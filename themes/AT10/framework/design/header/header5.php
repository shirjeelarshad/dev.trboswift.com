<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header5',  'data') );
add_action( 'header5',  		array('block_header5', 'output' ) );
add_action( 'header5-css',  	array('block_header5', 'css' ) );

class block_header5 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "header5.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 5,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header5", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 $settings['btn'] = "yes";
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header5 bg-primary">
        
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
 
   <?php 
   
   $settings['submenu_bg'] = "bg-white border-bottom ";
   
   _ppt_template( 'framework/design/header/parts/header-submenu' ); ?> 
 
    
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>

        <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>