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

global $CORE;

if($CORE->ADVERTISING("check_exists", "header_top") ){ ?>
<div class="hide-ipad hide-mobile">
<?php echo $CORE->ADVERTISING("get_banner", "header_top" );  ?> 	
</div>
<?php } ?>
<button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars"></span></button>