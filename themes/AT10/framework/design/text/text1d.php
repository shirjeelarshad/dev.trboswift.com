<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text1d',  'data') );
add_action( 'text1d',  		array('block_text1d', 'output' ) );
add_action( 'text1d-css',  	array('block_text1d', 'css' ) );
add_action( 'text1d-js',  	array('block_text1d', 'js' ) );

class block_text1d {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text1d'] = array(
			"name" 		=> "Style 1d",
			"image"		=> "text1d.jpg",
			"cat"		=> "text",
			"desc" 		=> "", 
			"order" 	=> 1.3, 
			
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					"section_padding" => "section-80",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "text1") ),						 
					"subtitle"			=>  $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text1") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "5",				
					"btn_size" 			=> "btn-lg",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Get Started","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "orange",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-2",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "1",				
					"btn2_size" 		=> "btn-xl",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "dark",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4",
					
					
					"text_image1" => DEMO_IMG_PATH."/blocks/text/icons/user-1.png"
					 
			), 
			
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text1d", "text", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
		if($settings['text_image1'] == ""){
	 
			$default_data = $CORE->LAYOUT("get_block_defaults", "text1d");		 	 
			$settings['text_image1'] = $default_data['text_image1'];		 	
				
		}
		  
	 	
	 
	ob_start();
	
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?> pb-0 mb-0">
  <div class="container">
    <div class="row d-flex flex-lg-row-reverse y-middle">
      <div class="col-md-5 pl-xl-5 text-center text-lg-left">
        <?php  _ppt_template( 'framework/design/parts/title' ); ?>
        <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
      </div>
      <div class="col-md-7 pr-lg-5 text-center">
      <?php if(isset($settings['text_image1_link']) && strlen($settings['text_image1_link']) > 1){ ?>
    <a href="<?php echo $settings['text_image1_link']; ?>">
    <?php } ?>
      <img data-src="<?php echo $settings['text_image1']; ?>" class="img-fluid mt-3 pt-3 pt-md-0 mt-lg-0 lazy" alt="<?php echo strip_tags($settings['title']); ?>" />
      
      <?php if(isset($settings['text_image1_link']) && strlen($settings['text_image1_link']) > 1){ ?>  </a>  <?php } ?>
      
      </div>
    </div>
  </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
<?php	
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