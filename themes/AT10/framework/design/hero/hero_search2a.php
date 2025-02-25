<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_search2a',  'data') );
add_action( 'hero_search2a',  			array('block_hero_search2a', 'output' ) );
add_action( 'hero_search2a-css',  		array('block_hero_search2a', 'css' ) );
add_action( 'hero_search2a-js',  		array('block_hero_search2a', 'js' ) );

class block_hero_search2a {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search2a'] = array(
			"name" 	=> "Hero Search 2",
			"image"	=> "hero_search2a.jpg",
			"cat"	=> "hero",
			"order" => 4,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=> "Get Started Today",					 
					"subtitle"			=> "",					
					"desc" 				=> "Filter your search results below;",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "primary",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					 
					"hero_size" 		=> "hero-medium",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero4_bg.jpg",
					"hero_overlay" 		=> "primary", 				
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search2a", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search2a");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}	
		
		// TITLE STYLE
		$settings["title_heading"] = "h4";
 
		ob_start();
		
		
		?>
<section class="hero-search2a position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default">
<div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
<?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>
<div class="hero_content bg-content clearfix">
<div class="container">
  <div class="col-md-6 col-lg-6 col-xl-5">
    <div class="bg-white text-dark shadow p-4">
      <?php 
			    
			  _ppt_template( 'framework/design/parts/title' ); ?>
              
      <?php _ppt_template( 'framework/design/parts/search-list-big' ); ?>
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
	 
		ob_start();
		?>
        <style>
		.hero-search2a h1, .hero-search2a h4 {
		font-size: 32px;
    line-height: 42px;
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