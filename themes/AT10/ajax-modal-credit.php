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


global $CORE, $userdata;

 ?>

<div class="p-4 font-itc">

<i class="fal fa-sack fa-3x float-left mr-3 text-primary mt-1"></i>

<h4 class="font-itc"><?php echo __("Buy Credit","premiumpress"); ?></h4>

<p class="opacity-5 font-itc"><?php echo __("Top-up your account and save money with our credit system.","premiumpress"); ?></p>

<hr />

<div id="ajax_overdue_payment"></div>

  <?php $i=1; while($i < 8){ 
  
  
  	if(_ppt(array('credit', $i .'a')) == ""){ $i++; continue; }
  
  ?>
  
  
<div class="row buycredit">

    <div class="col-md-8">
    
    <div class="small opacity-5 font-itc"><?php echo __("You Pay","premiumpress"); ?></div>
    
    <h4 class="font-itc <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo _ppt(array('credit', $i .'a')); ?></h4>
    
    </div>
    
   <!-- <div class="col-md-4">
    
     <div class="small opacity-5 font-itc"><?php echo __("You Get","premiumpress"); ?></div> 
    
    <h4 class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo _ppt(array('credit', $i .'b')); ?></h4>
  
    
    </div> -->
    
    <div class="col-md-4">
    
    
     <button class="btn btn-danger float-right btn-xl" onclick="ajax_load_credit_payment('#ppt_creditdata_<?php echo $i; ?>')"><?php echo __("Buy Now","premiumpress"); ?></button>
    
   <input type="hidden" id="ppt_creditdata_<?php echo $i; ?>" value="<?php 
 
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => _ppt(array('credit', $i .'a')), 
 
   	"order_id" => "CREDIT-".$userdata->ID."-NEW-".$i."-".rand(),
   	 
   	"description" => __("Credit Purchase","premiumpress"),
   	
   	"recurring" => 0,
   	
   	"couponcode" => 0,
   
   								
   ) ); 
    		
   ?>" />
    
    </div>


<div class="col-12">

<hr />
</div>

</div>  
  
  
  <?php $i++; } ?>


</div>  
  
<script> 
   
   function ajax_load_credit_payment(div){
   
   
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   			details:jQuery(div).val(),
           },
           success: function(response) {	
	 		
			jQuery(".buycredit").hide();
   			jQuery('#ajax_overdue_payment').html(response);
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>