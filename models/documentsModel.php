<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class documents extends DBManagerModel{
	
    public function getList($params = array()){
        $entity = $this->entity();
        if(!array_key_exists('filter', $params))
                $params["filter"] = 0;

        $start = $params["limit"] * $params["page"] - $params["limit"];
        $query = "SELECT  n.`systemDocumentId`,
			n.`document_name`,
			n.documentTypeId,
			n.`description`,
			n.`version`,
			n.`date_entered`,
			f.ext soporte, f.fileId, '' file, n.created_by
                    FROM  `".$entity["tableName"]."` n
                    JOIN ".$this->wpPrefix."users u ON u.ID = n.created_by
		    LEFT JOIN ".$this->pluginPrefix."systemDocuments_files fi on fi.systemDocumentId = n.`systemDocumentId`
		    LEFT JOIN ".$this->pluginPrefix."files f ON f.fileId = fi.fileId
                    WHERE  n.`deleted` = 0 ";
        if(array_key_exists('where', $params)){
            if (is_array( $params["where"]->rules )){
                $countRules = count($params["where"]->rules);
                for($i = 0; $i < $countRules; $i++){
                    if($params["where"]->rules[$i]->field == "created_by")
                        $params["where"]->rules[$i]->field = "display_name";
                    if($params["where"]->rules[$i]->field == "ExpiredStatus")
                        $params["where"]->rules[$i]->field = "Expired";
                }
            }
            
           $query .= " AND (". $this->buildWhere($params["where"]) .")";
        }
       // echo $query;
        return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"] );
    }

    /*public function add(){
        $entityObj = $this->entity();
        $relEntity = $entityObj["relationship"][$_POST["parentRelationShip"]];
        $taskType = $entityObj["relationship"][$_POST["taskType"]];
        
        $this->addRecord($entityObj, $_POST, array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID, "taskTypeId" => $taskType));
        $this->sendAssignedMail($this->DBOper["data"]["assigned_user_id"], $this->LastId, "task");
        $this->addRecord($relEntity, array($relEntity["parent"]["Id"] => $_POST["parentId"],"taskId" => $this->LastId), array());
        
    }*/
    
    public function add(){
	//print_r($_POST);
        //$_POST["integranteId"] = $_POST["parentId"];
	$this->addRecord($this->entity(), $_POST, array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID));
	echo json_encode(array("parentId" => $this->LastId));
    }
    
    public function edit(){
        $this->updateRecord($this->entity(), $_POST, array("taskId" => $_POST["taskId"]), array("columnValidateEdit" => "assigned_user_id"));
        if(array_key_exists("assigned_user_id", $this->DBOper["data"])){
            $this->sendAssignedMail($this->DBOper["data"]["assigned_user_id"], $_POST["taskId"], "task");
        }
    }
    public function del(){
        $this->delRecord($this->entity(), array("systemDocumentId" => $_POST["id"]), array("columnValidateEdit" => "created_by"));
    }
    public function detail($params = array()){
        $entity = $this->entity();
        $query = "SELECT n.`taskId`, `taskType`, `name`, s.`status`, p.priority `priority`, `date_entered`, u.`display_name` AS `created_by`
                                         , u.`display_name` as `assigned_user_id`, `date_start`,  `date_due`, `Expired` ExpiredStatus, `description` 
                  FROM  `".$entity["tableName"]."` n
                  JOIN ".$this->wpPrefix."users u ON u.ID = n.created_by
                  JOIN ".$this->pluginPrefix."taskTypes t ON t.taskTypeId = n.taskTypeId
                  LEFT JOIN ".$this->pluginPrefix."status s ON s.statusid = n.status
                  LEFT JOIN ".$this->pluginPrefix."priorities p ON p.priorityId = n.priority
                  LEFT JOIN ".$this->wpPrefix."users ua ON ua.ID = n.assigned_user_id
                  LEFT JOIN timetasksstatus tts On tts.taskId = n.taskId
                  WHERE n.taskId = " . $params["filter"];
        $this->queryType = "row";
        return $this->getDataGrid($query);
    }    
    public function entity($CRUD = array())
    {
        $data = array(
                        "tableName" => $this->pluginPrefix."systemDocuments"
                        ,"columnValidateEdit" => "created_by"
                        ,"entityConfig" => $CRUD
                        ,"atributes" => array(
                            "systemDocumentId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true )
                            ,"document_name" => array("type" => "varchar", "required" => true)
			    ,"documentTypeId" => array("type" => "tinyint", "required" => true, "references" => array("table" => $this->pluginPrefix."systemDocumentTypes", "id" => "documentTypeId", "text" => "documentType"))
			    ,"description" => array("type" => "varchar", "required" => true, "text" => true, "hidden" => true)
                            ,"version" => array("type" => "varchar", "required" => true)
			    ,"date_entered" => array("type" => "datetime", "required" => false, "readOnly" => true )                            
                            ,"parentId" => array("type" => "int","required" => false, "hidden" => true, "isTableCol" => false)
			    ,"soporte" => array("type" => "varchar", "required" => false, "readOnly" => true, "hidden" => false, "isTableCol" => false, "downloadFile" => array("show" => true, "cellIcon" => 6, "rowObjectId" => 6, "view" => "files"))
			    ,"file" => array("type" => "file", "validateAttr" => array("size" => 200, "units" => "MB", "factor" => 1024), "required" => false,"hidden" => true, "edithidden" => true, "isTableCol" => false)
			    ,"fileId" => array("type" => "int", "hidden" => true, "required" => false, "readOnly" => true, "hidden" => true, "isTableCol" => false)
                            
                        )
                );
        return $data;
    }
}
?>
