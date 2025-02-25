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

global $CORE, $post;
 
if(defined('THEME_KEY') && !in_array(THEME_KEY, array("cp"))){ 
if(in_array(_ppt(array('design', 'display_related')), array("","1"))){ ?>
<section class="section-top-40">
<div class="container-fluid">

<?php _ppt_template( 'framework/design/singlenew/blocks/related' ); ?>
 
</div>
</section>
<?php } } ?>