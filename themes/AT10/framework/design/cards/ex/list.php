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

<div class="<?php echo $post->cardclass; ?> mb-4 p-4 shadow-sm" <?php echo $post->carddata; ?>>
  <div class="row no-gutters">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-2">
          <div class="position-relative"> <?php echo $CORE->USER("get_photo", $post->post_author); ?>
            <div class="position-absolute" style="right: 5px; bottom:0px;"> <?php echo $CORE->USER("get_country_flag", $post->post_author); ?> </div>
          </div>
          <div class="text-center"> <?php echo do_shortcode('[FAVS]'); ?> </div>
        </div>
        <div class="col pl-lg-3">
          <div class="row mr-0">
            <div class="col-md-6 col-xl-8">
              <h4><a href="<?php echo $post->link;?>" class="text-dark"><?php echo $CORE->USER("get_username", $post->post_author); ?></a></h4>
              <p><?php echo do_shortcode('[USERTYPE]'); ?></p>
            </div>
            <div class="col-md-6 col-xl-4 text-md-right">
              <div><?php echo do_shortcode('[RATING_USER uid='.$post->post_author.' reviews=0]'); ?></div>
              <p class="opacity-5 mt-3 small">
                <?php $data = $CORE->USER("feedback_score", $post->post_author);  $totalscore 	= $data['score'];	$totalreviews 	= $data['votes']; ?>
                <?php echo $totalreviews; ?> reviews</p>
            </div>
          </div>
          <div class="mb-3 opacity-5"><?php echo do_shortcode('[EXCERPT]'); ?></div>
          <hr style="width:40px;margin: 0;" />
          <div class="row mt-4">
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">From</div>
              <div class="userinfo-t2"><?php echo $CORE->USER("get_country", $post->post_author); ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">Living In</div>
              <div class="userinfo-t2"><?php echo $CORE->USER("get_city", $post->post_author); ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
              <div class="userinfo-t1">
                <?php if(get_user_meta($post->post_author,'user_type',true) == "user_em"){ ?>
                Teaches
                <?php }else{ ?>
                Learning
                <?php } ?>
              </div>
              <div class="userinfo-t2"><?php echo do_shortcode('[MYLANGUAGES]'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 border-left pl-4  text-center">
      <?php /*
      <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
        <li class="nav-item"> <a class="nav-link active" id="user-t1<?php echo $post->ID; ?>-tab" data-toggle="pill" href="#user-t1<?php echo $post->ID; ?>" role="tab" aria-controls="user-t1<?php echo $post->ID; ?>" aria-selected="true">Video</a> </li>
        <li class="nav-item"> <a class="nav-link" id="user-t2<?php echo $post->ID; ?>-tab" data-toggle="pill" href="#user-t2<?php echo $post->ID; ?>" role="tab" aria-controls="user-t2<?php echo $post->ID; ?>" aria-selected="false">Intro</a> </li>
        <li class="nav-item"> <a class="nav-link" id="user-t3<?php echo $post->ID; ?>-tab" data-toggle="pill" href="#user-t3<?php echo $post->ID; ?>" role="tab" aria-controls="user-t3<?php echo $post->ID; ?>" aria-selected="false">Contact</a> </li>
      </ul>
	  */ ?>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="user-t1<?php echo $post->ID; ?>" role="tabpanel" aria-labelledby="user-t1<?php echo $post->ID; ?>-tab">
          <?php if( !is_array($videos) || is_array($videos) && empty($videos) && ($youtubevid == 0 && $videmovid ==0 )){ ?>
          <div class="bg-light p-5 border text-center">
            <div class=" opacity-5 mb-3 mt-3"><i class="fal fa-video fa-4x"></i></div>
            <div class="opacity-5">user video unavailable</div>
          </div>
          <?php }else{ ?>
          <div class="position-relative" id="videopreviewcontainer<?php echo $post->ID; ?>">
            <div class="video_play-btn bg-primary text-center"> <a href="javascript:void(0);" onclick="processVideoPop('<?php echo $post->ID; ?>','videopreviewcontainer<?php echo $post->ID; ?>')" class="popup-yt"><i class="fas fa-play"></i></a> </div>
            <img src="<?php echo $videoimage; ?>" class="img-fluid" style="max-height:250px;" /> </div>
          <?php } ?>
        </div>
        <div class="tab-pane fade" id="user-t2<?php echo $post->ID; ?>" role="tabpanel" aria-labelledby="user-t2<?php echo $post->ID; ?>-tab">
          <div class="bg-light p-5 border text-center">
            <?php if(strlen($mydesc) > 2){ ?>
            <div> <i class="fa fa-quote-left float-left mr-2 opacity-5"></i> <?php echo $mydesc; ?> </div>
            <?php }else{ ?>
            <div class=" opacity-5 mb-3 mt-3"><i class="fal fa-pencil fa-4x"></i></div>
            <div class="opacity-5">user info unavailable</div>
            <?php } ?>
          </div>
        </div>
        <div class="tab-pane fade" id="user-t3<?php echo $post->ID; ?>" role="tabpanel" aria-labelledby="user-t3<?php echo $post->ID; ?>-tab">
          <div class="bg-light p-5 border text-center">
            <div class=" opacity-5 mb-3 mt-3"><i class="fal fa-comments-alt fa-4x"></i></div>
            <div class="opacity-5">user chat unavailable</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style> 

.video_play-btn {
    width: 80px;
    height: 80px;
	border-radius: 50%;
	    margin: auto;
top: 35%;
    position: absolute;  
    left: 40%;

}
.video_play-btn a i {
    line-height: 80px;
	margin-left:5px;
    font-size: 20px;
	color:#fff;
}
.hero_play_btn span {
    display: block;
    margin-top: 15px;
}
</style>
