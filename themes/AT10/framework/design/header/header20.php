<?php
 
 
add_filter( 'ppt_blocks_args', 	array('block_header20',  'data') );
add_action( 'header20',  		array('block_header20', 'output' ) );
add_action( 'header20-css',  	array('block_header20', 'css' ) );
add_action( 'header20-js',  	array('block_header20', 'js' ) );

class block_header20 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header20'] = array(
			"name" 	=> "Style 20",
			"image"	=> "header20.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 20,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header20", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		 $settings['topmenu_bg'] = "bg-white text-dark border-bottom";
		    
 
		ob_start();
		
		?>
        
        
 
        
<header class="elementor_header header20 logo-sm bg-white border-bottom">
   
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container-fluid">
    
    <a class="navbar-brand" href="<?php echo home_url(); ?>">
	 <?php echo $CORE->LAYOUT("get_logo","light");  ?>
	 <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
     </a>
     
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar">
	  <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?>
      
      <ul class="list-inline pt-0 mb-0 float-right seperator userloginlist ">
        <?php if(!$userdata->ID){ ?>
          <li class="list-inline-item pr-3">
          <a href="javascript:void(0);" onclick="processLogin();"> <?php echo __("Sign In","premiumpress"); ?></a>         
           </li>
           <?php if( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )   ){ ?>
          <li class="list-inline-item">
          <a href="<?php echo wp_registration_url(); ?>"> <?php echo __("Register","premiumpress"); ?></a>         
           </li>
           <?php } ?>
           
          <?php }else{ ?>
          <li class="list-inline-item">
          
          <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="tm">
   <img class="rounded-circle img-fluid lazy" data-src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user" style="max-width:50px;"> 
    </a>
           </li>
          <?php } ?>
      
      </ul>
      
      </div>
      
	  <?php if($settings['btn_show'] == "yes"){ ?>
      <div class="align-items-center">
        <?php _ppt_template( 'framework/design/header/parts/header-button' ); ?>
      </div>
      <?php }else{ ?>
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
      <?php } ?>
      
    </div>
  </nav>
  
  
</header>
 
<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
		
		public static function js(){ 
		return "";
		}
		
		public static function css(){ 
		 
		ob_start(); ?>
 <style>
.elementor_mainmenu .nav-item a {
    text-transform: unset !important;
    text-decoration: unset !important;
    font-size: 14px;
}
.elementor_mainmenu .navbar-nav .nav-link {
    padding: 0 15px;
}
@media(min-width:997px){
.navbar-brand {

border-right: 1px solid #dee2e6!important;
    padding-right: 40px;
}
}
.userloginlist { padding-right:30px; padding-left:10px; } 
.userloginlist a { font-size: 14px;  color: #222; font-weight:bold; margin-top:-4px; }


.userloginlist img { max-width:40px;  max-height:40px; }

</style>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		
}

?>
