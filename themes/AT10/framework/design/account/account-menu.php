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

global $CORE, $userdata, $post;

 

?>

<div class="side-menu-links" style="">

	<?php foreach($CORE->USER("get_account_links", array()) as $k => $i){  ?>
	<a class="btn btn-icon mt-2 mb-2 position-relative" <?php if($i['link'] != "") { ?>href="<?php echo $i['link']; ?>"
		<?php } else { ?>onclick="SwitchPage('<?php echo $k; ?>');" href="javascript:void(0);" <?php } ?>
		id="switch-page-tab-<?php echo $k; ?>" title="<?php echo $i['name'] ?>">
		<?php if($k == 'escrow'){ ?>
		<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/escrow.svg" title="<?php echo $i['name'] ?>"
			alt="<?php echo $i['name'] ?>" style="width: 50px; height: 50px;" />
		<?php }else if($k == 'financing'){ ?>
		<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/finance-icon-1.svg" title="<?php echo $i['name'] ?>"
			alt="<?php echo $i['name'] ?>"
			style="width: 50px; height: 50px; background:#F8F9FA; border-radius:50px;object-fit:contain" />

		<?php }else{ ?>
		<i class="fal <?php echo $i['icon'] ?> text-dark"></i>
		<?php } ?>
		<span class="menu-alert-<?php echo $k; ?> badge badge-dark position-absolute"
			style="min-width: 21px; display:none; padding: 2px !important; top: -5px; right: -5px;">0</span>
	</a>


	<?php if($k == "details"){ ?>

	<?php } ?>
	<script>
	function SwitchPage(apage) {
		jQuery(".account_page_wrapper").hide();
		jQuery("#" + apage).show();

		if (apage == "financing") {
			ajax_load_chat_list();

			jQuery("#switch-page-tab-dashboard").removeClass('active');
			jQuery("#switch-page-tab-details").removeClass('active');
			jQuery("#switch-page-tab-escrow").removeClass('active');
			jQuery("#switch-page-tab-financing").addClass('active');
			jQuery("#switch-page-tab-messages").removeClass('active');
			jQuery("#switch-page-tab-transport").removeClass('active');
		} else if (apage == "escrow") {
			ajax_load_chat_list();

			jQuery("#switch-page-tab-dashboard").removeClass('active');
			jQuery("#switch-page-tab-details").removeClass('active');
			jQuery("#switch-page-tab-escrow").addClass('active');
			jQuery("#switch-page-tab-financing").removeClass('active');
			jQuery("#switch-page-tab-messages").removeClass('active');
			jQuery("#switch-page-tab-transport").removeClass('active');

		} else if (apage == "messages") {
			ajax_load_chat_list();
			jQuery("#switch-page-tab-details").removeClass('active');
			jQuery("#switch-page-tab-escrow").removeClass('active');
			jQuery("#switch-page-tab-financing").removeClass('active');
			jQuery("#switch-page-tab-messages").addClass('active');
			jQuery("#switch-page-tab-dashboard").removeClass('active');
			jQuery("#switch-page-tab-transport").removeClass('active');
		} else if (apage == "transport") {
			ajax_load_chat_list();
			jQuery("#switch-page-tab-details").removeClass('active');
			jQuery("#switch-page-tab-escrow").removeClass('active');
			jQuery("#switch-page-tab-financing").removeClass('active');
			jQuery("#switch-page-tab-messages").removeClass('active');
			jQuery("#switch-page-tab-dashboard").removeClass('active');
			jQuery("#switch-page-tab-transport").addClass('active');
		} else if (apage == "details") {
			jQuery("#account_jumplinks").show();
			jQuery("#switch-page-tab-details").addClass('active');
			jQuery("#switch-page-tab-escrow").removeClass('active');
			jQuery("#switch-page-tab-financing").removeClass('active');
			jQuery("#switch-page-tab-messages").removeClass('active');
			jQuery("#switch-page-tab-dashboard").removeClass('active');
			jQuery("#switch-page-tab-transport").removeClass('active');

		} else if (apage == "dashboard") {
			jQuery("#account_jumplinks").show();
			jQuery("#switch-page-tab-escrow").removeClass('active');
			jQuery("#switch-page-tab-financing").removeClass('active');
			jQuery("#switch-page-tab-details").removeClass('active');
			jQuery("#switch-page-tab-messages").removeClass('active');
			jQuery("#switch-page-tab-dashboard").addClass('active');
			jQuery("#switch-page-tab-transport").removeClass('active');
		} else {
			jQuery("#account_jumplinks").hide();
		}
	}

	jQuery(document).ready(function() {

		SwitchPage('dashboard');

		// Toggle
		var off = false;
		var toggle = jQuery('.toggle');
		toggle.siblings().hide();
		toggle.show();



	});

	function ToggleME(div) {


		var self = jQuery("#" + div + '_toggle .toggle');

		if (self.hasClass('on')) {
			self.removeClass('on').addClass('off');
			jQuery('#' + div).val(0);
		} else {
			self.removeClass('off').addClass('on');
			jQuery('#' + div).val(1);
		}

	}
	</script>
	<?php } ?>



	<?php /* if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>

	<a href="<?php echo home_url()."/?s=&favs=1"; ?>" class="btn text-dark  btn-icon mt-2 mb-2 position-relative"> <i
			class="fal fa-heart text-dark"></i>

	</a>


	<?php } */ ?>

	<?php if(in_array(THEME_KEY, array("da")) ){ global $wpdb;
	 
	  $singleListingLink = $CORE->USER("get_user_profile_link",$userdata->ID);	
	
	 if(_ppt(array('lst','onelistingonly')) == "1"  ){  //&& !$CORE->USER("membership_hasaccess", "listings_multiple")  
  
		$SQL = "SELECT DISTINCT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('".$userdata->ID."') LIMIT 1";				 
		$query = $wpdb->get_results($SQL, OBJECT);
	 	
		if(!empty($query)){		
			
			$singleListingLink = get_permalink($query[0]->ID);
		 
		 }else{
		 
		 	$singleListingLink = _ppt(array('links','add'));
		 }
	 
	 }
	 
	 
	 ?>

	<!--<a href="<?php echo $singleListingLink; ?>" class="btn btn-block btn-light btn-md" ><?php echo __("View My Profile","premiumpress"); ?></a>-->

	<?php }elseif(!in_array(THEME_KEY, array("es"))  && _ppt(array('user','allow_profile')) == "1"){ ?>
	<!--<a href="<?php echo $CORE->USER("get_user_profile_link",$userdata->ID); ?>" class="btn btn-block btn-light btn-md"  ><?php echo __("View My Profile","premiumpress"); ?></a>-->
	<?php } ?>


	<div class="side-bar-bottom">
		<a href="#" title="Settings" class="btn text-dark  btn-icon mt-2 mb-2 position-relative"> <i
				class="fal fa-cog"></i></i></a>

		<a href="<?php echo wp_logout_url(home_url()); ?>" title="Sign Out"
			class="btn text-dark  btn-icon mt-3 mb-2 position-relative"> <i
				class="fal fa-sign-out-alt text-dark"></i></a>

	</div>
</div>