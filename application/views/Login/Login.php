<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Generating form with CI for CSRF protection
echo form_open('login/ValidateCredentials');
?>
<div class="container golge-ve-gecikme" align="center">
    <fieldset>
        <legend>Existing Users Login</legend>
        <?php echo '<div class="text-error">'.validation_errors()."</div>";?>
        <label for="Username">Username</label>
        <div class="div_text">
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input name="Username" type="text" id="log inputIcon" value="" class="username span2" /></div>

        </div>

        <label for="Password">Password</label>
        <div class="div_text">
                <div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span><input name="Password" type="password" id="pwd inputIcon" class="password span2" /></div>
        </div>
        <div class="button_div">
            <input name="rememberme" type="checkbox" id="rememberme" value="forever" />&nbsp;Remember me&nbsp;&nbsp;
            <input type="submit" name="Submit" value="Login" class="btn btn-primary" />
        </div>
    </fieldset>
    </form>
</div>
<br>
<br>
