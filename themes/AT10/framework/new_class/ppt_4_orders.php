<?php


class framework_orders extends framework_media {

// USED WITHIN OLD PAYMENT PLUGINS
function order_exists($orderid){ global $CORE;

	return $CORE->ORDER("check_exists", $orderid);
}

 
function ORDER($action='add', $order_data){

global $userdata, $wpdb, $CORE;
 
	switch($action){
	
		case "order_id_user_id": {
		
			$orderid = $order_data;
		
			// EXTRA VALIDATE FOR USER ID
			if( substr($orderid,0,4) == "SUBS"){
				
				$ff = explode("-",$orderid);
				if(isset($ff[2]) && is_numeric($ff[2])){
				return $ff[2];
				}
			
			}elseif(substr($orderid,0,6) == "CREDIT"){
			
				$ff = explode("-",$orderid);
				if(isset($ff[1]) && is_numeric($ff[1])){
				return $ff[1];
				}	
			
			
			}elseif(substr($orderid,0,7) == "UPGRADE"){
			
				$ff = explode("-",$orderid);
				if(isset($ff[1]) && is_numeric($ff[1])){
				return get_post_field( 'post_author', $ff[1] );
				}	
			
			
			}elseif(substr($orderid,0,2) == "MJ"){ 
			
				$ff = explode("-",$orderid);
				if(isset($ff[2]) && is_numeric($ff[2])){
				return $ff[2];
				}	
			
			}
			
			return 1;
		
		
		} break;
	 	
	
		case "user_get_name": {
			
			$name = "";
			
			if(THEME_KEY == "sp"){
				
				$f = get_user_meta($order_data, "billing_fname", true)." ".get_user_meta($order_data, "billing_lname", true);
				 
				if(strlen($f) > 3){
					$name .= $f."<br>";
				}
			}
			
			if($name == ""){
			$name = $CORE->USER("get_name", $order_data);
			}
			
			return $name;
		
		} break;
		
		case "user_get_address": {
		
			$addr = "";
			
			if(THEME_KEY == "sp"){
			
				global $CORE_CART;
			
				foreach($CORE_CART->shop_user_fields as $key => $field){	
		 		
					if($field['type'] != "sep" && !in_array($key, array("billing_phone","billing_fname","billing_lname")) ){
					
						$f = get_user_meta($order_data, $key, true);
						if(strlen($f) > 0){
						$addr .= $f."<br>";
						}
					 
					}		
				}			
			}
		
			if($addr == ""){
			$addr = $CORE->USER("get_address", $order_data);
			}
			
			return $addr;
		
		
		} break;
		
		case "user_get_phone": {
			
			$addr = "";
			
			if(THEME_KEY == "sp"){
				
				$f = get_user_meta($order_data, "billing_phone", true);
				if(strlen($f) > 0){
					$addr .= $f."<br>";
				}
			}
			
			if($addr == ""){
			$addr = $CORE->USER("get_phone", $order_data);
			}
			
			return $addr;
		
		
		} break;
		
		case "format_id": {
		
			return str_pad($order_data, 6, "0", STR_PAD_LEFT);
		
		} break;
		
		case "check_expired": {
		
			$orderid = $order_data;	
		
		} break;
		
		case "check_exists": {
		
			if($order_data == "" || $order_data == "CART-" || $order_data == "UPGRADE-" || $order_data == "LST-" ){
				return "";
			}
		
			$ores = $wpdb->get_results("SELECT post_id as order_id FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'order_id' AND meta_value = ('".esc_sql($order_data)."') LIMIT 1 ");
			 
			if(isset($ores[0])){
			  
				if($ores[0]->order_id == 0){	
					return "";
				}else{
					return $ores[0]->order_id;
				}
			
			}	
		
		} break;
 
		case "delete": {
		 
			wp_delete_post( $order_data, true );
			return;	
		
		} break;
			
		case "add": {
		 
		 	// DONT ADD INVOICE FOR COMBINED ORDERS
			if(strpos($order_data['order_id'],"combined") !== false){
			return array("orderid" => "99999999", "type" => "old");	
			}
		
			// CHECK ORDER DOESNT ALREADY EXISTS
			if(!is_numeric($this->ORDER("check_exists", $order_data['order_id'])) ){			
				 
				if(isset($order_data['user_id'])){
					$order_data['order_userid'] = $order_data['user_id'];
				}elseif(isset($order_data['order_userid'])){
					$order_data['order_userid'] = $order_data['order_userid'];
				}else{
					$order_data['order_userid'] = 1;
				}
				
				// PREPARE DATA
		  		$rawdata = array();
				$postcontent = "";
				if(isset($_POST) && !isset($_POST['action'])){
					parse_str(implode("", $_POST), $rawdata);
					if(is_array($rawdata)){
						foreach($rawdata as $k => $v){
							 $postcontent .= $k." == ".$v;
						}
					}
				}
				
				 
				// SETUP NEW ORDER			
				$my_post = array();				
				$my_post['post_title'] 		= "Order #".$order_data['order_id']; 
				$my_post['post_type'] 		= "ppt_orders"; 
				$my_post['post_status'] 	= "publish";
				$my_post['post_content'] 	= $postcontent; 
				$payment_id = wp_insert_post( $my_post );	
				 
				// CLEAN THE ORDER DATA
				foreach($order_data as $key=>$val){	
					update_post_meta($payment_id, $key, esc_sql($val));			 
				}// end foreach
				 
				// SET DEFULT STATUS				
				update_post_meta($payment_id, 'order_process', 1);
				
				// RETURN
				return array("orderid" => $payment_id, "type" => "new");
				
			}else{
			
			 	
				// CHECK OLD ORDERS
				$old_id = $this->ORDER("check_exists", $order_data['order_id']);
			 	
				// UPDATE STATUS AND SET ACTIVE
				if(is_numeric($old_id)){					
					$my_post = array();	
					$my_post['ID']	= $old_id;	
					$my_post['post_status'] 	= "publish";
					wp_update_post( $my_post );	
										
					// SET DEFULT STATUS				
					update_post_meta($old_id, 'order_status', 1);
						
					// SET DEFULT STATUS				
					update_post_meta($old_id, 'order_process', 3);	
					
					// SET DEFULT STATUS				
					update_post_meta($old_id, 'order_gatewayname', $order_data['order_gatewayname']);	
					
					
					// IF ORDER VALUE IS 0 SET IT AS FREE FOR FREE LISTING
					if($order_data['order_total'] == 0){
					update_post_meta($old_id, 'order_total', 0);
					update_post_meta($old_id, 'order_notes', "free listing upgrade");				
						
					}				 
								
				}
				
				// ADD NEW TRANSACTION				
				return array("orderid" => $old_id, "type" => "old");			
			}
	 
		} break ; // end add
	
		case "get_id": {		
	 
		 	if( $order_data == "random" ){
			
				return  rand(0,999999);
				
			}
		
		} break;

		
		case "get_order": {
		
			if(get_post_meta($order_data, "order_id", true) != ""){
			
				$p = get_post($order_data);
				
				$data = array(
				
					"order_id" 			=> get_post_meta($order_data, "order_id", true),
					"order_status" 		=> get_post_meta($order_data, "order_status", true),
					
					"order_process" 	=> get_post_meta($order_data, "order_process", true),
					
					"order_date" 		=> $p->post_date,
					
					"order_total" 		=> get_post_meta($order_data, "order_total", true),
					"order_discount" 	=> get_post_meta($order_data, "order_discount", true),
					"order_tax" 		=> get_post_meta($order_data, "order_tax", true),
					"order_shipping" 	=> get_post_meta($order_data, "order_shipping", true),
					
					
					"order_userid" 		=> get_post_meta($order_data, "order_userid", true),
					"order_email" 		=> get_post_meta($order_data, "order_email", true),
					
					"order_description" => get_post_meta($order_data, "order_description", true),
					
					"order_postid" 		=> get_post_meta($order_data, "order_postid", true),
					 
						
				);	
				
				return $data;
			
			}else{
			
				return false;
			
			}
		
		} break;
		
		case "get_order_total": { 
		
			return get_post_meta($order_data, "order_total", true);
		
		} break;
		
		case "get_listing_orders": {
		 
		 	 $records = array();
			 
			  $args = array(
				  'post_type' 			=> 'ppt_orders',
				  'posts_per_page' 		=> 100,					 	 
			  );
			  $args['meta_query']["order_postid"]  = array(							
				'key' => "order_postid",
				'type' => 'NUMERIC',
				'value' => $order_data,
				'compare'=> '='						
			 );			  
			  
			 $wp_query = new WP_Query($args); 
			 $tt = $wpdb->get_results($wp_query->request, OBJECT);
			  
			 if(!empty($tt)){
			 	foreach($tt as $p){	
				
				$os = get_post_meta($p->ID,'order_status',true);
				 
				 		  
				  $records[$p->ID] =  array(
				  
					"id" => $p->ID,
					"id_formatted" 		=> $CORE->ORDER("format_id", $p->ID),
					"total" 			=> get_post_meta($p->ID,'order_total',true),
					"status" 			=> get_post_meta($p->ID,'order_status',true),
					"status_formatted" 	=> $CORE->ORDER("get_status",$os),
					
					
				   );
			 	}
			 }
			 
			 return $records;
		
		
		} break;
		
		
		case "get_process": {
		
		
			$order_status = array(
			 
			
				1 => array(	
					"name" =>  __("Processing","premiumpress"), 
					"color" => "#eb983c",
				),
				
				2 => array(	
					"name" =>  __("In Transit","premiumpress"), 
					"color" => "#277fbf",
				),
				
				3 => array(	
					"name" =>  __("Complete","premiumpress"), 
					"color" => "#34cd63",
				),
				
				4 => array(	
					"name" =>  __("Recurring","premiumpress"), 
					"color" => "#344860",
				),
				
			);
			
			
			if( $order_data == "random" ){ // RETURN RANDOM TYPE
			
				return rand(0, 3);			
			 
			
			}elseif(is_numeric($order_data) && isset($order_status[$order_data]) ){ // GET SINGLE
			
				return $order_status[$order_data];
			
			}
			
			return $order_status; 
		
		
		} break;
		
		
		case "get_status_formatted": {
		
			$status = $CORE->ORDER("get_status", $order_data);
			 	 
			$t = '<span class="inline-flex items-center font-weight-bold order-status-icon '.$status['css'].'"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap">'.$status['name'].'</span> </span>';
			
			return $t;
		
		} break;	
		
		case "get_status": {
		
		
			$order_status = array(
			
			/*
			 	0 => array(	
					"name" =>  __("Pending","premiumpress"), 
					"color" => "#eb983c",
					"css" => "status-2",
					"key" => 0,
				),
				*/
			
				1 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Paid","premiumpress"), 
					"color" => "#34cd63",
					"css" => "status-1",
					"key" => 1,
				),			
							
				
				2 => array(	
					"name" =>  __("Pending","premiumpress"), 
					"color" => "#eb983c",
					"css" => "status-2",
					"key" => 2,
					
				),	
				
				3 => array(	
					"name" =>  __("Failed","premiumpress"), 
					"color" => "#c13a24",
					"css" => "status-5",
					"key" => 3,
				),			
				
				4 => array(	
					"name" =>  __("Cancelled","premiumpress"), 
					"color" => "#576475",
					"css" => "status-7",
					"key" => 4,
				),
				
				5 => array(	
					"name" =>  __("Refunded","premiumpress"), 
					"color" => "#8d43b4",
					"css" => "status-7",
					"key" => 5,
				),
				
				6 => array(	
					"name" =>  __("On Hold","premiumpress"), 
					"color" => "#95a5a5",
					"css" => "status-7",
					"key" => 6,
				),
				 
			
			);
			
			
			if( $order_data == "random" ){ // RETURN RANDOM TYPE
			
				return rand(0, 6);			
			 
			
			}elseif(is_numeric($order_data) && isset($order_status[$order_data]) ){ // GET SINGLE
			
				return $order_status[$order_data];
			
			}
			
			return $order_status; 
		
		
		} break;
		
		case "get_type": {
		
		
			$ordertypes = array(
	
					"LST" 			=> array(
						"id" 		=> "LST",  
						"name" 		=> __("Listing","premiumpress"), 
						"color" 	=> "#49caae",
					),
					
					"UPGRADE" 		=> array(
						"id" 		=>	"UPGRADE",  
						"name" 		=> __("Listing Upgrade","premiumpress"),   
						"color" 	=> "green",
					),	
					
					
					"SUBS" 			=> array(
						"id" 		=> "SUBS",
						"name"		=> __("Membership","premiumpress"),
						"color" 	=> "#34cd63"
					),
					
					"BAN" 			=> array("id" =>"BAN",  "name" => __("Advertising","premiumpress"),  "color" => "#3197e1"),
					"CREDIT" 		=> array("id" =>"CREDIT",  "name" => __("User Credit","premiumpress"),  "color" => "#9a58bc"),
					//"TOKEN" 		=> array("id" =>"TOKEN",  "name" => "Token",  "color" => "" ),
					"RENEW" 		=> array("id" =>"RENEW",  "name" => __("Renewal","premiumpress"),  "color" => "#344860"),
					"INVOICE" 		=> array("id" =>"INVOICE",  "name" => __("Invoice","premiumpress"),  "color" => "#1ba083"),
					//"POWERSELLER" 	=> array("id" =>"POWERSELLER",  "name" => "Powerseller",  "color" => "green"),
					
					
					"CART" 			=> array("id" =>"CART",  "name" => __("Cart","premiumpress"),  "color" => "#54be74"),	
					"MJ" 			=> array("id" =>"MJ",  "name" => __("Micro Jobs","premiumpress"),  "color" => "#277fbf"),
					"NA" 			=> array("id" =>"NA",  "name" => __("Unknown","premiumpress"),  "color" => "#8d43b4"),
					
					"OFFER" 		=> array("id" =>"OFFER",  "name" => __("Offer","premiumpress"),  "color" => "#576475"),
					
					"CUSTOM" 		=> array("id" =>"CUSTOM",  "name" => __("Custom","premiumpress"),  "color" => "#f0c400"),
					
					"TEST" 		=> array("id" =>"TEST",  "name" => __("Test","premiumpress"),  "color" => "#c13a24"),
					
					
					"ESCROW" 		=> array("id" =>"ESCROW",  "name" => __("Escrow","premiumpress"),  "color" => "#f0c400"),
					
					"FREE" 		=> array("id" =>"FREE",  "name" => __("Free","premiumpress"),  "color" => "#f0c400"),
					
					
			);
			
			$toplevel = array();
			foreach($ordertypes as $k => $h){
			$toplevel[$k] = $k;
			} 
			
			if(is_array($order_data)){
				
				if(THEME_KEY == "sp"){
				unset($ordertypes['LST']);	
				unset($ordertypes['MJ']);
				unset($ordertypes['TEST']);	
				unset($ordertypes['SUBS']);		
				unset($ordertypes['OFFER']);
				}
				
				return $ordertypes;
			
			}elseif( $order_data == "" ){ // RETURN ALL TYPES
			
				return $ordertypes;			
			
			}elseif( $order_data == "random" ){ // RETURN RANDOM TYPE
			
				$rand_keys = array_rand($ordertypes, 2);
							
				return $ordertypes[$rand_keys[0]]['id'];
			
			}elseif(in_array($order_data, $toplevel) ){
			
				return $ordertypes[$order_data];
			
			}elseif(substr($order_data,0,4) == "FREE"){	
			
				return $ordertypes["FREE"];
				
			}elseif(substr($order_data,0,4) == "TEST"){	
			
				return $ordertypes["TEST"];
			
			}elseif(substr($order_data,0,2) == "MJ"){	
			
				return $ordertypes["MJ"];	
			
			}elseif(substr($order_data,0,5) == "TOKEN"){	
			
				return $ordertypes["TOKEN"];
			
			}elseif(substr($order_data,0,5) == "RENEW"){	
		 
				return $ordertypes["RENEW"];
			
			}elseif(substr($order_data,0,7) == "INVOICE"){
			
				return $ordertypes["INVOICE"];
			
			}elseif(substr($order_data,0,11) == "POWERSELLER"){	
			
				return $ordertypes["POWERSELLER"];
			
			}elseif(substr($order_data,0,3) == "BAN"){
			
				return $ordertypes["BAN"];
			
			}elseif(substr($order_data,0,6) == "CREDIT"){
				
				
				if(in_array(THEME_KEY, array("mj","at","ct")) && ( _ppt(array('lst', 'house_comission')) > 0 || _ppt(array('lst', 'house_comission_fixed')) > 0 ) ){
				$ordertypes["CREDIT"]['name'] = __("House Comission","premiumpress");
				}
				
				return $ordertypes["CREDIT"];
			
			}elseif(substr($order_data,0,7) == "UPGRADE"){
			
				return $ordertypes["UPGRADE"];
			
			}elseif( substr($order_data ,0,4) == "SUBS"){
			
				return $ordertypes["SUBS"];
			
			}elseif( substr($order_data ,0 ,3) == "LST"){
			
				return $ordertypes["LST"];
			
			}elseif( substr($order_data ,0,4) == "CART"){	
			
				return $ordertypes["CART"];
			
			}elseif( substr($order_data ,0,5) == "OFFER"){	
			
				return $ordertypes["OFFER"];
			
			}elseif( substr($order_data ,0,6) == "CUSTOM"){	
			
				return $ordertypes["CUSTOM"];
				
			}elseif( substr($order_data ,0,6) == "ESCROW"){	
			
				return $ordertypes["ESCROW"];				
			
			}
			
			
			return $ordertypes;  
		
		
		} break;
		
		case "get_total": {		
		
		// TOTAL OF ALL ORDERS		
		$SQL = "SELECT sum(mt1.meta_value) AS total FROM ".$wpdb->prefix."posts 
					INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id) 					 				
					WHERE 1=1 
					AND ( mt1.meta_key = 'order_total' )				 
					AND ".$wpdb->prefix."posts.post_type='ppt_orders' AND ".$wpdb->prefix."posts.post_status = 'publish' ";
			 
			$result = $wpdb->get_results($SQL);	
			 		 
			if(empty($result)){
				return 0;
			}
			
			return $result[0]->total;
	 	
		}
		
		
		case "get_order_items": {
		
		
		// ORDER ID
		if(!is_numeric($order_data)){
		return "invalid order id";
		}
		
		$orderid = get_post_meta($order_data, "order_id", true);		
		$order_type = $CORE->ORDER("get_type", $orderid);
		
		
		if(substr($orderid,0,4) == "CART"){
		
			$obits = explode("-",$orderid); 
			$SQL = "SELECT session_data FROM ".$wpdb->prefix."core_sessions WHERE session_key LIKE ('%".strip_tags($obits[1])."%') LIMIT 1";
			$hassession = $wpdb->get_results($SQL, OBJECT);
			if(!empty($hassession)){
						// RESTORE THE CART DATA
					$cart_data = unserialize($hassession[0]->session_data);		 
					// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
					if(isset($cart_data['items']) && is_array($cart_data['items'])){
						$GLOBALS['global_cart_data'] = $cart_data;
					 }// end if
			}		
		
		
		}else{
		
			
			// INVOICE FOR OFFERS
			if($order_type['id'] == "OFFER"){ 
			 
			
			$order_description = "";
			$offer_id = get_post_meta($order_data, "offer_id", true);
			$post_id = get_post_meta($offer_id, "post_id", true);
			$order_description = get_the_title($post_id);
			
			
			$order_total = get_post_meta($order_data, "order_total", true);
			$order_userid = get_post_meta($order_data, "order_userid", true);
			
			
			
			$order_tax = "";
			$order_shipping = "";
			$order_discount = "";
			
			}else{
		
			
			// GET DATA FROM ADMIN
			$order_total = get_post_meta($order_data, "order_total", true);
			$order_tax = get_post_meta($order_data, "order_tax", true);
			$order_shipping = get_post_meta($order_data, "order_shipping", true);
			$order_discount = get_post_meta($order_data, "order_discount", true);
			$order_id = get_post_meta($order_data, "order_id", true);
			$order_description = get_post_meta($order_data, "order_description", true);
			$order_email = get_post_meta($order_data, "order_email", true);
			$order_userid = get_post_meta($order_data, "order_userid", true);
			
			}
			
			if(!is_numeric($order_tax)){ $order_tax = 0; }
			if(!is_numeric($order_shipping)){ $order_shipping = 0; }
			if(!is_numeric($order_discount)){ $order_discount = 0; }
			if(!is_numeric($order_total)){ $order_total = 0; }
			
			 
			$order_subtotal = $order_total - $order_shipping - $order_discount - $order_tax;
			
			
			 switch(THEME_KEY){
	  
				  case "at": {
				   
				  // GET SHIPPING OST
				   $price_shipping = get_post_meta($post_id,'price_shipping',true);
				     
				   if(is_numeric($price_shipping) && $price_shipping > 0){				  
				   
					update_post_meta($order_data, "order_shipping",  $price_shipping);					 
					
				   }
				   
				  
				  } break;
			  
			  }
			  
			  
			if($order_description == "" && THEME_KEY == "mj"){
			
				$h = explode("-",$order_id);
				if(isset($h[1])){			
				$order_description = get_the_title($h[1]);			
				}
			}
			
		
		 $GLOBALS['global_cart_data'] = array(
				  
				"userid" => $order_userid,
				"total_items" => 1,
				"total" => $order_total,
				"subtotal" => $order_subtotal,
				"qty" => "1",
				"tax" => $order_tax,
				"weight_class" => 0,
				"weight" => 0,
				"tokens" => 0,
				"shipping" => $order_shipping,
				"comments" => "",
				"discount" => 0,
				"discount_code" => 0,
				 "items" => array(
						
						1 => array(
							
							1 => array(
							"innerID" => 1,
                            "name" => $order_description,
                            "link" => "", 
                            "amount" => $order_total,
                            "image" => "", 
							"qty" => "1",
							"comments" => "",
							),
						),
					
					),
					
				  );
		
		
		}
		
		// GLOBAL CHANGEs
		
		//print_r($GLOBALS['global_cart_data']);
		
		$order_total = get_post_meta($order_data, "order_total", true);
		$GLOBALS['global_cart_data']['total'] =  $order_total;
	
	 	$order_shipping = get_post_meta($order_data, "order_shipping", true);	
		$GLOBALS['global_cart_data']['shipping'] =  $order_shipping;
	
	 	$order_tax = get_post_meta($order_data, "order_tax", true);
		$GLOBALS['global_cart_data']['tax'] =  $order_tax;
		
		if($order_shipping > 0){
		$order_total = $order_total -$order_shipping;
		$GLOBALS['global_cart_data']['subtotal'] =  $order_total;	
		}
		
		
		ob_start();
		?>
        <div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>
<th class="center">#</th>
<th><?php echo __("Item","premiumpress"); ?></th>
 

<th class="right"><?php echo __("Unit Cost","premiumpress"); ?></th>
  <th class="center"><?php echo __("Qty","premiumpress"); ?></th>
<th class="right"><?php echo __("Total","premiumpress"); ?></th>
</tr>
</thead>
<tbody>
<?php 
 
foreach($GLOBALS['global_cart_data']['items'] as $key => $inner_item){  

	foreach($inner_item as $innerkey => $item){ 
	

?>
          
<tr>
<td class="center"><?php echo $innerkey; ?></td>
<td class="left strong">

<?php echo $item['name']; ?>
 
        <?php
		
		if(isset($item['custom_data']) && is_array($item['custom_data']) ){
		?>
        <ul class="list-inline">
        <?php
		  
		foreach($item['custom_data'] as $f){ ?>
        
        <li class="list-inline-item small">
        <?php 
		
		switch($f['key']){
			
			default: {
			?>
            <?php echo $CORE->GEO("translation_tax_key", $f['key']); ?>: <?php echo $f['text']; ?>  
            <?php			
			} break;		
		}
		 
		?>        
        </li>
        
        
        <?php	
		}
		?>
        </ul>
        <?php 
		}		
		 
		?>
        
        
        <?php if(get_post_meta($key, "download_path", true) != ""){ 
		
			 
			// DOWNLOAD ARRSY
			$data_array = array(
			"uid" 		=> $userdata->ID,
			"pid" 		=> $key,
			);
		
		?>
        
    
    <form method="post" action="" class="mt-3">
    <input type="hidden" name="data" value="<?php echo base64_encode( json_encode( $data_array ) ); ?>" />
    <input type="hidden" name="downloadproduct" value="1" />
    <button type='submit' class='btn btn-primary'><i class="fal mr-2 fa-download"></i> <?php echo __("Download File","premiumpress"); ?></button>
    </form>
        <?php } ?>

</td>
 

<td class="right"><?php echo hook_price($item['amount']); ?></td>
  <td class="center"><?php echo $item['qty']; ?></td>
<td class="right"><?php echo hook_price($item['amount']*$item['qty']); ?></td>
</tr>

<?php } } ?>
 

 

</tbody>
</table>
</div>
<div class="row">
<div class="col-lg-4 col-sm-5">

</div>

<div class="col-lg-5 ml-auto">
<table class="table table-clear">
<tbody>
<tr>
<td class="left">
<strong><?php echo __("Subtotal","premiumpress"); ?></strong>
</td>
<td class="right"><?php echo hook_price($GLOBALS['global_cart_data']['subtotal']); ?></td>
</tr>
<tr>
<?php if(is_numeric($GLOBALS['global_cart_data']['discount']) && $GLOBALS['global_cart_data']['discount'] > 0 ){ ?>
<td class="left">
<strong><?php echo __("Discount","premiumpress"); ?></strong>
</td>
<td class="right"><?php echo hook_price($GLOBALS['global_cart_data']['discount']); ?></td>
</tr>
<tr>
<?php } ?>
<?php if(is_numeric($GLOBALS['global_cart_data']['tax']) && $GLOBALS['global_cart_data']['tax'] > 0 ){ ?>
<td class="left">
 <strong><?php echo __("Tax","premiumpress"); ?></strong>
</td>
<td class="right"><?php echo hook_price($GLOBALS['global_cart_data']['tax']); ?></td>
</tr>
<tr>
<?php } ?>
<?php if(is_numeric($GLOBALS['global_cart_data']['shipping']) && $GLOBALS['global_cart_data']['shipping'] > 0 ){ ?>
<td class="left">
 <strong><?php echo __("Shipping","premiumpress"); ?></strong>
</td>
<td class="right"><?php echo hook_price($GLOBALS['global_cart_data']['shipping']); ?></td>
</tr>
<tr>
<?php } ?>
<td class="left">
<strong><?php echo __("Total","premiumpress"); ?></strong>
</td>
<td class="right">
<strong><?php echo hook_price($GLOBALS['global_cart_data']['total']); ?></strong>
</td>
</tr>
</tbody>
</table>

</div>
        <?php
		return ob_get_clean();
		
		} break;
	
		
	} // end switch

}


  
function order_encode($order_id){
 
return base64_encode(json_encode($order_id));

}

function order_decode($order_id){
 
return json_decode(base64_decode($order_id));

}

function order_get_orderid($autoid = "", $oid = ""){ 
	
	return str_pad($autoid, 6, "0", STR_PAD_LEFT);
	
}
  
  
  
  
  
  
  
  
  
  
  
  
 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
function payment_setup($data, $smallform = 0){ global $CORE, $userdata; $STRING = "";
	  
	  	// SMALL FORM COL WIDTHS
		if($smallform == 1){ 
		$col1 = 'col-12'; $col2 = "col-12"; 
		
		}else{ $col1 = 'col-md-7';  $col2 = "col-md-4 offset-md-1";  
		}
	  
		// DECODE DATA
		$data = $CORE->order_decode($data);
	 	 	   
		// MAKE SURE HERE IS AN ORDER ID
		if(!isset($data->order_id)){
		die("no payment data");
		}	 	
		
		 
		// CHECK FOR TOKEN PAYMENT
		if(isset($data->tokens) && is_numeric($data->tokens) && $data->tokens > 0){				
			$STRING .= $this->payment_via_tokens($data->order_id, $data->tokens , $data->description);	
		} 
		 
		// HOOK INTO THE PAYMENT GATEWAY ARRAY 
		$gatway = hook_payments_gateways($GLOBALS['core_gateways']);
	 	
		$data->amount = str_replace(",",".",$data->amount);
		
		$GLOBALS['orderid'] 	= $data->order_id;	
		$GLOBALS['total'] 		= $data->amount;
		$GLOBALS['description'] = $data->description;
		$GLOBALS['subtotal'] 	= 0;
		$GLOBALS['shipping'] 	= 0;
		$GLOBALS['tax'] 		= 0;
		$GLOBALS['weight'] 		= 0; 
		$GLOBALS['discount'] 	= 0;
		$GLOBALS['items'] 		= "";	
		 

		// FLAT RATE TAX 
		if(_ppt('basic_tax_flatrate') == 1){
		
			// SHIPPING FLAT RATE
			if( is_numeric(_ppt(array('basic_tax','flatrate'))) ){ 
				$GLOBALS['tax'] += _ppt(array('basic_tax','flatrate')); 
			}
					
			// SHIPPING FLAT PERCENTAGE
			if( is_numeric(_ppt(array('basic_tax','flatrate_percent')))  ){ 
				$GLOBALS['tax'] += (  $GLOBALS['total'] * _ppt(array('basic_tax','flatrate_percent')) /100);
			}	
		}
		
		// COUNTRY TAX
		$delivery_country 	= get_user_meta($userdata->ID, 'country', true);
		$delivery_state 	= get_user_meta($userdata->ID, 'city', true);
		 
		if(THEME_KEY != "sp" && _ppt('basic_country_tax_tax') == 1 && $delivery_country != "" ){		
		 
			$regions = _ppt('regions');	$taxSet = 0;	
			if(is_array($regions)){ 
				$i=0; 
				while($i < count($regions['name']) ){
					if($regions['name'][$i] !=""){	
					
						
						if( (!empty($regions['country'][$i]) && in_array($delivery_country, $regions['country'][$i]) ) 
						|| (!empty($regions['state'][$i]) && in_array($delivery_state, $regions['state'][$i]) ) ) { // COUNTRY OR STATE CHECKOUT	
						
					 
							// FLAT RATE 
							if( is_numeric( _ppt(array('tax_country','price_'.$regions['key'][$i])) ) && !$taxSet ){ 
								$GLOBALS['tax'] += _ppt(array('tax_country','price_'.$regions['key'][$i])); 
								$taxSet = 1;
							}
									
							// FLAT PERCENTAGE
							if( is_numeric( _ppt(array('tax_country','percentage_'.$regions['key'][$i])) ) && !$taxSet  ){ 		 
								$GLOBALS['tax'] += ( $GLOBALS['total'] * _ppt(array('tax_country','percentage_'.$regions['key'][$i])) /100);
								$taxSet = 1;
							}					
						
						}
												
					}
				$i++;
				} 
			}
		}
		
		if(THEME_KEY != "sp" && $GLOBALS['tax'] > 0){
		$GLOBALS['total'] += $GLOBALS['tax'];
		//$GLOBALS['tax'] = 0;
		}
	 	
		
		// FORM SIZES		 
		if(isset($data->formsize)){		 
		$col1 = 'col-12'; $col2 = "col-12";
		}
		
		  
		//if(!is_numeric($data->amount)){ $data->amount = 0; }
		if($data->amount < 0){ $data->amount = 0; }		
		
		if(_ppt(array('coupons','enable')) == 1 && isset($data->couponcode) && strlen($data->couponcode) > 1 ){
		 
			// COUPON CODES 
			$ppt_coupons = get_option("ppt_coupons");
			// CHECK WE HAVE SUCH A CODE
			if(is_array($ppt_coupons) && count($ppt_coupons) > 0 ){
				foreach($ppt_coupons as $key=>$field){
					if($data->couponcode == $field['code']){
					
							// WORK OUT DISCOUNT AMOUNT
							$discount = $field['discount_percentage'];
							
							 
							if(is_numeric($discount) ){
							
								$GLOBALS['CODECODES_DISCOUNT'] = $data->amount/100*$discount;
								
								//die($GLOBALS['CODECODES_DISCOUNT']."<-- (".$GLOBALS['total']."/100*".$discount.")");
								
							}elseif(is_numeric($field['discount_fixed'])){
								$GLOBALS['CODECODES_DISCOUNT'] = $field['discount_fixed']; 
							}
							
							if(defined('WLT_CART') ){
							global $CORE_CART; 
						 
							add_action('hook_cart_data', array( $CORE_CART, 'CODECODES_APPLYCART') );
							
							}
							
					
					}
				}
			}
			
			if(isset($GLOBALS['CODECODES_DISCOUNT']) && $GLOBALS['CODECODES_DISCOUNT'] > 0){
				$GLOBALS['total'] =  $data->amount; // - $GLOBALS['CODECODES_DISCOUNT'];
				//echo $GLOBALS['total']."<--".$data->amount."--".$GLOBALS['CODECODES_DISCOUNT'];
			}
			
			$STRING .= ' <script>jQuery("#ppdiscountlist").show();jQuery("#ppdiscount").html("'.hook_price($GLOBALS['CODECODES_DISCOUNT']).'");jQuery("#ppprice").html("'.hook_price($data->amount).'");</script>';
			 
		}		
		 
		
		$STRING .= '<ul class="list-group" id="paymentlistform">';	
		  
		
		// MAKE SURE PACKAGES ARE ENABLED, OTHERWISE WE CANNOT GET THE PAYMENT DATA	
		if(is_array($gatway) && isset($data->amount) && is_numeric($data->amount) && $data->amount > 0 ){
		 
		 // LOOP AND DISPLAY GATEWAYS
			foreach($gatway as $Value){
			 
				// GATEWAY IS ENABLED 		 
				if(get_option($Value['function']) == "yes" ){
				
				 
					// TEXT ONLY
					 if( !isset($Value['ownform']) || ( isset($Value['ownform']) && $Value['ownform'] == "no" ) ){
					
					   $rannum = rand();
					    
					   
					   $STRING .= '<li class="list-group-item py-lg-4 '.$Value['function'].'"><div class="container">
				
          	 <div class=" name">';
								
								if(strpos(get_option($Value['function'].'_name'), "http") === false){
								
									$STRING .= '<p>'.get_option($Value['function'].'_name').'</p>';
									
									if(strlen(get_option($Value['function']."_desc")) > 2){									
									$STRING .= '<div class="small">'.get_option($Value['function']."_desc").'</div>';									
									} 
									
								}else{
								
									$STRING .= '<img src="'.get_option($Value['function']."_name").'" alt="payment" class="img-fluid">';
									
								}
								
								
								 
								
								$STRING .= '</div>      
                
							<div class=" ">
							
							<div class="card-section">';
							
							
							if(user_can($userdata->ID, 'administrator') && isset($data->recurring) && $data->recurring == 1 && isset($data->recurring_days) && is_numeric($data->recurring_days) ){
							
								if($Value['function'] == "gateway_onepay"){
								
									$STRING .= str_replace("gateway_","gateway_".$rannum."_",$Value['function']($_POST));
									
								}else{
								
									$STRING .= "<div class='opacity-5 small text-center'>".__("Recurring payments not supported.","premiumpress")."</div>";
								}
							
							
							}else{
							
							$STRING .= str_replace("gateway_","gateway_".$rannum."_",$Value['function']($_POST));
							
							}
							
							
							
							
							$STRING .= '</div></div></div></li>';	   
					   
					// NORMAL FORMS	
					}else{	
									
						$STRING .= '<li class="list-group-item '.$Value['function'].'">'.$Value['function']($_POST).'<div class="clearfix"></div></li>';	
											
					}// END IF
					
				}// end if			
			
			
			} // end foreach		
		
		} // end gateway loop
		 
		
		
		
	// ADD ON PAYMENT BY USER CREDIT
		// if($userdata->ID){
	// $usercredit = get_user_meta($userdata->ID,'ppt_usercredit',true);
	// }
	
	// if(isset($usercredit) && isset($data->amount) && is_numeric($data->amount) && $data->amount > 0 && $usercredit >= $data->amount ){
			
		 	
	// 			if(!isset($GLOBALS['uccount'])){ $GLOBALS['uccount'] = 1; }else{ $GLOBALS['uccount']++; }
				
				
	// 			$STRING .= '<li class="list-group-item py-lg-4"><div class="container">
	// 						<div class="row">
	// 					   <div class="'.$col1.' name"><strong>'.__("User Credit Payment","premiumpress").'</strong><br> <div class="small">'.__("Your current balance is","premiumpress").' '.hook_price($usercredit).'</div></div>
	// 					   <div class="'.$col2.' paybutton">
						   
	// 					   <form method="post"  action="'._ppt(array('links','callback')).'" name="checkout_usercredit'.$GLOBALS['uccount'].'" onsubmit="jQuery(this).find(\'button\').attr(\'disabled\', true);">
	// 						<input type="hidden" name="credit_total" id="credit_total" value="'.$GLOBALS['total'].'" />
	// 						<input type="hidden" name="custom" value="'.$GLOBALS['orderid'].'" class="paymentcustomfield">		
	// 						<input type="hidden" name="item_name" value="'.strip_tags($GLOBALS['description']).'">			 
							 
	// 						<button class="btn btn-primary btn-block font-weight-bold text-uppercase" type="submit">'.__("Pay Now","premiumpress") .'</button>
							
	// 						</form>
			
	// 					   </div>
	// 					   </div>
						  
	// 					   <div class="clearfix"></div>  </div></li>'; 
	// 	}
			 
			
			
	
	if($userdata->ID && (substr($GLOBALS['orderid'], 0, 8) == "UPGRADE-" || substr($GLOBALS['orderid'], 0, 4) == "LST-") && $CORE->USER("membership_hasaccess", "listings") && $CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID)) > 0 ){
	
		if(!isset($GLOBALS['uccount'])){ $GLOBALS['uccount'] = 1; }else{ $GLOBALS['uccount']++; }
				
	
	
	$STRING .= '<li class="list-group-item py-lg-4"><div class="container">
							<div class="row">
						   <div class="'.$col1.' name"><strong>'.__("Free Upgrade","premiumpress").'</strong><br> <div class="small">'.__("Select this option to complete this order using your free upgrade credit.","premiumpress").' '.str_replace("%s",$CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID)),__("You have %s credits left.","premiumpress")).'</div></div>
						   <div class="'.$col2.' paybutton">
						   
						   <form method="post"  action="'._ppt(array('links','callback')).'" name="checkout_usercredit'.$GLOBALS['uccount'].'" onsubmit="jQuery(this).find(\'button\').attr(\'disabled\', true);">
							<input type="hidden" name="free_upgrade" value="1" />
							<input type="hidden" name="orderid" value="'.$GLOBALS['orderid'].'" class="paymentcustomfield">		
							  <input type="hidden" name="description" value="'.strip_tags($GLOBALS['description']).'"  />
							<button class="btn btn-primary btn-block font-weight-bold text-uppercase" type="submit">'.__("Continue","premiumpress") .'</button>
							
							</form>
			
						   </div>
						   </div>
						  
						   <div class="clearfix"></div>  </div></li>'; 
	
	
	
	}	
			
			
		// ADD ON FOR ADMIN TESTING
		if( ( user_can($userdata->ID, 'administrator') || defined('WLT_DEMOMODE') ) && in_array(_ppt('demopay'), array("","1"))  ){ // && isset($data->amount) && is_numeric($data->amount) && $data->amount > 0
		
		if($userdata->ID){		
			$email = get_option('admin_email');
		}else{
			$email = "testuser".rand(0,1000000)."@gmail.com";
		}
		
		 
		
		 $STRING .= '<li class="list-group-item py-lg-4"><div class="container">
				
							<div class="row">
							 	
								<div class="'.$col1.' name">
								
								<strong>Demo Test Mode</strong>
								
								<div class="small">Skip payment gateways to test callback.</div>
								
								</div>
							
							<div class="'.$col2.' paybutton">
							
							<form method="post" action="'._ppt(array('links','callback')).'" style="display:inline">
							<input type="hidden" name="email" value="'.$email.'" />
							
							<input type="hidden" name="admin_test_callback" value="1" />';
							
if(isset($data->recurring) && $data->recurring == 1 && isset($data->recurring_days) && is_numeric($data->recurring_days) ){
$STRING .= '<input type="hidden" name="subscription" value="1" />';
}else{
 $STRING .= '<input type="hidden" name="subscription" value="0" />';
}
							
						$STRING .= '<input type="hidden" name="amount" value="'.$GLOBALS['total'].'" id="admin_test_total" />
							<input type="hidden" name="custom" value="'.$GLOBALS['orderid'].'" class="paymentcustomfield" />							
							<input type="hidden" name="description" value="'.strip_tags($GLOBALS['description']).'"  />
							
							<button class="btn btn-primary btn-block font-weight-bold text-uppercase" style="cursor:pointer">'.__("Pay Now","premiumpress") .'</button>
							 
						 
							</form>
							
							</div> 
							
							
						</div> 
							 
							
							</div></li>';  
		
		
			 				
			}
			
			// HANDLE FREE PAYMENTS
	 

			
		// ADD ON FOR ADMIN TESTING
	 	 
		if( ( isset($data->amount) && is_numeric($data->amount) && $data->amount == 0 )  ){ // || ( isset($data->tokens) && $data->tokens == 0 ) 
		
		 		ob_start();
				?><li class="list-group-item">
				<div class="container">
				<div class="row">
				<div class="<?php echo $col1; ?> title font-weight-bold">
							 <?php echo __("No Payment Required","premiumpress"); ?>
				</div>
				<div class="<?php echo $col2; ?> paybutton">
				<?php if($userdata->ID){ ?>
					<form method="post" action="<?php echo _ppt(array('links','callback')); ?>">
							
							<input type="hidden" name="free_payment_order" value="1" />
							
							<input type="hidden" name="amount" value="0"  />
							<input type="hidden" name="custom" value="<?php echo $GLOBALS['orderid']; ?>" class="paymentcustomfield" />							
							 <input type="hidden" name="description" value="<?php echo strip_tags($GLOBALS['description']); ?>" class="paymentcustomfield" />
							 
							<button class="btn btn-primary btn-block font-weight-bold text-uppercase" type="submit"><?php echo __("Complete Order","premiumpress"); ?></button>
					</form>
                    <?php }else{ ?>
                    <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-primary btn-block font-weight-bold text-uppercase"><?php echo __("Please login","premiumpress"); ?></a>
                    
                    <?php } ?>
				</div>								
				</div>
				</div>	   
				</li><?php 
				
				$STRING .= ob_get_clean(); 	
				
				
							
			}
			
			
		 
		// COUPON ADD-ONS FOR DISCOUNTS
		if(_ppt(array('coupons','enable')) == 1 && !isset($data->hidecouponbox) && isset($data->amount) && is_numeric($data->amount) && $data->amount > 0  && (!isset($_SESSION['discount_code']) || isset($_SESSION['discount_code']) && $_SESSION['discount_code'] == "")  ){ //
		
	  
		ob_start();
		?>
        <li class="list-group-item">
				<div class="container">
				<div class="row">
				<div class="col-md-7 title">
				<a href="javascript:void(0);" onclick="jQuery('#couponcodeform').toggle();" class="small"><?php echo __("Have a coupon code? ","premiumpress"); ?></a> <span id="coupondiscounttext" class="small ml-3"></span>
				</div>
				<div class="col-md-4">
				
					<form method="post" action="#" id="couponcodeform" style="display:none;" onsubmit="ajax_apply_coupon(this); return false;"><input type="hidden" name="coupon_orderid" value="<?php echo $data->order_id; ?>" /><input type="text" name="couponcode" id="couponcode" class="form-control form-control-sm" placeholder="<?php echo __("Enter coupon here.. ","premiumpress"); ?>"><button class="btn btn-primary btn-sm btn-block mt-2" type="submit"><?php echo __("Apply Coupon","premiumpress"); ?></button></form>            
                    
<script>
function ajax_apply_coupon(acode){
  
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',
		   dataType: 'json',		
   		data: {
            action: 	"check_couponcode",
			code: 		acode.couponcode.value,		
			<?php if(isset($data->old_amount) && is_numeric($data->old_amount)){ ?>
			amount: 	"<?php echo $data->old_amount; ?>",
			<?php }else{ ?>
			amount: 	"<?php echo $data->amount; ?>",
			<?php } ?>
			orderid: 	"<?php echo $GLOBALS['orderid']; ?>",
			desc: 		"<?php echo strip_tags($GLOBALS['description']); ?>",
			<?php if(isset($data->recurring) && is_numeric($data->recurring) && isset($data->recurring_days) && is_numeric($data->recurring_days) ){ ?>
			recurring:  <?php echo $data->recurring; ?>,
			recurring_days: <?php echo $data->recurring_days; ?>,
			<?php } ?>
        },
        success: function(response) {
		  
				if(response.status == "ok"){
				
				 
				 	jQuery.ajax({
					   type: "POST",
					   url: '<?php echo home_url(); ?>/',					   	
					data: {
						action: "load_new_payment_form",
						details: response.code,
					   },
					   success: function(r) { 
			 			
						alert("<?php echo __("Coupon Applied","premiumpress"); ?>");
					 
					 	jQuery('#ajax-payment-form').html(r); 
							
						jQuery('#ppprice').html(response.total);
						jQuery('#pprice').html(response.total);
						jQuery('.ppprice').html(response.total);
						jQuery('.t-total .pricetag').html(response.total);
						
						jQuery('.payment-modal-container h3').html(response.total).show();						
						jQuery('#admin_test_total').val(response.total_value);
						
						jQuery("#coupondiscounttext").html("<?php echo __("You saved","premiumpress"); ?> " + response.discount);
						
						jQuery('.t-total').after('<div class="table-footer t-shipping clearfix"><div class="row"><div class="col-lg-6 col-6 text-sm-right"><?php echo __("Discount","premiumpress"); ?></div><div class="col-lg-6 col-6 text-right"><span class="text-uppercase"><a href="javascript:void(0);" onclick="RemoveCoupon();" id="removeCouponBtn" title="remove coupon"><i class="fal fa-times text-danger mr-2"></i></a>'+response.discount+'</span></div></div></div>');
						
						<?php if( in_array(THEME_KEY, array("sp","so")) ){ ?>
						
						jQuery("#main-userfields").submit();
						 
						<?php } ?>
												
						return false;
						
					   },
					   error: function(e) {
						   alert("<?php echo __("No Coupon Found","premiumpress"); ?>");
						   return false;
					   }
				   }); 
				   
				   return false;
				
				}else{
				
					alert("<?php echo __("Invalid Coupon Code","premiumpress"); ?>");
					return false;
				
				}
			   			
           },
           error: function(e) {
               console.log(e);
			   return false;
           }
       });

}
</script></div></div></div></li><?php 
		$STRING .= ob_get_clean();
		
		}
		
		
		$STRING .= '</ul>';
		
		
		
		
		
			
		if($GLOBALS['tax'] > 0){
		
			// COUPON ADD-ONS FOR DISCOUNTS
			 
			ob_start();
			?>
			
			<script> jQuery(document).ready(function(){ 
			
			var totalprice = 0;
			 
			totalprice = <?php echo $GLOBALS['total']; ?>;
			 
			jQuery(".payment-modal-container h3").html("<?php echo _ppt(array('currency','symbol')); ?>"+totalprice +" - <?php echo __("Tax Included","premiumpress"); ?> <span class='opacity-5'>(<?php echo hook_price($GLOBALS['tax']); ?>)</span>"); });</script>
			<?php 
			$STRING .= ob_get_clean();
			 
		
		}
		
		
		
		
		
		
		
		
		
		if(!function_exists('v10_gateway_bank_admin')){
		
		ob_start();
		?>
        <div class="text-center py-5" id="paymentspinner" style="display:none;">
        <i class='fas fa-spinner fa-spin fa-3x mt-4'></i>
        <div class="small opacity-5 mt-5"><?php echo __("Loading secure checkout","premiumpress"); ?></div>
        </div>
        <script>
		 
		if(jQuery("#paymentlistform li").length < 2){
			
			jQuery("#paymentspinner").show();
			
			jQuery("#paymentlistform .list-group-item").hide();
			
			setTimeout(function(){
			
				jQuery("#paymentlistform .list-group-item:first-child").find('button').trigger('click');
			
			},3000);
		}
		
		</script>
        
        <?php 
		$STRING .= ob_get_clean();
		
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		// RETURN GATEWAY INFORMATION
		return $STRING;
	}
	 
	
 
	
	
/* =============================================================================
ORDER PROCESSING
========================================================================== */

  
/*
	this function handles differeny changes
	based on the order ID prefix
*/

function _hook_v9_order_process($data){ global $wpdb, $CORE, $userdata;
 
 
	if(isset($data['order_id'])){
	
	
		if(substr($data['order_id'],0,6) == "ESCROW"){ 
		
		/*
			ESCROW PAYMENTS ARE FOR EXISTING INVOICES
			SO WE GET THE INVOICE ID
			AND THEN GET THE DATA FROM THERE
		*/
		 

			// BREAK DOWN THE ORDER ID
	   	 	$obits = explode("-", $data['order_id']);
			
			// 0 excrow
			// 1 = payment id
			// 2 = offer id
			// 3 = post id for orginal item
		  	
			$ordercheck = $CORE->ORDER("get_order", $obits[1]);	
			
			 //die(print_r($ordercheck).print_r($data).print_r($obits));
			 
			 
			 // FOR ALL NEW 'BUY NOW' OFFERS THE ORDER IS ONLY ADDED
			 // DURING PAYMENT, SO WE GET THE ID NOW
			 if(!is_numeric($obits[1]) && isset($ordercheck['ID']) && is_numeric($ordercheck['ID'])){
			 
			 $obits[1] = $ordercheck['ID'];
			 
			}
			
			 	
			if( is_array($ordercheck) && !empty($ordercheck) && isset($obits[1]) && isset($obits[2]) ){ 
			  
			  
				//	1. SET INVOICE HAS PAID
				if(is_numeric($obits[1])){
				update_post_meta($obits[1],'payment_complete', date('Y-m-d H:i:s') );
				update_post_meta($obits[1],'invoice_status', 5);
				update_post_meta($obits[1],'order_status', 1);
				}
				
				// 2. SET OFFER AS PAID
				update_post_meta($obits[2],'payment_complete', date('Y-m-d H:i:s') );				 	
				update_post_meta($obits[2], "order_id", $obits[1]);	
				update_post_meta($obits[2], "offer_complete", 2);
						 
				
				// 3. SET THE ORGINAL INVOICE AS PAID
				$oo = explode("-", $ordercheck['order_id']);
			 	
				update_post_meta($oo[1],'payment_complete', date('Y-m-d H:i:s') );
				update_post_meta($oo[1],'invoice_status', 5);
				update_post_meta($oo[1],'order_status', 1);
				
				// NOW UPDATE THE ORGINAL OFFER WITH A PAID ORDER ID
				add_post_meta($oo[1], "order_id", $obits[1]);
				add_post_meta($oo[1], "escrow_id", $data['ID']);
			 
			
			}elseif( !is_array($ordercheck)  && isset($obits[2]) ){
				
				// 2. SET OFFER AS PAID
				update_post_meta($obits[2],'payment_complete', date('Y-m-d H:i:s') );				 	
				update_post_meta($obits[2], "order_id", $obits[1]);	
				update_post_meta($obits[2], "offer_complete", 2);
				
			}
	 
	 		if(isset($obits[3]) && is_numeric($obits[3])){
			
				// UPDATE ORDER WITH DATA
				update_post_meta($data['ID'], "order_postid", $obits[3]);
			
			}
			
			// SET THE OFFER TO FINISHED IF ADMIN ONLY
			if(_ppt(array('lst','adminonly')) == "1" && isset($obits[2]) ){			
				update_post_meta($obits[2], "offer_status", 3);
				 update_post_meta($obits[2], "offer_complete", 5);
			}
		
				
			
 
		}elseif(substr($data['order_id'],0,2) == "MJ"){ 
		 
			/*
			Array
			(
				[0] =&gt; MJ <-- MICRO JOBS
				[1] =&gt; 991 <-- POST ID
				[2] =&gt; 1 <-- USERID
				[3] =&gt; 2 <-- STANDARD OR PREMIUM
				[4] =&gt; 50 <-- ADDON ID
			)		
			*/
			// BREAK DOWN THE ORDER ID
	   	 	$obits = explode("-", $data['order_id']);
		 
			$order_key_id = $this->ORDER("check_exists", $data['order_id']);
			 		
			if( is_numeric($order_key_id) ){
				
				
				// CHECK OFFER HASNT ALREADY BEEN ADDED
				$og = $CORE->USER("check_offer_exists_by_orderid", $order_key_id);
				 
				if($og  == 0){
						 	
					$ordercheck = $CORE->ORDER("get_order", $order_key_id);			 
					
					// ADD A NEW OFFER TO THE SYTEM
					$my_post = array();
					$my_post['post_title'] 		= "New Job - ".$obits[2]."-".$obits[1];
					$my_post['post_content'] 	= "";
					$my_post['post_excerpt'] 	= "";
					$my_post['post_status'] 	= "publish";
					$my_post['post_type'] 		= "ppt_offer";
					$my_post['post_author'] 	= 1;
					$POSTID 					= wp_insert_post( $my_post );
					
					// STORE ORDER ID
					add_post_meta($POSTID, "order_id", $order_key_id);
							
					// STORE POST ID
					add_post_meta($POSTID, "post_id", $obits[1]);
							 
					// SAVE THE BUYERS ID
					add_post_meta($POSTID, "buyer_id", $obits[2]); 
							
					// SAVE THE BUYERS ID
					$author_id = get_post_field ('post_author', $obits[1]);
					add_post_meta($POSTID, "seller_id", $author_id); 
							
					// ADD STATUS
					add_post_meta($POSTID, "price", $ordercheck['order_total']);			
							
					// ADD STATUS
					add_post_meta($POSTID, "offer_status", 1);
					
					// PREMIUMD OR STANDARD
					add_post_meta($POSTID, "gig_type", $obits[3]);
					add_post_meta($POSTID, "gig_addon", $obits[4]);
					
					
					// ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "offer_new",	
																
							"postid"	=> $obits[1],
									
							"to" 		=> get_post_field( 'post_author', $obits[1] ), 						
							"from" 		=> $obits[2],
									
							"alert_uid1" 	=>  get_post_field( 'post_author', $obits[1] ),	
									 
						)
					);			
			}
		 
	
		} // end check exists	 
 		
		
		// LISTING UPGRADES
		}elseif(substr($data['order_id'],0,7) == "UPGRADE"){
				 
			
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);
			 
			  	
			// UPGRADE PACKAGE ADDONS PAYMENT
			if(isset($ob[2]) && $ob[2] != "combined"){
				
				$CORE->PACKAGE("package_process_upgrade", array( $ob[2], $ob[1] ) );			
			
			}elseif(isset($ob[2]) && $ob[2] == "combined"){
			
				// COMBINED PAYMENT FOR ALL INVOICES
				
					$p = $CORE->PACKAGE("get_payment_due",  $ob[1] );
					if(isset($p['data']) && is_array($p['data'])){
					 
						foreach($p['data'] as $d){						
						
							// NOW LETS UPDATE THE ORDER STATUS
							update_post_meta($d['id'], "order_status", 1);				
							update_post_meta($d['id'], 'order_paid',date("Y-m-d-H:i:s"));	
							
						
						}
					
					}
				
			
			
			}
			
			
			
			// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
			$ex = $CORE->ORDER("check_exists", $data['order_id']);	
			 							 
			if( is_numeric($ex) && strlen($ex) > 1 ){						
				// NOW LETS UPDATE THE ORDER STATUS
				update_post_meta($ex, "order_status", 1);				
				update_post_meta($ex,'order_paid',date("Y-m-d-H:i:s"));	
			}
			 
			// UPDATE PACKAGE EXPIRY DATE
			// INCASE USER HAS DELAY BEFORE PAYING	
			if(isset($ob[2]) && in_array($ob[2], array("featured","sponsored","homepage"))){ //,"combined"
				
				// DO NOTHING
			
			}else{
				
				$pak = get_post_meta($ob[1],'packageID',true);			
				if(strlen($pak) > 0){			
					$tnow = date("Y-m-d H:i:s"); 				
					$newdate = date("Y-m-d H:i:s", strtotime( $tnow . " +"._ppt('pak'.$pak.'_duration')." days"));				 
					update_post_meta($ob[1], 'listing_expiry_date', $newdate );
				}
			
			}			 
			
			// SET STATUS TO LIVE
			$my_post = array();
			$my_post['ID'] 					= $ob[1];
			$my_post['post_status']			= "publish";
			wp_update_post( $my_post  );
	 
		}elseif( substr($data['order_id'] ,0 ,3) == "LST"){		
		
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);			
			 
			// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
			$ex = $CORE->ORDER("check_exists", $data['order_id'] );									 
			if( is_numeric($ex) && strlen($ex) > 1 ){						
				// NOW LETS UPDATE THE ORDER STATUS
				update_post_meta($ex, "order_status", 1);				
				update_post_meta($ex,'order_paid',date("Y-m-d-H:i:s"));	
			}
			
			// SET STATUS TO LIVE
			$my_post = array();
			$my_post['ID'] 					= $ob[1];
			$my_post['post_status']			= "publish";
			wp_update_post( $my_post  );
			
			
			// UPDATE PACKAGE EXPIRY DATE
			// INCASE USER HAS DELAY BEFORE PAYING			
			$pak = get_post_meta($ob[1],'packageID',true);
			if(strlen($pak) > 0){			
				$tnow = date("Y-m-d H:i:s"); 				
				$newdate = date("Y-m-d H:i:s", strtotime( $tnow . " +"._ppt('pak'.$pak.'_duration')." days"));				 
				update_post_meta($ob[1], 'listing_expiry_date', $newdate );
			}
			
			 	
			
		}elseif(substr($data['order_id'],0,6) == "CREDIT"){
		 	
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);
			 		
			
			// ADD ON CREDIT
			
			//die(print_r($ob)."--"._ppt(array('credit', $ob[3] .'b')).print_r($data));
			
			if( $ob[2] == "NEW"){			
			
				$c = get_user_meta($ob[1],'ppt_usercredit', true);
				
				if(!is_numeric($c)){
				$c = 0;
				}
				
				$v = _ppt(array('credit', $ob[3] .'b'));
				if(!is_numeric($v)){
				$v = 0;
				}
				
				$c1  = $c + $v;
				
				update_user_meta($ob[1],'ppt_usercredit', $c1);	
			
			
			}elseif( is_numeric($ob[1]) && $ob[1] > 0 && !in_array(THEME_KEY, array("mj","at"))  ){		
						
					$c = get_user_meta($data['user_id'],'ppt_usercredit', true);
					$c1  = $c + $data['order_total'];
					update_user_meta($data['user_id'],'ppt_usercredit', $c1);						
			}			
			 
		 
		// TOKEN PAYMENT
		}elseif(substr($data['order_id'],0,5) == "TOKEN"){
		 
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);	
		 	 
			// ADD ON TOKENS
			if( is_numeric($ob[1]) && $ob[1] > 0){	
			 
						$c = get_user_meta($data['user_id'],'ppt_usertokens', true);
						$c1  = $c + $CORE->credit_exchangerate($data['order_total'], "token");
						update_user_meta($data['user_id'],'ppt_usertokens', $c1);
			}
			
		
		
		}elseif(substr($data['order_id'],0,5) == "RENEW"){	
		
		 	// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);
			
			if( is_numeric($ob[1]) && $ob[1] > 0){
			
				$POSTID = $ob[1];
				
				$pak = get_post_meta($POSTID,'packageID',true);
				
				// GET LISTING TIME AND ADD TIME
				$tnow = get_post_meta($POSTID, 'listing_expiry_date', true);	
				if($tnow == ""){ $tnow = date("Y-m-d H:i:s"); }
				
				$newdate = date("Y-m-d H:i:s", strtotime( $tnow . " +"._ppt('pak'.$pak.'_duration')." days"));
				 
				update_post_meta($POSTID, 'listing_expiry_date', $newdate );
				
				// UPDATE THE ORDER DATA TO INCLUDE THE POST ID FOR GETTING INVOICES LATER
				update_post_meta($data['ID'],'post_id', $ob[1]);
				
				// SET STATUS TO LIVE
				$my_post = array();
				$my_post['ID'] 					= $ob[1];
				$my_post['post_status']			= "publish";
				wp_update_post( $my_post  );
				 
			
			}
		
		}elseif(substr($data['order_id'],0,7) == "INVOICE"){	
			
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']); 
		 	 
			if( is_numeric($ob[2]) && $ob[2] > 0){
			
			update_post_meta($ob[2],'payment_complete', date('Y-m-d H:i:s') );
			update_post_meta($ob[2],'invoice_status', 5);
			
			
			} 
 	 
		// CHECK IF THIS IS A SELLSPACE PAYMENT
		}elseif(substr($data['order_id'],0,3) == "BAN"){
		
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);
			
			// CREATE A NEW CAMPAIGN
			$my_post = array();
			$my_post['post_title'] 		= "User Campaign #".$data['order_id'];
			$my_post['post_content'] 	= "";
			$my_post['post_excerpt'] 	= "";
			$my_post['post_status'] 	= "publish";
			$my_post['post_type'] 		= "ppt_campaign";
			$my_post['post_author'] 	= $userdata->ID;
			$POSTID 					= wp_insert_post( $my_post );
			 
			// GET BANNER DETAILS
			$sellspacedata = _ppt('sellspace'); 
			
			add_post_meta($POSTID, 'impressions', '0');	
			add_post_meta($POSTID, 'clicks', '0'); 
			add_post_meta($POSTID, 'bannerid', '0'); 
			add_post_meta($POSTID, 'location', $ob[1]);
			add_post_meta($POSTID, 'expires', date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " +".$sellspacedata[$ob[1]."_days"]." days")) );
			
			add_post_meta($POSTID, 'status', 'pending'); 

			
			 
		// SUBSCRIPTION PAYMENT
		}elseif( substr($data['order_id'] ,0,4) == "SUBS"){
	
			// GETKEY
			$ff = explode("-",$data['order_id']);
			
			// CHECK FOR NEW USER
			if($ff[2] == 0){
			$ff[2] = $data['user_id'];			
			}
			  
			// GET THE CREDITS AND TOKENS FOR THIS
			// SUBSCRIPTION AND UPDATE THE USERS ACCOUNT
			$days = _ppt($ff[1].'_duration'); //'mem'		
			if(!is_numeric($days)){
				$days = 30;								
			}
 			 
			// CHECK FOR EXISTING SUBSCRIPTION
			$f = get_user_meta($ff[2], 'ppt_subscription',true);
			if(is_array($f) && !empty($f) ){
			
				// ADD ON EXTRA TIME	
				if(in_array(_ppt(array('mem','paktime')), array("","1"))){		
					$da = $this->date_timediff($f['date_expires'],'');				 
					if($da['expired'] == 0){					
						$days += $da['date_array']['days']+($da['date_array']['months']*30);					
					}	
				}			
			} 
			
			// GET FOR FREE LISTINGS
			$c = _ppt($ff[1].'_listings_count');	 
			if(is_numeric($c)){ 			
				// CHECK IF THEY HAVE FREE LISTINGS ALREADY
				$current_free = get_user_meta($ff[2], 'free_listings_count',true);				 
				if(!is_numeric($current_free)){ $current_free = 0; }				
				$current_free = $current_free + $c;				
				update_user_meta($ff[2], 'free_listings_count', $current_free);				
			}
			
			// GET FOR FREE LISTINGS
			$c = _ppt($ff[1].'_listings_max_count');	 
			if(is_numeric($c)){ 			
				// CHECK IF THEY HAVE FREE LISTINGS ALREADY
				$current_free = get_user_meta($ff[2], 'free_listings_max_count',true);				 
				if(!is_numeric($current_free)){ $current_free = 0; }				
				$current_free = $current_free + $c;				
				update_user_meta($ff[2], 'free_listings_max_count', $current_free);				
			}
			
			// GET FOR FREE LISTINGS
			$c = _ppt($ff[1].'_max_msg_count');	 
			if(is_numeric($c)){ 			
				// CHECK IF THEY HAVE FREE LISTINGS ALREADY
				$current_free = get_user_meta($ff[2], 'max_msg_count',true);				 
				if(!is_numeric($current_free)){ $current_free = 100; }				
				$current_free = $current_free + $c;				
				update_user_meta($ff[2], 'max_msg_count', $current_free);				
			}
						
			// GET FOR FREE DOWNLOADS
			if(THEME_KEY == "so"){
				$c = _ppt($ff[1].'_downloads_count');	 
				if(is_numeric($c)){ 			
					// CHECK IF THEY HAVE FREE downloads ALREADY
					$current_free = get_user_meta($ff[2], 'free_downloads_count',true);				 
					if(!is_numeric($current_free)){ $current_free = 0; }				
					$current_free = $current_free + $c;					
					update_user_meta($ff[2], 'free_downloads_count', $current_free);				
				}
			}
		 	
			// 0 = UNLIMITED BUT WE SET A LONG EXPIRY DATE
			if($days == 0){
			$dd = date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " +10 years"));			
			}else{
			$dd =  date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " + ".$days." days"));
			} 
			
			
			// CHECK FOR LAST UPDATED
			$lastupdated = get_user_meta($ff[2], "lastupdated", true);
			if($lastupdated == ""){
				$lastupdated = date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +21 minutes"));
			}
			
			// ADMIN TESTING
			if(current_user_can('administrator') ){			
			$lastupdated = date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +21 minutes"));
			}
			
			if(strtotime($lastupdated) > strtotime(date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +20 minutes"))) ){
			 	
				
				// REQUIRED APPROVAL?
				$app = 1;
				if( _ppt($ff[1].'_approval') == '1'){
				$app = 0;
				}				
				
				// SAVE THE SUBSCRIPTION TO THE USERS ACCOUNT
				update_user_meta($ff[2],'ppt_subscription', 
					array(
						"key" 			=> $ff[1] , 
						"date_start" 	=> date("Y-m-d-H:i:s"), 
						"date_expires" 	=> $dd,	
						"approved" 		=> $app,				
					)
				);
				
				update_user_meta($ff[2], "lastupdated", date("Y-m-d H:i:s") );				 
			
			}
			 	 
		
		}elseif( substr($data['order_id'] ,0,4) == "CART"){		
		
	 	 
			// BREAK DOWN ID
			$ob = explode("-",$data['order_id']);				 
			 
			// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
			$ex = $CORE->ORDER("check_exists", $data['order_id']);
						 
			if(is_numeric($ex) && $ex != 0){
			
				// NOW LETS UPDATE THE ORDER STATUS
				update_post_meta($ex, "order_status", 1);
				update_post_meta($ex, "order_process", 3);				
				update_post_meta($ex,'order_paid',date("Y-m-d-H:i:s"));			
				
			}
 			
			// NOW GET CART DATA
			$SQL = "SELECT * FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".strip_tags($ob[1])."') LIMIT 1";
			$hassession = $wpdb->get_results($SQL, OBJECT);
		
			if(!empty($hassession)){
			 	
				// RESTORE THE CART DATA
				$cart_data = unserialize($hassession[0]->session_data); 
				 	 		 
				// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
				if(isset($cart_data['items']) && is_array($cart_data['items'])){
				 
				  
					// UPDATE SHIPPING
					update_post_meta($ex,'order_shipping', $cart_data['shipping'] );
					update_post_meta($ex,'order_tax', $cart_data['tax'] );
					update_post_meta($ex,'order_discount', $cart_data['discount'] );					
					update_post_meta($ex,'order_discount_code', $cart_data['discount_code'] );				
					update_post_meta($ex,'order_id', $data['order_id'] );
					update_post_meta($ex, "order_userid", $cart_data['userid']);
					
					update_post_meta($ex, "order_email", $CORE->USER("get_email", $cart_data['userid']) );
										
					
					if(isset($_SESSION['ppt_cart']['comment'])){ 					
					update_post_meta($ex,'order_comment', $_SESSION['ppt_cart']['comment'] );
					}  		
				
					// CHECK FOR COMMENTS
					if($cart_data['userid'] == 0){ // GUEST CHECKOUT		
						$order_username = "Guest";	
						$order_useremail = $cart_data['guest_data']["billing_email"];							
					}else {
						$order_username = get_user_meta($cart_data['userid'], "billing_fname",true)." ".get_user_meta($cart_data['userid'], "billing_lname",true);	
						 
						$user_info = get_userdata($cart_data['userid']);
						//$userloginname = $user_info->user_login;
						$order_username = $user_info->user_nicename;
						$order_useremail = $user_info->user_email;										
					}	
					 
					
					$order_data_description = "\n\n\n********** Order Information **********\n\n";
					$order_data_description .= "Date : ".hook_date(date('Y-m-d H:i:s'))."\n";
					$order_data_description .= "Order ID : ".$data['order_id']."\n";				 
					$order_data_description .= "Items : ".count($cart_data['items'])."\n";												
					$order_data_description .= "Order Total : ".hook_price($cart_data['total'])."\n";
					
					// SEND EMAIL
					/*	
					$all_emails = _ppt('emails');					
					if(isset($all_emails['admin_order_new']['enable']) && $all_emails['admin_order_new']['enable'] == 1){
									
						$data1 = array(		
								"username" 		=> $order_username,	
								"description" 	=> $order_data_description,
								"order_id" 		=> $data['order_id'],								
								"order_email" 	=> $order_useremail,								 
						);															
												
						$CORE->email_system('admin', 'admin_order_new', $data1);
											
					}
					if(isset($all_emails['order_new_sccuess']['enable'] ) && $all_emails['order_new_sccuess']['enable'] == 1){
										
						$data1 = array(		
								"username" 		=> $order_username,	
								"description" 	=> $order_data_description,
								"order_id" 		=> $data['order_id'],								
								"order_email" 	=> $order_useremail,								 
						); 
										
						$CORE->email_system($order_useremail, 'order_new_sccuess', $data1);
					}
					*/
							
				
					// UPDATE ORDER QTY AND DATA ITEMS
					$itemslist = "";
					foreach($cart_data['items'] as $key => $item){
								foreach($item as $mainitem){
								
									$itemslist .= $key." ";								
								
									// UPDATE PURCHASE COUNTER
									$purchased = get_post_meta($key,'purchased',true);
									if($purchased == ""){ $purchased = 0; }									
									update_post_meta($key,'purchased', ( $purchased + 1 ));
									
									// UPDATE STOCK COUNT
									if(get_post_meta($key,'stock_remove',true) == "1"){									
									
										// CHECK IF WE ARE USING THE PRICE-ON SYSTEM
										if(get_post_meta($key,'price-on',true) == 1 && isset($mainitem['custom_data']) ){										
											 	// LET CUSTOM DATA HANDLE IT
										}else{											
											// UPDATE
											update_post_meta($key,'qty',get_post_meta($key,'qty',true)-$mainitem['qty']);
										}
									}
								 
				
						} }
						
				
				}// END ITEMS
				
				
				// UPDATE PRODUCT ITEMS
				update_post_meta($ex,'order_postid', $itemslist ); /// still needed?
				 
					
				
						
			} // END HAS SESSOPM 
	
		}
		
	}// end if


return $data;


}
  	
	
	
	 
	
}

?>