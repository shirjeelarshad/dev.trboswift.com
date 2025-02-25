<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text4',  'data') );
add_action( 'text4',  		array('block_text4', 'output' ) );
add_action( 'text4-css',  	array('block_text4', 'css' ) );
add_action( 'text4-js',  	array('block_text4', 'js' ) );

class block_text4 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "text4.jpg",
			"order" => 4,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			
			"defaults" => array(
					
					// TEXT
					
					"section_padding" => "section-60",
					"section_bg"	=>	"bg-light",	
						
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text4", "text", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array(600,800));
		}
		
		if($settings['text_image2'] == ""){
		$settings['text_image2'] =  $CORE->LAYOUT("get_placeholder",array(600,800));
		}
		
		 
	 
	ob_start();
?>
 

<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   
      <div class="row d-flex flex-lg-row-reverse y-middle">
      
         <div class="col-md-12 col-lg-6 text-center text-md-left pl-lg-5">
          
		  <?php _ppt_template( 'framework/design/parts/title' ); ?>
             
            <?php _ppt_template( 'framework/design/parts/btn' ); ?>
          
      </div>
      <div class="col-md-12 col-lg-6">
      
         <div class="row">
         
         <div class="col-md-6">
            <img data-src="<?php echo $settings['text_image1']; ?>" alt="<?php echo strip_tags($settings['text_image1_title']); ?>" class="img-fluid lazy">
         </div>
         
           <div class="col-md-6 d-none d-md-block">
            <img data-src="<?php echo $settings['text_image2']; ?>" alt="<?php echo strip_tags($settings['text_image2_title']); ?>" class="img-fluid lazy">
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