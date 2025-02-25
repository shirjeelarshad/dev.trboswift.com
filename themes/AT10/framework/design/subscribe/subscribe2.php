<?php
 
add_filter( 'ppt_blocks_args', 	array('block_subscribe2',  'data') );
add_action( 'subscribe2',  		array('block_subscribe2', 'output' ) );
add_action( 'subscribe2-css',  	array('block_subscribe2', 'css' ) );
add_action( 'subscribe2-js',  	array('block_subscribe2', 'js' ) );

class block_subscribe2 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['subscribe2'] = array(
			"name" 	=> "subscribe 2",
			"image"	=> "subscribe2.jpg",
			"cat"	=> "subscribe",
			"order" => 2,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "subscribe") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "subscribe") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "no",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> "",
					"btn_link" 			=> "",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> "",
					"btn2_link" 		=> "",
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("subscribe2", "subscribe", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	 
	ob_start();
	?> <section id="subscribe2" class="position-relative bg-dark <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
    
    
   <div class="bg-image" data-bg="<?php echo $settings['image_subscribe']; ?>"></div>
   <div class="overlay-innerxx"></div>   
   <div class="bg-gradient-none">     
   <div class="container bg-content">
     
           
                <div class="row align-items-center wrapper "> 
                    <div class="col-md-6">
                        <div class="subscribe-form-wrapper text-light">
                            
                            <?php _ppt_template( 'framework/design/parts/title' ); ?>
                            
                             
                              <?php _ppt_template( 'framework/design/widgets/widget-newsletter' ); ?> 
                            
                        </div>
                    </div>
                    
                    
                </div>
            </div> 


     </div>  
    
   
</section>
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		
			
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