<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style5',  'data') );
add_action( 'image_style5',  		array('block_image_style5', 'output' ) );
add_action( 'image_style5-css',  	array('block_image_style5', 'css' ) );

class block_image_style5 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "image_style5.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 25,
			"data" 	=> array( ),
			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style5", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(300,300), array(300,300), array(625,620), array(300,300), array(300,300) );
		 $i=1; while($i < 6){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }		
		
		global $imagedata;
 
		ob_start();
		?><section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
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
      <div class="col-lg-3 col-md-12">
        <div class="row">
          <div class="col-lg-12 col-sm-6 mb-4">
            <?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>
          </div>
          <div class="col-lg-12 col-sm-6">
            <?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 mb-sm-4 mb-lg-0">
        <?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?>
      </div>
      <div class="col-lg-3 col-md-12">
        <div class="row">
          <div class="col-lg-12 col-sm-6 sm-4 mb-4">
            <?php _ppt_template( 'framework/design/image_block/parts/i4' );  ?>
          </div>
          <div class="col-lg-12 col-sm-6">
            <?php _ppt_template( 'framework/design/image_block/parts/i5' );  ?>
          </div>
        </div>
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
	
		return "";
		ob_start();		 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>