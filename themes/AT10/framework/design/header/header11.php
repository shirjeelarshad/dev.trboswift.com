<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header11',  'data') );
add_action( 'header11',  		array('block_header11', 'output' ) );
add_action( 'header11-css',  	array('block_header11', 'css' ) );

class block_header11 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header11'] = array(
			"name" 	=> "Style 11",
			"image"	=> "header11.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 11,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header11", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header11 b-bottom logo-lg <?php if(in_array(_ppt(array('design','boxed_layout')), array('1a','2a','4a')) ){ echo "bg-white"; } ?>">
        
        
                 <?php 
		 
		 $settings['topmenu_bg'] = "text-dark border-bottom";
		 _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
   <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg has-sticky">
   
      <div class="container <?php if($settings['btn_show'] == "yes"){ ?> pr-0<?php } ?>">
      
         <a class="navbar-brand" href="<?php echo home_url(); ?>"> 
         <?php echo $CORE->LAYOUT("get_logo","light");  ?>
         <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
         </a>
         
         
         <div class="collapse navbar-collapse main-menu justify-content-end">
            <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?>
         </div>  
         
           <?php if($settings['btn_show'] == "yes"){ ?> 
        
            <?php _ppt_template( 'framework/design/header/parts/header-button' ); ?>           
         
         <?php }else{ ?>
         
          <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button> 
        
         <?php } ?>
         
      </div>
   </nav> 
   
   
   <div class=" <?php if(in_array(_ppt(array('design','boxed_layout')), array('1', '1a','2a','4a')) ){ echo "px-0 mx-0 container-fluid"; }else{ ?>container<?php } ?> d-none d-md-block">
   <div class="bg-secondary p-3">
   
   
     <?php
	 
	 
	  _ppt_template( 'framework/design/parts/search-inline' ); ?> 
   
   
   </div>
   
   </div>
 
    
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>
        <style>
		.header11 form .form-control, .header11 form .btn { border-radius:0px !important; border:0px; }
		</style>

        <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>