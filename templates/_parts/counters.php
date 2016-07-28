<?php
$show_all_counters = !isset($post_options['counters']);
$counters_tag = is_single() ? 'span' : 'a';
 
if ($show_all_counters || rosemary_strpos($post_options['counters'], 'views')!==false) {
	?>
	<<?php echo ($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo esc_attr( sprintf(__('Views - %s', 'rosemary'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo ($post_data['post_views']); ?></<?php echo ($counters_tag); ?>>
	<?php
}

if ($show_all_counters || rosemary_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-chat-empty" title="<?php echo esc_attr( sprintf(__('Comments - %s', 'rosemary'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php echo ($post_data['post_comments']); ?></span><span class="comments_text"><?php echo ($post_data['post_comments'] == 1 ? ' Comment' : ' Comments')?></span></a>
	<?php 
}
 
$rating = $post_data['post_reviews_'.(rosemary_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || rosemary_strpos($post_options['counters'], 'rating')!==false)) {
	?>
	<<?php echo ($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(__('Rating - %s', 'rosemary'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php echo ($rating); ?></span></<?php echo ($counters_tag); ?>>
	<?php
}

if ($show_all_counters || rosemary_strpos($post_options['counters'], 'likes')!==false) {
	// Load core messages
	rosemary_enqueue_messages();
	$likes = isset($_COOKIE['rosemary_likes']) ? $_COOKIE['rosemary_likes'] : '';
	$allow = rosemary_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php echo ($allow ? 'enabled' : 'disabled'); ?>" title="<?php echo ($allow ? esc_attr__('Like', 'rosemary') : esc_attr__('Dislike', 'rosemary')); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_attr_e('Like', 'rosemary'); ?>"
		data-title-dislike="<?php esc_attr_e('Dislike', 'rosemary'); ?>"><span class="post_counters_number"><?php echo ($post_data['post_likes']); ?></span></a>
	<?php
}

if (is_single() && rosemary_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(rosemary_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(rosemary_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>