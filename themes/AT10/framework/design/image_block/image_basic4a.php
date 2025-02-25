<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic4a',  'data') );
add_action( 'image_basic4a',  		array('block_image_basic4a', 'output' ) );
add_action( 'image_basic4a-css',  	array('block_image_basic4a', 'css' ) );

class block_image_basic4a {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic4a'] = array(
			"name" 	=> "Basic 4 (a)",
			"image"	=> "image_basic4a.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic4a", "image_block", $settings ) ); 
 		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $i=1; while($i < 5){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(600,300));
			}
			$i++;
		 }
 	  
	 
 
		ob_start();
		?>
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="<?php echo $settings['section_w']; ?>">
<div class="row">
 
    
<?php $i=1; while($i < 5){ ?>
<div class="col-md-6 mb-4">
<?php _ppt_template( 'framework/design/image_block/parts/i'.$i );  ?>     
</div>   
<?php $i++; } ?>
  


</div></div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function js(){ global $CORE;
		return "";
		ob_start();
		?> 
        
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function css(){ global $CORE;
		return "";
		ob_start();
		?> 
        
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>