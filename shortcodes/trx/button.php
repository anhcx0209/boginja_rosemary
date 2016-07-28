<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_button_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_button_theme_setup' );
	function rosemary_sc_button_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_button_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_button_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/

if (!function_exists('rosemary_sc_button')) {
	function rosemary_sc_button($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "square",
			"style" => "filled",
			"size" => "small",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"link" => "",
			"target" => "",
			"align" => "",
			"rel" => "",
			"popup" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= rosemary_get_css_dimensions_from_values($width, $height)
			. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
		if (rosemary_param_is_on($popup)) rosemary_enqueue_popup('magnific');
		$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
			. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
			. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
			. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
			. ' class="sc_button sc_button_' . esc_attr($type) 
					. ' sc_button_style_' . esc_attr($style) 
					. ' sc_button_size_' . esc_attr($size)
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
					. (rosemary_param_is_on($popup) ? ' sc_popup_link' : '')
					. '"'
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</a>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_button', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_button', 'rosemary_sc_button');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_button_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_button_reg_shortcodes');
	function rosemary_sc_button_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_button"] = array(
			"title" => esc_html__("Button", "rosemary"),
			"desc" => wp_kses( __("Button with link", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Caption", "rosemary"),
					"desc" => wp_kses( __("Button caption", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"type" => array(
					"title" => esc_html__("Button's shape", "rosemary"),
					"desc" => wp_kses( __("Select button's shape", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "square",
					"size" => "medium",
					"options" => array(
						'square' => esc_html__('Square', 'rosemary'),
						'round' => esc_html__('Round', 'rosemary')
					),
					"type" => "switch"
				), 
				"style" => array(
					"title" => esc_html__("Button's style", "rosemary"),
					"desc" => wp_kses( __("Select button's style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "default",
					"dir" => "horizontal",
					"options" => array(
						'filled' => esc_html__('Filled', 'rosemary'),
						'border' => esc_html__('Border', 'rosemary')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Button's size", "rosemary"),
					"desc" => wp_kses( __("Select button's size", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "small",
					"dir" => "horizontal",
					"options" => array(
						'small' => esc_html__('Small', 'rosemary'),
						'medium' => esc_html__('Medium', 'rosemary'),
						'large' => esc_html__('Large', 'rosemary')
					),
					"type" => "checklist"
				), 
				"icon" => array(
					"title" => esc_html__("Button's icon",  'rosemary'),
					"desc" => wp_kses( __('Select icon for the title from Fontello icons set',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
				),
				"color" => array(
					"title" => esc_html__("Button's text color", "rosemary"),
					"desc" => wp_kses( __("Any color for button's caption", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"std" => "",
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Button's backcolor", "rosemary"),
					"desc" => wp_kses( __("Any color for button's background", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Button's alignment", "rosemary"),
					"desc" => wp_kses( __("Align button to left, center or right", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['align']
				), 
				"link" => array(
					"title" => esc_html__("Link URL", "rosemary"),
					"desc" => wp_kses( __("URL for link on button click", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"target" => array(
					"title" => esc_html__("Link target", "rosemary"),
					"desc" => wp_kses( __("Target for link on button click", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"popup" => array(
					"title" => esc_html__("Open link in popup", "rosemary"),
					"desc" => wp_kses( __("Open link target in popup window", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "no",
					"type" => "switch",
					"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
				), 
				"rel" => array(
					"title" => esc_html__("Rel attribute", "rosemary"),
					"desc" => wp_kses( __("Rel attribute for button's link (if need)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"width" => rosemary_shortcodes_width(),
				"height" => rosemary_shortcodes_height(),
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
if ( !function_exists( 'rosemary_sc_button_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_button_reg_shortcodes_vc');
	function rosemary_sc_button_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_button",
			"name" => esc_html__("Button", "rosemary"),
			"description" => wp_kses( __("Button with link", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_button',
			"class" => "trx_sc_single trx_sc_button",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Caption", "rosemary"),
					"description" => wp_kses( __("Button caption", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Button's shape", "rosemary"),
					"description" => wp_kses( __("Select button's shape", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(
						esc_html__('Square', 'rosemary') => 'square',
						esc_html__('Round', 'rosemary') => 'round'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Button's style", "rosemary"),
					"description" => wp_kses( __("Select button's style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(
						esc_html__('Filled', 'rosemary') => 'filled',
						esc_html__('Border', 'rosemary') => 'border'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Button's size", "rosemary"),
					"description" => wp_kses( __("Select button's size", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Small', 'rosemary') => 'small',
						esc_html__('Medium', 'rosemary') => 'medium',
						esc_html__('Large', 'rosemary') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Button's icon", "rosemary"),
					"description" => wp_kses( __("Select icon for the title from Fontello icons set", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Button's text color", "rosemary"),
					"description" => wp_kses( __("Any color for button's caption", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Button's backcolor", "rosemary"),
					"description" => wp_kses( __("Any color for button's background", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Button's alignment", "rosemary"),
					"description" => wp_kses( __("Align button to left, center or right", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['align']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", "rosemary"),
					"description" => wp_kses( __("URL for the link on button click", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Link', 'rosemary'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", "rosemary"),
					"description" => wp_kses( __("Target for the link on button click", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Link', 'rosemary'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "popup",
					"heading" => esc_html__("Open link in popup", "rosemary"),
					"description" => wp_kses( __("Open link target in popup window", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Link', 'rosemary'),
					"value" => array(esc_html__('Open in popup', 'rosemary') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "rel",
					"heading" => esc_html__("Rel attribute", "rosemary"),
					"description" => wp_kses( __("Rel attribute for the button's link (if need", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Link', 'rosemary'),
					"value" => "",
					"type" => "textfield"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css'],
				rosemary_vc_width(),
				rosemary_vc_height(),
				$ROSEMARY_GLOBALS['vc_params']['margin_top'],
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
				$ROSEMARY_GLOBALS['vc_params']['margin_left'],
				$ROSEMARY_GLOBALS['vc_params']['margin_right']
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Button extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>