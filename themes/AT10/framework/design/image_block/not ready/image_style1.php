<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style1',  'data') );
add_action( 'image_style1',  		array('block_image_style1', 'output' ) );
add_action( 'image_style1-css',  	array('block_image_style1', 'css' ) );

class block_image_style1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "image_style1.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array(
			
						"image_size" => 
							array( 
							"t" => "Image Size",
							"type" => "select", 
							"values" => array(
								"200" => "200px", 
								"250" => "250px", 
								"300" => "300px", 
								"350" => "350px", 
								"400" => "400px", 
								"450" => "450px"
							),						 
						), 

						"image1" 			=> array( "t" => "Big Image 1 (870x435 pixels)","type" => "upload" ), 
						"image1_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image1_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ),						
						"image1_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image1_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						  
						  
						"image2" 			=> array( "t" => "Big Image 1 (870x435 pixels)","type" => "upload" ), 
						"image2_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image2_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ),						
						"image2_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image2_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						 
						
						"image3" 			=> array( "t" => "Big Image 1 (870x435 pixels)","type" => "upload" ), 
						"image3_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image3_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ),						
						"image3_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image3_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						 
						 
						"image4" 			=> array( "t" => "Big Image 1 (870x435 pixels)","type" => "upload" ), 
						"image4_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image4_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ),						
						"image4_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image4_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						 
				  
			),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style1", "image_block", $settings ) );
 		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $sd = array( '', array(400,525), array(820,250), array(400,250), array(400,250)  );
		 $i=1; while($i < 6){ 		 	
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
            
<div class="col-lg-4 d-none d-lg-block">
                 
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
            
<div class="col-lg-8">
<div class="row">
<div class="col mb-4">
                           
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

</div>                        
</div>
                    
<div class="row">
<div class="col-md-6">                           
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
<div class="col-md-6">
                          
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
                
           
                
            </div>
   
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