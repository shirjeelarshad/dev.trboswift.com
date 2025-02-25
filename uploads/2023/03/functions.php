<?php

 
// LOAD IN CHILD THEME OPTIONS
add_filter( 'ppt_admin_layouts',  array('childtheme_Child_Themes',  'data') );
add_filter( 'childtheme_Child_Themes',  array('childtheme_Child_Themes',  'load') );
 
$childtheme_Child_Themes	= new childtheme_Child_Themes; 
class childtheme_Child_Themes { 

	function _construct(){ 
	
		// LANGUAGES
		load_childtheme_theme_textdomain( 'premiumpress-childtheme_', get_stylesheet_directory() . '/languages' );	 

	} 
 
	public static function data($a){ 
	
		global $CORE;
  
		$a['childtheme_Child_Themes'] = array(
		
			"key" => "childtheme_Child_Themes",
		
			"name" 	=> "Child Themes",
			
			"image"	=> get_stylesheet_directory_uri()."/",
						
			"theme"	=> "childtheme_at",	
 			
			"order" => 1,			
			
			"elementor" => array( 
		
				"homepage" => __DIR__ ."/",
				
			),
 	 		
		);		
		
		return $a;
	
	}	
	
	public static  function load($core){  global $CORE;
 
		/* logo */
		$core['design']['logo_url_aid'] = "";
		$core['design']['logo_url'] = get_stylesheet_directory_uri()."/";
		$core['design']['light_logo_url_aid'] = "";
		$core['design']['light_logo_url'] = get_stylesheet_directory_uri()."/";
		$core['design']['textlogo'] = "<i class='fal fa-hand-pointer ml-2 text-primary'>&nbsp;</i> <span class='font-weight-bold text-primary'>Auction</span>House";
		$core['design']['color_bg'] = "";
		$core['design']['color_text'] = "";	
	
		$core['design']['header_style'] = "header7";
		$core['design']['footer_style'] = "footer1"; 
		
		$core['design']['slot1_style'] = "elementor";
		$core['design']['slot2_style'] =  "";
		$core['design']['slot3_style'] = "";
		$core['design']['slot4_style'] = "";
		$core['design']['slot5_style'] = '';
		$core['design']['slot6_style'] = '';
		$core['design']['slot7_style'] = '';
		$core['design']['slot8_style'] = '';
		$core['design']['slot9_style'] = '';
		
		$core['design']['color_primary'] = "#c3001e";
		$core['design']['color_secondary'] = "#0c2b64"; 
 		
				
  
		// DEFAULT INNER PAGE DAATA
		$core = $CORE->LAYOUT("default_innerpages", $core);
	 	 			
			
	return $core;
	} 
	
}
 

?>