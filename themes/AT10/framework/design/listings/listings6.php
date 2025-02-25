<?php
 
add_filter( 'ppt_blocks_args',  	array('block_listings6',  'data') );
add_action( 'listings6',  	array('block_listings6', 'output' ) );
add_action( 'listings6-css',  array('block_listings6', 'css' ) );
add_action( 'listings6-js',  	array('block_listings6', 'js' ) );

class block_listings6 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
	
		global $CORE;
  
		$a['listings6'] = array(
			"name" 	=> "Style 6",
			"image"	=> "listings6.jpg",
			"cat"	=> "listings",
			"order" => 6,
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( );
		  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings6", "listings", $settings ) );
 	  
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
      <div class="row d-flex flex-lg-row-reverse">
         <div class="col-md-4">
            <div class="card <?php if($settings['section_bg'] == "bg-white"){?>bg-light<?php }else{ ?>bg-white<?php } ?> rounded-0  mb-4 mb-md-0">
               <div class="card-body p-md-4 shadow-sm">
                  <?php _ppt_template( 'framework/design/parts/title' ); ?> 
                  <?php _ppt_template( 'framework/design/parts/search-list' ); ?>
               </div>
            </div>
         </div>
         <div class="col-md-8 hide-mobile">
            <div class="listing1-carousel-6 owl-carousel owl-theme">
               <?php 
			   
			   if(isset($_GET['ppt_live_preview'])){
		echo str_replace("new-search","new-search no-resize", str_replace("data-src","src",do_shortcode('[LISTINGS card="" dataonly=1 nav=0 small=1 carousel=1 '.$settings['datastring'].' ]'))); 
		}else{
		echo str_replace("new-search","new-search no-resize", str_replace("data-src","src",do_shortcode('[LISTINGS card="" dataonly=1 nav=0 small=1 carousel=1 '.$settings['datastring'].' ]'))); 		
		}
			    ?>  
            </div>
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
		?>
<script> 
jQuery(window).bind("load", function() { 
		 
	jQuery(".listing1-carousel-6").owlCarousel({
        loop: false,
        margin: 20,
		autoHeight:true,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        nav: true,
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

.block-listings6 .owl-theme .owl-nav {
    margin-top: 10px;
    position: absolute;
    top: 40%;
	width: 100% !important;
	
    color: #222 !important;
	 font-size: 30px !important;
	 font-weight:bold;
}
.block-listings6 .owl-theme .owl-next { float:right; background: #fff !important;    width: 40px; }


.block-listings6 .owl-theme  .owl-prev { float:left; background: #fff !important;    width: 40px; }

</style>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>