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

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-top-image list product">
  <div class="row no-gutters">
    <div class="col-lg-4 bg-white border-right">
      <?php /************ MIAN IMAGE ***/ ?>
      <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
        <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
        </a> </figure>
      <?php /***************** */ ?>
    </div>
    <div class="col bg-white">
      <div class="card-body">
        <h3 class="mb-2"><a href="<?php echo get_permalink($post->ID); ?>" class="text-dark"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
        <p class="text-muted mt-3 small mb-0 d-none d-md-block"><?php echo do_shortcode('[EXCERPT limit=90]'); ?></p>
        <div class="card-bottom d-flex justify-content-between mt-3">
          <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo  $price; ?></span>
          
          <?php echo do_shortcode('[OLD-PRICE]'); ?>
          <div class="text-muted d-none d-md-block">
            <?php  echo do_shortcode('[CATEGORY]'); ?>
          </div>
          
          </div>
        </div>
        
        
        
      </div>
    </div>
  </div>
</div>
