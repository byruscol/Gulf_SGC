<?php 
require_once $pluginPath . "/helpers/resources.php";
$viewName = (empty($_GET["page"]))? "basic": $_GET["page"]."View";
$viewFile = $pluginPath . "/views/" . $viewName . "/" . $viewName . ".php";
$resource = new resources();

if(!file_exists($viewFile)){
	$viewFile = $pluginPath. "/views/basicView/basicView.php";
}

function nonConformity() {
	global $viewFile;
	global $resource;
	require_once($viewFile);
}
?>