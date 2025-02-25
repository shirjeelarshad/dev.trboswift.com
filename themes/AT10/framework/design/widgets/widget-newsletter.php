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

global $CORE, $userdata, $post; 

if(isset($GLOBALS['UNIQUE-NEWSLETTER-ID'])){
$GLOBALS['UNIQUE-NEWSLETTER-ID']= $GLOBALS['UNIQUE-NEWSLETTER-ID']+1;
}else{
$GLOBALS['UNIQUE-NEWSLETTER-ID'] = 1;
}

$randomID = rand(0,100000)

?>
 
<?php if( _ppt(array('newsletter','enable'))  == 1 || defined('WLT_DEMOMODE') ){ ?>

<?php if( _ppt(array('newsletter','newsdefault'))  == 0 ){  ?>

<?php echo do_shortcode(_ppt(array('newsletter','customcode')) ); ?>

<?php }else{ ?>


<script>

function ajax_newsletter_signup<?php echo $randomID; ?>(){

    jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',		
		dataType: 'json',
		data: {
            action: "newsletter_join",
			email: jQuery('#ppt_newsletter_mailme<?php echo $randomID; ?>').val(),	 
			name: jQuery('#ppt_newsletter_mailme_name>').val(),	 
        },
        success: function(r) {
			
			if(r.status == "ok"){
				jQuery('#newsletterthankyou<?php echo $randomID; ?>').show();
				jQuery('#mailinglist-form<?php echo $randomID; ?>').html('');
			}else{
				jQuery('#mailinglist-form<?php echo $randomID; ?>').html("<?php echo __("Invalid Email Address","premiumpress") ?>");
			}
			
        },
        error: function(e) {
            //console.log(e)
        }
    });

}
</script>

<div id="newsletterthankyou<?php echo $randomID; ?>" style="display:none" class="newsletter-confirmation txt">
	<div class="h4"><?php echo __("Email confirmation sent.","premiumpress") ?></div>
	<p><?php echo __("Please check your email for a confirmation email.","premiumpress") ?></p>
	<p class="small"><?php echo __("Only once you've confirmed your email will you be subscribed to our newsletter.","premiumpress") ?></p>
</div>

<form id="mailinglist-form<?php echo $randomID; ?>" name="mailinglist-form<?php echo $randomID; ?>" method="post" onSubmit="return IsEmailMailinglist<?php echo $randomID; ?>();" class="footer-newsletter">
    

<div class="input-group mb-2">										 
<input type="text" name="ppt_newsletter_mailme_name" id="ppt_newsletter_mailme_name" value="" placeholder="<?php echo __("Name","premiumpress") ?>" style="height:40px;" class="form-control  rounded-pill border-0" /> 
  					
</div>  

<div class="input-group">										 
<input type="text" name="ppt_newsletter_mailme<?php echo $randomID; ?>" id="ppt_newsletter_mailme<?php echo $randomID; ?>" value="" placeholder="<?php echo __("Email","premiumpress") ?>" style="height:40px;" class="form-control  rounded-pill border-0" /> 
  					
</div>  

<button type="submit" class="btn btn-primary rounded-pill px-3 mt-3"><?php echo __("Subscribe","premiumpress") ?></button>

     
        
         
 </form>
<script>
		function IsEmailMailinglist<?php echo $randomID; ?>(){
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			var de4 	= document.getElementById("ppt_newsletter_mailme<?php echo $randomID; ?>");
			
			if(de4.value == ''){
			alert("<?php echo __("Please enter your email.","premiumpress") ?>");
			de4.style.border = 'thin solid red';
			de4.focus();
			return false;
			}
			if( !pattern.test( de4.value ) ) {	
			alert("<?php echo __("Invalid Email Address","premiumpress") ?>");
			de4.style.border = 'thin solid blue';
			de4.focus();
			return false;
			}
			ajax_newsletter_signup<?php echo $randomID; ?>();
		 
		  	return false;
		}		
 </script>
 

<?php } ?>
 
<?php } ?>