<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header9',  'data') );
add_action( 'header9',  		array('block_header9', 'output' ) );
add_action( 'header9-css',  	array('block_header9', 'css' ) );

class block_header9 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header9'] = array(
			"name" 	=> "Style 9",
			"image"	=> "header9.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 			
			"data" 	=> array( ),
			"order" 	=> 9,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header9", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header9 tmb text-md logo-lg">
        
<?php 

$settings['topmenu_bg'] = "bg-white text-dark border-bottom";

_ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
        
   <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
      <div class="container"> 
      
       <div class="navbar-collapse collapse w-100"><?php  _ppt_template( 'framework/design/header/parts/header-search-3' ); ?></div>      
      
       <div class="mx-auto text-center">
            <a class="navbar-brand" href="<?php echo home_url(); ?>"> 
             <?php echo $CORE->LAYOUT("get_logo","light");  ?>
             <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
             </a>      
        </div>
    
     	<div class="w-100 d-flex ml-md-auto d-none d-md-block-inline">
     
        <div class="d-flex align-items-center ml-auto">  <?php _ppt_template( 'framework/design/header/parts/header-button' ); ?> <div> 
          
    	</div> 
    
    </div>    
   </nav>
 
  <nav class="elementor_mainmenu  menu-bold navbar-bottom navbar navbar-expand-md navbar-light py-2 d-none d-md-block border-top border-bottom">
      <div class="container">
  
         <div class="collapse navbar-collapse main-menu justify-content-center">
            <?php   echo do_shortcode('[MAINMENU class="navbar-nav seperator" style=1]');  ?>
         </div> 
      
      </div>
   </nav>
 
    
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