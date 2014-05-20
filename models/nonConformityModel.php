<?php
require_once('DBManagerModel.php');
class nonConformity extends DBManagerModel{
	
	public function getList($params = array()){
		
		$start = $params["limit"] * $params["page"] - $params["limit"];
		$query = "SELECT  `nonConformityId`, `name`, `description` 
							, `estadonc`, `nombre_del_clientenc`
							, `telefononc`, `fuentenc`, `generalidadnc`, `sedenc`
							, `gestion`, `clasificacion_nc`, created_by, `assigned_user_id`
				  FROM ".$this->pluginPrefix."nonConformities 
				  WHERE `deleted` = 0";
		return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"]);
	}
	
	public function set(){
	}
	public function edit(){
	}
	public function delete(){
		
	}
	
	public function entity()
	{
		$data = array(
						"nonConformityId" => array("type" => "int", "PK" => 0, "required" => false, readOnly => true )
						,"name" => array("type" => "varchar", "required" => true)
						,"description" => array("type" => "text", "required" => true, "text" => true)
						,"estadonc" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."status", "id" => "statusid", "text" => "status"))
						,"nombre_del_clientenc" => array("type" => "varchar", "required" => true)
						,"telefononc" => array("type" => "varchar", "required" => true)
						,"fuentenc" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."sources", "id" => "sourceId", "text" => "source"))
						,"generalidadnc" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."generalities", "id" => "generalityId", "text" => "generality"))
						,"sedenc" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."offices", "id" => "officeId", "text" => "office"))
						,"gestion" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."managements", "id" => "managementId", "text" => "management")
						,"clasificacion_nc" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."classifications", "id" => "classificationId", "text" => "classification"))
						,"created_by" => array("type" => "bigint", "hidden" => true, "required" => false)
						,"assigned_user_id" => array("type" => "char", "hidden" => true, "required" => false))
				);
		return $data;
	}
}
?>