<?php
 
add_filter( 'ppt_blocks_args', 	array('block_faq4',  'data') );
add_action( 'faq4',  		array('block_faq4', 'output' ) );
add_action( 'faq4-css',  	array('block_faq4', 'css' ) );
add_action( 'faq4-js',  	array('block_faq4', 'js' ) );

class block_faq4 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['faq4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "faq4.jpg",
			"cat"	=> "faq",
			"order" => 4,
			"desc" 	=> "", 
			"data" 	=> array(),		
			
			
			"defaults" => array(
					
					// TEXT
					
					"section_padding" => "section-80",
					"section_bg"	=>	"bg-light",	
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> "Why Choose Us",					 
					"subtitle"			=> "Here's why lots of people choose our website.",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "mb-5",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "opacity-5",
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
					
					"image_faq" 		=> DEMO_IMG_PATH."/innerpages/2.jpg", //$CORE->LAYOUT("get_placeholder",array(1000,550))
					
					"faq1_title" => "Amazing Features",
					"faq2_title" => "SEO Friendly Design",
					"faq3_title" => "Easy To Customize",
					 
			),
				
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array();  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("faq4", "faq", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		}	 
		 
		/* DEFAULTS */
		if($settings['title'] == ""){		
			$default_data = $CORE->LAYOUT("get_block_defaults", "faq4");
		 	foreach($default_data as $k => $d){		 
				$settings[$k] = $default_data[$k];				
			}			
		}
	 
	ob_start();
	
	?>
    
    
    
    <section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>" id="faq4">
    <div class="container">
        <div class="row">
        
        
        
        
             <div class="container">
                <div class="row y-middle d-flex flex-lg-row-reverse">    
               
                   
                     <div class="col-lg-5 text-center m-b-md wow fadeInRight hide-mobile hide-ipad"> 
                        <img data-src="<?php echo $settings['image_faq']; ?>" class="dash-right lazy" alt="faq"> 
                    </div>
                    
                      <div class="col-lg-7 align-middle text-left pr-lg-5">
                    
                                    
               <?php  _ppt_template( 'framework/design/parts/title' ); ?>
               <?php  _ppt_template( 'framework/design/parts/btn' ); ?>     
                    
               
              <div class="mt-5">
        <?php $i=1; while($i < 7){ 
							
							if($i > 3 && $settings['faq'.$i.'_title'] == ""){ $i++; continue; }
 

?>
                            
                        
                                <div class="mb-4 clearfix w-100 btn-block">
                                
                                <div class="numtxt float-left mr-5">0<?php echo $i; ?></div>
                                 
                                <h4><?php if($settings['faq'.$i.'_title'] == ""){ ?>
                                    Reason <?php echo $i; ?>
                                    <?php }else{ ?>
                                    <?php echo __($settings['faq'.$i.'_title'],"premiumpress");; ?>
                                    <?php } ?></h4>
                                    
                                    
                                    <p class="opacity-5">
                                    <?php if($settings['faq'.$i.'_desc'] == ""){ ?>
                                     
                                    Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos. Mazim nemore singulis an ius, nullam ornatus nam ei. 
									<?php }else{ ?>
                                    
                                    <?php echo __($settings['faq'.$i.'_desc'],"premiumpress"); ?>
                                    
                                    <?php } ?>
                                    
                                    </p>
                                    
                                </div>
                                
                                
                            <?php $i++; } ?>
                        
                        
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
  
 
 .numtxt {
    font-weight: 700;
    font-style: italic;
    font-family: Lora, serif;
     opacity:0.8;
    font-size: 60px;
    line-height: 1;
    letter-spacing: 1px;
	padding-bottom:80px;
	
}
 @media (max-width: 575.98px){
.numtxt {
   font-size: 40px !important;
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