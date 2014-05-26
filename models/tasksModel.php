<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class tasks extends DBManagerModel{
	
    public function getList($params = array()){
        $entity = $this->entity();
        if(!array_key_exists('filter', $params))
                $params["filter"] = 0;

        $start = $params["limit"] * $params["page"] - $params["limit"];
        $query = "SELECT `taskId`, `name`, `status`, `priority`, `date_entered`, `display_name` AS `created_by`
                                         , `assigned_user_id`, `date_start`,  `date_due`, `description` 
                          FROM  `".$entity["tableName"]."` n
                          JOIN ".$this->wpPrefix."users u ON u.ID = n.created_by
                          WHERE  `deleted` = 0 AND `taskId` IN ( ". $params["filter"] ." )";

        return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"] );
    }

    public function getNonConformitiesTasks($params = array()){
        $query = "SELECT  `taskId`
                          FROM  `".$this->pluginPrefix."nonConformities_tasks`
                          WHERE  `nonConformityId` = " . $params["filter"];

        $responce = $this->getDataGrid($query);

        foreach ( $responce["data"] as $k => $v ){
                $DataArray[] = $responce["data"][$k]->taskId;
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
                        "tableName" => $this->pluginPrefix."tasks"
                        ,"atributes" => array(
                            "taskId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true )
                            ,"name" => array("type" => "varchar", "required" => true)
                            ,"status" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."status", "id" => "statusId", "text" => "status"))
                            ,"priority" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."priorities", "id" => "priorityId", "text" => "priority"))
                            ,"date_entered" => array("type" => "datetime", "required" => false, "readOnly" => true )
                            ,"created_by" => array("type" => "varchar", "required" => false, "readOnly" => true)
                            ,"assigned_user_id" => array("type" => "int", "required" => true, "references" => array("table" => $this->wpPrefix."users", "id" => "ID", "text" => "display_name"))
                            ,"date_start" => array("type" => "datetime", "required" => true)
                            ,"date_due" => array("type" => "datetime", "required" => true)
                            ,"description" => array("type" => "varchar", "required" => true, "text" => true)
                        )
                );
        return $data;
    }
}
?>