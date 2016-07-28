<?php
/**
Template Name: Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move rosemary_set_post_views to the javascript - counter will work under cache system
	if (rosemary_get_custom_option('use_ajax_views_counter')=='no') {
		rosemary_set_post_views(get_the_ID());
	}

	rosemary_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>