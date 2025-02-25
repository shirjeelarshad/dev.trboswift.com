<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style6',  'data') );
add_action( 'image_style6',  		array('block_image_style6', 'output' ) );
add_action( 'image_style6-css',  	array('block_image_style6', 'css' ) );

class block_image_style6 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style6'] = array(
			"name" 	=> "Style 6",
			"image"	=> "image_style6.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style6", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(710,525), array(500,250), array(234,250), array(234,250) );
		 $i=1; while($i < 5){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }		
		
		global $imagedata;
 
		ob_start();
		?>
        
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

 
        <div class="container px-0">
            <div class="row">
            
                 <div class="col-lg-7">
                 
                 
                 
<?php 
 
$imagedata = array(	
	 "effect" 				=> $settings['image_block1_effect'],
	 "image_size" 			=> $settings['image_block1_size'],
	 "image_txtcolor" 		=> $settings['image_block1_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block1_txtpos'],
	 "image" 				=> $settings['image_block1'],
	 "image_title" 			=> $settings['image_block1_title'],
	 "image_subtitle" 		=> $settings['image_block1_subtitle'],
	 "image_link" 			=> $settings['image_block1_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?> 
            
         
            
            

                    
                    
                </div>
            
                <div class="col-lg-5">
                
<?php 
 
$imagedata = array(	
	 "effect" 				=> $settings['image_block2_effect'],
	 "image_size" 			=> $settings['image_block2_size'],
	 "image_txtcolor" 		=> $settings['image_block2_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block2_txtpos'],
	 "image" 				=> $settings['image_block2'],
	 "image_title" 			=> $settings['image_block2_title'],
	 "image_subtitle" 		=> $settings['image_block2_subtitle'],
	 "image_link" 			=> $settings['image_block2_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?> 
            
            
            <div class="row mt-4">
                
                
                 
                
                
                <div class="col-lg-6">
                
<?php 
 
$imagedata = array(	
	 "effect" 				=> $settings['image_block3_effect'],
	 "image_size" 			=> $settings['image_block3_size'],
	 "image_txtcolor" 		=> $settings['image_block3_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block3_txtpos'],
	 "image" 				=> $settings['image_block3'],
	 "image_title" 			=> $settings['image_block3_title'],
	 "image_subtitle" 		=> $settings['image_block3_subtitle'],
	 "image_link" 			=> $settings['image_block3_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?> 
            
            </div>
            <div class="col-lg-6">
            
            
<?php 
 
$imagedata = array(	
	 "effect" 				=> $settings['image_block4_effect'],
	 "image_size" 			=> $settings['image_block4_size'],
	 "image_txtcolor" 		=> $settings['image_block4_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block4_txtpos'],
	 "image" 				=> $settings['image_block4'],
	 "image_title" 			=> $settings['image_block4_title'],
	 "image_subtitle" 		=> $settings['image_block4_subtitle'],
	 "image_link" 			=> $settings['image_block4_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?> 
                
                
                </div>
                
            </div>
                
            </div>
   
   </div> </div> </div>

</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
	
		ob_start();
		?>
        
        <style>
		 
		</style>
        
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>