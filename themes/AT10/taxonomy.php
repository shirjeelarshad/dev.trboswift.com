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
 
$GLOBALS['flag-search'] = 1;
$GLOBALS['flag-taxonomy'] = 1;

$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
 
  
$GLOBALS['flag-taxonomy-type'] 	= $term->taxonomy;
$GLOBALS['flag-taxonomy-id'] 	= $term->term_id;
$GLOBALS['flag-taxonomy-name'] 	= $term->name;
$GLOBALS['flag-tax-'.$term->taxonomy] = 1;
 
 
_ppt_template( 'search' );

?>