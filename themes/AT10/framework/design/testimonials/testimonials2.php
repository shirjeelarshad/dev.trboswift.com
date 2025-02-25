<?php
 
add_filter( 'ppt_blocks_args', 	array('block_testimonials2',  'data') );
add_action( 'testimonials2',  		array('block_testimonials2', 'output' ) );
add_action( 'testimonials2-css',  	array('block_testimonials2', 'css' ) );
add_action( 'testimonials2-js',  	array('block_testimonials2', 'js' ) );

class block_testimonials2 {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['testimonials2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "testimonials2.jpg",
			"cat"	=> "testimonials",
			"desc" 	=> "", 
			"data" 	=> array( ),	
			"order" => 2		
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("testimonials2", "testimonials", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		 
		
		$settings['title_pos'] = "center";
		 
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row">
      <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
    </div>
    <div class="row">
      <?php $i=1; while($i < 9){ ?>
      <div class="col-xl-3 col-lg-4 col-md-6 mt-4">
        <div class="card text-center border-0 shadow-sm">
          <div class="card-body">
            <div class="mb-4 col-5 mx-auto"> <img data-src="<?php echo $settings['author_image'.$i]; ?>" class="rounded-circle img-fluid lazy" alt="<?php echo $settings['author_name'.$i]; ?>"> </div>
            <p class="text-muted opacity-8 text-muted">&quot;<?php echo $settings['author_quote'.$i]; ?>&quot;</p>
            <div class="text-center mt-3">
              <h6><?php echo $settings['author_name'.$i]; ?></h6>
              <p class="small text-muted opacity-5"><?php echo $settings['author_job'.$i]; ?></p>
            </div>
          </div>
        </div>
      </div>
      <?php $i++; } ?>
    </div>
  </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
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
