<?php
 
 
add_filter( 'ppt_blocks_args', 	array('block_header17',  'data') );
add_action( 'header17',  		array('block_header17', 'output' ) );
add_action( 'header17-css',  	array('block_header17', 'css' ) );
add_action( 'header17-js',  	array('block_header17', 'js' ) );

class block_header17 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header17'] = array(
			"name" 	=> "Style 17 - Basic",
			"image"	=> "header17.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 17,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header17", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 //$settings['btn'] = "yes";
		 //$settings['btn_show'] = "no";
		 $settings['topmenu_bg'] = "bg-white text-dark border-bottom";
		    
 
		ob_start();
		
		?><header class="elementor_header header17 logo-lg bg-white border-top border-bottom">
   
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container px-0">
    
    <a class="navbar-brand" href="<?php echo home_url(); ?>">
	 <?php echo $CORE->LAYOUT("get_logo","light");  ?>
	 <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
     </a>
     
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar">
	  <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?>
      </div>
      
	  <?php if($settings['btn_show'] == "yes"){ ?>
      <div class="align-items-center">
        <?php _ppt_template( 'framework/design/header/parts/header-button' ); ?>
      </div>
      <?php }else{ ?>
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
      <?php } ?>
      
    </div>
  </nav>
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
		
		public static function js(){ 
		return "";
		}
		
		public static function css(){ 
		 
		ob_start(); ?>
<style>
.elementor_mainmenu .nav-item a {
    text-transform: unset !important;
    text-decoration: unset !important;
    font-size: unset !important;
}
</style>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		
}

?>
