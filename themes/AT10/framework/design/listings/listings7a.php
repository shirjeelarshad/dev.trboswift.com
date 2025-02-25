<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings7a',  'data') );
add_action( 'listings7a',  		array('block_listings7a', 'output' ) );
add_action( 'listings7a-css',  	array('block_listings7a', 'css' ) );
add_action( 'listings7a-js',  	array('block_listings7a', 'js' ) );

class block_listings7a {

	function __construct(){}		

	public static function data($a){ global $CORE;  
  
		$a['listings7a'] = array(
			"name" 	=> "Style 7 (a) - custom",
			"image"	=> "listings7a.jpg",
			"cat"	=> "listings",
			"desc" 	=> "", 
			"order" 	=> 7, 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "listings") ),					 
					"subtitle"			=> "",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
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
	
	
		$settings = array();  
	 
	   // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings7a", "listings", $settings ) );
 		 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		 
 	$settings['card'] = "list-xsmall";
	
	ob_start();
	
	$randomID = rand(0,9999);
	 
	?>

<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="block-header">
          <h3 class="block-header__title"><?php echo $settings['title']; ?></h3>
          <div class="block-header__divider"></div>
        </div>
        <?php echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=12 card_class="col-lg-4 col-6" '.$settings['datastring'].'  ]');  ?> </div>
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
.block-header{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;margin-bottom:24px; font-size:28px;font-weight:700; }
.block-header__title{margin-bottom:0;font-size:20px;}
.block-header__divider{-ms-flex-positive:1;flex-grow:1;height:2px;background:#ebebeb;}
.block-header__title+.block-header__divider{margin-left:16px;}
@media (max-width:767px){
.block-header{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;}
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
