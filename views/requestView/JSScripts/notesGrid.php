<?php
require_once "../../commonNotesGrid.php";
$params["postData"]["method"] = "getNonConformitiesNotes";
$params["sortname"] = "date_entered";
$view = new buildView("notes", $params, "notes");
?>