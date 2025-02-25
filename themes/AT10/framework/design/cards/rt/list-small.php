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
 
$beds = do_shortcode('[BEDS numonly=1]');
$baths = do_shortcode('[BATHS numonly=1]');
 
 
?>
<div class="<?php echo $post->cardclass; ?>" <?php echo $post->carddata; ?>>
  <div class="row no-gutters">
    <div class="col-lg-4">
       <?php echo $post->image_formatted; ?>
    </div>
    <div class="col-lg-8"> 
   
      <div class="new-search-body">
       
       
 <div class="card-category mb-2"><?php echo do_shortcode('[CATEGORY limit=1]'); ?></div>
      <h3><a href="<?php echo $post->link; ?>"><?php echo $post->title; ?></a></h3>
      
       
    <div class="card-bottom text-center d-md-flex justify-content-between mt-3">
      <div class="pricetag-big <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo $post->price; ?></div>
      <?php if($beds > 0){ ?>
      <div class="badge badge-default small hide-mobile hide-ipad pt-3" data-toggle="tooltip" data-placement="top" title="<?php echo $beds ." ".__("Beds","premiumpress"); ?> / <?php echo $baths ." ".__("Baths","premiumpress"); ?>">         
        <i class="fal fa-bed"></i> <?php echo $beds; ?> <span class="ml-2"> <i class="fal fa-bath"></i> <?php echo $baths; ?> </span>         
      </div>
      <?php } ?>
    </div>     
        
      </div>
    </div>
  </div>
</div>

 