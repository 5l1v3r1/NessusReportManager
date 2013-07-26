<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author mince
 */
class Admin extends CI_Controller{
    /**
     * Keep all globaldata array on it for use other functions
     * @var array
     */
    var $data = array();
    
    /**
     * Keep main view page name for send pages!
     * @var string
     */
    var $mainName;

    function __construct() {
        parent::__construct();
        $this->load->model("globaldata_model");
        $this->load->model("membership_model");

        
        
        $this->globaldata_model->AdminSessionCheck();
        
        $this->mainName = "Admin";
        $this->data = $this->globaldata_model->GetGlobalDataArray();
        $this->data['mainMenu']  = $this->mainName."/MainMenu.php";
    }
    
    function __destruct() {
        unset($data);
    }
    
    public function index()
    {
        $this->data['rightMenu'] = $this->mainName."/RightMenuMain.php";
        $this->load->view("Home",$this->data);
    }
    /*
     * For Developer view on Dashboard
     */
    public function Information()
    {
        
        $this->data['rightMenu'] = "/Include/Information.php";
        $this->load->view("Home",$this->data);
    }
    /*
     * For Contact view on Dashboard
     */
    public function Contact()
    {
        $this->data['rightMenu'] = "/Include/Contact.php";
        $this->load->view("Home",$this->data);
    }
    /**
     * For Faillogin datas view on Dashboard
     * 
     */
    public function FailLogin()
    {     
        $this->load->model('pagination_model');
        
        $base_url = site_url()."/admin/FailLogin";
        $total_rows = $this->membership_model->getFailLoginRowNumbers();
        $per_page = 5;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);
        $this->data['failLogins'] = $this->membership_model->getFailLogin($per_page,$this->uri->segment(3));
        $this->data['rightMenu'] = $this->mainName."/RightMenuFailLogin.php";
                
        
        $this->load->view('Home', $this->data);
    }
    
    public function AccessLogin()
    {
        $this->load->model("pagination_model");
        
        $base_url = site_url()."/admin/AccessLogin";
        $total_rows = $this->membership_model->getTableRowNumbers("AccessLogin");
        $per_page = 5;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);
        $this->data['accessLogins'] = $this->membership_model->getAccessLogin($per_page,$this->uri->segment(3));
        $this->data['rightMenu'] = $this->mainName."/RightMenuAccessLogin.php";
        $this->load->view('Home', $this->data);
    }
    /**
     * User management modul for administartor.
     */
    
    public function Users()
    {
        $this->load->model('pagination_model');
        
        $base_url = site_url()."/admin/Users";
        $total_rows = $this->membership_model->getTableRowNumbers("Users");
        $per_page = 10;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        $this->data['userInfo']  = $this->membership_model->getTableDataWithLimit("Users",$per_page,$this->uri->segment(3));
        
        $this->data['rightMenu'] = $this->mainName."/RightMenuUsers.php";
        $this->load->view("Home",$this->data);
    }
    public function UserDetail($user_id = -1)
    {
        if ($user_id == -1){
            $this->index();
            return FALSE;          
        }
        
        $this->data['userInfo'] = $this->membership_model->getUserInfoByID($user_id);
        
        $this->data['rightMenu'] = $this->mainName."/RightMenuUserDetail.php";
        $this->load->view("Home",$this->data);
            
        
    }
    
    public function ChangeUserInformation($user_id)
    {
        $this->load->library('form_validation');
        $this->load->library('input');
        // Prepare input sanitzation
        $rules_config = array(
               array(
                     'field'   => 'Username', 
                     'label'   => 'Username', 
                     'rules'   => 'xss_clean|trim|required'
                  ),
               array(
                     'field'   => 'Name', 
                     'label'   => 'Name', 
                     'rules'   => 'xss_clean|trim|required'
                  ),   
               array(
                     'field'   => 'Surname', 
                     'label'   => 'Surname', 
                     'rules'   => 'xss_clean|trim|required'
                  ),            
               array(
                     'field'   => 'UserIdentify', 
                     'label'   => 'User Identify', 
                     'rules'   => 'xss_clean|trim|required'
                  ),
               array(
                     'field'   => 'Mail', 
                     'label'   => 'Mail', 
                     'rules'   => 'xss_clean|trim|required|valid_email'
                  ),   
               array(
                     'field'   => 'CurrentPassword', 
                     'label'   => 'Current Password', 
                     'rules'   => 'xss_clean|trim|required|min_length[6]'
                  ),
               array(
                     'field'   => 'NewPassword', 
                     'label'   => 'New Password', 
                     'rules'   => 'xss_clean|trim|min_length[6]'
                  ),
               array(
                     'field'   => 'NewPassword2', 
                     'label'   => 'New Password2', 
                     'rules'   => 'xss_clean|trim|min_length[6]'
                  )
            );
        $this->form_validation->set_rules($rules_config);
        if($this->form_validation->run() == FALSE){
            $this->UserDetail($user_id);
            return false;
        }
        // Everything is oke. lets change user information
        
        if($this->input->post("NewPassword") == $this->input->post("NewPassword2"))
        {
            $new_password_1 = $this->input->post("NewPassword");
            $new_password_2 = $this->input->post("NewPassword2");
            // Checking new password is null. if null, dont change current password
            if(empty($new_password_1) and empty($new_password_2))
                $prepare_input = array(
                    'Username'      => $this->input->post("Username"),
                    'UserIdentify'  => $this->input->post("UserIdentify"),
                    'Mail'          => $this->input->post("Mail"),
                    'Name'          => $this->input->post("Name"),
                    'Surname'       => $this->input->post("Surname")
                );
            else 
                $prepare_input = array(
                    'Username'      => $this->input->post("Username"),
                    'UserIdentify'  => $this->input->post("UserIdentify"),
                    'Mail'          => $this->input->post("Mail"),
                    'Name'          => $this->input->post("Name"),
                    'Surname'       => $this->input->post("Surname"),
                    'Password'      => sha1(md5($this->input->post("NewPassword")))
                );
           

                
            $admin_password = $this->input->post("CurrentPassword");
            // Check admin password is TRUE!
            if($this->membership_model->checkUserPassIsTrue($this->session->userdata("Username"),$admin_password))
            {
                if($this->membership_model->updateUserInfoByUserID($prepare_input,$user_id))
                    //Password has been changed!    
                    $this->data['process'] = 1;
                else
                    //Something went wrong!
                    $this->data['process'] = 2;  
            } else {
                    // Current password is wrong!
                    $this->data['process'] = 3;                    
            }
            
        } else {
                    // entered password is not same!
                    $this->data['process'] = 4; 
        }
        $this->UserDetail($user_id);
    }
    /** 
     * Create new user
     */
    public function UserAdd()
    {
        $this->data['rightMenu'] = $this->mainName."/RightMenuUserAdd.php";
        $this->load->view("Home",$this->data);
    }
    
    public function CreateNewUser()
    {
        $this->load->library("form_validation");
        $this->load->library("input");
        // Checking username is free!
        if($this->membership_model->checkUsernameIsFree($this->input->post("Username")) == FALSE)
        {
            $this->data['process'] = 4;
            $this->UserAdd();
            return FALSE;
        }
        // Checking mail is free!
        if($this->membership_model->checkMailIsFree($this->input->post("Mail")) == FALSE)
        {
            $this->data['process'] = 5;
            $this->UserAdd();
            return FALSE;
        }
        // Prepare User Inputs for a sanitzation
        $rules_config = array(
               array(
                     'field'   => 'Username', 
                     'label'   => 'Username', 
                     'rules'   => 'xss_clean|trim|required'
                  ),
               array(
                     'field'   => 'Name', 
                     'label'   => 'Name', 
                     'rules'   => 'xss_clean|trim|required'
                  ),   
               array(
                     'field'   => 'Surname', 
                     'label'   => 'Surname', 
                     'rules'   => 'xss_clean|trim|required'
                  ),            
               array(
                     'field'   => 'UserIdentify', 
                     'label'   => 'User Identify', 
                     'rules'   => 'integer|trim|required'
                  ),
               array(
                     'field'   => 'Mail', 
                     'label'   => 'Mail', 
                     'rules'   => 'xss_clean|trim|required|valid_email'
                  ),   
               array(
                     'field'   => 'CurrentPassword', 
                     'label'   => 'Current Password', 
                     'rules'   => 'xss_clean|trim|required|min_length[6]'
                  ),
               array(
                     'field'   => 'NewPassword1', 
                     'label'   => 'New Password', 
                     'rules'   => 'xss_clean|trim|min_length[6]|matches[NewPassword2]'
                  ),
               array(
                     'field'   => 'NewPassword2', 
                     'label'   => 'Again New Password ', 
                     'rules'   => 'xss_clean|trim|min_length[6]|matches[NewPassword1]'
                  )
            );
        $this->form_validation->set_rules($rules_config);
        if($this->form_validation->run() == FALSE)
        {
            $this->UserAdd();
            return FALSE;
        }

        // Everything is oke. lets create an user.
        $prepare_input = array(
            'Username'      => $this->input->post("Username"),
            'Password'      => sha1(md5($this->input->post("Password"))),
            'UserIdentify'  => $this->input->post("UserIdentify"),
            'Mail'          => $this->input->post("Mail"),
            'Name'          => $this->input->post("Name"),
            'Surname'       => $this->input->post("Surname")
        );
        // Checking admin password is true!
        $admin_password = $this->input->post("CurrentPassword");
            // Check admin password is TRUE!
            if($this->membership_model->checkUserPassIsTrue($this->session->userdata("Username"),$admin_password))
            {
                if($this->membership_model->createNewUser($prepare_input))
                    //User has been create   
                    $this->data['process'] = 1;
                else
                    //Something went wrong!
                    $this->data['process'] = 2;  
            } else {
                    // Current password is wrong!
                    $this->data['process'] = 3;                    
            }
         $this->UserAdd(); 
         return TRUE;
        
    }
    public function DeleteUser()
    {
        $this->load->library("form_validation");
        $this->load->library("input");
        $this->form_validation->set_rules("deleteButton","required|integer");
        $this->form_validation->set_rules("UserID", "UserID Hidden value", "required|integer");
        if($this->form_validation->run() == FALSE)
        {
            $this->Users();
            return FALSE;
        }
        if($this->membership_model->deleteUserByID($this->input->post("UserID")))
        {
            $this->data['processFeedback'] = 1;
            $this->Users();
            return TRUE;
        }
        $this->data['processFeedback'] = 2;
        $this->Users();
    }
    public function ActiveProcess()
    {
        $this->load->model("pagination_model");
        $this->load->model("reportregisterer_model");
        
        $base_url = site_url()."/admin/ActiveProcess";
        $total_rows = $this->reportregisterer_model->getActiveProcessReportsRowNumbers();
        $per_page   = 15;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);
        $this->data['reportInfo']  = $this->reportregisterer_model->getActiveProcessReports($per_page,$this->uri->segment(3));
        $this->data['rightMenu'] = $this->mainName."/RightMenuActiveProcess.php";
        $this->load->view("Home",$this->data);         
    }
    public function Reports()
    {
        $this->load->model('pagination_model');
        $this->load->model("reportregisterer_model");                
        
        $base_url = site_url()."/admin/Reports";
        $total_rows = $this->reportregisterer_model->getProcessedReportsRowNumbers();
        $per_page = 15;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        $this->data['reportInfo']  = $this->reportregisterer_model->getProcessedReports($per_page,$this->uri->segment(3));        
        //$this->membership_model->getUserInfoByID();
        
        $this->data['rightMenu'] = $this->mainName."/RightMenuReports.php";
        $this->load->view("Home",$this->data);        
      
    }
    public function ReportDetail($report_id = NULL)
    {
        if(!is_numeric($report_id))
        {
            $this->Reports();
            return FALSE;
        }
        $this->load->model("reportregisterer_model");
        $this->data['report_data'] = $this->reportregisterer_model->getReportWithID($report_id);
        $this->data['rightMenu'] = $this->mainName."/RightMenuReportDetail.php";
        $this->load->view("Home", $this->data);                    
    }
    public function NessusReportManager()
    {
        $this->load->model("reportregisterer_model");
        $this->data['reportGroup'] =  $this->reportregisterer_model->getReportGroups();
        $this->data['rightMenu'] = $this->mainName."/RightMenuNessusReportManager.php";
        $this->load->view("Home",$this->data);
    }
    /**
     * Handling nessus files and processing it!
     */
    public function do_NessusUpload()
    {      
        $this->load->library("form_validation");
        $this->load->helper(array('form', 'url'));
        $this->data['rightMenu'] = $this->mainName."/RightMenuNessusReportManager.php";
        
        $this->form_validation->set_rules("ReportName", "Report Name", "xss_clean|trim|required");
        $this->form_validation->set_rules("ReportDescription", "Report Description", "xss_clean|trim");
        $this->form_validation->set_rules("ReportGroup", "Report Group", "numeric|trim|required");
        if($this->form_validation->run() == FALSE)
        {
            $this->NessusReportManager();
            return FALSE;
        }
        $config['upload_path'] = './nessus_report_repo/';
        $config['allowed_types'] = 'nessus';
        $config['max_size']	= '300000';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        // Upload fail! give an error to user
        if ( ! $this->upload->do_nessus_upload())
        {                    
            $this->data['error'] = array('error' => $this->upload->display_errors());                
            $this->NessusReportManager();
        }
        else
        {
            // Upload has been finished! Lets begin all report registration!
            $this->load->model("reportregisterer_model");
            // Get uploaded file info.
            $file_info = $this->upload->data();            
            
            $report_checksum = $this->reportregisterer_model->calcReportCheckSum($file_info['full_path']);
            if($this->reportregisterer_model->checkReportHash($report_checksum))
            {
                // This is 0day report :)
                $report_info = array(
                    'UserID'            => $this->session->userdata("UserID"),
                    'InsertDate'        => date('Y-m-d'),
                    'IpAddress'         => $this->session->userdata("ip_address"),
                    'CheckSum'          => $report_checksum,
                    'ReportName'        => $this->input->post("ReportName"),
                    'ReportDescription' => $this->input->post("ReportDescription"),
                    'ReportPath'        => $file_info['file_name'],
                    'GroupID'           => $this->input->post("ReportGroup"),
                );
                if($this->reportregisterer_model->insertReport($report_info))
                {
                    // Upload success and 0day report. Lets send information to user
                    $this->data['reportInfo'] = $report_info;
                    $this->data['rightMenu'] = $this->mainName . "/RightMenuUploadSuccess.php";
                    // Report is uniq and read to insert report's data to database!
                    // reportToDatabase() is main method for parsing and registering process.                    
                    if($this->reportregisterer_model->reportToDatabase( $report_checksum, $file_info['full_path']) == FALSE)
                    {
                        $this->data['reportregister_erros'] = $this->reportregisterer_model->get_errors();                    
                        $this->NessusReportManager();                        
                    }                        
                    $this->load->view("Home",$this->data);
                    return;
                }
            } else 
            {                
                $same_report_info = $this->reportregisterer_model->getReportWithHash($report_checksum);
                foreach ($same_report_info as $row)
                // get old report owner informations
                $this->load->model("membership_model");
                $this->data['db_report_owner_info'] = $this->membership_model->getUserInfoByID($row->UserID);
                // delete current file
                $this->data['db_report_info'] = $same_report_info;
                // same report and deleteing current uploaded file
                unlink($file_info['full_path']);
            }           
            $this->NessusReportManager();
            //$this->load->view("Home",$this->data);
        }
    }
    ############### JOBS SEGMENT! #################
    public function ReportList()
    {
        $this->load->model('pagination_model');
        $this->load->model("reportregisterer_model");                
        
        $base_url = site_url()."/admin/jobs/ReportList";
        $total_rows = $this->reportregisterer_model->getProcessedReportsRowNumbers();
        $per_page = 15;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        $this->data['reportInfo'] = $this->reportregisterer_model->getProcessedReports($per_page,$this->uri->segment(3));        
        //$this->membership_model->getUserInfoByID();
        
        $this->data['rightMenu'] = $this->mainName."/jobs/ReportList.php";
        $this->load->view("Home",$this->data);        
      
    }
    ################ REPORT GROUP SEGMENT ##############
    public function ReportGroup()
    {
        $this->load->model('pagination_model');
        $this->load->model("membership_model");
        
        $base_url = site_url()."/admin/ReportGroup";
        $total_rows = $this->membership_model->getTableRowNumbers("ReportGroups");
        $per_page = 10;        
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        $this->data['reportGroup'] = $this->membership_model->getTableDataWithLimit("ReportGroups",$per_page,$this->uri->segment(3));         
        $this->data['rightMenu'] = $this->mainName."/RightMenuReportGroup.php";
        $this->load->view("Home",$this->data); 
    }
    public function ReportGroupDetail($group_id = NULL)
    {
        if(!is_numeric($group_id))
        {
            $this->ReportGroup();
            return FALSE;
        }
        $this->load->model("reportregisterer_model");
        
        $this->data['groupData'] = $this->reportregisterer_model->getGroupByGroupID($group_id);
        $this->data['rightMenu'] = $this->mainName."/RightMenuReportGroupDetail.php";
        $this->load->view("Home",$this->data); 
        
    }
    public function ChangeReportGroupInformation($group_id = NULL)
    {
        if(!is_numeric($group_id))
        {
            $this->ReportGroup();
            return FALSE;
        }
        $this->load->library("form_validation");
        $this->load->library('input');
        $this->load->model("reportregisterer_model");
        $this->load->model("membership_model");
        
        $this->form_validation->set_rules("GroupName", "Group Name", "xss_clean|trim|required");
        $this->form_validation->set_rules("GroupDescription", "Group Description", "xss_clean|trim|required");
        if($this->form_validation->run() == FALSE)
        {
            
           $this->ReportGroupDetail($group_id);
           return FALSE;
        }
        
        $data = array(
            'GroupName'         =>  $this->input->post("GroupName"),
            'GroupDescription'  =>  $this->input->post("GroupDescription")
        );
        $admin_password = $this->input->post("CurrentPassword");
        // Check admin password is TRUE!
        if($this->membership_model->checkUserPassIsTrue($this->session->userdata("Username"),$admin_password))
        {
            if($this->reportregisterer_model->updateGroupInformationByID($group_id, $data))
               $this->data['process'] = 1;
            else
                $this->data['process'] = 2;
        } else {
            $this->data['process'] = 3;
        }
        $this->data['groupData'] = $this->reportregisterer_model->getGroupByGroupID($group_id);
        $this->data['rightMenu'] = $this->mainName."/RightMenuReportGroupDetail.php";
        $this->load->view("Home",$this->data);        
    }
    
    public function CreateNewGroup()
    {
        $this->load->library("form_validation");
        $this->load->library('input');
        $this->load->model("reportregisterer_model");
        $this->load->model("membership_model"); 
        
        $this->form_validation->set_rules("GroupName", "Group Name", "xss_clean|trim|required");
        $this->form_validation->set_rules("GroupDescription", "Group Description", "xss_clean|trim");
        if($this->form_validation->run() == FALSE)
        {
           $this->ReportGroup();
           return FALSE;
        }
        
        $data = array(
            'GroupName'         =>  $this->input->post("GroupName"),
            'GroupDescription'  =>  $this->input->post("GroupDescription")
        );
        $admin_password = $this->input->post("CurrentPassword");
        // Check admin password is TRUE!
        if($this->membership_model->checkUserPassIsTrue($this->session->userdata("Username"),$admin_password))
        {
            if($this->reportregisterer_model->createNewReportGroup($data))
               $this->data['process'] = 1;
            else
               $this->data['process'] = 2;
        } else {
            $this->data['process'] = 3;
        }        
        $this->ReportGroup();
        return FALSE;         
    }
    public function DeleteReportGroup($group_id = NULL)
    {
        if(!empty($group_id) and is_numeric($group_id))
        {   
            // group_id is not empty and its int.
            $this->load->model("reportregisterer_model");
            if(!$this->reportregisterer_model->isReportGroupExist($group_id))
                return $this->ReportGroup();
            $this->reportregisterer_model->deleteReportGroup($group_id);
            return $this->ReportGroup();           
        } else {
            // group_id is empty or not integer.
            
        }          
    }
    ####################### JOBS #########################
    public function JobManager()
    {
        $this->load->model("reportregisterer_model");
        $this->load->model("membership_model");
        
        $this->data['users'] = $this->membership_model->getAllUser();
        $this->data['reportGroups'] = $this->reportregisterer_model->getAllReportGroup();
        $this->data['rightMenu'] = $this->mainName."/RightMenuJobManager.php";
        $this->load->view("Home",$this->data);           
    }
    public function MyActiveJobs()
    {
        $this->load->model("pagination_model");        
        $this->load->model("job_model");

        $user_id = $this->session->userdata("UserID");
        $base_url = site_url()."/admin/MyCompletedJobs";
        $total_rows = $this->job_model->get_active_jobs_numnumber_by_userid($user_id);
        $per_page   = 10;    
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);  
        $this->data['user_jobs'] = $this->job_model->get_active_jobs_by_userid($user_id,$per_page,$this->uri->segment(3));
        foreach ($this->data['user_jobs'] as $key => $value) 
            {                                
                $this->data['user_jobs'][$key]['TotalLeftTime'] = (strtotime($value['EndDate']) - strtotime($value['StartDate']));                                        
            }                
        
        $this->data['rightMenu'] = "Job/RightMenuUserJob.php";
        $this->load->view("Home",$this->data);         
        
    }
    public function MyCompletedJobs()
    {
        $this->load->model("pagination_model");        
        $this->load->model("job_model");
        $user_id = $this->session->userdata("UserID");        
        $base_url = site_url()."/admin/MyCompletedJobs";
        $total_rows = $this->job_model->get_completed_jobs_rownumber_by_userid($user_id);
        $per_page   = 10;        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);                               
        $this->data['user_completed_jobs'] = $this->job_model->get_completed_jobs_by_userid($user_id,$per_page,$this->uri->segment(3));
        $this->data['rightMenu'] = "Job/RightMenuCompletedJob.php";
        $this->load->view("Home",$this->data);          
        
    }
    public function AllRuningJobs()
    {
        $this->load->model("pagination_model");        
        $this->load->model("job_model");
        $base_url = site_url()."/admin/AllRuningJobs";
        $total_rows = $this->job_model->get_all_running_jobs_rownumber();
        $per_page   = 10;        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        
        
        $this->data['all_runing_jobs'] = $this->job_model->get_all_runnig_jobs($per_page,$this->uri->segment(3));
        foreach ($this->data['all_runing_jobs'] as $key => $value) 
            {                                
                $this->data['all_runing_jobs'][$key]['TotalLeftTime'] = (strtotime($value['EndDate']) - strtotime($value['StartDate']));                                        
            }         
        $this->data['rightMenu'] = "Job/RightMenuRunningJob.php";
        $this->load->view("Home",$this->data);                  
    }
    public function AllCompletedJobs()
    {
        $this->load->model("pagination_model");        
        $this->load->model("job_model");
        $base_url = site_url()."/admin/AllCompletedJobs";
        $total_rows = $this->job_model->get_all_completed_jobs_rownumber();
        $per_page   = 10;        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);         
        $this->data['all_completed_jobs'] = $this->job_model->get_all_completed_jobs($per_page,$this->uri->segment(3));      
        $this->data['rightMenu'] = "Job/RightMenuAllCompletedJob.php";
        $this->load->view("Home",$this->data);                        
    }
    public function AddNewJob()
    {
        $this->load->library("form_validation");
        $this->load->library('input');     
        if( $this->input->get_post("datepicker") < date('m/d/Y',time()))
        {
            $this->data['job_errors'] = "Selected date is must be equal or bigger than current date";            
            $this->JobManager();
            return FALSE;
        }        
        $this->form_validation->set_rules("reportID", "Report", "numeric|trim|required");
        $this->form_validation->set_rules("groupID", "Group", "numeric|trim|required");
        $this->form_validation->set_rules("userID", "User", "numeric|trim|required");
        $this->form_validation->set_rules("hostID", "Host", "numeric|trim|required");
        $this->form_validation->set_rules("datepicker", "Date Picker", "trim|required|max_length[10]");
        $this->form_validation->set_rules("Description", "Description", "trim|required");
        
        if($this->form_validation->run() == FALSE)
        {            
            $this->JobManager();
            return FALSE;
        }
        // Everything is OK! Lets bind jobs.
        $this->load->model("job_model");
        $data = array(                        
            "UserID"      => $this->input->post("userID"),
            "HostID"      => $this->input->post("hostID"),
            "StartDate"   => date('Y/m/d',time()),
            "EndDate"     => date('Y/m/d',strtotime($this->input->post("datepicker"))),
            "Description" => $this->input->post("Description"),
            "ReportID"    => $this->input->post("reportID"),
            "GroupID"     => $this->input->post("groupID")                
        ); 
        $process = $this->job_model->create_new_job($data);
        if($process)
        {
            $this->data['job_success'] = 1;             
        }
        else
        {
            $this->data['job_errors'] = $process;
            $this->data['job_success'] = 0;
        }
        $this->JobManager();         
    }
    public function JobCancel()
    {
        $this->load->library("form_validation");
        $this->load->library('input');
        $this->load->model("job_model");
        $this->form_validation->set_rules("JobID", "Job ID", "numeric|trim|required");
        if($this->form_validation->run() == False)
        {
            $this->AllRuningJobs();
            return False;
        }
        if($this->job_model->job_cancel($this->input->post("JobID")) == TRUE)
        {
            $this->data['job_cancel_success'] =  1;
            $this->AllRuningJobs();            
        }            
        $this->data['job_cancel_success'] =  0;
        $this->AllRuningJobs();
    }
    public function JobComplete()
    {
        $this->load->library("form_validation");
        $this->load->library('input');
        $this->load->model("job_model");
        
        $this->form_validation->set_rules("JobID", "Job ID", "numeric|trim|required");        
        if($this->form_validation->run() == False)
        {
            $this->MyActiveJobs();
            return False;
        }        
        if($this->job_model->job_complete($this->input->post("JobID"), $this->session->userdata("UserID")) == True)                
        {
            $this->MyActiveJobs();
            return False;            
        }
            $this->MyActiveJobs();
            return False;        
    }
}

?>
