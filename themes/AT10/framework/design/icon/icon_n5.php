<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon_n5',  'data') );
add_action( 'icon_n5',  		array('block_icon_n5', 'output' ) );
add_action( 'icon_n5-css',  	array('block_icon_n5', 'css' ) );
add_action( 'icon_n5-js',  	array('block_icon_n5', 'js' ) );

class block_icon_n5 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon_n5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "icon_n5.jpg",
			"cat"	=> "icon",
			"order" => 10,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
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
					
					"icon1_title" => "Pixel Perfect",
					"icon1_desc"  => "Made by professionals",
				 
					"icon2_title" => "Product UX",
					"icon2_desc"  => "Get buyers satisfaction",				 
				 
				 	"icon3_title" => "Web Design",
					"icon3_desc"  => "From A to Z",				 
				 
				 	"icon4_title" => "SEO Ready",
					"icon4_desc"  => "Search engines friendly",
				 
					 
					
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon_n5", "icon", $settings ) ); 
  
	 
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
		"fal fa-globe",
		
		);
		
		$settings["title_pos"] = "center";
		 
	  
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
   <?php if($settings['title_show'] == "yes"){ ?>
  <div class="col-lg-8 mx-auto text-center mb-4">  
      <?php _ppt_template( 'framework/design/parts/title' ); ?> 
   </div>
   <?php } ?>
   
   <div class="col-12 col-md-10 mx-auto">
      <div class="row">
         <?php $i=1; while($i < 5){ ?>
         <div class="col-md-6 col-lg-3">
            <div class="card py-md-4 mb-4 mb-md-0" style="border-radius:0px;">
            <a href="<?php if($settings['icon'.$i.'_link'] == ""){ echo home_url()."/?s="; }else{ echo $settings['icon'.$i.'_link']; } ?>" class="text-decoration-none">
               <div class="card-body text-md-center">
               
               
                  <div class="row">
                     <div class="col-3 col-md-12">
                       
                        <?php if($settings['icon'.$i.'_type'] == "image"){ ?>
                       <img data-src="<?php echo $settings['icon'.$i.'_image']; ?>" class="img-fluid mb-3 lazy" alt="<?php echo $settings['icon'.$i.'_title']; ?>" />                      
					   <?php }else{ ?>
                    	<i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-<?php echo $settings['icon'.$i.'_iconcolor']; ?>  fa-3x mb-4"></i>
                    	<?php } ?>
                    
                    
                     </div>
                     <div class="col-9  col-md-12">
                     
<h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing mb-md-4 text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>">
<?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?>
</h5>
<p class="text-dark opacity-5 small"><?php if($settings['icon'.$i.'_desc'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('desc') ); }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                     
                     
                     </div>
                  </div>
               </div>
               </a>
               
            </div>
         </div>
         <?php $i++; } ?>
         
         <?php if($settings['btn_show'] == "yes"){ ?>
         <div class="col-12 text-center mt-4">
               <?php _ppt_template( 'framework/design/parts/btn' ); ?>
         </div>
         <?php } ?> 
         
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