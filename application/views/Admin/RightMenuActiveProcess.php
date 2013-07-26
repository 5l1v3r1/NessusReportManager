<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> ACTIVE PROCESS</h5>
                 <div class="text-warning"><i class="icon-info-sign"></i> All data sorted by "Time" automatically!</div>
                 <div class="text-error"><i class="icon-info-sign"></i> Our AIMS application working on these reports..!</div>
                 <br>
                 <table class="table table-striped alert">
                    <style>
                     table { table-layout: fixed; }
                     table th, table td { overflow: hidden; }
                 
                    </style>                       
                    <thead>
                      <tr>                         
                        <th style="width: 8%;">Report ID</th>
                        <th style="width: 10%;">Report Owner</th>
                        <th style="width: 60%;">Report Name</th>
                        <th style="width: 12%;">Report Date</th>                        
                        <th style="width: 10%;">Report Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reportInfo as $row){ ?>
                      <tr>                        
                        <td><?=html_escape($row->ReportID)?></td>
                        <td><?=html_escape($row->UserID)?></td>
                        <td><?=html_escape(nl2br($row->ReportName))?></td>
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
