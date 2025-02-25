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
   
   global $CORE, $userdata, $settings, $post; 
   
 
   
   if(!_ppt_checkfile("widget-search-filters.php")){
   ?>
    
  
  

<div class="card">
  
<?php _ppt_template( 'framework/design/widgets/widget-filter', 'keyword' ); ?>  

<?php _ppt_template( 'framework/design/widgets/widget-filter', 'distance' ); ?>  
 
<?php _ppt_template( 'framework/design/widgets/widget-filter', 'category' ); ?>

<?php _ppt_template( 'framework/design/widgets/widget-filter', 'taxonomy' ); ?>  

<?php _ppt_template( 'framework/design/widgets/widget-filter', 'showonly' ); ?>
  

<?php _ppt_template( 'framework/design/widgets/widget-filter', 'price' ); ?>

</div>
<?php } ?>