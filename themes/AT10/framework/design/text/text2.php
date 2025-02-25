<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text2',  'data') );
add_action( 'text2',  		array('block_text2', 'output' ) );
add_action( 'text2-css',  	array('block_text2', 'css' ) );
add_action( 'text2-js',  	array('block_text2', 'js' ) );

class block_text2 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "text2.jpg",
			"order" => 2,
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
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "yes",						
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text2", "text", $settings ) );
		 
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
	
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
      <div class="row y-middle">        
         <div class="col-lg-6 pr-lg-5 text-center text-lg-left">
            
            <?php _ppt_template( 'framework/design/parts/title' ); ?>
            
            <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
         </div>
         
          <div class="col-lg-6 pl-lg-5">
          <?php if(isset($settings['text_image1_link']) && strlen($settings['text_image1_link']) > 1){ ?>
    <a href="<?php echo $settings['text_image1_link']; ?>">
    <?php } ?>
            <img data-src="<?php echo $settings['text_image1']; ?>" class="img-fluid mt-5 mt-lg-0 lazy" alt="<?php echo strip_tags($settings['title']); ?>" />
           <?php if(isset($settings['text_image1_link']) && strlen($settings['text_image1_link']) > 1){ ?>  </a>  <?php } ?>
         </div>
         
      </div>
   </div>
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