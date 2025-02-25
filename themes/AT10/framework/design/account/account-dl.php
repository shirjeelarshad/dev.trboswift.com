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

<div class="row border-bottom smallbox">
  <div class="col-md-6 border-right"> <a onclick="SwitchPage('listings');" href="javascript:void(0);" class="text-dark"> <i class="fal <?php echo $CORE->LAYOUT("captions","icon"); ?> text-primary opacity-5"></i>
    <div class="mt-4">
      <div class="count-numbers"><?php echo $CORE->USER("count_listings", $userdata->ID); ?></div>
      <div class="count-name"><?php echo __("My","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","2"); ?> <small class="small text-muted btn-block"><?php echo __("view all","premiumpress"); ?></small> </div>
    </div>
    </a> </div>
  <div class="col-md-6"> 
  <?php if(THEME_KEY == "vt"){ ?>
  
  <a  href="<?php echo get_author_posts_url( $userdata->ID ); ?>" class="text-dark"> <i class="fal fa-ticket text-primary opacity-5"></i>
    <div class="mt-4">
      <div class="count-numbers"><?php echo $CORE->USER("get_subscribers_count", $userdata->ID); ?></div>
      <div class="count-name"><?php echo __("My Subscribers","premiumpress"); ?><small class="small text-muted btn-block"><?php echo __("view all","premiumpress"); ?></small> </div>
    </div>
    </a> 
  
  <?php }elseif($CORE->LAYOUT("captions","offers") != ""){ ?>
  
  <a onclick="SwitchPage('offers');" href="javascript:void(0);" class="text-dark"> <i class="fal fa-ticket text-primary opacity-5"></i>
    <div class="mt-4">
      <div class="count-numbers"><?php echo $CORE->USER("count_offers", $userdata->ID); ?></div>
      <div class="count-name"><?php echo $CORE->LAYOUT("captions","offers"); ?><small class="small text-muted btn-block"><?php echo __("view all","premiumpress"); ?></small> </div>
    </div>
    </a> 
    <?php } ?>
    </div>
</div>
<div class="row border-bottom smallbox">
  <div class="col-md-6 border-right"> <a onclick="SwitchPage('messages');" href="javascript:void(0);" class="text-dark"> <i class="fal fa-envelope text-primary opacity-5"></i>
    <div class="mt-4">
      <div class="count-numbers"><?php echo $CORE->USER("count_messages", $userdata->ID); ?></div>
      <div class="count-name"><?php echo __("Messages","premiumpress"); ?> <small class="small text-muted btn-block"><?php echo __("view all","premiumpress"); ?></small> </div>
    </div>
    </a> </div>
  <div class="col-md-6"> 
    <?php if(THEME_KEY == "da"){ ?>
    <?php if(_ppt(array('mem','enable')) == 1){ ?>
    <a onclick="SwitchPage('membership');" href="javascript:void(0);" class="text-dark"> <i class="fal fa-lock-alt text-primary opacity-5"></i>
    <div class="mt-4">
       
      <div class="count-name"><?php echo __("My Membership","premiumpress"); ?> <small class="small text-muted btn-block"><?php echo __("view all","premiumpress"); ?></small> </div>
    </div>
    </a> 
    <?php } ?>
  
  <?php }else{ ?>
  <a href="<?php echo get_author_posts_url($userdata->ID); ?>" class="text-dark"> <i class="fal fa-user text-primary opacity-5"></i>
    <div class="mt-4">
      <div class="count-numbers"><?php echo $CORE->USER("count_profile_views", $userdata->ID); ?></div>
      <div class="count-name"><?php echo __("Profile","premiumpress"); ?> <small class="small text-muted btn-block"><?php echo __("views","premiumpress"); ?></small> </div>
    </div>
    </a>
    <?php } ?>
     </div>
</div>
