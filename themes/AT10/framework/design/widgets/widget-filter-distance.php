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

 
$distance1 = 0;
if(isset($_GET['radius']) && is_numeric($_GET['radius'])){ $distance2 = esc_attr($_GET['radius']); }else{ $distance2 = 100; }		

$max_distance = 1000;	
 
?>

<div class="card card-filter">
  <div class="card-body"> 
  
  <a href="#" data-toggle="collapse" data-target="#collapse_distance" aria-expanded="true" >
    <h5 class="card-title"><?php echo __("Location","premiumpress"); ?></h5>
    </a>
    
    <div <?php if(!$CORE->isMobileDevice()){ ?>class="filter-content collapse" id="collapse_distance"<?php }else{ ?> class="pt-2"<?php } ?>>
      
      
      
      <?php if(_ppt(array("maps","provider")) == "basic"){   
	  
	  
	  $selected_country = "";
	  if(isset($_GET['country'])){
	  $selected_country  = $_GET['country'];
	  }
	  
		  $SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a INNER JOIN ".$wpdb->postmeta." AS t ON ( a.meta_key = 'map-country' AND t.post_id = a.post_id ) LIMIT 60";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				if(count($results) > 0 && !empty($results) ){
				
				?>
                 <select class="customfilter form-control"  id="filter-country"  name="country" data-type="select" data-key="country" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>>
       				<option value=""><?php echo __("Any","premiumpress"); ?></option>
				<?php	
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
							}
							
							if( $selected_country == $state){
							echo "<option value='".$state."' selected=selected>". $name."</option>";
							}else{
							echo "<option value='".$state."'>". $name."</option>";
							}
					}  
	 
	  
		  ?>
        
        </select>
        
        
          <input type="hidden"  value="" id="user-city"  />
           
          <select class="customfilter form-control mt-3" id="filter-city" style="display:none;" name="city" data-type="select" data-key="city" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>> </select>
        
        
        
         <!-- end row -->
        <script type="application/javascript">
            jQuery(document).ready(function(){ 
            
            	jQuery('#filter-country').on('change', function(e){
            	
            		 ajax_update_citylist();					 
					
            	});	
				
				<?php if(isset($_GET['country'])){ ?>
				 ajax_update_citylist();	
				<?php } ?>
            	  
            });
            
            function ajax_update_citylist(){
            
            	// COUNTRY VALUE
            	var countryid = jQuery('#filter-country').val();
            	if(countryid == ""){            	
				jQuery('#filter-city').hide();
				return;
            	}
             
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
            			jQuery("#filter-city").html(response);
						 jQuery('#filter-city').show();
                    },
                    error: function(e) {
                         
                    }
                });
            }
            
         </script>
        
      <?php } ?>
      
      
      <?php }else{ ?>
      
      
      <div class="position-relative form-group">
      
      <div class="pb-4 mb-2">
       <div class="position-absolute locationmapgeromapbox w-100" id="locationmapgeromapbox">
       
       
       <input type="text" class="form-control w-100 customfilter" id="location-setaddress"  value="<?php 
		 
		if(isset($_GET['zipcode'])) { echo esc_attr($_GET['zipcode']); }
		elseif(isset($_SESSION['mylocation']) && strlen($_SESSION['mylocation']['zip']) > 1 ){ echo esc_attr($_SESSION['mylocation']['zip']); }
		elseif(isset($_SESSION['mylocation']) && isset($GLOBALS['core_country_list'][$_SESSION['mylocation']['country']])){ echo $GLOBALS['core_country_list'][$_SESSION['mylocation']['country']]; }
		 
		 ?>" />
 		
         
        </div>        
        </div>
        
        <div id="locationMap"></div>  
        
        <input type="hidden" id="location-mylog" value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['log']; }else{ echo "-60.1"; } ?>" />
        <input type="hidden" id="location-mylat" value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['lat']; }else{ echo "30.7"; }  ?>" />
        <input type="hidden" id="location-country" value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['country']; } ?>" />
        <input type="hidden" id="location-address" value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['address']; } ?>" />
        <input type="hidden" id="location-zip" value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['zip']; } ?>" />
         
         </div>
          
         
         
        <?php /* if(isset($_SESSION['mylocation'])){ ?>
        <span  style="top: 10px; right: 40px; position: absolute;    z-index: 100;"> <a href="javascript:void(0);" class="single-location-window text-primary"> <span class="fa fa-map-marker ppt_locationflag"></span></a> </span>
        <?php }else{ ?>
        <span  style="top: 10px; right: 40px; position: absolute;    z-index: 100;"> <a href="javascript:void(0);" class="single-location-window text-primary"> <i class="fa fa-map-marker"></i> </a> </span>
        <?php } 
		
		  <span  style="top: 10px; right: 10px; position: absolute;    z-index: 100;"> <i class="fa fa-search" style="cursor:pointer;" onclick="jQuery('.distancef').trigger('click').trigger('click');jQuery('#ajax-search-location').html('');"></i> </span> </div>
		
		*/  ?>
        
        
        <div class="position-relative form-group" id="basiczipcodesearchbox">
        <input type="text" class="form-control w-100 customfilter" id="zipcodesearch" name="zipcode"  autocomplete="off" data-type="text" data-key="zipcode" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>  value="<?php 
		 
		if(isset($_GET['zipcode'])) { echo esc_attr($_GET['zipcode']); }
		elseif(isset($_SESSION['mylocation']) && strlen($_SESSION['mylocation']['zip']) > 1 ){ echo $_SESSION['mylocation']['zip']; }
		elseif(isset($_SESSION['mylocation']) && isset($GLOBALS['core_country_list'][$_SESSION['mylocation']['country']])){ echo $GLOBALS['core_country_list'][$_SESSION['mylocation']['country']]; }
		 
		 ?>" placeholder="<?php echo __("Town or city","premiumpress"); ?>" />
         
        
         <span  style="top: 10px; right: 10px; position: absolute;    z-index: 100;"> 
         <i class="fa fa-search" style="cursor:pointer;" onclick="jQuery('.distancef').trigger('click').trigger('click');jQuery('#ajax-search-location').html('');"></i>
         </span>
         
        
		</div>
        
      
      <div class="form-group mb-0 mt-3">
        <select id="radius" name="radius" class=" customfilter" data-type="select" data-key="radius"  <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> >
          <option value="0" selected="selected"><?php echo __("All available","premiumpress"); ?></option>
          <?php
	foreach(array("0.25","0.5","1","3","5","10","15","20","30","40","50","75","100") as $v){
		  		
		$val = $v; 
	
	?>
          <option value="<?php echo $v; ?>" <?php if(isset($_GET['radius']) && $_GET['radius'] == $v){ echo "selected=selected"; } ?>>
          <?php 
	
	if( _ppt(array('search','mapmetric')) == "1"){
	echo str_replace("%s", $val,__("Within %s KM","premiumpress"));
	}else{
	
	echo str_replace("%s", $val,__("Within %s miles","premiumpress"));
	}
	
	
	
	 ?>
          </option>
          <?php } ?>
        </select>
      </div>
      <div id="ajax-search-location"></div>
      
      
      <?php } // end basic ?>
      
      
      <?php if(_ppt(array("maps","provider")) == "mapbox"){ ?>
      <script>
	  
	  jQuery(document).ready(function(){ 
	  setTimeout(function(){ 						
		jQuery(".mapboxgl-ctrl-geocoder--input").attr("placeholder", "<?php echo __("Country, City, Zipcode.","premiumpress"); ?>");	
		
		<?php if(isset($_GET['zipcode'])){ ?>
		jQuery(".mapboxgl-ctrl-geocoder--input").val("<?php echo esc_html(strip_tags($_GET['zipcode'])); ?>");	
		<?php } ?>
		
										
		}, 2000);
	
	  });
	  
	  </script>
      
      <?php }elseif(_ppt(array("maps","provider")) == "google"){ ?>
      <script>
	  
	  jQuery(document).ready(function(){ 
	  setTimeout(function(){ 						
		jQuery("#location-setaddress").attr("placeholder", "<?php echo __("Country, City, Zipcode.","premiumpress"); ?>");	
		
		
		<?php if(isset($_GET['zipcode'])){ ?>
		jQuery("#location-setaddress").val("<?php echo esc_html(strip_tags($_GET['zipcode'])); ?>");	
		<?php } ?>
										
		}, 2000);
	
	  });
	  
	  </script>
      <?php } ?>
      
    </div>
  </div>
</div>
<?php } ?>