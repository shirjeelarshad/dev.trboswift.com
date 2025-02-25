<?php


class framework_updates extends framework_shortcodes {
	
 
	
	// THIS FUNCTION IS USED TO UPDATE CHILD THEME STYLESHEET FILES
	function admin_update_child_theme(){ global $wpdb, $CORE;  $f = wp_get_theme(); 
	 
		// DONT CHECK FOR LOCALHOST		 
		if(in_array($_SERVER['REMOTE_ADDR'], array(  '127.0.0.1', '::1')) ){ return; }
 		 
		$HandlePath = WP_CONTENT_DIR."/themes/";
		if($themes = opendir($HandlePath)) {      
			while(false !== ($theme = readdir($themes))){ 		
				if(strpos($theme,".") === false && substr($theme,0,9) == "template_" && file_exists($HandlePath.$theme."/style.css") ){	
				
					// OPEN THE CHILD THEME AND REPLACE THE THEME NAME WITH OUR SETUP ONE
					$file = $HandlePath.$theme."/style.css";				
					$file_contents = file_get_contents($file);			
					$fh = @fopen($file, "w");
					$file_contents = str_replace('[XXX]',$f->template,$file_contents);
					@fwrite($fh, $file_contents);
					@fclose($fh);				
				   
				}
			}			
		}
	
	} 
 
 	function check_for_theme_update($theme_data) { global $wp_version, $theme_version, $theme_base;   
	
	 
		// DONT CHECK FOR LOCALHOST		 
		//if(in_array($_SERVER['REMOTE_ADDR'], array(  '127.0.0.1', '::1')) ){ return; }
		 
		if(empty($theme_data->checked)  ){ return $theme_data; } // 
		
		if(!defined('THEME_KEY')){  return $theme_data; }  	 	 
		
		// NOW LOOP THROUGH ALL OUR THEMES TO CHECK FOR UPDATES
		if(is_array($theme_data->checked)){ 	
			
			// LOOP ALL THEMES
			foreach($theme_data->checked as $key => $version){
				
				// check theme name
				if(strlen($key) > 4 ){ continue; } 	
				
				// NEXT
				$do_this_action = "theme_update";
				if(isset($theme_data->action)  ){ $do_this_action = $theme_data->action; }
				   
				// build request				 
				$request = array(
						'slug' 			=> strtoupper($key),
						'version' 		=> $version,
						"theme_key" 	=> strtoupper(THEME_KEY),
						'email' 		=> get_option('admin_email'),
						'theme_lic' 	=> get_option("ppt_license_key"),	
						'theme_url' 	=> esc_url( home_url() ),						
					);
					
					 
				 
				// Start checking for an update
				$send_for_check = array(
					'body' => array(
						'action' => $do_this_action, 
						'request' => serialize($request),
						'api-key' => md5(esc_url( home_url() ))
					),
					'user-agent' => 'WordPress/' . $wp_version . '; ' . esc_url( home_url() )
				);
			  
				 
						
				update_option("ppt_expired","0");
						 		
							
			
			} // end foreach
		}// end if 	 
	  
		return $theme_data;
	}
	 

	
	/* =============================================================================
	   CORE SYSTEM PLUGIN UPDATE TOOL
	   ========================================================================== */
	function themes_api_call($def, $action, $args) {
		global $theme_base, $api_url, $theme_version, $wp_version, $api_url;
		
		 
		// RETURN
		return $def;
	
	}  
 
	
}

?>