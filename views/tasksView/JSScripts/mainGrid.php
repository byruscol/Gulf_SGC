<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Grid.php";
require_once "../../../helpers/Charts.php";
require_once "../../class.buildView.php";
require_once "../../class.buildChartView.php";

header('Content-type: text/javascript');
$params = array("numRows" => 10
                , "sortname" => "date_entered"
                , "CRUD" => array("add" => false, "edit" => true, "del" => true, "view" => true)
                , "postData" => array("method" => "getMyTasks")
                , "actions" => array(
                                        array("type" => "onSelectRow"
                                                  ,"function" => 'function(id) {
                                                                    if(id != null) {
                                                                            var postDataObj = jQuery("#notes").jqGrid("getGridParam","postData");
                                                                            postDataObj["filter"] = id;
                                                                            postDataObj["parent"] = "'.$_GET["view"].'";
                                                                            jQuery("#notes").jqGrid("setGridParam",{postData: postDataObj})
                                                                                            .trigger("reloadGrid");
             
                                                                            postDataObj = jQuery("#files").jqGrid("getGridParam","postData");
                                                                            postDataObj["filter"] = id;
                                                                            postDataObj["parent"] = "'.$_GET["view"].'";
                                                                            jQuery("#files").jqGrid("setGridParam",{postData: postDataObj})
                                                                                            .trigger("reloadGrid");
                                                                    }
                                                                }'
                                                )
                                    )
            );
$chartParams = array("title"=>"consolidateTaskStauts","subtitle"=>"puntoacopio", "queryId" => "pieMyTask");
$viewPieChart = new buildChartView("pie",$chartParams,"taskPieChart","tasks");
$chartParams = array("title"=>"consolidateTaskStauts","subtitle"=>"puntoacopio", "queryId" => "barMyTask", "chartConfig" => array("series" => "status", "rows" => "Expired", "data" => "Q", "isStacked" => false));
$viewBarChart = new buildChartView("bar",$chartParams,"taskBarChart","tasks");

$view = new buildView($_GET["view"], $params, "tasks");

?>
