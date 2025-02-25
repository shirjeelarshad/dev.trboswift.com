 																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														
(function($){$.formatCurrency={};$.formatCurrency.regions=[];$.formatCurrency.regions[""]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:true};
$.fn.formatCurrency=function(destination,settings){if(arguments.length==1&&typeof destination!=="string"){settings=destination;destination=false
}var defaults={name:"formatCurrency",colorize:false,region:"",global:true,roundToDecimalPlace:2,eventOnDecimalsEntered:false};defaults=$.extend(defaults,$.formatCurrency.regions[""]);
settings=$.extend(defaults,settings);if(settings.region.length>0){settings=$.extend(settings,getRegionOrCulture(settings.region))}settings.regex=generateRegex(settings);
return this.each(function(){$this=$(this);var num="0";num=$this[$this.is("input, select, textarea")?"val":"html"]();if(num.search("\\(")>=0){num="-"+num
}if(num===""||(num==="-"&&settings.roundToDecimalPlace===-1)){return}if(isNaN(num)){num=num.replace(settings.regex,"");if(num===""||(num==="-"&&settings.roundToDecimalPlace===-1)){return
}if(settings.decimalSymbol!="."){num=num.replace(settings.decimalSymbol,".")}if(isNaN(num)){num="0"}}var numParts=String(num).split(".");var isPositive=(num==Math.abs(num));
var hasDecimals=(numParts.length>1);var decimals=(hasDecimals?numParts[1].toString():"0");var originalDecimals=decimals;num=Math.abs(numParts[0]);
num=isNaN(num)?0:num;if(settings.roundToDecimalPlace>=0){decimals=parseFloat("1."+decimals);decimals=decimals.toFixed(settings.roundToDecimalPlace);
if(decimals.substring(0,1)=="2"){num=Number(num)+1}decimals=decimals.substring(2)}num=String(num);if(settings.groupDigits){for(var i=0;i<Math.floor((num.length-(1+i))/3);
i++){num=num.substring(0,num.length-(4*i+3))+settings.digitGroupSymbol+num.substring(num.length-(4*i+3))}}if((hasDecimals&&settings.roundToDecimalPlace==-1)||settings.roundToDecimalPlace>0){num+=settings.decimalSymbol+decimals
}var format=isPositive?settings.positiveFormat:settings.negativeFormat;var money=format.replace(/%s/g,settings.symbol);money=money.replace(/%n/g,num);
var $destination=$([]);if(!destination){$destination=$this}else{$destination=$(destination)}$destination[$destination.is("input, select, textarea")?"val":"html"](money);
if(hasDecimals&&settings.eventOnDecimalsEntered&&originalDecimals.length>settings.roundToDecimalPlace){$destination.trigger("decimalsEntered",originalDecimals)
}if(settings.colorize){$destination.css("color",isPositive?"black":"text-danger")}})};$.fn.toNumber=function(settings){var defaults=$.extend({name:"toNumber",region:"",global:true},$.formatCurrency.regions[""]);
settings=jQuery.extend(defaults,settings);if(settings.region.length>0){settings=$.extend(settings,getRegionOrCulture(settings.region))}settings.regex=generateRegex(settings);
return this.each(function(){var method=$(this).is("input, select, textarea")?"val":"html";$(this)[method]($(this)[method]().replace("(","(-").replace(settings.regex,""))
})};$.fn.asNumber=function(settings){var defaults=$.extend({name:"asNumber",region:"",parse:true,parseType:"Float",global:true},$.formatCurrency.regions[""]);
settings=jQuery.extend(defaults,settings);if(settings.region.length>0){settings=$.extend(settings,getRegionOrCulture(settings.region))}settings.regex=generateRegex(settings);
settings.parseType=validateParseType(settings.parseType);var method=$(this).is("input, select, textarea")?"val":"html";var num=$(this)[method]();
num=num?num:"";num=num.replace("(","(-");num=num.replace(settings.regex,"");if(!settings.parse){return num}if(num.length==0){num="0"}if(settings.decimalSymbol!="."){num=num.replace(settings.decimalSymbol,".")
}return window["parse"+settings.parseType](num)};function getRegionOrCulture(region){var regionInfo=$.formatCurrency.regions[region];if(regionInfo){return regionInfo
}else{if(/(\w+)-(\w+)/g.test(region)){var culture=region.replace(/(\w+)-(\w+)/g,"$1");return $.formatCurrency.regions[culture]}}return null}function validateParseType(parseType){switch(parseType.toLowerCase()){case"int":return"Int";
case"float":return"Float";default:throw"invalid parseType"}}function generateRegex(settings){if(settings.symbol===""){return new RegExp("[^\\d"+settings.decimalSymbol+"-]","g")
}else{var symbol=settings.symbol.replace("$","\\$").replace(".","\\.");return new RegExp(symbol+"|[^\\d"+settings.decimalSymbol+"-]","g")}}})(jQuery);

jQuery(document).ready(function(){ 

	UpdatePrices();
 
});

function UpdatePrices(){	
 
	 
	 /* REMOVE LEADING 00 */	 
	 jQuery('.format-usd, .format-eur, .format-cad, .format-aud, .format-jpy, .format-cny, .format-gbp').each(function(i, obj) {		
		jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });
	 
 						
	 /* EUROS */
	 jQuery('.format-eur:not(.free)').each(function(i, obj) {	
													
		// 00. GET VALUE									
		var val = jQuery(obj).html();			
			
			if(jQuery.isNumeric(val)){
					
					//01. CLEAN 
					jQuery(obj).html(jQuery(obj).html().replace(',', "."));			
					
					//02. CONVERT			
					if( jQuery(obj).hasClass('format-right') ){
					jQuery(obj).formatCurrency( { symbol: '',  } );
					}else{
					jQuery(obj).formatCurrency( { symbol: '&euro;',  } );	
					}
					
					//03. CHOP OFF EXTRS
					var val = jQuery(obj).html();
					var res = val.substring(val.length - 3, val.length);
					if(res == ".00"){
						jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));	
					}
					
					// CLEAN COMMAS
					jQuery(obj).html(jQuery(obj).html().replace('.', ",")); 
					 
			}else{
				
				jQuery(obj).html(jQuery(obj).html().replace('.', ",")); 
			}
		 
		 
	 });
	 
	 /* POUNDS */
	 jQuery('.format-gbp:not(.free)').each(function(i, obj) {								 
		 jQuery(obj).formatCurrency( { symbol: '&pound;', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 }); 
	 
	 /* AUD */
	 jQuery('.format-aud:not(.free)').each(function(i, obj) {								 
		 jQuery(obj).formatCurrency( { symbol: '$', decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
		 
		 if( jQuery(obj).hasClass('format-right') ){
			jQuery(obj).html(jQuery(obj).html().replace('$', '')+'$');
		 } 
		 
	 });
	 
	 /* USD */
	 jQuery('.format-usd:not(.free)').each(function(i, obj) {								 
		 jQuery(obj).formatCurrency( { symbol: '$', decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
		 
		 if( jQuery(obj).hasClass('format-right') ){
			jQuery(obj).html(jQuery(obj).html().replace('$', '')+'$');
		 } 
		 
	 });
 						
	 /* CAD */
	 jQuery('.format-cad:not(.free)').each(function(i, obj) {								 
		 jQuery(obj).formatCurrency( { symbol: 'C$', decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
		  
	 });
 
	 /* YAN */
	 jQuery('.format-jpy:not(.free)').each(function(i, obj) {		
		 jQuery(obj).formatCurrency( { symbol: '&yen;', decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
		 
	 });  
	 /* CNY */	 
	 jQuery('.format-cny:not(.free)').each(function(i, obj) {	
		jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));
		 jQuery(obj).formatCurrency( { symbol: '&yen;', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 }); 
	 
	 /* INR */	 
	 jQuery('.format-inr:not(.free)').each(function(i, obj) {	
		jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));	
		 jQuery(obj).formatCurrency( { symbol: '<i class="fal fa-rupee-sign"></i>', decimalSymbol: '.', roundToDecimalPlace: 2,   } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });
	 /* RUB */	 
	 jQuery('.format-rub:not(.free)').each(function(i, obj) {										 
		 jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));							 
		 jQuery(obj).formatCurrency( { symbol: '<i class="fal fa-ruble-sign"></i>', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });
	 /* TRY */	 
	 jQuery('.format-try:not(.free)').each(function(i, obj) {	
		 jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));	
		 jQuery(obj).formatCurrency( { symbol: '<i class="fal fa-lira-sign"></i>', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });
	  /* PST */	 
	 jQuery('.format-pst:not(.free)').each(function(i, obj) {	
		 jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));	
		 jQuery(obj).formatCurrency( { symbol: '&#8359;', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });
	 /* BTC */	 
	 jQuery('.format-btc:not(.free)').each(function(i, obj) {	
		 jQuery(obj).html(jQuery(obj).html().replace(/[^0-9.,]/g, ''));	
		 jQuery(obj).formatCurrency( { symbol: '<i class="fab fa-bitcoin"></i>', decimalSymbol: '.', roundToDecimalPlace: 2  } );	
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 }); 
	 /* ZAR */	 
	 jQuery('.format-zar:not(.free)').each(function(i, obj) {	
		 jQuery(obj).formatCurrency( { symbol: 'R', decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
	 });	 
	  
	 
	 // ALL OTHER CURRENCIES
	 jQuery('.format-customsymbol:not(.free)').each(function(i, obj) {	
															 
															 
		jQuery(obj).formatCurrency( { symbol: jQuery(obj).attr('data-symbol'), decimalSymbol: '.', roundToDecimalPlace: 2  } );
		 jQuery(obj).html(jQuery(obj).html().replace(/\.00/g, ''));
		 
		if( jQuery(obj).hasClass('format-right') ){
		 jQuery(obj).html(jQuery(obj).html().replace(jQuery(obj).attr('data-symbol'), '')+jQuery(obj).attr('data-symbol'));
		} 												  
		 
		
	 });	
	 
	 
 	/* CSS FORMATTING */	 
	 jQuery('.format-usd:not(.price-set), .format-eur:not(.price-set), .format-cad:not(.price-set), .format-aud:not(.price-set), .format-jpy:not(.price-set), .format-cny:not(.price-set), .format-gbp:not(.price-set), .format-inr:not(.price-set),  .format-rub:not(.price-set), .format-try:not(.price-set), .format-pts:not(.price-set), .format-btc:not(.price-set), .format-zar:not(.price-set),.format-right:not(.price-set)').each(function(i, obj) {		
		
		
		var str = jQuery(obj).html();
		   
		if(str.replace(/[^0-9.,]/g, '').length > 10){
			jQuery(obj).addClass('price-tiny');
			
		}else if(str.replace(/[^0-9.,]/g, '').length > 6){
			jQuery(obj).addClass('price-small');
		 	
		}else if(str.replace(/[^0-9.,]/g, '').length > 4){
			jQuery(obj).addClass('price-medium');
		}
	 });
	 
	 
}