<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
class resources{
        private $locale;
	private $pluginPath;
	function __construct($l = "es"){
            global $pluginPath;
            $locale = array();
            //echo __FILE__;
            $this->pluginPath = $pluginPath;
            require_once $this->pluginPath.'/helpers/resources/'. $l .'.php';
            $this->locale = $locale;
            
            //print_r($this->locale);    
	}
	
	public function getWord($key){//print_r($this->locale); 
		if(is_array ( $this->locale )){
                    $word = (array_key_exists($key, $this->locale ))? $this->locale[$key] : $key;
                }
		else 
                    $word = $key;
		return	$word;
	}
}
?>