<?php
/**
 * RoseMary Framework: global variables storage
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get global variable
if (!function_exists('rosemary_get_global')) {
	function rosemary_get_global($var_name) {
		global $ROSEMARY_GLOBALS;
		return isset($ROSEMARY_GLOBALS[$var_name]) ? $ROSEMARY_GLOBALS[$var_name] : '';
	}
}

// Set global variable
if (!function_exists('rosemary_set_global')) {
	function rosemary_set_global($var_name, $value) {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS[$var_name] = $value;
	}
}

// Inc/Dec global variable with specified value
if (!function_exists('rosemary_inc_global')) {
	function rosemary_inc_global($var_name, $value=1) {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS[$var_name] += $value;
	}
}

// Concatenate global variable with specified value
if (!function_exists('rosemary_concat_global')) {
	function rosemary_concat_global($var_name, $value) {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS[$var_name] .= $value;
	}
}

// Get global array element
if (!function_exists('rosemary_get_global_array')) {
	function rosemary_get_global_array($var_name, $key) {
		global $ROSEMARY_GLOBALS;
		return isset($ROSEMARY_GLOBALS[$var_name][$key]) ? $ROSEMARY_GLOBALS[$var_name][$key] : '';
	}
}

// Set global array element
if (!function_exists('rosemary_set_global_array')) {
	function rosemary_set_global_array($var_name, $key, $value) {
		global $ROSEMARY_GLOBALS;
		if (!isset($ROSEMARY_GLOBALS[$var_name])) $ROSEMARY_GLOBALS[$var_name] = array();
		$ROSEMARY_GLOBALS[$var_name][$key] = $value;
	}
}

// Inc/Dec global array element with specified value
if (!function_exists('rosemary_inc_global_array')) {
	function rosemary_inc_global_array($var_name, $key, $value=1) {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS[$var_name][$key] += $value;
	}
}

// Concatenate global array element with specified value
if (!function_exists('rosemary_concat_global_array')) {
	function rosemary_concat_global_array($var_name, $key, $value) {
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS[$var_name][$key] .= $value;
	}
}
?>