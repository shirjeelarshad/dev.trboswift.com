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

$img = do_shortcode('[IMAGE pathonly=1]');

?>

<div class="<?php echo $post->cardclass; ?> no-resize img-user img-user-big bg-none" <?php echo $post->carddata; ?>>
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> <a href="<?php echo get_permalink($post->ID); ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>"> </a>
    
    
     <?php  if(isset($GLOBALS['distance_value']) && _ppt(array('maps','enable'))  == "1" ){  ?>
       
        <span class="badge small badge-dark text-light position-absolute font-weight-normal" style="top:10px; left:10px;"><i class="fal fa-map-marker mr-2 hide-mobile"></i> <?php echo do_shortcode('[DISTANCE]'); ?></span>
     
	 <?php } ?>
    
    <div class="list-info-pop bg-secondary">
      <ul class="list-unstyled">
        <li> <span><?php echo __("Age","premiumpress"); ?></span> <?php echo do_shortcode('[AGE]'); ?> </li>
        <li> <span><?php echo __("Height","premiumpress"); ?></span> <?php echo do_shortcode('[HEIGHT]'); ?> </li>
        <li> <span><?php echo __("Dress Size","premiumpress"); ?></span> <?php echo do_shortcode('[DRESSSIZE]'); ?> </li>
        <?php if(_ppt(array('maps','enable')) == 1){ ?>
        <li> <span><?php echo __("City","premiumpress"); ?></span> <?php echo do_shortcode('[CITY]'); ?></li>
        <?php } ?>
      </ul>
    </div>
  </figure>
  <?php /***************** */ ?>
  <div class=" pt-3 position-relative">
    <h3 class="mt-0 text-uppercase font-weight-bold"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
  </div>
</div>
