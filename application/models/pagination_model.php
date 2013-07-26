<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pagination_model
 *
 * @author mince
 */
class pagination_model extends CI_Model{
    /**
     * Keeping all pagination's data in this array.
     * @var array string 
     */
    var $config = array();
    function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        
        $this->config['full_tag_open'] = '<div class="pagination"><ul>';
        $this->config['full_tag_close'] = '</ul></div>';
        $this->config['first_link'] = false;
        $this->config['last_link'] = false;
        $this->config['first_tag_open'] = '<li>';
        $this->config['first_tag_close'] = '</li>';
        $this->config['prev_link'] = '&larr; Previous';
        $this->config['prev_tag_open'] = '<li class="prev">';
        $this->config['prev_tag_close'] = '</li>';
        $this->config['next_link'] = 'Next &rarr;';
        $this->config['next_tag_open'] = '<li>';
        $this->config['next_tag_close'] = '</li>';
        $this->config['last_tag_open'] = '<li>';
        $this->config['last_tag_close'] = '</li>';
        $this->config['cur_tag_open'] =  '<li class="active"><a href="#">';
        $this->config['cur_tag_close'] = '</a></li>';
        $this->config['num_tag_open'] = '<li>';
        $this->config['num_tag_close'] = '</li>';
        
    }
    /**
     * Main pagination method. Users'll  call only that!
     * 
     * @param string $url
     * @param integer $total_rows
     * @param integer $per_page
     * @return paginationLink
     */
    function preparePagination($url , $total_rows, $per_page = 5)
    {
        $this->_setBaseUrl($url);
        $this->_setTotalRows($total_rows);
        $this->_setPerPageNumber($per_page);
        $this->_initialize();
        return $this->pagination->create_links();
    }
    /**
     * Pushin array row numbers.
     * @param integer $rows_number
     * @return boolean
     */
    private function _setTotalRows($rows_number)
    {
        $this->config['total_rows'] =$rows_number;
        return true;
    }
    /**
     * How much row will show on everypage!
     * @param integer $per_page
     * @return boolean
     */
    private function _setPerPageNumber($per_page = 5)
    {
        $this->config['per_page'] = $per_page;
        return true;
    }
    /**
     * Form's base url!
     * @param string $base_url
     * @return boolean
     */
    private function _setBaseUrl($base_url)
    {
        $this->config['base_url'] = $base_url;
        return true;
    }
    /**
     * Create links!
     * @return boolean
     */
    private function _initialize()
    {
        $this->pagination->initialize($this->config);
        return true;
    }
}

?>
