<?php
 
add_filter( 'ppt_blocks_args', 	array('block_testimonials1',  'data') );
add_action( 'testimonials1',  		array('block_testimonials1', 'output' ) );
add_action( 'testimonials1-css',  	array('block_testimonials1', 'css' ) );
add_action( 'testimonials1-js',  	array('block_testimonials1', 'js' ) );

class block_testimonials1 {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['testimonials1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "testimonials1.jpg",
			"cat"	=> "testimonials",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" => 1,
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "no",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> "",					 
					"subtitle"			=> "",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "no",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> "",
					"btn_link" 			=> "",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> "",
					"btn2_link" 		=> "",
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array();  
	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("testimonials1", "testimonials", $settings ) ); 

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
        <div class="row">
   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
      </div>
            <div class="row justify-content-center">
            
                 <?php $i=1; while($i < 4){ ?>
                  
                <div class="col-6 col-md-4 <?php if($i == 3){ echo "hide-mobile"; } ?>">
                    <div class="testmonial-1 bg-white">
                        <div class="testmonial-1-author">
                            <img src="<?php if(isset($settings['author_image'.$i]) && strlen($settings['author_image'.$i]) > 1 ){ echo $settings['author_image'.$i]; }else{ ?>http://via.placeholder.com/80x80<?php } ?>" alt="">
                        </div>
                        <div class="testmonial-1-dec">
                            <p class="text-dark opacity-5">"
                            
                              <?php if($settings['author_quote'.$i] == ""){ ?>
                                     
                                   Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem
                                animal assentior nam.
									<?php }else{ ?>
                                    
                                    <?php echo $settings['author_quote'.$i]; ?>
                                    
                                    <?php } ?>
                            
                            "</p>
                        </div>
                        <div class="testmonial-8-ratings">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                        </div>
                        <div class="testmonial-3-author text-dark">
                            <h4><?php if(isset($settings['author_name'.$i]) && strlen($settings['author_name'.$i]) > 1 ){ echo $settings['author_name'.$i]; }else{ ?>John Doe<?php } ?></h4>
                            <p><?php if(isset($settings['author_job'.$i]) && strlen($settings['author_job'.$i]) > 1 ){ echo $settings['author_job'.$i]; }else{ ?>PremiumPress<?php } ?></p>
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
.testmonial-1{
    border: 1px solid #eeeeee;
    padding: 30px;
    text-align: center;
}
.testmonial-1-author{
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto;
    margin-bottom: 30px;
}
.testmonial-1-author img {
    width: 100%;
    height: auto;
}
.testmonial-1-author h4{
    margin: 0;
}
.testmonial-1-author p{
    color: rgb(153, 153, 153);
    font-weight: 300;
    margin-bottom: 0px;
    font-size: 12px;
}
.testmonial-1-dec{
    margin-bottom: 8px;
}
.testmonial-1-dec p{
    margin-bottom: 0;
}
.testmonial-1-ratings i{
    font-size: 18px;
    color: #0076ff;
}
.testmonial-1 .testmonial-8-ratings{
    margin-bottom: 18px;
}
.testmonial-1 .testmonial-3-author{
    margin-bottom: 0;
}
@media (max-width: 575.98px) { 
	.testmonial-1 {
		 
		padding: 10px !important;
	 
	}
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