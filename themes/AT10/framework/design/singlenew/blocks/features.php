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
	$title = __("Services","premiumpress");
	} break;

	case "da": {
	$title = __("My Interests","premiumpress");
	} break;

	case "mj": {
	$title = __("Why Choose Me","premiumpress");
	} break;	
	
	case "ll": {
	$title = __("Skills you will gain","premiumpress");
	} break;	
		
	case "jb": {
	$title = "";
	} break; 
	
	default: {	
	$title = __("Features","premiumpress");
	} break;
} 

?>

<div class="card  position-relative <?php if(isset($GLOBALS['global_design3'])){ echo "border-0"; } ?>" style="overflow:hidden">
  <div class="card-body pl-0">
    <div class="<?php if(!isset($GLOBALS['global_design3'])){ echo 'p-lg-4'; } ?>">
    
    
    
    
     
      
      <?php if(in_array(_ppt(array('design', 'display_features')), array("","1"))){  ?>
      
    <div id="single-display-features">
      <?php if($title != ""){ ?>
      <h5 class="text-center mb-4"><?php echo $title; ?></h5>
      <?php } ?>
      
      <?php if(!in_array(THEME_KEY, array("jb")) ){ ?>
       <div class="addeditmenu" data-key="features"></div>
      <?php _ppt_template( 'framework/design/singlenew/blocks/features-code' );  ?>
    <?php } ?>
    
    </div>
    
    <?php } ?>
    
    
    
    
    
    

    
    

    
      <?php if(in_array(THEME_KEY, array("at")) && _ppt(array('design','display_delivery')) != "0" ){ ?>
      <hr class="my-4" />
       <?php _ppt_template( 'framework/design/singlenew/blocks/features-delivery' );  ?>
      <?php  } ?>
    
    </div>
  </div>
 
  
</div>