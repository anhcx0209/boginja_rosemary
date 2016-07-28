<?php
/**
 * RoseMary Framework: Theme options custom fields
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_options_custom_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_options_custom_theme_setup' );
	function rosemary_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'rosemary_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'rosemary_options_custom_load_scripts' ) ) {
	//add_action("admin_enqueue_scripts", 'rosemary_options_custom_load_scripts');
	function rosemary_options_custom_load_scripts() {
		rosemary_enqueue_script( 'rosemary-options-custom-script',	rosemary_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
function rosemary_show_custom_field($id, $field, $value) {
	$output = '';
	switch ($field['type']) {
		case 'reviews':
			$output .= '<div class="reviews_block">' . trim(rosemary_reviews_get_markup($field, $value, true)) . '</div>';
			break;

		case 'mediamanager':
			wp_enqueue_media( );
			$output .= '<a id="'.esc_attr($id).'" class="button mediamanager"
				data-param="' . esc_attr($id) . '"
				data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'rosemary') : esc_html__( 'Choose Image', 'rosemary')).'"
				data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'rosemary') : esc_html__( 'Choose Image', 'rosemary')).'"
				data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
				data-linked-field="'.esc_attr($field['media_field_id']).'"
				onclick="rosemary_show_media_manager(this); return false;"
				>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'rosemary') : esc_html__( 'Choose Image', 'rosemary')) . '</a>';
			break;
	}
	return apply_filters('rosemary_filter_show_custom_field', $output, $id, $field, $value);
}
?>