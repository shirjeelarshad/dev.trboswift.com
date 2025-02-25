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

global $CORE;
 
 
?> 

<div class="py-4">

    <div class="container">
    <div class="row">
              
 
<div class="row">
<?php 
$g = $CORE->FUNC("get_logtype", array());
foreach($g as $l => $log){

if(strlen($log['name']) > 5){
?>
<div class="col-md-3">
<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="logtype" data-value="<?php echo $l; ?>" onclick="_filter_update()" <?php if(isset($_GET['emailid']) && $l == "email"){ ?>value="email" checked=checked<?php } ?>>
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo $log['name']; ?> 
  
</label> 
</div>
<?php }  }?>
</div> 
       
 
    
    </div>    
    </div>   

</div> 