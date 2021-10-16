<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package coelix
 */

?>

<footer class="footer">
	<div class="container">
		<div class="footer__text">
			<a href="<?= get_home_url(); ?>" class="footer__logo logo">
				<img src="<?php the_field('logo_image', 'option'); ?>" alt="logo">
			</a>
			<div class="footer__info">
				© <?php the_time('Y'); ?> Copyright By <a href="https://jewishmusic.fm/%d7%93%d7%a3-%d7%94%d7%91%d7%99%d7%aa-2/" target="_blank">Jewishmusic.fm</a> Site Built By Coelix
			</div>
		</div>
		<div class="footer__facebook">
			<?php if ( is_rtl() ): ?>
			<div class="fb-page" data-href="https://www.facebook.com/jewishmusic.fm" data-tabs="timeline" data-width="320" data-height="340" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
				<blockquote cite="https://www.facebook.com/jewishmusic.fm" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/jewishmusic.fm">‎ג&#039;ואיש מיוזיק אף אם - הלב של המוזיקה היהודית‎</a></blockquote>
			</div>
			<?php else: ?>
			<div class="fb-page" data-href="https://www.facebook.com/www.jewishmusic.fm" data-tabs="timeline" data-width="320" data-height="340" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
				<blockquote cite="https://www.facebook.com/www.jewishmusic.fm" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/www.jewishmusic.fm">JewishMusic.fm - The Heart Of Jewish Music</a></blockquote>
			</div>
			<?php endif; ?>
		</div>
		<div class="footer__app app-block">
			<?php
			$video_link = get_field('footer_video_link', 'option');
			if ( $video_link ):
			?>
			<iframe src="<?= $video_link ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<?php endif; ?>
		</div>
	</div>
</footer>
</div><!-- #page -->


<?php wp_footer(); ?>

</body>

</html>