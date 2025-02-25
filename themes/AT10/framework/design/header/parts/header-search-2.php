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

global $CORE, $settings;

?>

<ul class="topbar-info main-header">
  <li>
    <form action="<?php echo home_url(); ?>" class="search" >
      <div class="input-group">
        <input type="text" class="form-control rounded-0 typeahead" name="s" autocomplete="off">
        <div class="input-group-append">
          <button class="btn <?php echo $settings['btn-class']; ?> rounded-0 text-uppercase px-3  border-0" type="submit"> <?php echo __("Search","premiumpress"); ?> </button>
        </div>
      </div>
    </form>
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
                         <strong><?php echo _ppt(array('company','phone')); ?></strong>
                          <br><?php echo _ppt(array('company','email')); ?></span>
                      </span>
  
  
  </li>
</ul>
