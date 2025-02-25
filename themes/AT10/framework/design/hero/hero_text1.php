<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_text1',  'data') );
add_action( 'hero_text1',  			array('block_hero_text1', 'output' ) );
add_action( 'hero_text1-css',  		array('block_hero_text1', 'css' ) );
add_action( 'hero_text1-js',  		array('block_hero_text1', 'js' ) );

class block_hero_text1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_text1'] = array(
			"name" 	=> "Hero Text 1",
			"image"	=> "hero_text1.jpg",
			"cat"	=> "hero",
			"order" => 7,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					"hero_size" 		=> "hero-medium",
					
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					"title" 			=> "Building Amazing Websites Today",
					"subtitle"			=> "Save time & money - get started now!",	
					"title_txtcolor" 	=> "white",				
					
 
					"hero_size" 		=> "hero-medium",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero6_bg.jpg",
					"hero_overlay" 		=> "grey", 
					
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_text1", "hero", $settings ) );
		
		//print_r($settings);
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }// DEFAULTS		 
	 
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
		
		  
		ob_start();
		 
		?><section class="hero-text1 position-relative hero-default <?php echo $settings['hero_size']; ?> text-<?php echo $settings['hero_txtcolor']; ?>">
  <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
  <?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>
  <div class="hero_content z-10">
    <div class="container">
      <div class="row justify-content-start">
        <div class="col-lg-6 col-md-10 text-center text-md-left">
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
          <?php _ppt_template( 'framework/design/parts/btn' ); ?>
        </div>
      </div>
    </div>
  </div>
  <?php _ppt_template( 'framework/design/hero/parts/js' ); ?>
</section>

<?php
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
	return "";
		ob_start();
	 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>
