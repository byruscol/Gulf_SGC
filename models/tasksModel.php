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
        if(array_key_exists('where', $params)){
            if (is_array( $params["where"]->rules )){
                $countRules = count($params["where"]->rules);
                for($i = 0; $i < $countRules; $i++){
                    if($params["where"]->rules[$i]->field == "created_by")
                        $params["where"]->rules[$i]->field = "display_name";
                }
            }
            
           $query .= " AND (". $this->buildWhere($params["where"]) .")";
        }
        
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
        $entityObj = $this->entity();
        $relEntity = $entityObj["relationship"][$_POST["parentRelationShip"]];
        
        $this->addRecord($entityObj, $_POST, array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID));
        $this->addRecord($relEntity, array($relEntity["parent"]["Id"] => $_POST["parentId"],"taskId" => $this->LastId), array());
    }
    public function edit(){
        $this->updateRecord($this->entity(), $_POST, array("taskId" => $_POST["taskId"]), array("columnValidateEdit" => "assigned_user_id"));
    }
    public function del(){
        $this->delRecord($this->entity(), array("taskId" => $_POST["id"]), array("columnValidateEdit" => "assigned_user_id"));
    }

    public function detail(){}
    
    public function entity()
    {
        $data = array(
                        "tableName" => $this->pluginPrefix."tasks"
                        ,"columnValidateEdit" => "assigned_user_id"
                        ,"entityConfig" => array("add" => true, "edit" => true, "del" => true, "view" => true)
                        ,"atributes" => array(
                            "taskId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true )
                            ,"name" => array("type" => "varchar", "required" => true)
                            ,"status" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."status", "id" => "statusId", "text" => "status"))
                            ,"priority" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."priorities", "id" => "priorityId", "text" => "priority"))
                            ,"date_entered" => array("type" => "datetime", "required" => false, "readOnly" => true )
                            ,"created_by" => array("type" => "varchar", "required" => false, "readOnly" => true, "update" => false)
                            ,"assigned_user_id" => array("type" => "int", "required" => true, "references" => array("table" => $this->wpPrefix."users", "id" => "ID", "text" => "display_name"))
                            ,"date_start" => array("type" => "datetime", "required" => true)
                            ,"date_due" => array("type" => "datetime", "required" => true)
                            ,"description" => array("type" => "varchar", "required" => true, "text" => true, "hidden" => true)
                            ,"parentId" => array("type" => "int","required" => false, "hidden" => true, "isTableCol" => false)
                            ,"parentRelationShip" => array("type" => "varchar","required" => false, "hidden" => true, "isTableCol" => false)
                        )
                        ,"relationship" => array(
                            "nonConformity" => array(
                                    "tableName" => $this->pluginPrefix."nonConformities_tasks"
                                    ,"parent" => array("tableName" => $this->pluginPrefix."nonConformities", "Id" => "nonConformityId")
                                    ,"atributes" => array(
                                        "nonConformityId" => array("type" => "int", "PK" => 0)
                                        ,"taskId" => array("type" => "int", "PK" => 0)
                                    )
                                )
                            ,"request" => array(
                                    "tableName" => $this->pluginPrefix."nonConformities_tasks"
                                    ,"parent" => array("tableName" => $this->pluginPrefix."nonConformities", "Id" => "nonConformityId")
                                    ,"atributes" => array(
                                        "nonConformityId" => array("type" => "int", "PK" => 0)
                                        ,"taskId" => array("type" => "int", "PK" => 0)
                                    )
                                )
                        )
                );
        return $data;
    }
}
?>
