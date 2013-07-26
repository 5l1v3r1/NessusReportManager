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
class Search_model extends CI_Model{
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
        $this->load->database();
    }
 
    function get_report_stats()
    {
        $query = $this->db->get("ReportGroups");
        $result = $query->result_array();
        // Counting Report Number of each Group
        foreach ($result as $key => $value) {
            $temp = $this->db->get_where("Reports", array("GroupID" => $value['GroupID']));
            $result[$key]['ReportList'] = $temp->result_array();
            $result[$key]['ReportCount'] = $temp->num_rows();
        }
        return $result;
    }
}
?>
