<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of membership_model
 *
 * @author mince
 */
class Membership_model extends CI_Model {
    
   
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   /**
    * User Login Process Function
    * Checking username & password from database
    * Creating Session if it can validate!
    * Logging access and fail attemps
    * @param string $username
    * @param string $password
    * @param string $userip
    * @return boolean
    */
    public function Login($username,$password,$userip)
    {
            $this->db->where('Username',$username);
            $this->db->where('Password',sha1(md5($password)));
            $query = $this->db->get('Users');
            // Username and Password TRUE! Start session and log access login
            if($query->num_rows == 1){  
                foreach ($query->result() as $userinfo){}
                $sessionData = array(
                   'UserID'             => $userinfo->UserID,
                   'Username'           => $userinfo->Username,
                   'Mail'               => $userinfo->Mail,
                   'RegistrationDate'   => $userinfo->RegistrationDate,
                   'UserIdentify'       => $userinfo->UserIdentify,
				   'UserIP'				=> $userip,
                   'is_logged_in'       => TRUE
                );
                $this->session->set_userdata($sessionData);
                $this->_AccesLogin ($username, $userip);
                return true;
            }
            // Username and Password WRONG! is there any lamer ?!:) Start Logging
            if($query->num_rows == 0)
                $this->_FailLogin($username, $password,$userip);
            redirect("login");
            return false;
            
    }
    /**
     * Inserting fail login datas to database.
     * @param string $username
     * @param string $password
     * @param string $userip
     * @return blooean
     */
    private function _FailLogin($username,$password,$userip)
    {
            $data = array(
                    'Username'    => $username,
                    'Password'    => $password,
                    'IpAddress'   => $userip
            );
           return $this->db->insert('FailLogin',$data);
    }
    /**
     * Inserting access login datas to database.
     * @param string $username
     * @param string $password
     * @param string $userip
     * @return blooean
     */
    private function _AccesLogin($username,$userip)
    {
            $data = array(
                    'Username'    => $username,
                    'IpAddress'   => $userip
            );
            return $this->db->insert('AccessLogin',$data);

    }
    /**
     * Get all fail login datas with limitation
     * @param integer $per_page
     * @param integer $segment
     * @return boolean
     */
    public function getFailLogin($per_page,$segment)
    {
        $this->db->order_by("RequestTime", "DESC");
        $this->db->limit($per_page,$segment);
        $query = $this->db->get("FailLogin");
        return $query->result();
    }
    /**
     * Returning faillogin tables row numbers
     * @return integer 
     */
    public function getFailLoginRowNumbers()
    {
        $query = $this->db->get("FailLogin");
        return $query->num_rows();
    }
    /**
     * 
     * @param type $per_page
     * @param type $segment
     * @return type
     */
    public function getAccessLogin($per_page, $segment)
    {
        $this->db->order_by("RequestTime", "DESC");
        $this->db->limit($per_page,$segment);
        $query = $this->db->get("AccessLogin");
        return $query->result();
    }

    /**
     * get user info by usename
     * @return array 
     */
    public function getUserInfoByUsername($Username)
    {
        $this->db->where("Username", $Username);
        $query = $this->db->get("Users");
        return $query->result();                
    }
    /**
     * Get user information by UserID
     * @param integer $user_id
     * @return array
     */
    public function getUserInfoByID($user_id)
    {
        if($user_id == NULL)
            return FALSE;
        $this->db->where("UserID", $user_id);
        $query = $this->db->get("Users");
        return $query->result();                
    }
    /**
     * get table's datas by table name
     * @return array
     */    
    public function getTableData($table_name)
    {
        $query = $this->db->get($table_name);
        return $query->result();
    }
    /**
     * Get table data by table name and limitation
     * @return array 
     */    
    public function getTableDataWithLimit($table_name, $per_page, $segment)
    {
        $this->db->limit($per_page,$segment);
        $query = $this->db->get($table_name);
        return $query->result();
    }
    /**
     * get table row numbers by tablename
     * @return integer 
     */   
    public function getTableRowNumbers($table_name)
    {
        $query = $this->db->get($table_name);
        return $query->num_rows();
    }
    /**
     * Update user information by username
     * @return integer 
     */    
    public function updateUserInfoByUsername($data, $username)
    {
        $this->db->where('Username', $username);
        if($this->db->update('Users', $data))
            return TRUE;
        return FALSE;
    }
    /**
     * Update user information by userID
     * @param type $data
     * @param type $user_id
     * @return boolean
     */
    public function updateUserInfoByUserID($data, $user_id)
    {
        $this->db->where('UserID', $user_id);
        if($this->db->update('Users', $data))
            return TRUE;
        return FALSE;
    }    
    /**
     * check user password is true or false
     * @return boolean
     */    
    public function checkUserPassIsTrue($username,$password)
    {
            $this->db->where('Username',$username);
            $this->db->where('Password',sha1(md5($password)));
            $query = $this->db->get('Users');
            // Username and Password TRUE! Start session and log access login
            if($query->num_rows == 1)
                return TRUE;
            return FALSE;
    }
    
    /**
     * Creating User
     * @param array $user_data
     * @return boolean
     */
    public function createNewUser($user_data)
    {
        if($this->db->insert("Users",$user_data))
                return TRUE;
        return FALSE;
    }
    /**
     * Checking username is avaible
     * @param string $str
     * @return boolean
     */
    public function checkUsernameIsFree($str)
    {
            $this->db->where('Username',$str);
            $query = $this->db->get('Users');
            if($query->num_rows == 0)
                return TRUE;
            return FALSE;
    }
    /**
     * Checking mail is avaible
     * @param string $str
     * @return boolean
     */    
    public function checkMailIsFree($str)
    {
            $this->db->where('Mail',$str);
            $query = $this->db->get('Users');
            if($query->num_rows == 0)
                return TRUE;
            return FALSE;
    }
    
    public function deleteUserByID($user_id)
    {
        $this->db->delete("Users", array('UserID' => $user_id));
        if ($this->db->affected_rows() > 0)
            return TRUE;
        return FALSE;
    }
    
    public function getAllUser()
    {
        return $this->db->get("Users")->result();
    }
    
    
}

?>
