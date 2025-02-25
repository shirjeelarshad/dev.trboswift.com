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

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-small card-zoom card-top-image clearfix card-1">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
    <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
    </a>
   
  </figure>
  <?php /***************** */ ?>
</div>
