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

global $CORE, $userdata, $post;

// PRICE AND TYPE
$price = get_post_meta($post->ID, "price", true);
$type = get_post_meta($post->ID, "type", true);
 
// DOWNLOAD ARRSY
$data_array = array(
	"uid" 		=> $userdata->ID,
	"pid" 		=> $post->ID,
);

 ?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div class="<?php echo $CORE->GEO("price_formatting",array()); ?> h2 font-weight-bold"> <?php echo do_shortcode('[PRICE]'); ?> </div>
        <div> <?php echo do_shortcode('[SCORE]'); ?> </div>
      </div>
      <hr />
      <ul class="list-group list-group-flush small mb-4">
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-clock mr-2"></i> <?php echo __("Added","premiumpress") ?>:</span> <span><?php echo date("F jS, Y",strtotime($post->post_date)); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-eye mr-2"></i> <?php echo __("Views","premiumpress") ?>:</span> <span><?php echo do_shortcode('[HITS]'); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-download mr-2"></i> <?php echo __("Downloads","premiumpress") ?>:</span> <span><?php echo do_shortcode('[DOWNLOADS]'); ?></span></li>
      </ul>
      <?php 
	  
	  // FREE DOWNLOAD
	  
	  if($price  == 0 ){  ?>
     
		  <?php if($type == 2){ ?>
          <a class="btn btn-lg btn-primary btn-block btn-icon icon-before" <?php if(!$userdata->ID && _ppt(array('lst', 'requirelogin_downloads' )) == '1'){ ?>href="javascript:void(0);" onclick="processLogin();"<?php }else{ ?>href="<?php echo get_post_meta($post->ID, "buy_link", true); ?>" target="_blank" rel="nofollow"<?php } ?>><i class="fal fa-download mr-2"></i> <?php echo __("Download Now","premiumpress"); ?></a>
          
          <?php }else{ ?>
          <button type="button" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2" <?php if(!$userdata->ID && _ppt(array('lst', 'requirelogin_downloads' )) == '1'){ ?>onclick="processLogin();"<?php }else{ ?>onclick="jQuery('#downloadnow<?php echo $post->ID; ?>').submit();"<?php } ?>><i class="fal fa-download mr-2"></i> <?php echo __("Download Now","premiumpress"); ?></button>
          <form method="post" action="" class="mt-3" id="downloadnow<?php echo $post->ID; ?>">
            <input type="hidden" name="data" value="<?php echo base64_encode( json_encode( $data_array ) ); ?>" />
            <input type="hidden" name="downloadproduct" value="1" />
          </form>
          <?php } ?>
     
      <?php } // end free download ?>
      
      <?php 
	  
	  // PAID DOWNLOAD	  
	  if($price  > 0 ){  ?>
      
      
      <?php if($type == 2){ ?>
      
      <?php }else{ ?>
      
	  <?php echo do_shortcode('[ADDCART btn=1 class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2"]<i class="fal fa-shopping-cart mr-2"></i>'. __("Add to Cart","premiumpress").'[/ADDCART]'); ?>    
     
      <?php } ?>    
      
      
      <?php } // end paid download ?>
      
<?php 
// DEMO DETAILS
$url = get_post_meta($post->ID, "url", true);
$url_demo = get_post_meta($post->ID, "url_demo", true);
if($url != "" &&  $url_demo != ""){
?>
 
  <?php if($url != ""){ ?>
  <a href="<?php echo $url ?>" class="btn btn-lg btn-system btn-block btn-icon icon-before mb-2" rel="nofollow" target="_blank"><i class="fal fa-link mr-2"></i> <?php echo __("Visit Website","premiumpress"); ?></a>
  <?php } ?>
  <?php if($url_demo != ""){ ?>
  <a href="<?php echo $url_demo; ?>" class="btn btn-lg btn-system btn-block btn-icon icon-before" rel="nofollow" target="_blank"><i class="fal fa-box mr-2"></i> <?php echo __("View Demo","premiumpress"); ?></a>
  <?php } ?>

<?php } ?> 
      
      
      
      <?php

// GET USER DOWNLOAD COUNT
if($price > 0 && $userdata->ID){

$freedownloads = 0;
$freedownloads = $CORE->USER("get_user_free_membership_addon", array("downloads", $userdata->ID));

if($freedownloads > 0){


?>
      <form method="post" action="" class="mt-3" id="downloadnow<?php echo $post->ID; ?>">
        <input type="hidden" name="data" value="<?php echo base64_encode( json_encode( $data_array ) ); ?>" />
        <input type="hidden" name="downloadproduct" value="1" />
      </form>
      <button type="button" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mb-2" <?php if(!$userdata->ID && _ppt(array('lst', 'requirelogin_downloads' )) == '1'){ ?>onclick="processLogin();"<?php }else{ ?>onclick="jQuery('#downloadnow<?php echo $post->ID; ?>').submit();"<?php } ?>><i class="fal fa-download mr-2"></i> <?php echo __("Download Now","premiumpress"); ?></button>
      <div class="text-center small mt-2"><?php echo str_replace("%s", $freedownloads, __("You have %s free downloads left.","premiumpress")); ?></div>
      <?php } } ?>
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
     
     <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?>
      <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn btn-block btn-light mt-2"><?php echo __("Write Review","premiumpress") ?></a>
    <?php } ?>
    
    
    <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-light  btn-block mt-3" text=1 icon=0]'); ?>
      <?php } ?>
      <?php } ?>
      
      
    </div>
  </div>
</div>
<script>

 
jQuery(document).ready(function(){    
  
		jQuery(".sidebar-fixed-content").scrollToFixed({
			minWidth: 1064,
			zIndex: 12,
			marginTop: 100,
			removeOffsets: true,
			limit: function () {
				var a = jQuery(".limit-box").offset().top - jQuery(".sidebar-fixed-content").outerHeight(true) - 48;
				return a;
			}
		});  
   
});

</script>
