<?php
 
add_filter( 'ppt_blocks_args', 	array('block_testimonials3a',  'data') );
add_action( 'testimonials3a',  		array('block_testimonials3a', 'output' ) );
add_action( 'testimonials3a-css',  	array('block_testimonials3a', 'css' ) );
add_action( 'testimonials3a-js',  	array('block_testimonials3a', 'js' ) );

class block_testimonials3a {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['testimonials3a'] = array(
			"name" 	=> "Style 3 (a)",
			"image"	=> "testimonials3a.jpg",
			"cat"	=> "testimonials",
			"desc" 	=> "", 
			"data" 	=> array( ),	
			"order" => 3		
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array();  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("testimonials3a", "testimonials", $settings ) ); 

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
	?>

<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <?php if($settings['title_show'] == "yes"){ ?>
    <div class="row mb-4">
      <div class="col-12">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
        <?php _ppt_template( 'framework/design/parts/btn' ); ?>
      </div>
    </div>
    <?php } ?>
    <div class="row justify-content-center">
      <?php $i=1; while($i < 4){ ?>
      <div class="col-lg-4 col-sm-12 mb-0">
        <div class="testomonial-2">
          <div class="testomonial-2-img"> <img data-src="<?php if(isset($settings['author_image'.$i]) && strlen($settings['author_image'.$i]) > 1 ){ echo $settings['author_image'.$i]; }else{ ?>http://via.placeholder.com/100x100<?php } ?>" alt="testimonial" class="lazy img-fluid"> </div>
          <p class="testomonial-2-des text-muted small"> "
            <?php if($settings['author_quote'.$i] == ""){ ?>
            Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem
            animal assentior nam.
            <?php }else{ ?>
            <?php echo $settings['author_quote'.$i]; ?>
            <?php } ?>
            " </p>
          <div class="testmonial-3-author">
            <h6 class="float-left">
              <?php if(isset($settings['author_name'.$i]) && strlen($settings['author_name'.$i]) > 1 ){ echo $settings['author_name'.$i]; }else{ ?>
              John Doe
              <?php } ?>
            </h6>
            <div class="float-right rating-small"> <i class="fa fa-star text-warning"></i> <i class="fa fa-star text-warning"></i> <i class="fa fa-star text-warning"></i> <i class="fa fa-star text-warning"></i> <i class="fa fa-star text-warning"></i> </div>
          </div>
        </div>
      </div>
      <?php $i++; } ?>
    </div>
  </div>
</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
.testomonial-2{
    padding-left: 80px;
    position: relative;
    padding-top: 10px;
}
.testomonial-2-img{
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    position: absolute;
    left: 0;
    top: 0;
}
.testomonial-2-img img{
    width: 100%;
    height: auto;
}

</style>
<?php	
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
