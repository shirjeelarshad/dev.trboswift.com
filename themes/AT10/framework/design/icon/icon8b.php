<?php
 
add_filter( 'ppt_blocks_args', 	array('block_icon8b',  'data') );
add_action( 'icon8b',  		array('block_icon8b', 'output' ) );
add_action( 'icon8b-css',  	array('block_icon8b', 'css' ) );
add_action( 'icon8b-js',  	array('block_icon8b', 'js' ) );

class block_icon8b {

	function __construct(){}		

	public static function data($a){  global $CORE; 
  
		$a['icon8b'] = array(
			"name" 	=> "Style 8 (b) - Carousel",
			"image"	=> "icon8b.jpg",
			"cat"	=> "icon",
			"order" => 8,
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("icon8b", "icon", $settings ) ); 
  
	 
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
		
		"fas fa-layer-group",
		"fas fa-tachometer-alt",
		"fas fa-file-signature",
		
		"fas fa-layer-group",
		"fas fa-tachometer-alt",
		"fas fa-file-signature",

		"fas fa-layer-group",
		"fas fa-tachometer-alt",
 		
		
		);
		
		$settings["title_pos"] = "center";
		 
	  $randomID = rand(0,9999);
	 
	ob_start();
	?><section id="icon8-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="<?php echo $settings['section_w']; ?>">
   <div class="row m-0 p-0">
   <?php if($settings['title_show'] == "yes"){ ?>
   <div class="pl-2 text-left mb-2 font-weight-bold">
   
      <?php _ppt_template( 'framework/design/parts/title' ); ?>      
       
   </div>
   <?php } ?>
   
   <div class="col-md-12 ">
   <div  class="owl-carousel owl-theme">      
      
         <?php $i=1; while($i < 9){ 
		 
		 if($i > 8 && $settings['icon'.$i] == ""){ $i++; continue; }
		 
		 ?>
         <div class="item">
            <div class="card p-0 my-4 <?php if($settings['icon'.$i.'_type'] != "image"){ ?>py-3<?php } ?> border-0">
               <div class="card-body p-0 text-center card-hover ">
               <a href="<?php if($settings['icon'.$i.'_link'] == ""){ echo "#"; }else{ echo $settings['icon'.$i.'_link']; } ?>" class="text-decoration-none">
                  <div class="row m-0 p-0">
                  
                     <div class="col-12 col-md-12 m-0 p-0">
                       
                       
                        <?php if($settings['icon'.$i.'_type'] == "image"){ ?>
                       <img src="<?php echo $settings['icon'.$i.'_image']; ?>" class="img-fluid px-md-3 px-sm-0 " alt="<?php echo $settings['icon'.$i.'_title']; ?>" />                      
					   <?php }else{ ?>
                    	<i class="<?php if($settings['icon'.$i] == ""){ echo $d_icons[$i]; }else{  echo strtolower($settings['icon'.$i]); } ?> text-<?php echo $settings['icon'.$i.'_iconcolor']; ?>  fa-3x mb-4"></i>
                    	<?php } ?>
                    
                    
                     </div>
                     
                     <div class="col-12  col-md-12">
<h5 data-elementor-setting-key="icon<?php echo $i; ?>_title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-<?php echo $settings['icon'.$i.'_txtcolor']; ?>"><?php if($settings['icon'.$i.'_title'] == ""){ echo $CORE->LAYOUT("get_placeholder_text", array('title', $i) ); }else{ echo $settings['icon'.$i.'_title']; } ?></h5>
                        
                         
                     </div>
                  </div>
               </div>
               </a>
            </div>
         </div>
         <?php $i++; } ?>
         
         </div>
         
         <?php if($settings['btn_show'] == "yes"){ ?>
         <div class="col-12 text-center mt-4">
               <?php _ppt_template( 'framework/design/parts/btn' ); ?>
         </div>
         <?php } ?> 
         
      </div>
   </div>
</section>
<script> 
jQuery(document).ready(function(){ 
 	
		 
	var owl = jQuery("#icon8-carousel-<?php echo $randomID; ?> .owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,
		 
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        },        
    }); 
	
	owl.owlCarousel();
 
  jQuery("#icon8-carousel-<?php echo $randomID; ?> .next").click(function(){
    owl.trigger('next.owl.carousel');
  })
  jQuery("#icon8-carousel-<?php echo $randomID; ?> .prev").click(function(){
    owl.trigger('prev.owl.carousel');
  })
	
	
	});		 
</script>

<?php
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