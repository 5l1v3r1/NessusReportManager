<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author mince
 */
class Main extends CI_Controller{
    
    function __construct() 
    {
        parent::__construct();
        $this->load->model("globaldata_model");
    }
    
    public function index()
    {
        /**
         * Checking she's session and redirect she!
         */
        $this->globaldata_model->AutoRedirect();        
    } 
}

