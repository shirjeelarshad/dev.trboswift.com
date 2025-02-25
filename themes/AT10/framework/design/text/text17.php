<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text17',  'data') );
add_action( 'text17',  		array('block_text17', 'output' ) );
add_action( 'text17-css',  	array('block_text17', 'css' ) );
add_action( 'text17-js',  	array('block_text17', 'js' ) );

class block_text17 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text17'] = array(
			"name" 	=> "Style 17",
			"image"	=> "text17.jpg",
			"order" => 3,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( 	
			),	
			
			"defaults" => array(
					
					"section_padding" => "section-60",
					"section_bg"	=>	"",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "5",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "Beautiful Websites In Minutes",					 
					"subtitle"			=>  "PremiumPress Themes",					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "text1") ),
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "white",
					"subtitle_txtcolor" => "opacity-5",
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
					"btn_txt" 			=> __("Get Started","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "orange",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-2",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "1",				
					"btn2_size" 		=> "btn-xl",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "orange",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4",
					
					
					//"text_image1" => DEMO_IMG_PATH."/innerpages/4.jpg",
					 
			),
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array();  
		
	  	// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text17", "text", $settings ) );
 	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	 
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider'].$settings['section_pos']; ?>">


 <?php if(strlen($settings['text_image1']) > 5){ ?>
        <div class="bg-pattern" data-bg="<?php echo $settings['text_image1']; ?>" style="z-index:100; opacity:1;"></div>
        <?php }else{ ?>
        
         <div class="bg-pattern" data-bg="<?php echo DEMO_IMG_PATH; ?>/blocks/text/icons/bg2.png" style="z-index:100; opacity:1;"></div>
        
       <?php } ?>

 <div class='bg-overlay-green'></div>

<div class="hero_content bg-content clearfix">

<div class="container pt-5">
<div class="row">

<div class="col-12 mb-4 pb-4 textsection">
	<?php _ppt_template( 'framework/design/parts/title' ); ?>
    <?php _ppt_template( 'framework/design/parts/btn' ); ?>
    </div> 
    
    
    </div>
</div>
</div>


   


</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>.textsection p { max-width:550px; }</style>
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