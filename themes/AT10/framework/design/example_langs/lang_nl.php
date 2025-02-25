<?php
 
add_filter( 'ppt_admin_layouts',  array('lang_nl',  'data') );
add_filter( 'lang_nl',  array('lang_nl',  'load') );
 
class lang_nl {

	function __constfrct(){} 

	public static function data($a){ 
	 
		global $CORE;
  
		$a['lang_nl'] = array(
		
			"key" => "lang_nl",
		
			"name" 	=> "Dutch",
			"image"	=> DEMO_IMG_PATH."/example_langs/nl0.jpg",
						
			"theme"	=> "lang",
			
			"lang"	=> "nl_NL",
			 
			 
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
	$core['design']['textlogo'] = "<i class='fal fa-globe-europe ml-2 text-primary'>&nbsp;</i> <span class='font-weight-bold text-primary'>My</span> Website";  
 
	
$core['design']['header_style'] = "header7";
$core['design']['slot1_style'] = "hero_text1";
$core['design']['slot2_style'] = "text1";
$core['design']['slot3_style'] = "cta1a";
$core['design']['slot4_style'] = "listings7";
$core['design']['slot5_style'] = "subscribe2";
$core['design']['footer_style'] = "footer1";
$core['design']['slot6_style'] = '';
$core['design']['slot7_style'] = '';
$core['design']['slot8_style'] = '';
$core['design']['slot9_style'] = '';
$core['design']['color_primary'] = "#0F59BA";
$core['design']['color_secondary'] = "#fdb819";
 
 
        /* header7 */    
        $core["header"]["header7"]["section_padding"] = "section-80";     
        $core["header"]["header7"]["section_bg"] = "bg-white";     
        $core["header"]["header7"]["section_pos"] = "";     
        $core["header"]["header7"]["section_w"] = "container";     
        $core["header"]["header7"]["section_pattern"] = "";     
        $core["header"]["header7"]["btn_show"] = "yes";     
        $core["header"]["header7"]["btn_link"] = "[link-add]";     
        $core["header"]["header7"]["btn_txt"] = "POST AD";     
        $core["header"]["header7"]["btn_bg"] = "primary";     
        $core["header"]["header7"]["btn_bg_txt"] = "text-light";     
        $core["header"]["header7"]["btn_icon"] = "fas fa-angle-double-right";     
        $core["header"]["header7"]["btn_icon_pos"] = "after";     
        $core["header"]["header7"]["btn_size"] = "btn-md";     
        $core["header"]["header7"]["btn_margin"] = "mt-0";     
        $core["header"]["header7"]["btn_style"] = "3";     
        $core["header"]["header7"]["btn_font"] = "";     
        $core["header"]["header7"]["topmenu_show"] = "yes";     
        $core["header"]["header7"]["extra_show"] = "yes";     
        $core["header"]["header7"]["extra_type"] = ""; 		
 
        /* hero_text1 */    
        $core["home"]["hero_text1"]["section_padding"] = "section-80";     
        $core["home"]["hero_text1"]["section_bg"] = "bg-primary";     
        $core["home"]["hero_text1"]["section_pos"] = "";     
        $core["home"]["hero_text1"]["section_w"] = "container";     
        $core["home"]["hero_text1"]["section_pattern"] = "2";     
        $core["home"]["hero_text1"]["title_show"] = "yes";     
        $core["home"]["hero_text1"]["title"] = "Welkom op onze <br> nieuwe website!";     
        $core["home"]["hero_text1"]["subtitle"] = "Dit is een voorbeeldindeling.";     
        $core["home"]["hero_text1"]["desc"] = "";     
        $core["home"]["hero_text1"]["title_style"] = "1";     
        $core["home"]["hero_text1"]["title_pos"] = "left";     
        $core["home"]["hero_text1"]["title_heading"] = "h1";     
        $core["home"]["hero_text1"]["title_margin"] = "mb-3";     
        $core["home"]["hero_text1"]["subtitle_margin"] = "mb-5";     
        $core["home"]["hero_text1"]["desc_margin"] = "mb-5";     
        $core["home"]["hero_text1"]["title_txtcolor"] = "dark";     
        $core["home"]["hero_text1"]["subtitle_txtcolor"] = "secondary";     
        $core["home"]["hero_text1"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["hero_text1"]["title_font"] = "";     
        $core["home"]["hero_text1"]["subtitle_font"] = "";     
        $core["home"]["hero_text1"]["desc_font"] = "";     
        $core["home"]["hero_text1"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["hero_text1"]["btn_show"] = "yes";     
        $core["home"]["hero_text1"]["btn_link"] = "[link-search]";     
        $core["home"]["hero_text1"]["btn_txt"] = "Website doorzoeken";     
        $core["home"]["hero_text1"]["btn_bg"] = "primary";     
        $core["home"]["hero_text1"]["btn_bg_txt"] = "text-light";     
        $core["home"]["hero_text1"]["btn_icon"] = "fas fa-long-arrow-alt-right";     
        $core["home"]["hero_text1"]["btn_icon_pos"] = "after";     
        $core["home"]["hero_text1"]["btn_size"] = "btn-xl";     
        $core["home"]["hero_text1"]["btn_margin"] = "mt-0";     
        $core["home"]["hero_text1"]["btn_style"] = "1";     
        $core["home"]["hero_text1"]["btn_font"] = "";     
        $core["home"]["hero_text1"]["btn2_show"] = "no";     
        $core["home"]["hero_text1"]["hero_image"] = "";     
        $core["home"]["hero_text1"]["hero_size"] = "hero-medium";     
        $core["home"]["hero_text1"]["hero_txtcolor"] = "light"; 	
		$core["home"]["hero_text1"]["hero_image"] = DEMO_IMG_PATH."/example_langs/hero_nl.jpg";  	
 
        /* text1 */    
        $core["home"]["text1"]["section_padding"] = "section-100";     
        $core["home"]["text1"]["section_bg"] = "bg-white";     
        $core["home"]["text1"]["section_pos"] = "";     
        $core["home"]["text1"]["section_w"] = "container";     
        $core["home"]["text1"]["section_pattern"] = "";     
        $core["home"]["text1"]["title_show"] = "yes";     
        $core["home"]["text1"]["title"] = "Welkom op onze website!";     
        $core["home"]["text1"]["subtitle"] = "We hebben precies wat je zoekt!";     
        $core["home"]["text1"]["desc"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";   
		$core["home"]["text1"]["text_image1"] = DEMO_IMG_PATH."/example_langs/nl1.jpg";   
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
        $core["home"]["text1"]["btn_txt"] = "Website doorzoeken";     
        $core["home"]["text1"]["btn_bg"] = "primary";     
        $core["home"]["text1"]["btn_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn_icon"] = "";     
        $core["home"]["text1"]["btn_icon_pos"] = "before";     
        $core["home"]["text1"]["btn_size"] = "btn-lg";     
        $core["home"]["text1"]["btn_margin"] = "mt-0";     
        $core["home"]["text1"]["btn_style"] = "1";     
        $core["home"]["text1"]["btn_font"] = "";     
        $core["home"]["text1"]["btn2_show"] = "yes";     
        $core["home"]["text1"]["btn2_link"] = "[link-login]";     
        $core["home"]["text1"]["btn2_txt"] = "Inloggen voor Leden";     
        $core["home"]["text1"]["btn2_bg"] = "primary";     
        $core["home"]["text1"]["btn2_bg_txt"] = "text-light";     
        $core["home"]["text1"]["btn2_icon"] = "";     
        $core["home"]["text1"]["btn2_icon_pos"] = "before";     
        $core["home"]["text1"]["btn2_size"] = "btn-lg";     
        $core["home"]["text1"]["btn2_margin"] = "mt-0";     
        $core["home"]["text1"]["btn2_style"] = "1";     
        $core["home"]["text1"]["btn2_font"] = ""; 		
 
        /* cta1a */    
        $core["home"]["cta1a"]["section_padding"] = "section-40";     
        $core["home"]["cta1a"]["section_bg"] = "bg-secondary";     
        $core["home"]["cta1a"]["section_pos"] = "";     
        $core["home"]["cta1a"]["section_w"] = "container";     
        $core["home"]["cta1a"]["section_pattern"] = "2";     
        $core["home"]["cta1a"]["title_show"] = "yes";     
        $core["home"]["cta1a"]["title"] = "Welkom op onze website!";     
        $core["home"]["cta1a"]["subtitle"] = "";     
        $core["home"]["cta1a"]["desc"] = "";     
        $core["home"]["cta1a"]["title_style"] = "1";     
        $core["home"]["cta1a"]["title_pos"] = "left";     
        $core["home"]["cta1a"]["title_heading"] = "h2";     
        $core["home"]["cta1a"]["title_margin"] = "mb-0";     
        $core["home"]["cta1a"]["subtitle_margin"] = "mb-0";     
        $core["home"]["cta1a"]["desc_margin"] = "mb-4";     
        $core["home"]["cta1a"]["title_txtcolor"] = "light";     
        $core["home"]["cta1a"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["cta1a"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["cta1a"]["title_font"] = "";     
        $core["home"]["cta1a"]["subtitle_font"] = "";     
        $core["home"]["cta1a"]["desc_font"] = "";     
        $core["home"]["cta1a"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["cta1a"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["cta1a"]["btn_show"] = "yes";     
        $core["home"]["cta1a"]["btn_link"] = "[link-search]";     
        $core["home"]["cta1a"]["btn_txt"] = "Website doorzoeken";     
        $core["home"]["cta1a"]["btn_bg"] = "primary";     
        $core["home"]["cta1a"]["btn_bg_txt"] = "";     
        $core["home"]["cta1a"]["btn_icon"] = "";     
        $core["home"]["cta1a"]["btn_icon_pos"] = "before";     
        $core["home"]["cta1a"]["btn_size"] = "btn-xl";     
        $core["home"]["cta1a"]["btn_margin"] = "mt-0";     
        $core["home"]["cta1a"]["btn_style"] = "1";     
        $core["home"]["cta1a"]["btn_font"] = ""; 		
 
        /* listings7 */    
        $core["home"]["listings7"]["section_padding"] = "section-80";     
        $core["home"]["listings7"]["section_bg"] = "bg-white";     
        $core["home"]["listings7"]["section_pos"] = "";     
        $core["home"]["listings7"]["section_w"] = "container";     
        $core["home"]["listings7"]["section_pattern"] = "";     
        $core["home"]["listings7"]["title_show"] = "no";     
        $core["home"]["listings7"]["datastring"] = " dataonly='1' cat='' show='' custom='new' customvalue='' order='desc' orderby='date' debug='0' ";     
        $core["home"]["listings7"]["perrow"] = "4";     
        $core["home"]["listings7"]["card"] = "info";     
        $core["home"]["listings7"]["limit"] = "";     
        $core["home"]["listings7"]["custom"] = "new"; 		
 
        /* subscribe2 */    
        $core["home"]["subscribe2"]["section_padding"] = "section-80";     
        $core["home"]["subscribe2"]["section_bg"] = "bg-white";     
        $core["home"]["subscribe2"]["section_pos"] = "";     
        $core["home"]["subscribe2"]["section_w"] = "container";     
        $core["home"]["subscribe2"]["section_pattern"] = "";     
        $core["home"]["subscribe2"]["title_show"] = "yes";     
        $core["home"]["subscribe2"]["title"] = "WORD LID VAN DE NIEUWSBRIEF";     
        $core["home"]["subscribe2"]["subtitle"] = "BLIJF UPDATE MET HET LAATSTE NIEUWS";     
        $core["home"]["subscribe2"]["desc"] = "";     
        $core["home"]["subscribe2"]["title_style"] = "1";     
        $core["home"]["subscribe2"]["title_pos"] = "left";     
        $core["home"]["subscribe2"]["title_heading"] = "h2";     
        $core["home"]["subscribe2"]["title_margin"] = "mb-4";     
        $core["home"]["subscribe2"]["subtitle_margin"] = "mb-4";     
        $core["home"]["subscribe2"]["desc_margin"] = "mb-4";     
        $core["home"]["subscribe2"]["title_txtcolor"] = "dark";     
        $core["home"]["subscribe2"]["subtitle_txtcolor"] = "dark";     
        $core["home"]["subscribe2"]["desc_txtcolor"] = "opacity-5";     
        $core["home"]["subscribe2"]["title_font"] = "";     
        $core["home"]["subscribe2"]["subtitle_font"] = "";     
        $core["home"]["subscribe2"]["desc_font"] = "";     
        $core["home"]["subscribe2"]["title_txtw"] = "font-weight-bold";     
        $core["home"]["subscribe2"]["subtitle_txtw"] = "font-weight-bold";     
        $core["home"]["subscribe2"]["image_subscribe"] = DEMO_IMG_PATH."/example_langs/nl2.jpg";  		
 
        /* footer1 */    
        $core["footer"]["footer1"]["section_padding"] = "section-60";     
        $core["footer"]["footer1"]["section_bg"] = "bg-light";     
        $core["footer"]["footer1"]["section_pos"] = "";     
        $core["footer"]["footer1"]["section_w"] = "container-fluid";     
        $core["footer"]["footer1"]["section_pattern"] = "";  

 
		// DEFAULT INNER PAGE DAATA
		$core = $CORE->LAYOUT("default_innerpages", $core);
 	
			
	return $core;
	}
	
	
}

?>