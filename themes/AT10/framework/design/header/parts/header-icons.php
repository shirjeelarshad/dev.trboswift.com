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

global $CORE;

$phone = _ppt(array('company','phone'));
$email = _ppt(array('company','email'));

if(isset($_GET['ppt_live_preview']) && $phone == ""){
$phone = "123 456 789";
}

if(isset($_GET['ppt_live_preview']) && $email == ""){
$email = "admin@mywebsite.com";
}

?>
 
<ul class="topbar-info main-header hide-ipad">
                  <li class="hide-mobile">
                    
                      <span class="media">
                      
                        <span class="media-left">
                          <span class="icon">
                            <i class="fal fa-clock text-primary">&nbsp;</i>
                          </span>
                        </span>
                        <span class="media-content">
                          <strong><?php echo __("Monday - Friday 08:00 - 20:00","premiumpress"); ?></strong>
                          <br><?php echo __("Sunday - Closed","premiumpress"); ?>
                        </span>
                      </span>                     
                  </li>
                  <li class="hide-mobile">
                     
                      <span class="media">
                        <span class="media-left">
                          <span class="icon">
                            <i class="fal fa-map-marker text-primary">&nbsp;</i>
                          </span>
                        </span>
                        <span class="media-content">
                          <?php $g = explode(",", _ppt(array('company','address')) ); ?>
                          <strong><?php echo $g[0]; ?></strong>
                          <br><?php echo $g[1]; ?></span>
                      </span>
                 
                  </li>
                  <li class="hide-mobile">
                   
                      <span class="media">
                        <span class="media-left">
                          <span class="icon">
                            <i class="fal fa-phone-alt text-primary">&nbsp;</i>
                          </span>
                        </span>
                        <span class="media-content">
                         <strong><?php echo $phone; ?></strong>
                          <br><?php echo $email; ?></span>
                      </span>
                  
                  </li>
                
</ul> 
<button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button> 
</button> 