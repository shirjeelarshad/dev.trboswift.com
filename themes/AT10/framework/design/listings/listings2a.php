<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings2a',  'data') );
add_action( 'listings2a',  		array('block_listings2a', 'output' ) );
//add_action( 'listings2a-css',  	array('block_listings2a', 'css' ) );
//add_action( 'listings2a-js',  	array('block_listings2a', 'js' ) );

class block_listings2a {

	function __construct(){}		

	public static function data($a){ global $CORE;  
  
		$a['listings2a'] = array(
			"name" 	=> "Style 2 - Block (extra)",
			"image"	=> "listings2a.jpg",
			"cat"	=> "listings",
			"order" => 2,
			"desc" 	=> "", 
			"data" 	=> array( ),	

			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "listings") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "listings") ),					
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
	
	
		$settings = array( 
					
				"datastring" => "custom=new&num=12",
				 
		 );  
	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings2a", "listings", $settings ) ); 
 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
 
	ob_start();
	 
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="container">
<div class="row">
  <?php if($settings['title_show'] == "yes"){ ?>
  <div class="col-12 section-bottom-40">
    <?php _ppt_template( 'framework/design/parts/title' ); ?>
  </div>
  <?php } ?>
  <div class="col-12">
    <div class="clearfix"></div>
    <?php
	 
	if(in_array($settings['card'], array("list" ) )){
	
	echo do_shortcode('[LISTINGS dataonly=1 nav=0   card_class="col-12" '.$settings['datastring'].' ]');
	
	}elseif(in_array($settings['card'], array("list-small" ) )){
	
	echo do_shortcode('[LISTINGS dataonly=1 nav=0 '.$settings['datastring'].' ]');
	
	}else{
	echo do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 '.$settings['datastring'].' ]');
	}
	
	
	  ?> </div>
</div>
</section>
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