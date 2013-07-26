<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">             
             <div class="row-fluid offset2">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-user"></i> CREATE NEW USER</h5>
                 <div class="text-warning">
                 </div>
                 <?php
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$process == 1)
                     echo '<p class="text-success"><i class="icon-ok"></i> New User has been created!</p>';
                 else if (@$process==2) 
                     echo '<p class="text-error"><i class="icon-remove"></i> Something went wrong</p>';
                 else if (@$process==3)
                     echo '<p class="text-error"><i class="icon-remove"></i> Your password is wrong</p>';
                 else if (@$process==4)
                     echo '<p class="text-error"><i class="icon-remove"></i><b>This Username has been taken.<B></b></p>';
                 else if (@$process==5)
                     echo '<p class="text-error"><i class="icon-remove"></i><b>This Mail Address has been taken.<B></b></p>';
                 unset($process);                 
                 ?>
                 
                 <?php echo form_open('admin/CreateNewUser');?>
                     <fieldset>
                        <div class="span4"> 
                            <label class="control-label text-error">
                                Username
                            </label> 
                            <div class="controls">
                                <input name="Username" type="text" class="input-large" id="Username" value="">
                            </div>
                            <label class="control-label text-error">
                                User Status
                            </label>  
                            <div class="controls">
                               <select name="UserIdentify" >
                                  <option value="1">Administrator</option>
                                  <option value="2">Moderator</option>
                                </select>
                            </div>
                            <label class="control-label text-error" for="Name">
                                Email
                            </label>  
                            <div class="controls">  
                                <input name="Mail" type="text" class="input-large" id="Email" value="">
                            </div>
                            <label class="control-label text-error" for="Name">
                                Name
                            </label>  
                            <div class="controls">  
                                <input name="Name" type="text" class="input-large" id="Name" value="">
                            </div>
                            <label class="control-label text-error" for="Surname">
                                Surname
                            </label>  
                            <div class="controls">  
                                <input name="Surname" type="text" class="input-large" id="Surname" value="">
                            </div>
                        </div>
                         <div class="span4">
                            <label class="control-label text-error" for="NewPassword1">
                                Set Password
                            </label>  
                            <div class="controls">  
                                <input name="NewPassword1" type="password" class="input-large" id="Name" value="">
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
            </div> 
    </div>
</div><!--/row-->
