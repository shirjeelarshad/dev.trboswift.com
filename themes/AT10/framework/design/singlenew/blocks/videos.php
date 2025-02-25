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

global $CORE, $post, $userdata; 

$GLOBALS['videoshown'] = 1;


////////////////////////////////////////////////////

$showAuthorBox = 0; $showRatingBox = 0; $showMapBox = 0; $showVideoBox = 0;

/* $switchtype = _ppt(array('design','single_mr')); */

$switchtype = "video";

if(isset($GLOBALS['videoshowme'])){
$switchtype = "video";
unset($GLOBALS['videoshowme']);
}


$title = "";
switch(THEME_KEY){

	case "ll": {
	$title = __("Intro Video","premiumpress");
	} break;
 
	default: {	
	$title = __("Videos","premiumpress");
	} break;
} 


// SHOW GALLERY OR DEFAUT
switch($switchtype){

	case "author": {
	
		$showAuthorBox = 1;
	
	} break;
	
	case "video": {
	
		$showVideoBox = 1;
	
	} break;
	
	case "rating": {
	
		$showRatingBox = 1;
	
	} break;
	
	case "map": {
	
		$showMapBox = 1;
	
	} break;
	
	default: {
	
		if( !in_array(THEME_KEY, array("da","es")) && $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1 && strlen(_ppt(array('maps','apikey'))) > 2){
		
			$showMapBox = 1;
		
		}elseif(in_array(THEME_KEY, array("mj","ct","dl","sp","vt","so","cp","ph","at","ll"))){
		
			$showRatingBox = 1;
		
		}	
	
	
	} break;
}

////////////////////////////////////////////////////


if( $showMapBox ){ 

_ppt_template( 'framework/design/singlenew/blocks/map' ); 

}elseif($showRatingBox){ 

_ppt_template( 'framework/design/singlenew/blocks/rating' ); 

}elseif($showAuthorBox){ 

_ppt_template( 'framework/design/singlenew/blocks/photos-user' ); 


}else{ 
        
$files = $CORE->MEDIA("get_all_images", $post->ID);	

$videos = $CORE->MEDIA("get_all_videos", $post->ID);
 
$youtubevid = 0;
$videmovid =0;

if( !is_array($videos) || is_array($videos) && empty($videos)){ 

	$youtubeid = get_post_meta($post->ID,'youtube_id',true);
 	 
	if($youtubeid != ""){	
	 
	$youtubevid = 1;
	$videos = array('');
	
	}
	
	$videid = get_post_meta($post->ID,'vimeo_id',true);
	if($videid != ""){	
	
	$videmovid = 1;
	$videos = array('');
	
	} 

}

?>

<div class="card p-lg-4 position-relative overflow-hidden"> <i class="fal fa-smile fa-8x text-primary" style="position:absolute; bottom:-25px; right:-15px;"></i>
  <div class="bg-image" data-bg="<?php if(isset($files[2]['src'])){  echo $files[2]['src']; }elseif(isset($files[0]['src'])){ echo $files[0]['src']; } ?>"></div>
  <div class="overlay-inner opacity-8"></div>
  <div class="bg-content text-white p-4">
    <div class="addeditmenu" data-key="video"></div>
    <h5 class="card-title"><?php echo $title; ?></h5>
    <div class="small mb-3"> <?php echo count($videos); ?> vids</div>
  
  
  
    <?php if(!$userdata->ID && in_array(_ppt(array('design', 'display_videologin')), array("","1")) ){ ?>
    <a onclick="processLogin();" href="javascript:void(0);" class="btn btn-system "><i class="fal fa-video text-primary mr-2"></i> <?php echo __("Watch Videos","premiumpress"); ?></a>
    <?php  }elseif( !$CORE->USER("membership_hasaccess", "view_videos") ){  ?>
    <a onclick="processUpgrade();" href="javascript:void(0);" class="btn btn-system "><i class="fal fa-video text-primary mr-2"></i> <?php echo __("Watch Videos","premiumpress"); ?></a>
    <?php }elseif( !is_array($videos) || is_array($videos) && empty($videos) && ($youtubevid == 0 && $videmovid ==0 )){ ?>
    <button class="btn btn-system " disabled><i class="fal fa-video  mr-2"></i> <?php echo __("No Videos","premiumpress"); ?></button>
    
    <?php }else{ ?>

    <a href="javascript:void(0);" onclick="processVideoOpen();" class="btn btn-system "><i class="fal fa-video text-primary mr-2"></i> <?php echo __("Watch Videos","premiumpress"); ?></a>

      <script> 
   function processVideoOpen(){	       
	 
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
  
  
    <?php } ?>
  </div>
</div>


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
<?php } ?>