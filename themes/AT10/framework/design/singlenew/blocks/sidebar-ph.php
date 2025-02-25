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

if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE') ){

	$data = array("score" => 5, "votes" => 3);
 	
	$totalcomments = $data['votes'];
	 	
	$ratingStyle = "user";
 

}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ct")) ){

	$data = $CORE->USER("feedback_score", $post->post_author);  
 	
	$totalcomments = $data['votes'];
	
	$ratingStyle = "user";
	
}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ph")) ){

	$data = $CORE->USER("user_comment_score", $post->post_author);  
 	
	$totalcomments = $data['votes'];
	
	$ratingStyle = "user";
}

 
 
 ?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
    
    
     <a href="<?php echo $CORE->USER("get_user_profile_link", $post->post_author); ?>" class="userphoto" style="position:absolute; top:18px; left:20px; width:50px;height:50px;"> <?php echo str_replace("userphoto","rounded-circlex",get_avatar( $post->post_author, 80 )); ?></a>
      
     
       <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?> <div class="float-right">       <?php if($ratingStyle == "user"){ 
	  
	  if(isset($data['score'])){
	   echo do_shortcode('[SCORE user_rating=1 score_link=1 total_r='.$data['votes'].' total_s='.$data['score'].']');
	  }else{
	   echo do_shortcode('[SCORE user_rating=1 score_link=1]');
	  }
	  
	  }else{ echo do_shortcode('[SCORE score_link=1]'); } ?> </div><?php } ?>
       
    <div class="clearfix"></div>
    
      <hr />
      
    
   
   
      <ul class="list-group list-group-flush small mb-4">
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-clock mr-2"></i> <?php echo __("Added","premiumpress") ?>:</span> <span><?php echo date("F jS, Y",strtotime($post->post_date)); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-eye mr-2"></i> <?php echo __("Views","premiumpress") ?>:</span> <span><?php echo do_shortcode('[HITS]'); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><i class="fal fa-download mr-2"></i> <?php echo __("Downloads","premiumpress") ?>:</span> <span><?php echo do_shortcode('[DOWNLOADS]'); ?></span></li>
     <li class="list-group-item px-0 d-flex justify-content-between align-items-center"><span><span class="mr-2"><?php echo do_shortcode('[CATEGORYICON]'); ?></span> <?php echo __("Category","premiumpress") ?>:</span> <span class="text-lowercase"><?php echo do_shortcode('[CATEGORY]'); ?></span></li>
     
      </ul>

 <?php _ppt_template( 'framework/design/singlenew/parts/_ph_download' );  ?>
 
     
 
      
      
      
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
