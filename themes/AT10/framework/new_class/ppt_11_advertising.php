<?php


class framework_advertising extends framework_geo {


	function ADVERTISING($action='add', $order_data){
	
	global $userdata, $wpdb, $CORE;
	 
		switch($action){
		
		
			case "get_continue_button": {
		
				$k = $order_data;
				 
                
					if($userdata->ID){
					
						$sellspacedata 	= _ppt('sellspace');
                    
                    	// PAY CODE
						$btn =  $CORE->order_encode(array(  
									   
							  "uid" 			=> $userdata->ID,                
							  "amount" 			=> $sellspacedata[$k."_price"],
							  "order_id" 		=> "BAN-".$k."-".$userdata->ID."-".rand(),                
							  "description" 	=> stripslashes($sellspacedata[$k."_name"]),
																 
						)); 
									
						$button = 'href="javascript:void(0);" onclick="processPayment(\''.$btn.'\',\''.$sellspacedata[$k."_price"].'\'); "';
									 
					}else{ 
									
						$button = 'href="javascript:void(0)" onclick="processLogin(0,\'\');"';
									
					} 
				 
				
				return $button;
			
			} break;
		
		
			case "campaign_expires": {
				
				$expires = get_post_meta($order_data,'expires',true);
				
				$expired = 0;
				$days = 0;
				
				// CHECK EXPIRES
				if($expires == ""){
					$expired = 1;				 
				}else{
				
					$da = $CORE->date_timediff($expires,'');
					if($da['expired'] == 1){
					
						$expired = 1;					
						update_post_meta($order_data,'status','ended'); 
						
					}else{
					$days = $da['string'];
					}
					 			  
				} 
				
				$data = array(
					"days" => $days,
					"date" => $expires,
					"expired" => $expired,
				);
				
				return $data;	
	
			} break;
			
			case "campaign_clicks": {
				
				$clicks = get_post_meta($order_data,'clicks',true);
				if($clicks == ""){
				$clicks = 0;
				}
				return number_format($clicks);	
	
			} break;
			
			case "campaign_impressions": {
				
				$clicks = get_post_meta($order_data,'impressions',true);
				if($clicks == ""){
				$clicks = 0;
				}
				return number_format($clicks);	
	
			} break;
			
			case "update_impressions": {
			
				$clicks = get_post_meta($order_data,'impressions',true);
				if($clicks == ""){
				$clicks = 0;
				}
				
				update_post_meta($order_data,'impressions',$clicks+1);
				
			} break;			
		
			case "campaign_status": {
			
				
				$status_array = array(
				
					"active" => array(
						"key"	=> "publish",
						"name" => __("Live","premiumpress"),
						"short" => __("Live","premiumpress"),
						"color" => "#00b517",
					),	
				 
					"pending" => array(	
						"key" 	=> "payment",				
						"name" 	=> __("Pending Update","premiumpress"),
						"short" => __("Pending","premiumpress"),
						"color" => "#ff9017",
					),
					
					"hold" => array(	
						"key" 	=> "hold",				
						"name" 	=> __("On Hold","premiumpress"),
						"short" => __("On Hold","premiumpress"),
						"color" => "#ff9017",
					),
					 
					
					"ended" => array(
						"key"	=> "ended",
						"name" => __("Finished","premiumpress"),
						"short" => __("Finished ","premiumpress"),
						"color" => "#17a2b8",
					),
					
					
				);
				
				if(is_numeric($order_data)){
				
					$status = get_post_meta($order_data,'status',true);
					
					if(isset($status_array[$status])){
						return $status_array[$status];					
					}
					
					return $status_array["pending"];
					
				 
				
				}else{
				
				return $status_array;
				
				}
				
				 
			
			
			} break;	
			
			case "check_exists": {		
			
			
				if(_ppt(array('mem','enable')) == "1" && isset($userdata->ID) && $CORE->USER("membership_hasaccess", "adfree")){
					return 0;				
				}			
				
	
				// BANNER KEY (FOOTER, HEADER ETC)
				if(is_array($order_data)){
				$banner_key 	= $order_data[0];				
				}else{
				$banner_key 	= $order_data;				
				}
				
				// SELLSPACE
				$sellspacedata = _ppt('sellspace');
				
				
				
				 
				// args
				$args = array(
							'posts_per_page' 	=> 1, 
							'post_type' 		=> 'ppt_campaign', 
							'orderby' 			=> 'post_date', 
							'order' 			=> 'desc',
							'post_status'		=> 'publish',
							'meta_query' => array(
								array(
									'key'     => 'location',
									'value'   => $banner_key,
									'compare' => '=',
								),							
								
								array(
									'key'     => 'status',
									'value'   => "active",
									'compare' => '=',
								),
							),
					);
					 
				$wp_query1 = new WP_Query($args); 
				$tt = $wpdb->get_results($wp_query1->request, OBJECT);
				 
					  
				if(!empty($tt)){			
					
					return 1;
					
				}elseif(isset($sellspacedata[$banner_key]) && $sellspacedata[$banner_key] == 1 && isset($sellspacedata[$banner_key."_sample"]) && $sellspacedata[$banner_key."_sample"] ){
					
					return 1;
										
				}
			   	
			   	return 0;				
				
			
			} break;
			
			case "get_spaces": {
			
			// SELL SPACE AREAS
			$sellspace = array(	
			
				"header_top" => array(		 
					"n" => "Header Top (header style 12 only)",
					"sw" => "468",
					"sh" => "60",
					"p"	=> "header_top",
					"min" => 1,
					"max" => 1,					
				),	
			
				"header" => array(		 
					"n" => "Header",
					"sw" => "468",
					"sh" => "60",
					"p"	=> "header",
					"min" => 1,
					"max" => 1,					
				),				
			 
				"footer" => array(		 
					"n" => "Footer",
					"sw" => "468",
					"sh" => "60",
					"p"	=> "footer",
					"min" => 1,
					"max" => 1,
					 
					
				),
				
				"account_top" => array(		 
					"n" => "Account Page (Top)",
					"sw" => "468",
					"sh" => "60",
					"p"	=> "account_top",
					"min" => 1,
					"max" => 3,
					 
					
				),
			
				"blog_top" => array(		 
					"n" => "Blog Sidebar (Top)",
					"sw" => "280",
					"sh" => "250",
					"p"	=> "blog_top",
					"min" => 1,
					"max" => 3,
					 
					
				),
				
				"blog_bottom" => array(		 
					"n" => "Blog Sidebar (Bottom)",
					"sw" => "280",
					"sh" => "250",
					"p"	=> "blog_bottom",
					"min" => 1,
					"max" => 3,
					 
				),
				
				
				
				
				// SEARCH PAGE
				"search_top" => array(		 
					"n" => "Search Top",
					"sw" => "728",
					"sh" => "90",
					"p"	=> "search",
					"min" => 1,
					"max" => 1,
					
					"color" => "green",
				),
				
				"search_bottom" => array(		 
					"n" => "Search Bottom",
					"sw" => "728",
					"sh" => "90",
					"p"	=> "search",
					"min" => 1,
					"max" => 1,
				),
				
				"search_sidebar_top" => array(		 
					"n" => "Search Sidebar - Top",
					"sw" => "280",
					"sh" => "200",
					"p"	=> "search",
					"min" => 1,
					"max" => 1,
				),
				
				"search_sidebar_bottom" => array(		 
					"n" => "Search Sidebar - Bottom",
					"sw" => "280",
					"sh" => "200",
					"p"	=> "search",
					"min" => 1,
					"max" => 1,
				),	
				
				"search_side" => array(		 
					"n" => "Search Side",
					"sw" => "175",
					"sh" => "600",
					"p"	=> "search",
					"min" => 1,
					"max" => 1,
				),			
				
				
				// SINGLE PAGE
				"single_sidebar" => array(		 
					"n" => "Single ".$CORE->LAYOUT("captions", 1)." Sidebar",
					"sw" => "350",
					"sh" => "250",
					"p"	=> "single",
					"min" => 1,
					"max" => 1,
				),	
				
				
				
									
			);
			
			
			// UNSET UNUSED 
			
			if( !in_array(_ppt(array('design','search_layout')) , array('5','6')) ){
			
				unset($sellspace['search_sidebar_top']);
				unset($sellspace['search_sidebar_bottom']);
			
			}
			
			if(!is_array($order_data) && strlen($order_data) > 1){
				
				if(isset($sellspace[$order_data])){
					return $sellspace[$order_data];
				}
				return $sellspace["header"];
			}
			
			
			return $sellspace;
			
			
			} break;
			
			case "get_user_banners": {
			
					$mybanners = array();
					
					$userid = $order_data[0];
					if(isset($order_data[1])){
						$size1 = $order_data[1];
						$size2 = $order_data[2];
					}
					
					if(isset($size1)){		
					
					$SQL = "SELECT ".$wpdb->posts.".* FROM ".$wpdb->posts."
							INNER JOIN ".$wpdb->postmeta." AS t1 ON ( t1.post_id = ".$wpdb->posts.".ID AND t1.meta_key = 'width' AND t1.meta_value = '".$size1."')
							INNER JOIN ".$wpdb->postmeta." AS t2 ON ( t2.post_id = ".$wpdb->posts.".ID AND t2.meta_key = 'height' AND t2.meta_value = '".$size2."')
							WHERE ".$wpdb->posts.".post_status= 'publish' AND ".$wpdb->posts.".post_author = ".$userid."  LIMIT 0,50";	
			 
					}else{
					$SQL = "SELECT * FROM ".$wpdb->prefix."posts WHERE post_type = 'ppt_banner' AND post_author = ".$userid." ORDER BY post_date DESC"; 
					}
				  
					$posts = $wpdb->get_results($SQL);	 
					foreach($posts as $post){ 
						$mybanners[] = array(
							'id' => $post->ID, 
							'name' => $post->post_title, 
							'img' => $post->post_excerpt, 
							'w' => get_post_meta($post->ID, 'width', true), 
							'h' => get_post_meta($post->ID, 'height', true)  
						);
					}
				 
					return $mybanners;	
			
			} break;
			
			case "get_all_banners": {
			
					$SQL = "SELECT * FROM ".$wpdb->prefix."posts WHERE post_type = 'ppt_banner' ORDER BY post_date DESC"; 					
				  	$mybanners = array();
					$posts = $wpdb->get_results($SQL);	 
					foreach($posts as $post){ 
						$mybanners[] = array(
							'id' => $post->ID, 
							'name' => $post->post_title, 
							'img' => $post->post_excerpt, 
							'w' => get_post_meta($post->ID, 'width', true), 
							'h' => get_post_meta($post->ID, 'height', true)  
						);
					}
				 
					return $mybanners;	
			
			
			} break;
						
			case "get_banner_link": {			
			
			
			return home_url()."/outbanner/".$order_data."/";
			
			} break;			
			
			case "get_banner": {	
				
				
				// BANNER KEY (FOOTER, HEADER ETC)
				if(is_array($order_data)){
				$banner_key 	= $order_data[0];
			 
				}else{
				$banner_key 	= $order_data;
				 
				}  
				
				// GET DATA
				$OUTINNER = "";				 
				$sellspacedata = _ppt('sellspace');
				 
				// args
				$args = array(
							'posts_per_page' 	=> 10, 
							'post_type' 		=> 'ppt_campaign', 
							'orderby' 			=> 'rand', 
							'order' 			=> 'desc',
							'post_status'		=> 'publish',
							'meta_query' => array(
								array(
									'key'     => 'location',
									'value'   => $banner_key,
									'compare' => '=',
								),							
								
								array(
									'key'     => 'status',
									'value'   => "active",
									'compare' => '=',
								),
							),
				);
				 					 
				$wp_query1 = new WP_Query($args); 
				 
				$tt = $wpdb->get_results($wp_query1->request, OBJECT);	
			  		
				if(!empty($tt)){
				
					// GET RANDOM BANNER
					$tc = count($tt);
					if($tc > 1){
						$randomID = rand(0,$tc-1);
					}else{
						$randomID = 0;
					}
					
					// RANDOM BANNER ID
					$RanBannerID = $tt[$randomID]->ID;					  
				
					// GET BANNER
					$bannerID = get_post_meta($RanBannerID,"bannerid",true);
					$code = get_post_meta($RanBannerID,"code",true);
					
					if(strlen($code) > 1){
					
					$OUTINNER .= $code; 
					
					$CORE->ADVERTISING("update_impressions", $RanBannerID);
					
					}elseif(is_numeric($bannerID)){ 
					
					$img = $CORE->ADVERTISING("banner_image", $bannerID);
					$OUTINNER .= '<a href="'.$CORE->ADVERTISING("get_banner_link", $RanBannerID).'">
					<img src="'.$img.'" alt="banner" class="sellspace img-fluid" />
					</a>';
					
					$CORE->ADVERTISING("update_impressions", $RanBannerID);
					
					} 
					 
				
				// DISPLAY SAMPLE BANNERS IF REQUIRED
				}elseif( isset($sellspacedata[$banner_key."_sample"]) && $sellspacedata[$banner_key."_sample"] ){						
					 
						// CHECK FOR A CUSTOM LINK							 
						$adlink = _ppt(array('links','sellspace'));
							
						$size = $sellspacedata[$banner_key.'_size'];
						$size_parts = explode("x", $size);				
						$width = $size_parts[0];
						$heigth = $size_parts[1];
							
						// CHECK FOR SAMPLE BANNER
						if( _ppt('samplebanner_'.$width.'x'.$heigth) != "" && substr( _ppt('samplebanner_'.$width.'x'.$heigth) ,0,4) == "http"){ 
							
							$OUTINNER .= '<a href="'.$adlink.'?selladd=1&amp;ad='.$banner_key.'" target="_blank">
							<img src="'._ppt('samplebanner_'.$width.'x'.$heigth).'" alt="samplebanner_'.$width.'_'.$heigth.' " class="sellspace_banner w-100 banner_'.$width.'_'.$heigth.' img-fluid" />
							</a>';
							
						}else{
							
							$OUTINNER .= '<a href="'.$adlink.'?selladd=1&amp;ad='.$banner_key.'">
							<div class="sellspace_banner banner_'.$width.'_'.$heigth.' text-center hidden-xs hidden-sm w-100 mx-auto y-middle" style="max-width:'.$width.'px; height:'.$heigth.'px;">
							<div class="title">'.__("Advertise Here","premiumpress").'</div>';
							if($width > 300){ $OUTINNER .= '<div class="pricing">'.__("view pricing","premiumpress").'</div>'; }
							$OUTINNER .= '</div></a>'; 
							
						}
				}			
			 
				return "<div class='sellspace-live'>".$OUTINNER."</div>";
			
		}
		
		case "banner_image": {
		
		return get_the_excerpt($order_data);
		
		} break;
		
		case "banner_name": {
		
		return get_the_title($order_data);
		
		} break;
		
		case "banner_data": {
		
			return array(
				'name' => get_the_title($order_data), 
				'img' => get_the_excerpt($order_data), 
				'w' => get_post_meta($order_data, 'width', true), 
				'h' => get_post_meta($order_data, 'height', true),
				'size' => get_post_meta($order_data, 'size', true) 
			);					 
		
		} break;
		
		
	}
 
}
	
}

?>