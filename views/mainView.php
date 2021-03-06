<?php 
require_once $pluginPath . "/helpers/resources.php";

if(empty($_GET["page"])){
    $viewDir = "basic";
    $viewName = "basic";
}else{
    $viewDir = $_GET["page"]."View";
    switch ($_GET["task"]){
        case "Details": $viewName = $_GET["page"]."DetailsView";break;
        default: $viewName = $_GET["page"]."View";break;
    }  
}

$viewFile = $pluginPath . "/views/" . $viewDir . "/" . $viewName . ".php";
$resource = new resources();

if(!file_exists($viewFile)){
	$viewFile = $pluginPath. "/views/basicView/basicView.php";
}

function PQRCustomerService(){
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function nonConformity() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function request() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function tasks() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function actionRequest() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function loadCodes() {
    global $pluginPath;
    global $pluginURL;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function adminSGC() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}

function documents() {
    global $pluginPath;
    global $viewFile;
    global $resource;
    require_once($viewFile);
}
?>