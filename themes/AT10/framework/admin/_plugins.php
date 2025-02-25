<?php

global $wpdb;

_ppt_template('framework/admin/header' ); 

 global $settings;
 
 
$plugins = array(

	1 => array(

	"name" => "Design Plugins",
	"desc" => "These plugins are recommended for additonal design options.",
	"data" => array(
		
		"elementor" => array(
			"t" => "Elementor", 
			"d" => "Elementor is a free drag-n-drop design editor for WordPress.", 
			"i" => "https://ps.w.org/elementor/assets/icon.svg?rev=1426809",  
		),
		
		"loco-translate" => array(
			"t" => "Loco Translate", 
			"d" => "Translate WordPress themes directly in your browser", 
			"i" => "http://ps.w.org/loco-translate/assets/icon-256x256.png"
		),
 		 
		
		"datafeedr-api" => array(
			"t" => "Datafeedr API", 
			"d" => "This plugin lets you use Datafeedr on your WordPress website.", 
			"i" => "https://ps.w.org/datafeedr-api/assets/icon-256x256.png?rev=1335107"
		),
			
		"datafeedr-comparison-sets" => array(
			"t" => "Datafeedr Comparison Sets", 
			"d" => "Automatically create price comparison sets for your AutoCoin Website.", 
			"i" => "https://ps.w.org/datafeedr-comparison-sets/assets/icon-256x256.png?rev=1388272"
		),
		 
		"wlt_icodes" => array(
			"t" => "iCodes Coupon Plugin", 
			"d" => "This plugin lets you import coupon codes from icodes.", 
			"i" => "icodes.png"
		),
	),
	
	
	
	),
	
	
	2 => array(

	"name" => "Popular Plugins",
	"desc" => "These popular plugins are used by many of our customers",
		"data" => array(
		
		
	 
		"wlt_vimeo" => array(
			"t" => "Vimeo Video Import", 
			"d" => "This plugin will help you search and add Vimeo videos to your autocoin website.", 
			"i" => "https://ps.w.org/wp-vimeo-videos/assets/icon-128x128.png?rev=2051497",  
			),
		),
	
	),
	

	3 => array(

	"name" => "Security Plugins",
	"desc" => "These plugins help prevent spam and unauthorized website access.",
		"data" => array(
		
		
	 
		"wordfence" => array(
			"t" => "Wordfence Security", 
			"d" => "The Wordfence WordPress security plugin provides free enterprise-class WordPress security, protecting your website from hacks and malware", 
			"i" => "http://ps.w.org/wordfence/assets/icon-256x256.png?rev=1208450",  
			),
		),
	
	),
	
	

	
	
	4 => array(

	"name" => "Payment Plugins",
	"desc" => "These plugins are used for accepting payments on your website.",
		"data" => array(
		
		
"plugindownload" => array("t" => "20+ Payment Gateway", "d" => "all payment gateways can be downloaded from our main website completely free.", "i" => "https://www.premiumpress.com/_demoimages/gateways/stripe.png", "link" => "https://stripe.com/"  ),
 
		
		
		
		),
	),
	
	
	5 => array(

	"name" => "SEO Plugins",
	"desc" => "These plugins will help improve your SEO.",
		"data" => array(
		
		
	"autoptimize" => array("t" => "Autoptimize", "d" => "Autoptimize speeds up your website and helps you save bandwidth by aggregating and minimizing JS, CSS and HTML.", "i" => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI5NiIgaGVpZ2h0PSI5NiIgdmlld2JveD0iMCAwIDk2IDk2IiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJyZ2IoMTQzLCA3NywgNjMpIiAvPjxjaXJjbGUgY3g9IjgiIGN5PSI4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzIyMiIgc3R5bGU9Im9wYWNpdHk6MC4wMjg2NjY2NjY2NjY2Njc7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI4IiBjeT0iOCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMTE1MzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzIyMiIgc3R5bGU9Im9wYWNpdHk6MC4wODA2NjY2NjY2NjY2Njc7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSIyNCIgY3k9IjgiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA0NiIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjgiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZGRkIiBzdHlsZT0ib3BhY2l0eTowLjAzNzMzMzMzMzMzMzMzMztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjQwIiBjeT0iOCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDIiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzIyMiIgc3R5bGU9Im9wYWNpdHk6MC4xMTUzMzMzMzMzMzMzMztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjU2IiBjeT0iOCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMTI0IiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iOCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDgwNjY2NjY2NjY2NjY3O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNzIiIGN5PSI4IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wNTQ2NjY2NjY2NjY2NjciIC8+PGNpcmNsZSBjeD0iODgiIGN5PSI4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzIyMiIgc3R5bGU9Im9wYWNpdHk6MC4xNTtzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9Ijg4IiBjeT0iOCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDk4IiAvPjxjaXJjbGUgY3g9IjgiIGN5PSIyNCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDM3MzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iOCIgY3k9IjI0IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMiIgLz48Y2lyY2xlIGN4PSIyNCIgY3k9IjI0IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2RkZCIgc3R5bGU9Im9wYWNpdHk6MC4wMzczMzMzMzMzMzMzMzM7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSIyNCIgY3k9IjI0IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wNjMzMzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSIyNCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDcyO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSIyNCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDcyIiAvPjxjaXJjbGUgY3g9IjU2IiBjeT0iMjQiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZGRkIiBzdHlsZT0ib3BhY2l0eTowLjA4OTMzMzMzMzMzMzMzMztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjU2IiBjeT0iMjQiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjA1NDY2NjY2NjY2NjY2NyIgLz48Y2lyY2xlIGN4PSI3MiIgY3k9IjI0IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2RkZCIgc3R5bGU9Im9wYWNpdHk6MC4xMjQ7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI3MiIgY3k9IjI0IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wODkzMzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iODgiIGN5PSIyNCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDg5MzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iODgiIGN5PSIyNCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDU0NjY2NjY2NjY2NjY3IiAvPjxjaXJjbGUgY3g9IjgiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDYzMzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iOCIgY3k9IjQwIiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wNzIiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDk4O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI0MCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDIiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMTU7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjQwIiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wNjMzMzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDk4O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI0MCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMTE1MzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iNzIiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDM3MzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNzIiIGN5PSI0MCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMTUiIC8+PGNpcmNsZSBjeD0iODgiIGN5PSI0MCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDQ2O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iODgiIGN5PSI0MCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDgwNjY2NjY2NjY2NjY3IiAvPjxjaXJjbGUgY3g9IjgiIGN5PSI1NiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDU0NjY2NjY2NjY2NjY3O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iOCIgY3k9IjU2IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wNDYiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI1NiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDYzMzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI1NiIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMTA2NjY2NjY2NjY2NjciIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSI1NiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMTA2NjY2NjY2NjY2Njc7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjU2IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wNjMzMzMzMzMzMzMzMzMiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI1NiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDQ2O3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI1NiIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDU0NjY2NjY2NjY2NjY3IiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iNTYiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMjIyIiBzdHlsZT0ib3BhY2l0eTowLjA4MDY2NjY2NjY2NjY2NztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iNTYiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA0NiIgLz48Y2lyY2xlIGN4PSI4OCIgY3k9IjU2IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzIyMiIgc3R5bGU9Im9wYWNpdHk6MC4xNTtzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9Ijg4IiBjeT0iNTYiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjAzNzMzMzMzMzMzMzMzMyIgLz48Y2lyY2xlIGN4PSI4IiBjeT0iNzIiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMjIyIiBzdHlsZT0ib3BhY2l0eTowLjExNTMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iOCIgY3k9IjcyIiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wOTgiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI3MiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDYzMzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iMjQiIGN5PSI3MiIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMTUiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSI3MiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDI7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjcyIiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wOTgiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI3MiIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiNkZGQiIHN0eWxlPSJvcGFjaXR5OjAuMDcyO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI3MiIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDYzMzMzMzMzMzMzMzMzIiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iNzIiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZGRkIiBzdHlsZT0ib3BhY2l0eTowLjA1NDY2NjY2NjY2NjY2NztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iNzIiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjA4OTMzMzMzMzMzMzMzMyIgLz48Y2lyY2xlIGN4PSI4OCIgY3k9IjcyIiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2RkZCIgc3R5bGU9Im9wYWNpdHk6MC4wODkzMzMzMzMzMzMzMzM7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI4OCIgY3k9IjcyIiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4xMjQiIC8+PGNpcmNsZSBjeD0iOCIgY3k9Ijg4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2RkZCIgc3R5bGU9Im9wYWNpdHk6MC4wNTQ2NjY2NjY2NjY2Njc7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSI4IiBjeT0iODgiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjA4OTMzMzMzMzMzMzMzMyIgLz48Y2lyY2xlIGN4PSIyNCIgY3k9Ijg4IiByPSI2LjY2NjY2NjY2NjY2NjciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2RkZCIgc3R5bGU9Im9wYWNpdHk6MC4wNzI7c3Ryb2tlLXdpZHRoOjIuNjY2NjY2NjY2NjY2N3B4OyIgLz48Y2lyY2xlIGN4PSIyNCIgY3k9Ijg4IiByPSIzLjMzMzMzMzMzMzMzMzMiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wNzIiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSI4OCIgcj0iNi42NjY2NjY2NjY2NjY3IiBmaWxsPSJub25lIiBzdHJva2U9IiMyMjIiIHN0eWxlPSJvcGFjaXR5OjAuMDYzMzMzMzMzMzMzMzMzO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNDAiIGN5PSI4OCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDM3MzMzMzMzMzMzMzMzIiAvPjxjaXJjbGUgY3g9IjU2IiBjeT0iODgiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZGRkIiBzdHlsZT0ib3BhY2l0eTowLjAyO3N0cm9rZS13aWR0aDoyLjY2NjY2NjY2NjY2NjdweDsiIC8+PGNpcmNsZSBjeD0iNTYiIGN5PSI4OCIgcj0iMy4zMzMzMzMzMzMzMzMzIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDM3MzMzMzMzMzMzMzMzIiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iODgiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMjIyIiBzdHlsZT0ib3BhY2l0eTowLjA5ODtzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9IjcyIiBjeT0iODgiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjE1IiAvPjxjaXJjbGUgY3g9Ijg4IiBjeT0iODgiIHI9IjYuNjY2NjY2NjY2NjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZGRkIiBzdHlsZT0ib3BhY2l0eTowLjA1NDY2NjY2NjY2NjY2NztzdHJva2Utd2lkdGg6Mi42NjY2NjY2NjY2NjY3cHg7IiAvPjxjaXJjbGUgY3g9Ijg4IiBjeT0iODgiIHI9IjMuMzMzMzMzMzMzMzMzMyIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA4MDY2NjY2NjY2NjY2NyIgLz48L3N2Zz4=" ),
	),
	),	
		

);




if(THEME_KEY != "cp"){

unset($plugins[1]['data']['wlt_icodes']);

}

if(THEME_KEY != "cm"){

unset($plugins[1]['data']['datafeedr-api']);
unset($plugins[1]['data']['datafeedr-comparison-sets']);

}

?>

<div class="tab-content">
  <?php foreach($plugins as $f){ ?>
  <?php if(isset($f['name'])){  


$settings = array("title" => $f['name'], "desc" => $f['desc']);
_ppt_template('framework/admin/_form-wrap-top' ); ?>
  <div class="card card-admin">
    <div class="card-body">
      <?php $i=1; foreach($f['data'] as $key => $p){ ?>
      <div class="row <?php if( $i != 1){ ?>border-top pt-3<?php } ?>">
        <div class="col-md-3"> <a class="media-left" href="#"> <img src="<?php echo $p['i']; ?>" style="width:100px;" /> </a> </div>
        <div class="col-md-8">
          <h5><?php echo $p['t']; ?></h5>
          <div class="text-muted small"><?php echo $p['d']; ?></div>
          
          <?php if($key == "plugindownload"){ ?>
          
            <a href="https://www.premiumpress.com/plugins/?license=<?php echo get_option('ppt_license_key'); ?>" class="btn btn-system btn-md shadow-sm mt-3 mb-3" target="_blank"><?php echo __("Visit Page","premiumpress"); ?></a> 
          
          <?php }else{ ?>
          
          <a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=<?php echo $key; ?>" class="btn btn-system btn-md shadow-sm mt-3 mb-3"><?php echo __("Install Now","premiumpress"); ?></a> 
          
          <?php } ?>
          
          </div>
      </div>
      <div class="clearfix"></div>
      <?php $i++; }?>
    </div>
  </div>
  <?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
  <?php } ?>
  <?php }?>
</div>
<?php

_ppt_template('framework/admin/footer' ); 

?>