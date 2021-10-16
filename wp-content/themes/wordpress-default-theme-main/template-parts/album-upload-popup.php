<?php global $user; ?>
<div class="popup popup-album" id="popup-album">
    <form class="popup__box custom-scrollbar">
        <input type="hidden" name="user_id" value="<?= $user->ID ?>">
        <div class="popup__title title-2">
            <?= __('Upload Album', 'jm') ?>
        </div>
        <div class="popup-form popup-form--first form">
            <label><?= __('Full name of artist in English', 'jm') ?><input name="album_artist" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
            <label><?= __('Full name of artist In Hebrew', 'jm') ?><input name="album_artist_he" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
        </div>
        <div class="popup-form popup-form--first form">
            <label><?= __('Album Name in English', 'jm') ?><input name="album_name" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
            <label><?= __('Album Name In Hebrew', 'jm') ?><input name="album_name_he" type="text" placeholder="<?= __('Name', 'jm') ?>" required></label>
        </div>
        <div class="popup__subtitle"><?= __('Album cover', 'jm') ?></div>
        <div class="popup-form-body">
            <div class="account-box" id="#js-drag-area-2">
                <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-2" class="remove-btn">
                <div class="account-box__title">
                    <?= __('Drag your photo here', 'jm') ?>
                </div>
                <div class="account-box__subtitle">
                    <?= __('Or choose from your computer', 'jm') ?>
                </div>
                <div class="account-box__label">
                    <?= __('image size should be at least 600x600', 'jm') ?>
                </div>
                <div class="account-box__error-message"><?= __('image must be square sized', 'jm') ?></div>
                <input class="account-box__input" name="album_cover" type="file" id="js-image-input-2" accept=".jpg, .png, .jpeg" required>
                <img class="account-box__image" src="" alt="" id="js-target-image-2">
            </div>
            <div class="account-list">
                <ul class="custom-scrollbar"></ul>
                <div class="add-more js-add-more-songs">
                    <!--<input class="add-more__input" type="file">-->
                    <?= __('Add song', 'jm') ?>
                </div>
            </div>
        </div>
        <div class="popup-form form popup-form--textarea">
            <label>
                <?= __('Comment',  'jm') ?>
                <textarea class="popup-form__comment" name="album_comment" placeholder="<?= __('Leave your comment', 'jm') ?>"></textarea>
            </label>
        </div>
        <div class="popup-form popup-form--last form">
            <label><?= __('Genre', 'jm') ?>
                <select name="genre[]" class="select-genre" multiple="multiple" required>
                    <?php
                    $genres = get_field('genre_list', 'options');
                    foreach ($genres as $genre) :
                    ?>
                        <option value="<?= $genre['genre_item'] ?>"><?= __($genre['genre_item'], 'jm-genre') ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label><?= __('Release Date', 'jm') ?><input required name="album_release_date" type="date" max="2030-12-31" placeholder="<?= __('Release Date', 'jm') ?>"></label>
            <label><?= __('Record Label', 'jm') ?><input required name="album_record_label" type="text" placeholder="<?= __('Record Label', 'jm') ?>"></label>

            <?php $checkbox_text = get_field('checkbox_text', 'option'); ?>
            <input type="checkbox" name="album_check_agree" id="check3" required /><label for="check3"><?= $checkbox_text['terms_and_conditions'] ?></label>
            <input type="checkbox" name="album_check_policy" id="check4" required /><label for="check4"><?= $checkbox_text['privacy_policy'] ?></span></label>
        </div>
        <input name="album_submit" class="btn btn-text btn--dark" type="submit" value="<?= __('Upload album', 'jm') ?>">
    </form>
</div>
