<?php
// Include Common Functions
include_once('functions.php');

add_action('acf/include_field_types', 'villenoir_include_field_types_google_font_selector');
function villenoir_include_field_types_google_font_selector() {
	include_once('acf-google_font_selector-v5.php');
}