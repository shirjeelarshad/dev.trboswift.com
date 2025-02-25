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

global $userdata, $CORE, $CORE_CART;

 
if(isset($GLOBALS['global_cart_data']) && is_array($GLOBALS['global_cart_data']['items']) && !empty($GLOBALS['global_cart_data']['items']) ){ 
 
?>

<div class="checkout-table clearfix shadow-soft">
  <div class="table-header clearfix">
    <div class="row">
      <div class="col-item col-sm-6 col-p-5"> <?php echo __("My Basket","premiumpress"); ?> </div>
      <div class="col-price col-sm-2 text-center hidden-sm-down col-p-2"> <?php echo __("Price","premiumpress"); ?> </div>
      <div class="col-qty col-sm-1 text-center hidden-sm-down col-p-1"> <?php echo __("Quantity","premiumpress"); ?> </div>
      <div class="col-total <?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-sm-6<?php }else{ ?>col-sm-3<?php } ?> hidden-xs-down col-p-1 text-right"> <?php echo __("Total","premiumpress"); ?> </div>
    </div>
  </div>
  <?php  $counter = 1; $tokens = 0;
 
foreach($GLOBALS['global_cart_data']['items'] as $key => $inner_item){  foreach($inner_item as $innerkey => $item){

 
?>
  <div class="table-row clearfix" id="table_row_<?php echo $counter; ?>">
    <div class="row">
      <div class="col-item col-md-6 col-9 col-p-5">
      
        <?php if(defined('WLT_CART')){ ?>
        
        
        
			<?php if(isset($item['image'])){ ?>
            
                <a href="<?php echo $item['link']; ?>"> 
                <?php echo do_shortcode('[IMAGE pid="'.$key.'"]'); ?>
                </a> 
                
            <?php } ?>
         
        
            <a href="<?php echo get_permalink($key); ?>" class="text-dark">
            <h6><?php echo $item['name']; ?></h6>
            </a>
            
        
        <?php }else{ ?>
        
        <?php if(isset($item['link']) && strlen($item['link']) > 5 ){ ?>
        <a href="<?php echo $item['link']; ?>" target="_blank"  class="text-dark">
        <?php } ?>
        
        <h5><?php echo $item['name']; ?></h5>
        <?php if(isset($item['link']) && strlen($item['link']) > 5 ){ ?>
        </a>
        <?php } ?>
        <?php if(isset( $item['comments']) && strlen( $item['comments']) > 1){ ?>
        <p><?php echo $item['comments']; ?></p>
        <?php } ?>
        <?php } ?>
        <ul class="list-unstyled p0 list-inline small">
          
         
            <?php if(isset($GLOBALS['global_cart_data']['order_data']) && substr($GLOBALS['global_cart_data']['order_data'],0,5) == "addon" ){ ?>
             <li class="list-inline-item">
            <?php
			   $thisVal = substr($GLOBALS['global_cart_data']['order_data'],5,100);			   
				$current_data = get_post_meta($key, 'customextras', true); 
				if(is_array($current_data) && !empty($current_data) && $current_data['name'][0] != "" ){ $i=0; 				 
					foreach($current_data['name'] as $key => $data){ 
					if($current_data['name'][$i] !="" && is_numeric($current_data['price'][$i]) ){						
							if($i == $thisVal){
							?>
            <div class="bg-light p-3 border mt-4"> <span class="float-right badge badge-primary"><?php echo ($current_data['price'][$i]); ?></span>
              <h6><?php echo $current_data['name'][$i]; ?></h6>
              <p><?php echo trim($current_data['value'][$i]); ?></p>
            </div>
            <?php						
							} 
						}						
						$i++; 
					}
				} 
			   
			   ?>
           
          </li>
           <?php } ?>
          
          <?php
		
		if(isset($item['custom_data']) && is_array($item['custom_data']) ){
		  
		foreach($item['custom_data'] as $f){  ?>
          <li class="list-inline-item customtag text-muted">
            <?php 
		
		
		
		switch($f['key']){
			/*
			case "color": {
			?>
            <?php echo $CORE->GEO("translation_tax_key", "color"); ?>: <?php echo $f['text']; ?>  
            <?php			
			} break;
			
			case "size": {
			?>
            <?php echo $CORE->GEO("translation_tax_key", "size"); ?>: <?php echo $f['text']; ?>  
            <?php			
			} break;
			*/
			
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
		}		
		
		?>
          <div class="list-inline-item qty-small visible-xs-down small">
          <?php echo __("QTY","premiumpress"); ?> X<?php echo $item['qty']; ?>
          </li>
        </ul>
      </div>
      <div class="col-price col-sm-2 hidden-sm-down text-center col-p-2">
      
       <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>">
        <?php echo hook_price(array($item['amount'],0)); ?>
        </span>
         
      </div>
      <div class="col-qty col-sm-1 hidden-sm-down text-center col-p-1">
        <?php if(get_post_meta($key, 'stock_remove', true) ==1){ echo $item['qty']; }else{ ?>
        <input type="text" value="<?php echo $item['qty']; ?>" class="qty-input text-center qty" 
    style="max-width:50px;" onchange="ajax_cart('update', this.value, '<?php echo $key ?>','<?php echo $innerkey; ?>','refresh');"  />
        <?php } ?>
      </div>
      <div class="col-total <?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-sm-6<?php }else{ ?>col-sm-3<?php } ?> col-3 text-right col-p-1">
       
       <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>">
        <?php if( isset($item['tokens'] ) && $item['tokens'] == 1){ ?>
        <?php echo $item['amount'] * $item['qty']; ?> <?php echo __("Tokens","premiumpress"); ?>
        <?php $tokens += ( $item['amount'] * $item['qty'] ); ?>
        <?php }else{ ?>
        <?php echo hook_price(array($item['amount']* $item['qty'],0)) ;?>
        <?php } ?>
        </span>
        
        
        <?php if(isset($GLOBALS['flag-checkout'])){ ?>
        <a href="javascript:void(0);" onclick="jQuery('#table_row_<?php echo $counter; ?>').hide(); ajax_cart('remove', 1000, '<?php echo $key ?>','<?php echo $innerkey; ?>','refresh');" 
        class="btn btn-sm ml-3 btn-secondary btn-remove-item margin-left1" title="<?php echo __("Remove Item","premiumpress"); ?>"> <i class="fas fa-times nomargin"></i> </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php $counter++; } unset($setflag);  }  ?>
  <?php if($GLOBALS['global_cart_data']['subtotal'] != 0  ){ ?>
  <div class="table-footer t-subtotal clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("SubTotal","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right">
               
        <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>">
		<?php echo hook_price(array($GLOBALS['global_cart_data']['subtotal'],0)); ?>
        </span> 
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($GLOBALS['global_cart_data']['weight'] != 0 ){ ?>
  <div class="table-footer t-weight clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Weight","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right"> <?php echo $GLOBALS['global_cart_data']['weight']." ".$CORE_CART->cart_weightclass($GLOBALS['global_cart_data']['weight_class']); ?> </div>
    </div>
  </div>
  <?php } ?>
  
  <?php if(defined('WLT_CART')){ ?>
  
  <?php if(!isset($GLOBALS['flag-cart'])){  ?>
  <div class="table-footer t-shipping clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Shipping","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right">
        <?php if($GLOBALS['global_cart_data']['shipping'] != 0 ){ ?>
        <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price(array($GLOBALS['global_cart_data']['shipping'],0)); ?></span>
        <?php }else{ ?>
        <span class="text-uppercase"><?php echo __("Free","premiumpress"); ?></span>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php }  ?>
  
  <?php }else{ ?>
  
  <?php if($GLOBALS['global_cart_data']['shipping'] != 0 ){ ?>
  <div class="table-footer t-shipping clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Shipping","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right"> <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price(array($GLOBALS['global_cart_data']['shipping'],0)); ?></span> </div>
    </div>
  </div>
  <?php } ?>
  <?php } ?>
  <?php if($GLOBALS['global_cart_data']['tax'] != 0 ){ ?>
  <div class="table-footer t-tax clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Tax","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right"> <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price(array($GLOBALS['global_cart_data']['tax'],0)); ?></span> </div>
    </div>
  </div>
  <?php } ?>
  <?php if($GLOBALS['global_cart_data']['discount'] != 0 ){ ?>
  <div class="table-footer t-discount clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Discount","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right">
      
      
      <?php if(isset($_SESSION['discount_code_value'])){ ?>
      <a href="javascript:void(0);" onclick="RemoveCoupon();" id="removeCouponBtn" title="remove coupon"><i class="fal fa-times text-danger mr-2"></i></a>
      <?php } ?>
      
       <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price(array($GLOBALS['global_cart_data']['discount'],0)); ?></span> </div>
    </div>
  </div>
  <?php } ?>
  
  <?php if($GLOBALS['global_cart_data']['total'] != 0 ){  ?>
  <div class="table-footer t-total clearfix">
    <div class="row">
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-8<?php } ?> col-6 text-sm-right"> <?php echo __("Total","premiumpress"); ?> </div>
      <div class="<?php if(isset($GLOBALS['flag-smallbasket'])){ ?>col-lg-6<?php }else{ ?>col-lg-4<?php } ?> col-6 text-right h5 ebold">
         
        <span class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price(array($GLOBALS['global_cart_data']['total'],0)); ?> </span>
     
      </div>
    </div>
  </div>
  <?php } ?>
  
</div>
<?php } ?>
<input type="hidden" id="ppt_orderdata" value="<?php 


$tt = 0;
if(is_numeric(str_replace(",","",$GLOBALS['global_cart_data']['total'])) && isset($GLOBALS['global_cart_data']['total_tokens']) && $GLOBALS['global_cart_data']['total_tokens'] > 0){
$tt = intval(str_replace(",","",$GLOBALS['global_cart_data']['total']))-intval($GLOBALS['global_cart_data']['total_tokens']);
}else{
$tt =  str_replace(",","", hook_price(array($GLOBALS['global_cart_data']['total'],0)) );
}


if(!isset($GLOBALS['global_cart_data']['total_tokens'])){
$GLOBALS['global_cart_data']['total_tokens'] = 0;
} 


$cartdata = array(

	"uid" => $userdata->ID, 
	"amount" => str_replace(",","",$GLOBALS['global_cart_data']['total']), 	 
	
	"local_currency_amount" => $CORE->price_format_display(array( $tt , false ) ),
	"local_currency_code" => $CORE->_currency_get_code(),
	
	"order_id" => "CART-".session_id(),
	"tokens" => $GLOBALS['global_cart_data']['total_tokens'], 
	
	"description" => "Cart Checkout",
	"nocoupons" => 0,
	
	"recurring" => 0,
								
);


echo $CORE->order_encode($cartdata); 
								
								
?>" />

<script>

 function RemoveCoupon(){
			 
				 jQuery.ajax({
					type: "POST",
					url: '<?php echo home_url(); ?>/',		
					data: {
						cart_action: "remove_coupon",         			 
					 },
					 success: function(response) {
					 
						jQuery("#removeCouponBtn").hide();
						location.reload();									
					 },
					 error: function(e) {
						 alert("error "+e)
					 }
				 });
	}         
        
 
</script>
