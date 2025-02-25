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


$current_country_ship_array = get_option('ppt_country_ship_price_array'); $current_amount_ship_array = get_option('ppt_amount_ship_price_array'); $current_free_shipping_array = get_option('ppt_free_shipping_array');
 
global $settings;

$settings = array("title" => "Shipping ", "desc" => "Here you can setup shipping options for your website.", "video" => "https://www.youtube.com/watch?v=8huSOebhC_c");

_ppt_template('framework/admin/_form-wrap-top' ); ?>  <div class="card card-admin"><div class="card-body">
 
   
<?php if(defined('WLT_CART')){  ?>


<div class="row mb-4" style="padding: 20px;    background: #ecf6ff;    margin: -2px;border:0px;">

    <div class="col-10">
    
        <h4><?php echo __("Force Shipping","premiumpress"); ?></h4>        
        <p class="text-muted mt-2"><?php echo __("By default shipping charges are enabled per item.  Enable this option to turn shipping on for all items.","premiumpress"); ?></p>
        
    </div>
    
    <div class="col-2">
    
	<div class="mt-3">
                                    <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('system_shipping').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('system_shipping').value='1'">
                                  </label>
                                  <div class="toggle <?php if(_ppt('system_shipping') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                           
                             
                             <input type="hidden" id="system_shipping" name="admin_values[system_shipping]" 
                             value="<?php echo _ppt('system_shipping'); ?>"> 
                             
                              
    
</div>
</div>


<?php } ?> 



<h4><?php echo __("Flat Rate Shipping","premiumpress"); ?></h4>

<div class="small opacity-5"><?php echo __("This will apply shipping to all items at checkout.","premiumpress"); ?></div>


<hr />
  
 
 
  
  

<div class="row">

<div class="col-md-3">

    <label class="txt500"><?php echo __("Enable","premiumpress"); ?></label>
  <div class="mt-3">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('basic_shipping_flatrate').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('basic_shipping_flatrate').value='1'">
                                  </label>
                                  <div class="toggle <?php if(_ppt('basic_shipping_flatrate') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                           
                             
                             <input type="hidden" id="basic_shipping_flatrate" name="admin_values[basic_shipping_flatrate]" 
                             value="<?php echo _ppt('basic_shipping_flatrate'); ?>"> 
  

</div>

<div class="col-md-4">

	<label class="txt500"><?php echo __("Flat Rate","premiumpress"); ?> <br /><small> (<?php echo __("fixed price","premiumpress"); ?>)</small></label>
    <div class="input-group">
      <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
        <input type="text" name="admin_values[basic_shipping][flatrate]"  value="<?php echo _ppt(array('basic_shipping','flatrate')); ?>" class="form-control" >    
    </div>   
 
</div>

 

<div class="col-md-4">

	<label class="txt500"><?php echo __("Flat Rate","premiumpress"); ?> <br /><small>(<?php echo __("percentage","premiumpress"); ?>)</small></label>
    <div class="input-group">
     <span class="add-on input-group-prepend"><span class="input-group-text">%</span></span>
   <input type="text" name="admin_values[basic_shipping][flatrate_percent]" value="<?php echo _ppt(array('basic_shipping','flatrate_percent')); ?>" class="form-control" >   
    </div>   
 
</div>

</div> 

 
 
 
</div></div>
<div class="card card-admin"><div class="card-body">
 
 
 
 
 <h4><?php echo __("Free Shipping","premiumpress"); ?></h4>

<div class="small opacity-5"><?php echo __("This will check the total cart value at the end of checkout.","premiumpress"); ?></div>


<hr />
  
 
 
 

 

 

<div class="row">

<div class="col-md-3">

    <label><?php echo __("Enable","premiumpress"); ?></label>
  <div>
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('basic_free_shipping').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('basic_free_shipping').value='1'">
                                  </label>
                                  <div class="toggle <?php if(_ppt('basic_free_shipping') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                           
                             
                             <input type="hidden" id="basic_free_shipping" name="admin_values[basic_free_shipping]" 
                             value="<?php echo _ppt('basic_free_shipping'); ?>"> 
  

</div>

<div class="col-md-4">

  <label><?php echo __("Select Region","premiumpress"); ?></label>
               
                
                  <select data-placeholder="Choose a region..." class="form-control" name="basic_free_ship" id="freeship" style="width:100%;">
                
                    <option value="" title='<?php if(isset($current_free_shipping_array['default'])){ echo $current_free_shipping_array['default']; } ?>'><?php echo __("All Regions","premiumpress"); ?></option>
                    
                    <?php
					
					$regions = _ppt('regions');
					
					 
					if(is_array($regions)){ 
						$i=0; 
						if(isset($regions['name'])){
						
						 
						while($i < count($regions['name']) ){
						
							if($regions['name'][$i] !=""){	
							
								$pp1 = "";
								$amount = 0;
								
								if( isset($current_free_shipping_array[$regions['name'][$i]]) && is_numeric($current_free_shipping_array[$regions['name'][$i]]) && $current_free_shipping_array[$regions['name'][$i]] > 0 ){
								$amount = $current_free_shipping_array[$regions['name'][$i]];
								}
								
								
								$pp1 = "title='".$amount."|'";	
								 
											
								echo "<option value='".$regions['name'][$i]."' ".$pp1." id='".$i."'>".$regions['name'][$i]."</option>";	
								
							} // end if
							$i++;
						} // end foreach
					}// end if		
					}		 
					?>                    
                  </select>

</div>
      <script>
			jQuery(document).ready(function(){
				jQuery( "#freeship" ).change(function() {				 
					var sdt = jQuery("option:selected", this).attr("title");						 	 
					if(sdt != ""){	
					var exploded = sdt.split('|');
					 jQuery('#free_ship_price').val(exploded[0]);
					 
					}
				});		
			});
			</script> 

<div class="col-md-4">
	<label class="span4"><?php echo __("Orders Over","premiumpress"); ?></label>
    <div class="input-group">
      <span class="add-on input-group-prepend"><span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span></span>
        <input type="text" class="form-control" name="free_ship_price" id="free_ship_price" value="<?php if(isset($current_free_shipping_array['default']) && $current_free_shipping_array['default'] > 0){ echo $current_free_shipping_array['default']; } ?>">    
    </div>  
    
 

</div>


<div class="col-12">

   <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>


</div>


 
 </div>  
 
 
 
 
 <?php //_ppt_template('framework/admin/parts/cart/shipping-country' ); ?>
 
 

 <?php _ppt_template('framework/admin/parts/cart/shipping-weight' ); ?>
 
 
 <?php _ppt_template('framework/admin/parts/cart/shipping-methods' ); ?>
 
 


    



</div></div>


 


<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>