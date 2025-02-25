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

    $img = do_shortcode('[STOREIMAGE checkimage=1]');
?>

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-top-image card-zoom bg-white list-small product mb-3">
  <div class="row no-gutters">
    <div class="col-lg-3 col-md-4 bg-white border-right y-middle">
      <?php /************ MIAN IMAGE ***/ ?>
      <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
        <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
        </a> </figure>
      <?php /***************** */ ?>
    </div>
    <div class="col">
      <div class="p-md-2 p-md-3">
        <div class="lead mb-2"><a href="<?php echo get_permalink($post->ID); ?>" class="text-dark small"><?php echo do_shortcode('[TITLE]'); ?></a></div>
       
          <div class="mt-2 small text-muted">
		  
          <?php echo __( 'Added', 'premiumpress' ); ?> <?php echo do_shortcode('[TIMESINCE]'); ?> <?php echo __("ago","premiumpress"); ?>
          
           <?php		  
		  $expdate = do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="'.__("Never Expires","premiumpress").'" key="listing_expiry_date"]');
		  if($expdate != "ended"){ ?>
           <i class="fal fa-clock mx-2"></i> 		 
		   <span class="hide-mobile"><?php echo __("Expires","premiumpress"); ?>:</span> <?php echo $expdate; ?>
          <?php } ?>
          
          </div>
         
     
      </div>
    </div>
  </div>
</div>
