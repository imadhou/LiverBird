<?php


class Router
{
    public static function Route($url){
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER;
        $controller_name = str_replace('Controller','',$controller);
        array_shift($url);

        $action = (isset($url[0]) && $url[0] != '')? $url[0].'Action': 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != '')? $url[0] : 'index';
        array_shift($url);

        if(!class_exists($controller)){
            header('HTTP/1.0 404 Not Found');
            self::redirect('/notfound');
        }

        $access = self::hasAccess($controller_name,$action_name);
        if (!$access){
            header('HTTP/1.0 403 Restricted');
            self::redirect('/restricted');
        }
        $params = $url;
        $dispatch = new $controller($controller_name,$action);
        //var_dump($dispatch);
        if (method_exists($controller,$action)){
            call_user_func_array([$dispatch,$action],$params);
        }else{
            die('la page '.strtolower($controller_name).'/'.$action_name.' n\'existe pas!!');
        }
    }

    public static function redirect($location){
        if (!headers_sent()){
            header('Location: '.$location);

            exit();
        }else{
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
            echo '</noscript>';exit;
        }
    }

    public static function hasAccess($controller_name ,$action_name){
        $acl_file = file_get_contents(ROOTE . DS . 'app' . DS .'jsonfiles'.DS. 'acl.json');
        $acl = json_decode($acl_file,true);
        $current_user_acls = ["Guest"];
        $grantAccess = false;

        if (Sessions::exists(SESSION_ETU) || Cookies::exists(COOKIE_ETU)) {
            $current_user_acls[] = "Etudiant";
        }
        if (Sessions::exists(SESSION_ENS) || Cookies::exists(COOKIE_ENS)) {
            $current_user_acls[] = "Enseignant";
        }

        if (Sessions::exists('admin')){
            $current_user_acls[] = "Administrateur";
        }

        foreach ($current_user_acls as $level){
            if (array_key_exists($level,$acl) && array_key_exists($controller_name,$acl[$level])){
                if (in_array($action_name,$acl[$level][$controller_name])|| in_array("*",$acl[$level][$controller_name])){
                    $grantAccess = true;
                    break;
                }
            }
        }


        foreach ($current_user_acls as $level){
            $denied = $acl[$level]['denied'];
            if (!empty($denied) && array_key_exists($controller_name,$denied) && in_array($action_name,$denied[$controller_name])){
                $grantAccess = false;
                break;
            }
        }
        return $grantAccess;
    }

    public static function currentPage(){
        $currentPage = $_SERVER['REQUEST_URI'];
        if($currentPage == PROOT || $currentPage == PROOT.'home/index'){
            $currentPage =PROOT. 'HomeController';
        }
        return $currentPage;
    }

    private static function get_link($val){
        if (preg_match('/https?:\/\//',$val) == 1){
            return $val;
        }else{
            $uAry = explode(DS,$val);
            $controller_name = ucwords($uAry[0]);
            $action_name = (isset($uAry[1]))? $uAry[1] : '';
            if (self::hasAccess($controller_name,$action_name)){
                return '/'.$val;
            }
            return false;
        }
    }

    public static function getMenu($menu){
        $menuArray = [];
        $menuFile = file_get_contents(ROOTE . DS . 'app' . DS .'jsonfiles'.DS. $menu .'.json');
        $acl = json_decode($menuFile,true);
        foreach ($acl as $key=>$value){
            if (is_array($value)) {
                $sub = [];
                foreach ($value as $k => $v) {
                    if ($k == 'separator' && !empty($sub)) {
                        $sub[$k] = '';
                        continue;
                    } else if ($finalVal = self::get_link($v)) {
                        $sub[$k] = $finalVal;
                    }
                }
                if (!empty($sub)) {
                    $menuArray[$key] = $sub;
                }
            }
            else{
                if ($finalVal = self::get_link($value)){
                    $menuArray[$key] = $finalVal;
                }
            }
        }

        return $menuArray;
    }



}