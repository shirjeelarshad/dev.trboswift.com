<?php

	function ppt_orderby_activated($network_wide){

            global $wpdb;
                 
            // check if it is a network activation
            if ( $network_wide ) 
                {
                    $current_blog = $wpdb->blogid;
                    
                    // Get all blog ids
                    $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                    foreach ($blogids as $blog_id) 
                        {
                            switch_to_blog($blog_id);
                            ppt_orderby_activated_actions();
                        }
                    
                    switch_to_blog($current_blog);
                    
                    return;
                }
                else
                ppt_orderby_activated_actions();
        }
        
    function ppt_orderby_activated_actions(){
            global $wpdb;
                 
            //make sure the vars are set as default
            $options = get_option('tto_options');
            if (!isset($options['autosort']))
                $options['autosort'] = '1';
                
            if (!isset($options['adminsort']))
                $options['adminsort'] = '1';
                
            if (!isset($options['capability']))
                $options['capability'] = 'install_plugins';
                
            update_option('tto_options', $options);
            
            //try to create the term_order column in case is not created
            $query = "SHOW COLUMNS FROM `". $wpdb->terms ."` 
                        LIKE 'term_order'";
            $result = $wpdb->get_row($query);
            if(!$result) 
                {
                    $query = "ALTER TABLE `". $wpdb->terms ."` 
                                ADD `term_order` INT NULL DEFAULT '0'";
                    $result = $wpdb->get_results($query);   
                }            
        }
         
    
        
    //Wp E-commerce fix, remove the term filter in case we use autosort
    add_filter('plugins_loaded', 'atto1_plugins_loaded');
    function atto1_plugins_loaded()
        {
            
            //prepare rest data
            new ppt_orderby_rest();
            
            
            $options = get_option('tto_options');
            
            if (is_admin())
                {
                    if ($options['adminsort'] == "1")
                        remove_filter('get_terms','wpsc_get_terms_category_sort_filter');
                }
                else
                {
                    if ($options['autosort'] == 1)
                        remove_filter('get_terms','wpsc_get_terms_category_sort_filter');   
                }
        }
        
    add_filter('get_terms_args', 'ppt_to_get_terms_args', 99, 2);
    function ppt_to_get_terms_args($args, $taxonomies)
        {

            
            return ($args);
        }

    add_filter('get_terms_orderby', 'ppt_get_terms_orderby', 10, 2);
    function ppt_get_terms_orderby($orderby, $args)
        {
            //make sure the requested orderby follow the original args data
            if ($args['orderby'] == 'term_order')
                $orderby = 't.term_order';

            return $orderby;
        }
        
        
    add_filter('terms_clauses', 'ppt_to_terms_clauses', 99, 3);
    function ppt_to_terms_clauses($pieces, $taxonomies, $args){
		
		
			if(!isset($args['orderby'])){ $args['orderby'] = ""; }
		
		 
            //no need to order when count terms for this query
            if(isset($args['fields']) && strtolower($args['fields'])    ==  'count')
                return $pieces;    
            
            //check for sort ignore
            if(isset($args['ignore_custom_sort']) && $args['ignore_custom_sort']    === TRUE)
                return $pieces;
            
            $options = get_option('tto_options');
			
			// defaults
			if(!isset($options['adminsort'])){ $options['adminsort'] = 0; }
			if(!isset($options['autosort'])){ $options['autosort'] = 0; } 

            //if admin make sure use the admin setting
            if (is_admin() && !defined('DOING_AJAX')){
                    if($options['adminsort'] != "1" && $args['orderby'] != 'term_order')
                        return $pieces;
            }else{
                        if($options['autosort'] != '1' && $args['orderby'] != 'term_order')
                            return $pieces;
            }
            
            if (count($taxonomies) == 1)
                {
                    //check the current setting for current taxonomy
                    $taxonomy = $taxonomies[0];
                    $order_type = (isset($options['taxonomy_settings'][$taxonomy]['order_type'])) ? $options['taxonomy_settings'][$taxonomy]['order_type'] : 'manual'; 
                    
                    //if manual
                    if ($order_type == 'manual')
                        {
                
                            $taxonomy_info = get_taxonomy($taxonomy);
                            
                            //check if is hierarchical
							 $pieces['orderby'] = 'ORDER BY t.term_order';
							 return $pieces;
					 
                            if ($taxonomy_info->hierarchical !== TRUE)
                                {
                                    $pieces['orderby'] = 'ORDER BY t.term_order';
                                }
                                else
                                {
                                    //customise the order
                                    global $wpdb;
                                    
                                    $query_pieces = array( 'fields', 'join', 'where', 'orderby', 'order', 'limits' );
                                    foreach ( $query_pieces as $piece )
                                        $$piece = isset( $pieces[$piece] ) ? $pieces[$piece] : '';

                                    $pieces['orderby'] = 'ORDER BY t.term_order';     
                                    
                                    $query = "SELECT ".$pieces['fields'] ." FROM $wpdb->terms AS t ".$pieces['join'] ." WHERE ".$pieces['where'] ." ".$pieces['orderby'] ." ".$pieces['order'] ." ".$pieces['limits'];
                                    $results = $wpdb->get_results($query);
                                    
                                    $children = ppt_get_term_hierarchy( $taxonomy );
                                    
                                    $parent = isset($args['parent']) && is_numeric($args['parent']) ? $args['parent'] : 0;
                                    $terms_order_raw = ppt_to_process_hierarhically($taxonomy, $results, $children, $parent);
                                    $terms_order_raw = rtrim($terms_order_raw, ",");
                                    
                                    if(!empty($terms_order_raw))                        
                                        $pieces['orderby'] = 'ORDER BY FIELD(t.term_id, '. $terms_order_raw .')';
                                        
                                }
                                         
                            //no need to continue; return original order
                            return $pieces;   
                        }
                        
                    //if auto
                    $auto_order_by = isset($options['taxonomy_settings'][$taxonomy]['auto']['order_by']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order_by'] : 'name';
                    $auto_order = isset($options['taxonomy_settings'][$taxonomy]['auto']['order']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order'] : 'desc';
                    
                    
                    $order_by = "";
                    switch ($auto_order_by)
                        {
                            case 'default':
                                                return $pieces;
                                                break;
                            
                            case 'id':
                                        $order_by = "t.term_id";
                                        break;
                            case 'name':
                                        $order_by = 't.name';
                                        break;
                            case 'slug':
                                        $order_by = 't.slug';
                                        break;
                            case 'count':
                                        $order_by = 'tt.count';
                                        break;
                                        
                            case 'random':
                                        $order_by = 'RAND()';
                                        break;
                        }
                    
                    $pieces['orderby']  = 'ORDER BY '. $order_by; 
                    $pieces['order']    =  strtoupper($auto_order); 
                    
                    return $pieces; 
                }
                else
                {
                    //if autosort, then force the term_order
                    if ($options['autosort'] == 1)
                        {
                            $pieces['orderby'] = 'ORDER BY t.term_order';
                    
                            return $pieces; 
                        }    
                }

        }
    
    
    function ppt_wp_get_object_terms($terms, $object_ids, $taxonomies, $args = array())
        {
		
		 
            if(!is_array($terms) || count($terms) < 1)
                return $terms;
                    
            global $wpdb;
           
            $options = get_option('tto_options');

			// defaults
			if(!isset($options['adminsort'])){ $options['adminsort'] = 0; }
			if(!isset($options['autosort'])){ $options['autosort'] = 0; } 
           
            if (is_admin() && !defined('DOING_AJAX'))
                {
                    if ($options['adminsort'] != "1" && (!isset($args['orderby']) || $args['orderby']   !=  'term_order'))
                        return $terms;    
                }
                else
                {
                    if ($options['autosort'] != "1" && (!isset($args['orderby']) || $args['orderby']   !=  'term_order'))
                        return $terms;                        
                }
                
            //check for ignore filter
            if(apply_filters('atto/ignore_get_object_terms', $terms, $object_ids, $taxonomies, $args) === TRUE)
                return $terms; 
            
            //check for order ignore 
            if(isset($args['ignore_term_order']) && $args['ignore_term_order']    === TRUE)
                return $terms;
                
            // return $terms;
                
            if(!is_array($object_ids))
                $object_ids =   explode(",", $object_ids);
            $object_ids = array_map('trim', $object_ids);
            
            if ( !is_array($taxonomies) )
                $taxonomies = explode(",", $taxonomies);
            $taxonomies = array_map('trim', $taxonomies);

            foreach ( $taxonomies as $key   =>  $taxonomy ) 
                {
                    $taxonomies[$key]   =   trim($taxonomy, "'");
                }
    
            //no need if multiple objects
            if(count($object_ids) > 1)
                return $terms;
                
            //check if there are terms and if they belong to current taxonomies list, oterwise return as there's nothign to sort
            foreach($terms  as $term)
                {
                    if(!isset($term->taxonomy))
                        return $terms;
                        
                    if(!in_array($term->taxonomy, $taxonomies))
                        return $terms;
                }
            
            $object_id  =   $object_ids[0];
                                
            $terms = array();
                
            if(!isset($args['order']))
                $args['order']    =   '';
                
            if(!isset($args['fields']))
                $args['fields']    =   'all';
            
            extract($args, EXTR_SKIP);
            
            $select_this = '';
            if ( 'all' == $fields )
                $select_this = 't.*, tt.*';
            else if ( 'ids' == $fields )
                $select_this = 't.term_id';
            else if ( 'names' == $fields )
                $select_this = 't.name';
            else if ( 'slugs' == $fields )
                $select_this = 't.slug';
            else if ( 'all_with_object_id' == $fields )
                $select_this = 't.*, tt.*, tr.object_id';
            
            foreach ( $taxonomies as $key   =>  $taxonomy ) 
                {
                    $order_type = (isset($options['taxonomy_settings'][$taxonomy]['order_type'])) ? $options['taxonomy_settings'][$taxonomy]['order_type'] : 'manual'; 
                    
                    //if manual
                    if ($order_type == 'manual')
                        {
                            $orderby    =   't.term_order';
                            
                            // tt_ids queries can only be none or tr.term_taxonomy_id
                            if ( 'tt_ids' == $fields )
                                $orderby = 'tr.term_taxonomy_id';

                            if ( !empty($orderby) )
                                $orderby = "ORDER BY $orderby";

                            $order = strtoupper( $order );
                            if ( '' !== $order && ! in_array( $order, array( 'ASC', 'DESC' ) ) )
                                $order = 'ASC';
                        }
                        else
                        {
                            if(isset($options['taxonomy_settings'][$taxonomy])  &&  isset($options['taxonomy_settings'][$taxonomy]['auto'])  &&  isset($options['taxonomy_settings'][$taxonomy]['auto']['order_by']))
                                $orderby    =   'ORDER BY t.' . $options['taxonomy_settings'][$taxonomy]['auto']['order_by'];
                                else
                                {
                                    if(isset($args['orderby']))
                                        $orderby    =   'ORDER BY t.' . $args['orderby'];
                                        else
                                        $orderby    =   'ORDER BY t.name';
                                }
                            
                            
                            if(isset($options['taxonomy_settings'][$taxonomy])  &&  isset($options['taxonomy_settings'][$taxonomy]['auto'])  &&  isset($options['taxonomy_settings'][$taxonomy]['auto']['order']))
                                $order    =   strtoupper($options['taxonomy_settings'][$taxonomy]['auto']['order']);
                                else
                                {
                                    if(isset($args['order']))
                                        $order    =   $args['order'];
                                        else
                                        $order    =   'ASC';
                                }
                            
                            //$order      =   strtoupper($options['taxonomy_settings'][$taxonomy]['auto']['order']);
                        }
                    
                      $orderby    =   'ORDER BY t.name';
					                     
                    $query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ('$taxonomy') AND tr.object_id IN ($object_id) $orderby $order";

                    if ( 'all' == $fields || 'all_with_object_id' == $fields ) 
                    {
                        $_terms = $wpdb->get_results($query);
                        foreach ( $_terms as $key => $term ) 
                            {
                                $_terms[$key] = sanitize_term( $term, $term->taxonomy, 'raw' );
                            }
                            
                        $object_id_index = array();
                        foreach ( $_terms as $key => $term ) 
                            {
                                $term = sanitize_term( $term, $taxonomy, 'raw' );
                                $_terms[ $key ] = $term;

                                if ( isset( $term->object_id ) ) 
                                    {
                                        $object_id_index[ $key ] = $term->object_id;
                                    }
                            }
                        
                        update_term_cache($_terms, $taxonomy);
                        $_terms = array_map( 'get_term', $_terms );

                        // Re-add the object_id data, which is lost when fetching terms from cache.
                        if ( 'all_with_object_id' === $fields ) 
                            {
                                foreach ( $_terms as $key => $_term ) 
                                    {
                                        if ( isset( $object_id_index[ $key ] ) ) 
                                            {
                                                $_term->object_id = $object_id_index[ $key ];
                                            }
                                    }
                            }
                        
                        $terms = array_merge($terms, $_terms);
                    } 
                    else if ( 'ids' == $fields || 'names' == $fields || 'slugs' == $fields ) 
                    {
                        $_terms = $wpdb->get_col( $query );
                        $_field = ( 'ids' == $fields ) ? 'term_id' : 'name';
                        foreach ( $_terms as $key => $term ) 
                            {
                                $_terms[$key] = $term;
                            }
                        $terms = array_merge($terms, $_terms);
                    } 
                    else if ( 'tt_ids' == $fields ) 
                    {
                        $terms = $wpdb->get_col("SELECT tr.term_taxonomy_id FROM $wpdb->term_relationships AS tr INNER JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id IN ($object_id) AND tt.taxonomy IN ('$taxonomy') $orderby $order");
                        foreach ( $terms as $key => $tt_id ) 
                            {
                                $terms[$key] = $tt_id;
                            }
                    }    
                }

                
            return $terms;
        }


    //wp_get_object_terms term_order support
    add_filter('wp_get_object_terms',   'ppt_wp_get_object_terms', 99,     4);
 
    add_filter('get_the_terms',         'ppt_wp_get_object_terms', 999,    3);


    function ppt_to_process_hierarhically($taxonomy, $terms, &$children, $parent = 0, $level = 0 )
        {

            $output = '';
            foreach ( $terms as $key => $term ) 
                {
                    if(!isset($term->parent))
                        {
                            $output .= $term->term_id . ",";
                            
                            unset( $terms[$key] );

                            if ( isset( $children[$term->term_id] ) )
                                $output .= ppt_to_process_hierarhically( $taxonomy, $terms, $children,  $term->term_id, $level + 1 );   
                        }
                        else
                        {
                            // ignore if not search?!?
                            if ( $term->parent != $parent || empty( $_REQUEST['s'] ) )
                                continue;
                    
                            $output .= $term->term_id . ",";
                    
                            unset( $terms[$key] );

                            if ( isset( $children[$term->term_id] ) )
                                $output .= ppt_to_process_hierarhically( $taxonomy, $terms, $children,  $term->term_id, $level + 1 );
                        }
                }

            return $output;
        
        }

        
    
    function ppt_orderby_admin_scripts()
        {
            
            wp_enqueue_script('jquery');
            
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-widget');
            wp_enqueue_script('jquery-ui-mouse');
            
            $myJavascriptFile = ppt_orderby_URL . '/js/touch-punch.min.js';
            wp_register_script('touch-punch.min.js', $myJavascriptFile, array(), '', TRUE);
            wp_enqueue_script( 'touch-punch.min.js');
               
            $myJavascriptFile = ppt_orderby_URL . '/js/nested-sortable.js';
            wp_register_script('nested-sortable.js', $myJavascriptFile, array(), '', TRUE);
            wp_enqueue_script( 'nested-sortable.js');
            
            $myJsFile = ppt_orderby_URL . '/js/to-javascript.js';
            wp_register_script('to-javascript.js', $myJsFile);
            wp_enqueue_script( 'to-javascript.js');
               
        }
        
    
    function ppt_orderby_admin_styles()
        {
            $myCssFile = ppt_orderby_URL . '/css/to.css';
            wp_register_style('to.css', $myCssFile);
            wp_enqueue_style( 'to.css');
        }
        
 
    
 
    function ppt_orderby_PluginMenu() 
        {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            
            include (ppt_orderby_PATH . '/include/interface.php');
            include (ppt_orderby_PATH . '/include/terms_walker.php');
            
            include (ppt_orderby_PATH . '/include/options.php');
            
              
            //add_options_page('Taxonomy Terms Order', 'Taxonomy Terms Order', 'manage_options', 'to-options', 'to_plugin_options');
                    
            $options = get_option('tto_options');
            
            if(isset($options['capability']) && !empty($options['capability']))
                    {
                        $capability = $options['capability'];
                    }
                else if (isset($options['level']) && is_numeric($options['level']))
                    {
                        //maintain the old user level compatibility
                        $capability = ppt_userdata_get_user_level();
                    }
                    else
                        {
                            $capability = 'install_plugins';  
                        }
            
            
            //put a menu within all custom types if apply
            $post_types = get_post_types();
            foreach( $post_types as $post_type) 
                {
                        
                    //check if there are any taxonomy for this post type
                    $post_type_taxonomies = get_object_taxonomies($post_type);
                          
                    if (count($post_type_taxonomies) == 0)
                        continue;                
                    
                    $menu_title = apply_filters('atto/admin/menu_title', 'Taxonomy Order', $post_type);
                    
                    if ($post_type == 'post')
                        $hookID =   add_submenu_page('edit.php', $menu_title, $menu_title, $capability, 'to-interface-'.$post_type, 'WLTPluginInterface' );
                        elseif ($post_type == 'attachment')
                        $hookID =   add_submenu_page('upload.php', $menu_title, $menu_title, $capability, 'to-interface-'.$post_type, 'WLTPluginInterface' );
                        elseif($post_type == 'shopp_product'   &&  is_plugin_active('shopp/Shopp.php'))
                        {
                            $hookID =   add_submenu_page('shopp-products', $menu_title, $menu_title, $capability, 'to-interface-'.$post_type, 'WLTPluginInterface' );
                        }
                        else
                        $hookID =   add_submenu_page('edit.php?post_type='.$post_type, $menu_title, $menu_title, $capability, 'to-interface-'.$post_type, 'WLTPluginInterface' );
                        
                    add_action('admin_print_styles-' . $hookID , 'ppt_orderby_admin_styles');
                    add_action('admin_print_scripts-' . $hookID , 'ppt_orderby_admin_scripts');
                }
        }
        
        
    add_action( 'wp_ajax_update-taxonomy-order', 'ppt_orderby_SaveAjaxOrder' );
    function ppt_orderby_SaveAjaxOrder()
        {
            global $wpdb; 
            
            parse_str($_POST['order'], $data);

            $taxonomy   = $_POST['taxonomy'];
            
            //retrieve the taxonomy details 
            $taxonomy_info = get_taxonomy($taxonomy);
            if($taxonomy_info->hierarchical === TRUE)    
                $is_hierarchical = TRUE;
                else
                $is_hierarchical = TRUE;
            
            //WPML fix
            if (defined('ICL_LANGUAGE_CODE'))
                {
                    global $iclTranslationManagement, $sitepress;
                    
                    remove_action('edit_term',  array($iclTranslationManagement, 'edit_term'),11, 2);
                    remove_action('edit_term',  array($sitepress, 'create_term'),1, 2);
                }
            
            
            if (is_array($data))
                {
                        
                    //prepare the var which will hold the item childs current order
                    $childs_current_order = array();
                    
                    foreach($data['item'] as $term_id => $parent_id ) 
                        {
                            if($is_hierarchical === TRUE)
                                {
                                    //$current_item_term_order = '';
                                    if($parent_id != 'null')
                                        {
                                            $childs_current_order[$parent_id] = $current_item_term_order;
                                                
                                            $current_item_term_order    = $childs_current_order[$parent_id];
                                            $term_parent                = $parent_id;
                                        }
                                        else
                                            {
                                                                                
                                                $current_item_term_order    = isset($current_item_term_order) ? $current_item_term_order : 1;
                                                $term_parent                = 0;
                                            }
                                        
                                    //update the term_order
                                    $args = array(
                                                    'term_order'    =>  $current_item_term_order,
                                                    'parent'        =>  $term_parent
                                                    );
                                    wp_update_term($term_id, $taxonomy, $args);
                                    //update the term_order as the above function can't do that !!
                                    $wpdb->update( $wpdb->terms, array('term_order' => $current_item_term_order), array('term_id' => $term_id) );
                                    
                                    do_action('ppt_order_update_hierarchical', array('term_id' =>  $term_id, 'position' =>  $current_item_term_order, 'term_parent'    =>  $term_parent));
                                    
                                    $current_item_term_order++;
                                    
                                    continue;
                                }
                                
                            //update the non-hierarhical structure
                            $current_item_term_order = 1;
                                
                            //update the term_order
                            $args = array(
                                            'term_order'    =>  $current_item_term_order
                                            );
                            wp_update_term($term_id, $taxonomy, $args);
                            //update the term_order as there code can't do that !! bug - hope they will fix soon! 
                            $wpdb->update( $wpdb->terms, array('term_order' => $current_item_term_order), array('term_id' => $term_id) );
                            do_action('ppt_order_update', array('term_id' =>  $term_id, 'position' =>  $current_item_term_order, 'term_parent'    =>  $term_parent));
                            
                            $current_item_term_order++;
        
                        }
        
                    if($is_hierarchical === TRUE)
                        _get_term_hierarchy($taxonomy);
                }

            die();
        }



    /**
    * @desc 
    * 
    * Return UserLevel
    * 
    */
    function ppt_userdata_get_user_level($return_as_numeric = FALSE)
        {
            global $userdata;
            
            $user_level = '';
            for ($i=10; $i >= 0;$i--)
                {
                    if (current_user_can('level_' . $i) === TRUE)
                        {
                            $user_level = $i;
                            if ($return_as_numeric === FALSE)
                                $user_level = 'level_'.$i; 
                            break;
                        }    
                }        
            return ($user_level);
        }    
        
 
        
    function ppt_get_the_terms($terms = '', $id = '', $taxonomy = '')
        {
            if($terms == '' || $id == '' || $taxonomy == '' || (is_array($terms) && count($terms) < 1))
                return '';
            
            $options = get_option('tto_options'); 

            //if admin make sure use the admin setting
            if (is_admin())
                return $terms;
            
            if (!is_array($terms) || $terms === FALSE)
                return $terms;
                
            if ($options['autosort'] != "1")
                return $terms;
                
            if (is_array($taxonomy) && count($taxonomy) > 1)
                return $terms;
                else if(is_array($taxonomy))
                    {
                        $taxonomy = $taxonomy[0];
                    }
            
            //check the current setting for current taxonomy
            $order_type = (isset($options['taxonomy_settings'][$taxonomy]['order_type'])) ? $options['taxonomy_settings'][$taxonomy]['order_type'] : 'manual'; 
            
            //if manual
            if ($order_type == 'manual')
                {

                    $terms = ppt_reindex_terms_array($terms, 'term_order');
                    
                    return $terms;
                }
                
            //if auto
            $auto_order_by = isset($options['taxonomy_settings'][$taxonomy]['auto']['order_by']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order_by'] : 'name';
            $auto_order = isset($options['taxonomy_settings'][$taxonomy]['auto']['order']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order'] : 'desc';
            
            
            $order_by = "";
            switch ($auto_order_by)
                {
                    case 'id':
                                $terms = ppt_reindex_terms_array($terms, 'term_id');
                                break;
                    case 'name':
                                $terms = ppt_reindex_terms_array($terms, 'name');
                                break;
                    case 'slug':
                                $terms = ppt_reindex_terms_array($terms, 'slug');
                                break;
                    case 'count':
                                $terms = ppt_reindex_terms_array($terms, 'count');
                                break;
                                
                    case 'random':
                                shuffle($terms);
                                break;
                    default :
                                break;
                }
            
            if ($auto_order == 'desc')
                $terms = array_reverse($terms);
            
            return $terms;
        }
        
    function ppt_reindex_terms_array($terms, $required_field)
        {
		
            //re-arange the term list
            $_reordered_key_relation = array();
            foreach ($terms as $key => $term)
                {
                    $_reordered_key_relation[$key]  = strtolower($term->{$required_field});
                }
            
            asort($_reordered_key_relation);
            $_terms = array();
            
            foreach ($_reordered_key_relation as $key => $term)
                {
                    $_terms[] = $terms[$key];
                }    
                
                
            $terms = array_values($_terms);
            
            return $terms;   
            
        }
        
    function ppt_get_term_hierarchy($taxonomy)
        {
		
            if ( !is_taxonomy_hierarchical($taxonomy) ){ return array(); }
            
            global $wpdb;
			
			$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		      
          // $children = get_option("{$taxonomy}_children"); // MARKS EDIT UNCOMMENTS THESE TWO TO SAVE HUNDRED+ QUERIES
            //return $children;
            
            //retrieve all terms of this taxonomy and set a hierarchy array data
            $sql_query  =   "SELECT t.term_id, tt.parent, tt.count, tt.taxonomy FROM ".  $wpdb->terms ." AS t 
                                INNER JOIN ".  $wpdb->term_taxonomy ." AS tt ON t.term_id = tt.term_id 
                                WHERE tt.taxonomy IN ('"    .   $taxonomy   ."') 
                                ORDER BY t.term_order ASC";
            $results            =   $wpdb->get_results($sql_query);

            $children = array();
            
            if(count($results)  >   0)
            foreach($results    as  $result)
                {
                    if($result->parent  <   1)
                        continue;
                        
                    $children[$result->parent][]    =   $result->term_id;
                    
                }
       
            return $children;   
            
        }
        
    /**
    * Apply customised sort to array of terms
    * 
    * @param mixed $terms_array, can contain term_id or terms data array
    * @param mixed $taxonomy
    */
    function ppt_apply_term_order($terms_array,    $taxonomy)
        {
            $argv   =   array(
                                'orderby'           => 'term_order',
                                'fields'            => 'term_id',
                                );   
            
        }
        
 

?>