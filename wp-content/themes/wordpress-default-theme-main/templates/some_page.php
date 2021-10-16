<?php

/**
 * Template Name: Some Page
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */
get_header();

?>

<main class="somepage">
    <div class="container">

        <?php
        while (have_posts()) :
            the_post(); ?>

            <div class="post__content">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>

        <?php endwhile; // End of the loop.
        ?>

    </div>
</main><!-- #main -->

<?php

get_footer();
