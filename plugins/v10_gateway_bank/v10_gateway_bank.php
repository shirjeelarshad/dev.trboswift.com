<?php
/*
Plugin Name: [GATEWAY V10] - Bank Payment Form
Plugin URI: http://www.premiumpress.com
Description: This plugin will let you add your bank details for the user to pay you manually.
Version: 1.1
Author: Mark Fail
Author URI: http://www.premiumpress.com
Updated: Feb 10th 2021
License:
*/

//1. HOOK INTO THE GATEWAY ARRAY
function v10_gateway_bank_admin($gateways){
	$nId = count($gateways)+1;
	$gateways[$nId]['name'] 		= "Bank Details Form";
	$gateways[$nId]['logo'] 		= plugins_url()."/v10_gateway_bank/img/icon.jpg";
	$gateways[$nId]['function'] 	= "v10_gateway_bank_form";
	$gateways[$nId]['website'] 		= "http://www.premiumpress.com";
	$gateways[$nId]['callback'] 	= "yes";
	$gateways[$nId]['ownform'] 		= "yes";
	$gateways[$nId]['notes'] 		= "The bank details you enter above will be displayed to the user where payment is required. They will need to go to their bank and deposit the funds into your account manually and once you have confirmed payment you'll need to update their listing/account manually.<style>#accordion textarea{height:150px !important;} </style>";
	$gateways[$nId]['fields'] 		= array(
	
	'1' => array('name' => 'Enable Gateway', 'type' => 'listbox','fieldname' => $gateways[$nId]['function'],'list' => array('yes'=>'Enable','no'=>'Disable',) ),	 							
	'2' => array('name' => 'Bank Details', 'type' => 'textarea', 'fieldname' => 'bank_details'),
	'3' => array('name' => 'Display Name', 'type' => 'text', 'fieldname' => 'bank_displayname', 'default' => 'Online Bank Transfer'),
 
	);
 
	return $gateways;
}
add_action('hook_payments_gateways','v10_gateway_bank_admin');

//2. BUILD THE PAYMENT FORM DATA
function v10_gateway_bank_form($data=""){

	global $wpdb, $CORE, $userdata; 
	
	$gatewaycode = wpautop(stripslashes(get_option('bank_details')));

 
    /* DATA AVAILABLE
   
	$GLOBALS['total'] 	 
	$GLOBALS['subtotal'] 	 
	$GLOBALS['shipping'] 	 
	$GLOBALS['tax'] 		 
	$GLOBALS['discount'] 	 
	$GLOBALS['items'] 		 
	$GLOBALS['orderid'] 	 
	$GLOBALS['description'] 
    
    */
	
	ob_start();?>
 
 
    <div class="row">
        <div class="col-md-9">
        
        <b><?php echo get_option('bank_displayname'); ?></b>
        
        <?php echo $gatewaycode; ?>
        
        </div>
        <div class="col-md-3 paybutton">  
        
<form method="post"  action="<?php echo _ppt(array('links','callback')); ?>" name="checkout_bank">
<input type="hidden" name="credit_total" id="credit_total" value="<?php echo $GLOBALS['total']; ?>" />
<input type="hidden" name="custombank" value="<?php echo $GLOBALS['orderid']; ?>">	
<input type="hidden" name="item_name" value="Ngân hàng">			 
<input type="hidden" name="amount" value="<?php echo $GLOBALS['total']; ?>">	
<button class="btn btn-primary btn-block font-weight-bold text-uppercase mt-3" type="submit"><?php echo __("Continue","premiumpress"); ?></button>
							
</form>
         
        </div>
        <div class="clearfix"></div>
    </div>
 
<?php
$gatewaycode = ob_get_contents();
ob_end_clean();
return $gatewaycode;
 
}

// 3. HANDLE THE CALLBACK 
function v9_gateway_bank_callback(){ global $CORE, $userdata;
 
 	 
	if(isset($_POST['custombank']) && strlen($_POST['custombank']) > 1 ){ 
	   


	// PASS IN DATA
		$data = core_generic_gateway_callback($_POST['custombank'], array(
				'description' =>  "Tiền đặt cọc mua xe nhanh", 
				'email' => $CORE->USER("get_email", $userdata->ID), 
				'shipping' => 0, 
				'shipping_label' => '', 
				'tax' => 0,
				'payment_data' => "",
				'gateway_name' => 'Ngân hàng',
				'amount' => str_replace(",","",$_POST['amount']) ) 	 				
				);
			 
			
			// SET ORDER TO PENDING
			update_post_meta($data['ID'],'order_status', 2);
			 
			// die(print_r($data->ID));
			 
		return $data; 
	} 	
}

add_action('hook_callback','v9_gateway_bank_callback');
?>