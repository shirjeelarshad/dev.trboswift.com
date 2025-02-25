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

global $CORE, $settings, $userdata;
 
 
$settings['btn'] = "yes";
 
if($settings['btn_bg_txt'] == ""){ $settings['btn_bg_txt'] ="text-light"; }
if($settings['btn_bg'] == ""){ $settings['btn_bg'] ="primary"; }
if($settings['btn_txt'] == ""){ $settings['btn_txt'] = "<i class='fa fa-plus'></i> add new";  }
 			 
			
?>

<ul class="list-inline mb-0 small-list">
  <?php if(!$userdata->ID){ ?>
  <li class="list-inline-item hide-mobile"> <a href="javascript:void(0);" onclick="processLogin();"> <?php echo __("Sign In","premiumpress"); ?></a> </li>
  <?php if( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )   ){ ?>
  <li class="list-inline-item hide-mobile"> <a href="<?php echo wp_registration_url(); ?>"> <?php echo __("Register","premiumpress"); ?></a> </li>
  <?php } ?>
  <?php }else{ ?>
  <li class="list-inline-item hide-mobile"> <a class="sign-up  lrm-register" href="<?php echo _ppt(array('links','myaccount')); ?>"> <?php echo __("My Account","premiumpress"); ?></a> </li>
  <?php } ?>
  <li class="list-inline-item hide-mobile hide-ipad mr-0 pr-0">
    <?php
			 
			 if(THEME_KEY == "sp"){
			 
			 _ppt_template( 'framework/design/parts/cart' ); 
			 
			 }else{		 
			 
			  _ppt_template( 'framework/design/parts/btn' ); 
			  
			 } 
			  
			  ?>
  </li>
  <li class="list-inline-item ">
    <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
  </li>
</ul>
