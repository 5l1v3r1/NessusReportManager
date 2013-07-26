<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="span10">
         <div class="hero-unit golge-ve-gecikme">
             <div class="row-fluid">
                 <h5 class="Main-Menu-Mehmet"><i class="icon-lock"></i> FAIL LOGINS</h5>
                 <div class="text-warning"><i class="icon-exclamation-sign"></i> All data sorted by "Request Time" automatically!</div>
                 <table class="table table-striped ">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Request Time</th>
                        <th>Ip Address</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($failLogins as $row){ ?>
                      <tr>
                        <td><?=$row->Id?></td>
                        <td><?=$row->Username?></td>
                        <td><?=$row->Password?></td>
                        <td><?=$row->RequestTime?></td>
                        <td><?=$row->IpAddress?></td>
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
