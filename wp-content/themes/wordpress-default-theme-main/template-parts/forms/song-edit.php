<?php
global $user;
$genres = get_field('genre_list', 'options');
?>

<form id="form-song-edit" class="form l-song-form js-song-edit " data-layout="song-edit">
  <input type="hidden" name="user_id" value="<?= $user -> ID ?>">
  <input type="hidden" name="post_id" value="">

  <h2 class="form__title"><?= __('Update song', 'jm') ?></h2>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in English', 'jm') ?></label>
    <input class="input-text" name="song_artist" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in Hebrew', 'jm') ?></label>
    <input class="input-text" name="song_artist_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Artist photo', 'jm') ?></label>
    <div class="account-box" id="#js-drag-area-6">
      <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-6" class="remove-btn">
      <div class="account-box__title">
        <?= __('Drag your photo here', 'jm') ?>
      </div>
      <div class="account-box__subtitle">
        <?= __('Or choose from your computer', 'jm') ?>
      </div>
      <input class="account-box__input" name="song_artist_photo" type="file" id="js-image-input-6" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--artist" src="" alt="" id="js-target-image-6">
    </div>
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Song Name in English', 'jm') ?></label>
    <input class="input-text" name="song_name" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Song Name in Hebrew', 'jm') ?></label>
    <input class="input-text" name="song_name_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Song artwork', 'jm') ?></label>
    <div class="account-box" id="#js-drag-area-3">
      <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-3" class="remove-btn">
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
      <input class="account-box__input" name="song_cover" type="file" id="js-image-input-3" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--thumb" src="" alt="" id="js-target-image-3">
    </div>
  </div>

  <div class="form__group form__group--full-width">
    <ul class="js-song-list song-list"></ul>
    <button class="more-song-btn">
      <?= __('Add song', 'jm') ?>
      <input type="file" name="song_file" accept="audio/*">
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
    <input class="input-text" required name="release_date" type="date" max="2030-12-31" placeholder="<?= __('Release Date', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Record label', 'jm') ?></label>
    <input class="input-text" required name="record_label" type="text" placeholder="<?= __('Record Label', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Comment', 'jm') ?></label>
    <textarea class="textarea" name="song_comment"></textarea>
  </div>

  <div class="form__group form__group--full-width"><button class="btn btn-text btn--dark" type="submit"><?= __('Update song', 'jm') ?></button></div>

</form>
