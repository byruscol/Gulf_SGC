<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');

class PQRCustomerService extends DBManagerModel{
	
    public function getList($params = array()){}

    public function getChart($params = array()){
        switch ($params["queryId"])
        {
            case "QPieChart": 
                $query = "SELECT s.status, COUNT( 1 ) Q
                        FROM `".$this->pluginPrefix."nonConformities` n
                            LEFT JOIN `".$this->pluginPrefix."status` s ON s.statusid = n.`estadonc`
                        WHERE n.deleted = 0 AND clasificacion_nc_c = 1
                        GROUP BY `estadonc";
                break;
            case "PPieChart": 
                $query = "SELECT s.status, COUNT( 1 ) Q
                            FROM `".$this->pluginPrefix."nonConformities` n
                                LEFT JOIN `".$this->pluginPrefix."status` s ON s.statusid = n.`estadonc`
                            WHERE n.deleted = 0 AND clasificacion_nc_c = 3
                            GROUP BY `estadonc";
                break;
            case "RPieChart": 
                $query = "SELECT s.status, COUNT( 1 ) Q
                            FROM `".$this->pluginPrefix."nonConformities` n
                                LEFT JOIN `".$this->pluginPrefix."status` s ON s.statusid = n.`estadonc`
                            WHERE n.deleted = 0 AND clasificacion_nc_c = 2
                            GROUP BY `estadonc";
                break;
            case "PQRBarSourceChart":
                $query = "SELECT `source`, COUNT( 1 ) Q
                            FROM `".$this->pluginPrefix."nonConformities` n
                            JOIN `".$this->pluginPrefix."sources` s ON s.sourceId = n.fuentenc
                            WHERE deleted =0
                            GROUP BY `fuentenc` ";
                break;
            case "PQRBarCalsifStutsChart"; 
                $query = "SELECT s.status, c.classification, COUNT( 1 ) Q
                            FROM `".$this->pluginPrefix."nonConformities` n
                                JOIN `".$this->pluginPrefix."status` s ON s.statusid = n.`estadonc`
                                JOIN `".$this->pluginPrefix."classifications` c ON c.classificationId = n.clasificacion_nc_c
                            WHERE n.deleted = 0
                            GROUP BY classificationId, `estadonc`
                            ORDER BY `estadonc` , classificationId";
                break;
        }
        return $this->getDataGrid($query);
    }
    
    public function add(){}
    public function edit(){}
    public function del(){}
    public function detail($params = array()){}    
    public function entity($CRUD = array()){}
}
?>
