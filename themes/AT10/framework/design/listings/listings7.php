<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings7',  'data') );
add_action( 'listings7',  		array('block_listings7', 'output' ) );
add_action( 'listings7-css',  	array('block_listings7', 'css' ) );
add_action( 'listings7-js',  	array('block_listings7', 'js' ) );

class block_listings7 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
  
		$a['listings7'] = array(
			"name" 	=> "Style 7 - small list",
			"image"	=> "listings7.jpg",
			"cat"	=> "listings",
			"desc" 	=> "", 
			"order" 	=> 7, 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "no",
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
	
	
		$settings = array( "datastring" => "custom=new num=5" );  
	 
	   // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings7", "listings", $settings ) );
 		 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		 
 	$settings['card'] = "list-xsmall";
	
	$GLOBALS['max_img_size'] = 250;
	
	ob_start();
	
	$randomID = rand(0,9999);	 
	 
	?>
 
    
<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
          
     
    <?php if($settings['title_show'] == "yes"){ ?>
    <div class="col-12 mb-5">
      <?php _ppt_template( 'framework/design/parts/title' ); ?>
    </div>
    <?php } ?>
    
 
    <div class="col-lg-4 col-6">
    
    <div class="block-header"><h3 class="block-header__title"><?php echo __("Newly Added","premiumpress"); ?></h3><div class="block-header__divider"></div></div>
    
    <?php echo do_shortcode('[LISTINGS dataonly=1 nav=0 carousel=1  custom="new" show=4  ]');  ?>  
    </div>
    
    <div class="col-lg-4 col-6">
    <div class="block-header"><h3 class="block-header__title"><?php echo __("Most Popular","premiumpress"); ?></h3><div class="block-header__divider"></div></div>
    
    <?php echo do_shortcode('[LISTINGS dataonly=1 nav=0   carousel=1 custom="popular" show=4   ]');  ?>  
    </div>
    <div class="col-lg-4 d-none d-lg-block">
    
    <div class="block-header"><h3 class="block-header__title"><?php echo __("Featured","premiumpress"); ?></h3><div class="block-header__divider"></div></div>
    
    <?php echo do_shortcode('[LISTINGS dataonly=1 nav=0   carousel=1 custom="featured" show=4  ]');  ?>  
    </div>        
            
         
      </div>
   </div>
</section>
		<?php
		
		
		$output = ob_get_contents();
		ob_end_clean();
		
		unset($GLOBALS['max_img_size']);
		
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