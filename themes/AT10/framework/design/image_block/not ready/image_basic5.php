<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic5',  'data') );
add_action( 'image_basic5',  		array('block_image_basic5', 'output' ) );
add_action( 'image_basic5-css',  	array('block_image_basic5', 'css' ) );

class block_image_basic5 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic5'] = array(
			"name" 	=> "Basic 5",
			"image"	=> "image_basic5.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array(),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
 	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic5", "image_block", $settings ) );
 		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $i=1; while($i < 6){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(600,800));
			}
			$i++;
		 }	  
 		  
		  
		  // TITLE STYLE
		if($settings["title_style"] == ""){
			$settings["title_style"] = "center";
		}
		 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="container px-0">
<div class="row">

   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>

<div class="col-12">

<div class="image_basic5 owl-carousel owl-theme">
<?php $i=1; while($i < 6){ ?>
 

<?php 
global $imagedata;

$imagedata = array(	
	 "image" 				=> $settings['image_block'.$i],
	 "effect" 				=> $settings['image_block'.$i.'_effect'],
	 "image_txtcolor" 		=> $settings['image_block'.$i.'_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block'.$i.'_txtpos'],
	 "image_title" 			=> $settings['image_block'.$i.'_title'],
	 "image_subtitle" 		=> $settings['image_block'.$i.'_subtitle'],
	 "image_link" 			=> $settings['image_block'.$i.'_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?>  
 
<?php $i++; } ?>
</div> </div>

</div></div>

<script> 
jQuery(document).ready(function(){ 
		 
	jQuery(".image_basic5").owlCarousel({
        loop:false,
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
                items: 5
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
        
        <style>
		 
		</style>
        
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>