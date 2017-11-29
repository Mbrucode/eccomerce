<?php
function gg_villenoir_nav_custom_script($hook) {
    if ( 'nav-menus.php' != $hook ) {
        return;
    }
    wp_enqueue_style( 'gg-admin-nav-style', get_template_directory_uri() . '/lib/nav/nav-admin-style.css', false, '1.0.0' );
    wp_enqueue_script('gg-admin-nav', get_template_directory_uri() . '/lib/nav/nav-admin.js', array('jquery'), VILLENOIR_THEMEVERSION, true);
}
add_action( 'admin_enqueue_scripts', 'gg_villenoir_nav_custom_script' );

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'gg_villenoir_add_custom_nav_fields' );

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'gg_villenoir_update_custom_nav_fields', 10, 3 );

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'gg_villenoir_edit_walker', 10, 2 );


function gg_villenoir_add_custom_nav_fields( $menu_item ) {
    $menu_item->menu_type       = get_post_meta( $menu_item->ID, '_menu_item_menu_type', true );
    $menu_item->menu_columns    = get_post_meta( $menu_item->ID, '_menu_item_menu_columns', true );
    $menu_item->menu_fullscreen = get_post_meta( $menu_item->ID, '_menu_item_menu_fullscreen', true );
    $menu_item->menu_extrahtml  = get_post_meta( $menu_item->ID, '_menu_item_menu_extrahtml', true );
    $menu_item->menu_hidelabel  = get_post_meta( $menu_item->ID, '_menu_item_menu_hidelabel', true );
    return $menu_item;
   
}

/**
 * Save menu custom fields
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function gg_villenoir_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

        $check = array('menu_type', 'menu_columns', 'menu_fullscreen', 'menu_extrahtml', 'menu_hidelabel');
            
        foreach ( $check as $key ){
            if(!isset($_POST['menu-item-'.$key][$menu_item_db_id]))
            {
                $_POST['menu-item-'.$key][$menu_item_db_id] = "";
            }
            
            $value = $_POST['menu-item-'.$key][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
        }
}

/**
 * Define and include a new Walker edit 
 */
function gg_villenoir_edit_walker($walker,$menu_id) {
    return 'gg_villenoir_Walker_Nav_Menu_Edit_Custom';
}
include_once('edit_custom_walker.php');

/**
 * Include menu limit detector
*/

include_once('menu-limit-detector.php');

class villenoir_navwalker extends Walker_Nav_Menu {

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu noclose\">\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        /**
         * Dividers, Headers or Disabled
         * =============================
         * Determine whether the item is a Divider, Header, Disabled or regular
         * menu item. To prevent errors we use the strcasecmp() function to so a
         * comparison that is not case sensitive. The strcasecmp() function returns
         * a 0 if the strings are equal.
         */
        if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth > 0 ) {
            $output .= $indent . '<li role="presentation" class="divider">';
        } else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth > 0 ) {
            $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
        } else {

            $class_names = $value = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            if($args->has_children && $depth === 0) { 
                $class_names .= ' dropdown';
            } elseif($args->has_children && $depth > 0) {
                $class_names .= ' dropdown-submenu';
            }

            //Megamenu classes
            if($item->menu_type == "wide") {
                if($args->has_children && $depth === 0) {
                    $class_names .=' is-megamenu';
                    $class_names .=' cols-no-'.$item->menu_columns;
                    $class_names .=' '.$item->menu_fullscreen;
                }
            }

            if ( in_array( 'current-menu-item', $classes ) )
                $class_names .= ' active';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $atts = array();
            $atts['title']  = ! empty( $item->title )   ? $item->title  : '';
            $atts['target'] = ! empty( $item->target )  ? $item->target : '';
            $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';

            //Add description + extra html
            if($depth !== 0) {
                //Menu description    
                $description  = ! empty( $item->description ) ? '<span>'.esc_html( $item->description ).'</span>' : '';
                
                //Code for labelhide
                $atts['class']          = $item->menu_hidelabel;
                //Code for extra html field
                $extrahtml = '';
                //Arrays of keys to search for
                $extrahtml_keys = array('image','video','carousel');

                if ( ! empty( $item->menu_extrahtml ) ) {
                    if ( villenoir_strpos_array($item->menu_extrahtml, $extrahtml_keys) === 0 ) {
                        //Construct the array
                        foreach (preg_split ('/$\R?^/m', $item->menu_extrahtml) as $pair) {
                            list ($k,$v) = array_pad(explode (':',$pair,2), 2, null);
                            $extrahtml_arr[trim($k)] = $v;
                            //unset empty values
                            if( empty( $v ) ) {
                               unset( $extrahtml_arr[$k] );
                            }
                        }
                        //Array Logic
                        if (! empty( $extrahtml_arr )) {
                            foreach ($extrahtml_arr as $key => $arr_value) {
                                //Add the array value to class
                                $class_names .= ' '.$key;
                                //Loop though keys and display accordingly
                                switch ($key) {
                                    case 'image':
                                        if ($arr_value) {
                                            //If menu item has href wrap it around the image
                                            if ($item->url != '') {
                                                $extrahtml .= ' <a href="'.esc_url($item->url).'"><img src="'.$arr_value.'" alt="" /></a>';
                                            } else {
                                                $extrahtml .= ' <img src="'.$arr_value.'" alt="" />';
                                            }
                                            
                                        }
                                        break;
                                    case 'video':
                                        if ($arr_value)
                                            $extrahtml .= ' '.wp_oembed_get($arr_value);
                                        break;
                                }
                                
                            }
                        }
                    } else {
                        $extrahtml .= $item->menu_extrahtml; //print everything
                    } //end if for strpos check   
                }//end if for extrahtml  

                $extrahtmlcode  = ! empty( $item->menu_extrahtml ) ? '<div class="gg-extra-html">'.$extrahtml.'</div>' : '';
            } else {
                $description = $append = $prepend = $extrahtmlcode = ""; 
            }

            //construct the li
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            $output .= $indent . '<li ' . $id . $value . $class_names .'>';

            // If item has_children add atts to a.
            if ( $args->has_children ) {
                $atts['href'] = ! empty( $item->url ) ? $item->url : '';
                $atts['data-toggle']    = 'dropdown';
                $atts['class']          = 'dropdown-toggle';
                $atts['aria-haspopup']  = 'true';
            } else {
                $atts['href'] = ! empty( $item->url ) ? $item->url : '';
            }

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;

            // Font Awesome icons
            if ( ! empty( $item->attr_title ) )
                $item_output .= '<a'. $attributes .'><i class="' . esc_attr( $item->attr_title ) . '"></i>&nbsp;';
            else
                $item_output .= '<a'. $attributes .'>'; 

            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $description . $args->link_after;
            $item_output .= '</a>'. $extrahtmlcode;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback( $args ) {
        if ( current_user_can( 'manage_options' ) ) {

            extract( $args );

            $fb_output = null;

            if ( $container ) {
                $fb_output = '<' . $container;

                if ( $container_id )
                    $fb_output .= ' id="' . $container_id . '"';

                if ( $container_class )
                    $fb_output .= ' class="' . $container_class . '"';

                $fb_output .= '>';
            }

            $fb_output .= '<ul';

            if ( $menu_id )
                $fb_output .= ' id="' . $menu_id . '"';

            if ( $menu_class )
                $fb_output .= ' class="' . $menu_class . '"';

            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
            $fb_output .= '</ul>';

            if ( $container )
                $fb_output .= '</' . $container . '>';

            echo wp_kses_post($fb_output);
        }
    }
}