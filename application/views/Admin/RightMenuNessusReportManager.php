<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
function setReportName()
{
var path = document.getElementById("userfile").value; 
var pos =path.lastIndexOf( path.charAt( path.indexOf(":")+1) ); 
var filename = path.substring( pos+1);
document.getElementById("ReportName").value = filename;

}
</script>
<div class="span10">      
  <div class="hero-unit golge-ve-gecikme">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row-fluid">            
                 <div class="text-warning">
                     <i class="icon-exclamation-sign"></i>
                     Please select .nessus report file ( Max Size 10MB )<br>
                     <i class="icon-exclamation-sign"></i>
                     <b>Report Name</b> and <b>Report Descriptrions</b> fields are important! Please write all information about current report.                    
                 </div>
            <br>
                <?php
                echo '<div class="text-error"><b>'.validation_errors()."</b></div>";
                if(!empty($error))
                {
                   foreach ($error as $value)
                       {
                       echo '<div class="text-error"><b>'.$value.'</b></div>'; 
                       }                    
                }
                // there is same checksume at database with that report.
                if(is_array(@$db_report_info))
                {
                    echo '<div class="alert"><p><i class="icon-remove"></i><span> We have a same report with your file!</p>';
                    foreach ($db_report_info as $row)
                    {
                        echo '<p><b>Report Name</b> : ' . html_escape($row->ReportName) ."</p>";
                        echo '<p><b>Report Owner</b> : '. html_escape($db_report_owner_info[0]->Username) . "</p>";
                        echo '<p><b>Report Description</b> : ' . html_escape($row->ReportDescription) ."</p>";
                        echo '<p><b>Report Inserted Date</b>: '. html_escape($row->InsertDate) . "</p>";
                        echo '<p><b>Report Physical Name</b>: '. html_escape($row->ReportPath) . "</p>";
                    }
                    echo '</span></div>';
                }
                    
                    
                unset($db_report_info);
                ?>
                <?php echo form_open_multipart('admin/do_NessusUpload');?>
                <fieldset>
                <div class="span4">
                    <label class="control-label text-error">
                        Report Name
                    </label> 
                    <div class="controls">
                        <input name="ReportName" type="text" class="input-large" id="ReportName" value="">
                    </div>
                    <label class="control-label text-error">
                        Report Description
                    </label> 
                    <div class="controls">
                        <textarea name="ReportDescription" rows="5" type="text-area" id="ReportDescription" value=""></textarea>
                    </div>                    
                </div>
                <div class="span4">
                    <label class="control-label text-error">
                        Report Group
                    </label>
                    <div>
                        <select name="ReportGroup" id ="ReportGroup">
                            <?php
                                foreach ($reportGroup as $value) {
                                    echo ' <option value="'.html_escape($value->GroupID).'">'.html_escape($value->GroupName).'</option>';
                                }
                            ?>
                        </select>                        
                    </div>
                    <label class="control-label text-error">
                        Choose a Nesuss File
                    </label>  
                    <div class="controls">
                        <input id="userfile" type="file" name="userfile" onchange="setReportName()">
                    </div>                    
                    <div class="">
                        <input class="btn btn-primary start" type="submit" value="Upload" />
                    </div>                    
                </div>                   
            </div>
          </fieldset>                 
        </form>
        </div>              
    </div>
</div>