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

global $region_list;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values"); 

// GET WEIGHT SHIP
$weightship = _ppt('weightship'); 

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
 

  
?>
</div>
</div>

<div class="card card-admin">
<div class="card-body">
<a href="javascript:void(0);" onClick="jQuery('#ppt_weightbox').clone().prependTo('#ppt_weightbased_shpping');" class="btn btn-system btn-md shadow-sm float-right"><i class="fal fa-plus"></i> <?php echo __("Add New","premiumpress"); ?></a>
<h4><?php echo __("Weight Based Shipping","premiumpress"); ?></h4>
<div class="small opacity-5"><?php echo __("This will check the total cart value at the end of checkout.","premiumpress"); ?></div>
<hr />
<ul id="ppt_weightbased_shpping">
  <?php 


if(is_array($weightship) && !empty($weightship['region'])){ $wi=0;  

foreach($weightship['region'] as $weightopK){ 

if($core_admin_values['weightship']['pricec'][$wi] == ""){ $wi++; continue; }
 			 
 
?>
  <li class="cfielditem" id="ewbs<?php echo $wi; ?>">
    <div class="heading">
      <div class="showhide"> <a href="javascript:void(0);" onclick="jQuery('#ewbsinner<?php echo $wi; ?>').fadeToggle();" rel="tooltip" data-original-title="Show/Hide Options" data-placement="top" class="btn btn-primary btn-sm"> <i class="fa fa-search" aria-hidden="true"></i> </a> </div>
      <div class="name"> <a href="javascript:void(0);" onclick="clearwd('ewbs<?php echo $wi; ?>');" rel="tooltip" data-original-title="Delete" data-placement="top" class="btn btn-primary btn-sm"> <i class="fas fa-times" aria-hidden="true"></i> </a> <strong class="ml-2"> > <?php echo $weightship['pricea'][$wi]; ?> < <?php echo $weightship['priceb'][$wi]; ?> = <?php echo hook_price($weightship['pricec'][$wi]); ?> </strong> </div>
    </div>
    <div id="ewbsinner<?php echo $wi; ?>" class="bg-white"  style="display:none;padding:20px;">
      <div class="row">
        <div class="col-md-6">
          <label>Region</label>
        </div>
        <div class="col-md-6">
          <select name="admin_values[weightship][region][]" class="form-control">
            <?php 
		  
$regions = _ppt('regions'); 
$c = 0;
if(is_array( $regions )){ 
	while($c < count($regions['name']) ){
		if($regions['name'][$c] !="" ){	
		
			if($core_admin_values['weightship']['region'][$wi] == $regions['key'][$c] ){
			echo "<option value='".$regions['key'][$c]."' selected=selected>".$regions['name'][$c]."</option>";	
			}else{
			echo "<option value='".$regions['key'][$c]."'>".$regions['name'][$c]."</option>";	
			}
								
		} // end if
	$c++;
	} // end foreach
}// end if
		 
		  ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label>Weight (greater than)</label>
        </div>
        <div class="col-md-6">
          <div class="input-group"> <span class="add-on input-group-prepend"><span class="input-group-text">#</span></span>
            <input type="text" name="admin_values[weightship][pricea][]" value="<?php echo $core_admin_values['weightship']['pricea'][$wi]; ?>" class="form-control"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label>Weight (less than)</label>
        </div>
        <div class="col-md-6">
          <div class="input-group"> <span class="add-on input-group-prepend"><span class="input-group-text">#</span></span>
            <input type="text" name="admin_values[weightship][priceb][]" value="<?php echo $core_admin_values['weightship']['priceb'][$wi]; ?>" class="form-control"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label> Price Per Item</label>
        </div>
        <div class="col-md-6">
          <div class="input-group"> <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
            <input type="text" name="admin_values[weightship][pricec][]" value="<?php echo $core_admin_values['weightship']['pricec'][$wi]; ?>" class="form-control" />
          </div>
        </div>
      </div>
      <hr />
      <button type="submit" class="btn btn-primary" onclick="document.getElementById('ShowTab').value='basic_shipping';document.getElementById('ShowSubTab').value='shiptab4'"><?php echo __("Save","premiumpress"); ?></button>
    </div>
  </li>
  <?php $wi++; } } ?>
</ul>

<script>
function clearwd(div){

jQuery("#"+div+" input").val('');

jQuery('#'+div).hide();

}
</script>

 
   <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>


 
