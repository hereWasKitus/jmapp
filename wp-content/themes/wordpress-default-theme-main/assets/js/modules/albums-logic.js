const {renderAlbumItems, renderSongRow} = require('./template-engine');

$('#upload-album').on('click', function () {
  // $('#popup-album form')
  //   .trigger('reset')
  //   .find('.account-box__image').attr('src', '')
  //   .removeClass('show');
  // $('#popup-album').trigger('show');
  $(document).trigger('show-sidebar', ['album-upload']);

  if ($('.account-box').hasClass('error-size')) {
    $('.account-box').removeClass('error-size')
  }
});

$('#album-none__btn').on('click', function () {
  // $('#popup-album form')
  //   .trigger('reset')
  //   .find('.account-box__image').attr('src', '')
  //   .removeClass('show');
  // $('#popup-album').trigger('show');

  $(document).trigger('show-sidebar', ['album-upload']);
});

/**
 * Album upload function
 */
$('.js-album-upload').on('submit', function (e) {
  e.preventDefault();

  let error_message = $('.error_message');
  let formdata = new FormData(this);

  // TODO: display error
  if ( $(e.currentTarget).find('.js-song-list').children().length == 0 ) {
    let add_song_button = $(e.currentTarget).find('.more-song-btn')[0];

    add_song_button.scrollIntoView();
    add_song_button.animate([
      {transform: `scale(1.2)`},
      {transform: `scale(1)`}
    ], {
      duration: 600,
      iterations: 2,
      easing: 'ease-in-out'
    });
    return;
  }

  $.ajax({
    url: `${wp.custom_rest_url}/albums`,
    data: formdata,
    contentType: false,
    processData: false,
    type: 'POST',
    beforeSend () {
      e.currentTarget.classList.add('loading');
    },
    success(resp) {
      e.currentTarget.classList.remove('loading');
      let data = JSON.parse(resp);
      console.log(data);

      if (!data.success) {
        console.log(data);
        return;
      }

      $(document).trigger('hide-sidebar');
      $('#popup-thanks').trigger('show');
    },
  })
});

/**
 * Album edit function
 */
$('.js-album-edit').on('submit', function (e) {
  e.preventDefault();

  let formdata = new FormData(this);

  $.ajax({
    url: `${wp.custom_rest_url}/albums`,
    data: formdata,
    contentType: false,
    processData: false,
    type: 'POST',
    beforeSend () {
      e.currentTarget.classList.add('loading');
    },
    success(resp) {
      e.currentTarget.classList.remove('loading');
      let data = JSON.parse(resp);
      console.log(data);

      if (!data.success) {
        console.log(data);
        return;
      }

      window.location.reload();
    },
  })
});

/**
 * Album delete function
 */
$('.account-albums tbody').on('click', '.delete-row', function (e) {
  const $row = $(this).closest('tr');

  $.ajax({
    url: `${wp.custom_rest_url}/albums`,
    type: 'DELETE',
    data: {
      id: parseInt($row.data('post_id'), 10)
    },
    success: function (resp) {
      let data = JSON.parse(resp);

      if (!data.success) {
        console.log(data);
        return;
      }

      $row.addClass('fade-out');
      setTimeout(() => {
        $row.remove();
        if ($('.account-albums tbody')[0].childElementCount === 0) {
          window.location.reload();
        }
      }, 405);
    }
  });
});

/**
 * Load more albums
 */
$('.account-albums .js-load-more').on('click', function (e) {
  e.preventDefault();
  let self = e.currentTarget;
  let offset = parseFloat( $(self).data('offset'), 10 );

  $.ajax(`${wp.custom_rest_url}/albums`, {
    data: {
      offset,
      limit: 5,
      author: wp.current_user_id
    },
    beforeSend() {
      $(self).addClass('is-disabled');
    },
    success(resp) {
      if (resp.length < 1) {
        $(self).remove();
        return;
      }

      $(self).removeClass('is-disabled');

      let album_items = renderAlbumItems(resp);
      $('.account-albums table').append(album_items);
      tabParentHeight();

      offset += resp.length;
      $(self).data('offset', offset);
    }
  });
});

/**
 * Add songs rows feature
 */
$('.js-album-upload .more-song-btn').on('click', function (e) {
  e.preventDefault();
  let $list_el = $(e.currentTarget).closest('form').find('.js-song-list');
  let row = renderSongRow( $list_el.children().length + 1 ); // get index not from count, but take last item index and increment it
  $list_el.append(row);
  // do stuff
});

$('.account-albums').on('click', '.edit-row', function (e) {
  e.preventDefault();
  let post_id = parseInt( $(e.currentTarget).closest('tr').data('post_id'), 10 );
  let $popup = $('.js-album-edit');

  $popup.find('.js-song-list').html('');
  $popup.find(`.account-box__image`).removeClass('show');

  $.ajax(`${wp.custom_rest_url}/albums`, {
    data: {
      id: post_id
    },

    success (resp) {
      const fields = resp[0].fields;
      $popup.find('[name="post_id"]').val(resp[0].id);
      console.log(fields);

      for (const key in fields) {
        const value = fields[key];

        if ( key === 'thumbnail' && value ) {
          $popup.find(`.account-box__image--thumb`)
            .attr('src', value)
            .addClass('show');
          continue;
        }

        if ( key === 'album_artist_photo' && value ) {
          $popup.find(`.account-box__image--artist`)
            .attr('src', value)
            .addClass('show');
          continue;
        }

        if ( key === 'album_songs' ) {
          let $songs_container = $popup.find('.js-song-list');
          let fragment = document.createDocumentFragment();

          value.forEach((row, index) => {
            let row_html = renderSongRow(index + 1, row, false);
            fragment.append(row_html);
          });

          $songs_container.append(fragment);
          continue;
        }

        if ( key === 'genre' && value ) {
          let genres = value.split(', ');

          $popup.find(`.js-select`).val(genres);
          $popup.find(`.js-select`).trigger('change');
        }

        $popup.find(`[name="${key}"]`).val(value);
      }
      $(document).trigger('show-sidebar', ['album-edit']);
    }
  });
});

/**
 * Handle song file change
 */
$('.js-album-upload .js-song-list, .js-album-edit .js-song-list').on('change', '[type="file"]', function (e) {
  $(this).closest('.song-row').addClass('has-file');
  $(this).parent().find('svg').addClass('jello-horizontal');
});

/**
 * Handle album song deletion
 */
$('.js-album-upload .js-song-list').on('click', '.song-row__delete', function (e) {
  $(this).closest('.song-row').remove();
});

$('.js-album-edit .js-song-list').on('click', '.song-row__delete', function (e) {
  let $row = $(this).closest('.song-row');
  $(this).closest('form').find('.js-delete-queue')[0].value += `${$row.data('index')},`;
  $row.remove();
});
