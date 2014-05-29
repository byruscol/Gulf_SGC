<?php
require_once "DBManager.php"; 
if(!isset($resource)){
	require_once "resources.php";
	$resource = new resources();
}
class Grid extends DBManager
{	
	private $table;
	private $ColMolde;
	private $colnames = array();
	private $baseId;
	private $entity;
	private $params;
	private $loc;
        private $beforeShowForm = "";
	public $view;
	
	function __construct($type = "table", $p, $v, $t) {
		global $resource;
		$this->view = $v;
		$this->params = $p;
		$this->loc = $resource;
		parent::__construct();
		if($type == "table"){
			require_once $this->pluginPath."/models/".$v."Model.php";
			$this->baseId = $t;
			$this->table = $this->pluginPrefix.$t;
			$this->entity = $v::entity();
			$this->gridBuilderFromTable();
		}
	}
	
	function __destruct() {
	}
	
	function RelationShipData($references){
	
		$DataArray = array();
		
		$query = "SELECT " . $references["id"] . " Id, " . $references["text"] . " Name FROM ". $references["table"];
		$Relation = $this->getDataGrid($query, null, null, $references["text"], "ASC");

		foreach ( $Relation["data"] as $k => $v ){
			$DataArray[] = "{".$Relation["data"][$k]->Id.":".htmlspecialchars($Relation["data"][$k]->Name)."}";
		}

		$replaceBlank = array('"','{','}','[');
		$replaceSemicolon = array(',',']');
		
		$DataArray = str_ireplace($replaceBlank,'',json_encode($DataArray, JSON_UNESCAPED_UNICODE));
		$DataArray = str_ireplace($replaceSemicolon,';',$DataArray);
	
		return $DataArray;
	}
	
    function colModelFromTable(){
    	$countCols = count($this->entity["atributes"]);
    	$j=1;
    	$k=1;
    	$numCols = 2;
    	
    	foreach ($this->entity["atributes"] as $col => $value){
    		$this->colnames[] = $col;
    		
    		$hidden = (isset($value['hidden']) && $value['hidden'] == true)? true: false;
    		
    		$required = ($value['required'])? true: false;
    		
    		if($j <= $numCols){
    			$option = array('rowpos' => $k, 'colpos' => $j);
    		}
    		else{
    			$k++;
    			$j=1;
    			$option = array('rowpos' => $k, 'colpos' => $j);
    		}
    		
    		$model = array(
    				'label' => $this->loc->getWord($col),
                                'name'=> $col,
    				'index'=> $col,
    				'align' => 'center',
    				'sortable' => true,
    				'editable' => true,
    				'editrules' => array('required' => $required),
    				'formoptions' => $option,
    				'hidden' => $hidden,
    				'classes'=> 'ellipsis'
                                
    		);
    		
    		if(array_key_exists('references', $value))
    			$colType = "Referenced";
    		else
    			$colType = $value["type"];
    		
    		switch($colType){
    			case 'date':
    				$model = array_merge($model
                                                    ,array(
                                                        'sorttype' => "date",
				    			'formatter' => "date",
				    			'formatoptions' => array('newformat' => 'Y-m-d', 'srcformat' => 'Y-m-d'),
				    			'editoptions' => array('dataInit'=>"@initDateEdit@")
                                                        )
                                                    );
    				break;
    			case 'datetime':
    					$model = array_merge($model
                                                            ,array(
                                                                'sorttype' => "date",
                                                                'formatter' => "date",
                                                                'formatoptions' => array('newformat' => 'Y-m-d H:i:s', 'srcformat' => 'Y-m-d H:i:s'),
                                                                'editoptions' => array('dataInit'=>"@initDateEdit@")
                                                                )
                                                            );
    					break;
    			case 'enum':
    				/*$enumList = explode(",", str_replace("'", "", substr($cols["data"][$i]->Type, 5, (strlen($cols["data"][$i]->Type)-6))));
    				$values = array();
    				$values[""] = "--Seleccione--";
    				foreach($enumList as $value){
    					$values[htmlspecialchars($value)] = htmlspecialchars($value);
    				}
    					
    				$model = array_merge($model
    						,array(
    								'edittype' => 'select',
    								'formatter' => 'select',
    								'stype' => 'select',
    								'editoptions' => array( 'value' => $values ),
    								'searchoptions' => array('value' => $values)
    						)
    				);*/
    				break;
    			case "Referenced":
    				$QueryData = $this->RelationShipData($value["references"]);
    					
    				$model = array_merge($model
    						,array(
                                                    'edittype' => 'select',
                                                    'formatter' => 'select',
                                                    'stype' => 'select',
                                                    'editoptions' => array( value => "@'".$QueryData.":'@" ),
                                                    'searchoptions' => array('value' => "@'".$QueryData.":'@")
    						)
                                            );
    				break;
    			case 'longblob':
    		
    				break;
    		}
                
                switch($col){
                    case "parentId": $model["editoptions"]["defaultValue"] = "@function(g){return this.p.postData.filter}@"; break;
                    case "parentRelationShip": $model["editoptions"]["defaultValue"] = "@function(g){return this.p.postData.parent}@"; break;
                }
                
                if($value['text']){
    			$model["edittype"] = "textarea";
    			$model["editoptions"]["rows"] = 6; 
    			$model["editoptions"]["cols"] = 50;
    			
    			if($j == $numCols){
                            $k++;
                            $option = array('rowpos' => $k, 'colpos' => 1);
                            $model["formoptions"] = $option;
    			}
    			$k++;
    			$j=1;
                        
                        $this->beforeShowForm .= "setTextAreaForm(form,'tr_".$col."');";
    		}

    		if($value['readOnly'])
    			$model["editoptions"]["dataInit"] = "@function(element) { jQuery(element).attr('readonly', 'readonly');}@";
    		
    		$j++;
    		$colmodel[] = $model;
    		$model = array();
    	}
        
    	$this->ColModel = str_ireplace('"@',"",json_encode($colmodel));
    	$this->ColModel = str_ireplace('@"',"",$this->ColModel);
    }
	
    function gridBuilderFromTable() {
    	$this->colModelFromTable();
    	$title = $this->table;
    	
    	if(array_key_exists('postData', $this->params)){
    		if(is_array($this->params['postData']))
    		{	
    			$pd = array();
    			foreach ( $this->params['postData'] as $k => $v ){
    				$pd[] = '"'. $k .'":"'. $v .'"';
	    		}
	    		$postData = ",". implode(",", $pd);
    		}
    		else 
    			$postData = "";
    	}
    	else
    		$postData = "";
    	
            $grid = 'jQuery(document).ready(function(){
                        $grid = jQuery("#' . $this->view . '"),
                                        initDateEdit = function (elem) {						
                                                jQuery(elem).datepicker({
                                                        dateFormat: "dd-M-yy",
                                                        autoSize: true,
                                                        changeYear: true,
                                                        changeMonth: true,
                                                        showButtonPanel: true,
                                                        showWeek: true
                                                });
                                        },
                                        numberTemplate = {formatter: "number", align: "right", sorttype: "number",
                                        editrules: {number: true, required: true},
                                        searchoptions: { sopt: ["eq", "ne", "lt", "le", "gt", "ge", "nu", "nn", "in", "ni"] }
                                };
                        $grid.jqGrid({						
                                        url:"admin-ajax.php",
                                        datatype: "json",
                                        mtype: "POST",
                                        postData : {
                                                action: "action",
                                                id: "' . $this->view . '"
                                                '. $postData.'
                                        },
                                        //colNames:'.json_encode($this->colnames).',					
                                        colModel:'.$this->ColModel.',
                                        rowNum:'. $this->params["numRows"].',
                                        rowList: ['. $this->params["numRows"] .', '. ($this->params["numRows"] * 2) .', '. ($this->params["numRows"] * 3) .'],
                                        pager: "#' . $this->view . 'Pager",						
                                        sortname: "'. $this->params["sortname"].'",
                                        viewrecords: true,
                                        sortorder: "desc",
                                        viewrecords: true,
                                        gridview: true,
                                        height: "100%",
                                        autowidth: true,
                                        editurl: "'.$this->pluginURL.'edit.php?controller='.$this->view.'",
                                        caption:"' . $this->loc->getWord($this->view) . '",
                                        beforeRequest: function() {
                                            responsive_jqgrid(jQuery(".jqGrid"));
                                        }';

                                if(array_key_exists('actions', $this->params))
                                {
                                        foreach ($this->params['actions'] as $key => $value){
                                                $grid .= ',' . $value["type"] .': '. $value["function"];
                                        }
                                }						    

                                $grid .= '});
                                jQuery("#' . $this->view . '").jqGrid("navGrid","#' . $this->view . 'Pager",
                                                {edit:true,add:true,del:true},{width: "99%"';
                                if(!empty($this->beforeShowForm)){
                                    $grid .=     ',beforeShowForm:function(form){'.$this->beforeShowForm.'}';
                                }
                                
                                $grid .=', closeAfterEdit: true, closeAfterAdd: true});';

            $grid .= '})';

            echo  $grid;
	}
}
?>