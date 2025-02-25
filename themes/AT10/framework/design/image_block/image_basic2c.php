<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic2c',  'data') );
add_action( 'image_basic2c',  		array('block_image_basic2c', 'output' ) );
add_action( 'image_basic2c-css',  	array('block_image_basic2c', 'css' ) );

class block_image_basic2c {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic2c'] = array(
			"name" 	=> "Basic 2 (c)",
			"image"	=> "image_basic2c.jpg",
			"cat"	=> "image_block",
			"order"	=> 2,
			
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings, $image_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array();
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic2c", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(600,800), array(800,530) );
		 $i=1; while($i < 3){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }
		 
		 
		 $image_settings = $settings;
		 
 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="<?php echo $settings['section_w']; ?>">

<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>

<div class="row">

<div class="col-sm-4 pr-0">

  
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>

</div>

<div class="col-sm-8 mb-4">
<?php 

global $settings;
_ppt_template( 'framework/design/image_block/parts/i2' );  ?>

</div>
 
 
</div>

</div>
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