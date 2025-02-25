<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header15',  'data') );
add_action( 'header15',  		array('block_header15', 'output' ) );
add_action( 'header15-css',  	array('block_header15', 'css' ) );

class block_header15 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header15'] = array(
			"name" 	=> "Style 15 - logo only",
			"image"	=> "header15.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 15,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header15", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header15 border-bottom py-0">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <div class="text-center"> <a href="<?php echo home_url(); ?><?php if(defined('WLT_DEMOMODE')){ ?>/?reset=1<?php } ?>"> <?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
    <button class="navbar-toggler menu-toggle tm border-0 text-light show-mobile"><span class="fal fa-bars"></span></button>
  </div>
</header>
<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		 
		 return "";
		ob_start(); ?>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>
