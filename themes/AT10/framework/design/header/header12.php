<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header12',  'data') );
add_action( 'header12',  		array('block_header12', 'output' ) );
add_action( 'header12-css',  	array('block_header12', 'css' ) );

class block_header12 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header12'] = array(
			"name" 	=> "Style 12",
			"image"	=> "header12.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 12,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header12", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header12 b-bottom logo-lg no-sticky <?php if(in_array(_ppt(array('design','boxed_layout')), array('1a','2a','4a')) ){ echo "bg-white"; } ?>">
        
        
                 <?php 
		 
		 $settings['topmenu_bg'] = "text-dark border-bottom";
		 _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
   <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg has-sticky">
   
      <div class="container">
      
         <a class="navbar-brand" href="<?php echo home_url(); ?>"> 
         <?php echo $CORE->LAYOUT("get_logo","light");  ?>
         <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
         </a>
         
        
           <div>
            <?php _ppt_template( 'framework/design/header/parts/header-advertising' ); ?> 
            </div>          
        
      </div>
   </nav> 
   
   
  <?php 
   
   $settings['submenu_bg'] = "bg-primary shadow-sm navbar-dark";
   
   _ppt_template( 'framework/design/header/parts/header-submenu' ); ?> 
   
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>
        <style>
		.header12 .sellspace-live { width:468px; }
		</style>
        <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>