<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_content_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_content_theme_setup' );
	function rosemary_sc_content_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_content_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_content_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_content id="unique_id" class="class_name" style="css-styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_content]
*/

if (!function_exists('rosemary_sc_content')) {
	function rosemary_sc_content($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			"scheme" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, '', $bottom);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_content content_wrap' 
				. ($scheme && !rosemary_param_is_off($scheme) && !rosemary_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '')
				. ($class ? ' '.esc_attr($class) : '') 
				. '"'
			. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '').'>' 
			. do_shortcode($content) 
			. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_content', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_content', 'rosemary_sc_content');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_content_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_content_reg_shortcodes');
	function rosemary_sc_content_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_content"] = array(
			"title" => esc_html__("Content block", "rosemary"),
			"desc" => wp_kses( __("Container for main content block with desired class and style (use it only on fullscreen pages)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"scheme" => array(
					"title" => esc_html__("Color scheme", "rosemary"),
					"desc" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "checklist",
					"options" => $ROSEMARY_GLOBALS['sc_params']['schemes']
				),
				"_content_" => array(
					"title" => esc_html__("Container content", "rosemary"),
					"desc" => wp_kses( __("Content for section container", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"top" => $ROSEMARY_GLOBALS['sc_params']['top'],
				"bottom" => $ROSEMARY_GLOBALS['sc_params']['bottom'],
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
if ( !function_exists( 'rosemary_sc_content_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_content_reg_shortcodes_vc');
	function rosemary_sc_content_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_content",
			"name" => esc_html__("Content block", "rosemary"),
			"description" => wp_kses( __("Container for main content block (use it only on fullscreen pages)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_content',
			"class" => "trx_sc_collection trx_sc_content",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", "rosemary"),
					"description" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Colors and Images', 'rosemary'),
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['schemes']),
					"type" => "dropdown"
				),
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Container content", "rosemary"),
					"description" => wp_kses( __("Content for section container", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
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
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom']
			)
		) );
		
		class WPBakeryShortCode_Trx_Content extends ROSEMARY_VC_ShortCodeCollection {}
	}
}
?>