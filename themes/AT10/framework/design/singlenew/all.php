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

global $CORE, $post, $userdata;


$SetThis = _ppt(array('design','single_layout'));

 

if(defined('WLT_DEMOMODE') && isset($_GET['style']) && is_numeric($_GET['style'])){
	switch($_GET['style']){
		case "2": {
			$SetThis = "global_design2";
		} break;
		case "3": {
			$SetThis = "global_design3";
		} break;
		 
	}
}

switch($SetThis){
case "2":
case "global_design2": {
 
	_ppt_template( 'framework/design/singlenew/designs/global_design2' );

} break;

case "3":
case "global_design3": {
 
	_ppt_template( 'framework/design/singlenew/designs/global_design3' );

} break;

default: {

$GLOBALS['global_design1'] = 1;

?>

<div class="container my-4">
  <div class="row">
    <div class="col-lg-8 col-xl-9">
      <?php 
	
	$pageLinkingID = _ppt_pagelinking("listingpage");
	if( substr($pageLinkingID ,0,9) == "elementor" ){
  
	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");
	
	}else{ 
	
	?>
      <div class="row">
      
      <?php if(_ppt(array('design','single_top')) != "hide"){ ?> 
        <div class="col-12">
          <?php _ppt_template( 'framework/design/singlenew/blocks/top' );  ?>
        </div>
        
        <?php } ?>
        
        <?php if(_ppt(array('design','single_ml')) != "hide"){ ?> 
        <div class="col-md-6 mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/photos' );  ?>
        </div>
        <?php } ?>
        
        <?php if(_ppt(array('design','single_mr')) != "hide"){ ?>
        <div class="col-md-6 mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/videos' );  ?>
        </div>
        <?php } ?>
       
	   <?php if(defined('THEME_KEY') && !in_array(THEME_KEY, array("sp","cp","vt","ll"))){ ?>
         
         <?php if(_ppt(array('design','single_bl')) != "hide"){ ?>
        <div class="<?php if(_ppt(array('design','single_br')) != "hide"){ ?>col-md-6<?php }else{ ?>col-12<?php } ?> mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/customfields' );  ?>
        </div>
        <?php } ?>
        
        <?php if(_ppt(array('design','single_br')) != "hide"){ ?>
        <div class="<?php if(_ppt(array('design','single_bl')) != "hide"){ ?>col-md-6<?php }else{ ?>col-12<?php } ?> mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/features' );  ?>
        </div>
        <?php } ?>        
        <?php } ?>
      </div>
      <?php } ?>
      
      
      <?php
	  
	  // WIDGET WIDEBAR
	  dynamic_sidebar("single_middle"); 
	  
	  ?>
      
    </div>
    <div class="col-lg-4 col-xl-3">
      <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-'.THEME_KEY );  ?>
      
              
        <?php if(!in_array(THEME_KEY, array("ph","dl","dt")) || in_array(_ppt(array('design', 'display_subbar')), array("0")) ){  ?>
<?php if(in_array(_ppt(array('design', 'display_addthis')), array("","1"))){ ?>
<div class="text-center mb-4"><div class="addthis_inline_share_toolbox"></div> </div>          
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6041aeed65b26d12"></script>
<?php } ?> 
<?php } ?>
      
		  <?php
          
          // WIDGET WIDEBAR
            dynamic_sidebar("single_sidebar");           
          ?>
          
          <?php // ADVERTISING
		if($CORE->ADVERTISING("check_exists", "single_sidebar") ){ ?>
        
				<div class="mt-4 text-center"> <?php echo $CORE->ADVERTISING("get_banner", "single_sidebar" );  ?> </div>
                
		<?php } ?>


    </div>
  </div>
</div>
<div class="limit-box"></div>
<?php

if(defined('THEME_KEY') && !in_array(THEME_KEY, array("cp"))){

 
if(in_array(_ppt(array('design', 'display_related')), array("","1"))){
_ppt_template( 'framework/design/singlenew/blocks/related' ); 
}

}

 ?>
 
<?php } break;

} // end switch ?> 
 
<div class="scroll-nav-wrapper"></div>
 
<!--msg model -->
<div class="editlisting-modal-wrap shadow hidepage" style="display:none;">
  <div class="editlisting-modal-wrap-overlay"></div>
  <div class="editlisting-modal-item">
    <div class="editlisting-modal-container"> 
     <form method="post" class="p-0 m-0" onsubmit="return processEditSubmitData()">
     <input type="hidden" name="liveeditlisting" value="1" />
      <input type="hidden" name="eid" value="<?php echo $post->ID; ?>" />
      <div class="card-body">
     
         <div id="ajax-editlisting-form"></div>
        <div class="editlisting-modal-close text-center"><i class="fa fa-times">&nbsp;</i></div>
      </div>
      <div class="card-footer text-center">
      <button  class="btn btn-system shadow-sm btn-xl btn-icon icon-before m-2"><i class="fal fa-sync mr-2 text-primary"></i> <?php echo __("Save Changes","premiumpress"); ?></button>
      </div>
    </div>
     </form>
  </div>
</div>

<script>
function processEditSubmitData(){
	// BUSINESS HOURS PLUGIN
	jQuery('.startTime').attr('name', 'startTime[]');
	jQuery('.endTime').attr('name', 'endTime[]');
	jQuery('.isActive').attr('name', 'isActive[]');
	
	return true;
}
function processEditData(btype){

    jQuery.ajax({
        type: "POST",
        url: ajax_site_url,		
   		data: {
               action: "load_editlisting_form",		
			   type: btype,
			   eid: <?php echo $post->ID; ?>   
           },
           success: function(response) { 
		   
		   		jQuery(".editlisting-modal-wrap").fadeIn(400);
   				jQuery('#ajax-editlisting-form').html(response);
				    			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
}

<?php if($post->post_author == $userdata->ID){ ?>

jQuery(document).ready(function(){ 

	jQuery('.addeditmenu').each(function () {	
	
		icon = "fal fa-pencil";
		css = "float-right position-relative hide-mobile <?php if(isset($GLOBALS['global_design3'])){ echo "mr-3"; } ?>";
		
		
		if( jQuery(this).attr("data-key") == "top"){
		icon = "fal fa-camera";
		} else if( jQuery(this).attr("data-key") == "video"){
		icon = "fal fa-video";
		} else if( jQuery(this).attr("data-key") == "images"){
		icon = "fal fa-image";
		
		} else if( jQuery(this).attr("data-key") == "imagestop"){
		icon = "fal fa-image";
		css = " position-relative float-left hide-mobile";
		
		} else if( jQuery(this).attr("data-key") == "titletop"){
		icon = "fal fa-pencil";
		css = " position-relative float-left hide-mobile";
		
		
		} else if (jQuery(this).attr("data-key")  == "videoseries"){
		icon = "fal fa-film";
		//css = " position-relative hide-mobile ";
		}
		  
		jQuery(this).html('<span class="'+css+'"><a href="javascript:void(0);" onclick="processEditData(\''+jQuery(this).attr("data-key")+'\');" class="single-page-edit-button single-page-edit-button-bg"><i class="'+icon+' text-white"></i><span class="ripple single-page-edit-button-bg"></span><span class="ripple single-page-edit-button-bg"></span><span class="ripple single-page-edit-button-bg"></span></a></span>');	
	});



});
<?php } ?> 


/*EXTRA MODAL */
	jQuery(".editlisting-modal-close, .editlisting-modal-wrap-overlay").on("click", function (e) {
        jQuery(".editlisting-modal-wrap").fadeOut(400);		
    });
	
</script>
