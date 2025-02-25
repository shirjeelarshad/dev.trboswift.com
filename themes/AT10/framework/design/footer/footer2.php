<?php
 
add_filter( 'ppt_blocks_args', 	array('block_footer2',  'data') );
add_action( 'footer2',  		array('block_footer2', 'output' ) );
add_action( 'footer2-css',  	array('block_footer2', 'css' ) );
add_action( 'footer2-js',  	array('block_footer2', 'js' ) );

class block_footer2 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['footer2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "footer2.jpg",
			"cat"	=> "footer",
			"order" => 2,
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
	$settings = array( );  
	  
	 // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("footer2", "footer", $settings ) );
		
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
<footer class="footer <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 text-center text-md-left">
                        
                            <a href="<?php echo home_url(); ?>">
                                 <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
                            </a> 
                  
                        </div>
                        
                        <div class="col-md-8 text-center mt-4 mt-md-0 text-md-right">
                        
                        
        <?php if(isset($settings['footer_menu1']) && strlen($settings['footer_menu1']) > 2){ ?>
        
          <?php echo str_replace("menu-item","list-inline-item", str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu1'].'" class="list-inline"][/MAINMENU]'))); ?>
        
        
          <?php }else{ ?>
          
        
        <?php  echo str_replace("menu-item","list-inline-item", str_replace("<li>","<li class='list-inline-item'>", str_replace("list-unstyled","list-inline", str_replace("nav-link","text-dark",do_shortcode('[MAINMENU footer=1 class="list-inline"][/MAINMENU]')))));  ?>
                        
                   
                            
                              <?php } ?>                       

                        </div>            
        </div>
        
        
        
        <?php

// FOOTE BOTTOM
if(!isset($settings["footer_copyright_style"])){  $settings["footer_copyright_style"] = "";}
switch($settings["footer_copyright_style"]){

	case "1": {
		_ppt_template( 'framework/design/footer/parts/bottom-left' ); 
	} break;
	case "2": {
		_ppt_template( 'framework/design/footer/parts/bottom-center' ); 
	} break;
	case "3": {
		_ppt_template( 'framework/design/footer/parts/bottom-right' ); 
	} break;
 	case "4": {
		_ppt_template( 'framework/design/footer/parts/bottom-cards' ); 
	} break;
 	case "5": {
		_ppt_template( 'framework/design/footer/parts/bottom-social' ); 
	} break;		
	default: {
		_ppt_template( 'framework/design/footer/parts/bottom-cards' ); 	
	}
}
?> 
        
</div> 
</footer>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static  function css(){
	 	return "";
		ob_start();
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>