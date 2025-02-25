<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_box1',  'data') );
add_action( 'hero_box1',  			array('block_hero_box1', 'output' ) );
add_action( 'hero_box1-css',  		array('block_hero_box1', 'css' ) );
add_action( 'hero_box1-js',  		array('block_hero_box1', 'js' ) );

class block_hero_box1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_box1'] = array(
			"name" 	=> "Hero Box 1",
			"image"	=> "hero_box1.jpg",
			"cat"	=> "hero",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_box1", "hero", $settings ) );
 
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
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_image'] =  $CORE->LAYOUT("get_placeholder",array('full','dark'));	
			}else{
			$settings['hero_image'] =  $CORE->LAYOUT("get_placeholder",array('full','light'));	
			}
			
		}
		
		if($settings['btn_size'] == "btn-xl"){
		$settings['btn_size'] = "btn-md";
		}
		if($settings['btn2_size'] == "btn-xl"){
		$settings['btn2_size'] = "btn-md";
		}	
		 
 
		ob_start();
		
		
		?><section class="hero-text1 position-relative hero-default <?php echo $settings['hero_size']; ?> hero-default text-light">
   <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
   
   <div class="hero_content z-10">
      <div class="container">
         <div class="row justify-content-start">
            <div class="col-lg-7 col-xl-5 col-md-10">
            
              <div class="hero_box box1 bg-secondary p-3">
              <div class="hero_box_wrap p-5">
              
               <?php _ppt_template( 'framework/design/parts/title' ); ?>
              
              <?php _ppt_template( 'framework/design/parts/btn' ); ?>
               
              </div>
              </div>
               
            </div>
         </div>
      </div>
   </div>
   <?php _ppt_template( 'framework/design/hero/parts/js' ); ?>
</section><?php
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