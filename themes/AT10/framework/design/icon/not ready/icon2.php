<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon2',  'data') );
add_action( 'icon2',  		array('block_icon2', 'output' ) );
add_action( 'icon2-css',  	array('block_icon2', 'css' ) );
add_action( 'icon2-js',  	array('block_icon2', 'js' ) );

class block_icon2 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "icon2.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon2", "icon", $settings ) );   
	 
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
    
 <section class="icon2 <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
        <div class="container">
            <div class="row">
           
                <div class="col-md-6 mb-4 text-center text-md-left">
                     
                 <?php _ppt_template( 'framework/design/parts/title' ); ?>
				
                 <?php _ppt_template( 'framework/design/parts/btn' ); ?>	
                    
                </div>
                

                <div class="col-md-6">
                    <div class="icon2m">
                        <div class="media">
                            <span class="bg-primary"><i class="<?php if($settings['icon4'] == ""){ ?>fas fa-tachometer-alt <?php }else{ echo strtolower($settings['icon4']); } ?>"></i></span>
                            <div class="media-body">
                                <h5><?php if($settings['icon4_title'] == ""){ ?>Powerful Layout<?php }else{ echo $settings['icon4_title']; } ?></h5>
                                <p class="text-muted"><?php if($settings['icon4_desc'] == ""){ ?>His cu tamquam dolorum veritus, porro assum docendi mei. Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon4_desc']; } ?></p>
                            </div>
                        </div>

                        <div class="media">
                            <span class="bg-primary"><i class="<?php if($settings['icon5'] == ""){ ?>fas fa-layer-group <?php  }else{  echo strtolower($settings['icon5']); } ?>"></i></span>
                            <div class="media-body">
                                <h5><?php if($settings['icon5_title'] == ""){ ?>Functionality<?php }else{ echo $settings['icon5_title']; } ?></h5>
                                <p class="text-muted"><?php if($settings['icon5_desc'] == ""){ ?>Noluime similique te his. Sect consul vocent ez, has vero mandamus eu, ei earn alia recusabo harum vocibus.<?php }else{ echo $settings['icon6_desc']; } ?></p>

                            </div>
                        </div>
                        <div class="media mb-0">
                            <span class="bg-primary"><i class="<?php if($settings['icon6'] == ""){ ?>fas fa-file-signature <?php  }else{  echo strtolower($settings['icon6']); } ?>"></i></span>
                            <div class="media-body">
                                <h5><?php if($settings['icon6_title'] == ""){ ?>Documentation<?php }else{ echo $settings['icon6_title']; } ?></h5>
                                <p class="text-muted"><?php if($settings['icon6_desc'] == ""){ ?>Pro eu apeirian suavitate dissentiet, qui dicunt ancillae id, ne mea homero persequeris delectus instructior.<?php }else{ echo $settings['icon6_desc']; } ?></p>
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

 
.icon2 span.anchor {
    display: block;
    margin-bottom: 20px;
    font-size: 50px;
}

.icon2 span {
    display: block;
    margin-right: 20px;
    font-size: 16px;
}

.icon2 .media {
    margin-bottom: 20px;
}

.icon2 .mb-40 {
    margin-bottom: 40px;
}
 


.icon2 .icon2m span {
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

.icon2 .icon2m .media {
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