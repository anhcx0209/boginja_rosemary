<?php
//####################################################
//#### Inheritance system (for internal use only) #### 
//####################################################

// Add item to the inheritance settings
if ( !function_exists( 'rosemary_add_theme_inheritance' ) ) {
	function rosemary_add_theme_inheritance($options, $append=true) {
		global $ROSEMARY_GLOBALS;
		if (!isset($ROSEMARY_GLOBALS["inheritance"])) $ROSEMARY_GLOBALS["inheritance"] = array();
		$ROSEMARY_GLOBALS['inheritance'] = $append
			? rosemary_array_merge($ROSEMARY_GLOBALS['inheritance'], $options)
			: rosemary_array_merge($options, $ROSEMARY_GLOBALS['inheritance']);
	}
}



// Return inheritance settings
if ( !function_exists( 'rosemary_get_theme_inheritance' ) ) {
	function rosemary_get_theme_inheritance($key = '') {
		global $ROSEMARY_GLOBALS;
		return $key ? $ROSEMARY_GLOBALS['inheritance'][$key] : $ROSEMARY_GLOBALS['inheritance'];
	}
}



// Detect inheritance key for the current mode
if ( !function_exists( 'rosemary_detect_inheritance_key' ) ) {
	function rosemary_detect_inheritance_key() {
		static $inheritance_key = '';
		if (!empty($inheritance_key)) return $inheritance_key;
		$key = apply_filters('rosemary_filter_detect_inheritance_key', '');
		global $ROSEMARY_GLOBALS;
		if (empty($ROSEMARY_GLOBALS['pre_query'])) $inheritance_key = $key;
		return $key;
	}
}


// Return key for override parameter
if ( !function_exists( 'rosemary_get_override_key' ) ) {
	function rosemary_get_override_key($value, $by) {
		$key = '';
		$inheritance = rosemary_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v[$by]) && in_array($value, $v[$by])) {
					$key = $by=='taxonomy' 
						? $value
						: (!empty($v['override']) ? $v['override'] : $k);
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for categories) by post_type from inheritance array
if ( !function_exists( 'rosemary_get_taxonomy_categories_by_post_type' ) ) {
	function rosemary_get_taxonomy_categories_by_post_type($value) {
		$key = '';
		$inheritance = rosemary_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy']) ? $v['taxonomy'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for tags) by post_type from inheritance array
if ( !function_exists( 'rosemary_get_taxonomy_tags_by_post_type' ) ) {
	function rosemary_get_taxonomy_tags_by_post_type($value) {
		$key = '';
		$inheritance = rosemary_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy_tags']) ? $v['taxonomy_tags'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}
?>