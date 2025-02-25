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

 
	// SET DEFAULTS
	ob_start();
	 dynamic_sidebar("single_sidebar"); 
	$sidebar_content = ob_get_clean();
	
	if($sidebar_content == ""){
	
	global $settings;
	
	$settings['num'] = 3;
	
	_ppt_template( 'framework/design/widgets/widget', 'coupon-pop' );
	
	_ppt_template( 'framework/design/widgets/widget', 'blog-recent' );	 
	
	}
?>
 