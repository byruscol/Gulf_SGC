<div class="row-fluid">
    <!--
    <div class="span11">
        <div class="jqGrid">
            <div class="wrap">
                <div id="icon-tools" class="icon32"></div>
                <h2><?php echo $resource->getWord("adminSGC"); ?></h2>
            </div>
            <div class="span12">
            <table id="adminSGC"></table>
            <div id="adminSGCPager"></div>
            </div>
        </div>
    </div>
    -->
    
    <div class="span12">
        <div class="wrap">
            <div id="icon-tools" class="icon32"></div>
            <h2><?php echo $resource->getWord("adminSGC"); ?></h2>
        </div>        
    </div>
    <div id="tabs" class="span11">
        <ul id="adminSGCTab" class="nav nav-tabs">
            <li class="active"><a href="#statusTab" data-toggle="tab"><?php echo $resource->getWord("estadosQ"); ?></a></li>     
            <li><a href="#sourcesTab" data-toggle="tab"><?php echo $resource->getWord("fuentencs"); ?></a></li>  
            <li><a href="#generalitiesTab" data-toggle="tab"><?php echo $resource->getWord("generalidadnc"); ?></a></li>
            <li><a href="#officesTab" data-toggle="tab"><?php echo $resource->getWord("sedes"); ?></a></li>
            <li><a href="#managementsTab" data-toggle="tab"><?php echo $resource->getWord("gestiones"); ?></a></li>
            <li><a href="#classificationsTab" data-toggle="tab"><?php echo $resource->getWord("clasificacion_nc_c"); ?></a></li>
            <li><a href="#customerTypesTab" data-toggle="tab"><?php echo $resource->getWord("tipo_cliente_c"); ?></a></li>
            <li><a href="#actionRequestTypesTab" data-toggle="tab"><?php echo $resource->getWord("tiposolicitudsa"); ?></a></li>
        </ul>
        <div id="TabContent" class="tab-content">
            <div class="tab-pane fade active" id="statusTab">
                <div class="spacer10"></div>
                <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                    <table id="adminSGC"></table>
                    <div id="adminSGCPager"></div>
                </div>
            </div>
            <div class="tab-pane fade active" id="sourcesTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="sources"></table>
                        <div id="sourcesPager"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade active" id="generalitiesTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="generalities"></table>
                        <div id="generalitiesPager"></div>
                    </div>                      
                </div>
            </div>
            <div class="tab-pane fade active" id="officesTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="offices"></table>
                        <div id="officesPager"></div>
                    </div>                      
                </div>
            </div>
            <div class="tab-pane fade active" id="managementsTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="managements"></table>
                        <div id="managementsPager"></div>
                    </div>                      
                </div>
            </div>
            <div class="tab-pane fade active" id="classificationsTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="classifications"></table>
                        <div id="classificationsPager"></div>
                    </div>                      
                </div>
            </div>
            <div class="tab-pane fade active" id="customerTypesTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="customerTypes"></table>
                        <div id="customerTypesPager"></div>
                    </div>                      
                </div>
            </div>
            <div class="tab-pane fade active" id="actionRequestTypesTab">
                <div class="spacer10"></div>
                <div class="jqGrid">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="actionRequestTypes"></table>
                        <div id="actionRequestTypesPager"></div>
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
      var tab = jQuery('#adminSGCTab li:eq(0) a').attr("href");
      jQuery(tab).css("opacity", 1);
   });
</script>