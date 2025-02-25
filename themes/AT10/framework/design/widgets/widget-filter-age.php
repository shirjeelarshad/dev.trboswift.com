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

global $CORE, $userdata, $post, $settings; 

// FIND THE MAX PRICE OF ITEMS IN OUR DATABASE
$max_price = 85; 
 
if(isset($_GET['age1']) && is_numeric($_GET['age1'])){ $price1 = esc_attr($_GET['age1']); }else{ $price1 = __("18","premiumpress"); }		
if(isset($_GET['age2']) && is_numeric($_GET['age2']) && $_GET['age2'] > 0){ $price2 = esc_attr($_GET['age2']); }else{ $price2 = __("65","premiumpress"); }	 

 		
 
?>

<div class="card card-filter">
  <div class="card-body"> 
  <a href="#" data-toggle="collapse" data-target="#collapse_age" aria-expanded="true">
    <h5 class="card-title"><?php  echo __("Aged Between","premiumpress");  ?></h5>
    </a>
    
   <div <?php if(!$CORE->isMobileDevice()){ ?> class="filter-content collapse" id="collapse_age" <?php }else{ ?> class="pt-2"<?php } ?>>
    
    <div class="row">
    <div class="col-md-6">
    <label><?php echo __("Min. Age","premiumpress"); ?></label>
    
    <input type="text" name="price1" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> class="form-control customfilter val-numeric" data-type="text" data-key="age1" id="filter_age_value_1" value="<?php echo $price1; ?>">
    </div>
    <div class="col-md-6">
    <label><?php echo __("Max. Age","premiumpress"); ?></label>
    <input type="text" class="form-control customfilter val-numeric" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> name="age2" data-type="text" data-key="age2" id="filter_age_value_2" value="<?php echo $price2; ?>">
    </div>    
    </div>

</div>
</div>
</div>
<?php /*
    
  <div class="filter-content collapse" id="collapse_price">
    
       
    
    
      <div class="distance"> <span class="txt_price1"><?php echo $price1; ?></span> <?php echo __("and","premiumpress"); ?> <span class="txt_price2"><?php echo $price2; ?></span></div>
      <div class="">
        <input type="text" class="price-slider" value=""  />
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="age1" class="form-control customfilter" data-type="text" data-key="age1" id="filter_price_value_1" value="<?php echo $price1; ?>">
<input type="hidden" class="form-control customfilter" name="age2" data-type="text" data-key="age2" id="filter_price_value_2" value="<?php echo $max_price; ?>">
<script>

jQuery(document).ready(function(){  

 jQuery(".price-slider").ionRangeSlider({ 
        type: "double",
		
		min: "0",
		max: "<?php echo $max_price; ?>",
		from:"<?php echo $price1; ?>",
		to: "<?php echo $price2; ?>",
		step:1,
		//grid: true,
        hide_min_max:true,
		hide_from_to:true,
		
		onChange: function (data) {
            
			jQuery('.txt_price1').html(data.from);
			jQuery('.txt_price2').html(data.to);
			
			jQuery('#filter_price_value_1').val(data.from);
			jQuery('#filter_price_value_2').val(data.to);
						 
        },onFinish: function (data) { 
		    
           _filter_update();
        }		
}); 

 
	
});
</script>
*/ ?>