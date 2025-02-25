<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text5',  'data') );
add_action( 'text5',  		array('block_text5', 'output' ) );
add_action( 'text5-css',  	array('block_text5', 'css' ) );
add_action( 'text5-js',  	array('block_text5', 'js' ) );

class block_text5 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "text5.jpg",
			"order" => 5,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "text") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "text") ),					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "text") ),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text5", "text", $settings ) );
 
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		
		if($settings['text_image1'] == ""){
		$settings['text_image1'] =  $CORE->LAYOUT("get_placeholder",array('full'));
		}
		
		
 		 
	 
	ob_start();
	?>
<section class="block-text5 position-relative bg-dark">

<?php if(strlen($settings['text_image1']) > 1){ ?>
<div class="bg-inner" data-bg="<?php echo $settings['text_image1']; ?>"></div>
<?php } ?>

<div class="overlay-inner"></div>
 
<div class="bg-gradient bg-wrap overflow-hidden text-white" style="z-index:5">
 
<div class="text-center <?php echo $settings['section_padding']; ?>">

                <div class="section-title-separator ">
                    <span>
                    <i class="fas fa-star text-white opacity-5"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-white opacity-5"></i>
                    </span>
                </div>
                 
                <h1 class="font-weight-bold text-white h2 mt-3"><?php  echo $settings['title']; ?></h1>
                <p class="lead text-white col-md-5 mx-auto opacity-5"><?php echo $settings['desc']; ?></p>
                <hr style="width:50px; height:3px;" class="bg-primary mx-auto">
 
</div>

</div>

<div class="clearfix"></div>
<div> 

</div></section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
 
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