<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_dropcaps_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_dropcaps_theme_setup' );
	function rosemary_sc_dropcaps_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_dropcaps_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_dropcaps_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_dropcaps id="unique_id" style="1-6"]paragraph text[/trx_dropcaps]

if (!function_exists('rosemary_sc_dropcaps')) {
	function rosemary_sc_dropcaps($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "1",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$style = min(4, max(1, $style));
		$content = do_shortcode($content);
		$output = rosemary_substr($content, 0, 1) == '<'
			? $content 
			: '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_dropcaps sc_dropcaps_style_' . esc_attr($style) . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
				. ($css ? ' style="'.esc_attr($css).'"' : '')
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. '>' 
					. '<span class="sc_dropcaps_item">' . trim(rosemary_substr($content, 0, 1)) . '</span>' . trim(rosemary_substr($content, 1))
			. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_dropcaps', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_dropcaps', 'rosemary_sc_dropcaps');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_dropcaps_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_dropcaps_reg_shortcodes');
	function rosemary_sc_dropcaps_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_dropcaps"] = array(
			"title" => esc_html__("Dropcaps", "rosemary"),
			"desc" => wp_kses( __("Make first letter as dropcaps", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", "rosemary"),
					"desc" => wp_kses( __("Dropcaps style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "1",
					"type" => "checklist",
					"options" => rosemary_get_list_styles(1, 4)
				),
				"_content_" => array(
					"title" => esc_html__("Paragraph content", "rosemary"),
					"desc" => wp_kses( __("Paragraph with dropcaps content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
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
if ( !function_exists( 'rosemary_sc_dropcaps_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_dropcaps_reg_shortcodes_vc');
	function rosemary_sc_dropcaps_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_dropcaps",
			"name" => esc_html__("Dropcaps", "rosemary"),
			"description" => wp_kses( __("Make first letter of the text as dropcaps", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_dropcaps',
			"class" => "trx_sc_single trx_sc_dropcaps",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", "rosemary"),
					"description" => wp_kses( __("Dropcaps style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(rosemary_get_list_styles(1, 4)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Paragraph text", "rosemary"),
					"description" => wp_kses( __("Paragraph with dropcaps content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css']
			),
			'js_view' => 'VcTrxTextView'
		
		) );
		
		class WPBakeryShortCode_Trx_Dropcaps extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>