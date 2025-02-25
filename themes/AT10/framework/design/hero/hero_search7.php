<?php
 
add_filter( 'ppt_blocks_args',  	array('block_hero_search7',  'data') );
add_action( 'hero_search7',  		array('block_hero_search7', 'output' ) );
add_action( 'hero_search7-css',  	array('block_hero_search7', 'css' ) );
add_action( 'hero_search7-js',  	array('block_hero_search7', 'js' ) );

class block_hero_search7 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search7'] = array(
			"name" 	=> "Hero Search - Style 7",
			"image"	=> "hero_search7.jpg",
			"cat"	=> "hero",
			"order" => 10,
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
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "light",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					
					"hero_size" => "hero-small",
					"hero_overlay" => "primary",
					  
					
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
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search7", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search7");		 	 
			$settings['hero_overlay'] = $default_data['hero_overlay'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
		
		
		$settings['title_pos'] = "center";
 
		
	 
 
		ob_start();
		
		
		?>

<section class="hero-search7 hero-search position-relative section-60 text-<?php echo $settings['hero_txtcolor']; ?>">
  <div class="container">
    <div class="card bg-<?php echo $settings['hero_overlay']; ?> card-body p-lg-5 border-0">
      <?php if(strlen($settings['hero_image']) > 5){ ?>
      <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
      <?php }else{ ?>
      <div class="bg-pattern-small" data-bg="<?php echo get_template_directory_uri(); ?>/framework/images/pattern/4.svg"></div>
      <?php } ?>
      <div class="bg-content">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
        <form method="get" action="<?php echo home_url(); ?>" class="py-lg-0">
          <div class="form-input position-relative">
            <input name="s" class="form-control typeahead homepage--search" autocomplete="off" placeholder="<?php echo __("Start your search here...","premiumpress"); ?>" />
            <button class="btn position-absolute prev" style="left:10px; top:8px;" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </form>
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
		.homepage--search {
    border: none;
    background: #fafafa;
    border-radius: 5px;
    font-size: 18px;
    color: #888;
    padding: 0 20px;
    height: 50px;
    width: 100%;
	padding-left:60px;
 
}
		
		</style>
<?php $output = ob_get_contents();  ob_end_clean();
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
