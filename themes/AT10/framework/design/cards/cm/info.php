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
   
   $price = do_shortcode('[PRICE]');
   if( $price == ""){
   	 $price = hook_price(100);
   }
 
?>

<div <?php if(isset($post->carddata)){ echo $post->carddata; } ?> data-pid="<?php echo $post->ID; ?>" class="card-search card-zoom card-top-image clearfix border-0 shadow-sm">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
    <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
    </a>
    <?php if( $CORE->PACKAGE("featured",$post->ID) ){ ?>
    <div class="fbit top-left bg-danger hide-mobile"><span><?php echo __("Featured","premiumpress"); ?></span></div>
    <?php } ?>
    <div class="fbit top-right p-0 z-1"><?php echo do_shortcode('[FAVS icon_only=1]'); ?></div>
  </figure>
  <?php /***************** */ ?>
  <div class="card-body  py-3 bg-white">
    <div class="card-top">
      <h3 class="mb-1 font-weight-normal"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
      <div class="small opacity-5 mb-2"><?php echo do_shortcode('[CATEGORY limit=1]'); ?></div>
    </div>
    <div class="card-bottom d-flex justify-content-between">
      <div class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo $price; ?></div>
    </div>
  </div>
</div>
