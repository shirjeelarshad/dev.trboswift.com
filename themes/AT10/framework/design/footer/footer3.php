<?php
 
add_filter( 'ppt_blocks_args', 	array('block_footer3',  'data') );
add_action( 'footer3',  		array('block_footer3', 'output' ) );
add_action( 'footer3-css',  	array('block_footer3', 'css' ) );
add_action( 'footer3-js',  	array('block_footer3', 'js' ) );

class block_footer3 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['footer3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "footer3.jpg",
			"cat"	=> "footer",
			"order" => 3,
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
	$settings = array( );  
	  
	 // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("footer3", "footer", $settings ) );
		
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	ob_start();
	?>

<footer class="footer <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 m-b-30">
        <h5 class="m-b-20"><?php echo __("Address","premiumpress"); ?></h5>
        <p><?php echo _ppt(array('company','address')); ?></p>
      </div>
      <div class="col-lg-3 col-md-6 m-b-30">
        <h5 class="m-b-20"><?php echo __("Phone","premiumpress"); ?></h5>
        <p><?php echo _ppt(array('company','phone')); ?></p>
      </div>
      <div class="col-lg-3 col-md-6 m-b-30">
        <h5 class="m-b-20"><?php echo __("Email","premiumpress"); ?></h5>
        <p><?php echo _ppt(array('company','email')); ?></p>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 class="m-b-20"><?php echo __("Social","premiumpress"); ?></h5>
        <div class="socials <?php if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){ ?>dark<?php } ?>">
 <?php if(_ppt(array('company','twitter')) != ""){ 
		  
		  $tw_link = _ppt(array('company','twitter'));
		  if(strpos($tw_link ,"twitter.com") === false){		  
		  	$tw_link  = "https://www.twitter.com/"._ppt(array('company','twitter'));		  
		  }	
		  
		  ?>
          <a class="social" target="_blank" href="<?php echo $tw_link; ?>" title="Twitter"><i class="fab fa-twitter"></i></a>
          <?php } ?>
          <?php if(_ppt(array('company','facebook')) != ""){ 
		  
		  $fb_link = _ppt(array('company','facebook'));
		  if(strpos($fb_link,"facebook.com") === false){		  
		  	$fb_link = "https://www.facebook.com/"._ppt(array('company','facebook'));		  
		  }		  
		  
		  ?>
          <a class="social" target="_blank" href="<?php echo $fb_link; ?>" title="Facebook"><i class="fab fa-facebook"></i></a>
          <?php } ?>
          <?php if(_ppt(array('company','youtube')) != ""){ 
		  
		  $yt_link = _ppt(array('company','youtube'));
		  if(strpos($yt_link ,"youtube.com") === false){		  
		  	$yt_link  = "https://www.youtube.com/"._ppt(array('company','youtube'));		  
		  }	
		  
		  ?>
          <a class="social" target="_blank" href="<?php echo $yt_link; ?>" title="YouTube"><i class="fab fa-youtube"></i></a>
          <?php } ?>
          
          <?php if(_ppt(array('company','instagram')) != ""){ 
		  
		   $in_link = _ppt(array('company','instagram'));
		  if(strpos($yt_link ,"instagram.com") === false){		  
		  	$in_link  = "https://www.instagram.com/"._ppt(array('company','instagram'));		  
		  }	
		  
		  ?>
          <a class="social" target="_blank" href="<?php echo $in_link; ?>" title="Instagram"><i class="fab fa-instagram"></i></a>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class=" mt-5 pt-4" style="border-top:1px solid #313131">
      <?php

// FOOTE BOTTOM
if(!isset($settings["footer_copyright_style"])){  $settings["footer_copyright_style"] = "";}
switch($settings["footer_copyright_style"]){

	case "1": {
		_ppt_template( 'framework/design/footer/parts/bottom-left' ); 
	} break;
	case "2": {
		_ppt_template( 'framework/design/footer/parts/bottom-center' ); 
	} break;
	case "3": {
		_ppt_template( 'framework/design/footer/parts/bottom-right' ); 
	} break;
 	case "4": {
		_ppt_template( 'framework/design/footer/parts/bottom-cards' ); 
	} break;
 	case "5": {
		_ppt_template( 'framework/design/footer/parts/bottom-social' ); 
	} break;	
 	case "6": {
		_ppt_template( 'framework/design/footer/parts/bottom-links' ); 
	} break;		
	default: {
		_ppt_template( 'framework/design/footer/parts/bottom-links' ); 
	}
}
?>
    </div>
  </div>
</footer>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static  function css(){
	 	return "";
		ob_start();		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
<?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>
