<?php


class Cookies
{
    public static function set($name, $value, $expiry){
        if(setcookie($name,$value,$expiry,'/')){
            return true;
        }
        return false;
    }
    public static function delete($name){
        unset($_COOKIE[$name]);
        setcookie($name,'',-1,'/');
    }
    public static function get($name){
        return($_COOKIE[$name]);
    }
    public static function exists($name){
        return isset($_COOKIE[$name]);
    }

}