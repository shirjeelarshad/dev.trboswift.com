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

global $CORE, $settings, $post;

 $files = $CORE->MEDIA("get_all_images", $post->ID);
 
   // ADMIN PREVIEW
    if(!isset($post->ID)){
		$post = new stdClass();
		$post->ID 			= 1;
		$post->post_title 	= "This is a sample title."; 
		$post->post_author 	= 1; 
		$post->post_excerpt = "";
		$post->post_content = "";
	}
	
	$thiscard = "";
 
	if(isset($settings['card']) && strlen($settings['card']) > 0){
		$thiscard = $settings['card'];
	} 
 
	// TALL
	// LARGE
	// NORMAL
	// SMALL
	// LIST

	if(!in_array($thiscard, array('blank','info','small', 'list', 'list-small', 'list-xsmall','user'))){	
	$thiscard = "info";	
	}
	
	// LINK
	$post->link = get_permalink($post->ID);
	
	// TITLE
	$post->title = do_shortcode('[TITLE]');
	
	// LOCATION
	$post->carddata = 'data-pid="'.$post->ID.'"';
	if(_ppt(array('maps','enable')) == 1 ){
		
		// HIDE DATA FOR BASIC MAP SETUP
		if(_ppt(array("maps","provider")) != "basic"){
		
			$long 		= get_post_meta($post->ID,'map-log',true); 
			$lat 		= get_post_meta($post->ID,'map-lat',true);	
			$address 	= get_post_meta($post->ID,'map-location',true);
					
			$post->carddata = 'data-pid="'.$post->ID.'" data-lat="'. $lat.'" data-long="'.$long.'" data-address="'.$address .'" ';
			$post->maplat = $lat;
			$post->maplong = $long;
			$post->maplocation = do_shortcode('[LOCATION]');
		
		}
		
		$post->city = do_shortcode('[CITY]');
	
	}
	
	// CLASS
	$extracss = "";
	if(in_array(THEME_KEY, array("sp")) ){  //|| user_can($post->post_author, 'administrator') 
	$extracss = "no-resize";
	}
	$post->cardclass = "card-search card-".$thiscard." card-theme-".THEME_KEY." card-zoom bg-white ".$extracss; // card-top-image  bg-white list-xsmall product mb-3 no-img-resize	
	
	// IMAGE
	if(in_array(THEME_KEY, array("pj")) ){
	
	$imgdata = $CORE->MEDIA("get_image_category", $post->ID);
	$post->image = $imgdata['thumbnail'];
	$post->imageh = $imgdata['h'];
	$post->imagew = $imgdata['w'];
	
	}else{
	
	$imgdata = $CORE->MEDIA("get_image_data", $post->ID);
	$post->image = $imgdata['thumbnail'];
	$post->imageh = $imgdata['h'];
	$post->imagew = $imgdata['w'];
	}
	 
	
	$post->price = do_shortcode('[PRICE]');
	
	$post->featured = $CORE->PACKAGE("featured",$post->ID);
	
	
	
	if($thiscard  == "list" && in_array(THEME_KEY, array("es"))  ){
	$post->cardclass = "list-view mb-4 img-user".$extracss; // card-top-image  bg-white list-xsmall product mb-3 no-img-resize	
	
	}else{
	$post->cardclass = "new-search ".$thiscard." ".$extracss; // card-top-image  bg-white list-xsmall product mb-3 no-img-resize	
	
	}
	 	
	
	// IMAGE
	ob_start();?>
	 <div> 
     <?php if(in_array($thiscard, array("small")) ){
     ?>
     
    <?php if( count($files) == 1 ){
			?>
        <figure class="home-gallery-card">
  <a href="<?php echo $post->link; ?>">  

        <img data-src="<?php echo $post->image; ?>" class="home-gallery-img img-fluid lazy"  alt="<?php echo $post->post_title; ?>">

 </a>
 </figure>
			<?php } elseif (count($files) > 0) { ?>
            <figure class="home-gallery-card">
  <a href="<?php echo $post->link; ?>">           
  <div class="row m-0 p-0 home-gallery" >
  <div class="<?php if((count($files) == 1)){echo 'col-12';}else{ echo 'col-lg-8 col-md-8 col-sm-8';} ?> m-0 p-0">
  <img data-src="<?php echo $post->image; ?>" class="home-gallery-img1 img-fluid lazy"  alt="<?php echo $post->post_title; ?>">
  </div>
  
  <div class="col-lg-4 col-md-4 col-sm-4 home-gallery-mobile-bottom m-0 p-0">
    <?php $i = 1; foreach ($files as $f) { ?>
        <?php if ($i === 1) {} elseif ($i >= 2) { ?>
          <img src="<?php echo $f['thumbnail']; ?>" alt="image <?php echo $i; ?>" class=" <?php if(count($files) == 2){ echo 'home-gallery-img2';}else{echo 'home-gallery-img3';} ?> img-fluid lazy">
        <?php } ?>
      <?php 
        $i++;
        if ($i > 3) {
          break;
        } } ?>
  </div>
 </div>
 </a>
 </figure>
 <?php } ?>
     
        <div class="home-banner-title">
          
  <span class="font-weight-bold"><?php echo do_shortcode('[TITLE]'); ?></span>
         
        </div>
        
        <div class="home-banner-ending-bid d-flex p-1">
        
         
         <span class="pr-2 "><?php echo do_shortcode('[TIMELEFT]'); ?></span>
         <span>Bid <?php echo do_shortcode('[PRICE]'); ?></span>
        </div>
        
        <?php }else { ?>
        
        <figure class="search-card-img">
        <a href="<?php echo $post->link; ?>"> <img data-src="<?php echo $post->image; ?>" style="height:235px; width:100%; object-fit:cover" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
        <div class="read_more"><span><?php echo __("View Details","premiumpress"); ?></span></div>
        <?php } ?>
        
        </a>
        
        <?php if( isset($GLOBALS['ajax_sponsored']) ){ ?>
        <span class="featuredribbion bg-success"><?php echo __("New commercial","premiumpress"); ?></span>
        <?php }elseif( $post->featured ){ ?>
        <span class="featuredhometag bg-primary"><?php echo __("Featured","premiumpress"); ?></span>
        <?php } ?>
        
   
        <?php  if(isset($GLOBALS['distance_value']) && _ppt(array('maps','enable'))  == "1" && in_array($thiscard, array("info","blank")) ){  ?>
        <span class="badge small badge-dark text-light position-absolute font-weight-normal" style="top:10px; left:10px;"><i class="fal fa-map-marker mr-2 hide-mobile"></i> <?php echo do_shortcode('[DISTANCE]'); ?></span>
        <?php } ?>
         
        
        <?php if(in_array(THEME_KEY, array("sp")) && in_array($thiscard, array("info","blank")) ){ ?>
        <div class="add-cart-wrap"> <?php echo do_shortcode('[ADDCART class="bg-primary text-light"]'. __("Add to Cart","premiumpress").'[/ADDCART]'); ?> </div>
        <?php } ?>
        
        <?php if(in_array(THEME_KEY, array("da"))   ){ ?>
        
        <div class="imgcount z-1 bg-dark" style="bottom:0;"><i class="fa fa-camera"></i> <?php echo $CORE->MEDIA("count_files",$post->ID); ?></div>
        
        <?php }elseif(strtotime(date("Y-m-d H:i:s", strtotime($post->post_date . " +1 day"))) > strtotime(date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) ) )) ){  ?>
        
        <span class="badge small badge-success text-light position-absolute" style="bottom:10px; left:10px;"><?php echo __("new","premiumpress"); ?></span>    
            
        <?php } ?>
        
        
        
        
     </figure> </div><?php
	$output_image = ob_get_contents();
	ob_end_clean();	
	
	$post->image_formatted = $output_image;
	
	 
	 // MAIN OUTPUT
	 
 	_ppt_template( 'framework/design/cards/'.THEME_KEY.'/'.$thiscard );
	  
  
?>