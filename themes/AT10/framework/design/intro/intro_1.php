<?php
 
add_filter( 'ppt_blocks_args',  	array('block_intro_1',  'data') );
add_action( 'intro_1',  		array('block_intro_1', 'output' ) );
add_action( 'intro_1-css',  	array('block_intro_1', 'css' ) );
add_action( 'intro_1-js',  	array('block_intro_1', 'js' ) );

class block_intro_1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['intro_1'] = array(
			"name" 	=> "Intro 1",
			"image"	=> "intro1.jpg",
			"cat"	=> "intro",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "intro") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "intro") ),				
					"desc" 				=> "",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					
					"title_pos" => "center",
					
					"hero_size" => "hero-large",
					"hero_image" => DEMO_IMG_PATH."/blocks/intro/intro1_bg.jpg",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "3",				
					"btn_size" 			=> "btn-lg",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "before",
					"btn_font" 			=> "",
					"btn_txt" 			=> "Search",
					"btn_link" 			=> "[link-search]",
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-dark",					
					"btn_margin" 		=> "mt-4", 

					// BUTTON					
					"btn2_show" 			=> "yes",						
					"btn2_style" 		=> "4",				
					"btn2_size" 			=> "btn-lg",
					"btn2_icon" 			=> "",				
					"btn2_icon_pos" 		=> "before",
					"btn2_font" 			=> "",
					"btn2_txt" 			=> "Join Now",
					"btn2_link" 			=> "[link-add]",
					"btn2_bg" 			=> "light",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4", 				
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings, $userdata;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("intro_1", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		 
		 
		/* DEFAULTS */
		if($settings['hero_image'] == ""){
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "intro_1");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
 
		ob_start();
		
		
		?>

<header class="elementor_header header7 bg-white b-bottom">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container"> <a class="navbar-brand" href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar"> <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?> </div>
      
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
  
    </div>
  </nav>
</header>

<section class="hero-demo hero-text1 position-relative hero-default <?php echo $settings['hero_size']; ?> text-<?php echo $settings['hero_txtcolor']; ?> text-<?php echo $settings['title_pos']; ?>">
  <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
  <div class="bg-overlay-grey"></div>
  <div class="hero_content z-10">
    <div class="container">
      <div class="row justify-content-start">
        <div class="col-12">
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
          <?php _ppt_template( 'framework/design/parts/btn' ); ?>          
         <div class="icon-wrap w-100 hide-mobile text-<?php echo $settings['title_pos']; ?>"><i class="fal fa-chevron-double-down fa-moving-btn fa-3x opacity-5 text-<?php echo $settings['title_pos']; ?>"></i></div>
 
        </div>
      
      </div> 
      
    </div>
     
  </div>
    

<script>

jQuery(document).ready(function(){ 

	 
	jQuery('.elementor_header').addClass('fixed-top bg-transparent-none').removeClass('bg-dark').addClass('bg-white');
	
	<?php if($settings['hero_txtcolor'] == "light"){ ?>
	jQuery('.elementor_mainmenu').removeClass('navbar-light').addClass('navbar-dark');
	<?php }else{ ?>
	jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
	<?php } ?>
	
	jQuery('.elementor_topmenu').addClass('fade');
	
	
	jQuery('.header2 .elementor_submenu, .header12 .elementor_submenu').attr('style','display: none !important');
 

});
 

jQuery(window).on('load', function(){
 
	jQuery(window).on('scroll', function() {
		if(jQuery(this).scrollTop() > 150) {
		
			jQuery('.elementor_header').removeClass('bg-transparent-none');
			jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
			
		} else {
		
			jQuery('.elementor_header').addClass('bg-transparent-none');
			<?php if($settings['hero_txtcolor'] == "light"){ ?>
			jQuery('.elementor_mainmenu').removeClass('navbar-light').addClass('navbar-dark');
			<?php }else{ ?>
			jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
			<?php } ?>
			
		}
	}); 

});
jQuery(document).ready(function(){ 

 jQuery(window).resize(checkSize3);

});

	function checkSize3(){
		
		 var wins = jQuery(window).width(); 
		 
		  				 
			if (wins  < 767){
				
			 jQuery('header.fixed-top').removeClass('fixed-top').removeClass('bg-transparent-none').addClass('bg-dark');
				 			 
	
			}else if ( wins > 767){
	
				 jQuery('header.bg-dark').addClass('fixed-top').addClass('bg-transparent-none').removeClass('bg-dark');
			 
				
			}	 
		 
		 
	}

</script> 

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
	 
.navbar-dark .navbar-nav .nav-link {
    color: #fff;
    opacity: 0.7;
}
.hero_content p {
    max-width: 580px;
    display: inline-block;
}
   /* Arrow Animation */
    @-webkit-keyframes new_icon {
        0% { top: 0px; }
        100% { top: 15px;  }
    }
    @-moz-keyframes new_icon {
        0% { top: 0px; }
        100% { top: 15px;  }
    }
.fa-moving-btn {
    position: relative;
    animation: new_icon 1s linear 0s infinite alternate;
    -webkit-animation: new_icon 2s linear 0s infinite alternate;
	
}
.icon-wrap { position:absolute;	bottom:-100px;   }

</style>
		<?php $output = ob_get_contents();  ob_end_clean();
		echo $output;	
	
	}		
	public static function js(){ global $CORE;
		ob_start();
	  _ppt_template( 'framework/design/hero/parts/js' );  
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>
