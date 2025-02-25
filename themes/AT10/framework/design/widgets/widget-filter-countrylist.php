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


if(_ppt(array('maps','enable')) == 1){ 

 
?>

<div class="card card-filter">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_country" aria-expanded="true" >
    <h5 class="card-title"><?php echo __("Location","premiumpress"); ?></h5>
    </a>
    <div <?php if(!$CORE->isMobileDevice()){ ?>class="filter-content collapse" id="collapse_country"<?php }else{ ?> class="pt-2"<?php } ?>>
      <?php    
	  
	  
	  $selected_country = "";
	  if(isset($_GET['country'])){
	  $selected_country  = trim($_GET['country']);
	  }
	 
	  
		  $SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a INNER JOIN ".$wpdb->postmeta." AS t ON ( a.meta_key = 'map-country' AND t.post_id = a.post_id ) LIMIT 60";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				if(count($results) > 0 && !empty($results) ){
				
				
				
				$in_array = array(); $statesArray = array();
					foreach ($results as $val){			
						
						$state = $val->meta_value;						
						if(!in_array($state,$in_array)){						
							
							// ADD TO ARRAY
							$in_array[] = $state;
							$statesArray[] .= $state;
						}// if in array					
					} // end while	
					
					// NOW RE-ORDER AND DISPLAY
					asort($statesArray);
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							
							
							$name = $state;			
							
							
							if(isset($GLOBALS['core_country_list'][$state])){
							
								$name = $GLOBALS['core_country_list'][$state];
								
							}else{
								foreach($GLOBALS['core_country_list'] as $country){
								
									if($country == $state){
									
										$name = $country;
									
									}
								}
							
							}
							
							?>						 
                            
                            
       <label class="custom-control custom-checkbox">
       
      <input type="checkbox"  value="<?php echo trim($state); ?>" name="country" class="custom-control-input customfilter ccche" onclick="_filter_update(); ajax_update_citylist();" <?php if($selected_country == trim($state)){ echo "checked=checked"; } ?> data-key="country" data-value="<?php echo trim($state); ?>" data-old-value="" data-type="checkbox">
  
  
  
      <div class="custom-control-label " data-countkey="catid-"> 
	  
	  <a href="javascript:void(0)" class="text-dark" style="text-decoration:none;">
	  <?php echo $name; ?>
       
       </a>
     
     
      
      </div>
      
      </label>
      
      
                            
<?php  }  ?> 


       <input type="hidden"  value="" id="user-city"  />
      <select class="customfilter form-control mt-3" id="filter-city" style="display:none;" name="city" data-type="select" data-key="city" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>>
      </select>
       
      <script type="application/javascript">
            jQuery(document).ready(function(){ 
             
				
				<?php if(isset($_GET['country']) && strlen($_GET['country']) > 1){ ?>
				 ajax_update_citylist();	
				<?php } ?>
            	  
            });
            
            function ajax_update_citylist(){
            
            	// COUNTRY VALUE
            	var countryid = "";
				jQuery('.ccche').each(function(key, value) { //loop through each checkbox
					 
					if(this.checked) { 
						
							countryid = this.value;
					} 					
				}); 
				 
             
            	// SET VALUE
            	jQuery('#user-city').val(countryid);
            
                jQuery.ajax({
                    type: "POST",
                    url: ajax_site_url,	 	
            		data: {
                        action: "get_location_states",
            			country_id: countryid,
						showany:1,
              			state_id: "<?php echo get_user_meta($userdata->ID,'city',true); ?>",
                    },
                    success: function(response) {   
					
						if(response.length > 5){         	 
            			jQuery("#filter-city").html(response);
						 jQuery('#filter-city').show();
						
						}else{
						jQuery('#filter-city').hide();
						}
						  
						 
                    },
                    error: function(e) {
                         
                    }
                });
            }
            
         </script>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>
