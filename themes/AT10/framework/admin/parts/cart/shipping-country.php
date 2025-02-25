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

// GET SHIPPING DATA
$countryship 	= _ppt('countryship');


 
  
?> 
<div class="card p-0 mt-5">
<div class="card-header">

<a href="javascript:void(0);" onClick="jQuery('#ppt_shipping_country_box').clone().prependTo('#ppt_shipping_country');" class="btn btn-primary btn-sm float-right" style="float:right;"><?php echo __("Add New","premiumpress") ?></a>	   

<span>
Country Based Shipping
</span>
</div>
<div class="card-body"> 

 

<ul id="ppt_shipping_country">

 
<?php 
 
 
if(is_array($countryship) && !empty($countryship['region'])){ $i=0;  

foreach($countryship['name'] as $cship){ 


	if($countryship['name'][$i] == ""){ continue; }
  
 
?>
<li class="cfielditem" id="cbs-<?php echo $i; ?>"> 

	<div class="heading">
      
     	<div class="showhide">
            <a href="#" onclick="jQuery('#cbs-inner<?php echo $i; ?>').fadeToggle();" rel="tooltip" data-original-title="Show/Hide Options" data-placement="top" class="btn btn-primary btn-sm">
            <i class="fa fa-search" aria-hidden="true"></i>
            </a>                                  
        </div>            

        <div class="name"> 
        
        <a href="#" onClick="jQuery('#csval-<?php echo $i; ?>').val('');jQuery('#cbs-<?php echo $i; ?>').hide();" rel="tooltip" data-original-title="Delete" data-placement="top" class="btn btn-primary btn-sm">
        <i class="fas fa-times" aria-hidden="true"></i>
        </a> 
 		
        <strong class="ml-2"><?php echo $countryship['name'][$i]; ?></strong>
        
        
        </div>
        
	</div> 
     
     
    <div id="cbs-inner<?php echo $i; ?>" class="bg-white"  style="display:none;padding:20px;">            
            
	 	
        <div class="row mb-3">
        <div class="col-md-6">
            <label>Display Caption</label>
        </div>
        <div class="col-md-6">
             <input type="text" name="admin_values[countryship][name][]" id="csval-<?php echo $i; ?>" value="<?php echo $countryship['name'][$i]; ?>" class="form-control" />
        </div>
        </div>
        
        <div class="row mb-3">
        <div class="col-md-6">
            <label>Select Region</label>
        </div>
        <div class="col-md-6">
            <select name="admin_values[countryship][region][]" id="wship1" class="form-control">
          <?php 
		  
$regions = _ppt('regions'); 
$c = 0;
if(is_array( $regions )){ 
	while($c < count($regions['name']) ){
		if($regions['name'][$c] !="" ){	
		
			if($countryship['region'][$i] == $regions['key'][$c] ){
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
        
        
        <?php $types = array("0"=>"Light", "1"=>"Medium", "2" => "Heavy", "3" => "Very Heavy" );
        foreach($types as $key=>$tt){
        ?>
         
        <div class="row  mb-3">
        <div class="col-md-6">
            <label><?php echo $tt; ?> Items</label>
        </div>
        <div class="col-md-6">
            <div class="input-group">
              <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
                <input type="text" name="admin_values[countryship][<?php echo $key; ?>][]"  value="<?php echo $countryship[$key][$i]; ?>" class="form-control">    
            </div>   
        </div>
        </div>
        
        <?php } ?> 
 
            
 
 	<hr />
    <button type="submit" class="btn btn-primary" onclick="document.getElementById('ShowTab').value='basic_shipping';document.getElementById('ShowSubTab').value='shiptab4'">Save</button>
    </div>
    
</li> 
<?php $i++; } } ?>

</ul>






</div></div><!-- end card -->