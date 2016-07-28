<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('rosemary_action_skin_theme_setup')) {
	add_action( 'rosemary_action_init_theme', 'rosemary_action_skin_theme_setup', 1 );
	function rosemary_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('rosemary_filter_used_fonts',			'rosemary_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('rosemary_filter_list_fonts',			'rosemary_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('rosemary_action_add_styles',			'rosemary_action_skin_add_styles');
		// Add skin inline styles
		add_filter('rosemary_filter_add_styles_inline',		'rosemary_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('rosemary_action_add_responsive',		'rosemary_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('rosemary_filter_add_responsive_inline',	'rosemary_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('rosemary_action_add_scripts',			'rosemary_action_skin_add_scripts');
		// Add skin scripts inline
		add_action('rosemary_action_add_scripts_inline',	'rosemary_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('rosemary_filter_compile_less',			'rosemary_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		rosemary_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'rosemary'),

			// Accent colors
			'accent1'				=> '#c4a648',
			'accent1_hover'			=> '#b59533',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#696969',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#000000',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e7e7e7',
			'bg_color'				=> '#f8f8f8',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#e6e6e6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#c4a648',
			'alter_hover'			=> '#696969',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#f7f7f7',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		rosemary_add_color_scheme('red', array(

			'title'					=> esc_html__('Red', 'rosemary'),

			// Accent colors
			'accent1'				=> '#fa5f5d',
			'accent1_hover'			=> '#d9504e',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#696969',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#000000',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e7e7e7',
			'bg_color'				=> '#f8f8f8',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#e6e6e6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#fa5f5d',
			'alter_hover'			=> '#696969',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#f7f7f7',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
);

// Add color schemes
		rosemary_add_color_scheme('purple', array(

			'title'					=> esc_html__('Purple', 'rosemary'),

			// Accent colors
			'accent1'				=> '#9b57be',
			'accent1_hover'			=> '#703F8A',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#696969',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#000000',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#e7e7e7',
			'bg_color'				=> '#f8f8f8',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#e6e6e6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#9b57be',
			'alter_hover'			=> '#696969',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#f7f7f7',
			'alter_bg_hover'		=> '#f0f0f0',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);


		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		rosemary_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '4.286em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.4em'
			)
		);
		rosemary_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '2.857em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.18em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		rosemary_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '2.143em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '2.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		rosemary_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '1.714em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '2.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.6em'
			)
		);
		rosemary_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '1.286em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '2.7em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.5em'
			)
		);
		rosemary_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '1.071em',
			'font-weight'	=> '700',
			'font-style'	=> 'i',
			'line-height'	=> '3.6em',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '0.65em'
			)
		);
		rosemary_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '14px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.5em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		rosemary_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		rosemary_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '0.929em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.8em'
			)
		);
		rosemary_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.5em',
			'margin-bottom'	=> '1.35em'
			)
		);
		rosemary_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		rosemary_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '2.8571em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '0.75em',
			'margin-top'	=> '3.75em',
			'margin-bottom'	=> '2em'
			)
		);
		rosemary_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2em'
			)
		);
		rosemary_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'rosemary'),
			'description'	=> '',
			'font-family'	=> 'Merriweather',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('rosemary_filter_skin_used_fonts')) {
	//add_filter('rosemary_filter_used_fonts', 'rosemary_filter_skin_used_fonts');
	function rosemary_filter_skin_used_fonts($theme_fonts) {
		$theme_fonts['Merriweather'] = 1;
		//$theme_fonts['Love Ya Like A Sister'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('rosemary_filter_skin_list_fonts')) {
	//add_filter('rosemary_filter_list_fonts', 'rosemary_filter_skin_list_fonts');
	function rosemary_filter_skin_list_fonts($list) {
		// Example:
		if (!isset($list['Merriweather'])) {
				$list['Merriweather'] = array(
					'family' => 'serif',																						// (required) font family
					'link'   => 'Merriweather:400,700,400italic,700italic,800,900'	// (optional) if you use Google font repository
				//	'css'    => rosemary_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
					);
		}
		if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('rosemary_action_skin_add_styles')) {
	//add_action('rosemary_action_add_styles', 'rosemary_action_skin_add_styles');
	function rosemary_action_skin_add_styles() {
		// Add stylesheet files
		rosemary_enqueue_style( 'rosemary-skin-style', rosemary_get_file_url('skin.css'), array(), null );
		if (file_exists(rosemary_get_file_dir('skin.customizer.css')))
			rosemary_enqueue_style( 'rosemary-skin-customizer-style', rosemary_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('rosemary_filter_skin_add_styles_inline')) {
	//add_filter('rosemary_filter_add_styles_inline', 'rosemary_filter_skin_add_styles_inline');
	function rosemary_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = rosemary_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = rosemary_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('rosemary_action_skin_add_responsive')) {
	//add_action('rosemary_action_add_responsive', 'rosemary_action_skin_add_responsive');
	function rosemary_action_skin_add_responsive() {
		$suffix = rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(rosemary_get_file_dir('skin.responsive'.($suffix).'.css')))
			rosemary_enqueue_style( 'theme-skin-responsive-style', rosemary_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('rosemary_filter_skin_add_responsive_inline')) {
	//add_filter('rosemary_filter_add_responsive_inline', 'rosemary_filter_skin_add_responsive_inline');
	function rosemary_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('rosemary_filter_skin_compile_less')) {
	//add_filter('rosemary_filter_compile_less', 'rosemary_filter_skin_compile_less');
	function rosemary_filter_skin_compile_less($files) {
		if (file_exists(rosemary_get_file_dir('skin.less'))) {
		 	$files[] = rosemary_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('rosemary_action_skin_add_scripts')) {
	//add_action('rosemary_action_add_scripts', 'rosemary_action_skin_add_scripts');
	function rosemary_action_skin_add_scripts() {
		if (file_exists(rosemary_get_file_dir('skin.js')))
			rosemary_enqueue_script( 'theme-skin-script', rosemary_get_file_url('skin.js'), array(), null );
		if (rosemary_get_theme_option('show_theme_customizer') == 'yes' && file_exists(rosemary_get_file_dir('skin.customizer.js')))
			rosemary_enqueue_script( 'theme-skin-customizer-script', rosemary_get_file_url('skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('rosemary_action_skin_add_scripts_inline')) {
	//add_action('rosemary_action_add_scripts_inline', 'rosemary_action_skin_add_scripts_inline');
	function rosemary_action_skin_add_scripts_inline() {
		// Todo: add skin specific scripts
		// Example:
		// echo '<script type="text/javascript">'
		//	. 'jQuery(document).ready(function() {'
		//	. "if (ROSEMARY_GLOBALS['theme_font']=='') ROSEMARY_GLOBALS['theme_font'] = '" . rosemary_get_custom_font_settings('p', 'font-family') . "';"
		//	. "ROSEMARY_GLOBALS['theme_skin_color'] = '" . rosemary_get_scheme_color('accent1') . "';"
		//	. "});"
		//	. "< /script>";
	}
}
?>