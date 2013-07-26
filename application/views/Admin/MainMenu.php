<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Admin MainMenu
$this->load->model("globaldata_model");
$this->globaldata_model->AdminSessionCheck();

$this->load->view("Admin/LeftMenu");
$this->load->view($rightMenu);
?>
