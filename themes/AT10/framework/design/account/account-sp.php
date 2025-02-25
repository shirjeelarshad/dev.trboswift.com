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
   
   if(!empty($orders) ){ ?>
 
   <table class="table table-bordered table-payments table-striped my-4 small">
      <thead>
         <tr>          
            <th><?php echo __("Order ID","premiumpress"); ?></th>
            
            <th class="text-center"><?php echo __("Amount","premiumpress"); ?></th>
           
            <th class="text-center"><?php echo __("Status","premiumpress"); ?></th>
         </tr>
      </thead> 
      
      <tbody> 
         <?php
		 
		 $data = array("1" => $orders );
		 
		 foreach($data as $h){
		 
		 foreach($h as $order){ 
		 
		  
		 $data = $CORE->ORDER("get_order", $order->ID);
		 
		  // SELLER ID
          $seller_id = get_post_meta($order->ID,'seller_id',true);	  
          $buyer_id = get_post_meta($order->ID,'buyer_id',true);	
		   
            
           ?>
         <tr class="row-<?php echo $order->ID; ?>">
          
            <td>
               <a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->ID; ?>" target="_blank"> #<?php echo $CORE->ORDER("format_id", $order->ID ); ?></a>
               
               <div class="text-muted small"><?php echo hook_date($data['order_date']); ?></div>
               
            </td>            
            
            <td class="text-center">
               <?php echo hook_price($data['order_total']); ?>
            </td>  
                      
      
            
            <td class="text-center">
             <div>
                <?php $h = $CORE->ORDER("get_status", $data['order_status']);  ?>
                
                <div style="background:<?php echo $h['color']; ?>" class="text-white p-2 text-center small btn-block"><?php echo $h['name']; ?></div>  
              </div>
            </td>
            
         </tr>
         
         
         <?php if($data['order_status'] == 0 && $seller_id == $userdata->ID){  // strpos(strtolower($data['order_id']), "user") !== false &&  ?>
         <tr>         
         <td colspan="3">
         
         <p>Please update this when you receive payment.</p>
          
                 <div id="update_status_<?php echo $order->ID; ?>">
                  <select class="form-control-sm mb-4" style="width:100%;" id="payment_order_<?php echo $order->ID; ?>">
                     <option value="0"><?php echo __("Waiting Payment","premiumpress"); ?></option>
                     <option value="1"><?php echo __("Paid","premiumpress"); ?></option>
                     <option value="6"><?php echo __("Refunded","premiumpress"); ?></option>
                     <option value="4"><?php echo __("Cancelled","premiumpress"); ?></option>
                  </select> 
               
               
                <button type="button" onclick="ajax_update_order<?php echo $order->ID; ?>();" class="btn btn-success btn-sm btn-block"><?php echo __("Update Status","premiumpress"); ?></button>
         </div>
                  
   <script>
      function ajax_update_order<?php echo $order->ID; ?>(){
         alert('asd');
             jQuery.ajax({
                 type: "POST",
                 url: '<?php echo home_url(); ?>/',		
         		data: {
                  	action: "update_user_payment",
      				id: <?php echo $order->ID; ?>,
      				val: jQuery('#payment_order_<?php echo $order->ID; ?>').val(),
                 },
                 success: function(response) {
         			
         			jQuery('update_status_<?php echo $order->ID; ?>').html(response);
         		 	
                 },
                 error: function(e) {
                     console.log(e)
                 }
             });
         
         }
  
       
   </script>
               
         </td>
         
         <td colspan="3">
         
             
         
         </td>
         </tr>
         <?php } ?>
         
         
         
         
         <?php   } } ?> 
        
         
         
         
      </tbody>
   </table> 

<?php } ?>

 <?php if(empty($orders) ){ ?>
         
          
<div class="py-4 text-center">

<h6>No Orders Found</h6>

</div>              
            
<?php } ?> 