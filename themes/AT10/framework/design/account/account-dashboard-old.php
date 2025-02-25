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

global $CORE, $userdata; $showDashboard = true;
$user_roles = wp_get_current_user()->roles;	

?>
<div class="row m-0">
 



<?php if($CORE->ADVERTISING("check_exists", "account_top") ){ ?>

<div class="col-12">
  <div class="py-4 text-center"> <?php echo $CORE->ADVERTISING("get_banner", "account_top" );  ?> </div>
</div>
<?php } ?>
<?php if(strlen(get_user_meta($userdata->ID,'ppt_customtext', true)) > 1){  ?>
<div class="alert alert-success text-center"> <?php echo get_user_meta($userdata->ID,'ppt_customtext', true); ?></div>
<?php } ?>


<div class="row  align-content-start col-12 col-md-9 my-4 mx-0 p-0">

<div class="col-12">

<div class="top-banner">
<div class="banner-bg d-flex">

<div class="col-8">
<div class="mb-3">
<h2 class="text-white mb-1">Welcome to TurboBid</h2>
 
<span class="text-white mb-3">Built for Enthusiasts, inspired by Transparency </span>
</div>
<a href="/" class="btn btn-light rounded-pill px-4">Explore Now</a>
</div>

<div class="col-4 d-flex align-items-center">
<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/image-106.png" style="width:100%; height:100%; object-fit:contain;" >
</div>
</div>
</div>

</div><!-- Top Banner Close -->

<div class="col-12 my-3">
<?php _ppt_template( 'framework/design/account/_newauctions' ); ?>
</div>
<div class="col-12">
<?php _ppt_template( 'framework/design/account/_topauctions' ); ?>
</div>

 
</div>

<div class="col-12 col-md-3 my-4">

<div class="bg-white radiusx d-flex flex-column justify-content-center align-items-center p-4 mb-3">
<h6 class="mb-2">Buy modern cars & Sell Old cars </h6>
<a href="<?php echo home_url(); ?>/list-your-car" class="btn btn-secondary rounded-pill px-4">+  Sell your Car</a>

</div>


 <div class="bg-white radiusx d-flex flex-column justify-content-center align-items-center p-2">
<?php _ppt_template( 'framework/design/account/parts/_live_ending_auctions' ); ?>
</div>

</div>
</div>