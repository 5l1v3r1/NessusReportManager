<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span9">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-tag"></i> REPORT GROUP DETAIL</h5>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> You can change report group informations!</div>
                 <?php 
                 echo form_open('admin/ChangeReportGroupInformation/'.$groupData->GroupID);
                 
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$process == 1)
                     echo '<p class="text-success"><i class="icon-ok"></i> Group has been created</p>';
                 else if (@$process==2) 
                     echo '<p class="text-error"><i class="icon-remove"></i> Something went wrong</p>';
                 else if (@$process==3)
                     echo '<p class="text-error"><i class="icon-remove"></i> Your password is wrong</p>';               
                 ?>
<fieldset>
                        <div class="span5">                             
                            <label class="control-label text-error" for="Name">
                                Group Name
                            </label>  
                            <div class="controls">  
                                <input name="GroupName" type="text" class="input-large" id="GroupName" value="<?=htmlspecialchars($groupData->GroupName)?>">
                            </div>
                            <label class="control-label text-error" for="Name">
                                Group Description
                            </label>  
                            <div class="controls">  
                                <textarea name="GroupDescription" type="text" class="input-large" id="GroupDescription"><?=htmlspecialchars($groupData->GroupDescription)?></textarea>
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
                            <br>
                            <div class="text-warning">
                                <i class="icon-exclamation-sign"></i>
                                If you delete this report group!
                                <li>All reports of this group will be deleted!</li>
                                <li>All hosts of this group will be deleted!</li>
                                <li>All hosts's vulnerabilities of this group will be deleted!</li>
                                <li>Are you sure ?</li>
                            </div>
                            <script LANGUAGE="JavaScript">
                            <!--
                            function confirmPost()
                            {
                            var agree=confirm("Are you sure you want to delete?");
                            if (agree)
                            return true ;
                            else
                            return false ;
                            }
                            // -->
                            </script>
                            </form>
                            <?php echo form_open('admin/DeleteReportGroup/'.$groupData->GroupID);?>
                                <div class="">                                    
                                    <button name="deleteGroup" value="1" type="submit" class="btn btn-danger" onclick="return confirmPost()"><b>DELETE GROUP</b></button>   
                                </div>
                            </form>
                             <br>
                                                         
                        </div>                                                    
                     </fieldset>                                  
         </div>
     </div>
</div><!--/row-->
