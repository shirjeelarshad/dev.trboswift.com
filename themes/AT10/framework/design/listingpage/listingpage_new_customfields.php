<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_new_customfields',  'data') );
add_action( 'listingpage_new_customfields',  		array('block_listingpage_new_customfields', 'output' ) );
add_action( 'listingpage_new_customfields-css',  	array('block_listingpage_new_customfields', 'css' ) );
add_action( 'listingpage_new_customfields-js',  	array('block_listingpage_new_customfields', 'js' ) );

class block_listingpage_new_customfields {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_new_customfields'] = array(
			"name" 		=> "Custom Fields Box",
			"image"		=> "listingpage_new_customfields.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 5, 
			
			"data" 	=> array( ),	
			
			"defaults" => array( ), 
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_new_customfields", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		  
	ob_start();
	
		_ppt_template( 'framework/design/singlenew/blocks/customfields' ); 
	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
<?php	
		$output = ob_get_authors();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
<?php	
		$output = ob_get_authors();
		ob_end_clean();
		echo $output;
		}	
}

?>