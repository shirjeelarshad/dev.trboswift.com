<?php
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */ 
class premiumpress_themes extends framework { 

 	public $ppt_core_settings = array(); // STORES ALL THE CORE THEME SETTINGS
	
	 
	function __construct(){ global $wpdb; 	
	 	
		// FIX FOR NUM SEARCHES
		if(!is_admin() && isset($_GET['s']) && strlen($_GET['s']) < 3 && is_numeric($_GET['s'])){
		header('location: '.home_url()."/?s=&uid=".$_GET['s']);
		exit();
		}
		
		// CRON JOBS
		add_action( 'wp', array($this, 'premiumpress_cron_activation' ) );
 		add_action( 'premiumpress_hourly_event_hook', array($this, 'cron_hourly') );
		add_action( 'premiumpress_daily_event_hook', array($this, 'cron_daily') ); 
		 	
		
		// LOAD IN CONFIG AND CORE WORDPRESS FUNCTIONALITY				
		$this->constants();
		$this->globals();
		$this->theme_support();	
		$this->register_widgets();
		$this->taxonomies();
		$this->actions_add(); 	
		$this->actions_remove();
		$this->default_shortcodes();		 
		$this->default_searchfilters();
		$this->default_blocks();		
			
		// LOAD IN THE ADMIN DESIGNS
		$this->default_designs();	
		 
	}
	
	// START CONSTANTANTS	 
	function constants(){  global  $userdata;	
						
		// GET CURRENT USER
		$userdata = wp_get_current_user(); 
		// THEME VERSION 
		define("THEME_VERSION", "10.5.7");		
		// RELEASE DATE
		define("THEME_VERSION_DATE", "20th May, 2021");		
		// THEME INSTALL LINK
		define("THEME_URI", get_template_directory_uri() );		
		// THEME INSTALL PATH
		define("THEME_PATH", get_template_directory()."/");	  
		// FRAMEWORK LINKS	 
		define("FRAMREWORK_URI", get_template_directory_uri()."/framework/" );	
  			
		// CHILD THEME NAME	
		$f = wp_get_theme();
		if($f->stylesheet != _ppt('template') && strlen($f->stylesheet) > 3 ){		
		  
			define("CHILD_THEME_NAME", $f->stylesheet);				
			define("CHILD_THEME_PATH_URL", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/');
			define("CHILD_THEME_PATH_IMG", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/images/');
			define("CHILD_THEME_PATH_JS", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/js/');
			define("CHILD_THEME_PATH_CSS", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/css/');		
			define("CHILD_THEME_APTH", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/css/');	
			 	 
		}
 	 
	 	// CORE PATHS FOR EASY ACCESS
		if(defined('THEME_FOLDER')){
		define("CORE_PATH_URL", get_template_directory_uri()."/".THEME_FOLDER."/template/");
		define("CORE_PATH_IMG", get_template_directory_uri()."/".THEME_FOLDER."/template/img/");
		define("CORE_PATH_JS", get_template_directory_uri()."/".THEME_FOLDER."/template/js/");
		define("CORE_PATH_CSS", get_template_directory_uri()."/".THEME_FOLDER."/template/css/");	
		}
  
   
		
	}
	  

 	// SUPPORT MINE TYPES
	function my_myme_types($mime_types){
			$mime_types['flv'] 	= 'video/x-flv';
			$mime_types['mp4'] 	= 'video/mp4';
			$mime_types['webm'] = 'video/webm';
			$mime_types['mpeg'] = 'audio/mpeg';
			$mime_types['mp3'] 	= 'audio/mp3';				
			$mime_types['ogg'] 	= 'video/ogg';
			$mime_types['pdf'] 	= 'application/pdf';	
			$mime_types['zip']  = 'application/octet-stream';			
			$mime_types['doc']  = 'application/msword';					 		
			//unset($mime_types['flv']); //Removing the pdf extension		
			return $mime_types;
	}
	  
	
	// START GLOBALS
	function globals() {
	
		// SETUP CORE THEME SETTINGS
		$this->ppt_core_settings = get_option("core_admin_values"); 
	 
		// GET THE MAIN THEME SETTINGS
		if(!isset($GLOBALS['CORE_THEME'])){
		$GLOBALS['CORE_THEME'] = $this->ppt_core_settings;
		}
 		
		// DEMO OPTIONS FOR DEVELOPERS
		if(defined('WLT_DEMOMODE')){
	   
			// DEMO THEME SETUP
			if(isset($_REQUEST['skin'])){	
				$_SESSION['skin']					= $_REQUEST['skin'];
				$GLOBALS['childtemplate'] 			= strip_tags($_REQUEST['skin']);
			}elseif(isset($_SESSION['skin'])){
				$GLOBALS['childtemplate'] 			= strip_tags($_SESSION['skin']);
			}					
						 
		}	// end if	
			 
	}
 
	function clean_script_tag($input) {
	  $input = str_replace("type='text/javascript' ", '', $input);
	  return str_replace("'", '"', $input);
	}
		
	 
	function _locale($locale) {
	 	
		// PUSH SESSION OTHERWISE 
		// TEXT BEFORE
		$this->start_session();
		
		// DEFAULY LANGUAGE
		if(!is_admin() && _ppt(array('lang','default')) != ""){ 
			$locale = _ppt(array('lang','default'));
		}
		
		if(isset($_SESSION['language']) && $_SESSION['language'] != ""){
		  $locale = strip_tags($_SESSION['language']);
		
		}
		
		if(isset($_GET['l']) && strlen($_GET['l']) > 1){
		  $_SESSION['language'] =  strip_tags($_GET['l']);
		  $locale = strip_tags($_GET['l']);
		}  
		
		return $locale;
	}
	// START THEME SUPPORT	
	function theme_support() { 	
	 
		// MENU
		add_theme_support('nav_menus');
		
		// DEFAULT MENU
		register_nav_menus( array('topmenu_en_US' => 'Top Links (en_US)' ) );
		register_nav_menus( array('mainmenu_en_US' => 'Main Navigation (en_US)' ) );	
		register_nav_menu( 'footermenu_en_US', 'Footer Links (en_US)' );		
		register_nav_menus( array('mobilemenu_en_US' => 'Mobile Device Menu (en_US)' ) );	
		
		// REGISTER NEW NAVS FOR DIFFERENT LANGUAGES
		if( is_array(_ppt('languages')) ){
			foreach(_ppt('languages') as $lang){
				if($lang == "en_US"){ continue; }
				register_nav_menus( array('topmenu_'.$lang => 'Top Links ('.$lang.')' ) );			
				register_nav_menus( array('mainmenu_'.$lang => 'Main Navigation ('.$lang.')' ) );
				register_nav_menu( 'footermenu_'.$lang, 'Footer Links ('.$lang.')' );				
				register_nav_menus( array('mobilemenu_'.$lang => 'Mobile Device Menu ('.$lang.')' ) );		
			}
		}
		
		// THUMBNAILS
		add_theme_support( 'post-thumbnails', array( 'post','page' ) );
					 
		// CUSTOM BACKGROUNDS 
		//add_theme_support( 'custom-background' );	
		//add_theme_support( 'custom-header' );		 
		// GLOBAL SUPPORT FOR SELECTIVE WIDGET MENUS
	 
		 
		if(!is_admin() ){
		add_filter('script_loader_tag', array($this, 'clean_script_tag') );	
		}
 	
	}
 
 	
	/*
		this function sets up all the theme
		shortcodes
	*/
	function default_shortcodes(){
	 		
			// HOME URL
			add_shortcode( 'HOME_URL', array($this,'pptv9_shortcode_url') );
			
			// CHECKED 4.4.4.4
			add_shortcode( 'AUTHOR',  array($this, 'ppt_shortcode_author' ) ); 	 
		 	add_shortcode( 'AUTHORIMAGE',  array($this, 'ppt_shortcode_author_image' ) );
			
			// LISTING PAGE
			add_shortcode( 'ID',  array($this, 'pptv9_shortcode_postid' ) );			
			add_shortcode( 'TITLE', array($this,'pptv9_shortcode_title') );	
			add_shortcode( 'EXCERPT',  array($this, 'pptv9_shortcode_excerpt' ) );
			add_shortcode( 'CONTENT',  array($this, 'pptv9_shortcode_content' ) );
			add_shortcode( 'TAGS',  array($this, 'pptv9_shortcode_tags' ) );
			add_shortcode( 'IMAGE', array($this,	'pptv9_shortcode_image' ) );
			add_shortcode( 'IMAGES', array($this,	'pptv9_shortcode_images' ) );	
			add_shortcode( 'GALLERY', array($this,	'pptv9_shortcode_gallery' ) );
			add_shortcode( 'VIDEO',  array($this, 	'pptv9_shortcode_video' ) );
			add_shortcode( 'VIDEO-YOUTUBE',  array($this, 'pptv9_shortcode_video_youtube' ) );
			add_shortcode( 'VIDEO-VIMEO',  array($this, 'pptv9_shortcode_video_vimeo' ) );
			add_shortcode( 'CATEGORY',  array($this, 'pptv9_shortcode_cats' ) );
			add_shortcode( 'COMMENTS',  array($this, 'pptv9_shortcode_comments' ) );
			
			add_shortcode( 'LISTING-RATEBOX',  array($this, 'pptv9_shortcode_listing_ratebox' ) );
			
		 
			add_shortcode( 'CATEGORYIMAGE',  array($this, 'pptv9_shortcode_categoryimage' ) ); 
			add_shortcode( 'CATEGORYICON',  array($this, 'pptv9_shortcode_categoryicon' ) ); 
			add_shortcode( 'TAX',  array($this, 'pptv9_shortcode_taxonomy' ) ); 			
			add_shortcode( 'OFFERS', array($this,'pptv9_shortcode_offers') );
 		    add_shortcode( 'FEATURES', array($this,'pptv9_shortcode_features') );	
			add_shortcode( 'FEATURES_TAX', array($this,'pptv9_shortcode_features_tax') );		
			add_shortcode( 'FAVS',  array($this, 'pptv9_shortcode_favs' ) );
			add_shortcode( 'SUBSCRIBE',  array($this, 'pptv9_shortcode_subscribe' ) );
			 // STORE IMAGES
			add_shortcode( 'STOREIMAGE',  array($this, 'pptv9_shortcode_storeimage' ) );
			add_shortcode( 'STORENAME',  array($this, 'pptv9_shortcode_storename' ) );
		 	add_shortcode( 'STORELINK',  array($this, 'pptv9_shortcode_storelink' ) );
		 	
			// THEME CHANGES
			if(defined('THEME_KEY') && THEME_KEY != "at"){
			add_shortcode( 'PRICE', array($this,'pptv9_shortcode_price') );
 		  	} 
			
			
			
			// SOCIAL MEDIA SHARES
			add_shortcode( 'SOCIALSHARE',  array($this, 'pptv9_shortcode_socialbtns' ) );	 	
			
			// RATING AND SCORES
			add_shortcode( 'RATING', array($this,'ppt_shortcode_rating') );
	 		add_shortcode( 'SCORE',  array($this, 'pptv9_shortcode_score' ) ); 
			add_shortcode( 'RATING_USER', array($this,'pptv9_shortcode_rating_user') );
	 		
			// TIME 
			add_shortcode( 'TIMESINCE', array($this,'ppt_shortcode_timesince') );			
			// INSIDE LOOP
			add_shortcode( 'DISTANCE', array($this, 'ppt_distance' ) );	 
			add_shortcode( 'COUNTRY',  array($this, 'ppt_shortcode_country' ) );
			add_shortcode( 'CITY',  array($this, 'ppt_shortcode_city' ) );			
			// LISTING PAGE
			add_shortcode( 'AMENITIES',  array($this, 'pptv9_shortcode_amenities' ) );
			add_shortcode( 'HITS',  array($this, 'ppt_shortcode_hits' ) );					
			add_shortcode( 'LIKES',  array($this, 'ppt_shortcode_likes' ) ); 		
			// V9 LAYOUT SHORTCODES
			add_shortcode( 'MAINMENU', array($this,'ppt_shortcode_mainmenu') );	
			add_shortcode( 'RIBBON',  array($this, 'ppt_shortcode_ribbon' ) );	
		 	add_shortcode( 'FIELDS', array($this,'ppt_shortcode_fields') );			  
			// LOOP SHORTCODES						
			add_shortcode( 'LOCATION',  array($this, 'ppt_shortcode_location' ) );			 
			add_shortcode( 'TIMELEFT', array($this,'ppt_shortcode_timeleft') );			
			// NORMAL PAGES
			add_shortcode( 'USERS', array($this,'ppt_page_users') );
			add_shortcode( 'LISTINGS', array($this,'ppt_page_listings') );			 
			add_shortcode( 'CATEGORIES', array($this,'ppt_page_categories') );
			add_shortcode( 'MEMBERSHIP', array($this,'ppt_membership_filter') );			
			// BETA				
			add_shortcode( 'SELLSPACE',  array($this, 'ppt_shortcode_advertising' ) );	
			// BETA DISPLAY
			add_shortcode( 'D_CATEGORIES',  array($this, 'ppt_shortcode_dcats' ) ); 				
			add_shortcode( 'SOCIAL',  array($this, 'ppt_shortcode_socialbtns' ) );		 
			add_shortcode( 'FLAG',  array($this, 'ppt_shortcode_flag' ) );					 		
			add_shortcode( 'SCREENSHOT',  array($this, 'ppt_shortcode_screenshot' ) );		 
			add_shortcode( 'GOOGLEMAP', array($this, 'ppt_google_maps_display' ) );
			add_filter('tiny_mce_before_init', array($this, 'tinymce_init' ));			
			
			// PROTECT AGAINST SPAM
			add_action('register_form', array($this, 'spam_registration' )); 
			//add_filter('preprocess_comment', array($this, 'span_filter_comments' )  );
			add_action('user_registration_email',  array($this, 'span_filter_email' ) );	
			
			add_action( 'wp_default_scripts', array($this,  'remove_jquery_migrate' ) );
			
			remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );	
			
			add_filter( 'send_password_change_email', '__return_false' );
			 

	}
	
 
	 

	function remove_jquery_migrate( $scripts ) {
	   if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
	   		if ( $script->deps ) { 
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		 	}
		 }
	 }	
	
	function span_filter_email($user_email = ''){ global $errors;
 
		if(trim($_POST['ppt_spam_hash']) != hash('sha256', "premiumpress-spam-".date("Ymd"))){		
			
				wp_die("<p class=\"error\">".__("Spam bot detected.","premiumpress")."</p>");
			 	
		}
		
		return $user_email;
	
	}
	function span_filter_comments($commentdata){ global $errors;
 
		if(trim($_POST['ppt_spam_hash']) != hash('sha256', "premiumpress-spam-".date("Ymd"))){		
			
				wp_die("<p class=\"error\">".__("Spam bot detected.","premiumpress")."</p>");
			 	
		} 
		
		return $commentdata; 
	
	}
	function spam_registration(){ ?>
	<input type="hidden" name="ppt_spam_hash" value="<?php echo hash('sha256', "premiumpress-spam-".date("Ymd")); ?>" />
	<?php
	
	}
	

	/*
	this function stops the editor in wordpress
	from removing the tags we need
	*/
	function tinymce_init( $init ) {
	
		if(isset($init['extended_valid_elements'])){
		$init['extended_valid_elements'] .= ', span[style|id|nam|class|lang|pre]';
		}else{
		$init['extended_valid_elements'] = ', span[style|id|nam|class|lang|pre]';
		}
		
		$init['verify_html'] = false;
		return $init;
	}
	
	
	function start_session(){ global $CORE;	 
	  	
		
		
		if(!session_id() &&  session_status() == PHP_SESSION_NONE ) {
		 	
        	if(!headers_sent()){
				session_start(); 
			}
		 
		
			if ( !isset($_SESSION['language'] ) && !isset($_REQUEST['l']) ){
			//$_SESSION['language'] = $GLOBALS['CORE_THEME']['language'];		
			}else{		
				if (isset($_REQUEST['l'])){ 
				unset($_SESSION['language']);
				}
				if (isset($_SESSION['language']) && !isset($_REQUEST['l'])){
				}elseif (isset($_SESSION['language'] ) && isset($_REQUEST['l'])){
				unset($_SESSION['language']);
				$_SESSION['language'] = $_REQUEST['l'];  
				}else{
				$_SESSION['language'] = $_REQUEST['l'];			 
				}		
			}			
			

			if(defined('WLT_DEMOMODE') &&  isset($_GET['reset'])){	
				if(isset($_SESSION['design_preview'])){
				unset($_SESSION['design_preview']);
				}
				unset($_SESSION);
				return ;
			}	
		
			if(is_admin()){
			return;
			}	
			 
			if(get_option("ppt_license_key") == ""){	
				return;
			}
		 
		 
			// CHILD THEMES DEMO	 
			if(defined('WLT_DEMOMODE') &&  isset($_GET['skin'])){	
				$_GET['design'] = $_GET['skin'];
				$_SESSION['skin'] = $_GET['skin'];
			 
			 }elseif(defined('WLT_DEMOMODE') &&  isset($_GET['design'])){
			  
				$_SESSION['skin'] = $_GET['design'];
			 
			//}elseif(defined('WLT_DEMOMODE') &&  isset($_SESSION['skin']) && strlen($_SESSION['skin']) > 1 ){
				
				//$_GET['design'] = $_SESSION['skin']; 
			
			}elseif(defined('WLT_DEMOMODE') && empty($_SESSION) && !isset($_GET['design']) ){
			
				$_GET['design'] = $CORE->LAYOUT("captions","demo_design");
				$_SESSION['skin'] = $CORE->LAYOUT("captions","demo_design");
			}
			
			// ADMIN DEMO PREVIEW
			if(is_home() && !isset($_GET['design']) || isset($_GET['reset'])){
			unset($_SESSION['design_preview']);	
			}
			
			 
			// LOAD DEMO
			if(isset($_GET['design']) || isset($_SESSION['design_preview']) ){			
				
				if(isset($_SESSION['design_preview']) && !isset($_GET['design'])  ){
				$thisdesign = $_SESSION['design_preview'];	
				}else{
				$thisdesign = $_GET['design'];		
				} 
				  
				$g = $CORE->LAYOUT("load_single_design", $thisdesign);
				 
				if(is_array($g)){
				
					$dd = get_option("core_admin_values");
					
					if(!is_array($dd)){ $dd = array(); }				 
					$new_core_array = apply_filters( $thisdesign, $dd );
						 
					$GLOBALS['CORE_THEME'] = $new_core_array;			 
					$_SESSION['design_preview'] = $thisdesign; 
					  
				}		
				
			}
			
			
		
    	} // end
		  
		 
 		add_action('wp_logout', array($this,'end_session'));
    	add_action('wp_login', array($this,'end_session'));
   	 	add_action('end_session_action', array($this,'end_session'));

	} 
	
	function end_session() {
	
		if(!session_id()) {
			session_start();
		}
        @session_destroy();
    }  
	
	// REQUIRED FOR REST ERROR NOT TO SHOW
	function close_my_session() {
		if (session_status() == PHP_SESSION_ACTIVE) {
			session_write_close();;
		}
	}
	
	/*
	this functions sets up all the core
	theme filters
	*/
	
	function actions_remove() { 
	
		//REMOVE HEADER DISPLAYS
		remove_action( 'wp_head', 'feed_links_extra', 3 ); //Extra feeds such as category feeds
		remove_action( 'wp_head', 'feed_links', 2 ); // General feeds: Post and Comment Feed
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator');
		remove_action( 'wp_head', 'start_post_rel_link' ,10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link' ,10, 0 );
		remove_action( 'wp_head', 'wlwmanifest_link' );		
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
		remove_action( 'wp_print_styles', 'print_emoji_styles' );		
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);		
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); //  WooCommerce	
		remove_action( 'wp_head', 'wp_resource_hints', 2 );		
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
		remove_action('template_redirect', 'rest_output_link_header', 11, 0);		 
		remove_action('wp_head', 'rel_canonical', 10, 0);
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	
	
	}
	
	function actions_add() { 
	
		 
		// WP HEAD
		add_action( 'wp_head', array($this, '_wp_head'  ), 10 );	 
	 	
		// WP ENQUE STYLES
		add_action( 'wp_enqueue_scripts', array($this, '_enqueue_scripts'  ) );
		add_action( 'admin_enqueue_scripts', array($this, '_enqueue_scripts'  ) );		
	 	
		// PHP SESSIONS
		add_action('init',  array($this, 'start_session') );
		add_action('wp_loaded',  array($this, 'close_my_session' ), 30); 
   
		// PERFORM ALL THE SITE ACTIONS
		add_action('init', array($this, '_ajax_actions' ) );		
 		
		// SETUP LANGUAGE SUPPORT	 
		add_filter('locale', array($this,  '_locale') ,10);  
		add_action('after_setup_theme', array($this, 'set_theme_languages' ));		
		
		// REMOVE GALLERT FROM PAGES
		add_shortcode('gallery', '__return_false');
 			
		// CUSTOM HOOKS
		add_action( 'hook_date', array($this, 'DATE') );
		add_action( 'hook_date_only', array($this, 'DATEONLY') );
  		add_action( 'hook_price', array($this, 'price_format_display') );
		add_action( 'hook_upload', array($this, 'UPLOAD') );
		
		// CURRENCY
		add_action( 'hook_currency_code', array($this, '_currency_get_code') );
		add_action( 'hook_currency_symbol', array($this, '_currency_get_symbol') );
		
		// ADD ON AJAX CALLS
		add_action( 'init', array($this, '_ajax_calls' )  );	 
  		
		// ORDER SYSTEM
		add_action('hook_orderid', array($this, 'order_get_orderid') );	
 		
		// EMAIL SETTINGS
		add_filter('wp_mail_from_name', array($this, '_fromname' ));
		add_filter('wp_mail_from', array($this, '_fromemail' )); 	
	 	
		// COMMENTS PROCESSING
		add_action('wp_insert_comment',  array($this, 'insert_comment_extra') ); 
		add_filter('comment_post_redirect', array( $this, 'redirect_after_comment' ) );
		add_filter( 'preprocess_comment', array($this, '_preprocess_comment' ) );	
		// DELETE COMMENT EXTRAS IN 10.2.2
		add_action('delete_comment', array($this, 'delete_comment_extra' ) );
		//add_action('trash_comment', array($this, 'delete_comment_extra' ) );
		
		// PRESS THIS TYPE
		add_filter('shortcut_link', array($this, 'press_this_ptype') , 11);		
		// HIDE ADMIN
		if(isset($_GET['hideadminbar'])){
		add_filter( 'show_admin_bar', '__return_false' );
		}
		// FIX TEXT WIDGET TITLE;
		add_filter( 'widget_title', array($this, 'widget_title_link' ) );

		
		
		// ADD ON MENU EDITOR 
		add_action('admin_bar_menu', array($this, 'ppt_adminbar_menu_items' ),  999);
  
		// PAGE TITLE FILTER
		add_filter( 'wp_title', array( $this, 'TITLE' ), 10, 2 );
		add_filter('wpseo_title', array( $this, 'TITLE' ), 10, 2 );
		
		// DEBUG EMAIL
		add_filter('wp_mail', array($this,'debug_wpmail') ); 
		
		// CUSTOM MIME TYPES
		add_filter('upload_mimes', array($this, 'my_myme_types')  );	
			
		// REMOVE ADMIN BAR FROM NON-ADMINS
		if(!current_user_can('administrator')){
		add_filter( 'show_admin_bar', '__return_false' );
		} 	
		// SETUP FOR EDITING POSTS
		add_action( 'init', array($this, 'ppt_edit_own_caps') );
		
		// CUSTOM TAXONOMIES
		add_action('init', array($this, 'custom_taxonomies') );	
	 			
		// CURRENY
		add_action('init',array($this, '_currency_setup') ); 
		add_action('hook_price_filter',array($this, '_currency'), 2);	
			
		// Disables Kses only for textarea saves
		foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes') as $filter) {
			remove_filter($filter, 'wp_filter_kses');
		}
		// Disables Kses only for textarea admin displays
		foreach (array('term_description', 'link_description', 'link_notes') as $filter) {
			remove_filter($filter, 'wp_kses_data');
		}
		// ADJUST BODY CLASS
		add_filter('body_class', array($this, 'BODYCLASS' ));
	 	 
		// REMOVES MEDIA HEIGHT/WIDTHS
		add_filter( 'post_thumbnail_html',  array($this,  'remove_thumbnail_dimensions' ), 10, 3 );
 	
	// SOCIAL LOGIN
	add_action('init', array($this, 	'sociallogin') );
	
	// TEMPLATE ADJUSTMENTS
	add_filter('page_template', array($this, 	'handle_page_template') );
	add_filter('single_template', array($this,	'handle_post_type_template') );  
	add_filter('author_template', array($this, 'handle_author_template') );
  	 
	  
		// LOGIN PAGE 
		add_action('login_form', array($this, 'login_form' ) );
 	
		// SEARCH RESULTS PAGE
		add_filter('hook_gallerypage_results_title', array($this, 'gallerypage_results_title' ) );		 
		add_action('hook_items_before', array($this, 'gallerypage_results_top' ) );		
		
		// TPL-CALLBACK PAGE
		add_action('hook_callback_success',array($this,'_hook_callback_success') );
		
		 	
		// IMAGE ADJUSTMENTS
		add_filter( 'get_avatar' , array($this, 'image_avatar' ) , 1 , 4 );
 		add_filter( 'get_avatar', array($this, 'avatar_remove_dimensions' ), 10 );
		
		// MAP INS EARCH RESULTS
		add_action('hook_core_columns_right_top', array($this, 'hook_map_display' ) );
		add_action('hook_core_columns_left_top', array($this, 'hook_map_display1' ) );
	
		// SELLSPACE ADVERTING HOOKS
		add_action('hook_core_columns_right_bottom', array($this, 'hook_sidebar_bottom' ) );
		add_action('hook_core_columns_left_bottom', array($this, 'hook_sidebar_bottom1' ) );
		
		
			// MEDIA
			add_filter( 'wp_calculate_image_srcset', array($this, 'meks_disable_srcset' ) );
			
			
			// Take over the update check
			//add_filter('pre_set_site_transient_update_plugins', array($this,'check_for_plugin_update' ));
			add_filter('pre_set_site_transient_update_themes', array($this,'check_for_theme_update' ));	
			// Take over the Plugin info screen		 		 	
 			add_filter('themes_api', array($this, 'themes_api_call' ), 10, 3);
			
		
				
		 	// THIS CHANGES THE ACTIVE DIRECTORY FOR THEME FILES
			add_action( 'hook_theme_folder', '_ppt_theme_folder' );
			
			
		// HANDLE NEW PAYMENTS
		add_filter('hook_v9_order_process', array($this, '_hook_v9_order_process' ) );
		 
		
		// LOGOUT
		add_action('wp_logout', array($this, 'wp_logout'), 10 );		
 		
		
		add_action( 'admin_bar_menu',  array($this, 'remove_customizer'  ), 999 ); 
		
		 
	
	}  


	
 
	function remove_customizer($wp_admin_bar)
	{
		 $wp_admin_bar->remove_menu( 'customize' );
	}
	
	function wp_logout($uid){ global $CORE;
	
   
  		// SET LISITNGS OFFLINE
		$CORE->USER("set_offline_listings", $uid);
		
		// SET USER OFFLINE
		delete_user_meta($uid, 'online' );
		 
		// ADD LOG
		$CORE->FUNC("add_log",
					array(				 
						"type" 		=> "user_logout",
						"userid" 	=> $uid,					 
					)
		);
	
	
	}
	
	
 
	
	  

	
 	// REMOVE UNWANTED QUERIES
	function fix_queries_2( $query ) { global $wpdb;
	 
		if ( is_home() && strpos($query,"SELECT $wpdb->posts.*") !== false){
		 
			$query = false;
		} 
		return $query;
	}
 
	/*
		this function assigns the language file
		for the entire theme and text domain prefix
	*/
	function set_theme_languages(){	
 	
		load_theme_textdomain('premiumpress', get_template_directory() . '/languages/');
		 
	}
	 
	
	// PRESS THIS CHANGE
	function press_this_ptype($link) {		
		$link = str_replace('press-this.php', "post-new.php?post_type=".THEME_TAXONOMY."_type", $link);
		$link = str_replace('?u=', '&u=', $link);	
		return $link;
	}
	
	function CUSTOMFIELD_LIST($field,$selected="",$isTranslation=1){ global $wpdb, $CORE; $STRING = ""; $in_array = array(); $statesArray = array();	
 						
				$SQL = "SELECT DISTINCT ".$wpdb->postmeta.".meta_value FROM ".$wpdb->postmeta." 
				INNER JOIN ".$wpdb->posts." ON (".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_type = 'listing_type' AND ".$wpdb->posts.".post_status='publish'  )
				WHERE ".$wpdb->postmeta.".meta_key = ('".strip_tags($field)."') LIMIT 0,100";				 
				 
				//if ( WLT_CACHING == false || ( $query = get_transient( 'customfieldlist_query2_'.$field) ) === false   ) {
 
					$query = $wpdb->get_results($SQL, OBJECT);
					//set_transient( 'customfieldlist_query2_'.$field, $query, 24 * HOUR_IN_SECONDS );
				//}
				
				if(!empty($query)){
				
					// LOOK DATA
					foreach($query as $val){
				 
							// ADD TO ARRAY
							$in_array[] 	= $val->meta_value;
							$statesArray[] .= $val->meta_value; 
					}				 						  
					
					// NOW RE-ORDER AND DISPLAY				
					asort($statesArray);					 
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							$label = $state; 
							
							if($field == "map-country" && isset($GLOBALS['core_country_list'][$state]) ){ $label = $GLOBALS['core_country_list'][$state]; }
							
							if($selected != "" &&  strtolower($state) == strtolower($selected) ){							
								$STRING .= "<option value='".$state."' selected=selected>". $label."</option>";
							}else{
								$STRING .= "<option value='".$state."'>". $label."</option>";
							} // end if	
					}					
					
				}
				
				return $STRING;	
	
	}
		
 


	

	

	
	

 	

	
	function CUSTOMLIST($key,$selected){ global $wpdb, $CORE;
	
		$selected = $_GET['sel']; $in_array = array();	$STRING = "";			
		$SQL = "SELECT DISTINCT ".$wpdb->postmeta.".meta_value FROM ".$wpdb->postmeta." 
				INNER JOIN ".$wpdb->posts." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish')
				WHERE ".$wpdb->postmeta.".meta_key = ('".strip_tags($key)."') LIMIT 0,100";
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
				
				$txt = $val->meta_value;
				$value = $val->meta_value;
				
				if($key == "map-country"){
					$c_text = $GLOBALS['core_country_list'][$val->meta_value];
					if($c_text == ""){ continue; }
					$txt = $c_text;
				}				
				
				if($selected != "" &&  $val == $selected){
					$STRING .= "<option value='".$value."' selected=selected>".$txt."</option>";
				}else{
					$STRING .= "<option value='".$value."'>".$txt."</option>";
				} // end if	
			} // end while
		} // end if
	return $STRING;
	}

/* ========================================================================
 [WLT FRAMEWORK] - HEADER
========================================================================== */ 
function make_stylesheet_alt( $tag ) {
 
 $tag = preg_replace( "/='stylesheet' id='__/", "='stylesheet alternate' id='X1", $tag );
 $tag = str_replace("X1", "' title='", $tag );
 $tag = str_replace("id=''", "", $tag );
 $tag = str_replace("__X2-css'", "'", $tag );
 return $tag;
 
}
 
 
 
/* ========================================================================
 [WORDPRESS INIT] - LOADS WHEN THE PAGE LOADS
========================================================================== */ 
function INIT(){	
		global $wpdb, $CORE, $post, $userdata, $pagenow;
		
		 
		// DELETE MEDIA OPTIONS	
		if(isset($_POST['core_delete_attachment']) && $_POST['core_delete_attachment'] == "gogo"){	 
			$CORE->UPLOAD_DELETE($_POST['attachement_id']);
			die();		
		} 
		
		//UPLOAD MEDIA UPLOADS
		if(isset($_FILES['core_attachments']) && !empty($_FILES['core_attachments']) && isset($_POST['value']) && is_numeric($_POST['value']) ){  
			$responce = hook_upload($_POST['value'], $_FILES['core_attachments'], false);		 
			echo json_encode($responce); 
			die();				
		}
		
		//UPLOAD VIDEO THUMBNAILS
		if(isset($_FILES['core_videothumb']) && !empty($_FILES['core_videothumb']) && isset($_POST['value']) && is_numeric($_POST['value']) ){ 	 
			$responce = hook_upload($_POST['value'], $_FILES['core_videothumb'], "videothumbnail");		 
			echo json_encode($responce); 
			die();				
		} 		
		// LOAD IN NEW PAGE SETUP FOR LOGIN SYSTEM
		if(!isset($_GET['reauth']) && !isset($_GET['key'])  ){	
		
			if(!isset($_GET['action'])){ $act = "login"; }else{ $act = strip_tags($_GET['action']); }
			 	
			if($pagenow == "wp-login.php" ){ 
				 
				if(in_array($act,array('login','register', 'lostpassword', 'membership' ))){  //'',
				add_action('init', array( $CORE, 'LOGIN' ) , 98); 	
				}
					
			}		
		}
		
		// APPLY COUPON CODE
		if(defined('WLT_CART')){
			global $CORE_CART;
			$CORE_CART->cart_apply_couponcode();		
 		}
		
		// SAVE CUSTOM SEARCHES
		$savekeyword = "";
		if(isset($_GET['zipcode'])){
			$savekeyword = $_GET['zipcode'];
		}elseif(isset($_GET['s'])){
			$savekeyword = $_GET['s'];
		}
		if(strlen($savekeyword) > 3 && strlen($savekeyword) < 30){
		
		$saved_searches_array = get_option('recent_searches');
		
		if(!is_array($saved_searches_array)){ $saved_searches_array = array(); }
	 	
			// STOP HEAVY DATA QUERY
			if(count($saved_searches_array) > 100){
				$saved_searches_array = array();
			}
		
			if(isset($saved_searches_array[strip_tags(str_replace(" ","_",$savekeyword))])){ 
				
				$views = $saved_searches_array[strip_tags(str_replace(" ","_",$savekeyword))]['views'];
				$views++;
				$saved_searches_array[strip_tags(str_replace(" ","_",$savekeyword))] = 
				array(
				"views" => $views, 
				//"first_view" => $saved_searches_array[strip_tags(str_replace(" ","_",$savekeyword))]['first_view'], 
				//"last_view" => date('Y-m-d H:i:s') 
				); 
			
			}else{ 
			
				$saved_searches_array[strip_tags(str_replace(" ","_",$savekeyword))] = 
				array(
				"views" => 1, 
				//"first_view" => date('Y-m-d H:i:s'), 
				//"last_view" => ""
				);			
			}
					 
		update_option('recent_searches',$saved_searches_array);
		}
 
				
	} // END FUN 
 
 

/* =============================================================================
   DISPLAY CATEGORIES
   ========================================================================== */

function CategoryList($data){  global $CORE;

if(!is_array($data)){ return $data; }
 

$id				=$data[0];
$showAll		=$data[1];
$showExtraPrice	=$data[2]; 
$TaxType		=$data[3];
if(isset($data[4])){ $ChildOf	= $data[4];  }else{$ChildOf="";  }
if(isset($data[5])){ $hideExCats	= $data[5];  }else{ $hideExCats=""; }
if(isset($data[6])){$ShowCatPrice	= $data[6];   }else{ $ShowCatPrice	= "";  }

 
global $wpdb; $exclueMe=array(); $extra = ""; $count=0; $limit = 200; $STRING = ""; $ShowCatCount = get_option("display_categories_count");	$exCats=0;  $largelistme = false; $opgset = false;

// IF WE ARE GOING TO SHOW THE CATPRICE, LETS INCLUDE THE CAT PRICE ARRAY
if($ShowCatPrice){ $current_catprices = get_option('ppt_catprices'); }


 
// WHICH TYPE OF CATEGORY LIST TO DISPLAY?
if($showAll == "toponly"){
		
		if($TaxType == "category"){
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			'exclude'               => $exCats,
			);			
		}else{
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			);			
		}
		 
			$categories = get_categories($args);  
			
		 	if(is_array($categories)){
			foreach($categories as $category) {
			 	// SKIP	
				if ($category->parent > 0 && $ChildOf == 0) { continue; }
				if($ChildOf > 0 && $ChildOf != $category->parent){ continue; }				
				// BUILD DISPLAY				
				$STRING .= '<option value="'.$category->cat_ID.'" ';
				if( ( is_array($id) && in_array($category->cat_ID,$id) ) ||  ( !is_array($id) && $id == $category->cat_ID ) ){
				$STRING .= 'selected=selected';
				}
				$STRING .= '>';
				
				
				$STRING .= $category->cat_name;
				
				
				// SHOW PRICE
				if($ShowCatPrice && isset($current_catprices[$category->cat_ID]) 
				&& ( isset($current_catprices[$category->cat_ID]) && is_numeric($current_catprices[$category->cat_ID]) && $current_catprices[$category->cat_ID] > 0 ) ){ 
				 	$STRING .= " (".hook_price($current_catprices[$category->cat_ID]).')'; 
				}
				// SHOW COUNT
				if($ShowCatCount =="yes"){ $STRING .= " (".$category->count.')'; }			 
				$STRING .= '</option>';
		
			}			
			}
			return $STRING;	
		
/* =============================================================================
   DISPLAY ALL CATEGORIES
   ========================================================================== */
		
		}else{
 		
		$args = array(
		'taxonomy'                 => $TaxType,
		'child_of'                 => $ChildOf,
		'hide_empty'               => $largelistme,
		'hierarchical'             => true,
		'exclude'                  => $exCats);
 	
		$cats  = get_categories( $args );
 
		$newcatarray = array(); $addedAlready = array(); $opgset = false;
		
		// SHOW OPTGROUP
		if(isset($GLOBALS['tpl-add']) && isset($GLOBALS['CORE_THEME']['disablecategory']) && $GLOBALS['CORE_THEME']['disablecategory'] == 1){
		$showopg = true;
		}else{
		$showopg = false;
		}
	
		// NOW WE BUILD A CLEAN ARRAY OF VALUES
		foreach($cats as $cat){	
		 
			if($cat->parent != 0){ continue; }		
			$newcatarray[$cat->term_id]['term_id'] 	=  $cat->term_id;
			
			
			
		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		
		$cat_name = $cat->cat_name;
		
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$cat->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$cat->term_id];			
			}		
		}
			
			
		$newcatarray[$cat->term_id]['name'] 	=  $cat_name;
			
			
			
			
			
			
			
			// SHOW PRICE
			if($ShowCatPrice && isset($current_catprices[$cat->term_id]) 
				&& ( isset($current_catprices[$cat->term_id]) && is_numeric($current_catprices[$cat->term_id]) && $current_catprices[$cat->term_id] > 0 ) ){ 
				 	$newcatarray[$cat->term_id]['name'] .= " (".hook_price($current_catprices[$cat->term_id]).')'; 
			}
			$newcatarray[$cat->term_id]['parent'] 	=  $cat->parent;
			$newcatarray[$cat->term_id]['slug'] 	=  $cat->slug;
			$newcatarray[$cat->term_id]['count'] 	=  $cat->count;
		}
		// SECOND LOOP TO GET CHILDREN
		foreach($cats as $cat){
	 
			if($cat->parent == 0){ continue; }		
			$newcatarray[$cat->parent]['child'][] = $cat;		 
		}
 		 // NOW BUILD THE MAIN ARRAY
		foreach($newcatarray as $cat){
		  	
			if(!isset($cat['term_id'])){ continue; }
			
			// CHECK IF THIS IS SELECTED
			if( ( is_array($id) && in_array($cat['term_id'],$id) ) ||  ( !is_array($id) && $id == $cat['term_id'] ) ){ $EX1 = 'selected=selected'; }else{ $EX1 = ""; }
						
			if(!$showopg && !in_array($cat['term_id'], $addedAlready) && $cat['name'] !=""){ 	 
			
			$STRING .= '<option value="'.$cat['term_id'].'" '.$EX1.'>'.$cat['name'].'</option>';
			
			}elseif($showopg && !in_array($cat['term_id'], $addedAlready) && $cat['name'] !=""){ 			
					if(isset($opgset)){ $STRING .= '</optgroup>'; }
					$opgset = true;					
					$STRING .= '<optgroup data-parent="optiongroup" label="'.$cat['name'].'">';
			}
			
			
			$addedAlready[] = $cat['term_id'];
			 	
			if(!empty($cat['child'])){	
				foreach($cat['child'] as $sub1){ 
				 			
							// CHECK IF THIS IS SELECTED
							if( ( is_array($id) && in_array($sub1->term_id,$id) ) ||  ( !is_array($id) && $id == $sub1->term_id ) ){ $EX2 = 'selected=selected'; }else{ $EX2 = ""; }
							
							// SHOW PRICE
							if($ShowCatPrice && isset($current_catprices[$sub1->term_id]) 
								&& ( isset($current_catprices[$sub1->term_id]) && is_numeric($current_catprices[$sub1->term_id]) && $current_catprices[$sub1->term_id] > 0 ) ){ 
									$sub1->name .= " (".hook_price($current_catprices[$sub1->term_id]).')'; 
							}
														
							// OUTPUT
							if(!in_array($sub1->term_id, $addedAlready)){ 
							$STRING .= '<option value="'.$sub1->term_id.'" '.$EX2.'> -- '.$sub1->name.'</option>';
							}
							$addedAlready[] = $sub1->term_id;
							 
							// CHECK FOR SUB CATS LEVEL 2
							if(!empty($newcatarray[$sub1->term_id]['child'])){  
							 
								foreach($newcatarray[$sub1->term_id]['child'] as $sub2){
									
									// CHECK IF THIS IS SELECTED
									if( ( is_array($id) && in_array($sub2->term_id,$id) ) ||  ( !is_array($id) && $id == $sub2->term_id ) ){ $EX3 = 'selected=selected'; }else{ $EX3 = ""; }
																		
									// OUTPUT
									if(!in_array($sub2->term_id, $addedAlready)){ 
									$STRING .= '<option value="'.$sub2->term_id.'" '.$EX3.'> ---- '.$sub2->name.'</option>';	
									}
									$addedAlready[] = $sub2->term_id;						
									 
									// CHECK FOR SUB CATS LEVEL 2
								 
									if(!empty($newcatarray[$sub2->term_id]['child'])){ 
										foreach($newcatarray[$sub2->term_id]['child'] as $sub3){
									
											// CHECK IF THIS IS SELECTED
											if( ( is_array($id) && in_array($sub3->term_id,$id) ) ||  ( !is_array($id) && $id == $sub3->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
																						
											// OUTPUT
											if(!in_array($sub3->term_id, $addedAlready)){ 
											$STRING .= '<option value="'.$sub3->term_id.'" '.$EX4.'> ------ '.$sub3->name.'</option>';	
											}
											$addedAlready[] = $sub3->term_id;	
											
											
											// CHECK FOR SUB CATS LEVEL 2
											if(!empty($newcatarray[$sub3->term_id]['child'])){ 
												foreach($newcatarray[$sub3->term_id]['child'] as $sub4){										
										
													// CHECK IF THIS IS SELECTED
													if( ( is_array($id) && in_array($sub4->term_id,$id) ) ||  ( !is_array($id) && $id == $sub4->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
												
													
													// OUTPUT
													if(!in_array($sub4->term_id, $addedAlready)){ 
													$STRING .= '<option value="'.$sub4->term_id.'" '.$EX4.'> ------ '.$sub4->name.'</option>';	
													}
													$addedAlready[] = $sub4->term_id;	
																							
												}
											} 
										 									
										}										
									}
									
								}
						}
							
				}
			}
			 	
		
		} // end foreach
		
		if($opgset){ $STRING .= '</optgroup>'; }
  	
		return $STRING;		

	}
}

 /* =============================================================================
   CUSTOM FIELD DISPLAY FUNCTION
   ========================================================================== */

function CUSTOMFIELDLIST($value1="", $key="meta_key"){
	
		global $wpdb; $STRING = ""; $STRING1 = ""; $cleanArray = array(); $removeValues = array('map-country','map-state','map-city');		
		
				 	
		$SQL = "SELECT DISTINCT ".$key." FROM $wpdb->postmeta LIMIT 200";
			 
		$last_posts = (array)$wpdb->get_results($SQL);
		$savestring = array();
		foreach($last_posts as $value){			
			$savestring[] = $value->meta_key;		
		}
			
		asort($savestring);		 
		
		foreach($savestring as $k => $value){
		
			//CLEAN UP
			if(substr($value,0,1) == "_"){ continue; }
				 	
			if(is_array($value1) && in_array($value,$value1)){
					$STRING .= "<option value='".$value."' selected>".$value."</option>";
			}elseif(!is_array($value1) && $value1 == $value){
					$STRING .= "<option value='".$value."' selected>".$value."</option>";
			}else{
					$STRING .= "<option value='".$value."'>".$value."</option>";
			}
		}
		
		return $STRING;
	 
}








 
/* =============================================================================
  PAGE ACCESS
   ========================================================================== */

 
 
// RETUNS A COUNT FOR HOW MANY PACKAGES ARE VISIBLE (NOT HIDDEN)
function _PACKNOTHIDDEN($c){ $count = 0;
if(is_array($c) && !empty($c) ){
	foreach($c as $v){
		if( ( !isset($v['hidden']) ) || ( isset($v['hidden']) && $v['hidden'] != "yes" )){
		$count++;
		}
	}
}
return $count;
} 

 
// FIX BLANK TEXT WIDGET TITLES
function widget_title_link( $title ) {
	return $title."&nbsp;";
}
 


function reports($date1, $date2, $runnow=false, $returnSQL=false){ global $wpdb, $CORE, $userdata; $SQL = array(); $core_admin_values = get_option("core_admin_values");

	// IF ITS A CRON, MAKE SURE THE USER HAS ENABLED THE REPORT AND EMAIL
	if(!$runnow){
		if(!isset($core_admin_values['ppt_report']) || isset($core_admin_values['ppt_report']['email']) && $core_admin_values['ppt_report']['email'] == ""  ){
		return "";
		}
	}
 		
 	// DEFAULTS FOR DATES
	if($date1 == ""){ $date1 = date('Y-m-d', strtotime('-7 days')); }
	if($date2 == ""){ $date2 = date('Y-m-d'); }
	 	
		// TOP 10 RECENT LISTINGS
		if(_ppt(array('ppt_report','f1')) == 1 || $returnSQL == true){
			 
			$SQL[] = array(
					"sql" => "SELECT ID, post_title, post_date FROM ".$wpdb->posts." 
					WHERE ".$wpdb->posts.".post_status='publish'
					AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type'
					AND ".$wpdb->posts.".post_date >= '" .$date1. "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->posts.".ID DESC
					LIMIT 0,10", 
			"title" => "10 MOST RECENT LISTINGS",
			"date" => true,					
			);		
		 
		}// end f1
				
		// TOP 10 POPULAR LISTING
		if(_ppt(array('ppt_report','f2')) == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT ".$wpdb->posts.".ID, ".$wpdb->posts.".post_title, ".$wpdb->postmeta.".meta_value FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->postmeta." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type')
					WHERE ".$wpdb->postmeta.".meta_key = ('hits')
					AND ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->postmeta.".meta_value+0 DESC
					LIMIT 0,10",
			"title" => "10 MOST POPULAR LISTINGS",
			"hits" => true,
			);	
				
		} // end f2
				
		// TOP 10 USER RATED LISTINGS
		if(_ppt(array('ppt_report','f3')) == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT ".$wpdb->posts.".ID, ".$wpdb->posts.".post_title, ".$wpdb->postmeta.".meta_value FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->postmeta." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type')
					WHERE ".$wpdb->postmeta.".meta_key = ('starrating_votes')
					AND ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->postmeta.".meta_value+0 DESC
					LIMIT 0,10",
			"title" => "10 MOST RATED LISTINGS",
			"rating" => true,
			);	
				
		} // end f3
				
		// TOP 10 ORDERS
		if(_ppt(array('ppt_report','f4')) == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT order_id as post_title, order_total as meta_value, autoid as meta_value1 FROM `".$wpdb->prefix."core_orders`
					WHERE ".$wpdb->prefix."core_orders.order_date >= '" . $date1 . "' AND ".$wpdb->prefix."core_orders.order_date < '".$date2."'
					ORDER BY ".$wpdb->prefix."core_orders.autoid DESC LIMIT 0,10",
			"title" => "10 MOST RECENT ORDERS",
			"orders" => true,
			); 
				
		} // end f4
				
		// TOP 10 SEARCH TERMS
		if(_ppt(array('ppt_report','f5')) == 1 || $returnSQL == true){
				
			$saved_searches_array = get_option('recent_searches');
			if(is_array($saved_searches_array) && !empty($saved_searches_array) ){ 
						 
						$saved_searches_array = $CORE->multisort( $saved_searches_array, array('views') ); $jj = array(); $i =0;
						foreach($saved_searches_array  as $key=>$searchdata){ if($i > 11){ continue; }
						
							if(strtotime($searchdata['first_view']) >= strtotime( date('Y-m-d H:i:s', strtotime('-7 days')) ) ){							
								$jj[$i]['post_title'] = str_replace("_"," ",$key);
								$jj[$i]['views'] = $searchdata['views'];
								$i++;
							}
						} // foreach
						
						$SQL[] = array(
						"sql" => "none",
						"title" => "10 MOST SEARCHED KEYWORDS",
						"array" => $jj
						);
											
			}
				
		} // end f5
 								
		// TOP 10 COMMENTS
		if(_ppt(array('ppt_report','f6')) == 1 || $returnSQL == true){
				
			$SQL[] = array(
				 	
				"sql" => "SELECT DISTINCT ".$wpdb->comments.".comment_ID, ".$wpdb->comments.".comment_content AS post_title  
					FROM ".$wpdb->comments."
					LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) 
					WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND ".$wpdb->comments.".comment_date >= '" . $date1 . "' AND ".$wpdb->comments.".comment_date < '".$date2."'
					ORDER BY comment_date_gmt DESC LIMIT 10",
				"title" => "10 LATEST COMMENTS"
				); 
				 
			} // end f6
				
		// TOP 10 AUTHORS
		if(_ppt(array('ppt_report','f7')) == 1 || $returnSQL == true){
			 
			$SQL[] = array(
					"sql" => "SELECT count(".$wpdb->posts.".ID) AS meta_value, ".$wpdb->users.".user_nicename AS post_title, ".$wpdb->posts.".post_author FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->users." ON ( ".$wpdb->posts.".post_author = ".$wpdb->users.".ID )
					WHERE ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type' 
					GROUP BY ".$wpdb->users.".user_nicename
					LIMIT 0,10",
				"title" => "10 MOST ACTIVE AUTHORS",
				"users" => true,
				); 
					 	 
		}// end f1
		
		if($returnSQL){ return $SQL; };
	 	
		// LOOP THROUGH AND RUN THE SQL QUERIES
		if(is_array($SQL)){ $STRING = "";
			
			foreach($SQL as $querystr){
				 
				if($querystr['sql'] == "none"){
						
							$STRING .= "<h4>".$querystr['title']."</h4><hr />";						
							$STRING .= '<div id="tb1" style="padding:20px; background:#fafafa"><table>';
								foreach ( $querystr['array'] as $r ) {									 
									$STRING .= "<tr>
										<td>".$r['post_title']."</td>
										<td>".$r['views']." Searches</td>
										<td><a href='".get_home_url().'/?s='.$r['post_title']."' style='text-decoration:none;background-color:#CC0000;color:#fff;padding:5px;'>Link</a><br></td>
									  </tr>";
								} // end foreach		
							$STRING .= "</table></div>";
						
										
				}else{ 
					$results = $wpdb->get_results($querystr['sql']);						
					$STRING .= "<h4>".$querystr['title']."</h4>";	
					if(!empty($results)){						
							$STRING .= '<div id="tb1"><table>';
								foreach ( $results as $r ) {
									 $hits = "";
									if(isset($querystr['hits'])){
										$hits = get_post_meta($r->ID,'hits',true);
										if($hits == ""){ $hits = "0 views"; }else{ $hits = $hits." views"; }
									}
									if(isset($querystr['date'])){
										$hits = hook_date($r->post_date);
									}
									if(isset($querystr['rating'])){
										$hits = $r->meta_value ." votes";
									}
									if(isset($querystr['users']) ){
										$hits = $r->meta_value ." listings";
										$link = get_home_url()."/?s=&uid=".$r->post_author;
									}elseif($querystr['orders']){
										$hits = hook_currency_symbol('')."".$r->meta_value ."";
										$link = get_home_url()."/wp-admin/admin.php?page=6&id=".$r->meta_value;
									}else{
										$link = get_permalink($r->ID);
									}
									
									$STRING .= "<tr>
										<td>".$r->post_title."</td>
										<td>".$hits."</td>
										<td><a href='".$link."' style='text-decoration:none;background-color:#CC0000;color:#fff;padding:5px;'>Link</a><br></td>
									  </tr>";
								} // end foreach		
							$STRING .= "</table></div>";	
					}else{
					$STRING .= "No record found";
					}		
				} // end if	
			}// end foreach	
		 	
				
		} // end if 
	
	} // end report function 
 
/* =============================================================================
ADMIN MENU BAR EXTRAS
========================================================================== */

	// CUSTOM EDIT BAR OPTIONS
	function ppt_adminbar_menu_items($wp_admin_bar){ global $post;
 
 			if(is_single()){			
			
			if($post->post_type == "listing_type"){
			$wp_admin_bar->add_node(array(
			'id' => 'ppt_adminbar_theme-1',
			'title' => '<i class="dashicons dashicons-admin-tools" style="font-family: dashicons;"></i>  Edit This',
			'meta'  => array( 'class' => 'admin-toolbar-editor' ),
			'href' => home_url().'/wp-admin/admin.php?page=listings&eid='.$post->ID,
			));
			
 			$wp_admin_bar->remove_node( 'edit' );
			}
			
			}
			
			$wp_admin_bar->remove_node( 'new-post' );
    		$wp_admin_bar->remove_node( 'new-link' );
    		$wp_admin_bar->remove_node( 'new-media' );
 
 			
 			$wp_admin_bar->add_node(array(
			'id' => 'ppt_adminbar_theme-editor',
			'title' => '<i class="dashicons dashicons-performance" style="font-family: dashicons;"></i> turbobid',
			'meta'  => array( 'class' => 'admin-toolbar-editor' ),
			'href' => home_url().'/wp-admin/admin.php?page=premiumpress',
			));
		 
			return $wp_admin_bar;	
		
	}
 
 	
	
}// END CLASS

 
?>