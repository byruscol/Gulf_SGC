<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Grid.php";
require_once "../../class.buildView.php";
header('Content-type: text/javascript');
$postData = array("method" => "getNonConformitiesTasks");
if((isset($_GET["view"]) && !empty($_GET["view"])) && 
    (isset($_GET["rowid"]) && !empty($_GET["rowid"])))
{
    $postData["parent"] = $_GET["view"];
    $postData["filter"] = $_GET["rowid"];
}
$params = array("numRows" => 10, "sortname" => "date_entered", "postData" => $postData);
$view = new buildView("tasks", $params, "tasks");
?>
