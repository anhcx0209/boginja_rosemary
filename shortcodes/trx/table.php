<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_table_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_table_theme_setup' );
	function rosemary_sc_table_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_table_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_table_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_table id="unique_id" style="1"]
Table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/
[/trx_table]
*/

if (!function_exists('rosemary_sc_table')) {
	function rosemary_sc_table($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"align" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => "",
			"width" => "100%"
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= rosemary_get_css_dimensions_from_values($width);
		$content = str_replace(
					array('<p><table', 'table></p>', '><br />'),
					array('<table', 'table>', '>'),
					html_entity_decode($content, ENT_COMPAT, 'UTF-8'));
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_table' 
					. (!empty($align) && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. '"'
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				.'>' 
				. do_shortcode($content) 
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_table', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_table', 'rosemary_sc_table');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_table_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_table_reg_shortcodes');
	function rosemary_sc_table_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_table"] = array(
			"title" => esc_html__("Table", "rosemary"),
			"desc" => wp_kses( __("Insert a table into post (page). ", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"align" => array(
					"title" => esc_html__("Content alignment", "rosemary"),
					"desc" => wp_kses( __("Select alignment for each table cell", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['align']
				),
				"_content_" => array(
					"title" => esc_html__("Table content", "rosemary"),
					"desc" => wp_kses( __("Content, created with any table-generator", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"rows" => 8,
					"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
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
if ( !function_exists( 'rosemary_sc_table_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_table_reg_shortcodes_vc');
	function rosemary_sc_table_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_table",
			"name" => esc_html__("Table", "rosemary"),
			"description" => wp_kses( __("Insert a table", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_table',
			"class" => "trx_sc_container trx_sc_table",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "align",
					"heading" => esc_html__("Cells content alignment", "rosemary"),
					"description" => wp_kses( __("Select alignment for each table cell", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['align']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Table content", "rosemary"),
					"description" => wp_kses( __("Content, created with any table-generator", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => esc_html__("Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/", 'rosemary'),
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
			'js_view' => 'VcTrxTextContainerView'
		) );
		
		class WPBakeryShortCode_Trx_Table extends ROSEMARY_VC_ShortCodeContainer {}
	}
}
?>