$('.popup').on('show', function (e, info) {
  $(this).addClass('active');
  $('body').addClass('fixed');
  blockBodyScroll();
});

$('.popup').on('hide', function (e) {
  $(this).removeClass('active');
  $('body').removeClass('fixed');
  enableBodyScroll();
});

$('.popup').on('mousedown', function (e) {
  let $target = $(e.target);

  if ($target.hasClass('popup')) {
    $target.trigger('hide');
  }

  if ($target.hasClass('popup__close')) {
    e.preventDefault();
    $target.closest('.popup').trigger('hide');
  }
});
