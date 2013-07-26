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
class Moderator extends CI_Controller{
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
        $this->globaldata_model->ModeratorSessionCheck();
        
        $this->mainName = "Moderator";
        $this->data = $this->globaldata_model->GetGlobalDataArray();
        $this->data['mainMenu']  = $this->mainName."/MainMenu.php";
    }
    
    function __destruct() {
        unset($this->data);
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
     * User Settings modul for use can change own information
     */
    public function UserSettings()
    {
        $user_name = $this->session->userdata("Username");
        $this->data['userInfo']  = $this->membership_model->getUserInfoByUsername($user_name);
        $this->data['rightMenu'] = $this->mainName."/RightMenuUserSettings.php";
        $this->load->view("Home",$this->data);
        
    }
    /**
     * User can change own information.
     */
    public function ChangeUserInformation()
    {
        // Loading nessecery library
        $this->load->library('form_validation');
        $this->load->library('input');
        
        // Form Validation and filtering for preventing XSS!
        $this->form_validation->set_rules("Mail","Mail","xss_clean|trim|required|valid_email");
        $this->form_validation->set_rules("Name","Name","xss_clean|trim|required");
        $this->form_validation->set_rules("CurrentPassword","Current Password","xss_clean|trim|required|min_length[6]");
        $this->form_validation->set_rules("NewPassword","New Password","xss_clean|trim|required|min_length[6]");
        $this->form_validation->set_rules("NewPassword2","Again New Password","xss_clean|trim|required|min_length[6]");

        if($this->form_validation->run() == FALSE)
        {
            $this->UserSettings(); 
          
        } else {
                // Prepare array to send query
                $prepare_input = array(
                    'Username' => $this->session->userdata("Username"),
                    'Mail'     => $this->input->post("Mail"),
                    'Name'     => $this->input->post("Name"),
                    'Surname'  => $this->input->post("Surname"),
                    'Password' => sha1(md5($this->input->post("NewPassword")))
                );
                // if user enter same new password
                if($this->input->post("NewPassword") == $this->input->post("NewPassword2"))
                {
                    $current_password = $this->input->post("CurrentPassword");
                    $user_name        = $this->session->userdata("Username");
                    if($this->membership_model->checkUserPassIsTrue($user_name, $current_password))
                    {
                        if($this->membership_model->updateUserInfoByUsername($prepare_input,$user_name))
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
                    // enter password is not same!
                    $this->data['process'] = 4; 
                }
                $this->UserSettings(); 
            }
            
        }
    public function Reports()
    {
        $this->load->model('pagination_model');
        $this->load->model("reportregisterer_model");                
        
        $base_url = site_url()."/moderator/Reports";
        $total_rows = $this->reportregisterer_model->getProcessedReportsRowNumbers();
        $per_page = 10;
        
        $this->data['links'] = $this->pagination_model->preparePagination($base_url,$total_rows,$per_page);        
        $this->data['reportInfo']  = $this->reportregisterer_model->getProcessedReports();        
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

}

?>
