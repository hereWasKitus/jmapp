<?php
$local = get_locale();
$field = get_fields(get_the_ID());
$thumbnail_src = get_the_post_thumbnail_url();
$img_src = $thumbnail_src ?: get_template_directory_uri() . '/assets/images/Icon/song-placeholder.svg';


?>
<tr data-post_id="<?= get_the_ID() ?>">
    <td>
        <img src="<?= $img_src ?>" alt="song">
    </td>
    <td>
        <?php if ($local == "en_US") {
            echo $field['album_name'];
        } else {
            echo $field['album_name_he'];
        } ?>
    </td>
    <td>
        <?php if ($local == "en_US") {
            echo $field['album_artist'];
        } else {
            echo $field['album_artist_he'];
        } ?>
    </td>
    <td><?= isset( $field['album_songs'] ) ? count( $field['album_songs'] ) : 0 ?></td>
    <td><?= $field['album_release_date'] ?></td>
    <td>
        <span class="edit-row">
            <img src="<?= get_template_directory_uri() ?>/assets/images/Icon/edit.svg" alt="edit">
        </span>
        <span class="delete-row">
            <img src="<?= get_template_directory_uri() ?>/assets/images/Icon/crash.svg" alt="delete">
        </span>
    </td>
</tr>