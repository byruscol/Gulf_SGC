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
		
		foreach ($this->result as $key => $value)
		{
			foreach ($value as $k => $v){
				$this->result[$key]->$k =  utf8_encode(htmlentities($v));
			}
		}
		
		$this->getTotalRows();
	}
	
	protected function execute() {
		try {
			switch($this->queryType)
			{
				case "add": $this->result = $this->conn->insert( $this->query["table"], $this->query["data"]); $this->$LastId = $this->conn->insert_id;break;
				case "upd": $this->result = $this->conn->update( $this->query["table"], $this->query["data"], $this->query["filter"]); break;
				case "del": $this->result = $this->conn->delete( $this->query["table"], $this->query["filter"]); break;
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