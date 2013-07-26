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
class Reportgenerator extends CI_Controller{
    
    var $data = array();
    
    public function __construct() {
        parent::__construct();
        $this->load->model("reportgenerator_model");
        $this->load->model("reportregisterer_model");        
        $this->load->model("globaldata_model");                
        $this->globaldata_model->LoginControl();        
    }
    public function reportByHosts($report_id = NULL)
    {        
        if(! is_numeric($report_id))
            redirect ("main","index");
        $this->data['chart_host_vuln_detail'] = $this->reportgenerator_model->chart_host_vuln_detail($report_id);
        $this->data['chart_host_vuln'] = $this->reportgenerator_model->chart_host_vuln($report_id);
        $this->data['chart_top10_vuln_rate'] = $this->reportgenerator_model->chart_top10_vuln_rate($report_id);
        $this->data['report_info']  = $this->reportregisterer_model-> getReportWithID($report_id);
        $this->data['report_data'] = $this->reportgenerator_model->report_by_host($report_id);
        $this->data['globaldata'] = $this->globaldata_model->getGlobalDataArray();
        $this->load->view("Report/report_by_hosts",$this->data);
    }
    public function FullyReportByHosts($report_id = NULL)
    {
        if(! is_numeric($report_id))
            redirect ("main","index");
        $this->data['chart_host_vuln_detail'] = $this->reportgenerator_model->chart_host_vuln_detail($report_id);
        $this->data['chart_host_vuln'] = $this->reportgenerator_model->chart_host_vuln($report_id);
        $this->data['chart_top10_vuln_rate'] = $this->reportgenerator_model->chart_top10_vuln_rate($report_id);
        $this->data['report_info']  = $this->reportregisterer_model-> getReportWithID($report_id);
        $this->data['report_data'] = $this->reportgenerator_model->full_report_by_host($report_id);
        $this->data['globaldata'] = $this->globaldata_model->getGlobalDataArray();
        $this->load->view("Report/report_by_hosts",$this->data);        
    }
    
    public function reportByVulns($report_id = NULL)
    {        
        if(! is_numeric($report_id))
            redirect ("main","index");
        $this->data['chart_host_vuln_detail'] = $this->reportgenerator_model->chart_host_vuln_detail($report_id);
        $this->data['chart_host_vuln'] = $this->reportgenerator_model->chart_host_vuln($report_id);
        $this->data['chart_top10_vuln_rate'] = $this->reportgenerator_model->chart_top10_vuln_rate($report_id);
        $this->data['report_info']  = $this->reportregisterer_model-> getReportWithID($report_id);
        $this->data['report_data'] = $this->reportgenerator_model->report_by_vuln($report_id);
        $this->data['globaldata'] = $this->globaldata_model->getGlobalDataArray();
        $this->load->view("Report/report_by_vulns",$this->data);
    }
    
    public function FullyReportByVulns($report_id = NULL)
    {        
        if(! is_numeric($report_id))
            redirect ("main","index");
        $this->data['chart_host_vuln_detail'] = $this->reportgenerator_model->chart_host_vuln_detail($report_id);
        $this->data['chart_host_vuln'] = $this->reportgenerator_model->chart_host_vuln($report_id);
        $this->data['chart_top10_vuln_rate'] = $this->reportgenerator_model->chart_top10_vuln_rate($report_id);
        $this->data['report_info']  = $this->reportregisterer_model-> getReportWithID($report_id);
        $this->data['report_data'] = $this->reportgenerator_model->full_report_by_vuln($report_id);
        $this->data['globaldata'] = $this->globaldata_model->getGlobalDataArray();
        $this->load->view("Report/report_by_vulns",$this->data);
    }    
    ################# EXPLOITABLE
    public function ExploitablereportByVulns($report_id = NULL)
    {        
        if(! is_numeric($report_id))
            redirect ("main","index");
        $this->data['chart_host_vuln_detail'] = $this->reportgenerator_model->chart_host_vuln_detail($report_id);
        $this->data['chart_host_vuln'] = $this->reportgenerator_model->chart_host_vuln($report_id);
        $this->data['chart_top10_vuln_rate'] = $this->reportgenerator_model->chart_top10_vuln_rate($report_id);
        $this->data['report_info']  = $this->reportregisterer_model-> getReportWithID($report_id);
        $this->data['report_data'] = $this->reportgenerator_model->exloitable_report_by_vuln($report_id);
        $this->data['globaldata'] = $this->globaldata_model->getGlobalDataArray();
        $this->load->view("Report/report_by_vulns",$this->data);
    }    
    
   
}

?>
