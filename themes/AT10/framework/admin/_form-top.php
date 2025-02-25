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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }  global $wpdb, $CORE;   
 
?>

<script>
function CheckFormData(){
 
	var cleanme = "";
	
	jQuery('.form-control:not(.stopclean)').each(function(i, obj) {	
		 
		if(jQuery(obj).val() == "" && !jQuery(obj).hasClass('selectpicker') && !jQuery(obj).hasClass('bootstrap-select') && jQuery(obj).attr('name') != ""){	
			 
				jQuery(obj).remove();
				
				cleanme = cleanme + jQuery(obj).attr('name') +','
				 
		}
		 
	});
	
	jQuery("#cleardatastrings").val(cleanme);
	
	window.scrollTo(0, 0);
	
	jQuery("#saving-spinner").show();
	jQuery(".tab-content").hide();

 
return true;
}
</script>
<form method="post" name="admin_save_form" id="admin_save_form" enctype="multipart/form-data" <?php if(isset($_GET['page']) && $_GET['page'] == "settings" ){ ?> onsubmit="return CheckFormData()" <?php } ?>>

<textarea id="cleardatastrings" name="cleardatastrings" class="w-100" style="display:none;"></textarea>

<input type="hidden" name="submitted" value="yes" />
<input type="hidden" name="tabinner" class="tabinner" value="<?php if(isset($_POST['tabinner'])){ echo $_POST['tabinner']; } ?>" />
<input type="hidden" name="lefttab" class="lefttab" value="<?php if(isset($_POST['lefttab'])){ echo $_POST['lefttab']; } ?>" />
<input type="hidden" name="showaccordiantab" class="ShowThisAccordianTab" value="<?php if(isset($_POST['showaccordiantab'])){ echo $_POST['showaccordiantab']; } ?>" />
<?php if(isset($_GET['firstinstall']) && isset($_GET['page']) && $_GET['page'] == "settings" ){  ?>
<script>
    jQuery(document).ready(function () { 
	 
	document.admin_save_form.submit(); })
    </script>
<input type="hidden" name="newinstall" value="premiumpress" />
<input type="hidden" name="page" value="premiumpress" />
<?php if(defined('WLT_CART')){ ?>
<input type="hidden" name="admin_values[google]" value="0" />
<?php } ?>
<?php } ?>
