<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon12',  'data') );
add_action( 'icon12',  		array('block_icon12', 'output' ) );
add_action( 'icon12-css',  	array('block_icon12', 'css' ) );
add_action( 'icon12-js',  	array('block_icon12', 'js' ) );

class block_icon12 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon12'] = array(
			"name" 	=> "Style 12",
			"image"	=> "icon12.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon12", "icon", $settings ) ); 
  
	 
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
		"fal fa-file-signature",
		"fal fa-file",		
		);
	 
	 
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
   
   <?php if($settings['title_show'] == "yes"){ ?>
  <div class="col-md-8 mx-auto text-center">
      <?php _ppt_template( 'framework/design/parts/title' ); ?>
       <?php _ppt_template( 'framework/design/parts/btn' ); ?>
   </div>
   <?php } ?>
   <div class="col-10 mx-auto">
      <div class="row"> 

 <?php $i=1; while($i < 7){ ?>
                    <div class="col-md-4 py-4">
                        <div class="media">
                            <div class="mr-3">
                            <i class="<?php if(strlen($settings['icon'.$i]) < 3){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?>  text-<?php echo $settings['icon'.$i.'_iconcolor']; ?> fa-2x"></i>
                            </div>
                            <div class="media-body text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>">
                             
                                <h5><?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                                
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