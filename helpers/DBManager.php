<?php
require_once dirname(__FILE__)."/../pluginConfig.php";
require_once getPahtFile("wp-load.php");
abstract class DBManager{
	public $conn;
	public $pluginPrefix;
	public $wpPrefix;
	public $pluginPath;
	public $pluginURL;
	protected $query;
        protected $DBOper = array("table" => "", "data" => array(), "filter" => "");
	protected $totalRows;
	protected $queryType;
	protected $LastId;
	protected $result;
	
	function __construct() {
		global $wpdb;
		global $pluginURL;
		global $pluginPath;
		global $prefixPlugin;
		$this->conn = $wpdb;
		$this->pluginURL = $pluginURL;
		$this->pluginPath = $pluginPath;
		$this->wpPrefix = $this->conn->prefix;
		$this->pluginPrefix = $this->wpPrefix;
		if(!empty($prefixPlugin)) $this->pluginPrefix .= $prefixPlugin;
	}
	
	function __destruct() {}
	
	public function getDataGrid($query = "SELECT 1 FROM dual", $start = null, $limit = null, $colSort = null, $sortDirection = null)
	{
		$queryBuild = $query;
		
		if($colSort != null)
			$queryBuild .= " ORDER BY " . $colSort;
		
		if($sortDirection != null)
			$queryBuild .= " " . $sortDirection;
		
		if($start != null && $limit != null)
			$queryBuild .= " LIMIT " . $start . " , " . $limit;

		return $this->get($queryBuild, "rows");
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
            //echo $this->DBOper["filter"];
            try {
			switch($this->queryType)
			{
				case "add": $this->result = $this->conn->insert( $this->DBOper["table"], $this->DBOper["data"]); $this->$LastId = $this->conn->insert_id;break;
                                case "edit": $this->result = $this->conn->update( $this->DBOper["table"], $this->DBOper["data"], $this->DBOper["filter"]); break;
				case "del": $this->result = $this->conn->delete( $this->DBOper["table"], $this->DBOper["filter"]); break;
				default: $this->executeQuery();
			}
		}
		catch (Exception $e)
		{
			$this->result = "Error: ".$e->getMessage();
		}
	}
}
?>