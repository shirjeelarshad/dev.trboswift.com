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
 
 
global $settings;


  $settings = array(
  
  "title" => __("Theme License Key","premiumpress"), 
  "desc" => __("Here you can update your license key.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<?php _ppt_template('framework/admin/blocks/login' ); ?>

<div class="mt-5"></div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 


  $settings = array(
  
  "title" => __("Check for Updates","premiumpress"), 
  "desc" => __("Here you can check your running the latest theme version.","premiumpress"),
  
  );
  if(!defined('WLT_DEMOMODE')){ 
   $settings['desc'] = $settings['desc']."<br><br><a href='javascript:void(0);' onclick=\"jQuery('#resetbox').toggle();\" style='color:blue'>Reset Options</a>";
  }
  
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body text-center py-5">
    <button type="button" onclick="Checkforupdates();" id="checkforupdatesbtn" class="btn btn-admin btn-sm color3" ><?php echo __("Check for updates","premiumpress"); ?></button>
    <div id="checkupdatesmsg" class="mt-4"></div>
    <div id="updatebtn" style="display:none;"> <a href="<?php echo home_url(); ?>/update-core.php" class="btn btn-primary mt-3"><?php echo __("Update now!","premiumpress"); ?></a> </div>
    
    <hr />
    
    <div class="text-center text-muted mt-3">
    
    Current Theme <strong> V <?php echo THEME_VERSION; ?></strong> updated on <strong><?php echo THEME_VERSION_DATE; ?></strong>.
    
    </div>
  </div>
</div>
<script>

function Checkforupdates(){

jQuery('#checkforupdatesbtn').html("<i class='fas fa-spinner fa-spin'></i>");

jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {			 
            admin_action: "check_updates",			 			
        },
        success: function(response) {
		
		console.log(response.status);
 
			if(response.status == "new"){
			
			jQuery('#checkupdatesmsg').html("Version "+response.msg+" is now available!");
			jQuery('#updatebtn').show();		  			 
  		 	 
			}else if(response.status == "old"){
			
			jQuery('#checkupdatesmsg').html("You are using the latest version.");			   			 
  		 	
			}else if(response.status == "error"){
			
			jQuery('#checkupdatesmsg').html(response.msg);
			  			 
  		 	
			}		
			 
			jQuery('#checkforupdatesbtn').html("Completed");
											
						
        },
        error: function(e) {
            alert("Could not validate license key.")
        }
    });

}
</script>
<?php  _ppt_template('framework/admin/_form-wrap-bottom' );  



if(!defined('WLT_DEMOMODE')){ echo "<div id='resetbox' style='display:none;'>"; }

  $settings = array(
  
  "title" => __("Website Reset","premiumpress"), 
  "desc" => __("These options will allow you to clean up or reset your website data.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body text-center py-5"> <a  href="javascript:void(0);" onclick="jQuery('#UpdateModal').modal('show');" class="btn btn-admin btn-sm color2" ><?php echo __("Delete Everything","premiumpress"); ?></a> </div>
</div>
<?php  _ppt_template('framework/admin/_form-wrap-bottom' );

if(!defined('WLT_DEMOMODE')){ echo "</div>"; }

 

 ?>
