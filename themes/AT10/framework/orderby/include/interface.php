<?php


    function WLTPluginInterface()
        {
            global $wpdb, $wp_locale, $CORE_ADMIN;
            
            $options = get_option('tto_options');
              
            $taxonomy = isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : '';
            $post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';
            
            if(empty($post_type))
                {
                    $screen = get_current_screen();
                    
                    if(isset($screen->post_type)    && !empty($screen->post_type))
                        $post_type  =   $screen->post_type;
                        else
                        {
                            switch($screen->parent_file)
                                {
                                    case "upload.php" :
                                                                $post_type  =   'attachment';
                                                                break;
                                                        
                                    case "shopp-products"   :
                                                                $post_type  =   'shopp_product';
                                                                break;
                                                
                                    default:
                                                                $post_type  =   'post';   
                                }
                        }       
                }
                    
            $post_type_taxonomies = get_object_taxonomies($post_type);
        
            //use the first taxonomy if emtpy taxonomy
            if ($taxonomy == '' || !taxonomy_exists($taxonomy))
                {
                    reset($post_type_taxonomies);   
                    $taxonomy = current($post_type_taxonomies);
                }
                                
            $post_type_data = get_post_type_object($post_type);
            
            if (!taxonomy_exists($taxonomy))
                $taxonomy = '';
            
            //set as default for auto
            $order_type = (isset($options['taxonomy_settings'][$taxonomy]['order_type'])) ? $options['taxonomy_settings'][$taxonomy]['order_type'] : 'manual'; 
            
            
            $taxonomy_info = get_taxonomy($taxonomy);
            
            
            if (isset($_GET['switch_order_type']))
                {
                    $order_type =   $_GET['switch_order_type'];
                              
                    //save the new order
                    $options['taxonomy_settings'][$taxonomy]['order_type'] = $order_type;
                    update_option('tto_options', $options); 
                    
                    echo '<div class="message updated fade"><p>'. __('Order type for','premiumpress') . ' ' .$taxonomy_info->label.' '. __('Switched to', 'premiumpress'). ' ' . ucfirst($order_type)  .'</p></div>';  
                }
                        
            //check for order type update
            if (isset($_POST['order_type']))
                {
                    $new_order_type = $_POST['order_type'];
                    if ($new_order_type != 'auto' && $new_order_type != 'manual')
                        $new_order_type = '';
                        
                    if ($new_order_type != '')
                        {
                            
                            echo '<div class="message updated fade"><p>'. __('Order updated','premiumpress') .'</p></div>';
                            $order_type = $new_order_type;
                            
                            //save the new order
                            $options['taxonomy_settings'][$taxonomy]['order_type'] = $order_type;

                            //update the orde_by
                            if (isset($_POST['auto_order_by']))
                                {
                                    $new_order_by = $_POST['auto_order_by'];
                                    if ($new_order_by != '')
                                        $options['taxonomy_settings'][$taxonomy]['auto']['order_by'] = $new_order_by;
                                } 
                            
                            //update the orde_by
                            if (isset($_POST['auto_order']))
                                {
                                    $new_order = $_POST['auto_order'];
                                    if ($new_order_by != '')
                                        $options['taxonomy_settings'][$taxonomy]['auto']['order'] = $new_order;
                                }    
                                
                            update_option('tto_options', $options);                        
                        }
                }
            
            if(isset($taxonomy_info->hierarchical) && $taxonomy_info->hierarchical === TRUE)    
                $is_hierarchical = TRUE;
                else
                $is_hierarchical = FALSE;

            
            $current_section_parent_file    =   '';
     
            switch($post_type)
                {
                    case "post" :
                                    $current_section_parent_file    =    "edit.php";
                                    break;
                    case "attachment" :
                                    $current_section_parent_file    =   "upload.php";
                                    break;
                }
    
            ?>    
            <div id="atto" class="wrap">
          

                <div id="ajax-response"></div>
                
    

                <div class="clear"></div>
                
                <?php do_action('ato_interface_before_form'); ?>
                </form>
                <form action="<?php  echo $current_section_parent_file ?>" method="get" id="to_form">
                    <input type="hidden" name="page" value="to-interface-<?php echo $post_type ?>" />
                    
                    <input type="hidden" name="taxonomy" value="" id="chageTaxValue" />
                    
                    
                    <?php
                
                     if (!in_array($post_type, array('post', 'attachment')))
                        echo '<input type="hidden" name="post_type" value="'. $post_type .'" />';

                    
                                            
                    if (count($post_type_taxonomies) > -1) {
						
						global $CORE_ADMIN;
                echo $CORE_ADMIN->HEAD();
                            ?>
                            </form>
 
 
 
<div class="main-body-column ">

<div class="tab-content ppt-wrap">
 
<h1>Taxonomy Order</h1>

<div class="padding">
 
             
<nav class="nav nav-inline">

<a class="nav-link">Select Taxonomy: </a>
                                <?php
                                    
                                    $alternate = FALSE;
                                    foreach ($post_type_taxonomies as $key => $post_type_taxonomy)
                                        {
                                            $taxonomy_info = get_taxonomy($post_type_taxonomy);

                                            $alternate = $alternate === TRUE ? FALSE :TRUE;
                                            
                                            
                                            $args = array(
                                                            'hide_empty'    =>  0
                                                            );
                                            $taxonomy_terms = get_terms($post_type_taxonomy, $args);
                                                             
                                            ?>
                                             
                                            <a class="nav-link <?php if ($post_type_taxonomy == $taxonomy) {echo 'active';} ?>" href="javascript:void(0);" onclick="to_change_taxonomy('<?php echo $post_type_taxonomy ?>')"> 
                                            
                                            <b><?php echo $taxonomy_info->label ?></b>  <!--(<?php echo  $taxonomy_info->labels->singular_name; ?>) -->
                                                        
                                            (<?php echo count($taxonomy_terms) ?>)
                                            
                                            </a>
                                               
                                        
                                            <?php
                                        }
                                ?>
                                          
</nav>
                            <?php
                        }
                            ?>
                </form>
                

	
 
    
          



                            <h4 class="ntitle"><?php echo ucfirst($post_type_data->labels->name) ?> Taxonomies</h4>
                            
                
 
   
                
              
                <script >    

                    var taxonomy    = '<?php echo $taxonomy ?>';

                </script>
               
               
                <?php

                    $url_query_vars =   array(
                                                "page"          =>  "to-interface-" .   $post_type,
                                                "taxonomy"      =>  $taxonomy 
                                                );

                    if (!in_array($post_type, array('post', 'attachment')))   
                        $url_query_vars['post_type']    =   $post_type;
                 
                ?>
                <form action="<?php  echo $current_section_parent_file ?>?<?php echo http_build_query($url_query_vars) ?>" method="post" id="to_form">
                    <input type="hidden" name="order_type" value="<?php echo $order_type ?>" />
                    <?php
                
                    if (!in_array($post_type, array('post', 'attachment')))
                        echo '<input type="hidden" name="post_type" value="'. $post_type .'" />';
                
                    $url_query_vars =   array(
                                                "page"          =>  "to-interface-" .   $post_type,
                                                "taxonomy"      =>  $taxonomy 
                                                );
                    
                    if (!in_array($post_type, array('post', 'attachment')))   
                        $url_query_vars['post_type']    =   $post_type;
                     
                    ?>
                
                <h2 class="nav-tab-wrapper" id="apto-nav-tab-wrapper">
                    <a href="<?php  echo $current_section_parent_file ?>?<?php echo http_build_query(array_merge($url_query_vars, array("switch_order_type" => "auto"))) ?>" class="nav-tab<?php if ($order_type == 'auto') {echo ' nav-tab-active';} ?>"><?php _e('Automatic Order', 'premiumpress') ?></a>
                    <a href="<?php  echo $current_section_parent_file ?>?<?php echo http_build_query(array_merge($url_query_vars, array("switch_order_type" => "manual"))) ?>" class="nav-tab<?php if ($order_type == 'manual') {echo ' nav-tab-active';} ?>"><?php _e('Manual Order', 'premiumpress') ?></a>
                </h2>
                <?php if ($order_type == 'auto')
                        {
                           ?>
                            <div class="atto_metabox">
                                                   
                               <h4 class="ntitle"><?php _e('Order By', 'premiumpress') ?></h4>
                               
                               
                                                <?php
                                                
                                                    $auto_order_by = isset($options['taxonomy_settings'][$taxonomy]['auto']['order_by']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order_by'] : 'name';

                                                ?>
                                                
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'default') {echo 'checked="checked"'; } ?> value="default" id="order_by_default" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Default', 'premiumpress') ?></label>                                                
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'id') {echo 'checked="checked"'; } ?> value="id" id="order_by_id" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Creation Time / ID', 'premiumpress') ?></label> 
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'name') {echo 'checked="checked"'; } ?> value="name" id="order_by_name" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Name', 'premiumpress') ?></label>
                                                </div>
                                                
                                                <div class="clearfix"></div>                                                
                                                
                                               <?php /*
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'count') {echo 'checked="checked"'; } ?> value="count" id="order_by_count" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Count', 'premiumpress') ?></label>
                                                </div>
                                                
                                                <div class="clearfix"></div> 
												*/ ?>                                               
                                                
                                                
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'slug') {echo 'checked="checked"'; } ?> value="slug" id="order_by_slug" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Slug', 'premiumpress') ?></label>
                                                </div>
                                                
                                                <div class="clearfix"></div>                                                
                                                
                                                <?php /*
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order_by == 'random') {echo 'checked="checked"'; } ?> value="random" id="order_by_random" name="auto_order_by" />
                                                </div>
                                                <label class="control-label col-7"><?php _e('Random', 'premiumpress') ?></label>
                                                </div>
                                                */ ?>
                                                
                                                
                                                 
                                      <h4 class="ntitle"><?php _e('Order', 'premiumpress') ?></h4>
                                                <?php
                                                
                                                    $auto_order = isset($options['taxonomy_settings'][$taxonomy]['auto']['order']) ? $options['taxonomy_settings'][$taxonomy]['auto']['order'] : 'desc';

                                                ?>
                                                
                                                
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order == 'desc') {echo 'checked="checked"'; } ?> value="desc" id="order_desc" name="auto_order" />
                                                
                                                </div>
                                                <label for="order_desc"><?php _e('Descending', 'premiumpress') ?></label>
                                                </div>
												
                                                <div class="row">                                               
                                                <div class="controls col-1">
                                                <input type="radio" <?php if ($auto_order == 'asc') {echo 'checked="checked"'; } ?> value="asc" id="order_asc" name="auto_order" />
                                                </div>
                                                <label for="order_asc"><?php _e('Ascending', 'premiumpress') ?></label><br>
                                                </div>
                                                
                                    <input type="submit" value="<?php _e('Update', 'premiumpress') ?>" class="button-primary" name="update">
                                
                            </div>
                            
                            <?php
                        }
                ?>
               
               
               
               
               <?php if ($order_type == 'manual')
                        {
                           ?>
                            <div id="order-terms">
                                
                                <div id="nav-menu-header">
                                    <div class="major-publishing-actions">

                                            
                                            <div class="alignright actions">
                                                <p class="actions">
                  
                                                    <span class="img_spacer">&nbsp;
                                                        <img alt="" src="<?php echo ppt_orderby_URL ?>/images/wpspin_light.gif" class="waiting pto_ajax_loading" style="display: none;">
                                                    </span>
                                                    <a href="javascript:;" class="save-order button-primary"><?php _e('Update', 'premiumpress') ?></a>
                                                </p>
                                            </div>
                                            
                                            <div class="clear"></div>

                                    </div><!-- END .major-publishing-actions -->
                                </div><!-- END #nav-menu-header -->

                                
                                <div id="post-body">                    
                                    
                                        <ul id="sortable">
                                            <?php 
                                                
                                                WLTlistTerms($taxonomy); 
                                            ?>
                                        </ul>
                                        
                                        <div class="clear"></div>
                                </div>
                                
                                <div id="nav-menu-footer">
                                    <div class="major-publishing-actions">
                                            <div class="alignright actions">
                                                <img alt="" src="<?php echo ppt_orderby_URL ?>/images/wpspin_light.gif" class="waiting pto_ajax_loading" style="display: none;">
                                                <a href="javascript:;" class="save-order button-primary"><?php _e('Update', 'premiumpress') ?></a>
                                            </div>
                                            
                                            <div class="clear"></div>

                                    </div><!-- END .major-publishing-actions -->
                                </div><!-- END #nav-menu-header -->
                                
                            </div>
                            
                            <?php
                        }
                ?> 

                </form>

                
                <script >
    
                    jQuery(document).ready(function() {
                        
                        jQuery('ul#sortable').nestedSortable({
                                handle:             'div',
                                tabSize:            20,
                                listType:           'ul',
                                items:              'li',
                                toleranceElement:   '> div',
                                placeholder:        'ui-sortable-placeholder',
                                disableNesting:     'no-nesting'
                                <?php
                    
                                    if ($is_hierarchical === TRUE)
                                        {
                                        }
                                        else
                                        {
                                            ?>,disableNesting      :true<?php
                                        }
                                ?>});
                          
                        jQuery(".save-order").bind( "click", function() {
                            jQuery(this).parent().find('img').show();
                            
                            var serialized = jQuery('ul#sortable').nestedSortable('serialize');
                            
                            jQuery.post( ajaxurl, { 
                                                        action:         'update-taxonomy-order', 
                                                        order:          jQuery("#sortable").nestedSortable("serialize"),
                                                        taxonomy:       taxonomy
                            }, function() {
                                    jQuery("#ajax-response").html('<div class="message updated fade"><p><?php _e( "Items Order Updated", 'premiumpress' ) ?></p></div>');
                                    jQuery("#ajax-response div").delay(3000).hide("slow");
                                    jQuery('img.pto_ajax_loading').hide();
                                });
                        });
                    });
                </script>
                
            </div> </div></div>
            
            
            <?php 
             echo $CORE_ADMIN->FOOTER();
            
        }
    
    
    function WLTlistTerms($taxonomy) 
            {

                // Query pages.
                $args = array(
                            'orderby'       =>  'term_order',
                            'depth'         =>  0,
                            'child_of'      => 0,
                            'hide_empty'    =>  0
                );
                $taxonomy_terms = get_terms($taxonomy, $args);

                $output = '';
                if (count($taxonomy_terms) > 0)
                    {
                        $output = WLTTOwalkTree($taxonomy_terms, $args['depth'], $args);    
                    }

                echo $output; 
                
            }
        
        function WLTTOwalkTree($taxonomy_terms, $depth, $r) 
            {
                $walker = new WLT_TO_Terms_Walker; 
                $args = array($taxonomy_terms, $depth, $r);
                return call_user_func_array(array(&$walker, 'walk'), $args);
            }

?>