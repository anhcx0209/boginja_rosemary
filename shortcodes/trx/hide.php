<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_hide_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_hide_theme_setup' );
	function rosemary_sc_hide_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_hide_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_hide selector="unique_id"]
*/

if (!function_exists('rosemary_sc_hide')) {
	function rosemary_sc_hide($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"selector" => "",
			"hide" => "on",
			"delay" => 0
		), $atts)));
		$selector = trim(chop($selector));
		$output = $selector == '' ? '' : 
			'<script type="text/javascript">
				jQuery(document).ready(function() {
					'.($delay>0 ? 'setTimeout(function() {' : '').'
					jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
					'.($delay>0 ? '},'.($delay).');' : '').'
				});
			</script>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_hide', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_hide', 'rosemary_sc_hide');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_hide_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_hide_reg_shortcodes');
	function rosemary_sc_hide_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_hide"] = array(
			"title" => esc_html__("Hide/Show any block", "rosemary"),
			"desc" => wp_kses( __("Hide or Show any block with desired CSS-selector", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"selector" => array(
					"title" => esc_html__("Selector", "rosemary"),
					"desc" => wp_kses( __("Any block's CSS-selector", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"hide" => array(
					"title" => esc_html__("Hide or Show", "rosemary"),
					"desc" => wp_kses( __("New state for the block: hide or show", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "yes",
					"size" => "small",
					"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no'],
					"type" => "switch"
				)
			)
		);
	}
}
?>