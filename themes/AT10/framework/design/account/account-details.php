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
   
   global $CORE, $userdata;
   $seek1 = "";
   $seek2 = "";
   	
   	// USER COUNTRY
   	$selected_country = $CORE->USER("get_address_part", array("country", $userdata->ID) ); 
   	if($selected_country == ""){
   		$selected_country = _ppt(array('user','account_usercountry'));
   	}
	
	// CHECK FOR USERNAME CHANGE
	$old_username = get_user_meta($userdata->ID,'old_username',true);
    
    $profile_pic = $CORE->USER("get_avatar", $userdata->ID );
   
   ?>

<style>
.control-label{
font-size:12px;
color:#bc9f4c;
}

</style>
 
   
<script>


function showdetails(type){
	
	if(type == "details"){
		jQuery("#userdetailsform").show();
        
		jQuery("#my-details").show();
        jQuery(".list-item-details").addClass("account-details-tab-bg");
        jQuery(".list-item-details a").addClass("text-white");
        jQuery(".list-item-details a").removeClass("text-dark");
        
        jQuery("#my-listings").hide();
        jQuery(".list-item-listing").removeClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-white");
        jQuery(".list-item-listing a").addClass("text-dark");
        
        jQuery("#my-bidding").hide();
        jQuery(".list-item-bidding").removeClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-white");
        jQuery(".list-item-bidding a").addClass("text-dark");
        
        jQuery("#my-notifications").hide();	
        jQuery(".list-item-notifications").removeClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-white");
        jQuery(".list-item-notifications a").addClass("text-dark");
        
        jQuery("#my-invoices").hide();	
        jQuery(".list-item-invoices").removeClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-white");
        jQuery(".list-item-invoices a").addClass("text-dark");
        
        jQuery("#my-favorites").hide();	
        jQuery(".list-item-favorites").removeClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-white");
        jQuery(".list-item-favorites a").addClass("text-dark");
	
	}else if(type == "listings"){
    	jQuery("#userdetailsform").hide();
        
		jQuery("#my-listings").show();
        jQuery(".list-item-listing").addClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-dark");
        jQuery(".list-item-listing a").addClass("text-white");
        
        jQuery("#my-details").hide();
        jQuery(".list-item-details").removeClass("account-details-tab-bg text-dark");
        jQuery(".list-item-details a").addClass("text-dark");
        jQuery(".list-item-details a").removeClass("text-white");
        
        jQuery("#my-bidding").hide();
        jQuery(".list-item-bidding").removeClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-white");
        jQuery(".list-item-bidding a").addClass("text-dark");
        
        jQuery("#my-notifications").hide();	
        jQuery(".list-item-notifications").removeClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-white");
        jQuery(".list-item-notifications a").addClass("text-dark");
        
        jQuery("#my-invoices").hide();	
        jQuery(".list-item-invoices").removeClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-white");
        jQuery(".list-item-invoices a").addClass("text-dark");
        
        jQuery("#my-favorites").hide();	
        jQuery(".list-item-favorites").removeClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-white");
        jQuery(".list-item-favorites a").addClass("text-dark");
	
	}else if(type == "bidding"){
		
		jQuery("#userdetailsform").hide();
        
        jQuery("#my-bidding").show();
        jQuery(".list-item-bidding").addClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-dark");
        jQuery(".list-item-bidding a").addClass("text-white");
        
		jQuery("#my-listings").hide();
        jQuery(".list-item-listing").removeClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-white");
        jQuery(".list-item-listing a").addClass("text-dark");
        
        jQuery("#my-details").hide();
        jQuery(".list-item-details").removeClass("account-details-tab-bg text-dark");
        jQuery(".list-item-details a").addClass("text-dark");
        jQuery(".list-item-details a").removeClass("text-white");
        
        jQuery("#my-notifications").hide();	
        jQuery(".list-item-notifications").removeClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-white");
        jQuery(".list-item-notifications a").addClass("text-dark");
        
        jQuery("#my-invoices").hide();	
        jQuery(".list-item-invoices").removeClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-white");
        jQuery(".list-item-invoices a").addClass("text-dark");
        
        jQuery("#my-favorites").hide();	
        jQuery(".list-item-favorites").removeClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-white");
        jQuery(".list-item-favorites a").addClass("text-dark");
		
	}else if(type == "invoices"){
		
		jQuery("#userdetailsform").hide();
        
        jQuery("#my-invoices").show();
        jQuery(".list-item-invoices").addClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-dark");
        jQuery(".list-item-invoices a").addClass("text-white");
        
		jQuery("#my-listings").hide();
        jQuery(".list-item-listing").removeClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-white");
        jQuery(".list-item-listing a").addClass("text-dark");
        
        jQuery("#my-bidding").hide();
        jQuery(".list-item-bidding").removeClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-white");
        jQuery(".list-item-bidding a").addClass("text-dark");
        
        jQuery("#my-details").hide();
        jQuery(".list-item-details").removeClass("account-details-tab-bg text-dark");
        jQuery(".list-item-details a").addClass("text-dark");
        jQuery(".list-item-details a").removeClass("text-white");
        
        jQuery("#my-notifications").hide();	
        jQuery(".list-item-notifications").removeClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-white");
        jQuery(".list-item-notifications a").addClass("text-dark");
        
        jQuery("#my-favorites").hide();	
        jQuery(".list-item-favorites").removeClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-white");
        jQuery(".list-item-favorites a").addClass("text-dark");
	
	 }else if(type == "favorites"){
		
		jQuery("#userdetailsform").hide();
        
        jQuery("#my-favorites").show();
        jQuery(".list-item-favorites").addClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-dark");
        jQuery(".list-item-favorites a").addClass("text-white");
        
		jQuery("#my-listings").hide();
        jQuery(".list-item-listing").removeClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-white");
        jQuery(".list-item-listing a").addClass("text-dark");
        
        jQuery("#my-details").hide();
        jQuery(".list-item-details").removeClass("account-details-tab-bg text-dark");
        jQuery(".list-item-details a").addClass("text-dark");
        jQuery(".list-item-details a").removeClass("text-white");
        
        jQuery("#my-notifications").hide();	
        jQuery(".list-item-notifications").removeClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-white");
        jQuery(".list-item-notifications a").addClass("text-dark");
        
        jQuery("#my-invoices").hide();	
        jQuery(".list-item-invoices").removeClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-white");
        jQuery(".list-item-invoices a").addClass("text-dark");
        
        jQuery("#my-bidding").hide();
        jQuery(".list-item-bidding").removeClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-white");
        jQuery(".list-item-bidding a").addClass("text-dark");

	 }else if(type == "notifications"){
		
		jQuery("#userdetailsform").show();
        
        jQuery("#my-notifications").show();
        jQuery(".list-item-notifications").addClass("account-details-tab-bg");
        jQuery(".list-item-notifications a").removeClass("text-dark");
        jQuery(".list-item-notifications a").addClass("text-white");
        
		jQuery("#my-listings").hide();
        jQuery(".list-item-listing").removeClass("account-details-tab-bg");
        jQuery(".list-item-listing a").removeClass("text-white");
        jQuery(".list-item-listing a").addClass("text-dark");
        
        jQuery("#my-bidding").hide();
        jQuery(".list-item-bidding").removeClass("account-details-tab-bg");
        jQuery(".list-item-bidding a").removeClass("text-white");
        jQuery(".list-item-bidding a").addClass("text-dark");
        
        jQuery("#my-details").hide();
        jQuery(".list-item-details").removeClass("account-details-tab-bg text-dark");
        jQuery(".list-item-details a").addClass("text-dark");
        jQuery(".list-item-details a").removeClass("text-white");
        
        
        jQuery("#my-invoices").hide();	
        jQuery(".list-item-invoices").removeClass("account-details-tab-bg");
        jQuery(".list-item-invoices a").removeClass("text-white");
        jQuery(".list-item-invoices a").addClass("text-dark");
        
        jQuery("#my-favorites").hide();	
        jQuery(".list-item-favorites").removeClass("account-details-tab-bg");
        jQuery(".list-item-favorites a").removeClass("text-white");
        jQuery(".list-item-favorites a").addClass("text-dark");

	 }
		
	
	

	SwitchPage('details');

}

 

</script>



<div class="row m-0">
<div class="col-md-2">
<ul class="bg-white list-unstyled py-3 my-3 radiusx" id="account_jumplinks" style="display:none; line-height:30px;">
        <li class="list-item-details account-details-tab-bg px-3 py-2 mb-3"> <a onclick="showdetails('details');" href="javascript:void(0);" class="text-decoration-none text-white" data-toggle="tab" role="tab"> <i class="far fa-user mr-2"></i> <?php echo __("My Profile","premiumpress") ?> </a> </li>
       
       <!-- <li class="list-item-listing  px-3 py-2 mb-3"> <a onclick="showdetails('listings');" href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i class="fas fa-list-ol mr-2"></i> <?php echo __("Listings","premiumpress") ?> </a> </li> -->
       
        <!-- <li class="list-item-bidding px-3 py-2 mb-3"> <a onclick="showdetails('bidding');" href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i class="fal fal fa-gavel mr-2"></i> <?php echo __("Bids","premiumpress") ?> </a> </li> -->
        
        <li class="list-item-invoices px-3 py-2 mb-3"> <a onclick="showdetails('invoices');" href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i class="far fa-window-restore mr-2"></i> <?php echo __("Invoices","premiumpress") ?> </a> </li>
        
         <!-- <li class="list-item-favorites px-3 py-2 mb-3"> <a onclick="showdetails('favorites');" href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i class="fal fa-heart mr-2"></i> <?php echo __("Favorites","premiumpress") ?> </a> </li> -->
         
       
 <?php if(in_array(_ppt(array('user','email_notify')),array("","1"))){ ?>
       
<li class="list-item-notifications px-3 py-2 mb-3"> <a onclick="showdetails('notifications');" href="javascript:void(0);" data-toggle="tab" role="tab" class="text-decoration-none text-dark"> <i class="fal fa-cog mr-2"></i> <?php echo __(" Settings","premiumpress") ?> </a> </li>
            
  <?php } ?>
            
 
       
  <li class="list-item px-3 py-2"> <a " href="<?php echo wp_logout_url(home_url()); ?>" class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i class="fal fa-sign-out-alt text-danger mr-2"></i> <?php echo __("Sign Out","premiumpress") ?> </a> </li>
    
      </ul>
      </div>

<div class="col-md-10">
<form class="bg-white radiusx col-12 my-3" action="" method="post" id="userdetailsform" onsubmit="return js_validate_fields('<?php echo __("Please completed required fields.","premiumpress") ?>')" enctype="multipart/form-data">
  <input type="hidden" name="action" value="userupdate" />
  <div>
    <div class="mt-3">
      <div id="my-details" >
        <div class="row m-0">
        
        <div class="col-12 pl-0 mb-3">

 <h4 class="mb-2 "><?php echo __("My Profile","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Manage your profile from here!","premiumpress"); ?> </h4>

</div>
        
          <div class="col-md-12 row m-0 radiusx border" >
          
          <div class="">
          <div class="text-center my-4 position-relative profile-img-block" style="width:100px; height:100px;">
                  <?php 
// GET USER PHOTO
$currentimg = get_user_meta($userdata->ID, "userphoto", true);

$i=1;
while($i < 16){
$user_avatars["f".$i] = "f".$i;
$i++;
}

$i=1;
while($i < 18){
$user_avatars["m".$i] = "m".$i;
$i++;
}
 
?>
          <i class="fal fa-camera camera-icon d-none"></i>  
          <img id="user-photo" class="rounded-circle img-fluid" src="<?php if($profile_pic){ echo $profile_pic; }else{ echo '<?php echo home_url(); ?>/wp-content/themes/AT10/framework/images/avatar/m13.png';} ?>" alt="user " style="width:100%; height:100%; object-fit:cover; border: 0.5px solid #f1f1f1;">
          
          </div>
           <input hidden id="file-input" type="file" name="ppt_userphoto" tabindex="12" />
           
              <style>
              .camera-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    cursor: pointer;
    font-size: 24px;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    border-radius: 50%;
}

.profile-img-block{
transition: 0.9s;
}
.profile-img-block:hover .camera-icon{
display:block !important;
}


.profile-img-block .fas.fa-trash-alt{
    position: absolute;
    right: 0px;
    top: 6px;
    color: red;
    background: #eee;
    padding: 5px;
    border-radius: 100px;
    width: 25px;
    height: 25px;
    font-size: 15px;
    cursor: pointer;
}

.profile-img-block:hover .fas.fa-trash-alt{display:block !important;}
    
 </style>
              
 <script>
jQuery(document).ready(function($) {
    // When the camera icon is clicked
    $('.camera-icon').on('click', function() {
        $('#file-input').click();  // Trigger the file input click
    });

    // When a file is selected in the file input
    $('#file-input').on('change', function() {
        var file = this.files[0];  // Get the selected file
        
        if (file) {
            var reader = new FileReader();  // Create a new FileReader
            
            // When the file is read successfully
            reader.onload = function(e) {
                $('#user-photo').attr('src', e.target.result);  // Update the image source
            }
            
            reader.readAsDataURL(file);  // Read the file as a data URL
        }
    });
});
</script>

 <script>
function delete_userphoto(){
 										   
 	
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "delete_userphoto",
			 		
        },
        success: function(response) {
 
			if(response.status == "ok"){
			
			alert("<?php echo __("Photo Deleted","premiumpress"); ?>"); 
			 			 
  		 	
			}else{			
		 			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });	
 		
}
</script>
          
</div>
<div class="col p-2">

 <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Public","premiumpress"); ?> <?php echo __("Username","premiumpress"); ?> <span id="ajaxMsgUser"></span> </label>
              <div class="controls position-relative">
                <input type="text" name="newusername" id="newusernamefield" class="form-control val-nospaces rounded-pill" value="<?php if(isset($_POST['usernamechange'])){ $the_user = get_user_by( 'id', $userdata->ID ); echo $the_user->user_login;  }else{ echo $userdata->user_login; } ?>" tabindex="6" autocomplete="off" onclick="jQuery('#savemydetailsbutton').hide();jQuery('#valnewusername').show();">
                <button type="button" class="btn btn-sm btn-system position-absolute" style="right:10px; top:10px; display:none" id="valnewusername"><?php echo __("validate","premiumpress"); ?></button>
              </div>
              <div class="mt-2 text-muted small"><?php echo __("The username can only be changed once. No spaces or special characters allowed.","premiumpress"); ?></div>
            </div>
          </div>
          <script>
jQuery(document).ready(function() {


jQuery(".showeditusernamefields").show();



         jQuery('#newusernamefield').change(function() { 
		 
		 jQuery('#ajaxMsgUser').html('');
		 
		 if(jQuery('#newusernamefield').val().length > 6){
		 
         
             jQuery.ajax({
                 type: "POST",
                 url: '<?php echo home_url(); ?>/',		
         		data: {
                     action: "validateUsername",
         			name: jQuery('#newusernamefield').val(), 
                 },
                 success: function(response) {
         		 
         			if(response == "yes"){
					
         			jQuery('#ajaxMsgUser').html("<span class='badge badge-danger'><i class='fa fa-close'></i> <?php echo __("Username Taken","premiumpress"); ?></span>");
					
					jQuery('#valnewusername').hide();
					
         			
         			} else {
         			
					jQuery('#ajaxMsgUser').html("<span class='badge badge-success'><i class='fa fa-check-circle'></i> <?php echo __("Valid","premiumpress"); ?></span>");
					
					jQuery('#userdetailsform').append('<input type="hidden" name="usernamechange" value="1">');						
					
					jQuery('#savemydetailsbutton').show();
					
					jQuery('#valnewusername').hide();
					
					
					}			
                 },
                 error: function(e) {
                     alert("error "+e)
                 }
             });
			 
			 
			 }else{
			 
			 jQuery('#ajaxMsgUser').html("<span class='badge badge-danger'><i class='fa fa-close'></i> <?php echo __("Invalid Username","premiumpress"); ?></span>");
					
			 
			 }
         
         });
});
</script>
 
<?php if(!in_array(THEME_KEY , array("da")) ){ ?>
          <div class="col-md-9">
            <div class="form-group">
              <label class="control-label"><i class="icon-comment"></i> <?php echo __("Bio","premiumpress"); ?></label>
              <textarea style="height:100px;" class="form-control radiusx border bg-light" placeholder="What do you want other users to know about? What cars do you like etc." name="description" tabindex="6"><?php echo stripslashes($userdata->description); ?></textarea>
            </div>
          </div>
          <?php } ?>
          
          
             <?php if(_ppt(array('user','social')) != "0"){  ?>
      <div id="my-social" class="col-12">
        <span class="mt-4 pb-3"><?php echo __("Social Media","premiumpress"); ?></span>
        <div class="row">
          <div class="col-md-3">
            
            <input type="text" name="facebook" class="form-control rounded-pill" placeholder="Facebook" value="<?php echo get_user_meta($userdata->ID,'facebook',true); ?>" tabindex="7">
          </div>
          <div class="col-md-3">
           
            <input type="text" name="twitter" class="form-control rounded-pill" placeholder="Twitter" value="<?php echo get_user_meta($userdata->ID,'twitter',true); ?>" tabindex="8">
          </div>
          <div class="col-md-3">
         
            <input type="text" name="linkedin" class="form-control rounded-pill" placeholder="LinkedIn" value="<?php echo get_user_meta($userdata->ID,'linkedin',true); ?>" tabindex="9">
          </div>
          <div class="col-md-3">
           
            <input type="text" name="skype" class="form-control rounded-pill" placeholder="Skype" value="<?php echo get_user_meta($userdata->ID,'skype',true); ?>" tabindex="10">
          </div>
        </div>
      </div>
      <?php } ?>

</div>
          
</div>

<div class="col-md-12 py-4 my-3 radiusx border" >

 <div>

 <h4 class="mb-2 "><?php echo __("My Account","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Manage your account from here","premiumpress"); ?> </h4>

</div>

<div class="row my-3">
<div class="col-md-3">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Given Name(Optional)","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="fname" class="form-control requiredfield rounded-pill" value="<?php echo $userdata->first_name ?>" tabindex="1">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Last Name(Optional)","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="lname" class="form-control requiredfield rounded-pill"  value="<?php echo $userdata->last_name ?>" tabindex="2">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Email","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="email" class="form-control requiredfield rounded-pill" value="<?php echo $userdata->user_email; ?>" disabled="disabled" tabindex="3">
              </div>
            </div>
          </div>
</div>

<div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("New Password","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="password" class="form-control rounded-pill" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("Confirm Password","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="password_r" class="form-control rounded-pill" autocomplete="off">
              </div>
            </div>
</div>


<did class="row mx-0 my-3">
 <?php  if(_ppt(array('user','mobile')) === "423"){  ?>
          <div class="col-md-6">
            <div class="form-group">
            
              <div class="row">
                <div class="col-12">
                  <label class="control-label"><?php echo __("Mobile Number","premiumpress"); ?></label>
                </div>
                <div class="col-12">
                  <div class="row m-0 border rounded-pill overflow-hidden">
                    
                      <input name="custom[mobile-prefix]" type="text" class="col-2 form-control border-0" id="mobileprefix-input" placeholder="+" 
                                 value="<?php echo get_user_meta($userdata->ID,'mobile-prefix',true); ?>" />
                    
                      <input name="custom[mobile]" type="text" class="col-10 form-control border-0" id="mobilenum-input"
                                 value="<?php echo get_user_meta($userdata->ID,'mobile',true); ?>" />
                    
                  </div>
                  <!-- end row -->
                </div>
              </div>
            </div>
          </div>
          <?php }  ?>
          
          <?php if(!in_array(THEME_KEY , array("da")) ){ ?>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("Phone","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="phone" class="form-control rounded-pill" value="<?php echo get_user_meta($userdata->ID,'phone',true); ?>" tabindex="5">
              </div>
            </div>
          </div>
          <?php } ?>
          
          <?php if(!in_array(THEME_KEY , array("da")) ){ ?>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Website","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="url" class="form-control rounded-pill" value="<?php echo get_user_meta($userdata->ID,'url',true); ?>" tabindex="4">
              </div>
            </div>
          </div>
          <?php } ?>
          
          </div>


</div>

<div class="col-md-12 py-4 my-3 radiusx border" >

 <div>

 <h4 class="mb-2 "><?php echo __("My Bidding Details","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Manage your bidding details from here","premiumpress"); ?> </h4>

</div>


<div class="row my-3">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Address Line 1","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="address1" class="form-control rounded-pill" value="<?php echo $CORE->USER("get_address_part", array("address1", $userdata->ID) ); ?>" tabindex="4">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Address Line 2","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="address2" class="form-control rounded-pill" value="<?php echo $CORE->USER("get_address_part", array("address2", $userdata->ID) ); ?>" tabindex="4">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("My Country","premiumpress"); ?></label>
              <div class="controls">
                <select name="country" class="form-control rounded-pill" tabindex="6" id="user-country">
                  <?php 
				  
				  $admin_countries = _ppt('checkout_countries');
				  
                        foreach($GLOBALS['core_country_list'] as $key=>$value){
						
						
						// HIDE COUNTRIES
						if( !is_array( $admin_countries ) || is_array($admin_countries) && in_array("0", $admin_countries ) ){						
						
						}else{
						
							if( is_array( $admin_countries ) && $admin_countries[0] != ""){		
								if(!in_array( $key, $admin_countries )  ){
								continue;
								}
							}
						
						}
						
						
                                if(isset($selected_country) && $selected_country == $key){ $sel ="selected=selected"; }else{ $sel =""; }
                                echo "<option ".$sel." value='".$key."'>".$value."</option>";} ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo __("Region","premiumpress"); ?></label>
              <div class="controls">
                <input type="hidden"  value="<?php echo $CORE->USER("get_address_part", array("city", $userdata->ID) ); ?>" id="user-city"  />
                <select class="form-control rounded-pill" id="user-city-select" name="city"  tabindex="7" >
                </select>
              </div>
            </div>
          </div>
          
           <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Town/City","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="town" class="form-control rounded-pill" value="<?php echo $CORE->USER("get_address_part", array("town", $userdata->ID) ); ?>" tabindex="4">
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("Postal/ Zipcode","premiumpress"); ?></label>
              <div class="controls">
                <input type="text" name="zip" class="form-control rounded-pill" value="<?php echo $CORE->USER("get_address_part", array("zip", $userdata->ID) ); ?>" tabindex="4">
              </div>
            </div>
          </div>
          
          
        </div>
        <!-- end row -->
        <script type="application/javascript">
            jQuery(document).ready(function(){ 
            
            	jQuery('#user-country').on('change', function(e){
            	
            		 ajax_update_citylist();
            	
            	});	
            	 	
            	 ajax_update_citylist(); 
            	
            });
            
            function ajax_update_citylist(){
            
            	// COUNTRY VALUE
            	var countryid = jQuery('#user-country').val();
            	if(countryid == ""){
            	countryid = jQuery('#user-country option:first').val();
            	}
             
            	// SET VALUE
            	jQuery('#user-city').val(countryid);
            
                jQuery.ajax({
                    type: "POST",
                    url: ajax_site_url,	 	
            		data: {
                        action: "get_location_states",
            			country_id: countryid,
              			state_id: "<?php echo get_user_meta($userdata->ID,'city',true); ?>",
                    },
                    success: function(response) {            	 
            			jQuery("#user-city-select").html(response);
                    },
                    error: function(e) {
                         
                    }
                });
            }
            
         </script>

</div>


<div class="col-md-12 py-4 my-3 radiusx border" >

 <div>

 <h4 class="mb-2 "><?php echo __("Bidding Source","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Manage your payment methods from here","premiumpress"); ?> </h4>

</div>

 
 <div id="my-payment" class="my-3">
     
       
            
             <div class="card-error"></div>
              <div class="all-payment-methods row m-0"></div>
             <div> <button type="button" class="btn btn-white "  onclick="addStripePaymentCard();"><i class="fas fa-plus-circle"></i> Add new card</button></div>
             
             <span>Payments are Secured </span>
             
         
      
      </div>
      
      <?php
      $user_id = $userdata->ID;
      
     
      ?>
      
      
     <script>
    retrieveAllPaymentMethods();

    function retrieveAllPaymentMethods() {
        // Send AJAX request to retrieve all payment methods for the customer
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'retrieve_all_payment_methods',
                user_id: '<?php echo $user_id; ?>',
                nonce: '<?php echo wp_create_nonce('retrieve_all_payment_methods_nonce'); ?>'
            },
            success: function(response) {
                
                // Display all payment methods in the .all-payment-methods div
                if (response.success) {
                    var paymentMethods = response.data.payment_methods;
                var paymentMethodsHTML = '';

                paymentMethods.forEach(function(method) {
                    paymentMethodsHTML += '<div class="col-md-6"><div class="bg-light credit-card ' + method.card.brand + ' selectable" data-payment-method-id="' + method.id + '" data-payment-method-brand="' + method.card.brand + '">';
                    
                    paymentMethodsHTML += '<div class="row">';
                    
                    paymentMethodsHTML += '<div class="col-3">';
                    
                    paymentMethodsHTML += '<div class="credit-card-img ' + method.card.brand + '"></div>';
                    
                    paymentMethodsHTML += '</div>';
                    
                    paymentMethodsHTML += '<div class="col-6">';
                    
                    paymentMethodsHTML += '<div class="font-weight-bold text-capitalize brandName">' + method.card.brand + '</div>';
                    paymentMethodsHTML += '<div class="mt-3 d-flex justify-content-start">';
                    paymentMethodsHTML += '<div class="pr-2 credit-card-last4">' + method.card.last4 + '</div>';
                    
                    paymentMethodsHTML += '<div class="credit-card-expiry">' + method.card.exp_month + ' / ' + method.card.exp_year + '</div>';
                    
                    paymentMethodsHTML += '</div>';
                    
                    paymentMethodsHTML += '</div>';
                    
                    paymentMethodsHTML += '<div class="col-3 d-flex flex-column align-items-end">';
                    
                    if (method.id === response.data.default_payment_method) {
                        paymentMethodsHTML += '<span class="badge bg-info ">Default</span>';
                    }
                    paymentMethodsHTML += '<a class="pr-2 remove-method-btn"><i class="fas fa-ban"></i> Remove</a>';
                    paymentMethodsHTML += '<a class="text-dark pr-2 pt-2 set-default-btn" title="Set as default"><i class="fas fa-ellipsis-h"></i></a>';
                    
                    paymentMethodsHTML += '</div>';
                    
                    paymentMethodsHTML += '</div>';

                    paymentMethodsHTML += '</div></div>';
                });

                document.querySelector('.all-payment-methods').innerHTML = paymentMethodsHTML;

// Add event listener to set default button
document.querySelectorAll('.set-default-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var paymentMethodId = this.closest('.credit-card').getAttribute('data-payment-method-id');
        setDefaultPaymentMethod(paymentMethodId);
    });
});

// Add event listener to remove button
document.querySelectorAll('.remove-method-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var paymentMethodId = this.closest('.credit-card').getAttribute('data-payment-method-id');
        var paymentMethodBrand = this.closest('.credit-card').getAttribute('data-payment-method-brand');
        removeCardYesNoBtn(paymentMethodBrand, paymentMethodId);
    });
});
                    
                } else {
                 
                 document.querySelector('.card-error').innerHTML = response.data;
                }
            },
            error: function(xhr, status, error) {
                document.querySelector('.card-error').innerHTML = error;
                
            }
        });
    }

    
    
    function setDefaultPaymentMethod(paymentMethodId) {
        // Send AJAX request to set default payment method
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_default_payment_method',
                user_id: '<?php echo $user_id; ?>',
                payment_method_id: paymentMethodId,
                nonce: '<?php echo wp_create_nonce('set_default_payment_method_nonce'); ?>'
            },
            success: function(response) {
                
                // Refresh payment methods list after setting default
                retrieveAllPaymentMethods();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }
    
    
function removeCardYesNoBtn(paymentMethodBrand, paymentMethodId) {
    jQuery('#stripe-card-content').empty();

    // Construct the function call as a string
    var detachFunctionCall = 'detachPaymentMethod("'+ paymentMethodId +'");';

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'show_modal_yes_no',
            message: 'Are you sure you want to remove this',
            card_name: paymentMethodBrand,
            yes_btn_call: detachFunctionCall, // Pass the function call string
        },
        success: function(response) {
            console.log('AJAX Success:', response);
            jQuery('.add-stripe-card-modal-wrap').fadeIn(400);
            jQuery('#stripe-card-content').html(response);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            // Handle error here (e.g., display error message)
        }
    });
}

    

    
    
    
     function detachPaymentMethod(paymentMethodId) {
     jQuery('.add-stripe-card-modal-wrap').fadeOut(400);
    // Send AJAX request to detach payment method
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'remove_payment_method',
            user_id: '<?php echo $user_id; ?>',
            payment_method_id: paymentMethodId,
            nonce: '<?php echo wp_create_nonce('remove_payment_method_nonce'); ?>'
        },
        success: function(response) {
           
            // Refresh payment methods list after detaching payment method
            retrieveAllPaymentMethods();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            // Handle error response
        }
    });
}

    
    
    
    
    // Function to add Stripe Payment Card the posts
    
    function addStripePaymentCard() {
        jQuery('#stripe-card-content').empty();
        
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_card_save_container',
                nonce: '<?php echo wp_create_nonce('add_stripe_payment_methods_nonce'); ?>'
            },
            success: function(response) {
            	jQuery('.add-stripe-card-modal-wrap').fadeIn(400);
                // Update the content of the post container with the new posts
                jQuery('#stripe-card-content').html(response);
               
            }
        
        });
    }
    
    
            
       </script>

</div>

  
          <?php if(_ppt(array('lang','switch')) == "1" && is_array(_ppt('languages')) && !empty(_ppt('languages'))  ){ ?>
                
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> <?php echo __("My Language","premiumpress"); ?></label>
              <div class="controls">
               
                   <select name="language" class="form-control" tabindex="5" id="user-language">
                  <?php 
				  
				  $selected_lang = get_user_meta($userdata->ID,'language',true);
				  
				  
				  $admin_countries = _ppt('checkout_countries');
				  
                        foreach(_ppt('languages') as $k => $lang){
						
                                if(isset($selected_lang) && $selected_lang == $lang){ $sel ="selected=selected"; }else{ $sel =""; }
                                echo "<option ".$sel." value='".$lang."'>".$CORE->GEO("get_lang_name", $lang)."</option>";
						} 
								
								
				?>
                </select>
               
               
              </div>
            </div>
          </div>
          <?php } ?>
          
          
         
          
          <div class="col-md-12">
            <div class="row"> <?php echo $CORE->user_fields($userdata->ID); ?> </div>
          </div>
        </div>
      </div>
  
      <div id="my-notifications" style="display:none;">
        <div class="col-12 my-3 row">
  <div class="col-md-6">
        
 <h4 class="mb-2 "><?php echo __("Notifications","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Here you can set email notifications","premiumpress"); ?></span>
  
        </div>
        <div class="col-md-6 text-right hide-mobile">
<a href="<?php echo home_url(); ?>/?s=" class="btn btn-secondary rounded-pill">Explore Auctions</a>
</div>

</div>


  <?php if(in_array(THEME_KEY, array("jb","mj", "ll")) ){ 
		  
		  	$mtype = get_user_meta($userdata->ID,'user_type',true);
		  
		  	if(THEME_KEY == "mj"){
				global $CORE_MICROJOBS;	
				$accountTypes = $CORE_MICROJOBS->_user_types();
			}elseif(THEME_KEY == "es"){
				global $CORE_ESCORTTHEME;	
				$accountTypes = $CORE_ESCORTTHEME->_escort_types();
			}elseif(THEME_KEY == "jb"){
				global $CORE_JOBS;	
				$accountTypes = $CORE_JOBS->_user_types();	
			}elseif(THEME_KEY == "ll"){
			global $CORE_LEARNING;	
			$accountTypes = $CORE_LEARNING->_user_types();	
			}
				  
		  ?>
          <div class="col-md-6 d-none">
            <label class="control-label"><?php echo __("I'm a","premiumpress"); ?></label>
            <select name="user_type" class="form-control" <?php if(THEME_KEY == "ex"){?>onchange="switchlabel(this.value)"<?php } ?>>
              <?php foreach($accountTypes as $k => $g){ ?>
              <option value="<?php echo $k ?>" <?php if($mtype == $k){ echo "selected='selected'"; } ?>>
              <?php if(isset($g['name'])){ echo $g['name']; }else{ echo $g; } ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <script>

function switchlabel(val){

	if(val == "user_em"){
	txt = "<?php echo __("I can teach","premiumpress"); ?>";
	}else{
	txt = "<?php echo __("I'm want to learn","premiumpress"); ?>";
	}
	jQuery("#da-seeking2-label").html(txt);
}

</script>
          <?php } ?>
          <?php if( THEME_KEY == "pj" && get_user_meta($userdata->ID,'user_type',true) == "user_fr" ){  $rate = get_user_meta($userdata->ID,'ppt_hourlyrate',true); if($rate == ""){ $rate = 0; } ?>
          <div class="col-md-12">
            <div class=" p-3 mb-4">
              <label class="control-label"><?php echo __("My Hourly Rate","premiumpress"); ?></label>
              <div class="input-group mb-3 mt-2">
                <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><?php echo _ppt(array('currency','symbol')); ?></span> </div>
                <input type="text" name="ppt_hourlyrate" value="<?php echo $rate; ?>" class="form-control">
              </div>
            </div>
          </div>
          <?php } ?>
          <?php if( in_array(THEME_KEY, array("da", "es")) ){

$seek1 = get_user_meta($userdata->ID,'da-seek1',true);
$seek2 = get_user_meta($userdata->ID,'da-seek2',true);

  
?>
          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 position-relative">
                  <label class="control-label"><?php echo __("I'm a","premiumpress"); ?></label>
                  <select name="da-seek1" class="form-control required">
                    <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
                    <option value="<?php echo $cat->term_id; ?>" <?php if($seek1 == "" && strtolower($cat->name) == "male"){  echo "selected=selected";  }elseif($seek1 ==  $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
                    <?php $count++; } } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" <?php if(_ppt(array('register','da_seeking')) == "1"){ echo 'style="display:none;"'; } ?>>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 position-relative">
                  <label class="control-label"><?php echo __("Interested In","premiumpress"); ?></label>
                  <select name="da-seek2" class="form-control required" >
                    <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
                    <option value="<?php echo $cat->term_id; ?>" <?php if($seek2 == "" && strtolower($cat->name) == "female"){  echo "selected=selected";  }elseif($seek2 ==  $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
                    <?php $count++; } } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <?php }else{ 


   // CATEGORY SELECT
	$seek1 = get_user_meta($userdata->ID,'da-seek2',true);

?>
          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 position-relative">
                  <label id="da-seeking2-label" class="control-label">
                  <?php 
		
		if(THEME_KEY == "ex"){
		
		
			if(get_user_meta($userdata->ID,'user_type',true) == "user_em"){
			echo __("I can teach","premiumpress"); 
			}else{		
			echo __("I'm want to learn","premiumpress"); 
			}  
		 
		 }else{ echo __("I'm mostly interested in","premiumpress"); } ?>
                  </label>
                  <select name="da-seek2" class="form-control rounded-pill bg-white">
                    <option value=""><?php echo __("Any Category","premiumpress"); ?></option>
                    <?php
                  $count = 1;
                  $cats = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
                    <option value="<?php echo $cat->term_id; ?>" <?php if($seek1 == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
                    <?php $count++; } } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <hr />
          </div>
          <?php } ?>
          

      
        <div class="">
          <div class="col-md-12">
            <?php
		  
		  $notify_match = get_user_meta($userdata->ID,'notify_match',true);
		  
		  
		  ?>
            <!-- ------------------------- -->
            <div class="container px-0 border-bottom mb-3">
              <div class="row py-2">
                <div class="col-md-8">
                  <label class="font-weight-bold"><?php echo __("Enable Notification","premiumpress"); ?></label>
              <!---    <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Turn on/off email notifications for new matches.","premiumpress")); ?></p> --->
                </div>
                <div class="col-md-4">
                  <div class="mt-3 togglebox" onclick="ToggleME('notify_match')" id="notify_match_toggle">                   
                    <div class="toggle <?php if(in_array($notify_match, array("","1"))){ ?>on<?php } ?>">
                      <div class="yes"><?php echo __("YES","premiumpress"); ?></div>
                      <div class="switch"></div>
                      <div class="no"><?php echo __("NO","premiumpress"); ?></div>
                    </div>
                  </div>
                  <input type="hidden" id="notify_match" name="notify_match" value="<?php if(in_array($notify_match, array("","1"))){  echo 1; }else{ echo 0; }  ?>">
                </div>
              </div>
            </div>
            <?php if(in_array($notify_match, array("","1"))){ 
	
	
	$match_data = get_user_meta($userdata->ID,'notify_match_data',true);
	if(!is_array($match_data)){$match_data = array(); }
	
	?>
            <div class="">
              <div class="control-label font-weight-bold mb-2"><?php echo __("Notification Categories","premiumpress"); ?></div>
              
              <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Each time a new %s is added to a category you select below, you'll receive an email notification.","premiumpress")); ?>
              </p>
     
     <div class="row">         
<?php

$count = 1;

if( in_array(THEME_KEY, array("da", "es")) ){
$taxonomy = "dagender";
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
}else{
$taxonomy = "listing";
$cats = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => 0  ));
}

if(!empty($cats)){

foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
                   

?>         
<div class="col-md-6">     

<label class="custom-control custom-checkbox">

<input type="checkbox" value="<?php echo $cat->term_id; ?>" name="notify_match_data[]" class="custom-control-input"  <?php if(in_array($cat->term_id, $match_data)){ echo "checked=checked"; } ?>>
        <div class="custom-control-label">
		
         
		<a href="<?php echo get_term_link( $cat->term_id, $taxonomy); ?>" class="text-dark">
        
         
		<?php echo $CORE->GEO("translation_tax_value", array($cat->term_id, $cat->name));  ?>
        
        
        </a>        
        
        </div>
        </label>
</div>
              
<?php } } ?>            
   </div>            
              
  </div>
            <?php } ?>         
              
              

          </div>
        </div>
      </div>
   
      
      
    </div>
  </div>
  <div class="py-3 pb-3 mobile-mb-6 savemydetailssection">
    <button class="btn btn-primary mt-2 btn-md" type="submit" id="savemydetailsbutton"><?php echo __("Save Changes","premiumpress"); ?></button>
  </div>
  <!-- end card footer -->
</form>
<!-- form block clole -->

<div id="my-listings" style="display:none;" class="bg-white radiusx col-12 my-3">

<script>
function showMyListings(type){
	
	if(type == "myListings"){
        jQuery("#my-archive-listings").hide();
		jQuery("#listings-details").show();
        jQuery(".account-toggle-buttons .archive-auctions").removeClass("btn-primary text-white");
        jQuery(".account-toggle-buttons .archive-auctions").addClass("btn-light");
        jQuery(".account-toggle-buttons .active-acutions").addClass("btn-primary text-white");
        
  	}else if(type == "myListingsArchive"){
    	jQuery("#listings-details").hide();
    	jQuery("#my-archive-listings").show();
        jQuery(".account-toggle-buttons .active-acutions").removeClass("btn-primary text-white");
        jQuery(".account-toggle-buttons .active-acutions").addClass("btn-light");
        jQuery(".account-toggle-buttons .archive-auctions").addClass("btn-primary text-white");
        
    
    }
  
 }

</script>
<div class="col-12 my-3 row">
  <div class="col-md-6">
	<h4 class="mb-2 "><?php echo __("Listings","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Here you will see all your listings!","premiumpress"); ?> </span>
  
  <div class="account-toggle-buttons mt-3">
  <a href="javascript:void(0)" onclick="showMyListings('myListings');" class="active-acutions btn btn-primary text-white radiusx">Listings</a>
  <a href="javascript:void(0)" onclick="showMyListings('myListingsArchive');" class="archive-auctions btn btn-light radiusx">Archived Listings</a>
  </div>
  
</div>
<div class="col-md-6 text-right hide-mobile">
<a href="<?php echo home_url(); ?>/?s=" class="btn btn-secondary rounded-pill">Bid Now</a>
</div>

</div>
<div id="listings-details">
  <?php get_template_part( 'framework/design/account/account-listings'); ?>
 </div>
  <div id="my-archive-listings" style="display:none;">
    <?php echo do_shortcode('[LISTINGS card_class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-3" ]'); ?>
  
    </div>
  
</div>

<div id="my-bidding" style="display:none;" class="bg-white radiusx col-12 my-3">

<script>
function showMyBids(type){
	
	if(type == "activeBids"){
        jQuery("#archive-bids").hide();
		jQuery("#active-bids").show();
        jQuery(".account-toggle-buttons .archive-bids").removeClass("btn-primary text-white");
        jQuery(".account-toggle-buttons .archive-bids").addClass("btn-light");
        jQuery(".account-toggle-buttons .active-bids").addClass("btn-primary text-white");
        
  	}else if(type == "archiveBids"){
    	jQuery("#active-bids").hide();
    	jQuery("#archive-bids").show();
        jQuery(".account-toggle-buttons .active-bids").removeClass("btn-primary text-white");
        jQuery(".account-toggle-buttons .active-bids").addClass("btn-light");
        jQuery(".account-toggle-buttons .archive-bids").addClass("btn-primary text-white");
        
    
    }
  
 }

</script>

  <div class="col-12 my-3 row">
  <div class="col-md-6">
 <h4 class="mb-2 "><?php echo __("My Bids","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Here you will see all your bids!","premiumpress"); ?></span>
  
  <div class="account-toggle-buttons mt-3">
  <a href="javascript:void(0)" onclick="showMyBids('activeBids');" class="active-bids btn btn-primary text-white radiusx">Active Bids</a>
  <a href="javascript:void(0)" onclick="showMyBids('archiveBids');" class="archive-bids btn btn-light radiusx">Archived Bids</a>
  </div>
  
</div>
<div class="col-md-6 text-right hide-mobile">
<a href="<?php echo home_url(); ?>/?s=" class="btn btn-secondary rounded-pill">Bid Now</a>
</div>

</div>

	<div id="active-bids">
    <?php get_template_part( 'framework/design/account/account-offers'); ?>
    </div>
    <div id="archive-bids" style="display:none;">
    <?php echo do_shortcode('[LISTINGS card_class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-3" ]'); ?>
  
    </div>
</div>

<div id="my-invoices" style="display:none;" class="bg-white radiusx col-12 my-3">
       <?php get_template_part( 'framework/design/account/account-orders'); ?>
</div>

<div id="my-favorites" style="display:none;" class="bg-white radiusx col-12 my-3">
    <div class="col-12 my-3 row">
  <div class="col-md-6">
        
 <h4 class="mb-2 "><?php echo __("Favorites","premiumpress"); ?> </h4>
 
  <span class="text-dark "><?php echo __("Here you will see your favorites","premiumpress"); ?></span>
  
        </div>
        <div class="col-md-6 text-right hide-mobile">
<a href="<?php echo home_url(); ?>/?s=" class="btn btn-secondary rounded-pill">Explore Auctions</a>
</div>

</div>
  <?php echo do_shortcode('[LISTINGS custom=userfavorite card_class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-3" ]'); ?>

</div>

</div>

<!-- col-12 block clole -->



</div>