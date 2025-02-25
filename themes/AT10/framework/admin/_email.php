<?php

global $wpdb, $CORE;


_ppt_template('framework/admin/header' ); 

// REMOVE REGISTRATION FIELD
if( current_user_can('administrator') ){
 

// COUPON CODE SETTINGS
if(isset($_POST['newsub']) && is_numeric($_POST['newsub'])){
 
		// ADD SYSTEM TRANSACTION				
		$my_post = array();				
		$my_post['post_title'] 		= $_POST['news_email']; 
		$my_post['post_type'] 		= "ppt_newsletter"; 
		$my_post['post_status'] 	= "publish";
		$my_post['post_content'] 	= ""; 
		
		// UPDATE
		if($_POST['newsub'] == 1){
		
			$payment_id = wp_insert_post( $my_post );
 		
		}else{
		
			$my_post['ID'] 	= $_POST['newsub'];
			$payment_id 	= $_POST['newsub'];
			wp_update_post( $my_post );
 	
		} 

	 	update_post_meta($payment_id, "news_email", $_POST['news_email']);
		update_post_meta($payment_id, "news_verified", $_POST['news_verified']);
		
		
		// LEAVE MESSAGE
		$GLOBALS['ppt_error'] = array(
			"type" 		=> "success",
			"title" 	=> __("New Subscriber Added","premiumpress"),
			"message"	=> __("Your subscriber list has been updated","premiumpress"),
		);
 

}
 
 
if(isset($_POST['action'])){
 
	switch($_POST['action']){
	
	
		case "sendnewsletter": {
		  
		 
		if(strlen($_POST['subject']) > 2){
		 
		   // ORDERS
			$args = array(
				'post_type' 		=> 'ppt_newsletter',
				'posts_per_page' 	=> 500,
				'paged' 			=> 1,
				
					'meta_query' => array( 
						'user_id'    => array(
							'key' 			=> 'news_email',	
							'value' 		=> "",
							'compare' 		=> '!=',								 					 			
						),	
						
						'verified'    => array(
							'key' 			=> 'news_verified',	
							'value' 		=> "yes",
							'compare' 		=> '=',								 					 			
						),				 	
					), 
				 
					
			  );
			  
			  
			  $wp_query1 = new WP_Query($args);    
			  $emails = $wpdb->get_results($wp_query1->request, OBJECT);
			  
			  if(!empty($emails) ){ 
			
				foreach ( $emails as $e ) {				
				
					$thisemail = get_post_meta($e->ID, "news_email", true);
					
					if(strlen($thisemail) > 1){
					 
					 	// SUBJECT
						$subject = $_POST['subject'];
						
						// UNSUBSCRIBE
						$unsubscriptlink = get_home_url()."/confirm/unsubscribe/".$thisemail;
						$message = str_replace("(unsubscribe)",$unsubscriptlink,$_POST['newsletter_message']);
						
						
						// FILTER
						$huser = get_user_by( 'email', $thisemail );
						if(isset($huser->data->ID)){
							$message = $CORE->email_message_filter($message, array("user_id" => $huser->data->ID));
							$subject = $CORE->email_message_filter($subject, array("user_id" => $huser->data->ID));
						}else{
							$message = $CORE->email_message_filter($message, array());
							$subject = $CORE->email_message_filter($subject, array());
						}
		
						// SEND
						$CORE->email_send($thisemail, $subject, $message);
					
						// ADD LOG
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "newsletter",									
								"email" 	=> $thisemail,
								"data" 		=> $subject."/n/n/n".$message,							  					 
							)
						);
					 
					}
				}
			}			 
		}
		
			// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
				"type" 		=> "success",
				"title" 	=> "Newsletter Sent",
				"message"	=> "Your newsletter has been sent successfully..",
			);
		
		 
		} break;
 
	
	case "newemail": {
			 
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$ppt_emails = get_option("ppt_emails");
		if(!is_array($ppt_emails)){ $ppt_emails = array(); }
		
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
				array_push($ppt_emails, $_POST['ppt_email']);		
				$GLOBALS['error_message'] = "Email Created Successfully";
		}else{
				$ppt_emails[$_POST['eid']] = $_POST['ppt_email'];		
				$GLOBALS['error_message'] = "Email Updated Successfully";
		}
		
		// SAVE ARRAY DATA		 
		update_option( "ppt_emails", $ppt_emails); 
		 
	
	} break;	
	
	case "send-new-email": {
	  	
		 
		if($_POST['senttogo'] == 1){
		
			// EMAILS
			$mailinglist = $wpdb->get_results("SELECT user_email AS email, ID AS uid FROM ".$wpdb->users.""); 
 
			if ( $mailinglist ) {
				foreach ( $mailinglist as $data ) {				 
					// VALIDATE
					if(strlen($data->email) > 5){	
						
						// CLEAN UP
						$subject = $_POST['subject'];
						$message = $_POST['message']; 	
					
						// FILTER
						$message = $CORE->email_message_filter($message, array("user_id" => $data->uid));
						$subject = $CORE->email_message_filter($subject, array("user_id" => $data->uid));					 
									
						// SEND EMAIL
						$CORE->email_send($data->email, $subject, $message);
						
						// ADD LOG
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "email_admin",									
								"email" 	=> $data->email,
							  	"data" 		=> $subject."/n/n/n".$message,	
								"userid" 	=> $data->uid,			 
							)
						);
						 
						
										
					}// end if	
				}
			}
			
		}elseif($_POST['senttogo'] == 2){
			
			// TO EMAILS
			$to_emails = trim($_POST['to_emails']);
			$emails = explode(",",$to_emails);
						
			// EMAILS
			foreach($emails as $email){				
				// VALIDATE
				if(strlen($email) > 5){					
				
					// CLEAN UP
					$subject = $_POST['subject'];
					$message = $_POST['message'];
					
					 
					 // FILTER
					$huser = get_user_by( 'email', $email );
					if(isset($huser->data->ID)){
						$message = $CORE->email_message_filter($message, array("user_id" => $huser->data->ID));
						$subject = $CORE->email_message_filter($subject, array("user_id" => $huser->data->ID));
					}else{
						$message = $CORE->email_message_filter($message, array());
						$subject = $CORE->email_message_filter($subject, array());
					}
								
					// SEND EMAIL
					$CORE->email_send($email, $subject, $message);	
					
					// ADD LOG
					$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "email_admin",
							  	"data" 		=> $subject."/n/n/n".$message,	
								"email" 	=> $email,	
								"userid" 	=> $data->uid,		 
							)
					);
					
								
				}// end if						
			}// foreach	
		
		}	
	
		 
		// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
				"type" 		=> "success",
				"title" 	=> "Email Sent",
				"message"	=> "Your email has been sent successfully.",
			);
	
	} break;
	
	case "testemail": {
 
		$CORE->email_send($_POST['test_email_data']['toemail'],$_POST['test_email_data']['subject'], $_POST['test_email_data']['message']);
			
		 
		$GLOBALS['error_message'] = "Email sent.";
		
	} break;
	
	case "sendemail": {
	if(strlen($_POST['subject']) > 2){
		$mailinglist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_mailinglist WHERE email_confirmed=1"); 
		if ( $mailinglist ) {
			foreach ( $mailinglist as $maild ) {
				if(strlen($maild->email) > 1){
				$CORE->email_send($maild->email,$_POST['subject'],$_POST['message']);
				}
			}
		}
			
	
		
		$GLOBALS['error_message'] = "Email sent.1";
	}
	} break;
	
	
	 	case "importemails": {
 		 
			$emails = explode(PHP_EOL,$_POST['import_emails']);
		  
			if(is_array($emails)){
				foreach($emails as $email){			 
				 $bits = explode("[",$email);
				  
				 $fname = ""; 
				 $lname = "";
				 
				 if(isset($bits[1]) && strpos($bits[1], "]") !== false){
					$ib = explode(" ",$bits[1]);
					$fname = str_replace("]","",$ib[0]); 
					$lname = str_replace("]","",$ib[1]);
				 }		
				 	 
				// ADD DATABASE ENTRY
				if(strlen($bits[0]) > 2){
				 	
					// MAKE HAS FOR THIS USER
					$hash = md5($bits[0].rand());
					
					$data = array(						
						"email" => strip_tags($bits[0]),
						"hash" => $hash,
						"verified" => "yes",
					);
					
					$uid = $CORE->EMAIL("newsletter_add", $data);
				 
					
					 	 
					 // LEAVE MESSAGE
					$GLOBALS['ppt_error'] = array(
						"type" 		=> "success",
						"title" 	=> "New Subscribers Added",
						"message"	=> "Your new subscribers have been added.",
					);
		
				
				}
					
				} // end foreach
			}// end if
			
			$GLOBALS['error_message'] = "Mailing List Updated";
		
		} break;
	

} 
 


}
}

?> 
<div class="tab-content">

        <div class="tab-pane active addjumplink" 
        data-title="<?php echo __("Overview","premiumpress"); ?>" 
        data-icon="fa-envelope" 
        id="overview" 
        role="tabpanel" aria-labelledby="overview-tab">
        
        <?php _ppt_template('framework/admin/parts/email-overview' ); ?>
       
           
        </div><!-- end design home tab -->
        
        <div class="tab-pane addjumplink" 
         
        
        data-title="<?php echo __("System Emails","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup the default website emails.","premiumpress"); ?>"
       
        
        data-icon="fal fa-mail-bulk" 
        id="manage" 
        role="tabpanel" aria-labelledby="manage-tab">
        <?php _ppt_template('framework/admin/_form-top' );  ?>
        <?php _ppt_template('framework/admin/parts/email-manage' ); ?>
         <?php _ppt_template('framework/admin/_form-bottom' );  ?>
           
        </div><!-- end design home tab -->
        
        
        <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("Email Settings","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can configure the default email settings.","premiumpress"); ?>"
       
        data-icon="fa-cog" 
        id="settings" 
        role="tabpanel" aria-labelledby="settings-tab">
        <?php _ppt_template('framework/admin/_form-top' );  ?>
        <?php _ppt_template('framework/admin/parts/email-settings' ); ?>
         <?php _ppt_template('framework/admin/_form-bottom' );  ?>           
        </div><!-- end design home tab -->     
        

        
        <div class="tab-pane addjumplink" 
       
         data-title="<?php echo __("Send Email","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can send a quick email to a single user or your entire community.","premiumpress"); ?>"
       
        
        data-icon="fa-envelope" 
        id="sendemail" 
        role="tabpanel" aria-labelledby="sendemail-tab">
        
        <?php _ppt_template('framework/admin/parts/email-send' ); ?>
        
           
        </div><!-- end design home tab -->
        
        <?php if( _ppt(array('newsletter','newsdefault')) != "0" ){  ?>
        <div class="tab-pane addjumplink"        
         data-title="<?php echo __("Subscribers","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can manage your newsletter subscriber list.","premiumpress"); ?>"        
        data-icon="fa-users" 
        id="subscribers" 
        role="tabpanel" aria-labelledby="subscribers-tab">        
        <?php _ppt_template('framework/admin/parts/newsletter-table' ); ?>          
        </div><!-- end design home tab --> 
        <?php } ?>
        
        <?php if( _ppt(array('newsletter','newsdefault')) != "0" ){  ?>
        <div class="tab-pane addjumplink"          
        data-title="<?php echo __("Send Newsletter","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can send a newsletter to your subscribers.","premiumpress"); ?>"        
        data-icon="fa-envelope-open" 
        id="shortcodes" 
        role="tabpanel" aria-labelledby="shortcodes-tab">
        <?php _ppt_template('framework/admin/parts/newsletter-send' ); ?>          
        </div><!-- end design home tab -->
        <?php } ?>
        
        <?php if( _ppt(array('newsletter','newsdefault')) != "0" ){  ?>
        <div class="tab-pane addjumplink"         
        data-title="<?php echo __("Add Subscriber","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can add a new subscriber to your newsletter list.","premiumpress"); ?>"        
        data-icon="fa-user" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">		             
        <?php  _ppt_template('framework/admin/parts/newsletter-add' ); ?>
        </div>
        <?php } ?>
        
        <div class="tab-pane addjumplink"         
         data-title="<?php echo __("Newsletter Settings","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can manage your newsletter settings.","premiumpress"); ?>"        
        data-icon="fa-layer-plus" 
        id="newsletters" 
        role="tabpanel" aria-labelledby="newsletters-tab">		             
               
               <?php _ppt_template('framework/admin/_form-top' );  ?>
         <?php  _ppt_template('framework/admin/parts/newsletter-settings' ); ?>  
         <?php _ppt_template('framework/admin/_form-bottom' );  ?>              
                      
        </div>
        
   
        
  		<?php if( _ppt(array('newsletter','newsdefault')) != "0" ){  ?>
        <div class="tab-pane addjumplink"        
         data-title="<?php echo __("Subscriber Import","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can bulk import new users to your subscriber list.","premiumpress"); ?>"        
        data-icon="fa-mail-bulk" 
        id="newsimport" 
        role="tabpanel" aria-labelledby="newsimport-tab">        
        <?php _ppt_template('framework/admin/parts/newsletter-import' ); ?>          
        </div><!-- end design home tab -->    
        <?php } ?>
        
         

</div>


<?php

_ppt_template('framework/admin/footer' ); 

?>