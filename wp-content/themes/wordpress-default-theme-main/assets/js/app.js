jQuery(document).ready(function ($) {
  window.scrollPosition = 0;
  window.blockBodyScroll = function () {
    window.scrollPosition = window.pageYOffset;
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${window.scrollPosition}px`;
    document.body.style.width = '100%';
  }

  window.enableBodyScroll = function () {
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('position');
    document.body.style.removeProperty('top');
    document.body.style.removeProperty('width');
    window.scrollTo(0, window.scrollPosition);
  }

  function isIOS() {
    return [
      'iPad Simulator',
      'iPhone Simulator',
      'iPod Simulator',
      'iPad',
      'iPhone',
      'iPod'
    ].includes(navigator.platform)
    // iPad on iOS 13 detection
    || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
  }

  require('./modules/popup-controller');
  require('./modules/sidebar');

  $('.user-data__btn').on('click', function () {
    $(this).toggleClass('rotate');
    $(this).parent().find('.user-data__menu').toggleClass('active');
  });

  $("#burger").click(function () {
    $(this).toggleClass("active");
    $(".overlay").toggleClass("open");
    $("body").toggleClass("locked");
  });

  $('.blog__block').slick({
    responsive: [
      {
        breakpoint: 9999,
        settings: "unslick"
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: true,
          arrows: false,
          appendDots: $('.blog__dots')
        }
      },
    ]
  });

  /**
   * Canvas
   */
  const UserSignature = require('./modules/canvas-signature').default;
  const canvas_element = document.getElementById('user-signature');
  const user_signature = new UserSignature( canvas_element );

  /* Tabs for account page */
  $('.account-link').click(function (event) {
    event.preventDefault();

    if ($('.account-box').hasClass('error-size')) {
      $('.account-box').removeClass('error-size')
    };

    if ($(this).hasClass('active')) {
      if ($(window).width() < '991') {
        $(this).removeClass('active');
        $('.account__block').css({
          'min-height': '100%'
        });
      }
    } else {
      $(this).addClass('active');
      $(this).siblings().removeClass('active');

      if ($(window).width() > '991') {
        tabParentHeight();
      }
    }

    if ( window.innerWidth <= 991 && event.currentTarget.classList.contains('account-link--other') ) {
      user_signature.initSize();
    }

  });

  const clear_canvas_btn = document.querySelector('.account__form .js-clear-canvas');
  if ( clear_canvas_btn ) {
    clear_canvas_btn.addEventListener('click', e => {
      e.preventDefault();
      user_signature.clear();
    });
  }

  window.tabParentHeight = function () {
    let ch = $('.account__block .account-link.active').next('.account-content').height();
    $('.account__block').css({
      'min-height': ch + 'px'
    });
  }

  if ($(window).width() > '991') {
    tabParentHeight();
  }

  $(document).ready(function () {
    if ($('html').attr('lang') === 'he-IL') {
      $text = "בחר ז'אנר";
    } else if ($('html').attr('lang') === 'en-US') {
      $text = 'Choose genre';
    }
    $('.select-genre, .js-select').select2({
      placeholder: $text,
      allowClear: true
    });
  });

  // Account login
  require('./modules/albums-logic');
  require('./modules/songs-logic');

  /* Feedback form submission */
  $('.js-feedback-form').on('submit', function (e) {
    e.preventDefault();
    let form = e.currentTarget;
    let formdata = new FormData(form);
    let error_class = 'is-error';
    let show_message = 'show';

    $.ajax({
      url: `${wp.custom_rest_url}/send_feedback`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend() {
        $(form).find(`.${error_class}`).removeClass(error_class);
      },
      success(resp) {
        let data = JSON.parse(resp);

        // Handle error fields
        if (!data.success) {
          data.fields.forEach(field_name => {
            $(form)
              .find(`[name=${field_name}]`)
              .addClass(error_class);
          });
          return;
        }

        // Success
        console.log($(form));
        $('.message')
          .addClass(show_message);
      }
    })
  });

  /* Add image for Album and Song */

  function addImage(file_input, image_element, remove_btn, drag_area, resolution_restriction = true) {
    function insertImage(file) {
      const reader = new FileReader();
      var img = new Image();
      reader.readAsDataURL(file);

      reader.onloadend = function () {
        img.src = reader.result;
      }

        img.onload = function () {
          $img_elem = image_element.closest('.account-box');

          $img_elem.removeClass(['error-size', 'square-error']);

          if ( ((img.width < 600) && (img.height < 600)) && resolution_restriction ) {
            $img_elem.addClass('error-size');
            image_element.attr('src', '');
            image_element.removeClass('show');
            $img_elem.removeClass('add-remove');
            file_input.val('');
            return;
          }

          if ( (img.width !== img.height) && resolution_restriction ) {
            $img_elem.addClass('error-size square-error');
            image_element.attr('src', '');
            image_element.removeClass('show');
            $img_elem.removeClass('add-remove');
            file_input.val('');
            return;
          }

          // if (
          //   ( ((img.width >= 600) && (img.height >= 600)) ) ||
          //   ( !resolution_restriction )
          //   ) {
          //   image_element.attr('src', reader.result);
          //   image_element.addClass('show');
          //   $img_elem.addClass('add-remove');
          //   if ($img_elem.hasClass('error-size')) {
          //     $img_elem.removeClass('error-size')
          //   }
          // } else {
          //   $img_elem.addClass('error-size');
          //   image_element.attr('src', '');
          //   image_element.removeClass('show');
          //   $img_elem.removeClass('add-remove');
          //   file_input.val('');
          // }

          image_element.attr('src', reader.result);
          image_element.addClass('show');
          $img_elem.addClass('add-remove');
        }
    }

    file_input.on('change', function (e) {
      console.log(e, this.files[0]);
      let file = this.files[0];
      $('.account-box').removeClass('error-size');
      insertImage(file);
    });

    remove_btn.on('click', function () {
      image_element.attr('src', '');
      image_element.removeClass('show');
      image_element.closest('.account-box').removeClass('add-remove');
    })

    // Drag and drop
    const dropAreaSelector = drag_area;
    if ($(dropAreaSelector).length) {
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
        $(document).on(eventName, dropAreaSelector, e => {
          e.preventDefault();
          e.stopPropagation();
        });
      });

      $(document).on('click', dropAreaSelector, e => {
        file_input.click();
      });

      $(document).on('drop', dropAreaSelector, handleDrop);

      function handleDrop(e) {
        let dt = e.originalEvent.dataTransfer;
        let files = dt.files;
        insertImage(files[0]);
      }
    };
  }

  addImage($('#js-image-input'), $('#js-target-image'), $('#js-remove-image'), $('#js-drag-area'), false);
  addImage($('#js-image-input-1'), $('#js-target-image-1'), $('#js-remove-image-1'), $('#js-drag-area-1'));
  addImage($('#js-image-input-2'), $('#js-target-image-2'), $('#js-remove-image-2'), $('#js-drag-area-2'));
  addImage($('#js-image-input-3'), $('#js-target-image-3'), $('#js-remove-image-3'), $('#js-drag-area-3'));
  addImage($('#js-image-input-4'), $('#js-target-image-4'), $('#js-remove-image-4'), $('#js-drag-area-4'));
  addImage($('#js-image-input-5'), $('#js-target-image-5'), $('#js-remove-image-5'), $('#js-drag-area-5'), false);
  addImage($('#js-image-input-6'), $('#js-target-image-6'), $('#js-remove-image-6'), $('#js-drag-area-6'), false);
  addImage($('#js-image-input-7'), $('#js-target-image-7'), $('#js-remove-image-7'), $('#js-drag-area-7'), false);
  addImage($('#js-image-input-8'), $('#js-target-image-8'), $('#js-remove-image-8'), $('#js-drag-area-8'), false);


  $('input[type="date"]').keypress(function (e) {
    e.preventDefault();
  });

  /* Add music files */
  // $('.add-more__input').on('change', function (e) {
  //   let file = this.files[0];
  //   let file_name = file.name;
  //   let file_type = file.type;
  //   let liLast = document.createElement('li');
  //   liLast.innerHTML = file_name + '<span class="remove-element"></span>';
  //   $('.account-list ul').append(liLast);

  //   removeSong();
  // });

  // function removeSong() {
  //   $('.remove-element').on('click', function () {
  //     $(this).parent('.account-list li').remove();
  //   });
  // }
  // removeSong();

  /* Sign up form submission */
  $('.js-sign-up-form').on('submit', function (e) {
    e.preventDefault();
    let form = e.currentTarget;
    let formdata = new FormData(form);
    let error_class = 'is-error';
    let message_block = $('.message-error');

    $.ajax({
      url: `${wp.custom_rest_url}/register`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend() {
        $(form).find(`.${error_class}`).removeClass(error_class);
      },
      success(resp) {
        let data = JSON.parse(resp);

        // Handle error fields
        if (!data.success) {
          if (data.fields) {
            data.fields.forEach(field_name => {
              $(form)
                .find(`[name=${field_name}]`)
                .addClass(error_class);
            });
          } else {
            message_block.html(data.error_message);
          }
          return;
        }

        // Success
        console.log(data);
        window.location = window.location.hostname + data.redirect;
      }
    })
  });

  /* Sign in form submission */
  $('.js-sign-in-form').on('submit', function (e) {
    e.preventDefault();
    let form = e.currentTarget;
    let formdata = new FormData(form);
    let error_class = 'is-error';
    let message_block = $('.message-error');

    $.ajax({
      url: `${wp.custom_rest_url}/authorize`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend() {
        $(form).find(`.${error_class}`).removeClass(error_class);
      },
      success(resp) {
        let data = JSON.parse(resp);

        console.log(data.redirect);

        // Handle error fields
        if (!data.success) {
          if (data.fields) {
            data.fields.forEach(field_name => {
              $(form)
                .find(`[name=${field_name}]`)
                .addClass(error_class);
            });
          } else {
            message_block.html(data.error_string);
          }
          return;
        }

        window.location = window.location.hostname + data.redirect;
      }
    })
  });

  function isCanvasBlank(canvas) {
    const context = canvas.getContext('2d');

    const pixelBuffer = new Uint32Array(
      context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
    );

    return !pixelBuffer.some(color => color !== 0);
  }

  /* Account form submission */
  $('.js-account-form').on('submit', function (e) {
    e.preventDefault();

    let
      form = e.currentTarget,
      formdata = new FormData(form),
      error_class = 'is-error',
      form_canvas = $(e.currentTarget).find('canvas')[0],
      message_block = $('.message-success');

    if ( !isCanvasBlank( form_canvas ) ) {
      formdata.set( 'user_signature', form_canvas.toDataURL() );
    }

    $.ajax({
      url: `${wp.custom_rest_url}/update_user`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend() {
        $(form).find(`.${error_class}`).removeClass(error_class);
        if (formdata.get('user_avatar').size === 0) {
          formdata.delete('user_avatar');
        }
      },
      success(resp) {
        let data = JSON.parse(resp);

        message_block.show();

        // Handle error fields
        if (!data.success) {
          data.fields.forEach(field_name => {
            $(form)
              .find(`[name=${field_name}]`)
              .addClass(error_class);
            message_block.text('');
          });
          return;
        }

        window.location.reload();

      }
    })
  });

  $('.js-change-signature').on('click', e => {
    e.preventDefault();
    // $('.canvas-container').removeClass('has-signature');
    // tabParentHeight();
    // user_signature.initSize();
    const fd = new FormData();

    fd.append('user_id', wp.current_user_id);

    $.ajax({
      url: `${wp.custom_rest_url}/change_signature`,
      data: fd,
      contentType: false,
      processData: false,
      type: 'POST',
      success () {
        $('#popup-notification').trigger('show');
      }
    });
  });

  /* Forgot Password Popup */
  $('#recovery_password').on('click', function () {
    $('#popup-recovery .popup__box')
      .trigger('reset')
      .removeClass('show');
    $('#popup-recovery').trigger('show');
  });

  /* Forgot Password form submission */
  $('.js-recovery-form').on('submit', function (e) {
    e.preventDefault();
    let form = e.currentTarget;
    let formdata = new FormData(form);
    let error_class = 'is-error';
    let message_block = $('.recovery-message-error');

    $.ajax({
      url: `${wp.custom_rest_url}/send_mail`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend() {
        $(form).find(`.${error_class}`).removeClass(error_class);
      },
      success(resp) {
        let data = JSON.parse(resp);

        // Handle error fields
        if (!data.success) {
          if (data.fields) {
            data.fields.forEach(field_name => {
              $(form)
                .find(`[name=${field_name}]`)
                .addClass(error_class);
            });
          } else {
            message_block.html("The user with the specified mail was not found. Please enter correct email.");
          }
          return;
        }

        // Success
        // console.log(data);
        $('.popup__box').html('A temporary password has been sent to the mail.')

      }
    })
  });

  /* Google authorization submission */

  gapi.load('auth2', function () {
    auth2 = gapi.auth2.init({
      'apiKey': 'GyFbr4tSNZuPNDfSA_zpky11',
      'discoveryDocs': ['https://people.googleapis.com/$discovery/rest'],
      'clientId': '995200861756-g8ecmvak7g2qvtcga132rcokjl6s603b.apps.googleusercontent.com',
      'scope': 'profile',
    });

    let google_btn = document.getElementById('js-google-btn');
    if ( google_btn ) {
      googleAttachSignin(google_btn);
    }
  });


  function googleAttachSignin(el) {
    let googleUserInfo = {};

    auth2.attachClickHandler(el, {}, function (googleUser) {
      let profile = googleUser.getBasicProfile();

      googleUserInfo.name = profile.getName();
      googleUserInfo.mail = profile.getEmail();
      console.log(googleUserInfo);

      $.ajax({
        url: `${wp.custom_rest_url}/google_register`,
        data: googleUserInfo,
        type: 'POST',
        success(resp) {
          let data = JSON.parse(resp);

          // Handle error fields
          if (!data.success) {
            console.log(data);
            return;
          }

          // Success
          console.log(data);
          window.location = window.location.hostname + data.redirect;
        }
      });
    },

      function (er) {
        console.log(JSON.stringify(er, undefined, 2));
      })
  };


  const popup_user_signature = new UserSignature( document.getElementById('user-signature-popup') );

  $('.js-open-signature-popup').on('click', function (e) {
    e.preventDefault();
    $('#signature-popup').trigger('show');
  });

  $('#signature-popup .js-clear-canvas').on('click', function (e) {
    e.preventDefault();
    popup_user_signature.clear();
  });

  $('#signature-popup form').on('submit', function (e) {
    e.preventDefault();
    let
      formdata = new FormData( this ),
      form_canvas = this.querySelector('canvas');

    if ( isCanvasBlank( form_canvas ) ) {
      form_canvas.classList.add('is-error', 'jello-horizontal');
      setTimeout(() => {
        form_canvas.classList.remove('is-error', 'jello-horizontal')
      }, 1000);
      return;
    }

    formdata.set( 'user_signature', form_canvas.toDataURL() );

    $.ajax({
      url: `${wp.custom_rest_url}/update_user`,
      data: formdata,
      contentType: false,
      processData: false,
      type: 'POST',
      success ( resp ) {
        let data = JSON.parse( resp );

        if ( data.success ) {
          location.reload();
        }
      }
    });
  });

  /**
   * Thanks popup
   */
  $('#popup-thanks').on('hide', () => {
    location.reload();
  });

});
