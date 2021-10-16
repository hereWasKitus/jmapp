<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package coelix
 */

?>

<aside id="secondary" class="post__sidebar">
	<div class="sidebar-title">
		<?= __('Last news', 'jm') ?>
	</div>
	<div class="sidebar-block">
		<?php
		$args = array(
			'posts_per_page' => 3,
		);

		$query = new WP_Query($args);

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				get_template_part('template-parts/content', 'archive');
			}
		}
		wp_reset_postdata();
		?>
	</div>
</aside><!-- #secondary -->