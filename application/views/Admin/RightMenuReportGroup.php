<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> REPORT GROUPS</h5>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> All data sorted by "ID" automatically!</div>
                 <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Detail</th>  
                        <th>Report Group ID</th>                        
                        <th>Report Group Name</th>                                               
                        <th>Report Group Description</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reportGroup as $row){?>
                      <tr>
                        <td><a class="muted" href="<?=base_url()."index.php/admin/ReportGroupDetail/"?><?=$row->GroupID?>">Edit</a></td>
                        <td><?=html_escape($row->GroupID)?></td>
                        <td><?=html_escape($row->GroupName)?></td>
                        <td><?=html_escape($row->GroupDescription)?></td>
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
             <hr>
             <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> CREATE REPORT GROUP</h5>
             <div class="text-warning"><i class="icon-exclamation-sign"></i> Create a new report group!</div>
<?php 
                 echo form_open('admin/CreateNewGroup/');
                 
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$process == 1)
                     echo '<p class="text-success"><i class="icon-ok"></i> Information has been changed</p>';
                 else if (@$process==2) 
                     echo '<p class="text-error"><i class="icon-remove"></i> Something went wrong</p>';
                 else if (@$process==3)
                     echo '<p class="text-error"><i class="icon-remove"></i> Your password is wrong</p>';                 
                 ?>
                <fieldset>
                        <div class="span4">                             
                            <label class="control-label text-error" for="Name">
                                Group Name
                            </label>  
                            <div class="controls">  
                                <input name="GroupName" type="text" class="input-large" id="GroupName" value=" ">
                            </div>
                            <label class="control-label text-error" for="Name">
                                Group Description
                            </label>  
                            <div class="controls">  
                                <textarea name="GroupDescription" type="text" class="input-large" id="GroupDescription"></textarea>
                            </div>  
                            <label class="control-label text-error" for="CurrentPassword">
                                <b>Your Current Password</b>
                            </label>  
                            <div class="controls">  
                                <input name="CurrentPassword" type="password" class="input-large" id="Email" value="">
                            </div>                             
                            <div class="">  
                                <button type="submit" class="btn btn-primary">Save changes</button>  
                                <button class="btn">Cancel</button>  
                            </div> 
                        </div> 
                     </fieldset>
                 </form>                    
     </div>
</div><!--/row-->
