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
 
if(!_ppt_checkfile("home-3.php")){  

	global $CORE;

	$design = _ppt(array('design','slot3_style'));
	if(strlen($design) > 1){	
	$CORE->LAYOUT("load_single_block",$design);	
	}

} ?>