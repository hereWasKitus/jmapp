<div class="blog-item">
    <?php coelix_post_thumbnail(); ?>
    <div class="blog-item__details">
        <div class="blog-item__date">
            <?php echo get_the_date('d/m/y'); ?>
        </div>
        <div class="blog-item__title desc">
            <?php the_title(); ?>
        </div>
        <div class="blog-item__desc">
            <?php the_excerpt(); ?>
        </div>
        <a href="<?= get_permalink(); ?>" class="blog-item__btn btn btn--light">
            <span><?= __('Show more', 'jm') ?></span>
        </a>
    </div>
</div>