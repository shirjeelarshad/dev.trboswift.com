function ajax_load_notification_bubble(){
	
		if(typeof ajax_site_url === "undefined"){
			return;
		}
		
		if( jQuery('#premiumpress-body').length > 0 ){
			return;
		}
   
       jQuery.ajax({
           type: "POST",
           url: ajax_site_url,	
		   dataType: 'json',	
   			data: {
               action: "notification_bubble",   				
           },
           success: function(response) {	
		    	
   			if(response.status == "ok"){
			
				notify({
					type: response.type,
					title: response.title,
					position: {
					 	x: "right", 
					 	y: "bottom"
					},
					icon: response.icon,
					message: response.msg,
				});	
				
				if(jQuery("#notifyaudiosource").length == 0){
				jQuery("footer").append('<audio  controls style="display:none;"><source id="notifyaudiosource" src="" type="audio/mpeg"></audio>');
				}
				
				jQuery('audio #notifyaudiosource').attr('src', response.audio);
                jQuery('audio').get(0).load();
                jQuery('audio').get(0).play();
				
				
			}
			
			if(response.status == "ok" || response.status == "none" ){  
				setTimeout(function(){	 
							
					ajax_load_notification_bubble();
												 
				},10000);
			}
   			
           },
           error: function(e) {
               console.log(e)
           }
       });

}

jQuery(document).ready(function(){ 
	
	if(jQuery(".notify-stop").length == 0){
	setTimeout(function(){		
						
			ajax_load_notification_bubble();	
	
	}, 2000);
	
	}

});

/* =============================================================================
  Notify
  ========================================================================== */	
function notify(e){return jQuery.cNotify(e)}(function(e){e.cNotify=function(t){var n={type:"default",title:null,message:null,position:{x:"right",y:"bottom"},icon:null,size:"normal",overlay:false,closeBtn:true,overflowHide:false,spacing:20,theme:"default",autoHide:true,delay:2500,onShow:null,onClick:null,onHide:null,template:'<div class="notify"><div class="notify-text"></div></div>',_classes:{box:".notify",closeBtn:".notify-close-btn",content:".notify-text",icon:".notify-icon",iconI:".notify-icon-inner",overlay:".notify-overlay"}},t=e.extend({},n,t),r=e(t.template).hide(),i=t._classes.box,s={init:function(){s._setContent();r.on("click",function(e){t.onClick!=null?t.onClick(e,r,t):null})},_show:function(){var e=function(e){t.onShow!=null?t.onShow(r,t):null;if(t.autoHide){s._hide(true)}};r.fadeIn(250,e)},_hide:function(n){var i;if(typeof n=="object"){i=n;i.remove();s._reposition(i.attr("class"));return}else{i=r}t.onHide!=null?t.onHide(i,t):null;var o=function(){
																																																																																																																																																																																																																																																			 
																																																																																																																																																																																																																																																			 if(e(t._classes.box+".notify-overlayed").length <1){
																																																																																																																																																																																																																																																															 
																																																																																																																																																																																																																																																															 e(t._classes.overlay).fadeOut(250,function(){e(this).remove()})}s._reposition(i.attr("class"))};if(!n){i.fadeOut(function(){e(this).remove();o()})}else{var u=e(t._classes.content).text().length*30;setTimeout(function(){i.fadeOut(function(){e(this).remove();o()})},typeof t.delay!="number"||t.delay=="auto"?u<2500?2500:u:t.delay)}},_setContent:function(){if(t.theme&&t.theme!=null&&t.theme!="default"){r.addClass(t.theme)}if(e.inArray(t.type,["success","error","warning","info"])!=-1){r.addClass(t.type)}if(t.title&&t.title!=null){r.find(t._classes.content).prepend("<h3>"+t.title+"</h3>")}else{r.addClass("notify-without-title")}if(t.message&&t.message!=null){r.find(t._classes.content).append("<p>"+t.message+"</p>")}if(t.size&&t.size!=null&&t.size!="normal"){if(t.size=="full"&&(t.position.y=="top"||t.position.y=="bottom")){r.addClass("notify-"+t.position.y+"-full")}else{r.addClass("size-"+t.size)}}if(t.icon&&t.icon!=null){var n=e(t.icon).is("img")?e(t.icon):e(t.icon).find("img").length !=0?e(t.icon).find("img"):e(t.icon);r.prepend('<div class="notify-icon"><div class="notify-icon-inner">'+t.icon+"</div>")}else{r.addClass("notify-without-icon")}if(t.overlay&&t.overlay!=null){if(e("body").find(t._classes.overlay).length ==0){
																																																																																																																																																																																																																																																																 
																																																																																																																																																																																																																																																																 e('<div class="notify-overlay'+(typeof t.overlay=="string"?" "+t.overlay:"")+'"></div>').hide().appendTo("body").fadeIn(250)}r.addClass("notify-overlayed")}if(t.closeBtn){r.prepend('<a href="javascript:;" class="notify-close-btn"><i class="fa fa-times"></i></a>');r.on("click",t._classes.closeBtn,function(){s._hide()})}else{r.on("click",function(){s._hide()}).css("cursor","pointer")}r.appendTo("body");s._show();s._poisition();if(n){
																																																																																																																																																																																																																																																																	 
																																																																																																																																																																																																																																																																					 n.on('load',function () {
																																																																																																																																																																																																																																																																					 var e=Math.round(r.find(t._classes.iconI).outerHeight()/2);if(e>0){r.find(t._classes.iconI).css("margin-top",e*-1)}})}},_poisition:function(){var n="notify-";if(t.position&&t.position!=null&&e.isPlainObject(t.position)&&t.position.x&&t.position.y){switch(t.position.y){case"top":n+="top-";break;case"center":n+="center-";break;case"bottom":n+="bottom-";break}switch(t.position.x){case"right":n+="right";break;case"center":n+="center";break;case"left":n+="left";break}}else{n+="bottom-right"}r.addClass(n);if(n=="notify-center-center"){if(e(".notify.notify-center-center").length >1){s._hide(e(".notify.notify-center-center").first())}r.css({marginTop:r.outerHeight()/2*-1})}var i=e("body").find(".notify."+n).length;if(i>1){var o={};pS=n.split("-");switch(pS[1]){case"top":o.top=parseFloat(e("body").find(".notify."+n).eq(i-2).css("top"))+e("body").find(".notify."+n).eq(i-2).outerHeight()+t.spacing;break;case"bottom":o.bottom=parseFloat(e("body").find(".notify."+n).eq(i-2).css("bottom"))+e("body").find(".notify."+n).eq(i-2).outerHeight()+t.spacing;break}r.css(o);var u=0;jQuery(".notify."+n).each(function(){u+=jQuery(this).outerHeight()+t.spacing});if(u>=e(window).height()){if(t.overflowHide){s._hide(e("body").find(".notify."+n).first())}else{r.hide()}}}},_reposition:function(n){if(n.match(/notify\-bottom\-(right|left|center|full)/g)){n=n.match(/notify\-bottom\-(right|left|center|full)/g)[0]}else if(n.match(/notify\-top\-(right|left|center|full)/g)){n=n.match(/notify\-top\-(right|left|center|full)/g)[0]}else{return false}var i=0;jQuery(".notify."+n).each(function(){i+=jQuery(this).outerHeight()+t.spacing});if(i>=e(window).height()){if(t.overflowHide){s._hide(e("body").find(".notify."+n).first())}else{r.hide()}}e("body").find(".notify."+n+":hidden").first().show();var o={};jQuery(".notify."+n).stop(true,true);jQuery(".notify."+n).each(function(r,i){var s={},u=n.split("-");switch(u[1]){case"top":var a=u[2]=="full"?0:21;if(r==0){e(i).animate({top:a-1},300);o.top=a;o.height=e(i).outerHeight();return true}s.top=parseFloat(o.top)+o.height+t.spacing;o.top=s.top;o.height=e(i).outerHeight();break;case"bottom":var a=u[2]=="full"?0:21;if(r==0){e(i).animate({bottom:a-1},300);o.bottom=a;o.height=e(i).outerHeight();return true}s.bottom=parseFloat(o.bottom)+o.height+t.spacing;o.bottom=s.bottom;o.height=e(i).outerHeight();break}e(i).animate(s,300)})}};s.init();return true}})(jQuery,window,document);