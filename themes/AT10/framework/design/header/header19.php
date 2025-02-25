<?php
 
 
add_filter( 'ppt_blocks_args', 	array('block_header19',  'data') );
add_action( 'header19',  		array('block_header19', 'output' ) );
add_action( 'header19-css',  	array('block_header19', 'css' ) );
add_action( 'header19-js',  	array('block_header19', 'js' ) );

class block_header19 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header19'] = array(
			"name" 	=> "Style 19",
			"image"	=> "header19.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 17,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header19", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		 $settings['topmenu_bg'] = "bg-white text-dark border-bottom";
		    
 
		ob_start();
		
		?><header class="elementor_header header19 logo-lg bg-white border-bottom">
   
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container px-0">
    
    <a class="navbar-brand" href="<?php echo home_url(); ?>">
	 <?php echo $CORE->LAYOUT("get_logo","light");  ?>
	 <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
     </a>
     
         <?php 
		 
		 $settings['btn'] = "yes";
		 $settings['btn_show'] = "yes";
		  $settings["btn_bg"] = "primary";  
		  
		  _ppt_template( 'framework/design/header/parts/header-login' ); ?> 
      
    </div>
  </nav>
  
   <?php 
   $settings['btn'] = "no";
   $settings['btn_show'] = "no";
   
   
   $settings['submenu_bg'] = "bg-white border-top ";
   $settings['seperator'] = 1;
   $settings['submenu_menu_class'] = "mx-auto";
   $settings['submenu_shadow'] = "py-2";
   
   
   
   _ppt_template( 'framework/design/header/parts/header-submenu' ); ?> 
  
  
</header>
 
<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
		
		public static function js(){ 
		return "";
		}
		
		public static function css(){ 
		 
		ob_start(); ?>
 
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		
}

?>
