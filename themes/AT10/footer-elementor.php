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
 
global $CORE;
	
	 
	 
 	// GET TEMPLATE DETAILS
	$g = $CORE->LAYOUT("load_single_design", $_SESSION['design_preview']);
	
	  
	$preview_name = $g['key']."_footer - ".date('Y');
	
	// CHECK FOR PAGE
	$exi = get_page_by_title( $preview_name , OBJECT, 'elementor_library');	
	
	// CHECK EXISTS
	if ($exi && $exi->post_status == "publish") {
	
		$f = get_page_by_title( $preview_name , OBJECT, 'elementor_library');		
		 
		echo do_shortcode( "[premiumpress_elementor_template id='".$f->ID."']");
		 	
	
	// CREATE NEW ONE
	}else{	
	
		// DELETE CURRENT PAGE
		if($exi){
			wp_delete_post($exi->ID, true);
		}
	
		$elementor_file = $g['elementor']['footer'];	
	 
		if(!file_exists($elementor_file)){ unset($_SESSION['design_preview']); die("preview file not found"); }
		 
		// PROCESS IT 
		$elementor_importer = new PremiumPress_Elementor_Importer();
		$id = $elementor_importer->import_elementor_file( $elementor_file, $g['key']."_footer - ".date('Y') );
	
		// DISLAY IT
		 			
		echo do_shortcode( "[premiumpress_elementor_template id='".$id."']");	
		 
	}	
	
 

?>