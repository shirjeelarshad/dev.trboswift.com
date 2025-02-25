<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


function _ppt_elementor_defaultvalue($cat, $element_id) { global $CORE;
		
		
 	
		$data = $CORE->LAYOUT("get_blocks_data", array());
		
		//print_r($data);
		
		
		if($cat == "hero"){
		return "yes";
		
		}else{
		
		return "no";
		}
		 
 

    	return $items;
}

function _ppt_elementor_menus() {

 	
		$items = ['' => esc_html__( 'Default', 'premiumpress' ) ];
		$items = ['none' => esc_html__( 'No Menu', 'premiumpress' ) ];
		
        $menus = wp_get_nav_menus();	 
       
        foreach ( $menus as $menu ) {
            $items[ $menu->slug ] = $menu->name;
        }
 

    return $items;
}



class PremiumPress_Elementor_Importer {

 
	function process_export_import_content( $content, $method ) {
	
		if(!defined('ELEMENTOR_VERSION')){		
		die("<h1>Elementor is no installed.</h1><p>Please install Elementor page builder pluign and then try again.</p>");
		}
		
		$d = \Elementor\plugin::$instance->db->iterate_data(
		
			$content, function( $element_data ) use ( $method ) {
			 	 
				$element = \Elementor\plugin::$instance->elements_manager->create_element_instance( $element_data );				 
				 	
				if ( ! $element ) {					
					return null;
				}
				
				if(!function_exists('get_file_description')){
				
					$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
					if(!defined('ABSPATH')){
						require $dir_path . "/wp-load.php";
					}
					
					require $dir_path . "/wp-admin/includes/file.php";
					require $dir_path . "/wp-admin/includes/media.php";	
				}
				
				if(!function_exists('wp_generate_attachment_metadata') ){
					require $dir_path . "/wp-admin/includes/image.php";
				}
				 
				return $this->process_element_export_import_content( $element, $method );
			}
		);
	 	 
		return $d;
	}
	 
	function process_element_export_import_content( $element, $method ) {
	
	 
		$element_data = $element->get_data();		
		 
		if ( method_exists( $element, $method ) ) {
			 
			$element_data = $element->{$method}( $element_data );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = \Elementor\plugin::$instance->controls_manager->get_control( $control['type'] );
		  	
			// If the control isn't exist, like a plugin that creates the control but deactivated.
			if ( ! $control_class ) {
				return $element_data;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_data['settings'][ $control['name'] ] = $control_class->{$method}( $element->get_settings( $control['name'] ), $control );
			}

			// On Export, check if the control has an argument 'export' => false.
			if ( 'on_export' === $method && isset( $control['export'] ) && false === $control['export'] ) {
				unset( $element_data['settings'][ $control['name'] ] );
			}
		}

		return $element_data;
	}
	
	public function removeMy(&$element, $index){
	
		if(!defined('CHILD_THEME_PATH_IMG')){
		define('CHILD_THEME_PATH_IMG','');
		}
		
		  	    
		 $element = 
		 str_replace('[link-add]', _ppt(array('links','add')),
		 str_replace('[link-login]', wp_login_url(), 
		 str_replace('[link-register]', wp_registration_url(), 
		 str_replace('[link-myaccount]', _ppt(array('links','myaccount')), 
		 str_replace('[link-aboutus]', _ppt(array('links','about')), 
		 str_replace('[link-contact]', _ppt(array('links','contact')),
		 str_replace('[link-search]', home_url()."/?s=",		 
		 str_replace('[path-plugins]', home_url()."/wp-content/plugins/",		 
		 str_replace('[path-server-images]', DEMO_IMG_PATH,		 
		 str_replace('[path-images]', addslashes(CHILD_THEME_PATH_IMG), $element ) ) ) ) ) ) ) ) ) );		 
	}

    public function import_elementor_file( $file, $title) {
	
	 	if($file == ""){
		die("no file set");
		} 
		
		if(strlen($file) > 100){
			 
			$content = json_decode( $file, true ); 
 			
		}else{
			$data = json_decode( file_get_contents( $file ), true );
			if ( empty( $data ) ) {
			
				return new \WP_Error( 'file_error', 'Invalid File. ('.$file.') Data cannot be read.' );
			}
		 	
			$content = $data['content'];
		}		
		
		// REPLACE {IMAGE} WITH CHILD THEME PATH
		array_walk_recursive($content, array($this, "removeMy" ) );
			
		 
		if ( ! is_array( $content ) ) {
		
			$g = explode("wp-content", $file);		 
			
			return new \WP_Error( 'file_error', '<br><br><h3>Manual Upload Required.</h3><p>Unfortunately your hosting provider could not read the template file, please download the file using the link below and manually upload it using the Elementor import tool.</p> <a href="'.home_url().'/wp-content/'.$g[1].'" target="_blank" class="button">Download File Now</a> <br><br> <p>Import page found <a href="'.home_url().'/wp-admin/edit.php?post_type=elementor_library&tabs_group=library" target="_blank"><u>here</u></a></p>' );
		}
	 	  
		//$content = $this->process_export_import_content( $content, 'on_import' );
		 
		 
        // Import the data
        return $this->import_data( $content, $title );

    }
	
	public function export_elementor_file( array $args ) {	 

		$source = \Elementor\plugin::instance()->templates_manager->get_source( $args['source'] );

		if ( ! $source ) {
			return new \WP_Error( 'template_error', 'Template source not found' );
		}
		
		$file_data = $this->prepare_template_export( $source, $args['template_id']  ); 
 		
		return $file_data;
		 
	}
	
	function cleanup($item, $key){	
	
		
			
	}

	
	private function prepare_template_export( $source, $template_id ) {
	
		$template_data = $source->get_data( [
			'template_id' => $template_id,
		] );

		if ( empty( $template_data['content'] ) ) {
			return new \WP_Error( 'empty_template', 'The template is empty' );
		}		
		
		$this->process_export_import_content( $template_data['content'], 'on_export' );				
	 	 
		// CLEANUP ARRAY
		$GLOBALS['extractimages'] = array();
				
		
		array_walk_recursive(
			$template_data['content'],
			function (&$item) {
			  
				// CLEAN UP
				$item = str_replace(home_url()."?s=","[link-search]", $item);
				$item = str_replace(home_url()."/?s=","[link-search]", $item);
				
				$item = str_replace(home_url()."/add-listing/","[link-add]", $item);
				$item = str_replace(home_url()."/contact/","[link-contact]", $item);
				
				$item = str_replace(home_url()."/wp-content/plugins/","[path-plugins]", $item);
				 
				
				// GET IMAGE
				if(strpos($item, "uploads") !== false){				
					$GLOBALS['extractimages'][] = $item;			 		
					$item = "[path-images]".wp_basename($item);			
				}
				
				
			}
		);
		
		
		//$template_data['content'] = $this->process_element_export_import_content( $content , 'on_export' );
		
		/*
		if ( get_post_meta( $template_id, '_elementor_page_settings', true ) ) {
		
			$page = \Elementor\plugin::instance()->settings->get_settings_managers( 'page' )->get_model( $template_id );

			$page_settings_data = $this->process_export_import_content( $page, 'on_export' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$template_data['page_settings'] = $page_settings_data['settings'];
			}
		}
		*/
		//die(print_r($template_data));
	    

		$export_data = [
			'version' => "0.4",
			'title' => get_the_title( $template_id ),
			'type' => "page",
		];

		$export_data += $template_data;

		return [
			'name' => 'elementor-' . $template_id . '-' . gmdate( 'Y-m-d' ) . '.json',
			'content' => wp_json_encode( $export_data ),
			'images' => $GLOBALS['extractimages'],
		];
	}
	
	
	
    private function import_data( $data, $title ) {	 
		 		 
		$local = \Elementor\plugin::instance()->templates_manager->save_template( [
			'post_id' => 1,
			'source' => 'local',		
			'content' => json_encode($data , true),
			'type' => 'page',
			//'page_settings' => json_encode($data1->page_settings),
		] );
		
		if( !is_wp_error( $local ) ) {	
		
			// NOW UPDATE NAME OF TEMPLATE ETC USINF $local['template_id']		
			 $my_post = array(
				  'ID'           => $local['template_id'],
				  'post_title'   => $title,
			  );
			
			// Update the post into the database
			 wp_update_post( $my_post );
			 
			 
			 //$page_settings_data = \Elementor\plugin::process_element_export_import_content( array('id' => $local['template_id'], 'settings' => 'default' ), 'on_import' );
			 //die(print_r($page_settings_data);
			  
			 // SET PAGE TEMPLATE CANVUS		 
			 update_post_meta($local['template_id'], '_wp_page_template', 'elementor_canvas');
					
			 return $local['template_id'];
		
		}else{
		
			die("Elementor Import Error: ".$local->get_error_message());
		
		
		}
	 
		 

	 
    }
	
	

	
	

}

?>