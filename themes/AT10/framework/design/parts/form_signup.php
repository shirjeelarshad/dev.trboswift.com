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

$GLOBALS['blockform'] =1;

global $CORE; ?>
<div class="card shadow-sm"><div class="card-body">

 <?php _ppt_template( 'ajax', 'modal-register' ); ?>
 
</div>
</div>