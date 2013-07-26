<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title." Advanced Search Engin"?></title>
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
<?php $this->load->view("Include/header");?>
<!-- Header End -->
<!-- Main Body Start -->
<center>
    <b class ="text-warning">ADVANCED SEARCH MODUL</b>
</center>
<br>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <div class="well sidebar-nav golge-ve-gecikme">
                <ul class="nav nav-list">
                    <li class="nav-header">Dashboard</li>
                    <li><a href="<?=base_url()?>index.php/admin">Report Stats</a></li>                                            
                </ul>
            </div><!--/.well -->
        </div><!--/span-->    
        <div class="span10">
        <?php $this->load->view($right_menu); ?>
            <div class="hero-unit golge-ve-gecikme">
                <div class="row-fluid">
                    <h5 class="Main-Menu-Mehmet">
                        <i class="icon-file"></i>
                        Report Stats
                    </h5>
                </div>
                <hr>
                <?
                foreach ($report_stats as $key => $value) {                                    
                ?>
                <div class="row-fluid">
                    <div class="span4">
                        <b class ="text-warning">Group Name : </b> <?=html_escape($value['GroupName']);?>
                    </div>
                    <div class="span4">
                        <b class ="text-warning">Total Report Number : </b> <?=html_escape($value['ReportCount']);?>
                    </div>
                </div> 
                <div class="">
                    <b class ="text-warning">Report Name List : </b>
                </div>
                <?php
                foreach ($value['ReportList'] as $key_2 => $reports) {
                ?>
                <section>
                    
                        <li><?= html_escape($reports['ReportName']);?></li>
                   
                </section>
                <?
                }
                ?>
                <hr>
                <? } ?>
            </div>
        </div>
    </div><!--/row-->    
</div>
<!--/.fluid-container-->
<!-- Main Body End -->
<!-- Footer Start -->
<?php $this->load->view("Include/footer");?>
<!-- Footer End -->
</body>
</html>