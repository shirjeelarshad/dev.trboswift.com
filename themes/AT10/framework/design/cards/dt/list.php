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

$websitelink = get_post_meta($post->ID, "website", true);
if(strlen($websitelink) > 3 && substr($websitelink,0,4) != "http" ){
$websitelink = "https://".$websitelink;
}

?>

 <div class="<?php echo $post->cardclass; ?> mb-4 p-3" <?php echo $post->carddata; ?>>

<div class="row no-gutters">

    
<div class="col-12 text-center text-md-left pr-lg-5">

	<?php echo $post->image_formatted; ?>   

    
    <h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    
    <ul class="list-inline small opacity-5 hide-mobile mb-0">    	
        
        
        <li class="list-inline-item hide-mobile"><span class="mr-2"><?php echo do_shortcode('[CATEGORYICON]'); ?></span> <?php echo do_shortcode('[CATEGORY limit=1]'); ?></li>
         
      <?php if(strlen($post->city) > 1){ ?>
         <li class="list-inline-item"><i class="fal fa-map-marker"></i> <?php echo $post->city; ?> </li> 
         
      <?php } ?>
    
    <?php if(_ppt(array('design','display_openinghours')) == "1"){ ?>
    
    <li class="list-inline-item hide-mobile"><span class="text-success"><?php echo do_shortcode('[OPEN icon=1]'); ?></span></li>
    
    <?php } ?>
    
    </ul>
    
    <div class="small opacity-5 hide-mobile my-2"><?php echo do_shortcode('[EXCERPT limit=200]'); ?>...</div>
    
    <div> 
    
    <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-sm btn-system"><?php echo __("read more","premiumpress"); ?></a>   
    
    <?php if(strlen($websitelink) > 3){ ?>
     <a href="<?php echo $websitelink; ?>" rel="nofollow" target="_blank" class="btn btn-sm btn-system ml-2 hide-mobile"><?php echo __("visit website","premiumpress"); ?></a>   
   
    <?php } ?>
    
     </div>
    
    
</div>
<?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){

$totalcomments = $post->comment_count;

if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE') ){
$totalcomments = 3;
}


 ?>
<div style="width:60px; right:0px; top:0px;" class="position-absolute bg-white h-100 border-left hide-ipad hide-mobile">


<div class="text-dark text-center small border-bottom py-4">

<div class="text-uppercase tiny"><?php echo __("rating","premiumpress"); ?></div>
<div class="font-weight-bold mt-1">
 <?php echo do_shortcode('[SCORE size="text"]'); ?>
</div>

</div>



<div class="text-dark text-center small py-4">

<div class="text-uppercase tiny"><?php echo __("reviews","premiumpress"); ?></div>
<div class="font-weight-bold mt-1"><?php echo $totalcomments; ?></div>

</div>
</div>
    
<?php } ?>
 
</div>

</div>  