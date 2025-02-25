<?php
 
add_filter( 'ppt_blocks_args', 	array('block_footer4',  'data') );
add_action( 'footer4',  		array('block_footer4', 'output' ) );
add_action( 'footer4-css',  	array('block_footer4', 'css' ) );
add_action( 'footer4-js',  	array('block_footer4', 'js' ) );

class block_footer4 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['footer4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "footer4.jpg",
			"cat"	=> "footer",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	  
		$settings = array( );
	
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("footer4", "footer", $settings ) );
			  
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
    
    
      <div class="col-lg-4 col-md-6 text-center text-md-left">
        <?php		 
// SET DEFAULTS
ob_start();
dynamic_sidebar('footer4'); 
$footer4 = ob_get_clean();
if(strlen($footer4) > 10){ echo $footer4; }else{	 
?>
        <a href="<?php echo home_url(); ?>">
        <?php  if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){
								 
								 echo str_replace("text-primary","",str_replace("text-secondary","",str_replace("text-muted","", $CORE->LAYOUT("get_logo","dark") ))); 
								 
								 }else{
								 
								 echo str_replace("text-primary","",str_replace("text-secondary","",str_replace("text-muted","", $CORE->LAYOUT("get_logo","light") )));
								  
								 }  ?></a>
                                 
                                 
        <p class="mt-4 opacity-8 small line-height-30">
          <?php if(isset($settings['footer_description']) && strlen($settings['footer_description']) > 2){ ?>
          <?php echo $settings['footer_description']; ?>
          <?php }elseif(strlen(_ppt(array('company','mission'))) > 2){ echo _ppt(array('company','mission')); }else{ ?>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.
          <?php } ?>
        </p>
        
        
        <div class="socials mt-4 <?php if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){ ?>dark<?php } ?>">
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
        <?php } ?>
      </div>
      
      <div class="col-lg-4">&nbsp;</div>
      
      
      <div class="col-lg-2 col-md-3 d-none d-md-block">
        <?php		 
// SET DEFAULTS
ob_start();
dynamic_sidebar('footer2'); 
$footer4 = ob_get_clean();
if(strlen($footer4) > 10){ echo $footer4; }else{	 
?>
        <?php if(isset($settings['footer_menu1']) && $settings['footer_menu1'] == "none"){ ?>
        <?php }else{ ?>
        <?php if(isset($settings['footer_menu1_title']) && strlen($settings['footer_menu1_title']) > 2){ ?>
        <div class="h5"><?php echo $settings['footer_menu1_title']; ?></div>
        <?php }else{ ?>
        <div class="h5"><?php echo __("Useful Links","premiumpress"); ?></div>
        <?php } ?>
        <div style="line-height:35px;">
          <?php if(isset($settings['footer_menu1']) && strlen($settings['footer_menu1']) > 2){ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu1'].'" class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php }else{ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU footer=1 class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      
      
      
      <div class="col-lg-2 col-md-3  d-none d-md-block">
        <?php if(isset($settings['footer_menu2']) && $settings['footer_menu2'] == "none"){ ?>
        <?php }else{ ?>
        <?php if(isset($settings['footer_menu2_title']) && strlen($settings['footer_menu2_title']) > 2){ ?>
        <div class="h5"><?php echo $settings['footer_menu2_title']; ?></div>
        <?php }else{ ?>
        <div class="h5"><?php echo __("Members","premiumpress"); ?></div>
        <?php } ?>
        <div style="line-height:35px;">
          <?php if(isset($settings['footer_menu2']) && strlen($settings['footer_menu2']) > 2){ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu2'].'" class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php }else{ ?>
          <ul class="links-vertical list-unstyled" style="line-height:35px;">
            <li><a class="opacity-8" href="<?php echo _ppt(array('links','myaccount')); ?>"><?php echo __("Members Area","premiumpress"); ?></a></li>
            <li><a class="opacity-8" href="<?php echo _ppt(array('links','contact')); ?>"><?php echo __("Contact Us","premiumpress"); ?></a></li>
            <li><a class="opacity-8" href="<?php echo _ppt(array('links','privacy')); ?>"><?php echo __("Privacy Policy","premiumpress"); ?></a></li>
            <li> <a class="opacity-8" href="<?php echo _ppt(array('links','terms')); ?>"><?php echo __("Terms","premiumpress"); ?></a></li>
          </ul>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      
       
      
      
      
      
      <div class="col-md-12 small text-center text-md-left">
        <hr class="bg-white my-4" style="opacity:0.2" />
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
		_ppt_template( 'framework/design/footer/parts/bottom-cards' ); 	
	}
}
?>
      </div>
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
