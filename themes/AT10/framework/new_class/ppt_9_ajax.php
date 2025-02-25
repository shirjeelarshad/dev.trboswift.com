<?php
 
class framework_ajax extends framework_email {
 
 
function _ajax_actions(){ global $CORE, $wpdb, $userdata;



 	
	if(isset($_POST['elementor_action'])){	
	 	
		switch($_POST['elementor_action']){
		
		
			case "load_default_data": {
			
				
				$default_data = $CORE->LAYOUT("get_block_defaults", $_POST['blockid'] );
			 
				$data1 = array();
				
				if(is_array($default_data) && !empty($default_data) ){	
							 
					foreach($default_data as $k => $v){		 
						
						$data1[$k] = $v;					
					}
					
				}
				
				header('Content-type: application/json; charset=utf-8');
				 	
				die(json_encode(array("status" => "ok", "data" => json_encode($data1) )));	
			
			
			} break;
			
			case "load_preview": {
			
			
				// GET DATA
				 $gd = $CORE->LAYOUT("load_all_by_cat", $_POST['cat']);
				 
					  if(in_array($_POST['cat'], array('text','icon','listings','header','footer','cta','contact','video','faq','store','hero' ))){
						$order = array_column($gd, 'order'); 
						array_multisort( $order, SORT_ASC, $gd);
						}
					  
					  
					ob_start();
					foreach( $gd as $tid => $g){
					
						if($tid == $_POST['blockid']){
						
						?>
                        <div style="border-bottom:1px solid #ddd;">
                        <div style="font-size:12px; color:#ccc; font-weight:bold; margin-bottom:10px; margin-top:-30px;"> 
                        <span style="color:#666;"><?php echo $g['name']; ?></span> 
                        <span style="float:right;"><?php echo $_POST['cat']; ?></span> 
                        </div>
                        <div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;" >
                        
                        
		   <a href="javascript:void(0)" onclick="ppt_elementor_change_type('<?php echo $_POST['cat']; ?>');ppt_panel_settings()"> 
		   <img src="<?php echo $CORE->LAYOUT("get_block_prewview",  $tid ); ?>" class="img-fluid lazy" />
		   </a>
		   </div>
           
           <div style="font-size:10px; margin-bottom:10px; text-transform: uppercase;">
           
           <a href="javascript:void(0)" onclick="ppt_elementor_change_type('<?php echo $_POST['cat']; ?>');">change design</a>
           
            <a href="javascript:void(0);" onclick="UpdateBlockData(1);" style="float:right;">reset design</a>
           
           </div>
          
             <div style="margin-bottom:20px;margin-top:20px; font-size:10px; text-transform: uppercase;">
             
            <a href="javascript:void(0);" onclick="load_ppt_blocks(1);">new category</a>
             
             <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&tid=<?php echo $_POST['cat']; ?>&sid=<?php echo $tid; ?>" style="float:right;" target="_blank">preview</a>
           
             
             </div>
            
		   </div>
           
           
            
		   <?php
						}
					}	
						 
					$output = ob_get_contents();
					ob_end_clean();	 
					 
				
				header('Content-type: application/json; charset=utf-8');
				 	
				die(json_encode(array("status" => "ok", "data" => $output)));	
			
			
			} break;
			
			case "load_blocks": {
			 
				$cats_array = array();
				$code = "";
				$i=1;
				
				// BLOCK TYPES
				$block_types = array(); 
				
				foreach($CORE->LAYOUT("get_block_types",array()) as $t){ 
				 
					
					$block_types[$t['id']] = $t['name']; 
				}
		
				foreach($block_types as $typeid => $type){
				 
					$cats_array[$typeid] = $typeid;
					
					$extracss = "";
					if($i%2){
					$extracss = "margin-right:7px;";
					}
					$code .= "<div style='width: 48%;line-height:50px;float: left;text-align:center;border:1px solid #ddd; margin-bottom:20px;".$extracss."'><a href=\"javascript:void(0);\" onclick=\"ppt_elementor_change_type('".$typeid."');\">".str_replace("_"," ", str_replace("Listingpage","Listing Page",  str_replace("Cta","Call To Action", ucfirst($typeid))))."</a></div>";
					$i++;
				}// end types
					
				// REPORT AJAX
				header('Content-type: application/json; charset=utf-8');
					
				die(json_encode(array("status" => "ok", "data" => $code)));	
			
			} break;
			
			case "load_layouts": {
			
				// REPORT AJAX
				
					// GET DATA
				 $gd = $CORE->LAYOUT("load_all_by_cat", $_POST['cat']);
					  if(in_array($_POST['cat'], array('text','icon','listings','header','footer','cta','contact','video','faq','store','hero' ))){
						$order = array_column($gd, 'order'); 
						array_multisort( $order, SORT_ASC, $gd);
						}
					  
					  
					ob_start();
					foreach( $gd as $tid => $g){
					
					// HIDE DUPLICATES
					if(isset($g['duplicate'])){ continue; }
					
					if($tid == "listingpage_openinghours" && THEME_KEY != "dt"){
					   continue;
					 }
					 
					 if(substr($tid,0,12) == "listingpage_" && substr($tid,0,15) != "listingpage_new"){
	   
					   continue;
					   }
				
					
					?><div style="padding:5px; border:1px solid #ddd; margin-bottom:5px;" >
       <a href="javascript:void(0)" onclick="ppt_elementor_change_layout('<?php echo $tid; ?>','<?php echo $_POST['cat']; ?>');ppt_panel_settings()">
       <img src="<?php echo $CORE->LAYOUT("get_block_prewview",  $tid ); ?>" class="img-fluid lazy" />
       </a>
       </div>
       
       <div style="font-size:12px; color:#999999; margin-bottom:20px; margin-top:10px;">
	   
	   <?php echo $g['name']; ?>
	   
	   <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&tid=<?php echo $_POST['cat']; ?>&sid=<?php echo $tid; ?>" style="float:right;" target="_blank">preview</a>
	   
	   </div>
	   <?php
					}	 
					?>
                    <div style="clear:both;"></div>
                    <div  style="border:1px solid #ddd; padding:20px;width:100%; text-align:center; margin-top:20px;">
                    <a href="javascript:void(0);" onclick="load_ppt_blocks(1);">change category</a>
                    </div>
                     
                    <?php
					
					$output = ob_get_contents();
					ob_end_clean();	 
					 
				
				header('Content-type: application/json; charset=utf-8');
				 	
				die(json_encode(array("status" => "ok", "data" => $output)));	
			
			} break;
			
			
		}
		
		die();
	}
	

	if(isset($_POST['search_action'])){	
	 	
		switch($_POST['search_action']){
		
			case "get_description": {
			
				$g = _ppt(array('lst', 'cpterms')); 
				
				if($g == 2){
				echo do_shortcode("[CONTENT  pid='".$_POST['pid']."']");				
				}else{
				echo get_the_excerpt($_POST['pid'])."&nbsp;"; 
				}
			
				die();
			
			} break;
		
			case "search_live":{
		 
				if(isset($_POST['search'])){
 
					
					$ar = array();
					
					if(is_numeric($_POST['search'])){
					$args = array('post_type' => 'listing_type', 'paged'  => 1, 'p' =>  $_POST['search']  );
					}else{
					$args = array('posts_per_page' => 8, 'post_type' => 'listing_type', 'orderby' => 'name', 'order' => 'asc', 'paged'  => 1, 's' => esc_html($_POST['search']) );
					}
					
					if(defined('WLT_DEMOMODE')){
					$_POST['search'] = "";
					}
					
					// SOTRE SEARCH
					if(THEME_KEY == "cp"){
					
						
						$args = array(
							'taxonomy'      => array( 'store' ), 
							'orderby'       => 'id', 
							'order'         => 'ASC',
							'hide_empty'    => true,
							'fields'        => 'all',
							'name__like'    => $_POST['search']
						); 
						
						$terms = get_terms( $args );
						$count = count($terms);
						 if($count > 0){		
						 	$stop = 0;					
							 foreach ($terms as $term) {
							 	
								if($stop > 8){ continue; }
							 
								 $ar['mylist'][] = array(
									'id' => $term->term_id, 
									'name' => $term->name, 
									'img' => do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]'), 
									'link' => get_term_link( $term ), 
									'text' => "",
								 ); 
								 
								 $stop++; 
						
							 }							
						 }

					}
					
					
					if(empty($ar)){
					 
					 
							$custom_query = new WP_Query( $args );	
							 			 
							if ( $custom_query->have_posts() ) :
							while( $custom_query->have_posts() ) : $custom_query->the_post(); 
							 
							if(in_array($custom_query->post->post_type, array("post","page"))){							
							continue;
							}
							
							$name = get_the_title();
							if(is_numeric($_POST['search'])){
							$name = get_the_title()." (LOT ".$_POST['search'].")";
							}
							
							$ar['mylist'][] = array(
								'id' => $custom_query->post->ID, 
								'name' => $name, 
								'img' => do_shortcode('[IMAGE post_id="'.$custom_query->post->ID.'" link=0 pathonly=1]'), 
								'link' => get_permalink($custom_query->post->ID), 
								'text' => "",
							 );  
							
							endwhile; endif;
					
					}
					 
					echo json_encode($ar);
					die();
				}
			
			} break;
			 	
				case "search": {				
					
					global $settings;
					
					// DEFAULT 
					$wrap_1 = "";
					$wrap_2 = "";
					$pagenav = "";
					
					// MONITOR
					$time_start = microtime(true); 
					
					// CUSTOM  TAXONOMIES				 
					$CORE->custom_taxonomies();
					
					// SHOW EXPIRED IN SEARCH RESULTS
					if(!is_admin() && _ppt(array("search","showexpired")) == 1){
					
						$ps = array('publish','expired'); //, 'pending','pending_approval','payment'
						
					}else{
					
						$ps = array('publish');
					}
					  
				 	
					// GET FIILTER QUERY
					$args = apply_filters( 'ppt_query_args',  array('paged' => 1, 'post_type'=> 'listing_type','posts_per_page' => 2, 'post_status' => $ps )  );					
					
					
					if(!isset($args['cardtype'])){
						$args['cardtype'] = "search";					
					} 
					
					// SHOW FAVS
					$g = $CORE->_check_search_query('favorites'); 	
					if(isset($g['favorites']) ){
					$args['post_status'] = array("publish","expired");
					}
					 
					
					if(!isset($args['card'])){
						$args['card'] = "";					
					}
					
					// PER PAGE					
					if(isset($args['perpage']) && is_numeric($args['perpage']) ){						
						$args['posts_per_page'] = $args['perpage'];
					}
					
					// CARD 					
					if(isset($args['card']) && $args['card'] != ""){						
						$settings['card'] = $args['card'];
					}
					
					// CARD ROW
					if(!isset($args['cardrow'])){
						$args['cardrow'] = 4;					
					}
					
					// PAGED
					if(!isset($args['paged']) || isset($args['paged']) && $args['paged'] == ""){ 
						$args['paged'] = $args['pagenum'];					
					}
					 
					// QUERY WHICH POST TYPE
					if(function_exists('current_user_can') && (current_user_can('dealer') || current_user_can('administrator')) ){
						switch($args['cardtype']){						
							case "admin-cashout": { 	$args['post_type'] = "ppt_cashout"; } break;
							case "admin-cashback": { 	$args['post_type'] = "ppt_cashback"; } break;
							case "admin-order": { 		$args['post_type'] = "ppt_orders"; } break;
							case "admin-log": { 		$args['post_type'] = "ppt_logs"; } break;
							case "admin-newsletter": { 	$args['post_type'] = "ppt_newsletter"; } break;
							case "admin-advertising": { $args['post_type'] = "ppt_campaign"; } break;	
							case "admin-banner": { 		$args['post_type'] = "ppt_banner"; } break;	
												
						}
					}
					
				 
				 	 	
					// QUERY CHANGES
					if($args['cardtype'] == "admin-user" && function_exists('current_user_can') && (current_user_can('dealer') || current_user_can('administrator')) ){
					 
						$args['number'] = $args['posts_per_page'];
						
						$wp_custom_query = new WP_User_Query($args);
						$totalfound = count($wp_custom_query->results);  
						
						$result = count_users();
						$totalfound = $result['total_users'];
						 
					   
					}else{
					 				
						$wp_custom_query = new WP_Query($args); 
						$totalfound = $wp_custom_query->found_posts;
					
					}
				 	   
					  	  
					// COUNT EXISTING LISTINGS 
					$tt = $wpdb->get_results($wp_custom_query->request, OBJECT);
					$SQLBACKUP = $wp_custom_query->request;
					 
					// BUILD CARD OUTPPUT
					switch($args['cardtype']){
											  
						  	case "admin-advertising": {							
								$card_name = 'framework/admin/parts/card-advertising';							
							} break;							
							case "admin-banner": {							
								$card_name = 'framework/admin/parts/card-banner';							
							} break;							
							case "admin-newsletter": {							
								$card_name = 'framework/admin/parts/card-newsletter';								
							} break;						  
						  	case "admin-listing": {							
								$card_name = 'framework/admin/parts/card-listing';								
							} break;							
							case "admin-log": {							
								$card_name = 'framework/admin/parts/card-log';								
							} break;							
						  	case "admin-order": {							
								 $card_name = 'framework/admin/parts/card-order';								
							} break;	
							case "admin-cashout": {							
								 $card_name = 'framework/admin/parts/card-cashout';								
							} break;	
							case "admin-cashback": {							
								 $card_name = 'framework/admin/parts/card-cashback';								
							} break;												
						  	case "admin-user": {							
								 $card_name = 'framework/admin/parts/card-user';								
							} break;							
							case "search": {
								
								$card_name = 'content-listing';	
								
								
								// CHANGE FOR GRID 4								 
								if( $CORE->LAYOUT("captions","perrow") == 3 && isset($args['cardlayout']) && in_array($args['cardlayout'], array("grid4","grid4a"))  ){
									$args['cardlayout'] = "grid3";								
								}
								
								
								if(isset($args['cardlayout']) && $args['cardlayout'] == "list1"){
								 	
									$settings['card'] = "list";
									
									if(in_array(THEME_KEY, array("es")) ){
									$wrap_1 = '<div class="col-6 col-md-12 col-lg-12">';
									}else{
									$wrap_1 = '<div class="col-6 col-md-12 col-lg-12">';
									}
																	
									$card_name = 'content-listing';
									$wrap_2 = '</div>'; 
									
									if(THEME_KEY == "ph"){
									
									$wrap_1 = '';								
									$card_name = 'content-listing';
									$wrap_2 = '';
									}
									
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "list2"){
								 	
									$settings['card'] = "list-small";
									
									$wrap_1 = '<div class="col-6 col-md-6 perrow2">';								
									$card_name = 'content-listing';
									$wrap_2 = '</div>'; 	
									
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "list3"){
								 	
									$settings['card'] = "list-small";
									
									$wrap_1 = '<div class="col-6 col-md-4 perrow3">';								
									$card_name = 'content-listing';
									$wrap_2 = '</div>'; 
									 
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "grid5"){
								
									$wrap_1 = '<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">';
									$card_name = 'content-listing';
									$wrap_2 = '</div>';
								
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "grid4"){
								
									$wrap_1 = '<div class="col-6 col-sm-6 col-md-6 col-lg-3 perrow4">';
									$card_name = 'content-listing';
									$wrap_2 = '</div>';	
									
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "grid4a"){
								
									$wrap_1 = '<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 perrow4">';
									$card_name = 'content-listing';
									$wrap_2 = '</div>';								
								 
								}elseif(isset($args['cardlayout']) && $args['cardlayout'] == "grid3"){
								
									$wrap_1 = '<div class="col-6 col-sm-6 col-md-6 col-lg-4 perrow3">';
									$card_name = 'content-listing';
									$wrap_2 = '</div>';								
								}
								
								 
							} break;							
					}
					
					$saved_args = $args;
					
					 
					$GLOBALS['ajax_search'] = 1;
					
					// START OUTPUT
					ob_start();					
					if(!empty($tt)){						
						$counter = 1;	
						foreach($tt as $p){	 global $post;
						 
						 
						// HACK FOR DISTANCE ADDON
						if(isset($p->distance)){							
							$GLOBALS['distance_value'] = $p->distance;								 
							$g = $CORE->_check_search_query('radius'); 	
							if( isset($g['radius']) && $g['radius']  > 0 &&  round($p->distance,0) > round($g['radius'],0)   ){
							 	$totalfound--;
								$counter++;	
								continue;							
							} 
						}
						 					
						if($args['cardtype'] == "admin-user" ){
						 
						 $post = get_userdata($p->ID);	
						 }else{
						 $post = get_post($p->ID);
						 }
						 
						if($counter == 1){ 
							if($args['cardtype'] == "admin-order" || $args['cardtype'] == "admin-listing" || $args['cardtype'] == "admin-user" ){
							}else{
							echo '<div class="row">';
							}
						}
						
						echo $wrap_1;				
						_ppt_template($card_name);	
						echo $wrap_2;
						
						$counter++;										
						}						
					}
					// MAIN LISTING OUTPUT
					$output = ob_get_contents();ob_end_clean();					
					
					 // FOOTER
					if($saved_args['cardtype'] == "admin-order" || $saved_args['cardtype'] == "admin-listing"  || $saved_args['cardtype'] == "admin-user" ){							 
					}else{
					$output .= '</div>';
					}	
					
					// CHECK FOR OUTPUT DATA ERROR
					if(strlen($output) < 20){
						$totalfound = 0;
					}
					
					//////////////////////////// -- ONLY DO ADDON DATA IF OUTPUT IS BIGGER THAN 0
					if(strlen($output) > 10){
					 
						ob_start();
							
							// TABLE STYLE FOOTER					
							if($totalfound >  $saved_args['posts_per_page']){
												
								$pagenav = $CORE->_filter_ajax_nav($totalfound, $saved_args['posts_per_page'], $saved_args['paged'] );
							} 					 
				 	
					 
							if(in_array($card_name, array("content-listing" )) && _ppt(array('search','count')) != 1 && $totalfound < 150 ){	
							 
							// BUILD A NEW SEARCH QUERY WITH MORE RESULTS AND USE THESE
							// TO SETUP THE COUNTER STATS
							$newquery = explode("LIMIT", $wp_custom_query->request);					
							$xx = $wpdb->get_results($newquery[0]." limit 150", OBJECT);
							if(!empty($xx)){
							
								$taxonomies = get_taxonomies(); 
								foreach($xx as $c){
								
									$catID = "";
									
									$ThisPostID = $c->ID;
								
									  // GET CATID
									  $catID = "";
									  $cat =  wp_get_object_terms( $ThisPostID , THEME_TAXONOMY );
									   
									  if(is_array($cat)){
										foreach($cat as $k => $v){
										
											if($v->parent !=0){
											$catID .= "catid-".$v->parent." ";	
											}
											
											$catID .= "catid-".$v->term_id." ";					
										}
										
										
									  }
									  
									  // GET TAX 
									  if(is_array(_ppt('searchtax'))  ){		
									  
														
										  foreach ( $taxonomies as $taxonomy ) {  	
													  
											  if(in_array($taxonomy, _ppt('searchtax')) ){									  							  
												  $tax = wp_get_post_terms( $ThisPostID, $taxonomy );										
												  if(is_array($tax)){
													  foreach($tax as $k => $v){
														 $catID .= $taxonomy."-".$v->term_id." ";	
																	
													  }
												  }
											  } 
										  } 
									  }
									  
									  // DATE INTO (A/B/C/)
									  //$vv = $CORE->date_timediff($map->post_date);	      	
									  if(isset($vv['date_array']["".__('Years',"premiumpress").""]) && $vv['date_array']["".__('Years',"premiumpress").""] > 0){
									  $dID = "date-t5";							  
									  }elseif(isset($vv['date_array']["".__('years',"premiumpress").""]) && $vv['date_array']["".__('years',"premiumpress").""] > 0){
									  $dID = "date-t5";								
									  }elseif(isset($vv['date_array']["".__('Months',"premiumpress").""]) && $vv['date_array']["".__('Months',"premiumpress").""] > 0){
									  $dID = "date-t4";							  
									  }elseif(isset($vv['date_array']["".__('months',"premiumpress").""]) && $vv['date_array']["".__('months',"premiumpress").""] > 0){
									  $dID = "date-t4"; 							  
									  }elseif(isset($vv['date_array']["".__('Days',"premiumpress").""]) &&  $vv['date_array']["".__('Days',"premiumpress").""] > 0){
									  $dID = "date-t3";							  
									  }elseif(isset($vv['date_array']["".__('days',"premiumpress").""]) &&  $vv['date_array']["".__('days',"premiumpress").""] > 0){
									  $dID = "date-t3";							  
									  }elseif(isset($vv['date_array']["".__('Hours',"premiumpress").""]) &&  $vv['date_array']["".__('Hours',"premiumpress").""] > 0){ 
									  $dID = "date-t2";							  
									  }elseif(isset($vv['date_array']["".__('hours',"premiumpress").""]) &&  $vv['date_array']["".__('hours',"premiumpress").""] > 0){ 
									  $dID = "date-t2";							  
									  }else{
									  $dID = "date-t1";
									  }
									  
									?><div class="addondata <?php echo $catID; ?> <?php echo $dID; ?>"></div><?php 
								
								}
								}
						}
						
						$output .= ob_get_contents();ob_end_clean(); 
					
					} 
					unset($GLOBALS['ajax_search']);
				
				//print_r($saved_args);
				//echo $wp_custom_query->request;
			 	//die();
					
					
					
					// SPONSORED OUTPUT	*******************************************************/					 
					$output_sponsor = "";	
					
					if(!isset($_POST['search_data'])){ $_POST['search_data'] = ""; }
					
					if( $totalfound >  3 && in_array($card_name, array("content-listing" )) && strpos($_POST['search_data'], "sortby:price") === false && strpos($_POST['search_data'], "sortby:expiry") === false ){	
					 
					 
					 	$GLOBALS['ajax_sponsored'] = 1;
						
						// GET FIILTER QUERY
						$args = apply_filters( 'ppt_query_args',  array('paged' => 1, 'post_type'=> 'listing_type','posts_per_page' => 2, 'post_status' => 'publish' )  );				 	 	
						
						if( $CORE->LAYOUT("captions","perrow") == 3 && isset($args['cardlayout']) && in_array($args['cardlayout'], array("grid4","grid4a"))  ){
						 $args['posts_per_page'] = 3;
						}elseif(isset($args['cardlayout']) && in_array($args['cardlayout'], array("grid4","grid4a")) ){
						$args['posts_per_page'] = 4;
						}elseif(isset($args['cardlayout']) && in_array($args['cardlayout'], array("grid5")) ){
						$args['posts_per_page'] = 6;
						}elseif(isset($args['cardlayout']) && in_array($args['cardlayout'], array("list2")) ){
						$args['posts_per_page'] = 4;
						}else{
						$args['posts_per_page'] = 3;
						}
						
						
						$args['orderby'] = "rand";
						$args['meta_query']["sponsored"]  = array(							
							'key' => "sponsored",							 				
							'value' => "1",
							'compare'=> '='						
						);					
						$wp_custom_query = new WP_Query($args); 
						$totalsponsorfound = $wp_custom_query->found_posts;
						 	  
						// COUNT EXISTING LISTINGS 
						if($totalsponsorfound > 0){
							$tt = $wpdb->get_results($wp_custom_query->request, OBJECT);
							$GLOBALS['ajax_search'] = 1;
							ob_start();	
							?>
							<h6><?php echo __("sponsored ads","premiumpress"); ?></h6>
                            <div class="row">
							<?php
							
							foreach($tt as $p){	 global $post, $args;
							$post = get_post($p->ID);	 
							
							if(get_post_meta($p->ID, "paymentdue", true) == "1"){
							continue;
							}
							
							
							// HACK FOR DISTANCE ADDON
						if(isset($p->distance)){							
							$GLOBALS['distance_value'] = $p->distance;								 
							$g = $CORE->_check_search_query('radius'); 	
							if( isset($g['radius']) && $g['radius']  > 0 &&  round($p->distance,0) > round($g['radius'],0)   ){
							 	$totalfound--;
								$counter++;	
								continue;							
							} 
						}
							
							echo $wrap_1;				
							_ppt_template($card_name);	
							echo $wrap_2;																
							}
							 				
							?>
                            </div><hr />
                            <?php
							 	
							$output_sponsor = ob_get_contents();ob_end_clean();	
							unset($GLOBALS['ajax_search']);
						} // end
						
						unset($GLOBALS['ajax_sponsored']);
					
					}
					$output_sponsor = trim($output_sponsor);
					
					//****************************************************************************/ 
					
					// REMOVE LAZYLOAD
					$output = str_replace("data-src","src", str_replace("img-fluid lazy","img-fluid", $output ) );
					$output_sponsor = str_replace("data-src","src",  str_replace("img-fluid lazy","img-fluid", $output_sponsor ) );
					
					// MONITOR
					$time_end = microtime(true);
					$execution_time = ($time_end - $time_start)/60;
					
					// PAGES
					$totalPages = ceil($totalfound/$saved_args['posts_per_page']);	
					
					// REPORT AJAX
					header('Content-type: application/json; charset=utf-8');
					
					$output = $output;
					
					// HIDE SQL
				 	if(!current_user_can('administrator')){
					$SQLBACKUP = "";
					}
					
					
					// LOCATION ADD-ON
					$location_output = "";
					if(isset($GLOBALS['search_google_address']) && $GLOBALS['search_google_address'] != ""){
						$location_output = array(
						"address" => $GLOBALS['search_google_address'], 
						"lat" => $GLOBALS['search_google_lat'], 
						"long" => $GLOBALS['search_google_long']
						);
					} 
					
					die(json_encode(array(
					"status" 	=> "ok", 
					"total" 	=> number_format($totalfound), 
					"sponsor" 	=> $output_sponsor,
					"output" 	=> $output,
					"pagenav" 	=> $pagenav,
					"location"  => $location_output,
					"page" 		=> $saved_args['paged'],
					"pageof" 	=> $totalPages,
					"sql" 		=> $SQLBACKUP,
					"time" 		=> $execution_time." Mins"), JSON_PARTIAL_OUTPUT_ON_ERROR )); //JSON_PARTIAL_OUTPUT_ON_ERROR
		
				
				} break;
		}
	}


 


	/// SET USER LOCATION
	if(isset($_POST['updatemylocation'])){				
		$_SESSION['mylocation']['log'] = strip_tags($_POST['log']);
		$_SESSION['mylocation']['lat'] = strip_tags($_POST['lat']);
		$_SESSION['mylocation']['zip'] = strip_tags($_POST['zip']);
		$_SESSION['mylocation']['country'] = strip_tags($_POST['country']);
		$_SESSION['mylocation']['address'] = strip_tags($_POST['myaddress']);
	}

 

		// CUSTOM COMMENTS SHORTCODE
		if(isset($_POST['commentsform']) && isset($_POST['pid']) && is_numeric($_POST['pid']) && $userdata ){
		 
		
			if(strlen($_POST['comment']) > 0 ){
			 
			 
			$time = current_time('mysql');	
			$data = array(
				'comment_post_ID' => $_POST['pid'],
				'comment_author' => $userdata->display_name,
				'comment_author_email' => 'admin@admin.com',
				'comment_author_url' => 'http://',
				'comment_content' => strip_tags($_POST['comment']),
				'comment_type' => '',
				'comment_parent' => 0,
				'user_id' => $userdata->ID,
				'comment_author_IP' => $this->get_client_ip(),
				'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date' => $time,
				'comment_approved' => 0,
			);
			
			wp_insert_comment($data);			 
			
			}
		
		}


	//CHECK FOR OUTBOUT LINKS
	if(strpos($_SERVER['REQUEST_URI'], "/verifyme/") !== false) {	
	
			$bb = explode("verifyme/",$_SERVER['REQUEST_URI']);
			$bb1 = explode("/",$bb[1]);
			
			if(is_numeric($bb1[0])){
			
				
				update_user_meta($bb1[0],'ppt_verified',1);
				
				$link = _ppt(array('links','email_verify'));
				
				if(strlen($link) > 3){
				
				// REDIRECT				 
				header("location:".$link, true ,301);
				exit;
				
				}else{
				
				echo "<div style='display: flex;
                        justify-content: center;
                        align-content: center;
                        align-items: center;
                        height: 100vh;
                        width:100%;
                        flex-direction: column;
                        background:#03040B;
                        border-radius: 20px;
    
                '>
                <h1 style='color: white; font-size:50px'>".__("Email Verified Successfully","premiumpress")."</h1>";
				echo "<br>";
				echo "<p><a style='    
    background: green;
    color: white;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left:20px;
    padding-right:20px;
    border-radius: 10px;
    text-decoration: none;' href='"._ppt(array('links','myaccount'))."'>".__("Go to my account.","premiumpress")."</a></p></div>";
				die("");
				
				
				}
				
				
			
			}
			
	}elseif(strpos($_SERVER['REQUEST_URI'], "/outtax/") !== false) {	
		 
			$bb = explode("outtax/",$_SERVER['REQUEST_URI']);
			$bb1 = explode("/",$bb[1]);
			
			 			
			if(is_numeric($bb1[0])){
			  
				// GET LIST
				$link = _ppt('storelinkaff_'.$bb1[0]);
				 
				if($link == ""){
				$link = home_url(); 
				}				
				 
		 		if(strpos($link, "http") === false){
				$link = "http://".$link;
				}
				
				if(defined('WLT_DEMOMODE')){
					
					echo "<h1>Demo Mode</h1>";
					echo "Affiliate links are disabled in 'demo mode'.<br><br>";
					echo "<small>".$link."</small>";
					die();			
				}
			
				// REDIRECT				 
				header("location:".$link, true ,301);
				exit;
				
			}
			
	}elseif(strpos($_SERVER['REQUEST_URI'], "/outbanner/") !== false) {	
		 
			$bb = explode("outbanner/",$_SERVER['REQUEST_URI']);
			$bb1 = explode("/",$bb[1]);
			
			if(defined('WLT_DEMOMODE')){
							
				echo "<h1>Demo Mode</h1>";
				echo "Banner links are disabled in 'demo mode'.";
				die();			
			}			
			 				
			if(isset($bb1[0]) && is_numeric($bb1[0]) ){				
				 
				// UPDATE CLICK COUNTER
				update_post_meta($bb1[0], 'clicks', get_post_meta($bb1[0], 'clicks', true) + 1 );
				
				// GET LIST
				$link = get_post_meta($bb1[0], "url", true);
				if($link == ""){
					$link = get_post_meta($bb1[0], "buy_link", true);
				}	
				
				if($link == ""){
					echo "<h1>".__("Link Broken","premiumpress")."</h1>";
					echo __("We're sorry for the inconveniece. The link you are looking for is broken.","premiumpress");
					die();
				}	
				 
				if(strpos($link, "http") === false){
				$link = "http://".$link;
				}			
				 
				// REDIRECT				 
				header("location:".htmlspecialchars_decode($link), true ,301);
				exit;
				
			}	
				
	}elseif(strpos($_SERVER['REQUEST_URI'], "/out/") !== false) {	
		 
			$bb = explode("out/",$_SERVER['REQUEST_URI']);
			$bb1 = explode("/",$bb[1]);
			
							
			if(strlen($bb1[1]) > 1){
				
				// POST ID
				$GLOBALS['out_post_id'] = $bb1[0];
			 	
				// GET LIST
				$link = get_post_meta($bb1[0], $bb1[1], true);	
								
				if($link == ""){
					$link = get_post_meta($bb1[0], "buy_link", true);
				}	
				
				if($link == ""){
					echo "<h1>".__("Link Broken","premiumpress")."</h1>";
					echo __("We're sorry for the inconveniece. The link you are looking for is broken.","premiumpress");
					die();
				}						
				 
				// USED COUNT
				if(THEME_KEY == "cp"){
					$used = get_post_meta($bb1[0],'used',true);
					if($used == ""){ $used = 0; }
					update_post_meta($bb1[0],'used', $used + 1);					
					update_post_meta($bb1[0], 'lastused', current_time( 'mysql' ));
					
					// TRACK THIS USER CLICKS
					if($userdata->ID && _ppt(array('lst', 'cpcashback' )) == '1' ){
					
						$f = get_user_meta($userdata->ID,'linktracking', true);
						if(!is_array($f)){
							$f = array();
						}					
						$f[$bb1[0]] = array(
							"pid" => $bb1[0],							
							"date" => date('Y-m-d H:i:s'),
						);
												
						update_user_meta($userdata->ID,'linktracking', $f);
						 
					}elseif(!$userdata->ID && _ppt(array('lst', 'cpcashback' )) == '1' ){
					
						header("location: ".wp_registration_url());
						exit();
					}
					 
				}
				
				if(strpos($link, "http") === false){
				$link = "http://".$link;
				}
				
				 
				if(defined('WLT_DEMOMODE')){
					
					echo "<h1>Demo Mode</h1>";
					echo "Affiliate links are disabled in 'demo mode'.<br><br>";
					echo $link;
					die();
				
				}			
				  
				// REDIRECT				 
				header("location:".htmlspecialchars_decode($link), true ,301);
				exit;
				
			}		 
	}elseif (strpos($_SERVER['REQUEST_URI'], "/confirm/") !== false) {
	
			$bb = explode("confirm/",$_SERVER['REQUEST_URI']);
						
			if (strpos($bb[1], "unsubscribe/") !== false) {
			
				$be = explode("unsubscribe/",$bb[1]);				 
				$data = array(
						"email" => strip_tags($be[1]),
				);
				$CORE->EMAIL("newsletter_unsubscribe", $data);
				
				// REDIRECT USER		
				$url = _ppt(array('newsletter','unsubscribepage'));				 
				if($url == ""){ $url = home_url(); }
				header("location: ".$url);
				exit();
				
			}elseif (strpos($bb[1], "mailinglist/") !== false) {
			
				$be = explode("mailinglist/",$bb[1]);				 
				$data = array(
						"hash" => strip_tags($be[1]),
				);					
				$CORE->EMAIL("newsletter_confirm", $data);
				 
				$url = _ppt(array('newsletter','thankyoupage'));
				 
				if($url == ""){ $url = home_url(); }
				header("location: ".$url);
				exit();
				
			}		 
	}







	// LIVE EDIT CHANGES
	if(isset($_POST['liveeditlisting']) && $_POST['liveeditlisting'] == 1 && is_numeric($_POST['eid']) ){
		
		
		
		if(isset($_POST['form']['post_content']) && strlen($_POST['form']['post_content']) > 5){
			
			$my_post 					= array();
			$my_post['ID'] 				= $_POST['eid'];
			$my_post['post_content'] 	= strip_tags(strip_tags($_POST['form']['post_content']));
			wp_update_post( $my_post );
		
		}elseif(isset($_POST['form']['post_excerpt']) && strlen($_POST['form']['post_excerpt']) > 2){
			
			$my_post 					= array();
			$my_post['ID'] 				= $_POST['eid'];
			$my_post['post_excerpt'] 	= strip_tags(strip_tags($_POST['form']['post_excerpt']));
			wp_update_post( $my_post );
	 
		
		}elseif(isset($_POST['form']['post_title']) && strlen($_POST['form']['post_title']) > 5){
			
			$my_post 					= array();
			$my_post['ID'] 				= $_POST['eid'];
			$my_post['post_title'] 	= strip_tags(strip_tags($_POST['form']['post_title']));
			wp_update_post( $my_post );
		}
		
		if(THEME_KEY == "dt" && isset($_POST['startTime'])){	
			
				$businesshours = array( 'start' => $_POST['startTime'], 'end' => $_POST['endTime'], 'active' => $_POST['isActive']  );				 
				update_post_meta($_POST['eid'],"businesshours", $businesshours);								 
		}
		
		// ADD ON FOR MJ THEME
			if(in_array(THEME_KEY, array("mj","dt")) && isset($_POST['customextras']) ){
			update_post_meta($_POST['eid'], 'customextras', $_POST['customextras']);
			}	
		
	// SAVE THE CUSTOM PROFILE DATA
				if(isset($_POST['custom']) && is_array($_POST['custom'])){ 	
		
					foreach($_POST['custom'] as $key => $val){
					
						if($val == ""){					
							delete_post_meta($_POST['eid'], strip_tags($key));
						}elseif(is_array($val)){
							update_post_meta($_POST['eid'], strip_tags($key), $val);
						}else{							 
							update_post_meta($_POST['eid'], strip_tags($key), esc_html(strip_tags($val)));					
						}
					} // end foreach 
					
				}// end if
				
			if(isset($_POST['tax']) && is_array($_POST['tax'])){ 	
			 	 
				foreach($_POST['tax'] as $key => $val){ 
				
					// REGISTER IF DOESNT EXIST
					if(!taxonomy_exists($key)){
					register_taxonomy( $key, 'listing_type', array( 'hierarchical' => true, 'labels' =>'', 'query_var' => true, 'rewrite' => true ) ); 
					}
										  
					// SAVE DATA
					$g = wp_set_post_terms($_POST['eid'], $val, $key );
			
				}
			}
			 
	
	}












	if(isset($_POST['single_action'])){		
			
		switch($_POST['single_action']){
		
				case "single_claimlisting":{
				 
				// ALLOW CLAIM
				$my_post = array();
				$my_post['ID'] 					= $_POST['pid'];
				$my_post['post_status']			= "publish";
				$my_post['post_author']			= $userdata->ID;	
				wp_update_post( $my_post  );	
				
				// STORE CLAIMED
				add_post_meta($_POST['pid'], "claimed", current_time( 'mysql' ) );			 
				
				die(json_encode(array("status" => "ok")));	
				
				
				} break;
			 	
				case "single_offer_make": {
				
					if(!is_numeric($_POST['pid'])){ die(); }
					if(!$userdata->ID){ die(); }
					 		
				
					// ADD A NEW OFFER TO THE SYTEM
					$my_post = array();
					$my_post['post_title'] 		= hook_price($_POST['price'])." offer for ". get_the_title( $_POST['pid'] );
					$my_post['post_content'] 	= "";
					$my_post['post_excerpt'] 	= "";
					$my_post['post_status'] 	= "publish";
					$my_post['post_type'] 		= "ppt_offer";
					$my_post['post_author'] 	= 1;
					$POSTID 					= wp_insert_post( $my_post );
					
					// STORE POST ID
					add_post_meta($POSTID, "post_id", $_POST['pid'] );
					 
					// SAVE THE BUYERS ID
					add_post_meta($POSTID, "buyer_id", $userdata->ID); 
					
					// SAVE THE BUYERS ID
					add_post_meta($POSTID, "seller_id", $_POST['aid']); 
					
					// ADD STATUS
					if(isset($_POST['price']) && is_numeric($_POST['price'])){
						$amount = $_POST['price'];					
						update_post_meta($POSTID, "price_customoffer", $_POST['price']); 
					
					}else{					
					$amount = get_post_meta($_POST['pid'], "price", true); 
					
					}
					add_post_meta($POSTID, "price", $amount);				 
					
					
					// SKIP STEPS
					if(isset($_POST['skip_to_buy']) && in_array( THEME_KEY, array("ct","dl") ) ){
					
						update_post_meta($_POST['pid'], "status", 1);
						
						add_post_meta($POSTID, "offer_status", 3);
						add_post_meta($POSTID, "offer_complete", 1);  
					
					}else{
					
					// ADD STATUS
					add_post_meta($POSTID, "offer_status", 1);
					} 
				
					 /*
					// 3. ADD NEW ORDER/INVOICE				
					$o = $this->ORDER("add", array( 
								"order_id" => "OFFER-".$_POST['pid'],
								"order_status" 		=> 2, // pending
								"order_total" 		=> $amount,
								"order_userid" 		=> $userdata->ID,
								
					) );
							 
					$payment_id = $o['orderid'];					 
					
					update_post_meta($payment_id, 'order_id', $_POST['pid']);
					update_post_meta($payment_id, 'order_email', $CORE->USER("get_email", $userdata->ID ) );
					update_post_meta($payment_id, 'seller_id', $_POST['aid']);	
					update_post_meta($payment_id, 'buyer_id', $userdata->ID);						 
					update_post_meta($payment_id, 'offer_id', $POSTID );	
			
					// UPDATE BID WITH PAYMENT ID
					update_post_meta($POSTID, 'payment_id', $payment_id );	
					
					*/ 
						 
				 
					// ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "offer_new",	
							
							"postid"	=> $_POST['pid'],
							
							"to" 		=> $_POST['aid'], 						
							"from" 		=> $userdata->ID,
							
							"alert_uid1" 	=>  $_POST['aid'],							
							 
						)
					);
				 
					die(json_encode(array("status" => "ok", "oid" => $POSTID )));					
				
				} break;
				
				
				case "offer_close": {
				 
						// NOW CLOSE THE OFFER
						update_post_meta($_POST['job_id'], "offer_status", 3);
						update_post_meta($_POST['job_id'], "offer_complete", 5); 
						add_post_meta($_POST['job_id'], "feedback_date_seller", current_time( 'mysql' ));
						add_post_meta($_POST['job_id'], "feedback_date_buyer", current_time( 'mysql' ));
						
						update_post_meta($_POST['listing_id'],'status',1);	
				
					// UPDATE
					die(json_encode(array("status" => "ok")));
				
				} break;
				
				case "offer_refund": {
				
				 
						if(THEME_KEY == "mj"){
								
							// GET AMOUNT
							$amount = get_post_meta($_POST['job_id'], "price", true); 								 						
							$price_customoffer = get_post_meta($_POST['job_id'], "price_customoffer", true); 							
							
							/// ADD ON CREDIT
							if( is_numeric($amount) && $amount  > 0 && $price_customoffer == ""){ // DONT CREDIT FOR CUSTOM OFFERS AS THEY ARE NOT PAID FOR					
									$c = get_user_meta($_POST['buyer_id'],'ppt_usercredit', true);
									$c1  = $c + $amount;
									update_user_meta($_POST['buyer_id'],'ppt_usercredit', $c1);						
							}						
								
								
						}
						
					 
				
					// UPDATE
					die(json_encode(array("status" => "ok")));
				
				} break;
				
				
				case "offer_delete": {
				
				
					wp_delete_post( $_POST['job_id'], true);
				
					// UPDATE
					die(json_encode(array("status" => "ok")));
				
				} break;
				
				case "offer_update": {

   					update_post_meta($_POST['job_id'], "offer_status", $_POST['offer_status']);
					
					
					// REJECTED CREDIT USER
					if($_POST['offer_status'] == 2){
							
							if(THEME_KEY == "mj"){
								
								// GET AMOUNT
								$amount = get_post_meta($_POST['job_id'], "price", true); 								
								$price_customoffer = get_post_meta($_POST['job_id'], "price_customoffer", true); 
								 
								/// ADD ON CREDIT
								if( is_numeric($amount) && $amount  > 0 && $price_customoffer == ""){ // DONT CREDIT FOR CUSTOM OFFERS AS THEY ARE NOT PAID FOR					
									$c = get_user_meta($_POST['buyer_id'],'ppt_usercredit', true);
									$c1  = $c + $amount;
									update_user_meta($_POST['buyer_id'],'ppt_usercredit', $c1);						
								}
							
							}
					
					
					}elseif($_POST['offer_status'] == 3){ // ACCEPTED
					
						
						// SKIP PAYMENT STEP AND GO TO FEEDBACK
						if(in_array( THEME_KEY, array("da","rt","jb") )  ){
							
							update_post_meta($_POST['job_id'], "offer_complete", 5); 
						
						}
						
						// IF THEREIS NO PAYMENT DUE
						// SKIP AND GO TO FEEDBACK
						$amount = get_post_meta($_POST['job_id'], "price", true); 
						if(!is_numeric($amount) || $amount < 1){
							
							update_post_meta($_POST['job_id'], "offer_complete", 5);
						
						}else{
						
							
							// CHECK WE HAVENT ADDED THIS BEFORE
							if(get_post_meta($_POST['job_id'], 'payment_id', true) == "" && !in_array( THEME_KEY, array("da","mj","rt","jb") )  ){
						
								// GET AMOUNT
								$amount = get_post_meta($_POST['job_id'], "price", true); 
						
								// 3. ADD NEW ORDER/INVOICE
								$o = $this->ORDER("add", array( 
									"order_id" => "OFFER-".$_POST['listing_id'],
									"order_status" 		=> 2, // pending
									"order_total" 		=> $amount,
									"order_userid" 		=> $_POST['buyer_id'],
									
								) );
								 
								$payment_id = $o['orderid'];					 
				
								update_post_meta($payment_id, 'seller_id', $_POST['seller_id']);	
								update_post_meta($payment_id, 'buyer_id', $_POST['buyer_id']);						 
								update_post_meta($payment_id, 'offer_id', $_POST['job_id'] );	
				
								// UPDATE BID WITH PAYMENT ID
								update_post_meta($_POST['job_id'], 'payment_id', $payment_id );
				
								//SET ITEM TO SOLD STATUS		
								update_post_meta($_POST['listing_id'],'status',1);	
							
							}
						
						}
		
					} 
					
					
				
					
					// ADD LOG
					if($_POST['offer_status'] == 3){
						$logtype ="offer_accepted";
					}elseif($_POST['offer_status'] == 2){
						$logtype ="offer_rejected";
					} 
					
					if(isset($logtype)){
					
					// ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> $logtype,								
							"postid"	=> $_POST['listing_id'],							
							"to" 		=> $_POST['buyer_id'], 						
							"from" 		=> $_POST['seller_id'],							
							"alert_uid1" 	=>  $_POST['buyer_id'],								
							"offerid" 	=> $_POST['job_id'],						
							 
						)
					); 
					 
						
					}					 
						
					// SEND EMAIL TO APPLICANT
					
					
					// UPDATE
					die(json_encode(array("status" => "ok","offer" => $_POST['offer_status'])));
				
				
				} break;
				
				case "offer_complete": {
					
				 
				 	update_post_meta($_POST['job_id'], "offer_complete", $_POST['offer_status']); 
					
				 	 
					// UPDATE ORDER STATUS AND PAYMENT
					$AMOUNTOWED  = 0;
					if( ( in_array($_POST['offer_status'], array(4,5)) && in_array(THEME_KEY, array("mj","at")) )  || $_POST['offer_status'] == 5){ //$_POST['offer_status'] == 5
					 
					
					 	// IF PAYMENT HAS AN OFFER, UPDATE THIS TOO			
						$order_id = get_post_meta($_POST['job_id'],'order_id', true);							 			
						update_post_meta($order_id,'order_process', 3);	
						
						// GET ORDER TOTAL
						$order_total = $CORE->ORDER("get_order_total", $order_id);	
						if($order_total == ""){					
						$order_total = get_post_meta($_POST['job_id'],'price', true);
						}		 		  
						
						// UPDATE PAYMENT 
						$payment_id = get_post_meta($_POST['job_id'],'payment_id', true);						
						update_post_meta($payment_id,'order_status', 1);
						update_post_meta($payment_id,'order_process', 3);	
						
						// UPDATE ESCROW PAYMENT
						if(_ppt(array('cashout', 'enable_escrow')) == 1){
							$escrow_id = get_post_meta($_POST['job_id'],'escrow_id', true);							 			
							update_post_meta($escrow_id,'order_process', 3);								 
						}					

						
						// CREDIT USER IN MIRO JOBS
						if( ( THEME_KEY == "mj" || _ppt(array('cashout', 'enable_escrow')) == '1' ) && $_POST['offer_status'] == 5 ){ //5 = release funds
						 
							$AMOUNTOWED = $order_total;
						 
							 /// ADD ON CREDIT
							if( is_numeric($AMOUNTOWED) && $AMOUNTOWED  > 0){					
								$c = get_user_meta($_POST['seller_id'],'ppt_usercredit', true);
								$c1  = $c + $AMOUNTOWED;
								update_user_meta($_POST['seller_id'],'ppt_usercredit', $c1);						
							} 
							
							// ADD LOG
							$CORE->FUNC("add_log",
								array(				 
									"type" 		=> "mj_credit_added",									
									"postid"	=> $_POST['listing_id'],									
									"to" 		=> $_POST['seller_id'], 					
									"from" 		=> 0,									
									"alert_uid1" 	=>  $_POST['seller_id'],									
									"offerid" 	=> $_POST['job_id'],									
									"extra" 	=> $AMOUNTOWED,	
								)
							); 						
							
						} // end mico jobs 
						
						 
						
						// CHECK FOR HOUSE COMISSION
						if(( _ppt(array('lst', 'house_comission')) > 0 || _ppt(array('lst', 'house_comission_fixed')) > 0 ) && $_POST['offer_status'] == 5 ){
						 	
							
							if(_ppt(array('lst', 'house_comission_fixed')) > 0){
							$AMOUNTOWED = _ppt(array('lst', 'house_comission_fixed'));
							}else{
							$AMOUNTOWED = (_ppt(array('lst', 'house_comission'))/100)*$order_total;
							}							
							
							if( is_numeric($AMOUNTOWED) && $AMOUNTOWED  > 0){
								
								// 1. COMISSION INVOICE
								if(_ppt(array('lst', 'house_comission_invoice')) == '1'){	
								
										// 3. ADD NEW ORDER/INVOICE
										$o = $this->ORDER("add", array( 
											"order_id" 			=> "CREDIT-".$_POST['job_id'],
											"order_status" 		=> 2, // pending
											"order_total" 		=> $AMOUNTOWED,
											"order_userid" 		=> $_POST['seller_id'],
											"order_description" => __("Comission Payment","premiumpress")." (".get_the_title($_POST['job_id']).") (#".$_POST['job_id'].")",
											
										) );
										 
										$payment_id = $o['orderid'];					 
						
										update_post_meta($payment_id, 'seller_id', $_POST['seller_id']);	
										update_post_meta($payment_id, 'buyer_id', $_POST['buyer_id']);						 
										update_post_meta($payment_id, 'offer_id', $_POST['job_id'] );	
									
								
								// 2. DEDUCT AMOUNT FROM TOTAL
								}else{
								
									$c = get_user_meta($_POST['seller_id'],'ppt_usercredit', true);
									$c1  = $c - $AMOUNTOWED;
									update_user_meta($_POST['seller_id'],'ppt_usercredit', $c1);
								
								}							
							}
													
						}		 
						
						
						// ADD LOG
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "offer_complete",								
								"postid"	=> $_POST['listing_id'],								
								"to" 		=> $_POST['buyer_id'], 						
								"from" 		=> $_POST['seller_id'],
								
								"alert_uid1" 	=>  $_POST['buyer_id'],	
								 
								
								"offerid" 	=> $_POST['job_id'],						
								 
							)
						); 
					
					}else{
					
					  
					// ADD LOG
					if($_POST['seller_id'] == $userdata->ID){
					 
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "offer_updated",									
								"postid"	=> $_POST['listing_id'],								
								"to" 		=> $_POST['buyer_id'], 						
								"from" 		=> $_POST['seller_id'],								
								"alert_uid1" 	=>  $_POST['buyer_id'],	
								"offerid" 	=> $_POST['job_id'],						
								 
							)
						); 
					}else{
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "offer_updated",									
								"postid"	=> $_POST['listing_id'],								
								"to" 		=> $_POST['seller_id'], 						
								"from" 		=> $_POST['buyer_id'],								
								"alert_uid1" 	=>  $_POST['seller_id'],
								"offerid" 	=> $_POST['job_id'],						
								 
							)
						); 
					}
					
					
					
					}
			
				
					// UPDATE
					die(json_encode(array("status" => "ok" )));
				
				} break;				
				
				
		}
		
	}



	if(isset($_POST['cart_action'])){
	 		
		switch($_POST['cart_action']){
		
		
				case "remove_coupon": {
	
					// RMEOVE COUPON		 
					unset($_SESSION['discount_code']);	
					die();
				
				} break;
			 	
				case "update": {
				  
				//$ProductArray = array( "1" => array( "qty" => 50 ) );
				//$_SESSION['ppt_cart'][612] = $ProductArray;
				//die();
				
				// GET CART DATA
				global $CORE_CART;
				$cartdata 	= $CORE_CART->cart_getitems();
				
				$cart_items = $cartdata['items'];
				
				//PRODUCT DATA					
				$product_id 		= $_POST['pid'];
				$product_qty 		= $_POST['qty'];
				$product_ship 		= 0; // NEEDS DOING
				$product_innerid 	= $_POST['innerid']; // USED AT CHECKOUT FOR INCREASING QTY	
			 	$product_customdata = "";
				if(strlen($_POST['custom']) > 1){ 
					$product_customdata = $_POST['custom'];
				}
				
				// CREDIT SYSTEM
				$product_paument_via_tokens 		= 0; 
				if(isset($_POST['tokens']) && is_numeric($_POST['tokens']) && $_POST['tokens'] == 1){
				$product_paument_via_tokens 		= 1; 
				}
				
			 
				// CHECK IF THE PRODUCT ALREADY EXISTS
				if(isset($cart_items[$product_id])){	
							
					$ProductArray = $cart_items[$product_id]; 	
					
					if( is_numeric($product_innerid) && isset($cart_items[$product_id][$product_innerid]) ){
						$innerID 		= $product_innerid;
					
					}else{		
						$innerID = count($cart_items[$product_id]);
					}
													
				}else{ 
			 
					$ProductArray = array( "1" => array( "qty" => 0 ) ); // NEW PRODUCT
					$innerID = 1;
					
				}// endif
				
				
				// IF WERE ADDING CHECK IF WE NEED TO ADD A NEW PRODUCT
				// OR UPDATE AN EXISTING ONE
				if($_POST['type'] == "add" && $product_customdata != "" && isset($cart_items[$product_id]) ){
					$innerID = count($cart_items[$product_id])+1;	// GENERATE A NEW ID
				}
				
				// THIS IS THE PRODUCT WE ARE EDITING!!!
				$CURRENTPRODUCT = $ProductArray[$innerID]; 			 
			
				// NOW PERFORM TASK
				switch($_POST['type']){
				
					case "add": {
						 
						$CURRENTPRODUCT['qty'] = $CURRENTPRODUCT['qty'] + $product_qty;					 
					
					} break;
					
					case "remove": {
						
						$CURRENTPRODUCT['qty'] = $CURRENTPRODUCT['qty'] - $product_qty;	
						
					} break;
					
					case "update": {
						 
						$CURRENTPRODUCT['qty'] = $product_qty;					 
					
					} break;
				
				}// end switch
				
				
					 
				// IF LESS THAN 1 REMOVE
				if($CURRENTPRODUCT['qty'] < 1){
					unset($_SESSION['ppt_cart'][$product_id][$innerID]);						
					die("here");						
				}
						
			 	
				 
				// CHECK FOR EXTRAS
				$extras_array = array();
				if(strlen($product_customdata) > 0){ 
						$e1 = explode(",",$product_customdata);	 $o=1;										
						foreach($e1 as $ed){
							$bits = explode("|",$ed);
							if(isset($bits[1])){
							$extras_array[$o]['key'] 	= $bits[0];
							$extras_array[$o]['field'] 	= $bits[1];
							$extras_array[$o]['text'] 	= $bits[2];
							$extras_array[$o]['amount'] = $bits[3];
							 
							$o++;
							} // end if
						} // end foreach
				}// end if
					
				// PRODUCT SAVE
				$CURRENTPRODUCT['extra'] 	= array("ship" => $product_ship, "tokens" => $product_paument_via_tokens, "custom" => $extras_array);				
			 	
 				// SAVE SESSION
				$_SESSION['ppt_cart'][$product_id][$innerID] = $CURRENTPRODUCT;
					 
				// LEAVE MSG
				die(print_r($_SESSION['ppt_cart'])); 
			
				
				} break; // end update
			
		} // end switch				
		 
	}// end actions
 

 
 
// AJAX FROM WITHIN THE SITE
if(isset($_POST['admin_action']) && $_POST['admin_action'] !=""  ){ //&& function_exists('current_user_can') && current_user_can('administrator')

	switch($_POST['admin_action']){
	
	
	case "set_massimportdata": {
		
			
			// MAKE SURE THE USER IS THE AUTHOR
		 
				$the_post 				= array();
				$the_post['ID'] 		= $_POST['pid'];
				$the_post['post_title'] = strip_tags(strip_tags($_POST['title']));
				wp_update_post( $the_post ); 
				
				// CATEGORIES
				$cats = explode(",",$_POST['cat']);
				if(is_array($cats) && !empty($cats) ){
					foreach($cats as $cat){
						$cat = trim($cat);
						if(!is_numeric($cat) ){ continue; }
						$categories[] = $cat;
					}
					 
					wp_set_post_terms($the_post['ID'], $categories, THEME_TAXONOMY );
				}	 
		 		 
				die(json_encode(array("status" => "ok")));
		 
		} break;
	
		case "helpme_search": {
		
				$status = "error";
				$mainvid = "";
				$innerpage = "";
				if(isset($_POST['innerpage'])){
				$innerpage = $_POST['innerpage'];
				}
		
				// build request				 
				$request = array(					 
						'version' 		=> THEME_VERSION,
						"theme_key" 	=> strtoupper(THEME_KEY),
						'email' 		=> get_option('admin_email'),
						'theme_lic' 	=> get_option("ppt_license_key"),	
						'theme_url' 	=> esc_url( home_url() ),						
						"keyword" 		=> $_POST['keyword'], 
						"page" 			=> $_POST['page'], 
						"innerpage" 	=> $innerpage,						
					);
				 
				// Start checking for an update
				$send_for_check = array(
					'body' => array(					 
						'request' => serialize($request),
						'api-key' => md5(esc_url( home_url() ))
					),
					'user-agent' => 'WordPress; ' . esc_url( home_url() )
				);
				 	
				// EXECUTE 
				if(defined('WLT_DEMOMODE') && strpos($_SERVER['HTTP_HOST'],"premiummod.com") === false  ){
				$raw_response = wp_remote_post("http://localhost/_helpfeed/index.php", $send_for_check);
				}else{
				$raw_response = wp_remote_post("https://www.premiumpress.com/_helpfeed/index.php", $send_for_check);
				}
				
				  	//die(print_r($raw_response));
				if( !is_wp_error( $raw_response ) ) {	 
				 	 
					$data = (array)json_decode($raw_response['body']);	
					
					if(!empty($data)){
					
						$status = "ok";
					 	
						// BUILD OUTPUT
						$output = '<h6>'.__("Related Tutorials","premiumpress").'</h6><hr />';
						$output .= '<ul>';
						foreach($data as $g){ 
							if(strlen($g->link) > 1){
                        	$output .= '<li><i class="fal fa-file-search mr-2"></i><a href="'.$g->link.'" target="_blank">'.$g->name.'</a></li>';
							}
							
							if(isset($g->mainvid)){
							$mainvid = $g->mainvid;
							}
							
                        } 
						$output .= '</ul>';
												
					
					} 				 		
				
				}else{				
					
					$output = $raw_response->get_error_message();	
					
					$status = "error";				
				}
		
		 
			// REPORT AJAX
			header('Content-type: application/json');			 
			die(json_encode(array("status" => $status, "keyword" => $_POST['keyword'], "page" => $_POST['page'], "innerpage" => $_POST['innerpage'], "output" => $output, "mainvid" => $mainvid  )));
		
		} break;
	
		case "auction_deletebid": {
		
				global $CORE_AUCTION;
		 
				// GET BID HISTORY
				$bidding_history = get_post_meta($_POST['pid'],'current_bid_data',true);
				 			
				if(!is_array($bidding_history)){ $bidding_history = array(); }
				$newdata = array();
				 	
					// LOOP LIST		 
					if(is_array($bidding_history) && !empty($bidding_history) ){ 
					
						// SORT BY DATE
						uksort($bidding_history,  array($CORE_AUCTION, "order_bidhiustory_bykey") );
				 
						$bidding_history = array_reverse($bidding_history, true);
						
						
							$i=1; 
							foreach($bidding_history as $date => $bhistory){  
							
								if($date == $_POST['bid']){ continue; }
								
								$newdata[$date] = $bhistory;								
								$i++;
							
							}							
						 
							// UPDATE
							update_post_meta($_POST['pid'],'current_bid_data',$newdata);
							 
							 // GET HIGHEST BID AND SET THE NEW PRICE
							 $hi = $CORE_AUCTION->get_highest_bidder($_POST['pid']);
							 if(is_array($hi)){
							 	update_post_meta($_POST['pid'],'price_current',$hi['amount']);
							 }else{
								 update_post_meta($_POST['pid'],'price_current',0);
							 }
							 
						
					}
				 
		
		
			// REPORT AJAX
			header('Content-type: application/json');			 
			die(json_encode(array("status" => "ok",   )));
		
		} break;
	 
	
		case "check_updates": {		
		 
			$theme_data = new stdClass();
			$theme_data->action 	= "version_check";
			$theme_data->checked 	= array( THEME_KEY => THEME_VERSION );
			  
			$data = $CORE->check_for_theme_update($theme_data);			 
			 
			$version = $data->response[THEME_KEY];
			
			if(is_numeric(intval($version))){	
			
				if ( version_compare( $version, THEME_VERSION, '>' ) ) {			 
						$s = "new";
				}else{
						$s = "old";
				}
						
			}else{
				$s = "error";
			}
		
			// REPORT AJAX
			header('Content-type: application/json');			 
			die(json_encode(array("status" => $s, "current" => THEME_VERSION, "msg" => $version )));
		
		
		} break;
	
		case "check_license": {
		
			// update
			// install
			// error
			
			$current_key = get_option("ppt_license_key");						
			if($current_key == ""){
				$status = "install";
			}else{
				$status = "update";
			}
				
			if(strlen($_POST['theme']) > 1){
			update_option('ppt_theme', $_POST['theme']);
			}
			
			if(defined('WLT_DEMOMODE')){			
				// REPORT AJAX
				header('Content-type: application/json');			 
				die(json_encode(array("status" => $status )));
			}
			
			if(defined('THEME_VERSION')){
			$themeversion = THEME_VERSION;
			}else{
			$themeversion = 99;
			}
			
			if(defined('THEME_KEY')){
			$themekey = THEME_KEY;
			}else{
			$themekey = "";
			} 
			
				// build request				 
				$request = array(
						't' 			=> $themekey,
						'v' 			=> $themeversion,
						'l' 			=> trim($_POST['key']),					
						'e' 			=> get_option('admin_email'),				
						'w' 			=> esc_url( home_url() ),						
				);	
							 
				// Start checking for an update
				$send_for_check = array(
					'body' => array(						 
						'request' => serialize($request),
						'api-key' => md5(esc_url( home_url() ))
					),
					'user-agent' => 'WordPress/' . $wp_version . '; ' . esc_url( home_url() )
				);
				 	
				// EXECUTE 
				$raw_response = wp_remote_post("https://www.premiumpress.com/_themesv10/version_check.php", $send_for_check);	
			 	  			
			// CHECK RESPONSE
			if( !is_wp_error( $raw_response ) && ($raw_response['response']['code'] == 200) ) {	 
			
					$newversion = $raw_response['body'];					 
					 
					if($newversion == "1"){						
					 
						// REPORT AJAX
						header('Content-type: application/json');			 
						die(json_encode(array("status" => $status )));
						
					}elseif($newversion == "expired"){	
					
						// REPORT AJAX
						header('Content-type: application/json');			 
						die(json_encode(array("status" => "error", "msg" => "License Key Has Expired - Please login to www.premiumpress.com and renew your account." )));
					
					}else{
					
						// REPORT AJAX
						header('Content-type: application/json');			 
						die(json_encode(array("status" => "error", "msg" => "Invalid License Key" )));									
					}					
					
			} else {
			
				// REPORT AJAX
				header('Content-type: application/json');			 
				die(json_encode(array("status" => "error", "msg" => $raw_response->get_error_message() )));	
			  
			}
			
			// REPORT AJAX
			header('Content-type: application/json');			 
			die(json_encode(array("status" => "error", "msg" => "Invalid License Key" )));	
			 
		
		} break;
	
	
		case "load_block_data": {
				
				$output = "";
				
				global $CORE;
				$defaults = $CORE->LAYOUT("get_blocks_data",array());
			 
				
				if(isset($defaults[$_POST['id']]['data'])){
				 
					if(isset($_GET['pagekey'])){
						$pagekey = $_GET['pagekey'];
					}else{
						$pagekey = "home";
					}
					
					 		
					ob_start();
					echo $CORE->CustomDesignEdit($_POST['id'], $defaults[$_POST['id']], $pagekey);		 
					$output = ob_get_contents();
					ob_end_clean();	 
					
				}
				
				
				// REPORT AJAX
				header('Content-type: application/json');
				$n = array("statsus" => "ok", "output" => $output);
				echo json_encode($n);
				die();
		} break;
	
		case "mass_update_users": {
		
		require_once( ABSPATH.'wp-admin/includes/user.php' );
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
			 
				wp_delete_user( $pid );
				
				}elseif($_POST['cat'] != ""){
				
				//update_post_meta( $pid, "order_status", $_POST['cat'] );
				
				}
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;
		
		
		case "mass_update_campaigns": {
		
		
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
				
				wp_delete_post( $pid, true);
				
				}elseif($_POST['cat'] != ""){
				
				update_post_meta( $pid, "status", $_POST['cat'] );
				
				}
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;			
		case "mass_update_cashout": {
		
		
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
				
				wp_delete_post( $pid, true);
				
				}elseif($_POST['cat'] != ""){
				
				update_post_meta( $pid, "order_status", $_POST['cat'] );
				
				}
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;
		case "mass_update_orders": {
		
		
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
				
				wp_delete_post( $pid, true);
				
				}elseif($_POST['cat'] != ""){
				
				update_post_meta( $pid, "order_status", $_POST['cat'] );
				
				}
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;
		
		case "mass_update_subscriber": {		
		
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
				
				wp_delete_post( $pid, true);
				
				}elseif($_POST['cat'] != ""){
				
				 
				}
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;
		
		case "mass_update_logs": {
		
		
	 	if(is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['deleteall']  == 1){
				
				wp_delete_post( $pid, true);
				
				}
			}		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;		
			
		case "mass_update_listings": {
		
		
	 	if(isset($_POST['pids']) && is_array($_POST['pids'])){
			foreach($_POST['pids'] as $pid){
			
				// UDPATE CATEGORY
				if($_POST['status']  != ""){
				
					switch($_POST['status']){
						
						case "publish": {		
							
							$my_post = array();
							$my_post['ID'] 			= $pid; 
							$my_post['post_status'] = "publish";				
							wp_update_post( $my_post );
						
						} break;
						
						case "pending": {
						
							$my_post = array();
							$my_post['ID'] 			= $pid; 
							$my_post['post_status'] = "pending";				
							wp_update_post( $my_post );						
						
						} break;
						
						case "trash": {
							wp_delete_post( $pid, true);
						} break;
					
					}				
					
				
				}elseif($_POST['cat'] != ""){
				
				wp_set_post_terms( $pid, $_POST['cat'], 'listing' );
				
				}elseif($_POST['pak'] != ""){
				
				 update_post_meta($pid, "packageID", $_POST['pak']);
				
				}
				
				// ON
				if($_POST['addon_featured'] == 1){
					 update_post_meta($pid, "featured", 1);				
				}
				
				// ON
				if($_POST['addon_homepage'] == 1){
					 update_post_meta($pid, "homepage", 1);				
				}
				
				// ON
				if($_POST['addon_sponsored'] == 1){
					 update_post_meta($pid, "sponsored", 1);				
				}
				
				// OFF
				if($_POST['addon_off_featured'] == 1){
					 update_post_meta($pid, "featured", 0);				
				}
				
				// OFF
				if($_POST['addon_off_homepage'] == 1){
					 update_post_meta($pid, "homepage", 0);				
				}
				
				// OFF
				if($_POST['addon_off_sponsored'] == 1){
					 update_post_meta($pid, "sponsored", 0);				
				}				
				
			}
		
		}	 	
		
		die(json_encode(array("status" => "ok")));
		
		
		} break;
	
	
		case "testing_order_add": {
		
			if(1 == 1){
			
				global $CORE;
			 	
				 
				 $i=0; while($i < 10){
				   
				 $orderadd = $CORE->ORDER('add', array(
				 	 	
					'order_status' 	=> $CORE->ORDER("get_status", "random"),
					
				 	'order_id' 		=> $CORE->ORDER("get_type", "random")."-".$CORE->ORDER("get_id", "random"),
					
					'user_id' => 1,
					
					'order_total' 		=> rand(10,9999),
					
					'order_shipping' 	=> rand(10,9999),
					
					'order_tax' 		=> rand(10,9999),
				 	
				 
				 ));
				 
				 
				 $i++; }
				 
				 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;
	
	
	
		case "log_delete_all": {
		
			$wpdb->query("DELETE FROM ".$wpdb->prefix."posts WHERE post_type = 'ppt_logs'");	
			
			die(json_encode(array("status" => "ok")));
			 
		} break;
		
		case "log_delete": {
		
			if(isset($_POST['uid']) && is_numeric($_POST['uid'])  ){
			 	
				 wp_delete_post($_POST['uid'], true); 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;
		
		case "campaign_delete": {
		
			if(isset($_POST['pid']) && is_numeric($_POST['pid'])  ){
			 	
				 wp_delete_post($_POST['pid'], true); 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;
			
		case "subscriber_delete": {
		
			if(isset($_POST['uid']) && is_numeric($_POST['uid'])  ){
			 	
				 wp_delete_post($_POST['uid'], true); 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;

		case "cashout_delete": {
		
			if(isset($_POST['uid']) && is_numeric($_POST['uid'])  ){
			 	
				 wp_delete_post($_POST['uid'], true); 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;
							
		case "order_delete": {
		
			if(isset($_POST['uid']) && is_numeric($_POST['uid'])  ){
			 	
				 wp_delete_post($_POST['uid'], true); 
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;
	
 
		case "user_delete": {
		
			if(isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['uid'] != 1 ){
			
				require_once(ABSPATH.'wp-admin/includes/user.php' );				
				
				$user = get_userdata( $_POST['uid'] );			
				
				if(!in_array( 'administrator', $user->roles ) ){
					wp_delete_user($_POST['uid']);
				}			
				
			
				die(json_encode(array("status" => "ok")));
			
			}else{
				die(json_encode(array("status" => "error")));
			}
		
		} break;

	
		case "update_title": {
		
				$the_post 				= array();
				$the_post['ID'] 		= $_POST['id'];
				$the_post['post_title'] = strip_tags(strip_tags($_POST['title']));
				wp_update_post( $the_post );
				
				die("ok");
		
		} break;
		
		case "update_custom_field": {
			
			if(is_numeric($_POST['pid'])){
				update_post_meta($_POST['pid'], $_POST['key'], $_POST['value']);
			}
				die("ok");
		
		} break;

		case "listing_catprice": {
				
			if(!is_numeric($_POST['cid'])){ die(0); }
				
			if(is_numeric($_POST['amount'])){
					$current_catprices = get_option('ppt_catprices');
					if(!is_array($current_catprices)){ $current_catprices = array(); }
					$current_catprices[$_POST['cid']] = $_POST['amount'];
					update_option('ppt_catprices',$current_catprices);
					die(1);				 
				}
			
			die(0);	 
				
		} break;
	
	} // end switch

}


// AJAX FROM WITHIN THE SITE
if(isset($_POST['action']) && $_POST['action'] !=""){

 
	switch($_POST['action']){
	
	case "savesearch_get": { 
	
		
		
		$addLink = ' href="javascript:void(0);" onclick="savedsearch_add();"';
		if(!$userdata->ID){
			$addLink = 'onclick="processLogin();" href="javascript:void(0);"';
		}	
		
		if(!$userdata->ID){
			$output = '<a '.$addLink.' class="btn btn-secondaryrounded-pill small savesearchadd  btn-xl"> '.__("Save Search","premiumpress").'</a>';
		}else{
			
			ob_start();	 
			$savedsearches = get_user_meta($userdata->ID,'savedsearches',true);	
			if(!is_array($savedsearches)){ $savedsearches = array(); }
			$sc = 1;
			foreach($savedsearches as $sk => $ss){
			?>
			<div class="card px-2 mb-2 bg-white small" id="savedsearchdiv<?php echo $sk; ?>"><div class="d-flex justify-content-between"><div><a href="javascript:void(0);" onclick="savesearch_go(<?php echo $sk; ?>)" class="text-dark small"> <?php echo __("Search","premiumpress"); ?> <?php echo $sc; ?></a></div><a href="javascript:void(0);" onclick="savesearch_remove(<?php echo $sk; ?>)" class="text-danger"><i class="fa fa-times mr-2"></i></a></div></div><textarea style="display:none;" id="saveseachgo<?php echo $sk; ?>"><?php echo $ss; ?></textarea><?php $sc++; } ?><a <?php echo $addLink; ?> class="btn btn-secondary rounded-pill small  my-2 savesearchadd"><?php echo __("Save Search","premiumpress"); ?></a>
			<?php 
			$output = ob_get_contents();
			ob_end_clean();	
		
		}
        
        die(json_encode(array(			
				"status" 	=> "ok", 
				"output" 		=> trim($output),				 
				 
		)));
	
	} break;
	
	case "savesearch": {
	
			if(!$userdata->ID){
			return;
			}
			
			
			$savedsearches = get_user_meta($userdata->ID,'savedsearches',true);			
			if(!is_array($savedsearches)){ $savedsearches = array(); }
			 
			$key = count($savedsearches)+1;
			
			if(isset($savedsearches[$key])){
				$key = $key . rand(100,200);
			}
			 
			$savedsearches[$key] = $_POST['details']; 
			
			update_user_meta($userdata->ID,'savedsearches',$savedsearches);				
	 
			die(json_encode(array(			
					"status" 	=> "ok", 				 
			)));
	
	} break;
	
	case "savesearch_remove": {

			if(!$userdata->ID){
			return;
			}
			
			$newarray = array();
			$savedsearches = get_user_meta($userdata->ID,'savedsearches',true);			
			if(!is_array($savedsearches)){ $savedsearches = array(); }
			foreach($savedsearches as $sk => $sd){
				if($_POST['rid'] == $sk){
				$newarray[$sk] = $sd;
				}
			}
			
			update_user_meta($userdata->ID,'savedsearches', $newarray);	
			
	
		$status = "ok";
	
		die(json_encode(array(			
				"status" 	=> $status, 
				//"link" 		=> $link,				 
				//"msg" 		=> $msg,	
		)));
	
	} break;
	
	
	case "get_comments":{
	
 
	 		if(!is_numeric($_POST['uid'])){ die(); }
			
			$args = array(
				 
				'number' => 10,
				
				'meta_query' => array(
						 
						array(
							'key'		=> 'feedback_for',
							'value' 	=> $_POST['uid'],
							'compare' 		=> '=',
						),
						
						
						array(
							'key'		=> 'feedback',	
							'value' 	=> 1,
							'compare' 	=> '=',
						),	
						
						array(
							'key'		=> 'ratingtotal',	
							'value' 	=> $_POST['value1'],
							'compare' 	=> '>=',
						),	
						
						array(
							'key'		=> 'ratingtotal',	
							'value' 	=> $_POST['value2'],
							'compare' 	=> '<',
						),
						 
						 
					),
					
			);
			// GET USER FEEDBACK
			$c = new WP_Comment_Query($args); 
			$feedback = $c->comments;
			
			if(empty($feedback)){ ?>
            <div class="bg-light p-4 text-muted font-weight-bold text-center">
                        <div><?php echo __("No feedback found.","premiumpress") ?></div>
                        </div>
              
              <?php }elseif(!empty($feedback)){
			
			 foreach($feedback as $this_feedback){
					 
					global $settings;
					
					$settings = array(
					
						"ID" => $this_feedback->comment_ID,
						"desc" => strip_tags($this_feedback->comment_content), 
						"date" => $this_feedback->comment_date, 			
						"author" => $this_feedback->user_id, 
						"author_name" => $CORE->USER("get_name",$this_feedback->user_id), 			
						"pid" => $this_feedback->comment_post_ID,			
						
					);		 
					
					// DISPLAY FEEDBACK 
					_ppt_template( 'content', 'feedback' );
					 
					
					
			}  // end foreach
			
		}
		
		die();
	
	} break;
	
	
	
	case "chat_upload": {
	  
	
			// CHECK FOR FILE UPLOAD
			if(isset($_FILES['file']) && is_array($_FILES['file'])){	 // && 
			  
				
				if(!in_array($_FILES['file']['type'],$CORE->allowed_image_types) && !in_array($_FILES['file']['type'], $CORE->allowed_zip_types ) ){
			 	
				
					die(json_encode(array("status" => "error","msg" => __("This file is not allowed.","premiumpress") .$_FILES['file']['type'] )));
				
				}
			   
				// LOAD IN WORDPRESS FILE UPLOAOD CLASSES
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				
				if(!function_exists('get_file_description')){
				if(!defined('ABSPATH')){
				require $dir_path . "/wp-load.php";
				}
				require $dir_path . "/wp-admin/includes/file.php";
				require $dir_path . "/wp-admin/includes/media.php";	
				}
				if(!function_exists('wp_generate_attachment_metadata') ){
				require $dir_path . "/wp-admin/includes/image.php";
				}				 
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['file']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['file']['type'],
					'tmp_name'	=> $_FILES['file']['tmp_name'],
					'error'		=> $_FILES['file']['error'],
					'size'		=> $_FILES['file']['size'],
				);
				
				 
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));	
				 
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					 
					die(json_encode(array("status" => "error", "msg" => $uploaded_file['error'] )));
					
				}else{
				
					// set up the array of arguments for "wp_insert_post();"
					$attachment = array(			 
						'post_mime_type' => $_FILES['file']['type'],
						'post_title' 	=> $_FILES['file']['name'],
						'post_content' 	=> '',
						'post_author' 	=> $userdata->ID,
						'post_status' 	=> 'inherit',
						'post_type' 	=> 'attachment',
						'post_parent' 	=> 0,
						'guid' 			=> $uploaded_file['url']
					);	
				 							
					
					// insert the attachment post type and get the ID
					$attachment_id = wp_insert_post( $attachment );
					 
					// generate the attachment metadata
					$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
					  
					// update the attachment metadata
					$rr = wp_update_attachment_metadata( $attachment_id,  $attach_data );
					
					if(isset($attach_data['sizes']['thumbnail']['file'])){
						$thumbnail = $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
					}else{
						$thumbnail = $uploaded_file['url'];
					}
					
					// UPDATE
					$fd = array("status" => "ok","thumbnail" => $thumbnail, "src" => $uploaded_file['url'], "aid" => $attachment_id, "type" =>  $_FILES['file']['type']  );
					
					
					add_post_meta($attachment_id, "chat_attach_data", $fd); 
					
					die(json_encode($fd));
			 
			 	}
			 
			} // end if
			
			
			die(json_encode(array("status" => "error","msg" => "no file")));
	
	} break;
	
	
	
/*

	/////////////////////////////// LOGIN OPTIONS
	// UPDATED: AUG 2020

*/
				
		case "load_editlisting_form": {			
			 
			 
			 
			$_GET['eid'] = $_POST['eid'];
			
			$_POST['ajaxedit'] = 1;
			 
			switch($_POST['type']){
			 
			 	case "top": {
				
				_ppt_template('framework/design/add/add-background' );
				 
				} break;	
				
				case "titletop":
				case "title": {
				
				_ppt_template('framework/design/add/add-title' );
				 
				} break;
				
				case "excerpt": {
				
				_ppt_template('framework/design/add/add-excerpt' );
				 
				} break;
				
				case "content": {
				
				_ppt_template('framework/design/add/add-content' );
				 
				} break;
				
				case "map": {
				
				_ppt_template('framework/design/add/add-location' );
				 
				} break;
				
				case "customfields": {
				
				_ppt_template('framework/design/add/add-customfields' );
				 
				} break;
				
				case "imagestop":
				case "images": {
				
				_ppt_template('framework/design/add/add-images' );
				 
				} break;
				
				case "video": {
				
				_ppt_template('framework/design/add/add-youtube' );
				
				_ppt_template('framework/design/add/add-vimeo' );
				
				_ppt_template('framework/design/add/add-video' );
				 
				} break;
				
				case "features": {
				
				_ppt_template('framework/design/add/add-features' );
				 
				} break;
				
				case "lookingfor": {
				
				_ppt_template('framework/design/add/add-lookingfor' );
				 
				} break;
				
				case "openinghours": {
				
				_ppt_template('framework/design/add/add-workinghours' );
				 
				} break;
				
				case "compare": {
				
				_ppt_template('framework/design/add/add-compare' );
				 
				} break;	
				
				case "stores": {
				
				_ppt_template('framework/design/add/add-compare-stores' );
				 
				} break;	
				
				case "shopfields": {
				
				_ppt_template('framework/design/add/add-product' );
				_ppt_template('framework/design/add/add-product-details' );
				
				} break;	
				
				case "videoseries": {
				
				_ppt_template('framework/design/add/add-videoseries' );
				
				} break;
				
				case "callrates": {
				
				_ppt_template('framework/design/add/add-callrates' );
				
				} break;
				
				case "services": {
				
				_ppt_template('framework/design/add/add-services' );
				
				} break;
			 
			 }
			 
			die();
		
		} break;	

		case "load_payuser_form": {
			 
			_ppt_template( 'ajax', 'modal-payuser' );
			 
			die();
		
		} break;
				
		case "load_register_form": {
			 
			_ppt_template( 'ajax', 'modal-register' );
			 
			die();
		
		} break;
			
		case "load_upgrade_form": {			
			 
			_ppt_template( 'ajax', 'modal-upgrade' );
			 
			die();
		
		} break;					
			
		case "load_credit_form": {			
			 
			_ppt_template( 'ajax', 'modal-credit' );
			 
			die();
		
		} break;
				
		case "load_login_form": {			
			 
			_ppt_template( 'ajax', 'modal-login' );
			 
			die();
		
		} break;
		
		case "load_video_form": {			
			 
			_ppt_template( 'ajax', 'modal-video' );
			 
			die();
		
		} break;
		
		case "load_images_form": {			
			 
			_ppt_template( 'ajax', 'modal-images' );
			 
			die();
		
		} break;
		
		case "load_msg_form": {			
			 
			_ppt_template( 'ajax', 'modal-msg' );
			 
			die();
		
		} break;
		
		
		case "load_search_filter": {			
			 
			_ppt_template( 'framework/design/widgets/widget-filter', $_POST['fid'] );
			 
			die();
		
		} break;
		
		case "login_process": {	
		
			// PREPARE DATA
		  	$data = array();
		  	parse_str($_POST['formdata'], $data);			 
			
			
			if(isset($_SESSION['ppt_cart'])){
			$savedSession = $_SESSION['ppt_cart'];			
			}
			
			// LOGIN						
			global $CORE, $userdata;
			$ff = $CORE->USER_LOGIN($data['log'], $data['pwd'], $return = 1 );
			 	 
			 
			// RETURN DATA
			$msg = ""; $link = ""; $status = "ok";
			if(strpos($ff,"http") === false){
				$msg = $ff;
				$status = "error";	
				
			}elseif( strpos(strtolower($ff),"error") != false ){
			 
				$msg = $ff;
				$status = "error";	
				
			}elseif(isset($data['reload'])){			
				$status = "reload";						
			}else{
				
				$link = $ff;
			 
				if(isset($data['extra']) && $data['extra'] != ""){
					
					if(strpos($data['extra'],"mem") !== false){					
						
						$memdata = $CORE->USER("get_this_membership", $data['extra']);						
						$link =  $CORE->order_encode(array(  
					               
						   "uid" 					=> $userdata->ID,                
						   "amount" 				=> $memdata['price'], 
						   "order_id" 				=> "SUBS-".$data['extra']."-".$userdata->ID."-".rand(),                 
						   "description" 			=> $memdata['name'],
						   "recurring" 				=> $memdata['recurring'],    
						   "recurring_days" 		=> $memdata['duration'],            
						   "couponcode" 			=> "", 					                 
					   	));
						
						$status = "func_mem";						 
						$msg 	= hook_price($memdata['price']);
					
					
					}elseif(strpos($data['extra'],"pak") !== false){	
					
						$status = "ok";	
						$link = _ppt(array('links','add'))."?pakid=".str_replace("pak","", $data['extra']);
					
					} 
					
					
					
				}				
			}
			
			
			if(isset($savedSession) && $savedSession != ""){
			$_SESSION['ppt_cart'] = $savedSession;
			}
			 
			 
			die(json_encode(array(			
				"status" 	=> $status, 
				"link" 		=> $link,				 
				"msg" 		=> $msg,	
			)));
		
		} break;
		
		case "login_otp_process": {	
		
			// RETURN DATA
			$msg = ""; $link = ""; $status = "ok";

		  	// Validate phone number
			$phone = sanitize_text_field($_POST['phone'] ?? '');
			
			// Query user by phone meta
			$user_query = new WP_User_Query(array(
				'meta_key'   => 'phone',
				'meta_value' => $phone,
				'number'     => 1,
				'count_total' => false,
			));
			$users = $user_query->get_results();
			$user = !empty($users) ? $users[0] : null;

			if ($user) {
				wp_set_auth_cookie($user->ID);
						$status = "ok";
			} else {
						$msg = 'No user found.';
			}

			die(json_encode(array(			
				"status" 	=> $status, 
				"link" 		=> $link,				 
				"msg" 		=> $msg,	
			)));
		
		} break;
		
		case "register_process": {	
		
			// PREPARE DATA
		  	$data = array(); $customdata = array();
		  	parse_str($_POST['formdata'], $data);	
			
			 
			// captcha code from Google
			if(isset($data['g-recaptcha-response'])){ 
			
				if($data['g-recaptcha-response'] == ""){					
					die(json_encode(array("status" => "error", "msg" => __("Invalid Google reCAPTCHA","premiumpress")  )));				
				}
			 
				$args = array(
					'secret'   => _ppt(array('captcha','secretkey')),
					'response' => $data['g-recaptcha-response'],
				);
			 
				$gcaptcha = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify' , $args );
		
				if ( is_wp_error( $gcaptcha ) ) {
					 
				}else{
				
					$body = wp_remote_retrieve_body( $gcaptcha );
					if ( empty( $body ) ) {
						die(json_encode(array("status" => "error", "msg" => __("Invalid Google reCAPTCHA","premiumpress")  )));
					}
					$result = json_decode( $body );
					if ( empty( $result ) ) {
						die(json_encode(array("status" => "error", "msg" => __("Invalid Google reCAPTCHA","premiumpress")  )));
					}
					if ( ! isset( $result->success ) ) {
						die(json_encode(array("status" => "error", "msg" => __("Invalid Google reCAPTCHA","premiumpress")  )));
					}				 
				
				}		 
			
			} 
			
			
			 
			// CREATE PASSWORD FOR USER
			if(!isset($data['pass1'])){			
			
				$data['user_pass'] = wp_generate_password( $length=12, $include_standard_special_chars=false );
			
			}else{			
			
				$data['user_pass'] = $data['pass1'];
			
			}
			 
			
			// CREATE USERNAME
			if(isset($data['username']) && _ppt(array('register','username')) == 1 ){
			
				$username = $data['username'];			
			
			}else{
			
				if(!isset($data['first_name'])){
				
					$data['first_name'] = "";
					$data['last_name'] = "";
					
					$username = "user_".wp_generate_password( $length=5, $include_standard_special_chars=false );		  
				
				}else{
				
					$username = $data['first_name']."_".$data['last_name'].wp_generate_password( $length=5, $include_standard_special_chars=false );		  
				
				}
			
			}
			 
		 	 
			// REGISTER						
			global $CORE;
			 
			$savedata = array(
				"first_name" 	=> $data['first_name'], 
				"last_name" 	=> $data['last_name'],
				"custom" 		=> $customdata,					 	
			); 
			
			
			if(isset($data['custom']) && is_array($data['custom'])){
			$savedata['custom'] = $data['custom'];
			}
			
			if(THEME_KEY == "da"){			
			$savedata['custom']['da-seek1'] = $data['da-seek1'];
			$savedata['custom']['da-seek2'] = $data['da-seek2'];
			}
			
			if(in_array(THEME_KEY, array("es","jb","mj","ll")) && isset($data['user_type']) ){ 			
			$savedata['custom']['user_type'] = $data['user_type'];
			}
			
			$ff = $CORE->USER_REGISTER($username, $data['user_pass'], $data['user_email'], $savedata, 1 );

  
			 
			// RETURN DATA
			$msg = ""; $link = ""; $status = "ok";
			if(strpos($ff,"http") === false ){
				$msg = $ff;
				$status = "error";	
			 
			}elseif(isset($data['reload'])){	
					
				$status = "reload";
				
			}else{
				
				$link = $ff;
			 
				if(isset($data['extra']) && $data['extra'] != ""){
					
					if(strpos($data['extra'],"mem") !== false){					
						
						$memdata = $CORE->USER("get_this_membership", $data['extra']);						
						$link =  $CORE->order_encode(array(  
					               
						   "uid" 					=> $userdata->ID,                
						   "amount" 				=> $memdata['price'], 
						   "order_id" 				=> "SUBS-".$data['extra']."-".$userdata->ID."-".rand(),                 
						   "description" 			=> $memdata['name'],
						   "recurring" 				=> $memdata['recurring'],    
						   "recurring_days" 		=> $memdata['duration'],            
						   "couponcode" 			=> "", 					                 
					   	));
						
						$status = "func_mem";						 
						$msg 	= hook_price($memdata['price']);
					
					
					}elseif(strpos($data['extra'],"pak") !== false){	
					
						$status = "ok";	
						$link = _ppt(array('links','add'))."?pakid=".str_replace("pak","", $data['extra']);
					
					}
					
				}				
			} 
			 
			die(json_encode(array(			
				"status" 	=> $status, 
				"link" 		=> $link,				 
				"msg" 		=> $msg,	
			)));
		
		} break;		
	
/*

	/////////////////////////////// LOGIN OPTIONS

*/	
	
	
	 case "get_alerts_reset": {	 
	 
	 
		if(isset($_POST['type']) && $_POST['type'] == "msg"){								
		
			$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_value = ('unread_".$userdata->ID."') ");
		}
	 
	 
	 } break;
	 
	
 	case "get_alerts": {
	
		$output = ""; $count = 0;
		
		if(isset($_POST['uid']) && is_numeric($_POST['uid'])) {
		
		
			// COUNT MESSAGES
			$mymsg = $CORE->USER("count_messages_unread", $_POST['uid']);			
			
			$count += $mymsg;
			 
			
			if($mymsg > 0){ 
			
			
			ob_start();	
			?>  
			<a onclick="ShowAlertBoxReset('msg');SwitchPage('messages');" href="javascript:void(0);" class="dropdown-notification-item">
			
			<div class="dropdown-notification-icon">
			<i class="fal fa-envelope fa-lg fa-fw text-success mr-3"></i>
			</div>
			<div class="dropdown-notification-info">
			<div class="title"><?php echo str_replace("%s", $mymsg, __("You have %s unread messages.","premiumpress") ); ?></div>
			 
			</div>
			<div class="dropdown-notification-arrow">
			<i class="fa fa-chevron-right"></i>
			</div>
			</a>
			<?php 
			$output .= ob_get_contents();
			ob_end_clean();			
			} 
			
			
			// NO MESSAGES
			if($output == ""){
			ob_start();		
			?>
			<a href="#" class="dropdown-notification-item bg-light">
				<div class="dropdown-notification-info text-center">
				  <div class="title"><?php echo __("No new notifications","premiumpress") ?></div>
				</div>
			</a><?php			
			$output .= ob_get_contents();
			ob_end_clean();	
			}
		
		
			die(json_encode(array("status" => "ok", "data" => $output, "count" => $count )));
		
		}
	
	} break;	
	
	
	
	case "notification_bubble": {
	
	global $userdata, $CORE;
	
	$rec = _ppt(array('user','notify'));
	if($rec == "" || $rec == 1){
	
		// if not logged in
		if($userdata->ID){
		
			$logs = $CORE->USER("get_unread_logs", $userdata->ID);		
			  
			if(!empty($logs)){
				
				// GET LOG DATA
				$data = $CORE->FUNC("format_logtype", $logs[0]['logid'] );
				
				// SET LOG AS READ
				delete_post_meta($logs[0]['logid'],"log_read".$userdata->ID,"");
				
				die(json_encode(array(
				
					"status" 	=> "ok", 
					"type" 		=> "info", // info // success // warning
					"title" 	=> $data['name'],
					"icon" 		=> '<i class="'.$data['icon'].'"></i>',
					"msg" 		=> $data['desc'] ." <br><br>".$data['time'],
					"audio" => FRAMREWORK_URI."images/notification.mp3"	
				)));
				
				 
			}else{
				$uid = 0;
				if(isset($userdata->ID)){
				$uid = $userdata->ID;
				}
			
				die(json_encode(array("status" => "none", "uid" => $uid )));
			}
		
		
		} 
		
	}
	
	die(json_encode(array("status" => "stop")));
 
	
	} break;
	
	
	
	case "subscribe_deleteall": {	
	
			$extn = "_list";
			$type = "subscribe";
			if(defined('WP_ALLOW_MULTISITE')){
				$extn .= get_current_blog_id();
			}
			 
			update_user_meta($_POST['uid'], $type.$extn, "");
			 
	
		die(json_encode(array("status" => "ok")));
		
	} break;
	
	case "subscribe": {
	
		$extn = "_list";
		$type = "subscribe";
		$userid =  $_POST['uid'];
		
		if($userdata->ID && is_numeric($userid) ){
		
			if(defined('WP_ALLOW_MULTISITE')){
				$extn .= get_current_blog_id();
			}						
			 
			$my_list = get_user_meta($userdata->ID, $type.$extn, true);	
			
			$their_list = get_user_meta($userid, $type.$extn."_followers", true);	
								
							
			if(is_array($my_list) && in_array($userid, $my_list) ){
			
				$result = $my_list;							
				unset($result[array_search($userid, $result)]);
				
				$result1 = $their_list;							
				unset($result1[array_search($userdata->ID, $result1)]);				
				
				$status = "add";	
				
					// ADD PUBLIC LOG
					if($userdata->ID){
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "public_user_unsubscribe",								
								"postid"	=> $post->ID,
								"to" 		=> $userid, 						
								"from" 		=> $userdata->ID,				
								"public" => 1,		
													 
							)
						);
					}
				
			}else{			 
				
				$result = array_merge((array)$my_list, array($userid));
				
				$result1 = array_merge((array)$their_list, array($userdata->ID));	
				
					$status = "remove";	
				
				
					// ADD PUBLIC LOG
					if($userdata->ID){
						$CORE->FUNC("add_log",
							array(				 
								"type" 		=> "public_user_subscribe",								
								"postid"	=> $post->ID,
								"to" 		=> $userid, 						
								"from" 		=> $userdata->ID,				
								"public" => 1,		
													 
							)
						);
					}
				
				
			}
			
			/*** now cleanup array(); ***/
			if(is_array($result)){
			$newResult = array();
					foreach($result as $g){
						if(is_numeric($g)){
							$newResult[] = $g;
						}
					}
			}
			
			/*** now cleanup array(); ***/
			if(is_array($result1)){
			$newResult1 = array();
					foreach($result1 as $g){
						if(is_numeric($g)){
							$newResult1[] = $g;
						}
					}
			}
					
					
			update_user_meta($userdata->ID, $type.$extn, $newResult);
						
			update_user_meta($userid, $type.$extn."_followers", $newResult1);
		
		}else{
			$status = "login";	
		}
		
		header('Content-type: application/json');
		$n = array("status" => $status, "data" => $type.$extn);
		die(json_encode($n));
	
	} break;
	
	
	case "favs": {
	
		$extn = "_list";
		$type = "favorite";
		$postid =  $_POST['pid'];
		
		if($userdata->ID){
		
			if(defined('WP_ALLOW_MULTISITE')){
				$extn .= get_current_blog_id();
			}						 
			$my_list = get_user_meta($userdata->ID, $type.$extn, true);						
							
			if(is_array($my_list) && in_array($postid, $my_list) ){
			
				$result = $my_list;							
				unset($result[array_search($postid, $result)]);
				$status = "add";
				
			}else{			 
				$result = array_merge((array)$my_list, array($postid));	
				$status = "remove"	;		
			}
			
			/*** now cleanup array(); ***/
			if(is_array($result)){
			$newResult = array();
					foreach($result as $g){
						if(is_numeric($g)){
							$newResult[] = $g;
						}
					}
			}
					
			update_user_meta($userdata->ID, $type.$extn, $newResult);
		
		}else{
			$status = "login";	
		}
		
		header('Content-type: application/json');
		$n = array("status" => $status);
		die(json_encode($n));
	
	} break;
	
	case "load_map_data": {
	
			$data =	$CORE->GEO("get_mapdata",array());
			header('Content-type: application/json');
			$n = array("mapdata" => $data );
			die(json_encode($n));
	
	} break;
	
	case "update_user_payment": {
	
		if(is_numeric($_POST['id'])){
			
		 	
			update_post_meta($_POST['id'],'order_status', $_POST['val']);
			
			// IF PAYMENT HAS AN OFFER, UPDATE THIS TOO			
			$offer_id = get_post_meta($_POST['id'],'offer_id', $_POST['val']);
			if($offer_id != ""){
				update_post_meta($offer_id,'payment_complete', date('Y-m-d H:i:s') );
			}
 			  		 	
		 	
		}
		die();
	
	} break; 
 	
	case "cancel_membership": {
	 	
		update_user_meta($_POST['uid'], 'ppt_subscription', "" );
		
		return 1; 
	
	
	} break;	
	
	case "events_set_attending": {
	
	
	$attending = get_post_meta($_POST['pid'],'attending',true);
	if(!is_array($attending)){ $attending = array(); }	
	
	if(isset($attending[$_POST['uid']] )){
	unset($attending[$_POST['uid']]);
	}else{
	$attending[$_POST['uid']] = $_POST['uid'];	
	}
		
	update_post_meta($_POST['pid'],'attending',$attending);
	
	die("ok");
	
	
	} break;
	
	case "rating_likes_check": {


		if(is_numeric($_POST['pid']) ){ 
			 
				// GET RATING IPS AND STOP THE USER FROM VOTING MULTIPLE TIMES
				$rated_user_ips = get_option('rated_user_ips');
				$user_ip = $CORE->get_client_ip();
				if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
				 
				if(isset($rated_user_ips[$_POST['pid']]) && in_array($user_ip, $rated_user_ips[$_POST['pid']]['ip-'.$user_ip])  ){ 
					
					echo "none";
					die();
				
				}else{
				
					echo "1";
					die();
				
				}
			
		}// end if if valid pid
				 
		echo "none";			
		die();
	
	} break;
	
		case "rating_likes": {	
		
		 		 
			if(is_numeric($_POST['pid']) ){ 
			 
				// GET RATING IPS AND STOP THE USER FROM VOTING MULTIPLE TIMES
				$rated_user_ips = get_option('rated_user_ips');
				$user_ip = $CORE->get_client_ip();
				if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
				 
				if(isset($rated_user_ips[$_POST['pid']]) && is_array($rated_user_ips[$_POST['pid']]['ip-'.$user_ip]) && in_array($user_ip, $rated_user_ips[$_POST['pid']]['ip-'.$user_ip])  ){ 
					
					echo "none";
					die();
				
				}else{
				
					// GET EXISTING DATA
					if($_POST['value'] == "up"){
						$result = get_post_meta($_POST['pid'], 'ratingup', true);
						if(!is_numeric($result)){ $result = 1; }else{ $result = $result + 1; }
						update_post_meta($_POST['pid'], 'ratingup', $result);
						$value = 1;
					}else{
						$result = get_post_meta($_POST['pid'], 'ratingdown', true);
						if(!is_numeric($result)){ $result = 1; }else{ $result = $result + 1; }
						update_post_meta($_POST['pid'], 'ratingdown', $result);	
						$value = 0;				
					}
					
					// SAVE RESULTS			
					$total = get_post_meta($_POST['pid'], 'rating_total', true);	
					if(!is_numeric($total)){ $total = 1; }else{ $total = $total + 1; }	
					update_post_meta($_POST['pid'], 'rating_total', $total);
					
					
					// UPDATE LIKES COUNTER
					$CORE->USER("update_rating_likes", $_POST['pid']);
					 
					// SAVE USER IP
					if(!isset($rated_user_ips[$_POST['pid']]['ip-'.$user_ip])){ $rated_user_ips[$_POST['pid']]['ip-'.$user_ip] = array(); }
					$rated_user_ips[$_POST['pid']]['ip-'.$user_ip] = array_merge($rated_user_ips[$_POST['pid']]['ip-'.$user_ip],array("ip" => $user_ip, "rating" => $value));
					update_option('rated_user_ips', $rated_user_ips); 
					
					echo $result;
					die();
				
				}
			
			}// end if if valid pid
				 
			echo "none";			
			die();
			
		} break;
	
	
		// CHANGE MESSAGE STATUS ONCLICK	
		case "msg_changestatus": {	
				if(is_numeric($_POST['id'])){			
						update_post_meta($_POST['id'],"status","read");	
						}					 	
		} break;
	
 
		case "validateUsername": {				
		
			if(strlen($_POST['name']) > 2){
			
				$dd = get_user_by( 'login',  str_replace("-"," ",strip_tags($_POST['name'])) );	
				 
				if(isset($dd->ID)){
					die("yes");
				}
			}	
			die("0");
									
		} break;
		
		case "resendvemail": {
				 
				// ADD LOG					
				$CORE->FUNC("add_log",
							array(				 
								"type" 			=> "user_verify",							 
								"userid" 		=> $_POST['uid'],								
								"email_data" 	=> array(	
									"user_id" 		=> $_POST['uid'],			 		
									"username" 		=> $CORE->USER("get_username", $_POST['uid']),
									"first_name" 	=> $CORE->USER("get_firstname", $_POST['uid']),
									"last_name" 	=> $CORE->USER("get_lastname", $_POST['uid']),
									"password" 		=> "",
									"email" 		=> $CORE->USER("get_email", $_POST['uid']),		 
								)			 
							)
				);
		
			die(json_encode(array("status" => "sent", "uid" => $_POST['uid'] )));
		
		} break;


		case "update_usage": {				

				// UPDATE LAST USED
				update_post_meta($_POST['pid'],'lastused', current_time( 'mysql' ));		
				
				// USED COUNT
				update_post_meta($_POST['pid'],'used', get_post_meta($_POST['pid'],'used',true) + 1);
				
		} break;
	
		case "sms_test": {	
			die($CORE->SENDSMS_ADMIN($_POST['num'], $_POST['msg']));
		} break;
		
		case "sms_sendcode": {
			
			$response = "invalid number";
			if(isset($_POST['num']) && $_POST['num'] > 6){
			
			$response = $CORE->SENDSMS_ACTIVATION($_POST['pf'].$_POST['num']);
			
			}
			die($response);
		
		} break;
		
		case "sms_validatecode": {
		
			if($_POST['code'] == date('ymd')){
			die("ok");
			}else{
			die("error");
			}	
		
		} break;
	
		case "get_email_content": {
			
			$emailid = $_POST['emailid'];
			
			// EMAILS
			$ppt_emails = get_option("ppt_emails");

			if(is_array($ppt_emails)){ 
				foreach($ppt_emails as $key => $field){ 
				
					if($emailid == $key){
						die($field['message']);
					}
				 
				} 
			} 
		
			die();
		
		} break;
				
		/*
			this function gets a users email
			address from their user id
		*/
		case "get_user_email": {
		
			$userid = $_POST['uid'];
			if(is_numeric($userid)){
				die(get_the_author_meta( 'email', $userid));
			}
			
			die();		
		} break;
	
		case "load_media_delete": {
		
			update_post_meta($_POST['pid'], 'image','');
			die();
		
		} break;
		
		
		case "setbg_file": {
		
			$status = "error";
			if(isset($_POST['aid']) && is_numeric($_POST['aid']) ){
			
				update_post_meta($_POST['pid'], "backgroundimg", "custom-".$_POST['aid']);
				
				$status = "ok";
			
			}
			
			header('Content-type: application/json');
			$n = array("status" => $status);
			die(json_encode($n));
			
		} break;
		
		
		case "delete_file": {
		 
			if(isset($_POST['aid']) && is_numeric($_POST['aid']) && $_POST['aid'] == "9999"){
			
			delete_post_meta($_POST['pid'],'image','');	
			die();
			
			}elseif(isset($_POST['aid']) && is_numeric($_POST['aid'])){
			  
				// GET EXISTS MEDIA ARRAYS
				$get_type = array("image_array", "videothumbnails_array", "video_array", "doc_array", "music_array");			
				// LOOP ARRAYS TO GET ALL MEDIA DATA
				foreach($get_type as $type){		
					// GET THE MEDIA DATA FOR THIS ARRAY
					$data = get_post_meta($_POST['pid'],$type,true);	 
					if(is_array($data)){
					// LOOP THROUGH, CHECK AND DELETE
						$new_array = array();			
						foreach($data as $media){
							if($media['id'] != $_POST['aid']){
								$new_array[] = $media;
							}else{
								$delsrc 	= $media['filepath'];
								$delthumbsrc = $media['thumbnail'];				
								
							}// end if
						}// end foreach	
						// UPDATE MEDIA FILE ARRAY
						update_post_meta($_POST['pid'],$type,$new_array);	
					}// end if
				} // end foreach
				// LOOP THROUGH AND REMOVE THE ONE WE DONT WANT
				
				// DELETE FILE FROM WORDPRESS MEDIA LIBUARY
				if ( false === wp_delete_attachment($_POST['aid'], true) ){	
					//die("could not delete file");
				} 
				
				// FALLBACK IF SYSTEM IS NOT DELETING IMAGES
				if(strlen($delsrc) > 1 && file_exists($delsrc)){ @unlink($delsrc); } 
				if(strlen($delthumbsrc) > 1){ 	
					$ff = explode("/",$delsrc);
					$fg = explode($ff[count($ff)-1],$delsrc);
					$fd = explode("/",$delthumbsrc);
					$thumbspath = $fg[0].$fd[count($fd)-1]; 
					if(file_exists($thumbspath)){					
					@unlink($thumbspath);
					}
				} 
			
			}
			
			if(isset($_POST['stopc'])){
			die();
			}
		
		} break;
		
		case "get_media_dimentions": {
		
		$image_attributes = wp_get_attachment_image_src( $_POST['aid'] , 'full' );
		die(json_encode(array("w" => $image_attributes[1], "h" => $image_attributes[2] )));
		die();
		
		} break;
		
		case "get_media_size": {
		
		$image_attributes = wp_get_attachment_image_src( $_POST['aid'] , 'full' );
		
		die(print_r($image_attributes));
		die(json_encode(array("size" => 1000 )));
		die();
		
		} break;
		
		
		
		case "set_media_order": {
		
		global $userdata;
	 
			// CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
					$post_data = get_post($_POST['aid']); 
					if($post_data->post_author == $userdata->ID || user_can($userdata->ID, 'administrator') ){
					
					$haschanged = false;
					
					// SET FEATURED IMAGE
					if($_POST['order'] == 1){
				 	set_post_thumbnail($_POST['pid'], $_POST['aid']);
					}
					
					// LOOP ALL ITEMS
					foreach(array("image_array", "video_array", "doc_array", "music_array") as $switch){
						
						 	if($haschanged){ continue; }
							$t = array();
							$g = get_post_meta($_POST['pid'], $switch, true);							
							
							if(is_array($g) && !empty($g) ){	
								 					
								foreach($g as $img){
									if($img['id'] == $_POST['aid']){
										$haschanged = true;
										$img['order'] = $_POST['order'];
									}
									$t[] = $img; 
								}
								
								if($haschanged){
								update_post_meta($_POST['pid'], $switch, $t);
								}
													
							} // end if
							
						}// end foreach	
						 
					}
					die();
		
		} break;
		case "set_media_title": {
		
			
			// MAKE SURE THE USER IS THE AUTHOR
			$post_data = get_post($_POST['aid']); 
			if($post_data->post_author == $userdata->ID || is_admin() ){
					
				$the_post 				= array();
				$the_post['ID'] 		= $_POST['aid'];
				$the_post['post_title'] = strip_tags(strip_tags($_POST['title']));
				wp_update_post( $the_post );
				 
				die(__("Caption Updated.","premiumpress")); 
			}	
		 
		} break;
	
	
		
	
		case "quickview": {
		global $post;
		$post = new stdClass();
		$post->ID 				= $_POST['pid'];
		$post->post_type 		= "listing_type";
		$post->post_title		= get_the_title($post->ID);
		
		?>
        <?php _ppt_template('single','quickview'); ?>
        <?php
		
		die();
		
		} break;
		
		
	
		case "load_categories": {
		
		 echo wp_list_categories(array(
                'walker'=> new Walker_CategorySelection, 
                'taxonomy' => THEME_TAXONOMY, 
                'show_count' => 1, 
                'hide_empty' => 0, 
                'echo' => 0, 
                'parent' => $_POST['parent'],
                'title_li' =>   "",
				'level' => $_POST['level']
				) 
            ); 
		
		die();
		
		} break;
		
		 
case "load_taxonomy_list": {	

	$output = ""; $default = ""; $parent_count = 0;
	
	$list = array();
	$list = explode(",",$_POST['parent']);
	
	// RMOVE LAST VALUE
	if(count($list) > 0){
	unset($list[count($list)-1]);
	}
	 
	  
	foreach($list as $key => $pid){ 
	 
		if(!is_numeric($pid) || is_numeric($pid) && $pid == 0){ continue; }
		 
		// GET LIST OF ALL PARENTS FROM SUB MENU
		$parent_terms = get_terms($_POST['taxonomy1'] ,array(  'orderby'    => 'count', 'hide_empty' => 0, 'parent' => $pid ));	
		 
		$parent_count = $parent_count + count($parent_terms);
									 				 			
		if ( !empty( $parent_terms ) && !is_wp_error( $parent_terms ) ){
		 
			$s = (isset( $_POST['child'] )) ? $_POST['child'] : '';	
			$selec = explode(",", $s);
			 
			foreach ( $parent_terms as $term ) {
					
				if(in_array($term->term_id, $selec) ){ $a = "selected=selected"; }else{ $a = ""; }	
				
				// DEFAULT
				if($default == ""){
					$default = $term->term_id;
				}
				
				// OUTPUT						   
				$output .= "<option value='".$term->term_id."' ".$a.">" . $CORE->GEO("translation_tax", array($term->term_id, $term->name ))  . "</option>"; // (".$term->count.") 		
									   				
			}// foreach	
				
		}	/// end if
	
	}// end for loop
	 
	// REPORT AJAX
	header('Content-type: application/json');
	die(json_encode(array("total" => $parent_count, "default" => $default, "output" => $output, "list" => $list )));
	

} break;



case "upload_wpmediafile": {
	
		
		$pid = $_POST['pid'];
		
		
		if(isset($_POST['video'])){
		
		$storage_key = "video_array";
		$title = $_POST['title'];
		
			$SQL = "SELECT ID, guid FROM ".$wpdb->prefix."posts WHERE post_title LIKE ('%".strip_tags($title)."%') LIMIT 1";				 		
			$sub_results = $wpdb->get_results($SQL);
			if(isset($sub_results[0])){
			
				$aid = $sub_results[0]->ID;
				$attachment_metadata = wp_get_attachment_metadata( $aid );
				$uploads = wp_upload_dir();	
				
				$save_file_array = array(
					'name' 		=> $attachment_metadata['original_image'],
					'type'		=> $attachment_metadata['mime_type'],
					'postID'	=> $pid,
					'size'		=> 100,
					'src' 		=> $sub_results[0]->guid,						
					'thumbnail' => '',						
					'filepath' 	=> $sub_results[0]->guid,
					'id'		=> $aid,
					'default' 	=> 0,
					'order'		=> 0,						
					'dimentions' => 0,						
					'dpi' 		=> 0,						
				);
				
				update_post_meta($pid,$storage_key, ""); // RESET DEFAULT ONE AS WE ONLYHAVE 1 VIDEO UPLOAD
				
			
			}else{
			
			die("error finding video");
			}
		
		
		}else{
		
			$storage_key = "image_array";
			
			if(isset($_POST['videothumb'])){
			
			$storage_key = "videothumbnails_array";
			update_post_meta($pid,$storage_key, ""); // RESET DEFAULT ONE AS WE ONLYHAVE 1 VIDEO UPLOAD			 	
				
			}
			
			
			$aid = $_POST['aid'];
			$aurl = $_POST['aurl'];
			
			$attachment_metadata = wp_get_attachment_metadata( $aid );	
			$uploads = wp_upload_dir();	
			
			if($attachment_metadata['sizes']['thumbnail']['file'] == ""){
			$thumbnail = $aurl;
			}else{
			$thumbnail = $uploads['url']."/".$attachment_metadata['sizes']['thumbnail']['file'];			
			} 
			
			$save_file_array = array(
					'name' 		=> $attachment_metadata['original_image'],
					'type'		=> "image/jpg",
					'postID'	=> $pid,
					'size'		=> 100,
					'src' 		=> $aurl,						
					'thumbnail' => $thumbnail,						
					'filepath' 	=> $uploads['basedir']."/".$attachment_metadata['file'],
					'id'		=> $aid,
					'default' 	=> 0,
					'order'		=> 0,						
					'dimentions' => 0,						
					'dpi' 		=> 0,						
				);
				
				//die(print_r($save_file_array));
				
				 
		
		} 
			
 				
		// ADD TO MY IMAGE GALLERY ARRAY
		$my_existing_images = get_post_meta($pid,$storage_key, true);
		if(is_array($my_existing_images)){					
			$new_array = array();
			$new_array[] = $save_file_array;
			foreach($my_existing_images as $img ){ $new_array[] = $img; }						
		}else{				
			$new_array = array();
			$new_array[] = $save_file_array;									
		}				 		
		// SAVE
		update_post_meta($pid,$storage_key,$new_array);

	// REPORT AJAX
	header('Content-type: application/json');
	die(json_encode(array("status" => "ok", "msg" => $aid )));
	
	
} break;
	
		case "savelisting": {	global $userdata;
		 
		  // PREPARE DATA
		  $data = array(); 
		  $current_post_status = "";
		  parse_str($_POST['data'], $data);		       
		    
		  // IS ADMIN EDITOR
		  $isAdminEditor = false;
		  if(isset($data['custom']['adminareaedit']) && $data['custom']['adminareaedit'] == 1){
		  $isAdminEditor = true;		  
		  }		  
		     
			// VALIDATION
			if(strlen($data['form']['post_title']) < 2){ 		
			die(__("Please provide more details, your listing is too short.","premiumpress"));			 
			}			
			
			// SETUP WORDPRESS ALUES FOR NEW POST
			
			if($isAdminEditor){
			 	
				$tags_to_strip = array("form","code"  );
				$CONTENT = $data['form']['post_content'];
				foreach ($tags_to_strip as $tag)
				{
					$CONTENT = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/","", $CONTENT);
				
				}
				
				// CLEAN UP ADMIN IMAGES
				$CONTENT = preg_replace( '/(width|height)="\d*"\s/', "", $CONTENT );
				 
				
 			}else{
			$CONTENT = stripslashes(strip_tags(str_replace("http://","",str_replace("https://","",$data['form']['post_content']))));	
			}
			 
			// ADD TAGS TO CONTENT FOR BETTER SEARCHING
			// SAVE POST TAGS
			if(isset($data['form']['post_tags'])){
				
				// DELETE OLD TAGS
				$CONTENT = preg_replace('#<div id="ppt_keywords">(.*?)</div>#', ' ', stripslashes($CONTENT));
				$CONTENT .= '<div id="ppt_keywords">'.str_replace(","," ",strip_tags($data['form']['post_tags']))."</div>";					
			}
		 	
			$my_post = array(
				'post_type'		=> 'listing_type',
				'post_title' 	=> esc_html($data['form']['post_title']),
				'post_modified' => current_time( 'mysql' ),
				'post_excerpt' => ' ',
				'post_content' 	=> $CONTENT,
			);			
			
			if(isset($data['form']['post_excerpt']) ){ 
				$my_post['post_excerpt'] = $data['form']['post_excerpt']; 						 
			}			
			 
			// LISTING STATUS			
			if(isset($data['form']['post_status']) ){ 
			
				$my_post['post_status'] 	= $data['form']['post_status']; // ADMIN OVERWRITE
			
			}
			
			
				
			if(isset($data['repost']) && isset($data['eid']) && THEME_KEY == "at"){
				
					// RESET BID STRINGS
					update_post_meta($data['eid'],	'bidstring', '');				
					update_post_meta($data['eid'],	'user_maxbid_data', '');								
					update_post_meta($data['eid'],	'relisted', current_time( 'mysql' ) );	
					update_post_meta($data['eid'],	'status', '0');					
					update_post_meta($data['eid'], "listing_expiry_date", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +30 days") ) );
				  
				}	
			
			 
			 
			// UPDATE LISTING DATA  ************************************************************************************************/
 
			if( isset($data['eid']) && $data['eid'] != 0 ){
			 
				
				// GET AND SAVE POST STATUS
				$current_post_status = get_post_status($data['eid']);	
				if($current_post_status == "draft"){
					$my_post['post_status'] 	= "publish";
				}	
				
				
				if(_ppt(array('lst', 'default_listing_status')) == "pending"  ){ //				
					
					$my_post['post_status'] 	= "pending_approval"; // USER EDIT					
				
				}elseif( isset($data['packageID']) && in_array(_ppt('pak'.$data['packageID'].'_price'), array("","0"))){
					$my_post['post_status'] 	= "publish"; // EVERYTHING ELSE
				}
				
				// ADMIN CHANGES
				if($isAdminEditor){
					$my_post['post_status'] 	= $data['form']['post_status']; 
				}
				
				if(isset($data['repost']) && THEME_KEY == "at"){
					$my_post['post_status'] 	= "publish"; 
				}
				
					
				$my_post['ID'] = $data['eid'];
				 
				wp_update_post( $my_post );
				$POSTID = $data['eid'];				
				
				
				// CHECK IF HAS HITS
				if(get_post_meta($data['eid'], 'hits', true) == ""){
				$CORE->USER("update_user_free_membership_addon", array("listings", $userdata->ID) );				
				$CORE->USER("update_user_free_membership_addon", array("listings_max", $userdata->ID) );	
				}
                
                $new_author_id = intval($data['post_author_override']);
                  if (isset($data['post_author_override']) && isset($data['eid'])) {
                            // Update the post author
                            wp_update_post(array(
                                'ID' => $POSTID,
                                'post_author' => $new_author_id,
                            ));
                        
                    }else{
                    // Check if the current user can edit the post
                            // Update the post author
                            wp_update_post(array(
                                'ID' => $my_post['ID'],
                                'post_author' => $new_author_id
                            ));
                    }
				
			}else{
			
			
				if(_ppt(array('lst', 'default_listing_status')) == "pending"  ){ //
				
					$my_post['post_status'] 	= "pending_approval"; // USER EDIT
				
				}elseif(isset($data['form']['totalprice']) && is_numeric($data['form']['totalprice']) && $data['form']['totalprice'] > 0 ){	
				
					$my_post['post_status'] 	= "payment"; // PENDING PAYMEN				
				
				}else{
				
					$my_post['post_status'] 	= "publish"; // EVERYTHING ELSE					
				}	
			
				$POSTID = wp_insert_post( $my_post );					
				
				
				
				// UPDATE FREE LISTING COUNTER
				if($userdata->ID){
					$CORE->USER("update_user_free_membership_addon", array("listings", $userdata->ID) );				
					$CORE->USER("update_user_free_membership_addon", array("listings_max", $userdata->ID) );			
				} 			
						 
			}
		 
			// SEND EMAILS  ************************************************************************************************/
			 
			if(!isset($data['oldeid'])){
			
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 		=> "listing_added",	
						"postid"	=> $POSTID,				 
					)
				);				
				
				// SEND EMAIL
				$data1 = array(		
					"username" => $userdata->display_name,	
					"item_title" => get_the_title($POSTID),
					"item_link" => get_permalink($POSTID),	
					"title" => get_the_title($POSTID),
					"link" => get_permalink($POSTID),
					"ID" => $POSTID,
				);				 
				
				// SEND EMAILS
				$CORE->email_system($userdata->ID, 'newlisting', $data1);	
				$CORE->email_system("admin", "admin_listing_new", $data1);			
			
			}else{
				
				// SEND EDIT LISTING EMAIL
				$data1 = array(		
					"username" => $userdata->display_name,	
					"item_title" => get_the_title($POSTID),
					"item_link" => get_permalink($POSTID),	
					"title" => get_the_title($POSTID),
					"link" => get_permalink($POSTID),
					"ID" => $POSTID,
				); 
										
				
				// SEND APPROVAL EMAIL
				//if( _ppt(array('lst', 'default_listing_status')) == "pending" && !isset($_GET['eid'])  ){
				//$CORE->email_send(get_option('admin_email'), __("Listing Requires Approval","premiumpress")." (#".$POSTID.")", $data1['item_link'] );
				//}
				
			
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 		=> "listing_update",	
						"postid"	=> $POSTID,				 
					)
				);
				// SEND EMAIL
				$CORE->email_system("admin", "admin_listing_update", $data1);		
				
			
			}
			
			// USER TYPE
			if(THEME_KEY == "ex"){
			
				$gh = get_user_meta($userdata->ID, 'user_type', true );
				if($gh == "user_em"){
				update_post_meta($POSTID, 'user_type', "user_em");
				}else{
				update_post_meta($POSTID, 'user_type', "user_fr");
				}
			}
			
			
			// FIENDS SYSTEM  ************************************************************************************************/
			if(_ppt(array('user', 'friends')) == "1"){
			
				// CHECK ALL USERS WHO HAVE ADDED ME AS A FRIEND
				$gg = $CORE->USER("get_subscribers_followingme", $userdata->ID);				
			
				if(is_array($gg) && !empty($gg)){
					$sendAlready = array();
					foreach($gg as $key => $val){
					
						if(!in_array($val,$sendAlready)){
							
							// ADD TO ARRAY
							$sendAlready[$val] = $val;
						 
							// ADD LOG
							$CORE->FUNC("add_log",
													array(				 
														"type" 			=> "friend_listing_update",									
														"postid"		=> $POSTID,									
														"to" 			=> $val, 						
														"from" 			=> $userdata->ID,	
														"from_name" 	=> $CORE->USER("get_username", $userdata->ID),							
														"alert_uid1" 	=>  $val,									
														 
														"email_data" 	=> array(	
															"username" 	=> $CORE->USER("get_username",$val),
															"link" 		=> get_permalink($POSTID),
															"title" 	=> get_the_title($POSTID),
														),
													)
								); 
								  
							
							}					
					
					}			
				}
			}		
			
			
			// CATEGORIES  ************************************************************************************************/
			  
			$categories = array();			 
			if(isset($data['form']['category'])){
				
				if(is_array($data['form']['category'])){
					foreach($data['form']['category'] as $cat){
						if(!is_numeric($cat) ){ continue; }
						$categories[] = $cat;
						
							// CHECK FOR USER SUBSCRIPTION EMAILS
							if( in_array(THEME_KEY, array("da", "es")) ){ }else{
							foreach($categories as $kk => $catID){
								$SQL = "SELECT user_id FROM $wpdb->usermeta WHERE meta_value LIKE ('%\"".strip_tags($catID)."\"%') AND meta_key='notify_match_data' AND user_id !=".$userdata->ID;				 		
								$sub_results = $wpdb->get_results($SQL);
								 
								 
								if (!empty($sub_results) ) {				
									foreach($sub_results as $val){
									  		
											if(get_user_meta($val->user_id,'notify_match',true) == "1" && !isset($email_sent)){
											
											$email_sent = 1;
											
											// ADD LOG
											$CORE->FUNC("add_log",
												array(				 
													"type" 			=> "match_notification",									
													"postid"		=> $POSTID,									
													"to" 			=> $val->user_id, 						
													"from" 			=> 1,	
													"from_name" 	=> __("Name","premiumpress"),								
													"alert_uid1" 	=>  $val->user_id,									
													 
													"email_data" 	=> array(	
														"username" 	=> $CORE->USER("get_username",$val->user_id),
														"link" 		=> get_permalink($POSTID),
														"title" 	=> get_the_title($POSTID),
													),
												)
											); 
											
											}
										
										}	
														
									}				
								}
							}
						
						
					}
				}
				
				
				
			 
				
							
				// UPDATE CAT LIST
				wp_set_post_terms( $POSTID, $categories, THEME_TAXONOMY );
			}
			
			
			
			// EXPIRY DATE ************************************************************************************************/
			  	
				
			if( isset($data['custom']['adminareaedit']) && isset($data['custom']['listing_expiry_date'])  ){  // 1. CHECK ADMIN EDIT
				
					update_post_meta($POSTID, "listing_expiry_date", $data['custom']['listing_expiry_date'] );
				
			}elseif( $CORE->LAYOUT("captions","listings")  && isset($data['packageID']) && ( !isset($data['oldeid']) || isset($data['repost']) ) ) { // 2. NEW LISTING
					
					// FALLBACK
					$duration = _ppt('pak'.$data['packageID'].'_duration');	
								 
					if(is_numeric($duration) && $duration > 0){
							
							update_post_meta($POSTID, "listing_expiry_date", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +".$duration." days") ) );
						
					}
						
			}
				
				
			if(isset($data['custom']['listing_expiry_days']) && is_numeric($data['custom']['listing_expiry_days']) && ( !isset($data['oldeid'])  || isset($data['repost']) )  ){ //3. DAYS EXPIRY (AUCTION THEME )
						// UPDATE EXPIRY DATE
						
					if($data['custom']['listing_expiry_days'] == "0.5"){
						
							update_post_meta($POSTID, "listing_expiry_date", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +30 minutes") ) );
						
					}elseif($data['custom']['listing_expiry_days'] == "0.1"){
						
							update_post_meta($POSTID, "listing_expiry_date", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +1 hour") ) );
							
					}else{
						
							update_post_meta($POSTID, "listing_expiry_date", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ). " +".$data['custom']['listing_expiry_days']." days") ) );						
					}	
				
			}
				
			// CUSTOM DATA  ************************************************************************************************/
 
			if(isset($data['custom']) && is_array($data['custom'])){ 	
			
				foreach($data['custom'] as $key => $val){ 
				 	
					// PASS ON SOME KEYS
					if($key == "listing_expiry_days" || $key == "adminareaedit" || $key == "listing_expiry_date" ){ continue; }
					 
					// CLEAN SOME ATTRIBUTES
					if(substr($key,0,5) == "price"){
						$val = preg_replace('/[^\da-z.]/i', '', $val);
					} 
				 	
					// SAVE DATA
					if($val == ""){
						delete_post_meta($POSTID, strip_tags($key));
					}elseif(is_array($val)){					 
						update_post_meta($POSTID, strip_tags($key), $val);
					}else{
						update_post_meta($POSTID, strip_tags($key), esc_html(strip_tags(trim($val))));
					}
					
				} 
				
			}
			
			// POST TAGS  ************************************************************************************************/

			if(isset($data['form']['post_tags'])){
			 
				wp_set_post_tags( $POSTID, explode(",",strip_tags($data['form']['post_tags'])), false);		
			
			}

			// POST TAXONOMY  ************************************************************************************************/

			if(isset($data['tax']) && is_array($data['tax'])){ 	
			 	 
				foreach($data['tax'] as $key => $val){ 
				
					// REGISTER IF DOESNT EXIST
					if(!taxonomy_exists($key)){
					register_taxonomy( $key, 'listing_type', array( 'hierarchical' => true, 'labels' =>'', 'query_var' => true, 'rewrite' => true ) ); 
					}
										  
					// SAVE DATA
					$g = wp_set_post_terms( $POSTID, $val, $key );
					
					if( in_array(THEME_KEY, array("da", "es")) && $key == "dagender" ){
					 
						$SQL = "SELECT user_id FROM $wpdb->usermeta WHERE meta_value LIKE ('%\"".strip_tags($val)."\"%') AND meta_key='notify_match_data' AND user_id !=".$userdata->ID;				 		
						$sub_results = $wpdb->get_results($SQL);
						if (!empty($sub_results) ) {				
						
						foreach($sub_results as $val){
						
							if(get_user_meta($val->user_id,'notify_match',true) == "1"){
											
											// ADD LOG
											$CORE->FUNC("add_log",
												array(				 
													"type" 			=> "match_notification",									
													"postid"		=> $POSTID,									
													"to" 			=> $val->user_id, 						
													"from" 			=> 1,	
													"from_name" 	=> __("Name","premiumpress"),								
													"alert_uid1" 	=>  $val->user_id,									
													 
													"email_data" 	=> array(	
														"username" 	=> $CORE->USER("get_username",$val->user_id),
														"link" 		=> get_permalink($POSTID),
														"title" 	=> get_the_title($POSTID),
													),
												)
											); 
											
											}
										
										}	
														
									}			
					
					
					}
			
				}
			}
			
			// IMAGE UPLOADS  ************************************************************************************************/

			if(isset($_FILES['image']) && is_array($_FILES['image']) ){	 // && 
			 
				$u=0;
				foreach($CORE->reArrayFiles($_FILES['image']) as $file_upload){			
					if(strlen($file_upload['name']) > 1){
						if(isset($data['eid']) || $u == 0){
						$responce = hook_upload($POSTID, $file_upload,true);
						}else{
						$responce = hook_upload($POSTID, $file_upload);
						}
						if(isset($responce['error'])){
							$canContinue = false;			
							$errorMsg = $responce['error'];
						}// end if
						$u++;
					} // end if			
				} // end foeach
			} // end if
			
			
			
			// ADD-ON ATTRIBUTES  ************************************************************************************************/
 
			if(isset($data['attributes']) && is_array($data['attributes']) && !empty($data['attributes'])){
			update_post_meta($POSTID,"attributes",$data['attributes']);
			}else{
			update_post_meta($POSTID,"attributes","");
			}
 
			// YOUTUBE  ************************************************************************************************/

			if(isset($data['youtube_id']) && ( strlen($data['youtube_id']) > 8 && strlen($data['youtube_id']) < 13 )   ){
				update_post_meta($POSTID, 'youtube_id', esc_attr( $data['youtube_id'] ) );
			}	
			
			// BUSINESS HOURS ************************************************************************************************/
			
			if(isset($data['startTime'])){	
			
				$businesshours = array( 'start' => $data['startTime'], 'end' => $data['endTime'], 'active' => $data['isActive']  );				 
				update_post_meta($POSTID,"businesshours", $businesshours);				 
			}
			
			// PRICE COMPARISON ************************************************************************************************/
			
			if(isset($data['comparedata'])){
			update_post_meta($POSTID,"comparedata", $data['comparedata'] );	
			}
			
			// ADDONS FOR FEATURE UPGRADES
			/************************************************************************************************/
			
 			// ADD ON FOR MJ THEME
			if(in_array(THEME_KEY, array("mj","dt"))){
			update_post_meta($POSTID, 'customextras', $data['customextras']);
			}	
 	 
		 
			// PAYMENT SHOULD BE WORKED OUT FROM THE PACKAGE ID
			// TO SAVE HACKING
			/************************************************************************************************/
			
			
			
			// 0. CHECK THEIR EXISTING PACKAGEID AND COMPARE AGAINST NEW ONE
			
			if(isset($data['oldeid']) && is_numeric($data['oldeid']) ){
				
				$currentpakid = get_post_meta($data['oldeid'], 'packageID', true);
				
				 	
				if(is_numeric($currentpakid) && $currentpakid != "0" && is_numeric($data['packageID']) && $currentpakid != $data['packageID']){
				
					$PackageUpgrade = 1;
					
					// RESET
					update_post_meta($POSTID, 'featured', "0" );
					update_post_meta($POSTID, 'sponsored', "0" );
					update_post_meta($POSTID, 'homepage', "0" );					
					 
					$allorders = $CORE->ORDER("get_listing_orders", $POSTID);	
					
					if(is_array($allorders) && !empty($allorders)){	
						
						foreach($allorders as $order){
							 	
							// CHECK IS PENDING PAYMENT
							$d = $CORE->ORDER("get_order", $order['id']);								 					
							if($d['order_status'] == 2){									
								
								// DELETE INVOICE
								$CORE->ORDER("delete", $order['id'] );				
							}
							  
						}
					
					}
				
				}
			
			}
			
			
			
		  
			// 1. FIRST ADDON - DEFAULT OPTIONS			
			$addonpayment_totaldue = 0;
			if(isset($data['custom']['adminareaedit']) && $data['custom']['adminareaedit'] == 1){			
				
				// ADMIN EDIT				
				if(isset($data['addon_featured']) && $data['addon_featured'] == 1){ 
					update_post_meta($POSTID, 'featured', "1" );
				}else{
					update_post_meta($POSTID, 'featured', "0" );
				}
				
   				if(isset($data['addon_sponsored']) && $data['addon_sponsored'] == 1){ 
					update_post_meta($POSTID, 'sponsored', "1" );
				}else{
					update_post_meta($POSTID, 'sponsored', "0" );
				}
				
    			if(isset($data['addon_homepage']) && $data['addon_homepage'] == 1){
					update_post_meta($POSTID, 'homepage', "1" );
				}else{
					update_post_meta($POSTID, 'homepage', "0" );
				} 
			
			
			}else{ 
			
			
			
			
			
			
			$addons_array = $CORE->PACKAGE("get_packages_addons", array() );			
		
 			if(!empty($addons_array) && isset($data['packageID']) ){
			
				foreach($addons_array as $a){
				
					$checkthiskey =  'pak'.$data['packageID'].'_'.str_replace("addon_","",$a['key']);					 
					
					if(_ppt($checkthiskey) == 1){
				 
						// UPGRADE PACKAGE
						$CORE->PACKAGE("package_process_upgrade", array( str_replace("addon_","",$a['key']), $POSTID) );					
					
					}elseif( isset($data[$a['key']]) && $data[$a['key']] == 1 ){ 
						 
						
						// CHECK ITS ENABLED
						if( _ppt(array('lst', $a['key'].'_enable')) == '1'){	
						
						
							// CHECK FOR PAID UPGRADE
							$pp = _ppt(array('lst', $a['key'].'_price'));							 
							
							// CHECK IF ACCOUNT ALREADY HAS THIS ADDED
								
							if(get_post_meta($POSTID, str_replace("addon_","",$a['key']), true) == 1){ // DO NOTHING ITS ALREADY SET
							
							 
							}else{							
							
								// ADD-ON UPGRADE
								$CORE->PACKAGE("package_process_upgrade", array( str_replace("addon_","",$a['key']), $POSTID) );
								
								if( is_numeric($pp) && $pp > 0){							
									
									$eorder = "";
									
									// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
									$ex = $CORE->ORDER("check_exists", "UPGRADE-".$POSTID);
									
									// CHECK IT'S NOT EXPIRED
									// RESET IT SO USE RPAYS AGAIN
									if( isset($data['oldeid']) && strlen($ex) > 0 && in_array($current_post_status, array("pending","expired")) && get_post_meta($data['eid'],'listing_expiry_date',true) == "" ){
										$ex = "";				
									}
									
									if(isset($data['repost'])){
										$ex = "";
										$eorder = "-repost".rand(0,1000);	
									}
								 
									if(!$ex){
									
									 	// 3. ADD NEW ORDER/INVOICE
										$ex = $CORE->ORDER("add", array( 
											"order_id" => "UPGRADE-".$POSTID."-".str_replace("addon_","",$a['key']).$eorder,
											"order_status" => 2, // pending
											"order_total" => $pp,
											"order_userid" => $userdata->ID,
											"order_postid" => $POSTID,											
											"order_description" => $a['name']." ".__(" upgrade for ","premiumpress")." ".get_the_title($POSTID), 
											
										) );										
									
									}
								
								}
							
							}
						
						} 
					
					}
								
				}			
			}
			
			} 
		  
		 
			
			// 1. CHECK IF PACKAE REQUIRES PAYMENT
			$g = $this->PACKAGE("get_packages", array());
			 
			if( isset($data['custom']['adminareaedit']) ){ 
			
			// DO NOTHING!!
			  
			}elseif(isset($data['packageID']) && isset($g[$data['packageID']]['price']) && is_numeric($g[$data['packageID']]['price']) && $g[$data['packageID']]['price'] > 0){
		 		
				$eorder = "";
				
				// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
				$ex = $CORE->ORDER("check_exists", "UPGRADE-".$POSTID);					 
				 
				// CHECK IT'S NOT EXPIRED
				// RESET IT SO USE RPAYS AGAIN
				if( isset($data['oldeid']) && strlen($ex) > 0 && in_array($current_post_status, array("pending","expired")) && get_post_meta($data['eid'],'listing_expiry_date',true) == "" ){
					$ex = "";				
				}
				
				if(isset($data['repost'])){
					$ex = "";
					$eorder = "-repost".rand(0,1000);	
				}
				
				if(isset($PackageUpgrade) && $PackageUpgrade == "1"){
					$ex = "";
					$eorder = "-upgrade".rand(0,1000);
				}
				 
				if(!$ex){
				
					//die("here 2".print_r($data));
				
					// 3. ADD NEW ORDER/INVOICE
					$ex = $CORE->ORDER("add", array( 
						"order_id" => "UPGRADE-".$POSTID.$eorder,
						"order_status" => 2, // pending
						"order_total" => $g[$data['packageID']]['price']+$addonpayment_totaldue,
						"order_userid" => $userdata->ID,
						"order_postid" => $POSTID,
						"order_description" => $g[$data['packageID']]['name']." ".__(" upgrade for ","premiumpress")." ".get_the_title($POSTID), 
						
					) );
					 
					
					// SET STATUS TO WAITING PAYMENT??
					if($my_post['post_status'] != "pending_approval"){
						$my_post = array();
						$my_post['ID'] 					= $POSTID;
						$my_post['post_status']			= "payment";
						wp_update_post( $my_post  );
					}
				
				}			
			
			}elseif(isset($data['packageID']) && isset($g[$data['packageID']]['price']) && is_numeric($g[$data['packageID']]['price']) && $g[$data['packageID']]['price'] == 0){
			 
				// 2. CHECK IF THERE IS AN EXISTING ORDER FOR THIS
				$ex = $CORE->ORDER("check_exists", "LST-".$POSTID);
			 
				if($ex){
				
					// CHECK IS PENDING PAYMENT
					$d = $CORE->ORDER("get_order", $ex);
					if($d['order_status'] == 2 && $d['order_total'] > 0){
						
						// DELETE INVOICE
						$CORE->ORDER("delete", $ex );				
					}
					
					 
				}
			
			}
			
			if(!isset($data['packageID']) || ( isset($data['packageID']) && !isset($g[$data['packageID']]['price']) ) ){ $data['packageID'] = 0; }
			
			update_post_meta($POSTID, 'packageID', $data['packageID'] );		
			 
			
			// REDIRECT
			/************************************************************************************************/

			 
			// IF IS NEW RETURN PAYMENT DATA		
			
			if( isset($data['custom']['adminareaedit']) ){
			
				// REDIRECT LINK 	
				$redirect = home_url()."/wp-admin/admin.php?page=listings&done=1&eid=".$POSTID;				
				
				die($redirect);			
				
			}else{
			
				// REDIRECT LINK 	
				$redirect = get_permalink($POSTID);				
				
				die($redirect);
			}
			 
			 
			
		} break;
		
 		
		
case "SaveRating": {
				
					// LOAD IN LANGUAGE
					 
					if(is_numeric($_POST['pid']) && is_numeric($_POST['value'])){
					// GET RATING IPS AND STOP THE USER FROM VOTING MULTIPLE TIMES
					$rated_user_ips = get_option('rated_user_ips');  $user_ip = $CORE->get_client_ip();
					if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
					
						if(isset($rated_user_ips[$_POST['pid']]) && isset($rated_user_ips[$_POST['pid']]['ips']) && in_array($user_ip, $rated_user_ips[$_POST['pid']]['ips']) ){							
							echo ''.__("You've Already Rated!","premiumpress");
							die();
							
						}elseif(isset($rated_user_ips[$_POST['pid']]) && isset($rated_user_ips[$_POST['pid']]['ips']) && !in_array($user_ip, $rated_user_ips[$_POST['pid']]['ips']) ){
						 
							$rated_user_ips[$_POST['pid']]['ips'] = array_merge($rated_user_ips[$_POST['pid']]['ips'],array("ip" => $user_ip, "rating" => $_POST['value']));
							update_option('rated_user_ips', $rated_user_ips); 
						}
						
					// GET RATING IPS
					$rated_user_ips = get_option('rated_user_ips');  $user_ip = $CORE->get_client_ip();
					if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
					if(isset($rated_user_ips[$user_ip])){ return; }else{ update_option('rated_user_ips', array_merge($rated_user_ips,array($user_ip))); }					 
					// GET EXISTING DATA
					$totalvotes = get_post_meta($_POST['pid'], 'starrating_votes', true);
					$totalamount = get_post_meta($_POST['pid'], 'starrating_total', true);
					if(!is_numeric($totalamount)){ $totalamount = $_POST['value']; }else{ $totalamount += $_POST['value']; }
					if(!is_numeric($totalvotes)){ $totalvotes = 1; }else{ $totalvotes++; }
					// WORK OUT RATING
					$save_rating = round(($totalamount/$totalvotes),2);
					// SAVE RESULTS
					update_post_meta($_POST['pid'], 'starrating', $save_rating);
					update_post_meta($_POST['pid'], 'starrating_total', $totalamount);
					update_post_meta($_POST['pid'], 'starrating_votes', $totalvotes);
					
					echo ''.__("Thank You!","premiumpress");
					die();
				 
					//echo $save_rating." <-- total votes:".$totalvotes." / total amount: ".$totalamount;
					}
				} break;
		
 
	
		case "update_mylocaton": {
		
			/// SET USER LOCATION
			if(isset($_POST['long'])){
			 		
					$_SESSION['mylocation']['log'] = strip_tags($_POST['long']);
					$_SESSION['mylocation']['lat'] = strip_tags($_POST['lat']);
					$_SESSION['mylocation']['zip'] = strip_tags($_POST['zip']);
					
					$_SESSION['mylocation']['country'] = strip_tags($_POST['country']);
					$_SESSION['mylocation']['address'] = strip_tags($_POST['address']);
					die("ok");
			}
			die("error");
		
		} break;
		
		case "get_location_states": {
		
		if(isset($GLOBALS['core_state_list'][$_POST['country_id']])){
			
			if(isset($_POST['showany'])){
			?>
            <option value=""><?php echo __("Any City/State","premiumpress"); ?></option>
            <?php
			}
			
			$states = explode("|",$GLOBALS['core_state_list'][$_POST['country_id']]);
			foreach($states as $state){
			?>
            <option value="<?php echo $state; ?>" <?php if($state == $_POST['state_id']){ echo "selected=selected"; } ?>><?php echo $state; ?></option>
            <?php
			}
		}
		
		die();
		
		} break;	
	
		case "SaveSession": { 
		global $CORE_CART;
				$table_data = $CORE_CART->cart_getitems();
				$wpdb->query("DELETE FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".session_id()."') LIMIT 1");	
				$wpdb->query("INSERT INTO ".$wpdb->prefix."core_sessions (`session_key` ,`session_date` ,`session_userid`, session_data) VALUES ('".session_id()."', '".date('Y-m-d H:i:s')."', '".$userdata->ID."', '".serialize($table_data)."')");
			 die();
		} break;			
		case "UpdateUserField":
		case "update_userfield": {
				
				if(isset($_POST['id']) && $_POST['id'] == "cartcomment"){
				   
					if($userdata->ID){
					
						$SQL = "SELECT * FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".strip_tags($_POST['key'])."') LIMIT 1";						 
						$hassession = $wpdb->get_results($SQL, OBJECT);					 
						if(!empty($hassession)){
						
							$cart_data 				= unserialize($hassession[0]->session_data);
							$cart_data['comments'] 	= stripslashes(strip_tags($_POST['value']));
							
							$wpdb->query("UPDATE ".$wpdb->prefix."core_sessions SET session_data = '".serialize($cart_data)."' WHERE session_key = ('".strip_tags($_POST['key'])."') LIMIT 1"); 
							
							die("UPDATE ".$wpdb->prefix."core_sessions SET session_data = '".serialize($cart_data)."' WHERE session_key = ('".strip_tags($_POST['key'])."') LIMIT 1");
							 
						} 
					
					}else{
					
						update_option('cartc_' . stripslashes(strip_tags($_POST['value'])) , stripslashes(strip_tags($_POST['key'])) );
					 
					} 
					
				}else{
					
					update_user_meta($_POST['id'], strip_tags($_POST['key']), strip_tags($_POST['value']));
			 
				}
				
				die();
							
		} break;
		
		case "server_time": {
		
			header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
			header("Expires: Fri, 1 Jan 2010 00:00:00 GMT"); // Date in the past 
			header("Content-Type: text/plain; charset=utf-8"); // MIME type 
			$now = new DateTime(); 
		 	die(json_encode(array("time" => $now->format("M j, Y H:i:s O")  )) );
		
		} break;
		
		
		case "single_msg": {
		
		
		$user 		= strip_tags( esc_attr($_POST['u']));
		$message 	= strip_tags( esc_attr($_POST['m']));
		
		$canContinue = true;
		
		if(is_numeric($user)){
			$uid = $user;
		}else{	
			$dd = get_user_by( 'login',  $user );
			$uid =  $dd->ID;		
		}
		
		// #1 VALIDATE
		if(strlen($message) < 5){ 
			$canContinue = false;	
		}
		
		
			
		if($canContinue && $userdata->ID ){
			
			
			$my_post = array();
				$my_post['post_title'] 		= "new conversation";
				$my_post['post_content'] 	= strip_tags(strip_tags($message));
				$my_post['post_excerpt'] 	= "";
				$my_post['post_status'] 	= "publish";
				$my_post['post_type'] 		= "ppt_message";
				$my_post['post_author'] 	= $userdata->ID;
				$POSTID 					= wp_insert_post( $my_post );
								
				add_post_meta($POSTID, "sender_id", $userdata->ID);
				add_post_meta($POSTID, "reciever_id", $uid );			
				 
				
				// EASY TO FIND CUSTOM FIELD
				add_post_meta($POSTID, "msg_stick", "[".$uid."][".$userdata->ID."]");
				add_post_meta($POSTID, "msg_status", "unread_".$uid);		
				 
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 			=> "msg_new",											 
						"to" 		=> $uid, 						
						"from" 		=> $userdata->ID,						
						"alert_uid1" 	=>  $uid,
					)
				);
				
				die(json_encode(array("status" => "ok"  )));
			
		}
		
		die(json_encode(array("status" => "error"  )));
		
		
		} break;
	
		case "single_contactform": {
				
		
		$name 		= strip_tags( esc_attr($_POST['n']));
		$email 		= strip_tags( esc_attr($_POST['e']));
		$message 	= strip_tags( esc_attr($_POST['m']));
		$phone 		= strip_tags( esc_attr($_POST['p']));
		$code 		= strip_tags( esc_attr($_POST['c']));
		$post_id 	= strip_tags( esc_attr($_POST['pid']));		
		$code_answer = strip_tags( esc_attr($_POST['ca']));				
		
		if($code == $code_answer && $code != ""){
        
        
          // Process uploaded images
        if (!empty($_FILES['images'])) {
            $uploaded_images = $_FILES['images'];

            // Check if there are uploaded files
            if (!empty($uploaded_images['name'][0])) {
                $upload_dir = wp_upload_dir(); // Get WordPress upload directory

                foreach ($uploaded_images['tmp_name'] as $key => $tmp_name) {
                    $file_name = $uploaded_images['name'][$key];
                    $file_type = $uploaded_images['type'][$key];
                    $file_size = $uploaded_images['size'][$key];
                    $file_error = $uploaded_images['error'][$key];

                    // Check for upload errors
                    if ($file_error == 0) {
                        $upload_path = $upload_dir['path'] . '/' . $file_name;

                        // Move uploaded file to the WordPress uploads directory
                        if (move_uploaded_file($tmp_name, $upload_path)) {
                            // Optionally, store the image URL to use in email
                            $image_url = $upload_dir['url'] . '/' . $file_name;
                            
                            // Append image link to message
                            $message .= "\r\n Dealer License: <br><br> <img src='". $image_url ."' alt='Dealer License' style='max-width: 300px; height: auto;'>";
                        }
                    }
                }
            }
        }
        
        
        
	 			 
			// GET POST DATA
			if(is_numeric($post_id)){
					
					$post 		= get_post($post_id);	
					$user_info 	= get_userdata($post->post_author);
					$ussid 		= $user_info->ID;
					$link 		= get_permalink($post_id);
					
					// UPDATE LEADS COUNTER					
					$leads = get_post_meta($post_id, "leads", true);
					if(!is_numeric($leads)){
					$leads = 0;
					}
					$leads++;					
					update_post_meta($post_id, "leads", $leads);
					 
			}else{
					$ussid = 1;	
					$link = "";			
			}
			
			
			// captcha code from Google
			if(isset($_POST['captcha'])){ 
				 
				$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret="._ppt(array('captcha','secretkey'))."&response=".$_POST['captcha']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
				if ($response['success'] != false) {
				
				}else{
				
				 
				//die(json_encode(array("status" => "error", "msg" => "captcha invalid"  )));
				
				} 
			
			} 
		 
			// SAVE MESSAGE
			$Message = "".__("Name","premiumpress").": ".$name."\r\n
							".__("Email","premiumpress").": ".$email."\r\n
							".__("Phone","premiumpress").": ".$phone." \r\n
							".__("Message","premiumpress").": ".$message."\r\n";
			if(strlen($link) > 1){
			$Message .= __("Link","premiumpress").": <a href='".$link."'>".$link."</a>\r\n"; 
			}
			
				
			if(!$userdata->ID){	$userid = 1;}else{	$userid = $userdata->ID; }
				
							
				$my_post = array();
				$my_post['post_title'] 		= "contactform";
				$my_post['post_content'] 	= $Message;
				$my_post['post_excerpt'] 	= "";
				$my_post['post_status'] 	= "publish";
				$my_post['post_type'] 		= "ppt_message";
				$my_post['post_author'] 	= $userid;
				$POSTID 					= wp_insert_post( $my_post );
							
				add_post_meta($POSTID, "reciever_id", $ussid);
				add_post_meta($POSTID, "sender_id", $userid);
				add_post_meta($POSTID, "contactform", 1);
							
				// EASY TO FIND CUSTOM FIELD
				add_post_meta($POSTID, "msg_stick", "[".$ussid."][".$userid."]");
				add_post_meta($POSTID, "msg_status", "unread_".$ussid);	
							  
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 			=> "listing_message",									
						"postid"		=> $post_id,									
						"to" 			=> $ussid, 						
						"from" 			=> $userid,	
						"from_name" 	=> __("Name","premiumpress"),								
						"alert_uid1" 	=>  $ussid,									
						"data"  		=> $Message,
						"email_data" 	=> array(	
							"message" => $Message,
						),
					)
				); 
				
				// SEND MESSAGE TO ADMIN
				if($_POST['pid'] == ""){
					  
					// SEND
					$CORE->email_send(get_option('admin_email'), __("New list submitted for sell Form","premiumpress")." - ".date("F j, Y"), $CORE->email_message_filter($Message, array()));
				
				}
		
				// RETURN MSG
				die(json_encode(array("status" => "ok" )));
		}
		
		// RETURN MSG
		die(json_encode(array("status" => "error"  )));
	 	 	 
					
		} break;
	
		case "newsletter_join" : {	
				
				  
				if( !preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i", $_POST['email']) && $CORE->get_client_ip() != "error" ) {
				
					$status =  "error";
				 
				}else{
				
					
					// MAKE HAS FOR THIS USER
					$hash = md5($_POST['email'].rand());
					
					$data = array(						
						"email" => strip_tags($_POST['email']),
						"hash" => $hash,
					);
					
					$uid = $CORE->EMAIL("newsletter_add", $data);					 
				
					// BUILD LINK FOR EMAIL
					$_POST['link'] = get_home_url()."/confirm/mailinglist/".$hash;	
						 
					// SEND OUT CONFIRMATION EMAIL				 
					$subject = stripslashes(_ppt(array('newsletter','confirmation_title')));				
					$message = str_replace("(link)", $_POST['link'] ,stripslashes(_ppt(array('newsletter','confirmation_message'))) );				
					
					// SEND EMAIL
					$CORE->email_send($_POST['email'], $subject, $message);
					
					// PROVIDE USER MESSAGE
					$status = "ok";			
					}
				
				die(json_encode( array("status" => $status) ) );
				
		} break;
	
		case "listing_enhancements": {
		
			die($CORE->listing_enhancements($_POST['pid']));
		
		} break;
	
		case "listing_relist": {
			
			if(isset($_POST['pid']) && is_numeric($_POST['pid']) ){
			
				// GET REILIST PRICE
				$relist = $this->relist_price($_POST['pid']);
				
				// START DATE FOR RENEWAL encase
				// user is upgrading early
				$listing_expiry_date = get_post_meta($_POST['pid'],'listing_expiry_date',true); 
				if( strtotime($listing_expiry_date) < strtotime(current_time( 'mysql' ))  ){	
				$datenow = current_time( 'mysql' );
				}else{
				$datenow = $listing_expiry_date;
				}
		 		
				// WORK OUT HOW LONG TO UPGRADE FOR
				if(isset($relist['days']) && $relist['days'] > 0){ $extdasy = $relist['days']; }else{ $extdasy = 30; }
				
				if($relist['price'] > 0){
				
					// ADD NEW PAYMENT REQUEST TO LISTING
				
				
				}else{ 
				
					// UPGRADE LISTING FOR FREE
					if($relist['days'] == 0){
					
					} 
					
					hook_relist_listing_action($postid);
					
					// SAVE THE NEW DATE
					update_post_meta($_POST['pid'], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime($datenow . " +".$extdasy." days"))); 
				
				}
				
				// RETURN MSG
				die(json_encode(array("status" => "ok")));
			
			}
		
		} break;
		
		 		
		case "listing_featured": {
		
			if(isset($_POST['pid']) && is_numeric($_POST['pid']) ){
			
				$type = $_POST['type'];
				
				if($type == "sponsor"){
				$tn = "sponsored";
				}else{
				$tn = "featured";
				}
				
			
				$featured = get_post_meta($_POST['pid'], $tn, true);
				
				if($featured == "no"){
					update_post_meta($_POST['pid'], $tn, "yes");	
					$featured = "yes";				
				}else{
					update_post_meta($_POST['pid'], $tn, "no");	
					$featured = "no";				 
				}
				
				die(json_encode(array("current" => $featured)));
			
			}		
		}
		case "listing_delete": {
		
			if(isset($_POST['pid']) && is_numeric($_POST['pid']) ){
			
			 	
				// CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
				$post_data = get_post($_POST['pid']); 
				 		
				if(isset($post_data->post_author) && $post_data->post_author == $userdata->ID || function_exists('current_user_can') && current_user_can('administrator') ){			 	
				
				$my_post = array();
				$my_post['ID'] 					= $_POST['pid'];
				$my_post['post_status']			= "trash";
				wp_update_post( $my_post  );
				
				if(function_exists('current_user_can') && current_user_can('administrator') ){	
				wp_delete_post( $_POST['pid'] );
				}
				
				// DELETE ALL ATTACHMENTS
				$CORE->UPLOAD_DELETEALL($_POST['pid']);
				
				 // ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "listing_deleted",	
							"postid"	=> $_POST['pid'],
							"userid"  	=> $userdata->ID,	
						)
					);
				
				
				// ERROR MESSAGE
				die(json_encode(array("status" => "ok")));
				
				}else{
				
				die(json_encode(array("status" => "error")));
					
				}
				
			} // end if
			
			return false;	
		
		} break;
		case "check_couponcode": {
			
			// CHECK
			if(!isset($_POST['code']) || ( isset($_POST['code']) && $_POST['code'] == "") ){
			
				echo json_encode(array("status" => "error"));
				die();
			}
		 	
			$ppt_coupons = get_option("ppt_coupons");
			 
			// CHECK WE HAVE SUCH A CODE
			if(is_array($ppt_coupons) && count($ppt_coupons) > 0 ){
				foreach($ppt_coupons as $key => $field){
					if($_POST['code'] == $field['code']){	
						
						
						// UPDATE USED COUNTER
						if(!isset($ppt_coupons[$key]['used'])){ 
							$ppt_coupons[$key]['used'] = 1; 
						}else{ 
							$ppt_coupons[$key]['used'] = $ppt_coupons[$key]['used']+1; 
						}
					 
				 		
						// WORK OUT DISCOUNT AMOUNT
						$discount = $field['discount_percentage'];
						if($discount != ""){													   						
							$dc = str_replace(",","",$_POST['amount'])/100*$discount;							 						
						}else{
							$dc = $field['discount_fixed']; 
						}
						
						if(!is_numeric($dc)){
							$discount = 0;
						}else{						
							$discount = $dc;
						}
						
						// CALCULATE NEW AMOUNT
						$amount = intval(strval($_POST['amount'])) - $discount;
						
						if($amount < 0){
						$amount = 0;
						}
						  
						
						$rr = 0;
						$rd = 0;
						
						if(isset($_POST['recurring']) && is_numeric($_POST['recurring'])){
						$rr = $_POST['recurring'];
						}
						if(isset($_POST['recurring_days']) && is_numeric($_POST['recurring_days'])){
						$rd = $_POST['recurring_days'];
						}
						 
						$cartdata = array(
							"uid" 			=> $userdata->ID, 
							"amount" 		=> $amount,
							"order_id" 		=> $_POST['orderid'],
							"description" 	=> $_POST['desc'],	
							"couponcode" 	=> $_POST['code'],
							"old_amount"	=> strval($_POST['amount']),
							"recurring" 	=> $rr,
							"recurring_days" => $rd,												
						);
						
						// UPDATE COUNTER
						update_option("ppt_coupons", $ppt_coupons);						 
						
						if(defined('WLT_CART') ){
						$_SESSION['discount_code'] 			= strip_tags($_POST['code']);
						$_SESSION['discount_code_value'] 	= $discount;
						}
						
						// REPORT AJAX
						header('Content-type: application/json');
						$n = array("status" => "ok", "total" => hook_price($amount), "total_value" => $amount, "code" => $CORE->order_encode($cartdata), "discount"=> hook_price($discount), "old_amount"	=> strval($_POST['amount']), );
						echo json_encode($n);
						die();
						 				 				 
					}			
				} // end foreach
							 
			} // end if				
			 
			
			echo json_encode(array("status" => "error"));
			die();
		
		} break; 
		
		
		
		case "load_new_payment_form_recalculate": {
			
			if(isset($_POST['details'])){
			 	 
				// DECODE DATA
				$data = array();
				$data = $CORE->order_decode($_POST['details']);
				$data->amount = $_POST['amount'];
				if(isset($_POST['orderid'])){
				$data->order_id = $_POST['orderid'];
				}
				echo $CORE->order_encode($data);
		 			
			}
			
			die();
		
		} break;
		
		case "load_new_payment_form": {
			
			if(isset($_POST['details'])){		
				
				if(isset($_POST['smallform'])){ $sm = 1; }else{ $sm = 0; }
		 	
				echo $CORE->payment_setup($_POST['details'], $sm );			
			}
			
			die();
		
		} break;
		 
		  
		case "expire_check_membership": {
		
			die($CORE->USER("membership_active", $_POST['pid']));			
			
		} break;
		
		case "validateexpiry":  
		case "expire_check_listing": {
		
			die($CORE->expire_listing($_POST['pid']));			
			
		} break; 
	
		case "addfeedback": {
		 
		 
					$time = current_time('mysql');	
					$data = array(
							'comment_post_ID' => $_POST['pid'],
							'comment_author' => $userdata->display_name,
							'comment_author_email' => 'admin@admin.com',
							'comment_author_url' => 'http://',
							'comment_content' => strip_tags(strip_tags($_POST['message'])),
							'comment_type' => '',
							'comment_parent' => 0,
							'user_id' => $userdata->ID,
							'comment_author_IP' => $this->get_client_ip(),
							'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
							'comment_date' => $time,
							'comment_approved' => 1,
					);
					$commentid = wp_insert_comment($data);					
						
					// SAVE COMMEN META INCASE WE DELETE IT					 			
					add_comment_meta( $commentid, 'ratingtotal', $_POST['score'] );
					add_comment_meta( $commentid, 'rating1', $_POST['score'] );
					add_comment_meta( $commentid, 'feedback', 1 );
					add_comment_meta( $commentid, 'ratingpid', $_POST['pid'] );
					
					 	  
					// EXTRAS FOR THEME CHANGES
					if(isset($_POST['extraid']) && $_POST['extraid'] != "" ){	
						
						if($_POST['sellerid'] == $userdata->ID){
							 				 
							add_post_meta($_POST['extraid'], "commentid_seller", $commentid);
							add_post_meta($_POST['extraid'], "feedback_date_seller", current_time( 'mysql' ));
							add_comment_meta( $commentid, 'feedback_for', $_POST['buyerid'] );	 							
							add_comment_meta( $commentid, 'feedback_from', $_POST['sellerid'] );
							
							// ADD LOG
							$CORE->FUNC("add_log",
								array(				 
									"type" 		=> "feedback_receieved",
									"postid" => $_POST['pid'], 
									"to" 	=> $_POST['buyerid'],
									"from" 	=> $_POST['sellerid'],	
																		
									"alert_uid1" 	=>  $_POST['buyerid'],			 
								)
							);
						
						}elseif($_POST['buyerid'] == $userdata->ID){
							
							add_post_meta($_POST['extraid'], "commentid_buyer", $commentid);
							add_post_meta($_POST['extraid'], "feedback_date_buyer", current_time( 'mysql' ));							
							add_comment_meta( $commentid, 'feedback_for', $_POST['sellerid'] );	
							add_comment_meta( $commentid, 'feedback_from', $_POST['buyerid'] );
							
							// ADD LOG
							$CORE->FUNC("add_log",
								array(				 
									"type" 		=> "feedback_receieved",
									"postid" 	=> $_POST['pid'], 
									"to" 		=> $_POST['sellerid'],
									"from" 		=> $_POST['buyerid'],	
																		
									"alert_uid1" 	=>  $_POST['sellerid'],			 
								)
							);
						
						}
									
					
					}
				  
		
		} break;
		
	
	case "delfeedback": {	
	
	
		if( !is_numeric($_POST['fid'])  ){
			die("invalid ID");
		}
		
		// CHECK FEEDBACK BELONGS TO THIS USER?
		
		wp_delete_post( $_POST['fid'], true);
		
		// DELETE ALL FEEDBACK WITH THIS REPLY ID
		
		$args = array(
			'post_type' => 'ppt_feedback',
			'posts_per_page'	=> '150',
			'meta_query' => array(
					 
					array(
						'key'		=> 'replyid',
						'value' 	=> $_POST['fid'],
						'compare' 		=> '=',
					),
					 
				),
		);
		$query1 = new WP_Query($args); 
		$data = $query1->posts;
		// GET USER FEEDBACK
		if(!empty($data)){  foreach($data as $post){
			wp_delete_post( $post->ID, true);		
		}}
		
		// LEAVE MESSAGE FOR THE USER
		$GLOBALS['error_message'] 	= __("Feedback Deleted","premiumpress");
			
	
	} break;
	
	case "sellspace_set": {
		
		if(!is_numeric($_POST['cid'])){ return; }
	
		// SET NEW BANNER ID
		update_post_meta($_POST['cid'], 'bannerid', esc_attr($_POST['bannerid']));
		
		// UPDATE LINK
		update_post_meta($_POST['cid'], 'url', esc_attr($_POST['camurl']) ); 
		
		// UPDATE STATUS
		update_post_meta($_POST['cid'], 'status', "active" ); 
		
		// IF THE EXISTING VALUE IS BLANK THEN LETS ASUME THIS IS THE FIRST TIME WE'VE UPLOAD
		// SO WE SHOULD START THE ADVERTISING PERIOD FROM NOW ON
		
		$timeleft = get_post_meta($_POST['cid'], 'expires', true);
		if($timeleft == ""){
			$campaign = get_post_meta($_POST['cid'], 'campaign', true);
			$DAYS = $sellspacedata[$campaign."_days"];
			if($DAYS == ""){ $DAYS = 30; }
			$sellspacedata = $GLOBALS['CORE_THEME']['sellspace']; 
			update_post_meta( $_POST['cid'], 'expires', date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +".$DAYS." days")) );
		}
		
		// MSG
		$GLOBALS['error_message'] = __("Banner Set Successfully","premiumpress")."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#SellSpaceTabs a[href=\"#a3\"]').tab('show'); });</script>";
	
	} break;
	
	case "sellspace_delete": { 
		
		// DELETE FILES
		@unlink(get_post_meta($_POST['delid'],'path', true));
			 
		// NOW LETS SAVE THE NEW ONE	
		wp_delete_post( $_POST['delid'], true );
		
		die(json_encode(array("status" => "ok")));
		 
	} break;
	
	case "sellspace": {
	
	$GLOBALS['error_message']= "";
		 
		if(is_array($_FILES['ppt_banner'])){
			$i = 0;
			foreach($_FILES['ppt_banner'] as $banner){
			 
			if(!isset($_FILES['ppt_banner']['name'][$i]) || ( isset($_FILES['ppt_banner']['name'][$i]) && $_FILES['ppt_banner']['name'][$i] == "") ){ $i++; continue; }
			 
				if(in_array($_FILES['ppt_banner']['type'][$i], array('image/jpg','image/jpeg','image/png', 'image/gif') ) ){
					
					// INCLUDE UPLOAD SCRIPTS
					$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
					if(!function_exists('wp_handle_upload')){
					require $dir_path . "/wp-admin/includes/file.php";
					}
					
					// GET WORDPRESS UPLOAD DATA
					$uploads = wp_upload_dir();
					
					// UPLOAD FILE 
					$file_array = array(
						'name' 		=> $_FILES['ppt_banner']['name'][$i], //$userdata->ID."_userphoto",//
						'type'		=> $_FILES['ppt_banner']['type'][$i],
						'tmp_name'	=> $_FILES['ppt_banner']['tmp_name'][$i],
						'error'		=> $_FILES['ppt_banner']['error'][$i],
						'size'		=> $_FILES['ppt_banner']['size'][$i],
					);
					//die(print_r($file_array));
					$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));
				 
					// CHECK FOR ERRORS
					if(isset($uploaded_file['error']) ){		
						$GLOBALS['error_message'] .= $uploaded_file['error'];
					}else{
					
					// GET SIZES
					list($width, $height) = getimagesize($uploaded_file['file']);
					 
					$my_post = array();
					$my_post['post_title'] 		= strip_tags($_FILES['ppt_banner']['name'][$i]);
					$my_post['post_content'] 	= $width."X".$height."=".$_FILES['ppt_banner']['size'][$i];
					$my_post['post_excerpt'] 	= $uploaded_file['url'];
					$my_post['post_status'] 	= "publish";
					$my_post['post_type'] 		= "ppt_banner";
					$my_post['post_author'] 	= $userdata->ID;
					$POSTID 					= wp_insert_post( $my_post );
					
					// ADD CUSTOM FIELDS
					add_post_meta($POSTID,'img', $uploaded_file['url']);	
					add_post_meta($POSTID,'path', $uploaded_file['file']);
					add_post_meta($POSTID,'size', $_FILES['ppt_banner']['size'][$i]);
					add_post_meta($POSTID,'width', $width);
					add_post_meta($POSTID,'height', $height);
					
					}
					
					$i++;
					
				}else{
				$GLOBALS['error_message'] .= __("File Type Invalid","premiumpress")." (".$_FILES['ppt_banner']['name'][$i].")<br>";
				}
			}
		}
		
		// MSG
		if($GLOBALS['error_message'] == ""){
		$GLOBALS['error_message'] = __("Banners Saved Successfully","premiumpress");
		}
		
		$GLOBALS['error_message'] .= "<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#SellSpaceTabs a[href=\"#a2\"]').tab('show');   });</script>";
	
	
	} break;
	
	case "add_gift": {
		
		
		$status = "error";
	
		if(is_numeric($_POST['pid'])){
		
			$gifts = get_post_meta($_POST['pid'],"gifts", true);
			
			if(!is_array($gifts)){ $gifts = array(); }
			
			if(isset($gifts[$_POST['uid']])){
			
				$status = "found";
			
			}else{			
			
				$gifts[$_POST['uid']] = array(
				 	"to" => $_POST['rid'],
					"from" => $_POST['uid'],
					"gift" => $_POST['gift'],
					"date" => date('Y-m-d H:i:s'),
				);
				update_post_meta($_POST['pid'],"gifts", $gifts);
								
				$status = "ok";
			}			
			
			
		}
		
	
		die(json_encode(array("status" => $status)));
	
	} break;
	
	case "cashback_new": {
	
		if(is_numeric($_POST['total']) && $_POST['total'] > 0){
		 
		 	$my_post = array();
			$my_post['post_title'] 		= "Cashback request ".date('Y-m-d H:i:s');
			$my_post['post_content'] 	= "";
			$my_post['post_excerpt'] 	= "";
			$my_post['post_status'] 	= "publish";
			$my_post['post_type'] 		= "ppt_cashback";
			$my_post['post_author'] 	= $userdata->ID;
			$POSTID 					= wp_insert_post( $my_post );
			
			update_post_meta($POSTID,"cashback_reftotal", $_POST['total']);
			update_post_meta($POSTID,"cashback_refid", $_POST['orderid']);
			update_post_meta($POSTID,"cashback_pid", $_POST['pid']);
			
			update_post_meta($POSTID,"cashback_userid", $userdata->ID);		 		
			
			update_post_meta($POSTID,"cashback_status", 0);
			update_post_meta($POSTID,"cashback_date", date('Y-m-d H:i:s'));
			
			// ADD LOG					
				$CORE->FUNC("add_log",
							array(				 
								"type" 			=> "admin_cashback",							 
								"userid" 		=> $userdata->ID,								
								"email_data" 	=> array(	
									"user_id" 		=> $_POST['uid'],			 		
									"username" 		=> $CORE->USER("get_username", $userdata->ID),
									"first_name" 	=> $CORE->USER("get_firstname", $userdata->ID),
									"last_name" 	=> $CORE->USER("get_lastname", $userdata->ID),
									
									"email" 		=> $CORE->USER("get_email", $userdata->ID),		 
								)			 
							)
				);
					
			// SAVE A COPY TO THE DATABASE
			die(json_encode(array("status" => "ok")));
			 
		}	
	
	} break;
	
	case "cashout_new": {
	
		if(is_numeric($_POST['total']) && $_POST['total'] > 0){
		 
		 	$my_post = array();
			$my_post['post_title'] 		= "Cashout request ".date('Y-m-d H:i:s');
			$my_post['post_content'] 	= "";
			$my_post['post_excerpt'] 	= "";
			$my_post['post_status'] 	= "publish";
			$my_post['post_type'] 		= "ppt_cashout";
			$my_post['post_author'] 	= $userdata->ID;
			$POSTID 					= wp_insert_post( $my_post );
			
			update_post_meta($POSTID,"cashout_total", $_POST['total']);
			update_post_meta($POSTID,"cashout_notes", $_POST['msg']);
			update_post_meta($POSTID,"cashout_userid", $userdata->ID);
			update_post_meta($POSTID,"cashout_email", $CORE->USER("get_email", $userdata->ID));
			
			
			update_post_meta($POSTID,"cashout_status", 2);
			update_post_meta($POSTID,"cashout_process", 1);
			
			
			// ADD LOG					
				$CORE->FUNC("add_log",
							array(				 
								"type" 			=> "admin_cashout",							 
								"userid" 		=> $userdata->ID,								
								"email_data" 	=> array(	
									"user_id" 		=> $userdata->ID,			 		
									"username" 		=> $CORE->USER("get_username", $userdata->ID),
									"first_name" 	=> $CORE->USER("get_firstname", $userdata->ID),
									"last_name" 	=> $CORE->USER("get_lastname", $userdata->ID),									
									"email" 		=> $CORE->USER("get_email", $userdata->ID),		
									"amount" 		=>  $_POST['total'],
								)			 
							)
				);
			
					
			// SAVE A COPY TO THE DATABASE
			die(json_encode(array("status" => "ok")));
			 
		}	
	
	} break;
	

 
 
 	case "load_chat_list": {
	
		$SQL = "SELECT DISTINCT meta_value FROM ".$wpdb->prefix."postmeta AS mt1 WHERE mt1.meta_key = 'msg_stick' AND mt1.meta_value LIKE ('%[".$userdata->ID."]%') ORDER BY meta_id DESC";
		$useridlist = array(); 
		$result = $wpdb->get_results($SQL);
		 
		foreach($result as $j){
		
			$h = str_replace("[]","",$j->meta_value);
			$k = explode("]", $h);
			foreach($k as $n){
			
				$id = str_replace("[","",$n);
				if(is_numeric($id)  ){ //&& $userdata->ID != $id
				
					$date = date("Y-m-d H:i:s");				 
				 
					// GET THE LAST CHAT TIME 					
					$SQL = "SELECT ".$wpdb->prefix."posts.post_date FROM ".$wpdb->prefix."posts 
					INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id AND  mt1.meta_key = 'msg_stick' 
					AND ( mt1.meta_value LIKE '%[".$id."][".$userdata->ID."]%' OR  mt1.meta_value LIKE '%[".$userdata->ID."][".$id."]%' ) )  
					WHERE  1= 1
					AND ".$wpdb->prefix."posts.post_status = 'publish' 
					AND ".$wpdb->prefix."posts.post_type = 'ppt_message' ORDER BY ".$wpdb->prefix."posts.post_date DESC LIMIT 1";					 
					$result = $wpdb->get_results($SQL);	
					
					foreach($result as $bb){
						$date = $bb->post_date;
					}
					 
					$useridlist[$id] = array("uid" => $id, "last" => $date);
				
				
				}			
			}		
		}
		
		 
	 	array_multisort(array_map('strtotime',array_column($useridlist,'last')),SORT_DESC,  $useridlist);
 		
		ob_start();
		foreach($useridlist as $u => $ud){
		
		if($ud['uid'] == $userdata->ID && $userdata->ID != 1){ continue; }
		 
		if(!isset($lastuid )){ $lastuid = $ud['uid']; } // GET FIRST ID FOR OUR USER LIST
		
		$vv = $CORE->date_timediff($ud['last']);	 
		
		?><div class="col-lg-12 col-md-12 user-<?php echo $ud['uid']; ?> contact" data-uid="<?php echo $ud['uid']; ?>">
										<div class="row">
											<div class="col-lg-3 col-md-3 col-2 contact-left">
												<div class="user-status bg-success"></div>
												
                                                <?php echo $CORE->USER("get_photo", $ud['uid']); ?>
											</div>
											<div class="col-lg-9 col-md-9 col-10 contact-infos">
												<h3><b class="name_of_contact"><?php echo $CORE->USER("get_username", $ud['uid']); ?></b></h3>
												<p><span class="chat-timing"><?php echo $vv['string-small']; ?> <?php echo __("ago","premiumpress") ?></span></p>
											</div>
										</div>
		</div>        
        <?php
		}
	
		$output = ob_get_contents();
		ob_end_clean();	
		
		if(!isset($lastuid)){ $lastuid = 0; }				
		
		// REPORT AJAX
		header('Content-type: application/json');
		die(json_encode(array("status" => "ok", "total" => number_format(count($useridlist)), "output" => $output, "last_userid" => $lastuid)));
				
	
	} break; 
	
	case "load_chat_data": {
		
	
		$u1 = $userdata->ID;
		$u2 = $_POST['rid'];
		
		if(!is_numeric($u1) || !is_numeric($u2) ){
			die("invalid ID");
		}
		
		$limit = 10;
		if(isset($_POST['limit']) && is_numeric($_POST['limit'])){
			$limit = $_POST['limit'];		
		}		
		
		if(is_numeric(_ppt(array('user','messages_limit'))) ){		
		$limit = _ppt(array('user','messages_limit'));		
		}
		 
		
		
		// MSSAGES BETWEEN USER
		$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id AND  mt1.meta_key = 'msg_stick' 
		AND ( mt1.meta_value LIKE '%[".$u2."][".$u1."]%' OR  mt1.meta_value LIKE '%[".$u1."][".$u2."]%' ) )  
		WHERE  1= 1
		AND ".$wpdb->prefix."posts.post_status = 'publish' 
		AND ".$wpdb->prefix."posts.post_type = 'ppt_message' ORDER BY ".$wpdb->prefix."posts.post_date DESC LIMIT ".$limit;
		 
		 
		$result = $wpdb->get_results($SQL);	
		 
		
		if(is_array($result) && !empty($result) && isset($result[0]) ){
		 
			if(get_user_meta($userdata->ID, $u2."-".$u1."-last", true) == $result[0]->post_date &&  $canShow){			
				 
				if(isset($_POST['forceload']) && $_POST['forceload'] == 1){
				
				}else{
				
					// REPORT AJAX
					header('Content-type: application/json');
					die(
					json_encode(array(
						"status" => "noupdate", 
						//"total" => number_format(count($msgdata)), 
						//"output" => trim($output),
						//"sql" => $SQL 		
					)));
				
				}
			
			}else{			
			
			$d = str_replace("asdasdasd","", $result[0]->post_date );
			 
			update_user_meta($userdata->ID, $u2."-".$u1."-last", $d);
			
			}
		
		}
		
	 
		$msgdata = array();
		foreach($result  as $m){		 	 
			
			$mm = $m->post_content;			 
			 
			$hidebg = 0;
			preg_match("/\[smile:(.+?)\]/", $m->post_content, $matches);	
			if(isset($matches[1]) && is_numeric($matches[1]) ){
				
				$smiles = $CORE->USER("smiles", 0);			
				$mm = str_replace("[smile:".$matches[1]."]","<i class='ppt-smile-icon icon-size-chatwindow icon-".$smiles[$matches[1]]."'></i>", $m->post_content);
				$hidebg = 1;
			
			}
				 
			  
			if(substr($mm, 0, 4) == "[aid"){
			
			 	
				$aid = preg_replace('/[^0-9,.]/', '', $mm);
				$imgdta = get_post_meta($aid, "chat_attach_data", true); 
				if(is_array($imgdta) && !empty($imgdta)){
						
						
						 
						if(in_array($imgdta['type'],$CORE->allowed_zip_types )){						
						
						$mm = "<div class='text-center'><a href='".$imgdta['src']."' target='_blank'><img src='".get_template_directory_uri()."/framework/images/zipfile.png' class='img-fluid' ></a></div>";
						
						}else if(in_array($imgdta['type'],$CORE->allowed_image_types )){
						
						$mm = "<div class='text-center'><a href='".$imgdta['thumbnail']."' target='_blank'><img src='".$imgdta['src']."' style='min-width:200px; height:auto' class='img-fluid' ></a></div>";
						
						}
				}
			
			 
				
			}else{ 
					
					
					// MEMBERSHIP SYSTEM
					if(!isset($_POST['fullaccess']) ){
						if(!$CORE->USER("membership_hasaccess", "msg_read") && get_post_meta($m->ID, "sender_id", true) != 1){
						$mm = "<i class='fa fa-lock mr-2'></i>".__("No Access","premiumpress");			
						}
					}
					
					if($m->post_title == "contactform"){
					$mm = wpautop($mm);
					}
					
					// GIFTS IN DATING THME
					if(THEME_KEY == "da"){
					
						$gift = get_post_meta($m->ID, 'gift', true);
						if(is_numeric($gift) && $gift > 0){
						
						
						$defaultimg = get_template_directory_uri()."/_dating/icons/".$gift.".png";
						if( _ppt(array('bgimg', "gift".$gift)) == ""){			
						}else{				
							$defaultimg = _ppt(array('bgimg', "gift".$gift));				
						}
						
						
						$mm = "<div class='text-center mt-4'>".__("You've received a gift!","premiumpress")."</div>";
						$mm .= "<div class='text-center mt-4'><img src='".$defaultimg."' style='min-width:200px; height:auto ' class='img-fluid' ></div>";
						
						}			
					
					}
			
			}// end attachment
			
			$msgdata[$m->ID] = array(
			
				"msg" 		=> $mm,				
				
				"date" 		=> $m->post_date,
				"rid" 		=> get_post_meta($m->ID, "reciever_id", true),
				"rid_name" 	=> $CORE->USER("get_username", get_post_meta($m->ID, "reciever_id", true)),
				
				"sid" 		=> get_post_meta($m->ID, "sender_id", true),
				"sid_name" 	=> $CORE->USER("get_username", get_post_meta($m->ID, "sender_id", true)),
				
				"hidebg" => $hidebg,
								
				);
		
		}
		//////////////////////////////////////////////////////////////////////////////////////////
		
		
		//print_r($msgdata);
		
		//die($SQL);
		 
		$order = array_column($msgdata, 'date'); 
		array_multisort( $order, SORT_ASC, $msgdata);
		 
		 
		ob_start();		
		$showmsgcount = 0;
		foreach($msgdata as $m){
		
		$vv = $CORE->date_timediff($m['date']);	 
		
		//if($showmsgcount > 5){ continue; }
	 	
		// HIDE TIMEER FOR BETTER DISPLAY
		$showtime = 1;		
		if(!isset($lasttime)){
		$lasttime = $vv['string-small'];		 
		}else{
		
			if($vv['string-small'] == $lasttime || $vv['string-small'] == ""){
				$showtime = 0;
			} 
		}
		
		
		?>
<div class="col-lg-12 col-md-12 message-chat <?php if($m['sid'] == $userdata->ID){ ?>message-chat-right<?php }else{ ?>message-chat-left<?php } ?>">
		<div class="text-muted small"><?php echo $CORE->USER("get_photo",$m['sid']); ?> <?php 
		
		//if($m['sid'] == $userdata->ID){ echo __("you","premiumpress"); }else{ echo $m['sid_name']; } 
		
		?></div>
        <div class="message-chat-text <?php if($m['hidebg']){ echo "chaticontxt"; }else{ echo "shadow-sm"; } ?> mb-2"><span><?php echo wpautop($m['msg']); ?></span></div>
        <?php if($showtime){ ?><div class="message-chat-meta mx-4 opacity-5"><span><?php echo $vv['string-small']; ?> <?php echo __("ago","premiumpress") ?></span></div><?php } ?>
        </div>
        <?php
		$showmsgcount++;
		}
	
		$output = ob_get_contents();
		ob_end_clean();	
	 
		// REPORT AJAX
		header('Content-type: application/json');
		die(
		json_encode(array(
			"status" => "ok", 
			"total" => number_format(count($msgdata)), 
			"output" => trim($output),
			//"sql" => $SQL 		
		)));
				
	
	} break; 
	
	case "send_chat_msg": {
	
	 
	
	 	// REDUCE COUNTER
		if(_ppt(array('mem','enable')) == "1"){
			$canContinue = $CORE->USER("update_user_free_membership_addon", array("max_msg", $userdata->ID) );
			if(!$canContinue){		
			return "";
			}
		}
	
	
		$my_post = array();
		$my_post['post_title'] 		= "conversation";
		$my_post['post_content'] 	= strip_tags(strip_tags($_POST['msg']));
		$my_post['post_excerpt'] 	= "";
		$my_post['post_status'] 	= "publish";
		$my_post['post_type'] 		= "ppt_message";
		$my_post['post_author'] 	= $userdata->ID;
		$POSTID 					= wp_insert_post( $my_post );								
				
		add_post_meta($POSTID, "reciever_id", $_POST['rid']);
		add_post_meta($POSTID, "sender_id", $userdata->ID);
		
		if(isset($_POST['gift']) && is_numeric($_POST['gift']) ){		
			add_post_meta($POSTID, "gift", $_POST['gift']);
		}
		
		
		
			// ADD LOG
			$lastemail = get_user_meta($_POST['rid'], "lastemail", true);
			
			if($lastemail == "" || ( strtotime($lastemail) < strtotime( current_time( 'mysql' ) ))  ){
			
				$CORE->FUNC("add_log",
						array(				 
							"type" 			=> "msg_new",
												 
							"to" 		=> $_POST['rid'], 						
							"from" 		=> $userdata->ID,
							
							"alert_uid1" 	=>  $_POST['rid'],
							"data" => strip_tags(strip_tags($_POST['msg'])),
						)
				);
				
				update_user_meta($_POST['rid'], "lastemail", date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " + 5 minutes"))  );
			
			}
			
			
				
				
				// UPDATE LEADS COUNTER		
				if(isset($_POST['pid']) && is_numeric($_POST['pid'])){			
					$leads = get_post_meta($_POST['pid'], "leads", true);
					if(!is_numeric($leads)){
					$leads = 0;
					}
					$leads++;					
					update_post_meta($_POST['pid'], "leads", $leads);
				}	
		 
		
		
		// EASY TO FIND CUSTOM FIELD
		add_post_meta($POSTID, "msg_stick", "[".$_POST['rid']."][".$userdata->ID."]");
		 
		// REPORT AJAX
		header('Content-type: application/json');
		die(json_encode(array("status" => "ok", "last" => $lastemail, "now" => current_time( 'mysql' ) ) ) );
		
	
	} break;
	
	
	
	case "delete_userphoto": {
		
		if(isset($_POST['uid']) && is_numeric($_POST['uid'])){
		$uid =  $_POST['uid'];
		}else{
		$uid = $userdata->ID;
		}
		
		// DELETE PHOTO
		$currentimg = get_user_meta($uid, "userphoto", true);		 
		 
		// DELETE FILE
		$uploads = wp_upload_dir();
		if(isset($currentimg['path']) && strlen($currentimg['path']) > 5){		
			$imgb = explode("uploads/",$currentimg['path']);		
			if(file_exists($uploads['basedir']."/".$imgb[1])){			
				@unlink($uploads['basedir']."/".$imgb[1]); 
			}
		 }		 
		 
		// DELETE META DATA
		delete_user_meta($uid, "userphoto"); 
		
		if(isset($currentimg['aid'])){		
			wp_delete_attachment($currentimg['aid'], true);
		}
		
		// REPORT AJAX
		header('Content-type: application/json');
		die(json_encode(array("status" => "ok" )));
	
	
	} break;
	
	case "userupdate": { 
	 		 
	  
			// SAVE THE CUSTOM PROFILE DATA
			if(isset($_POST['custom']) && is_array($_POST['custom'])){ 	
	
				foreach($_POST['custom'] as $key => $val){
				
					if($val == ""){					
						delete_user_meta($userdata->ID, strip_tags($key));
					}elseif(is_array($val)){
						update_user_meta($userdata->ID, strip_tags($key), $val);
					}else{					
						update_user_meta($userdata->ID, strip_tags($key), esc_html(strip_tags($val)));					
					}
				} // end foreach
			}// end if
			
			// CHECK EMAIL IS VALID	
			if(THEME_KEY == "pj"){					
			update_user_meta($userdata->ID, 'ppt_hourlyrate', strip_tags($_POST['ppt_hourlyrate']));
			}
			
			if(THEME_KEY == "da"){					
			update_user_meta($userdata->ID, 'da-seek1', strip_tags($_POST['da-seek1']));
			}
			
			update_user_meta($userdata->ID, 'da-seek2', strip_tags($_POST['da-seek2']));
			
			
			// CHECK EMAIL IS VALID	
			if(isset($_POST['url'])){
			update_user_meta($userdata->ID, 'url', strip_tags($_POST['url']));
			}
			if(isset($_POST['phone'])){
			update_user_meta($userdata->ID, 'phone', strip_tags($_POST['phone']));
			}
			
			// SOCIAL
			if(isset($_POST['facebook'])){
			update_user_meta($userdata->ID, 'facebook', strip_tags($_POST['facebook']));
			update_user_meta($userdata->ID, 'twitter', strip_tags($_POST['twitter']));
			update_user_meta($userdata->ID, 'linkedin', strip_tags($_POST['linkedin']));
			update_user_meta($userdata->ID, 'skype', strip_tags($_POST['skype']));			 
			}
			
			// ADDRESS			
			update_user_meta($userdata->ID, 'address1', strip_tags($_POST['address1']));
			update_user_meta($userdata->ID, 'address2', strip_tags($_POST['address2']));
			update_user_meta($userdata->ID, 'zip', strip_tags($_POST['zip']));
			update_user_meta($userdata->ID, 'town', strip_tags($_POST['town']));
			
			update_user_meta($userdata->ID, 'country', strip_tags($_POST['country']));
			update_user_meta($userdata->ID, 'city', strip_tags($_POST['city']));

			// MOBILE
			if(isset($_POST['mobile']) && is_numeric($_POST['mobile'])){
				update_user_meta($userdata->ID, 'mobile', strip_tags($_POST['mobile']) );
			}
			
			// LANGUAGE
			if(isset($_POST['language'])){
			update_user_meta($userdata->ID, 'language', strip_tags($_POST['language']));
			}
			
			// USER TYPE
			if(isset($_POST['user_type']) ){			
				update_user_meta($userdata->ID, 'user_type', strip_tags($_POST['user_type']) );				
			}
			
			// EMAIL NOTIFICATIONS
			update_user_meta($userdata->ID, 'notify_match', strip_tags($_POST['notify_match']));
			if(isset($_POST['notify_match_data'])){
			update_user_meta($userdata->ID, 'notify_match_data', $_POST['notify_match_data']);
			}		
			
			
			
			// PAYPAL DETAILS
			if( _ppt(array('user','cashout')) == 1){
				update_user_meta($userdata->ID, 'payment_type', strip_tags($_POST['payment_type']) );
				update_user_meta($userdata->ID, 'paypal', strip_tags($_POST['paypal']) );			
				update_user_meta($userdata->ID, 'bank', strip_tags($_POST['bank']) );
				update_user_meta($userdata->ID, 'payaddresss', strip_tags($_POST['payaddresss']) );
			}		
			 
			 
			 
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			 
			$data = array();
			$data['ID'] 			= $userdata->ID;			
			
			// CHECK FOR USERNAME CHANGE
			if(isset($_POST['usernamechange']) && $_POST['usernamechange'] == 1){
			
				// SAVE OLD USERNAME
				update_user_meta($userdata->ID, 'old_username', $userdata->user_login);
				
				// SET NEW USER LOGIN
				$data['user_login'] 		= $_POST['newusername'];
				
				$wpdb->query("UPDATE ".$wpdb->prefix."users SET user_login = '".trim(strip_tags($_POST['newusername']))."' WHERE ID = (".$userdata->ID.") LIMIT 1"); 
				 
				 
				
			}
			// EXTRA
			$data['first_name'] 		= strip_tags($_POST['fname']);
			$data['last_name'] 			= strip_tags($_POST['lname']);
			if(isset($_POST['description'])){
		 	$data['description'] 		= strip_tags($_POST['description']);	
		 	}
			
			// UPDATE DATA
			$g = wp_update_user( $data ); 
			 	
			// CHECK IF WE ARE CHANGING PASSWORDS	
			if(!defined('WLT_DEMOMODE')){
				 
				if( ( $_POST['password'] == $_POST['password_r'] ) && $_POST['password'] !=""){
					
					$data = array();
					$data['user_pass'] 		= $_POST['password'];					
					$data['ID'] 			= $userdata->ID;
					wp_update_user( $data );	
					 
					// ADD LOG
					$CORE->FUNC("add_log",
						array(				 
							"type" 		=> "user_password",					 
						)
					);
						
					// ERROR MESSAGE
					$GLOBALS['error_message'] = __("Password Updated","premiumpress");
					
				} elseif(isset($_POST['password']) && strlen($_POST['password']) > 1){	
						
					// PASSWORD CHECK ERROR
					$GLOBALS['error_message'] = __("New Password Invalid","premiumpress");
					
				}else{
					// ERROR MESSAGE
					$GLOBALS['error_message'] = __("Profile Data Updated","premiumpress");
				}
				

				
			}// end if		
			
			
			
			// AVATAR
			update_user_meta($userdata->ID, 'myavatar', strip_tags($_POST['myavatar']) );
			 
			  
			// UPLOAD USER PHOTO			 
			if(isset($_FILES['ppt_userphoto']) && strlen($_FILES['ppt_userphoto']['name']) > 2 && in_array($_FILES['ppt_userphoto']['type'],$CORE->allowed_image_types) ){
			
			
				// DELETE PHOTO
				$currentimg = get_user_meta($userdata->ID, "userphoto", true);		 
				 
				// DELETE FILE
				$uploads = wp_upload_dir();
				if(isset($currentimg['path']) && strlen($currentimg['path']) > 5){		
					$imgb = explode("uploads/",$currentimg['path']);		
					if(file_exists($uploads['basedir']."/".$imgb[1])){			
						@unlink($uploads['basedir']."/".$imgb[1]); 
					}
					
					// DELETE META DATA
					delete_user_meta($userdata->ID, "userphoto"); 
				 }	 
			
			
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 		=> "user_photo",
						"userid" 	=> $userdata->ID,					 
					)
				);
				
				
				// LOAD IN WORDPRESS FILE UPLOAOD CLASSES
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				if(!function_exists('get_file_description')){
				if(!defined('ABSPATH')){
				require $dir_path . "/wp-load.php";
				}
				require $dir_path . "/wp-admin/includes/file.php";
				require $dir_path . "/wp-admin/includes/media.php";	
				}
				if(!function_exists('wp_generate_attachment_metadata') ){
				require $dir_path . "/wp-admin/includes/image.php";
				}				 
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['ppt_userphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['ppt_userphoto']['type'],
					'tmp_name'	=> $_FILES['ppt_userphoto']['tmp_name'],
					'error'		=> $_FILES['ppt_userphoto']['error'],
					'size'		=> $_FILES['ppt_userphoto']['size'],
				);
				
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));	  
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
				
				// set up the array of arguments for "wp_insert_post();"
				$attachment = array(			 
					'post_mime_type' => $_FILES['ppt_userphoto']['type'],
					'post_title' => "",
					'post_content' => '',
					'post_author' => $userdata->ID,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_parent' => 0,
					'guid' => $uploaded_file['url']
				);									
				
				// insert the attachment post type and get the ID
				$attachment_id = wp_insert_post( $attachment );
		
				// generate the attachment metadata
				$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
				 
				// update the attachment metadata
				$rr = wp_update_attachment_metadata( $attachment_id,  $attach_data );
				
				if(isset($attach_data['sizes']['thumbnail']['file'])){
					$thumbnail = $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
				}else{
					$thumbnail = $uploaded_file['url'];
				}	
					
			 	 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($userdata->ID, "userphoto", array('img' =>$thumbnail, 'path' => $uploaded_file['file'], "aid" => $attachment_id ) );				
				
				}
			}		
			 		
			
			
			// ADD LOG
			$CORE->FUNC("add_log",
				array(				 
					"type" 		=> "user_update",					 
				)
			);				
			
			// MESSAGE
			if(!isset($GLOBALS['error_message'])){
			$GLOBALS['error_message'] = __("Details Saved Successfully","premiumpress");
			}
			
		} break;
	
 
 



case "userupdatephoto": {
	 
	
			// AVATAR
			update_user_meta($userdata->ID, 'myavatar', strip_tags($_POST['myavatar']) );
			
			// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 		=> "user_photo",
						"userid" 	=> $userdata->ID,					 
					)
				);
			  
			// UPLOAD USER PHOTO			 
			if(isset($_FILES['ppt_userphoto']) && strlen($_FILES['ppt_userphoto']['name']) > 2 && in_array($_FILES['ppt_userphoto']['type'],$CORE->allowed_image_types) ){
			
			
				// DELETE PHOTO
				$currentimg = get_user_meta($userdata->ID, "userphoto", true);		 
				 
				// DELETE FILE
				$uploads = wp_upload_dir();
				if(isset($currentimg['path']) && strlen($currentimg['path']) > 5){		
					$imgb = explode("uploads/",$currentimg['path']);		
					if(file_exists($uploads['basedir']."/".$imgb[1])){			
						@unlink($uploads['basedir']."/".$imgb[1]); 
					}
					
					// DELETE META DATA
					delete_user_meta($userdata->ID, "userphoto"); 
				 }	 
				
				
				// LOAD IN WORDPRESS FILE UPLOAOD CLASSES
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				if(!function_exists('get_file_description')){
				if(!defined('ABSPATH')){
				require $dir_path . "/wp-load.php";
				}
				require $dir_path . "/wp-admin/includes/file.php";
				require $dir_path . "/wp-admin/includes/media.php";	
				}
				if(!function_exists('wp_generate_attachment_metadata') ){
				require $dir_path . "/wp-admin/includes/image.php";
				}				 
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['ppt_userphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['ppt_userphoto']['type'],
					'tmp_name'	=> $_FILES['ppt_userphoto']['tmp_name'],
					'error'		=> $_FILES['ppt_userphoto']['error'],
					'size'		=> $_FILES['ppt_userphoto']['size'],
				);
				
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));	  
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
				
				// set up the array of arguments for "wp_insert_post();"
				$attachment = array(			 
					'post_mime_type' => $_FILES['ppt_userphoto']['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename( $file['name'] ) ),
					'post_content' => '',
					'post_author' => $userdata->ID,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_parent' => 0,
					'guid' => $uploaded_file['url']
				);									
				
				// insert the attachment post type and get the ID
				$attachment_id = wp_insert_post( $attachment );
		
				// generate the attachment metadata
				$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
				 
				// update the attachment metadata
				$rr = wp_update_attachment_metadata( $attachment_id,  $attach_data );
				
				if(isset($attach_data['sizes']['thumbnail']['file'])){
					$thumbnail = $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
				}else{
					$thumbnail = $uploaded_file['url'];
				}	
					
			 	 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($userdata->ID, "userphoto", array('img' =>$thumbnail, 'path' => $uploaded_file['file'], "aid" => $attachment_id ) );				
				
				}
			}
			
			$GLOBALS['error_message'] = __("Profile Data Updated","premiumpress");
	
	} break;






		
	 
	
} // end switch	
	

}
}










function _ajax_calls(){ global $wpdb, $post, $userdata, $CORE;


if(isset($_POST['ppt_ajax'])){

	switch($_POST['ppt_ajax']){
 
				
		/***
		
		desc: Category selection tool for listing page
		updated: 23rd July 2014
		
		***/
		case "cats": {
		
		$json = array();		
		if(!is_array($_POST['category']) || ( is_array($_POST['category']) && empty($_POST['category']) )){	
		$json[] = '{"id" : "hide"}'; 
		}else{
		
		// CATEGORY PRICE
		$current_catprices = get_option('ppt_catprices'); $price = "";
		
		foreach($_POST['category'] as $cat){
			// ARGS
			$args = array(
			'taxonomy'                 => THEME_TAXONOMY,
			'child_of'                 => $cat,
			'hide_empty'               => 0,
			'hierarchical'             => false,
			'exclude'                  => 0);
			// QUERY CATS
			$cats  = get_categories( $args ); 
			 
			// CHECK FOR VALID DATA
			if(is_array($cats) && !empty($cats)){		
				// SELECTED VALUES
				$selcats = explode(",",$_POST['selected']);
				// LOOP
				foreach($cats as $data){				
					//SKIP IF NOT SAME PARENT
					if($cat != $data->parent){ continue; }
					// SELECED
					if(in_array($data->term_id,$selcats)){ $sel = "selected=selected"; }else{ $sel = ""; }
					// SHOW PRICE
					if(isset($current_catprices[$data->term_id]) 
					&& ( isset($current_catprices[$data->term_id]) && is_numeric($current_catprices[$data->term_id]) && $current_catprices[$data->term_id] > 0 ) ){ 
						$price = " (".hook_price($current_catprices[$data->term_id]).')'; 
					}
					// BUILD JASON STRING
					$json[] = '{"id" : "'.$data->term_id.'", "text" : "'.$data->name.$price.'", "sel" : "'.$sel.'"}'; 
				}// end foreach	
			}else{		
				$json[] = '{"id" : "hide"}'; 		
			}
		}// end foreach	
		}	
		// OUTPUT	
		echo '[' . implode(',', $json) . ']'; 
		die();				  
      
		} break;
	
	
	
	
	} // end switch

}// end if


if(isset($_GET['core_aj']) && $_GET['core_aj'] == 1){

	
	switch($_GET['action']){
	 
									
				// CHANGE THE STATE VALUE FOR OUNTRY/STATE/CITY	
				case "ChangeState": {				
				
				$selected = $_GET['sel']; $in_array = array();				
							
				if(strpos($_GET['div'],"core_state") !== false){
						$s1 = 'map-state'; $s2 = 'map-country';										
				}else{
						$s1 = 'map-city'; $s2 = 'map-state';	
				}				
				
				$SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a				
				INNER JOIN ".$wpdb->postmeta." AS t ON ( t.meta_key = '".$s2."' AND t.meta_value= ('".strip_tags($_GET['val'])."') AND t.post_id = a.post_id )				
				WHERE a.meta_key = '".$s1."'";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				if(count($results) > 0 && !empty($results) ){
				
					echo "<option value=''></option>";
					
					foreach ($results as $val){			
						
						$state = $val->meta_value;						
						if(!in_array($state,$in_array)){						
							
							// ADD TO ARRAY
							$in_array[] = $state;
							$statesArray[] .= $state;
						}// if in array					
					} // end while	
					
					// NOW RE-ORDER AND DISPLAY
					asort($statesArray);
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							if($selected != "" &&  $state == $selected){
							echo "<option selected=selected>". $state."</option>";
							}else{
							echo "<option>". $state."</option>";
							} // end if	
					} 
					
					
				}else{ // end if
				
				// LOAD IN LANGUAGE
					
				
				echo "<option value=''>".__("Any","premiumpress")."</option>";
				}							
				} break;
				
				case "ChangeSearchValues": { 
					
					$THIS_SLUG = "";
					
				 	
					// GET ALL PARENT TERMS AND FIND ONE THAT MATCHES THE SLUG
					
					 $bits = explode("__", $_GET['key']);
					 
					 $isMakeSearch = false;
					 if(strpos($_GET['val'],"make-") !== false){
						 $isMakeSearch = true;
						 $_GET['val'] = str_replace("make-","",$_GET['val']);
					 }
					  
					  
					 if(!isset($bits[0])){ return; }
					 
					 // REGISTER TO PREVENT ERROR
					 register_taxonomy( $bits[0], 'listing_type', array() );
					 if(isset($bits[1])){
					 register_taxonomy( $bits[1], 'listing_type', array() );
					 }
					 
					 // GET LIST OF ALL PARENTS FROM SUB MENU
					 $parent_terms = get_terms($bits[0] ,array(  'orderby'    => 'count', 	'hide_empty' => 0, 'parent' => 0 ));	
					  							 				 			
					 if ( !empty( $parent_terms ) && !is_wp_error( $parent_terms ) ){
					 
					  
					 	// VALIDATION FOR VALUE
					 	if($_GET['val'] == ""){ die("<select id='novalueset'><option value=''>".__("Any","premiumpress")."</option></select>"); }	 
						 
						 // PASSED IN NUMERICAL VALUE INSTEAD OF SLUG
						if(is_numeric($_GET['val']) && isset($bits[1])){
						
							$found_term = get_term_by('id', $_GET['val'], $bits[1]);	
							   				 
							if(isset($found_term->slug)){
								$_GET['val'] = $found_term->slug;						 
							}					 
						}
						 	 
						// LOOP PARENT TERMS
						foreach ( $parent_terms as $term ) {
						  
						 	// CHECK FOR MATCH
							if (strpos($term->slug, $_GET['val']) !== false && $THIS_SLUG == "") {								 
								 
								$THIS_SLUG = $term->slug;
								 
								if (strpos($_GET['val'], "-") === false && strpos($term->slug, "-") !== false){
								
								}else{
								
								}
							} 							
						}
						
						//echo $THIS_SLUG."<--";
					 	 	
						if($THIS_SLUG != ""){						
						
							// GET THE PARENT ID
							$df_term = get_term_by('slug', $THIS_SLUG, $bits[0]);
							  
							// CHECK IF TERM EXISTS
							if(isset($df_term->term_id)){
						
								$terms = get_terms($bits[0], array('hide_empty' => false ) ); //, 'child_of' => $df_term->term_id
								
								$selec = (isset( $_GET['pr'] )) ? $_GET['pr'] : '';								 
								 
								$count = count($terms);
						 
							if ( $count > 0 ){
							
							 	echo "<select name='".$_GET['cl']."' class='form-control'>";
							 
							 	echo "<option value=''>".__("Any","premiumpress")."</option>";
							 
								 foreach ( $terms as $term ) {
								 
									if($term->parent != $df_term->term_id){ continue; } 
									
									// SELECTED
									if(is_numeric($_GET['pr']) && $_GET['pr'] == $term->term_id ){ $a = "selected=selected";  }else{ $a = ""; }											
									
									if($isMakeSearch){
										echo "<option value='model-".$term->term_id."' ".$a.">" . $term->name . " (".$term->count.") </option>";	
									}else{
										echo "<option value='".$term->term_id."' ".$a.">" . $term->name . " (".$term->count.") </option>";	
									}
											   
																			
								 }						  
							
							 	echo "</select>";
							 
							 }
							 }else{
							 
							  echo "<select><option value=''>".__("Any","premiumpress")."</option></select>";
							 }
						 
						 }else{
						 
						 	 echo "<select><option value=''>".__("Any","premiumpress")."</option></select>";
						 }
						
						 
					 }else{
					 	echo "<select><option value=''>".__("Any","premiumpress")."</option></select>";
					 }				  
				
				
				} break;
			}
		
			die();	
		}
		//////////////////////////////////////////////////////////////////////////////////////	

}














	
} // end class

?>