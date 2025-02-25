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

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-zoom card-top-image clearfix border-0">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
    <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
    </a>
	 
  </figure>
  <?php /***************** */ ?>
  <div class="card-body  p-0 py-3 bg-white">
    <div class="card-top">
      <h3 class="mb-2 font-weight-normal"><a href="<?php echo get_permalink($post->ID); ?>" class="text-dark"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    </div>
   <div class="small text-lowercase opacity-5"><?php echo do_shortcode('[CATEGORY]'); ?>  </div>	
  </div>
</div>
