<?php
 
add_filter( 'ppt_blocks_args',  	array('block_hero_search6',  'data') );
add_action( 'hero_search6',  		array('block_hero_search6', 'output' ) );
add_action( 'hero_search6-css',  	array('block_hero_search6', 'css' ) );
add_action( 'hero_search6-js',  	array('block_hero_search6', 'js' ) );

class block_hero_search6 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search6'] = array(
			"name" 	=> "Hero Location Search",
			"image"	=> "hero_search6.jpg",
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
					"subtitle"			=> "",					
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
					
					"hero_size" => "hero-large",
					
					 
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search6", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search6");		 	 
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
<section id="hero_search6" class="hero-text1 position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default text-<?php echo $settings['hero_txtcolor']; ?>" style="overflow:visible !important;">
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
            <form method="get" action="<?php echo home_url(); ?>" class="py-lg-0">
              <input type="hidden" name="s" value="" />
              <div class="row">
              
              
              
                <div class="col-md-6">
                  <div class="form-input position-relative">
                    <input name="zipcode" class="form-control typeahead" autocomplete="off" placeholder="<?php echo __("Town, city, postcode...","premiumpress"); ?>" />
                   
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
					 
						 default: {?>
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
          
<div class="col-md-12 hide-mobile mt-5">
   <div  class="owl-carousel owl-theme">      
      
         <?php 
		 
		 
		 	$orderby = "menu_order";
	$order = "asc";	
	
	
	$args = array(
	
		'taxonomy'  	=> 'listing',
		'depth'         => 0,	
		'hierarchical'  => true,		
		'hide_empty'    => 0,
		'echo'			=> false,
		'title_li' 		=> '', 
		'walker'		=> new walker_shortcode_dcats,			
		'orderby'      => $orderby,
		'order'		 	=> $order, 
		'limit' 		=> 10,
		'limit_list' 	=> 0,
		'offset'		=> 0,		
		'show_count'	=> 1,
	
	); 
$c=1;
$categories = get_categories($args);
 
foreach ($categories as $category) { 

			if(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) && $GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id] != ""   ){
                        $caticon = "fal ".str_replace("&", "&amp;",$GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]);
            }else{
			
				$cat_icons_small = array(
		
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-coffee',
						'fa-university',
						'fa-archive',
						'fa-laptop',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
		
		);	
		
		if(isset($cat_icons_small[$c])){
		$caticon = "fal ".$cat_icons_small[$c];
		}else{
		$caticon = "fal fa-check";
		}
			
                        
            }
			
			if($c > 10){  $c++; continue; }
 
?>

<div class="item">
            <div class="card my-4 shadow-sm py-3">
               <div class="card-body text-center card-hover ">
               <a href="<?php echo get_term_link($category); ?>" class="text-decoration-none">
                  <div class="row">
                  
                     <div class="col-12 col-md-12">
                       
                       
                       
                    	<i class="<?php echo $caticon; ?> fa-3x mb-4 text-primary"></i>
                     
                    
                    
                     </div>
                     
                     
                     <div class="col-12  col-md-12">
<h5 data-elementor-setting-key="icon1_title" data-elementor-inline-editing-toolbar="none"  class="elementor-inline-editing small text-dark"><?php echo $category->name; ?></h5>
                        
                         
                     </div>
                     
                      
                  </div>
               </div>
               </a>
            </div>
         </div>
<?php $c++; } ?>
         
         </div>
          
 
    </div>
  </div>
</div>
</section>
<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#hero_search6 .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        nav: false,
        dots: true,
		 
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        },        
    }); 
	
	owl.owlCarousel();
 
  jQuery("#hero_search6 .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#hero_search6 .prev").click(function(){
    owl.trigger('prev.owl.carousel');
  })
	
	
	});		 
</script>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function css(){ global $CORE;		
		ob_start(); ?>
        <style>
		@media (min-width: 1200px) { #hero_search6 .form-control, #hero_search6 .btn { height: 50px !important;} }
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
