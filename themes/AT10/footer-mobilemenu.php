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
if (!defined('THEME_VERSION')) {	footer('HTTP/1.0 403 Forbidden'); exit; }

global $userdata, $CORE;

$showmenu = _ppt('footer_mobile_menu');

if( ( $showmenu == "" || $showmenu == 1 ) && is_array(_ppt('mobilemenucaption'))  ){

?> 

<div class="footer-nav-area hidepage" style="display:none;" id="mobile-bottom-bar">
      <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
          <ul class="h-100 list-unstyled d-flex align-items-center justify-content-between pl-0">
          
          <?php  $i=1; 
		  
		  $names = _ppt('mobilemenucaption');
		  $icons = _ppt('mobilemenuicon');
		  $links = _ppt('mobilemenulink');
		  
		  while($i < 6){
		  
		   		$name = "";
		  
		  		if(isset($names[$i])){	 $name = $names[$i]; }
			  
			  	$icon = $icons[$i];
			  	$link = $links[$i];
			
			  
			  if(_ppt(array('lang','switch')) == "1" && is_array(_ppt('languages')) && !empty(_ppt('languages')) ){ 
			
				$lang = strtolower($CORE->_language_current());
				
				if(_ppt(array('mobilemenucaption_'.$lang, $i)) != "" && $lang != "us"){
				
					$name = _ppt(array('mobilemenucaption_'.$lang, $i));
					
				}
			
			}
		  
		  ?>
          
          
          <?php if($link == "[menu]"){ ?>
          
          <li>
           <a href="javascript:void(0);" class="menu-toggle"><i class="fal fa-bars"></i> </a>
           </li>
          
          
          <?php }elseif($link == "[login]" && $userdata->ID){ ?>
          
          
           <li <?php if(isset($GLOBALS['flag-account'])){ ?>class="active"<?php } ?>>
           <a href="<?php echo _ppt(array('links','myaccount')); ?>"><i class="fal fa-user"></i> <?php echo __("Account","premiumpress"); ?></a>
           </li>
          
          <?php }elseif($link == "[login]" && !$userdata->ID){ ?>
           
           
           <li <?php if(isset($GLOBALS['flag-login'])){ ?>class="active"<?php } ?>>
           <a href="<?php echo wp_login_url(); ?>"><i class="fal fa-user"></i> <?php echo __("Login","premiumpress"); ?></a>
           </li>
          
          
          <?php }else{ 
		  
		  if($link == home_url() && defined('WLT_DEMOMODE') ){
		  $link = $link."/?reset=1";
		  }
		  
		  
		  ?>
          
          
          <li <?php if(isset($GLOBALS['flag-home'])){ ?>class="active"<?php } ?>><a href="<?php echo $link; ?>"><i class="<?php echo $icon; ?>"></i> <?php echo $name; ?></a></li>
          
          <?php } ?>
           
          
          <?php $i++; }  ?>
          
    
          </ul>
        </div>
      </div>
</div>

<?php } ?>
