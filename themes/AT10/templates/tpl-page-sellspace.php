<?php
   /*
   Template Name: [PAGE - ADVERTISING]
   */
   
   global $wpdb, $CORE, $userdata;
   
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   

$pageLinkingID = _ppt_pagelinking("sellspace");
 
if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header(); 

		echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");

	get_footer();

}else{
   
   // GET DATA
   $sellspace 	= $CORE->ADVERTISING("get_spaces", array() ); 
             
   $sellspacedata = _ppt('sellspace'); 
   
   // + GLOBAL HEADER
   get_header(); 
   
   // + PAGE TOP
   _ppt_template( 'page', 'top' );
   
   $CORE->LAYOUT("get_innerpage_blocks", array("page_sellspace","load")); 
  
	// + PAGE BOTTOM
	_ppt_template( 'page', 'bottom' ); 
   
	// + GLOBAL FOOTER
	get_footer(); 

}   ?>