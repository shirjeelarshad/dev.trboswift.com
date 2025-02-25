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

global $CORE, $settings, $userdata;
 
// LANGUAGES
$languages =  $CORE->GEO("get_languagelist",array());

// CURRENCY
$currency =  $CORE->GEO("get_currencylist",array());
 


?>

<ul class="list-inline mt-3 small-list">
  <?php if( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )  && $settings['btn_myaccount'] == "yes" ){ ?>
  <li class="list-inline-item w usericon hide-mobile"> 
  
 
    <?php if(!$userdata->ID){ ?>
     <a href="javascript:void(0);" onclick="processLogin();" class="tm">
   <img class="rounded-circle img-fluid" src="<?php echo get_template_directory_uri(); ?>/framework/images/avatar/none.png" alt="user" style="max-width:50px;"> 
    </a>
    <?php }else{ ?>
     <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="tm">
  <img class="rounded-circle img-fluid lazy" data-src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user" style="max-width:50px;"> 
    </a>
    <?php } ?>
    
    
    
    </li>
  <?php } ?>
  <?php if($settings['btn_search'] == "yes"){  ?>
  <li class="list-inline-item w hide-mobile"> <a href="<?php echo home_url(); ?>/?s=" class="tm"><i class="fal fa-search"></i></a> </li>
  <?php } ?>
  <?php if(is_array($currency) && !empty($currency) && $settings['btn_currency'] == "yes" ){ ?>
  <li class="list-inline-item dropdown w  hide-mobile"> <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-dollar-sign"></i></a>
    <div class="dropdown-menu">
      <?php  foreach($currency as $h){ ?>
      <a class="dropdown-item" href="<?php echo $h['link']; ?>"> <span class="text-muted float-right"><?php echo $h['icon']; ?></span> <?php echo $h['name']; ?></a>
      <?php } ?>
    </div>
  </li>
  <?php } ?>
  <?php if(is_array($languages) && !empty($languages) && $settings['btn_language'] == "yes"  ){ ?>
  <li class="list-inline-item w dropdown hide-mobile"> <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe"></i></a>
    <div class="dropdown-menu">
      <?php foreach($languages as $h){ ?>
      <a class="dropdown-item" href="<?php echo $h['link']; ?>"><i class="<?php echo $h['icon']; ?> float-right mt-2"></i> <?php echo $h['name']; ?></a>
      <?php } ?>
    </div>
  </li>
  <?php } ?>
  <?php if(defined('WLT_CART')){ ?>
  <li class="list-inline-item hide-mobile"> <a href="<?php echo _ppt(array('links','cart')); ?>" class="tm"><i class="fal fa-shopping-basket"></i></a> </li>
  <?php } ?>
  <?php if($settings['btn'] == "yes"){ 
			
			if($settings['btn_bg_txt'] == ""){ $settings['btn_bg_txt'] ="text-light"; }
			if($settings['btn_bg'] == ""){ $settings['btn_bg'] ="btn-primary"; }
			if($settings['btn_txt'] == ""){ $settings['btn_txt'] = "<i class='fa fa-plus'></i> add new";  }
			 
			
			?>
  <li class="list-inline-item hide-mobile">
    <?php _ppt_template( 'framework/design/parts/btn' ); ?>
  </li>
  <?php  } ?>
  <li class="list-inline-item ">
    <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars"></span></button>
    </button>
  </li>
</ul>
