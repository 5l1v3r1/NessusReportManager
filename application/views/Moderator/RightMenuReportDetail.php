<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span9">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> REPORT DETAILS</h5>
                 <div>
                     <b class ="text-success">Report ID : </b><?=html_escape($report_data->ReportID)?>
                 </div>                 
                 <br>
                 <div>
                     <b class ="text-success">Report Name : </b><?=html_escape($report_data->ReportName)?>
                 </div>
                 <br>
                 <div>
                     <b class ="text-success">Report Owner: </b><?=html_escape($report_data->UserID)?>
                 </div>
                 <br>
                 <div>
                     <b class ="text-success">Report Insert Date: </b><?=html_escape($report_data->InsertDate)?>
                 </div>
                 <br>
                 <div>
                     <b class ="text-success">Report Checksum: </b><?=html_escape($report_data->CheckSum)?>
                 </div>
                 <br>
                 <div>
                     <b class ="text-success">Report Path: </b><i><?=html_escape($report_data->ReportPath)?></i>
                 </div>
                 <br>
                 <div>
                     <b class ="text-success">Report Description: </b><?=html_escape($report_data->ReportDescription)?>
                 </div>
                 <br>
                 <div>
                     <a class="btn btn-primary" href="<?= base_url()."index.php/reportgenerator/reportByHosts/".html_escape($report_data->ReportID)?>" target="_blank">
                         Get Report by Hosts
                     </a>
                     <a class="btn btn-warning" href="<?= base_url()."index.php/reportgenerator/reportByVulns/".html_escape($report_data->ReportID)?>" target="_blank">
                         Get Report by Vulnerabilities 
                     </a>
                     <a class="btn btn-success" href="<?= base_url()."index.php/reportgenerator/FullyreportByVulns/".html_escape($report_data->ReportID)?>" target="_blank">
                         Fully Report by Hosts 
                     </a>
                     <a class="btn btn-success" href="<?= base_url()."index.php/reportgenerator/FullyReportByVulns/".html_escape($report_data->ReportID)?>" target="_blank">
                         Fully Report by Vulnerabilities 
                     </a>                     
                 </div>
         </div>
     </div>
</div><!--/row-->
