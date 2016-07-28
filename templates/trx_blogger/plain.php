<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_plain_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_plain_theme_setup', 1 );
	function rosemary_template_plain_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'plain',
			'template' => 'plain',
			'need_terms' => true,
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Plain', 'rosemary')
			));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_plain_output' ) ) {
	function rosemary_template_plain_output($post_options, $post_data) {
		?>
		<div class="post_item sc_blogger_item sc_plain_item<?php echo ($post_options['number'] == $post_options['posts_on_page'] && !rosemary_param_is_on($post_options['loadmore']) ? ' sc_blogger_item_last' : ''); ?>">
			
			<?php
			if (!empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
				?>
				<?php
			}

			if (!isset($post_options['links']) || $post_options['links']) { 
				?><h5 class="post_title sc_title sc_title_underline sc_align_center "><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo ($post_data['post_title']); ?></a></h5><?php
			} else {
				?><h5 class="post_title sc_title sc_title_underline sc_align_center "><?php echo ($post_data['post_title']); ?></h5><?php
			}
			
			if (!$post_data['post_protected'] && $post_options['info']) {
				$info_parts = array('counters'=>true, 'terms'=>false, 'author' => false);
				require rosemary_get_file_dir('templates/_parts/post-info.php');
			}
			?>

		</div>		<!-- /.post_item -->

		<?php
	}
}
?>