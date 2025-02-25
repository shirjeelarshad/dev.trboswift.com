<?php
 
add_filter( 'ppt_blocks_args',  	array('block_hero_search8',  'data') );
add_action( 'hero_search8',  		array('block_hero_search8', 'output' ) );
add_action( 'hero_search8-css',  	array('block_hero_search8', 'css' ) );
add_action( 'hero_search8-js',  	array('block_hero_search8', 'js' ) );

class block_hero_search8 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search8'] = array(
			"name" 	=> "Hero Location Search",
			"image"	=> "hero_search8.jpg",
			"cat"	=> "hero",
			"order" => 12,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "6",
					"title_heading" 	=> "h1",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "hero") ),					 
					"subtitle"			=> "",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "mb-4",
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
					
					"hero_size" => "hero-large",
					
					 
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero9_bg.jpg",
					"hero_overlay" 		=> "grey", 
					 
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "before",
					"btn_font" 			=> "",
					"btn_txt" 			=> "Explore Website",
					"btn_link" 			=> "[link-search]",
					"btn_bg" 			=> "orange",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "", 
					 			
					
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search8", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search8");		 	 
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
<section id="hero_search8" class="hero-text1 position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default text-<?php echo $settings['hero_txtcolor']; ?>" style="overflow:visible !important;">
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
     
<div class="col-md-12 hide-mobile ">
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
		 
$c =0 ;
$categories = get_categories($args);
 
foreach ($categories as $category) { 

if($c > 10){ continue; }
			 

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
			
			
			$c++;
 
?>

<div class="item">
            <div class="cardxx bg-transparent my-4 shadow-sm py-3">
               <div class="card-body text-center card-hover ">
               <a href="<?php echo get_term_link($category); ?>" class="text-decoration-none">
                  <div class="row">
                  
                     <div class="col-12 col-md-12">
                       
                       
                       
                    	<i class="<?php echo $caticon; ?> fa-3x mb-4 text-light"></i>
                     
                    
                    
                     </div>
                     
                     
                     <div class="col-12  col-md-12">
<h5 data-elementor-setting-key="icon1_title" data-elementor-inline-editing-toolbar="none"  class="elementor-inline-editing small text-light font-weight-bold"><?php echo $category->name; ?></h5>
                        
                         
                     </div>
                     
                      
                  </div>
               </div>
               </a>
            </div>
         </div>
<?php } ?>
         
         </div>
          
 
    </div>
  </div>
</div>
 <?php _ppt_template( 'framework/design/hero/parts/js' ); ?>
</section>
<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#hero_search8 .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
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
 
  jQuery("#hero_search8 .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#hero_search8 .prev").click(function(){
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
		@media (min-width: 1200px) { #hero_search8 .form-control, #hero_search8 .btn { height: 50px !important;} }
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
