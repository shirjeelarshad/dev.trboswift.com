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
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }  global $wpdb, $CORE;   
    
?> 
<!-- MAIN SPINNER -->
<div class="text-center mt-5 pt-5" id="loading-spinnner"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>
<!-- END SPINNER -->
<!-- MAIN BODY WRAP -->
<div id="premiumpress-body" style="display:none;">
<div class="wrapper d-flex align-items-stretch ml-n4">
<?php if(isset($_GET['page'] ) && $_GET['page'] == "ASDADAD" ){ // && $_GET['page'] == "premiumpress" ||  $_GET['page'] == "listings"  ||  $_GET['page'] == "orders" ||  $_GET['page'] == "reports" ||  $_GET['page'] == "members" ?>
<ul class="list-unstyled components mb-5 nav flex-column nav-pills" id="jumplinks" style="display:none;"> </ul>
<?php }else{ ?>
<nav id="sidebar" class="d-none">
   <div class="custom-menu">
      <button type="button" id="sidebarCollapse" class="btn">
      <i class="fa fa-bars text-white"></i>
      <span class="sr-only">Toggle Menu</span>
      </button>
   </div>
   <h1></h1>
   <ul class="list-unstyled components mb-5 nav flex-column nav-pills" id="jumplinks">
      <li><a href="admin.php?page=premiumpress" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "premiumpress"){ echo "active show"; }  ?>" ><i class="fal fa-tachometer-alt"></i><?php echo __("Dashboard","premiumpress"); ?></a></li>
      <li>
         <a href="admin.php?page=orders" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "orders"){ echo "active show"; }  ?>" ><i class="fa fa-dollar-sign"></i><?php echo __("Orders","premiumpress"); ?></a>
         <ul class="child jumplinks-orders" style="display:none;"></ul>
      </li>
      
       <?php if( _ppt(array('user','cashout')) == 1 ){ ?>
          <li>
         <a href="admin.php?page=cashout" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "cashout"){ echo "active show"; }  ?>" ><i class="fal fa-comments-alt-dollar"></i><?php echo __("Cashout","premiumpress"); ?></a>
         <ul class="child jumplinks-cashout" style="display:none;"></ul>
      </li>
      <?php } ?>


       <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("cp")) && _ppt(array('lst','cpcashback')) == 1 ){ ?>
          <li>
         <a href="admin.php?page=cashback" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "cashback"){ echo "active show"; }  ?>" ><i class="fal fa-sync"></i><?php echo __("Cashback","premiumpress"); ?></a>
         <ul class="child jumplinks-cashout" style="display:none;"></ul>
      </li>
      <?php } ?>      
      
      <li>
         <a href="admin.php?page=listings" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "listings"){ echo "active show"; }  ?>" >
         <i class="<?php echo $CORE->LAYOUT("captions","icon"); ?>"></i><?php echo $CORE->LAYOUT("captions","2"); ?> </a>
         <ul class="child jumplinks-listings" style="display:none;"></ul>
      </li>
      
      <?php if( $CORE->LAYOUT("captions","listings") ){ ?>
      <li>
         <a href="admin.php?page=listingsetup" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "listingsetup"){ echo "active show"; }  ?>" ><i class="fal fa-layer-plus"></i><?php echo $CORE->LAYOUT("captions","1"); ?> <?php echo __("Settings","premiumpress"); ?> </a>
         <ul class="child jumplinks-listingsetup"></ul>
      </li>
      <?php } ?> 
       
       <?php if( $CORE->LAYOUT("captions","memberships") ){ ?>
      <li>
         <a href="admin.php?page=membershipsetup" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "membershipsetup"){ echo "active show"; }  ?>" ><i class="fal fa-users-class"></i><?php echo __("Memberships","premiumpress"); ?>  </a>
         <ul class="child jumplinks-membershipsetup"></ul>
      </li>
	  <?php } ?>
      
      
      
      <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("cp"))  ){ ?>
     <li>
         <a href="edit-tags.php?taxonomy=store&post_type=listing_type" class="nav-item nav-link" >
         <i class="fal fa-home"></i> <?php echo __("Stores","premiumpress"); ?></a>
         <ul class="child jumplinks-listings" style="display:none;"></ul>
      </li>
      <?php } ?>
      
      <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("ph"))){ ?>
        <li>
         <a href="admin.php?page=massimport" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "massimport"){ echo "active show"; }  ?>" ><i class="fal fa-download"></i><?php echo __("Mass Import","premiumpress"); ?></a>
         <ul class="child jumplinks-members" style="display:none;"></ul>
      </li>
      <?php } ?>
      
      
      
      <li>
         <a href="admin.php?page=members" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "members"){ echo "active show"; }  ?>" ><i class="fal fa-users"></i><?php echo __("Users","premiumpress"); ?></a>
         <ul class="child jumplinks-members" style="display:none;"></ul>
      </li>
      <li class="design-autocoin" >
         <a href="admin.php?page=design" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "design"){ echo "active show"; }  ?>" ><i class="fal fa-paint-brush"></i><?php echo __("Design","premiumpress"); ?></a>
         <ul class="child jumplinks-design"></ul>
      </li>
       
      
      <li>
         <a href="admin.php?page=email" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "email"){ echo "active show"; }  ?>" ><i class="fal fa-envelope"></i><?php echo __("Email","premiumpress"); ?></a>
         <ul class="child jumplinks-email"></ul>
      </li>
     
     
      <li>
         <a href="admin.php?page=cart" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "cart"){ echo "active show"; }  ?>" ><i class="fal fa-shopping-cart"></i><?php echo __("Checkout","premiumpress"); ?>  </a>
         <ul class="child jumplinks-cart"></ul> 
      </li>
       
      
      <li>
         <a href="admin.php?page=advertising" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "advertising"){ echo "active show"; }  ?>" ><i class="fal fa-bullseye"></i><?php echo __("Advertising","premiumpress"); ?></a>
         <ul class="child jumplinks-advertising"></ul>
      </li>
     
      <li>
         <a href="admin.php?page=settings" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "settings"){ echo "active show"; }  ?>" ><i class="fal fa-cog"></i><?php echo __("Settings","premiumpress"); ?></a>
         <ul class="child jumplinks-settings"></ul>
      </li>
      <?php if(isset($_GET['page']) && $_GET['page'] != "settings"){ ?>
      <li  style="position: absolute; bottom: 50px; width: 100%; border-top: 1px solid rgba(255, 255, 255, 0.1);" >
         <a href="admin.php?page=reports" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "logs"){ echo "active show"; }  ?>" ><i class="fal fa-signal-alt-3"></i><?php echo __("System Logs","premiumpress"); ?></a>
         <ul class="child jumplinks-reports" style="display:none;"></ul>
      </li>
      <?php } ?>
      
      
      
<?php

	// ADD-ON FOR NEW MENU ITEMS
		if(isset($GLOBALS['new_admin_menu']) && is_array($GLOBALS['new_admin_menu']) ){
			$sk = 3.5;
		 
			foreach($GLOBALS['new_admin_menu'] as $newmenu){ 
				foreach($newmenu as $key=>$menu){
				?>
                
                  <li>
         <a href="admin.php?page=<?php echo $key; ?>" class="nav-item nav-link" ><?php echo $menu['title']; ?></a>
         
      </li>
      
       <?php 
				 
					
					$sk = $sk  + 0.1;
				}
			}
		}	

?>
      
      
      <li  style="position: absolute; bottom: 0px;  width: 100%;">
         <a href="admin.php?page=docs" class="nav-item nav-link <?php if(isset($_GET['page']) && $_GET['page'] == "docs"){ echo "active show"; }  ?>" ><i class="fal fa-book"></i><?php echo __("Docs","premiumpress"); ?> - V.<?php echo THEME_VERSION; ?></a>
         <ul class="child jumplinks-docs"></ul>
      </li>
   </ul>
</nav>
<?php } ?>

<div id="content" class="position-relative"  style="max-width:100%">
<?php if(isset($_GET['page']) && $_GET['page'] != "premiumpress" && !isset($_GET['eid']) && !isset($_GET['tid']) ){ ?>
<a href="<?php echo home_url(); ?>/?reset=1" class="position-absolute small" target="_blank" style="top:15px; right:10px;"><?php echo __("Visit Website","premiumpress"); ?> <i class="fa fa-long-arrow-right ml-2"></i></a>
<?php } ?>
<!-- SAVING SPINNER -->
<div id="saving-spinner" style="display:none;">
   <div class="alert alert-primary alert-dismissible fade show m-5" role="alert">
      <span class="alert-inner--icon">                            
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      </span>
      <span class="alert-inner--text"><strong><?php echo __("Saving Your Changes","premiumpress"); ?></strong> - <?php echo __("This may take a few minutes, please wait...","premiumpress"); ?></span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">x</span>
      </button>
   </div>
</div>

<?php 

if(get_option('ppt_expired') == "1"){ ?>
<div class="bg-light p-4 m-4" style="border-top:5px solid #e53f4f;">

<i class="fa fa-download float-left fa-4x mr-4"></i>

<h4>Your AutoCoin updates have expired - Contact with <a href="mailto:rancoded.it@gmail.com">Nuralam</a> </h4>

<p>Access to theme updates and the support have been disabled.</p>

</div>
<?php } ?>