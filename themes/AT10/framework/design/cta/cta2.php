<?php
 
add_filter( 'ppt_blocks_args', 	array('block_cta2',  'data') );
add_action( 'cta2',  		array('block_cta2', 'output' ) );
add_action( 'cta2-css',  	array('block_cta2', 'css' ) );
add_action( 'cta2-js',  	array('block_cta2', 'js' ) );

class block_cta2 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['cta2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "cta2.jpg",
			"cat"	=> "cta",
			"order" => 2,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
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
	
	
		$settings = array( );  
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("cta2", "cta", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		}
		
		$settings['title_pos'] = "center";
		
	 
	ob_start();
	?> 
<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<?php _ppt_template( 'framework/design/parts/section-before' ); ?>
<div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                       
                      <?php _ppt_template( 'framework/design/parts/title' ); ?>
                       
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