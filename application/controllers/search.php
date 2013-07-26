<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportgenerator
 *
 * @author mince
 */
class Search extends CI_Controller{
    
    var $data = array();
    
    public function __construct() {
        parent::__construct();      
        $this->load->model("globaldata_model");                
        $this->load->model("search_model");                
        $this->globaldata_model->LoginControl();   
        $this->data = $this->globaldata_model->GetGlobalDataArray();        
    }
    
    public function index()
    {        
        return $this->report_stats();
    }
    
    
    public function report_stats()
    {
        $this->data['right_menu'] = 
        $this->data['report_stats'] = $this->search_model->get_report_stats();
        $this->load->view("Search/main.php",$this->data);
    }                   
}

?>
