<?php
/**
 * Theme sprecific functions and definitions
 */


/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'rosemary_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_theme_setup', 1 );
	function rosemary_theme_setup() {

		// Register theme menus
		add_filter( 'rosemary_filter_add_theme_menus',		'rosemary_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'rosemary_filter_add_theme_sidebars',	'rosemary_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'rosemary_filter_importer_options',		'rosemary_importer_set_options' );

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'rosemary_add_theme_menus' ) ) {
	//add_filter( 'rosemary_filter_add_theme_menus', 'rosemary_add_theme_menus' );
	function rosemary_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'rosemary');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'rosemary_add_theme_sidebars' ) ) {
	//add_filter( 'rosemary_filter_add_theme_sidebars',	'rosemary_add_theme_sidebars' );
	function rosemary_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'rosemary' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'rosemary' ),
				'sidebar_instagram'	=> esc_html__( 'Instagram Sidebar', 'rosemary' )
			);
			if (function_exists('rosemary_exists_woocommerce') && rosemary_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'rosemary' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Set theme specific importer options
if ( !function_exists( 'rosemary_importer_set_options' ) ) {
	//add_filter( 'rosemary_filter_importer_options',	'rosemary_importer_set_options' );
	function rosemary_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Please, note! The following text strings should not be translated, 
			// since these are article titles, menu locations, etc. used by us in the demo-website. 
			// They are required when setting some of the WP parameters during demo data installation 
			// and cannot be changed/translated into other languages.
			$options['debug'] = rosemary_get_theme_option('debug_mode')=='yes';
			$options['domain_dev'] = esc_url('_trex2.rosemary.dnw');
			$options['domain_demo'] = esc_url('trex2.dev.rosemary.net');
			$options['page_on_front'] = esc_html__('Header 1, Contacts, Copyright text. Testimonials and Team', 'rosemary');	// Homepage title (NOT FOR TRANSLATION)
			$options['page_for_posts'] = esc_html__('All posts', 'rosemary');													// Blog streampage title (NOT FOR TRANSLATION)
			$options['menus'] = array(																	// Menus locations and names (NOT FOR TRANSLATION)
				'menu-main'	  => esc_html__('Main menu', 'rosemary'),
				'menu-user'	  => esc_html__('User menu', 'rosemary'),
				'menu-footer' => esc_html__('Footer menu', 'rosemary'),
				'menu-outer'  => esc_html__('Main menu', 'rosemary')
			);
			$options['required_plugins'] = array(														// Required plugins slugs (NOT FOR TRANSLATION)
				'visual_composer',
				'revslider',
				'woocommerce',
				'booking',
				'essgrids',
				'tribe_events'
			);
		}
		return $options;
	}
}


/* Include framework core files
------------------------------------------------------------------- */
// If now is WP Heartbeat call - skip loading theme core files
if (!isset($_POST['action']) || $_POST['action']!="heartbeat") {
	require_once get_template_directory().'/fw/loader.php';
}
?>