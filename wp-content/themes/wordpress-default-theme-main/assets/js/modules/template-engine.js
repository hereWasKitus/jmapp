export function renderSongItems(songs, lang = 'en') {
  let fragment = document.createDocumentFragment();

  songs.forEach(song => {
    let tr = document.createElement('tr');
    tr.dataset.post_id = song.id;
    tr.classList.add('fade-in');

    let cover_cell = document.createElement('td');
    let cover_img = document.createElement('img');
    cover_img.src = song.fields.thumbnail || wp.placeholder_image;
    cover_cell.append(cover_img);

    let name_cell = document.createElement('td');
    name_cell.textContent = lang == 'en' ? song.fields.song_name : song.fields.song_name_he;

    let artist_cell = document.createElement('td');
    artist_cell.textContent = lang == 'en' ? song.fields.song_artist : song.fields.song_artist_he;

    let date_cell = document.createElement('td');
    date_cell.textContent = song.fields.release_date;

    let action_cell = document.createElement('td');
    action_cell.innerHTML = `
      <span class="edit-row">
        <i class="symbol symbol--pencil"></i>
      </span>
      <span class="delete-row">
        <i class="symbol symbol--trash"></i>
      </span>
    `;

    tr.append(cover_cell, name_cell, artist_cell, date_cell, action_cell);
    fragment.append(tr);
  });

  return fragment;
};

export function renderAlbumItems(albums, lang = 'en') {
  let fragment = document.createDocumentFragment();

  albums.forEach(album => {
    let tr = document.createElement('tr');
    tr.dataset.post_id = album.id;
    tr.classList.add('fade-in');

    let cover_cell = document.createElement('td');
    let cover_img = document.createElement('img');
    cover_img.src = album.fields.thumbnail || wp.placeholder_image;
    cover_cell.append(cover_img);

    let name_cell = document.createElement('td');
    name_cell.textContent = lang == 'en' ? album.fields.album_name : album.fields.album_name_he;

    let artist_cell = document.createElement('td');
    artist_cell.textContent = lang == 'en' ? album.fields.album_artist : album.fields.album_artist_he;

    let include_cell = document.createElement('td');
    include_cell.textContent = '12';

    let date_cell = document.createElement('td');
    date_cell.textContent = album.fields.album_release_date;

    let action_cell = document.createElement('td');
    action_cell.innerHTML = `
      <span class="edit-row">
        <i class="symbol symbol--pencil"></i>
      </span>
      <span class="delete-row">
        <i class="symbol symbol--trash"></i>
      </span>
    `;

    tr.append(cover_cell, name_cell, artist_cell, include_cell, date_cell, action_cell);
    fragment.append(tr);
  });

  return fragment;
};

export function renderSongRow ( index, data, file_required = true ) {
  const row = document.createElement('div');
  row.classList.add('song-row', 'form');
  row.dataset.index = index;

  const name_field = document.createElement('input');
  name_field.classList.add('input-text');
  name_field.name = `song_name_${index}`;
  name_field.placeholder = wp.is_rtl ? 'שם השיר באנגלית' : 'Song name';
  name_field.type = 'text';
  name_field.value = data ? data.song_name : '';
  name_field.required = true;

  const name_field_he = document.createElement('input');
  name_field_he.classList.add('input-text');
  name_field_he.name = `song_name_he_${index}`;
  name_field_he.placeholder = wp.is_rtl ? 'שם השיר בעברית' : 'Song name in hebrew';
  name_field_he.type = 'text';
  name_field_he.value = data ? data.song_name_he : '';
  name_field_he.required = true;

  const actions_wrapper = document.createElement('div');
  actions_wrapper.classList.add('song-row__actions');

  const song_file_wrapper = document.createElement('div');
  song_file_wrapper.classList.add('song-row__file-wrapper');

  if ( data && !!data.song_file ) row.classList.add('has-file');

  const song_file = document.createElement('input');
  song_file.type = 'file';
  song_file.name = `song_file_${index}`;
  song_file.classList.add('exclude');
  song_file.accept = 'audio/*';
  song_file.required = file_required;

  song_file_wrapper.append(song_file);
  song_file_wrapper.innerHTML += `<svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.7405 1.7205C12.4465 -0.573499 8.71088 -0.573499 6.41931 1.7205L0.0633389 8.0716C0.0219398 8.113 2.25135e-05 8.16901 2.25135e-05 8.22746C2.25135e-05 8.2859 0.0219398 8.34191 0.0633389 8.38331L0.961942 9.28192C1.00302 9.32281 1.05862 9.34577 1.11658 9.34577C1.17454 9.34577 1.23014 9.32281 1.27122 9.28192L7.62719 2.93081C8.41621 2.14179 9.4658 1.70832 10.5811 1.70832C11.6965 1.70832 12.7461 2.14179 13.5327 2.93081C14.3217 3.71983 14.7551 4.76942 14.7551 5.88232C14.7551 6.99766 14.3217 8.04482 13.5327 8.83383L7.05491 15.3091L6.00532 16.3587C5.02392 17.3401 3.42884 17.3401 2.44744 16.3587C1.97257 15.8839 1.712 15.2531 1.712 14.581C1.712 13.9089 1.97257 13.2781 2.44744 12.8033L8.87404 6.37911C9.0372 6.21838 9.2515 6.12828 9.48041 6.12828H9.48285C9.71176 6.12828 9.92362 6.21838 10.0844 6.37911C10.2475 6.54227 10.3352 6.75657 10.3352 6.98549C10.3352 7.21196 10.2451 7.42626 10.0844 7.58699L4.83154 12.8349C4.79014 12.8763 4.76822 12.9323 4.76822 12.9908C4.76822 13.0492 4.79014 13.1052 4.83154 13.1466L5.73014 14.0452C5.77122 14.0861 5.82682 14.1091 5.88478 14.1091C5.94274 14.1091 5.99834 14.0861 6.03942 14.0452L11.2898 8.79487C11.7744 8.31026 12.0398 7.66735 12.0398 6.98305C12.0398 6.29875 11.772 5.65341 11.2898 5.17123C10.2889 4.17035 8.66217 4.17278 7.66129 5.17123L7.03787 5.79709L1.23712 11.5954C0.843421 11.9868 0.53134 12.4525 0.318979 12.9654C0.106618 13.4783 -0.00179641 14.0283 2.25135e-05 14.5834C2.25135e-05 15.7109 0.440801 16.7703 1.23712 17.5666C2.06267 18.3897 3.14392 18.8013 4.22516 18.8013C5.30641 18.8013 6.38766 18.3897 7.21077 17.5666L14.7405 10.0417C15.8486 8.93124 16.4622 7.45305 16.4622 5.88232C16.4647 4.30916 15.851 2.83097 14.7405 1.7205Z" fill="#E0E0E0"/></svg>`;

  actions_wrapper.append(song_file_wrapper);
  actions_wrapper.innerHTML += `<a class="song-row__delete"><i class="symbol symbol--trash"></i></a>`;

  row.append(name_field, name_field_he, actions_wrapper);
  return row;
}
