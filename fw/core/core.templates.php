<?php
/**
 * RoseMary Framework: templates and thumbs management
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('rosemary_templates_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_templates_theme_setup' );
	function rosemary_templates_theme_setup() {

		// Add custom thumb sizes into media manager
		add_filter( 'image_size_names_choose', 'rosemary_show_thumb_sizes');
	}
}



/* Templates
-------------------------------------------------------------------------------- */

// Add template (layout name)
// $tpl = array( 
//		'layout' => 'layout_name',
//		'template' => 'template_file_name',		// If empty - use 'layout' name
//		'body_style' => 'required_body_style',	// If not empty - use instead current body_style
//		'need_content' => true|false,			// true - for single posts or if template need prepared full content of the posts, else - false
//		'need_terms' => true|false,				// true - for single posts or if template need prepared terms list (categories, tags, product_cat, etc.), else - false
//		'need_columns' => true|false,			// true - if template need columns wrapper for horizontal direction, else - false
//		'need_isotope' => true|false,			// true - if template need isotope wrapper, else - false
//		'container' => '',						// Additional elements container (if need) for single post and blog streampage. For example: <div class="addit_wrap">%s</div>
//		'container_classes' => '',				// or additional classes for existing elements container
//		'mode'   => 'blog|single|widgets|blogger|internal',
//		'title'  => 'Layout title',
//		'thumb_title'  => 'Thumb title',		// If empty - don't show in the thumbs list (and not add image size)
//		'w'      => width,
//		'h'      => height (null if no crop, but only scale),
//		'h_crop' => cropped height (optional),
//		);
// $tpl = array('layout' => 'excerpt', 'mode' => 'blog', 'title'=>'Excerpt', 'thumb_title'=>'Medium image size', 'w' => 720, 'h' => 460, 'h_crop' => 460);
// $tpl = array('layout' => 'fullpost', 'mode' => 'blog,single', 'title'=>'Fullwidth post', 'thumb_title'=>'Large image', 'w' => 1150, 'h' => null, 'h_crop' => 720);
// $tpl = array('layout' => 'accordion', 'mode' => 'blogger', 'title'=>'Accordion');
if (!function_exists('rosemary_add_template')) {
	function rosemary_add_template($tpl) {
		global $ROSEMARY_GLOBALS;
		if (empty($tpl['mode']))						$tpl['mode'] = 'blog';
		if (empty($tpl['template']))					$tpl['template'] = $tpl['layout'];
		if (empty($tpl['need_content']))				$tpl['need_content'] = false;
		if (empty($tpl['need_terms']))					$tpl['need_terms'] = false;
		if (empty($tpl['need_columns']))				$tpl['need_columns'] = false;
		if (empty($tpl['need_isotope']))				$tpl['need_isotope'] = false;
		if (!isset($tpl['h_crop']) && isset($tpl['h']))	$tpl['h_crop'] = $tpl['h'];
		if (!isset($ROSEMARY_GLOBALS['registered_templates'])) $ROSEMARY_GLOBALS['registered_templates'] = array();
		$ROSEMARY_GLOBALS['registered_templates'][$tpl['layout']] = $tpl;
		if (!empty($tpl['thumb_title']))
			rosemary_add_thumb_sizes( $tpl );
		else 
			$tpl['thumb_title'] = '';
	}
}

// Return template file name
if (!function_exists('rosemary_get_template_name')) {
	function rosemary_get_template_name($layout_name) {
		global $ROSEMARY_GLOBALS;
		return $ROSEMARY_GLOBALS['registered_templates'][$layout_name]['template'];
	}
}

// Return true, if template required content
if (!function_exists('rosemary_get_template_property')) {
	function rosemary_get_template_property($layout_name, $what) {
		global $ROSEMARY_GLOBALS;
		return !empty($ROSEMARY_GLOBALS['registered_templates'][$layout_name][$what]) ? $ROSEMARY_GLOBALS['registered_templates'][$layout_name][$what] : '';
	}
}

// Return template output function name
if (!function_exists('rosemary_get_template_function_name')) {
	function rosemary_get_template_function_name($layout_name) {
		global $ROSEMARY_GLOBALS;
		return 'rosemary_template_'.str_replace(array('-', '.'), '_', $ROSEMARY_GLOBALS['registered_templates'][$layout_name]['template']).'_output';
	}
}


/* Thumbs
-------------------------------------------------------------------------------- */

// Add image dimensions with layout name
// $sizes = array( 
//		'layout' => 'layout_name',
//		'thumb_title'  => 'Thumb title',
//		'w'      => width,
//		'h'      => height (null if no crop, but only scale),
//		'h_crop' => cropped height,
//		);
// $sizes = array('layout' => 'excerpt',  'thumb'=>'Medium image', 'w' => 720, 'h' => 460, 'h_crop' => 460);
// $sizes = array('layout' => 'fullpost', 'thumb'=>'Large image', 'w' => 1150, 'h' => null, 'h_crop' => 720);
if (!function_exists('rosemary_add_thumb_sizes')) {
	function rosemary_add_thumb_sizes($sizes) {
		global $ROSEMARY_GLOBALS;
		if (!isset($sizes['h_crop']))		$sizes['h_crop'] =  isset($sizes['h']) ? $sizes['h'] : null;
		//if (empty($sizes['mode']))			$sizes['mode'] = 'blog';
		if (empty($sizes['thumb_title']))	$sizes['thumb_title'] = rosemary_strtoproper($sizes['layout']);
		$thumb_slug = rosemary_get_slug($sizes['thumb_title']);
		if (empty($ROSEMARY_GLOBALS['thumb_sizes'][$thumb_slug])) {
			if (empty($ROSEMARY_GLOBALS['thumb_sizes'])) $ROSEMARY_GLOBALS['thumb_sizes'] = array();
			$ROSEMARY_GLOBALS['thumb_sizes'][$thumb_slug] = $sizes;
			add_image_size( 'rosemary-'.$thumb_slug, $sizes['w'], $sizes['h'], $sizes['h']!=null );
			if ($sizes['h']!=$sizes['h_crop']) {
				// Uncomment this lines, if you want create separate entry for the cropped sizes (optional)
				//$sizes['h']=$sizes['h_crop'];
				//$sizes['title'] .= esc_html__(' (cropped)', 'rosemary');
				//$ROSEMARY_GLOBALS['thumb_sizes'][$sizes['layout'].'_crop'] = $sizes;
				add_image_size( 'rosemary-'.$thumb_slug.'_crop', $sizes['w'], $sizes['h_crop'], true );
			}
		}
	}
}

// Return image dimensions
if (!function_exists('rosemary_get_thumb_sizes')) {
	function rosemary_get_thumb_sizes($opt) {
		$opt = array_merge(array(
			'layout' => 'excerpt'
		), $opt);
		global $ROSEMARY_GLOBALS;
		$thumb_slug = empty($ROSEMARY_GLOBALS['registered_templates'][$opt['layout']]['thumb_title']) ? '' : rosemary_get_slug($ROSEMARY_GLOBALS['registered_templates'][$opt['layout']]['thumb_title']);
		$rez = $thumb_slug ? $ROSEMARY_GLOBALS['thumb_sizes'][$thumb_slug] : array('w'=>null, 'h'=>null, 'h_crop'=>null);
		return $rez;
	}
}

// Show custom thumb sizes into media manager sizes list
if (!function_exists('rosemary_show_thumb_sizes')) {
	function rosemary_show_thumb_sizes( $sizes ) {
		global $ROSEMARY_GLOBALS;
		$thumb_sizes = $ROSEMARY_GLOBALS['thumb_sizes'];
		if (is_array($thumb_sizes) && count($thumb_sizes) > 0) {
			$rez = array();
			foreach ($thumb_sizes as $k=>$v)
				$rez[$k] = !empty($v['thumb_title']) ? $v['thumb_title'] : $k;
			$sizes = array_merge( $sizes, $rez);
		}
		return $sizes;
	}
}

// AJAX callback: Get attachment url
if ( !function_exists( 'rosemary_callback_get_attachment_url' ) ) {
	function rosemary_callback_get_attachment_url() {
		global $_REQUEST, $ROSEMARY_GLOBALS;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $ROSEMARY_GLOBALS['ajax_url'] ) )
			die();
	
		$response = array('error'=>'');
		
		$id = (int) $_REQUEST['attachment_id'];
		
		$response['data'] = wp_get_attachment_url($id);
		
		echo json_encode($response);
		die();
	}
}
?>