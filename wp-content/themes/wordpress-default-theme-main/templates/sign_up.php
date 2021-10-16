<?php

/**
 * Template Name: Sign in
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */

if (is_user_logged_in()) {
    wp_redirect(home_url('account'));
}

get_header(); ?>

<main class="sign sign-up">
    <div class="container">
        <h1 class="sign__title ">
            <?= __('Sign up', 'jm') ?>
        </h1>
        <form class="old-form sign__form sign__form--up form js-sign-up-form">
            <label><?= __('First name', 'jm') ?><input required name="first_name" type="text" placeholder="<?= __('Name', 'jm') ?>"></label>
            <label><?= __('Last name', 'jm') ?><input required name="last_name" type="text" placeholder="<?= __('Name', 'jm') ?>"></label>
            <label><?= __('Phone', 'jm') ?><input required name="phone" type="tel" placeholder="1233242"></label>
            <label><?= __('Mail', 'jm') ?><input required name="email" type="mail" placeholder="1233242@gmail.com"></label>
            <label><?= __('Password', 'jm') ?><input required name="password" type="password" placeholder="*********"></label>
            <label><?= __('Confirm password', 'jm') ?><input required name="confirm_password" type="password" placeholder="*********"></label>
            <input type="checkbox" required name="check-1" id="check-1" /><label for="check-1"><?= __('Agree with', 'jm') ?> <span><a href="<?= home_url('terms-and-conditions') ?>"><?= __('Terms & Conditions', 'jm') ?></a></span></label>
            <input type="checkbox" required name="check-2" id="check-2" /><label for="check-2"><?= __('Agree with', 'jm') ?> <span><a href="<?= home_url('privacy-policy') ?>" target="_blank"><?= __('Privacy Policy', 'jm') ?></a></span></label>
            <p class="message-error"></p>
            <input type="submit" value="<?= __('Send', 'jm') ?>">
            <a href="<?= home_url('sign-in') ?>" target="_blank"><?= __('Already have an account? Log in', 'jm') ?></a>
        </form>

        <button class="google_btn" id="js-google-btn">
            <img src="<?= get_template_directory_uri() . '/assets/images/google+.png' ?>" alt="google+">
            <?= __('Sign in with Google', 'jm') ?>
        </button>

    </div>
</main>


<?php

get_footer();
