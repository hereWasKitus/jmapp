<?php global $user; ?>
<div class="popup popup-signature" id="signature-popup">
  <form class="popup__box custom-scrollbar">
    <i class="popup__close symbol symbol--close"></i>
    <input type="hidden" name="user_id" value="<?= $user->ID ?>">
    <h2 class="popup-signature__title"><?= __('Your signature', 'jm') ?></h2>
    <p class="popup-signature__subtitle"><?= __('To upload songs & albums you have to sign your signature', 'jm') ?></p>
    <div class="canvas-container">
      <div class="canvas-container__inner">
        <canvas id="user-signature-popup" class="signature-canvas" style="cursor: url('<?= get_template_directory_uri() . '/assets/images/pen.png' ?>'), auto"></canvas>
        <button class="btn btn-text btn--dark js-clear-canvas"><?= __('Erase', 'jm') ?></button>
        <input type="hidden" name="user_signature">
      </div>
    </div>
    <input type="submit" class="btn btn-text btn--dark" value="<?= __('Save', 'jm') ?>">
  </form>
</div>
