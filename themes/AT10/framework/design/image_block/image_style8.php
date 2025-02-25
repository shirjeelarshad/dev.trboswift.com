<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style8',  'data') );
add_action( 'image_style8',  		array('block_image_style8', 'output' ) );
add_action( 'image_style8-css',  	array('block_image_style8', 'css' ) );

class block_image_style8 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style8'] = array(
			"name" 	=> "Style 8",
			"image"	=> "image_style8.jpg",
			"cat"	=> "image_block",
			"order" => 8,
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style8", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
 
		 // DEFAULTS
		 $sd = array( '', array(1000,500), array(1000,1000), array(1000,1000), array(1000,1000), array(1000,1000)  );
		 $i=1; while($i < 5){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }		
		
		global $imagedata;
 
		ob_start();
		?><section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
<div class="container">
<div class="row">

<div class="col-md-6 pr-0">

    <div class="col-12">
 
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?> 
    </div>


    <div class="col-12 mt-4">
    <div class="row">
    <div class="col-md-6">
<?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?> 
    </div>
     <div class="col-md-6">
<?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?> 
    </div>   
    </div>
    </div>

</div>
 
 <div class="col-md-6">

<?php _ppt_template( 'framework/design/image_block/parts/i4' );  ?> 

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