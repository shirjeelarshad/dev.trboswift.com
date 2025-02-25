<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings4',  'data') );
add_action( 'listings4',  		array('block_listings4', 'output' ) );
add_action( 'listings4-css',  	array('block_listings4', 'css' ) );
add_action( 'listings4-js',  	array('block_listings4', 'js' ) );

class block_listings4 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
  
		$a['listings4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "listings4.jpg",
			"cat"	=> "listings",
			"order" => 4,
			"desc" 	=> "", 
			"duplicate" => 1,
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h4",
					"title_pos" 		=> "",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "listings") ),					 
					"subtitle"			=> "",					
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
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( "datastring" => "custom=new num=12" );  
	 
	   // ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings4", "listings", $settings ) );
 		 
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
	 
	?>
 
    
<section id="listing3-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
      
      <div class="col-12">
         <div class="clearfix"></div>
         
         
         
<div class="d-flex mb-4 justify-content-between">
<div>
<?php if($settings['title_show'] == "yes"){ ?>
  <?php _ppt_template( 'framework/design/parts/title' ); ?>
<?php } ?>
</div>
    <div>
      <a class="btn bg-white btn-sm text-muted prev px-2 mt-2 border"><i class="fa fa-angle-left px-1" aria-hidden="true"></i></a>
      <a class="btn bg-white btn-sm text-muted next px-2 mt-2 border"><i class="fa fa-angle-right px-1" aria-hidden="true"></i></a>
    </div>
</div>
         
 

         <div  class="owl-carousel owl-theme">
            <?php echo do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 '.$settings['datastring'].' ]');  ?>  
         </div>
      </div>
   </div>
</section>

<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#listing3-carousel-<?php echo $randomID; ?> .owl-carousel").owlCarousel({
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
                items: 2
            },
			800: {
                items: 3
            },
            1000: {
                items: 4
            }
        },        
    }); 
	
	owl.owlCarousel();
 
  jQuery("#listing3-carousel-<?php echo $randomID; ?> .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#listing3-carousel-<?php echo $randomID; ?> .prev").click(function(){
    owl.trigger('prev.owl.carousel');
  })
	
	
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