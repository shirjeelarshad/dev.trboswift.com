<?php
 
add_filter( 'ppt_blocks_args', 	array('block_stores1',  'data') );
add_action( 'stores1',  		array('block_stores1', 'output' ) );
add_action( 'stores1-css',  	array('block_stores1', 'css' ) );
add_action( 'stores1-js',  	array('block_stores1', 'js' ) );

class block_stores1 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['stores1'] = array(
			"name" 		=> "Style 1",
			"image"		=> "stores1.jpg",
			"cat"		=> "store",
			"desc" 		=> "", 
			"order" 	=> 2, 
			
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("stores1", "store", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
 $settings['card'] 			= "store";
 $settings['custom'] 		= "stores";
 $settings['datastring'] 	= "";
$settings['perrow'] 	= "5"; 
$randomID = rand();



	ob_start();
	
	?><section id="stores1-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="clearfix"></div>
        <?php if($settings['title_show'] == "yes"){ ?>
        <div class="d-flex mb-4 justify-content-between">
          <div>
            <h4 class="font-weight-bold mb-0 font-<?php echo $settings['title_font'];  ?> text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title']; ?></h4>
          </div>
          <div> <a class="btn bg-white btn-sm text-muted prev px-2 mt-2 border"><i class="fa fa-angle-left px-1" aria-hidden="true"></i></a> <a class="btn bg-white btn-sm text-muted next px-2 mt-2 border"><i class="fa fa-angle-right px-1" aria-hidden="true"></i></a> </div>
        </div>
        <?php } ?>
        <div  class="owl-carousel owl-theme"> 
		
        
        
        <?php
		
		$termdata = get_terms('store', 'orderby=term_order&hide_empty=0');
		$start		= 1;
		$per_page 	= 10;
		$total_merchants = count($termdata);		  
         
		$i=1; $sf = 0;
        foreach ($termdata as $term) { 
		
		if($i > 10){ continue;}
	 
		 // LINK 
         $link = get_term_link($term);		 
		 
		 // IMAGE
		 $img = do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]');
		
		?>
        
        <div class="card-search card-zoom card-top-image border-0 card-coupon">
		  <?php /************ MIAN IMAGE ***/ ?>
          <figure> <a href="<?php echo $link; ?>">
          
          <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $term->name; ?>">
            <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
            </a> </figure>
          <?php /***************** */ ?>
          <div class="card-body  p-0 py-3 text-center">
           <?php 
		   
		   
		   	if( defined('WLT_DEMOMODE') ){
		 
				$did = filter_var($term->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
				}
		
	 
		}else{
		
				echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
		
		}
		   
		 ?>
          </div>
        </div>
        <?php $i++; } ?> 
                
        </div>
      </div>
    </div>
  </div>
</section>
<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#stores1-carousel-<?php echo $randomID; ?> .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,
		 
        responsive: {
            0: {
                items: 2
            },
			 
            600: {
                items: 3
            },
			
			 
			
            1000: {
                items: 4
            }
        },        
    }); 
	
	owl.owlCarousel();
 
  jQuery("#stores1-carousel-<?php echo $randomID; ?> .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#stores1-carousel-<?php echo $randomID; ?> .prev").click(function(){
    owl.trigger('prev.owl.carousel');
  })
	
	
	});		 
</script><?php
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