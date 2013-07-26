<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlobalData
 *
 * @author mince
 */
class GlobalData_model extends CI_Model{
    /**
     * Keeping Global Datas -required by footer, header etc- in this array.
     * 
     * @var private string array
     * @access private
     */
    private $data = array();
    
    function __construct() 
    {
        parent::__construct();
        $this->data['title'] = "Nessus Report Manager";
        $this->data['version'] = "v0.3a";
        $this->data['companyName'] = "Garanti Bank";
        $this->data['developerCompanyName'] = "";
        $this->data['year'] = "2012";
        $this->data['startDate'] = "16 September 2012";
        $this->data['latestUpdate'] = "26 September 2012";
        $this->data['projectManager'] = "Mehmet Dursun İnce";
        $this->data['developers'] = "Mehmet Dursun İnce - Barkın Kılıç";
        $this->data['header'] = $this->data['title']." ".$this->data['version'];
        $this->data['footer'] = $this->data['companyName']." © " . $this->data['year'];
    }
    /**
     * Getting all global data for use template!
     * @return type array
     */
    public function GetGlobalDataArray()
    {
        return $this->data;
    }
   /**
    * Chechking user session to access login or admin area
    * @return boolean
    */
    public function isLoggedIn()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');	
	if(isset($is_logged_in) and $is_logged_in == true)
            return true;
        return false;
            
    }
    /**
     * Checking user session and redirecting she/he. i guess she:)
     */
    public function LoginControl()
    {
        if(!$this->isLoggedIn())
            redirect("login");
    }
    /**
     * Checking Moderator identify.
     * @return boolean
     */
    public function isModerator()
    {
        if($this->session->userdata("UserIdentify") == 2)
            return true;
        return false;
    }
    /**
     * Checking moderator session. 
     * If user have not Moderator permission. Kill all session and redirect it login page!
     */
    public function ModeratorSessionCheck()
    {
        if(!$this->isModerator()){
            $this->session->sess_destroy();
            redirect ("login");
        }
    }
    /**
     * Checking Administrator identify
     * if user have an administrator permission return TRUE;
     * @return boolean
     */
    public function isAdmin()
    {
        if($this->session->userdata("UserIdentify") == 1)
            return true;
        return false;
    }
    /**
     * if she is NOT administrator. Redirect to login area.
     */
    public function AdminSessionCheck()
    {
        if(!$this->isAdmin())
        {
            $this->session->sess_destroy();
            redirect ("login");
        }
    }
    /**
     * Auto redirection According to user's identifiers
     */
    public function AutoRedirect()
    {
        if($this->isAdmin())
            redirect ("admin","index");
        if($this->isModerator())
            redirect ("moderator","index");
        redirect("login");
    }
}
?>
