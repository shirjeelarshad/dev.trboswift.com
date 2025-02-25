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

global $CORE, $default_email_array; 


 
?>

<div class="row">
  <div class="col-md-4 pr-lg-4">
    <h3 class="mt-4"><?php echo __("Email Settings","premiumpress"); ?></h3>
    <p class="text-muted lead"> <?php echo __("These details are applied to all emails sent from this website.","premiumpress"); ?> <a href="https://www.youtube.com/watch?v=A23nzR48OkU" class="btn btn-danger text-light mt-4 shadow-sm btn-sm px-3 popup-yt"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a> </p>
  </div>
  <div class="col-md-8">
    <div class="card card-admin">
      <div class="card-body">
        <div class="row">
          <div class="form-group col-6">
            <label class="txt500"><?php echo __("Email From","premiumpress"); ?></label>
            <input type="text"  name="adminArray[admin_email]" class="form-control"  value="<?php echo get_option('admin_email'); ?>">
            <div class="small text-muted mt-3"><?php echo __("This is the email address that will show up on emails sent from this website.","premiumpress"); ?> </div>
          </div>
          <div class="form-group col-6">
            <label class="txt500"><?php echo __("From Name","premiumpress"); ?></label>
            <input type="text"  name="adminArray[emailfrom]" class="form-control"  value="<?php echo get_option('emailfrom'); ?>">
            <div class="small text-muted mt-3"><?php echo __("The name that appears on emails sent from this website.","premiumpress"); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4 pr-lg-4">
    <h3 class="mt-4"><?php echo __("Welcome Inbox Message","premiumpress"); ?></h3>
    <p class="text-muted lead"> <?php echo __("This is the default inbox message the user will recieve when they join your website.","premiumpress"); ?> </p>
  </div>
  <div class="col-md-8">
    <div class="card card-admin">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-md-12">
            <label class="txt500"><?php echo __("Default Inbox Message","premiumpress"); ?> </label>
            <hr />
            <?php


$welcomemsg = stripslashes(get_option('ppt_email_inboxwelcome'));
if($welcomemsg == ""){

$welcomemsg = "Welcome to our website!<br><br>If you need any help with getting started just send me a reply and ill try my best to help you.";

}


 echo wp_editor( $welcomemsg, 'ppt_email_header1', array( 'textarea_name' => 'adminArray[ppt_email_inboxwelcome]', 'editor_height' => '200px') );  ?>
          </div>
        </div>
        <!-- end row -->
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4 pr-lg-4">
    <h3 class="mt-4"><?php echo __("Email Header/Footer","premiumpress"); ?></h3>
    <p class="text-muted lead"> <?php echo __("These details are applied to the header/footer for all emails sent from this website.","premiumpress"); ?> </p>
  </div>
  <div class="col-md-8">
    <div class="card card-admin">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-md-12">
            <label class="txt500"><?php echo __("Email Header","premiumpress"); ?> </label>
            <hr />
            <?php echo wp_editor( stripslashes(get_option('ppt_email_header')), 'ppt_email_header2', array( 'textarea_name' => 'adminArray[ppt_email_header]', 'editor_height' => '200px') );  ?> </div>
        </div>
        <!-- end row -->
        <div class="row py-2">
          <hr />
          <div class="col-md-12">
            <label class="txt500"><?php echo __("Email Footer","premiumpress"); ?></label>
            <hr />
            <?php

$ef = get_option('ppt_email_footer');
if($ef == ""){
$ef = '<br><br>Kind Regards<br>Management.<br><br>(website)';
}


 echo wp_editor( stripslashes($ef), 'ppt_email_footer', array( 'textarea_name' => 'adminArray[ppt_email_footer]', 'editor_height' => '200px') );  ?>
          </div>
        </div>
        <!-- end row -->
        <div class="p-4 bg-light text-center mt-4">
          <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
        </div>
      </div>
    </div>
  </div>
</div>
