<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_related',  'data') );
add_action( 'listingpage_related',  		array('block_listingpage_related', 'output' ) );
add_action( 'listingpage_related-css',  	array('block_listingpage_related', 'css' ) );
add_action( 'listingpage_related-js',  	array('block_listingpage_related', 'js' ) );

class block_listingpage_related {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_related'] = array(
			"name" 		=> "Related Items",
			"image"		=> "listingpage_related.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 8, 
			
			"data" 	=> array( ),	
			
			"defaults" => array( ),
			 
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_related", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
	 
	ob_start();
	
	_ppt_template( 'framework/design/single/content/single-related' ); 
	
	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
<?php	
		$output = ob_get_relateds();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
<?php	
		$output = ob_get_relateds();
		ob_end_clean();
		echo $output;
		}	
}

?>