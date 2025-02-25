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
			"order" => 9,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			"defaults" => array(
					
					"section_padding" => "section-40",
					"section_bg"	=>	"bg-light",	
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					"title" 			=> "Build your website in minutes!",					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "hero") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
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
		
		"fal fa-layer-group",
		"fal fa-tachometer-alt",
		"fal fa-file-signature",

		"fal fa-layer-group",
		"fal fa-tachometer-alt",
 		
		
		);
		
		if($settings['image_icon'] == ""){
		$settings['image_icon'] =   DEMO_IMG_PATH."/innerpages/1.jpg";		
		}
		 
	  
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
  
   <div class="col-lg-5 col-md-12">
   
   <div class="row">
    <?php if($settings['title_show'] == "yes"){ ?>
   		<div class="col-lg-12 col-md-7">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>      
       		<?php _ppt_template( 'framework/design/parts/btn' ); ?>
        
        </div>
        <?php } ?>
   
   		<div class="col-lg-12 col-md-5">
        
              <ul class="list-group list-group-flush">
                    <?php $i=1; while($i < 8){ 
                    
                    if($settings['icon'.$i.'_title'] == "" && $i > 5){ $i++; continue; }
                    ?>
                     <li class="list-group-item pl-0 py-3" style="background:transparent !important;">
                     
                     <i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-<?php echo $settings['icon'.$i.'_iconcolor']; ?> mr-2"></i>
                     
                     
            <span data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>">
            <?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?>
            </span>
                            
            </li>
                     
                     <?php $i++; } ?>
                   </ul>
        
        </div>      
       
   </div>
       
       
     
       
   </div>
  
   
   <div class="col-lg-6 offset-lg-1 text-center my-4 my-lg-0">
   
   <img data-src="<?php echo $settings['image_icon']; ?>" class="img-fluid shadow lazy" alt="<?php echo $settings['icon1_title']; ?>" />
       
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