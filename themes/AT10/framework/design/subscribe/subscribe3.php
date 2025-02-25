<?php
 
add_filter( 'ppt_blocks_args', 	array('block_subscribe3',  'data') );
add_action( 'subscribe3',  		array('block_subscribe3', 'output' ) );
add_action( 'subscribe3-css',  	array('block_subscribe3', 'css' ) );
add_action( 'subscribe3-js',  	array('block_subscribe3', 'js' ) );

class block_subscribe3 {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['subscribe3'] = array(
			"name" 	=> "subscribe 3 - form only",
			"image"	=> "subscribe3.jpg",
			"cat"	=> "subscribe",
			"order" 	=> 3, 
			"desc" 	=> "", 
			"data" 	=> array( ),	
			  
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("subscribe3", "subscribe", $settings ) ); 
	 
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
    <div class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
     <div class="subscribe-form"><?php _ppt_template( 'framework/design/widgets/widget-newsletter' ); ?></div></div><?php
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