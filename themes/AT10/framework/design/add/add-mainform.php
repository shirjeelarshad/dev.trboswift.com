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
   
   $editID = "";
   if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
   
   	if(!$CORE->PACKAGE("canedit", $_GET['eid'])){
	echo "This is not your post!";
	return;
	}
	
   	$editID = $_GET['eid'];
   	
   	// LOAD IN OPTIONS FOR SORTING DATA
   	wp_enqueue_script( 'jquery-ui-sortable' );
   	wp_enqueue_script( 'jquery-ui-draggable' );
   	wp_enqueue_script( 'jquery-ui-droppable' );
   }
   
   
   // USER MEMBERSHIP INCLUDED IN PRICE
   $freeListingMembership = false;
  

    
   /* =============================================================================
      GET ALL SETUP OPTIONS
      ========================================================================== */ 
    
   	// COUNT PACKAGES
   	$total_packages = $CORE->packages_count();
   	
   	// CHECK IF LISTING IS PAID, IF SO REMOVE ALL EDITING OPTIONS
   	$canEdit = true;
    
   	if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ 
   		if(get_post_meta($_GET['eid'],'paid_date',true) != ""){
   		$canEdit = false;
   		}
   		
   		global $canEdit;
   	}
    
   $o=0;
?>
<!-- SAVING SPINNER -->

<div id="core_saving_wrapper" style="display:none;">
  <div class="alert alert-primary alert-dismissible fade show" role="alert"> <span class="alert-inner--icon"> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> </span> <span class="alert-inner--text"><strong><?php echo __("Saving Your Changes","premiumpress"); ?></strong> - <?php echo __("This may take a few minutes, please wait...","premiumpress"); ?></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">x</span> </button>
  </div>
</div>
<!-- setup package array for jquery -->
<script>var package = [];</script>
<?php if( $CORE->LAYOUT("captions","listings") ){	 ?>
<div id="step-packages">
  <?php _ppt_template('framework/design/add/add-packages' ); ?>
</div>
<?php } ?>
<div id="MAINCONTAINER" class="add-listing-form">
<?php


// SEE IF WE HAVE ANY OTHER LISTINGS ALREADY
if(_ppt(array('lst', 'onelistingonly')) == 1 && !$CORE->USER("membership_hasaccess", "listings_multiple") ){

$SQL = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='".THEME_TAXONOMY."_type' and post_status != 'trash' AND post_author='".$userdata->ID."' ORDER BY ID DESC LIMIT 1";	
$result = $wpdb->get_results($SQL);


}
	 



// CHECK FOR 1 LISTING ONLY, IF SO REDIRECT
if( !is_admin() && !empty($result) && ( _ppt(array('lst', 'onelistingonly')) == 1 ) && $userdata->ID && !isset($_GET['eid']) && !isset($_POST['action']) ){
 
		?>
<div class="bg-white p-4 border shadow-sm text-center col-md-8 mx-auto">
  <h1 class="mt-4"><?php echo __("We've found your Ad!","premiumpress"); ?></h1>
  <div class="lead col-md-10 mx-auto mb-4"><?php echo __("Users can create one ad per account. We'll redirect you to edit your ad page shortly.","premiumpress"); ?></div>
  <div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>
  <script>setTimeout(function() { window.location.href = "<?php echo _ppt(array('links','add')); ?>/?eid=<?php echo $result[0]->ID; ?>"; }, 3000);</script>
</div>
<?php 



}elseif( !is_admin() && _ppt(array('mem','register'))  == '1' && $CORE->USER("membership_active", $userdata->ID) == 0 ){ 

?>
<div class="col-md-8 mx-auto">
  <?php _ppt_template( 'page-login-memberships' ); ?>
</div>
<?php


}else{


	
if(!$userdata->ID){

?>
<div class="text-center"><?php echo __("Please login to your account.","premiumpress"); ?></div>
<?php 

}else{

?>
<?php if(isset($_GET['repost'])){ ?>
<input type="hidden" class="form-control" name="repost" value="1" />
<?php } ?>
<?php if(isset($_GET['eid'])){ ?>
<input type="hidden" class="form-control" name="oldeid" value="<?php echo esc_attr($_GET['eid']); ?>" />
<?php } ?>
<div class="row">
<div class="col-md-8">
  <div class="card shadow-sm">
    <div class="card-body">
      <?php _ppt_template('framework/design/add/add-title' ); ?>

      
      <?php _ppt_template('framework/design/add/add-excerpt' ); ?>
      
      <?php _ppt_template('framework/design/add/add-content' ); ?>
      <div class="form-group mt-4">
        <label> <?php echo __("Keywords","premiumpress"); ?> </label>
        <input type="input" <?php if(!$userdata->ID ){ ?>disabled <?php } ?> name="form[post_tags]" class="form-control tokenfield" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo $CORE->get_edit_data('post_tags', $_GET['eid'] ); } ?>">
        <div class="opacity-5 small mt-2"><?php echo __("Separate each keyword with a comma.","premiumpress"); ?></div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mt-4">
    <div class="card-body">
      <?php if(defined('WLT_CART') && !in_array(THEME_KEY, array("ph")) ){ ?>
      
      
         <?php if(in_array(THEME_KEY, array("so")) ){ ?>
    
      <?php _ppt_template('framework/design/add/add-customfields' ); ?>
         
      <?php } ?>
      
      <?php _ppt_template('framework/design/add/add-product' ); ?>
      
   
      
      <?php }else{ ?>
      <?php _ppt_template('framework/design/add/add-customfields' ); 	  
	  } ?>
    </div>
  </div>
 

 
  <?php //_ppt_template('framework/design/add/add-background' ); ?>
  
  <?php if(THEME_KEY == "da"){ ?>
  <?php _ppt_template('framework/design/add/add-lookingfor' ); ?>
  <?php } ?>
  
   <?php if(!in_array(THEME_KEY, array("vt","sp","cp")) && in_array(_ppt(array('design', 'display_features')), array("","1")) ){   ?>
  <?php _ppt_template('framework/design/add/add-features' ); ?>  
  <?php } ?>
  
  <?php if(THEME_KEY == "dt" && in_array(_ppt(array('lst', 'dt_services')), array("","1")) ){ ?>
  <?php _ppt_template('framework/design/add/add-services' ); ?>
  <?php } ?>
  
  <?php  if( in_array(THEME_KEY, array("dt","es")) && in_array(_ppt(array('design', "display_openinghours")), array("","1")) ){ ?>
  <?php _ppt_template('framework/design/add/add-workinghours' ); ?>
  <?php } ?>
  <?php if(THEME_KEY == "cm"){ ?>
  <?php _ppt_template('framework/design/add/add-compare' ); ?>
  <?php _ppt_template('framework/design/add/add-compare-stores' ); ?>
  <?php } ?>
  <?php if(THEME_KEY == "mj"){ ?>
  <?php _ppt_template('framework/design/add/add-gigs' ); ?>
  <?php } ?>
  <?php if(THEME_KEY == "vt"){ ?>
  <?php _ppt_template('framework/design/add/add-videoseries' ); ?>
  <?php } ?>  
  <?php if(THEME_KEY == "ll"){ ?>
  <?php _ppt_template('framework/design/add/add-coursedownload' ); ?>
  <?php } ?>  
  
  
  <?php if(THEME_KEY == "es" && in_array(_ppt(array('design', 'display_rates')), array("","1"))){  ?>
  <?php _ppt_template('framework/design/add/add-callrates' ); ?>
  <?php } ?> 
  
   <?php if(!in_array(THEME_KEY, array("vt","ex")) && in_array( _ppt(array('lst', 'default_imguploads')) , array("","1")) ){ ?>
  <?php _ppt_template('framework/design/add/add-images' ); ?>
  <?php }else{ ?>
  <script>function  CheckuploadSpace(){ }</script>  
  <?php } ?>
  
  <?php if(!in_array(THEME_KEY, array("cp")) ){ ?>
  <?php _ppt_template('framework/design/add/add-media' ); ?>
  <?php } ?>
  
  <?php if(defined('WLT_CART') && !in_array(THEME_KEY, array("so", "ph")) ){ ?>
  <?php _ppt_template('framework/design/add/add-product-details' ); ?>
   
  <?php } ?>
  <?php 
   
   if($CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1 && in_array(_ppt(array('lst', 'default_location')), array("","1"))  ){	
   _ppt_template('framework/design/add/add-location' ); 
   }
   
   ?>
</div>
<div class="col-md-4">
  <?php _ppt_template('framework/design/add/add-featuredimage' ); ?>
  <div class="card shadow-sm bg-light">
    <div class="card-body">
    
    <?php if(is_admin()){ ?>
    <div class="d-flex justify-content-between my-3"><h6>Seller</h6> <?php echo do_shortcode('[custom_user_dropdown]'); ?></div>
    
    <?php } ?>
    
      <?php _ppt_template('framework/design/add/add-category' ); ?>
      <?php if( $CORE->LAYOUT("captions","memberships") && THEME_KEY == "vt" ){ ?>
      <?php _ppt_template('framework/design/add/add-membership' ); ?>
      <?php } ?>
      <?php _ppt_template('framework/design/add/add-save' ); ?>
    </div>
  </div>
  <?php if( $CORE->LAYOUT("captions","listings") ){ ?>
  <?php _ppt_template('framework/design/add/add-addons' ); ?>
  <?php } ?>
  
 
  
  <div class="<?php if(!is_admin()){ ?>mb-5 pb-5<?php } ?>">
    <button class="btn btn-primary btn-block btn-xl mt-5 <?php if(!is_admin()){ ?>mb-5<?php } ?>" id="mainSaveBtn" onclick="VALIDATE_FORM_DATA();"><?php echo __("Save Changes","premiumpress"); ?></button>
  </div>
  <?php if(is_admin() && THEME_KEY == "at" && isset($_GET['eid']) ){ ?>
  <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=listings&eid=<?php echo esc_attr($_GET['eid']); ?>&resetaction=<?php echo esc_attr($_GET['eid']); ?>" class="btn btn-outline-primary btn-xl btn-block mt-4"><?php echo __("Reset Auction","premiumpress"); ?></a>
  <?php 
  global $CORE_AUCTION;
  
  // SHOW BIDDING DATA
		$data = $CORE_AUCTION->bidding_history($_GET['eid'], false);
		 
 
		?>
  <div class="small mt-4" style="max-height:400px; overflow:scroll-y;"> <?php echo str_replace("card","",$data['data']); ?> </div>
  <script>

function auction_deletebid(bid){

 // RESET
jQuery('#deletebid'+bid).hide();	

jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "auction_deletebid",
			pid: <?php echo esc_attr($_GET['eid']); ?>,
			bid: bid,
        },
        success: function(response) {			
			if(response.status == "ok"){ 
			
			}else{			
			 			
			}			
        },
        error: function(e) {
            console.log(e)
        }
});

}
</script>
  <?php if(isset($_GET['resetaction'])){ ?>
  <script>
jQuery(document).ready(function(){ 

	notify({
		type: "warning", //alert | success | error | warning | info
		title: "Success",
		position: {
					 x: "right", //right | left | center
					 y: "top" //top | bottom | center
					},
		icon: '<i class="fal fa-check"></i>',
		message: "<?php echo __("Auction Reset Successfully","premiumpress"); ?>"
	});
	
});

</script>
  <?php } ?>
  <?php } ?>
</div>
<?php if($userdata->ID ){ ?>
<input type="hidden" id="input-filelimit" value="<?php echo _ppt('default_listing_uploads'); ?>" />
<form  method="post" enctype="multipart/form-data" onsubmit="VALIDATE_FORM_DATA(); return false;" id="SUBMISSION_FORM" style="display:none;">
  <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
  <input type="hidden" name="eid" value="<?php echo esc_attr($_GET['eid']); ?>" />
  <?php } ?>
  <?php if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){ ?>
  <input type="hidden" name="upgradepakid" value="<?php echo esc_attr($_GET['upgradepakid']); ?>" />
  <?php } ?>
</form>
<?php } ?>
<script>



jQuery(document).ready(function(){ 


   <?php if(isset($_GET['eid'])){   
 
   $MyPackageId = 1; // default
   if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ $MyPackageId = get_post_meta($_GET['eid'],'packageID',true); }
   if(!is_numeric($MyPackageId)){ $MyPackageId = 1; }   
   ?>
   processPackage(<?php echo $MyPackageId; ?>);
   
   <?php }else{ ?> 
   
   

   <?php } ?>
   

	

}); 

function textarealimit(){
   
     
   	text_max = <?php if(!is_numeric(_ppt(array('lst', 'descmin' )))){ echo 100; }else{ echo _ppt(array('lst', 'descmin' )); } ?>;
   
     if(text_max == 0 || text_max == ""){
   	  jQuery('#textarea_counter').hide();
	  jQuery('#textarea_counter_hidden').val('1');
   	  return;
     }
	 
	 if(jQuery('#field-post_content').length){
	 
     	var text_length = jQuery('#field-post_content').val().length;
	 
		 var text_remaining = text_max - text_length;
		 if(text_remaining < 0){
		 jQuery('#textarea_counter').hide();
		 }
	   
		 jQuery('#textarea_counter span').html( '<b>' + text_remaining + '</b> <?php echo __("characters remaining","premiumpress"); ?>');
	   
		  jQuery('#field-post_content').keyup(function() {
		
			   var text_length = jQuery('#field-post_content').val().length;
			   var text_remaining = text_max - text_length; 
	   
			   jQuery('#textarea_counter span').html( '<b>' + text_remaining + '</b> <?php echo __("characters remaining","premiumpress"); ?>');
			
			if(text_remaining < 0){
				jQuery('#textarea_counter').hide();
				 jQuery('#textarea_counter_hidden').val('1');
			}else{
				jQuery('#textarea_counter').show();
				 jQuery('#textarea_counter_hidden').val('0');
			}
			
		  });
	  
	 
	 } 
	 
	 /* 
	 //var shortdesc_text_max = jQuery('#excerpt_counter_hidden').val();
     var excerpt_length = jQuery('#field-post_excerpt').val().length;	 
     var shortdesc_text_remaining = shortdesc_text_max - excerpt_length;     
	 
	 CheckLeft()
   
     jQuery('#excerpt_counter span').html( '<b>' + shortdesc_text_remaining + '</b> <?php echo __("characters remaining","premiumpress"); ?>');
   
      jQuery('#field-post_excerpt').keyup(function() {
	  
	  		CheckLeft()
   	
           var excerpt_length = jQuery('#field-post_excerpt').val().length;
           var shortdesc_text_remaining = shortdesc_text_max - excerpt_length; 
   
           jQuery('#excerpt_counter span').html( '<b>' + shortdesc_text_remaining + '</b> <?php echo __("characters remaining","premiumpress"); ?>');
   		
   		if(shortdesc_text_remaining < 0){
   			jQuery('#excerpt_counter').hide();
			 jQuery('#excerpt_counter_hidden').val('1');
   		}else{
   			jQuery('#excerpt_counter').show();
			 jQuery('#excerpt_counter_hidden').val('0');
   		}
   		
      });
	   */
	  
}

function CheckLeft(){

	var text_max 		= 90;
    var excerpt_length 	= jQuery('#field-post_excerpt').val().length;	 
  
	if(excerpt_length > text_max ){	 
	 	 
    	jQuery('#field-post_excerpt').val(jQuery('#field-post_excerpt').val().substr(0,text_max));
    }

}

	
function updatePackageID(id){


	<?php if(isset($_GET['eid']) && !is_admin() ){ ?>
	if(confirm("<?php echo __("Are you sure you want to change your package?","premiumpress"); ?>")) {
		   
		// PROCESS PACKAGE
		processPackage(id);
		
		// TUNR ON ADDON
		processPakageAddons(id);
		
		// CHECK IMAGE SPACE
		CheckuploadSpace();		
		
	}else{
	 	
		jQuery('.pakid-val[value="'+ jQuery('#packageID').val()+'"]').prop("checked", true);		
			 
	}
	<?php }else{ ?>
	 
 	
	// PROCESS PACKAGE
	processPackage(id);
	
	// TUNR ON ADDON
	processPakageAddons(id);
	
	// CHECK IMAGE SPACE
	CheckuploadSpace();
	
	<?php } ?>

}

function processPakageAddons(mid){

 
		// featured
		if(package[mid]['featured'] == 1){
			jQuery('#addon_featuredcheck').prop("checked", true).prop("disabled", true);
			jQuery('#addon_featuredadd').val(1);
			jQuery('.addon_featured .includedtext').show();	
			jQuery('.addon_featured .addonprice').hide();
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_featured .paymentform').hide();
			<?php } ?>	
			
		}else{
			jQuery('#addon_featuredcheck').prop("checked",false).prop("disabled", false);
			jQuery('#addon_featuredadd').val(0);
			jQuery('.addon_featured .includedtext').hide();	
			jQuery('.addon_featured .addonprice').show();	
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_featured .paymentform').show();
			<?php } ?>			
		}	
		
		// homepage
		if(package[mid]['homepage'] == 1){
			jQuery('#addon_homepagecheck').prop("checked", true).prop("disabled", true);
			jQuery('#addon_homepageadd').val(1);
			jQuery('.addon_homepage .includedtext').show();	
			jQuery('.addon_homepage .addonprice').hide();
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_homepage .paymentform').hide();
			<?php } ?>	
		
		}else{
			jQuery('#addon_homepagecheck').prop("checked",false).prop("disabled", false);
			jQuery('#addon_homepageadd').val(0);
			jQuery('.addon_homepage .includedtext').hide();	
			jQuery('.addon_homepage .addonprice').show();	
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_homepage .paymentform').show();	
			<?php } ?>			
		}	 
		 
		 
		 // sonsored
		if(package[mid]['sponsored'] == 1){
			jQuery('#addon_sponsoredcheck').prop("checked", true).prop("disabled", true);
			jQuery('#addon_sponsoredadd').val(1);
			jQuery('.addon_sponsored .includedtext').show();	
			jQuery('.addon_sponsored .addonprice').hide();	
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_sponsored .paymentform').hide();	
			<?php } ?>				
					
		}else{
			jQuery('#addon_sponsoredcheck').prop("checked",false).prop("disabled", false);
			jQuery('#addon_sponsoredadd').val(0);
			jQuery('.addon_sponsored .includedtext').hide();	
			jQuery('.addon_sponsored .addonprice').show();	
			<?php if(!isset($_GET['eid'])){ ?>
			jQuery('.addon_sponsored .paymentform').show();	
			<?php } ?>	
		
		}
		
		<?php if( is_admin() && !isset($_GET['eid']) ){ ?>
			jQuery("#listing_expiry_date").val(package[mid]['duration_date']);		
		<?php } ?>
 
}






function VALIDATE_FORM_DATA(){ 

	<?php if( in_array(THEME_KEY, array("dt","es")) && in_array(_ppt(array('design', "display_openinghours")), array("","1")) ){ ?>
	// BUSINESS HOURS PLUGIN
	jQuery('.startTime').attr('name', 'startTime[]');
	jQuery('.endTime').attr('name', 'endTime[]');
	jQuery('.isActive').attr('name', 'isActive[]');
	<?php } ?>
	

	canContinue = true;	
	
	 <?php if(!defined('WLT_CART')){ ?>
	<?php if(is_numeric(_ppt(array('lst', 'descmin' ))) && _ppt(array('lst', 'descmin' )) > 0){ ?>							
	// CHECK IF VALUE IS ON
	if(jQuery('#field-post_content').length){
	
		var text_length = jQuery('#field-post_content').val().length;	
		if( text_length < <?php echo _ppt(array('lst', 'descmin')); ?> ){	
		
			jQuery('#field-post_content').addClass('required-active').focus();
									
			alert("<?php echo __("Please enter a bigger description.","premiumpress"); ?>");
			return false;
		}	
	}						
	<?php } ?>
	<?php } ?>
	
	<?php if( THEME_KEY != "vt" && _ppt(array('lst', 'default_listing_require_image' )) == 1){ ?>
	if(jQuery('.preview').length == 0){	 
		setTimeout(function(){
			jQuery('#collapseFour').collapse('show');
		}, 1000); 
		alert("<?php echo __("Please upload an image.","premiumpress"); ?>");
		return false;
	}
	<?php } ?>
	
	// FIRE DEFAULT VALIDATION
	canContinue = js_validate_fields("<?php echo __("Please completed all required fields.","premiumpress"); ?>");	
	 
	// SHOW SPINNER
	if(canContinue){
	
		jQuery('#MAINCONTAINER').hide();
		jQuery('#core_saving_wrapper').show(); 
		
		// MOVE ALL FORM DATA INTO PLACE
		jQuery('.form-control').each(function(){
								 
			jQuery('#SUBMISSION_FORM').append(this);			 		
												
		});	
		
		
		// Check if TinyMCE is active
		if (typeof tinyMCE != "undefined" && jQuery('#editor_post_content').length > 0) {
		
			var activeEditor = tinyMCE.get('editor_post_content');
			if (tinyMCE.activeEditor != null){
			
				if(jQuery('#wp-editor_post_content-wrap').hasClass('html-active')){
				
					post_content_val = jQuery('#editor_post_content').val(); // HTML MODE
				
				}else{
					
					post_content_val = tinyMCE.activeEditor.getContent(); 
				
				}
			
			}else{
			
			post_content_val = jQuery('#editor_post_content').val();
			
			}
			 
			jQuery('#SUBMISSION_FORM').append('<textarea class="form-control" name="form[post_content]">'+post_content_val+'</textarea>');	 
		}
		 
         // Append the author dropdown value
        var authorValue = jQuery('#post_author_override').val();
        jQuery('#SUBMISSION_FORM').append('<input type="hidden" name="post_author_override" value="' + authorValue + '">');
		 	
	 
		// SAVE THE DATA		
		jQuery.ajax({
			type: "POST",
			url: '<?php echo home_url(); ?>/',		
			data: {
				action: "savelisting",
				data: jQuery('#SUBMISSION_FORM').serialize(), // serialize the form's data			 
		},
		success: function(response) {
			
			if(response == 0){ // ERROR
	
				alert('There was an error.');	 
	
			}else{// process
	
				if(response == "donothing"){			
					// STOP SPINNER
					jQuery('#core_saving_wrapper').html('listing updated');
				
				}else if(response.toLowerCase().indexOf("http") == -1){	
				 
				}else{
				
				// REDIRECT TO LISTING
				window.location.replace(response);
				
				}
				
				 
			}			
						
		}
		});		 
		 
		// end

	}
	
	return canContinue;
} 



/* =============================================================================
 JS TOKEN FIELDS
  ========================================================================== */	 
  
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=global.window&&global.window.$?a(global.window.$):function(b){if(!b.$&&!b.fn)throw new Error("Tokenfield requires a window object with jQuery or a jQuery instance");return a(b.$||b)}:a(jQuery,window)}(function(a,b){"use strict";var c=function(c,d){var e=this;this.$element=a(c),this.textDirection=this.$element.css("direction"),this.options=a.extend(!0,{},a.fn.tokenfield.defaults,{tokens:this.$element.val()},this.$element.data(),d),this._delimiters="string"==typeof this.options.delimiter?[this.options.delimiter]:this.options.delimiter,this._triggerKeys=a.map(this._delimiters,function(a){return a.charCodeAt(0)}),this._firstDelimiter=this._delimiters[0];var f=a.inArray(" ",this._delimiters),g=a.inArray("-",this._delimiters);f>=0&&(this._delimiters[f]="\\s"),g>=0&&(delete this._delimiters[g],this._delimiters.unshift("-"));var h=["\\","$","[","{","^",".","|","?","*","+","(",")"];a.each(this._delimiters,function(b,c){var d=a.inArray(c,h);d>=0&&(e._delimiters[b]="\\"+c)});var i,j=b&&"function"==typeof b.getMatchedCSSRules?b.getMatchedCSSRules(c):null,k=c.style.width,l=this.$element.width();j&&a.each(j,function(a,b){b.style.width&&(i=b.style.width)});var m="rtl"===a("body").css("direction")?"right":"left",n={position:this.$element.css("position")};n[m]=this.$element.css(m),this.$element.data("original-styles",n).data("original-tabindex",this.$element.prop("tabindex")).css("position","absolute").css(m,"-10000px").prop("tabindex",-1),this.$wrapper=a('<div class="tokenfield form-control" />'),this.$element.hasClass("input-lg")&&this.$wrapper.addClass("input-lg"),this.$element.hasClass("input-sm")&&this.$wrapper.addClass("input-sm"),"rtl"===this.textDirection&&this.$wrapper.addClass("rtl");var o=this.$element.prop("id")||(new Date).getTime()+""+Math.floor(100*(1+Math.random()));this.$input=a('<input type="'+this.options.inputType+'" class="token-input" autocomplete="off" />').appendTo(this.$wrapper).prop("placeholder",this.$element.prop("placeholder")).prop("id",o+"-tokenfield").prop("tabindex",this.$element.data("original-tabindex"));var p=a('label[for="'+this.$element.prop("id")+'"]');if(p.length&&p.prop("for",this.$input.prop("id")),this.$copyHelper=a('<input type="text" />').css("position","absolute").css(m,"-10000px").prop("tabindex",-1).prependTo(this.$wrapper),k?this.$wrapper.css("width",k):i?this.$wrapper.css("width",i):this.$element.parents(".form-inline").length&&this.$wrapper.width(l),(this.$element.prop("disabled")||this.$element.parents("fieldset[disabled]").length)&&this.disable(),this.$element.prop("readonly")&&this.readonly(),this.$mirror=a('<span style="position:absolute; top:-999px; left:0; white-space:pre;"/>'),this.$input.css("min-width",this.options.minWidth+"px"),a.each(["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],function(a,b){e.$mirror[0].style[b]=e.$input.css(b)}),this.$mirror.appendTo("body"),this.$wrapper.insertBefore(this.$element),this.$element.prependTo(this.$wrapper),this.update(),this.setTokens(this.options.tokens,!1,!this.$element.val()&&this.options.tokens),this.listen(),!a.isEmptyObject(this.options.autocomplete)){var q="rtl"===this.textDirection?"right":"left",r=a.extend({minLength:this.options.showAutocompleteOnFocus?0:null,position:{my:q+" top",at:q+" bottom",of:this.$wrapper}},this.options.autocomplete);this.$input.autocomplete(r)}if(!a.isEmptyObject(this.options.typeahead)){var s=this.options.typeahead,t={minLength:this.options.showAutocompleteOnFocus?0:null},u=a.isArray(s)?s:[s,s];u[0]=a.extend({},t,u[0]),this.$input.typeahead.apply(this.$input,u),this.typeahead=!0}};c.prototype={constructor:c,createToken:function(b,c){var d=this;if(b="string"==typeof b?{value:b,label:b}:a.extend({},b),"undefined"==typeof c&&(c=!0),b.value=a.trim(b.value.toString()),b.label=b.label&&b.label.length?a.trim(b.label):b.value,!(!b.value.length||!b.label.length||b.label.length<=this.options.minLength||this.options.limit&&this.getTokens().length>=this.options.limit)){var e=a.Event("tokenfield:createtoken",{attrs:b});if(this.$element.trigger(e),e.attrs&&!e.isDefaultPrevented()){var f=a('<div class="token" />').append('<span class="token-label" />').append('<a href="#" class="close" tabindex="-1">&times;</a>').data("attrs",b);this.$input.hasClass("tt-input")?this.$input.parent().before(f):this.$input.before(f),this.$input.css("width",this.options.minWidth+"px");var g=f.find(".token-label"),h=f.find(".close");return this.maxTokenWidth||(this.maxTokenWidth=this.$wrapper.width()-h.outerWidth()-parseInt(h.css("margin-left"),10)-parseInt(h.css("margin-right"),10)-parseInt(f.css("border-left-width"),10)-parseInt(f.css("border-right-width"),10)-parseInt(f.css("padding-left"),10)-parseInt(f.css("padding-right"),10),parseInt(g.css("border-left-width"),10)-parseInt(g.css("border-right-width"),10)-parseInt(g.css("padding-left"),10)-parseInt(g.css("padding-right"),10),parseInt(g.css("margin-left"),10)-parseInt(g.css("margin-right"),10)),g.text(b.label).css("max-width",this.maxTokenWidth),f.on("mousedown",function(){return d._disabled||d._readonly?!1:(d.preventDeactivation=!0,void 0)}).on("click",function(a){return d._disabled||d._readonly?!1:(d.preventDeactivation=!1,a.ctrlKey||a.metaKey?(a.preventDefault(),d.toggle(f)):(d.activate(f,a.shiftKey,a.shiftKey),void 0))}).on("dblclick",function(){return d._disabled||d._readonly||!d.options.allowEditing?!1:(d.edit(f),void 0)}),h.on("click",a.proxy(this.remove,this)),this.$element.trigger(a.Event("tokenfield:createdtoken",{attrs:b,relatedTarget:f.get(0)})),c&&this.$element.val(this.getTokensList()).trigger(a.Event("change",{initiator:"tokenfield"})),this.update(),this.$element.get(0)}}},setTokens:function(b,c,d){if(b){c||this.$wrapper.find(".token").remove(),"undefined"==typeof d&&(d=!0),"string"==typeof b&&(b=this._delimiters.length?b.split(new RegExp("["+this._delimiters.join("")+"]")):[b]);var e=this;return a.each(b,function(a,b){e.createToken(b,d)}),this.$element.get(0)}},getTokenData:function(b){var c=b.map(function(){var b=a(this);return b.data("attrs")}).get();return 1==c.length&&(c=c[0]),c},getTokens:function(b){var c=this,d=[],e=b?".active":"";return this.$wrapper.find(".token"+e).each(function(){d.push(c.getTokenData(a(this)))}),d},getTokensList:function(b,c,d){b=b||this._firstDelimiter,c="undefined"!=typeof c&&null!==c?c:this.options.beautify;var e=b+(c&&" "!==b?" ":"");return a.map(this.getTokens(d),function(a){return a.value}).join(e)},getInput:function(){return this.$input.val()},listen:function(){var c=this;this.$element.on("change",a.proxy(this.change,this)),this.$wrapper.on("mousedown",a.proxy(this.focusInput,this)),this.$input.on("focus",a.proxy(this.focus,this)).on("blur",a.proxy(this.blur,this)).on("paste",a.proxy(this.paste,this)).on("keydown",a.proxy(this.keydown,this)).on("keypress",a.proxy(this.keypress,this)).on("keyup",a.proxy(this.keyup,this)),this.$copyHelper.on("focus",a.proxy(this.focus,this)).on("blur",a.proxy(this.blur,this)).on("keydown",a.proxy(this.keydown,this)).on("keyup",a.proxy(this.keyup,this)),this.$input.on("keypress",a.proxy(this.update,this)).on("keyup",a.proxy(this.update,this)),this.$input.on("autocompletecreate",function(){var b=a(this).data("ui-autocomplete").menu.element,d=c.$wrapper.outerWidth()-parseInt(b.css("border-left-width"),10)-parseInt(b.css("border-right-width"),10);b.css("min-width",d+"px")}).on("autocompleteselect",function(a,b){return c.createToken(b.item)&&(c.$input.val(""),c.$input.data("edit")&&c.unedit(!0)),!1}).on("typeahead:selected typeahead:autocompleted",function(a,b){c.createToken(b)&&(c.$input.typeahead("val",""),c.$input.data("edit")&&c.unedit(!0))}),a(b).on("resize",a.proxy(this.update,this))},keydown:function(b){function c(a){if(e.$input.is(document.activeElement)){if(e.$input.val().length>0)return;a+="All";var c=e.$input.hasClass("tt-input")?e.$input.parent()[a](".token:first"):e.$input[a](".token:first");if(!c.length)return;e.preventInputFocus=!0,e.preventDeactivation=!0,e.activate(c),b.preventDefault()}else e[a](b.shiftKey),b.preventDefault()}function d(c){if(b.shiftKey){if(e.$input.is(document.activeElement)){if(e.$input.val().length>0)return;var d=e.$input.hasClass("tt-input")?e.$input.parent()[c+"All"](".token:first"):e.$input[c+"All"](".token:first");if(!d.length)return;e.activate(d)}var f="prev"===c?"next":"prev",g="prev"===c?"first":"last";e.$firstActiveToken[f+"All"](".token").each(function(){e.deactivate(a(this))}),e.activate(e.$wrapper.find(".token:"+g),!0,!0),b.preventDefault()}}if(this.focused){var e=this;switch(b.keyCode){case 8:if(!this.$input.is(document.activeElement))break;this.lastInputValue=this.$input.val();break;case 37:c("rtl"===this.textDirection?"next":"prev");break;case 38:d("prev");break;case 39:c("rtl"===this.textDirection?"prev":"next");break;case 40:d("next");break;case 65:if(this.$input.val().length>0||!b.ctrlKey&&!b.metaKey)break;this.activateAll(),b.preventDefault();break;case 9:case 13:if(this.$input.data("ui-autocomplete")&&this.$input.data("ui-autocomplete").menu.element.find("li:has(a.ui-state-focus), li.ui-state-focus").length)break;if(this.$input.hasClass("tt-input")&&this.$wrapper.find(".tt-cursor").length)break;if(this.$input.hasClass("tt-input")&&this.$wrapper.find(".tt-hint").val()&&this.$wrapper.find(".tt-hint").val().length)break;if(this.$input.is(document.activeElement)&&this.$input.val().length||this.$input.data("edit"))return this.createTokensFromInput(b,this.$input.data("edit"));if(13===b.keyCode){if(!this.$copyHelper.is(document.activeElement)||1!==this.$wrapper.find(".token.active").length)break;if(!e.options.allowEditing)break;this.edit(this.$wrapper.find(".token.active"))}}this.lastKeyDown=b.keyCode}},keypress:function(b){return-1!==a.inArray(b.which,this._triggerKeys)&&this.$input.is(document.activeElement)?(this.$input.val()&&this.createTokensFromInput(b),!1):void 0},keyup:function(a){if(this.preventInputFocus=!1,this.focused){switch(a.keyCode){case 8:if(this.$input.is(document.activeElement)){if(this.$input.val().length||this.lastInputValue.length&&8===this.lastKeyDown)break;this.preventDeactivation=!0;var b=this.$input.hasClass("tt-input")?this.$input.parent().prevAll(".token:first"):this.$input.prevAll(".token:first");if(!b.length)break;this.activate(b)}else this.remove(a);break;case 46:this.remove(a,"next")}this.lastKeyUp=a.keyCode}},focus:function(){this.focused=!0,this.$wrapper.addClass("focus"),this.$input.is(document.activeElement)&&(this.$wrapper.find(".active").removeClass("active"),this.$firstActiveToken=null,this.options.showAutocompleteOnFocus&&this.search())},blur:function(a){this.focused=!1,this.$wrapper.removeClass("focus"),this.preventDeactivation||this.$element.is(document.activeElement)||(this.$wrapper.find(".active").removeClass("active"),this.$firstActiveToken=null),!this.preventCreateTokens&&(this.$input.data("edit")&&!this.$input.is(document.activeElement)||this.options.createTokensOnBlur)&&this.createTokensFromInput(a),this.preventDeactivation=!1,this.preventCreateTokens=!1},paste:function(a){var b=this;b.options.allowPasting&&setTimeout(function(){b.createTokensFromInput(a)},1)},change:function(a){"tokenfield"!==a.initiator&&this.setTokens(this.$element.val())},createTokensFromInput:function(a,b){if(!(this.$input.val().length<this.options.minLength)){var c=this.getTokensList();return this.setTokens(this.$input.val(),!0),c==this.getTokensList()&&this.$input.val().length?!1:(this.$input.hasClass("tt-input")?this.$input.typeahead("val",""):this.$input.val(""),this.$input.data("edit")&&this.unedit(b),!1)}},next:function(a){if(a){var b=this.$wrapper.find(".active:first"),c=b&&this.$firstActiveToken?b.index()<this.$firstActiveToken.index():!1;if(c)return this.deactivate(b)}var d=this.$wrapper.find(".active:last"),e=d.nextAll(".token:first");return e.length?(this.activate(e,a),void 0):(this.$input.focus(),void 0)},prev:function(a){if(a){var b=this.$wrapper.find(".active:last"),c=b&&this.$firstActiveToken?b.index()>this.$firstActiveToken.index():!1;if(c)return this.deactivate(b)}var d=this.$wrapper.find(".active:first"),e=d.prevAll(".token:first");return e.length||(e=this.$wrapper.find(".token:first")),e.length||a?(this.activate(e,a),void 0):(this.$input.focus(),void 0)},activate:function(b,c,d,e){if(b){if("undefined"==typeof e)var e=!0;if(d)var c=!0;if(this.$copyHelper.focus(),c||(this.$wrapper.find(".active").removeClass("active"),e?this.$firstActiveToken=b:delete this.$firstActiveToken),d&&this.$firstActiveToken){var f=this.$firstActiveToken.index()-2,g=b.index()-2,h=this;this.$wrapper.find(".token").slice(Math.min(f,g)+1,Math.max(f,g)).each(function(){h.activate(a(this),!0)})}b.addClass("active"),this.$copyHelper.val(this.getTokensList(null,null,!0)).select()}},activateAll:function(){var b=this;this.$wrapper.find(".token").each(function(c){b.activate(a(this),0!==c,!1,!1)})},deactivate:function(a){a&&(a.removeClass("active"),this.$copyHelper.val(this.getTokensList(null,null,!0)).select())},toggle:function(a){a&&(a.toggleClass("active"),this.$copyHelper.val(this.getTokensList(null,null,!0)).select())},edit:function(b){if(b){var c=b.data("attrs"),d={attrs:c,relatedTarget:b.get(0)},e=a.Event("tokenfield:edittoken",d);if(this.$element.trigger(e),!e.isDefaultPrevented()){b.find(".token-label").text(c.value);var f=b.outerWidth(),g=this.$input.hasClass("tt-input")?this.$input.parent():this.$input;b.replaceWith(g),this.preventCreateTokens=!0,this.$input.val(c.value).select().data("edit",!0).width(f),this.update(),this.$element.trigger(a.Event("tokenfield:editedtoken",d))}}},unedit:function(a){var b=this.$input.hasClass("tt-input")?this.$input.parent():this.$input;if(b.appendTo(this.$wrapper),this.$input.data("edit",!1),this.$mirror.text(""),this.update(),a){var c=this;setTimeout(function(){c.$input.focus()},1)}},remove:function(b,c){if(!(this.$input.is(document.activeElement)||this._disabled||this._readonly)){var d="click"===b.type?a(b.target).closest(".token"):this.$wrapper.find(".token.active");if("click"!==b.type){if(!c)var c="prev";if(this[c](),"prev"===c)var e=0===d.first().prevAll(".token:first").length}var f={attrs:this.getTokenData(d),relatedTarget:d.get(0)},g=a.Event("tokenfield:removetoken",f);if(this.$element.trigger(g),!g.isDefaultPrevented()){var h=a.Event("tokenfield:removedtoken",f),i=a.Event("change",{initiator:"tokenfield"});d.remove(),this.$element.val(this.getTokensList()).trigger(h).trigger(i),(!this.$wrapper.find(".token").length||"click"===b.type||e)&&this.$input.focus(),this.$input.css("width",this.options.minWidth+"px"),this.update(),b.preventDefault(),b.stopPropagation()}}},update:function(){var a=this.$input.val(),b=parseInt(this.$input.css("padding-left"),10),c=parseInt(this.$input.css("padding-right"),10),d=b+c;if(this.$input.data("edit")){if(a||(a=this.$input.prop("placeholder")),a===this.$mirror.text())return;this.$mirror.text(a);var e=this.$mirror.width()+10;if(e>this.$wrapper.width())return this.$input.width(this.$wrapper.width());this.$input.width(e)}else{var f="rtl"===this.textDirection?this.$input.offset().left+this.$input.outerWidth()-this.$wrapper.offset().left-parseInt(this.$wrapper.css("padding-left"),10)-d-1:this.$wrapper.offset().left+this.$wrapper.width()+parseInt(this.$wrapper.css("padding-left"),10)-this.$input.offset().left-d;isNaN(f)?this.$input.width("100%"):this.$input.width(f)}},focusInput:function(b){if(!(a(b.target).closest(".token").length||a(b.target).closest(".token-input").length||a(b.target).closest(".tt-dropdown-menu").length)){var c=this;setTimeout(function(){c.$input.focus()},0)}},search:function(){this.$input.data("ui-autocomplete")&&this.$input.autocomplete("search")},disable:function(){this.setProperty("disabled",!0)},enable:function(){this.setProperty("disabled",!1)},readonly:function(){this.setProperty("readonly",!0)},writeable:function(){this.setProperty("readonly",!1)},setProperty:function(a,b){this["_"+a]=b,this.$input.prop(a,b),this.$element.prop(a,b),this.$wrapper[b?"addClass":"removeClass"](a)},destroy:function(){this.$element.val(this.getTokensList()),this.$element.css(this.$element.data("original-styles")),this.$element.prop("tabindex",this.$element.data("original-tabindex"));var b=a('label[for="'+this.$input.prop("id")+'"]');b.length&&b.prop("for",this.$element.prop("id")),this.$element.insertBefore(this.$wrapper),this.$element.removeData("original-styles").removeData("original-tabindex").removeData("bs.tokenfield"),this.$wrapper.remove(),this.$mirror.remove();var c=this.$element;return c}};var d=a.fn.tokenfield;return a.fn.tokenfield=function(b,d){var e,f=[];Array.prototype.push.apply(f,arguments);var g=this.each(function(){var g=a(this),h=g.data("bs.tokenfield"),i="object"==typeof b&&b;"string"==typeof b&&h&&h[b]?(f.shift(),e=h[b].apply(h,f)):h||"string"==typeof b||d||(g.data("bs.tokenfield",h=new c(this,i)),g.trigger("tokenfield:initialize"))});return"undefined"!=typeof e?e:g},a.fn.tokenfield.defaults={minWidth:60,minLength:0,allowEditing:!0,allowPasting:!0,limit:0,autocomplete:{},typeahead:{},showAutocompleteOnFocus:!1,createTokensOnBlur:!1,delimiter:",",beautify:!0,inputType:"text"},a.fn.tokenfield.Constructor=c,a.fn.tokenfield.noConflict=function(){return a.fn.tokenfield=d,this},c});


jQuery(window).on('load', function(){
jQuery('.tokenfield').tokenfield();
});

</script>
<?php } ?>
<?php } // end must be logged in ?>

<?php if(!$userdata->ID ){ ?>
<script>
function processPackage(mid){ }
</script>
<?php } ?>

<?php if($userdata->ID ){ ?>
<script>

function processPackage(mid){

	
	// REMOVE ANNOYING STICKY HEADERS
	jQuery('.elementor_header').removeClass('has-sticky');
	jQuery('.block-text6').hide();
	
	// SHOW / HIDE
	jQuery('#add-packages').hide();
	jQuery('#add-main').show();
	
	jQuery('#packageID').val(mid);

	// PROCESS
	if (typeof package[mid] !== "undefined") {
	
		textarealimit();
	 
		// package id
		<?php if(!isset($_GET['eid'])){ ?>
		jQuery('.pakid-val').prop("checked", false);	
		jQuery('.pakid-val[value="'+ mid+'"]').prop("checked", true);
		<?php } ?>			
			
		// images
		jQuery('.pak-images').html(package[mid]['images']);
		jQuery('.pak-videos').html(package[mid]['videos']);
		jQuery('.pak-duration').html(package[mid]['duration']);
		
		
		// EXTRA IF IS ADMIN
		<?php if( is_admin() ){ ?>
		
			jQuery('#addon_sponsoredcheck').prop("disabled", false);	
			jQuery('#addon_homepagecheck').prop("disabled", false);	
			jQuery('#addon_featuredcheck').prop("disabled", false);				
		 
		<?php }else{ ?>
		
			processPakageAddons(mid);
		
		<?php } ?>
		

		<?php if( isset($_GET['eid']) && get_post_meta($_GET['eid'], "sponsored", true) == 1){ ?>
			jQuery('#addon_sponsoredcheck').prop("checked",true).prop("disabled", false);	
			<?php if( !is_admin() ){ ?>
			jQuery('#addon_sponsoredcheck').prop("disabled", true);
			<?php } ?>
		<?php } ?>
			
		<?php if( isset($_GET['eid']) && get_post_meta($_GET['eid'], "homepage", true) == 1){ ?>
			jQuery('#addon_homepagecheck').prop("checked",true).prop("disabled", false);	
			<?php if( !is_admin() ){ ?>
			jQuery('#addon_homepagecheck').prop("disabled", true);
			<?php } ?>			
		<?php } ?>
			
		<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "featured", true) == 1){ ?>
			jQuery('#addon_featuredcheck').prop("checked",true).prop("disabled", false);	
			<?php if( !is_admin() ){ ?>
			jQuery('#addon_featuredcheck').prop("disabled", true);
			<?php } ?>			
		<?php } ?>
		
		
		// CATEGORY SETUP
		<?php if(!isset($_GET['eid'])){ ?>
		
		//console.log(package[mid]['category']+'<--');
		 
		
		if(package[mid]['category'] == 1  ){ //&& !jQuery('#parent_category_list').hasClass('selectpicker')
		
			
			jQuery("#parent_category_list").attr('multiple','multiple');
			
			jQuery("#parent_category_list").attr('data-show-subtext','true');
			jQuery("#parent_category_list").attr('data-live-search','true');
			jQuery("#parent_category_list").attr('data-size','10');					
			jQuery("#parent_category_list").attr('name','form[category][]');
			jQuery('#parent_category_list').addClass('selectpicker');
			jQuery("#parent_category_list").selectpicker('destroy');
			jQuery("#parent_category_list").selectpicker("refresh");
			jQuery("#parent_category_list").addClass('border');				 
  
		}else{
		
			jQuery('#parent_category_list').removeClass('selectpicker');
			jQuery("#parent_category_list").removeAttr('multiple');
			jQuery("#parent_category_list").selectpicker('destroy');			
			jQuery("#parent_category_list").attr('name','form[category][0]');
			
		}
		<?php } ?>
		
		// VIDEO ACCESS
		if(package[mid]['videos'] == 1){
			jQuery('.access_video_msg').hide();	
			jQuery('.access_video_options').show();		
		}else{
			jQuery('.access_video_msg').show();	
			jQuery('.access_video_options').hide();			
		}
		
		// DISABLE FORM
		if(jQuery('#photoscount').lenght > 0 && package[mid]['videos'] > 0 ){		
			CheckuploadSpace();
		}
		
		// PHOTOS
		jQuery("#photoscount .badge-success").html(package[mid]['images']);
		jQuery("#photoscount").show();
		CheckuploadSpace();
		
		
		 <?php if(is_admin()){ ?>
		 
		  jQuery('.access_image_msg').hide();
		  jQuery('#fileupload').show();
		  if( package[mid]['images'] == 0){
		  jQuery("#photoscount .badge-success").html(999);
		  jQuery("#photoscount").hide();
		  ///jQuery('.pak-images').html('9999');
		  }
		  
		<?php }else{ ?> 
		if( package[mid]['images'] == 0){
		
		jQuery('.access_image_msg').show();
		jQuery('#fileupload').hide();
		
		} else {
		
		jQuery('.access_image_msg').hide();
		jQuery('#fileupload').show();
		
		}
		<?php } ?> 
		
		
		// CHANGE STEPS
      	 ChangeSteps(2);
		
	}

}
function ChangeSteps(step){ 

   
   	if(step == 1){   		
   		    		 
   		jQuery('#step-packages').show();		
   		jQuery('#step-content').hide();	
   		
   	}else if(step == 2){
   		    		
   		jQuery('#step-packages').hide();		
   		jQuery('#step-content').show();	   	
   	}
	
} 
</script>
<?php } ?>
<div class="scroll-nav-wrapper"></div>