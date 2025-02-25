<?php
 
 
add_filter( 'ppt_blocks_args', 	array('block_header7a',  'data') );
add_action( 'header7a',  		array('block_header7a', 'output' ) );
add_action( 'header7a-css',  	array('block_header7a', 'css' ) );
add_action( 'header7a-js',  	array('block_header7a', 'js' ) );

class block_header7a {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header7a'] = array(
			"name" 	=> "Style 7 (black)",
			"image"	=> "header7.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 7,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header7a", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 //$settings['btn'] = "yes";
		 //$settings['btn_show'] = "no";
		 $settings['topmenu_bg'] = "text-light bb-light bg-black";
		    
 
		ob_start();
		
		?><header style="border-bottom:none !important" class="elementor_header header7a bg-white b-bottom <?php if(!isset($GLOBALS['flag-home'])){ ?>shadow-sm<?php } ?>">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg pb-0 pr-2 pr-md-0">
    <div class="container p-0"> <a class="navbar-brand" href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
    
    </a>
    
   <?php if($userdata->ID){ ?> <a href="<?php echo home_url(); ?>/sell-a-car/"   class="btn btn-rounded-25 btn-sm btn-primary text-white py-0 px-2" ><span class=" text-white"> <?php echo __("SELL YOUR CAR","premiumpress"); ?></span></a> 
    
    <div class="left-side-menu"> 
    <a href="<?php echo home_url(); ?>/sell-a-car/"   class=" pl-2 small" > For Sellers <span class="h3 text-primary">→</span></a> 
    <a href="<?php echo home_url(); ?>/buy-a-car/"   class=" px-2 small" ><span > <?php echo __("For Buyers","premiumpress"); ?></span></a>
    </div>
    
    
    
    <?php } else{ ?>
    
    <a href="javascript:void(0);" onclick="processRegister();"   class="btn btn-rounded-25 btn-sm btn-primary text-white py-0 px-2" ><span class=" text-white"> <?php echo __("SELL YOUR CAR","premiumpress"); ?></span></a> 
    
    <div class="left-side-menu"> 
    <a href="javascript:void(0);" onclick="processRegister();"   class=" pl-2 small" > For Sellers <span class="h3 text-primary">→</span></a> 
    <a href="javascript:void(0);" onclick="processRegister();"   class=" px-2 small" ><span > <?php echo __("For Buyers","premiumpress"); ?></span></a>
    </div>
    
    <?php } ?>
    
    
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar"> <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?> </div>
      
      
      <?php if($settings['btn_show'] == "yes"){ ?>
      <div class="align-items-center ml-4">
      
       <?php if(!$userdata->ID){ ?>
          <div class="list-inline-item">
          <a href="javascript:void(0);" onclick="processRegister();"  class="btn btn-sm py-0 px-2 btn-rounded-25 btn-secondary text-white" > <?php echo __("Sign Up","premiumpress"); ?></a>         
           </div>
          
           
          <?php }else{ ?>
          <div class="list-inline-item d-none d-md-block mr-0"> <a class="btn btn-rounded-25 btn-secondary text-white" href="<?php echo _ppt(array('links','myaccount')); ?>"> <?php echo __("My Account","premiumpress"); ?></a> </div>
          <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
          <?php } ?>
          
        
      </div>
      <?php }else{ ?>
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
      <?php } ?>
    </div>
  
  </nav>
  <div class="container d-none d-md-block">
  <span class=" small text-secondary font-weight-bold " style="letter-spacing: 3.2px;" >CANADA'S FIRST AUCTION MARKETPLACE </span>
  </div>
    
  
  <style>
  
 a.tidio-5hhiig{
    display: none!important;
}

.left-side-menu a{
color: #454444;
text-decoration: none;
font-weight: bold;
line-height: 35px;
font-size:14px;
}

.left-side-menu a:hover {
    color: #000000;
    text-decoration: none;
    font-weight: bold;
}

/*Desktop*/

@media (min-width:1000px){
    .col-desk-5{
    width:20%;
    flex: 0 0 20%;
}
}

@media (min-width: 575.98px ){
 .navbar-brand .img-fluid {
    max-width: 200px!important;
}



  .text-12{
      font-size:12px !important;
  }
  
 

}


/*Mobile*/
@media (max-width: 575.98px) {
 .footer img, .navbar-brand img {
    max-width: 180px !important;
  }
  
    .text-12{
      font-size:11px !important;
  }
  
  

  
}

.elementor_mainmenu .nav-item a {
    text-transform: unset !important;
    text-decoration: unset !important; 
    font-size: unset !important;
}


</style>
  
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
		
		public static function js(){ 
		return "";
		}
			
		public static function css(){ 
		return "";
		}	
}

?>