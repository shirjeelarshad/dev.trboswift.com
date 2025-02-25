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

$addons = $CORE->PACKAGE("get_packages_addons", array() );

 
if(!empty($addons )){

// CHECK NOT HIDDEN
$canShow = false;
foreach($addons as $a){ 

	if( _ppt(array('lst', $a['key'].'_enable')) == '1' || is_admin() ){ $canShow = true; }

}
if($canShow){
?>

<div id="ajax_addon_payment_form"></div>
<div class="card shadow-sm bg-light mt-4">
  <div class="card-header text-muted font-weight-bold"> 
  
  <?php if(is_admin()){ ?>
  <a href="admin.php?page=listingsetup&lefttab=packages-tab" class="float-right small btn btn-sm btn-system"><?php echo __("manage","premiumpress"); ?></a>
  <?php } ?>
  
  <?php
  
  if(is_admin()){
  echo __("Add-ons","premiumpress");
  }else{
   echo __("Make your ad stand out!","premiumpress"); 
   }
   ?> 
  
  
  
  </div>  
  <div class="card-body bg-white">
    <p class="text-muted">
	
	<?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Promote this %s today!","premiumpress")); ?>
    
    </p>
    <?php foreach($addons as $a){  if( _ppt(array('lst', $a['key'].'_enable')) != '1'  && !is_admin()){ continue; } ?>
    <div class="row border-top pt-3 mt-3 <?php echo $a['key']; ?>">
      
      <div class="col-1">
        <label class="custom-control custom-checkbox">
        <input type="checkbox"  value="1" class="custom-control-input" id="<?php echo $a['key']; ?>check" 
	
        <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], str_replace("addon_","",$a['key']), true) == 1){ echo "checked=checked"; } ?>
        
		 onclick="<?php if(isset($_GET['eid']) && !is_admin() ){ ?>jQuery('.<?php echo $a['key']; ?> .paymentform').toggle();<?php } ?> ChekME('#<?php echo $a['key']; ?>');">
        
        
        <input type="hidden" name="<?php echo $a['key']; ?>" id="<?php echo $a['key']; ?>add" value="<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], str_replace("addon_","",$a['key']), true) == 1){ echo 1; }else{ echo 0; } ?>" class="form-control">
        
        <span class="custom-control-label">&nbsp;</span> </label>
      </div>
    
      
      <div class="col-md-10"> <span class="<?php echo $a['color']; ?> small"><?php echo $a['name']; ?></span>
        <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], str_replace("addon_","",$a['key']), true) == 1){ ?>
        <span class="text-success small float-right"><i class="fa fa-check"></i> <?php echo __("active","premiumpress"); ?></span> </div>
      <?php }else{ ?>
      
      <?php if( _ppt(array('lst', $a['key'].'_enable')) == '1'){ ?>
      <span class="float-right addonprice">+ <?php echo hook_price(_ppt(array('lst', $a['key'].'_price'))); ?> </span>
      <?php } ?>
      
       <span class="text-success small includedtext float-right" style="display:none"><i class="fa fa-check mr-2"></i><?php echo __("included","premiumpress"); ?></span> </div>
   
   
    <?php } ?>
    <div class="col-md-12">
      <div class="small text-muted mt-2"><?php echo $a['desc']; ?></div>
    </div>
    <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
    
	<?php if(get_post_meta($_GET['eid'], str_replace("addon_","",$a['key']), true) == 1){ ?>
   
    <?php }else{ ?>
    
    <div class="col-md-12 paymentform" style="display:none;">
      <div class="p-3 bg-light text-center"> <a href="javascript:void(0);" onclick="ajax_load_addon_payment('#<?php echo $a['key']; ?><?php echo esc_attr($_GET['eid']); ?>','<?php echo _ppt(array('lst', $a['key'].'_price')); ?>')" class="btn btn-dark btn-sm text-light"><?php echo __("Upgrade Now","premiumpress"); ?></a> </div>
    </div>
    <input type="hidden" id="<?php echo $a['key']; ?><?php echo esc_attr($_GET['eid']); ?>" value="<?php 

 
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
   	"amount" => _ppt(array('lst', $a['key'].'_price')),    	
   	"order_id" => "UPGRADE-".$_GET['eid']."-".str_replace("addon_","",$a['key']),  	 
   	"description" => $a['name']." ".__(" upgrade for ","premiumpress")." ".get_the_title($_GET['eid']),   	
   	"recurring" => 0,   	
   	"couponcode" => 0, 
	"full" => 1,     								
   ) ); 
    		
   ?>" />
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
</div>
</div>
<?php } ?>
<script> 
   
   function ajax_load_addon_payment(data, pp){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
			   //"smallform": 1,
   			details:jQuery(data).val(),
           },
           success: function(response) {			
   			//jQuery('#ajax_addon_payment_form').html(response);
			
			
			jQuery(".payment-modal-wrap").fadeIn(400); 
		 
		    jQuery(".payment-modal-container h3").text(pp); 			 
			 
   			jQuery('#ajax-payment-form').html(response);	
			
			UpdatePrices();	
			
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>
<script>
		function ChekME(div){
		 
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>
<?php } ?>
