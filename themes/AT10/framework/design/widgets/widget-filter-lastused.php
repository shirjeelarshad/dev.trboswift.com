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

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata, $post, $settings; 

if(isset($GLOBALS['flag-search'])){ // added to stop sowing on homepage for slower SEO
 
if(isset($_GET['lastused1']) && is_numeric($_GET['lastused1'])){ $price1 = esc_attr($_GET['lastused1']); }else{ $price1 = 365; }		
  
?>

<div class="card card-filter">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_price" aria-expanded="true" class="">
    <h5 class="card-title"><?php  echo __("Last Used","premiumpress");  ?></h5>
    </a>
    <div class="filter-content collapse" id="collapse_price">
    
      <div class="distance" style="display:none"><?php  echo __("within the last","premiumpress");  ?> 
      <span class="txt_price1"><?php echo $price1; ?></span> <?php echo __("days","premiumpress"); ?> 
      </div>
     
      <div class="distance_today" style="display:none"><?php  echo __("Used Today","premiumpress");  ?>! <i class="fal fa-smile-beam"></i> </div>
      
      <div class="distance_anytime"><?php  echo __("Used Anytime","premiumpress");  ?> <i class="fal fa-smile"></i> </div>
     
      <div>
        <input type="text" class="price-slider" value=""  />
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="lastused1" class="form-control customfilter" data-type="text" data-key="lastused1" id="filter_price_value_1" value="<?php echo $price1; ?>">
 
<script>

jQuery(document).ready(function(){  

 jQuery(".price-slider").ionRangeSlider({        
		
		min:1,
		max:365,
		from:"365",
		 
		step:1,
		//grid: true,
        hide_min_max:true,
		hide_from_to:true,
		
		onChange: function (data) {
            
			jQuery('.txt_price1').html(data.from);
			 
			jQuery('#filter_price_value_1').val(data.from);
			
			if(data.from == 1){
			
			jQuery('.distance').hide();
			jQuery('.distance_today').show();
			jQuery('.distance_anytime').hide();
			
			}else if(data.from == 365){
			
			jQuery('.distance').hide();
			jQuery('.distance_today').hide();
			jQuery('.distance_anytime').show();
			
			} else {
			
			jQuery('.distance').show();
			jQuery('.distance_today').hide();
			jQuery('.distance_anytime').hide();
			}
			 
						 
        },onFinish: function (data) { 
		    
           _filter_update();
        }		
}); 

 
	
});
</script>
<?php } */ ?>