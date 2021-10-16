<?php
global $user;
$genres = get_field('genre_list', 'options');
?>

<form class="form l-song-form js-album-edit" data-layout="album-edit">
  <input type="hidden" name="user_id" value="<?= $user -> ID ?>">
  <input type="hidden" name="post_id" value="">
  <input type="hidden" name="delete_queue" value="" class="js-delete-queue">

  <h2 class="form__title"><?= __('Update Album', 'jm') ?></h2>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in English', 'jm') ?></label>
    <input class="input-text" name="album_artist" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Full name of artist in Hebrew', 'jm') ?></label>
    <input class="input-text" name="album_artist_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Artist photo', 'jm') ?></label>
    <div class="account-box" id="#js-drag-area-8">
      <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-8" class="remove-btn">
      <div class="account-box__title">
        <?= __('Drag your photo here', 'jm') ?>
      </div>
      <div class="account-box__subtitle">
        <?= __('Or choose from your computer', 'jm') ?>
      </div>
      <input class="account-box__input" name="album_artist_photo" type="file" id="js-image-input-8" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--artist" src="" alt="" id="js-target-image-8">
    </div>
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Album Name in English', 'jm') ?></label>
    <input class="input-text" name="album_name" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group">
    <label class="form__label"><?= __('Album Name in Hebrew', 'jm') ?></label>
    <input class="input-text" name="album_name_he" type="text" placeholder="<?= __('Name', 'jm') ?>">
  </div>

  <div class="form__group form__group--full-width">
    <label class="form__label"><?= __('Album cover', 'jm') ?></label>
    <div class="account-box" id="#js-drag-area-4">
      <img src="<?= get_template_directory_uri() . '/assets/images/close.png' ?>" alt="close" id="js-remove-image-4" class="remove-btn">
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
      <input class="account-box__input" name="album_cover" type="file" id="js-image-input-4" accept=".jpg, .png, .jpeg">
      <img class="account-box__image account-box__image--thumb" src="" alt="" id="js-target-image-4">
    </div>
  </div>

  <div class="form__group form__group--full-width">
    <ul class="js-song-list song-list"></ul>
    <button class="more-song-btn">
      <?= __('Add song', 'jm') ?>
    </button>
  </div>

  <div class="form__group form__group--full-width">
    <select class="form__select js-select" name="genre[]"
     multiple="multiple">
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

  <div class="form__group form__group--full-width"><button class="btn btn-text btn--dark" type="submit"><?= __('Update album', 'jm') ?></button></div>

</form>
