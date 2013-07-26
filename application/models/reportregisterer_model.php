<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportregisterer_model
 *
 * @author mince
 */
;
class reportregisterer_model extends CI_Model {
    /**
     * Handling errors
     * @var array
     */
    var $error_handler =  array();
    
    /**
     * Holding all nessus content on this variable!
     * @var type 
     */
    var $stdObjicerik;
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function __destruct() {
        unset($this->error_handler);
    }

    public function get_errors()
    {
        return $this->error_handler;
    }
    /**
     * Calculating report hash with full path name!
     * @param string $report_path
     * @return boolean
     */
    public function calcReportCheckSum($report_path)
    {
        if(file_exists($report_path))
            return md5_file($report_path);
        return FALSE;         
    }
    /**
     * Checking report hash for prevent dublicate report on database!
     * @param type $raport_hash
     * @return boolean
     */
    public function checkReportHash($raport_hash)
    {
        $this->db->where("CheckSum", $raport_hash);
        $query = $this->db->get("Reports");
        if($query->num_rows > 0)
            return FALSE;
        return TRUE;
    }
    /**
     * Inserting new report informations to Report table
     * @param type $data
     * @return boolean
     */
    public function insertReport($data)
    {
        if($this->db->insert("Reports",$data))
            return TRUE;
        return FALSE;
    }
    /**
     * Getting report informations by checksum
     * @param string $report_hash
     * @return array
     */
    public function getReportWithHash($report_hash)
    {
        $this->db->where("CheckSum", $report_hash);
        $query = $this->db->get("Reports");
        return $query->result();
    }
    /**
     * Getting report list which is processed!
     * @return array
     */
    /**
     * get report list and change UserID to Username for show report owner.local
     * @return type
     */

    public function getProcessedReports($per_page,$segment)
    {
        $this->db->order_by("InsertDate", "DESC");
        $this->db->where("IsProcessed", 1);
        $this->db->limit($per_page,$segment);
        $query = $this->db->get("Reports");               
        $reports = $query->result();
        foreach ($reports  as $row)
        {
            $this->db->where("UserID", $row->UserID);
            $user_info = $this->db->get("Users");
            $row->UserID = $user_info->row("Username");
        }
        return $reports;
    }   
    public function getReportWithID($report_id)
    {
        $this->db->where("ReportID", $report_id);
        $query = $this->db->get("Reports");
        $reports = $query->result();
        foreach ($reports  as $row)
        {
            $this->db->where("UserID", $row->UserID);
            $user_info = $this->db->get("Users");
            $row->UserID = $user_info->row("Username");
        }                
        return $query->row();
    }
    public function getProcessedReportsRowNumbers()
    {
        $this->db->where("IsProcessed", 1);
        $query = $this->db->get("Reports");
        return $query->num_rows();       
    }
    public function getActiveProcessReports($per_page,$segment)
    {
        $this->db->order_by("InsertDate", "DESC");
        $this->db->where("IsProcessed", 0);
        $this->db->limit($per_page,$segment);
        $query = $this->db->get("Reports");               
        $reports = $query->result();
        foreach ($reports  as $key => $row)
        {
            $this->db->where("UserID", $row->UserID);
            $user_info = $this->db->get("Users");
            $row->UserID = $user_info->row("Username");
        }
        return $reports;        
    }
    public function getActiveProcessReportsRowNumbers()
    {
        $this->db->where("IsProcessed",0);
        $query = $this->db->get("Reports");
        return $query->num_rows();
    }
    public function getReportGroups()
    {
        return $this->db->get("ReportGroups")->result();
    }
    /**
     * Main method for register all vulnerabilities and hosts data.
     * @param string $report_checksum
     * @param string $report_path
     * @return boolean
     */
    public function reportToDatabase($report_checksum, $report_full_path)
    {        
        if(file_exists("./xml_to_db/xml_to_db.php"))
        {
            shell_exec("/usr/bin/php ./xml_to_db/xml_to_db.php ". $report_checksum . " " . $report_full_path ." >> /tmp/".$report_checksum."log_file.log 2>&1 &");
            return TRUE;            
        } else {
            log_message('error', 'xml_to_db.php does not exists.');
        }
    }
    ############# Report GROUP Segment ##############
    public function isReportGroupExist($group_id)
    {
        $this->db->where("GroupID", $group_id);
        $query = $this->db->get("ReportGroups");
        if($query->num_rows > 0)
            return FALSE;
        return TRUE;
    }    
    public function getAllReportGroup()
    {
        return $this->db->get("ReportGroups")->result();
    }
    public function getReportGroupRowNumber()
    {
        return $this->db->get("ReportGroups")->num_rows();        
    }
    
    public function getReportGroup($per_page,$segment)
    {        
        $this->db->limit($per_page,$segment);
        $query = $this->db->get("ReportGroups");
        return $query->result();    
        
    }
    
    public function getGroupByGroupID($group_id)
    {
        return $this->db->where("GroupID",$group_id)->get("ReportGroups")->row();
    }
    
    public function updateGroupInformationByID($group_id, $data)
    {
        if($this->db->where("GroupID",$group_id)->update("ReportGroups",$data))
                return TRUE;
        return FALSE;
    }
    
    public function createNewReportGroup($data)
    {
        if($this->db->insert("ReportGroups", $data))
            return TRUE;
        return FALSE;
    }
    
    public function deleteReportGroup($group_id)
    {
        //Report group are deleting.
        if(!$this->db->delete('ReportGroups', array('GroupID' => $group_id)))
            log_message('error', 'Cant delete group from ReportGroups.');   
                                         
        // Reports are deleting.
        $report_result = $this->db->select("ReportID")->get_where("Reports", array("GroupID" => $group_id))->result_array();
        $report_list = array();        
        foreach ($report_result as $value) {
            array_push($report_list, $value['ReportID']);
        }                
        if(is_array($report_list) and !empty($report_list))
        {
            if(!$this->db->where_in('ReportID', $report_list)->delete('Reports'))
                log_message('error', 'Cant delete reports from Reports');                                 
        }       
        
        // Host and Vulnerabilities are deleting.        
        $host_result = $this->db->select("HostID")->where_in("ReportID", $report_list)->get("Hosts")->result_array();                               
        $host_list = array();
        foreach ($host_result as $value) {
            array_push($host_list,$value['HostID']);
        }        
        if(is_array($host_list) and !empty($host_list))
        {
            if(!$this->db->where_in('HostID', $host_list)->delete("Hosts"))            
                log_message('error', 'Cant delete hosts from Hosts');            
            if(!$this->db->where_in('HostID', $host_list)->delete("HostsVulnerabilities"))            
                log_message('error', 'Cant delete hosts from HostsVulnerabilities');
            if(!$this->db->where_in('HostID', $host_list)->delete("JobAssignment"))            
                log_message('error', 'Cant delete hosts from JobAssignment');  
        }                
    }  
}

?>
