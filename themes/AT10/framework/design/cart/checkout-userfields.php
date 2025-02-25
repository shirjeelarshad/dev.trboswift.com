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

global $CORE, $CORE_CART, $userdata, $wpdb;
 
 
?>
 
<div class="row">

<?php 
foreach($CORE_CART->shop_user_fields as $key => $field){ ?>

	<?php 
	
		$colsize = "col-6"; $output = "";
		
		switch($field['type']){
		
		case "hidden": {
		
		} break;
	
		case "sep": { ?>
        
         
        <div class="col-12">
        <div class="ml-1">
        <h5 class="margin-top2"><?php echo __($field['caption'],"premiumpress"); ?></h5>
		<hr class="dashed" />
        <div class="clearfix"></div>
        </div>	
        
        </div>
         
		
		<?php } break;
		
		case "country": {
		
		// GET VALUE
		$value = "";
		
		if( isset($_POST[$key]) ){
		$value = esc_html($_POST[$key]);
		}elseif($userdata->ID){
		$value = get_user_meta($userdata->ID, $key, true);
		} 
	 
		
		ob_start(); 
		
		$admin_countries = _ppt('checkout_countries');
		 
		?> 
          
        <select class="form-control rounded-0" id="field-<?php echo $key; ?>" name="<?php echo $key; ?>">
		
     
        <?php 
		
		// ADMIN DISPLAY COUNTRIES
		$admin_countries = _ppt('checkout_countries');
 		
		// LOOP
		foreach($GLOBALS['core_country_list'] as $ckey => $cvalue){
		
		
		// HIDE COUNTRIES
		if( !is_array( $admin_countries ) || is_array($admin_countries) && in_array("0", $admin_countries ) ){
		
		
		}else{
		
			if( is_array( $admin_countries ) && $admin_countries[0] != ""){		
				if(!in_array( $ckey, $admin_countries )  ){
				continue;
				}
			}
		
		}
		
		if($value == $ckey){ $sel ="selected=selected"; }else{ $sel =""; }
		
		echo "<option ".$sel." value='".$ckey."'>".$cvalue."</option>";} ?>
        
        </select>  
        
        <?php
		
		$output = ob_get_clean(); 
		
		} break;
		case "state": {
		
		// GET VALUE
		$value = "";		 
		if( isset($_POST[$key]) ){
		$value = esc_html($_POST[$key]);
		}elseif($userdata->ID){
		$value = get_user_meta($userdata->ID, $key, true);
		}
		
		if($value  == "" && _ppt('checkout_default_state') != ""){
		$value = _ppt('checkout_default_state');
		}
		
		
		
		ob_start(); 
		
		?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" id="field-hidden-state" /> 
        <select class="form-control rounded-0" id="field-<?php echo $key; ?>" name="<?php echo $key; ?>">
 
			 
        </select>  
        
        <?php
		
		$output = ob_get_clean(); 
		
		} break;
		
		case "textarea": { $colsize = "col-6"; }
		default: { 
		
		//
		
		// GET VALUE
		$value = "";
		 
		if( isset($_POST[$key]) ){
		$value = esc_html($_POST[$key]);
		}elseif($userdata->ID){
		$value = get_user_meta($userdata->ID, $key, true);
		}
		
		// DEFAULT FOR CITY FIELD
		if($key == "billing_city" && $value  == "" && _ppt('checkout_default_city') != ""){
		$value = _ppt('checkout_default_city');
		}
		
			
		
		ob_start(); 
		?>
        
		<?php 
		
		
		
		if($field['type'] == "textarea"){ 
		 
		
		?>
     
        <textarea class="form-control rounded-0 <?php if(!isset($field['nr']) && !isset($GLOBALS['flag-account']) ){ ?>required-field<?php } ?>" name="<?php echo $key; ?>" id="field-<?php echo $key; ?>"><?php echo $value; ?></textarea>
        
        <?php }else{ 
		
		
		
		?>
        <input type="text"  class="form-control rounded-0 <?php if(!isset($field['nr']) && !isset($GLOBALS['flag-account']) ){ ?>required-field<?php } ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" id="field-<?php echo $key; ?>">
        <?php } ?>
        
        
        <?php 
		
		$output = ob_get_clean(); 
		} 
		
		
		}// end switch ?> 
        
        <?php if($output != ""){ ?>
        <div class="<?php echo $colsize; ?>">
        <div class="form-group">
        <label class="control-label"><?php echo __($field['caption'],"premiumpress"); ?><?php if(!isset($field['nr']) && !isset($GLOBALS['flag-account'])  ){ ?><span class="red">*</span><?php } ?></label>
        <div class="controls">
        
        <?php echo $output; ?>
                   
        </div>
        </div>
        </div>
        <?php } ?>

<?php } ?>

</div>

  
<?php
// GET VALUE
		$value = "";
		if( isset($_POST[$key]) ){
		$value = esc_html($_POST[$key]);
		}elseif($userdata->ID){
		$value = get_user_meta($userdata->ID, $key, true);
		}
?>
<div class="form-group">
        <label class="control-label"><?php echo __("Order Notes.","premiumpress") ?></label>
        <div class="controls">
          
        <textarea class="form-control rounded-0" name="billing_comments" id="field-billing_comments" style="height:150px;" placeholder="<?php echo __("Notes about your order, e.g. special notes for delivery.","premiumpress") ?>"><?php echo $value; ?></textarea>
 </div>
</div>
 



<?php
// GET SHIPPING METHODS
$custommethods 	= _ppt('custommethods');
 
if(is_array($custommethods) && !empty($custommethods['region'])){ $i=0;
	
if(is_array($custommethods['name'])){ 

$hasValue = false;

ob_start();
?>

<h5><?php echo __("Shipping Methods","premiumpress") ?></h5>
<hr class="dashed" />

<div class="form-style1 clearfix">

<input type="hidden" name="custommethod-name" id="cmn" value="" />
<input type="hidden" name="custommethod-price" id="cmp" value="" />
<script>
function setupMethod(name, price){
	jQuery("#cmn").val(name);
	jQuery("#cmp").val(price);
}
</script>
<?php
 

foreach($custommethods['name'] as $cship){

	if($custommethods['name'][$i] == ""){ $i++; continue; } 
	
	$hasValue = true;

?>

<div class="row">

    <div class="col-1">
    
    <div>
    <input 
    name="custommethod" <?php if(isset($_POST['custommethod']) && $_POST['custommethod'] == $custommethods['key'][$i]){ ?>checked=checked<?php } ?> 
    type="checkbox" 
    value="<?php echo $custommethods['key'][$i]; ?>" 
    onclick="setupMethod(this.value,'<?php echo $custommethods['price'][$i]; ?>');" />
    </div>
    
    </div>
    
    <div class="col-11">
    
     
   <span class="mr-2">
   
   <?php if(is_numeric($custommethods['price'][$i])){ echo hook_price($custommethods['price'][$i]); }else{ echo $custommethods['price'][$i]; } ?>
   
   </span>
    
   <?php echo $custommethods['name'][$i]; ?> 
   
     
    </div>

</div>


<?php $i++; } } ?>

</div> 
<?php 

$SavedContent = ob_get_clean(); ob_flush();

if($hasValue){
	echo $SavedContent;
}


} // end shipping methods ?>




<hr class="dashed margin-top3" />

<script type="application/javascript">

jQuery(document).ready(function(){ 

	jQuery('#field-billing_country').on('change', function(e){
	
		 ajax_cart_update_country();
	
	});
		 	
	 ajax_cart_update_country();	
});

function ajax_cart_update_country(){

// COUNTRY VALUE
var countryid = jQuery('#field-billing_country').val();
if(countryid == ""){
countryid = jQuery('#field-billing_country option:first').val();
}
 

jQuery('#field-billing_country').val()

    jQuery.ajax({
        type: "POST",
        url: ajax_site_url,	 	
		data: {
            action: "get_location_states",
			country_id: countryid,
  			state_id: jQuery('#field-hidden-state').val(),
        },
        success: function(response) {
		//console.log(response);
			jQuery("#field-billing_state").html(response);
        },
        error: function(e) {
             
        }
    });
}

</script>