<?php
 
add_filter( 'ppt_blocks_args', 	array('block_blog1',  'data') );
add_action( 'blog1',  		array('block_blog1', 'output' ) );
add_action( 'blog1-css',  	array('block_blog1', 'css' ) );
add_action( 'blog1-js',  	array('block_blog1', 'js' ) );

class block_blog1 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['blog1'] = array(
			"name" 	=> "Blog 1",
			"image"	=> "blog1.jpg",
			"cat"	=> "blog",
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "blog") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "blog") ),					
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
	
	} public static function output(){ global $CORE, $wpdb, $new_settings, $settings;
 		
		$settings = array();  
	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("blog1", "blog", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 	
		
	$args = array(
	'post_type' 		=> 'post',
	'posts_per_page' 	=> 8, 
	'paged' 			=> 1,
	'orderby' 			=> 'date'
	);
	
	$wp_query = new WP_Query($args); 
	$tt = $wpdb->get_results($wp_query->request, OBJECT);

 
	ob_start();
	 
	?>  
<section id="blog1" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
      <div class="row">
   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
         <div class="col-12">
            <div class="blog1-carousel owl-carousel owl-theme">
               <?php
                  if(!empty($tt)){
                  foreach($tt as $p){
                  
                  global $post;
                  
                  $post = get_post($p->ID);
				  
				   $day 	= date("d", strtotime(get_the_date('Y-m-d',$post->ID)));
				   $month 	= date("M", strtotime(get_the_date('Y-m-d',$post->ID)));
				   $year 	= date("Y", strtotime(get_the_date('Y-m-d',$post->ID)));

                  
                  ?>
               <article class="card card-top-image" style="background: rgba(255, 255, 255, 0.12);

backdrop-filter: blur(50px); border: 0px solid #00000000;">
               
               <figure>
							 
							<a href="<?php echo get_permalink($post->ID); ?>">
                            
                            <img style="height:215px;" src="<?php echo do_shortcode('[IMAGE pathonly=1]'); ?>" alt="<?php echo strip_tags(do_shortcode('[TITLE]')); ?>" class="img-fluid">
                            
                            <div class="read_more"><span><?php echo __("Read More","premiumpress"); ?></span></div></a>
							 
						</figure>
               
               
              
                  <div class="card-body">
                  
                     <a href="<?php echo get_permalink($post->ID); ?>" >
                        <h5 class="text-secondary font-weight-bold h6" ><?php echo do_shortcode('[TITLE]'); ?></h5>
                     </a>
                   
                        <?php /*<div class="my-3"><?php the_category(','); ?> </div>*/ ?>
                  
                  <p class="card-text mb-0 mb-lg-4 text-secondary small"> <?php echo do_shortcode('[EXCERPT limit=90]'); ?>...</p>
                  
                  <?php /*  <hr />
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="post-meta">
                        <a class="text-dark" href="<?php echo get_permalink($post->ID); ?>">
                        <i class="fal fa-comments mr-2"></i><?php echo $post->comment_count; ?></a>
                     </div>
                     <span class="text-italic"> <i class="fal fa-calendar"></i> <?php echo $month; ?> <?php echo $day ; ?></span>
                  </div>
			*/	  ?>
            
         
            </div>
            </article>
            <?php
               }} ?>
            <?php wp_reset_query(); ?>     
         </div>
      </div>
   </div>
   </div>
</section> 


<script> 
jQuery(document).ready(function(){ 
		 
	jQuery(".blog1-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        },
        
    }); 
	
	
	});		 
</script> 

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
		public static function css(){
		return "";
		ob_start();
		?>

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