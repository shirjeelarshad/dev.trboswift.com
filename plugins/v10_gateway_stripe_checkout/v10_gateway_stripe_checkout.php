<?php
/*
Plugin Name: [GATEWAY V10] - Stripe Checkout
Plugin URI: http://www.rancoded.com
Description: This plugin will add stripe to your  payment gateways list.
Version: 2.1
Author: Mark Fail
Author URI: http://www.rancoded.com
Updated: Oct, 17th 2021
License:
*/

 

//1. HOOK INTO THE GATEWAY ARRAY
function v10_gateway_stripe_checkout_admin($gateways){
	$nId = count($gateways)+1;
	$gateways[$nId]['name'] 		= "Stripe (Checkout)";
	$gateways[$nId]['logo'] 		= plugins_url( 'img/logo.jpg' , __FILE__ ); // plugins_url()."/v10_gateway_stripe_checkout/img/logo.svg";
	$gateways[$nId]['function'] 	= "v10_gateway_stripe_checkout";
	$gateways[$nId]['website'] 		= "http://www.stripe.com";
	$gateways[$nId]['callback'] 	= "yes";
	$gateways[$nId]['ownform'] 		= "no";
	$gateways[$nId]['recurring'] 	= "yes";
	$gateways[$nId]['fields'] 		= array(
	
	'1' => array('name' => 'Enable Gateway', 'type' => 'listbox','fieldname' => $gateways[$nId]['function'],'list' => array('yes'=>'Enable','no'=>'Disable',) ),
 	
	'2' => array('name' => 'API Secret Key', 'type' => 'text', 'fieldname' => 'stripe_secret'),
 
	'3' => array('name' => 'API Publishable Key', 'type' => 'text', 'fieldname' => 'stripe_production'),
 	
	'4' => array('name' => 'Currency Code', 'type' => 'text', 'fieldname' => 'stripe_currency', 'default' => 'GBP'),
	 
	'5' => array('name' => 'Display Name', 'type' => 'text', 'fieldname' => 'v10_gateway_stripe_checkout_name', 'default' => 'Pay with stripe'),
	 
	//'6' => array('name' => 'Connect Link (optional)', 'type' => 'text', 'fieldname' => 'stripe_connectlink', 'default' => ''),
	
	//'7' => array('name' => 'Connect ID (optional)', 'type' => 'text', 'fieldname' => 'stripe_connectid', 'default' => 'acct_xxxx'),
	
	6 => array('name' => 'Enable Recurring Payments', 'type' => 'listbox','fieldname' => 'strip_r','list' => array('yes'=>'Enable','no'=>'Disable',) ),
 
	
 	
	
	);
	$gateways[$nId]['notes'] 	= "";
	
	/*
	A list of stripe curreny codes can be found <a href='https://support.stripe.com/questions/which-currencies-does-stripe-support' target='_blank' style='text-decoration:underline;'>here</a>
 
	".' <br><br><label>Stripe Connect Link</label>
        
         <p>This is used mostly for the auction/micro jobs theme. It allows partial payments. <br> You can find it here under <b>Create the OAuth link</b>;</p>
         
         <p><a href="https://stripe.com/docs/connect/standard-accounts" target="_blank">https://stripe.com/docs/connect/standard-accounts</a></p>   
	*/
	
	return $gateways;
}
add_action('hook_payments_gateways','v10_gateway_stripe_checkout_admin');



//2. BUILD THE PAYMENT FORM DATA
function v10_gateway_stripe_checkout($data = "") {
    global $CORE, $userdata;
    
    $user_id = $userdata->ID;
    

    if ($GLOBALS['description'] == "") {
		$GLOBALS['description'] = $GLOBALS['orderid'];
	}

	// DECODE DATA
	$data = $CORE->order_decode($_POST['details']);

    // Calculate amount
    $amount = v10_gateway_stripe_checkout_callback_amount($data->amount + $GLOBALS['tax']);
    
    if (strlen($GLOBALS['CORE_THEME']['links']['callback']) < 20) {
		$GLOBALS['CORE_THEME']['links']['callback'] = home_url() . "/callback/";
	}

    if (!class_exists('Stripe')) {
        require('stripe-php-13.16.0/init.php');
    }

    // Set your secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));
    
    $customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
    $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
    $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;

ob_start();
?>

<div class="payment-checkout-form">

    <div class="errors-section mt-2" role="alert"></div>
</div>

<div class="new-card-btn">
<button onClick="addStripePaymentMethod();" class="btn btn-light btn-block font-weight-bold text-uppercase mt-3">
        <?php echo __("Pay With New Card", "premiumpress"); ?>
    </button>
</div>
<script>

checkUserPaymentMethods();
function checkUserPaymentMethods() {

var ceck_customer_id = '<?php if($isLiveMode){echo $customer_live_id; }else{ echo $customer_id;} ?>';

if (ceck_customer_id){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'retrieve_all_payment_methods',
            user_id: '<?php echo $user_id; ?>',
            nonce: '<?php echo wp_create_nonce('retrieve_all_payment_methods_nonce'); ?>'
        },
        success: function(response) {
            if (response.success && response.data.payment_methods.length > 0) {
                // Payment methods exist, hide modal and continue
                checkoutAllPaymentMethods();
            } else {
                // No payment methods, show modal to add new card
               addStripePaymentMethod();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            // Handle error scenario
        }
    });
    
    } else {
    addStripePaymentMethod();
    }
    
}



var setupIntentButton = document.getElementById('setup-intent-button');

 function payNowCheckout() {
        // Send AJAX request to attach payment method
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'initiate_stripe_payment',
                        amount: '<?php echo $amount; ?>',
                        order_id: '<?php echo $GLOBALS['orderid']; ?>',
                        description: '<?php echo $GLOBALS['description']; ?>',
                        nonce: '<?php echo wp_create_nonce('stripe_payment_nonce'); ?>'
            },
            success: function(response) {
         	console.log('Payment data insert Successfull:', response);
           
            
         	// Disable button to prevent multiple clicks
            if(response.success){
          jQuery('.new-card-btn').html('');
         jQuery('.payment-checkout-form').html(
        '<div class="alert alert-success" role="alert">' +
        '<h4>Payment successfully complete</h4>' +
        '</div>'
        );
        }else {
        if (jQuery('#setup-intent-button').length) {
     		setupIntentButton.disabled = false;
			}
        if (jQuery('.errors-section').length) {
     		jQuery('.errors-section').html(
        '<div class="alert alert-danger mt-2" role="alert">' +
        '<h5>Payment canceled!</h5>' +
        '</div>'
        )
			}
        
   		}
        
        
            
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                setupIntentButton.disabled = false;
                jQuery('.errors-section').html(
        '<div class="alert alert-danger mt-2" role="alert">' +
        '<h5>Payment canceled!</h5>' +
        '</div>'
    );
            }
        });
    }
    
    
    function addStripePaymentMethod() {
        jQuery('#stripe-card-content').empty();
        
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_card_save_container',
                user_id: '<?php echo $user_id; ?>',
                nonce: '<?php echo wp_create_nonce('add_stripe_payment_methods_nonce'); ?>'
            },
            success: function(response) {
            
                jQuery('.new-card-btn').html('');
                jQuery('.payment-checkout-form').html(response);
                jQuery('#submit-button').html('Pay Now');
                
               
            }
        });
    }
    
    
    
    
     function checkoutAllPaymentMethods() {
        // Send AJAX request to retrieve all payment methods for the customer
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'retrieve_all_payment_methods',
                user_id: '<?php echo $user_id; ?>',
                nonce: '<?php echo wp_create_nonce('retrieve_all_payment_methods_nonce'); ?>'
            },
            success: function(response) {
                
                // Display all payment methods in the .all-payment-methods div
                if (response.success && response.data.payment_methods.length > 0) {
                
                    var paymentMethods = response.data.payment_methods;
                var paymentMethodsHTML = '';

                paymentMethods.forEach(function(method) {
                    paymentMethodsHTML += '<div class="credit-card ' + method.card.brand + ' selectable" data-payment-method-id="' + method.id + '" data-payment-method-brand="' + method.card.brand + '">';

                    paymentMethodsHTML += '<div class="set-pay-card">';
                    paymentMethodsHTML += '<div class="d-flex align-items-center">';
                    paymentMethodsHTML += '<div class="pr-2 text-capitalize brandName">' + method.card.brand + '</div>';
                    paymentMethodsHTML += '<div class="pr-2 credit-card-last4">' + method.card.last4 + '</div>';

                    if (method.id === response.data.default_payment_method) {
                        paymentMethodsHTML += '<span class="badge bg-info ">Selected</span>';
                    }

                    paymentMethodsHTML += '</div>';

                    paymentMethodsHTML += '<div class="pt-3 credit-card-expiry">' + method.card.exp_month + ' / ' + method.card.exp_year + '</div>';
                    paymentMethodsHTML += '</div>';
                    paymentMethodsHTML += '<a class="text-white pr-2 pt-2 set-default-btn" title="Set as default"><i class="fas fa-ellipsis-h"></i></a>';
                    paymentMethodsHTML += '<a class="pr-2 remove-method-btn"><i class="fas fa-ban"></i> Remove</a>';
                    paymentMethodsHTML += '</div>';
                });

                document.querySelector('.payment-checkout-form').innerHTML = paymentMethodsHTML;

// Add event listener to set default button
document.querySelectorAll('.set-pay-card').forEach(function(button) {
    button.addEventListener('click', function() {
        var paymentMethodId = this.closest('.credit-card').getAttribute('data-payment-method-id');
        setPaymentCardMethod(paymentMethodId);
    });
});

// Add event listener to remove button
document.querySelectorAll('.remove-method-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var paymentMethodId = this.closest('.credit-card').getAttribute('data-payment-method-id');
        var paymentMethodBrand = this.closest('.credit-card').getAttribute('data-payment-method-brand');
        removePayCard(paymentMethodBrand, paymentMethodId);
    });
});
                    
                } else {
                   addStripePaymentMethod();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }
    
    
     function setPaymentCardMethod(paymentMethodId) {
        // Send AJAX request to set default payment method
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_default_payment_method',
                payment_method_id: paymentMethodId,
                nonce: '<?php echo wp_create_nonce('set_default_payment_method_nonce'); ?>'
            },
            success: function(response) {
                
        jQuery('.payment-checkout-form').html('<div><button onClick="payNowCheckout();" id="setup-intent-button" class="btn btn-primary btn-block font-weight-bold text-uppercase mt-3"><?php echo __("Pay Now", "premiumpress"); ?></button><button onClick="checkoutAllPaymentMethods();" id="setup-intent-button" class="btn btn-info btn-block font-weight-bold text-uppercase mt-3"><?php echo __("Select another card", "premiumpress"); ?></button></div>');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }
    
    
    
    function removePayCard(paymentMethodBrand, paymentMethodId) {
    jQuery('#stripe-card-content').empty();

    // Construct the function call as a string
    var detachFunctionCall = 'deletePaymentMethod("'+ paymentMethodId +'");';
    var noFunctionCall = 'checkoutAllPaymentMethods();';

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'delete_payment_user_card',
            message: 'Are you sure you want to remove this',
            card_name: paymentMethodBrand,
            yes_btn_call: detachFunctionCall,
            no_btn_call: noFunctionCall,
            
        },
        success: function(response) {
            
            jQuery('.payment-checkout-form').html(response);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            // Handle error here (e.g., display error message)
        }
    });
}

    

    
    
    
     function deletePaymentMethod(paymentMethodId) {
     jQuery('.add-stripe-card-modal-wrap').fadeOut(400);
    // Send AJAX request to detach payment method
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'remove_payment_method',
            user_id: '<?php echo $user_id; ?>',
            payment_method_id: paymentMethodId,
            nonce: '<?php echo wp_create_nonce('remove_payment_method_nonce'); ?>'
        },
        success: function(response) {
           
            // Refresh payment methods list after detaching payment method
            checkoutAllPaymentMethods();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            // Handle error response
        }
    });
}



</script>

<?php

    $gatewaycode = ob_get_clean();

    return $gatewaycode;
}





function v10_gateway_stripe_checkout_callback_amount($input_amount)
{

	// UPDATE AMOUNT
	if (get_option('stripe_currency') == "JPY") {
		$amount = (str_replace(",", "", $input_amount));
	} else {
		$amount = (str_replace(",", "", $input_amount) * 100);
	}

	return $amount;

}


?>