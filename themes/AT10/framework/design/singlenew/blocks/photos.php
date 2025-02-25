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

$title = "";
switch(THEME_KEY){


	case "es": {
	$title = __("My Gallery","premiumpress");
	} break;

	case "da": {
	$title = __("My Photos","premiumpress");
	} break;
 
	default: {	
	$title = __("Photos","premiumpress");
	} break;
} 


////////////////////////////////////////////////////

$showAuthorBox = 0; $showRatingBox = 0; $showMapBox = 0; $showVideoBox = 0;

////////////////////////////////////////////////////

if(in_array(THEME_KEY, array("dl","ll")) && in_array(_ppt(array('design','single_top')), array("","gallery-carousel")) ){
$showAuthorBox = 1; 
}

 // SHOW GALLERY OR DEFAUT
switch(_ppt(array('design','single_ml'))){

	case "author": {
	
		$showAuthorBox = 1;
	
	} break;
	
	case "rating": {
	
		$showRatingBox = 1;
	
	} break;
	
	case "video": {
	
		$showVideoBox = 1;
	
	} break;
	
	case "map": {
	
		$showMapBox = 1;
	
	} break;
	
	default: {
	 
	
	
	} break;
}



////////////////////////////////////////////////////

if( $showVideoBox ){ 

$GLOBALS['videoshowme'] = 1;
_ppt_template( 'framework/design/singlenew/blocks/videos' ); 

}elseif( $showMapBox ){ 

_ppt_template( 'framework/design/singlenew/blocks/map' ); 

}elseif($showRatingBox){

_ppt_template( 'framework/design/singlenew/blocks/rating' ); 

}elseif(in_array(THEME_KEY, array("cp")) ){ 

_ppt_template( 'framework/design/singlenew/blocks/store' ); 

}elseif($showAuthorBox || in_array(THEME_KEY, array("ph")) ){ 

_ppt_template( 'framework/design/singlenew/blocks/photos-user' ); 

}else{

$files = array();

if(isset($_GET['ppt_live_preview']) || isset($_GET['preview']) ||  ( isset($_GET['action']) && $_GET['action'] == "elementor") || isset($_POST['actions']) ){

	$preview = true;	
	$i= 0;
	while($i < 10){
				
		$files[$i] = array(
				"name" 		=> "Example Image",
				"thumbnail" => "https://premiumpress.com/_demoimagesv10/wall".$i.".jpg",
				"src" 		=> "https://premiumpress.com/_demoimagesv10/wall".$i.".jpg",
				"ID" 		=> 1,
				);
		$i++; 
	}
}else{

$files = $CORE->MEDIA("get_all_images", $post->ID);	
 
}

 
$defaultbg = DEMO_IMG_PATH."backgroundimages/photos.jpg";

if(_ppt(array('bgimg', 'photos')) == ""){ }else{ $defaultimg =  _ppt(array('bgimg', 'photos' )); } 
 

 
?>

<div class="card  p-lg-4 position-relative overflow-hidden" >
  <div class="bg-image" data-bg="<?php if(isset($files[1]['thumbnail'])){  echo $files[1]['thumbnail']; }elseif(isset($files[0]['thumbnail'])){ echo $files[0]['thumbnail']; }else{ echo $defaultbg; } ?>"></div>
  <div class="overlay-inner <?php if(empty($files)){ ?>opacity-8<?php }else{ ?>opacity-5<?php } ?>"></div>
  <div class="bg-content text-white p-4">
    <div class="addeditmenu" data-key="images"></div>
    <h5 class="card-title"><?php echo $title; ?></h5>
    <div class="small mb-3"> <?php echo number_format(count($files)); ?> <?php if(count($files) == 1){  echo __("photo","premiumpress"); }else{ echo __("photos","premiumpress"); } ?></div>
   
    <?php if(!$userdata->ID && in_array(_ppt(array('design', 'display_photologin')), array("", "1"))  ){ ?>
    <a onclick="processLogin();" href="javascript:void(0);" class="btn btn-system "><i class="fal fa-camera mr-2 text-primary shadow-sm"></i> <?php echo __("View Photos","premiumpress"); ?></a>
    <?php }elseif( !$CORE->USER("membership_hasaccess", "view_photos") ){  ?>
    <a onclick="processUpgrade();" href="javascript:void(0);" class="btn btn-system "><i class="fal fa-camera mr-2 text-primary shadow-sm"></i> <?php echo __("View Photos","premiumpress"); ?></a>
    <?php }elseif(count($files) > 0 ){ ?>
    
    <a href="javascript:void(0);" onclick="processImagesOpen();" class="btn btn-system "><i class="fal fa-camera mr-2 text-primary shadow-sm"></i> <?php echo __("View Photos","premiumpress"); ?></a>
    
     
     <script>
 
 jQuery(document).ready(function(){ 
 
  
  jQuery("#topimagepreview").attr("data-toggle","");
 jQuery("#topimagepreview").attr("href","javascript:void(0);");
 jQuery("#topimagepreview").attr("onclick","processImagesOpen()");	
 });
 
 
   function processImagesOpen(){	 
     
       jQuery.ajax({
        type: "POST",
        url: ajax_site_url,		
   		data: {
               action: "load_images_form",	
			   pid: <?php echo $post->ID; ?>,
			   uid: <?php echo $post->post_author; ?>,	   
           },
           success: function(response) { 
		   
		   		jQuery(".images-modal-wrap").fadeIn(400);
   			 	jQuery('#imagesrajaxwindow').html(response); 
			 
           },
           error: function(e) {
               console.log(e)
           }
       }); 
   
   } 
   
   </script>

    
    
    
    <?php }else{ ?>
    <button disabled class="btn btn-system "><i class="fal fa-camera mr-2"></i> <?php echo __("View Photos","premiumpress"); ?></button>
    <?php } ?>
  </div>
</div>

      <!--msg model -->
      <div class="images-modal-wrap shadow hidepage" style="display:none;">
        <div class="images-modal-wrap-overlay"></div>
        <div class="images-modal-item">
          <div class="images-modal-container">
            <div class="card-body">
              <div id="imagesrajaxwindow"></div>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.images-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div> 
<?php } ?>