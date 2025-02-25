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
 
  
<div class="row">
            <div class="col-md-12">
               <div class="form-group">
                  <label class="control-label"> <?php echo __("Password","premiumpress"); ?></label>
                  <div class="controls">
                     <input type="password" name="password" class="form-control"  value="">
                  </div>
               </div>
            </div>
            <div class="col-md-12">
            
               <div class="form-group">
                  <label class="control-label"><?php echo __("Confirm Password","premiumpress"); ?></label>
                  <div class="controls">
                     <input type="password" name="password_r" class="form-control" value="">                        
                  </div>
               </div>
     </div>
   </div>