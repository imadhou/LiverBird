<?php

define('DS',DIRECTORY_SEPARATOR);
define('ROOTE',dirname(__FILE__));
define('PROOT','/eredlearning.atwebpages.com/');

require_once (ROOTE.DS.'config'.DS.'config.php');

//importer les classes necessaires selon le parametre $classename
function autoload($classename){
if (file_exists(ROOTE.DS.'core'.DS.$classename.'.php')){
    require_once(ROOTE.DS.'core'.DS.$classename.'.php');
}
if (file_exists(ROOTE.DS.'app'.DS.'controllers'.DS.$classename.'.php')){
    require_once(ROOTE.DS.'app'.DS.'controllers'.DS.$classename.'.php');
}
if (file_exists(ROOTE.DS.'app'.DS.'models'.DS.$classename.'.php')){
    require_once(ROOTE.DS.'app'.DS.'models'.DS.$classename.'.php');
}
if (file_exists(ROOTE.DS.'app'.DS.'views'.DS.$classename.'.php')){
    require_once(ROOTE.DS.'app'.DS.'views'.DS.$classename.'.php');
}
}
              
//appeller automatiquement lafonction autoload pour faire l'import
spl_autoload_register('autoload');
session_start();
if (!Sessions::exists(SESSION_ETU) && Cookies::exists(COOKIE_ETU)){
    Etudiant::loginFromCookie();
}

if (!Sessions::exists(SESSION_ENS) && Cookies::exists(COOKIE_ENS)){
    Enseignant::loginFromCookie();
}

if (isset($_SERVER['REQUEST_URI'])){
    $url = explode('/',ltrim($_SERVER['REQUEST_URI'],'/'));
}else $url = [];
Router::Route($url);



