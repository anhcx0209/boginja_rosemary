<?php
/**
Template Name: Single post
 */
get_header(); 

global $ROSEMARY_GLOBALS;
$single_style = !empty($ROSEMARY_GLOBALS['single_style']) ? $ROSEMARY_GLOBALS['single_style'] : rosemary_get_custom_option('single_style');

while ( have_posts() ) { the_post();

	// Move rosemary_set_post_views to the javascript - counter will work under cache system
	if (rosemary_get_custom_option('use_ajax_views_counter')=='no') {
		rosemary_set_post_views(get_the_ID());
	}

	rosemary_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_main')),
			'content' => rosemary_get_template_property($single_style, 'need_content'),
			'terms_list' => rosemary_get_template_property($single_style, 'need_terms')
		)
	);

}

get_footer();
?>