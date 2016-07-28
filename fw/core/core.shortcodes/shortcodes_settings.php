<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'rosemary_shortcodes_is_used' ) ) {
	function rosemary_shortcodes_is_used() {
		return rosemary_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| (function_exists('rosemary_vc_is_frontend') && rosemary_vc_is_frontend());		// VC Frontend editor mode														// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'rosemary_shortcodes_width' ) ) {
	function rosemary_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", "rosemary"),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'rosemary_shortcodes_height' ) ) {
	function rosemary_shortcodes_height($h='') {
		global $ROSEMARY_GLOBALS;
		return array(
			"title" => esc_html__("Height", "rosemary"),
			"desc" => wp_kses( __("Width (in pixels or percent) and height (only in pixels) of element", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"value" => $h,
			"type" => "text"
		);
	}
}

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_shortcodes_settings_theme_setup' ) ) {
//	if ( rosemary_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'rosemary_action_before_init_theme', 'rosemary_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'rosemary_action_after_init_theme', 'rosemary_shortcodes_settings_theme_setup' );
	function rosemary_shortcodes_settings_theme_setup() {
		if (rosemary_shortcodes_is_used()) {
			global $ROSEMARY_GLOBALS;

			// Sort templates alphabetically
			ksort($ROSEMARY_GLOBALS['registered_templates']);

			// Prepare arrays 
			$ROSEMARY_GLOBALS['sc_params'] = array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", "rosemary"),
					"desc" => wp_kses( __("ID for current element", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", "rosemary"),
					"desc" => wp_kses( __("CSS class for current element (optional)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", "rosemary"),
					"desc" => wp_kses( __("Any additional CSS rules (if need)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
			
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'rosemary'),
					'ol'	=> esc_html__('Ordered', 'rosemary'),
					'iconed'=> esc_html__('Iconed', 'rosemary')
				),
				'yes_no'	=> rosemary_get_list_yesno(),
				'on_off'	=> rosemary_get_list_onoff(),
				'dir' 		=> rosemary_get_list_directions(),
				'align'		=> rosemary_get_list_alignments(),
				'float'		=> rosemary_get_list_floats(),
				'show_hide'	=> rosemary_get_list_showhide(),
				'sorting' 	=> rosemary_get_list_sortings(),
				'ordering' 	=> rosemary_get_list_orderings(),
				'shapes'	=> rosemary_get_list_shapes(),
				'sizes'		=> rosemary_get_list_sizes(),
				'sliders'	=> rosemary_get_list_sliders(),
				'revo_sliders' => rosemary_get_list_revo_sliders(),
				'categories'=> rosemary_get_list_categories(),
				'columns'	=> rosemary_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), rosemary_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), rosemary_get_list_icons()),
				'locations'	=> rosemary_get_list_dedicated_locations(),
				'filters'	=> rosemary_get_list_portfolio_filters(),
				'formats'	=> rosemary_get_list_post_formats_filters(),
				'hovers'	=> rosemary_get_list_hovers(true),
				'hovers_dir'=> rosemary_get_list_hovers_directions(true),
				'schemes'	=> rosemary_get_list_color_schemes(true),
				'animations'		=> rosemary_get_list_animations_in(),
				'margins' 			=> rosemary_get_list_margins(true),
				'blogger_styles'	=> rosemary_get_list_templates_blogger(),
				'forms'				=> rosemary_get_list_templates_forms(),
				'posts_types'		=> rosemary_get_list_posts_types(),
				'googlemap_styles'	=> rosemary_get_list_googlemap_styles(),
				'field_types'		=> rosemary_get_list_field_types(),
				'label_positions'	=> rosemary_get_list_label_positions()
			);

			$ROSEMARY_GLOBALS['sc_params']['animation'] = array(
				"title" => esc_html__("Animation",  'rosemary'),
				"desc" => wp_kses( __('Select animation while object enter in the visible area of page',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"value" => "none",
				"type" => "select",
				"options" => $ROSEMARY_GLOBALS['sc_params']['animations']
			);
			$ROSEMARY_GLOBALS['sc_params']['top'] = array(
				"title" => esc_html__("Top margin",  'rosemary'),
				"divider" => true,
				"value" => "inherit",
				"type" => "select",
				"options" => $ROSEMARY_GLOBALS['sc_params']['margins']
			);
			$ROSEMARY_GLOBALS['sc_params']['bottom'] = array(
				"title" => esc_html__("Bottom margin",  'rosemary'),
				"value" => "inherit",
				"type" => "select",
				"options" => $ROSEMARY_GLOBALS['sc_params']['margins']
			);
			$ROSEMARY_GLOBALS['sc_params']['left'] = array(
				"title" => esc_html__("Left margin",  'rosemary'),
				"value" => "inherit",
				"type" => "select",
				"options" => $ROSEMARY_GLOBALS['sc_params']['margins']
			);
			$ROSEMARY_GLOBALS['sc_params']['right'] = array(
				"title" => esc_html__("Right margin",  'rosemary'),
				"desc" => wp_kses( __("Margins around this shortcode", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"value" => "inherit",
				"type" => "select",
				"options" => $ROSEMARY_GLOBALS['sc_params']['margins']
			);
	
			// Shortcodes list
			//------------------------------------------------------------------
			$ROSEMARY_GLOBALS['shortcodes'] = array();
			
			// Add shortcodes
			do_action('rosemary_action_shortcodes_list');

			// Sort shortcodes list
			ksort($ROSEMARY_GLOBALS['shortcodes']);
		}
	}
}
?>