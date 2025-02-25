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


$ratingStyle = "all";
$totalcomments = $post->comment_count;
 

if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE') ){ // DEMO COMMMENTS

	$data = array("score" => 5, "votes" => 3);
 	
	$totalcomments = $data['votes'];
	 	
	$ratingStyle = "user"; 

}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ct","at","mj","dl")) ){ // USER FEEDBACK

	$data = $CORE->USER("feedback_score", $post->post_author);  
 	
	$totalcomments = $data['votes'];
	
	$ratingStyle = "user";
	
}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ph","cp")) ){ // BASIC COMMENTS

	$data = $CORE->USER("user_comment_score", $post->post_author);  
 	
	$totalcomments = $data['votes'];
	
	$ratingStyle = "user";
}

 

$defaultimg = DEMO_IMG_PATH."backgroundimages/users.jpg";

 


if(_ppt(array('bgimg', 'users')) == ""){ }else{ $defaultimg =  _ppt(array('bgimg', 'users' )); } 
 
 
?>

<div class="card  p-lg-4 position-relative overflow-hidden"> <i class="fal fa-smile fa-8x text-primary" style="position:absolute; bottom:-25px; right:-15px;"></i>
  <div class="bg-image  bg-light" data-bg="<?php echo $defaultimg; ?>"></div>
  <div class="overlay-inner opacity-8"></div>
  <div class="bg-content text-white p-4">
    <?php if($post->post_author == $userdata->ID && in_array(THEME_KEY, array("sp","vt")) ){ ?>
    <span class="float-right position-relative hide-mobile"><a href="javascript:void(0);" onclick="processCommentPop();" class="single-page-edit-button single-page-edit-button-bg"><i class="fal fa-pencil text-white"></i><span class="ripple single-page-edit-button-bg"></span><span class="ripple single-page-edit-button-bg"></span><span class="ripple single-page-edit-button-bg"></span></a></span>
    <?php } ?>
    <h5 class="card-title mt-n3"><?php echo __("User Rating","premiumpress"); ?></h5>
    <div class="mb-3">
      <?php if($ratingStyle == "user"){ 
	  
	  if(isset($data['score'])){
	   echo do_shortcode('[SCORE user_rating=1 total_r='.$data['votes'].' total_s='.$data['score'].']');
	  }else{
	   echo do_shortcode('[SCORE user_rating=1]');
	  }
	  
	  }else{ echo do_shortcode('[SCORE]'); } ?>
    </div>
    <?php 	 
	
	if(!$userdata->ID && in_array(_ppt(array('design','display_commentslogin')), array("1")) ){ ?>
   
    <a  href="javascript:void(0);" onclick="processLogin();" class="btn btn-system "><i class="fal fa-comments  mr-2"></i> <?php echo __("Read Reviews","premiumpress"); ?></a>
    
	<?php }else{ ?>
    
    <a <?php if($totalcomments > 0){ ?> onclick="processCommentAll();" <?php }else{ ?> <?php } ?>  href="javascript:void(0);" class="btn btn-system  <?php if($totalcomments == 0){ ?>opacity-5 <?php } ?>"><i class="fal fa-comments  mr-2"></i> <?php echo __("Read Reviews","premiumpress"); ?></a>
    
    <?php } ?>
  </div>
</div>

<?php if(in_array(THEME_KEY, array("so")) || ( _ppt(array('design','single_ml')) == "rating"  || _ppt(array('design','single_mr')) == "rating" )  ){

$GLOBALS['hidecomments'] = 1;
 ?>

<?php _ppt_template( 'framework/design/singlenew/blocks/comments' );  ?>

<?php unset($GLOBALS['hidecomments']); } ?>
