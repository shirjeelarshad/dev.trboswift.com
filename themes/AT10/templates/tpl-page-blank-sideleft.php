<?php
/*
Template Name: [BLANK PAGE - SIDEBAR LEFT]
*/
 
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
global  $userdata, $CORE;

$GLOBALS['flag-page'] = true;

// SIDEBAR
if(!defined('SIDEBAR-LEFT')){
define('SIDEBAR-LEFT', true);
}

get_header(); get_template_part( 'page', 'top' ); ?>

<section class="section-60 bg-light mt-1">
<div class="container">
<div class="row">

<?php get_sidebar();  ?>

    <div class="col pr-md-5">
        
        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
         
         <?php echo the_content(); ?>
        
    <?php endwhile; endif; ?>
    
    </div>




</div>
</div>
</section>

<?php get_template_part( 'page', 'bottom' ); get_footer(); ?>