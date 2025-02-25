<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon7',  'data') );
add_action( 'icon7',  		array('block_icon7', 'output' ) );
add_action( 'icon7-css',  	array('block_icon7', 'css' ) );
add_action( 'icon7-js',  	array('block_icon7', 'js' ) );

class block_icon7 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon7'] = array(
			"name" 	=> "Style 7",
			"image"	=> "icon7.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon7", "icon", $settings ) ); 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		if($settings['image_icon'] == ""){
		$settings['image_icon'] = $CORE->LAYOUT("get_placeholder", array(600,800) );
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
    
 
    
    
    
<section class="icon7 <?php echo $settings['section_class']." ".$settings['section_bg']."  ".$settings['section_divider']; ?>">
        <div class="container-fluid px-md-0">
            <div class="row">
            
            
             <div class="col-md-5 col-12 bg-cover eqh"  style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('<?php echo $settings['image_icon']; ?>');"></div>
            
          

                <div class="col-md-7 text-left section-100">
                
                
                
                
                    <div class="icon7m p-lg-5 col-sm-10 mx-auto">
                    
                    
                     <?php _ppt_template( 'framework/design/parts/title' ); ?>
                     
                      <?php _ppt_template( 'framework/design/parts/btn' ); ?>
					
                    <div class="row mt-md-5">
                    <?php $i=1; while($i < 5){ ?>
                    <div class="col-lg-6 pr-lg-5">
                        <div class="media">
                           
                            <div class="media-body">
                            
                            
                                <h3 class="mt-0"><?php if($settings['icon'.$i.'_title'] == ""){ ?>Powerful Layout<?php }else{ echo $settings['icon'.$i.'_title']; } ?> </h3>
                                <p class="text-muted"><?php if($settings['icon'.$i.'_desc'] == ""){ ?>Earn partem audiam impedit oblique propriae singulis nec.<?php }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
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
.icon7 .icon7m span {
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

.icon7 .icon7m .media {
    margin-bottom: 15px;
}

.icon7 .icon7m h3 {
    font-weight: 700;
    text-transform: capitalize;
    font-size: 20px;
    color: #000;
    margin-bottom: 20px;
    margin-top: 18px;
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