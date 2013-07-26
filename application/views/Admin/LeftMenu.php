<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
    <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav golge-ve-gecikme">
            <ul class="nav nav-list">
              <li class="nav-header">Dashboard</li>
              <li><a href="<?=base_url()?>index.php/admin">Home</a></li>
              <li><a href="<?=base_url()?>index.php/admin/Users">Users</a></li>
              <li><a href="<?=base_url()?>index.php/admin/UserAdd">Create New user</a></li>
              <li><a href="<?=base_url()?>index.php/admin/MyActiveJobs">My Active Jobs</a></li>
              <li><a href="<?=base_url()?>index.php/admin/MyCompletedJobs">My Completed quests</a></li>             
              <li class="nav-header">Job Assignment</li>
              <li><a href="<?=base_url()?>index.php/admin/JobManager">Add New Job</a></li>
              <li><a href="<?=base_url()?>index.php/admin/AllRuningJobs">Runing Jobs</a></li>
              <li><a href="<?=base_url()?>index.php/admin/AllCompletedJobs">Completed Jobs</a></li>
              <li class="nav-header">Search Manager</li>
              <li><a href="<?=base_url()?>index.php/search/">Search</a></li>
              <li class="nav-header">Nessus Report Manager</li>
              <li><a href="<?=base_url()?>index.php/admin/ActiveProcess">Active Process</a></li>
              <li><a href="<?=base_url()?>index.php/admin/NessusReportManager">Nessus Upload</a></li>
              <li><a href="<?=base_url()?>index.php/admin/Reports">Reports</a></li>
              <li><a href="<?=base_url()?>index.php/admin/ReportGroup">Report Groups Manager</a></li>
              <li class="nav-header">System Monitoring</li>
              <li><a href="<?=base_url()?>index.php/admin/AccessLogin">Last Logins</a></li>
              <li><a href="<?=base_url()?>index.php/admin/FailLogin">Failed Login Attempts</a></li>
              <li class="nav-header">Other</li>
              <li><a href="<?=base_url()?>index.php/admin/Contact">Contact & Feedback</a></li>
              <li><a href="<?=base_url()?>index.php/admin/Information">Information</a></li>
              <li><a href="<?=base_url()?>index.php/login/Logout" class="text-error">Logout</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->