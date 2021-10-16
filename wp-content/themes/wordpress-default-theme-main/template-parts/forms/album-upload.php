<?php
global $user;
$genres = get_field('genre_list', 'options');
$checkbox_text = get_field('checkbox_text', 'option');
?>

<form class="form l-song-form js-album-upload " data-layout="album-upload">
  <input type="hidden" name="user_id" value="<?= $user -> ID ?>">
  <h2 class="form__title"><?= __('Upload Album', 'jm') ?></h2>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in English', 'jm') ?></label>
    <input required class="input-text" name="album_artist" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in Hebrew', 'jm') ?></label>
    <input required class="input-text" name="album_artist_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Artist photo', 'jm') ?></label>
    <div class="account-box" id="#js-drag-area-7">
      <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-7" class="remove-btn">
      <div class="account-box__title">
        <?= __('Drag your photo here', 'jm') ?>
      </div>
      <div class="account-box__subtitle">
        <?= __('Or choose from your computer', 'jm') ?>
      </div>
      <input class="account-box__input" name="album_artist_photo" type="file" id="js-image-input-7" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--artist" src="" alt="" id="js-target-image-7">
    </div>
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Album Name in English', 'jm') ?></label>
    <input required class="input-text" name="album_name" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Album Name in Hebrew', 'jm') ?></label>
    <input required class="input-text" name="album_name_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Album cover', 'jm') ?></label>
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
      <input required class="account-box__input" name="album_cover" type="file" id="js-image-input-2" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--thumb" src="" alt="" id="js-target-image-2">
    </div>
  </div>

  <div class="form__group form__group--full-width">
    <ul class="js-song-list song-list"></ul>
    <button class="more-song-btn">
      <?= __('Add song', 'jm') ?>
    </button>
  </div>

  <div class="form__group form__group--full-width">
    <select class="form__select js-select" name="genre[]" required multiple="multiple">
      <?php foreach ( $genres as $genre ): ?>
      <option value="<?= $genre['genre_item'] ?>"><?= __( $genre['genre_item'], 'jm-genre' ) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Release Date', 'jm') ?></label>
    <input class="input-text" required name="album_release_date" type="date" max="2030-12-31" placeholder="<?= __('Release Date', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Record label', 'jm') ?></label>
    <input class="input-text" required name="album_record_label" type="text" placeholder="<?= __('Record Label', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Comment', 'jm') ?></label>
    <textarea class="textarea" name="album_comment"></textarea>
  </div>

  <?php foreach ( $checkbox_text as $text ): ?>
  <div class="form__group form__group--full-width">
    <div class="form__checkbox"><input type="checkbox" required><span></span></div>
    <div class="form__text"><?= $text ?></div>
  </div>
  <?php endforeach; ?>

  <div class="form__group form__group--full-width"><button class="btn btn-text btn--dark" type="submit"><?= __('Upload album', 'jm') ?></button></div>

</form>
