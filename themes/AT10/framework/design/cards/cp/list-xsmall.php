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
	
	$type = strtolower(strip_tags(do_shortcode('[CTYPE]')));
	
	if($type == "offer"){
	$btnLik = do_shortcode('[AFFLINK pid="'.$post->ID.'"]');
	}else{
	$btnLik = $post->link;
	}
	 
?>

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-top-image card-zoom bg-white list-small product mb-3">
  <div class="row no-gutters y-middle">
    <div class="col-lg-4 bg-white border-right text-center">
      <?php /************ MIAN IMAGE ***/ ?>
      <figure class="bg-white"> <a href="<?php echo $btnLik; ?>"> <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>"></a> </figure>
      <?php /***************** */ ?>
    </div>
    <div class="col">
    
    
    
      <div class="p-2 pl-md-3">
        <div class="lead mb-2" style="min-height:60px;"><a href="<?php echo $btnLik; ?>" <?php if($type == "offer"){ ?>target="_blank"<?php } ?> class="text-dark small"><?php echo do_shortcode('[TITLE]'); ?></a></div>
        <div class="small text-muted"> 
      <?php		  
		  $expdate = do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="'.__("Never Expires","premiumpress").'" key="listing_expiry_date"]');
		  if($expdate != "ended"){ ?>
           <i class="fal fa-clock mx-2"></i> 		 
		  <span class="hide-mobile"><?php echo __("Expires","premiumpress"); ?>:</span> <?php echo $expdate; ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
