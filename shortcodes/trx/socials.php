<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_socials_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_socials_theme_setup' );
	function rosemary_sc_socials_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_socials_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_socials_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_socials id="unique_id" size="small"]
	[trx_social_item name="facebook" url="profile url" icon="path for the icon"]
	[trx_social_item name="twitter" url="profile url"]
[/trx_socials]
*/

if (!function_exists('rosemary_sc_socials')) {
	function rosemary_sc_socials($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"size" => "small",		// tiny | small | medium | large
			"shape" => "square",	// round | square
			"type" => rosemary_get_theme_setting('socials_type'),	// icons | images
			"socials" => "",
			"custom" => "no",
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
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_social_icons'] = false;
		$ROSEMARY_GLOBALS['sc_social_type'] = $type;
		if (!empty($socials)) {
			$allowed = explode('|', $socials);
			$list = array();
			for ($i=0; $i<count($allowed); $i++) {
				$s = explode('=', $allowed[$i]);
				if (!empty($s[1])) {
					$list[] = array(
						'icon'	=> $type=='images' ? rosemary_get_socials_url($s[0]) : 'icon-'.$s[0],
						'url'	=> $s[1]
						);
				}
			}
			if (count($list) > 0) $ROSEMARY_GLOBALS['sc_social_icons'] = $list;
		} else if (rosemary_param_is_off($custom))
			$content = do_shortcode($content);
		if ($ROSEMARY_GLOBALS['sc_social_icons']===false) $ROSEMARY_GLOBALS['sc_social_icons'] = rosemary_get_custom_option('social_icons');
		$output = rosemary_prepare_socials($ROSEMARY_GLOBALS['sc_social_icons']);
		$output = $output
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_socials sc_socials_type_' . esc_attr($type) . ' sc_socials_shape_' . esc_attr($shape) . ' sc_socials_size_' . esc_attr($size) . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. '>' 
				. ($output)
				. '</div>'
			: '';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_socials', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_socials', 'rosemary_sc_socials');
}


if (!function_exists('rosemary_sc_social_item')) {
	function rosemary_sc_social_item($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"name" => "",
			"url" => "",
			"icon" => ""
		), $atts)));
		global $ROSEMARY_GLOBALS;
		if (!empty($name) && empty($icon)) {
			$type = $ROSEMARY_GLOBALS['sc_social_type'];
			if ($type=='images') {
				if (file_exists(rosemary_get_socials_dir($name.'.png')))
					$icon = rosemary_get_socials_url($name.'.png');
			} else
				$icon = 'icon-'.esc_attr($name);
		}
		if (!empty($icon) && !empty($url)) {
			if ($ROSEMARY_GLOBALS['sc_social_icons']===false) $ROSEMARY_GLOBALS['sc_social_icons'] = array();
			$ROSEMARY_GLOBALS['sc_social_icons'][] = array(
				'icon' => $icon,
				'url' => $url
			);
		}
		return '';
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_social_item', 'rosemary_sc_social_item');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_socials_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_socials_reg_shortcodes');
	function rosemary_sc_socials_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_socials"] = array(
			"title" => esc_html__("Social icons", "rosemary"),
			"desc" => wp_kses( __("List of social icons (with hovers)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Icon's type", "rosemary"),
					"desc" => wp_kses( __("Type of the icons - images or font icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => rosemary_get_theme_setting('socials_type'),
					"options" => array(
						'icons' => esc_html__('Icons', 'rosemary'),
						'images' => esc_html__('Images', 'rosemary')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Icon's size", "rosemary"),
					"desc" => wp_kses( __("Size of the icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "small",
					"options" => $ROSEMARY_GLOBALS['sc_params']['sizes'],
					"type" => "checklist"
				), 
				"shape" => array(
					"title" => esc_html__("Icon's shape", "rosemary"),
					"desc" => wp_kses( __("Shape of the icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "square",
					"options" => $ROSEMARY_GLOBALS['sc_params']['shapes'],
					"type" => "checklist"
				), 
				"socials" => array(
					"title" => esc_html__("Manual socials list", "rosemary"),
					"desc" => wp_kses( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"custom" => array(
					"title" => esc_html__("Custom socials", "rosemary"),
					"desc" => wp_kses( __("Make custom icons from inner shortcodes (prepare it on tabs)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "no",
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
			),
			"children" => array(
				"name" => "trx_social_item",
				"title" => esc_html__("Custom social item", "rosemary"),
				"desc" => wp_kses( __("Custom social item: name, profile url and icon url", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"name" => array(
						"title" => esc_html__("Social name", "rosemary"),
						"desc" => wp_kses( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"url" => array(
						"title" => esc_html__("Your profile URL", "rosemary"),
						"desc" => wp_kses( __("URL of your profile in specified social network", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"icon" => array(
						"title" => esc_html__("URL (source) for icon file", "rosemary"),
						"desc" => wp_kses( __("Select or upload image or write URL from other site for the current social icon", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					)
				)
			)
		);
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_socials_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_socials_reg_shortcodes_vc');
	function rosemary_sc_socials_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_socials",
			"name" => esc_html__("Social icons", "rosemary"),
			"description" => wp_kses( __("Custom social icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_socials',
			"class" => "trx_sc_collection trx_sc_socials",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_social_item'),
			"params" => array_merge(array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Icon's type", "rosemary"),
					"description" => wp_kses( __("Type of the icons - images or font icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"std" => rosemary_get_theme_setting('socials_type'),
					"value" => array(
						esc_html__('Icons', 'rosemary') => 'icons',
						esc_html__('Images', 'rosemary') => 'images'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Icon's size", "rosemary"),
					"description" => wp_kses( __("Size of the icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"std" => "small",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['sizes']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "shape",
					"heading" => esc_html__("Icon's shape", "rosemary"),
					"description" => wp_kses( __("Shape of the icons", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"std" => "square",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['shapes']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "socials",
					"heading" => esc_html__("Manual socials list", "rosemary"),
					"description" => wp_kses( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom socials", "rosemary"),
					"description" => wp_kses( __("Make custom icons from inner shortcodes (prepare it on tabs)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(esc_html__('Custom socials', 'rosemary') => 'yes'),
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
			))
		) );
		
		
		vc_map( array(
			"base" => "trx_social_item",
			"name" => esc_html__("Custom social item", "rosemary"),
			"description" => wp_kses( __("Custom social item: name, profile url and icon url", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => false,
			'icon' => 'icon_trx_social_item',
			"class" => "trx_sc_single trx_sc_social_item",
			"as_child" => array('only' => 'trx_socials'),
			"as_parent" => array('except' => 'trx_socials'),
			"params" => array(
				array(
					"param_name" => "name",
					"heading" => esc_html__("Social name", "rosemary"),
					"description" => wp_kses( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Your profile URL", "rosemary"),
					"description" => wp_kses( __("URL of your profile in specified social network", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("URL (source) for icon file", "rosemary"),
					"description" => wp_kses( __("Select or upload image or write URL from other site for the current social icon", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Socials extends ROSEMARY_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Social_Item extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>