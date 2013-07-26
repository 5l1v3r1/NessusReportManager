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
                 echo '<div class="text-error">'.validation_errors()."</div>";   
                 // Sorting array by which job should done with immiadlity!
                function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
                    $sort_col = array();
                    foreach ($arr as $key=> $row) {
                        $sort_col[$key] = $row[$col];
                    }

                    array_multisort($sort_col, $dir, $arr);
                }                
                array_sort_by_column($user_jobs, 'TotalLeftTime');                 
                foreach ($user_jobs as $key => $value) {
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
                        <b class ="text-warning">Report Group : </b> <?=html_escape($value['GroupName'])?>
                    </div>
                     <div class="span8">
                        <b class ="text-warning">Report Name : </b> <?=html_escape($value['ReportName'])?>
                    </div>
                 </div>
                 <div  class="">
                        <b class ="text-warning">Host/IP Name : </b> <?=html_escape($value['Name'])?>
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
                 echo form_open('admin/JobComplete/');
                 echo '<input type="hidden" name="JobID" value="'.$value['JobID'].'">';
                 echo '<button name="jobCompleted" value="1" type="submit" class="btn btn-info" onclick="return confirmPost()"><b>Finished</b></button>';
                 echo '<hr>';
                 }                                                  
                 ?>            
                <div class="pagination pagination-centered">
                    <ul>
                       <?=$links?> 
                    </ul>      
                </div>                    
        </div>
    </div><!--/row-->
