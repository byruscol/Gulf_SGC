<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
/*
Plugin Name: Gulf_SGC
Plugin URI: http://localhost
Description: Plugin para hacer pruebas
Version: 1.0
Author: Yohan Valderrama - Byron Otalvaro
Author URI: http://localhost
License: GPL2
*/
if(!function_exists('wp_get_current_user'))
    require_once(ABSPATH . "wp-includes/pluggable.php"); 
wp_cookie_constants();
$current_user = wp_get_current_user();

require_once "pluginConfig.php";
require_once "views/mainView.php";
require_once 'controllers/mainController.php';

if(!empty($_POST["id"])){
    $controlerId = $_POST["id"];
}elseif(!empty($_GET["controller"])){
    $controlerId = $_GET["controller"];
}elseif(!empty($_REQUEST["page"])){
    $controlerId = $_REQUEST["page"];
}

if(is_plugin_active($pluginName."/".$pluginName.".php"))
    if(!isset($controller))
        $controller = new mainController($controlerId);

function js_includer_opciones() {
       include("config.php");
}
?>
