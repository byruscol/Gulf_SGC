<?php 
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
$pluginPath = dirname(__FILE__);
$rp = explode("wp-content", $pluginPath);
$rootPath = $rp[0];
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$URLPrefix = empty($_SERVER['CONTEXT_PREFIX'])? '' : $_SERVER['CONTEXT_PREFIX'];
$pluginName = explode(DIRECTORY_SEPARATOR,__DIR__);
$pluginURL = $protocol."://".$_SERVER['HTTP_HOST'].$URLPrefix."/wp-content/plugins/".end($pluginName)."/";

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
?>