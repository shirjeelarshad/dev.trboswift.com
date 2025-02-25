<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text14',  'data') );
add_action( 'text14',  		array('block_text14', 'output' ) );
add_action( 'text14-css',  	array('block_text14', 'css' ) );
add_action( 'text14-js',  	array('block_text14', 'js' ) );

class block_text14 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text14'] = array(
			"name" 	=> "Style 14",
			"image"	=> "text14.jpg",
			"order" => 14,
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text14", "text", $settings ) );
	 
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
 
		// TITLE STYLE
		if($settings["title_style"] == ""){
			$settings["title_style"] = "basic-color-h2";
		}
	 
	ob_start();
?>
 

<section class="position-relative  <?php echo $settings['section_class']." ".$settings['section_bg']."  ".$settings['section_divider']; ?>">
   <div class="container-fluid px-0">
   
      <div class="row no-gutters d-flex flex-md-row-reverse y-middle">
     
      <div class="bg-pattern-small" data-bg="<?php echo get_template_directory_uri(); ?>/framework/images/pattern/6.svg"></div>

         <div class="col-md-6 col-xl-7 pl-lg-5 p-4 text-center text-md-left bg-content pt-5">
          
          	
            <div class="col-xl-10 mx-auto">
        	<?php _ppt_template( 'framework/design/parts/title' ); ?>
            
            <div class="my-4">
            <?php _ppt_template( 'framework/design/parts/btn' ); ?>
            </div>
      		</div>
         
      </div>
      
       
       <div class="col-md-6 col-xl-5 bg-cover  bg-content eqh hide-mobile"  style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('<?php echo $settings['text_image1']; ?>'); min-height:600px;">
            
            
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