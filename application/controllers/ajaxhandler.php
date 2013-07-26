<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ajaxhandler
 *
 * @author mince
 */
class ajaxhandler extends CI_Controller {
    
 function __construct(){
        parent::__construct();
        $this->load->model("globaldata_model");
        $this->globaldata_model->AdminSessionCheck();
    }
    
    public function get_reports_by_groupid($group_id){ 
        $query = $this->db->where("GroupID",$group_id)->get("Reports")->result();                              
        echo json_encode($query);           
    }
    public function get_hosts_by_reportid($host_id){ 
        $query = $this->db->where("ReportID",$host_id)->order_by("Name")->get("Hosts")->result();                              
        echo json_encode($query);
    }      
}

?>