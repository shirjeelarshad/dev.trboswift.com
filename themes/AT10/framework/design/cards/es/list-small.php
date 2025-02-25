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

<div class="<?php echo $post->cardclass; ?> img-float" <?php echo $post->carddata; ?>>
  <div class="row no-gutters">
   
    <div class="col-lg-12">
    
    <?php echo $post->image_formatted; ?>
    
    
      <div class="new-search-body">
      
      
      <h3 class="h3-big"><a href="<?php echo $post->link; ?>"><?php echo $post->title; ?></a></h3>
      
      <div class="card-category mb-2">
      
	  <?php echo do_shortcode('[AGE]'); ?><?php if(_ppt(array('maps','enable')) == 1){ ?>, <?php echo do_shortcode('[CITY]'); ?> <?php }else{ ?>, <?php echo do_shortcode('[GENDER]'); ?><?php } ?>  
	  
	  <?php echo $CORE->USER("get_online_badge", $CORE->USER("get_online_status", $post->post_author)); ?>
      
      </div>
      
      <div class="mt-3 opacity-5 hide-mobile hide-ipad">
      <?php echo do_shortcode('[EXCERPT]'); ?>
      </div> 
         
      </div>
    </div>
  </div>
</div>