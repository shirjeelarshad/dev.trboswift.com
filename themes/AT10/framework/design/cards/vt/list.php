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
<div data-pid="<?php echo $post->ID; ?>" class="card-search card-bg card-top-image p-2 mb-3 card-image-tiny">
  <div class="row no-gutters">
    <div class="col-lg-6 bg-white bbr">
      <div class="row">
        <div class="col-lg-3">
          <?php /************ MIAN IMAGE ***/ ?>
          <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
           <i class="fa fa-play-circle" aria-hidden="true"></i>
            </a> </figure>
          <?php /***************** */ ?>
        </div>
        <div class="col text-center text-lg-left">
          <div class="mt-2 font-weight-bold"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></div>
          <div class="small mt-2 text-muted"><?php echo do_shortcode('[CATEGORY limit=1]'); ?>, <?php echo do_shortcode('[HITS]'); ?> <?php echo __("views","premiumpress"); ?> <?php if( $CORE->PACKAGE("featured",$post->ID) ){ ?><span class="span-red hide-mobile tiny"><?php echo __("Featured","premiumpress"); ?></span><?php } ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 bg-white text-center text-lg-left">
      <div class="row">
        <div class="col-lg-7 bbr y-middle">
          <div class="pl-3">
            <div  class="mt-2"><strong><?php echo do_shortcode('[DURATION]'); ?></strong></div>
            <div class="mt-2 small text-muted"><?php echo do_shortcode('[LEVEL btn=1]'); ?>  </div>
          </div>
        </div>
        <div class="col-lg-5 text-center">
        
        
        <a href="<?php echo get_permalink($post->ID); ?>"class="btn btn-primary rounded-0 btn-sm btn-block mt-1"><?php echo __("watch now","premiumpress"); ?></a>
       <div class="mt-2 tiny text-muted text-center"><?php echo do_shortcode('[TIMESINCE]'); ?> <?php echo __("ago","premiumpress"); ?></div>
      
        </div>
      </div>
    </div>
  </div>
</div>
