<?php
 
add_filter( 'ppt_blocks_args',  	array('block_hero_search5',  'data') );
add_action( 'hero_search5',  		array('block_hero_search5', 'output' ) );
add_action( 'hero_search5-css',  	array('block_hero_search5', 'css' ) );
add_action( 'hero_search5-js',  	array('block_hero_search5', 'js' ) );

class block_hero_search5 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search5'] = array(
			"name" 	=> "Hero Location Search",
			"image"	=> "hero_search5.jpg",
			"cat"	=> "hero",
			"order" => 12,
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
					"hero_overlay" 		=> "black", 
					 
					
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search5", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search5");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
		
		
		
		$settings['title_pos'] = "center";
		
   $categories = wp_list_categories( 
   	array(
   	'taxonomy'  	=> 'listing',
   	'depth'         => 1,	
   	'hierarchical'  => 1,		
   	'hide_empty'    => 0,
   	'echo'			=> false,
   	'title_li' 		=> '',
   	'orderby' 		=> 'term_order',
   	'walker'		=> new walker_shortcode_dcats,
   	'limit' 		=> 16,
   	'show_count'	=> 0,
   	) 
   );
		
		
	 
 
		ob_start();
		
		
		?>
<section class="hero-text1 hero-demo position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default text-<?php echo $settings['hero_txtcolor']; ?>" style="overflow:visible !important;">
<div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
<?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>
<div class="hero_content bg-content clearfix">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 text-center mt-md-5">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
        <?php _ppt_template( 'framework/design/parts/btn' ); ?>
      </div>
      <div class="col-md-10 mx-auto text-center my-md-5">
        <div class="wrapp bg-white-50 p-2 shadow rounded">
          <div class="bg-white p-4 rounded">
            <form method="get" action="<?php echo home_url(); ?>" class="py-lg-0">
             
              <div class="row">
              
              
              
                <div class="col-md-6">
                  <div class="form-input position-relative">
                  
                  
                  <?php if(_ppt(array("maps","enable")) == "1" && _ppt(array("maps","provider")) != "basic"){  ?>
                  
                   <input name="zipcode" class="form-control typeahead" autocomplete="off" placeholder="<?php echo __("Town, city, postcode...","premiumpress"); ?>" />
                    <input type="hidden" name="s" value="" />
                  <?php }else{ ?>
                  
                   <input name="s" class="form-control typeahead" autocomplete="off" placeholder="<?php echo __("Keyword...","premiumpress"); ?>" />
                   
                  <?php } ?>
                   
                    </div>
                </div>
                
                <div class="col-md-3">
                  <div class="form-input position-relative">
                     <?php 
					 
					 
					 switch(THEME_KEY){
					 
					 	case "rt": {						
						 
                        $foundcats 	= get_terms( "type", array( 'hide_empty' => 0  )); ?>
                        
                        <select class="form-control form-control-custom" name="tax-type">
                   
                          <?php if(is_array($foundcats) && !empty($foundcats)){
                        foreach($foundcats as $cat){ ?>
                          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
                          <?php
                             
                        }
                    }	?>
                        </select>
                        
                        <?php
						
						} break;
					 
						 default: {						 
						 
						 
						if(_ppt(array("maps","enable")) == "1" && _ppt(array("maps","provider")) == "basic"){  
						
						global $wpdb;
                        
						
						$selected_country = "";
                        
                          $SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a INNER JOIN ".$wpdb->postmeta." AS t ON ( a.meta_key = 'map-country' AND t.post_id = a.post_id ) LIMIT 60";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				if(count($results) > 0 && !empty($results) ){
				
				?>
      <select class="form-control" name="country">
        <option value=""><?php echo __("Any Country","premiumpress"); ?></option>
        <?php	
					$in_array = array(); $statesArray = array();
					foreach ($results as $val){			
						
						$state = $val->meta_value;						
						if(!in_array($state,$in_array)){						
							
							// ADD TO ARRAY
							$in_array[] = $state;
							$statesArray[] .= $state;
						}// if in array					
					} // end while	
					
					// NOW RE-ORDER AND DISPLAY
					asort($statesArray);
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							
							
							$name = $state;			
							
							
							if(isset($GLOBALS['core_country_list'][$state])){
							
								$name = $GLOBALS['core_country_list'][$state];
								
							}else{
								foreach($GLOBALS['core_country_list'] as $country){
								
									if($country == $state){
									
										$name = $country;
									
									}
								}
							
							}
							
							if( $selected_country == $state){
							echo "<option value='".trim($state)."' selected=selected>". $name."</option>";
							}else{
							echo "<option value='".trim($state)."'>". $name."</option>";
							}
					}  
	 
	  
		  ?>
      </select>
                        
                  <?php } ?>
						 
						 <?php }else{ ?>
                          <select name="tax-listing" class="form-control rounded-0 bg-white">
          <option value=""><?php echo __("Any Category","premiumpress"); ?></option>
          <?php
                  $count = 1;
                  $cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
          <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php $count++; } } ?>
        </select>
        
        <?php } ?>
						 
						 
						 <?php } break;
					 
					 }
			?> 
		 
                    </div>
                </div>         
                
                
                <div class="col-md-3">
                  <button class="btn-block btn btn-primary rounded-0" style="height: 45px;" type="submit"><?php echo __("Search","premiumpress"); ?></button>
                </div>
              </div>
            </form>
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
		
		return "";
	
		ob_start(); 
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