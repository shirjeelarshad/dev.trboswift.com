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

global $CORE, $userdata, $post, $settings; 

	  $canShow = true;
   	  if(_ppt(array('mem','enable'))  == '1' && _ppt('mem0_view_listing') != "" && $CORE->USER("membership_hasaccess", "max_msg")){
	  
			// CHECK USER CREDIT
			if($CORE->USER("get_user_free_membership_addon", array("max_msg", $userdata->ID)) > 0){
			
			}else{
			
			$canShow = false;
			}
	  
	  }
 
?>

<div class="card">
  <div id="ajax-sql"></div>
  <div class="wrapper-chat p-4">
    <div class="row">
      <div class="col-lg-3 col-md-4 wrapper-infos pt-1">
        <div class="row">
          <div class="col-lg-12 col-md-12 contact-list px-0">
            <div id="ajax_chat_list" class="col-12 px-0"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-8 col-12 d-none d-lg-block d-md-block wrapper-discussion">
        <div class="row">
          <div class="col-lg-12 col-md-12 discussion-header" style="display:none;">
            <div class="row">
              <div class="col-lg-4 col-7 discussion">
                <div class="row">
                  <div class="col-lg-3 col-md-2 col-4 contact-left"> <img src="#" alt="user icon"> </div>
                  <div class="col-lg-9 col-md-10 col-8 contact-infos discussion-infos">
                    <h3></h3>
                    <p></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 col-5 discussion-menu">
                <?php /*
										<ul class="d-menu">
											<a href="#">
												<li class="to-audio-call">
													<div><i class="fas fa-eye fa-3x"></i></div>
                                                    <div class="small">view profile</div>
												</li>
											</a>
										 
										</ul>
										*/ ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 discussion-list border-left">
            <div class="row" id="discussion-block"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($CORE->USER("membership_hasaccess", "msg_send")){ ?>
  <div class="col-md-12 discussion-message py-2 position-relative">
    <input type="text" name="messages" id="chat_msg" class="form-control bg-white" placeholder="<?php echo __("Type a message...","premiumpress") ?>">
    <?php if($canShow){ ?>
    <button  onclick="ppt_chat_send()" type="button" class="btn btn-sm btn-primary" style="position: absolute;  <?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:18px;"; }else{ echo "right:18px;";  } ?>    top: 11px;"><?php echo __("send","premiumpress") ?></button>
    <?php }else{ ?>
    <a href="<?php echo _ppt(array('links','myaccount'))."?noaccess=1&showtab=membership&op=max_msg"; ?>" class="btn btn-sm btn-primary" style="position: absolute;    <?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:18px;"; }else{ echo "right:18px;";  } ?>     top: 11px;"><?php echo __("send","premiumpress") ?></a>
    <?php } ?>
  </div>
  <?php } ?>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <?php _ppt_template( 'ajax', 'modal-msg' ); ?>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <input name="rid" id="rid" value="" type="hidden" />
</div>
<script>
jQuery(document).ready(function(){ 

 

//ajax_load_chat_list();
 <?php if( isset($_GET['u']) && !isset($_POST['username']) ){ ?>
 jQuery('.userf').val('<?php echo strip_tags($_GET['u']); ?>');
  jQuery('.userfieldmsg').hide();
 jQuery('#exampleModal').modal('toggle');
<?php } ?> 


 <?php if( isset($_GET['uid']) && !isset($_POST['username']) && is_numeric($_GET['uid']) ){ ?>
 jQuery('.userf').val('<?php echo $CORE->USER("get_username", $_GET['uid']); ?>');
 jQuery('.userfieldmsg').hide();
 jQuery('#exampleModal').modal('toggle');
<?php } ?> 

<?php if(isset($_POST['username'])){ ?>

notify({
		type: "success", //alert | success | error | warning | info
        title: "<?php echo __("Message Sent","premiumpress"); ?>",
		position: {
         x: "right", //right | left | center
         y: "top" //top | bottom | center
        },
        icon: '<i class="fal fa-check"></i>',
        message: "<?php echo __("Your message has been sent successfully.","premiumpress"); ?>&nbsp;"
	});


<?php } ?>

});


jQuery(document).ready(function(){ 

	jQuery('body').on('click','.contact',function(){	
	
	
	<?php if(_ppt('footer_mobile_menu') == 1){ ?>
 
	jQuery(".footer-nav-area").addClass('hide-mobile');
	 
 
<?php } ?>									 
				 
		var uid = jQuery(this).data('uid');	
		 
		jQuery('#rid').val(uid);				 
		
		ajax_load_chat_data(uid);					 
											 
		jQuery('.contact').removeClass('active-contact');
		jQuery(this).addClass('active-contact');		
		
		jQuery('.wrapper-discussion').removeClass('d-none');
		
		update_discussion_header();
				
		// RELOAD CHAT
		setTimeout(function(){ 	
		
			ajax_load_chat_data(uid);
						
			update_discussion_header();
					
		}, 25000);	
		
	});
	
	
	jQuery('body').on('click','.discussion',function(){
		jQuery('.wrapper-discussion').addClass('d-none');
	});
	 
 
});

function ajax_load_chat_data(id){


jQuery('#discussion-block').html('<div class="text-center mt-5 pt-5 col-12"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');

 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "load_chat_data",
			uid: id,
			rid: jQuery('#rid').val(),
        },
        success: function(response) {
  
			if(response.status == "noupdate"){
			
			
  
			}else if(response.status == "ok"){
				
				if(response.output == ""){
				
				jQuery('#discussion-block').html('<div class="col-12 text-center mt-5 pt-5"><?php echo __("You have no chat history.","premiumpress") ?></div>');	
				//jQuery('.discussion-message').hide();		 	 
				
				}else{
				
				 	// SHOW MESSAGE				
					jQuery('#discussion-block').html(response.output);	
					
					jQuery('#ajax-search-found').html(response.total);						
					
					// SCROL TO BOTTOM
					var wtf    = jQuery('.discussion-list');				 
					var height = wtf[0].scrollHeight;				  
					jQuery('.discussion-list').stop().animate({ scrollTop: height}, "slow");				  			
					
					var uid = jQuery('.active-contact').data('uid');							 
					jQuery('#rid').val(uid);
					
				
				}	 
			 
  		 	
			}else{			
				jQuery('#discussion-block').html("Could not get message data - try again later.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure
 
function ajax_load_chat_list(){


 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "load_chat_list",
			uid: <?php echo $userdata->ID; ?>,
        },
        success: function(response) {
		 
			if(response.status == "noupdate"){			
			
  
			}else if(response.status == "ok"){
			
			jQuery('#discussion-block').html('<div class="col-12 text-center mt-5 pt-5"><i class="fal fa-comments fa-4x mb-4 btn-block"></i> <i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
 
			 	 
			 
					// SHOW MESSAGE				
					jQuery('#ajax_chat_list').html(response.output); 
					
					jQuery('#discussion-block').html('');
					 
					 
					if(response.total == 0){
					 
						jQuery('#discussion-block').html('<div class="col-12 text-center mt-5 pt-5"><?php echo __("You have no chat history.","premiumpress") ?></div>');	
						//jQuery('.discussion-message').hide();	
					
					}else{						 
						
						jQuery('.user-'+response.last_userid).addClass('active-contact');
						jQuery('#rid').val(response.last_userid);
						
						ajax_load_chat_data(response.last_userid);
					
					}
					 
					
					update_discussion_header();
				 			 
  		 	
			}else{			
				jQuery('#ajax_chat_list').html("Could not get message data - try again later.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure


function update_discussion_header(){
	
	var img = jQuery(".active-contact").find('img').attr('src');
	
	if (typeof img != "undefined") {
	
		jQuery(".discussion-header").find('img').attr('src', img);
						
		var name = jQuery(".active-contact .name_of_contact").html();
		jQuery(".discussion-header h3").html(name);
		
		var time = jQuery(".active-contact .chat-timing").html();
		jQuery(".discussion-header p").html(time);
		 
		 
		jQuery(".discussion-header").show();
	
	}
	 
	
} 

function ppt_chat_send(){
 										   
										   
var msg = jQuery("#chat_msg").val();
var msgcheck 	= document.getElementById("chat_msg"); 
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
			uid: <?php echo $userdata->ID; ?>,
			rid: jQuery('#rid').val(),
			msg: msg,			
        },
        success: function(response) {
 
			if(response.status == "ok"){
			
				// RELOAD CHAT WINDOW
				ajax_load_chat_data(jQuery('#rid').val());			 	 
			 			 
  		 	
			}else{			
				jQuery('#ajax_chat_list').html("Could not get message data - try again later.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
 		
}


jQuery(document).ready(function(){ 

jQuery('body').on('keyup','#chat_msg',function(e){
	if (jQuery("#chat_msg").is(":focus") && (e.keyCode == 13) ) {
		var msg = jQuery(this).val();				
		if( msg != "" ){
		
		ppt_chat_send();
		
		}else{
			alert("Please write a message");
		}
	}
});

});
 
</script>