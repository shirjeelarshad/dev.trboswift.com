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

global $CORE, $userdata, $post;


	switch(THEME_KEY){
		
		case "da": {
		
			 $title = __("Here's My Story","premiumpress"); 
			 
		} break;
		
		
		case "ll": {
		
			 $title = ""; 
			 
		} break;		 	
		case "rt": {
		
			 $title = ""; 
			 
		} break;
		
		default: {
		
			$title = ""; //__("Description","premiumpress");
		 
		} break;
	
	}
	
	if(_ppt(array('design','single_top')) == "gallery"){ $title = ""; }

?>

<div class="addeditmenu" data-key="content"></div>



<?php if(!in_array(_ppt(array('design','single_top')), array("", "text","text-split")) ){ ?>
   <h1 class="h4 mb-4">
      <?php if(THEME_KEY == "es" && get_post_meta($post->ID, 'photosverified', true) == 1 ){ ?>
      <span class="btn btn-system btn-small float-right hide-mobile hide-ipad mt-n2"><i class="fa fa-check text-success"></i> <?php echo __("Photos Verified","premiumpress"); ?></span>
      <?php } ?>
      <?php echo do_shortcode('[TITLE link=0]'); ?>
      <div class="addeditmenu" data-key="titletop"></div>
    </h1>

<?php } ?>


      
      
<?php if(in_array(THEME_KEY, array("ph","dl","dt")) && in_array(_ppt(array('design', 'display_subbar')), array("","1")) ){  ?>
<div class="row">
  <div class="col-lg-6 small"> <i class="fal fa-chart-bar mr-2"></i> <?php echo do_shortcode('[HITS]'); ?> <?php echo __("views","premiumpress") ?> <i class="fal fa-clock ml-2"></i> <?php echo __("Updated","premiumpress") ?> <?php echo do_shortcode('[TIMESINCE updated=1]'); ?> <?php echo __("ago","premiumpress"); ?> <i class="fal fa-hashtag ml-2"></i> <?php echo __("ID","premiumpress") ?>: <?php echo $post->ID; ?> </div>
  

  <div class="col-lg-6 text-lg-right hide-mobile"> 
  
   <?php /*if(in_array(_ppt(array('design', 'display_subbar_thumbs')), array("","1"))){ ?>
  <?php echo do_shortcode('[LISTING-RATEBOX]'); ?> 
   <?php } */ ?>
   

<?php if(in_array(_ppt(array('design', 'display_addthis')), array("","1"))){ ?>
<div class="addthis_inline_share_toolbox"></div>            
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6041aeed65b26d12"></script>
<?php } ?> 

  
  
  </div>

 
  <div class="col-md-12">
    <hr class="mt-lg-2" />
  </div>
</div>




<script>

function doratebutton(div, id, type){

 	jQuery('#'+div+' .rating'+type).html("<i class='fas fa-spinner fa-spin'></i>");
	ajax_saverating(id ,type, div+''+type);  
	
	setTimeout(function(){  
		jQuery('#'+div+' .rating'+type).html("<i class='fa fa-check'></i>");   
	}, 1000); 
 
}

</script>
<?php } ?>


<?php if(in_array(THEME_KEY, array("vt")) ){ global $CORE_VIDEO; 

$vidp = 1;
if(is_numeric(_ppt(array('lst', 'videopreview_seconds')))){
$vidp = _ppt(array('lst', 'videopreview_seconds'));
}

 ?>
<div class="row mt-lg-n3">
  <div class="col-lg-6 small"> <i class="fal fa-chart-bar mr-2"></i> <?php echo do_shortcode('[HITS]'); ?> <?php echo __("views","premiumpress") ?> <i class="fal fa-clock ml-2"></i> <?php echo __("Added","premiumpress") ?> <?php echo do_shortcode('[TIMESINCE]'); ?> <?php echo __("ago","premiumpress"); ?> <i class="fal fa-hashtag ml-2"></i> <?php echo __("Video ID","premiumpress") ?>: <?php echo $post->ID; ?> </div>
  <div class="col-lg-6 text-lg-right"> <?php echo do_shortcode('[RATEBUTTON]'); ?> </div>
  <div class="col-md-12">
    <hr class="mt-lg-0" />
  </div>
</div>
<script>
	  
	  
function doratebutton(div, id, type){

 	jQuery('#'+div+' .rating'+type).html("<i class='fas fa-spinner fa-spin'></i>");
	ajax_saverating(id ,type, div+''+type);  
	
	setTimeout(function(){  
		jQuery('#'+div+' .rating'+type).html("<i class='fa fa-check'></i>");   
	}, 1000); 
 
}
var i=1;
 
   function processVideoOpen(){	 
     

		// CHECK FOR RELOAD VALUE
		if(jQuery('#reloadform').length > 0){			
			reloadme = 1;
		}
	 
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
			  
			 
           },
           error: function(e) {
               console.log(e)
           }
       });
   
  
   
   } 
   
   </script>
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
<?php if($title != ""){ ?>
<h5 class="card-title"><?php echo $title; ?></h5>
<?php } ?>
<?php if(THEME_KEY == "es" && strlen(do_shortcode('[EXCERPT]')) > 1 ){ ?>
<i class="fa fa-flame text-danger"></i> <?php echo do_shortcode('[EXCERPT]'); ?>
<hr />
<?php } ?>



<?php if(in_array(THEME_KEY, array("ll")) ){ ?>

<div class="row">
<div class="col-md-8 ">
 
<h6 class="text-uppercase mb-3"><?php echo __("Course Description","premiumpress"); ?></h6>
<hr />
<div class="card-text">
<?php echo do_shortcode('[CONTENT]'); ?>
</div>


<?php if(strlen(get_post_meta($post->ID,'req',true)) > 5){ ?>

<div class="addeditmenu" data-key="customfields"></div>
<h6 class="text-uppercase mb-3"><?php echo __("Course Requirments","premiumpress"); ?></h6>
 <hr />
<div class="card-text">
<?php echo str_replace("/n/n","<br><br>",wpautop(get_post_meta($post->ID,'req',true))); ?>
</div>
<?php } ?>



 
<h6 class="text-uppercase mb-4"><?php echo __("Skills You'll Gain","premiumpress"); ?></h6>
<hr />
<div class="addeditmenu" data-key="features"></div>
<?php _ppt_template( 'framework/design/singlenew/blocks/features-code' );  ?>


</div>
<div class="col-md-4 pl-lg-4">



<div class="card card-body bg-light border-0">


 


      <ul class="list-group list-group-flush small mb-4 bg-light">
       
       <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-shopping-cart mr-2"></i> <?php echo __("Price","premiumpress") ?>:</span> <span><?php echo do_shortcode('[PRICE]'); ?></span></li>
       
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-clock mr-2"></i> <?php echo __("Added","premiumpress") ?>:</span> <span><?php echo date("F jS, Y",strtotime($post->post_date)); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-chart-bar mr-2"></i> <?php echo __("Views","premiumpress") ?>:</span> <span><?php echo do_shortcode('[HITS]'); ?></span></li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-download mr-2"></i> <?php echo __("Enrolled","premiumpress") ?>:</span> <span><?php echo do_shortcode('[ENROLLED]'); ?> <?php echo __("Students","premiumpress"); ?></span></li>
    
    <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-user mr-2"></i> <?php echo __("Level","premiumpress") ?>:</span> <span><?php echo do_shortcode('[LEVEL]'); ?></span></li>
    
   <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-light"><span><i class="fal fa-user mr-2"></i> <?php echo __("Language","premiumpress") ?>:</span> <span class="text-dark"><?php echo do_shortcode('[LANGUAGE]'); ?></span></li>
    
    
      </ul>


</div>
</div>
</div>




<?php }else{ ?>



    <?php if($CORE->USER("membership_hasaccess", "view_profile")){  ?>
  

<div class="card-text">

  <?php if(in_array(THEME_KEY, array("da","mj")) ){ ?>
  <i class="fa fa-quote-left fa-3x float-left mr-5 pb-4 hide-mobile opacity-5"></i>
  <?php } ?>
  
  <?php echo do_shortcode('[CONTENT]'); ?>
  
	<?php if(in_array(THEME_KEY, array("da","mj")) ){ ?>
    <i class="fa fa-quote-right float-right mt-n4 hide-mobile opacity-5"></i>
    <?php } ?>

</div>



  
  
  
      <?php }else{ ?>
    <div class="position-relative">
      <div class="post-body content-blur" style=" width: 100%;    height: 100%;    border: 5px solid #FFF;    background: #FFF;    clip: rect(300px, 415px, 605px, 0);    z-index: 2;    -webkit-transform: translate3d(0, 0, 0);    -webkit-transform-origin: 0 0;    -webkit-filter: blur(5px);    -webkit-backface-visibility: hidden;">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
        <blockquote>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
        </blockquote>
      </div>
      <div style="top:45%; left:-20px;" class="position-absolute w-100 text-center font-weight-bold"> <i class="fa fa-lock-alt mr-2"></i> <?php echo __("Members Only","premiumpress") ?> </div>
    </div>
    <?php } ?>
  
  
  
  




<?php } ?>


<?php

/*
if(in_array(THEME_KEY, array("so")) ){ 
// DEMO DETAILS
$url = get_post_meta($post->ID, "url", true);
$url_demo = get_post_meta($post->ID, "url_demo", true);
if($url != "" &&  $url_demo != ""){
?>
<hr />
<div class="btn-group" role="group">
  <?php if($url != ""){ ?>
  <a href="<?php echo $url ?>" class="btn btn-lg btn-primary" rel="nofollow" target="_blank"><i class="fal fa-link mr-2"></i> <?php echo __("Visit Website","premiumpress"); ?></a>
  <?php } ?>
  <?php if($url_demo != ""){ ?>
  <a href="<?php echo $url_demo; ?>" class="btn btn-lg btn-light" rel="nofollow" target="_blank"><i class="fal fa-box mr-2"></i> <?php echo __("View Demo","premiumpress"); ?></a>
  <?php } ?>
</div>
<?php } } */ ?>


<?php if(in_array(THEME_KEY, array("vt")) ){ ?>
<?php

$videoarray = array();
$vtest = get_post_meta($post->ID,'vt_video1',true);
if(is_numeric($vtest)){
$i =1; while($i < 10){
	
	$vif = get_post_meta($post->ID,'vt_video'.$i,true);
	if(is_numeric($vif)){
		$videoarray[$vif] = $vif;
	}
	
	$i++;

}
 
if(is_array($videoarray) && !empty($videoarray) ){


?>
<h6 class="card-title mt-4"><?php echo __("Videos in this series..","premiumpress"); ?></h6>
<div class="addeditmenu" data-key="videoseries"></div>
<?php

$args = array('post__in' => $videoarray,  'post_type' => "listing_type",  'orderby' => 'ID', 'order' => 'desc', 'paged'  => 1, 'offset'  => 0 );

$query1 = new WP_Query( $args );
 
if ( $query1->have_posts() ) {
?>
<div class="row mt-4">
  <?php while ( $query1->have_posts() ) { $query1->the_post(); ?>
  <div class='col-6 col-md-2 small'>
    <?php 
   
		global $settings;
		
		$settings 			= array();
		$settings["ID"] 	= $post->ID;
		$settings["card"] 	= "small";
		 
		
		// DISPLAY FEEDBACK 		
		_ppt_template( 'content-listing'); 	
		 
   
   ?>
  </div>
  <?php } ?>
</div>
<?php } wp_reset_query(); } ?>
<?php } } ?>
