<?php
 
add_filter( 'ppt_blocks_args', 	array('block_subscribe1',  'data') );
add_action( 'subscribe1',  		array('block_subscribe1', 'output' ) );
add_action( 'subscribe1-css',  	array('block_subscribe1', 'css' ) );
add_action( 'subscribe1-js',  	array('block_subscribe1', 'js' ) );

class block_subscribe1 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['subscribe1'] = array(
			"name" 	=> "subscribe 1",
			"image"	=> "subscribe1.jpg",
			"cat"	=> "subscribe",
			"order" 	=> "1", 
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "subscribe") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "subscribe") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("subscribe1", "subscribe", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		$settings['title_pos'] = "center";
		
	 
	 
	ob_start();
	?>
    <section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
            <div class="container"> 
                <div class="row "> 
                <div class="col-md-6 mx-auto text-center">
                   
                   
                     <?php _ppt_template( 'framework/design/parts/title' ); ?>
                          
                            <div class="subscribe-form">
                              <?php _ppt_template( 'framework/design/widgets/widget-newsletter' ); ?> 
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