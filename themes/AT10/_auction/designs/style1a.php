<?php
 
add_filter( 'ppt_admin_layouts',  array('at_style1a',  'data') );
add_filter( 'at_style1a',  array('at_style1a',  'load') );
 
class at_style1a {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['at_style1a'] = array(
		
			"key" => "at_style1a",
		
			"name" 	=> "Style 1a",
			"image"	=> _ppt_demopath()."/designs/style1a.jpg",
						
			"theme"	=> "at_style1",
			
			
			"color_p" 	=> "#D8AE5B",
			"color_s" 	=> "#111111",
			
			"order" => 0
 	 		
		);		
		
		return $a;
	
	} 
	
	
	
	public static  function load($core){ global $CORE; 
  
 
	/* logo */
	$core['design']['logo_url_aid'] = "";
	$core['design']['logo_url'] = "";
	$core['design']['light_logo_url_aid'] = "";
	$core['design']['light_logo_url'] = "";
	$core['design']['textlogo'] = "<i class='fal fa-hand-pointer ml-2 text-primary'>&nbsp;</i> <span class='font-weight-bold text-primary'>Auction</span>House";  
 
	
$core['design']['header_style'] = "header7";
$core['design']['slot1_style'] = "hero_text1";
$core['design']['slot2_style'] = "listings2";
$core['design']['slot3_style'] = "text1";
$core['design']['slot4_style'] = "listings2a";
$core['design']['slot5_style'] = "text2";
$core['design']['slot6_style'] = "listings2b";
$core['design']['footer_style'] = "footer1";
$core['design']['slot7_style'] = 'subscribe2';
$core['design']['slot8_style'] = '';
$core['design']['slot9_style'] = '';
$core['design']['color_primary'] = "#c3001e";
$core['design']['color_secondary'] = "#0c2b64";
 
 
        /* header7 */    
        $core["header"]["header7"]["section_padding"] = "section-80";     
        $core["header"]["header7"]["section_bg"] = "bg-white";     
        $core["header"]["header7"]["section_pos"] = "";     
        $core["header"]["header7"]["section_w"] = "container";     
        $core["header"]["header7"]["section_pattern"] = "";     
        $core["header"]["header7"]["btn_show"] = "yes";     
        $core["header"]["header7"]["btn_link"] = "[link-add]";     
        $core["header"]["header7"]["btn_txt"] = "Add Auction";     
        $core["header"]["header7"]["btn_bg"] = "primary";     
        $core["header"]["header7"]["btn_bg_txt"] = "text-light";     
        $core["header"]["header7"]["btn_icon"] = "";     
        $core["header"]["header7"]["btn_icon_pos"] = "before";     
        $core["header"]["header7"]["btn_size"] = "btn-md";     
        $core["header"]["header7"]["btn_margin"] = "mt-0";     
        $core["header"]["header7"]["btn_style"] = "1";     
        $core["header"]["header7"]["btn_font"] = "";     
        $core["header"]["header7"]["topmenu_show"] = "yes";     
        $core["header"]["header7"]["extra_show"] = "yes"; 		
 
        /* hero_text1 */    
        $core["home"]["hero_text1"]["section_padding"] = "section-80";     
        $core["home"]["hero_text1"]["section_bg"] = "bg-light";     
        $core["home"]["hero_text1"]["section_pos"] = "";     
        $core["home"]["hero_text1"]["section_w"] = "container";     
        $core["home"]["hero_text1"]["section_pattern"] = "";     
        $core["home"]["hero_text1"]["title_show"] = "yes";     
        $core["home"]["hero_text1"]["title"] = "Online Auction Website";     
        $core["home"]["hero_text1"]["subtitle"] = "Big saving on amazing items!";     
        $core["home"]["hero_text1"]["desc"] = "";     
        $core["home"]["hero_text1"]["title_style"] = "1";     
        $core["home"]["hero_text1"]["title_pos"] = "left";     
        $core["home"]["hero_text1"]["title_heading"] = "h1";     
        $core["home"]["hero_text1"]["title_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["subtitle_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["desc_margin"] = "mb-4";     
        $core["home"]["hero_text1"]["title_txtcolor"] = "dark";     
        $core["home"]["hero_text1"]["subtitle_txtcolor"] = "primary";     
        $core["home"]["hero_text1"]["desc_txtcolor"] = "dark";     
        $core["home"]["hero_text1"]["title_font"] = "";     
        $core["home"]["hero_text1"]["subtitle_font"] = "";     
        $core["home"]["hero_text1"]["desc_font"] = "";     
        $core["home"]["hero_text1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["btn_show"] = "yes";     
        $core["home"]["hero_text1"]["btn_link"] = "[link-search]";     
        $core["home"]["hero_text1"]["btn_txt"] = "View Auctions";     
        $core["home"]["hero_text1"]["btn_bg"] = "light";     
        $core["home"]["hero_text1"]["btn_bg_txt"] = "text-dark";     
        $core["home"]["hero_text1"]["btn_icon"] = "fas fa-long-arrow-alt-right";     
        $core["home"]["hero_text1"]["btn_icon_pos"] = "after";     
        $core["home"]["hero_text1"]["btn_size"] = "btn-xl";     
        $core["home"]["hero_text1"]["btn_margin"] = "mt-5";     
        $core["home"]["hero_text1"]["btn_style"] = "3";     
        $core["home"]["hero_text1"]["btn_font"] = "";     
        $core["home"]["hero_text1"]["btn2_show"] = "no";     
        $core["home"]["hero_text1"]["hero_image"] = _ppt_demopath()."/style1/hero1.jpg";     
        $core["home"]["hero_text1"]["hero_size"] = "hero-medium";     
        $core["home"]["hero_text1"]["hero_txtcolor"] = "light"; 		
 
        /* listings2 */    
        $core["home"]["listings2"]["section_padding"] = "section-80";     
        $core["home"]["listings2"]["section_bg"] = "bg-white";     
        $core["home"]["listings2"]["section_pos"] = "";     
        $core["home"]["listings2"]["section_w"] = "container";     
        $core["home"]["listings2"]["section_pattern"] = "";     
        $core["home"]["listings2"]["title_show"] = "yes";     
        $core["home"]["listings2"]["title"] = "Featured Auctions";     
        $core["home"]["listings2"]["subtitle"] = "";     
        $core["home"]["listings2"]["desc"] = "";     
        $core["home"]["listings2"]["title_style"] = "1";     
        $core["home"]["listings2"]["title_pos"] = "center";     
        $core["home"]["listings2"]["title_heading"] = "h2";     
        $core["home"]["listings2"]["title_margin"] = "mb-4";     
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
        $core["home"]["listings2"]["datastring"] = " dataonly='1' cat='' show='8' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings2"]["perrow"] = "4";     
        $core["home"]["listings2"]["card"] = "list-small";     
        $core["home"]["listings2"]["limit"] = "8"; 		
 
        /* text1 */    
        $core["home"]["text1"]["section_padding"] = "section-80";     
        $core["home"]["text1"]["section_bg"] = "bg-light";     
        $core["home"]["text1"]["section_pos"] = "";     
        $core["home"]["text1"]["section_w"] = "container";     
        $core["home"]["text1"]["section_pattern"] = "";     
        $core["home"]["text1"]["title_show"] = "yes";     
        $core["home"]["text1"]["title"] = "Welcome to <i class='fal fa-hand-pointer ml-2 text-primary'>&nbsp;</i> <span class='font-weight-bold text-primary'>Auction</span>House";     
        $core["home"]["text1"]["subtitle"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.";     
        $core["home"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";     
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
        $core["home"]["text1"]["btn_txt"] = "Search auctions";     
        $core["home"]["text1"]["btn_bg"] = "primary";     
        $core["home"]["text1"]["btn_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn_icon"] = "";     
        $core["home"]["text1"]["btn_icon_pos"] = "after";     
        $core["home"]["text1"]["btn_size"] = "btn-lg";     
        $core["home"]["text1"]["btn_margin"] = "mt-0";     
        $core["home"]["text1"]["btn_style"] = "5";     
        $core["home"]["text1"]["btn_font"] = "";     
        $core["home"]["text1"]["btn2_show"] = "yes";     
        $core["home"]["text1"]["btn2_link"] = "[link-search]";     
        $core["home"]["text1"]["btn2_txt"] = "Contact Us";     
        $core["home"]["text1"]["btn2_bg"] = "primary";     
        $core["home"]["text1"]["btn2_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn2_icon"] = "";     
        $core["home"]["text1"]["btn2_icon_pos"] = "before";     
        $core["home"]["text1"]["btn2_size"] = "btn-lg";     
        $core["home"]["text1"]["btn2_margin"] = "mt-0";     
        $core["home"]["text1"]["btn2_style"] = "5";     
        $core["home"]["text1"]["btn2_font"] = "";     
        $core["home"]["text1"]["text_image1"] = _ppt_demopath()."/style1/image1.jpg";     
        $core["home"]["text1"]["text_image1_title"] = "Welcome";     
        $core["home"]["text1"]["text_image1_link"] = "[link-search]"; 		
 
        /* listings2 */    
        $core["home"]["listings2a"]["section_padding"] = "section-80";     
        $core["home"]["listings2a"]["section_bg"] = "bg-white";     
        $core["home"]["listings2a"]["section_pos"] = "";     
        $core["home"]["listings2a"]["section_w"] = "container";     
        $core["home"]["listings2a"]["section_pattern"] = "";     
        $core["home"]["listings2a"]["title_show"] = "yes";     
        $core["home"]["listings2a"]["title"] = "RECENTLY ADDED";     
        $core["home"]["listings2a"]["subtitle"] = "";     
        $core["home"]["listings2a"]["desc"] = "";     
        $core["home"]["listings2a"]["title_style"] = "1";     
        $core["home"]["listings2a"]["title_pos"] = "center";     
        $core["home"]["listings2a"]["title_heading"] = "h2";     
        $core["home"]["listings2a"]["title_margin"] = "mb-4";     
        $core["home"]["listings2a"]["subtitle_margin"] = "mb-4";     
        $core["home"]["listings2a"]["desc_margin"] = "mb-4";     
        $core["home"]["listings2a"]["title_txtcolor"] = "dark";     
        $core["home"]["listings2a"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["listings2a"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["listings2a"]["title_font"] = "";     
        $core["home"]["listings2a"]["subtitle_font"] = "";     
        $core["home"]["listings2a"]["desc_font"] = "";     
        $core["home"]["listings2a"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["listings2a"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["listings2a"]["datastring"] = " dataonly='1' cat='' show='8' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings2a"]["perrow"] = "4";     
        $core["home"]["listings2a"]["card"] = "list-small";     
        $core["home"]["listings2a"]["limit"] = "8"; 		
 
        /* text2 */    
        $core["home"]["text2"]["section_padding"] = "section-80";     
        $core["home"]["text2"]["section_bg"] = "bg-light";     
        $core["home"]["text2"]["section_pos"] = "";     
        $core["home"]["text2"]["section_w"] = "container";     
        $core["home"]["text2"]["section_pattern"] = "";     
        $core["home"]["text2"]["title_show"] = "yes";     
        $core["home"]["text2"]["title"] = "Buy & sell your old stuff!";     
        $core["home"]["text2"]["subtitle"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.";     
        $core["home"]["text2"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";     
        $core["home"]["text2"]["title_style"] = "1";     
        $core["home"]["text2"]["title_pos"] = "left";     
        $core["home"]["text2"]["title_heading"] = "h2";     
        $core["home"]["text2"]["title_margin"] = "mb-4";     
        $core["home"]["text2"]["subtitle_margin"] = "mb-4";     
        $core["home"]["text2"]["desc_margin"] = "mb-4";     
        $core["home"]["text2"]["title_txtcolor"] = "dark";     
        $core["home"]["text2"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["text2"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["text2"]["title_font"] = "";     
        $core["home"]["text2"]["subtitle_font"] = "";     
        $core["home"]["text2"]["desc_font"] = "";     
        $core["home"]["text2"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["text2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["text2"]["btn_show"] = "yes";     
        $core["home"]["text2"]["btn_link"] = "[link-search]";     
        $core["home"]["text2"]["btn_txt"] = "Search auctions";     
        $core["home"]["text2"]["btn_bg"] = "primary";     
        $core["home"]["text2"]["btn_bg_txt"] = "text-light";     
        $core["home"]["text2"]["btn_icon"] = "fas fa-long-arrow-alt-right";     
        $core["home"]["text2"]["btn_icon_pos"] = "after";     
        $core["home"]["text2"]["btn_size"] = "btn-xl";     
        $core["home"]["text2"]["btn_margin"] = "mt-0";     
        $core["home"]["text2"]["btn_style"] = "5";     
        $core["home"]["text2"]["btn_font"] = "";     
        $core["home"]["text2"]["btn2_show"] = "no";     
        $core["home"]["text2"]["text_image1"] = _ppt_demopath()."/style1/image2.jpg";     
        $core["home"]["text2"]["text_image1_title"] = "Welcome";     
        $core["home"]["text2"]["text_image1_link"] = "[link-search]"; 		
 
        /* subscribe2 */    
        $core["home"]["subscribe2"]["section_padding"] = "section-100";     
        $core["home"]["subscribe2"]["section_bg"] = "bg-light";     
        $core["home"]["subscribe2"]["section_pos"] = "";     
        $core["home"]["subscribe2"]["section_w"] = "container";     
        $core["home"]["subscribe2"]["section_pattern"] = "";     
        $core["home"]["subscribe2"]["title_show"] = "yes";     
        $core["home"]["subscribe2"]["title"] = "STAY <i class='fal fa-star mx-2 text-primary'></i> UPDATED";     
        $core["home"]["subscribe2"]["subtitle"] = "Join our newsletter today!";     
        $core["home"]["subscribe2"]["desc"] = "";     
        $core["home"]["subscribe2"]["title_style"] = "1";     
        $core["home"]["subscribe2"]["title_pos"] = "left";     
        $core["home"]["subscribe2"]["title_heading"] = "h2";     
        $core["home"]["subscribe2"]["title_margin"] = "mb-2";     
        $core["home"]["subscribe2"]["subtitle_margin"] = "mb-4";     
        $core["home"]["subscribe2"]["desc_margin"] = "mb-4";     
        $core["home"]["subscribe2"]["title_txtcolor"] = "dark";     
        $core["home"]["subscribe2"]["subtitle_txtcolor"] = "light";     
        $core["home"]["subscribe2"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["subscribe2"]["title_font"] = "";     
        $core["home"]["subscribe2"]["subtitle_font"] = "";     
        $core["home"]["subscribe2"]["desc_font"] = "";     
        $core["home"]["subscribe2"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["subscribe2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["subscribe2"]["image_subscribe"] = _ppt_demopath()."/style1/hero2.jpg"; 		
 
        /* footer1 */    
        $core["footer"]["footer1"]["section_padding"] = "section-60";     
        $core["footer"]["footer1"]["section_bg"] = "bg-secondary";     
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