<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_comments',  'data') );
add_action( 'listingpage_comments',  		array('block_listingpage_comments', 'output' ) );
add_action( 'listingpage_comments-css',  	array('block_listingpage_comments', 'css' ) );
add_action( 'listingpage_comments-js',  	array('block_listingpage_comments', 'js' ) );

class block_listingpage_comments {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_comments'] = array(
			"name" 		=> "Comments",
			"image"		=> "listingpage_comments.jpg",
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_comments", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		 
	 	
	 
	ob_start();
	
		_ppt_template( 'framework/design/single/content/single-comments' );  
	
	
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