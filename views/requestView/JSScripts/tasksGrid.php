<?php
require_once "../../commonNotesGrid.php";
$params["postData"]["method"] = "getNonConformitiesTasks";
$params["sortname"] = "date_entered";
$view = new buildView("tasks", $params, "tasks");
?>
