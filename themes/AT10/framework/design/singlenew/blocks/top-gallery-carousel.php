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

if(isset($_GET['ppt_live_preview']) || isset($_GET['preview']) ||  ( isset($_GET['action']) && $_GET['action'] == "elementor") || isset($_POST['actions']) ){

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
 
<div id="sec-photos" class="card card-listing addtomenu echo big top-wrapper ">
  <div class="addeditmenu" data-key="imagestop"></div>
  <?php  if(count($files) > 0){ ?>
  <div class="card-body pb-0 clearfix text-center">
  
    <div class="gallery-items clearfix">
      <?php $i=1; foreach($files as $f){  if($i > 6){ continue; }  ?>
      <div class="gallery-item <?php if($i == 2){ echo "photo-2"; } ?>">
        <div class="grid-item-holder"> <a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-type="image"> <img src="<?php echo $f['src']; ?>" class="img-fluid" alt="image <?php echo $i; ?>"> </a> </div>
      </div>
      <?php $i++; } ?>
      
     
    
    </div>
 
    <?php if(count($files) > 3){ ?>
    
        <div class="gallery-items-nav">
    
      <?php $i=1; foreach($files as $f){  if($i > 6){ continue; }  ?>
       
        <div><img src="<?php echo $f['src']; ?>" class="img-fluid" alt="image <?php echo $i; ?>"></div>
        
        
      
      <?php $i++; } ?>
    </div>
    
    <?php } ?>
    
  </div>
  <?php } ?>
  <div class="p-4">
 
    <?php _ppt_template( 'framework/design/singlenew/blocks/top-content' ); ?>
  </div>
</div>
<?php if(count($files) > 0){ ?>
     
    <script src="<?php echo FRAMREWORK_URI.'js/js.plugins-slickslider.js'; ?>"></script>
    <script> 
    
    jQuery(document).ready(function(){  
     
      jQuery('.gallery-items').slick({
          centerMode: false,
          centerPadding: '0',
          slidesToShow: 1,
          slidesToScroll: 1,
		  autoplaySpeed: 10000,
		  adaptiveHeight: true,
          autoplay: true,
          prevArrow: '<span class="fal fa-angle-left left"></span>',
          nextArrow: '<span class="fal fa-angle-right right"></span>',
		  <?php if(count($files) > 3){ ?>
          asNavFor: '.gallery-items-nav'
		  <?php } ?>
    });
	  <?php if(count($files) > 3){ ?>
	jQuery('.gallery-items').attr('dir', 'ltr');
    
    jQuery('.gallery-items-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.gallery-items',
      dots: false,
	  
      nav:false,
	  prevArrow: '',
          nextArrow: '',
      centerMode: true,
      focusOnSelect: true
    });
	
	jQuery('.gallery-items-nav').attr('dir', 'ltr');
	<?php } ?>
    
    });
    </script>
    
<?php } ?>
