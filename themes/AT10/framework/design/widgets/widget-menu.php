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
   
  
   ?>
   
   
<div class="card card-blog">
  <div class="card-body">
    <h5 class="card-title"><?php  echo $settings['title']; ?></h5>
    
 
<?php echo str_replace("active","font-weight-bold active-item", str_replace("menu-item ","list-group-item d-flex justify-content-between align-items-center px-0 ", str_replace("nav-link","text-dark",do_shortcode('[MAINMENU menu_name="'.$settings['menu_id'].'" class="list-group list-group-flush"][/MAINMENU]')))); ?>




</div>
</div>
 