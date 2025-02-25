<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;


// COUPON CODE SETTINGS
if(current_user_can('administrator') && isset($_POST['edituserid']) && is_numeric($_POST['edituserid'])){


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

 

_ppt_template('framework/admin/header' ); 

?>


<div class="tab-content">


        <div class="tab-pane active addjumplink" 
        data-title="Users" 
        data-icon="fa-users" 
        id="users" 
        role="tabpanel" aria-labelledby="users-tab">    
    
    	<?php _ppt_template('framework/admin/parts/users-table' ); ?> 

        </div>  
        
        
        <div class="tab-pane addjumplink" 
        data-title="Add Member" 
        data-icon="fa-users-medical" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">

		<?php
		 _ppt_template('framework/admin/parts/users-add' );
		  ?>

        </div>
             
</div><!-- end tabs -->


<script>


 
jQuery(document).ready(function(){
 
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

</script>

<?php  _ppt_template('framework/admin/footer' );  ?>