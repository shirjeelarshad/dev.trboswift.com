<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header13',  'data') );
add_action( 'header13',  		array('block_header13', 'output' ) );
add_action( 'header13-css',  	array('block_header13', 'css' ) );

class block_header13 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header13'] = array(
			"name" 	=> "Style 13",
			"image"	=> "header13.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 12,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header13", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header4 bg-primary b-bottom">
        
         <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
   <nav class="elementor_mainmenu navbar navbar-dark navbar-expand-lg">
   
      <div class="container">
      
         <a class="navbar-brand" href="<?php echo home_url(); ?>"> 
         <?php echo $CORE->LAYOUT("get_logo","light");  ?>
         <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
         </a>
         
         
          <?php 
		  
		  $settings['btn-class'] = "btn-dark";
		  _ppt_template( 'framework/design/header/parts/header-search-1' ); ?> 
         
         
      </div>
   </nav> 
 
 
 
    
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>
        <style>
		.header13 .sellspace-live { width:468px; }
		</style>

        <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>