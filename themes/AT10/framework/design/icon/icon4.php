<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon4',  'data') );
add_action( 'icon4',  		array('block_icon4', 'output' ) );
add_action( 'icon4-css',  	array('block_icon4', 'css' ) );
add_action( 'icon4-js',  	array('block_icon4', 'js' ) );

class block_icon4 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "icon4.jpg",
			"cat"	=> "icon",
			"order" => 4,
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
					"subtitle_margin"	=> "mb-5",
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon4", "icon", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['image_icon'] == ""){
		$settings['image_icon'] =   DEMO_IMG_PATH."/innerpages/1.jpg";	
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
    
<section class="icon4 <?php echo $settings['section_class']." ".$settings['section_bg']."  ".$settings['section_divider']; ?>">
        <div class="container-fluid px-md-0">
            <div class="row">
            
            
             <div class="col-md-5 col-12 bg-cover eqh"  style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('<?php echo $settings['image_icon']; ?>');"></div>
            
          

                <div class="col-lg-7 text-left section-100">
                
                 
                    <div class="col-sm-10 mx-auto">
                    
                    
                     <?php _ppt_template( 'framework/design/parts/title' ); ?>
                     
                     <?php _ppt_template( 'framework/design/parts/btn' ); ?>
                     
					
                    <div class="row mt-md-5 icon4m">
                    <?php $i=1; while($i < 5){ ?>
                    <div class="col-lg-12 col-xl-6 pr-xl-5">
                        <div class="media">
                              <div class="mr-3">
                            <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-primary fa-2x"></i>
                            </div>
                            <div class="media-body">
                            
                            
                                <h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing mt-0"><?php if($settings['icon'.$i.'_title'] == ""){ ?>Powerful Layout<?php }else{ echo $settings['icon'.$i.'_title']; } ?> </h5>
            
                                <p data-elementor-setting-key="icon<?php echo $i; ?>_desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-muted opacity-5"><?php if($settings['icon'.$i.'_desc'] == ""){ ?>Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
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
		ob_start();
		?>
<style>
.icon4 .icon4m span {
    display: block;
    margin-right: 20px;
    background: #0076ff;
    width: 70px;
    height: 70px;
    text-align: center;
    line-height: 70px;
    color: #fff;
    font-size: 25px;
    border-radius: 50%;
}

.icon4 .icon4m .media {
    margin-bottom: 15px;
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