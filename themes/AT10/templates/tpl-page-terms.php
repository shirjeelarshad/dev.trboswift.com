<?php
/*
Template Name: [PAGE - TERMS & CONDITIONS]
*/
 
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
global  $userdata, $CORE; 

 
if(!_ppt_checkfile("tpl-page-terms.php")){

$pageLinkingID = _ppt_pagelinking("terms");


if( substr($pageLinkingID ,0,9) == "elementor" ){

	get_header(); 
	
	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");
	
	get_footer();
	
}else{

   
   // + GLOBAL HEADER
   get_header(); 
   
   // + PAGE TOP
   _ppt_template( 'page', 'top' );
   
    $CORE->LAYOUT("get_innerpage_blocks", array("page_terms","load"));
 
    ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="section-80 bg-white">
<div class="container">
  
    <div class="row"> 
       
      <div class="col-md-12">
      
      
    <?php if($post->post_content == ""){ ?>
                     
                <h2>Part 1</h2>
				<p>To edit this text, simply enter your own text into the content area when editing this page.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
                <h3 class="mt-4">Part 1.a</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
                <h3 class="mt-4">Part 1.b</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>      
                   
<hr class="mt-5" />

                <h2>Part 2</h2>
				<p>To edit this text, simply enter your own text into the content area when editing this page.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
                <h3 class="mt-4">Part 2.a</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
                <h3 class="mt-4">Part 2.b</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>                
                 
				   <?php }else{ ?>                   
                   <?php the_content(); ?>
                 <?php } ?>
      
      
      </div>  
</div>
  
</div>
</section> 
<?php endwhile; endif; ?>
<?php 

 
// + PAGE BOTTOM
_ppt_template( 'page', 'bottom' ); 

// + GLOBAL FOOTER
get_footer(); } } ?>