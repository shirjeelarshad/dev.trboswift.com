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


if($CORE->USER("get_verified", $post->post_author) == "1"){
$verified = '<span class="onlinebadge online text-dark badge border px-2 bg-white"><i class="fa fa-award text-success"></i> '.__("Email Verified","premiumpress").'</span>';
}else{
$verified = '<span class="onlinebadge online text-dark badge border px-2 bg-white"><i class="fa fa-award text-danger"></i> '.__("Not Verified","premiumpress").'</span>';
}


$videos = $CORE->MEDIA("get_all_videos", $post->ID);
$youtubevid = 0;
$videmovid =0;
$videoimage = "";
$videolink = "";
if(isset($videos['thumbnail'])){
	$videoimage = $videos['thumbnail'];
	$videolink = $videos['src'];
}

if( !is_array($videos) || is_array($videos) && empty($videos)){ 

	$videid = get_post_meta($post->ID,'youtube_id',true);
 	 
	if($videid != ""){	
	 
		$youtubevid = 1;
		$videlink = "https://www.youtube.com/watch?v=".$videid;	
		$videoimage = "https://i.ytimg.com/vi/".$videid."/hqdefault.jpg";
	
	}
	
	$videid = get_post_meta($post->ID,'vimeo_id',true);
	if($videid != ""){	
		
		$videlink = "https://player.vimeo.com/video/".$videid;	
		$videmovid = 1;
	
	} 

}	

$mydesc = do_shortcode('[EXCERPT]'); 

?>

<div class="<?php echo str_replace("list","",$post->cardclass); ?> mb-4 p-4 shadow-sm no-resize" <?php echo $post->carddata; ?>>
  <div class="row no-gutters">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-2">
          <div class="position-relative"> 
		  
		  <a href="<?php echo $CORE->USER("get_user_profile_link", $post->post_author); ?>">
		  <?php echo $CORE->USER("get_photo", $post->post_author); ?>
          </a>
          
          </div>
     
        </div>
        <div class="col pl-lg-3">
          <div class="row mr-0">
          
            <div class="col-md-6 col-xl-8">
              <h4><a href="<?php echo $post->link;?>" class="text-dark"><?php echo $post->title; ?></a></h4>
              <p class="small opacity-5">by <?php echo $CORE->USER("get_username", $post->post_author); ?> </p>
            </div>
            
            <div class="col-md-6 col-xl-4 text-md-right">
            
              <div class="mr-2"><?php echo do_shortcode('[SCORE]'); ?></div>
               
            </div>
            
          </div>
          
          
          <div class="mb-3 opacity-5"><?php echo do_shortcode('[EXCERPT]'); ?></div>
          <hr style="width:40px;margin: 0;" />
          <div class="row mt-4">
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">Category</div>
              <div class="userinfo-t2"><?php echo do_shortcode('[CATEGORY limit=1 link=0]'); ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">Language</div>
              <div class="userinfo-t2"><?php echo do_shortcode('[LANGUAGE]'); ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">Level</div>
              <div class="userinfo-t2"><?php echo do_shortcode('[LEVEL]'); ?></div>
            </div>
          </div>
          
          
        </div>
      </div>
    </div>
    <div class="col-md-4 border-left pl-4  text-center">
   <?php echo $post->image_formatted; ?>
    </div>
  </div>
</div>