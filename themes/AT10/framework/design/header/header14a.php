<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header14a',  'data') );
add_action( 'header14a',  		array('block_header14a', 'output' ) );
add_action( 'header14a-css',  	array('block_header14a', 'css' ) );

class block_header14a {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header14a'] = array(
			"name" 	=> "Style 14a",
			"image"	=> "header14a.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"order" => 12,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header14a", "header", $settings ) );
 
		  
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
<header class="elementor_header header14a bg-white border-bottom">
  <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  
  <div class="container py-3">
    <div class="row">
      <div class="col-lg-4 col-md-4 text-center text-md-left mb-4 mb-md-0"> <a class="navbar-brand" href="<?php echo home_url(); ?><?php if(defined('WLT_DEMOMODE')){ ?>/?reset=1<?php } ?>"><?php echo $CORE->LAYOUT("get_logo","dark");  ?> </a>
        <button class="navbar-toggler menu-toggle tm border-0 text-dark show-ipad show-mobile"><span class="fal fa-bars"></span></button>
      </div>
      <div class="col-md-8 col-lg-5">
        <form action="<?php echo home_url(); ?>" class="search">
          <div class="input-group">
            <input type="text" class="form-control-lg w-100 typeahead" name="s" placeholder="<?php if(THEME_KEY == "cp"){ echo __("Store name or keyword..","premiumpress"); }else{ echo __("Keyword..","premiumpress"); } ?>" autocomplete="off">
          </div>
          <button class="btn position-absolute text-muted" style="top:10px; right:20px;" type="submit"><i class="fal fa-search"></i></button>
        </form>
      </div>
      <?php if($settings["btn_show"] == "yes"){
	  
	  $settings["btn_size"] = "btn-lg";
	  ?>
      <div class="col-lg-3 text-right hide-ipad hide-mobile">
     
     
<?php if($settings['extra_type'] == "icons"){ ?>



          <?php if(!$userdata->ID){ ?>
            <a href="javascript:void(0);" onclick="processLogin();" class="tm">
            <img class="rounded-circle img-fluid lazt" data-src="<?php echo get_template_directory_uri(); ?>/framework/images/avatar/none.png" alt="user" style="max-width:50px;"> 
            </a>
            <?php }else{ ?>
            <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="tm">
            
            <img class="rounded-circle img-fluid lazy" data-src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user" style="max-width:50px;"> 
           
           </a>
            <?php } ?>           
            
<?php }else{ ?>
 <?php _ppt_template( 'framework/design/parts/btn' ); ?>
<?php } ?>
         
         
      </div>
      <?php } ?>
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
.header14a .input-group {
	padding: 2px;
	background: #efefef;
	border-radius: 8px;
	font-size:30px;
}
.header14a input {
	border: 0px;
	background: none;
}
</style>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>
