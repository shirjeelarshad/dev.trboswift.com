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
   
   $userid = $userdata->ID;
   
   if(is_admin() && isset($_GET['eid'])){   
   $userid = $_GET['eid'];
   }
   
   
    
   // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_orders',
      	'posts_per_page' 	=> 100,
        'paged' 			=> 1,
		
			'meta_query' => array( 
				'user_id'    => array(
					'key' 			=> 'order_userid',	
					'type' 			=> 'NUMERIC',
					'value' 		=> $userid,
					'compare' 		=> '=',								 					 			
				),					 	
      		), 
		 
			
      );
      $wp_query1 = new WP_Query($args); 
      $orders = $wpdb->get_results($wp_query1->request, OBJECT);
	
  // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_orders',
      	'posts_per_page' 	=> 100,
        'paged' 			=> 1,
		
			 
			
      	'meta_query' => array(
      		'relation'    => 'OR',												 
      									'seller_id'    => array(
      										'key' => 'seller_id',	
      										'type' 			=> 'NUMERIC',
      										'value' 		=> $userid,
      										'compare' 		=> '=',								 					 			
      									),			 
      									'buyer_id'   => array(
      										'key'     => 'buyer_id',							
      										'type' 			=> 'NUMERIC',
      										'value' 		=> $userid,
      										'compare' 		=> '=',															
      									),		
      	),
			
      );
      $wp_query2 = new WP_Query($args); 
      $payments = $wpdb->get_results($wp_query2->request, OBJECT);   
   ?>
<script> 


 
   
   function ajax_load_order_payment(div,pp){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   			details:jQuery('#'+div).val(),
           },
           success: function(response) {
		   
		   
		   jQuery(".payment-modal-wrap").fadeIn(400);
		 
		    jQuery(".payment-modal-container h3").text(pp).addClass("<?php echo _ppt(array('currency','symbol')); ?>"); 			 
			 
   			jQuery('#ajax-payment-form').html(response);	
			
			UpdatePrices();
		    
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>




      <div id="ajax_makepayment_form"></div>
      <?php if(isset($_GET['paymentid']) ){ ?>
      <script> jQuery(document).ready(function(){   setTimeout(function(){  SwitchPage('orders'); }, 2000); }); </script>
      <?php } ?>
      <div class="mt-3 mb-5">
         <div class="col-12 my-3 row">
  <div class="col-md-6">
        
 <h4 class="mb-2 "><?php echo __("My Invoices","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Here you will see " . number_format(count($orders)) . " invoices","premiumpress"); ?></span>
  
        </div>
        <div class="col-md-6 text-right hide-mobile">
<a href="<?php echo home_url(); ?>/sell-a-car/" class="btn btn-secondary rounded-pill">Sell Now</a>
</div>

</div>

        <div class="card-body p-0">
          <?php
if(!empty($orders) || !empty($payments)){
?>
<div class="overflow-auto"> 
          <table class="table small table-orders">
            <thead>
              <tr>
                <th class="text-center bg-primary text-white " style="border-radius:10px 0 0 0;"><?php echo __("Order ID","premiumpress"); ?></th>
                <th class="text-center bg-primary text-white "><?php echo __("Date","premiumpress"); ?></th>
                <th class="text-center bg-primary text-white"><?php echo __("Amount","premiumpress"); ?></th>
                <th class="text-center bg-primary text-white dashhideme"><?php echo __("Type","premiumpress"); ?></th>
                <th class="text-center bg-primary text-white "><?php echo __("Status","premiumpress"); ?></th>
                <th class="text-center text-white  bg-primary  dashhideme" style="border-radius:0 10px 0 0;"><?php echo __("Actions","premiumpress"); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
		 
		 $mixa = array();
		 $data = array("1" => $orders, "2" => $payments );
		 foreach($data as $h){
		 
		 foreach($h as $order){ 
		 
		 	if(in_array($order->ID, $mixa)){ continue; }
	
				$mixa[$order->ID] = $order->ID;
		 
		  
		 $data = $CORE->ORDER("get_order", $order->ID);
		 
		  // SELLER ID
          $seller_id = get_post_meta($order->ID,'seller_id',true);	  
          $buyer_id = get_post_meta($order->ID,'buyer_id',true);			       
           ?>
              <tr class="row-<?php echo $order->ID; ?>">
                <td><span class="font-weight-bold">
                
                <a class="text-dark" href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->ID; ?>" target="_blank">#<?php echo $CORE->ORDER("format_id", $order->ID ); ?></a>
                
                
                </span> </td>
                <td class="text-center text-muted"><?php echo hook_date($data['order_date']); ?></td>
                <td class="text-center"><?php echo hook_price($data['order_total']); ?> </td>
                <td class="text-center dashhideme">
				
				<?php $h = $CORE->ORDER("get_type", $data['order_id']);  ?>
                
                
                  <?php echo $h['name']; ?> </td>
                <td class="text-center"><?php $h = $CORE->ORDER("get_status", $data['order_status']); ?>
                  <span class="inline-flex items-center font-weight-bold order-status-icon status-<?php echo $data['order_status']; ?>"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo $h['name']; ?></span> </span> </td>
                <td class="text-center dashhideme"><a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->ID; ?>" class="btn btn-system btn-sm" target="_blank"><i class="fal fa-file"></i> <?php echo __("Invoice","premiumpress"); ?></a>
                  <?php
				  
	 
			if( ( substr($data['order_id'], 0, 8) == "UPGRADE-" || substr($data['order_id'], 0, 7) == "CREDIT-" || substr($data['order_id'], 0, 4) == "LST-" ) &&  $data['order_status'] == 2){  ?>
            
             
            
            
            
            
                  <button class="btn btn-system btn-sm bg-warning " onclick="ajax_load_order_payment('orderdatafor<?php echo $order->ID; ?>','<?php echo $data['order_total']; ?>');"><?php echo __("Pay Now","premiumpress"); ?></button>
                  <input type="hidden" id="orderdatafor<?php echo $order->ID; ?>" value="<?php 
				  
				  
   if(!isset($data['order_description'])){ $data['order_description'] = ""; }
   
   echo $CORE->order_encode(array(   
   	"uid" => $userid, 
   	"amount" => $data['order_total'],     	
   	"order_id" => $data['order_id'],   	 
   	"description" => $data['order_description'],   	
   	"recurring" => 0,   	
   	"couponcode" => 0,   	
	"hidecouponbox" => 1, 							
   ) ); 
    		
   ?>" />
                  <script>
			
			 jQuery(document).ready(function(){ 
			jQuery('#notice-overduepayment').show();
			jQuery('#notice-accountdefault').hide();
			
			});
			
			</script>
                  <?php } ?>
                </td>
              </tr>              
              <?php  } } ?>
            </tbody>
          </table>
          </div>
          <?php } ?>
          <?php if(empty($orders) && empty($payments)){ ?>
          <div class="py-4 text-center">
            <h6><i class="fal fa-frown mr-2"></i> <?php echo __("No Orders Found","premiumpress"); ?></h6>
          </div>
          <?php } ?>
        </div>
      </div>