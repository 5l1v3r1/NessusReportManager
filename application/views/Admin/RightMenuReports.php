<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> REPORTS</h5>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> All data sorted by "Time" automatically!</div>
                 <table class="table table-striped">
                    <style>
                     table { table-layout: fixed; }
                     table th, table td { overflow: hidden; }
                 
                    </style>                     
                    <thead>
                      <tr>
                        <th style="width: 8%;">Detail</th>  
                        <th style="width: 10%">Report ID</th>
                        <th style="width: 12%">Report Owner</th>
                        <th style="width: 60%">Report Name</th>
                        <th style="width: 10%">Report Date</th>                                               
                      </tr>
                    </thead>                   
                    <tbody>
                      <?php foreach($reportInfo as $row){?>
                        <tr>
                        <td><a class="muted" href="<?=base_url()."index.php/admin/ReportDetail/"?><?=$row->ReportID?>">Details</a></td>
                        <td><?=html_escape($row->ReportID)?></td>
                        <td><?=html_escape($row->UserID)?></td>
                        <td><?=html_escape(nl2br($row->ReportName))?></td>
                        <td><?=html_escape($row->InsertDate)?></td>                                                
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
