<?php
 
class framework_layout extends framework_functions {

	public $all_admin_layouts;
	
	
	function _ppt_home_url(){
	
		if(isset($_SERVER['HTTPS'])) {
			if ($_SERVER['HTTPS'] == "on") {
				return str_replace("http://","https://",home_url());
			}
		}
	
		return home_url();
	
	}

	function _wp_head(){
	 	
		if(!is_admin()){
		echo "<style>.preload-hide { display:none; }</style>";
		}		
	}

	function _elementor_scripts($pagekey = ""){	global $post;
	 
			
		// ELEMENTOR
		if( defined('ELEMENTOR_VERSION') ){
		 	
				wp_register_style( 'elementor-global', $this->_ppt_home_url().'/wp-content/uploads/elementor/css/global.css');	 
				wp_enqueue_style( 'elementor-global' );
				
				wp_register_style( 'elementor-frontend', $this->_ppt_home_url().'/wp-content/plugins/elementor/assets/css/frontend.min.css');	 
				wp_enqueue_style( 'elementor-frontend' ); 
				 	
				if(defined('ELEMENTOR_PRO_VERSION')){
				wp_register_style( 'elementorpro-frontend', $this->_ppt_home_url().'/wp-content/plugins/elementor-pro/assets/css/frontend.min.css');	 
				wp_enqueue_style( 'elementorpro-frontend' );
				}	
				
				if(isset($post->ID)){
				
					$valid = _ppt(array('pageassign', $pagekey ));
					if(strlen($valid) > 5 && strpos($valid,"elementor") !== false ){
						
						$elementor_page_id = str_replace("elementor-","", $valid);
						
						$uploads = wp_upload_dir();
						
						//_elementor_css
						  
						if( is_numeric($elementor_page_id) && file_exists( $uploads['basedir'].'/elementor/css/post-'.$elementor_page_id.'.css') ){	
										
								wp_register_style( 'elementor-post-'.$elementor_page_id, $uploads['baseurl'].'/elementor/css/post-'.$elementor_page_id.'.css');	 
								wp_enqueue_style( 'elementor-post-'.$elementor_page_id );	
								
								/*echo "<script>jQuery(document).ready(function(){ jQuery('body').addClass('elementor-kit-".$elementor_page_id."'); });</script>";	*/		
						}				
						
						
					
					}
					
				}
				
		}
				
	}
	
	function _enqueue_scripts(){
		
		global $pagenow, $userdata, $wp_styles, $CORE, $post; 
			
				// LOAD IN FRAMEWORK CSS
				$css 	= 	array();  						
				$js 	= 	array();  
				$extra_css 	= 	array();			
			 
				// LOAD IN FRAMEWORK JS				 						
				$js[] 	=  	FRAMREWORK_URI.'js/js.bootstrap.js';			
				$js[] 	=  	FRAMREWORK_URI.'js/js.plugins.js';	
				 
				if(!is_admin() && is_array($wp_styles->queue) && !empty($wp_styles->queue)){
					foreach($wp_styles->queue as $g){
				 
						if($g == "elementor-common"){
												 
							wp_dequeue_style( 'elementor-common' );						
							$extra_css["elementor-common"] = $wp_styles->registered['elementor-common']->src;	
						
						}elseif($g == "elementor-icons"){
						
							wp_dequeue_style( 'elementor-icons' );						
							$extra_css["elementor-icons"] = $wp_styles->registered['elementor-icons']->src;	
							
						}						
						
					}
				}
				
				
				// ELEMENTOR
				if(isset($_GET['post_type']) && $_GET['post_type'] == "elementor_library"){ 
				
				wp_enqueue_script('premiumpress-globals', FRAMREWORK_URI.'admin/js/elementor.js');
				
				}
				
				// BOOTSTRAP
				if($CORE->GEO("is_right_to_left", array() )){ 
					$css["bootstrap"] 	=  	FRAMREWORK_URI."css/_bootstrap-rtl.css"; 
				}else{ 
					$css["bootstrap"] 	=  	FRAMREWORK_URI."css/_bootstrap.css"; 
				}  
 				
				// PREMIUMPRESS
				$css['_fonts'] 			=  	FRAMREWORK_URI."css/_fonts.css"; 
				$css['_fontawesome'] 	=  	FRAMREWORK_URI."css/_fontawesome.css"; 
				$css['_plugins'] 		=  	FRAMREWORK_URI."css/_plugins.css"; 				
				$css['_responsive'] 	=  	FRAMREWORK_URI."css/_responsive.css"; 				
				$css[] 					=  	FRAMREWORK_URI."css/css.premiumpress.css"; 
				
				// EXTRAS
				if(!is_admin() && $userdata->ID ){
					$css[] 	=  	FRAMREWORK_URI."css/_account.css"; 
				} 
				
				if(( !$CORE->isMobileDevice() && defined('THEME_KEY') && !in_array(THEME_KEY, array("dt","sp","cm","cp","vt","jb","rt","so","cp","ph","es")) ) && !is_admin() && $userdata->ID && in_array(_ppt(array('user','friends')), array("","1")) && _ppt(array("comchat","msg_enable")) != 1 && $CORE->USER("get_subscribers_followers_count", $userdata->ID) > 0 ){				
					$css[] 	=  	FRAMREWORK_URI."css/_chat.css";
				}
				
				// POPUPS
				if( ( defined('THEME_KEY') && in_array(THEME_KEY, array("exxxxxxxxx")) ) || ( is_admin() || !is_admin() && !defined('WLT_DEMOMODE') ) ){
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-popups.js';
				}
				
				if( _ppt(array('search','typehead')) == 1 || ( defined('WLT_DEMOMODE') && defined('THEME_KEY') && THEME_KEY == "cp" ) ) {
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-typeahead.js';	
				}
				
				if( defined('THEME_KEY') && !in_array(THEME_KEY, array("sp") )  ){
				$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-rating.js';	
				}
				
				// EXTRA ADDON STYLES				
				if(isset($GLOBALS['flag-singlepage']) ||  isset($_GET['preview']) ||  ( isset($_GET['action']) && $_GET['action'] == "elementor") || isset($_POST['actions']) ){
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-sliders.js';	
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-single.js';			
				}
				
				// CART
				if(defined('WLT_CART')){
					$css['cart'] 	=  	FRAMREWORK_URI."css/_cart.css"; 
					$js[] 	= 	FRAMREWORK_URI.'js/js.cart.js';
				}
								
				// UPLOADER
				if(isset($GLOBALS['flag-add']) || ( is_admin() && isset($_GET['page'])) && in_array($_GET['page'], array("listings") ) ){
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-upload.js';										
					$css[] 	=  	FRAMREWORK_URI.'css/_submitform.css'; 																			
				}
				
				// DATE PICKER
				if(isset($GLOBALS['flag-add']) || ( is_admin() && isset($_GET['page'])) && in_array($_GET['page'], array("listings","email","orders","cashout","advertising","cashback") ) ){
								
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-datepicker.js';
				}			 
				
				// COOKIES
				if( !is_admin() && ( _ppt(array('adultwarning','enable')) == 1 || _ppt(array('gdpr','enable')) == 1 ) ){ 
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-cookie.js';								
				}
				
				// LOGGED IN
				if( is_admin() || $userdata->ID ){ 
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-notify.js';								
				}
				
				// CURRENCY
				//if( is_admin() || _ppt(array('currency','code')) != "USD" || ( isset($GLOBALS['flag-single']) && defined('THEME_KEY') && in_array(THEME_KEY, array("mj")) ) ){ 
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-currency.js';								
				//}					
				
				// COUNTDOWNS AND TIMERS
				if( ( defined('THEME_KEY') && in_array(THEME_KEY, array("at","cp")) )  || isset($GLOBALS['flag-account'])  || isset($GLOBALS['flag-add']) || ( is_admin() && isset($_GET['page'])) && in_array($_GET['page'], array("listings","members") ) ){ 
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-countdown.js';								
				}				 
				
				// CHARTS
				if( isset($GLOBALS['flag-account']) || ( is_admin() && isset($_GET['page'])) && in_array($_GET['page'], array("premiumpress","email") ) ){				
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-charts.js'; 
				}
				
				// MAPS
				if(!is_admin() && $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1 && ( isset($GLOBALS['flag-home']) || isset($GLOBALS['flag-search']) || ( isset($GLOBALS['flag-single']) && !in_array(THEME_KEY, array("es")) ) ) ){ 	
				 			 
					
					if(_ppt(array("maps","provider")) == "mapbox"){
					
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-map-mapbox.js';
					$css["mapbox"] 	=  	"https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css"; 
					wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js');
					wp_enqueue_script('mapbox-geo', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js');
					 
					
					}elseif(_ppt(array("maps","provider")) == "google"){
					
					$js[] 	=  	FRAMREWORK_URI.'js/js.plugins-map.js';
					
					}
					
				} 
				
				
				/// LOAD LAST
				$js[] 	=  	FRAMREWORK_URI.'js/js.custom.js';			
				$js[] 	=  	FRAMREWORK_URI.'js/js.search.js';	
				
				
				if(( !$CORE->isMobileDevice() && defined('THEME_KEY') && !in_array(THEME_KEY, array("dt","sp","cm","cp","vt","rt","so","jb","cp","ph","es")) ) && !is_admin() && $userdata->ID && in_array(_ppt(array('user','friends')), array("","1")) && _ppt(array("comchat","msg_enable")) != 1  && $CORE->USER("get_subscribers_followers_count", $userdata->ID) > 0 ){
				
				$js[] 	=  	FRAMREWORK_URI.'js/js.chat.js';			
 				
				}
 
 			/*********************************************************************************************/
			/* LIVE PREVIEW	
			/*********************************************************************************************/
			
		
 			if(  _ppt_livepreview() || get_page_template_slug() == "elementor_canvas" && !isset($_GET['tabs_group']) ){
		  
				// JQUERY
				wp_enqueue_script('jquery', includes_url( '/js/jquery/jquery.js' ),false); 
				
				// LOAD CSS
				$i=1;
				foreach($css as $key => $file){					   
					wp_enqueue_style('premiumpress'.$i, $file, array(), THEME_VERSION );
					$i++;			 
				}
				
				// LOAD JS
				$i=1;
				foreach($js as $key => $file){					   
					wp_enqueue_script('premiumpress'.$i, $file, array(), THEME_VERSION );
					$i++;			 
				} 
				
				return;
			 
            
			/*********************************************************************************************/
			/* ADMIN AREA		
			/*********************************************************************************************/
			
 			}elseif( is_admin()  ){
			 
				 
				// ELEMENTOR
				wp_enqueue_script('premiumpress-globals', FRAMREWORK_URI.'admin/js/elementor.js'); 
				
				
				if( 
				
				isset($GLOBALS['new_admin_menu']) && isset($_GET['page']) && substr($_GET['page'],0,3) == "v10" ||
				
				 isset($_GET['page']) && in_array($_GET['page'], array("premiumpress","settings","docs","orders","listings","reports","advertising","cashout","cashback","members","email","design","plugins","cart","getting-started","customfields","massimport","membershipsetup","listingsetup")) 
				 
				 ){
				  
					// GLOBAL STYLES 
					wp_enqueue_style("premiumpress-globals", FRAMREWORK_URI.'admin/css/wpglobal.css');					
				  
					// INCLUDE POP-UP MEDIA BOX
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_style('thickbox'); 
				   
					// LOAD IN OPTIONS FOR SORTING DATA					
					wp_enqueue_script( 'jquery-ui-sortable' );
					wp_enqueue_script( 'jquery-ui-draggable' );
					wp_enqueue_script( 'jquery-ui-droppable' );	
							
					
					$css[] 	=  	FRAMREWORK_URI.'css/_bootstrap.css';	
					$css[] 	=  	FRAMREWORK_URI.'css/css.premiumpress.css';						
					
					// ADMIN EXTRAS
					$js[] 	=  	FRAMREWORK_URI.'admin/js/admin.js';					
					$css[] 	= 	FRAMREWORK_URI.'admin/css/premiumpress.css'; /* ADMIN STYLES !! */
				 	 
					// LOAD CSS
					$i=1;
					foreach($css as $key => $file){					   
						wp_enqueue_style('premiumpress'.$i, $file, array(), THEME_VERSION );
						$i++;			 
					} 
					
					// LOAD JS
					$i=1;
					foreach($js as $key => $file){					   
						wp_enqueue_script('premiumpress'.$i, $file, array(), THEME_VERSION, $footer = false);
						$i++;			 
					} 
					
					
				}
				
				// RETURN
				return;
			}			 
	
			/*********************************************************************************************/
			/* FONTEND STYLES	
			/*********************************************************************************************/
			
				wp_enqueue_script('jquery', includes_url( '/js/jquery/jquery.js' ),false, THEME_VERSION ); //, THEME_VERSION, $footer = true
				
				
				if(_ppt(array("design","preloader")) == "0"){
				
					$GLOBALS['footer-css'] = "";
					$GLOBALS['footer-css-extra'] = "";
					
					// LOAD CSS
					$i=1;
					foreach($css as $key => $file){					   
						wp_enqueue_style('premiumpress'.$i, $file, array(), THEME_VERSION );
						$i++;			 
					} 
					
					// LOAD JS
					$i=1;
					foreach($js as $key => $file){					   
						wp_enqueue_script('premiumpress'.$i, $file, array(), THEME_VERSION, $footer = false);
						$i++;			 
					}				
				
				
				}else{
					
					// LOAD JS IN FOOTER
					$GLOBALS['footer-css'] = $css;
					$GLOBALS['footer-css-extra'] = $extra_css;
					
						
					// LOAD JS
					$i=1;
					foreach($js as $key => $file){					   
						wp_enqueue_script('premiumpress'.$i, $file, array(), THEME_VERSION, $footer = true);
						$i++;			 
					}
				
				}
				

			/*********************************************************************************************/
			/* DEREGISTER OTHERS
			/*********************************************************************************************/
					
					
				// REMOVE BLOCK EDITOR
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' ); 
						
				
				return;
		 
	}
 

	function LAYOUT($action='add', $order_data){
 
 
	
	
	global $userdata, $wpdb, $CORE;
 
	switch($action){ 
	
	case "default_search_type": {
	
		if(in_array(THEME_KEY, array("pj")) ){	
			return "list1";
		}
	
		switch($order_data){
			case "1": { $t = "grid5"; } break;
			case "2": { $t = "list3"; } break;
			case "3": { $t = "grid4"; } break;
			case "4": { $t = "list2"; } break;			
			case "5": { $t = "grid4a"; 
			
			if($CORE->ADVERTISING("check_exists", "search_side") ){
			
			$t = "grid3";
			}
			
			if(in_array(THEME_KEY, array("dl")) ){
			$t = "grid3";
			}
			
			} break; // sidebar
			case "6": { $t = "list1"; } break; // sidebar
			case "7": { $t = "grid3"; } break;
			case "8": { $t = "list1"; } break;
			
		 }
		 
		 return $t;
	
	}
	
		case "get_demo_categories": {
		
			$categories = array(
				"dl" => array(
					
					"dl_cars" => "Auto Trader", 
					"dl_dealership" => "Car Dealership", 
					
					"dl_boats" => "Boat Trader",
					"dl_motorbike" => "Bike Trader", 
					"dl_bikes" => "BMX/ Bikes",	
					//"dl_vintage" => "Vintage Cars",	
					"dl_trucks" => "Trucks &amp; Vans",	
					 
					
				),
				
				"sp" => array( 
					
					"sp_fashion" => "Fashion", 
					"sp_jewelry" => "Jewelry", 
					"sp_glasses" => "Glasses",
					"sp_furniture" => "Furniture", 
					"sp_tools" => "Tools",					 
					"sp_pets" =>"Pets",
				 
					
				),
				
				"ct" => array(
				
				
				
					"ct_yard" 	=> "Yard Sale Concept",
					"ct_local" 		=> "Local City Ads",					
					"ct_market" 	=> "Market Place",					
					"ct_classic" 	=> "Classic Ads",	
					"ct_pets" 		=> "Pets",
					"ct_clean" 		=> "Clean",						
					//	"ct_map" 		=> "Map",						
					"ct_compact" 	=> "Compact",
					
				),
				
				"cm" => array(				
					"cm_style1" 	=> "Style 1",
				 	"cm_style2" 	=> "Style 2", 
					"cm_style3" 	=> "Style 3", 
				),
				
				"cp" => array(
					
					"cp_cashback" 	=> "Cashback Website Example",					
					"cp_style0" 	=> "Product Discounts Example", 					
					"cp_clean" 		=> "General Coupon Website Example",					
					"cp_style3" 	=> "Fashion/Retail Coupon Website", 	
					"cp_tools" 		=> "Affiliate Coupon Website Example", 				
					"cp_style1" 	=> "Hosting Coupons Example",
				 	"cp_style4" 	=> "Website Hosting Example",					
				),
				
				"mj" => array(				
				 	
					"mj_fiv" 		=> "Ready-Made Style 1",					
					"mj_style1" 	=> "Ready-Made Style 2",
					"mj_style3" 	=> "Ready-Made Style 3",
					"mj_style2" 	=> "Ready-Made Style 4",		 
					"mj_compact" 	=> "Ready-Made Style 5",
					 
				),
				
				"da" => array(
				
					"da_single" 	=> "Ready-Made Style 1",
					"da_style2" 	=> "Ready-Made Style 2", 
					"da_style3" 	=> "Ready-Made Style 3", 					
					"da_style4" 	=> "Ready-Made Style 4",
					"da_style1" 	=> "Ready-Made Style 5",
				),
				
				"rt" => array(					
					
					"rt_style1" 	=> "Ready-Made Style 1",
					"rt_style2" 	=> "Ready-Made Style 2",
					"rt_style3" 	=> "Ready-Made Style 3",
					"rt_compact" 	=> "Ready-Made Style 4",
					"rt_style0" 	=> "Ready-Made Style 5",
					
				),
				
				"jb" => array(
				
					"jb_style1" 	=> "Ready-Made Style 1",
					"jb_compact" 	=> "Ready-Made Style 2",
					"jb_style3" 	=> "Ready-Made Style 3",
					"jb_style4" 	=> "Ready-Made Style 4",
					
				),
				
				"at" => array(
																		
					"at_style1" 	=> "Ready-Made Style 1",					
					"at_yard" 		=> "Ready-Made Style 2",										
					"at_style4" 	=> "Ready-Made Style 3",
					"at_compact" 	=> "Ready-Made Style 4",					
					"at_style3" 	=> "Ready-Made Style 5",
					
				),
				
			
				
				"dt" => array(
					
					
					"dt_classic" 	=> "Example - Link Directory (screenshots API)",					
					"dt_country" 	=> "Example - Country Directory (no maps API)",
					
					"dt_niche" 	=> "Example - Niche Directory (with services)",
					
                   
                    
					"dt_style1" 	=> "Style 1",
					"dt_style2" 	=> "Style 2",
					"dt_style3" 	=> "Style 3",					
					"dt_city" 		=> "Style 4",
                    
					"dt_compact" 	=> "Compact",
					
					//"childtheme_dt" 	=> "Child Themes",
					 
				),
				
				"vt" => array(
				
					"vt_style0" 	=> "Community",
					"vt_style1" 	=> "Style 1",
					"vt_style2" 	=> "Style 2",
					"vt_style3" 	=> "Style 3",					 
					 
				),
				
				"so" => array(
				
					"so_style1" 	=> "General Downloads",					
					"so_style2" 	=> "Classic PHP Scripts",					
					"so_style3" 	=> "WordPress Themes",
				),
				
				"pj" => array(
				
					"pj_style1" 	=> "Style 1",					
					"pj_style2" 	=> "Style 2",					
					"pj_style3" 	=> "Style 3",
				),
				
				"bo" => array(
				
					"bo_style1" 	=> "Style 1",					
					 
				),
				
				"ex" => array(
				
					"ex_style1" 	=> "Style 1",					
					 
				),
				
				"ph" => array(
				
					"ph_style1" 	=> "General",
						
					"ph_style2" 	=> "Sports Stock",
						
					"ph_style3" 	=> "Wedding Stock",
						
					"ph_style4" 	=> "Food Stock",	
					
					
									
					 
				),
				
				"es" => array(				
				
					"es_style0" 	=> "Style 1",						
					"es_style3" 	=> "Style 2",
					"es_style2" 	=> "Style 3",						
					"es_style1" 	=> "Style 4",
				),				
				
				"ll" => array(
				
					"ll_style1" 	=> "Style 1",
					//"ll_style2" 	=> "Style 2",				
					 
				),
				
			);
			
			return $categories;
		
		
		} break;
		
		case "captions": {
		
		
		$themeoptions = array(





		"ph" => array(
				"1" 	=> __("Photo","premiumpress"),
				"2" 	=> __("Photos","premiumpress"),	
				
				"icon"	=> "fal fa-camera",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> false,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
				
				"account_offer1" => "",
				"account_offer2" => "", 
				
				"add" => __("Add Item","premiumpress"),				
				"add_title" => __("eg. Landscape photo of New York","premiumpress"),
				 
				
				"desc" => "Build your own stock photo website today!",
				"demo_design" => "ph_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	 "rating1" => __("My Rating","premiumpress"),		
				),
				
				"filters" => array(	
					"category", "taxonomy","keyword","showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-stock-photography-theme/", 
				
				
			),
		
		
		"at" => array(
				"1" 	=> __("Auction","premiumpress"),
				"2" 	=> __("Auctions","premiumpress"),	
				
				"icon"	=> "fal fa-gavel",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => __("Bid Now","premiumpress"),
				"offer" => __("Bid","premiumpress"),
				"offers" => __("Bids","premiumpress"),
				
				"account_offer1" => __("Bidding","premiumpress"),
				"account_offer2" => __("Items Won","premiumpress"),
				
				
				
				"add" => __("Add Auction","premiumpress"),				
				"add_title" => __("eg. Tesla Model X","premiumpress"),
				 
				
				"desc" => "Build your own auction website today!",
				"demo_design" => "at_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Value for money","premiumpress"),
					"rating2" => __("Quality","premiumpress"),
					"rating3" => __("Packaging","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country", "price","category", "taxonomy","keyword","showonly"	
				), 
				
				"link" => "https://www.premiumpress.com/wordpress-auction-theme/", 
				 
			),
			
			
	"ex" => array(
				"1" 	=> __("Profile","premiumpress"),
				"2" 	=> __("Profiles","premiumpress"),	
				
				"icon"	=> "fal fa-gavel",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => __("Bid Now","premiumpress"),
				"offer" => __("Bid","premiumpress"),
				"offers" => __("Bids","premiumpress"),
				
				"account_offer1" => __("Bidding","premiumpress"),
				"account_offer2" => __("Items Won","premiumpress"),
				
				
				
				"add" => __("Add Profile","premiumpress"),				
				"add_title" => "",
				 
				
				"desc" => "Build your own language exchange community.",
				"demo_design" => "ex_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Value for money","premiumpress"),
					"rating2" => __("Quality","premiumpress"),
					"rating3" => __("Packaging","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"category", "usertype", "showonly"	
				), 
				
				"link" => "https://www.premiumpress.com/wordpress-auction-theme/", 
				
				
				
			),
			
			
			
		
		"bo" => array(
				"1" 	=> __("Booking","premiumpress"),
				"2" 	=> __("Bookings","premiumpress"),	
				
				"icon"	=> "fal fa-gavel",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => __("Book Now","premiumpress"),
				"offer" => __("Bookings","premiumpress"),
				"offers" => __("Bookings","premiumpress"),
				
				"account_offer1" => __("Bookings","premiumpress"),
				"account_offer2" => __("Items Booked","premiumpress"),
				 	
				
				"add" => __("Add Auction","premiumpress"),				
				"add_title" => __("eg. Tesla Model X","premiumpress"),
				 
				
				"desc" => "Build your own booking website today!",
				"demo_design" => "bo_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Value for money","premiumpress"),
					"rating2" => __("Quality","premiumpress"),
					"rating3" => __("Packaging","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price","category", "taxonomy","keyword","showonly"	
				), 
				
				"link" => "https://www.premiumpress.com/wordpress-auction-theme/", 
				
				
				
			),
		
			
			"dl" => array(
				"1" 	=> __("Car","premiumpress"),
				"2" 	=> __("Cars","premiumpress"),	
				
				"icon"	=> "fal fa-car",				
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => __("Make Offer","premiumpress"),
				"offer" => __("Offer","premiumpress"),
				"offers" => __("Offers","premiumpress"),
				
				"account_offer1" => __("Offers Made","premiumpress"),
				"account_offer2" => __("Offers Accepted","premiumpress"),
				
				
				"add" => __("Sell Car","premiumpress"),
				"add_title" => __("eg. 2007 Ford Mustang","premiumpress"),
				
				"desc" => "Build your own car dealership or Auto Trader website.",
				"demo_design" => "cars1",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 4,
				
				"rating" => array(	
					"rating1" => __("Value for money","premiumpress"),
					"rating2" => __("Interior","premiumpress"),
					"rating3" => __("Exterior","premiumpress"),
					"rating4" => __("Drive & Handling","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price","category", "taxonomy", "year", "keyword","showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-car-dealer-theme/", 
				
				
			),
			
			"sp" => array(
				"1" 	=> __("Product","premiumpress"),
				"2" 	=> __("Products","premiumpress"),	
				
				"icon"	=> "fal fa-tshirt",
				"maps"	=> false,
				"memberships" => false,
				"listings" => false,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
				
				"account_offer1" => "",
				"account_offer2" => "",
				
				"add_title" => __("eg. Microsoft Surface Laptop","premiumpress"),
				
				"desc" => "Build online stores or affiliate websites in minutes!",
				"demo_design" => "sp_fashion1",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Packaging","premiumpress"),
					"rating3" => __("Delivery","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"price","category", "taxonomy", "keyword", "showonly"	
				),
				
				
				"link" => "https://www.premiumpress.com/wordpress-shop-theme/", 
				
				 
					
			),
			
			
		"ll" => array(
				"1" 	=> __("Course","premiumpress"),
				"2" 	=> __("Courses","premiumpress"),	
				
				
				"icon"	=> "fal fa-heart",
				"icon-offer"	=> "fal fa-image",
				
				"maps"	=> false,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => __("Enroll Now","premiumpress"),
				"offer" => __("Application","premiumpress"),
				"offers" => __("Applications","premiumpress"),
				
				"add" => __("Add Course","premiumpress"),
				"add_title" => __("Introduction to Data Science","premiumpress"),
				
				"desc" => "Build an own e-learning website.",
				"demo_design" => "ll_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Enjoyment","premiumpress"),
					"rating3" => __("Interesting","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-lms-theme/", 
				
				
			),
			
			
			
			"so" => array(
				"1" 	=> __("Product","premiumpress"),
				"2" 	=> __("Products","premiumpress"),	
				
				"icon"			=> "fal fa-download",
				"maps"			=> false,
				"memberships" 	=> true,
				"listings" 		=> true,
				"youtube" 		=> true,
				"cashout" 		=> true,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",	
				
				"add_title" => __("eg. Windows Antivirus Software","premiumpress"),			
				
				"desc" => "Digital download websites in minutes!",
				"demo_design" => "so_style1",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Packaging","premiumpress"),
					"rating3" => __("Delivery","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"price","category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-digital-download-theme/", 
				
				 
					
			),
			
			
			"cm" => array(
				"1" 	=> __("Product","premiumpress"),
				"2" 	=> __("Products","premiumpress"),	
				
				"icon"	=> "fal fa-tshirt",
				"maps"	=> false,
				"memberships" => false,
				"listings" => true,
				"cashout" => false,
				"youtube" => true,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
				
				"add_title" => __("eg. Microsoft Surface Laptop","premiumpress"),
				
				"desc" => "Build your own price comparison website.",
				"demo_design" => "cm_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 4,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Packaging","premiumpress"),
					"rating3" => __("Delivery","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"price","category", "taxonomy", "rating", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-price-comparison-theme/", 
				
					
			),
			
			"ct" => array(
				"1" 	=> __("Ad","premiumpress"),
				"2" 	=> __("Ads","premiumpress"),	
				
				"icon"	=> "fa fa-megaphone",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				 
				"offerbtn" => __("Make Offer","premiumpress"),
				"offer" => __("Offer","premiumpress"),
				"offers" => __("Offers","premiumpress"),
				
				"account_offer1" => __("Offers Made","premiumpress"),
				"account_offer2" => __("Items Won","premiumpress"),
				
				
				"add" => __("Post Ad","premiumpress"),
				"add_title" => __("eg. Used Microsoft Surface Laptop","premiumpress"),
				
				"desc" => "Start a classifieds website today!",
				"demo_design" => "ct_pets3",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Price","premiumpress"),
					"rating3" => __("Value for money","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price","category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-classifieds-theme/", 
				
				
			),	
			
			"cp" => array(
				"1" 	=> __("Coupon","premiumpress"),
				"2" 	=> __("Coupons","premiumpress"),	
				"icon"	=> "fal fa-tag",
				
				"maps"	=> false,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
				
				"account_offer1" => "",
				"account_offer2" => "",
				
				"add" => __("Add Coupon","premiumpress"),
				"add_title" => __("eg. Save 10% at BestBuy.com","premiumpress"),
				
				"desc" => "Build your own coupon website today!",
				"demo_design" => "cp_style3c",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Discount","premiumpress"),
					 	
				),
				
				"filters" => array(	
					"category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-coupon-theme/", 
				
				
			),
			
			"da" => array(
				"1" 	=> __("Profile","premiumpress"),
				"2" 	=> __("Profiles","premiumpress"),	
				
				
				"icon"	=> "fal fa-heart",
				"icon-offer"	=> "fal fa-image",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => "", //__("Match Now","premiumpress"),
				"offer" => "", //__("Request","premiumpress"),
				"offers" => "", //__("Requests","premiumpress"),
				
				"add" => __("Add Profile","premiumpress"),
				"add_title" => __("Jane_Doe_USA","premiumpress"),
				
				"desc" => "Build your own online dating website today!",
				"demo_design" => "da_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => false,
				
				"filters" => array(	
					"distance", "country", "age", "category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-dating-theme/", 
				
				
			),
			
			"es" => array(
				"1" 	=> __("Profile","premiumpress"),
				"2" 	=> __("Profiles","premiumpress"),	
				
				
				"icon"	=> "fal fa-heart",
				"icon-offer"	=> "fal fa-image",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => "", //__("Match Now","premiumpress"),
				"offer" => "", //__("Request","premiumpress"),
				"offers" => "", //__("Requests","premiumpress"),
				
				"add" => __("Add Profile","premiumpress"),
				"add_title" => __("Jane_Doe_USA","premiumpress"),
				
				"desc" => "Build your own escort agency website today!",
				"demo_design" => "es_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => false,
				
				"filters" => array(	
					"distance", "country", "age", "category", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpress-escort-theme/", 
				
				
			),
			
			
			"mj" => array(
				"1" 	=> __("Job","premiumpress"),
				"2" 	=> __("Jobs","premiumpress"),
					
				"icon"	=> "fal fa-briefcase",
				"icon-offer"	=> "fal fa-file-invoice-dollar",
				
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => true,
				
				"offerbtn" => __("Buy Now","premiumpress"),
				"offer" => __("Order","premiumpress"),
				"offers" => __("Orders","premiumpress"),
				
				"account_offer1" => __("Orders","premiumpress"),
				"account_offer2" => __("Accepted","premiumpress"),
				
				
				"add" => __("Post Job","premiumpress"),
				"add_title" => __("e.g I will build you a WordPress website.","premiumpress"),
				
				"desc" => "Start your own micro jobs website right now!",
				"demo_design" => "mj_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,
				
				"rating" =>  array(),
				
				"filters" => array(	
					"price", "category", "taxonomy", "rating", "keyword", "showonly" //"days", 	
				),
				
				
				"link" => "https://www.premiumpress.com/wordpress-micro-jobs-theme/", 
				
				
			),	
			
		
		"dt" => array(
				"1" 	=> __("Auction","premiumpress"),
				"2" 	=> __("Auctions","premiumpress"),
					
				"icon"	=> "fal fa-sign",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true,
				"memberships" => true,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
				
				"add" => __("Add Business","premiumpress"),
				"add_title" => __("eg. Frankys Burger Restaurant","premiumpress"),
				
			 
				"desc" => "Build your own directory website.",
				"demo_design" => "dt_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",	
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Price","premiumpress"),
					"rating3" => __("Value for money","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country", "countrylist", "category",  "rating", "taxonomy", "keyword", "showonly"	
				),
				
				"link" => "https://www.premiumpress.com/wordpressdirectory-theme/", 
				
				
			),
			
			
			"rt" => array(
				"1" 	=> __("Home","premiumpress"),
				"2" 	=> __("Homes","premiumpress"),
				
				"icon"	=> "fal fa-home",
				"icon-offer"	=> "fal fa-clock",
				
				"maps"	=> true,
				"memberships" => false,
				"listings" => true,
				"youtube" => false,
				"cashout" => false,
				
				"offerbtn" => __("Book Viewing","premiumpress"),
				"offer" => __("Viewing","premiumpress"),
				"offers" => __("Viewings","premiumpress"),
				
				"account_offer1" => __("Viewings","premiumpress"),
				"account_offer2" => __("Accepted","premiumpress"),
				
				"add" => __("Add Home","premiumpress"),
				"add_title" => __("eg. 4 Bedroom Detached House Near London","premiumpress"),
				
				"desc" => "Start your own real estate website today!",
				"demo_design" => "rt_style2a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,	
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Price","premiumpress"),
					"rating3" => __("Value for money","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price","category", "taxonomy", "keyword", "showonly"	
				),	
				
					"link" => "https://www.premiumpress.com/wordpress-real-estate-theme/", 
				
						
			),	
			
			
			"jb" => array(
			
				"1" 			=> __("Job","premiumpress"),
				"2" 			=> __("Jobs","premiumpress"),
				
				"offerbtn" 		=> __("Apply Now","premiumpress"),
				"offer" 		=> __("Interview","premiumpress"),
				"offers" 		=> __("Interviews","premiumpress"),
				
				"account_offer1" => __("Applied For","premiumpress"),
				"account_offer2" => __("Accepted","premiumpress"),
					
				"icon"				=> "fal fa-briefcase",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"			=> true,
				"memberships" 	=> true,
				"listings" 		=> true,
				"youtube" 		=> false,
				"cashout" 		=> false,
				
				"add" => __("Add Job","premiumpress"),
				"add_title" => __("eg. Full-time Staff Wanted Urgently","premiumpress"),
				
				"desc" => "Start your own Job Board website today!",
				"demo_design" => "job_style1a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,
				
				"rating" => array(	
					"rating1" => __("Location","premiumpress"),
					"rating2" => __("Salary","premiumpress"),
					"rating3" => __("Company","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price", "category", "taxonomy", "keyword", "showonly"	
				),	
				
				"link" => "https://www.premiumpress.com/wordpress-job-board-theme/", 
							
			),	
			
			"vt" => array(
			
				"1" 	=> __("Video","premiumpress"),
				"2" 	=> __("Videos","premiumpress"),
				
				"offerbtn" => "",
				"offer" => "",
				"offers" => "",
					
				"icon"	=> "fal fa-video",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> false, 
				"memberships" => true,
				"listings" => true,
				"youtube" => true,
				"cashout" => false,
				
				"add" => __("Add Video","premiumpress"),
				"add_title" => __("eg. Learn to cook steak in 5 minutes or less!","premiumpress"),
				
				"desc" => "Start a video website today!",
				"demo_design" => "vt_style0a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,	
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Enjoyment","premiumpress"),
					"rating3" => __("Interesting","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"rating", "category", "taxonomy", "keyword", "showonly"	
				),	
				
				"link" => "https://www.premiumpress.com/wordpress-video-theme/", 
				
						
			),
			
	"pj" => array(
			
				"1" 	=> __("Job","premiumpress"),
				"2" 	=> __("Jobs","premiumpress"),
				
				"offerbtn" 		=> __("Submit Offer","premiumpress"),
				"offer" 		=> __("Offer","premiumpress"),
				"offers" 		=> __("Offers","premiumpress"),
					
				"icon"				=> "fal fa-briefcase",
				"icon-offer"	=> "fal fa-hand-paper",
				
				"maps"	=> true, 
				"memberships" => true,
				"listings" => true,
				"youtube" => true,
				"cashout" => true,
				
				"add" => __("Add Job","premiumpress"),
				"add_title" => __("eg. I need a new website building.","premiumpress"),
				
				"account_offer1" => __("Offers","premiumpress"),
				"account_offer2" => __("Accepted","premiumpress"),
				
				
				"desc" => "Start a job/freelancer/task based website today!",
				"demo_design" => "pj_style0a",	
				
				"color1" => "#fdb819",
				"color2" => "",
				
				"perrow" => 3,	
				
				"rating" => array(	
					"rating1" => __("Quality","premiumpress"),
					"rating2" => __("Enjoyment","premiumpress"),
					"rating3" => __("Interesting","premiumpress"),
					"rating4" => __("Overall","premiumpress"),		
				),
				
				"filters" => array(	
					"distance", "country",  "price", "category", "taxonomy", "keyword", "showonly"	
				),	
				
				"link" => "https://www.premiumpress.com/wordpress-video-theme/", 
				
						
			),
						
		
		);
		
		
		if(!defined('THEME_KEY')){
			$data = $themeoptions["sp"];
		}else{
			$data = $themeoptions[THEME_KEY];
		} 
		
		if($order_data == "all"){
			return $data;
		}elseif(isset($data[$order_data])){		
			return $data[$order_data];		
		}else{
			return "";
		}
 		
		} break;
	
		case "get_fonttypes": {
		
			$fonttypes = array(
		
				"font_body" => array(
					"name" => "Body Font",
					"code" => "body ",
				),
				
				"font_logo" => array(
					"name" => "Logo Font",
					"code" => ".textlogo ",
				),
				
				"font_h1" => array(
					"name" => "Heading 1 Font",
					"code" => "h1, .h1, .grid .title",
				),
				
				"font_h2" => array(
					"name" => "Heading 2 Font",	
					"code" => "h2, .h2, .grid .subtitle",
				),
				
				"font_h3" => array(
					"name" => "Heading 3 Font",	
					"code" => "h3, .h3",
				),
				
				"font_h4" => array(
					"name" => "Heading 4 Font",	
					"code" => "h4, .h4",
				),
				
				"font_h5" => array(
					"name" => "Heading 5 Font",	
					"code" => "h5, .h5",
				),
				
				"font_h6" => array(
					"name" => "Heading 6 Font",	
					"code" => "h6, .h6",
				),
				
				"font_menu" => array(
					"name" => "Main Menu",	
					"code" => ".nav-link",
				),
				
				"font_btn" => array(
					"name" => "Button Font",	
					"code" => ".btn",
				),
				
				
					
			
			);
			
			if(is_array($order_data) && empty($order_data)){
				return $fonttypes;
			}else{		
				return $fonttypes[$order_data];
			} 
		
		
		} break;
	
		case "get_fonts": {
		
		
$googleFonts = array('Inter', 'Plus Jakarta Sans', 'ABeeZee', 'Abel', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura', 'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amethysta', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 'Arial Black', 'Arial Narrow', 'Arimo', 'Arizonia', 'Armata', 'Artifika', 'Arvo', 'Asap', 'Asset', 'Astloch', 'Asul', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans', 'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Balthazar', 'Bangers', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Bell MT', 'Bell MT Alt', 'Belleza', 'BenchNine', 'Barlow', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'Bitter', 'Black Ops One', 'Bodoni', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buenard', 'Butcherman', 'Butcherman Caps', 'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Calibri', 'Calligraffitti', 'Cambo', 'Cambria', 'Candal', 'Cantarell', 'Cantata One', 'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Caudex', 'Cedarville Cursive', 'Ceviche One', 'Changa One', 'Chango', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Cinzel', 'Cinzel Decorative', 'Clara', 'Clicker Script', 'Coda', 'Codystar', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Consolas', 'Content', 'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Corsiva', 'Courgette', 'Courier New', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Creepster Caps', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'Dawning of a New Day', 'Days One', 'Delius', 'Delius Swash Caps', 'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Dhyana', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 'Domine', 'Donegal One', 'Doppio One', 'Dorsa', 'Dosis', 'Dr Sugiyama', 'Droid Arabic Kufi', 'Droid Arabic Naskh', 'Droid Sans', 'Droid Sans Mono', 'Droid Sans TV', 'Droid Serif', 'Duru Sans', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Eater Caps', 'Economica', 'Electrolize', 'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Engagement', 'Englebert', 'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script', 'Ewert', 'Exo', 'Expletus Sans', 'Fanwood Text', 'Fascinate', 'Fascinate Inline', 'Faster One', 'Fasthand', 'Fauna One', 'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint', 'Fjalla One', 'Fjord One', 'Flamenco', 'Flavors', 'Fondamento', 'Fontdiner Swanky', 'Forum', 'Francois One', 'Freckle Face', 'Fredericka the Great', 'Fredoka One', 'Freehand', 'Fresca', 'Fira sans','Frijole', 'Fruktur', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 'Gafata', 'Galdeano', 'Galindo', 'Garamond', 'Gentium Basic', 'Gentium Book Basic', 'Geo', 'Geostar', 'Geostar Fill', 'Germania One', 'Gilda Display', 'Give You Glory', 'Glass Antiqua', 'Glegoo', 'Gloria Hallelujah', 'Goblin One', 'Gochi Hand', 'Gorditas', 'Goudy Bookletter 1911', 'Graduate', 'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Habibi', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman', 'Happy Monkey', 'Headland One', 'Helvetica Neue', 'Henny Penny', 'Herr Von Muellerhoff', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC', 'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Irish Grover', 'Irish Growler', 'Istok Web', 'Italiana', 'Italianno', 'Jacques Francois', 'Jacques Francois Shadow', 'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 'Josefin Sans', 'Josefin Sans Std Light', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Julius Sans One', 'Junge', 'Jura', 'Just Another Hand', 'Just Me Again Down Here', 'Kameron', 'Karla', 'Kaushan Script', 'Kavoon', 'Keania+One', 'Kelly Slab', 'Kenia', 'Khmer', 'Kite One', 'Knewave', 'Kotta One', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Krona One', 'La Belle Aurore', 'Lancelot', 'Lateef', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 'Lekton', 'Lemon', 'Lemon One', 'Libre Baskerville', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 'Lobster Two', 'Lohit Bengali', 'Lohit Devanagari', 'Lohit Tamil', 'Londrina Outline', 'Londrina Shadow', 'Londrina Sketch', 'Londrina Solid', 'Lora', 'Love Ya Like A Sister', 'Loved by the King', 'Lovers Quarrel', 'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps', 'Magra', 'Maiden Orange', 'Mako', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 'Marvel', 'Mate', 'Mate SC', 'Maven Pro', 'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Megrim', 'Meie Script', 'Merienda', 'Merienda One', 'Merriweather', 'Merriweather Sans', 'Metal', 'Metal Mania', 'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 'Miltonian Tattoo', 'Miniver', 'Miss Fajardose', 'Miss Saint Delafield', 'Modern Antiqua', 'Molengo', 'Monda', 'Monofett', 'Monoton', 'Monsieur La Doulaise', 'Montaga', 'Montez', 'Montserrat', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedford', 'Mr Bedfort', 'Mr Dafoe', 'Mr De Haviland', 'Mrs Saint Delafield', 'Mrs Sheppards', 'Muli', 'Mystery Quest', 'Neucha', 'Neuton', 'New Rocker', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Nosifer Caps', 'Nothing You Could Do', 'Noticia Text', 'Noto Sans', 'Noto Sans UI', 'Noto Serif', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'OFL Sorts Mill Goudy TT', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script', 'Oleo Script Swash Caps', 'Open Sans', 'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald', 'Over the Rainbow', 'Overlock', 'Overlock SC', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Paprika', 'Parisienne', 'Passero One', 'Passion One', 'Pathway Gothic One', 'Patrick Hand', 'Patrick Hand SC', 'Patua One', 'Paytone One', 'Peralta', 'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball', 'Playfair Display', 'Podkova', 'Poiret One', 'Poller One', 'Poly', 'Pompiere', 'Pontano Sans', 'Port Lligat Sans', 'Port Lligat Slab', 'Prata', 'Preahvihear', 'Press Start 2P', 'Princess Sofia', 'Prociono', 'Prosto One', 'Proxima Nova', 'Proxima Nova Tabular Figures', 'Puritan', 'Purple Purse', 'Quando', 'Quantico', 'Quattrocento', 'Quattrocento Sans', 'Questrial', 'Quicksand', 'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Raleway', 'Raleway Dots', 'Rambla', 'Rammetto One', 'Ranchers', 'Rancho', 'Rationale', 'Redressed', 'Reenie Beanie', 'Revalia', 'Ribeye', 'Ribeye Marrow', 'Righteous', 'Risque', 'Roboto', 'Roboto Condensed', 'Roboto Slab', 'Rochester', 'Rock Salt', 'Rokkitt', 'Romanesco', 'Ropa Sans', 'Rosario', 'Rosarivo', 'Rouge Script', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 'Rum Raisin', 'Ruslan Display', 'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sail', 'Salsa', 'Sanchez', 'Sancreek', 'Sansita One', 'Sarina', 'Satisfy', 'Scada', 'Scheherazade', 'Schoolbell', 'Seaweed Script', 'Sevillana', 'Seymour One', 'Shadows Into Light', 'Shadows Into Light Two', 'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Siamreap', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony', 'Sirin Stencil', 'Six Caps', 'Skranji', 'Slackey', 'Smokum', 'Smythe', 'Snippet', 'Snowburst One', 'Sofadi One', 'Sofia', 'Sonsie One', 'Sorts Mill Goudy', 'Source Code Pro', 'Source Sans Pro', 'Special Elite', 'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Stalemate', 'Stalin One', 'Stalinist One', 'Stardos Stencil', 'Stint Ultra Condensed', 'Stint Ultra Expanded', 'Stoke', 'Strait', 'Sue Ellen Francisco', 'Sunshiney', 'Supermercado One', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tahoma', 'Tangerine', 'Taprom', 'Tauri', 'Telex', 'Tenor Sans', 'Terminal Dosis', 'Terminal Dosis Light', 'Text Me One', 'Thabit', 'The Girl Next Door', 'Tienne', 'Tinos', 'Titan One', 'Titillium Web', 'Trade Winds', 'Trocchi', 'Trochut', 'Trykker', 'Tulpen One', 'Ubuntu', 'Ubuntu Condensed', 'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 'Unica One', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Unna', 'VT323', 'Vampiro One', 'Varela', 'Varela Round', 'Vast Shadow', 'Vibur', 'Vidaloka', 'Viga', 'Voces', 'Volkhov', 'Vollkorn', 'Voltaire', 'Waiting for the Sunrise', 'Wallpoet', 'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Yanone Kaffeesatz', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Zeyada', 'jsMath cmbx10', 'jsMath cmex10', 'jsMath cmmi10', 'jsMath cmr10', 'jsMath cmsy10', 'jsMath cmti10');
		
		
			$fonts = array(				
				"" => array(				
					"name" => "Default Font",
					"google" => 1,					
				),
			);
			
			foreach($googleFonts as $g){
				
				$hh = explode(" ", $g);
				
				$fonts[$hh[0]] = array(
				
					"name" => $g,
					"google" => 1,					
				);
			}	
			
			if(is_array($order_data) && !empty($order_data) && $order_data[1] == "code"){
			
			return $fonts[$order_data[0]]['code'];
			
			}elseif(is_array($order_data) && !empty($order_data) && $order_data[1] == "name" && isset($fonts[$order_data[0]]) ){
			
			return $fonts[$order_data[0]]['name'];
			
			}elseif(is_array($order_data) && empty($order_data)){
				
				$n = array();
				foreach($fonts as $fk => $f){
				$n[$fk] = $f['name'];
				}
				return $n;
			
			}	
		
		
		} break;

		
		case "key":{
		
			// GET PAGE KEY		
			
			if(isset($GLOBALS['flag-footer-block'])){
			
				$pagekey = "footer";
				
			}elseif(isset($_GET['innerpageid']) && current_user_can('administrator')  ){
			
				$pagekey = "page_".$_GET['innerpageid'];			
			
			}elseif(is_page()){
							
				$pagekey = strtolower(str_replace("templates/","", str_replace("tpl-","", str_replace("tpl-page-","", str_replace(".php","", get_page_template_slug())))));	
				
				if( defined('THEME_FOLDER') ){
					$pagekey = str_replace(THEME_FOLDER."/", "", $pagekey);
				}
				$pagekey = "page_".$pagekey;	
			 
			
			}elseif( isset($GLOBALS['flag-home']) || isset($_GET['loadpage']) ){
						
				$pagekey = "home";
				
			}else{
			
				$pagekey = "";
			}
			 
			return $pagekey;
				
		} break;
	
		case "get_logo": {
	 
			if($order_data == "light"){
				$logo = _ppt(array('design','light_logo_url'));			
				if($logo == ""){
					$logo = _ppt(array('design','logo_url'));
				}
				$logocss = "navbar-brand-light";		
			}else{
				$logo = _ppt(array('design','logo_url'));
				$logocss = "navbar-brand-dark";		
			}
			
			$textlogo = trim(_ppt(array('design','textlogo')));
		 
			if($logo == "" && $textlogo == ""){
				$textlogo = "Website<span>Logo</span>";
			} 
			
			if( strlen($textlogo) > 1){
			return "<div class='textlogo ".$logocss."'>".$textlogo."</div>";
			}
			
			// FULL PATH
			return "<img src='".$logo."' alt='logo' class='img-fluid ".$logocss."' />";	
	
 		
		} break;
	
		case "get_color": {
		
			// CHECK TYPE
			if(is_array($order_data)){				
				$csstype = $order_data[0];			
			}else{				
				$csstype = $order_data;			
			}
			
			 
		
			if($csstype == "primary"){
			
			
				if(isset($order_data[1]) && strlen($order_data[1]) > 1 ){
					$color = $order_data[1];
				}else{
					$color = _ppt(array("design","color_primary"));
				}
			
			 
			
			if(strlen($color) > 3){
			ob_start(); ?><style>
			.bg-primary, .bg-primary:hover,.bg-primary:focus, a.bg-primary:focus, a.bg-primary:hover, button.bg-primary:focus, button.bg-primary:hover, .badge-primary { background:<?php echo $color; ?> !important; }
			
			.btn-primary, .btn-primary:hover { color: #fff; background-color: <?php echo $color; ?> !important; border-color: <?php echo $color; ?> !important; } 			
			.text-primary, .filters_col .distance span { color: <?php echo $color; ?> !important; }
			.btn-outline-primary { color: <?php echo $color; ?> !important; border-color: <?php echo $color; ?> !important; }
			.btn-outline-primary:hover { background:none !important; }
			.text-primary a  { color: <?php echo $color; ?> !important; }
			
			</style><?php $d = ob_get_clean(); 
			return hook_color_primary_css(strip_tags($d));
			}
			
			
			}elseif($csstype == "secondary"){
			
			
			if(isset($order_data[1]) && strlen($order_data[1]) > 1 ){
				$color = $order_data[1];
			}else{
				$color = _ppt(array("design","color_secondary"));
			}
			 
			
			if(strlen($color) > 3){
			ob_start();?><style>
			.bg-secondary, .bg-secondary:hover, .bg-secondary:focus, a.bg-secondary:focus, a.bg-secondary:hover, button.bg-secondary:focus, button.bg-secondary:hover, .irs-bar  { background-color:<?php echo $color; ?> !important; } 
			.btn-secondary, .btn-secondary:hover, .btn-secondary:focus { color: #fff; background-color: <?php echo $color; ?> !important; border-color: <?php echo $color; ?> !important; }
			  
			.text-secondary { color: <?php echo $color; ?> !important; }
			.text-secondary a  { color: <?php echo $color; ?> !important; }
			.btn-outline-secondary { color: <?php echo $color; ?> !important; border-color: <?php echo $color; ?> !important; }
			.btn-outline-secondary:hover { background:none !important; }
            </style><?php $d = ob_get_clean();
			
			return hook_color_secondary_css(strip_tags($d));
			}
			}elseif($csstype == "bglight"){
			
			$color = _ppt(array("design","color_bglight"));
			if(strlen($color) > 3){
			ob_start();?><style>
			
			.bg-light { background:<?php echo $color; ?> !important; } 
			
			 </style><?php $d = ob_get_clean();
			
			return hook_color_bglight_css(strip_tags($d));
			}
			}elseif($csstype == "bgdark"){
			
			$color = _ppt(array("design","color_bgdark"));
			if(strlen($color) > 3){
			ob_start();?><style>
			.bg-dark { background:<?php echo $color; ?> !important; } 
			 </style><?php $d = ob_get_clean();
			
			return hook_color_bgdark_css(strip_tags($d));
			}
			
			}elseif($csstype == "bg"){
			
			$color = _ppt(array("design","color_bg"));
			if(strlen($color) > 3){
			
			ob_start();?><style>
			body { background:<?php echo $color; ?> !important; } 
			 </style><?php $d = ob_get_clean();
			
			return strip_tags($d);
			}		
			
			
			}
		
		} break;
		
		
		case "get_placeholder_text": {
		
			$defaults = array(
				"hero" => array(				
					"title" 	=> __("Build Amazing New Websites Today!","premiumpress"),
					"subtitle" 	=> "",
					"desc" 		=> __("Save time and money - get started now!","premiumpress"),
					 
				),
				
				"intro" => array(				
					"title" 		=> __("Build Beautiful Websites","premiumpress"),
					"subtitle" 		=> __("Create stunning websites with our Premium WordPress themes.","premiumpress"),
					"desc" 			=> __("Create stunning websites for yourself or for your clients with our professional business themes for WordPress.","premiumpress"),
					 
				),	
				
				"listings" => array(				
					"title" 		=> __("New Auction","premiumpress"),
					"subtitle" 		=> __("Take a look at some of our latest items.","premiumpress"),
					"desc" 			=> __("Save time and money - get started now!","premiumpress"),
					
					 
				),	
				
				"text1" => array(				
					"title" 		=> __("Create Beautiful Websites In Minutes With PremiumPress","premiumpress"),
					"subtitle" 		=> __("150+ design blocks to choose from.","premiumpress"),
					"desc" 			=> __("PremiumPress themes come with 150+ ready-made drag &amp; drop design blocks making it easy to create stunning websites.","premiumpress"),
					"btn" 			=> __("Get Started","premiumpress"),
					 
				),	
				
				"text" => array(				
					"title" 		=> __("Welcome to our website!","premiumpress"),
					"subtitle" 		=> __("We've got exactly what you're looking for!","premiumpress"),
					"desc" 			=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", 
				),
				"icon" => array(				
					"title" 		=> "We know you'll love our service.",
					"subtitle" 		=> "",
					"desc" 			=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ",
					 
				),	
				"cta" => array(				
					"title" 		=> __("High Conversion CTA Section","premiumpress"),
					"subtitle" 		=> __("Call to action buttons help bring focus to user attention.","premiumpress"),
					"desc" 			=> "",
					 
				),			
				"text" => array(				
					"title" 		=> __("Welcome to our website!","premiumpress"),
					"subtitle" 		=> __("We've got exactly what you're looking for!","premiumpress"),
					"desc" 			=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", 
					 
				),
				"testimonials" => array(				
					"title" 		=> __("Recent Customer Feedback","premiumpress"),
					"subtitle" 		=> __("Over 50,000+ customers worldwide","premiumpress"),
					"desc" 			=> __("We've included everything you need to build amazing websites in one theme.","premiumpress"), 
				),				
				"blog" => array(				
					"title" 		=> __("Latest News & Updates","premiumpress"),
					"subtitle" 		=> __("stay upddated and join our newsletter","premiumpress"),
					"desc" 			=> "We've included everything you need to build amazing websites in one theme.", 
				),					
				"faq" => array(				
					"title" 		=> __("Common FAQ","premiumpress"),
					"subtitle" 		=> __("Commonly asked questions & answers","premiumpress"),
					"desc" 			=> __("If you can't find answers to your questions below, contact us.","premiumpress"), 
				),	
				"pricing" => array(				
					"title" 		=> __("Pricing made for everyone","premiumpress"),
					"subtitle" 		=> __("All pricing packages are backed up by a 30-day money back guarantee.","premiumpress"),
					"desc" 			=> "", 
				),	
				"subscribe" => array(				
					"title" 		=> __("Join Our Newsletter","premiumpress"),
					"desc" 		=> __("Stay updated with the latest news and updates.","premiumpress"),
					  
				),
				"video" => array(
					"title" 		=> __("Built using the latest HTML5 Web standards","premiumpress"),
					"subtitle" 		=> __("Optimized for speed and search engines.","premiumpress"),
					"desc" 			=> "We've included everything you need to build amazing websites in one theme.", 
				),
				"slider" => array(				
					"title" 		=> "<small>PremiumPress Themes</small> Build Amazing Websites Today!",
					"subtitle" 		=> "Get Started Today!",
					"desc" 			=> "Build Amazing Websites Today!",
					  
				),
				
				"category" => array(				
					"title" 		=> __("Popular Website Categories","premiumpress"),
					"subtitle" 		=> __("Find what your looking for, right now!","premiumpress"),
					"desc" 			=> "",
					  
				),
				 				  
																			 
			);
			
			  
			
			// 1. TYE
			// 2. BLOCK
			// 3. NUMBER
			  
			switch($order_data[0]){
			
				 				
				case "title": {
			 	
					if(isset($order_data[1]) && is_numeric($order_data[1])){
					
						$titles_array = array(
							1 => __("24/7 Support","premiumpress"),
							2 => __("Members Area","premiumpress"),
							3 => __("Easy to Navigate","premiumpress"),
							4 => __("Free To Register","premiumpress"),
							5 => __("Message System","premiumpress"),
							6 => __("Author Profiles","premiumpress"),
							7 => __("Facebook Login","premiumpress"),
							8 => __("Message System","premiumpress"),							
							
						);
						
						return $titles_array[$order_data[1]];
						
					}elseif( isset($defaults[$order_data[1]]['title']) ){	
					 	
						return $defaults[$order_data[1]]['title'];
						
					}else{
								
					return "Welcome to my webiste!";
					
					}
				
				} break;				
			 				
				case "subtitle": {
					
					if( isset($defaults[$order_data[1]]['subtitle']) ){	
					 	
						return $defaults[$order_data[1]]['subtitle'];
						
					}else{
								
					return "Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos. ";
					
					}
					
				
				} break;
	 	
				case "desc": {
				
					 if( isset($order_data[1]) && isset($defaults[$order_data[1]]['desc']) ){	
					 	
						return $defaults[$order_data[1]]['desc'];
						
					}else{
								
					return "Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos.";
					
					}
					 		 
				
				} break;
				case "desc_big": {					 
								
					return "Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos. Mazim nemore singulis an ius, nullam ornatus nam ei. ldque maiestatis vis ut. Quo in tacimates recusabo scripserit, in mea tantas soleat imperdiet.";	 
				
				} break;
				
				case "desc_small": {					 
								
					return "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";	 
				
				} break;
				
				  
				case "link_video": {
				
					return "https://www.youtube.com/watch?v=sKDAblffdI8";
					
				} break;
				case "quote": {					
					return "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";				
				} break;
				case "quote_name": {					
					return "John Doe";				
				} break;
				case "quote_job": {					
					return "PremiumPress";				
				} break;
											
				default: {
				
					return $order_data[0];
				}
			
			}
			
			
		
		
		} break;
		
		case "get_placeholder": {
		
			//$order_data[0]
			//$order_data[1]
			//$order_data[2] // type {user, text}
		 
			if($order_data[0] == "slider"){
			
			
				 
				if(isset($order_data[1]) ){
					
						$r = array(
						
							"slider_inline" => "https://via.placeholder.com/1210x540/000000/FFFFFF/",
					
						);
						
						return $r[$order_data[1]];
						
					}else{
								
					return "https://via.placeholder.com/1940x500/000000/FFFFFF/";
					
					}
			
			
			}elseif($order_data[0] == "user"){
			
				return DEMO_IMG_PATH."user/".$order_data[1].".jpg";
			
			}elseif($order_data[0] == "full"){
			
				if(isset($order_data[1]) && strlen($order_data[1]) > 1){
					
						$r = array(
							
							"dark" => "https://via.placeholder.com/1940x500/000000/FFFFFF/",
							"light" => "https://via.placeholder.com/1940x500/efefef/FFFFFF/",
							 			
							
						);
						
						return $r[$order_data[1]];
						
					}else{
								
					return "https://via.placeholder.com/1940x500/000000/FFFFFF/";
					
					}
			
			
			
			}elseif($order_data[0] == "hero"){
			
				if(isset($order_data[1]) && is_numeric($order_data[1])){
					
						$r = array(
							1 => DEMO_IMG_PATH."random/full/1.jpg",
							2 => DEMO_IMG_PATH."random/full/2.jpg",
							3 => DEMO_IMG_PATH."random/full/3.jpg",
							4 => DEMO_IMG_PATH."random/full/4.jpg",
							5 => DEMO_IMG_PATH."random/full/5.jpg",					
							
						);
						
						return $r[$order_data[1]];
						
					}else{
								
					//
					
					}
			
				return "https://via.placeholder.com/1940x500/000000/FFFFFF/";
				
			}elseif($order_data[0] == "text"){
				
				return DEMO_IMG_PATH."".THEME_KEY."/preview/text/".$order_data[1]."_bg.jpg";
 			
			}elseif($order_data[0] == "square"){
			
			return "https://via.placeholder.com/800x800/000000/FFFFFF/";
 			
			} 
			 
		 	
			return "https://via.placeholder.com/".$order_data[0]."x".$order_data[1]."/000000/FFFFFF/";
		
		
		
		} break;
		
		case "get_innerpage_blocks": {
				
				// LIST ALL THEME PAGES
				$pages = array(
				
					"page_aboutus" 		=> array("name"=> "About Us Page", "flag" => "flag-aboutus", "blocks" => array('text8', 'text1', 'icon9','text10') , "link" => _ppt(array('links','aboutus')), "order" => 3),			
				 
					"page_sellspace" 	=> array("name"=> "Advertising Page", "blocks" => array( 'pricing1' , 'icon6') , "link" => _ppt(array('links','sellspace')), "order" => 4),	
					
					"page_contact" 		=> array("name"=> "Contact Form" , "blocks" => array('contact1') , "link" => _ppt(array('links','contact')), "order" => 5),	
							 
					"page_memberships" 	=> array("name"=> "Memberships" , "blocks" => array( 'pricing1', 'icon10') , "link" => _ppt(array('links','memberships')), "order" => 6),
					
					"page_terms" 		=> array("name"=> "Terms &amp; Conditions Page" , "blocks" => array('text8') , "link" => _ppt(array('links','terms')), "order" => 13),
					
					"page_privacy" 		=> array("name"=> "Privacy Page" , "blocks" => array('text8') , "link" => _ppt(array('links','privacy')), "order" => 13),	
							
					"page_faq" 			=> array("name"=> "FAQ Page" , "blocks" => array('text8', 'text1',  'faq1', 'faq2' ) , "link" => _ppt(array('links','faq')), "order" => 10),	
					
					"page_testimonials" => array("name"=> "Testimonials Page" , "blocks" => array('text8', 'text1', 'testimonials2' ) , "link" => _ppt(array('links','testimonials')), "order" =>9),	
							
					"page_how" 			=> array("name"=> "How it works", "blocks" => array('text8', 'text1', 'icon1', 'faq1' ), "link" => _ppt(array('links','how')), "order" => 8),
					 
					"page_add" 			=> array("name"=> "Add Auction Page", "blocks" => array('pricing2' , 'icon11'), "link" => _ppt(array('links','add')), "order" => 8),
					
					"page_stores" 		=> array("name"=> "Stores Page", "blocks" => array('text8', 'stores2' ), "link" => _ppt(array('links','stores')), "order" => 9),
					
					
					"page_chatroom" 		=> array("name"=> "Chatroom", "link" => _ppt(array('links','chatroom')), "order" => 13),
					
					
					// DEMO EXTRAS
					"page_account" 			=> array("name"=> "My Account", "link" => _ppt(array('links','myaccount')), "order" => 2),					
					"page_blog" 			=> array("name"=> "Blog", "link" => _ppt(array('links','blog')), "order" => 11),					 
					"page_login" 			=> array("name"=> "Login", "link" => wp_login_url() , "order" => 12),
					"page_register" 		=> array("name"=> "Register", "link" => wp_registration_url()  , "order" => 13),
					
					
					//"page_lostpassword" 		=> array("name"=> "Lost Password", "link" => $this->_ppt_home_url()."/wp-login.php?action=lostpassword"  ),
					
					"page_search" 		=> array("name"=> "Search Page", "link" => $this->_ppt_home_url()."/?s="  , "order" => 1),
					
					
					"page_listingpage" 		=> array("name"=> "Auction Page", "blocks" => array('single1'), "order" => 14 ), //, "noedit" => 1
					
					
				); 
				
				if(in_array(THEME_KEY, array("cp")) ){
				
				}else{
					unset($pages['page_stores']);
				}
				 
				// REMOVE PER THEME
				if(THEME_KEY == "sp"){
					unset($pages['page_add']);
					unset($pages['page_memberships']);					
				}
				
				if(THEME_KEY != "da"){
					unset($pages['page_chatroom']);					 				
				}
				
				if( !$CORE->LAYOUT("captions","memberships") ){ 
				unset($pages['page_memberships']);	
				}
				
				if( !$CORE->LAYOUT("captions","listings") ){ 
				unset($pages['page_add']);	
				}
				
				
				if($order_data == "demo"){
					
					return $pages;
				
				}else{
					
					// REMOVE PAGES FROM ARRAY
					// WHICH DO NOT HAVE BLOCKS (DEMO ONLY )
					foreach($pages as $kk => $k){
						
						if(!isset($k['blocks'])){						 					
							unset($pages[$kk]);
						}
					}			
				
				}
				
				
				// CREATE BLOCK DATA FROM BUILT IN ARRAY
				$innerd  = $CORE->LAYOUT("default_innerpages", array() ); 
				foreach($pages as $k => $o){
				
					if(isset($innerd[$k]) && is_array($innerd[$k]) ){
						
						$blocksdata = array();
						foreach($innerd[$k] as $j => $cc){							
								$blocksdata[$j] = $j; 						
						}						
						$pages[$k]['blocks'] = $blocksdata;							
					
					}				
				}	
				
				
				
				if(is_array($order_data) && empty($order_data) ){
				
				return $pages;
				
				}elseif(is_array($order_data) && !empty($order_data) ){
				
					 $k = $order_data[0];
					  
					 if(isset($pages[$k]) && is_array($pages[$k]['blocks'])){
					  
						 foreach($pages[$k]['blocks'] as $k){
							
							echo do_action( $k."-css" );
							echo do_action( $k );
							echo do_action( $k."-js" );
						 }
					 }
				
				
				}else{
				
				return $pages[$order_data];
				
				}
				 
		
		} break;
		
		case "get_block_defaults": {
		
			$data = $this->LAYOUT("get_blocks_data", array());
		
			if( is_array($data) && isset($data[$order_data]) && isset($data[$order_data]['defaults']) ){
									
			return $data[$order_data]['defaults'];	
				
			}		
		
		} break;
		
		case "get_block_category": {
		
			$data = $this->LAYOUT("get_blocks_data", array());
		
			if( is_array($data) && isset($data[$order_data]) ){
									
			return $data[$order_data]['cat'];	
				
			}		
		
		} break;
		
		case "get_block_prewview": {
		
			$data = $this->LAYOUT("get_blocks_data", array()); 
		
			if( is_array($data) && isset($data[$order_data]) ){
			
			
			if(in_array($data[$order_data]['cat'], array('heroxx','sliderxx') ) ){
			
				return DEMO_IMG_PATH."".THEME_KEY."/preview/".$data[$order_data]['cat']."/".$data[$order_data]['image'];	
			}
			
			return DEMO_IMG_PATH."blocks/".$data[$order_data]['cat']."/".$data[$order_data]['image'];
			
			
			 	
				
			}		
		
		} break;
	 
		case "get_slots": {	
		
			$slots = array(
			 
				"header" => array (
					"id" => "header_style",
					"name" => "Header",					
				),
				
				"footer" => array (
					"id" => "footer_style",
					"name" => "Footer",	
				),
				 
				1 => array (
					"id" => "slot1_style",
					"name" => "Slot 1",	
				),
			
				2 => array (
					"id" => "slot2_style",
					"name" => "Slot 2",	
				),
				
				3 => array (
					"id" => "slot3_style",
					"name" => "Slot 3",	
				),
				
				4 => array (
					"id" => "slot4_style",
					"name" => "Slot 4",	
				),				
				
				5 => array (
					"id" => "slot5_style",
					"name" => "Slot 5",	
				),
				
				6 => array (
					"id" => "slot6_style",
					"name" => "Slot 6",	
				),	
				
				7 => array (
					"id" => "slot7_style",
					"name" => "Slot 7",	
				),	
				
				8 => array (
					"id" => "slot8_style",
					"name" => "Slot 7",	
				),
				
				9 => array (
					"id" => "slot9_style",
					"name" => "Slot 9",	
				),
				
					
				
			);
			
			if( is_array($order_data) && !empty($order_data) ){
			
				$h = array();
				foreach($order_data as $c){
			 	
				$h[$c] = $slots[$c];
				}
				
				return $h;
				
			
			}else{
			
				return $slots;
			}
			
				
		} break;	
		
		

	
		case "get_block_types": {	
		
			$blocks = array(
			 
				0 => array(	
					"name" 	=>  __("Header","premiumpress"), 
					"id" 	=> "header",
					"color" => "#e5e5e5",
				),	
							
				1 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Footer","premiumpress"), 
					"id" 	=> "footer",
					"color" => "#87c8f7",
				),	
				
					
				20 => array(	 
					"name" =>  __("Intro","premiumpress"), 
					"id" 	=> "intro",
					"color" => "#87c8f7",
				),
			
				 	
				2 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Hero","premiumpress"), 
					"id" 	=> "hero",
					"color" => "#87c8f7",
				),
				3 => array (
					"name" =>  __("Text","premiumpress"), 
					"id" 	=> "text",
					"color" => "#87c8f7",
				),
				4 => array (
					"name" =>  __("Icons","premiumpress"), 
					"id" 	=> "icon",
					"color" => "#87c8f7",
				),
				5 => array (
					"name" =>  __("Call-to-action","premiumpress"), 
					"id" 	=> "cta",
					"color" => "#87c8f7",
				),			 			
				6 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Contact Us","premiumpress"), 
					"id" 	=> "contact",
					"color" => "#87c8f7",
				),				
											
				7 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Video","premiumpress"), 
					"id" 	=> "video",
					"color" => "#87c8f7",
				),
											
				8 => array(	// FOR OLDER SYSTEM
					"name" =>  __("FAQ","premiumpress"), 
					"id" 	=> "faq",
					"color" => "#87c8f7",
				),	
												
				9 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Auctiona","premiumpress"), 
					"id" 	=> "listings",
					"color" => "#87c8f7",
				),	
				 
				
				10 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Testimonials","premiumpress"), 
					"id" 	=> "testimonials",
					"color" => "#87c8f7",
				),
					
				11 => array(	// FOR OLDER SYSTEM
					"name" =>  __("Subscribe","premiumpress"), 
					"id" 	=> "subscribe",
					"color" => "#87c8f7",
				),
				
				12 => array (
					"name" =>  __("Image Grids","premiumpress"), 
					"id" 	=> "image_block",
					"color" => "#87c8f7",
				),	
				
				13 => array (
					"name" =>  __("Category","premiumpress"), 
					"id" 	=> "category",
					"color" => "#87c8f7",
				),
								
				14 => array (
					"name" =>  __("Search","premiumpress"), 
					"id" 	=> "search",
					"color" => "#87c8f7",
				),
				 
				
				15 => array (
					"name" =>  __("Blog","premiumpress"), 
					"id" 	=> "blog",
					"color" => "#87c8f7",
				),
				
				16 => array (
					"name" =>  __("Pricing","premiumpress"), 
					"id" 	=> "pricing",
					"color" => "#87c8f7",
				),
				
				17 => array (
					"name" =>  __("Stores","premiumpress"), 
					"id" 	=> "store",
					"color" => "#87c8f7",
				),
				
				18 => array (
					"name" =>  __("Auctions Page","premiumpress"), 
					"id" 	=> "listingpage",
					"color" => "#87c8f7",
				),
				
				19 => array (
					"name" =>  __("Users","premiumpress"), 
					"id" 	=> "users",
					"color" => "#87c8f7",
				),
				
								
			);
			
			if(defined('THEME_KEY') && THEME_KEY == "cp"){
			
			}else{
			
			unset($blocks[17]);
			}
			 
			
			return $blocks;   
		
		} break;
		
		case "get_blocks_data": {  		
		
			return apply_filters( 'ppt_blocks_args', array() );			 
		
		} break;
		
		case "load_css": {
			
			$blocks_css  = "";
			
			// GET PAGE
			$key = $this->LAYOUT("key",array()); 
			
			if($key == "home"){
			// GET
			$css = "";
			$g = $this->LAYOUT("get_slots", array());
			foreach($g as $k){
				
				$h = _ppt(array('design', $k['id']));
				
				// DEFAULTS
				if($k['id'] == "header_style" && $h == ""){
				$h = "header3";
				
				}elseif($k['id'] == "footer_style" && $h == ""){
				$h = "footer1";
				 
				} 		
					
				if($h != ""){
				ob_start();
				do_action($h.'-css');
				$css .= ob_get_clean();
				}
			}
			
			$blocks_css = $css;
			
			}else{
			
			
			}
			
			$custom_css  =  $this->LAYOUT("get_color","primary"); 
			$custom_css .=  $this->LAYOUT("get_color","secondary"); 
			$custom_css .=  $this->LAYOUT("get_color","bglight"); 
			$custom_css .=  $this->LAYOUT("get_color","bgdark"); 
			$custom_css .=  $this->LAYOUT("get_color","bg"); 
			
			// ADMIN CUSTOM CSS
			$custom_css .= stripslashes(get_option('custom_head'));
			 
			return preg_replace('/\s+/', ' ',trim(str_replace("<style>","", str_replace("</style>","", $blocks_css.$custom_css))));
		
		} break;
		
		case "load_js": {
		
				$css = "";				
				
				// CHECK FOR DEFAULT FONTS
				foreach($CORE->LAYOUT("get_fonttypes", array() ) as $fk => $f){
					
					if(_ppt(array('design', $fk)) != ""){
				 
					$h = _ppt(array('design', $fk));					
					$t = $this->LAYOUT("get_fonttypes", $fk);
				 
					ob_start();?>					
					<script>
					jQuery(document).ready(function() {	
						jQuery("head").append("<link href='https://fonts.googleapis.com/css?family=<?php echo $CORE->LAYOUT("get_fonts", array($h, "name") ); ?>' rel='stylesheet' type='text/css'>");
						jQuery("head").find('style').append('<?php echo $t['code']; ?> { font-family: "<?php echo $CORE->LAYOUT("get_fonts", array($h, "name") ); ?>", Sans-serif; }');
					});</script><?php 
					$css .= ob_get_clean();
					
					}    
				
				}
				
			
				$key = $this->LAYOUT("key", array());
				 
				if($key == ""){ return $css; }			 
			 
				if(isset($GLOBALS['CORE_THEME'][$key])){
					$dd = $GLOBALS['CORE_THEME'][$key];
				}else{
					$g = get_option("core_admin_values");
					if(isset($g[$key])){
					$dd = $g[$key];
					}else{
						$dd = array();
					}
				}
				
				if($dd == ""){ 
					$dd = array();
				}
				
				 
				$im = "";
				if(is_array($dd)){
					foreach($dd as $bb){ 
						if(is_array($bb)){
							foreach($bb as $hk => $h){
						
								if(strpos($hk,"font") !== false && $h != "" ){	 //	
									
								ob_start();?>					
								<script>
								jQuery(document).ready(function() {	
									jQuery("head").append("<link href='https://fonts.googleapis.com/css?family=<?php echo $CORE->LAYOUT("get_fonts", array($h, "name") ); ?>' rel='stylesheet' type='text/css'>");
									jQuery("head").find('style').append('.font-<?php echo $h; ?> { font-family: "<?php echo $CORE->LAYOUT("get_fonts", array($h, "name") ); ?>", serif; }');
								});</script><?php $css .= ob_get_clean();
								
								}
						
							} 
					
						}
					}
				}
				
				
		
		
			// GET
			
			$g = $this->LAYOUT("get_slots", array());
			foreach($g as $k){
				
				$h = _ppt(array('design', $k['id']));
				
				// DEFAULTS
				if($k['id'] == "header_style" && $h == ""){
				$h = "header3";
				
				}elseif($k['id'] == "footer_style" && $h == ""){
				$h = "footer1";
				
				} 		
					
				if($h != ""){
				ob_start();
				do_action($h.'-js');
				$css .= ob_get_clean();
				}
			}
			
			return str_replace("","", str_replace("","", $css));
		
		} break;
		
		case "load_all_by_cat": {
		
			$h = array();
			$data = $this->LAYOUT("get_blocks_data", array());
		 		
			if( is_array($data) && !empty($data)  ){			 
			
				foreach($data as $k => $g){				
			 
			 		if(is_array($order_data) && in_array($g['cat'], $order_data)){
					 
						$h[$k] =  $data[$k];
					
					}elseif($g['cat'] == $order_data){
					
					
						// HIDE FROM SYSTEM
						if($k == "listingpage_openinghours" && !in_array(THEME_KEY, array("dt"))){
						continue;
						}						
						 
						if($k == "listingpage_title" && in_array(THEME_KEY, array("da"))){
						continue;
						} 
						
						if($k == "listingpage_author" && !in_array(THEME_KEY, array("at","mj"))){
						continue;
						} 
						
						
						if(in_array($k, array("listingpage_comments","listingpage_map","listingpage_content","listingpage_images","listingpage_sidebar")) && THEME_KEY == "cp" ){
						continue;
						}
						
					
						$h[$k] =  $data[$k];
						
					}				
				}
			}
			
			return $h;
		
		} break;
		
		case "load_designs_by_theme": {
		
			$h = array();
			if( is_array($this->all_admin_layouts)  ){
			
				foreach($this->all_admin_layouts as $k => $g){				
			 
			 		if(is_array($order_data) && in_array($g['theme'], $order_data)){
					
						$h[$k] =  $this->all_admin_layouts[$k];
					
					}elseif($g['theme'] == $order_data){
					
						$h[$k] =  $this->all_admin_layouts[$k];
						
					}				
				}
			}
			
			return $h;
		
		} break;
		
		case "load_single_design": {	
		
		//die(print_r($this->all_admin_layouts));		
			
			if(isset($this->all_admin_layouts[$order_data])){
			
			return $this->all_admin_layouts[$order_data];
			
			}
			
		} break;
				
		case "load_all": {
			
			$data = $this->LAYOUT("get_blocks_data", array());			
			
			
			if( is_array($data) && !empty($data) ){					
				
			
				foreach($data as $k => $g){
				
					if($g['cat'] == $order_data){
					
						echo do_action( $k."-css" );
						echo do_action( $k );
						if($g['cat'] == "header" && isset($_GET['ppt_live_preview']) ){
						echo "<div style='height:200px; background:grey'></div>";
						}
						echo do_action( $k."-js" );
						
						echo "<div class='w-100 bg-black py-3 text-white text-center'>".$k."</div>";
						
					}				
				}
			}
		
		} break;
		
		case "load_random_block": {
		
		
			$h = array();
			
			$data = $this->LAYOUT("get_blocks_data", array());
			
			if( is_array($data) && !empty($data)  ){
			
				foreach($data as $k => $g){				
			 
			 		if(is_array($order_data) && in_array($g['cat'], $order_data)){
					
						$h[$k] =  $data[$k];
					
					}elseif($g['cat'] == $order_data){
					
						$h[$k] =  $data[$k];
						
					}				
				}
			}
			
			$rand_keys = array_rand($h, 2);			 
			$ran = $rand_keys[0]; 
			
			echo do_action( $ran."-css" );
			echo do_action( $ran."-js" );
			 
			$this->LAYOUT("load_single_block",$ran);
 		
		} break;
		
		case "load_single_block": {
		
			$data = $this->LAYOUT("get_blocks_data", array());	
			 
			if(is_array($order_data)){
				foreach($order_data as $b){
				
					if( is_array($data) && isset($data[$b]) ){
									
						echo do_action( $b );	
						echo do_action( $b."-css" );
						echo do_action( $b."-js" );	
						
					}
				
				}
			
		 	}elseif( is_array($data) && isset($data[$order_data]) ){
									
					echo do_action( $order_data );		
					echo do_action( $order_data."-css" );
					echo do_action( $order_data."-js" );					
			}
		
		} break;
		

		case "load_single_value": {
		
	 
				// KEYS
				$key1 = $order_data[0];	// name
				$key2 = $order_data[1];	// id
				
				if(isset($order_data[2]) && strlen($order_data[2]) > 1){
					$mainkey = $order_data[2];								
				}else{				
					$mainkey = $this->LAYOUT("key", array());				 
				} 
				 
				  		  
				// LOAD ALL CORE DATA
				if( 
				
					( defined('WLT_DEMOMODE') && isset($_GET['previewblock']) ) || 
					
					( defined('WLT_DEMOMODE') && strpos($mainkey,"page_") !== false ) || 					 
					
					( current_user_can('administrator') && isset($_GET['ppt_live_preview']) && !isset($_GET['livedata']) ) 
					
				 ){
				$HDATA = array();
				}else{
				$HDATA = _ppt($mainkey);
				 
				}
				
				  
				
				// CHECK IF THERE IS DATA SAVED
				// IN THE MAI DATABASE				
				if(substr($key2,-4) == "_aid"){
						 
					if($exta == "post_title"){
						return get_the_title($HDATA[$key1][$key2]);
					}
						
				}elseif(is_array($HDATA) && isset($HDATA[$key1][$key2]) && $HDATA[$key1][$key2] != "" && _ppt_pagelinking(str_replace("page_","", $mainkey)) == "" ){ 
				
					return stripslashes($HDATA[$key1][$key2]); 
						
				}	
				
				
				
					 
				// if value is blank and it's an inner page
				// lets check for some default content				
				if(strpos($mainkey,"page_") !== false && _ppt_pagelinking(str_replace("page_","", $mainkey)) == ""   ){		 // IS NOT ELEMENTOR PAGE
				 
					$innerd  = $CORE->LAYOUT("default_innerpages", array() );					  
					if(isset($innerd[$mainkey])){
						
						
						$HDATA = $innerd[$mainkey];							 		 			
						if(is_array($HDATA) && isset($HDATA[$key1][$key2]) && $HDATA[$key1][$key2] != ""){ 	
						
							$non_elementor_data = _ppt($mainkey);
							if(is_array($non_elementor_data) && isset($non_elementor_data[$key1][$key2]) && $non_elementor_data[$key1][$key2] != ""){ 
							
							return stripslashes($non_elementor_data[$key1][$key2]); 	
							
							}else{	
											 
							return stripslashes($HDATA[$key1][$key2]); 	
							
							}
							
													
						}
					}	
								
				}
				///////////////////////////////////////
				
				
				// LIVE PREVIEW DETAILS				 
				if(isset($_GET['ppt_live_preview']) ){
					$default_data = $CORE->LAYOUT("get_block_defaults", $key1);
					if(is_array($default_data) && !empty($default_data)){				 
						if(isset($default_data[$key2]) && $default_data[$key2] != ""){ 						 
							return stripslashes($default_data[$key2]); 							
						}
					}
				}
				  
				 
		} break;
		
		
		case "get_block_settings_defaults": {
		  
			if( is_array($order_data) ){
			
				$blockid 	=  $order_data[0];
				$cat 		=  $order_data[1];
				$s 			=  $order_data[2];
				
				
				
				
				//return $CORE->LAYOUT("get_block_defaults", $blockid );
		 
				
				
				// GLOBAL SECTION TITLES
				if(!in_array($cat, array("header","footer")) ){ 					
				
					// TITLE STYLE
					$s["title_pos"]		= $CORE->LAYOUT("load_single_value", array($blockid, 'title_pos') );
					$s["title_heading"]		= $CORE->LAYOUT("load_single_value", array($blockid, 'title_heading') );
					
					$s["title_show"]	= $CORE->LAYOUT("load_single_value", array($blockid, 'title_show') );
					$s["title_style"]	= $CORE->LAYOUT("load_single_value", array($blockid, 'title_style') );
					$s["title"]			= $CORE->LAYOUT("load_single_value", array($blockid, 'title'));	
					$s["subtitle"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'subtitle'));	
					$s["desc"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'desc'));
					 	
					$s["title_margin"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'title_margin'));
					$s["subtitle_margin"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'subtitle_margin'));
					$s["desc_margin"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'desc_margin'));
					
					
					$s["title_font"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'title_font'));
					$s["subtitle_font"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'subtitle_font'));
					$s["desc_font"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'desc_font'));
					 
					$s["title_txtcolor"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'title_txtcolor'));
					$s["subtitle_txtcolor"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'subtitle_txtcolor'));
					$s["desc_txtcolor"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'desc_txtcolor'));
					
					$s["title_txtw"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'title_txtw'));
					$s["subtitle_txtw"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'subtitle_txtw'));
					
					
					/*
					if($s["title_show"]  == ""){
						
						
						//defaults
						switch($cat){
							case "hero":{
							 
							} break;							
							case "icon": {	
							
								$s["title_show"] = "yes"; 
								$s["title_style"] = "1";
								$s["title_heading"]	 = "h2"; 
								
								$s["title"] = $CORE->LAYOUT("get_placeholder_text", array('title', $cat) );	
								$s["subtitle"] = $CORE->LAYOUT("get_placeholder_text", array('subtitle', $cat) );	
								$s["desc"] = $CORE->LAYOUT("get_placeholder_text", array('desc', $cat) );
						
													
								$s["desc_txtcolor"] = "opacity-5";								
							} break;
							case "image_block": {							
								$s["title_pos"] = "center";		
								$s["desc_margin"] = "mb-5";							
							} break;
							case "category": {							
								$s["title_pos"] = "center";
								$s["subtitle_txtcolor"] = "primary";
							} break;
							case "listings": {							
								$s["title_pos"] = "center";
							} break;
							case "video":
							case "text": {							
								$s["desc_txtcolor"] = "opacity-5";
								$s["subtitle_txtcolor"] = "primary";							
							} break;
							case "cta": {							
								$s["desc_txtcolor"] = "opacity-5";
								$s["subtitle_txtcolor"] = "dark";
								$s["title_txtcolor"] = "primary";								 						
							} break;					
						}// end switch  
					
					}*/
					
					
				}
				
				// GLOBAL SECTION PADDING
				if(!in_array($cat, array("header","hero",'intro')) ){ 
					
					$extra = "";
					if($cat == "footer"){
					$extra = "footer";
					}
			
					// GLOBAL SECTION	
					$s["section_class"]		= "block-cat-".$cat." block-".$blockid;
					$s["section_bg"]		= $CORE->LAYOUT("load_single_value", array($blockid, 'section_bg', $extra) );		
					$s["section_divider"] 	= ""; //$CORE->LAYOUT("load_single_value", array($blockid, 'section_divider', $extra) );		
					$s["section_padding"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'section_padding', $extra) );
					$s["section_pos"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'section_pos', $extra) );
					$s["section_pattern"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'section_pattern', $extra) );
					 
					 
					$s["section_w"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'section_w', $extra) );
					 
					if($s["section_w"] == ""){ $s["section_w"] = "container"; }
					
					if($s["section_pos"] == "center"){
					$s["section_class"]	.= " text-center";
					}
					 
					
					// PADDING DEFAULTS FOR DESIGNS 
					if($s["section_padding"] == ""){
					
						 
						//defaults
						switch($cat){
							case "cta": {							
								$s["section_bg"] 		= "bg-light";
								$s["section_padding"] 	= "section-40";						
							} break;
							
							case "footer": {							
								$s["section_bg"] 		= "bg-light";
								$s["section_padding"] 	= "section-60";						
							} break;
							
							default: {							
								$s["section_padding"] 	= "section-100";							
							} break;					
						}// end switch
					}				
					 
				
				}
				
				// GLOBAL BUTTONS
				if(in_array($cat, array("header","hero","cta","text","faq","icon","video",'intro','store')) ){ 
				
					$extra = "";
					if($cat == "header"){
						$extra = "header";
					}
			
					$s["btn_show"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_show', $extra));
						
					$s["btn_style"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_style', $extra));					
					$s["btn_size"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_size', $extra));
					$s["btn_icon"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_icon', $extra));					
					$s["btn_icon_pos"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_icon_pos', $extra));				
					
					$s["btn_font"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_font'));					
					
					$s["btn_txt"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_txt', $extra));
					$s["btn_link"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_link', $extra));
					$s["btn_bg"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_bg', $extra));
					$s["btn_bg_txt"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_bg_txt', $extra));					
					$s["btn_margin"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn_margin', $extra));
					
					// REPLACE
					$s["btn_link"] = $CORE->_ppt_filter_link($s["btn_link"]);					
					
					// REPLACE ICON
					$s["btn_icon"] = str_replace( "far fa", "fa fa", $s["btn_icon"] );
				 
				
				}	
				// GLOBAL BUTTONS
				if(in_array($cat, array("hero","text","icon","video",'intro')) ){ 
			
					$s["btn2_show"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_show'));
						
					$s["btn2_style"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_style'));					
					$s["btn2_size"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_size'));
					$s["btn2_icon"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_icon'));					
					$s["btn2_icon_pos"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_icon_pos'));					
					
					$s["btn2_font"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_font'));					
							
					$s["btn2_txt"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_txt'));
					$s["btn2_link"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_link'));
					$s["btn2_bg"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_bg'));
					$s["btn2_bg_txt"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_bg_txt'));					
					$s["btn2_margin"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'btn2_margin'));
					
					// REPLACE
					$s["btn2_link"] = $CORE->_ppt_filter_link($s["btn2_link"]);
					
					// REPLACE ICON
					$s["btn2_icon"] = str_replace( "far ", "fa ", $s["btn2_icon"] ); 
					
				}					
				
							
				
				// HEADER
				if($cat == "header"){
				 	 
					$s["topmenu_show"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'topmenu_show', 'header'));					 
					$s["extra_show"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'extra_show', 'header'));
				  	$s["extra_type"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'extra_type', 'header'));
				  	 	
					/* defaults */
					if($s["topmenu_show"]  == ""){ $s["topmenu_show"]  = "yes"; }					 
					
				}
				
				// FOOTER
				if($cat == "footer"){
				 	 
					$s["footer_copyright"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_copyright', 'footer'));					 
					$s["footer_description"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_description', 'footer'));					 
				
					$s["footer_copyright_style"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_copyright_style', 'footer'));					 
				
					$s["footer_menu1"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_menu1', 'footer'));					 
					$s["footer_menu2"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_menu2', 'footer'));					 
				
					$s["footer_menu1_title"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_menu1_title', 'footer'));					 
					$s["footer_menu2_title"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'footer_menu2_title', 'footer'));					 
				
				}
				
				// STORES BLOCK
				if($cat == "store"){
				 	 
					//$s["topmenu_show"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'topmenu_show', 'header'));					 
				 	
				}
				 
				if($cat == "users"){
				 	 
					$s["user_type"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'user_type'));					 
				 	
				}
				
				// GLOBAL IMAGE BLOCKS
				if($cat == "image_block"){
				
					$i=1; 
					while($i < 7){
				 	
					 $s["image_block".$i] 				= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i) );
					 $s["image_block".$i."_effect"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_effect') );
					 $s["image_block".$i."_size"] 		= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_size') );
					 $s["image_block".$i."_txtcolor"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_txtcolor') );
					 
					 $s["image_block".$i."_txtpos"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_txtpos') );
					 
					 $s["image_block".$i."_title"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title') );
					 $s["image_block".$i."_subtitle"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle') );
					 
					  $s["image_block".$i."_title_margin"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title_margin') );
					 $s["image_block".$i."_subtitle_margin"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle_margin') );					 
				 	 
				 	 $s["image_block".$i."_title_txtcolor"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title_txtcolor') );
					 $s["image_block".$i."_subtitle_txtcolor"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle_txtcolor') );					
					
					 $s["image_block".$i."_title_txtsize"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title_txtsize') );
					 $s["image_block".$i."_subtitle_txtsize"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle_txtsize') );					
					
					 $s["image_block".$i."_title_font"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title_font') );
					 $s["image_block".$i."_subtitle_font"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle_font') );					
					
					 $s["image_block".$i."_title_txtw"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_title_txtw') );
					 $s["image_block".$i."_subtitle_txtw"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_subtitle_txtw') );					
					
			  		 $s["image_block".$i."_btn_show"] 		=	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_show') );					
					 $s["image_block".$i."_btn_txt"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_txt') );
					 $s["image_block".$i."_btn_bg"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_bg') );
					 $s["image_block".$i."_btn_bg_txt"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_bg_txt') );
					 $s["image_block".$i."_btn_icon"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_icon') );
					 $s["image_block".$i."_btn_icon_pos"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_icon_pos') );
					 $s["image_block".$i."_btn_size"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_size') );
					 $s["image_block".$i."_btn_margin"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_margin') );
					 $s["image_block".$i."_btn_style"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_style') );
					 $s["image_block".$i."_btn_font"] 	= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_font') );
					 $s["image_block".$i."_btn_link"] 		= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_block'.$i.'_btn_link') );
					
					 
						/* defaults */
						if($s["image_block".$i."_effect"]  == ""){ $s["image_block".$i."_effect"]  =  1; }	
						
						// REPLACE						
						$s["image_block".$i."_btn_link"] = $CORE->_ppt_filter_link($s["image_block".$i."_btn_link"]);
						
					$i++; 
					}
				
				}
				
				
				// LISTING PAGE
				if($cat == "listingpage"){	
					
					// TITLE
					//$s["listingpage_title_social"] 				= 	$CORE->LAYOUT("load_single_value", array($blockid, 'listingpage_title_social') );					
					$s["listingpage_title_style"] 				= 	$CORE->LAYOUT("load_single_value", array($blockid, 'listingpage_title_style') );
					
					// IMAGES
					$s["listingpage_images_style"] 				= 	$CORE->LAYOUT("load_single_value", array($blockid, 'listingpage_images_style') );
					
					
				}
				
				// GLOBAL ICON BLOCKS
				if($cat == "icon"){					
					$i=1; 
					
					$s["image_icon"] 				= 	$CORE->LAYOUT("load_single_value", array($blockid, 'image_icon') );
					
					while($i < 11){
						$s["icon".$i] 				= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i) );
						$s["icon".$i."_title"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_title') );
						$s["icon".$i."_desc"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_desc') );
						$s["icon".$i."_link"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_link') );
						$s["icon".$i."_txtcolor"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_txtcolor') );
						$s["icon".$i."_iconcolor"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_iconcolor') );
						
						// FILTER LINK
						$s["icon".$i."_link"] = $CORE->_ppt_filter_link($s["icon".$i."_link"]);
						
						
						$s["icon".$i."_type"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_type') );
						$s["icon".$i."_image"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'icon'.$i.'_image') );
						
						
						// REMOVE FAR
						$s["icon".$i]  = str_replace("far ","fa ", $s["icon".$i] );
						
						if($s["icon".$i."_txtcolor"] == ""){
							$s["icon".$i."_txtcolor"] = "dark";
						}
						
						if($s["icon".$i."_iconcolor"] == ""){
							$s["icon".$i."_iconcolor"] = "primary";
						}
						
						$i++; 
					}
					
				}
				
				
				
				// GLOBAL ICON BLOCKS
				if($cat == "hero"){	
				
					$s["hero_size"]			= $CORE->LAYOUT("load_single_value", array($blockid, 'hero_size'));
					if($s["hero_size"] == ""){
						$s["hero_size"] = "hero-large";
					} 
					
					// USED TO CONTROL MENU COLOR	
					$s["hero_txtcolor"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'hero_txtcolor') );
					if($s["hero_txtcolor"] == ""){
						$s["hero_txtcolor"] = "light";
					} 
					
					$s["hero_image"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'hero_image') );
					
					$s["hero_overlay"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'hero_overlay') );
					  	  
					 
				}
				
				// GLOBAL ICON BLOCKS
				if($cat == "cta"){
				
					$s["image_cta"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'image_cta' ) );						 
					 
				}
				
				// GLOBAL TEXT
				if($cat == "text" || $cat == "video"){
					 
					 	$i=1; 
						while($i < 7){
				
							$s["text_image".$i] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'text_image'.$i) );
							$s["text_image".$i."_title"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'text_image'.$i.'_title') );
							$s["text_image".$i."_link"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'text_image'.$i.'_link') );
							
							// FILTER LINK
							$s["text_image".$i."_link"] 	= $CORE->_ppt_filter_link($s["text_image".$i."_link"]);
						 
						$i++; 
						}						 
				}
				
				// GLOBAL VIDEO
				if($cat == "video"){
				
					$s["video_link"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'video_link') );
					if($s["video_link"] == ""){
						$s["video_link"] = "https://www.youtube.com/watch?v=8wSMWMHx1AI";
					}
				 
				}
				 
				
				// GLOBAL SLIDER
				if($cat == "slider"){					
					$i=1; 
					while($i < 4){
					 	
						// IMAGE
						$s["image".$i] 					= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i));
						$s["image".$i."_txtcolor"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_txtcolor'));
						$s["image".$i."_txtdir"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_txtdir'));						 	
						$s["image".$i."_title"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_title'));
						$s["image".$i."_desc"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_desc'));
						
						$s["image".$i."_btn_text"]		= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_btn_text'));
						$s["image".$i."_btn_link"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'image'.$i.'_btn_link'));
						
						// FILTER LINK
						$s["image".$i."_btn_link"] = $CORE->_ppt_filter_link($s["image".$i."_btn_link"]);
						 
						// defaults
						if(  $i == 1 && $s["image".$i] == ""){
						
							$s["image".$i] 	 			= $CORE->LAYOUT("get_placeholder", array('slider', $blockid) );
							
							$s["image".$i."_title"] 	= $CORE->LAYOUT("get_placeholder_text", array('title', $blockid ) );
							$s["image".$i."_desc"] 		= $CORE->LAYOUT("get_placeholder_text", array('desc', $blockid) );
							
							$s["image".$i."_txtcolor"] 		= "light";
							
							$s["image".$i."_btn_link"] 		= $this->_ppt_home_url()."/?s=";							
							
							if($i == 1){
								$s["image".$i."_txtdir"] 		= "left";
							}elseif($i == 2){
								$s["image".$i."_txtdir"] 		= "center";
							}else{
								$s["image".$i."_txtdir"] 		= "right";
							}
						
						}
						 
						 
						$i++; 
					}
				}			
				 		
				
				// GLOBAL FAQ BLOCKS
				if($cat == "faq"){
				
					$s["image_faq"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'image_faq' ) );
				 				
					$i=1; 
					while($i < 7){
						$s["faq".$i."_title"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'faq'.$i.'_title') );
						$s["faq".$i."_desc"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'faq'.$i.'_desc') );
						$i++; 
					}
				}
				
				// GLOBAL FAQ BLOCKS
				if($cat == "testimonials"){	
								
					$i=1; 
					while($i < 9){
					
						$s["author_quote".$i] 	= $CORE->LAYOUT("load_single_value", array($blockid, "author_quote".$i) );
						$s["author_name".$i] 	= $CORE->LAYOUT("load_single_value", array($blockid, "author_name".$i) );						
						$s["author_image".$i] 	= $CORE->LAYOUT("load_single_value", array($blockid, "author_image".$i) );
						$s["author_job".$i] 	= $CORE->LAYOUT("load_single_value", array($blockid, "author_job".$i) );
						
							if($s["author_quote".$i] == ""){
								$s["author_quote".$i] 		= $CORE->LAYOUT("get_placeholder_text", array('quote') );
							}
							if($s["author_name".$i] == ""){
								$s["author_name".$i] 		= $CORE->LAYOUT("get_placeholder_text", array('quote_name') );
							}
							if($s["author_job".$i] == ""){
								$s["author_job".$i] 		= $CORE->LAYOUT("get_placeholder_text", array('quote_job') );
							}
							if($s["author_image".$i] == ""){
								$s["author_image".$i] 		= $CORE->LAYOUT("get_placeholder", array('user', $i, $blockid ) );
							}
						
						$i++; 
					}
				}
					 
				// GLOBAL PRICING BLOCKS
				if($cat == "pricing"){	
				 			
				 	$s["pricing_type"] = $CORE->LAYOUT("load_single_value", array($blockid, 'pricing_type'));	
					
					if($s["pricing_type"] == ""){
						$s["pricing_type"]  = "memberships";
					}				
					
				 				
				}
				
				// GLOBAL FAQ BLOCKS
				if($cat == "listings"){	
				 			
				 	$s["perrow"] = $CORE->LAYOUT("load_single_value", array($blockid, 'perrow'));						
					$s["limit"] = $CORE->LAYOUT("load_single_value", array($blockid, 'limit'));					
					$s["card"] = $CORE->LAYOUT("load_single_value", array($blockid, 'card'));	
					$s["order"] = $CORE->LAYOUT("load_single_value", array($blockid, 'order'));
					$s["orderby"] = $CORE->LAYOUT("load_single_value", array($blockid, 'orderby'));
					$s["custom"] = $CORE->LAYOUT("load_single_value", array($blockid, 'custom'));
					$s["datastring"] = $CORE->LAYOUT("load_single_value", array($blockid, 'datastring'));
					  
					if($s["datastring"] == "" || $s["custom"] != ""){					
						$s['datastring'] = '
						dataonly="1" 
						cat="" 
						card="'.$s['card'].'"
						perrow="'.$s['perrow'].'" 
						show="'.$s['limit'].'" 
						custom="'.$s['custom'].'" 
						customvalue=""
						order="'.$s['order'].'" 
						orderby="'.$s['orderby'].'" 
						debug="0"	
						';
					}
					 			
				 				
				}
				
				// GLOBAL BLOG
				if($cat == "blog"){
				 
					 			
				}
				
				
				// GLOBAL GATEGORY BLOCKS
				if($cat == "category"){
				
					 $s["cat_order"]  	= $CORE->LAYOUT("load_single_value", array($blockid, 'cat_order' ) );
					 $s["cat_orderby"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'cat_orderby' ) );
					 $s["cat_show"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'cat_show' ) );
					 $s["cat_offset"] 	= $CORE->LAYOUT("load_single_value", array($blockid, 'cat_offset' ) );	
					 $s["cat_show_list"] 		= $CORE->LAYOUT("load_single_value", array($blockid, 'cat_show_list' ) );
					 
				}
				
				// GLOBAL SUBSCRIBE
				if($cat == "subscribe"){
				 
					$s["image_subscribe"] 			= $CORE->LAYOUT("load_single_value", array($blockid, 'image_subscribe' ) );
						
						/* defaults */
						if($s["image_subscribe"]  == ""){							
								$s["image_subscribe"] = $CORE->LAYOUT("get_placeholder", array(800,600 ) );
						}
				}  			
				
			 
				return $s;
			
			}
			
			return array();
		
		
		} break;		
		case "load_blocks": {
		
		
				 global $CORE, $CORE_ADMIN;
				 		
				$i=1;
				foreach($order_data as $key => $file){
				 
				
					if(!isset($file['name'])){ continue; }
					 
					
					if(!in_array($file['cat'], array('header','hero'))){
					
					$file['data']["seperator_section"] = array( "type" => "seperator-heading", "t" => "Section" );
					
					// ADDON EXTRA BLOCKS FOR GLOBAL VALUES
					$file['data']["section_bg"]  = array( 					
					"t" => "Background", 
					"type" => "select", 
					"values" => array(
					
					'bg-white' 		=> "White",					
					'bg-light' 		=> "Light" ,
					'bg-dark' 		=> "Dark",					
					'bg-primary' 	=> "Primary Color",
					'bg-secondary' 	=> "Secondary Color",	
						
						
						) 
					);
					
					/*
					$file['data']["section_divider"]  = array( 
						"t" => "Divider Style", 
						"type" => "select", 
						"values" => array(
							"divider-after" 	=> "divider-after",
							"divider-before" 	=> "divider-before", 
							"divider-both" 		=> "divider-both", 
							"" 					=> "No Divider"
						),
					);
					*/
					
					$file['data']["section_padding"]  = array( 
						"t" => "Padding", 
						"type" => "select", 
						"values" => array(
						
							"section-0" 		=> "No Padding",
							
							"section-120" 		=> "120px Padding",
							"section-100" 		=> "100px Padding", 
							"section-80" 		=> "80px Padding", 
							"section-60" 		=> "60px Padding", 						
							"section-40" 		=> "40px Padding",
							"section-20" 		=> "20px Padding",
							
							"a" => "------------",
							
							"section-top-40" 		=> "40px Padding Top",
							"section-top-60" 		=> "60px Padding Top",
							"section-top-80" 		=> "80px Padding Top",
							"section-top-100" 		=> "100px Padding Top",
							"section-top-120" 		=> "120px Padding Top",
							
							"b" => "------------",
							
							"section-bottom-40" 		=> "40px Padding Bottom",
							"section-bottom-60" 		=> "60px Padding Bottom",
							"section-bottom-80" 		=> "80px Padding Bottom",
							"section-bottom-100" 		=> "100px Padding Bottom",
							"section-bottom-120" 		=> "120px Padding Bottom",
						),
					);
					
					
					
					$file['data']["section_w"]  = array( 
						"t" => "Container Width", 
						"type" => "select", 
						"values" => array(
						
							'container-fluid' 	=> "Full Width (100%)",					
							'container' 		=> "Container (1300px)" ,
							'container-slim' 	=> "Slim (1000px)",
							
							 
						),
					);
					
					
					
					
					
					
					$file['data']["seperator1"] = array( "type" => "seperator-end" );
			 
					
					}
					/***********************************************************/
					
					
					
					// TITLE
					if(!in_array($file['cat'], array('header','footer')) && !isset($file['hide-title']) ){
					
					$file['data']["seperator_title"] = array( "type" => "seperator-heading", "t" => "Title" );
						 
						
					$file['data']["title"]			= array( "t" => "Title", "type" 		=> "text", "d" => $CORE->LAYOUT("get_placeholder_text", array('title', $file['cat']))   ); 
						
						
						$file['data']["title_show"] = array( 
								"t" => "Show Title",
								"type" => "yesno", 
								"values" => array(
									"yes" 	=> "Yes",
									"no" 	=> "No",
									 						
								), 
								"d" => "yes",
						);
						
						
							$file['data']["title_pos"] = array( 
								"t" => "Position",
								"type" => "select", 
								"values" => array(
									"left" 		=> "Left",
									"right" 	=> "Right",
									"center" 	=> "Center",
								), 
								"d" => "left",
						);
						
						$file['data']["title_heading"] = array( 
								"t" => "Heading",
								"type" => "select", 
								"values" => array(
									"h1" 	=> "H1",
									"h2" 	=> "H2",
									"h3" 	=> "H3", 
									"h4" 	=> "H4", 
								), 
								"d" => "left",
						);
						
						
						$file['data']["title_style"] = array( 
								"t" => "Title Style",
								"type" => "select", 
								"values" => array( 
									"1" 			=> "Style 1",
									"2" 			=> "Style 2",
									"3" 			=> "Style 3",
									"4" 			=> "Style 4",		
									"5" 			=> "Style 5",
									"6" 			=> "Style 6",
									//"7" 			=> "Style 7",						 
															
								), 
								"d" => "1",
						);
						
						
						
						$file['data']["title_font"] 		= array( "t" => "Font","type" => "select", "values" =>  $CORE->LAYOUT("get_fonts", array() ) );
						
						$file['data']["title_margin"] = array( 
								"t" => "Margin Bottom",
								"type" => "select", 
								"values" => array(
									'mb-0' => "0px",
									'mb-1' => "10px",
									'mb-2' => "20px",
									'mb-3' => "30px" ,
									'mb-4' => "40px",
									'mb-5' => "50px", 
								), 
								"d" => "mb0",
						);
						
						$file['data']["title_txtcolor"] = array( 
								"t" => "Text Color",
								"type" => "select", 
								"values" => array(
									
									'black' 	=> "Black", 
									
									'white' 	=> "White", 
									
									'light' 	=> "Light",
									'dark' 		=> "Dark",
									 
									"primary" 	=> "Primary Color", 
									"secondary" => "Secondary Color"
								), 
								"d" => "dark",
						);
						
						$file['data']["title_txtw"] = array( 
								"t" => "Bold",
								"type" => "select", 
								"values" => array(
									'font-weight-normal' 	=> "Normal", 
									'font-weight-bold' 		=> "Bold", 
									
									'text-300' 	=> "300",
									'text-500' 	=> "500",
									'text-700' 	=> "700",
									'text-800' 	=> "800",
									'text-900' 	=> "900",
								), 
								"d" => "font-weight-bold",
						);
						
						
						$file['data']["seperator_subtitle"] = array( "type" => "seperator", "t" => "Subtitle" );
						
						
						
						$file['data']["subtitle"] 		= array( "t" => "Subtitle", "type" 		=> "text",  "d" => $CORE->LAYOUT("get_placeholder_text", array('subtitle', $file['cat']))  ); 
						
						
						$file['data']["subtitle_margin"] = array( 
								"t" => "Margin Bottom",
								"type" => "select", 
								"values" => array(
									'mb-0' => "0px",
									'mb-1' => "10px",
									'mb-2' => "20px",
									'mb-3' => "30px" ,
									'mb-4' => "40px",
									'mb-5' => "50px", 
								), 
								"d" => "mb0",
						);
						
						$file['data']["subtitle_txtcolor"] = array( 
								"t" => "Text Color",
								"type" => "select", 
								"values" => array(
								
									
									'black' 	=> "Black", 
									'white' 	=> "White", 
									
									'light' 	=> "Light",
									'dark' 		=> "Dark",
									 
									"primary" 	=> "Primary Color", 
									"secondary" => "Secondary Color"
								), 
								"d" => "dark",
						);
						
						$file['data']["subtitle_font"] 		= array( "t" => "Font","type" => "select", "values" =>  $CORE->LAYOUT("get_fonts", array()) );
						
						$file['data']["subtitle_txtw"] = array( 
								"t" => "Bold",
								"type" => "select", 
								"values" => array(
									'font-weight-normal' 	=> "Normal", 
									'font-weight-bold' 		=> "Bold", 
									
									'text-300' 	=> "300",
									'text-500' 	=> "500",
									'text-700' 	=> "700",
									'text-800' 	=> "800",
									'text-900' 	=> "900",
								), 
								"d" => "font-weight-bold",
						);
						
						
						$file['data']["seperator_desc"] = array( "type" => "seperator", "t" => "Description" );
						
						
						
						$file['data']["desc"] 			= array( "t" => "Description","type" 	=> "textarea", "d" => $CORE->LAYOUT("get_placeholder_text", array('desc', $file['cat']))   ); 
						
						$file['data']["desc_margin"] = array( 
								"t" => "Margin Bottom",
								"type" => "select", 
								"values" => array(
									'mb-0' => "0px",
									'mb-1' => "10px",
									'mb-2' => "20px",
									'mb-3' => "30px" ,
									'mb-4' => "40px",
									'mb-5' => "50px", 
								), 
								"d" => "mb0",
						);
						
						$file['data']["desc_txtcolor"] = array( 
								"t" => "Text Color",
								"type" => "select", 
								"values" => array(
									
									'black' 	=> "Black", 
									'white' 	=> "White", 
									
									'light' 	=> "Light",
									'dark' 		=> "Dark",
									 
									"primary" 	=> "Primary Color", 
									"secondary" => "Secondary Color",
									
									"opacity-5" => "50% Black",
								), 
								"d" => "opacity-5",
						);
						
						$file['data']["desc_font"] 		= array( "t" => "Font","type" => "select", "values" =>  $CORE->LAYOUT("get_fonts", array()) );
						
						
						$file['data']["desc_txtw"] = array( 
								"t" => "Bold",
								"type" => "select", 
								"values" => array(
									'font-weight-normal' 	=> "Normal", 
									'font-weight-bold' 		=> "Bold", 
									
									'text-300' 	=> "300",
									'text-500' 	=> "500",
									'text-700' 	=> "700",
									'text-800' 	=> "800",
									'text-900' 	=> "900",
								), 
								"d" => "font-weight-normal",
						);						
						
						
						$file['data']["seperator_text1"] 	= array( "type" => "seperator-end" );
						
					}
					/***********************************************************/
					
					
					// GLOBAL BUTTON STYLES
					if(in_array($file['cat'], array('text','cta','header','faq','hero','icon','video') ) && !isset($file['hide-button1']) ){
					
						$file['data']["seperator_btn1"] = array( "type" => "seperator-heading", "t" => "Button 1" );
						
						$file['data']["btn_show"] 		= array( "t" => "Show Button","type" => "yesno", "values" => array( "yes" => "Enable", "no" => "disable" ), "d" => "yes" ); 		
						$file['data']["btn_txt"] 		= array( "t" => "Button Caption", "type" 		=> "text"  ); 
						$file['data']["btn_link"] 		= array( "t" => "Button Link", "type" 		=> "text"  ); 
						$file['data']["btn_bg"] 		= array( "t" => "Button Color","type" => "select", "values" => 
							array( 
							"primary" 	=> "Primary Button",
							"secondary" => "Secondary Button",
							"light" 	=> "Light Button",
							"dark" 		=> "Dark Button",
							
							"orange" => "Orange Button",
							
							)  
						); 
						$file['data']["btn_bg_txt"] 	= array( "t" => "Text Color","type" => "select", "values" => array( "light" => "Light","dark" => "Dark")  ); 
						
						
						$file['data']["btn_style"] 		= array( "t" => "Button Style","type" => "select", "values" => 
							array( 
							"1" 	=> "Normal",
							"2" 	=> "Outlined",	
							"3" 	=> "Normal Rounded",	
							"4" 	=> "Outlined Rounded",					 
							)  
						);
						
						$file['data']["btn_font"] 		= array( "t" => "Font","type" => "select", "values" =>  $CORE->LAYOUT("get_fonts", array()) );
						
						$file['data']["btn_size"] 		= array( "t" => "Button Size","type" => "select", "values" => 
							array( 
						 
							"btn-sm" 	=> "Small",
							"btn-md" 	=> "Medium",
							"btn-lg" 	=> "Large",
							"btn-xl" 	=> "Extra Large",
													 
							)  
						);
						
						
						$file['data']["btn_icon"] 		= array( "t" => "Button Icon", "type" 		=> "text" ); 
						
						$file['data']["btn_icon_pos"] 		= array( "t" => "Icon Position","type" => "select", "values" => 
							array( 							
							"before" 	=> "Before Text",
							"after" 	=> "After Text",													 
							)  
						);
						
						$file['data']["btn_margin"] 		= array( "t" => "Margin","type" => "select", "values" => 
							array( 							
							'mt-0' => "0px",
							'mt-1' => "10px",
							'mt-2' => "20px",
							'mt-3' => "30px" ,
							'mt-4' => "40px",
							'mt-5' => "50px",													 
							)  
						); 
						
						
						$file['data']["seperator_button21"] 	= array( "type" => "seperator-end" );
						
					
					} 
					/***********************************************************/
					
					
					
					// GLOBAL BUTTON STYLES
					if(in_array($file['cat'], array('text','faq','hero','icon','video') ) && !isset($file['hide-button2']) ){
					
						$file['data']["seperator_btn2"] = array( "type" => "seperator-heading", "t" => "Button 2 " );
						
						$file['data']["btn2_show"] 		= array( "t" => "Show Button","type" => "yesno", "values" => array( "yes" => "Enable", "no" => "disable" ), "d" => "yes"  ); 		
						$file['data']["btn2_txt"] 		= array( "t" => "Button Caption", "type" 		=> "text"  ); 
						$file['data']["btn2_link"] 		= array( "t" => "Button Link", "type" 		=> "text"  ); 
						$file['data']["btn2_bg"] 		= array( "t" => "Button Color","type" => "select", "values" => 
							array( 
							"primary" 	=> "Primary Button",
							"secondary" => "Secondary Button",
							"light" 	=> "Light Button",
							"dark" 		=> "Dark Button",
							)  
						); 
						$file['data']["btn2_bg_txt"] 	= array( "t" => "Text Color","type" => "select", "values" => array( "light" => "Light","dark" => "Dark")  ); 
						
						
						$file['data']["btn2_font"] 		= array( "t" => "Font","type" => "select", "values" =>  $CORE->LAYOUT("get_fonts", array() ) );
						
						$file['data']["btn2_style"] 		= array( "t" => "Button Style","type" => "select", "values" => 
							array( 
							"1" 	=> "Normal",
							"2" 	=> "Outlined",	
							"3" 	=> "Normal Rounded",	
							"4" 	=> "Outlined Rounded",					 
							)  
						);
						
						$file['data']["btn2_size"] 		= array( "t" => "Button Size","type" => "select", "values" => 
							array( 
						 
							"btn-sm" 	=> "Small",
							"btn-md" 	=> "Medium",
							"btn-lg" 	=> "Large",
							"btn-xl" 	=> "Extra Large",
													 
							),
							
							"d" => "btn-xl",
							
						);
						
						
						$file['data']["btn2_icon"] 		= array( "t" => "Button Icon", "type" 		=> "text", "d" => "fa fa-long-arrow-alt-right"  ); 
						
						$file['data']["btn2_icon_pos"] 		= array( "t" => "Icon Position","type" => "select", "values" => 
							array( 							
							"before" 	=> "Before Text",
							"after" 	=> "After Text",													 
							)  
						);
						
						$file['data']["btn2_margin"] 		= array( "t" => "Margin","type" => "select", "values" => 
							array( 							
							'mt-0' => "0px",
							'mt-1' => "10px",
							'mt-2' => "20px",
							'mt-3' => "30px" ,
							'mt-4' => "40px",
							'mt-5' => "50px",													 
							)  
						); 
						
						
						$file['data']["seperator_button22"] 	= array( "type" => "seperator-end" );
						
					
					} 
					/***********************************************************/
					
				 
				 
					
					// CTA
					if(in_array($file['cat'], array('cta'))){	
					
						 
						$file['data']["seperator_cta1"] 	= array( "type" => "seperator-heading", "t" => "Call to action" );				
					
						$file['data']["image_cta"] 		= array( "t" => "Image", "type" => "upload", "desc" => "This is used on some layout designs and might not apply to all."  );
						 
						$file['data']["seperator_cta2"] 	= array( "type" => "seperator-end" ); 
							
					}
					/***********************************************************/ 
					
					
					// ICONS
					if(in_array($file['cat'], array('icon'))){
						
						
						 	
						$i=1; 
						while($i < 10){
						
						$file['data']["seperator_icons".$i] 	= array( "type" => "seperator-heading", "t" => "Icon ".$i."" );				
							
						
					
							
							$file['data']["icon".$i.""] 	= array( "t" => "Icon Code <br> <small><a href='http://fontawesome.com/icons?d=gallery&q=' target='_blank'>Full list here</a></small>", "type" => "text", "placeholder" => "fa fa-cog",  ); 
							
							$file['data']["icon".$i."_title"] 	= array( "t" => "Title", "type" 		=> "text"  ); 
							$file['data']["icon".$i."_desc"] 	= array( "t" => "Description","type" 	=> "text"  );
							$file['data']["icon".$i."_link"] 	= array( "t" => "Link","type" 	=> "text"  );
							
$file['data']["icon".$i."_txtcolor"] 	= array( "t" => "Text Color", "type" => "select", "values" => 
							array( 
							"primary" 	=> "Primary Button",
							"secondary" => "Secondary Button",
							"light" 	=> "Light Button",
							"dark" 		=> "Dark Button",
							), 
						);
$file['data']["icon".$i."_iconcolor"] 	= array( "t" => "Icon Color", "type" => "select", "values" => 
							array( 
							"primary" 	=> "Primary Button",
							"secondary" => "Secondary Button",
							"light" 	=> "Light Button",
							"dark" 		=> "Dark Button",
							),
						 );
							
							$file['data']["seperator_icon".$i] 	= array( "type" => "seperator-end" ); 
					
							
							$i++; 
						}						
				 
						
						
						
					}
					/***********************************************************/
					
					
					
					// FAQ
					if(in_array($file['cat'], array('faq'))){
						
						$file['data']["seperator_faq1"] = array( "type" => "seperator-heading", "t" => "FAQ Data" );
						
						$file['data']["image_faq"] 		= array( "t" => "Image", "type" => "upload", "desc" => "This is used on some layout designs and might not apply to all."  ); 
									
						$i=1; 
						while($i < 7){
							$file['data']["faq".$i."_title"] 	= array( "t" => "FAQ ".$i." Title", "type" 		=> "text"  ); 
							$file['data']["faq".$i."_desc"] 	= array( "t" => "FAQ ".$i." Description","type" 	=> "textarea"  );
							$i++; 
						}
						
						$file['data']["seperator_faq2"] 	= array( "type" => "seperator-end" ); 
					
					}
					/***********************************************************/
					
					
					
					// SLIDER DETAILS					 
					if(in_array($file['cat'], array('slider'))){	
						
						$file['data']["seperator_slider"] 	= array( "type" => "seperator-heading", "t" => "Slider" ); 
										
						$i=1; 
						while($i < 4){
						
							$file['data']["seperator_im".$i] 	= array( "type" => "seperator", "t" => "Image ".$i ); 
							
							// IMAGE						 
							$file['data']["image".$i.""] 			= array( "t" => "Image ".$i."", "type" => "upload"  ); 						
							$file['data']["image".$i."_txtcolor"] 	= array( "t" => "Text Color","type" => "select", "values" => array( "light" => "light","dark" => "dark")  ); 	
							$file['data']["image".$i."_txtdir"] 	= array( "t" => "Text Direction","type" => "select", "values" => array("left" => "left","right" => "right" ,"center" => "center")  );
												 
							$file['data']["image".$i."_title"] 		= array( "t" => "Title", "type" 		=> "text"  ); 
							$file['data']["image".$i."_desc"] 		= array( "t" => "Description","type" 	=> "textarea"  ); 
							
							$file['data']["image".$i."_btn_text"] 	= array( "t" => "Button Text ","type" 	=> "text"  ); 
							$file['data']["image".$i."_btn_link"]	= array( "t" => "Button Link","type" 	=> "text"  );
							
							$file['data']["image".$i."_seperator"] = array( "type" => "seperator" );
							
							 
							$i++; 
						}
						
						$file['data']["seperator_slider"] 	= array( "type" => "seperator-end" ); 
					}		
					
					// REMOVE SECTION STYLES
					if(in_array($file['cat'], array('hero'))){
					
						$file['data']["seperator_hero"] = array( "type" => "seperator-heading", "t" => "Hero Image" );
						
						
						$file['data']["hero_size"]			= array( "t" => "Hero Size","type" => "select", "values" => 
							array( 
							"hero-small" 	=> "Slim",
							"hero-medium" 	=> "Normal",
							"hero-large" 	=> "Large",
							"hero-full" 	=> "Full Page",
							),
						); 
					  
						$file['data']["hero_image"] 		= array( "t" => "Image", "type" 		=> "upload"  ); 
						
						$file['data']["hero_txtcolor"] = array( 
								"t" => "Menu Color",
								"type" => "select", 
								"values" => array(
									"dark" 	=> "Dark",
									"light" 	=> "Light",
								), 
								"d" => "light",
						); 
						
						
							$file['data']["hero_overlay"] = array( 
								"t" => "Overlay Style",
								"type" => "select", 
								"values" => array(
									"" 	=> "None",
									"gradient" 	=> "Gradient",
									"black" 	=> "Black",
									"white" 	=> "White",
									"grey" 		=> "Grey",	
									"green" => "Green",									
									"primary" 	=> "Primary Color",
									"secondary" => "Secondary Color",								
									
								), 
								"d" => "",
						); 
						
						$file['data']["seperator_hero2"] 	= array( "type" => "seperator-end" ); 
						
						
					
					} 
					
					
					/***********************************************************/
					
					
						
					// USERS BLOCK					 
					if(in_array($file['cat'], array('users'))){
					
						$file['data']["user_type"] = array( 
								"t" => "User Type",
								"type" => "select", 
								"values" => array(
									"all" 	=> "All Users",
									"user_fr" 	=> "Freelancers",
									"user_em" 	=> "Employees",
								 	
								), 
								"d" => "all",
						); 
					}
					
					
					
						
					/***********************************************************/
					
					
						
					// IMAGE BLOCK					 
					if(in_array($file['cat'], array('image_block'))){	
					
					$file['data']["seperator_imageblock"] = array( "type" => "seperator-heading", "t" => "Images" );
						
									
						$i=1; 
						while($i < 7){
						
							$file['data']["seperator_imx".$i] 	= array( "type" => "seperator", "t" => "Image ".$i ); 
							
							// IMAGE						 
							$file['data']["image_block".$i.""] 			= array( "t" => "Image", "type" => "upload"  );
							 						
						 					 
							$file['data']["image_block".$i."_title"] 		= array( "t" => "Title", "type" 		=> "text"  ); 
							$file['data']["image_block".$i."_subtitle"] 		= array( "t" => "Subtitle","type" 	=> "text"  ); 
							
							$file['data']["image_block".$i."_link"] 		= array( "t" => "Link","type" 	=> "text"  ); 
							
							
							$file['data']["image".$i."_effect"] 	= array( "t" => "Text Direction","type" => "select", "values" => array(
							"1" => "1", "2" => "2" ,"3" => "3","4" => "4","5" => "5","6" => "6")  );
							
							
							$file['data']["image".$i."_txtcolor"] 	= array( "t" => "Text Color","type" => "select", "values" => array('dark' => "Dark",'light' => "White")  );
							
							$file['data']["image".$i."_txtpos"] 	= array( "t" => "Text Color","type" => "select", "values" => array(
							
							'tleft' => "Top Left",
							"tright" => "Top Right",
							"tcenter" => "Top Centered",					
							'ccenter' => "Centered", 					
							'bleft' => "Bottom Left",
							"bright" => "Bottom Right",
							"bcenter" => "Bottom Centered",
							)  );
							
							
							 
							$i++; 
						}
						
						
						$file['data']["seperator_imageblock2"] 	= array( "type" => "seperator-end" );
						
					}	
					/***********************************************************/
					
					
					// LISTINGS DETAILS					 
					if(in_array($file['cat'], array('listings'))){
					 
					
					$file['data']["seperator_listings"] = array( "type" => "seperator-heading", "t" => "Auction Data" );
					
					$file['data']["custom"] =  array( "t" => "Data","type" => "select", "values" => _ppt_custom_searchlist() , "d"=>"random" );				  
					
					
					$file['data']["perrow"] = array( "t" => "Per Row", "type" 		=> "text", "d" => 4  );					 	
					$file['data']["limit"] = array( "t" => "Limit", "type" 		=> "text", "d" => 12  ); 						
					$file['data']["card"] = array( "t" => "Display","type" => "select", "values" => array(
							
						'small' 		=> 'Small',
						'blank' 		=> 'Blank',
						'info' 			=> 'Info',
						'list' 			=> 'List',
						'list-small' 	=> 'List Small',
					
					),
					"d"=>"info",
					  );					 		
					
					
					$file['data']["orderby"] =  array( "t" => "Order By","type" => "select", "values" => array(
							
					'ID' => 'Post ID',
					'author' => 'Post Author',
					'title' => 'Title',
					'date' => 'Date',
					'modified' => 'Last Modified Date',				
					'rand' => 'Random',				
					'menu_order' => 'Menu Order',
					
					),
					"d"=>"ID",
					  );
					  
					  $file['data']["order"] =  array( "t" => "Order","type" => "select", "values" => array(
							
						'asc' => 'Ascending',
                   	 	'desc' => 'Descending'
					
						),
					"d"=>"asc",
					 );
					 
							
					$file['data']["seperator_listings2"] 	= array( "type" => "seperator-end" );			
					
					
					
					}	
					/***********************************************************/
					
					// HEADER
				if($file['cat'] == "header"){
				
					$file['data']["seperator_sub"] = array( "type" => "seperator-heading", "t" => "Header" );
				 	 
					$file['data']["topmenu_show"] 	= array( "t" => "Show Top Menu","type" => "yesno", "values" => array( "yes" => "Enable", "no" => "disable" ), "d" => "yes"  ); 		
					$file['data']["extra_show"] 	= array( "t" => "Show Extra","type" => "yesno", "values" => array( "yes" => "Enable", "no" => "disable" ), "d" => "yes"  ); 				  	 	
					$file['data']["extra_type"] 	= array( "t" => "Show Extra","type" => "select", "values" => array( "" => "Phone", "icons" => "Icons" ), "d" => ""  ); 
					
					
				  	/* defaults */
					if($file['data']["topmenu_show"]  == ""){ $file['data']["topmenu_show"]  = "yes"; }	
					if($file['data']["extra_show"]  == ""){ $file['data']["extra_show"]  = "yes"; }		
					
					$file['data']["seperator_sub2"] 	= array( "type" => "seperator-end" );				 
					
				}
				
				
				
					/***********************************************************/
					
					// FOOTER
				if($file['cat'] == "footer"){
				
					$file['data']["seperator_sub"] = array( "type" => "seperator-heading", "t" => "Footer Menu" );
					
					 
					 
					$file['data']["footer_copyright_style"] 	= array( "t" => "Copyright Style","type" => "select", "values" =>  array(
					""		=> "Default",
					"1" 	=> "Text Left",
					"2" 	=> "Text Center",	
					"3" 	=> "Text Right",	
					"4" 	=> "Text + Cards",
					"5" 	=> "Text + Social",
					"6" 	=> "Text + Links",
				), "d" => ""  ); 
					
					
				 	$file['data']["footer_copyright"] = array( 					 
					 "t" 		=> "Copyright Text", 
					 "type" 	=> "text", 
					 "d" 		=> "&copy; ".date("Y")." ".stripslashes(_ppt(array('company','name')))." ". __("All rights reserved.","premiumpress") 
					);					  
					 
				    $file['data']["footer_description"] = array( "t" => "Footer Description", "type" 		=> "textarea", "d" => _ppt(array('company','mission'))  );	
					
				 	
					$file['data']["footer_menu1_title"] = array( "t" => "Links Title 1", "type" 		=> "text", "d" => "Useful Links"  );	
					  
					 
					$file['data']["footer_menu1"] 	= array( "t" => "Links Menu 1","type" => "select", "values" => _ppt_elementor_menus(), "d" => ""  ); 
					
					
					$file['data']["footer_menu2_title"] = array( "t" => "Links Title 2", "type" 		=> "text", "d" => "Members"  );	
					
					
					$file['data']["footer_menu2"] 	= array( "t" => "Links Menu 2","type" => "select", "values" => _ppt_elementor_menus(), "d" => ""  ); 
					
					 
					
					$file['data']["seperator_sub2"] 	= array( "type" => "seperator-end" );				 
					
				}
				
				
				
				
				
					/***********************************************************/
					
					// SUBSCRIBER DETAILS					 
					if(in_array($file['cat'], array('subscribe'))){
					
						$file['data']["seperator_sub"] = array( "type" => "seperator-heading", "t" => "Subscribe" );
					
						$file['data']["image_subscribe"] 		= array( "t" => "Image", "type" 		=> "upload"  ); 
						
						$file['data']["seperator_sub2"] 	= array( "type" => "seperator-end" );					
					
					}
					/***********************************************************/
					
					// GLOBAL TESTIMONIALS BLOCKS				 
					if(in_array($file['cat'], array('testimonials'))){
					
						$file['data']["seperator_test"] = array( "type" => "seperator-heading", "t" => "Testimonials" );
									
						$i=1; 
						while($i < 9){
						
							$file['data']["author_quote".$i] 	= array( "t" => "Quote", "type" 	=> "textarea"  ); 
							$file['data']["author_name".$i] 	= array( "t" => "Name", "type" 		=> "text"  ); 					
							$file['data']["author_image".$i]  	= array( "t" => "Image", "type" 	=> "upload"  );
							$file['data']["author_job".$i] 		= array( "t" => "Job Title", "type" => "text"  ); 
							
							
							$i++; 
						}
						
						$file['data']["seperator_test2"] 	= array( "type" => "seperator-end" );
					}	
					/***********************************************************/
					
					
					// GLOBAL TEXT IMAGES
					if(in_array($file['cat'], array('text','video'))){
					
							$file['data']["seperator_images"] = array( "type" => "seperator-heading", "t" => "Images" );
						
						 
							$i=1; 
							while($i < 3){
							
								$file['data']["seperator_im".$i] 	= array( "type" => "seperator", "t" => "Image ".$i ); 
					
								$file['data']["text_image".$i] 			= array( "t" => "Image", "type" 	=> "upload"  );
								$file['data']["text_image".$i."_title"] 	= array( "t" => "Title", "type" 		=> "text"  ); 
								$file['data']["text_image".$i."_link"] 	= array( "t" => "Link", "type" 		=> "text"  ); 							 
							 
							$i++; 
							}	
							
							$file['data']["seperator_images2"] 	= array( "type" => "seperator-end" );					 
					}		
					  
					
					
					$image = $CORE->LAYOUT("get_block_prewview", $key );
				 
				?> 
                  
				<section 
   <?php if(isset($_GET['sid']) && $_GET['sid'] != $key){ ?>style="display:none;"<?php } ?> class=" mt-n3 styletype styletype-<?php echo $file['cat']; ?>">
   
   	<h3 class="pl-4"><?php echo $file['name']; ?></h3>
    <hr />
    
   
    
    <?php if(isset($file['data']) && !empty($file['data']) && count($file['data']) > 3){  ?>
   
                           
                           <?php
						   if(isset($_GET['sid']) && $_GET['sid'] == $key){ 
							
								if(isset($_GET['pagekey'])){
									$pagekey = $_GET['pagekey'];
								}else{
									$pagekey = "home";
								}	
								
								
															 
								echo $CORE->CustomDesignEdit($key, $file, $pagekey);						   	
						   }
						    
						   ?>
                           
         <div id="v-<?php echo $key; ?>-<?php echo $i; ?>-settings-ajax"></div>
         
       <div class="p-4 text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>
        <?php }else{ ?>
        
        <div class="py-4 text-center"><?php echo __("No settings available for this design.","premiumpress"); ?></div>
        
        <?php }  ?> 
                   
              
</section><?php $i++; }   
 
		} break;	
		
		case "default_innerpages": {
		
		$core = $order_data;
		
/*
STORES
*/		

 
        /* text8 */    
        $core["page_stores"]["text8"]["section_padding"] = "section-40";     
        $core["page_stores"]["text8"]["section_bg"] = "bg-light";     
        $core["page_stores"]["text8"]["section_pos"] = "";     
        $core["page_stores"]["text8"]["section_w"] = "container";     
        $core["page_stores"]["text8"]["section_pattern"] = "";     
        $core["page_stores"]["text8"]["title_show"] = "yes";     
        $core["page_stores"]["text8"]["title"] = "All Stores";     
        $core["page_stores"]["text8"]["subtitle"] = "Don't miss a thing!";     
        $core["page_stores"]["text8"]["desc"] = "";     
        $core["page_stores"]["text8"]["title_style"] = "h2-2";     
        $core["page_stores"]["text8"]["title_pos"] = "left";     
        $core["page_stores"]["text8"]["title_heading"] = "h2";     
        $core["page_stores"]["text8"]["title_margin"] = "mb-4";     
        $core["page_stores"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_stores"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_stores"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_stores"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_stores"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_stores"]["text8"]["title_font"] = "";     
        $core["page_stores"]["text8"]["subtitle_font"] = "";     
        $core["page_stores"]["text8"]["desc_font"] = "";     
        $core["page_stores"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_stores"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
 
        /* stores2 */    
        $core["page_stores"]["stores2"]["section_padding"] = "section-40";     
        $core["page_stores"]["stores2"]["section_bg"] = "bg-white";     
        $core["page_stores"]["stores2"]["section_pos"] = "";     
        $core["page_stores"]["stores2"]["section_w"] = "container";     
        $core["page_stores"]["stores2"]["section_pattern"] = "";     
        $core["page_stores"]["stores2"]["title_show"] = "yes";     
        $core["page_stores"]["stores2"]["title"] = "Popular Stores";     
        $core["page_stores"]["stores2"]["subtitle"] = "We've got exactly what you're looking for!";     
        $core["page_stores"]["stores2"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";     
        $core["page_stores"]["stores2"]["title_style"] = "2";     
        $core["page_stores"]["stores2"]["title_pos"] = "left";     
        $core["page_stores"]["stores2"]["title_heading"] = "h2";     
        $core["page_stores"]["stores2"]["title_margin"] = "mb-4";     
        $core["page_stores"]["stores2"]["subtitle_margin"] = "mb-4";     
        $core["page_stores"]["stores2"]["desc_margin"] = "mb-4";     
        $core["page_stores"]["stores2"]["title_txtcolor"] = "dark";     
        $core["page_stores"]["stores2"]["subtitle_txtcolor"] = "dark";     
        $core["page_stores"]["stores2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_stores"]["stores2"]["title_font"] = "";     
        $core["page_stores"]["stores2"]["subtitle_font"] = "";     
        $core["page_stores"]["stores2"]["desc_font"] = "";     
        $core["page_stores"]["stores2"]["title_txtw"] = "font-weight-bold";     
        $core["page_stores"]["stores2"]["subtitle_txtw"] = "font-weight-bold"; 		

 
		
/*
MEMBERSHIPS
*/
      /* pricing1 */    
        $core["page_memberships"]["pricing2"]["section_padding"] = "section-60";     
        $core["page_memberships"]["pricing2"]["section_bg"] = "bg-white";     
        $core["page_memberships"]["pricing2"]["section_pos"] = "";     
        $core["page_memberships"]["pricing2"]["section_w"] = "container";     
        $core["page_memberships"]["pricing2"]["section_pattern"] = "";     
        $core["page_memberships"]["pricing2"]["title_show"] = "yes";     
        $core["page_memberships"]["pricing2"]["title"] = "Membership Pricing";     
        $core["page_memberships"]["pricing2"]["subtitle"] = "All prices include a 30-day money back guarantee.";     
        $core["page_memberships"]["pricing2"]["desc"] = "";     
        $core["page_memberships"]["pricing2"]["title_style"] = "1";     
        $core["page_memberships"]["pricing2"]["title_pos"] = "center";     
        $core["page_memberships"]["pricing2"]["title_heading"] = "h1";     
        $core["page_memberships"]["pricing2"]["title_margin"] = "mb-4";     
        $core["page_memberships"]["pricing2"]["subtitle_margin"] = "mb-4";     
        $core["page_memberships"]["pricing2"]["desc_margin"] = "mb-4";     
        $core["page_memberships"]["pricing2"]["title_txtcolor"] = "dark";     
        $core["page_memberships"]["pricing2"]["subtitle_txtcolor"] = "dark";     
        $core["page_memberships"]["pricing2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_memberships"]["pricing2"]["title_font"] = "";     
        $core["page_memberships"]["pricing2"]["subtitle_font"] = "";     
        $core["page_memberships"]["pricing2"]["desc_font"] = "";     
        $core["page_memberships"]["pricing2"]["title_txtw"] = "font-weight-bold";     
        $core["page_memberships"]["pricing2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_memberships"]["pricing2"]["pricing_type"] = "memberships"; 		
 
        /* icon10 */    
        $core["page_memberships"]["icon10"]["section_padding"] = "section-80";     
        $core["page_memberships"]["icon10"]["section_bg"] = "bg-light";     
        $core["page_memberships"]["icon10"]["section_pos"] = "";     
        $core["page_memberships"]["icon10"]["section_w"] = "container";     
        $core["page_memberships"]["icon10"]["section_pattern"] = "";     
        $core["page_memberships"]["icon10"]["title_show"] = "yes";     
        $core["page_memberships"]["icon10"]["title"] = "Our Promise";     
        $core["page_memberships"]["icon10"]["subtitle"] = "7 Day Refund Policy";     
        $core["page_memberships"]["icon10"]["desc"] = "Purchase any of our membership packages today and test drive our website with full access. If your unhappy with our service you can contact us for a refund within 7 days for a full refund.";     
        $core["page_memberships"]["icon10"]["title_style"] = "1";     
        $core["page_memberships"]["icon10"]["title_pos"] = "left";     
        $core["page_memberships"]["icon10"]["title_heading"] = "h2";     
        $core["page_memberships"]["icon10"]["title_margin"] = "mb-4";     
        $core["page_memberships"]["icon10"]["subtitle_margin"] = "mb-4";     
        $core["page_memberships"]["icon10"]["desc_margin"] = "mb-4";     
        $core["page_memberships"]["icon10"]["title_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["subtitle_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["desc_txtcolor"] = "opacity-5";     
        $core["page_memberships"]["icon10"]["title_font"] = "";     
        $core["page_memberships"]["icon10"]["subtitle_font"] = "";     
        $core["page_memberships"]["icon10"]["desc_font"] = "";     
        $core["page_memberships"]["icon10"]["title_txtw"] = "font-weight-bold";     
        $core["page_memberships"]["icon10"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_memberships"]["icon10"]["btn_show"] = "no";     
        $core["page_memberships"]["icon10"]["btn2_show"] = "no";     
        $core["page_memberships"]["icon10"]["icon1"] = "";     
        $core["page_memberships"]["icon10"]["icon1_title"] = "7 Day Money Back Guarantee.";     
        $core["page_memberships"]["icon10"]["icon1_desc"] = " ";     
        $core["page_memberships"]["icon10"]["icon1_link"] = "";     
        $core["page_memberships"]["icon10"]["icon1_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["icon1_iconcolor"] = "primary";     
        $core["page_memberships"]["icon10"]["icon1_type"] = "icon";     
        $core["page_memberships"]["icon10"]["icon2"] = "";     
        $core["page_memberships"]["icon10"]["icon2_title"] = "Secure Online Payments.";     
        $core["page_memberships"]["icon10"]["icon2_desc"] = " ";     
        $core["page_memberships"]["icon10"]["icon2_link"] = "";     
        $core["page_memberships"]["icon10"]["icon2_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["icon2_iconcolor"] = "primary";     
        $core["page_memberships"]["icon10"]["icon2_type"] = "icon";     
        $core["page_memberships"]["icon10"]["icon3"] = "";     
        $core["page_memberships"]["icon10"]["icon3_title"] = "Instant Access After Payment";     
        $core["page_memberships"]["icon10"]["icon3_desc"] = " ";     
        $core["page_memberships"]["icon10"]["icon3_link"] = "";     
        $core["page_memberships"]["icon10"]["icon3_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["icon3_iconcolor"] = "primary";     
        $core["page_memberships"]["icon10"]["icon3_type"] = "icon";     
        $core["page_memberships"]["icon10"]["icon4"] = "";     
        $core["page_memberships"]["icon10"]["icon4_title"] = "24/7 Help & Online Support";     
        $core["page_memberships"]["icon10"]["icon4_desc"] = " ";     
        $core["page_memberships"]["icon10"]["icon4_link"] = "";     
        $core["page_memberships"]["icon10"]["icon4_txtcolor"] = "dark";     
        $core["page_memberships"]["icon10"]["icon4_iconcolor"] = "primary";     
        $core["page_memberships"]["icon10"]["icon4_type"] = "icon"; 	

/*
HOW
*/

		if(defined('THEME_KEY') && THEME_KEY == "cp"){
 		
		/* text8 */    
        $core["page_how"]["text8"]["section_padding"] = "section-40";     
        $core["page_how"]["text8"]["section_bg"] = "bg-light";     
        $core["page_how"]["text8"]["section_pos"] = "";     
        $core["page_how"]["text8"]["section_w"] = "container";     
        $core["page_how"]["text8"]["section_pattern"] = "";     
        $core["page_how"]["text8"]["title_show"] = "yes";     
        $core["page_how"]["text8"]["title"] = "How it works";     
        $core["page_how"]["text8"]["subtitle"] = "Save Time & Money";     
        $core["page_how"]["text8"]["desc"] = "";     
        $core["page_how"]["text8"]["title_style"] = "h2-2";     
        $core["page_how"]["text8"]["title_pos"] = "left";     
        $core["page_how"]["text8"]["title_heading"] = "h2";     
        $core["page_how"]["text8"]["title_margin"] = "mb-4";     
        $core["page_how"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_how"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_how"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_how"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["text8"]["title_font"] = "";     
        $core["page_how"]["text8"]["subtitle_font"] = "";     
        $core["page_how"]["text8"]["desc_font"] = "";     
        $core["page_how"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* text1 */    
        $core["page_how"]["text1"]["section_padding"] = "section-100";     
        $core["page_how"]["text1"]["section_bg"] = "bg-white";     
        $core["page_how"]["text1"]["section_pos"] = "";     
        $core["page_how"]["text1"]["section_w"] = "container";     
        $core["page_how"]["text1"]["section_pattern"] = "";     
        $core["page_how"]["text1"]["title_show"] = "yes";     
        $core["page_how"]["text1"]["title"] = "Browse. Shop. Get Paid!";     
        $core["page_how"]["text1"]["subtitle"] = "Shop online and get money back";     
        $core["page_how"]["text1"]["desc"] = "Shop through our website via any of 100+ stores and earn Cash Back whenever you make a purchase.<br> <br>After you make a purchase simple send us your order ID so we can verify the order and we'll add your earnings to your account. ";     
        $core["page_how"]["text1"]["title_style"] = "1";     
        $core["page_how"]["text1"]["title_pos"] = "left";     
        $core["page_how"]["text1"]["title_heading"] = "h2";     
        $core["page_how"]["text1"]["title_margin"] = "mb-4";     
        $core["page_how"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["page_how"]["text1"]["desc_margin"] = "mb-4";     
        $core["page_how"]["text1"]["title_txtcolor"] = "dark";     
        $core["page_how"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["text1"]["title_font"] = "";     
        $core["page_how"]["text1"]["subtitle_font"] = "";     
        $core["page_how"]["text1"]["desc_font"] = "";     
        $core["page_how"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_how"]["text1"]["btn_show"] = "no";     
        $core["page_how"]["text1"]["btn2_show"] = "no";     
        $core["page_how"]["text1"]["text_image1"] = DEMO_IMG_PATH."/innerpages/2.jpg";     
        $core["page_how"]["text1"]["text_image1_title"] = "";     
        $core["page_how"]["text1"]["text_image1_link"] = ""; 		
 
        /* stores1 */    
        $core["page_how"]["stores1"]["section_padding"] = "section-100";     
        $core["page_how"]["stores1"]["section_bg"] = "bg-white";     
        $core["page_how"]["stores1"]["section_pos"] = "";     
        $core["page_how"]["stores1"]["section_w"] = "container";     
        $core["page_how"]["stores1"]["section_pattern"] = "";     
        $core["page_how"]["stores1"]["title_show"] = "yes";     
        $core["page_how"]["stores1"]["title"] = "Popular Stores";     
        $core["page_how"]["stores1"]["subtitle"] = "Shop online and get money back";     
        $core["page_how"]["stores1"]["desc"] = "Shop through our website via any of 100+ stores and earn Cash Back whenever you make a purchase.<br> <br>After you make a purchase simple send us your order ID so we can verify the order and we'll add your earnings to your account. ";     
        $core["page_how"]["stores1"]["title_style"] = "1";     
        $core["page_how"]["stores1"]["title_pos"] = "left";     
        $core["page_how"]["stores1"]["title_heading"] = "h2";     
        $core["page_how"]["stores1"]["title_margin"] = "mb-4";     
        $core["page_how"]["stores1"]["subtitle_margin"] = "mb-4";     
        $core["page_how"]["stores1"]["desc_margin"] = "mb-4";     
        $core["page_how"]["stores1"]["title_txtcolor"] = "dark";     
        $core["page_how"]["stores1"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["stores1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["stores1"]["title_font"] = "";     
        $core["page_how"]["stores1"]["subtitle_font"] = "";     
        $core["page_how"]["stores1"]["desc_font"] = "";     
        $core["page_how"]["stores1"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["stores1"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* faq3 */    
        $core["page_how"]["faq3"]["section_padding"] = "section-100";     
        $core["page_how"]["faq3"]["section_bg"] = "bg-light";     
        $core["page_how"]["faq3"]["section_pos"] = "";     
        $core["page_how"]["faq3"]["section_w"] = "container";     
        $core["page_how"]["faq3"]["section_pattern"] = "";     
        $core["page_how"]["faq3"]["title_show"] = "yes";     
        $core["page_how"]["faq3"]["title"] = "Have a question?";     
        $core["page_how"]["faq3"]["subtitle"] = "We're here to help, if you cant find an answer below, contact us!";     
        $core["page_how"]["faq3"]["desc"] = "";     
        $core["page_how"]["faq3"]["title_style"] = "1";     
        $core["page_how"]["faq3"]["title_pos"] = "left";     
        $core["page_how"]["faq3"]["title_heading"] = "h2";     
        $core["page_how"]["faq3"]["title_margin"] = "mb-4";     
        $core["page_how"]["faq3"]["subtitle_margin"] = "mb-5";     
        $core["page_how"]["faq3"]["desc_margin"] = "mb-4";     
        $core["page_how"]["faq3"]["title_txtcolor"] = "dark";     
        $core["page_how"]["faq3"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["faq3"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["faq3"]["title_font"] = "";     
        $core["page_how"]["faq3"]["subtitle_font"] = "";     
        $core["page_how"]["faq3"]["desc_font"] = "";     
        $core["page_how"]["faq3"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["faq3"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_how"]["faq3"]["btn_show"] = "yes";     
        $core["page_how"]["faq3"]["btn_link"] = "[link-join]";     
        $core["page_how"]["faq3"]["btn_txt"] = "Sign-up Now!";     
        $core["page_how"]["faq3"]["btn_bg"] = "primary";     
        $core["page_how"]["faq3"]["btn_bg_txt"] = "";     
        $core["page_how"]["faq3"]["btn_icon"] = "";     
        $core["page_how"]["faq3"]["btn_icon_pos"] = "before";     
        $core["page_how"]["faq3"]["btn_size"] = "btn-xl";     
        $core["page_how"]["faq3"]["btn_margin"] = "mt-0";     
        $core["page_how"]["faq3"]["btn_style"] = "1";     
        $core["page_how"]["faq3"]["btn_font"] = "";     
        $core["page_how"]["faq3"]["faq1_title"] = "How do i get cash back?";     
        $core["page_how"]["faq3"]["faq1_desc"] = "Create a free account on our website and whenever you make a purchase via one of the stores/links on our website - send us the order details and we'll credit your account with any earning you've made.";     
        $core["page_how"]["faq3"]["faq2_title"] = "Can i redeem my old orders?";     
        $core["page_how"]["faq3"]["faq2_desc"] = "Maybe - If you've used our links to purchase an order we might be able to get the cashback for you. Send us the order details and we can check for you.";     
        $core["page_how"]["faq3"]["faq3_title"] = "Must I be a member?";     
        $core["page_how"]["faq3"]["faq3_desc"] = "Yes - we can only provide members with cash back - creating an account is completely free.";     
        $core["page_how"]["faq3"]["image_faq"] = "";
		
		}else{
 
 
        /* text8 */    
        $core["page_how"]["text8"]["section_padding"] = "section-40";     
        $core["page_how"]["text8"]["section_bg"] = "bg-light";     
        $core["page_how"]["text8"]["section_pos"] = "";     
        $core["page_how"]["text8"]["section_w"] = "container";     
        $core["page_how"]["text8"]["title_show"] = "yes";     
        $core["page_how"]["text8"]["title"] = "How it works";     
        $core["page_how"]["text8"]["subtitle"] = "Learn More";     
        $core["page_how"]["text8"]["desc"] = "";     
        $core["page_how"]["text8"]["title_style"] = "h2-2";     
        $core["page_how"]["text8"]["title_pos"] = "left";     
        $core["page_how"]["text8"]["title_heading"] = "h2";     
        $core["page_how"]["text8"]["title_margin"] = "mb-4";     
        $core["page_how"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_how"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_how"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_how"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["text8"]["title_font"] = "";     
        $core["page_how"]["text8"]["subtitle_font"] = "";     
        $core["page_how"]["text8"]["desc_font"] = "";     
        $core["page_how"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* text1 */    
        $core["page_how"]["text1"]["section_padding"] = "section-100";     
        $core["page_how"]["text1"]["section_bg"] = "bg-white";     
        $core["page_how"]["text1"]["section_pos"] = "";     
        $core["page_how"]["text1"]["section_w"] = "container";     
        $core["page_how"]["text1"]["title_show"] = "yes";     
        $core["page_how"]["text1"]["title"] = "Learn how to use our website in 3 easy steps.";     
        $core["page_how"]["text1"]["subtitle"] = "Here to help provide a better service";     
        $core["page_how"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";     
        $core["page_how"]["text1"]["title_style"] = "1";     
        $core["page_how"]["text1"]["title_pos"] = "left";     
        $core["page_how"]["text1"]["title_heading"] = "h2";     
        $core["page_how"]["text1"]["title_margin"] = "mb-4";     
        $core["page_how"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["page_how"]["text1"]["desc_margin"] = "mb-4";     
        $core["page_how"]["text1"]["title_txtcolor"] = "dark";     
        $core["page_how"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["text1"]["title_font"] = "";     
        $core["page_how"]["text1"]["subtitle_font"] = "";     
        $core["page_how"]["text1"]["desc_font"] = "";     
        $core["page_how"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_how"]["text1"]["btn_show"] = "yes";     
        $core["page_how"]["text1"]["btn_link"] = "[link-contact]";     
        $core["page_how"]["text1"]["btn_txt"] = "Contact Us";     
        $core["page_how"]["text1"]["btn_bg"] = "primary";     
        $core["page_how"]["text1"]["btn_bg_txt"] = "text-light";     
        $core["page_how"]["text1"]["btn_icon"] = "";     
        $core["page_how"]["text1"]["btn_icon_pos"] = "before";     
        $core["page_how"]["text1"]["btn_size"] = "btn-xl";     
        $core["page_how"]["text1"]["btn_margin"] = "mt-0";     
        $core["page_how"]["text1"]["btn_style"] = "5";     
        $core["page_how"]["text1"]["btn_font"] = "";     
        $core["page_how"]["text1"]["btn2_show"] = "no";     
        $core["page_how"]["text1"]["text_image1"] = DEMO_IMG_PATH."innerpages/3.jpg";     
        $core["page_how"]["text1"]["text_image1_title"] = "";     
        $core["page_how"]["text1"]["text_image1_link"] = ""; 		
 
        /* icon3 */    
        $core["page_how"]["icon3"]["section_padding"] = "section-bottom-60";     
        $core["page_how"]["icon3"]["section_bg"] = "bg-white";     
        $core["page_how"]["icon3"]["section_pos"] = "";     
        $core["page_how"]["icon3"]["section_w"] = "container";     
        $core["page_how"]["icon3"]["title_show"] = "no";     
        $core["page_how"]["icon3"]["btn_show"] = "no";     
        $core["page_how"]["icon3"]["btn2_show"] = "no"; 		
 
        /* faq1 */    
        $core["page_how"]["faq1"]["section_padding"] = "section-100";     
        $core["page_how"]["faq1"]["section_bg"] = "bg-light";     
        $core["page_how"]["faq1"]["section_pos"] = "";     
        $core["page_how"]["faq1"]["section_w"] = "container";     
        $core["page_how"]["faq1"]["title_show"] = "yes";     
        $core["page_how"]["faq1"]["title"] = "We're here to help!";     
        $core["page_how"]["faq1"]["subtitle"] = "Optimized for speed and search engines.";     
        $core["page_how"]["faq1"]["desc"] = "";     
        $core["page_how"]["faq1"]["title_style"] = "1";     
        $core["page_how"]["faq1"]["title_pos"] = "left";     
        $core["page_how"]["faq1"]["title_heading"] = "h2";     
        $core["page_how"]["faq1"]["title_margin"] = "mb-4";     
        $core["page_how"]["faq1"]["subtitle_margin"] = "mb-5";     
        $core["page_how"]["faq1"]["desc_margin"] = "mb-4";     
        $core["page_how"]["faq1"]["title_txtcolor"] = "dark";     
        $core["page_how"]["faq1"]["subtitle_txtcolor"] = "dark";     
        $core["page_how"]["faq1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_how"]["faq1"]["title_font"] = "";     
        $core["page_how"]["faq1"]["subtitle_font"] = "";     
        $core["page_how"]["faq1"]["desc_font"] = "";     
        $core["page_how"]["faq1"]["title_txtw"] = "font-weight-bold";     
        $core["page_how"]["faq1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_how"]["faq1"]["btn_show"] = "no";     
        $core["page_how"]["faq1"]["image_faq"] = DEMO_IMG_PATH."innerpages/4.jpg"; 		

 
		}

/*
TESTIMONIALS
*/

 
 
 
        /* text8 */    
        $core["page_testimonials"]["text8"]["section_padding"] = "section-40";     
        $core["page_testimonials"]["text8"]["section_bg"] = "bg-light";     
        $core["page_testimonials"]["text8"]["section_pos"] = "";     
        $core["page_testimonials"]["text8"]["section_w"] = "container";     
        $core["page_testimonials"]["text8"]["title_show"] = "yes";     
        $core["page_testimonials"]["text8"]["title"] = "Testimonials";     
        $core["page_testimonials"]["text8"]["subtitle"] = "User Feedback";     
        $core["page_testimonials"]["text8"]["desc"] = "";     
        $core["page_testimonials"]["text8"]["title_style"] = "h2-2";     
        $core["page_testimonials"]["text8"]["title_pos"] = "left";     
        $core["page_testimonials"]["text8"]["title_heading"] = "h2";     
        $core["page_testimonials"]["text8"]["title_margin"] = "mb-4";     
        $core["page_testimonials"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_testimonials"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_testimonials"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_testimonials"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_testimonials"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_testimonials"]["text8"]["title_font"] = "";     
        $core["page_testimonials"]["text8"]["subtitle_font"] = "";     
        $core["page_testimonials"]["text8"]["desc_font"] = "";     
        $core["page_testimonials"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_testimonials"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* text1 */    
        $core["page_testimonials"]["text1"]["section_padding"] = "section-100";     
        $core["page_testimonials"]["text1"]["section_bg"] = "bg-white";     
        $core["page_testimonials"]["text1"]["section_pos"] = "";     
        $core["page_testimonials"]["text1"]["section_w"] = "container";     
        $core["page_testimonials"]["text1"]["title_show"] = "yes";     
        $core["page_testimonials"]["text1"]["title"] = "Over 50,00 Clients Worldwide";     
        $core["page_testimonials"]["text1"]["subtitle"] = "Optimized for speed and search engines.";     
        $core["page_testimonials"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";     
        $core["page_testimonials"]["text1"]["title_style"] = "1";     
        $core["page_testimonials"]["text1"]["title_pos"] = "left";     
        $core["page_testimonials"]["text1"]["title_heading"] = "h2";     
        $core["page_testimonials"]["text1"]["title_margin"] = "mb-4";     
        $core["page_testimonials"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["page_testimonials"]["text1"]["desc_margin"] = "mb-4";     
        $core["page_testimonials"]["text1"]["title_txtcolor"] = "dark";     
        $core["page_testimonials"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["page_testimonials"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_testimonials"]["text1"]["title_font"] = "";     
        $core["page_testimonials"]["text1"]["subtitle_font"] = "";     
        $core["page_testimonials"]["text1"]["desc_font"] = "";     
        $core["page_testimonials"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["page_testimonials"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_testimonials"]["text1"]["btn_show"] = "yes";     
        $core["page_testimonials"]["text1"]["btn_link"] = "[link-contact]";     
        $core["page_testimonials"]["text1"]["btn_txt"] = "CONTACT US";     
        $core["page_testimonials"]["text1"]["btn_bg"] = "primary";     
        $core["page_testimonials"]["text1"]["btn_bg_txt"] = "text-light";     
        $core["page_testimonials"]["text1"]["btn_icon"] = "";     
        $core["page_testimonials"]["text1"]["btn_icon_pos"] = "before";     
        $core["page_testimonials"]["text1"]["btn_size"] = "btn-xl";     
        $core["page_testimonials"]["text1"]["btn_margin"] = "mt-0";     
        $core["page_testimonials"]["text1"]["btn_style"] = "5";     
        $core["page_testimonials"]["text1"]["btn_font"] = "";     
        $core["page_testimonials"]["text1"]["btn2_show"] = "no";     
        $core["page_testimonials"]["text1"]["text_image1"] = DEMO_IMG_PATH."innerpages/2.jpg";     
        $core["page_testimonials"]["text1"]["text_image1_title"] = "";     
        $core["page_testimonials"]["text1"]["text_image1_link"] = ""; 		
 
        /* testimonials1 */    
        $core["page_testimonials"]["testimonials1"]["section_padding"] = "section-bottom-40";     
        $core["page_testimonials"]["testimonials1"]["section_bg"] = "bg-white";     
        $core["page_testimonials"]["testimonials1"]["section_pos"] = "";     
        $core["page_testimonials"]["testimonials1"]["section_w"] = "container";     
        $core["page_testimonials"]["testimonials1"]["title_show"] = "yes";     
        $core["page_testimonials"]["testimonials1"]["title"] = "Recent Customer Feedback";     
        $core["page_testimonials"]["testimonials1"]["subtitle"] = "Lot's of Happy Customers";     
        $core["page_testimonials"]["testimonials1"]["desc"] = "";     
        $core["page_testimonials"]["testimonials1"]["title_style"] = "center";     
        $core["page_testimonials"]["testimonials1"]["title_pos"] = "left";     
        $core["page_testimonials"]["testimonials1"]["title_heading"] = "h2";     
        $core["page_testimonials"]["testimonials1"]["title_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials1"]["subtitle_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials1"]["desc_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials1"]["title_txtcolor"] = "dark";     
        $core["page_testimonials"]["testimonials1"]["subtitle_txtcolor"] = "dark";     
        $core["page_testimonials"]["testimonials1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_testimonials"]["testimonials1"]["title_font"] = "";     
        $core["page_testimonials"]["testimonials1"]["subtitle_font"] = "";     
        $core["page_testimonials"]["testimonials1"]["desc_font"] = "";     
        $core["page_testimonials"]["testimonials1"]["title_txtw"] = "font-weight-bold";     
        $core["page_testimonials"]["testimonials1"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* testimonials2 */    
        $core["page_testimonials"]["testimonials2"]["section_padding"] = "section-100";     
        $core["page_testimonials"]["testimonials2"]["section_bg"] = "bg-light";     
        $core["page_testimonials"]["testimonials2"]["section_pos"] = "";     
        $core["page_testimonials"]["testimonials2"]["section_w"] = "container";     
        $core["page_testimonials"]["testimonials2"]["title_show"] = "yes";     
        $core["page_testimonials"]["testimonials2"]["title"] = "Recent Customer Feedback";     
        $core["page_testimonials"]["testimonials2"]["subtitle"] = "See what our customers are saying!";     
        $core["page_testimonials"]["testimonials2"]["desc"] = "";     
        $core["page_testimonials"]["testimonials2"]["title_style"] = "1";     
        $core["page_testimonials"]["testimonials2"]["title_pos"] = "center";     
        $core["page_testimonials"]["testimonials2"]["title_heading"] = "h2";     
        $core["page_testimonials"]["testimonials2"]["title_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials2"]["subtitle_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials2"]["desc_margin"] = "mb-4";     
        $core["page_testimonials"]["testimonials2"]["title_txtcolor"] = "dark";     
        $core["page_testimonials"]["testimonials2"]["subtitle_txtcolor"] = "primary";     
        $core["page_testimonials"]["testimonials2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_testimonials"]["testimonials2"]["title_font"] = "";     
        $core["page_testimonials"]["testimonials2"]["subtitle_font"] = "";     
        $core["page_testimonials"]["testimonials2"]["desc_font"] = "";     
        $core["page_testimonials"]["testimonials2"]["title_txtw"] = "font-weight-bold";     
        $core["page_testimonials"]["testimonials2"]["subtitle_txtw"] = "font-weight-bold"; 		


 
 
/*
FAQ
*/  
 
        /* text8 */    
        $core["page_faq"]["text8"]["section_padding"] = "section-40";     
        $core["page_faq"]["text8"]["section_bg"] = "bg-light";     
        $core["page_faq"]["text8"]["section_pos"] = "";     
        $core["page_faq"]["text8"]["section_w"] = "container";     
        $core["page_faq"]["text8"]["title_show"] = "yes";     
        $core["page_faq"]["text8"]["title"] = "FAQ";     
        $core["page_faq"]["text8"]["subtitle"] = "Commonly Asked Questions";     
        $core["page_faq"]["text8"]["desc"] = "";     
        $core["page_faq"]["text8"]["title_style"] = "h2-2";     
        $core["page_faq"]["text8"]["title_pos"] = "left";     
        $core["page_faq"]["text8"]["title_heading"] = "h2";     
        $core["page_faq"]["text8"]["title_margin"] = "mb-4";     
        $core["page_faq"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_faq"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_faq"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_faq"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_faq"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_faq"]["text8"]["title_font"] = "";     
        $core["page_faq"]["text8"]["subtitle_font"] = "";     
        $core["page_faq"]["text8"]["desc_font"] = "";     
        $core["page_faq"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_faq"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* text1 */    
        $core["page_faq"]["text1"]["section_padding"] = "section-100";     
        $core["page_faq"]["text1"]["section_bg"] = "bg-white";     
        $core["page_faq"]["text1"]["section_pos"] = "";     
        $core["page_faq"]["text1"]["section_w"] = "container";     
        $core["page_faq"]["text1"]["title_show"] = "yes";     
        $core["page_faq"]["text1"]["title"] = "Over 50,000 Customers Worldwide";     
        $core["page_faq"]["text1"]["subtitle"] = "Optimized for speed and search engines.";     
        $core["page_faq"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";     
        $core["page_faq"]["text1"]["title_style"] = "1";     
        $core["page_faq"]["text1"]["title_pos"] = "left";     
        $core["page_faq"]["text1"]["title_heading"] = "h2";     
        $core["page_faq"]["text1"]["title_margin"] = "mb-4";     
        $core["page_faq"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["page_faq"]["text1"]["desc_margin"] = "mb-4";     
        $core["page_faq"]["text1"]["title_txtcolor"] = "dark";     
        $core["page_faq"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["page_faq"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_faq"]["text1"]["title_font"] = "";     
        $core["page_faq"]["text1"]["subtitle_font"] = "";     
        $core["page_faq"]["text1"]["desc_font"] = "";     
        $core["page_faq"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["page_faq"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_faq"]["text1"]["btn_show"] = "no";     
        $core["page_faq"]["text1"]["btn2_show"] = "no";     
        $core["page_faq"]["text1"]["text_image1"] = DEMO_IMG_PATH."innerpages/2.jpg";     
        $core["page_faq"]["text1"]["text_image1_title"] = "faq";     
        $core["page_faq"]["text1"]["text_image1_link"] = ""; 		
 
        /* faq1 */    
        $core["page_faq"]["faq1"]["section_padding"] = "section-60";     
        $core["page_faq"]["faq1"]["section_bg"] = "bg-light";     
        $core["page_faq"]["faq1"]["section_pos"] = "";     
        $core["page_faq"]["faq1"]["section_w"] = "container";     
        $core["page_faq"]["faq1"]["title_show"] = "yes";     
        $core["page_faq"]["faq1"]["title"] = "Commonly Asked";     
        $core["page_faq"]["faq1"]["subtitle"] = "Optimized for speed and search engines.";     
        $core["page_faq"]["faq1"]["desc"] = "";     
        $core["page_faq"]["faq1"]["title_style"] = "1";     
        $core["page_faq"]["faq1"]["title_pos"] = "left";     
        $core["page_faq"]["faq1"]["title_heading"] = "h2";     
        $core["page_faq"]["faq1"]["title_margin"] = "mb-4";     
        $core["page_faq"]["faq1"]["subtitle_margin"] = "mb-5";     
        $core["page_faq"]["faq1"]["desc_margin"] = "mb-4";     
        $core["page_faq"]["faq1"]["title_txtcolor"] = "dark";     
        $core["page_faq"]["faq1"]["subtitle_txtcolor"] = "dark";     
        $core["page_faq"]["faq1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_faq"]["faq1"]["title_font"] = "";     
        $core["page_faq"]["faq1"]["subtitle_font"] = "";     
        $core["page_faq"]["faq1"]["desc_font"] = "";     
        $core["page_faq"]["faq1"]["title_txtw"] = "font-weight-bold";     
        $core["page_faq"]["faq1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_faq"]["faq1"]["btn_show"] = "no";     
        $core["page_faq"]["faq1"]["image_faq"] = DEMO_IMG_PATH."innerpages/3.jpg"; 		
 
        /* faq2 */    
        $core["page_faq"]["faq2"]["section_padding"] = "section-100";     
        $core["page_faq"]["faq2"]["section_bg"] = "bg-white";     
        $core["page_faq"]["faq2"]["section_pos"] = "";     
        $core["page_faq"]["faq2"]["section_w"] = "container";     
        $core["page_faq"]["faq2"]["title_show"] = "yes";     
        $core["page_faq"]["faq2"]["title"] = "Account Questions";     
        $core["page_faq"]["faq2"]["subtitle"] = "Members area and user features";     
        $core["page_faq"]["faq2"]["desc"] = "Can't find what your looking for? Please contact us.";     
        $core["page_faq"]["faq2"]["title_style"] = "1";     
        $core["page_faq"]["faq2"]["title_pos"] = "left";     
        $core["page_faq"]["faq2"]["title_heading"] = "h2";     
        $core["page_faq"]["faq2"]["title_margin"] = "mb-4";     
        $core["page_faq"]["faq2"]["subtitle_margin"] = "mb-4";     
        $core["page_faq"]["faq2"]["desc_margin"] = "mb-4";     
        $core["page_faq"]["faq2"]["title_txtcolor"] = "dark";     
        $core["page_faq"]["faq2"]["subtitle_txtcolor"] = "dark";     
        $core["page_faq"]["faq2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_faq"]["faq2"]["title_font"] = "";     
        $core["page_faq"]["faq2"]["subtitle_font"] = "";     
        $core["page_faq"]["faq2"]["desc_font"] = "";     
        $core["page_faq"]["faq2"]["title_txtw"] = "font-weight-bold";     
        $core["page_faq"]["faq2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_faq"]["faq2"]["btn_show"] = "no";     
        $core["page_faq"]["faq2"]["image_faq"] = DEMO_IMG_PATH."innerpages/1.jpg"; 		


 
/*
CONTACT PAGE To LIST CAR
*/


 
        /* contact1 */    
        $core["page_contact"]["contact1"]["section_padding"] = "section-100";     
        $core["page_contact"]["contact1"]["section_bg"] = "bg-light";     
        $core["page_contact"]["contact1"]["section_pos"] = "";     
        $core["page_contact"]["contact1"]["section_w"] = "container"; 		
 
 
/* ABOUT US */
         /* text8 */    
        $core["page_aboutus"]["text8"]["section_padding"] = "section-40";     
        $core["page_aboutus"]["text8"]["section_bg"] = "bg-light";     
        $core["page_aboutus"]["text8"]["section_pos"] = "";     
        $core["page_aboutus"]["text8"]["section_w"] = "container";     
        $core["page_aboutus"]["text8"]["title_show"] = "yes";     
        $core["page_aboutus"]["text8"]["title"] = "About Us";     
        $core["page_aboutus"]["text8"]["subtitle"] = "Learn more about us";     
        $core["page_aboutus"]["text8"]["desc"] = "";     
        $core["page_aboutus"]["text8"]["title_style"] = "h2-2";     
        $core["page_aboutus"]["text8"]["title_pos"] = "left";     
        $core["page_aboutus"]["text8"]["title_heading"] = "h2";     
        $core["page_aboutus"]["text8"]["title_margin"] = "mb-4";     
        $core["page_aboutus"]["text8"]["subtitle_margin"] = "mb-4";     
        $core["page_aboutus"]["text8"]["desc_margin"] = "mb-4";     
        $core["page_aboutus"]["text8"]["title_txtcolor"] = "dark";     
        $core["page_aboutus"]["text8"]["subtitle_txtcolor"] = "dark";     
        $core["page_aboutus"]["text8"]["desc_txtcolor"] = "opacity-5";     
        $core["page_aboutus"]["text8"]["title_font"] = "";     
        $core["page_aboutus"]["text8"]["subtitle_font"] = "";     
        $core["page_aboutus"]["text8"]["desc_font"] = "";     
        $core["page_aboutus"]["text8"]["title_txtw"] = "font-weight-bold";     
        $core["page_aboutus"]["text8"]["subtitle_txtw"] = "font-weight-bold"; 		
 
        /* text1 */    
        $core["page_aboutus"]["text1"]["section_padding"] = "section-100";     
        $core["page_aboutus"]["text1"]["section_bg"] = "bg-white";     
        $core["page_aboutus"]["text1"]["section_pos"] = "";     
        $core["page_aboutus"]["text1"]["section_w"] = "container";     
        $core["page_aboutus"]["text1"]["title_show"] = "yes";     
        $core["page_aboutus"]["text1"]["title"] = "IN BUSINESS SINCE 2010";     
        $core["page_aboutus"]["text1"]["subtitle"] = "We've been working hard helping customers for over 10 years.";     
        $core["page_aboutus"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ";     
        $core["page_aboutus"]["text1"]["title_style"] = "2";     
        $core["page_aboutus"]["text1"]["title_pos"] = "left";     
        $core["page_aboutus"]["text1"]["title_heading"] = "h2";     
        $core["page_aboutus"]["text1"]["title_margin"] = "mb-4";     
        $core["page_aboutus"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["page_aboutus"]["text1"]["desc_margin"] = "mb-4";     
        $core["page_aboutus"]["text1"]["title_txtcolor"] = "dark";     
        $core["page_aboutus"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["page_aboutus"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["page_aboutus"]["text1"]["title_font"] = "";     
        $core["page_aboutus"]["text1"]["subtitle_font"] = "";     
        $core["page_aboutus"]["text1"]["desc_font"] = "";     
        $core["page_aboutus"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["page_aboutus"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_aboutus"]["text1"]["btn_show"] = "no";     
        $core["page_aboutus"]["text1"]["btn2_show"] = "no";     
        $core["page_aboutus"]["text1"]["text_image1"] = DEMO_IMG_PATH."innerpages/2.jpg";     
        $core["page_aboutus"]["text1"]["text_image1_title"] = "";     
        $core["page_aboutus"]["text1"]["text_image1_link"] = ""; 		
 
        /* text2 */    
        $core["page_aboutus"]["text2"]["section_padding"] = "section-100";     
        $core["page_aboutus"]["text2"]["section_bg"] = "bg-light";     
        $core["page_aboutus"]["text2"]["section_pos"] = "";     
        $core["page_aboutus"]["text2"]["section_w"] = "container";     
        $core["page_aboutus"]["text2"]["title_show"] = "yes";     
        $core["page_aboutus"]["text2"]["title"] = "Over 50,000 Clients Worldwide";     
        $core["page_aboutus"]["text2"]["subtitle"] = "Optimized for speed and search engines.";     
        $core["page_aboutus"]["text2"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ";     
        $core["page_aboutus"]["text2"]["title_style"] = "1";     
        $core["page_aboutus"]["text2"]["title_pos"] = "left";     
        $core["page_aboutus"]["text2"]["title_heading"] = "h2";     
        $core["page_aboutus"]["text2"]["title_margin"] = "mb-4";     
        $core["page_aboutus"]["text2"]["subtitle_margin"] = "mb-4";     
        $core["page_aboutus"]["text2"]["desc_margin"] = "mb-4";     
        $core["page_aboutus"]["text2"]["title_txtcolor"] = "dark";     
        $core["page_aboutus"]["text2"]["subtitle_txtcolor"] = "dark";     
        $core["page_aboutus"]["text2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_aboutus"]["text2"]["title_font"] = "";     
        $core["page_aboutus"]["text2"]["subtitle_font"] = "";     
        $core["page_aboutus"]["text2"]["desc_font"] = "";     
        $core["page_aboutus"]["text2"]["title_txtw"] = "font-weight-bold";     
        $core["page_aboutus"]["text2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_aboutus"]["text2"]["btn_show"] = "yes";     
        $core["page_aboutus"]["text2"]["btn_link"] = "[link-contact]";     
        $core["page_aboutus"]["text2"]["btn_txt"] = "Contact Us";     
        $core["page_aboutus"]["text2"]["btn_bg"] = "primary";     
        $core["page_aboutus"]["text2"]["btn_bg_txt"] = "text-light";     
        $core["page_aboutus"]["text2"]["btn_icon"] = "far fa-comments";     
        $core["page_aboutus"]["text2"]["btn_icon_pos"] = "after";     
        $core["page_aboutus"]["text2"]["btn_size"] = "btn-xl";     
        $core["page_aboutus"]["text2"]["btn_margin"] = "mt-3";     
        $core["page_aboutus"]["text2"]["btn_style"] = "5";     
        $core["page_aboutus"]["text2"]["btn_font"] = "";     
        $core["page_aboutus"]["text2"]["btn2_show"] = "no";     
        $core["page_aboutus"]["text2"]["text_image1"] = DEMO_IMG_PATH."innerpages/3.jpg";     
        $core["page_aboutus"]["text2"]["text_image1_title"] = "";     
        $core["page_aboutus"]["text2"]["text_image1_link"] = ""; 		




/* TERMS &amp; CONDITIONS */ 
        
        $core["page_terms"]["text8"]["section_padding"] = "section-40";     
        $core["page_terms"]["text8"]["section_bg"] = "bg-light";     
        $core["page_terms"]["text8"]["title_show"] = "yes";     
        $core["page_terms"]["text8"]["title"] = "Terms &amp; Conditions";     
        $core["page_terms"]["text8"]["subtitle"] = "Because we care";     
        $core["page_terms"]["text8"]["desc"] = "";     
        $core["page_terms"]["text8"]["title_style"] = "h2-2"; 	
		

 
/* PRIVACY */ 
        
        $core["page_privacy"]["text8"]["section_padding"] = "section-40";     
        $core["page_privacy"]["text8"]["section_bg"] = "bg-light";     
        $core["page_privacy"]["text8"]["title_show"] = "yes";     
        $core["page_privacy"]["text8"]["title"] = "Privacy";     
        $core["page_privacy"]["text8"]["subtitle"] = "Because we care";     
        $core["page_privacy"]["text8"]["desc"] = "";     
        $core["page_privacy"]["text8"]["title_style"] = "h2-2"; 	
 

 
/* SELL SPACE */

 
 
        /* pricing1 */    
        $core["page_sellspace"]["pricing2"]["section_padding"] = "section-60";     
        $core["page_sellspace"]["pricing2"]["section_bg"] = "bg-white";     
        $core["page_sellspace"]["pricing2"]["section_pos"] = "";     
        $core["page_sellspace"]["pricing2"]["section_w"] = "container";     
        $core["page_sellspace"]["pricing2"]["title_show"] = "yes";     
        $core["page_sellspace"]["pricing2"]["title"] = "Advertising Pricing";     
        $core["page_sellspace"]["pricing2"]["subtitle"] = "All prices include a 30-day money back guarantee.";     
        $core["page_sellspace"]["pricing2"]["desc"] = "";     
        $core["page_sellspace"]["pricing2"]["title_style"] = "1";     
        $core["page_sellspace"]["pricing2"]["title_pos"] = "center";     
        $core["page_sellspace"]["pricing2"]["title_heading"] = "h1";     
        $core["page_sellspace"]["pricing2"]["title_margin"] = "mb-4";     
        $core["page_sellspace"]["pricing2"]["subtitle_margin"] = "mb-4";     
        $core["page_sellspace"]["pricing2"]["desc_margin"] = "mb-4";     
        $core["page_sellspace"]["pricing2"]["title_txtcolor"] = "dark";     
        $core["page_sellspace"]["pricing2"]["subtitle_txtcolor"] = "dark";     
        $core["page_sellspace"]["pricing2"]["desc_txtcolor"] = "opacity-5";     
        $core["page_sellspace"]["pricing2"]["title_font"] = "";     
        $core["page_sellspace"]["pricing2"]["subtitle_font"] = "";     
        $core["page_sellspace"]["pricing2"]["desc_font"] = "";     
        $core["page_sellspace"]["pricing2"]["title_txtw"] = "font-weight-bold";     
        $core["page_sellspace"]["pricing2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_sellspace"]["pricing2"]["pricing_type"] = "advertising"; 		
 
        /* icon10 */    
        $core["page_sellspace"]["icon10"]["section_padding"] = "section-80";     
        $core["page_sellspace"]["icon10"]["section_bg"] = "bg-light";     
        $core["page_sellspace"]["icon10"]["section_pos"] = "";     
        $core["page_sellspace"]["icon10"]["section_w"] = "container";     
        $core["page_sellspace"]["icon10"]["title_show"] = "yes";     
        $core["page_sellspace"]["icon10"]["title"] = "Advertising Opportunities";     
        $core["page_sellspace"]["icon10"]["subtitle"] = "Place your banners on our website.";     
        $core["page_sellspace"]["icon10"]["desc"] = "Purchase advertising space on our website and promote your products or services to our community.<br><br>Contact us today for any special requirements.";     
        $core["page_sellspace"]["icon10"]["title_style"] = "2";     
        $core["page_sellspace"]["icon10"]["title_pos"] = "left";     
        $core["page_sellspace"]["icon10"]["title_heading"] = "h2";     
        $core["page_sellspace"]["icon10"]["title_margin"] = "mb-4";     
        $core["page_sellspace"]["icon10"]["subtitle_margin"] = "mb-4";     
        $core["page_sellspace"]["icon10"]["desc_margin"] = "mb-4";     
        $core["page_sellspace"]["icon10"]["title_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["subtitle_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["desc_txtcolor"] = "opacity-5";     
        $core["page_sellspace"]["icon10"]["title_font"] = "";     
        $core["page_sellspace"]["icon10"]["subtitle_font"] = "";     
        $core["page_sellspace"]["icon10"]["desc_font"] = "";     
        $core["page_sellspace"]["icon10"]["title_txtw"] = "font-weight-bold";     
        $core["page_sellspace"]["icon10"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_sellspace"]["icon10"]["btn_show"] = "no";     
        $core["page_sellspace"]["icon10"]["btn2_show"] = "no";     
        $core["page_sellspace"]["icon10"]["icon1"] = "";     
        $core["page_sellspace"]["icon10"]["icon1_title"] = "30 Day Money Back Guarantee.";     
        $core["page_sellspace"]["icon10"]["icon1_desc"] = " ";     
        $core["page_sellspace"]["icon10"]["icon1_link"] = "";     
        $core["page_sellspace"]["icon10"]["icon1_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["icon1_iconcolor"] = "primary";     
        $core["page_sellspace"]["icon10"]["icon1_type"] = "icon";     
        $core["page_sellspace"]["icon10"]["icon2"] = "";     
        $core["page_sellspace"]["icon10"]["icon2_title"] = "Secure Online Payments.";     
        $core["page_sellspace"]["icon10"]["icon2_desc"] = " ";     
        $core["page_sellspace"]["icon10"]["icon2_link"] = "";     
        $core["page_sellspace"]["icon10"]["icon2_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["icon2_iconcolor"] = "primary";     
        $core["page_sellspace"]["icon10"]["icon2_type"] = "icon";     
        $core["page_sellspace"]["icon10"]["icon3"] = "";     
        $core["page_sellspace"]["icon10"]["icon3_title"] = "Instant Access After Payment";     
        $core["page_sellspace"]["icon10"]["icon3_desc"] = " ";     
        $core["page_sellspace"]["icon10"]["icon3_link"] = "";     
        $core["page_sellspace"]["icon10"]["icon3_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["icon3_iconcolor"] = "primary";     
        $core["page_sellspace"]["icon10"]["icon3_type"] = "icon";     
        $core["page_sellspace"]["icon10"]["icon4"] = "";     
        $core["page_sellspace"]["icon10"]["icon4_title"] = "24/7 Help & Online Support";     
        $core["page_sellspace"]["icon10"]["icon4_desc"] = " ";     
        $core["page_sellspace"]["icon10"]["icon4_link"] = "";     
        $core["page_sellspace"]["icon10"]["icon4_txtcolor"] = "dark";     
        $core["page_sellspace"]["icon10"]["icon4_iconcolor"] = "primary";     
        $core["page_sellspace"]["icon10"]["icon4_type"] = "icon"; 		

	


/* ADD */

 
        /* text6 */    
     
        $core["page_add"]["pricing10"]["section_padding"] = "section-60";     
        $core["page_add"]["pricing10"]["section_bg"] = "bg-white";     
        $core["page_add"]["pricing10"]["section_pos"] = "";     
        $core["page_add"]["pricing10"]["title_show"] = "yes";     
        $core["page_add"]["pricing10"]["title"] = "Pricing Plans for Everyone";     
        $core["page_add"]["pricing10"]["subtitle"] = "All purchases include a 30-day money back guarantee.";     
        $core["page_add"]["pricing10"]["desc"] = "";     
        $core["page_add"]["pricing10"]["title_style"] = "1";     
        $core["page_add"]["pricing10"]["title_pos"] = "center";     
        $core["page_add"]["pricing10"]["title_heading"] = "h1";     
        $core["page_add"]["pricing10"]["title_margin"] = "mb-4";     
        $core["page_add"]["pricing10"]["subtitle_margin"] = "mb-4";     
        $core["page_add"]["pricing10"]["desc_margin"] = "mb-4";     
        $core["page_add"]["pricing10"]["title_txtcolor"] = "dark";     
        $core["page_add"]["pricing10"]["subtitle_txtcolor"] = "primary";     
        $core["page_add"]["pricing10"]["desc_txtcolor"] = "opacity-5";     
        $core["page_add"]["pricing10"]["title_txtw"] = "font-weight-bold";     
        $core["page_add"]["pricing10"]["subtitle_txtw"] = "font-weight-bold";     
        $core["page_add"]["pricing10"]["pricing_type"] = "packages"; 		

            
        $core["page_add"]["icon11"]["section_padding"] = "section-80";     
        $core["page_add"]["icon11"]["section_bg"] = "bg-light";     
        $core["page_add"]["icon11"]["section_pos"] = "";     
        $core["page_add"]["icon11"]["title_show"] = "no";     
        $core["page_add"]["icon11"]["btn_show"] = "no";     
        $core["page_add"]["icon11"]["btn2_show"] = "no";     
        $core["page_add"]["icon11"]["icon1"] = "";     
        $core["page_add"]["icon11"]["icon1_title"] = "Money Back Guarentee";     
        $core["page_add"]["icon11"]["icon1_desc"] = "If your unhappy with our service at anytime within 30 days - contact us.";     
        $core["page_add"]["icon11"]["icon1_link"] = "";     
        $core["page_add"]["icon11"]["icon1_txtcolor"] = "dark";     
        $core["page_add"]["icon11"]["icon1_iconcolor"] = "primary";     
        $core["page_add"]["icon11"]["icon1_type"] = "icon";     
        $core["page_add"]["icon11"]["icon2"] = "";     
        $core["page_add"]["icon11"]["icon2_title"] = "Over 50,000 Members";     
        $core["page_add"]["icon11"]["icon2_desc"] = "Your ad will be exposure to over 50,000+ website members.";     
        $core["page_add"]["icon11"]["icon2_link"] = "";     
        $core["page_add"]["icon11"]["icon2_txtcolor"] = "dark";     
        $core["page_add"]["icon11"]["icon2_iconcolor"] = "primary";     
        $core["page_add"]["icon11"]["icon2_type"] = "icon";     
        $core["page_add"]["icon11"]["icon3"] = "";     
        $core["page_add"]["icon11"]["icon3_title"] = "Easy to customize";     
        $core["page_add"]["icon11"]["icon3_desc"] = "You can come back and edit you ad anytime using the members area tool.";     
        $core["page_add"]["icon11"]["icon3_link"] = "";     
        $core["page_add"]["icon11"]["icon3_txtcolor"] = "dark";     
        $core["page_add"]["icon11"]["icon3_iconcolor"] = "primary";     
        $core["page_add"]["icon11"]["icon3_type"] = "icon"; 		
		
 
		
		return $core;
		
		} break;
		
 			
		
		
	}
}
 
function default_blocks(){ global $wpdb, $CORE_ADMIN; 

	// GET EACH CATEGORY 
	$types = $this->LAYOUT("get_block_types",array());
	if(is_array($types)){
	foreach($types as $t){
	
		// LOAD DEFAULTS
		$HandlePath = get_template_directory()."/framework/design/".$t['id']; 
		$loadheroArray = array();
		if(is_dir($HandlePath)){
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){	
				if(strlen($file) > 5 && substr($file, -3) == "php" ){
				
					//die($HandlePath."/".$file);
				 
					include($HandlePath."/".$file);
					
							
				}
			}	
		}
		}
	}
	}
			
}

function default_designs(){ global $wpdb, $CORE_ADMIN; 
	
 
	// LOAD DEFAULTS
	if(defined('WLT_DEMOMODE')){
	 
		$HandlePath = get_template_directory()."/framework/design/example_langs/";			 
		$loadheroArray = array();
		if(is_dir($HandlePath)){
		if($handle1 = opendir($HandlePath)) {      
				while(false !== ($file = readdir($handle1))){	
					if(strlen($file) > 5 && substr($file, -3) == "php" ){
					
						include($HandlePath."/".$file);					
								
					}
				}	
			}
		} 
	} 
 	
	if(defined('THEME_FOLDER')){

	// LOAD DEFAULTS
	$HandlePath = get_template_directory()."/".THEME_FOLDER."/designs/"; 
		 
	$loadheroArray = array();
	if(is_dir($HandlePath)){
	if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){	
				if(strlen($file) > 5 && substr($file, -3) == "php" ){
				 
					include($HandlePath."/".$file);					
							
				}
			}	
		}
	} 
	
	}	
	
	
	// LOAD ALL BLOCK DATA AND STORE IT IN A GLOBAL ARRAY
	$args = apply_filters( 'ppt_admin_layouts', array() );
 	
	// THEN LOAD IN THE BLOCKS		
	$this->all_admin_layouts = $args; // save all array into block data
 
}
  

/* =============================================================================
		IS FLUID LAYOUT
	========================================================================== */
function homeCotent($key1, $key2, $exta = ""){ global $CORE;	 
		
		
		if(defined('WLT_DEMOMODE')){
			// CHECK FOR DEFAULT VALUES
			$homedata = hook_admin_2_homeedit(array());			
			if(!empty($homedata) && isset($homedata[$key1]['data'][$key2]['d'])){			
				return $homedata[$key1]['data'][$key2]['d'];			
			}		
		}
		
		$lang = $CORE->_language_current(1);
		
		$lang = "en_us";
		
	 	$HDATA = _ppt('hdata_'.$lang);
		   
		if(substr($key2,-4) == "_aid"){
				 
			if($exta == "post_title"){
				return get_the_title($HDATA[$key1][$key2]);
			}
				
		}elseif(isset($HDATA[$key1][$key2]) && $HDATA[$key1][$key2] != ""){ 
		
				return stripslashes($HDATA[$key1][$key2]); 
				
		}else{
		
			// CHECK FOR DEFAULT VALUES
			$homedata = hook_admin_2_homeedit(array());
			
			if(!empty($homedata) && isset($homedata[$key1]['data'][$key2]['d'])){
			
				return $homedata[$key1]['data'][$key2]['d'];
			
			}else{
			
				return;
			
			}
		}
	
	return;
} 







function style_header($default, $settings){ global $settings;

	// GET SETTINGS
	$headerstyle = _ppt('headerstyle');
	
	if(is_array($headerstyle) && _ppt('allow_headerstyles') == 1 ){
	 
		if(isset($headerstyle['top']) && $headerstyle['top'] != "0"){
		
			// ADD-ON CSS
			if(isset($headerstyle['topclass'])){
			$settings['class'] = $headerstyle['topclass'];
			}
			  
			_ppt_template(  'framework/elementor/_header/'.$headerstyle['top']);
		
		}
		
		if(isset($headerstyle['main']) && $headerstyle['main'] != "0"){
		
			// ADD-ON CSS
			if(isset($headerstyle['mainclass'])){
			$settings['class'] = $headerstyle['mainclass'];
			}
			
			_ppt_template(  'framework/elementor/_header/'.$headerstyle['main']);
		
		}
		
		if(isset($headerstyle['menu']) && $headerstyle['menu'] != "0"){
			
			
			// ADD-ON CSS
			if(isset($headerstyle['menuclass'])){
			$settings['class'] = $headerstyle['menuclass'];
			}
			
			_ppt_template(  'framework/elementor/_header/'.$headerstyle['menu']);		
		}
	
	
	}else{
	 
	_ppt_template( $default );
	
	} 

}
 

/*
	this function performs the rating
	for newly added comments
*/


function delete_comment_extra( $comment_id ){
    //$filter = current_filter();
		
		// GET META
		$update_postid = get_comment_meta($comment_id, 'ratingpid', true);
		
		if(is_numeric($update_postid)){
		
			$vv = get_post_meta( $update_postid, 'starrating_votes', true);
			$vv = $vv -1;
			update_post_meta($update_postid, 'starrating_votes', $vv);
			
			// DELETE ALL
			delete_comment_meta( $commentid, 'ratingpid', '' ); 
		 
		}
		
		return $comment_id;
  
 }

function insert_comment_extra($commentid) { global $post, $CORE;


		// CHECK FOR FILE ATTACHMENT
		if(isset($_FILES['commentphoto']) && strlen($_FILES['commentphoto']['name']) > 2 && in_array($_FILES['commentphoto']['type'],$CORE->allowed_image_types) && is_numeric($_POST['comment_post_ID']) ){
				 
				
				// LOAD IN WORDPRESS FILE UPLOAOD CLASSES
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				if(!function_exists('get_file_description')){
				if(!defined('ABSPATH')){
				require $dir_path . "/wp-load.php";
				}
				require $dir_path . "/wp-admin/includes/file.php";
				require $dir_path . "/wp-admin/includes/media.php";	
				}
				if(!function_exists('wp_generate_attachment_metadata') ){
				require $dir_path . "/wp-admin/includes/image.php";
				}				 
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['commentphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['commentphoto']['type'],
					'tmp_name'	=> $_FILES['commentphoto']['tmp_name'],
					'error'		=> $_FILES['commentphoto']['error'],
					'size'		=> $_FILES['commentphoto']['size'],
				);
				
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));	  
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
				
				// set up the array of arguments for "wp_insert_post();"
				$attachment = array(			 
					'post_mime_type' => $_FILES['commentphoto']['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename( $file['name'] ) ),
					'post_content' => '',
					'post_author' => $userdata->ID,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_parent' => 0,
					'guid' => $uploaded_file['url']
				);									
				
				// insert the attachment post type and get the ID
				$attachment_id = wp_insert_post( $attachment );
		
				// generate the attachment metadata
				$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
				 
				// update the attachment metadata
				$rr = wp_update_attachment_metadata( $attachment_id,  $attach_data );
				
				if(isset($attach_data['sizes']['thumbnail']['file'])){
					$thumbnail = $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
				}else{
					$thumbnail = $uploaded_file['url'];
				}	
					
			 	 
				// NOW LETS SAVE THE NEW ONE				 
				add_comment_meta( $commentid, 'photo',  array('src' => $uploaded_file['url'], 'thumb' => $thumbnail, 'path' => $uploaded_file['file'], "attachment_id" => $attachment_id )  );
				
		}}
		
		 
		if(isset($_POST['rating1']) && is_numeric($_POST['rating1']) && is_numeric($_POST['comment_post_ID']) ){	
		 
		 
		 	$postid = $_POST['comment_post_ID'];  
		 	
			// SAVE STAR RATING VALUE
			$totalvotes 	= get_post_meta($postid, 'starrating_votes', true);
			$totalamount 	= get_post_meta($postid, 'starrating_total', true);
				
			$dividbyme = $_POST['totalratingitems'];
			
			
			// ADD UP ALL THE STARS
			// DEVIDE THEM BY 5
			// MULTIPLY BY 100
			 
			if($dividbyme == 4){
			
				$score = round( ( $_POST['rating1']+$_POST['rating2']+$_POST['rating3']+$_POST['rating4'] ) / 4 ,2);
			
			}elseif($dividbyme == 1){
			
				$score = $_POST['rating1'];
			
			}
			  
			if(!is_numeric($totalamount)){ $totalamount = $score; }else{ $totalamount += $score; }
			if(!is_numeric($totalvotes)){ $totalvotes = 1; }else{ $totalvotes++; }	
			 
			$save_rating = round(($totalamount/$totalvotes),2);
			update_post_meta($postid, 'starrating', $save_rating);
			update_post_meta($postid, 'starrating_total', $totalamount);
			update_post_meta($postid, 'starrating_votes', $totalvotes);
			
			// SAVE COMMEN META INCASE WE DELETE IT
			add_comment_meta( $commentid, 'ratingpid', $postid );				
			add_comment_meta( $commentid, 'ratingtotal', $score );
			add_comment_meta( $commentid, 'rating1', $_POST['rating1'] );
			
			// POST AUTHOR
			if(isset($_POST['postauthor']) && is_numeric($_POST['postauthor']) ){
			add_comment_meta( $commentid, 'postauthor', $_POST['postauthor'] );
			}
			
			if($dividbyme == 4){
				add_comment_meta( $commentid, 'rating2', $_POST['rating2'] );
				add_comment_meta( $commentid, 'rating3', $_POST['rating3'] );
				add_comment_meta( $commentid, 'rating4', $_POST['rating4'] );	
			}
					
		}
}
/*
	this function redirects the user
	after they have submitted a comment
*/
function redirect_after_comment($location){
		$newurl = substr($location, 0, strpos($location, "#comment"));
		return $newurl . '?newcomment=1';
}
/*
	this function processed the comment
	form
*/
function _preprocess_comment( $comment_data ) { global $CORE, $userdata, $post, $comment;	 
		 
		// BASIC FORM VALIDATION
		if(!is_admin() && !isset($_POST['nocaptcha'])){
		
		 	$canContinue = true;
			if(_ppt(array('captcha','enable')) == 1 && _ppt('captcha','sitekey') != "" ){	
				$canContinue = google_validate_recaptcha();	
			}
			
			if($canContinue){
			wp_die( __("The verification code was invalid. Press back and try again.","premiumpress") );
			}
		} 
		
		// ! RETURN COMMENT DATA
		return $comment_data;
}
 
 

	/* ========================================================================
	 CORE BODY CSS TAGS
	========================================================================== */ 
	function BODYCLASS($classes){
	
		global $wpdb, $post, $pagenow; $c = ""; $extra = "";
	 
		if($pagenow == "wp-login.php"){
		$classes[] = "ppt_login";
		}
		
		if(_ppt(array('design','boxed_layout')) != "" && !isset($_GET['ppt_live_preview'])  && !isset($GLOBALS['flag-account']) ){
			switch(_ppt(array('design','boxed_layout'))){
			
				case "1":
				case "1a": 
				case "1b": {
					$classes[] = "boxed";				
				} break;
				 	
				case "3":
				case "3a": {
					//$classes[] = "fullcontainer";				
				} break;
				
				case "4":
				case "4a": {
					//$classes[] = "slim";				
				} break;				
				
			}		
		}
		 
		// LAYOUT SHADOW
		if( in_array( _ppt(array('design','boxed_layout')) , array("1a","2a","3a","4a") )   ){		 
			$classes[] = "body-shadow";	
		}
		
		// LAYOUT SHADOW
		if( in_array( _ppt(array('design','boxed_layout')) , array("1b") )   ){		 
			$classes[] = "body-border";	
		}
		
		// MOBILE MENU
		if(_ppt('footer_mobile_menu') == 1){
			$classes[] = "body-hide-footer";			
		}
		 
		if(defined('WLT_DEMOMODE')){
		$classes[] = "demomode";
		} 
		
		if(isset($GLOBALS['flag-search'])){ 
		$classes[] = "search";		
		} 
		
		
		/*
		if(in_array(THEME_KEY, array("sp"))){
		 	
		}else{
			
			$g = _ppt(array('lst', 'imagemode'));
			if($g == 1){				
				$classes[] = "ppt-tall-images";
			}elseif($g == 2){
				$classes[] = "ppt-tall-images-big";				
			}elseif($g == 3){
				$classes[] = "ppt-long-images";				
			}elseif($g == 4){
				$classes[] = "ppt-long-images-big";	
			}
		
		}
		*/
		
		
		
	 	
		if(defined('THEME_KEY')){
		$classes[] = "theme-".THEME_KEY;
		}
		
		// INNER PAGE FOR BACKGROUND COLOR
		if(isset($GLOBALS['flag-home']) && !isset($_GET['ppt_live_preview']) ){ 
		
			$classes[] = "home";	
			
		}elseif( isset($_GET['ppt_live_preview']) ){		
		
			$classes[] = "previewmode";
			
		}else{
		
			$classes[] = "innerpage";			
		}
		 
		
		return $classes;	
	}
	
/* ========================================================================
 CORE BODY COLUMN LAYOUTS
========================================================================== */ 
function BODYCOLUMNS(){ global $post;return;}
function CSS($tag,$return=false){}

/* =============================================================================
	PAGE TITLE ADJUSTMENTS
========================================================================== */

function TITLE( $title, $sep = "" ) {
	global $paged, $page, $CORE; $extra = "";
	
	// HOME PAGE OBJECTS
	if(isset($_GET['home_paged'])){
		$extra .= " | ".__("Page","premiumpress")." ".$_GET['home_paged'];
	}
 
    return $title.$extra;
}

	 



function hook_sidebar_bottom(){ global $CORE;
	echo $CORE->BANNER('sidebar_right_bottom'); 
}
function hook_sidebar_bottom1(){ global $CORE;
	echo $CORE->BANNER('sidebar_left_bottom'); 
}
function hook_map_display(){ global $CORE;

if( isset($GLOBALS['CORE_THEME']['display_search_map'] ) && $GLOBALS['CORE_THEME']['display_search_map']  == "2" ){ 

echo $this->ppt_googlemap_html(false);  

}

echo $CORE->BANNER('sidebar_right_top'); 

}

function hook_map_display1(){ global $CORE;
 
if( isset($GLOBALS['CORE_THEME']['display_search_map'] ) && $GLOBALS['CORE_THEME']['display_search_map']  == "1" ){ 

echo $this->ppt_googlemap_html(false);  

}

echo $CORE->BANNER('sidebar_left_top'); 


}

 
	
function login_form(){ if(isset($_GET['redirect']) || isset($_GET['redirect_to']) ){ ?>
 <input type="hidden" name="redirect_to" value="<?php if(isset($_GET['redirect'])){  echo esc_attr($_GET['redirect']); }elseif(isset($_GET['redirect_to'])){  echo esc_attr($_GET['redirect_to']); }else{ echo $GLOBALS['CORE_THEME']['links']['myaccount']; } ?>" />
<?php    
} }
 
 
 
function _hook_callback_success(){ global $payment_data;

   $gc = stripslashes(get_option('google_conversion'));
   
   if(isset($payment_data['orderid'])){        
   echo str_replace("[orderid]",$payment_data['orderid'], $gc ); 
   }
   
   if(isset($payment_data['description'])){
   $gc = str_replace("[description]",$payment_data['description'], $gc);
   }
   
   if(isset($payment_data['total'])){
   $gc = str_replace("[total]",$payment_data['total'], $gc);
   }
   
   echo $gc;	
	
}

 
function _facebookmeta(){ global $post, $CORE;  

?>

<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo strip_tags(do_shortcode('[TITLE]')); ?>" />
<meta property="og:description" content="<?php echo strip_tags(do_shortcode('[EXCERPT]')); ?>" />
<meta property="og:image" content="<?php echo strip_tags(do_shortcode('[IMAGE pathonly=1]')); ?>" />
<meta property="og:image:width" content="700" />
<meta property="og:image:height" content="700" />

<?php }
 
function handle_post_type_template($single_template) { global $post, $userdata, $CORE, $FRAMEWORK;

	
	// CHECK PAGE ACCESS
	if(!$CORE->USER("membership_hasaccess_page", $post->ID )){
	
		header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
		exit();	
	
	}
	
	// ADD PUBLIC LOG
	if($userdata->ID){
		$CORE->FUNC("add_log",
			array(				 
				"type" 		=> "public_listing_view",								
				"postid"	=> $post->ID,
				"to" 		=> $post->post_author, 						
				"from" 		=> $userdata->ID,				
				"public" => 1,		
									 
			)
		);
	}
	
	/*
		Check if the admin has setup global page access
		and if so check we can access this page
			
	*/	
 
	if($userdata->ID && ( $post->post_author == $userdata->ID ) ){
	 
	}else{
 
	$access = _ppt(array('mem','listingaccess')); 
	 
	if($access != "" && ( !current_user_can('editor') || !current_user_can('administrator')  ) ){	
		if($access == 1){
		
			$CORE->Authorize();
		
		}elseif($access == "subs"){ // any subscription thats active
			
			$f = get_user_meta($userdata->ID, 'ppt_subscription',true);			 
			if($userdata->ID && is_array($f)){	
					 		
				$da = $CORE->date_timediff($f['date_expires'],'');
				if($da['expired'] == 0){				  
				}else{
					header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
					exit();
				}
				
			}else{
				
				if($userdata->ID){
					header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
					exit();
				}else{
					// NOT A MEMBER OR NOT LOGGED IN
					header("location: ".site_url('wp-login.php?action=login', 'login_post')."&redirect=".get_permalink($post->ID));
					exit();	
				}		
			}
		
		}else{ // unique subscription
		
			$f = get_user_meta($userdata->ID, 'ppt_subscription',true);			 
			if($userdata->ID && is_array($f)){
				$da = $CORE->date_timediff($f['date_expires'],'');
				if($da['expired'] == 0 && $f['key'] == $access){				  
				}else{				
			 
					header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
					exit();
				}
							
			}else{
				// NOT A MEMBER OR NOT LOGGED IN
				header("location: ".site_url('wp-login.php?action=login', 'login_post')."&redirect=".get_permalink($post->ID));
				exit();			
			}
		}
		
		// end if	
		
	}// end access
	
	}
	
	 
  if ($post->post_type == THEME_TAXONOMY."_type") { 

		// SET FLAG
	 	$GLOBALS['flag-single'] = 1;
 		
		// ADD ON FACEBOOK META
		add_action('wp_head',  array($this, '_facebookmeta') ); 
	 	 
		// CHECK FOR FORCED LOGIN
		if(isset($GLOBALS['CORE_THEME']['requirelogin']) && $GLOBALS['CORE_THEME']['requirelogin'] == 1){ $CORE->Authorize(); }
		
		// CHECK IF EXPIRED
		$CORE->expire_listing($post->ID);
	 
		 
		// EXTRA FOR FEEDBACK
		if(isset($_GET['ftyou'])){
		
			$GLOBALS['error_type'] 		= "success"; //ok,warn,error,info
			$GLOBALS['error_message'] 	= __("Feedback Added Successfully.","premiumpress") ;
				
		}	 
			
     
	 }
	 
	 // ADD BOOTSTRAP img-fluid CODE
	 add_filter( 'the_content', array($this, '_make_images_responsive' ) );
	 
	 
	 //RETURN	 
     return $single_template;  
}

function _make_images_responsive($content) {
  
  $content = str_replace("wp-image","img-fluid wp-image", $content);
  
  return $content;
}

 
 
 
 
function handle_page_template($template_dir) { global $post, $userdata, $wp_query, $CORE;
 
 
	if ( is_page_template() && !isset($GLOBALS['flag-callback']) ) { // STOP IT FROM REPEATING
		
		// EXTRAS FOR CALLBACK PAGE
		if(strpos($template_dir, "tpl-callback") !== false){
	  	
		// SET FLAG
		$GLOBALS['flag-callback'] = 1;
		 
		
		// PAYMENT DATA GLOBAL
		global $payment_status, $payment_data;
	 
	 	// ADD HOOK FOR PAYPAL
		add_action('hook_callback','core_onepay_callback');
		add_action('hook_callback','core_usercredit_callback');
		add_action('hook_callback','core_token_callback');
		add_action('hook_callback','core_admin_test_callback');
		add_action('hook_callback','core_free_upgrade_callback'); 
		
		add_action('hook_callback','core_free_order_callback'); //?? 
		 
		// GET PAYMENT RESPONSDE
		$payment_data = hook_callback($_POST);
		 
		  
 		if(is_array($payment_data) ){
		$payment_status = "success";
		}else{
		$payment_status = "error";
		}
		
		// DESTROY CART SESSION		 
		unset($_SESSION['ppt_cart']); 
		// DELETE STORED SESSION COOKIE
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		// AUTO FOR FORCING PAYMENT SUCCESS
		if(isset($_GET['auth'])){ $payment_status = "success"; }		
		   
		// EMAIL OPTIONS
		if(isset($payment_status) && $payment_status != "" && is_array($payment_data) && !empty($payment_data) ){
		 
			switch($payment_status){
				case "thankyou":
				case "success": { 
				 
					
				
				} break;
				default: { 
					
				  
				} break;
			   }
		 
			 
		}
		
 
			
		}else{ // END IF CALLBACK
 
 
 			// CHECK PAGE ACCESS
			if(!$CORE->USER("membership_hasaccess_page", $post->ID )){
			
				header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
				exit();	
			
			}
 		
		
		
		}
	 	 
	}else{
	 
		if(is_front_page() && $CORE->_language_current(1) != "en_us" && $CORE->_language_current(1) != ""){
			
			// CHECK FOR LANGUAGE TEMPLATE
			$lang = $CORE->_language_current(1);
			if(_ppt('home_link_'.$lang) != ""){
				header('location:'._ppt('home_link_'.$lang));
			}
		
		}else{
				
			// CHECK PAGE ACCESS
			if(!$CORE->USER("membership_hasaccess_page", $post->ID )){
			
				header("location: "._ppt(array('links','myaccount'))."?noaccess=1&showtab=membership");
				exit();	
			
			}
		
		}
	    
		
		// SET FLAG
		$GLOBALS['flag-page'] = 1;
		 
 		// CHECK FOR PAGE WIDGET
		$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
		if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }
		 
	} 
	
	//RETURN
	return $template_dir;
}
function handle_author_template($template_dir) { global $post,$userdata, $authorID, $listingcount, $wp_query, $CORE;
   
	// SET FLAG 
	$GLOBALS['flag-author'] = 1;
	
	if(isset($_POST['action']) && $_POST['action'] !=""){

		switch($_POST['action']){
		
			case "delfeedback": {	
			 
			$my_post 				= array();
			$my_post['ID'] 			= $_POST['fid'];
			$my_post['post_status'] = "draft";
			wp_update_post( $my_post );	
			
			$GLOBALS['error_message'] 	= "Feedback Deleted";				
			
			} break;
		
		}	
	} 
  
	// GET THE AUTHOR ID 
	if(isset($_GET['author']) && is_numeric($_GET['author'])){
	$authorID = $_GET['author'];
	}else{	
	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$authorID = $author->ID;
	}
 
	//RETURN
	return $template_dir;
}
	
	
/* ========================================================================
 PAGE NAVIGATION BUTTONS
========================================================================== */
function PAGENAV($return="", $numposts = "", $max_page = "") { global $wpdb, $wp_query; $return=""; $pages = "";  $backBtn = ""; $forwardBtn = "";

if (!is_single()) {

 	
		$request = $wp_query->request;	 
		$posts_per_page = intval(get_query_var('posts_per_page'));
		 
		$paged = intval(get_query_var('paged'));
	
		$pagenavi_options['pages_text'] = __("Page %CURRENT_PAGE% of %TOTAL_PAGES%","premiumpress");
		$pagenavi_options['current_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['page_text'] = "%PAGE_NUMBER%";
		
		$pagenavi_options['first_text'] = __("<< First","premiumpress");
		$pagenavi_options['last_text'] = __("Last >>","premiumpress");
 
		$pagenavi_options['num_pages'] = "2";
		$backBtn = ""; $forwardBtn = "";
		
		if(!is_numeric($numposts)){
		$numposts = $wp_query->found_posts;
		}
		
		if(!is_numeric($max_page)){
		$max_page = $wp_query->max_num_pages;
		}
		 
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		if(isset($_GET['home_paged']) && is_numeric($_GET['home_paged'])){
		$paged = $_GET['home_paged'];
		}
		 
		// HIDE IF
		//die($numposts." == ".$posts_per_page);
		if($numposts  <= $posts_per_page){ return; }
		
		
		$pages_to_show = intval(5);
		$larger_page_to_show = intval(1);
		$larger_page_multiple = intval(1);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		
		
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = ($this->n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = $this->n_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = $this->n_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = $this->n_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1 || intval(1) == 1) {
		
		if($max_page == 0 && $paged > 0){ $max_page=1; }
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);	
  		
					// PAGES COUNT
					if(!empty($pages_text)) {
						$pages .= '<li class="page-item"><span class="page-link">'.$pages_text.'</span></li>';
					}
					
					 
					 // PREVIOUS
					if($paged > 1 ){							
							 				
						if(isset($GLOBALS['flag-home'])){
							$link = get_home_url()."/?home_paged=".($paged-1);
						}else{
							$link = esc_url(get_pagenum_link($paged-1));
						}
															
						$backBtn .= '<li class="page-item "><a href="'.$link.'" class="page-link"><i class="fa fa-angle-left"></i></a></li>';
													
					}else{
					
						$backBtn .= '<li class="page-item disabled "><a href="javascript:void(0);" class="page-link"><i class="fa fa-angle-left"></i> </a></li>';	
					
					}
					
					
				  	//  NUMBERS
					for($i = $start_page; $i  <= $end_page; $i++) {	
						/*** get link for formatting ***/						
						if(isset($GLOBALS['flag-home'])){
						$link = get_home_url()."/?home_paged=".$i;
						}else{
						$link = esc_url(get_pagenum_link($i));
						}

						/*** build string ***/
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
							$return .= '<li class="page-item active"><a href="'.$link.'" class="page-link bg-primary" rel="nofollow">'.$current_page_text.'</a></li>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$return .= '<li class="page-item"><a href="'.$link.'" class="page-link" rel="nofollow">'.$page_text.'</a></li>';
						}
					}
					 
			 		// FIRST BUTTON
					if($paged > 0 && $paged < $max_page){	
						/*** get link for formatting ***/						
						if(isset($GLOBALS['flag-home'])){
						$link = get_home_url()."/?home_paged=".($paged+1);
						}else{
						$link = esc_url(get_pagenum_link($paged+1));
						}
						 
						$forwardBtn = '<li class="page-item "><a href="'.$link.'" class="page-link"> <i class="fa fa-angle-right nomargin" aria-hidden="true"></i> </a></li>';	
										
					}else{
					
						$forwardBtn = '<li class="page-item disabled "><a href="javascript:void(0);" class="page-link"><i class="fa fa-angle-right nomargin" aria-hidden="true"></i></a></li>';				
					
					}
		}
	}
	
	// ADD ON STYLE WRAPPER <div class="pager pull-right">'.$pages.'</div>
	$return = '<ul class="pagination">'.$backBtn.''.$return.''.$forwardBtn.'</ul>';
	 
	// RETURN VALUE
	if($return){	return $return;	}else{	echo $return;	}
}
function n_round($num, $tonearest) {  return floor($num/$tonearest)*$tonearest;}	
	
/* =============================================================================
   BREADCRUMBS 
   ========================================================================== */		

function BREADCRUMBS($before = '', $after = '') {
 
 global $CORE, $post, $wp_query;
 
  $delimiter = ''; 
 
  $STRING = "";

    $homeLink = esc_url( home_url() );
    $STRING .= $before .' <a href="' . $homeLink . '" class="bchome breadcrumb-item">'.__('Home','premiumpress').'</a> ' . $delimiter . ' '. $after;
 	
	if ( is_category() ) {
 
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
	 
      if ($thisCat->parent != 0 && is_numeric($parentCat) ) $STRING .=(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
	  
      $STRING .= $before . '<a href="'.$GLOBALS['CORE_THEME']['links']['blog'].'" class="breadcrumb-item">'.__("Blog","premiumpress").'</a>'.$after. ' '. $before.'<a href="#" class="breadcrumb-item">' . single_cat_title('', false) . '</a>' . $after;
 
    } elseif ( is_author() ) {
	
       global $author, $authorID;
      $userdata = get_userdata($author);
      $STRING .= $before . "<a href='#' rel='nofollow' class='breadcrumb-item'>".get_the_author_meta( 'display_name', $authorID)."</a>" . $after;
 
 
    } elseif ( is_day() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '" class="breadcrumb-item">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '" class="breadcrumb-item">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '" class="breadcrumb-item">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      $STRING .= $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
	
      if ( get_post_type() != 'post' ) {
	  
	  // ADD IN FIRST CATEGORY TO THE BREADCRUMBS FOR USER TO RETURN TO
	    $term_list = wp_get_post_terms($post->ID, THEME_TAXONOMY, array("fields" => "all"));
		if(isset($term_list[0]->name)){
		
		 $STRING .=  $before ."<a href='".get_term_link($term_list[0]->slug, THEME_TAXONOMY)."' class='breadcrumb-item'>".$term_list[0]->name.'</a> '.$after;
		}

        
      } else {
	  
        $cat = get_the_category();
		if(!empty($cat)){
		$cat = $cat[0];
		
		$STRING .= $before .'<a href="'._ppt(array('links','blog')).'"  class="breadcrumb-item">'.__("Blog","premiumpress").'</a>'. $after; 
		$STRING .= $before . "".str_replace("<a ","<a class='breadcrumb-item' ",get_category_parents($cat, TRUE, ''))."". $after;
			
			// DONT SET BLOG TITLE AGAIN
			if(!isset($GLOBALS['flag-blog'])){
			
			$STRING .= $before . "<a href='#' rel='nofollow' class='breadcrumb-item'>".get_the_title()."</a>" . $after;
			}
		}
		
      }
 	
	} elseif (isset($_GET['s']) || isset($_GET['advanced_search']) ){
	
	$STRING .= $before . "<a href='#' rel='nofollow' class='breadcrumb-item'>".__('Search','premiumpress') ."</a>" . $after;//$post_type->labels->singular_name
	
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	
	// CHECK IF ITS A CATEGORY FOR OUR CUSTOM POST TYPE	
	$category = $wp_query->get_queried_object();
	 
	
	 if(isset($category->taxonomy) && $category->taxonomy != THEME_TAXONOMY){

	  if(isset($category->term_taxonomy_id)){
			 $pterm = get_term_by('id', $category->term_id, $category->taxonomy);
			 $gg1 = get_term_link($pterm->slug, $category->taxonomy);
			 if( !is_wp_error( $gg1 ) ) {
			  $STRING .= $before . "<a href='".$gg1."' class='breadcrumb-item'>".str_replace("_"," ",str_replace("-"," ",$pterm->taxonomy)). "</a>". $before." <a href='".$gg1."' class='breadcrumb-item'>".$pterm->name ."</a>" . $after;
			 }		 
		 }
	 
	 }elseif(isset($category->name)){
	 
	 
		 $gg = get_term_link($category);
			 
		 if( !is_wp_error( $gg ) ) {		 
		 // CHECK FOR PARENT CATEGORY
		 if($category->parent != "0"){
			 $pterm = get_term_by('id', $category->parent, $category->taxonomy);
			 $gg1 = get_term_link($pterm->slug, $category->taxonomy);
			 if( !is_wp_error( $gg1 ) ) {
				 // CHECK FOR PARENT CATEGORY
				 if($pterm->parent != "0"){
					 $pterm2 = get_term_by('id', $pterm->parent, $pterm->taxonomy);
					 $gg2 = get_term_link($pterm2->slug, $pterm2->taxonomy);
					 if( !is_wp_error( $gg2 ) ) {
					 	$STRING .= $before . "<a href='".$gg2."' class='breadcrumb-item'>".$pterm2->name ."</a>" . $after;
					 }		 
				 }
			 
			  $STRING .= $before . "<a href='".$gg1."' class='breadcrumb-item'>".$pterm->name ."</a>" . $after;
			 }		 
		 }		 
	 	 $STRING .= $before . "<a href='".$gg."' class='breadcrumb-item'>".$category->name ."</a>" . $after;
		 }
	 }elseif(!isset($GLOBALS['flag-home'])){	
	 
		 $post_type = get_post_type_object(get_post_type());
		 
		 if(isset($post_type->labels->singular_name)){
		 $STRING .= $before ."<a href='#' class='breadcrumb-item'>".__("Category","premiumpress")."</a>" . $after; //$post_type->labels->singular_name
		 }
		 
	  }
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
	  
      //$STRING .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      $STRING .= $before .'<a href="' . get_permalink($parent) . '" class="breadcrumb-item">' . $parent->post_title . '</a>'. $after;
	  
      $STRING .= $before . "<a href='#' class='breadcrumb-item'>".get_the_title()."</a>" . $after;
 
    } elseif ( is_page() && !$post->post_parent && !is_front_page()   ) {
      $STRING .= $before . "<a href='#' class='breadcrumb-item'>".get_the_title()."</a>" . $after;
 
    } elseif ( is_page() && $post->post_parent  && !is_front_page() ) {
	
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
	  if(!is_object($parent_id)){
        $page = get_page($parent_id);
        $breadcrumbs[] = $before .'<a href="' . get_permalink($page->ID) . '" class="breadcrumb-item">' . get_the_title($page->ID) . '</a>'. $after;
        $parent_id  = $page->post_parent;
		}
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb){
		  $STRING .= $crumb . ' ' . $delimiter . '';
	  }
      $STRING .= $before ."<a href='#' class='breadcrumb-item'>" . get_the_title() . "</a>". $after;
 
    } elseif ( is_search() ) {
      $STRING .= $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      $STRING .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 

    } elseif ( is_404() ) {
      $STRING .= $before . "<a href='#' rel='nofollow' class='breadcrumb-item'>".'Error 404'.'</a>' . $after;
    }else{
	
	}
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= '  ';
      $STRING .= $before . "<a href='#' class='breadcrumb-item'>".__("Page","premiumpress") . ' ' . get_query_var('paged')."</a>". $after;
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= ' ';
    }
  
  //}
  
  return $STRING;
}	























function CustomDesignEdit($key, $homedata, $pagekey = "home"){

global $CORE;
 

   // GET THE CURRENT DATA
   $HDATA = _ppt($pagekey);
  
   // CHECK FOR INNER PAGE CONTENT -- DEFAULTS   
   if( $HDATA  == "" && isset($_GET['pagekey']) && strpos($_GET['pagekey'],"page_") !== false ){
   	
		$innerd  = $CORE->LAYOUT("default_innerpages", array() ); 
		if(isset($innerd[$pagekey])){
		$HDATA = $innerd[$pagekey];
		}   
   } 
 
    
     
   ?>
  
<div class="container px-0 bg-white p-4">
    
<div class="accordion" id="accordionExample">    
 <?php $i=1; foreach($homedata['data'] as $key1 => $item){
	    
	   		if(isset($item['type'])){
			
			}else{
				$item['type'] = ""; 
			}
			
			if(!isset($item['d'])){ $item['d'] = ""; }
			 
			
			?>


<?php if($item['type'] == "seperator-heading"){ ?>
  <div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn font-weight-bold text-dark" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
         <?php echo $item['t']; ?>
        </button>
      </h5>
    </div>

    <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
      <div class="card-body py-0">   
      
      
<?php }elseif($item['type'] == "seperator-end"){ ?>     
      
      </div>
    </div>
  </div>  
 
          
<?php }elseif($item['type'] == "seperator"){ ?>
 
<div class="bg-dark text-light p-3 font-weight-bold" style="margin: 0px -20px;"><span class="pl-2"><?php echo $item['t']; ?></span></div>
 
<?php }else{ ?>
      
      

<div class="row border-bottom py-3">
 <div class="col-4">            
         <?php  if(isset($item['t'])){ ?><label class=""><?php echo $item['t']; ?></label><?php } ?>
         
         <?php if(isset($item['desc'])){  ?><p><?php echo $item['desc']; ?></p> <?php  } ?>  
         
         </div>            
         <div class="col-8">
 <?php  switch($item['type']){ 
			 
			
			 
			 case "select": {
			 
               ?> 
			 <select name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" class="form-control " id="<?php echo $key; ?>_<?php echo $key1; ?>">
             
             <?php if(isset($item['values']) && is_array($item['values']) ){ foreach($item['values'] as $k => $v){ ?>
             <option value="<?php echo $k; ?>" <?php 
			 
			 if(isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == "" && $item['d'] == $k){  
			 echo "selected=selected"; 
			 }elseif(isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == $k){ 
			 echo "selected=selected"; 
			 } ?>><?php echo $v; ?></option>
             <?php } } ?>
             
             </select>
             
             <?php if(in_array($key1,array("footer_menu1","footer_menu2"))){ ?>
             <a href="nav-menus.php" class="small mt-2" target="_blank">set menu items here</a>
             <?php } ?>
             
             <?php
			 
			 
			 } break;
			 
               case "yesno": {
                
               ?> 
            <div class="">
               <div class="mb-4">
                  <label class="radio off">
                  <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('<?php echo $key; ?><?php echo $key1; ?>_onoff').value='no'">
                  </label>
                  <label class="radio on">
                  <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('<?php echo $key; ?><?php echo $key1; ?>_onoff').value='yes'">
                  </label>
                  <div class="toggle <?php if(!isset($HDATA[$key][$key1])){ echo "on"; }elseif(isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == 'yes'){  ?>on<?php } ?>">
                     <div class="yes">ON</div>
                     <div class="switch"></div>
                     <div class="no">OFF</div>
                  </div>
               </div>
            </div>
            <input type="hidden" name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" id="<?php echo $key; ?><?php echo $key1; ?>_onoff" value="<?php 
			
			if(!isset($HDATA[$key][$key1])){ echo "yes"; }elseif(isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""){ echo $item['d']; }elseif(isset($HDATA[$key][$key1])){ echo stripslashes($HDATA[$key][$key1]); } ?>">
            <?php 
             
               
               } break;
               
               
               
               
               case "seperator": { } break; 
               
               case "upload": { 
               
                
			   
			   $tdata = _ppt(array( $pagekey ,$key));
			    
               ?> 
           
            <input type="hidden" 
               
               id="up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>_aid" 
               
               name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>_aid]" 
              
               class="form-control"
             
             value="<?php if(isset($tdata[$key1.'_aid']) && is_numeric($tdata[$key1.'_aid'])){ echo $tdata[$key1.'_aid']; } ?>"  />  
               
               
                             
            <input 
               name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" 
               type="hidden" 
               id="up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>" 
               value="<?php if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($HDATA[$key][$key1]); } ?>"
               class="form-control form-image-data"
             
               /> 
               
            <div class="pptselectbox mb-3 bg-dark p-1 text-center" style="padding:5px;">
               <img src="<?php if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($HDATA[$key][$key1]); }  ?>" style="max-width:100%; max-height:300px;" class="form-image" 
               id="<?php echo $key."".$key1; ?>_preview_<?php echo $pagekey; ?>" />   
            </div>
            <div class="pptselectbtns mb-5 bg-light text-center py-2">
               <a href="<?php if(isset($HDATA[$key][$key1])){ echo $HDATA[$key][$key1]; } ?>" target="_blank" class="btn btn-sm rounded-0 btn-secondary ml-2">View </a>
               <a href="javascript:void(0);"id="editImg<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>" class="btn btn-sm rounded-0 btn-info mr-3">Edit </a>  
               <a href="javascript:void(0);" id="upload_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>" class="btn btn-sm rounded-0 btn-warning">Change </a>
               <a href="javascript:void(0);" onclick="jQuery('#up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>').val('');document.admin_save_form.submit();" class="btn btn-sm rounded-0 btn-danger">Delete</a>
            </div>
            <script >
               jQuery(document).ready(function () {
               
                   jQuery('#editImg<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>').click(function() {           
                                
                       tb_show('', 'media.php?attachment_id=<?php if(isset($HDATA[$key][$key1."_aid"])){ echo $HDATA[$key][$key1."_aid"]; } ?>&action=edit&amp;TB_iframe=true');
                                    
                       return false;
                   });
                   
                   jQuery('#upload_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>').click(function() {           
                   
                       ChangeAIDBlock('up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>_aid');
                       ChangeImgBlock('up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>');		
                       ChangeImgPreviewBlock('<?php echo $key."".$key1; ?>_preview_<?php echo $pagekey; ?>')
                       
                       formfield = jQuery('#up_<?php echo $key."".$key1; ?>_<?php echo $pagekey; ?>').attr('name');
                    
                       tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                           return false;
                   });
                                   
               });	
            </script>
            <?php 
          
               } break; 
			   
			     case "textarea": {
               ?>
            <div class="form-group">
            <textarea name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" 
            style="height:150px !important; margin-bottom:20px !important; width:100%;" class="form-control pt-2"/><?php 
			if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == "" ){ 
			echo $item['d']; 
			}else{ echo stripslashes($HDATA[$key][$key1]); } ?></textarea>
            </div>
            <?php 
               } break; 
               
			   case "text": {
                ?>    
          
            <div class="form-group">
               <input type="text" 
                  name="admin_values[<?php echo $pagekey; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" 
                  value="<?php if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""  ){ 
				  echo $item['d']; 
				  }else{ echo stripslashes($HDATA[$key][$key1]); } ?>" 
                  id="<?php echo $key; ?>_<?php echo $key1; ?>"
                  
                  <?php if(isset($item['placeholder'])){ ?>placeholder="<?php echo $item['placeholder']; ?>"<?php } ?>       
                  
                  
                  <?php if(strpos(strtolower($item['t']), "link") !== false){ ?>placeholder="https://" <?php } ?>         
                  class="form-control">
            </div>
            <?php 
               
               } break;
               
               
               } // end swiutch 
            
               
                ?> 
</div>
</div> 


<?php } ?>      
      

 
 
             
<?php $i++; } // end foreach ?>

</div><!-- end accordian -->

</div>
      
</div><!-- end container -->
 <?php
 
} 




	 
	
}

?>