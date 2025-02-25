<?php

 
class framework_cart {

	function __construct(){ global $CORE;
	
		// DEFAULT FIELDS FOR THE SHOP
		$this->shop_user_fields = array(
	
			"sep"  => array( "type" => "sep", "caption" => __("Delivery Name &amp; Contact","premiumpress")  ),		
			"billing_fname" => array( "type" => "text", "caption" => __("First Name","premiumpress") ),
			"billing_lname" => array( "type" => "text", "caption" => __("Last Name","premiumpress") ),
			"billing_phone" => array( "type" => "text", "caption" => __("Telephone","premiumpress") ),
			"billing_email" => array( "type" => "text", "caption" => __("Email","premiumpress") ),
			"sep1"  => array( "type" => "sep", "caption" => __("Delivery Address","premiumpress") ),
			"billing_company" => array( "type" => "text", "caption" => __("Company Name","premiumpress"), "nr" => true ), // NOT REQUIRED
			"billing_address" => array( "type" => "text", "caption" => __("Address","premiumpress") ),
			"billing_country" => array( "type" => "country", "caption" => __("Country","premiumpress") ),
			"billing_city" => array( "type" => "text", "caption" => __("City","premiumpress") ),
			"billing_state" => array( "type" => "state", "caption" => __("State","premiumpress") ),
			"billing_zip" => array( "type" => "text", "caption" => __("Zip/Postal Code","premiumpress") ),
			//"sep3"  => array( "type" => "sep", "caption" => "Delivery Method" ),
			//"billing_method" => array( "type" => "text", "caption" => "Method" ),
	 
			"billing_comments" => array( "type" => "hidden", "caption" => __("Comments","premiumpress"), "nr" => true ),			
		);
		
 		 
		add_shortcode( 'ADDCART', array($this,'shortcode_addtocart') );	
	 	add_shortcode( 'OLD-PRICE', array($this,'shortcode_oldprice') );	
		add_shortcode( 'DOWNLOADS', array($this,'shortcode_downloads') );
	 	 
		
		// LOAD IN JAVASCRIPT
		if(!is_admin()){		
		add_action('wp_footer',array($this,'_shop_footer'));
 		}
		
		// ADD ON  PAGE LINK
		add_action('hook_admin_1_tab1_subtab2_pagelist', array($this,'_updatepagelist' ));
		
		
		 // CHECK FOR GUEST DATA
		add_action('init', array($this , 'cart_checkout_save' ) );
			
		// HOOK INTO INIT FOR DOWNLOAD
		add_action('init', array($this, '_downloadproduct' ) );	
			
		// HOOK INTO USERS ACCOUNT AND ADD IN BILLING/DELIVERY ADDRESS FIELDS		 
		add_action('hook_account_update', array($this, 'cart_update_userfields' ) );
		add_action('hook_account_userfields_after', array($this, '_hook_account_userfields_after'));
		
		
		// HANDLE NEW PAYMENTS
		//add_action('hook_callback_process_orderid', array($this, '_hook_callback_process_orderid') );
		
		// APPLY SHIPPING CHARGES
		add_action('hook_cart_data', array( $this, 'shipping_charges') );
		
		
	}
	
function shortcode_downloads( $atts, $content = null ) { global $userdata, $CORE, $post; $STRING = "";  $HIDDENDATA = "";
	 
	
	$downlaods = get_post_meta($post->ID, 'download_count', true);
	if($downlaods == ""){ $downlaods = 0; } 
	
	return number_format($downlaods);
	
}

function shortcode_oldprice( $atts, $content = null ) { global $CORE, $post;

		extract( shortcode_atts( array(), $atts ) );
		
		$oldprice = get_post_meta($post->ID,"old_price",true);
	 
		if(is_numeric($oldprice) > 0 && $oldprice != 0){
		
			return "<span style='text-decoration: line-through;' class='".$CORE->GEO("price_formatting",array())."'>".hook_price($oldprice)."</span>";
		}
		
} 

function shipping_charges($cart){ global $userdata;

if(is_admin()){ return $cart; }

// CHECK WE HAVE A POSiTIVE QTY
if($cart['qty'] < 1){ return $cart; }
 

// MAKE A BACKUP OF ORGINAL DATA
$backup = $cart; 

// SET NUMBER OF PRODUCTS EXEMPTY FROM TAX
$tax_exempt_product_count = 0; 


// RCOUNTRY WEIGHT SHIPPING
$countryship 	= _ppt('countryship');

// REGIONS
$regions = _ppt('regions');  

// GET THE USERS DELIVERY COUNTRY
$delivery_country = get_user_meta($userdata->ID,"billing_country",true);
if(isset($_POST['billing_country']) && strlen($_POST['billing_country']) > 1){
	$delivery_country = $_POST['billing_country'];
}
	$delivery_state = get_user_meta($userdata->ID,"billing_state",true);
if(isset($_POST['billing_state']) && strlen($_POST['billing_state']) > 1){
	$delivery_state = $_POST['billing_state'];
}
if(isset($_GET['guestcheckout']) && isset($_POST['billing_method'])){ 
	$delivery_method = $_POST['billing_method'];
}else{
	$delivery_method = get_user_meta($userdata->ID, "billing_method",true);  
}
 


// FLAT RATE SHIPPING  
if(_ppt('basic_shipping_flatrate') == 1){


	
	
	// LOOP BASKET ITEMS AND MAKE SURE SHIPPING IS ENABLED
	$canDoFlatShipping = 1;

	if(_ppt('system_shipping') != "1"){
	
		
		if(isset($_SESSION['ppt_cart']) && is_array($_SESSION['ppt_cart'])){
		
			$canDoFlatShipping = 0;
			
			// LOOP ITEMS
			foreach($_SESSION['ppt_cart'] as $key => $items){
				// GET INNER ITEM COUNT
				if(is_array($items)){
				$innerID = 1;
					foreach($items as $item){
					
						if(get_post_meta($key,"ship_required",true) == "1"){
							$canDoFlatShipping = 1;
						}
					
					}
				}
			}
		}
	
	
	}

	
	if($canDoFlatShipping){

		// SHIPPING FLAT RATE
		if( is_numeric(_ppt(array('basic_shipping','flatrate'))) ){ 
			$cart['shipping'] += _ppt(array('basic_shipping','flatrate')); 
		}
				
		// SHIPPING FLAT PERCENTAGE
		if( is_numeric(_ppt(array('basic_shipping','flatrate_percent')))  ){ 		 
			$cart['shipping'] += ( $cart['subtotal'] * _ppt(array('basic_shipping','flatrate_percent')) /100);
		}
	
	}	
}


// FLAT RATE TAX 
if(_ppt('basic_tax_flatrate') == 1){





	// LOOP BASKET ITEMS AND MAKE SURE SHIPPING IS ENABLED
	$canDoFlatTax = 1;

	
	if($canDoFlatTax){
	
		// SHIPPING FLAT RATE
		if( is_numeric(_ppt(array('basic_tax','flatrate'))) ){ 
			$cart['tax'] += _ppt(array('basic_tax','flatrate')); 
		}
				
		// SHIPPING FLAT PERCENTAGE
		if( is_numeric(_ppt(array('basic_tax','flatrate_percent')))  ){ 	
			 
			$cart['tax'] += ( $cart['subtotal'] * _ppt(array('basic_tax','flatrate_percent')) /100);
		}
	
	}
	
}



 




//5. WEIGHT BASED SHIPPING
$wb = _ppt('weightship');
$weight = $cart['weight'];
$regions = _ppt('regions'); 
 
if(is_array($wb) && !empty($wb) && isset($regions['name']) && is_array($regions['name']) && !empty($regions['name'])){ 
 
 	 
	$i=0; $m=0;
	while($i < count($wb['region'])+1){		
	
		//print_r($wb['region']);
		 
		if(isset($wb['region'][$i]) && $wb['region'][$i] != "" && $weight >= $wb['pricea'][$i] && $weight <= $wb['priceb'][$i] ){		
			  
			   	$m=0;
				while($m < count($regions['name'])+1){
				
				  	
					if(isset($regions['key'][$m]) && $regions['key'][$m] == $wb['region'][$i]){ 
					 
						 
						if($delivery_country != "" && $wb['pricec'][$i]!= "" && !empty($regions['country'][$m]) && in_array($delivery_country, $regions['country'][$m]) ){
						 				 
							$cart['shipping'] += $wb['pricec'][$i];
							//$completed_items[$key] = $key;							 	
							
						}
					}					
					$m++;
				}		
		}	
		$i++;
		
		//echo $i." -- ".$wb['region'][$i]."<br>";
	}	
}

 



// COUNTRY TAX
if(_ppt('basic_country_tax_tax') == 1 && $delivery_country != "" ){

 
	$regions = _ppt('regions');					
	if(is_array($regions)){ 
		$i=0; 
		while($i < count($regions['name']) ){
			if($regions['name'][$i] !=""){	
			
			
				if( (!empty($regions['country'][$i]) && in_array($delivery_country, $regions['country'][$i]) ) 
				|| (!empty($regions['state'][$i]) && in_array($delivery_state, $regions['state'][$i]) ) ) { // COUNTRY OR STATE CHECKOUT	
				
			 
					// FLAT RATE 
					if( is_numeric( _ppt(array('tax_country','price_'.$regions['key'][$i])) ) ){ 
						$cart['tax'] += _ppt(array('tax_country','price_'.$regions['key'][$i])); 
					}
							
					// FLAT PERCENTAGE
					if( is_numeric( _ppt(array('tax_country','percentage_'.$regions['key'][$i])) )  ){ 		 
						$cart['tax'] += ( $backup['subtotal'] * _ppt(array('tax_country','percentage_'.$regions['key'][$i])) /100);
					}
				
				
				}
			
			
										
			}
		$i++;
		} 
	}
}


// CUSTOM SHIPPING // MARK SHOULD LOOP REGONS FIRST // TO TIRED
if(isset($_POST['custommethod']) && $_POST['custommethod'] != ""){
	$custommethods 	= _ppt('custommethods');
	if(is_array($custommethods) && !empty($custommethods['region'])){ $i=0;  
		foreach($custommethods['name'] as $cship){ 
		 
			if($_POST['custommethod'] == $custommethods['key'][$i] && is_numeric($custommethods['price'][$i]) ){			
				$cart['shipping'] += $custommethods['price'][$i];
			}
		
			$i++;
		}
	}
}



	
// FREE SHIPPING
if( _ppt('basic_free_shipping') == '1'){  $fs = get_option('ppt_free_shipping_array'); 
 
	// FALLBACK IF NOT ARRAY
	if(!is_array($fs)){ $fs = array(); }	
	
	// LOOP THROUGH ALL REGIONS AND SEE IF WE HAVE A VALUE FOR THIS DELIVERY COUNTRY		 
	if(is_array($regions)){ $i=-1; while($i <= count($regions)){  $i++;
	 	
	if(isset($regions['name'][$i]) && $regions['name'][$i] !=""  ){ 
		
			if(( is_array($regions['country'][$i]) && in_array($delivery_country, $regions['country'][$i]) ) 
			|| ( isset($regions['state']) && is_array($regions['state'][$i]) && in_array($delivery_country, $regions['state'][$i]) ) ) { // COUNTRY OR STATE CHECKOUT	
							 			 
				$region_name = $regions['name'][$i];
				 
				if(isset($fs[$region_name]) && strlen($fs[$region_name]) > 1 && $backup['subtotal'] > $fs[$region_name] ){
 
				$cart['shipping'] = 0;
	
				}
			}
				
	}}} // end if / foreach / if 
	
	// EXTRA FOR 
	if(isset($fs['default']) && is_numeric($fs['default']) && $fs['default'] > 0){	
		if($backup['subtotal'] > $fs['default'] ){
			$cart['shipping'] = 0;	 
		}
	}
	 
}



return $cart;

}
	
	
 


function shortcode_addtocart( $atts, $content = null ) { global $userdata, $CORE, $post; $STRING = ""; 
	
	   	extract( shortcode_atts( array(  'class' => '', 'btn' => 0 ), $atts ) );
		
		// CATELOG MODE
		if(_ppt('catalog_mode') == 1){ return ""; }
		
		$price = 10;
		$qty = 50;
		
		if(is_numeric($price) && $price != "" && ( $qty == "" || $qty > 0) ){
		
			// GET PRODUCT TYPE
			$product_type = get_post_meta($post->ID,'type',true);
		
		if($product_type  == 2){	
			
			//$buy_link =	hook_affiliate_link( get_post_meta($post->ID, 'buy_link', true ) );		
			$buy_link = get_home_url()."/out/".$post->ID."/buy_link/";	
				
		}else{
		
			$buy_link =	 get_permalink($post->ID);
			
		}
		
		if($btn){
		
		ob_start(); ?>
        
		<button type="button" class="<?php echo $class; ?>" onclick="ajax_cart('add', 1, '<?php echo $post->ID; ?>', '','yes');"><?php echo $content; ?></button>
        
		<?php
		return ob_get_clean();
		
		}else{
		
		
		ob_start(); ?>
        
		<a class="<?php echo $class; ?>"
		<?php if(isset($current_data) && is_array($current_data) && strlen($current_data['name'][0]) > 1 || $product_type  == 2 || get_post_meta($post->ID, 'price-on', true) == 1 ){ ?>
		href="<?php echo $buy_link; ?>"
		<?php }else{ ?>
		href="javascript:void(0);" 
		onclick="ajax_cart('add', 1, '<?php echo $post->ID; ?>', '','yes');" 
		<?php } ?>><?php echo $content; ?></a>
		<?php
		return ob_get_clean();
		
		}
		
		}	
				
 
} 

	
// ADD IN NEW CART JS FILE
function _shop_footer(){ global $CORE, $CORE_CART;


// GET CART DATA
$cart_data = $CORE_CART->cart_getitems(true);  

?>
 
<div>
<input type="hidden" name="ppt_shop_required" value="1" id="ppt_shop_required" />
<input type="hidden" name="ppt_shop_total_items" value="<?php echo $cart_data['total_items']; ?>" id="ppt_shop_total_items" />
<input type="hidden" name="ppt_shop_session" value="<?php echo session_id(); ?>" id="ppt_shop_session" />
<input type="hidden" name="ppt_shop_currency_symbol" value="<?php echo hook_currency_symbol(''); ?>" id="ppt_shop_currency_symbol" />
</div>
 
 
<!-- Modal -->
<div id="addedToCart" class="modal fade addcart hidepage" tabindex="-1" role="dialog" style="margin-top:20%; display:none;">

  <div class="modal-dialog"><div class="modal-wrap"><div class="modal-content rounded-0">
  
  <div class="modal-body"> 
  
  <div class="h4 my-3">
  
      <i class="fa fa-shopping-basket" aria-hidden="true">&nbsp;</i>
      
      <?php echo __('Basket Updated','premiumpress'); ?>
  
  </div>
  
  <p class="grey margin-bottom2"><?php echo __('Your items have been added to your basket.','premiumpress'); ?></p>
  
  <hr class="dashed margin-top2 margin-bottom2" />
 
  <div class="row">
  
    <div class="col-6">
        <button class="btn btn-block btn-secondary rounded-0" data-dismiss="modal">
        <?php echo __('Continue','premiumpress'); ?>
        </button>    
    </div>
    <div class="col-6">
        <button class="btn btn-block btn-primary rounded-0" onclick="document.location.href='<?php echo _ppt(array('links','cart')); ?>'">
        <i class="fa fa-check-circle" aria-hidden="true">&nbsp;</i> <?php echo __('Checkout','premiumpress'); ?>
        </button>
    </div>
 
  </div>
  
  </div>

</div></div></div>

</div><!-- end modal -->

 
 
<?php

}	
	
	
	
/*
	this function displays the final price
	for items within the website
*/
function cart_buy_fields( ) { global $userdata, $CORE, $post; $STRING = "";  $HIDDENDATA = "";
	
	$options = true;
	

	
	
	
			

	// OUTPUT
	return $STRING;

		
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

/*
	this function applies the coupon code
	to the basket items
*/
function CODECODES_APPLYLISTING($c){
 
	$c = $c - $GLOBALS['CODECODES_DISCOUNT'];
	if($c < 0){ $c = 0; }
	
	return $c;	
}	
function CODECODES_APPLYCART($c){	
	  
		$GLOBALS['CODECODES_DISCOUNT_IISET'] = 1;	
		$c['discount'] += $GLOBALS['CODECODES_DISCOUNT'];
	 
	return $c;	
}
/*
	this function gets the discount for a
	coupon code entered by a user
*/
function cart_apply_couponcode(){ global $CORE, $CORE_CART;

		// COUPON CODE CHECKER
		if(isset($_POST['couponcode']) && strlen($_POST['couponcode']) > 0 ){			
			// DEFAULT RETURN
		  	$GLOBALS['error_message'] = __("Invalid Coupon Code","premiumpress")."<script>jQuery(document).ready(function() {jQuery('#myPaymentOptions').modal('show'); });</script>";		
			// CHECK THE CODES
			$ppt_coupons = get_option("ppt_coupons");
			// CHECK WE HAVE SUCH A CODE
			if(is_array($ppt_coupons) && count($ppt_coupons) > 0 ){
				foreach($ppt_coupons as $key=>$field){
					if($_POST['couponcode'] == $field['code']){					 	
						
						// WORK OUT DISCOUNT AMOUNT
						$discount = $field['discount_percentage'];
						if($discount != ""){
							
							if(defined('WLT_CART')){
						 				
							$cart = $CORE_CART->cart_getitems();
							 	  						
							$GLOBALS['CODECODES_DISCOUNT'] = str_replace(",","",$cart['subtotal'])/100*$discount;	
							
							//die($discount."% of ".str_replace(",","",$cart['total'])." = ".$GLOBALS['CODECODES_DISCOUNT']);
							
							}else{
							
								// MEMBERSHIP PRICES
								if(isset($_POST['membershipID']) && is_numeric($_POST['membershipID']) ){
									$membershipfields 	= get_option("membershipfields");
									$payment_due = $membershipfields[$_POST['membershipID']]['price'];															
									// LISTING PRICES
								}else{
									if(isset($post->ID)){
									$postIDDD = $post->ID;
									}else{
									$postIDDD = $_GET['p'];
									}
									$payment_due = get_post_meta($postIDDD,'listing_price_due',true);									 	
									 					
								}
								$GLOBALS['CODECODES_DISCOUNT'] = $payment_due/100*$discount;
								 
									
							}
							
						}else{
							$GLOBALS['CODECODES_DISCOUNT'] = $field['discount_fixed']; 
						}
						 
						// HOOK INTO CART
						if(defined('WLT_CART') ){
						
							global $CORE_CART; 
							//$_SESSION['discount_code'] 			= strip_tags($_POST['couponcode']);
							//$_SESSION['discount_code_value'] 	= $GLOBALS['CODECODES_DISCOUNT'];
							add_action('hook_cart_data', array( $CORE_CART, 'CODECODES_APPLYCART') );
							
							
						}else{						 
							add_action('hook_payment_package_price', array( $this, 'CODECODES_APPLYLISTING') );
						}
						 						
						// UPDATE THE USAGE COUNTER	
						$ppt_coupons[$key]['used']++;
						
						// LEAVE ERROR MESSAGE
						$GLOBALS['error_message'] = __("Coupon Discount Applied.","premiumpress");
					}			
				} // end foreach
				// UPDATE THE USAGE COUNTER	
				update_option( "ppt_coupons", $ppt_coupons);
			} // end if			
		 }// end if

}

/*

this function calculates the discount for  aproduct
*/
function cart_item_discount(){ global $post;
 
	$oldp = get_post_meta($post->ID,'old_price',true);
	if($oldp != "" ){
		
		$price = get_post_meta($post->ID,'price',true);
		
		$discount = ($price / $oldp ) * 100;
		 
		
		return round($discount,0);
	}
	
	return false;

}

/*
	this function returns items from
	your shopping cart
*/
function cart_getitems(){
		
		global $wpdb, $userdata, $CORE; $total_items = 0; $total_tokens = 0;
	 
		$cart_defaults = array(
			"userid" 		=> 0, 
			"total_items" 	=> 0, 
			"total" 		=> 0, 
			"subtotal" 		=> 0, 
			"qty" 			=> 0, 
			"tax" 			=> 0, 
			"weight_class" 	=> 0,
			"weight" 		=> 0, 
			"tokens" 		=> 0,  
			"shipping" 		=> 0, 
			"comments" 		=> "", 
			"discount" 		=> 0, 
			"discount_code" => "", 
			"session" 		=> session_id(), 
			"items" 		=> array()
		);
 		
		// IF GUEST CHECKOUT ADD-ON NEW VALUES
		if(isset($_SESSION['guestdata']) && !empty($_SESSION['guestdata']) ){		
		$cart_defaults['guest_data'] = $_SESSION['guestdata'];
		}
		 
		
		if(isset($_GET['emptycart'])){ unset($_SESSION['ppt_cart']); }
		  
		if(isset($_SESSION['ppt_cart']) && is_array($_SESSION['ppt_cart'])){
			// LOOP ITEMS
			foreach($_SESSION['ppt_cart'] as $key => $items){
				// GET INNER ITEM COUNT
				if(is_array($items)){
				$innerID = 1;
					foreach($items as $item){
					 	 
						$total_items += $item['qty'];
					 
						// TOTAL IS THE STORED ITEM PRICE X QTY
						$amount 	= get_post_meta($key,"price",true); 
						  			
						if(!is_numeric($amount)){ 	$amount = 0; }
						// WEGIGHT
						$weight 					= get_post_meta($key,"weight",true); 
						$weight_class				= get_post_meta($key,"weight_class",true);						
						$cart_defaults['weight_class'] = $weight_class;							
						if(!is_numeric($weight)){ 	$weight = 0; }
						$cart_defaults['weight'] 	+= $weight*$item['qty'];						
						// QTY
						$cart_defaults['subtotal'] += $amount*$item['qty'];
						$cart_defaults['qty'] 	+= $item['qty'];
						$custom					= "";
						// CHECK FOR ADDITIONAL PRICE EXTRAS

						if(is_array($item['extra']['ship'])){ 
						$cart_defaults['shipping'] += $item['extra']['ship'];
						}// end if
						
						
						// CHECK FOR CUSTOM AMOUNTS						
					 	$customdata = "";
						if(is_array($item['extra']['custom']) && is_array($item['extra']['custom']) ){ 	
							
							// SAVE FOR LATER
							$customdata = $item['extra']['custom'];
						
						 	// LOOP EXTRAS AND INCREASE PRICE 
							foreach($item['extra']['custom'] as $custom_item){
								
								// CUSTOM FIELD ATTRIBUTES							
								$display = $custom_item['amount'];	
								 
								// IF ITS A NUMERICAL VALUE, ASSUME ITS A PRICE				 
								if(is_numeric($custom_item['amount'])){								
									$cart_defaults['subtotal'] += ($custom_item['amount']*$item['qty']);						
									$amount += $custom_item['amount'];
									 								
									if(isset($display_text)){
									$display = $display_text;
									} 
								}// end if numeric
								
								// BUILD DISPLAYS TRING						
								$custom .= $custom_item['text'];
							} // end if
						}
						
						// ADD ON TOKENS
						if(isset($item['extra']['tokens']) && $item['extra']['tokens'] == 1){ 
						$total_tokens = $amount;						
						}
						 
						// CHECK FOR PRODUCT DISCOUNTS
						$current_discount_data = get_post_meta($key,"ppt_productdiscounts",true); 
						if(is_array($current_discount_data) && !empty($current_discount_data) ){
							$di=0; $num_discounts = count($current_discount_data);
							// LOOP DISCOUNTS
							while($di < $num_discounts){															 
								if(isset($current_discount_data['min'][$di]) && $item['qty'] >= $current_discount_data['min'][$di] && $item['qty'] <= $current_discount_data['max'][$di]){
									$old_item_price = get_post_meta($key,"price",true);
									$new_price_per_product = $current_discount_data['price'][$di];
									$new_discount = ($new_price_per_product*$item['qty']-$old_item_price*$item['qty']);
									if($new_discount < 0){
									$cart_defaults['discount'] += $new_discount;
									}
									//$amount = $new_price_per_product;
								}
							$di++;
							}
							 
							 $cart_defaults['discount'] = str_replace("-","",$cart_defaults['discount']);
						}
						
						
					 
						
											 			
						// IF WE ARE GETTING EVERYTHING, INCLUDE ALL OF THE PRODUCT INFORMATION						 
						$permalink = get_permalink($key);
						$image = "";
						if ( has_post_thumbnail($key) ) { 						
							$image = '<a href="'.$permalink.'" class="frame">';
							$image .= hook_image_display(get_the_post_thumbnail($key,'thumbnail',array('class'=> "img-fluid")));
							$image .= '</a>';	
						}else{
							// CHECK FOR FALLBACK IMAGE
							$fimage = $CORE->FALLBACK_IMAGE($key); 
							if($fimage !=""){ //&& !isset($GLOBALS['flag-single'])
							$image = '<a  href="'.$permalink.'" class="frame">';
							$image .= $fimage; 
							$image .= '</a>';
							}
						}
						  
						
						$cart_defaults['items'][$key][$innerID] = 
						array (
						"innerID" 	=> $innerID,
						"name" 		=> get_the_title($key), 
						"link" 		=> $permalink,
						"amount" 	=> $amount,
						"image" 	=> $image, 
						"qty"		=> $item['qty'],
						"tokens"	=> $item['extra']['tokens'], 
						"shipping" 	=> $item['extra']['ship'],
						"custom"	=> $custom, 
						"custom_data" => $customdata,
						);				
						$innerID++;
						 
					} // end foreach
					
				} // end if
				
			} // enf foreach		
		} // end if
		 
		
		// UPDATE COMMENTS
		if(isset($_SESSION['ppt_cart']['comment'])){ $cart_defaults['comments'] = stripslashes(strip_tags($_SESSION['ppt_cart']['comment'])); }
  	
	  
		// CHECK FOR COUPON CODE		
		if(isset($_SESSION['discount_code']) && strlen($_SESSION['discount_code']) > 3 ){		 
		 
			//$cart_defaults['discount_code'] = strip_tags($_SESSION['discount_code']);
			
			$GLOBALS['CODECODES_DISCOUNT'] = $_SESSION['discount_code_value'];
			
			//die($_SESSION['discount_code']."<--".$_SESSION['discount_code_value'].print_r($_SESSION));
			
			add_action('hook_cart_data', array( $this, 'CODECODES_APPLYCART') );
		}
		
		// HOOK INTO THE ARRAY
		$cart_defaults = hook_cart_data($cart_defaults);	
		
		// CALCULATE TOKENS AMOUNT
		$cart_defaults['total_tokens'] = $total_tokens;
		 
		
		if(isset($GLOBALS['flag-cart'])){
			 	 
			$cart_defaults['shipping'] = 0;
							
		}
						
			 	
		// CALCULATE SUBTOTAL		
		$cart_defaults['total'] =  number_format((float)($cart_defaults['subtotal'] + $cart_defaults['shipping'] + $cart_defaults['tax']) - $cart_defaults['discount'], 2);	
		 
		// UPDATE TOTAL ITEMS
		$cart_defaults['total_items'] = $total_items;
		
		if($userdata->ID){
		$cart_defaults['userid'] = $userdata->ID;
		}
		 	
		// RETURN COMPLETE ARRAY	 
		return $cart_defaults;
	}

 

	
	function cart_weightclass($num){
		
		switch($num){
			case "1": {
				return "g";
			} break;
			case "2": {
				return "lb";
			} break;
			case "3": {
				return "oz";
			} break;
			default: { 
				return "KG";
			}
		}
	} 
 
	
	
	function _downloadproduct(){ global $wpdb, $CORE, $userdata;
	
		if(isset($_POST['downloadproduct']) && isset($_POST['data'])  ){
			 
			$data_array = (array)json_decode(base64_decode($_POST['data']));
			 
			// UPDATE DOWNLOAD COUNTER
			$gg = get_post_meta($data_array['pid'], 'download_count',true);
			if($gg == ""){ $gg = 0; }
			update_post_meta($data_array['pid'], 'download_count', $gg+1);
			  	
		 	
			// START DOWNLOAD
			if(isset($data_array['aid']) && ( in_array($data_array['type'], $CORE->allowed_image_types) || in_array(strtolower($data_array['type']), array('jpeg','png','jpg') ) ) ){
					 
						$image  = wp_get_attachment_image_src( $data_array['aid'], 'full' );
						//$image_data = wp_get_attachment_metadata( $data_array['aid'] );						 		 
						$uploads = wp_upload_dir();			 
						$image_e = wp_get_image_editor( $image[0] );
						$filename = $data_array['width']."x".$data_array['height']."-".$data_array['pid'].".".substr($image[0],-3);
						// MAKE FILENAME
					 
								
						 	
						if ( ! is_wp_error( $image_e ) ) {
							 								
								$image_e->resize( $data_array['width'], $data_array['height'], true );									
								$image_e->set_quality( 100 );
								$image_e->save( $uploads['path'].$filename );								
							
						}
							
						$file = $uploads['path'].$filename;
						 
						
						$deletefile = true;
			
			}elseif(isset($data_array['aid']) && in_array($data_array['type'], $CORE->allowed_video_types) ){
			
				$video  = wp_get_attachment_metadata( $data_array['aid'] );
				 
				$filename =  $video['name'];
				$file = $video['filepath'];
				 	
			}else{
					 
						$file = get_post_meta($data_array['pid'], 'download_path',true);
						
						
						
						// ASSUME THE USER HAS LINKED TO THE FILE
						if(strpos($file,get_home_url()) !== false){			
							$b = explode("/wp-content/",THEME_PATH);		
							$file = str_replace(get_home_url(),$b[0],$file);			
						}
						
						$filename = $file;
						 
			 
			} 
			
			
			// SOFTWARE THEME REMOVE DOWNLOAD FROM LIMITS
			if($userdata->ID && THEME_KEY == "so"){
			$CORE->USER("update_user_free_membership_addon", array("downloads", $userdata->ID, $data_array['pid'] ) );
			}
			
			 
			if(substr($file,0,4) == "http"){			
			
			die("Click <a href='".$file."'>here</a> to download.");
			
			} 
		 
			//ini_set('memory_limit','256M');	
			if(file_exists($file)) {
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($filename));
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						readfile($file);
						if(isset($deletefile)){ unlink($file); }
						exit;
			}else{
			die("<h1>Download Error</h1><p>The file your looking for has been moved or deleted. Please contact the website owner.</p>");
			}		
		}
	}
	
	
	
	// ADD NEW PAGE SELECTION FOR CHECKOUT IN THE ADMIN
	function _updatepagelist($c){
	 
	$c['checkout'] = array("name" => "Checkout Page", "desc" => "");
	$c['cart'] = array("name" => "Cart Page", "desc" => "");
	return $c;
	}
	
 
	
	/*
		this function saves the users data TO
		their account
	*/
	function cart_update_userfields($userid = ""){
	
		global $userdata, $wpdb;
		  
	 	if(is_numeric($userid)){	 
		foreach($this->shop_user_fields as $key => $field){	
		 		
			if($field['type'] != "sep" && isset($_POST[$key]) ){
			
			update_user_meta($userid, $key, esc_html(strip_tags($_POST[$key])));
			
			//echo $userid." -- ".$key." -- ".esc_html(strip_tags($_POST[$key]))."<br>";
			 
			}		
		}
		}
		
	}
	/*
		this function takes all of the billing data
		at checkout and saves it to the users account.
		and also guest checkouts
	*/
	function cart_checkout_save(){ global $wpdb, $userdata, $CORE, $CORE_CART;
	
	 
		// CHECK IF LOGGED IN
		if($userdata->ID){
		
			$userid = $userdata->ID;
		
		}elseif(isset($_POST['cart-checkout-complete'])){		
		 
			// CHECK IF THE EMAIL BELONGS TO AN EXISTING USER
			// IF IT DOES UPDATE THEIR DELIOVERY DETAILS
			$g = email_exists($_POST['billing_email']);
			 
			if(email_exists($_POST['billing_email'])){	
					
				//$userid = email_exists($_POST['billing_email']);				 
		 		
				// REDIRECT TO LOGIN PAGE
				header("location: ".home_url()."/wp-login.php?noaccess=1&redirect_to="._ppt(array('links','checkout')));
				exit();	
					
			}else{		
				
				if(isset($_SESSION['ppt_cart'])){
				$savedSession = $_SESSION['ppt_cart'];			
				}
				
				$creds = array();
				$creds['user_login'] 	= $_POST['billing_email'];
				$creds['user_password'] = "password";
				$creds['remember'] 		= true;	
				$USEREMAIL 				= $_POST['billing_email'];
			 
				$userid = wp_create_user( $creds['user_login'], $creds['user_password'], $USEREMAIL);				
				 	
				// CHECK FOR ERRORS	 
				if ( is_wp_error($userid) ) {
					
					if(isset($userid->errors['existing_user_login'])){	
					
						$creds['user_login'] = $creds['user_login'].rand(0,10000);			
						$userid = wp_create_user( $creds['user_login'], $creds['user_password'], $USEREMAIL );
												
					}else{					
						die(print_r($userid));					
					}									 	
				
				}				
				
				// AUTO LOGIN USER				
				if(strpos(get_option('siteurl'),"https") == false){	 //if ( is_ssl() && !force_ssl_admin() ){		
					$secure_cookie = '';
				}else{			
					$secure_cookie = true;
				} 			 
		 
				$user = wp_signon($creds, $secure_cookie);
				 
				if ( is_wp_error($user) ) {
				
					// REDIRECT TO LOGIN PAGE
					header("location: ".home_url()."/wp-login.php?redirect_to="._ppt(array('links','checkout')));
					exit();
				}
				
				if($savedSession != ""){
				$_SESSION['ppt_cart'] = $savedSession;
				}
				
				$userdata = $user;
				global $userdata; 
			 	
				
				
			} // end else
		
		} // end else
		
		
		if(isset($userid)){
		
			// NOW UPDATE THEIR BILLING DETAILS			
			$this->cart_update_userfields($userid); 
				
			// SAVE THE SESSION  
			$table_data = $CORE_CART->cart_getitems();
			$wpdb->query("DELETE FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".session_id()."') LIMIT 1");	
			$wpdb->query("INSERT INTO ".$wpdb->prefix."core_sessions (`session_key` ,`session_date` ,`session_userid`, session_data) 
			VALUES ('".session_id()."', '".date('Y-m-d H:i:s')."', '".$userid."', '".serialize($table_data)."')");
		
		}
	  		 	
				
	}
 
	
	/*
		this function displays the extra tax
		percentage set via the admin area
	*/
	function _curreny_extra_tax($p){ global $post;
	
	// DONT INCLUDE DISPLAY TAX ON CHECKOUT
	if(isset($GLOBALS['flag-checkout']) || isset($_GET['invoiceid']) || isset($GLOBALS['flag-callback']) ){ return $p; }
 	if(!isset($GLOBALS['CORE_THEME']['display_percentage']) || !is_numeric($GLOBALS['CORE_THEME']['display_percentage']) ){ return $p; }
	
	
		$p = strip_tags($p); 
		 if($p > 0){ 
			$p = str_replace(",","",$p);
			$p += ($p/100*$GLOBALS['CORE_THEME']['display_percentage']);	
			$p = round($p,2);			
			$seperator = "."; $sep = ","; $digs = 2; 
			if(is_numeric($p)){		
			$p = number_format($p,$digs, $seperator, $sep); 
			}		 
		}
	 
	 
		return $p;
	}
	
	
	
	
	
	function _hook_account_userfields_after(){
	
	?>
    
    <?php get_template_part( hook_theme_folder( array('cart', 'userfields', true) ) , 'userfields' ); ?>
    
    <?php
	
	}	
	
	
	
	
	
	
	
	
	
	/*
		callback for shopping cart
		
	 
	
	function _hook_callback_process_orderid($obits){ global $userdata, $wpdb, $CORE;
	
 
 
	// CHECK FOR CART PAYMENT
	if(isset($obits['order_id']) && substr($obits['order_id'],0,4) == "CART"){ 
	
	  
			// ADD IN EXTRAS FOR SHOP THEMES
			if(defined('WLT_CART') && strlen($obits[1]) > 4 ){
			 	
				$SQL = "SELECT * FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".strip_tags($obits[1])."') LIMIT 1";
				$hassession = $wpdb->get_results($SQL, OBJECT);
				if(!empty($hassession)){
				
					// RESTORE THE CART DATA
					$cart_data = unserialize($hassession[0]->session_data); 
				 	 
						// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
						if(isset($cart_data['items']) && is_array($cart_data['items'])){
						
						
							// CHECK FOR COMMENTS
							if($cart_data['userid'] == 0){ // GUEST CHECKOUT		
							 					
								$cart_data['comments'] = get_option('cartc_' . stripslashes(strip_tags($cart_data['guest_data']["billing_email"])) );	
								$newcartdata = $cart_data;						 
								$wpdb->query("UPDATE ".$wpdb->prefix."core_sessions SET session_data = '".serialize($newcartdata)."' WHERE session_key = ('".strip_tags($obits[1])."') LIMIT 1"); 
								delete_option('cartc_' . stripslashes(strip_tags($cart_data['guest_data']["billing_email"])));
								
								$order_username = "Guest";
								
							}else {
							
								$order_username = $cart_data['guest_data']["billing_fname"]." ".$cart_data['guest_data']["billing_lname"];
								
							}						
							 
							
							
							$order_data_description = "\n\n\n********** Order Information **********\n\n";
							$order_data_description .= "Date : ".hook_date(date('Y-m-d H:i:s'))."\n";
							$order_data_description .= "Order ID : #XXORDERIDXX\n";
							$order_data_description .= "User ID : ".$cart_data['userid']."\n";	
							$order_data_description .= "Comments : ".$cart_data['comments']."\n";
							$order_data_description .= "Shipping : ".hook_price($obits['data']['shipping'])."\n";
							$order_data_description .= "Tax : ".hook_price($obits['data']['tax'])."\n";
							$order_data_description .= "Discount : ".$cart_data['discount']."\n";
							$order_data_description .= "Weight : ".$cart_data['weight']."\n";
							$order_data_description .= "Items : ".count($cart_data['items'])."\n";												
							$order_data_description .= "Order Total : ".hook_price($obits['data']['total'])."\n";								 
														
							// GET ORDER SHIPPING DATA
							$order_data_description .= "\n\n\n********** Shipping Information **********\n\n";
							if(isset($cart_data['guest_data']) && !empty($cart_data['guest_data'])){
							$order_data_description .= "Name : ".$cart_data['guest_data']["billing_fname"]." ".$cart_data['guest_data']["billing_lname"]."\n";
							$order_data_description .= "Email : ".$cart_data['guest_data']["billing_email"]."\n";
							$order_data_description .= "Phone : ".$cart_data['guest_data']["billing_phone"]."\n";
							$order_data_description .= "Address 1 : ".$cart_data['guest_data']["billing_address"]."\n";
							$order_data_description .= "Address 2 : ".$cart_data['guest_data']["billing_address2"]."\n";
							$order_data_description .= "City : ".$cart_data['guest_data']["billing_city"]."\n";
							$order_data_description .= "State : ".$cart_data['guest_data']["billing_state"]."\n";
							$order_data_description .= "Country : ".$cart_data['guest_data']["billing_country"]."\n";
							$order_data_description .= "Zip/Postal Code : ".$cart_data['guest_data']["billing_zip"]."\n"; 
							$guestcheckoutemail = $cart_data['guest_data']["billing_email"];
							
							$order_useremail = $cart_data['guest_data']["billing_email"];
							
							}else{	
						 				
							$order_data_description .= "Name : ".get_user_meta($cart_data['userid'], "billing_fname",true)." ".get_user_meta($cart_data['userid'], "billing_lname",true)."\n";
							$order_data_description .= "Email : ".get_user_meta($cart_data['userid'], "billing_email",true)."\n";
							$order_data_description .= "Phone : ".get_user_meta($cart_data['userid'], "billing_phone",true)."\n";
							$order_data_description .= "Address 1 : ".get_user_meta($cart_data['userid'], "billing_address",true)."\n";
							$order_data_description .= "Address 2 : ".get_user_meta($cart_data['userid'], "billing_address2",true)."\n";
							$order_data_description .= "City : ".get_user_meta($cart_data['userid'], "billing_city",true)."\n";
							$order_data_description .= "State : ".get_user_meta($cart_data['userid'], "billing_state",true)."\n";
							$order_data_description .= "Country : ".get_user_meta($cart_data['userid'], "billing_country",true)."\n";
							$order_data_description .= "Zip/Postal Code : ".get_user_meta($cart_data['userid'], "billing_zip",true)."\n";
							
							$order_useremail = get_user_meta($cart_data['userid'], "billing_email",true);
							
							}
							 
							// PRODUCTS							
							$order_data_description .= "\n\n********** Ordered Products **********\n\n";
							
							 
							foreach($cart_data['items'] as $key => $item){
								foreach($item as $mainitem){
								 
									// SETUP PRICE
									if(get_post_meta($key,'price-on',true) == 1){
										$product_amount = 0;
									}else{
										$product_amount = get_post_meta($key,'price',true);
									}									
								 
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
									
								 
									// LOOP ALL THE CUSTOM DATA
									if(isset($mainitem['custom_data']) && is_array($mainitem['custom_data']) && !empty($mainitem['custom_data']) ){
										foreach($mainitem['custom_data'] as $f){
										
										 
											if($f['field'] == "priceon"){
												update_post_meta($key,'price-'.$f['key'].'-stock',get_post_meta($key,'price-'.$f['key'].'-stock',true)-$mainitem['qty']);
											}else{
											
											}
											
											// UPDATE AMOUNT
											$product_amount += $f['amount'];
												
												
										} // end foreach
									}
									 
									 	 									
									 
									// CREATE DESCRIPTION
									$extraprice = 0;
									$order_data_description .= "Product #: ".$key."\n";
									$order_data_description .= "Product Name: ".$mainitem['name']."\n";									
									$order_data_description .= "Quantity: ".$mainitem['qty']."\n";
									$order_data_description .= "Unit Price: ".hook_price($product_amount+($extraprice))."\n";
									$order_data_description .= "Shipping: ".hook_price($mainitem['shipping'])."\n";
									$order_data_description .= "Attributes: ".preg_replace("/\r\n|\r|\n/", "", $mainitem['custom'])."\n";
									$order_data_description .= "Product Link: ".$mainitem['link']."\n";
									$order_data_description .= "Total: ".hook_price(($product_amount+$extraprice)*$mainitem['qty'])."\n\n";
									 
									
									
									
									///////////////////
									 
								 
								}// end foreach
							}// end foreach
						}// end if
				}// end if 
			} 
	
	} 
 

}*/	












 

	
	
 
	
	
}

?>