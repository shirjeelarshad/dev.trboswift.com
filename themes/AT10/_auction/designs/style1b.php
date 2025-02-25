<?php
 
add_filter( 'ppt_admin_layouts',  array('at_style1b',  'data') );
add_filter( 'at_style1b',  array('at_style1b',  'load') );
 
class at_style1b {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['at_style1b'] = array(
		
			"key" => "at_style1b",
		
			"name" 	=> "Style 1b",
			"image"	=> _ppt_demopath()."/designs/style1b.jpg",
						
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
$core['design']['slot2_style'] = "testimonials3a";
$core['design']['slot3_style'] = "icon8";
$core['design']['slot4_style'] = "text2";
$core['design']['slot5_style'] = "cta1";
$core['design']['slot6_style'] = "listings2";
$core['design']['slot7_style'] = "subscribe2";
$core['design']['footer_style'] = "footer1";
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
        $core["home"]["hero_text1"]["subtitle"] = "Awesome items at amazing prices!";     
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
        $core["home"]["hero_text1"]["hero_image"] = _ppt_demopath()."/style1/hero2.jpg";     
        $core["home"]["hero_text1"]["hero_size"] = "hero-medium";     
        $core["home"]["hero_text1"]["hero_txtcolor"] = "light"; 		
 
        /* testimonials3a */    
        $core["home"]["testimonials3a"]["section_padding"] = "section-40";     
        $core["home"]["testimonials3a"]["section_bg"] = "bg-light";     
        $core["home"]["testimonials3a"]["section_pos"] = "";     
        $core["home"]["testimonials3a"]["section_w"] = "container";     
        $core["home"]["testimonials3a"]["section_pattern"] = "";     
        $core["home"]["testimonials3a"]["title_show"] = "no"; 		
 
        /* icon8 */    
        $core["home"]["icon8"]["section_padding"] = "section-80";     
        $core["home"]["icon8"]["section_bg"] = "bg-white";     
        $core["home"]["icon8"]["section_pos"] = "";     
        $core["home"]["icon8"]["section_w"] = "container";     
        $core["home"]["icon8"]["section_pattern"] = "";     
        $core["home"]["icon8"]["title_show"] = "yes";     
        $core["home"]["icon8"]["title"] = "POPULAR <i class='fal fa-star mx-2 text-primary'></i> CATEGORIES";     
        $core["home"]["icon8"]["subtitle"] = "";     
        $core["home"]["icon8"]["desc"] = "";     
        $core["home"]["icon8"]["title_style"] = "1";     
        $core["home"]["icon8"]["title_pos"] = "center";     
        $core["home"]["icon8"]["title_heading"] = "h2";     
        $core["home"]["icon8"]["title_margin"] = "mb-4";     
        $core["home"]["icon8"]["subtitle_margin"] = "mb-4";     
        $core["home"]["icon8"]["desc_margin"] = "mb-4";     
        $core["home"]["icon8"]["title_txtcolor"] = "dark";     
        $core["home"]["icon8"]["subtitle_txtcolor"] = "primary";     
        $core["home"]["icon8"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["icon8"]["title_font"] = "";     
        $core["home"]["icon8"]["subtitle_font"] = "";     
        $core["home"]["icon8"]["desc_font"] = "";     
        $core["home"]["icon8"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["icon8"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["icon8"]["btn_show"] = "yes";     
        $core["home"]["icon8"]["btn_link"] = "[link-search]";     
        $core["home"]["icon8"]["btn_txt"] = "SHOW MORE ";     
        $core["home"]["icon8"]["btn_bg"] = "primary";     
        $core["home"]["icon8"]["btn_bg_txt"] = "";     
        $core["home"]["icon8"]["btn_icon"] = "";     
        $core["home"]["icon8"]["btn_icon_pos"] = "before";     
        $core["home"]["icon8"]["btn_size"] = "btn-xl";     
        $core["home"]["icon8"]["btn_margin"] = "mt-4";     
        $core["home"]["icon8"]["btn_style"] = "5";     
        $core["home"]["icon8"]["btn_font"] = "";     
        $core["home"]["icon8"]["btn2_show"] = "no";     
        $core["home"]["icon8"]["icon1"] = "";     
        $core["home"]["icon8"]["icon1_title"] = "Doctor";     
        $core["home"]["icon8"]["icon1_desc"] = "";     
        $core["home"]["icon8"]["icon1_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon1_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon1_iconcolor"] = "";     
        $core["home"]["icon8"]["icon1_type"] = "image";     
        $core["home"]["icon8"]["icon1_image"] = _ppt_demopath()."/style1/8.png";     
        $core["home"]["icon8"]["icon2"] = "";     
        $core["home"]["icon8"]["icon2_title"] = "Hospitality";     
        $core["home"]["icon8"]["icon2_desc"] = "";     
        $core["home"]["icon8"]["icon2_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon2_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon2_iconcolor"] = "";     
        $core["home"]["icon8"]["icon2_type"] = "image";     
        $core["home"]["icon8"]["icon2_image"] = _ppt_demopath()."/style1/3.png";     
        $core["home"]["icon8"]["icon3"] = "";     
        $core["home"]["icon8"]["icon3_title"] = "Software";     
        $core["home"]["icon8"]["icon3_desc"] = "";     
        $core["home"]["icon8"]["icon3_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon3_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon3_iconcolor"] = "";     
        $core["home"]["icon8"]["icon3_type"] = "image";     
        $core["home"]["icon8"]["icon3_image"] = _ppt_demopath()."/style1/7.png";     
        $core["home"]["icon8"]["icon4"] = "";     
        $core["home"]["icon8"]["icon4_title"] = "Office";     
        $core["home"]["icon8"]["icon4_desc"] = "";     
        $core["home"]["icon8"]["icon4_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon4_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon4_iconcolor"] = "";     
        $core["home"]["icon8"]["icon4_type"] = "image";     
        $core["home"]["icon8"]["icon4_image"] = _ppt_demopath()."/style1/4.png";     
        $core["home"]["icon8"]["icon5"] = "";     
        $core["home"]["icon8"]["icon5_title"] = "HR";     
        $core["home"]["icon8"]["icon5_desc"] = "";     
        $core["home"]["icon8"]["icon5_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon5_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon5_iconcolor"] = "";     
        $core["home"]["icon8"]["icon5_type"] = "image";     
        $core["home"]["icon8"]["icon5_image"] = _ppt_demopath()."/style1/5.png";     
        $core["home"]["icon8"]["icon6"] = "";     
        $core["home"]["icon8"]["icon6_title"] = "Lawyer";     
        $core["home"]["icon8"]["icon6_desc"] = "";     
        $core["home"]["icon8"]["icon6_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon6_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon6_iconcolor"] = "";     
        $core["home"]["icon8"]["icon6_type"] = "image";     
        $core["home"]["icon8"]["icon6_image"] = _ppt_demopath()."/style1/6.png";     
        $core["home"]["icon8"]["icon7"] = "";     
        $core["home"]["icon8"]["icon7_title"] = "Electrician";     
        $core["home"]["icon8"]["icon7_desc"] = "";     
        $core["home"]["icon8"]["icon7_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon7_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon7_iconcolor"] = "";     
        $core["home"]["icon8"]["icon7_type"] = "image";     
        $core["home"]["icon8"]["icon7_image"] = _ppt_demopath()."/style1/2.png";     
        $core["home"]["icon8"]["icon8"] = "";     
        $core["home"]["icon8"]["icon8_title"] = "Fashion";     
        $core["home"]["icon8"]["icon8_desc"] = "";     
        $core["home"]["icon8"]["icon8_link"] = "[link-search]";     
        $core["home"]["icon8"]["icon8_txtcolor"] = "dark";     
        $core["home"]["icon8"]["icon8_iconcolor"] = "";     
        $core["home"]["icon8"]["icon8_type"] = "image";     
        $core["home"]["icon8"]["icon8_image"] = _ppt_demopath()."/style1/1.png"; 		
 
        /* text2 */    
        $core["home"]["text2"]["section_padding"] = "section-80";     
        $core["home"]["text2"]["section_bg"] = "bg-light";     
        $core["home"]["text2"]["section_pos"] = "";     
        $core["home"]["text2"]["section_w"] = "container";     
        $core["home"]["text2"]["section_pattern"] = "";     
        $core["home"]["text2"]["title_show"] = "yes";     
        $core["home"]["text2"]["title"] = "Welcome to <i class='fal fa-hand-pointer ml-2 text-primary'>&nbsp;</i> <span class='font-weight-bold text-primary'>Auction</span>House";     
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
 
        /* cta1 */    
        $core["home"]["cta1"]["section_padding"] = "section-40";     
        $core["home"]["cta1"]["section_bg"] = "bg-primary";     
        $core["home"]["cta1"]["section_pos"] = "";     
        $core["home"]["cta1"]["section_w"] = "container";     
        $core["home"]["cta1"]["section_pattern"] = "";     
        $core["home"]["cta1"]["title_show"] = "yes";     
        $core["home"]["cta1"]["title"] = "Sell your old stuff today!";     
        $core["home"]["cta1"]["subtitle"] = "";     
        $core["home"]["cta1"]["desc"] = "";     
        $core["home"]["cta1"]["title_style"] = "1";     
        $core["home"]["cta1"]["title_pos"] = "left";     
        $core["home"]["cta1"]["title_heading"] = "h2";     
        $core["home"]["cta1"]["title_margin"] = "mb-0";     
        $core["home"]["cta1"]["subtitle_margin"] = "mb-4";     
        $core["home"]["cta1"]["desc_margin"] = "mb-4";     
        $core["home"]["cta1"]["title_txtcolor"] = "white";     
        $core["home"]["cta1"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["cta1"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["cta1"]["title_font"] = "";     
        $core["home"]["cta1"]["subtitle_font"] = "";     
        $core["home"]["cta1"]["desc_font"] = "";     
        $core["home"]["cta1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["cta1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["cta1"]["btn_show"] = "yes";     
        $core["home"]["cta1"]["btn_link"] = "[link-add]";     
        $core["home"]["cta1"]["btn_txt"] = "add auction";     
        $core["home"]["cta1"]["btn_bg"] = "light";     
        $core["home"]["cta1"]["btn_bg_txt"] = "";     
        $core["home"]["cta1"]["btn_icon"] = "fas fa-long-arrow-alt-right";     
        $core["home"]["cta1"]["btn_icon_pos"] = "after";     
        $core["home"]["cta1"]["btn_size"] = "btn-xl";     
        $core["home"]["cta1"]["btn_margin"] = "mt-0";     
        $core["home"]["cta1"]["btn_style"] = "3";     
        $core["home"]["cta1"]["btn_font"] = ""; 		
 
        /* listings2 */    
        $core["home"]["listings2"]["section_padding"] = "section-80";     
        $core["home"]["listings2"]["section_bg"] = "bg-white";     
        $core["home"]["listings2"]["section_pos"] = "";     
        $core["home"]["listings2"]["section_w"] = "container";     
        $core["home"]["listings2"]["section_pattern"] = "";     
        $core["home"]["listings2"]["title_show"] = "yes";     
        $core["home"]["listings2"]["title"] = "FEATURED <i class='fal fa-star mx-2 text-primary'></i> Auctions";     
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
        $core["home"]["listings2"]["datastring"] = " dataonly='1' cat='' show='12' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings2"]["perrow"] = "4";     
        $core["home"]["listings2"]["card"] = "blank";     
        $core["home"]["listings2"]["limit"] = "12"; 		
 
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
        $core["home"]["subscribe2"]["image_subscribe"] = _ppt_demopath()."/style1/hero3.jpg"; 		
 
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