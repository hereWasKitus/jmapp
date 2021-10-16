/**
 * Sidebar
 */

$(document).on('show-sidebar', (e, layout) => {
  $('.sidebar [data-layout]').removeClass('active');
  $('.overflow').addClass('active');

  $('html, body').addClass('scroll-block');

  if ( layout ) {
    $(`.sidebar [data-layout='${layout}']`).addClass('active');
  }

  $('.sidebar').addClass('active');
});

$(document).on('hide-sidebar', () => {
  $('.overflow, .sidebar').removeClass('active');
  $('html, body').removeClass('scroll-block');
});

$('.js-sidebar [data-action="hide"]').on( 'click', () => $(document).trigger('hide-sidebar') );
$('.js-sidebar-overflow').on('click', e => {
  if ( e.target.classList.contains('js-sidebar-overflow') ) $(document).trigger('hide-sidebar');
})
