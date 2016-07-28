<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_gap_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_gap_theme_setup' );
	function rosemary_sc_gap_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_gap_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_gap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_gap]Fullwidth content[/trx_gap]

if (!function_exists('rosemary_sc_gap')) {
	function rosemary_sc_gap($atts, $content = null) {
		if (rosemary_in_shortcode_blogger()) return '';
		$output = rosemary_gap_start() . do_shortcode($content) . rosemary_gap_end();
		return apply_filters('rosemary_shortcode_output', $output, 'trx_gap', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode("trx_gap", "rosemary_sc_gap");
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_gap_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_gap_reg_shortcodes');
	function rosemary_sc_gap_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_gap"] = array(
			"title" => esc_html__("Gap", "rosemary"),
			"desc" => wp_kses( __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Gap content", "rosemary"),
					"desc" => wp_kses( __("Gap inner content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				)
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_gap_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_gap_reg_shortcodes_vc');
	function rosemary_sc_gap_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_gap",
			"name" => esc_html__("Gap", "rosemary"),
			"description" => wp_kses( __("Insert gap (fullwidth area) in the post content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Structure', 'js_composer'),
			'icon' => 'icon_trx_gap',
			"class" => "trx_sc_collection trx_sc_gap",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"params" => array(
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Gap content", "rosemary"),
					"description" => wp_kses( __("Gap inner content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				)
				*/
			)
		) );
		
		class WPBakeryShortCode_Trx_Gap extends ROSEMARY_VC_ShortCodeCollection {}
	}
}
?>