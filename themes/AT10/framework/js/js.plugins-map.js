
var map;

jQuery(document).ready(function(){
					
	if( window.google && google.maps ) {	 
		
	 MappingEvents();
		
	}else{
		
		if ( typeof ajax_googlemaps_key !== 'undefined' ){
		
 			jQuery.ajax({					
				data: {
						'v': 3,
						'sensor': false,
						'libraries': 'places',
						//'callback': 'ppt_maps_callback',						
						"key": ajax_googlemaps_key,
				},
				url: 'https://maps.google.com/maps/api/js',
				dataType: 'script',						 
				success: function(response) {
					
					MappingEvents();
						
				},
				error: function(e) {
						console.log("error loading map: "+e)
				}
			});
	
	
		}
		
	}

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
		
		/* HERO MAP */
		if(jQuery('.search-mapside').length > 0){
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
	 
	if( window.google && google.maps ) {	
		
		var markerIcon = {
			url: ajax_framework_url + 'framework/images/marker.png',
		} 
	 
		var myLatLng = {
			lng: jQuery('#singleMap').data('longitude'),
			lat: jQuery('#singleMap').data('latitude'),
		};
		
		var single_map = new google.maps.Map(document.getElementById("singleMap"),{
			zoom: 14,
			center: myLatLng,
			scrollwheel: false,
			zoomControl: false,
			fullscreenControl: true,
			mapTypeControl: false,
			scaleControl: false,
			panControl: false,
			navigationControl: false,
			streetViewControl: true,
			styles: [{
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"color": "#f2f2f2"
				}]
			}]
		});
		
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: single_map,
			icon: markerIcon,
			title: 'Location'
		});
	} 
	 
    jQuery(document).on("click","a.single-map-item", function (e) {
          
			jQuery(".map-modal-wrap").fadeIn(400);
						  	
			var $t 			= jQuery(this);
            var newln 		= $t.data("newlatitude");
            var newlg 		= $t.data("newlongitude");
			var newtitle 	= $t.data("title");
			var newurl 		= $t.data("url");	
			var newaddress 	= $t.data("address");
			jQuery(".map-modal-container h3 a").text(newtitle).attr("href", newurl);
			jQuery(".map-modal-container .address").text(newaddress);
			
			
			if( window.google && google.maps ) {
				var latlng = new google.maps.LatLng(newln, newlg);			
				marker.setPosition(latlng);
				single_map.panTo(latlng);	
			}
			
		 
    });
	jQuery(".map-modal-close , .map-modal-wrap-overlay").on("click", function (e) {
        jQuery(".map-modal-wrap").fadeOut(400);
		 
		 if( window.google && google.maps ) {
        	single_map.setZoom(14);
        	single_map.getStreetView().setVisible(false);
		 }
		
    });
	
 
	
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
 	
	var myLatLng = {
        lng: parseFloat(default_lng),
        lat: parseFloat(default_lat),
    }
	
 	
	if( window.google && google.maps ) {	
  
	
		var single_map = new google.maps.Map(document.getElementById('locationMap'), {
			zoom: 14,
			center: myLatLng,
			scrollwheel: false,
			zoomControl: true,
			fullscreenControl: true,
			mapTypeControl: false,
			scaleControl: false,
			panControl: false,
			navigationControl: false,
			streetViewControl: true,
			styles: [{
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"color": "#f2f2f2"
				}]
			}]
		});
		
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: single_map,
			icon: markerIcon,
			title: 'Location',
			draggable: !0,
			animation: google.maps.Animation.DROP
			 
		});
		
		
		
		
		
	 
            var input = document.getElementById('location-setaddress');
			
			//jQuery("#location-setaddress").attr("placeholder", jQuery("#ipcodesearch").attr("placeholder") );
			
            var searchBox = new google.maps.places.SearchBox(input);
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
				
				 places.forEach(function (place) {
										  
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
					
					jQuery("#location-address-display").html(place.formatted_address);				
					jQuery('#location-address').val(place.formatted_address);					 
					jQuery("#zipcodesearch").val(jQuery("#location-address").val());
					
					_filter_update();
					
				
				});
				 
            });
		
		
		
		
	
	} 
	
 
    jQuery(document).on("click",".single-location-window", function (e) {		 
       		
			e.preventDefault();         
			jQuery(".location-modal-wrap").fadeIn(400);			
			getCurrentLocation();		
			
			if( window.google && google.maps ) {
				
				var t = new google.maps.Geocoder;
				t && t.geocode({ latLng: myLatLng }, function(e, t) {
					if (t == google.maps.GeocoderStatus.OK) {
						
						jQuery('#location-address').val(e[0].formatted_address);
						
						for (var a = 0; a < e[0].address_components.length; a++) {
							var o = e[0].address_components[a];
							switch (o.types[0]) {							
								case "postal_code":
								   document.getElementById("location-zip").value = o.short_name;
								break;							
								break;
								case "country":
								   document.getElementById("location-country").value = o.short_name
							}
						}
						 
						var latlng = new google.maps.LatLng(e[0].geometry.location.lat(), e[0].geometry.location.lng());			
						marker.setPosition(latlng);
						single_map.panTo(latlng);
					
					}
				});	
			
			}
		 
    });
	
	jQuery("#location-setaddress").on("change", function (e) {
	 	 
  											  
		var t = new google.maps.Geocoder;
		t && t.geocode({ address: jQuery('#location-setaddress').val() }, function(e, t) {
			if (t == google.maps.GeocoderStatus.OK) {
				
				
				jQuery("#location-address-display").html(e[0].formatted_address);				
				jQuery('#location-address').val(e[0].formatted_address);
		 		jQuery("#location-mylog").val(e[0].geometry.location.lng());
				jQuery("#location-mylat").val(e[0].geometry.location.lat());
				
				for (var a = 0; a < e[0].address_components.length; a++) {
						var o = e[0].address_components[a];
						switch (o.types[0]) {							
							case "postal_code":
							   document.getElementById("location-zip").value = o.short_name;
							break;							
							break;
							case "country":
							   document.getElementById("location-country").value = o.short_name
						}
				}
				 
				var latlng = new google.maps.LatLng(e[0].geometry.location.lat(), e[0].geometry.location.lng());			
				marker.setPosition(latlng);
				single_map.panTo(latlng);
			
			}
		});													
															
	});
	
	
	if( window.google && google.maps ) {
		
		google.maps.event.addListener(marker, "dragend", function(e) {
				 
				jQuery("#location-mylog").val(e.latLng.lng());
				jQuery("#location-mylat").val(e.latLng.lat());
				
				var latlng1 = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());	
				
				var t = new google.maps.Geocoder;
				t && t.geocode({ latLng: latlng1 }, function(e, t) {
					if (t == google.maps.GeocoderStatus.OK) {
						
						jQuery('#location-address').val(e[0].formatted_address);
						
						for (var a = 0; a < e[0].address_components.length; a++) {
							var o = e[0].address_components[a];
							switch (o.types[0]) {							
								case "postal_code":
								   document.getElementById("location-zip").value = o.short_name;
								break;							
								break;
								case "country":
								   document.getElementById("location-country").value = o.short_name
							}
						}
						 
						var latlng = new google.maps.LatLng(e[0].geometry.location.lat(), e[0].geometry.location.lng());			
						marker.setPosition(latlng);
						single_map.panTo(latlng);
					
					}
				});			 	 
		}); 
	
	}
	 
	jQuery(".location-modal-close").on("click", function (e) {
  
 		if(jQuery('#location-country').val() == ""){			
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
   				
				if(jQuery('#location-address').val() != ""){
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

	jQuery(document).on("click",".distance-filter-click", function (e) {	
			 			 
		if(jQuery("#location-mylog").val() == ""){
		 
			jQuery('.single-location-window').trigger('click');
		}
		
	});
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
	
if( window.google && google.maps ) {
	
/* info boxes */
"use strict";function InfoBox(t){t=t||{},google.maps.OverlayView.apply(this,arguments),this.content_=t.content||"",this.disableAutoPan_=t.disableAutoPan||!1,this.maxWidth_=t.maxWidth||0,this.pixelOffset_=t.pixelOffset||new google.maps.Size(0,0),this.position_=t.position||new google.maps.LatLng(0,0),this.zIndex_=t.zIndex||null,this.boxClass_=t.boxClass||"infoBox",this.boxStyle_=t.boxStyle||{},this.closeBoxMargin_=t.closeBoxMargin||"2px",this.closeBoxURL_=t.closeBoxURL||"http://www.google.com/intl/en_us/mapfiles/close.gif",""===t.closeBoxURL&&(this.closeBoxURL_=""),this.infoBoxClearance_=t.infoBoxClearance||new google.maps.Size(1,1),void 0===t.visible&&(void 0===t.isHidden?t.visible=!0:t.visible=!t.isHidden),this.isHidden_=!t.visible,this.alignBottom_=t.alignBottom||!1,this.pane_=t.pane||"floatPane",this.enableEventPropagation_=t.enableEventPropagation||!1,this.div_=null,this.closeListener_=null,this.moveListener_=null,this.contextListener_=null,this.eventListeners_=null,this.fixedWidthSet_=null}InfoBox.prototype=new google.maps.OverlayView,InfoBox.prototype.createInfoBoxDiv_=function(){var t,i,e,o=this,s=function(t){t.cancelBubble=!0,t.stopPropagation&&t.stopPropagation()};if(!this.div_){if(this.div_=document.createElement("div"),this.setBoxStyle_(),void 0===this.content_.nodeType?this.div_.innerHTML=this.getCloseBoxImg_()+this.content_:(this.div_.innerHTML=this.getCloseBoxImg_(),this.div_.appendChild(this.content_)),this.getPanes()[this.pane_].appendChild(this.div_),this.addClickHandler_(),this.div_.style.width?this.fixedWidthSet_=!0:0!=this.maxWidth_&&this.div_.offsetWidth>this.maxWidth_?(this.div_.style.width=this.maxWidth_,this.div_.style.overflow="auto",this.fixedWidthSet_=!0):(e=this.getBoxWidths_(),this.div_.style.width=this.div_.offsetWidth-e.left-e.right+"px",this.fixedWidthSet_=!1),this.panBox_(this.disableAutoPan_),!this.enableEventPropagation_){for(this.eventListeners_=[],i=["mousedown","mouseover","mouseout","mouseup","click","dblclick","touchstart","touchend","touchmove"],t=0;t<i.length;t++)this.eventListeners_.push(google.maps.event.addDomListener(this.div_,i[t],s));this.eventListeners_.push(google.maps.event.addDomListener(this.div_,"mouseover",function(t){this.style.cursor="default"}))}this.contextListener_=google.maps.event.addDomListener(this.div_,"contextmenu",function(t){t.returnValue=!1,t.preventDefault&&t.preventDefault(),o.enableEventPropagation_||s(t)}),google.maps.event.trigger(this,"domready")}},InfoBox.prototype.getCloseBoxImg_=function(){var t="";return""!=this.closeBoxURL_&&(t="<img",t+=" src='"+this.closeBoxURL_+"'",t+=" align=right",t+=" style='",t+=" position: relative;",t+=" cursor: pointer;",t+=" margin: "+this.closeBoxMargin_+";",t+="'>"),t},InfoBox.prototype.addClickHandler_=function(){var t;""!=this.closeBoxURL_?(t=this.div_.firstChild,this.closeListener_=google.maps.event.addDomListener(t,"click",this.getCloseClickHandler_())):this.closeListener_=null},InfoBox.prototype.getCloseClickHandler_=function(){var t=this;return function(i){i.cancelBubble=!0,i.stopPropagation&&i.stopPropagation(),google.maps.event.trigger(t,"closeclick"),t.close()}},InfoBox.prototype.panBox_=function(t){var i,e=0,o=0;if(!t&&(i=this.getMap())instanceof google.maps.Map){i.getBounds().contains(this.position_)||i.setCenter(this.position_),i.getBounds();var s=i.getDiv(),n=s.offsetWidth,h=s.offsetHeight,l=this.pixelOffset_.width,d=this.pixelOffset_.height,r=this.div_.offsetWidth,a=this.div_.offsetHeight,_=this.infoBoxClearance_.width,p=this.infoBoxClearance_.height,v=this.getProjection().fromLatLngToContainerPixel(this.position_);if(v.x<-l+_?e=v.x+l-_:v.x+r+l+_>n&&(e=v.x+r+l+_-n),this.alignBottom_?v.y<-d+p+a?o=v.y+d-p-a:v.y+d+p>h&&(o=v.y+d+p-h):v.y<-d+p?o=v.y+d-p:v.y+a+d+p>h&&(o=v.y+a+d+p-h),0!==e||0!==o){i.getCenter();i.panBy(e,o)}}},InfoBox.prototype.setBoxStyle_=function(){var t,i;if(this.div_){this.div_.className=this.boxClass_,this.div_.style.cssText="",i=this.boxStyle_;for(t in i)i.hasOwnProperty(t)&&(this.div_.style[t]=i[t]);this.div_.style.WebkitTransform="translateZ(0)",void 0!==this.div_.style.opacity&&""!=this.div_.style.opacity&&(this.div_.style.MsFilter='"progid:DXImageTransform.Microsoft.Alpha(Opacity='+100*this.div_.style.opacity+')"',this.div_.style.filter="alpha(opacity="+100*this.div_.style.opacity+")"),this.div_.style.position="absolute",this.div_.style.visibility="hidden",null!=this.zIndex_&&(this.div_.style.zIndex=this.zIndex_)}},InfoBox.prototype.getBoxWidths_=function(){var t,i={top:0,bottom:0,left:0,right:0},e=this.div_;return document.defaultView&&document.defaultView.getComputedStyle?(t=e.ownerDocument.defaultView.getComputedStyle(e,""))&&(i.top=parseInt(t.borderTopWidth,10)||0,i.bottom=parseInt(t.borderBottomWidth,10)||0,i.left=parseInt(t.borderLeftWidth,10)||0,i.right=parseInt(t.borderRightWidth,10)||0):document.documentElement.currentStyle&&e.currentStyle&&(i.top=parseInt(e.currentStyle.borderTopWidth,10)||0,i.bottom=parseInt(e.currentStyle.borderBottomWidth,10)||0,i.left=parseInt(e.currentStyle.borderLeftWidth,10)||0,i.right=parseInt(e.currentStyle.borderRightWidth,10)||0),i},InfoBox.prototype.onRemove=function(){this.div_&&(this.div_.parentNode.removeChild(this.div_),this.div_=null)},InfoBox.prototype.draw=function(){this.createInfoBoxDiv_();var t=this.getProjection().fromLatLngToDivPixel(this.position_);this.div_.style.left=t.x+this.pixelOffset_.width+"px",this.alignBottom_?this.div_.style.bottom=-(t.y+this.pixelOffset_.height)+"px":this.div_.style.top=t.y+this.pixelOffset_.height+"px",this.isHidden_?this.div_.style.visibility="hidden":this.div_.style.visibility="visible"},InfoBox.prototype.setOptions=function(t){void 0!==t.boxClass&&(this.boxClass_=t.boxClass,this.setBoxStyle_()),void 0!==t.boxStyle&&(this.boxStyle_=t.boxStyle,this.setBoxStyle_()),void 0!==t.content&&this.setContent(t.content),void 0!==t.disableAutoPan&&(this.disableAutoPan_=t.disableAutoPan),void 0!==t.maxWidth&&(this.maxWidth_=t.maxWidth),void 0!==t.pixelOffset&&(this.pixelOffset_=t.pixelOffset),void 0!==t.alignBottom&&(this.alignBottom_=t.alignBottom),void 0!==t.position&&this.setPosition(t.position),void 0!==t.zIndex&&this.setZIndex(t.zIndex),void 0!==t.closeBoxMargin&&(this.closeBoxMargin_=t.closeBoxMargin),void 0!==t.closeBoxURL&&(this.closeBoxURL_=t.closeBoxURL),void 0!==t.infoBoxClearance&&(this.infoBoxClearance_=t.infoBoxClearance),void 0!==t.isHidden&&(this.isHidden_=t.isHidden),void 0!==t.visible&&(this.isHidden_=!t.visible),void 0!==t.enableEventPropagation&&(this.enableEventPropagation_=t.enableEventPropagation),this.div_&&this.draw()},InfoBox.prototype.setContent=function(t){this.content_=t,this.div_&&(this.closeListener_&&(google.maps.event.removeListener(this.closeListener_),this.closeListener_=null),this.fixedWidthSet_||(this.div_.style.width=""),void 0===t.nodeType?this.div_.innerHTML=this.getCloseBoxImg_()+t:(this.div_.innerHTML=this.getCloseBoxImg_(),this.div_.appendChild(t)),this.fixedWidthSet_||(this.div_.style.width=this.div_.offsetWidth+"px",void 0===t.nodeType?this.div_.innerHTML=this.getCloseBoxImg_()+t:(this.div_.innerHTML=this.getCloseBoxImg_(),this.div_.appendChild(t))),this.addClickHandler_()),google.maps.event.trigger(this,"content_changed")},InfoBox.prototype.setPosition=function(t){this.position_=t,this.div_&&this.draw(),google.maps.event.trigger(this,"position_changed")},InfoBox.prototype.setZIndex=function(t){this.zIndex_=t,this.div_&&(this.div_.style.zIndex=t),google.maps.event.trigger(this,"zindex_changed")},InfoBox.prototype.setVisible=function(t){this.isHidden_=!t,this.div_&&(this.div_.style.visibility=this.isHidden_?"hidden":"visible")},InfoBox.prototype.getContent=function(){return this.content_},InfoBox.prototype.getPosition=function(){return this.position_},InfoBox.prototype.getZIndex=function(){return this.zIndex_},InfoBox.prototype.getVisible=function(){return void 0!==this.getMap()&&null!==this.getMap()&&!this.isHidden_},InfoBox.prototype.show=function(){this.isHidden_=!1,this.div_&&(this.div_.style.visibility="visible")},InfoBox.prototype.hide=function(){this.isHidden_=!0,this.div_&&(this.div_.style.visibility="hidden")},InfoBox.prototype.open=function(t,i){var e=this;i&&(this.position_=i.getPosition(),this.moveListener_=google.maps.event.addListener(i,"position_changed",function(){e.setPosition(this.getPosition())})),this.setMap(t),this.div_&&this.panBox_()},InfoBox.prototype.close=function(){var t;if(this.closeListener_&&(google.maps.event.removeListener(this.closeListener_),this.closeListener_=null),this.eventListeners_){for(t=0;t<this.eventListeners_.length;t++)google.maps.event.removeListener(this.eventListeners_[t]);this.eventListeners_=null}this.moveListener_&&(google.maps.event.removeListener(this.moveListener_),this.moveListener_=null),this.contextListener_&&(google.maps.event.removeListener(this.contextListener_),this.contextListener_=null),this.setMap(null)};
 
function ClusterIcon(a,b){a.getMarkerClusterer().extend(ClusterIcon,google.maps.OverlayView),this.cluster_=a,this.className_=a.getMarkerClusterer().getClusterClass(),this.styles_=b,this.center_=null,this.div_=null,this.sums_=null,this.visible_=!1,this.setMap(a.getMap())}function Cluster(a){this.markerClusterer_=a,this.map_=a.getMap(),this.gridSize_=a.getGridSize(),this.minClusterSize_=a.getMinimumClusterSize(),this.averageCenter_=a.getAverageCenter(),this.markers_=[],this.center_=null,this.bounds_=null,this.clusterIcon_=new ClusterIcon(this,a.getStyles())}function MarkerClusterer(a,b,c){this.extend(MarkerClusterer,google.maps.OverlayView),b=b||[],c=c||{},this.markers_=[],this.clusters_=[],this.listeners_=[],this.activeMap_=null,this.ready_=!1,this.gridSize_=c.gridSize||60,this.minClusterSize_=c.minimumClusterSize||10,this.maxZoom_=c.maxZoom||null,this.styles_=c.styles||[],this.title_=c.title||"",this.zoomOnClick_=!0,void 0!==c.zoomOnClick&&(this.zoomOnClick_=c.zoomOnClick),this.averageCenter_=!1,void 0!==c.averageCenter&&(this.averageCenter_=c.averageCenter),this.ignoreHidden_=!1,void 0!==c.ignoreHidden&&(this.ignoreHidden_=c.ignoreHidden),this.enableRetinaIcons_=!1,void 0!==c.enableRetinaIcons&&(this.enableRetinaIcons_=c.enableRetinaIcons),this.imagePath_=c.imagePath||MarkerClusterer.IMAGE_PATH,this.imageExtension_=c.imageExtension||MarkerClusterer.IMAGE_EXTENSION,this.imageSizes_=c.imageSizes||MarkerClusterer.IMAGE_SIZES,this.calculator_=c.calculator||MarkerClusterer.CALCULATOR,this.batchSize_=c.batchSize||MarkerClusterer.BATCH_SIZE,this.batchSizeIE_=c.batchSizeIE||MarkerClusterer.BATCH_SIZE_IE,this.clusterClass_=c.clusterClass||"cluster",navigator.userAgent.toLowerCase().indexOf("msie")!==-1&&(this.batchSize_=this.batchSizeIE_),this.setupStyles_(),this.addMarkers(b,!0),this.setMap(a)}ClusterIcon.prototype.onAdd=function(){var b,c,a=this;this.div_=document.createElement("div"),this.div_.className=this.className_,this.visible_&&this.show(),this.getPanes().overlayMouseTarget.appendChild(this.div_),this.boundsChangedListener_=google.maps.event.addListener(this.getMap(),"bounds_changed",function(){c=b}),google.maps.event.addDomListener(this.div_,"mousedown",function(){b=!0,c=!1}),google.maps.event.addDomListener(this.div_,"click",function(d){if(b=!1,!c){var e,f,g=a.cluster_.getMarkerClusterer();google.maps.event.trigger(g,"click",a.cluster_),google.maps.event.trigger(g,"clusterclick",a.cluster_),g.getZoomOnClick()&&(f=g.getMaxZoom(),e=a.cluster_.getBounds(),g.getMap().fitBounds(e),setTimeout(function(){g.getMap().fitBounds(e),null!==f&&g.getMap().getZoom()>f&&g.getMap().setZoom(f+1)},100)),d.cancelBubble=!0,d.stopPropagation&&d.stopPropagation()}}),google.maps.event.addDomListener(this.div_,"mouseover",function(){var b=a.cluster_.getMarkerClusterer();google.maps.event.trigger(b,"mouseover",a.cluster_)}),google.maps.event.addDomListener(this.div_,"mouseout",function(){var b=a.cluster_.getMarkerClusterer();google.maps.event.trigger(b,"mouseout",a.cluster_)})},ClusterIcon.prototype.onRemove=function(){this.div_&&this.div_.parentNode&&(this.hide(),google.maps.event.removeListener(this.boundsChangedListener_),google.maps.event.clearInstanceListeners(this.div_),this.div_.parentNode.removeChild(this.div_),this.div_=null)},ClusterIcon.prototype.draw=function(){if(this.visible_){var a=this.getPosFromLatLng_(this.center_);this.div_.style.top=a.y+"px",this.div_.style.left=a.x+"px"}},ClusterIcon.prototype.hide=function(){this.div_&&(this.div_.style.display="none"),this.visible_=!1},ClusterIcon.prototype.show=function(){if(this.div_){var a="",b=this.backgroundPosition_.split(" "),c=parseInt(b[0].replace(/^\s+|\s+$/g,""),10),d=parseInt(b[1].replace(/^\s+|\s+$/g,""),10),e=this.getPosFromLatLng_(this.center_);this.div_.style.cssText=this.createCss(e),a="<img src='"+this.url_+"' style='position: absolute; top: "+d+"px; left: "+c+"px; ",this.cluster_.getMarkerClusterer().enableRetinaIcons_||(a+="clip: rect("+-1*d+"px, "+(-1*c+this.width_)+"px, "+(-1*d+this.height_)+"px, "+-1*c+"px);"),a+="'>",this.div_.innerHTML=a+"<div class='cluster' style='position: absolute;top: "+this.anchorText_[0]+"px;left: "+this.anchorText_[1]+"px;color: "+this.textColor_+";font-size: "+this.textSize_+"px;font-family: "+this.fontFamily_+";font-weight: "+this.fontWeight_+";font-style: "+this.fontStyle_+";text-decoration: "+this.textDecoration_+";text-align: center;width: "+this.width_+"px;line-height:"+this.height_+"px;'>"+this.sums_.text+"</div>","undefined"==typeof this.sums_.title||""===this.sums_.title?this.div_.title=this.cluster_.getMarkerClusterer().getTitle():this.div_.title=this.sums_.title,this.div_.style.display=""}this.visible_=!0},ClusterIcon.prototype.useStyle=function(a){this.sums_=a;var b=Math.max(0,a.index-1);b=Math.min(this.styles_.length-1,b);var c=this.styles_[b];this.url_=c.url,this.height_=c.height,this.width_=c.width,this.anchorText_=c.anchorText||[0,0],this.anchorIcon_=c.anchorIcon||[parseInt(this.height_/2,10),parseInt(this.width_/2,10)],this.textColor_=c.textColor||"black",this.textSize_=c.textSize||11,this.textDecoration_=c.textDecoration||"none",this.fontWeight_=c.fontWeight||"bold",this.fontStyle_=c.fontStyle||"normal",this.fontFamily_=c.fontFamily||"Arial,sans-serif",this.backgroundPosition_=c.backgroundPosition||"0 0"},ClusterIcon.prototype.setCenter=function(a){this.center_=a},ClusterIcon.prototype.createCss=function(a){var b=[];return b.push("cursor: pointer;"),b.push("position: absolute; top: "+a.y+"px; left: "+a.x+"px;"),b.push("width: "+this.width_+"px; height: "+this.height_+"px;"),b.join("")},ClusterIcon.prototype.getPosFromLatLng_=function(a){var b=this.getProjection().fromLatLngToDivPixel(a);return b.x-=this.anchorIcon_[1],b.y-=this.anchorIcon_[0],b.x=parseInt(b.x,10),b.y=parseInt(b.y,10),b},Cluster.prototype.getSize=function(){return this.markers_.length},Cluster.prototype.getMarkers=function(){return this.markers_},Cluster.prototype.getCenter=function(){return this.center_},Cluster.prototype.getMap=function(){return this.map_},Cluster.prototype.getMarkerClusterer=function(){return this.markerClusterer_},Cluster.prototype.getBounds=function(){var a,b=new google.maps.LatLngBounds(this.center_,this.center_),c=this.getMarkers();for(a=0;a<c.length;a++)b.extend(c[a].getPosition());return b},Cluster.prototype.remove=function(){this.clusterIcon_.setMap(null),this.markers_=[],delete this.markers_},Cluster.prototype.addMarker=function(a){var b,c,d;if(this.isMarkerAlreadyAdded_(a))return!1;if(this.center_){if(this.averageCenter_){var e=this.markers_.length+1,f=(this.center_.lat()*(e-1)+a.getPosition().lat())/e,g=(this.center_.lng()*(e-1)+a.getPosition().lng())/e;this.center_=new google.maps.LatLng(f,g),this.calculateBounds_()}}else this.center_=a.getPosition(),this.calculateBounds_();if(a.isAdded=!0,this.markers_.push(a),c=this.markers_.length,d=this.markerClusterer_.getMaxZoom(),null!==d&&this.map_.getZoom()>d)a.getMap()!==this.map_&&a.setMap(this.map_);else if(c<this.minClusterSize_)a.getMap()!==this.map_&&a.setMap(this.map_);else if(c===this.minClusterSize_)for(b=0;b<c;b++)this.markers_[b].setMap(null);else a.setMap(null);return this.updateIcon_(),!0},Cluster.prototype.isMarkerInClusterBounds=function(a){return this.bounds_.contains(a.getPosition())},Cluster.prototype.calculateBounds_=function(){var a=new google.maps.LatLngBounds(this.center_,this.center_);this.bounds_=this.markerClusterer_.getExtendedBounds(a)},Cluster.prototype.updateIcon_=function(){var a=this.markers_.length,b=this.markerClusterer_.getMaxZoom();if(null!==b&&this.map_.getZoom()>b)return void this.clusterIcon_.hide();if(a<this.minClusterSize_)return void this.clusterIcon_.hide();var c=this.markerClusterer_.getStyles().length,d=this.markerClusterer_.getCalculator()(this.markers_,c);this.clusterIcon_.setCenter(this.center_),this.clusterIcon_.useStyle(d),this.clusterIcon_.show()},Cluster.prototype.isMarkerAlreadyAdded_=function(a){var b;if(this.markers_.indexOf)return this.markers_.indexOf(a)!==-1;for(b=0;b<this.markers_.length;b++)if(a===this.markers_[b])return!0;return!1},MarkerClusterer.prototype.onAdd=function(){var a=this;this.activeMap_=this.getMap(),this.ready_=!0,this.repaint(),this.listeners_=[google.maps.event.addListener(this.getMap(),"zoom_changed",function(){a.resetViewport_(!1),this.getZoom()!==(this.get("minZoom")||0)&&this.getZoom()!==this.get("maxZoom")||google.maps.event.trigger(this,"idle")}),google.maps.event.addListener(this.getMap(),"idle",function(){a.redraw_()})]},MarkerClusterer.prototype.onRemove=function(){var a;for(a=0;a<this.markers_.length;a++)this.markers_[a].getMap()!==this.activeMap_&&this.markers_[a].setMap(this.activeMap_);for(a=0;a<this.clusters_.length;a++)this.clusters_[a].remove();for(this.clusters_=[],a=0;a<this.listeners_.length;a++)google.maps.event.removeListener(this.listeners_[a]);this.listeners_=[],this.activeMap_=null,this.ready_=!1},MarkerClusterer.prototype.draw=function(){},MarkerClusterer.prototype.setupStyles_=function(){var a,b;if(!(this.styles_.length>0))for(a=0;a<this.imageSizes_.length;a++)b=this.imageSizes_[a],this.styles_.push({url:this.imagePath_+(a+1)+"."+this.imageExtension_,height:b,width:b})},MarkerClusterer.prototype.fitMapToMarkers=function(){var a,b=this.getMarkers(),c=new google.maps.LatLngBounds;for(a=0;a<b.length;a++)c.extend(b[a].getPosition());this.getMap().fitBounds(c)},MarkerClusterer.prototype.getGridSize=function(){return this.gridSize_},MarkerClusterer.prototype.setGridSize=function(a){this.gridSize_=a},MarkerClusterer.prototype.getMinimumClusterSize=function(){return this.minClusterSize_},MarkerClusterer.prototype.setMinimumClusterSize=function(a){this.minClusterSize_=a},MarkerClusterer.prototype.getMaxZoom=function(){return this.maxZoom_},MarkerClusterer.prototype.setMaxZoom=function(a){this.maxZoom_=a},MarkerClusterer.prototype.getStyles=function(){return this.styles_},MarkerClusterer.prototype.setStyles=function(a){this.styles_=a},MarkerClusterer.prototype.getTitle=function(){return this.title_},MarkerClusterer.prototype.setTitle=function(a){this.title_=a},MarkerClusterer.prototype.getZoomOnClick=function(){return this.zoomOnClick_},MarkerClusterer.prototype.setZoomOnClick=function(a){this.zoomOnClick_=a},MarkerClusterer.prototype.getAverageCenter=function(){return this.averageCenter_},MarkerClusterer.prototype.setAverageCenter=function(a){this.averageCenter_=a},MarkerClusterer.prototype.getIgnoreHidden=function(){return this.ignoreHidden_},MarkerClusterer.prototype.setIgnoreHidden=function(a){this.ignoreHidden_=a},MarkerClusterer.prototype.getEnableRetinaIcons=function(){return this.enableRetinaIcons_},MarkerClusterer.prototype.setEnableRetinaIcons=function(a){this.enableRetinaIcons_=a},MarkerClusterer.prototype.getImageExtension=function(){return this.imageExtension_},MarkerClusterer.prototype.setImageExtension=function(a){this.imageExtension_=a},MarkerClusterer.prototype.getImagePath=function(){return this.imagePath_},MarkerClusterer.prototype.setImagePath=function(a){this.imagePath_=a},MarkerClusterer.prototype.getImageSizes=function(){return this.imageSizes_},MarkerClusterer.prototype.setImageSizes=function(a){this.imageSizes_=a},MarkerClusterer.prototype.getCalculator=function(){return this.calculator_},MarkerClusterer.prototype.setCalculator=function(a){this.calculator_=a},MarkerClusterer.prototype.getBatchSizeIE=function(){return this.batchSizeIE_},MarkerClusterer.prototype.setBatchSizeIE=function(a){this.batchSizeIE_=a},MarkerClusterer.prototype.getClusterClass=function(){return this.clusterClass_},MarkerClusterer.prototype.setClusterClass=function(a){this.clusterClass_=a},MarkerClusterer.prototype.getMarkers=function(){return this.markers_},MarkerClusterer.prototype.getTotalMarkers=function(){return this.markers_.length},MarkerClusterer.prototype.getClusters=function(){return this.clusters_},MarkerClusterer.prototype.getTotalClusters=function(){return this.clusters_.length},MarkerClusterer.prototype.addMarker=function(a,b){this.pushMarkerTo_(a),b||this.redraw_()},MarkerClusterer.prototype.addMarkers=function(a,b){var c;for(c in a)a.hasOwnProperty(c)&&this.pushMarkerTo_(a[c]);b||this.redraw_()},MarkerClusterer.prototype.pushMarkerTo_=function(a){if(a.getDraggable()){var b=this;google.maps.event.addListener(a,"dragend",function(){b.ready_&&(this.isAdded=!1,b.repaint())})}a.isAdded=!1,this.markers_.push(a)},MarkerClusterer.prototype.removeMarker=function(a,b){var c=this.removeMarker_(a);return!b&&c&&this.repaint(),c},MarkerClusterer.prototype.removeMarkers=function(a,b){var c,d,e=!1;for(c=0;c<a.length;c++)d=this.removeMarker_(a[c]),e=e||d;return!b&&e&&this.repaint(),e},MarkerClusterer.prototype.removeMarker_=function(a){var b,c=-1;if(this.markers_.indexOf)c=this.markers_.indexOf(a);else for(b=0;b<this.markers_.length;b++)if(a===this.markers_[b]){c=b;break}return c!==-1&&(a.setMap(null),this.markers_.splice(c,1),!0)},MarkerClusterer.prototype.clearMarkers=function(){this.resetViewport_(!0),this.markers_=[]},MarkerClusterer.prototype.repaint=function(){var a=this.clusters_.slice();this.clusters_=[],this.resetViewport_(!1),this.redraw_(),setTimeout(function(){var b;for(b=0;b<a.length;b++)a[b].remove()},0)},MarkerClusterer.prototype.getExtendedBounds=function(a){var b=this.getProjection(),c=new google.maps.LatLng(a.getNorthEast().lat(),a.getNorthEast().lng()),d=new google.maps.LatLng(a.getSouthWest().lat(),a.getSouthWest().lng()),e=b.fromLatLngToDivPixel(c);e.x+=this.gridSize_,e.y-=this.gridSize_;var f=b.fromLatLngToDivPixel(d);f.x-=this.gridSize_,f.y+=this.gridSize_;var g=b.fromDivPixelToLatLng(e),h=b.fromDivPixelToLatLng(f);return a.extend(g),a.extend(h),a},MarkerClusterer.prototype.redraw_=function(){this.createClusters_(0)},MarkerClusterer.prototype.resetViewport_=function(a){var b,c;for(b=0;b<this.clusters_.length;b++)this.clusters_[b].remove();for(this.clusters_=[],b=0;b<this.markers_.length;b++)c=this.markers_[b],c.isAdded=!1,a&&c.setMap(null)},MarkerClusterer.prototype.distanceBetweenPoints_=function(a,b){var c=6371,d=(b.lat()-a.lat())*Math.PI/180,e=(b.lng()-a.lng())*Math.PI/180,f=Math.sin(d/2)*Math.sin(d/2)+Math.cos(a.lat()*Math.PI/180)*Math.cos(b.lat()*Math.PI/180)*Math.sin(e/2)*Math.sin(e/2),g=2*Math.atan2(Math.sqrt(f),Math.sqrt(1-f)),h=c*g;return h},MarkerClusterer.prototype.isMarkerInBounds_=function(a,b){return b.contains(a.getPosition())},MarkerClusterer.prototype.addToClosestCluster_=function(a){var b,c,d,e,f=4e4,g=null;for(b=0;b<this.clusters_.length;b++)d=this.clusters_[b],e=d.getCenter(),e&&(c=this.distanceBetweenPoints_(e,a.getPosition()),c<f&&(f=c,g=d));g&&g.isMarkerInClusterBounds(a)?g.addMarker(a):(d=new Cluster(this),d.addMarker(a),this.clusters_.push(d))},MarkerClusterer.prototype.createClusters_=function(a){var b,c,d,e=this;if(this.ready_){0===a&&(google.maps.event.trigger(this,"clusteringbegin",this),"undefined"!=typeof this.timerRefStatic&&(clearTimeout(this.timerRefStatic),delete this.timerRefStatic)),d=this.getMap().getZoom()>3?new google.maps.LatLngBounds(this.getMap().getBounds().getSouthWest(),this.getMap().getBounds().getNorthEast()):new google.maps.LatLngBounds(new google.maps.LatLng(85.02070771743472,-178.48388434375),new google.maps.LatLng(-85.08136444384544,178.00048865625));var f=this.getExtendedBounds(d),g=Math.min(a+this.batchSize_,this.markers_.length);for(b=a;b<g;b++)c=this.markers_[b],!c.isAdded&&this.isMarkerInBounds_(c,f)&&(!this.ignoreHidden_||this.ignoreHidden_&&c.getVisible())&&this.addToClosestCluster_(c);g<this.markers_.length?this.timerRefStatic=setTimeout(function(){e.createClusters_(g)},0):(delete this.timerRefStatic,google.maps.event.trigger(this,"clusteringend",this))}},MarkerClusterer.prototype.extend=function(a,b){return function(a){var b;for(b in a.prototype)this.prototype[b]=a.prototype[b];return this}.apply(a,[b])},MarkerClusterer.CALCULATOR=function(a,b){for(var c=0,d="",e=a.length.toString(),f=e;0!==f;)f=parseInt(f/10,10),c++;return c=Math.min(c,b),{text:e,index:c,title:d}},MarkerClusterer.BATCH_SIZE=2e3,MarkerClusterer.BATCH_SIZE_IE=500,MarkerClusterer.IMAGE_PATH="../images/m",MarkerClusterer.IMAGE_EXTENSION="png",MarkerClusterer.IMAGE_SIZES=[53,56,66,78,90];

		
		/* DEFAULT ZOOM */
		dzoom = 10;
		if ( jQuery('.map-zoom').lenght == 0) {
			dzoom = parseFloat(jQuery('.map-zoom').val());
		} 
		
 			
        var map = new google.maps.Map(document.getElementById('map-main'), {
            zoom: dzoom,
            scrollwheel: false,
            center: new google.maps.LatLng(40.8, -73.90),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            panControl: false,
            fullscreenControl: true,
            navigationControl: false,
            streetViewControl: false,
            animation: google.maps.Animation.BOUNCE,
            gestureHandling: 'cooperative',
            styles: [{
                    "featureType": "poi.attraction",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "poi.business",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "poi.medical",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "poi.place_of_worship",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "poi.school",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "transit.station.bus",
                    "stylers": [{
                        "visibility": "off"
                    }]

                }
            ]
        });
		
 
		if(typeof jQuery('.map-color') !== "undefined"){
			
		if(jQuery('.map-color').val() == "blue"){
		var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];			
		map.setOptions({styles: styles});
		}
		
		if(jQuery('.map-color').val() == "grey"){
		var styles = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}];
		map.setOptions({styles: styles});
		}
		
		if(jQuery('.map-color').val() == "green"){
		var styles = [{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#aee2e0"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#abce83"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#769E72"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#7B8758"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#EBF4A4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#8dab68"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#5B5B3F"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ABCE83"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#A4C67D"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#9BBF72"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#EBF4A4"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#87ae79"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#7f2200"},{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"visibility":"on"},{"weight":4.1}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#495421"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"visibility":"off"}]}]
		map.setOptions({styles: styles});
		}
		
		}else{
			
	 var styles = [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}];
	 map.setOptions({styles: styles});
	 
		}
		  
		
        var boxText = document.createElement("div");
        boxText.className = 'map-box'
        var currentInfobox;
        var boxOptions = {
            content: boxText,
            disableAutoPan: true,
            alignBottom: true,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-100, -25),
            zIndex: null,
            boxStyle: {
                width: "260px"
            },
            closeBoxMargin: "0",
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(1, 1),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false,
        };

        var markerCluster, marker, i;
        var allMarkers = [];
        var clusterStyles = [{
            textColor: 'white',
            url: '',
            height: 50,
            width: 50
        }];
		
		var lastlog,lastlat;
       
		
        google.maps.event.addDomListener(window, "resize", function () {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });
		
		google.maps.event.addListenerOnce(map, 'idle', function(){
    
				jQuery( ".dynamic_map" ).each(function( index ) { 
					 
					var jsonObj = jQuery( this ).val();	
					 
					  var markerIcon = {
							anchor: new google.maps.Point(12, 0),
							url: ajax_framework_url + 'framework/images/marker.png',
							labelOrigin: new google.maps.Point(25, 20)
						}
					
					
					if(jsonObj != ""){
						
						canContinue = true;
						
						try {
							
							var obj = jQuery.parseJSON(jsonObj);
							
						} catch (e) {
							if (e instanceof SyntaxError) {
								console.log(e);
								canContinue = false;
								return;
							} else {
								console.log(e);
								return;
							}
						}

						if(canContinue){
						
						 	
							var h = 0;					
						 	jQuery.each(obj, function(index, item) {
													  
								if(typeof item.lat != 'undefined' && item.lat != 'undefined' ){
	  
								 marker = new google.maps.Marker({
										position: new google.maps.LatLng(item.lat, item.long),
										icon: markerIcon,
										id: h,
										label: {
											text: "" + h,
											color: "#3AACED",
											fontSize: "11px",
											fontWeight: "bold",
										},
								});
								 
								 lastlog = item.long;
								 lastlat =  item.lat;
								
								allMarkers.push(marker);
								
								var ib = new InfoBox(); 
								   google.maps.event.addListener(ib, "domready", function () {
									cardextradata()
								});
							 
								google.maps.event.addListener(marker, 'click', (function (marker, i) {
									return function () {
										
										ib.setOptions(boxOptions);
										boxText.innerHTML = locationData(item.url, item.img, item.title, item.address, item.price, "5"),
										
										ib.close();
										ib.open(map, marker);
										currentInfobox = marker.id;
										
										var latLng = new google.maps.LatLng(item.lat, item.long);
										map.panTo(latLng);
										map.panBy(0, -150);
										google.maps.event.addListener(ib, 'domready', function () {
											jQuery('.infoBox-close').click(function (e) {
												e.preventDefault();
												ib.close();
											});
										});
									}
								})(marker, i)); 
								
								
								 // ADD CLASS LINK
								jQuery(".card-search[data-pid='"+item.id+"']").on("mouseover", function (e) {
										 
										ib.setOptions(boxOptions);
										boxText.innerHTML = locationData(item.url, item.img, item.title, item.address, item.price, "5"),
										 
									 
										map.panTo( new google.maps.LatLng(item.lat, item.long));
										map.panBy(0, -150);
										 
										google.maps.event.trigger(marker.id, 'click');
										 										 
									 
								});
								 
								
							 
								
								h++;								
								}								 
								
							});
							
						}
							
							 
							var options2 = {
									imagePath: 'images/',
									styles: clusterStyles,
									minClusterSize: 2
							};							
							
							markerCluster = new MarkerClusterer(map, allMarkers, options2);
							
					}
				 
				});	
		 	
		 	
		 	if (typeof (lastlat) != "undefined") {
				latlng = new google.maps.LatLng(lastlat, lastlog);
				marker.setPosition(latlng);
				map.panTo(latlng);			
				map.setZoom(15);
			}
			 
				 
		}); 
		
        if (jQuery(".controls-searchbox").length) {
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
			
        }
		
		 
        jQuery('.map-item').on("click", function (e) {
            e.preventDefault();
            map.setZoom(15);
            var index = currentInfobox;
            var marker_index = parseInt(jQuery(this).attr('href').split('#')[1], 10);
            google.maps.event.trigger(allMarkers[marker_index], "click");
            if (jQuery(window).width() > 1064) {
                if (jQuery(".map-container").hasClass("fw-map")) {
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".map-container").offset().top + "-110px"
                    }, 1000)
                    return false;
                }
            }
        });
        jQuery('.nextmap-nav').on("click", function (e) {
            e.preventDefault();
            map.setZoom(15);
            var index = currentInfobox;
            if (index + 1 < allMarkers.length) {
                google.maps.event.trigger(allMarkers[index + 1], 'click');
            } else {
                google.maps.event.trigger(allMarkers[0], 'click');
            }
        });
        jQuery('.prevmap-nav').on("click", function (e) {
            e.preventDefault();
            map.setZoom(15);
            if (typeof (currentInfobox) == "undefined") {
                google.maps.event.trigger(allMarkers[allMarkers.length - 1], 'click');
            } else {
                var index = currentInfobox;
                if (index - 1 < 0) {
                    google.maps.event.trigger(allMarkers[allMarkers.length - 1], 'click');
                } else {
                    google.maps.event.trigger(allMarkers[index - 1], 'click');
                }
            }
        });
		 
		
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);
        function ZoomControl(controlDiv, map) {
            zoomControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
            controlDiv.style.padding = '5px';
            var controlWrapper = document.createElement('div');
            controlDiv.appendChild(controlWrapper);
            var zoomInButton = document.createElement('div');
            zoomInButton.className = "mapzoom-in";
            controlWrapper.appendChild(zoomInButton);
            var zoomOutButton = document.createElement('div');
            zoomOutButton.className = "mapzoom-out";
            controlWrapper.appendChild(zoomOutButton);
			
            google.maps.event.addDomListener(zoomInButton, 'click', function () {
                map.setZoom(map.getZoom() + 1);
            });
            google.maps.event.addDomListener(zoomOutButton, 'click', function () {
                map.setZoom(map.getZoom() - 1);
            });
        }
}


}
/* =============================================================================
  GOOGLE MAP DATA
  ========================================================================== */	 
 
function ppt_maps_callback() {
    var acInputs = document.getElementsByClassName("autocomplete-input");
    for (var i = 0; i < acInputs.length; i++) {
        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
        autocomplete.inputId = acInputs[i].id;
    }
}

function cardextradata() {
    jQuery.fn.duplicate = function (a, b) {
        var c = [];
        for (var d = 0; d < a; d++) jQuery.merge(c, this.clone(b).get());
        return this.pushStack(c);
    };
    var cr = jQuery(".card-popup-raining"),
        sts = jQuery(".section-title-separator span");
    cr.each(function (cr) {
        var starcount = jQuery(this).attr("data-starrating");
        jQuery("<i class='fa fa-star'></i>").duplicate(starcount).prependTo(this);
    });
    sts.each(function (sts) {
        jQuery("<i class='fa fa-star'></i>").duplicate(3).prependTo(this);
    })
} 

 function locationData(locationURL, locationImg, locationTitle, locationAddress, locationPrice, locationStarRating) {
            return ('<div class="map-popup-wrap"><div class="map-popup"><div class="infoBox-close text-center"><i class="fa fa-times"></i></div><a href="' + locationURL + '" class="listing-img-content fl-wrap"><img src="' + locationImg + '" alt=""><span class="map-popup-location-price">' + locationPrice + '</span></a><div class="listing-content fl-wrap"><div class="listing-title fl-wrap"><h4><a href=' + locationURL + '>' + locationTitle + '</a></h4><span class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i>' + locationAddress + '</span></div></div></div></div>')

}   
	

/* =============================================================================
  GOOGLE LOCATION
  ========================================================================== */	 
  
function getCurrentLocation() {
	 
	 if (navigator.geolocation) {
	   
	   navigator.geolocation.getCurrentPosition(
        function(position) {
			 
            //do succes handling
			savePosition(position);
			
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
    console.log(t)
}

function savePosition(e) {	
	 
		
    jQuery.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + e.coords.latitude + "," + e.coords.longitude + "&key=" + ajax_googlemaps_key, {
        sensor: !1,
        latlng: e.coords.latitude + "," + e.coords.longitude
    }, function(t) {
		
		if(typeof t.results[0] != 'undefined'){
		 
			jQuery('#location-address').val(t.results[0].formatted_address);
			
			jQuery('#homesearchzip').val(t.results[0].formatted_address);
		
		}
		
		jQuery("#location-mylog").val(e.coords.longitude);
		jQuery("#location-mylat").val(e.coords.latitude);
		
    });
}