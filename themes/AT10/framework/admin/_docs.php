<?php

// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }


if( current_user_can('administrator') && isset($_POST['toolbox']) ){

	global $wpdb, $CORE;
	
	
	switch($_POST['toolbox']){
	
	
		case "cp_verified": {
		
			global $post;
			$args = array('posts_per_page' => 1000,  'post_type' => "listing_type", "post_status" => "publish", "order" => "desc");
			$query1 = new WP_Query( $args );	
 
			if ( $query1->have_posts() ) {
				
				while ( $query1->have_posts() ) { $query1->the_post();
				
						
					$postid = $post->ID;
					
					// SET VERIFIED 1
					update_post_meta($postid,'verified',1);
					
					
					
				}
			}
		
		
		} break;
	
	
		case "v9_membership": { 
		
		
		$args = array('role'    => 'subscriber' );
		$query1 = new WP_User_Query($args);		
		$editors = $query1->get_results();		 
 
		if ( ! empty( $editors ) ) { 			 
			
			foreach ( $editors as $editor ) {
			 
				//update_user_meta( $editor->data->ID, 'ppt_verified', "1");
				
				 
				
				$sd = $CORE->USER("get_this_membership", $_POST['membership']);	
			 
				if(isset($sd['duration'])){
							 
						$au = array(
							"date_start" => date("Y-m-d H:i:s"), 
							"date_expires" => date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " + ".$sd['duration']." days")),
						);
					
				}
					
					// DATE EXPIRES
				$expires = "";
				if(isset($au['date_expires'])){
					$expires = $au['date_expires'];
				}
				
				if($expires != ""){
				update_user_meta( $editor->data->ID ,'ppt_subscription', 
						array(
							"key" 			=> $_POST['membership'] , 
							"date_start" 	=> $au['date_start'], 
							"date_expires" 	=> $expires,					 
						)
				);
				}
			
			
				
			
			
			}
		}
			
		// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
						"type" 		=> "success",
						"title" 	=> "Settings Updated",
						"message"	=> "featured listings updated.",
			);
				
			
		
		} break;
	
	
		case "v9_verified": {
		
		
		$args = array('role'    => 'subscriber' );
		$query1 = new WP_User_Query($args);		
		$editors = $query1->get_results();		 
 
		if ( ! empty( $editors ) ) { 			 
			
			foreach ( $editors as $editor ) {
			 
				update_user_meta( $editor->data->ID, 'ppt_verified', "1");	
			
			
			}
		}
			
		// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
						"type" 		=> "success",
						"title" 	=> "Settings Updated",
						"message"	=> "featured listings updated.",
			);
				
			
		
		} break;
		
		case "v9_featured": {
		
			$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='1' WHERE meta_key='featured'");	
			
			// LEAVE MESSAGE
			$GLOBALS['ppt_error'] = array(
						"type" 		=> "success",
						"title" 	=> "Settings Updated",
						"message"	=> "featured listings updated.",
			);
		
		} break;
		
		case "v9_expired": {
			
			global $post;
			$args = array('posts_per_page' => 100,  'post_type' => "listing_type", "post_status" => "expired");
			$query1 = new WP_Query( $args );	
 
			if ( $query1->have_posts() ) {
				
				while ( $query1->have_posts() ) { $query1->the_post();
				
						
					$postid = $post->ID;
					
					if(THEME_KEY == "at"){	
					// RESET BID STRINGS
					update_post_meta($postid,	'bidstring', '');				
					update_post_meta($postid,	'user_maxbid_data', '');								
					update_post_meta($postid,	'relisted', current_time( 'mysql' ) );	
					update_post_meta($postid,	'status', '0');	
					update_post_meta($postid, 	'current_bid_data', '');
					}		
					
					// UPDATE POST STATUS
					$my_post = array();
					$my_post['ID'] 					= $postid;
					$my_post['post_status']			= "publish";
					wp_update_post( $my_post );	
					
					
					$pak = get_post_meta($postid,'packageID',true);			
					if(strlen($pak) > 0){			
						
						$tnow = date("Y-m-d H:i:s"); 				
						$newdate = date("Y-m-d H:i:s", strtotime( $tnow . " +"._ppt('pak'.$pak.'_duration')." days"));				 
						update_post_meta($postid, 'listing_expiry_date', $newdate );
					
					}else{
					
						$newdate = date("Y-m-d H:i:s", strtotime( $tnow . " +30 days"));				 
						update_post_meta($postid, 'listing_expiry_date', $newdate );
					
					
					}
				
				
				
				}
			
			}
			
		
		} break;
	
	}


}

if( current_user_can('administrator') ){

global $wpdb;

	if(isset($_GET['deletedb']) && strlen($_GET['deletedb']) > 1){
	
	
		$SQL = "DELETE FROM ".$wpdb->prefix."posts WHERE ".$wpdb->prefix."posts.post_type='".$_GET['deletedb']."'";
		$result = $wpdb->query($SQL);
		 
		
		die("Database Cleared");
	
	
	}

}


// CREATE CHILD THEME
if( current_user_can('administrator') && isset($_POST['dsample'])  ){ //!defined('WLT_DEMOMODE') && 

		 
		 // WORDPRESS UPLOADS
		 $uploads = wp_upload_dir(); $saveimages = array();
		 
		 // NAME 
		 $cname = "Child Themes";
		 if(strlen( _ppt(array('childtheme','name')) ) > 1){
		 $cname = _ppt(array('childtheme','name'));
		 } 
		 
		  
		
		// SCREENSHOT FILE		 
		if(is_numeric(_ppt(array('childtheme','thumb_url_aid'))) && strtolower(substr(_ppt(array('childtheme','thumb_url')), -3)) == "png" ){
		 				
			$file = get_attached_file(_ppt(array('childtheme','thumb_url_aid')), true);	
			
			$newname = "screenshot.png";
			
			if (file_exists($uploads['path']."/".$newname)) {
				
			}else{			
			
				if (!copy($file, $uploads['path']."/".$newname)) {
					die("Could not save your screenshot image");
				}
			
			}
		
		} 
		 
		
		// PREVIEW FILE		 
		$preview_image = "";
		if(is_numeric(_ppt(array('childtheme','thumb1_url_aid')))  ){
		 				
			$file = get_attached_file(_ppt(array('childtheme','thumb1_url_aid')), true);	
			
			$preview_image = wp_basename($file);
			
			$preview_image_file =  $file; 
		
		} 
		  
		 
 		  	
		//1. INCLUDE ZIP FEATURE
		include(TEMPLATEPATH."/framework/new_class/class_pclzip.php");
		$uploads = wp_upload_dir();
		
		$template_name = "childtheme_".str_replace(" ","_",strip_tags($cname));		  
		  
		// 2. REMOVE OLD FILES
		if (file_exists($uploads['path']."/".$template_name.".zip")) {
			@unlink($uploads['path']."/".$template_name.".zip"); 
		}
		   
		// 3. CREATE NEW STYLE.CSS
		$cssContent = "/*
		Theme Name: ".strip_tags($cname)."
		Theme URI: http://www.premiumpress.com
		Description: PremiumPress Child Theme created on ".date('l jS \of F Y h:i:s A')."
		Author: ".get_option('admin_email')."
		Author URI: ".get_home_url()."
		Template: ".strtoupper(THEME_KEY)."10
		Version: 1.0
		*/";
		
		 	
		//2. ADD-ON CUSTOM STYLES		
		$cssContent .= stripslashes(get_option('custom_head')); 
			
		//3. SAVE THE NEW STYLE FILE		   
		$handle = fopen($uploads['path']."/style.css", "w");
		if (fwrite($handle, $cssContent) === FALSE) {
				echo "Cannot write to styles";
				die();
		} 		 
		fclose($handle);
		
		
		
		// 4. CHECK FOR LOGO
		$logofile = ""; $logo_text = _ppt(array('design','textlogo')); $logo_url = "";
		if(is_numeric(_ppt(array('design','logo_url_aid')))){
		
			$logo_fullpath = get_attached_file(_ppt(array('design','logo_url_aid')), true);		
		 
	
			$hh = wp_get_attachment_metadata(_ppt(array('design','logo_url_aid')));
			if(isset($hh['file']) && $hh['file'] != ""){			 
			$logofile = $logo_fullpath;
			}
			
			$logo_url = wp_basename($logo_fullpath);
			
		}		
		
		
		// HOMEPAGE ELEMENTOR
		$elementor_homepage_name = "";
		if(strlen(_ppt(array('pageassign','homepage'))) > 3 && substr(_ppt(array('pageassign','homepage')) ,0,4) != "page"){ 
	 	 
			 $args = array(
				 "action" 			=> "elementor_library_direct_actions",
				 "library_action" 	=> "export_template",
				 "source" 			=> "local",
				 "template_id" 		=> str_replace("elementor-","", _ppt(array('pageassign','homepage')) ),
				 		 
			 );
			  
			$elementor_importer = new PremiumPress_Elementor_Importer();
			$filedata = $elementor_importer->export_elementor_file( $args );
			
			
			// IF HAS ERRORS					 
				if ( is_wp_error($filedata) ) {
					echo '<h4>' . $filedata->get_error_message() . '</h4>';						 
					die();	
				}
			
			$elementor_homepage_path = $uploads['path']."/".$filedata['name'];
			$elementor_homepage_name = $filedata['name'];
			
			// SAVE CONTENT TO FUNCTIONS FILE
			$handle = fopen($elementor_homepage_path, "w");
			if (fwrite($handle, $filedata['content']) === FALSE) {
					echo "Cannot write to Elementor Homepage file";
					die();
			} 
			fclose($handle); 
			
			// NOW LOOP ALL IMAGES
			if( is_array($filedata['images']) && !empty($filedata['images']) ) {
				
				foreach($filedata['images'] as $img){
				
					if(file_exists( $uploads['path']."/". wp_basename($img) )){
						
						$saveimages[] = $uploads['path']."/". wp_basename($img); 
					}
				}
			
			}
		}
	 	
		
	   
		// 4. BUILD THE FUNCTIONS FILE	 
		$funContent = file_get_contents(TEMPLATEPATH."/framework/sampletheme_func.txt");	
		
		$this_theme_key = $template_name;
		/*
		(theme_key)
		(theme_name)
		(theme_logo)
		(preview_image)
		*/	
		$funContent = str_replace("(core_key)", 	strtolower(THEME_KEY), $funContent);
		
		$funContent = str_replace("(theme_key)", 	$this_theme_key, $funContent);
		$funContent = str_replace("(theme_name)", 	strip_tags($cname), $funContent);
		
		$funContent = str_replace("(theme_color1)", _ppt(array('design','color_primary')), $funContent);
		$funContent = str_replace("(theme_color2)", _ppt(array('design','color_secondary')), $funContent);


		$funContent = str_replace("(logo_text)", $logo_text, $funContent);
		$funContent = str_replace("(logo_url)", $logo_url, $funContent);		
			 	
		$funContent = str_replace("(preview_image)", 	$preview_image, $funContent); 	
	    
		$funContent = str_replace("(theme_header)", _ppt(array('design','header_style')), $funContent);
 		$funContent = str_replace("(theme_footer)", _ppt(array('design','footer_style')), $funContent);
 		
		
		// ELEMENTOR
		$funContent = str_replace("(elementor_homepage_name)", $elementor_homepage_name, $funContent);
		
		
		/* DESIGN EXTRA */
		$extra = "";
		/*
		if( _ppt(array('design','header_style')) ){ 
			ob_start(); 
			foreach($core_admin_values['design'] as $k=> $v){ 
			?>$core['design']['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";<?php
			}
			$extra = ob_get_clean();
		} 		
		*/
		$funContent = str_replace("(design_extra)", $extra, $funContent);
		
		// SAVE CONTENT TO FUNCTIONS FILE
		$handle = fopen($uploads['path']."/functions.php", "w");
		if (fwrite($handle, $funContent) === FALSE) {
				echo "Cannot write to functions file";
				die();
		} 
		fclose($handle);	
			  
			
		// ADD IN ALL FILES
		$addfiles = array();
		$addfiles[] = $uploads['path']."/style.css";
		$addfiles[] = $uploads['path']."/functions.php";
		
		// ELEMENTOR FILES
		if(strlen($elementor_homepage_name) > 1){
			$addfiles[] = $elementor_homepage_path;
		}
		
		// IMAGE FILES
		if(isset($logofile)){
			$addfiles[] = $logofile;
		}
		
		// SCREENSHOT
		if(is_numeric(_ppt(array('childtheme','thumb_url_aid'))) && strtolower(substr(_ppt(array('childtheme','thumb_url')), -3)) == "png" ){		
			$addfiles[] = $uploads['path']."/screenshot.png";
		}
		
		// PREVIEW IMAGE
		if(strlen($preview_image) > 1){		
			$addfiles[] = $preview_image_file;			
		}
 		 
		// CLEAN ARRAY
		$addfiles1 = "";
		foreach($addfiles as $f){
			if(strlen($f) > 5){
				$addfiles1 .= $f.",";
			}
		}
		
		// CLEAN STRING
		$addfiles1 = substr($addfiles1,0,-1);					  
 		 
		
		// 4. ZIP EVERYTHING TOGETHER
		$zipfile = new PclZip($uploads['path']."/".$template_name.".zip");		
		$zipfile->add($addfiles1, PCLZIP_OPT_REMOVE_ALL_PATH,  PCLZIP_OPT_ADD_PATH, $template_name);
		
		
		// ADD IMAGES AFTER		  
		if(!empty($saveimages)){		
			foreach($saveimages as $img){				 
				$zipfile->add($img, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name."/images/");
			}
		}
		
		// CREATE LANGUAGES
		$zipfile->add(TEMPLATEPATH."/framework/index.html", PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name."/languages/");
		
		// CREATE JS
		$zipfile->add(TEMPLATEPATH."/framework/index.html", PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name."/js/");
 		  
	
		$file = $uploads['path']."/".$template_name.".zip";
		$file_download = $uploads['url']."/".$template_name.".zip";
		
		
		if(headers_sent()){
		?>
        <h1>Download Ready</h1>
        <p>Use the link below to download your child theme.</p>
        <p><a href="<?php echo $file_download; ?>"><?php echo $file_download; ?></a>
        <?php 
		die();
		}elseif(file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
		}else{
		die("Theme file unavailable.");
		} 	 
} 







_ppt_template('framework/admin/header' ); 


?> 
<div class="tab-content">

	    <div class="tab-pane active addjumplink"         
        data-title="<?php echo __("Introduction","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is an overview of the options.","premiumpress"); ?>"
     
        data-icon="fa-user" 
        id="intro" 
        role="tabpanel" aria-labelledby="intro-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-intro' ); ?>      
        </div><!-- end design home tab -->


	    <div class="tab-pane addjumplink" 
        
         data-title="<?php echo __("Theme Flow","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is a flow diagram for your website.","premiumpress"); ?>"
     
        
        data-icon="fa-fog" 
        id="flow" 
        role="tabpanel" aria-labelledby="flow-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-flow' ); ?>      
        </div><!-- end design home tab -->



        <div class="tab-pane addjumplink" 
         
         data-title="<?php echo __("Typography","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is the typography used within this theme.","premiumpress"); ?>"
     
        
        
        data-icon="fa-font" 
        id="typography" 
        role="tabpanel" aria-labelledby="typography-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-typography' ); ?>      
        </div><!-- end design home tab -->
        
        
        
       <div class="tab-pane addjumplink" 
          
        data-title="<?php echo __("Shortcodes","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can preview some of the shortcodes available.","premiumpress"); ?>"
     
        
        data-icon="fa-brackets" 
        id="shortcodes" 
        role="tabpanel" aria-labelledby="shortcodes-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-shortcodes' ); ?>      
        </div><!-- end design home tab -->
        
        
       <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("Database","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is an overview of the database setup within this theme.","premiumpress"); ?>"
    
        
        data-icon="fa-database" 
        id="database" 
        role="tabpanel" aria-labelledby="database-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-database' ); ?>      
        </div><!-- end design home tab -->
        
       
         
       <div class="tab-pane addjumplink" 
       
         data-title="<?php echo __("System Check","premiumpress"); ?>" 
        data-desc="<?php echo __("Here is a basic system check to ensure your running at optimal performance.","premiumpress"); ?>"

        
        data-icon="fa-shield-check" 
        id="check" 
        role="tabpanel" aria-labelledby="check-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-systemcheck' ); ?>      
        </div><!-- end design home tab -->
        
                       
       <div class="tab-pane addjumplink" 
        
         data-title="<?php echo __("Order System","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can learn more about the order system.","premiumpress"); ?>"

        
        data-icon="fa-coin" 
        id="order" 
        role="tabpanel" aria-labelledby="order-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-orders' ); ?>      
        </div><!-- end design home tab -->
        
     

                   
       <div class="tab-pane addjumplink" 
       
         data-title="<?php echo __("Awards System","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can learn more about the reward system.","premiumpress"); ?>"
       
        
        data-icon="fa-award" 
        id="awards" 
        role="tabpanel" aria-labelledby="awards-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-awards' ); ?>      
        </div><!-- end design home tab -->              
        
        
        
        
        <div class="tab-pane addjumplink" 
         
         data-title="<?php echo __("Debug","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can preview the entire theme code.","premiumpress"); ?>"
     
        
        data-icon="fa-debug" 
        id="debug" 
        role="tabpanel" aria-labelledby="debug-tab">
        <?php _ppt_template('framework/admin/parts/docs-basics-debug' ); ?>      
        </div><!-- end design home tab -->
     
          
        <div class="tab-pane addjumplink" 
         
         data-title="<?php echo __("Child Theme","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can export a design to a child theme.","premiumpress"); ?>"
     
        
        data-icon="fa-pencil-paintbrush" 
        id="child" 
        role="tabpanel" aria-labelledby="child-tab">
        <?php _ppt_template('framework/admin/parts/docs-childtheme' ); ?>      
        </div><!-- end design home tab -->  
   
   
   
   
        <div class="tab-pane addjumplink" 
         
         data-title="<?php echo __("Toolbox","premiumpress"); ?>" 
        data-desc="<?php echo __("A collection of useful functions for upgrading and updating.","premiumpress"); ?>"
     
        
        data-icon="fa-tools" 
        id="toolbox" 
        role="tabpanel" aria-labelledby="toolbox-tab">
        <?php _ppt_template('framework/admin/parts/docs-toolbox' ); ?>      
        </div><!-- end design home tab -->  
   
   
   
   

</div>

<?php

_ppt_template('framework/admin/footer' ); 

?>