<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_sidebar',  'data') );
add_action( 'listingpage_sidebar',  		array('block_listingpage_sidebar', 'output' ) );
add_action( 'listingpage_sidebar-css',  	array('block_listingpage_sidebar', 'css' ) );
add_action( 'listingpage_sidebar-js',  	array('block_listingpage_sidebar', 'js' ) );

class block_listingpage_sidebar {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_sidebar'] = array(
			"name" 		=> "Sidebar",
			"image"		=> "listingpage_sidebar.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 10, 
			
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					 
					 
			),
			 
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_sidebar", "text", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array(800,600));		
		}
	 	
	 
	ob_start();
	
	_ppt_template( 'framework/design/single/sidebar/sidebar-'.THEME_KEY );  
	
	
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