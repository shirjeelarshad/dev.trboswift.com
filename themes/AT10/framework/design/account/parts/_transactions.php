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

global $settings;

if(_ppt(array('user','orders')) == 1){

?>
 
<div class="card shadow-sm border-0 hide-mobile">
  <div class="card-header bg-white">
    <h6><?php echo __("Recent Transactions","premiumpress"); ?></h6>
    <p><span id="totalordersfound_dash">0</span> <?php echo __("orders found","premiumpress"); ?></p>
  </div>
  <div class="card-body p-0">
    <div class="bg-light text-center p-3 m-4 text-muted noorders" style="display:none;">
      <div><i class="fal fa-frown mr-2"></i> <?php echo __("No Orders Found","premiumpress"); ?></div>
    </div>
    <div class="overflow-auto">
      <table class="table  small table-orders" id="dash_orders_table">
      </table>
    </div>
  </div>
</div>
<script>
jQuery(document).ready(function(){ 

 	
	
	if (jQuery('.table-orders').length){
	
 	
	jQuery('#totalordersfound_dash').html(jQuery('#totalordersfound').html());
	
	jQuery('.table-orders tr').each(function() {
	   
		var rowFromTable1 = jQuery(this);
	 
		var clonedRowFromTable1 = rowFromTable1.clone();
		 
		jQuery('#dash_orders_table').append( clonedRowFromTable1 );
		
	 });
	 
	 jQuery('#dash_orders_table tr').hide();
	 jQuery('#dash_orders_table tr:nth-child(0)').show();
	 jQuery('#dash_orders_table tr:nth-child(1)').show();
	 jQuery('#dash_orders_table tr:nth-child(2)').show();
	 jQuery('#dash_orders_table tr:nth-child(3)').show();
	 jQuery('#dash_orders_table tr:nth-child(4)').show();
	 jQuery('#dash_orders_table tr:nth-child(5)').show();
	 jQuery('#dash_orders_table tr:nth-child(6)').show();
	 jQuery('#dash_orders_table tr:nth-child(7)').show();
	 
	} else {
	
		jQuery('.noorders').show();
	}




});

</script>
<?php } ?>