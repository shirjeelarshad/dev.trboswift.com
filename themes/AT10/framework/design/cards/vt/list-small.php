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

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-top-image card-zoom list-small card-bg">
  <div class="row no-gutters">
    <div class="col-xl-5 border-right">
      <?php /************ MIAN IMAGE ***/ ?>
      <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
        <i class="fa fa-play-circle" aria-hidden="true"></i>
        </a>
       
      </figure>
      <?php /***************** */ ?>
    </div>
    <div class="col">
      <div class="card-body py-xl-2">
        <h3 class="mb-2"><a href="<?php echo get_permalink($post->ID); ?>" class="text-dark"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
        
        <div class="card-bottom d-flex justify-content-between font-weight-bold mt-2"> 
          <?php echo do_shortcode('[LEVEL btn=1]'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
