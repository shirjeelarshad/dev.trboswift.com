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

if(isset($_GET['post'])){ $_GET['eid'] = $_GET['post']; }

$counter = 1; $media = "";
if(isset($_GET['eid'])){

	$media = $CORE->MEDIA("get_all_images", $_GET['eid']);	 
	
	$bgimg = get_post_meta($_GET['eid'], "backgroundimg", true);
	$custombgid = 0;
	
	if(substr($bgimg,0,6) == "custom"){
		$custombgid = str_replace("custom-","", $bgimg);
	}
		
}
 
 
?>


<div class="card shadow-sm mt-4">
  <div class="card-body">
    <h4><?php echo __("Photos","premiumpress"); ?></h4>
    <hr class="pb-0 mb-0" />
   
<div class="col-12 access_image_msg" style="display:none;"> 


<div class="bg-white y-middle">
      <div class="p-4 text-center">
        <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class="mt-4 small"><?php echo __("You've run out of image space or have no access to this feature.","premiumpress"); ?></div>         
        </div>
    </div>
       
    
</div>
 


<form <?php if($userdata->ID ){ ?>id="fileupload" action="<?php echo get_home_url(); ?>/index.php" method="POST" enctype="multipart/form-data"<?php } ?>>
  <?php  /*if(is_array($media) && count($media) > 0 ){ }else{ ?>
  <!--- PREVIEW IMAGE -->
  <div class="bg-light rounded text-center py-5" id="addimagesiconbox"> <i class="fa fa-image fa-3x opacity-5"></i>
    <div class="opacity-5 mt-3"><?php echo __("Images","premiumpress"); ?></div>
  </div>
  <?php } */?>
  
  <!--- UPLOAD BUTTONS -->
  <div class="fileupload-loading"></div>
  <div class="fileupload-buttonbar">
    <div class="mt-2">
    
    <?php if(is_admin()  ){ ?>
    
    <div class="text-right small mb-2">
    
    <a href="javascript:void(0);"  <?php if(!isset($_GET['eid'])){ ?> onclick="SaveReloadMe1();"<?php }else{ ?>id="selectmediafile"<?php } ?> class="btn btn-system  <?php if(!isset($_GET['eid'])){ ?>opacity-5<?php } ?>"><?php echo __("select WP media file","premiumpress"); ?></a>
    
    </div>
    
    <script>
	
function SaveReloadMe1(){

alert("<?php echo __("Please save the current changes first before adding attachments.","premiumpress"); ?>");

jQuery("#mainSaveBtn").trigger('click');
}

jQuery(document).ready(function() {

var my_original_editor = window.send_to_editor;


 	jQuery('#selectmediafile').click(function() {           
           
		   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		   
			window.send_to_editor = function(html) {	
			
			console.log(html);
			 		
				var regex = /src="(.+?)"/;
				var rslt =html.match(regex);
				 
				var imgrex = /wp-image-(.+?)"/;
				var imgid = html.match(imgrex);
			 
				var imgurl = rslt[1];
				var imgaid = imgid[1];
				
				
				jQuery(this).removeClass('btn-icon').html("<i class='fas fa-spinner fa-spin'></i>");
		
				jQuery.ajax({
					type: "POST",
					url: ajax_site_url,	
					dataType: 'json',	
					data: {
						'action': "upload_wpmediafile",
						'aid': imgaid,	
						'aurl': imgurl,
						'pid': <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0;} ?>,				 
					},
					success: function(response) {
						 
						if(response.status == "ok"){
							  
jQuery("#mediatablelist").append('<div class="uploaditem border-top pt-3 template-download <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo esc_attr($_GET['eid']); }else{ echo 0;} ?>bb in"><div class="row"><div class="col-md-3 preview"><a href="'+imgurl+'" title="0.jpg" rel="gallery" download="0.jpg"><img src="'+imgurl+'" class="img-fluid"></a></div><div class="col-md-7"><div class="mb-1 text-muted small">Display Caption</div><input type="text" value="0.jpg" id="media-title-566" onchange="ajax_media_edit(\''+imgaid+'\', \''+imgaid+'\');" class="form-input col-md-12"></div><div class="col-md-1 text-center"><div class=" bits delete mt-4"><button class="btn  rounded-0 p-0  bg-light text-dark btndeleteme " onclick="PreCheckuploadSpace();" data-type="DELETE" data-url="'+imgaid+'---<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo esc_attr($_GET['eid']); }else{ echo ""; } ?>">	<i class="fa fa-trash m-0 px-2"></i></button>	</div>	</div></div></div>');
						
						} 
						 			
					},
					error: function(e) {
					   console.log('error getting search results');
					}
				}); 
				
				tb_remove();
				
				window.send_to_editor = my_original_editor;
			 
			 
			}		   
		   
		   
           return false;
    });
               		
 

}); 
</script>
    
    <?php } ?>
    
   
	
      <div class="custom-file">
        <input type="file" name="files[]" id="image_upload_field" class="custom-file-input" multiple="" <?php if(!$userdata->ID ){ ?>disabled <?php } ?> onclick="PreCheckuploadSpace();jQuery('#mainuploadbutton, #uploadlalbtn').show();">
        <label class="custom-file-label"><?php echo __("Select Photo","premiumpress"); ?></label>
      </div>
      <div class="container px-0">
        <div class="row">
          <div class="col-md-5">
              
              <?php /*
               <button type="button" id="uploadlalbtn" class="btn btn-dark btn-sm rounded-0 start"  style="display:none;"> <i class="fa fa-upload"></i> <span><?php echo __("Upload All","premiumpress"); ?></span> </button>
          */ ?>
          
            <div class="text-muted small mt-4" id="photoscount" style="display:none;">
			<?php echo str_replace("%s",'<span class="badge badge-success">100</span>',__("Up to %s photos.","premiumpress")); ?>
            <?php echo str_replace("%s",'<span class="badge  badge-warning">1</span>',__("%s left.","premiumpress")); ?>
            </div> 
         
            
           </div>
          <div class="col-md-7 text-md-right">
          
           
            <div class="small my-3 text-muted"><?php echo __("*.jpg, *.png and *.jpeg formats only.","premiumpress"); ?> 
            
            
            <?php  echo "<strong>(".__("Max size:","premiumpress").ini_get('upload_max_filesize').")</strong>";   ?> 
             
            
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <ul id="mediatablelist" class="files pl-0  mt-4 list-unstyled">
    <?php
         
         
         if(isset($_GET['eid']) && is_array($media) && !empty($media)){ 
         foreach($media as $img){
		 
         ?>
    <li class="mt-0 position-relative">
    <div class="featured-ribbon hide-mobile"><span><?php echo __("Featured Image","premiumpress"); ?></span></div>
      <input type="hidden" value="<?php echo $img['order']; ?>" data-pid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo esc_attr($_GET['eid']); }else{ echo $img['postID']; } ?>" data-aid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>" class="dorder" id="media-order-<?php echo $img['id']; ?>"  />
    
    
      <div class="uploaditem  border-top pt-3 template-upload clearfix ftype_<?php echo substr($img['type'],0,5); ?> imgshow<?php echo $counter; ?>"
      
      
      data-pid="<?php echo $img['postID']; ?>"
      data-aid="<?php echo $img['id']; ?>"
      
      >
        <div class="row">
          <div class="col-md-3 preview">
            <?php  echo $CORE->media_display($img);  ?>
          </div>
          <div class="col-md-9">
            <div class="small font-weight-bold mb-3"><?php echo __("Display Caption","premiumpress"); ?></div>
            <input type="text" value="<?php echo get_the_title($img['id']); ?>" 
                  id="media-title-<?php echo $img['id']; ?>" class="form-control w-100 rounded-0" onchange="ajax_media_edit(<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); } ?>,'<?php echo $img['id']; ?>')" />
            <div class="mt-1 extra-small text-uppercase text-muted"> <span class="mt-2">
              <?php if(isset($img['size'])){ echo $CORE->_format_bytes($img['size']); } ?>
              / <?php echo $CORE->_format_type($img['type']); ?>
              <?php if(isset($img['dimentions']) && strlen($img['dimentions']) > 1){ echo "/ ".$img['dimentions']; } ?>
              </span> 
              
              </div>
            <button class="btn  btn-md mt-4"  type="button" onclick="jQuery('.imgshow<?php echo $counter; ?>').removeClass('uploaditem');ajax_media_delete('<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ if(is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); } }else{ echo $img['postID']; } ?>','<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>','<?php echo $counter; ?>');PreCheckuploadSpace();"> <i class="fa fa-trash m-0 mr-2" id="<?php echo $counter; ?>delbtn"></i> <?php echo __("Delete","premiumpress"); ?> </button>
            
            
            <?php if(in_array(_ppt(array('design','single_top')), array("","text","text-big"))){ ?>
            
            <button class="btn  btn-md mt-4 <?php if($custombgid == $img['id']){ echo "activebgimg"; } ?>" id="<?php echo $counter; ?>setbgbtn" type="button" onclick="ajax_media_setbg('<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ if(is_numeric($_GET['eid'])){  echo esc_attr($_GET['eid']); } }else{ echo $img['postID']; } ?>','<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>','<?php echo $counter; ?>');"> 
            
            
            
            <i class="<?php if($custombgid == $img['id']){ ?>fa fa-camera text-success <?php }else{ ?>fal fa-camera  mr-2<?php } ?> m-0"></i> <?php  echo __("Set Background","premiumpress");  ?>
          
             </button>
             <?php } ?>
             
             
             
          </div>
          <!-- end row -->
        </div>
      </div>
      <div class="clearfix"></div>
    </li>
    <?php $counter++; } } ?>
  </ul>
  
  <?php if(isset($_GET['eid']) && !isset($_POST['ajaxedit']) ){ ?>
  <div class="mt-3"><div class="bg-light small p-2 text-center"><i class="fa fa-sliders-v-square mr-2"></i> <?php echo __("Hold + drag any image to change display order.","premiumpress"); ?></div> </div>
  <?php } ?>
  
</form>
<?php if($userdata->ID ){ ?>
<script>
 
jQuery(document).ready(function(){ 

 // MAKE SORTABLE
	<?php  if(isset($_GET['eid']) && !isset($_POST['ajaxedit']) ){ ?>
	setTimeout(function(){
	jQuery( "#mediatablelist" ).sortable({
	
		stop: function( ) {
            //var order = $("#sortable").sortable("serialize", {key:'order[]'});
            //$( "p" ).html( order );
			setorder(1);
			//setorder();
        } 
	});
	}, 1500);  
	<?php } ?>
	
	// SET DEFAULT ORDER
 	setorder(0);
	 
	
});


</script>
<form method="post" action="<?php echo get_home_url(); ?>/index.php" target="core_delete_attachment_iframe" name="core_delete_attachment" id="core_delete_attachment">
  <input type="hidden"  name="core_delete_attachment" value="gogo" />
  <input type="hidden" id="attachement_id" name="attachement_id" value="" />
</form>
<iframe frameborder="0" style="display:none;" scrolling="auto" name="core_delete_attachment_iframe" id="core_delete_attachment_iframe"></iframe>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger">{%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem template-upload notuploaded">
<div class="row">
    <div class="col-lg-3 col-md-6 preview">
        <span class=""></span>
    </div>
    <div class="col-md-6 col-lg-9">  
	<span class="fname">{%=file.name%}</span>  
<progress class="progress progress-success progress-striped active w-100 mr-4 mb-4" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" value="0" max="100" style="height:15px !important;"></progress>
 
{% if (!o.options.autoUpload) { %}
<span class="start"><button class="btn btn-system btn-md shadow-sm btn-sm "><i class="fa fa-check m-0 px-2"></i></button></span>
{% } %}   
{% if (!i) { %}
<span class="cancel"><button class="btn btn-system btn-md shadow-sm btn-sm btndeleteme" onclick="PreCheckuploadSpace();"><i class="fa fa-trash m-0 px-2"></i></button></span>
{% } %}        
</div>
<div class="clearfix"></div>	
</div></div>
{% } %}
{% } %}
</script>


<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"  style="display:none;"><b><?php echo __("Error","premiumpress"); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem border-top pt-3  template-download  {%=file.aid%}bb" data-aid="{%=file.aid%}">
<div class="row">
<div class="col-md-3 preview">
<a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}" class='img-fluid'></a>
</div>
<div class="col-md-7">
<div class="mb-1 text-muted small"><?php echo __("Display Caption","premiumpress"); ?></div>
<input type="text" value="{%=file.name%}" id="media-title-{%=file.aid%}" onchange="ajax_media_edit('<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); } ?>', '{%=file.aid%}');" class="form-input col-md-12" />
</div>
    <div class="col-md-1 text-center">     
    <div class=" bits delete mt-4">	 
	<button class="btn btn-sm rounded-0 p-0  bg-light text-dark btndeleteme " onclick="PreCheckuploadSpace();" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	<i class="fa fa-trash m-0 px-2"></i>            
	</button>
	</div>	
</div>
</div></div>
{% } %}
{% } %}
</script>

<script>


jQuery(document).ready(function(){ 
	
 
    jQuery('#fileupload').fileupload({
		 
        url: '<?php echo get_home_url(); ?>/index.php',
		type: 'POST',
		paramName: 'core_attachments',
		//fileTypes: '/^image\/(gif|jpeg|png)$/',
		formData: {  name: 'core_post_id', value: <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0; } ?>   },		
	 
		change: function (e, data) {		
			setTimeout(function(){ StartAutoUpload(); }, 1000 );                
         }, 
		 
	    success: function(response) {
	  
		  if(typeof response['error'] == "undefined" ){
			   
					<?php if(!isset($_GET['eid'])){ ?>
					jQuery('#SUBMISSION_FORM').append('<input type="hidden" value="'+response[0]['pid']+'" name="eid" />');
					<?php } ?>
					
					// UPDATE COUNTER			
					totalM = parseFloat(jQuery('#mediaspaceused').html());
					if(totalM < 0){ totalM = 0; }
					totalM = totalM + 1;
					jQuery('#mediaspaceused').html(totalM);
			
			} else {
			
			alert(response['error']);
			
			}
				
			},
			error: function(e) {
				console.log(e)
			}
		 
	});	
 
	
	// CHECK UPLOAD SPACE
	 setTimeout(function(){ CheckuploadSpace(); }, 2000 );
 
	jQuery('#fileupload').bind('fileuploadadd', function (e, data) {	
	
	 // CHECK WE HAVE ENOUGH SPACE LEFT
	 setTimeout(function(){ CheckuploadSpace(); }, 1000 );
	
	});

	
	jQuery('#fileupload').bind('fileuploaddestroy', function (e, data) {	 
	 
		document.getElementById('attachement_id').value= data.url;
		document.core_delete_attachment.submit();	
	}); 
	
	
 });
  
function StartAutoUpload(){


	CheckuploadSpace();
		
	jQuery('#mediatablelist .start').each(function(i, obj) {		
			jQuery(obj).find('button').trigger('click').hide();					  
	});	


}

function PreCheckuploadSpace(){
			  
		 setTimeout(function(){ CheckuploadSpace(); }, 1000 );
} 

function CheckuploadSpace(){
		
		
		c = jQuery('#mediatablelist .uploaditem .preview').length;	
			
		var maximages = parseFloat(jQuery('#photoscount .badge-success').html());
		 
		var spaceleft = maximages - parseFloat(c);
	 	 
		jQuery('#photoscount .badge-warning').html(spaceleft);			 
	 
	 	if(c == maximages ){
		
			jQuery("#image_upload_field").prop( "disabled", true );
	 
		}else if(c > maximages ){
		
			jQuery("#image_upload_field").prop( "disabled", true );
			jQuery("#uploadlalbtn").hide();
			jQuery("#ajax_media_msg").html("<?php echo trim(__("Upload Space Exceeded","premiumpress")); ?>");
			//jQuery('#mediatablelist .uploaditem:last').html('');
			
			// REMOVE IMAGES
			var total_to_remove = jQuery('#mediatablelist .uploaditem').length - maximages;			
			 
			//1. START BY CLEARING NEWLY ADED ITEMS
			jQuery('#mediatablelist .uploaditem.notuploaded').each(function(i, obj) {	
				
				 if(total_to_remove > 0 ){					 
				 	jQuery(obj).removeClass('uploaditem').html('');//.hide();					
					 
					total_to_remove--;
					
				 }			
			
			});
			
			// 2. NOW REMOVE OLD ITEMS
			jQuery('#mediatablelist .uploaditem:not(.notuploaded)').each(function(i, obj) {			 
			   	
				 if(total_to_remove > 0 ){					 						 
				 	
					ajax_media_delete(jQuery(this).attr('data-pid'),jQuery(this).attr('data-aid'),'0');
					jQuery(obj).removeClass('uploaditem').html('');//.hide();				  				 
				 	
					
					total_to_remove--;
				 } 
				 
			});	
 	
			
		} else{ 
			
			jQuery("#ajax_media_msg").html("");
			jQuery("#image_upload_field").prop( "disabled", false );
			if(c > 0){
			jQuery("#uploadlalbtn").show();
			}
		
		}
}
 

</script>
<?php } ?>

<?php if(isset($_POST['ajaxedit'])){ ?>

<script src="<?php echo home_url(); ?>/wp-includes/js/jquery/ui/sortable.js?ver=1.12.1" id="jquery-ui-sortable-js"></script>
<script src="<?php echo home_url(); ?>/wp-includes/js/jquery/ui/droppable.js?ver=1.12.1" id="jquery-ui-droppable-js"></script>

<script src="<?php echo FRAMREWORK_URI.'js/'; ?>js.plugins-upload.js?ver=10.5.7"></script>
<link rel="stylesheet" type="text/css" href="<?php echo FRAMREWORK_URI.'css/'; ?>_submitform.css" />

<script>var package = [];</script>
<?php if( $CORE->LAYOUT("captions","listings") ){	 ?>
<div style="display:none">
  <?php _ppt_template('framework/design/add/add-packages' ); ?>
</div>
<?php } ?>
<script>

function processPackage(mid){

		// PHOTOS
		jQuery("#photoscount .badge-success").html(package[mid]['images']);
		jQuery("#photoscount").show();
		CheckuploadSpace();
		
		if( package[mid]['images'] == 0){
		
		jQuery('.access_image_msg').show();
		jQuery('#fileupload').hide();
		
		} else {
		
		jQuery('.access_image_msg').hide();
		jQuery('#fileupload').show();
		
		}
		 


}
jQuery(document).ready(function() {

   <?php if(isset($_GET['eid'])){   
 
   $MyPackageId = 1; // default
   if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ $MyPackageId = get_post_meta($_GET['eid'],'packageID',true); }
   if(!is_numeric($MyPackageId)){ $MyPackageId = 1; }   
   ?>
   processPackage(<?php echo $MyPackageId; ?>);
   <?php }else{ ?> 
   

   <?php } ?>
});

</script>

<?php } ?>


  </div>
</div>