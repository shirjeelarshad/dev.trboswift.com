<?php
/*
   Template Name: [PAGE - BLOG]
*/
   
   global $wpdb, $post, $wp_query;
   
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
    
   $GLOBALS['flag-blog'] = true;
  
   if(!_ppt_checkfile("tpl-page-blog.php")){  
   
   // + GLOBAL HEADER
   get_header(); 
   
   // + PAGE TOP
   _ppt_template( 'page', 'top' ); ?>
<section class="section-60 bg-light">
<div class="container">
<div class="row">
<div class="col pr-md-5"><?php
   
    
      $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      
      $args = array(
          'post_type' 			=> 'post',
          'posts_per_page' 		=> get_option('posts_per_page'),
          'paged' 				=> $paged,
 
      );
	  
  	
	if(isset($wp_query->query['category_name'])){
	
		$term = get_term_by('slug', $wp_query->query['category_name'], 'category');
	 
		
		$args['cat'] = $term->term_id;
	
	}
	  
	  
	  if(isset($_GET['keyword'])){
	  	  
	  	$args['s'] = $_GET['keyword'];
		
	  } 
	  
      $wp_query = new WP_Query($args); 
      
      // COUNT EXISTING ADVERTISERS	 
      $tt = $wpdb->get_results($wp_query->request, OBJECT);
      
      if(!empty($tt)){
      foreach($tt as $p){
      
      $post = get_post($p->ID);
      
      ?>
       
   <?php _ppt_template( 'content', 'post' ); ?>
   
   <?php }}else{?>
   
   
   <?php echo __("no results found","premiumpress"); ?>
   
   
   <?php } ?>


<div class="my-4 pt-3  mobile-mb-4 mobile-pb-4"><?php echo $CORE->PAGENAV(); ?></div>

<?php wp_reset_query(); ?> 

</div>

<?php get_sidebar();  ?>


</div>
</div>
</section><?php 

// + PAGE BOTTOM
_ppt_template( 'page', 'bottom' ); 

// + GLOBAL FOOTER
get_footer(); } ?>