<div class="row-fluid">
       
    <div class="span12"></div>
    <div id="tabs" class="span11">
        <ul id="tasksTab" class="nav nav-tabs">
        <!--<li class="active"><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>      -->
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
                                <table id="documents"></table>
                                <div id="documentsPager"></div>
                            </div>
                        </div>
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