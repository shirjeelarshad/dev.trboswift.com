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
 
$storelink = do_shortcode("[STORENAME link=0 linkonly=1]");

$count = 0;

$storedata 	= wp_get_object_terms( $post->ID, 'store' ); 
if(is_array($storedata) && !empty($storedata)){
		
	$termid = $storedata[0]->term_id;
	$term = get_term( $storedata[0]->term_id, 'store' );
	$count =  $term->count;			
}


 





?>

<div class="card p-lg-4 position-relative overflow-hidden"> <i class="fal fa-smile fa-8x text-primary" style="position:absolute; bottom:-25px; right:-15px;"></i>
  <div class="bg-image  bg-light" data-bg="<?php echo do_shortcode("[STOREIMAGE]"); ?>"></div>
  <div class="overlay-inner opacity-8"></div>
  <div class="bg-content text-white p-4">
    <h5 class="card-title"><?php echo do_shortcode("[STORENAME link=0]"); ?></h5>
    <div class="small mb-3"> <?php echo $count; ?> <?php echo __("coupons &amp; offers","premiumpress"); ?></div>
    <a <?php if(strlen($storelink) > 2){ ?> href="<?php echo $storelink; ?>" <?php }else{ ?> href="javascript:void(0);" <?php } ?>  class="btn btn-system <?php if(strlen($storelink) == 0){ ?>opacity-5<?php } ?>" ><i class="fal fa-home  mr-2"></i> <?php echo __("Visit Store","premiumpress"); ?></a> </div>
</div>