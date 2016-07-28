<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_single_portfolio_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_single_portfolio_theme_setup', 1 );
	function rosemary_template_single_portfolio_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'single-portfolio',
			'mode'   => 'single',
			'need_content' => true,
			'need_terms' => true,
			'title'  => esc_html__('Portfolio item', 'rosemary'),
			'thumb_title'  => esc_html__('Fullsize image', 'rosemary'),
			'w'		 => 1170,
			'h'		 => null,
			'h_crop' => 660
		));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_single_portfolio_output' ) ) {
	function rosemary_template_single_portfolio_output($post_options, $post_data) {
		$post_data['post_views']++;
		$avg_author = 0;
		$avg_users  = 0;
		if (!$post_data['post_protected'] && $post_options['reviews'] && rosemary_get_custom_option('show_reviews')=='yes') {
			$avg_author = $post_data['post_reviews_author'];
			$avg_users  = $post_data['post_reviews_users'];
		}
		$show_title = rosemary_get_custom_option('show_post_title')=='yes' && (rosemary_get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));

		rosemary_open_wrapper('<article class="'
				. join(' ', get_post_class('itemscope'
					. ' post_item post_item_single_portfolio'
					. ' post_featured_' . esc_attr($post_options['post_class'])
					. ' post_format_' . esc_attr($post_data['post_format'])))
				. '"'
				. ' itemscope itemtype="http://schema.org/'.($avg_author > 0 || $avg_users > 0 ? 'Review' : 'Article')
				. '">');

		require rosemary_get_file_dir('templates/_parts/prev-next-block.php');

		if ($show_title) {
			?>
			<h1 itemprop="<?php echo ($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'headline'); ?>" class="post_title entry-title"><?php echo ($post_data['post_title']); ?></h1>
			<?php
		}

		if (!$post_data['post_protected'] && rosemary_get_custom_option('show_post_info')=='yes') {
			require rosemary_get_file_dir('templates/_parts/post-info.php');
		}

		require rosemary_get_file_dir('templates/_parts/reviews-block.php');

		rosemary_open_wrapper('<section class="post_content'.(!$post_data['post_protected'] && $post_data['post_edit_enable'] ? ' '.esc_attr('post_content_editor_present') : '').'" itemprop="'.($avg_author > 0 || $avg_users > 0 ? 'reviewBody' : 'articleBody').'">');
			
		// Post content
		if ($post_data['post_protected']) { 
			echo ($post_data['post_excerpt']);
			echo get_the_password_form(); 
		} else {
			if (rosemary_strpos($post_data['post_content'], rosemary_get_reviews_placeholder())===false) $post_data['post_content'] = rosemary_sc_reviews(array()) . ($post_data['post_content']);
			echo trim(rosemary_gap_wrapper(rosemary_reviews_wrapper($post_data['post_content'])));
			require rosemary_get_file_dir('templates/_parts/single-pagination.php');
			if ( rosemary_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
				?>
				<div class="post_info">
					<span class="post_info_item post_info_tags"><?php esc_html_e('in', 'rosemary'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
				</div>
				<?php
			} 
		}

		if (!$post_data['post_protected'] && $post_data['post_edit_enable']) {
			require rosemary_get_file_dir('templates/_parts/editor-area.php');
		}

		rosemary_close_wrapper();	// .post_content

		if (!$post_data['post_protected']) {
			require rosemary_get_file_dir('templates/_parts/author-info.php');
			require rosemary_get_file_dir('templates/_parts/share.php');
			require rosemary_get_file_dir('templates/_parts/related-posts.php');
			require rosemary_get_file_dir('templates/_parts/comments.php');
		}
	
		rosemary_close_wrapper();	// .post_item

		require rosemary_get_file_dir('templates/_parts/views-counter.php');
	}
}
?>