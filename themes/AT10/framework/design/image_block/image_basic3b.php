<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic3b',  'data') );
add_action( 'image_basic3b',  		array('block_image_basic3b', 'output' ) );
add_action( 'image_basic3b-css',  	array('block_image_basic3b', 'css' ) );

class block_image_basic3b {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic3b'] = array(
			"name" 	=> "Basic 3 (b)",
			"image"	=> "image_basic3.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 3,
			"duplicate" => 1,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic3b", "image_block", $settings ) );
 		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $sd = array( '', array(670,680), array(670,325), array(670,325) );
		 $i=1; while($i < 4){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }	 
 
		ob_start();
		?>
        
<section class="image_block grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="<?php echo $settings['section_w']; ?> <?php if($settings['section_w'] == "container-fluid"){ ?>px-0<?php } ?>">

<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>

<div class="row ">
 
                 
<div class="col-md-6 mb-4 mb-mb-0">

<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>

</div>

<div class="col-md-6">

<div class="row no-md-gutters">

<div class="col-12 mb-4">
<?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?>
</div>

<div class="col-12">
<?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?>
</div>

</div>

</div>
  

</div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
	
		return "";	
	
	}	
	
}

?>