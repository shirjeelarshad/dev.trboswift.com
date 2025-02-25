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

global $CORE, $wpdb, $userdata;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

$emailto = "";
 
  
?>


<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4"><?php echo __("Send Email","premiumpress"); ?></h3>        
        <p class="text-muted lead mb-4"><?php echo __("Here you can send emails to your website users.","premiumpress"); ?></p>
        
        
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">  


 
<form method="post" name="admin_email" id="admin_email" action="admin.php?page=email" onsubmit="return CheckSendEmail();">
<input type="hidden" name="action" value="send-new-email" />
   



<div class="row my-3">

<div class="col-md-6">
<div class="bg-light p-3">
<input type="radio"  value="1" name="senttogo" onclick="jQuery('#eeu').hide();" <?php if(strlen($emailto) == 0){ ?>checked="checked"<?php } ?> /> <i class="fa fa-users text-muted float-right fa-3x" style="opacity:0.1"></i>  <?php echo __("All Users","premiumpress"); ?>
</div>
</div>

<div class="col-md-6">
<div class="bg-light p-3">
<input type="radio"  value="2" name="senttogo" onclick="jQuery('#eeu').show();  jQuery('#ueem').hide();" <?php if(strlen($emailto) > 1){ ?>checked="checked"<?php } ?>/> <i class="fa fa-envelope text-muted float-right fa-3x" style="opacity:0.1"></i>  <?php echo __("Email Address","premiumpress"); ?>
</div>
</div>
</div>
 
 
<div class="row mb-2" id="eeu" style="display:none;">
    <div class="col-12" style="">
    <label class="txt500"><?php echo __("Email To","premiumpress"); ?>:</label>
    <div><input type="text"  name="to_emails" id="new_subject" class="form-control btn-block" value="<?php echo $emailto; ?>"> </div>   
    </div>  
            
</div>
  

<script>

jQuery( "#useremailselect" ).change(function() {
 
 
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		data: {
            action: "get_user_email",
			uid: jQuery(this).val(),
        },
        success: function(response) {			
			jQuery('#new_subject').val( jQuery('#new_subject').val() + ',' +response);		 
			
        },
        error: function(e) {
            console.log(e)
        }
    });	
 
});
</script>

<div class="clearfix"></div>

<div class="mb-3 mt-4">
<label class="txt500"><?php echo __("Email Subject","premiumpress"); ?></label>


<?php

$subject = "";
if(isset($_GET['testemail'])){
$subject = "";

	$all_emails = _ppt('emails');
	if(isset($all_emails[$_GET['testemail']]['subject'])){
		$subject 		= $all_emails[$_GET['testemail']]['subject'];
	}

}
?>
<input type="text"  name="subject" id="mainsubject" class="form-control btn-block required-field" value="<?php echo $subject; ?>"> 
</div>      
 

<div id="showemails" style="display:none">
<div class="my-2">

<script>
 
jQuery(document).ready(function(){

	//jQuery('#sendNewEmail #wp-message-media-buttons').after('<a href="javascript:void(0);" onclick="jQuery(\'#showemails\').toggle();" class="button"><i class="fa fa fa-envelope"></i> Get System Email Content</a> ');
<?php if(strlen($emailto) > 1){ ?>
	jQuery('#eeu').show();
	<?php } ?>

});


function SetEmailContent(eid){
 
    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		data: {
            action: "get_email_content",
			emailid: eid,
        },
        success: function(response) {	
		
			console.log(response);
 
			// ADD TEXT TO EDITOR
			text1 = response.replace("\n", "<br />")
			parent.tinyMCE.activeEditor.setContent(text1);
			 
			
        },
        error: function(e) {
         
        }
    });

}

</script>
<label><?php echo __("Select System Email","premiumpress"); ?></label>
<select data-placeholder="Choose a an email..." name="" onchange="SetEmailContent(this.value)" class="form-control">
<option value="website"></option>
	<?php 
	if(isset($ppt_emails) && is_array($ppt_emails)){ 
		foreach($ppt_emails as $key=>$field){ 
			if(isset($core_admin_values['emails']) && isset($core_admin_values['emails'][$key1]) && $core_admin_values['emails'][$key1] == $key){	$sel = " selected=selected ";	}else{ $sel = ""; }
			echo "<option value='".$key."' ".$sel.">".stripslashes($field['subject'])."</option>"; 
		} 
	} 
	?> 
 
</select>  


</div>

</div>         
              
<div id="sendNewEmail" style=" margin-top:30px;">
<?php

$content = "";

if(isset($_GET['testemail'])){
	
	$all_emails = _ppt('emails');
	if(isset($all_emails[$_GET['testemail']]['body'])){
		$content 		= $all_emails[$_GET['testemail']]['body'];
	}

}

 echo wp_editor( $content, 'message', array( 'textarea_name' => 'message', 'editor_height' => '300px !important') );  ?>                        
</div>
 

 

<div class=" mt-4" id="emailshortcodesbox">
<label class="font-weight-bold"><?php echo __("Email Shortcodes","premiumpress"); ?></label>

<?php $shortcodes = $CORE->email_message_filter('',array("user_id" => $userdata->ID), true); ?>
<select class="form-control" id="emailshortcodes">
<option></option>
	<?php foreach($shortcodes as $key => $sc){ ?>
    <option value="<?php echo $key; ?>"><?php echo "(".$key.") = ".$sc; ?></option>
    <?php } ?>
</select>

<script>
jQuery('#emailshortcodes').on('change',function(){
 var test = this;
 jQuery('#message').val(function(_,v){
     return v + "("+test.value+")";
 })
});
</script>

<?php if(defined('WLT_DEMOMODE')){ ?>
<a href="javascript:void(0);"onclick="jQuery('#message').val('user id = (user_id)\n\n\website = (website)\n\ndate = (date)\n\ntime = (time)\n\nuser = (username)\n\nfirst name = (first_name)\n\nlast name = (last_name)\n\nemail = (user_email)');" class="mt-3 text-dark small">test codes</a>
<?php } ?>

 
</div>
              
 
<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Send Email","premiumpress"); ?></button>
    	</div>
               
</form>

<script>

 
function CheckSendEmail(){
 
					
					 
					var mainsubject 	= document.getElementById("mainsubject"); 
				 			
					if(mainsubject.value == '')
					{
						alert('<?php echo __("Please complete all required fields.","premiumpress") ?>');
						mainsubject.focus();
						mainsubject.style.border = 'thin solid red';
						return false;
					}
				 		
					
		 return true;
					
}
</script>

   
      
        
        </div><!-- end col 8 -->
      

    </div></div>  <!-- end admin card -->
        
        

</div></div>  <!-- end row -->
        