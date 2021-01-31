<?php


class Sessions
{
    public static function set($name, $value){
        $_SESSION[$name] = $value;
    }
    public static function get($name){
        return $_SESSION[$name];
    }
    public static function delete($name){
        unset($_SESSION[$name]);
    }
    public static function exists($name){
        return isset($_SESSION[$name]);
    }
    public static function user_agent(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $regx = '/\/[a-zA-Z0-p.]+/';
        $new = preg_replace($regx,'',$agent);
        return $new;
    }
}
