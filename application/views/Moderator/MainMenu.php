<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Moderator MainMenu
$this->load->model("globaldata_model");
$this->globaldata_model->ModeratorSessionCheck();

$this->load->view("Moderator/LeftMenu");
$this->load->view($rightMenu);
?>
