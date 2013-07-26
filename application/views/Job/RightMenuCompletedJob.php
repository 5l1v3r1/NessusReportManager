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
                 <hr>
                 <?php                                                
                foreach ($user_completed_jobs as $key => $value) {                                                              
                 //}                                                  
                 ?>
                 <div class="muted">
                     <i class="icon-flag"></i>                      
                         Job Number = <?=$value->JobID?>                     
                 </div>                    
                 <div class="row-fluid">                                                       
                    <div class="span4">
                        <b class ="text-warning">Job Start Date : </b> <?=$value->StartDate?>
                    </div>
                    <div class="span4">
                        <b class ="text-warning">Job End Date : </b> <?=$value->EndDate?>
                    </div>
                 </div>
                <div class="row-fluid"> 
                     <div class="span4">
                        <b class ="text-warning">Report Group : </b> <?=html_escape($value->GroupName)?>
                    </div>
                     <div class="span8">
                        <b class ="text-warning">Report Name : </b> <?=html_escape($value->ReportName)?>
                    </div>
                 </div>
                 <div  class="">
                        <b class ="text-warning">Host/IP Name : </b> <?=html_escape($value->Name)?>
                 </div>                     
                 <br>
                 <div>
                     <b class ="text-warning">Description : </b> <?=html_escape($value->Description)?>
                 </div>                                                          
                 <hr>
                 <?php } ?>
                <div class="pagination pagination-centered">
                    <ul>
                       <?=$links?> 
                    </ul>      
                </div>                 
        </div>
    </div><!--/row-->
