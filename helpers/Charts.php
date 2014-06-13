<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "DBManager.php"; 
if(!isset($resource)){
	require_once "resources.php";
	$resource = new resources();
}
class Charts extends DBManager
{	
	private $table;	
	private $params;
        private $div;
        private $model;
        private $data;
	function __construct($type = "pie", $p, $d, $v) { 
                global $resource;
                $controller = $v;
		$this->type = $type;
                $this->params = $p;
                $this->div = $d;
                $this->loc = $resource;
                parent::__construct();
                require_once $this->pluginPath."/models/".$v."Model.php";
                $this->model = new $controller();                
                $this->data = $this->model->getChart($p);
                $this->chartBuilder();		
	}
        
	function __destruct() {
	}
        
	function chartBuilder(){
            global $resource;
            $chart="";
            $total = $this->data["total"];
            $dataChart = $this->data["data"];
            $dataCol = array();
            
            //"chartConfig" => array("series" => "status", "rows" => "Expired", "data" => "Q")
            if(array_key_exists('chartConfig', $this->params)){
                $series = array("serie");
                $dataRow = array();
                //echo $this->params["chartConfig"]["series"];
                foreach($dataChart as $k => $v){
                    $serie = $this->params["chartConfig"]["series"];
                    $row = $this->params["chartConfig"]["rows"];
                    $q = $this->params["chartConfig"]["data"];
                    $series[] = $v->$serie;
                    $dataRow[$v->$row][] = $v->$q;
                }
                $series = array_unique($series);
                        //[] = array("role" => "annotation");
                $dataCol[] = $series;
                foreach($dataRow as $key => $value){
                    $row = array($key);
                    foreach($value as $k => $v){
                        $row[] = $v + 0;
                    }
                    $dataCol[] = $row;
                }
                
                //print_r($dataCol);
            }
            else
            {
                foreach($dataChart as $k => $v){
                    $dataArray = array();
                    foreach($v as $key => $value){
                        if(is_numeric($value)){
                            $value = $value + 0;
                        }
                        $dataArray[] = $value;
                    }
                    $dataCol[] = $dataArray;                    
                }
            }
            $dc = json_encode($dataCol);

            header('Content-type: text/javascript');
            switch ($this->type) {
                case "stackedBar":
                    /*[
                                ['Sin fechas','In Progress',13]
                                ,['Sin fechas','Completed',80]
                                ,['Sin fechas','Deferred',1]
                                ,['Vencida','Abierta',8]
                                ,['Vencida','In Progress',1]
                                ,['Vencida','Completed',6]
                                ,['Vencida','Deferred',1]
                                ,['Con tiempo','In Progress',1]
                                ,['Vence hoy','Abierta',1]
                            ]
                            [
                              ['Year', 'Sales', 'Expenses'],
                              ['2004',  1000,      400],
                              ['2005',  1170,      460],
                              ['2006',  660,       1120],
                              ['2007',  1030,      540]
                            ]*/
                    $chart = "
                        google.load('visualization', '1', {packages:['corechart']});
                        google.setOnLoadCallback(".$this->div.");
                        function ".$this->div."() {
                            var data = google.visualization.arrayToDataTable(".$dc.");

                            var options = {
                              title: '".$this->loc->getWord($this->params["title"])."',
                              legend: { position: 'top', maxLines: 3 },
                                bar: { groupWidth: '75%' },
                                isStacked: true
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('".$this->div."'));
                            chart.draw(data, options);
                        }
                        jQuery(document).ready(function ($) {
                            $(window).resize(function(){
                                ".$this->div."();
                            });
                        });
                        ";
                    break;
                case "pie":
                    $chart = "  
                        google.load('visualization', '1.0', {'packages':['corechart']});
                        google.setOnLoadCallback(".$this->div.");
                        function ".$this->div."() {
                          var data = new google.visualization.DataTable();
                          data.addColumn('string', 'Topping');
                          data.addColumn('number', 'Slices');
                          data.addRows(".$dc.");                                     
                          var options = {'title':'".$this->loc->getWord($this->params["title"])."'};
                          var chart = new google.visualization.PieChart(document.getElementById('".$this->div."'));
                          chart.draw(data, options);
                        }

                        jQuery(document).ready(function ($) {
                            $(window).resize(function(){
                                ".$this->div."();
                            });
                        });
                    ";
                    break;
                case "geo":
                    $chart ="google.load('visualization', '1', {'packages': ['geochart']});
                            google.setOnLoadCallback(".$this->div.");

                            function ".$this->div."() {
                                var data = google.visualization.arrayToDataTable([
                                    ['City', '".$this->loc->getWord($this->params["subtitle"])."'],
                                    ".$dc."
                                ]);

                                var options = {                                    
                                    region: 'CO', 
                                    displayMode: 'markers',
                                    colorAxis: {colors: ['#e7711c', '#4374e0']} // orange to blue
                                };

                                var chart = new google.visualization.GeoChart(document.getElementById('".$this->div."'));
                                chart.draw(data, options);
                            };
                            jQuery(document).ready(function ($) {
                                $(window).resize(function(){
                                    ".$this->div."();
                                });
                            });
                       ";
                    break;

                default:
                    break;
            }
             
            echo $chart;
	}
}
?>