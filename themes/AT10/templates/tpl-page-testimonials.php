<?php
/*
Template Name: [PAGE - TESTIMONIALS]
*/

global $wpdb, $post, $wp_query;

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

$GLOBALS['flag-testimonials'] = true;

$GLOBALS['flag-nosidebar'] = 1;



$pageLinkingID = _ppt_pagelinking("testimonials");

if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header(); 
	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");
	get_footer();

}else{
 
    
   // + GLOBAL HEADER
   get_header(); 
   
   // + PAGE TOP
   _ppt_template( 'page', 'top' ); 
   
    $CORE->LAYOUT("get_innerpage_blocks", array("page_testimonials","load"));
  

	// + PAGE BOTTOM
	_ppt_template( 'page', 'bottom' ); 

// + GLOBAL FOOTER
get_footer(); }  ?>