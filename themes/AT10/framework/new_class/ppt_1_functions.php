<?php

// USED TO REORDER MEMBERSHIP ITEMS BY ORDER
function compare_order($a, $b){

	return strnatcmp($a['order'], $b['order']);
					
} 

function _get_country_search_box(){

global $wpdb;

 $SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a INNER JOIN ".$wpdb->postmeta." AS t ON ( a.meta_key = 'map-country' AND t.post_id = a.post_id ) LIMIT 60";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				$in_array = array(); $statesArray = array();
				?>
                 <select class=" form-control"  id="filter-country"  name="country">
       				<option value=""><?php echo __("Any Location","premiumpress"); ?></option>
				<?php	
					foreach ($results as $val){			
						
						$state = $val->meta_value;						
						if( !in_array($state,$in_array)){						
							
							// ADD TO ARRAY
							$in_array[] = $state;
							$statesArray[] .= $state;
						}// if in array					
					} // end while	
					
					// NOW RE-ORDER AND DISPLAY
					asort($statesArray);
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							
							
							$name = $state;
							if(isset($GLOBALS['core_country_list'][$state])){
							$name = $GLOBALS['core_country_list'][$state];
							}
							echo "<option value='".$state."'>". $name."</option>";
							
					}  
	 
	  
		  ?>
        
        </select> <?php
 
}

function _ppt_meta_title(){ global $post;

	// WEBSITE TITLE
	ob_start();
	// wp_title(); 
	$site_title 	= ob_get_clean(); 
	$custom_title 	= "";
	 
	
	// CHECK FOR PAGE KEY
	$pagekey = _ppt_pagekey();
	if(strlen($pagekey) > 1){
		
		// GET TITLE		
		if(is_page() && strlen(_ppt(array('seo', $pagekey.'_title'))) > 1){ // PAGES
		
			$custom_title = _ppt_meta_filter(_ppt(array('seo', $pagekey.'_title')), $pagekey);	
		  
		}elseif(isset($GLOBALS['flag-taxonomy-id']) && _ppt( array('seo',$GLOBALS['flag-taxonomy-id'].'_title')) != ""){
		
			$custom_title = _ppt( array('seo',$GLOBALS['flag-taxonomy-id'].'_title'));
				
		}elseif(strlen(_ppt(array('seo', $pagekey.'_title'))) > 1){
		
			$custom_title = _ppt_meta_filter(_ppt(array('seo', $pagekey.'_title')), $pagekey);
		}
		
		// CUSTOM TITLE
		if( strlen($custom_title) > 1 && _ppt(array('seo', $pagekey.'_force')) == 1){			
			$site_title = $custom_title;	
		}
	
	}
	
	// CHECK FOR PAGE TEMPLATE
	if(is_page_template() && _ppt(array('seo', 'pages_force')) == 1 ){
			
			$g = get_post_meta($post->ID,'_wp_page_template',true);	  
			$gb = explode("/",$g);
			if(isset($gb[1])){
				
				$newpagekey = str_replace("tpl-","",$gb[1]);
				$newpagekey = str_replace("page-","",$newpagekey);
				$newpagekey = str_replace(".php","",$newpagekey); 
								
				 
				if( strlen(_ppt(array('seo', 'page_'.$newpagekey.'_title'))) > 1){ // PAGES
		
					$site_title = _ppt_meta_filter(_ppt(array('seo', 'page_'.$newpagekey.'_title')), "pages");
					
				}elseif(strlen(_ppt(array('seo', 'pages_title'))) > 1){ // PAGES
		 
					$site_title = _ppt_meta_filter(_ppt(array('seo', 'pages_title')), "pages");
					 
		  		}
			 
			}
			 
	} 
	
	
	
	// FALLBACK
	if($site_title == ""){
	$site_title = get_option("blogname");
	}
	 
	// RETURN
	return $site_title;

}

function _ppt_meta_description(){

	global $post;

	$site_desc = "";
	$custom_desc = "";
	
	// CHECK FOR PAGE KEY
	$pagekey = _ppt_pagekey();
	 
	
	if(strlen($pagekey) > 1){
		
		// GET DESC	
		if(is_page() && strlen(_ppt(array('seo', $pagekey.'_desc'))) > 1){ // PAGES
		
			$custom_desc = _ppt_meta_filter(_ppt(array('seo', $pagekey.'_desc')), $pagekey);	
		  
		}elseif(isset($GLOBALS['flag-taxonomy-id']) && _ppt( array('seo',$GLOBALS['flag-taxonomy-id'].'_desc')) != ""){
		
			$custom_desc = _ppt( array('seo',$GLOBALS['flag-taxonomy-id'].'_desc'));
				
		}elseif(strlen(_ppt(array('seo', $pagekey.'_desc'))) > 1){
		
			$custom_desc = _ppt_meta_filter(_ppt(array('seo', $pagekey.'_desc')), $pagekey);
		}
		
		// CUSTOM TITLE
		if( strlen($custom_desc) > 1 && _ppt(array('seo', $pagekey.'_force')) == 1){			
			$site_desc = $custom_desc;	
		}
	
	}
	
	// CHECK FOR PAGE TEMPLATE
	if(is_page_template() && _ppt(array('seo', 'pages_force')) == 1 ){
			
			$g = get_post_meta($post->ID,'_wp_page_template',true);	  
			$gb = explode("/",$g);
			if(isset($gb[1])){
				
				$newpagekey = str_replace("tpl-","",$gb[1]);
				$newpagekey = str_replace("page-","",$newpagekey);
				$newpagekey = str_replace(".php","",$newpagekey); 
								
				 
				if( strlen(_ppt(array('seo', 'page_'.$newpagekey.'_desc'))) > 1){ // PAGES
		
					$site_desc = _ppt_meta_filter(_ppt(array('seo', 'page_'.$newpagekey.'_desc')), "pages");
					
				}elseif(strlen(_ppt(array('seo', 'pages_desc'))) > 1){ // PAGES
		 
					$site_desc = _ppt_meta_filter(_ppt(array('seo', 'pages_desc')), "pages");
					 
		  		}
			 
			}
			 
	} 
	
	
	// FACEBOOK IMAGES ADDON
	$out = '';
	if($pagekey == "home" && strlen(_ppt(array('ogdata', 'image'))) > 2 ){
	
		echo '<meta property="og:url" content="'.home_url().'" />
			<meta property="og:type" content="webpage" />
			<meta property="og:title" content="'._ppt(array('ogdata', 'title')).'" />
			<meta property="og:description" content="'._ppt(array('ogdata', 'desc')).'" />
			<meta property="og:image" content="'._ppt(array('ogdata', 'image')).'" />
			<meta property="og:image:width" content="700" />
			<meta property="og:image:height" content="700" />';
	
	}	
	
	if(strlen($site_desc) > 1){
	return '<meta name="description" content="'.$custom_desc.'">';
 	}
	
	return "";

}

function _ppt_meta_keywords(){

	// CHECK FOR PAGE KEY
	$pagekey = _ppt_pagekey();
	$custom_desc = "";
	
	if(strlen($pagekey) > 1){
	
		// GET DESCRIPTION
		if(strlen(_ppt(array('seo', $pagekey.'_keywords'))) > 2){
			$custom_desc = _ppt(array('seo', $pagekey.'_keywords'));
		}
	
	}
	
	if(strlen($custom_desc) > 1){
	return '<meta name="keywords" content="'.$custom_desc.'">';
 	}
	
	return "";

}

function _ppt_pagekey(){	
	
	foreach(_ppt_metapages() as $k => $page){

		if(isset($GLOBALS[$page['flag']])){
		
			return $k;
		}	
	}	
 	
	return "";
}

function _ppt_metapages(){

	$pages = array(
		
		"home"	=> array( 
			"name" 		=> "Home page", 
			"default" 	=> get_option("blogname"), 
			"order" 	=> 1, 
			"tags" 		=> array(),
			"flag" 		=> "flag-home"
		),
		 
		
		"category" => array( 
			"name" 		=> "Category page", 
			"default" 	=> "Categories &raquo; [CAT-NAME]", 
			"order" 	=> 2, 
			"tags" 		=> array("cat-name"),
			"flag" 		=> "flag-tax-listing",
		),
		
		"store" => array( 
			"name" 		=> "Store page", 
			"default" 	=> "[STORE-NAME]", 
			"order" 	=> 2, 
			"tags" 		=> array("store-name"),
			"flag" 		=> "flag-tax-store", // load this after category
		),
				
		
		"taxonomy" => array( 
			"name" 		=> "Taxonomy pages", 
			"default" 	=> "[TAX-NAME]", 
			"order" 	=> 3, 
			"tags" 		=> array("tax-name"),
			"flag" 		=> "flag-taxonomy", // load this after category
		), 
				
		"search" => array( 
			"name" 		=> "Search page", 
			"default" 	=> "", 
			"order" 	=> 4, 
			"tags" 		=> array("keyword"),
			"flag" 		=> "flag-search",
			
		),
		
		"listing" => array( 
			"name" 		=> "Main listing page", 
			"default" 	=> "[TITLE] - [CATEGORY]", 
			"order" 	=> 5, 
			"tags" 		=> array("title","category"),
			"flag" 		=> "flag-singlepage",
			
		),
		
		
		"pages" => array( 
			"name" 		=> "Pages", 
			"default" 	=> "[TITLE]", 
			"order" 	=> 6, 
			"tags" 		=> array("title"),
			"flag" 		=> "flag-page",
			
		),
		
		
	);
	
	//
	if(defined('THEME_KEY') && THEME_KEY == "cp" ){
	
	}else{
	unset($pages['store']);
	}
	
	return $pages;

}

function _ppt_meta_filter($title, $pagekey){ global $post;

	foreach(_ppt_metapages() as $k => $page){

		if($k == $pagekey){
			
			foreach($page['tags'] as $t => $d){
				
				switch($k){
				
					case "pages": {
					  
						$title = str_replace("[TITLE]", get_the_title($post->ID), $title);						 
					
					} break;
				
					case "category": {
						
						// KEYWORD
						$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						
						//print_r($term->term_id);
						 
						$title = str_replace("[CAT-NAME]", $term->name, $title);
						 
					
					} break;
					
					case "store": { 
					
						// KEYWORD
						$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						 
						$title = str_replace("[STORE-NAME]", $term->name, $title);
						
					
					} break;
					
					case "taxonomy": {
					
					
						// KEYWORD
						$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						 
						$title = str_replace("[TAX-NAME]", $term->name, $title);
						
					
					} break;
				
					case "search": {
						
						// KEYWORD
						if(isset($_GET['s'])){
						$title = str_replace("[KEYWORD]", $_GET['s'], $title);
						}
					
					} break;
					
					case "listing": {
						
						// KEYWORD
						 
						$title = str_replace("[TITLE]", do_shortcode("[TITLE]"), $title);
						
						$title = str_replace("[CATEGORY]", do_shortcode("[CATEGORY link=0]"), $title);
						 
					
					} break;
					
				
				} // END SWITCH
			}		 
		}	
	}
	
	return $title;
}





function _ppt_livepreview(){

 
	if(isset($_GET['ppt_live_preview']) && isset($_GET['tid']) && $_GET['tid'] != "" && function_exists('current_user_can') && current_user_can('administrator') ){
	
		return 1;
	
	}
	return 0;
}
 
 
function _ppt_demopath(){	
	
	$path = DEMO_IMG_PATH.THEME_KEY;
		
	if(!defined('WLT_DEMOMODE')  && ( isset($_GET['loadpage']) || isset($_POST['loaddesign']) ) ){
		$path .= "/ELEMENTOR/";
	}	
	return $path;
}
function _ppt_custom_searchlist(){

	 
	$customlist = array(
			'' => __( 'Default Orderby', 'premiumpress' ),				
			'featured' => __( 'Featured Items', 'premiumpress' ),	
			'sponsored' => __( 'Sponsored Items', 'premiumpress' ),	
			
			'homepage' => __( 'Homepage Items', 'premiumpress' ),	
						
			'popular' => __( 'Popular Items', 'premiumpress' ),			
			'random' => __( 'Random Items', 'premiumpress' ),
			'new' => __( 'New Items', 'premiumpress' ), 
	);
	
	if(defined('THEME_KEY') && in_array(THEME_KEY, array("da","es")) ){	
		$customlist["men"] = __( 'Male Profiles', 'premiumpress' );
		$customlist["women"] = __( 'Female Profiles', 'premiumpress' );	
	}
	
	if(defined('THEME_KEY') &&  THEME_KEY == "at"){
		$customlist["endingsoon"] = __( 'Items Ending Soon', 'premiumpress' );
	}
	
	if(defined('THEME_KEY') &&  in_array(THEME_KEY, array("dt","cm"))){
		$customlist["rating"] = __( 'Rated Items', 'premiumpress' );
	}
	
	
	return $customlist;
}

function _ppt_pagelinking($key){ global $CORE;
 	 
	// CHECK FOR DEMO CONTENT
	// ELEMENTOR CONTENT
	if(isset($_SESSION['design_preview']) && strlen($_SESSION['design_preview']) ){
	
		$g = $CORE->LAYOUT("load_single_design", $_SESSION['design_preview']);
		
		if(isset($g['elementor']) && is_array($g['elementor'])  && isset($g['elementor'][$key])){
		 	
			$preview_name = $key." - ".date('Y');			 		
			
			// CHECK FOR PAGE
			$exi = get_page_by_title( $preview_name , OBJECT, 'elementor_library') ;	 
		
			// CHECK EXISTS
			if ($exi && $exi->post_status == "publish") {
			
				$f = get_page_by_title( $preview_name , OBJECT, 'elementor_library');
				
				return "elementor-".$f->ID;			 
			
			// CREATE NEW ONE
			}else{	
			
				// DELETE CURRENT PAGE
				if($exi){
					wp_delete_post($exi->ID, true);
				}
			
				$elementor_file = $g['elementor'][$key];	
			 
				if(!file_exists($elementor_file)){ unset($_SESSION['design_preview']); die("preview file not found"); }
				 
				// PROCESS IT 
				$elementor_importer = new PremiumPress_Elementor_Importer();
				$id = $elementor_importer->import_elementor_file( $elementor_file, $key." - ".date('Y') );
			 
				
				if( !is_wp_error( $id ) ) {	
				
					return "elementor-".$id;				 			 		
				
				}else{				
					die($id->get_error_message());			
				}					
					
			}
						
		}		
	
	}
	
	// CURRENT LANG
	$cl = strtolower($CORE->_language_current());
	$check = "";
	
	// CHECK MOBILE
	if( $CORE->isMobileDevice() ){  	
	 
	 	// CHECK FOR MOBILE PAGE
		$checkKey 		= $key.'_mobile_'.$cl;
 		$check 			= _ppt(array('pageassign', $checkKey ));
		if($check == ""){		
			$checkKey 	= $key."_mobile";
			$check 		= _ppt(array('pageassign', $key."_mobile" ));
		} 		  
	
	}
	
	if(in_array($check, array("","0")) ){
	
	 	// CHECK FOR PAGE
		$checkKey 		= $key.'_'.$cl;
 		$check 			= _ppt(array('pageassign', $checkKey ));
		if($check == ""){		
			$checkKey 	= $key;
			$check 		= _ppt(array('pageassign', $key ));
		}
			
	}
 	
	if($check != "" && !in_array($check, array("","0")) && !in_array($key, array("header","footer")) && !isset($_GET['reset']) && substr($check,0,5) == "page-"){
	 	
			$g = explode("-",$check);			
			$rpage = get_permalink($g[1]);
			
			if(strlen($rpage) > 5){		
				header("location:".$rpage."");
				exit();
			}
			
	}
	
	if( $check != "" && !in_array($check, array("","0")) ){
 		
			// CHECK FOR ELEMENETOR
			$CORE->_elementor_scripts($checkKey);
					
			// RETURN
			return $check;		
	}
	
	return 0;

}
 

function _ppt_single_layouts(){


// CORE THEME STYLES ARRAY
$themes = array(


	"cp" => array(	
	
		"1" => array(				
				"verytop" => array( ),	
				"top" => array(  "top-text",  "top-coupon",   ),					 
				"content" => array(  "single-video" ),							 
				"sidebar" => array(  ),
				
				"hide_footer_related" => true,
				  				 
		), // end design 1	
 	
		
		"elements" => array( 
		
		 
		), 
		
		
			
	),	
	
	
	"ex" => array(	
	
	
		
		"1" => array(	
				"verytop" => array( ),			
				"top" => array(    ),	 				
				"content" => array(  "single-content-ex",), 								 
				"sidebar" => array( "sidebar-ex" ), 				 
		), // end design 4	
 
 
		
		"elements" => array( 
		
			 
			//"bids" 			=> __("Bids","premiumpress"), 
			 
			//"condition" 	=> __("Condition","premiumpress"),
			"shipping" 		=> __("Shipping","premiumpress"),
			//"user" 			=> __("Author","premiumpress"),			
			//"reserve" 			=> __("Reserve Price","premiumpress"),
			//"features" 		=> __("Features","premiumpress"),
			//"delivery" 		=> __("Delivery Box","premiumpress"), 
			 
		), 
			
	),
	
	"bo" => array(	
	
	
		
		"1" => array(	
				"verytop" => array(  "top2"),			
				"top" => array(    ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-author", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "" ), 				 
		), // end design 4	
		
 		
		"elements" => array( 
		
			 
			"bids" 			=> __("Bids","premiumpress"), 
			"refunds" 		=> __("Refunds","premiumpress"),
			"condition" 	=> __("Condition","premiumpress"),
			"shipping" 		=> __("Shipping","premiumpress"),
			"user" 			=> __("Author","premiumpress"),			
			"reserve" 			=> __("Reserve Price","premiumpress"),
			//"features" 		=> __("Features","premiumpress"),
			"delivery" 		=> __("Delivery Box","premiumpress"), 
			 
		), 
			
	),
	
	
	
	
	"ph" => array(	
	
	
		
		"1" => array(	
				"verytop" => array(  "top2"),			
				"top" => array(    ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-author", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "" ), 				 
		), // end design 4	
		
 		
		"elements" => array( 
		 
		), 
			
	),
		
	
	"es" => array(	
	
	
		
		"1" => array( ), // end design 4	
		
 		
		"elements" => array( 
		 
		), 
			
	),
		

	"at" => array(	
	
	
		
		"1" => array(	
				"verytop" => array(  "top2"),			
				"top" => array(    ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-author", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-at" ), 				 
		), // end design 4	
		
	
		
		"2" => array(	
				"verytop" => array(  ),	
				"top" => array(  ),									 
				"content" => array( "at-product", "single-hr", "single-content","single-author",   "single-video", "single-video-youtube",   ),								 
				"sidebar" => array(  ), 
		),   // end design 1		
		
		"3" => array(				
				"verytop" => array(  ),		
				"top" => array( ),				 
				"content" => array( "single-text", "single-images-slider2", "single-content", "single-author",  "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-at" ),  				 
		), // end design 3
			
		"4" => array(	
				"verytop" => array(  ),			
				"top" => array(  "top-text",  ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-author",  "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-at" ), 				 
		), // end design 4			
		
	
			
	
		"5" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-at" ),  				 
		), // end design 3	
		
		"6" => array(	
				"verytop" => array(  ),			
				"top" => array(    ),	 				
				"content" => array( "single-product" ), 								 
				"sidebar" => array(  ), 
				
				//"hide_footer_related" => true,								 
		), // end design 4
		
 	
		
		"elements" => array( 
		
			 
			//"bids" 			=> __("Bids","premiumpress"), 
			//"refunds" 		=> __("Refunds","premiumpress"),
			"condition" 	=> __("Condition","premiumpress"),
			"shipping" 		=> __("Shipping","premiumpress"),
			//"user" 			=> __("Author","premiumpress"),			
			"reserve" 			=> __("Reserve Price","premiumpress"),
			//"features" 		=> __("Features","premiumpress"),
			"delivery" 		=> __("Delivery Box","premiumpress"), 
			 
		), 
			
	),	
	

	"mj" => array(	
	 
	
		"1" => array(				
				"verytop" => array(   ),	
				"top" => array( ),					 
				"content" => array( "single-text", "single-images-slider2", "single-content", "single-author", "single-video", "single-video-youtube",  "single-comments" ),							 
				"sidebar" => array( "sidebar-mj" ),  				 
		), // end design 3	
 
		
		"3" => array(				
				"verytop" => array( "top2" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content",  "single-author", "single-video", "single-video-youtube", "single-comments" ),							 
				"sidebar" => array( "sidebar-mj" ),  				 
		), // end design 3	
	
		"2" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content",  "single-author", "single-video", "single-video-youtube",  "single-comments" ),							 
				"sidebar" => array( "sidebar-mj" ),  				 
		), // end design 3	
 
		
	
	
		
		"4" => array(				
				"verytop" => array(   ),	
				"top" => array( "top-text" ),					 
				"content" => array(  "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-author",  "single-comments" ),							 
				"sidebar" => array( "sidebar-mj" ),  				 
		), // end design 3	
 		
		
		
		"elements" => array( 
		
			"days" 		=> __("Completion Time","premiumpress"), 
			"sold" 	=> __("jobs Sold","premiumpress"), 		
			"waiting" 	=> __("Waiting","premiumpress"),  
					
			//"online" 		=> __("Online Status","premiumpress"), 
			//"user" 	=> __("Seller","premiumpress"),
			"id" 	=> __("Job ID","premiumpress"),
			
			
		), 
			
	),	

	
	"da" => array(	
	
		"1" => array(				
				"verytop" => array( "top" ),	
				"top" => array( ),									 
				"content" => array(  ), 	//"single-images-slider2", "single-content", "single-video", "single-video-youtube", "single-map"  							 
				"sidebar" => array(  ),   //"sidebar-da"				 
		), // end design 2	
		
		"elements" => array( 
		
		
			 
			"gender" 		=> __("Gender","premiumpress"), 
			"sexuality" 	=> __("Sexuality","premiumpress"), 		
			
			//"age" 	=> __("Age","premiumpress"),  
					
			"dathnicity" 		=> __("Ethnicity","premiumpress"), 			
			"eye" 	=> __("Eye Color","premiumpress"),
			"hair" 	=> __("Hair Color","premiumpress"),
			
			"body" 		=> __("Body Shape","premiumpress"), 			
			"smoke" 	=> __("Smoker","premiumpress"),
			"drink" 	=> __("Drinker","premiumpress"),
			
			//"features" 	=> __("Features","premiumpress"),
			
		
 		
		), 
 		
	),
	
	"dt" => array(	
	
		"1" => array(				
				"verytop" => array( "top2" ),	
				"top" => array( ),									 
				"content" => array( "single-content", "single-openinghours", "single-video", "single-video-youtube",  "single-images-wall",  "single-map",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-dt" ),  				 
		), // end design 2	
		"2" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-openinghours", "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-dt" ),  				 
		), // end design 3	
	
		"3" => array(				
				"verytop" => array(  ),		
				"top" => array( ),				 
				"content" => array( "single-text", "single-images-slider2", "single-content", "single-openinghours", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-dt" ),  				 
		), // end design 3	
		"4" => array(	
				"verytop" => array(  ),			
				"top" => array(  "top-text",  ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-openinghours", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-dt" ), 				 
		), // end design 4	
		
		"elements" => array( 
		 
			//"category" 	=> __("Category","premiumpress"), 		
			//"location" 	=> __("Location","premiumpress"),  		
			
			//"features" 	=> __("Features","premiumpress"), 
			
		), 
	),
 

	"dl" => array(		
		"2" => array(
				"verytop" => array(  "top2" ),					
				"top" => array( ),									 
				"content" => array( "single-images", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-dl" ),  
		), // end design 2	
		"1" => array(	
				"verytop" => array(  ),				
				"top" => array( ),					 
				"content" => array( "single-text", "single-images", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-dl" ),  				 
		), // end design 3
		"3" => array(
				"verytop" => array(  "top1"  ),					
				"top" => array( ),					 
				"content" => array( "single-content", "single-video", "single-video-youtube",  "single-map", "single-comments" ), 								 
				"sidebar" => array( "sidebar-images", "sidebar-dl" ),				 
		), // end design 1			
		"4" => array(	
				"verytop" => array(   ),	
				"top" => array( "top-text", ),					
				"content" => array( "single-images-slider2",   "single-content", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-dl" ), 				 
		), // end design 4
		
		"elements" => array( 
		
			"miles" 		=> __("Miles","premiumpress"), 
			"year" 		=> __("Year","premiumpress"), 		
			"make" 		=> __("Make","premiumpress"),  		
			"model" 	=> __("Model","premiumpress"),  		
			  
			"fuel" 		=> __("Fuel","premiumpress"), 
			"condition" => __("Condition","premiumpress"),
			"body" 		=> __("Body","premiumpress"), 
			
			"transmission" 	=> __("Transmission","premiumpress"), 
			"exterior" => __("Exterior","premiumpress"),
			"interior" 	=> __("Interior","premiumpress"), 
			
			"doors" 	=> __("Doors","premiumpress"), 
			"engine" 	=> __("Engine","premiumpress"),
			"drive" 	=> __("Drive","premiumpress"),
			
			"seller" 	=> __("Seller","premiumpress"), 
			"owners" 	=> __("owners","premiumpress"),
			//"category" 	=> __("Category","premiumpress"),
			
			 
			//"features" 	=> __("Features","premiumpress"),
			
		
		), 
		
	),
	
	"cm" => array(	
		"1" => array(	
				"verytop" 	=> array(  ),				
				"top" 		=> array( ),					 
				"content" 	=> array( "single-text",  "single-content",  "single-video", "single-video-youtube", "single-images-wall", "single-comments"  ),							 
				"sidebar" 	=> array( "sidebar-cm" ),  				 
		), // end design 3
		"2" => array(
				"verytop" 	=> array(  "top2" ),					
				"top" 		=> array( ),									 
				"content" 	=> array( "single-content", "single-video", "single-video-youtube",  "single-images-wall", "single-comments" ), 								 
				"sidebar" 	=> array( "sidebar-cm" ),  
		), // end design 2			
		"3" => array(
				"verytop" => array(  "top1"  ),					
				"top" => array( ),					 
				"content" => array( "single-content", "single-video", "single-video-youtube",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-cm" ),				 
		), // end design 1			
		"4" => array(	
				"verytop" => array(  ),	
				"top" => array( ),					
				"content" => array( "single-text", "single-images-slider2",   "single-content", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-cm" ), 				 
		), // end design 4
		
		"elements" => array( ),
	),
	
	
	"sp" => array(
	
		"1" => array(	
				"verytop" => array(  ),	
				"top" => array(  ),									 
				"content" => array( "sp-product", "single-video", "single-video-youtube" ),								 
				"sidebar" => array(  ), 
		),   // end design 1	
		
		"2" => array(	
				"verytop" => array(  "top2"   ),				
				"top" => array(),									 
				"content" => array(   "single-content", "single-video", "single-video-youtube",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-images", "sidebar-cart",  ),  				 
		), // end design 2	
		
		"3" => array(	
				"verytop" => array( "top1"  ),				
				"top" => array(  ),									 
				"content" => array(   "single-content", "single-video", "single-video-youtube",  "single-comments" ),								 
				"sidebar" => array( "sidebar-cart",  ), 				 
		), // end design 3		
		
		"4" => array(		
				"verytop" => array(  ),			
				"top" => array(   ),									 
				"content" => array(  "single-text",  "single-content", "single-video", "single-video-youtube", "single-comments" ), 								 
				"sidebar" => array( "sidebar-cart",  ), 				 
		), // end design 3	
		
		"elements" => array( ),				
	
	),
	
	 
	
	"ct" => array(
	
	
		"1" => array(				
				"verytop" => array( "top2" ),	
				"top" => array( ),									 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-ct" ),  				 
		), // end design 2	
		
		
			"2" => array(				
				"verytop" => array(  ),		
				"top" => array( ),				 
				"content" => array( "single-text", "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-ct" ),  				 
		), // end design 3	
		
		"3" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-ct" ),  				 
		), // end design 3	
	

	
		
		"4" => array(	
				"verytop" => array(  ),			
				"top" => array(  "top-text",  ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments"), 								 
				"sidebar" => array( "sidebar-ct" ), 				 
		), // end design 4
		
		
		"5" => array(	
				"verytop" => array(  ),			
				"top" => array(    ),	 				
				"content" => array( "single-product" ), 								 
				"sidebar" => array(  ), 
				
				//"hide_footer_related" => true,								 
		), // end design 4
		
		
		"elements" => array(
		
		"delivery" 		=> __("Shipping Fields","premiumpress"),
		
		 ),		
	),	
	
	
	
	
	"rt" => array(	
		"1" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-rt" ),  				 
		), // end design 3	
		"2" => array(				
				"verytop" => array( "top2" ),	
				"top" => array( ),									 
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-rt" ),  				 
		), // end design 2	
		"3" => array(				
				"verytop" => array(  ),		
				"top" => array( ),				 
				"content" => array( "single-text", "single-images-slider2", "single-content", "single-video", "single-video-youtube", "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-rt" ),  				 
		), // end design 3	
		"4" => array(	
				"verytop" => array(  ),			
				"top" => array(  "top-text",  ),	 				
				"content" => array( "single-images-slider2", "single-content", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array( "sidebar-rt" ), 				 
		), // end design 4	
		
		"elements" => array( 
		 
			//"size" 			=> __("Size","premiumpress"), 		
			//"beds" 			=> __("Beds","premiumpress"),  		
			//"baths" 		=> __("Baths","premiumpress"), 
			//"features" 		=> __("Features","premiumpress"), 
			
			
			 
		), 
			
	),
	
	
	"jb" => array(	
		"1" => array(				
				"verytop" => array( "top1" ),	
				"top" => array( ),					 
				"content" => array(  "single-content", "single-video", "single-video-youtube", "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-jb"  ),  				 
		), // end design 3	
		"2" => array(				
				"verytop" => array( "top2" ),	
				"top" => array( ),									 
				"content" => array(  "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ), 								 
				"sidebar" => array( "sidebar-jb"  ),  				 
		), // end design 2	
		"3" => array(				
				"verytop" => array(  ),		
				"top" => array( ),				 
				"content" => array( "single-text", "single-content", "single-video", "single-video-youtube",  "single-map",  "single-comments" ),							 
				"sidebar" => array( "sidebar-jb"  ),  				 
		), // end design 3	
		"4" => array(	
				"verytop" => array(  ),			
				"top" => array(  "top-text",  ),	 				
				"content" => array( "single-content", "single-video", "single-video-youtube",  "single-map", "single-comments"), 								 
				"sidebar" => array(  "sidebar-jb" ), 				 
		), // end design 4		
		
		
		"elements" => array( 
		
			"date" 		=> __("Date","premiumpress"), 
			"salary" 	=> __("Salary","premiumpress"), 		
			"hours" 	=> __("Hours","premiumpress"),  		
			  
			"offers" 	=> __("Offers","premiumpress"), 
			"experience" => __("Experience","premiumpress"),
			"category" 	=> __("Category","premiumpress"),
			 
			
		), 
		
	),	
	
	
	
	"vt" => array(	
	
		"1" => array(				
				"verytop" => array(  ),	
				"top" => array( ),									 
				"content" => array( "single-video-vt", "single-content", "single-comments" ), 								 
				"sidebar" => array( "sidebar-vt" ),  				 
		), // end design 2	
		
		"elements" => array( ),
 	
	),
	
	
	
	"ll" => array(	
	
		"1" => array(				
				"verytop" => array(  ),	
				"top" => array( ),									 
				"content" => array( "single-video-vt", "single-content", "single-comments" ), 								 
				"sidebar" => array( "sidebar-vt" ),  				 
		), // end design 2	
		
		"elements" => array( ),
 	
	),
 
	"so" => array(	
	
		"1" => array(				
				"verytop" => array(  ),	
				"top" => array( ),									 
				"content" => array( "single-download", "single-content", "single-video", "single-video-youtube", "single-comments",   ), 								 
				"sidebar" => array( "sidebar-so" ),  				 
		), // end design 2	
		
		"elements" => array( 		
		
			//"id" 	=> __("Product ID","premiumpress"), 
			
			//"version" => __("Version","premiumpress"),
			
			//"date" => __("Date Added","premiumpress"),
			
			//"category" 	=> __("Category","premiumpress"),
			
			//"user" => __("User Icon","premiumpress"),
			
			//"useritems" => __("User Items","premiumpress"),
			
		
		),
 	
	),
	
	
	
	
	
	
	
	
	"pj" => array(	
	
		"1" => array(				
				"verytop" => array(  ),	
				"top" => array( ),									 
				"content" => array(  "single-content", "single-video", "single-video-youtube", "single-comments",   ), 								 
				"sidebar" => array( "sidebar-PJ" ),  				 
		), // end design 2	
		
		"elements" => array( 		
		
			//"id" 	=> __("Product ID","premiumpress"), 
			 	
		
		),
 	
	),
	
	
	
	
	
	
		
);

return $themes[THEME_KEY];
 

}

function _ppt_custom_text($text, $matchkey = false){

	$captions = array(
		"condition" 	=> __("Condition","premiumpress"),
		"make" 			=> __("Make","premiumpress"),
		"model" 		=> __("Model","premiumpress"),
		
		"level" 		=> __("Difficulty Level","premiumpress"),
		
		"color" 		=> __("Color","premiumpress"),
		"size" 			=> __("Size","premiumpress"),
		"brand" 		=> __("Brand","premiumpress"),
		
		"body" 			=> __("Body","premiumpress"),
		"fuel" 			=> __("Fuel","premiumpress"),
		"transmission" 	=> __("Transmission","premiumpress"),
		"exterior" 		=> __("Exterior","premiumpress"),
		"interior" 		=> __("Interior","premiumpress"),
		"doors" 		=> __("Door","premiumpress"),
		"seller" 		=> __("Seller","premiumpress"),
		"features" 		=> __("Features","premiumpress"),
		"engine" 		=> __("Engine","premiumpress"),
		"drive" 		=> __("Drive","premiumpress"),
		"owners" 		=> __("Owners","premiumpress"),
		
		"ctype"			=> __("Type","premiumpress"),
		"jobtype"		=> __("Type","premiumpress"),
		
		"dagender" 		=> __("Gender","premiumpress"),
		"daseeking"		=> __("Seeking","premiumpress"),
		"dasexuality"	=> __("Sexuality","premiumpress"),
		"dathnicity"	=> __("Ethnicity","premiumpress"),
		"daeyes"		=> __("Eyes Color","premiumpress"),
		"dahair"		=> __("Hair Color","premiumpress"),
		"dabody"		=> __("Body","premiumpress"),
		"dasmoke"		=> __("Smoking","premiumpress"),
		"dadrink"		=> __("Drinking","premiumpress"),
		"dastarsign"	=> __("Star Sign","premiumpress"),
		
		
		"cameratype" 	=> __("Camera","premiumpress"),
		"license" 		=> __("License","premiumpress"),
		"orientation" 	=> __("Orientation","premiumpress"),
	 
	);
	
	if($matchkey){
		
		if(array_key_exists($text,$captions)){
		return true;
		}else{
		return false;
		}
	}
 	
	if(isset($captions[$text])){
		return $captions[$text];
	}
	return "";

}
 
 
 

function menuaddondata(){ 
return ""; // REMOVED 9.4.4
}


function _ppt_template($n, $n1 = ''){

	get_template_part($n, $n1);
	
}



function google_validate_recaptcha(){
 
 		 
		$response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret'   =>  stripslashes(_ppt(array('captcha','secretkey'))),
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        ) );
	 	
		if (!is_wp_error($response) && ($response['response']['code'] == 200)){
		
			$response_body = json_decode( $response['body'] );
			
			if ( empty( $response_body->success ) || ! $response_body->success ) {
				return false;
			}
			
			return true;
		
		}else{
			return false;
		}
}
 
/*
	this function will stop wordpress showing 404 pages
*/
function _ppt_check_pagetemplate_request($c){
 
return $c;
}
add_filter( 'template_include',  '_ppt_check_pagetemplate_request'  );

function _ppt_checkfile($filename){

	return false;// ERRORS IN DEMO - NEEDS MORE TESTING
	
}
function _ppt_theme_part($c){ global $post;
 
	// MUST BE IN TWO PARTS
	// 1. PATHS / 2. NAME //3. FORCE ($c[2]
 
	if(defined('THEME_FOLDER') ){		
		// CHECK IF CHILD THEME HAS THIS FILE
		// OTHERWISE LET THEME USE DEFAULT		
		if(defined('CHILD_THEME_NAME') && file_exists(get_stylesheet_directory()."/".$c[0]."-".$c[1].".php") ){
			return $c[0];	
		}else{ 
			 
			return constant('THEME_FOLDER')."/".$c[0];
		}
	}
	return $c[0];
}
/*
	this function returns the folder path
	for the correct file, fallback to theme
	default is no child theme variation found
*/
function _ppt_theme_folder($c, $force = false){ global $post;
 
	// MUST BE IN TWO PARTS
	// 1. PATHS / 2. NAME //3. FORCE ($c[2]	 	 	
	if( ( !is_array($c)  || ( isset($post->post_type) && $post->post_type != "listing_type" ) ) && !isset($c[2]) ){ return $c[0]; }
	
 
	if(defined('THEME_FOLDER') ){		
		// CHECK IF CHILD THEME HAS THIS FILE
		// OTHERWISE LET THEME USE DEFAULT	
		 
		if(defined('WLT_DEMOMODE') && isset($GLOBALS['childtemplate']) && file_exists(WP_CONTENT_DIR."/themes/".$GLOBALS['childtemplate']."/".$c[0]."-".$c[1].".php") ){
		
		return $c[0];	
 
		}elseif(defined('CHILD_THEME_NAME') && file_exists(get_stylesheet_directory()."/".$c[0]."-".$c[1].".php") ){
		
			return $c[0];	
		
		}elseif(file_exists(THEME_PATH."/templates/".$c[0]."-".$c[1].".php") ){ // CHECK OUR PARTS FOLDER
 
			return "templates/".$c[0];			
		
		}elseif(file_exists(THEME_PATH.constant('THEME_FOLDER')."/template/".$c[0]."-".$c[1].".php") ){ 
		 
			return constant('THEME_FOLDER')."/template/".$c[0];
			
		}else{ 
			 
			return constant('THEME_FOLDER')."/".$c[0];
		}
	}
	return $c[0];
}
function _ppt($a){
   
	$core_data = get_option("core_admin_values");	 

	// HOMEPAGE DESIGN CHANGER
	if(defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']) && isset($_GET['design']) || (  defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']) && isset($_SESSION['design_preview']) ) ){	 
 	
		$core_data = $GLOBALS['CORE_THEME']; 

	} 	 
	
	if(function_exists('current_user_can')  && current_user_can('administrator')  && isset($GLOBALS['CORE_THEME']) && isset($_GET['design']) ){
	
		$core_data = $GLOBALS['CORE_THEME']; 
	
	}
	
	
	if(is_array($a)){
 	
		if( isset($core_data[$a[0]][$a[1]]) ){
		 	
			if(is_string($core_data[$a[0]][$a[1]])){						
				return stripslashes($core_data[$a[0]][$a[1]]);				
			}else{
				return $core_data[$a[0]][$a[1]];
			}
					
		}else{		
			return "";		
		}
	
	}else{
 
 
		// DEMO EXTRAS
		if(isset($core_data[$a]) ){
		 
			if(is_string($core_data[$a])){							
				return stripslashes($core_data[$a]);
			}else{
				return $core_data[$a];
			}
			
		}else{		
			return "";		
		}	
	}
		 
}
/*
	this function is used throughout
	plugins and core for adding
	term values to existing taxonomies
*/
function _ppt_term_add($name, $tax, $parent = 0){
	
	// VALIUDATE
	if($name == ""){ return false; }
	
	// REGISTER IF DOESNT EXIST
	if(!taxonomy_exists($tax)){
	register_taxonomy( $tax, 'listing_type', array( 'hierarchical' => true, 'labels' =>'', 'query_var' => true, 'rewrite' => true ) ); 
	}
	
	if ( term_exists( $name , $tax ) ){	
	
			$term = get_term_by('slug', $name, $tax );		 
			$nparent  = $term->term_id;
			$saved_cats_array[] = $term->term_id;
				
	}else{
		
		$cat_id = wp_insert_term($name, $tax, array('cat_name' => $name, 'parent' => $parent ));
	 	 
		if(!is_object($cat_id) && isset($cat_id['term_id'])){
		
			$saved_cats_array[] = $cat_id['term_id'];
			$nparent = $cat_id['term_id'];
			
		}else{
		
			$nparent = $cat_id->term_id;
			
		}	 // end if	
		 
	} 
	
	return $nparent;

}


 
		 
/* =============================================================================
[FRAMEWORK] CORE FUNCTIONS
========================================================================== */

class framework_functions {



function _ppt_filter_link($link){

	$link = str_replace( "[link-contact]", _ppt(array('links','contact')), $link );
	$link = str_replace( "[link-add]", _ppt(array('links','add')), $link );
	$link = str_replace( "[link-stores]", _ppt(array('links','stores')), $link );
	$link = str_replace( "[link-search]", home_url()."/?s=", $link );
	$link = str_replace( "[link-login]", wp_login_url(), $link );
	$link = str_replace( "[link-join]", wp_registration_url(), $link );
	$link = str_replace( "[link-register]", wp_registration_url(), $link );
	$link = str_replace( "[link-membership]", _ppt(array('links','memberships')), $link );
	
	return $link;
}


function FUNC($action='add', $order_data){

global $userdata, $wpdb, $CORE;
 
	switch($action){
	
		case "demo_title": {
		 
		
			switch(THEME_KEY){
			
				case "cp": {
				
					$randomeTitle = array(
						1 => "20% Off With in-store pick-pp", 
						2 => "Free Shipping with this coupon code", 
						3 => "50% when you shop in store today",
						4 => "Buy Obe get One Free Between 3pm and 6pm.",
						5 => "Save 35% on purchased over $50",
						6 => "Enjoy Free Shipping on orders over $100",
						7 => "Buy Now Deliver Tomorrow with this coupon code.",
						8 => "Up to 15% Off When You Join Newsletter",
						9 => "Up to 33% Off Selected Bikes",
						10 => "30% Off When you buy Two",
						11 => "Up to 33% Off Selected Items",
						12 => "Up to $20 Off Summer Items", 
						13 => "20% Off With in-store pick-pp", 
						14 => "Free Shipping with this coupon code", 
						15 => "50% when you shop today",
						16 => "Buy One get One Free Between 3pm and 6pm.",
						17 => "Save 35% on purchased over $50",
						18 => "Enjoy Free Shipping on orders over $100",
						19 => "Buy Now Deliver Tomorrow with this coupon code.",
						20 => "Up to 15% Off Selected Items",
						21 => "Up to 33% Off Selected Items",
					); 
				
				
				} break;
				
				
				default: {
				
				
				} break;
			
			} 
		
			if(isset($randomeTitle)){
			return $randomeTitle[$order_data];
			}else{
			return "Example Listing ".$order_data;
			}
			
		
		} break; 
	
		case "update_core":{
		
		// EXAMPLE		
		// array('design','color_primary'),  $s['color_primary'])
		
		if(is_array($order_data) && isset($order_data[0][0]) ){
		
			$existing_values = get_option("core_admin_values");			
			if(isset($order_data[0][1]) &&	$order_data[0][1] != ""){				
				$existing_values[$order_data[0][0]][$order_data[0][1]] = $order_data[1];	
			}				  
			update_option( "core_admin_values", $existing_values);			 
		
		}
		
		
		
		} break;
 
		case "format_logtype": {
		
		
			$type = get_post_meta($order_data,"log_type",true);			
			$log_to 	= get_post_meta($order_data,"log_to",true);		
			$log_from 	= get_post_meta($order_data,"log_from",true);
			$userid 	= $log_to;
		
			$l = $CORE->FUNC("get_logtype", array());
			
			if(!isset($l[$type])){ return; }
			
			$name = $type;
			$desc = "";
			$icon = "fal fa-info-circle"; 
			
			// ICON
			if(isset($l[$type]['icon']) ){
				$icon = $l[$type]['icon'];
			}
			
			// LINK
			$link = "";
			if(isset($l[$type]['link']) ){
				$link = $l[$type]['link'];				
			}
			 
			
			// MESSAGE REPLACE
			if(isset($l[$type]['replace_username']) ){	
					
			
				if($userdata->ID == $log_to){
				
					if($link == "profile"){ $link = get_author_posts_url($log_from); }
					 
					$name = $l[$type]["data"]["to"]['name'];
					$rtxt = "<a href='".$link."'>".$CORE->USER("get_username",$log_from)."</a>";
					$desc = str_replace("%s", $rtxt, $l[$type]["data"]["to"]['desc']);
					
					// REPLACE USER 2
					$rtxt = "<a href='".$link."'>".$CORE->USER("get_username",$log_to)."</a>";
					$desc = str_replace("%u2", $rtxt, $desc);
					
				
				}else{	
				
					if($link == "profile"){ $link = get_author_posts_url($log_to); }
									
					$name = $l[$type]["data"]["from"]['name'];
					
					// REPLACE USER 1
					$rtxt = "<a href='".$link."'>".$CORE->USER("get_username",$log_to)."</a>";
					$desc = str_replace("%s", $rtxt, $l[$type]["data"]["from"]['desc']);
					
					
					// REPLACE USER 2
					$rtxt = "<a href='".$link."'>".$CORE->USER("get_username",$log_from)."</a>";
					$desc = str_replace("%u2", $rtxt, $desc);
					
					
					$userid = $log_from;				
				}						
			
			
			}else{ // DEFAULT NOTICE
			
				$name = $l[$type]['name'];
				$desc = $l[$type]['desc'];
						
				
				
				if($link == "profile"){
				$link = get_author_posts_url($log_to);
				}
				$utxt = "<a href='".$link."'>".$CORE->USER("get_username",$log_to)."</a>";
				if($link == ""){ $utxt = "<strong>".strip_tags($utxt)."</strong>"; }
				
				if($userdata->ID == $log_to && isset($GLOBALS['flag-account'])){
				//$utxt = __("You","premiumpress");
				}
				
				$desc = str_replace("%u", $utxt, $desc); 
			
			}
			
			
			
			
			// REPLACE %emailid
			$etxt = get_post_meta($order_data, "log_emailid", true);
			if(strlen($etxt) > 0){
				$desc = str_replace("%emailid", $etxt, $desc);
				$name = str_replace("%emailid", $etxt, $name);
			}
			
			
			//REPLACE %t (to)
			$rtxt = "<a href='".$CORE->USER("get_user_profile_link", $log_to)."'>".$CORE->USER("get_username",$log_to)."</a>";
			$desc = str_replace("%t", $rtxt, $desc);
			$name = str_replace("%t", $rtxt, $name);
			
			//REPLACE %f (from)
			$rtxt = "<a href='".$CORE->USER("get_user_profile_link", $log_from)."'>".$CORE->USER("get_username",$log_from)."</a>";
			$desc = str_replace("%f", $rtxt, $desc);
			$name = str_replace("%f", $rtxt, $name); 
			
			
			
			// REPLACE %e
			$etxt = get_post_meta($order_data, "log_email", true);
			if(strlen($etxt) > 0){
				$desc = str_replace("%email", $etxt, $desc);
			}
			
			// REPLACE %e
			$etxt = get_post_meta($order_data, "log_extra", true);
			if(strlen($etxt) > 0){
				$desc = str_replace("%e", $etxt, $desc);
				$name = str_replace("%e", $etxt, $name);
			} 		
				
			// REPLACE %P
			$postid = get_post_meta($order_data, "log_postid", true);
			if(is_numeric($postid) && strlen($postid) > 0 ){			
					$ptxt = "<a href='".get_permalink($postid)."' target='_blank'>".get_the_title($postid)."</a>";				
					$desc = str_replace("%p", $ptxt, $desc);
					$name = str_replace("%p", $ptxt, $name);
			}
				
			 
			
			$date = get_the_date("Y-m-d H:i:s", $order_data);
			$vv = $CORE->date_timediff($date);
			$time = $vv['string-small'];
			if($time == ""){ $time = "1s"; }
			
			return array(
				"name" => $name, 
				"desc" => $desc, 
				"icon" => $icon, 
				"date" => $date, 
				"time" => $time." ".__("ago","premiumpress"), 
				"user_to" => $log_to, 
				"user_from" => $log_from, 
				'userid' => $userid,			 
				 
			);
		
		
		} break;
	
		case "get_logtype": {
		
				$types = array(
				
				
				
				
				// USER ACCOUNT
				
				"user_verify" => array(	
					
						"name" 		=>  __("Verify Email Address","premiumpress"),
						"desc" 		=>  __("verification email sent to","premiumpress")." %u",	
						"icon" 		=> "fal fa-award",
						
						"email" => array(
							"subject" => "Please verify your email.",
							"body" => "Dear (username)<br><br>Thank you for joining our website.<br><br>Please use the link below to verify your email address.<br><br> (vlink) <br>",
							"shortcodes" => array("username","email","vlink","first_name","last_name"),
						),
						
					),
				
				
					"user_registered" => array(	
					
						"name" 		=>  __("New User Registration","premiumpress"),
						"desc" 		=>  "%u ".__("joined the website.","premiumpress"),	
						"icon" 		=> "fal fa-user-plus",
						
						"email" => array(
							"subject" => "Welcome to our website",
							"body" => "Dear (username)<br><br>Thank you for joining our website.<br><br>Your login details are;<br><br>Username: (username)<br>Password: (password) <br>",
							"shortcodes" => array("username","email","password","first_name","last_name"),
						),
						
					),
										
					"user_update" => array(						
						
						"name" =>  __("Account Update","premiumpress"), 
						"desc" =>  "%u ".__("updated their account details.","premiumpress"),
						"icon" => "fa fa-user-edit",	
					),
					
					"user_password" => array(						
						"name" =>  __("Updated account password.","premiumpress"), 
						"desc" =>  "%u ".__("updated their login password.","premiumpress"),	
						
						"icon" => "fal fa-user-cog",	
					),
					
					"user_photo" => array(						
						"name" =>  __("User Photo Updated","premiumpress"),	
						"desc" =>  "%u ".__("updated their display photo.","premiumpress"),
						"icon" => "fal fa-user-circle",
							
					),
					
					"user_logout" => array(
										
						"name" =>  __("User Logout","premiumpress"),
						"desc" =>  "%u ".__("just logged out!","premiumpress"),						
						"icon" => "fal fa-user-slash",
					),
				 
				
				
			   
					// PLUBCLIC LOGS
					"public_listing_view" => array(	
					
						"name" =>  "%f", 						
						"desc" =>  __("viewed","premiumpress")." %p",						
						"icon" => "fal fa-user",
					),
					
					"public_profile_view" => array(	
					
						"name" =>  "%f", 						
						"desc" =>  __("saw profile by","premiumpress")." %t",						
						"icon" => "fal fa-user",
					),
					
					"public_user_subscribe" => array(	
					
						"name" =>  "%f", 						
						"desc" =>  __("started following","premiumpress")." %t",						
						"icon" => "fal fa-user",
					),
					
					"public_user_unsubscribe" => array(	
					
						"name" =>  "%f", 						
						"desc" =>  __("unfollowed","premiumpress")." %t",						
						"icon" => "fal fa-user",
					),
					
					
					// EMAILS
					"email" => array(	
					
						"name" =>  __("Email Sent","premiumpress")." (%emailid)", 						
						"desc" =>  __("email sent to","premiumpress")." (%email)",						
						"icon" => "fa fa-envelope",
					),
					
					"email_system" => array(	
					
						"name" =>  __("System Email Sent","premiumpress"), 						
						"desc" =>  __("was sent an email.","premiumpress"), 						
						"icon" => "fal fa-envelope",
					),
					
					"email_admin" => array(	
					
						"name" =>  __("Admin Sent Email","premiumpress"), 						
						"desc" =>  __("was sent an email.","premiumpress"), 						
						"icon" => "fal fa-envelope",
					),
					
					"newsletter" => array(	
					
						"name" =>  __("Newsletter Sent","premiumpress"), 
						"desc" =>  __("was sent a newsletter.","premiumpress"),
						"icon" => "fal fa-mail-bulk",
					),
					
					// ORDERS
					"order" => array(	
					
						"name" =>  __("New Order","premiumpress"), 
						"desc" =>  "%u ".__("placed a new order.","premiumpress"), 						
						"icon" => "fal fa-sack",
						
						"email" => array(
							"subject" => "Payment received - thank you!",
							"body" => "Dear (username)<br><br>Thank you for placing an order on our website. <br><br>You can login to your account anytime to view your invoice.",
						),
						
					), 
					
					
				
					 
					
					// ORDERS
					"offer_new" => array(	
					
						"name" 		=>  __("New Offer Sent","premiumpress"),
						"desc" =>  __("%u sent a new offer.","premiumpress"),					
											
						
						"postid" 	=> true, 
						 
						"alert" => true,
						"icon" => "fal fa-comments-alt-dollar",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("New Offer Received","premiumpress"),	
								"desc" =>  __("from %s","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("New Offer Sent","premiumpress"),	
								"desc" =>  __("Sent to %s","premiumpress"),								
							),							
						),
						
						"email" => array(
							"subject" => "New Offer Received",
							"body" => "Dear (username)<br><br>You have received a new offer from (from_username).<br><br>You can login to your account anytime to find out more.",
						),
						
					), 
					
					"offer_accepted" => array(						
							 
						"name" 	=>  __("Offer Accepted","premiumpress"),
						"desc"  =>  __("User offer accepted.","premiumpress"),					
							 
							 
						"postid" 	=> true, 
						 
						"alert" => true,
						"icon" => "fal fa-smile",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("Offer Accepted","premiumpress"),	
								"desc" =>  __("%s accepted your offer.","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("Offer Accepted","premiumpress"),	
								"desc" =>  __("You accepted the offer from %s","premiumpress"),								
							),							
						),
						"email" => array(
							"subject" => "Offer Accepted",
							"body" => "Dear (username)<br><br>An offer you made has been accepted.<br><br>You can login to your account anytime to find out more.",
						),		  
					 
					), 	
					
					
					"offer_rejected" => array(	
					
						"name" 	=>  __("Offer Rejected","premiumpress"),
						"desc"  =>  __("User offer rejected.","premiumpress"),					
											
						 
						"postid" 	=> true, 
						 
						"alert" => true,
						"icon" => "fal fa-frown",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("Offer Rejected","premiumpress"),	
								"desc" =>  __("%s rejected your offer.","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("Offer Rejected","premiumpress"),	
								"desc" =>  __("You rejected the offer from %s","premiumpress"),								
							),							
						),
						"email" => array(
							"subject" => "Offer Rejected",
							"body" => "Dear (username)<br><br>An offer you made has been rejected.<br><br>You can login to your account anytime to find out more.",
						),			  
					 
					),
					
					"offer_updated" => array(
					
						"name" 	=>  __("Offer Updated","premiumpress"),
						"desc"  =>  __("User offer updated.","premiumpress"),					
						
											 
						"postid" 	=> true, 						 
						"alert" => true,
						"icon" => "fal fa-sync-alt",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("Offer Updated","premiumpress"),	
								"desc" =>  __("%s updated the offer status.","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("Offer Updated","premiumpress"),	
								"desc" =>  __("You have updated the offer status.","premiumpress"),								
							),							
						),
						"email" => array(
							"subject" => "Offer Updated",
							"body" => "Dear (username)<br><br>An offer status has been updated.<br><br>You can login to your account anytime to find out more.",
						),			  
					 
					),
										
					"offer_complete" => array(	
					
						"name" 	=>  __("Offer Completed","premiumpress"),
						"desc"  =>  __("User offer completed.","premiumpress"),
						 
						"postid" 	=> true, 						 
						"alert" => true,
						"icon" => "fal fa-thumbs-up",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("Order Complete","premiumpress"),	
								"desc" =>  __("%s marked the offer as finished.","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("Order Complete","premiumpress"),	
								"desc" =>  __("You marked the order complete.","premiumpress"),								
							),							
						)				  
					 
					),
					
					
						
					// LISTING ADDED
					"listing_added" => array(						
						"name" =>  __("New Listing Added","premiumpress"), 
						"desc" =>  __("%u added a new listing.","premiumpress"),
						"postid" 	=> true, 
						"icon" => "fal fa-plus",
					),
					
					"listing_update" => array(						
						"name" 		=>  __("Listing Updated","premiumpress"),
						"desc" =>  __("%u updated a listing.","premiumpress"),
						"postid" 	=> true, 
						"icon" => "fal fa-edit",
					),
					
					"listing_deleted" => array(						
						"name" 		=>  __("Listing Deleted","premiumpress"),
						"desc" =>  __("%u deleted a listing.","premiumpress"),
						"postid" 	=> true, 
						"icon" => "fal fa-trash-alt",
					),
					
					"listing_expired" => array(						
						"name" 		=>  __("Listing Expired","premiumpress"),
						"desc" =>  __("User listing expired.","premiumpress"),
						"postid" 	=> true, 
						"alert" 	=> true,
						"icon" => "fal fa-clock",
						
						"email" => array(
							"subject" => "Listing Expired",
							"body" => "Dear (username)<br><br>Your listing has expired.<br><br>You can login to your account anytime to renew and update your listings.",
						),
					),
					
					
					
					// MEMBERSHIP 
					"membership_expired" => array(						
						"name" 		=>  __("Membership Expired","premiumpress"),
						"desc" =>  __("User membership expired.","premiumpress"),
						"postid" 	=> false, 
						"alert" 	=> true,
						"icon" => "fal fa-clock",
						
						"email" => array(
							"subject" => "Listing Expired",
							"body" => "Dear (username)<br><br>Your membership has expired.<br><br>You can login to your account anytime to renew and update your membership.",
						),
					),
				 
					
					// ORDERS
					"listing_message" => array(	
					
						"name" 		=>  __("Contact Form","premiumpress"),
						"desc" 		=>  __("Contact page or listing contact forms.","premiumpress"),
						 
						"postid" 	=> true,						 
						"alert" 	=> true,
						"icon" 		=> "fal fa-envelope-open-text",
						
						"replace_username" => true,
						
						"link" 		=> _ppt(array('links','myaccount'))."?showtab=messages",
						"data" 		=> array(
						
								"to" => array(							
									"name" =>  __("New Message Received","premiumpress"),	
									"desc" =>  __("from %s","premiumpress"),								
								),
								
								"from" => array(							
									"name" =>  __("New Message Sent","premiumpress"),	
									"desc" =>  __("Sent to %s","premiumpress"),								
								),							
						),	
						
						"email" => array(
							"subject" => "Contact Form",
							"body" => "Dear (username)<br><br>You have recieved a new message.<br><br>(message)",
						),					
						
					),  
					  
					
					// MESSAGE SYSTEM
					"msg_new" => array(	
					
						"name" 	=>  __("New Message","premiumpress"),
						"desc"  =>  __("User received a new message.","premiumpress"),				
											
						 
						"alert" => true,
						"icon" => "fal fa-envelope",
						"replace_username" => true,
						"link" => _ppt(array('links','myaccount'))."?showtab=messages",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("New Message","premiumpress"),	
								"desc" =>  __("Sent from %s","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("Message Sent","premiumpress"),	
								"desc" =>  __("Sent to %s","premiumpress"),								
							),	
						),
						"email" => array(
							"subject" => "New Message",
							"body" => "Dear (username)<br><br>You have received a new message.<br><br>You can login to your account anytime to read your messages.",
						),							 	
						 
					 ),
					 
					 
					 // MICRO JOBS					 
					"mj_credit_added" => array(						
						 
						"alert" => true,
						"icon" => "fal fa-funnel-dollar",
						 
						"link" => _ppt(array('links','myaccount'))."?showtab=messages",						 					
						 						
						"name" =>  __("New Credit Added","premiumpress"),	
						"desc" =>  __("Congratulations - new credit added.","premiumpress"),		
						
						"email" => array(
							"subject" => "New Credit Added",
							"body" => "Dear (username)<br><br>Your account has been updated with new credit.<br><br>You can login to your account anytime to find out more.",
						),							 	
						 
					 ),
					 
					// AUCTION THME
					"at_auction_ended" => array(	
					
						"name" 	=>  __("Auction Ended","premiumpress"),
						"desc"  =>  __("The auction has ended.","premiumpress"),				
											
						 
						"alert" => true,
						"icon" => "fal fa-clock",
						
						"link" => _ppt(array('links','myaccount'))."?showtab=offers",
						 	
						"email" => array(
							"subject" => "Auction Ended",
							"body" => "Dear (username)<br><br>An (title) auction you were watching has ended.<br>Auction Link: (link) <br>You can login to your account anytime to view your auctions.",
						),							 	
						 
					 ), 
					 
					 
					 
					 
					 // FEEDBACK 
					
					"feedback_receieved" => array(	
					
						"name" =>  __("Feedback received","premiumpress"), 
						"desc" =>  __("%u received new feedback.","premiumpress"), 
						"icon" => "fal fa-comments",
						"postid" 	=> true,  
						
						"alert" => true,
						"replace_username" => true,
						"link" => "profile",
						"data" => array(
						
							"to" => array(							
								"name" =>  __("New Feedback Received","premiumpress"),	
								"desc" =>  __("from %s","premiumpress"),								
							),
							
							"from" => array(							
								"name" =>  __("New Feedback Sent","premiumpress"),	
								"desc" =>  __("Sent to %s","premiumpress"),								
							),							
						),
						
						"email" => array(
							"subject" => "New Feedback received",
							"body" => "Dear (username)<br><br>You have just received new feedback. <br><br>You can login to your account anytime to view your new feedback.",
						),
						
					),
					
					
					// RELATED LISITNGS
					"match_notification" => array(	
					
						"name" 		=>  __("New Match Found","premiumpress"),
						"desc" 		=>  str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Sent to the user when a %s is added that meets a users match criteria.","premiumpress") ),
						 
						"postid" 	=> true,						 
						"alert" 	=> true,
						"icon" 		=> "fal fa-star",
						
						"replace_username" => true,
						
						"link" 		=> _ppt(array('links','myaccount'))."?showtab=messages",
						"data" 		=> array(
						
								"to" => array(							
									"name" =>  __("New Match Found","premiumpress"),	
									"desc" =>  "%p",								
								),
								 							
						),	
						
						"email" => array(
							"subject" => "New Match Found",
							"body" => "Dear (username)<br><br>A new auction has been added which meets your match criteria.<br><br>(link)<br><br>",
						),					
						
					), 
					
					
					
					// FRIENDS NOTIFICATION
				
					"friend_listing_update" => array(	
					
						"name" 		=>  str_replace("%s", $CORE->LAYOUT("captions","1"), __("Friend System - New %s Added","premiumpress")),
						"desc" 		=>  str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Sent to friends of a user who creates a new %s.","premiumpress") ),
						 
						"postid" 	=> true,						 
						"alert" 	=> true,
						"icon" 		=> "fal fa-user",
						
						"replace_username" => true,
						
						"link" 		=> _ppt(array('links','myaccount'))."?showtab=friends",
						"data" 		=> array(
						
								"to" => array(							
									"name" =>  __("Friend Update","premiumpress"),	
									"desc" =>  "%p",								
								),
								 							
						),	
						
						"email" => array(
							"subject" => str_replace("%s", $CORE->LAYOUT("captions","1"),"New %s Added"),
							"body" => str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), "Dear (username)<br><br>A new %s has been added by one of your friends.<br><br>(link)<br><br>"),
						),					
						
					),
					
					
					 
					 			
				
				);
				 
				if(_ppt(array('user', 'friends')) == "1"){
				
				}else{
				unset($types['friend_listing_update']['email']);
				}
				
				// CLEAN UP				
				if(_ppt(array('cashout', 'enable_escrow')) == "1"){
				
				}elseif( defined('THEME_KEY') && THEME_KEY != "mj"){				
					unset($types['mj_credit_added']['email']);
				}
				
				
				if(defined('THEME_KEY') && THEME_KEY != "at"){				
					unset($types['at_auction_ended']['email']);
				}
				
				if(defined('THEME_KEY') && in_array(THEME_KEY, array("sp","at")) ){	
					unset($types['listing_expired']['email']);
				} 
				
				// IF NOT OFFER SYSTEM REMOVE EMAILS
				if( $CORE->LAYOUT("captions","offers")  == ""){
				
					unset($types['offer_complete']['email']);					
					unset($types['offer_updated']['email']);
					unset($types['offer_rejected']['email']);
					unset($types['offer_accepted']['email']);
					unset($types['offer_new']['email']);
					unset($types['feedback_receieved']['email']);
				}
				
				// MEMBERSHIPS
				if( !$CORE->LAYOUT("captions","memberships") ){
				 	unset($types['membership_expired']['email']);
				}
				
				
				
				
				
				// TEXT CHANGES				
				if(defined('THEME_KEY') && THEME_KEY == "rt"){
					
					// 1. new offer
					$types["offer_new"]['name'] =  __("New Viewing Request","premiumpress");
					$types["offer_new"]["data"]["to"]["name"] =  __("New Viewing Request","premiumpress");
					$types["offer_new"]["data"]["from"]["name"] =  __("Viewing Request Sent","premiumpress");	
			 
				 	// 2. offer accepted
					$types["offer_accepted"]["data"]["to"]["name"] =  __("Request Accepted","premiumpress");
					$types["offer_accepted"]["data"]["from"]["name"] =  __("Request Accepted","premiumpress");	
					
					// 3. offer rejected
					$types["offer_rejected"]["data"]["to"]["name"] =  __("Request Rejected","premiumpress");
					$types["offer_rejected"]["data"]["from"]["name"] =  __("Request Rejected","premiumpress");	
					
					// 3. offer updated
					$types["offer_updated"]["data"]["to"]["name"] =  __("Request Updated","premiumpress");
					$types["offer_updated"]["data"]["from"]["name"] =  __("Request Updated","premiumpress");		
					
					
					// EMAILS
					$types["offer_new"]["email"]["subject"] =  "New Property Viewing Request";
					$types["offer_new"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - (from_username) has just requested a home viewing for your listed property.<br><br>Property Title: (post_name) <br><br>Please login to your account to update the applicate and schedule an viewing date.";
					
					$types["offer_accepted"]["email"]["subject"] =  "Viewing Request Accepted";
					$types["offer_accepted"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - your property viewing request has been accepted by the seller/agent.<br><br>Property Title: (post_name) <br><br>You can login to your account anytime to check for updates."; 
						
					$types["offer_rejected"]["email"]["subject"] =  "Property Viewing Request Rejected";
					$types["offer_rejected"]["email"]["body"] =  "Dear (username)<br><br>Unfortunately the seller has decided to decline a viewing request at this time.<br><br>Property Title: (post_name) <br><br>You can login to your account anytime to schedule a viewing on a different property.";
				
					$types["offer_updated"]["email"]["subject"] =  "Property Viewing Status Updated";
					$types["offer_updated"]["email"]["body"] =  "Dear (username)<br><br>The property viewing request for <strong>(post_name)</strong> has been updated.<br><br>Please login to your account to check for updates.";
									
			 
			 
				}elseif(defined('THEME_KEY') && THEME_KEY == "jb"){
					
					// 1. new offer
					$types["offer_new"]["data"]["to"]["name"] =  __("New Interview Request","premiumpress");
					$types["offer_new"]["data"]["from"]["name"] =  __("Interview Request Sent","premiumpress");	
			 
				 	// 2. offer accepted
					$types["offer_accepted"]["data"]["to"]["name"] =  __("Request Accepted","premiumpress");
					$types["offer_accepted"]["data"]["from"]["name"] =  __("Request Accepted","premiumpress");	
					
					// 3. offer rejected
					$types["offer_rejected"]["data"]["to"]["name"] =  __("Request Rejected","premiumpress");
					$types["offer_rejected"]["data"]["from"]["name"] =  __("Request Rejected","premiumpress");	
					
					// 3. offer updated
					$types["offer_updated"]["data"]["to"]["name"] =  __("Request Updated","premiumpress");
					$types["offer_updated"]["data"]["from"]["name"] =  __("Request Updated","premiumpress");	
					
					// EMAILS
					$types["offer_new"]["email"]["subject"] =  "New Interview";
					$types["offer_new"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - (from_username) has just requested an interview for your work position.<br><br> Job Title: (post_name) <br><br>Please login to your account to update the applicate and schedule an interview date.";
					
					$types["offer_accepted"]["email"]["subject"] =  "Interview Request Accepted";
					$types["offer_accepted"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - your job interview has been accepted and is being updared by the employer.<br><br> Job Title: (post_name) <br><br>You can login to your account anytime to check for updates."; 
						
					$types["offer_rejected"]["email"]["subject"] =  "Interview Request Rejected";
					$types["offer_rejected"]["email"]["body"] =  "Dear (username)<br><br>Unfortunately the employeer has decided to decline an interview.<br><br> Job Title: (post_name) <br><br>You can login to your account anytime to apply for another job.";
				
					$types["offer_updated"]["email"]["subject"] =  "Interview Status Updated";
					$types["offer_updated"]["email"]["body"] =  "Dear (username)<br><br>The job interview request for <strong>(post_name)</strong> has been updated.<br><br>Please login to your account to check for updates.";
									
			 
			 
			 	}elseif(defined('THEME_KEY') && THEME_KEY == "ll"){
					
					// 1. new offer
					$types["offer_new"]["data"]["to"]["name"] =  __("New Application Request","premiumpress");
					$types["offer_new"]["data"]["from"]["name"] =  __("Application Request Sent","premiumpress");	
			 
				 	// 2. offer accepted
					$types["offer_accepted"]["data"]["to"]["name"] =  __("Request Accepted","premiumpress");
					$types["offer_accepted"]["data"]["from"]["name"] =  __("Request Accepted","premiumpress");	
					
					// 3. offer rejected
					$types["offer_rejected"]["data"]["to"]["name"] =  __("Request Rejected","premiumpress");
					$types["offer_rejected"]["data"]["from"]["name"] =  __("Request Rejected","premiumpress");	
					
					// 3. offer updated
					$types["offer_updated"]["data"]["to"]["name"] =  __("Request Updated","premiumpress");
					$types["offer_updated"]["data"]["from"]["name"] =  __("Request Updated","premiumpress");	
					
					// EMAILS
					$types["offer_new"]["email"]["subject"] =  "New Application";
					$types["offer_new"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - (from_username) has just requested an Application for your work position.<br><br> Job Title: (post_name) <br><br>Please login to your account to update the applicate and schedule an Application date.";
					
					$types["offer_accepted"]["email"]["subject"] =  "Application Request Accepted";
					$types["offer_accepted"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - your job Application has been accepted and is being updared by the employer.<br><br> Job Title: (post_name) <br><br>You can login to your account anytime to check for updates."; 
						
					$types["offer_rejected"]["email"]["subject"] =  "Application Request Rejected";
					$types["offer_rejected"]["email"]["body"] =  "Dear (username)<br><br>Unfortunately the employeer has decided to decline an Application.<br><br> Job Title: (post_name) <br><br>You can login to your account anytime to apply for another job.";
				
					$types["offer_updated"]["email"]["subject"] =  "Application Status Updated";
					$types["offer_updated"]["email"]["body"] =  "Dear (username)<br><br>The job Application request for <strong>(post_name)</strong> has been updated.<br><br>Please login to your account to check for updates.";
					
			 
			 
			 }elseif(defined('THEME_KEY') && THEME_KEY == "mj"){
					
					// 1. new offer
					$types["offer_new"]['name'] =  __("New Job","premiumpress");
					
					$types["offer_new"]["data"]["to"]["name"] =  __("New Job Ordered","premiumpress");
					$types["offer_new"]["data"]["from"]["name"] =  __("New Job Purchased","premiumpress");	
					
					$types["offer_new"]["data"]["to"]["desc"] =  "%s ".__("paid for","premiumpress")." %p";
					$types["offer_new"]["data"]["from"]["desc"] =  "%u2 ".__("paid for","premiumpress")." %p";
					 
				 
					// 3. offer rejected
					$types["offer_rejected"]['name'] =  __("Job Rejected","premiumpress");					
					$types["offer_rejected"]["data"]["to"]["name"] =  __("Job Refunded","premiumpress");					 
					$types["offer_rejected"]["data"]["to"]["desc"] =  "%s ".__("rejected the order for","premiumpress")." %p";
					 						
					$types["offer_rejected"]["data"]["from"]["name"] =  __("Job Rejected","premiumpress");					 
					$types["offer_rejected"]["data"]["from"]["desc"] =  __("You rejected the order from %s on","premiumpress")." %p";					
					
					$types["offer_updated"]['name'] =  __("Job Updated","premiumpress");	
					$types["offer_accepted"]['name'] =  __("Job Accepted","premiumpress");	
							
					
					// EMAILS
					$types["offer_new"]["email"]["subject"] =  "New Job Purchased";
					$types["offer_new"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - (from_username) has just purchased your gig.<br><br> Item: (post_name) <br><br>Item Link: (link) <br><br>Please login to your account to update the user and begin the order.";
					
					$types["offer_accepted"]["email"]["subject"] =  "Work has started.";
					$types["offer_accepted"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - your job has been accepted and is now being worked on.<br><br> Item: (post_name) <br><br>Item Link: (link) <br><br>You can login to your account anytime and check the progress."; 
						
					$types["offer_rejected"]["email"]["subject"] =  "Job Rejected";
					$types["offer_rejected"]["email"]["body"] =  "Dear (username)<br><br>Unfortunately the seller has decided to decline this job. Payment for this job has been credted to your account.<br><br> Job Cancelled: (post_name) <br><br>You can login to your account anytime to purchase another job.";
				
					$types["offer_updated"]["email"]["subject"] =  "Job Status Updated";
					$types["offer_updated"]["email"]["body"] =  "Dear (username)<br><br>The job <strong>(post_name)</strong> has been updated.<br><br>Please login to your account to check for new feedback.";
				
					 
			 
				}elseif(defined('THEME_KEY') && THEME_KEY == "at"){
					
					// 1. new offer
					$types["offer_new"]['name'] =  __("New Bid","premiumpress");
					
					$types["offer_new"]["data"]["to"]["name"] =  __("Bid received","premiumpress");
					$types["offer_new"]["data"]["from"]["name"] =  __("New Bid Added","premiumpress");	
					
					$types["offer_new"]["data"]["to"]["desc"] =  "%s ".__("bid on","premiumpress")."  %p";
					$types["offer_new"]["data"]["from"]["desc"] =  "%u2 ".__("bid on","premiumpress")." %p.";
					
					$types["offer_new"]["email"]["subject"] =  "New Bid Recieved";
					$types["offer_new"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - you've received a new bid on your item.<br><br> Item: (post_name) <br><br>Item Link: (link) <br><br>You can login to your account and manage your items.";
					  
			 
				 	// 2. offer accepted
					$types["offer_accepted"]['name'] =  __("Auction Won","premiumpress");					
					$types["offer_accepted"]["data"]["to"]["name"] =  __("Auction Won","premiumpress");
					$types["offer_accepted"]["data"]["from"]["name"] =  __("Item Sold","premiumpress");	
					
					$types["offer_accepted"]["data"]["to"]["desc"] =  "%u2 ".__("won","premiumpress")." %p.";
					$types["offer_accepted"]["data"]["from"]["desc"] =  "%p";
					
					
					$types["offer_accepted"]["email"]["subject"] =  "Auction Winner - Congratulations!";
					$types["offer_accepted"]["email"]["body"] =  "Dear (username)<br><br>Congratulations - you've won an auction.<br><br> Item: (post_name) <br><br>Item Link: (link) <br><br>You can login to your account and make payment asap.";
					 
					
					// 3. offer rejected
					$types["offer_rejected"]['name'] =  __("Auction Outbid","premiumpress");					
					$types["offer_rejected"]["data"]["to"]["name"] =  __("You've been outbid","premiumpress");					 
					$types["offer_rejected"]["data"]["to"]["desc"] =  "%u2 ".__("was outbid by %s on","premiumpress")." %p";
					 						
					$types["offer_rejected"]["data"]["from"]["name"] =  __("You've been outbid","premiumpress");					 
					$types["offer_rejected"]["data"]["from"]["desc"] =  __(" %s was outbid by %u2 on","premiumpress")."  %p";
					
					$types["offer_rejected"]["email"]["subject"] =  "You've been outbid!";
					$types["offer_rejected"]["email"]["body"] =  "Dear (username)<br><br>You'be been outbid by (from_username)<br><br> Item: (post_name) <br><br>Item Link: (link) <br><br>You can login to your account anytime to bid again.";
					
					
					// 3. offer updated
					$types["offer_updated"]['name'] =  __("Auction Payment Updated","premiumpress");
					$types["offer_updated"]["data"]["to"]["name"] =  __("Payment Updated","premiumpress");
					$types["offer_updated"]["data"]["from"]["name"] =  __("Payment Updated","premiumpress");	
					 
					 
					$types["offer_updated"]["email"]["subject"] =  "Item Status Updated";
					$types["offer_updated"]["email"]["body"] =  "Dear (username)<br><br>The auction item status has been updated.<br><br>Please login to your account to check for new buy/seller feedback.";
				 
				 
				
				}
				 
				
				
				if(!is_array($order_data) && strlen($order_data) > 1 && isset($types[$order_data]) ){
					
					return $types[$order_data];
				}
				
				return $types;			
				
		
		
		} break;
	
		case "add_log": {		
	 		
				
			$data = "";
			if(isset($order_data['data']) && is_array($order_data['data'])){
			$data = $this->flatten($order_data['data']);
			}elseif(isset($order_data['data'])){
			$data = $order_data['data'];
			} 
			
					
				
			// IF THIS IS A PUBLIC LOG
			// LETS CHECK FOR DUPLICATES
			if(isset($order_data['public']) && $order_data['public'] == 1){			
			
				$args = array( 
				
					'post_type' 		=> 'ppt_logs',
					'posts_per_page' 	=>  4, // WE ONLY NEED 1
				
					'date_query' => array(
						'after'     => '1 minutes ago',
						'inclusive' => true
					), 			
						
					'meta_query' => array(
						 											 
							'log_to'    => array(      								
								'key' 			=> 'log_public',	
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 					 			
							),			 
							 		
					),					
				);
							
			 $found_logs = new WP_Query($args);
			 if(count($found_logs->posts) > 3){
			 return ;
			 }
			
			
			}		
			
			
			// SETUP NEW ORDER			
			$my_post = array();				
			$my_post['post_title'] 		= " ";
			$my_post['post_type'] 		= "ppt_logs"; 
			$my_post['post_status'] 	= "publish";
			$my_post['post_content'] 	= addslashes($data); 
			$logid = wp_insert_post( $my_post );
			 
			// LOG TYPE
			add_post_meta($logid, "log_type", $order_data['type']);
			
			// USER TO
			if(isset($order_data['to']) && is_numeric($order_data['to'])){	
								
				$touser = $order_data['to'];
				add_post_meta($logid, "log_to", $order_data['to'] );			
			
			}elseif(isset($order_data['userid']) && is_numeric($order_data['userid'])){	
			
				$touser = $order_data['userid'];
				add_post_meta($logid, "log_to", $order_data['userid'] );
			
			}elseif($userdata->ID){		
				$touser = $userdata->ID;
				add_post_meta($logid, "log_to", $userdata->ID);			
			}
			
			// USER FROM
			if(isset($order_data['from']) && $order_data['from'] != ""){
				add_post_meta($logid, "log_from", $order_data['from']);
			}			
						
			// POST ID
			if(isset($order_data['postid']) && $order_data['postid'] != ""){
			add_post_meta($logid, "log_postid", $order_data['postid']);
			}
			
			// EXTRA
			if(isset($order_data['extra']) && $order_data['extra'] != ""){
			add_post_meta($logid, "log_extra", $order_data['extra']);
			}
			
			// EMAIL ID
			if(isset($order_data['emailid']) && $order_data['emailid'] != ""){
			add_post_meta($logid, "log_emailid", $order_data['emailid']);
			}
			
			// USER EMAIL
			if(isset($order_data['email']) && $order_data['email'] != ""){
			add_post_meta($logid, "log_email", $order_data['email']);
			}
			
			// PUBLIC
			if(isset($order_data['public']) && $order_data['public'] != ""){
			add_post_meta($logid, "log_public", 1);
			}else{			
			add_post_meta($logid, "log_public", 0);
			}
			
			// IF ITS READ OR NOT
			$checkalert = $CORE->FUNC("get_logtype", $order_data['type']);
			if(is_array($checkalert) && isset($checkalert['alert']) ){
			 
				// USER ID 1
				if(isset($order_data['alert_uid1'])){				 					
				add_post_meta($logid, "log_read".$order_data['alert_uid1'], "unread" );	
				}
				
				// USER 2
				if(isset($order_data['alert_uid2'])){
					add_post_meta($logid, "log_read".$order_data['alert_uid2'], "unread" );	
				}	
			
			}
			
			
			// NOW SEND EMAIL
			/*
			if($order_data['type'] == "listing_message"){
				$order_data['type'] = "msg_new";
				$emailswitch = true;
				
			}		
			
			if(THEME_KEY == "mj" && $order_data['type'] == "offer_new"){
				$emailswitch = true;				 
			}	
			*/
				
			
			$l = $CORE->FUNC("get_logtype",$order_data['type']);
			if(isset($l['email']) ){ 
			
			$data1 = array();
				
				// SEND EDIT LISTING EMAIL	
				/*			
				if(isset($emailswitch)){
				
					$data1 = array(										
						"username" 	=> $CORE->USER("get_username", $order_data['to']),					
						"name" 		=> $CORE->USER("get_name", $order_data['to'] ),					 
					);
					 
				}else{
					
					$data1 = array(										
						"username" 	=> $CORE->USER("get_username", $order_data['from'] ),					
						"name" 		=> $CORE->USER("get_name", $order_data['from'] ),					 
					);
				
				}*/
				
				
				 
				
				if(isset($order_data['alert_uid1']) && is_numeric($order_data['alert_uid1']) ){	
								
					$data1['username'] 		= $CORE->USER("username",$order_data['alert_uid1']);
					$data1['username'] 		= $CORE->USER("get_name",$order_data['alert_uid1']); 
					
				}elseif(isset($order_data['to']) && is_numeric($order_data['to']) ){					
					
					$data1['username'] 		= $CORE->USER("username",$order_data['to']);
					$data1['username'] 		= $CORE->USER("get_name",$order_data['to']);
										 
				}
				
				
				if(isset($order_data['alert_uid2']) && is_numeric($order_data['alert_uid2']) ){	
								
					$data1['from_username'] 		= $CORE->USER("username",$order_data['alert_uid2']);
					$data1['from_username'] 		= $CORE->USER("get_name",$order_data['alert_uid2']); 
					
				}elseif(isset($order_data['from']) && is_numeric($order_data['from']) ){
				
					$data1['from_username'] 		= $CORE->USER("get_username",$order_data['from']);
					
				}
				
				
				if(isset($order_data['postid']) && is_numeric($order_data['postid']) ){
					$data1['post_name'] 		= get_the_title($order_data['postid']);				
				}	
			 
				// CHECK FOR PASSED IN EMAIL DATA
				if( isset($order_data["email_data"]) && is_array($order_data["email_data"])){		
				
					foreach($order_data["email_data"] as $k => $d){						
						$data1[$k] = $d;					
					}				
				
				}
				 
				 //die(print_r($order_data).print_r($data).print_r($data1));
				  
				
				$CORE->email_system($touser, $order_data['type'], $data1);
			
			}
			
			
			
		} break;
		

		
		
		
		
	}
}



	/*
		this function creates a new database entry
		for logging user events
	*/	
	function ADDLOG($message='',$userid='',$postid='',$link='label-success', $type = "", $data = ""){ global $wpdb, $CORE;	
	
		$this->FUNC("add_log",
			array(
				"message" 	=> $message,
				"type" 		=> $type,
				"postid" 	=> $postid,
				"userid" 	=> $userid,
			)
		);	 	
	
	}
	
	 
	/*
		This function gets the difference between dates
		returns in different formats
	*/
	function date_timediff($end_date, $start_date = '' ){ global $CORE;
	 	
			if($end_date == ""){ $end_date = date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " - 1 days") ); } // default is expired
			if($start_date == ""){ $start_date = current_time( 'mysql' ); } // default is now
			
			// REQUIRE DATE DIFF
			if(!function_exists('date_diff')){
				//return $this->format_date($end_date);
				echo "This theme required PHP date_diff enabled. Please contact your hosting provider to enable it.";
				return;
			}
			 
			// MAKE SURE ITS A DATE STRING		
			$end_date = date( "Y-m-d H:i:s", strtotime( $end_date ) ); 
			
			 	 
			// GET DATE DIF PARTS
			$intervalo = date_diff(date_create($start_date), date_create($end_date));
		 
		   	// TRANSLATION
			$out = $intervalo->format(__("Years","premiumpress").":%Y,".__("Months","premiumpress").":%M,".__("Days","premiumpress").":%d,".__("Hours","premiumpress").":%H,".__("Minutes","premiumpress").":%i,".__("Seconds","premiumpress").":%s");
			
			$out_small = $intervalo->format(__("Yrs","premiumpress").":%Y,".__("months","premiumpress").":%M,".__("days","premiumpress").":%d,".__("hrs","premiumpress").":%H,".__("mins","premiumpress").":%i,".__("Seconds","premiumpress").":%s"); //,".__("s","premiumpress").":%s"
			
			 
			// BUILD DATA
			$v1 = explode(',',$out); $a_out = array();   $lastValue = "";
			 
	 		
			// LOOP FOR PARTS
			foreach($v1 as $k){
				$g = explode(":",$k);
				$a_out[$g[0]] = $g[1];
			}			
		 
			// ELSE CREATE DISPLAY
			$string = "  "; $returnstring = "";
	 
			foreach($a_out as $key => $val){ 
				$canShow = true;			
				// SKIP FOR STRING
				if(is_array($returnstring) && !in_array($key, $returnstring)){ continue; }				 
				if($val != "00" && $val != ""){				  
					
					
					// CHOP OF SECONDS OF MINUTES IS SET				 
					if($key == __("Seconds","premiumpress") && $lastValue > 0){
					continue;
					}
					
					// LOOP SO LAST VALUE WOULD BE THE ONE BEFORE
					$lastValue = $val;				 
					
					$string .= "".str_replace("01","1", str_replace("02","2", str_replace("03","3", 
					str_replace("04","4", str_replace("05","5", str_replace("07","7", str_replace("08","8",
					str_replace("09","9",str_replace("06","6",$val)))))))))." ".$key." ";	
									
					 				
				}
			} 
			 
			
			// BUILD DATA
			$v1 = explode(',',$out_small); $b_out = array(); $daysleft = 0;  $lastValue = "";
	 		
			// LOOP FOR PARTS
			foreach($v1 as $k){
				$g = explode(":",$k);
				$b_out[$g[0]] = $g[1];
			}			
		 
			// ELSE CREATE DISPLAY
			$string_small = "  "; $returnstring = "";
	 		
			$i=1;
			foreach($b_out as $key => $val){  
				$canShow = true;					 
				 
					// DAYS
					/*
					if($i == 1){ // ASSUME LOOP 1 IS YEARS
					
					$daysleft += $val*365;					
					
					}elseif($i == 2){ // 2 IS MONTHS
					
					$daysleft += $val*30;
					
					
					}elseif($i == 3){ // DAYS
					$daysleft += $val;
					}
					*/
					 
					$i++;
				
				
				// SKIP FOR STRING
				if(is_array($returnstring) && !in_array($key, $returnstring)){ continue; }				 
				if($val != "00" && $val != ""){			
				
					  
					// CHOP OF SECONDS OF MINUTES IS SET				 
					if($key == __("Seconds","premiumpress") && $lastValue > 0){
					continue;
					}
					
					if($key == __("mins","premiumpress") && $lastValue > 0){
					continue;
					}
					
					if($key == __("hrs","premiumpress") && $lastValue > 0){
					continue;
					}
					
					if($key == __("days","premiumpress") && $lastValue > 0){
					continue;
					}
					
					if($key == __("months","premiumpress") && $lastValue > 0){
					continue;
					}
					
					// LOOP SO LAST VALUE WOULD BE THE ONE BEFORE
					$lastValue = $val;			 
					
					$string_small .= "".str_replace("01","1", str_replace("02","2", str_replace("03","3", 
					str_replace("04","4", str_replace("05","5", str_replace("07","7", str_replace("08","8",
					str_replace("09","9",str_replace("06","6",$val)))))))))." ".$key." ";	
					 
									
				}
			} 
			 
			// BUILD DAYS STRING			
			//$days = $vv['date_array']['days']+($vv['date_array']['months']*30)+($vv['date_array']['years']*365);
			
			// DAYS LEFT 
			$daysleft = round( (  strtotime($end_date) - strtotime(current_time( 'mysql' )) ) / (60 * 60 * 24));
			 
			 
			// CHECK IF EXPIRED
			if( strtotime($end_date) > strtotime(current_time( 'mysql' ))  ){			
				// ITS EXPIRED
				$expired = 0;
			}else{
				// NOT EXPIRED
				$expired = 1;
			} 
			
			// RETURN ARRAY OF PARTS
			$array = array_change_key_case($a_out, CASE_LOWER); 
			
			// CLEAN UP
			$string_small = str_replace("1 ".__("days","premiumpress"), "1 ".__("day","premiumpress"), $string_small);	
			$string_small = str_replace("1 ".__("mins","premiumpress"), "1 ".__("min","premiumpress"), $string_small);	
			$string_small = str_replace("1 ".__("hours","premiumpress"), "1 ".__("hour","premiumpress"), $string_small);	
			$string_small = str_replace("1 ".__("months","premiumpress"), "1 ".__("month","premiumpress"), $string_small);	
			
			if(trim($string_small) == ""){ $string_small = __("1 second","premiumpress"); }
			
			// RETURN STRING
			return array(
			"string-small" => $string_small, 
			"string" => $string, 
			"expired" => $expired, 
			"date_array" => $array, 
			"test_start" => $start_date, 
			"test_end" => $end_date, 
			"days-left" => $daysleft 
			);
			
	}

 
 

	/* =============================================================================
		 DATE FORMATTING
		========================================================================== */
	
	function format_date($date){
	return mysql2date(get_option('date_format') . ' ' . get_option('time_format'),  $date, false);
	}
	
	/* =============================================================================
	  Time Difference (now and date entered) / V7 / 25th Feb 
	   ========================================================================== */

	function DATE($date){
		global $wpdb;
		if($date == "" || is_array($date) ){return; }	
			
		$date_format = get_option('date_format') . ' ' . get_option('time_format');		
		 
		return mysql2date($date_format,$date);
	}
	
		function DATEONLY($date){
		global $wpdb;
		if($date == "" || is_array($date) ){return; }	
			
		$date_format = get_option('date_format');		
		 
		return mysql2date($date_format,$date);
	}
	
function DATETIME($extratime = ""){
	 
		if($extratime !=""){
		return date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . $extratime) );
		}else{
		return date('Y-m-d H:i:s', strtotime(current_time( 'mysql' )) );
		}
		
	}
	
	/* =============================================================================
		GET CLIENT IP
		========================================================================== */
		
	function get_client_ip(){
			if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])){
				  return $_SERVER['HTTP_CLIENT_IP'];
			}
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				  return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
			}
			if (isset($_SERVER['HTTP_PROXY_USER']) && !empty($_SERVER['HTTP_PROXY_USER'])){
				  return $_SERVER['HTTP_PROXY_USER'];
			}
			if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])){
				  return $_SERVER['REMOTE_ADDR'];
			}else{
				  return "invalid";//"0.0.0.0";
			}
	}
	
/*
	this function sorts an array 
	by the required key
*/
function multisort($array, $sort_by) {
 
 		if(!is_array($array)){ return; }
		$estr = '';
		
		foreach ($array as $key => $value) {
			$estr = '';
			foreach ($sort_by as $sort_field) {
				if(isset($value[$sort_field])){
					$tmp[$sort_field][$key] = $value[$sort_field];	
					$estr .= '$tmp[\'' . $sort_field . '\'], ';
				}
			}
		}
		
		$estr .= '$array';
		$estr = 'array_multisort(' . $estr . ');';
		eval($estr);
	
		return $array;
}
function multisortkey($array, $skey, $svalue){

	if(!is_array($array)){ return; }
	foreach ($array as $key => $value) {
		if($svalue == $value[$skey]){
			return $key;
		} // end if
	}// end foreach
}

 
	
}


 
	
 
?>