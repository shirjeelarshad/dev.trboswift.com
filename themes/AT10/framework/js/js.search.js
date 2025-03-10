jQuery(document).ready(function(){ 
								
	/*  OPEN SEARCH FILTERS */
	 jQuery('.openfilters .filter-content').each(function () {
		jQuery(this).addClass('show');
	});

});
/* =============================================================================
  SAVE SEARCH RESULTS
  ========================================================================== */

function savesearch_get(){

		jQuery("#savedsearcheshere").html('');	
   	  
       jQuery.ajax({
           type: "POST",
           url: ajax_site_url,
		   dataType: 'json',		
   			data: {
               action: "savesearch_get",   			 
           },
           success: function(response) {  
		   
		   		if(response.status == "ok"){
				
					jQuery("#savedsearcheshere").html(response.output);
				
				}					 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
}

function savesearch_go(id){
 
jQuery('#_filter_data').val(jQuery("#saveseachgo"+id).val());
_filter_newsearch();

}
function savesearch_remove(id){

		jQuery("#savedsearchdiv"+id).hide();	
   	  
       jQuery.ajax({
           type: "POST",	
           url: ajax_site_url,		
   			data: {
               action: "savesearch_remove",
   			   rid: id, 
           },
           success: function(response) { 
		   
           },
           error: function(e) {
               console.log(e)
           }
       });
}
function savedsearch_add(){
   	 	
	jQuery(".savesearchicon").removeClass('fa-star').addClass('fa-spinner');	
       jQuery.ajax({
           type: "POST",		  
           url: ajax_site_url,		
   			data: {
               action: "savesearch",
   			   details: jQuery('#_filter_data').val(), 
           },
           success: function(response) { 		   
				savesearch_get();   			
           },
           error: function(e) {
               console.log(e)
           }
       });
	   jQuery(".savesearchicon").removeClass('fa-spinner').addClass('fa-star');	
	    
   }

/* =============================================================================
  CUSTOM SEARCH CLASSES
  ========================================================================== */

function _updatecardlayout(thisone){
       jQuery('.filter_sortby.t2 a').removeClass('active');
       jQuery('.activex').addClass('active').removeClass('activex');
       jQuery('#filter-cardlayout').val(thisone)
       _filter_update();
}
function _updateselected(run){
 
	jQuery('.filter_sortby.t1 a:not(.show-mobile)').each(function () {
	
		if(jQuery(this).hasClass('active')){		
			 
			if(jQuery(this).hasClass('up')){
			
				jQuery(this).removeClass('up').addClass('down');
				jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-up-alt').addClass('ml-2 fa fa-sort-amount-down-alt');
				
				jQuery('#filter-sortby-main').val(jQuery(this).attr("data-key")+'-u');
				
			}else{
				jQuery(this).removeClass('down').addClass('up');
				jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-down-alt').addClass('ml-2 fa fa-sort-amount-up-alt');
				
				jQuery('#filter-sortby-main').val(jQuery(this).attr("data-key")+'-d');
			}
			 
			if(run == "yes"){
			_filter_update();
			}
			
		}else{
		
			jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-down-alt').removeClass('ml-2 fa fa-sort-amount-up-alt');
		}	
	
	}); 
 

}

jQuery(document).on("click",".filter_sortby.t1 a", function (e) {

 jQuery('.filter_sortby.t1 a').removeClass('active');
 jQuery(this).addClass('active');
 
 _updateselected('yes');

});  

jQuery(document).on("click",".filter_sortby_list .dropdown-item", function (e) {

	 
 jQuery('.filter_sortby_list .dropdown-item').removeClass('active');
 jQuery(this).addClass('active');
 
 _updateselectedlist('yes');

});

function _updateselectedlist(run){
 
	jQuery('.filter_sortby_list .dropdown-item').each(function () {
	
		if(jQuery(this).hasClass('active')){		
			 
			if(jQuery(this).hasClass('up')){
			
				jQuery(this).removeClass('up').addClass('down');
				jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-up-alt').addClass('ml-2 fa fa-sort-amount-down-alt');
				
				jQuery('#filter-sortby-main').val(jQuery(this).attr("data-key")+'-u');
				
			}else{
				jQuery(this).removeClass('down').addClass('up');
				jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-down-alt').addClass('ml-2 fa fa-sort-amount-up-alt');
				
				jQuery('#filter-sortby-main').val(jQuery(this).attr("data-key")+'-d');
			}
			 
			if(run == "yes"){
			_filter_update();
			}
			
		}else{
		
			jQuery(this).find('i').removeClass('ml-2 fa fa-sort-amount-down-alt').removeClass('ml-2 fa fa-sort-amount-up-alt');
		}	
	
	}); 

}

function _filter_update(){
	 
	jQuery('#_filter_data').val('');
	 
	var i = 1;
	jQuery('.customfilter').each(function(index,item){
										  
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
			jQuery('#_filter_data').val(jQuery('#_filter_data').val()+"["+key+':'+value+"]")
		}   
	  
		  i++;
	 }); 
	 	
 
	_filter_newsearch();
	
}



function _filter_page(pagenum){	
	
	jQuery('#_filter_data').val(jQuery('#_filter_data').val()+"[pagenum:"+pagenum+"]");
	 
	_filter_newsearch();	
}

function _filter_mapdata(){
 	
	
	jQuery(".dynamic_map").html("");
	
	jQuery('.new-search').each(function(i, obj) {		
		 
		
		var title 		= jQuery(obj).find('h3 a').text();	
		var url 		= jQuery(obj).find('h3 a').attr('href');
		var img 		= jQuery(obj).find('img').attr('src');
		 
		var pid 		= jQuery(obj).data('pid');		
		var lat 		= jQuery(obj).data('lat');
		var long 		= jQuery(obj).data('long');
		var address 	= jQuery(obj).data('address');
		 
		jQuery(".dynamic_map").html(jQuery(".dynamic_map").html() + '{"id": "'+pid+'", "url": "'+ url +'", "title": "'+ title +'", "img": "'+ img +'", "lat":"'+lat+'","long":"'+long+'","address":"'+address+'", "price":""  },');
						  
	});	
	
	// format
	jQuery(".dynamic_map").html('['+jQuery(".dynamic_map").html()+'{}]');
	
	
	mainMap();
	 
}

function _filter_newsearch(){
	 
	
	if(jQuery('#filterssidebox').length > 0){
		
	jQuery('#ajax-search-output').html('<tr><td  colspan=7><div class="text-center my-5 py-5 w-100"><i class="fa fa-spinner fa-5x fa-spin"></i></div></td></tr>');
 
	}else if(jQuery('#ajax-search-output').length > 0){
		
	jQuery('#ajax-search-output').html('<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
 
	}
	
	
	jQuery('#ajax-navbar-showhide').hide();
	
	jQuery.ajax({
        type: "POST",
        url: ajax_site_url,	
		dataType: 'json',	
		data: {
            search_action: "search",
			search_data: jQuery('#_filter_data').val(),
        },
        success: function(response) { 
			
			if(response.status == "ok"){
				
				if(response.sponsor == null){
					
					jQuery('#ajax-sponsor-output').html('');
					
				}else if(response.sponsor == "" || response.sponsor.length == 118 ){
					
					jQuery('#ajax-sponsor-output').html('');
				}else{
					jQuery('#ajax-sponsor-output').html(response.sponsor);	
				}
				 
				jQuery('#ajax-search-output').html(response.output);	
				jQuery('.ajax-search-pagenav').html(response.pagenav);
				jQuery('.ajax-search-found').html(response.total);	
				jQuery('.ajax-search-page').html(response.page);
				jQuery('.ajax-search-pageof').html(response.pageof);
				
				if(response.total == 0){
					jQuery('#noresults').show();
					jQuery('#ajax-navbar-showhide').hide();
					
				}else{
					jQuery('#noresults').hide();
					jQuery('#ajax-navbar-showhide').show();
				}
				
				if(response.location.address != null){
				jQuery('#ajax-search-location').html(response.location.address).addClass('p-2 border mt-3 small');
				}
				
				
				// MAP DATA
				if(jQuery('.search-mapside').length > 0){				
				_filter_mapdata();	
				}
				
				
				// FLEX IMAGES
				if(jQuery('.theme-ph').length > 0){
					
					jQuery('#ajax-search-output .stock-item').each(function() {																			
																			
						jQuery(this).attr('data-h',jQuery(this).find("img").attr('data-height'));
						jQuery(this).attr('data-w',jQuery(this).find("img").attr('data-width'));
					});
					
					jQuery('#ajax-search-output').flexImages({rowHeight: 350 });
				}
				
				// CLEAN UP
				if(jQuery('.shortcode_excerpt').length > 0){
					setTimeout(function(){
						jQuery(".shortcode_excerpt").each(function (a) {
																			
							 thistext = jQuery(this).text();
																			
							var m = thistext.match(/"(.*?)"/); 
							 
							if(m !== null ){								
								jQuery(this).html(m[1]);
								
							} else {
								
								thistext = thistext + '"';
								
								var m = thistext.match(/"(.*?)"/); 
								if(m !== null ){								
									jQuery(this).html(m[1]);
								}
								
								
							}
							
							 
						}); 
					}, 1000);
				
				}
				
				
				_filter_counterupdate();
				
				jQuery("input.rating").rating();
				
				jQuery('[data-toggle="tooltip"]').tooltip();
				
				if(jQuery('.home').length > 0){
					
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					
				}else{
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
				}
				
				if(jQuery('.countdowntimer').length > 0){					
						ppt_countdowns();
				}
				
				UpdatePrices();
				
				
				
				
  		 	
			}else{			
				jQuery('#ajax-search-output').html("Error trying to get results.");			
			}			
        },
        error: function(e) {
           console.log('error getting search results');
        }
    });
	
}

function _filter_counterupdate(){
 
	jQuery('.addcount .badge:not(.defaultvalue)').hide();
	
	jQuery('.addcount').append('<b class="badge badge-pill badge-secondary float-right novalue">0</b>');
	
	jQuery('.addcount').each(function(){
											   
		var id = this.id;	
		
		key = jQuery(this).data('countkey');
		 						
								
		if(jQuery('.'+ key).length > 50){
			
			jQuery(this).find('.novalue').html('50+');
		
		}else if(jQuery('.'+ key).length > 20){
			
			jQuery(this).find('.novalue').html('20+');
		
		}else if(jQuery('.'+ key).length > 0){
			
			jQuery(this).find('.novalue').html(jQuery('.'+ key).length);
		}
		
		
		if(jQuery('.'+ key).length > 0){
			
			jQuery(this).find('.novalue').removeClass('badge-secondary').addClass('badge-primary');
			
			jQuery(this).find('.defaultvalue').hide();
		}else{
			
			//if(key.indexOf('catid') !== -1) {
				
			//} else {
				
			jQuery(this).find('.novalue').hide();	
			jQuery(this).find('.defaultvalue').show();
			
			//}
		 		
		}
		
												  
	});
 
	jQuery('#ajax-sponsor-output .card-search').each(function () {		  
		
		var uid = jQuery(this).attr("data-pid");
	 	
		if(typeof uid !== "undefined"){
		
			jQuery('#ajax-search-output .card-search').each(function () {
																	   
				if(jQuery(this).attr("data-pid") == uid){
					jQuery(this).closest('.col-6').attr('style','display: none !important');
				}
			});
		
		}
		
	}); 		
	 
}


 
  
/* =============================================================================
 BOOTSTRAP SELECT
   ========================================================================== */
 
!function(e,t){void 0===e&&void 0!==window&&(e=window),"function"==typeof define&&define.amd?define(["jquery"],function(e){return t(e)}):"object"==typeof module&&module.exports?module.exports=t(require("jquery")):t(e.jQuery)}(this,function(e){!function(z){"use strict";var d=["sanitize","whiteList","sanitizeFn"],l=["background","cite","href","itemtype","longdesc","poster","src","xlink:href"],e={"*":["class","dir","id","lang","role","tabindex","style",/^aria-[\w-]*$/i],a:["target","href","title","rel"],area:[],b:[],br:[],col:[],code:[],div:[],em:[],hr:[],h1:[],h2:[],h3:[],h4:[],h5:[],h6:[],i:[],img:["src","alt","title","width","height"],li:[],ol:[],p:[],pre:[],s:[],small:[],span:[],sub:[],sup:[],strong:[],u:[],ul:[]},r=/^(?:(?:https?|mailto|ftp|tel|file):|[^&:/?#]*(?:[/?#]|$))/gi,a=/^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+/]+=*$/i;function v(e,t){var i=e.nodeName.toLowerCase();if(-1!==z.inArray(i,t))return-1===z.inArray(i,l)||Boolean(e.nodeValue.match(r)||e.nodeValue.match(a));for(var s=z(t).filter(function(e,t){return t instanceof RegExp}),n=0,o=s.length;n<o;n++)if(i.match(s[n]))return!0;return!1}function B(e,t,i){if(i&&"function"==typeof i)return i(e);for(var s=Object.keys(t),n=0,o=e.length;n<o;n++)for(var l=e[n].querySelectorAll("*"),r=0,a=l.length;r<a;r++){var c=l[r],d=c.nodeName.toLowerCase();if(-1!==s.indexOf(d))for(var h=[].slice.call(c.attributes),p=[].concat(t["*"]||[],t[d]||[]),u=0,f=h.length;u<f;u++){var m=h[u];v(m,p)||c.removeAttribute(m.nodeName)}else c.parentNode.removeChild(c)}}"classList"in document.createElement("_")||function(e){if("Element"in e){var t="classList",i="prototype",s=e.Element[i],n=Object,o=function(){var i=z(this);return{add:function(e){return e=Array.prototype.slice.call(arguments).join(" "),i.addClass(e)},remove:function(e){return e=Array.prototype.slice.call(arguments).join(" "),i.removeClass(e)},toggle:function(e,t){return i.toggleClass(e,t)},contains:function(e){return i.hasClass(e)}}};if(n.defineProperty){var l={get:o,enumerable:!0,configurable:!0};try{n.defineProperty(s,t,l)}catch(e){void 0!==e.number&&-2146823252!==e.number||(l.enumerable=!1,n.defineProperty(s,t,l))}}else n[i].__defineGetter__&&s.__defineGetter__(t,o)}}(window);var t,c,i,s=document.createElement("_");if(s.classList.add("c1","c2"),!s.classList.contains("c2")){var n=DOMTokenList.prototype.add,o=DOMTokenList.prototype.remove;DOMTokenList.prototype.add=function(){Array.prototype.forEach.call(arguments,n.bind(this))},DOMTokenList.prototype.remove=function(){Array.prototype.forEach.call(arguments,o.bind(this))}}if(s.classList.toggle("c3",!1),s.classList.contains("c3")){var h=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(e,t){return 1 in arguments&&!this.contains(e)==!t?t:h.call(this,e)}}function E(e){var t,i=[],s=e.selectedOptions;if(e.multiple)for(var n=0,o=s.length;n<o;n++)t=s[n],i.push(t.value||t.text);else i=e.value;return i}s=null,String.prototype.startsWith||(t=function(){try{var e={},t=Object.defineProperty,i=t(e,e,e)&&t}catch(e){}return i}(),c={}.toString,i=function(e){if(null==this)throw new TypeError;var t=String(this);if(e&&"[object RegExp]"==c.call(e))throw new TypeError;var i=t.length,s=String(e),n=s.length,o=1<arguments.length?arguments[1]:void 0,l=o?Number(o):0;l!=l&&(l=0);var r=Math.min(Math.max(l,0),i);if(i<n+r)return!1;for(var a=-1;++a<n;)if(t.charCodeAt(r+a)!=s.charCodeAt(a))return!1;return!0},t?t(String.prototype,"startsWith",{value:i,configurable:!0,writable:!0}):String.prototype.startsWith=i),Object.keys||(Object.keys=function(e,t,i){for(t in i=[],e)i.hasOwnProperty.call(e,t)&&i.push(t);return i}),HTMLSelectElement&&!HTMLSelectElement.prototype.hasOwnProperty("selectedOptions")&&Object.defineProperty(HTMLSelectElement.prototype,"selectedOptions",{get:function(){return this.querySelectorAll(":checked")}});var p={useDefault:!1,_set:z.valHooks.select.set};z.valHooks.select.set=function(e,t){return t&&!p.useDefault&&z(e).data("selected",!0),p._set.apply(this,arguments)};var C=null,u=function(){try{return new Event("change"),!0}catch(e){return!1}}();function $(e,t,i,s){for(var n=["display","subtext","tokens"],o=!1,l=0;l<n.length;l++){var r=n[l],a=e[r];if(a&&(a=a.toString(),"display"===r&&(a=a.replace(/<[^>]+>/g,"")),s&&(a=w(a)),a=a.toUpperCase(),o="contains"===i?0<=a.indexOf(t):a.startsWith(t)))break}return o}function L(e){return parseInt(e,10)||0}z.fn.triggerNative=function(e){var t,i=this[0];i.dispatchEvent?(u?t=new Event(e,{bubbles:!0}):(t=document.createEvent("Event")).initEvent(e,!0,!1),i.dispatchEvent(t)):i.fireEvent?((t=document.createEventObject()).eventType=e,i.fireEvent("on"+e,t)):this.trigger(e)};var f={"\xc0":"A","\xc1":"A","\xc2":"A","\xc3":"A","\xc4":"A","\xc5":"A","\xe0":"a","\xe1":"a","\xe2":"a","\xe3":"a","\xe4":"a","\xe5":"a","\xc7":"C","\xe7":"c","\xd0":"D","\xf0":"d","\xc8":"E","\xc9":"E","\xca":"E","\xcb":"E","\xe8":"e","\xe9":"e","\xea":"e","\xeb":"e","\xcc":"I","\xcd":"I","\xce":"I","\xcf":"I","\xec":"i","\xed":"i","\xee":"i","\xef":"i","\xd1":"N","\xf1":"n","\xd2":"O","\xd3":"O","\xd4":"O","\xd5":"O","\xd6":"O","\xd8":"O","\xf2":"o","\xf3":"o","\xf4":"o","\xf5":"o","\xf6":"o","\xf8":"o","\xd9":"U","\xda":"U","\xdb":"U","\xdc":"U","\xf9":"u","\xfa":"u","\xfb":"u","\xfc":"u","\xdd":"Y","\xfd":"y","\xff":"y","\xc6":"Ae","\xe6":"ae","\xde":"Th","\xfe":"th","\xdf":"ss","\u0100":"A","\u0102":"A","\u0104":"A","\u0101":"a","\u0103":"a","\u0105":"a","\u0106":"C","\u0108":"C","\u010a":"C","\u010c":"C","\u0107":"c","\u0109":"c","\u010b":"c","\u010d":"c","\u010e":"D","\u0110":"D","\u010f":"d","\u0111":"d","\u0112":"E","\u0114":"E","\u0116":"E","\u0118":"E","\u011a":"E","\u0113":"e","\u0115":"e","\u0117":"e","\u0119":"e","\u011b":"e","\u011c":"G","\u011e":"G","\u0120":"G","\u0122":"G","\u011d":"g","\u011f":"g","\u0121":"g","\u0123":"g","\u0124":"H","\u0126":"H","\u0125":"h","\u0127":"h","\u0128":"I","\u012a":"I","\u012c":"I","\u012e":"I","\u0130":"I","\u0129":"i","\u012b":"i","\u012d":"i","\u012f":"i","\u0131":"i","\u0134":"J","\u0135":"j","\u0136":"K","\u0137":"k","\u0138":"k","\u0139":"L","\u013b":"L","\u013d":"L","\u013f":"L","\u0141":"L","\u013a":"l","\u013c":"l","\u013e":"l","\u0140":"l","\u0142":"l","\u0143":"N","\u0145":"N","\u0147":"N","\u014a":"N","\u0144":"n","\u0146":"n","\u0148":"n","\u014b":"n","\u014c":"O","\u014e":"O","\u0150":"O","\u014d":"o","\u014f":"o","\u0151":"o","\u0154":"R","\u0156":"R","\u0158":"R","\u0155":"r","\u0157":"r","\u0159":"r","\u015a":"S","\u015c":"S","\u015e":"S","\u0160":"S","\u015b":"s","\u015d":"s","\u015f":"s","\u0161":"s","\u0162":"T","\u0164":"T","\u0166":"T","\u0163":"t","\u0165":"t","\u0167":"t","\u0168":"U","\u016a":"U","\u016c":"U","\u016e":"U","\u0170":"U","\u0172":"U","\u0169":"u","\u016b":"u","\u016d":"u","\u016f":"u","\u0171":"u","\u0173":"u","\u0174":"W","\u0175":"w","\u0176":"Y","\u0177":"y","\u0178":"Y","\u0179":"Z","\u017b":"Z","\u017d":"Z","\u017a":"z","\u017c":"z","\u017e":"z","\u0132":"IJ","\u0133":"ij","\u0152":"Oe","\u0153":"oe","\u0149":"'n","\u017f":"s"},m=/[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g,g=RegExp("[\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff\\u1ab0-\\u1aff\\u1dc0-\\u1dff]","g");function b(e){return f[e]}function w(e){return(e=e.toString())&&e.replace(m,b).replace(g,"")}var x,I,k,y,S,O=(x={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},I=function(e){return x[e]},k="(?:"+Object.keys(x).join("|")+")",y=RegExp(k),S=RegExp(k,"g"),function(e){return e=null==e?"":""+e,y.test(e)?e.replace(S,I):e}),T={32:" ",48:"0",49:"1",50:"2",51:"3",52:"4",53:"5",54:"6",55:"7",56:"8",57:"9",59:";",65:"A",66:"B",67:"C",68:"D",69:"E",70:"F",71:"G",72:"H",73:"I",74:"J",75:"K",76:"L",77:"M",78:"N",79:"O",80:"P",81:"Q",82:"R",83:"S",84:"T",85:"U",86:"V",87:"W",88:"X",89:"Y",90:"Z",96:"0",97:"1",98:"2",99:"3",100:"4",101:"5",102:"6",103:"7",104:"8",105:"9"},A=27,N=13,D=32,H=9,P=38,W=40,M={success:!1,major:"3"};try{M.full=(z.fn.dropdown.Constructor.VERSION||"").split(" ")[0].split("."),M.major=M.full[0],M.success=!0}catch(e){}var R=0,U=".bs.select",j={DISABLED:"disabled",DIVIDER:"divider",SHOW:"open",DROPUP:"dropup",MENU:"dropdown-menu",MENURIGHT:"dropdown-menu-right",MENULEFT:"dropdown-menu-left",BUTTONCLASS:"btn-default",POPOVERHEADER:"popover-title",ICONBASE:"glyphicon",TICKICON:"glyphicon-ok"},V={MENU:"."+j.MENU},F={span:document.createElement("span"),i:document.createElement("i"),subtext:document.createElement("small"),a:document.createElement("a"),li:document.createElement("li"),whitespace:document.createTextNode("\xa0"),fragment:document.createDocumentFragment()};F.a.setAttribute("role","option"),F.subtext.className="text-muted",F.text=F.span.cloneNode(!1),F.text.className="text",F.checkMark=F.span.cloneNode(!1);var _=new RegExp(P+"|"+W),q=new RegExp("^"+H+"$|"+A),G=function(e,t,i){var s=F.li.cloneNode(!1);return e&&(1===e.nodeType||11===e.nodeType?s.appendChild(e):s.innerHTML=e),void 0!==t&&""!==t&&(s.className=t),null!=i&&s.classList.add("optgroup-"+i),s},K=function(e,t,i){var s=F.a.cloneNode(!0);return e&&(11===e.nodeType?s.appendChild(e):s.insertAdjacentHTML("beforeend",e)),void 0!==t&&""!==t&&(s.className=t),"4"===M.major&&s.classList.add("dropdown-item"),i&&s.setAttribute("style",i),s},Y=function(e,t){var i,s,n=F.text.cloneNode(!1);if(e.content)n.innerHTML=e.content;else{if(n.textContent=e.text,e.icon){var o=F.whitespace.cloneNode(!1);(s=(!0===t?F.i:F.span).cloneNode(!1)).className=e.iconBase+" "+e.icon,F.fragment.appendChild(s),F.fragment.appendChild(o)}e.subtext&&((i=F.subtext.cloneNode(!1)).textContent=e.subtext,n.appendChild(i))}if(!0===t)for(;0<n.childNodes.length;)F.fragment.appendChild(n.childNodes[0]);else F.fragment.appendChild(n);return F.fragment},Z=function(e){var t,i,s=F.text.cloneNode(!1);if(s.innerHTML=e.label,e.icon){var n=F.whitespace.cloneNode(!1);(i=F.span.cloneNode(!1)).className=e.iconBase+" "+e.icon,F.fragment.appendChild(i),F.fragment.appendChild(n)}return e.subtext&&((t=F.subtext.cloneNode(!1)).textContent=e.subtext,s.appendChild(t)),F.fragment.appendChild(s),F.fragment},J=function(e,t){var i=this;p.useDefault||(z.valHooks.select.set=p._set,p.useDefault=!0),this.$element=z(e),this.$newElement=null,this.$button=null,this.$menu=null,this.options=t,this.selectpicker={main:{},current:{},search:{},view:{},keydown:{keyHistory:"",resetKeyHistory:{start:function(){return setTimeout(function(){i.selectpicker.keydown.keyHistory=""},800)}}}},null===this.options.title&&(this.options.title=this.$element.attr("title"));var s=this.options.windowPadding;"number"==typeof s&&(this.options.windowPadding=[s,s,s,s]),this.val=J.prototype.val,this.render=J.prototype.render,this.refresh=J.prototype.refresh,this.setStyle=J.prototype.setStyle,this.selectAll=J.prototype.selectAll,this.deselectAll=J.prototype.deselectAll,this.destroy=J.prototype.destroy,this.remove=J.prototype.remove,this.show=J.prototype.show,this.hide=J.prototype.hide,this.init()};function Q(e){var r,a=arguments,c=e;if([].shift.apply(a),!M.success){try{M.full=(z.fn.dropdown.Constructor.VERSION||"").split(" ")[0].split(".")}catch(e){J.BootstrapVersion?M.full=J.BootstrapVersion.split(" ")[0].split("."):(M.full=[M.major,"0","0"],console.warn("There was an issue retrieving Bootstrap's version. Ensure Bootstrap is being loaded before bootstrap-select and there is no namespace collision. If loading Bootstrap asynchronously, the version may need to be manually specified via $.fn.selectpicker.Constructor.BootstrapVersion.",e))}M.major=M.full[0],M.success=!0}if("4"===M.major){var t=[];J.DEFAULTS.style===j.BUTTONCLASS&&t.push({name:"style",className:"BUTTONCLASS"}),J.DEFAULTS.iconBase===j.ICONBASE&&t.push({name:"iconBase",className:"ICONBASE"}),J.DEFAULTS.tickIcon===j.TICKICON&&t.push({name:"tickIcon",className:"TICKICON"}),j.DIVIDER="dropdown-divider",j.SHOW="show",j.BUTTONCLASS="btn btn-ppt-select",j.POPOVERHEADER="popover-header",j.ICONBASE="",j.TICKICON="bs-ok-default";for(var i=0;i<t.length;i++){e=t[i];J.DEFAULTS[e.name]=j[e.className]}}var s=this.each(function(){var e=z(this);if(e.is("select")){var t=e.data("selectpicker"),i="object"==typeof c&&c;if(t){if(i)for(var s in i)i.hasOwnProperty(s)&&(t.options[s]=i[s])}else{var n=e.data();for(var o in n)n.hasOwnProperty(o)&&-1!==z.inArray(o,d)&&delete n[o];var l=z.extend({},J.DEFAULTS,z.fn.selectpicker.defaults||{},n,i);l.template=z.extend({},J.DEFAULTS.template,z.fn.selectpicker.defaults?z.fn.selectpicker.defaults.template:{},n.template,i.template),e.data("selectpicker",t=new J(this,l))}"string"==typeof c&&(r=t[c]instanceof Function?t[c].apply(t,a):t.options[c])}});return void 0!==r?r:s}J.VERSION="1.13.9",J.DEFAULTS={noneSelectedText:"",noneResultsText:"No results matched {0}",countSelectedText:function(e,t){return 1==e?"{0} item selected":"{0} items selected"},maxOptionsText:function(e,t){return[1==e?"Limit reached ({n} item max)":"Limit reached ({n} items max)",1==t?"Group limit reached ({n} item max)":"Group limit reached ({n} items max)"]},selectAllText:"titlemax",deselectAllText:"Detitlemax",doneButton:!1,doneButtonText:"Close",multipleSeparator:", ",styleBase:"btn",style:j.BUTTONCLASS,size:"auto",title:null,selectedTextFormat:"values",width:!1,container:!1,hideDisabled:!1,showSubtext:!1,showIcon:!0,showContent:!0,dropupAuto:!0,header:!1,liveSearch:!1,liveSearchPlaceholder:null,liveSearchNormalize:!1,liveSearchStyle:"contains",actionsBox:!1,iconBase:j.ICONBASE,tickIcon:j.TICKICON,showTick:!1,template:{caret:'<span class="caret"></span>'},maxOptions:!1,mobile:!1,selectOnTab:!1,dropdownAlignRight:!1,windowPadding:0,virtualScroll:600,display:!1,sanitize:!0,sanitizeFn:null,whiteList:e},J.prototype={constructor:J,init:function(){var i=this,e=this.$element.attr("id");this.selectId=R++,this.$element[0].classList.add("bs-select-hidden"),this.multiple=this.$element.prop("multiple"),this.autofocus=this.$element.prop("autofocus"),this.options.showTick=this.$element[0].classList.contains("show-tick"),this.$newElement=this.createDropdown(),this.$element.after(this.$newElement).prependTo(this.$newElement),this.$button=this.$newElement.children("button"),this.$menu=this.$newElement.children(V.MENU),this.$menuInner=this.$menu.children(".inner"),this.$searchbox=this.$menu.find("input"),this.$element[0].classList.remove("bs-select-hidden"),!0===this.options.dropdownAlignRight&&this.$menu[0].classList.add(j.MENURIGHT),void 0!==e&&this.$button.attr("data-id",e),this.checkDisabled(),this.clickListener(),this.options.liveSearch&&this.liveSearchListener(),this.setStyle(),this.render(),this.setWidth(),this.options.container?this.selectPosition():this.$element.on("hide"+U,function(){if(i.isVirtual()){var e=i.$menuInner[0],t=e.firstChild.cloneNode(!1);e.replaceChild(t,e.firstChild),e.scrollTop=0}}),this.$menu.data("this",this),this.$newElement.data("this",this),this.options.mobile&&this.mobile(),this.$newElement.on({"hide.bs.dropdown":function(e){i.$menuInner.attr("aria-expanded",!1),i.$element.trigger("hide"+U,e)},"hidden.bs.dropdown":function(e){i.$element.trigger("hidden"+U,e)},"show.bs.dropdown":function(e){i.$menuInner.attr("aria-expanded",!0),i.$element.trigger("show"+U,e)},"shown.bs.dropdown":function(e){i.$element.trigger("shown"+U,e)}}),i.$element[0].hasAttribute("required")&&this.$element.on("invalid"+U,function(){i.$button[0].classList.add("bs-invalid"),i.$element.on("shown"+U+".invalid",function(){i.$element.val(i.$element.val()).off("shown"+U+".invalid")}).on("rendered"+U,function(){this.validity.valid&&i.$button[0].classList.remove("bs-invalid"),i.$element.off("rendered"+U)}),i.$button.on("blur"+U,function(){i.$element.trigger("focus").trigger("blur"),i.$button.off("blur"+U)})}),setTimeout(function(){i.createLi(),i.$element.trigger("loaded"+U)})},createDropdown:function(){var e=this.multiple||this.options.showTick?" show-tick":"",t="",i=this.autofocus?" autofocus":"";M.major<4&&this.$element.parent().hasClass("input-group")&&(t=" input-group-btn");var s,n="",o="",l="",r="";return this.options.header&&(n='<div class="'+j.POPOVERHEADER+'"><button type="button" class="close" aria-hidden="true">&times;</button>'+this.options.header+"</div>"),this.options.liveSearch&&(o='<div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"'+(null===this.options.liveSearchPlaceholder?"":' placeholder="'+O(this.options.liveSearchPlaceholder)+'"')+' role="textbox" aria-label="Search"></div>'),this.multiple&&this.options.actionsBox&&(l='<div class="bs-actionsbox"><div class="btn-group btn-group-sm btn-block"><button type="button" class="actions-btn bs-select-all btn '+j.BUTTONCLASS+'">'+this.options.selectAllText+'</button><button type="button" class="actions-btn bs-deselect-all btn '+j.BUTTONCLASS+'">'+this.options.deselectAllText+"</button></div></div>"),this.multiple&&this.options.doneButton&&(r='<div class="bs-donebutton"><div class="btn-group btn-block"><button type="button" class="btn btn-sm '+j.BUTTONCLASS+'">'+this.options.doneButtonText+"</button></div></div>"),s='<div class="dropdown bootstrap-select'+e+t+'"><button type="button" class="'+this.options.styleBase+' dropdown-toggle" '+("static"===this.options.display?'data-display="static"':"")+'data-toggle="dropdown"'+i+' role="button"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner"></div></div> </div>'+("4"===M.major?"":'<span class="bs-caret">'+this.options.template.caret+"</span>")+'</button><div class="'+j.MENU+" "+("4"===M.major?"":j.SHOW)+'" role="combobox">'+n+o+l+'<div class="inner '+j.SHOW+'" role="listbox" aria-expanded="false" tabindex="-1"><ul class="'+j.MENU+" inner "+("4"===M.major?j.SHOW:"")+'"></ul></div>'+r+"</div></div>",z(s)},setPositionData:function(){this.selectpicker.view.canHighlight=[];for(var e=0;e<this.selectpicker.current.data.length;e++){var t=this.selectpicker.current.data[e],i=!0;"divider"===t.type?(i=!1,t.height=this.sizeInfo.dividerHeight):"optgroup-label"===t.type?(i=!1,t.height=this.sizeInfo.dropdownHeaderHeight):t.height=this.sizeInfo.liHeight,t.disabled&&(i=!1),this.selectpicker.view.canHighlight.push(i),t.position=(0===e?0:this.selectpicker.current.data[e-1].position)+t.height}},isVirtual:function(){return!1!==this.options.virtualScroll&&this.selectpicker.main.elements.length>=this.options.virtualScroll||!0===this.options.virtualScroll},createView:function(T,e){e=e||0;var A=this;this.selectpicker.current=T?this.selectpicker.search:this.selectpicker.main;var N,D,H=[];function i(e,t){var i,s,n,o,l,r,a,c,d,h,p=A.selectpicker.current.elements.length,u=[],f=!0,m=A.isVirtual();A.selectpicker.view.scrollTop=e,!0===m&&A.sizeInfo.hasScrollBar&&A.$menu[0].offsetWidth>A.sizeInfo.totalMenuWidth&&(A.sizeInfo.menuWidth=A.$menu[0].offsetWidth,A.sizeInfo.totalMenuWidth=A.sizeInfo.menuWidth+A.sizeInfo.scrollBarWidth,A.$menu.css("min-width",A.sizeInfo.menuWidth)),i=Math.ceil(A.sizeInfo.menuInnerHeight/A.sizeInfo.liHeight*1.5),s=Math.round(p/i)||1;for(var v=0;v<s;v++){var g=(v+1)*i;if(v===s-1&&(g=p),u[v]=[v*i+(v?1:0),g],!p)break;void 0===l&&e<=A.selectpicker.current.data[g-1].position-A.sizeInfo.menuInnerHeight&&(l=v)}if(void 0===l&&(l=0),r=[A.selectpicker.view.position0,A.selectpicker.view.position1],n=Math.max(0,l-1),o=Math.min(s-1,l+1),A.selectpicker.view.position0=!1===m?0:Math.max(0,u[n][0])||0,A.selectpicker.view.position1=!1===m?p:Math.min(p,u[o][1])||0,a=r[0]!==A.selectpicker.view.position0||r[1]!==A.selectpicker.view.position1,void 0!==A.activeIndex&&(D=A.selectpicker.main.elements[A.prevActiveIndex],H=A.selectpicker.main.elements[A.activeIndex],N=A.selectpicker.main.elements[A.selectedIndex],t&&(A.activeIndex!==A.selectedIndex&&H&&H.length&&(H.classList.remove("active"),H.firstChild&&H.firstChild.classList.remove("active")),A.activeIndex=void 0),A.activeIndex&&A.activeIndex!==A.selectedIndex&&N&&N.length&&(N.classList.remove("active"),N.firstChild&&N.firstChild.classList.remove("active"))),void 0!==A.prevActiveIndex&&A.prevActiveIndex!==A.activeIndex&&A.prevActiveIndex!==A.selectedIndex&&D&&D.length&&(D.classList.remove("active"),D.firstChild&&D.firstChild.classList.remove("active")),(t||a)&&(c=A.selectpicker.view.visibleElements?A.selectpicker.view.visibleElements.slice():[],A.selectpicker.view.visibleElements=!1===m?A.selectpicker.current.elements:A.selectpicker.current.elements.slice(A.selectpicker.view.position0,A.selectpicker.view.position1),A.setOptionStatus(),(T||!1===m&&t)&&(d=c,h=A.selectpicker.view.visibleElements,f=!(d.length===h.length&&d.every(function(e,t){return e===h[t]}))),(t||!0===m)&&f)){var b,w,x=A.$menuInner[0],I=document.createDocumentFragment(),k=x.firstChild.cloneNode(!1),$=A.selectpicker.view.visibleElements,y=[];x.replaceChild(k,x.firstChild);v=0;for(var S=$.length;v<S;v++){var E,C,O=$[v];A.options.sanitize&&(E=O.lastChild)&&(C=A.selectpicker.current.data[v+A.selectpicker.view.position0])&&C.content&&!C.sanitized&&(y.push(E),C.sanitized=!0),I.appendChild(O)}A.options.sanitize&&y.length&&B(y,A.options.whiteList,A.options.sanitizeFn),!0===m&&(b=0===A.selectpicker.view.position0?0:A.selectpicker.current.data[A.selectpicker.view.position0-1].position,w=A.selectpicker.view.position1>p-1?0:A.selectpicker.current.data[p-1].position-A.selectpicker.current.data[A.selectpicker.view.position1-1].position,x.firstChild.style.marginTop=b+"px",x.firstChild.style.marginBottom=w+"px"),x.firstChild.appendChild(I)}if(A.prevActiveIndex=A.activeIndex,A.options.liveSearch){if(T&&t){var z,L=0;A.selectpicker.view.canHighlight[L]||(L=1+A.selectpicker.view.canHighlight.slice(1).indexOf(!0)),z=A.selectpicker.view.visibleElements[L],A.selectpicker.view.currentActive&&(A.selectpicker.view.currentActive.classList.remove("active"),A.selectpicker.view.currentActive.firstChild&&A.selectpicker.view.currentActive.firstChild.classList.remove("active")),z&&(z.classList.add("active"),z.firstChild&&z.firstChild.classList.add("active")),A.activeIndex=(A.selectpicker.current.data[L]||{}).index}}else A.$menuInner.trigger("focus")}this.setPositionData(),i(e,!0),this.$menuInner.off("scroll.createView").on("scroll.createView",function(e,t){A.noScroll||i(this.scrollTop,t),A.noScroll=!1}),z(window).off("resize"+U+"."+this.selectId+".createView").on("resize"+U+"."+this.selectId+".createView",function(){A.$newElement.hasClass(j.SHOW)&&i(A.$menuInner[0].scrollTop)})},setPlaceholder:function(){var e=!1;if(this.options.title&&!this.multiple){this.selectpicker.view.titleOption||(this.selectpicker.view.titleOption=document.createElement("option")),e=!0;var t=this.$element[0],i=!1,s=!this.selectpicker.view.titleOption.parentNode;if(s)this.selectpicker.view.titleOption.className="bs-title-option",this.selectpicker.view.titleOption.value="",i=void 0===z(t.options[t.selectedIndex]).attr("selected")&&void 0===this.$element.data("selected");(s||0!==this.selectpicker.view.titleOption.index)&&t.insertBefore(this.selectpicker.view.titleOption,t.firstChild),i&&(t.selectedIndex=0)}return e},createLi:function(){var a=this,f=this.options.iconBase,m=':not([hidden]):not([data-hidden="true"])',v=[],g=[],c=0,b=0,e=this.setPlaceholder()?1:0;this.options.hideDisabled&&(m+=":not(:disabled)"),!a.options.showTick&&!a.multiple||F.checkMark.parentNode||(F.checkMark.className=f+" "+a.options.tickIcon+" check-mark",F.a.appendChild(F.checkMark));var t=this.$element[0].querySelectorAll("select > *"+m);function w(e){var t=g[g.length-1];t&&"divider"===t.type&&(t.optID||e.optID)||((e=e||{}).type="divider",v.push(G(!1,j.DIVIDER,e.optID?e.optID+"div":void 0)),g.push(e))}function x(e,t){if((t=t||{}).divider="true"===e.getAttribute("data-divider"),t.divider)w({optID:t.optID});else{var i=g.length,s=e.style.cssText,n=s?O(s):"",o=(e.className||"")+(t.optgroupClass||"");t.optID&&(o="opt "+o),t.text=e.textContent,t.content=e.getAttribute("data-content"),t.tokens=e.getAttribute("data-tokens"),t.subtext=e.getAttribute("data-subtext"),t.icon=e.getAttribute("data-icon"),t.iconBase=f;var l=Y(t);v.push(G(K(l,o,n),"",t.optID)),e.liIndex=i,t.display=t.content||t.text,t.type="option",t.index=i,t.option=e,t.disabled=t.disabled||e.disabled,g.push(t);var r=0;t.display&&(r+=t.display.length),t.subtext&&(r+=t.subtext.length),t.icon&&(r+=1),c<r&&(c=r,a.selectpicker.view.widestOption=v[v.length-1])}}function i(e,t){var i=t[e],s=t[e-1],n=t[e+1],o=i.querySelectorAll("option"+m);if(o.length){var l,r,a={label:O(i.label),subtext:i.getAttribute("data-subtext"),icon:i.getAttribute("data-icon"),iconBase:f},c=" "+(i.className||"");b++,s&&w({optID:b});var d=Z(a);v.push(G(d,"dropdown-header"+c,b)),g.push({display:a.label,subtext:a.subtext,type:"optgroup-label",optID:b});for(var h=0,p=o.length;h<p;h++){var u=o[h];0===h&&(r=(l=g.length-1)+p),x(u,{headerIndex:l,lastIndex:r,optID:b,optgroupClass:c,disabled:i.disabled})}n&&w({optID:b})}}for(var s=t.length;e<s;e++){var n=t[e];"OPTGROUP"!==n.tagName?x(n,{}):i(e,t)}this.selectpicker.main.elements=v,this.selectpicker.main.data=g,this.selectpicker.current=this.selectpicker.main},findLis:function(){return this.$menuInner.find(".inner > li")},render:function(){this.setPlaceholder();var e,t,i=this,s=this.$element[0].selectedOptions,n=s.length,o=this.$button[0],l=o.querySelector(".filter-option-inner-inner"),r=document.createTextNode(this.options.multipleSeparator),a=F.fragment.cloneNode(!1),c=!1;if(this.togglePlaceholder(),this.tabIndex(),"static"===this.options.selectedTextFormat)a=Y({text:this.options.title},!0);else if((e=this.multiple&&-1!==this.options.selectedTextFormat.indexOf("count")&&1<n)&&(e=1<(t=this.options.selectedTextFormat.split(">")).length&&n>t[1]||1===t.length&&2<=n),!1===e){for(var d=0;d<n&&d<50;d++){var h=s[d],p={},u={content:h.getAttribute("data-content"),subtext:h.getAttribute("data-subtext"),icon:h.getAttribute("data-icon")};this.multiple&&0<d&&a.appendChild(r.cloneNode(!1)),h.title?p.text=h.title:u.content&&i.options.showContent?(p.content=u.content.toString(),c=!0):(i.options.showIcon&&(p.icon=u.icon,p.iconBase=this.options.iconBase),i.options.showSubtext&&!i.multiple&&u.subtext&&(p.subtext=" "+u.subtext),p.text=h.textContent.trim()),a.appendChild(Y(p,!0))}49<n&&a.appendChild(document.createTextNode("..."))}else{var f=':not([hidden]):not([data-hidden="true"]):not([data-divider="true"])';this.options.hideDisabled&&(f+=":not(:disabled)");var m=this.$element[0].querySelectorAll("select > option"+f+", optgroup"+f+" option"+f).length,v="function"==typeof this.options.countSelectedText?this.options.countSelectedText(n,m):this.options.countSelectedText;a=Y({text:v.replace("{0}",n.toString()).replace("{1}",m.toString())},!0)}if(null==this.options.title&&(this.options.title=this.$element.attr("title")),a.childNodes.length||(a=Y({text:void 0!==this.options.title?this.options.title:this.options.noneSelectedText},!0)),o.title=a.textContent.replace(/<[^>]*>?/g,"").trim(),this.options.sanitize&&c&&B([a],i.options.whiteList,i.options.sanitizeFn),l.innerHTML="",l.appendChild(a),M.major<4&&this.$newElement[0].classList.contains("bs3-has-addon")){var g=o.querySelector(".filter-expand"),b=l.cloneNode(!0);b.className="filter-expand",g?o.replaceChild(b,g):o.appendChild(b)}this.$element.trigger("rendered"+U)},setStyle:function(e,t){var i,s=this.$button[0],n=this.$newElement[0],o=this.options.style.trim();this.$element.attr("class")&&this.$newElement.addClass(this.$element.attr("class").replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi,"")),M.major<4&&(n.classList.add("bs3"),n.parentNode.classList.contains("input-group")&&(n.previousElementSibling||n.nextElementSibling)&&(n.previousElementSibling||n.nextElementSibling).classList.contains("input-group-addon")&&n.classList.add("bs3-has-addon")),i=e?e.trim():o,"add"==t?i&&s.classList.add.apply(s.classList,i.split(" ")):"remove"==t?i&&s.classList.remove.apply(s.classList,i.split(" ")):(o&&s.classList.remove.apply(s.classList,o.split(" ")),i&&s.classList.add.apply(s.classList,i.split(" ")))},liHeight:function(e){if(e||!1!==this.options.size&&!this.sizeInfo){this.sizeInfo||(this.sizeInfo={});var t=document.createElement("div"),i=document.createElement("div"),s=document.createElement("div"),n=document.createElement("ul"),o=document.createElement("li"),l=document.createElement("li"),r=document.createElement("li"),a=document.createElement("a"),c=document.createElement("span"),d=this.options.header&&0<this.$menu.find("."+j.POPOVERHEADER).length?this.$menu.find("."+j.POPOVERHEADER)[0].cloneNode(!0):null,h=this.options.liveSearch?document.createElement("div"):null,p=this.options.actionsBox&&this.multiple&&0<this.$menu.find(".bs-actionsbox").length?this.$menu.find(".bs-actionsbox")[0].cloneNode(!0):null,u=this.options.doneButton&&this.multiple&&0<this.$menu.find(".bs-donebutton").length?this.$menu.find(".bs-donebutton")[0].cloneNode(!0):null,f=this.$element.find("option")[0];if(this.sizeInfo.selectWidth=this.$newElement[0].offsetWidth,c.className="text",a.className="dropdown-item "+(f?f.className:""),t.className=this.$menu[0].parentNode.className+" "+j.SHOW,t.style.width=this.sizeInfo.selectWidth+"px","auto"===this.options.width&&(i.style.minWidth=0),i.className=j.MENU+" "+j.SHOW,s.className="inner "+j.SHOW,n.className=j.MENU+" inner "+("4"===M.major?j.SHOW:""),o.className=j.DIVIDER,l.className="dropdown-header",c.appendChild(document.createTextNode("\u200b")),a.appendChild(c),r.appendChild(a),l.appendChild(c.cloneNode(!0)),this.selectpicker.view.widestOption&&n.appendChild(this.selectpicker.view.widestOption.cloneNode(!0)),n.appendChild(r),n.appendChild(o),n.appendChild(l),d&&i.appendChild(d),h){var m=document.createElement("input");h.className="bs-searchbox",m.className="form-control",h.appendChild(m),i.appendChild(h)}p&&i.appendChild(p),s.appendChild(n),i.appendChild(s),u&&i.appendChild(u),t.appendChild(i),document.body.appendChild(t);var v,g=r.offsetHeight,b=l?l.offsetHeight:0,w=d?d.offsetHeight:0,x=h?h.offsetHeight:0,I=p?p.offsetHeight:0,k=u?u.offsetHeight:0,$=z(o).outerHeight(!0),y=!!window.getComputedStyle&&window.getComputedStyle(i),S=i.offsetWidth,E=y?null:z(i),C={vert:L(y?y.paddingTop:E.css("paddingTop"))+L(y?y.paddingBottom:E.css("paddingBottom"))+L(y?y.borderTopWidth:E.css("borderTopWidth"))+L(y?y.borderBottomWidth:E.css("borderBottomWidth")),horiz:L(y?y.paddingLeft:E.css("paddingLeft"))+L(y?y.paddingRight:E.css("paddingRight"))+L(y?y.borderLeftWidth:E.css("borderLeftWidth"))+L(y?y.borderRightWidth:E.css("borderRightWidth"))},O={vert:C.vert+L(y?y.marginTop:E.css("marginTop"))+L(y?y.marginBottom:E.css("marginBottom"))+2,horiz:C.horiz+L(y?y.marginLeft:E.css("marginLeft"))+L(y?y.marginRight:E.css("marginRight"))+2};s.style.overflowY="scroll",v=i.offsetWidth-S,document.body.removeChild(t),this.sizeInfo.liHeight=g,this.sizeInfo.dropdownHeaderHeight=b,this.sizeInfo.headerHeight=w,this.sizeInfo.searchHeight=x,this.sizeInfo.actionsHeight=I,this.sizeInfo.doneButtonHeight=k,this.sizeInfo.dividerHeight=$,this.sizeInfo.menuPadding=C,this.sizeInfo.menuExtras=O,this.sizeInfo.menuWidth=S,this.sizeInfo.totalMenuWidth=this.sizeInfo.menuWidth,this.sizeInfo.scrollBarWidth=v,this.sizeInfo.selectHeight=this.$newElement[0].offsetHeight,this.setPositionData()}},getSelectPosition:function(){var e,t=z(window),i=this.$newElement.offset(),s=z(this.options.container);this.options.container&&s.length&&!s.is("body")?((e=s.offset()).top+=parseInt(s.css("borderTopWidth")),e.left+=parseInt(s.css("borderLeftWidth"))):e={top:0,left:0};var n=this.options.windowPadding;this.sizeInfo.selectOffsetTop=i.top-e.top-t.scrollTop(),this.sizeInfo.selectOffsetBot=t.height()-this.sizeInfo.selectOffsetTop-this.sizeInfo.selectHeight-e.top-n[2],this.sizeInfo.selectOffsetLeft=i.left-e.left-t.scrollLeft(),this.sizeInfo.selectOffsetRight=t.width()-this.sizeInfo.selectOffsetLeft-this.sizeInfo.selectWidth-e.left-n[1],this.sizeInfo.selectOffsetTop-=n[0],this.sizeInfo.selectOffsetLeft-=n[3]},setMenuSize:function(e){this.getSelectPosition();var t,i,s,n,o,l,r,a=this.sizeInfo.selectWidth,c=this.sizeInfo.liHeight,d=this.sizeInfo.headerHeight,h=this.sizeInfo.searchHeight,p=this.sizeInfo.actionsHeight,u=this.sizeInfo.doneButtonHeight,f=this.sizeInfo.dividerHeight,m=this.sizeInfo.menuPadding,v=0;if(this.options.dropupAuto&&(r=c*this.selectpicker.current.elements.length+m.vert,this.$newElement.toggleClass(j.DROPUP,this.sizeInfo.selectOffsetTop-this.sizeInfo.selectOffsetBot>this.sizeInfo.menuExtras.vert&&r+this.sizeInfo.menuExtras.vert+50>this.sizeInfo.selectOffsetBot)),"auto"===this.options.size)n=3<this.selectpicker.current.elements.length?3*this.sizeInfo.liHeight+this.sizeInfo.menuExtras.vert-2:0,i=this.sizeInfo.selectOffsetBot-this.sizeInfo.menuExtras.vert,s=n+d+h+p+u,l=Math.max(n-m.vert,0),this.$newElement.hasClass(j.DROPUP)&&(i=this.sizeInfo.selectOffsetTop-this.sizeInfo.menuExtras.vert),t=(o=i)-d-h-p-u-m.vert;else if(this.options.size&&"auto"!=this.options.size&&this.selectpicker.current.elements.length>this.options.size){for(var g=0;g<this.options.size;g++)"divider"===this.selectpicker.current.data[g].type&&v++;t=(i=c*this.options.size+v*f+m.vert)-m.vert,o=i+d+h+p+u,s=l=""}"auto"===this.options.dropdownAlignRight&&this.$menu.toggleClass(j.MENURIGHT,this.sizeInfo.selectOffsetLeft>this.sizeInfo.selectOffsetRight&&this.sizeInfo.selectOffsetRight<this.sizeInfo.totalMenuWidth-a),this.$menu.css({"max-height":o+"px",overflow:"hidden","min-height":s+"px"}),this.$menuInner.css({"max-height":t+"px","overflow-y":"auto","min-height":l+"px"}),this.sizeInfo.menuInnerHeight=Math.max(t,1),this.selectpicker.current.data.length&&this.selectpicker.current.data[this.selectpicker.current.data.length-1].position>this.sizeInfo.menuInnerHeight&&(this.sizeInfo.hasScrollBar=!0,this.sizeInfo.totalMenuWidth=this.sizeInfo.menuWidth+this.sizeInfo.scrollBarWidth,this.$menu.css("min-width",this.sizeInfo.totalMenuWidth)),this.dropdown&&this.dropdown._popper&&this.dropdown._popper.update()},setSize:function(e){if(this.liHeight(e),this.options.header&&this.$menu.css("padding-top",0),!1!==this.options.size){var t,i=this,s=z(window),n=0;if(this.setMenuSize(),this.options.liveSearch&&this.$searchbox.off("input.setMenuSize propertychange.setMenuSize").on("input.setMenuSize propertychange.setMenuSize",function(){return i.setMenuSize()}),"auto"===this.options.size?s.off("resize"+U+"."+this.selectId+".setMenuSize scroll"+U+"."+this.selectId+".setMenuSize").on("resize"+U+"."+this.selectId+".setMenuSize scroll"+U+"."+this.selectId+".setMenuSize",function(){return i.setMenuSize()}):this.options.size&&"auto"!=this.options.size&&this.selectpicker.current.elements.length>this.options.size&&s.off("resize"+U+"."+this.selectId+".setMenuSize scroll"+U+"."+this.selectId+".setMenuSize"),e)n=this.$menuInner[0].scrollTop;else if(!i.multiple){var o=i.$element[0];"number"==typeof(t=(o.options[o.selectedIndex]||{}).liIndex)&&!1!==i.options.size&&(n=(n=i.sizeInfo.liHeight*t)-i.sizeInfo.menuInnerHeight/2+i.sizeInfo.liHeight/2)}i.createView(!1,n)}},setWidth:function(){var i=this;"auto"===this.options.width?requestAnimationFrame(function(){i.$menu.css("min-width","0"),i.$element.on("loaded"+U,function(){i.liHeight(),i.setMenuSize();var e=i.$newElement.clone().appendTo("body"),t=e.css("width","auto").children("button").outerWidth();e.remove(),i.sizeInfo.selectWidth=Math.max(i.sizeInfo.totalMenuWidth,t),i.$newElement.css("width",i.sizeInfo.selectWidth+"px")})}):"fit"===this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width","").addClass("fit-width")):this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width",this.options.width)):(this.$menu.css("min-width",""),this.$newElement.css("width","")),this.$newElement.hasClass("fit-width")&&"fit"!==this.options.width&&this.$newElement[0].classList.remove("fit-width")},selectPosition:function(){this.$bsContainer=z('<div class="bs-container" />');var s,n,o,l=this,r=z(this.options.container),e=function(e){var t={},i=l.options.display||!!z.fn.dropdown.Constructor.Default&&z.fn.dropdown.Constructor.Default.display;l.$bsContainer.addClass(e.attr("class").replace(/form-control|fit-width/gi,"")).toggleClass(j.DROPUP,e.hasClass(j.DROPUP)),s=e.offset(),r.is("body")?n={top:0,left:0}:((n=r.offset()).top+=parseInt(r.css("borderTopWidth"))-r.scrollTop(),n.left+=parseInt(r.css("borderLeftWidth"))-r.scrollLeft()),o=e.hasClass(j.DROPUP)?0:e[0].offsetHeight,(M.major<4||"static"===i)&&(t.top=s.top-n.top+o,t.left=s.left-n.left),t.width=e[0].offsetWidth,l.$bsContainer.css(t)};this.$button.on("click.bs.dropdown.data-api",function(){l.isDisabled()||(e(l.$newElement),l.$bsContainer.appendTo(l.options.container).toggleClass(j.SHOW,!l.$button.hasClass(j.SHOW)).append(l.$menu))}),z(window).off("resize"+U+"."+this.selectId+" scroll"+U+"."+this.selectId).on("resize"+U+"."+this.selectId+" scroll"+U+"."+this.selectId,function(){l.$newElement.hasClass(j.SHOW)&&e(l.$newElement)}),this.$element.on("hide"+U,function(){l.$menu.data("height",l.$menu.height()),l.$bsContainer.detach()})},setOptionStatus:function(){var e=this;if(e.noScroll=!1,e.selectpicker.view.visibleElements&&e.selectpicker.view.visibleElements.length)for(var t=0;t<e.selectpicker.view.visibleElements.length;t++){var i=e.selectpicker.current.data[t+e.selectpicker.view.position0],s=i.option;s&&(e.setDisabled(i.index,i.disabled),e.setSelected(i.index,s.selected))}},setSelected:function(e,t){var i,s,n=this.selectpicker.main.elements[e],o=this.selectpicker.main.data[e],l=void 0!==this.activeIndex,r=this.activeIndex===e||t&&!this.multiple&&!l;o.selected=t,s=n.firstChild,t&&(this.selectedIndex=e),n.classList.toggle("selected",t),n.classList.toggle("active",r),r&&(this.selectpicker.view.currentActive=n,this.activeIndex=e),s&&(s.classList.toggle("selected",t),s.classList.toggle("active",r),s.setAttribute("aria-selected",t)),r||!l&&t&&void 0!==this.prevActiveIndex&&((i=this.selectpicker.main.elements[this.prevActiveIndex]).classList.remove("active"),i.firstChild&&i.firstChild.classList.remove("active"))},setDisabled:function(e,t){var i,s=this.selectpicker.main.elements[e];this.selectpicker.main.data[e].disabled=t,i=s.firstChild,s.classList.toggle(j.DISABLED,t),i&&("4"===M.major&&i.classList.toggle(j.DISABLED,t),i.setAttribute("aria-disabled",t),t?i.setAttribute("tabindex",-1):i.setAttribute("tabindex",0))},isDisabled:function(){return this.$element[0].disabled},checkDisabled:function(){var e=this;this.isDisabled()?(this.$newElement[0].classList.add(j.DISABLED),this.$button.addClass(j.DISABLED).attr("tabindex",-1).attr("aria-disabled",!0)):(this.$button[0].classList.contains(j.DISABLED)&&(this.$newElement[0].classList.remove(j.DISABLED),this.$button.removeClass(j.DISABLED).attr("aria-disabled",!1)),-1!=this.$button.attr("tabindex")||this.$element.data("tabindex")||this.$button.removeAttr("tabindex")),this.$button.on("click",function(){return!e.isDisabled()})},togglePlaceholder:function(){var e=this.$element[0],t=e.selectedIndex,i=-1===t;i||e.options[t].value||(i=!0),this.$button.toggleClass("bs-placeholder",i)},tabIndex:function(){this.$element.data("tabindex")!==this.$element.attr("tabindex")&&-98!==this.$element.attr("tabindex")&&"-98"!==this.$element.attr("tabindex")&&(this.$element.data("tabindex",this.$element.attr("tabindex")),this.$button.attr("tabindex",this.$element.data("tabindex"))),this.$element.attr("tabindex",-98)},clickListener:function(){var S=this,t=z(document);function e(){S.options.liveSearch?S.$searchbox.trigger("focus"):S.$menuInner.trigger("focus")}function i(){S.dropdown&&S.dropdown._popper&&S.dropdown._popper.state.isCreated?e():requestAnimationFrame(i)}t.data("spaceSelect",!1),this.$button.on("keyup",function(e){/(32)/.test(e.keyCode.toString(10))&&t.data("spaceSelect")&&(e.preventDefault(),t.data("spaceSelect",!1))}),this.$newElement.on("show.bs.dropdown",function(){3<M.major&&!S.dropdown&&(S.dropdown=S.$button.data("bs.dropdown"),S.dropdown._menu=S.$menu[0])}),this.$button.on("click.bs.dropdown.data-api",function(){S.$newElement.hasClass(j.SHOW)||S.setSize()}),this.$element.on("shown"+U,function(){S.$menuInner[0].scrollTop!==S.selectpicker.view.scrollTop&&(S.$menuInner[0].scrollTop=S.selectpicker.view.scrollTop),3<M.major?requestAnimationFrame(i):e()}),this.$menuInner.on("click","li a",function(e,t){var i=z(this),s=S.isVirtual()?S.selectpicker.view.position0:0,n=S.selectpicker.current.data[i.parent().index()+s],o=n.index,l=E(S.$element[0]),r=S.$element.prop("selectedIndex"),a=!0;if(S.multiple&&1!==S.options.maxOptions&&e.stopPropagation(),e.preventDefault(),!S.isDisabled()&&!i.parent().hasClass(j.DISABLED)){var c=S.$element.find("option"),d=n.option,h=z(d),p=d.selected,u=h.parent("optgroup"),f=u.find("option"),m=S.options.maxOptions,v=u.data("maxOptions")||!1;if(o===S.activeIndex&&(t=!0),t||(S.prevActiveIndex=S.activeIndex,S.activeIndex=void 0),S.multiple){if(d.selected=!p,S.setSelected(o,!p),i.trigger("blur"),!1!==m||!1!==v){var g=m<c.filter(":selected").length,b=v<u.find("option:selected").length;if(m&&g||v&&b)if(m&&1==m){c.prop("selected",!1),h.prop("selected",!0);for(var w=0;w<c.length;w++)S.setSelected(w,!1);S.setSelected(o,!0)}else if(v&&1==v){u.find("option:selected").prop("selected",!1),h.prop("selected",!0);for(w=0;w<f.length;w++){d=f[w];S.setSelected(c.index(d),!1)}S.setSelected(o,!0)}else{var x="string"==typeof S.options.maxOptionsText?[S.options.maxOptionsText,S.options.maxOptionsText]:S.options.maxOptionsText,I="function"==typeof x?x(m,v):x,k=I[0].replace("{n}",m),$=I[1].replace("{n}",v),y=z('<div class="notify"></div>');I[2]&&(k=k.replace("{var}",I[2][1<m?0:1]),$=$.replace("{var}",I[2][1<v?0:1])),h.prop("selected",!1),S.$menu.append(y),m&&g&&(y.append(z("<div>"+k+"</div>")),a=!1,S.$element.trigger("maxReached"+U)),v&&b&&(y.append(z("<div>"+$+"</div>")),a=!1,S.$element.trigger("maxReachedGrp"+U)),setTimeout(function(){S.setSelected(o,!1)},10),y.delay(750).fadeOut(300,function(){z(this).remove()})}}}else c.prop("selected",!1),d.selected=!0,S.setSelected(o,!0);!S.multiple||S.multiple&&1===S.options.maxOptions?S.$button.trigger("focus"):S.options.liveSearch&&S.$searchbox.trigger("focus"),a&&(l!=E(S.$element[0])&&S.multiple||r!=S.$element.prop("selectedIndex")&&!S.multiple)&&(C=[d.index,h.prop("selected"),l],S.$element.triggerNative("change"))}}),this.$menu.on("click","li."+j.DISABLED+" a, ."+j.POPOVERHEADER+", ."+j.POPOVERHEADER+" :not(.close)",function(e){e.currentTarget==this&&(e.preventDefault(),e.stopPropagation(),S.options.liveSearch&&!z(e.target).hasClass("close")?S.$searchbox.trigger("focus"):S.$button.trigger("focus"))}),this.$menuInner.on("click",".divider, .dropdown-header",function(e){e.preventDefault(),e.stopPropagation(),S.options.liveSearch?S.$searchbox.trigger("focus"):S.$button.trigger("focus")}),this.$menu.on("click","."+j.POPOVERHEADER+" .close",function(){S.$button.trigger("click")}),this.$searchbox.on("click",function(e){e.stopPropagation()}),this.$menu.on("click",".actions-btn",function(e){S.options.liveSearch?S.$searchbox.trigger("focus"):S.$button.trigger("focus"),e.preventDefault(),e.stopPropagation(),z(this).hasClass("bs-select-all")?S.selectAll():S.deselectAll()}),this.$element.on("change"+U,function(){S.render(),S.$element.trigger("changed"+U,C),C=null}).on("focus"+U,function(){S.options.mobile||S.$button.trigger("focus")})},liveSearchListener:function(){var u=this,f=document.createElement("li");this.$button.on("click.bs.dropdown.data-api",function(){u.$searchbox.val()&&u.$searchbox.val("")}),this.$searchbox.on("click.bs.dropdown.data-api focus.bs.dropdown.data-api touchend.bs.dropdown.data-api",function(e){e.stopPropagation()}),this.$searchbox.on("input propertychange",function(){var e=u.$searchbox.val();if(u.selectpicker.search.elements=[],u.selectpicker.search.data=[],e){var t=[],i=e.toUpperCase(),s={},n=[],o=u._searchStyle(),l=u.options.liveSearchNormalize;l&&(i=w(i)),u._$lisSelected=u.$menuInner.find(".selected");for(var r=0;r<u.selectpicker.main.data.length;r++){var a=u.selectpicker.main.data[r];s[r]||(s[r]=$(a,i,o,l)),s[r]&&void 0!==a.headerIndex&&-1===n.indexOf(a.headerIndex)&&(0<a.headerIndex&&(s[a.headerIndex-1]=!0,n.push(a.headerIndex-1)),s[a.headerIndex]=!0,n.push(a.headerIndex),s[a.lastIndex+1]=!0),s[r]&&"optgroup-label"!==a.type&&n.push(r)}r=0;for(var c=n.length;r<c;r++){var d=n[r],h=n[r-1],p=(a=u.selectpicker.main.data[d],u.selectpicker.main.data[h]);("divider"!==a.type||"divider"===a.type&&p&&"divider"!==p.type&&c-1!==r)&&(u.selectpicker.search.data.push(a),t.push(u.selectpicker.main.elements[d]))}u.activeIndex=void 0,u.noScroll=!0,u.$menuInner.scrollTop(0),u.selectpicker.search.elements=t,u.createView(!0),t.length||(f.className="no-results",f.innerHTML=u.options.noneResultsText.replace("{0}",'"'+O(e)+'"'),u.$menuInner[0].firstChild.appendChild(f))}else u.$menuInner.scrollTop(0),u.createView(!1)})},_searchStyle:function(){return this.options.liveSearchStyle||"contains"},val:function(e){if(void 0===e)return this.$element.val();var t=E(this.$element[0]);return C=[null,null,t],this.$element.val(e).trigger("changed"+U,C),this.render(),C=null,this.$element},changeAll:function(e){if(this.multiple){void 0===e&&(e=!0);var t=this.$element[0],i=0,s=0,n=E(t);t.classList.add("bs-select-hidden");for(var o=0,l=this.selectpicker.current.elements.length;o<l;o++){var r=this.selectpicker.current.data[o],a=r.option;a&&!r.disabled&&"divider"!==r.type&&(r.selected&&i++,(a.selected=e)&&s++)}t.classList.remove("bs-select-hidden"),i!==s&&(this.setOptionStatus(),this.togglePlaceholder(),C=[null,null,n],this.$element.triggerNative("change"))}},selectAll:function(){return this.changeAll(!0)},deselectAll:function(){return this.changeAll(!1)},toggle:function(e){(e=e||window.event)&&e.stopPropagation(),this.$button.trigger("click.bs.dropdown.data-api")},keydown:function(e){var t,i,s,n,o,l=z(this),r=l.hasClass("dropdown-toggle"),a=(r?l.closest(".dropdown"):l.closest(V.MENU)).data("this"),c=a.findLis(),d=!1,h=e.which===H&&!r&&!a.options.selectOnTab,p=_.test(e.which)||h,u=a.$menuInner[0].scrollTop,f=a.isVirtual(),m=!0===f?a.selectpicker.view.position0:0;if(!(i=a.$newElement.hasClass(j.SHOW))&&(p||48<=e.which&&e.which<=57||96<=e.which&&e.which<=105||65<=e.which&&e.which<=90)&&(a.$button.trigger("click.bs.dropdown.data-api"),a.options.liveSearch))a.$searchbox.trigger("focus");else{if(e.which===A&&i&&(e.preventDefault(),a.$button.trigger("click.bs.dropdown.data-api").trigger("focus")),p){if(!c.length)return;void 0===(t=!0===f?c.index(c.filter(".active")):a.activeIndex)&&(t=-1),-1!==t&&((s=a.selectpicker.current.elements[t+m]).classList.remove("active"),s.firstChild&&s.firstChild.classList.remove("active")),e.which===P?(-1!==t&&t--,t+m<0&&(t+=c.length),a.selectpicker.view.canHighlight[t+m]||-1===(t=a.selectpicker.view.canHighlight.slice(0,t+m).lastIndexOf(!0)-m)&&(t=c.length-1)):(e.which===W||h)&&(++t+m>=a.selectpicker.view.canHighlight.length&&(t=0),a.selectpicker.view.canHighlight[t+m]||(t=t+1+a.selectpicker.view.canHighlight.slice(t+m+1).indexOf(!0))),e.preventDefault();var v=m+t;e.which===P?0===m&&t===c.length-1?(a.$menuInner[0].scrollTop=a.$menuInner[0].scrollHeight,v=a.selectpicker.current.elements.length-1):d=(o=(n=a.selectpicker.current.data[v]).position-n.height)<u:(e.which===W||h)&&(0===t?v=a.$menuInner[0].scrollTop=0:d=u<(o=(n=a.selectpicker.current.data[v]).position-a.sizeInfo.menuInnerHeight)),(s=a.selectpicker.current.elements[v])&&(s.classList.add("active"),s.firstChild&&s.firstChild.classList.add("active")),a.activeIndex=a.selectpicker.current.data[v].index,a.selectpicker.view.currentActive=s,d&&(a.$menuInner[0].scrollTop=o),a.options.liveSearch?a.$searchbox.trigger("focus"):l.trigger("focus")}else if(!l.is("input")&&!q.test(e.which)||e.which===D&&a.selectpicker.keydown.keyHistory){var g,b,w=[];e.preventDefault(),a.selectpicker.keydown.keyHistory+=T[e.which],a.selectpicker.keydown.resetKeyHistory.cancel&&clearTimeout(a.selectpicker.keydown.resetKeyHistory.cancel),a.selectpicker.keydown.resetKeyHistory.cancel=a.selectpicker.keydown.resetKeyHistory.start(),b=a.selectpicker.keydown.keyHistory,/^(.)\1+$/.test(b)&&(b=b.charAt(0));for(var x=0;x<a.selectpicker.current.data.length;x++){var I=a.selectpicker.current.data[x];$(I,b,"startsWith",!0)&&a.selectpicker.view.canHighlight[x]&&w.push(I.index)}if(w.length){var k=0;c.removeClass("active").find("a").removeClass("active"),1===b.length&&(-1===(k=w.indexOf(a.activeIndex))||k===w.length-1?k=0:k++),g=w[k],d=0<u-(n=a.selectpicker.main.data[g]).position?(o=n.position-n.height,!0):(o=n.position-a.sizeInfo.menuInnerHeight,n.position>u+a.sizeInfo.menuInnerHeight),(s=a.selectpicker.main.elements[g]).classList.add("active"),s.firstChild&&s.firstChild.classList.add("active"),a.activeIndex=w[k],s.firstChild.focus(),d&&(a.$menuInner[0].scrollTop=o),l.trigger("focus")}}i&&(e.which===D&&!a.selectpicker.keydown.keyHistory||e.which===N||e.which===H&&a.options.selectOnTab)&&(e.which!==D&&e.preventDefault(),a.options.liveSearch&&e.which===D||(a.$menuInner.find(".active a").trigger("click",!0),l.trigger("focus"),a.options.liveSearch||(e.preventDefault(),z(document).data("spaceSelect",!0))))}},mobile:function(){this.$element[0].classList.add("mobile-device")},refresh:function(){var e=z.extend({},this.options,this.$element.data());this.options=e,this.checkDisabled(),this.setStyle(),this.render(),this.createLi(),this.setWidth(),this.setSize(!0),this.$element.trigger("refreshed"+U)},hide:function(){this.$newElement.hide()},show:function(){this.$newElement.show()},remove:function(){this.$newElement.remove(),this.$element.remove()},destroy:function(){this.$newElement.before(this.$element).remove(),this.$bsContainer?this.$bsContainer.remove():this.$menu.remove(),this.$element.off(U).removeData("selectpicker").removeClass("bs-select-hidden selectpicker"),z(window).off(U+"."+this.selectId)}};var X=z.fn.selectpicker;z.fn.selectpicker=Q,z.fn.selectpicker.Constructor=J,z.fn.selectpicker.noConflict=function(){return z.fn.selectpicker=X,this},z(document).off("keydown.bs.dropdown.data-api").on("keydown"+U,'.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input',J.prototype.keydown).on("focusin.modal",'.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input',function(e){e.stopPropagation()}),z(window).on("load"+U+".data-api",function(){z(".selectpicker").each(function(){var e=z(this);Q.call(e,e.data())})})}(e)});