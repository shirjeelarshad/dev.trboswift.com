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

 <div class="<?php echo $post->cardclass; ?> mb-4 p-3" <?php echo $post->carddata; ?>>

<div class="row no-gutters">

    
<div class="col-md-8 col-xl-10 col-lg-8 text-center text-md-left">

	<?php echo $post->image_formatted; ?> 

    
    <h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    
    <ul class="list-inline small hide-mobile">    	
        
        <li class="list-inline-item opacity-5"><?php echo do_shortcode('[GENDER]'); ?> , <?php echo do_shortcode('[AGE]'); ?> </li> 
          
		<?php if(_ppt(array('maps','enable')) == 1){ ?><li class="list-inline-item opacity-5"> <i class="fa fa-map-marker"></i> <?php echo do_shortcode('[CITY]'); ?></li> <?php } ?>
        
      <?php if($CORE->USER("get_online_status", $post->post_author)){ ?>
      
      <li class="list-inline-item">
        <?php echo $CORE->USER("get_online_badge", $CORE->USER("get_online_status", $post->post_author)); ?>
      </li>
      
      <?php } ?>  
    
    </ul>
    
    <div class="small opacity-5 hide-mobile hide-ipad"><?php echo do_shortcode('[EXCERPT]'); ?>...</div>
    
    
</div>
    
<div class="col-md-4 col-xl-2 col-lg-4 text-center text-lg-right y-middle">
    
     
    <a href="<?php echo get_permalink($post->ID); ?>"class="btn btn-primary rounded-0 btn-sm btn-block mt-1"><?php echo __("view profile","premiumpress"); ?></a>
    
    
</div> 
 
</div>

</div>  