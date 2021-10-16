<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package coelix
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<meta name="google-signin-client_id" content="995200861756-g8ecmvak7g2qvtcga132rcokjl6s603b.apps.googleusercontent.com">-->
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v9.0" nonce="6EHDCwNi"></script>

	<header class="header">
		<div class="container">
			<div class="burger" id="burger">
				<span></span>
			</div>
			<div class="language language-mobile">
				<?php function wpml_lang_switcher()
				{
					$languages = icl_get_languages();
				?>
					<?php foreach ($languages as $lang) : ?>
						<a href="<?= $lang['url'] ?>" class="<?php if ($lang['active']) {
																	echo 'active';
																} ?>">
							<img src="<?= $lang['country_flag_url'] ?>">
						</a>
					<?php endforeach; ?>
				<?php }
				wpml_lang_switcher();
				?>
			</div>
			<div class="logo header__logo">
				<?= get_custom_logo(); ?>
			</div>
			<div class="overlay <?php if (is_user_logged_in()) {
									echo 'overlay--other';
								} ?>">
				<?php
				wp_nav_menu([
					'theme_location'  => 'main-menu',
					'container'       => false,
					'menu_class'      => 'header__nav menu text',
					'items_wrap'      => '<nav id="%1$s" class="%2$s">%3$s</nav>',
				]);
				?>

				<?php
				if (is_user_logged_in()) {
					$current_user = wp_get_current_user();
					$user_meta = get_user_meta($current_user->ID);
				?>
					<div class="user-data">
						<div class="user-data__name"><?= $current_user->display_name ?></div>
						<div class="user-data__photo">
							<img src="<?= $user_meta['user_avatar'][0] ?>" alt="photo">
						</div>
						<div class="user-data__btn">
							<img src="<?= get_template_directory_uri() ?>/assets/images/Icon/arrow.svg" alt="arrow">
						</div>
						<div class="user-data__menu">
							<a href="<?= home_url('account') ?>"><?= __('My account', 'jm') ?></a>
							<a href="<?php echo wp_logout_url(home_url('sign-in')); ?>"><?= __('Log out', 'jm') ?></a>
							<div class="language"><?php wpml_custom_switcher(); ?></div>
						</div>
					</div>
				<?php } else { ?>
					<a href="<?= home_url('sign-in') ?>" class="btn btn--dark text">
						<?= __('Sign in', 'jm') ?>
					</a>
					<a href="<?= home_url('sign-up') ?>" class="btn btn--dark text">
						<?= __('Sign up', 'jm') ?>
					</a>
					<div class="language">
						<?php wpml_custom_switcher(); ?>
					</div>
				<?php } ?>
			</div>
			<?php if (is_user_logged_in()) { ?>
				<a href="<?= home_url('account') ?>" class="user-logo">
					<img src="<?= $user_meta['user_avatar'][0] ?>" alt="user">
				</a>
			<?php } ?>
		</div>
	</header><!-- #masthead -->
