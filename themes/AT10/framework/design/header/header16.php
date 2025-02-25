<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header16',  'data') );
add_action( 'header16',  		array('block_header16', 'output' ) );
add_action( 'header16-css',  	array('block_header16', 'css' ) );

class block_header16 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header16'] = array(
			"name" 	=> "Style 16",
			"image"	=> "header16.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 12,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header16", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?><header class="elementor_header header16 logo-lg b-bottom no-sticky bg-primary">
        
        
                 <?php 
		 
		 $settings['topmenu_bg'] = "text-light bb-light";
		 _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
    
   
 <div class="container <?php if($settings['topmenu_show'] == "yes"){ ?>py-4 <?php }else{ ?>py-3 <?php } ?> px-0">
    <div class="row no-gutters">
    
    
      <div class="col-12 col-sm-6 col-md-3 text-left">
      
      <a class="navbar-brand mt-n2" href="<?php echo home_url(); ?><?php if(defined('WLT_DEMOMODE')){ ?>/?reset=1<?php } ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
      </a>
      
      
      <button class="navbar-toggler menu-toggle tm border-0 text-light display-mobile hide-ipad hide-desktop float-right"><span class="fal fa-bars"></span></button>
      
      </div>
      
      <div class="col-lg-2 col-md-3 font-weight-bold text-uppercase  hide-ipad hide-mobile ">
      
         <?php if(THEME_KEY == "cp"){  ?>
           
            <div class="mt-3"><a href="<?php echo _ppt(array('links','stores')); ?>" class="text-light"><i class="fal fa-home mr-2"></i> <?php echo __("All Stores","premiumpress") ?></a></div>
            
      <?php }else{ ?>
      
       <div class="mt-3"><a href="<?php echo _ppt(array('links','blog')); ?>" class="text-light"><i class="fal fa-rss mr-2"></i> <?php echo __("Our Blog","premiumpress") ?></a></div>
           
      <?php } ?>
      
      </div>
      
      <div class="col-sm-6 col-md-4 col-lg-3 hide-mobile">
      
           <form action="<?php echo home_url(); ?>" class="search position-relative w-100">
              <div class="input-group">
                <input type="text" class="form-control rounded typeahead " name="s" placeholder="<?php echo __("Search","premiumpress"); ?>..." autocomplete="off">
              </div>
              <button class="btn position-absolute text-muted" style="top:3px; right:0px;" type="submit"><i class="fal fa-search"></i></button>
            </form>
                
      
      
      </div> 
      
      
      <div class="col-md-5 col-lg-4 text-right hide-ipad hide-mobile">
      
      
      <div class="d-flex justify-content-between">
    		
            
             <?php if(THEME_KEY == "sp"){  ?>
               <a href="<?php echo _ppt(array('links','cart')); ?>" class="btn btn-md shadow-sm btn-secondary mx-3 btn-block font-weight-bold"><?php echo __("My Basket","premiumpress"); ?></a> 
          
             <?php }else{ ?>
            <a href="<?php echo _ppt(array('links','add')); ?>" class="btn btn-md shadow-sm btn-secondary mx-3 btn-block font-weight-bold"><?php echo __("Add New","premiumpress"); ?></a> 
            
            <?php } ?>
            
            <?php if( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )   ){ ?>
            <span>&nbsp;</span>    
            
          <?php if(!$userdata->ID){ ?>
            
            <a href="<?php echo wp_login_url(); ?>" class="btn btn-md shadow-sm btn-light text-dark btn-block font-weight-bold"><?php echo __("Login","premiumpress") ?></a>
            
            <?php }else{ ?>
            
            <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="btn btn-md shadow-sm btn-light text-dark btn-block font-weight-bold"><?php echo __("My Account","premiumpress") ?></a>
            
            <?php } ?>         
            
              
             
             <?php } ?>
             
        </div>
             
             
          </div>
 
         
     
  
  
  </div>
          
        
      </div>
   
   
   
  <?php 
    
   $settings['seperator'] = 1;
   $settings['submenu_bg'] = "bg-white shadow-sm navbar-light";
   
   _ppt_template( 'framework/design/header/parts/header-submenu' ); ?> 
   
</header><?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>
        <style>
.header16 .navbar-light .navbar-nav .nav-link {
    color: #222;
    font-weight: bold;
}
		</style>
        <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>