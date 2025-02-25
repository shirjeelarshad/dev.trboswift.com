var previewid = "";



jQuery(document).ready(function(){
	"use strict"; 
	 
	// TOGGLE SELECT
	jQuery("body").on("click", function () {
															
		 //load_ppt_blocks(0);
	
	});	 
 
	
	// PAGE LOAD
	//load_ppt_blocks(0);	
 
 
 	jQuery("#elementor-preview-iframe").bind("load",function(){
        //jQuery(this).contents().find(".elementor-add-section-drag-title").html("asdsadsad");
		 
    });

});


function load_ppt_blocks(resetme){
	
	if(jQuery('#ppt_elementor_editor_categories').length > 0 ){
		
		
		jQuery('#ppt_elementor_editor_layouts').html('');
		jQuery('#ppt_elementor_editor_preview').html('');
		
		// CHECK IF CATEGORY IS EMPTY
		var a = jQuery(".elementor-control-input-wrapper select");
		a.each(function (a) {	
			
			var thissel = jQuery(this).attr("data-setting");
			if (thissel == "type") {
				
				typeid = jQuery(this).find('option:selected').val();
				
				
			}
		});
		
		//console.log(typeid+'<--');
		
		if(typeid != "" && resetme == 0){
		
			jQuery('#ppt_elementor_editor_categories').html('');
			
		}else{
		
		   jQuery.ajax({
			   type: "POST",
			   url: ajax_site_url,	
			   dataType: 'json',	
			data: {
				   elementor_action: "load_blocks",
					//details:jQuery('#'+div).val(),
			   },
			   success: function(response) {
			   
				 if(response.status == "ok"){
				
					jQuery('#ppt_elementor_editor_categories').html(response.data);	
				
				 }
				
				
			   },
			   error: function(e) {
				   console.log(e)
			   }
		   });
	   
		}// end else
		
		 	
	} 	
	console.log("checked");
	
}


//#1 - PICK A CATEGORY


function ppt_elementor_change_type(typeid){
	
	jQuery('#ppt_elementor_editor_layouts').html('');
	jQuery('#ppt_elementor_editor_categories').html('');
	jQuery('#ppt_elementor_editor_preview').html('');
	
	previewid = "";
	 
	jQuery(".elementor-control-content_section.elementor-open .elementor-section-title").html("#2 - PICK A DESIGN");


	var a = jQuery(".elementor-control-input-wrapper select");
	a.each(function (a) {	
		
		var thissel = jQuery(this).attr("data-setting");
		if (thissel == "type") {
			 
			jQuery(this).empty().append('<option selected="selected" value="'+typeid+'">'+typeid+'</option>').trigger('change');
			 				
			   jQuery.ajax({
				   type: "POST",
				   url: ajax_site_url,	
				   dataType: 'json',	
				data: {
					   	elementor_action: "load_layouts",
						cat: typeid,
				   },
				   success: function(response) {
				   
					 if(response.status == "ok"){
					
						jQuery('#ppt_elementor_editor_layouts').html(response.data);	
					
					 }
					
					
				   },
				   error: function(e) {
					   console.log(e)
				   }
			   });
			
									
		}
					
	});

}


function ppt_panel_settings(){
	
	/*
	jQuery('#elementor-controls .elementor-control-separator-default').hide();
	jQuery('#elementor-controls .elementor-open').removeClass('elementor-open');
	
	jQuery('#elementor-control-content_section1').addClass('elementor-open').trigger('click');
	*/
	
}


function ppt_elementor_change_preview(loaddefaults){
	
 
	jQuery('#ppt_elementor_editor_layouts').html('');
	jQuery('#ppt_elementor_editor_categories').html('');
	//jQuery('#ppt_elementor_editor_preview').html('');	
	
	
if(jQuery('#ppt_preview_key_cat').length > 0){
	
	typeid = jQuery('#ppt_preview_key_cat').val();
	styleid = jQuery('#ppt_preview_key_style').val();
	
}else if(jQuery('#ppt_elementor_editor_preview').length > 0){
	
		typeid = "";
		var a = jQuery(".elementor-control-input-wrapper select");
			a.each(function (a) {	
				
				var thissel = jQuery(this).attr("data-setting");
				if (thissel == "type") {
					
					typeid = jQuery(this).find('option:selected').val();
					
					
				}
		});
	
	
		styleid = "";
		var a = jQuery(".elementor-control-input-wrapper select");
		a.each(function (a) {	
			
			var thissel = jQuery(this).attr("data-setting");
			if (thissel == typeid + "_style") {
				
				
				styleid = jQuery(this).val();
				 
										
			}
					
					
		});
		 

}
		if(jQuery('#ppt_elementor_editor_preview').length == 0){
			previewid = "";
		}
		
		//console.log('previrw for: '+typeid+' -- '+styleid);
		
		if(typeid != "" && styleid != "" && jQuery('#lastcheckedpreview').length > 0){
			
			
			
			 if(jQuery('#lastcheckedpreview').val() != ''+typeid+'_'+styleid+'' && previewid != ''+typeid+'_'+styleid+''){
				 
				previewid = ''+typeid+'_'+styleid+'';
				
			   jQuery.ajax({
				   type: "POST",
				   url: ajax_site_url,	
				   dataType: 'json',	
				   data: {
					   	elementor_action: "load_preview",
						cat: typeid,
						blockid: styleid,
				   },
				   success: function(response) {
				   
					 if(response.status == "ok"){
					
						jQuery('#ppt_elementor_editor_preview').html(response.data);	
						
						jQuery('#lastcheckedpreview').val(''+typeid+'_'+styleid+'');
					 	
						if(jQuery('#ppt_preview_key_cat').length > 0){
							
							jQuery('#ppt_preview_key_cat').val(typeid);
							jQuery('#ppt_preview_key_style').val(styleid);	
							
						}else{
							jQuery('#elementor-controls').append('<input type="hidden" id="ppt_preview_key_cat" value="'+typeid+'">');
							jQuery('#elementor-controls').append('<input type="hidden" id="ppt_preview_key_style" value="'+styleid+'">');							
							jQuery('#elementor-controls').append('<input type="hidden" id="ppt_preview_panel" value="overview">')
						}
						
						// reset
						previewid = "";
						
						// LOAD DEFAULT DATA
						if(loaddefaults == 1){
							UpdateBlockData(0);
						}
			
					
					 }					
					
				   },
				   error: function(e) {
					   console.log(e)
				   }
			   });
			   
			 }// end if

		}	 
		
}

function ppt_update_panel(panelid){
	 
	
	if(jQuery('#ppt_preview_panel').length > 0){
							
							 
							jQuery('#ppt_preview_panel').val(panelid);	
							
	}else{
							 					
							jQuery('#elementor-controls').append('<input type="hidden" id="ppt_preview_panel" value="'+panelid+'">');
	}
	
	// RELOAD PREVIEW
	if(panelid == "overview"){
		
		ppt_elementor_change_preview(0);
	}
	
	
}

function ppt_elementor_change_layout(styleid, typeid){
	
	 
	
	if( typeid == ""){
		var a = jQuery(".elementor-control-input-wrapper select");
		a.each(function (a) {	
			
			var thissel = jQuery(this).attr("data-setting");
			if (thissel == "type") {
				
				typeid = jQuery(this).find('option:selected').val();
				
				
			}
		});
		
	}else{
		
		
			var a = jQuery(".elementor-control-input-wrapper select");
			a.each(function (a) {	
				
				var thissel = jQuery(this).attr("data-setting");
				if (thissel == "type") {
							 
					jQuery(this).empty().append('<option selected="selected" value="'+typeid+'">'+typeid+'</option>').trigger('change');
					 
				}
				
			});
		
	}
	
	if(jQuery('#ppt_preview_key_cat').length > 0){
							
			jQuery('#ppt_preview_key_cat').val(typeid);
			jQuery('#ppt_preview_key_style').val(styleid);	
							
	}else{
		
		jQuery('#elementor-controls').append('<input type="hidden" id="ppt_preview_key_cat" value="'+typeid+'">').append('<input type="hidden" id="ppt_preview_key_style" value="'+styleid+'">');
	}
	
	//console.log(typeid+' == '+styleid);

 	var a = jQuery(".elementor-control-input-wrapper select");
	a.each(function (a) {	
		
		var thissel = jQuery(this).attr("data-setting");
		if (thissel == typeid + "_style") {
			
			
			jQuery(this).empty().append('<option selected="selected" value="'+styleid+'">'+styleid+'</option>').trigger('change');
			 
 			 						
		}
					
	});
	
	// NOW SWITCH TO PREVIEW
	ppt_elementor_change_preview(1);
	


}

 



 
	
	
	
// MAIN BLOCK UPDATE
function UpdateBlockData(alertme){
	
	block_default = [];
	
	 	
	
if(jQuery('#ppt_preview_key_cat').length > 0){
	
	typeid = jQuery('#ppt_preview_key_cat').val();
	styleid = jQuery('#ppt_preview_key_style').val();
	
}else{
	
		
		typeid = "";
		var a = jQuery(".elementor-control-input-wrapper select");
			a.each(function (a) {	
				
				var thissel = jQuery(this).attr("data-setting");
				if (thissel == "type") {
					
					typeid = jQuery(this).find('option:selected').val();
					
					
				}
		});
	
	
		styleid = "";
		var a = jQuery(".elementor-control-input-wrapper select");
		a.each(function (a) {	
			
			var thissel = jQuery(this).attr("data-setting");
			if (thissel == typeid + "_style") {
				
				
				styleid = jQuery(this).val();
				 
										
			}
						
		});
		

}// end if
		 
		if(typeid != "" && styleid != ""){
	
			   jQuery.ajax({
				   type: "POST",
				   url: ajax_site_url,	
				   dataType: 'json',	
				data: {
					   	elementor_action: "load_default_data",
						cat: typeid,
						blockid: styleid,
				   },
				   success: function(response) {
				   
						if(response.status == "ok"){
					   
							var text = response.data;
							
							var obj = JSON.parse(text, function (key, value) {
								 
								 block_default[key] = value;
								 
								 //jQuery('#ppt_elementor_editor_preview').append('<input type="text" name="'+key+'" data-settings="'+key+'" value="'+value+'">');
							
							});
							
							// #1. OVERVIEW TAB					
							loopandsave(block_default);
							
							// #2. TITLE TAB							 	
							const update1 = function(){
							  	jQuery('.elementor-control-ppt_title').trigger('click');					
								loopandsave(block_default);
							};
							setTimeout(update1, 1000);							 	
							
							// #3. BUTTON TAB
							const update2 = function(){
							  	jQuery('.elementor-control-ppt_button').trigger('click');					
								loopandsave(block_default);
							};
							setTimeout(update2, 2000);							
							
							// #3. BUTTON 2 TAB
							const update3 = function(){
							  	jQuery('.elementor-control-ppt_button2').trigger('click');					
								loopandsave(block_default);
							};
							setTimeout(update3, 3000);
							
							// BACK TO OVERVIEW TAB
							const update4 = function(){
							  	jQuery('.elementor-control-ppt_block_overview').trigger('click');	
							};
							setTimeout(update4, 4000);
							 
							 
							
							// OPEN UP ALL THE FIELDS
							if(alertme == 1){
									
								jQuery('#elementor-controls').prepend('<div style="padding:10px; background:green; color:#fff;">Block settings have been reset to default</div>');	
							}
							
							
						}	
					
					
				   },
				   error: function(e) {
					   console.log('ERROR: '+e)
				   }
			   });
	
		} // end if
	 
		
}

function loopandsave(block_default){

		var a = jQuery(".elementor-control-input-wrapper select, .elementor-control-input-wrapper input, .elementor-control-input-wrapper textarea");
						a.each(function (a) {
							
							var thissel = jQuery(this).attr("data-setting");
								
							if (typeof block_default[thissel] !== "undefined") {
									   
									if (jQuery('#'+jQuery(this).attr("id")).is( "select" ) ) {
										
										jQuery(this).empty().append('<option selected="selected" value="'+block_default[thissel]+'">'+block_default[thissel]+'</option>').trigger('change');
										 
									} else if ( jQuery('#'+jQuery(this).attr("id")).is( "input" ) ) {
									
										jQuery('#'+jQuery(this).attr("id")).addClass("test").trigger('focus').val(block_default[thissel]).trigger('input');
										
									}  else if ( jQuery('#'+jQuery(this).attr("id")).is( "textarea" ) ) {
									
										jQuery('#'+jQuery(this).attr("id")).addClass("test").trigger('focus').val(block_default[thissel]).trigger('input');
										
									} else {
									
										jQuery('#elementor-controls').append('<input type="text" data-settings="'+thissel+'" value="'+block_default[thissel]+'">').trigger('input');
										
									}								
							} 							 
							
						});
	
}

function label_1(){
	
	 
	 // BACK TO OVERVIEW TAB
	const update4 = function(){
		jQuery(".elementor-control-ppt_block_overview .elementor-section-title").html("CHOOSE A CATEGORY");	
	};
	setTimeout(update4, 1000);
	
}
function label_2(){
	
	 
	 // BACK TO OVERVIEW TAB
	const update4 = function(){
		jQuery(".elementor-control-ppt_block_overview .elementor-section-title").html("CHOOSE A DESIGN");	
	};
	setTimeout(update4, 1000);
	
}