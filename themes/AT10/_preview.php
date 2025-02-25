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

global $CORE, $userdata, $settings;


if( _ppt_livepreview() ){

 
	if( $_GET['tid'] == "typography"){
	
	_ppt_template('framework/design/typography' );  
		
	}elseif(isset($_GET['sid'])){
	
		echo do_action( $_GET['sid']."-css" );
		echo do_action( $_GET['sid'] );
		echo do_action( $_GET['sid']."-js" );
		
	}else{
		
		// GET DATA
		$g = $CORE->LAYOUT("load_all_by_cat",  $_GET['tid']);
			
		if(in_array($_GET['tid'], array('text','icon','listings','header','cta','contact','video','faq'))){
			$order = array_column($g, 'order'); 
   			array_multisort( $order, SORT_ASC, $g);
		}	   
	   
	   foreach($g as $k => $g){ 
	   
			echo do_action( $k."-css" );
			echo do_action( $k );
			if($g['cat'] == "header" && isset($_GET['ppt_live_preview']) ){
						echo "<div style='height:200px; background:grey'></div>";
			}
			echo do_action( $k."-js" );						
		    echo "<div class='w-100 bg-black py-3 text-white text-center my-3'>".$k."</div>";
						
		}
	
	}
	echo "<style>body {    background: #ffffff !important;} html {    margin-top: 0px !important;  }</style>";
	
	die(); 

 } ?> 