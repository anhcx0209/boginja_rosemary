<?php
/**
 * RoseMary Framework: less manipulations
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('rosemary_less_theme_setup2')) {
	add_action( 'rosemary_action_after_init_theme', 'rosemary_less_theme_setup2' );
	function rosemary_less_theme_setup2() {
		global $ROSEMARY_GLOBALS;
		if (!empty($ROSEMARY_GLOBALS['less_recompile'])) {

			// Theme first run - compile and save css
			do_action('rosemary_action_compile_less');

		} else if (!is_admin() && rosemary_get_theme_option('debug_mode')=='yes') {

			// Regular run - if not admin - recompile only changed files
			$ROSEMARY_GLOBALS['less_check_time'] = true;
			do_action('rosemary_action_compile_less');
			$ROSEMARY_GLOBALS['less_check_time'] = false;

		}
	}
}

// Theme first run - compile and save css
if (!function_exists('rosemary_less_theme_setup3')) {
	add_action( 'after_switch_theme', 'rosemary_less_theme_setup3' );
	function rosemary_less_theme_setup3() {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['less_recompile'] = true;
	}
}



/* LESS
-------------------------------------------------------------------------------- */

// Recompile all LESS files
if (!function_exists('rosemary_compile_less')) {
	function rosemary_compile_less($list = array(), $recompile=true) {

		if (!function_exists('rosemary_less_compiler')) return false;

		$success = true;

		// Less compiler
		$less_compiler = rosemary_get_theme_setting('less_compiler');
		if ($less_compiler == 'no') return $success;
		
		// Generate map for the LESS-files
		$less_map = rosemary_get_theme_setting('less_map');
		if (rosemary_get_theme_option('debug_mode')=='no' || $less_compiler=='lessc') $less_map = 'no';
		
		// Get separator to split LESS-files
		$less_sep = $less_map!='no' ? '' : rosemary_get_theme_setting('less_separator');
	
		// Prepare skin specific LESS-vars (colors, backgrounds, logo height, etc.)
		$vars = apply_filters('rosemary_filter_prepare_less', '');

		// Collect .less files in parent and child themes
		if (empty($list)) {
			$list = rosemary_collect_files(get_template_directory(), 'less');
			if (get_template_directory() != get_stylesheet_directory()) $list = array_merge($list, rosemary_collect_files(get_stylesheet_directory(), 'less'));
		}
		// Prepare separate array with less utils (not compile it alone - only with main files)
		$utils = $less_map!='no' ? array() : '';
		$utils_time = 0;
		if (is_array($list) && count($list) > 0) {
			foreach($list as $k=>$file) {
				$fname = basename($file);
				if ($fname[0]=='_') {
					if ($less_map!='no')
						$utils[] = $file;
					else
						$utils .= rosemary_fgc($file);
					$list[$k] = '';
					$tmp = filemtime($file);
					if ($utils_time < $tmp) $utils_time = $tmp;
				}
			}
		}
		
		// Compile all .less files
		if (is_array($list) && count($list) > 0) {
			global $ROSEMARY_GLOBALS;
			$success = rosemary_less_compiler($list, array(
				'compiler' => $less_compiler,
				'map' => $less_map,
				'utils' => $utils,
				'utils_time' => $utils_time,
				'vars' => $vars,
				'separator' => $less_sep,
				'check_time' => !empty($ROSEMARY_GLOBALS['less_check_time']),
				'compressed' => rosemary_get_theme_option('debug_mode')=='no'
				)
			);
		}
		
		return $success;
	}
}
?>