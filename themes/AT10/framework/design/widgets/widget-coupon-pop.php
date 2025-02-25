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
   
   // DISPLAY AMOUNT
   $num = 5;
   if(isset($settings['num']) && is_numeric($settings['num']) && $settings['num'] > 0){
   $num = $settings['num'];
   }
   

   if(!_ppt_checkfile("widget-blog-recent.php")){
   
   
   ?>

<div class="card card-blog">
  <div class="card-body">
    <h5 class="card-title"><?php echo __("Popular Coupons","premiumpress"); ?></h5>
    <ul class="list-unstyled">
      <?php	
                  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                  
                  $args = array(
                      'post_type' 		=> 'listing_type',
                      'posts_per_page' 	=> $num,
					  'order' => 'desc',
					  	'meta_query' => array (
					array (
					  'key' => "lastused",
						'compare' => 'LIKE',
						'value' => date('Y-m-d'),
						'type' => 'DATETIME'
					 
					)
				  )
                  
                  );
                  $wp_query = new WP_Query($args);                   
                  if ( $wp_query->have_posts() ) {                                                       
                  while ( $wp_query->have_posts() ) {  $wp_query->the_post();    
				  
				  
   // USED
   $used = do_shortcode('[USED]');
   if(!is_numeric($used)){
   $used = 0;
   }
   
				   
?>
      <li class="media pt-3 border-top mt-3"> <a href="<?php the_permalink(); ?>" style="max-width:60px;">
        <?php if ( has_post_thumbnail() ) { ?>
        <?php the_post_thumbnail(array(40,40, 'class'=> " img-fluid")); ?>
        <?php }else{ ?>
        <img src="<?php echo do_shortcode('[STOREIMAGE]'); ?>" class="img-fluid" alt="store" />
        <?php } ?>
        </a>
        <div class="media-body ml-3">
          <h5 class="mt-0 mb-2 small"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
            <?php the_title(); ?>
            </a></h5>
          <div class="text-muted small">
          
           <?php
		   
		   
		   
		    if($used > 0){ ?>
          <i class="fa fa-flame text-danger mr-1"></i> <?php 
		  
		  if($used == 1){
		   echo str_replace("%s", $used , __( 'used once', 'premiumpress' ) ); 
		  }else{
		   echo str_replace("%s", $used , __( 'used %s times', 'premiumpress' ) ); 
		  }
		  
		 ?>   
          <?php } ?>
          
           </div>
        </div>
      </li>
      <?php } } ?>
      <?php wp_reset_query(); ?>
    </ul>
  </div>
</div>
<?php } ?>
