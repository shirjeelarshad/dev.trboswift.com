<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon11',  'data') );
add_action( 'icon11',  		array('block_icon11', 'output' ) );
add_action( 'icon11-css',  	array('block_icon11', 'css' ) );
add_action( 'icon11-js',  	array('block_icon11', 'js' ) );

class block_icon11 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon11'] = array(
			"name" 	=> "Style 11",
			"image"	=> "icon11.jpg",
			"cat"	=> "icon",
			"order" => 11,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					"section_padding" => "section-40",
					"section_bg"	=>	"bg-light",	
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> "Build your website in minutes!",					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "hero") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
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
					
					 
			),		
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon11", "icon", $settings ) ); 
  
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		// default icons
		$d_icons = array(
		"",
		"fal fa-layer-group",
		"fal fa-tachometer-alt",
		"fal fa-file-signature",
		"fal fa-file",		
		);
		
		$settings["title_pos"] = "center";
	 
	 
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
   
   <?php if($settings['title_show'] == "yes"){ ?>
  <div class="col-lg-8 mx-auto text-center pb-5">
      <?php _ppt_template( 'framework/design/parts/title' ); ?>
       <?php _ppt_template( 'framework/design/parts/btn' ); ?>
   </div>
   <?php } ?>
   <div class="col-12 mx-auto">
      <div class="row"> 

 <?php $i=1; while($i < 4){ ?>
                    <div class="col-md-4">
                        <div class="media">
                            <div class="mr-3">
                            <i class="<?php if(strlen($settings['icon'.$i]) < 3){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?>  text-<?php echo $settings['icon'.$i.'_iconcolor']; ?> fa-2x"></i>
                            </div>
                            <div class="media-body text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>">
                             
                                <h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                                <p data-elementor-setting-key="icon<?php echo $i; ?>_desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-muted"><?php if($settings['icon'.$i.'_desc'] == ""){ ?>Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                            </div>
                        </div>
                        </div>
                        <?php $i++; } ?> 
                        </div> </div>
 
      </div>
      
      
      
   </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
	 
		ob_start();
		?><?php	
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