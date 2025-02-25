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

<div <?php if(isset($post->carddata)){ echo $post->carddata; } ?> data-pid="<?php echo $post->ID; ?>" class="card-search card-zoom card-top-image clearfix card-1 ">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> <a href="<?php echo get_permalink($post->ID); ?>">
  
  <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
  
    <i class="fa fa-play-circle" aria-hidden="true"></i>
    </a>
    
  </figure>
  <?php /***************** */ ?>
  <div class="card-body bg-white">
    <div class="card-top">
      <div class="small text-primary"><?php echo do_shortcode('[CATEGORY]'); ?></div>
      <h3 class="mb-2 font-weight-bold"><a href="<?php echo get_permalink($post->ID); ?>" class="text-dark"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    </div>
    <div class="card-middle">
      <div class="excerpt text-muted mt-2"><?php echo do_shortcode('[EXCERPT limit=90]'); ?></div>
    </div>
    <hr />
     <div class="card-bottom small"> 
	<?php echo do_shortcode('[LEVEL btn=1]'); ?>
      <div class="float-right mt-n2 hide-mobile"><?php echo do_shortcode('[SCORE]'); ?></div>
      </div>
  </div>
</div>
