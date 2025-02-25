<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic2a',  'data') );
add_action( 'image_basic2a',  		array('block_image_basic2a', 'output' ) );
add_action( 'image_basic2a-css',  	array('block_image_basic2a', 'css' ) );

class block_image_basic2a {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic2a'] = array(
			"name" 	=> "2 Images (a)",
			"image"	=> "image_basic2a.jpg",
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
						"image1_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ),
						
						"image1_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image1_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image1_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						  
						  
						"image2" 			=> array( "t" => "Big Image 1 (870x435 pixels)","type" => "upload" ), 
						"image2_txtcolor" 	=> array( "t" => "Click Link (http) ","type" => "select", "values" => array("light","dark")  ), 

						"image2_link" 		=> array( "t" => "Click Link (http) ","type" => "text",   ), 
						"image2_title" 		=> array( "t" => "Click Link (http) ","type" => "text",  ), 
						"image2_subtitle" 	=> array( "t" => "Click Link (http) ","type" => "text", ), 
						 
						
			),			
						 
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic2a", "image_block", $settings ) );
 		 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $i=1; while($i < 3){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(1000,600));
			}
			$i++;
		 }
		 
 
		ob_start();
		?>
<section class="image_block grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="container-fluid px-0">
<div class="row">

<?php $i=1; while($i < 3){ ?>
<div class="col-md-6 px-0">
<?php 
global $imagedata;

$imagedata = array(	
	 "effect" 				=> $settings['image_block'.$i.'_effect'],
	 "image_size" 			=> $settings['image_block'.$i.'_size'],
	 "image_txtcolor" 		=> $settings['image_block'.$i.'_txtcolor'],
	 "image_txtpos" 		=> $settings['image_block'.$i.'_txtpos'],
	 "image" 				=> $settings['image_block'.$i],
	 "image_title" 			=> $settings['image_block'.$i.'_title'],
	 "image_subtitle" 		=> $settings['image_block'.$i.'_subtitle'],
	 "image_link" 			=> $settings['image_block'.$i.'_link'], 
);

_ppt_template( 'framework/design/image_block/parts/image' ); 

?>  
</div>   
<?php $i++; } ?> 
  


</div></div>
</section>
 

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
	
		ob_start();
		?> 
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>