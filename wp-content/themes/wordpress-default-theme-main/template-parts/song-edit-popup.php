<?php global $user; ?>
<div class="popup popup-song-edit" id="popup-song-edit">
    <form class="popup__box custom-scrollbar">
        <input type="hidden" name="user_id" value="<?= $user->ID ?>">
        <input type="hidden" name="post_id" value="">
        <div class="popup__title title-2">
            <?= __('Update Song', 'jm') ?>
        </div>
        <div class="popup-form popup-form--first form">
            <label><?= __('Full name of artist in English', 'jm') ?><input name="song_artist" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
            <label><?= __('Full name of artist In Hebrew', 'jm') ?><input name="song_artist_he" type="text" placeholder="<?= __('Name', 'jm') ?>"></label>
        </div>
        <div class="popup-form popup-form--first form">
            <label><?= __('Song Name in English', 'jm') ?><input name="song_name" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
            <label><?= __('Song Name In Hebrew', 'jm') ?><input name="song_name_he" type="text" placeholder="<?= __('Name', 'jm') ?>"></label>
        </div>
        <div class="popup__subtitle"><?= __('Song artwork', 'jm') ?></div>
        <div class="popup-form-body">
            <div class="account-box" id="#js-drag-area-3">
                <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-3" class="remove-btn">

                <div class="account-box__title"><?= __('Drag your photo here', 'jm') ?></div>
                <div class="account-box__subtitle"><?= __('Or choose from your computer', 'jm') ?></div>
                <div class="account-box__label"><?= __('image size should be at least 600x600', 'jm') ?></div>
                <div class="account-box__error-message"><?= __('image must be square sized', 'jm') ?></div>

                <input class="account-box__input" name="song_cover" type="file" id="js-image-input-3" accept=".jpg, .png, .jpeg">
                <img class="account-box__image" src="" alt="" id="js-target-image-3">
            </div>
            <div class="account-list">
                <ul class="custom-scrollbar">
                    <!-- Song item -->
                </ul>
                <span class="js-add-more add-more"><?= __('Add song', 'jm') ?></span>
                <input type="file" name="song_file" accept="audio/*">
            </div>
        </div>
        <div class="popup-form form popup-form--textarea">
            <label>
                <?= __('Comment',  'jm') ?>
                <textarea class="popup-form__comment" name="song_comment" placeholder="<?= __('Leave your comment', 'jm') ?>"></textarea>
            </label>
        </div>
        <div class="popup-form popup-form--last form">
            <label><?= __('Genre', 'jm') ?>
               <select name="genre[]" class="select-genre" multiple="multiple">
                    <?php
                    $genres = get_field('genre_list', 'options');
                    foreach ($genres as $genre) :
                    ?>
                        <option value="<?= $genre['genre_item'] ?>"><?= __($genre['genre_item'], 'jm-genre') ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label><?= __('Release Date', 'jm') ?><input name="release_date" type="date" max="2030-12-31" placeholder="<?= __('Release Date', 'jm') ?>"></label>
            <label><?= __('Record Label', 'jm') ?><input name="record_label" type="text" placeholder="<?= __('Record Label', 'jm') ?>"></label>
            </label>
        </div>
        <input name="song_submit" class="btn btn-text btn--dark" type="submit" value="<?= __('Update song', 'jm') ?>">
    </form>
</div>
