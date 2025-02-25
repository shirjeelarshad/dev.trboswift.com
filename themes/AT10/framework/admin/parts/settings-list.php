<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE_ADMIN, $settings, $CORE;

 

// START MAIN ARRAY
$configsettings = array(

 
'company' => array(	

	
	"n" => __("Company","premiumpress"), 	
	"desc-small" => __("Update company details and website information.","premiumpress"),		
	"desc" => __("Update company details and website information.","premiumpress"),
		
	"video" => "https://www.youtube.com/watch?v=k2h86vK7tYo",
	
	
 	"icon" => "fa-briefcase",
	
	"data" => array(	
		
		"name" 		=> array("name"=> __("Company Name","premiumpress"), "d" => "", "icon" => "fal fa-home", "col6" => true ),		
		"ceoname" 	=> array("name"=> __("CEO Name","premiumpress"), "d" => "", "icon" => "fal fa-user-circle", "col6" => true ),		
		"email" 	=> array("name"=> __("Email","premiumpress"), "d" => "", "icon" => "fal fa-envelope", "col6" => true),
		"phone" 	=> array("name"=> __("Phone","premiumpress"), "d" => "", "icon" => "fal fa-phone", "col6" => true),
		
		
		"twitter" => array("name"=> __("Twitter","premiumpress"), "d" => "", "icon" => "fab fa-twitter", "col6" => true),
		"facebook" => array("name"=> __("Facebook","premiumpress"), "d" => "",  "icon" => "fab fa-facebook", "col6" => true),
		"youtube" => array("name"=> __("Youtube","premiumpress"), "d" => "",  "icon" => "fab fa-youtube", "col6" => true),
		"instagram" => array("name"=> __("Instagram","premiumpress"), "d" => "",  "icon" => "fab fa-instagram", "col6" => true),
		 
		
		"s" 	=> array( "seperator" => true),
		
		"mission" 		=> array("name"=> __("Mission Statement","premiumpress"),  "icon" => "fal fa-header", "d" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.", "type" => "textarea"),
		 
		"companymap" 		=> array("name"=> __("Map","premiumpress"), "type" => "custom", "icon" => "fal fa-map-marker",  "path" => "companymap", "col12" => true ),
		
		
		"address" 	=> array("name"=> __("Full Address","premiumpress"), "icon" => "fal fa-map", "d" => "Horse Guards Parade, United Kingdom","type" => "textarea" ),
		
		
		
		
		
		// company map map-log map-lat
		
		
			
	),
), 



 


'pagelinks' => array(		
	 
	
	"n" => __("Page Links","premiumpress"), 	
	"desc-small" => __("Setup button and page links here by selecting custom pages.","premiumpress"),	
		
	"desc" => __("Page links tell the theme where to send users when they click on links and buttons.","premiumpress"),
	
		
	"video" => "https://www.youtube.com/watch?v=SK7dgyP5H4Q",
	 
	 "icon" => "fa-link",
	 
	 "data" => array(
	 
		 "links" => array( 
				 "name" => "", 
				 "desc" => "",
				 "type" => "custom", 
				 "path" => "pagelinks",
				 "col12" => true 
			),	
	),
	 
), 


'menu' => array(		
	 
	
	"n" => __("Menu","premiumpress"), 	
	"desc-small" => __("Here you can setup your website menus.","premiumpress"),	
		
	"desc" => __("Here you can setup your website menus.","premiumpress"),
	
		
	//"video" => "https://www.youtube.com/watch?v=SK7dgyP5H4Q",
	 
	 "icon" => "fa-bars",
	 
	 "data" => array(
	 
		 "links" => array( 
				 "name" => "", 
				 "desc" => "",
				 "type" => "custom", 
				 "path" => "mobile",
				 "col12" => true 
			),	
	),
	 
), 

 

'register' => array(		
	  

	"n" => __("Registration","premiumpress"), 
		
	"desc-small" => __("Configure your user registration process here.","premiumpress"),	
		
	"desc" => __("These settings are applied during the user registration page.","premiumpress"),
		
	"video" => "https://www.youtube.com/watch?v=tcq0LAATZQg",

	"icon" => "fa-lock-alt",
	"data" => array(	
	
	
		 "users_can_register" => array(
		 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom",
			 "path" => "register",
			 "col12" => true 
		 ),


		 "username" => array(
		 
			 "name" => __("User Sets Username","premiumpress"),
			 "desc" => __("Let users create their own username instead of the system creating one for them.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "1",
			 "col4" => 1, 
		 ),	
		 		 
		 "password" => array(
		 
			 "name" => __("User Sets Password","premiumpress"),
			 "desc" => __("Let users create their own password instead of the system emailing them one.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "1",
			 "col4" => 1, 
		 ),	
		 
		 "hide_firstlast" => array(
		 
			 "name" => __("Hide First/Last Name","premiumpress"),
			 "desc" => __("Turn ON to disable the first/last name registration and profile fields.","premiumpress"),
			 "type" => "yesno", 
			 "d" 	=> "1",
			 "col4" => 1, 
		 ),	
		  
		 
		  "da_autocreate" => array(
		 
			 "name" => __("Auto Create System Profile","premiumpress"),
			 "desc" => __("Turn ON to create a blank profile when the user signup.","premiumpress"),
			 "type" => "yesno", 
			 "d" 	=> "1",
			 "col4" => 1, 
		 ),	
		 
		  "da_seeking" => array(
		 
			 "name" => __("Hide Seeking User Option","premiumpress"),
			 "desc" => __("Turn ON to disable the seeking user selection field.","premiumpress"),
			 "type" => "yesno", 
			 "d" 	=> "0",
			 "col4" => 1, 
		 ),	
		 
		 "da_reggender" => array(
		 
			 "name" => __("Hide Gender Option","premiumpress"),
			 "desc" => __("Turn ON to disable the gender option at registration.","premiumpress"),
			 "type" => "yesno", 
			 "d" 	=> "0",
			 "col4" => 1, 
		 ),	
		 
		 			
 /*
		 "mobilenumber" => array(
		 
			 "name" => __("Mobile Number","premiumpress"), 
			 "desc" => __("Let users add their mobile number during registration.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0" ,
			 "col4" => 1,
		 ),		
		 */
		  
		 "sociallogin" => array(
		 
			 "name" => __("Enable Social Login","premiumpress"), 
			 "desc" => __("Turn on/off social login features allowing members to login/register with their social media accounts.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0" ,
			 "col4" => 1,
		 ),		
		 
		 
		  "forcemailverify" => array(
		 
			 "name" => __("Force Email Verification","premiumpress"), 
			 "desc" => __("Turn on if you want to stop users accessing account features before they have verified their email address.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0" ,
			 "col4" => 1,
		 ),			 
		 
		 
		 "socialoptions" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "socialogin",
			 "col12" => true 
		 ),		
			
			
	),
), 

 

'search' => array(	


	"n" => __("Search Settings","premiumpress"), 	
	"desc-small" => __("Configure your search page settings with additional options.","premiumpress"),			
	"desc" => __("Here are all of the search page settings for your website.","premiumpress"),
	
"video" => "https://www.youtube.com/watch?v=LhYV-K4s3Tw",
	
 
	 "icon" => "fa-search",
	"data" => array(
	

	 
	  
		 "exr" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "searchfields", 
			 "col12" => true   
		 ),	
		 
		  
		  "cardswicth" => array(
		 
			 "name" => __("Hide Layout Switcher","premiumpress"), 
			 "desc" => __("Turn on/off the icon to change the display layouts.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0",
			 "col8" => 1, 
			 
		 ),
		 
		 
		 "typehead" => array(
		 
			 "name" => __("Enable Typeahead","premiumpress"), 
			 "desc" => __("Turn on/off the default typeahead system for search boxes.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0",
			 "col8" => 1, 
		 ),	
		 
		  "count" => array(
		 
			 "name" => __("Hide Category Count","premiumpress"), 
			 "desc" => __("(Recommended for slow websites) Turn on/off category/taxonomy count icon.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0",
			 "col8" => 1, 
			 
		 ),
		 
		  "ss" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "searchfilters", 
			 "col12" => true   
		 ),	
	), 
	
	
	
), 


'maps' => array(		
	 
	
	"n" => __("Google Maps","premiumpress"), 	
	"desc-small" => __("Here you can enter your Google Maps API key.","premiumpress"),			
	"desc" => __("Here are all the Google Map settings for your website.","premiumpress"),
	
	
	"video" => "https://www.youtube.com/watch?v=ef_QC3tCFyE",
	

	"link" => "https://developers.google.com/maps/documentation/javascript/get-api-key",
	
	
	
	 "icon" => "fa-map-marker",
	"data" => array(	
			
		 "enable" => array(
		 
			 "name" => __("Enable Maps","premiumpress"), 
			 "desc" => __("This will display a map of search results at the top of the page.","premiumpress"),
			 "type" => "yesno", 
			 "d" => 0,
			 "col4" => 1, 
		 ),
		 

		  "provider" => array(
		 
			 "name" 	=> __("Map Provider","premiumpress"), 
			 "desc" 	=> __("Choose which map service you want to use.","premiumpress"),
			 "type" 	=> "select",
			 "values" 	=> array(
								1 => array("id" => "google", "name" => "Google Maps"), 
								2 => array("id" => "mapbox", "name" => "MapBox Maps"),
								3 => array("id" => "basic", "name" => "Basic Country/City Search (no map)"),
			 ),					
			 "d" 		=> "",
			 "col4" 	=> 1,  
		 ),	
		 
		 "apikey" => array(
		 
			 "name" => __("API Key","premiumpress"), 
			 "desc" => __("This is API key for the map provider you select above.","premiumpress")." <a href='https://console.developers.google.com/apis/dashboard' style='font-weight: bold;' target='_blank'>Google maps here</a> and <a href='https://account.mapbox.com/' style='font-weight: bold;' target='_blank'>Mapbox here.</a>",			 
			 "d" 	=> "",
			 "col4" => 1,  
		 ),	
		 
		 /*
		 "enable_mapbox" => array(
		 
			 "name" => __("MapBox","premiumpress"), 
			 "desc" => __("Mapbox is a Google Maps alternative. You can signup free here: ","premiumpress")."<a href='https://mapbox.com'>MapBox</a>",
			 "type" => "yesno", 
			 "d" => 0,
			 "col4" => 1, 
		 ),
		 
		 "mapbox_apikey" => array(
		 
			 "name" => __("Mapbox API Key","premiumpress"), 
			 "desc" => __("Enter your Mapbox API key above if you are using MapBox instead of Google Maps. ","premiumpress")."",
			 
			 "d" => "",
			 "col4" => 1,  
		 ),
		 */
		 
		 /*
		  "cluster" => array(
		 
			 "name" => __("Map Clusters","premiumpress"), 
			 "desc" => __("This will look for markers that are near each other and replaces them with another icon to represent multiple markers","premiumpress"),
			 "type" => "yesno", 
			 "d" => 1,
			 "col4" => 1, 
		 ),	 
		 */


	),
), 

'analytics' => array(		
	 
	
	"n" => __("Google Analytics","premiumpress"), 	
	"desc-small" => __("Here you can enter your Google Analytics API key.","premiumpress"),			
	"desc" => __("Here are all the Google Analytics settings for your website.","premiumpress"),

	"link" => "https://analytics.google.com/analytics/web/",
	
	"icon" => "fa-signal-alt",
	"data" => array(
	
		 "enable" => array(
		 
			 "name" => __("Enable","premiumpress"), 
			 "desc" => __("This will turn on/off Analytics for your website.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0",
			 "col4" => 1,
		 ),
		 
	  
		 "uakey" => array(
		 
			 "name" => __("Google Analytics UA Key","premiumpress"), 
			 "desc" => __("This is required by Google to use their Analytics code on your website.","premiumpress")."<a href='https://analytics.google.com/analytics/'>Get your key here.</a>",
			 "placeholder" => "UA-123456-x",
			 "d" => "" ,
			 "col4" => 1,  
		 ),	
		 
		  "uakeyv4" => array(
		 
			 "name" => __("Google Analytics V4 Key","premiumpress"), 
			 "desc" => __("If you are using a new v4 key, enter the code here.","premiumpress")."<a href='https://analytics.google.com/analytics/'>Get your key here.</a>",
			 "placeholder" => "G-xxxxx",
			 "d" => "" ,
			 "col4" => 1,  
		 ),	

	),
), 

'captcha' => array(		


	"n" => __("Google Captcha V2","premiumpress"), 	
	"desc-small" => __("Google Captcha is designed to help reduce spam on your website.","premiumpress"),			
	"desc" => __("This is to stop bots commenting. If turned OFF there will be no CAPTCHA security code.","premiumpress"),
	
	"link" => "https://www.google.com/recaptcha/intro/v3.html",
	
	"video" => "https://www.youtube.com/watch?v=jiCMXejenDs",

	"icon" => "fa-project-diagram",
	"data" => array(	
			
		 "enable" => array(
		 
			 "name" => __("Enable","premiumpress"), 
			 "desc" => "",
			 "type" => "yesno", 
			 "d" => "0",
			 "col4" => 1,  
		 ),
		 
		 
		 "sitekey" => array(
		 
			 "name" => __("Site Key","premiumpress"), 
			 "desc" => "You can get your own key using the link here: <a href='https://www.google.com/recaptcha/' target='_blank'>https://www.google.com/recaptcha/</a>",
			 
			 "d" => "",
			 "col4" => 1, 
		 ),	
		 
		 
		 "secretkey" => array(
		 
			 "name" => __("Secret Key","premiumpress"), 
			 "desc" => "",
			 
			 "d" => "",
			 "col4" => 1, 
		 ),			 
		 	 


	),
), 




'lang' => array(		
	 
	"n" => __("Languages","premiumpress"), 	
	
	"desc-small" => __("Here you can change the language settings for your website.","premiumpress"),
				
	"desc" => __("Here are all of the language settings for your website.","premiumpress"),
	
	"plugin" => array("name" => "Install Language Editor", "link" => "http://localhost/V9/wp-admin/plugin-install.php?tab=plugin-information&plugin=loco-translate") ,
	
	"video" => array(
	
		1 => array(
		
			"title" => "How to setup multiple languages.",
			"link" => "https://www.youtube.com/watch?v=4yoCSvH8xjU",		
			
		),
				
		
		2 => array(
		
			"title" => "How to setup menu navigation bars in multiple languages.",
			"link" => "https://www.youtube.com/watch?v=Zz8WZhf_JuA",		
			
		),
		
		3 => array(
		
			"title" => "How to update your own language files using loco translate.",
			"link" => "https://www.youtube.com/watch?v=Mm1SMYSSu5c",		
			
		),	
		
		4 => array(
		
			"title" => "How to change text on your website.",
			"link" => "https://www.youtube.com/watch?v=G68QcvQ1U40",		
			
		),	 
		 
	),
	
	"icon" => "fa-language",
	"data" => array(
	
	  
	  
	  
		 "langcustom" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "language",
			 "col12" => true 
		 ),		

	),
), 


   
/*
'gateways' => array(	


	"n" => __("Payment Gateways","premiumpress"), 	
	"desc-small" => __("Here you can setup and configure payment gateways for your website.","premiumpress"),			
	"desc" => __("Here you can setup and configure payment gateways for your website.","premiumpress"),
	
	"video" => "https://www.youtube.com/watch?v=jBVnWQi8Xlw",
	 
	"icon" => "fa-shopping-cart",
	"data" => array(
	
	
 		"exr" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "gateways",
			 "col12" => true 
		 ),	
		 		 
		 
		 
	),		 
),
*/

/*
'coupons' => array(	


	"n" => __("Coupon Codes","premiumpress"), 	
	"desc-small" => __("Here you can setup discount codes for your website.","premiumpress"),			
	"desc" => __("Here you can setup discount codes for your website.","premiumpress"),

 	"video" => "https://www.youtube.com/watch?v=atAAYYUuo4o",
	
	"icon" => "fa-cut",
	"data" => array(
	
	
	 "enable" => array(
		 
			 "name" => __("Enable","premiumpress"), 
			 "desc" => __("Turn on/off discount codes during payment.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0"  
		 ),
		 
	 
 		"exr1" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "coupons",
			 "col12" => true 
		 ),			 
		 
		 
	),		 
),
*/

'currency' => array(	


	"n" => __("Currency Settings","premiumpress"), 	
	"desc-small" => __("Here you can change the currency settings for your website.","premiumpress"),			
	"desc" => __("Here are all of the currency settings for your website.","premiumpress"),

 
	"icon" => "fa-sack-dollar",
	"data" => array(
	
	
 		"switch" => array(
		 
			 "name" => __("Currency Switcher","premiumpress"), 
			 "desc" => __("Turn on/off the display of the currency switching button.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "1",
			  
		 ),	
		 
 		"symbol" => array(
		 
			 "name" => "<br>".__("Symbol (eg. $)","premiumpress"), 
			 "desc" => "",
			 "type" => "text", 
			 "d" => "$",
			 "col6" => true
		 ),	

		 
 		"code" => array(
		 
			 "name" => "<br>"."Code (eg. USD)", 
			 "desc" => "",
			 "type" => "text", 
			 "d" => "USD" ,
			  "col6" => true
		 ),	
		 
		 
 		"position" => array(
		 
			 "name" => __("Symbol Position","premiumpress"), 
			 "desc" => "",
			 "type" => "select", 
			 "values" => array( 1=> array("id" => "left", "name" => "Left (e.g $100)"), 2 => array("id" => "right", "name" => "Right (e.g 100$)"), ),
			  "col6" => true 
		 ),	
		 	 
		 /*
 		"dec" => array(
		 
			 "name" => __("Decimal Places","premiumpress"), 
			 "desc" => "",
			 "type" => "select", 
			 "values" => array( 1=> array("id" => "0", "name" => "0"), 2 => array("id" => "1", "name" => "1"), 3 => array("id" => "2", "name" => "2"), 4 => array("id" => "3", "name" => "3"), ) ,
			 "col6" => true
		 ),			 
		 
		 
		 */
		 
		 "s" 	=> array( "seperator" => true),	 		 
	  
		 "exr" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "exchangerates",
			 "col12" => true 
		 ),		

	),
), 



'gdpr' => array(	


	"n" => __("GDPR Cookie Law","premiumpress"), 	
	"desc-small" => __("Here you can turn on the accepty GDPR cookies option.","premiumpress"),			
	"desc" => __("Here you can turn on the accepty GDPR cookies option.","premiumpress"),
 
 	"video" => "https://www.youtube.com/watch?v=7yfq6n05TNQ",
	
	"icon" => "fa-cookie",
	"data" => array(
	
	
	 "enable" => array(
		 
			 "name" => __("Enable","premiumpress"), 
			 "desc" => __("Turn on/off  the display of the 'accept cookies' option in the footer of your website.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0"  
		 ), 
		 
		 
	),		 
),
 
'adultwarning' => array(	


	"n" => __("Adult Notice 18+","premiumpress"), 	
	"desc-small" => __("Here you can turn on adult only content notices.","premiumpress"),			
	"desc" => __("Here you can turn on adult only content notices.","premiumpress"),
 
 	"video" => "https://www.youtube.com/watch?v=7yfq6n05TNQ",
	
	"icon" => "fa-exclamation-circle",
	"data" => array(
	
	
	 "enable" => array(
		 
			 "name" => __("Enable","premiumpress"), 
			 "desc" => __("Turn on/off  the display of the 'adult content' at the bottom of your website.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "0"  
		 ), 
		 
		 
	),		 
),

'blog' => array(	


	"n" => __("Blog","premiumpress"), 	
	"desc-small" => __("Here are additional settings for the built-in blog pages.","premiumpress"),			
	"desc" => __("Here are additional settings for the built-in blog pages.","premiumpress"),
 
	"icon" => "fa-rss",
	"data" => array(
	
	
	 "enablesocial" => array(
		 
			 "name" => __("Social Sharing","premiumpress"), 
			 "desc" => __("Turn on/off the social media sharing buttons.","premiumpress"),
			 "type" => "yesno", 
			 "d" => "1"  
		 ),
		 
	 
 		 		 
		 
		 
	),		 
),

 
'comchat' => array(	


	"n" => __("CometChat Integration","premiumpress"), 	
	"desc-small" => __("CometChat are a third-part chatroom software provider.","premiumpress"),			
	"desc" => __("Here you can setup CometChat software on your website.","premiumpress"),

 	"video" => "https://youtu.be/bUDRwX2j8vo",
	
	"link" => "https://a.paddle.com/v2/click/11855/127045?link=3219",
	
	"icon" => "fa-comment-alt-smile",
	"data" => array(
	 
		 
	 
 		"exr1" => array( 
			 "name" => "", 
			 "desc" => "",
			 "type" => "custom", 
			 "path" => "comchat",
			 "col12" => true 
		 ),			 
		 
		 
	),		 
),



 
);



if(THEME_KEY != "da"){
unset($configsettings['comchat']);
}

 

if(in_array(THEME_KEY, array("da","ex")) ){

}else{
unset($configsettings['register']['data']['da_seeking']);
unset($configsettings['register']['data']['da_reggender']);
unset($configsettings['register']['data']['da_autocreate']);
}

 

// TURN OFF SETTINGS
if(THEME_KEY == "sp"){
unset($configsettings['user']['data']['allow_profile']);
}

if(THEME_KEY == "vt"){
unset($configsettings['user']['data']['author_reputation']);
}

if(defined('WP_ALLOW_MULTISITE')){ 
unset($configsettings['register']['data']['users_can_register']);
}

 

?>

<style>
#overview-box { display:none; }
</style>
   
   
  <div class="tab-content">
  
    
    
        <div class="tab-pane addjumplink show active" 
        data-title="<?php echo __("Overview","premiumpress"); ?>" 
        data-icon="fa-home" 
        id="overview" 
        role="tabpanel" aria-labelledby="overview-tab">
             <div id="overviewlist" class="row"> </div>                      
        </div>  
    
    <?php 
	
	global $settings;
	$i=1; foreach($configsettings as $k => $d){ ?>
    
    
     <div class="tab-pane addjumplink" 
     data-title="<?php echo $d['n']; ?>" 
     data-icon="<?php echo $d['icon']; ?>"
     data-desc="<?php echo $d['desc-small']; ?>"
     
      
     id="<?php echo $k; ?>" role="tabpanel" aria-labelledby="<?php echo $k; ?>-tab">
     
   
      <?php
 
 	$vid = "";
 	if(isset($d['video'])){ $vid = $d['video']; }
	
	$link = "";
 	if(isset($d['link'])){ $link = $d['link']; }
 	
	$plugin = "";
 	if(isset($d['plugin'])){ $plugin = $d['plugin']; }
 
  	$settings = array("title" => $d['n'], "desc" => $d['desc'], "video" => $vid, "link" => $link , "plugin" => $plugin);
  	 _ppt_template('framework/admin/_form-wrap-top' ); 
	 
	 
	 
	 ?>  
    
    
    <div class="card card-admin"><div class="card-body">
    
    <div class="row">
    <?php if(is_array($d['data'])){ foreach($d['data'] as $fieldkey => $fielddata){ echo $CORE_ADMIN->LoadCongifField($fielddata, $fieldkey, $k); } } ?>  
    </div>
    
   
    <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>
    
    
     </div>
    
 
	<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  
     
  
  </div> </div>
    
    
    <?php $i++; } ?>
    
 
        <div class="tab-pane  addjumplink" 
        data-title="<?php echo __("SEO","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can manage your website meta tags.","premiumpress"); ?>"
        data-icon="fa-globe" 
        id="seo" 
        role="tabpanel" aria-labelledby="seo-tab">
        <?php _ppt_template('framework/admin/parts/settings-seo' ); ?>          
        </div><!-- end design home tab -->    
    
        <div class="tab-pane  addjumplink" 
        data-title="<?php echo __("User Settings","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can change the user settings for your website.","premiumpress"); ?>"
        data-icon="fa-user" 
        id="user" 
        role="tabpanel" aria-labelledby="cleaning-tab">
        <?php _ppt_template('framework/admin/parts/settings-user' ); ?>          
        </div><!-- end design home tab -->    
        
         <div class="tab-pane addjumplink" 
        data-title="<?php echo __("Taxonomies","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup your own custom taxonomies.","premiumpress"); ?>"
        data-icon="fa-filter" 
        id="taxonomies" 
        role="tabpanel" aria-labelledby="taxonomies-tab">
        <?php _ppt_template('framework/admin/parts/settings-taxonomies' ); ?>          
        </div><!-- end design home tab -->    
    
    

<?php /* if( $CORE->LAYOUT("captions","listings") ){ ?>

     <div class="tab-pane addjumplink" 
        data-title="<?php echo __("Listing Settings","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup listing packages for your website.","premiumpress"); ?>"
        data-icon="fa-layer-plus" 
        id="packages" 
        role="tabpanel" aria-labelledby="packages-tab">
<?php  _ppt_template('framework/admin/parts/listings-packages' ); ?> 
        </div>      
       
        
      <div class="tab-pane addjumplink" 
        data-title="<?php echo __("Custom Fields","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup cutom fields for your listings.","premiumpress"); ?>"
        data-icon="fa-cube" 
        id="customfields" 
        role="tabpanel" aria-labelledby="customfields-tab">
<?php  _ppt_template('framework/admin/parts/listings-fields' ); ?> 
        </div>  
        */ ?>
           
          
        <?php /*if( $CORE->LAYOUT("captions","memberships") ){ ?>
       <div class="tab-pane addjumplink" 
        data-title="<?php echo __("Memberships","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can configure membership options.","premiumpress"); ?>"
        data-icon="fa-users-class" 
        id="mem-packages" 
        role="tabpanel" aria-labelledby="mem-packages-tab">
		 <?php _ppt_template('framework/admin/parts/membership-packages' ); ?>
        </div> 
        <?php } */  ?>
         
    
        <!--<div class="tab-pane  addjumplink" -->
        <!--data-title="<?php echo __("License Key","premiumpress"); ?>" -->
        <!--data-desc="<?php echo __("Here you can change your license key.","premiumpress"); ?>"-->
        <!--data-icon="fa-key" -->
        <!--id="cleaning" -->
        <!--role="tabpanel" aria-labelledby="cleaning-tab">-->
        
        <!--<?php _ppt_template('framework/admin/parts/settings-cleaning' ); ?>-->

          
        <!--</div>-->
        <!-- end design home tab -->      
    
    
    
    
    
    
    
    
    
    </div>
   
 

<script>
 
jQuery(document).ready(function(){
  // Add smooth scrolling to all links
  jQuery(".runmenow").on('click', function(event) {
   	var id = this.id;	
 	
	// switch tab
	jQuery('#myTab li:nth-child(2) a').tab('show');
	
	// set tab value
	jQuery('.tabinner').val('settings-tab');
	
	// SET ACCORDIAN TAB
	jQuery('.ShowThisAccordianTab').val('#collapse'+jQuery(this).data('id')); 
	
	// HIDE ALL TABS
	jQuery('.addsection').hide();
	
	// SHOW ONLY THIS ONE
	jQuery('#'+id).show();
	
	// open collapse	 
	jQuery('#collapse'+jQuery(this).data('id')).collapse('show');
  
  });
});

</script>