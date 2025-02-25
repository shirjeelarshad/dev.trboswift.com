<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon_n4',  'data') );
add_action( 'icon_n4',  		array('block_icon_n4', 'output' ) );
add_action( 'icon_n4-css',  	array('block_icon_n4', 'css' ) );
add_action( 'icon_n4-js',  	array('block_icon_n4', 'js' ) );

class block_icon_n4 {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon_n4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "icon_n4.jpg",
			"cat"	=> "icon",
			"order" => 3,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			
			"defaults" => array(
					
					
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
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "light",
					"desc_txtcolor" 	=> "opacity-5",
					 
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
					
					// ICONS
					"icon1_title" 		=> "Awesome Features",
					"icon1_type"		=> "image",
					"icon1_image" 		=> "", //DEMO_IMG_PATH."/blocks/icon/b1.svg",
					
					"icon2_title" 		=> "Save Time &amp; Money",
					"icon2_type"		=> "image",
					"icon2_image" 		=> "", //DEMO_IMG_PATH."/blocks/icon/b2.svg",
					
					"icon3_title" 		=> "Members Area",
					"icon3_type"		=> "image",
					"icon3_image" 		=> "", //DEMO_IMG_PATH."/blocks/icon/b3.svg",
					
			),
			
			
			
			
			
			
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon_n4", "icon", $settings ) ); 
  
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		/* DEFAULTS */
		if($settings['icon1_title'] == ""){
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "icon_n4");		
			
			$i=1;
			while($i < 4){
				$settings['icon'.$i.'_title'] = $default_data['icon'.$i.'_title'];
				$settings['icon'.$i.'_type'] = $default_data['icon'.$i.'_type'];
				$settings['icon'.$i.'_image'] = $default_data['icon'.$i.'_image'];
			$i++;
			} 	 
		 
			
			
			
		}
	 
		 	 
	  
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container">
   <div class="row">
   <?php if($settings['title_show'] == "yes"){ ?>
   <div class="col-12">
   
      <?php _ppt_template( 'framework/design/parts/title' ); ?>      
       
   </div>
   <?php } ?>
   
   <div class="col-12">
      <div class="row">
         <?php $i=1; while($i < 5){ ?>
         <div class="col-md-3">
           
              
               <a href="<?php if($settings['icon'.$i.'_link'] == ""){ echo "#"; }else{ echo $settings['icon'.$i.'_link']; } ?>" class="text-decoration-none">
              
               <div class="card  mb-4 mb-md-0" style="border-top:3px solid <?php if($i == 1){ echo '#1274e7'; }elseif($i == 2){ echo '#00c853'; }elseif($i == 3){ echo '#ff9800'; }else{ echo '#ff1700'; } ?>">
               <div class="card-body py-lg-4">
               
                  <div class="row">
                  
                  <?php if($settings['icon'.$i.'_image'] != "" || $settings['icon'.$i] != ""){ ?>
                  <div class="col-12 col-md-3">
                  
                    <?php if($settings['icon'.$i.'_type'] == "image"){ ?>
                       <img data-src="<?php echo $settings['icon'.$i.'_image']; ?>" class="img-fluid mb-3 lazy" alt="<?php echo $settings['icon'.$i.'_title']; ?>" style="max-width:60px;" />                      
					   <?php }else{ ?>
                    	<i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-<?php echo $settings['icon'.$i.'_iconcolor']; ?>  fa-3x mb-4"></i>
                    	<?php } ?>
                  
                  </div>
                  <?php } ?>
                  
                     <div class="col-12 <?php if($settings['icon'.$i.'_image'] != "" || $settings['icon'.$i] != ""){ ?>col-md-9<?php }else{ ?>px-4<?php } ?>">
                     
                  
 
  <h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing  text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>" >
<?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?>
</h5>
    <p data-elementor-setting-key="icon<?php echo $i; ?>_desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-dark opacity-5"><?php if($settings['icon'.$i.'_desc'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('desc') ); }else{ echo $settings['icon'.$i.'_desc']; } ?></p>
                     
 


                     


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