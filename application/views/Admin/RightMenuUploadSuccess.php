<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
print_r(@$reportregister_erros);
?>
<div class="span10">      
  <div class="hero-unit golge-ve-gecikme">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row-fluid">
            <h5 class="Main-Menu-Mehmet"><i class="icon-ok"></i> report Successfully Added Crontab Manager!</h5>
            <div>
                <?php
                if(!empty($reportInfo))
                {
                        echo '<div class="alert">';
                        echo '<p><b>Report Name</b> : ' . html_escape($reportInfo['ReportName']) ."</p>";
                        echo '<p><b>Report Owner</b> : '. $this->session->userdata("Username") . "</p>";
                        echo '<p><b>Report Description</b> : ' . html_escape($reportInfo['ReportDescription']) ."</p>";
                        echo '<p><b>Report Inserted Date</b> : '. html_escape($reportInfo['InsertDate']) . "</p>";
                        echo '<p><b>Report CheckSum</b> :'. html_escape($reportInfo['CheckSum'])."</p>";
                        echo '<p><b>Report Physical Name</b> : '. html_escape($reportInfo['ReportPath']) . "</p>";
                        echo '<p><b>Report InsertDate</b> :' . html_escape($reportInfo['InsertDate']) . "</p>";                    
                        echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="text-error">
            <h4><i class="icon-exclamation-sign"></i> When processing of the report is finished, you will see raport in "Reports" section!</h4>
        </div>
  </div>
</div>