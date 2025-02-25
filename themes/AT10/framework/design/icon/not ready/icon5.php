<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon5',  'data') );
add_action( 'icon5',  		array('block_icon5', 'output' ) );
add_action( 'icon5-css',  	array('block_icon5', 'css' ) );
add_action( 'icon5-js',  	array('block_icon5', 'js' ) );

class block_icon5 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "icon5.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon5", "icon", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['image_icon'] == ""){
		$settings['image_icon'] = $CORE->LAYOUT("get_placeholder", array(700,600) );
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
    
 
    
    
    
<section class="icon5 <?php echo $settings['section_class']." ".$settings['section_padding']."  ".$settings['section_bg']."  ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row d-flex flex-lg-row-reverse">
             

                <div class="col-md-6">
                  
                    
                     <?php _ppt_template( 'framework/design/parts/title' ); ?>
                     <?php _ppt_template( 'framework/design/parts/btn' ); ?>
                     
					
                    <div class="row mt-md-5">
                    <?php $i=1; while($i < 5){ ?>
                    <div class="col-lg-6">
                        <div class="media mb-4">
                            <div class="mr-3">
                            <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-primary fa-2x"></i>
                            </div>
                            <div class="media-body">
                            
                            
                                <h5> <?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                                <p class="text-muted"><?php if($settings['icon'.$i.'_desc'] == ""){ ?>Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                            </div>
                        </div>
                        </div>
                        <?php $i++; } ?> 
                        </div>
                        
                    </div>
              
                
                
                 
             <div class="col-md-6 col-12  pr-lg-5">
             
             <img data-src="<?php echo $settings['image_icon']; ?>" class="img-fluid lazy" />
             
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