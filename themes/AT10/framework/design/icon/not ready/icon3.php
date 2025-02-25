<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon3',  'data') );
add_action( 'icon3',  		array('block_icon3', 'output' ) );
add_action( 'icon3-css',  	array('block_icon3', 'css' ) );
add_action( 'icon3-js',  	array('block_icon3', 'js' ) );

class block_icon3 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "icon3.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon3", "icon", $settings ) ); 
	 
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
    
 <section class="icon3 <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container"> 

            <div class="row">
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">
                        <span><i class="<?php if($settings['icon1'] == ""){ ?>fas fa-anchor<?php  }else{  echo strtolower($settings['icon1']); } ?> text-<?php echo $settings['icon1_iconcolor']; ?> fa-2x mb-2"></i></span>
                        <h5><?php if($settings['icon1_title'] == ""){ ?>Layouts<?php }else{ echo $settings['icon1_title']; } ?></h5>
                    </div>
                </div>
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">
                        <span><i class="<?php if($settings['icon2'] == ""){ ?>fas fa-layer-group<?php  }else{  echo strtolower($settings['icon2']); } ?> text-<?php echo $settings['icon2_iconcolor']; ?> fa-2x mb-2"></i></span>
                        <h5><?php if($settings['icon2_title'] == ""){ ?>Coffee<?php }else{ echo $settings['icon2_title']; } ?></h5>
                    </div>
                </div>
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">

                        <span><i class="<?php if($settings['icon3'] == ""){ ?>fas fa-tachometer-alt<?php  }else{  echo strtolower($settings['icon3']); } ?> text-<?php echo $settings['icon3_iconcolor']; ?> fa-2x mb-2"></i></span>
                        <h5><?php if($settings['icon3_title'] == ""){ ?>Awards<?php }else{ echo $settings['icon3_title']; } ?></h5>
                    </div>
                </div>
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">
                        <span><i class="<?php if($settings['icon4'] == ""){ ?>fas fa-file-signature<?php  }else{  echo strtolower($settings['icon4']); } ?> text-<?php echo $settings['icon4_iconcolor']; ?> fa-2x mb-2"></i></span>

                        <h5><?php if($settings['icon4_title'] == ""){ ?>Projects<?php }else{ echo $settings['icon4_title']; } ?></h5>
                    </div>
                </div>
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">
                        <span><i class="<?php if($settings['icon5'] == ""){ ?>fas fa-hand-pointer<?php  }else{  echo strtolower($settings['icon5']); } ?> text-<?php echo $settings['icon5_iconcolor']; ?> fa-2x mb-2"></i></span>
                        <h5><?php if($settings['icon5_title'] == ""){ ?>Gift Cards<?php }else{ echo $settings['icon5_title']; } ?></h5>
                    </div>
                </div>
                <div class="col-6 col-lg-2 col-md-4  mb-4">
                    <div class="media9 text-center">
                        <span><i class="<?php if($settings['icon6'] == ""){ ?>fas fa-smile-beam<?php  }else{  echo strtolower($settings['icon6']); } ?> text-<?php echo $settings['icon6_iconcolor']; ?> fa-2x mb-2"></i></span>
                        <h5><?php if($settings['icon6_title'] == ""){ ?>FaceApp<?php }else{ echo $settings['icon6_title']; } ?></h5>
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
		?>
 
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