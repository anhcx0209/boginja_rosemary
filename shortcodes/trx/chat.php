<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_chat_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_chat_theme_setup' );
	function rosemary_sc_chat_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_chat_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_chat_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_chat id="unique_id" link="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_chat]
[trx_chat id="unique_id" link="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_chat]
...
*/

if (!function_exists('rosemary_sc_chat')) {
	function rosemary_sc_chat($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"photo" => "",
			"title" => "",
			"link" => "",
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
		$css .= rosemary_get_css_dimensions_from_values($width, $height);
		$title = $title=='' ? $link : $title;
		if (!empty($photo)) {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = rosemary_get_resized_image_tag($photo, 75, 75);
		}
		$content = do_shortcode($content);
		if (rosemary_substr($content, 0, 2)!='<p') $content = '<p>' . ($content) . '</p>';
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_chat' . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. ($css ? ' style="'.esc_attr($css).'"' : '') 
				. '>'
					. '<div class="sc_chat_inner">'
						. ($photo ? '<div class="sc_chat_avatar">'.($photo).'</div>' : '')
						. ($title == '' ? '' : ('<div class="sc_chat_content_wrap"><div class="sc_chat_title">' . ($link!='' ? '<a href="'.esc_url($link).'">' : '') . ($title) . ($link!='' ? '</a>' : '') . '</div>'))
						. '<div class="sc_chat_content">'.($content).'</div>'
					. '</div>
					</div>'
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_chat', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_chat', 'rosemary_sc_chat');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_chat_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_chat_reg_shortcodes');
	function rosemary_sc_chat_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_chat"] = array(
			"title" => esc_html__("Chat", "rosemary"),
			"desc" => wp_kses( __("Chat message", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Item title", "rosemary"),
					"desc" => wp_kses( __("Chat item title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"photo" => array(
					"title" => esc_html__("Item photo", "rosemary"),
					"desc" => wp_kses( __("Select or upload image or write URL from other site for the item photo (avatar)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"link" => array(
					"title" => esc_html__("Item link", "rosemary"),
					"desc" => wp_kses( __("Chat item link", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Chat item content", "rosemary"),
					"desc" => wp_kses( __("Current chat item content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
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
if ( !function_exists( 'rosemary_sc_chat_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_chat_reg_shortcodes_vc');
	function rosemary_sc_chat_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_chat",
			"name" => esc_html__("Chat", "rosemary"),
			"description" => wp_kses( __("Chat message", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_chat',
			"class" => "trx_sc_container trx_sc_chat",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Item title", "rosemary"),
					"description" => wp_kses( __("Title for current chat item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "photo",
					"heading" => esc_html__("Item photo", "rosemary"),
					"description" => wp_kses( __("Select or upload image or write URL from other site for the item photo (avatar)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", "rosemary"),
					"description" => wp_kses( __("URL for the link on chat title click", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Chat item content", "rosemary"),
					"description" => wp_kses( __("Current chat item content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				*/
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
			'js_view' => 'VcTrxTextContainerView'
		
		) );
		
		class WPBakeryShortCode_Trx_Chat extends ROSEMARY_VC_ShortCodeContainer {}
	}
}
?>