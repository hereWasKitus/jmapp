<?php

/**
 * Template Name: Sign up
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */

if (is_user_logged_in()) {
    wp_redirect(home_url('account'));
}
get_header(); ?>

<main class="sign sign-in">
    <div class="container">
        <h1 class="sign__title ">
            <?= __('Sign in', 'jm') ?>
        </h1>
        <form class="old-form sign__form sign__form--in form js-sign-in-form">
            <label><?= __('Mail', 'jm') ?><input name="email" type="mail" placeholder="1233242@gmail.com"></label>
            <label><?= __('Password', 'jm') ?><input name="password" type="password" placeholder="*********"></label>
            <input type="checkbox" name="check" id="check" /><label for="check"><?= __('Remember me', 'jm') ?></label>
            <p class="message-error"></p>
            <input type="submit" value="<?= __('Send', 'jm') ?>">
            <a href="#" id="recovery_password"><?= __('Forgot password?', 'jm') ?></a>
            <a href="<?= home_url('sign-up') ?>"><?= __('Not registered yet? Create an account', 'jm') ?></a>
        </form>
        <button class="google_btn" id="js-google-btn">
            <img src="<?= get_template_directory_uri() . '/assets/images/google+.png' ?>" alt="google+">
            <?= __('Sign in with Google', 'jm') ?>
        </button>
    </div>
</main>

<div class="popup popup-recovery" id="popup-recovery">
    <div class="popup__box">
        <p>
            <?= __('Please enter your username or email address. You will receive an email message with instructions on how to reset your password.', 'jm') ?>
        </p>
        <form class="form js-recovery-form">
            <label><?= __('Email Address', 'jm') ?><input name="mail_recovery" type="email" placeholder="1233242@gmail.com"></label>
            <p class="recovery-message-error"></p>
            <input type="submit" value="<?= __('Send', 'jm') ?>">
        </form>
    </div>
</div>

<?php

get_footer();
