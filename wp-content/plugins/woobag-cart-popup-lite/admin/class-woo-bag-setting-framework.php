<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Handle Options Functionality
 *
 * @class 		Woo_Bag_Setting_framework
 * @version		1.0.0
 * @package		Woo_Bag/Classes/
 * @category            Class
 * @author 		Gatelogixs
 */
if (!class_exists('Woo_Bag_Setting_framework')) :

    /**
     * Woo_Bag_Setting_framework class
     */
    class Woo_Bag_Setting_framework {

        /**
         * @access private
         * @var array
         */
        private $settings;

        /**
         * @access private
         * @var string
         */
        private $option_group;

        /**
         * @access protected
         * @var array
         */
        protected $setting_defaults = array(
            'id' => 'default_field',
            'title' => 'Default Field',
            'desc' => '',
            'std' => '',
            'type' => 'text',
            'placeholder' => '',
            'choices' => array(),
            'class' => '',
            'help' => '',
            'select_all_text' => '',
            'front_end' => '',
            'has_dependent' => '',
            'dependent_id' => '',
            'dependent_condation' => '',
            'dependent_from' => '',
            'change_property' => '',
            'change_property_id' => '',
            'max' => '',
            'min' => '',
        );

        /**
         * Constructor
         *
         * @param string path to settings file
         * @param string optional "option_group" override
         */
        public function __construct($settings_file, $option_group = '') {
            if (!is_file($settings_file)):
                return;
            endif;
            require_once( $settings_file );

            $this->option_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));
            if ($option_group):
                $this->option_group = $option_group;
            endif;

            $this->settings = array();
            $this->settings = apply_filters('wb_register_settings', $this->settings);
            if (!is_array($this->settings)) :
                return new WP_Error('broke', __('WooBag settings must be an array'));
            endif;

            add_action('admin_init', array(&$this, 'wb_register_setting'));
            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
        }

        /**
         * Get the option group for this instance
         *
         * @return string the "option_group"
         */
        public function get_option_group() {
            return $this->option_group;
        }

        /**
         * Registers the internal WordPress settings
         */
        public function wb_register_setting() {
            register_setting($this->option_group, $this->option_group, array(&$this, 'settings_validate'));
            $this->process_settings();
        }

        /**
         * Enqueue scripts and styles
         */
        public function admin_enqueue_scripts() {
            wp_enqueue_style('farbtastic');
            wp_enqueue_style('thickbox');

            wp_enqueue_script('jquery');
            wp_enqueue_script('farbtastic');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }

        /**
         * Adds a filter for settings validation
         *
         * @param array the un-validated settings
         * @return array the validated settings
         */
        public function settings_validate($input) {
            return apply_filters($this->option_group . '_settings_validate', $input);
        }

        /**
         * Displays the "section_description" if specified in $this->settings
         *
         * @param array callback args from add_settings_section()
         */
        public function section_intro($args) {
            if (!empty($this->settings)) {
                foreach ($this->settings as $section) {
                    if ($section['section_id'] == $args['id']) {
                        if (isset($section['section_description']) && $section['section_description'])
                            echo '<p>' . $section['section_description'] . '</p>';
                        break;
                    }
                }
            }
        }

        /**
         * Processes $this->settings and adds the sections and fields via the WordPress settings API
         */
        private function process_settings() {
            if (!empty($this->settings)) {
                usort($this->settings, array(&$this, 'sort_array'));
                foreach ($this->settings as $section) {
                    if (isset($section['section_id']) && $section['section_id'] && isset($section['section_title'])) {
                        add_settings_section($section['section_id'], $section['section_title'], array(&$this, 'section_intro'), $this->option_group);
                        if (isset($section['fields']) && is_array($section['fields']) && !empty($section['fields'])) {
                            foreach ($section['fields'] as $field) {
                                if (isset($field['id']) && $field['id'] && isset($field['title'])) {
                                    add_settings_field($field['id'], $field['title'], array(&$this, 'generate_setting'), $this->option_group, $section['section_id'], array('section' => $section, 'field' => $field));
                                }
                            }
                        }
                    }
                }
            }
        }

        /**
         * Usort callback. Sorts $this->settings by "section_order"
         *
         * @param mixed section order a
         * @param mixed section order b
         * @return int order
         */
        public function sort_array($a, $b) {
            return $a['section_order'] > $b['section_order'];
        }

        /**
         * Generates the HTML output of the settings fields
         *
         * @param array callback args from add_settings_field()
         */
        public function generate_setting($args) {
            $section = $args['section'];
            $this->setting_defaults = apply_filters('wb_defaults', $this->setting_defaults);
            extract(wp_parse_args($args['field'], $this->setting_defaults));

            $options = get_option($this->option_group);
            $el_id = $this->option_group . '_' . $section['section_id'] . '_' . $id;
            $val = (isset($options[$el_id])) ? $options[$el_id] : $std;
            if (!$select_all_text):
                $select_all_text = 'Select All';
            endif;
            do_action('wb_before_field');
            do_action('wb_before_field_' . $el_id);
            $wb_default_id = $el_id;
            switch ($type) {
                case 'text':
                    $val = esc_attr(stripslashes($val));
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<input type="text" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'value="' . $val . '" '
                    . 'placeholder="' . $placeholder . '" '
                    . 'wb_field_type="text" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . 'class="regular-text ' . $class . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/>';
                    if ($help):
                        echo '<span class="wb_setting_single_input_help input-group-addon">' . __($help, 'woo-bag') . '</span>';
                    endif;
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'number':
                    $val = esc_attr(stripslashes($val));
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<input type="number" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'value="' . $val . '" '
                    . 'placeholder="' . $placeholder . '" '
                    . 'wb_field_type="number" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_change_property="' . $change_property . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . 'wb_help="' . $help . '" '
                    . 'max="' . $max . '" '
                    . 'min="' . $min . '" '
                    . 'class="regular-text ' . $class . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/>';
                    if ($help):
                        echo '<span class="wb_setting_single_input_help input-group-addon">' . __($help, 'woo-bag') . '</span>';
                    endif;
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'textarea':
                    $val = esc_html(stripslashes($val));
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<textarea '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'placeholder="' . $placeholder . '" '
                    . 'rows="5" '
                    . 'cols="60" '
                    . 'class="' . $class . '"'
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '>' . $val . '</textarea>';
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'select':
                    $val = esc_html(esc_attr($val));
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<select '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'class="' . $class . '" '
                    . 'wb_field_type="select" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_change_property="' . $change_property . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . 'wb_help="' . $help . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '>';
                    foreach ($choices as $ckey => $cval) :
                        echo '<option value="' . $ckey . '"' . (($ckey == $val) ? ' selected="selected"' : '') . '>' . $cval . '</option>';
                    endforeach;
                    echo '</select>';
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    if ($help):
                        echo '<span class="wb_setting_single_input_help input-group-addon">' . __($help, 'woo-bag') . '</span>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'radio':
                    $val = esc_html(esc_attr($val));
                    echo '<div class="wb_setting_single_input input-group">';
                    foreach ($choices as $ckey => $cval) :
                        echo '<label>'
                        . '<input '
                        . 'type="radio" '
                        . 'name="' . $this->option_group . '[' . $el_id . ']" '
                        . 'id="' . $wb_default_id . '_' . $ckey . '" '
                        . 'value="' . $ckey . '" '
                        . 'class="' . $class . '" '
                        . 'wb_field_type="radio" '
                        . 'wb_change_property_id="' . $change_property_id . '" '
                        . 'wb_change_property="' . $change_property . '" '
                        . 'wb_field_id="' . $wb_default_id . '" '
                        . (($ckey == $val) ? ' checked="checked"' : '') . ' '
                        . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                        . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                        . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                        . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                        . '/> ' . $cval . '</label>';
                    endforeach;
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'checkbox':
                    $val = esc_attr(stripslashes($val));
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<input '
                    . 'type="hidden" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'value="0" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/>';
                    echo '<label>'
                    . '<input type="checkbox" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'value="1" '
                    . 'class="' . $class . '"'
                    . (($val) ? ' ' . 'checked="checked"' : '') . ' '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/> ' . __($desc, 'woo-bag') . '</label>';
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'checkboxes':
                    $wb_count = 0;
                    $wb_value = $this->option_group . '_' . $el_id . '_' . $val;
                    echo '<div class="wb_setting_single_input input-group ' . $wb_value . '">';
                    foreach ($choices as $ckey => $cval) :
                        $wb_count++;
                        $val = '';
                        if (isset($options[$el_id . '_' . $ckey])):
                            $val = $options[$el_id . '_' . $ckey];
                        elseif (is_array($std) && in_array($ckey, $std)):
                            $val = $ckey;
                        endif;
                        $val = esc_html(esc_attr($val));
                        echo '<input '
                        . 'type="hidden" '
                        . 'name="' . $this->option_group . '[' . $el_id . '_' . $ckey . ']" '
                        . 'value="0" '
                        . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                        . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                        . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                        . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                        . '/>';
                        echo '<label>'
                        . '<input '
                        . 'type="checkbox" '
                        . 'name="' . $this->option_group . '[' . $el_id . '_' . $ckey . ']" '
                        . 'id="' . $wb_default_id . '_' . $ckey . '" '
                        . 'value="' . $ckey . '" '
                        . 'class="' . $class . ' ' . $wb_default_id . ' "'
                        . (($ckey == $val) ? ' checked="checked"' : '') . ' '
                        . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                        . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                        . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                        . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                        . '/> ' . $cval . '</label>';

                        if ($cval === end($choices) && $wb_count != 1) :
                            echo '<input type="hidden" name="' . $this->option_group . '[' . $el_id . '_selectall]" value="0" />';
                            echo '<label class="wb_check_all_label">'
                            . '<input type="checkbox" '
                            . 'name="' . $this->option_group . '[' . $el_id . '_selectall]" '
                            . 'id="' . $wb_value . '"'
                            . 'value="select" '
                            . 'class="wb_check_all ' . $class . ' "'
                            . (($ckey == $val) ? ' checked="checked"' : '') . ' /> ' . $select_all_text . '</label>';
                        endif;
                    endforeach;
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'color':
                    $val = esc_attr(stripslashes($val));
                    echo '<div class="wb_setting_single_input input-group wb_setting_color_input_field"><div>';
                    echo '<input '
                    . 'type="text" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'value="' . $val . '" '
                    . 'class="' . $class . '" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_change_property="' . $change_property . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . 'wb_field_type="color" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/>';
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'file':
                    $val = esc_attr($val);
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<input type="text" '
                    . 'name="' . $this->option_group . '[' . $el_id . ']" '
                    . 'id="' . $wb_default_id . '" '
                    . 'value="' . $val . '" '
                    . 'class="regular-text ' . $class . '" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_change_property="' . $change_property . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/> ';
                    echo '<input '
                    . 'type="button" '
                    . 'class="button wpsf-browse wb_image_upload_button" '
                    . 'wb_field_type="wb_image_upload_button" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . 'id="' . $wb_default_id . '_button" '
                    . 'value="Browse" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/>';
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'image_position':
                    $values = (isset($options[$el_id . '_x'])) ? $options[$el_id . '_x'] : $std;
                    $val = esc_attr($values);
                    echo '<div class="wb_setting_single_input input-group">'
                    . '<input type="hidden" '
                    . 'name="' . $this->option_group . '[' . $el_id . '_x]"'
                    . 'id="' . $el_id . '_x" '
                    . 'value="' . $val . '" '
                    . 'class="wb_x_axis ' . $class . '" '
                    . 'wb_change_property_id="' . $change_property_id . '" '
                    . 'wb_change_property="' . $change_property . '" '
                    . 'wb_field_id="' . $wb_default_id . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/> ';
                    $values = (isset($options[$el_id . '_y'])) ? $options[$el_id . '_y'] : $std;
                    $val = esc_attr($values);
                    echo '<input type="hidden" '
                    . 'name="' . $this->option_group . '[' . $el_id . '_y]"'
                    . 'id="' . $el_id . '_y" '
                    . 'value="' . $val . '" '
                    . 'class="wb_y_axis ' . $class . '" '
                    . (($has_dependent) ? ' has_dependent="' . $has_dependent . '"' : '') . ' '
                    . (($dependent_id) ? ' dependent_id="' . $dependent_id . '"' : '') . ' '
                    . (($dependent_condation) ? ' dependent_condation="' . $dependent_condation . '"' : '') . ' '
                    . (($dependent_from) ? ' dependent_from="' . $dependent_from . '"' : '') . ' '
                    . '/> ';
                    echo '<div class="wb_image_position_wrapper wb_image_position_wrapper_' . $el_id . '">';
                    echo '<i id="' . $el_id . '" image_arrow="left" class="fa fa-arrow-circle-left" ></i>';
                    echo '<i id="' . $el_id . '" image_arrow="up" class="fa fa-arrow-circle-up" ></i>';
                    echo '<i id="' . $el_id . '" image_arrow="down" class="fa fa-arrow-circle-down"></i>';
                    echo '<i id="' . $el_id . '" image_arrow="right" class="fa fa-arrow-circle-right" ></i>';
                    echo '<i id="' . $el_id . '" image_arrow="refresh" class="fa fa-refresh description" data-container="body" data-original-title="Reset" data-placement="left" data-toggle="tooltip"></i>';
                    echo '</div>';
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'editor':
                    echo '<div class="wb_setting_single_input input-group">';
                    wp_editor($val, $el_id, array('textarea_name' => $this->option_group . '[' . $el_id . ']'));
                    if ($desc):
                        echo '<div class="wb_setting_help_text"><a class="description" data-trigger="manual" data-placement="right" data-toggle="tooltip" data-container="body" data-original-title="' . __($desc, 'woo-bag') . '"><i class="fa fa-info-circle"></i></a></div>';
                    endif;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'custom':
                    echo '<div class="wb_setting_single_input input-group">';
                    echo $std;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
                case 'hidden':
                    echo '<div class="wb_setting_single_input input-group wb_hidden_field">';
                    echo $std;
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;

                default:
                    echo '<div class="wb_setting_single_input input-group">';
                    echo '</div>';
                    if ($front_end):
                        echo '<span class="wb_setting_single_input_front_end">' . __($front_end, 'woo-bag') . '</span>';
                    endif;
                    break;
            }
            do_action('wb_after_field');
            do_action('wb_after_field_' . $el_id);
        }

        /**
         * Output the settings form
         */
        public function settings() {
            do_action('wb_before_settings');
            ?>
            <div class="wb_setting_options_wrapper col-md-12 nopadding">
                <form action="options.php" method="post" id="wb_setting_form" >
                    <div class="form-group col-md-12 nopadding">
                        <?php do_action('wb_before_settings_fields'); ?>
                        <div class="wb_settings col-md-12 nopadding">
                            <div class="col-md-12 nopadding">
                                <?php
                                settings_fields($this->option_group);
                                wb_do_settings_sections($this->option_group);
                                ?>
                            </div>
                            <div class="submit wb_submit_form col-md-12 wb_padding">
                                <div class="wb_setting_form_buttons">
                                    <input type = "submit" class = "button-primary woo_bag_submit_button wb_grey" id ="woo_bag_submit_button" value = "<?php _e('Save Changes', 'woo-bag'); ?>" />
                                </div>
                            </div>
                            <div class="wb_setting_spinner_overlay"></div>
                            <div class="wb_setting_spinner_wrapper">
                                <div class="wb_setting_spinner">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                                <div class="wb_setting_message"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            do_action('wb_after_settings');
        }

    }

    endif;

if (!function_exists('wb_get_option_group')) :

    /**
     * Converts the settings file name to option group id
     *
     * @param string settings file
     * @return string option group id
     */
    function wb_get_option_group($settings_file) {
        $option_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));
        return $option_group;
    }

endif;

if (!function_exists('wb_get_all_setting')) :

    /**
     * Get the settings from a settings file/option group
     *
     * @param string option group id
     * @return array settings
     */
    function wb_get_all_setting($option_group) {
        return get_option($option_group);
    }

endif;

if (!function_exists('wb_get_single_setting')) :

    /**
     * Get a setting from an option group
     *
     * @param string option group id
     * @param string section id
     * @param string field id
     * @return mixed setting or false if no setting exists
     */
    function wb_get_single_setting($option_group, $section_id, $field_id) {
        $options = get_option($option_group);
        $wb_template_name_part = WB()->wb_get_setting_name();
        if (isset($options[$wb_template_name_part . '_' . $section_id . '_' . $field_id])) {
            return $options[$wb_template_name_part . '_' . $section_id . '_' . $field_id];
        }
        return false;
    }

endif;

if (!function_exists('wb_delete_settings')) :

    /**
     * Delete all the saved settings from a settings file/option group
     *
     * @param string option group id
     */
    function wb_delete_settings($option_group) {
        delete_option($option_group);
    }



endif;
