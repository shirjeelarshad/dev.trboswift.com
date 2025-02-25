<?php

class framework_email extends framework_updates {

	function EMAIL($action='add', $order_data){
	
	global $userdata, $wpdb, $CORE;
	 
		switch($action){
			
	 		case "newsletter_unsubscribe": {
			
				// CHECK EXISTS
				$ores = $wpdb->get_results("SELECT post_id as uid FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'news_email' AND meta_value = ('".esc_sql($order_data['email'])."') LIMIT 1 ");
				 
				if(!empty($ores)){
					 
					wp_delete_post($ores[0]->uid, true);
				
				}
				
				return 0;
			
			} break;
			
			case "newsletter_confirm": {
			
				// CHECK EXISTS
				$ores = $wpdb->get_results("SELECT post_id as uid FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'news_hash' AND meta_value = ('".esc_sql($order_data['hash'])."') LIMIT 1 ");
				 
				if(!empty($ores)){
												
					update_post_meta($ores[0]->uid, "news_verified", "yes");
				
				}
				
				return 0;			
			
			} break;
			
			case "newsletter_add": {
			
				// CHECK EXISTS
				$ores = $wpdb->get_results("SELECT post_id as uid FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'news_email' AND meta_value = ('".esc_sql($order_data['email'])."') LIMIT 1 ");
				 
				if(empty($ores)){
			
					$my_post = array();				
					$my_post['post_title'] 		= $order_data['email']; 
					$my_post['post_type'] 		= "ppt_newsletter"; 
					$my_post['post_status'] 	= "publish";
					$my_post['post_content'] 	= ""; 		
					$uid = wp_insert_post( $my_post );
					
					add_post_meta($uid, "news_email", $order_data['email']);
					add_post_meta($uid, "news_hash", $order_data['hash']);					
					add_post_meta($uid, "news_verified", $order_data['verified']);
					
					
					return $uid;
				
				}else{
				
					return $ores[0]->uid;
					
				}  
				 
			
			} break;
			
			case "get_all": {
			
				$emails = array( );
				
				return $emails;			
			
			} break;
			
			case "count_email": {
			
				$SQL = "SELECT count(*) AS total FROM ".$wpdb->base_prefix."postmeta WHERE meta_key = 'log_emailid' AND meta_value = '".$order_data."'";					 
				$result = $wpdb->get_results($SQL);
				if(empty($result)){ 
				
					return 0;
				}
				  
				return $result[0]->total;			
			
			} break;
			
			
			case "get_admin_emails": {
			
				$emails = array( 	
				
				
				
						"admin_user_new" => array(
							
							"name" => __("New User Registration","premiumpress"),
							"desc" => __("Sent to admin when a new user joins.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "Admin Email [Listing Expired]",
								"body" 		=> "Dear Admin<br><br>A new user has just signed up;<br><br> User: (username) <br> Email: (email)<br> User ID: (user_id) <br><br>Regards <br><br>System Email",
							),
						),					
						
						
							"admin_user_login" => array(
							
							"name" => __("User Login","premiumpress"),
							"desc" => __("Sent to admin when a user logins in.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "User Login Detected",
								"body" 		=> "Dear Admin<br><br>A user has just logged in;<br><br> User: (username) <br> Email: (email)<br> User ID: (user_id) <br>Date (date) (time)  <br>Website (website) <br><br>Regards <br><br>System Email",
							),
						),
						
									
									
						"admin_listing_new" => array(
							
							"name" => __("Listing Added","premiumpress"),
							"desc" => __("Sent to admin when a new listing is added.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "Admin Email [Listing Added]",
								"body" 		=> "Dear Admin<br><br>A user listing (title) has been added by (username);<br><br> (link)<br><br>Regards <br><br>System Email",
							),
							
						),
						"admin_listing_update" => array(
							
							"name" => __("Listing Updated","premiumpress"),
							"desc" => __("Sent to admin when a listing is updated.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "Admin Email [Listing Updated]",
								"body" 		=> "Dear Admin<br><br>A user listing (title) has been updated by (username);<br><br> (link)<br><br>Regards <br><br>System Email",
							),
						),	
						
						"admin_listing_expire" => array(
							
							"name" => __("Listing Expired","premiumpress"),
							"desc" => __("Sent to admin when a listing has expired.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "Admin Email [Listing Expired]",
								"body" 		=> "Dear Admin<br><br>A user listing (title) has expired;<br><br> (link)<br><br>User: (username) <br><br>Regards <br><br>System Email",
							),
						),	
						
						
						"admin_order_new" => array(
							
							"name" => __("New Order","premiumpress"),
							"desc" => __("Sent to admin when a new order is added.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "Admin Email [New Order]",
								"body" 		=> "Dear Admin<br><br>(from_username) has placed a new order.<br><br> (post_name)<br><br>Total: (total) <br><br>Regards <br><br>System Email",
							),
						),	
						
						
						"admin_cashback" => array(
							
							"name" => __("New Cashback Request","premiumpress"),
							"desc" => __("Sent to admin when a new cashback request is made.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "New Cashback Request",
								"body" 		=> "Dear Admin<br><br>(from_username) has added a new cashback request. <br><br>Regards <br><br>System Email",
							),
						),
						
						"admin_cashout" => array(
							
							"name" => __("New Cashout Request","premiumpress"),
							"desc" => __("Sent to admin when a new cashout request is made.","premiumpress"),
							
							"email" => array(
							
								"subject" 	=> "New Cashout Request",
								"body" 		=> "Dear Admin<br><br>A new cashout request has been made. <br><br>Regards <br><br>System Email",
							),
						),
						
						
				
				);
				
				if(!$CORE->LAYOUT("captions","listings")){
				
					unset($emails['admin_listing_new']);
					unset($emails['admin_listing_update']);
					unset($emails['admin_listing_expire']);
					
				}
				
				if(_ppt(array('user','cashout')) != "1"){ 
					unset($emails['admin_cashout']);
				}
				
				if(defined('THEME_KEY') && THEME_KEY  != "cp"){ 
				
					unset($emails['admin_cashback']);
				
				}
				
				return $emails;			
			
			} break;			
			
			
			
		}
	}


 	
	
/*
	this function sends daily emails to users
	if any are required
*/	
function cron_emails(){ global $wpdb, $CORE;

	if(is_numeric(_ppt(array('emails','event_5days'))) != ""){
	
		// CHECK EVENTS
		/*
		$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
			INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key = 'date' AND mt2.meta_value LIKE '%".date("Y-m-d", strtotime( "+5 days") )."%'  ) 
			WHERE ".$wpdb->prefix."posts.post_type = 'event' 
			AND ".$wpdb->prefix."posts.post_status = 'publish'
			LIMIT 50";
		
		$result = $wpdb->get_results($SQL);
		if(!empty($result)){
			foreach($result as $r){
			
			$data = array(			
			"name" => get_the_title($r->ID),
			"link" => get_permalink($r->ID),
			"date" => get_post_meta($r->ID,"date", true),
			"price" => get_post_meta($r->ID,"price", true),
			"location" => get_post_meta($r->ID,"location", true),
			 
			); 
		
			$this->email_system("allusers", 'event_5days', $data);
			
			}// end foreach
		} // end if empty
		
		*/
		
	} // END EMAIL
	
	
	
	if(is_numeric(_ppt(array('emails','event_1day'))) != ""){
	
		// CHECK EVENTS
		// 
		$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
			INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key = 'date' AND mt2.meta_value LIKE '%".date("Y-m-d" )."%'  ) 
			WHERE ".$wpdb->prefix."posts.post_type = 'event' 
			AND ".$wpdb->prefix."posts.post_status = 'publish'
			LIMIT 50";
		
		$result = $wpdb->get_results($SQL);
		if(!empty($result)){
			foreach($result as $r){
			
			$data = array(			
			"name" => get_the_title($r->ID),
			"link" => get_permalink($r->ID),
			"date" => get_post_meta($r->ID,"date", true),
			"price" => get_post_meta($r->ID,"price", true),
			"location" => get_post_meta($r->ID,"location", true),
			 
			); 
		
			$this->email_system("allusers", 'event_1day', $data);
			
			}// end foreach
		} // end if empty
		
	} // END EMAIL
	
	
	
 
	

}
	
	
	
function returnhtml(){ return "text/html"; }
	
	

/*
	this function sends the email
*/
function email_send($email, $subject, $message, $headers = array() ){ global $CORE;

 	// ADD ON EXTRA HEADERS
	$headers[] = "Content-Type: text/html; charset=\"" .get_option('blog_charset') . "\"\n"; 
 	
	// EMAIL FILTERS		 
	add_filter('wp_mail_content_type', array($this, 'returnhtml') );	
	apply_filters( 'wp_mail_content_type', "text/html" );
	
	 
	// CHECK FOR EMAIL HEADER/FOOTERS	
	$finalMessage = stripslashes($this->email_message_filter(get_option('ppt_email_header'), array())).$message.stripslashes($this->email_message_filter(get_option('ppt_email_footer'), array()));	 
	
	$finalMessage = str_replace("<p>","<p style='margin-bottom:15px;'>", stripslashes(wpautop($finalMessage)));
		 
	// SEND MESSAGE	
	wp_mail($email, stripslashes($subject), "<html><body>".$finalMessage."</body></html>", $headers); 	 
	
	// UPDATE EMAIL LOGS
	$emaillogs = get_option('ppt_emaillogs');
	if(!is_array($emaillogs)){ $emaillogs = array(); }
	
	// GET DATE		  
	$date_now = date('Y-m-d');
					
	// update
	if(isset($emaillogs[$date_now]) && isset($emaillogs[$date_now]) ){
		$emaillogs[$date_now] = array("date" => $date_now, "hits" => $emaillogs[$date_now]['hits']+1, "last_sent" => date('Y-m-d H:i:s')); 				
	}else{	  
		$emaillogs[$date_now] = array("date" => $date_now, "hits" => 1 );
	}
	
	update_option("ppt_emaillogs", $emaillogs);
		 
	
}

/*
	this function gets all of the user emails
*/
function email_get_all_user_emails(){ global $wpdb; $STRING = "";


		$SQL = "SELECT DISTINCT user_email FROM ".$wpdb->base_prefix."users";		 	
		$result = $wpdb->get_results($SQL);
		if(!empty($result)){
		 
			foreach($result as $e){
			$STRING .= $e->user_email.",";
			}		
		}
 
	return substr($STRING,0,-1);
}
 
/*
	this function sets up emails from the built-in
	email templates
*/
function SENDEMAIL($userid = "", $emailid, $data = ""){$this->email_system($userid, $emailid, $data); }

function email_custom($userid = "", $subject, $message){ global $CORE; $headers = array();

		// GET USER EMAIL FROM THEIR ID
		if($userid == "admin"){		
			$user_email = get_option('admin_email');
		}elseif($userid == "allusers"){		
			$user_email = $this->email_get_all_user_emails();
		}elseif(is_numeric($userid)){
			$user_email = get_the_author_meta( 'user_email', $userid );
		}else{
			$user_email = $userid;
		}
			 
		// VALIDATE FOR NO EMAIL SET
		if($user_email == ""){	
			
			$CORE->ADDLOG("Email Error", $userid, "", "error", "email", $emailid );			 
			return;			
		}	
		
		// CLEAN EMAIL WITH SHORTCODES
		$subject = $this->email_message_filter($subject, array());
		$message = $this->email_message_filter($message, array());
	
		
			
		// DEFAULT MESSAGE HEADERS
		if(isset($_POST['contact_e1']) && $_POST['contact_n1'] != ""){	
			$headers[] = 'From: '.esc_html($_POST['contact_n1']).' <'.$_POST['contact_e1'].'>';			
		}elseif(isset($ppt_emails[$emailid]['from_name']) && strlen($ppt_emails[$emailid]['from_name']) > 2){ 
			$headers[] = 'From: '.$ppt_emails[$emailid]['from_name'].' <'.$ppt_emails[$emailid]['from_email'].'>';
		}else{ 
			$headers[] = 'From: '.get_option('emailfrom').' <'.get_option('admin_email').'>';
		}
		
		// CHECK FOR BBC HEADERS
		if(isset($ppt_emails[$emailid]['bcc_name']) && strlen($ppt_emails[$emailid]['bcc_name']) > 1){ 
			$headers[] .= 'Bcc: '.$bbc_name.' <'.$ppt_emails[$emailid]['bcc_email'].'>';
		}
			
  		
		// SEND EMAIL
		$this->email_send($user_email, stripslashes($subject), $message, $headers);
 
}

function email_system($userid = "", $emailid, $data = array() ){ global $CORE; $headers = array(); 

 

 	// CHECK WE HAVE ASSIGNED AN EMAIL TO THIS
	/// EMAIL ID OTHERWISE LOG NO EMAIL
	
	// GET EMAIL DATA
	$all_emails = _ppt('emails');
	  
	// CHECK WE HAVE AN EMAIL SETUP
	if( isset($all_emails[$emailid]) ){ 
	
		// CHECK ITS ENABLED
		if(!isset($all_emails[$emailid]['enable']) || ( isset($all_emails[$emailid]['enable']) && $all_emails[$emailid]['enable'] != 1) ){ return; }
	
		// GET USER EMAIL FROM THEIR ID
		if($userid == "admin"){		
			$user_email = get_option('admin_email');
		}elseif($userid == "allusers"){		
			$user_email = $this->email_get_all_user_emails();
		}elseif(is_numeric($userid)){
			$user_email = get_the_author_meta( 'user_email', $userid );
		}else{
			$user_email = $userid;
		}
			 
		// VALIDATE FOR NO EMAIL SET
		if($user_email == ""){	
				// ADD LOG
				$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "email",	
							"status" 	=> "error",		
							"data" 		=> "Error sending email ".$emailid,						 
							"userid" 	=> $userid,		
							"email" 	=> $emailid,			 
						)
				);		
			 
			return;			
		}
		
		if(!isset($all_emails[$emailid]['body'])){
		$all_emails[$emailid]['body'] = "";
		}
	
		// GET THE EMAIL CONTENT
		$subject = $this->email_message_filter($all_emails[$emailid]['subject'], $data);
		$message = $this->email_message_filter($all_emails[$emailid]['body'], $data);

		
		// IF BLANK GET DEFAULT EMAIL CONTENT
		if($subject == "" || $message == "" ){
			return;
		} 
		
		/*
		if(defined('WLT_DEMOMODE')){
			$message .= "\n\n------------------------------------------\n\n";
			foreach($data as $g => $gg){
				$message .= "".$g." :: ".$gg."\n\n";
			}
		}*/
 	
		// DEFAULT MESSAGE HEADERS
		if(isset($_POST['contact_e1']) && $_POST['contact_n1'] != ""){	
			$headers[] = 'From: '.esc_html($_POST['contact_n1']).' <'.$_POST['contact_e1'].'>';					
			$headers[] = 'Reply-To: '.esc_html($_POST['contact_n1']).' <'.$_POST['contact_e1'].'>';
		}elseif(isset($ppt_emails[$emailid]['from_name']) && strlen($ppt_emails[$emailid]['from_name']) > 2){ 
			$headers[] = 'From: '.$ppt_emails[$emailid]['from_name'].' <'.$ppt_emails[$emailid]['from_email'].'>';
		}else{ 
			$headers[] = 'From: '.get_option('emailfrom').' <'.get_option('admin_email').'>';
		}
		
		// CHECK FOR BBC HEADERS
		if(isset($ppt_emails[$emailid]['bcc_name']) && strlen($ppt_emails[$emailid]['bcc_name']) > 1){ 
			$headers[] .= 'Bcc: '.$bbc_name.' <'.$ppt_emails[$emailid]['bcc_email'].'>';
		}
		
		// ADD LOG
		$CORE->FUNC("add_log",
				array(				 
					"type" 		=> "email",
					"data" 		=> stripslashes($subject) ." <br><br>".stripslashes($message)."<br><br>".$user_email,						 
					
					"userid" 	=> $userid,
					
					"emailid" 	=> $emailid, 
					
					"email"		=> $user_email,
					 		 
				)
		);	
 		
		// SEND EMAIL
		$this->email_send($user_email, stripslashes($subject), stripslashes($message), $headers);		
		
		// SEND SMS ALERT		
		//$this->SENDEMAILALERT($userid, $emailid, $data); 
		
	
	// NO EMAIL SET
	}else{
	
		 
		return;	
	}
 
}
/*
	this function replaces tags in emails with
	anyting thats available within the system
*/
function email_message_filter($message, $data, $get=false, $emailID = ""){ global $userdata, $CORE;

 	$extra_shortcodes = array(
		
		'website' 		=> home_url(), 		
		'date' 			=> hook_date(date('Y-m-d')),
		'time' 			=> date('h:i:s A'),		
	);	
	
	 	
	if($get && in_array($emailID, array("newsletter")) ){
	$extra_shortcodes["unsubscribe"] 		= "http://wwww.XXXX/unsubscribe/";	
	}
	
	if($get && in_array($emailID, array("user_verify")) ){
	$extra_shortcodes["vlink"] 		= "http://wwww.XXXX/link-to-verify/";	
	}
	
	
	if($get && in_array($emailID, array("offer_new","offer_accepted","offer_rejected","offer_updated")) ){
		
		$extra_shortcodes["from_username"] 		= "Buyer Name";
		$extra_shortcodes["post_name"] 			= "Full Item Name";
 		
	}
	
	if($get && in_array($emailID, array("order","admin_order_new")) && THEME_KEY  != "sp"){
		
		$extra_shortcodes["from_username"] 	= "Buyer Name";
		$extra_shortcodes["total"] 			= "$100";
		$extra_shortcodes["post_name"] 		= "Full Item Name";
 		$extra_shortcodes["orderid"] 		= "34838434";
	}
	 
	
	if($get && in_array($emailID, array("user_registered", "admin_user_new")) ){	
	 
		$extra_shortcodes["user_id"] 		= "45";
		$extra_shortcodes["username"] 		= "JohnDoe";
		$extra_shortcodes["email"] 			= "johndoe@gmail.com";
		$extra_shortcodes["password"] 		= "adas87d8sa7d87a8sda8d";
		$extra_shortcodes["first_name"] 	= "John";
		$extra_shortcodes["last_name"] 		= "Doe";
		
		$regfields = get_option("regfields"); 
		if(!is_array($regfields)){ $regfields = array(); } $i=0; 
		
		if(is_array($regfields) && isset($regfields['name'])){
			foreach($regfields['name'] as $data){ 	
				if( strlen($regfields['name'][$i]) > 2 ){ 
				$extra_shortcodes["userfield_".$regfields['key'][$i]] 		= stripslashes($regfields['name'][$i]);		
				}
				$i++;
			} 
		}
	
	}
	
  
	// USER ID	
	if(isset($data['user_id']) && is_numeric($data['user_id']) ){
		
		$userid =   $data['user_id'];
		
		$message = str_replace("(user_id)", $data['user_id'], $message);
		
		$extra_shortcodes["user_id"] = $data['user_id'];	
		 
	}elseif( isset($userdata->ID) ){
		
		$userid =   $userdata->ID;
		
		$message = str_replace("(user_id)", $userdata->ID, $message);	
	}
	
	
	// VERIFY LINK	
	$message = str_replace("(vlink)", '<a href="'.home_url()."/verifyme/".$userid."/".'">'.home_url()."/verifyme/".$userid."/".'</a>', $message); 
	
	$message = str_replace("(website)", '<a href="'.home_url().'">'.home_url().'</a>', $message); 
  
	
	// MATCH REG FIELDS
	preg_match_all('/\(([^\)]*)\)/', $message, $matches);
	if(is_array($matches) && !empty($matches[0])){
		
		$o=0;
		foreach($matches[1] as $g){
		
			if(substr($g,0, 10) == "userfield_"){			
			 
				$message = str_replace("(".$g.")", get_user_meta($userid, substr($g, 10), true), $message); 
			
			}		 
		$o++;
		} 
		 
	}
	
	
	 
	
	
	// USERNAME	
	if(isset($data['username']) && strlen($data['username']) > 2){ 
	
		$message = str_replace("(username)", $data['username'], $message);		
		$extra_shortcodes["username"] = $data['username'];
		
	}elseif(isset($data['user_id']) && is_numeric($data['user_id']) ){
		 
		$message = str_replace("(username)", $CORE->USER("get_username", $data['user_id']), $message);		
		$extra_shortcodes["username"] = $CORE->USER("get_username", $data['user_id']);
	
	}elseif(isset($_POST['user_login'])){
	
		$message = str_replace("(username)", $_POST['user_login'], $message);	 
		$message = str_replace("(Username)", $_POST['user_login'], $message);
	
	}elseif(isset($_POST['username'])){
	
		$message = str_replace("(username)", $_POST['username'], $message);	 
		$message = str_replace("(Username)", $_POST['username'], $message);	
	
	}elseif( isset($userdata->display_name) ){
	
		$message = str_replace("(Username)", $userdata->display_name, $message);
		$message = str_replace("(username)", $userdata->display_name, $message);	 
	 
	}	
	
	
	
	// USERNAME	
	if(isset($data['from_username']) && strlen($data['from_username']) > 2){ 
	
		$message = str_replace("(from_username)", $data['from_username'], $message);		
		$extra_shortcodes["from_username"] = $data['from_username'];
		
	} 
	
	
	// FIRST NAME
	if(isset($data['user_id']) && is_numeric($data['user_id']) ){
		 
		$message = str_replace("(first_name)", $CORE->USER("get_first_name", $data['user_id']), $message);				
	
	}elseif(isset($_POST['first_name'])){
	
		$message = str_replace("(first_name)", $_POST['first_name'], $message);	
	
	}elseif(isset($userdata->first_name) && !in_array($emailID, array("newsletter")) ){
	
		$message = str_replace("(first_name)", $userdata->first_name, $message);
		$extra_shortcodes["first_name"] = $userdata->first_name;
	 	 	
	}
	
	// LAST NAME
	if(isset($data['user_id']) && is_numeric($data['user_id']) ){
		 
		$message = str_replace("(last_name)", $CORE->USER("get_last_name", $data['user_id']), $message);			
	
	}elseif(isset($_POST['last_name'])){
	
		$message = str_replace("(last_name)", $_POST['last_name'], $message);	 
	
	}elseif(isset($userdata->last_name) && !in_array($emailID, array("newsletter")) ){
		 
		$message = str_replace("(last_name)", $userdata->last_name, $message);			
		$extra_shortcodes["last_name"] = $userdata->last_name;
		
	}
	
	// USER EMAIL
	if(isset($data['user_id']) && is_numeric($data['user_id']) ){
	 	
		$message = str_replace("(user_email)", $CORE->USER("get_email", $data['user_id']), $message);			
	
	}elseif(isset($_POST['user_email'])){	
	
		$message = str_replace("(user_email)", $_POST['user_email'], $message);	
		 
	}elseif( isset($userdata->ID) && !in_array($emailID, array("newsletter"))  ){	
		
		$e = $CORE->USER("get_email", $userdata->ID);
		$message = str_replace("(user_email)", $e, $message);		
		$extra_shortcodes["user_email"] = $e;
		 
	}	 
	 
	// NAME
	if(isset($_POST['contact_n1'])){
	$message = str_replace("(name)", $_POST['contact_n1'], $message);	
	} 
	 

	// PERFORM STRING REPLACE ON ENTIRE MESSAGE CONTENT	
	if(is_array($_POST)){
		foreach($_POST as $key=>$value){
			if(is_array($value)){
				foreach($value as $key1=>$val1){
					if(is_array($val1)){
					
					}else{
					$message = str_replace("(".$key1.")",$val1,$message);
					}// end if
				} // end foreach			
			}else{
			if(!is_object($value)){
			$message = str_replace("(".$key.")",$value,$message);
			}
			}		 
		}// end foreach
	}// end if
	
	
	
	// PASSED IN DATA
	if(is_array($data)){
		foreach($data as $key => $val){
			$message = str_replace("(".$key.")",$val, $message);
			
			$extra_shortcodes[$key] = $val;
			
		}	
	}
		
	// CHECK EXTRA SHORTCODES
	foreach($extra_shortcodes as $key=>$val){
	$message = str_replace("(".$key.")",$val,$message);
	}

	
	// RETURN SHORTCODES
	if($get){
	
	return $extra_shortcodes;
	
	}
	
	
	$message = str_replace("(theme_key)", THEME_KEY, $message);
	
	
	// CLEAN UPDATE EMPTY TAGS
	if(is_admin()){
	$message = preg_replace("/\([^)]+\)/", '******', $message);
	}else{
	//$message = preg_replace("/\([^)]+\)/", '', $message);
	}	 

	
	// RETURN MESSAGE
	return $message;
}
 
 
	
	
	
	
	
	
	


	
 	// EMAIL FROM
	function _fromname($email){
		return get_option('emailfrom');
	}
	function _fromemail($email){
		$admin_email = get_option('admin_email');
		if($admin_email == ""){
			return $email;
		}else{
			return $admin_email;
		}		
	}
	
	// DEBUG EMAIL OPTION
	function debug_wpmail($query){
	if(defined('WLT_DEBUG_EMAIL')){
		echo "<div style='background:#fafafa; border:1px solid #ddd; padding:15px;'>";
		foreach($query as $k=>$p){
			if(is_array($p)){
			print_r($p);
			}else{
			echo $k.": ".$p."<br />";
			}
		}
		echo "</div>";
		die();
	}
	return $query;
	} 


function SENDSMS_ACTIVATION($num){
	
	$from 	= _ppt('ppt_nexmo_from');
	$msg 	= "SMS CODE ".date('ymd')."";

	$url = "https://rest.nexmo.com/sms/json?api_key="._ppt('ppt_nexmo_api').
						"&api_secret="._ppt('ppt_nexmo_se').
						"&from=".$from .
						"&to=".$num .
						"&text=".urlencode(stripslashes($msg))."&type=unicode"; 
 
	$response = wp_remote_post( $url );	
	if ( is_wp_error( $response ) ) {	
		$error_message = $response->get_error_message();	
		$ERROR = "Something went wrong: $error_message";	
	}else{	
		$ERROR =  "ok";
	}	
	
	// SEND ADMIN A COPY
	if(_ppt('ppt_nexmo_admincopy') == 1){
		$msg." - admincopy";
		//$this->SENDSMS_ADMIN($msg);	
	}	
	return $ERROR;
	
}
function SENDSMS_ADMIN($num = "all", $msg, $from = "ALERT"){ global $CORE, $userdata;

  $i=1; 
  
  if($num == "all"){
  while($i < 6){ 
  
	  if(strlen(_ppt('ppt_nexmo_num_'.$i) > 2) && _ppt('ppt_nexmo_prefix_'.$i) != "" ){
	
			$url = "https://rest.nexmo.com/sms/json?api_key="._ppt('ppt_nexmo_api').
						"&api_secret="._ppt('ppt_nexmo_se').
						"&from=".$from.
						"&to="._ppt('ppt_nexmo_prefix_'.$i)._ppt('ppt_nexmo_num_'.$i).
						"&text=".urlencode(stripslashes($msg)); 
						 
			$response = wp_remote_post( $url );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				return "Something went wrong: $error_message";
			}else{	
			
				$CORE->ADDLOG("SMS Sent", $userdata->ID, 0, $num, "sms", $msg );
			
				return "SMS Sent\n";
			}		
		}	
	$i++; 	
	}
	
	}else{
	
	$url = "https://rest.nexmo.com/sms/json?api_key="._ppt('ppt_nexmo_api').
						"&api_secret="._ppt('ppt_nexmo_se').
						"&from=".$from.
						"&to=".$num.
						"&text=".urlencode(stripslashes($msg)); 
						
			$response = wp_remote_post( $url );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				
				// ADD LOG				 
				$CORE->ADDLOG("SMS Failed", $userdata->ID, 0, $num, "sms", $error_message );		
				
				return "Something went wrong: $error_message";
			}else{	
			
				// ADD LOG					
				$CORE->ADDLOG("SMS Test Sent", $userdata->ID, 0, $num, "sms", $msg );
			
				return "SMS Sent\n";
			}	
	
	}

}
function SENDEMAILALERT($userid, $emailid, $data = ""){ global $post, $CORE, $userdata; $sms_msg = ""; 

 	// SEND SMS OPTION
	if(_ppt('ppt_email_alert_sendsms') != 1){ return; }
 
	
	// CHECK WE HAVE SMS MESSAGE FOR THIS EMAIL
	$all_emails = _ppt('emails');
 	
	if(!isset($all_emails[$emailid]['sms']) || isset($all_emails[$emailid]['sms']) && $all_emails[$emailid]['sms'] == ""){ return; }
	 
	
	// MAKE SURE VALID USER
	if(!is_numeric($userid) && $userid != "admin"){ return; }
	
	// MESSAGE
	$sms_msg = $all_emails[$emailid]['sms'];
	
	
	// CHECK USER 
	if($userid == "admin"){
	
		// SEND SMS
		$this->SENDSMS_ADMIN('all',$sms_msg);
	
	}else{
	
		// GET USER MOBILE NUM
		$mobilenum = get_user_meta($userid, 'mobile', true);
	
	
		if($mobilenum != ""){
			// GET COUNTRY
			
			$ca = get_user_meta($userid, 'country', true);
			
			// BUILDING MOBILE NUMBER
			$num =  "+".$this->countrydialingcodes[$ca]['code'].$mobilenum;			
			 
			// SEND SMS
			$this->SENDSMS_ADMIN($num, $sms_msg, _ppt('ppt_nexmo_from'));
		}
	}
 
}   


	 
	
}

?>