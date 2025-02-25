<?php
 
class ppt_admin extends ppt_admin_design { 



function _theme_remove_required(){
//if(isset($_GET['TB_iframe'])){ 
?>
<script>
jQuery(document).ready(function () {		
					 				 
jQuery('input').removeAttr('required');
 				  
});					  
</script>
<?php
//}
}
 

	function __construct(){ global $pagenow, $CORE, $userdata;
	
		
		
		if( isset($_GET['page']) && in_array($_GET['page'], array("settings","design","reports")) && get_option("ppt_license_key") == "" ){
			header("location: admin.php?page=premiumpress");
			exit();
		}
		
		
		add_action('admin_print_footer_scripts', array($this,'_theme_remove_required') );
	
 		
		// ADD IN TAXONOMY ORDERING FUNCTIONS
	 	add_action('admin_menu', 'ppt_orderby_PluginMenu', 99);
 	 
		// 0. SWITCHED THEME
		add_action('switch_theme', 			array($this,'_theme_deactivated') );
		add_action('after_switch_theme', 	array($this,'_theme_activated') );
 	 
		// 1. ADMIN STYLES IN HEADER/FOOTER
		add_action('admin_head', 	array($this, '_admin_head' ) );
		add_action('admin_footer', 	array($this, '_admin_footer') );
		 
		// REMOVE PASSWORD FROM ADMIN
		if( !current_user_can( 'edit_user', $userdata->ID ) ) {
			add_filter( 'show_password_fields', '__return_false' );			
		}
		
		// 2. LOAD IN ADMIN MENU
		add_action('admin_menu', 	array($this, '_admin_menu' ) ); 
		add_action('admin_menu', 	array($this, '_admin_menu_plugins' ) );
		// 3. MAIN INIT
		add_action('init',	array($this, '_init' ) );
		
		// 3. ADMIN INIT
		add_action('admin_init',	array($this, '_admin_init' ), 999);
		
		// EXTEND USER DROP DOWN
		add_filter('wp_dropdown_users', array($this, '_wp_dropdown_users' ) );
	   
		// LISTING CATEGORY
		add_filter('edited_terms', array( $this, 'ppt_update_icon_field' )); 
	 	 
		 
			/*
				Here we allow saving of custom post_meta data
				so we dont need to keep declaring it
			*/
			add_action('admin_menu', array($this, 	'_custom_metabox' ) );		 	
			add_action('save_post', array($this, '_custom_metabox_save') );
			
			add_filter('comment_save_pre', array($this, 'save_mycomment_data' ) );
			
			
		 
		 
		 


/* COMMENTS */
add_filter("manage_edit-comments_columns", function($columns) {
       // unset($columns["author"]);
        $columns_one = array_slice($columns,0,1);
        $columns_two = array_slice($columns,1);
       // $columns_one["user"] = "User";
		$columns_two["rating"] = "Rating";
        $columns = $columns_one + $columns_two;
        return $columns;
    });

add_filter( 'manage_comments_custom_column', function($column, $column_id) {
        
		
		if($column == "rating"){
		
		$totalscore = get_comment_meta($column_id, "ratingtotal", true);
		
		if($totalscore != ""){
		
		?>
      
        <div class="rating-score-small">
     
    <strong class="<?php if($totalscore == 0){ ?>bg-primary<?php }else{ echo "rating-color-".number_format($totalscore,0); } ?>"><?php if($totalscore == 0){ echo "-"; }else{ echo number_format($totalscore,1); } ?></strong>
    </div>
        <?php
		
		}
		
		
		}elseif($column == "user"){
		
		
		}
		
		
    },10, 2 );
 
}
	
	
 function save_mycomment_data($comment_content) {
    global $wpdb;
	 
    	$comment_ID = absint($_POST['comment_ID']);
		 
		// SAVE THE CUSTOM PROFILE DATA
		if(isset($_POST['custom']) && is_array($_POST['custom'])){ 	
	
			foreach($_POST['custom'] as $key => $val){
				
					if($val == ""){					
						delete_comment_meta($comment_ID, strip_tags($key));					
					}else{					
						update_comment_meta($comment_ID, strip_tags($key), esc_html(strip_tags($val)));							 			
					}
				} // end foreach
				
			   
				
				$SQL = "UPDATE $wpdb->comments SET comment_content = '".strip_tags($_POST['content'])."' WHERE comment_ID = ".$comment_ID." LIMIT 1";
				$PPO = $wpdb->get_results($SQL,ARRAY_A);
				
				
		}// end if
		
	
	
	}
	
	
 
	// THEME IS ACTIVATED 
	function _theme_activated(){
		 
		add_action('admin_footer', array($this, 'pointer_welcome' ) );
 
	}
	// THEME IS DEACTIBATED
	function _theme_deactivated(){
	
		//add_action('admin_footer', array($this, 'pointer_welcome' ) );
	
		core_admin_01_theme_deactivated();
	}
 
	// THEME HEADER STYLES
	function _admin_head(){ global $pagenow, $CORE, $post;
	
		
		// GLOBAL STYLES 
		wp_enqueue_style("premiumpress-globals", FRAMREWORK_URI.'admin/css/wpglobal.css');	
 
 
 
		switch($pagenow){
			
 
			case "users.php": {
				
				// SET LAST VIEWED TIME
				//update_option('ppt_users_lastviewed', $CORE->DATETIME() );

			} break;
			
			case "term.php": {
				if(isset($_GET['taxonomy']) &&  ($_GET['taxonomy'] == "listing")) { 
				wp_enqueue_style('wn-style', THEME_URI .'/framework/css/backup_css/css.framework.css', array(), '1.0');
				}
			} break;
			case "edit.php": {
				
				// FOR POP-UP EDITORS ON LISTING RESULTS SCREEN
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox'); 
				
				if(isset($_GET['post_type']) && $_GET['post_type'] == "page"){
				
					echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('.wp-heading-inline').append('<a href=\"admin.php?page=design&editpages=1\" class=\"page-title-action\" style=\"margin-left:20px; display:none;   background: #0073aa;    color: #fff;\">Edit Turbobid Pages</a>');
                  });
              </script>"; 
				
				}
				
				if(isset($_GET['post_type']) && $_GET['post_type'] == "listing_type"){
				
					echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('.wp-heading-inline').append('<a href=\"admin.php?page=listings\" class=\"page-title-action\" style=\"margin-left:20px;   background: #0073aa;    color: #fff;\">Edit With RanCoded</a>');
                  });
              </script>"; 
				
				}
				
			
			} break;
			case "theme-install.php":
			case "themes.php": {		
				// ADD IN EXTRAS
				wp_register_script( 'ex1',  FRAMREWORK_URI.'admin/js/extra1.js');
				wp_enqueue_script( 'ex1' );
			} break;
 
			
			default: {
			
  
	  		    // DISPLAY WELCOME POINTER
				if(isset($_GET['firstinstall'])){	
				//wp_enqueue_style( 'wp-pointer' );
				//wp_enqueue_script( 'jquery-ui' );
				//wp_enqueue_script( 'wp-pointer' );
				//wp_enqueue_script( 'utils' );
				//add_action('admin_footer', array($this, 'pointer_intro') );
				}
				 
		 
			} break;
			
		} // END SWITCH
		
		
		 echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('#post').attr('enctype','multipart/form-data');
                  });
              </script>"; 
		
		// REMOVE INVALID TEXT FOR CHILD THEME UPLOADS
		if ( is_admin() && ( isset($_GET['action']) && $_GET['action'] == "upload-theme" )  && $pagenow == 'update.php'  ) { 	
			echo "<style>#wpbody-content p strong { display:none; }</style>";	
		}
		
		// ADD SHORTCODE FOR PAGE OPTIONS
		if( ( isset($_GET['post_type']) && $_GET['post_type'] == "page") || (isset($post->post_type) && $post->post_type == "page" ) ){?>
<script language="javascript">
		function wltpopup(linka){
		tb_show("[WLT] Shortcode List",linka+"TB_iframe=true&height=600&width=900&modal=false", null);
					 return false;
		}
		 
		</script>
<?php }elseif( ( isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type") || (isset($post->post_type) && $post->post_type == THEME_TAXONOMY."_type" ) ){
 
 
        ?>
<script language="javascript">
    jQuery(function(){
 
    <?php if(isset($post->post_status) && $post->post_status == "pending" && !defined('WLT_CART') ){ $ppt_emails = get_option("ppt_emails"); ?>
    jQuery('#titlediv').before('<div id="message" class="updated below-h2" style="padding:10px;"><b style="font-size:18px;line-height:30px;">Listing Pending Approval</b><br /> If you are unhappy with this listing or require the user to provide more information, enter the reasons below;   <br><br><b>Comments:</b><br><textarea name="custom[pending_message]" style="width:100%;height:50px;padding:5px;"><?php echo addslashes(get_post_meta($post->ID,'pending_message',true)); ?></textarea><br> <input type="submit" name="save" id="save-post" value="Save as Pending" class="button" style="margin:20px 0px;"><br /><div class="clear"></div></div>');
    <?php } ?>
    
    });
    </script>
<?php }
			   
			  
	
	}
	// THEME FOOTER STYLES
	function _admin_footer(){ global $pagenow;
	
	 
		
		if($pagenow =="options-general.php"){
		 
		
	 
		}elseif($pagenow == "options-permalink.php" ){  
		
			$default_perm = get_option('premiumpress_custompermalink');
			$default_perm1 = get_option('premiumpress_customcategorypermalink');
			if($default_perm == ""){
			$default_perm = THEME_TAXONOMY;
			}
			if($default_perm1 == ""){
			$default_perm1 = $default_perm."-category";
			}
		  
			echo "<script> 
			jQuery(document).ready(function(){
				jQuery('table.permalink-structure').prepend( '<tr><th><label><input type=\"hidden\" name=\"submitted\" value=\"yes\">PremiumPress Theme</label></th><td> <b> Listing Slug Name</b><br /><input name=\"adminArray[premiumpress_custompermalink]\" type=\"text\" value=\"".$default_perm."\" class=\"regular-text-r code\" style=\"padding:5px !important;margin-top:10px;\"><br><br><b> Category Slug Name</b><br /><input name=\"adminArray[premiumpress_customcategorypermalink]\" type=\"text\" value=\"".$default_perm1."\" class=\"regular-text-r code\" style=\"padding:5px !important;margin-top:10px;\"><br /><br /><p>IMPORTANT. This option will let you change the slug display name from /listing/ to your chosen value however doing so will change all of your existing listing permalinks. <br />This option is not recommend for established website as it will result in many 404 errors for existing listing.</p></td></tr>' );
			});
			</script>";		
			
			
			if(THEME_KEY == "cp"){
			
			$da = get_option('premiumpress_storeslug');	
			if($da == ""){
			$da = "store";
			}
			echo "<script> 
			jQuery(document).ready(function(){
				jQuery('table.permalink-structure').prepend( '<tr><th><label>PremiumPress Stores Slugs</label></th><td> <b> Slug Name</b><br /><input name=\"adminArray[premiumpress_storeslug]\" type=\"text\" value=\"".$da."\" class=\"regular-text-r code\" style=\"padding:5px !important;margin-top:10px;\"><br></td></tr>' );
			});
			</script>";	
			}

		
		}
	}

 
	
	function _admin_menu(){ global $wpdb, $user, $CORE, $menu, $submenu; $userdata = wp_get_current_user(); $license = get_option('ppt_license_key'); 

	
	// ADMIN DISPLAY OPTION
	$DEFAULT_STATUS = "edit_posts"; // <-- SET FOR PERMISSION
	
	if(defined('WLT_DEMOMODE')  && !user_can($userdata->ID, 'administrator') ){
		$DEFAULT_STATUS = "edit_posts";
		$this->_admin_remove_menus();
	}
	 
 	// CHANGE LABEL TO BLOG
    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'All Blog Posts';
    $submenu['edit.php'][10][0] = 'Add Blog Post';	
	
	// HIDE IF THIS IS THE INITIAL SETUP
	
	
	//add_theme_page( 'Child Themes', 'Child Themes',  $DEFAULT_STATUS, 'premiumpresschildthemes', 'theme-install.php?browse=premiumpress', 12 );
  		
		
		add_menu_page('', $CORE->LAYOUT("captions",2),  $DEFAULT_STATUS, 'admin.php?page=listings', "", 'dashicons-editor-ol', '4a');
		
		 
		// SITE OVERVIEW	 
		add_menu_page('', "Turbobid",  $DEFAULT_STATUS, 'premiumpress', array($this, '_admin_page_install' ), get_template_directory_uri() .'/framework/admin/images/premiumpress.png', 4.1);
			 
	 
	  	add_submenu_page('premiumpress', "", '<i class="fal fa-tachometer-alt" style="font-size:12px; margin-right:10px;"></i> '.__("Overview","premiumpress"), $DEFAULT_STATUS, 'premiumpress', array($this, '_admin_overview' ) );
		
		// LISTINGS
		 add_submenu_page('premiumpress', "", '<i class="'.$CORE->LAYOUT("captions","icon").'" style="font-size:12px; margin-right:10px;"></i> '.$CORE->LAYOUT("captions","2"), $DEFAULT_STATUS, 'listings', array($this, '_admin_page_listings' ) );	
		 
		 // LISTING SETTINGS
		 if( $CORE->LAYOUT("captions","listings") ){		
		 add_submenu_page('premiumpress', "", '<i class="fa fa-layer-plus" style="font-size:12px; margin-right:10px;"></i> '.$CORE->LAYOUT("captions","1")." ".__("Setup","premiumpress"), $DEFAULT_STATUS, 'listingsetup', array($this, '_admin_page_listingsetup' ) );			
		}	
		 
		// memberships
		 if( $CORE->LAYOUT("captions","memberships") ){ 
		 add_submenu_page('premiumpress', "", '<i class="fa fa-users-class" style="font-size:12px; margin-right:10px;"></i> '.__("Memberships","premiumpress"), $DEFAULT_STATUS, 'membershipsetup', array($this, '_admin_page_membershipsetup' ) );			
		 
		 }
  
  		// MEMBERS 
		 add_submenu_page('premiumpress', "", '<i class="fal fa-user" style="font-size:12px; margin-right:10px;"></i> '.__("Users","premiumpress"), $DEFAULT_STATUS, 'members', array($this, '_admin_users' ) );		
		
		// SETTINGS
		add_submenu_page('premiumpress', "", '<i class="fa fa-cog" style="font-size:12px; margin-right:10px;"></i> '.__("Settings","premiumpress"), $DEFAULT_STATUS, 'settings', array($this, '_admin_page_settings' ) );	
	 	
		// DESIGN
		add_submenu_page('premiumpress', "", '<i class="fa fa-paint-brush" style="font-size:12px; margin-right:10px;"></i>  '.__("Design","premiumpress"), $DEFAULT_STATUS, 'design', array($this, '_admin_page_design' ) );	
	  	
		// ORDERS
		add_submenu_page('premiumpress', "", '<i class="fa fa-dollar-sign" style="font-size:12px; margin-right:10px;"></i> '.__("Orders","premiumpress"), $DEFAULT_STATUS, 'orders', array($this, '_admin_page_orders' ) );		
		
		
		
		
		
		
		
		// CASHOUT
		if( _ppt(array('user','cashout')) == 1 ){
		add_submenu_page('premiumpress', "", '<i class="fa fa-dollar-sign" style="font-size:12px; margin-right:10px;"></i> '.__("Cashout","premiumpress"), $DEFAULT_STATUS, 'cashout', array($this, '_admin_page_cashout' ) );
		}	
		
		// CASHOUT
		if( _ppt(array('lst','cpcashback')) == 1 ){
		add_submenu_page('premiumpress', "", '<i class="fa fa-sync" style="font-size:12px; margin-right:10px;"></i> '.__("Cashback","premiumpress"), $DEFAULT_STATUS, 'cashback', array($this, '_admin_page_cashback' ) );
		}		

		// EMAIL
		add_submenu_page('premiumpress', "", '<i class="fal fa-envelope" style="font-size:12px; margin-right:10px;"></i> '.__("Email","premiumpress"),  $DEFAULT_STATUS, 'email', array($this, '_admin_page_email') );

		// TOOLS
		/*
		add_submenu_page('premiumpress', "", '<i class="fal fa-wrench" style="font-size:12px; margin-right:10px;"></i>  Toolbox',  $DEFAULT_STATUS, 'tools', array($this, '_admin_page_tools') );
		*/
		if(defined('THEME_KEY') && in_array(THEME_KEY, array("ph"))){
		add_submenu_page('premiumpress', "", '<i class="fal fa-download" style="font-size:12px; margin-right:10px;"></i> '.__("Mass Import","premiumpress"), $DEFAULT_STATUS, 'massimport', array($this, '_admin_page_massimport' ) );		
		}
		
	 	
		// ADVERTISING
		add_submenu_page('premiumpress', "", '<i class="fal fa-bullseye" style="font-size:12px; margin-right:10px;"></i> '.__("Advertising","premiumpress"),  $DEFAULT_STATUS, 'advertising', array($this, '_admin_page_advertising') );
		
		
		
		add_submenu_page('premiumpress', "", '<i class="fal fa-ship" style="font-size:12px; margin-right:10px;"></i> '.__("Checkout","premiumpress"), 		$DEFAULT_STATUS, 'cart', array($this, '_admin_page_cart') );
		 
		 
	
	   // add_submenu_page('premiumpress', "PremiumPress Themes", 'Dashboard', 
		//$DEFAULT_STATUS, '0', array($this, '_admin_page_21' ) );
		
		//if(THEME_KEY == "ph"){
		//add_submenu_page(null, "PremiumPress Themes", 'Mass Import', 
		//$DEFAULT_STATUS, 'massimport', array($this, '_admin_page_massimport') );
		//}
		 
		
		//add_submenu_page('premiumpress', "PremiumPress Themes", 'Payment &amp; Currency', 
		//$DEFAULT_STATUS, '20', array($this, '_admin_page_20') );
		
	
		 
		//add_submenu_page('premiumpress', "PremiumPress Themes", 'Order Manager', 
		//$DEFAULT_STATUS, 'orders', array($this, '_admin_page_orders') ); 		
		
		
 		// REPORTS
		add_submenu_page('premiumpress', "", '<i class="fal fa-signal-alt-3" style="font-size:12px; margin-right:10px;"></i> '.__("Logs","premiumpress"), $DEFAULT_STATUS, 'reports', array($this, '_admin_page_reports' ) );
		
	
		add_submenu_page('premiumpress', "PremiumPress Themes", '<i class="fa fa-book" style="font-size:12px; margin-right:10px;"></i> '.__("Docs","premiumpress"), 
		$DEFAULT_STATUS, 'docs', array($this, '_admin_page_docs') );		

	  add_submenu_page('premiumpress', "PremiumPress Themes", '<i class="fa fa-plug" style="font-size:12px; margin-right:10px;"></i> '.__("Plugins","premiumpress"), 
		$DEFAULT_STATUS, 'plugins', array($this, '_admin_page_plugins') );		
		
// 		 add_submenu_page('premiumpress', "PremiumPress Themes", '<i class="fa fa-smile" style="font-size:12px; margin-right:10px;"></i> '.__("Getting started","premiumpress"), 
// 		$DEFAULT_STATUS, 'getting-started', array($this, '_admin_page_gettingstarted') );	

  

	
	}
	// EXTRA MENU ITEMS FROM PLUGINS
	function _admin_menu_plugins(){
 
		$DEFAULT_STATUS = "activate_plugins";
		// ADD-ON FOR NEW MENU ITEMS
		if(isset($GLOBALS['new_admin_menu']) && is_array($GLOBALS['new_admin_menu']) ){
			$sk = 3.5;
		 
			foreach($GLOBALS['new_admin_menu'] as $newmenu){ 
				foreach($newmenu as $key=>$menu){
					
					if(!isset($menu['link'])){
				
					add_menu_page('', $menu['title'], $DEFAULT_STATUS, $key, $menu['function'],'dashicons-admin-plugins', ''.$sk.'' );
					
					}

					
					$sk = $sk  + 0.1;
				}
			}
		}	
	}
	// TEMPLATE HEADER
	function HEAD($style = 0){
	
	if($style == 1){
	_ppt_template('framework/admin/templates/admin', 'header1' );	
	}else{
	_ppt_template('framework/admin/templates/admin', 'header' );	
	}
	
		
	}
	// LOAD IN TEMPLATE FOOTER	
	function FOOTER($style = 0){	
	if($style == 1){
	_ppt_template('framework/admin/templates/admin', 'footer1' );
	}else{
	_ppt_template('framework/admin/templates/admin', 'footer' );
	}
	}
	
	
	
	// MEMBERS
	function _admin_users() 	{  			include(get_template_directory() . '/framework/admin/_users.php');  }
	
	// TEMPLATE PAGES
	function _admin_overview() 		{  			include(get_template_directory() . '/framework/admin/welcome.php');  }
	function _admin_page_install() 	{  			include(get_template_directory() . '/framework/admin/_install.php');  }
	function _admin_page_settings() 	{  		include(get_template_directory() . '/framework/admin/_settings.php');  }		 
	function _admin_page_email() 	{  			include(get_template_directory() . '/framework/admin/_email.php');  }
	function _admin_page_listings() {  			include(get_template_directory() . '/framework/admin/_listings.php');  }	
	
	function _admin_page_cashout() 	{  			include(get_template_directory() . '/framework/admin/_cashout.php');  }
	function _admin_page_cashback() 	{  			include(get_template_directory() . '/framework/admin/_cashback.php');  }
	
	function _admin_page_orders() 	{  			include(get_template_directory() . '/framework/admin/_orders.php');  }	 
	function _admin_page_reports() 	{  			include(get_template_directory() . '/framework/admin/_reports.php');  }	
	function _admin_page_design() 	{  			include(get_template_directory() . '/framework/admin/_design.php');  }
 	function _admin_page_tools() 	{  			include(get_template_directory() . '/framework/admin/_tools.php');  }
 	function _admin_page_plugins() 	{  			include(get_template_directory() . '/framework/admin/_plugins.php');  }
 	
	function _admin_page_advertising() 	{  			include(get_template_directory() . '/framework/admin/_advertising.php');  }

	function _admin_page_newsletter() 		{  	include(get_template_directory() . '/framework/admin/_newsletter.php');  } 
	function _admin_page_docs() 	{  		include(get_template_directory() . '/framework/admin/_docs.php');  }
	function _admin_page_cart() 		{  		include(get_template_directory() . '/framework/admin/_cart.php');  }
	function _admin_page_customfields() 		{  		include(get_template_directory() . '/framework/admin/_customfields.php');  }
	function _admin_page_massimport() 		{  		include(get_template_directory() . '/framework/admin/_massimport.php');  }
	function _admin_page_membershipsetup() 		{  		include(get_template_directory() . '/framework/admin/_membershipsetup.php');  }
	function _admin_page_listingsetup() 		{  		include(get_template_directory() . '/framework/admin/_listingsetup.php');  }
	
	
	function _admin_page_gettingstarted() 	{  			include(get_template_directory() . '/framework/admin/gettingstarted.php');  }
	
	// MAIN WORDPRESS INIT
	function _init(){	global $CORE, $userdata;
		
		// SWITCH PAGES		
		 
		if(isset($_GET['page']) && user_can($userdata->ID, 'administrator') ){
		
			switch($_GET['page']){
			
				case "premiumpresschildthemes": {
				header("location: ".home_url()."/wp-admin/theme-install.php?browse=premiumpress");
				exit();	
				}
				
				case "13": {
				 		
				if( isset($_POST['runreportnow']) && $_POST['runreportnow'] == "yes"){  $CORE->reports($_POST['date1'],$_POST['date2'],true); }			
				} break;
				
				case "supportcenter": {			
				header("location: https://www.premiumpress.com/forums/?theme="._ppt('template')."&key=".get_option('ppt_license_key'));
				exit();			
				} break; 
				
				case "videotutorials": {						
				header("location: https://www.premiumpress.com/videos/?theme="._ppt('template')."&key=".get_option('ppt_license_key'));
				exit();			
				} break;
				
				case "childthemes": {			
				header("location: http://childthemes.premiumpress.com/?responsive=1&theme="._ppt('template')."&key=".get_option('ppt_license_key'));
				exit();			
				} break;	
				
				case "customizeme": {			
				header("location: ". home_url().'/wp-admin/customize.php?url='. home_url().'/?s=');
				exit();			
				} break;		
			
			}	
		} // end switch
	}
	
 
	// ADMIN INIT
	function _admin_init(){ global $CORE, $wpdb, $userdata, $pagenow, $userdata, $wp_post_types; 
		
		
		// CHECK FOR THEME INSTALLATION
		premiumpress_install_and_reset();
		
		// ON THEME OVERVIEW PAGE		 
		if ( user_can($userdata->ID, 'administrator') && $pagenow == 'themes.php'  ) {
		$CORE->admin_update_child_theme();
		}
		
		// CUSTOM LABEL FOR BLOG
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Blog Manager';
        $labels->singular_name = 'Blog';
		$labels->menu_icon		= ''; 
        $labels->add_new = 'Add Blog';
        $labels->add_new_item = 'Add Blog';
        $labels->edit_item = 'Edit Blog';
        $labels->new_item = 'Blog';
        $labels->view_item = 'View Blog';
        $labels->search_items = 'Search Blog Post';
        $labels->not_found = 'No Blog Post found';
        $labels->not_found_in_trash = 'No Blog Post found in Trash';
		
		
		// FIX FOR ADMIN QUERY
		if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false && $userdata->ID )   { 
		 		
			if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
				
				if( !defined('WLT_DEMOMODE') ){
				
					wp_die(__('Oops! You do not have sufficient permissions to access this page.','premiumpress'));	
				 
					wp_redirect( home_url() );
					exit;
				
				}
			}
			
		}		
	
		// CUSTOM CATEGORY EDITS 
		if( isset($_GET['taxonomy']) && isset($_GET['post_type']) && ( $_GET['post_type'] == THEME_TAXONOMY."_type" ||  $_GET['post_type'] == "post"   ) && $_GET['taxonomy'] != "post_tag" ){			
		
				// Load the pop-up for admin image uploads	
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');				
			 
				add_filter($_GET['taxonomy'].'_edit_form_fields', array( $this, 'my_category_fields'  ) );				 				
				//add_filter( 'manage_edit-'.$_GET['taxonomy'].'_columns', array( $this, 'category_id_head' ) );
				//add_filter( 'manage_'.$_GET['taxonomy'].'_custom_column', array( $this, 'category_id_row' ), 10, 3 );			
		} // end if
		


 		
		
		if(isset($_GET['exportalllistings']) && is_numeric($_GET['exportalllistings']) ){
		 	 
			 global $wpdb;
			// GET ALL CUSTOM FIELDS
			$CFT = $wpdb->get_results("SELECT DISTINCT meta_key FROM ".$wpdb->prefix."postmeta",ARRAY_A);
			$FF = array();	
			foreach($CFT as $k=>$v){		 
				if(substr($v['meta_key'],0,1) == "_"){ // DONT INCLUDE FIELDS THAT BEGIN WITH _		
				}else{		
				$FF[$v['meta_key']] ="";		
				}
			}
			
			// START AND END
			if(isset($_GET['s'])){ $start = $_GET['s']; }else{ $start = 0; }
			if(isset($_GET['e'])){ $end = $_GET['e']; }else{ $end = 1000; }
			
			// GET ALL POSTS
			$allposts = array();
			$SQL = "SELECT * FROM $wpdb->posts WHERE post_type='".THEME_TAXONOMY."_type' LIMIT $start,$end ";
			$PPO = $wpdb->get_results($SQL,ARRAY_A);
			foreach ( $PPO as $dat ){
			
				// CLEAN ANY COLUMNS WE DONT WANT
				unset($dat['comment_count']);	
				unset($dat['post_mime_type']);
				unset($dat['menu_order']);	 
				unset($dat['post_date_gmt']);
				unset($dat['ping_status']);
				unset($dat['post_password']);
				unset($dat['post_name']);
				unset($dat['to_ping']);
				unset($dat['pinged']);
				unset($dat['post_modified']);
				unset($dat['post_modified_gmt']);
				unset($dat['post_content_filtered']);
				unset($dat['post_parent']);
				unset($dat['guid']);
				unset($dat['_edit_last']);
				unset($dat['_wp_page_template']);
				unset($dat['_edit_lock']);
				unset($dat['post_status']);
				unset($dat['comment_status']); 
			 
		
				// GET CATEGORY
				$cs = ""; 
				$categories = get_the_terms($dat['ID'], THEME_TAXONOMY);				
				if(is_array($categories)){foreach($categories as $cat){ $cs .= $cat->name. ","; } }
				$dat['category'] = substr($cs,0,-1); //$category[0]			
 				
				// GET ALL THE POST DATA FOR THIS LISTING
				$cf = get_post_custom($dat['ID']);
				
				 // LOOP THROUGH AND DELETE UNUSED ONES
				 if(is_array($cf)){
				 foreach($cf as $k=>$c){	 	 
					if(substr($k,0,1) == "_"){ unset($cf[$k]); }else{  } 
				  //if( == ""){  }	 // unset($dat[$k]);	 
				 } } 
			 
				 // CLEAN OUT DEFAULT CUSTOM FIELDS WHICH WE DONT WANT
				 unset($cf['_wp_page_template']);
				 unset($cf['_wp_attachment_metadata']);
				 unset($cf['_wp_attached_file']);
				 unset($cf['_wp_trash_meta_status']);
				 unset($cf['_wp_trash_meta_time']);
				 unset($cf['_edit_lock']);
				 unset($cf['_edit_last']);				 
				 unset($cf['post_title']);
				 unset($FF['post_title']);			
				 unset($cf['post_excerpt']);
				 unset($FF['post_excerpt']);				 
				 unset($cf['post_content']);
				 unset($FF['post_content']);
				 unset($cf['id']);
				 
				// ADD ON THE CUSTOM FIELDS TO THE OUTPUT DATA
				if(is_array($FF)){
					 foreach($FF as $key=>$val){
					 if($key == "post_id" || $key == "ID"){ continue; } 
						if(isset($cf[$key])){
						$dat[$key] = $cf[$key][0];
						}else{
						$dat[$key] = "";
						}
					 }
				 } 
				
				// ADD IN SKU
			 	if(!isset($dat['post_id'])){	$dat['post_id'] = $dat['ID'];	}	
		 
				//die(print_r($dat));
				// SAVE DATA INTO ARRAY
				if(strlen(trim($dat['post_title'])) > 2){
				$allposts[] = $dat; 
				}	
			
			}
   			if(is_array($allposts) && !empty($allposts)){
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=CSV-".date('l jS \of F Y h:i:s A')." .csv"); 

			$export = new ppt_csv_export($allposts);
			$export->set_mode(ppt_csv_export::EXPORT_AS_CSV);
			$export->export($export);
			
			echo $export;
			die();
			}else{
			die("<h1>There is no data to export</h1>"."Query run: ".$SQL);
			}
			
		}
 
	 
	 	// EXPORT EMAIL ADDRESSES
		if(isset($_GET['exportall']) && is_numeric($_GET['exportall']) ){
				global $wpdb;
				$csv_output = ''; $ex  = ''; $dont_show_fields = array('autoid','payment_data','');
				
				if($_GET['exportall'] == 1){
					
					$file_name = "mailinglist";	
					$table = $wpdb->prefix."core_mailinglist";	  
					$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_mailinglist";
				
				}elseif($_GET['exportall'] == 2){
							
					$file_name = "orderhistory";		
					$table = $wpdb->prefix."core_orders";	 
					$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_orders GROUP BY order_id ORDER BY order_date";
				 
				}else{
					die("no table set");
				}			
		 
				// RUN QUERIES
				
				$headers = $wpdb->get_results("SHOW COLUMNS FROM ".$table."", ARRAY_A);
				$values = $wpdb->get_results($RUNTHISSQL, ARRAY_N);
				
				// GET HEADERS
				$csv_headers = array();
				if (!empty($headers)) {
					foreach($headers as $row){					
						$csv_headers[] =  $row['Field'];
					}				
				}
				
				// GET VALUES
				$csv_values = array();
				if (!empty($values)) {				
					foreach($values as $k => $row){				 			 
						$csv_values[] =  $row;					
					}				
				}			
				 
				// ADD-ON HEADERS
				foreach($csv_headers as $col_V){
					if(in_array($col_V,$dont_show_fields) ){ continue; }					 
					$csv_output .= str_replace("_"," ",$col_V).",";				 
				}
				
				// NEW LINE				
				$csv_output .= "\n";
				
				// ADD-ON VALUES
				foreach($csv_values as $vv){	
			 
					foreach($vv as $vk => $v){	
						if(in_array($csv_headers[$vk],$dont_show_fields)){ continue; }				 
						$csv_output .= $v.",";					
					}
					$csv_output .= "\n";
				}	 
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private", false);
				header("Content-Type: application/octet-stream");
				header("Content-Disposition: attachment; filename=\"".$file_name.".csv\";" );
				header("Content-Transfer-Encoding: binary");
				echo $csv_output;
				die();
		}  
		
		if(defined('WLT_DEMOMODE')  && !user_can($userdata->ID, 'administrator') ){
		
		$GLOBALS['error_message'] = "Demo Mode - Changes not saved!";
		
		}else{
		
		// ADMIN ACTION
		if(isset($_POST['admin_action']) && strlen($_POST['admin_action']) > 1){	
		 
		 
			switch($_POST['admin_action']){
			
				case "category_import": {
				
				if(strlen($_POST['cat_import']) > 5 ){ 
				
					// DELETE ALL CURRENT CATEGORIES
					if(isset($_POST['deleteall']) && $_POST['deleteall'] == 1){
					
						$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');	 
						$count = count($terms);
						if ( $count > 0 ){
						
							 foreach ( $terms as $term ) {
								wp_delete_term( $term->term_id, THEME_TAXONOMY );
								$_POST['admin_values']['category_icon_'.$term->term_id] = "";
							 }
						 }		  		
						// GET THE CURRENT VALUES
						$existing_values = get_option("core_admin_values");
						// MERGE WITH EXISTING VALUES
						$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
						// UPDATE DATABASE 		
						update_option( "core_admin_values", $new_result);
					
					}
					
					// ADD NEW CATEGORIES
 
 					$cats = explode(PHP_EOL,$_POST['cat_import']);
			 
					if(is_array($cats)){
					
						$taxType = THEME_TAXONOMY; 
						foreach($cats as $catme){ 
						
							// CLEANUP
							$catme = trim($catme);
							
							// SKIP
							if($catme == ""){ continue; }
							
							// CHECK FOR PARENT
							$parent = 0; $isSub = false;  $isSubSub = false;
							if(substr($catme,0,1) == "-" && substr($catme,0,2) != "--" && is_numeric($taxID) ){
								$parent = $taxID;
								$isSub = true;
							}elseif(substr($catme,0,1) == "-" && substr($catme,0,2) == "--" && is_numeric($taxID) ){
								$parent = $lastTaxID;
								$isSubSub = true;
							} 
							
							// REMOVE SLASHES
							$catme = str_replace("-","",$catme);							
							
							// IMPORT
							$termid = _ppt_term_add($catme, 'listing', $parent);	 
							if(is_numeric($termid) ){
								
								if(!$isSub){
								$taxID = $termid;
								}
								if(!$isSubSub){							
								$lastTaxID = $termid;															
								}
								
							}
							
							 
							
						} //end foreach
					}// end if
					
					$GLOBALS['error_message'] = "Category Setup Complete";
				
				
				}
				
				} break;
			
				case "csv_import": {				
				
				set_time_limit(0); 		
			
				if($_POST['csv_key'] == ""){ die("database table missing"); }
				
				if($_POST['deleteall'] == 1){
				
					$wpdb->query("delete a,b,c,d
					FROM ".$wpdb->prefix."posts a
					LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
					LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
					LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
					LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
					WHERE a.post_type ='listing_type'");
				
				}
				
				// GET A LIST OF ALL TAXONOMIES
				$current_taxonomies = get_taxonomies(); 
				 
				$start_num = $_POST['csv_pagenumber'];
				if($start_num > 0){ $start_num = $start_num*100; }
				// STOP IF THE PAGE NUMBER IS GREATER THANK TOTAL
				if( $start_num > $_POST['csv_total']){ die("import completed (".$start_num." = ".$_POST['csv_total'].")"); }
				
					// POST FIELDS
					$post_fields = array('SKU','post_author','post_date','post_date_gmt','post_content','post_title','post_excerpt','post_status',
					'comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_content_filtered',
					'post_parent','guid','menu_order','post_type','post_mime_type','comment_count');	  
					
					// OK LETS LOOP THE TABLE X TIMES THEN 	
					if(isset($_POST['runall'])){
					$QUERYSTRING  = "SELECT * FROM ".$_POST['csv_key']."";
					}else{
					$QUERYSTRING  = "SELECT * FROM ".$_POST['csv_key']." LIMIT ".$start_num.",100";
					}	
					
					  
					$results = $wpdb->get_results($QUERYSTRING, OBJECT);
					if(is_array($results)){
					foreach($results as $new_post){
						
						// IMPORT NEW POST DATA
						$my_post = array(); $my_post['post_excerpt'] = ""; $customdata = array(); $catsarray = array(); $update=false; $category = "";
						
						foreach($new_post as $key=>$val){
							
							switch($key){
								case "ID":
								case "SKU":
								case "sku":
								case "post_id": { 
									// CHECK IF POST EXISTS
									if(!$update && $val != ""){
									
										if($key == "SKU" || $key == "sku"){
										$post_exists = $wpdb->get_row("SELECT ".$wpdb->prefix."postmeta.post_id AS ID FROM ".$wpdb->prefix."postmeta WHERE 
										( meta_value = '" . $val . "' AND meta_key='SKU' OR meta_value = '" . $val . "' AND meta_key='sku' )
										LIMIT 1", 'ARRAY_A');										
										}else{										
										$post_exists = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE ID = '" . $val . "' LIMIT 1", 'ARRAY_A');	
										}
										 						 
										if(isset($post_exists['ID'])){
										  $my_post['ID'] = $post_exists['ID']; 
										  $update = true; 										   									  
										}elseif($key == "SKU"){										
											$customdata["SKU"] = $val; 
										}
									}
								 	$customdata["SKU"] = $val; 
								} break;								 
								case "post_author": { $my_post['post_author'] = $val; } break;
								//case "post_date": { $my_post['post_date'] = $val; } break;
								//case "post_date_gmt": { $my_post['post_date_gmt'] = $val; } break;
								case "post_content": { $my_post['post_content'] = $val; } break;
								case "post_title": { $my_post['post_title'] = $val;  } break;
								case "post_excerpt": { $my_post['post_excerpt'] = $val; } break;
								case "post_status": { $my_post['post_status'] = $val; } break;
								case "comment_status": { $my_post['comment_status'] = $val; } break;
								case "store_logo": { $my_post['store_logo'] = $val; } break;
								case "post_type": { if(strlen($val) > 2){$my_post['post_type'] = $val;}else { $my_post['post_type'] = THEME_TAXONOMY."_type"; } } break;
								case "category1":
								case "category": {
								
									$category = $val;
									
								} break;
								default: { 	
								
								if(in_array($key,$current_taxonomies)){
								
										$vals = explode("|",$val);										
										$catIDArray = array();
										foreach($vals as $val1){
										 	
											// TRIM VALUE
											$val1 = trim($val1);
											// CHECK IF THE CATEGORY ALREADY EXISTS
											if ( term_exists( $val1, $key ) ){
												$term = get_term_by('name', str_replace("_"," ",$val1), $key);										 
												$catID = $term->term_id;												
											}else{										
												$args = array('cat_name' => str_replace("_"," ",$val1) ); 
												$term = wp_insert_term(str_replace("_"," ",$val1), $key, $args); 
																							
												if(is_array($term) && isset($term['term_id']) && !isset($term['errors'][0]) ){
													$catID = $term['term_id'];
												}elseif(isset($term->term_id)){
													$catID = $term->term_id;
												}					 
											}
											
											// SAVE ID
											if(is_numeric($catID)){
											$catIDArray[] = $catID;
											}										
										}
										 
										$taxarray[$key] = $catIDArray;
								
								}else{
									$customdata[$key] = $val;								
								}
								 
								
								 } break;
							
							}// end switch				
						}// end foreach
						
							
						// CHECK IF NOT SET
						if(!isset($my_post['post_type'])){
						$my_post['post_type'] 		= THEME_TAXONOMY."_type";
						}
						 
						
						// SET POST STATUS
						if(!isset($my_post['post_status'])){
						$my_post['post_status'] = "publish";
						}
						
						// WORK ON CUSTOM ENCODING						
						if(function_exists('utf8_encode')){ 
							$np = array();
							foreach($my_post as $key=>$val){
								if(is_string($val)){
									if(function_exists('mb_convert_encoding')){									
										$np[$key] = mb_convert_encoding($val, CSV_IMPORT_ENCODING(),'auto');
									}else{
										$np[$key] = utf8_encode($val);
									}								 
								}else{
									$np[$key] = $val;
								}
								
							}
							$my_post = $np;
						}
						
						// ADD OR UPDATE ISTING
						if($update){
						$POSTID = wp_update_post( $my_post );
						}else{
						$POSTID = wp_insert_post( $my_post );
						}
						
						// SAVE CATEGORY
						if(strlen($category) > 1 ){
							$cats = explode("|",$category);
							foreach($cats as $catname){
								$termid = _ppt_term_add($catname, 'listing');	 
								if(is_numeric($termid)){									 
									wp_set_post_terms( $POSTID, $termid, 'listing' );	
								}	
							}						
						}
						
						// SAVE ANY CUSTOM TAXONOMIES
						if(is_array($taxarray)){				 
							foreach($taxarray as $k=>$v){
								wp_set_post_terms( $POSTID, $v, $k, true);
							}
						} 
						
						// SET POST CATEGOIRY FOR POST TYPE
						if(is_array($catsarray) && !empty($catsarray)){
						wp_set_post_terms( $POSTID, $catsarray, THEME_TAXONOMY );
						}	
						 
										
						// NOW ADD IN THE CUSTOM FIELDS
						if(is_array($customdata)){
							foreach($customdata as $key=>$val){
								update_post_meta($POSTID,$key,$val);
							}
						}
						
						// EXTRA FOR STORE LOGO
						if (taxonomy_exists('store') && isset($taxarray['store'])){
						 
							$_POST['admin_values']['category_icon_'.$taxarray['store']] = $my_post['store_logo'];			
							// GET THE CURRENT VALUES
							$existing_values = get_option("core_admin_values");
							// MERGE WITH EXISTING VALUES
							$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
							// UPDATE DATABASE 		
							update_option( "core_admin_values", $new_result);
						}															 
							
					}// forwach loop
				}
				
				$GLOBALS['error_message'] = "Import Completed Successfully";
			
				} break;
				
				case "csv_savetables": {
				
					foreach($_POST['table1'] as $key=>$val){
	
						if($val != $_POST['table2'][$key]){
						
							$SQL = "ALTER TABLE ".$_POST['database_table']." CHANGE  `".$val."`  `".$_POST['table2'][$key]."` TEXT";
						 
							mysql_query($SQL); // CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL
						
							$GLOBALS['error_message'] = "Table Changes Completed";
						}
					}
				 
				} break;
			
				case "csv_upload": {
								
				
					  $csv = new ppt_csv_import();
					 
					  // UPLOAD THE FILE FIRST TO THE SERVER
					  $uploads = wp_upload_dir();  
					  copy($_FILES['file_source']['tmp_name'], $uploads['path']."/".$_FILES['file_source']['name']);
					
					  // IF ITS COMPRESSED, UNZIP IT
					  $lastthree = substr($_FILES['file_source']['name'],-3);
					  if($lastthree == ".gz" || $lastthree == "zip"){
							$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
							require $dir_path . "/wp-admin/includes/file.php";
							WP_Filesystem();
							$zipresult = unzip_file( $uploads['path']."/".$_FILES['file_source']['name'], $uploads['path']."/unzipped/" );
							if ( is_wp_error($zipresult)){
								echo "<h1>The file could not be extracted.</h1><hr>";
								print_r($zipresult);
								die();
							 }else{		 	
								// READ THE FOLDER TO GET THE FILENAME THEN REMOVE THE FOLDER
								if ($handle = opendir($uploads['path']."/unzipped/")) {
									while (false !== ($entry = readdir($handle))) {
										if ($entry != "." && $entry != ".." && ( substr($entry,-4) == ".csv" || substr($entry,-4) == ".txt") ) {
											$unzippedfilename = $entry;
										}
									}
									closedir($handle);
								}
								
								// CHECK WE FOUD IT
								if(!isset($unzippedfilename)){
								die("The file could not be extracted and found.");			
								}else{
								
									copy($uploads['path']."/unzipped/".$unzippedfilename, $uploads['path']."/".$unzippedfilename);				
									$csv->file_name = $uploads['path']."/".$unzippedfilename;
									// DELETE THE ZIP FOLDER AND FILE
									unlink($uploads['path']."/unzipped/".$unzippedfilename);
									unlink($uploads['path']."/".$_FILES['file_source']['name']);
									rmdir($uploads['path']."/unzipped/");				
								}			
							 
							 }		 
					  }else{
					  
						$csv->file_name 				= $uploads['path']."/".$_FILES['file_source']['name'];  
					  
					  }
					  
					  //optional parameters
					  $csv->use_csv_header 			= isset($_POST["use_csv_header"]);
					  $csv->field_separate_char 	= $_POST["field_separate_char"][0];
					  $csv->field_enclose_char 		= $_POST["field_enclose_char"][0];
					  $csv->field_escape_char 		= $_POST["field_escape_char"][0];
					  $csv->encoding 				= CSV_IMPORT_ENCODING();
					   
						//start import now
						$database = $csv->import();	
						$countrows = $csv->countrows($database);
					 
						$new_values = array();
						$new_values[$database] = $countrows;  
						// GET THE CURRENT VALUES
						$existing_values = get_option("ppt_csv");
						// MERGE WITH EXISTING VALUES
						$new_result = array_merge((array)$existing_values, (array)$new_values);
						// UPDATE DATABASE 		
						update_option( "ppt_csv", $new_result);
						// CLEAN UP
						@unlink($csv->file_name);
						// LEAVE FRIENDLY MESSAGE
						$GLOBALS['error_message'] = "CSV Uploaded Successfully";
	
				} break;
			
				case "csv_delete": {
			
								
					// GET THE CURRENT VALUES
					$existing_values = get_option("ppt_csv");
					unset($existing_values[$_POST['csvid']]);		
					// UPDATE DATABASE 		
					update_option( "ppt_csv", $existing_values);
					
					// REMOVE FILE NAME FROM LIST
					$csv_files = get_option("ppt_csv_filenames");
					if(!is_array($csv_files)){ $csv_files = array(); }
					unset($csv_files[$_POST['csvid']]);
					update_option("ppt_csv_filenames", $csv_files);
					
					// DELETE DATABASE TABLE
					$wpdb->query("DROP TABLE IF EXISTS ".$_POST['csvid']);	
	
					// LEAVE FRIENDLY MESSAGE
					$GLOBALS['error_message'] = "Deleted Successfully";
					
				} break;
			
			}// end switch		
		
		// SAVE ADMIN DATA
		}elseif(isset($_POST['submitted']) && $_POST['submitted'] == "yes"  ){
		
		 
				// GET OLD OPTIONS
				$new_result = array();
				$existing_values = $CORE->ppt_core_settings;
				
				 
		 		if(isset($_POST['admin_values'])){	
				 
					// MERGE WITH EXISTING VALUES					 
					$new_result = $this->clean_array_merge((array)$existing_values, (array)$_POST['admin_values']);
					
				 
					// CLEANUP ARRAY
					if( is_array($new_result)){
						foreach($new_result as $c => $cc){
						
							if(is_numeric($c) || $cc == ""){
								unset($new_result[$c]);
							}
						}
					}
					
					//print_r($_POST['cleardatastrings']);
					
					// CLEARUP ONE
					if(isset($_POST['cleardatastrings']) && strlen($_POST['cleardatastrings']) > 5){
						$cb = explode(",",$_POST['cleardatastrings']);
						if(is_array($cb) && !empty($cb)){
							foreach($cb as $h){
								
								if($h != "undefined"){
								 
									$nh = str_replace("]","", str_replace("][",",", str_replace("admin_values[", "", $h)));
									$gb = explode(",", $nh);
									if(is_array($gb) && !empty($gb) && isset($gb[1])){
									
										unset($new_result[$gb[0]][$gb[1]]);
										
									}else{
									
									unset($new_result[$gb[0]]);
									}
								
								}
								
							}
						}					
					}
					
					//die(print_r($new_result));
					
				 
					 	
					// UPDATE DATABASE 		
					update_option( "core_admin_values", $new_result, true);
					
					
					
					 
					// LEAVE MESSAGE
					$GLOBALS['ppt_error'] = array(
						"type" 		=> "success",
						"title" 	=> "Settings Updated",
						"message"	=> "Your changes have been saved.",
					); 
					
				} 
				
				// SAVE EXTRA DATA
				if(isset($_POST['adminArray'])){
		 
					$update_options = $_POST['adminArray']; 
					 
					foreach($update_options as $key => $value){
						if(is_array($value)){			 
							update_option( trim($key), $value, true);			 
						}else{ 		
							update_option( trim($key), trim($value), true);
						}		
					}
				
				}
				
				// NOW UPDATE THE OPTIONS
				$GLOBALS['CORE_THEME'] = $new_result;
				
				
				
				// NEW INSTALL REDIRECT
				if(isset($_POST['newinstall']) && $_POST['newinstall'] == "premiumpress"){				
				header("location: ".get_home_url().'/wp-admin/admin.php?page=getting-started');
				exit();
				} 
				 					
			}// END SAVE ADMIN OPTION	
			
			
	} // end if is admin demo mode	
			
				
	}	
	
	
	function clean_array_merge($old, $new){
	 
		$na = array();
		
		$na = array_merge($old, $new);		
		
		foreach($old as $k => $v) {
			
			
			// FIX FOR DESIGN CHANGES
			if( (in_array($k, array("home")) || substr($k,0,5) == "page_" ) && isset($old[$k]) && isset($new[$k]) ){
			
				$na[$k]	= array_merge($old[$k], $new[$k]);		
			 		
			
			}
		 
		}
		  
		return $na;	
	
	}
 	
	
	// REMOVE MENU ITEMS FROM ADMIN 
	function _admin_remove_menus() {
		global $menu;
			$restricted = array('Dashboard','Media','Links','Appearance','Tools','Settings','Comments','Plugins','Tools');
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
	}
	
	
	// POINTERS FOR INSTALLATION
	function pointer_welcome(){
			global $CORE_ADMIN;	
			
			wp_enqueue_script( 'jquery' );
 			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'jquery-ui' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
			 	
			if(defined('PPT_CHILDTHEME')){
			
			$id      = 'li.toplevel_page_premiumpress';
			$content = '<h3>' . 'Child Theme Activated' . '</h3>';
			$content .= '<p>' .  '<b>Awesome!</b> You\'ve just activated your new child theme. Now let\'s begin setting it up!' . '</p>';
			$opt_arr  = array(
						'content'  => $content,
						'position' => array( 'edge' => 'top', 'align' => 'center' )
					);
			$button2  =  "Begin Setup";
			
			if(defined('NOHOMEPAGECONTENT') || defined('WLT_ELEMENTOR_AUTO_INSTALL') ){
			$function = 'document.location="' . admin_url( 'admin.php?page=design&tab=tab-pagebuilder&autosetup=1' ) . '";';
			}else{
			$function = 'document.location="' . admin_url( 'admin.php?page=design' ) . '";';
			}
			}else{
		 		 
			$id      = 'li.toplevel_page_premiumpress';
			$content = '<h3>' . 'Congratulations!' . '</h3>';
			$content .= '<p>' .  'You\'ve just activated your PremiumPress theme.' . '</p>';
			$opt_arr  = array(
						'content'  => $content,
						'position' => array( 'edge' => 'top', 'align' => 'center' )
					);
			$button2  =  "Begin Setup";
			$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
			
			}
			
			$this->print_scripts( $id, $opt_arr, "Close", $button2, $function );
			
	}
	function pointer_intro(){
			global $CORE_ADMIN;
			
			$id      = '#gotobtn';
			$content = '<h3>' .'Remember!'. '</h3>';
			$content .= '<p>' . 'Watch the video tutorial first then click here!' . '</p>';
			$opt_arr  = array(
						'content'  => $content,
						'position' => array( 'edge' => 'top', 'align' => 'center' )
					);
			$button2  = "123";
			$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
	 
			
			$this->print_scripts( $id, $opt_arr, "Close", $button2, $function );
			
	}	
	function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '' ) {
			?>
<script >
			//<![CDATA[
			(function ($) {
				var premiumpress_pointer_options = <?php echo json_encode( $options ); ?>, setup;
	 
				premiumpress_pointer_options = $.extend(premiumpress_pointer_options, {
					buttons:function (event, t) {
						button = jQuery('<a id="pointer-close" style="margin-left:5px" class="button-secondary">' + '<?php echo $button1; ?>' + '</a>');
						button.bind('click.pointer', function () {
							t.element.pointer('close');
						});
						return button;
					},
					close:function () {
					}
				});
	
				setup = function () {
					$('<?php echo $selector; ?>').pointer(premiumpress_pointer_options).pointer('open');
					<?php if ( $button2 ) { ?>
						jQuery('#pointer-close').after('<a id="pointer-primary" class="button-primary">' + '<?php echo $button2; ?>' + '</a>');
						jQuery('#pointer-primary').click(function () {
							<?php echo $button2_function; ?>
						});
						jQuery('#pointer-close').click(function () {
							<?php if ( $button1_function == '' ) { ?>
								//premiumpress_setIgnore("tour", "wp-pointer-0", "<?php echo wp_create_nonce( 'premiumpress-ignore' ); ?>");
								<?php } else { ?>
								<?php echo $button1_function; ?>
								<?php } ?>
						});
						<?php } ?>
				};
	
				if (premiumpress_pointer_options.position && premiumpress_pointer_options.position.defer_loading)
					$(window).bind('load.wp-pointers', setup);
				else
					$(document).ready(setup);
			})(jQuery);
			//]]>
		</script>
<?php
	}
 	
	
// FUNCTION CALLED WHEN SAVING THE ICON
	function ppt_update_icon_field($term_id) {
		 
		if(isset($_POST['caticon'])){		   
		   
		    if( isset($_POST['storeimage'])  ){
			 
			 	$_POST['admin_values']['storeimage_'.$term_id] = strip_tags($_POST['storeimage']);					 
		    	$_POST['admin_values']['storelink_'.$term_id] = strip_tags($_POST['storelink']);	
				$_POST['admin_values']['storelinkaff_'.$term_id] = strip_tags($_POST['storelinkaff']);
				 
		    }
			
			if( isset($_POST['catimage'])  ){
			 
			 	$_POST['admin_values']['category_image_'.$term_id] = strip_tags($_POST['catimage']);	
				 
		    }
			 
			$_POST['admin_values']['category_icon_small_'.$term_id] = strip_tags($_POST['caticon']);
			
						
			$_POST['admin_values']['category_description_'.$term_id] = stripslashes($_POST['cat_desc_big']);
			 
			
			// CAT TRANSLATIONS
			if(isset($_POST['category_translation'])){			
				$na = array();				
				$ct = _ppt('category_translation');			
				if(is_array($ct)){ 
					foreach($ct as $k => $v){
					
						foreach($v as $k1 => $v1){
						
							$na[$k][$k1] = $v1;
						}
						
					}
				}
				
				foreach($_POST['category_translation'] as $k => $v){
				
					foreach($v as $k1 => $v1){
					
						$na[$k][$k1] = $v1;
					}
					
				}
				
										 
				$_POST['admin_values']['category_translation'] = $na; 
			}
			
			 
			// GET THE CURRENT VALUES		 
			if(!isset($GLOBALS['CORE_THEME'])){
				$existing_values = get_option("core_admin_values");
			}else{
				$existing_values = $GLOBALS['CORE_THEME']; //get_option("core_admin_values");
			}
			// MERGE WITH EXISTING VALUES
			$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
			// UPDATE DATABASE 		
			update_option( "core_admin_values", $new_result, true);
			 
		} // end if
	}	
	
	// FUNCTION ADDS THE CATEGORY ICON TO THE ADMIN VIEW
	function category_id_head( $columns ) {		 
		//unset($columns['title']);	 
		unset($columns['description']);
		unset($columns['slug']);	
    	$columns['icon'] = 'Icon';		 
		$columns['id'] = 'ID';		 
    	return $columns;
		
	}	
	
	// FUNCTION ADDS IN AN EXTRA FIELD TO THE CATEGORY CREATION SO YOU CAN
	function category_id_row( $output, $column, $term_id ){
	
		global $wpdb; $icon ="";
 
		if( $column == 'id'){
		
			return $term_id;
		
		}elseif( $column == 'description'){
		
			return strip_tags(substr($output,0,100));
		
		}elseif( $column == 'icon'){	
			
			if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$term_id])){
				return $GLOBALS['CORE_THEME']['category_icon_small_'.$term_id];
			}else{
				$imgPath = "";
			}
			
			  
			return $imgPath;
		
		}else{
		
			return $output;
		
		}
	 
	}
	function my_category_fields($tag) { global $wpdb, $CORE;
	
		// LOAD IN MAIN DEFAULTS
		$core_admin_values = get_option("core_admin_values"); 
		
		?><input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script>
			
			function changefaicon(faicon){
			
			jQuery('#caticon').val(faicon);
			jQuery(this).css('border:1px solid red');
			
			}
			
			function ChangeImgBlock(divname){ document.getElementById("imgIdblock").value = divname; }

            function ChangeCatIcon(id){	
			
				window.send_to_editor = function(html) {
				
					var regex = /src="(.+?)"/;
					var rslt =html.match(regex);
					var imgurl = rslt[1];
				 
				 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
				 tb_remove();
				} 
			
				if(id == 2){
				
					ChangeImgBlock('caticon2');
					formfield = jQuery('#caticon2').attr('name');
					
				}else if(id == 3){
					ChangeImgBlock('caticon3');
					formfield = jQuery('#caticon3').attr('name');
				
				
				}else if(id == 4){
					ChangeImgBlock('storeimage');
					formfield = jQuery('#storeimage').attr('name');
				 
				}else if(id == 5){
					ChangeImgBlock('catimage');
					formfield = jQuery('#catimage').attr('name');
				  
				 
				} else {
					ChangeImgBlock('caticon');
					formfield = jQuery('#caticon').attr('name');
				}
				 
				 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				 return false;             
            }
			
			jQuery(document).ready(function() {			 
						
			jQuery('.term-description-wrap label').html('Small Description');
			
			});
            
            </script>
<script> var ajax_site_url = "<?php echo home_url(); ?>/"; </script>
 
<table class="form-table">
 
  <tr class="form-field">
    <th> <label>Big Description</label>
    </th>
    <td><div>
      
        <?php
		
		$content = "";
		if(isset($core_admin_values['category_description_'.$_GET['tag_ID']])){
		$content = $core_admin_values['category_description_'.$_GET['tag_ID']];
		} 
		
		$settings = array( 'media_buttons' => true,  "editor_height" => 300, 'textarea_name' => 'cat_desc_big' );
        wp_editor( $content, 'message', $settings ); 
        
        ?>
        <p>This description is displayed at the bottom of the search page.</p>
      </div></td>
  </tr>
 

  <tr class="form-field">
  
  
  
  
  <?php if(THEME_KEY == "pj" && isset($_GET['taxonomy']) && $_GET['taxonomy'] == "listing"){ ?>
      <th scope="row" valign="top"><label>Category Image </label></th>
       
       <td><input name="catimage" id="catimage" type="text" size="40" aria-required="false" value="<?php echo _ppt('category_image_'.$_GET['tag_ID']); ?>" />                        
          <input type="button" size="36" name="upload_category_image" value="Upload Image" onclick="ChangeCatIcon(5);" class="button" style="width:100px;"> 
                       
                         
                        <?php if(_ppt('category_image_'.$_GET['tag_ID']) != ""){ ?>
                        <div style="background:#efefef;border:1px solid #ddd; padding:20px; margin-top:20px;">
                       
                       
                       <img src="<?php echo _ppt('category_image_'.$_GET['tag_ID']); ?>" class="img-fluid" style="max-width:500px; max-height:600px; "/>
                        </div>
                        <?php } ?>
                        
                       </td>
                    </tr>
  
  
  <?php } ?>
  
  
  
  
  
  
  
  
  
  
  
    <?php if(isset($_GET['taxonomy']) && $_GET['taxonomy'] == "store"){ ?>
    
    
      <th scope="row" valign="top"><label>Store Logo </label></th>
                        <td><input name="storeimage" id="storeimage" type="text" size="40" aria-required="false" value="<?php echo _ppt('storeimage_'.$_GET['tag_ID']); ?>" />                        
                       <input type="button" size="36" name="upload_storeimage" value="Upload Image" onclick="ChangeCatIcon(4);" class="button" style="width:100px;"> 
                       
                       <p class="description">The image is not prominent by default; however, some themes may show it.</p>                   
                        
                        <?php if(_ppt('storeimage_'.$_GET['tag_ID']) != ""){ ?>
                        <div style="background:#efefef;border:1px solid #ddd; padding:20px; margin-top:20px;">
                       
                       
                       <img src="<?php echo _ppt('storeimage_'.$_GET['tag_ID']); ?>" class="img-fluid" style="max-width:500px; max-height:600px; "/>
                        </div>
                        <?php } ?>
                        
                       </td>
                    </tr>
    
    <th scope="row" valign="top"><label>Store Link</label></th>
    <td><input name="storelink" type="text" size="40" style="width:300px;" value="<?php if(isset($core_admin_values['storelink_'.$_GET['tag_ID']])){ echo $core_admin_values['storelink_'.$_GET['tag_ID']]; } ?>" />
      <small class="clearfix">e.g: http://google.com</small> </td>
  </tr>
  <th scope="row" valign="top"><label>Store Affiliate Link</label></th>
    <td><input name="storelinkaff" type="text" size="40" style="width:300px;" value="<?php if(isset($core_admin_values['storelinkaff_'.$_GET['tag_ID']])){ echo $core_admin_values['storelinkaff_'.$_GET['tag_ID']]; } ?>" />
      <small class="clearfix">e.g: http://google.com/?myaffiliatelink=123</small> </td>
  </tr>
  <?php } ?>
  
  
  
  
  
<?php

		$langs = _ppt('languages');
	  
	if(is_array($langs) && count($langs) > 1 ){ 
	
	
	$catTrans = _ppt('category_translation');

	
	?>
             <tr class="form-field">
             
             <th>
             <label>Translations</label>
             
             </th>
             
             <td>
             
 <link rel="stylesheet" href="<?php echo FRAMREWORK_URI; ?>css/_plugins.css" media="screen" />


	<?php 
	 foreach(_ppt('languages') as $lang){
			
			$icon = explode("_",$lang); 
			
			if(isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
			
			
			// icon
			$icon = explode("_",$lang);			
			if(isset($icon[1])){ $icon = "flag flag-".strtolower($icon[1]); }else{ $icon = "flag flag-".$icon[0]; }  
			 		
			// array
			$clist[] = array(						
					"name" 		=> $CORE->GEO("get_lang_name", $lang),
					"icon" 		=> $icon,
					"link" 		=> home_url()."/?l=".$lang,
			);
	
	 
	?>
 
 <div style="margin-bottom:10px;">
 
 
    <label style="margin-bottom:10px;"><div class="flag flag-<?php echo $icon; ?>">&nbsp;</div> <?php echo $CORE->GEO("get_lang_name", $lang); ?></label>
  
    
    <input placeholder="title here.."  style="margin-top:10px;" type="text" id="cat_trans_<?php echo strtolower($lang); ?>"
    name="category_translation[<?php echo strtolower($lang); ?>][<?php echo esc_attr($_GET['tag_ID']); ?>]"
    value="<?php if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$_GET['tag_ID']]) ){ echo stripslashes($catTrans[strtolower($lang)][$_GET['tag_ID']]); } ?>" />

 
    <textarea placeholder="description here.."   style="margin-top:20px;"  id="cat_trans_<?php echo strtolower($lang); ?>_desc"
    name="category_translation[<?php echo strtolower($lang); ?>][<?php echo esc_attr($_GET['tag_ID']); ?>_desc]"><?php if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$_GET['tag_ID']."_desc"]) ){ 
	
	echo stripslashes($catTrans[strtolower($lang)][$_GET['tag_ID']."_desc"]); } ?></textarea>



</div>
	<?php }  ?>
    
             
             
             
             </td>
             
             </tr>
<?php } ?>
  
  
  
  
  
  
  
  <tr class="form-field">
    <th scope="row" valign="top"><label>Text Icon</label>
    </th>
    <td><input name="caticon" id="caticon" type="text" size="40" style="width:300px;" aria-required="false" value="<?php if(isset($core_admin_values['category_icon_small_'.$_GET['tag_ID']])){ echo $core_admin_values['category_icon_small_'.$_GET['tag_ID']]; } ?>" />
      <a href="javascript:void(0);" onclick="jQuery('#showfaicons').toggle();" class="button">View Icons</a>
      <p class="description">The icon is not prominent by default; however, some themes may show it.</p>
      <div id="showfaicons" style="display:none;">
        <hr />
        <link rel="stylesheet" href="<?php echo FRAMREWORK_URI; ?>css/_fontawesome.css" media="screen" />
        <?php
		$font_awesome_icons = array (
        'fab fa-500px' =>  '500px',
        'fab fa-accessible-icon' =>  'accessible-icon',
        'fab fa-accusoft' =>  'accusoft',
        'fa fa-address-book' =>  'address-book',
        'far fa-address-book' =>  'address-book',
        'fa fa-address-card' =>  'address-card',
        'far fa-address-card' =>  'address-card',
        'fa fa-adjust' =>  'adjust',
        'fab fa-adn' =>  'adn',
        'fab fa-adversal' =>  'adversal',
        'fab fa-affiliatetheme' =>  'affiliatetheme',
        'fab fa-algolia' =>  'algolia',
        'fa fa-align-center' =>  'align-center',
        'fa fa-align-justify' =>  'align-justify',
        'fa fa-align-left' =>  'align-left',
        'fa fa-align-right' =>  'align-right',
        'fa fa-allergies' =>  'allergies',
        'fab fa-amazon' =>  'amazon',
        'fab fa-amazon-pay' =>  'amazon-pay',
        'fa fa-ambulance' =>  'ambulance',
        'fa fa-american-sign-language-interpreting' =>  'american-sign-language-interpreting',
        'fab fa-amilia' =>  'amilia',
        'fa fa-anchor' =>  'anchor',
        'fab fa-android' =>  'android',
        'fab fa-angellist' =>  'angellist',
        'fa fa-angle-double-down' =>  'angle-double-down',
        'fa fa-angle-double-left' =>  'angle-double-left',
        'fa fa-angle-double-right' =>  'angle-double-right',
        'fa fa-angle-double-up' =>  'angle-double-up',
        'fa fa-angle-down' =>  'angle-down',
        'fa fa-angle-left' =>  'angle-left',
        'fa fa-angle-right' =>  'angle-right',
        'fa fa-angle-up' =>  'angle-up',
        'fab fa-angrycreative' =>  'angrycreative',
        'fab fa-angular' =>  'angular',
        'fab fa-app-store' =>  'app-store',
        'fab fa-app-store-ios' =>  'app-store-ios',
        'fab fa-apper' =>  'apper',
        'fab fa-apple' =>  'apple',
        'fab fa-apple-pay' =>  'apple-pay',
        'fa fa-archive' =>  'archive',
        'fa fa-arrow-alt-circle-down' =>  'arrow-alt-circle-down',
        'far fa-arrow-alt-circle-down' =>  'arrow-alt-circle-down',
        'fa fa-arrow-alt-circle-left' =>  'arrow-alt-circle-left',
        'far fa-arrow-alt-circle-left' =>  'arrow-alt-circle-left',
        'fa fa-arrow-alt-circle-right' =>  'arrow-alt-circle-right',
        'far fa-arrow-alt-circle-right' =>  'arrow-alt-circle-right',
        'fa fa-arrow-alt-circle-up' =>  'arrow-alt-circle-up',
        'far fa-arrow-alt-circle-up' =>  'arrow-alt-circle-up',
        'fa fa-arrow-circle-down' =>  'arrow-circle-down',
        'fa fa-arrow-circle-left' =>  'arrow-circle-left',
        'fa fa-arrow-circle-right' =>  'arrow-circle-right',
        'fa fa-arrow-circle-up' =>  'arrow-circle-up',
        'fa fa-arrow-down' =>  'arrow-down',
        'fa fa-arrow-left' =>  'arrow-left',
        'fa fa-arrow-right' =>  'arrow-right',
        'fa fa-arrow-up' =>  'arrow-up',
        'fa fa-arrows-alt' =>  'arrows-alt',
        'fa fa-arrows-alt-h' =>  'arrows-alt-h',
        'fa fa-arrows-alt-v' =>  'arrows-alt-v',
        'fa fa-assistive-listening-systems' =>  'assistive-listening-systems',
        'fa fa-asterisk' =>  'asterisk',
        'fab fa-asymmetrik' =>  'asymmetrik',
        'fa fa-at' =>  'at',
        'fab fa-audible' =>  'audible',
        'fa fa-audio-description' =>  'audio-description',
        'fab fa-autoprefixer' =>  'autoprefixer',
        'fab fa-avianex' =>  'avianex',
        'fab fa-aviato' =>  'aviato',
        'fab fa-aws' =>  'aws',
        'fa fa-backward' =>  'backward',
        'fa fa-balance-scale' =>  'balance-scale',
        'fa fa-ban' =>  'ban',
        'fa fa-band-aid' =>  'band-aid',
        'fab fa-bandcamp' =>  'bandcamp',
        'fa fa-barcode' =>  'barcode',
        'fa fa-bars' =>  'bars',
        'fa fa-baseball-ball' =>  'baseball-ball',
        'fa fa-basketball-ball' =>  'basketball-ball',
        'fa fa-bath' =>  'bath',
        'fa fa-battery-empty' =>  'battery-empty',
        'fa fa-battery-full' =>  'battery-full',
        'fa fa-battery-half' =>  'battery-half',
        'fa fa-battery-quarter' =>  'battery-quarter',
        'fa fa-battery-three-quarters' =>  'battery-three-quarters',
        'fa fa-bed' =>  'bed',
        'fa fa-beer' =>  'beer',
        'fab fa-behance' =>  'behance',
        'fab fa-behance-square' =>  'behance-square',
        'fa fa-bell' =>  'bell',
        'far fa-bell' =>  'bell',
        'fa fa-bell-slash' =>  'bell-slash',
        'far fa-bell-slash' =>  'bell-slash',
        'fa fa-bicycle' =>  'bicycle',
        'fab fa-bimobject' =>  'bimobject',
        'fa fa-binoculars' =>  'binoculars',
        'fa fa-birthday-cake' =>  'birthday-cake',
        'fab fa-bitbucket' =>  'bitbucket',
        'fab fa-bitcoin' =>  'bitcoin',
        'fab fa-bity' =>  'bity',
        'fab fa-black-tie' =>  'black-tie',
        'fab fa-blackberry' =>  'blackberry',
        'fa fa-blind' =>  'blind',
        'fab fa-blogger' =>  'blogger',
        'fab fa-blogger-b' =>  'blogger-b',
        'fab fa-bluetooth' =>  'bluetooth',
        'fab fa-bluetooth-b' =>  'bluetooth-b',
        'fa fa-bold' =>  'bold',
        'fa fa-bolt' =>  'bolt',
        'fa fa-bomb' =>  'bomb',
        'fa fa-book' =>  'book',
        'fa fa-bookmark' =>  'bookmark',
        'far fa-bookmark' =>  'bookmark',
        'fa fa-bowling-ball' =>  'bowling-ball',
        'fa fa-box' =>  'box',
        'fa fa-box-open' =>  'box-open',
        'fa fa-boxes' =>  'boxes',
        'fa fa-braille' =>  'braille',
        'fa fa-briefcase' =>  'briefcase',
        'fa fa-briefcase-medical' =>  'briefcase-medical',
        'fab fa-btc' =>  'btc',
        'fa fa-bug' =>  'bug',
        'fa fa-building' =>  'building',
        'far fa-building' =>  'building',
        'fa fa-bullhorn' =>  'bullhorn',
        'fa fa-bullseye' =>  'bullseye',
        'fa fa-burn' =>  'burn',
        'fab fa-buromobelexperte' =>  'buromobelexperte',
        'fa fa-bus' =>  'bus',
        'fab fa-buysellads' =>  'buysellads',
        'fa fa-calculator' =>  'calculator',
        'fa fa-calendar' =>  'calendar',
        'far fa-calendar' =>  'calendar',
        'fa fa-calendar-alt' =>  'calendar-alt',
        'far fa-calendar-alt' =>  'calendar-alt',
        'fa fa-calendar-check' =>  'calendar-check',
        'far fa-calendar-check' =>  'calendar-check',
        'fa fa-calendar-minus' =>  'calendar-minus',
        'far fa-calendar-minus' =>  'calendar-minus',
        'fa fa-calendar-plus' =>  'calendar-plus',
        'far fa-calendar-plus' =>  'calendar-plus',
        'fa fa-calendar-times' =>  'calendar-times',
        'far fa-calendar-times' =>  'calendar-times',
        'fa fa-camera' =>  'camera',
        'fa fa-camera-retro' =>  'camera-retro',
        'fa fa-capsules' =>  'capsules',
        'fa fa-car' =>  'car',
        'fa fa-caret-down' =>  'caret-down',
        'fa fa-caret-left' =>  'caret-left',
        'fa fa-caret-right' =>  'caret-right',
        'fa fa-caret-square-down' =>  'caret-square-down',
        'far fa-caret-square-down' =>  'caret-square-down',
        'fa fa-caret-square-left' =>  'caret-square-left',
        'far fa-caret-square-left' =>  'caret-square-left',
        'fa fa-caret-square-right' =>  'caret-square-right',
        'far fa-caret-square-right' =>  'caret-square-right',
        'fa fa-caret-square-up' =>  'caret-square-up',
        'far fa-caret-square-up' =>  'caret-square-up',
        'fa fa-caret-up' =>  'caret-up',
        'fa fa-cart-arrow-down' =>  'cart-arrow-down',
        'fa fa-cart-plus' =>  'cart-plus',
        'fab fa-cc-amazon-pay' =>  'cc-amazon-pay',
        'fab fa-cc-amex' =>  'cc-amex',
        'fab fa-cc-apple-pay' =>  'cc-apple-pay',
        'fab fa-cc-diners-club' =>  'cc-diners-club',
        'fab fa-cc-discover' =>  'cc-discover',
        'fab fa-cc-jcb' =>  'cc-jcb',
        'fab fa-cc-mastercard' =>  'cc-mastercard',
        'fab fa-cc-paypal' =>  'cc-paypal',
        'fab fa-cc-stripe' =>  'cc-stripe',
        'fab fa-cc-visa' =>  'cc-visa',
        'fab fa-centercode' =>  'centercode',
        'fa fa-certificate' =>  'certificate',
        'fa fa-chart-area' =>  'chart-area',
        'fa fa-chart-bar' =>  'chart-bar',
        'far fa-chart-bar' =>  'chart-bar',
        'fa fa-chart-line' =>  'chart-line',
        'fa fa-chart-pie' =>  'chart-pie',
        'fa fa-check' =>  'check',
        'fa fa-check-circle' =>  'check-circle',
        'far fa-check-circle' =>  'check-circle',
        'fa fa-check-square' =>  'check-square',
        'far fa-check-square' =>  'check-square',
        'fa fa-chess' =>  'chess',
        'fa fa-chess-bishop' =>  'chess-bishop',
        'fa fa-chess-board' =>  'chess-board',
        'fa fa-chess-king' =>  'chess-king',
        'fa fa-chess-knight' =>  'chess-knight',
        'fa fa-chess-pawn' =>  'chess-pawn',
        'fa fa-chess-queen' =>  'chess-queen',
        'fa fa-chess-rook' =>  'chess-rook',
        'fa fa-chevron-circle-down' =>  'chevron-circle-down',
        'fa fa-chevron-circle-left' =>  'chevron-circle-left',
        'fa fa-chevron-circle-right' =>  'chevron-circle-right',
        'fa fa-chevron-circle-up' =>  'chevron-circle-up',
        'fa fa-chevron-down' =>  'chevron-down',
        'fa fa-chevron-left' =>  'chevron-left',
        'fa fa-chevron-right' =>  'chevron-right',
        'fa fa-chevron-up' =>  'chevron-up',
        'fa fa-child' =>  'child',
        'fab fa-chrome' =>  'chrome',
        'fa fa-circle' =>  'circle',
        'far fa-circle' =>  'circle',
        'fa fa-circle-notch' =>  'circle-notch',
        'fa fa-clipboard' =>  'clipboard',
        'far fa-clipboard' =>  'clipboard',
        'fa fa-clipboard-check' =>  'clipboard-check',
        'fa fa-clipboard-list' =>  'clipboard-list',
        'fa fa-clock' =>  'clock',
        'far fa-clock' =>  'clock',
        'fa fa-clone' =>  'clone',
        'far fa-clone' =>  'clone',
        'fa fa-closed-captioning' =>  'closed-captioning',
        'far fa-closed-captioning' =>  'closed-captioning',
        'fa fa-cloud' =>  'cloud',
        'fa fa-cloud-download-alt' =>  'cloud-download-alt',
        'fa fa-cloud-upload-alt' =>  'cloud-upload-alt',
        'fab fa-cloudscale' =>  'cloudscale',
        'fab fa-cloudsmith' =>  'cloudsmith',
        'fab fa-cloudversify' =>  'cloudversify',
        'fa fa-code' =>  'code',
        'fa fa-code-branch' =>  'code-branch',
        'fab fa-codepen' =>  'codepen',
        'fab fa-codiepie' =>  'codiepie',
        'fa fa-coffee' =>  'coffee',
        'fa fa-cog' =>  'cog',
        'fa fa-cogs' =>  'cogs',
        'fa fa-columns' =>  'columns',
        'fa fa-comment' =>  'comment',
        'far fa-comment' =>  'comment',
        'fa fa-comment-alt' =>  'comment-alt',
        'far fa-comment-alt' =>  'comment-alt',
        'fa fa-comment-dots' =>  'comment-dots',
        'fa fa-comment-slash' =>  'comment-slash',
        'fa fa-comments' =>  'comments',
        'far fa-comments' =>  'comments',
        'fa fa-compass' =>  'compass',
        'far fa-compass' =>  'compass',
        'fa fa-compress' =>  'compress',
        'fab fa-connectdevelop' =>  'connectdevelop',
        'fab fa-contao' =>  'contao',
        'fa fa-copy' =>  'copy',
        'far fa-copy' =>  'copy',
        'fa fa-copyright' =>  'copyright',
        'far fa-copyright' =>  'copyright',
        'fa fa-couch' =>  'couch',
        'fab fa-cpanel' =>  'cpanel',
        'fab fa-creative-commons' =>  'creative-commons',
        'fa fa-credit-card' =>  'credit-card',
        'far fa-credit-card' =>  'credit-card',
        'fa fa-crop' =>  'crop',
        'fa fa-crosshairs' =>  'crosshairs',
        'fab fa-css3' =>  'css3',
        'fab fa-css3-alt' =>  'css3-alt',
        'fa fa-cube' =>  'cube',
        'fa fa-cubes' =>  'cubes',
        'fa fa-cut' =>  'cut',
        'fab fa-cuttlefish' =>  'cuttlefish',
        'fab fa-d-and-d' =>  'd-and-d',
        'fab fa-dashcube' =>  'dashcube',
        'fa fa-database' =>  'database',
        'fa fa-deaf' =>  'deaf',
        'fab fa-delicious' =>  'delicious',
        'fab fa-deploydog' =>  'deploydog',
        'fab fa-deskpro' =>  'deskpro',
        'fa fa-desktop' =>  'desktop',
        'fab fa-deviantart' =>  'deviantart',
        'fa fa-diagnoses' =>  'diagnoses',
        'fab fa-digg' =>  'digg',
        'fab fa-digital-ocean' =>  'digital-ocean',
        'fab fa-discord' =>  'discord',
        'fab fa-discourse' =>  'discourse',
        'fa fa-dna' =>  'dna',
        'fab fa-dochub' =>  'dochub',
        'fab fa-docker' =>  'docker',
        'fa fa-dollar-sign' =>  'dollar-sign',
        'fa fa-dolly' =>  'dolly',
        'fa fa-dolly-flatbed' =>  'dolly-flatbed',
        'fa fa-donate' =>  'donate',
        'fa fa-dot-circle' =>  'dot-circle',
        'far fa-dot-circle' =>  'dot-circle',
        'fa fa-dove' =>  'dove',
        'fa fa-download' =>  'download',
        'fab fa-draft2digital' =>  'draft2digital',
        'fab fa-dribbble' =>  'dribbble',
        'fab fa-dribbble-square' =>  'dribbble-square',
        'fab fa-dropbox' =>  'dropbox',
        'fab fa-drupal' =>  'drupal',
        'fab fa-dyalog' =>  'dyalog',
        'fab fa-earlybirds' =>  'earlybirds',
        'fab fa-edge' =>  'edge',
        'fa fa-edit' =>  'edit',
        'far fa-edit' =>  'edit',
        'fa fa-eject' =>  'eject',
        'fab fa-elementor' =>  'elementor',
        'fa fa-ellipsis-h' =>  'ellipsis-h',
        'fa fa-ellipsis-v' =>  'ellipsis-v',
        'fab fa-ember' =>  'ember',
        'fab fa-empire' =>  'empire',
        'fa fa-envelope' =>  'envelope',
        'far fa-envelope' =>  'envelope',
        'fa fa-envelope-open' =>  'envelope-open',
        'far fa-envelope-open' =>  'envelope-open',
        'fa fa-envelope-square' =>  'envelope-square',
        'fab fa-envira' =>  'envira',
        'fa fa-eraser' =>  'eraser',
        'fab fa-erlang' =>  'erlang',
        'fab fa-ethereum' =>  'ethereum',
        'fab fa-etsy' =>  'etsy',
        'fa fa-euro-sign' =>  'euro-sign',
        'fa fa-exchange-alt' =>  'exchange-alt',
        'fa fa-exclamation' =>  'exclamation',
        'fa fa-exclamation-circle' =>  'exclamation-circle',
        'fa fa-exclamation-triangle' =>  'exclamation-triangle',
        'fa fa-expand' =>  'expand',
        'fa fa-expand-arrows-alt' =>  'expand-arrows-alt',
        'fab fa-expeditedssl' =>  'expeditedssl',
        'fa fa-external-link-alt' =>  'external-link-alt',
        'fa fa-external-link-square-alt' =>  'external-link-square-alt',
        'fa fa-eye' =>  'eye',
        'fa fa-eye-dropper' =>  'eye-dropper',
        'fa fa-eye-slash' =>  'eye-slash',
        'far fa-eye-slash' =>  'eye-slash',
        'fab fa-facebook' =>  'facebook',
        'fab fa-facebook-f' =>  'facebook-f',
        'fab fa-facebook-messenger' =>  'facebook-messenger',
        'fab fa-facebook-square' =>  'facebook-square',
        'fa fa-fast-backward' =>  'fast-backward',
        'fa fa-fast-forward' =>  'fast-forward',
        'fa fa-fax' =>  'fax',
        'fa fa-female' =>  'female',
        'fa fa-fighter-jet' =>  'fighter-jet',
        'fa fa-file' =>  'file',
        'far fa-file' =>  'file',
        'fa fa-file-alt' =>  'file-alt',
        'far fa-file-alt' =>  'file-alt',
        'fa fa-file-archive' =>  'file-archive',
        'far fa-file-archive' =>  'file-archive',
        'fa fa-file-audio' =>  'file-audio',
        'far fa-file-audio' =>  'file-audio',
        'fa fa-file-code' =>  'file-code',
        'far fa-file-code' =>  'file-code',
        'fa fa-file-excel' =>  'file-excel',
        'far fa-file-excel' =>  'file-excel',
        'fa fa-file-image' =>  'file-image',
        'far fa-file-image' =>  'file-image',
        'fa fa-file-medical' =>  'file-medical',
        'fa fa-file-medical-alt' =>  'file-medical-alt',
        'fa fa-file-pdf' =>  'file-pdf',
        'far fa-file-pdf' =>  'file-pdf',
        'fa fa-file-powerpoint' =>  'file-powerpoint',
        'far fa-file-powerpoint' =>  'file-powerpoint',
        'fa fa-file-video' =>  'file-video',
        'far fa-file-video' =>  'file-video',
        'fa fa-file-word' =>  'file-word',
        'far fa-file-word' =>  'file-word',
        'fa fa-film' =>  'film',
        'fa fa-filter' =>  'filter',
        'fa fa-fire' =>  'fire',
        'fa fa-fire-extinguisher' =>  'fire-extinguisher',
        'fab fa-firefox' =>  'firefox',
        'fa fa-first-aid' =>  'first-aid',
        'fab fa-first-order' =>  'first-order',
        'fab fa-firstdraft' =>  'firstdraft',
        'fa fa-flag' =>  'flag',
        'far fa-flag' =>  'flag',
        'fa fa-flag-checkered' =>  'flag-checkered',
        'fa fa-flask' =>  'flask',
        'fab fa-flickr' =>  'flickr',
        'fab fa-flipboard' =>  'flipboard',
        'fab fa-fly' =>  'fly',
        'fa fa-folder' =>  'folder',
        'far fa-folder' =>  'folder',
        'fa fa-folder-open' =>  'folder-open',
        'far fa-folder-open' =>  'folder-open',
        'fa fa-font' =>  'font',
        'fab fa-font-awesome' =>  'font-awesome',
        'fab fa-font-awesome-alt' =>  'font-awesome-alt',
        'fab fa-font-awesome-flag' =>  'font-awesome-flag',
        'fab fa-fonticons' =>  'fonticons',
        'fab fa-fonticons-fi' =>  'fonticons-fi',
        'fa fa-football-ball' =>  'football-ball',
        'fab fa-fort-awesome' =>  'fort-awesome',
        'fab fa-fort-awesome-alt' =>  'fort-awesome-alt',
        'fab fa-forumbee' =>  'forumbee',
        'fa fa-forward' =>  'forward',
        'fab fa-foursquare' =>  'foursquare',
        'fab fa-free-code-camp' =>  'free-code-camp',
        'fab fa-freebsd' =>  'freebsd',
        'fa fa-frown' =>  'frown',
        'far fa-frown' =>  'frown',
        'fa fa-futbol' =>  'futbol',
        'far fa-futbol' =>  'futbol',
        'fa fa-gamepad' =>  'gamepad',
        'fa fa-gavel' =>  'gavel',
        'fa fa-gem' =>  'gem',
        'far fa-gem' =>  'gem',
        'fa fa-genderless' =>  'genderless',
        'fab fa-get-pocket' =>  'get-pocket',
        'fab fa-gg' =>  'gg',
        'fab fa-gg-circle' =>  'gg-circle',
        'fa fa-gift' =>  'gift',
        'fab fa-git' =>  'git',
        'fab fa-git-square' =>  'git-square',
        'fab fa-github' =>  'github',
        'fab fa-github-alt' =>  'github-alt',
        'fab fa-github-square' =>  'github-square',
        'fab fa-gitkraken' =>  'gitkraken',
        'fab fa-gitlab' =>  'gitlab',
        'fab fa-gitter' =>  'gitter',
        'fa fa-glass-martini' =>  'glass-martini',
        'fab fa-glide' =>  'glide',
        'fab fa-glide-g' =>  'glide-g',
        'fa fa-globe' =>  'globe',
        'fab fa-gofore' =>  'gofore',
        'fa fa-golf-ball' =>  'golf-ball',
        'fab fa-goodreads' =>  'goodreads',
        'fab fa-goodreads-g' =>  'goodreads-g',
        'fab fa-google' =>  'google',
        'fab fa-google-drive' =>  'google-drive',
        'fab fa-google-play' =>  'google-play',
        'fab fa-google-plus' =>  'google-plus',
        'fab fa-google-plus-g' =>  'google-plus-g',
        'fab fa-google-plus-square' =>  'google-plus-square',
        'fab fa-google-wallet' =>  'google-wallet',
        'fa fa-graduation-cap' =>  'graduation-cap',
        'fab fa-gratipay' =>  'gratipay',
        'fab fa-grav' =>  'grav',
        'fab fa-gripfire' =>  'gripfire',
        'fab fa-grunt' =>  'grunt',
        'fab fa-gulp' =>  'gulp',
        'fa fa-h-square' =>  'h-square',
        'fab fa-hacker-news' =>  'hacker-news',
        'fab fa-hacker-news-square' =>  'hacker-news-square',
        'fa fa-hand-holding' =>  'hand-holding',
        'fa fa-hand-holding-heart' =>  'hand-holding-heart',
        'fa fa-hand-holding-usd' =>  'hand-holding-usd',
        'fa fa-hand-lizard' =>  'hand-lizard',
        'far fa-hand-lizard' =>  'hand-lizard',
        'fa fa-hand-paper' =>  'hand-paper',
        'far fa-hand-paper' =>  'hand-paper',
        'fa fa-hand-peace' =>  'hand-peace',
        'far fa-hand-peace' =>  'hand-peace',
        'fa fa-hand-point-down' =>  'hand-point-down',
        'far fa-hand-point-down' =>  'hand-point-down',
        'fa fa-hand-point-left' =>  'hand-point-left',
        'far fa-hand-point-left' =>  'hand-point-left',
        'fa fa-hand-point-right' =>  'hand-point-right',
        'far fa-hand-point-right' =>  'hand-point-right',
        'fa fa-hand-point-up' =>  'hand-point-up',
        'far fa-hand-point-up' =>  'hand-point-up',
        'fa fa-hand-pointer' =>  'hand-pointer',
        'far fa-hand-pointer' =>  'hand-pointer',
        'fa fa-hand-rock' =>  'hand-rock',
        'far fa-hand-rock' =>  'hand-rock',
        'fa fa-hand-scissors' =>  'hand-scissors',
        'far fa-hand-scissors' =>  'hand-scissors',
        'fa fa-hand-spock' =>  'hand-spock',
        'far fa-hand-spock' =>  'hand-spock',
        'fa fa-hands' =>  'hands',
        'fa fa-hands-helping' =>  'hands-helping',
        'fa fa-handshake' =>  'handshake',
        'far fa-handshake' =>  'handshake',
        'fa fa-hashtag' =>  'hashtag',

        'fa fa-hdd' =>  'hdd',
        'far fa-hdd' =>  'hdd',
        'fa fa-heading' =>  'heading',
        'fa fa-headphones' =>  'headphones',
        'fa fa-heart' =>  'heart',
        'far fa-heart' =>  'heart',
        'fa fa-heartbeat' =>  'heartbeat',
        'fab fa-hips' =>  'hips',
        'fab fa-hire-a-helper' =>  'hire-a-helper',
        'fa fa-history' =>  'history',
        'fa fa-hockey-puck' =>  'hockey-puck',
        'fa fa-home' =>  'home',
        'fab fa-hooli' =>  'hooli',
        'fa fa-hospital' =>  'hospital',
        'far fa-hospital' =>  'hospital',
        'fa fa-hospital-alt' =>  'hospital-alt',
        'fa fa-hospital-symbol' =>  'hospital-symbol',
        'fab fa-hotjar' =>  'hotjar',
        'fa fa-hourglass' =>  'hourglass',
        'far fa-hourglass' =>  'hourglass',
        'fa fa-hourglass-end' =>  'hourglass-end',
        'fa fa-hourglass-half' =>  'hourglass-half',
        'fa fa-hourglass-start' =>  'hourglass-start',
        'fab fa-houzz' =>  'houzz',
        'fab fa-html5' =>  'html5',
        'fab fa-hubspot' =>  'hubspot',
        'fa fa-i-cursor' =>  'i-cursor',
        'fa fa-id-badge' =>  'id-badge',
        'far fa-id-badge' =>  'id-badge',
        'fa fa-id-card' =>  'id-card',
        'far fa-id-card' =>  'id-card',
        'fa fa-id-card-alt' =>  'id-card-alt',
        'fa fa-image' =>  'image',
        'far fa-image' =>  'image',
        'fa fa-images' =>  'images',
        'far fa-images' =>  'images',
        'fab fa-imdb' =>  'imdb',
        'fa fa-inbox' =>  'inbox',
        'fa fa-indent' =>  'indent',
        'fa fa-industry' =>  'industry',
        'fa fa-info' =>  'info',
        'fa fa-info-circle' =>  'info-circle',
        'fab fa-instagram' =>  'instagram',
        'fab fa-internet-explorer' =>  'internet-explorer',
        'fab fa-ioxhost' =>  'ioxhost',
        'fa fa-italic' =>  'italic',
        'fab fa-itunes' =>  'itunes',
        'fab fa-itunes-note' =>  'itunes-note',
        'fab fa-java' =>  'java',
        'fab fa-jenkins' =>  'jenkins',
        'fab fa-joget' =>  'joget',
        'fab fa-joomla' =>  'joomla',
        'fab fa-js' =>  'js',
        'fab fa-js-square' =>  'js-square',
        'fab fa-jsfiddle' =>  'jsfiddle',
        'fa fa-key' =>  'key',
        'fa fa-keyboard' =>  'keyboard',
        'far fa-keyboard' =>  'keyboard',
        'fab fa-keycdn' =>  'keycdn',
        'fab fa-kickstarter' =>  'kickstarter',
        'fab fa-kickstarter-k' =>  'kickstarter-k',
        'fab fa-korvue' =>  'korvue',
        'fa fa-language' =>  'language',
        'fa fa-laptop' =>  'laptop',
        'fab fa-laravel' =>  'laravel',
        'fab fa-lastfm' =>  'lastfm',
        'fab fa-lastfm-square' =>  'lastfm-square',
        'fa fa-leaf' =>  'leaf',
        'fab fa-leanpub' =>  'leanpub',
        'fa fa-lemon' =>  'lemon',
        'far fa-lemon' =>  'lemon',
        'fab fa-less' =>  'less',
        'fa fa-level-down-alt' =>  'level-down-alt',
        'fa fa-level-up-alt' =>  'level-up-alt',
        'fa fa-life-ring' =>  'life-ring',
        'far fa-life-ring' =>  'life-ring',
        'fa fa-lightbulb' =>  'lightbulb',
        'far fa-lightbulb' =>  'lightbulb',
        'fab fa-line' =>  'line',
        'fa fa-link' =>  'link',
        'fab fa-linkedin' =>  'linkedin',
        'fab fa-linkedin-in' =>  'linkedin-in',
        'fab fa-linode' =>  'linode',
        'fab fa-linux' =>  'linux',
        'fa fa-lira-sign' =>  'lira-sign',
        'fa fa-list' =>  'list',
        'fa fa-list-alt' =>  'list-alt',
        'far fa-list-alt' =>  'list-alt',
        'fa fa-list-ol' =>  'list-ol',
        'fa fa-list-ul' =>  'list-ul',
        'fa fa-location-arrow' =>  'location-arrow',
        'fa fa-lock' =>  'lock',
        'fa fa-lock-open' =>  'lock-open',
        'fa fa-long-arrow-alt-down' =>  'long-arrow-alt-down',
        'fa fa-long-arrow-alt-left' =>  'long-arrow-alt-left',
        'fa fa-long-arrow-alt-right' =>  'long-arrow-alt-right',
        'fa fa-long-arrow-alt-up' =>  'long-arrow-alt-up',
        'fa fa-low-vision' =>  'low-vision',
        'fab fa-lyft' =>  'lyft',
        'fab fa-magento' =>  'magento',
        'fa fa-magic' =>  'magic',
        'fa fa-magnet' =>  'magnet',
        'fa fa-male' =>  'male',
        'fa fa-map' =>  'map',
        'far fa-map' =>  'map',
        'fa fa-map-marker' =>  'map-marker',
        'fa fa-map-marker-alt' =>  'map-marker-alt',
        'fa fa-map-pin' =>  'map-pin',
        'fa fa-map-signs' =>  'map-signs',
        'fa fa-mars' =>  'mars',
        'fa fa-mars-double' =>  'mars-double',
        'fa fa-mars-stroke' =>  'mars-stroke',
        'fa fa-mars-stroke-h' =>  'mars-stroke-h',
        'fa fa-mars-stroke-v' =>  'mars-stroke-v',
        'fab fa-maxcdn' =>  'maxcdn',
        'fab fa-medapps' =>  'medapps',
        'fab fa-medium' =>  'medium',
        'fab fa-medium-m' =>  'medium-m',
        'fa fa-medkit' =>  'medkit',
        'fab fa-medrt' =>  'medrt',
        'fab fa-meetup' =>  'meetup',
        'fa fa-meh' =>  'meh',
        'far fa-meh' =>  'meh',
        'fa fa-mercury' =>  'mercury',
        'fa fa-microchip' =>  'microchip',
        'fa fa-microphone' =>  'microphone',
        'fa fa-microphone-slash' =>  'microphone-slash',
        'fab fa-microsoft' =>  'microsoft',
        'fa fa-minus' =>  'minus',
        'fa fa-minus-circle' =>  'minus-circle',
        'fa fa-minus-square' =>  'minus-square',
        'far fa-minus-square' =>  'minus-square',
        'fab fa-mix' =>  'mix',
        'fab fa-mixcloud' =>  'mixcloud',
        'fab fa-mizuni' =>  'mizuni',
        'fa fa-mobile' =>  'mobile',
        'fa fa-mobile-alt' =>  'mobile-alt',
        'fab fa-modx' =>  'modx',
        'fab fa-monero' =>  'monero',
        'fa fa-money-bill-alt' =>  'money-bill-alt',
        'far fa-money-bill-alt' =>  'money-bill-alt',
        'fa fa-moon' =>  'moon',
        'far fa-moon' =>  'moon',
        'fa fa-motorcycle' =>  'motorcycle',
        'fa fa-mouse-pointer' =>  'mouse-pointer',
        'fa fa-music' =>  'music',
        'fab fa-napster' =>  'napster',
        'fa fa-neuter' =>  'neuter',
        'fa fa-newspaper' =>  'newspaper',
        'far fa-newspaper' =>  'newspaper',
        'fab fa-nintendo-switch' =>  'nintendo-switch',
        'fab fa-node' =>  'node',
        'fab fa-node-js' =>  'node-js',
        'fa fa-notes-medical' =>  'notes-medical',
        'fab fa-npm' =>  'npm',
        'fab fa-ns8' =>  'ns8',
        'fab fa-nutritionix' =>  'nutritionix',
        'fa fa-object-group' =>  'object-group',
        'far fa-object-group' =>  'object-group',
        'fa fa-object-ungroup' =>  'object-ungroup',
        'far fa-object-ungroup' =>  'object-ungroup',
        'fab fa-odnoklassniki' =>  'odnoklassniki',
        'fab fa-odnoklassniki-square' =>  'odnoklassniki-square',
        'fab fa-opencart' =>  'opencart',
        'fab fa-openid' =>  'openid',
        'fab fa-opera' =>  'opera',
        'fab fa-optin-monster' =>  'optin-monster',
        'fab fa-osi' =>  'osi',
        'fa fa-outdent' =>  'outdent',
        'fab fa-page4' =>  'page4',
        'fab fa-pagelines' =>  'pagelines',
        'fa fa-paint-brush' =>  'paint-brush',
        'fab fa-palfed' =>  'palfed',
        'fa fa-pallet' =>  'pallet',
        'fa fa-paper-plane' =>  'paper-plane',
        'far fa-paper-plane' =>  'paper-plane',
        'fa fa-paperclip' =>  'paperclip',
        'fa fa-parachute-box' =>  'parachute-box',
        'fa fa-paragraph' =>  'paragraph',
        'fa fa-paste' =>  'paste',
        'fab fa-patreon' =>  'patreon',
        'fa fa-pause' =>  'pause',
        'fa fa-pause-circle' =>  'pause-circle',
        'far fa-pause-circle' =>  'pause-circle',
        'fa fa-paw' =>  'paw',
        'fab fa-paypal' =>  'paypal',
        'fa fa-pen-square' =>  'pen-square',
        'fa fa-pencil-alt' =>  'pencil-alt',
        'fa fa-people-carry' =>  'people-carry',
        'fa fa-percent' =>  'percent',
        'fab fa-periscope' =>  'periscope',
        'fab fa-phabricator' =>  'phabricator',
        'fab fa-phoenix-framework' =>  'phoenix-framework',
        'fa fa-phone' =>  'phone',
        'fa fa-phone-slash' =>  'phone-slash',
        'fa fa-phone-square' =>  'phone-square',
        'fa fa-phone-volume' =>  'phone-volume',
        'fab fa-php' =>  'php',
        'fab fa-pied-piper' =>  'pied-piper',
        'fab fa-pied-piper-alt' =>  'pied-piper-alt',
        'fab fa-pied-piper-hat' =>  'pied-piper-hat',
        'fab fa-pied-piper-pp' =>  'pied-piper-pp',
        'fa fa-piggy-bank' =>  'piggy-bank',
        'fa fa-pills' =>  'pills',
        'fab fa-pinterest' =>  'pinterest',
        'fab fa-pinterest-p' =>  'pinterest-p',
        'fab fa-pinterest-square' =>  'pinterest-square',
        'fa fa-plane' =>  'plane',
        'fa fa-play' =>  'play',
        'fa fa-play-circle' =>  'play-circle',
        'far fa-play-circle' =>  'play-circle',
        'fab fa-playstation' =>  'playstation',
        'fa fa-plug' =>  'plug',
        'fa fa-plus' =>  'plus',
        'fa fa-plus-circle' =>  'plus-circle',
        'fa fa-plus-square' =>  'plus-square',
        'far fa-plus-square' =>  'plus-square',
        'fa fa-podcast' =>  'podcast',
        'fa fa-poo' =>  'poo',
        'fa fa-pound-sign' =>  'pound-sign',
        'fa fa-power-off' =>  'power-off',
        'fa fa-prescription-bottle' =>  'prescription-bottle',
        'fa fa-prescription-bottle-alt' =>  'prescription-bottle-alt',
        'fa fa-print' =>  'print',
        'fa fa-procedures' =>  'procedures',
        'fab fa-product-hunt' =>  'product-hunt',
        'fab fa-pushed' =>  'pushed',
        'fa fa-puzzle-piece' =>  'puzzle-piece',
        'fab fa-python' =>  'python',
        'fab fa-qq' =>  'qq',
        'fa fa-qrcode' =>  'qrcode',
        'fa fa-question' =>  'question',
        'fa fa-question-circle' =>  'question-circle',
        'far fa-question-circle' =>  'question-circle',
        'fa fa-quidditch' =>  'quidditch',
        'fab fa-quinscape' =>  'quinscape',
        'fab fa-quora' =>  'quora',
        'fa fa-quote-left' =>  'quote-left',
        'fa fa-quote-right' =>  'quote-right',
        'fa fa-random' =>  'random',
        'fab fa-ravelry' =>  'ravelry',
        'fab fa-react' =>  'react',
        'fab fa-readme' =>  'readme',
        'fab fa-rebel' =>  'rebel',
        'fa fa-recycle' =>  'recycle',
        'fab fa-red-river' =>  'red-river',
        'fab fa-reddit' =>  'reddit',
        'fab fa-reddit-alien' =>  'reddit-alien',
        'fab fa-reddit-square' =>  'reddit-square',
        'fa fa-redo' =>  'redo',
        'fa fa-redo-alt' =>  'redo-alt',
        'fa fa-registered' =>  'registered',
        'far fa-registered' =>  'registered',
        'fab fa-rendact' =>  'rendact',
        'fab fa-renren' =>  'renren',
        'fa fa-reply' =>  'reply',
        'fa fa-reply-all' =>  'reply-all',
        'fab fa-replyd' =>  'replyd',
        'fab fa-resolving' =>  'resolving',
        'fa fa-retweet' =>  'retweet',
        'fa fa-ribbon' =>  'ribbon',
        'fa fa-road' =>  'road',
        'fa fa-rocket' =>  'rocket',
        'fab fa-rocketchat' =>  'rocketchat',
        'fab fa-rockrms' =>  'rockrms',
        'fa fa-rss' =>  'rss',
        'fa fa-rss-square' =>  'rss-square',
        'fa fa-ruble-sign' =>  'ruble-sign',
        'fa fa-rupee-sign' =>  'rupee-sign',
        'fab fa-safari' =>  'safari',
        'fab fa-sass' =>  'sass',
        'fa fa-save' =>  'save',
        'far fa-save' =>  'save',
        'fab fa-schlix' =>  'schlix',
        'fab fa-scribd' =>  'scribd',
        'fa fa-search' =>  'search',
        'fa fa-search-minus' =>  'search-minus',
        'fa fa-search-plus' =>  'search-plus',
        'fab fa-searchengin' =>  'searchengin',
        'fa fa-seedling' =>  'seedling',
        'fab fa-sellcast' =>  'sellcast',
        'fab fa-sellsy' =>  'sellsy',
        'fa fa-server' =>  'server',
        'fab fa-servicestack' =>  'servicestack',
        'fa fa-share' =>  'share',
        'fa fa-share-alt' =>  'share-alt',
        'fa fa-share-alt-square' =>  'share-alt-square',
        'fa fa-share-square' =>  'share-square',
        'far fa-share-square' =>  'share-square',
        'fa fa-shekel-sign' =>  'shekel-sign',
        'fa fa-shield-alt' =>  'shield-alt',
        'fa fa-ship' =>  'ship',
        'fa fa-shipping-fast' =>  'shipping-fast',
        'fab fa-shirtsinbulk' =>  'shirtsinbulk',
        'fa fa-shopping-bag' =>  'shopping-bag',
        'fa fa-shopping-basket' =>  'shopping-basket',
        'fa fa-shopping-cart' =>  'shopping-cart',
        'fa fa-shower' =>  'shower',
        'fa fa-sign' =>  'sign',
        'fa fa-sign-in-alt' =>  'sign-in-alt',
        'fa fa-sign-language' =>  'sign-language',
        'fa fa-sign-out-alt' =>  'sign-out-alt',
        'fa fa-signal' =>  'signal',
        'fab fa-simplybuilt' =>  'simplybuilt',
        'fab fa-sistrix' =>  'sistrix',
        'fa fa-sitemap' =>  'sitemap',
        'fab fa-skyatlas' =>  'skyatlas',
        'fab fa-skype' =>  'skype',
        'fab fa-slack' =>  'slack',
        'fab fa-slack-hash' =>  'slack-hash',
        'fa fa-sliders-h' =>  'sliders-h',
        'fab fa-slideshare' =>  'slideshare',
        'fa fa-smile' =>  'smile',
        'far fa-smile' =>  'smile',
        'fa fa-smoking' =>  'smoking',
        'fab fa-snapchat' =>  'snapchat',
        'fab fa-snapchat-ghost' =>  'snapchat-ghost',
        'fab fa-snapchat-square' =>  'snapchat-square',
        'fa fa-snowflake' =>  'snowflake',
        'far fa-snowflake' =>  'snowflake',
        'fa fa-sort' =>  'sort',
        'fa fa-sort-alpha-down' =>  'sort-alpha-down',
        'fa fa-sort-alpha-up' =>  'sort-alpha-up',
        'fa fa-sort-amount-down' =>  'sort-amount-down',
        'fa fa-sort-amount-up' =>  'sort-amount-up',
        'fa fa-sort-down' =>  'sort-down',
        'fa fa-sort-numeric-down' =>  'sort-numeric-down',
        'fa fa-sort-numeric-up' =>  'sort-numeric-up',
        'fa fa-sort-up' =>  'sort-up',
        'fab fa-soundcloud' =>  'soundcloud',
        'fa fa-space-shuttle' =>  'space-shuttle',
        'fab fa-speakap' =>  'speakap',
        'fa fa-spinner' =>  'spinner',
        'fab fa-spotify' =>  'spotify',
        'fa fa-square' =>  'square',
        'far fa-square' =>  'square',
        'fa fa-square-full' =>  'square-full',
        'fab fa-stack-exchange' =>  'stack-exchange',
        'fab fa-stack-overflow' =>  'stack-overflow',
        'fa fa-star' =>  'star',
        'far fa-star' =>  'star',

        'fa fa-star-half' =>  'star-half',
        'far fa-star-half' =>  'star-half',
        'fab fa-staylinked' =>  'staylinked',
        'fab fa-steam' =>  'steam',
        'fab fa-steam-square' =>  'steam-square',
        'fab fa-steam-symbol' =>  'steam-symbol',
        'fa fa-step-backward' =>  'step-backward',
        'fa fa-step-forward' =>  'step-forward',
        'fa fa-stethoscope' =>  'stethoscope',
        'fab fa-sticker-mule' =>  'sticker-mule',
        'fa fa-sticky-note' =>  'sticky-note',
        'far fa-sticky-note' =>  'sticky-note',
        'fa fa-stop' =>  'stop',
        'fa fa-stop-circle' =>  'stop-circle',
        'far fa-stop-circle' =>  'stop-circle',
        'fa fa-stopwatch' =>  'stopwatch',
        'fab fa-strava' =>  'strava',
        'fa fa-street-view' =>  'street-view',
        'fa fa-strikethrough' =>  'strikethrough',
        'fab fa-stripe' =>  'stripe',
        'fab fa-stripe-s' =>  'stripe-s',
        'fab fa-studiovinari' =>  'studiovinari',
        'fab fa-stumbleupon' =>  'stumbleupon',
        'fab fa-stumbleupon-circle' =>  'stumbleupon-circle',
        'fa fa-subscript' =>  'subscript',
        'fa fa-subway' =>  'subway',
        'fa fa-suitcase' =>  'suitcase',
        'fa fa-sun' =>  'sun',
        'far fa-sun' =>  'sun',
        'fab fa-superpowers' =>  'superpowers',
        'fa fa-superscript' =>  'superscript',
        'fab fa-supple' =>  'supple',
        'fa fa-sync' =>  'sync',
        'fa fa-sync-alt' =>  'sync-alt',
        'fa fa-syringe' =>  'syringe',
        'fa fa-table' =>  'table',
        'fa fa-table-tennis' =>  'table-tennis',
        'fa fa-tablet' =>  'tablet',
        'fa fa-tablet-alt' =>  'tablet-alt',
        'fa fa-tablets' =>  'tablets',
        'fa fa-tachometer-alt' =>  'tachometer-alt',
        'fa fa-tag' =>  'tag',
        'fa fa-tags' =>  'tags',
        'fa fa-tape' =>  'tape',
        'fa fa-tasks' =>  'tasks',
        'fa fa-taxi' =>  'taxi',
        'fab fa-telegram' =>  'telegram',
        'fab fa-telegram-plane' =>  'telegram-plane',
        'fab fa-tencent-weibo' =>  'tencent-weibo',
        'fa fa-terminal' =>  'terminal',
        'fa fa-text-height' =>  'text-height',
        'fa fa-text-width' =>  'text-width',
        'fa fa-th' =>  'th',
        'fa fa-th-large' =>  'th-large',
        'fa fa-th-list' =>  'th-list',
        'fab fa-themeisle' =>  'themeisle',
        'fa fa-thermometer' =>  'thermometer',
        'fa fa-thermometer-empty' =>  'thermometer-empty',
        'fa fa-thermometer-full' =>  'thermometer-full',
        'fa fa-thermometer-half' =>  'thermometer-half',
        'fa fa-thermometer-quarter' =>  'thermometer-quarter',
        'fa fa-thermometer-three-quarters' =>  'thermometer-three-quarters',
        'fa fa-thumbs-down' =>  'thumbs-down',
        'far fa-thumbs-down' =>  'thumbs-down',
        'fa fa-thumbs-up' =>  'thumbs-up',
        'far fa-thumbs-up' =>  'thumbs-up',
        'fa fa-thumbtack' =>  'thumbtack',
        'fa fa-ticket-alt' =>  'ticket-alt',
        'fa fa-times' =>  'times',
        'fa fa-times-circle' =>  'times-circle',
        'far fa-times-circle' =>  'times-circle',
        'fa fa-tint' =>  'tint',
        'fa fa-toggle-off' =>  'toggle-off',
        'fa fa-toggle-on' =>  'toggle-on',
        'fa fa-trademark' =>  'trademark',
        'fa fa-train' =>  'train',
        'fa fa-transgender' =>  'transgender',
        'fa fa-transgender-alt' =>  'transgender-alt',
        'fa fa-trash' =>  'trash',
        'fa fa-trash-alt' =>  'trash-alt',
        'far fa-trash-alt' =>  'trash-alt',
        'fa fa-tree' =>  'tree',
        'fab fa-trello' =>  'trello',
        'fab fa-tripadvisor' =>  'tripadvisor',
        'fa fa-trophy' =>  'trophy',
        'fa fa-truck' =>  'truck',
        'fa fa-truck-loading' =>  'truck-loading',
        'fa fa-truck-moving' =>  'truck-moving',
        'fa fa-tty' =>  'tty',
        'fab fa-tumblr' =>  'tumblr',
        'fab fa-tumblr-square' =>  'tumblr-square',
        'fa fa-tv' =>  'tv',
        'fab fa-twitch' =>  'twitch',
        'fab fa-twitter' =>  'twitter',
        'fab fa-twitter-square' =>  'twitter-square',
        'fab fa-typo3' =>  'typo3',
        'fab fa-uber' =>  'uber',
        'fab fa-uikit' =>  'uikit',
        'fa fa-umbrella' =>  'umbrella',
        'fa fa-underline' =>  'underline',
        'fa fa-undo' =>  'undo',
        'fa fa-undo-alt' =>  'undo-alt',
        'fab fa-uniregistry' =>  'uniregistry',
        'fa fa-universal-access' =>  'universal-access',
        'fa fa-university' =>  'university',
        'fa fa-unlink' =>  'unlink',
        'fa fa-unlock' =>  'unlock',
        'fa fa-unlock-alt' =>  'unlock-alt',
        'fab fa-untappd' =>  'untappd',
        'fa fa-upload' =>  'upload',
        'fab fa-usb' =>  'usb',
        'fa fa-user' =>  'user',
        'far fa-user' =>  'user',
        'fa fa-user-circle' =>  'user-circle',
        'far fa-user-circle' =>  'user-circle',
        'fa fa-user-md' =>  'user-md',
        'fa fa-user-plus' =>  'user-plus',
        'fa fa-user-secret' =>  'user-secret',
        'fa fa-user-times' =>  'user-times',
        'fa fa-users' =>  'users',
        'fab fa-ussunnah' =>  'ussunnah',
        'fa fa-utensil-spoon' =>  'utensil-spoon',
        'fa fa-utensils' =>  'utensils',
        'fab fa-vaadin' =>  'vaadin',
        'fa fa-venus' =>  'venus',
        'fa fa-venus-double' =>  'venus-double',
        'fa fa-venus-mars' =>  'venus-mars',
        'fab fa-viacoin' =>  'viacoin',
        'fab fa-viadeo' =>  'viadeo',
        'fab fa-viadeo-square' =>  'viadeo-square',
        'fa fa-vial' =>  'vial',
        'fa fa-vials' =>  'vials',
        'fab fa-viber' =>  'viber',
        'fa fa-video' =>  'video',
        'fa fa-video-slash' =>  'video-slash',
        'fab fa-vimeo' =>  'vimeo',
        'fab fa-vimeo-square' =>  'vimeo-square',
        'fab fa-vimeo-v' =>  'vimeo-v',
        'fab fa-vine' =>  'vine',
        'fab fa-vk' =>  'vk',
        'fab fa-vnv' =>  'vnv',
        'fa fa-volleyball-ball' =>  'volleyball-ball',
        'fa fa-volume-down' =>  'volume-down',
        'fa fa-volume-off' =>  'volume-off',
        'fa fa-volume-up' =>  'volume-up',
        'fab fa-vuejs' =>  'vuejs',
        'fa fa-warehouse' =>  'warehouse',
        'fab fa-weibo' =>  'weibo',
        'fa fa-weight' =>  'weight',
        'fab fa-weixin' =>  'weixin',
        'fab fa-whatsapp' =>  'whatsapp',
        'fab fa-whatsapp-square' =>  'whatsapp-square',
        'fa fa-wheelchair' =>  'wheelchair',
        'fab fa-whmcs' =>  'whmcs',
        'fa fa-wifi' =>  'wifi',
        'fab fa-wikipedia-w' =>  'wikipedia-w',
        'fa fa-window-close' =>  'window-close',
        'far fa-window-close' =>  'window-close',
        'fa fa-window-maximize' =>  'window-maximize',
        'far fa-window-maximize' =>  'window-maximize',
        'fa fa-window-minimize' =>  'window-minimize',
        'far fa-window-minimize' =>  'window-minimize',
        'fa fa-window-restore' =>  'window-restore',
        'far fa-window-restore' =>  'window-restore',
        'fab fa-windows' =>  'windows',
        'fa fa-wine-glass' =>  'wine-glass',
        'fa fa-won-sign' =>  'won-sign',
        'fab fa-wordpress' =>  'wordpress',
        'fab fa-wordpress-simple' =>  'wordpress-simple',
        'fab fa-wpbeginner' =>  'wpbeginner',
        'fab fa-wpexplorer' =>  'wpexplorer',
        'fab fa-wpforms' =>  'wpforms',
        'fa fa-wrench' =>  'wrench',
        'fa fa-x-ray' =>  'x-ray',
        'fab fa-xbox' =>  'xbox',
        'fab fa-xing' =>  'xing',
        'fab fa-xing-square' =>  'xing-square',
        'fab fa-y-combinator' =>  'y-combinator',
        'fab fa-yahoo' =>  'yahoo',
        'fab fa-yandex' =>  'yandex',
        'fab fa-yandex-international' =>  'yandex-international',
        'fab fa-yelp' =>  'yelp',
        'fa fa-yen-sign' =>  'yen-sign',
        'fab fa-yoast' =>  'yoast',
        'fab fa-youtube' =>  'youtube',
        'fab fa-youtube-square' =>  'youtube-square',
    );
	
	?>
        <?php foreach($font_awesome_icons as $ficon => $fhex){ ?>
        <div style="float:left; padding:5px; background:#fff; border:1px solid #ddd; margin-right:10px; margin-bottom:10px; cursor:pointer; font-size:20px; padding-left:10px; padding-right:10px;" onclick="changefaicon('fa <?php echo $ficon; ?>');"> <span class="fa <?php echo $ficon; ?>"></span> </div>
        <?php } ?>
        <div class="clearfix"></div>
      </div></td>
  </tr>
</table>
<?php }	
	
 

  
 








	// ADDS ALL USERS TO THE EDIT BOX IN WORDPRESS WHEN EDITING LISTINGS
	function _wp_dropdown_users($output){
    global $post, $wpdb;
	
  
	 
	if(isset($post->post_type) && $post->post_type == "listing_type" && isset($_GET['action']) ){ 
		
		$result = count_users();
		if($result['total_users'] > 500){
		$wp_user_query =  new WP_User_Query( array(   'number' => 200, 'orderby' => 'display_name', 'order' => 'desc', 'count_total'  => true, 'role__not_in' => 'Subscriber' ) );
		}else{
		$wp_user_query =  new WP_User_Query( array(   'number' => 500, 'orderby' => 'display_name', 'order' => 'desc', 'count_total'  => true ) );
		}
		$users = $wp_user_query->get_results();		
 

		$output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
	
		//Leave the admin in the list
		if(isset($_GET['action']) && $_GET['action'] == "edit"){
		$output .= "<option value=\"".$post->post_author."\" selected=selected>User ID: ".$post->post_author." (".count_user_posts( $post->post_author , 'listing_type' )." listings)</option>";
		}
		if(is_array( $users )){
		foreach($users as $user)
		{
		
			$sel = ($post->post_author == $user->ID)?"selected='selected'":'';
			$output .= '<option value="'.$user->ID.'" '.$sel.'>'.$user->user_login.' ('.count_user_posts( $user->ID , 'listing_type' ).' listings)</option>';
		}
		}
		$output .= "</select>";
	
	}
	 
	
    return $output;	
	}	






function buildadminfields($full_list_of_fields){ global $post, $CORE, $wpdb; $tabbedarea = 0; $core_admin_values = get_option("core_admin_values");   ?>
<?php $i= 0; $rowid=0; foreach($full_list_of_fields as $key=>$val){ $e_value = get_post_meta($_GET['eid'],$key,true); 
 
// CHECK FOR DEFAULT FIELD VALUE
if($e_value == "" && isset($val['default'])){ $e_value = $val['default']; }  

// CHECK IF THIS IS A NEW TAB
if(isset($val['tab'])){ $tabbedarea = $key; $i = 0; ?>
<div class="clearfix"></div>
</div>
</div>
<div class="card card-row-<?php echo $rowid; ?>">
<?php $rowid++; ?>
<div class="card-header"><?php echo $val['title']; ?></div>
<div class="card-body" style="padding:20px;">
<?php }else{ ?>
<div class="row">
  <div class="form-group clearfix">
    <div class="col-md-6">
      <label class="col-form-label"><?php echo $val['label']; ?></label>
    </div>
    <div class="col-md-6">
      <?php if(isset($val['combo'])){ ?>
      <input type="text" id="autocompleteme" style="width:300px;" placeholder="Enter product title here.." />
      <?php if($key != "related"){ ?>
      <!-- HERE WE GET AND SAVE THE OLD VALUES ENCASE THEY CHANGED -->
      <?php
	$options1 = get_post_meta($post->ID,$key,true); $oldIds = "";
	if(is_array($options1) && !empty($options1)){				
		foreach($options1 as $val1){
		$oldIds .= $val1.",";
		}			 				 
	}// end foreach
  ?>
      <input type="hidden" name="ppt_field[<?php echo $key; ?>_old]" value="<?php echo $oldIds; ?>" />
      <?php } ?>
      <?php } ?>
      <?php if(isset($val['values'])){ ?>
      <select name="custom[<?php echo $key; ?>]<?php if(isset($val['multi'])){ ?>[]<?php }?>" id="field_<?php echo $key; ?>" <?php if(isset($val['multi'])){ ?>multiple="multiple"<?php } ?> class="form-control">
        <?php if(isset($val['combo'])){  ?>
        <option value=""> </option>
        <?php } ?>
        <?php if($key == "packageID"){ ?>
        <option value="">----- no package assigned -----</option>
        <?php } ?>
        <?php 
	
	if($key == "related"){
		foreach($val['values'] as $k=>$val){ 			
			$val = trim($val);
			if(strlen($val) > 0 && is_numeric($val)){
			echo '<option value="'.$val.'" selected=selected>'.get_the_title($val).'</option>';	
			}		
		}
	}else{
		foreach($val['values'] as $k=>$o){ 
		
		if(is_array($e_value) && isset($val['multi']) && in_array($k, $e_value) ){ $f = "selected=selected"; }elseif($e_value != "" && $e_value == $k){ $f = "selected=selected"; }else{ $f=""; }?>
        <?php if(is_array($o) && $key == "packageID"){ $o = $o['name']; } 
		if($o == ""){ continue; }
		?>
        <option value="<?php echo $k; ?>" <?php echo $f; ?>><?php echo $o; ?></option>
        <?php }?>
        <?php } ?>
      </select>
      <?php }else{ ?>
      <?php 
	 
	if(isset($val['dateitem'])){ 
			 $db = explode(" ",$e_value);
			echo ' 
			<script>jQuery(function(){ jQuery(\'#reg_field_'.$key.'_date\').datetimepicker(); }); </script>
			
			 
			<div style="width:30%; float:left;">
			
			
			<div class="input-prepend date span6" id="reg_field_'.$key.'_date" data-date="'.$db[0].'" data-date-format="yyyy-MM-dd hh:mm:ss">
			<span class="add-on"><i class="dashicons dashicons-calendar-alt" style="cursor:pointer"></i></span>
				<input type="text" name="custom['.$key.']" value="'.$e_value.'" id="reg_field_'.$key.'"  data-format="yyyy-MM-dd hh:mm:ss" />
			 </div>
			 
			 
			 </div>';
		 
			 
	} ?>
      <?php if(!isset($val['dateitem'])){ ?>
      <div class="input-group date">
        <?php  if($key == "price" || $key == "old_price" || $key == "current_price" || $key == "reserve_price"    || isset($val['price'])){ ?>
        <span class="add-on input-group-prepend"> <span class="input-group-text"><?php echo _ppt(array('currency','symbol'));   ?></span></span>
        <?php } ?>
        <input type="text" name="custom[<?php echo $key; ?>]" value="<?php echo $e_value; ?>" id="<?php echo $key; ?>" class="form-control" />
      </div>
      <?php } ?>
      <?php } ?>
      <?php if($key == "listing_expiry_date"){ ?>
      <a href="javascript:void(0);" onclick="jQuery('#reg_field_listing_expiry_date').val('<?php echo date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($CORE->DATETIME()))); ?>');" style="float:right;margin-top:5px;" class="button">Set Date Now (+5 mins)</a>
      <?php } ?>
      <?php if($key == "download_path"){ ?>
      <a href="javascript:void(0);" class="button" id="upload_logo">Select File</a>
      <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
      <script >

 function ChangeImgBlock(divname){
	document.getElementById("imgIdblock").value = divname;
} 
 
	jQuery('#upload_logo').click(function() {	
	 
	window.send_to_editor = function(html) {	
	var regex = /src="(.+?)"/;
    var rslt =html.match(regex);
    var imgurl = rslt[1];
	 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
	 tb_remove();
	} 
	
	 ChangeImgBlock('download_path'); 
	 formfield = jQuery('#download_path').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false; 
	 }); 
</script>
      <?php  }// end if this field is a tab ?>
    </div>
  </div>
  <!-- end form group -->
</div>
<!-- end col-md-6 -->
<?php if($i == 2){ ?>
<div class="clearfix"></div>
<div class=" mt-1"></div>
<?php $i = -1; } ?>
<?php $i++; }  }  ?>
<script type="application/javascript">
jQuery(document).ready(function(){	

	jQuery( "#field_listing_status" ).change(function() {
		var sdt = jQuery( "#field_listing_status" ).val();
		if(sdt == 10){
			 jQuery( "#table_row_listing_status_msg" ).show(0);
		}else{
			 jQuery( "#table_row_listing_status_msg" ).hide(0);
		} 
	});	
	var sdt = jQuery( "#field_listing_status" ).val();
	if(sdt == 10){
		jQuery( "#table_row_listing_status_msg" ).show(0);
	}else{
		jQuery( "#table_row_listing_status_msg" ).hide(0);
	} 
	
});
</script>
<?php 
}

 

 
/* =============================================================================
	USER DISPLAY PAGE CHANGES
	========================================================================== */
 
	function contributes_sortable_columns( $columns ) {
		$columns['c1'] = "Listings";
		$columns['c2'] = "Credit";
		if(THEME_KEY != "sp"){
		$columns['c3'] = "Membership";
		}
		
		return $columns;
	}
	function contributes($columns) {
			$columns['c1'] = "Listings";
			$columns['c2'] = "Credit";
			if(THEME_KEY != "sp"){
			$columns['c3'] = "Membership";
			}
			return $columns;
	}		
	function contributes_columns( $value, $column_name, $user_id ) { global $wp_query, $CORE;
			
			if ( 'c1' != $column_name && 'c2' != $column_name && 'c3' != $column_name ){ return $value; }
 			
			if($column_name == "c1"){
			
				$column_title = "Listings";
				$column_slug = THEME_TAXONOMY;
				$posts = query_posts('post_type='.$column_slug.'_type&author='.$user_id.'&order=ASC&posts_per_page=30');//Replace post_type=contribute with the post_type=yourCustomPostName
				$posts_count = "<a href='edit.php?post_type=".THEME_TAXONOMY."_type&author=".$user_id."' style='text-decoration:underline; font-weight:bold;'>".count($posts)."</a>";			 
				return $posts_count;
			
			}elseif($column_name == "c2"){
			
				$user_balance = get_user_meta($user_id,'ppt_usercredit',true);
				if($user_balance == ""){ $user_balance = 0; }
				return hook_price($user_balance);
			
			}elseif($column_name == "c3"){
			
				return $CORE->get_subscription_name($user_id);
			
			}
	}	
	function save_extra_user_profile_fields( $user_id ) {
	global $CORE, $wpdb;
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	
	

	
	}
	// USER FIELDS FOR THE ADMIN TO EDIT
	function userfields( $contactmethods ) { global $wpdb, $CORE;
	
	$regfields = get_option("regfields");
	if(is_array($regfields)){
		//PUT IN CORRECT ORDER
		$regfields = $CORE->multisort( $regfields , array('order') );
		foreach($regfields as $field){
		
		if(!isset($field['key'])){ continue; }
		
			// EXIST IF KEY DOESNT EXIST
			if(  $field['key'] == ""  && $field['fieldtype'] !="taxonomy" ){ continue; }
			$contactmethods[$field['key']]             = $field['name'];
		}		
	}
    
    return $contactmethods;
   }
   
  	
 
 
	
} // END CORE ADMIN CLASS

?>