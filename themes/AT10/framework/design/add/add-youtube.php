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

global $CORE, $userdata;

if(isset($_GET['post'])){ $_GET['eid'] = $_GET['post']; }
 
 
?>

<div class="row">
  <div class="col-12 access_video_msg" style="display:none;">
<div class="bg-white y-middle">
      <div class="p-4 text-center">
        <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class="mt-4 small"><?php echo __("Please upgrade or select a different package to access this feature.","premiumpress"); ?></div>         
        </div>
    </div>
  </div>
  <div class="col-12 access_video_options">
    <div class="bg-light p-4">
    
  
    <a href="http://www.youtube.com" class="btn btn-system btn-sm shadow-sm float-right" target="_blank"><?php echo __("Visit Youtube","premiumpress") ?> <i class="fa fa-angle-right ml-3"></i></a>
    
    
      <div class="font-weight-bold"><?php echo __("Youtube Video","premiumpress"); ?></div>
       <p class="mt-4"><?php echo __("Add a YouTube video to your page by entering the YouTube link or Video ID below;","premiumpress") ?></p>
       
      <div class="position-relative">
        <input type="text" placeholder="<?php echo __("Youtube Video ID","premiumpress") ?>" class="form-control input-lg btn-block mb-3" name="custom[youtube_id]" onchange="ProcessyouTubeVieo();"  id="youtube_videid" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "youtube_id",true ); } ?>" />
        <span class="input-group-addon" style="top: 10px;    <?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:10px;"; }else{ echo "right:10px;";  } ?>      position: absolute;    z-index: 100;"> <span class="fab fa-youtube"></span> </span> </div>
      <iframe id="youtube_videoframe" width="100%" height="240" style="display:none;"></iframe>
      <div id="videoloading" class="text-center"></div>
      <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "youtube_id",true ) != ""){ ?>
      <div id="videoplayer">
        <iframe width="100%" height="240px" src="https://www.youtube.com/embed/<?php echo get_post_meta($_GET['eid'], "youtube_id",true ); ?>"></iframe>
      </div>
      <?php }else{ ?>
      <div id="videopreview" class="bg-light btn-block text-center text-dark text-uppercase" style="min-height:300px; line-height:300px;display:none;"><?php echo __("Video Preview","premiumpress") ?></div>
      <?php } ?>
    </div>
  </div>
 
</div>
<script>

function ProcessyouTubeVieo(){
   
    
   var videoID = jQuery('#youtube_videid').val();
  
   	if(videoID.length != 11){
   	
   		var videoid = videoID.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
   		if(videoid != null) {
   		   videoID = videoid[1];
   		   jQuery('#youtube_videid').val(videoID);
   		} 		
   	}
}

</script>
