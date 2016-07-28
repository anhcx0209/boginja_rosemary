<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_list_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_list_theme_setup' );
	function rosemary_sc_list_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_list_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_list_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_list id="unique_id" style="arrows|iconed|ol|ul"]
	[trx_list_item id="unique_id" title="title_of_element"]Et adipiscing integer.[/trx_list_item]
	[trx_list_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in.[/trx_list_item]
	[trx_list_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer.[/trx_list_item]
	[trx_list_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus.[/trx_list_item]
[/trx_list]
*/

if (!function_exists('rosemary_sc_list')) {
	function rosemary_sc_list($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "ul",
			"icon" => "icon-right",
			"icon_color" => "",
			"color" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => "",
			"underlined" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= $color !== '' ? 'color:' . esc_attr($color) .';' : '';
		if (trim($style) == '' || (trim($icon) == '' && $style=='iconed')) $style = 'ul';
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_list_counter'] = 0;
		$ROSEMARY_GLOBALS['sc_list_icon'] = empty($icon) || rosemary_param_is_inherit($icon) ? "icon-right" : $icon;
		$ROSEMARY_GLOBALS['sc_list_icon_color'] = $icon_color;
		$ROSEMARY_GLOBALS['sc_list_style'] = $style;
		$output = '<' . ($style=='ol' ? 'ol' : 'ul')
				. ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_list sc_list_style_' . esc_attr($style) . (!empty($class) ? ' '.esc_attr($class) : '')
                . ($underlined=='true' ? ' underlined' : '') . '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. '>'
               	. do_shortcode($content)
            . '</' .($style=='ol' ? 'ol' : 'ul') . '>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_list', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_list', 'rosemary_sc_list');
}


if (!function_exists('rosemary_sc_list_item')) {
	function rosemary_sc_list_item($atts, $content=null) {
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts( array(
			// Individual params
			"color" => "",
			"icon" => "",
			"icon_color" => "",
			"title" => "",
			"link" => "",
			"target" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"style" => ""
		), $atts)));
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_list_counter']++;
		$style = $ROSEMARY_GLOBALS['sc_list_style'];
		$css .= $color !== '' ? 'color:' . esc_attr($color) .';' : '';
		if (trim($icon) == '' || rosemary_param_is_inherit($icon)) $icon = $ROSEMARY_GLOBALS['sc_list_icon'];
		if (trim($color) == '' || rosemary_param_is_inherit($icon_color)) $icon_color = $ROSEMARY_GLOBALS['sc_list_icon_color'];
		$output = '<li' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_list_item' 
			. (!empty($class) ? ' '.esc_attr($class) : '')
			. ($ROSEMARY_GLOBALS['sc_list_counter'] % 2 == 1 ? ' odd' : ' even')
			. ($ROSEMARY_GLOBALS['sc_list_counter'] == 1 ? ' first' : '')
			. '"' 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. ($title ? ' title="'.esc_attr($title).'"' : '') 
			. '>' 
			. (!empty($link) ? '<a href="'.esc_url($link).'"' . (!empty($target) ? ' target="'.esc_attr($target).'"' : '') . '>' : '')
			. ($ROSEMARY_GLOBALS['sc_list_style']=='iconed' && $icon!='' ? '<span class="sc_list_icon '.esc_attr($icon).'"'.($icon_color !== '' ? ' style="color:'.esc_attr($icon_color).';"' : '').'></span>' : '')
            . ($style=='ol' ? '<span>' : '')
            . do_shortcode($content)
			. (!empty($link) ? '</a>': '')
            . ($style=='ol' ? '</span>' : '')
			. '</li>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_list_item', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_list_item', 'rosemary_sc_list_item');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_list_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_list_reg_shortcodes');
	function rosemary_sc_list_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_list"] = array(
			"title" => esc_html__("List", "rosemary"),
			"desc" => wp_kses( __("List items with specific bullets", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Bullet's style", "rosemary"),
					"desc" => wp_kses( __("Bullet's style for each list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "ul",
					"type" => "checklist",
					"options" => $ROSEMARY_GLOBALS['sc_params']['list_styles']
					),
				"underlined" => array(
					"title" => __("Line for li", "rosemary"),
					"desc" => __("Add line for li", "rosemary"),
					"type" => "checkbox"
					), 
				"color" => array(
					"title" => esc_html__("Color", "rosemary"),
					"desc" => wp_kses( __("List items color", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('List icon',  'rosemary'),
					"desc" => wp_kses( __("Select list icon from Fontello icons set (only for style=Iconed)",  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
				),
				"icon_color" => array(
					"title" => esc_html__("Icon color", "rosemary"),
					"desc" => wp_kses( __("List icons color", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"dependency" => array(
						'style' => array('iconed')
					),
					"type" => "color"
				),
				"top" => $ROSEMARY_GLOBALS['sc_params']['top'],
				"bottom" => $ROSEMARY_GLOBALS['sc_params']['bottom'],
				"left" => $ROSEMARY_GLOBALS['sc_params']['left'],
				"right" => $ROSEMARY_GLOBALS['sc_params']['right'],
				"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
				"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
				"animation" => $ROSEMARY_GLOBALS['sc_params']['animation'],
				"css" => $ROSEMARY_GLOBALS['sc_params']['css']
			),
			"children" => array(
				"name" => "trx_list_item",
				"title" => esc_html__("Item", "rosemary"),
				"desc" => wp_kses( __("List item with specific bullet", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => true,
				"params" => array(
					"_content_" => array(
						"title" => esc_html__("List item content", "rosemary"),
						"desc" => wp_kses( __("Current list item content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"rows" => 4,
						"value" => "",
						"type" => "textarea"
					),
					"title" => array(
						"title" => esc_html__("List item title", "rosemary"),
						"desc" => wp_kses( __("Current list item title (show it as tooltip)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"color" => array(
						"title" => esc_html__("Color", "rosemary"),
						"desc" => wp_kses( __("Text color for this item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "color"
					),
					"icon" => array(
						"title" => esc_html__('List icon',  'rosemary'),
						"desc" => wp_kses( __("Select list item icon from Fontello icons set (only for style=Iconed)",  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "icons",
						"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
					),
					"icon_color" => array(
						"title" => esc_html__("Icon color", "rosemary"),
						"desc" => wp_kses( __("Icon color for this item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "color"
					),
					"link" => array(
						"title" => esc_html__("Link URL", "rosemary"),
						"desc" => wp_kses( __("Link URL for the current list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"divider" => true,
						"value" => "",
						"type" => "text"
					),
					"target" => array(
						"title" => esc_html__("Link target", "rosemary"),
						"desc" => wp_kses( __("Link target for the current list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
					"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
					"css" => $ROSEMARY_GLOBALS['sc_params']['css']
				)
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_list_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_list_reg_shortcodes_vc');
	function rosemary_sc_list_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_list",
			"name" => esc_html__("List", "rosemary"),
			"description" => wp_kses( __("List items with specific bullets", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			"class" => "trx_sc_collection trx_sc_list",
			'icon' => 'icon_trx_list',
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"as_parent" => array('only' => 'trx_list_item'),
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Bullet's style", "rosemary"),
					"description" => wp_kses( __("Bullet's style for each list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['list_styles']),
					"type" => "dropdown"
					),
				array(
                        "param_name" => "underlined",
                        "heading" => __("Underline", "rosemary"),
                        "description" => __("Underline for li", "rosemary"),
                        "type" => "checkbox"
                    ),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", "rosemary"),
					"description" => wp_kses( __("List items color", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("List icon", "rosemary"),
					"description" => wp_kses( __("Select list icon from Fontello icons set (only for style=Iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),

				array(
					"param_name" => "icon_color",
					"heading" => esc_html__("Icon color", "rosemary"),
					"description" => wp_kses( __("List icons color", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => "",
					"type" => "colorpicker"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css'],
				$ROSEMARY_GLOBALS['vc_params']['margin_top'],
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
				$ROSEMARY_GLOBALS['vc_params']['margin_left'],
				$ROSEMARY_GLOBALS['vc_params']['margin_right']
			),
			'default_content' => '
				[trx_list_item]' . esc_html__( 'Item 1', 'rosemary' ) . '[/trx_list_item]
				[trx_list_item]' . esc_html__( 'Item 2', 'rosemary' ) . '[/trx_list_item]
			'
		) );
		
		
		vc_map( array(
			"base" => "trx_list_item",
			"name" => esc_html__("List item", "rosemary"),
			"description" => wp_kses( __("List item with specific bullet", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"class" => "trx_sc_single trx_sc_list_item",
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => false,
			'icon' => 'icon_trx_list_item',
			"as_child" => array('only' => 'trx_list'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"as_parent" => array('except' => 'trx_list'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("List item title", "rosemary"),
					"description" => wp_kses( __("Title for the current list item (show it as tooltip)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", "rosemary"),
					"description" => wp_kses( __("Link URL for the current list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"group" => esc_html__('Link', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", "rosemary"),
					"description" => wp_kses( __("Link target for the current list item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"group" => esc_html__('Link', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", "rosemary"),
					"description" => wp_kses( __("Text color for this item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("List item icon", "rosemary"),
					"description" => wp_kses( __("Select list item icon from Fontello icons set (only for style=Iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_color",
					"heading" => esc_html__("Icon color", "rosemary"),
					"description" => wp_kses( __("Icon color for this item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("List item text", "rosemary"),
					"description" => wp_kses( __("Current list item content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
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
		
		class WPBakeryShortCode_Trx_List extends ROSEMARY_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_List_Item extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>