<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_infobox_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_infobox_theme_setup' );
	function rosemary_sc_infobox_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_infobox_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_infobox_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_infobox id="unique_id" style="regular|info|success|error|result" static="0|1"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_infobox]
*/

if (!function_exists('rosemary_sc_infobox')) {
	function rosemary_sc_infobox($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"closeable" => "no",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) .';' : '');
		if (empty($icon)) {
			if ($icon=='none')
				$icon = '';
			else if ($style=='regular')
				$icon = 'icon-cog';
			else if ($style=='success')
				$icon = 'icon-check';
			else if ($style=='error')
				$icon = 'icon-attention';
			else if ($style=='info')
				$icon = 'icon-info';
		}
		$content = do_shortcode($content);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_infobox sc_infobox_style_' . esc_attr($style) 
					. (rosemary_param_is_on($closeable) ? ' sc_infobox_closeable' : '')
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. ($icon!='' && !rosemary_param_is_inherit($icon) ? ' sc_infobox_iconed '. esc_attr($icon) : '')
					. '"'
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'
				. trim($content)
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_infobox', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_infobox', 'rosemary_sc_infobox');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_infobox_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_infobox_reg_shortcodes');
	function rosemary_sc_infobox_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_infobox"] = array(
			"title" => esc_html__("Infobox", "rosemary"),
			"desc" => wp_kses( __("Insert infobox into your post (page)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", "rosemary"),
					"desc" => wp_kses( __("Infobox style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "regular",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'regular' => esc_html__('Regular', 'rosemary'),
						'info' => esc_html__('Info', 'rosemary'),
						'success' => esc_html__('Success', 'rosemary'),
						'error' => esc_html__('Error', 'rosemary')
					)
				),
				"closeable" => array(
					"title" => esc_html__("Closeable box", "rosemary"),
					"desc" => wp_kses( __("Create closeable box (with close button)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "no",
					"type" => "switch",
					"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
				),
				"icon" => array(
					"title" => esc_html__("Custom icon",  'rosemary'),
					"desc" => wp_kses( __('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
				),
				"color" => array(
					"title" => esc_html__("Text color", "rosemary"),
					"desc" => wp_kses( __("Any color for text and headers", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", "rosemary"),
					"desc" => wp_kses( __("Any background color for this infobox", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"_content_" => array(
					"title" => esc_html__("Infobox content", "rosemary"),
					"desc" => wp_kses( __("Content for infobox", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"top" => $ROSEMARY_GLOBALS['sc_params']['top'],
				"bottom" => $ROSEMARY_GLOBALS['sc_params']['bottom'],
				"left" => $ROSEMARY_GLOBALS['sc_params']['left'],
				"right" => $ROSEMARY_GLOBALS['sc_params']['right'],
				"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
				"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
				"animation" => $ROSEMARY_GLOBALS['sc_params']['animation'],
				"css" => $ROSEMARY_GLOBALS['sc_params']['css']
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_infobox_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_infobox_reg_shortcodes_vc');
	function rosemary_sc_infobox_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_infobox",
			"name" => esc_html__("Infobox", "rosemary"),
			"description" => wp_kses( __("Box with info or error message", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_infobox',
			"class" => "trx_sc_container trx_sc_infobox",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", "rosemary"),
					"description" => wp_kses( __("Infobox style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Regular', 'rosemary') => 'regular',
							esc_html__('Info', 'rosemary') => 'info',
							esc_html__('Success', 'rosemary') => 'success',
							esc_html__('Error', 'rosemary') => 'error',
							esc_html__('Result', 'rosemary') => 'result'
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "closeable",
					"heading" => esc_html__("Closeable", "rosemary"),
					"description" => wp_kses( __("Create closeable box (with close button)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(esc_html__('Close button', 'rosemary') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Custom icon", "rosemary"),
					"description" => wp_kses( __("Select icon for the infobox from Fontello icons set. If empty - use default icon", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", "rosemary"),
					"description" => wp_kses( __("Any color for the text and headers", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", "rosemary"),
					"description" => wp_kses( __("Any background color for this infobox", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Message text", "rosemary"),
					"description" => wp_kses( __("Message for the infobox", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				*/
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css'],
				$ROSEMARY_GLOBALS['vc_params']['margin_top'],
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
				$ROSEMARY_GLOBALS['vc_params']['margin_left'],
				$ROSEMARY_GLOBALS['vc_params']['margin_right']
			),
			'js_view' => 'VcTrxTextContainerView'
		) );
		
		class WPBakeryShortCode_Trx_Infobox extends ROSEMARY_VC_ShortCodeContainer {}
	}
}
?>