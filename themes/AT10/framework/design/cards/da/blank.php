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

global $CORE, $post, $userdata;


$mydesc = do_shortcode('[EXCERPT]'); 
  	 
?>

<div class="<?php echo $post->cardclass; ?> no-resize" <?php echo $post->carddata; ?>> <?php echo $post->image_formatted; ?>
  <div class="card-body position-relative border-top">
    <ul class="list-inline btn-list cardtop hide-mobile hide-ipad" style="right:10px;">
      <?php if($CORE->USER("get_online_status", $post->post_author)){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Online Now","premiumpress"); ?>">
        <div> <i class="fa fa-circle text-success"></i> </div>
      </li>
      <?php } ?>
      <?php if(in_array(_ppt(array('user','favs')), array("","1"))){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Add Favorites","premiumpress"); ?>">
        <div> <?php echo do_shortcode('[FAVS icon=1 class="text-primary"]'); ?> </div>
      </li>
      <?php } ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Send Message","premiumpress"); ?>">
        <div> <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?>><i class="fal fa-envelope text-primary"></i></a> </div>
      </li>
    </ul>
    <div class="card-category mt-n2"><?php echo do_shortcode('[AGE]'); ?>
      <?php if(_ppt(array('maps','enable')) == 1){ ?>
      , <?php echo do_shortcode('[CITY]'); ?>
      <?php }else{ ?>
      , <?php echo do_shortcode('[GENDER]'); ?>
      <?php } ?>
    </div>
    <h3 class="mt-1"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    <?php if(strlen($mydesc) > 1){ ?>
    <div class="small opacity-5 hide-mobile hide-ipad"><?php echo do_shortcode('[EXCERPT]'); ?></div>
 	<?php } ?>
    
  </div>
</div>
