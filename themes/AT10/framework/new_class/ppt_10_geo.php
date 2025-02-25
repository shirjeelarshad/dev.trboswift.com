<?php


class framework_geo extends framework_ajax {


function GEO($action='add', $order_data){
 

global $userdata, $wpdb, $CORE;
 
	switch($action){ 
	
		case "price_formatting": {
		 	
			$css = "format-".strtolower($this->_currency_current());
			
			if(_ppt(array('currency','position')) == "right"){
				
				$css .= " format-right";
			 
			}
		 
			
			// NON DEFAULT CURRENCIES 
			if($CORE->GEO("get_currency_icon", $this->_currency_current() ) == "fal fa-globe"){
			
				if($order_data == "js"){
				
				return $css." format-customsymbol' data-symbol='".$this->_currency_symbol()."'";
				
				}else{
				
				return $css.' format-customsymbol" data-symbol="'.$this->_currency_symbol();
				
				}
				
			}else{
			
			return $css;
			}	
			
			
			
		
		} break;
	
		case "maps_google_link": {
		
			$region = "us"; $lang = "en"; $extra = "";
	 
			//if(isset($GLOBALS['flag-add']) || isset($GLOBALS['flag-googleplaces'])){
			$extra = "&v=3.exp&libraries=places";
			//}
			//$order_data
			
			return 'https://maps.googleapis.com/maps/api/js?language='.$lang.'&amp;region='.$region.$extra."&key=".trim(stripslashes(_ppt(array('maps','apikey'))));

		
		} break;


		case "translate_field_help": {
		
				if(!is_array($order_data)){ return $order_data; }
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				$data 		= $order_data[2];
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(isset($data['help_'.strtolower($cl)][$key]) && $data['help_'.strtolower($cl)][$key]  != ""){
						$default = $data['help_'.strtolower($cl)][$key];
					}				
				}				
				
				return $default;
		
		} break;
				
		
		case "translate_field_name": {
		
				if(!is_array($order_data)){ return $order_data; }
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				$data 		= $order_data[2];
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(isset($data['name_'.strtolower($cl)][$key]) && $data['name_'.strtolower($cl)][$key]  != ""){
						$default = $data['name_'.strtolower($cl)][$key];
					}				
				}				
				
				return $default;
		
		} break;
		
		
		case "translate_mem_fea_name": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				$key1 		= $order_data[2];
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('mem'.$key.'_txt'.$key1.'_'.strtolower($cl)) != ""){
						$default = _ppt('mem'.$key.'_txt'.$key1.'_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;
		
		
		case "translate_pak_fea_name": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				$key1 		= $order_data[2];
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('pak'.$key.'_txt'.$key1.'_'.strtolower($cl)) != ""){
						$default = _ppt('pak'.$key.'_txt'.$key1.'_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;
				
		case "translate_pak_name": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('pak'.$key.'_name_'.strtolower($cl)) != ""){
						$default = _ppt('pak'.$key.'_name_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;
		
		
		case "translate_pak_desc": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('pak'.$key.'_desc_'.strtolower($cl)) != ""){
						$default = _ppt('pak'.$key.'_desc_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;	
		
		
		case "translate_mem_name": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('mem'.$key.'_name_'.strtolower($cl)) != ""){
						$default = _ppt('mem'.$key.'_name_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;
		
		
		case "translate_mem_desc": {
		
				$default 	= $order_data[0];
				$key 		= $order_data[1];				
				
				if(_ppt(array('lang','switch')) == 1){
				
					$cl = $CORE->_language_current();
					if(_ppt('mem'.$key.'_desc_'.strtolower($cl)) != ""){
						$default = _ppt('mem'.$key.'_desc_'.strtolower($cl));
					}				
				}				
				
				return $default;
		
		} break;
		
		
		case "translation_tax_key": {
		
		  	
			$cleaned = str_replace(" ","-",$order_data);			 
			$lang = strtolower($this->_language_current());
				
			$text = _ppt(array('taxcaption_'.$lang, $cleaned)); 
			if($text != "" && $text != $cleaned ){
				
				return _ppt(array('taxcaption_'.$lang, $cleaned));					
			}
			
			$text = _ppt(array('taxcaption', $cleaned));			
			
			if($text != "" && $text != $cleaned ){
				
				return  _ppt(array('taxcaption', $cleaned));
					
			} 
			
			
			$nd = _ppt_custom_text($order_data, $matchkey = false);
			
			if($nd != ""){
				return $nd;
			}
			
			// DEFAULT			 			
			return $order_data;		
			 
		
		} break;	
		
		case "translation_tax_data": {
		
			$tax = $order_data[0];
			$pid = $order_data[1];		
			
			$t = "";	 
				
			$cl = $CORE->_language_current();
			 
			if(_ppt(array('lang','switch')) == 1 && $cl != "en_US"){
			
			$cats = get_the_terms( $pid, $tax);
			
				if(isset($cats[0])){
				 
					$t = $CORE->GEO("translation_tax", array($cats[0]->term_id, $cats[0]->name));		 
					
				}else{
				
					$t = get_the_term_list( $post->ID, $tax, "", ', ', '' );
				}				
			
			}else{
			
				$t = get_the_term_list( $pid, $tax, "", ', ', '' );
			
			} 			
			 
			return $t;
			 
		
		} break;
	 	
		
		case "translation_tax_with_termdata": {
			
			if(is_array(_ppt('languages')) && !empty(_ppt('languages')) ){ 
			 
			 	$catTrans = _ppt('category_translation');
				
				$lang = strtolower($this->_language_current());
				 
				if(isset($catTrans[$lang]) && isset($catTrans[$lang][$order_data->term_id]) && strlen($catTrans[$lang][$order_data->term_id])  > 1 ){ 
				
					return $catTrans[strtolower($lang)][$order_data->term_id]; 
				
				}
			
			}
		
			if(isset($order_data->name)){
			
				return $order_data->name;
			
			}
		
		} break;
		
		case "translation_tax_desc_with_termdata": {
			
			if(is_array(_ppt('languages')) && !empty(_ppt('languages')) ){ 
			 
			 	$catTrans = _ppt('category_translation');
				
				$lang = strtolower($this->_language_current());
				 
				if(isset($catTrans[$lang]) && isset($catTrans[$lang][$order_data->term_id."_desc"]) && strlen($catTrans[$lang][$order_data->term_id."_desc"])  > 1 ){ 
				
					return $catTrans[strtolower($lang)][$order_data->term_id."_desc"]; 
				
				}
			
			}
		
			if(isset($order_data->description)){
			
				return $order_data->description;
			
			}
		
		} break;		
		
	
		case "translation_tax_value": 
		case "translation_tax": {
		  
			if(is_array(_ppt('languages')) && !empty(_ppt('languages')) ){ 
			 
			 	$catTrans = _ppt('category_translation');
				
				$lang = strtolower($this->_language_current());
				 	 
				if(isset($catTrans[$lang]) && isset($catTrans[$lang][$order_data[0]]) && strlen($catTrans[$lang][$order_data[0]])  > 1 ){ 
				
					return $catTrans[strtolower($lang)][$order_data[0]]; 
				
				}else{
					
					return $order_data[1];
				
				}			
			
			}else{
			 
				return $order_data[1];
			
			}
		
		
		} break;
		
		case "is_right_to_left": {
		
			$l = get_locale();
			 
			
			// 1. CHECK LANGUAGE SWITCH
			if(!isset($_SESSION['language']) || isset($_SESSION['language']) && empty($_SESSION['language']) ){										 
				
				if(in_array($l,array("ar","az"))){
					
					return 1;				
				} 				
			
			} 
			
			
			// CHECK DEFAULT LANGUAGE SET IN THE ADMIN
			if(is_array(_ppt('languages')) && !empty(_ppt('languages')) ){ 
			  
				$lang = strtolower($this->_language_current());
			 	
				if(in_array($lang, array("ar"))){
				
					return 1;
				
				}else{
				
					return 0;
				}
				
			}
			
			// CHECK WORDPRESS LANGUAGE			
			$l = get_locale();
			if(in_array($l,array("ar","az"))){
					
				return 1;				
			} 
			
			return 0;
		
		
		} break;
	
		case "get_language_icon": {
		
			$dl = $this->_language_current(1);
			
			$icon = explode("_",$dl);
			
			 
			if(isset($icon[1])){ 
			
				if(strtolower($icon[1]) == "en"){ $icon[1] = "us"; }
				if(strtolower($icon[1]) == "ko"){ $icon[1] = "kr"; }
				if(strtolower($icon[1]) == "jp"){ $icon[1] = "ja"; }
				 
			return strtolower($icon[1]); }else{ return $icon[0]; }  

		} break;
		
		case "fix_demo": {
			
			
				if(strtolower($order_data) == "us"){ $order_data = "en"; }
				if(strtolower($order_data) == "ja"){ $order_data = "jp"; }
				if(strtolower($order_data) == "kr"){ $order_data = "ko"; }
				
				return $order_data;
		
		} break;
	
		case "get_languagelist": {
		
		// ON/OFF
		if(_ppt(array('lang','switch')) != 1  ){ return; }
		 
		
		// BUILD ARRAY
		$clist = array(); 
 		foreach(_ppt('languages') as $k => $lang){ 
			
			// icon
			$icon = explode("_",$lang);			
			if(isset($icon[1])){ $icon1 = "flag flag-".strtolower($icon[1]); }else{ $icon1 = "flag flag-".$icon[0]; }  
		 			 
			
			if(defined('WLT_DEMOMODE')){
			
				if(isset($icon[1])){
					 
					$icon[1] = $this->GEO("fix_demo", $icon[1]);				
					$link = home_url()."/?design=lang_".strtolower($icon[1])."&l=".$lang;
					
				}else{
					$icon[0] = $this->GEO("fix_demo", $icon[0]);
					$link = home_url()."/?design=lang_".strtolower($icon[0])."&l=".$lang;
				}
					
			}else{
				$link = home_url()."/?l=".$lang;
			}
				
					
			// array
			$clist[$k] = array(						
					"name" 		=> $this->GEO("get_lang_name", $lang),
					"icon" 		=> $icon1,
					"link" 		=> $link,
			);
		}
			
		return $clist;
	 
		
		} break;
		
		case "get_currency_icon": {
			
			$cicons  = array(
				
				"EUR" => "fal fa-euro-sign",
				"GBP" => "fal fa-pound-sign",
				"RUB" => "fal fa-ruble-sign",
				"USD" => "fal fa-dollar-sign",
				"CAD" => "fal fa-dollar-sign",
				"AUD" => "fal fa-dollar-sign",
				"JPY" => "fal fa-yen-sign",
				"RMB" => "fal fa-yen-sign",
				
				"INR" => "fal fa-rupee-sign",
				"RUB" => "fal fa-ruble-sign",
				"TRY" => "fal fa-lira-sign",	
				"PTS" => "&#8359;",	
				"BTC" => "fab fa-bitcoin",		
				
						
			);
			
			$dl = $this->_currency_current();
			 
			if(is_array($order_data) && empty($order_data) && isset($cicons[$dl]) ){
				 
				return $cicons[$dl];
			
			}elseif(!is_array($order_data) && isset($cicons[$order_data])){
			
				return $cicons[$order_data];
			}
			
			return "fal fa-globe";
			
			 

		} break;
	
		case "get_currencylist": {
		
		
		if(_ppt(array('currency','switch')) != 1 ){ return; }
		 
		
		if(isset($GLOBALS['set-currency'])){ return;}
		$GLOBALS['set-currency'] = 1;
	 
			// MAKE SURE ITS SET
			if(!isset($GLOBALS['shop_currency']) || (isset($GLOBALS['shop_currency']) && empty($GLOBALS['shop_currency']) ) ){ return; }
			
				// SETUP DEFAULTS
				if(!isset($_SESSION['currency']['code']) || (isset($_SESSION['currency']['code']) && $_SESSION['currency']['code'] == "" ) ){ 
				
					$_SESSION['currency']['code'] 	= $GLOBALS['CORE_THEME']['currency']['code']; 
					$_SESSION['currency']['symbol'] = hook_currency_symbol('');  
					$_SESSION['currency']['rate'] = 0; 		
			 
				} 
				 
			
			global $wp;
			$currentpage = home_url( add_query_arg( array(), $wp->request ) );	 
			$clist = array();
			if(is_array($GLOBALS['shop_currency'])){  
				foreach($GLOBALS['shop_currency'] as $v){	
				
				if(strlen($v['code']) < 3){ continue; }			
				 	
					$clist[] = array(						
						"name" 		=> $v['code'],
						"icon" 		=> $CORE->GEO("get_currency_icon", $v['code'] ),
						"link" 		=> $currentpage."/?c=".$v['code'],
					);
				}
			}
		 
			
			return $clist;
	 
		
		} break;
	
		case "get_lang_name": {
		 
			$lang_array = array(			
				 "en_US" => array("name" => __("English","premiumpress") ),
				 "es_ES" => array("name" => __("Spanish","premiumpress")),
				 "fr_FR" => array("name" => __("French","premiumpress")),
				 "zh_CN" => array("name" => __("Chinese","premiumpress")),
				 "de_DE" => array("name" => __("German","premiumpress")),
				 "ru_RU" => array("name" => __("Russian","premiumpress")),
				 "ar" 	=> array("name" => __("Arabic","premiumpress")),
				 "ja" 	=> array("name" => __("Japanese","premiumpress")),
				 
				"nl_NL" 	=> array("name" => __("Dutch","premiumpress")),
				"it_IT" 	=> array("name" => __("Italian","premiumpress")),
				"ko_KR" 	=> array("name" => __("Korean","premiumpress")),
				
				"si_LK"  => array("name" => __("Sinhala","premiumpress")),
				
				"ta_LK"  => array("name" => __("Tamil","premiumpress")),
		 		 
			);
			
			$h = explode("_",$order_data);
			
			if( isset($lang_array[$order_data]) ){
			
			return $lang_array[$order_data]['name'];
			
			}elseif(isset($GLOBALS['core_country_list'][$h[1]])){
			
			return $GLOBALS['core_country_list'][$h[1]];
			
			}elseif(isset($GLOBALS['core_country_list'][strtoupper($h[0])])){
			
			return $GLOBALS['core_country_list'][strtoupper($h[0])];
			
			}else{
			
			return $order_data;
			
			}		
			 
		
		} break;
		
		case "get_mapdata": {  
			 	 
				
			// GET FIILTER QUERY
			$args = apply_filters( 'ppt_query_args',  array('paged' => 1, 'no_found_rows' => true, 'post_type'=> 'listing_type','posts_per_page' => 2, 'post_status' => 'publish' )  );
			$args['posts_per_page'] = 500;	
			$args['meta_query']["map-lat"]  = array(							
				'key' 		=> "map-lat",
				'value' 	=> "",
				'compare'	=> '!='						
			);	
			 	
			$my_query = new WP_Query($args); 
			$mapdata = $my_query->posts; 			 
		  
			if( is_array($mapdata) ) {	
								
				foreach($mapdata as $map){
				   
						  
					$catID 		= 0;	
					$catName 	= "";
					 
						
					// GET LISTING DATA
					$permalink 	= get_permalink($map->ID);
					$long 		= get_post_meta($map->ID,'map-log',true);	
					$lat 		= get_post_meta($map->ID,'map-lat',true);	
					$address	= get_post_meta($map->ID,'map-location',true);	
						
					$image = do_shortcode('[IMAGE pathonly=1 pid="'.$map->ID.'"]');						 
					 
					// switch based on theme display
					if(THEME_KEY == "jb"){
					
					$price = do_shortcode('[JOBTYPE pid="'.$map->ID.'"]');
					
					}elseif(THEME_KEY == "dt"){
					
					$price = strip_tags(do_shortcode('[CATEGORY pid="'.$map->ID.'" link=0]'));
					
					}elseif(THEME_KEY == "at"){
					
					$price = hook_price(get_post_meta($map->ID,'price_current',true));
					
					}else{
					
					$price = hook_price(get_post_meta($map->ID,'price',true));
					
					}
						 
					// SETUP JASON DATA
					$json[] = array(	
					
					"id"	=> $map->ID,	
					"lat" 	=> $lat,
					"long" 	=> $long, 
					"address" => esc_html(str_replace("'","",substr(strip_tags($address),0,200))), 
					
					"img" 	=> $image,
					"title" => esc_html(str_replace("'","",substr(strip_tags($map->post_title),0,28))),
					"url"  	=> $permalink,				
					
					"price" => $price,	
					 
					);	
				}
		 
			}  
		 
			// RETURN JASON OUTPUT
			return json_encode($json);
			
		
		
		} break;
		
		
	}


}

 

 
	function _language_current($lowercase = false){
	
	 
		if(isset($_SESSION['language'])){		 
			$name = $_SESSION['language'];		
		}else{
		 
			$name = _ppt(array('lang','default'));
			if($name == ""){
			$name = "en_US";
			}
		}
		 
	 	 
		if($lowercase){
			return strtolower($name);
		}else{
			return $name;
		}
	
	}
	

	function _currency_current($lowercase = false){
	
		if(isset($_SESSION['currency'])){		 
			$name = $_SESSION['currency']['code'];
		}else{
			$name = _ppt(array('currency','code'));
		}
		 
		if($lowercase){
			return strtolower($name);
		}else{
			return $name;
		}	
	}
	
	function _currency_symbol($lowercase = false){
	
		if(isset($_SESSION['currency'])){		 
			$name = $_SESSION['currency']['symbol'];
		}else{
			$name = _ppt(array('currency','symbol'));
		}
		 
		if($lowercase){
			return strtolower($name);
		}else{
			return $name;
		}	
	}




/* =============================================================================
CURRENY OPTIONS
========================================================================== */

	/*
		this function will return the 
		active currency code
	*/
	function _currency_get_code($c = array()){	
	
		// CHECK IF NOT TURNED OFF 	
		 
		if( _ppt(array('currency','switch')) != '1'){ return _ppt(array('currency','code')); }
	
		if(isset($_SESSION['currency']) && isset($_SESSION['currency']['code']) && $_SESSION['currency']['code'] != ""){
			return $_SESSION['currency']['code'];
		}else{
			
			$default = _ppt(array('curreny','symbol') );					 
			if($default == ""){ 
			
			$core_data = get_option("core_admin_values");
			$default = $core_data['currency']['symbol']; 
			
			}
		
			return $default;
		}
	}
	
	/*
		this function will get the active
		currency symbol
	*/
	function _currency_get_symbol($c){
	
		// CHECK IF NOT TURNED OFF 	
		if( _ppt(array('currency','switch')) != '1'){ return _ppt(array('currency','symbol'));; }

	
		if(!is_admin() && isset($_SESSION['currency']) && isset($_SESSION['currency']['symbol'])){
		
			return $_SESSION['currency']['symbol'];
			
		}else{
			
			$default = _ppt( array('currency','symbol') );
 	 
			if($default == ""){ $default = "$"; }
		
			return $default;
		}
	}		
	/*
		this function sets up the currency with rates etc
	*/
	function _currency_setup($p = 0){	
		 
		
		 $GLOBALS['shop_currency']	= array();
		 
		 if(!isset($GLOBALS['CORE_THEME']['currency'])){ return; }
		 if(!isset($GLOBALS['CORE_THEME']['cc'])){ return; }
		 
		 if(!isset($GLOBALS['CORE_THEME']['currency']['code'])){ $GLOBALS['CORE_THEME']['currency']['code'] = "USD"; }
		 
		 
		 // CREATE DEFAULT VALUE	
		 $GLOBALS['shop_currency'][$GLOBALS['CORE_THEME']['currency']['code']] 	= array(
			"code" 	=> $GLOBALS['CORE_THEME']['currency']['code'], 
			"rate" 	=> 1, 
			"symbol"=> $GLOBALS['CORE_THEME']['currency']['symbol'], 
			"link"	=> "c=".$GLOBALS['CORE_THEME']['currency']['code']
			);
		
		 $i=1; 
		 while($i < 11){ 
		
			if(_ppt('cc','symbol'.$i) == "" || !isset($GLOBALS['CORE_THEME']['cc']['symbol'.$i]) ){ $i++; continue; }
			
			if(strpos($GLOBALS['CORE_THEME']['cc']['symbol'.$i], "fa") !== false){
			$symb = '<i class=\''.$GLOBALS['CORE_THEME']['cc']['symbol'.$i].'\'></i>';
			}else{
			$symb = $GLOBALS['CORE_THEME']['cc']['symbol'.$i];
			}
			
			$GLOBALS['shop_currency'][$GLOBALS['CORE_THEME']['cc']['code'.$i]] 	= array(
			"code" 		=> $GLOBALS['CORE_THEME']['cc']['code'.$i], 
			"rate" 		=> $GLOBALS['CORE_THEME']['cc']['rate'.$i], 
			"symbol"	=> $symb, 
			"link"		=> "c=".$GLOBALS['CORE_THEME']['cc']['code'.$i]
			);
		
		 $i++; 
		 }
	
		if(isset($_REQUEST['c']) && isset($GLOBALS['shop_currency'][$_REQUEST['c']])){ 
			
			$_SESSION['currency'] 	= $GLOBALS['shop_currency'][$_REQUEST['c']];
		
		}
 
	
	}


	// THIS FUNCTION WILL HANDLE ALL OF THE CURRENCY CONVERSIONS ETC
	function _currency($p = 0){	
	 
 
	// CHECK IF NOT TURNED OFF 	
	if( _ppt(array('currency','switch'))!= '1'){ return $p; }
	
  
	if(isset($_REQUEST['c']) && isset($GLOBALS['shop_currency'][$_REQUEST['c']])){ 
			
		$_SESSION['currency'] 	= $GLOBALS['shop_currency'][$_REQUEST['c']];
	 
	}elseif(isset($_SESSION['currency']['rate']) && $_SESSION['currency']['rate'] > 0  ){ 
	
	 	// DO NOTHING	
								 
	}elseif(isset($GLOBALS['shop_currency']) && isset($GLOBALS['currency']['code']) ){
	
		$_SESSION['currency'] 	= $GLOBALS['shop_currency'][$GLOBALS['currency']['code']];
	}
	
	 
	// CALCULATE NEW PRICE	
	if(isset($_SESSION['currency']) && isset($_SESSION['currency']['rate']) && $_SESSION['currency']['rate'] > 0 ){	
		
		// STRIP TAGS FROM PRICE JUST ENCASE
		$p = strip_tags($p); 
		
			// 
			if($_SESSION['currency']['code'] == $GLOBALS['CORE_THEME']['currency']['code']){
			
			$thisrate = 1;		
			
			}else{
			
			$thisrate = $_SESSION['currency']['rate'];
		 
			}
		 
		 
		if($p > 0  ){ 
			$p = str_replace(",","",$p);
			$a = (float)($p);
						
			if($thisrate != 1){
			$p = ($a/$thisrate); // get the rate against the default curreny	
			}
			
			$p = round($p,2); 
						
			//echo $p." = ".$a." /".$thisrate."<br>";
			//die();
			
			 
		} // end if
		
	} // end if
	
	// RESET DISPLAY CURRENCY
	if(isset($_SESSION['currency']['symbol'])){
	$_SESSION['currency']['symbol'] = 	hook_currency_symbol('');
	}
 
	return $p;
	}

 	
 
 
	
	
/*
	this is the main function for hook_price
	it will return a price formatted
	or use array to remove curreny code
*/
function price_format_display($data){  $curreny = true; $val = $data; $digs = "";
 
	// CHECK FOR ARRAY WITH CURRENY OFF
	if(is_array($data)){
		 
		$val = $data[0];
				
		if(isset($data[1])){
		$curreny = false;
		}else{
		$curreny = true;
		} 
	}
	
	// FORMATTING FIX
	$val = str_replace(",", "", $val);
	 
	// FORMAT
	if(!is_numeric($val)){ $val = 0; }	
	$val = number_format($val, 2);
	
	// CURRENCY EXCHANGE RATE
	$val = hook_price_filter($val);	  	 
	 
	// CODE
	if($curreny){
	
		$cs = hook_currency_symbol('');
		$cc = hook_currency_code('');
		
		if(strpos($cs, "fa") !== false){
			if(strpos($cs, "class") !== false){
			$cs = $cs;
			}else{
			$cs = '<i class=\''.$cs.'\'></i>';
			}
		}
	 		
		if(_ppt( array('currency','position') ) == "right"){ 		 
				$val = $val.$cs;				
		}else{				
				$val = $cs.$val;
		}			
	}

	// RETURN
	return $val;
}	
	 
	 
 



/* =============================================================================
  GOOGLE MAP DISPLAY FUNCTION FOR SEARCH RESULTS PAGE
   ========================================================================== */

function get_radius_unit(){

	// GET THE UNIT
	$unit = strtoupper(_ppt('geolocation_unit'));			
	if ($unit == "K") {			 
		$rt = __("kilometers","premiumpress");
	} else if ($unit == "N") {
		$rt = __("nautical miles","premiumpress");	
	} else {
		$rt = __("miles","premiumpress");    
	}
	
	return $rt;
}
function MilesToMeters($num){
if($num == "" || $num == 0){ return 0; }
 
	$unit = strtoupper(_ppt('geolocation_unit'));
	
	if ($unit == "K") {	
		return $num/0.001;  // 1 meters = 0.001 KM;
	} else {
		return $num/0.00062137119; // 1 meters = 0.00062137119 miles; 
	}

} 
function ppt_google_getradius(){

if(!isset($_GET['zipcode'])){ return; }

$saved_searches = get_option('ppt_saved_zipcodes');

$longitude 	= $saved_searches[$_GET['zipcode']]['log'];
$latitude 	= $saved_searches[$_GET['zipcode']]['lat'];
$radius = 1;
if(isset($_GET['radius']) && is_numeric($_GET['radius']) ){
$radius = $_GET['radius'];
}

return array("zip" => $_GET['zipcode'], "long"  => $longitude, "lat"  => $latitude, "dis" => $this->MilesToMeters($radius) );

} 
function ppt_google_getdefaults(){	
	
	// REGION
	$region = "us"; $lang = "en"; 
	if(isset($GLOBALS['CORE_THEME']['google_lang'])){
		$region = $GLOBALS['CORE_THEME']['google_region'];
		$lang = $GLOBALS['CORE_THEME']['google_lang'];
	}

	// GET DEFAULT ROOM AND COORDS FROM ADMIN
	if(isset($GLOBALS['CORE_THEME']['google_coords1']) && $GLOBALS['CORE_THEME']['google_coords1'] != ""){ 
		$ff = explode(",",$GLOBALS['CORE_THEME']['google_coords1']);
		$latitude =  $ff[1];
		$longitude = $ff[0];
	}
	if(isset($GLOBALS['CORE_THEME']['google_zoom1'])){ $default_zoom = $GLOBALS['CORE_THEME']['google_zoom1']; }
	
	
	// CHECK IF THIS IS A ZIPODE SEARCH
	if(isset($_GET['zipcode']) && ( strlen($_GET['zipcode']) > 2 && strlen($_GET['zipcode']) < 9 ) ){
	
		$saved_searches = get_option('ppt_saved_zipcodes');
		
		if(isset($saved_searches[$_GET['zipcode']]['log'])){
		$longitude 	= $saved_searches[$_GET['zipcode']]['log'];
		}else{ $longitude =0; }
		
		if(isset($saved_searches[$_GET['zipcode']]['lat'])){
		$latitude 	= $saved_searches[$_GET['zipcode']]['lat'];
		}else{ $latitude =0; }	 
			
	}
	
	// SET COORDS TO USERS LOCATION IF ORDERING BY DISTANCE
	if(isset($_SESSION['mylocation']['lat']) && strlen($_SESSION['mylocation']['lat']) > 0 && strlen($_SESSION['mylocation']['log']) > 0 && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != ""){

		$latitude =  strip_tags($_SESSION['mylocation']['lat']);
		$longitude = strip_tags($_SESSION['mylocation']['log']);
	}
	
	// CHECK AND VALDATE
	if(!isset($longitude) || ( isset($longitude) && $longitude == "" ) ){ $longitude = 0; }
	if(!isset($latitude) || ( isset($latitude) && $latitude == "" ) ){ $latitude = 0; }
	
	$default_zoom = 7;
	
	return array("region" => $region, "lang" => $lang, "zoom" => $default_zoom, "long" => $longitude, "lat" => $latitude  );
}

 

 


 

	
 
	

	
}

?>