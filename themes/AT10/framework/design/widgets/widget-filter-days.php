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
 
if(isset($_GET['days1']) && is_numeric($_GET['days1'])){ $price1 = esc_attr($_GET['days1']); }else{ $price1 = 0; }		
if(isset($_GET['days2']) && is_numeric($_GET['days2']) && $_GET['days2'] > 0){ $price2 = esc_attr($_GET['days2']); }else{ $price2 = 30; }	 

 		
 
?>

<div class="card card-filter">
  <div class="card-body"> 
  <a href="#" data-toggle="collapse" data-target="#collapse_age" aria-expanded="true" class="">
    <h5 class="card-title"><?php  echo __("Delivery Time","premiumpress");  ?></h5>
    </a>
    
   <div class="filter-content collapse" id="collapse_days" >
    
    <div class="row ">
    <div class="col-md-6">
    <label><?php echo __("Min. Days","premiumpress"); ?></label>
    
    <input type="text" name="days1" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> class="form-control customfilter val-numeric" data-type="text" data-key="days1" id="filter_days_value_1" value="<?php echo $price1; ?>">
    </div>
    <div class="col-md-6">
    <label><?php echo __("Max. Days","premiumpress"); ?></label>
    <input type="text" class="form-control customfilter val-numeric" autocomplete="off" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> name="days2" data-type="text" data-key="days2" id="filter_days_value_2" value="<?php echo $price2; ?>">
    </div>    
    </div>

</div>
</div>
</div> 