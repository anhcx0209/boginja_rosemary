<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_no_articles_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_no_articles_theme_setup', 1 );
	function rosemary_template_no_articles_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'no-articles',
			'mode'   => 'internal',
			'title'  => esc_html__('No articles found', 'rosemary'),
			'w'		 => null,
			'h'		 => null
		));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_no_articles_output' ) ) {
	function rosemary_template_no_articles_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php esc_html_e('No posts found', 'rosemary'); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria.', 'rosemary' ); ?></p>
				<p><?php echo wp_kses( sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'rosemary'), esc_url(home_url('/')), get_bloginfo()), $ROSEMARY_GLOBALS['allowed_tags'] ); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'rosemary'); ?></p>
				<?php echo trim(rosemary_sc_search(array('state'=>"fixed"))); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>