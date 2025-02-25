<?php
 
add_filter( 'ppt_admin_layouts',  array('at_style3e',  'data') );
add_filter( 'at_style3e',  array('at_style3e',  'load') );
 
class at_style3e {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['at_style3e'] = array(
		
			"key" => "at_style3e",
		
			"name" 	=> "Style 3",
			"image"	=> _ppt_demopath()."/designs/style3e.jpg",
						
			"theme"	=> "at_style3",
			
			
			"color_p" 	=> "#D8AE5B",
			"color_s" 	=> "#111111",
			
			"order" => 0
 	 		
		);		
		
		return $a;
	
	} 
	
	
	
	public static  function load($core){ global $CORE; 
 
 
 
	/* logo */
	$core['design']['logo_url_aid'] = "";
	$core['design']['logo_url'] = _ppt_demopath()."/style3/logo.png";
	$core['design']['light_logo_url_aid'] = "1";
	$core['design']['light_logo_url'] = _ppt_demopath()."/style3/logo.png";
	$core['design']['textlogo'] = "";  
	
	$core['design']['header_style'] = "header12";
$core['design']['slot1_style'] = "hero_text1";
$core['design']['slot2_style'] = "category1";
$core['design']['slot3_style'] = "listings3";
$core['design']['slot4_style'] = "text1";
$core['design']['slot5_style'] = "listings2";
$core['design']['footer_style'] = "footer1";
$core['design']['slot6_style'] = '';
$core['design']['slot7_style'] = '';
$core['design']['slot8_style'] = '';
$core['design']['slot9_style'] = '';
$core['design']['color_primary'] = "#7e294d";
$core['design']['color_secondary'] = "#111111";
 
 
        /* header12 */    
        $core["header"]["header12"]["section_padding"] = "section-80";     
        $core["header"]["header12"]["section_bg"] = "bg-white";     
        $core["header"]["header12"]["section_pos"] = "";     
        $core["header"]["header12"]["section_w"] = "container";     
        $core["header"]["header12"]["section_pattern"] = "";     
        $core["header"]["header12"]["btn_show"] = "yes";     
        $core["header"]["header12"]["btn_link"] = "[link-add]";     
        $core["header"]["header12"]["btn_txt"] = "Add Auction";     
        $core["header"]["header12"]["btn_bg"] = "light";     
        $core["header"]["header12"]["btn_bg_txt"] = "text-dark";     
        $core["header"]["header12"]["btn_icon"] = "fas fa-long-arrow-alt-right";     
        $core["header"]["header12"]["btn_icon_pos"] = "after";     
        $core["header"]["header12"]["btn_size"] = "btn-md";     
        $core["header"]["header12"]["btn_margin"] = "mt-0";     
        $core["header"]["header12"]["btn_style"] = "1";     
        $core["header"]["header12"]["btn_font"] = "";     
        $core["header"]["header12"]["topmenu_show"] = "yes";     
        $core["header"]["header12"]["extra_show"] = "yes";     
        $core["header"]["header12"]["extra_type"] = ""; 		
 
        /* hero_text1 */    
        $core["home"]["hero_text1"]["section_padding"] = "section-40";     
        $core["home"]["hero_text1"]["section_bg"] = "bg-light";     
        $core["home"]["hero_text1"]["section_pos"] = "";     
        $core["home"]["hero_text1"]["section_w"] = "container";     
        $core["home"]["hero_text1"]["section_pattern"] = "";     
        $core["home"]["hero_text1"]["title_show"] = "yes";     
        $core["home"]["hero_text1"]["title"] = "Welcome to our auction website!";     
        $core["home"]["hero_text1"]["subtitle"] = "We've got exactly what you're looking for!";     
        $core["home"]["hero_text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";     
        $core["home"]["hero_text1"]["title_style"] = "1";     
        $core["home"]["hero_text1"]["title_pos"] = "left";     
        $core["home"]["hero_text1"]["title_heading"] = "h1";     
        $core["home"]["hero_text1"]["title_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["subtitle_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["desc_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["title_txtcolor"] = "dark";     
        $core["home"]["hero_text1"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["hero_text1"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["hero_text1"]["title_font"] = "";     
        $core["home"]["hero_text1"]["subtitle_font"] = "";     
        $core["home"]["hero_text1"]["desc_font"] = "";     
        $core["home"]["hero_text1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["btn_show"] = "yes";     
        $core["home"]["hero_text1"]["btn_link"] = "[link-search]";     
        $core["home"]["hero_text1"]["btn_txt"] = "Search Auctions";     
        $core["home"]["hero_text1"]["btn_bg"] = "primary";     
        $core["home"]["hero_text1"]["btn_bg_txt"] = "text-light";     
        $core["home"]["hero_text1"]["btn_icon"] = "fas fa-search";     
        $core["home"]["hero_text1"]["btn_icon_pos"] = "before";     
        $core["home"]["hero_text1"]["btn_size"] = "btn-md";     
        $core["home"]["hero_text1"]["btn_margin"] = "mt-0";     
        $core["home"]["hero_text1"]["btn_style"] = "1";     
        $core["home"]["hero_text1"]["btn_font"] = "";     
        $core["home"]["hero_text1"]["btn2_show"] = "yes";     
        $core["home"]["hero_text1"]["btn2_link"] = "[link-login]";     
        $core["home"]["hero_text1"]["btn2_txt"] = "Member Login";     
        $core["home"]["hero_text1"]["btn2_bg"] = "primary";     
        $core["home"]["hero_text1"]["btn2_bg_txt"] = "text-light";     
        $core["home"]["hero_text1"]["btn2_icon"] = "far fa-user-circle";     
        $core["home"]["hero_text1"]["btn2_icon_pos"] = "before";     
        $core["home"]["hero_text1"]["btn2_size"] = "btn-md";     
        $core["home"]["hero_text1"]["btn2_margin"] = "mt-0";     
        $core["home"]["hero_text1"]["btn2_style"] = "1";     
        $core["home"]["hero_text1"]["btn2_font"] = "";     
        $core["home"]["hero_text1"]["hero_image"] = _ppt_demopath()."/style3/hero5.jpg";     
        $core["home"]["hero_text1"]["hero_size"] = "hero-medium";     
        $core["home"]["hero_text1"]["hero_txtcolor"] = "dark"; 		
 
        /* category1 */    
        $core["home"]["category1"]["section_padding"] = "section-80";     
        $core["home"]["category1"]["section_bg"] = "bg-light";     
        $core["home"]["category1"]["section_pos"] = "";     
        $core["home"]["category1"]["section_w"] = "container";     
        $core["home"]["category1"]["section_pattern"] = "";     
        $core["home"]["category1"]["title_show"] = "yes";     
        $core["home"]["category1"]["title"] = "POPULAR CATEGORIES";     
        $core["home"]["category1"]["subtitle"] = "";     
        $core["home"]["category1"]["desc"] = "";     
        $core["home"]["category1"]["title_style"] = "1";     
        $core["home"]["category1"]["title_pos"] = "center";     
        $core["home"]["category1"]["title_heading"] = "h2";     
        $core["home"]["category1"]["title_margin"] = "mb-0";     
        $core["home"]["category1"]["subtitle_margin"] = "mb-4";     
        $core["home"]["category1"]["desc_margin"] = "mb-4";     
        $core["home"]["category1"]["title_txtcolor"] = "dark";     
        $core["home"]["category1"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["category1"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["category1"]["title_font"] = "";     
        $core["home"]["category1"]["subtitle_font"] = "";     
        $core["home"]["category1"]["desc_font"] = "";     
        $core["home"]["category1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["category1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["category1"]["cat_show"] = "16";     
        $core["home"]["category1"]["cat_show_list"] = "5";     
        $core["home"]["category1"]["cat_offset"] = "0"; 		
 
        /* listings3 */    
        $core["home"]["listings3"]["section_padding"] = "section-top-60";     
        $core["home"]["listings3"]["section_bg"] = "bg-white";     
        $core["home"]["listings3"]["section_pos"] = "";     
        $core["home"]["listings3"]["section_w"] = "container";     
        $core["home"]["listings3"]["section_pattern"] = "";     
        $core["home"]["listings3"]["title_show"] = "yes";     
        $core["home"]["listings3"]["title"] = "FEATURED ADS";     
        $core["home"]["listings3"]["subtitle"] = "";     
        $core["home"]["listings3"]["desc"] = "";     
        $core["home"]["listings3"]["title_style"] = "1";     
        $core["home"]["listings3"]["title_pos"] = "center";     
        $core["home"]["listings3"]["title_heading"] = "h2";     
        $core["home"]["listings3"]["title_margin"] = "mb-4";     
        $core["home"]["listings3"]["subtitle_margin"] = "mb-4";     
        $core["home"]["listings3"]["desc_margin"] = "mb-4";     
        $core["home"]["listings3"]["title_txtcolor"] = "dark";     
        $core["home"]["listings3"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["listings3"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["listings3"]["title_font"] = "";     
        $core["home"]["listings3"]["subtitle_font"] = "";     
        $core["home"]["listings3"]["desc_font"] = "";     
        $core["home"]["listings3"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["listings3"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["listings3"]["datastring"] = " dataonly='1' cat='' show='' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings3"]["perrow"] = "4";     
        $core["home"]["listings3"]["card"] = "blank";     
        $core["home"]["listings3"]["limit"] = "";     
        $core["home"]["listings3"]["custom"] = "new"; 		
 
        /* text1 */    
        $core["home"]["text1"]["section_padding"] = "section-80";     
        $core["home"]["text1"]["section_bg"] = "bg-light";     
        $core["home"]["text1"]["section_pos"] = "";     
        $core["home"]["text1"]["section_w"] = "container";     
        $core["home"]["text1"]["section_pattern"] = "";     
        $core["home"]["text1"]["title_show"] = "yes";     
        $core["home"]["text1"]["title"] = "Welcome to our website.";     
        $core["home"]["text1"]["subtitle"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.";     
        $core["home"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat.";     
        $core["home"]["text1"]["title_style"] = "1";     
        $core["home"]["text1"]["title_pos"] = "left";     
        $core["home"]["text1"]["title_heading"] = "h2";     
        $core["home"]["text1"]["title_margin"] = "mb-4";     
        $core["home"]["text1"]["subtitle_margin"] = "mb-4";     
        $core["home"]["text1"]["desc_margin"] = "mb-4";     
        $core["home"]["text1"]["title_txtcolor"] = "dark";     
        $core["home"]["text1"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["text1"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["text1"]["title_font"] = "";     
        $core["home"]["text1"]["subtitle_font"] = "";     
        $core["home"]["text1"]["desc_font"] = "";     
        $core["home"]["text1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["text1"]["btn_show"] = "yes";     
        $core["home"]["text1"]["btn_link"] = "[link-search]";     
        $core["home"]["text1"]["btn_txt"] = "Search Website";     
        $core["home"]["text1"]["btn_bg"] = "primary";     
        $core["home"]["text1"]["btn_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn_icon"] = "fas fa-search";     
        $core["home"]["text1"]["btn_icon_pos"] = "before";     
        $core["home"]["text1"]["btn_size"] = "btn-md";     
        $core["home"]["text1"]["btn_margin"] = "mt-0";     
        $core["home"]["text1"]["btn_style"] = "1";     
        $core["home"]["text1"]["btn_font"] = "";     
        $core["home"]["text1"]["btn2_show"] = "yes";     
        $core["home"]["text1"]["btn2_link"] = "[link-login]";     
        $core["home"]["text1"]["btn2_txt"] = "Member Login";     
        $core["home"]["text1"]["btn2_bg"] = "primary";     
        $core["home"]["text1"]["btn2_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn2_icon"] = "far fa-user-circle";     
        $core["home"]["text1"]["btn2_icon_pos"] = "before";     
        $core["home"]["text1"]["btn2_size"] = "btn-md";     
        $core["home"]["text1"]["btn2_margin"] = "mt-0";     
        $core["home"]["text1"]["btn2_style"] = "1";     
        $core["home"]["text1"]["btn2_font"] = "";     
        $core["home"]["text1"]["text_image1"] = _ppt_demopath()."/style3/image2.jpg";     
        $core["home"]["text1"]["text_image1_title"] = "asd";     
        $core["home"]["text1"]["text_image1_link"] = ""; 		
 
        /* listings2 */    
        $core["home"]["listings2"]["section_padding"] = "section-80";     
        $core["home"]["listings2"]["section_bg"] = "bg-white";     
        $core["home"]["listings2"]["section_pos"] = "";     
        $core["home"]["listings2"]["section_w"] = "container";     
        $core["home"]["listings2"]["section_pattern"] = "";     
        $core["home"]["listings2"]["title_show"] = "yes";     
        $core["home"]["listings2"]["title"] = "Newly Added Auctions";     
        $core["home"]["listings2"]["subtitle"] = "";     
        $core["home"]["listings2"]["desc"] = "";     
        $core["home"]["listings2"]["title_style"] = "1";     
        $core["home"]["listings2"]["title_pos"] = "center";     
        $core["home"]["listings2"]["title_heading"] = "h2";     
        $core["home"]["listings2"]["title_margin"] = "mb-0";     
        $core["home"]["listings2"]["subtitle_margin"] = "mb-4";     
        $core["home"]["listings2"]["desc_margin"] = "mb-4";     
        $core["home"]["listings2"]["title_txtcolor"] = "dark";     
        $core["home"]["listings2"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["listings2"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["listings2"]["title_font"] = "";     
        $core["home"]["listings2"]["subtitle_font"] = "";     
        $core["home"]["listings2"]["desc_font"] = "";     
        $core["home"]["listings2"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["listings2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["listings2"]["datastring"] = " dataonly='1' cat='' show='' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings2"]["perrow"] = "5";     
        $core["home"]["listings2"]["card"] = "blank";     
        $core["home"]["listings2"]["limit"] = "";     
        $core["home"]["listings2"]["custom"] = "new"; 		
 
        /* footer1 */    
        $core["footer"]["footer1"]["section_padding"] = "section-60";     
        $core["footer"]["footer1"]["section_bg"] = "bg-primary";     
        $core["footer"]["footer1"]["section_pos"] = "";     
        $core["footer"]["footer1"]["section_w"] = "container-fluid";     
        $core["footer"]["footer1"]["section_pattern"] = ""; 		



  
			 
 
		// DEFAULT INNER PAGE DAATA
		$core = $CORE->LAYOUT("default_innerpages", $core);
		
		// SAMPLE DATA 
		$i=1;		
		while($i < 21){	
		
			$core['sampledata'][$i] = array(		 
					
					"title" => "Example Auction ".$i,	
					
					"image" => _ppt_demopath()."/products/photo/".$i.".jpg", 
					"thumb" => _ppt_demopath()."/products/photo/".$i.".jpg",			 
					 
						"images" => array(
					
						1 => array(
							"image" => _ppt_demopath()."/products/photo/".$i.".jpg", 
							"thumb" => _ppt_demopath()."/products/photo/".$i.".jpg",
						),
						2 => array(
							"image" => _ppt_demopath()."/products/photo/".$i.".jpg", 
							"thumb" => _ppt_demopath()."/products/photo/".$i.".jpg",
						),
						3 => array(
							"image" => _ppt_demopath()."/products/photo/".$i.".jpg", 
							"thumb" => _ppt_demopath()."/products/photo/".$i.".jpg",
						),	
											
						
					),
									 
				);
		$i++;	
		} 	
			
	return $core;
	}
	
	
}

?>