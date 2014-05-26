<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class notes extends DBManagerModel{
	
    public function getList($params = array()){
        $entity = $this->entity();
        if(!array_key_exists('filter', $params))
                $params["filter"] = 0;

        $start = $params["limit"] * $params["page"] - $params["limit"];
        $query = "SELECT  `noteId`, `name`, `date_entered`, `display_name` AS created_by, `noteTypeId`,  `description` 
                          FROM  `".$entity["tableName"]."` n
                          JOIN ".$this->wpPrefix."users u ON u.ID = n.created_by
                          WHERE  `noteId` IN ( ". $params["filter"] ." )";

        return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"] );
    }

    public function getNonConformitiesNotes($params = array()){
            $query = "SELECT  `noteId`
                              FROM  `".$this->pluginPrefix."nonConformities_notes` n
                              WHERE  `nonConformityId` = " . $params["filter"];

            $responce = $this->getDataGrid($query);

            foreach ( $responce["data"] as $k => $v ){
                    $DataArray[] = $responce["data"][$k]->noteId;
            }

            $params["filter"] = implode(",", $DataArray);

            $data = $this->getList($params);
            return $data;
    }

    public function add(){
    }
    public function edit(){
    }
    public function del(){

    }

    public function entity()
    {
        $data = array(
                    "tableName" => $this->pluginPrefix."notes"
                    ,atributes => array(
                        "noteId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true )
                        ,"name" => array("type" => "varchar", "required" => true)
                        ,"date_entered" => array("type" => "datetime", "required" => false, "readOnly" => true )
                        ,"created_by" => array("type" => "varchar", "required" => false, "readOnly" => true)
                        ,"noteTypeId" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."noteTypes", "id" => "noteTypeId", "text" => "noteType"))
                        ,"description" => array("type" => "varchar", "required" => true, "text" => true)
                    )
                );
        return $data;
    }
}
?>