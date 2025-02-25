<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic4',  'data') );
add_action( 'image_basic4',  		array('block_image_basic4', 'output' ) );
add_action( 'image_basic4-css',  	array('block_image_basic4', 'css' ) );

class block_image_basic4 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic4'] = array(
			"name" 	=> "Basic 4",
			"image"	=> "image_basic4.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array(),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
 	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic4", "image_block", $settings ) );
 		
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
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(600,800));
			}
			$i++;
		 }	  
 		  
		 
		ob_start();
		?><section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        
<?php _ppt_template( 'framework/design/parts/section-before' ); ?>

        
<div class="<?php echo $settings['section_w']; ?> z-1">
<div class="row">

   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>

<?php $i=1; while($i < 5){ ?>
<div class="col-md-3 col-6 mb-4">
<?php _ppt_template( 'framework/design/image_block/parts/i'.$i );  ?>   
</div>   
<?php $i++; } ?>

</div></div>
<?php _ppt_template( 'framework/design/parts/section-after' ); ?>

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