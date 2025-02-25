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

$count_pending = 0;
if($userdata->ID){ 

	$count_pending = $CORE->USER("count_offers_pending_by_postid", array($post->ID, $userdata->ID) );
	 
	$count_pending_id = $CORE->USER("get_offers_pending_by_postid", array($post->ID, $userdata->ID) );
	$canShowDownload = 0;
	
	if($count_pending_id  != 0 && get_post_meta($count_pending_id, "offer_complete",true) == 5){
	$canShowDownload = 1;
	$ddlink = get_post_meta($post->ID, "download_path", true);
	}

}
?>

<div class="sidebar-fixed-content">


<div class="card card-listing" >

    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div class="<?php echo $CORE->GEO("price_formatting",array()); ?> h2 font-weight-bold"> <?php echo do_shortcode('[PRICE]'); ?> </div>
        <div> <?php echo do_shortcode('[SCORE]'); ?> </div>
      </div>
      <hr />
 
      
     
      <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){  $GLOBALS['hidecomments'] =1; ?>
      
      <?php   _ppt_template( 'framework/design/singlenew/blocks/comments' ); ?>
      
      <?php } ?>
      
      
      
      <?php if($canShowDownload  ){ ?>
  
      
      <a href="<?php echo $ddlink; ?>" target="_blank" rel="nofollow" class="btn btn-block btn-success rounded-0 mb-3 shadow-sm">  <?php echo __("Download Course","premiumpress"); ?> </a>
	
    <?php } ?>
    
      
     <?php if(in_array(_ppt(array('design','display_offers')), array("","1")) && $count_pending == 0 ){ ?>
     
      <a href="javascript:void(0);" <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processMakeOffer();"<?php } ?> class="btn btn-block btn-primary btn-xl rounded-0 mb-3 shadow-sm">  <?php echo __("Take Course","premiumpress"); ?> </a>
      <script>
   
   function processMakeOffer(){	 jQuery(".extra-modal-wrap").fadeIn(400);} 
   
   
   
function BuyNowOffer(){

if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>"))
		{
		
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "single_offer_make",
			pid: <?php echo $post->ID; ?>,
			aid: <?php echo $post->post_author; ?>,
			skip_to_buy: 1,
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				window.location.href='<?php echo _ppt(array('links','myaccount')); ?>?showtab=offers&showoid='+response.oid;	
				  
  		 	
			}else{			
				console.log("Error trying to add.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
		
		}
		else
		{
		 
			e.preventDefault();
		}
}

   
   
   </script>
      <!--msg model -->
      <div class="extra-modal-wrap shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-ll-offer' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>      
      <?php } ?>
      
      
      
      
      
 <a href="javascript:void(0);" onclick="processVideoOpen1();" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mb-3"><i class="fal fa-video mr-2 text-primary"></i> 
 <?php echo __("Intro Video","premiumpress") ?></a>

     <!--msg model -->
      <div class="video-modal-wrap shadow hidepage" style="display:none;">
        <div class="video-modal-wrap-overlay"></div>
        <div class="video-modal-item">
          <div class="video-modal-container">
            <div class="card-body">
              <div id="videoplayerajaxwindow"></div>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.video-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      <script> 
   function processVideoOpen1(){	       
	 
       jQuery.ajax({
        type: "POST",
        url: ajax_site_url,		
   		data: {
               action: "load_video_form",	
			   pid: <?php echo $post->ID; ?>		   
           },
           success: function(response) { 
		   
		   		jQuery(".video-modal-wrap").fadeIn(400);
   				jQuery('#videoplayerajaxwindow').html(response); 
				
				
				jQuery('video').mediaelementplayer({videoWidth: '100%',  videoHeight: '100%',  enableAutosize: true,});
				
			 
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   } 
   
   </script>       
      
      
      
 
      
      
      <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
              <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message Me","premiumpress") ?></a>
              
              <?php } ?> 
         
         <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
              
        <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
        <?php if(!$userdata->ID){ ?>
        <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add Favorites","premiumpress") ?></a>
        <?php }else{ ?>
        <?php echo do_shortcode('[FAVS class="btn btn-block btn-light mt-2" text=1 icon=0 icon_name="fal fa-heart"]'); ?>
        <?php } ?>
        
        <?php } ?>
        
            <?php if(in_array(_ppt(array('design','display_comments')), array("","1")) ){ ?>
    
     <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?> class="btn btn-block btn-light mt-2"> <?php echo __("Write Review","premiumpress") ?></a>
     
     
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
