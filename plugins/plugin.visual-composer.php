<?php
/* Visual Composer support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('rosemary_vc_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_vc_theme_setup', 1 );
	function rosemary_vc_theme_setup() {
		if (rosemary_exists_visual_composer()) {
			if (is_admin()) {
				add_filter( 'rosemary_filter_importer_options',				'rosemary_vc_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'rosemary_filter_importer_required_plugins',		'rosemary_vc_importer_required_plugins', 10, 2 );
			add_filter( 'rosemary_filter_required_plugins',					'rosemary_vc_required_plugins' );
		}
	}
}

// Check if Visual Composer installed and activated
if ( !function_exists( 'rosemary_exists_visual_composer' ) ) {
	function rosemary_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if Visual Composer in frontend editor mode
if ( !function_exists( 'rosemary_vc_is_frontend' ) ) {
	function rosemary_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
		//return function_exists('vc_is_frontend_editor') && vc_is_frontend_editor();
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'rosemary_vc_required_plugins' ) ) {
	//add_filter('rosemary_filter_required_plugins',	'rosemary_vc_required_plugins');
	function rosemary_vc_required_plugins($list=array()) {
		$list[] = array(
					'name' 		=> 'Visual Composer',
					'slug' 		=> 'js_composer',
					'source'	=> rosemary_get_file_dir('plugins/install/js_composer.zip'),
					'required' 	=> false
				);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check VC in the required plugins
if ( !function_exists( 'rosemary_vc_importer_required_plugins' ) ) {
	//add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_vc_importer_required_plugins', 10, 2 );
	function rosemary_vc_importer_required_plugins($not_installed='', $importer=null) {
		if ($importer && in_array('visual_composer', $importer->options['required_plugins']) && $_POST['data_type']=='vc' && !rosemary_exists_visual_composer() )
			$not_installed .= '<br>Visual Composer';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'rosemary_vc_importer_set_options' ) ) {
	//add_filter( 'rosemary_filter_importer_options',	'rosemary_vc_importer_set_options' );
	function rosemary_vc_importer_set_options($options=array()) {
		if (is_array($options)) {
			$options['additional_options'][] = 'wpb_js_templates';		// Add slugs to export options for this plugin

		}
		return $options;
	}
}
?>