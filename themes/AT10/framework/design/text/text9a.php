<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text9a',  'data') );
add_action( 'text9a',  		array('block_text9a', 'output' ) );
add_action( 'text9a-css',  	array('block_text9a', 'css' ) );
add_action( 'text9a-js',  	array('block_text9a', 'js' ) );

class block_text9a {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text9a'] = array(
			"name" 	=> "Style 9a",
			"image"	=> "text9a.jpg",
			"order" => 9,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
					"section_padding" => "section-60",
					"section_bg"	=>	"bg-light",	
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "text") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "text") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
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
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("Search Website","premiumpress"),
					"btn_link" 			=> home_url()."/?s=",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "yes",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> __("Join Now!","premiumpress"),
					"btn2_link" 		=> wp_login_url(),
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					
					 
			),
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
	$settings = array( );  
	  
	// ADD ON SYSTEM DEFAULTS
	$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text9a", "text", $settings ) ); 
  
	// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
	if(is_array($new_settings)){
		foreach($settings as $h => $j){
			if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
			}
		}
	} 
	
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array(1000,550));
		}
	 
		
		 
		
	 
	ob_start();
	?>
<section class="p-y-lg bg-edit content-dashboard content-align-md <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
            
            <div class="container">
                <div class="row y-middle d-flex flex-lg-row-reverse">    
               
                   
                     <div class="col-lg-7 text-center m-b-md wow fadeInRight"> 
                        <img data-src="<?php echo $settings['text_image1']; ?>" class="dash-right lazy" alt=""> 
                    </div>
                    
                      <div class="col-lg-5 align-middle text-center text-lg-left pb-5 pr-lg-5">
                    
                        <?php  _ppt_template( 'framework/design/parts/title' ); ?>
                        
                        <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
                        
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

.dash-right {
    margin-right: -400px;
}
@media only screen and (max-width : 1199px) {
	.dash-right {
		margin-right: -500px;
	}
}
@media only screen and (max-width : 991px) {
  .dash-right {
        margin-right: 0;
		width:100%;
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