<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-user"></i> USER INFORMATION</h5>
                 <?php
                 echo '<div class="text-error">'.validation_errors()."</div>";
                 if(@$processFeedback == 1)
                     echo '<p class="text-success"><i class="icon-ok"></i> User has been deleted!</p>';
                 else if (@$processFeedback == 2)
                     echo '<p class="text-error"><i class="icon-ok"></i> Something went wrong!</p>';
                 ?>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> All data sorted by "UserID" automatically!</div>
                 <table class="table table-striped ">
                    <thead>
                      <tr>
                        <th>Select</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Mail</th>                 
                        <th>User Identify</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php foreach($userInfo as $row){ ?>
                      <tr onclick="">
                      <?php
                      $hidden = array('UserID' => $row->UserID);
                      echo form_open('admin/UserDetail',"",$hidden);
                      ?>                            
                        <td><a class="muted" href="<?=base_url()?>index.php/admin/UserDetail/<?=$row->UserID?>">Details</a></td>
                        <td><?=html_escape($row->UserID)?></td>
                        <td><?=html_escape($row->Username)?></td>
                        <td><?=html_escape($row->Name)?></td>
                        <td><?=html_escape($row->Surname)?></td>
                        <td><?=html_escape($row->Mail)?></td>                        
                        <?php
                            if ($row->UserIdentify == 1)
                                $Status = "Administrator";
                                else if ($row->UserIdentify == 2)
                                        $Status = "Moderator";
                                    else
                                            $Status = "Something Else";
                        ?>
                        <td><?=$Status?></td>
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
     </div>
</div><!--/row-->
