<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata, $settings;
 
?>

<nav class="elementor_mainmenu submenu-icon py-0 navbar-bottom navbar navbar-expand-md navbar-dark d-none d-lg-block bg-dark border-top py-2 <?php if(!isset($GLOBALS['flag-home'])){ ?>border-bottom<?php } ?>">
  <div class="container">
    <div class="collapse navbar-collapse main-menu" id="header2menubar">
      <?php
		ob_start();
		?>
      <li class="nav-item" style="border-left:none;" > <a href="<?php echo home_url(); ?>" class="nav-link pl-0 border-left-none"><i class="fal fa-home font-weight-bold"></i> </a> </li>
      <?php 
			
			$addon = ob_get_clean();
            ob_start();	
            echo do_shortcode('[MAINMENU class="navbar-nav " style=1]');
            $menu = ob_get_clean();                  
            echo str_replace('navbar-nav ">', 'navbar-nav ">'.$addon, $menu);
            
			?>
    </div>
    <div class="d-flex align-items-center ml-3 d-none d-lg-block">
      <?php
			 
			 if(THEME_KEY == "sp"){
			 
			 _ppt_template( 'framework/design/parts/cart' ); 
			 
			 }else{		 
			 
			  _ppt_template( 'framework/design/parts/btn' ); 
			  
			 } 
			  
			  ?>
    </div>
  </div>
</nav>
