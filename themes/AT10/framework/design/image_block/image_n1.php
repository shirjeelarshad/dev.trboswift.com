<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_n1',  'data') );
add_action( 'image_n1',  		array('block_image_n1', 'output' ) );
add_action( 'image_n1-css',  	array('block_image_n1', 'css' ) );
add_action( 'image_n1-js',  	array('block_image_n1', 'js' ) );

class block_image_n1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_n1'] = array(
			"name" 	=> "New 1",
			"image"	=> "image_n1.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 1,
			"data" 	=> array( ),
			
			"defaults" => array(
					
					
					"section_padding" => "section-40",
					"section_bg"	=>	"bg-light",	
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					
					"title" 			=> "Popular Countries",					 
					"subtitle"			=> "search by the most popular countries",					
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
					
					"title_pos" => "center",
					 
					
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
					
					// IMAGE 1
					"image_block1_title" 	=> "United States",				
					"image_block1" 			=> DEMO_IMG_PATH."/blocks/image_block/country1.jpg",
					"image_block1_btn_link" => home_url()."/?s=&country=US",
				 
					// IMAGE 2
					"image_block2_title" 	=> "United Kingdom",			
					"image_block2" 			=> DEMO_IMG_PATH."/blocks/image_block/country2.jpg",
					"image_block2_btn_link" => home_url()."/?s=&country=GB",
				 
					 // IMAGE 3
					"image_block3_title" 	=> "India",			
					"image_block3" 			=> DEMO_IMG_PATH."/blocks/image_block/country3.jpg",
				  	"image_block3_btn_link" => home_url()."/?s=&country=IN",
				 
				 	// IMAGE 4
					"image_block4_title" 	=> "Canada",				
					"image_block4" 			=> DEMO_IMG_PATH."/blocks/image_block/country4.jpg",
				 	"image_block4_btn_link" => home_url()."/?s=&country=CA",
				 
				 	// IMAGE 5
					"image_block5_title" 	=> "Germany",				
					"image_block5" 			=> DEMO_IMG_PATH."/blocks/image_block/country5.jpg",
					"image_block5_btn_link" => home_url()."/?s=DE",			 
				 
				 	// IMAGE 6
					"image_block6_title" 	=> "Pakistan",				
					"image_block6" 			=> DEMO_IMG_PATH."/blocks/image_block/country7.jpg",
				 	"image_block6_btn_link" => home_url()."/?s=PK",
				 
			),			
						 
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_n1", "image_block", $settings ) );
 		 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 if($settings['image_block1'] == ""){
	 
			$default_data = $CORE->LAYOUT("get_block_defaults", "image_n1");
			
			$i=1;
			while($i < 7){		 	 
			$settings['image_block'.$i] = $default_data['image_block'.$i];
			$settings['image_block'.$i.'_title'] = $default_data['image_block'.$i.'_title'];
			$settings['image_block'.$i.'_btn_link'] = $default_data['image_block'.$i.'_btn_link'];		 	
			$i++;
			}
			
		}
		  
 		global $imagedata;
 
		ob_start();
		?>

<section class="image_block city-part grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  
 
  <div class="container">
    
<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>
   
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="city-card" style="background:url('<?php echo $settings['image_block1']; ?>') no-repeat center; background-size:cover">
          <h5><a href="<?php echo $settings['image_block1_btn_link']; ?>"><?php echo $settings['image_block1_title']; ?></a></h5>
        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="city-card" style="background:url('<?php echo $settings['image_block2']; ?>') no-repeat center; background-size:cover">
          <h5><a href="<?php echo $settings['image_block2_btn_link']; ?>"><?php echo $settings['image_block2_title']; ?></a></h5>
          
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-5">
        <div class="city-card" style="background:url('<?php echo $settings['image_block3']; ?>') no-repeat center; background-size:cover">
          <h5><a href="<?php echo $settings['image_block3_btn_link']; ?>"><?php echo $settings['image_block3_title']; ?></a></h5>
       
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-5">
        <div class="city-card" style="background:url('<?php echo $settings['image_block4']; ?>') no-repeat center; background-size:cover">
           <h5><a href="<?php echo $settings['image_block4_btn_link']; ?>"><?php echo $settings['image_block4_title']; ?></a></h5>
         
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="city-card" style="background:url('<?php echo $settings['image_block5']; ?>') no-repeat center; background-size:cover">
          <h5><a href="<?php echo $settings['image_block5_btn_link']; ?>"><?php echo $settings['image_block5_title']; ?></a></h5>
        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="city-card" style="background:url('<?php echo $settings['image_block6']; ?>') no-repeat center; background-size:cover">
           <h5><a href="<?php echo $settings['image_block6_btn_link']; ?>"><?php echo $settings['image_block6_title']; ?></a></h5>
      
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
	
	public static function css(){ 
	
	
	ob_start();
	?>
    
    <style> 
	
	
 
.city-card{position:relative;text-align:center;margin-bottom:30px;cursor:pointer;z-index:1;width:100%;height:230px; border-radius: 8px; }

.city-card:hover h5{bottom:42px;}

.city-card:hover p{visibility:visible;bottom:15px;opacity:1;}

.city-card::before{position:absolute;content:"";top:0px;left:0px;z-index:1;width:100%;height:100%;
background:-webkit-gradient(linear, left top, left bottom, color-stop(40%, rgba(0,0,0,0)), color-stop(90%, rgba(0,0,0,0.5)));background:linear-gradient(rgba(0,0,0,0) 40%, rgba(0,0,0,0.5) 90%);transition:all linear .3s;-webkit-transition:all linear .3s;-moz-transition:all linear .3s;-ms-transition:all linear .3s;-o-transition:all linear .3s;}

.city-card h5{position:absolute;bottom:30px;left:50%;z-index:1;width:100%;font-weight:500;text-align:center;text-transform:capitalize;-webkit-transform:translateX(-50%);transform:translateX(-50%);transition:all linear .3s;-webkit-transition:all linear .3s;-moz-transition:all linear .3s;-ms-transition:all linear .3s;-o-transition:all linear .3s;}
.city-card h5 a{color:#fff;}

.city-card p{position:absolute;bottom:0px;left:50%;z-index:1;width:100%;text-align:center;-webkit-transform:translateX(-50%);transform:translateX(-50%);color:#fff;font-size:14px;visibility:hidden;opacity:0;transition:all linear .3s;-webkit-transition:all linear .3s;-moz-transition:all linear .3s;-ms-transition:all linear .3s;-o-transition:all linear .3s;}

@media (min-width: 400px) and (max-width: 575px){
.city-card{width:370px;margin:0px auto 30px;}

}
@media (max-width: 575.98px) { 
.city-card{ height:100px; }
}
 
	</style>
    <?php
	
	$output = ob_get_contents();
		ob_end_clean();
		echo $output;
	
	 }	
	public static function js(){ return ""; }	
	
}

?>
