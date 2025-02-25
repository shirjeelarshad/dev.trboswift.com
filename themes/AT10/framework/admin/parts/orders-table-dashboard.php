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
 
 
?>


  
<div id="ajax_response_msg"></div>

<textarea style="width:100%; height:100px;display:none;" id="_filter_data"></textarea>
<input type="hidden" name="cardtype" value="admin-order" class="customfilter"  data-type="select" data-key="cardtype" />
<input type="hidden" name="sort" class="customfilter" id="filter-sortby-main"  data-type="select" data-key="sortby" />
<input type="hidden" class="customfilter" name="perpage" data-type="select" data-key="perpage" value="30">
<div class="row">
  <div class="col">
   
      <?php _ppt_template('framework/admin/parts/orders-table-sortby' ); ?>
      <div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="actionsbox">
        <?php _ppt_template('framework/admin/parts/order-table-actions' ); ?>
      </div>
      <div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="filterssidebox">
        <?php // _ppt_template('framework/admin/parts/order-table-filters' ); ?>
      </div>
      <div class="bg-white">
        <div class="premiumpress_table members">
          <table class="table table-striped table-hover">
            <thead>
              <tr style="margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;">
                <th><input type="checkbox" onclick="doselectall();" /></th>
                <th><?php echo __("Amount","premiumpress"); ?></th>
                <th style="width:150px;"><?php echo __("Date","premiumpress"); ?> </th>
                <th class="text-center"><?php echo __("Type","premiumpress"); ?> </th>
                <th class="text-center" style="width:150px;"><?php echo __("Status","premiumpress"); ?></th>
                <th class="text-center"><?php echo __("Action","premiumpress"); ?></th>
              </tr>
            </thead>
            <tbody id="ajax-search-output">
            </tbody>
          </table>
          <hr />
          <div class="d-flex justify-content-between align-items-center py-2 letter-spacing-1">
            <div class="text-muted small"> <span class="ajax-search-found">100</span> <?php echo __("results","premiumpress"); ?> - <?php echo __("page","premiumpress"); ?> <span class="ajax-search-page">1</span> of <span class="ajax-search-pageof">10</span> </div>
            <div class="ajax-search-pagenav"></div>
          </div>
        </div>
      </div>
  </div>
</div>
<script>


function ajax_massupdate_listings(){

	var ids = [];
	var cats = [];
	
	// DELETE ALL
	var delall = false; 
	if(jQuery('#delete-seleced').is(':checked')){
		delall = 1;
	}
	
 	
	jQuery('.checkbox1').each(function(key, value) { //loop through each checkbox
	 
		if(this.checked) { 
		
			ids.push(this.value);
		} 
	
	}); 

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "mass_update_orders",
			pids: ids,
			cat: jQuery('#mass_os').val(),
			deleteall: delall,
        },
        success: function(response) {
					
			if(response.status == "ok"){
					
				// CHANGE ICON
				_filter_update();					 
  		 	
			}else{		
				
				// CHANGE ICON
				jQuery('#ajax_mass_update_msg').html("Update Failed");					 
  		 		
			} 
			
				
        },
        error: function(e) {
            console.log(e)
        }
    });

} // end function


jQuery(document).ready(function() {
_filter_update();
}); 

  

function ajax_delete_order(id){


// RESET
jQuery('#ajax_response_msg').html("");	

if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")) {

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "order_delete",
			uid: id,
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#postid-'+id).hide();	
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("Order deleted successfully");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });

}
	
}// end are you sure

 
function ajax_testing_orders_add(){

// RESET
jQuery('#ajax_response_msg').html("");	

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "testing_order_add",
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("Orders added successfully");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to add.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure


</script>