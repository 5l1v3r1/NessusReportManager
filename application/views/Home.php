<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<LINK REL=StyleSheet HREF="<?=base_url()?>css/wnessus.css">
        <LINK REL=StyleSheet HREF="<?=base_url()?>css/bootstrap.css">
	<script type="text/javascript" src="<?=base_url()?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery1-8-1.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/googlechart.js"></script>
	<style type="text/css">
      body {
      	padding-top: 120px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
</head>
<!-- Header Start -->
<?php $this->load->view("Include/header")?>
<!-- Header End -->
<!-- Main Body Start -->
<div class="container-fluid">
    
      <?php 

      $this->load->view($mainMenu);
      
      ?>
    

</div><!--/.fluid-container-->
<!-- Main Body End -->
<!-- Footer Start -->
<?php $this->load->view("Include/footer");?>
<!-- Footer End -->
</body>
</html>