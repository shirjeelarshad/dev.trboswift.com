<?php
 

/*
	this function performs the installation
*/
function premiumpress_install_and_reset(){ global $CORE, $userdata, $wpdb;



	// REINSTALL
	if(get_option("core_theme_defaults_loaded") == "" && isset($_POST['adminArray']['ppt_license_key']) && isset($_POST['reinstall']) ){	
	 	
		
		// SET LICENSE KEY
		update_option('ppt_license_key', trim($_POST['adminArray']['ppt_license_key']), true);		
		
		// MAKE CHECKES
		header("location: ".get_home_url().'/wp-admin/admin.php?page=premiumpress');
		exit();		
	
	// FIRST INSTALL
	}elseif(get_option("core_theme_defaults_loaded") == "" && isset($_POST['adminArray']['ppt_license_key']) && isset($_POST['firstimeinstall']) ){		 	  
			
		// SAVE THE THEME NAME FOR LATER USE
		update_option('ppt_theme', $_POST['admin_values']['template']);
		
		// INSTALL THEME TABLES
		core_admin_2_themeinstall();	
		
		// UPDATE
		update_option("ppt_reinstall", THEME_VERSION);
					
		// SET LICENSE KEY
		update_option('ppt_license_key', trim($_POST['adminArray']['ppt_license_key']), true);
		
		// MAKE CHECKES
		header("location: ".get_home_url().'/wp-admin/admin.php?page=settings&firstinstall=1');
		exit();		
	
	}// END FIRST INSTALLATION
	
	// SYSTEM RESET
	if(isset($_POST['core_system_reset']) && $_POST['core_system_reset'] == "new"){		 	
			
			if(current_user_can( 'edit_user', $userdata->ID ) ){
			
				delete_option("ppt_reinstall");
			
			
				// [MYSQL] DROP ALL OF THE TABLES LINKED TO OUR THEMES
				$wpdb->query("delete a,b,c,d
							FROM ".$wpdb->prefix."posts a
							LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
							LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
							LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
							LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
							WHERE a.post_type ='".THEME_TAXONOMY."_type'");
				
				// 2. DELETE ALL CATEGORIES
				$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');	 
				$count = count($terms);
				if ( $count > 0 ){				
						foreach ( $terms as $term ) {
							wp_delete_term( $term->term_id, THEME_TAXONOMY );
						}
				}
			
				// RESET ALL CORE VALUES
				update_option('ppt_installed_theme','');
				update_option('ppt_license_key','');
				update_option('ppt_license_upgrade', '');
				update_option("core_theme_defaults_loaded","");
				update_option("core_admin_values","");
				// REDIRECT TO DASHBOARD
				header("location: ".get_home_url().'/wp-admin/index.php');
				exit();			
			}
			
	} // END SYSTEM RESET	

}

/*
FUNCTION USED WHEN OUR THEME IS DEACTIVATED
*/
function core_admin_01_theme_deactivated(){ }
   
  
function ppt_install_db_tables($droptable = true){ global $wpdb;

 
// [MYSQL] INSTALL SESSION TABLE FOR CART
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_sessions` (
  `session_key` varchar(100) NOT NULL,
  `session_date` datetime NOT NULL,
  `session_userid` int(10) NOT NULL,
  `session_data` text NOT NULL,
  PRIMARY KEY (`session_key`));");

$wpdb->query("ALTER TABLE ".$wpdb->prefix."core_sessions CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
 

}

 
function core_admin_2_themeinstall($test=false){ global $wpdb, $CORE; $CORE->taxonomies(); $GLOBALS['theme_defaults'] = array();

	// INSTALL DATABASE TABLES
	ppt_install_db_tables();
 	
	// [WORDPRESS] DEFAULT MEDIA OPTIONS
	update_option('thumbnail_size_w', 300);
	update_option('thumbnail_size_h', 350);
	update_option('thumbnail_crop', 0);	 
	update_option('core_post_types', ''); 
	update_option('posts_per_page', '12');
	update_option('recent_searches','');
	
	// ADD IN NEW TAX ORDERING CHANGES
	ppt_orderby_activated(false);	
	
	// [PAGES] CREATE DEFAULT THEME PAGES
	$page_links = array();
	
	$theme_pages = array( 
	
		"My Account"	=> "templates/tpl-page-account.php", 
		"Blog" 			=> "templates/tpl-page-blog.php", 
		"Callback" 		=> "templates/tpl-callback.php", 
		"Contact" 		=> "templates/tpl-page-contact.php", 
		"About Us" 		=> "templates/tpl-page-aboutus.php", 
		"FAQ" 			=> "templates/tpl-page-faq.php", 
		"Advertising" 	=> "templates/tpl-page-sellspace.php", 
		
		"Terms" 		=> "templates/tpl-page-terms.php", 
		"Privacy" 		=> "templates/tpl-page-privacy.php",  
		"Add Listing" 	=> "templates/tpl-add.php",
		"Testimonials" 	=> "templates/tpl-page-testimonials.php", 
		"Memberships" 	=> "templates/tpl-page-memberships.php", 
		
		"How it works" 	=> "templates/tpl-page-how.php", 
		"Top Listings" 	=> "templates/tpl-page-top.php",
		
		"Checkout" 		=> "_shop/tpl-shop-checkout.php", 
		"Cart"			=> "_shop/tpl-shop-cart.php" ,
		
		"Stores"		=> "_coupon/tpl-page-stores.php"  
	
	 );
	 
	 if( in_array($_POST['admin_values']['template'],array("dating"))){
	 $theme_pages['chatroom']  = "_dating/tpl-chatroom.php";
	 }
	 
	 
	  if( !in_array($_POST['admin_values']['template'],array("coupon"))){
	 unset($theme_pages['Stores']);	 
	 }
	 
	  
	 if( isset($_POST['admin_values']['template']) && !in_array($_POST['admin_values']['template'],array("software")) ){
	 
		 if( isset($_POST['admin_values']['template']) && in_array($_POST['admin_values']['template'],array("shop")) ){
			unset($theme_pages['Add Listing']);
			unset($theme_pages['Memberships']);	 
		 }else{
			unset($theme_pages['Checkout']);	
			unset($theme_pages['Cart']);	
		 }
		 
	 }
 
	foreach($theme_pages as $ntitle => $nkey){
		
		if ( get_page_by_title( $ntitle ) == NULL ) {
		
		$page = array();
		$page['post_title'] 	= $ntitle;
		$page['post_content'] 	= '';
		$page['post_status'] 	= 'publish';
		$page['post_type'] 		= 'page';
		$page['post_author'] 	= 1;
		$page_id = wp_insert_post( $page );
		update_post_meta($page_id , 'pagecolumns', 3);
		update_post_meta($page_id , '_wp_page_template', $nkey);
		$page_links[$nkey] = get_permalink($page_id);
		
		update_post_meta($page_id,'sub-description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat.');
		
		}else{
			$pagep = get_page_by_title( $ntitle );
			$page_links[$nkey] = get_permalink($pagep->ID);
		}
	
	}
	
 	
	
	// NOW ASSIGN PAGES	
	 
	$GLOBALS['theme_defaults']['links'] = array();
	$GLOBALS['theme_defaults']['links']['blog'] 		= $page_links['templates/tpl-page-blog.php'];
	$GLOBALS['theme_defaults']['links']['myaccount'] 	= $page_links['templates/tpl-page-account.php'];	
	$GLOBALS['theme_defaults']['links']['callback'] 	= $page_links['templates/tpl-callback.php'];
	//$GLOBALS['theme_defaults']['links']['members'] 		= $page_links['tpl-page-members.php'];
	$GLOBALS['theme_defaults']['links']['contact'] 		= $page_links['templates/tpl-page-contact.php'];
	$GLOBALS['theme_defaults']['links']['sellspace'] 	= $page_links['templates/tpl-page-sellspace.php'];
	$GLOBALS['theme_defaults']['links']['aboutus'] 		= $page_links['templates/tpl-page-aboutus.php'];
	$GLOBALS['theme_defaults']['links']['terms'] 		= $page_links['templates/tpl-page-terms.php'];
	$GLOBALS['theme_defaults']['links']['privacy'] 		= $page_links['templates/tpl-page-privacy.php'];
	$GLOBALS['theme_defaults']['links']['faq'] 			= $page_links['templates/tpl-page-faq.php'];
 	$GLOBALS['theme_defaults']['links']['testimonials'] = $page_links['templates/tpl-page-testimonials.php'];
 	
	$GLOBALS['theme_defaults']['links']['how'] 			= $page_links['templates/tpl-page-how.php'];
 	$GLOBALS['theme_defaults']['links']['top'] 			= $page_links['templates/tpl-page-top.php'];
 	
	if( isset($_POST['admin_values']['template']) && in_array($_POST['admin_values']['template'],array("software")) ){
	
			$GLOBALS['theme_defaults']['links']['cart'] 		= $page_links['_software/tpl-shop-cart.php'];
			$GLOBALS['theme_defaults']['links']['checkout'] 	= $page_links['_software/tpl-shop-checkout.php'];	 	
		 
			$GLOBALS['theme_defaults']['links']['add'] 			= $page_links['templates/tpl-add.php'];
			$GLOBALS['theme_defaults']['links']['memberships'] 	= $page_links['templates/tpl-page-memberships.php'];
	
	}else{
	
		if( in_array($_POST['admin_values']['template'],array("shop"))){	
			$GLOBALS['theme_defaults']['links']['cart'] 		= $page_links['_shop/tpl-shop-cart.php'];
			$GLOBALS['theme_defaults']['links']['checkout'] 	= $page_links['_shop/tpl-shop-checkout.php'];	 	
		}else{	
			$GLOBALS['theme_defaults']['links']['add'] 			= $page_links['templates/tpl-add.php'];
			$GLOBALS['theme_defaults']['links']['memberships'] 	= $page_links['templates/tpl-page-memberships.php'];
		} 
	}
	
	if( in_array($_POST['admin_values']['template'],array("coupon"))){
	$GLOBALS['theme_defaults']['links']['stores'] 	= $page_links['_coupon/tpl-page-stores.php'];	
	}
	
	if( in_array($_POST['admin_values']['template'],array("dating"))){
	$GLOBALS['theme_defaults']['links']['chatroom'] 	= $page_links['_dating/tpl-chatroom.php'];		
	}
 
// SOCIAL
$GLOBALS['theme_defaults']['company'] = array("twitter" => "#", "facebook" => "#",  "youtube" => "#", "skype" => "#", "instagram" => "#");
 
 
update_option('show_on_front','page');
update_option('page_on_front', 0);
 
// DEFAULT MEMBERSHIP PACKAGES	
	
$cmems = array( 
    "name" => array(
            "0" => "Free Membership",
            "1" => "Bronze Membership",
            "2" => "Silver Membership",
            "3" => "",
            "4" => "",			
	),
    "subtitle" => array("0" => "", "1" => "", "2" => "", "3" => "", "4" => ""),

    "desc" => array( 
	"0" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.", 
	"1" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.", 
	"2" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.", 
	"3" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue."
	),

    "price" => array("0" => "0", "1" => "20","2" => "40", "3" => "60","4" => "100"),

    "days" => array(
            "0" => "1",
            "1" => "7",
            "2" => "14",
            "3" => "30",
            "4" => "365",
        ),

    "recurring" => array(
            "0" => "0",
            "1" => "0",
            "2" => "0",
            "3" => "1",
            "4" => "0",
        ), 

    "key" => array(
            "0" => "mem1",
            "1" => "mem2",
            "2" => "mem3",
            "3" => "mem4",
            "4" => "mem5",
        ),
 

);

update_option('csubscriptions', $cmems);	
	
// SAMPLE PAYPAL GATEWAY
update_option('gateway_onepay', 'yes');
update_option('paypal_email', 'sample@paypal.com');	
update_option('paypal_currency', 'USD');	
 
	 
// WEBSITE FAQ
$cfaq = array(

"name" => array(

0 => "This is a sample FAQ for your website.",
1 => "This is a sample FAQ for your website.",
2 => "This is a sample FAQ for your website.",
3 => "This is a sample FAQ for your website.",
4 => "This is a sample FAQ for your website.",

),

"desc" => array(

0 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",

1 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",


2 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",


3 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",


4 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",

),

);
update_option('cfaq', $cfaq);	


switch($_POST['admin_values']['template']){
	
	case "coupon":
	case "micro":
	case "job": 
	case "compare": {
	
	$dafelds = array();
	update_option("cfields", $dafelds);	
	
	} break;
	
	
		  case "learning": {
	   
	   $dafelds = array('name' => array('0' => 'Price','1' => 'Level','2' => 'Language','3' => 'Course Requirements',),'help' => array('0' => '','1' => '','2' => '','3' => '',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'textarea',),'dbkey' => array('0' => 'price','1' => 'level','2' => 'language','3' => 'req',),'values' => array('0' => '','1' => '','2' => '','3' => '',),'taxonomy' => array('0' => 'category','1' => 'level','2' => 'language','3' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),);
		
		update_option("cfields", $dafelds);
	   
	   } break;
	
	
	  case "cardealer": {
	   
	   $dafelds = array('name' => array('0' => 'Make','1' => 'Model','2' => 'Year','3' => 'Condition','4' => 'Body','5' => 'Fuel','6' => 'Transmission','7' => 'Exterior','8' => 'Interior','9' => 'Doors','10' => 'Engine','11' => 'Seller','12' => 'Miles','13' => 'Drive','14' => 'Owners',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'taxonomy','2' => 'input','3' => 'taxonomy','4' => 'taxonomy','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'taxonomy','9' => 'taxonomy','10' => 'taxonomy','11' => 'taxonomy','12' => 'input','13' => 'taxonomy','14' => 'taxonomy',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'year','3' => 'key3','4' => 'key4','5' => 'key5','6' => 'key13','7' => 'key6','8' => 'key7','9' => 'key8','10' => 'key9','11' => 'key10','12' => 'miles','13' => 'key12','14' => 'key1214',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'taxonomy' => array('0' => 'make','1' => 'model','2' => 'category','3' => 'condition','4' => 'body','5' => 'fuel','6' => 'transmission','7' => 'exterior','8' => 'interior','9' => 'doors','10' => 'engine','11' => 'owners','12' => 'category','13' => 'drive','14' => 'owners',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),);
	   
	   update_option("cfields", $dafelds);
	   
	   } break;
	
	
	case "software": {
	
	$dafelds = array('name' => array('0' => 'Price','1' => 'Version','2' => 'Operating System','3' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '',),'fieldtype' => array('0' => 'input','1' => 'input','2' => 'taxonomy','3' => 'input',),'dbkey' => array('0' => 'price','1' => 'version','2' => 'system','3' => 'examplefield',),'values' => array('0' => '','1' => '','2' => '','3' => '',),'taxonomy' => array('0' => 'category','1' => 'category','2' => 'system','3' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),);
		
		update_option("cfields", $dafelds);
	
	
	} break;
	
	case "realestate": {
	
	   $dafelds = array('name' => array('0' => 'Asking Price','1' => 'Property Type','2' => 'Beds','3' => 'Baths','4' => 'Property Size (sqft)','5' => 'Phone Number','6' => 'Website','7' => 'My Custom Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'taxonomy','4' => 'input','5' => 'input','6' => 'input','7' => 'input',),'dbkey' => array('0' => 'price','1' => 'key75170','2' => 'key751701','3' => 'key751702','4' => 'size','5' => 'phone','6' => 'website','7' => 'customfield',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'taxonomy' => array('0' => 'category','1' => 'type','2' => 'beds','3' => 'baths','4' => 'category','5' => 'category','6' => 'category','7' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no',),'cat' => array('0' => 'Array',),);
	   
	update_option("cfields", $dafelds);	
	
	} break;
	
	
	case "escort": {
	
$dafelds = array('name' => array('0' => 'Ethnicity','1' => 'Sexuality','2' => 'Gender','3' => 'Location','4' => 'What do I look like?','5' => 'My Eyes','6' => 'My Hair','7' => 'My Body','8' => 'My Height','9' => 'Dress Size','10' => 'Bust size','11' => 'My Habbits','12' => 'Drinking','13' => 'Smoking','14' => 'WhatsApp Number',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'taxonomy','2' => 'taxonomy','3' => 'input','4' => 'title','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'input','9' => 'input','10' => 'input','11' => 'title','12' => 'taxonomy','13' => 'taxonomy','14' => 'input',),'dbkey' => array('0' => 'key2','1' => 'key3','2' => 'key4','3' => 'map-city','4' => 'key5','5' => 'key6','6' => 'key7','7' => 'key8','8' => 'height','9' => 'dresssize','10' => 'bustsize','11' => 'key9','12' => 'key10','13' => 'key11','14' => 'whatsapp',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'taxonomy' => array('0' => 'dathnicity','1' => 'dasexuality','2' => 'dagender','3' => 'category','4' => 'category','5' => 'daeyes','6' => 'dahair','7' => 'dabody','8' => 'category','9' => 'category','10' => 'category','11' => 'category','12' => 'dadrink','13' => 'dasmoke','14' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),'cat' => array('0' => 'Array',),);

update_option("cfields", $dafelds);	

	} break;
	
	case "dating": {


$dafelds = array('name' => array('0' => 'Age','1' => 'Ethnicity','2' => 'Sexuality','3' => 'Gender','4' => 'What do I look like?','5' => 'My Eyes','6' => 'My Hair','7' => 'My Body','8' => 'My Habbits','9' => 'Drinking','10' => 'Smoking',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '',),'cat' => array('0' => 'Array','1' => 'Array','2' => 'Array','3' => 'Array','4' => 'Array','5' => 'Array','6' => 'Array','7' => 'Array','8' => 'Array','9' => 'Array','10' => 'Array',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'taxonomy','4' => 'title','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'title','9' => 'taxonomy','10' => 'taxonomy',),'dbkey' => array('0' => 'daage','1' => 'key2','2' => 'key3','3' => 'key4','4' => 'key5','5' => 'key6','6' => 'key7','7' => 'key8','8' => 'key9','9' => 'key10','10' => 'key11',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '',),'taxonomy' => array('0' => 'category','1' => 'dathnicity','2' => 'dasexuality','3' => 'dagender','4' => 'category','5' => 'daeyes','6' => 'dahair','7' => 'dabody','8' => 'category','9' => 'dadrink','10' => 'dasmoke',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no',),);

update_option("cfields", $dafelds);	
	
	} break;
	case "auction": {

  $dafelds = array('name' => array('0' => 'Refunds','1' => 'Condition','2' => '7 Day Refunds','3' => 'Brand','4' => 'Brand','5' => 'Model Number','6' => 'Color','7' => 'Size',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'fieldtype' => array('0' => 'title','1' => 'taxonomy','2' => 'taxonomy','3' => 'title','4' => 'taxonomy','5' => 'input','6' => 'taxonomy','7' => 'taxonomy',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'key94643','3' => 'key46827','4' => 'key90394','5' => 'modelnum','6' => 'key5411','7' => 'key91614',),'values' => array('0' => '','1' => '','2' => 'Yes
No','3' => '','4' => '','5' => '','6' => '','7' => 'Yes
No',),'taxonomy' => array('0' => 'category','1' => 'condition','2' => 'refunds','3' => 'category','4' => 'brand','5' => 'category','6' => 'color','7' => 'size',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no',),);

update_option("cfields", $dafelds);	
	
	} break;
	case "directory": {
	
$dafelds = array('name' => array('0' => 'Phone Number','1' => 'Website',),'help' => array('0' => '','1' => '',),'fieldtype' => array('0' => 'input','1' => 'input',),'dbkey' => array('0' => 'phone','1' => 'website',),'values' => array('0' => '','1' => '',),'taxonomy' => array('0' => 'category','1' => 'category',),'required' => array('0' => 'no','1' => 'no',),);

update_option("cfields", $dafelds);	
	
	} break;
	case "classifieds": {
	
$dafelds = array('name' => array('0' => 'Refunds','1' => 'Condition','2' => '7 Day Refunds','3' => 'Brand','4' => 'Brand','5' => 'Model Number','6' => 'Color','7' => 'Size','8' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '',),'fieldtype' => array('0' => 'title','1' => 'taxonomy','2' => 'taxonomy','3' => 'title','4' => 'taxonomy','5' => 'input','6' => 'taxonomy','7' => 'taxonomy','8' => 'input',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'key94643','3' => 'key46827','4' => 'key90394','5' => 'modelnum','6' => 'key5411','7' => 'key91614','8' => 'examplefield',),'values' => array('0' => '','1' => '','2' => 'Yes
No','3' => '','4' => '','5' => '','6' => '','7' => 'Yes
No','8' => '',),'taxonomy' => array('0' => 'category','1' => 'condition','2' => 'refunds','3' => 'category','4' => 'brand','5' => 'category','6' => 'color','7' => 'size','8' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no',),'cat' => array('0' => 'Array',),);

update_option("cfields", $dafelds);

	} break;
	case "dealer": {
	
	   $dafelds = array('name' => array('0' => 'Make','1' => 'Model','2' => 'Year','3' => 'Condition','4' => 'Body','5' => 'Fuel','6' => 'Transmission','7' => 'Exterior','8' => 'Interior','9' => 'Doors','10' => 'Engine','11' => 'Seller','12' => 'Miles','13' => 'Drive','14' => 'Owners',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'taxonomy','2' => 'input','3' => 'taxonomy','4' => 'taxonomy','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'taxonomy','9' => 'taxonomy','10' => 'taxonomy','11' => 'taxonomy','12' => 'input','13' => 'taxonomy','14' => 'taxonomy',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'year','3' => 'key3','4' => 'key4','5' => 'key5','6' => 'key13','7' => 'key6','8' => 'key7','9' => 'key8','10' => 'key9','11' => 'key10','12' => 'miles','13' => 'key12','14' => 'key1214',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'taxonomy' => array('0' => 'make','1' => 'model','2' => 'category','3' => 'condition','4' => 'body','5' => 'fuel','6' => 'transmission','7' => 'exterior','8' => 'interior','9' => 'doors','10' => 'engine','11' => 'owners','12' => 'category','13' => 'drive','14' => 'owners',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),);
	   
update_option("cfields", $dafelds);
	
	
	} break;
	
	case "photography": {
	
$dafelds = array('name' => array('0' => 'Camera','1' => 'Camera Model','2' => 'Orientation','3' => 'License Type','4' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'input','2' => 'taxonomy','3' => 'taxonomy','4' => 'input',),'dbkey' => array('0' => 'cameratype','1' => ' camera_model','2' => 'key62809','3' => 'licensetype','4' => 'examplefield',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '',),'taxonomy' => array('0' => 'cameratype','1' => 'category','2' => 'orientation','3' => 'license','4' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no',),);
		
		update_option("cfields", $dafelds);
		
	} break;

}


 



	
	
 // WEBSITE TESTIMONIALS
$cfaq = array(

"name" => array(

0 => "John Doe",
1 => "Jane Doe",
2 => "Mark Brown", 
),

"name_title" => array(

0 => "CEO/ Manager",
1 => "General Manager",
3 => "Manager", 

),

"logo_url" => array(

0 => get_template_directory_uri()."/framework/img/user.png",
1 => get_template_directory_uri()."/framework/img/user.png",
2 => get_template_directory_uri()."/framework/img/user.png",
 
),

"date" => array(

0 => " " . date('Y-m-d H'),
1 => " " . date('Y-m-d H'),
2 => " " . date('Y-m-d H'),
 
),

"rating" => array(

0 => 5,
1 => 5,
 
),

"desc" => array(

0 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",

1 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",
 
2 => " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. \n\n\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",

),

);

update_option('ctestimonial', $cfaq);  
	
	
	
// INSTALL 5 SAMPLE BLOG POSTS

$titles = array(
"The 7 Secrets You Will Never Know About Business.",
"Seven Top Reasons Why You Face Obstacles In Learning Business.",
"Why Is Business So Famous?",
"This Story Behind Business Will Haunt You Forever!",
"Seven Places That You Can Find Business.",
"Think You're An Expert In Business? Take This Quiz Now To Find Out.",
"7 Ways To Tell You're Suffering From An Obession With Business.",
"5 Questions To Ask At Business.",
"The Story Of Business Has Just Gone Viral!",
"7 Tips To Avoid Failure In Business.",
"Seven Ways Business Can Improve Your Business.",
"Top Five Common Prejudices About Business.",
"Seven Unbelievable Facts About Business.",
"You Will Never Believe These Bizarre Truth Behind Business.",
"Seven Secrets About Business That Has Never Been Revealed For The Past 50 Years.",
"Here's What Industry Insiders Say About Business.",
"The Rank Of Business In Consumer's Market.",
"Ten Useful Tips From Experts In Business.",
"Understand Business Before You Regret.",
);



$catsid = array();
foreach(array("Consulting","Business","Corporate","Finance","Economy","WordPress") as $cat){

$wpdocs_cat = array('cat_name' => $cat, 
'category_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 
'category_nicename' => strtolower($cat), 'category_parent' => '');
$nid = wp_insert_category($wpdocs_cat);
$catsid[$nid] = $nid;
	
}	
 
$i=1;
while($i < 12){
 
	$my_post = array();
	$my_post['post_title'] 		= $titles[$i];
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
<p>Accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>";
	$my_post['post_type'] 		= "post";
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= "";
	$POSTID 					= wp_insert_post( $my_post );
 
 	add_post_meta($POSTID, "image", "https://www.premiumpress.com/_demoimages/blog/blog".$i.".jpg");
	
	 
	// UPDATE CAT LIST 
	if(isset($catsid) && is_array($catsid) ){
		
		$rndid = rand(0,5);
		if(isset($catsid[$rndid])){
		wp_set_post_categories( $POSTID, $catsid[$rndid] );
		}
	}
		
	
	$i++;	
} 	


// PACKAGES

$GLOBALS['theme_defaults']['pak0_price'] 	= "0";
$GLOBALS['theme_defaults']['pak1_price'] 	= "10";
$GLOBALS['theme_defaults']['pak2_price'] 	= "50";
 

$GLOBALS['theme_defaults']['lst']['websitepackages'] = 1;
 
 
// DESIGN
$GLOBALS['theme_defaults']['design'] = array('single-comments' => "1", 'single-map' => "1", 'single-offer' => "1");
 
// CURRENY PARTS
$GLOBALS['theme_defaults']['currency']['symbol'] 	= "$";
$GLOBALS['theme_defaults']['currency']['code'] 		= "USD";

// PAGE ASSIGN
$GLOBALS['theme_defaults']['pageassign']['homepage'] = ""; 
	
/***********************************************************************************/



$nameLink = array();
$taxdata = array();
$randomarray = array();

// EXTRA FOR TEMPLATES
switch($_POST['admin_values']['template']){
 
			case "learning": {
			
				$taxdata = array(	
								
						1 => array(						
							"name" => "listing",							
								"data" => array( 
								
								"Data Scienece",
								"Business",
								"Computer Science",
								"Personal Development",
								"Information Technology",
								"Language Learning",
								"Health",
								"Math and Logic",
								"Social Science",
								"Physucal Learning",
								"Arts and Crafts", 
								),
							),
							 
							2 => array(		
							"name" => "features",		
							"data" => array(
								"Gratitude",
								"Happiness",
								"Meditation",						 
								"Algorithms",
								"Grammar",
								"Speech",
								"Writing",
								 																
								),
							),
							
							3 => array(						
							"name" => "level",							
							"data" => array("All Levels", "Beginner","Intermediate","Advanced" ),
							),
							
							
							4 => array(						
							"name" => "language",							
							"data" => array("English", "Mandarin Chinese","Hindi","Spanish","French","Arabic","Russian","German","Bengali" ),
							), 

				);
						
			} break;
			case "auction": {
			
				$taxdata = array(	
								
						1 => array(						
							"name" => "listing",							
								"data" => array(
							
								"Appliances" => array ('General Appliances', 'Kitchen', 'Other'),
								"Business" => array ('Accounting','Aerospace and Defense','Agriculture and Forestry'),
								"Computers" => array ('Laptops','Desktops','Parts for sale'),
								"Games" => array ('xbox','Pc &amp; Mac','Playstation'),
								"Health" => array ('Skincare','Medicine','Pills and Potions'),
								"Home" => array ('Furniture','Decorations','Misc'),
								"Kids and Teens" => array ('Clothes','Shoes','Outdoors'),
								"Arts" => array ('Paints','Crft Items','Misc'),
								"Books" => array ('Kindle Books','Magazines','Textbooks'),
								"Sports" => array ('Outdoor','Indoor','Misc'),
								"Electronics" => array ('Dvd Players','TVs','Mics'),
								"Clothing" => array ('Clothing','Jewelry','Accessories'),
								"Freebies" => array ('Coupons','VIP Cards', 'Other'),
								"Video Games" => array ('Xbox','Nintendo','Other'),
								"Pets" => array ('Pets for Sale','Equipment &amp; Accessories','Other'),
								"Community" => array ('Artists &amp; Theatres','Fitness &amp; Health','Other'),
							
							),
							
						),
						
						2 => array(							
							"name" => "condition",							
							"data" => array("New","Used"),						
						),
						
						3 => array(		
							"name" => "size",		
							"data" => array("XL","L","M","2XL","S","3XL","XS","4XL"),	
						),	
						 	
						4 => array(		
							"name" => "color",		
							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),	
						),	
						
						5 => array(		
							"name" => "brand",		
							"data" => array("Sony","Sennheiser","Bose","Samsung"),	
						),
						
						6 => array(		
							"name" => "refunds",		
							"data" => array("Yes","No"),	
						),
						
						7 => array(		
							"name" => "features",		
							"data" => array(
								"Almost New",
								"Unwanted Gift",
								"Original Packaging",
								"Includes Reciept",
								"Like Brand New",
								"Latest Model",
								"Half Orginal Price",
								"Limited Edition",																	
							),
						),
						
				);
			
			} break;
			
			case "exchange": {
			
				$taxdata = array(					
						1 => array(						
							"name" => "listing",							
							"data" => array(
								"English", "Chinese (Mandarin)", "French","Spanish","Portuguese","German", "Japanese", "Korean", "Arabic", "Hindi", "Italian", "Russian"
							),
						),
				);
				
			} break;

			case "escort": {
			
				$taxdata = array(					
						1 => array(						
							"name" => "listing",							
							"data" => array("Non Asian Girls","Asian Girls","Sensual Massage","Blonde Escorts","Busty Escorts","Mature Escorts","Young Escorts","Cougar Escorts","MILF Escorts","Red hair Escorts","Black hair Escorts","Brunette Escorts","Slim EscortsTall Escorts","BBW Escorts","Curvy Escorts","Voluptuous Escorts","Petite Escorts","Touring Escorts","Tattooed Escorts","No Tattoo Escorts","Submissive Escorts","Shaved Escorts","Natural Bush Escorts","Non Smoking Escorts","Enhanced Breasts Escorts","Natural Breasts Escorts","Fitness Escorts","Massage / Erotic Relaxation Escorts","Photos Verified Escorts","Fly Me To You Escorts","Doubles Profiles"),
						),
						2 => array(							
							"name" => "dagender",							
							"data" => array("Male","Female","Couple","Trans Man","Trans Woman","Transsexual","Non-binary"),							
						), 
						
						3 => array(							
							"name" => "dasexuality",							
							"data" => array("Straight","Gay","Lesbian","Bisexual","Other"),						
						),
						
						4 => array(							
							"name" => "dathnicity",							
							"data" => array("African","American","Arab","Asian","Caucasian","Hispanic","Indian", "Mixed", "Native", "Other"),						
						),
						
						5 => array(							
							"name" => "daeyes",							
							"data" => array("Amber","Brown","Green","Blue","Gray","Hazel","Other"),						
						),
						
						6 => array(							
							"name" => "dahair",							
							"data" => array("Blond","Brown","Red","Black","Gray","Other"),						
						),
						
						7 => array(							
							"name" => "dabody",							
							"data" => array("Slim","Average","A little plump","Big and lovely","Other"),						
						),
						
						8 => array(							
							"name" => "dasmoke",							
							"data" => array("Never","Rarely","Quit","Socially","Often","Very often"),						
						),
						
						9 => array(							
							"name" => "dadrink",							
							"data" => array("Never","Rarely","Quit","Socially","Often","Very often"),						
						),
						10 => array(							
							"name" => "dastarsign",							
							"data" => array("Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces"),						
						), 
						
						11 => array(							
							"name" => "features",							
							"data" => array(
								"sensual massage only",
								"Affectionate cuddling",
								"Affectionate kissing",
								"Sexy lingerie",
								"Light bondage",
								"Dirty talk",
								"Costumes",
								"Strip tease",
								"body slide",
								"Blow job",
								"Balls licking",
								"Cum in mouth",
								"Cum on body",
								"Deep French kissing",
								"Double penetration",
								"Disabled clients",
								"Doggy style",
								"Girlfriend experience",
								"Happy ending",
								"Massage",
								"Overnight stays",
								"Passionate kissing"
							),						
						),
						
				);
				 	
			} break;
						
			
			case "dating": {
			
				$taxdata = array(					
						1 => array(						
							"name" => "listing",							
							"data" => array( ),
						),
						2 => array(							
							"name" => "dagender",							
							"data" => array("Male","Female","Couple","Trans Man","Trans Woman","Transsexual","Non-binary"),						
						), 
						
						3 => array(							
							"name" => "dasexuality",							
							"data" => array("Straight","Gay","Lesbian","Bisexual","Other"),						
						),
						
						4 => array(							
							"name" => "dathnicity",							
							"data" => array("African","American","Arab","Asian","Caucasian","Hispanic","Indian", "Mixed", "Native", "Other"),						
						),
						
						5 => array(							
							"name" => "daeyes",							
							"data" => array("Amber","Brown","Green","Blue","Gray","Hazel","Other"),						
						),
						
						6 => array(							
							"name" => "dahair",							
							"data" => array("Blond","Brown","Red","Black","Gray","Other"),						
						),
						
						7 => array(							
							"name" => "dabody",							
							"data" => array("Slim","Average","A little plump","Big and lovely","Other"),						
						),
						
						8 => array(							
							"name" => "dasmoke",							
							"data" => array("Never","Rarely","Quit","Socially","Often","Very often"),						
						),
						
						9 => array(							
							"name" => "dadrink",							
							"data" => array("Never","Rarely","Quit","Socially","Often","Very often"),						
						),
						10 => array(							
							"name" => "dastarsign",							
							"data" => array("Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces"),						
						), 
						
						11 => array(							
							"name" => "features",							
							"data" => array(
								"Writing/Blogging",
								"Cooking",
								"Refinishing Furniture",
								"Flea Market Shopping",
								"Catering",
								"Making Music",
								"Tapping Maple Trees",
								"Bartending",
								"Wine Making",
								"Playing The Stock Market",							
								"Beekeeping",							
								"Programming",
								"Proofreading And Editing",
								"Coding",
								"Tattooing",
								"Performing Stand Up Comedy",
								"Drive Others Around",
								"Graphic Design",
								"Making T-Shirts",
								"Becoming A Fitness Instructor",
								"Starting A YouTube Channel",
								"Being A Handyman",
								"Decorating Homes",
								"Reviewing Things",
								"Pet Sitting",
								"Flipping Items"
							),						
						),
						
				);
				 	
			} break;
			
			case "micro": {
			
				$taxdata = array(					
						1 => array(						
							"name" => "listing",							
							"data" => array(
								"Graphics &amp; Design","Marketing","Writing","Video","Music &amp; Audio","Programming","Business","Fun","Lifestyle","Outdoors","Fashion"
							),
						),
						2 => array(							
							"name" => "delivery",							
							"data" => array("Express 24H","Up to 3 days","Up to 5 days","Up to 10 days","Up to 1 month"),						
						),
						
						3 => array(
							
							"name" => "features",
							
							"data" => array("Hard Worker","Team Player","Creative","Organized","Flexibile","Emotional Intelligent","Punctual", "Reliable", "Caring","Good Listener"),
						
						),	
 
				);
				 	
			} break;
			
			
		case "directory": {				 
				$taxdata = array(
					
						1 => array(		
							"name" => "listing",		
							"data" => array(
														
							"Arts and Entertainment" => array (
  "Animation",
  "Architecture",
  "Art History",
  "Astrology and Horoscopes",
  "Body Modification",
  "Classical Studies",
  "Comics",
  "Crafts",
  "Dance",
  "Design",
  "Entertainment",
  "Fashion",
  "Graphic Design",
  "Humanities",
  "Humor",
  "Literature",
  "Movies",
  "Music",
  "Myths and Folktales",
  "Native and Tribal",
  "Online Writing",
  "Performing Arts",
  "Photography",
  "Radio",
  "Rhetoric",
  "Television",
  "Theatre",
  "Typography",
  "Video",
  "Visual Arts",
  "Writers Resources"),
  
  "Business" => array (
  "Agriculture",
  "Bookkeeping and Accounting",
  "Construction",
  "Consulting",
  "Cooperatives",
  "Customer Service",
  "Engineering",
  "Event Planning",
  "Freight Brokerage and Transportation",
  "Human Resources",
  "Industrial",
  "Information Services",
  "International Business and Trade",
  "Jobs and Employment",
  "Life Coaching",
  "Locksmiths",
  "Major Companies",
  "Management",
  "Manufacturing",
  "Messengers and Couriers",
  "Mining",
  "Offline Marketing and Advertising",
  "Opportunities",
  "Outsourcing",
  "Painting Services",
  "Personal and Virtual Assistants",
  "Point of Sale Hardware and Systems",
  "Private Investigation",
  "Publishing and Printing",
  "Security Services",
  "Small Business",
  "Telecommunications",
  "Transcription Services",
  "Translation Services",
  "Waste Management and Recycling",
  "Work At Home"),
  
  "Computers and Internet" => array (
  "Algorithms",
  "Artificial Intelligence",
  "Chats and Forums",
  "Computer Repair",
  "Computer Science",
  "Cyberculture",
  "Data Backup",
  "Data Recovery",
  "Desktop Publishing",
  "Desktop and Mobile Wallpapers",
  "Directories",
  "Domain Names",
  "E-Commerce",
  "Freelancers",
  "Hardware",
  "Internet",
  "Marketing and Advertising",
  "Mobile Computing",
  "Open Source",
  "Operating Systems",
  "Podcasts",
  "Portal",
  "Programming",
  "Robotics",
  "Search Engine Optimization",
  "Search Engines",
  "Security",
  "Social Networking",
  "Software",
  "Systems",
  "Technical Guides and Support",
  "Virtual Reality",
  "Web Design and Development",
  "Web Hosting",
  "Webmaster Resources"),
  
  "Games" => array (
  "Board Games",
  "Card Games",
  "Coin-Op",
  "Computer Games",
  "Dice",
  "Flash Game Arcades",
  "Hand Games",
  "Hand-Eye Coordination",
  "Miniatures",
  "Mobile Games",
  "Online",
  "Paper and Pencil",
  "Party Games",
  "Play-By-Mail",
  "Puzzles",
  "Roleplaying",
  "Tile Games",
  "Trading Card Games",
  "Video Games",
  "Yard, Deck, and Table Games"),
  
  "Health and Fitness" => array (
  "Aging",
  "Allergies",
  "Alternative",
  "Anaesthesiology",
  "Animal",
  "Ayurveda",
  "Beauty",
  "Cardiology",
  "Child Health",
  "Chiropractic",
  "Clinical Research",
  "Conditions and Diseases",
  "Cosmetic Surgery",
  "DNA Testing",
  "Dental",
  "Dermatology",
  "Diagnostic Imaging",
  "Disabilities",
  "First Aid",
  "Fitness",
  "Healthcare Industry",
  "Hearing and Audiology",
  "Home Health Care",
  "Homeopathy",
  "Hygiene",
  "Massage Therapy",
  "Medical Billing",
  "Medical Equipment",
  "Medical ID Bracelets",
  "Medicine",
  "Mental Health",
  "Nephrology",
  "Neurology",
  "Nursing",
  "Nutrition",
  "Obstetrics and Gynecology",
  "Oncology",
  "Ophthalmology and Optometry",
  "Orthopedics",
  "Otorhinolaryngology",
  "Pain Management",
  "Physical Therapy",
  "Physiotherapy",
  "Podiatry",
  "Rheumatology",
  "Senior Care",
  "Urology",
  "Weight Loss"),
  
  "Home" => array (
  "Apartment Living",
  "Appliance Repair",
  "Asbestos Removal",
  "Bathroom",
  "Carpeting and Flooring",
  "Chimney Cleaning",
  "Cleaning Services",
  "Cooking",
  "Do-It-Yourself",
  "Domestic Services",
  "Electricians",
  "Emergency Preparation",
  "Entertaining",
  "Family",
  "Fences",
  "Furniture",
  "Garage",
  "Heating and Cooling",
  "Home Automation",
  "Home Business",
  "Home Improvement",
  "Home Restoration and Repair",
  "Home and Office Safety",
  "Homemaking",
  "Homeowners",
  "Interior Design",
  "Kitchen",
  "Laundry and Dry Cleaning",
  "Lighting",
  "Packers and Movers",
  "Personal Finance",
  "Personal Organization",
  "Pest Control",
  "Pets",
  "Plumbing",
  "Roofs and Gutters",
  "Rural Living",
  "Security",
  "Seniors",
  "Storage",
  "Swimming Pools and Spas",
  "Urban Living",
  "Windows and Siding",
  "Yard and Garden"),
  
  "Kids and Teens" => array (
  "Arts",
  "Babies",
  "Childcare",
  "People and Society",
  "Pre-School",
  "School Time",
  "Sports and Hobbies",
  "Teen Life",
  "Your Family"),
  
  "News" => array (
  
  "Current Events",
  "Internet Broadcasts",
  "Journals",
  "Magazines and E-zines",
  "Newspapers",
  "Television",
  "Weather"),
  
  "Real Estate" => array (
  "Apartment Rentals",
  "Appraisers and Consultants",
  "Brokerages",
  "Commercial",
  "Coworking and Office Space",
  "Farm Land",
  "For Sale By Owner",
  "Home Inspection",
  "Plots and Land For Sale",
  "Property Management",
  "Realtors",
  "Residential Projects",
  "Timeshare"),
  
  "Reference and Education" => array (
  "Advice",
  "Almanacs",
  "Articles",
  "Bibliography",
  "Biography",
  "Blogs",
  "College and University",
  "Education and Training",
  "Educational Resources",
  "Encyclopedias",
  "Genealogy",
  "History",
  "Knowledge Management",
  "Libraries",
  "Living History",
  "Maps",
  "Museums",
  "Resources",
  "Thesauri",
  "World Records"),
  
  "Regional" => array (
  "Africa",
  "Argentina",
  "Armenia",
  "Asia",
  "Australia",
  "Austria",
  "Brazil",
  "Canada",
  "Caribbean",
  "Central America",
  "Croatia",
  "Czech Republic",
  "Denmark",
  "Europe",
  "Finland",
  "Germany",
  "Greece",
  "Hong Kong",
  "India",
  "Indonesia",
  "Ireland",
  "Israel",
  "Italy",
  "Japan",
  "Lithuania",
  "Middle East",
  "Netherlands",
  "New Zealand",
  "North America",
  "Norway",
  "Oceania",
  "Philippines",
  "Polar Regions",
  "Puerto Rico",
  "Russia",
  "Slovakia",
  "South America",
  "Sweden",
  "Taiwan",
  "United Kingdom",
  "United States",
  "Zimbabwe"),
  
  "Science" => array (
  "Aerospace and Aeronautics",
  "Astronomy",
  "Biology",
  "Chemistry",
  "Conferences",
  "Earth Sciences",
  "Environment and Nature",
  "Geology and Geophysics",
  "Institutions",
  "Instruments and Supplies",
  "Mathematics",
  "Methods and Techniques",
  "Museums",
  "Nanotechnology",
  "News and Media",
  "Physics",
  "Publications",
  "Reference",
  "Renewable Energy",
  "Science in Society",
  "Technology",
  "Wildlife"),
  
  "Shopping" => array (
  "Antiques",
  "Appliances",
  "Art Supplies",
  "Auctions",
  "Autos",
  "Beauty Products",
  "Books",
  "Classifieds",
  "Clothing and Shoes",
  "Coupons and Deals",
  "Electronics",
  "Flowers",
  "Food and Beverage",
  "Gifts",
  "Glassware",
  "Greeting Cards",
  "Jewelry",
  "Mobile Phones",
  "Motorcycles",
  "Office Products",
  "Sporting Goods",
  "Tickets",
  "Tools and Hardware",
  "Toys",
  "Wholesale"),
  
  "Society" => array (
  "Activism",
  "Crime",
  "Death",
  "Disabled",
  "Economics",
  "Ethnicity",
  "Folklore",
  "Future",
  "Holidays",
  "Issues",
  "Language and Linguistics",
  "Law",
  "Lifestyle Choices",
  "Men",
  "Military",
  "Organizations",
  "Paranormal",
  "People",
  "Philanthropy",
  "Philosophy",
  "Roads and Highways",
  "Social Sciences",
  "Sociology",
  "Subcultures",
  "Support Groups",
  "Trains and Railroads",
  "Urban Legends",
  "Weddings",
  "Women"),
  
  "Sports and Recreation" => array (
  "Archery",
  "Audio and Radio",
  "Aviation",
  "Badminton",
  "Baseball",
  "Basketball",
  "Billiards",
  "Birding",
  "Boating",
  "Bowling",
  "Boxing and MMA",
  "Camps",
  "Climbing",
  "Coaching",
  "Collecting",
  "Crafts",
  "Cricket",
  "Cycling",
  "Disabled",
  "Events",
  "Extreme Sports",
  "Fantasy",
  "Fishing",
  "Football",
  "Geocaching",
  "Golf",
  "Hang Gliding",
  "Hockey",
  "Horseracing",
  "Kites",
  "Knives",
  "Lacrosse",
  "Martial Arts",
  "Models",
  "Motorsports",
  "Organizations",
  "Outdoors",
  "Paintball",
  "Parties",
  "People",
  "Rugby",
  "Running",
  "Scouting",
  "Scuba Diving",
  "Skateboarding",
  "Skating",
  "Soccer",
  "Surfing",
  "Swimming",
  "Table Tennis",
  "Team Spirit",
  "Tennis",
  "Theme Parks",
  "Track and Field",
  "Volleyball",
  "Weight Lifting",
  "Winter Sports",
  "Wrestling"
  ),
  
  "Travel" => array (
  "Aircraft Charter",
  "Cruises",
  "Hotels and Accomodation",
  "Limousines",
  "Luggage",
  "Taxis and Chauffeurs",
  "Tours",
  "Travel Agents",
  "Vacation Packages",
  "Vehicle Rental"
  ),
  ),
 
						),	
						 
						2 => array(		
							"name" => "features",		
							"data" => array(
								"Modern Fittings",
								"Air Conditioning",
								"Washer/Dryer Hookups",
								"Furniture",
								"Patio/Balcony",
								"Hardwood Floors",
								"Dishwasher",
								"Stunning Views",
								"Walk-in Closets",
								"Wireless Internet",
								"Pet Friendly",
								"Fitness Center/Gym",
								"Swimming Pool",
								"Car Park",
								"Nearby Shops &amp; Restaurants",
								"Bike Storage",
								"Large Public Spaces",
								"Meeting Rooms",
								"24/7 Building Security Staff", 
								"Nearby Public Transport",
								"Good Mobile Coverage",										
							),
						),
						
					);	
					
								
			} break;
			
			
			case "cardealer": {
					$taxdata = array(
					
						1 => array(
							
							"name" => "make",
							
							"data" => array("Acura","Alfa Romeo", "Austin Martin","Audi","Austin","Bentley","BMW","Bugatti","Buick","Cadillac","Chevrolet","Chrysler",
							"Citroen","Daewoo","Dodge","Ferrari","Fiat","Ford","GMC","Honda","Hummer","Hyundai","Infiniti","Isuzu","Jaguar","Jeep","Kia", "Lamborghini",
							"Lancia","Land Rover","Lexus", "Lincoln","Lotus", "Maserati","Maybach","Mazda","Mercedes","MG","Mini","Mitsubishi","Morgan", "Nissan","Oldsmobile", 
							"Peugeot", "Pontiac","Porsche","Proton","Reliant","Renault","Riley","Rolls-Royce","Rover","Saab","Seat","Skoda","Smart","Ssangyong","Subaru","Suzuki",
							"Talbot","Tata","Toyota","Trabant","Triumph","TVR","Vauxhall","Volkswagen","Volvo","Denza","extra2"),
						
						),						
						
						2 => array(
							
							"name" => "model",
							"data" => array(
					
									"Acura" => array("MDX","NSX","RL","RSX","TL","TSX"),
									"Alfa Romeo" => array("145","146","147","155","156","159","1600","164","166","2000","2300","2600","33","75","8C","90","Alfasud","Alfetta","Brera","Crosswagon","Giulia","Giulietta","GT","GTA","GTV","MiTo","RZ/SZ","Spider","Sprint"),
									"Alpina" => array("B10","B12","B3","B5","B6","B7","B8","D10","D3","Roadster S"),
									
									"Aston Martin" => array("AR1","DB","DB7","DB9","DBS","Lagonda","Rapide","V12 Vanquish","V8","V8 Vantage","Vanquish","Virage","Volante"),
									"Audi" => array("100","200","80","90","A1","A2","A3","A4","A5","A6","A7","A8","Allroad","Cabriolet","Coupe","Q3","Q5","Q7","Quattro","R8","RS2","RS4","RS5","RS6","S2","S3","S4","S5","S6","S8","TT","V8"),
									"Austin" => array("1100","1500","2000","Allegro","Ambassador","Maxi","Maxi 2","Princess"),
									"Bentley" => array("Arnage","Azure","Brooklands","Continental","Eight","Mulsanne","Turbo R","Turbo RT","Turbo S"),
									"BMW" => array("1 Series","1500","1600","1800","2000","2600","3 Series","5 Series","6 Series","7 Series","8 Series","M Series","M1","X1","X3","X5","X6","Z1","Z3","Z4","Z8"),
									"Buick" => array("Century","Electra","LeSabre","Park Avenue","Regal","Riviera","Roadmaster","Sabre","Skylark"),
									
									"Citroen" => array("2 CV","2000","2400","AX","Berlingo","BX","C-Crosser","C-Zero","C1","C2","C3","C3 Picasso","C4","C4 Picasso","C5","C6","C8","CX","Dispatch","DS","DS3","Dyane","Evasion","GS","GSA","Jumpy","LNA","Nemo Multispace","Saxo","SM","SM Maserati","Synergie","Visa","Xantia","XM","Xsara","Xsara Picasso","ZX"),
									
									"Mercedes" => array("123","180","190","190-Series","200","212","220","230","240","250","260","270","280","280C","290","300","320","350","380","400","416","420","450","500","560","600 Series","A-Class","B-Class","C-Class","Cabriolet","CE 200","CE 220","CE 300","CL-Class","CLC-Class","CLK-Class","E-Class","G-Wagen","GL-Class","ML-Class","R-Class","S-Class","SL-Class","SLK-Class","SLR","Sprinter","V-Class","Vaneo","Vario","Viano","Vito"),
									
									
									),
						
						),
						
						3 => array(
							
							"name" => "condition",
							
							"data" => array("New","Used","Certified"),
						
						),
						
						4 => array(
							
							"name" => "body",
							
							"data" => array("Convertible", "Coupe","Hatchback", "Sedan", "SUV / Crossover", "Truck", "Van / Minivan", "Wagon"),
						
						),
						
						5 => array(
							
							"name" => "fuel",
							
							"data" => array("Petrol", "Diesel", "Electric", "Gasoline", "Hybrid", "Plug-in Hybrid"),
						
						),	
						
						6 => array(
							
							"name" => "transmission",
							
							"data" => array("Automatic", "Manual"),
						
						),	
						
						7 => array(
							
							"name" => "exterior",
							


							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),
						
						),
						
						8 => array(
							
							"name" => "interior",
							
							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),
						
						),
							
						9 => array(
							
							"name" => "doors",
							
							"data" => array("Two Door", "Three Door", "Four Door", "Five Door"),
						
						), 
						
							
						10 => array(
							
							"name" => "seller",
							
							"data" => array("Dealer", "Private Seller"),
						
						), 	
						
						11 => array(
							
							"name" => "features",
							
							"data" => array("Android Auto","Apple CarPlay","Bluetooth, Hands-Free","Cruise Control","DVD Player","Navigation","Portable Audio Connection","Premium Audio","Satellite Radio","Steering Wheel Controls"),
						
						),	
						
						12 => array(
							
							"name" => "engine",
							
							"data" => array("1L","1.6L","3L","3.2L","6L","1.2L","2L"),
						
						),	
						
						13 => array(
							
							"name" => "drive",
							
							"data" => array("Left Hand Drive", "Right Hand Drive"),
						
						),	
						
						14 => array(
							
							"name" => "owners",
							
							"data" => array("0 Owners", "1 Owner","2 Owners","3 Owners","4 Owners","5 Owners","6+ Owners"),
						
						),	
							
					
					);	
			} break;	
			case "classifieds": {
					$taxdata = array(				
						
					 
						
						1 => array(							
							"name" => "condition",							
							"data" => array("New","Used","Certified"),						
						),
						2 => array(							
							"name" => "listing",							
							"data" => array(
							
								"Appliances" => array ('General Appliances', 'Kitchen', 'Other'),
								"Business" => array ('Accounting','Aerospace and Defense','Agriculture and Forestry'),
								"Computers" => array ('Laptops','Desktops','Parts for sale'),
								"Games" => array ('xbox','Pc &amp; Mac','Playstation'),
								"Health" => array ('Skincare','Medicine','Pills and Potions'),
								"Home" => array ('Furniture','Decorations','Misc'),
								"Kids and Teens" => array ('Clothes','Shoes','Outdoors'),
								"Arts" => array ('Paints','Crft Items','Misc'),
								"Books" => array ('Kindle Books','Magazines','Textbooks'),
								"Sports" => array ('Outdoor','Indoor','Misc'),
								"Electronics" => array ('Dvd Players','TVs','Mics'),
								"Clothing" => array ('Clothing','Jewelry','Accessories'),
								"Pets" => array ('Pets for Sale','Equipment &amp; Accessories','Other'),
								"Freebies" => array ('Coupons','VIP Cards', 'Other'),
								"Video Games" => array ('Xbox','Nintendo','Other'),
								"Community" => array ('Artists &amp; Theatres','Fitness &amp; Health','Other'),
							
							),						
						),
						3 => array(		
							"name" => "size",		
							"data" => array("XL","L","M","2XL","S","3XL","XS","4XL"),	
						),	
						 	
						4 => array(		
							"name" => "color",		
							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),	
						),	
						
						5 => array(		
							"name" => "brand",		
							"data" => array("Sony","Sennheiser","Bose","Samsung"),	
						),
						
						6 => array(		
							"name" => "refunds",		
							"data" => array("Yes","No"),	
						),
						
						7 => array(		
							"name" => "features",		
							"data" => array(
								"Almost New",
								"Unwanted Gift",
								"Original Packaging",
								"Includes Reciept",
								"Like Brand New",
								"Latest Model",
								"Half Orginal Price",
								"Limited Edition",																	
							),
						), 

					
					);
				 	
			} break;
			
			 
						
			case "dating": {
				 	
			} break;
			
			
			case "project": {
			 
			
				$taxdata = array(
						
						1 => array(		
							"name" => "listing",	
								
							"data" => array(
								"Accounting & Consulting",
								"Admin Support",
								"Customer Service",
								"Data Science & Analytics",
								"Design & Creative",
								"Engineering & Architecture",
								"IT & Networking",
								"Legal",
								"Sales & Marketing",
								"Translation",
								"Web, Mobile & Software Dev",
								"Writing"
							),	
						),	 
						
						2 => array(		
							"name" => "experience",		
							"data" => array( "No Experience Required", "High school diploma or equivalent", "Some college, no degree",  "Postsecondary non-degree award", "Associate's degree", "Bachelor's degree", "Master's degree","Doctoral or professional degree" ),	
						),
						 
				);	
				 		
			} break;
			
			case "jobs": {
				$taxdata = array(
					
						1 => array(		
							"name" => "jobtype",		
							"data" => array("Part-time", "Contract" , "Internship", "Temporary", "Full-time"),	
						),	
						
						2 => array(		
							"name" => "listing",		
							"data" => array("Accounting" ,"General Business","Admin & Clerical"	 ,"General Labor"	 ,"Pharmaceutical","Automotive"	 ,"Government","Banking"	 ,"Grocery"	 ,"Purchasing" ,"Procurement"
,"Biotech"	 ,"Health Care"	 ,"QA" ,"Quality Control","Broadcast" ,"Journalism"	 ,"Hotel" ,"Hospitality"	 ,"Real Estate"	 ,"Human Resources"	 ,"Research","Construction"	   ,"Restaurant" ,"Food Service","Consultant","Customer Service"	 ,"Insurance"	 ,"Sales","Design","Inventory","Science","Distribution" ,"Shipping"	,"Legal","Skilled Labor" ,"Trades","Education" ,"Teachin"	 ,"Legal Admin"	 ,"Strategy" ,"Planning","Engineering"	 ,"Management"	 ,"Supply Chain","Entry Level" ,"New Grad"	 ,"Manufacturing","Executive"	 ,"Marketing"	 ,"Training","Facilities"	 ,"Media" ,"Journalism" ,"Newspaper","Transportation","Finance"	 ,"Nonprofit" ,"Social Services","Warehouse"),	
						),	 
						
						3 => array(		
							"name" => "experience",		
							"data" => array( "No Experience Required", "High school diploma or equivalent", "Some college, no degree",  "Postsecondary non-degree award", "Associate's degree", "Bachelor's degree", "Master's degree","Doctoral or professional degree" ),	
						),
						
						3 => array(		
							"name" => "postedby",		
							"data" => array( "Agency", "Employer", "REED"),	
						),
						
						4 => array(		
							"name" => "company",		
							"data" => array("Starbucks","Skype","Pepsi","7eleven","Google","KFC","Burger King","apple"),	
						), 
				);	
				 		
			} break;			
			case "coupon": {
			 
			
			$taxdata = array(
					
						1 => array(		
							"name" => "listing",		
							"data" => array("Cash Back","COVID-19","Clothing","Food","Electronics","Beauty","Traveln"),	
						),	 
						
						2 => array(		
							"name" => "ctype",		
							"data" => array("Coupon","Offer","Printable Coupon"),	
						),		
						  
						3 => array(		
							"name" => "store",		
							"data" => array(
								"Store Name 1",
								"Store Name 2",
								"Store Name 3",	
								"Store Name 4",	
								"Store Name 5",
								"Store Name 6",	
								"Store Name 7",	
								"Store Name 8",		
								"Store Name 9",				
							),
						), 
					);
		 
			} break;
			case "photography": {
			
			
			$taxdata = array(
					
						1 => array(		
							"name" => "listing",		
							"data" => array("ABSTRACT","ANIMALS","ARCHITECTURE","BUSINESS","CELEBRATIONS","CITY","ELECTRONICS","HEALTH &amp; BEAUTY","AROUND THE HOUSE","LANDSCAPES","LIFESTYLE","MUSIC","NATURE","PEOPLE","SCIENCE","TRAVEL"),	
						),	 
						
						2 => array(		
							"name" => "orientation",		
							"data" => array("Landscape","Portrait"),	
						),		
						
						3 => array(							
							"name" => "features",							
							"data" => array("Canon Camera","Colorful","Landscape","Difficult Shot","Commercial Use","Fun Photo"),						
						),
						
						4 => array(							
							"name" => "license",							
							"data" => array("Commercial Usage","Creative Commons","Non-exclusive"),						
						),
						
						5 => array(							
							"name" => "cameratype",							
							"data" => array("Canon", "Nikon", "Pentax", "Sony", "Olympus", "Fujifilm", "GoPro", "Leica"),						
						),
						
						
					 
					);
			
				 
			} break;
			case "software":{
			
			$taxdata = array(
			
			
				1 => array(		
					"name" => "listing",		
					"data" => array(
							
								"Audio" => array("Audio Encoders/Decoders","Audio File Players","Audio File Recorders","CD Burners","CD Players","Multimedia Creation Tools","Music Composers","Rippers &amp; Converters","Other"),
								"Business" => array("Accounting &amp; Finance","Calculators &amp; Converters","Databases &amp; Tools","Helpdesk &amp; Remote PC","Inventory &amp; Barcoding","Investment Tools","Math &amp; Scientific Tools","Office Suites &amp; Tools","Other"),
								"Coms" => array("Chat &amp; Instant Messaging","E-Mail Clients","E-Mail List Management","Newsgroup Clients","Web/Video Cams","Pager Tools","Telephony","Other Comms Tools"),
								"Desktop" => array("Clocks &amp; Alarms","Cursors &amp; Fonts","Icons","Screen Savers","Themes &amp; Wallpaper","Other"),
								"Development" => array("Active X","Basic, VB, VB DotNet","C / C++ / C#","Compilers &amp; Interpreters","Components &amp; Libraries","Debugging","Delphi","Help Tools","Install &amp; Setup"),
								"Education" => array("Computer","Dictionaries","Geography","Kids","Languages","Mathematics","Reference Tools","Teaching &amp; Training Tools","Other"),
								"Games" => array("Action","Adventure &amp; Roleplay","Arcade","Board","Card","Casino &amp; Gambling","Kids","Online Gaming","Strategy &amp; War Games","Other"),
								"Graphic Apps" => array("Animation Tools","CAD","Converters &amp; Optimizers","Editors","Font Tools","Gallery &amp; Cataloging Tools","Icon Tools","Screen Capture","Other"),
								"Home &amp; Hobby" => array("Astrology/Biorhythms/Mystic","Astronomy","Cataloging","Food &amp; Drink","Genealogy","Health &amp; Nutrition","Personal Finance","Personal Interes","Other"),
								"Network" => array("Ad Blockers","Browser Tools","Browsers","Download Managers","File Sharing/Peer to Peer","FTP Clients","Network Monitoring","Remote Computing","Other"),
								"Security" => array("Access Control","Anti-Spam &amp; Anti-Spy Tools","Anti-Virus Tools","Covert Surveillance","Encryption Tools","Password Managers","Other"),
								"Servers" => array("Firewall &amp; Proxy Servers","FTP Servers","Mail Servers","News Servers","Telnet Servers","Web Servers","Other Server Applications"),
								"Utilities" => array("Automation Tools","Backup &amp; Restore","Benchmarking","Clipboard Tools","File &amp; Disk Management","File Compression","Launchers &amp; Task Managers","Printer","Other"),
								"Web Development" => array("ASP &amp; PHP","E-Commerce","Flash Tools","HTML Tools","Java &amp; JavaScript","Log Analysers","Site Administration","Wizards &amp; Components","XML/CSS Tools","Other"),
								"Other" => array(),
						),
					),
					
					2 => array(		
							"name" => "features",		
							"data" => array(
								"Easy to Install",
								"No Skills Required",
								"Original Packaging",
								"Download Version Included",
								"IOS App Included",
								"Lots of Hidden Features",
								"Half Orginal Price",
								"Limited Edition",																	
							),
						), 
						
						3 => array(		
							"name" => "system",		
							"data" => array(
								"Windows",
								"Apple MAC",
								"Mobile Device", 																
							),
						), 

			 
			);
			
 		
			} break;
			case "realestate": {				 
				$taxdata = array(
					
						1 => array(		
							"name" => "beds",		
							"data" => array("1 Bedroom","2 Bedrooms","3 Bedrooms","4 Bedrooms","5+ Bedrooms"),	
						),	 	
						2 => array(		
							"name" => "baths",		
							"data" => array("1 Bathroom","2 Bathrooms","3 Bathrooms","4 Bathrooms","5+ Bathrooms"),	
						),	
						
						3 => array(		
							"name" => "listing",		
							"data" => array("Detached","Semi-Detached","Terraced","Bungalow","Land","Apartment","Office"),	
						),	
						
						4 => array(		
							"name" => "type",		
							"data" => array("For Sale","For Rent"),	
						),	
						
						5 => array(		
							"name" => "features",		
							"data" => array(
								"Modern Fittings",
								"Air Conditioning",
								"Washer/Dryer Hookups",
								"Furniture",
								"Patio/Balcony",
								"Hardwood Floors",
								"Dishwasher",
								"Stunning Views",
								"Walk-in Closets",
								"Wireless Internet",
								"Pet Friendly",
								"Fitness Center/Gym",
								"Swimming Pool",
								"Car Park",
								"Nearby Shops &amp; Restaurants",
								"Bike Storage",
								"Large Public Spaces",
								"Meeting Rooms",
								"24/7 Building Security Staff", 
								"Nearby Public Transport",
								"Good Mobile Coverage",										
							),
						),
					);		
								
			} break;
			
			case "compare": {
			
			$taxdata = array(
					
						1 => array(		
							"name" => "size",		
							"data" => array("XL","L","M","2XL","S","3XL","XS","4XL"),	
						),	 	
						2 => array(		
							"name" => "color",		
							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),	
						),	
						
						3 => array(		
							"name" => "listing",		
							"data" => array(
							
								"Sports" => array ('Tennis', 'Football', 'Swimming', 'Climbing'),
								"Electronic" => array ('Television', 'Air Conditional', 'ARM', 'Theater'),
								"Digital" => array ('Mobile', 'Camera', 'Laptop', 'Notebook'),
								"Furniture" => array ('Television', 'Air Conditional', 'Theater', 'Accessories'),
								"Jewelry" => array ('Mobile', 'Camera', 'Laptop', 'Notebook'), 
								"Fashion" => array ('Women', 'Men', 'Kids', 'Accessories'),
								"Books" => array ('Romance', 'Crime Fiction', 'Fiction', 'Erotica'),
								"Music" => array ('Pop', 'Dance', 'Electronic', 'Rock'),
								"Gaming" => array ('xBox', 'Playstation', 'PC Games', 'Accessories'),
								
								"Outdoors" => array ('Fitness', 'Crime Fiction', 'Camping & Hiking', 'Cycling'),
								"Movies &amp; TV," => array ('DVD & Blu-ray CDs ', 'Vinyl', ' Digital Music'),
								"Watches" => array ('Women', 'Men'),
							),	
						),	
						
						4 => array(		
							"name" => "features",		
							"data" => array(
								"24MP APS-C CMOS sensor", 
								"45-point AF system", 
								"3' 1.04M-dot articulating touchscreen",
								"1080/60p video capture",
								"7 fps continuous shooting with AF",
								"Weather-resistant body",
								"7560-pixel RGB+IR Metering Sensor",
								"Wi-Fi + NFC",									
							),
						),	
						
						5 => array(		
							"name" => "store",		
							"data" => array(
								"Store Name 1",
								"Store Name 2",
								"Store Name 3",	
								"Store Name 4",	
								"Store Name 5",	
								"Store Name 6",					
							),
						), 
					);
						
			} break;
			case "shop": {				 
					$taxdata = array(
					
						1 => array(		
							"name" => "size",		
							"data" => array("XL","L","M","2XL","S","3XL","XS","4XL"),	
						),	 	
						2 => array(		
							"name" => "color",		
							"data" => array("Beige","Black","Blue","Brown","Burgundy","Charcoal","Gold","Gray","Green","Off White","Orange","Pink","Purple","Red","Silver"),	
						),	
						
						3 => array(		
							"name" => "listing",		
							"data" => array(
							
								"Sports" => array ('Tennis', 'Football', 'Swimming', 'Climbing'),
								"Electronic" => array ('Television', 'Air Conditional', 'ARM', 'Theater'),
								"Digital" => array ('Mobile', 'Camera', 'Laptop', 'Notebook'),
								"Furniture" => array ('Television', 'Air Conditional', 'Theater', 'Accessories'),
								"Jewelry" => array ('Mobile', 'Camera', 'Laptop', 'Notebook'), 
								"Fashion" => array ('Women', 'Men', 'Kids', 'Accessories'),
								"Books" => array ('Romance', 'Crime Fiction', 'Fiction', 'Erotica'),
								"Music" => array ('Pop', 'Dance', 'Electronic', 'Rock'),
								"Gaming" => array ('xBox', 'Playstation', 'PC Games', 'Accessories'),
								
								"Outdoors" => array ('Fitness', 'Crime Fiction', 'Camping & Hiking', 'Cycling'),
								"Movies &amp; TV," => array ('DVD & Blu-ray CDs ', 'Vinyl', ' Digital Music'),
								"Watches" => array ('Women', 'Men'),
							),	
						),		
					
					);					
			} break;
			case "video": {
			
				$taxdata = array(					
						1 => array(						
							"name" => "listing",							
							"data" => array(
							"Action & Adventure","Animation","Beauty & Fashion","Classic TV","Comedy","Documentary","Drama","Entertainment","Family","Food","Gaming","Health & Fitness","Home & Garden","Learning & Education","Music","Nature","News","Reality & Game Shows","Science & Tech","Science Fiction","Soaps","Sports","Travel"
							),
						),
						
						2 => array(						
							"name" => "level",							
							"data" => array("All Levels", "Beginner","Intermediate","Advanced" ),
						),
						 
						 
				);
			
			} break;
}


		$cat_icons_small = array(
		
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-coffee',
						'fa-university',
						'fa-archive',
						'fa-laptop',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
		
		);	

$ti = 0; 
foreach($taxdata as $t){

	
	//1 . register
	register_taxonomy( $t['name'], THEME_TAXONOMY.'_type', array( 'hierarchical' => true, 'labels' => array('name' => $t['name']) , 'query_var' => true, 'rewrite' => true, 'rewrite' => array('slug' => $t['name']) ) );  
		

		//2. build categories
		foreach( $t['data'] as $topcat => $cat){
		
		$desc = "";
		
		if($t['name'] == "listing"){
			
			$desc = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.";
		
		}
		 
		
		if(is_array($cat)){
		
		
			if ( term_exists( $topcat, $t['name'] ) ){
				$term = get_term_by('slug', $topcat, $t['name']);		 
				$nparent  = $term->term_id;				
			}else{
			
				$topcat_id = wp_insert_term($topcat, $t['name'], array('cat_name' => $topcat, 'description' => $desc ));
				if(!is_object($topcat_id) && isset($topcat_id['term_id'])){				 
					$nparent = $topcat_id['term_id'];				
				}else{			 
					$nparent = $topcat_id->term_id;
				}	 
				 
			}
			
			// STORE NAME
			$nameLink[$t['name']."-".strtolower(str_replace(" ","",$topcat))] = $nparent; 			
			$randomarray[$t['name']][$nparent] = $nparent;
			 
			 	
			// INNER DATA
			foreach($cat as $incat){
				
				if ( term_exists( $incat, $t['name'], $nparent ) ){					
						$term = get_term_by('slug', $incat, $t['name']);		 
						$sparent  = $term->term_id;						
				}else{
					
						$cat_id = wp_insert_term($incat, $t['name'], array('parent' => $nparent, 'description' => $desc ));
						if(!is_object($cat_id) && isset($cat_id['term_id'])){
							$sparent = $cat_id['term_id'];
						}elseif(isset($cat_id->term_id)){									 
							$sparent = $cat_id->term_id;
						}
				}					
				// STORE NAME
				$nameLink[$t['name']."-".strtolower(str_replace(" ","",$incat))] = $sparent;
				$randomarray[$t['name']][$sparent] = $sparent;
		}
		
		//die(print_r($nameLink));
		
		}else{
		
			if ( term_exists( $cat, $t['name'] ) ){	
		
				$term = get_term_by('slug', $cat, $t['name']);		 
				$nparent  = $term->term_id;
				
			}else{
			
				$cat_id = wp_insert_term($cat, $t['name'], array('cat_name' => $cat, 'description' => $desc ));
				if(!is_object($cat_id) && isset($cat_id['term_id'])){				 
					$nparent = $cat_id['term_id'];				
				}else{			 
					$nparent = $cat_id->term_id;
				}			 
			 
			}
			
			// STORE NAME
			$nameLink[$t['name']."-".strtolower(str_replace(" ","",$cat))] = $nparent;
			$randomarray[$t['name']][$nparent] = $nparent;
			
			if(isset($cat_icons_small[$ti])){
			$GLOBALS['theme_defaults']['category_icon_small_'.$nparent] = $cat_icons_small[$ti];
			}
			
			$ti++;
			 
			
			
		}// END OUTTER ARAY
			
	
	
	}

}	
 
$locations = array(

	1 => array("US", "New York", "Manhattan", "240 Broadway, New York, NY 10007, USA", "-74.0059728","40.7127753","10007"),
	2 => array("US", "New York", "Manhattan", "Pearl Street & Robert F Wagner Place, New York, NY 10038, USA", "-74.00099462006835","40.710433145221195", "10038"),
	3 => array("US", "New York", "Manhattan", "Madison St/Catherine St, New York, NY 10038, USA", "-73.99751847718505","40.71202712062323","100038"),
	4 => array("US", "New York", "Manhattan", "429 Broome St, New York, NY 10013, USA", "-73.99932092164306","40.72123239521979","10013"),
	5 => array("US", "New York", "Manhattan", "66 1st Avenue, New York, NY 10009, USA", "-73.98627465699462","40.72539549359491","10009"),
	6 => array("US", "New York", "Manhattan", "68 W 10th St, New York, NY 10011, USA", "-73.9984626147583","40.73437128836366","10011"),
	7 => array("US", "New York", "Manhattan", "108 E 16th St, New York, NY 10003, USA", "-73.98884957764892","40.735541954942086","10003"),
	8 => array("US", "New York", "Manhattan", "42 W 44th St, New York, NY 10036, USA", "-73.98215478394775","40.755570168893485","10036"),
	9 => array("US", "New York", "Manhattan", "230 E 63rd St, New York, NY 10065, USA", "-73.96344369385986","40.76324171770885","10065"),
	10 => array("US", "New York", "Queens", "8 49th Ave, Queens, NY 11101, USA", "-73.94765084718017","40.74217534312245","11101"),
	11 => array("US", "New York", "Queens", "25-3 Borden Ave, Long Island City, NY 11101, USA", "-73.94473260377197","40.73967164196744","11101"),
	12 => array("US", "New York", "Queens", "48-1 36th St, Long Island City, NY 11101, USA", "-73.92962640260009","40.74032196301581","11101"),
	13 => array("US", "New York", "Queens", "30-09 41st St, Astoria, NY 11103, USA", "-73.91434854005126","40.763209213014065","11103"),
	14 => array("US", "New York", "Queens", "30-48 72nd St, Queens, NY 11370, USA", "-73.89546578858642","40.75878842640948","11370"),
	15 => array("US", "New York", "Queens", "63-39 83rd Pl, Flushing, NY 11379, USA", "-73.87108987305908","40.72211057045409","11374"),
	16 => array("US", "New York", "Queens", "79-42 67th Rd, Flushing, NY 11379, USA", "-73.87186234925537","40.71235241703782","11379"),
	17 => array("US", "New York", "Queens", "107-47 104th St, Jamaica, NY 11417, USA", "-73.8354701373413","40.67929418003906","11417"),
	18 => array("US", "New York", "Queens", "87-27 133rd St, Jamaica, NY 11418, USA", "-73.81881898377685","40.70155172662101","11418"),
	19 => array("US", "New York", "Queens", "143-57 229th St, Jamaica, NY 11413, USA", "-73.74878114197998","40.66406104898427","11413"),
	20 => array("US", "New York", "Queens", "4 Central Terminal Area, Jamaica, NY 11430, USA", "-73.78963654969482","40.64153046978498","11430"),

); 


$locations_dt = array(

	1 => array("US", "New York", "Manhattan", "240 Broadway, New York, NY 10007, USA", "-74.0059728","40.7127753","10007"),
	2 => array("GB", "London", "Manhattan", "Pearl Street & Robert F Wagner Place, New York, NY 10038, USA", "-74.00099462006835","40.710433145221195", "10038"),
	3 => array("GB", "Leeds", "Manhattan", "Madison St/Catherine St, New York, NY 10038, USA", "-73.99751847718505","40.71202712062323","100038"),
	4 => array("GB", "Liverpool", "Manhattan", "429 Broome St, New York, NY 10013, USA", "-73.99932092164306","40.72123239521979","10013"),
	5 => array("US", "Colorado", "Manhattan", "66 1st Avenue, New York, NY 10009, USA", "-73.98627465699462","40.72539549359491","10009"),
	6 => array("US", "California", "Manhattan", "68 W 10th St, New York, NY 10011, USA", "-73.9984626147583","40.73437128836366","10011"),
	7 => array("US", "Texas", "Manhattan", "108 E 16th St, New York, NY 10003, USA", "-73.98884957764892","40.735541954942086","10003"),
	8 => array("US", "Mississippi", "Manhattan", "42 W 44th St, New York, NY 10036, USA", "-73.98215478394775","40.755570168893485","10036"),
	9 => array("IN", "Assam", "Manhattan", "230 E 63rd St, New York, NY 10065, USA", "-73.96344369385986","40.76324171770885","10065"),
	10 => array("IN", "Chandigarh", "Queens", "8 49th Ave, Queens, NY 11101, USA", "-73.94765084718017","40.74217534312245","11101"),
	11 => array("IN", "Chhattisgarh", "Queens", "25-3 Borden Ave, Long Island City, NY 11101, USA", "-73.94473260377197","40.73967164196744","11101"),
	12 => array("IN", "Pondicherry", "Queens", "48-1 36th St, Long Island City, NY 11101, USA", "-73.92962640260009","40.74032196301581","11101"),
	13 => array("IN", "Sikkim", "Queens", "30-09 41st St, Astoria, NY 11103, USA", "-73.91434854005126","40.763209213014065","11103"),
	14 => array("IN", "Uttar Pradesh", "Queens", "30-48 72nd St, Queens, NY 11370, USA", "-73.89546578858642","40.75878842640948","11370"),
	15 => array("GB", "Manchester", "Queens", "63-39 83rd Pl, Flushing, NY 11379, USA", "-73.87108987305908","40.72211057045409","11374"),
	16 => array("GB", "London", "Queens", "79-42 67th Rd, Flushing, NY 11379, USA", "-73.87186234925537","40.71235241703782","11379"),
	17 => array("GB", "London", "Queens", "107-47 104th St, Jamaica, NY 11417, USA", "-73.8354701373413","40.67929418003906","11417"),
	18 => array("US", "California", "Queens", "87-27 133rd St, Jamaica, NY 11418, USA", "-73.81881898377685","40.70155172662101","11418"),
	19 => array("US", "California", "Queens", "143-57 229th St, Jamaica, NY 11413, USA", "-73.74878114197998","40.66406104898427","11413"),
	20 => array("US", "California", "Queens", "4 Central Terminal Area, Jamaica, NY 11430, USA", "-73.78963654969482","40.64153046978498","11430"),

); 
 
 
$itemdata = array(); $i =1;

$tcc = 20;
if($_POST['admin_values']['template'] == "learning"){
$tcc = 20;
}

while($i< $tcc){ 

 
		// EXTRA FOR TEMPLATES
		if(isset($_POST['admin_values']['template'])){
			switch($_POST['admin_values']['template']){
			
	 
			
			case "auction": {
			
			 	$random_num = rand(20, 100);
			 
				$itemdata[$i] = array(
				
						"name" 	=> "Example Auction ".$i,						 
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							"map-country" 	=> $locations[$i][0],			
							"map-city" 		=> $locations[$i][1],
							"map-area" 		=> $locations[$i][2],
							"map-location" 	=> $locations[$i][3],
							"map-log" 		=> $locations[$i][4],
							"map-lat" 		=> $locations[$i][5],
							"map-zip" 		=> $locations[$i][6],	
										 
							"hits" 			=> rand(0,10000),			
							"price_current" => rand(80, 500),
							"price_bin" 	=> rand(500, 1500),
							
							
							"modelnum" => "MH12433",
							
							"backgroundimg" => rand(1,14),
							
							"listing_expiry_date" =>  date('Y-m-d H:i:s', strtotime( current_time( 'mysql' ) . "+".$random_num." days" )  ) ,
							"listing_expiry_days" =>  $random_num,
							
							"examplefield" => "example value",	
							
							"image" => "https://premiumpress.com/_demoimagesv10/at/products/photo/".$i.".jpg",
							
							  
						), 
						
						"tax" => array("listing","condition","features","color","size","brand","refunds"),						
						
				);
				 
			
			} break;
			
			case "micro": {
			
			 	 $itemdata[$i] = array(
				
						"name" 	=> "Example Job ".$i,						 
						
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
						  				 
							"hits" 			=> rand(0,10000),	
							
								"youtube_id"	=> "tBJwQiCjZ-E",
							
							"image" => "https://premiumpress.com/_demoimagesv10/mj/products/biz/".$i.".jpg",
										
					 		
							"days" 			=> rand(1, 30),
							"price" 		=> rand(500, 1500),							
							"gig" => "Example Standard Title",
							"desc" => "This is a test description for this gig. Users can write their own when they create their jobs.",
							
							
							"days-1" 			=> rand(1, 30),
							"price-1" 		=> rand(500, 1500),							
							"gig-1" => "Example Premium Title",
							"desc-1" => "This is a test description for this gig. Users can write their own when they create their jobs.",
							
							
							"customextras" => array(	
							"name" => array( 0 => "Example Addon 1", 1 => "Example Addon 2" ),
							"value" => array( 0 => "Tihs is an example micro job add-on option.", 1 => "Tihs is an example micro job add-on option." ),
							"price" => array( 0 => "10", 1 => "50" ) 
							),
					 		 
							  
						), 
						
						"tax" => array("listing","delivery","features"),						
						
				);
				 
			
			} break;
			case "directory": {
			
			$businesshours = array(
				'start' => array
					(
						0 => '09:00',
						1 => '09:00',
						2 => '12:00',
						3 => '09:45',
						4 => '09:00',
						5 => '09:00',
						6 => '06:45',
					),
			
				'end' => array
					(
						0 => '18:00',
						1 => '18:00',
						2 => '18:00',
						3 => '18:00',
						4 => '18:00',
						5 => '18:00',
						6 => '18:00',
					),
			
				'active' => array
					(
						0 => rand(0,1),
						1 => rand(0,1),
						2 => rand(0,1),
						3 => rand(0,1),
						4 => rand(0,1),
						5 => rand(0,1),
						6 => rand(0,1),
					),
			
			);
			
			$website = array(
			"www.premiumpress.com",
			"google.com",
			"yahoo.com",
			"bing.com",
			"ask.com","baidu.com","duckduckgo.com","youtube.com","facebook.com","twitter.com","myspace.com","bbc.com","cnn.com","wordpress.org","instagram.com","okcupid.com","match.com","zoosk.com","fiverr.com","jdate.com","fontawesome.com","bbpress.org"
			
			);
			 	
			
			$itemdata[$i] = array(
				
						"name" 	=> "Example Business ".$i,						 
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							"map-country" 	=> $locations_dt[$i][0],			
							"map-city" 		=> $locations_dt[$i][1],
							"map-area" 		=> $locations_dt[$i][2],
							"map-location" 	=> $locations_dt[$i][3],
							"map-log" 		=> $locations_dt[$i][4],
							"map-lat" 		=> $locations_dt[$i][5],
							"map-zip" 		=> $locations_dt[$i][6],	
										 
							"hits" 			=> rand(0,10000),			
							"phone" 		=> "+".rand(10,99)." ".rand(100,700)." ".rand(100,700)." ".rand(100,700),
							//"email" 		=> "example@example.com",
							"website" 		=> $website[$i],
							
							"businesshours" => 	$businesshours,
							
							"backgroundimg" => rand(1,14),
							
							"youtube_id"	=> "Rhoumi1Ml9s", 
							
							
							"customextras" => array(	
								"name" => array( 0 => "Example Service 1", 1 => "Example Service 2", 2 => "Example Service 3" ),
								"value" => array( 0 => "Here users can create their own services.", 1 => "Here users can create their own services", 2 => "Here users can create their own services" ),
								"price" => array( 0 => "10", 1 => "50", 2 => "100" ) 
							),
							
							"image" => "https://premiumpress.com/_demoimagesv10/dt/products/biz/".$i.".jpg",
						), 
						
						"tax" => array("listing","features"),
					 	
				);
			
			} break;
			
			case "cardealer": {
				$itemdata[$i] = array(
				
						"name" 	=> "Example Car ".$i,						 
						
						
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							"map-country" 	=> $locations[$i][0],			
							"map-city" 		=> $locations[$i][1],
							"map-area" 		=> $locations[$i][2],
							"map-location" 	=> $locations[$i][3],
							"map-log" 		=> $locations[$i][4],
							"map-lat" 		=> $locations[$i][5],
							"map-zip" 		=> $locations[$i][6],				 
							"hits" 			=> rand(0,10000),			
							"price" 		=> rand(0,10000),
							"miles" 	=> rand(20000,100000),
							"year" 		=> rand(1999,2020),	
							
							"image" => "https://premiumpress.com/_demoimagesv10/dl/products/cars/car".$i."_1.jpg",
						
							
						), 
						
						"tax" => array("make","model","condition","body","fuel","transmission","exterior","interior","doors","seller","features","engine","drive","owners"),
					 	
				);
			} break;	
			case "classifieds": {
				$itemdata[$i] = array(
				
						"name" 	=> "Example Ad ".$i,						 
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							"map-country" 	=> $locations[$i][0],			
							"map-city" 		=> $locations[$i][1],
							"map-area" 		=> $locations[$i][2],
							"map-location" 	=> $locations[$i][3],
							"map-log" 		=> $locations[$i][4],
							"map-lat" 		=> $locations[$i][5],
							"map-zip" 		=> $locations[$i][6],
											 
							"hits" 			=> rand(0,10000),			
							"price" 		=> rand(0,10000),
							"price_bn" 		=> rand(500,10000),	
							
							"examplefield" => "example value",	
							
							"modelnum" => "MH12433",
							
							"image" => "https://premiumpress.com/_demoimagesv10/ct/products/gym/".$i.".jpg",
						 
							
							"backgroundimg" => rand(1,14),		 
						), 
						
						"tax" => array("condition","listing","features","color","size","brand","refunds"),
					 	
				);	 	
			} break;
			
			 		
			case "escort": {
			 
			 
			 	$businesshours = array(
				'start' => array
					(
						0 => '09:00',
						1 => '09:00',
						2 => '12:00',
						3 => '09:45',
						4 => '09:00',
						5 => '09:00',
						6 => '06:45',
					),
			
				'end' => array
					(
						0 => '18:00',
						1 => '18:00',
						2 => '18:00',
						3 => '18:00',
						4 => '18:00',
						5 => '18:00',
						6 => '18:00',
					),
			
				'active' => array
					(
						0 => rand(0,1),
						1 => rand(0,1),
						2 => rand(0,1),
						3 => rand(0,1),
						4 => rand(0,1),
						5 => rand(0,1),
						6 => rand(0,1),
					),
			
			);
			
			
				$ag = rand(18,45);
				$itemdata[$i] = array(
					
							"name" 	=> "Example Profile ".$i,							
							"data" => array(					 
								"hits" 			=> rand(0,10000),			
								 								
								"packageID" 	=> rand(0,2),
														
								"map-country" 	=> $locations[$i][0],			
								"map-city" 		=> $locations[$i][1],
								"map-area" 		=> $locations[$i][2],
								"map-location" 	=> $locations[$i][3],
								"map-log" 		=> $locations[$i][4],
								"map-lat" 		=> $locations[$i][5],
								"map-zip" 		=> $locations[$i][6],
								
								"videoaccess" 	=> array(0 => 1, 1 => 2 , 2 => 3 ),
								
								"image" => "https://premiumpress.com/_demoimagesv10/es/products/escort/".$i.".jpg",
								
								"daage" => $ag,	
								
 								"height" => rand(150,200)." CM",	
								
								"dresssize" => rand(5,12),	
								
								"whatsapp" => "15551234567",
								
								"bustsize" => "G",
								
								"youtube_id"	=> "PVeAGrWJZ6s",
								
								"businesshours" => 	$businesshours, 
								
								"phone" => "123 456 678",
								
								'rate_outcall1' => rand(10,50),
								'rate_outcall2' => rand(10,50),
								'rate_outcall3' => rand(10,50),
								'rate_outcall4' => rand(10,50),
								'rate_outcall5' => rand(10,50),
								
								
								"photosverified" => "1",
								
								
								"lookingdesc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat.", 
								"lookinggen" => $nameLink["dagender-male"],
								"lookingage" => rand(1,6),
								
								"backgroundimg" => rand(1,12),
							),
							
							"tax" => array("listing","dagender","daseeking","dasexuality","dathnicity","daeyes","dahair","dabody","dasmoke","dadrink","features"),
					);	
			
				 	
			} break;
			
			 		
			case "dating": {
			 
			
				$ag = rand(18,65);
				$itemdata[$i] = array(
					
							"name" 	=> "Example Profile ".$i,							
							"data" => array(					 
								"hits" 			=> rand(0,10000),			
								 								
								"packageID" 	=> rand(0,2),
														
								"map-country" 	=> $locations[$i][0],			
								"map-city" 		=> $locations[$i][1],
								"map-area" 		=> $locations[$i][2],
								"map-location" 	=> $locations[$i][3],
								"map-log" 		=> $locations[$i][4],
								"map-lat" 		=> $locations[$i][5],
								"map-zip" 		=> $locations[$i][6],
								
								"videoaccess" 	=> array(0 => 1, 1 => 2 , 2 => 3 ),
								
								"daage" => $ag,	
								
								"lookingdesc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat.", 
								"lookinggen" => $nameLink["dagender-male"],
								"lookingage" => rand(1,6),
								
								"backgroundimg" => rand(1,12),
								
								"youtube_id"	=> "OoaXpf54vs", 
								
								"image" => "https://premiumpress.com/_demoimagesv10/da/products/mix/".$i.".jpg",
								
							),
							
							"tax" => array("dagender","daseeking","dasexuality","dathnicity","daeyes","dahair","dabody","dasmoke","dadrink","features"),
					);	
			
				 	
			} break;
			
			
			
			case "project": {
			
			
				$ss = array_values($randomarray['listing']);
				
				$_POST['admin_values']['category_image_'.$ss[0]] = _ppt_demopath()."/cat1.jpg";	
				$_POST['admin_values']['category_image_'.$ss[1]] = _ppt_demopath()."/cat2.jpg";	
				$_POST['admin_values']['category_image_'.$ss[2]] = _ppt_demopath()."/cat3.jpg";	
				$_POST['admin_values']['category_image_'.$ss[3]] = _ppt_demopath()."/cat4.jpg";	
				$_POST['admin_values']['category_image_'.$ss[4]] = _ppt_demopath()."/cat5.jpg";					
				$_POST['admin_values']['category_image_'.$ss[5]] = _ppt_demopath()."/cat6.jpg";					
				$_POST['admin_values']['category_image_'.$ss[6]] = _ppt_demopath()."/cat7.jpg";					
				$_POST['admin_values']['category_image_'.$ss[7]] = _ppt_demopath()."/cat8.jpg";	
				$_POST['admin_values']['category_image_'.$ss[8]] = _ppt_demopath()."/cat9.jpg";	
				$_POST['admin_values']['category_image_'.$ss[9]] = _ppt_demopath()."/cat10.jpg";	
				$_POST['admin_values']['category_image_'.$ss[10]] = _ppt_demopath()."/cat11.jpg";	
				$_POST['admin_values']['category_image_'.$ss[11]] = _ppt_demopath()."/cat12.jpg";				
				
				// GET THE CURRENT VALUES
				$existing_values = get_option("core_admin_values");
				// MERGE WITH EXISTING VALUES
				$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
				// UPDATE DATABASE 		
				update_option( "core_admin_values", $new_result);
			
			
				$itemdata[$i] = array(
					
							"name" 	=> "Example Job ".$i,							
							"data" => array(		
										 
								"hits" 			=> rand(0,10000),
											
								"price" 		=> rand(50,100000),									
								 								
								"packageID" 	=> rand(0,2),						
								"map-country" 	=> $locations[$i][0],			
								"map-city" 		=> $locations[$i][1],
								"map-area" 		=> $locations[$i][2],
								"map-location" 	=> $locations[$i][3],
								"map-log" 		=> $locations[$i][4],
								"map-lat" 		=> $locations[$i][5],
								"map-zip" 		=> $locations[$i][6],
								 
							),
							
							"tax" => array("experience","listing"),
					);	
					
					 
				 		
			} break;
			
			
			
			
			case "jobs": {
			
			$itemdata[$i] = array(
					
							"name" 	=> "Example Job ".$i,							
							"data" => array(					 
								"hits" 			=> rand(0,10000),			
								"price" 		=> rand(0,100000),	
								
								"company" => "John Doe Company",
								"hours" => rand(20,100),
																
								"packageID" 	=> rand(0,2),						
								"map-country" 	=> $locations[$i][0],			
								"map-city" 		=> $locations[$i][1],
								"map-area" 		=> $locations[$i][2],
								"map-location" 	=> $locations[$i][3],
								"map-log" 		=> $locations[$i][4],
								"map-lat" 		=> $locations[$i][5],
								"map-zip" 		=> $locations[$i][6],
								
								"responsibilities" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",
								
								"qualifications"  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",
								
								
								
							),
							
							"tax" => array("jobtype","experience","listing"),
					);	
					
					 
				 		
			} break;			
			case "coupon": {
			
			
			
					$ss = array_values($randomarray['store']);
					 
					
					$cd = array(
						"store" => array($ss[0],$ss[1],$ss[2],$ss[3],$ss[4]),						 
						"price" => array(rand(100, 1000),rand(100, 1000),rand(100, 10000),rand(100, 10000),rand(100, 10000)),
						"link" => array("https://premiumpress.com","https://premiumpress.com","https://premiumpress.com","https://premiumpress.com","https://premiumpress.com"),
					);
					
					//$_POST['admin_values']['storeimage_'.$ss[0]] = DEMO_IMG_PATH."cp/stores/1.jpg";
					//$_POST['admin_values']['storeimage_'.$ss[1]] = DEMO_IMG_PATH."cp/stores/2.jpg";
					//$_POST['admin_values']['storeimage_'.$ss[2]] = DEMO_IMG_PATH."cp/stores/3.jpg";
					//$_POST['admin_values']['storeimage_'.$ss[3]] = DEMO_IMG_PATH."cp/stores/4.jpg";
					//$_POST['admin_values']['storeimage_'.$ss[4]] = DEMO_IMG_PATH."cp/stores/5.jpg";
					
					$_POST['admin_values']['storelink_'.$ss[0]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[1]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[2]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[3]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[4]] = "https://premiumpress.com";					
					$_POST['admin_values']['storelink_'.$ss[5]] = "https://premiumpress.com";					
					$_POST['admin_values']['storelink_'.$ss[6]] = "https://premiumpress.com";					
					$_POST['admin_values']['storelink_'.$ss[7]] = "https://premiumpress.com";					
					$_POST['admin_values']['storelink_'.$ss[8]] = "https://premiumpress.com";					
					
					
					
					$_POST['admin_values']['category_description_'.$ss[0]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";
					$_POST['admin_values']['category_description_'.$ss[1]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";
					$_POST['admin_values']['category_description_'.$ss[2]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";
					$_POST['admin_values']['category_description_'.$ss[3]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";
					$_POST['admin_values']['category_description_'.$ss[4]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";					
					$_POST['admin_values']['category_description_'.$ss[5]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";					
					$_POST['admin_values']['category_description_'.$ss[6]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";					
					$_POST['admin_values']['category_description_'.$ss[7]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";					
				 $_POST['admin_values']['category_description_'.$ss[8]] = "<h4>Learn more about this store;</h4><p>Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.</p>";					
				 
					$_POST['admin_values']['storelinkaff_'.$ss[0]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[1]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[2]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[3]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[4]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[5]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[6]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[7]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[8]] = "https://premiumpress.com/?afflink=123";
					 
					
					// GET THE CURRENT VALUES
					$existing_values = get_option("core_admin_values");
					// MERGE WITH EXISTING VALUES
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
					// UPDATE DATABASE 		
					update_option( "core_admin_values", $new_result);
			
 			
			 	 $itemdata[$i] = array(
				
						"name" 	=> "Coupon Title ".$i,
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							 			 
							"hits" 			=> rand(0,10000), 
							
							"buy_link" => "https://www.premiumpress.com",
							
							"verified" 	=> rand(0,1),	
							
							"listing_expiry_date" => date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " + ".rand(1, 30)." days") ),
							 
							
						), 
						
						"tax" => array("listing", "store"),						
						
				);
				 
			
			} break;
			
			
			case "learning": {
			 
			 	 $itemdata[$i] = array(
				
						"name" 	=> "Example Course ".$i, 
						
						"data" => array(
						
							"backgroundimg" => rand(1,14),
							
							"hits" 			=> rand(0,10000),  
							
							"price"	=> "0",
							
							"youtube_id"	=> "H3K9y8ptQ0s",
							
							"download_path" 	=> "https://www.premiumpress.com/_demoimages/softwaretheme/example.zip",
							
							"req" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",
							
							
							"image" => "https://premiumpress.com/_demoimagesv10/ll/products/course/".$i.".jpg",
						
								 
								
							
						 							 
						), 
						
						"tax" => array("listing","level","language","features"),						
						
				); 
				 
			} break;
			
			
			case "photography": {
			 
			 	 $itemdata[$i] = array(
				
						"name" 	=> "Example File ".$i,						 
						
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
						  				 
							"hits" 			=> rand(0,10000),	 
						 
							 "camera_model" => " Mark 3",
							 
						), 
						
						"tax" => array("listing","orientation","features","license","cameratype"),						
						
				); 
				 
			} break;
			case "software": {
			 
					$itemdata[$i] = array(
					
							"name" 	=> "Example Software ".$i,							
							"data" => array(				
								 
								"hits" 				=> rand(1000,10000),	
								"price" 			=> rand(0,100),			
								"old_price" 		=> rand(10,500),		
								"download_count" 	=> rand(0,10000),
								
								"version" 	=> rand(1,5).".".rand(0,9),	
								 
								"type" 				=> "3",
								
								"examplefield" => "example value",
								
								"url" 				=> "https://www.premiumpress.com/",
								"url_demo" 			=> "https://www.premiumpress.com/?demo=123",
								
								"download_path" 	=> "https://www.premiumpress.com/_demoimages/softwaretheme/example.zip",
								
								"image" => "https://premiumpress.com/_demoimagesv10/so/product/box/".$i.".jpg",
								 
							 
							),	
							
							
							"tax" => array("listing","features","system"),			
							 
					);	
 		
			} break;
			
			case "realestate": {	
			
			
		 			 
					$itemdata[$i] = array(
					
							"name" 	=> "Example Property ".$i,							
							"data" => array(					 
								"hits" 			=> rand(0,10000),			
								"price" 		=> rand(0,100000),		
								"size" 			=> rand(0,10000),								
								"packageID" 	=> rand(0,2),						
								"map-country" 	=> $locations[$i][0],			
								"map-city" 		=> $locations[$i][1],
								"map-area" 		=> $locations[$i][2],
								"map-location" 	=> $locations[$i][3],
								"map-log" 		=> $locations[$i][4],
								"map-lat" 		=> $locations[$i][5],
								"map-zip" 		=> $locations[$i][6],
								
								"image" => "https://premiumpress.com/_demoimagesv10/rt/products/homes/".$i.".jpg",
						
								
							),
							
							"tax" => array("beds","baths","type","listing","features"),
					);				
			} break;
			case "compare": {			
			
					$ss = array_values($randomarray['store']);
					 
					
					$cd = array(
						"store" => array($ss[0],$ss[1],$ss[2],$ss[3],$ss[4]),						 
						"price" => array(rand(100, 1000),rand(100, 1000),rand(100, 10000),rand(100, 10000),rand(100, 10000)),
						"link" => array("https://premiumpress.com","https://premiumpress.com","https://premiumpress.com","https://premiumpress.com","https://premiumpress.com"),
					);
					
					$_POST['admin_values']['storeimage_'.$ss[0]] = DEMO_IMG_PATH."cm/stores/1.jpg";
					$_POST['admin_values']['storeimage_'.$ss[1]] = DEMO_IMG_PATH."cm/stores/2.jpg";
					$_POST['admin_values']['storeimage_'.$ss[2]] = DEMO_IMG_PATH."cm/stores/3.jpg";
					$_POST['admin_values']['storeimage_'.$ss[3]] = DEMO_IMG_PATH."cm/stores/4.jpg";
					$_POST['admin_values']['storeimage_'.$ss[4]] = DEMO_IMG_PATH."cm/stores/5.jpg";
					$_POST['admin_values']['storeimage_'.$ss[4]] = DEMO_IMG_PATH."cm/stores/6.jpg";
					
					$_POST['admin_values']['storelink_'.$ss[0]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[1]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[2]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[3]] = "https://premiumpress.com";	
					$_POST['admin_values']['storelink_'.$ss[4]] = "https://premiumpress.com";		
					$_POST['admin_values']['storelink_'.$ss[5]] = "https://premiumpress.com";			
					
					$_POST['admin_values']['category_description_'.$ss[0]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";
					$_POST['admin_values']['category_description_'.$ss[1]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";
					$_POST['admin_values']['category_description_'.$ss[2]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";
					$_POST['admin_values']['category_description_'.$ss[3]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";
					$_POST['admin_values']['category_description_'.$ss[4]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";					
					$_POST['admin_values']['category_description_'.$ss[5]] = "Et vim graeco principes. Cu dico nullam pri stet possim quaerendum invenire platonem animal assentior nam.";	
					
					$_POST['admin_values']['storelinkaff_'.$ss[0]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[1]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[2]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[3]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[4]] = "https://premiumpress.com/?afflink=123";
					$_POST['admin_values']['storelinkaff_'.$ss[5]] = "https://premiumpress.com/?afflink=123";
					
					
				
					
					// GET THE CURRENT VALUES
					$existing_values = get_option("core_admin_values");
					// MERGE WITH EXISTING VALUES
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
					// UPDATE DATABASE 		
					update_option( "core_admin_values", $new_result);
					
					 
			
					$itemdata[$i] = array(
					
							"name" 	=> "Example Product ".$i,							
							"data" => array(
								 
								"packageID" 	=> rand(0,2),	
								"hits" 		=> rand(0,10000),			
								"price" 	=> rand(0,10000),		
								"old_price" 	=> rand(0,10000),
								
								"sku" 	=> "PPT0".rand(1,9)."-".rand(100,200),
								
								"cm_verdict" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.",
								"cm_for" 	=> "Point One\nPoint Two\nPoint Three\nPoint Four",
								"cm_against" => "Point One\nPoint Two\nPoint Three\nPoint Four",
								"cm_rating" => "5", 
								
								"comparedata" => $cd,
								
								
								"buy_link" 	=> "https://www.premiumpress.com/",
								
								"image" => "https://premiumpress.com/_demoimagesv10/cm/products/photo/".$i.".jpg",
						
								
							),
							
							"tax" => array("color","size","listing","features","store"),
					);	
			
			
			} break;
			case "shop": {	
					
					$op = 0;
					if($i > 10){
					
					$op = rand(100,200);
					}
						 
					$itemdata[$i] = array(
					
							"name" 	=> "Example Product ".$i,							
							"data" => array(
								 
								"hits" 		=> rand(0,10000),			
								"price" 	=> rand(50,200),		
								"old_price" 	=> $op,
								
								"sku" 	=> "PPT0".rand(1,9)."-".rand(100,200),
								
								"image" => "https://premiumpress.com/_demoimagesv10/sp/products/store2/".$i.".jpg",
							),
							
							"tax" => array("color","size","listing"),
					);				
			} break;
 
			case "video": {
				$itemdata[$i] = array(
				
						"name" 	=> "Example Video ".$i,						 
						
						"data" => array(
							"packageID" 	=> rand(0,2),							
							"map-country" 	=> $locations[$i][0],			
							"map-city" 		=> $locations[$i][1],
							"map-area" 		=> $locations[$i][2],
							"map-location" 	=> $locations[$i][3],
							"map-log" 		=> $locations[$i][4],
							"map-lat" 		=> $locations[$i][5],
							"map-zip" 		=> $locations[$i][6],
											 
							"hits" 			=> rand(0,10000),			
							"time" 			=> rand(1,1000),
							"level" 		=> rand(1,3),	
							"youtube_id"	=> "H3K9y8ptQ0s",
							"videoaccess" 	=> array(0 => 1, 1 => 2 , 2 => 3 ),
							
							
							"image" => "https://premiumpress.com/_demoimagesv10/vt/products/cook/".$i.".jpg",
							
						), 
						
						"tax" => array("listing","level"),
					 	
				);	 	
			} break;

			}
		}// END SWITCH	

 
$i++;
};



	 
$i=1; $importedListings = array();
foreach($itemdata as $car){

	if($car['name'] == ""){ continue; }
 
	$my_post = array();
	$my_post['post_title'] 		= $car['name'];
	
	
	
	if(isset($_POST['admin_values']['template']) && in_array($_POST['admin_values']['template'], array("software","escort"))){
	
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>";			
		
	}elseif(isset($_POST['admin_values']['template']) && in_array($_POST['admin_values']['template'], array("shop","compare","directory"))){
	
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>";	
		
		
	}else{
	
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>";	

	}
	

	
	
	$my_post['post_type'] 		= THEME_TAXONOMY."_type";
	$my_post['post_excerpt'] 	= "";
	
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= array('tag1','tag2');
	$POSTID 					= wp_insert_post( $my_post );
	
	$importedListings[$i] = $POSTID;
 	 
 	foreach($car['data'] as $k => $g){
	
		add_post_meta($POSTID, $k, $g );
	
	}
	
	// BACKGROUND
	update_post_meta($POSTID, "backgroundimg", rand(1,14) );
	 
	 
 	
 	foreach($car['tax'] as $k){
	 
		// GET RANDOM VALUE FROM MAIN LIST	 
		if(isset($randomarray[$k]) ){
		
			$rand_keys = array_rand($randomarray[$k], 1);
			
			if($k == "features"){
		 	
			wp_set_post_terms( $POSTID, $randomarray[$k], $k );
			
			}else{
			
				if($k == "listing" && in_array($_POST['admin_values']['template'], array("classifieds","exchange") ) ){
			 
				$rand_keys = $randomarray[$k];
				
				}elseif($k == "listing" && $_POST['admin_values']['template'] == "coupon"){
				
				$rand_keys = $nameLink["listing-coupon"];
				
				
				}elseif($k == "dagender" && $_POST['admin_values']['template'] == "escort"){
				
				
				$rand_keys = $nameLink["dagender-female"];
				
				}elseif($k == "dagender"){
					
					if($i < 10){
					$rand_keys = $nameLink["dagender-male"];
				 	}else{
					$rand_keys = $nameLink["dagender-female"];
					}
				 
				
				} 
			
				wp_set_post_terms( $POSTID, $rand_keys, $k );
 				
			}			
			
		}
	
	}
 	
$i++;		
} // end foreach


	
		$nusers = array(
			
			1 => array("name" => "James Black", "pass" => "password", "email" => "jblack@gmail.com", "photo" => _ppt_demopath()."/user1.jpg", "youtube" => "DB0HDumBAH4", "info" => "I am well-balanced and stable, but willing to let you knock me off my feet."),
			2 => array("name" => "John Forth", "pass" => "password", "email" => "jforth@gmail.com", "photo" => _ppt_demopath()."/user2.jpg", "youtube" => "-jL5vzGmU-k", "info" => "I am old fashioned sometimes. I still believe in romance, in roses, in holding hands."),
			3 => array("name" => "Tim Green", "pass" => "password", "email" => "tgreen@gmail.com", "photo" => _ppt_demopath()."/user3.jpg", "youtube" => "DZYXleNfqc0", "info" => "I don't smoke, drink or party every weekend. I don't play around or start drama to get attention. Yes, we do still exist!"),
			4 => array("name" => "Kai Rashford", "pass" => "password", "email" => "krashford@gmail.com", "photo" => _ppt_demopath()."/user4.jpg", "youtube" => "lbIAFwGJL8I", "info" => "I'm going to make the rest of my life the best of my life. Care to share it with me?"),
			
			5 => array("name" => "Jane Cross", "pass" => "password", "email" => "jcross@gmail.com", "photo" => _ppt_demopath()."/user5.jpg", "youtube" => "_71XmzANVow", "info" => "I am strong, kind, smart, hilarious, sweet, lovable, and amazing. Isn't that what you've been looking for?"),
			6 => array("name" => "Sarah Smith", "pass" => "password", "email" => "ssmith@gmail.com", "photo" => _ppt_demopath()."/user6.jpg", "youtube" => "wD3YltuTUwE", "info" => "I'm neither especially clever nor especially gifted, except for when it comes to being your perfect other half." ),
			7 => array("name" => "Karren Ronbinson", "pass" => "password", "email" => "krobinson@gmail.com", "photo" => _ppt_demopath()."/user7.jpg", "youtube" => "cCFQDNISUbY", "info" => "I want to inspire and be inspired.",),
			8 => array("name" => "Maria Brown", "pass" => "password", "email" => "mbrown@gmail.com", "photo" => _ppt_demopath()."/user8.jpg", "youtube" => "T7qvWrbXKG8", "info" => "I find that having a dirty mind makes ordinary conversations much more interesting." ), 
			
			
			
		
			 
			 
		
		);
 

/***********************************************************************************/

// EXTRA FOR TEMPLATES
if(isset($_POST['admin_values']['template'])){
	switch($_POST['admin_values']['template']){	
	 	
		case "learning": 
		case "escort": 
		case "photography":
		case "dating": 
		case "exchange":
		case "project": {
	
		$ic = 1;
		foreach($nusers as $user){
		
			$user_id = wp_create_user( $user['name'], $user['pass'], $user['email'] );	
			
			if ( is_wp_error( $user_id  ) ) {
				
				$us = get_user_by( 'email', $user['email']  );
				
				$user_id = $us->data->ID;
			}
			
			update_user_meta( $user_id, "userphoto", array('img' => $user['photo']));	
			update_user_meta( $user_id, 'ppt_verified', 1);	
			 
			$ggtypes = array("user_fr", "user_em");
			$ut = $ggtypes[rand(0,1)];
			update_user_meta( $user_id, 'user_type', $ut);	
			
			update_user_meta( $user_id, 'login_lastdate', date('Y-m-d H:i:s', strtotime( current_time( 'mysql' ) )  ) );	
			
 			
			if(in_array($_POST['admin_values']['template'], array("photography", "learning" ) ) ){ 
				
				$my_post = array();
				$my_post['ID'] = $importedListings[$ic];				
				//$my_post['post_title'] = get_the_title($importedListings[$ic]);	
				$my_post['post_author'] = $user_id;				 
				wp_update_post( $my_post );
				
				update_user_meta( $user_id, "userphoto", array('img' => $user['photo']));	
				
				if(in_array($_POST['admin_values']['template'], array("learning" ) ) ){ 
				update_post_meta($my_post['ID'], 'youtube_id', $user['youtube'] );
				}
			
			
			}elseif(in_array($_POST['admin_values']['template'], array("dating","escort") ) ){ 
				
				$my_post = array();
				$my_post['ID'] = $importedListings[$ic];				
				$my_post['post_title'] = get_the_title($importedListings[$ic]);	
				$my_post['post_author'] = $user_id;				 
				wp_update_post( $my_post );
				
				update_user_meta( $user_id, "userphoto", array('img' => $user['photo']));	
				 
		  
					
					 
			}elseif($_POST['admin_values']['template'] == "exchange"){
			
			
				update_user_meta( $user_id, 'country', "US");
				update_user_meta( $user_id, 'city', "New York");
			
				$my_post = array(
						'post_type'		=> 'listing_type',
						'post_title' 	=> __("My Profile","premiumpress")." - ".$user['name'],
						'post_modified' => current_time( 'mysql' ),
						'post_excerpt' => 'Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. ',
						'post_content' 	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. <br><br> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. <br><br> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget. ',
						'post_author' 	=> $user_id,
					);	
					 				
					$my_post['post_status'] 	= "publish"; 
					$POSTID = wp_insert_post( $my_post );	
					 
					
					$rand_keys = array_rand($randomarray["listing"], 1);
					
					wp_set_post_terms( $POSTID, $rand_keys, "listing" );
					
					update_post_meta($POSTID, 'youtube_id', $user['youtube'] );
					
					
					if($ut == "user_em"){
					update_post_meta($POSTID, 'user_type', "user_em");
					}else{
					update_post_meta($POSTID, 'user_type', "user_fr");
					}
					
			
			}else{
			
			update_user_meta( $user_id, 'pj_rate', rand(5,50));	
			
			}
			
			$ic++;
		
		}
		
		
		
			if(in_array($_POST['admin_values']['template'], array("dating","escort")) ){ 
			
			//$GLOBALS['theme_defaults']['mem']["enable"] = 1;
			$GLOBALS['theme_defaults']['lst']["onelistingonly"] = 1;
		 	//$GLOBALS['theme_defaults']['lst']["websitepackages"] = 1;
			
			
			$GLOBALS['theme_defaults']['mem0_msg_send'] = 0;
			$GLOBALS['theme_defaults']['mem0_view_photos'] = 0;
			$GLOBALS['theme_defaults']['mem0_view_videos'] = 0; 
			
			if(in_array($_POST['admin_values']['template'], array("escort")) ){
			$GLOBALS['theme_defaults']['design']['single_top'] = "gallery"; 
			
			} 
			
			
			
			if(in_array($_POST['admin_values']['template'], array("photography")) ){ 
			$GLOBALS['theme_defaults']['lst']["websitepackages"] = 1;
			
			$GLOBALS['theme_defaults']['pak0_enable'] = 0;
			$GLOBALS['theme_defaults']['pak1_enable'] = 0;
			$GLOBALS['theme_defaults']['pak2_enable'] = 0;
			
			
			}
			
			
			if(in_array($_POST['admin_values']['template'], array("learning")) ){ 
					 
				$GLOBALS['theme_defaults']['searchtax']['0'] = "levels";
				$GLOBALS['theme_defaults']['searchtax']['1'] = "language";					 
				$GLOBALS['theme_defaults']['taxorder']['levels'] = "1";
				$GLOBALS['theme_defaults']['taxorder']['language'] = "2";				
				$GLOBALS['theme_defaults']['search']['cardswicth'] = "0";				
				
		  	}
		 
			$GLOBALS['theme_defaults']['searchtax']['0'] = "dagender";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "1";
		 	
			$GLOBALS['theme_defaults']['searchtax']['2'] = "dasexuality";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "3";
			
			$GLOBALS['theme_defaults']['searchtax']['3'] = "dathnicity";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "4";
			
			$GLOBALS['theme_defaults']['searchtax']['4'] = "daeyes";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "5";
			
			$GLOBALS['theme_defaults']['searchtax']['5'] = "dahair";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "6";
			
			$GLOBALS['theme_defaults']['searchtax']['6'] = "dabody";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "7";
			
			$GLOBALS['theme_defaults']['searchtax']['7'] = "dasmoke";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "8";
			
			$GLOBALS['theme_defaults']['searchtax']['8'] = "dadrink";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "9";
			
			$GLOBALS['theme_defaults']['searchtax']['9'] = "dastarsign";			 
			$GLOBALS['theme_defaults']['dagender']['level'] = "10";
		
			}
	 	
		
		
		} break;	
		
		case "classifieds":
		case "directory": {
			
			//$GLOBALS['theme_defaults']['mem']["enable"] = 1;
		 	$GLOBALS['theme_defaults']['lst']["websitepackages"] = 1;
			
		
		} break;		
		
		case "software": {
		
			//$GLOBALS['theme_defaults']['mem']["enable"] = 1;
			$GLOBALS['theme_defaults']['lst']["onelistingonly"] = 0;
		 	$GLOBALS['theme_defaults']['lst']["websitepackages"] = 0;
		
			$GLOBALS['theme_defaults']['lst']["requirelogin_downloads"] = 1;
			$GLOBALS['theme_defaults']['lst']["hide_featuredimage"] = 1;
		
		} break;
				
		case "realestate": {
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "beds";
			$GLOBALS['theme_defaults']['searchtax']['1'] = "baths";
			$GLOBALS['theme_defaults']['searchtax']['2'] = "type";
			
			$GLOBALS['theme_defaults']['taxorder']['beds'] = "2";
			$GLOBALS['theme_defaults']['taxorder']['baths'] = "3";
			$GLOBALS['theme_defaults']['taxorder']['type'] = "1";
			$GLOBALS['theme_defaults']['taxorder']['features'] = "4";
			
			
			$GLOBALS['theme_defaults']['design']['single_top'] = "gallery"; 
			
						
		} break;
		
		case "auction": {
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "condition";			 
			$GLOBALS['theme_defaults']['taxorder']['condition'] = "1";
			
			$GLOBALS['theme_defaults']['searchtax']['1'] = "color";	
			$GLOBALS['theme_defaults']['searchtax']['2'] = "store";	
					 
			$GLOBALS['theme_defaults']['taxorder']['color'] = "1";
			$GLOBALS['theme_defaults']['taxorder']['store'] = "2";
			
			//$GLOBALS['theme_defaults']['mem']["enable"] = 1;
		 	$GLOBALS['theme_defaults']['lst']["websitepackages"] = 1; 
			
						
		} break;
				
		case "jobs": {
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "jobtype";			 
			$GLOBALS['theme_defaults']['taxorder']['jobtype'] = "1";
						
		} break;
		
		
		case "exchange": {
		
			$GLOBALS['theme_defaults']['lst']["onelistingonly"] = 1;
			
		} break;
 
		
		case "video": {
				
			//$GLOBALS['theme_defaults']['mem']["enable"] = 1;
		 	$GLOBALS['theme_defaults']['lst']["websitepackages"] = 0;	
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "level";			 
			$GLOBALS['theme_defaults']['taxorder']['level'] = "1";
			
			foreach($importedListings as $vid){
			
			update_post_meta($vid, "vt_video1", $importedListings[1] );
			update_post_meta($vid, "vt_video2", $importedListings[2] );
			update_post_meta($vid, "vt_video3", $importedListings[3] );
			update_post_meta($vid, "vt_video4", $importedListings[4] );
			//update_post_meta($vid, "vt_video5", $importedListings[5] );
			//update_post_meta($vid, "vt_video6", $importedListings[6] );
			
			}
						
		} break;
		
		case "compare": {
		
			$GLOBALS['theme_defaults']['searchtax']['0'] = "color";	
			$GLOBALS['theme_defaults']['searchtax']['1'] = "store";	
					 
			$GLOBALS['theme_defaults']['taxorder']['color'] = "1";
			$GLOBALS['theme_defaults']['taxorder']['store'] = "2";
		
		} break;
		
		case "coupon": {
		
			 
			$GLOBALS['theme_defaults']['searchtax']['1'] = "store";	
			 
			$GLOBALS['theme_defaults']['taxorder']['store'] = "1";
		
		} break;
		
		case "shop": {
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "color";			 
			$GLOBALS['theme_defaults']['taxorder']['color'] = "1";
						
		} break;
		
		case "cardealer": {
				
			$GLOBALS['theme_defaults']['searchtax']['0'] = "make";			 
			$GLOBALS['theme_defaults']['taxorder']['make'] = "1";
			
			$GLOBALS['theme_defaults']['searchtax']['1'] = "model";			 
			$GLOBALS['theme_defaults']['taxorder']['model'] = "2";
			
			$GLOBALS['theme_defaults']['searchtax']['1'] = "condition";			 
			$GLOBALS['theme_defaults']['taxorder']['condition'] = "3";
		
		
							
		} break;
 
		
	}
} 


if(defined('WLT_DEMOMODE')){

$GLOBALS['theme_defaults']['maps']['enable'] = "1";
$GLOBALS['theme_defaults']['maps']['provider'] = "mapbox";
$GLOBALS['theme_defaults']['maps']['apikey'] = "pk.eyJ1IjoibWFya2ZhaWwiLCJhIjoiY2tmcDVjdHMzMDQ3ajJzcGc4ZXYwd25ieiJ9.e7zE4IaDtGATyhs5XIucUw";


$GLOBALS['theme_defaults']['emails']['user_verify']['enable'] = 1;
$GLOBALS['theme_defaults']['emails']['admin_user_new']['enable'] = 1;
$GLOBALS['theme_defaults']['emails']['admin_user_login']['enable']  = 1;
$GLOBALS['theme_defaults']['emails']['admin_user_login']['subject'] = "Demo Theme Login - (theme_key)";


}

	$GLOBALS['theme_defaults']['newsletter']['enable'] = "1";
	$GLOBALS['theme_defaults']['newsletter']['newsdefault'] = "1";
	 
	
	// FINALLY, SAVE IT ALL AND UPDATE DATABASE 		
	update_option( "core_admin_values",  array_merge((array)get_option("core_admin_values"), $GLOBALS['theme_defaults'])); 	
	
	// FINISH
	$GLOBALS['error_message'] = "Example Information Installed";
 		
	 
}// END FUNCTION
   
   
   
 


	function IsNumericOnly($input)
	{
		/*  NOTE: The PHP function "is_numeric()" evaluates "1e4" to true
		 *        and "is_int()" only evaluates actual integers, not 
		 *        numeric strings. */

		return preg_match("/^[0-9]*$/", $input);
	}

	function GetAsRed($string, $inBold=false)
	{
		return GetAsColor($string, 'FF0000', $inBold);
	}

	function GetAsGreen($string, $inBold=false)
	{
		return GetAsColor($string, '279B00', $inBold);
	} 
	function GetAsColor($string, $colorHex, $inBold)
	{
		$string = ($string === false || $string === 0) ? '0' : $string;
		if($inBold) $string = '<b>'.$string.'</b>';
		return '<span style="color:#'.$colorHex.'">'.$string.'</span>';
	}
	function IsExtensionInstalled($moduleName)
	{
		// The faster "less-reliable" alternative which is not used because
		// a module (or extension) names could be in different casing, so
		// 'Mysql' should be approved even though only 'mysql' is loaded		
		## return extension_loaded($moduleName);

		// Set the module name to lower case and get all loaded extensions 
		$moduleName = strtolower($moduleName);
		$extensions = get_loaded_extensions();
		foreach($extensions as $ext)
		{
			if($moduleName == strtolower($ext))
				return true;
		}

		return false;
	}
	function ppt_system_check($echo = false, $extras=false){
	
	
		$php_extentions = array(
		'title'       =>  'PHP Requirements',
		'enabled'     =>  $extras,
		'extensions'  =>  array(
							'mysql'  => 'MySQL Databases',
							'mcrypt' => 'Encryption',
							'zlib'   => 'ZIP Archives',
							'GD'   => 'Image Editing',
							'ffmpeg'   => 'Video thumbnail Service',
							'cURL'   => 'Client URL Library', 
							'exif'   => 'Exchangeable image information',							  
							'Filter'   => 'Data Filtering', 
							'FTP'   => 'File Transfer Protocol', 
							'Hash'   => 'HASH Message Digest Framework', 
							'iconv'   => 'iconv', 
							'JSON'   => 'JavaScript Object Notation', 
							'libxml'   => 'libxml', 
							'mbstring'   => 'Multibyte String', 
							'OpenSSL'   => 'OpenSSL', 
							'PCRE'   => 'Regular Expressions (Perl-Compatible)', 
							'SimpleXML'   => 'SimpleXML', 
							'Sockets'   => 'Sockets', 
							'SPL'   => 'Standard PHP Library (SPL)', 
							'Tokenizer'   => 'Tokenizer', 
							 
		)
		);
	
		$php_directives = array
		(
			// --- BOOLEAN SETTINGS : On/Off ---
			array('title'  => 'Running Safe Mode',
				  'inikey' => 'safe_mode',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Register Globals',
				  'inikey' => 'register_globals',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Magic Quotes Runtime',
				  'inikey' => 'magic_quotes_runtime',
				  'mustbe' => 'Off',
				),
			 /*array('title'  => 'Display PHP Errors',
			 	  'inikey' => 'display_errors',
			 	  'mustbe' => 'On',
			 	),*/
			 //array('title'  => 'Short Open Tags',
			 //	  'inikey' => 'short_open_tag',
			 //	  'mustbe' => 'On',
			 //	),
			array('title'  => 'Automatic Session Start',
				  'inikey' => 'session.auto_start',
				  'mustbe' => 'Off',
				),
			array('title'  => 'File Uploading',
				  'inikey' => 'file_uploads',
				  'mustbe' => 'On',
				),
	
			// --- NUMERIC SETTINGS : Ints ---
			array('title'    => 'Maximum Upload File Size',
				  'inikey'   => 'upload_max_filesize',
				  'orhigher' => '10M',
				),
				
			array('title'    => 'Maximum Input Time',
				  'inikey'   => 'max_input_time',
				  'orhigher' => '60',
				),
								
			array('title'    => 'Max Simultaneous Uploads',
				  'inikey'   => 'max_file_uploads',
				  'orhigher'  => '2', 
				),
			array('title'    => 'Max Execution Time',
				  'inikey'   => 'max_execution_time',
				  'orhigher' => '100',
				),			
			array('title'    => 'Memory Capacity Limit',
				  'inikey'   => 'memory_limit',
				  'orhigher' => '32M',
				),
			array('title'    => 'POST Form Maximum Size',
				  'inikey'   => 'post_max_size',
				  'orhigher' => '16M',
				),
		);
		
	$output_string = ""; $passed_checks = true;	
	
	if($php_extentions['enabled']){
	foreach($php_extentions['extensions'] as $extKey=>$extTitle){
	
						$output_string .= '<tr>';
						$output_string .= '<td><strong>'.$extTitle.'</strong><br /><small>'.$extKey.'</small></td>';
						$output_string .= '<td>On</td>';
						if(IsExtensionInstalled($extKey)){
							$output_string .= '<td>'.GetAsGreen('On', true).'</td>';								
						}else{
							$output_string .= '<td>'.GetAsRed('Off', true).'</td>'; 
						}
						$output_string .= '</tr>';
	}
	}				
	foreach($php_directives as $idx=>$directive) {
	 
	// Prepair variables
							$current = ini_get($directive['inikey']);
							$required = '';
							$icon = 'okayico';
	
							// If this directive must be equal to something, works
							// with booleans, strings and numeric values
							if(isset($directive['mustbe']))
							{
								$required = $directive['mustbe']; 
								if($required == 'On' || $required == 'Off')
								{
									// Requirements are met
									if($current == '1' && $required == 'On')
										$current = GetAsGreen('On', true);
									else if($current != '1' && $required == 'Off')
										$current = GetAsGreen('Off', true);
	
									// Current switch is not correct
									else if($current == '1')
									{
										$current = GetAsRed('On', true);
										$icon = 'failico';
										$passed_checks = false;
									}
									else 
									{
										$current = GetAsRed('Off', true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
	
								// Any other value MUST be equal!
								else if($current == $required)
									$current = GetAsGreen($current, true);
								else
								{
									$current = GetAsRed($current, true);
									$icon = 'failico';
									$passed_checks = false;
								}
							}
	
							// or Higher/Lower only works with numeric values
							else if(isset($directive['orhigher']) || isset($directive['orlower']))
							{
							
								$current = ($current === '') ? 0 : $current;
								  
								$required = (isset($directive['orhigher'])) ? $directive['orhigher'] : $directive['orlower'];
								$reqInt = $required;
								$curInt = $current;
								settype($reqInt, 'integer');
								settype($curInt, 'integer');
	
								if(isset($directive['orhigher']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or more</span>';
									if($curInt >= $reqInt || $current == 0){
										$current = GetAsGreen($current, true);
									}else{								
										$current = GetAsRed($current, true);									
										$icon = 'failico';
										$passed_checks = false;
									}
								}
								else if(isset($directive['orlower']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or less</span>';
									if($curInt <= $reqInt){
									
										$current = GetAsGreen($current, true);
										
									}else{
									
										$current = GetAsRed($current, true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
							}
					
	
							
							$output_string .= '<tr>';
							$output_string .= '<td style="font-size:12px;"><strong title="'.$directive['inikey'].'">'.$directive['title'].'</strong><br /><small>'.$directive['inikey'].'</small></td>';
							$output_string .= '<td>'.$required.'</td>';
							$output_string .= '<td>'.$current.'</td>';	
							$output_string .= '</tr>';
									
	}	
	
	if($echo){
		echo '<table class="table table-bordered" style="background:#fff;">';
		echo '<tr><td><strong>Directive Title</strong></td><td>Required</td><td><span style="color:#279B00"><b>Current</b></span></td></tr>';
		echo $output_string;
		echo '</table>';
		if(!$passed_checks){
		echo "<p class='alert alert-warning'><b>Your hosting setup needs adjusting</b><br>Contact your webserver support (hosting service) to get the necessary PHP settings fixed.</p>";
		}
	}else{
		if($passed_checks){
		return true;
		}else{
		return false;
		}
	}
	}

















?>