const {renderSongItems} = require('./template-engine');

$('#upload-song').on('click', function () {
  // $('#popup-song form')
  //   .trigger('reset')
  //   .find('.account-box__image').attr('src', '')
  //   .removeClass('show');
  // $('#popup-song').trigger('show');

  if ($('.account-box').hasClass('error-size')) {
    $('.account-box').removeClass('error-size')
  }
  // $('#popup-song').find('input[name="add_to_album"]')[0].value = 'false';
  $(document).trigger('show-sidebar', ['song-upload']);
});

$('#song-none__btn').on('click', function () {
  // $('#popup-song form')
  //   .trigger('reset')
  //   .find('.account-box__image').attr('src', '')
  //   .removeClass('show');
  // $('#popup-song').trigger('show');
  $(document).trigger('show-sidebar', ['song-upload']);
});

/**
 * Handle song upload
 */
$('.js-song-upload').on('submit', function (e) {
  e.preventDefault();

  let formdata = new FormData(this);

  $.ajax({
    url: `${wp.custom_rest_url}/songs`,
    data: formdata,
    contentType: false,
    processData: false,
    type: 'POST',
    beforeSend () {
      e.currentTarget.classList.add('loading');
    },
    success (resp) {
      e.currentTarget.classList.remove('loading');

      let data = JSON.parse(resp);

      if (!data.success) {
        console.log(data);
        return;
      };

      $(document).trigger('hide-sidebar');
      $('#popup-thanks').trigger('show');
    },
  });
});

/**
 * Handle song update
 */
$('.js-song-edit').on('submit', function (e) {
  e.preventDefault();

  let formdata = new FormData(this);

  $.ajax({
    url: `${wp.custom_rest_url}/songs`,
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
  });
});

// $('.js-add-more').on('click', function (e) {
//   e.preventDefault();
//   $(this).parent().find('[name="song_file"]').click();
// });

$('.l-song-form [name="song_file"]').on('change', function (e) {
  let file = this.files[0];
  let file_name = file.name.replace(/\.[^/.]+$/, "");
  let file_type = file.type;
  $(this).closest('.form__group').find('ul').html(`
    <li class="song-item fade-in">
      ${file_name}
      <i href="#" class="song-item__remove js-remove-song"></i>
    </li>
  `);
  $('.l-song-form .more-song-btn').hide();
});

$('.l-song-form').on('click', '.js-remove-song', function (e) {
  e.preventDefault();
  $cur_layout = $(this).closest('[data-layout]');
  $cur_layout.find('[name="song_file"]').val('');
  $cur_layout.find('.more-song-btn').show();
  $(this).parent().remove();
});

/**
 * Songs table logic
 */
$('.account-songs tbody').on('click', '.delete-row', function (e) {
  const $row = $(this).closest('tr');

  $.ajax({
    url: `${wp.custom_rest_url}/songs`,
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
        if ($('.account-songs tbody')[0].childElementCount === 0) {
          window.location.reload();
        }
      }, 405);
    }
  });
});

/**
 * Handle song edit
 */
$('.account-songs tbody').on('click', '.edit-row', function (e) {
  const $row = $(this).closest('tr');
  const edit_popup_selector = '.js-song-edit'

  $(`${edit_popup_selector} .account-box__image`).removeClass('show');

  $.ajax({
    url: `${wp.custom_rest_url}/songs`,
    type: 'GET',
    data: {
      id: parseInt($row.data('post_id'), 10)
    },
    success: function (resp) {
      let post_fields = resp[0].fields;
      console.log(post_fields);

      for (const key in post_fields) {
        const value = post_fields[key];
        let $input = $(`${edit_popup_selector} [name="${key}"]`);

        if ( key === 'genre' && value ) {
          let genres = value.split(', ');

          $(`${edit_popup_selector} .js-select`).val(genres);
          $(`${edit_popup_selector} .js-select`).trigger('change');
        }

        if (key === 'thumbnail' && value) {
          $(`${edit_popup_selector} .account-box__image--thumb`)
            .attr('src', value)
            .addClass('show');
          continue;
        }

        if (key === 'song_artist_photo' && value) {
          $(`${edit_popup_selector} .account-box__image--artist`)
            .attr('src', value)
            .addClass('show');
          continue;
        }

        if ( !$input.length ) continue;

        if ( key === 'song_file' && value !== false ) {
          $(`${edit_popup_selector} .js-song-list`).html(`
            <li class="song-item fade-in">
              ${value.title}
              <i href="#" class="song-item__remove js-remove-song"></i>
            </li>
          `);
          $(`${edit_popup_selector} .more-song-btn`).hide();
          continue;
        }

        $input.val(value);
      };

      $(`${edit_popup_selector} [name="post_id"]`).val(resp[0].id);
      $(document).trigger('show-sidebar', ['song-edit']);
    }
  })
});

/**
 * Load more songs
 */
$('.account-songs .js-load-more').on('click', function (e) {
  e.preventDefault();
  let self = e.currentTarget;
  let offset = parseFloat($(self).data('offset'), 10);

  $.ajax(`${wp.custom_rest_url}/songs`, {
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

      let song_items = renderSongItems(resp);
      $('.account-songs table').append(song_items);
      tabParentHeight();

      offset += resp.length;
      $(self).data('offset', offset);
    }
  });
});
