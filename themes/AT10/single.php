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

global $CORE, $post;
  
if(!_ppt_checkfile("single.php")){
 
get_header(); _ppt_template( 'page', 'top' ); ?>

    <a name="toplisting"></a>
        
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
         
          
            <?php the_content(); ?> 
          
        
    <?php endwhile; endif; ?>
	 
<?php _ppt_template( 'page', 'bottom' ); get_footer(); ?> 

<?php } ?>