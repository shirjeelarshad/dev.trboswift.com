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
			"desc" 	=> "", 
			"data" 	=> array(
					
	 					
				"title" => array( "t" => "Title Text","type" => "icon", "d" => "Welcome to my website!" ),
				"desc" 	=> array( "t" => "Description Text","type" => "iconarea","d" => ""),	
				
			),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
	$settings = array(
 			
			"title" 		=> $CORE->LAYOUT("load_single_value", array('icon10', 'title')),	
			"subtitle" 		=> $CORE->LAYOUT("load_single_value", array('icon10', 'subtitle')),	
		 
			 
	 );  
	  
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
		 
	ob_start();
	?>
    
    <section class="icon10 <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row align-items-center">
            
            
            
               <div class="col-lg-6 col-xl-4 text-center text-md-left">
                   
                        <?php _ppt_template( 'framework/design/parts/title' ); ?>
                        
                         <?php _ppt_template( 'framework/design/parts/btn' ); ?>
                      
                </div>
            
            
            
            
            
                <div class="col-lg-6 col-xl-7 mb-4 offset-xl-1">
                    <div class="row no-gutters">
                        <div class="col-4 mb-5">
                            <div class="media9 text-center">
                                <span><i class="<?php if($settings['icon1'] == ""){ ?>fas fa-anchor<?php  }else{  echo strtolower($settings['icon1']); } ?> text-<?php echo $settings['icon1_iconcolor']; ?>"></i></span>
                                <h5><?php if($settings['icon1_title'] == ""){ ?>Flexible<?php }else{ echo $settings['icon1_title']; } ?></h5>
                            </div>
                        </div>
                        <div class="col-4 mb-5">
                            <div class="media9 text-center">
                                <span><i class="<?php if($settings['icon2'] == ""){ ?>fas fa-layer-group<?php  }else{  echo strtolower($settings['icon2']); } ?> text-<?php echo $settings['icon2_iconcolor']; ?>"></i></span>
                                <h5><?php if($settings['icon2_title'] == ""){ ?>Secure<?php }else{ echo $settings['icon2_title']; } ?></h5>
                            </div>
                        </div>
                        <div class="col-4 mb-5">
                            <div class="media9 text-center">

                                <span><i class="<?php if($settings['icon3'] == ""){ ?>fas fa-tachometer-alt<?php  }else{  echo strtolower($settings['icon3']); } ?> text-<?php echo $settings['icon3_iconcolor']; ?>"></i></span>
                                <h5><?php if($settings['icon3_title'] == ""){ ?>Access<?php }else{ echo $settings['icon3_title']; } ?></h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="media9 text-center">
                                <span><i class="<?php if($settings['icon4'] == ""){ ?>fas fa-file-signature<?php  }else{  echo strtolower($settings['icon4']); } ?> text-<?php echo $settings['icon4_iconcolor']; ?>"></i></span>

                                <h5><?php if($settings['icon4_title'] == ""){ ?>Location<?php }else{ echo $settings['icon4_title']; } ?></h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="media9 text-center">
                                <span><i class="<?php if($settings['icon5'] == ""){ ?>fas fa-hand-pointer<?php  }else{  echo strtolower($settings['icon5']); } ?> text-<?php echo $settings['icon5_iconcolor']; ?>"></i></span>
                                <h5<?php if($settings['icon5_title'] == ""){ ?>>Rented<?php }else{ echo $settings['icon5_title']; } ?></h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="media9 text-center">
                                <span><i class="<?php if($settings['icon6'] == ""){ ?>fas fa-smile-beam<?php  }else{  echo strtolower($settings['icon6']); } ?> text-<?php echo $settings['icon6_iconcolor']; ?>"></i></span>
                                <h5><?php if($settings['icon6_title'] == ""){ ?>Countries<?php }else{ echo $settings['icon6_title']; } ?></h5>
                            </div>
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

.icon10 span {
    display: inline-block;
    text-align: center;
    color: #000;
    font-size: 30px;
}

@media (max-width:991px) {
    .icon10 br {
        display: none;
    }
    .icon10 h2 {
        font-size: 30px;
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