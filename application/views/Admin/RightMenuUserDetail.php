<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
foreach($userInfo as $row){}
if ($row->UserIdentify == 1) {
    $Status = "Administrator";
    } else if ($row->UserIdentify == 2) {
            $Status = "Moderator";
        } else {
            $Status = "Something Else";
        }
?>
<div class="span10">    
         <div class="hero-unit golge-ve-gecikme center">
             <div class="row-fluid offset2" style="vertical-align: middle;">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-user"></i> USER SETTINGS</h5>
                 <div class="text-warning">
                     <i class="icon-exclamation-sign"></i>
                     Leave blank if you do NOT need change user's password.<br>
                     <i class="icon-exclamation-sign"></i>
                     After clicking "Delete User" button, there is no turning back. Be carefull !!!                     
                 </div>
                 <?php
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$process == 1)
                     echo '<p class="text-success"><i class="icon-ok"></i> Information has been changed</p>';
                 else if (@$process==2) 
                     echo '<p class="text-error"><i class="icon-remove"></i> Something went wrong</p>';
                 else if (@$process==3)
                     echo '<p class="text-error"><i class="icon-remove"></i> Your password is wrong</p>';
                 else if (@$process==4)
                     echo '<p class="text-error"><i class="icon-remove"></i> Password is not same</p>';
                 unset($process);
                 ?>
                 <?php echo form_open('admin/ChangeUserInformation/'.$row->UserID);?>
                     <fieldset>
                        <div class="span4"> 
                            <label class="control-label text-error">
                                Username
                            </label> 
                            <div class="controls">
                                <input name="Username" type="text" class="input-large" id="Username" value="<?=htmlspecialchars($row->Username)?>">
                            </div>
                            <label class="control-label text-error">
                                User Status
                            </label>  
                            <div class="controls">
                               <select name="UserIdentify" >
                                  <?php
                                  if($row->UserIdentify == 1){
                                  ?>
                                  <option value="1"><?=$Status?></option>
                                  <option value="2">Moderator</option>
                                  <?php } else if ( $row->UserIdentify == 2 ){ ?>
                                  <option value="2"><?=$Status?></option>
                                  <option value="1">Administrator</option>
                                  <?php } ?>
                                </select>
                            </div>
                            <label class="control-label text-error" for="Name">
                                Email
                            </label>  
                            <div class="controls">  
                                <input name="Mail" type="text" class="input-large" id="Email" value="<?=htmlspecialchars($row->Mail)?>">
                            </div>
                            <label class="control-label text-error" for="Name">
                                Name
                            </label>  
                            <div class="controls">  
                                <input name="Name" type="text" class="input-large" id="Name" value="<?=htmlspecialchars($row->Name)?>">
                            </div>
                            <label class="control-label text-error" for="Surname">
                                Surname
                            </label>  
                            <div class="controls">  
                                <input name="Surname" type="text" class="input-large" id="Surname" value="<?=htmlspecialchars($row->Surname)?>">
                            </div>
                        </div>
                         <div class="span4"> 
                            <label class="control-label text-error">
                                Registration Date
                            </label> 

                            <div class="controls">  
                                <span class="uneditable-input"><?=$row->RegistrationDate?></span>
                            </div>
                            <label class="control-label text-error" for="NewPassword1">
                                Set New Password
                            </label>  
                            <div class="controls">  
                                <input name="NewPassword" type="password" class="input-large" id="Name" value="">
                            </div>
                            <label class="control-label text-error" for="NewPassword2">
                                Again New Password
                            </label>  
                            <div class="controls">  
                                <input name="NewPassword2" type="password" class="input-large" id="Surname" value="">
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
                 <?php echo form_open('admin/DeleteUser');?>
                    <div class="">
                        <input name="UserID" value="<?=$row->UserID?>" type="hidden">
                        <button name="deleteButton" value="1" type="submit" onClick="return confirmPost()" class="btn btn-danger"><b>DELETE USER</b></button>   
                    </div>
                 <br>
                </form>
            </div> 
    </div>
</div><!--/row-->
