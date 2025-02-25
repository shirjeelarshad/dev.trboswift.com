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

    
     <button type="button"  onclick="jQuery('#UpdateModal').modal('show');"  class="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "float-left"; }else{ echo "float-right"; } ?> btn btn-admin"><i class="fa fa-plus"></i> <?php echo __("Add Banner","premiumpress"); ?></button>
    
     
    <h3 class="mt-4"><span class="ajax-search-found1"></span> <?php echo __("Banners","premiumpress"); ?></h3>
    
     <a href="hhttps://www.youtube.com/watch?v=jXU5EW_0di0" class="small popup-yt"><i class="fa fa-play-circle"></i> <?php echo __("watch video","premiumpress"); ?></a>
    

</div> 



<textarea style="width:100%; height:100px;display:none;" id="_filter_data1"></textarea>

<input type="hidden" name="cardtype" value="admin-banner" class="customfilter1"  data-type="select" data-key="cardtype" />
 
 
<div class="row">
 
<div class="col"> 
 
 
<div class="card card-admin p-4">  

<div id="ajax_response_msg1"></div>  


    <div class="row mb-3">   
     
        <div class="col-lg-3 hide-mobile hide-ipad">  
        
        <div class="mt-n1">
        
        <!--<a href="javascript:void(0);" class="btn btn-admin btn-sm color3" onclick="showfilersbar();"><i class="fa fa-filter"></i> <?php echo __("Show Filters","premiumpress"); ?> </a>-->
      
        </div>
                 
        </div>
        
        
       <div class="col-lg-9 text-lg-right">
    
        <div class="filter_sortby t1">
    
        <!--<a href="javascript:void(0);" class="active" data-key="id"><span><?php echo __("Latest","premiumpress"); ?><i class="ml-2 fa fa-sort-amount-up-alt"></i></span></a>-->
        
    	</div>
        
         <input type="hidden" name="sort" class="customfilter1" id="filter-sortby-main"  data-type="select" data-key="sortby" />
        
         <input type="hidden" class="customfilter1" name="perpage" data-type="select" data-key="perpage" value="30">
    
    </div> 

        
    </div>
    
    
<div class="col-md-12 px-0 bg-light border-top"  style="display:none;" id="actionsbox">

<?php _ppt_template('framework/admin/parts/advertising-table-actions' ); ?>
 
</div>    
    
<div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="filterssidebox">


<?php _ppt_template('framework/admin/parts/advertising-table-filters' ); ?>

  
</div>
    
    
	<div class="bg-white">    
    <div class="premiumpress_table members">
     
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>  
                        	                    
                            <th ><?php echo __("Banner","premiumpress"); ?></th>
                            <th class="text-center"><?php echo __("Dimensions","premiumpress"); ?></th>
                             
                            <th class="text-center"><?php echo __("Action","premiumpress"); ?></th>
                        </tr>
                    </thead>
                    <tbody id="ajax-search-output1"></tbody>                
                </table>
        
                <hr />
                
                <div class="d-flex justify-content-between align-items-center py-2 letter-spacing-1">

                <div class="text-muted small">
                <span class="ajax-search-found">100</span> <?php echo __("results","premiumpress"); ?> - 
                page <span class="ajax-search-page">1</span> of <span class="ajax-search-pageof">10</span>
                </div>
               
                <div class="ajax-search-pagenav"></div>
                
            	</div> 
                
                 
    </div>
	</div>
</div>
</div>
</div>
<script>

 


jQuery(document).ready(function() {

 
	// CLEAR
	jQuery('#_filter_data1').val('');
	
	// make titles
	var i = 1;
	jQuery('.customfilter1').each(function(index,item){
										  
		var id = this.id;	
		 
		canContinue = false; 
		if(jQuery(this).data('type') == "checkbox" && jQuery(this).prop("checked") == true ){	
			canContinue = true;
			value = jQuery(this).data('value'); 
		}
		
		if(jQuery(this).data('type') == "text" && jQuery(this).val() != "" ){
			canContinue = true;
			value = jQuery(this).val(); 
		}
		
		if(jQuery(this).data('type') == "select" && jQuery(this).val() != "" ){
			canContinue = true;
			value = jQuery(this).val(); 
		}		
		
		if(canContinue){
			
			key = jQuery(this).data('key'); 						
		
			jQuery('#_filter_data1').val(jQuery('#_filter_data1').val()+"["+key+':'+value+"]")
		}  
		 	
	  
		  i++;
	 }); 
	 
	_filter_newsearch1();
 

}); 


function _filter_newsearch1(){
	 
	
	if(jQuery('#ajax-search-output').length > 0){
		
	jQuery('#ajax-search-output').html('<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
 
	}
	
	
	jQuery('#ajax-navbar-showhide').hide();
	
	jQuery.ajax({
        type: "POST",
        url: ajax_site_url,	
		dataType: 'json',	
		data: {
            search_action: "search",
			search_data: jQuery('#_filter_data1').val(),
        },
        success: function(response) {
 
			
			if(response.status == "ok"){
			
			
				//setTimeout(function(){
				 
				//console.log('Execution Time: ' + response.time);
				
				// SPONSORED SECTIONS
				if(response.sponsor == ""){
					jQuery('#ajax-sponsor-output1').html('');
				}else{
					jQuery('#ajax-sponsor-output1').html(response.sponsor);	
				}
				
			  	
				// LEAVE MESSAGE	
				
				jQuery('#ajax-search-output1').html(response.output);	
				jQuery('.ajax-search-pagenav1').html(response.pagenav);
				jQuery('.ajax-search-found1').html(response.total);	
				jQuery('.ajax-search-page1').html(response.page);
				jQuery('.ajax-search-pageof1').html(response.pageof);
				
				_filter_counterupdate();
				
				jQuery('#ajax-navbar-showhide').show();
				
				//},500);
				 
  		 	
			}else{			
				jQuery('#ajax-search-output').html("Error trying to get results.");			
			}			
        },
        error: function(e) {
           console.log('error getting search results');
        }
    });
	
}

function ajax_banner_delete(id){


if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")) {
		   
		


// RESET
jQuery('#ajax_response_msg').html("");	
 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "sellspace_delete",
			delid: id,
        },
        success: function(response) {
	 
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#postid-'+id).hide();	
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg1').html("Banner Deleted successfully");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg1').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            alert("error gere "+e)
        }
    });
	
}
	
}// end are you sure  

</script>