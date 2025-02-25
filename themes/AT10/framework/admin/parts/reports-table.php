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

global $wpdb, $CORE; 


?>

<div class="clearfix mb-4">
  <button type="button" onclick="jQuery('#add-tab').tab('show');"  class="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "float-left"; }else{ echo "float-right"; } ?> btn btn-admin"> <span class="btn-label"><i class="fa fa-plus"></i></span> <?php echo __("Add Log","premiumpress"); ?></button>
  <h4 class="mt-4"> <span class="ajax-search-found"></span> <?php echo __("Logs Found","premiumpress"); ?></h4>
  <a href="javascript:void(0);" onclick="ajax_delete_all_logs();" class="btn btn-system btn-sm"><i class="fa fa-trash"></i> Delete all logs</a> </div>
<div class="row">
  <div class="col">
    <div class="card card-admin p-4">
      <div class="row mb-3">
        <div class="col">
          <div class="mt-n1"> <a href="javascript:void(0);" class="btn btn-system btn-md hide-mobile" onclick="showfilersbar();"><i class="fa fa-filter"></i> <?php echo __("Show Filters","premiumpress"); ?> </a> </div>
        </div>
        <div class="col-md-8 text-right">
          <div class="filter_sortby t1"> <a href="javascript:void(0);" class="active" data-key="date"><span><?php echo __("Dated","premiumpress"); ?><i class="ml-2 fa fa-sort-amount-up-alt"></i></span></a> </div>
          <input type="hidden" name="sort" class="customfilter" id="filter-sortby-main"  data-type="select" data-key="sortby" />
          <input type="hidden" class="customfilter" name="perpage" data-type="select" data-key="perpage" value="30">
          
          
           
        </div>
      </div>
      <div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="actionsbox">
        <?php _ppt_template('framework/admin/parts/reports-table-actions' ); ?>
      </div>
      <div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="filterssidebox">
        <?php _ppt_template('framework/admin/parts/reports-table-filters' ); ?>
      </div>
      <div class="premiumpress_table reports-table">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th><input type="checkbox" onclick="doselectall();" /></th>
              <th><?php echo __("User","premiumpress"); ?></th>
              <th><?php echo __("Date","premiumpress"); ?></th>
              <th><?php echo __("Type","premiumpress"); ?></th>
              <th><?php echo __("Action","premiumpress"); ?></th>
            </tr>
          </thead>
          <tbody id="ajax-search-output">
          </tbody>
        </table>
        <hr />
        <div class="d-flex justify-content-between align-items-center py-2 letter-spacing-1">
          <div class="text-muted small"> <span class="ajax-search-found">100</span> <?php echo __("results","premiumpress"); ?> - 
            page <span class="ajax-search-page">1</span> of <span class="ajax-search-pageof">10</span> </div>
          <div class="ajax-search-pagenav"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>


<textarea style="width:100%;; height:100px;display:none;" id="_filter_data"></textarea>
<input type="hidden" name="cardtype" value="admin-log" class="customfilter"  data-type="select" data-key="cardtype" />
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
            admin_action: "mass_update_logs",
			pids: ids,
			//cat: jQuery('#mass-cat').val(),
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


function ajax_delete_all_logs(){

// RESET
jQuery('#ajax_response_msg').html("");	

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "log_delete_all",		
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("Log deleted successfully");
				
				_filter_update();
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure


function ajax_delete_log(id){

// RESET
jQuery('#ajax_response_msg').html("");	

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "log_delete",
			uid: id,
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#postid-'+id).hide();	
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("Log deleted successfully");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure



</script>
