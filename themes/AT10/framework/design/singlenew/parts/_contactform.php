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

global $CORE, $post;

// RANDOM NUMBERS
$email_nr1 = rand("0", "9"); $email_nr2 = rand("0", "9"); 

if(_ppt(array('user','account_messages')) == 0){ return ""; }

?>

<div id="ajax_contactform_output_ok" style="display:none;">
  <div class="alert alert-success text-center small"> <i class="fa fa-check"></i> <?php echo __("Message Sent Successfully.","premiumpress") ?> </div>
</div>
<div id="ajax_contactform_output_error" style="display:none;">
  <div class="alert alert-danger text-center small"> <i class="fa fa-times"></i> <?php echo __("Error Sending Message.","premiumpress") ?> </div>
</div>

<?php if(!isset($GLOBALS['contactformopen'])){ ?>
  <div class="btnboxconf">
  <?php if(in_array(THEME_KEY, array("sp")) ){ ?>
   
  <button type="button" onclick="CheckFormData();" class="btn btn-block btn-light"><?php echo __("Message","premiumpress") ?></button>
  <?php }else{ ?>
 
  <button type="button" onclick="CheckFormData();" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-2"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></button>  
  <?php } ?>
  </div>
<?php } ?>

<form role="form" method="post" action=""  id="contactusform">



<div <?php if(!isset($GLOBALS['contactformopen'])){ ?>style="display:none;"<?php } ?> id="contactforminner">
  <div class="row">
    <div class="col-12">
      <div class="controls mb-3 position-relative">
        <input type="text" class="form-control form-control-sm" name="contact_n1" id="name" tabindex="1"  placeholder="<?php echo __("Full Name","premiumpress") ?>" onchange="jQuery('#showcodeb').show();">
        <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-user"></span> </span> </div>
    </div>
    <div class="col-12">
      <div class="controls mb-3 position-relative">
        <input type="text" class="form-control form-control-sm" id="phone" name="contact_p1" tabindex="2" placeholder="<?php echo __("Phone","premiumpress") ?>">
        <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-phone"></span> </span> </div>
    </div>
    <div class="col-12">
      <div class="controls mb-3 position-relative">
        <input placeholder="<?php echo __("Email","premiumpress") ?>" type="text" class="form-control form-control-sm" id="email1" name="contact_e1" tabindex="3" v>
        <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-envelope"></span> </span> </div>
    </div>
    <div class="col-12">
      <div class="controls mb-3 position-relative">
        <textarea placeholder="<?php echo __("Your message","premiumpress") ?>..." name="contact_m1" class="form-control form-control-sm" id="message" tabindex="4" style="height:110px; width:100%;"></textarea>
      </div>
    </div>
    <div class="col-12" id="showcodeb" style="display:none;">
      <div class="controls mb-3 position-relative">
        <input type="text" name="contact_code" placeholder="<?php echo str_replace("%a",$email_nr1,str_replace("%b",$email_nr2,__("Security: %a + %b = ?","premiumpress"))); ?>" class="form-control"  tabindex="5"  id="code" />
        <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-shield-check"></span> </span>
      </div>
    </div>
    
    <div class="col-12">
    
     <button type="button" onclick="CheckFormData();" class="btn btn-block btn-light"><?php echo __("Send Message","premiumpress") ?></button>
 
    
    </div>
  </div>
  
  
  
  
  </div>
  
  <div class="clearfix"></div>
	
   
</form>
<script>					 
 
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
      function CheckFormData()
      {
	  
	  jQuery("#contactforminner").show();
	  jQuery(".btnboxconf").hide();
      
      	jQuery('#showcodeb').show();
      	var name 	= document.getElementById("name"); 
      	var email1 	= document.getElementById("email1");
      	var phone 	= document.getElementById("phone");
	  	var code 	= document.getElementById("code");
      	var message = document.getElementById("message");	 
      				
      	if(name.value == '')
      	{
      		alert('<?php echo __("Please complete all required fields.","premiumpress") ?>');
      		name.focus();
      		name.style.border = 'thin solid red';
      		return false;
      	}
      	if(email1.value == '')
      	{
      		alert('<?php echo __("Please complete all required fields.","premiumpress") ?>');
      		email1.focus();
      		email1.style.border = 'thin solid red';
      		return false;
      	}
		
		if(!isEmail(email1.value))
      	{
      		alert('<?php echo __("Invalid email address.","premiumpress") ?>');
      		email1.focus();
      		email1.style.border = 'thin solid red';
      		return false;
      	}
      	  
      	if(message.value == '')
      	{
      		alert('<?php echo __("Please complete all required fields.","premiumpress") ?>');
      		message.focus();
      		message.style.border = 'thin solid red';
      		return false;
      	}  
		
		if(code.value != '<?php echo $email_nr1+$email_nr2; ?>')
      	{
      		alert('<?php echo __("The security code is incorrect.","premiumpress") ?>');
      		code.focus();
			code.value = '';
      		code.style.border = 'thin solid red';
      		return false;
      	}
      	  
		jQuery.ajax({
				type: "POST",
				url: '<?php echo home_url(); ?>/',	
				dataType: 'json',	
				data: {
					action: "single_contactform",
					n: ''+name.value+'',
					e: ''+email1.value+'',
					p: ''+phone.value+'',
					c: ''+code.value+'',
					ca: '<?php echo ($email_nr1+$email_nr2); ?>',
					m: ''+message.value+'',
					pid: '<?php echo $post->ID; ?>',
							
				},
				success: function(response) {
		 
					if(response.status == "ok"){
					 
						jQuery('#ajax_contactform_output_ok').show();	
						jQuery('#contactusform').hide(); 
								 
					
					}else{			
						jQuery('#ajax_contactform_output_error').show();						
					}			
				},
				error: function(e) {
					console.log(e)
				}
			});
		
		
      }
   </script>
