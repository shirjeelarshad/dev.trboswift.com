<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_map1',  'data') );
add_action( 'hero_map1',  			array('block_hero_map1', 'output' ) );
add_action( 'hero_map1-css',  		array('block_hero_map1', 'css' ) );
add_action( 'hero_map1-js',  		array('block_hero_map1', 'js' ) );

class block_hero_map1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_map1'] = array(
			"name" 	=> "Hero Map 1",
			"image"	=> "hero_map1.jpg",
			"cat"	=> "hero",
			
			"order" => 19,
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
			
			// HIDE VALUES
			"hide-title" 	=> true,	
			"hide-button1" 	=> true,
			"hide-button2" 	=> true,		
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_map1", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		 
 
		ob_start();
		
		
		?>
<section class="hero-text1 position-relative hero-default her-search hero-default hero-map text-<?php echo $settings['hero_txtcolor']; ?>">
  <div class="map-container clearfix">
    <div id="map-main" class="w-100 <?php echo $settings['hero_size']; ?> mb-0">
    <?php
	
	// elementor preview
		if( isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ||  ( isset($_REQUEST['action']) && $_REQUEST['action'] == "elementor" ) ){
	 ?>
     <div class=" y-middle text-center text-dark h-100">
     
     <div> <h1>Map Preview</h1> <br />The map will display here in live view only.</div>
      
     </div>
     <?php
		
		} ?>
    
    </div>
    <div class="position-absolute w-100 py-4" style="bottom:0px; background:#0000004d;">
      <div class="container position-relative">
        <?php _ppt_template( 'framework/design/parts/search-inline' ); ?>
      </div>
    </div>
  </div>
  <input value="15" class="map-zoom" type="hidden" />
  <input value="grey" class="map-color" type="hidden" />
  <textarea id="mapdatabox" class="dynamic_map w-100" style="display:none;"></textarea> 
</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function css(){ global $CORE;
	 
		ob_start();?>
        <style>
		.hero-text1 .form-control  { border:0px; border-radius:0px;; border-bottom:1px solid #fff; padding:0px; background: none;}
.hero-text1 input.form-control { color:#fff;  }	
.hero-text1 select { color:#fff; }		
.hero-text1 ::-webkit-input-placeholder { 
 color: #fff;
}
.hero-text1 ::-moz-placeholder {  
 color: #fff;
}
.hero-text1 :-ms-input-placeholder {
  color: #fff;
}
.hero-text1 :-moz-placeholder {  
 color: #fff;
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