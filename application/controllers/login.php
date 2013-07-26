<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author mince
 */
class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("globaldata_model");
    }
    
    public function index()
    {
        // if user already login => redirect she!
        $userIdentify = $this->session->userdata("UserIdentify");
        if($userIdentify == 1) //She is admin!
            redirect ("admin");
        else if ($userIdentify == 2 ) //She is moderator!
            redirect ("moderator");
        
        $data['mainMenu'] = "Login/Login.php";
        $data += $this->globaldata_model->GetGlobalDataArray();
        $this->load->view("Home",$data);
    }
    /*
     * Destroy user session and redirect it login page!
     */
    public function Logout()
    {
        $this->session->sess_destroy();
        redirect("login");
    }
    /*
     * Getting user input and filtering it
     * Checking user's login process is access or fail
     * Redirecting user according to login process!
     */
    public function ValidateCredentials()
    {
        // Loading nessecery modul and library
        $this->load->model("membership_model");
        $this->load->library('form_validation');
        $this->load->library('input');
        
        // Form Validation and Input filtering for preventing XSS!
        $this->form_validation->set_rules("Username","Username", "xss_clean|trim|required|min_length[4]");
        $this->form_validation->set_rules("Password","Password","xss_clean|trim|required|min_length[4]");
        
        if($this->form_validation->run()==FALSE)
        {
           $this->index();
           return false;
        }
        
        $username = $this->input->post('Username');
        $password = $this->input->post('Password');
        $userip   = $this->input->ip_address();
        if($this->membership_model->login($username,$password,$userip)){
            $this->globaldata_model->AutoRedirect();        
        } 
        $this->index();
        return true;
    }
}
?>
