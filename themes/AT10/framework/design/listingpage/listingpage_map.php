<?php
 
add_filter( 'ppt_blocks_args', 		array('block_listingpage_map',  'data') );
add_action( 'listingpage_map',  	array('block_listingpage_map', 'output' ) );
add_action( 'listingpage_map-css',  array('block_listingpage_map', 'css' ) );
add_action( 'listingpage_map-js',  	array('block_listingpage_map', 'js' ) );

class block_listingpage_map {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_map'] = array(
			"name" 		=> "Map",
			"image"		=> "listingpage_map.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 4, 
			
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					 
					 
			),
			 
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_map", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
	 	
	 
	ob_start();
	
	_ppt_template( 'framework/design/single/content/single-map' );  
	
	
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