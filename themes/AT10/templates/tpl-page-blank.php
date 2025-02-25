<?php
/*
Template Name: [BLANK PAGE]
*/
 
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
global  $userdata, $CORE;

$GLOBALS['flag-blankpage'] = 1;
 
get_header(); ?>
 

<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
         
         <?php echo the_content(); ?>
        
<?php endwhile; endif; ?>
 

<?php  get_footer(); ?>