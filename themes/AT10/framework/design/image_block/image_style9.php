<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style9',  'data') );
add_action( 'image_style9',  		array('block_image_style9', 'output' ) );
add_action( 'image_style9-css',  	array('block_image_style9', 'css' ) );

class block_image_style9 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style9'] = array(
			"name" 	=> "Style 9",
			"image"	=> "image_style9.jpg",
			"cat"	=> "image_block",
			"order" => 29,
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array();
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style9", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(1000,610), array(1000,600), array(1000,600) );
		 $i=1; while($i < 4){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }	
		 
		 
		global $imagedata; 
 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="<?php echo $settings['section_w']; ?>">
<div class="row">

<div class="col-md-8 pr-0">

    <div class="col-12 pl-0 mb-4 mb-md-0">
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?> 
    </div>  

</div>
 
 <div class="col-md-4">


    <div class="row">
        <div class="col-md-12 mb-4">
<?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?>
        </div>
         <div class="col-md-12">
<?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?>
        </div>   
    </div>
 
 
</div>


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