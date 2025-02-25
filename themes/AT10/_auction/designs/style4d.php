<?php
 
add_filter( 'ppt_admin_layouts',  array('at_style4d',  'data') );
add_filter( 'at_style4d',  array('at_style4d',  'load') );
 
class at_style4d {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['at_style4d'] = array(
		
			"key" => "at_style4d",
		
			"name" 	=> "Style 4",
			"image"	=> _ppt_demopath()."/designs/style4d.jpg",
						
			"theme"	=> "at_style4",
			
			
			"color_p" 	=> "#D8AE5B",
			"color_s" 	=> "#111111",
			
			"order" => 0
 	 		
		);		
		
		return $a;
	
	} 
	
	
	
	public static  function load($core){ global $CORE; 
 
 
 //
 
 
 
 /* fonts */
$core['design']['font_body'] = "";
$core['design']['font_logo'] = "";

//$core['design']['font_h1'] = "Barlow";
//$core['design']['font_h2'] = "Barlow";
	
 
	/* logo */
	$core['design']['logo_url_aid'] = "";
	$core['design']['logo_url'] = "";
	$core['design']['light_logo_url_aid'] = "";
	$core['design']['light_logo_url'] = "";
	$core['design']['textlogo'] = "<i class='fal fa-paint-brush text-primary'>&nbsp;</i><span class='font-weight-bold text-uppercase'>Art Auctions</span>";    
	$core['design']['color_bg'] = "";
	$core['design']['color_text'] = "";
	
$core['design']['header_style'] = "header4";
$core['design']['slot1_style'] = "hero_map1";
$core['design']['slot2_style'] = "listings2";
$core['design']['slot3_style'] = "testimonials3a";
$core['design']['footer_style'] = "footer1";
$core['design']['slot4_style'] = '';
$core['design']['slot5_style'] = '';
$core['design']['slot6_style'] = '';
$core['design']['slot7_style'] = '';
$core['design']['slot8_style'] = '';
$core['design']['slot9_style'] = '';
$core['design']['color_primary'] = "#003884";
$core['design']['color_secondary'] = "#FF6600";
 
 
        /* header4 */    
        $core["header"]["header4"]["section_padding"] = "section-80";     
        $core["header"]["header4"]["section_bg"] = "bg-white";     
        $core["header"]["header4"]["section_pos"] = "";     
        $core["header"]["header4"]["section_w"] = "container";     
        $core["header"]["header4"]["section_pattern"] = "";     
        $core["header"]["header4"]["btn_show"] = "yes";     
        $core["header"]["header4"]["btn_link"] = "[link-add]";     
        $core["header"]["header4"]["btn_txt"] = "Add Auction";     
        $core["header"]["header4"]["btn_bg"] = "secondary";     
        $core["header"]["header4"]["btn_bg_txt"] = "text-light";     
        $core["header"]["header4"]["btn_icon"] = "";     
        $core["header"]["header4"]["btn_icon_pos"] = "before";     
        $core["header"]["header4"]["btn_size"] = "btn-md";     
        $core["header"]["header4"]["btn_margin"] = "mt-0";     
        $core["header"]["header4"]["btn_style"] = "1";     
        $core["header"]["header4"]["btn_font"] = "";     
        $core["header"]["header4"]["topmenu_show"] = "yes";     
        $core["header"]["header4"]["extra_show"] = "yes"; 		

 
        /* hero_map1 */    
        $core["home"]["hero_map1"]["section_padding"] = "section-80";     
        $core["home"]["hero_map1"]["section_bg"] = "bg-light";     
        $core["home"]["hero_map1"]["section_pos"] = "";     
        $core["home"]["hero_map1"]["section_w"] = "container";     
        $core["home"]["hero_map1"]["section_pattern"] = "";     
        $core["home"]["hero_map1"]["title_show"] = "no";     
        $core["home"]["hero_map1"]["hero_image"] = "";     
        $core["home"]["hero_map1"]["hero_size"] = "hero-medium";     
        $core["home"]["hero_map1"]["hero_txtcolor"] = "light"; 		
 
        /* listings2 */    
        $core["home"]["listings2"]["section_padding"] = "section-80";     
        $core["home"]["listings2"]["section_bg"] = "bg-white";     
        $core["home"]["listings2"]["section_pos"] = "";     
        $core["home"]["listings2"]["section_w"] = "container";     
        $core["home"]["listings2"]["section_pattern"] = "";     
        $core["home"]["listings2"]["title_show"] = "yes";     
        $core["home"]["listings2"]["title"] = "FEATURED <i class='fal fa-paint-brush mx-2 text-primary'></i> PAINTINGS";     
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
        $core["home"]["listings2"]["card"] = "list-small";     
        $core["home"]["listings2"]["limit"] = "12"; 		
 
        /* testimonials3a */    
        $core["home"]["testimonials3a"]["section_padding"] = "section-40";     
        $core["home"]["testimonials3a"]["section_bg"] = "bg-light";     
        $core["home"]["testimonials3a"]["section_pos"] = "";     
        $core["home"]["testimonials3a"]["section_w"] = "container";     
        $core["home"]["testimonials3a"]["section_pattern"] = "";     
        $core["home"]["testimonials3a"]["title_show"] = "no"; 		
 
        /* footer1 */    
        $core["footer"]["footer1"]["section_padding"] = "section-60";     
        $core["footer"]["footer1"]["section_bg"] = "bg-dark";     
        $core["footer"]["footer1"]["section_pos"] = "";     
        $core["footer"]["footer1"]["section_w"] = "container-fluid";     
        $core["footer"]["footer1"]["section_pattern"] = ""; 		


		// DEFAULT INNER PAGE DAATA
		$core = $CORE->LAYOUT("default_innerpages", $core);
		
		// SAMPLE DATA		
		$i=1;		
		while($i < 21){	
		
			$core['sampledata'][$i] = array(		 
					
					"title" => "Example Painting ".$i,	
					
					"image" => _ppt_demopath()."/products/art/".$i.".jpg", 
					"thumb" => _ppt_demopath()."/products/art/".$i.".jpg",			 
					 
									 
				);
		$i++;	
		}  	
			
	return $core;
	}
	
	
}

?>