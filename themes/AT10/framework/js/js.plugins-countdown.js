jQuery(document).ready(function(){ 

	/*  COUNTDOWN TOOL */	
	setTimeout(function(){ 
		
		ppt_countdowns(); 

	}, 2000); 

});

function ppt_countdowns(){
	

jQuery('[data-ppt-countdown]').each(function() {
	
		var $this 	=	jQuery(this); 
		var layout 	=	jQuery('.'+$this.data( "layout" )).html();	
		var dateStr =	$this.data('ppt-countdown');
		 
		var a		=	dateStr.split(' ');
		var d		=	a[0].split('-');
		var t		=	a[1].split(':');
		var finalDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2],t[2]);
 		
		
		var postid = $this.data('postid');
		if(typeof postid === "undefined"){	
		postid = 0;
		}
 
		var tzone = $this.data( "timezone" );
		if(typeof $this.data( "timezone" ) === "undefined"){	
		tzone = null;	
		} 
 
		if(typeof layout === "undefined"){			 
		layout = "<div class='ppt_countdown ppt-cd-" + postid + "'><span class='cdays va-{dn}'>{dn}d </span><span class=''>{hnn}</span><span class='sep '>:</span><span class=''>{mnn}</span><span class='sep'>:</span><span class=''>{snn}</span></div>";
		}
 
		jQuery($this).countdown({
			until: finalDate,
			format: $this.data( "format" ),
			 
			layout: layout,
			timezone: tzone,
			
			
			/*onTick:  function(periods){ 
			
					console.log(periods);
					//ontick = $this.data('ontick');
					
					months = periods[2];
					days = periods[3];
					hours = periods[4];
					minutes = periods[5];
					seconds = periods[6];
					
					// HIDE CLOCK VALUES WITH DAYS
					if(days == 0){
						jQuery(".ppt-cd-"+ postid+ " .cdays" ).hide();
					}					 
					// CHECK FOR CALLBACK FUNCTION
					if (typeof ontick !== "undefined") {					
							window[ontick](hours, minutes, seconds, postid);						
					}
			},*/
			
			onExpiry: function(){
				
				postid = $this.data('postid');
				if (typeof action !== "undefined") {
						
				jQuery.ajax({
						type: "POST",
						url: ajax_site_url,	
						dataType: 'json',	
						data: {
							action: "validateexpiry",
							pida: postid,
						},
						success: function(response) {
							
										
						},
						error: function(e) {
						   console.log('error validating countdown expiry');
						}
					});
				
				}
				
				
				 
			},
			alwaysExpire: true,
		});			
		 
	});
	
}

/* =============================================================================
   COUNTDOWN
   ========================================================================== */
   
(function($){function Countdown(){this.regional=[];this.regional['']={labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,digits:['0','1','2','3','4','5','6','7','8','9'],timeSeparator:':',isRTL:false};this._defaults={until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1};$.extend(this._defaults,this.regional['']);this._serverSyncs=[];var c=(typeof Date.now=='function'?Date.now:function(){return new Date().getTime()});var d=(window.performance&&typeof window.performance.now=='function');function timerCallBack(a){var b=(a<1e12?(d?(performance.now()+performance.timing.navigationStart):c()):a||c());if(b-f>=1000){x._updateTargets();f=b}e(timerCallBack)}var e=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var f=0;if(!e||$.noRequestAnimationFrame){$.noRequestAnimationFrame=null;setInterval(function(){x._updateTargets()},980)}else{f=window.animationStartTime||window.webkitAnimationStartTime||window.mozAnimationStartTime||window.oAnimationStartTime||window.msAnimationStartTime||c();e(timerCallBack)}}var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.extend(Countdown.prototype,{markerClassName:'hasCountdown',propertyName:'countdown',_rtlClass:'countdown_rtl',_sectionClass:'countdown_section',_amountClass:'countdown_amount',_rowClass:'countdown_row',_holdingClass:'countdown_holding',_showClass:'countdown_show',_descrClass:'countdown_descr',_timerTargets:[],setDefaults:function(a){this._resetExtraLabels(this._defaults,a);$.extend(this._defaults,a||{})},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},_attachPlugin:function(a,b){a=$(a);if(a.hasClass(this.markerClassName)){return}var c={options:$.extend({},this._defaults),_periods:[0,0,0,0,0,0,0]};a.addClass(this.markerClassName).data(this.propertyName,c);this._optionPlugin(a,b)},_addTarget:function(a){if(!this._hasTarget(a)){this._timerTargets.push(a)}},_hasTarget:function(a){return($.inArray(a,this._timerTargets)>-1)},_removeTarget:function(b){this._timerTargets=$.map(this._timerTargets,function(a){return(a==b?null:a)})},_updateTargets:function(){for(var i=this._timerTargets.length-1;i>=0;i--){this._updateCountdown(this._timerTargets[i])}},_optionPlugin:function(a,b,c){a=$(a);var d=a.data(this.propertyName);if(!b||(typeof b=='string'&&c==null)){var e=b;b=(d||{}).options;return(b&&e?b[e]:b)}if(!a.hasClass(this.markerClassName)){return}b=b||{};if(typeof b=='string'){var e=b;b={};b[e]=c}if(b.layout){b.layout=b.layout.replace(/&lt;/g,'<').replace(/&gt;/g,'>')}this._resetExtraLabels(d.options,b);var f=(d.options.timezone!=b.timezone);$.extend(d.options,b);this._adjustSettings(a,d,b.until!=null||b.since!=null||f);var g=new Date();if((d._since&&d._since<g)||(d._until&&d._until>g)){this._addTarget(a[0])}this._updateCountdown(a,d)},_updateCountdown:function(a,b){var c=$(a);b=b||c.data(this.propertyName);if(!b){return}c.html(this._generateHTML(b)).toggleClass(this._rtlClass,b.options.isRTL);if($.isFunction(b.options.onTick)){var d=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date());if(b.options.tickInterval==1||this.periodsToSeconds(d)%b.options.tickInterval==0){b.options.onTick.apply(a,[d])}}var e=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(e&&!b._expiring){b._expiring=true;if(this._hasTarget(a)||b.options.alwaysExpire){this._removeTarget(a);if($.isFunction(b.options.onExpiry)){b.options.onExpiry.apply(a,[])}if(b.options.expiryText){var f=b.options.layout;b.options.layout=b.options.expiryText;this._updateCountdown(a,b);b.options.layout=f}if(b.options.expiryUrl){window.location=b.options.expiryUrl}}b._expiring=false}else if(b._hold=='pause'){this._removeTarget(a)}c.data(this.propertyName,b)},_resetExtraLabels:function(a,b){var c=false;for(var n in b){if(n!='whichLabels'&&n.match(/[Ll]abels/)){c=true;break}}if(c){for(var n in a){if(n.match(/[Ll]abels[02-9]|compactLabels1/)){a[n]=null}}}},_adjustSettings:function(a,b,c){var d;var e=0;var f=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==b.options.serverSync){f=this._serverSyncs[i][1];break}}if(f!=null){e=(b.options.serverSync?f:0);d=new Date()}else{var g=($.isFunction(b.options.serverSync)?b.options.serverSync.apply(a,[]):null);d=new Date();e=(g?d.getTime()-g.getTime():0);this._serverSyncs.push([b.options.serverSync,e])}var h=b.options.timezone;h=(h==null?-d.getTimezoneOffset():h);if(c||(!c&&b._until==null&&b._since==null)){b._since=b.options.since;if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(b.options.until,d));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}}b._show=this._determineShow(b)},_destroyPlugin:function(a){a=$(a);if(!a.hasClass(this.markerClassName)){return}this._removeTarget(a[0]);a.removeClass(this.markerClassName).empty().removeData(this.propertyName)},_pausePlugin:function(a){this._hold(a,'pause')},_lapPlugin:function(a){this._hold(a,'lap')},_resumePlugin:function(a){this._hold(a,null)},_hold:function(a,b){var c=$.data(a,this.propertyName);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addTarget(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,this.propertyName,c);this._updateCountdown(a,c)}},_getTimesPlugin:function(a){var b=$.data(a,this.propertyName);return(!b?null:(b._hold=='pause'?b._savePeriods:(!b._hold?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date()))))},_determineTime:function(k,l){var m=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var n=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,x._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,x._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var o=(k==null?l:(typeof k=='string'?n(k):(typeof k=='number'?m(k):k)));if(o)o.setMilliseconds(0);return o},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this;c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,c.options.significant,new Date()));var e=false;var f=0;var g=c.options.significant;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=(c.options.compact?c.options.compactLabels:c.options.labels);var l=c.options.whichLabels||this._normalLabels;var m=function(a){var b=c.options['compactLabels'+l(c._periods[a])];return(h[a]?d._translateDigits(c,c._periods[a])+(b?b[a]:k[a])+' ':'')};var n=function(a){var b=c.options['labels'+l(c._periods[a])];return((!c.options.significant&&h[a])||(c.options.significant&&j[a])?'<span class="'+x._sectionClass+'">'+'<span class="'+x._amountClass+'">'+d._translateDigits(c,c._periods[a])+'</span><br/>'+(b?b[a]:k[a])+'</span>':'')};return(c.options.layout?this._buildLayout(c,h,c.options.layout,c.options.compact,c.options.significant,j):((c.options.compact?'<span class="'+this._rowClass+' '+this._amountClass+(c._hold?' '+this._holdingClass:'')+'">'+m(Y)+m(O)+m(W)+m(D)+(h[H]?this._minDigits(c,c._periods[H],2):'')+(h[M]?(h[H]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[M],2):'')+(h[S]?(h[H]||h[M]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[S],2):''):'<span class="'+this._rowClass+' '+this._showClass+(c.options.significant||f)+(c._hold?' '+this._holdingClass:'')+'">'+n(Y)+n(O)+n(W)+n(D)+n(H)+n(M)+n(S))+'</span>'+(c.options.description?'<span class="'+this._rowClass+' '+this._descrClass+'">'+c.options.description+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=c.options[f?'compactLabels':'labels'];var k=c.options.whichLabels||this._normalLabels;var l=function(a){return(c.options[(f?'compactLabels':'labels')+k(c._periods[a])]||j)[a]};var m=function(a,b){return c.options.digits[Math.floor(a/b)%10]};var o={desc:c.options.description,sep:c.options.timeSeparator,yl:l(Y),yn:this._minDigits(c,c._periods[Y],1),ynn:this._minDigits(c,c._periods[Y],2),ynnn:this._minDigits(c,c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:this._minDigits(c,c._periods[O],1),onn:this._minDigits(c,c._periods[O],2),onnn:this._minDigits(c,c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:this._minDigits(c,c._periods[W],1),wnn:this._minDigits(c,c._periods[W],2),wnnn:this._minDigits(c,c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:this._minDigits(c,c._periods[D],1),dnn:this._minDigits(c,c._periods[D],2),dnnn:this._minDigits(c,c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:this._minDigits(c,c._periods[H],1),hnn:this._minDigits(c,c._periods[H],2),hnnn:this._minDigits(c,c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:this._minDigits(c,c._periods[M],1),mnn:this._minDigits(c,c._periods[M],2),mnnn:this._minDigits(c,c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:this._minDigits(c,c._periods[S],1),snn:this._minDigits(c,c._periods[S],2),snnn:this._minDigits(c,c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}([\\s\\S]*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b,c){b=''+b;if(b.length>=c){return this._translateDigits(a,b)}b='0000000000'+b;return this._translateDigits(a,b.substr(b.length-c))},_translateDigits:function(b,c){return(''+c).replace(/[0-9]/g,function(a){return b.options.digits[a]})},_determineShow:function(a){var b=a.options.format;var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=x._getDaysInMonth(f.getFullYear(),f.getMonth());var j=x._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=x._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}});var w=['getTimes'];function isNotChained(a,b){if(a=='option'&&(b.length==0||(b.length==1&&typeof b[0]=='string'))){return true}return $.inArray(a,w)>-1}$.fn.countdown=function(a){var b=Array.prototype.slice.call(arguments,1);if(isNotChained(a,b)){return x['_'+a+'Plugin'].apply(x,[this[0]].concat(b))}return this.each(function(){if(typeof a=='string'){if(!x['_'+a+'Plugin']){throw'Unknown command: '+a;}x['_'+a+'Plugin'].apply(x,[this].concat(b))}else{x._attachPlugin(this,a||{})}})};var x=$.countdown=new Countdown()})(jQuery);