<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header14',  'data') );
add_action( 'header14',  		array('block_header14', 'output' ) );
add_action( 'header14-css',  	array('block_header14', 'css' ) );

class block_header14 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header14'] = array(
			"name" 	=> "Style 14",
			"image"	=> "header14.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 12,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header14", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 
		    
 
		ob_start();
		
		?>
<header class="elementor_header header14 bg-primary b-bottom">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <div class="container py-3">
    <div class="row">
      <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0">
      
      <a class="navbar-brand" href="<?php echo home_url(); ?><?php if(defined('WLT_DEMOMODE')){ ?>/?reset=1<?php } ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> <?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
      
      
      <button class="navbar-toggler menu-toggle tm border-0 text-light"><span class="fal fa-bars"></span></button>
      
      </div>
      <div class="col-lg-5 col-md-8">
        <form action="<?php echo home_url(); ?>" class="search">
          <div class="input-group">
            <input type="text" class="form-control rounded-0 typeahead" name="s" placeholder="<?php if(THEME_KEY == "cp"){ echo __("Store name or keyword..","premiumpress"); }else{ echo __("Keyword..","premiumpress"); } ?>" autocomplete="off">
          </div>
          <button class="btn position-absolute text-muted" style="top:10px; right:20px;" type="submit"><i class="fal fa-search"></i></button>
        </form>
      </div>
      <div class="col-md-4 px-0 hide-ipad hide-mobile">
        <div class="row no-gutters ">
          <div class="col-md-6 text-center">
            <?php if(THEME_KEY == "cp"){  ?>
           
            <div class="mt-3"><a href="<?php echo _ppt(array('links','stores')); ?>" class="text-light"><i class="fal fa-home"></i> <?php echo __("All Stores","premiumpress") ?></a></div>
           
           <?php   }elseif( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )   ){ ?>
           
            <?php if(!$userdata->ID){ ?>
            <div class="mt-3"><a href="<?php echo wp_login_url(); ?>" class="text-light"><?php echo __("Member Login","premiumpress") ?></a></div>
            <?php }else{ ?>
            <div class="mt-3"><a href="<?php echo _ppt(array('links','myaccount')); ?>" class="text-light"><?php echo __("My Account","premiumpress") ?></a></div>
            <?php } ?>
            
            <?php } ?>
          </div>
 
          
          <div class="col-md-6 text-right">
            <div class="mt-1">
              <?php _ppt_template( 'framework/design/parts/btn' ); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		 
		ob_start(); ?>
<style>
.header14 .input-group {
	padding: 5px;
	background: #00000021;
	border-radius: 8px;
}
</style>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>
