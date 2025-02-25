<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata; 

?>


<div class="text-center mb-5"> 

<h2>User Levels </h2>

<p class="text-muted mx-auto col-10">User levels are based on user activity. </p>

</div>

<table class="table table-bordered bg-white shadow-sm mb-4">
  <thead>
    <tr>
    
      <th scope="col">Level</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach($CORE->USER("get_levels", $userdata->ID) as $k => $h){ ?>
 
  
    <tr>
      <td><div style="background:#28a745;" class="p-2 btn-block text-white font-weight-bold text-center"><?php echo $h['name']; ?></div></td>
  
      <td><div class="p-2"><?php echo $h['desc']; ?></div></td>
    </tr>
 
   <?php } ?>



  </tbody>
</table>


 
 
 


<div class="text-center mb-4 mt-5"> 

<h2>User Awards </h2>

<p class="text-muted mx-auto col-10">Awards are provided to users when they achieve something special.</p>

</div>



    
<div class="row"> 
<?php
foreach($CORE->USER("get_awards", $userdata->ID) as $k => $h){?>

<div class="col-md-3 text-center">
<figure>
<img src="<?php echo get_template_directory_uri(); ?>/framework/images/award/a<?php echo $k; ?>.png" alt="" class="img-fluid">
 
</figure>
<div class="award-text text-center">
<div class="small font-weight-bold"><?php echo $h['name']; ?></div>
<div class="small text-muted mt-3"><?php echo $h['desc']; ?></div>
</div>
</div>
<?php } ?>
</div>