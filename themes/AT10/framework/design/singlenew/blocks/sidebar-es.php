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

$whatsapp = get_post_meta($post->ID, "whatsapp", true);

?>

<div class="sidebar-fixed-contentxx">


<div class="card card-listing" >
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
      <div class="text-center bg-light p-3">
      
      <i class="fal fa-phone-alt mr-2 text-primary"></i> <?php echo get_post_meta($post->ID, "phone", true); ?>
      
      </div>
       </div>
      <?php } ?>
      
     
      <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){  $GLOBALS['hidecomments'] =1; ?>
      
      <?php   _ppt_template( 'framework/design/singlenew/blocks/comments' ); ?>
      
      <?php } ?>
      
      
      <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
              <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message Me","premiumpress") ?></a>
              
              <?php } ?>
              
              
       <?php if(strlen($whatsapp) > 2){ ?>
       
           <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>" target="_blank" rel="nofollow" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2"><i class="fab fa-whatsapp mr-2 text-primary"></i> <?php echo __("WhatsApp Me!","premiumpress") ?></a>
       <?php } ?>
              
         
         <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
              
        <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
        <?php if(!$userdata->ID){ ?>
        <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add Favorites","premiumpress") ?></a>
        <?php }else{ ?>
        <?php echo do_shortcode('[FAVS class="btn btn-block btn-light mt-2" text=1 icon=0 icon_name="fal fa-heart"]'); ?>
        <?php } ?>
        
        <?php } ?>
        
        <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?>
        <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn btn-block btn-light mt-2"> <?php echo __("Write Review","premiumpress") ?></a>
     	<?php } ?>

</div>

</div>


<?php if(in_array(_ppt(array('design', 'display_rates')), array("","1"))){  ?>
 <?php _ppt_template( 'framework/design/singlenew/blocks/rates' );  ?>
    <?php } ?>
    
    
 
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
