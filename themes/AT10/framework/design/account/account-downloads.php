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

global $CORE, $userdata, $STRING;
 
    // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_orders',
      	'posts_per_page' 	=> 100,
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

$alreadyFound = array();


 
?>

<h5><?php echo __("My Downloads","premiumpress"); ?></h5>
<hr class="dashed mb-3" />
<?php if(!empty($orders)){ $i = 1; ?>
<?php

	foreach($orders as $order){
	
	$data = $CORE->ORDER("get_order", $order->ID);
	
	
	$key  = trim($data['order_postid']);
	
	if( in_array($key, $alreadyFound) ){ continue; }
	$alreadyFound[$key] = $key; 
 	
	if(isset($key) && is_numeric($key) && get_post_meta($key, "download_path", true) != ""){ 
	
	// DOWNLOAD ARRSY
	$data_array = array(
		"uid" 		=> $userdata->ID,
		"pid" 		=> $key,
	);
	
	// SATYS
	$ss = get_post_status($key);
 
?>
<div class="border-bottom bg-white shadow-sm mb-4  p-3 listingid-<?php echo $key; ?> paiddownloads">
  <div class="row y-middle">
    <div class="col-9">
      <div class="float-left img-list mr-3"> <?php echo str_replace("data-","",do_shortcode('[IMAGE pid="'.$key.'"]'));  ?> </div>
      <div class="ellipsis" style="max-width:200px;">
        <?php if($ss != "trash"){ ?>
        <a href="<?php echo get_permalink($key); ?>" class="text-dark font-weight-bold" target="_blank"> <?php echo get_the_title($key); ?></a>
        <?php }else{ ?>
        <?php echo get_the_title($key); ?>
        <?php } ?>
      </div>
    </div>
    <div class="col-3">
      <form method="post" action="" >
        <input type="hidden" name="data" value="<?php echo base64_encode( json_encode( $data_array ) ); ?>" />
        <input type="hidden" name="downloadproduct" value="1" />
        <button type='submit' class='btn btn-primary btn-block'><i class="fal mr-2 fa-download"></i> <?php echo __("Download","premiumpress"); ?></button>
      </form>
    </div>
  </div>
</div>
<?php 					 
						 
			}// end if 
 
} // end if
 

?>
<?php }else{ ?>
<p class="small grey"><?php echo __("No downloads found","premiumpress"); ?></p>
<?php } ?>
