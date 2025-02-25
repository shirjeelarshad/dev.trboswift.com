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

global $CORE, $userdata;

		$nameArray = array(
		
		"realestate" => array("n" => "Real Estate Theme"),
		"directory" => array("n" => "Directory Theme"),
		"coupon" => array("n" => "Coupon Theme"),
		"auction" => array("n" => "Auction Theme"),
		"shop" => array("n" => "Shop Theme"),
		"classifieds" => array("n" => "Classifieds Theme"),
		"photography" => array("n" => "Stock Photo Theme"),
		"compare" => array("n" => "Comparison Theme"),
		"dating" => array("n" => "Dating Theme"),
		"video" => array("n" => "Video Theme"),
		"software" => array("n" => "Software Download Theme"),
		"micro" => array("n" => "Micro Jobs Theme"),
		"jobs" => array("n" => "Jobs Board Theme"),		
		"cardealer" => array("n" => "Car Dealer Theme"),		
		"project" => array("n" => "Project Theme"),
		"booking" => array("n" => "Booking Theme"),
		
		"exchange" => array("n" => "Language Exchange Theme"),
		
		"escort" => array("n" => "Escort Theme"),
		"learning" => array("n" => "Learning Theme"),
		
		"_dev" => array("n" => "xxx"),
		
		);
	 
 
		$HandlePath = get_template_directory(); $TemplateString = "";
	    $count=1;
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){	
			
				// GET LIST
				if(substr($file,0,1) == "_" && is_dir(get_template_directory()."/".$file)){
				
					if(str_replace("_","",$file) == "mobile"){ continue; }
				
					$TemplateString .= '<option value="'.str_replace("_","",$file).'">'; 
						$TemplateString .= $nameArray[str_replace("_","",$file)]["n"]." - Version ".THEME_VERSION;									
						$TemplateString.= "</option>";	
				}
			
			 
			}
		}

?>

<div class="text-center" id="installspinner" style="display:none;">
  <div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x  fa-spin"></i></div>
  <div class="mt-3 text-muted">
    <?php if(get_option("ppt_reinstall") != ""){ ?>
    Updating your theme, please wait...
    <?php }else{ ?>
    Installing, please wait...
    <?php } ?>
  </div>
</div>
<div id="licensekeyform">
  <div class="card card-body shadow-sm mx-auto bg-white p-4">
    <?php if(get_option("ppt_reinstall") != "" && isset($_GET['page']) && $_GET['page'] == "premiumpress" ){ ?>
    <div class="bg-light p-3 mb-4">
      <h3><i class="fal fa-check mr-2 text-success"></i> New Update Installed</h3>
      <p class="lead ">Please check &amp; confirm your license key below.</p>
      <p class="opacity-5">Your license key can be <a href="https://www.premiumpress.com/account/" target="_blank"><u>found here</u>.</a> You'll need this each time you update.</p>
    </div>
    <?php } ?>
    <label class="font-weight-bold">
    <?php if(get_option("ppt_reinstall") != ""){ ?>
    <?php echo __("New License Key","premiumpress"); ?>
    <?php }else{ ?>
    <a href="https://www.youtube.com/watch?v=h5R9jBkSbfs" class="btn btn-sm popup-yt btn-danger float-right" id="helpvideo" target="_blank" style="display:none;"><i class="fa fa-video mr-1"></i> need help?</a> <a href="https://premiumpress.com/account/?installhelp=<?php echo home_url(); ?>" target="_blank" class="small" id="logintext" style="float:right">what is this?</a> Avangate Order ID
    <?php } ?>
    </label>
    <input class="form-control" id="avangateid" style="height:60px !important; font-size:30px !important; text-align:center; " placeholder="xxx-xxx-xxx" value="<?php if(get_option("ppt_reinstall") != "" && isset($_GET['page']) && $_GET['page'] == "premiumpress" ){ echo get_option("ppt_license_key_bk"); } ?>"  />
    <div class="row px-0 mt-3">
      <div class="col-md-6">
        <label class="checkbox small py-4 btn-block p-0 w-100">
        <input type="checkbox" value="" onchange="UnDMe()" />
        I agree to the <a href="javascript:void(0);" onclick="jQuery('#termbox').toggle();">terms of usage</a>. </label>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-lg btn-block btn-admin mb-3 rounded-0 px-5" id="mainsavebtn" onclick="ppt_install_check()">
        <?php if(get_option("ppt_license_key") == ""){ echo __("Continue","premiumpress"); }else{ echo __("Update","premiumpress"); } ?>
        </button>
      </div>
    </div>
    <div style="display:none" id="termbox">
      <textarea style="height:150px;width:100%; margin-bottom:20px; font-size:12px;"><?php include("terms.txt"); ?>
</textarea>
      <?php if(strlen($TemplateString) > 1){  ?>
      <?php $selected_template = ""; ?>
      <select  class="form-control" id="seltemplate"  style="width:100%; height:45px;">
        <?php echo $TemplateString; ?>
      </select>
      <?php } ?>
      
      <div class="mt-3 small opacity-5">
      <?php echo $_SERVER['SERVER_ADDR']; ?>
      </div>
    </div>
  </div>
</div>
<?php /*
<form method="post" id="newinstallform">
<input type="hidden" name="submitted" value="yes" />
<input type="hidden" name="firstimeinstall" value="yes" /> 

<input type="hidden" name="adminArray[ppt_license_key]" id="licensekeyf" value="" /> 
<input type="hidden" name="admin_values[template]" id="templatef" value="" /> 
 
</form>
*/ 

?>
<script>

jQuery(document).ready(function() { 

jQuery('#mainsavebtn').attr('disabled', true);  });
 
function UnDMe(){
 
if ( jQuery('#mainsavebtn').is(':disabled') === false) { jQuery('#mainsavebtn').attr('disabled', true);  
} else {jQuery('#mainsavebtn').attr('disabled', false);  }}

function ppt_install_check(){

	jQuery('#mainsavebtn').html("<i class='fas fa-spinner fa-spin'></i>");

	var de4 	= document.getElementById("avangateid");
	if(de4.value == ''){
		alert('Order ID Missing');
		de4.style.border = '3px solid red';
		de4.focus();

		jQuery('#mainsavebtn').html("<span>Try Again</span>");
		
		return false;
	}


jQuery.ajax({
        type: "POST",
        url: '<?php echo $CORE->_ppt_home_url(); ?>/',	
		dataType: 'json',	
		data: {			 
            admin_action: "check_license",			 
			key: jQuery('#avangateid').val().trim(),
			theme: jQuery('#seltemplate').val(),			
        },
        success: function(response) {
 			
			
			if(response == "expired"){
			
				alert("Your license key has expired.");
			} 
			
			if(response.status == "update" || response.status == "install"){
			
				jQuery('#licensekeyf').val(jQuery('#avangateid').val().trim());			
				jQuery('#templatef').val(jQuery('#seltemplate').val());
				 
				
				if(response.status == "install"){
				
					jQuery('#installspinner').show();
					jQuery('#licensekeyform').hide();
				
					jQuery('#newinstallform').submit();
					
				}else{
				
					jQuery('#admin_save_form').append('<input class="hidden" name="adminArray[ppt_license_key]" value="'+jQuery('#avangateid').val()+'">');	
					jQuery('#admin_save_form').submit();
				}
			 	 			 
  		 	
			}else{				
			
				jQuery('#helpvideo').show();
				jQuery('#logintext').hide();
			
			
				var de4 	= document.getElementById("avangateid");
				de4.style.border = '2px solid red';
				de4.focus();				
				alert(response.msg);				
				jQuery('#mainsavebtn').html("<span>Try Again</span>");
											
			}			
        },
        error: function(e) {
		
			
			jQuery('#helpvideo').show();
			jQuery('#logintext').hide();
		
            alert("Could not validate license key.")
        }
    });

}
</script>
