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
 
   $img = do_shortcode('[IMAGE pathonly=1]');	 
  
?>
 
<div data-pid="<?php echo $post->ID; ?>" class="card-search card-small card-zoom card-top-image clearfix card-1 card-white">
  <div class="container-fluid p-3">
    <div class="row y-middle">
      <div class="col-5"> 
	  
	  <a href="<?php echo $post->link; ?>" class="text-decoration-none"><?php echo do_shortcode('[COUPONDATA]'); ?> </a> </div>
      <div class="col-7">
        <h3>
		
        <a href="<?php echo $post->link; ?>" class="text-decoration-none"><?php echo $post->title; ?></a>
        
        </h3>
        <div class="small mt-3 text-muted hide-mobile hide-ipad"> <img src="<?php echo do_shortcode('[STOREIMAGE]'); ?>" class="img-fluid float-left mr-3 border bg-white p-1" style="max-width:32px;" alt="<?php echo strip_tags(do_shortcode('[STORENAME]')); ?>" /> 
        <a href="<?php echo do_shortcode('[AFFLINK store=1]'); ?>" class="mt-2"><?php echo do_shortcode('[STORENAME link=0]'); ?> </a> 
        
        
        </div>
      </div>
    </div>
  </div>
</div>
