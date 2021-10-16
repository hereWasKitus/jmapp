<?php

/**
 * Template Name: Account
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */
if (!is_user_logged_in()) {
    wp_redirect(home_url('sign-up'));
}

get_header();
$user = wp_get_current_user();
$songs = new WP_Query([
    'post_type' => 'song',
    'author' => $user->ID,
    'posts_per_page' => 5
    // 'tag' => 'single_song'
]);

$albums = new WP_Query([
    'post_type' => 'album',
    'author' => $user->ID,
    'posts_per_page' => 5
]);

$user_signature = get_user_meta( $user -> ID, 'user_signature', true );
?>

<main class="account">
    <div class="container">
        <header class="account__header">
            <h1 class="account__title title-2">
                <?= __('My account', 'jm') ?>
            </h1>
            <?php
            $class = !$user_signature ? 'js-open-signature-popup' : '';
            $song_attr = !$user_signature ? '' : 'id="upload-song"';
            $album_attr = !$user_signature ? '' : 'id="upload-album"';
            ?>
            <div class="account__btn <?= $class ?>">
                <button <?= $album_attr ?> class="account__btn-el btn btn--light">
                    <span><?= __('Upload album', 'jm') ?></span>
                </button>
                <button <?= $song_attr ?> class="account__btn-el btn btn--dark">
                    <span><?= __('Upload song', 'jm') ?></span>
                </button>
            </div>
        </header>
        <section class="account__block">
            <div class="account-link active <?php if (!($songs->have_posts())) {
                                                echo 'other';
                                            } ?>">
                <img src="<?= get_template_directory_uri() ?>/assets/images/Icon/songs.svg" alt="songs">
                <?= __('My songs', 'jm') ?>
            </div>
            <div class="account-content account-songs">
                <?php if ($songs->have_posts()) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th><?= __('Cover', 'jm') ?></th>
                                <th><?= __('Song name', 'jm') ?></th>
                                <th><?= __('Artist name', 'jm') ?></th>
                                <!-- <th><?= __('Album', 'jm') ?></th> -->
                                <th><?= __('Date of submit', 'jm') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($songs->have_posts()) {
                                // TODO: add support for 'album' field
                                $songs->the_post();
                                get_template_part('template-parts/loop/song-item');
                            };
                            wp_reset_postdata();
                            ?>
                        </tbody>
                    </table>
                    <?php if ($songs->post_count >= 5) : ?>
                        <button class="btn btn--dark js-load-more" data-offset="<?= $songs->post_count ?>"><?= __('Show more', 'jm') ?></button>
                    <?php endif; ?>
                <?php } else { ?>
                    <table class="table-other">
                        <tbody class="content-none">
                            <tr>
                                <td colspan="8">
                                    <div class="content-none__block">
                                        <img src="<?= get_template_directory_uri() ?>/assets/images/content-none.png" alt="upload" class="content-none__img">
                                        <div class="content-none__title">
                                            <?= __('Upload your songs', 'jm') ?>
                                        </div>
                                        <?php if ( !$user_signature ): ?>
                                        <div class="content-none__btn btn btn--dark js-open-signature-popup">
                                            <?= __('Upload', 'jm') ?>
                                        </div>
                                        <?php else: ?>
                                        <div class="content-none__btn btn btn--dark" id="song-none__btn">
                                            <?= __('Upload', 'jm') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <div class="account-link <?php if (!($albums->have_posts())) {
                                            echo 'other';
                                        } ?>">
                <img src="<?= get_template_directory_uri() ?>/assets/images/Icon/albums.svg" alt="albums">
                <?= __('My albums', 'jm') ?>
            </div>
            <div class="account-content account-albums">
                <?php if ($albums->have_posts()) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th><?= __('Cover', 'jm') ?></th>
                                <th><?= __('Album name', 'jm') ?></th>
                                <th><?= __('Artist name', 'jm') ?></th>
                                <th><?= __('Songs include', 'jm') ?></th>
                                <th><?= __('Date of upload', 'jm') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($albums->have_posts()) {
                                // TODO: add support for 'album' field
                                $albums->the_post();
                                get_template_part('template-parts/loop/album-item');
                            };
                            wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                    <?php if ($albums->post_count >= 5) : ?>
                        <button class="btn btn--dark js-load-more" data-offset="<?= $albums->post_count ?>"><?= __('Show more', 'jm') ?></button>
                    <?php endif; ?>
                <?php } else { ?>
                    <table class="table-other">
                        <tbody class="content-none">
                            <tr>
                                <td colspan="8">
                                    <div class="content-none__block">
                                        <img src="<?= get_template_directory_uri() ?>/assets/images/content-none.png" alt="upload" class="content-none__img">
                                        <div class="content-none__title">
                                            <?= __('Upload your albums', 'jm') ?>
                                        </div>
                                        <?php if ( !$user_signature ): ?>
                                        <div class="content-none__btn btn btn--dark js-open-signature-popup">
                                            <?= __('Upload', 'jm') ?>
                                        </div>
                                        <?php else: ?>
                                        <div class="content-none__btn btn btn--dark" id="album-none__btn">
                                            <?= __('Upload', 'jm') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <div class="account-link account-link--other">
                <img src="<?= get_template_directory_uri() ?>/assets/images/Icon/settings.svg" alt="settings">
                <?= __('Settings', 'jm') ?>
            </div>
            <form class="old-form account-content account-settings js-account-form">
                <div class="account__form form">
                    <label><?= __('Name', 'jm') ?><input name="account_name" type="text" data-value="<?= $user->display_name; ?>" value="<?= $user->display_name; ?>"></label>
                    <label><?= __('Change password', 'jm') ?><input name="account_password" type="password" placeholder="********"></label>
                    <label><?= __('E-mail', 'jm') ?><input name="account_mail" type="mail" data-value="<?= $user->user_email; ?>" value="<?= $user->user_email; ?>"></label>
                    <label><?= __('Confirm Password', 'jm') ?><input name="account_confirm" type="password" placeholder="********"></label>
                    <div class="canvas-container <?= $user_signature ? 'has-signature' : '' ?>">
                        <?= __('Your signature', 'jm') ?>
                        <button class="btn btn-text btn--dark js-change-signature"><?= __('Change signature', 'jm') ?></button>
                        <div class="canvas-container__inner">
                            <canvas id="user-signature" class="signature-canvas" style="cursor: url('<?= get_template_directory_uri() . '/assets/images/pen.png' ?>'), auto"></canvas>
                            <button class="btn btn-text btn--dark js-clear-canvas"><?= __('Erase', 'jm') ?></button>
                        </div>
                    </div>
                    <p class="message-success"><?= __('Data updated', 'jm') ?></p>
                    <input name="account_submit" class="btn btn-text btn--dark" type="submit" value="<?= __('Save', 'jm') ?>">
                    <input type="hidden" name="user_id" value="<?= $user->ID ?>">
                </div>
                <div class="account__photo">
                    <div class="account-subtitle">
                        <?= __('Profile photo', 'jm') ?>
                    </div>
                    <div class="account-box" id="#js-drag-area">
                        <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image" class="remove-btn">
                        <div class="account-box__title">
                            <?= __('Drag your photo here', 'jm') ?>
                        </div>
                        <div class="account-box__subtitle">
                            <?= __('Or choose from your computer', 'jm') ?>
                        </div>
                        <input class="account-box__input" name="user_avatar" type="file" id="js-image-input" accept=".jpg, .png, .jpeg">
                        <?php $user_image = get_user_meta($user -> ID, 'user_avatar', true); ?>
                        <?php if ( $user_image ): ?>
                        <img class="account-box__image show" src="<?= $user_image ?>" alt="jewishmusic user avatar" id="js-target-image">
                        <?php else: ?>
                        <img class="account-box__image" src="" alt="jewishmusic user avatar" id="js-target-image">
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>

<?php //get_template_part('template-parts/song-upload-popup') ?>
<?php //get_template_part('template-parts/song-edit-popup') ?>
<?php //get_template_part('template-parts/album-upload-popup') ?>
<?php //get_template_part('template-parts/album-edit-popup') ?>
<?php get_template_part('template-parts/notification-popup') ?>
<?php get_template_part('template-parts/thanks-popup') ?>

<div class="overflow js-sidebar-overflow">
    <?php get_template_part('template-parts/sidebar', null, ['slot' => 'content']) ?>
</div>

<?php
if ( !$user_signature ) {
    get_template_part('template-parts/signature-popup');
}
?>

<?php
get_footer();
