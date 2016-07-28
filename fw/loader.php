<?php
/**
 * RoseMary Framework
 *
 * @package rosemary
 * @since rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'ROSEMARY_FW_DIR' ) )		define( 'ROSEMARY_FW_DIR', '/fw/' );

// Theme timing
if ( ! defined( 'ROSEMARY_START_TIME' ) )	define( 'ROSEMARY_START_TIME', microtime());			// Framework start time
if ( ! defined( 'ROSEMARY_START_MEMORY' ) )	define( 'ROSEMARY_START_MEMORY', memory_get_usage());	// Memory usage before core loading

// Global variables storage
global $ROSEMARY_GLOBALS;
$ROSEMARY_GLOBALS = array(
	'page_template'	=> '',
    'allowed_tags'	=> array(		// Allowed tags list (with attributes) in translations
    	'b' => array(),
    	'strong' => array(),
    	'i' => array(),
    	'em' => array(),
    	'u' => array(),
    	'a' => array(
			'href' => array(),
			'title' => array(),
			'target' => array(),
			'id' => array(),
			'class' => array()
		),
    	'span' => array(
			'id' => array(),
			'class' => array()
		)
    )	
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'rosemary_loader_theme_setup', 20 );
	function rosemary_loader_theme_setup() {
		
		// Init admin url and nonce
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['admin_url']	= get_admin_url();
		$ROSEMARY_GLOBALS['admin_nonce']= wp_create_nonce(get_admin_url());
		$ROSEMARY_GLOBALS['ajax_url']	= admin_url('admin-ajax.php');
		$ROSEMARY_GLOBALS['ajax_nonce']	= wp_create_nonce(admin_url('admin-ajax.php'));

		// Before init theme
		do_action('rosemary_action_before_init_theme');

		// Load current values for main theme options
		rosemary_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			rosemary_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */

// Manual load important libraries before load all rest files
// core.strings must be first - we use rosemary_str...() in the rosemary_get_file_dir()
require_once (file_exists(get_stylesheet_directory().(ROSEMARY_FW_DIR).'core/core.strings.php') ? get_stylesheet_directory() : get_template_directory()).(ROSEMARY_FW_DIR).'core/core.strings.php';
// core.files must be first - we use rosemary_get_file_dir() to include all rest parts
require_once (file_exists(get_stylesheet_directory().(ROSEMARY_FW_DIR).'core/core.files.php') ? get_stylesheet_directory() : get_template_directory()).(ROSEMARY_FW_DIR).'core/core.files.php';

// Include custom theme files
rosemary_autoload_folder( 'includes' );

// Include core files
rosemary_autoload_folder( 'core' );

// Include theme-specific plugins and post types
rosemary_autoload_folder( 'plugins' );

// Include theme templates
rosemary_autoload_folder( 'templates' );

// Include theme widgets
rosemary_autoload_folder( 'widgets' );
?>