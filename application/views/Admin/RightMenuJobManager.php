    <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    ?>
    <link rel="stylesheet" href="<?=base_url()?>css/jquery-ui.css" />    
    <script src="<?=base_url()?>js/jquery-ui.js"></script>
    <script type="text/javascript">


    var istek =false;

    if (window.XMLHttpRequest)
    {
            istek = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
            istek = new ActiveXObject("Microsoft.XMLHTTP");
    }

    $(document).ready(function() {
            $( "#datepicker" ).datepicker();
        });


    function raporGetir()
    {		     
            var grupid = document.getElementById("grupsekmesi").value;        
            istek.open("GET", "<?=base_url()."index.php/ajaxhandler/get_reports_by_groupid/"?>"+grupid, true);        	
            istek.onreadystatechange=function()
                {                
                    if (istek.readyState==4 && istek.status==200)
                      {
                                    icerik = JSON.parse(istek.responseText);                                
                                    var options = '<option value="">Select</option>';                                
                                    for(var i = 0; i < icerik.length ; i++ )
                                        {                                        
                                            options += '<option value="' + icerik[i].ReportID + '">' + icerik[i].ReportName + '</option>';
                                        }
                                    document.getElementById("raporlar").innerHTML=options;                  
                      }
                };
            istek.send(null);
    }
    function ipGetir()
    {       
            var raporid = document.getElementById("raporlar").value;        
            istek.open("GET", "<?=base_url()."index.php/ajaxhandler/get_hosts_by_reportid/"?>"+raporid, true);        	
            istek.onreadystatechange=function()
                {                
                    if (istek.readyState==4 && istek.status==200)
                      {
                                    icerik = JSON.parse(istek.responseText);                                
                                    var optionsip = '<option value="">Select</option>';                                
                                    for(var i = 0; i < icerik.length ; i++ )
                                        {                                        
                                            optionsip += '<option value="' + icerik[i].HostID + '">' + icerik[i].Name + '</option>';
                                        }
                                    document.getElementById("ipler").innerHTML=optionsip;                  
                      }
                };
            istek.send(null);
    }

    </script>
    <div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> JOB ASSIGNMENT</h5>
                 <div class="text-warning">
                     <i class="icon-exclamation-sign"></i> 
                     Add new job to users.
                 </div>  
                 <div class="text-warning">
                     <i class="icon-exclamation-sign"></i> 
                     Dont leave blank * fields.
                 </div>               
                 <br>
                 <?php 
                 // Eger tarih mevcuttan kuçukse salla verdirt.              
                 if(isset($job_success))
                         echo '<div class="text-success"><b>Task was successfully created</b></div>';
                 if(isset($job_errors))
                 {
                         echo '<div class="text-error"><b>'.$job_errors."</b></div>";                
                 }             
                 echo '<div class="text-error"><b>'.validation_errors()."</b></div>";
                 echo form_open('admin/AddNewJob');
                 ?>
                 <div class="span4"> 
                 <fieldset>
                    <label class="control-label text-error">
                      Select a Report Group*
                    </label>
                    <select id="grupsekmesi" name="groupID" onChange="raporGetir()">
                        <option selected="selected"> Select </option>
                        <?php
                        foreach ($reportGroups as $value) {
                           echo '<option value="'.html_escape($value->GroupID).'">'.html_escape($value->GroupName).'</option>';
                        }
                        ?>
                    </select>
                    <div id="raporsekmesi">
                       <label class="control-label text-error">
                           Select a Report*
                       </label>                 
                       <select id="raporlar" name="reportID" onchange="ipGetir()"></select>  
                    </div>
                 </fieldset>                 
                 </div>
                 <div class="span4">
                     <fieldset>
                         <div id="descsekmesi">
                            <label class="control-label text-error">
                                Description*
                            </label>
                            <textarea name="Description" rows="5" type="text-area" id="Description"></textarea>                         
                         </div>
                     </fieldset>
                 </div>
                 <div class="span4">
                 <fieldset>                 
                    <div id="ipsekmesi">
                       <label class="control-label text-error">
                           Select a Host*
                       </label>                 
                       <select id="ipler" name="hostID"></select>  
                    </div>             
                    <div id="userlar">
                        <label class="control-label text-error">
                            Select a User*
                        </label>
                        <select id="users" name="userID">
                        <option value="">Select</option>
                        <?php
                           foreach ($users as $value) {
                              echo '<option value="'.html_escape($value->UserID).'">'.html_escape($value->Username).'</option>';
                           }
                        ?>
                        </select>
                    </div>
                 </fieldset>                 
                 </div>
                 <div class="span4">
                     <div>
                        <fieldset>                 
                            <div id="date">
                               <label class="control-label text-error">
                                       Select a Dead Line*
                               </label>
                               <input type="text" id="datepicker" name="datepicker" value="" />
                            </div>
                           <div id="save">  
                               <button type="submit" class="btn btn-primary">Save changes</button>                       
                           </div>
                        </fieldset>                      
                     </div>                
                 </div>                         
             </form>  
         </div>
        </div>
    </div><!--/row-->
