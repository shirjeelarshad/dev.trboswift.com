<?php
/*
* @@ PremiumPress Framework Config
* @ Developed By Mark Fail
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*/

 

/*
*
=============================================================================
   LOAD IN FRAMEWORK IMAGES
============================================================================*/ 
  	
//$_SERVER['HTTP_HOST']
$host = $_SERVER['HTTP_HOST'];
if( in_array($host, array('localhost','10.0.0.3')) || strpos($host,"premiummod.com") !== false ){
	define('WLT_DEMOMODE',true);
}

define("DEMO_IMG_PATH", "https://premiumpress.com/_demoimagesv10/");
//define("DEMO_IMG_PATH", "http://localhost/_demoimagesv10/");


/*
*
=============================================================================
   QUICK VALIDATION FOR USERS
============================================================================*/ 
if(isset($_GET['eid'])){
	if(!is_numeric($_GET['eid'])){
		die("invalid ID");
	}
}
if(isset($_GET['s'])){
	$_GET['s'] = esc_attr($_GET['s']);
}

/*
*
=============================================================================
   LOAD IN FRAMEWORK IMAGES
============================================================================*/ 


// V8.3 + EVERYTHING IS NOW LISTING
define("THEME_TAXONOMY", "listing");
define('ppt_orderby_PATH',    get_template_directory()."/framework/orderby/");
define('ppt_orderby_URL',     get_template_directory_uri()."/framework/orderby/");
require_once get_template_directory() ."/framework/orderby/main.php";


/**
=============================================================================
   LOAD IN FRAMEWORK
============================================================================*/ 
$GLOBALS['ppt_start_time'] = microtime(true);
//require_once get_template_directory() ."/framework/new_class/ppt_extra_colors.php";
require_once get_template_directory() ."/framework/new_class/ppt_extra_install.php";
 

/*=============================================================================
   LOAD IN THEME EXTRAS
============================================================================*/

$coretheme = get_option('ppt_theme');
if($coretheme != ""){
	if(file_exists(get_template_directory() .'/_'.$coretheme.'/functions.php')){
		require_once get_template_directory() .'/_'.$coretheme.'/functions.php';
	}
}

/*=============================================================================
   LOAD IN THEME EXTRAS
============================================================================*/
 

// FRAMEWORK FUNCTIONS [SEPERATED]
require_once get_template_directory() ."/framework/new_class/ppt_1_functions.php";
require_once get_template_directory() ."/framework/new_class/ppt_2_layout.php";
require_once get_template_directory() ."/framework/new_class/ppt_3_media.php";
require_once get_template_directory() ."/framework/new_class/ppt_4_orders.php";
require_once get_template_directory() ."/framework/new_class/ppt_5_search.php";
require_once get_template_directory() ."/framework/new_class/ppt_6_shortcodes.php";
require_once get_template_directory() ."/framework/new_class/ppt_7_updates.php";
require_once get_template_directory() ."/framework/new_class/ppt_8_email.php";
require_once get_template_directory() ."/framework/new_class/ppt_9_ajax.php";
require_once get_template_directory() ."/framework/new_class/ppt_10_geo.php";
require_once get_template_directory() ."/framework/new_class/ppt_11_advertising.php";
require_once get_template_directory() ."/framework/new_class/ppt_12_addlisting.php";
require_once get_template_directory() ."/framework/new_class/ppt_13_user.php";
require_once get_template_directory() ."/framework/new_class/ppt_14_mobile.php";
require_once get_template_directory() ."/framework/new_class/ppt.php";

// FRAMEWORK CLASSES [INDEPENDANT]
require_once get_template_directory() ."/framework/new_class/ppt_extra_walkers.php";
require_once get_template_directory() ."/framework/new_class/ppt_extra_widgets.php";


require_once get_template_directory() ."/framework/new_class/ppt_core.php";
$CORE		= new premiumpress_themes;
 
require_once get_template_directory() ."/framework/new_class/ppt_hooks_filters.php"; 
require_once get_template_directory() ."/framework/new_class/ppt_adsearch.php";
 

require_once get_template_directory() ."/framework/new_class/ppt_gateways.php";

if(defined('WLT_CART')){
require_once get_template_directory() ."/framework/new_class/ppt_extra_cart.php";
$CORE_CART	= new framework_cart;
}


// ELEMENTOR PAGE BUILDER BLOCKS

require_once get_template_directory() ."/framework/elementor/elementor-functions.php";
if(defined('ELEMENTOR_VERSION') ){
require_once get_template_directory() ."/framework/elementor/elementor.php";
}


//if( defined('ET_BUILDER_PLUGIN_VERSION') ){
//require_once get_template_directory() ."/framework/divi/divi_load.php";
//}


/*=============================================================================
   LOAD IN ADMIN FRAMEWORK
============================================================================*/

if(is_admin()){
	require_once (get_template_directory() ."/framework/new_class/class_admin_design.php");
	require_once (get_template_directory() ."/framework/new_class/class_admin.php");
	
	$CORE_ADMIN	 			= new ppt_admin;
	 
	$WLT_ADMIN 				= $CORE_ADMIN;
 	
}else{
	add_action('init', array( $CORE, 'INIT') );
}
  
  
 
?>