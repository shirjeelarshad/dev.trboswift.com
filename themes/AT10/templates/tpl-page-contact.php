<?php
   /*
   Template Name: [PAGE - CONTACT US]
   */
   
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   
   global  $userdata, $CORE; 
   
   $GLOBALS['flag-contact'] = true; 
  
$pageLinkingID = _ppt_pagelinking("contact");

if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header();
	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");	
	get_footer();

}else{
    
     
   if(!_ppt_checkfile("tpl-page-contact.php")){   	 
     
     // + GLOBAL HEADER
     get_header(); 
     
     // + PAGE TOP
     _ppt_template( 'page', 'top' ); 
	 
	 $CORE->LAYOUT("get_innerpage_blocks", array("page_contact","load"));	 
  

	// + PAGE BOTTOM
	_ppt_template( 'page', 'bottom' ); 
	
	// + GLOBAL FOOTER
	get_footer(); } } ?>