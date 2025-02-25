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
   
   // DONT DISPLAY FOR PREVIEW
   if(isset($_GET['ppt_live_preview'])){ return ""; } 
   
   global $CORE, $userdata; 
   
   	// LANGUAGES
	$languages =  $CORE->GEO("get_languagelist",array()); 
   
   
    ?>

<style>
#sidebar-wrapper ul li .nav-link {

	color: #000 !important;
}
</style>

<div class="sidebar-content">

	<div class="row ">
		<div class="col-8 ">
		
			<a class="sidebar-logo btn-block mt-4" style="display: flex;max-width: 126px;
    padding: 10px;
    margin-left: 20px;
    border-radius: 10px;
    width: 120px;
    flex-direction: column;"
							href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> </a>

		</div>

		<div class="col-4 sidebar-heading text-center  mt-4 d-flex">
			<button class="navbar-toggler menu-toggle">
				<div class="fal fa-bars text-secondary">&nbsp;</div>
			</button>
		</div>
	</div>
	<hr />
	<?php echo do_shortcode('[MAINMENU class="navbar-nav text-dark" mobile=1]');  ?>
	<hr />
	<?php if(!$userdata->ID){ ?>
	<a class="btn btn-secondary btn-md btn-block"
		href="<?php echo wp_login_url(); ?>"><?php echo __("Sign In","premiumpress"); ?></a>
	<?php if(get_option('users_can_register') == 1){   ?>

	<!--<a class="btn btn-outline-primary btn-md btn-block mt-4" href="<?php echo wp_registration_url(); ?>"><?php echo __("Register","premiumpress"); ?></a>-->

	<?php } ?>
	<?php }else{ ?>
	<a class="btn btn-secondary btn-md btn-block" href="<?php echo _ppt(array('links','myaccount')); ?>">
		<?php echo __("My Account","premiumpress"); ?></a> <a href="<?php echo wp_logout_url(home_url()); ?>"
		class="btn btn-outline-secondary btn-md btn-block mt-4"><i class="fa fa-sign-out"></i>
		<?php echo __("Logout","premiumpress"); ?></a>
	<?php } ?>
	<?php if(is_array($languages) && !empty($languages)){ ?>
	<hr />

	<script>
	jQuery(function() {

		jQuery("#mobilelangselect").change(function() {
			location.href = jQuery(this).val();
		})
	})
	</script>
	<?php } ?>
</div>