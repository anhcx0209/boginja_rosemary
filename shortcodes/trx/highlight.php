<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_highlight_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_highlight_theme_setup' );
	function rosemary_sc_highlight_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_highlight_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_highlight_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_highlight]
*/

if (!function_exists('rosemary_sc_highlight')) {
	function rosemary_sc_highlight($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"color" => "",
			"bg_color" => "",
			"font_size" => "",
			"type" => "1",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$css .= ($color != '' ? 'color:' . esc_attr($color) . ';' : '')
			.($bg_color != '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
			.($font_size != '' ? 'font-size:' . esc_attr(rosemary_prepare_css_value($font_size)) . '; line-height: 1em;' : '');
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.esc_attr($type) : ''). (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</span>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_highlight', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_highlight', 'rosemary_sc_highlight');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_highlight_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_highlight_reg_shortcodes');
	function rosemary_sc_highlight_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_highlight"] = array(
			"title" => esc_html__("Highlight text", "rosemary"),
			"desc" => wp_kses( __("Highlight text with selected color, background color and other styles", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Type", "rosemary"),
					"desc" => wp_kses( __("Highlight type", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "1",
					"type" => "checklist",
					"options" => array(
						0 => esc_html__('Custom', 'rosemary'),
						1 => esc_html__('Type 1', 'rosemary'),
						2 => esc_html__('Type 2', 'rosemary'),
						3 => esc_html__('Type 3', 'rosemary')
					)
				),
				"color" => array(
					"title" => esc_html__("Color", "rosemary"),
					"desc" => wp_kses( __("Color for the highlighted text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", "rosemary"),
					"desc" => wp_kses( __("Background color for the highlighted text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", "rosemary"),
					"desc" => wp_kses( __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Highlighting content", "rosemary"),
					"desc" => wp_kses( __("Content for highlight", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
				"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
				"css" => $ROSEMARY_GLOBALS['sc_params']['css']
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_highlight_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_highlight_reg_shortcodes_vc');
	function rosemary_sc_highlight_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_highlight",
			"name" => esc_html__("Highlight text", "rosemary"),
			"description" => wp_kses( __("Highlight text with selected color, background color and other styles", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_highlight',
			"class" => "trx_sc_single trx_sc_highlight",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Type", "rosemary"),
					"description" => wp_kses( __("Highlight type", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Custom', 'rosemary') => 0,
							esc_html__('Type 1', 'rosemary') => 1,
							esc_html__('Type 2', 'rosemary') => 2,
							esc_html__('Type 3', 'rosemary') => 3
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", "rosemary"),
					"description" => wp_kses( __("Color for the highlighted text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", "rosemary"),
					"description" => wp_kses( __("Background color for the highlighted text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", "rosemary"),
					"description" => wp_kses( __("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Highlight text", "rosemary"),
					"description" => wp_kses( __("Content for highlight", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['css']
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Highlight extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>