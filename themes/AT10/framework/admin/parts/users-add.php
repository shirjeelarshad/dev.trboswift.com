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

$userdata = array();

$u1 = "";
$u2 = "";
$u3 = "";

$selected_country = "";
$selected_city = "";

if(isset($_GET['eid'])){ 

	// GET USER INFO
	$user_info = get_userdata($_GET['eid']); 
	
	$u1 = get_user_meta($_GET['eid'],'login_count',true);
	$u2 = get_user_meta($_GET['eid'],'login_lastdate',true);
	$u3 = get_user_meta($_GET['eid'],'login_ip',true);
	
	// USER COUNTRY
	$selected_country 	= $CORE->USER("get_address_part", array("country", $_GET['eid']) );
	$selected_city 		= $CORE->USER("get_address_part", array("city", $_GET['eid']) );

}

if(isset($selected_country) && $selected_country == ""){
   	$selected_country = _ppt(array('user','account_usercountry'));
}
	
?>
<script>
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}
function VALIDATE_FORM_DATA(){ 
// FIRE DEFAULT VALIDATION
	canContinue = js_validate_fields("<?php echo __("Please completed all required-field fields.","premiumpress"); ?>");	
	
 
	var de4 	= document.getElementById("user_email");
	if(de4.value == ''){
		alert('Please enter your email.');
		de4.style.border = '3px solid red';
		de4.focus(); 		
		return false;
	}	
	
	if( !isValidEmailAddress( de4.value ) ) {
	
		alert('Please enter a valid email.');
		de4.style.border = '3px solid red';
		de4.focus(); 		
		return false;
	 
	} 
	 
	// SHOW SPINNER
	if(canContinue){
		
		jQuery('#user_form').hide();
		jQuery('#saving-spinner').show(); 
		
		return true;
	}
	
	return false;

}

</script>

<form method="post" action="" enctype="multipart/form-data" onsubmit="return VALIDATE_FORM_DATA();" id="user_form">
  <input type="hidden" name="edituserid" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 0; }?>" />
  <div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div class="e-profile">
          <div class="row">
            <div class="col-12 col-sm-auto mb-3">
              <div class="mx-auto" style="width: 140px;">
                <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                  <?php 
					
					if(isset($_GET['eid'])){
						echo $CORE->USER("get_photo", $_GET['eid']);
					}else{
					 ?>
                  <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                  <?php
					} 
					
					?>
                </div>
              </div>
            </div>
            <div class="col">
              <ul class="float-right list-unstyled">
                <li class="mb-4">
                  <?php if(isset($user_info)){ ?>
                  <span class="badge badge-primary"><?php echo $CORE->USER("get_role", $_GET['eid'] ); ?></span>
                  <?php } ?>
                </li>
                <li class="small text-muted"><?php echo __("Login count","premiumpress"); ?>: <strong>
                  <?php if( $u1 == ""){ echo 0; }else{ echo $u1; } ?>
                  </strong></li>
                <li class="small text-muted"><?php echo __("Last login IP","premiumpress"); ?>: <strong>
                  <?php if( $u1 == ""){ echo "unknown"; }else{ echo $u3; } ?>
                  </strong></li>
              </ul>
              <div class="text-center text-sm-left mb-2 mb-sm-0">
                <?php if(isset($user_info) && isset($user_info->display_name)){  ?>
                <h4 class="pt-sm-2 pb-1 mb-3 text-nowrap"><?php echo $user_info->display_name; ?></h4>
                <p class="mb-0">@<?php echo $user_info->user_login; ?></p>
                <?php if(isset($_GET['eid'])){ ?>
                <div class="text-muted"><small><?php echo __("Last seen","premiumpress"); ?> <?php echo $CORE->USER("get_lastlogin",$_GET['eid'] ); ?></small></div>
                <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <ul class="nav nav-tabs mt-4"   role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true"><?php echo __("General","premiumpress"); ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false"><?php echo __("Photo","premiumpress"); ?></a> </li>
         
          <li class="nav-item"> <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false"><?php echo __("Password","premiumpress"); ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="orderhistoryt-tab" data-toggle="tab" href="#orderhistoryt" role="tab" aria-controls="orderhistoryt" aria-selected="false"><?php echo __("Invoices","premiumpress"); ?></a> </li>
       
       <?php if( in_array(THEME_KEY, array("vt","cm")) || $CORE->LAYOUT("captions","offers") == ""){ }else{ ?>
       
       <li class="nav-item"> <a class="nav-link" id="mjorders-tab" data-toggle="tab" href="#mjorders" role="tab" aria-controls="mjorders" aria-selected="false"><?php echo __("Orders","premiumpress"); ?></a> </li>
       
       
       <?php } ?>
       
        </ul>
        <div class="tab-content bg-white pt-4  px-0" id="myTabContent">
          <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
            <div class="row">
            
            
            
            
              <div class="col-md-6">
              
              
               
                <div class="form-group">
                  <label><?php echo __("Username","premiumpress"); ?> <span id="ajaxMsgUser"></span> </label>
                  
                  
                  <input class="form-control required-field val-nospaces" type="text" id="newusernamefield" name="user_login" value="<?php 
				  
				  
				   if(isset($_POST['usernamechange']) ){ echo $_POST['user_login'];  }else{ if(isset($user_info)){ echo $user_info->user_login; } } ?>">
                  
                  
                  <script>
jQuery(document).ready(function() {

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
         			
         			} else {
         			
					jQuery('#ajaxMsgUser').html("<span class='badge badge-success'><i class='fa fa-check-circle'></i> <?php echo __("Valid Username","premiumpress"); ?></span>");
					
					jQuery('#user_form').append('<input type="hidden" name="usernamechange" value="1">');	
					
					}			
                 },
                 error: function(e) {
                     alert("error "+e)
                 }
             });
			 
			 
			 }
         
         });
});
</script>
              </div>
             
             
                                   
               
                <div class="form-group mt-n2">
                  <label><?php echo __("First Name","premiumpress"); ?></label>
                  <input class="form-control required-field" type="text" name="first_name" value="<?php if(isset($user_info)){ echo $user_info->first_name; } ?>">
                </div>
                <div class="form-group">
                  <label><?php echo __("Last Name","premiumpress"); ?></label>
                  <input class="form-control" type="text" name="last_name" value="<?php if(isset($user_info)){ echo $user_info->last_name; } ?>">
                </div>
                <div class="form-group">
                  <label><?php echo __("Email","premiumpress"); ?></label>
                  <input class="form-control required-field" type="text" placeholder="user@example.com" id="user_email" name="email" value="<?php if(isset($user_info)){ echo $user_info->user_email; } ?>">
                </div>
                
                       <?php if(_ppt(array('lang','switch')) == "1" && is_array(_ppt('languages')) && !empty(_ppt('languages'))  ){ ?>
                
        <div class="form-group">
              <label> <?php echo __("My Language","premiumpress"); ?></label>
            
               
                   <select name="language" class="form-control" tabindex="5" id="user-language">
                  <?php 
				  
				  if(isset($user_info)){
				  $selected_lang = get_user_meta($user_info->ID,'language',true);
				  }
				  
				  $admin_countries = _ppt('checkout_countries');
				  
                        foreach(_ppt('languages') as $k => $lang){
						
                                if(isset($selected_lang) && $selected_lang == $lang){ $sel ="selected=selected"; }else{ $sel =""; }
                                echo "<option ".$sel." value='".$lang."'>".$CORE->GEO("get_lang_name", $lang)."</option>";
						} 
								
								
				?>
                </select>
               
                
          </div>
          <?php } ?>
                
                
                
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><?php echo __("About","premiumpress"); ?></label>
                  <textarea class="form-control" rows="5" name="description" placeholder="My Bio" style="height:250px !important; font-size:11px !important;padding-top:15px !important;"><?php if(isset($user_info)){ echo $user_info->description; } ?>
</textarea>
                </div>
              </div>
              
              
                <div class="col-12">
                  <div class="step">
                    <h3 class="mb-1 mt-4"><?php echo __("User Social Media","premiumpress"); ?></h3>
                  </div>
                  <hr />
                </div>
              
              <div class="col-12">
               <div class="row">
            <div class="col-md-6">
              <label class="mb-2">Facebook</label>
              <input type="text" name="facebook" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'facebook',true); } ?>" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="mb-2">Twitter</label>
              <input type="text" name="twitter" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'twitter',true); } ?>" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="mb-2 mt-2">Linked-In</label>
              <input type="text" name="linkedin" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'linkedin',true); } ?>" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="mb-2 mt-2">Skype</label>
              <input type="text" name="skype" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'skype',true); } ?>" class="form-control" />
            </div>
            </div>
             </div> 
              
              
              
              
              
              
              
              
              <?php 
				  $uid = 0;
				  if(isset($_GET['eid'])){
				  $uid = $_GET['eid'];
				  }
				  echo $CORE->user_fields($uid); ?>
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
              <div class="col-12">
                <div class="card-body-grey">
                  <div class="step">
                    <h3 class="mb-1 mt-4"><?php echo __("User Address","premiumpress"); ?></h3>
                  </div>
                  <hr />
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label><?php echo __("Address","premiumpress"); ?> 1</label>
                    <input type="text" name="address1" value="<?php if(isset($_GET['eid'])){ echo $CORE->USER("get_address_part", array("address1", $_GET['eid']) ); } ?>" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label><?php echo __("Address","premiumpress"); ?> 2</label>
                    <input type="text" name="address2" value="<?php if(isset($_GET['eid'])){ echo $CORE->USER("get_address_part", array("address2", $_GET['eid']) ); } ?>" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label><?php echo __("Country","premiumpress"); ?></label>
                    <select name="country" class="form-control"   id="user-country">
                      <?php 
                        foreach($GLOBALS['core_country_list'] as $key=>$value){
                                if(isset($selected_country) && $selected_country == $key){ $sel ="selected=selected"; }else{ $sel =""; }
                                echo "<option ".$sel." value='".$key."'>".$value."</option>";} ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label><?php echo __("Region","premiumpress"); ?></label>
                    <input type="hidden"  value="<?php echo $selected_city; ?>" id="user-city"  />
                    <select class="form-control" id="user-city-select" name="city"   >
                    </select>
                  </div>
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
              			state_id: "<?php echo $selected_city; ?>",
                    },
                    success: function(response) {            	 
            			jQuery("#user-city-select").html(response);
                    },
                    error: function(e) {
                         
                    }
                });
            }
            
         </script>
         
         
         
          <div class="form-group col-md-6">
                    <label><?php echo __("Town/City","premiumpress"); ?></label>
                    <input type="text" name="town" value="<?php if(isset($_GET['eid'])){ echo $CORE->USER("get_address_part", array("town", $_GET['eid']) ); } ?>" class="form-control" />
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label><?php echo __("Zipcode","premiumpress"); ?></label>
                    <input type="text" name="zip" value="<?php if(isset($_GET['eid'])){ echo $CORE->USER("get_address_part", array("zip", $_GET['eid']) ); } ?>" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="col-form-label"><?php echo __("Mobile Number","premiumpress"); ?></label>
                      </div>
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-4">
                            <input name="mobile-prefix" type="text" class="form-control" id="mobileprefix-input" placeholder="+" 
                                 value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'mobile-prefix',true); } ?>" />
                          </div>
                          <div class="col-8">
                            <input name="mobile" type="text" class="form-control" id="mobilenum-input"
                                 value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'mobile',true); } ?>" />
                          </div>
                        </div>
                        <!-- end row -->
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php if(isset($_GET['eid'])){ echo $CORE->USER("get_address_part", array("phone", $_GET['eid']) ); } ?>" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Website</label>
                    <input type="text" name="url" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'url',true); } ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card-body-grey">
                  <div class="step">
                    <h3 class="mb-1 mt-4"><?php echo __("User Account Page","premiumpress"); ?></h3>
                  </div>
                  <hr />
                </div>
                <div><?php echo __("Account Notice","premiumpress"); ?></div>
                <textarea name="customtext" style="width:100%; height:100px; margin-top:10px;"><?php if(isset($_GET['eid'])){ echo stripslashes(get_user_meta($_GET['eid'],'ppt_customtext',true)); } ?>
</textarea>
                <p style="margin-bottom:20px;"><?php echo __("This text will appear at the top of the users main account page.","premiumpress"); ?></p>
              </div>
            </div>
            <!-- end inner row -->
          </div>
           <div class="tab-pane fade" id="orderhistoryt" role="tabpanel" aria-labelledby="orderhistoryt-tab">
            <?php _ppt_template('framework/design/account/account-orders' ); ?>
          </div>
          <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="profile-tab">
            <?php _ppt_template('framework/admin/parts/users-add-password' ); ?>
          </div>
          
          
          
          
           <?php if( in_array(THEME_KEY, array("vt","cm")) || $CORE->LAYOUT("captions","offers") == ""){ }else{ ?>
           <div class="tab-pane fade" id="mjorders" role="tabpanel" aria-labelledby="mjorders-tab">
            <?php _ppt_template('framework/design/account/account-offers' ); ?>
            <style>
			.img-list img { max-width:50px; max-height:40px; border: 1px solid #ddd;    padding: 2px; }
			.message-chat img { max-width:40px; }
			</style>
          </div>
           
           <?php } ?>
          
          
          
          
          
          <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
           
           
           
           
           
<?php       
           
// GET USER PHOTO
$currentimg = "";
if(isset($_GET['eid'])){
$currentimg = get_user_meta($_GET['eid'], "userphoto", true);
}

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
<div class="card-body">
 
<div class="container px-0">
  <div class="row">
    <div class="col-md-6 border-right">
      <h6 class="title-dark"><?php echo __("My Photo","premiumpress"); ?></h6>
      <div class="text-center my-4" id="photopreview"><?php if(isset($_GET['eid'])){
						echo $CORE->USER("get_photo", array($_GET['eid'], 140));
					}else{ } ?></div>
      <div class="text-center my-4">
        <input type="file" name="ppt_userphoto" tabindex="12" />
      </div>
      <?php if(isset($currentimg['img'])){ ?>
      <div class="text-center">
        <button class="btn btn-sm btn-dark" type="button" onclick="delete_userphoto1();"><?php echo __("Delete","premiumpress"); ?></button>
      </div>
      <?php } ?>
    </div>
    <div class="col-md-6">
      <h6 class="title-dark"><?php echo __("My Avatar","premiumpress"); ?></h6>
      <div class="row">
        <?php

$CA = "";
if(isset($_GET['eid'])){
$CA = get_user_meta($_GET['eid'],'myavatar',true);
}


foreach($user_avatars as $k => $h){?>
        <div class="col-md-3 text-center px-0">
          <figure> <img src="<?php echo get_template_directory_uri(); ?>/framework/images/avatar/<?php echo $k; ?>.png" alt="img" class="img-fluid"> </figure>
          <input type="radio"  value="<?php echo $k; ?>" name="myavatar" <?php if( $CA == "" && $k == "m1" ||  $CA == $k){ echo "checked=checked"; } ?> >
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</div>
<script>
function delete_userphoto1(){
 										   
 	
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "delete_userphoto",
			<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ ?>
			uid: "<?php echo esc_attr($_GET['eid']); ?>",
			<?php } ?>
			 		
        },
        success: function(response) {
 
			if(response.status == "ok"){
			
			jQuery('#photopreview').html('');
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
        </div>
      </div>
      <div class="p-4 bg-light text-center mt-4">
        <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
      </div>
    </div>
  </div>
  <div class="col-md-4">
  
  
  <?php if( in_array(THEME_KEY, array("es","jb","mj","ll"))){ 
	
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
  
     <article class=" card mb-4">
      <header class="card-header"> <a href="#" data-toggle="collapse" data-target="#collapse_1" class="text-dark"> <i class="icon-control fa fa-chevron-down float-right"></i>
        <h6 class="title mb-0"><?php echo __("Account Type","premiumpress"); ?> </h6>
        </a> </header>
      <div class="filter-content collapse show " id="collapse_1">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <label><?php echo __("User Type","premiumpress"); ?></label>
              <select name="user_type" class="form-control mt-2">
              
               <?php foreach($accountTypes as $k => $g){ 
			   
			   if( in_array(_ppt(array("usertype",$k)), array("","1")) ){ }else{ continue; }
			   
			   ?>             
             <option value="<?php echo $k ?>" <?php if(isset($_GET['eid']) && get_user_meta($_GET['eid'],'user_type',true) == $k){ echo "selected='selected'"; } ?>><?php if(isset($g['name'])){ echo $g['name']; }else{ echo $g; } ?></option>
             <?php } ?>  
              
               
              </select> 
              
              
              <?php if(THEME_KEY == "pj" && isset($_GET['eid']) && get_user_meta($_GET['eid'],'user_type',true) == "user_fr" ){ $rate = get_user_meta($_GET['eid'],'ppt_hourlyrate',true); if($rate == ""){ $rate = 0; } ?>
               <label class="mt-4"><?php echo __("Hourly Rate","premiumpress"); ?></label>  
    
    <div class="input-group mb-3 mt-2">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><?php echo _ppt(array('currency','symbol')); ?></span> </div>
            <input type="text" name="ppt_hourlyrate" value="<?php echo $rate; ?>" class="form-control">
          </div>
          <?php } ?>
              
    </div>
 
          </div>
        </div>
      </div>
    </article>
    
  <?php } ?>
  
  
   
    <article class=" card mb-4">
      <header class="card-header"> <a href="#" data-toggle="collapse" data-target="#collapse_1" class="text-dark"> <i class="icon-control fa fa-chevron-down float-right"></i>
        <h6 class="title mb-0"><?php echo __("Verify Account","premiumpress"); ?> </h6>
        </a> </header>
      <div class="filter-content collapse show " id="collapse_1">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <label><?php echo __("Account Verified","premiumpress"); ?></label>
              <select name="verified" class="form-control mt-2">
                <option value="0"><?php echo __("No","premiumpress"); ?></option>
                <option value="1" <?php if(isset($_GET['eid']) && get_user_meta($_GET['eid'],'ppt_verified',true) == 1){ echo "selected='selected'"; } ?>><?php echo __("Yes","premiumpress"); ?></option>
              </select>
              
              <?php if(isset($_GET['eid']) && get_user_meta($_GET['eid'],'ppt_verified',true) != 1){ ?>
              <div class="mt-2">
              <a href="javascript:void(0);" onclick="resendVemail();" class="small"><i class="fal fa-envelope"></i> <?php echo __("resend verify email","premiumpress"); ?></a>
              </div>
<script>
function resendVemail(){

	jQuery.ajax({
            type: "POST",
			dataType: 'json',	
            url: '<?php echo home_url(); ?>/',		
         	data: {
                    action: "resendvemail",
         			uid: <?php echo esc_attr($_GET['eid']); ?>, 
              },
              success: function(response) {
         		   
				 
         			if(response.status == "sent"){ 
         			 
					alert("<?php echo __("Email Sent!","premiumpress"); ?>");
					}	
					
							
              },
              error: function(e) {
                     alert("error "+e)
               }
	});
			 
}
</script>
              
              <?php } ?>
            </div>
 
          </div>
        </div>
      </div>
    </article>
    
    
    
	 
   
    <article class=" card mb-4">
      <header class="card-header"> <a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="text-dark"> <i class="icon-control fa fa-chevron-down float-right"></i>
        <h6 class="title mb-0"><?php echo __("User Credit","premiumpress"); ?></h6>
        </a> </header>
      <div class="filter-content collapse show" id="collapse_2">
        <div class="card-body ">
          <label><?php echo __("Account Balance","premiumpress"); ?></label>
          <div class="input-group mb-3 mt-2">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><?php echo _ppt(array('currency','symbol')); ?></span> </div>
            <input type="text" name="ppt_usercredit" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'ppt_usercredit',true); } ?>" class="form-control"  />
          </div>
          <div class="p-3 bg-light text-muted small"><?php echo __("Here you can set an amount in monies that will be credited to the users account. If the value is negative, the users account will show payment options for them to pay.","premiumpress"); ?></div>
        </div>
      </div>
    </article>
    
    
    
    
    
   
    
    
    
    <?php if( $CORE->LAYOUT("captions","memberships") && _ppt(array('mem','enable')) == 1 ){ ?>
    
    
    <article class=" card mb-4">
      <header class="card-header"> <a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="text-dark"> <i class="icon-control fa fa-chevron-down float-right"></i>
        <h6 class="title mb-0"><?php echo __("Membership Access","premiumpress"); ?></h6>
        </a> </header>
      <div class="filter-content collapse show" id="collapse_3" >
        <div class="card-body ">
          <?php 	 
	
	 
	
	// GET MEMBERSHIPS
	$all_memberships = $CORE->USER("get_memberships", array());
	
	 // 
	$value = array();
	if(isset($_GET['eid'])){
	
		$value = $CORE->USER("get_user_membership", $_GET['eid']);
		 		   
		if(!is_array($value)){ $value = array(); }
	 
	}
	?>
          <select name="membership" class="form-control">
          <option value=""><?php echo __("No Membership","premiumpress"); ?>
            <?php foreach($all_memberships  as $key => $m){  ?>
            <option value="mem<?php echo $m['key']; ?>" <?php if(isset($value['key']) && ( ($m['key'] == $value['key']) || ("mem".$m['key'] == $value['key']) ) ){  echo "selected=selected"; } ?>><?php echo $m['name']; ?></option>
            <?php } ?>
          </select>
          
              <label class="mt-2 small"><?php echo __("Membership Status","premiumpress"); ?></label>
          <div class="input-group mb-1">
             <select name="user_approved" class="form-control">
          <option value="1"><?php echo __("Approved","premiumpress"); ?></option>
             <option value="0" <?php if($value['user_approved'] == "0"){ echo 'selected=selected'; } ?>><?php echo __("Pending Approval","premiumpress"); ?></option>
        
          </select>
           </div>
          
          <label class="mt-2 small"><?php echo str_replace("%s", $CORE->LAYOUT("captions","1"),__("Free %s Credit","premiumpress")); ?></label>
          <div class="input-group mb-1">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1">#</span> </div>
            <input type="text" name="ppt_freelistings"  value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'free_listings_count',true); }else{ echo 0; } ?>" class="form-control"  />
          </div>
          
          
              <label class="mt-2 small"><?php echo str_replace("%s", $CORE->LAYOUT("captions","1"),__("Max %s Credit","premiumpress")); ?></label>
          <div class="input-group mb-1">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1">#</span> </div>
            <input type="text" name="ppt_freelistings_max"  value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'free_listings_max_count',true); }else{ echo 10; } ?>" class="form-control"  />
          </div>
          
          
              <label class="mt-2 small"><?php echo str_replace("%s", $CORE->LAYOUT("captions","1"),__("Max Send Messages","premiumpress")); ?></label>
          <div class="input-group mb-1">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1">#</span> </div>
            <input type="text" name="max_msg"  value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'max_msg_count',true); }else{ echo 100; } ?>" class="form-control"  />
          </div>
          
          <?php if(	THEME_KEY == "so"){ ?>
           <label class="mt-2 small"><?php echo __("Free downloads remaining","premiumpress"); ?></label>
          <div class="input-group mb-1">
            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1">#</span> </div>
            <input type="text" name="ppt_userdownloads" value="<?php if(isset($_GET['eid'])){ echo get_user_meta($_GET['eid'],'free_downloads_count',true); }else{ echo 0; } ?>" class="form-control"  />
          </div>
          <?php } ?>
         
          <?php if(is_array($value) && !empty($value) ){ ?>
          
          <div class="my-2 small"><?php echo __("Expires on","premiumpress") ?></div>
          
           <input type="text" name="membership_expires" id="mem_expires"  value="<?php echo $value['date_expires']; ?>" class="form-control"  />
          
          <a href="javascript:void(0);" class="small" onclick="jQuery('#mem_expires').val('<?php echo date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . "+1 minute")); ?>');">Time Now + 1 minute</a>
          
          <div class="bg-light small p-2 mt-3"><i class="fal fa-clock"></i> <?php echo do_shortcode('[TIMELEFT postid="'.$_GET['eid'].'" layout="1" text_before="" text_ended="Not Set" key="membership"]'); ?></div>
          
          
         
          <?php } ?>
          <?php
	 
	?>
        </div>
      </div>
    </article>
    <?php } ?>
    <?php if( $CORE->LAYOUT("captions","cashout") || _ppt(array('user','cashout')) == "1"  ){ ?>
    <article class=" card">
    <header class="card-header"> <a href="#" data-toggle="collapse" data-target="#collapse_55" aria-expanded="true" class="text-dark"> <i class="icon-control fa fa-chevron-down float-right"></i>
      <h6 class="title mb-0"><?php echo __("Payment Preferences","premiumpress") ?></h6>
      </a> </header>
    <div class="filter-content collapse show" id="collapse_55" >
      <div class="card-body ">
        <div class="">
          <div class="row">
            <div class="col-md-12">
              <label><?php echo __("My Payment Preference","premiumpress");  ?></label>
              <select class="form-control" onchange="SwitchPP(this.value)" name="payment_type">
                
                <?php if(in_array(_ppt("cashoutopt_paypal"), array("","1"))){ ?>
                <option value="paypal" <?php if(isset($_GET['eid']) && get_user_meta($_GET['eid'],'payment_type',true) == "paypal"){ ?>selected=selected<?php } ?>><?php echo __("PayPal","premiumpress"); ?></option>
                <?php } ?>
                
                <?php if(in_array(_ppt("cashoutopt_bank"), array("","1"))){ ?>
                <option value="bank" <?php if(isset($_GET['eid']) &&  get_user_meta($_GET['eid'],'payment_type',true) == "bank"){ ?>selected=selected<?php } ?>><?php echo __("Bank","premiumpress"); ?></option>
               <?php } ?>
               
               <?php if(in_array(_ppt("cashoutopt_person"), array("","1"))){ ?>
                <option value="person" <?php if(isset($_GET['eid']) &&  get_user_meta($_GET['eid'],'payment_type',true) == "person"){ ?>selected=selected<?php } ?>><?php echo __("In Person/On Collection","premiumpress"); ?></option>
                <?php } ?>
                
              </select>
            </div>
            <div class="col-md-12  mt-4">
              <div class="form-group payment_paypal">
                <label class="control-label"> <?php echo __("PayPal Email","premiumpress"); ?></label>
                <div class="controls">
                  <input type="text" name="paypal" class="form-control" style="width:100%;" value="<?php if(isset($_GET['eid']) ){ echo get_user_meta($_GET['eid'],'paypal',true); } ?>" tabindex="4">
                </div>
              </div>
              <div class="form-group payment_bank">
                <label class="control-label"> <?php echo __("My Bank Details","premiumpress"); ?></label>
                <div class="controls">
                  <textarea class="form-control" style="height:100px !important; width:100%;" name="bank"><?php if(isset($_GET['eid']) ){  echo stripslashes(get_user_meta($_GET['eid'],'bank',true)); } ?>
</textarea>
                </div>
              </div>
              <div class="form-group payment_person">
                <label class="control-label"> <?php echo __("Address for collection","premiumpress"); ?></label>
                <div class="controls">
                  <textarea class="form-control" style="height:100px !important; width:100%;" name="payaddresss"><?php if(isset($_GET['eid']) ){  echo stripslashes(get_user_meta($_GET['eid'],'payaddresss',true)); } ?>
</textarea>
                </div>
              </div>
            </div>
          </div>
          <script>
			
			
               function SwitchPP(g){
			   
				   if(g == "paypal"){
				   
				    jQuery('.payment_paypal').show();
               		jQuery('.payment_bank').hide();
				    jQuery('.payment_person').hide();
					jQuery('.payment_stripe').hide();
				   
				   }else if(g == "bank"){
				   
				    jQuery('.payment_paypal').hide();
               		jQuery('.payment_bank').show();
				    jQuery('.payment_person').hide();
					jQuery('.payment_stripe').hide();
				   }else if(g == "person"){
				   
				    jQuery('.payment_paypal').hide();
               		jQuery('.payment_bank').hide();
					jQuery('.payment_person').show();					
					jQuery('.payment_stripe').hide();
				
					}else if(g == "stripe"){
					
				    jQuery('.payment_paypal').hide();
               		jQuery('.payment_bank').hide();
					jQuery('.payment_person').hide();					
					jQuery('.payment_stripe').show();
											
				   }else{
				   
				    jQuery('.payment_paypal').show();
               		jQuery('.payment_bank').hide();
					jQuery('.payment_person').hide();					
					jQuery('.payment_stripe').hide();
				   
				   }
              
               }
			   
			       jQuery(document).ready(function(){ 
				   <?php if(isset($_GET['eid']) && get_user_meta($_GET['eid'],'payment_type',true) != ""){ ?>
				   
				   SwitchPP('<?php echo get_user_meta($_GET['eid'],'payment_type',true); ?>');
				   
				   
				   <?php }else{ ?>
				   jQuery('.payment_paypal').show();
               		jQuery('.payment_bank').hide();
					jQuery('.payment_person').hide();					
					jQuery('.payment_stripe').hide();
				   <?php } ?>
				   });
			   
            </script>
        </div>
      </div>
      </article>
      <?php } ?>
    </div>
  </div>
</form>