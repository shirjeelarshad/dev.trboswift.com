<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_text3',  'data') );
add_action( 'hero_text3',  			array('block_hero_text3', 'output' ) );
add_action( 'hero_text3-css',  		array('block_hero_text3', 'css' ) );
add_action( 'hero_text3-js',  		array('block_hero_text3', 'js' ) );

class block_hero_text3 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_text3'] = array(
			"name" 	=> "Hero Text 3",
			"image"	=> "hero_text3.jpg",
			"cat"	=> "hero",
			"order" => 9,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=> "Build Amazing Websites Today!",					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "hero") ),					
					"desc" 				=>  $CORE->LAYOUT("get_placeholder_text", array('desc_small', "text") ),	
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "dark",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					
					"hero_size" 		=> "hero-medium",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero5_bg.jpg",
					"hero_overlay" 		=> "primary", 	
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "yes",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "btn-xl",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",				
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_text3", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_text3");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}		
		 
 
		ob_start();
		
		
		?>
<section class="hero-text1 position-relative hero-default <?php echo $settings['hero_size']; ?>">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-6 <?php echo $settings['hero_size']; ?> y-middle text-center text-lg-left pl-lg-5">
        <div class="col-lg-10 mx-auto">
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
          <?php _ppt_template( 'framework/design/parts/btn' ); ?>
        </div>
      </div>
      <div class="col-12 col-md-6 p-0">
        <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
      </div>
    </div>
  </div>
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
		ob_start();
  _ppt_template( 'framework/design/hero/parts/js' ); 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>