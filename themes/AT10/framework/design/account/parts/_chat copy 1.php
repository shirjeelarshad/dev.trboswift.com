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


global $userdata, $CORE, $settings;

$chat_div_id = "#chatbetween_".$settings['job_seller_id']."_".$settings['job_buyer_id']."_".$settings['pid'];
 
$chat_upload_id = "ppt_chat_send_".$settings['pid']."_".$settings['job_buyer_id']."_".$settings['pid']."_file_form";
?>

<div class="card card-body mt-4 mb-4">
  <h5 class="mb-4"><?php echo __("Discussion Room","premiumpress") ?></h5>
  <div style="    height: 600px;    overflow: auto;  overflow-y: scroll;" id="<?php echo str_replace("#","",$chat_div_id); ?>"></div>
  <hr />
  <textarea class="form-control chattextbox" style="height:100px;" id="ppt_chat_send_<?php echo $settings['pid']; ?>_chat_msg"></textarea>
  <div class="fileupload-buttonbar" style="display:none;">
    <div class="d-flex justify-content-between align-items-center mt-2">
      <div class="custom-file">
        <!-- The HTML -->
        <form id="<?php echo $chat_upload_id; ?>" name="ppt_chat_send_<?php echo $settings['pid']; ?>_file_form" method="post" action="<?php echo home_url(); ?>" enctype="multipart/form-data">
          <input type="file" id="<?php echo $chat_upload_id; ?>_file" name="file" class="custom-file-input">
          <input type="hidden" action="chat_upload" value="1" />
        </form>
<script>





jQuery(document).ready(function(){
        jQuery("#<?php echo $chat_upload_id; ?>_file").change(function(){				
		//jQuery("#<?php echo $chat_upload_id; ?>").submit(); 		
		
		// The Javascript
		var form = document.getElementById('<?php echo $chat_upload_id; ?>');
		//form.onsubmit = function() {
		
		 
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
		
		
		  jQuery('#<?php echo $chat_upload_id; ?>').trigger("reset");
		  jQuery(form).trigger("reset");
		//  return false; // To avoid actual submission of the form
		//}
		
		
		
		
        });
});
</script>
        <label class="custom-file-label" for="gallery"><?php echo __("Select .zip, .jpg or .png files only.","premiumpress"); ?></label>
      </div>
    </div>
  </div>
  <div class="mt-4"> <a href="javascript:void(0);" onclick="ppt_chat_send_<?php echo $settings['pid']; ?>();" class="btn btn-primary btn-sm btn-icon icon-before mr-3"><i class="fa fa-paper-plane"></i> <?php echo __("Send Message","premiumpress") ?></a> <a href="javascript:void(0);" onclick="jQuery('.fileupload-buttonbar').toggle();" class="btn btn-secondary btn-sm btn-icon icon-before"><i class="fa fa-upload"></i> <?php echo __("Attach File","premiumpress"); ?></a> </div>
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
 
			if(response.status == "ok"){
			
				// RELOAD CHAT WINDOW
				ajax_chat_logs_<?php echo $settings['pid']; ?>();	
				
				// SCROL TO BOTTOM				 	  
				jQuery('<?php echo $chat_div_id; ?>').stop().animate({ scrollTop: jQuery('<?php echo $chat_div_id; ?>').get(0).scrollHeight}, "slow");	
			 
					
				jQuery(".chattextbox").val('');		 	 
			 			 
  		 	
			}else{			
				jQuery('#ajax_chat_list').html("Could not get message data - try again later.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
 		
}

function ajax_chat_logs_<?php echo $settings['pid']; ?>(){


 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "load_chat_data",
			fullaccess: 1,
			
			<?php  if( $settings['job_seller_id'] == $userdata->ID  ){ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_buyer_id']; ?>,
			
			<?php  }else{ ?>
			
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $settings['job_seller_id']; ?>,
			
			<?php } ?>
			
		 
        },
        success: function(response) {
  
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
				
				 // RELOAD CHAT
				setTimeout(function(){ 	
				
					ajax_chat_logs_<?php echo $settings['pid']; ?>();
							
				}, 15000);	
			 
  		 	
			}else{			
				jQuery('<?php echo $chat_div_id; ?>').html("Could not get message data - try again later.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure

</script>