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

<div class="clearfix mb-4">
  
  
  <a href="admin.php?page=listings&addnew=1"  class="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "float-left"; }else{ echo "float-right"; } ?> btn btn-admin"><i class="fa fa-plus"></i> <?php echo __("Add","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","1"); ?></a>
 
 <?php if(THEME_KEY == "ph"){ ?>
  <a href="admin.php?page=massimport"  class="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "float-left"; }else{ echo "float-right"; } ?> btn btn-admin mr-2  color2"><?php echo __("Mass Import","premiumpress"); ?></a>
  <?php } ?>
 
  <h4 class="mt-4"><span class="ajax-search-found"></span> <?php echo $CORE->LAYOUT("captions","2"); ?> </h4>
   <a href="edit-tags.php?taxonomy=listing&post_type=listing_type" class="mr-3 small" ><i class="fa fa-crop-alt"></i> <?php echo __("Manage Categories","premiumpress"); ?></a>
  <a href="hhttps://www.youtube.com/watch?v=jXU5EW_0di0" class="popup-yt small"><i class="fa fa-play-circle"></i> <?php echo __("watch video","premiumpress"); ?></a>
   </div>
<textarea style="width:100%; height:100px;display:none;" id="_filter_data"></textarea>
<input type="hidden" name="cardtype" value="admin-listing" class="customfilter"  data-type="select" data-key="cardtype" />
 <input type="hidden" name="sort" class="customfilter" id="filter-sortby-main"  data-type="select" data-key="sortby" />
  <input type="hidden" class="customfilter" name="perpage" data-type="select" data-key="perpage" value="30">
<div class="row">
  <div class="col"> <span id="ajax_response_msg"></span>
    <div class="card card-admin p-4">
    


  <?php _ppt_template('framework/admin/parts/listings-table-sortby' ); ?>
    
      <div class="col-md-12 px-0 bg-light border-top"  style="display:none;" id="actionsbox">
        <?php _ppt_template('framework/admin/parts/listings-table-actions' ); ?>
      </div>
      <div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="filterssidebox">
        <?php _ppt_template('framework/admin/parts/listings-table-filters' ); ?>
      </div>
      <div class="bg-white">
       
        <div class="premiumpress_table members overflow-auto">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th><input type="checkbox" onclick="doselectall();" /></th>
                <th><?php echo __("Title","premiumpress"); ?></th>
              
              
                <?php if(in_array(THEME_KEY, array("ct","dl"))){ ?>
                <th class="text-center"><?php echo __("Offers","premiumpress"); ?></th>
                <?php }elseif(in_array(THEME_KEY, array("jb"))){ ?>
                <th class="text-center"><?php echo __("Applicants","premiumpress"); ?></th>
                 <?php }elseif(in_array(THEME_KEY, array("mj"))){ ?>
                <th class="text-center"><?php echo __("Orders","premiumpress"); ?></th>
                
                <?php }elseif(in_array(THEME_KEY, array("cp"))){ ?>
                
                <th class="text-center"><?php echo __("Verified","premiumpress"); ?></th>
                
                <?php }elseif(in_array(THEME_KEY, array("at"))){ ?>
                  
                <th class="text-center"><?php echo __("Bids","premiumpress"); ?></th>
                
                
                  <?php }elseif(in_array(THEME_KEY, array("dt"))){ ?>
                  
                <th class="text-center"><?php echo __("Leads","premiumpress"); ?> <i class="fal fa-info-circle" data-toggle="tooltip" data-title="<?php echo __("The num of times the contact form has been used on the listing page.","premiumpress"); ?>"></i> </th>
               
                
               
				<?php } ?>
                
                
                
                
                
                <th class="text-center">  <?php echo __("Views","premiumpress"); ?> </th>
                
                
                <?php if(in_array(THEME_KEY, array("dt")) && _ppt(array('design', 'single-offers'))  == '1' ){ ?>
				
				<th class="text-center"><?php echo __("Claimed","premiumpress"); ?></th>
                
                 <?php }elseif(in_array(THEME_KEY, array("dt"))  ){ ?>
				
                <th class="text-center"><?php echo __("City","premiumpress"); ?></th>
                
				<?php }elseif(in_array(THEME_KEY, array("vt"))){ ?>
                
                <th class="text-center"><?php  if(in_array(_ppt(array('lst', 'vt_levels')), array("","1"))){ echo __("Level","premiumpress"); } ?></th>
                
                <?php }elseif(in_array(THEME_KEY, array("da"))){ ?>
               
               <th class="text-center"><?php echo __("Age","premiumpress"); ?></th>
              
               
               
               <?php }elseif(in_array(THEME_KEY, array("cp"))){ ?>
               
               <th class="text-center"><?php echo __("Times Used","premiumpress"); ?></th>
              
              <?php }elseif(in_array(THEME_KEY, array("ph"))){ ?>
               
               <th class="text-center"><?php echo __("Downloads","premiumpress"); ?></th>
              
               
                <?php }else{ ?>
                
                <th class="text-center"><?php echo __("Price","premiumpress"); ?></th>
                
                <?php } ?>
                
                
                <th class="text-center"><?php echo __("Status","premiumpress"); ?></th>
                <th class="text-center" style="width:150px;"><?php echo __("Action","premiumpress"); ?></th>
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
	
	var mf = 0;
	if(jQuery('#mass_addon_featured').length > 0){
		if(jQuery('#mass_addon_featured').is(':checked')){
		mf = 1;
		}
	}
	
	var mh = 0;
	if(jQuery('#mass_addon_homepage').length > 0){
		if(jQuery('#mass_addon_homepage').is(':checked')){
		mh = 1;
		}
	}
		 
	var ms = 0;
	if(jQuery('#mass_addon_sponsored').length > 0){
		if(jQuery('#mass_addon_sponsored').is(':checked')){
		ms = 1;
		}
	}

	// TURN OFF
	var off_mf = 0;
	if(jQuery('#mass_off_addon_featured').length > 0){
		if(jQuery('#mass_off_addon_featured').is(':checked')){
		off_mf = 1;
		}
	}
	
	var off_mh = 0;
	if(jQuery('#mass_off_addon_homepage').length > 0){
		if(jQuery('#mass_off_addon_homepage').is(':checked')){
		off_mh = 1;
		}
	}
		 
	var off_ms = 0;
	if(jQuery('#mass_off_addon_sponsored').length > 0){
		if(jQuery('#mass_off_addon_sponsored').is(':checked')){
		off_ms = 1;
		}
	}

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "mass_update_listings",
			pids: ids,
			cat: jQuery('#mass-cat').val(),			
			pak: jQuery('#mass-pak').val(),
			
			addon_featured: mf,
			addon_homepage: mh,
			addon_sponsored: ms,
			
			addon_off_featured: off_mf,
			addon_off_homepage: off_mh,
			addon_off_sponsored: off_ms,
			
			
			status: jQuery('#mass-status').val(),
			//deleteall: delall,
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

jQuery('.makefeatured').on('click', function() {		

var self = jQuery(this);
var id = this.id;	
jQuery('.tabinner').val(id);
			

});
 
function ajax_featured_listing(id,divid,t){
 
	 var self = jQuery(this);
	 
	  
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "listing_featured",
			pid: id,
			type: t,
        },
        success: function(response) {
					
			if(response.current == "yes"){
				
				jQuery("#"+divid+' i').addClass('text-warning');					 
  		 	
			}else{
							
				jQuery("#"+divid+' i').removeClass('text-warning');
			} 
			  
			notify({
					type: "warning", //alert | success | error | warning | info
					title: "Success",
					position: {
					 x: "right", //right | left | center
					 y: "top" //top | bottom | center
					},
					icon: '<i class="fal fa-check"></i>',
					message: "<?php echo __("Listing Updated Successfully","premiumpress"); ?>"
			});
			
					
        },
        error: function(e) {
            console.log(e)
        }
    });
}

function ajax_listing_delete(id){


if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")) {
		   
		


// RESET
jQuery('#ajax_response_msg').html("");	
 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "listing_delete",
			pid: id,
        },
        success: function(response) {	 
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#postid-'+id).hide();
				
				notify({
					type: "warning", //alert | success | error | warning | info
					title: "Success",
					position: {
					 x: "right", //right | left | center
					 y: "top" //top | bottom | center
					},
					icon: '<i class="fal fa-check"></i>',
					message: "Listing Deleted successfully"
				});
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            alert("error gere "+e)
        }
    });
	
}
	
}// end are you sure

</script>
