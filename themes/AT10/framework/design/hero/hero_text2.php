<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_text2',  'data') );
add_action( 'hero_text2',  			array('block_hero_text2', 'output' ) );
add_action( 'hero_text2-css',  		array('block_hero_text2', 'css' ) );
add_action( 'hero_text2-js',  		array('block_hero_text2', 'js' ) );

class block_hero_text2 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_text2'] = array(
			"name" 	=> "Hero Text 2 - Centered",
			"image"	=> "hero_text2.jpg",
			"cat"	=> "hero",
			"order" => 8,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					"hero_size" 	=> "hero-large",
					
					"title_show" 	=> "yes",
					"title_style" 	=> "1",
					"title_heading" => "h1",
					"title" 		=> "Building Amazing <br> Websites Today",
					"subtitle"		=> "Save time &amp; money - get started now!",	
					
					
					"hero_size" 		=> "hero-medium",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero5_bg.jpg",
					"hero_overlay" 		=> "primary", 				
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "3",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "after",
					"btn_font" 			=> "",
					"btn_txt" 			=> "Explore Website",
					"btn_link" 			=> "[link-search]",
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-dark",					
					"btn_margin" 		=> "mt-4", 

					// BUTTON					
					"btn2_show" 			=> "no",						
					"btn2_style" 		=> "4",				
					"btn2_size" 			=> "btn-lg",
					"btn2_icon" 			=> "",				
					"btn2_icon_pos" 		=> "before",
					"btn2_font" 			=> "",
					"btn2_txt" 			=> "Join Now",
					"btn2_link" 			=> "[link-add]",
					"btn2_bg" 			=> "light",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4", 
					
					
					 
			),
		);	
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_text2", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		 
		 
		/* DEFAULTS */
		if($settings['hero_image'] == ""){
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_text1");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
		
		
		 $settings["title_pos"] = "center";	
 
		ob_start();
		
		
		?><section class="hero-demo hero-text2 position-relative hero-default <?php echo $settings['hero_size']; ?> text-light">
   <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
   <?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>
  
   <div class="hero_content z-10">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
            
              <?php _ppt_template( 'framework/design/parts/title' ); ?>
              
              <?php _ppt_template( 'framework/design/parts/btn' ); ?>
  
               
               
            </div>
         </div>
      </div>
   </div></section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function css(){ global $CORE;
	return "";
		ob_start();
	 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function js(){ global $CORE;
		ob_start();
  _ppt_template( 'framework/design/hero/parts/js' ); 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>