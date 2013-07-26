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
<div class="span9">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-user"></i> USER SETTINGS</h5>
                 <?php
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$process == 1)
                     echo '<p class="text-access"><i class="icon-ok"></i> Password has been changed</p>';
                 else if (@$process==2) 
                     echo '<p class="text-error"><i class="icon-remove"></i> Something went wrong</p>';
                 else if (@$process==3)
                     echo '<p class="text-error"><i class="icon-remove"></i> Current password is wrong</p>';
                 else if (@$process==4)
                     echo '<p class="text-error"><i class="icon-remove"></i> Password is not same</p>';
                 unset($process);
                 ?>
                 <?php echo form_open('moderator/ChangeUserInformation');?>
                     <fieldset>
                        <div class="span4"> 
                            <label class="control-label text-error">
                                Username
                            </label> 

                            <div class="controls">  
                                <span class="uneditable-input"><?=$row->Username?></span>
                            </div>
                            <label class="control-label text-error">
                                User Status
                            </label>  
                            <div class="controls">  
                                <span class="uneditable-input"><?=$Status?></span>
                            </div>
                            <label class="control-label text-error" for="Name">
                                Email
                            </label>  
                            <div class="controls">  
                                <input name="Mail" type="text" class="input-large" id="Email" value="<?=$row->Mail?>">
                            </div>
                            <label class="control-label text-error" for="Name">
                                Name
                            </label>  
                            <div class="controls">  
                                <input name="Name" type="text" class="input-large" id="Name" value="<?=$row->Name?>">
                            </div>
                            <label class="control-label text-error" for="Surname">
                                Surname
                            </label>  
                            <div class="controls">  
                                <input name="Surname" type="text" class="input-large" id="Surname" value="<?=$row->Surname?>">
                            </div>
                        </div>
                         <div class="span4"> 
                            <label class="control-label text-error">
                                Registration Date
                            </label> 

                            <div class="controls">  
                                <span class="uneditable-input"><?=$row->RegistrationDate?></span>
                            </div>
                            <label class="control-label text-error">
                                Session Ip Address
                            </label>  
                            <div class="controls">  
                                <span class="uneditable-input"><?=$this->session->userdata('ip_address');?></span>
                            </div>
                            <label class="control-label text-error" for="CurrentPassword">
                                Current Password
                            </label>  
                            <div class="controls">  
                                <input name="CurrentPassword" type="password" class="input-large" id="Email" value="">
                            </div>
                            <label class="control-label text-error" for="NewPassword1">
                                New Password
                            </label>  
                            <div class="controls">  
                                <input name="NewPassword" type="password" class="input-large" id="Name" value="">
                            </div>
                            <label class="control-label text-error" for="NewPassword2">
                                Again NewPassword
                            </label>  
                            <div class="controls">  
                                <input name="NewPassword2" type="password" class="input-large" id="Surname" value="">
                            </div>
                            <div class="">  
                                <button type="submit" class="btn btn-primary">Save changes</button>  
                                <button class="btn">Cancel</button>  
                            </div> 
                        </div> 
                     </fieldset>
                 </form>
            </div> 
    </div>
</div><!--/row-->
