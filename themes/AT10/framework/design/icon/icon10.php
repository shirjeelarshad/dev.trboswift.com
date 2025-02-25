<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon10',  'data') );
add_action( 'icon10',  		array('block_icon10', 'output' ) );
add_action( 'icon10-css',  	array('block_icon10', 'css' ) );
add_action( 'icon10-js',  	array('block_icon10', 'js' ) );

class block_icon10 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon10'] = array(
			"name" 	=> "Style 10",
			"image"	=> "icon10.jpg",
			"cat"	=> "icon",
			"order" => 10,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					"section_padding" => "section-40",
					"section_bg"	=>	"bg-light",	
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "icon") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc_small', "text") ),
					 	
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon10", "icon", $settings ) ); 
	 
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
		 
	 
	ob_start();
	?>
    
 
    
    
    
<section class="icon10 <?php echo $settings['section_class']." ".$settings['section_padding']."  ".$settings['section_bg']."  ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row">
            
             <?php if($settings['title_show'] == "yes"){ ?>
             <div class="col-md-12 col-lg-6 text-center text-lg-left pb-5 pr-lg-5">
             
            
             <?php _ppt_template( 'framework/design/parts/title' ); ?>
					
            <?php _ppt_template( 'framework/design/parts/btn' ); ?>
			
             
             </div>
             <?php } ?>
            
          

                <div class="col-md-12 col-lg-6">
                
                 
                    <div class="icon10m">
                    
                    
                    
                    <div class="row">
                    <?php $i=1; while($i < 5){ ?>
                    <div class="col-md-6 col-lg-6">
                        <div class="media mb-4 text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>">
                            <div class="mr-3">
                            <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-<?php echo $settings['icon'.$i.'_iconcolor']; ?> fa-2x"></i>
                            </div>
                            <div class="media-body">                            
                                <h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"> <?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                                <p data-elementor-setting-key="icon<?php echo $i; ?>_desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-muted"><?php if($settings['icon'.$i.'_desc'] == ""){ ?>Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                            </div>
                        </div>
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