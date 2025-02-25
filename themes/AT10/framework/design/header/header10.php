<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header10',  'data') );
add_action( 'header10',  		array('block_header10', 'output' ) );
add_action( 'header10-css',  	array('block_header10', 'css' ) );

class block_header10 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header10'] = array(
			"name" 	=> "Style 10",
			"image"	=> "header10.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 10,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header10", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header10 tmb text-md logo-lg">
        
<?php 

$settings['topmenu_bg'] = "bg-white text-dark border-bottom";

_ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
        
   <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
      <div class="container-fluid"> 
      
      
     <div class="navbar-collapse collapse w-100">
	   
      <?php /* <button class="menu-toggle bg-primary border-0 position-absolutex text-center text-light fixed-topx" style="top:60px; left:20px; width:60px; height:60px; border-radius: 50%;"><span class="fal fa-bars">&nbsp;</span></button> */ ?>
       
       </div>   
      
       <div class="mx-auto text-center">
            <a class="navbar-brand" href="<?php echo home_url(); ?>"> 
             <?php echo $CORE->LAYOUT("get_logo","light");  ?>
             <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
             </a>     
             
            <?php if($settings['btn_show'] == "yes" && !isset($GLOBALS['flag-add'])){ ?> 
            <div class="mt-2">
           <a href="<?php echo $settings['btn_link']; ?>"><u><?php echo $settings['btn_txt']; ?></u></a>
           </div>
           <?php } ?>
        </div>
      
     
   
     	<div class="w-lg-100 d-flex ml-lg-auto">
     
           
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