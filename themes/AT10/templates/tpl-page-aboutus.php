<?php
/*
Template Name: [PAGE - ABOUT US]
*/
 
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
global  $userdata, $CORE;

$GLOBALS['flag-aboutus'] = 1;

$pageLinkingID = _ppt_pagelinking("aboutus");
 
if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header(); 

		echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");

	get_footer();

}else{
 
   
   get_header(); 
  
   _ppt_template( 'page', 'top' ); 
   
   $CORE->LAYOUT("get_innerpage_blocks", array("page_aboutus","load"));   
 
	_ppt_template( 'page', 'bottom' ); 
	
	get_footer(); 

} ?>