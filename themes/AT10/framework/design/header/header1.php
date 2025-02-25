<?php 
add_filter( 'ppt_blocks_args', 	array('block_header1',  'data') );
add_action( 'header1',  		array('block_header1', 'output' ) );
add_action( 'header1-css',  	array('block_header1', 'css' ) );
add_action( 'header1-js',  	array('block_header1', 'js' ) );


class block_header1 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "header1.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 1,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header1", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }		 
		    
 
		ob_start();
		
		?>
<header class="elementor_header header1 bg-white b-bottom">
  <?php $settings['topmenu_bg'] = "bg-light text-dark";
		 _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container"> <a class="navbar-brand" href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
      <?php 
		  
		  $settings['btn-class'] = "btn-dark";
		  //$settings['btn_size'] = "btn-sm";
		  
		  _ppt_template( 'framework/design/header/parts/header-search-1' ); ?>
    </div>
  </nav>
  <?php _ppt_template( 'framework/design/header/parts/header-submenu-icon' ); ?>
</header>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
		}
	
		public static function css(){ 		
		return "";
		}
		
		public static function js(){
		return "";	 
		}	
		
}

?>
