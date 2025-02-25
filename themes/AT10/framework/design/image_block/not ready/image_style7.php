<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style7',  'data') );
add_action( 'image_style7',  		array('block_image_style7', 'output' ) );
add_action( 'image_style7-css',  	array('block_image_style7', 'css' ) );

class block_image_style7 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style7'] = array(
			"name" 	=> "Style 7",
			"image"	=> "image_style7.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style7", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( );
		 $i=1; while($i < 5){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", array(800,600) );
			}
			$i++;
		 }		
		
		global $imagedata;
 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="<?php echo $settings['section_w']; ?>">
<div class="row">
<?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12"> 
         <?php _ppt_template('framework/design/titles/title-'.$settings['title_style']);  ?>
      </div>
      <?php } ?>
      
<div class="listing1-carousel-1 owl-carousel owl-theme">
<?php $i=1; while($i < 7){ ?>
 
<?php _ppt_template( 'framework/design/image_block/parts/i'.$i );  ?> 
 
<?php $i++; } ?>
</div>  
</div></div>
<script> 
jQuery(document).ready(function(){ 
		 
	jQuery(".listing1-carousel-1").owlCarousel({
        loop: false,
        margin: 0,
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
</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
	
		ob_start();
		?>
        
  
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>