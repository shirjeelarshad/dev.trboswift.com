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
?>
<div class="collapse clearfix" id="collapseMap">
  <div class="map-container clearfix">
    <div id="map-main"></div>
    <ul class="mapnavigation bg-primary list-unstyled m-0">
      <li><a href="#" class="prevmap-nav"><?php echo __("Prev","premiumpress"); ?></a></li>
      <li><a href="#" class="nextmap-nav"><?php echo __("Next","premiumpress"); ?></a></li>
    </ul>
    <div class="map-close" data-toggle="collapse" href="#collapseMap"><i class="fa fa-times"></i></div>
    <input id="pac-input" class="controls fl-wrap controls-searchbox" type="text" placeholder="<?php echo __("town, city or zipcode...","premiumpress"); ?>">
  </div>
</div>
<textarea id="mapdatabox" class="dynamic_map w-100" style="display:none;"></textarea>