<?php
 
add_filter( 'ppt_blocks_args', 	array('block_video1',  'data') );
add_action( 'video1',  		array('block_video1', 'output' ) );
add_action( 'video1-css',  	array('block_video1', 'css' ) );
add_action( 'video1-js',  	array('block_video1', 'js' ) );

class block_video1 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['video1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "video1.jpg",
			"cat"	=> "video",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "video") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "video") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "video") ),
					 	
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("video1", "video", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array(800,600));		
		}
		
  
	 
	ob_start();
	
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
      <div class="row d-flex flex-lg-row-reverse y-middle">        
         <div class="col-lg-6 text-center text-lg-left ">
            
            
            <?php  _ppt_template( 'framework/design/parts/title' ); ?>
            
            <?php _ppt_template( 'framework/design/parts/btn' ); ?>
             
         </div>
         
          <div class="col-lg-6 position-relative pr-lg-5">
           <div class="video_play-btn bg-primary text-center">
            <a href="<?php echo $settings['video_link']; ?>" class="popup-yt"><i class="fas fa-play"></i></a>
           </div>
                                        
            <img src="<?php echo $settings['text_image1']; ?>" class="img-fluid" alt="<?php echo $settings['text_image1_title']; ?>" />
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

.video_play-btn {
    width: 80px;
    height: 80px;
	border-radius: 50%;
	    margin: auto;
top: 45%;
    position: absolute;
  
    left: 40%;

}
.video_play-btn a i {
    line-height: 80px;
	margin-left:5px;
    font-size: 20px;
	color:#fff;
}
.hero_play_btn span {
    display: block;
    margin-top: 15px;
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