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

 $phone = get_post_meta($post->ID, "phone", true);
$website = get_post_meta($post->ID, "website", true);


?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?>
      <div class="float-left">
        <div class="opacity-5 small mt-4"> <?php echo do_shortcode('[CITY]'); ?> </div>
      </div>
      <div class="float-right"> <?php echo do_shortcode('[SCORE score_link=1]'); ?> </div>
      <div class="clearfix"></div>
      <hr />
      <?php } ?>
      <?php if(strlen($phone) > 1){ ?>
      <div class="h6">
        <div class="text-center bg-light p-3"> <i class="fal fa-phone-alt mr-2 text-primary"></i> <?php echo get_post_meta($post->ID, "phone", true); ?> </div>
      </div>
      <?php } ?>
      <?php if(strlen($website) > 1){ 
	 
			 if(substr($website,0,4) != "http"){
				$website = "https://".$website;
			}
	 ?>
      <a href="<?php echo $website; ?>" target="_blank" rel="nofollow" class="btn btn-block btn-system  btn-xl btn-icon icon-before mt-2 mb-2"><i class="fal fa-external-link mr-2 text-primary"></i> <?php echo __("Visit Website","premiumpress") ?></a>
      <?php } ?>
      <?php if(in_array(_ppt(array('design','display_comments')), array("","1")) ){ ?>
      <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn btn-block btn-system  btn-xl btn-icon icon-before mt-2 mb-2"><i class="fal fa-comments mr-2 text-primary"></i> <?php echo __("Write Review","premiumpress") ?></a>
      <?php 
	  
	  if(_ppt(array("design","single_br")) == "hide"){
	  
	   $GLOBALS['hidecomments'] = 1; 
	   _ppt_template( 'framework/design/singlenew/blocks/comments' ); 
	  
	  
	  } ?>
      <?php } ?>
      <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <?php if(_ppt(array('lst','adminonly')) == 1 || !$userdata->ID){ ?>
      <?php // CHECK FOR MEMBERSHIP ACCESS
	 
	 if(_ppt(array('mem','enable')) == "1" && _ppt("mem0_msg_send") != "1"){
	 
	 }else{
	 _ppt_template( 'framework/design/singlenew/parts/_contactform' ); 
	 }
	 
	 ?>
      <?php }else{ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-system  btn-xl btn-icon icon-before mt-2 "><i class="fal fa-envelope mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php } ?>
      <?php } ?>
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
      <?php if(in_array(_ppt(array('design','display_claim')), array("","1")) ){ ?>
      
	  <?php if( user_can( $post->post_author, 'edit_posts' ) && get_post_meta($post->ID,"claimed", true) == "" ){ ?>
      <a href="javascript:void(0)" <?php if(!$userdata->ID){ ?>onclick="processLogin();" <?php }else{ ?>onclick="processClaimPop();"<?php } ?> class="btn btn-block btn-light mt-2"><?php echo __("Claim This Page","premiumpress") ?> </a>
      <?php } ?>
      
      <?php if($userdata->ID){ ?>
      <script>function processClaimPop(){	 jQuery(".extra-modal-wrap").fadeIn(400);} </script>
      <!--msg model -->
      <div class="extra-modal-wrap shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-da-claim' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system  btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
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
