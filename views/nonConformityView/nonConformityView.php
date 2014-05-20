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
	<div class="span6">
		<ul id="nonConformityTab" class="nav nav-tabs">
		<li ><a href="#notesTab" data-toggle="tab"><?php echo $resource->getWord("notes"); ?></a></li>     
		<li class="active"><a href="#tasksTab" data-toggle="tab"><?php echo $resource->getWord("tasks"); ?></a></li>  
		<li><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>
		</ul>
		<div id="TabContent" class="tab-content">
			<div class="tab-pane fade " id="notesTab">
				<div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
			    	<table id="notes"></table>
					<div id="notesPager"></div>
				</div>
			</div>
			<div class="tab-pane fade in active" id="tasksTab">
				<div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
			    	<table id="tasks"></table>
					<div id="tasksPager"></div>
				</div>
			</div>
			<div class="tab-pane fade" id="filesTab">
				<div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
			    	<table id="files"></table>
					<div id="filesPager"></div>
				</div>
			</div>
		</div>
	</div> 
</div>

<script>
jQuery(function () {
      jQuery('#nonConformityTab li:eq(0) a').tab('show');
   });
</script>