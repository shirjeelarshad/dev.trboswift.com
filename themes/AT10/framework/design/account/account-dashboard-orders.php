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

global $CORE, $userdata;


 
 
?>

<div class=" mb-4">
  <div class="card-header d-sm-flex d-block  ">
    <h4 class=" text-white mb-0"><i class="fal fa-shopping-basket mr-2"></i> <?php echo __("Recent Orders","premiumpress") ?></h4>
  </div>
  <div class="pt-3 position-relative" style="min-height:300px;">
    <?php


   // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_orders',
      	'posts_per_page' 	=> 3,
        'paged' 			=> 1,
		
			'meta_query' => array( 
				'user_id'    => array(
					'key' 			=> 'order_userid',	
					'type' 			=> 'NUMERIC',
					'value' 		=> $userdata->ID,
					'compare' 		=> '=',								 					 			
				),					 	
      		), 
		 
			
      );
      $wp_query1 = new WP_Query($args); 
      $orders = $wpdb->get_results($wp_query1->request, OBJECT);
	  
	  if(!empty($orders)){
	  
	  
	   foreach($orders as $order){
	   
	   
	   $data = $CORE->ORDER("get_order", $order->ID);
	   
	   $vv = $CORE->date_timediff( $data['order_date']);
	   
	   $pids = "";
	   if(isset($data['order_postid']) && strlen($data['order_postid'])){
	   
	   $pids = explode(" ",$data['order_postid']);
	    
	   
	   }
	   
	  
	  
?>
    <div class="media mb-4 border-bottom p-3" >
      <?php if(is_array($pids) && isset($pids[0]) && is_numeric($pids[0])){ ?>
      <div class="image-bx mr-sm-4 mr-2" style="max-width:50px;"> <?php echo do_shortcode("[IMAGE pid=".$pids[0]."]"); ?> </div>
      <?php } ?>
      <div class="media-body d-sm-flex justify-content-between d-block align-items-center">
        <div class="w-100"> <span class="small opacity-5 float-right"><?php echo $vv['string-small']; ?> <?php echo __("ago","premiumpress") ?></span>
          <h6 class="mb-sm-2 mb-0"> <?php echo hook_price($data['order_total']); ?></h6>
          <div><a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->ID; ?>" target="_blank">#<?php echo $CORE->ORDER("format_id", $order->ID ); ?></a></div>
          
          <?php /*<p class="text-black mb-sm-3 mb-1 pb-0 small"><?php echo substr($ud['content'],0,200); ?></p>*/ ?>
          
        </div>
      </div>
    </div>
    <?php } ?>
    <?php }else{ ?>
    <div class="text-center mt-5"><i class="fal fa-frown fa-4x text-primary"></i></div>
    <h4 class="text-center mt-4"><?php echo __("No orders found","premiumpress"); ?></h4>
    <p class="text-center text-muted mt-3"><?php echo __("Don't miss out on our great deals.","premiumpress"); ?></p>
    <div class="text-center"> <a href="<?php echo home_url(); ?>/?s" class="btn btn-system btn-md"><?php echo __("Search Website","premiumpress"); ?></a> </div>
    <?php } ?>
  </div>
</div>
