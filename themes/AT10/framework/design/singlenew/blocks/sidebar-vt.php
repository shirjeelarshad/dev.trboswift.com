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

global $CORE, $userdata, $post, $CORE_VIDEO;
 
 
			   
	   $value = array();
			   
                  $status = array(
                      "" 		=> __("Everyone","premiumpress"),
                      "loggedin" 	=> __("Members Only","premiumpress"),		
                      "subs" 	=> __("Members With Subscriptions","premiumpress"), 
                  );
				  
				// GET ALL MEMBERSHIPS
				$all_memberships = $CORE->USER("get_memberships", array());
				foreach($all_memberships  as $key => $m){
							
						$status[$m['key']] = $m['name'];
							
				} 
				 
                  
                  $value = get_post_meta($post->ID,'videoaccess',true);
				   
				  // TESTING
				  if( _ppt(array('lst', 'requirelogin_videos' )) == '1'){
				  
				  $value["loggedin"] = "loggedin";
				  }
				   
?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <?php if($CORE_VIDEO->has_video_access()){ ?>
      
      
      <?php }else{ ?>
      <div class="bg-light text-dark p-4 text-center mb-3">
        <div class="h4"><?php echo __("Members Only","premiumpress"); ?></div>
        <?php if(is_array($value) && !empty($value) ){  
		
		$psks = "";
		  foreach($status as $key => $club){
					  if(in_array($key, array("","subs")) ){ continue; } 
                          if(in_array($key,$value) || in_array("mem".$key,$value) ){ 
                             $psks .= "<span class='badge badge-dark'>".$club."</span> "; 
                          }
                      } 
				  
				   echo '<p class="small">'.str_replace("%s",$psks,__("This video/series is available for %s members only","premiumpress")).'</p>'; 
                       
                  } 
		 ?>
        <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processUpgrade();"<?php } ?>  class="btn btn-system"><?php echo __("Upgrade Now","premiumpress") ?></a>
        <div class="small mt-2"> <a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=membership"><?php echo __("My Membership","premiumpress") ?></a> </div>
      </div>
      
      <?php
	  
	  // STOP THIS FOR FREE VIDEO PREVIEW
	  if(_ppt(array('lst', 'videopreview_enable')) == 1 && is_numeric(_ppt(array('lst', 'videopreview_seconds')))  ){ }else{ ?>
      <script>		
		jQuery(document).ready(function(){		
		jQuery(".videoplaybutton").attr("onclick","processUpgrade()");		
		});	
		</script>
        <?php } ?>
        
        
      <?php } ?>
      
      
      
      <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?>
      
      
      <div class="border-right text-center mb-4"> <?php echo do_shortcode('[SCORE size=big]'); ?> </div>
      
      <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-pencil mr-2 text-primary"></i> <?php echo __("Write Review","premiumpress") ?></a>
      
      
        <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentAll();"<?php } ?>  class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2"><i class="fal fa-comments mr-2 text-primary"></i> <?php echo __("Read Reviews","premiumpress") ?></a>
      
      
       <?php 
	  
	 // if(_ppt(array("design","single_br")) == "hide"){
	  
	   $GLOBALS['hidecomments'] = 1; 
	   _ppt_template( 'framework/design/singlenew/blocks/comments' ); 
	  
	  
	 // } ?>
     
      <?php } ?>
      
      
      
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
     
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add Favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-block btn-light mt-2" text=1 icon=1 icon_name="fal fa-heart"]'); ?>
      <?php } ?>
      
      <?php } ?>
      
      
      
    </div>
  </div>
</div>
<script>

 
function doratebutton(div, id, type){

 	jQuery('#'+div+' a').html("<i class='fas fa-spinner fa-spin'></i>");
	ajax_saverating(id ,type, div+''+type);  
	
	setTimeout(function(){  
		jQuery('#'+div+' a').html("<i class='fa fa-check'></i>");   
	}, 1000); 
 
}
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
