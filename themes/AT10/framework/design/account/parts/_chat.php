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

function get_admin_user_id() {
    // Get active admins first
    $args = array(
        'role'    => 'administrator',
        'orderby' => 'ID',
        'order'   => 'ASC',
        'number'  => 1,
    );

    // Check if any admin is currently active
    $admins = get_users($args);

    foreach ($admins as $admin) {
        if (is_user_logged_in() && get_user_meta($admin->ID, 'session_tokens', true)) {
            // Return ID if admin is currently active
            return $admin->ID;
        }
    }

    // If no active admin, get the last logged-in admin
    $args_last_logged_in = array(
        'role'    => 'administrator',
        'orderby' => 'meta_value_num',
        'meta_key'=> 'last_login',
        'order'   => 'DESC',
        'number'  => 1,
    );

    $last_logged_in_admin = get_users($args_last_logged_in);

    if (!empty($last_logged_in_admin)) {
        return $last_logged_in_admin[0]->ID;
    }

    return null; // No admin found
}

// Example of using the function
$admin_id = get_admin_user_id();


?>


<input type="hidden" id="dealChatId" value="44" />
<input type="hidden" id="dealVendorId" value="7" />


<div class="card card-body mt-4 mb-4">
    <h5 class="mb-4"><?php echo __("Discussion Room", "premiumpress") ?></h5>
    <div style="height: 600px; overflow: auto; overflow-y: scroll;" id="chat-div"></div>
    <hr />
    <textarea class="form-control chattextbox" style="height:100px;" id="chat-box"></textarea>
    <div class="fileupload-buttonbar" style="display:none;">
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="custom-file">
                <form id="chat-form" name="" method="post" action="<?php echo home_url(); ?>"
                    enctype="multipart/form-data">
                    <input type="file" id="" name="file" class="custom-file-input">
                    <input type="hidden" action="chat_upload" value="1" />
                </form>
                <label class="custom-file-label" for="gallery">
                    <?php echo __("Select .zip, .jpg or .png files only.", "premiumpress"); ?>
                </label>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-icon icon-before mr-3" id="sendMessageBtn">
            <i class="fa fa-paper-plane"></i> <?php echo __("Send Message", "premiumpress") ?>
        </a>
        <a href="javascript:void(0);" onclick="jQuery('.fileupload-buttonbar').toggle();"
            class="btn btn-secondary btn-sm btn-icon icon-before">
            <i class="fa fa-upload"></i> <?php echo __("Attach File", "premiumpress"); ?>
        </a>
    </div>
</div>

<script>
// Get deal chat and vendor IDs from the hidden inputs
var chatId = jQuery('#dealChatId').val();
var senderId = jQuery('#dealVendorId').val();
var adminId = <?php echo $admin_id; ?>;

// Generate chat_div_id and chat_upload_id dynamically
var chatDivId = "chatbetween_admin_user_" + adminId + "_" + senderId + "_" + chatId;
var chatUploadId = "ppt_chat_send_" + chatId + "_file_form";

// Update the div and textarea IDs dynamically
jQuery('#chat-div').addClass(chatDivId);
jQuery('#chat-box').addClass("ppt_chat_send_" + chatId + "_chat_msg");
jQuery('#chat-form').addClass(chatUploadId).attr('name', "ppt_chat_send_" + chatId + "_file_form");
jQuery('.custom-file-input').addClass(chatUploadId + "_file");

// Send message function
jQuery('#sendMessageBtn').on('click', function() {
    var msg = jQuery(".ppt_chat_send_" + chatId + "_chat_msg").val();
    var msgcheck = document.getElementsByClassName("ppt_chat_send_" + chatId + "_chat_msg");

    if (msgcheck.value == '') {
        alert('<?php echo __("Please enter a message.", "premiumpress") ?>');
        msgcheck.focus();
        msgcheck.style.border = 'thin solid red';
        return false;
    }

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',
        dataType: 'json',
        data: {
            action: "send_chat_msg",
            <?php  if( current_user_can('administrator') ){ ?>
            uid: adminId,
            rid: senderId,
            <?php  }else{ ?>
            uid: senderId,
            rid: adminId,
            <?php } ?>
            msg: msg
        },
        success: function(response) {
            if (response.status == "ok") {
                ajax_chat_logs_for_deal();
                jQuery("." + chatDivId).stop().animate({
                    scrollTop: jQuery("." + chatDivId).get(0).scrollHeight
                }, "slow");
                jQuery(".chattextbox").val('');
            } else {
                jQuery('#ajax_chat_list').html(
                    "Could not get message data - try again later.");
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
});




function ajax_chat_logs_for_deal() {
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',
        dataType: 'json',
        data: {
            action: "load_chat_data",
            fullaccess: 1,
            uid: senderId,
            rid: adminId, // Replace with actual logic
        },
        success: function(response) {
            if (response.status == "noupdate") {
                // No update logic
            } else if (response.status == "ok") {
                jQuery('.' + chatDivId).html(
                    '<div class="text-center mt-5 pt-5 col-12"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>'
                );

                if (response.output == "") {
                    jQuery('.' + chatDivId).html(
                        '<div class="col-12 text-center mt-5 pt-5"><i class="fal fa-comments fa-4x mb-4 btn-block"></i><?php echo __("You have no chat history.", "premiumpress") ?></div>'
                    );
                } else {
                    jQuery('.' + chatDivId).html(response.output);
                    jQuery('.' + chatDivId).stop().animate({
                        scrollTop: jQuery('.' + chatDivId).get(0)
                            .scrollHeight
                    }, "slow");
                }

                setTimeout(function() {
                    ajax_chat_logs_for_deal();
                }, 15000);
            } else {
                jQuery('.' + chatDivId).html(
                    "Could not get message data - try again later.");
            }
        },
        error: function(e) {
            console.log(e)
        }
    });
}
</script>