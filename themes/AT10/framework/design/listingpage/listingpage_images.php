<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_images',  'data') );
add_action( 'listingpage_images',  		array('block_listingpage_images', 'output' ) );
add_action( 'listingpage_images-css',  	array('block_listingpage_images', 'css' ) );
add_action( 'listingpage_images-js',  	array('block_listingpage_images', 'js' ) );

class block_listingpage_images {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_images'] = array(
			"name" 		=> "Image Gallery",
			"image"		=> "listingpage_images.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 2, 
			
			"data" 	=> array( ),	
			
			"defaults" => array( ), 
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_images", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	 
	ob_start();
	
	
	if(THEME_KEY == "vt"){ 
	
	_ppt_template( 'framework/design/single/content/single-video-vt' ); 
	
	
	}else{
	
	switch($settings['listingpage_images_style']){	
		
		case "2": {
		
			_ppt_template( 'framework/design/single/content/single-images' ); 
		
		} break;
		
		case "3": {
		
			_ppt_template( 'framework/design/single/content/single-images-slider' ); 
		
		} break;
		
		default: {
		
			_ppt_template( 'framework/design/single/content/single-images-slider2' ); 
		
		} break;		
	
	} 
	
	}
	
		 
		
		
		
	
	
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