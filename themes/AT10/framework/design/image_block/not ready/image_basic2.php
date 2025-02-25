<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic2',  'data') );
add_action( 'image_basic2',  		array('block_image_basic2', 'output' ) );
add_action( 'image_basic2-css',  	array('block_image_basic2', 'css' ) );

class block_image_basic2 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic2'] = array(
			"name" 	=> "Basic 2 ",
			"image"	=> "image_basic2.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array( ),			
						 
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic2", "image_block", $settings ) );
 		 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $i=1; while($i < 3){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(610,350));
			}
			$i++;
		 }
 
 
		ob_start();
		?>
<section class="image_block grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="container px-0">
<div class="row">

<?php $i=1; while($i < 3){ ?>
<div class="col-md-6">
<?php 
global $imagedata;

$imagedata = array(	
	 "effect" 				=> $settings['image_block'.$i.'_effect'],
	 "image_size" 			=> $settings['image_block'.$i.'_size'],
	 "image_txtcolor" 		=> $settings['image_block'.$i.'_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block'.$i.'_txtpos'],
	 "image" 				=> $settings['image_block'.$i],
	 "image_title" 			=> $settings['image_block'.$i.'_title'],
	 "image_subtitle" 		=> $settings['image_block'.$i.'_subtitle'],
	 "image_link" 			=> $settings['image_block'.$i.'_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?>  
</div>   
<?php $i++; } ?> 

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