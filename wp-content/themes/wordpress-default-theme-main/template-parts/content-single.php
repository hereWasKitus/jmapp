<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="wrap">
        <?php coelix_post_thumbnail(); ?>

        <header class="post__header">
            <?php the_title('<h1 class="post__title">', '</h1>'); ?>
            <?php the_date('l F d', '<span class="post__date">', '</span>'); ?>
        </header>
    </div>

    <div class="post__content">
        <?php the_content(); ?>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->