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
 

$photosToShow = 3;
if(in_array(THEME_KEY, array("rt")) ){
$photosToShow = 2;
}

$maxPhotos = 3;
if(is_numeric( _ppt(array('design','gallery_num'))) ){
$maxPhotos = _ppt(array('design','gallery_num'));

	if($maxPhotos < 3){
	$photosToShow = $maxPhotos;
	}
}


$title = __("Photos","premiumpress"); 

if( isset($_GET['ppt_live_preview']) || isset($_GET['preview']) ||  ( isset($_GET['action']) && $_GET['action'] == "elementor") || isset($_POST['actions']) ){

	$preview = true;
	$files = array();
	$i= 1;
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
 
 
$filecount = count($files);

 
?>
 
 
<div class="card top-gallery mb-4 card-top-image">
 <div class="card-body">
 
 <div class="row">
	
    <div class="col-md-5">
  
  
   <?php if(!empty($files)){ ?>
 
  <div class="single-images-slider2-nav clearfix">
    <?php $i=1; foreach($files as $f){ if($i > $maxPhotos){ continue; } ?>
    <div class="gallery-item">
      <figure> <a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image">
        <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
        </a> <img <?php if(!isset($preview)){ ?>data-<?php } ?>src="<?php echo $f['thumbnail']; ?>" class="img-fluid lazy" alt="<?php if(isset($f['alt']) && strlen($f['alt']) > 1){ echo stripslashes(strip_tags($f['alt']));  }else{ ?>image <?php echo $i; ?><?php } ?>"> </figure>
    </div>
    <?php $i++; } ?>
  </div>
  <?php } ?>
  
  <?php if(!empty($files)  ){ ?>
  <?php 

// PRETTY PHTO LINKS
$i=0; foreach($files as $f){ if($i == 0){ $i++; continue; } ?>
  <a href="<?php echo $f['src']; ?>" data-gal="prettyPhoto[gal2]"></a>
  <?php $i++; } ?>


  <script src="<?php echo FRAMREWORK_URI.'js/js.plugins-slickslider.js'; ?>"></script>
  <script>
jQuery(document).ready(function(){  
 

jQuery('.single-images-slider2-nav').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  
  
  <?php if(count($files) > 4){ ?>
  speed: 500, 
 autoplaySpeed: 7000,
 autoplay: true,
 <?php } ?>
 
  
       prevArrow: '<span class="fal fa-angle-left left"></span>',
      nextArrow: '<span class="fal fa-angle-right right"></span>',
	  
  dots: false,
  nav:false,

  
  adaptiveHeight: true,
  lazyLoad: 'ondemand',
  
  
  // the magic
  responsive: [{

      breakpoint: 1024,
      settings: {
        slidesToShow: <?php echo $photosToShow; ?>,
        infinite: true
      }

    }, {

      breakpoint: 600,
      settings: {
        slidesToShow: <?php echo $photosToShow; ?>,
        infinite: true
      }

    }, {

      breakpoint: 300,
       settings: {
        slidesToShow: 1,
       infinite: true
      }

    }]
  
  
});

jQuery('.single-images-slider2-nav').attr('dir', 'ltr');

});
</script>
  <?php } ?>
  
  
  </div>
  
  <div class="col-md-7">
  <div class="pl-xl-4">
  
     
     <h1 class="h2 mt-4 mb-4"><?php echo do_shortcode('[TITLE link=0]'); ?></h1>
     
      <div class="addeditmenu" data-key="titletop"></div>
    </h1>
  
  
    <?php _ppt_template( 'framework/design/singlenew/blocks/top-content' ); ?>
    
  </div>
  </div>

    
    </div>
  </div>
</div>
 
