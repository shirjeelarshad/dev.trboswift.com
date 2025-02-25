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
	
if(!isset($_POST['pid'])){ 
return "";
}


// DEMO CONTENT SETUP
if($_POST['uid'] == 1 && defined('WLT_DEMOMODE') ){

	$post = new stdClass();
	$post->ID 			= $_POST['pid'];
	$post->post_title 	= get_the_title($_POST['pid']); 
	$post->post_author 	= 1; 
	$post->post_excerpt = "";
	$post->post_content = "";	
	$post->post_type = "listing_type";
}

 
$files = $CORE->MEDIA("get_all_images", $_POST['pid']);	

 
 
if(empty($files) && $_POST['uid'] == 1 && defined('WLT_DEMOMODE')){

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

}


 
if(count($files) > 0){
?>

<div class="position-relative">
<button type="button" onclick="jQuery('.images-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm float-right position-absolute show-mobile" style="top:20px; right:20px; z-index: 1;"><i class="fa fa-times mr-0"></i></button>

<div class="row" style="
    max-height: 470px;
    overflow: hidden;
    overflow-y: auto;
">
  <?php
  
 
	$i=1; foreach($files as $f){ 
		
		if(strlen($f['src']) < 5){ continue; }

?>
  <div class="<?php if(count($files) == 1){?>col-12<?php }elseif(count($files) == 2){?>col-6<?php }else{ ?>col-6 col-md-4<?php } ?> mb-4"> <a href="<?php echo $f['src']; ?>"  
  
  <?php if(strlen(_ppt(array('pageassign','listingpage'))) < 2){ echo 'data-toggle="lightbox" '; } ?>
  
  data-gallery="example-gallery" data-type="image"> <img src="<?php echo $f['thumbnail']; ?>" class="img-fluid shadow-sm border" alt="image <?php echo $i; ?>"> </a> </div>
  <?php $i++; } ?>
</div>
</div> 
<?php }else{ ?>
<div class="bg-light p-5 border text-center" style="height:300px;">
  <div class=" opacity-5 mb-4 mt-5"><i class="fal fa-camera fa-4x"></i></div>
  <div class="opacity-5"><?php echo __("no images found","premiumpress") ?></div>
</div>
<?php } ?>
