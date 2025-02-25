<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata;


// GET ELEMENT PAGES
$elementorArray = array();
$args = array(
                   'post_type' 			=> 'elementor_library',
                   'posts_per_page' 	=> 150,
                    'orderby' 	=> 'date',
					'order' => 'desc'
               );
$wp_query = new WP_Query($args);
$tt = $wpdb->get_results($wp_query->request, OBJECT);
if(!empty($tt)){ foreach($tt as $p){ 
 $elementorArray["elementor-".$p->ID] = get_the_title($p->ID); 
} } 


$GLOBALS['elementor_page_templates'] = $elementorArray;
 

function include_thickbox_scripts()    
{
    // include the javascript    
    wp_enqueue_script('thickbox', null, array('jquery'));

    // include the thickbox styles    
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');

}
add_action('wp_enqueue_scripts', 'include_thickbox_scripts');
wp_enqueue_script( 'jquery-ui-tabs' );


if(isset($_GET['nid']) && is_numeric($_GET['nid']) ){

$GLOBALS['error_message'] = "<h4>Template Created Successfully</h4><div class='mt-3' style='font-weight:normal !important'> Click here to <a href='".home_url()."/wp-admin/post.php?post=".$_GET['nid']."&action=elementor"."' target='_blank'> <u>edit the template </u></a> "; 

}

if( current_user_can('administrator') ){

if(isset($_GET['resetdemo'])){
	
	$new_core_array = get_option("core_admin_values");
	
	foreach( array("slot1","slot2","slot3","slot4","slot5","slot6","slot7","slot8","slot9","header","footer") as $s){
	$new_core_array['design'][$s."_style"] = "";
	}
 	  
	update_option('core_admin_values', $new_core_array);
	
	// CLEAN UP ELEMENTOR PAGES
	$existing_values = get_option("core_admin_values");					
	$_POST['admin_values']['pageassign']["homepage"] = "";
	$_POST['admin_values']['pageassign']["header"] = "";
	$_POST['admin_values']['pageassign']["footer"] = "";
	$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);	
	update_option( "core_admin_values", $new_result);
	
	// LEAVE MESSAGE
	$GLOBALS['ppt_error'] = array(
				"type" 		=> "success",
				"title" 	=> "Settings Updated",
				"message"	=> "The design has been reset.",
	);

}

	if(isset($_POST) && isset($_POST['loaddesign']) ){
	
		$g = $CORE->LAYOUT("load_single_design", $_POST['loaddesign']);	 
		 
		if(is_array($g)){	
			
			
			// FIX PHP 7.1
			$existingdta = get_option("core_admin_values");
			if(!is_array($existingdta )){
			$existingdta  = array();
			}						 	
			$new_core_array = apply_filters( $_POST['loaddesign'], $existingdta );	
			
			
			 	 	
			if(isset($new_core_array['sampledata'])){ unset($new_core_array['sampledata']); }	
			
			
		//print_r($new_core_array);
						 
			update_option('core_admin_values', $new_core_array);	
			
			
			//die(print_r(get_option('core_admin_values')));
			
			 
			// REMOVE PREVIEW SESSION
			if(isset($_SESSION['design_preview'])){
				unset($_SESSION['design_preview']);
			}	
			
			/* ?><textarea style="width:100%; height:100%;"><?php print_r($new_core_array); ?></textarea><?php die(); */
			 
	 
			// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
				"type" 		=> "success",
				"title" 	=> __("Settings Updated","premiumpress"),
				"message"	=> __("The design has been loaded","premiumpress"),
			);
			
			if(defined('ELEMENTOR_VERSION')){ 
			
					// RESET HOMEPAGE ELEMENTOR PAGE
					$existing_values = get_option("core_admin_values");					
					$_POST['admin_values']['pageassign']["homepage"] = "";
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);	
					 
					update_option( "core_admin_values", $new_result);
					
					 
					// CHECK FOR ELEMENTOR TEMPLATES AS PART OF THE DESIGN
					if(isset($g['elementor']) && is_array($g['elementor'])){
					
						foreach($g['elementor'] as $k => $file_path){
							
							// PROCESS IT 
							$elementor_importer = new PremiumPress_Elementor_Importer();
							$id = $elementor_importer->import_elementor_file( $file_path, $k." - ".date('d-m-Y') );
							
							if( !is_wp_error( $id ) ) {	
						
								$existing_values = get_option("core_admin_values");					 	
								$existing_values['pageassign'][$k] = "elementor-".$id;					 
								update_option( "core_admin_values", $existing_values);					 			 		
						
							}else{				
								die($id->get_error_message());			
							}					
							
						
						}			
					} 
			
			} // end if elementor
		
			
			$_GET['redirecthomepage'] =1;
		
		}else{
			
			// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
				"type" 		=> "error",
				"title" 	=> "Design Not Found",
				"message"	=> "The design requested could not be located.",
			); 	 
		
		}
	
	}// end load design
	

 
if(isset($_GET['loadpage'])){


$columns = array(); $imgidrandom = 1;

// REMOVE PREVIEW SESSION
if(isset($_SESSION['design_preview'])){
	unset($_SESSION['design_preview']);
}




if($_GET['loadpage'] == "customcard"){
 
	
	$elementor_file = get_template_directory()."/framework/design/cards/elementor-".$_GET['cardid'].".json"; //
	 
	if(file_exists($elementor_file)){  
		 
		// PROCESS IT 
		$elementor_importer = new PremiumPress_Elementor_Importer();
		$id = $elementor_importer->import_elementor_file( $elementor_file, "Search Card (".$_GET['cardid'].") - ".date('d-m-Y') );
		
		
			
				if( !is_wp_error( $id ) ) {	
				
				
				// RESET HOMEPAGE ELEMENTOR PAGE
					$existing_values = get_option("core_admin_values");					
					$_POST['admin_values']['customcard'][$_GET['cardid']] = "elementor-".$id;
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);	
					update_option( "core_admin_values", $new_result);
					
					die(
					'<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>'.
					
					'<script>setTimeout(function() { window.location.href = "'.home_url().'/wp-admin/post.php?post='.$id.'&action=elementor"; }, 3000);</script>'
					); 
				 	
					 			 		
				
				}else{				
					die($id->get_error_message()."<br><br>".$elementor_file);			
				}	
		 
	
	}else{
	
		die("missing search card");
	}
	

}elseif($_GET['loadpage'] == "new" && $_GET['inner'] == "account"){
 
	
	$elementor_file = get_template_directory()."/framework/elementor/accountpage.json"; //
	 
	  
	if(file_exists($elementor_file)){  
		 
		// PROCESS IT 
		$elementor_importer = new PremiumPress_Elementor_Importer();
		$id = $elementor_importer->import_elementor_file( $elementor_file, "Listing Page - ".date('d-m-Y') );
		
		
			
				if( !is_wp_error( $id ) ) {	
				
				
				// RESET HOMEPAGE ELEMENTOR PAGE
					$existing_values = get_option("core_admin_values");					
					$_POST['admin_values']['pageassign']['account'] = "elementor-".$id;
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);	
					update_option( "core_admin_values", $new_result);
					
					die(
					'<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>'.
					
					'<script>setTimeout(function() { window.location.href = "'.home_url().'/wp-admin/post.php?post='.$id.'&action=elementor"; }, 3000);</script>'
					); 
				 	
					 			 		
				
				}else{				
					die($id->get_error_message()."<br><br>".$elementor_file);			
				}	
		 
	
	}else{
	
		die("missing search card");
	}
	
}elseif($_GET['loadpage'] == "new" && $_GET['inner'] == "listingpage"){
 	
	if(defined('THEME_KEY') && THEME_KEY == "cp" ){
	$elementor_file = get_template_directory()."/framework/elementor/listingpage-cp.json"; //
	}else{
	$elementor_file = get_template_directory()."/framework/elementor/listingpage-new.json"; //
	}
	 
	  
	if(file_exists($elementor_file)){  
		 
		// PROCESS IT 
		$elementor_importer = new PremiumPress_Elementor_Importer();
		$id = $elementor_importer->import_elementor_file( $elementor_file, "Listing Page - ".date('d-m-Y') );
		
		
			
				if( !is_wp_error( $id ) ) {	
				
				
				// RESET HOMEPAGE ELEMENTOR PAGE
					$existing_values = get_option("core_admin_values");					
					$_POST['admin_values']['pageassign']['listingpage'] = "elementor-".$id;
					$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);	
					update_option( "core_admin_values", $new_result);
					
					die(
					'<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>'.
					
					'<script>setTimeout(function() { window.location.href = "'.home_url().'/wp-admin/post.php?post='.$id.'&action=elementor"; }, 3000);</script>'
					); 
				 	
					 			 		
				
				}else{				
					die($id->get_error_message()."<br><br>".$elementor_file);			
				}	
		 
	
	}else{
	
		die("missing search card");
	}

}elseif($_GET['loadpage'] == "home"){

	foreach( $CORE->LAYOUT("get_slots",array("header",1,2,3,4,5,6,7,8,9,"footer")) as $s){
	
	
		if(strlen(_ppt(array('design',$s['id']))) > 1){ 
		  
		
			$cat = $CORE->LAYOUT("get_block_category", _ppt(array('design',$s['id'])) );
			
			$blockKey = _ppt(array('design',$s['id']));
			
			if($blockKey == ""){ continue; }
			
			
			$block_settings = array();			 
			$block_settings = $CORE->LAYOUT("get_block_settings_defaults", array($blockKey, $cat, array() ) );
			$block_settings["type"] =  $cat;
			$block_settings[$cat."_style"] = $blockKey;
			
			if($cat =="header"){
				$block_settings["color_primary"] = _ppt(array('design','color_primary'));
				$block_settings["color_secondary"] = _ppt(array('design','color_secondary'));
			}
			
			
			// CLEANUP IMAGES			
			foreach($block_settings as $k => $a){
			
				if( in_array($k, array(
				"hero_image", 
				
				"text_image1",
				"text_image2",
				"text_image3",
				"text_image4",
				"text_image5",
				"text_image6",
				"text_image7",
				"text_image8",
				"text_image9",
				
				"image_block1",
				"image_block2",
				"image_block3",
				"image_block4",
				"image_block5",
				"image_block6",
				"image_block7",
				"image_block8",
				"image_block9",
				
				"icon1_image",
				"icon2_image",
				"icon3_image",
				"icon4_image",
				"icon5_image",
				"icon6_image",
				"icon7_image",
				"icon8_image", 
				
				
				
				"image_subscribe",
				"image_icon",
				"image_cta",
				"image_faq",
				
					"author_image1",
				"author_image2",
				"author_image3",
				"author_image4",
				"author_image5",
				"author_image6",
				"author_image7",
				
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'url' => $a,
						);
					$imgidrandom++;
				}	
				
				if( in_array($k, array(
				
				"btn_icon", 
				"btn2_icon",
								
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'value' => $a,
						);
					$imgidrandom++;
				}		
			
			}
			
			//die(print_r($block_settings));
		 
			$columns[] = array( 
			 
				
					"id" 		=> "49157210",
					"isInner" 	=> false,
					"elType" 	=> "section",
					"settings" 	=> array(		
						"layout" 		=> "full_width",
						"css_classes" 	=> "",
					), 
					
					"elements" => array(
						
							0 => array(	
									"id" 		=> "49157211",
									"isInner" 	=> "1",
									"elType" 	=> "column",			 			
									"settings" => array(
										
										"_column_size" 	=> "100",
										"layout" 		=> "full_width",	
																
									),						
									
									"elements" => array(
									
										0 => array(	
												"id" 			=> "49157213",
												"isInner" 		=> false,
												"elType" 		=> "widget",							
												"widgetType" 	=> "new-hero",
																
												"settings" => $block_settings,
												
												"elements" => array( ),
										), 
										
									), // end widget
									
									
									
									
							),// end elements (column )
				
						),
					 
				);
		
		}
		
	}
	
 
}elseif(isset($_GET['inner']) ){



if($_GET['inner'] == "header"){

$h = array("blocks" => array("header1") );

}elseif($_GET['inner'] == "footer"){

$h = array("blocks" => array("footer1") );

}elseif(strlen($_GET['inner']) > 2){
$h = $CORE->LAYOUT("get_innerpage_blocks", "page_".$_GET['inner'] );
}else{
$h = $CORE->LAYOUT("get_innerpage_blocks", $_GET['loadpage'] );
}
 

if(isset($h['blocks'])){

	// GET INNER PAGE CONTENT DATA
	$allinnerdata = $CORE->LAYOUT("default_innerpages", array() );
	
	 
	foreach($h['blocks'] as $s){
	
		$cat = $CORE->LAYOUT("get_block_category", $s );			
			 
		$blockKey = $s;
 		
		$block_settings 				= array();	
		
		if($_GET['loadpage'] == "new" && isset($allinnerdata["page_".$_GET['inner']]) ){
		$block_settings 				= $allinnerdata["page_".$_GET['inner']][$blockKey];
		}	
	 
		$block_settings["type"] 		=  $cat;
		$block_settings[$cat."_style"] 	= $blockKey;
		
		if($cat =="header"){
				$block_settings["color_primary"] = _ppt(array('design','color_primary'));
				$block_settings["color_secondary"] = _ppt(array('design','color_secondary'));
		}
		 
			
			// CLEANUP IMAGES			
			foreach($block_settings as $k => $a){
			
				if( in_array($k, array(
				
				"hero_image", 
				"text_image1",
				"text_image2",
				"text_image3",
				"text_image4",
				"text_image5",
				"text_image6",
				"text_image7",
				"text_image8",
				"text_image9",
				
				"image_block1",
				"image_block2",
				"image_block3",
				"image_block4",
				"image_block5",
				"image_block6",
				"image_block7",
				"image_block8",
				"image_block9",
				
				"icon1_image",
				"icon2_image",
				"icon3_image",
				"icon4_image",
				"icon5_image",
				"icon6_image",
				"icon7_image",
				"icon8_image", 

				
				"image_subscribe",
				"image_icon",
				"image_cta",
				"image_faq",
				
				"author_image1",
				"author_image2",
				"author_image3",
				"author_image4",
				"author_image5",
				"author_image6",
				"author_image7",
				
				
				
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'url' => $a,
						);
					$imgidrandom++;
				}	
				
				
				if( in_array($k, array(
				
				"btn_icon", 
				"btn2_icon",
								
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'value' => $a,
						);
					$imgidrandom++;
				}		
			
			}
			
			$columns[] = array( 
			 
				
					"id" 		=> "49157210",
					"isInner" 	=> false,
					"elType" 	=> "section",
					"settings" 	=> array(		
						"layout" 		=> "full_width",
						"css_classes" 	=> "",
					), 
					
					"elements" => array(
						
							0 => array(	
									"id" 		=> "49157211",
									"isInner" 	=> "1",
									"elType" 	=> "column",			 			
									"settings" => array(
										
										"_column_size" 	=> "100",
										"layout" 		=> "full_width",	
																
									),						
									
									"elements" => array(
									
										0 => array(	
												"id" 			=> "49157213",
												"isInner" 		=> false,
												"elType" 		=> "widget",							
												"widgetType" 	=> "new-hero",
																
												"settings" => $block_settings,
												
												"elements" => array( ),
										), 
										
									), // end widget
									
									
									
									
							),// end elements (column )
				
						),
					 
				);	 
		
	
	}

}

	

}elseif(strlen($_GET['loadpage']) > 1 ){
 
 
	$g = $CORE->LAYOUT("load_single_design", $_GET['loadpage']);	
 	
	// CHECK FOR ELEMENTOR TEMPLATE
	if(isset($g['elementor'])){
	
				$elementor_file = $g['elementor']['homepage'];	
	 
				if(!file_exists($elementor_file)){ unset($_SESSION['design_preview']); die("preview file not found"); }
				 
				// PROCESS IT 
				$elementor_importer = new PremiumPress_Elementor_Importer();
				$id = $elementor_importer->import_elementor_file( $elementor_file, $g['key']." - ".date('d-m-Y') );
				
				
				if( !is_wp_error( $id ) ) {	
				
				
					die(
					'<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>'.
					
					'<script>setTimeout(function() { window.location.href = "'.home_url().'/wp-admin/post.php?post='.$id.'&action=elementor"; }, 3000);</script>'
					); 
											
				
				}else{				
					die($id->get_error_message());			
				}	
				
			
	
	}else{
	
	
		// FIX PHP 7.1
			$existingdta = get_option("core_admin_values");
			if(!is_array($existingdta )){
			$existingdta  = array();
			}
	
 	$new_core_array = apply_filters( $_GET['loadpage'], $existingdta ); 
	
	if(isset($new_core_array['sampledata'])){ unset($new_core_array['sampledata']); }	
	
 	foreach( $CORE->LAYOUT("get_slots", array("header", 1,2,3,4,5,6,7,8,9,"footer") ) as $s){
	
	  	if(!isset($new_core_array['design'][$s['id']])){
		continue;
		} 
		
		$blid = $new_core_array['design'][$s['id']];
		 
		
		if(strlen($blid) > 1){
		   
			$cat = $CORE->LAYOUT("get_block_category", $blid );			
			 
			$blockKey = $blid;
			
			if($blockKey == ""){ continue; }
			
			$block_settings 				= array();			 
			
			if($cat == "header" || $cat == "footer"){
			$block_settings 				= $new_core_array[$cat][$blockKey]; 
			}else{
			$block_settings 				= $new_core_array['home'][$blockKey]; 			 
			} 
			
			$block_settings["type"] 		= $cat;
			$block_settings[$cat."_style"] 	= $blockKey;
			
			if($cat =="header"){
				$block_settings["color_primary"] 	= $new_core_array['design']['color_primary'];
				$block_settings["color_secondary"] 	= $new_core_array['design']['color_secondary'];
			}
			
			 
			// CLEANUP IMAGES			
			foreach($block_settings as $k => $a){
			
				if( in_array($k, array(
				"hero_image", 
				"text_image1",
				"text_image2",
				"text_image3",
				"text_image4",
				"text_image5",
				"text_image6",
				"text_image7",
				"text_image8",
				"text_image9",

				"icon1_image",
				"icon2_image",
				"icon3_image",
				"icon4_image",
				"icon5_image",
				"icon6_image",
				"icon7_image",
				"icon8_image", 

				
				"image_block1",
				"image_block2",
				"image_block3",
				"image_block4",
				"image_block5",
				"image_block6",
				"image_block7",
				"image_block8",
				"image_block9",

				"image_subscribe",
				"image_icon",
				"image_cta",
				"image_faq",
				
					"author_image1",
				"author_image2",
				"author_image3",
				"author_image4",
				"author_image5",
				"author_image6",
				"author_image7",
				
				
				
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'url' => $a,
						);
					$imgidrandom++;
				}	
				
				
				
				if( in_array($k, array(
				
				"btn_icon", 
				"btn2_icon",
								
				)) ){
				
				 	unset($block_settings[$k]);
					$block_settings[$k] = array(
						"id" => $imgidrandom,
						'value' => $a,
						);
					$imgidrandom++;
				}
						
			
			}
			
			//die(print_r($block_settings));
		 
			$columns[] = array( 
			 
				
					"id" 		=> "49157210",
					"isInner" 	=> false,
					"elType" 	=> "section",
					"settings" 	=> array(		
						"layout" 		=> "full_width",
						"css_classes" 	=> "",
					), 
					
					"elements" => array(
						
							0 => array(	
									"id" 		=> "49157211",
									"isInner" 	=> "1",
									"elType" 	=> "column",			 			
									"settings" => array(
										
										"_column_size" 	=> "100",
										"layout" 		=> "full_width",	
																
									),						
									
									"elements" => array(
									
										0 => array(	
												"id" 			=> "49157213",
												"isInner" 		=> false,
												"elType" 		=> "widget",							
												"widgetType" 	=> "new-hero",
																
												"settings" => $block_settings,
												
												"elements" => array( ),
										), 
										
									), // end widget
									
									
									
									
							),// end elements (column )
				
						),
					 
				);
		
		}
		
		}
		
	}




}




	if(is_array($columns) && !empty($columns) ){
	
	      
		$name = $_GET['loadpage']; 
		if(isset($_GET['inner'])){
			$name = $_GET['inner'];		
		} 
		
		  
	 	$elementor_importer = new PremiumPress_Elementor_Importer();	 	
		$id = $elementor_importer->import_elementor_file( json_encode($columns, JSON_PARTIAL_OUTPUT_ON_ERROR), $name." - ".date('d-m-Y') );
	
		
		//update_post_meta($id, '_wp_page_template', 'elementor_canvas');
	 	 
		// UPDATE DATABASE WITH NEW KEY
		if(isset($_GET['inner']) ){
 				if(strlen($_GET['inner']) > 2){				
				
					 
					$existing_values = get_option("core_admin_values");	
					
					if(isset($_GET['mobile'])){
					$existing_values['pageassign'][$_GET['inner']."_mobile"] = "elementor-".$id;
					}else{
					$existing_values['pageassign'][$_GET['inner']] = "elementor-".$id;
					}
										 
					update_option( "core_admin_values", $existing_values);
					
				
				}
		}elseif(isset($_GET['loadpage']) && $_GET['loadpage'] == "home"){
	
					
					$existing_values = get_option("core_admin_values");		
					
					
					if(isset($_GET['mobile'])){
					$existing_values['pageassign']["homepage_mobile"] = "elementor-".$id;	
					}else{
					$existing_values['pageassign']["homepage"] = "elementor-".$id;	
					}
								 	
									 
					update_option( "core_admin_values", $existing_values);
		
		}
				
	
		die(
		'<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-dark fa-spin"></i></div>'.
		
		'<script>setTimeout(function() { window.location.href = "'.home_url().'/wp-admin/post.php?post='.$id.'&action=elementor"; }, 3000);</script>'
		);
	
	}

}





} // end if admin




 

// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );

 	 
// LOAD IN HEADER


_ppt_template('framework/admin/header' ); 
 

_ppt_template('framework/admin/_form-top' ); 
?>
<?php if(isset($_GET['smallwindow'])){ ?>
<style>
#wpadminbar, #adminmenu, #adminmenuback, #wpfooter { display:none; }
#wpcontent { padding:0px; margin:0px !important; }
</style>
<?php } ?>



<div class="tab-content">

                
        
            <div class="tab-pane <?php if(!isset($_GET['smallwindow'])){ ?>active<?php } ?> addjumplink" 
         
        data-title="<?php echo __("Overview","premiumpress"); ?>" 
        data-desc="<?php echo __("Here are all of the design options for your website.","premiumpress"); ?>"
        
        data-icon="fa fa-info" 
        id="intro" 
        role="tabpanel" aria-labelledby="intro-tab">
         <?php _ppt_template('framework/admin/parts/design-overview' ); ?>      
        </div><!-- end design home tab -->
                 
         
        
 
          
             
     <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("Logo &amp; Fonts","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can change the display of your website logo.","premiumpress"); ?>"
       
        data-icon="fa fa-lightbulb" 
         
        id="logo" 
        role="tabpanel" aria-labelledby="logo-tab">
         <?php _ppt_template('framework/admin/parts/design-logo' ); ?> 
        </div><!-- end design home tab -->
             
 
 
     <div class="tab-pane  addjumplink design-display-hide" 
          
        
         data-title="<?php echo __("Header &amp; Footer","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can customize the appearance of your header and footer.","premiumpress"); ?>"
       
        data-icon="fa fa-pager" 
         
        id="header" 
        role="tabpanel" aria-labelledby="header-tab">
         <?php _ppt_template('framework/admin/parts/design-header' ); ?>    
        </div><!-- end design home tab -->
          
       
        <div class="tab-pane addjumplink  design-display-hide" 
        
        
           data-title="<?php echo __("Pages","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can custom your website pages.","premiumpress"); ?>"
 
        
        data-icon="fa-file-alt" 
        id="pagelinking" 
        role="tabpanel" aria-labelledby="pagelinking-tab">
     <?php _ppt_template('framework/admin/parts/design-pagelinking' ); ?>    
        </div><!-- end design home tab -->    
     
     
     
       <div class="tab-pane addjumplink  design-display-hide" 
        
           data-title="<?php echo __("Single Page","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can customize the single page layout for your website.","premiumpress"); ?>"
       
        data-icon="fa fa-file" 
         
        id="single" 
        role="tabpanel" aria-labelledby="single-tab">
           <?php _ppt_template('framework/admin/parts/design-single' ); ?>
        </div><!-- end design home tab -->
       
       
      <?php if(defined('THEME_KEY') && !in_array(THEME_KEY, array("ph"))){ ?>
       <div class="tab-pane addjumplink" 
        
           data-title="<?php echo __("Search Page","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can customize the search layout for your website.","premiumpress"); ?>"
       
        data-icon="fa fa-search" 
         
        id="search" 
        role="tabpanel" aria-labelledby="search-tab">
           <?php _ppt_template('framework/admin/parts/design-search' ); ?>
        </div><!-- end design home tab -->
        <?php } ?>
      
      
      <?php /*
        <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("My Account Page","premiumpress"); ?>" 
        data-desc="<?php echo __("Here are additional settings for the users account page","premiumpress"); ?>"
       
        data-icon="fa fa-users" 
        id="myaccount" 
        role="tabpanel" aria-labelledby="myaccount-tab">
          <?php _ppt_template('framework/admin/parts/design-myaccount' ); ?>  
        </div><!-- end design home tab -->
      
         */ ?>
         
         
        <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("Announcements","premiumpress"); ?>" 
        data-desc="<?php echo __("Setup a global announcements bar at the top of your website.","premiumpress"); ?>"
       
        data-icon="fa fa-bullhorn" 
        id="section" 
        role="tabpanel" aria-labelledby="section-tab">
          <?php _ppt_template('framework/admin/parts/design-sections' ); ?>  
        </div><!-- end design home tab -->
              
           
                  
        <div class="tab-pane  addjumplink design-display-hide" 
        
        data-title="<?php echo __("Design Ideas","premiumpress"); ?>" 
        data-desc="<?php echo __("Additional design ideas to help build your website.","premiumpress"); ?>"
 
        
        data-icon="fa fa-bullseye-arrow" 
        id="ideas" 
        role="tabpanel" aria-labelledby="ideas-tab">
         <?php _ppt_template('framework/admin/parts/design-ideas' ); ?>      
        </div><!-- end design home tab -->
                 
           
           
             
       <div class="tab-pane addjumplink" 
        
        
         data-title="<?php echo __("Colors","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can customize the color schema for your website.","premiumpress"); ?>"
 
        data-icon="fa fa-fill-drip" 
         
        id="colors" 
        role="tabpanel" aria-labelledby="colors-tab">
           <?php _ppt_template('framework/admin/parts/design-colors' ); ?>
        </div><!-- end design home tab -->
        
        
        
             
         
         <div class="tab-pane addjumplink" 
         
          data-title="<?php echo __("Custom CSS/JS","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can add additional CSS &amp; Javascript to your website.","premiumpress"); ?>"
 
        data-icon="fa fa-file-csv" 
         
        id="css" 
        role="tabpanel" aria-labelledby="css-tab">
            <?php _ppt_template('framework/admin/parts/design-css' ); ?> 
        </div><!-- end design home tab -->
         
        
        <?php /*
            <div class="tab-pane addjumplink" 
        
        
           data-title="<?php echo __("Elementor","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can preview any additonal Elementor templates that might be required.","premiumpress"); ?>"
 
        
        data-icon="fa fa-desktop" 
         
        id="elementor" 
        role="tabpanel" aria-labelledby="elementor-tab">
         <?php _ppt_template('framework/admin/parts/design-elementor' ); ?>      
        </div><!-- end design home tab -->
        
        
        */ ?>
      
              
    
         
              
        <div class="tab-pane <?php if(isset($_GET['smallwindow'])){ ?>active<?php } ?> addjumplink" 
        
        
            data-title="<?php echo __("All Blocks","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can preview all of the design blocks included in this theme.","premiumpress"); ?>"
 
        data-icon="fa-layer-group" 
        id="blocks" 
        role="tabpanel" aria-labelledby="blocks-tab">
       <?php _ppt_template('framework/admin/parts/design-blocks' ); ?>        
        </div><!-- end design home tab -->
        
        <?php if(isset($_GET['smallwindow'])){ ?>
        <input type="hidden" name="removesmallwindow" value="1" />
        <?php } ?>
		
        
        

</div>



<?php _ppt_template('framework/admin/_form-bottom' ); ?>

<form id="loaddemodesign" name="loaddemodesign" method="post">
<input type="hidden" name="loaddesign" id="loaddesign" value="123" />

</form>
 

<script>

function DeleteSetDesign(id){ 
	jQuery('#'+id).val('');
	document.admin_save_form.submit();
}
function setThisDesign(design, id){
	jQuery('#'+id).val(design);	 	
	document.admin_save_form.submit();
}
jQuery('.loadblockdataajax').on('click', function() {	
	
		var self = jQuery(this);
		var id = this.id;
		var divout = jQuery(this).data('tdiv');
			
		jQuery.ajax({
			type: "POST",
			url: '<?php echo home_url(); ?>/',	
			dataType: 'json',	
			data: {
				admin_action: "load_block_data",
				id: jQuery(this).data('blockid'),
			},
			success: function(response) {
					  	
				// HIDE ROW
				jQuery('#'+divout).html(response.output); 				
				 			
			},
			error: function(e) {
				alert("error gere "+e)
			}
		});		 
			
}); 



jQuery(document).ready(function () {

 
<?php if(isset($_GET['redirecthomepage'])  ){ ?>
window.location.href = "<?php echo home_url(); ?>";
<?php } ?>
 
<?php if(isset($_GET['defaultdesign']) && strlen($_GET['defaultdesign']) > 1 && !isset($_POST['loaddesign'])  ){ ?>
 
jQuery('#loaddesign').val('<?php echo esc_attr($_GET['defaultdesign']); ?>');
document.loaddemodesign.submit();

<?php } ?>

 
 
 	<?php if(isset($_GET['pagekey']) && $_GET['pagekey'] == "home"){ ?>
	
	jQuery('.lefttab').val('pagelinking-tab');
	
	<?php }elseif(isset($_GET['pagekey']) && $_GET['pagekey'] == "header" || isset($_GET['pagekey']) && $_GET['pagekey'] == "footer" ){ ?>
	
	jQuery('.lefttab').val('header-tab');
	
 	<?php }elseif(isset($_GET['pagekey'])){ ?>
	
 	jQuery('.lefttab').val('pagelinking-tab');
	
	<?php } ?>

	<?php if(isset($_POST['removesmallwindow'])){ ?>
 
	self.parent.tb_remove();
	self.parent.location.assign("<?php echo home_url(); ?>/wp-admin/admin.php?page=design&lefttab="+jQuery('.lefttab').val());	 
	<?php } ?>
	
             
     jQuery('.loaddatabox').click(function() { 
              			   	 
     	tb_show('', 'admin.php?page=design&amp;tid='+ jQuery(this).data('id') +'&amp;pagekey='+ jQuery(this).data('pagekey') + '&amp;smallwindow=1&amp;TB_iframe=true');
		return false;	
 	
     });  
	 
     jQuery('.loadsettingsbox').click(function() { 
	          			   	 
     	tb_show('', 'admin.php?page=design&amp;tid='+ jQuery(this).data('id') +'&amp;sid='+ jQuery(this).data('settingid') +'&amp;pagekey='+ jQuery(this).data('pagekey') +'&amp;smallwindow=1&amp;TB_iframe=true');
		return false;	
 	
     });
  
});
</script>
<?php _ppt_template('framework/admin/footer' ); ?>