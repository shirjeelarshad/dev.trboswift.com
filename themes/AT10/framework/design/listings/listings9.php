<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings9',  'data') );
add_action( 'listings9',  		array('block_listings9', 'output' ) );
add_action( 'listings9-css',  	array('block_listings9', 'css' ) );
add_action( 'listings9-js',  	array('block_listings9', 'js' ) );

class block_listings9 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
  
		$a['listings9'] = array(
			"name" 	=> "Style 9 - sidebar",
			"image"	=> "listings9.jpg",
			"cat"	=> "listings",
			"order" 	=> 9,
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( "datastring" => "custom=new num=5" );  
	 
	   // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings9", "listings", $settings ) );
 		 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 	
	ob_start();
	
	$randomID = rand(0,9999);
	 
	?><section id="listing9-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
 
    <div class="col-md-9">
    
        <div class="block-header"><h3 class="block-header__title"><?php echo __("Newly Added","premiumpress"); ?></h3><div class="block-header__divider"></div></div>
        
        <?php
		
		//card_class="col-12"
		
		$settings['card'] = "list-xsmall";
		
        echo do_shortcode('[LISTINGS dataonly=1 nav=0   show=10 '.$settings['datastring'].' ]');  
        ?>
        
    </div>
    
    <div class="col-md-3">
    
    <div class="block-header"><h3 class="block-header__title"><?php echo __("Featured","premiumpress"); ?></h3><div class="block-header__divider"></div></div>
  
  <div  class="owl-carousel owl-theme">
    <?php 
	$settings['card'] = "blank";
	
	echo do_shortcode('[LISTINGS dataonly=1 nav=0  custom="featured"  show=1 card_class="col-12" ]');  ?>  
    </div>
    
    
<script> 
jQuery(document).ready(function(){ 
 	 
	var owl = jQuery("#listing9-carousel-<?php echo $randomID; ?> .owl-carousel").owlCarousel({
        loop: false,
        margin: 0,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        nav: false,
        dots: false,
		 
        responsive: {
            0: {
                items: 1
            },
			 
        },        
    }); 
	
	owl.owlCarousel();
	
	});		 
</script> 
          
            
         
      </div>
   </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
.block-header{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;margin-bottom:24px; font-size:28px;font-weight:700; }
.block-header__title{margin-bottom:0;font-size:20px;}
.block-header__divider{-ms-flex-positive:1;flex-grow:1;height:2px;background:#ebebeb;}
.block-header__title+.block-header__divider{margin-left:16px;}
@media (max-width:767px){
.block-header{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;}
}
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