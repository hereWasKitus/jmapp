<?php

/**
 * Template Name: Homepage
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */
get_header();

?>
<main class="homepage">

	<section class="banner" style="background-image: url(<?php the_field('banner_background'); ?>), linear-gradient(115.33deg, #891DDF 0%, #6611AD 67.71%, #5E009C 85.94%)">
		<div class="container">
			<div class="banner__text">
				<h1 class="banner__title title-1">
					<?php the_field('banner_title'); ?>
				</h1>
				<div class="banner__subtitle title-1">
					<?php the_field('banner_subtitle'); ?>
				</div>
				<div class="banner__label">
					<?php the_field('banner_label'); ?>
				</div>
				<div class="banner__buttons">
					<?php
					$buttons = get_field('buttons');
					foreach ($buttons as $button) :
					?>
						<a target="_blank" class="banner__button" href="<?= $button['button_link'] ?>">
							<img src="<?= $button['button_image'] ?>" alt="">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="banner__img">
				<img src="<?php the_field('banner_image'); ?>" alt="phone">
			</div>
		</div>
	</section>

	<section class="statistic">
		<div class="container">
			<div class="statistic-block">
				<?php
				$statistics = get_field('statistic_col');
				foreach ($statistics as $statistic) :
				?>

					<div class="statistic__col">
						<div class="statistic__icon icon">
							<img src="<?= $statistic['statistic_col_icon'] ?>" alt="user">
						</div>
						<div class="statistic__text">
							<div class="statistic__title">
								<?= $statistic['statistic_col_num'] ?>
							</div>
							<div class="statistic__desc desc">
								<?= $statistic['statistic_col_label'] ?>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="upload" class="upload">
		<div class="container">
			<div class="upload__text">
				<h2 class="upload__title title-2">
					<?php the_field('upload_title'); ?>
				</h2>
				<p class="upload__desc">
					<?php the_field('upload_description'); ?>
				</p>
			</div>
			<div class="upload-box heartbeat">
				<a href="<?php if (is_user_logged_in()) {
								echo get_home_url() . '/account';
							} else {
								echo get_home_url() . '/sign-up';
							} ?>" class="upload-box__wrap">
					<img class="upload-box__icon" src="<?php the_field('upload_box_icon'); ?>" alt="music">
					<div class="upload-box__title">
						<?php the_field('upload_box_title'); ?>
					</div>
					<div class="upload-box__desc">
						<?php the_field('upload_box_subtitle'); ?>
					</div>
				</a>
			</div>
		</div>
	</section>

	<section id="info" class="info">
		<div class="container">
			<div class="info__text">
				<h2 class="info__title">
					<?php the_field('info_title'); ?>
				</h2>
				<p class="info__desc text">
					<?php the_field('info_description'); ?>
				</p>
				<!--<a href="<?php the_field('link_address'); ?>" class="info-box">
					<div class="info-box__icon icon">
						<img src="<?= get_template_directory_uri() ?>/assets/images/Icon/location.svg" alt="location">
					</div>
					<div class="info-box__text">
						<div class="info-box__title desc">
							<?php the_field('title_link'); ?>
						</div>
						<div class="info-box__desc">
							<?php the_field('subtitle_link'); ?>
						</div>
					</div>
				</a>-->
				<div class="info-box">
					<div class="info-box__text">
						<a href="<?php the_field('link_address'); ?>" class="btn btn--dark info-box__btn"><?php the_field('button_name'); ?></a>
					</div>
				</div>
			</div>
			<div class="info__img">
				<img src="<?php the_field('info_image'); ?>" alt="system">
			</div>
		</div>
	</section>

	<section id="premium" class="premium" style="background-image: url(<?php the_field('premium_background'); ?>), linear-gradient(115.33deg, #891DDF 0%, #6611AD 67.71%, #5E009C 85.94%)">
		<div class="container">
			<div class="premium__text">
				<div class="premium__title">
					<?php the_field('premium_title'); ?>
				</div>
				<div class="premium__subtitle">
					<?php the_field('premium_subtitle'); ?>
				</div>
				<ul class="premium__images">
					<?php
					$cards = get_field('premium_cards');
					if ( $cards ) :
						foreach ($cards as $card ) :
					?>
						<li><img src="<?= $card['card'] ?>" alt="Cards"></li>
					<?php
						endforeach;
					endif;
					?>
				</ul>
			</div>
			<div class="premium__box">
				<?php
				$premium_elements = get_field('premium_element');
				foreach ($premium_elements as $premium_element) :
				?>
					<div class="premium-card">
						<div class="premium-card__icon">
							<img src="<?= $premium_element['premium_element_icon'] ?>" alt="Icon">
						</div>
						<div class="premium-card__text">
							<div class="premium-card__title">
								<?= $premium_element['premium_element_number'] ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="blog">
		<div class="container">
			<h2 class="blog__title"><?= __('Support', 'jm') ?></h2>
			<div class="blog__block">
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
			<div class="blog__dots"></div>
		</div>
	</section>

	<section class="feedback">
		<div class="container">
			<div class="feedback__img">
				<img src="<?php the_field('contact_us_image'); ?>" alt="feedback">
			</div>
			<div class="feedback__block">
				<h2 class="feedback__title title-2">
					<?php the_field('contact_us_title'); ?>
				</h2>
				<form class="feedback__form old-form js-feedback-form">
					<label><?= __('Mail', 'jm') ?><input name="email" type="mail" placeholder="1233242@gmail.com"></label>
					<label><?= __('Name', 'jm') ?><input name="name" type="text" placeholder="<?= __('John Smith', 'jm') ?>"></label>
					<label><?= __('Message', 'jm') ?><input name="message" type="text" placeholder="<?= __('Write here', 'jm') ?>"></label>
					<p class="message">
						<?= __('Your message has been sent', 'jm') ?>
					</p>
					<input type="submit" value="<?= __('Send', 'jm') ?>">
				</form>
				<div class="feedback__footer">
					<div class="feedback__label">
						<?= __('Follow us:', 'jm') ?>
					</div>
					<div class="feedback__socials">
						<?php
						$socials = get_field('socials', 'option');
						foreach ($socials as $social) :
						?>
							<a target="_blank" href="<?= $social['social_link'] ?>">
								<img src="<?= $social['social_icon'] ?>" alt="socials">
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="policy" style="background-image: url(<?php the_field('privacy_policy_background'); ?>), linear-gradient(115.33deg, #891DDF 0%, #6611AD 67.71%, #5E009C 85.94%)">
		<div class="container">
			<div class="policy__text">
				<h2 class="policy__title title-2">
					<a href="<?= home_url('privacy-policy') ?>">
						<?php the_field('privacy_policy_title'); ?>
					</a>
				</h2>
				<p class="policy__desc">
					<?php the_field('privacy_policy_description'); ?>
				</p>
				<div class="policy__app app-block">
					<div class="app-block__title">
						<?= __('Get the App', 'jm') ?>
					</div>
					<?php
					$buttons = get_field('button_group', 'option');
					foreach ($buttons as $button) :
					?>
						<a href="<?= $button['button_group_link'] ?>" class="download-btn">
							<img src="<?= $button['button_group_image'] ?>" alt="Google Play">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="policy__img">
				<img src="<?= get_template_directory_uri() ?>/assets/images/Phone_Mockup.png" alt="Phone Mockup">
				<img src="<?= get_template_directory_uri() ?>/assets/images/Phone_Mockup1.png" alt="Phone Mockup">
			</div>
		</div>
	</section>

</main>



<?php

get_footer();
