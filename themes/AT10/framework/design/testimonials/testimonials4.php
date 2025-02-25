<?php
 
add_filter( 'ppt_blocks_args', 	array('block_testimonials4',  'data') );
add_action( 'testimonials4',  		array('block_testimonials4', 'output' ) );
add_action( 'testimonials4-css',  	array('block_testimonials4', 'css' ) );
add_action( 'testimonials4-js',  	array('block_testimonials4', 'js' ) );

class block_testimonials4 {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['testimonials4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "testimonials4.jpg",
			"cat"	=> "testimonials",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" => 4			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("testimonials4", "testimonials", $settings ) ); 
 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	ob_start();
	?>
    <section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="testmonial-7">
                        <div class="testmonial-7-content">
                            <div class="quote-icon justify-content-between">
                                <span class="bg-primary"></span>
                                <span class="bg-primary"></span>
                            </div>
                            <p class="bg-white pt-3">
                            <?php echo $settings['author_quote1']; ?></p>
                            <div class="testmonial-3-author">
                                <h4><?php if(isset($settings['author_name1']) && strlen($settings['author_name1']) > 1 ){ echo $settings['author_name1']; }else{ ?>Amelia Edwards<?php } ?></h4>
                                <p><?php if(isset($settings['author_job1']) && strlen($settings['author_job1']) > 1 ){ echo $settings['author_job1']; }else{ ?>Google Inc<?php } ?></p>
                            </div>
                        </div>
                        <div class="testmonial-7-img">
                            <img data-src="<?php if(isset($settings['author_image1']) && strlen($settings['author_image1']) > 1 ){ echo $settings['author_image1']; }else{ echo "http://via.placeholder.com/400x400"; } ?>" alt="<?php echo $settings['author_name1']; ?>" class="lazy img-fluid">
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
		public static function css(){
		ob_start();
		?>
<style>
.testmonial-7{
    padding-left: 585px;
    position: relative;
}
.testmonial-7-content{
    position: absolute;
    left: 0;
    width: 70%;
    top: 50%;
    transform: translateY(-50%);
}
.testmonial-7-content .testmonial-3-author{
    margin-bottom: 0;
}
.quote-icon {
    width: 55px;
    height: 40px;
    display: flex;
    margin-bottom: 58px;
    margin-left: 25px;
}
.quote-icon span{
    width: 20px;
    height: 100%;
    background-color: #0076ff;
}
.testmonial-7-content > p {
    font-size: 24px;
    color: #000;
    font-weight: 700;
    margin-bottom: 45px;
}
.testmonial-7-img img{
    width: 100%;
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