<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_zoom_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_zoom_theme_setup' );
	function rosemary_sc_zoom_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_zoom_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_zoom_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_zoom id="unique_id" border="none|light|dark"]
*/

if (!function_exists('rosemary_sc_zoom')) {
	function rosemary_sc_zoom($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"effect" => "zoom",
			"src" => "",
			"url" => "",
			"over" => "",
			"align" => "",
			"bg_image" => "",
			"bg_top" => '',
			"bg_bottom" => '',
			"bg_left" => '',
			"bg_right" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		rosemary_enqueue_script( 'rosemary-elevate-zoom-script', rosemary_get_file_url('js/jquery.elevateZoom-3.0.4.js'), array(), null, true );
	
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css_dim = rosemary_get_css_dimensions_from_values($width, $height);
		$css_bg = rosemary_get_css_paddings_from_values($bg_top, $bg_right, $bg_bottom, $bg_left);
		$width  = rosemary_prepare_css_value($width);
		$height = rosemary_prepare_css_value($height);
		if (empty($id)) $id = 'sc_zoom_'.str_replace('.', '', mt_rand());
		$src = $src!='' ? $src : $url;
		if ($src > 0) {
			$attach = wp_get_attachment_image_src( $src, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$src = $attach[0];
		}
		if ($over > 0) {
			$attach = wp_get_attachment_image_src( $over, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$over = $attach[0];
		}
		if ($effect=='lens' && ((int) $width > 0 && rosemary_substr($width, -2, 2)=='px') || ((int) $height > 0 && rosemary_substr($height, -2, 2)=='px')) {
			if ($src)
				$src = rosemary_get_resized_image_url($src, (int) $width > 0 && rosemary_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && rosemary_substr($height, -2, 2)=='px' ? (int) $height : null);
			if ($over)
				$over = rosemary_get_resized_image_url($over, (int) $width > 0 && rosemary_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && rosemary_substr($height, -2, 2)=='px' ? (int) $height : null);
		}
		if ($bg_image > 0) {
			$attach = wp_get_attachment_image_src( $bg_image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$bg_image = $attach[0];
		}
		if ($bg_image) {
			$css_bg .= $css . 'background-image: url('.esc_url($bg_image).');';
			$css = $css_dim;
		} else {
			$css .= $css_dim;
		}
		$output = empty($src) 
				? '' 
				: (
					(!empty($bg_image) 
						? '<div class="sc_zoom_wrap'
								. (!empty($class) ? ' '.esc_attr($class) : '')
								. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
								. '"'
							. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
							. ($css_bg!='' ? ' style="'.esc_attr($css_bg).'"' : '') 
							. '>' 
						: '')
					.'<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_zoom' 
								. (empty($bg_image) && !empty($class) ? ' '.esc_attr($class) : '') 
								. (empty($bg_image) && $align && $align!='none' ? ' align'.esc_attr($align) : '')
								. '"'
							. (empty($bg_image) && !rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
							. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
							. '>'
							. '<img src="'.esc_url($src).'"' . ($css_dim!='' ? ' style="'.esc_attr($css_dim).'"' : '') . ' data-zoom-image="'.esc_url($over).'" alt="" />'
					. '</div>'
					. (!empty($bg_image) 
						? '</div>' 
						: '')
				);
		return apply_filters('rosemary_shortcode_output', $output, 'trx_zoom', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_zoom', 'rosemary_sc_zoom');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_zoom_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_zoom_reg_shortcodes');
	function rosemary_sc_zoom_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_zoom"] = array(
			"title" => esc_html__("Zoom", "rosemary"),
			"desc" => wp_kses( __("Insert the image with zoom/lens effect", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"effect" => array(
					"title" => esc_html__("Effect", "rosemary"),
					"desc" => wp_kses( __("Select effect to display overlapping image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "lens",
					"size" => "medium",
					"type" => "switch",
					"options" => array(
						"lens" => esc_html__('Lens', 'rosemary'),
						"zoom" => esc_html__('Zoom', 'rosemary')
					)
				),
				"url" => array(
					"title" => esc_html__("Main image", "rosemary"),
					"desc" => wp_kses( __("Select or upload main image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"over" => array(
					"title" => esc_html__("Overlaping image", "rosemary"),
					"desc" => wp_kses( __("Select or upload overlaping image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"align" => array(
					"title" => esc_html__("Float zoom", "rosemary"),
					"desc" => wp_kses( __("Float zoom to left or right side", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['float']
				), 
				"bg_image" => array(
					"title" => esc_html__("Background image", "rosemary"),
					"desc" => wp_kses( __("Select or upload image or write URL from other site for zoom block background. Attention! If you use background image - specify paddings below from background margins to zoom block in percents!", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"bg_top" => array(
					"title" => esc_html__("Top offset", "rosemary"),
					"desc" => wp_kses( __("Top offset (padding) inside background image to zoom block (in percent). For example: 3%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_bottom" => array(
					"title" => esc_html__("Bottom offset", "rosemary"),
					"desc" => wp_kses( __("Bottom offset (padding) inside background image to zoom block (in percent). For example: 3%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_left" => array(
					"title" => esc_html__("Left offset", "rosemary"),
					"desc" => wp_kses( __("Left offset (padding) inside background image to zoom block (in percent). For example: 20%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_right" => array(
					"title" => esc_html__("Right offset", "rosemary"),
					"desc" => wp_kses( __("Right offset (padding) inside background image to zoom block (in percent). For example: 12%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'bg_image' => array('not_empty')
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
if ( !function_exists( 'rosemary_sc_zoom_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_zoom_reg_shortcodes_vc');
	function rosemary_sc_zoom_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_zoom",
			"name" => esc_html__("Zoom", "rosemary"),
			"description" => wp_kses( __("Insert the image with zoom/lens effect", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_zoom',
			"class" => "trx_sc_single trx_sc_zoom",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "effect",
					"heading" => esc_html__("Effect", "rosemary"),
					"description" => wp_kses( __("Select effect to display overlapping image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"std" => "zoom",
					"value" => array(
						esc_html__('Lens', 'rosemary') => 'lens',
						esc_html__('Zoom', 'rosemary') => 'zoom'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Main image", "rosemary"),
					"description" => wp_kses( __("Select or upload main image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "over",
					"heading" => esc_html__("Overlaping image", "rosemary"),
					"description" => wp_kses( __("Select or upload overlaping image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", "rosemary"),
					"description" => wp_kses( __("Float zoom to left or right side", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['float']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "bg_image",
					"heading" => esc_html__("Background image", "rosemary"),
					"description" => wp_kses( __("Select or upload image or write URL from other site for zoom background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Background', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "bg_top",
					"heading" => esc_html__("Top offset", "rosemary"),
					"description" => wp_kses( __("Top offset (padding) from background image to zoom block (in percent). For example: 3%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Background', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_bottom",
					"heading" => esc_html__("Bottom offset", "rosemary"),
					"description" => wp_kses( __("Bottom offset (padding) from background image to zoom block (in percent). For example: 3%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Background', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_left",
					"heading" => esc_html__("Left offset", "rosemary"),
					"description" => wp_kses( __("Left offset (padding) from background image to zoom block (in percent). For example: 20%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Background', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_right",
					"heading" => esc_html__("Right offset", "rosemary"),
					"description" => wp_kses( __("Right offset (padding) from background image to zoom block (in percent). For example: 12%", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Background', 'rosemary'),
					"class" => "",
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Zoom extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>