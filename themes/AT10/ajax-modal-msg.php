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
	
	$randomnum = rand(0,100000);
	 
	
	  $canShow = true;
   	  if(_ppt(array('mem','enable'))  == '1' && _ppt('mem0_view_listing') != "" && $CORE->USER("membership_hasaccess", "max_msg")){
	  
			// CHECK USER CREDIT
			if($CORE->USER("get_user_free_membership_addon", array("max_msg", $userdata->ID)) > 0){
			
			}else{
			
			$canShow = false;
			}
	  
	  }
	 
	if(!$CORE->USER("membership_hasaccess", "msg_send")){
	
	?>
<div style="min-height:300px;" class="bg-white y-middle">
  <div class="p-4 text-center">
    <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
    <div class="mt-4 small"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></div>
    <a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=membership" class="btn btn-system btn-md mt-4"><?php echo __("View My Membership","premiumpress"); ?></a> </div>
</div>
<?php
	
	}elseif(isset($_POST['uid']) && is_numeric($_POST['uid']) && $userdata->ID ) {
	
	$settings = array();
	$settings['job_seller_id'] = $userdata->ID;
	$settings['job_buyer_id'] = $_POST['uid'];
	$settings['pid']=1;
	
	$chat_div_id = "#chatbetween_".$settings['job_seller_id']."_".$settings['job_buyer_id'];
 

?>
<div class="card card-body border-0">
  <h5 class="modal-title text-muted"><i class="fal fa-comments-alt mr-2"></i> <?php echo $CORE->USER("get_username", $_POST['uid']); ?> </h5>
  <hr />
  <div style="    height: 280px;    overflow: auto;  overflow-y: scroll;" id="<?php echo str_replace("#","",$chat_div_id); ?>"></div>
  <hr />
  <div class="smilesbox" style="display:none;">
    <ul class="list-inline">
      <?php
  
  $smiles = $CORE->USER("smiles",0); $si=0;
  foreach($smiles as $smile){ ?>
      <li class="list-inline-item"> <a href="javascript:void(0);" onclick="addSmile(<?php echo $si; ?>)"><i class='ppt-smile-icon icon-<?php echo $smile; ?>'></i></a> </li>
      <?php $si++; } ?>
    </ul>
  </div>
  <div class="mb-2">
  
    <?php if(_ppt(array('user','allow_profile')) == 1 && $CORE->USER("count_listings", $_POST['uid']) != 0 ){ ?>
    <a href="<?php echo $CORE->USER("get_user_profile_link", $_POST['uid']); ?>" class="btn btn-system float-right btn-sm ml-2"><i class="fal fa-search"></i> <?php echo __("view profile","premiumpress") ?></a>
    <?php } ?>
    
    
    <?php if( !in_array(THEME_KEY, array("dt","sp","cm","cp","vt","jb","rt","so","cp","ph","es"))  && _ppt(array('user','friends')) == 1 && isset($_POST['uid']) && is_numeric($_POST['uid']) ){ ?>
    <?php echo do_shortcode('[SUBSCRIBE class="btn btn-system float-right btn-sm" count=0 text=1 uid="'.$_POST['uid'].'"]'); ?>
    <?php } ?>
    <a href="javascript:void(0);" onclick="jQuery('.smilesbox').toggle();" class="btn btn-system float-right btn-sm mr-2"><i class="fal fa-smile"></i> <?php echo __("smilies","premiumpress") ?></a> </div>
  <textarea class="form-control chattextbox" style="height:50px;" id="ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg"></textarea>
  <div class="fileupload-buttonbar" style="display:none;">
    <div class="d-flex justify-content-between align-items-center mt-2">
      <div class="custom-file">
        <!-- The HTML -->
        <form id="ppt_chat_send_<?php echo $settings['pid']; ?>_file_form" name="ppt_chat_send_<?php echo $settings['pid']; ?>_file_form" method="post" action="<?php echo home_url(); ?>" enctype="multipart/form-data">
          <input type="file" id="ppt_chat_send_<?php echo $settings['pid']; ?>_file" name="file" class="custom-file-input">
          <input type="hidden" action="chat_upload" value="1" />
        </form>
<script>

var chatRefresh = 0;

if (typeof count === "undefined") {
var count = 0;
}

function addSmile(sid){

jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg").val("[smile:"+sid+"]");
ppt_chat_send_<?php echo $settings['pid']; ?>();

jQuery('.smilesbox').toggle();

}

jQuery(document).ready(function(){  

	ajax_chat_logs_<?php echo $settings['pid']; ?>();
 
 	if(count == 0){
	WindowRefresh();
	}

});


function WindowRefresh() {

		//console.log(count +'<--'); 
	 
         if(count == 10) {
		 
             ajax_chat_logs_<?php echo $settings['pid']; ?>();
			 
			 count  = 0;
			 
			  setTimeout(WindowRefresh, 1000);
			 
         } else { 
		 
             setTimeout(WindowRefresh, 1000);
			 
		}
		
		count ++;
} 
 


// The Javascript
var form = document.getElementById('ppt_chat_send_<?php echo $settings['pid']; ?>_file_form');

form.onsubmit = function() {

		var fd = new FormData(form);
        fd.append("action", "chat_upload");
		 
        jQuery.ajax({
            url: '<?php echo home_url(); ?>/',
			enctype: 'multipart/form-data',
            type: 'POST',
			dataType: 'json',	
            data: fd,
            success: function(response) {
 
				if(response.status == "ok"){
					
					jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg").hide().val("[aid"+response.aid+"]");
					ppt_chat_send_<?php echo $settings['pid']; ?>();
					jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg").show();
			
				}else{
				
				alert(response.msg);
				
				}
			   
			   // CLOSE BOX
			   jQuery('.fileupload-buttonbar').toggle();
            },
			
            cache: false,
            contentType: false,
            processData: false
        });


  jQuery(form).trigger("reset");
  return false; // To avoid actual submission of the form
}



jQuery(document).ready(function(){
        jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_file").change(function(){		
		jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_file_form").submit(); 
        });
});
</script>
        <label class="custom-file-label" for="gallery"><?php echo __("Select .zip, .jpg or .png files only.","premiumpress"); ?></label>
      </div>
    </div>
  </div>
  <?php /*
  <a href="javascript:void(0);" onclick="jQuery('.fileupload-buttonbar').toggle();" class="btn btn-secondary btn-sm btn-icon icon-before"><i class="fa fa-upload"></i> <?php echo __("Attach File","premiumpress"); ?></a> 
  */ ?>
</div>
</div>
<div class="card-footer text-center">
<?php if($canShow){ ?>
  <button type="button"  onclick="ppt_chat_send_<?php echo $settings['pid']; ?>();"  class="btn btn-system shadow-sm btn-xl btn-icon icon-before m-2"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Send Message","premiumpress") ?></button>
  <?php }else{ ?>
  <a href="<?php echo _ppt(array('links','myaccount'))."?noaccess=1&showtab=membership&op=max_msg"; ?>"class="btn btn-system shadow-sm btn-xl btn-icon icon-before m-2"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Send Message","premiumpress") ?></a>
  <?php } ?>
</div>
<script>

 
function ppt_chat_send_<?php echo $settings['pid']; ?>(){
 										   
										   
var msg = jQuery("#ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg").val();
var msgcheck 	= document.getElementById("ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg"); 

 
if(msgcheck.value == '')
{
      		alert('<?php echo __("Please enter a message.","premiumpress") ?>');
      		msgcheck.focus();
      		msgcheck.style.border = 'thin solid red';
      		return false;
}


jQuery("#chat_msg").val('');
	
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "send_chat_msg",
			
			<?php if(isset($_POST['pid']) && is_numeric($_POST['pid'])){ ?>
			pid: "<?php echo $_POST['pid']; ?>",
			<?php } ?>
			 
			
			<?php  if( $settings['job_seller_id'] == $userdata->ID  ){ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_buyer_id']; ?>,
			
			<?php  }else{ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_seller_id']; ?>,
			
			<?php } ?> 
			
			msg: msg,			
        },
        success: function(response) {
 			
			if(response.status == "noupdate"){			
			
  
			}else if(response.status == "ok"){
			
				// RELOAD CHAT WINDOW
				ajax_chat_logs_<?php echo $settings['pid']; ?>();	
				
				// SCROL TO BOTTOM				 	  
				jQuery('<?php echo $chat_div_id; ?>').stop().animate({ scrollTop: jQuery('<?php echo $chat_div_id; ?>').get(0).scrollHeight}, "slow");				 
					
				jQuery(".chattextbox").val('');		 	 
			 			 
  		 	
			}else{			
				jQuery('#ajax_chat_list').html("Could not get message data - try again later 4.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
 		
}

var firstloat = 1;

function ajax_chat_logs_<?php echo $settings['pid']; ?>(){

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "load_chat_data",
			fullaccess: 1,
			forceload: firstloat,
			limit: 5,
			
			
			
			<?php  if( $settings['job_seller_id'] == $userdata->ID  ){ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_buyer_id']; ?>,
			
			<?php  }else{ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_seller_id']; ?>,
			
			<?php } ?>
			
		 
        },
        success: function(response) {
		
			firstloat = 2;
		
			if(response.status == "noupdate"){
			
			
  
			}else if(response.status == "ok"){
			
				jQuery('<?php echo $chat_div_id; ?>').html('<div class="text-center mt-5 pt-5 col-12"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
				
				if(response.output == ""){
				
				jQuery('<?php echo $chat_div_id; ?>').html('<div class="col-12 text-center mt-5 pt-5"><i class="fal fa-comments fa-4x mb-4 btn-block"></i><?php echo __("You have no chat history.","premiumpress") ?></div>');	
				//jQuery('.discussion-message').hide();		 	 
				
				}else{
				
				 	// SHOW MESSAGE				
					jQuery('<?php echo $chat_div_id; ?>').html(response.output);	
					
					// SCROL TO BOTTOM				 	  
					jQuery('<?php echo $chat_div_id; ?>').stop().animate({ scrollTop: jQuery('<?php echo $chat_div_id; ?>').get(0).scrollHeight}, "slow");
		 		}			   
  		 	
			}else{			
				jQuery('<?php echo $chat_div_id; ?>').html("Could not get message data - try again later 123.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure

</script>
<?php }else{ ?>
<form id="sendmsgform<?php echo $randomnum; ?>" name="sendmsgform" method="post" action="">
  <div class="modal-header border-0">
    <h5 class="modal-title text-muted"><i class="fal fa-envelope mr-2"></i> <?php echo __("Send Message","premiumpress") ?></h5>
    <?php if(isset($GLOBALS['flag-account'])){ ?>
    <button type="button" class="close msg-modal-close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <?php } ?>
  </div>
  <div class="modal-body" >
    <div class="ajax_msgform_output_ok" style="display:none;">
      <div class="alert alert-success text-center small">
        <div class="mb-4 mt-2"><i class="fal fa-smile fa-4x"></i></div>
        <?php echo __("Message Sent Successfully.","premiumpress") ?> </div>
    </div>
    <div class="ajax_msgform_output_error" style="display:none;">
      <div class="alert alert-danger text-center small">
        <div class="mb-4 mt-2"><i class="fal fa-frown fa-4x"></i></div>
        <?php echo __("Error Sending Message.","premiumpress") ?> </div>
    </div>
    <div  class="ajax_msgform_error text-danger font-weight-bold mt-n2"></div>
    <div class="form-group userfieldmsg">
      <label class="font-weight-bold text-uppercase"><?php echo __("Username","premiumpress"); ?> <span class="ajaxMsgUser"></span> </label>
      <div class="input-group">
        <input class="form-control rounded-0 userf" id="usernamefield" name="username" type="text"  value="">
      </div>
    </div>
    <div class="form-group">
      <label class="font-weight-bold text-uppercase"><?php echo __("Message","premiumpress"); ?></label>
      <textarea rows="3" class="form-control rounded-0 msgf" id="newmsgcontent"  style="height:60px;" name="message"></textarea>
    </div>
    <script>


  jQuery(document).ready(function(){ 
         jQuery('#sendmsgform<?php echo $randomnum; ?> #usernamefield').change(function() { 
         
             jQuery.ajax({
                 type: "POST",
                 url: '<?php echo home_url(); ?>/',		
         		data: {
                     action: "validateUsername",
         			name: jQuery('#sendmsgform<?php echo $randomnum; ?> #usernamefield').val(), 
                 },
                 success: function(response) {
         		 
         			if(response == "yes"){
         			jQuery('#sendmsgform<?php echo $randomnum; ?> .ajaxMsgUser').html("<span class='badge badge-success'><i class='fa fa-check-circle'></i> <?php echo __("Valid Username","premiumpress"); ?></span>");
         			
					jQuery('#sendmsgform<?php echo $randomnum; ?> button').show();
					
					} else {
         			jQuery('#sendmsgform<?php echo $randomnum; ?> .ajaxMsgUser').html("<span class='badge badge-danger'><i class='fa fa-close'></i> <?php echo __("Invalid Username","premiumpress"); ?></span>");
         			
					jQuery('#sendmsgform<?php echo $randomnum; ?> button').hide();
					
					}			
                 },
                 error: function(e) {
                     console.log(e)
                 }
             });
         
         });
		 });

function CheckMsgFormData<?php echo $randomnum; ?>()
   { 
   	 
		 
		
		jQuery("#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_error").html('');	
		 
		if( jQuery("#sendmsgform<?php echo $randomnum; ?> .userf").val() == '')
		{
			jQuery("#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_error").html("<?php echo __("Please enter a valid username.","premiumpress") ?>");			  
			jQuery("#sendmsgform<?php echo $randomnum; ?> .userf").css('border', '1px solid red');			  
			return false;
		} 		
	 
	   
		if(jQuery("#sendmsgform<?php echo $randomnum; ?> .msgf").val() == "")
		{
			jQuery("#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_error").html("<?php echo __("Please enter a valid message.","premiumpress") ?>");
			jQuery("#sendmsgform<?php echo $randomnum; ?> .msgf").css('border', '1px solid red');
			return false;
		}  
	 
		if( jQuery("#sendmsgform<?php echo $randomnum; ?> .msgf").val().length < 5)
		{
			jQuery("#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_error").html("<?php echo __("Please enter a longer message.","premiumpress") ?>");
			jQuery("#sendmsgform<?php echo $randomnum; ?> .msgf").css('border', '1px solid red');
			return false;
		}  
	
	
		jQuery.ajax({
				type: "POST",
				url: '<?php echo home_url(); ?>/',	
				dataType: 'json',	
				data: {
					action: "single_msg",
					u: ''+jQuery("#sendmsgform<?php echo $randomnum; ?> .userf").val()+'',
					m: ''+jQuery("#sendmsgform<?php echo $randomnum; ?> .msgf").val()+'',
							
				},
				success: function(response) {
		 
					if(response.status == "ok"){
					 
						jQuery('#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_output_ok').show();	
						jQuery('#sendmsgform<?php echo $randomnum; ?> .form-group, #sendmsgform<?php echo $randomnum; ?> .sendbtn').hide(); 
					
					}else{			
						jQuery('#sendmsgform<?php echo $randomnum; ?> .ajax_msgform_output_error').show();		
						jQuery('#sendmsgform<?php echo $randomnum; ?> .form-group, #sendmsgform<?php echo $randomnum; ?> .sendbtn').hide(); 				
					}			
				},
				error: function(e) {
					console.log(e)
				}
			});
	
	
	 
   }
   
   
  
</script>
  </div>
  <div class="card-footer text-center">
  <?php 

  
  if( $canShow){ ?>
    <button type="button" onclick="CheckMsgFormData<?php echo $randomnum; ?>();" class="btn btn-system shadow-sm btn-xl btn-icon icon-before m-2"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Send Message","premiumpress") ?></button>
    <?php }else{ ?>
     <a href="<?php echo _ppt(array('links','myaccount'))."?noaccess=1&showtab=membership&op=max_msg"; ?>" class="btn btn-system shadow-sm btn-xl btn-icon icon-before m-2"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Send Message","premiumpress") ?></a>
     
    
    <?php } ?>
    
  </div>
</form>
<?php  } ?>
