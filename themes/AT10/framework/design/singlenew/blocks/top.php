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

// BACKGROUND IMAGE
$bgimg = get_post_meta($post->ID, "backgroundimg", true);
$bgfade = 8; 

if(substr($bgimg,0,6) == "custom"){

	$bgimg = wp_get_attachment_url(str_replace("custom-","", $bgimg));
	$bgfade  = 5;
	
}elseif(is_numeric($bgimg)){

	if(_ppt(array('bgimg', $bgimg)) == ""){ 
		$bgimg = DEMO_IMG_PATH."backgroundimages/".$bgimg.".jpg";
	}else{ 
		$bgimg = _ppt(array('bgimg', $bgimg));
	} 
	
}elseif(!is_numeric($bgimg)){

	if(_ppt(array('bgimg','1')) != ""){ 
	$bgimg = _ppt(array('bgimg', '1'));
	}else{
	$bgimg = DEMO_IMG_PATH."backgroundimages/1.jpg";
	}
	
}

$videoPreview = 0;
if(THEME_KEY == "vt"){
	$videoPreview = 1;
}

$bigPreview = 0;
 



if(THEME_KEY == "so" && $post->post_author == 1 && defined('WLT_DEMOMODE')){  

$bgimg = do_shortcode('[IMAGE link=0 pathonly=1]');

}


////////////////////////////////////////////////////

$showGallery = 0;
$showGridGallery = 0;
$showCarouselGallery = 0;
$showVideo = 0;
$showTextOnly= 0;
$showSlipt = 0;
 

// SHOW GALLERY OR DEFAUT
switch(_ppt(array('design','single_top'))){

	case "gallery": {
	
		$showGallery = 1;
	
	} break;
	
	case "gallery-grid": {
	
		$showGridGallery = 1;
	
	} break;
	
	case "gallery-carousel": {
	
		$showCarouselGallery = 1;
	
	} break;
		
	case "video": {
	
		$showVideo = 1;
	
	} break;
	
	case "textonly": {
	
		$showTextOnly = 1;
	
	} break;
	
	case "text-big": {
	
		$bigPreview = 1;
	
	} break;
	
	case "text-split": {
	
		$showSlipt = 1;
	
	} break;	
	

 
	
	default: {
	
	} break;
}

// DEFAULTS
if(in_array(THEME_KEY, array("es","rt")) && _ppt(array('design','single_top')) == "" ){
$showGallery = 1; 
}

if(in_array(THEME_KEY, array("dl")) && _ppt(array('design','single_top')) == "" ){
$showCarouselGallery = 1; 
}

if(in_array(THEME_KEY, array("cp")) && _ppt(array('design','single_top')) == "" ){
$showTextOnly = 1; 
}

if(in_array(THEME_KEY, array("ll")) && _ppt(array('design','single_top')) == "" ){
$bigPreview = 1; 
}


if($showVideo){

  _ppt_template( 'framework/design/singlenew/blocks/top-video' );   

}elseif($showGallery){

  _ppt_template( 'framework/design/singlenew/blocks/top-gallery' );  

}elseif($showCarouselGallery){

  _ppt_template( 'framework/design/singlenew/blocks/top-gallery-carousel' );  

}elseif($showGridGallery){

  _ppt_template( 'framework/design/singlenew/blocks/top-gallery-grid' );  

}elseif($showSlipt){

  _ppt_template( 'framework/design/singlenew/blocks/top-split' );  


}elseif($showTextOnly){

  _ppt_template( 'framework/design/singlenew/blocks/top-textonly' );  


}else{



 


?>

<div class="card mb-4 top-wrapper">
 
  <?php  if(in_array(THEME_KEY, array("ph")) ){  ?>
  <div class="position-relative bg-light  y-middle p-4">
  
    <div class="position-relative"> <?php echo do_shortcode('[IMAGE link=0 size=full]'); ?>  </div>
   
  </div>
  <?php } ?>
  <?php  if(!in_array(THEME_KEY, array("ph")) ){  ?>
  
     
  
  <div class="position-relative hero-single hero-single-big" style="overflow:visible !important;">
    <div class="bg-image" data-bg="<?php echo $bgimg; ?>"></div>
    <div class="overlay-inner opacity-<?php echo $bgfade; ?>"></div>
    <div class="bg-content">
    

    
      <div class="container">
        <div class="addeditmenu" data-key="top"></div>
        <div class="row <?php if($videoPreview) { ?>mb-4<?php } ?>">
          <?php  if(!in_array(THEME_KEY, array("so","cp")) ){  ?>
          <div class="<?php if($videoPreview) { ?>col-md-3 col-12 text-center<?php }elseif($bigPreview){ ?>col-md-4 text-center <?php }else{ ?>col-md-3 col-4 text-center<?php } ?>">
            <?php if($videoPreview) { ?>
            
            <div class="addeditmenu" data-key="video"></div>
            <div class=" videoplaybutton_wrap"> <a href="javascript:void(0);" onclick="processVideoOpen();" class="videoplaybutton bg-primary"> <i class="fa fa-play text-white"></i> <span class="ripple_playbtn bg-primary"></span> <span class="ripple_playbtn bg-primary"></span> <span class="ripple_playbtn bg-primary"></span> </a> </div>
          
            <?php }elseif($post->post_author == $userdata->ID){ ?>
            <div class="top-usericon mb-md-n4 ml-lg-3"> <a href="javascript:void(0);" onclick="processEditData('images');" class="float-right border rounded px-2 py-1 bg-light text-dark shadow-sm"> <?php echo do_shortcode('[IMAGE link=0 w=200]'); ?> </a> </div>
            <?php }else{ ?>
            
            <div class="top-usericon mb-md-n4 ml-lg-3"><a href="<?php echo do_shortcode('[IMAGE pathonly=1]'); ?>" id="topimagepreview" data-toggle="lightbox"><?php echo do_shortcode('[IMAGE link=0 w=200]'); ?></a> </div>
           
            <?php } ?>
          </div>
          <?php } ?>
          <div class="<?php if(in_array(THEME_KEY, array("so","cp")) ){ ?>col-12<?php }elseif($videoPreview){ ?>col-md-8<?php }elseif($bigPreview){ ?>col-md-7<?php  }else{ ?>col-8 col-md-9<?php } ?> text-light pl-lg-5 d-md-flex">
            <div style="align-self: flex-end;">
              <h1 class="h2 mb-2"><?php echo do_shortcode('[TITLE link=0]'); ?>
                <div class="addeditmenu" data-key="title"></div>
              </h1>
              <div class="clearfix mb-4">
                <?php if(in_array(THEME_KEY, array("dt","mj","ct","cm","sp","vt","jb","rt","so","cp","ll","at")) ){ ?>
                <span class="top-usericon-online full-view mt-2 mr-2"><?php echo do_shortcode('[CATEGORYICON]'); ?><span class="top-usericon-online__text-status ml-2"><?php echo do_shortcode('[CATEGORY limit=2]'); ?></span></span>
                <?php }?>
                <?php if(!in_array(THEME_KEY, array("cm","sp","vt","jb","rt","so","cp","ll"))  && $CORE->USER("get_online_status", $post->post_author)){ ?>
                <span class="top-usericon-online full-view mt-2"><i class="bgonline"></i><span class="top-usericon-online__text-status"><?php echo __("Online Now","premiumpress"); ?></span></span>
                <?php } ?>
                <?php if(in_array(THEME_KEY, array("sp")) ){  $qty = get_post_meta($post->ID, "qty", true );   if($qty == ""){ $qty = 10; }   $qty_min = 1; if($qty > 0){ ?>
                <span class="top-usericon-online full-view mt-2"><i class="bgonline"></i><span class="top-usericon-online__text-status"><?php echo __("In stock","premiumpress"); ?></span></span>
                <?php } } ?>
                <?php  if(in_array(THEME_KEY, array("vt","ll")) ){ ?>
                <span class="tiny mt-2 float-left ml-2"><?php echo do_shortcode('[LEVEL btn=1]'); ?></span>
                <?php } ?>
                 <?php  if(in_array(THEME_KEY, array("at")) ){ ?>
                <span class="top-usericon-online full-view mt-2 ml-2"><?php echo __("LOT","premiumpress"); ?>: <?php echo $post->ID; ?></span>
                <?php } ?>
                <?php  if(in_array(THEME_KEY, array("sp")) && get_post_meta($post->ID, "sku", true) != ""){ ?>
                <span class="top-usericon-online full-view mt-2"><i class="fa fa-hashtag mr-2"></i> <?php echo get_post_meta($post->ID, "sku", true); ?></span>
                <?php } ?>
                <?php  if(in_array(THEME_KEY, array("jb")) ){ ?>
                <span class="tiny mt-2 float-left ml-2"><?php echo do_shortcode('[JOBTYPE btn=1]'); ?></span>
                <?php } ?>
              </div>
              <?php if(in_array(THEME_KEY, array("at","mj","ct","dl")) &&  _ppt(array('lst','websitepackages')) == "1" && _ppt(array('lst','adminonly')) != 1 ){ ?>
              <ul class="list-inline text-muted pb-0 small">
                <li style="width:25px;" class="list-inline-item"><a href="<?php if(_ppt(array('user','allow_profile')) == 1){  echo get_author_posts_url( $post->post_author );  }else{ echo "#"; }?>" class="userphoto position-relative"> <?php echo str_replace("userphoto","rounded-circle",get_avatar( $post->post_author, 80 )); ?></a> </li>
                <li class="list-inline-item">
                  <?php if(_ppt(array('user','allow_profile')) == 1){ ?>
                  <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="text-white">
                  <?php } ?>
                  <?php echo $CORE->USER("get_username", $post->post_author); ?>
                  <?php if(_ppt(array('user','allow_profile')) == 1){ ?>
                  </a>
                  <?php } ?>
                </li>
                <li class="list-inline-item"> <?php echo do_shortcode('[RATING_USER]'); ?></li>
              </ul>
              <?php } ?>
            </div>
            <?php /*if(get_user_meta($post->post_author,'ppt_verified',true) == 1){ ?>
            <div class="btn btn-system text-success btn-sm"><i class="fa fa-award text-success"></i> <?php echo __("Verified","premiumpress") ?></div>
            <?php }else{ ?>
            <div class="btn btn-system text-danger btn-sm"><i class="fa fa-award text-danger"></i> <?php echo __("Not Verified","premiumpress") ?></div>
            <?php } */ ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
   
  <div class="card-body">
    <div class="p-lg-4"> 
     <?php _ppt_template( 'framework/design/singlenew/blocks/top-content' ); ?>
  	 </div>
   </div>
  
</div>
<?php } ?>