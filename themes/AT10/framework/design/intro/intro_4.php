<?php
 
add_filter( 'ppt_blocks_args',  	array('block_intro_4',  'data') );
add_action( 'intro_4',  		array('block_intro_4', 'output' ) );
add_action( 'intro_4-css',  	array('block_intro_4', 'css' ) );
add_action( 'intro_4-js',  	array('block_intro_4', 'js' ) );

class block_intro_4 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['intro_4'] = array(
			"name" 	=> "Intro 4",
			"image"	=> "intro4.jpg",
			"cat"	=> "intro",
			"order" => 3,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=>  $CORE->LAYOUT("get_placeholder_text", array('title', "intro") ),				 
					"subtitle"			=> "",					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('desc', "intro") ),
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "mb-4",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					
					"title_pos" => "left",
					
					"hero_size" => "hero-large",
					"hero_image" => "https://premiumpress.com/_demoimagesv10/mj/style1/hero1.jpg",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "4",				
					"btn_size" 			=> "btn-xl",
					"btn_icon" 			=> "fa fa-search",				
					"btn_icon_pos" 		=> "before",
					"btn_font" 			=> "",
					"btn_txt" 			=> "Join Now",
					"btn_link" 			=> "[link-search]",
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-4", 

					// BUTTON					
					"btn2_show" 			=> "no",						
					"btn2_style" 		=> "4",				
					"btn2_size" 			=> "btn-lg",
					"btn2_icon" 			=> "",				
					"btn2_icon_pos" 		=> "before",
					"btn2_font" 			=> "",
					"btn2_txt" 			=> "asd asdasd",
					"btn2_link" 			=> "",
					"btn2_bg" 			=> "light",
					"btn2_bg_txt" 		=> "text-light",					
					"btn2_margin" 		=> "mt-4", 				
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings, $userdata;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("intro_4", "hero", $settings ) );
 
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
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "intro_4");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
			
		}	 
		/* DEFAULTS */
		if($settings['hero_image'] == ""){
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
 
	if($settings['title_pos'] == ""){ $settings['title_pos'] = "left"; }
	switch($settings['title_pos']){
	
		case "left": {
		$txtdir = "text-center text-md-left";
		} break;
		case "right": {
		$txtdir = "text-center text-md-right";
		} break;
		case "center": {
		$txtdir = "text-center";
		} break;	
	}
	
	// LANGUAGES
	$languages =  $CORE->GEO("get_languagelist",array()); 
 
	 
 
		ob_start();
		
		
		?>
<header class="elementor_header header7 bg-white b-bottom">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container"> <a class="navbar-brand" href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar">
        <ul class="navbar-nav">
        <?php if(!$userdata->ID){ ?>
          <li class="nav-item"> <a href="javascript:void(0);" onclick="processLogin();" class="nav-link"><?php echo __("Member Login","premiumpress"); ?></a> </li>
          <?php }else{ ?>
          <li class="nav-item"> <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="nav-link"><?php echo __("My Account","premiumpress"); ?></a> </li>
          <?php } ?>
        </ul>
        <?php if(is_array($languages) && !empty($languages)){ ?>
        <ul class="list-inline p-0 mb-0 float-right ">
          <li class="list-inline-item w dropdown hide-mobile"> <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag flag-<?php echo $CORE->GEO("get_language_icon",array());  ?>">&nbsp;</span></a>
            <div class="dropdown-menu mt-n2">
              <?php foreach($languages as $h){ ?>
              <a class="dropdown-item" href="<?php echo str_replace("design","designxxxx",$h['link']); ?>"><i class="<?php echo $h['icon']; ?> float-right mt-2"></i> <?php echo $h['name']; ?></a>
              <?php } ?>
            </div>
          </li>
        </ul>
        <?php } ?>
      </div>
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
    </div>
  </nav>
  </header>
  <section class="hero-demo hero-text1 position-relative hero-default hero-full text-<?php echo $settings['hero_txtcolor']; ?> text-<?php echo $settings['title_pos']; ?>">
    <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
    <div class="bg-overlay-grey"></div>
    <div class="hero_content z-10">
      <div class="container">
        <div class="row justify-content-start">
          <div class="col-12 col-lg-7 <?php echo $txtdir; ?>">
            <?php _ppt_template( 'framework/design/parts/title' );  ?>
            <?php if($userdata->ID){ ?>
            <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="btn btn-border-2 font- btn-rounded-25 btn-xl btn-outline-light  mt-0  btn-icon icon-before"> <i class="mr-1 fa fa-user"></i> <span><?php echo __("My Account","premiumpress"); ?></span> </a>
           
           
            <?php }else{ ?>
           <a href="javascript:void(0);" onclick="processRegister();" class="btn btn-border-2 font- btn-rounded-25 btn-xl btn-outline-light  mt-0  btn-icon icon-before"> <i class="mr-1 fa fa-user"></i> <span><?php echo __("Sign-up Now","premiumpress"); ?></span> </a>
            <?php } ?>
            
            
            
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




#mobile-bottom-bar { display:none !important; }

.hero-intro-search { 	max-width:600px; margin-top:20px; }	
		
.homepage--search {
    border: none;
    background: #fafafa;
    border-radius: 5px;
    font-size: 18px;
    color: #888;
    padding: 0 20px;
    height: 50px;
    width: 100%;
	padding-left:60px;

 
}

.hero-intro-search .btn-primary {
right: 0px;
    top: 0px;
    height: 50px;
    position: absolute;
    border-bottom-left-radius: 0px;
	 border-top-left-radius: 0px;
}

/* mobile */
@media (max-width: 575.98px) { 
.hero-intro-search .btn-primary {

position:relative; width:100%; margin-top:30px;
 border-bottom-left-radius: 8px;
	 border-top-left-radius: 8px;
	 right:auto;

}

}
	 
.navbar-dark .navbar-nav .nav-link {
    color: #fff;
    opacity: 0.7;
}
 
 
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
