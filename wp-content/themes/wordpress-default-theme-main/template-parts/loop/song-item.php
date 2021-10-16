<?php
$local = get_locale();
$fields = get_fields(get_the_ID());
$thumbnail_src = get_the_post_thumbnail_url();
$img_src = $thumbnail_src ? $thumbnail_src : get_template_directory_uri() . '/assets/images/Icon/song-placeholder.svg';
?>
<tr data-post_id="<?= get_the_ID() ?>">
    <td>
        <img src="<?= $img_src ?>" alt="song">
    </td>
    <td>
        <?php if ($local == "en_US") {
            echo $fields['song_name'];
        } else {
            echo $fields['song_name_he'];
        } ?>
    </td>
    <td>
        <?php if ($local == "en_US") {
            echo $fields['song_artist'];
        } else {
            echo $fields['song_artist_he'];
        } ?>
    </td>
    <!-- <td></td> -->
    <td><?= $fields['release_date'] ?></td>
    <td>
        <span class="edit-row">
            <i class="symbol symbol--pencil"></i>
        </span>
        <span class="delete-row">
            <i class="symbol symbol--trash"></i>
        </span>
    </td>
</tr>