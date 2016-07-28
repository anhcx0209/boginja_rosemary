<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_search_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_search_theme_setup' );
	function rosemary_sc_search_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_search_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_search_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_search id="unique_id" open="yes|no"]
*/

if (!function_exists('rosemary_sc_search')) {
	function rosemary_sc_search($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"state" => "fixed",
			"scheme" => "original",
			"ajax" => "",
			"title" => esc_html__('Search', 'rosemary'),
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
		if (empty($ajax)) $ajax = rosemary_get_theme_option('use_ajax_search');
		// Load core messages
		rosemary_enqueue_messages();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="search_wrap search_style_'.esc_attr($style).' search_state_'.esc_attr($state)
						. (rosemary_param_is_on($ajax) ? ' search_ajax' : '')
						. ($class ? ' '.esc_attr($class) : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
					. '>
						<div class="search_form_wrap">
							<form role="search" method="get" class="search_form" action="' . esc_url( home_url( '/' ) ) . '">
								<button type="submit" class="search_submit icon-search" title="' . ($state=='closed' ? esc_attr__('Open search', 'rosemary') : esc_attr__('Start search', 'rosemary')) . '"></button>
								<input type="text" class="search_field" placeholder="' . esc_attr($title) . '" value="' . esc_attr(get_search_query()) . '" name="s" />
							</form>
						</div>
						<div class="search_results widget_area' . ($scheme && !rosemary_param_is_off($scheme) && !rosemary_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') . '"><a class="search_results_close icon-cancel"></a><div class="search_results_content"></div></div>
				</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_search', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_search', 'rosemary_sc_search');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_search_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_search_reg_shortcodes');
	function rosemary_sc_search_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_search"] = array(
			"title" => esc_html__("Search", "rosemary"),
			"desc" => wp_kses( __("Show search form", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", "rosemary"),
					"desc" => wp_kses( __("Select style to display search field", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "regular",
					"options" => array(
						"regular" => esc_html__('Regular', 'rosemary'),
						"rounded" => esc_html__('Rounded', 'rosemary')
					),
					"type" => "checklist"
				),
				"state" => array(
					"title" => esc_html__("State", "rosemary"),
					"desc" => wp_kses( __("Select search field initial state", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "fixed",
					"options" => array(
						"fixed"  => esc_html__('Fixed',  'rosemary'),
						"opened" => esc_html__('Opened', 'rosemary'),
						"closed" => esc_html__('Closed', 'rosemary')
					),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", "rosemary"),
					"desc" => wp_kses( __("Title (placeholder) for the search field", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => esc_html__("Search &hellip;", 'rosemary'),
					"type" => "text"
				),
				"ajax" => array(
					"title" => esc_html__("AJAX", "rosemary"),
					"desc" => wp_kses( __("Search via AJAX or reload page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "yes",
					"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no'],
					"type" => "switch"
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
if ( !function_exists( 'rosemary_sc_search_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_search_reg_shortcodes_vc');
	function rosemary_sc_search_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_search",
			"name" => esc_html__("Search form", "rosemary"),
			"description" => wp_kses( __("Insert search form", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_search',
			"class" => "trx_sc_single trx_sc_search",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", "rosemary"),
					"description" => wp_kses( __("Select style to display search field", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'rosemary') => "regular",
						esc_html__('Flat', 'rosemary') => "flat"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "state",
					"heading" => esc_html__("State", "rosemary"),
					"description" => wp_kses( __("Select search field initial state", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(
						esc_html__('Fixed', 'rosemary')  => "fixed",
						esc_html__('Opened', 'rosemary') => "opened",
						esc_html__('Closed', 'rosemary') => "closed"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", "rosemary"),
					"description" => wp_kses( __("Title (placeholder) for the search field", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => esc_html__("Search &hellip;", 'rosemary'),
					"type" => "textfield"
				),
				array(
					"param_name" => "ajax",
					"heading" => esc_html__("AJAX", "rosemary"),
					"description" => wp_kses( __("Search via AJAX or reload page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(esc_html__('Use AJAX search', 'rosemary') => 'yes'),
					"type" => "checkbox"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['animation'],
				$ROSEMARY_GLOBALS['vc_params']['css'],
				$ROSEMARY_GLOBALS['vc_params']['margin_top'],
				$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
				$ROSEMARY_GLOBALS['vc_params']['margin_left'],
				$ROSEMARY_GLOBALS['vc_params']['margin_right']
			)
		) );
		
		class WPBakeryShortCode_Trx_Search extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>