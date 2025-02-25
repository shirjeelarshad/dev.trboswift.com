<?php
$core_gateways = array();
$core_gateways[1]['name'] 		= "OnePAY payment gateway";
$core_gateways[1]['function'] 	= "gateway_onepay";
$core_gateways[1]['website'] 	= "http://onepay.vn";
$core_gateways[1]['logo'] 		= "";
$core_gateways[1]['callback'] 	= "yes";
 

$core_gateways[1]['fields'] 	= array(
'1' => array('name' => 'Gateway', 'type' => 'listbox', 'fieldname' => 'gateway_onepay','list' => array('yes'=>'Enable','no'=>'Disable')),					 

'2' => array('name' => 'OnePAY URL', 'type' => 'text', 'fieldname' => 'onepay_url', 'default' => 'https://mtf.onepay.vn/paygate/vpcpay.op'),
'3' => array('name' => 'Currency Code', 'type' => 'text', 'fieldname' => 'nlcurrency', 'default' => 'vnd'),
'4' => array('name' => 'Display Name -or- Image URL', 'type' => 'text', 'fieldname' => 'gateway_onepay_name', 'default' => 'OnePay') ,
					 
'5' => array('name' => 'Language', 'type' => 'text', 'fieldname' => 'onepay_language', 'default' => 'vn'),

 '6' => array('name' => 'Merchant ID', 'type' => 'text', 'fieldname' => 'merchant_id', 'default' => 'TESTONEPAY32'),
 
 '7' => array('name' => 'Merchant Access Code', 'type' => 'text', 'fieldname' => 'merchant_access_code', 'default' => '6BEB2566'),
 
 '8' => array('name' => 'Secure Secret', 'type' => 'text', 'fieldname' => 'secure_secret', 'default' => '6D0870CDE5F24F34F3915FB0045120D6')

);
$core_gateways[1]['notes'] 	= "";
$GLOBALS['core_gateways'] = $core_gateways;



// ---------------------------- GATEWAY CODE ------------------------
function gateway_onepay($data=""){

	global $CORE, $wpdb;
	 
 	$gatewaycode = "";	
	if(!isset($GLOBALS['pformid'])){	$GLOBALS['pformid'] = 1; }else{ $GLOBALS['pformid']++; }	
	 
	// DECODE DATA
	$data = $CORE->order_decode($data['details']); 
	 
	
	
	 if($data->description == ""){	 
		 $data->description = $data->order_id;
	 }
	 	
ob_start(); 

?>

<?php
// Function to generate OnePAY payment URL
function generateOnePayPaymentURL($order_id, $total, $description) {
    $onepayURL = get_option('onepay_url');
    $merchantID = get_option('merchant_id');
    $accessCode = get_option('merchant_access_code');
    $secureSecret = get_option('secure_secret');

    $amount = $total * 100; // Amount in cents
    $orderInfo = $order_id;
    $returnURL = "<?php echo home_url(); ?>/callback"; // Replace with your actual return page URL

    $params = array(
        'vpc_Version' => '2',
        'vpc_Command' => 'pay',
        'vpc_AccessCode' => $accessCode,
        'vpc_Merchant' => $merchantID,
        'vpc_MerchTxnRef' => $orderInfo,
        'vpc_OrderInfo' => $orderInfo,
        'vpc_Amount' => $amount,
        'vpc_ReturnURL' => $returnURL,
        'vpc_Locale' => 'vn',
        'vpc_Currency' => 'VND',
        'vpc_TicketNo' => $_SERVER["REMOTE_ADDR"]
    );

    ksort($params);

    $stringHashData = "";
    foreach ($params as $key => $value) {
        $stringHashData .= $key . "=" . $value . "&";
    }

    $stringHashData = rtrim($stringHashData, "&");

    $params['vpc_SecureHash'] = strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $secureSecret)));

    $paymentURL = $onepayURL . "?" . http_build_query($params);
    return $paymentURL;
}

// Button function to initiate payment
function displayPaymentButton($order_id) {
    $total = $GLOBALS['total'] ?? 0; // Replace with your actual total
    $description = $GLOBALS['description'] ?? ''; // Replace with your actual description

    $paymentURL = generateOnePayPaymentURL($order_id, $total, $description);

    $buttonHTML = '<a href="' . $paymentURL . '" class="btn btn-primary btn-block font-weight-bold text-uppercase mt-3" style="cursor:pointer">'.__("Pay Now","premiumpress") .'</a>';

    echo $buttonHTML;
}

// Example usage
$order_id = $GLOBALS['orderid'] ?? 0; // Replace with your actual order ID
displayPaymentButton($order_id);
?>


<?php
return ob_get_clean();
 

}

/*
	this function processes a new order
	for all payment gateways
	
	returns ORDERID
	
*/
function core_generic_gateway_callback($orderid, $data){ global $wpdb, $CORE, $userdata; $order_data_description = "";
 
	// MUST HAVE AN ORDER ID
	if($orderid == ""){ return; }	
	  
	// BUILD DATA TO SAVE INTO THE DATABASE
	$savadata = array(	
		'user_id'		=> '',
		'order_id'		=> $orderid,
		'order_ip' 		=> $_SERVER['REMOTE_ADDR'],
		'order_date' 	=> date("Y-m-d"),
		'order_time' 	=> date("H:i:s"),
		'order_data' 	=> '',
		'order_items' 	=> '', // USED TO HOLD THE LISTING IDS OR CART SESSION ID
		'order_email' 	=> '',
		'order_shipping' => 0,
		'order_tax' 	=> 0,
		'order_total' 	=> 0,
		'order_status' 	=> 1, // PAID	
		'user_login_name' => '',
		'shipping_label' 	=> '', 	
		'order_description' => '', // SHORT ORDER DESCRIPTION
		'order_gatewayname' => '', // USED FOR THE GATEWAY NAME (PAYPAL ETC)	
		'payment_data' 	=> '',			
	);
	
	// CHECK FOR SUBSCRIPTIONS
	if(isset($data['recurring']) && $data['recurring'] == 1){
	$savadata['order_status'] = 8; // recurring status
	}
		
 	  
	// SAVE ALL ORDER DATA FOR DEBUGGING
	$pstring = "";
	foreach($_POST as $k=>$v){ if(!is_array($k) && !is_array($v)){ $pstring .= $k.":".$v."\n"; } }		
	$data['paydata']		= $pstring;
	
	// FILL IN THE BLANKS FROM DATA PASSED VIA $orderdata	
	if(isset($data['amount']) && is_numeric($data['amount']) ){ $savadata['order_total'] =  $data['amount']; }
	if(isset($data['tax']) && is_numeric($data['tax']) ){ $savadata['order_tax'] =  $data['tax']; }
	if(isset($data['shipping']) && is_numeric($data['shipping']) ){ $savadata['order_shipping'] =  $data['shipping']; } 
	if(isset($data['description']) && strlen($data['description']) > 1 ){ $savadata['order_description'] = $data['description']; }	
	if(isset($data['gateway_name']) ){  $savadata['order_gatewayname'] =  $data['gateway_name']; }	
	if(isset($data['payment_data']) && strlen($data['payment_data']) > 1 ){  $savadata['payment_data'] = $data['payment_data']; }
	

	
	$orderbits = explode("-",$orderid);
	if(isset($orderbits[0]) && in_array($orderbits[0], array("LST","UPGRADE"))){
	$savadata['order_items'] =  $orderbits[1];	
	}
	 	 
	
	// CHECK FOR USER SESSION
	if($userdata->ID){
	
		$savadata['user_id'] 			=  $userdata->ID;
		$savadata['user_login_name'] 	= $userdata->user_login; 
		
		if(isset($data['email'])){
			$savadata['order_email'] 		=  $data['email'];
		}
		
		
	} elseif ( isset($data['email']) && strlen($data['email']) > 1 && email_exists($data['email']) ){
	 				
		$author_id 					= email_exists($data['email']);		
		$savadata['user_id']		= $author_id;		
		$savadata['order_email'] 	= $data['email'];		
		$savadata['user_login_name']= get_the_author_meta('user_login', $author_id);	 
				
	}else{
	
		$savadata['user_id'] 			= 1;
		$savadata['user_login_name'] 	= "Guest";
		
		if(isset($data['email']) && $data['email'] != ""  ){ $savadata['order_email'] =  $data['email']; }else{ $savadata['order_email'] = "no-email-recorded@noone.com"; }
		
	}
	
	
	$savadata['user_id'] = $CORE->ORDER('order_id_user_id', $orderid); 
	    
	// ADD NEW ORDER
	$orderadd = $CORE->ORDER('add',$savadata); 
 
	// ADD TO ARRAY
	$savadata['ID'] =  $orderadd['orderid'];
 	$savadata['IDFORMATTED'] =  $CORE->ORDER("format_id",$orderadd['orderid']); 
	  
	// HOOK FOR ALL MAIN THEME ACTIONS
	//if($orderadd['type'] == "new"){
	$savadata = hook_v9_order_process( $savadata );	// KEEP THIS FOR CHILD THEME HOOKS	
		 
	//}  
 	
	// ADD LOG
	$CORE->FUNC("add_log",
			array(				 
						"type" 		=> "order",	
									
						"postid"	=> $savadata['order_items'],
									
						"to" 			=> $savadata['user_id'], 						
						"post_name" 	=> $savadata['order_description'], 					
									  
						"alert_uid1" 	=>  $savadata['user_id'],
									 
									
						"email_data" 	=> array(	
							"user_id" 		=> $savadata['user_id'],	
																
							"username" 		=> $CORE->USER("get_username", $savadata['user_id']),
							"from_username" => $CORE->USER("get_username", $savadata['user_id']),
							"total" 		=> hook_price($savadata['order_total']), 												
							"first_name" 	=> $CORE->USER("get_firstname", $savadata['user_id']),
							"last_name" 	=> $CORE->USER("get_lastname", $savadata['user_id']),												 
							"email" 		=> $CORE->USER("get_email", $savadata['user_id']),												
							"orderid" 		=> $orderid, 												
							"post_name" 	=> $savadata['order_description'], 		 
					),
			)
		); 
						
						
		// SEND EMAIL
		$data1 = array(						
			"from_username" 	=> $CORE->USER("get_username", $savadata['user_id'] ), 
			"total" 			=> hook_price($savadata['order_total']), 
			"post_name" 		=> $savadata['order_description'], 							
		);
		$CORE->email_system("admin", "admin_order_new", $data1);
	
	
	
	 
	// RETURN SAVE DATA
	return $savadata;
	

}

function core_onepay_callback($c){
	 
	global $wpdb, $CORE, $userdata;
 	 
	// CHECK IF WE HAVE RECEIVED DATA FROM ONEPAY
	if (isset($_GET['vpc_TxnResponseCode']) && $_GET['vpc_TxnResponseCode'] == "0") {
		// Payment was successful

		$order_id = isset($_GET['vpc_MerchTxnRef']) ? $_GET['vpc_MerchTxnRef'] : '';

		$data = core_generic_gateway_callback($order_id, array(
			"gateway_name" => "OnePay Payment",
			"amount" => isset($_GET['vpc_Amount']) ? ($_GET['vpc_Amount'] / 100) : 0,
			"tax" => 0, // You may need to adjust this based on your requirements
			"shipping" => 0, // You may need to adjust this based on your requirements
			"email" => '', // You may need to adjust this based on your requirements
			'description' => isset($_GET['vpc_OrderInfo']) ? $_GET['vpc_OrderInfo'] : '',
		));

		return $data;
	} elseif (isset($_GET['cancel'])) {
		// Payment was canceled
		return "error";
	}

	// Return existing value for other gateways
	return $c;
}


function core_token_callback($c){

	global $wpdb, $CORE, $userdata;
 
	 
	// CHECK WE HAVE received DATA FROM PAYPAL
	if(isset($_POST['tokenpurchase'])  && is_numeric($_POST['tokenpurchase']) && $_POST['tokenpurchase'] > 0  ){
	  	
		$usercredit = get_user_meta($userdata->ID,'ppt_usertokens',true);
		if(isset($usercredit) && is_numeric($usercredit) && $usercredit >= $_POST['total']){ 
		
			update_user_meta($userdata->ID,'ppt_usertokens', get_user_meta($userdata->ID,'ppt_usertokens', true) - $_POST['total'] ); 
			
			$data = core_generic_gateway_callback($_POST['custom'], 		
				array(
				
					"gateway_name" => "Token Payment",
					"amount" => $_POST['total'],
					"email" =>  $userdata->user_email,
					'description' =>  $_POST['item_name'],
				) 
			);
				
			return $data;
		
		}else{ 	
			return "error";			
		}	
	}
		
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;

}



function core_free_order_callback($c){ global $userdata;

 		 
		if(isset($c['free_payment_order']) && $c['amount'] == 0){		
		 
			 return core_generic_gateway_callback($c['custom'], 		
				array(
				
					"gateway_name" => "Free Order",
					"amount" => $c['amount'],
					"email" => $userdata->user_email,
					"description" => $c['description'],
				) 
			);	
					
		}elseif(isset($_POST['free_payment_order']) && $_POST['amount'] == 0){		
		 
			 return core_generic_gateway_callback($_POST['custom'], 		
				array(
				
					"gateway_name" => "Free Order",
					"amount" => $_POST['amount'],
					"email" => $userdata->user_email,
					"description" => $_POST['description'],
				) 
			);			
		}
		
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;
}


function core_admin_test_callback($c){


 		if(isset($_POST['admin_test_callback'])){	
		 
		 	$data = core_generic_gateway_callback(
			
				$_POST['custom'], // <-- ORDER ID 		
				
				array(
				
					"gateway_name" 	=> "Admin Test",
					"amount" 		=> 	$_POST['amount'],
					"email" 		=> 	$_POST['email'],
					"description" 	=> 	$_POST['description'],
					"recurring" 	=> 	$_POST['subscription'],
				)
				
			);
		 
			return $data;	
			
		}
		
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;
}

function core_usercredit_callback($c){

	global $wpdb, $CORE, $userdata;
	
 	 
	// CHECK WE HAVE received DATA FROM PAYPAL
	if(isset($_POST['credit_total'])  && is_numeric($_POST['credit_total']) && $_POST['credit_total'] > 0 && isset($_POST['custom'])  ){ //&& $CORE->ORDEREXISTS($_POST['custom']) == false
		 
		$usercredit = get_user_meta($userdata->ID,'ppt_usercredit',true);
		
		if(isset($usercredit) && is_numeric($usercredit) && $usercredit >= $_POST['credit_total']){ 
			
			update_user_meta($userdata->ID,'ppt_usercredit', get_user_meta($userdata->ID,'ppt_usercredit',true) - $_POST['credit_total'] );
			
			// SUCCESS AND PASS IN DATA
			$data = core_generic_gateway_callback(
				$_POST['custom'], 				
				array(
					"gateway_name" 	=> "User Credit",
					'description' 	=>  $_POST['item_name'], 
					'email' 		=> $userdata->user_email, 
					'shipping' 		=> '', 
					'shipping_label' => '', 
					'tax' 			=> 0, 
					'amount' 		=> $_POST['credit_total'],
				)		
			 );
			 
			 
			return $data;	
			
		}
			
	}
	
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;

}

function core_free_upgrade_callback($c){

	global $wpdb, $CORE, $userdata;
	
 	 
	// CHECK WE HAVE received DATA FROM PAYPAL
	if(isset($_POST['free_upgrade'])  && $_POST['free_upgrade'] == 1  ){  
	 
		
		if( $CORE->USER("membership_hasaccess", "listings") && $CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID)) >  0){ 
			
			// UPDATE LISTING TOTAL
			$CORE->USER("update_user_free_membership_addon", array("listings", $userdata->ID) );		
			
			// SUCCESS AND PASS IN DATA
			$data = core_generic_gateway_callback($_POST['orderid'], 
			
					array(
						'description' =>  $_POST['description'], 
						'email' => $CORE->USER("get_email", $userdata->ID), 
						'shipping' => '', 
						'shipping_label' => '', 
						'tax' => 0, 
						'amount' => 0					
					) 
				);
			 
			return $data;	
			
		}	
	}
	
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;

}


?>