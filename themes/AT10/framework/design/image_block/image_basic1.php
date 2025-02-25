<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic1',  'data') );
add_action( 'image_basic1',  		array('block_image_basic1', 'output' ) );
add_action( 'image_basic1-css',  	array('block_image_basic1', 'css' ) );
add_action( 'image_basic1-js',  	array('block_image_basic1', 'js' ) );

class block_image_basic1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic1'] = array(
			"name" 	=> "Basic 1 ",
			"image"	=> "image_basic1.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 1,
			"data" 	=> array( ),	
						"defaults" => array(
					
					"section_padding" => "section-60",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "Beautiful Websites In Minutes",					 
					"subtitle"			=> "",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
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
					  
			),		
						 
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic1", "image_block", $settings ) );
 		 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		  		 	
		if($settings['image_block1'] == ""){			
			$settings['image_block1'] = $CORE->LAYOUT("get_placeholder",array('full'));	 
		 }
 
 		global $imagedata;
 
		ob_start();
		?>
<section class="image_block grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="<?php echo $settings['section_w']; ?>">

<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>
<div class="row"> 
<div class="col-12 <?php if($settings['section_w'] == "container-fluid"){ ?>px-0<?php } ?>">
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?> 
</div>   
 

</div></div>
</section> <?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ return ""; }	
	public static function js(){ return ""; }	
	
}

?>