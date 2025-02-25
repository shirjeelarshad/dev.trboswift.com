<?php
 
add_filter( 'ppt_admin_layouts',  array('at_yard4',  'data') );
add_filter( 'at_yard4',  array('at_yard4',  'load') );
 
class at_yard4 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['at_yard4'] = array(
		
			"key" => "at_yard4",
		
			"name" 	=> "Yard Sale 4",
			"image"	=> _ppt_demopath()."/designs/yard4.jpg",
						
			"theme"	=> "at_yard",
			 
			
			"order" => 2,
			
			"elementor" => array( 
		
				"homepage" => __DIR__ ."/elementor-yard4-homepage.json",
				"contact" => __DIR__ ."/elementor-yard-contact.json",
				
			),
			
			
			"menu-simple" => true,
 	 		
		);		
		
		return $a;
	
	} 
	
	
	
	public static  function load($core){ global $CORE; 
	
	// TURN OFF FAVS SYSTEM
	$core['user']['favs'] = 0;	
	
	/* SEARCH PAGE LAYOUT */
	$core['design']['search_layout'] = "3";
	
	/* SINGLE PAGE LAYOUT */
	$core['design']['single_layout'] = "6";	
	
	/* font */
	$core['design']['font_body'] = "";
	$core['design']['font_h1'] = "Playfair";
	$core['design']['font_h2'] = "Playfair";
	
	
	
 
		/* logo */
		$core['design']['logo_url_aid'] = "";
		$core['design']['logo_url'] = "";
		$core['design']['light_logo_url_aid'] = "";
		$core['design']['light_logo_url'] = "";
		$core['design']['textlogo'] = "<i class='fal fa-piggy-bank ml-2'></i> <span class='text-primary font-weight-bold'>Yard</span> Sale";  
	
		$core['design']['header_style'] = "header17";
		$core['design']['footer_style'] = "footer2";
		
		
		$core['design']['slot1_style'] = "elementor";
		$core['design']['slot2_style'] = "";
		$core['design']['slot3_style'] = "";
		$core['design']['slot4_style'] = "";		
		$core['design']['slot5_style'] = '';
		$core['design']['slot6_style'] = '';
		$core['design']['slot7_style'] = '';
		$core['design']['slot8_style'] = '';
		$core['design']['slot9_style'] = '';
		
		$core['design']['color_primary'] = "#F0AB00";
		$core['design']['color_secondary'] = "#111111"; 
		$core['design']['color_bglight'] = "#ffffff"; 
		
 
        /* header17 */    
        $core["header"]["header17"]["section_padding"] = "section-100";     
        $core["header"]["header17"]["section_bg"] = "bg-white";     
        $core["header"]["header17"]["section_pos"] = "";     
        $core["header"]["header17"]["section_w"] = "container";     
        $core["header"]["header17"]["section_pattern"] = "";     
        $core["header"]["header17"]["btn_show"] = "no";     
        $core["header"]["header17"]["topmenu_show"] = "";     
        $core["header"]["header17"]["extra_show"] = "";     
        $core["header"]["header17"]["extra_type"] = "";  
      
 
        /* footer1 */    
        $core["footer"]["footer2"]["section_padding"] = "section-60";     
        $core["footer"]["footer2"]["section_bg"] = "bg-white";     
        $core["footer"]["footer2"]["section_pos"] = "";     
        $core["footer"]["footer2"]["section_w"] = "container-fluid";     
        $core["footer"]["footer2"]["section_pattern"] = ""; 

		// DEFAULT INNER PAGE DAATA
		$core = $CORE->LAYOUT("default_innerpages", $core);
 	 
		$i=1;		
		while($i < 21){	
		
			$core['sampledata'][$i] = array(		 
					
					"title" => "Example Product ".$i,	
					
					"image" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg", 
					"thumb" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg",			 
					 
						"images" => array(
					
						1 => array(
							"image" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg", 
							"thumb" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg",
						),
						2 => array(
							"image" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg", 
							"thumb" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg",
						),
						3 => array(
							"image" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg", 
							"thumb" => DEMO_IMG_PATH."ct/products/kitchen/".$i.".jpg",
						),	 					
						
					),
			); 
					
			$i++;	
		}

			
	return $core;
	}
	
	
}

?>