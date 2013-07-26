<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span9">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> REPORTS</h5>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> All data sorted by "Time" automatically!</div>
                 <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Detail</th>  
                        <th>Report ID</th>
                        <th>Report Owner</th>
                        <th>Report Name</th>
                        <th>Report Date</th>                        
                        <th>Report Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reportInfo as $row){?>
                      <tr>
                        <td><a class="muted" href="<?=base_url()."index.php/moderator/ReportDetail/"?><?=$row->ReportID?>">Details</a></td>
                        <td><?=html_escape($row->ReportID)?></td>
                        <td><?=html_escape($row->UserID)?></td>
                        <td><?=html_escape($row->ReportName)?></td>
                        <td><?=html_escape($row->InsertDate)?></td>                        
                        <td><?=html_escape($row->ReportPath)?></td>
                      </tr>
                     <?php } ?>
                    </tbody>
                </table>
                <div class="pagination pagination-centered">
                    <ul>
                       <?=$links?> 
                    </ul>      
                </div>
         </div>
     </div>
</div><!--/row-->
