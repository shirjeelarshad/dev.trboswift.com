<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text16',  'data') );
add_action( 'text16',  		array('block_text16', 'output' ) );
add_action( 'text16-css',  	array('block_text16', 'css' ) );
add_action( 'text16-js',  	array('block_text16', 'js' ) );

class block_text16 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text16'] = array( 
			"name" 	=> "Style 16",
			"image"	=> "text16.jpg",
			"order" => 16,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "text") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "text") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "white",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "white",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "btn-md",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings; 
	
		$settings = array( );  
   
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text16", "text", $settings ) );
 	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
		
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array(800,600));		
		}
	  
	ob_start();
	?>
<section id="text16" class="position-relative <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="bg-image" data-bg="<?php echo $settings['text_image1']; ?>"></div>
  <div class="container bg-content">
    <div class="row align-items-center">
      <div class="col-lg-8 offset-lg-4">
        <?php  _ppt_template( 'framework/design/parts/title' ); ?>
        <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
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
		 
		ob_start();
		?>
<style>

#text16 span {
    display: inline-block;
    text-align: center;
    color: #000;

}

@media (max-width:991px) {
    #text16 br {
        display: none;
    }
    #text16 h2 {
        font-size: 30px;
    }
}
</style>
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
