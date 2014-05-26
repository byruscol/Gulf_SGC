<?php
require_once($_SERVER['CONTEXT_DOCUMENT_ROOT'].'/wp-load.php' );
require_once dirname(__FILE__)."/../pluginConfig.php";
abstract class DBManager{
	public $conn;
	public $pluginPrefix;
	public $wpPrefix;
	public $pluginPath;
	public $pluginURL;
	protected $query;
        protected $DBOper = array("table" => "", "data" => array(), "filter" => array());
	protected $totalRows;
	protected $queryType;
	protected $LastId;
	protected $result;
        protected $currentUser;
	
	function __construct() {
		global $wpdb;
		global $pluginURL;
		global $pluginPath;
		global $prefixPlugin;
                global $current_user;
		$this->conn = $wpdb;
		$this->pluginURL = $pluginURL;
		$this->pluginPath = $pluginPath;
		$this->wpPrefix = $this->conn->prefix;
		$this->pluginPrefix = $this->wpPrefix;
		if(!empty($prefixPlugin)) $this->pluginPrefix .= $prefixPlugin;
                $this->currentUser = $current_user;
	}
	
	function __destruct() {}
	
	public function getDataGrid($query = "SELECT 1 FROM dual", $start = null, $limit = null, $colSort = null, $sortDirection = null)
	{
		$this->queryType = (empty($this->queryType))? "rows" : $this->queryType;
                $queryBuild = $query;
		
		if($colSort != null)
			$queryBuild .= " ORDER BY " . $colSort;
		
		if($sortDirection != null)
			$queryBuild .= " " . $sortDirection;
		
		if($start != null && $limit != null)
			$queryBuild .= " LIMIT " . $start . " , " . $limit;

		return $this->get($queryBuild, $this->queryType);
	}
	
        protected function get($query, $type)
	{
		$this->query = $query;
		$this->queryType = $type;
		$this->execute();
	
		$array = array("totalRows" => $this->totalRows, "data" => $this->result);
		return $array;
	}
	
	protected function getTotalRows() {
		$this->totalRows = $this->conn->get_var( "SELECT FOUND_ROWS() AS `found_rows`;" );
	}
	
	protected function standardQuery()
	{
		$q = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $this->query);
		$queryLen = strlen($q);
		if(substr($q, $queryLen - 1, 1) != ";")
			$q = $q . ";";
		
		if(substr_count($q, "SELECT") > 0)
		{
			$selectPos = stripos ( $q , "SELECT " ) + 6;
			$q = "SELECT SQL_CALC_FOUND_ROWS " . substr ( $q , $selectPos, strlen($q));
		}
		
		$this->query = $q;
	}
	
	protected function executeQuery() {
		$this->standardQuery();
                
		switch($this->queryType)
		{
			case "var": $this->result = $this->conn->get_var( $this->query ); break;
			case "row": $this->result = $this->conn->get_row($this->query, OBJECT); break;
			case "rows":$this->result = $this->conn->get_results($this->query, OBJECT); break;
		}
		
		$this->getTotalRows();
	}
	
	protected function execute() {
            
            try {
                    switch($this->queryType)
                    {
                        case "add": $this->result = $this->conn->insert( $this->DBOper["table"], $this->DBOper["data"]); $this->LastId = $this->conn->insert_id;break;
                        case "edit": $this->result = $this->conn->update( $this->DBOper["table"], $this->DBOper["data"], $this->DBOper["filter"]); break;
                        case "del": $this->result = $this->conn->delete( $this->DBOper["table"], $this->DBOper["filter"]); break;
                        default: $this->executeQuery();
                    }
                    
                    $this->queryType = "";
		}
		catch (Exception $e)
		{
                    $this->result = "Error: ".$e->getMessage();
		}
	}

        protected function updateRecord($entity, $newRecord, $filters){
            if ( ! is_array( $newRecord ) || ! is_array( $filters ))
		return false;
            
            $updateData = array();
            $auditData = array();
            
            $cols = array();
            $where = array();
            $ws = array();
            
            $query = "SELECT {COLS} from ".$entity["tableName"]." WHERE {WHERE}";
            
            foreach($entity["atributes"] as $key => $value){
                $cols[] = $key;
                if(array_key_exists($key, $filters))
                    $where[$key] = $filters[$key];
            }

            foreach($where as $key => $value){
                $ws[] = $key ." = ". $value;
            }
            
            $query = str_replace("{COLS}", (implode(",", $cols)), $query);
            $query = str_replace("{WHERE}", (implode(" AND ", $ws)), $query);

            $this->queryType = "row";
            $currentRecord = $this->getDataGrid($query);
            
            foreach($entity["atributes"] as $key => $value){
                if(stripslashes($newRecord[$key]) != $currentRecord["data"]->$key){
                    $updateData[$key] = stripslashes($newRecord[$key]);
                    $auditData[] = array( 
                                       "table" => $entity["tableName"]
                                       ,"column" => $key
                                       ,"data" => stripslashes($currentRecord["data"]->$key)
                                       ,"action" => "edit"
                                       ,"date" => date("Y-m-d H:i:s",time())
                                       ,"user" => $this->currentUser->user_login
                                    );
                }
            }
            
            if(count($updateData) > 0)
            {
                $this->queryType = "add";
                $this->DBOper["table"] = $this->pluginPrefix."audit";
                foreach($auditData as $key => $value){
                    $this->DBOper["data"]  = $value;
                    $this->execute();
                }
                
                $this->queryType = "edit";
                $this->DBOper["table"] = $entity["tableName"];
                $this->DBOper["filter"] = $where;
                $this->DBOper["data"]  = $updateData;

                $this->execute();
            }
        }
        
}
?>