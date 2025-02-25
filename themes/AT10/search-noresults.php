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

if(!_ppt_checkfile("search-noresults.php")){

global $CORE; 

?><div class="text-center noresults my-5 col-12 border py-5 bg-white">
   <div class="h4 pt-2"><?php echo __("No Results Found.","premiumpress") ?></div>
   <p><?php echo __("Try broadening your search to find more results.","premiumpress") ?></p>
   
   <p><a href="<?php echo home_url(); ?>/?s="><u><?php echo __("Start new search","premiumpress") ?></u></a> </p>
   
</div><?php } ?>