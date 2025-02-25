<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon9',  'data') );
add_action( 'icon9',  		array('block_icon9', 'output' ) );
add_action( 'icon9-css',  	array('block_icon9', 'css' ) );
add_action( 'icon9-js',  	array('block_icon9', 'js' ) );

class block_icon9 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon9'] = array(
			"name" 	=> "Style 9",
			"image"	=> "icon9.jpg",
			"cat"	=> "icon",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon9", "icon", $settings ) ); 
  
	 
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
    <section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
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
            <div class="  text-md-center">
                
                  <div class="row">
                     <div class="col-3 col-md-12">
                        <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> fa-3x mb-4 text-<?php echo $settings['icon'.$i.'_iconcolor']; ?>"></i>
                     </div>
                     <div class="col-9 col-md-12 ">
<h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>"><?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                        <p class="opacity-5 text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>"><?php if($settings['icon'.$i.'_desc'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('desc') ); }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                     </div>
                  </div>
               
            </div>
         </div>
         <?php $i++; } ?>
      </div>
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