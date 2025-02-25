<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN, $region_list;


// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );


// MAKE REGIONS LIST
$regions 		= _ppt('regions');
$region_list = "";  $c=0;
if(is_array( $regions )){ 
	while($c < count($regions['name']) ){
		if($regions['name'][$c] !="" ){							 
		$region_list .= "<option value='".$regions['key'][$c]."' id='".$c."'>".$regions['name'][$c]."</option>";									
		} // end if
	$c++;
	} // end foreach
}// end if
 

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

 $current_country_tax_array = get_option('ppt_country_tax_price_array');  $current_ppt_tax_exemp_array = get_option('ppt_tax_exemp_array');


 
if(isset($_POST['admin_values']['basic_tax'])){

	// SET CUSTOM ARRAY FOR COUTNRIES SINCE THERE ARE ALOT OF THEM
	if( ( isset($_POST['basic_tax_country_price']) && is_numeric($_POST['basic_tax_country_price']) ) || ( isset($_POST['basic_tax_country_percentage']) && is_numeric($_POST['basic_tax_country_percentage']) )  ){
		$new_country_tax_array = array();	
		if(!is_array($current_country_tax_array)){ $current_country_tax_array = array(); }
		if(isset($_POST['basic_country_tax']) && !empty($_POST['basic_country_tax'])){
			foreach($_POST['basic_country_tax'] as $country){
				$new_country_tax_array[$country]['price'] 		= $_POST['basic_tax_country_price'];
				$new_country_tax_array[$country]['percent'] 	= $_POST['basic_tax_country_percentage'];
				//$new_country_tax_array[$country]['excemption'] 	= $_POST['basic_tax_country_excemption'];
				
			}// end foreach	
			update_option("ppt_country_tax_price_array",array_merge($current_country_tax_array,$new_country_tax_array), true);
			$current_country_tax_array = get_option('ppt_country_tax_price_array');
			
		}// end if
	}// end if 
	
} // end if
 
$current_country_ship_array = get_option('ppt_country_ship_price_array'); $current_amount_ship_array = get_option('ppt_amount_ship_price_array'); $current_free_shipping_array = get_option('ppt_free_shipping_array');
 
if(isset($_POST['admin_values']['basic_shipping'])){

	// SET CUSTOM ARRAY FOR COUTNRIES SINCE THERE ARE ALOT OF THEM
	if(isset($_POST['basic_shipping_country_price']) && is_array($_POST['basic_shipping_country_price'])){
		
		if(!is_array($current_country_ship_array)){ $current_country_ship_array = array(); }
		
		
		if(isset($_POST['basic_country']) && !empty($_POST['basic_country'])){
			foreach($_POST['basic_country'] as $country){
				$current_country_ship_array[$_POST['basic_country_shipping_methods']][$country] = $_POST['basic_shipping_country_price'];
			}// end foreach	
			 
			update_option("ppt_country_ship_price_array",$current_country_ship_array, true);
			$current_country_ship_array = get_option('ppt_country_ship_price_array');
		}// end if
	}// end if 
	
} // end if



if(isset($_POST['free_ship_price']) && strlen($_POST['free_ship_price']) > 0){

	// SET CUSTOM ARRAY FOR COUTNRIES SINCE THERE ARE ALOT OF THEM	 
	if($_POST['basic_free_ship'] == ""){ $_POST['basic_free_ship'] = "default"; }
	
	
	
	$current_free_shipping_array[$_POST['basic_free_ship']] = $_POST['free_ship_price'];		
	 	 
	update_option("ppt_free_shipping_array",$current_free_shipping_array, true);
	$current_free_shipping_array = get_option('ppt_free_shipping_array'); 
 
	
} // end if




if( current_user_can('administrator') ){
  
 
	// COUPON CODE SETTINGS
	if(isset($_POST['ppt_coupon']) && is_array($_POST['ppt_coupon']) ){
	 
				
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$ppt_coupons = get_option("ppt_coupons");
		if(!is_array($ppt_coupons)){ $ppt_coupons = array(); }
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
			array_push($ppt_coupons, $_POST['ppt_coupon']);
		}else{
			$ppt_coupons[$_POST['eid']] = $_POST['ppt_coupon'];		
		}
		
		// LEAVE MESSAGE
		$GLOBALS['ppt_error'] = array(
			"type" 		=> "success",
			"title" 	=> __("Coupons Updated","premiumpress"),
			"message"	=> __("Your coupon list has been updated.","premiumpress"),
		);
		
		// SAVE ARRAY DATA		 
		update_option( "ppt_coupons", $ppt_coupons); 
	 
				
}elseif(isset($_GET['delete_coupon']) && is_numeric($_GET['delete_coupon'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$ppt_coupons = get_option("ppt_coupons");
	if(!is_array($ppt_coupons)){ $ppt_coupons = array(); }
	
	// LOOK AND SEARCH FOR DELETION
	foreach($ppt_coupons as $key=>$pak){
		if($key == $_GET['delete_coupon']){
			unset($ppt_coupons[$key]);	 
		}
	}
	
	// SAVE ARRAY DATA
	update_option( "ppt_coupons", $ppt_coupons);
	
		// LEAVE MESSAGE
		$GLOBALS['ppt_error'] = array(
			"type" 		=> "success",
			"title" 	=> __("Coupon Deleted","premiumpress"),
			"message"	=> __("Your coupon list has been updated","premiumpress"),
		);
	 
}

if(isset($_POST['coupon_import']) && strlen($_POST['coupon_import']) > 2 ){
	
	$ppt_coupons = get_option("ppt_coupons"); $new_coupons = array();
	if(!is_array($ppt_coupons)){ $ppt_coupons = array(); }
	$coupons = explode(PHP_EOL,$_POST['coupon_import']);
	if(is_array($coupons)){ $i=0; $g = count($ppt_coupons); $g++;
		foreach($coupons as $c){
		
			$ns = explode("[",$c);
			 
			if(strpos($ns[1],"%") === false){
				$pd = ""; $fd = $ns[1];
			}else{
				$pd = $ns[1]; $fd = "";
			}
			
			$new_coupons[$g] = array("code" => $ns[0], "discount_fixed" => str_replace("]","",$fd), "discount_percentage" => str_replace("%","",str_replace("]","",$pd)));
			$i++; $g++;
		}	
	 
		update_option( "ppt_coupons", array_merge($ppt_coupons,$new_coupons));	
	}	
 
 
	
}

}


?>
<style>
#overview-box { display:none; }
</style>
<?php

_ppt_template('framework/admin/header' ); 

?> 
<div class="tab-content">

  		
        <div class="tab-pane addjumplink  active" 
         
        data-title="<?php echo __("Overview","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is an overview of the tip and shipping settings.","premiumpress"); ?>"
 
        
        
        data-icon="fa-home" 
        id="overview" 
        role="tabpanel" aria-labelledby="overview-tab">
             <div id="overviewlist" class="row"> </div>                      
        </div>
        
        
                <div class="tab-pane addjumplink" 
         
        data-title="<?php echo __("Payment Gateways","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup and configure payment gateways for your website.","premiumpress"); ?>"
 

        data-icon="fa-credit-card" 
        id="gateways" 
        role="tabpanel" aria-labelledby="gateways-tab">
         <?php _ppt_template('framework/admin/_form-top' ); ?>
  <?php _ppt_template('framework/admin/parts/cart/cart-gateways' ); ?> 
      
        <?php _ppt_template('framework/admin/_form-bottom' ); ?>     
        </div><!-- end design home tab -->
        

 
        <div class="tab-pane addjumplink" 
         
        data-title="<?php echo __("Regions","premiumpress"); ?>" 
        data-desc="<?php echo __("Regions let you setup custom areas for settings shipping and tax values.","premiumpress"); ?>"
 

        data-icon="fa-globe" 
        id="regions" 
        role="tabpanel" aria-labelledby="regions-tab">
         <?php _ppt_template('framework/admin/_form-top' ); ?>

        <?php _ppt_template('framework/admin/parts/cart/cart-settings' ); ?> 
        <?php _ppt_template('framework/admin/_form-bottom' ); ?>     
        </div><!-- end design home tab -->
        
        
        
<?php if(defined('WLT_CART')){ ?>
       <div class="tab-pane addjumplink" 
         
        data-title="<?php echo __("Shipping","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup shipping options for your website.","premiumpress"); ?>"

        
        data-icon="fa-ship" 
        id="shipping" 
        role="tabpanel" aria-labelledby="shipping-tab">
         <?php _ppt_template('framework/admin/_form-top' ); ?>

        <?php _ppt_template('framework/admin/parts/cart/cart-shipping' ); ?>  
        <?php _ppt_template('framework/admin/_form-bottom' ); ?>    
        </div><!-- end design home tab -->

<?php } ?>

        <div class="tab-pane addjumplink" 
         
        
         data-title="<?php echo __("Coupons","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup coupon codes for your website.","premiumpress"); ?>"
 
        
        data-icon="fa-cut" 
        id="coupons" 
        role="tabpanel" aria-labelledby="coupons-tab">
         <?php _ppt_template('framework/admin/_form-top' ); ?>

        <?php _ppt_template('framework/admin/parts/cart/cart-coupons' ); ?>  
        <?php _ppt_template('framework/admin/_form-bottom' ); ?>    
        </div><!-- end design home tab -->


 


   
        
        <div class="tab-pane addjumplink" 
         
        
         data-title="<?php echo __("Tax","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup tax options for your website.","premiumpress"); ?>"
 
        
        data-icon="fa-font" 
        id="tax" 
        role="tabpanel" aria-labelledby="tax-tab">
         <?php _ppt_template('framework/admin/_form-top' ); ?>

        <?php _ppt_template('framework/admin/parts/cart/cart-tax' ); ?>  
        <?php _ppt_template('framework/admin/_form-bottom' ); ?>    
        </div><!-- end design home tab -->

 
 

</div>



<div style="display:none"><div id="ppt_weightbox">

    <li class="cfielditem"> 
    
 
    <div class="inside bg-white">    
       
 

        <div class="row">
        <div class="col-md-6  mb-3">
           <label>Select Region</label>
        </div>
        <div class="col-md-6">
        <select name="admin_values[weightship][region][]" class="form-control">
          <?php echo $region_list; ?>
        </select>
        </div>
        </div>

        <div class="row  mb-3">
        <div class="col-md-6">
            <label>Weight (greater than)</label>
        </div>
        <div class="col-md-6">
             <div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text">#</span></span>
                <input type="text" name="admin_values[weightship][pricea][]" class="form-control"/> 
            </div>  
        </div>
        </div>        
        
         <div class="row  mb-3">
        <div class="col-md-6">
            <label>Weight (less than)</label>
        </div>
        <div class="col-md-6">
             <div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text">#</span></span>
                <input type="text" name="admin_values[weightship][priceb][]" class="form-control"/>
            </div>  
        </div>
        </div>

         <div class="row  mb-3">
        <div class="col-md-6">
            <label> Price Per Item</label>
        </div>
        <div class="col-md-6">
             <div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
                 <input type="text" name="admin_values[weightship][pricec][]" class="form-control" />
            </div>  
        </div>
        </div>


     
    <hr />
    <button class="btn btn-primary" type="submit" >Save</button>
    
    </div>
    
    </li>  
      
</div> 

 
</div> 
<!-- DEFAULT BOX CODE --->




<div style="display:none"><div id="ppt_shipping_country_box">

    <li class="cfielditem">
    <div class="inside bg-white"> 
       
	 	
        <div class="row mb-3">
        <div class="col-md-6">
            <label>Display Caption</label>
        </div>
        <div class="col-md-6">
             <input type="text" name="admin_values[countryship][name][]" value="" class="form-control" />
        </div>
        </div>
        
        <div class="row  mb-3">
        <div class="col-md-6">
            <label>Select Region</label>
        </div>
        <div class="col-md-6">
            <select name="admin_values[countryship][region][]" id="wship1" class="form-control">
             <?php echo $region_list; ?>
            </select>
        </div>
        </div>
        
        <?php $types = array("0"=>"Light", "1"=>"Medium", "2" => "Heavy", "3" => "Very Heavy" );
        foreach($types as $key=>$tt){
        ?>
         
        <div class="row mb-3">
        <div class="col-md-6">
            <label><?php echo $tt; ?> Items</label>
        </div>
        <div class="col-md-6">
            <div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
                <input type="text" name="admin_values[countryship][<?php echo $key; ?>][]"  value="" class="form-control">    
            </div>   
        </div>
        </div>
        
        <?php } ?> 
     
    <hr />
    <button class="btn btn-primary" type="submit" >Save</button>
    
    </div>
    
    </li>  
      
</div> 

 
</div> 
<!-- DEFAULT BOX CODE --->




<div style="display:none"><div id="ppt_custom_methods_box">

    <li class="cfielditem">     
 
    <div class="inside bg-white"> 
       
    	
        <div class="row">
        <div class="col-md-6">
            <label>Display Caption</label>
        </div>
        <div class="col-md-6">
             <input type="text" name="admin_values[custommethods][name][]" value="" class="form-control" placeholder="e.g. Cash on colletion" />
        </div>
        </div>
        
        <div class="row mt-4">
        <div class="col-md-6">
            <label>Select Region</label>
        </div>
        <div class="col-md-6">
            <select name="admin_values[custommethods][region][]" id="wship1" class="form-control">
             <?php echo $region_list; ?>
            </select>
        </div>
        </div>
        
        
        <div class="row mt-4">
        <div class="col-md-6">
            <label>Price</label>
        </div>
        <div class="col-md-6">
               	<div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
                 <input type="text" name="admin_values[custommethods][price][]" class="form-control" />
                 <input type="hidden" name="admin_values[custommethods][key][]" value="cm-<?php echo rand(1000,99999); ?>" />
            </div> 
        </div>
        </div> 
    
    <hr />
    <button class="btn btn-primary" type="submit">Save</button>
    
    </div>
    
    </li>  
      
</div> 

 
</div> 
<!-- DEFAULT BOX CODE --->

<?php if(strlen($region_list) < 5){ ?>
<script>
jQuery(document).ready(function(){
	
	jQuery('#basic_shipping .btn-primary').hide();	
	jQuery('#ppt_weightbased_shpping, #ppt_shipping_methods, #ppt_shipping_country, #ppt_tax_country').html("<div class='noreg text-center h6 py-5 bg-light opacity-5'><?php echo __("Please setup a region first.","premiumpress"); ?></div>");
});

</script>
<?php } ?>
 

<?php if(isset($_GET['edit_coupon']) && is_numeric($_GET['edit_coupon']) ){ 
$ppt_coupons = get_option("ppt_coupons");
?>
<script>
jQuery(document).ready(function () { jQuery('#CouponModal').modal('show'); })
</script>

<?php } ?> 


<?php

_ppt_template('framework/admin/footer' ); 

?>

<form method="post" name="admin_coupon" id="admin_coupon" action="admin.php?page=cart">
 
<input type="hidden" name="lefttab" value="coupons-tab" />


<?php if(isset($_GET['edit_coupon']) && is_numeric($_GET['edit_coupon']) ){ ?>

<input type="hidden" name="eid" value="<?php echo esc_attr($_GET['edit_coupon']); ?>" />
<input type="hidden" name="ppt_coupon[ID]" value="<?php echo esc_attr($_GET['edit_coupon']); ?>" />
 
<?php } ?>
<div id="CouponModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="CouponModalLabel" aria-hidden="true" style="margin-top:10%;">
<div class="modal-dialog" role="document"><div class="modal-content"> 
            <div class="modal-body">
              
         
            
              	 <div class="row control-group mt-4">
                <label class="control-label col-md-3" for="normal-field"><b>Code</b></label>
                <div class="controls col-md-9">
                  <input type="text" name="ppt_coupon[code]" class="form-control" value="<?php if(isset($_GET['edit_coupon']) && isset($ppt_coupons[$_GET['edit_coupon']]['code']) ){ 
				  echo stripslashes($ppt_coupons[$_GET['edit_coupon']]['code']); }?>">
                   
                </div>
              </div> 
              
              <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Discount:</b></label>
                <div class="controls span9">
                
                <div class="row">
                
                    <div class="col-6">
                    
                    
                    
                     <div class="input-group" id="orders_date1" data-date-format="yyyy-MM-dd" style="cursor:pointer">
                    <span class="add-on input-group-prepend"><span class="input-group-text">%</span></span>
                    <input type="text"  name="ppt_coupon[discount_percentage]" class="form-control numericonly" value="<?php if(isset($_GET['edit_coupon']) && isset($ppt_coupons[$_GET['edit_coupon']]['discount_percentage']) ){ echo $ppt_coupons[$_GET['edit_coupon']]['discount_percentage']; }?>" placeholder="Percentage Value"> 
     				</div>
                     
                   
                    </div>                
                    <div class="col-6">
                    
                    
                    <div class="input-group" id="orders_date1" data-date-format="yyyy-MM-dd" style="cursor:pointer">
                    <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo _ppt(array('currency','symbol')); ?></span></span>
                    <input type="text"  name="ppt_coupon[discount_fixed]" class="form-control numericonly" value="<?php if(isset($_GET['edit_coupon']) && isset($ppt_coupons[$_GET['edit_coupon']]['discount_fixed']) ){ echo $ppt_coupons[$_GET['edit_coupon']]['discount_fixed']; }?>" placeholder="Fixed Amount">
     				</div>
                    
                    
                    
        
                    </div>
                </div> 
                   
                </div>
              </div> 
           
              
            </div>
            
            <div class="modal-footer">
            
              <button class="btn btn-primary"><?php echo __("Save changes","premiumpress"); ?></button>
            </div>
</div></div></div>
</form>