 
jQuery(window).on('load',function () {
								   
	
			 // QUICK FIX FOR LAZY IMAGES
			 jQuery("img").each(function() { 
				   
				   var imgsrc = jQuery(this).attr('data-src');
				 
				   if(imgsrc != ""){		   
				   jQuery(this).attr('src', imgsrc);
				   }
			   
			 }); 
		  
			// CUSTOM BACKGROUNDS 
			var a = jQuery(".bg-image");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			});
			
			// CUSTOM PATTERNS
			var a = jQuery(".bg-pattern");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			});
		
			// CUSTOM PATTERNS
			var a = jQuery(".bg-pattern-small");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			}); 
		

});



	
		 
