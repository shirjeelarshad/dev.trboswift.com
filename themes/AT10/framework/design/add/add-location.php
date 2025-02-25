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

if(_ppt(array('maps','enable')) == 1 ){ //&& strlen(_ppt(array('maps','apikey'))) > 2
 
?>
<div class="card shadow-sm">
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <h4>
          <?php  echo __("Location","premiumpress");  ?>
        </h4>
        <hr />
      </div>
      
      
      <?php if(_ppt(array("maps","provider")) == "basic"){ 
	  
	  
	     	// USER COUNTRY
			$selected_country = "";
			$selected_city = "";
			
			if(isset($_GET['eid'])){			
				$selected_country = get_post_meta($_GET['eid'], 'map-country', true);
				$selected_city = get_post_meta($_GET['eid'], 'map-city', true);	
			}
	
	  
	  ?>
      
      
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("My Country","premiumpress"); ?></label>
              <div class="controls">
                <select name="custom[map-country]" class="form-control" id="user-country">
                  <?php 
                        foreach($GLOBALS['core_country_list'] as $key=>$value){
                                if(isset($selected_country) && $selected_country == $key){ $sel ="selected=selected"; }else{ $sel =""; }
                                echo "<option ".$sel." value='".$key."'>".$value."</option>";} ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("Region","premiumpress"); ?></label>
              <div class="controls">
                <input type="hidden"  value="<?php echo $selected_city; ?>" id="user-city"  />
                <select class="form-control" id="user-city-select" name="custom[map-city]"  >
                </select>
              </div>
            </div>
            
       
                    
        <script type="application/javascript">
            jQuery(document).ready(function(){ 
            
            	jQuery('#user-country').on('change', function(e){
            	
            		 ajax_update_citylist();
            	
            	});	
            	 	
            	 ajax_update_citylist(); 
            	
            });
            
            function ajax_update_citylist(){
            
            	// COUNTRY VALUE
            	var countryid = jQuery('#user-country').val();
            	if(countryid == ""){
            	countryid = jQuery('#user-country option:first').val();
            	}
             
            	// SET VALUE
            	jQuery('#user-city').val(countryid);
            
                jQuery.ajax({
                    type: "POST",
                    url: ajax_site_url,	 	
            		data: {
                        action: "get_location_states",
            			country_id: countryid,
              			state_id: "<?php echo $selected_city; ?>",
                    },
                    success: function(response) {            	 
            			jQuery("#user-city-select").html(response);
                    },
                    error: function(e) {
                         
                    }
                });
            }
            
         </script>
          </div>
          
                <div class="col-12">
        <div class="form-group"> 
          <label><?php echo __("Display Address","premiumpress"); ?></label>
          <input type="text" id="map-location" name="custom[map-location]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-location',true).'"'; } ?> class="form-control form-control-sm rounded-0 form-control form-control-sm rounded-0-sm">
        </div>
      </div>
            
      
      
      <?php }else{ ?>
      
      
      <div class="col-12 position-relative">
        <div id="geocoder" class="geocoder"></div>
        <input type="text" class="form-control rounded-0 required mb-3" placeholder="<?php echo __("town, city or zipcode...","premiumpress"); ?>" id="form_zipbox" name="custom[map-zip]" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'],'map-zip',true); } ?>">
      </div>
      <div class="col-12">
        <div id="showmapbox mb-4">
          <div id="ppt_map_location" style="height:300px;width:100%; background:#efefef;"></div>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group mt-4"> <a href="javascript:void(0);" onclick="jQuery('#mapdetailspart').toggle();" class="float-right btn btn-system btn-sm"><i class="fal fa-map-marker"></i> <?php echo __("show details","premiumpress"); ?></a>
          <label><?php echo __("Display Address","premiumpress"); ?></label>
          <input type="text" id="map-location" name="custom[map-location]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-location',true).'"'; } ?> class="form-control form-control-sm rounded-0 form-control form-control-sm rounded-0-sm">
        </div>
      </div>
    </div>
    <div id="mapdetailspart" style="display:none;">
      <div class="row">
        <?php

$fields = array(

	"map-country" => __("Country","premiumpress"),
	"map-state" => __("State/County","premiumpress"),
	"map-city" => __("City","premiumpress"),
	"map-area" => __("Area","premiumpress"),
	"map-route" => __("Route/Street","premiumpress"),
	"map-neighborhood" => __("Neighborhood","premiumpress"),
	
	"map-log" => __("Longitude","premiumpress"),
	"map-lat" => __("Latitude","premiumpress"),
	
	

);
foreach($fields as $fk => $f){
?>
        <div class="col-6">
          <div class="form-group">
            <label class=""><?php echo $f; ?></label>
            <input type="text" id="<?php echo $fk; ?>" name="custom[<?php echo $fk; ?>]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],$fk,true).'"'; } ?> 
class="form-control form-control-sm rounded-0 form-control form-control-sm rounded-0-sm">
          </div>
        </div>
        <?php } ?>
      </div>
      
       <?php } ?>
      
    </div>
    
   
  </div>
</div>

<?php if(_ppt(array("maps","provider")) == "mapbox"){



if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-lat',true) !=""){ 
			 
			 	$lat = get_post_meta($_GET['eid'],'map-lat',true); 
			 
			 }else{ 
			 
			 	$lat = "-0.06"; 
			
			 }
             
if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ 
			 
			 	$long =  get_post_meta($_GET['eid'],'map-log',true); 
			 
			 }else{ 
			 
			 	$long = "51.645"; 
			 } 


?>
<?php if(is_admin()){ ?>
<style>
.mapboxgl-ctrl-geocoder--input { padding-left:35px !important; }
</style>
<?php } ?>
 
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script>

function initializeLocationMap(){

console.log("loading map box..");


	mapboxgl.accessToken = '<?php echo _ppt(array('maps','apikey')); ?>';
	var map = new mapboxgl.Map({
	container: 'ppt_map_location',
	style: 'mapbox://styles/mapbox/streets-v11',
	center: [<?php echo $long; ?>, <?php echo $lat; ?>],
	zoom: 13
	});
	
	
	var geocoder = new MapboxGeocoder({
		accessToken: mapboxgl.accessToken,
		mapboxgl: mapboxgl,
		marker: {        
        	draggable: true
        },
	});
	document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
	 
	geocoder.on('result', function (ev) {	
	 	 
       var searchResult = ev.result.geometry;
	     
	   jQuery("#map-location").val(ev.result.place_name);
	   jQuery("#map-log").val(searchResult.coordinates[0]);
	   jQuery("#map-lat").val(searchResult.coordinates[1]);
	   
	   var marker = new mapboxgl.Marker({draggable: true}).setLngLat([searchResult.coordinates[0], searchResult.coordinates[1]]).on('dragend', onDragEnd).addTo(map);
		
	   
	   jQuery('#map-country').val = "";
   	   jQuery('#map-state').val = "";  
   	   jQuery('#map-route').val = "";  
   	   jQuery('#map-area').val = "";  
   	   jQuery('#map-neighborhood').val = "";  
   						
	   
		placeName = ev.result.place_name.split(',');
        
            if(placeName[0] != "") {                 
                jQuery('#map-neighborhood').val(placeName[0]);
            }
			
           if(placeName[1] != "") {                 
                jQuery('#map-route').val(placeName[1]);
            } 
			
			 if(placeName[2] != "") {                 
                jQuery('#map-city').val(placeName[1]);
            } 
	   
	     	if(placeName[3] != "") {  
		 
		 		c = placeName[3].split(' '); 
			 	   
				if(placeName[3] == " United Kingdom"){
				
				jQuery('#map-country').val("UK");
				
				}else if(placeName[3] == " United States"){
				
				jQuery('#map-country').val("US");
				
				}else if(c[3] == null){
				
				jQuery('#map-country').val(placeName[3]);
				
				} else{
				
				jQuery('#map-state').val(c[1]);
				jQuery('#form_zipbox').val(c[2]+' '+c[3]);
				
				}
				
				
            } 
			
			if(placeName[4] != "") {  
		
				jQuery('#map-country').val(placeName[4]);
			}
			
			
			
	}); 
	
	
	var marker = new mapboxgl.Marker({draggable: true}).setLngLat([<?php echo $long; ?>, <?php echo $lat; ?>]).on('dragend', onDragEnd).addTo(map);
	 
	function onDragEnd(ev) {
	 
		var lngLat = marker.getLngLat();
		
		 
	   jQuery("#map-log").val(lngLat.lng);
	   jQuery("#map-lat").val(lngLat.lat);
	    
    	jQuery.getJSON("https://api.mapbox.com/geocoding/v5/mapbox.places/"+ lngLat.lng + ',' + lngLat.lat	 +".json?access_token=<?php echo trim( _ppt(array('maps','apikey')) ); ?>", { }, function(e) {
		 
			
			jQuery("#map-location").val(e.features[0].place_name);	 
		 
		 	var long = e.features[0].center[0];
			var lat = e.features[0].center[1];
			  
			placeName = e.features[0].place_name.split(',');
			
			 if(placeName[0] != "") {                 
                jQuery('#map-neighborhood').val(placeName[0]);
            }
			
           if(placeName[1] != "") {                 
                jQuery('#map-route').val(placeName[1]);
            } 
			
			 if(placeName[2] != "") {                 
                jQuery('#map-city').val(placeName[1]);
            } 
	   
	     	if(placeName[3] != "" && typeof placeName[3] != 'undefined' ) {  
		 
		 		c = placeName[3].split(' '); 
			 	   
				if(placeName[3] == " United Kingdom"){
				
				jQuery('#location-country').val("UK");
				
				}else if(placeName[3] == " United States"){
				
				jQuery('#location-country').val("US");
				
				}else if(c[3] == null){
				
				jQuery('#map-country').val(placeName[3]);
				
				} else{
				
				jQuery('#map-state').val(c[1]);
				jQuery('#location-zip').val(c[2]+' '+c[3]);
				
				}
				
				
            } 
			
			if(placeName[4] != "" && typeof placeName[4] != 'undefined' ) {  
		
				jQuery('#location-country').val(placeName[4]);
			} 
			
		});
		 	
	
	}
	 

 
	
	
	jQuery("#form_zipbox").hide();

}


 

// LOAD MAP BOX
var mapset = 0;
jQuery(document).ready(function(){   
   
    	var position = jQuery(window).scrollTop();
		
		if(position > 500 && mapset == 0){	
			mapset = 1;		
			initializeLocationMap();		
		}	 
 
   
	  jQuery(window).scroll(function(){
	 
			var position =  jQuery(window).scrollTop();
	
			if(position > 500 && mapset == 0){
				mapset = 1;				
				initializeLocationMap();		
			}	         
	
	 });
	 <?php if(isset($_POST['ajaxedit'])){ ?>
	  jQuery(document).ready(function(){   
	  	mapset = 1;				
				initializeLocationMap();
	  });
	  <?php } ?>
 
});
</script>
<?php }elseif(_ppt(array("maps","provider")) == "google"){ ?>
<script > 
   var geocoder;var map;var marker = ''; var markers = [];
   	
   function initializeLocationMap() {
   
   if(typeof(map) != "undefined"){ return; }
      
     // GET DEFAULT LOCATION
      <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){   
      $DF_LOCATON = get_post_meta($_GET['eid'],'map-lat',true).",".get_post_meta($_GET['eid'],'map-log',true);
      }else{
      $DF_LOCATON = _ppt('google_coords');   
      } 
      if($DF_LOCATON == ""){ $DF_LOCATON ="0,0"; }
      
      ?>
      
     // CREATE MAP CANVUS
     var myOptions = {mapTypeId: google.maps.MapTypeId.ROADMAP, zoomControl: true, scaleControl: true }
     map = new google.maps.Map(document.getElementById("ppt_map_location"), myOptions); 
        
     // LOAD MAP LOCATIONS
     var defaultBounds = new google.maps.LatLngBounds(
         new google.maps.LatLng(<?php echo $DF_LOCATON; ?>) );
      map.fitBounds(defaultBounds);
   
     // ADD ON MARKER
     <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
     var marker = new google.maps.Marker({
     	position: new google.maps.LatLng(<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>,<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>),
     	map: map,
     	animation: google.maps.Animation.DROP,	
   	icon: new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/images/marker.png'),			 
     });
     <?php } ?> 
   
     // ADD SEARCH BOX
     //map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('form_zipbox'));
     var searchBox = new google.maps.places.SearchBox(document.getElementById('form_zipbox'));
     
     //jQuery('#showmapbox').hide();
   
     // EVENT
      google.maps.event.addListener(searchBox, 'places_changed', function() {
       var places = searchBox.getPlaces();
   
       if (places.length == 0) {
         return;
       }
       for (var i = 0, marker; marker = markers[i]; i++) {
         marker.setMap(null);
       }
   	
       // For each place, get the icon, place name, and location. 

       var bounds = new google.maps.LatLngBounds();
       for (var i = 0, place; place = places[i]; i++) {
         var image = {
           url: place.icon,
           size: new google.maps.Size(71, 71),
           origin: new google.maps.Point(0, 0),
           anchor: new google.maps.Point(17, 34),
           scaledSize: new google.maps.Size(25, 25)
         }; 
   	  
   
           addMarker(place.geometry.location);
   	    document.getElementById("map-log").value = place.geometry.location.lng();	
       	document.getElementById("map-lat").value =  place.geometry.location.lat();
   	    getMyAddress(place.geometry.location,true)
   
         bounds.extend(place.geometry.location);
       }
   
       map.fitBounds(bounds);	
   	map.setZoom(15);	 
     });
     
     // LISTEN FOR PLACES ONCLICK
     searchBox.addListener('places_changed', function() {
   	var places = searchBox.getPlaces();
   	jQuery('#form_zipbox').val(places[0].name);
   	jQuery('#showmapbox').show();
   
     });
   
     // EVENT
     google.maps.event.addListener(map, 'bounds_changed', function() {
       var bounds = map.getBounds();
       searchBox.setBounds(bounds);
   	//map.setZoom(15);	
     });
     
     // EVENT
     google.maps.event.addListener(map, 'click', function(event){			
     	document.getElementById("map-log").value = event.latLng.lng();	
       document.getElementById("map-lat").value =  event.latLng.lat();
       getMyAddress(event.latLng,"yes");	
       addMarker(event.latLng);
   	
     });
     
     
    
     
   } // END INIT
   
   jQuery(document).ready(function(){ 
   
	   jQuery("#form_map_location").focusout(function() {
	   setTimeout(function(){  getMapLocation(jQuery("#form_map_location").val()); }, 500);   
	   });
	   
	   // HANDLE WHEN THE USED DOESNT SELECT ANYTHING FROM PLACES
	   jQuery(document).on('change', '#form_zipbox', function() {
		getMapLocation(jQuery('#form_zipbox').val());
	   });
   	   
   
   });
   

   function getMapLocation(location){
                           document.getElementById("map-state").value = "";
                           var geocoder = new google.maps.Geocoder();
                               if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {
   						 	 
                               map.setCenter(results[0].geometry.location);
                               addMarker(results[0].geometry.location);
                               getMyAddress(results[0].geometry.location,"no");			
                               document.getElementById("map-log").value = results[0].geometry.location.lng();	
                               document.getElementById("map-lat").value =  results[0].geometry.location.lat();
                               map.setZoom(15);	 // MAP ZOOM LEVEL	
                               }});}			
   }
   
    function getMyAddress(location,setaddress){
                            
                           jQuery('#showmapbox').show();
                           google.maps.event.trigger(map, 'resize');
                           var geocoder = new google.maps.Geocoder();
                           var country = "";
                           if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { if (status == google.maps.GeocoderStatus.OK) {
                           
   						jQuery('#map-country').val = "";
   						jQuery('#map-state').val = "";  
   						jQuery('#map-route').val = "";  
   						jQuery('#map-area').val = "";  
   						jQuery('#map-neighborhood').val = "";  
   						jQuery('#map-location').val = ""; 
   						jQuery('#mapform-extra').show(); 
   
   						
   						
                           for (var i = 0; i < results[0].address_components.length; i++) {
   						
   						 
   							  var addr = results[0].address_components[i];
   							  //alert(addr.types[0]+' = '+ addr.long_name);
   							  switch (addr.types[0]){
   								
   								
   								case "street_number": {
   									//document.getElementById("map-address1").value = addr.long_name;
   								} break;
   								
   								
   								// area
   								case "political": {
   									document.getElementById("map-area").value = addr.long_name;
   								} break;
   								// neighborhood
   								case "neighborhood": {
   									document.getElementById("map-neighborhood").value = addr.long_name;
   								} break;
   								// street
   								case "route": {
   									document.getElementById("map-route").value = addr.long_name;
   								} break;
   								 
   								
   								case "locality": 
   								case "postal_town": 
   								{								 
   									//document.getElementById("map-address3").value = addr.long_name;
   									document.getElementById("map-city").value = addr.long_name;
   								} break;
   								
   								case "postal_code": {
   									jQuery('#form_zipbox').val(addr.short_name);
   								} break;
   								
   								case "administrative_area_level_1": {								
   									document.getElementById("map-state").value = addr.long_name;
   								} break;
   								
   								case "administrative_area_level_2": {								
   									document.getElementById("map-state").value = addr.long_name;
   								} break;
   								
   								case "administrative_area_level_3": {								
   									document.getElementById("map-state").value = document.getElementById("map-state").value + addr.long_name;
   								} break;
   								
   								case "country": {
   									document.getElementById("map-country").value = addr.short_name;	
   								} break;						  
   							  
   							  } // end switch
   						  
                   		} // end for	
   						
   						// NOW SET THE DISPLAY VALUES 
   			  			document.getElementById("map-location").value = results[0].formatted_address;
   						//jQuery('#map-location-display').html('<i class="fa fa-map-marker" aria-hidden="true"></i> '+results[0].formatted_address);
                           
                           map.setCenter(results[0].geometry.location);		
                           map.setZoom(16);	
                           
                           }
   						
   						});
   						
   						}} 
                           
                           
                           function addMarker(location) {
   						if (marker=='') {	
   						
   						
   						marker = new google.maps.Marker({	position: location, 	map: map, draggable:true,     animation: google.maps.Animation.DROP,	});
   						
   						
   						google.maps.event.addListener (marker, 'dragend', function (event){
   						document.getElementById("map-log").value = event.latLng.lng();	
                           document.getElementById("map-lat").value =  event.latLng.lat();
                           getMyAddress(event.latLng,"yes");	
                           addMarker(event.latLng);
   						});
   						
   						
   						}						
                           marker.setPosition(location);
   						map.setCenter(location); 						
   						}
    
    
   // LOAD MAP BOX
   var mapset = 0;
   jQuery(document).ready(function(){   
   
    	var position = jQuery(window).scrollTop();
		
		if(position > 500 && mapset == 0){	
			mapset = 1;		
			initializeLocationMap();		
		}	 
 
   
	  jQuery(window).scroll(function(){
	 
			var position =  jQuery(window).scrollTop();
	
			if(position > 500 && mapset == 0){
				mapset = 1;				
				initializeLocationMap();		
			}	         
	
	 });
	 
	 	 <?php if(isset($_POST['ajaxedit'])){ ?>
	  jQuery(document).ready(function(){   
	mapset = 1;				
				initializeLocationMap();
	  });
	  <?php } ?>
	 
 
});
    
</script>
<?php } ?>
<?php } ?>
