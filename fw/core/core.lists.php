<?php
/**
 * RoseMary Framework: return lists
 *
 * @package rosemary
 * @since rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'rosemary_get_list_styles' ) ) {
	function rosemary_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'rosemary'), $i);
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'rosemary_get_list_margins' ) ) {
	function rosemary_get_list_margins($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_margins']))
			$list = $ROSEMARY_GLOBALS['list_margins'];
		else {
			$list = array(
				'none'		=> esc_html__('0 (No margin)',	'rosemary'),
				'tiny'		=> esc_html__('Tiny',		'rosemary'),
				'small'		=> esc_html__('Small',		'rosemary'),
				'medium'	=> esc_html__('Medium',		'rosemary'),
				'large'		=> esc_html__('Large',		'rosemary'),
				'huge'		=> esc_html__('Huge',		'rosemary'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'rosemary'),
				'small-'	=> esc_html__('Small (negative)',	'rosemary'),
				'medium-'	=> esc_html__('Medium (negative)',	'rosemary'),
				'large-'	=> esc_html__('Large (negative)',	'rosemary'),
				'huge-'		=> esc_html__('Huge (negative)',	'rosemary')
				);
			$ROSEMARY_GLOBALS['list_margins'] = $list = apply_filters('rosemary_filter_list_margins', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'rosemary_get_list_animations' ) ) {
	function rosemary_get_list_animations($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_animations']))
			$list = $ROSEMARY_GLOBALS['list_animations'];
		else {
			$list = array(
				'none'			=> esc_html__('- None -',	'rosemary'),
				'bounced'		=> esc_html__('Bounced',		'rosemary'),
				'flash'			=> esc_html__('Flash',		'rosemary'),
				'flip'			=> esc_html__('Flip',		'rosemary'),
				'pulse'			=> esc_html__('Pulse',		'rosemary'),
				'rubberBand'	=> esc_html__('Rubber Band',	'rosemary'),
				'shake'			=> esc_html__('Shake',		'rosemary'),
				'swing'			=> esc_html__('Swing',		'rosemary'),
				'tada'			=> esc_html__('Tada',		'rosemary'),
				'wobble'		=> esc_html__('Wobble',		'rosemary')
				);
			$ROSEMARY_GLOBALS['list_animations'] = $list = apply_filters('rosemary_filter_list_animations', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'rosemary_get_list_animations_in' ) ) {
	function rosemary_get_list_animations_in($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_animations_in']))
			$list = $ROSEMARY_GLOBALS['list_animations_in'];
		else {
			$list = array(
				'none'				=> esc_html__('- None -',			'rosemary'),
				'bounceIn'			=> esc_html__('Bounce In',			'rosemary'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'rosemary'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'rosemary'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'rosemary'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'rosemary'),
				'fadeIn'			=> esc_html__('Fade In',			'rosemary'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'rosemary'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'rosemary'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'rosemary'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'rosemary'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'rosemary'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'rosemary'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'rosemary'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'rosemary'),
				'flipInX'			=> esc_html__('Flip In X',			'rosemary'),
				'flipInY'			=> esc_html__('Flip In Y',			'rosemary'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'rosemary'),
				'rotateIn'			=> esc_html__('Rotate In',			'rosemary'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','rosemary'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'rosemary'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'rosemary'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','rosemary'),
				'rollIn'			=> esc_html__('Roll In',			'rosemary'),
				'slideInUp'			=> esc_html__('Slide In Up',		'rosemary'),
				'slideInDown'		=> esc_html__('Slide In Down',		'rosemary'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'rosemary'),
				'slideInRight'		=> esc_html__('Slide In Right',		'rosemary'),
				'zoomIn'			=> esc_html__('Zoom In',			'rosemary'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'rosemary'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'rosemary'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'rosemary'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'rosemary')
				);
			$ROSEMARY_GLOBALS['list_animations_in'] = $list = apply_filters('rosemary_filter_list_animations_in', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'rosemary_get_list_animations_out' ) ) {
	function rosemary_get_list_animations_out($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_animations_out']))
			$list = $ROSEMARY_GLOBALS['list_animations_out'];
		else {
			$list = array(
				'none'				=> esc_html__('- None -',	'rosemary'),
				'bounceOut'			=> esc_html__('Bounce Out',			'rosemary'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'rosemary'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',		'rosemary'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',		'rosemary'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'rosemary'),
				'fadeOut'			=> esc_html__('Fade Out',			'rosemary'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',			'rosemary'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'rosemary'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'rosemary'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'rosemary'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',		'rosemary'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'rosemary'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'rosemary'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'rosemary'),
				'flipOutX'			=> esc_html__('Flip Out X',			'rosemary'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'rosemary'),
				'hinge'				=> esc_html__('Hinge Out',			'rosemary'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',		'rosemary'),
				'rotateOut'			=> esc_html__('Rotate Out',			'rosemary'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'rosemary'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',		'rosemary'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'rosemary'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'rosemary'),
				'rollOut'			=> esc_html__('Roll Out',		'rosemary'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'rosemary'),
				'slideOutDown'		=> esc_html__('Slide Out Down',	'rosemary'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',	'rosemary'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'rosemary'),
				'zoomOut'			=> esc_html__('Zoom Out',			'rosemary'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'rosemary'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',	'rosemary'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'rosemary'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',	'rosemary')
				);
			$ROSEMARY_GLOBALS['list_animations_out'] = $list = apply_filters('rosemary_filter_list_animations_out', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('rosemary_get_animation_classes')) {
	function rosemary_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return rosemary_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!rosemary_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'rosemary_get_list_categories' ) ) {
	function rosemary_get_list_categories($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_categories']))
			$list = $ROSEMARY_GLOBALS['list_categories'];
		else {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			$ROSEMARY_GLOBALS['list_categories'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'rosemary_get_list_terms' ) ) {
	function rosemary_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_taxonomies_'.($taxonomy)]))
			$list = $ROSEMARY_GLOBALS['list_taxonomies_'.($taxonomy)];
		else {
			$list = array();
			$args = array(
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $taxonomy,
				'pad_counts'               => false );
			$taxonomies = get_terms( $taxonomy, $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			$ROSEMARY_GLOBALS['list_taxonomies_'.($taxonomy)] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'rosemary_get_list_posts_types' ) ) {
	function rosemary_get_list_posts_types($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_posts_types']))
			$list = $ROSEMARY_GLOBALS['list_posts_types'];
		else {
			$list = array();
			/* 
			// This way to return all registered post types
			$types = get_post_types();
			if (in_array('post', $types)) $list['post'] = esc_html__('Post', 'rosemary');
			if (is_array($types) && count($types) > 0) {
				foreach ($types as $t) {
					if ($t == 'post') continue;
					$list[$t] = rosemary_strtoproper($t);
				}
			}
			*/
			// Return only theme inheritance supported post types
			$ROSEMARY_GLOBALS['list_posts_types'] = $list = apply_filters('rosemary_filter_list_post_types', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'rosemary_get_list_posts' ) ) {
	function rosemary_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		global $ROSEMARY_GLOBALS;
		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (isset($ROSEMARY_GLOBALS[$hash]))
			$list = $ROSEMARY_GLOBALS[$hash];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'rosemary');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			$ROSEMARY_GLOBALS[$hash] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'rosemary_get_list_users' ) ) {
	function rosemary_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_users']))
			$list = $ROSEMARY_GLOBALS['list_users'];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'rosemary');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			$ROSEMARY_GLOBALS['list_users'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'rosemary_get_list_sliders' ) ) {
	function rosemary_get_list_sliders($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_sliders']))
			$list = $ROSEMARY_GLOBALS['list_sliders'];
		else {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'rosemary')
			);
			$ROSEMARY_GLOBALS['list_sliders'] = $list = apply_filters('rosemary_filter_list_sliders', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'rosemary_get_list_slider_controls' ) ) {
	function rosemary_get_list_slider_controls($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_slider_controls']))
			$list = $ROSEMARY_GLOBALS['list_slider_controls'];
		else {
			$list = array(
				'no'		=> esc_html__('None', 'rosemary'),
				'side'		=> esc_html__('Side', 'rosemary'),
				'bottom'	=> esc_html__('Bottom', 'rosemary'),
				'pagination'=> esc_html__('Pagination', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_slider_controls'] = $list = apply_filters('rosemary_filter_list_slider_controls', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'rosemary_get_slider_controls_classes' ) ) {
	function rosemary_get_slider_controls_classes($controls) {
		if (rosemary_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'rosemary_get_list_popup_engines' ) ) {
	function rosemary_get_list_popup_engines($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_popup_engines']))
			$list = $ROSEMARY_GLOBALS['list_popup_engines'];
		else {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'rosemary'),
				"magnific"	=> esc_html__("Magnific popup", 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_popup_engines'] = $list = apply_filters('rosemary_filter_list_popup_engines', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'rosemary_get_list_menus' ) ) {
	function rosemary_get_list_menus($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_menus']))
			$list = $ROSEMARY_GLOBALS['list_menus'];
		else {
			$list = array();
			$list['default'] = esc_html__("Default", 'rosemary');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			$ROSEMARY_GLOBALS['list_menus'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'rosemary_get_list_sidebars' ) ) {
	function rosemary_get_list_sidebars($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_sidebars'])) {
			$list = $ROSEMARY_GLOBALS['list_sidebars'];
		} else {
			$list = isset($ROSEMARY_GLOBALS['registered_sidebars']) ? $ROSEMARY_GLOBALS['registered_sidebars'] : array();
			$ROSEMARY_GLOBALS['list_sidebars'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'rosemary_get_list_sidebars_positions' ) ) {
	function rosemary_get_list_sidebars_positions($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_sidebars_positions']))
			$list = $ROSEMARY_GLOBALS['list_sidebars_positions'];
		else {
			$list = array(
				'none'  => esc_html__('Hide',  'rosemary'),
				'left'  => esc_html__('Left',  'rosemary'),
				'right' => esc_html__('Right', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_sidebars_positions'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'rosemary_get_sidebar_class' ) ) {
	function rosemary_get_sidebar_class() {
		$sb_main = rosemary_get_custom_option('show_sidebar_main');
		$sb_outer = rosemary_get_custom_option('show_sidebar_outer');
		return (rosemary_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (rosemary_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_body_styles' ) ) {
	function rosemary_get_list_body_styles($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_body_styles']))
			$list = $ROSEMARY_GLOBALS['list_body_styles'];
		else {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'rosemary'),
				'wide'	=> esc_html__('Wide',		'rosemary')
				);
			if (rosemary_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'rosemary');
				$list['fullscreen']	= esc_html__('Fullscreen',	'rosemary');
			}
			$ROSEMARY_GLOBALS['list_body_styles'] = $list = apply_filters('rosemary_filter_list_body_styles', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'rosemary_get_list_skins' ) ) {
	function rosemary_get_list_skins($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_skins']))
			$list = $ROSEMARY_GLOBALS['list_skins'];
		else
			$ROSEMARY_GLOBALS['list_skins'] = $list = rosemary_get_list_folders("skins");
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'rosemary_get_list_themes' ) ) {
	function rosemary_get_list_themes($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_themes']))
			$list = $ROSEMARY_GLOBALS['list_themes'];
		else
			$ROSEMARY_GLOBALS['list_themes'] = $list = rosemary_get_list_files("css/themes");
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates' ) ) {
	function rosemary_get_list_templates($mode='') {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_'.($mode)]))
			$list = $ROSEMARY_GLOBALS['list_templates_'.($mode)];
		else {
			$list = array();
			if (is_array($ROSEMARY_GLOBALS['registered_templates']) && count($ROSEMARY_GLOBALS['registered_templates']) > 0) {
				foreach ($ROSEMARY_GLOBALS['registered_templates'] as $k=>$v) {
					if ($mode=='' || rosemary_strpos($v['mode'], $mode)!==false)
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: rosemary_strtoproper($v['layout'])
										);
				}
			}
			$ROSEMARY_GLOBALS['list_templates_'.($mode)] = $list;
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates_blog' ) ) {
	function rosemary_get_list_templates_blog($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_blog']))
			$list = $ROSEMARY_GLOBALS['list_templates_blog'];
		else {
			$list = rosemary_get_list_templates('blog');
			$ROSEMARY_GLOBALS['list_templates_blog'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates_blogger' ) ) {
	function rosemary_get_list_templates_blogger($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_blogger']))
			$list = $ROSEMARY_GLOBALS['list_templates_blogger'];
		else {
			$list = rosemary_array_merge(rosemary_get_list_templates('blogger'), rosemary_get_list_templates('blog'));
			$ROSEMARY_GLOBALS['list_templates_blogger'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates_single' ) ) {
	function rosemary_get_list_templates_single($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_single']))
			$list = $ROSEMARY_GLOBALS['list_templates_single'];
		else {
			$list = rosemary_get_list_templates('single');
			$ROSEMARY_GLOBALS['list_templates_single'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates_header' ) ) {
	function rosemary_get_list_templates_header($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_header']))
			$list = $ROSEMARY_GLOBALS['list_templates_header'];
		else {
			$list = rosemary_get_list_templates('header');
			$ROSEMARY_GLOBALS['list_templates_header'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_templates_forms' ) ) {
	function rosemary_get_list_templates_forms($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_templates_forms']))
			$list = $ROSEMARY_GLOBALS['list_templates_forms'];
		else {
			$list = rosemary_get_list_templates('forms');
			$ROSEMARY_GLOBALS['list_templates_forms'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_article_styles' ) ) {
	function rosemary_get_list_article_styles($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_article_styles']))
			$list = $ROSEMARY_GLOBALS['list_article_styles'];
		else {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'rosemary'),
				"stretch" => esc_html__('Stretch', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_article_styles'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'rosemary_get_list_post_formats_filters' ) ) {
	function rosemary_get_list_post_formats_filters($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_post_formats_filters']))
			$list = $ROSEMARY_GLOBALS['list_post_formats_filters'];
		else {
			$list = array(
				"no"      => esc_html__('All posts', 'rosemary'),
				"thumbs"  => esc_html__('With thumbs', 'rosemary'),
				"reviews" => esc_html__('With reviews', 'rosemary'),
				"video"   => esc_html__('With videos', 'rosemary'),
				"audio"   => esc_html__('With audios', 'rosemary'),
				"gallery" => esc_html__('With galleries', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_post_formats_filters'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'rosemary_get_list_portfolio_filters' ) ) {
	function rosemary_get_list_portfolio_filters($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_portfolio_filters']))
			$list = $ROSEMARY_GLOBALS['list_portfolio_filters'];
		else {
			$list = array(
				"hide"		=> esc_html__('Hide', 'rosemary'),
				"tags"		=> esc_html__('Tags', 'rosemary'),
				"categories"=> esc_html__('Categories', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_portfolio_filters'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_hovers' ) ) {
	function rosemary_get_list_hovers($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_hovers']))
			$list = $ROSEMARY_GLOBALS['list_hovers'];
		else {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'rosemary');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'rosemary');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'rosemary');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'rosemary');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'rosemary');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'rosemary');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'rosemary');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'rosemary');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'rosemary');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'rosemary');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'rosemary');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'rosemary');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'rosemary');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'rosemary');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'rosemary');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'rosemary');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'rosemary');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'rosemary');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'rosemary');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'rosemary');
			$list['square effect1']  = esc_html__('Square Effect 1',  'rosemary');
			$list['square effect2']  = esc_html__('Square Effect 2',  'rosemary');
			$list['square effect3']  = esc_html__('Square Effect 3',  'rosemary');
	//		$list['square effect4']  = esc_html__('Square Effect 4',  'rosemary');
			$list['square effect5']  = esc_html__('Square Effect 5',  'rosemary');
			$list['square effect6']  = esc_html__('Square Effect 6',  'rosemary');
			$list['square effect7']  = esc_html__('Square Effect 7',  'rosemary');
			$list['square effect8']  = esc_html__('Square Effect 8',  'rosemary');
			$list['square effect9']  = esc_html__('Square Effect 9',  'rosemary');
			$list['square effect10'] = esc_html__('Square Effect 10',  'rosemary');
			$list['square effect11'] = esc_html__('Square Effect 11',  'rosemary');
			$list['square effect12'] = esc_html__('Square Effect 12',  'rosemary');
			$list['square effect13'] = esc_html__('Square Effect 13',  'rosemary');
			$list['square effect14'] = esc_html__('Square Effect 14',  'rosemary');
			$list['square effect15'] = esc_html__('Square Effect 15',  'rosemary');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'rosemary');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'rosemary');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'rosemary');
			$list['square effect_more']  = esc_html__('Square Effect More',  'rosemary');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'rosemary');
			$ROSEMARY_GLOBALS['list_hovers'] = $list = apply_filters('rosemary_filter_portfolio_hovers', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'rosemary_get_list_blog_counters' ) ) {
	function rosemary_get_list_blog_counters($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_blog_counters']))
			$list = $ROSEMARY_GLOBALS['list_blog_counters'];
		else {
			$list = array(
				'views'		=> esc_html__('Views', 'rosemary'),
				'likes'		=> esc_html__('Likes', 'rosemary'),
				'rating'	=> esc_html__('Rating', 'rosemary'),
				'comments'	=> esc_html__('Comments', 'rosemary')
				);
			$ROSEMARY_GLOBALS['list_blog_counters'] = $list = apply_filters('rosemary_filter_list_blog_counters', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'rosemary_get_list_alter_sizes' ) ) {
	function rosemary_get_list_alter_sizes($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_alter_sizes']))
			$list = $ROSEMARY_GLOBALS['list_alter_sizes'];
		else {
			$list = array(
					'1_1' => esc_html__('1x1', 'rosemary'),
					'1_2' => esc_html__('1x2', 'rosemary'),
					'2_1' => esc_html__('2x1', 'rosemary'),
					'2_2' => esc_html__('2x2', 'rosemary'),
					'1_3' => esc_html__('1x3', 'rosemary'),
					'2_3' => esc_html__('2x3', 'rosemary'),
					'3_1' => esc_html__('3x1', 'rosemary'),
					'3_2' => esc_html__('3x2', 'rosemary'),
					'3_3' => esc_html__('3x3', 'rosemary')
					);
			$ROSEMARY_GLOBALS['list_alter_sizes'] = $list = apply_filters('rosemary_filter_portfolio_alter_sizes', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'rosemary_get_list_hovers_directions' ) ) {
	function rosemary_get_list_hovers_directions($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_hovers_directions']))
			$list = $ROSEMARY_GLOBALS['list_hovers_directions'];
		else {
			$list = array();
			$list['left_to_right'] = esc_html__('Left to Right',  'rosemary');
			$list['right_to_left'] = esc_html__('Right to Left',  'rosemary');
			$list['top_to_bottom'] = esc_html__('Top to Bottom',  'rosemary');
			$list['bottom_to_top'] = esc_html__('Bottom to Top',  'rosemary');
			$list['scale_up']      = esc_html__('Scale Up',  'rosemary');
			$list['scale_down']    = esc_html__('Scale Down',  'rosemary');
			$list['scale_down_up'] = esc_html__('Scale Down-Up',  'rosemary');
			$list['from_left_and_right'] = esc_html__('From Left and Right',  'rosemary');
			$list['from_top_and_bottom'] = esc_html__('From Top and Bottom',  'rosemary');
			$ROSEMARY_GLOBALS['list_hovers_directions'] = $list = apply_filters('rosemary_filter_portfolio_hovers_directions', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'rosemary_get_list_label_positions' ) ) {
	function rosemary_get_list_label_positions($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_label_positions']))
			$list = $ROSEMARY_GLOBALS['list_label_positions'];
		else {
			$list = array();
			$list['top']	= esc_html__('Top',		'rosemary');
			$list['bottom']	= esc_html__('Bottom',		'rosemary');
			$list['left']	= esc_html__('Left',		'rosemary');
			$list['over']	= esc_html__('Over',		'rosemary');
			$ROSEMARY_GLOBALS['list_label_positions'] = $list = apply_filters('rosemary_filter_label_positions', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'rosemary_get_list_bg_image_positions' ) ) {
	function rosemary_get_list_bg_image_positions($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_bg_image_positions']))
			$list = $ROSEMARY_GLOBALS['list_bg_image_positions'];
		else {
			$list = array();
			$list['left top']	  = esc_html__('Left Top', 'rosemary');
			$list['center top']   = esc_html__("Center Top", 'rosemary');
			$list['right top']    = esc_html__("Right Top", 'rosemary');
			$list['left center']  = esc_html__("Left Center", 'rosemary');
			$list['center center']= esc_html__("Center Center", 'rosemary');
			$list['right center'] = esc_html__("Right Center", 'rosemary');
			$list['left bottom']  = esc_html__("Left Bottom", 'rosemary');
			$list['center bottom']= esc_html__("Center Bottom", 'rosemary');
			$list['right bottom'] = esc_html__("Right Bottom", 'rosemary');
			$ROSEMARY_GLOBALS['list_bg_image_positions'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'rosemary_get_list_bg_image_repeats' ) ) {
	function rosemary_get_list_bg_image_repeats($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_bg_image_repeats']))
			$list = $ROSEMARY_GLOBALS['list_bg_image_repeats'];
		else {
			$list = array();
			$list['repeat']	  = esc_html__('Repeat', 'rosemary');
			$list['repeat-x'] = esc_html__('Repeat X', 'rosemary');
			$list['repeat-y'] = esc_html__('Repeat Y', 'rosemary');
			$list['no-repeat']= esc_html__('No Repeat', 'rosemary');
			$ROSEMARY_GLOBALS['list_bg_image_repeats'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'rosemary_get_list_bg_image_attachments' ) ) {
	function rosemary_get_list_bg_image_attachments($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_bg_image_attachments']))
			$list = $ROSEMARY_GLOBALS['list_bg_image_attachments'];
		else {
			$list = array();
			$list['scroll']	= esc_html__('Scroll', 'rosemary');
			$list['fixed']	= esc_html__('Fixed', 'rosemary');
			$list['local']	= esc_html__('Local', 'rosemary');
			$ROSEMARY_GLOBALS['list_bg_image_attachments'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'rosemary_get_list_bg_tints' ) ) {
	function rosemary_get_list_bg_tints($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_bg_tints']))
			$list = $ROSEMARY_GLOBALS['list_bg_tints'];
		else {
			$list = array();
			$list['white']	= esc_html__('White', 'rosemary');
			$list['light']	= esc_html__('Light', 'rosemary');
			$list['dark']	= esc_html__('Dark', 'rosemary');
			$ROSEMARY_GLOBALS['list_bg_tints'] = $list = apply_filters('rosemary_filter_bg_tints', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'rosemary_get_list_field_types' ) ) {
	function rosemary_get_list_field_types($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_field_types']))
			$list = $ROSEMARY_GLOBALS['list_field_types'];
		else {
			$list = array();
			$list['text']     = esc_html__('Text',  'rosemary');
			$list['textarea'] = esc_html__('Text Area','rosemary');
			$list['password'] = esc_html__('Password',  'rosemary');
			$list['radio']    = esc_html__('Radio',  'rosemary');
			$list['checkbox'] = esc_html__('Checkbox',  'rosemary');
			$list['select']   = esc_html__('Select',  'rosemary');
			$list['date']     = esc_html__('Date','rosemary');
			$list['time']     = esc_html__('Time','rosemary');
			$list['button']   = esc_html__('Button','rosemary');
			$ROSEMARY_GLOBALS['list_field_types'] = $list = apply_filters('rosemary_filter_field_types', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'rosemary_get_list_googlemap_styles' ) ) {
	function rosemary_get_list_googlemap_styles($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_googlemap_styles']))
			$list = $ROSEMARY_GLOBALS['list_googlemap_styles'];
		else {
			$list = array();
			$list['default'] = esc_html__('Default', 'rosemary');
			$list['simple'] = esc_html__('Simple', 'rosemary');
			$list['greyscale'] = esc_html__('Greyscale', 'rosemary');
			$list['greyscale2'] = esc_html__('Greyscale 2', 'rosemary');
			$list['invert'] = esc_html__('Invert', 'rosemary');
			$list['dark'] = esc_html__('Dark', 'rosemary');
			$list['style1'] = esc_html__('Custom style 1', 'rosemary');
			$list['style2'] = esc_html__('Custom style 2', 'rosemary');
			$list['style3'] = esc_html__('Custom style 3', 'rosemary');
			$ROSEMARY_GLOBALS['list_googlemap_styles'] = $list = apply_filters('rosemary_filter_googlemap_styles', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'rosemary_get_list_icons' ) ) {
	function rosemary_get_list_icons($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_icons']))
			$list = $ROSEMARY_GLOBALS['list_icons'];
		else
			$ROSEMARY_GLOBALS['list_icons'] = $list = rosemary_parse_icons_classes(rosemary_get_file_dir("css/fontello/css/fontello-codes.css"));
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'rosemary_get_list_socials' ) ) {
	function rosemary_get_list_socials($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_socials']))
			$list = $ROSEMARY_GLOBALS['list_socials'];
		else
			$ROSEMARY_GLOBALS['list_socials'] = $list = rosemary_get_list_files("images/socials", "png");
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'rosemary_get_list_flags' ) ) {
	function rosemary_get_list_flags($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_flags']))
			$list = $ROSEMARY_GLOBALS['list_flags'];
		else
			$ROSEMARY_GLOBALS['list_flags'] = $list = rosemary_get_list_files("images/flags", "png");
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'rosemary_get_list_yesno' ) ) {
	function rosemary_get_list_yesno($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_yesno']))
			$list = $ROSEMARY_GLOBALS['list_yesno'];
		else {
			$list = array();
			$list["yes"] = esc_html__("Yes", 'rosemary');
			$list["no"]  = esc_html__("No", 'rosemary');
			$ROSEMARY_GLOBALS['list_yesno'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'rosemary_get_list_onoff' ) ) {
	function rosemary_get_list_onoff($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_onoff']))
			$list = $ROSEMARY_GLOBALS['list_onoff'];
		else {
			$list = array();
			$list["on"] = esc_html__("On", 'rosemary');
			$list["off"] = esc_html__("Off", 'rosemary');
			$ROSEMARY_GLOBALS['list_onoff'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'rosemary_get_list_showhide' ) ) {
	function rosemary_get_list_showhide($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_showhide']))
			$list = $ROSEMARY_GLOBALS['list_showhide'];
		else {
			$list = array();
			$list["show"] = esc_html__("Show", 'rosemary');
			$list["hide"] = esc_html__("Hide", 'rosemary');
			$ROSEMARY_GLOBALS['list_showhide'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'rosemary_get_list_orderings' ) ) {
	function rosemary_get_list_orderings($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_orderings']))
			$list = $ROSEMARY_GLOBALS['list_orderings'];
		else {
			$list = array();
			$list["asc"] = esc_html__("Ascending", 'rosemary');
			$list["desc"] = esc_html__("Descending", 'rosemary');
			$ROSEMARY_GLOBALS['list_orderings'] = $list;
		}
		return ($prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list);
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'rosemary_get_list_directions' ) ) {
	function rosemary_get_list_directions($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_directions']))
			$list = $ROSEMARY_GLOBALS['list_directions'];
		else {
			$list = array();
			$list["horizontal"] = esc_html__("Horizontal", 'rosemary');
			$list["vertical"] = esc_html__("Vertical", 'rosemary');
			$ROSEMARY_GLOBALS['list_directions'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'rosemary_get_list_shapes' ) ) {
	function rosemary_get_list_shapes($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_shapes']))
			$list = $ROSEMARY_GLOBALS['list_shapes'];
		else {
			$list = array();
			$list["round"]  = esc_html__("Round", 'rosemary');
			$list["square"] = esc_html__("Square", 'rosemary');
			$ROSEMARY_GLOBALS['list_shapes'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'rosemary_get_list_sizes' ) ) {
	function rosemary_get_list_sizes($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_sizes']))
			$list = $ROSEMARY_GLOBALS['list_sizes'];
		else {
			$list = array();
			$list["tiny"]   = esc_html__("Tiny", 'rosemary');
			$list["small"]  = esc_html__("Small", 'rosemary');
			$list["medium"] = esc_html__("Medium", 'rosemary');
			$list["large"]  = esc_html__("Large", 'rosemary');
			$ROSEMARY_GLOBALS['list_sizes'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'rosemary_get_list_floats' ) ) {
	function rosemary_get_list_floats($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_floats']))
			$list = $ROSEMARY_GLOBALS['list_floats'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'rosemary');
			$list["left"] = esc_html__("Float Left", 'rosemary');
			$list["right"] = esc_html__("Float Right", 'rosemary');
			$ROSEMARY_GLOBALS['list_floats'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'rosemary_get_list_alignments' ) ) {
	function rosemary_get_list_alignments($justify=false, $prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_alignments']))
			$list = $ROSEMARY_GLOBALS['list_alignments'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'rosemary');
			$list["left"] = esc_html__("Left", 'rosemary');
			$list["center"] = esc_html__("Center", 'rosemary');
			$list["right"] = esc_html__("Right", 'rosemary');
			if ($justify) $list["justify"] = esc_html__("Justify", 'rosemary');
			$ROSEMARY_GLOBALS['list_alignments'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'rosemary_get_list_sortings' ) ) {
	function rosemary_get_list_sortings($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_sortings']))
			$list = $ROSEMARY_GLOBALS['list_sortings'];
		else {
			$list = array();
			$list["date"] = esc_html__("Date", 'rosemary');
			$list["title"] = esc_html__("Alphabetically", 'rosemary');
			$list["views"] = esc_html__("Popular (views count)", 'rosemary');
			$list["comments"] = esc_html__("Most commented (comments count)", 'rosemary');
			$list["author_rating"] = esc_html__("Author rating", 'rosemary');
			$list["users_rating"] = esc_html__("Visitors (users) rating", 'rosemary');
			$list["random"] = esc_html__("Random", 'rosemary');
			$ROSEMARY_GLOBALS['list_sortings'] = $list = apply_filters('rosemary_filter_list_sortings', $list);
		}
		return ($prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list);
	}
}

// Return list with columns widths
if ( !function_exists( 'rosemary_get_list_columns' ) ) {
	function rosemary_get_list_columns($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_columns']))
			$list = $ROSEMARY_GLOBALS['list_columns'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'rosemary');
			$list["1_1"] = esc_html__("100%", 'rosemary');
			$list["1_2"] = esc_html__("1/2", 'rosemary');
			$list["1_3"] = esc_html__("1/3", 'rosemary');
			$list["2_3"] = esc_html__("2/3", 'rosemary');
			$list["1_4"] = esc_html__("1/4", 'rosemary');
			$list["3_4"] = esc_html__("3/4", 'rosemary');
			$list["1_5"] = esc_html__("1/5", 'rosemary');
			$list["2_5"] = esc_html__("2/5", 'rosemary');
			$list["3_5"] = esc_html__("3/5", 'rosemary');
			$list["4_5"] = esc_html__("4/5", 'rosemary');
			$list["1_6"] = esc_html__("1/6", 'rosemary');
			$list["5_6"] = esc_html__("5/6", 'rosemary');
			$list["1_7"] = esc_html__("1/7", 'rosemary');
			$list["2_7"] = esc_html__("2/7", 'rosemary');
			$list["3_7"] = esc_html__("3/7", 'rosemary');
			$list["4_7"] = esc_html__("4/7", 'rosemary');
			$list["5_7"] = esc_html__("5/7", 'rosemary');
			$list["6_7"] = esc_html__("6/7", 'rosemary');
			$list["1_8"] = esc_html__("1/8", 'rosemary');
			$list["3_8"] = esc_html__("3/8", 'rosemary');
			$list["5_8"] = esc_html__("5/8", 'rosemary');
			$list["7_8"] = esc_html__("7/8", 'rosemary');
			$list["1_9"] = esc_html__("1/9", 'rosemary');
			$list["2_9"] = esc_html__("2/9", 'rosemary');
			$list["4_9"] = esc_html__("4/9", 'rosemary');
			$list["5_9"] = esc_html__("5/9", 'rosemary');
			$list["7_9"] = esc_html__("7/9", 'rosemary');
			$list["8_9"] = esc_html__("8/9", 'rosemary');
			$list["1_10"]= esc_html__("1/10", 'rosemary');
			$list["3_10"]= esc_html__("3/10", 'rosemary');
			$list["7_10"]= esc_html__("7/10", 'rosemary');
			$list["9_10"]= esc_html__("9/10", 'rosemary');
			$list["1_11"]= esc_html__("1/11", 'rosemary');
			$list["2_11"]= esc_html__("2/11", 'rosemary');
			$list["3_11"]= esc_html__("3/11", 'rosemary');
			$list["4_11"]= esc_html__("4/11", 'rosemary');
			$list["5_11"]= esc_html__("5/11", 'rosemary');
			$list["6_11"]= esc_html__("6/11", 'rosemary');
			$list["7_11"]= esc_html__("7/11", 'rosemary');
			$list["8_11"]= esc_html__("8/11", 'rosemary');
			$list["9_11"]= esc_html__("9/11", 'rosemary');
			$list["10_11"]= esc_html__("10/11", 'rosemary');
			$list["1_12"]= esc_html__("1/12", 'rosemary');
			$list["5_12"]= esc_html__("5/12", 'rosemary');
			$list["7_12"]= esc_html__("7/12", 'rosemary');
			$list["10_12"]= esc_html__("10/12", 'rosemary');
			$list["11_12"]= esc_html__("11/12", 'rosemary');
			$ROSEMARY_GLOBALS['list_columns'] = $list = apply_filters('rosemary_filter_list_columns', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'rosemary_get_list_dedicated_locations' ) ) {
	function rosemary_get_list_dedicated_locations($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_dedicated_locations']))
			$list = $ROSEMARY_GLOBALS['list_dedicated_locations'];
		else {
			$list = array();
			$list["default"] = esc_html__('As in the post defined', 'rosemary');
			$list["center"]  = esc_html__('Above the text of the post', 'rosemary');
			$list["left"]    = esc_html__('To the left the text of the post', 'rosemary');
			$list["right"]   = esc_html__('To the right the text of the post', 'rosemary');
			$list["alter"]   = esc_html__('Alternates for each post', 'rosemary');
			$ROSEMARY_GLOBALS['list_dedicated_locations'] = $list = apply_filters('rosemary_filter_list_dedicated_locations', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'rosemary_get_post_format_name' ) ) {
	function rosemary_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'rosemary') : esc_html__('galleries', 'rosemary');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'rosemary') : esc_html__('videos', 'rosemary');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'rosemary') : esc_html__('audios', 'rosemary');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'rosemary') : esc_html__('images', 'rosemary');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'rosemary') : esc_html__('quotes', 'rosemary');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'rosemary') : esc_html__('links', 'rosemary');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'rosemary') : esc_html__('statuses', 'rosemary');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'rosemary') : esc_html__('asides', 'rosemary');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'rosemary') : esc_html__('chats', 'rosemary');
		else						$name = $single ? esc_html__('standard', 'rosemary') : esc_html__('standards', 'rosemary');
		return apply_filters('rosemary_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'rosemary_get_post_format_icon' ) ) {
	function rosemary_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('rosemary_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'rosemary_get_list_fonts_styles' ) ) {
	function rosemary_get_list_fonts_styles($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_fonts_styles']))
			$list = $ROSEMARY_GLOBALS['list_fonts_styles'];
		else {
			$list = array();
			$list['i'] = esc_html__('I','rosemary');
			$list['u'] = esc_html__('U', 'rosemary');
			$ROSEMARY_GLOBALS['list_fonts_styles'] = $list;
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'rosemary_get_list_fonts' ) ) {
	function rosemary_get_list_fonts($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_fonts']))
			$list = $ROSEMARY_GLOBALS['list_fonts'];
		else {
			$list = array();
			$list = rosemary_array_merge($list, rosemary_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>rosemary_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list['Advent Pro'] = array('family'=>'sans-serif');
			$list['Alegreya Sans'] = array('family'=>'sans-serif');
			$list['Arimo'] = array('family'=>'sans-serif');
			$list['Asap'] = array('family'=>'sans-serif');
			$list['Averia Sans Libre'] = array('family'=>'cursive');
			$list['Averia Serif Libre'] = array('family'=>'cursive');
			$list['Bree Serif'] = array('family'=>'serif',);
			$list['Cabin'] = array('family'=>'sans-serif');
			$list['Cabin Condensed'] = array('family'=>'sans-serif');
			$list['Caudex'] = array('family'=>'serif');
			$list['Comfortaa'] = array('family'=>'cursive');
			$list['Cousine'] = array('family'=>'sans-serif');
			$list['Crimson Text'] = array('family'=>'serif');
			$list['Cuprum'] = array('family'=>'sans-serif');
			$list['Dosis'] = array('family'=>'sans-serif');
			$list['Economica'] = array('family'=>'sans-serif');
			$list['Exo'] = array('family'=>'sans-serif');
			$list['Expletus Sans'] = array('family'=>'cursive');
			$list['Karla'] = array('family'=>'sans-serif');
			$list['Lato'] = array('family'=>'sans-serif');
			$list['Lekton'] = array('family'=>'sans-serif');
			$list['Lobster Two'] = array('family'=>'cursive');
			$list['Maven Pro'] = array('family'=>'sans-serif');
			$list['Merriweather'] = array('family'=>'serif');
			$list['Montserrat'] = array('family'=>'sans-serif');
			$list['Neuton'] = array('family'=>'serif');
			$list['Noticia Text'] = array('family'=>'serif');
			$list['Old Standard TT'] = array('family'=>'serif');
			$list['Open Sans'] = array('family'=>'sans-serif');
			$list['Orbitron'] = array('family'=>'sans-serif');
			$list['Oswald'] = array('family'=>'sans-serif');
			$list['Overlock'] = array('family'=>'cursive');
			$list['Oxygen'] = array('family'=>'sans-serif');
			$list['PT Serif'] = array('family'=>'serif');
			$list['Puritan'] = array('family'=>'sans-serif');
			$list['Raleway'] = array('family'=>'sans-serif');
			$list['Roboto'] = array('family'=>'sans-serif');
			$list['Roboto Slab'] = array('family'=>'sans-serif');
			$list['Roboto Condensed'] = array('family'=>'sans-serif');
			$list['Rosario'] = array('family'=>'sans-serif');
			$list['Share'] = array('family'=>'cursive');
			$list['Signika'] = array('family'=>'sans-serif');
			$list['Signika Negative'] = array('family'=>'sans-serif');
			$list['Source Sans Pro'] = array('family'=>'sans-serif');
			$list['Tinos'] = array('family'=>'serif');
			$list['Ubuntu'] = array('family'=>'sans-serif');
			$list['Vollkorn'] = array('family'=>'serif');
			$ROSEMARY_GLOBALS['list_fonts'] = $list = apply_filters('rosemary_filter_list_fonts', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'rosemary_get_list_font_faces' ) ) {
	function rosemary_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = rosemary_get_folder_dir("css/font-face");
		if ( is_dir($dir) ) {
			$hdir = @ opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$css = file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.css' ) 
						? rosemary_get_folder_url("css/font-face/".($file).'/'.($file).'.css')
						: (file_exists( ($dir) . '/' . ($file) . '/stylesheet.css' ) 
							? rosemary_get_folder_url("css/font-face/".($file).'/stylesheet.css')
							: '');
					if ($css != '')
						$list[$file.' ('.esc_html__('uploaded font', 'rosemary').')'] = array('css' => $css);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}
?>