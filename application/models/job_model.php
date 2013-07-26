<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of job_model
 *
 * @author mince
 */
class job_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    var $group_id;
    var $report_id;
    var $user_id;
    var $host_id;
    var $datepicker;
    var $description;
    var $errors;
    /**
     * Creating new user job!
     * @param type $job_data
     * @return boolean
     */
    public function get_active_jobs_numnumber_by_userid($user_id)
    {
        $result = $this->db->get_where("JobAssignment", array("UserID" => $user_id, "Status" => 0));
        return $result->num_rows();        
    }
    public function get_active_jobs_by_userid($user_id,$per_page,$segment)
    {
        $this->db->select('*');
        $this->db->from('JobAssignment');
        $this->db->join('Hosts', 'JobAssignment.HostID = Hosts.HostID');
        $this->db->join('Reports', 'Hosts.ReportID = Reports.ReportID');
        $this->db->join('ReportGroups', 'Reports.GroupID = ReportGroups.GroupID');
        $this->db->where(array("JobAssignment.UserID" => $user_id, "JobAssignment.Status" => 0));  
        $this->db->limit($per_page,$segment);
        $query = $this->db->get();
        return $query->result_array();        
    }
    public function get_completed_jobs_rownumber_by_userid($user_id)
    {
       $result = $this->db->get_where("JobAssignment", array("UserID" => $user_id, "Status" => 1)); 
       return $result->num_rows();
    }
    public function get_completed_jobs_by_userid($user_id,$per_page,$segment)
    {        
        $this->db->select('*');
        $this->db->from('JobAssignment');
        $this->db->join('Hosts', 'JobAssignment.HostID = Hosts.HostID');
        $this->db->join('Reports', 'Hosts.ReportID = Reports.ReportID');
        $this->db->join('ReportGroups', 'Reports.GroupID = ReportGroups.GroupID');
        $this->db->where(array("JobAssignment.UserID" => $user_id, "JobAssignment.Status" => 1));  
        $this->db->limit($per_page,$segment);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_running_jobs_rownumber()
    {
        $this->db->select('*');
        $this->db->from('JobAssignment');               
        $this->db->where(array("JobAssignment.Status" => 0));        
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_all_runnig_jobs($per_page,$segment)
    {
        $this->db->select('*');
        $this->db->from('JobAssignment');
        $this->db->join('Users', 'JobAssignment.UserID = Users.UserID');
        $this->db->join('Hosts', 'JobAssignment.HostID = Hosts.HostID');
        $this->db->join('Reports', 'Hosts.ReportID = Reports.ReportID');
        $this->db->join('ReportGroups', 'Reports.GroupID = ReportGroups.GroupID');      
        $this->db->where(array("JobAssignment.Status" => 0));
        $this->db->limit($per_page,$segment);

        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_completed_jobs_rownumber()
    {
        $this->db->select('*');
        $this->db->from('JobAssignment');        
        $this->db->where(array("JobAssignment.Status" => 1));        
        $query = $this->db->get();
        return $query->num_rows();        
    }
    public function get_all_completed_jobs($per_page,$segment)
    {
        $this->db->select('*');
        $this->db->from('JobAssignment');
        $this->db->join('Users', 'JobAssignment.UserID = Users.UserID');
        $this->db->join('Hosts', 'JobAssignment.HostID = Hosts.HostID');
        $this->db->join('Reports', 'Hosts.ReportID = Reports.ReportID');
        $this->db->join('ReportGroups', 'Reports.GroupID = ReportGroups.GroupID');         
        $this->db->where(array("JobAssignment.Status" => 1));
        $this->db->limit($per_page,$segment);
        $query = $this->db->get();
        return $query->result();        
    }
    public function job_cancel($job_id)
    {
        $this->db->delete('JobAssignment', array('JobID' => $job_id)); 
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }
    public function job_complete($job_id, $user_id)
    {
        // Checking job owner is valid!
        if($this->_check_job_owner($job_id, $user_id) == FALSE)
        {
            return FALSE;
        }
        $result = $this->db->update(
                "JobAssignment", 
                array("Status" => 1),
                array("JobID" => $job_id , "UserID" => $user_id)
                );
        if($result)
        {
            return TRUE;
        }
        return FALSE;
        
    }
    public function create_new_job($job_data = NULL)
    {
        if(!is_array($job_data))
        {
            log_message("error", "Kullanicidan gelen job arrayi bos!");
            return FALSE;
        }       
        $this->group_id     = $job_data['GroupID'];
        $this->report_id    = $job_data['ReportID'];
        $this->user_id      = $job_data['UserID'];
        $this->host_id      = $job_data['HostID'];
        $this->datepicker   = $job_data['EndDate'];
        $this->description  = $job_data['Description'];         
        // Checking GroupID really have that ReportID ?
        if($this->_check_reportid_is_valid() == FALSE)
        {
            return $this->errors;
        }
        // Checking ReportID really have that HostID ?! Do not trust fuck'n users and womans.                                        
        if($this->_check_hostid_is_valid() == FALSE)
        {
            return $this->errors;
        }        
        // everything is ok!
        if($this->_job_assignment($job_data) == FALSE)
        {
            return $this->errors;
        }
        return TRUE;
        
    }
    /**
     * Insert new job to database.
     * @param type $job_data
     * @return boolean
     */
    private function _job_assignment($job_data)
    {
        $temp = $job_data;
        //we dont need GroupID and ReportID element of array. Delete it.
        unset($temp['GroupID']); 
        unset($temp['ReportID']);        
        if($this->db->insert("JobAssignment", $temp))
        {
            return TRUE;
        }
        log_message("error","verileri db'ye insert edemedik!");
        $this->errors = "Job Assignment insert process fail. Please report that bug!";
        return FALSE;
        
    }
    private function _check_reportid_is_valid()
    {
        $result = $this->db->get_where("Reports",
                array(
                    "ReportID" => $this->report_id,
                    "GroupID"  => $this->group_id
                ));
        if($result->num_rows() == 1)
        {
            // reportid is valid
            return TRUE;
        }
        else if ($result->num_rows() == 0)
        {
            // reportid is not valid. Maybe hacking attempt!
            log_message("error","Gelen GroupID ile ReportID uyumlu degil!G-R = ".$this->group_id . "-".$this->report_id);
            return FALSE;
        }
        else
        {
            log_message("error","Reports tablosundan birden fazla satir var!G-R".$this->group_id . "-".$this->report_id);
            return FALSE;
        }
    }
    /**
     * Checking reportID have got that hostID!
     * @return boolean
     */
    private function _check_hostid_is_valid()
    {
        $result = $this->db->get_where("Hosts",
                array("ReportID" => $this->report_id,
                      "HostID" => $this->host_id )
                );        
        if($result->num_rows() == 1)
        {
            // hostid is valid!
            return TRUE;
        } 
        else if ( $result->num_rows() == 0)
        {
            // hostid is not valid! hacking attempt!
            log_message("error","Gelen ReportID ve HostID uyumlu degil!R-H = ".$this->report_id . " - ". $this->host_id);
            $this->errors = "Report and Host fields data is not valid!";
            return FALSE;
        }
        else
        {
            // this is interesting.. expected 1 row but there is much more..
            log_message("error", "Hosts tablosunda 1den fazla satir var!Reportid-Hostid = ". $this->report_id . " - " .$this->host_id);
            $this->errors = "Unexpected error! Read codeigniter/apache error logs.";
            return FALSE;
        }
    }
    private function _check_job_owner($job_id, $user_id)
    {
        $result = $this->db->get_where("JobAssignment", array("JobID" => $job_id, "UserID" => $user_id));
        if($result->num_rows() == 1)
        {
            return TRUE;
        }
        else
        {
            log_message("error","Gelen JobID ve UserID uyumlu degil!J-U = ".$job_id . " - ". $user_id);
            return FALSE;
        }
    }
    
}

?>
