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

 

<div class="<?php echo $post->cardclass; ?>">
  <div class="list-view-wrapper">
    <div class="item-media"> <?php echo $post->image_formatted; ?> </div>
    <div class="item-content light-bg text-left rounded-bottom bg-white">
      <p class="model-name"> <?php echo do_shortcode('[TITLE]'); ?>, <?php echo do_shortcode('[AGE]'); ?> </p>
      <div class="model-location opacity-5"> <?php echo do_shortcode('[CITY]'); ?></div>
      <div class="mt-4">
       <?php echo do_shortcode('[EXCERPT]'); ?>
      </div>
       
      <div class="model-footer"> <a class="btn btn-system btn-md" href="<?php echo $post->link; ?>"><span><?php echo __("view profile","premiumpress"); ?></span></a>
      
            <?php if($CORE->USER("get_online_status", $post->post_author)){ ?>
     <?php echo $CORE->USER("get_online_badge", $CORE->USER("get_online_status", $post->post_author)); ?>
      <?php } ?>
      
      </div>
    </div>
  </div>
  
</div>
