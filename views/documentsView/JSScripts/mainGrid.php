<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Grid.php";
require_once "../../class.buildView.php";
header('Content-type: text/javascript');
$params = array("numRows" => 10 , "sortname" => "date_entered");
$params["CRUD"] = array("add" => true, "edit" => true, "del" => true, "view" => false, "files" => true,"excel"=>true);
$params["fileActions"] = array(
                                array(
                                    "idFile" => "file",
                                    "url" => $pluginURL."edit.php?controller=files",
                                    "parentRelationShip" => "documents",
                                    "oper" => "add"
                                )
                            );
$view = new buildView($_GET["view"], $params, "files");

?>
