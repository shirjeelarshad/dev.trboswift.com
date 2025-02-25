<?php
 
add_filter( 'ppt_blocks_args',  	array('block_slider_inline',  'data') );
add_action( 'slider_inline',  	array('block_slider_inline', 'output' ) );
add_action( 'slider_inline-css',  array('block_slider_inline', 'css' ) );
add_action( 'slider_inline-js',  	array('block_slider_inline', 'js' ) );

class block_slider_inline {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['slider_inline'] = array(
			"name" 	=> "Inline Slider",
			"image"	=> "slider_inline.jpg",
			"cat"	=> "slider",
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( );
		  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("slider_inline", "slider", $settings ) );
 	  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		  
		
		ob_start();
		?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   
      <div class="row">     
     
         <div class="col-12">         
             <?php 
             $settings['sliderID'] = "hero_inline";
             _ppt_template( 'framework/design/slider/parts/hero-carousel' ); ?>      
        </div>       
 
             
      </div>
   </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function js(){ global $CORE;
	
		ob_start();
		?><script>
		
 
jQuery(document).ready(function(){ 
 
 
    jQuery('#slider_inline').on('slide.bs.carousel', function () {
               jQuery(".single-slide-item h1").removeClass('flipInX animated').hide();
                jQuery(".single-slide-item p").removeClass('fadeInUp animated delay-03').hide();
                jQuery(".single-slide-item .search-btn").removeClass('zoomIn animated delay-06').hide();
    });
   jQuery('#slider_inline').on('slid.bs.carousel', function () {
                jQuery(".single-slide-item h1").addClass('flipInX animated').show();
                jQuery(".single-slide-item p").addClass('fadeInUp animated delay-03').show();
                jQuery(".single-slide-item .search-btn").addClass('zoomIn animated delay-06').show();
          });
	
 
});
</script>
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function css(){ global $CORE;
	return "";
		ob_start();
		?> <?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>