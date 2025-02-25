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
<!-- <i class="fa fa-user-plus"></i> -->
 
    <h5 class="mt-4"> <?php echo __("Manage Users","premiumpress"); ?></h5>
	
 
</div> 

 

<textarea style="width:100%; height:100px;display:none;" id="_filter_data"></textarea>

<input type="hidden" name="cardtype" value="admin-user" class="customfilter"  data-type="select" data-key="cardtype" /> 

<div class="col-md-12 px-0 row justify-content-between align-items-center bg-light" id="actionsbox">

<div class="col-md row m-0 users-filter-checkbox align-items-center">  

<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="online" data-value="1" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Online","premiumpress") ?> 
  
</label> 

<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="verify" data-value="1" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Verified","premiumpress") ?> 
  
</label>  

<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="verify" data-value="0" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Pending","premiumpress") ?> 
  
</label> 
    
   

        
        </div>

        <div class="position-relative">
        <input type="text" class="form-control rounded-pill customfilter" name="username" data-type="text" data-key="username"  placeholder="<?php echo __("Username..","premiumpress"); ?>" value="<?php if(isset($_GET['username'])){ echo esc_attr($_GET['username']); } ?>">

        <button class="btn position-absolute text-muted" style="top:0px; right:0px;" type="button" onclick="_filter_update()" ><i class="fa fa-search"></i></button>

        </div> 


        <div class="col-md d-flex justify-content-between align-items-center">
           <span class="font-10">Showing <span class="ajax-search-found"></span> Active Users</span>

            <button type="button" onclick="newFinanceAccountModal();"  class="btn btn-secondary rounded-pill font-12 px-4 "><?php echo __("Add User","premiumpress"); ?></button>
        </div>
     
 
</div>  

<div class="row">
 
<div class="col"> 


<div class="card p-3 card-admin bg-transparent border-0">  

    <div class="row mb-3">   
     
       
        
        
       <div class="col-lg-9 text-lg-right">
    
         <input type="hidden" name="sort" class="customfilter" id="filter-sortby-main"  data-type="select" data-key="sortby" />
        
         <input type="hidden" class="customfilter" name="perpage" data-type="select" data-key="perpage" value="10">
    
        </div> 

<?php if(in_array(THEME_KEY, array("pj","jb","ex")) ){?>
    <div class="col-12">
    <div class="filter_sortby t1 text-lg-right mt-2">
     
     <a href="javascript:void(0);" data-key="user_fr"><span><i class="fal fa-user mr-2"></i> <?php  if(THEME_KEY == "ex"){ echo __("User","premiumpress");  }elseif(THEME_KEY == "jb"){ echo __("Job Seeker","premiumpress"); }else{ echo __("Freelancer","premiumpress"); } ?><i></i></span></a> 
      
      <a href="javascript:void(0);" data-key="user_em"><span><i class="fa fa-user-tie mr-2"></i> <?php if(THEME_KEY == "ex"){  echo __("Teacher","premiumpress"); }else{  echo __("Employers","premiumpress"); } ?><i></i></span></a>                 
    </div>
    </div>
    
<?php }elseif( in_array(THEME_KEY, array("es","jb","mj","ll"))){ 
	
	if(THEME_KEY == "mj"){
	global $CORE_MICROJOBS;	
	$accountTypes = $CORE_MICROJOBS->_user_types();
	}elseif(THEME_KEY == "es"){
	global $CORE_ESCORTTHEME;	
	$accountTypes = $CORE_ESCORTTHEME->_escort_types();
	}elseif(THEME_KEY == "jb"){
	global $CORE_JOBS;	
	$accountTypes = $CORE_JOBS->_user_types();	
	}elseif(THEME_KEY == "ll"){
	global $CORE_LEARNING;	
	$accountTypes = $CORE_LEARNING->_user_types();	
	}
	
	
	?>
    <div class="col-12">
    <div class="filter_sortby t1 text-lg-right mt-2">
     
     <?php foreach($accountTypes as $k => $g){ ?>             
               
    
      
      <a href="javascript:void(0);" data-key="<?php echo $k; ?>"><span><?php echo $g['name']; ?><i></i></span></a> 
      
      <?php } ?>                  
    </div>
    </div>
 
<?php } ?>
      

        
    </div>
 
    
  
    
<div class="col-md-12 px-0 bg-light border-top" style="display:none;" id="filterssidebox">

<?php _ppt_template('framework/admin/parts/user-table-filters' ); ?>
  
</div>
    
    
	<div class="bg-white">    
    <div class="premiumpress_table members">
     
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="bg-secondary text-white font-12">                       
                           
                            <th><?php echo __("Name","premiumpress"); ?></th>						
                            <th><?php echo __("Role","premiumpress"); ?></th>
                            <th ><?php echo __("Phone","premiumpress"); ?></th>
                            <th><?php echo __("Email","premiumpress"); ?></th>
                        </tr>
                    </thead>
                    <tbody id="ajax-search-output"></tbody>                
                </table>
                
                                <hr />
                
                <div class="d-flex justify-content-between align-items-center p-2 letter-spacing-1">

                <div class="text-muted small">
                <span class="ajax-search-found">100</span> <?php echo __("results","premiumpress"); ?> - 
                <?php echo __("page","premiumpress"); ?> <span class="ajax-search-page">1</span> of <span class="ajax-search-pageof">10</span>
                </div>
               
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

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "mass_update_users",
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


function ajax_user_verify(id,divid){
 
	 var self = jQuery(this);
	 
	  
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "user_verify",
			uid: id,
        },
        success: function(response) {
					
			if(response.current == "yes"){
				
				jQuery("#"+divid+' i').removeClass('text-danger').addClass('text-success');					 
  		 	
			}else{
							
				jQuery("#"+divid+' i').removeClass('text-success').addClass('text-danger');
			} 
			
			jQuery('#ajax_response_msg').html("User Updated");
					
        },
        error: function(e) {
            console.log(e)
        }
    });
}

 

function ajax_user_delete(id){

// RESET

jQuery('#ajax_response_msg').html("");	
 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "user_delete",
			pid: id,
        },
        success: function(response) {
	 
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#postid-'+id).hide();	
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("<?php echo __("User Deleted successfully","premiumpress"); ?>");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            alert("error gere "+e)
        }
    });
	
}// end are you sure

</script>



<style>
.table td {
    color: #222222 !important;
}

.users-filter-checkbox .custom-control-label {
    display: none;
}

</style>