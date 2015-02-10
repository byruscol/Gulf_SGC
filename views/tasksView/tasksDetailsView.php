<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once $pluginPath . "/helpers/Details.php";
$details = new Details($viewFile);
?>
<br/>
<div class="row-fluid">
    <div class="span11">
        <div class="jqGrid">
            <div class="wrap">
                <div id="icon-tools" class="icon32"></div>
                <h2><?php echo $resource->getWord("tasks"); ?></h2>
            </div>
            <div class="span12">
                <?php $details->renderDetail();?>
            </div>
        </div>
    </div>
    
    <div class="span12"></div>
        <div id="tabs" class="span11">
            <ul id="tasksTab" class="nav nav-tabs">
            <li class="active"><a href="#notesTab" data-toggle="tab"><?php echo $resource->getWord("notes"); ?></a></li>     
            <li><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>
            </ul>
            <div id="TabContent" class="tab-content">
                <div class="tab-pane fade active" id="notesTab">
                    <div class="spacer10"></div>
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="notes"></table>
                        <div id="notesPager"></div>
                    </div>
                </div>
                <div class="tab-pane fade active" id="filesTab">
                    <div class="spacer10"></div>
                    <div class="span12">
                        <div class="span8">
                            <div class="jqGrid">
                                <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                                    <table id="files"></table>
                                    <div id="filesPager"></div>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <form id="uploadFiles" class="form-horizontal" enctype="multipart/form-data" method="post">
                                <fieldset>

                                <!-- Form Name -->
                                <legend><?php echo $resource->getWord("uploadFile"); ?></legend>

                                <!-- Text input-->
                                <div class="control-group">
                                  <div class="controls">
                                    <input id="name" name="name" placeholder="<?php echo $resource->getWord("fileName"); ?>" class="input-xlarge" required="true" type="text">
                                    <input type="hidden" name="oper" value="add"/>
                                    <input type="hidden" name="parentRelationShip" value="tasks"/>
                                    <input type="hidden" name="parentId" id="parentId" value="<?php echo $_GET["rowid"];?>"/>
                                  </div>
                                </div>
                                <br/>
                                <!-- Text input-->
                                <div class="control-group">
                                  <div class="controls">
                                      <input type="file" id="file" name="file" class="btn btn-default" required="true">
                                    </div>
                                  </div>
                                  <br/>
                                <!-- Button -->
                                <div class="control-group">
                                  <div class="controls">
                                    <button id="submit" name="submit" class="btn btn-primary"><?php echo $resource->getWord("accept"); ?></button>
                                  </div>
                                </div>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div id="loading"><p><?php echo $resource->getWord("LoadingFile"); ?></p></div>
 
<script>
    jQuery(function () {
        
        jQuery("#loading").dialog({
            closeOnEscape: false,
            autoOpen: false,
            modal: true,
            width: 200,
            height: 100/*,
            open: function(event, ui) { jQuery(".ui-dialog-titlebar-close").hide(); jQuery(".ui-dialog-titlebar").hide();}*/
         });
      var tab = jQuery('#tasksTab li:eq(0) a').attr("href");
      jQuery(tab).css("opacity", 1);
   });
</script>