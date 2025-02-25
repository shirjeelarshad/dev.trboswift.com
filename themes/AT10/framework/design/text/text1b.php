<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text1b',  'data') );
add_action( 'text1b',  		array('block_text1b', 'output' ) );
add_action( 'text1b-css',  	array('block_text1b', 'css' ) );
add_action( 'text1b-js',  	array('block_text1b', 'js' ) );

class block_text1b {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text1b'] = array(
			"name" 	=> "Style 1b",
			"image"	=> "text1b.jpg",
			"order" => 2,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),
			
					"defaults" => array(
					
					"section_padding" => "section-60",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "PremiumPress Themes",					 
					"subtitle"			=>  "",					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "text1") ),
					 	
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
					"btn_style" 		=> "2",				
					"btn_size" 			=> "btn-md",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "dark",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-2",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "1",				
					"btn2_size" 		=> "btn-lg",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "dark",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4",
					
					
					"text_image1" => DEMO_IMG_PATH."/blocks/text/icons/image-1.png"
					 
			), 
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
	 	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text1b", "text", $settings ) );
		 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
if($settings['text_image1'] == ""){
	 
			$default_data = $CORE->LAYOUT("get_block_defaults", "text1");		 	 
			$settings['text_image1'] = $default_data['text_image1'];		 	
				
		}
		  
		 
		 
		
	 
	ob_start();
	
	?><section class="hero-default hero-small <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
    
      <div class="bg-image" data-bg="<?php echo $settings['text_image1']; ?>"></div>
 
  <div class="hero_content z-10">
    
   <div class="container">
      <div class="row y-middle">        
         <div class="col-md-6 pr-lg-5 text-center text-lg-left">
            
            <?php _ppt_template( 'framework/design/parts/title' ); ?>
            
            <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
         </div>
         
          <div class="col-md-6">
       
         </div>
         
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