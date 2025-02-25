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
if (!defined('THEME_VERSION')) {	footer('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata, $settings;
 
 	 
$pageLinkingID = _ppt_pagelinking("footer");
	
if(isset($_GET['ppt_live_preview'])){
	
	
	}elseif(defined('NOHEADERFOOTER')){
	
		// DO NOTHING
		
	}elseif(_ppt(array('design','footer_style')) == "elementor" && isset($_SESSION['design_preview']) && strlen($_SESSION['design_preview']) > 1){ // CHILD THEME PREVIEWS		
		 
		_ppt_template( 'footer', 'elementor' ); 
			
	}elseif( substr($pageLinkingID ,0,9) == "elementor" ){ //&& !isset($_GET['design']) 
  	  
		echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");	
		
	}elseif ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
		
		
		 
		$slot1 = _ppt(array('design','slot1_style'));
		
		if(in_array($slot1, array("intro_4","intro_5","intro_6"))){
		
		// DO NOTHING
		
		}else{
		
		$design = _ppt(array('design','footer_style'));
	 	$GLOBALS['flag-footer-block'] = 1;
		if(strlen($design) > 1){	
		$CORE->LAYOUT("load_single_block",$design);	
		}			
		unset($GLOBALS['flag-footer-block']);
		
		}
	
}


 ?>