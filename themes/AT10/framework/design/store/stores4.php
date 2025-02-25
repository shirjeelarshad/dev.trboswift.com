<?php
 
add_filter( 'ppt_blocks_args', 	array('block_stores4',  'data') );
add_action( 'stores4',  		array('block_stores4', 'output' ) );
add_action( 'stores4-css',  	array('block_stores4', 'css' ) );
add_action( 'stores4-js',  	array('block_stores4', 'js' ) );

class block_stores4 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['stores4'] = array(
			"name" 		=> "Style 4",
			"image"		=> "stores4.jpg",
			"cat"		=> "store",
			"desc" 		=> "", 
			"order" 	=> 4, 
			
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					"section_padding" => "section-80",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "Featured Stores",					 
					"subtitle"			=>  "",					
					"desc" 				=> "Over 1,000 stores and coupons online right now - find the best deals and offers today!",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
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
					"btn_style" 		=> "4",				
					"btn_size" 			=> "btn-md",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("All Stores","premiumpress"),
					"btn_link" 			=> _ppt(array('links','stores')),
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-2",
				 
					
					 
			), 		
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("stores4", "store", $settings ) );
	 
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
	
	?><section id="stores4-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
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
        
        
        <div class="card">
        <div class="card-body">
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
        
        <div class="card-search card-zoom card-top-image border-0 card-coupon mb-0">
		  <?php /************ MIAN IMAGE ***/ ?>
          <figure style="border:1px solid #ddd;" class="p-0"> <a href="<?php echo $link; ?>">
          
          <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $term->name; ?>">
            <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
            </a> </figure>
          <?php /***************** */ ?>
          <div class="card-body  p-0 py-3 text-center small text-uppercase font-weight-bold opacity-5"><a href="<?php echo $link; ?>">
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
		   
		 ?></a>
          </div>
        </div>
        <?php $i++; } ?> 
         </div></div>       
        </div>
      </div>
    </div>
  </div>
</section>
<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#stores4-carousel-<?php echo $randomID; ?> .owl-carousel").owlCarousel({
        loop: false,
        margin: 10,
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
                items: 5
            }
        },        
    }); 
	
	owl.owlCarousel();
 
  jQuery("#stores4-carousel-<?php echo $randomID; ?> .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#stores4-carousel-<?php echo $randomID; ?> .prev").click(function(){
    owl.trigger('prev.owl.carousel');
  })
	
	
	});		 
</script><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
.block-stores4 .owl-theme .owl-nav {
    margin-top: 0px;
    position: absolute;
    top: 30%;
	width: 100% !important;
	
    color: #222 !important;
	 font-size: 30px !important;
	 font-weight:bold;
}
.block-stores4 .owl-theme .owl-next { float:right; background: #666 !important; color:#fff !important;    width: 40px; margin-right:-30px; }


.block-stores4 .owl-theme  .owl-prev { float:left; background: #666 !important;  color:#fff !important;   width: 40px; margin-left:-30px; }

</style>
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