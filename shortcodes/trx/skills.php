<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_skills_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_skills_theme_setup' );
	function rosemary_sc_skills_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_skills_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_skills_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_skills id="unique_id" type="bar|pie|arc|counter" dir="horizontal|vertical" layout="rows|columns" count="" max_value="100" align="left|right"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
[/trx_skills]
*/

if (!function_exists('rosemary_sc_skills')) {
	function rosemary_sc_skills($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"max_value" => "100",
			"type" => "bar",
			"layout" => "",
			"dir" => "",
			"style" => "1",
			"columns" => "",
			"align" => "",
			"color" => "",
			"bg_color" => "",
			"border_color" => "",
			"arc_caption" => esc_html__("Skills", "rosemary"),
			"pie_compact" => "on",
			"pie_cutout" => 0,
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'rosemary'),
			"link" => '',
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
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_skills_counter'] = 0;
		$ROSEMARY_GLOBALS['sc_skills_columns'] = 0;
		$ROSEMARY_GLOBALS['sc_skills_height']  = 0;
		$ROSEMARY_GLOBALS['sc_skills_type']    = $type;
		$ROSEMARY_GLOBALS['sc_skills_pie_compact'] = $pie_compact;
		$ROSEMARY_GLOBALS['sc_skills_pie_cutout']  = max(0, min(99, $pie_cutout));
		$ROSEMARY_GLOBALS['sc_skills_color']   = $color;
		$ROSEMARY_GLOBALS['sc_skills_bg_color']= $bg_color;
		$ROSEMARY_GLOBALS['sc_skills_border_color']= $border_color;
		$ROSEMARY_GLOBALS['sc_skills_legend']  = '';
		$ROSEMARY_GLOBALS['sc_skills_data']    = '';
		rosemary_enqueue_diagram($type);
		if ($type!='arc') {
			if ($layout=='' || ($layout=='columns' && $columns<1)) $layout = 'rows';
			if ($layout=='columns') $ROSEMARY_GLOBALS['sc_skills_columns'] = $columns;
			if ($type=='bar') {
				if ($dir == '') $dir = 'horizontal';
				if ($dir == 'vertical' && $height < 1) $height = 300;
			}
		}
		if (empty($id)) $id = 'sc_skills_diagram_'.str_replace('.','',mt_rand());
		if ($max_value < 1) $max_value = 100;
		if ($style) {
			$style = max(1, min(4, $style));
			$ROSEMARY_GLOBALS['sc_skills_style'] = $style;
		}
		$ROSEMARY_GLOBALS['sc_skills_max'] = $max_value;
		$ROSEMARY_GLOBALS['sc_skills_dir'] = $dir;
		$ROSEMARY_GLOBALS['sc_skills_height'] = rosemary_prepare_css_value($height);
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= rosemary_get_css_dimensions_from_values($width);
		if (!empty($ROSEMARY_GLOBALS['sc_skills_height']) && ($ROSEMARY_GLOBALS['sc_skills_type'] == 'arc' || ($ROSEMARY_GLOBALS['sc_skills_type'] == 'pie' && rosemary_param_is_on($ROSEMARY_GLOBALS['sc_skills_pie_compact']))))
			$css .= 'height: '.$ROSEMARY_GLOBALS['sc_skills_height'];
		$content = do_shortcode($content);
		$output = '<div id="'.esc_attr($id).'"' 
					. ' class="sc_skills sc_skills_' . esc_attr($type) 
						. ($type=='bar' ? ' sc_skills_'.esc_attr($dir) : '') 
						. ($type=='pie' ? ' sc_skills_compact_'.esc_attr($pie_compact) : '') 
						. (!empty($class) ? ' '.esc_attr($class) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
					. ' data-type="'.esc_attr($type).'"'
					. ' data-caption="'.esc_attr($arc_caption).'"'
					. ($type=='bar' ? ' data-dir="'.esc_attr($dir).'"' : '')
				. '>'
					. (!empty($subtitle) ? '<h6 class="sc_skills_subtitle sc_item_subtitle">' . esc_html($subtitle) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_skills_title sc_item_title">' . esc_html($title) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_skills_descr sc_item_descr">' . trim($description) . '</div>' : '')
					. ($layout == 'columns' ? '<div class="columns_wrap sc_skills_'.esc_attr($layout).' sc_skills_columns_'.esc_attr($columns).'">' : '')
					. ($type=='arc' 
						? ('<div class="sc_skills_legend">'.($ROSEMARY_GLOBALS['sc_skills_legend']).'</div>'
							. '<div id="'.esc_attr($id).'_diagram" class="sc_skills_arc_canvas"></div>'
							. '<div class="sc_skills_data" style="display:none;">' . ($ROSEMARY_GLOBALS['sc_skills_data']) . '</div>'
						  )
						: '')
					. ($type=='pie' && rosemary_param_is_on($pie_compact)
						? ('<div class="sc_skills_legend">'.($ROSEMARY_GLOBALS['sc_skills_legend']).'</div>'
							. '<div id="'.esc_attr($id).'_pie" class="sc_skills_item">'
								. '<canvas id="'.esc_attr($id).'_pie" class="sc_skills_pie_canvas"></canvas>'
								. '<div class="sc_skills_data" style="display:none;">' . ($ROSEMARY_GLOBALS['sc_skills_data']) . '</div>'
							. '</div>'
						  )
						: '')
					. ($content)
					. ($layout == 'columns' ? '</div>' : '')
					. (!empty($link) ? '<div class="sc_skills_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
				. '</div>';
		return apply_filters('rosemary_shortcode_output', $output, 'trx_skills', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_skills', 'rosemary_sc_skills');
}


if (!function_exists('rosemary_sc_skills_item')) {
	function rosemary_sc_skills_item($atts, $content=null) {
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts( array(
			// Individual params
			"title" => "",
			"value" => "",
			"color" => "",
			"bg_color" => "",
			"border_color" => "",
			"style" => "",
			"icon" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_skills_counter']++;
		$ed = rosemary_substr($value, -1)=='%' ? '%' : '';
		$value_pie = $value;
		$value = str_replace('%', '', $value);
		if ($ROSEMARY_GLOBALS['sc_skills_max'] < $value) $ROSEMARY_GLOBALS['sc_skills_max'] = $value;
		$percent = round($value / $ROSEMARY_GLOBALS['sc_skills_max'] * 100);
		$start = 0;
		$stop = $value;
		$steps = 100;
		$step = max(1, round($ROSEMARY_GLOBALS['sc_skills_max']/$steps));
		$speed = mt_rand(10,40);
		$animation = round(($stop - $start) / $step * $speed);
		$title_block = '<div class="sc_skills_info">'.($ROSEMARY_GLOBALS['sc_skills_type']=='counter' ? '<span class="sc_title_divider_after">'.esc_attr('//').'</span>' : '') .'<div class="sc_skills_label">' . ($title) . '</div></div>';
		$old_color = $color;
		if (empty($color)) $color = $ROSEMARY_GLOBALS['sc_skills_color'];
		if (empty($color)) $color = rosemary_get_scheme_color('accent1', $color);
		if (empty($bg_color)) $bg_color = $ROSEMARY_GLOBALS['sc_skills_bg_color'];
		if (empty($bg_color)) $bg_color = rosemary_get_scheme_color('bg_color', $bg_color);
		if (empty($border_color)) $border_color = $ROSEMARY_GLOBALS['sc_skills_border_color'];
		if (empty($border_color)) $border_color = rosemary_get_scheme_color('bd_color', $border_color);;
		if (empty($style)) $style = $ROSEMARY_GLOBALS['sc_skills_style'];
		$style = max(1, min(4, $style));
		$output = '';
		if ($ROSEMARY_GLOBALS['sc_skills_type'] == 'arc' || ($ROSEMARY_GLOBALS['sc_skills_type'] == 'pie' && rosemary_param_is_on($ROSEMARY_GLOBALS['sc_skills_pie_compact']))) {
			if ($ROSEMARY_GLOBALS['sc_skills_type'] == 'arc' && empty($old_color)) {
				$rgb = rosemary_hex2rgb($color);
				$color = 'rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.(1 - 0.1*($ROSEMARY_GLOBALS['sc_skills_counter']-1)).')';
			}
			$ROSEMARY_GLOBALS['sc_skills_legend'] .= '<div class="sc_skills_legend_item"><span class="sc_skills_legend_marker" style="background-color:'.esc_attr($color).'"></span><span class="sc_skills_legend_title">' . ($title) . '</span><span class="sc_skills_legend_value">' . ($ROSEMARY_GLOBALS['sc_skills_type'] == 'pie' ? esc_attr($value_pie) : esc_attr($value) ). '</span></div>';
			$ROSEMARY_GLOBALS['sc_skills_data'] .= '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_type']).'"'
				. ($ROSEMARY_GLOBALS['sc_skills_type']=='pie'
					? ( ' data-start="'.esc_attr($start).'"'
						. ' data-stop="'.esc_attr($stop).'"'
						. ' data-step="'.esc_attr($step).'"'
						. ' data-steps="'.esc_attr($steps).'"'
						. ' data-max="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_max']).'"'
						. ' data-speed="'.esc_attr($speed).'"'
						. ' data-duration="'.esc_attr($animation).'"'
						. ' data-color="'.esc_attr($color).'"'
						. ' data-bg_color="'.esc_attr($bg_color).'"'
						. ' data-border_color="'.esc_attr($border_color).'"'
						. ' data-cutout="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_pie_cutout']).'"'
						. ' data-easing="easeOutCirc"'
						. ' data-ed="'.esc_attr($ed).'"'
						)
					: '')
				. '><input type="hidden" class="text" value="'.esc_attr($title).'" /><input type="hidden" class="percent" value="'.esc_attr($percent).'" /><input type="hidden" class="color" value="'.esc_attr($color).'" /></div>';
		} else {
			$output .= ($ROSEMARY_GLOBALS['sc_skills_columns'] > 0 ? '<div class="sc_skills_column column-1_'.esc_attr($ROSEMARY_GLOBALS['sc_skills_columns']).'">' : '')
					. ($ROSEMARY_GLOBALS['sc_skills_type']=='bar' && $ROSEMARY_GLOBALS['sc_skills_dir']=='horizontal' ? $title_block : '')
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_skills_item' . ($style ? ' sc_skills_style_'.esc_attr($style) : '') 
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($ROSEMARY_GLOBALS['sc_skills_counter'] % 2 == 1 ? ' odd' : ' even')
							. ($ROSEMARY_GLOBALS['sc_skills_counter'] == 1 ? ' first' : '')
							. '"'
						. ($ROSEMARY_GLOBALS['sc_skills_height'] !='' || $css
							? ' style="' 
								. ($ROSEMARY_GLOBALS['sc_skills_height'] !='' ? 'height: '.esc_attr($ROSEMARY_GLOBALS['sc_skills_height']).';' : '')
								. ($css) 
								. '"' 
							: '')
					. '>'
					. (!empty($icon) ? '<div class="sc_skills_icon '.esc_attr($icon).'"></div>' : '');
			if (in_array($ROSEMARY_GLOBALS['sc_skills_type'], array('bar', 'counter'))) {
				$output .= '<div class="sc_skills_count"' . ($ROSEMARY_GLOBALS['sc_skills_type']=='bar' && $color ? ' style="background-color:' . esc_attr($color) . '; border-color:' . esc_attr($color) . '"' : '') . '>'
							. '</div>'
							. '<div class="sc_skills_total"'
								. ' data-start="'.esc_attr($start).'"'
								. ' data-stop="'.esc_attr($stop).'"'
								. ' data-step="'.esc_attr($step).'"'
								. ' data-max="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_max']).'"'
								. ' data-speed="'.esc_attr($speed).'"'
								. ' data-duration="'.esc_attr($animation).'"'
								. ' data-ed="'.esc_attr($ed).'">'
								. ($start) . ($ed)
							.'</div>';
			} else if ($ROSEMARY_GLOBALS['sc_skills_type']=='pie') {
				if (empty($id)) $id = 'sc_skills_canvas_'.str_replace('.','',mt_rand());
				$output .= '<canvas id="'.esc_attr($id).'"></canvas>'
					. '<div class="sc_skills_total"'
						. ' data-start="'.esc_attr($start).'"'
						. ' data-stop="'.esc_attr($stop).'"'
						. ' data-step="'.esc_attr($step).'"'
						. ' data-steps="'.esc_attr($steps).'"'
						. ' data-max="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_max']).'"'
						. ' data-speed="'.esc_attr($speed).'"'
						. ' data-duration="'.esc_attr($animation).'"'
						. ' data-color="'.esc_attr($color).'"'
						. ' data-bg_color="'.esc_attr($bg_color).'"'
						. ' data-border_color="'.esc_attr($border_color).'"'
						. ' data-cutout="'.esc_attr($ROSEMARY_GLOBALS['sc_skills_pie_cutout']).'"'
						. ' data-easing="easeOutCirc"'
						. ' data-ed="'.esc_attr($ed).'">'
						. ($start) . ($ed)
					.'</div>';
			}
			$output .= 
					  ($ROSEMARY_GLOBALS['sc_skills_type']=='counter' ? $title_block : '')
					. '</div>'
					. ($ROSEMARY_GLOBALS['sc_skills_type']=='bar' && $ROSEMARY_GLOBALS['sc_skills_dir']=='vertical' || $ROSEMARY_GLOBALS['sc_skills_type'] == 'pie' ? $title_block : '')
					. ($ROSEMARY_GLOBALS['sc_skills_columns'] > 0 ? '</div>' : '');
		}
		return apply_filters('rosemary_shortcode_output', $output, 'trx_skills_item', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_skills_item', 'rosemary_sc_skills_item');
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_skills_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_skills_reg_shortcodes');
	function rosemary_sc_skills_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		$ROSEMARY_GLOBALS['shortcodes']["trx_skills"] = array(
			"title" => esc_html__("Skills", "rosemary"),
			"desc" => wp_kses( __("Insert skills diagramm in your page (post)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"max_value" => array(
					"title" => esc_html__("Max value", "rosemary"),
					"desc" => wp_kses( __("Max value for skills items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => 100,
					"min" => 1,
					"type" => "spinner"
				),
				"type" => array(
					"title" => esc_html__("Skills type", "rosemary"),
					"desc" => wp_kses( __("Select type of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "bar",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'bar' => esc_html__('Bar', 'rosemary'),
						'pie' => esc_html__('Pie chart', 'rosemary'),
						'counter' => esc_html__('Counter', 'rosemary'),
						'arc' => esc_html__('Arc', 'rosemary')
					)
				), 
				"layout" => array(
					"title" => esc_html__("Skills layout", "rosemary"),
					"desc" => wp_kses( __("Select layout of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('counter','pie','bar')
					),
					"value" => "rows",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'rows' => esc_html__('Rows', 'rosemary'),
						'columns' => esc_html__('Columns', 'rosemary')
					)
				),
				"dir" => array(
					"title" => esc_html__("Direction", "rosemary"),
					"desc" => wp_kses( __("Select direction of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('counter','pie','bar')
					),
					"value" => "horizontal",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['dir']
				), 
				"style" => array(
					"title" => esc_html__("Counters style", "rosemary"),
					"desc" => wp_kses( __("Select style of skills items (only for type=counter)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('counter')
					),
					"value" => 1,
					"options" => rosemary_get_list_styles(1, 4),
					"type" => "checklist"
				), 
				// "columns" - autodetect, not set manual
				"color" => array(
					"title" => esc_html__("Skills items color", "rosemary"),
					"desc" => wp_kses( __("Color for all skills items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", "rosemary"),
					"desc" => wp_kses( __("Background color for all skills items (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "",
					"type" => "color"
				),
				"border_color" => array(
					"title" => esc_html__("Border color", "rosemary"),
					"desc" => wp_kses( __("Border color for all skills items (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Align skills block", "rosemary"),
					"desc" => wp_kses( __("Align skills block to left or right side", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => $ROSEMARY_GLOBALS['sc_params']['float']
				), 
				"arc_caption" => array(
					"title" => esc_html__("Arc Caption", "rosemary"),
					"desc" => wp_kses( __("Arc caption - text in the center of the diagram", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('arc')
					),
					"value" => "",
					"type" => "text"
				),
				"pie_compact" => array(
					"title" => esc_html__("Pie compact", "rosemary"),
					"desc" => wp_kses( __("Show all skills in one diagram or as separate diagrams", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "no",
					"type" => "switch",
					"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
				),
				"pie_cutout" => array(
					"title" => esc_html__("Pie cutout", "rosemary"),
					"desc" => wp_kses( __("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => 0,
					"min" => 0,
					"max" => 99,
					"type" => "spinner"
				),
				"title" => array(
					"title" => esc_html__("Title", "rosemary"),
					"desc" => wp_kses( __("Title for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", "rosemary"),
					"desc" => wp_kses( __("Subtitle for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Description", "rosemary"),
					"desc" => wp_kses( __("Short description for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "textarea"
				),
				"link" => array(
					"title" => esc_html__("Button URL", "rosemary"),
					"desc" => wp_kses( __("Link URL for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", "rosemary"),
					"desc" => wp_kses( __("Caption for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
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
			),
			"children" => array(
				"name" => "trx_skills_item",
				"title" => esc_html__("Skill", "rosemary"),
				"desc" => wp_kses( __("Skills item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"container" => false,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Title", "rosemary"),
						"desc" => wp_kses( __("Current skills item title", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"value" => array(
						"title" => esc_html__("Value", "rosemary"),
						"desc" => wp_kses( __("Current skills level", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 50,
						"min" => 0,
						"step" => 1,
						"type" => "spinner"
					),
					"color" => array(
						"title" => esc_html__("Color", "rosemary"),
						"desc" => wp_kses( __("Current skills item color", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "color"
					),
					"bg_color" => array(
						"title" => esc_html__("Background color", "rosemary"),
						"desc" => wp_kses( __("Current skills item background color (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "color"
					),
					"border_color" => array(
						"title" => esc_html__("Border color", "rosemary"),
						"desc" => wp_kses( __("Current skills item border color (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "color"
					),
					"style" => array(
						"title" => esc_html__("Counter style", "rosemary"),
						"desc" => wp_kses( __("Select style for the current skills item (only for type=counter)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 1,
						"options" => rosemary_get_list_styles(1, 4),
						"type" => "checklist"
					), 
					"icon" => array(
						"title" => esc_html__("Counter icon",  'rosemary'),
						"desc" => wp_kses( __('Select icon from Fontello icons set, placed above counter (only for type=counter)',  'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "icons",
						"options" => $ROSEMARY_GLOBALS['sc_params']['icons']
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
if ( !function_exists( 'rosemary_sc_skills_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_skills_reg_shortcodes_vc');
	function rosemary_sc_skills_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		vc_map( array(
			"base" => "trx_skills",
			"name" => esc_html__("Skills", "rosemary"),
			"description" => wp_kses( __("Insert skills diagramm", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"category" => esc_html__('Content', 'js_composer'),
			'icon' => 'icon_trx_skills',
			"class" => "trx_sc_collection trx_sc_skills",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_skills_item'),
			"params" => array(
				array(
					"param_name" => "max_value",
					"heading" => esc_html__("Max value", "rosemary"),
					"description" => wp_kses( __("Max value for skills items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "100",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Skills type", "rosemary"),
					"description" => wp_kses( __("Select type of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Bar', 'rosemary') => 'bar',
						esc_html__('Pie chart', 'rosemary') => 'pie',
						esc_html__('Counter', 'rosemary') => 'counter',
						esc_html__('Arc', 'rosemary') => 'arc'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "layout",
					"heading" => esc_html__("Skills layout", "rosemary"),
					"description" => wp_kses( __("Select layout of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					'dependency' => array(
						'element' => 'type',
						'value' => array('counter','bar','pie')
					),
					"class" => "",
					"value" => array(
						esc_html__('Rows', 'rosemary') => 'rows',
						esc_html__('Columns', 'rosemary') => 'columns'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "dir",
					"heading" => esc_html__("Direction", "rosemary"),
					"description" => wp_kses( __("Select direction of skills block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['dir']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Counters style", "rosemary"),
					"description" => wp_kses( __("Select style of skills items (only for type=counter)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(rosemary_get_list_styles(1, 4)),
					'dependency' => array(
						'element' => 'type',
						'value' => array('counter')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "columns",
					"heading" => esc_html__("Columns count", "rosemary"),
					"description" => wp_kses( __("Skills columns count (required)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", "rosemary"),
					"description" => wp_kses( __("Color for all skills items", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", "rosemary"),
					"description" => wp_kses( __("Background color for all skills items (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "border_color",
					"heading" => esc_html__("Border color", "rosemary"),
					"description" => wp_kses( __("Border color for all skills items (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", "rosemary"),
					"description" => wp_kses( __("Align skills block to left or right side", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['float']),
					"type" => "dropdown"
				),
				array(
					"param_name" => "arc_caption",
					"heading" => esc_html__("Arc caption", "rosemary"),
					"description" => wp_kses( __("Arc caption - text in the center of the diagram", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('arc')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "pie_compact",
					"heading" => esc_html__("Pie compact", "rosemary"),
					"description" => wp_kses( __("Show all skills in one diagram or as separate diagrams", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => array(esc_html__('Show all skills in one diagram', 'rosemary') => 'on'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "pie_cutout",
					"heading" => esc_html__("Pie cutout", "rosemary"),
					"description" => wp_kses( __("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", "rosemary"),
					"description" => wp_kses( __("Title for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"group" => esc_html__('Captions', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", "rosemary"),
					"description" => wp_kses( __("Subtitle for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Captions', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", "rosemary"),
					"description" => wp_kses( __("Description for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Captions', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", "rosemary"),
					"description" => wp_kses( __("Link URL for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Captions', 'rosemary'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", "rosemary"),
					"description" => wp_kses( __("Caption for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"group" => esc_html__('Captions', 'rosemary'),
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
		
		
		vc_map( array(
			"base" => "trx_skills_item",
			"name" => esc_html__("Skill", "rosemary"),
			"description" => wp_kses( __("Skills item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
			"show_settings_on_create" => true,
			'icon' => 'icon_trx_skills_item',
			"class" => "trx_sc_single trx_sc_skills_item",
			"content_element" => true,
			"is_container" => false,
			"as_child" => array('only' => 'trx_skills'),
			"as_parent" => array('except' => 'trx_skills'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", "rosemary"),
					"description" => wp_kses( __("Title for the current skills item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "value",
					"heading" => esc_html__("Value", "rosemary"),
					"description" => wp_kses( __("Value for the current skills item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", "rosemary"),
					"description" => wp_kses( __("Color for current skills item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", "rosemary"),
					"description" => wp_kses( __("Background color for current skills item (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "border_color",
					"heading" => esc_html__("Border color", "rosemary"),
					"description" => wp_kses( __("Border color for current skills item (only for type=pie)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Counter style", "rosemary"),
					"description" => wp_kses( __("Select style for the current skills item (only for type=counter)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(rosemary_get_list_styles(1, 4)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Counter icon", "rosemary"),
					"description" => wp_kses( __("Select icon from Fontello icons set, placed before counter (only for type=counter)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "",
					"value" => $ROSEMARY_GLOBALS['sc_params']['icons'],
					"type" => "dropdown"
				),
				$ROSEMARY_GLOBALS['vc_params']['id'],
				$ROSEMARY_GLOBALS['vc_params']['class'],
				$ROSEMARY_GLOBALS['vc_params']['css']
			)
		) );
		
		class WPBakeryShortCode_Trx_Skills extends ROSEMARY_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Skills_Item extends ROSEMARY_VC_ShortCodeSingle {}
	}
}
?>