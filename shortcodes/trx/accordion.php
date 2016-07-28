<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_accordion_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_accordion_theme_setup' );
	function rosemary_sc_accordion_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_accordion_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_accordion_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_accordion style="1" counter="off" initial="1"]
	[trx_accordion_item title="Accordion Title 1"]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 2"]Proin dignissim commodo magna at luctus. Nam molestie justo augue, nec eleifend urna laoreet non.[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 3 with custom icons" icon_closed="icon-check" icon_opened="icon-delete"]Curabitur tristique tempus arcu a placerat.[/trx_accordion_item]
[/trx_accordion]
*/
if (!function_exists('rosemary_sc_accordion')) {
	function rosemary_sc_accordion($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "1",
			"initial" => "1",
			"counter" => "off",
			"icon_closed" => "icon-plus",
			"icon_opened" => "icon-minus",
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
		$style = max(1, min(2, $style));
		$initial = max(0, (int) $initial);
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_accordion_counter'] = 0;
		$ROSEMARY_GLOBALS['sc_accordion_show_counter'] = rosemary_param_is_on($counter);
		$ROSEMARY_GLOBALS['sc_accordion_icon_closed'] = empty($icon_closed) || rosemary_param_is_inherit($icon_closed) ? "icon-plus" : $icon_closed;
		$ROSEMARY_GLOBALS['sc_accordion_icon_opened'] = empty($icon_opened) || rosemary_param_is_inherit($icon_opened) ? "icon-minus" : $icon_opened;
		rosemary_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion sc_accordion_style_'.esc_attr($style)
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. (rosemary_param_is_on($counter) ? ' sc_show_counter' : '')
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. ' data-active="' . ($initial-1) . '"'
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. '>'
				. do_shortcode($content)
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_accordion', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_accordion', 'rosemary_sc_accordion');
}


if (!function_exists('rosemary_sc_accordion_item')) {
	function rosemary_sc_accordion_item($atts, $content=null) {
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts( array(
			// Individual params
			"icon_closed" => "",
			"icon_opened" => "",
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_accordion_counter']++;
		if (empty($icon_closed) || rosemary_param_is_inherit($icon_closed)) $icon_closed = $ROSEMARY_GLOBALS['sc_accordion_icon_closed'] ? $ROSEMARY_GLOBALS['sc_accordion_icon_closed'] : "icon-plus";
		if (empty($icon_opened) || rosemary_param_is_inherit($icon_opened)) $icon_opened = $ROSEMARY_GLOBALS['sc_accordion_icon_opened'] ? $ROSEMARY_GLOBALS['sc_accordion_icon_opened'] : "icon-minus";
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion_item' 
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($ROSEMARY_GLOBALS['sc_accordion_counter'] % 2 == 1 ? ' odd' : ' even')
				. ($ROSEMARY_GLOBALS['sc_accordion_counter'] == 1 ? ' first' : '')
				. '">'
				. '<h5 class="sc_accordion_title">'
				. (!rosemary_param_is_off($icon_closed) ? '<span class="sc_accordion_icon sc_accordion_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
				. (!rosemary_param_is_off($icon_opened) ? '<span class="sc_accordion_icon sc_accordion_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
				. ($ROSEMARY_GLOBALS['sc_accordion_show_counter'] ? '<span class="sc_items_counter">'.($ROSEMARY_GLOBALS['sc_accordion_counter']).'</span>' : '')
				. ($title)
				. '</h5>'
				. '<div class="sc_accordion_content"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
					. do_shortcode($content) 
				. '</div>'
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_accordion_item', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_accordion_item', 'rosemary_sc_accordion_item');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_accordion_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_accordion_reg_shortcodes');
	function rosemary_sc_accordion_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_accordion"] = array(
			"title" => esc_html__("Accordion", "rosemary"),
			"desc" => wp_kses( __("Accordion items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Accordion style", "rosemary"),
					"desc" => wp_kses( __("Select style for display accordion", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => 1,
					"options" => rosemary_get_list_styles(1, 2),
					"type" => "radio"
				),
				"counter" => array(
					"title" => esc_html__("Counter", "rosemary"),
					"desc" => wp_kses( __("Display counter before each accordion title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "off",
					"type" => "switch",
					"options" => $ROSEMARY_GLOBALS['sc_params']['on_off']
				),
				"initial" => array(
					"title" => esc_html__("Initially opened item", "rosemary"),
					"desc" => wp_kses( __("Number of initially opened item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => 1,
					"min" => 0,
					"type" => "spinner"
				),
				"icon_closed" => array(
					"title" => esc_html__("Icon while closed",  'rosemary'),
					"desc" => wp_kses( __('Select icon for the closed accordion item from Fontello icons set',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
				),
				"icon_opened" => array(
					"title" => esc_html__("Icon while opened",  'rosemary'),
					"desc" => wp_kses( __('Select icon for the opened accordion item from Fontello icons set',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
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
				"name" => "trx_accordion_item",
				"title" => esc_html__("Item", "rosemary"),
				"desc" => wp_kses( __("Accordion item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"container" => true,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Accordion item title", "rosemary"),
						"desc" => wp_kses( __("Title for current accordion item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"icon_closed" => array(
						"title" => esc_html__("Icon while closed",  'rosemary'),
						"desc" => wp_kses( __('Select icon for the closed accordion item from Fontello icons set',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "icons",
						"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
					),
					"icon_opened" => array(
						"title" => esc_html__("Icon while opened",  'rosemary'),
						"desc" => wp_kses( __('Select icon for the opened accordion item from Fontello icons set',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "icons",
						"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
					),
					"_content_" => array(
						"title" => esc_html__("Accordion item content", "rosemary"),
						"desc" => wp_kses( __("Current accordion item content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"rows" => 4,
						"value" => "",
						"type" => "textarea"
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
if ( !function_exists( 'rosemary_sc_accordion_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_accordion_reg_shortcodes_vc');
	function rosemary_sc_accordion_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_accordion",
			"name" => esc_html__("Accordion", "rosemary"),
			"description" => wp_kses( __("Accordion items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_accordion',
			"class" => "trx_sc_collection trx_sc_accordion",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"as_parent" => array('only' => 'trx_accordion_item'),	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Accordion style", "rosemary"),
					"description" => wp_kses( __("Select style for display accordion", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(rosemary_get_list_styles(1, 2)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "counter",
					"heading" => esc_html__("Counter", "rosemary"),
					"description" => wp_kses( __("Display counter before each accordion title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array("Add item numbers before each element" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "initial",
					"heading" => esc_html__("Initially opened item", "rosemary"),
					"description" => wp_kses( __("Number of initially opened item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => 1,
					"type" => "textfield"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", "rosemary"),
					"description" => wp_kses( __("Select icon for the closed accordion item from Fontello icons set", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", "rosemary"),
					"description" => wp_kses( __("Select icon for the opened accordion item from Fontello icons set", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
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
				[trx_accordion_item title="' . esc_html__( 'Item 1 title', 'rosemary' ) . '"][/trx_accordion_item]
				[trx_accordion_item title="' . esc_html__( 'Item 2 title', 'rosemary' ) . '"][/trx_accordion_item]
			',
			"custom_markup" => '
				<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
					%content%
				</div>
				<div class="tab_controls">
					<button class="add_tab" title="'.esc_attr__("Add item", "rosemary").'">'.esc_html__("Add item", "rosemary").'</button>
				</div>
			',
			'js_view' => 'VcTrxAccordionView'
		) );
		
		
		vc_map( array(
			"base" => "trx_accordion_item",
			"name" => esc_html__("Accordion item", "rosemary"),
			"description" => wp_kses( __("Inner accordion item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => true,
			'icon' => 'icon_trx_accordion_item',
			"as_child" => array('only' => 'trx_accordion'), 	// Use only|except attributes to limit parent (separate multiple values with comma)
			"as_parent" => array('except' => 'trx_accordion'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", "rosemary"),
					"description" => wp_kses( __("Title for current accordion item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", "rosemary"),
					"description" => wp_kses( __("Select icon for the closed accordion item from Fontello icons set", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", "rosemary"),
					"description" => wp_kses( __("Select icon for the opened accordion item from Fontello icons set", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['css']
			),
		  'js_view' => 'VcTrxAccordionTabView'
		) );

		class WPBakeryShortCode_Trx_Accordion extends ROSEMARY_VC_ShortCodeAccordion {}
		class WPBakeryShortCode_Trx_Accordion_Item extends ROSEMARY_VC_ShortCodeAccordionItem {}
	}
}
?>