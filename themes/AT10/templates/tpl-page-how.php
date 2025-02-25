<?php
/*
Template Name: [PAGE - HOW IT WORKS]
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
    
global  $userdata, $CORE; 
   
$pageLinkingID = _ppt_pagelinking("how");

if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header(); 

	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");

	get_footer();

}else{
   
    
   // + GLOBAL HEADER
   get_header(); 
   
   // + PAGE TOP
   _ppt_template( 'page', 'top' ); 
      
   if (have_posts()) : while (have_posts()) : the_post();

   
  if($post->post_content == ""){ 
      
    $CORE->LAYOUT("get_innerpage_blocks", array("page_how","load"));
 
   
   }else{
   
   
    the_content();   
   
    }
   
   
    endwhile; endif;  
 

	// + PAGE BOTTOM
	_ppt_template( 'page', 'bottom' ); 
	
	// + GLOBAL FOOTER
	get_footer(); } 
?>