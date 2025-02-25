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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// COUNTRY LIST
$country_string1 = "";
foreach($GLOBALS['core_country_list'] as $key=>$value){
	$country_string1 .= "<option value='".$key."'>".$value."</option>";
} // end if 
  
?> 

<?php 

global $settings;

$settings = array("title" => "Regions", "desc" => "Regions let you setup country/state combinations which can be used for custom tax and shipping prices. <br><br>Note: If you are applying the same tax/ship price for the entire country, you do not need to add all of the states/provinces as well.", "video" => "");

_ppt_template('framework/admin/_form-wrap-top' ); ?>  <div class="card card-admin"><div class="card-body">
 
  

 <?php _ppt_template('framework/admin/parts/cart/shipping-regions' ); ?>
 
 
<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> Save Settings</button>
    </div>
    
    
    
    
    


</div></div><?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>

<?php 

 

global $settings;

$settings = array("title" => "Display Countries ", "desc" => "Here you can limit which countries are displayed at checkout and via the members area.", "video" => "");


$checkoutcountries = _ppt('checkout_countries');
 
_ppt_template('framework/admin/_form-wrap-top' ); ?>  <div class="card card-admin"><div class="card-body">
 
         
 

<h4><?php echo __("Available Countries","premiumpress"); ?></h1>
<hr />
     
<div class="form-group"> 
<select data-placeholder="Select Countries..."  name="admin_values[checkout_countries][]" class="form-control w-100" style="height:400px !important; width:100% !important;" multiple="multiple">
<option value="0" <?php if( !is_array( $checkoutcountries ) || is_array($checkoutcountries) && in_array("0", $checkoutcountries ) ){ echo "selected=selected"; } ?>><?php echo __("All Countries","premiumpress"); ?></option>
<?php
$country_string = $country_string1;

// ADD ON SELECTED ITEMS
if( is_array( $checkoutcountries ) ){
 
	foreach($checkoutcountries as $selected_countries){
	 
		if( strlen($selected_countries) > 1){	
		
			$country_string = str_replace($selected_countries."'",$selected_countries."' selected=selected",$country_string);	
		}
	}
}

echo $country_string;
?>
</select> 

</div> 


<p class="text-muted mt-2"><?php echo __("Press and hold CTRL to select multiple values.","premiumpress"); ?></p>

 
  
 
 
 
<?php if(THEME_KEY == "sp"){ ?>
<div class="row">

<div class="col-md-6">

 
 
<div class="form-group"> 
    	<label class="txt500 mt-3">Default State </label>
        
<input type="text" class="form-control" name="admin_values[checkout_default_state]" value="<?php echo stripslashes(_ppt('checkout_default_state')); ?>" placeholder="e.g. North Yorkshire">	 
 
</div>

</div>
<div class="col-md-6">
 
 
<div class="form-group"> 
    	<label class="txt500 mt-3">Default City </label>
        
<input type="text" class="form-control" name="admin_values[checkout_default_city]" value="<?php echo stripslashes(_ppt('checkout_default_city')); ?>" placeholder="e.g. Scarborough">	 

 </div>
 

</div></div> 

<?php } ?>

 

<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
    
</div></div>  

<?php _ppt_template('framework/admin/_form-wrap-bottom' );


 

 ?>