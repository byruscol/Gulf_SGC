<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Charts.php";
require_once "../../class.buildChartView.php";

header('Content-type: text/javascript');
$chartParams = array("title"=>"consolidatePStauts","subtitle"=>"", "queryId" => "PPieChart");
$viewPieChart = new buildChartView("pie",$chartParams,"PPieChart","PQRCustomerService");

$chartParams = array("title"=>"consolidateQStauts","subtitle"=>"", "queryId" => "QPieChart");
$viewPieChart = new buildChartView("pie",$chartParams,"QPieChart","PQRCustomerService");

$chartParams = array("title"=>"consolidateRStauts","subtitle"=>"", "queryId" => "RPieChart");
$viewPieChart = new buildChartView("pie",$chartParams,"RPieChart","PQRCustomerService");

$chartParams = array("title"=>"consolidateBarSource","subtitle"=>"", "queryId" => "PQRBarSourceChart", "chartConfig" => array("serieName" => "Cantidad", "ValueName" => "Value"));
$viewPieChart = new buildChartView("bar",$chartParams,"PQRBarSourceChart","PQRCustomerService");

$chartBarParams = array("title"=>"consolidatePQRStautsClasification","subtitle"=>"puntoacopio", "queryId" => "PQRBarCalsifStutsChart", "chartConfig" => array("series" => "status", "rows" => "classification", "data" => "Q", "isStacked" => false));
$viewBarChart = new buildChartView("bar",$chartBarParams,"PQRBarCalsifStutsChart","PQRCustomerService");
?>
