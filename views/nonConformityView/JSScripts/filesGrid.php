<?php
require_once "../../commonNotesGrid.php";
$params["postData"]["method"] = "getNonConformitiesFiles";
$params["sortname"] = "date_entered";
$view = new buildView("files", $params, "files");
?>
