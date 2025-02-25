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

  	 
?>

<div class="<?php echo $post->cardclass; ?>" <?php echo $post->carddata; ?>> <?php echo $post->image_formatted; ?>
  <div class="card-body position-relative border-top">
    <ul class="list-inline btn-list cardtop hide-mobile hide-ipad" style="right:10px;">
    <?php if(in_array(_ppt(array('user','favs')), array("","1"))){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Add Favorites","premiumpress"); ?>">
        <div> <?php echo do_shortcode('[FAVS icon=1 class="text-primary"]'); ?> </div>
      </li>
      <?php } ?>
 
    </ul>
   
    
    <div class="card-category mt-n2"><?php echo do_shortcode('[CATEGORY limit=1]'); ?></div>
    <h3 class="mt-1"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
     
  <?php echo do_shortcode('[LEVEL btn=1]'); ?>
        
    
  </div>
</div>
