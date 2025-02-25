<?php
 
add_filter( 'ppt_blocks_args', 	array('block_faq2',  'data') );
add_action( 'faq2',  		array('block_faq2', 'output' ) );
add_action( 'faq2-css',  	array('block_faq2', 'css' ) );
add_action( 'faq2-js',  	array('block_faq2', 'js' ) );

class block_faq2 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['faq2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "faq2.jpg",
			"cat"	=> "faq",
			"order" => 2,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "faq") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "faq") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc_small', "faq") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "mb-5",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "no",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> "",
					"btn_link" 			=> "",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> "",
					"btn2_link" 		=> "",
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					 
			),
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("faq2", "faq", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		/* DEFAULTS */
		if($settings['image_faq'] == ""){
		$settings['image_faq'] =  $CORE->LAYOUT("get_placeholder",array(800,600));
		}
		
	 
	 
	ob_start();
	?>
    
<section class="faq_default grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row d-flex flex-lg-row-reverse"> 
              

                
                <div class="col-md-6 pl-lg-5">
                
                <?php  _ppt_template( 'framework/design/parts/title' ); ?>                           
                <?php  _ppt_template( 'framework/design/parts/btn' ); ?>                             
                <div class="mt-4">
                <?php  _ppt_template( 'framework/design/faq/parts/faq1' ); ?>
                </div>
                
                </div>
                
                <div class="col-md-6">   
                             
<img data-src="<?php echo $settings['image_faq']; ?>" class="img-fluid lazy" alt="faq" />  
                    
                </div>
                
            </div>
        </div>
   </section>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
        <?php	
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