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

 
?>
<?php 

global $settings;

$settings = array(

"title" => "Payment Gateways", 
"desc" => "Here you can setup and configure payment gateways for your website.", 
"video" => "https://www.youtube.com/watch?v=jBVnWQi8Xlw"

);

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <?php _ppt_template('framework/admin/blocks/gateways' ); ?>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 

$settings = array(
"title" => "Thank You Tracking Code", 
"desc" => "Here you can paste in any tracking code you want to use for the thank you page.", 
//"video" => "https://www.youtube.com/watch?v=jBVnWQi8Xlw"
);

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    
	
    <textarea class="form-control"   name="adminArray[google_conversion]" style="height:200px !important;"><?php echo strip_tags(get_option('google_conversion')); ?></textarea>
    
    <p class="mt-3">Shortcodes: <strong>[orderid]</strong> = order ID <strong>[description]</strong> = description <strong>[total]</strong> = total</p>
    
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
