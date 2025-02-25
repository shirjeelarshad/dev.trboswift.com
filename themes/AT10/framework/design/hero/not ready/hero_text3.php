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
			"desc" 	=> "", 
			"data" 	=> array( ),			
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
		 	
			 $settings['hero_image'] =  $CORE->LAYOUT("get_placeholder",array('full','dark'));	
			 
			
		}	
 
		ob_start();
		
		
		?><section class="hero_text3 position-relative section-100 <?php if($settings['hero_txtcolor'] == "light"){ ?>bg-primary text-light<?php }else{ ?>bg-light text-dark<?php } ?> pb-0 clearfix <?php if($settings['hero_size'] == "hero-full"){ echo $settings['hero_size']; } ?>">
   
   <div class="bg-pattern" data-bg="<?php echo get_template_directory_uri(); ?>/framework/images/pattern/2.svg"></div>

   <div class="hero_content bg-content clearfix">
   
      <div class="container">
      
         <div class="row justify-content-center">
         
         
            <div class="col-md-7 text-center">            
  
               <?php _ppt_template( 'framework/design/parts/title' ); ?> 
               
               <?php _ppt_template( 'framework/design/parts/btn' ); ?> 
                            
            </div>
            
             <div class="col-12 text-center mt-5">
               
               <img src="<?php echo $settings['hero_image']; ?>" class="img-fluid" alt="<?php echo $settings['title'];  ?>" />
             
             </div>   
            
         </div>
         
      </div>
 
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
		ob_start();
	  _ppt_template( 'framework/design/hero/parts/js' );  
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>