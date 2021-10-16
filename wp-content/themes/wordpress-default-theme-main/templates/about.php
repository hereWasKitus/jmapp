<?php

/**
 * Template Name: About
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */
get_header();

?>
<main class="aboutpage">
    <section class="about">
        <div class="container">
            <h1 class="about__title">
                <?php the_title() ?>
            </h1>
            <?php if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif; ?>
        </div>
        <div class="about__image">
            <img src="<?php the_field('about_image'); ?>" alt="mobile">
        </div>
    </section>
</main>



<?php

get_footer();
