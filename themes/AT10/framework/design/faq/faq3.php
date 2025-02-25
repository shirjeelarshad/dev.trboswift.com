<?php
 
add_filter( 'ppt_blocks_args', 	array('block_faq3',  'data') );
add_action( 'faq3',  		array('block_faq3', 'output' ) );
add_action( 'faq3-css',  	array('block_faq3', 'css' ) );
add_action( 'faq3-js',  	array('block_faq3', 'js' ) );

class block_faq3 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['faq3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "faq3.jpg",
			"cat"	=> "faq",
			"order" => 3,
			"desc" 	=> "", 
			"data" 	=> array(),		
			
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "faq") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "faq") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc_small', "faq") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "mb-5",					
					
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("faq3", "faq", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 
	ob_start();
	
	?><section id="faq3" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-5">  
                    <div class="content-blk">
                    
                <?php  _ppt_template( 'framework/design/parts/title' ); ?>
                
                <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
                        
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="accordion">
                        <div class="accordion" id="faq3-accodian">
                            
                            
                            <?php $i=1; while($i < 7){ 
							
							if($i > 3 && $settings['faq'.$i.'_title'] == ""){ $i++; continue; }
							
							?>
                            <div class="card border">
                              <div class="card-header">
                              
                                <button class="btn btn-link <?php if($i != 1){ echo "collapsed"; }?>" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                                    <div class="collapseIcon">
                                        <span></span>
                                    </div>
                                    <?php if($settings['faq'.$i.'_title'] == ""){ ?>
                                    Example FAQ Title Here
                                    <?php }else{ ?>
                                    <?php echo $settings['faq'.$i.'_title']; ?>
                                    <?php } ?>
                                  </button>
                                  
                              </div>
                             </div> 
                              
                          
                              <div id="collapse<?php echo $i; ?>" class="collapse <?php if($i == 1){ echo "show"; }?>" aria-labelledby="heading<?php echo $i; ?>" data-parent="#faq3-accodian" style="">
                                <div class="card-body">
                                    
                                    <?php if($settings['faq'.$i.'_desc'] == ""){ ?>
                                     
                                    Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos. Mazim nemore singulis an ius, nullam ornatus nam ei. 
                                    Ut dicat euismod invidunt pro, ne his dolorum molestie reprehendunt, quo luptatum evertitur ex.
									<?php }else{ ?>
                                    
                                    <?php echo $settings['faq'.$i.'_desc']; ?>
                                    
                                    <?php } ?>
                                </div>
                              </div>
                            
                            <?php $i++; } ?>
                            
                             
 
                          </div>
                    </div>
                </div>
            </div>
        </div>

   </section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
  
#faq3 .accordion div#faq3-accodian{background:none;}
#faq3 .accordion div#faq3-accodian .card-header{background:none;border:none;border-radius:3px;padding:0;}
#faq3 .card{border:none;margin-bottom:15px;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link{text-decoration:none;color:#333;font-size:20px;font-weight:300;line-height:32px;position:relative;display:block;text-align:left;width:100%; padding:10px 50px;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link.collapsed{text-decoration:none;color:#333;font-size:20px;font-weight:300;line-height:32px;position:relative;display:block;text-align:left;width:100%;background:transparent;padding:10px 50px;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link .collapseIcon{display:block;position:absolute;left:25px;top:50%;transform:translate(-50%);}
#faq3 .accordion div#faq3-accodian button.btn.btn-link .collapseIcon span{display:block;width:15px;height:3px;background:#fff;position:relative;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link .collapseIcon span:after{position:absolute;content:"";width:15px;height:3px;background:#000;left:0px;top:0;transform:rotate(90deg);}
#faq3 .accordion div#faq3-accodian button.btn.btn-link.collapsed .collapseIcon span{display:block;width:15px;height:3px;background:#222;position:relative;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link.collapsed .collapseIcon span:after{position:absolute;content:"";width:15px;height:3px;background:#222;left:0px;top:0;transform:rotate(90deg);}
 
 
@media (min-width: 768px) and (max-width: 991px){
 
#faq3.last-blog .content-blk{margin-bottom:70px;}
}
@media only screen and (min-width: 320px) and (max-width: 767px){
 
#faq3.last-blog .content-blk{margin-bottom:70px;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link.collapsed{font-size:17px;}
#faq3 .accordion div#faq3-accodian button.btn.btn-link{font-size:17px;}
 
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