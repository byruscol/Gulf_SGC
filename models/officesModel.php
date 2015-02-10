<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class offices extends DBManagerModel{
   
    public function getList($params = array()){
        $entity = $this->entity();
        $start = $params["limit"] * $params["page"] - $params["limit"];
        $query = "SELECT  `officeId`, `office`
                  FROM ".$entity["tableName"]."
                  ";
        
        if(array_key_exists('where', $params))
            $query .= " AND (". $this->buildWhere($params["where"]) .")";
        //echo $query;
        return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"]);
    }

    public function add(){
        $this->addRecord($this->entity(), $_POST/*, array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID)*/);
    }
    public function edit(){
        $this->updateRecord($this->entity(), $_POST, array("officeId" => $_POST["officeId"])/*, array("columnValidateEdit" => "assigned_user_id")*/);
    }
    public function del(){
        $this->delRecord($this->entity(), array("officeId" => $_POST["id"])/*, array("columnValidateEdit" => "assigned_user_id")*/);
    }

    public function detail($params = array()){
        $entity = $this->entity();
        $query = "SELECT n.`actionRequestId` , n.`name`, `date_entered`, `display_name` `assigned_user_id`
                        , `requestType` tiposolicitudsa, `status`, `office` `sedenc`, m.`management` `gestion`
                        ,tipoproblemasa, `accionesinmediatassa`
                    FROM ".$entity["tableName"]." n
                    LEFT JOIN ".$this->pluginPrefix."status s ON s.statusid = n.estadosa
                    LEFT JOIN ".$this->wpPrefix."users u ON u.ID = n.assigned_user_id
                    LEFT JOIN ".$this->pluginPrefix."actionRequestTypes a ON a.requestTypeId = n.tiposolicitudsa
                    LEFT JOIN ".$this->pluginPrefix."offices o ON o.officeId = n.sedesa
                    LEFT JOIN ".$this->pluginPrefix."managements m ON m.managementId = n.gestionsa
                    WHERE n.`actionRequestId` = " . $params["filter"];
        $this->queryType = "row";
        return $this->getDataGrid($query);
    }
    
    public function entity($CRUD = array())
    {
  
        $data = array(
                        "tableName" => $this->pluginPrefix."offices"
                        //,"columnValidateEdit" => "assigned_user_id"
                        ,"entityConfig" => $CRUD
                        ,"atributes" => array(
                            "officeId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true)
                            ,"office" => array("type" => "varchar","label" => "sedesa", "required" => true)
                        )
                    );
            return $data;
    }
}
?>
