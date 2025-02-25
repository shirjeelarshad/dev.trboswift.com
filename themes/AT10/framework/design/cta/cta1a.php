<?php
 
add_filter( 'ppt_blocks_args', 	array('block_cta1a',  'data') );
add_action( 'cta1a',  		array('block_cta1a', 'output' ) );
add_action( 'cta1a-css',  	array('block_cta1a', 'css' ) );
add_action( 'cta1a-js',  	array('block_cta1a', 'js' ) );

class block_cta1a {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['cta1a'] = array(
			"name" 	=> "Style 1 (a)",
			"image"	=> "cta1a.jpg",
			"cat"	=> "cta",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array(
			
				//"image_cta" => array( "t" => "Image", "type" 		=> "upload"  ),
			),		
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "cta") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "cta") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "cta") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Join Now!","premiumpress"),
					"btn_link" 		=> wp_login_url(),
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "",
					  
			), 
			
				
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array();  
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("cta1a", "cta", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		}
		 
		if($settings['subtitle_margin'] == ""){
			$settings['subtitle_margin'] = "mb-0";
		}
		
	 
	ob_start();
	?> 
<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<?php _ppt_template( 'framework/design/parts/section-before' ); ?>
        <div class="container">
            <div class="row align-items-center  text-center text-md-right">
                <div class="col-md-8">
                   <?php _ppt_template( 'framework/design/parts/title' ); ?>
                </div>
                <div class="col-md-4 text-center text-md-right mobile-mt-4">
                   <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
                </div>
            </div>
        </div>
        <?php _ppt_template( 'framework/design/parts/section-after' ); ?>
    </section><?php
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