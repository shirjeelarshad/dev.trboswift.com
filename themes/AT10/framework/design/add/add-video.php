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


$counter = 1; $videos = ""; $videothumbs = "";

if(isset($_GET['eid'])){
 
	$videos = $CORE->MEDIA("get_all_videos", $_GET['eid']);	
	
	if(THEME_KEY == "vt" && is_array($videos) && !empty($videos) ){ 
	
         foreach($videos as $k => $img){
		 
			 if($img['type'] == "image/jpg"){
			 unset($videos[$k]);
			 }
		 
		 }
	}
	 
		
	
	$videothumbs = $CORE->MEDIA("get_all_videothumbnails", $_GET['eid']);	
	 
}
 

?>

<div class="row">
  <div class="col-12 access_video_msg" style="display:none;">
  
  
   <div class="bg-white y-middle">
      <div class="p-4 text-center">
        <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class="mt-4 small"><?php echo __("Please upgrade or select a different package to access this feature.","premiumpress"); ?></div>         
        </div>
    </div>
   
  </div>
  <div class="col-12 access_video_options">
    <div class="bg-light p-4">
    
    
        
            <?php if(is_admin()  ){ ?>
    
    <span class="float-right small">
    
    <a href="javascript:void(0);"  <?php if(!isset($_GET['eid'])){ ?> onclick="SaveReloadMe();"<?php }else{ ?>id="selectmediafile1"<?php } ?> class="btn btn-system btn-sm <?php if(!isset($_GET['eid'])){ ?>opacity-5<?php } ?>"><?php echo __("select WP media file","premiumpress"); ?></a>
    
    </span>
    
    <script>
	
function SaveReloadMe(){

alert("<?php echo __("Please save the current changes first before adding attachments.","premiumpress"); ?>");

jQuery("#mainSaveBtn").trigger('click');
}

jQuery(document).ready(function() {

var my_original_editor = window.send_to_editor;


 	jQuery('#selectmediafile1').click(function() {           
           
		   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		   
			window.send_to_editor = function(html) {	
			
			 	
				
				jQuery(this).removeClass('btn-icon').html("<i class='fas fa-spinner fa-spin'></i>");
		
				jQuery.ajax({
					type: "POST",
					url: ajax_site_url,	
					dataType: 'json',	
					data: {
						'action': "upload_wpmediafile",
						//'aid': imgaid,	
						'title': html,
						'video': 1,
						'pid': <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0;} ?>,				 
					},
					success: function(response) {
						 
						if(response.status == "ok"){
							  
							  jQuery('.videoupload-buttonbar').hide();
							  jQuery("#mainSaveBtn").trigger("click");
						
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
    
    
      <div class="font-weight-bold"><?php echo __("Upload Video File","premiumpress"); ?></div>
      <hr />
      <div class="small text-muted mb-4"> <?php echo __(".flv or .mp4 video formats only.","premiumpress") ?> <?php  echo "<strong>(".__("Max size:","premiumpress").ini_get('upload_max_filesize').")</strong>";   ?>  </div>
      <form id="videoupload"  <?php if($userdata->ID ){ ?>action="<?php echo get_home_url(); ?>/index.php" method="POST" enctype="multipart/form-data"<?php } ?>>
        <!--- UPLOAD BUTTONS -->
        <div class="videoupload-loading"></div>
        <div class="videoupload-buttonbar">
        
        

        
        
        
        
        
        
        
          <div class="d-flex justify-content-between align-items-center mt-2">
          
          
          
          
          
          
          
          
          
          
          
            <div class="custom-file" <?php if(isset($_GET['eid']) && is_array($videos) && !empty($videos)){ echo "style='display:none;'"; }?>>
              <input type="file"  name="files[]"class="custom-file-input" multiple="" <?php if(!$userdata->ID ){ ?>disabled <?php } ?>>
              <label class="custom-file-label"><?php echo __("Select Video","premiumpress") ?></label>
            </div>
          </div>
        </div>
        <ul id="video-mediatablelist" class="files pl-0 list-unstyled pb-0">
          <?php
        
         
         if(isset($_GET['eid']) && is_array($videos) && !empty($videos)){ 
         foreach($videos as $img){
		 
		
		 
         	 
         ?>
          <li class="">
            <input type="hidden" value="<?php echo $img['order']; ?>" data-pid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo esc_attr($_GET['eid']); }else{ echo $img['postID']; } ?>" data-aid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>" class="dorder" id="media-order-<?php echo $img['id']; ?>"  />
            
            <div class="uploaditem template-upload clearfix ftype_<?php echo substr($img['type'],0,5); ?> imgshow<?php echo $counter; ?> ">
              <div class="row">
          
                
                <div class="col-12 position-relative">
                
                <a href="<?php echo $img['src']; ?>" target="_blank" class="btn btn-sm btn-system float-right shadow-sm" style="text-transform:uppercase !important;"><?php echo __("preview video","premiumpress"); ?></a>
                    
                
                  <div class="small font-weight-bold mb-3"><?php echo __("Display Caption","premiumpress"); ?></div>
                 
                 <div class="input-group">  
                
                 
                  <input type="text" value="<?php echo get_the_title($img['id']); ?>" 
                  id="media-title-<?php echo $img['id']; ?>" class="form-control w-100 rounded-0" style="padding-left:40px !important;" placeholder="<?php echo __("Media Caption","premiumpress"); ?>" onchange="ajax_video_edit(<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); } ?>,'<?php echo $img['id']; ?>')" />
                  
                   <div class="position-absolute text-muted" style="bottom: 8px;    left: 10px;"><i class="fa fa-video"></i> </div>

                  
                  </div>
                  
                  <div class="mt-1 extra-small text-uppercase text-muted"> <span class="mt-2 float-left">
                    <?php if(isset($img['size'])){ echo $CORE->_format_bytes($img['size']); } ?>
                    / <?php echo $CORE->_format_type($img['type']); ?>
                    <?php if(isset($img['dimentions']) && strlen($img['dimentions']) > 1){ echo "/ ".$img['dimentions']; } ?> / <?php echo basename($img['filepath']); ?>
                    
                    <?php if(isset($img['time'])){ echo "/ ".$img['time']." ".__("seconds","premiumpress"); } ?>
                     
                    </span>
                    <button class="btn btn-sm rounded-0 p-0 float-right px-2 bg-light text-dark prev" 
                     type="button" 		
                        data-placement="top"
                        data-original-title="<?php echo __("Delete","premiumpress"); ?>" 
                                data-toggle="tooltip"              
                        onclick="ajax_media_delete('<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo esc_attr($_GET['eid']); }else{ echo $img['postID']; } ?>','<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>','<?php echo $counter; ?>');jQuery('#videoupload .custom-file').show();"> <i class="fa fa-trash m-0 prev" id="<?php echo $counter; ?>delbtn"></i> </button>
                  </div>
                </div>
                <!-- end row -->
              </div>
            </div>
            <div class="clearfix"></div>
          </li>
          <?php $counter++; } } ?>
        </ul>
      </form>
    </div>
  </div>
  <div class="col-12 mt-n4 access_video_options" <?php if(isset($_POST['ajaxedit'])){ ?>style="display:none"<?php } ?>>
    <div class="bg-light p-4">
    
    
    
    
    <?php if(is_admin() ){ ?>
    
    <span class="float-right small">
    
    <a href="javascript:void(0);" <?php if(!isset($_GET['eid'])){ ?> onclick="SaveReloadMe();"<?php }else{ ?>id="selectmediafile2"<?php } ?>class="btn btn-system btn-sm <?php if(!isset($_GET['eid'])){ ?>opacity-5<?php } ?>"><?php echo __("select WP media file","premiumpress"); ?></a>
    
    </span>
    
    <script>

jQuery(document).ready(function() {

var my_original_editor = window.send_to_editor;


 	jQuery('#selectmediafile2').click(function() {           
           
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
						'videothumb': 1,
						'pid': <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0;} ?>,				 
					},
					success: function(response) {
						 
						if(response.status == "ok"){
						
						
						
						// DELETE EXISTING ONE
						
						// DELETE
						jQuery(".listthumbnails button").trigger('click');
						
						
						jQuery(".listthumbnails").html('');
						
						jQuery(".listthumbnails").append('<div class="uploaditem border-top pt-3 template-download <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0;} ?>bb in"><div class="row"><div class="col-md-3 preview"><a href="'+imgurl+'" title="0.jpg" rel="gallery" download="0.jpg"><img src="'+imgurl+'" class="img-fluid"></a></div><div class="col-md-7"><div class="mb-1 text-muted small">Display Caption</div><input type="text" value="0.jpg" id="media-title-566" onchange="ajax_media_edit(\''+imgaid+'\', \''+imgaid+'\');" class="form-input col-md-12"></div><div class="col-md-1 text-center"><div class=" bits delete mt-4"><button class="btn btn-sm rounded-0 p-0  bg-light text-dark btndeleteme prev" onclick="PreCheckuploadSpace();" data-type="DELETE" data-url="'+imgaid+'---<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo ""; } ?>">	<i class="fa fa-trash m-0 px-2"></i></button>	</div>	</div></div></div>');
						
						
	
							  
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
    
    
    
    
    
    
      <div class="font-weight-bold"><?php echo __("Video Thumbnail","premiumpress"); ?> </div>
      <hr />
      <div class="small text-muted mb-4"><?php echo __("Image size: 800 x 600px recommended.","premiumpress"); ?></div>
      <form id="videothumbnail"  <?php if($userdata->ID ){ ?> action="<?php echo get_home_url(); ?>/index.php" method="POST" enctype="multipart/form-data"<?php } ?>>
        <div class="videoupload-loading"></div>
        <div class="videoupload-buttonbar">
          <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="custom-file" <?php if(isset($_GET['eid']) && is_array($videothumbs) && !empty($videothumbs)){ echo "style='display:none;'"; }?>>
              <input type="file"  name="files[]" class="custom-file-input" multiple="" <?php if(!$userdata->ID ){ ?>disabled <?php } ?>>
              <label class="custom-file-label"><?php echo __("Select Thumbnail","premiumpress") ?></label>
            </div>
          </div>
        </div>
        <ul id="video-mediatablelist" class="files pl-0 list-unstyled listthumbnails">
          <?php 
         if(isset($_GET['eid']) && is_array($videothumbs) && !empty($videothumbs)){ 
         foreach($videothumbs as $img){
         	 
         ?>
          <li>
            <input type="hidden" value="<?php echo $img['order']; ?>" data-pid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo esc_attr($_GET['eid']); }else{ echo $img['postID']; } ?>" data-aid="<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>" class="dorder" id="media-order-<?php echo $img['id']; ?>"  />
            <div class="uploaditem  border-top pt-3 template-upload clearfix ftype_<?php echo substr($img['type'],0,5); ?> imgshow<?php echo $counter; ?>">
              <div class="row">
                <div class="col-12 preview">
                  <?php  echo $CORE->media_display($img);  ?>
                </div>
                <div class="col-12">
                  <input type="hidden" value="<?php echo get_the_title($img['id']); ?>" 
                  id="media-title-<?php echo $img['id']; ?>" class="form-control w-100 rounded-0" placeholder="<?php echo __("Media Caption","premiumpress"); ?>" onchange="ajax_video_edit(<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); } ?>,'<?php echo $img['id']; ?>')" />
                  <div class="mt-1 extra-small text-uppercase text-muted"> <span class="mt-2 float-left">
                    <?php if(isset($img['size'])){ echo $CORE->_format_bytes($img['size']); } ?>
                    / <?php echo $CORE->_format_type($img['type']); ?>
                    <?php if(isset($img['dimentions']) && strlen($img['dimentions']) > 1){ echo "/ ".$img['dimentions']; } ?>
                    </span>
                    <button class="btn btn-sm rounded-0 p-0 float-right px-2 bg-light text-dark prev" 
                     type="button" 		
                        data-placement="top"
                        data-original-title="<?php echo __("Delete","premiumpress"); ?>" 
                                data-toggle="tooltip"              
                        onclick="ajax_media_delete('<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo esc_attr($_GET['eid']); }else{ echo $img['postID']; } ?>','<?php if( !isset($img['postID']) || ( isset($img['postID']) && $img['postID'] == "") ){ echo "9999"; }else{ echo $img['id']; } ?>','<?php echo $counter; ?>');jQuery('#videothumbnail .custom-file').show();"> <i class="fa fa-trash m-0" id="<?php echo $counter; ?>delbtn"></i> </button>
                  </div>
                </div>
                <!-- end row -->
              </div>
            </div>
            <div class="clearfix"></div>
          </li>
          <?php $counter++; } }else{ ?>
         
          <?php } ?>
        </ul>
      </form>
    </div>
  </div>
</div>
<?php if($userdata->ID ){ ?>
<script>
 
jQuery(document).ready(function(){ 
 
	// MAKE SORTABLE
	<?php  if(isset($_GET['eid'])){ ?>
	setTimeout(function(){
	jQuery( "#video-mediatablelist" ).sortable({
	
		stop: function( ) {
            //var order = $("#sortable").sortable("serialize", {key:'order[]'});
            //$( "p" ).html( order );
			video_setorder(1);
			//video_setorder();
        } 
	});
	}, 1500);  
	<?php } ?>
	
	// SET DEFAULT ORDER
 	video_setorder(0);
 	
	<?php if(isset($_GET['eid']) && is_array($videos) && !empty($videos)){  ?>
	// IF USER HAS AN IMAGE ALREADY, SKIP TO NEXT SECTION
		jQuery('#collapseFour').collapse('toggle');
		setTimeout(function(){
		jQuery('#collapseOne').collapse('show');
		 }, 1000); 
	<?php } ?>
	
	
	
	
});
function video_setorder(saveorder){
	
	jQuery('#ajax_video_msg').html();
	var order = 1;
	jQuery('.dorder').each(function(i, obj) {
			jQuery(obj).val(order);
			order = order +1;
	});
	
	if(saveorder == 1){
		jQuery('.dorder').each(function(i, obj) {
			 
				ajax_video_order(jQuery(obj).data('pid'), jQuery(obj).data('aid'), jQuery(obj).val());
				 
		});
	}	
}
function ajax_video_order(id, attachmentid, orderid){

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		data: {
            action: "set_media_order",		  
			pid: id,
			aid: attachmentid,
			order: orderid,
			 
        },
        success: function(response) {
			
			jQuery('#ajax_video_msg').html("<?php echo __("Order Updated","premiumpress"); ?>");
		 	console.log("order updated");
			
        },
        error: function(e) {
			console.log("error settings order "+e);
            //alert("error settings order "+e)
        }
    });

}	
function ajax_video_edit(id, attachmentid){

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		data: {
            action: "set_media_title",		  
			pid: id,
			aid: attachmentid,
			title: jQuery('#media-title-'+attachmentid).val(),
			order: jQuery('#media-order-'+attachmentid).val(),
			 
        },
        success: function(response) {
			
			jQuery('#ajax_video_msg').html(response);
			jQuery('#editmediabox').show();
			
        },
        error: function(e) {
            //console.log(e)
        }
    });

}


function ajax_video_delete(id, attachmentid, counter){
	
	
	jQuery('#'+counter+'delbtn').removeClass('fa-trash').addClass('fa-spin fa-spinner');
	
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		data: {
            action: "delete_file",		  
			pid: id,
			aid: attachmentid,	
			stopc:1,		 
        },
        success: function(response) {
			
			jQuery('.imgshow' + counter).hide();
			jQuery('.imgshow' + counter).html('');
			
			// UPDATE COUNTER			
			totalM = parseFloat(jQuery('#videopaceused').html());
			if(totalM == 0){ totalM = 1; }
			totalM = totalM - 1;
			jQuery('#videopaceused').html(totalM)
			
        },
        error: function(e) {
            console.log(e)
        }
    });

}

</script>
<form method="post" action="<?php echo get_home_url(); ?>/index.php" target="core_delete_video_attachment_iframe" name="core_delete_attachment_video" id="core_delete_attachment_video">
  <input type="hidden"  name="core_delete_attachment_video" value="gogo" />
  <input type="hidden" id="video_attachmentid" name="video_attachmentid" value="" />
</form>
<iframe frameborder="0" style="display:none;" scrolling="auto" name="core_delete_video_attachment_iframe" id="core_delete_video_attachment_iframe"></iframe>
<!-- The template to display files available for upload -->
<script id="video-template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
{% } else { %}
<div class="uploaditem template-upload ">
<div class="row">
    <div class="col-12 preview">
        <span class=""></span>
    </div>
    <div class="col-12">  
	<span class="fname">{%=file.name%}</span>  
<progress class="progress progress-success progress-striped active w-100 mr-4 mb-4" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" value="0" max="100" style="height:15px !important;"></progress>
 
{% if (!o.options.autoUpload) { %}
<span class="start"><button class="btn btn-system btn-block btn-md shadow-sm btn-sm "><i class="fa fa-check m-0 px-2"></i></button></span>
{% } %}   
{% if (!i) { %}
<span class="cancel"><button class="btn btn-system btn-block mt-4 btn-md shadow-sm btn-sm btndeleteme"><i class="fa fa-trash m-0 px-2"></i></button></span>
{% } %}        
</div>
<div class="clearfix"></div>	
</div></div>
{% } %}
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="video-template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"  style="display:none;"><b><?php echo __("Error","premiumpress"); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem border-top pt-3  template-download  {%=file.aid%}bb">
<div class="row">
<div class="col-12 preview">
<a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}" class='img-fluid'></a>
</div> <div class="col-12">     
    <div class=" bits delete mt-4">	 
	<button class="btn  btn-block btn-system btn-md shadow-sm btndeleteme"   data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	<i class="fa fa-trash m-0 px-2"></i>            
	</button>
	</div>	
</div>
</div></div>
{% } %}
{% } %}
</script>
<script>

function StartAutoVideoUpload(){
 
		
	jQuery('#video-mediatablelist .start').each(function(i, obj) {		
			jQuery(obj).find('button').trigger('click').hide();					  
	});	


}

jQuery(document).ready(function(){ 


jQuery('#videoupload').fileupload({

		dropZone: null,
		
        url: "<?php echo get_home_url(); ?>/index.php",
		type: 'POST',
		maxNumberOfFiles: 1,
	 
		uploadTemplateId: "video-template-upload",
		downloadTemplateId:  "video-template-download",
		paramName: 'core_attachments',
		//fileTypes: '/^image\/(gif|jpeg|png)$/',
		formData: {  name: 'core_post_id', value: <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0; } ?>   },
	  
	  
	  	change: function (e, data) {
		 
				
			setTimeout(function(){ StartAutoVideoUpload(); }, 500 );                
         }, 
	  
	    success: function(response) {
		
			jQuery('#videoupload .custom-file').hide();
	  
		  if(typeof response['error'] == "undefined" ){
								  
				jQuery('#SUBMISSION_FORM').append('<input type="hidden" value="'+response[0]['pid']+'" name="eid" />');					 
					 
			} else {
			
				alert(response['error']);
			
			}
			
        },
        error: function(e) {
            console.log(e)
        }
	 
});	


jQuery('#videoupload').bind('fileuploaddestroy', function (e, data) {
	document.getElementById('video_attachmentid').value= data.url;
	document.core_delete_attachment_video.submit();	
}); 
	


jQuery('#videothumbnail').fileupload({

 		dropZone: null,
		
        url: "<?php echo get_home_url(); ?>/index.php",
		type: 'POST', 		
		uploadTemplateId: "video-template-upload",
		downloadTemplateId:  "video-template-download",
		paramName: 'core_videothumb',
		fileTypes: '/^image\/(gif|jpeg|jpg|png)$/',
		maxNumberOfFiles: 1,
		formData: {  name: 'core_post_id', value: <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0; } ?>   },
	    
		change: function (e, data) {		
			setTimeout(function(){ StartAutoVideoUpload(); }, 1000 );                
         }, 
		 
		success: function(response) {
	   
		   jQuery('#videothumbnail .custom-file, .previewvideothumbnail').hide();
			
        },
        error: function(e) {
            console.log(e)
        }
	 
});	
 


}); 
  
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

// VIDEO ACCESS
		if(package[mid]['videos'] == 1){
			jQuery('.access_video_msg').hide();	
			jQuery('.access_video_options').show();		
		}else{
			jQuery('.access_video_msg').show();	
			jQuery('.access_video_options').hide();			
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