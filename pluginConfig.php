<?php 
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$URLPrefix = empty($_SERVER['CONTEXT_PREFIX'])? '' : $_SERVER['CONTEXT_PREFIX'];
$pluginName = "Gulf_SGC";
$pluginURL = $protocol."://".$_SERVER['HTTP_HOST'].$URLPrefix."/wp-content/plugins/".$pluginName."/";
$pluginPath = dirname(__FILE__);
$prefixPlugin = "sgc_";
$GeographicHierarchy = array("country" => array("table" => "countries"
						,"child" => array(
								"table" => "regions"
								,"child" => array(
										"table" => "cities"
										)
								)
						)
			);
 function getPahtFile($fileName){
    $CurrentDir = dirname(__FILE__);
    for($i=0;$i<10;$i++){
        if($i==0){
            $dir = $CurrentDir;
        }else{
            $dir = dirname($dir);
        }
        $file = $dir.DIRECTORY_SEPARATOR.$fileName;
        if(file_exists($file)){
            break;
        }      
    }
    return $file;
}
?>