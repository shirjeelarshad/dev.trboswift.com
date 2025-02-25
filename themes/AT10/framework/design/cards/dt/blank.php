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
      
      
      <?php if(isset($post->maplat) &&  strlen($post->maplat) > 1 ){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Load Map","premiumpress"); ?>">
        <div> <a href="javascript:void(0);" 
    class="single-map-item text-primary" 
    data-title="<?php echo strip_tags($post->title); ?>" 
    data-url="<?php echo $post->link; ?>" 
    data-newlatitude="<?php echo $post->maplat; ?>" 
    data-address="<?php echo $post->maplocation; ?>" 
    data-newlongitude="<?php echo $post->maplong; ?>"><i class="fal fa-map-marker-alt"></i></a> </div>
      </li>
      <?php } ?>
    </ul>
   
    
    <div class="card-category mt-n2"><?php echo do_shortcode('[CATEGORY limit=1]'); ?></div>
    <h3 class="mt-1"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
     
    <?php if(strlen($post->city) > 1){ ?>
    <div class="card-bottom d-flex justify-content-between mt-3 hide-mobile small opacity-5">
     <div> <i class="fal fa-map-marker"></i> <?php echo $post->city; ?> </div> 
     
	 <div><?php echo do_shortcode('[DISTANCE]'); ?> </div> 
     
     </div>
	 <?php } ?>
        
    
  </div>
</div>
