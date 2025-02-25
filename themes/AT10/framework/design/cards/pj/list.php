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

global $CORE, $post; ?>


<div class="<?php echo $post->cardclass; ?> mb-4 p-3" <?php echo $post->carddata; ?>>

<div class="row no-gutters">
    
<div class="col-md-8 col-xl-10 col-lg-8 text-center text-md-left">
    
    <h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    
    <ul class="list-inline small opacity-5">    	
        
        <li class="list-inline-item"><i class="fal fa-clock mr-2"></i> <span class="hide-mobile"><?php echo __("Posted","premiumpress"); ?></span> <?php echo $CORE->PACKAGE("get_timesince", $post->post_date); ?></li> 
        
        <li class="list-inline-item hide-mobile"><span class="mr-2"><?php echo do_shortcode('[CATEGORYICON]'); ?></span> <?php echo do_shortcode('[CATEGORY limit=1]'); ?></li>
            
        <li class="list-inline-item hide-mobile"><i class="fal fa-users mr-2"></i>  <?php echo do_shortcode('[PROPOSALS]'); ?> <?php echo __("Proposals","premiumpress"); ?> </li>
         
    
    </ul>
    
    <div class="small opacity-5 hide-mobile hide-ipad"><?php echo do_shortcode('[EXCERPT]'); ?>...</div>
    
    
</div>
    
<div class="col-md-4 col-xl-2 col-lg-4 text-center text-lg-right">
    
    <div class="tiny text-uppercase opacity-5 hide-mobile hide-ipad"><?php echo __("Budget","premiumpress"); ?></div>
    
    <h4><?php echo do_shortcode('[BUDGET]'); ?></h4>
    
    <a href="<?php echo get_permalink($post->ID); ?>"class="btn btn-primary rounded-0 btn-sm btn-block mt-1"><?php echo __("view","premiumpress"); ?></a>
    
    
</div> 
 
</div>

</div>   
    