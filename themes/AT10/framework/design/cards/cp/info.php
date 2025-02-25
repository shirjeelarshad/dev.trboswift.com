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

<div data-pid="<?php echo $post->ID; ?>" class="card-search border p-sm-3 bg-white mb-4">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure class="text-center"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo strip_tags($post->post_title); ?>"> </figure>
  <?php /***************** */ ?>
  <div class="card-body py-2">
    <div class="card-top">
      <h3 class="mb-1 font-weight-normal"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
      <div class="small opacity-5 mb-2"><?php echo do_shortcode('[STORENAME link=1]'); ?></div>
    </div>
    
    <?php if(_ppt(array('lst', 'cpcashback' )) != '0'){  ?>
    <div class="text-center mt-3 small font-weight-bold text-danger">
    <?php echo do_shortcode('[CASHBACK text="'.__("Earn %s cashback!","premiumpress").'"]'); ?>
    </div>
    <?php } ?>
    
    <div class="card-bottom mt-4"> <?php echo do_shortcode('[CBUTTON]'); ?> </div>
    

    
  </div>
</div>
