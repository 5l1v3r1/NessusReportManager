<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
?>
    <div class="span10">
         <div class="hero-unit golge-ve-gecikme">             
                 <h5 class="Main-Menu-Mehmet"><i class="icon-time"></i> USER TO DO LIST</h5>
                 <div class="text-warning">
                     <i class="icon-exclamation-sign"></i> 
                     All data sorted by "Dead Line" automatically!
                 </div> 
                 <br>
                 <?php
                 if(isset($job_cancel_success) and ($job_cancel_success == 1))
                 {
                     echo '<div class="text-success"><b>Task was successfully revoked</b></div>';
                 }
                 if(isset($job_cancel_success) and ($job_cancel_success == 0))
                 {
                     echo '<div class="text-error"><b>The task could not be revoked</b></div>';
                 }                  
                 ?>
                 <hr>
                 <?php                                  
                 echo '<div class="text-error">'.validation_errors()."</div>";   
                 // Sorting array by which job should done with immiadlity!               
                foreach ($all_runing_jobs as $key => $value) {
                    $now = new DateTime($value['StartDate']);
                    $ref = new DateTime($value['EndDate']);                    
                    $time_diff = $now->diff($ref);                                                                  
                 //}
                                                  
                 ?>
                 <div class="muted">
                     <i class="icon-flag"></i>                      
                         Job Number = <?=$value['JobID']?>                     
                 </div>                    
                 <div class="row-fluid">                                      
                 <div class="span4">
                     <b class ="text-error">Left Time : </b>
                     <?php
                     if($time_diff->y > 0)
                         echo  $time_diff->y ." Year ". $time_diff->m ." Month ". $time_diff->d." Day";
                     else if($time_diff->m > 0)
                         echo  $time_diff->m ." Month ". $time_diff->d." Day";
                     else
                         echo  $time_diff->d." Day";
                     ?>
                 </div>
                 
                 <div class="span4">
                     <b class ="text-warning">Job Start Date : </b> <?=$value['StartDate']?>
                 </div>             
                     
                 <div class="span4">
                     <b class ="text-warning">Job End Date : </b> <?=$value['EndDate']?>
                 </div>
                </div>                     
                <div class="row-fluid"> 
                    <div class="span4">
                        <b class ="text-warning">Job Owner : </b><b><?=$value['Username']?></b> 
                    </div>                    
                    <div class="span4">
                       <b class ="text-warning">Report Group : </b> <?=html_escape($value['GroupName'])?>
                    </div>
                    <div  class="">
                           <b class ="text-warning">Host/IP Name : </b> <?=html_escape($value['Name'])?>                 
                    </div>                   
                 </div>                     
                     <div class="">
                        <b class ="text-warning">Report Name : </b> <?=html_escape($value['ReportName'])?>
                    </div>
                 <br>
                 <div>
                     <b class ="text-warning">Description : </b> <?=html_escape($value['Description'])?>
                 </div>                                 
                <script LANGUAGE="JavaScript">
                <!--
                function confirmPost()
                {
                var agree=confirm("Are you sure ?");
                if (agree)
                return true ;
                else
                return false ;
                }
                // -->
                </script>    
                <br>    
                 <? 
                 echo form_open('admin/JobCancel/');
                 echo '<input type="hidden" name="JobID" value="'.$value['JobID'].'">';
                 echo '<button name="jobCompleted" value="1" type="submit" class="btn btn-warning" onclick="return confirmPost()"><b>Revoke</b></button>';
                 echo '<hr>';
                 }                                                  
                 ?>
            </div>
                <div class="pagination pagination-centered">
                    <ul>
                       <?=$links?> 
                    </ul>      
                </div>          
        </div>
    </div><!--/row-->
