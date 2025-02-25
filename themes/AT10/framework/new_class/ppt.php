<?php


class framework extends framework_mobile {


	function funs(){
	
		$config = array(
		
			"orders" => true,
		);	
		
		return hook_v9_corefuns($config); 
	
	} 
	
	// START REMOVING WIDGETS FROM WP
	function unregister_widgets() {	 global $wpdb; 
			 
			 
			register_widget( 'core_widget_blank' );
			register_widget( 'core_widget_blog_search' );
			register_widget( 'core_widget_blog_categories' );
			register_widget( 'core_widget_blog_recent' );	
			
			register_widget( 'core_widget_menu' );	
			
			
			if(defined('THEME_KEY') && THEME_KEY == "cp"){
				
				register_widget( 'core_widget_coupon_pop' );
			
			}	 
			 
			// REMOVE
			unregister_widget('WP_Widget_Pages');
			unregister_widget('WP_Widget_Calendar');
			unregister_widget('WP_Widget_Archives');
			//unregister_widget('WP_Widget_Links');
			unregister_widget('WP_Widget_Meta');
			unregister_widget('WP_Widget_Search');
			unregister_widget('WP_Widget_Categories');
			unregister_widget('WP_Widget_Recent_Posts');
			unregister_widget('WP_Widget_Recent_Comments');
			unregister_widget('WP_Widget_Tag_Cloud');
			unregister_widget('WP_Widget_RSS');
			unregister_widget('WP_Widget_Akismet');
			unregister_widget('WP_Nav_Menu_Widget'); 
		 
	}	
	 
	// START TAXONOMIES
	function taxonomies(){
	   
			// CUSTOM SLUG
			if(strlen(get_option('premiumpress_custompermalink')) > 1){ $listing_slug_name = get_option('premiumpress_custompermalink'); }else{ $listing_slug_name = THEME_TAXONOMY; }	
		 
	 		if(strlen(get_option('premiumpress_customcategorypermalink')) > 1){ $cat_slug_name = get_option('premiumpress_customcategorypermalink'); }else{ $cat_slug_name = $listing_slug_name."-category"; }	
			
			// REGISTER MAIN LISTING TAXONOMY
			$listing_title = $this->LAYOUT("captions","1"); 
			 		
			
			// SHOW UI OPTIONS
			$showUI = true;
			if(get_option('ppt_license_key') == ""){ $showUI = false; }			
			
			// WP CODE TO REGISTER 			 
			register_taxonomy( THEME_TAXONOMY, THEME_TAXONOMY.'_type', array( 	
			 
			'labels' => array(
				'name' => 'Categories' ,
				'singular_name' =>  $listing_title.' Category',
				'search_listings' =>   'Search '.$listing_title.' Categorys' ,
				'popular_listings' =>  'Popular '.$listing_title.' Categorys' ,
				'all_listings' => 'All '.$listing_title.' Categorys' ,
				'parent_listing' => null,
				'parent_listing_colon' => null,
				'edit_listing' =>'Edit '.$listing_title.' Category' , 
				'update_listing' =>  'Update '.$listing_title.' Category' ,
				'add_new_listing' =>  'Add '.$listing_title.' Category' ,
				'new_listing_name' => 'New '.$listing_title.' Category Name' ,
				'separate_listings_with_commas' => 'Separate '.$listing_title.' Categorys with commas' ,
				'add_or_remove_listings' =>  'Add or remove '.$listing_title.' Categorys',
				'choose_from_most_used' =>  'Choose from the most used '.$listing_title.' Categorys' 
				) , 
					'hierarchical' => true,	
					'query_var' => true,
					'show_ui' => $showUI,
					'has_archive' => true, 
					'rewrite' => array('slug' => $cat_slug_name) ) ); 
	 
			// CORE LISTING POST TYPE			
			register_post_type( THEME_TAXONOMY.'_type',
				array(
				  'labels' 				=> array('name' => $listing_title, 'singular_name' => 'listings' ), 
				  'rewrite'				=>  array('slug' => $listing_slug_name ),
				  'public' 				=> true,
				  'publicly_queryable'  => true,
				  'supports' 			=> array ( 'title', 'editor','author', 'post-formats', 'comments','excerpt', 'thumbnail', 'custom-fields', 'publicize', 'wpcom-markdown' ),
				  'taxonomies' => array('category', 'post_tag'),
				  'menu_icon' 			=> "dashicons-schedule", 
				  'show_ui'             => $showUI,
				  'menu_position'		=> 4,
				  'show_in_menu'        => true,
        		  'show_in_nav_menus'   => true,
				 				  
				)
			  );
			  
			 /** Status ******************************************************************/
			register_post_status( 'payment', array(
				'label'                     => __("Waiting Payment","premiumpress"),
				'public'                    => true,
				'label_count'               => "",
				'post_type'                 => array( 'listing_type' ), // Define one or more post types the status can be applied to.
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				  'label_count'               => _n_noop( 'Waiting Payment <span class="count">(%s)</span>', 'Waiting Payment <span class="count">(%s)</span>' ),    
				'show_in_metabox_dropdown'  => true,
				'show_in_inline_dropdown'   => true,
				'dashicon'                  => 'dashicons-yes',
			) );
			
			register_post_status( 'pending_approval', array(
				'label'                     => __("Pending Approval","premiumpress"),
				'public'                    => true,
				'label_count'               => "",
				'post_type'                 => array( 'listing_type' ), // Define one or more post types the status can be applied to.
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'show_in_metabox_dropdown'  => true,
				'label_count'               => _n_noop( 'Pending Approval <span class="count">(%s)</span>', 'Pending Approval <span class="count">(%s)</span>' ),    
				'show_in_inline_dropdown'   => true,
				'dashicon'                  => 'dashicons-yes',
			) );
			
			register_post_status( 'expired', array(
				'label'                     => __("Expired","premiumpress"),
				'public'                    => true,
				'label_count'               => "",
				'post_type'                 => array( 'listing_type' ), // Define one or more post types the status can be applied to.
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'show_in_metabox_dropdown'  => true,
				'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),    
				'show_in_inline_dropdown'   => true,
				'dashicon'                  => 'dashicons-yes',
			) );
			
			
			
			 
			  
		
		$ppt_core_types = array(
		
			'ppt_offer' 		=> array("name" => "Offers", 	"slug" => "offer"),
			'ppt_message' 		=> array("name" => "Messages", 	"slug" => "message"),
			'ppt_logs' 			=> array("name" => "Logs", 		"slug" => "log"),
			'ppt_orders' 		=> array("name" => "Orders", 	"slug" => "order"),
			'ppt_cashout' 		=> array("name" => "Cashout", 	"slug" => "cashout"),
			'ppt_banner' 		=> array("name" => "Banners", 	"slug" => "banner"),
			'ppt_campaign' 		=> array("name" => "Campaigns", "slug" => "campaign"),
			'ppt_feedback' 		=> array("name" => "Feedback", 	"slug" => "feedback"),
			'ppt_newsletter' 	=> array("name" => "Subscribers", "slug" => "subscribers"),		
		);
		
		if(defined('THEME_KEY') && THEME_KEY == "cp"){		
		$ppt_core_types['ppt_cashback'] 	= array("name" => "Cashback", 	"slug" => "cashback");
		}
		
		$showallme = false;
		if(isset($_GET['showalltax'])){ 
		
		$showallme = true;
		}
		 
		
		foreach($ppt_core_types as $k => $t){
		 
			register_post_type( $k , 
					array(
					'hierarchical' 			=> true,	
					  'labels' 				=> array('name' => $t['name'] ),
					  'public' 				=> false, // dont change this
					  'query_var' 			=> true,
					  'exclude_from_search' => true,
					  'show_ui' 			=> $showallme, // dont show UI
					  'rewrite' 			=> array('slug' => $t['slug'])	,
					  'menu_icon' 			=> "dashicons-format-chat",
					  'supports' 			=> array ( 'title',  'custom-fields'  ), 
			) );
			
		}
		  
	}
	 
	function custom_taxonomies(){
	
	
		global $wpdb, $CORE;
		// GET SAVED DAT
		$tax = get_option('custom_taxonomy'); 
		   
		if(is_array($tax)){
			foreach($tax as $tt){
		 
			if($tt != "" && strlen($tt) > 2){
				
				$NewTax = strtolower(htmlspecialchars(str_replace(" ","-",str_replace("&","",str_replace("'","",str_replace('"',"",str_replace('/',"",str_replace('\\',"",strip_tags($tt)))))))));
				 
				
				$taxname =  $CORE->GEO("translation_tax_key", str_replace(" ","-",$tt));
				 
				$labels = array(
				'name' =>   $taxname,
				'singular_name' =>  $taxname,
				'search_items' =>  __( 'Search','premiumpress')." ".$taxname ,
				'all_items' => __( 'All','premiumpress')." ".$taxname ,
				'parent_item' => __( 'Parent','premiumpress')." ".$taxname ,
				'parent_item_colon' => __( 'Parent','premiumpress')." ".$taxname ,
				'edit_item' => __( 'Edit','premiumpress')." ".$taxname ,
				'update_item' => __( 'Update','premiumpress')." ".$taxname ,
				'add_new_item' => __( 'Add New','premiumpress')." ".$taxname ,
				'new_item_name' => __( 'New','premiumpress')." ".$taxname ,
				'menu_name' => $taxname,	  ); 
				
				 register_taxonomy( $NewTax, THEME_TAXONOMY.'_type', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => true ) );  
			
				}
			
			}
		}
	}

	 
	 
	// REGISTER WIDGETS
	function register_widgets(){ global $pagenow, $page;
	  
 		 
		if ( function_exists('register_sidebar') ){		
		
 			$sidebars = array(
			
				"blog" => array( "name" => "Blog - Sidebar"),
			 	"page" => array( "name" => "Page - Sidebar"),
			 	
			);
		 
			foreach($sidebars as $key => $side){			
			
				register_sidebar(array('name'=> $side['name'],
					'before_widget' => '<div class="widget"><div class="widget-wrap"><div class="widget-block">',
					'after_widget' 	=> '<div class="clearfix"></div></div></div></div>',				
					'before_title' 	=> '<div class="widget-title"><div class="widget-content">',
					'after_title' 	=> '</div></div>',					
					'description' => '',
					'id'            => $key,
				));
			
			}

			
			
			
			// EXRA FOR FOOTER
			$sidebars = array(
			
		 	"search_sidebar" => array( "name" => "Search - Sidebar"),
			"search_top" => array( "name" => "Search - Top"),
			"search_bottom" => array( "name" => "Search - Bottom"),
			
							
			);
		
			foreach($sidebars as $key => $side){		
				
				register_sidebar(array('name'=> $side['name'],
					'before_widget' => '<div class="blank-widget">',
					'after_widget' 	=> '</div>',				
					'before_title' 	=> '<h5>',
					'after_title' 	=> '</h5>',					
					'description' 	=> '',
					'id'            => $key,
					));
			}	 		
				
				
			// EXRA FOR SINGLE PAGE
			$sidebars = array(
			
		 	"single_sidebar" => array( "name" => "Listing - Sidebar"),		 
			"single_middle" => array( "name" => "Listing - Middle"),
			
							
			);
		
			foreach($sidebars as $key => $side){		
				
				register_sidebar(array('name'=> $side['name'],
					'before_widget' => '<div class="blank-widget">',
					'after_widget' 	=> '</div>',				
					'before_title' 	=> '<h5>',
					'after_title' 	=> '</h5>',					
					'description' 	=> '',
					'id'            => $key,
					));
			}	 	
		
			// EXRA FOR FOOTER
			$sidebars = array(
			
			"footer1" => array( "name" => "Footer Block - 1"),
			"footer2" => array( "name" => "Footer Block - 2"),
			"footer3" => array( "name" => "Footer Block - 3"),
					 					
			);
		
			foreach($sidebars as $key => $side){		
				
				register_sidebar(array('name'=> $side['name'],
					'before_widget' => '<div class="footer-widget">',
					'after_widget' 	=> '</div>',				
					'before_title' 	=> '<h5>',
					'after_title' 	=> '</h5>',					
					'description' 	=> '',
					'id'            => $key,
					));
			}	  
			
				
				 
				
			// SET THE UNREGISTER WIDGET FLAG
			add_action( 'widgets_init', array($this, 'unregister_widgets' ) );	
		
		}	
	}
	
 
  
 	 

}

?>