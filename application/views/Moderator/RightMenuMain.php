<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$this->load->helper("systeminfo");
?>
<div class="span9">
          <div class="hero-unit golge-ve-gecikme">
            <div class="row-fluid">
                <div class="span4">
                  <h5 class="Main-Menu-Mehmet"><i class="icon-signal"></i> SYSTEM PERFORMANCE</h5>
                    <p class="text-error"><b>Uptime: </b><?= ServerUptime()?></p>
                    <p class="text-error"><b>Load Average:</b> <?=ServerLoadAverage()?></p>
                    <p class="text-error"><b>CPU Usage: </b><?= ServerCpuUsage()?></p>
                    <p class="text-error"><b>RAM Usage:</b> <?= ServerRamUsage()?></p>
                    <p class="text-error"><b>Disk Usage:</b> <?= ServerDiskUsage()?></p>
                    
                </div><!--/span-->
                <div class="span4">
                  <h5 class="Main-Menu-Mehmet"><i class="icon-user"></i> USER INFORMATION</h5>
                    <p class="text-success"><b>Username: </b><?=$this->session->userdata('Username');?></p>
                    <p class="text-success"><b>Email:</b> <?=$this->session->userdata('Mail');?></p>
                    <p class="text-success"><b>Registration Date:</b> <?=$this->session->userdata('RegistrationDate');?></p>
                    <p class="text-success"><b>Browser:</b> <?php echo $this->agent->browser()." ";echo $this->agent->version()?></p>
                    <p class="text-success"><b>Ip Address:</b> <?=$this->session->userdata('ip_address');?></p>
                </div><!--/span-->
            </div>
          </div>
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-align-right"></i> LASTEST ACTIVITIES</h5>
                 <table class="table table-striped ">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nessus Name</th>
                        <th>Date</th>
                        <th>Username</th>
                        <th>Physical Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>BGA-2012-TEST.nessus</td>
                        <td>2012-09-19 12:18:02</td>
                        <td>admin</td>
                        <td>bga-2012-test-12:18:02.nessus</td>
                      </tr>
                    </tbody>
                </table>
                 
                        
             </div>
         </div>
</div><!--/row-->