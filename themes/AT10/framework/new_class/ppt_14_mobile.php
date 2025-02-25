<?php

 
class framework_mobile extends framework_user {
	

	function premiumpress_cron_activation() {
	 
		if ( !wp_next_scheduled( 'premiumpress_hourly_event_hook' ) ) {
			wp_schedule_event( time(), 'hourly', 'premiumpress_hourly_event_hook' );
		}
	
		if ( !wp_next_scheduled( 'premiumpress_daily_event_hook' ) ) {
			wp_schedule_event( time(), 'daily', 'premiumpress_daily_event_hook' );
		}
		
	}
	function cron_hourly(){ global $CORE, $wpdb;
	
	 	// PERFORM LISTING EXPIRY
		$this->handle_listings_expire();	
		
		// PERFORM LISTING EXPIRY
		$this->handle_membership_expire(); 
		
		// PERFORM LISTING CHECKS
		if(defined('THEME_KEY') && THEME_KEY == "mj"){
		$this->handle_listings_without_accepted_offers();
		}
		
		// DELETE ONLINE USERS
		if(!defined('WLT_DEMOMODE')){
		
			delete_metadata( 'user', null, 'online', '', true );
		}
		
		// DELETE TEMP POSTS
		$SQL = "SELECT DISTINCT ID FROM $wpdb->posts WHERE post_title='temp post' LIMIT 100";			 
		$fp = $wpdb->get_results($SQL, ARRAY_A);
		if(is_array($fp) && !empty($fp)){
			foreach($fp as $d){
				wp_delete_post( $d['ID'], true );
			}
		} 
		 
	}

	function cron_daily(){ global $CORE, $wpdb;		
		
		//  ONLINE OLD LOGS
		$args = array( 				
			'post_type' 		=> 'ppt_logs',
			'posts_per_page' 	=>  100,				
			'date_query' => array(
					'before'     => '1 week ago',
					'inclusive' => true
			),	 					
		);
		$found_logs = new WP_Query($args);
		
		$logs = $wpdb->get_results($found_logs->request, OBJECT);
		foreach($logs as $log){		 
			wp_delete_post( $log->ID, true );		 
		 }	 
	 
	 
	 
	 	// CLEAN UP OLD DATA
		delete_option('ppt_saved_zipcodes');
	}
	
	
	function isMobileDevice(){ global $userdata;
	 
	    	
		// GET THE BROWSER AGENTS
        $agent = $_SERVER["HTTP_USER_AGENT"]; 
		    
		// CHECK FOR MOBILE DEVICE
		if (strpos(strtolower($agent), "facebook") === false) { }else{ return false;}	
		 
        $mobile = false;
        $agents = array("Alcatel", "Blackberry", "HTC",  "LG", "Motorola", "Nokia", "Palm", "Samsung", "SonyEricsson", "ZTE", "iPhone", "iPod", "Mini", "Playstation", "DoCoMo", "Benq", "Vodafone", "Sharp", "Kindle", "Nexus", "Windows Phone", "Mobile",'mobile');
        foreach($agents as $a){
		 
            if(stripos($agent, $a) !== false){
			 
				// SET CONSTANT
				return true;
            }
        }	
		
		if(isset($_GET['mobile_view'])){
			return true;
		}  
		
        return false;
	}	
	
	
	
}

?>