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


 	if(_ppt(array("maps","provider")) != "basic"){
	
		$long 		= get_post_meta($post->ID,'map-log',true); 
		$lat 		= get_post_meta($post->ID,'map-lat',true);	
		$address	= get_post_meta($post->ID,'map-location',true);			
				
		$post->carddata = 'data-pid="'.$post->ID.'" data-lat="'. $lat.'" data-long="'.$long.'" data-address="'.$address .'" ';
		$post->maplat = $lat;
		$post->maplong = $long;
	}
	$address 	= get_post_meta($post->ID,'map-location',true);
	$post->maplocation = do_shortcode('[LOCATION]');
	$post->city = do_shortcode('[CITY]');
	 

?>

<div class="card  p-lg-4 position-relative overflow-hidden" >
  <div class="bg-image  bg-light" data-bg="<?php echo FRAMREWORK_URI; ?>/images/mapbg.jpg"></div>
  <div class="overlay-inner opacity-5"></div>
  <div class="bg-content text-white p-4">
  
     <div class="addeditmenu" data-key="map"></div>
    
    <h5 class="card-title"><?php echo __("Location","premiumpress"); ?></h5>
    <div class="small mb-3"> <?php if($address == ""){ echo __("No location set.","premiumpress"); }else{ echo $address; } ?></div>
   
   <?php if(_ppt(array("maps","provider")) != "basic"){ ?>
    <a href="javascript:void(0);" class="btn btn-system <?php if($address == ""){ echo "opacity-8"; }else{ echo "single-map-item"; } ?>"
    
    data-title="<?php echo strip_tags($post->title); ?>" 
    data-url="<?php echo $post->link; ?>" 
    data-newlatitude="<?php echo $post->maplat; ?>" 
    data-address="<?php echo $post->maplocation; ?>" 
    data-newlongitude="<?php echo $post->maplong; ?>"><i class="fal fa-map-marker mr-2 text-primary shadow-sm"></i> <?php echo __("View Map","premiumpress"); ?></a>
   <?php }else{ ?>
   <div class="my-5"></div>
   <?php } ?>
  </div>
</div>
<script>

  
 
 jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
               jQuery(this).ekkoLightbox();
            });

</script>
