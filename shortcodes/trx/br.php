<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_br_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_br_theme_setup' );
	function rosemary_sc_br_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_br_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_br_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_br clear="left|right|both"]
*/

if (!function_exists('rosemary_sc_br')) {
	function rosemary_sc_br($atts, $content = null) {
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			"clear" => ""
		), $atts)));
		$output = in_array($clear, array('left', 'right', 'both', 'all')) 
			? '<div class="clearfix" style="clear:' . str_replace('all', 'both', $clear) . '"></div>'
			: '<br />';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_br', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode("trx_br", "rosemary_sc_br");
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_br_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_br_reg_shortcodes');
	function rosemary_sc_br_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_br"] = array(
			"title" => esc_html__("Break", "rosemary"),
			"desc" => wp_kses( __("Line break with clear floating (if need)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"clear" => 	array(
					"title" => esc_html__("Clear floating", "rosemary"),
					"desc" => wp_kses( __("Clear floating (if need)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "checklist",
					"options" => array(
						'none' => esc_html__('None', 'rosemary'),
						'left' => esc_html__('Left', 'rosemary'),
						'right' => esc_html__('Right', 'rosemary'),
						'both' => esc_html__('Both', 'rosemary')
					)
				)
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_br_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_br_reg_shortcodes_vc');
	function rosemary_sc_br_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
/*
		vc_map( array(
			"base" => "trx_br",
			"name" => esc_html__("Line break", "rosemary"),
			"description" => wp_kses( __("Line break or Clear Floating", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_br',
			"class" => "trx_sc_single trx_sc_br",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "clear",
					"heading" => esc_html__("Clear floating", "rosemary"),
					"description" => wp_kses( __("Select clear side (if need)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"value" => array(
						esc_html__('None', 'rosemary') => 'none',
						esc_html__('Left', 'rosemary') => 'left',
						esc_html__('Right', 'rosemary') => 'right',
						esc_html__('Both', 'rosemary') => 'both'
					),
					"type" => "dropdown"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Br extends ROSEMARY_VC_ShortCodeSingle {}
*/
	}
}
?>