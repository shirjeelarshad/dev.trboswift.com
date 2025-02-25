<?php
   /*
   Template Name: [PAGE - ADD LISTING]
    
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
   
   global $CORE, $userdata, $CORE; 
   
   $FREELISTING = false;
    
   // REDIRECT FOR LOGIN
   if( _ppt(array('lst','websitepackages')) == "0" || THEME_KEY == "da" ){
   	$CORE->Authorize();
   }
   
    $ev = _ppt(array("emails","user_verify"));
	
	// CHECK FOR FOCE EMAIL VERIFICATION
	if( $userdata->ID && isset($ev['enable']) && $ev['enable'] == "1" &&  _ppt(array('register','forcemailverify'))  == "1" && $CORE->USER("get_verified", $userdata->ID)  == "0"  ){
	
		$link = _ppt(array('links','myaccount'));
		header("location: ". $link);
		exit;
	
	}
	
  
	
   
   // CHECK FOR ACCESS AFTER NO LISTINGS
   if(_ppt(array('mem','enable'))  == '1' && _ppt('mem0_listings_max') != "" && $userdata->ID && $CORE->USER("membership_hasaccess", "listings_max")){
   
		// CHECK USER CREDIT
		if(isset($_GET['eid'])){
		
		}elseif($CORE->USER("get_user_free_membership_addon", array("listings_max", $userdata->ID)) > 0){
		
		}else{
			$link = _ppt(array('links','myaccount'))."?noaccess=1&showtab=membership&op=listings_max";
			if(!$userdata->ID){
				$link = wp_login_url();	
			} 	
			header("location: ". $link);
			exit;
		}
	}
   
   
	if( $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1  ){
				
		if(_ppt(array("maps","provider")) == "mapbox"){
	 
			wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css');
			wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js');
			  
		}elseif(_ppt(array("maps","provider")) == "google"){
				
			wp_enqueue_script('maps', $CORE->GEO("maps_google_link", array() ), array(), THEME_VERSION, $footer = true);	
		}
	}

   // SETUP PAGE GLOBALS 
   $GLOBALS['flag-add'] = 1; 
   
   // FREE LISTING OR NO PACKAGES
   if(_ppt(array('lst','websitepackages')) == 0 || $CORE->PACKAGE("count_enabled_packages", array()) == 0 ){
   $FREELISTING = true;
   }  
     
   //DISPLAY HEADER
   get_header();   
   
   // DISPLAY PAGE TOP
   _ppt_template( 'page', 'top' ); 
   
    
	if(in_array(THEME_KEY, array("mj")) && in_array(_ppt(array('lst', 'selleronly')), array("1")) && $userdata->ID && get_user_meta($userdata->ID,'user_type',true) == "user_fr" && !user_can( $post->post_author, 'edit_posts' )   ){  // 
	
		?>
        <section class="mt-1">
        
        <div class="container">
        
<div class=" my-4 py-5">
  <div class="col-lg-6 mx-auto">
    <div class="card card-body text-center p-5"> <i class="fal fa-lock fa-8x mb-4 text-primary"></i>
      <h4><?php echo __("No Access","premiumpress"); ?></h4>
      <p class="lead mb-0"> <?php echo __("Member accounts without seller privileges do not offer access to this feature.","premiumpress"); ?> </p>
    
    </div>
  </div>
</div> 
     
        </div>
        
        </section>
        
        
        <?php		
		
		 
	}else if(!$FREELISTING){
   ?>
<section id="add-packages" class="mt-1">
   <?php
   
   
   $pageLinkingID = _ppt_pagelinking("add"); 
   if( substr($pageLinkingID ,0,9) == "elementor" ){
		
		echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");
	
	}else{   
    // LOAD 
   $CORE->LAYOUT("get_innerpage_blocks", array("page_add","load"));   
   }
   
   ?>
</section>
<?php } ?>

<section id="add-main" <?php if(!$FREELISTING){ ?> style="display:none;"<?php } ?> class="bg-light section-80">
<div class="container">
<?php _ppt_template('framework/design/add/add-mainform' ); ?>
</div>
</section>

   <?php if($FREELISTING){ ?>  
	<script> 
    jQuery(document).ready(function() {	
		jQuery('#package-tab-content').hide();
		jQuery('#step-content').show();
		processPackage('<?php echo $FREELISTING; ?>');			
		jQuery('.ppprice').html('<?php echo __("FREE","premiumpress"); ?>');
		jQuery('#SUBMISSION_FORM').append('<input type="hidden" value="1" name="freelisting" />');
    });
    </script>
   <?php } ?>
      
  
   <script> 
    jQuery(document).ready(function() {
	
	jQuery('#package-outter-wrapper').show();
    
	
    });
    </script>
 
<?php if(isset($_GET['pakid']) && is_numeric($_GET['pakid']) ){ ?>

  
   <script> 
    jQuery(document).ready(function() {
	
		processPackage('<?php echo esc_attr($_GET['pakid']); ?>'); 
		jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
    
	
    });
    </script>
<?php } ?>


<?php 

// + PAGE BOTTOM
_ppt_template( 'page', 'bottom' ); 

// + GLOBAL FOOTER
get_footer();  ?>