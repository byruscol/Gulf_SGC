<?php
require_once "../../commonNotesGrid.php";
$params["postData"]["method"] = "getTasksNotes";
$params["sortname"] = "date_entered";
$params["CRUD"] = array("add" => true, "edit" => true, "del" => true, "view" => true, "excel" => true);
$view = new buildView("notes", $params, "notes");
?>