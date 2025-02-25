<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_search1',  'data') );
add_action( 'hero_search1',  			array('block_hero_search1', 'output' ) );
add_action( 'hero_search1-css',  		array('block_hero_search1', 'css' ) );
add_action( 'hero_search1-js',  		array('block_hero_search1', 'js' ) );

class block_hero_search1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search1'] = array(
			"name" 	=> "Hero Search 1",
			"image"	=> "hero_search1.jpg",
			"cat"	=> "hero",
			
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "hero") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "hero") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "light",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					
					
					"hero_size" 		=> "hero-medium",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero1_bg.jpg",
					"hero_overlay" 		=> "grey", 
					
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
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array(); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search1", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		
		
		/* DEFAULTS */
		if($settings['hero_image'] == ""){
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search1");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
		 
 		$settings["title_pos"] = "center";	
		 
		ob_start();
		
		
		?>
<section class="hero-text1 position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default text-<?php echo $settings['hero_txtcolor']; ?>">
<div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
<?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>

<div class="hero_content bg-content clearfix">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 text-center mt-md-5">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
        <?php _ppt_template( 'framework/design/parts/btn' ); ?>
      </div>
      <div class="col-md-10 mx-auto text-center my-5">
        <div class="wrapp bg-white-50 p-2 shadow rounded">
          <div class="bg-white p-4 rounded">
            <?php _ppt_template( 'framework/design/parts/search-inline' ); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function css(){ global $CORE;
	 
		ob_start();?>
        <style>
		.hero-text1 .form-control { border:0px; border-radius:0px;; border-bottom:1px dashed #ccc; padding:0px; }		
.hero-text1 ::-webkit-input-placeholder { 
 color: #495057;
}
.hero-text1 ::-moz-placeholder {  
 color: #495057;
}
.hero-text1 :-ms-input-placeholder {
  color: #495057;
}
.hero-text1 :-moz-placeholder {  
 color: #495057;
}
		</style>
        <?php
	 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function js(){ global $CORE;
		ob_start();
	  _ppt_template( 'framework/design/hero/parts/js' );  
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>