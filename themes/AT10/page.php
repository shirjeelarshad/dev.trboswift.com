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
  
   $GLOBALS['flag-page'] = true;
     
   get_header();
   
   _ppt_template( 'page', 'top' );
   
   if (have_posts()) : while (have_posts()) : the_post(); 
   ?>
   
   
<section class="section-80">
  <div class="container"> <?php echo the_content(); ?> </div>
</section>
<?php   
   endwhile; endif;
   
   _ppt_template( 'page', 'bottom' );
   
   get_footer(); 
   
   ?>
