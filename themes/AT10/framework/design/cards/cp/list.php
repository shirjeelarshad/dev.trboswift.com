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

<div data-pid="<?php echo $post->ID; ?>" class=" bg-white border card-search mb-4">
  <div class="container-fluid p-3">
    <div class="row y-middle">
      <div class="col-lg-2"> <?php echo do_shortcode('[COUPONDATA]'); ?> </div>
      <div class="col-lg-7 text-center text-lg-left pl-lg-4 psoition-relative">
      
      <?php if($post->post_status == "expired"){ ?>
      
      <div class="position-absolute bg-danger small px-3 py-2 tiny text-white hide-mobile hide-ipad text-uppercase" style="top:-17px; right:0px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;"> <i class="fal fa-frown"></i> <?php echo __( 'Expired', 'premiumpress' ); ?> </div>
      
        <?php }elseif( $CORE->PACKAGE("featured",$post->ID) ){ ?>
        <div class="position-absolute bg-success small px-3 py-2 tiny text-white hide-mobile hide-ipad text-uppercase" style="top:-17px; right:0px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;"> <i class="fal fa-star"></i> <?php echo __( 'staff picks', 'premiumpress' ); ?> </div>
       
        <?php }elseif( $CORE->PACKAGE("sponsored",$post->ID) ){ ?>
        <div class="position-absolute bg-warning small px-3 py-2 tiny text-dark hide-mobile hide-ipad text-uppercase" style="top:-17px; right:0px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;"> <?php echo __( 'sponsored', 'premiumpress' ); ?> </div>
        <?php } ?>
        
        <div class="small mb-2 text-muted hide-mobile hide-ipad">
          <?php if(do_shortcode('[VERIFIED]')){ ?>
          <span class="text-success"><i class="fa fa-check"></i> <?php echo __( 'Verified', 'premiumpress' ); ?></span>
          <?php }else{ ?>
          <?php echo __( 'Not Verified', 'premiumpress' ); ?>
          <?php } ?>
          <i class="fa fa-angle-right mx-2"></i> <?php echo do_shortcode('[CATEGORY limit=1]'); ?>
          <?php if(do_shortcode('[USED]') > 0){ ?>
          <i class="fa fa-angle-right mx-2"></i> <?php echo do_shortcode('[USED]'); ?> <?php echo __( 'times used', 'premiumpress' ); ?>
          <?php } ?>
        </div>
        <h4 class="my-2 my-md-4 my-lg-0"><?php echo do_shortcode('[TITLE link=0 size=0]'); ?></h4>
        <div class="small mt-3 text-muted hide-mobile hide-ipad"> <img src="<?php echo do_shortcode('[STOREIMAGE]'); ?>" class="img-fluid float-left bg-white mr-3 border p-1" style="max-width:32px;" alt="<?php echo strip_tags(do_shortcode('[STORENAME]')); ?>" /> 
        
          
         <a href="<?php echo do_shortcode('[AFFLINK store=1]'); ?>" class="mt-2"><?php echo do_shortcode('[STORENAME link=0]'); ?> </a>        
        
        
        
        </div>
      </div>
      <div class="col-lg-3"> 
	  
	  
	  <?php echo do_shortcode('[CBUTTON]'); ?> 
      
      
      
      
       <div class="mt-4">
	   <?php echo do_shortcode('[CRATING]'); ?>
       </div>
       
        
       
       
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
    <div class="container-fluid px-0">
      <div class="row">
        <div class="col-lg-8 small hide-mobile hide-ipad">
          <div class="pt-1">
          
          <?php if(strlen($post->post_content) > 1 ){ ?>
          <span class="hide-mobile hide-ipad position-relative mr-4"><a href="javascript:void(0);" onclick="preview_desc('<?php echo $post->ID; ?>');"> <?php echo __( 'Terms', 'premiumpress' ); ?> <i class="fa fa-angle-down position-absolute" style="right:-10px; top:3px;"></i> </a> </span>
          <?php } ?>
          
          
		  <?php echo __( 'Added', 'premiumpress' ); ?> <?php echo do_shortcode('[TIMESINCE]'); ?> <?php echo __("ago","premiumpress"); ?>
            <?php		  
			
		  $expdate = do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="'.__("Never Expires","premiumpress").'" key="listing_expiry_date"]');
		   
		  if(strlen( $expdate) > 0 && $expdate != "ended"){ ?>
            <i class="fal fa-clock mx-2"></i> <?php echo __("Expires","premiumpress"); ?>: <?php echo $expdate; ?>
            <?php } ?>
            <?php $useddate = get_post_meta($post->ID,'lastused',true);
			
			 
			if($useddate != "" &&  ( strtotime(date("Y-m-d H:i:s", strtotime($useddate) ))  >  strtotime(date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " -1 day")))  )
			 
			
			){ $da = $CORE->date_timediff($useddate,''); ?>
            <span class="text-danger"><i class="fa fa-fire  ml-2 mr-1"></i> <?php echo str_replace("%s",  $da['string-small'], __("last used %s ago","premiumpress")); ?> </span>
            <?php } ?>
            
           
           
           
          </div>
        </div>
        <div class="col-lg-4 text-center text-md-right small cashbackbit"> <?php if(_ppt(array('lst', 'cpcashback' )) != '0'){  echo do_shortcode('[CASHBACK text="'.__("Earn %s cashback!","premiumpress").'"]'); } ?> </div>
      </div>
    </div>
  </div>
</div>

<div class="listingdec-<?php echo $post->ID; ?>"></div>
