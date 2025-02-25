<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text1c',  'data') );
add_action( 'text1c',  		array('block_text1c', 'output' ) );
add_action( 'text1c-css',  	array('block_text1c', 'css' ) );
add_action( 'text1c-js',  	array('block_text1c', 'js' ) );

class block_text1c {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text1c'] = array(
			"name" 	=> "Style 1c",
			"image"	=> "text1c.jpg",
			"order" => 1.5,
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
					
					
					"title" 			=> "Premium WordPress Themes",					 
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
					"btn_style" 		=> "5",				
					"btn_size" 			=> "btn-lg",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "dark",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
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
					
					
					"text_image1" => DEMO_IMG_PATH."/blocks/text/icons/image-2.png"
					 
			), 
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
	 	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text1c", "text", $settings ) );
		 
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
      <div class="row y-middle d-flex flex-lg-row-reverse">        
         <div class="col-lg-6 pr-lg-5 text-center text-lg-left">
            
            <?php _ppt_template( 'framework/design/parts/title' ); ?>
            
            <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
         </div>
         
          <div class="col-lg-4 pl-lg-5">
       
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