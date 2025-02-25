<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic2b',  'data') );
add_action( 'image_basic2b',  		array('block_image_basic2b', 'output' ) );
add_action( 'image_basic2b-css',  	array('block_image_basic2b', 'css' ) );

class block_image_basic2b {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic2b'] = array(
			"name" 	=> "Basic 2 (b)",
			"image"	=> "image_basic2b.jpg",
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
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic2b", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(800,590), array(400,600), array(1300,300) );
		 $i=1; while($i < 4){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }
		 
		 
		 $image_settings = $settings;
		 
 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="container">

<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>

<div class="row">

<div class="col-sm-8 pr-0">

<div class="col-12 pl-0">
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>
</div> 


</div>
 
 <div class="col-sm-4 hide-mobile">


    <div class="row">
        <div class="col-md-12 mb-4">
<?php 

global $settings;
_ppt_template( 'framework/design/image_block/parts/i2' );  ?>
        </div>
</div> </div>
  


</div></div>
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