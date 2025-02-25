
var map;

jQuery(document).ready(function(){
					
	 	
	 MappingEvents();
	 

}); 

function MappingEvents(){

		/* main search map  */
    	jQuery(document).on("click","a.loadmainmap", function (e) {
				mainMap();								   
		});
		
		/* HERO MAP */
		if(jQuery('.hero-map').length > 0){
			mainMap();
		}
		
		/* USER SETS LOCATION MAP */
		locationMap();
		
		/* SINGLE PAGE MAP LOAD */
		singleMap(); 
}
 

/* =============================================================================
  MAP - SNGLE
  ========================================================================== */	 

function singleMap() { 
	 
	mapboxgl.accessToken = ajax_googlemaps_key;
	var map = new mapboxgl.Map({
		container: 'singleMap',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: [jQuery('#singleMap').data('longitude'), jQuery('#singleMap').data('latitude')],
		zoom: 10
	});
	 

	 
    jQuery(document).on("click","a.single-map-item", function (e) {         	
			
			map.resize();			
			
			jQuery(".map-modal-wrap").fadeIn(400);
						  	
			var $t 			= jQuery(this);
            var newln 		= $t.data("newlatitude");
            var newlg 		= $t.data("newlongitude");
			var newtitle 	= $t.data("title");
			var newurl 		= $t.data("url");	
			var newaddress 	= $t.data("address");
			jQuery(".map-modal-container h3 a").text(newtitle).attr("href", newurl);
			jQuery(".map-modal-container .address").text(newaddress);
			 
			
			map.easeTo({
				center: [newlg, newln],
				zoom: 15
			});
			
			var marker = new mapboxgl.Marker({draggable: false}).setLngLat([newlg, newln]).setOffset(new mapboxgl.Point(140, 100)).addTo(map);
	 
	 		map.resize();
			 
			
		 
    });
	jQuery(".map-modal-close , .map-modal-wrap-overlay").on("click", function (e) {
        jQuery(".map-modal-wrap").fadeOut(400); 
		
    });
	
 
	
}
/* =============================================================================
  MAPBOX SET DATA
  ========================================================================== */	 

function setMapData(data, map){
	  
		 	var long = data.center[0];
			var lat = data.center[1];
			
			var marker = new mapboxgl.Marker({draggable: true}).setLngLat([long, lat]).setOffset(new mapboxgl.Point(140, 100)).addTo(map);
			map.easeTo({
					center: [long, lat],
					zoom: 15
			});
			 
			jQuery("#location-address-display").html(data.place_name);
			jQuery("#location-address").val(data.place_name);
			jQuery("#location-mylog").val(long);
			jQuery("#location-mylat").val(lat);
			 
			placeName = data.place_name.split(',');
			
			//console.log(placeName);
			
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
				
            } else {
				
				jQuery('#location-country').val(placeName[2]);
				
			}
			
			if(placeName[4] != "" && typeof placeName[4] != 'undefined' ) {  
		
				jQuery('#location-country').val(placeName[4]);
			}
			
			
			jQuery("#zipcodesearch").val(jQuery("#location-address").val());
			
			_filter_update();
			 
	
}

/* =============================================================================
  MAP - USER LCOATION 
  ========================================================================== */	 

function locationMap() {
	
	if(jQuery('#locationmapgeromapbox').length == 0){		
	return;	
	}
	
	jQuery("#basiczipcodesearchbox").hide();
	 
    var markerIcon = {
        url: ajax_framework_url + 'framework/images/marker.png',
    } 
 	
	default_lng = "53.8007554";
	if(jQuery('#location-mylog').val() != ""){
	default_lng = jQuery('#location-mylog').val();	
	}
	
	default_lat = "-1.5490774";
	if(jQuery('#location-mylog').val() != ""){
	default_lat = jQuery('#location-mylat').val();	
	}
	 
	if(default_lat != 'undefined'){
		default_lat = "-1.5490774";
		default_lng = "53.8007554";	 
	}
	
	
	
	mapboxgl.accessToken = ajax_googlemaps_key;
	var map = new mapboxgl.Map({
		container: 'locationMap',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: [parseFloat(default_lng), parseFloat(default_lat) ],
		zoom: 10
	});
	
	jQuery('#locationmapgeromapbox').html('');
	
	var geocoder = new MapboxGeocoder({
						accessToken: mapboxgl.accessToken,
						mapboxgl: mapboxgl,
						marker: {        
							draggable: true
						},
	});
	
	
	document.getElementById('locationmapgeromapbox').appendChild(geocoder.onAdd(map)); 
		
	geocoder.on('result', function (ev) {
	
		setMapData(ev.result, map);
									
	}); 
	
	jQuery(document).on("click",".distance-filter-click", function (e) {								
								 
		if(jQuery("#location-mylog").val() == ""){
		 
			jQuery('.single-location-window').trigger('click');
		}
		
	});
	  
    jQuery(document).on("click",".single-location-window", function (e) {		 
       		
			e.preventDefault();         
			jQuery(".location-modal-wrap").fadeIn(400);			
			getCurrentLocation();
		 	
			if(jQuery("#location-mylog").val() != ""){
				
				var long = jQuery("#location-mylog").val();
				var lat = jQuery("#location-mylat").val();
				
				var marker = new mapboxgl.Marker({draggable: true}).setLngLat([long, lat]).setOffset(new mapboxgl.Point(140, 100)).on('dragend', onDragEnd).addTo(map);
				 map.easeTo({
					center: [long, lat],
					color: "yellow",
					zoom: 15
				});
				 
				function onDragEnd(ev) {
					 
					   var lngLat = marker.getLngLat();
					   
					   jQuery("#location-mylog").val(lngLat.lng);
					   jQuery("#ocation-mylat").val(lngLat.lat);
						
						jQuery.getJSON("https://api.mapbox.com/geocoding/v5/mapbox.places/"+ lngLat.lng + ',' + lngLat.lat	 +".json?access_token=" + ajax_googlemaps_key, { }, function(e) {
						 
							 setMapData(e.features[0], map);	
							
						});
				}	


			}
			
			map.resize(); 
		 
    }); 
	
	jQuery("#location-setaddress").on("change", function (e) {
		 
    	jQuery.getJSON("https://api.mapbox.com/geocoding/v5/mapbox.places/"+ jQuery('#location-setaddress').val() +".json?types=address&access_token=" + ajax_googlemaps_key, {
   
    	}, function(e) {
			 
			setMapData(e.features[0], map);	
			
		});
		
    }); 
	  
	jQuery(".location-modal-close").on("click", function (e) {
  
			if(jQuery('#location-country').val() == ""){	
			
				jQuery(".location-modal-wrap").fadeOut(400);
				return ;	
			}
			
			jQuery.ajax({
			   type: "POST",
			   url: ajax_site_url,		
			data: {
				action: "update_mylocaton",
				
				address: 	jQuery('#location-address').val(),
				long: 		jQuery('#location-mylog').val(),
				lat: 		jQuery('#location-mylat').val(),
				country: 	jQuery('#location-country').val(),
				zip: 		jQuery('#location-zip').val(),
			 },
			   success: function(response) {
					
					if(jQuery('#location-address').val()  != ""){
						jQuery('#zipcodesearch').val(jQuery('#location-address').val()); 	
					}else{
						jQuery('#zipcodesearch').val(jQuery('#location-country').val()); 	
					}
									
					jQuery(".location-modal-wrap").fadeOut(400);
					
					_filter_update();
					   //location.reload();
				
			   },
			   error: function(e) {
				   alert("error saving data"+e)
			   }
		   });		
		
    });	
	
	
} 



/* =============================================================================
  MAP - BIG (SEARCH AND HEROS)
  ========================================================================== */	 

function mainMap() {
	
	/* get map data */
	if(jQuery('#mapdatabox').val() == ""){
		
			jQuery.ajax({
				type: "POST",
				url: ajax_site_url,	
				dataType: 'json',	
				data: {
						action: "load_map_data",									
				},
				success: function(response) {
									  	
					jQuery('#mapdatabox').val(response.mapdata); 									 
					mainMapLoad();
					
					setTimeout(function(){ 						
					jQuery('.nextmap-nav').trigger( "click" );										
					}, 2000);
								
				},
				error: function(e) { console.log("could not load map data "+e) }
			});
	
	}else{
			
			mainMapLoad();
			
	}
	
}
function mainMapLoad(){
	
	
	var allMarkers = [];
	var current_marker_num;
	
	jQuery("#pac-input").hide();
	
	mapboxgl.accessToken = ajax_googlemaps_key;
	var map = new mapboxgl.Map({
		container: 'map-main',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: ['-0.06', '51.645'],
		zoom: 10
	});
	
	map.addControl(new mapboxgl.NavigationControl());
	 
	map.on('load', function () {
						 
						 
	jQuery( ".dynamic_map" ).each(function( index ) { 
					 
			var jsonObj = jQuery( this ).val();	
			if(jsonObj != ""){	
			
				var obj = jQuery.parseJSON(jsonObj);
				var h = 0; 
				 
				jQuery.each(obj, function(index, item) {
				 	 
					if(typeof item.lat != 'undefined' && item.lat != 'undefined' ){
							 
							 
							 
								 
							var marker = new mapboxgl.Marker({draggable: false}).setLngLat([item.long, item.lat]).setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(locationData(item.url, item.img, item.title, item.address, item.price, "5"))).addTo(map);
						  	
							allMarkers.push(marker);
							
							marker.on('click', Marker_Click);
							
							setMarkerColor(marker, "blue");
							 
							// ADD CLASS LINK
							jQuery(".card-search[data-pid='"+item.id+"']").on("mouseover", function (e) {
																									 
								/* DEFAULT ZOOM */
								dzoom = 10;
								if ( jQuery('.map-zoom').lenght == 0) {			
									dzoom = parseFloat(jQuery('.map-zoom').val());			
								}else if(jQuery('.search-results').length > 0){			
									dzoom = 12;			
								}
		
								map.easeTo({
									center: [item.long, item.lat],
										zoom: dzoom
								});
								
								setMarkerColor(marker, "red");
							 	
								map.resize();
								
								marker.togglePopup();
								 
								
						});
							
						jQuery(".card-search[data-pid='"+item.id+"']").on("mouseout", function (e) {
																									 
							setMarkerColor(marker, "blue");
							
							marker.togglePopup();
							
						});
						
					}
				
				}); // end loop
				 
				
			}
			
			// SET MARKERS ID
			current_marker_num = allMarkers.length -1; 
			 
			// ZOOM TO LAST MARKER
			Marker_Click(allMarkers[current_marker_num]);	
			
			// scroll top
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
		
		
	});	
	

	function setMarkerColor(marker, color) {
		var $elem = jQuery(marker.getElement());
		$elem.find('svg g[fill="' + marker._color + '"]').attr('fill', color);
		marker._color = color;
	}

	function Marker_Click(marker){
		
		/* DEFAULT ZOOM */
		dzoom = 10;
		if ( jQuery('.map-zoom').lenght == 0) {			
			dzoom = parseFloat(jQuery('.map-zoom').val());			
		}else if(jQuery('.search-results').length > 0){			
			dzoom = 12;			
		}
		
		 
		
		if(typeof marker != 'undefined'){
			 
			map.easeTo({
				center: [marker._lngLat['lng'], marker._lngLat['lat']],
				zoom: dzoom
			});
			 
		}
		
		map.resize();	
			
	}
	
	
	jQuery('.nextmap-nav').on("click", function (e) {
          
		   e.preventDefault();
		   
		   if(typeof allMarkers[current_marker_num] != 'undefined'){
			   
			   // turn of off popup
			   allMarkers[current_marker_num].togglePopup();
			   
			   current_marker_num = current_marker_num - 1;
			   
			   // trigger next popup
			   Marker_Click(allMarkers[current_marker_num]);
		   
		   }
       
	});
     
	jQuery('.prevmap-nav').on("click", function (e) {           
		   
		   e.preventDefault();
		   
		    if(typeof allMarkers[current_marker_num] != 'undefined'){
		   
		    // turn of off popup
		   allMarkers[current_marker_num].togglePopup();
		  
		   current_marker_num = current_marker_num + 1;
		   
		   // trigger next popup
		   Marker_Click(allMarkers[current_marker_num]);
		   
		}
		   
    });	
	
	
});
	
	
       
	
	

}
/* =============================================================================
  GOOGLE MAP DATA
  ========================================================================== */	 
 
 
 
 function locationData(locationURL, locationImg, locationTitle, locationAddress, locationPrice, locationStarRating) {
            return ('<div class="map-popup-wrap"><div class="map-popup"><a href="' + locationURL + '" class="listing-img-content fl-wrap"><img src="' + locationImg + '" alt=""><span class="map-popup-location-price">' + locationPrice + '</span></a><div class="listing-content fl-wrap"><div class="listing-title fl-wrap"><h4><a href=' + locationURL + '>' + locationTitle + '</a></h4><span class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i>' + locationAddress + '</span></div></div></div></div>')

}   
	

/* =============================================================================
  GOOGLE LOCATION
  ========================================================================== */	 
  
function getCurrentLocation() {
	 
	 if (navigator.geolocation) {
	   
	   navigator.geolocation.getCurrentPosition(
        function(position) {
			 
            //do succes handling
			//savePosition(position);
			
			jQuery('#homesearchzip').val(position.coords.latitude + "," + position.coords.longitude);
			
        },
        function errorCallback(error) {
            //do error handling
			console.log(error);
        },
        {
            timeout:5000
        }
   	 );	
 
	}
}
function positionError(e) {
    var t = (e.code, e.message);
}

function savePosition(e) {	

	jQuery("#location-mylog").val(e.coords.longitude);
	jQuery("#location-mylat").val(e.coords.latitude);
	 
	/*
    jQuery.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + e.coords.latitude + "," + e.coords.longitude + "&key=" + ajax_googlemaps_key, {
        sensor: !1,
        latlng: e.coords.latitude + "," + e.coords.longitude
    }, function(t) {
		
		if(typeof t.results[0] != 'undefined'){
		 
			jQuery('#location-setaddress').val(t.results[0].formatted_address);
		
		}
		
		jQuery("#location-mylog").val(e.coords.longitude);
		jQuery("#location-mylat").val(e.coords.latitude);
		
    });
	*/
}