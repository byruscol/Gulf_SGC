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
require_once "pluginConfig.php";
require_once "views/mainView.php";
require_once 'controllers/mainController.php';

$controlerId = (!empty($_POST["id"]))?$_POST["id"]:$_REQUEST["page"];

$controller = new mainController($controlerId);

function js_includer_opciones() {
       include("config.php");
}
?>