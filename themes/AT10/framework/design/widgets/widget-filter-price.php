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

global $CORE; 

// FIND THE MAX PRICE OF ITEMS IN OUR DATABASE
/*
if(THEME_KEY == "at"){
$SQL = "SELECT meta_value FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'price_current' AND meta_value != '' ORDER BY meta_value DESC LIMIT 1"; 
}else{
$SQL = "SELECT meta_value FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'price' AND meta_value != '' ORDER BY meta_value DESC LIMIT 1"; 
}
$result = $wpdb->get_results($SQL);
if(empty($result)){
	$max_price = "1000";
}else{
	$max_price = preg_replace("/[^0-9.]/", "", $result[0]->meta_value);
}
*/
 
 
if(isset($_GET['price1']) && is_numeric($_GET['price1'])){ $price1 = esc_attr($_GET['price1']); }else{ $price1 = ""; }		
if(isset($_GET['price2']) && is_numeric($_GET['price2']) && $_GET['price2'] > 0){ $price2 = esc_attr($_GET['price2']); }else{ 

	$price2 = "";

}


 
?>

<div class="card card-filter">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_price" aria-expanded="true" class="">
    <span class="small text-black"><?php 
	
	if(THEME_KEY == "jb"){ 
	echo __("Salary","premiumpress"); 
	}else{
	echo __("Price","premiumpress"); 
	}
	
	?></span>
    </a>
    
     <div <?php if(!$CORE->isMobileDevice()){ ?> class="filter-content collapse" id="collapse_price"<?php }else{ ?> class="pt-2"<?php } ?>>
    
    
    <div class="price-distance row ">
    <div class="col-md-6">
    <div class="position-relative d-flex align-items-center">
    <label><?php if(THEME_KEY == "pj"){ echo __("Min. Budget","premiumpress"); }else{ echo __("Min","premiumpress"); } ?><?php echo hook_currency_symbol(''); ?></label>
    
    <input type="text" placeholder="<?php echo __("$124","premiumpress"); ?>" name="price1" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> class="customfilter val-numeric" data-type="text" data-key="price1" id="filter_price_value_1" value="<?php echo $price1; ?>">
    
    
     
     </div>
    
    </div>
    <div class="col-md-6">
   
    
    <div class="price-distance-max position-relative d-flex align-items-center">
     <label><?php if(THEME_KEY == "pj"){ echo __("Max. Budget","premiumpress"); }else{ echo __("Max","premiumpress"); } ?><?php echo hook_currency_symbol(''); ?></label>
    <input type="text" placeholder="<?php echo __("$8999","premiumpress"); ?>" class=" customfilter val-numeric" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> name="price2" data-type="text" data-key="price2" id="filter_price_value_2" value="<?php echo $price2; ?>">
    
    
    
    </div>
    
    </div>    
    </div>
    
    <!-- Predefined Price Checkboxes -->
      <div class="price-checkboxes mt-3">
        <label class="custom-control custom-checkbox">
          <input type="checkbox" value="10000" class="custom-control-input customfilter price-checkbox" data-min="0" data-max="10000" data-key="price">
          <div class="custom-control-label addcount" data-countkey="price">Less than $10k</div>
        </label>
        <label class="custom-control custom-checkbox">
          <input type="checkbox" value="150000" class="custom-control-input customfilter price-checkbox" data-min="50000" data-max="150000" data-key="price">
          <div class="custom-control-label addcount" data-countkey="price">From $50k to $150k</div>
        </label>
        <label class="custom-control custom-checkbox">
          <input type="checkbox" value="500000" class="custom-control-input customfilter price-checkbox" data-min="200000" data-max="500000" data-key="price">
          <div class="custom-control-label addcount" data-countkey="price">From $200k to $500k</div>
        </label>
        <label class="custom-control custom-checkbox">
          <input type="checkbox" value="500001" class="custom-control-input customfilter price-checkbox" data-min="500000" data-max="10000000" data-key="price">
          <div class="custom-control-label addcount" data-countkey="price">More than $500k</div>
        </label>
      </div>
    
     </div> 
  </div> 
</div>   

<script>
jQuery(document).ready(function() {
// Checkbox event listener
    jQuery('.price-checkbox').on('change', function() {
      var min = jQuery(this).data('min');
      var max = jQuery(this).data('max');

      // Update price input fields
      jQuery('input[name="price1"]').val(min);
      jQuery('input[name="price2"]').val(max);

      // Trigger filter update
      _filter_update();
    });
    
      });

</script>

    <?php /* ?>
    
    
    
    <div class="filter-content collapse" id="collapse_price">
      <div class="distance"> <?php echo __("Between","premiumpress"); ?> <span class="txt_price1">0</span> <?php echo __("and","premiumpress"); ?> <span class="txt_price2"><?php echo $price2; ?></span></div>
      <div class="">
        <input type="text" class="price-slider" value=""  />
      </div>
    </div>
    
    
<input type="hidden" name="price1" autocomplete="off" class="form-control customfilter" data-type="text" data-key="price1" id="filter_price_value_1" value="<?php echo $price1; ?>">
<input type="hidden" class="form-control customfilter" name="price2" data-type="text" data-key="price2" id="filter_price_value_2" value="<?php echo $max_price; ?>">
<script>

function ionPriceDistance() {
    var priceRanges = jQuery('input[name="price[]"]:checked').map(function() {
        return jQuery(this).val();
    }).get();

jQuery(document).ready(function(){  

 jQuery(".price-slider").ionRangeSlider({ 
        type: "double",
		
		min: "<?php echo $price1; ?>",
		max: "<?php echo $max_price; ?>",
		from:0,
		to: "<?php echo $price2; ?>",
		step:1,
		//grid: true,
        hide_min_max:true,
		hide_from_to:true,
		
		onChange: function (data) {
            
			jQuery('.txt_price1').html(data.from).formatCurrency( { symbol: '<?php if(_ppt(array('currency','switch')) != 1){  echo _ppt(array('currency','symbol')); }else{ echo hook_currency_symbol(''); } ?>', roundToDecimalPlace:0 });
			jQuery('.txt_price2').html(data.to).formatCurrency( { symbol: '<?php if(_ppt(array('currency','switch')) != 1){  echo _ppt(array('currency','symbol')); }else{ echo hook_currency_symbol(''); } ?>', roundToDecimalPlace:0 });
			
			jQuery('#filter_price_value_1').val(data.from);
			jQuery('#filter_price_value_2').val(data.to);
						 
        },onFinish: function (data) { 
		    
           _filter_update();
        }		
}); 

	jQuery('.txt_price1').formatCurrency( { symbol: '<?php if(_ppt(array('currency','switch')) != 1){  echo _ppt(array('currency','symbol')); }else{ echo hook_currency_symbol(''); } ?>', roundToDecimalPlace:0 });
	jQuery('.txt_price2').formatCurrency( { symbol: '<?php if(_ppt(array('currency','switch')) != 1){  echo _ppt(array('currency','symbol')); }else{ echo hook_currency_symbol(''); } ?>', roundToDecimalPlace:0 });
	
});
</script>

    
    
 <?php */ ?>