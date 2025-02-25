<?php

/*
 * Plugin Name: [IMPORT V10] - CSV Import/Export
 * Plugin URI: https://www.premiumpress.com
 * Description: This plugin will let you import/export via CSV.
 * Version: 1.4
 * Author URI: https://www.premiumpress.com
 * Updated April 18th 2021
 */


add_action('admin_init', 'PPT_ExportCSV');
function PPT_ExportCSV(){

// SETUP GLOBALS
global $wpdb, $CORE, $userdata;
 
if( current_user_can('administrator') && isset($_GET['exportdata'])){
	 
	 include( dirname(__FILE__).'/class_csv.php' );
			
			
			$f = $wpdb->get_results("SELECT ".$wpdb->prefix."posts.ID 
			FROM ".$wpdb->prefix."posts 
			WHERE ".$wpdb->prefix."posts.post_type ='listing_type' 
			AND ".$wpdb->prefix."posts.post_status='publish' LIMIT 1",ARRAY_A);
			
			if(!isset($f[0]) || isset($f[0])  && !isset($f[0]['ID'])){
			
				die(" YOU HAVE DATA TO EXPORT");
			}
			
			$custom_fields = get_post_custom($f[0]['ID']); 
			
			
			// CHECK FOR DEFAULT THEM FIELDS
			if(THEME_KEY == "cp"){
			
				foreach(array("coupon","store") as $k){
				
					if(!isset($custom_fields[$k])){
						$custom_fields[$k] = "";
					}
				}		
			
			}
			
			// EXPIRY DATE
			if(THEME_KEY != "sp"){
				$custom_fields["listing_expiry_date"] = "";
			}
			
			
			// GET ALL CUSTOM FIELDS			 
			$FF = array();	
			foreach($custom_fields as $k => $v){		 
				if(substr($k,0,1) == "_" ){ // DONT INCLUDE FIELDS THAT BEGIN WITH _		
				}else{ 	
				$FF[$k] ="";		
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

			$export = new data_export_helper($allposts);
			$export->set_mode(data_export_helper::EXPORT_AS_CSV);
			$export->export($export);
			
			echo $export;
			die();
			}else{
			die("<h1>There is no data to export</h1>"."Query run: ".$SQL);
			}


} }





//1. ADD NEW ADMIN MENU ITEMS FOR YOUTUBE
$GLOBALS['new_admin_menu'][] = array("v10_importcsv" => array("title" => "<img src='".plugins_url()."/v10_importcsv/icon.png' class='mr-2'> CSV Import", "link" => true ));
 

$iwp_base_path = dirname(__FILE__);

if (!defined('IWP_VERSION')) {
    define('IWP_VERSION', '1.0');
}

if (!defined('IWP_MINIMUM_PHP_VERSION')) {
    define('IWP_MINIMUM_PHP_VERSION', '5.4');
}

if (!defined('IWP_POST_TYPE')) {
    define('IWP_POST_TYPE', 'ppt-importer');
}

if (version_compare(PHP_VERSION, IWP_MINIMUM_PHP_VERSION, '>=')) {
    require_once $iwp_base_path . '/class/autoload.php';
 
 	add_action('plugins_loaded', 'iwp_pro_loaded');
}

function import_wp_pro()
{
    global $iwp;

    if (!is_null($iwp)) {
        return $iwp;
    }

    $iwp = new ImportWP\Pro\ImportWPPro();
    $iwp->register();
    return $iwp;
}

function iwp_pro_loaded()
{
    if (function_exists(('import_wp_pro'))) {
        import_wp_pro();
    }
}

