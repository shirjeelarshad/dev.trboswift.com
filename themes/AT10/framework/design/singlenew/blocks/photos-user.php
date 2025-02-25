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

 

$files = array();

$filecount = $CORE->USER("count_listings", $post->post_author);
 
$defaultbg =  $CORE->USER("get_avatar", $post->post_author);

$title = "";
switch(THEME_KEY){


	case "ll": {
	$title = $CORE->USER("get_username",$post->post_author);
	} break;

	 
	default: {	
	$title = __("My","premiumpress")." ".$CORE->LAYOUT("captions",2);
	} break;
} 

?>

<div class="card  p-lg-4 position-relative overflow-hidden" >
  <div class="bg-image  bg-light" data-bg="<?php if(isset($files[1]['src'])){  echo $files[1]['src']; }elseif(isset($files[0]['src'])){ echo $files[0]['src']; }else{ echo $defaultbg; } ?>"></div>
  <div class="overlay-inner <?php if(empty($files)){ ?>opacity-8<?php }else{ ?>opacity-5<?php } ?>"></div>
  <div class="bg-content text-white p-4">
  
    
    <h5 class="card-title"><?php echo $title; ?></h5>
      
    <div class="small mb-3"> 
	
	<?php echo number_format($filecount); ?> <?php if($filecount == 1){  echo $CORE->LAYOUT("captions", 1); }else{ echo $CORE->LAYOUT("captions", 2); } ?> 
	
    <?php if(in_array(_ppt(array("design","display_comments")), array("","1"))){ ?>
    
    <?php echo do_shortcode('[RATING_USER reviews=0]'); ?> 
    
    <?php } ?>
	 
    
	
    
    
    </div>
   
    <?php if(!$userdata->ID && in_array(_ppt(array('design', 'display_photologin')), array("", "1"))  ){ ?>
 
    <a onclick="processLogin();" href="javascript:void(0);" class="btn btn-system "><i class="fal fa-user mr-2 text-primary shadow-sm"></i> <?php echo __("View Profile","premiumpress"); ?></a>
    
    <?php }else{ ?>
    
    <a href="<?php echo $CORE->USER("get_user_profile_link",$post->post_author); ?>" class="btn btn-system "><i class="fal fa-user mr-2 text-primary shadow-sm"></i> <?php echo __("View Profile","premiumpress"); ?></a>
    
     
    <?php } ?>
  </div>
</div>
 