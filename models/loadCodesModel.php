<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
//require_once($pluginPath.'/helpers/resources.php');

class loadCodes extends DBManagerModel{
	
    public function getList($params = array()){
        $entity = $this->entity();
        if(!array_key_exists('filter', $params))
                $params["filter"] = 0;

        $query = "SELECT n.`codeId`, n.`code`
                          FROM `".$this->pluginPrefix."codes` n
                          WHERE n.`code` IN ( ". $params["filter"] ." )";
        //echo $query;
        return $this->getDataGrid($query);
    }
   
    public function add(){
        global $resource;
        $entityObj = $this->entity();
        $codes = "'".(implode("','",$_POST["code"]))."'";
        $params = array("filter" => $codes);
        $data = $this->getList($params);
        $countData = count($data["data"]);
        $return = array();
        
        for($i = 0; $i < $countData; $i++){
            $this->LastId = 0;
            $this->addRecord($entityObj, array("codeId" => $data["data"][$i]->codeId), array("dateTime" => date("Y-m-d H:i:s"), "UserId" => $this->currentUser->ID));
            
            if(!empty($this->LastId)){
                $this->updateRecord($entityObj["relationship"]["codes"], array("validate" => 1), array("codeId" => $data["data"][$i]->codeId));
                $return[] = array("code" => $data["data"][$i]->code, "status" => "1","statusText" => $resource->getWord("codeLoaded"));
            }
            else
            {
                $return[] = array("code" => $data["data"][$i]->code, "status" => "0","statusText" => $resource->getWord("failCode"));
            }
            
        }
        
        if($countData == 0){
            $countData = count($_POST["code"]);
            for($i = 0; $i < $countData; $i++){
                if(!empty($_POST["code"][$i]))
                    $return[] = array("code" => $_POST["code"][$i], "status" => "0","statusText" => $resource->getWord("failCode") );
            }
        }
        else {
            $countPost = count($_POST["code"]);
            if($countData != $countPost){
                for($i = 0; $i < $countPost; $i++){
                    for($j = 0; $j < $countData; $j++){
                        if($_POST["code"][$i] == $return[$j]["code"]){
                            break;
                        }
                    }
                    
                    if($j < $countPost){
                        $return[] = array("code" => $_POST["code"][$i], "status" => "0","statusText" => $resource->getWord("failCode") );
                    }
                }
            }
        }
        
        echo json_encode($return);
    }
    public function edit(){}
    public function del(){}
    public function detail($params = array()){}    
    public function entity($CRUD = array())
    {
        $data = array(
                    "tableName" => $this->pluginPrefix."registeredCodes"
                    ,"atributes" => array(
                        "codeRegisteredId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true )
                        ,"codeId" => array("type" => "int", "required" => true)
                    )
                    ,"relationship" => array(
                        "codes" => array(
                                "tableName" => $this->pluginPrefix."codes"
                                ,"parent" => array("tableName" => $this->pluginPrefix."codes", "Id" => "codeId")
                                ,"atributes" => array(
                                    "codeId" => array("type" => "int", "required" => true, "PK" => 0, "autoIncrement" => true)
                                    ,"validate" => array("type" => "int", "required" => true)
                                )
                            )
                    )
                );
        return $data;
    }
}
?>
