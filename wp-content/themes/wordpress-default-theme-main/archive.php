<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package coelix
 */

get_header();
?>

<main id="primary" class="archivepage">

	<div class="container">

		<?php if (have_posts()) : ?>

			<header class="archive__header">
				<?php
				the_archive_title('<h1 class="archive__title">', '</h1>');
				?>
			</header>

			<section class="archive__block">

				<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post();

					get_template_part('template-parts/content', 'archive');

				endwhile;

			else : get_template_part('template-parts/content', 'none');
				?>

			<?php endif; ?>
			</section>

			<?php
			$args = array(
				'show_all'     => false,
				'end_size'     => 1,
				'mid_size'     => 1,
				'prev_next'    => false,
			);
			the_posts_pagination($args);
			?>

	</div>

</main><!-- #main -->

<?php
get_footer();
