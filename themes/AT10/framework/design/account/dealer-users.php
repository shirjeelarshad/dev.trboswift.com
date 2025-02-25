<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;


// COUPON CODE SETTINGS
if((current_user_can('administrator') || current_user_can('dealer')) && isset($_POST['edituserid']) && is_numeric($_POST['edituserid'])){


		$user_id = $_POST['edituserid'];
		
		 
		// ADD		
		$data = array();				
		$data['first_name'] 		= strip_tags($_POST['first_name']);
		$data['last_name'] 			= strip_tags($_POST['last_name']);
		$data['description'] 		= strip_tags($_POST['description']);
		
		if(isset($_POST['user_login'])){
		$data['user_login'] 		= strip_tags($_POST['user_login']); 
		}
		
		if($user_id == 0){
		 	
			if($_POST['password'] == ""){
			$_POST['password'] = "password";
			}
			$user_id = wp_create_user( $_POST['user_login'], $_POST['password'], $_POST['email'] );
			
			if( is_wp_error( $user_id ) ) {
			
				die("<h1>".$user_id->get_error_message()."</h1>");
			
			}
			 		
			 
		}
		
		$data['ID'] 				= $user_id;		
		$data['user_email'] 		= strip_tags($_POST['email']); 
	 	
			// PASSWORD
			if( ( $_POST['password'] == $_POST['password_r'] ) && $_POST['password'] != ""){					
				 
					$data['user_pass'] 		= $_POST['password'];
					 
					// ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "user_password",	
							"userid"	=> $user_id,			 
						)
					);
			}			
		$g = wp_update_user( $data ); 
		
		// CHECK FOR USERNAME CHANGE
		if(isset($_POST['usernamechange']) && $_POST['usernamechange'] == 1){
		 
			$wpdb->query("UPDATE ".$wpdb->prefix."users SET user_login = '".trim(strip_tags($_POST['user_login']))."' WHERE ID = (".$user_id.") LIMIT 1"); 
 		}
		
		if(isset($_POST['user_type'])){
		
			update_user_meta( $user_id, 'user_type',$_POST['user_type']);	
		
		}
		
		
		update_user_meta( $user_id, 'ppt_verified',$_POST['verified']);		
		//update_user_meta( $user_id, 'ppt_powerseller',$_POST['powerseller']);	
		update_user_meta( $user_id, 'ppt_customtext',$_POST['customtext']);
		update_user_meta( $user_id, 'ppt_usercredit',$_POST['ppt_usercredit']);
		  
		update_user_meta( $user_id, 'mobile-prefix',$_POST['mobile-prefix']);
		update_user_meta( $user_id, 'mobile',$_POST['mobile']);		
		
		if(isset($_POST['ppt_userdownloads'])){
		update_user_meta( $user_id, 'free_downloads_count',$_POST['ppt_userdownloads']); 		 	
		}
		
		if(isset($_POST['ppt_freelistings'])){
		update_user_meta( $user_id, 'free_listings_count',$_POST['ppt_freelistings']); 
		}
		
		if(isset($_POST['ppt_freelistings_max'])){
		update_user_meta( $user_id, 'free_listings_max_count',$_POST['ppt_freelistings_max']); 
		}
		
		if(isset($_POST['max_msg'])){
		update_user_meta( $user_id, 'max_msg_count',$_POST['max_msg']); 
		}
		
			// LANGUAGE
		if(isset($_POST['language'])){
		update_user_meta($user_id, 'language', strip_tags($_POST['language']));
		}
		
		// CHECK EMAIL IS VALID			
		update_user_meta($user_id, 'url', strip_tags($_POST['url']));
		update_user_meta($user_id, 'phone', strip_tags($_POST['phone']));
		
		// ADDRESS
		update_user_meta($user_id, 'address1', strip_tags($_POST['address1']));
		update_user_meta($user_id, 'address2', strip_tags($_POST['address2']));
		update_user_meta($user_id, 'country', strip_tags($_POST['country']));
		update_user_meta($user_id, 'city', strip_tags($_POST['city']));	
		update_user_meta($user_id, 'town', strip_tags($_POST['town']));	
		update_user_meta($user_id, 'zip', strip_tags($_POST['zip']));
		
		// PAYPAL
		if( $CORE->LAYOUT("captions","cashout") || _ppt(array('user','cashout')) == "1" ){
		update_user_meta($user_id, 'payment_type', strip_tags($_POST['payment_type']) );
		update_user_meta($user_id, 'paypal', strip_tags($_POST['paypal']) );
		update_user_meta($user_id, 'bank', strip_tags($_POST['bank']) );
		update_user_meta($user_id, 'payaddresss', strip_tags($_POST['payaddresss']) );
		}		
			
		// SOCIAL
		update_user_meta($user_id, 'facebook', strip_tags($_POST['facebook']));
		update_user_meta($user_id, 'twitter', strip_tags($_POST['twitter']));
		update_user_meta($user_id, 'linkedin', strip_tags($_POST['linkedin']));
		update_user_meta($user_id, 'skype', strip_tags($_POST['skype']));
		
	 	
		
		// AVATAR
		update_user_meta($user_id, 'myavatar', strip_tags($_POST['myavatar']) );
			
		// USER PHOTO		 
		if(isset($_FILES['ppt_userphoto']) && strlen($_FILES['ppt_userphoto']['name']) > 2 && in_array($_FILES['ppt_userphoto']['type'],$CORE->allowed_image_types) ){
				 
				// INCLUDE UPLOAD SCRIPTS
				if(!function_exists('wp_handle_upload')){
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				require $dir_path . "/wp-admin/includes/file.php";
				}
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['ppt_userphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['ppt_userphoto']['type'],
					'tmp_name'	=> $_FILES['ppt_userphoto']['tmp_name'],
					'error'		=> $_FILES['ppt_userphoto']['error'],
					'size'		=> $_FILES['ppt_userphoto']['size'],
				);
				//die(print_r($file_array));
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));
	 	
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
			 	 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($user_id, "userphoto", array('img' => $uploads['url']."/".$file_array['name'], 'path' => $uploads['path']."/".$file_array['name'] ) );
				
				}
			}


	 
	
	// SAVE USER MEMBERSHIP DATA
	if(isset($_POST['membership'])){ 
	
	 	// SAVE THE SUBSCRIPTION TO THE USERS ACCOUNT
		$au = get_user_meta( $user_id, 'ppt_subscription', true );		  
		 
		if(is_array($au) && isset($au['date_expires'])){
		
		}else{ 
			
			$sd = $CORE->USER("get_this_membership", $_POST['membership']);	
			
			if(isset($sd['duration'])){
			  		 
				$au = array(
					"date_start" => date("Y-m-d H:i:s"), 
					"date_expires" => date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " + ".$sd['duration']." days")),
				);			
			}
			
			 
			
			
		
		}
		
		// DATE EXPIRES
		$expires = "";
		if(isset($_POST['membership_expires'])){		
			$expires = $_POST['membership_expires'];
		}elseif(isset($au['date_expires'])){
			$expires = $au['date_expires'];
		}
		
		
		
		 
		
		if($expires != ""){		
			
		
			update_user_meta( $user_id ,'ppt_subscription', 
					array(
						"key" 			=> $_POST['membership'] , 
						"date_start" 	=> $au['date_start'], 
						"date_expires" 	=> $expires,	
						"approved" 		=>  $_POST['user_approved'],				 
					)
			);
			
					
		
		}
		
		 
	
 	}
	
	// CUSTOM FIELDS
	if(isset($_POST['custom']) && is_array($_POST['custom']) && !empty($_POST['custom']) ){
	
		foreach($_POST['custom'] as $kk => $vv){
			 update_user_meta( $user_id, $kk, $vv);			  
		}
	}
	
	// CART DELIVERY DATA
	 if(defined('WLT_CART') && isset($_POST['delivery']) && is_array($_POST['delivery']) ){
		 foreach($_POST['delivery'] as $kk => $vv){
		 update_user_meta( $user_id, $kk, $vv);
		 }     
     }







}

 

?>


<div class="tab-content">


        <div class="tab-pane active addjumplink allUsers" 
        data-title="Users" 
        data-icon="fa-users" 
        id="users" 
        role="tabpanel" aria-labelledby="users-tab">    
    
    	<?php _ppt_template('framework/admin/parts/users-table' ); ?> 

        </div>  
        
        
        <div class="tab-pane addjumplink singleUserInfo" 
        data-title="Add Member" 
        data-icon="fa-users-medical" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">

		<?php // _ppt_template('framework/admin/parts/users-add' ); ?>

		<div id="userDetailsInformation">
		</div>

        </div>
             
</div><!-- end tabs -->


<script>

 
jQuery(document).ready(function(){

function viewUserProfile(userId){
	jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_user_details',
            eid: userId,
			form_type: 'finance',
			form_id: 337873,
        },
        success: function(response){
			console.log(response);
			jQuery('.tab-pane').removeClass('active');
			jQuery('.singleUserInfo').addClass('active');



			let insertData = '';
			insertData += '<div class="col-12 row p-0 m-0">';
			insertData += '<div class="col-md-3 col-12 p-0">';
			insertData += `<div class="card p-0 border-0">
			<div class="m-2" style="background-image:url(<?php echo home_url(); ?>/wp-content/uploads/2025/02/image.png); height:100px; border-radius:10px; position:relative;">
			${response.data.user.photo}
			</div>

			<div class="row mt-3 m-2 mx-0 justify-content-between">
			<strong class="font-12">${response.data.user.display_name || '#'}</strong>

			<span class="d-flex justify-content-center align-items-center" style="font-size:10px; background:#E9FAF7; padding:0px 8px; border-radius:4px;color:#1A9882; ">Trbo Swift Certified</span>
			</div>
			<hr/>

			<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">First Name</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.first_name  || '#'} </span>
			</div> 
			</div>


			<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Last Name</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.last_name || '#'}</span>
			</div>
			</div>
			<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Address</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.address || '#'}</span>
			</div>
			</div>

			<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Phone Number</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.phone ||'#'}</span>
			</div>
			</div>

			<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Email</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.email || '#'}</span>
			</div>
			</div>
			
			

			<div class="font-12 p-2 mb-1"><strong>Status</strong></div>

				<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Last Login Date</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.login_info.last_date || '#'}</span>
			</div>
			</div>

				<div class="row align-items-center col-12 mx-0 mb-1 p-2">
			<div class="inIcon mr-2">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/34532.svg" style="width:100%; height:100%; object-fit:contain" />
			</div>
			<div>
			<span style="font-size:8px; color:#9D9D9D">Join Date</span><br>
			<span style="font-size:10px; color:#222222">${response.data.user.join_date || '#'}</span>
			</div>
			</div>

			</div>`;

			insertData += '</div>'; //col3

			insertData += '</div>';



            jQuery('#userDetailsInformation').html(insertData);
        }
    });
}

	jQuery(document).on('click', '#viewUserProfile', function(e){
		e.preventDefault();
        var userId = jQuery(this).data('user-id');
        viewUserProfile(userId);
	});
 
 <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
 
  jQuery('#myTab li:nth-child(2) a').tab('show');
  
  <?php if(isset($_POST['first_name'])){ ?>
  		notify({
					type: "success", //alert | success | error | warning | info
					title: "<?php echo __("Success","premiumpress"); ?>",
					position: {
					 x: "right", //right | left | center
					 y: "top" //top | bottom | center
					},
					icon: '<i class="fal fa-check"></i>',
					message: "<?php echo __("User Updated successfully","premiumpress"); ?>"
				});
  <?php } ?>
 <?php } ?>


});







function ajax_load_media(id){

tb_show('', 'admin.php?page=add&eid='+id+'&action=edit&mediaonly&amp;TB_iframe=true');
return false;

}



function ajax_delete_user(id){

// RESET
jQuery('#ajax_response_msg').html("");	


jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            admin_action: "user_delete",
			uid: id,
        },
        success: function(response) {			
			if(response.status == "ok"){
					
				// HIDE ROW
				jQuery('#postid-'+id).hide();	
				
				// LEAVE MESSAGE				
				jQuery('#ajax_response_msg').html("User deleted successfully");	
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure

 
jQuery(document).ready(function() {
	jQuery('.card-footer').hide(); 
});


	function showfilersbar(){  
		
		jQuery('#filters-extra').toggle();
		jQuery('#filterssidebox').toggle();
	 
	}
	function showactionsbar(){  
		
		jQuery('#actionsbox').toggle();
	 
	}

</script>

<script>

jQuery(document).on('change', '#newusernamefield', function() { 
    console.log("Name : ", jQuery(this).val());
});


jQuery(document).ready(function($) {
    function isValidEmailAddress(email) {
        var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return pattern.test(email);
    }

    // Handle form submission on button click
    jQuery(document).on("click", "#createNewFinanceAccount", function(e) {
    e.preventDefault(); // Prevent default button behavior

        const createForm = $('#new_user_create_form');

        if(!createForm){
            console.error("Form not found");
            return false;
        }

        // Get form values separately
        let username = createForm.find("#newusernamefield").val().trim();
        let lastName = createForm.find("input[name='last_name']").val().trim();
        let address = createForm.find("input[name='address1']").val().trim();
        let phone = createForm.find("input[name='phone']").val().trim();
        let email = createForm.find("#user_email").val().trim();
        let confirmEmail = createForm.find("input[name='confirm_email']").val().trim();
        let password = createForm.find("input[name='password']").val();
        let confirmPassword = createForm.find("input[name='password_r']").val();
        let role = createForm.find("input[name='role']:checked").val() || ""; // Get checked role value

        // Form validation
        if (!username || username.length < 4) {
            console.log("Please enter", username);
            alert("Dealer name must be at least 4 characters.");
            return false;
        }

        if (!lastName) {
            alert("Contact Name is required.");
            return false;
        }

        if (!address) {
            alert("Address is required.");
            return false;
        }

        if (!phone) {
            alert("Phone Number is required.");
            return false;
        }

        if (!isValidEmailAddress(email)) {
            alert("Enter a valid email address.");
            return false;
        }

        if (email !== confirmEmail) {
            alert("Emails do not match.");
            return false;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        if (!role) {
            alert("Please select a role.");
            return false;
        }

        // Prepare data object
        let formData = {
            action: "create_new_user_ajax",
            user_login: username,
            last_name: lastName,
            address1: address,
            phone: phone,
            email: email,
            password: password,
            role: role
        };

        console.table(formData); // Debugging - check collected data

        // AJAX request
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,  // WordPress-defined global AJAX URL
            data: formData,
            success: function(response) {
				console.log("User creation: ",response);
                if (response.success) {
                    jQuery('.newUserAddModalBody').removeClass('d-flex').addClass('d-none');
                    _filter_update();
                    alert("New user created successfully!");
                } else {
                    alert("Error: " + response.data);
                }
            },
            error: function() {
                alert("Something went wrong. Please try again.");
            }
        });
    });
});




function newFinanceAccountModal(){

	jQuery('.newUserAddModalBody .newUserAddModalContainer').removeClass(
			'p-3 customModalWidthHalf')
		.addClass(
			'p-0 border-0 bg-white customModalWidthSmall');

var displayData = `
    <div class="px-1 px-md-4 py-4 text-center"><h5>Add User</h5> <br><small>All fields are required</small></div>


    <div id="new_user_create_form" class="px-4 text-left">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Dealership Name</label>
            <input type="text" id="newusernamefield" class="form-control" placeholder="Enter Dealership Name">
            <span id="ajaxMsgUser"></span>
        </div>
        <div class="form-group col-md-6">
            <label>Contact Name</label>
            <input type="text" name="last_name" class="form-control" placeholder="Enter First & Last Name">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="info-label">Address</label>
            <input type="text" name="address1" value="" class="form-control googleAutoLocation"
                 placeholder="Enter Address">
        </div>
        <div class="form-group col-md-6">
            <label class="info-label">Phone Number</label>
            <input type="text" name="phone" value="" class="form-control"
                 placeholder="Enter Phone Number">
        </div>
     </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Email</label>
            <input type="text" id="user_email" class="form-control required-field" name="email" placeholder="Enter Email">
        </div>
        <div class="form-group col-md-6">
            <label>Confirm Email</label>
            <input type="text" name="confirm_email" class="form-control" placeholder="Confirm Email">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password">
        </div>
        <div class="form-group col-md-6">
            <label>Confirm Password</label>
            <input type="password" name="password_r" class="form-control" placeholder="Confirm Password">
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 text-center">
            <strong>Select Role</strong><br>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="role" class="custom-control-input" value="Finance" checked>
                <span class="custom-control-label"></span> Dealership Finance
            </label>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 text-center">
            <button type="submit" id="createNewFinanceAccount" class="btn btn-secondary rounded-pill px-3 my-2" style="min-width:120px">Create</button>
        </div>
    </div>
</div>
`;



jQuery(".newUserAddModalBody .newUserAddModalContainer").html(displayData);
jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');

}

</script>



<script>


jQuery(document).on('change', '#newusernamefield', function() { 
    console.log("Field changed. Value:", jQuery(this).val());

    jQuery('#ajaxMsgUser').html('');

    let username = jQuery(this).val().trim();
    
    if(username.length > 6) {
        console.log("Validating username:", username);
        
        jQuery.ajax({
            type: "POST",
            url: '<?php echo home_url(); ?>/',  // Ensure this outputs the correct URL
            data: {
                action: "validateUsername",
                name: username  // Use `username` variable instead of selecting again
            },
            success: function(response) {
                console.log("AJAX Response:", response);

                if(response == "yes"){
                    jQuery('#ajaxMsgUser').html("<span class='badge badge-danger'><i class='fa fa-close'></i> <?php echo __('Username Taken', 'premiumpress'); ?></span>");
                } else {
                    jQuery('#ajaxMsgUser').html("<span class='badge badge-success'><i class='fa fa-check-circle'></i> <?php echo __('Valid Username', 'premiumpress'); ?></span>");
                    jQuery('#new_user_create_form').append('<input type="hidden" name="usernamechange" value="1">');    
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong. Please try again.");
            }
        });
    }
});


</script>


<style>

#userDetailsInformation .userphoto{
	width: 75px;
    height: 75px;
    border-radius: 100%;
    position: absolute;
    left: 50%;
    bottom: 0%;
    transform: translate(-50%, 35%);
}
#userDetailsInformation .inIcon{
	width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #f3f3f3f3;
    padding: 8px;
    display: flex
;
    justify-content: center;
    align-items: center;
}

</style>