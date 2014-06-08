<div class="row-fluid">
	<div class="span3">
		<div class="span9">
			<div class="jqGrid">
				<div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
			    	<div class="wrap">
			    		<div id="icon-tools" class="icon32"></div>
						<h2><?php echo $resource->getWord("nonConformity"); ?></h2>
					</div>
					<hr/>
					<table id="nonConformity"></table>
					<div id="nonConformityPager"></div>
				</div>
			</div>
		</div>
	</div>
	<hr/>
	<div id="tabs" class="span6">
		<ul id="nonConformityTab" class="nav nav-tabs">
		<li class="active"><a href="#notesTab" data-toggle="tab"><?php echo $resource->getWord("notes"); ?></a></li>     
		<li><a href="#tasksTab" data-toggle="tab"><?php echo $resource->getWord("tasks"); ?></a></li>  
		<li><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>
		</ul>
		<div id="TabContent" class="tab-content">
			<div class="tab-pane fade active" id="notesTab">
                            <div class="span3">
                                <div class="span9">
                                    <div class="jqGrid">
                                        <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                                            <div class="wrap">
                                                <table id="notes"></table>
                                                <div id="notesPager"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
			</div>
			<div class="tab-pane fade active" id="tasksTab">
                            <div class="span3">
                                <div class="span9">
                                    <div class="jqGrid">
                                        <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                                            <div class="wrap">
                                                <table id="tasks"></table>
                                                <div id="tasksPager"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
			</div>
			<div class="tab-pane fade active" id="filesTab">
                            <div class="span3">
                                <div class="span9">
                                    <div class="jqGrid">
                                        <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                                            <div class="wrap">
                                                <table id="files"></table>
                                                <div id="filesPager"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
			</div>
		</div>
	</div> 
</div>
<div id="nonConformityDetail"></div>
<script>
    jQuery(function () {
      var tab = jQuery('#nonConformityTab li:eq(0) a').attr("href");
      jQuery(tab).css("opacity", 1);
   });
</script>