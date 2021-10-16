<?php
$popup_text = get_field('thanks_popup_text', 'option');
$default = [
  'title' => !is_rtl() ? 'Thanks for uploading your songs' : 'תודה שהעלית את השירים שלך',
  'text' => !is_rtl() ? '<p>we will review all the information you sent and proceed with the upload</p><p>please note it could take up to 14 days for the songs to appear on our platform</p>' : "<p>אנחנו נעבור על כל המידע ששלחת ונמשיך עם ההעלאה</p><p>שים לב שזה יכול לקחת עד 14 ימים עד שהשירים יופיע בפלטפורמה שלנו</p>",
]
?>

<div class="popup popup-thanks" id="popup-thanks">
  <div class="popup__box custom-scrollbar">
    <i class="popup__close symbol symbol--close"></i>
    <h2><?= $popup_text['title'] ?: $default['title'] ?></h2>
    <?= $popup_text['text'] ?: $default['text'] ?>
    <button class="btn btn-text btn--dark popup__close">OK</button>
  </div>
</div>