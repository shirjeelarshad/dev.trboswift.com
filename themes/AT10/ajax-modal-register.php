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

global $CORE;

if(!_ppt_checkfile("ajax-modal-register.php")){
?>

<style>
.login-modal-container{
   border-radius: 20px;

}

.header-top-btn{
    border-radius: 10px;
    
}

.header-topbtn-reg-active{
border-top-left-radius: 10px;
border-bottom-left-radius: 10px;
background:#efa404;
}


.login-modal-close {
    position: absolute;
    right: -30px;
    top: -30px;
    color: #fcfcfc;
}




.form-control{
border-radius: 10px;
}

.submitbtn{
border-radius: 50px;

}

.card{
border: 0px solid rgba(0,0,0,.125);
border-radius: 20px;
}

label {
    
    font-size: 14px;
    color: #3F3F3F;
}

</style>





<?php  if( !isset($GLOBALS['blockform']) ){  ?>
<div class="<?php if(isset($GLOBALS['flag-register'])){ ?>card shadow-sm<?php } ?>">

<div class="d-flex justify-content-center pt-3 mb-2">	<div style="max-width:120px; text-align:center;"><?php echo $CORE->LAYOUT("get_logo", "light"); ?></div></div>

<div class="card-body  mb-3">
<?php } ?>



<div class="px-md-5">
 <div class="text-center"> <h2 class="text-secondary font-weight-bold p-2"><?php echo __("SIGN UP","premiumpress") ?></h2>
 
 <span>Create a new account to stay updated on auctions, place bids, or list your car for sale.</span> </div>

<div id="register_form_message"></div>



<?php if( _ppt(array('register','password')) == '1'){  ?> 
<script>

jQuery( document ).ready( function() {
	
	jQuery( 'body' ).on( 'keyup', 'input[name=pass1]', function( event ) {
	
	pass_strenght_meter();
	
	});

	pass_strenght_meter();
  
});

function pass_strenght_meter(){
	
	var PassLen = jQuery('#pass1').val().length;
  
    // calculate the password strength
	if(PassLen < 5 ){	
		pwdStrength = PassLen;	
	}else if(PassLen == 5 ){
		pwdStrength =  4;
	}else if(PassLen > 5){
		pwdStrength =  5;
	}
   
	 	
	jQuery('.pm1, .pm2, .pm3, .pm4, .pm5').removeClass('bg-dark').removeClass('bg-danger').removeClass('bg-warning').removeClass('bg-success'); 	
	 

	// check the password strength
	switch ( pwdStrength ) {
	
		case 2: {
		
		jQuery('.pm1').addClass('bg-danger');
		jQuery('.pm2').addClass('bg-danger');
		jQuery('.pm3').addClass('bg-dark');
		jQuery('.pm4').addClass('bg-dark');
		jQuery('.pm5').addClass('bg-dark');	
		
		
		} break;
	
		case 3: {
		
		jQuery('.pm1').addClass('bg-warning');
		jQuery('.pm2').addClass('bg-warning');
		jQuery('.pm3').addClass('bg-warning');
		jQuery('.pm4').addClass('bg-dark');
		jQuery('.pm5').addClass('bg-dark');	
		
		
		} break;
	
		case 4: {
		
		jQuery('.pm1').addClass('bg-warning');
		jQuery('.pm2').addClass('bg-warning');
		jQuery('.pm3').addClass('bg-warning');
		jQuery('.pm4').addClass('bg-warning');
		jQuery('.pm5').addClass('bg-dark');	
		
		
		} break;
	
		case 5: {
		
		jQuery('.pm1').addClass('bg-success');
		jQuery('.pm2').addClass('bg-success');
		jQuery('.pm3').addClass('bg-success');
		jQuery('.pm4').addClass('bg-success');
		jQuery('.pm5').addClass('bg-success');	
		 
	
		} break;
	
		default: {
		
		jQuery('.pm1').addClass('bg-danger');
		jQuery('.pm2').addClass('bg-dark');
		jQuery('.pm3').addClass('bg-dark');
		jQuery('.pm4').addClass('bg-dark');
		jQuery('.pm5').addClass('bg-dark');		
		
		
		} break;
	
	}
} 

</script>
<?php } ?>

<script>

	
 
function register_process(){ 

					canContinue = true;
					
					jQuery("#register_form_message").html('');	
					
					jQuery('.required-active').removeClass('required-active');
					
					<?php if(THEME_KEY == "da"){ ?>
					jQuery("#otherusers").show();
					<?php } ?>
					
					
					<?php if(_ppt(array('register','username')) == 1){ ?>
					var username 	= document.getElementById("username");
					if(username.value == '')
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");	
						jQuery(username).addClass('required-active');
						
						canContinue = false;
					}
					
					
					<?php } ?>
					
					
					<?php if(_ppt(array('register','hide_firstlast')) != 1){ ?>
					var fname 	= document.getElementById("user_fname"); 					
					var name 	= document.getElementById("user_lanme");  					
					if(fname.value == '')
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");						
						 jQuery(fname).addClass('required-active');
						canContinue = false;
					}
							
					if(name.value == '')
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");
						name.focus();
						jQuery(name).addClass('required-active');
						canContinue = false;
					}
					<?php } ?>
					
					var email1 	= document.getElementById("user_email");
					
					if(email1.value == '')
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");
						email1.focus();
						jQuery(email1).addClass('required-active');
						canContinue = false;
					}
					if(!isValidEmail(email1.value))
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Invalid email address.","premiumpress") ?>");						
						email1.focus();
						jQuery(email1).addClass('required-active');
						canContinue = false;
					}
					
					<?php if( _ppt(array('register','password')) == '1'){  ?>
					
					var pass1 	= document.getElementById("pass1");
					
					/*var pass2 	= document.getElementById("pass2");
					
					if(pass1.value != pass2.value)
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Passwords do not match.","premiumpress") ?>");
						pass1.focus();
						pass1.style.border = 'thin solid red';
						canContinue = false;
					}*/
					
					if(pass1.value.length < 6)
					{
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Passwords must be at least 6 characters.","premiumpress") ?>");
						pass1.focus();
						jQuery(pass1).addClass('required-active');
						canContinue = false;
					}
					
					<?php } ?>
					
					<?php  if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "" ){ }else{ ?>
            /*
					var code 	= document.getElementById("user_code"); 
					if(code.value == '')
					{
					 
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");
						
						code.focus();
						jQuery(code).addClass('required-active');
						canContinue = false;
					}
					
					if(code.value !=  jQuery("#user_code").attr("data-codep")){
						
						
						jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Incorrect security code. Please try again.","premiumpress") ?>");
						
						 
						code.focus();
						jQuery(code).addClass('required-active');
						canContinue = false;
					
					}
					
					*/
				<?php } ?>
				
				
				
	jQuery('.required').each(function(i, obj) {		
				 	
		if(jQuery(obj).val() == ""){			
			jQuery(obj).addClass('required-active').focus();	
			
			jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html("<?php echo __("Please complete all required fields.","premiumpress") ?>");		
			canContinue = false;
		}		
	}); 
				
				
  if(canContinue){
  
  
 
   var formd = jQuery("#form_user_register").serialize();
   
   jQuery("#wp-submit-register").attr("disabled","disabled");
   
   
  jQuery('#register_form_message').html('<div class="text-center text-primary"><i class="fa fa-spinner fa-3x fa-spin"></i></div>');
  jQuery('#form_user_register').hide();
 
   jQuery.ajax({
        type: "POST",
        url: ajax_site_url,	
		dataType: 'json',	
   		data: {
               action: "register_process", 
			   formdata: formd,			 
           },
           success: function(response) { 
		    
				 if(response.status == "error"){				 
				 
				 	jQuery("#register_form_message").addClass('text-danger mb-4 text-center').html(response.msg);
					
					jQuery("#wp-submit-register").attr("disabled", false);
					
					 jQuery('#form_user_register').show();
				 
				 }else if(response.status == "func_mem"){				 	
					
					jQuery(".login-modal-wrap").fadeOut(400);
					
					processPayment(response.link, response.msg);
					
					jQuery("#wp-submit-register").attr("disabled", false);					
					
				 }else if(response.status == "reload"){
				 
				 	window.location.reload();
				 
				 }else if(response.status == "ok"){
				 	
					<?php if(isset($_GET['membership']) && $_GET['membership'] == -1 && _ppt(array('mem','enable')) == 1){ ?>
					
					window.location.href= "<?php echo _ppt(array('links','memberships')); ?>";
					<?php }else{ ?>
					window.location.href= response.link;
					<?php } ?>
				 	
				 } 
   			
           },
           error: function(e) {
               console.log(e);
			   
			   jQuery("#wp-submit-register").attr("disabled", false);
           }
       });
	
	}
  
  
}


</script>




<form  id="form_user_register" class="registerform mt-3" name="registerform" action="#" onsubmit="register_process(); return false;"  method="post" style="
    overflow: hidden;
    overflow-y: auto;
">
  <?php if(isset($_GET['redirect'])){ ?>
  <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_GET['redirect']); ?>" />
  <?php }elseif(isset($_GET['redirect_to']) && $_GET['redirect_to'] != ""){ ?>
  <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_GET['redirect_to']); ?>" />
  <?php } ?>
  <?php 
  
  // HOOK REGISTER TOP
  hook_register_top(); ?>
  <div class="row">
    <div class="row mx-0 form-default-fields">
      
      <?php if(_ppt(array('register','hide_firstlast')) != 1){ ?>
      <div class="col-12 col-md-6">
      <label>First Name</label>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 position-relative">
              <input type="text" name="first_name" id="user_fname"  tabindex="2" value="<?php if(isset($_POST['first_name'])){ echo esc_html(strip_tags($_POST['first_name'])); } ?>" class="form-control required rounded-pill" placeholder="<?php echo __("First Name","premiumpress") ?>">
              <i class="fal fa-user position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6">
      <label>Last Name</label>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 position-relative">
              <input type="text" name="last_name" id="user_lanme" tabindex="3" value="<?php if(isset($_POST['last_name'])){ echo esc_html(strip_tags($_POST['last_name'])); } ?>" class="form-control required rounded-pill" placeholder="<?php echo __("Last Name","premiumpress") ?>" >
              <i class="fal fa-user position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="col-12 col-md-12">
       <label>Email</label>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 position-relative">
              <input type="text" name="user_email" id="user_email" tabindex="4" value="<?php if(isset($_POST['user_email'])){ echo esc_html(strip_tags($_POST['user_email'])); } ?>" class="form-control required rounded-pill" placeholder="<?php echo __("Enter Email","premiumpress"); ?>" autocomplete="off">
              <i class="fal fa-envelope position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> </div>
          </div>
        </div>
      </div>
      
      <?php if(_ppt(array('register','username')) == 1){ ?>
      <div class="col-12 col-md-6">
       <label>Username (public name)</label>
        <div class="form-group">
          <div class="row">
            <div class="col-12 position-relative">
           
              <input type="text" name="username" id="username"  tabindex="1" value="<?php if(isset($_POST['username'])){ echo esc_html(strip_tags($_POST['username'])); } ?>" class="form-control required rounded-pill" placeholder="<?php echo __("Your last name","premiumpress") ?>">
              <i class="fal fa-smile position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> </div>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <?php echo $CORE->user_fields(); ?>
      <?php if( _ppt(array('register','password')) == '1'){  ?>
      
      <div class="col-12 col-md-12 mb-2">
      <label>Password</label>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 position-relative">
              <input type="password" name="pass1" id="pass1" value="<?php if(isset($_POST['pass1'])){ echo esc_html(strip_tags($_POST['pass1'])); } ?>" tabindex="5" class="form-control required rounded-pill" placeholder="<?php echo __("Password","premiumpress"); ?>" autocomplete="off">
              
              <i class="fal fa-lock position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> <i class="fa fa-eye position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:60px;"; }else{ echo "right:60px;";  } ?> top:12px;cursor:pointer;" onclick="TogglePass('pass1');TogglePass('pass2');"></i> 
              
              <i class="fal fa-lock position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i> </div>
          </div>
 		
          <ul class="ppt_pas_meter p-0 d-none" >
            <li class="strength_meter_block pm1 bg-danger"></li>
            <li class="strength_meter_block pm2 bg-dark"></li>
            <li class="strength_meter_block pm3 bg-dark"></li>
            <li class="strength_meter_block pm4 bg-dark"></li>
            <li class="strength_meter_block pm5 bg-dark"></li>
          </ul>
          
        
        </div>
        </div>

        
        <?php /*
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 position-relative">
              <input type="password" name="pass2" id="pass2" value="<?php if(isset($_POST['pass2'])){ echo esc_html(strip_tags($_POST['pass2'])); } ?>" tabindex="6" class="form-control required rounded-pill" placeholder="<?php echo __("Confirm Password","premiumpress"); ?>" autocomplete="off">
              
              
              
              </div>
          </div>
        </div>
      </div>
      
      */ ?>
      
      <?php } ?>
      <?php 
      /*
       <div class="col-12 col-md-12">
       <label>Phone Number</label>
            <div class="form-group">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex rounded-pill border">
                    <div class="col-2 p-0">
                      <input name="custom[mobile-prefix]" type="text" class="form-control rounded-pill border-0" id="mobileprefix-input" placeholder="+1"  value="<?php echo get_user_meta($userdata->ID,'mobile-prefix',true); ?>" />
                    </div>
                    <div class="col-10 p-0">
                      <input name="custom[mobile]" type="text" class="form-control rounded-pill border-0" id="mobilenum-input"  placeholder="<?php echo __("Phone number","premiumpress"); ?>" 
                                 value="<?php echo get_user_meta($userdata->ID,'mobile',true); ?>" /><i class="fal fa-phone position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i>
                    </div>
                  </div>
                  <!-- end row -->
                </div>
              </div>
            </div>
          </div>
          */
          ?>
      
      <?php if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "" ){ ?>
      <div class="g-recaptcha my-2 ml-3" data-sitekey="<?php echo stripslashes(_ppt(array('captcha','sitekey'))); ?>"></div>
      <?php }else{ $reg_nr1 = rand("0", "9"); $reg_nr2 = rand("0", "9"); 
        /*
      <div class="col-xs-12 col-md-12">
        <div class="form-group">
          <div class="row">
         
            <div class="col-md-12 position-relative">
            
            
            <i class="fal fa-shield position-absolute" style="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:30px;"; }else{ echo "right:30px;";  } ?> top:12px;"></i>
             
          
                <input type="text" name="reg_val" id="user_code" data-codep="<?php echo ($reg_nr1+$reg_nr2); ?>" tabindex="7" class="form-control required rounded-pill"  placeholder="<?php echo __("What is:","premiumpress") ?>  <?php echo $reg_nr1; ?> + <?php echo $reg_nr2; ?> =">
              
               
               <input type="hidden" name="reg1" value="<?php echo $reg_nr1; ?>" />
                <input type="hidden" name="reg2" value="<?php echo $reg_nr2; ?>" />
             
            </div>
          </div>
        </div>
      </div>
      */
       } ?>
      <div class="col-md-12">
        <div class="small py-2 termsbox">
          <label class="custom-control custom-checkbox my-2">
          <input type="checkbox" class="custom-control-input" id="agreepp1" value="1" onchange="jQuery('#agreepp1').prop('disabled', true);jQuery('#wp-submit-register').prop('disabled', false);">
          <div class="custom-control-label mr-2 font-weight-bold mt-1"> <?php echo __("I have read and agree to TruboBid","premiumpress") ?> <a href="<?php echo _ppt(array('links','terms')); ?>" target="_blank"><?php echo __("Terms of Use","premiumpress") ?></a> and <a href="<?php echo home_url(); ?>/privacy" target="_blank"><?php echo __(" Privacy Policy","premiumpress") ?></a>. </div>
          </label>
           <label class="custom-control custom-checkbox my-2">
          <input type="checkbox" class="custom-control-input" id="agreepp2" value="1" onchange="jQuery('#agreepp2').prop('disabled', true);jQuery('#wp-submit-register').prop('disabled', false);">
          <div class="custom-control-label mr-2 font-weight-bold mt-1"> <?php echo __("I agree to receive marketing updates from TurboBid","premiumpress") ?>.</div>
          </label>
        </div>
        <div class="text-center">
        <button type="submit" name="wp-submit" id="wp-submit-register" class="submitbtn btn btn-secondary px-5 py-2 "  disabled><?php  if( !isset($GLOBALS['blockform']) ){  ?><?php echo __("Sign Up","premiumpress"); ?><?php }else{ ?><?php echo __("Sign Up","premiumpress"); ?><?php } ?></button></div>
      </div>
    </div>
  </div>
</form>

<div class="text-center">Already a member? <a <?php if(isset($GLOBALS['flag-register'])){ ?>href="<?php echo wp_login_url(); ?>"<?php }else{ ?>href="javascript:void(0)" onclick="processLogin();"<?php } ?> ><span class="text-dark" ><?php echo __("Sign In","premiumpress"); ?></span></a></div>

<?php } ?>
<?php  if( !isset($GLOBALS['blockform']) ){  ?>
  </div>
  </div>
</div>
<?php } ?>