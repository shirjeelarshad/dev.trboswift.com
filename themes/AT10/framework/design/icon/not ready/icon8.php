<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon8',  'data') );
add_action( 'icon8',  		array('block_icon8', 'output' ) );
add_action( 'icon8-css',  	array('block_icon8', 'css' ) );
add_action( 'icon8-js',  	array('block_icon8', 'js' ) );

class block_icon8 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon8'] = array(
			"name" 	=> "Style 8",
			"image"	=> "icon8.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon8", "icon", $settings ) ); 
  
	 
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
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
   <?php if($settings['title_show'] == "yes"){ ?>
   <div class="col-md-8 mx-auto text-center mb-5">
      <?php _ppt_template( 'framework/design/parts/title' ); ?> 
      
      <?php _ppt_template( 'framework/design/parts/btn' ); ?> 
      
   </div>
   <?php } ?>
   <div class="col-12 mx-auto">
      <div class="row">
         <?php $i=1; while($i < 5){ ?>
         <div class="col-md-6 col-lg-3 mb-4  mb-lg-0">
            <div class="card py-md-4 bg-light">
               <div class="card-body text-md-center">
                  <div class="row">
                     <div class="col-3 col-md-12">
                        <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-primary  fa-3x mb-4"></i>
                     </div>
                     <div class="col-9 col-md-12">
                        <h5><?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                        <p class="opacity-5"><?php if($settings['icon'.$i.'_desc'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('desc') ); }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php $i++; } ?>
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