<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_quote_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_quote_theme_setup' );
	function rosemary_sc_quote_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_quote_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_quote_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_quote id="unique_id" cite="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/quote]
*/

if (!function_exists('rosemary_sc_quote')) {
	function rosemary_sc_quote($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "1",
			"title" => "",
			"cite" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$style = max(1, min(2, $style));
		$css .= rosemary_get_css_dimensions_from_values($width);
		$cite_param = $cite != '' ? ' cite="'.esc_attr($cite).'"' : '';
		$title = $title=='' ? $cite : $title;
		$content = do_shortcode($content);
		if (rosemary_substr($content, 0, 2)!='<p') $content = '<p>' . ($content) . '</p>';
		$output = '<blockquote' 
			. ($id ? ' id="'.esc_attr($id).'"' : '') . ($cite_param) 
			. ' class="sc_quote blockquote_style_' .esc_attr($style). ' '. (!empty($class) ? ' '.esc_attr($class) : '').'"' 
			. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
				. ($content)
				. ($title == '' ? '' : ('<p class="sc_quote_title">' . ($cite!='' ? '<a href="'.esc_url($cite).'">' : '') . ($title) . ($cite!='' ? '</a>' : '') . '</p>'))
			.'</blockquote>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_quote', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_quote', 'rosemary_sc_quote');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_quote_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_quote_reg_shortcodes');
	function rosemary_sc_quote_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_quote"] = array(
			"title" => esc_html__("Quote", "rosemary"),
			"desc" => wp_kses( __("Quote text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Blockquote style", "rosemary"),
					"desc" => wp_kses( __("Select style for display blockquote", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => 1,
					"options" => rosemary_get_list_styles(1, 2),
					"type" => "radio"
					),
				"cite" => array(
					"title" => esc_html__("Quote cite", "rosemary"),
					"desc" => wp_kses( __("URL for quote cite", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"title" => array(
					"title" => esc_html__("Title (author)", "rosemary"),
					"desc" => wp_kses( __("Quote title (author name)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Quote content", "rosemary"),
					"desc" => wp_kses( __("Quote content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"width" => rosemary_shortcodes_width(),
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
if ( !function_exists( 'rosemary_sc_quote_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_quote_reg_shortcodes_vc');
	function rosemary_sc_quote_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_quote",
			"name" => esc_html__("Quote", "rosemary"),
			"description" => wp_kses( __("Quote text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_quote',
			"class" => "trx_sc_single trx_sc_quote",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Blockquote style", "rosemary"),
					"description" => wp_kses( __("Select style for display blockquote", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(rosemary_get_list_styles(1, 2)),
					"type" => "dropdown"
					),
				array(
					"param_name" => "cite",
					"heading" => esc_html__("Quote cite", "rosemary"),
					"description" => wp_kses( __("URL for the quote cite link", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title (author)", "rosemary"),
					"description" => wp_kses( __("Quote title (author name)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Quote content", "rosemary"),
					"description" => wp_kses( __("Quote content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css'],
				rosemary_vc_width(),
				$ROSEMARY_GLOBALS['vc_params']['margin_top'],
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
				$ROSEMARY_GLOBALS['vc_params']['margin_left'],
				$ROSEMARY_GLOBALS['vc_params']['margin_right']
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Quote extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>