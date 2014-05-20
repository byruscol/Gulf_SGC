<?php 
$pluginURL = str_replace("controllers/","",plugin_dir_url(__FILE__));
$pluginPath = str_replace("controllers","",dirname(__FILE__));
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