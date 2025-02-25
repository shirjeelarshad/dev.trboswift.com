<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_video1',  'data') );
add_action( 'hero_video1',  			array('block_hero_video1', 'output' ) );
add_action( 'hero_video1-css',  		array('block_hero_video1', 'css' ) );
add_action( 'hero_video1-js',  		array('block_hero_video1', 'js' ) );

class block_hero_video1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_video1'] = array(
			"name" 	=> "Hero Video 1",
			"image"	=> "hero_video1.jpg",
			"cat"	=> "hero",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_video1", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		 
		 $settings['btn_video'] = 1;
		 
 
		ob_start();
		
		
		?><section class="hero-video1 position-relative hero-default <?php echo $settings['hero_size']; ?> text-light">
   <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
   <div class="overlay-inner"></div>
   <div class="hero_content z-10">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
            
               <h1><?php echo $settings['title']; ?></h1>
               
               <p class="lead mb-4"><?php echo $settings['desc']; ?></p>
               
               
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