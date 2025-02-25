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
   
   global $CORE, $userdata, $STRING; ?>
<h4 class="pb-4">
	  
	  <?php echo $CORE->USER("get_first_name", $userdata->ID );  ?> <?php echo $CORE->USER("get_last_name", $userdata->ID );  ?> &nbsp; <span class="opacity-5 float-right">
      
      <?php if(get_user_meta($userdata->ID,'old_username',true) != ""){ ?>
      <?php echo $CORE->USER("get_username", $userdata->ID );  ?>
      
      <?php }else{ ?>
      <a href="javascript:void(0);" style="text-decoration:none;" onclick="showdetails('details'); showdetails('username');"><?php echo $CORE->USER("get_username", $userdata->ID );  ?> <i class="fal fa-pencil"></i></a>
      
      <?php } ?>
      
      
      </span>      
      
</h4>