<div class="row-fluid">
     <div class="span11">
        <div class="jqGrid">
            <div class="wrap">
                <div id="icon-tools" class="icon32"></div>
                <h2><?php echo $resource->getWord("files"); ?></h2>
            </div>
            <div class="span12">
            <table id="documents"></table>
            <div id="documentsPager"></div>
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