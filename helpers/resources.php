<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
class resources{
        private $locale;
	private $pluginPath;
	function __construct($l = "es"){
            global $pluginPath;
            $locale = array();
            
            $this->pluginPath = $pluginPath;
            if(file_exists('resources/'. $l .'.php')){
                require_once 'resources/'. $l .'.php';
            }
            else{
                
                require_once realpath(dirname(__FILE__)).'/resources/'. $l .'.php';
                
            }
            $this->locale = $locale;   
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