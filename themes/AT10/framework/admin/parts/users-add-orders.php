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

$userdata = array();
$orders = array();
if(isset($_GET['eid'])){ 

 
   // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_orders',
      	'posts_per_page' 	=> 100,
        'paged' 			=> 1,
		
			'meta_query' => array( 
				'user_id'    => array(
					'key' 			=> 'order_userid',	
					'type' 			=> 'NUMERIC',
					'value' 		=> $_GET['eid'],
					'compare' 		=> '=',								 					 			
				),					 	
      		), 
		 
			
      );
      $wp_query1 = new WP_Query($args); 
   
   
     $orders = $wpdb->get_results($wp_query1->request, OBJECT);
} 
   
   if(!empty($orders) ){ ?>

<table class="table table-bordered table-payments table-striped my-4 small">
  <thead>
    <tr>
      <th><?php echo __("Order ID","premiumpress"); ?></th>
      <th class="text-center"><?php echo __("Amount","premiumpress"); ?></th>
      <th class="text-center"><?php echo __("Status","premiumpress"); ?></th>
      <th class="text-center"><?php echo __("Action","premiumpress"); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
		 
		 $data = array("1" => $orders, "2" => $payments );
		 foreach($data as $h){
		 
		 foreach($h as $order){ 
		 
		  
		 $data = $CORE->ORDER("get_order", $order->ID);
		 
		  // SELLER ID
          $seller_id = get_post_meta($order->ID,'seller_id',true);	  
          $buyer_id = get_post_meta($order->ID,'buyer_id',true);	
		   
            
           ?>
    <tr class="row-<?php echo $order->ID; ?>">
      <td><a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->ID; ?>" target="_blank"> #<?php echo $CORE->ORDER("format_id", $order->ID ); ?></a>
        <div class="text-muted small"><?php echo hook_date($data['order_date']); ?></div></td>
      <td class="text-center"><?php echo hook_price($data['order_total']); ?> </td>
      <td class="text-center"><div class="orderstatus-<?php echo $data['order_status']; ?>">
          <?php $h = $CORE->ORDER("get_status", $data['order_status']);  ?>
          <div style="background:<?php echo $h['color']; ?>" class="text-white p-2 text-center small btn-block orderstatus-<?php echo $data['order_status']; ?>"><?php echo $h['name']; ?></div>
        </div></td>
      <td class="text-center"><a href="admin.php?page=orders&eid=<?php echo $order->ID; ?>" target="_blank"> <i class="fa fa-search"></i> </a> </td>
    </tr>
    <?php $i++; } } ?>
  </tbody>
</table>
<?php } ?>
<?php if(empty($orders) ){ ?>
<div class="py-4 text-center">
  <h6>No Orders Found</h6>
</div>
<?php } ?>
