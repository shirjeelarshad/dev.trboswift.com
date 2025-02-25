<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listingpage_title',  'data') );
add_action( 'listingpage_title',  		array('block_listingpage_title', 'output' ) );
add_action( 'listingpage_title-css',  	array('block_listingpage_title', 'css' ) );
add_action( 'listingpage_title-js',  	array('block_listingpage_title', 'js' ) );

class block_listingpage_title {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['listingpage_title'] = array(
			"name" 		=> "Title Bar",
			"image"		=> "listingpage_title.jpg",
			"cat"		=> "listingpage",
			"desc" 		=> "", 
			"order" 	=> 1, 			
			"data" 	=> array( ),			
			"defaults" => array( ),
			 					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	 	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listingpage_title", "listingpage", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
	 
	ob_start();
	
	if(THEME_KEY == "cp"){ 
	
	_ppt_template( 'framework/design/single/top/top-coupon' ); 
	
	
	}else{
	
		switch($settings['listingpage_title_style']){	
			
			case "2": {
			
				_ppt_template( 'framework/design/single/top/top1' ); 
			
			} break;
			
			case "3": {
			
				_ppt_template( 'framework/design/single/top/top3' ); 
			
			} break;
			
			default: {
			
				_ppt_template( 'framework/design/single/top/top2' ); 
			
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