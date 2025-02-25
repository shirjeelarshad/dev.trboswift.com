<?php
 
add_filter( 'ppt_blocks_args',  	array('block_listings_n3',  'data') );
add_action( 'listings_n3',  	array('block_listings_n3', 'output' ) );
add_action( 'listings_n3-css',  array('block_listings_n3', 'css' ) );
add_action( 'listings_n3-js',  	array('block_listings_n3', 'js' ) );

class block_listings_n3 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
	
		global $CORE;
  
		$a['listings_n3'] = array(
			"name" 	=> "Style - 1",
			"image"	=> "listings_n3.jpg",
			"cat"	=> "listings",
			"order" => 6,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					"section_padding" => "section-40",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "no",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "text") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "yes",						
					"btn2_style" 		=> "1",				
					"btn2_size" 		=> "btn-xl",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "dark",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4",
					
					 
			), 
			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE,  $wpdb, $settings, $new_settings;
	
	
        $settings = array( );
		  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings_n3", "listings", $settings ) );
 	  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
	 	
		ob_start();
		?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." section-40 ".$settings['section_divider']; ?>">
  <div class="container">
    <?php if($settings['title_show'] == "yes"){ ?>
    <div class="row">
      <div class="col-12 mb-4">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
    </div>
    <?php } ?>
    <div class="row d-flex">
      
   
       
      <div class="col-12">
        <div class="listing1-carousel-6 owl-carousel owl-theme ">
          <?php
		  
		  
$args = array('posts_per_page' => 6, 
			'post_type' => "listing_type", 
			'meta_query' => array (
			
				'relation'    => 'AND',						
							array(							
							'homepage'    => array(
								'key' 			=> 'homepage',
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),
							 					
						),	
				  ) 
			 );
			 
			if(defined('WLT_DEMOMODE')){
			 
			 $args = array('posts_per_page' => 2,  'post_type' => "listing_type",  'orderby' => 'rand',   );		
			 
			 }
	
 	   
			  
      $wp_query = new WP_Query($args); 
      $tt = $wpdb->get_results($wp_query->request, OBJECT);      
      if(!empty($tt)){
	  $counter = 1;
      foreach($tt as $p){
      global $post;
      $post = get_post($p->ID);		
		
		$link = get_permalink($post->ID);
		
		$img = str_replace("lazy","", str_replace("data-", "", do_shortcode('[IMAGE link=0 pathonly=1]')));
		
		if(THEME_KEY == "cp" && defined('WLT_DEMOMODE') ){		
		$img = _ppt_demopath()."/banner".$counter.".jpg";		
		}
		$counter++;
		
?>
          <div class="new-search no-resize info mb-0" data-pid="<?php echo $post->ID; ?>">
            <figure> <a href="<?php echo $link; ?>"> <img src="<?php echo $img; ?>" alt="img" class="img-fluid" /> </a> </figure>
            <div class="card-body position-relative border-top ">
            
            <div class="row">
            <div class="col-sm-9">
              <div class="card-category mt-n2">
                <?php if(THEME_KEY == "cp"){ ?>
                <?php echo do_shortcode('[STORENAME]'); ?>
                <?php }else{ ?>
                <?php echo do_shortcode('[CATEGORY]'); ?>
                <?php } ?>
              </div>
              
              
              <h4 class="mt-1"><a href="<?php echo $link; ?>" class="text-dark"><?php echo $post->post_title; ?></a></h4>
              </div>
              <div class="col-sm-3 text-right">
              <a href="<?php echo $link; ?>" class="btn btn-system shadow-sm btn-md btn-block text-uppercase border-0"><?php echo __("Read More","premiumpress"); ?> </a>
              </div>
              </div>
            </div>
          </div>
          <?php }  ?>
          <?php }  ?>
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
	public static function js(){ global $CORE;
		ob_start();
		?>
<script> 
jQuery(window).bind("load", function() { 
		 
	jQuery(".listing1-carousel-6").owlCarousel({
        loop: false,
        margin: 20,
		autoHeight:true,
        nav: true,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,
        responsive: {
            0: {
                items: 1
            },
			600: {
                items: 1
            },
			1200: {
                items: 1
            },
            
        },
        
    }); 
	
	
	});		 
</script>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function css(){ global $CORE;
		ob_start();
		?>
<style>

.searchform label { font-size:12px; font-weight:bold;  margin-top:10px;}

.block-listings_n3 .owl-theme .owl-nav {
    margin-top: 10px;
    position: absolute;
    top: 40%;
	width: 100% !important;
	
    color: #222 !important;
	 font-size: 30px !important;
	 font-weight:bold;
}
.block-listings_n3 .owl-theme .owl-next { float:right; background: #fff !important;    width: 40px; }


.block-listings_n3 .owl-theme  .owl-prev { float:left; background: #fff !important;    width: 40px; }


.categories-list li {
    padding: 0;
    margin: 0;
    border-bottom: 1px solid #eee;
}
.categories-list li a {
    display: flex;
    align-items: center;
    padding: 10px;
}
.categories-list li .icon-wrap {
    padding-right: 10px;
    margin-right: 10px;
    border-right: 1px solid #eee;
    color: #aaa;
    font-size: 18px;
}
.categories-list li .cat-count {
    margin-left: auto;
    color: #aaa;
    margin-right: 5px;
}
.block-listings_n3 .new-search figure {  }
.block-listings_n3 .new-search figure img { width:100%; }
</style>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>
