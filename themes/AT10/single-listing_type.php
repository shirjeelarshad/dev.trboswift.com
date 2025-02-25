<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata, $post;

$GLOBALS['flag-singlepage'] = 1;
 
// LOGIN TO VIEW
$canContinue = true;

if(_ppt(array('design', 'requirelogin_listings' )) == 1 && !$userdata->ID){

$canContinue = false;

}elseif(_ppt(array('register', 'forcemailverify' )) == 1 && $userdata->ID && $CORE->USER("get_verified", $userdata->ID) == "0"){

	$ev = _ppt(array("emails","user_verify")); 
	if(isset($ev['enable']) && $ev['enable'] == 1){
		$canContinue = false;
		$link = _ppt(array('links','myaccount'));
	}

} 

if(!$canContinue){

	// DATING SEND TO MEMBERSHIPS PAGE
	if(THEME_KEY == "da"){
	
		if(_ppt(array('mem','register'))  == '1'){ 
			$link = wp_login_url();
		}else{
		$link = _ppt(array('links','memberships'));
		}
	
	}elseif(!isset($link)){
	
		$link = wp_login_url();	
	}

	header("location: ". $link);
	exit;

}

if(_ppt(array('mem','enable'))  == '1' && _ppt('mem0_view_listing') != "" && !$CORE->USER("membership_hasaccess", "view_listing")){
	
	$link = _ppt(array('links','memberships'))."?noaccess=1";
	if(!$userdata->ID){
		$link = wp_login_url();	
	} 	
	header("location: ". $link);
	exit;
}
 

// UPDATE VIEW COUNTER
$CORE->PACKAGE("update_hits", $post->ID);
		
// + UPDATE LAST VIEWED
$pv = get_post_meta($post->ID,'pageviewed',true);
if($pv != ""){
	update_post_meta($post->ID,'lastviewed', $pv);
}
update_post_meta($post->ID,'pageviewed',date("Y-m-d H:i:s"));
		
// UPDATE VIEW COUNTER
if(isset($userdata->ID) && $post->post_type == "listing_type"){
	$CORE->user_recentlyviewed($userdata->ID, $post->ID, false);
}



$pageLinkingID = _ppt_pagelinking("listingpage");
if( substr($pageLinkingID ,0,9) == "elementor" && !in_array(THEME_KEY, array("da","at","dt","mj")) ){

	get_header(); 
	
	// INCLUDE NORMAL ACCOUNT OPTIONS
	if($post->post_author == $userdata->ID){
	_ppt_template('author', 'toolbox' );
	}

	echo do_shortcode( "[premiumpress_elementor_template id='".substr($pageLinkingID,10,100)."']");
	
	_ppt_template('framework/design/single/all_js'); 
	
	get_footer();
	

}else{
    
	// + GLOBAL TOP
	get_header(); 
	
	// INCLUDE NORMAL ACCOUNT OPTIONS
	if($post->post_author == $userdata->ID){
	_ppt_template('author', 'toolbox' );
	}
	
	_ppt_template('framework/design/singlenew/all');	


	get_footer(); 

}  

 

 ?>