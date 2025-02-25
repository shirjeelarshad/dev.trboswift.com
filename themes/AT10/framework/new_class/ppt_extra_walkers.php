<?php

// Check if Class Exists.
if ( ! class_exists( 'WP_Bootstrap_Navwalker' ) ) {
	/**
	 * WP_Bootstrap_Navwalker class.
	 *
	 * @extends Walker_Nav_Menu
	 */
	class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

		/**
		 * Starts the list before the elements are added.
		 *
		 * @since WP 3.0.0
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			// Default class to add to the file.
			$classes = array( 'dropdown-menu' );
			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @since WP 4.8.0
			 *
			 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
			 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/*
			 * The `.dropdown-menu` container needs to have a labelledby
			 * attribute which points to it's trigger link.
			 *
			 * Form a string for the labelledby attribute from the the latest
			 * link with an id that was added to the $output.
			 */
			$labelledby = '';
			// Find all links with an id in the output.
			preg_match_all( '/(<a.*?id=\"|\')(.*?)\"|\'.*?>/im', $output, $matches );
			// With pointer at end of array check if we got an ID match.
			if ( end( $matches[2] ) ) {
				// Build a string to use as aria-labelledby.
				$labelledby = 'aria-labelledby="' . esc_attr( end( $matches[2] ) ) . '"';
			}
			$output .= "{$n}{$indent}<ul$class_names $labelledby role=\"menu\">{$n}";
		}

		/**
		 * Starts the element output.
		 *
		 * @since WP 3.0.0
		 * @since WP 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param WP_Post  $item   Menu item data object.
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int      $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			/*
			 * Initialize some holder variables to store specially handled item
			 * wrappers and icons.
			 */
			$linkmod_classes = array();
			$icon_classes    = array();

			/*
			 * Get an updated $classes array without linkmod or icon classes.
			 *
			 * NOTE: linkmod and icon class arrays are passed by reference and
			 * are maybe modified before being used later in this function.
			 */
			$classes = self::separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes, $depth );

			// Join any icon classes plucked from $classes into a string.
			$icon_class_string = join( ' ', $icon_classes );

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 *  WP 4.4.0
			 *
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param WP_Post  $item  Menu item data object.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			// Add .dropdown or .active classes where they are needed.
			if ( isset( $args->has_children ) && $args->has_children ) {
				$classes[] = 'dropdown';
			}
			if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
				$classes[] = 'active';
			}

			// Add some additional default classes to the item.
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'nav-item';

			// Allow filtering the classes.
			$classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );

			// Form a string of classes in format: class="class_names".
			$class_names = join( ' ', $classes );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since WP 3.0.1
			 * @since WP 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Post  $item    The current menu item.
			 * @param stdClass $args    An object of wp_nav_menu() arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $class_names . '>';

			// Initialize array for holding the $atts for the link item.
			$atts = array();

			/*
			 * Set title from item to the $atts array - if title is empty then
			 * default to item title.
			 */
			if ( empty( $item->attr_title ) ) {
				$atts['title'] = ! empty( $item->title ) ? strip_tags( $item->title ) : '';
			} else {
				$atts['title'] = $item->attr_title;
			}
			 

			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			// If the item has children, add atts to the <a>.
			if ( isset( $args->has_children ) && $args->has_children && 0 === $depth && $args->depth > 1 ) {
				$atts['href']          = '#'; // $item->url
				$atts['data-toggle']   = 'dropdown';
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
				$atts['class']         = 'dropdown-toggle nav-link';
				$atts['id']            = 'menu-item-dropdown-' . $item->ID;
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
				// For items in dropdowns use .dropdown-item instead of .nav-link.
				if ( $depth > 0 ) {
					$atts['class'] = 'dropdown-item';
				} else {
					$atts['class'] = 'nav-link';
				}
			}

			$atts['aria-current'] = $item->current ? 'page' : '';

			// Update atts of this item based on any custom linkmod classes.
			$atts = self::update_atts_for_linkmod_type( $atts, $linkmod_classes );
			// Allow filtering of the $atts array before using it.
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			// Build a string of html containing all the atts for the item.
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			// Set a typeflag to easily test if this is a linkmod or not.
			$linkmod_type = self::get_linkmod_type( $linkmod_classes );

			// START appending the internal item contents to the output.
			$item_output = isset( $args->before ) ? $args->before : '';

			/*
			 * This is the start of the internal nav item. Depending on what
			 * kind of linkmod we have we may need different wrapper elements.
			 */
			if ( '' !== $linkmod_type ) {
				// Is linkmod, output the required element opener.
				$item_output .= self::linkmod_element_open( $linkmod_type, $attributes );
			} else {
				// With no link mod type set this must be a standard <a> tag.
				$item_output .= '<a' . $attributes . '>';
			}

			/*
			 * Initiate empty icon var, then if we have a string containing any
			 * icon classes form the icon markup with an <i> element. This is
			 * output inside of the item before the $title (the link text).
			 */
			$icon_html = '';
			if ( ! empty( $icon_class_string ) ) {
				// Append an <i> with the icon classes to what is output before links.
				$icon_html = '<i class="' . esc_attr( $icon_class_string ) . '" aria-hidden="true"></i> ';
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', esc_html( $item->title ), $item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @since WP 4.4.0
			 *
			 * @param string   $title The menu item's title.
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			// If the .sr-only class was set apply to the nav items text only.
			if ( in_array( 'sr-only', $linkmod_classes, true ) ) {
				$title         = self::wrap_for_screen_reader( $title );
				$keys_to_unset = array_keys( $linkmod_classes, 'sr-only', true );
				foreach ( $keys_to_unset as $k ) {
					unset( $linkmod_classes[ $k ] );
				}
			}

			// Put the item contents into $output.
			$item_output .= isset( $args->link_before ) ? $args->link_before . $icon_html . $title . $args->link_after : '';

			/*
			 * This is the end of the internal nav item. We need to close the
			 * correct element depending on the type of link or link mod.
			 */
			if ( '' !== $linkmod_type ) {
				// Is linkmod, output the required closing element.
				$item_output .= self::linkmod_element_close( $linkmod_type );
			} else {
				// With no link mod type set this must be a standard <a> tag.
				$item_output .= '</a>';
			}

			$item_output .= isset( $args->after ) ? $args->after : '';

			// END appending the internal item contents to the output.
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since WP 2.5.0
		 *
		 * @see Walker::start_lvl()
		 *
		 * @param object $element           Data object.
		 * @param array  $children_elements List of elements to continue traversing (passed by reference).
		 * @param int    $max_depth         Max depth to traverse.
		 * @param int    $depth             Depth of current element.
		 * @param array  $args              An array of arguments.
		 * @param string $output            Used to append additional content (passed by reference).
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return; }
			$id_field = $this->db_fields['id'];
			// Display this element.
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback.
		 *
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'edit_theme_options' ) ) {

				// Get Arguments.
				$container       = $args['container'];
				$container_id    = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class      = $args['menu_class'];
				$menu_id         = $args['menu_id'];

				// Initialize var to store fallback html.
				$fallback_output = '';

				if ( $container ) {
					$fallback_output .= '<' . esc_attr( $container );
					if ( $container_id ) {
						$fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
					}
					if ( $container_class ) {
						$fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
					}
					$fallback_output .= '>';
				}
				$fallback_output .= '<ul';
				if ( $menu_id ) {
					$fallback_output .= ' id="' . esc_attr( $menu_id ) . '"'; }
				if ( $menu_class ) {
					$fallback_output .= ' class="' . esc_attr( $menu_class ) . '"'; }
				$fallback_output .= '>';
				$fallback_output .= '<li class="nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . esc_attr__( 'Add a menu', 'premiumpress' ) . '">' . esc_html__( 'Add a menu', 'premiumpress' ) . '</a></li>';
				$fallback_output .= '</ul>';
				if ( $container ) {
					$fallback_output .= '</' . esc_attr( $container ) . '>';
				}

				// If $args has 'echo' key and it's true echo, otherwise return.
				if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
					echo $fallback_output; // WPCS: XSS OK.
				} else {
					return $fallback_output;
				}
			}
		}

		/**
		 * Find any custom linkmod or icon classes and store in their holder
		 * arrays then remove them from the main classes array.
		 *
		 * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
		 * Supported iconsets: Font Awesome 4/5, Glypicons
		 *
		 * NOTE: This accepts the linkmod and icon arrays by reference.
		 *
		 * @since 4.0.0
		 *
		 * @param array   $classes         an array of classes currently assigned to the item.
		 * @param array   $linkmod_classes an array to hold linkmod classes.
		 * @param array   $icon_classes    an array to hold icon classes.
		 * @param integer $depth           an integer holding current depth level.
		 *
		 * @return array  $classes         a maybe modified array of classnames.
		 */
		private function separate_linkmods_and_icons_from_classes( $classes, &$linkmod_classes, &$icon_classes, $depth ) {
			// Loop through $classes array to find linkmod or icon classes.
			foreach ( $classes as $key => $class ) {
				/*
				 * If any special classes are found, store the class in it's
				 * holder array and and unset the item from $classes.
				 */
				if ( preg_match( '/^disabled|^sr-only/i', $class ) ) {
					// Test for .disabled or .sr-only classes.
					$linkmod_classes[] = $class;
					unset( $classes[ $key ] );
				} elseif ( preg_match( '/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class ) && $depth > 0 ) {
					/*
					 * Test for .dropdown-header or .dropdown-divider and a
					 * depth greater than 0 - IE inside a dropdown.
					 */
					$linkmod_classes[] = $class;
					unset( $classes[ $key ] );
				} elseif ( preg_match( '/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class ) ) {
					// Font Awesome.
					$icon_classes[] = $class;
					unset( $classes[ $key ] );
				} elseif ( preg_match( '/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class ) ) {
					// Glyphicons.
					$icon_classes[] = $class;
					unset( $classes[ $key ] );
				}
			}

			return $classes;
		}

		/**
		 * Return a string containing a linkmod type and update $atts array
		 * accordingly depending on the decided.
		 *
		 * @since 4.0.0
		 *
		 * @param array $linkmod_classes array of any link modifier classes.
		 *
		 * @return string                empty for default, a linkmod type string otherwise.
		 */
		private function get_linkmod_type( $linkmod_classes = array() ) {
			$linkmod_type = '';
			// Loop through array of linkmod classes to handle their $atts.
			if ( ! empty( $linkmod_classes ) ) {
				foreach ( $linkmod_classes as $link_class ) {
					if ( ! empty( $link_class ) ) {

						// Check for special class types and set a flag for them.
						if ( 'dropdown-header' === $link_class ) {
							$linkmod_type = 'dropdown-header';
						} elseif ( 'dropdown-divider' === $link_class ) {
							$linkmod_type = 'dropdown-divider';
						} elseif ( 'dropdown-item-text' === $link_class ) {
							$linkmod_type = 'dropdown-item-text';
						}
					}
				}
			}
			return $linkmod_type;
		}

		/**
		 * Update the attributes of a nav item depending on the limkmod classes.
		 *
		 * @since 4.0.0
		 *
		 * @param array $atts            array of atts for the current link in nav item.
		 * @param array $linkmod_classes an array of classes that modify link or nav item behaviors or displays.
		 *
		 * @return array                 maybe updated array of attributes for item.
		 */
		private function update_atts_for_linkmod_type( $atts = array(), $linkmod_classes = array() ) {
			if ( ! empty( $linkmod_classes ) ) {
				foreach ( $linkmod_classes as $link_class ) {
					if ( ! empty( $link_class ) ) {
						/*
						 * Update $atts with a space and the extra classname
						 * so long as it's not a sr-only class.
						 */
						if ( 'sr-only' !== $link_class ) {
							$atts['class'] .= ' ' . esc_attr( $link_class );
						}
						// Check for special class types we need additional handling for.
						if ( 'disabled' === $link_class ) {
							// Convert link to '#' and unset open targets.
							$atts['href'] = '#';
							unset( $atts['target'] );
						} elseif ( 'dropdown-header' === $link_class || 'dropdown-divider' === $link_class || 'dropdown-item-text' === $link_class ) {
							// Store a type flag and unset href and target.
							unset( $atts['href'] );
							unset( $atts['target'] );
						}
					}
				}
			}
			return $atts;
		}

		/**
		 * Wraps the passed text in a screen reader only class.
		 *
		 * @since 4.0.0
		 *
		 * @param string $text the string of text to be wrapped in a screen reader class.
		 * @return string      the string wrapped in a span with the class.
		 */
		private function wrap_for_screen_reader( $text = '' ) {
			if ( $text ) {
				$text = '<span class="sr-only">' . $text . '</span>';
			}
			return $text;
		}

		/**
		 * Returns the correct opening element and attributes for a linkmod.
		 *
		 * @since 4.0.0
		 *
		 * @param string $linkmod_type a sting containing a linkmod type flag.
		 * @param string $attributes   a string of attributes to add to the element.
		 *
		 * @return string              a string with the openign tag for the element with attribibutes added.
		 */
		private function linkmod_element_open( $linkmod_type, $attributes = '' ) {
			$output = '';
			if ( 'dropdown-item-text' === $linkmod_type ) {
				$output .= '<span class="dropdown-item-text"' . $attributes . '>';
			} elseif ( 'dropdown-header' === $linkmod_type ) {
				/*
				 * For a header use a span with the .h6 class instead of a real
				 * header tag so that it doesn't confuse screen readers.
				 */
				$output .= '<span class="dropdown-header h6"' . $attributes . '>';
			} elseif ( 'dropdown-divider' === $linkmod_type ) {
				// This is a divider.
				$output .= '<div class="dropdown-divider"' . $attributes . '>';
			}
			return $output;
		}

		/**
		 * Return the correct closing tag for the linkmod element.
		 *
		 * @since 4.0.0
		 *
		 * @param string $linkmod_type a string containing a special linkmod type.
		 *
		 * @return string              a string with the closing tag for this linkmod type.
		 */
		private function linkmod_element_close( $linkmod_type ) {
			$output = '';
			if ( 'dropdown-header' === $linkmod_type || 'dropdown-item-text' === $linkmod_type ) {
				/*
				 * For a header use a span with the .h6 class instead of a real
				 * header tag so that it doesn't confuse screen readers.
				 */
				$output .= '</span>';
			} elseif ( 'dropdown-divider' === $linkmod_type ) {
				// This is a divider.
				$output .= '</div>';
			}
			return $output;
		}
	}
}
 


class Walker_Admin_Taxonomy extends Walker_Category {
 
    public $tree_type = 'category'; 
    public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
 
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
    
            return;
 
        $indent = str_repeat("\t", $depth);
         
    }
 
 
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' != $args['style'] )
            return;
 
        $indent = str_repeat("\t", $depth);
      
    }
 
 
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
		
		$sep = "";
		if($category->parent == 0){
		
		}else{
		$sep = " -- ";
		}
		
		if( in_array($category->term_id, $args['selected']) ){
		$output .= '<option value="'.$category->term_id.'" selected=selected>'. $sep . $cat_name .' (' . number_format_i18n( $category->count ) . ') </option>';
		}else{
		$output .= '<option value="'.$category->term_id.'">'. $sep . $cat_name .' (' . number_format_i18n( $category->count ) . ') </option>';
		}
        
 
         
    }
 
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
     
            return; 
        
    }
 
}



class walker_inline_menu extends Walker_Nav_Menu {   

 public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = ' list-inline-item menu-item-' . $item->ID;
 
        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param array  $args  An array of arguments.
         * @param object $item  Menu item data object.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
 
        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
 
        /**
         * Filters the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
 
        $output .= $indent . '<li' . $id . $class_names .'>';
 
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
 
        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of wp_nav_menu() arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
 
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
 
        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );
 
        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string $title The menu item's title.
         * @param object $item  The current menu item.
         * @param array  $args  An array of wp_nav_menu() arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
 
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
 
        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of wp_nav_menu() arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
/* =============================================================================
D_CATEGORIES SHORTCODE WALKER
========================================================================== */

class walker_dropdown_categories extends Walker_Category {  

function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) { global $CORE;
    /** This filter is documented in wp-includes/category-template.php */
    $cat_name = apply_filters(
        'list_cats',
        esc_attr( $category->name ),
        $category
    );
 
    // Don't generate an element if the category name is empty.
    if ( ! $cat_name ) {
        return;
    }
	
		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
 
    $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" class="dropdown-item" ';
    if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
        /**
         * Filters the category description for display.
         *
         * @since 1.2.0
         *
         * @param string $description Category description.
         * @param object $category    Category object.
         */
        $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
    }
	
	
 
    $link .= '>';
    $link .= $cat_name . '</a>';
 
    if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
        $link .= ' ';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= '(';
        }
 
        $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
        if ( empty( $args['feed'] ) ) {
            $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','premiumpress' ), $cat_name ) . '"';
        } else {
            $alt = ' alt="' . $args['feed'] . '"';
            $name = $args['feed'];
            $link .= empty( $args['title'] ) ? '' : $args['title'];
        }
 
        $link .= '>';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= $name;
        } else {
            $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
        }
        $link .= '</a>';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= ')';
        }
    } 
 
    if ( ! empty( $args['show_count'] ) ) {
        $link .= ' (' . number_format_i18n( $category->count ) . ')';
    }
    if ( 'list' == $args['style'] ) {
        //$output .= "\t<li";
        $css_classes = array(
            'cat-item',
            'cat-item-' . $category->term_id,
        );
 
        if ( ! empty( $args['current_category'] ) ) {
            // 'current_category' can be an array, so we use `get_terms()`.
            $_current_terms = get_terms( $category->taxonomy, array(
                'include' => $args['current_category'],
                'hide_empty' => false,
            ) );
 
            foreach ( $_current_terms as $_current_term ) {
                if ( $category->term_id == $_current_term->term_id ) {
                    $css_classes[] = 'current-cat';
                } elseif ( $category->term_id == $_current_term->parent ) {
                    $css_classes[] = 'current-cat-parent';
                }
                while ( $_current_term->parent ) {
                    if ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] =  'current-cat-ancestor';
                        break;
                    }
                    $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                }
            }
        }
 
        /**
         * Filters the list of CSS classes to include with each category in the list.
         *
         * @since 4.2.0
         *
         * @see wp_list_categories()
         *
         * @param array  $css_classes An array of CSS classes to be applied to each list item.
         * @param object $category    Category data object.
         * @param int    $depth       Depth of page, used for padding.
         * @param array  $args        An array of wp_list_categories() arguments.
         */
        $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
        //$output .=  ' class="' . $css_classes . '"';
        $output .= "$link\n";
    } elseif ( isset( $args['separator'] ) ) {
        $output .= "\t$link" . $args['separator'] . "\n";
    } else {
        $output .= "\t$link<br />\n";
    }
	
	}



    //function start_lvl(&$output, $depth=1, $args=array()) {  
    //    $output .= "\n<ul class=\"product_cats\">\n";  
    //}  

   // function end_lvl(&$output, $depth=0, $args=array()) {  
   //     $output .= "</ul>\n";  
    //}  
 
    function end_el(&$output, $item, $depth=0, $args=array()) {  
     $output .= "\n";  
   }  
}
 
/* =============================================================================
D_CATEGORIES SHORTCODE WALKER
========================================================================== */

class walker_dropdown_categories_form extends Walker_Category {  

function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) { global $CORE;
    /** This filter is documented in wp-includes/category-template.php */
    $cat_name = apply_filters(
        'list_cats',
        esc_attr( $category->name ),
        $category
    );
 
    // Don't generate an element if the category name is empty.
    if ( ! $cat_name ) {
        return;
    }
	
		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
 
    $link = '<a href="#" data-catid="'.$category->term_id.'" data-name="'.$category->name.'" class="dropdown-item" ';
	
    if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
        /**
         * Filters the category description for display.
         *
         * @since 1.2.0
         *
         * @param string $description Category description.
         * @param object $category    Category object.
         */
        $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
    }
	
	
 
    $link .= '>';
    $link .= $cat_name . '</a>';
 
    if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
        $link .= ' ';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= '(';
        }
 
     $link = '<a href="#" data-catid="'.$category->term_id.'" data-name="'.$category->name.'" class="dropdown-item" ';
 
        if ( empty( $args['feed'] ) ) {
            $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','premiumpress' ), $cat_name ) . '"';
        } else {
            $alt = ' alt="' . $args['feed'] . '"';
            $name = $args['feed'];
            $link .= empty( $args['title'] ) ? '' : $args['title'];
        }
 
        $link .= '>';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= $name;
        } else {
            $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
        }
        $link .= '</a>';
 
        if ( empty( $args['feed_image'] ) ) {
            $link .= ')';
        }
    } 
 
    if ( ! empty( $args['show_count'] ) ) {
        $link .= ' (' . number_format_i18n( $category->count ) . ')';
    }
    if ( 'list' == $args['style'] ) {
        //$output .= "\t<li";
        $css_classes = array(
            'cat-item',
            'cat-item-' . $category->term_id,
        );
 
        if ( ! empty( $args['current_category'] ) ) {
            // 'current_category' can be an array, so we use `get_terms()`.
            $_current_terms = get_terms( $category->taxonomy, array(
                'include' => $args['current_category'],
                'hide_empty' => false,
            ) );
 
            foreach ( $_current_terms as $_current_term ) {
                if ( $category->term_id == $_current_term->term_id ) {
                    $css_classes[] = 'current-cat';
                } elseif ( $category->term_id == $_current_term->parent ) {
                    $css_classes[] = 'current-cat-parent';
                }
                while ( $_current_term->parent ) {
                    if ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] =  'current-cat-ancestor';
                        break;
                    }
                    $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                }
            }
        }
 
        /**
         * Filters the list of CSS classes to include with each category in the list.
         *
         * @since 4.2.0
         *
         * @see wp_list_categories()
         *
         * @param array  $css_classes An array of CSS classes to be applied to each list item.
         * @param object $category    Category data object.
         * @param int    $depth       Depth of page, used for padding.
         * @param array  $args        An array of wp_list_categories() arguments.
         */
        $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
        //$output .=  ' class="' . $css_classes . '"';
        $output .= "$link\n";
    } elseif ( isset( $args['separator'] ) ) {
        $output .= "\t$link" . $args['separator'] . "\n";
    } else {
        $output .= "\t$link<br />\n";
    }
	
	}



    //function start_lvl(&$output, $depth=1, $args=array()) {  
    //    $output .= "\n<ul class=\"product_cats\">\n";  
    //}  

   // function end_lvl(&$output, $depth=0, $args=array()) {  
   //     $output .= "</ul>\n";  
    //}  
 
    function end_el(&$output, $item, $depth=0, $args=array()) {  
     $output .= "\n";  
   }  
} 

/* =============================================================================
ADVANCED SEARCH WALKER FOR CUSTOM TAXONOMIES
========================================================================== */
function count_tax_amount_search($category, $nid){ global $wpdb;

	// NO RESULTS
	if($category->count < 1){ return 0; }

	
	// CHECK FOR PRICE SEARCHES
	$priceSearch = false;
	if(isset($_GET['price1']) && $_GET['price1'] > 0){
	$priceSearch = true;
	}
	
	// DONT DO THIS FOR ALL CATEGORIES
	//if($category->category_parent == 0 && !$priceSearch ){ return $category->count; }

 	// THIS CATEGORY
	$tax[] = array('taxonomy' => $category->taxonomy, 'field'  => 'term_id', 'terms'    => $category->term_id );
 	
	// CHECK FO EXISTING CATEGORY $cancontinue = false;
	$cat = get_query_var('term'); 
	if(strlen($cat) > 1){
		$vv = get_term_by('slug', $cat, 'listing');		 
		$tax[] = array('taxonomy' => 'listing', 'field'  => 'term_id', 'terms' => array( $vv->term_id ), 'operator' => 'IN'  );
	}
	
	
	if(is_array($_GET)){
		foreach($_GET as $key => $data){
		 	
			
			if(substr($key,0,2) == "ct" && is_numeric(substr($key,-2)) ){ 
				
				$cancontinue = true;
				
				// GET DATA FROM DATABASE
				$SQL = "SELECT * FROM ".$wpdb->prefix."core_search WHERE id = ('".substr($key,-2)."') LIMIT 1";
				$fields = $wpdb->get_results($SQL, ARRAY_A);
			 	
				// APPLY TO QUERY
				$tax[] = array('taxonomy' => $fields[0]['key'], 'field'  => 'term_id', 'terms' => $data, 'operator' => 'IN'  );
		 
			
			}// end if	
			
				
		}	// end foreach
	}// end if
	

	
	/*if(!$cancontinue){
	
		// RETURN 0 OTHERWISE WILL SHOW RESULTS FOR EVERYTHING
		if(!isset($_GET['advanced_search']) ) { return 0; }
		
		
		return $category->count;
	}*/
 
 
	// BUILT ARRAY
	$args = array(
		'post_type' => 'listing_type',
		'tax_query' => array( 'relation' => 'AND', $tax ),
	);
	
	// ADD ON PRICE SEARCH
 
	if($priceSearch){
		$args = array_merge($args, array( 'meta_query' => array(
			array(
				'key' => "price",
				'type' => 'NUMERIC',
				'value' => array($_GET['price1'],$_GET['price2']),
				'compare'=> 'BETWEEN'	
			), 
		), ) );
		
	 
	}
	
	
	
	//echo "------------------";
	//print_r($args);
	//echo "------------------";
	//die(print_r($args));
	 
	$query = new WP_Query( $args );
	$count = $query->found_posts;
	
	return $count;
}


class walker_search_taxonomies extends Walker_Category {  




		function start_lvl( &$output, $depth = 0, $args = array() ) {
		
		return;
	 
		}
		function end_lvl( &$output, $depth = 0, $args = array() ) {
		
		return;
	            
	    }
 

 
function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
		
		$link = "";
		 
		
		// CHECK BOX FOR SELECTED ATTRIBUTE
	 	$checkedm = "";
		if(isset($_GET['ct'.$args['fieldid']]) && in_array($category->term_id, $_GET['ct'.$args['fieldid']]) ){
		$checkedm = "checked=checked";	
		} 
		
		
		// NEW COUNT
		$count = count_tax_amount_search($category, $args['fieldid']); 
		if($count == 0){ return; }
		  
		ob_start(); ?> 
	   
        <?php if ($args['has_children'] ) {  }else{ ?>
        
        
         <span class="pull-right grey small">(<?php echo number_format_i18n($count); ?>)</span>
            
        
        <label class="checkbox <?php echo str_replace("checked=checked", "checked", $checkedm); if($category->taxonomy =="color"){ echo trim(strtolower(str_replace(" ","",$category->name))); } ?>" >
                                                        
            <input type="checkbox" data-toggle="checkbox" name="ct<?php echo $args['fieldid']; ?>[]" value="<?php echo $category->term_id; ?>" <?php echo $checkedm; ?>>
            
        <?php echo $cat_name; ?>
      
        </label>
        <?php }
		
		$link .= ob_get_clean();
	 
   
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );
 
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    } 

   // function end_el(&$output, $item, $depth=0, $args=array()) {  
   //     $output .= "</li>\n";  
   // }  
}  






class walker_search_taxonomies_filter extends Walker_Category {  
}  






/* =============================================================================
BASIC CATEGORY WALKER
========================================================================== */

class walker_basic_categories extends Walker_Category {  

  public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
  
  global $CORE;
                /** This filter is documented in wp-includes/category-template.php */
                $cat_name = apply_filters(
                        'list_cats',
                        esc_attr( $category->name ),
                        $category
                );
				
// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
				
				
                // Don't generate an element if the category name is empty.
                if ( ! $cat_name ) {
                        return;
                }
                $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
                if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
                        /**
                         * Filter the category description for display.
                         *
                         * @since 1.2.0
                         *
                         * @param string $description Category description.
                         * @param object $category    Category object.
                         */
                        $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
                }
                $link .= '>';
                $link .= $cat_name . '</a>';
                if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
                        $link .= ' ';
                        if ( empty( $args['feed_image'] ) ) {
                                $link .= '(';
                        }
                        $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
                        if ( empty( $args['feed'] ) ) {
                                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','premiumpress' ), $cat_name ) . '"';
                        } else {
                                $alt = ' alt="' . $args['feed'] . '"';
                                $name = $args['feed'];
                                $link .= empty( $args['title'] ) ? '' : $args['title'];
                        }
                        $link .= '>';
                        if ( empty( $args['feed_image'] ) ) {
                                $link .= $name;
                        } else {
                                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
                        }
                        $link .= '</a>';
                        if ( empty( $args['feed_image'] ) ) {
                                $link .= ')';
                        }
                }
                if ( ! empty( $args['show_count'] ) ) {
                        $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
                }
                if ( 'list' == $args['style'] ) {
                        $output .= "\t<li";
                        $css_classes = array(
                                'cat-item',
                                'cat-item-' . $category->term_id,
                        );
                        if ( ! empty( $args['current_category'] ) ) {
                                // 'current_category' can be an array, so we use `get_terms()`.
                                $_current_terms = get_terms( $category->taxonomy, array(
                                        'include' => $args['current_category'],
                                        'hide_empty' => false,
                                ) );
                                foreach ( $_current_terms as $_current_term ) {
                                        if ( $category->term_id == $_current_term->term_id ) {
                                                $css_classes[] = 'current-cat';
                                        } elseif ( $category->term_id == $_current_term->parent ) {
                                                $css_classes[] = 'current-cat-parent';
                                        }
                                        while ( $_current_term->parent ) {
                                                if ( $category->term_id == $_current_term->parent ) {
                                                        $css_classes[] =  'current-cat-ancestor';
                                                        break;
                                                }
                                                $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                                        }
                                }
                        }
                        /**
                         * Filter the list of CSS classes to include with each category in the list.
                         *
                         * @since 4.2.0
                         *
                         * @see wp_list_categories()
                         *
                         * @param array  $css_classes An array of CSS classes to be applied to each list item.
                         * @param object $category    Category data object.
                         * @param int    $depth       Depth of page, used for padding.
                         * @param array  $args        An array of wp_list_categories() arguments.
                         */
                        $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
                        $output .=  ' class="' . $css_classes . '"';
                        $output .= ">$link\n";
                } elseif ( isset( $args['separator'] ) ) {
                        $output .= "\t$link" . $args['separator'] . "\n";
                } else {
                        $output .= "\t$link<br />\n";
                }
        }

 

}


/* =============================================================================
ADVANCED SEARCH WALKER
========================================================================== */

class walker_search_categories extends Walker_Category {  


	function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( 'list' != $args['style'] )
				return;
	 
			$indent = str_repeat("\t", $depth);
			
			$output .= "<div class='accordion-inner'>";
			
			$output .= "$indent<ul class='children 123'>\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	      
		  if ( 'list' != $args['style'] )
                        return;
	
	                $indent = str_repeat("\t", $depth);
	                $output .= "$indent</ul>\n";
					
					$output .= "</div>";
	 }
 

 
function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
	
	global $CORE;

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
		
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '';

		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
 		
		// ADD ON ICON IF HAS ONE
 		$icon = "";
		//if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) > 1){		
		//	$icon = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]."'></i> ";		
		//}
 
        $link .= '';
		
		// CHECK BOX
	 	$checkedm = "";
		if(isset($_GET['ct'.$args['fieldid']]) && in_array($category->term_id, $_GET['ct'.$args['fieldid']]) ){
		$checkedm = "checked=checked";	
		} 
		
		// CHECK FO EXISTING CATEGORY
		$cat = get_query_var('term');
		if(strlen($cat) > 1){
	 
			$vv = get_term_by('slug', $cat, 'listing');
			 
			if(isset($vv->term_id) && $category->term_id == $vv->term_id ){
			$checkedm = "checked=checked";	
			}
		}
			
		 // NEW COUNT
		$count =  count_tax_amount_search($category, $args['fieldid']); 
		if($count == 0){ return; }
		

		
		ob_start();
		?>
  
        
        <?php  if ($args['has_children'] && $category->parent == 0 ) { ?>
        
         <a data-toggle="collapse" data-parent="#accordion" href="#scat<?php echo $category->term_id; ?>" class="collapsed">
        
        <?php echo $icon . $cat_name; ?> 
        
        </a>
        
            <div class='accordion-body collapse <?php if($checkedm != "" || $category->parent != 0  ){ echo "in"; } ?>' id='scat<?php echo $category->term_id; ?>' data-pid="<?php echo $category->category_parent; ?>">        
        
            <ul class="children">
            
            <li>
            
             <div class="allcats"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>" ><?php echo __('All Listings','premiumpress'); ?></a></div>
        
            </li>
            
            </ul> 
     
        <?php }else{ ?>
        
            <label class="checkbox <?php echo str_replace("checked=checked", "checked", $checkedm); ?>">
                                                        
                <input type="checkbox" data-toggle="checkbox" name="ct<?php echo $args['fieldid']; ?>[]" value="<?php echo $category->term_id; ?>" <?php echo $checkedm; ?>>
                
            <?php echo $icon . $cat_name; ?>  
            
            <?php if($checkedm != ""){ ?> 
            <script>
			jQuery(document).ready(function(){ 			
				// GET PID DATA				
				var parentid = jQuery('.adscatlist .cat-item-<?php echo $category->category_parent; ?>').data( "pid" );
				//console.log(parentid+'<--');
				jQuery('#scat'+parentid).addClass('in');
			});
			</script>
            <?php } ?>
             
        
        <?php } ?>
        
    
            
            
            
          
            
            
            
            
            
            
            
            
													
	
													
		 </label>
		<?php
		
		$link .= ob_get_clean();
	 
   
        if ( 'list' == $args['style'] ) {
			
			if($category->category_parent == 0){
			$pid = $category->term_id;
			}else{
			$pid = $category->category_parent;
			}
		
            $output .= "\t<li data-pid='".$pid."' ";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );
 
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    } 

   // function end_el(&$output, $item, $depth=0, $args=array()) {  
   //     $output .= "</li>\n";  
   // }  
}  







/* =============================================================================
ADVANCED SEARCH WALKER
========================================================================== */

class walker_search_categories_filter extends Walker_Category {  


	function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( 'list' != $args['style'] )
				return;
	 
			$indent = str_repeat("\t", $depth);
			
			$output .= "<div class='accordion-inner'>";
			
			$output .= "$indent<ul class='children 123'>\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	      
		  if ( 'list' != $args['style'] )
                        return;
	
	                $indent = str_repeat("\t", $depth);
	                $output .= "$indent</ul>\n";
					
					$output .= "</div>";
	 }
 

 
function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
	
	global $CORE;

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
		
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '';

		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
 		
		// ADD ON ICON IF HAS ONE
 		$icon = "";
		//if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) > 1){		
		//	$icon = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]."'></i> ";		
		//}
 
        $link .= '';
		
		// CHECK BOX
	 	$checkedm = "";
		if(isset($_GET['ct'.$args['fieldid']]) && in_array($category->term_id, $_GET['ct'.$args['fieldid']]) ){
		$checkedm = "checked=checked";	
		} 
		
		// CHECK FO EXISTING CATEGORY
		$cat = get_query_var('term');
		if(strlen($cat) > 1){
	 
			$vv = get_term_by('slug', $cat, 'listing');
			 
			if(isset($vv->term_id) && $category->term_id == $vv->term_id ){
			$checkedm = "checked=checked";	
			}
		}
			
		 // NEW COUNT
		$count =  count_tax_amount_search($category, $args['fieldid']); 
		if($count == 0){ return; }
		

		
		ob_start();
		?>
  
        
        <?php  if ($args['has_children'] && $category->parent == 0 ) { ?>
        
        
        <label class="checkbox <?php echo str_replace("checked=checked", "checked", $checkedm); ?>">
                                                        
                <input type="checkbox" data-toggle="checkbox" name="ct<?php echo $args['fieldid']; ?>[]" value="<?php echo $category->term_id; ?>" <?php echo $checkedm; ?>>
             
             </label>
             
         <a data-toggle="collapse" data-parent="#accordion" href="#scat<?php echo $category->term_id; ?>" class="collapsed" style="margin-left:30px;">
        
        
        <?php echo $icon . $cat_name; ?> 
        
        </a>
        
            <div class='accordion-body collapse <?php if($checkedm != "" || $category->parent != 0  ){ echo "in"; } ?>' id='scat<?php echo $category->term_id; ?>' data-pid="<?php echo $category->category_parent; ?>">        
        
            
     
        <?php }else{ ?>
        
            <label class="checkbox <?php echo str_replace("checked=checked", "checked", $checkedm); ?>">
                                                        
                <input type="checkbox" data-toggle="checkbox" name="ct<?php echo $args['fieldid']; ?>[]" value="<?php echo $category->term_id; ?>" <?php echo $checkedm; ?>>
                
            <?php echo $icon . $cat_name; ?>  
            
            <?php if($checkedm != ""){ ?> 
            <script>
			jQuery(document).ready(function(){ 			
				// GET PID DATA				
				var parentid = jQuery('.adscatlist .cat-item-<?php echo $category->category_parent; ?>').data( "pid" );
				//console.log(parentid+'<--');
				jQuery('#scat'+parentid).addClass('in');
			});
			</script>
            <?php } ?>
             
        
        <?php } ?>
        
    
            
            
            
          
            
            
            
            
            
            
            
            
													
	
													
		 </label>
		<?php
		
		$link .= ob_get_clean();
	 
   
        if ( 'list' == $args['style'] ) {
			
			if($category->category_parent == 0){
			$pid = $category->term_id;
			}else{
			$pid = $category->category_parent;
			}
		
            $output .= "\t<li data-pid='".$pid."' ";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );
 
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    } 

   // function end_el(&$output, $item, $depth=0, $args=array()) {  
   //     $output .= "</li>\n";  
   // }  
}  










/* =============================================================================
D_CATEGORIES SHORTCODE WALKER
========================================================================== */

class walker_shortcode_dcats extends Walker_Category {  
 

function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) { global $CORE;
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
		
		if(!isset($args['limit_list'])){
		$args['limit_list'] = 5;
		}
		
		// DEFAULTS
		if(!isset($GLOBALS['_list'])){  $GLOBALS['_list'] = 0;	 }		
		if(!isset($GLOBALS['_sublist'])){  $GLOBALS['_sublist'] = 0; }
		
		// COUNT
		if($category->parent == 0){
			$GLOBALS['_sublist'] = 0; // RESET
			$GLOBALS['_list'] = $GLOBALS['_list']+1;
		}else{
		 	$GLOBALS['_sublist'] =  $GLOBALS['_sublist'] +1;
		}
		
		// LIMIT MAIN
		if($GLOBALS['_list'] > $args['limit']){ 
		return; 
		}
		
		// LIMIT SUBLIST
		if($GLOBALS['_sublist'] > $args['limit_list']){ return; }
	 
		// OFFSET	
		if(isset($args['offset']) && $GLOBALS['_list'] < $args['offset'] ){
			return;				 
		}
		
		
		
		
	
		
			
		
		
		
 
        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" '; 
		
		if($category->parent){
		$link .= 'class="text-dark" ';
		}else{
		$link .= 'class="text-primary" ';
		}
			
		// ADD ON ICON IF HAS ONE
 		$icon = "";
		if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]) > 2){		
			$icon = "<i class='fa text-primary ".$GLOBALS['CORE_THEME']['category_icon_small_'.$category->term_id]."'></i> ";		
		}
 
        $link .= '>';
	  
		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');
		$lang = $CORE->_language_current();
		if($catTrans != "" && $lang != "en_US"){ 
			if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
				$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
			}		
		}
		
		  if ( ! empty( $args['show_count'] ) ) {
            $link .= ' <span class="catcount float-right">' . number_format_i18n( $category->count ) . '</span>';
        }
		
        $link .= $icon . $CORE->GEO("translation_tax", array($category->term_id, $cat_name) ). '</a>';
		
 
      
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );
 
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
				
				
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
			
			if($category->parent == 0){
			 $css_classes[] = 'cat-parent';
 			}
			
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    } 

     function end_el(&$output, $item, $depth=0, $args=array()) {  
		
		if(!isset($GLOBALS['_dcats_count'])){ $GLOBALS['_dcats_count'] =0; }
		
	 	if($GLOBALS['_dcats_count'] > $args['limit']){ return; }
         $output .= "</li>\n";  
     }  
}  






/* =============================================================================
FILTER WALKERS
========================================================================== */


class walker_shortcode_filter_tax extends Walker_Category {  



function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) { global $CORE;

 
  
    	
	   if( isset($_GET['catid123']) && $_GET['catid123'] != $item->term_id && $args['child_of'] == "" ){ 
		
		// DO NOTHING
		
		 	
		}else{
		
		
		?> 
        
 <li id="filter-<?php echo $args['taxonomy']; ?><?php echo $item->term_id; ?>" data-type="<?php echo $args['taxonomy']; ?>" data-value="<?php echo $item->term_id; ?>">
    <a href="javascript:void(0);" onclick="addtaxfilter('<?php echo $item->term_id; ?>','<?php echo $args['taxonomy']; ?>');">
	<?php if($args['child_of'] != ""){ ?>
     <i class="fa fa-angle-right" aria-hidden="true"></i>
	<?php } ?>
	<?php echo esc_attr( $item->name ); ?>
    </a>
      
  </li> 
  
        <?php
		
		}
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
      return;
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) {  
		return; 
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		return;
	} 
}  






class walker_shortcode_filter_cats extends Walker_Category {  



function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) { global $CORE;
  
    	
	   if( isset($_GET['catid']) && $_GET['catid'] != $item->term_id && $args['child_of'] == "" ){ 
		
		// DO NOTHING
		
		 	
		}else{
		
		
		?> 
        
 <li id="filter-catid<?php echo $item->term_id; ?>" data-type="catid" data-value="<?php echo $item->term_id; ?>">
    <a href="javascript:void(0);" onclick="addnewfilter('<?php echo $item->term_id; ?>','<?php if($args['child_of'] == ""){ echo 'catid'; }else{ echo 'catid'; } /* removed subcat*/ ?>');">
	<?php if($args['child_of'] != ""){ ?>
     <i class="fa fa-angle-right" aria-hidden="true"></i>
	<?php } ?>
	<?php echo esc_attr( $item->name ); ?>
    </a>
      
  </li> 
  
        <?php
		
		}
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
      return;
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) {  
		return; 
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		return;
	} 
}  
 
/* =============================================================================
PAGE NAVIGATION
========================================================================== */


class ppt_admin_paginator {
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
	var $pagelink;
    var $default_ipp = 25;
 
    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 7;
        $this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
    }
 
    function paginate()
    {
		if(!isset($_GET['ipp'])){ $_GET['ipp'] = 20; }
		
        if(isset($_GET['ipp']) && $_GET['ipp'] == 'All')
        {
            $this->num_pages = ceil($this->items_total/$this->default_ipp);
            $this->items_per_page = $this->default_ipp;
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
		if(!isset($_GET['cpage'])){ $_GET['cpage'] =1; }
		
        $this->current_page = (int) $_GET['cpage']; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
 
        if($this->num_pages > 10)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"page-link\" href=\"".$this->pagelink."&cpage=$prev_page&ipp=$this->items_per_page\">Previous</a> ":"<a class=\"page-link inactive\" href=\"#\">Previous</a>";
 
            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);
 
            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);
 
            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    $this->return .= ($i == $this->current_page And $_GET['cpage'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"page-link current\" href=\"#\">$i</a> ":"<a class=\"page-link\" title=\"Go to page $i of $this->num_pages\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return;
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['cpage'] != 'All')) ? "<a class=\"page-link\" href=\"".$this->pagelink."&cpage=$next_page&ipp=$this->items_per_page\">Next</a>\n":"<a class=\"inactive\" href=\"#\">Next</a>\n";
			
            //$this->return .= ($_GET['cpage'] == 'All') ? "<a class=\"page-link current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"page-link\" href=\"".$this->pagelink."&cage=1&ipp=All\">All</a> \n";
        }
        else
        {
            for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<a class=\"page-link current\" href=\"#\">$i</a>":"<a class=\"page-link\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a>";
            }
            //$this->return .= "<a class=\"page-link\" href=\"".$this->pagelink."&cpage=1&ipp=All\">All</a> \n";
        }
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
    }
 
    function display_items_per_page()
    {
        $items = '';
        $ipp_array = array(10,25,50,100,'All');
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<span class=\"page-item\">Items per page:</span><select class=\"page-link\" onchange=\"window.location='".$this->pagelink."&cpage=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";
    }
 
    function display_jump_menu()
    {
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        return "<span class=\"page-link\">Page:</span><select class=\"page-link\" onchange=\"window.location='".$this->pagelink."&cpage='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";
    }
 
    function display_pages()
    {
        return $this->return;
    }
}
 

/* =============================================================================
COMMENTS WALKER
========================================================================== */

class ppt_comment_walker extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
 
		// constructor – wrapper for the comments list
		function __construct() { ?>
  
			 
		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
	   
			<ol class="child-comments comments-list pl-3">

		<?php }
	
		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
 
			</ol>

		<?php }

		// start_el – HTML for comment template
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
	 
			
			global  $post_authorID, $args;
			
		 	$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 
	
			 
		 	
			// GET POST AUTHOR
			if(isset($comment_ID)){
			$authorID = get_comment_author( $comment_ID );			
			$authora = get_user_by('email',$comment->comment_author_email);			
			$post_authorID = get_post_field( 'post_author', $comment_post_ID );
			}else{
			$authorID = 1;
			$authora = 1;
			$post_authorID = 1;
			}
			
			if(!isset($GLOBALS['comment-style'])){ $GLOBALS['comment-style'] = 0; }
			 
			// GET FILE
			
			echo "<li >";
			 
			_ppt_template('content-comment');	
			 
			
			
		 
		
		}

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { 
		
		echo "</li>";
		
		?>
			
        

		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>
 
		
		<?php }

}
 
/* =============================================================================
WALKER CLASSES
========================================================================== */


class Walker_CategorySelection extends Walker_Category {  


     function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) { global $CORE; 
	 
	 
	 
		// CAT PRICES
		if(!isset($GLOBALS['catprices'])){
			$GLOBALS['catprices'] = get_option('ppt_catprices'); 
			if(!is_array($GLOBALS['catprices'])){ $GLOBALS['catprices'] = array(); }
	 	}
		
 
		// CHECK FOR CAT PRICE
		$eprice = ""; $ejquery = "";
		if(isset($GLOBALS['catprices'][$item->term_id]) && is_numeric($GLOBALS['catprices'][$item->term_id])  && $GLOBALS['catprices'][$item->term_id] > 0 ){ 
				$eprice = " (+".hook_price($GLOBALS['catprices'][$item->term_id]).')'; 
				
				$ejquery = "addExtraPrice('".$GLOBALS['catprices'][$item->term_id]."','".$item->term_id."','category');";
			 
		}
 
		
		if(isset($args['parent_only']) && $args['parent_only'] == 1 && $item->parent != 0){
		
		// DO NOTHING
		
		}else{
		
		
		?> 
        
        <li data-catid="<?php echo $item->term_id; ?>" 
        
        <?php if($ejquery != ""){ ?>
        data-price="<?php echo $GLOBALS['catprices'][$item->term_id] ?>"
        <?php } ?>
        
        
         class="list-group-item catpid-<?php echo $item->parent; ?> catid-<?php echo $item->term_id; ?>" onclick="addToSelectedCats('<?php echo $item->term_id; ?>', '<?php echo $item->parent; ?>', '<?php echo esc_attr( $item->name ); ?>', '<?php echo esc_url( get_term_link( $item ) ); ?>','<?php echo $args['level']; ?>','');<?php echo $ejquery; ?>" style="cursor:pointer;">
              
            <?php echo esc_attr( $item->name ); ?>  <?php if($eprice != ""){ ?><span class="tag tag-success"><?php echo $eprice ; ?></span><?php } ?>
            
          </li>
        <?php
		
		}
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
      return;
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) {  
		return; 
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		return;
	}
	
	
}

class Walker_CategorySelectionBAK extends Walker_Category {  


     function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) { global $CORE; 
	 
		// CAT PRICES
		if(!isset($GLOBALS['catprices'])){
		$GLOBALS['catprices'] = get_option('ppt_catprices'); 
		if(!is_array($GLOBALS['catprices'])){ $GLOBALS['catprices'] = array(); }
	 	}
		
		$GLOBALS['thiscatitemid'] = $item->term_id; 
		  
		// CHECK IF WE HAVE AN ICONS
		$image = "";		
		if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) > 1){			
			$image = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]."'></i>"; 
		}		 
		
        $output .= "<li class=\"list-group-item\">";
		
		// CATEGORY VIEW
		$output .= "<a href='".esc_url( get_term_link( $item ) )."' class='pull-right hidden-xs' target='_blank'><small>".' (' . number_format( $item->count ) . ')'. " ".$CORE->_e(array('button','35'))."</small> </a>";
		
		// CHECK IF PARENT CAT IS DISABLED
		$disableParent = "";
		if(isset($GLOBALS['tpl-add']) && isset($GLOBALS['CORE_THEME']['disablecategory']) && $GLOBALS['CORE_THEME']['disablecategory'] == 1 && $item->parent == 0 ){	
		$disableParent = "disabled=disabled";
		}
		
		// CHECK FOR CAT PRICE
		$eprice = ""; $ejquery = "";
		if(isset($GLOBALS['catprices'][$item->term_id]) && is_numeric($GLOBALS['catprices'][$item->term_id]) && !in_array($item->term_id, explode(",",$args['selected']))  ){ 
				$eprice = " (+".hook_price($GLOBALS['catprices'][$item->term_id]).')'; 
				
				if($GLOBALS['CORE_THEME']['show_enhancements'] == 1){
				$ejquery = "onclick=\"listingenhancement('catb".$item->term_id."',".$GLOBALS['catprices'][$item->term_id].")\"id='catb".$item->term_id."'";
				}
		}
		
		// TEXT AND LINKS 
		if(in_array($item->term_id, explode(",",$args['selected']))){
		$output .= " <div class='tcbox'><input type='checkbox' class='tcheckbox' name='form[category][]' value='".$item->term_id."' ".$ejquery." checked=checked ".$disableParent."></div>";
		}else{
		$output .= " <div class='tcbox'><input type='checkbox' class='tcheckbox' name='form[category][]' value='".$item->term_id."' ".$ejquery." ".$disableParent."></div>";
		}		
		
		// DISPLAY
		$output .= "<span class='twrap'> ".$image." <strong>".esc_attr( $item->name )."</strong> ".$eprice." </span>";	 
		
		// FLAG
		$GLOBALS['lastparent_id'] = $item->term_id;
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
        $output .= "</li>\n";  
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) { global $item;
 	 
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);		
		
		// HIDE CATS
		$output .= '<a href="javascript:void(0);" class="label label-default hidesub'. $GLOBALS['thiscatitemid'].'" style="display:none;"  
		onclick="jQuery(\'.hidesub'. $GLOBALS['thiscatitemid'].'\').hide(); jQuery(\'.showsub'. $GLOBALS['thiscatitemid'].'\').show(); jQuery(\'.subcats_'.$GLOBALS['thiscatitemid'].'\').hide();"> <i class="fa fa-chevron-up"></i> </a>';
		
		$output .= ' <a href="javascript:void(0);" class="label label-warning showsub'. $GLOBALS['thiscatitemid'].'"  
		onclick="jQuery(\'.hidesub'. $GLOBALS['thiscatitemid'].'\').show(); jQuery(\'.showsub'. $GLOBALS['thiscatitemid'].'\').hide(); jQuery(\'.subcats_'.$GLOBALS['thiscatitemid'].'\').show();"><i class="fa fa-chevron-down"></i></a> ';
		
		$output .= "<div  class='subcats_".$GLOBALS['thiscatitemid']."' style='display:none;'>";		
	
		// WRAPPER
		$output .= "<div style='max-height:600px; margin:0px; margin-top:10px; padding:0px; overflow: scroll;padding-right:10px;padding-bottom:10px;border-top:1px solid #ddd;padding-bottom:5px;'>";
 		
		// LIST
		$output .= "$indent<ul class='children' style='margin:0px;padding:0px; margin-top:10px; background:#fafafa;'>\n";
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div></div>\n";
	}
	
	
}

/* =============================================================================
  [FRAMEWORK] BOOTSTRAP MENU WALKER FOR WORDPRESS
   ========================================================================== */
class Bootstrap_Walker1 extends Walker_Nav_Menu {     
     
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth = 0, $args = array()) 
        {
		
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
			if(!isset($GLOBALS['flasg_smalldevicemenubar'])){ $mname = "dropdown-menu"; } else { $mname = "smalldevice_dropmenu"; }
			
				if ( ( $depth == 0 || $depth == 1 ) ) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
					$output .= "\n{$tabs}<ul class=\"".$mname."\">\n"; 
				} else { 
					$output .= "\n{$tabs}<ul>\n"; 
				}
			 
            return;
        } 
         
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth = 0, $args = array())  
        {
		
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
                 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul ><!--endchild-->\n";  // // KEEP THIS SPACE AFTER UL!!!! 
            return; 
        }
                 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)  
        {    
            global $wp_query;
			 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 

            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
			
            if ($item->hasChildren) { 
                $classes[] = 'dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            }else{			
			$classes[] = ''; 
			}			

            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<li ' . $value . $class_names .'>';  //id="menu-item-'. $item->ID . '"    
			         
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
			
			
			// DESCRIPTION USED FOR DISPLAY
			$description = "";
		 	//if(isset($item->description) && strpos($item->description,"fa-") === false){
			//$description = '<span class="desc">'.  esc_attr( $item->description ) .'</span>';
			//}
			 
			
			$icon = "";
			//if(isset($item->description) && strpos($item->description,"fa-") !== false){
			//$icon = "<i class='".$item->description."'></i> ";
			//}
			 
			
            $item_output = $args->before; 
			 
			
                    
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0 && !isset($GLOBALS['flasg_smalldevicemenubar']) ) { 
                $item_output .= '<a '. $attributes .' class="dropdown-toggle txt" data-hover="dropdown" data-delay="500" data-close-others="false">';	 //  data-toggle="dropdown"			
				 
            } else { 
                $item_output .= '<a'. $attributes .' class="txt">'.$icon; 
            }
	  		$iconpack = false;	
			
			// ADD ON CATEGORY ICON
			 
			$item_output .= $args->link_before . apply_filters( 'the_title', "<span>".$item->title."</span>", $item->ID ) . $args->link_after; 
			 
		 
            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
				 
				$item_output .= $description. ' </a>';  //<b class="caret"></b> 				 
                
            } else { 
                $item_output .= $description. '</a>'; 
            } 

            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
        
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth  = 0, $args = array() )
        {
            $output .= '</li>'; 
            return;
        } 
         
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 

            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
}

/* =============================================================================
  [FRAMEWORK] BOOTSTRAP MENU WALKER FOR WORDPRESS
   ========================================================================== */
class Bootstrap_Walker extends Walker_Nav_Menu {     
     
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth = 0, $args = array()) 
        {
		
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
			if(!isset($GLOBALS['flasg_smalldevicemenubar'])){ $mname = "dropdown-menu"; } else { $mname = "smalldevice_dropmenu"; }
			
				if ( ( $depth == 0 || $depth == 1 ) ) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
					$output .= "\n{$tabs}<ul class=\"".$mname."\">\n"; 
				} else { 
					$output .= "\n{$tabs}<ul>\n"; 
				}
			 
            return;
        } 
         
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth = 0, $args = array())  
        {
		
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
                 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul ><!--endchild-->\n"; // KEEP THIS SPACE AFTER UL!!!! 
            return; 
        }
                 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)  
        {    
            global $wp_query;
			 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 

            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
			
            if ($item->hasChildren) { 
                $classes[] = 'dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            }else{
			
			$classes[] = ''; 
			}
			

            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<li ' . $value . $class_names .'>';  //id="menu-item-'. $item->ID . '"    
			         
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
			
			
			// DESCRIPTION USED FOR DISPLAY
			$description = "";
		 	//if(isset($item->description) && strpos($item->description,"fa-") === false){
			//$description = '<span class="desc">'.  esc_attr( $item->description ) .'</span>';
			//}
			 
			
			$icon = "";
			//if(isset($item->description) && strpos($item->description,"fa-") !== false){
			//$icon = "<i class='".$item->description."'></i> ";
			//}
			 
			
            $item_output = $args->before; 
			 
			
                    
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0 && !isset($GLOBALS['flasg_smalldevicemenubar']) ) { 
                $item_output .= '<a '. $attributes .' class="dropdown-toggle txt" data-hover="dropdown" data-delay="500" data-close-others="false">';	 //  data-toggle="dropdown"			
				 
            } else { 
                $item_output .= '<a'. $attributes .' class="txt">'.$icon; 
            }
	  		$iconpack = false;	
			
			// ADD ON CATEGORY ICON
			 
			$item_output .= $args->link_before . apply_filters( 'the_title', "<span>".$item->title."</span>", $item->ID ) . $args->link_after; 
			 
		 
            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
				 
				$item_output .= $description. ' </a>';  //<b class="caret"></b> 				 
                
            } else { 
                $item_output .= $description. '</a>'; 
            } 

            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
        
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth  = 0, $args = array() )
        {
            $output .= '</li>'; 
            return;
        } 
         
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 

            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
}


/* =============================================================================
  [FRAMEWORK] BOOTSTRAP MENU WALKER FOR WORDPRESS
   ========================================================================== */
 
class Bootstrap_Walker_Mobile extends Walker_Nav_Menu {     
     
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth = 0, $args = array()) 
        {
		
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
		 
				if ( ( $depth == 0 || $depth == 1 ) ) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
					$output .= "\n{$tabs}<ul>\n"; 
				} else { 
					$output .= "\n{$tabs}<ul >\n"; 
				}
			 
            return;
        } 
         
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth = 0, $args = array())  
        {
		
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
                 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul ><!--endchild-->\n"; // KEEP THIS SPACE AFTER UL!!!! 
            return; 
        }
                 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)  
        {    
            global $wp_query;
			 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 

            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
			
            if ($item->hasChildren) { 
                $classes[] = 'dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            }else{
			
			$classes[] = ''; 
			}
			

            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<div ' . $value . $class_names .'>';  //id="menu-item-'. $item->ID . '"    
			         
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
			
			
			// DESCRIPTION USED FOR DISPLAY
			$description = "";
 			
			$icon = "";
	 			
            $item_output = $args->before; 
                    
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0 && !isset($GLOBALS['flasg_smalldevicemenubar']) ) { 
                $item_output .= '<a '. $attributes .'>';	 //  data-toggle="dropdown"			
				 
            } else { 
                $item_output .= '<a'. $attributes .' class="txt"><em><i class="fa fa-angle-right"></i> '.$icon; 
            }
	  		$iconpack = false;	
			
			// ADD ON CATEGORY ICON
			 
			$item_output .= $args->link_before . apply_filters( 'the_title', "".$item->title."", $item->ID ) . $args->link_after; 
			 
		 
            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
				 
				$item_output .= $description. ' </a>';  //<b class="caret"></b> 				 
                
            } else { 
                $item_output .= $description. '</em></a>'; 
            } 

            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
        
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth  = 0, $args = array() )
        {
            $output .= '</div>'; 
            return;
        } 
         
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 

            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
}
 

?>