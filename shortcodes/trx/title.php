<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_title_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_title_theme_setup' );
	function rosemary_sc_title_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_title_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_title_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/

if (!function_exists('rosemary_sc_title')) {
	function rosemary_sc_title($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "1",
			"style" => "regular",
			"align" => "",
			"font_weight" => "",
			"font_size" => "",
			"color" => "",
			"icon" => "",
			"image" => "",
			"picture" => "",
			"image_size" => "small",
			"position" => "left",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= rosemary_get_css_dimensions_from_values($width)
			.($align && $align!='none' && !rosemary_param_is_inherit($align) ? 'text-align:' . esc_attr($align) .';' : '')
			.($color ? 'color:' . esc_attr($color) .';' : '')
			.($font_weight && !rosemary_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) .';' : '')
			.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
			;
		$type = min(6, max(1, $type));
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic = $style!='iconed' 
			? '' 
			: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(rosemary_strpos($image, 'http:')!==false ? $image : rosemary_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';
		$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_title sc_title_'.esc_attr($style)
					.($align && $align!='none' && !rosemary_param_is_inherit($align) ? ' sc_align_' . esc_attr($align) : '')
					.(!empty($class) ? ' '.esc_attr($class) : '')
					.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. '>'
					. ($pic)
					. do_shortcode($content) 
					. ($style=='divider' ? '<span class="sc_title_divider_after">'.esc_attr('//').'</span>' : '')
				. '</h' . esc_attr($type) . '>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_title', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_title', 'rosemary_sc_title');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_title_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_title_reg_shortcodes');
	function rosemary_sc_title_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_title"] = array(
			"title" => esc_html__("Title", "rosemary"),
			"desc" => wp_kses( __("Create header tag (1-6 level) with many styles", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Title content", "rosemary"),
					"desc" => wp_kses( __("Title content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"type" => array(
					"title" => esc_html__("Title type", "rosemary"),
					"desc" => wp_kses( __("Title type (header level)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "1",
					"type" => "select",
					"options" => array(
						'1' => esc_html__('Header 1', 'rosemary'),
						'2' => esc_html__('Header 2', 'rosemary'),
						'3' => esc_html__('Header 3', 'rosemary'),
						'4' => esc_html__('Header 4', 'rosemary'),
						'5' => esc_html__('Header 5', 'rosemary'),
						'6' => esc_html__('Header 6', 'rosemary'),
					)
				),
				"style" => array(
					"title" => esc_html__("Title style", "rosemary"),
					"desc" => wp_kses( __("Title style", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "regular",
					"type" => "select",
					"options" => array(
						'regular' => esc_html__('Regular', 'rosemary'),
						'underline' => esc_html__('Underline', 'rosemary'),
						'divider' => esc_html__('Divider', 'rosemary'),
						'iconed' => esc_html__('With icon (image)', 'rosemary')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", "rosemary"),
					"desc" => wp_kses( __("Title text alignment", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['align']
				), 
				"font_size" => array(
					"title" => esc_html__("Font_size", "rosemary"),
					"desc" => wp_kses( __("Custom font size. If empty - use theme default", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", "rosemary"),
					"desc" => wp_kses( __("Custom font weight. If empty or inherit - use theme default", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'inherit' => esc_html__('Default', 'rosemary'),
						'100' => esc_html__('Thin (100)', 'rosemary'),
						'300' => esc_html__('Light (300)', 'rosemary'),
						'400' => esc_html__('Normal (400)', 'rosemary'),
						'600' => esc_html__('Semibold (600)', 'rosemary'),
						'700' => esc_html__('Bold (700)', 'rosemary'),
						'900' => esc_html__('Black (900)', 'rosemary')
					)
				),
				"color" => array(
					"title" => esc_html__("Title color", "rosemary"),
					"desc" => wp_kses( __("Select color for the title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Title font icon',  'rosemary'),
					"desc" => wp_kses( __("Select font icon for the title from Fontello icons set (if style=iconed)",  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
				),
				"image" => array(
					"title" => esc_html__('or image icon',  'rosemary'),
					"desc" => wp_kses( __("Select image icon for the title instead icon above (if style=iconed)",  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "images",
					"size" => "small",
					"options" => $ROSEMARY_GLOBALS['sc_params']['images']
				),
				"picture" => array(
					"title" => esc_html__('or URL for image file', "rosemary"),
					"desc" => wp_kses( __("Select or upload image or write URL from other site (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_size" => array(
					"title" => esc_html__('Image (picture) size', "rosemary"),
					"desc" => wp_kses( __("Select image (picture) size (if style='iconed')", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "small",
					"type" => "checklist",
					"options" => array(
						'small' => esc_html__('Small', 'rosemary'),
						'medium' => esc_html__('Medium', 'rosemary'),
						'large' => esc_html__('Large', 'rosemary')
					)
				),
				"position" => array(
					"title" => esc_html__('Icon (image) position', "rosemary"),
					"desc" => wp_kses( __("Select icon (image) position (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "left",
					"type" => "checklist",
					"options" => array(
						'top' => esc_html__('Top', 'rosemary'),
						'left' => esc_html__('Left', 'rosemary')
					)
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
if ( !function_exists( 'rosemary_sc_title_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_title_reg_shortcodes_vc');
	function rosemary_sc_title_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_title",
			"name" => esc_html__("Title", "rosemary"),
			"description" => wp_kses( __("Create header tag (1-6 level) with many styles", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_title',
			"class" => "trx_sc_single trx_sc_title",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Title content", "rosemary"),
					"description" => wp_kses( __("Title content", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Title type", "rosemary"),
					"description" => wp_kses( __("Title type (header level)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Header 1', 'rosemary') => '1',
						esc_html__('Header 2', 'rosemary') => '2',
						esc_html__('Header 3', 'rosemary') => '3',
						esc_html__('Header 4', 'rosemary') => '4',
						esc_html__('Header 5', 'rosemary') => '5',
						esc_html__('Header 6', 'rosemary') => '6'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Title style", "rosemary"),
					"description" => wp_kses( __("Title style: only text (regular) or with icon/image (iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'rosemary') => 'regular',
						esc_html__('Underline', 'rosemary') => 'underline',
						esc_html__('Divider', 'rosemary') => 'divider',
						esc_html__('With icon (image)', 'rosemary') => 'iconed'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", "rosemary"),
					"description" => wp_kses( __("Title text alignment", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['align']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", "rosemary"),
					"description" => wp_kses( __("Custom font size. If empty - use theme default", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", "rosemary"),
					"description" => wp_kses( __("Custom font weight. If empty or inherit - use theme default", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'rosemary') => 'inherit',
						esc_html__('Thin (100)', 'rosemary') => '100',
						esc_html__('Light (300)', 'rosemary') => '300',
						esc_html__('Normal (400)', 'rosemary') => '400',
						esc_html__('Semibold (600)', 'rosemary') => '600',
						esc_html__('Bold (700)', 'rosemary') => '700',
						esc_html__('Black (900)', 'rosemary') => '900'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Title color", "rosemary"),
					"description" => wp_kses( __("Select color for the title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title font icon", "rosemary"),
					"description" => wp_kses( __("Select font icon for the title from Fontello icons set (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'rosemary'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("or image icon", "rosemary"),
					"description" => wp_kses( __("Select image icon for the title instead icon above (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'rosemary'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => $ROSEMARY_GLOBALS['sc_params']['images'],
					"type" => "dropdown"
				),
				array(
					"param_name" => "picture",
					"heading" => esc_html__("or select uploaded image", "rosemary"),
					"description" => wp_kses( __("Select or upload image or write URL from other site (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Icon &amp; Image', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_size",
					"heading" => esc_html__("Image (picture) size", "rosemary"),
					"description" => wp_kses( __("Select image (picture) size (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Icon &amp; Image', 'rosemary'),
					"class" => "",
					"value" => array(
						esc_html__('Small', 'rosemary') => 'small',
						esc_html__('Medium', 'rosemary') => 'medium',
						esc_html__('Large', 'rosemary') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Icon (image) position", "rosemary"),
					"description" => wp_kses( __("Select icon (image) position (if style=iconed)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Icon &amp; Image', 'rosemary'),
					"class" => "",
					"value" => array(
						esc_html__('Top', 'rosemary') => 'top',
						esc_html__('Left', 'rosemary') => 'left'
					),
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
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Title extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>