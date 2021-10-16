<?php

/**
 * Template Name: Contact
 *
 * @package WordPress
 * @subpackage Coelix
 * @since Coelix 1.0
 */
get_header();

?>
<main class="contactpage">
    <section class="contact-us">
        <div class="container">
            <h1 class="contact-us__title title-2">
                <?php the_title() ?>
            </h1>
            <div class="contact-us__block">
                <div class="contact-us__form">
                    <p>
                        <?php the_field('text_before_form'); ?>
                    </p>
                    <form class="old-form js-feedback-form">
                        <label><?= __('Mail', 'jm') ?><input name="email" type="mail" placeholder="1233242@gmail.com"></label>
                        <label><?= __('Name', 'jm') ?><input name="name" type="text" placeholder="<?= __('John Smith', 'jm') ?>"></label>
                        <label><?= __('Message', 'jm') ?><input name="message" type="text" placeholder="<?= __('Write here', 'jm') ?>"></label>
                        <p class="message">
                            <?= __('Your message has been sent', 'jm') ?>
                        </p>
                        <input type="submit" value="<?= __('Send', 'jm') ?>">
                    </form>
                </div>
                <div class="contact-us__info">
                    <!--<div class="contact-us__el contact-phone">
                        <a href="tel:<?php the_field('phone_number', 'option'); ?>"><?php the_field('phone_number', 'option'); ?></a>
                    </div>-->
                    <div class="contact-us__el contact-mail">
                        <a href="mailto:<?php the_field('mail_address', 'option'); ?>"><?php the_field('mail_address', 'option'); ?></a>
                    </div>
                    <!--<div class="contact-us__el contact-location">
                        <a href="<?php the_field('location_link', 'option'); ?>"><?php the_field('location_address', 'option'); ?></a>
                    </div>-->
                    <div class="contact-us__socials">
                        <div class="feedback__footer">
                            <div class="feedback__label">
                                <?= __('Follow us:', 'jm') ?>
                            </div>
                            <div class="feedback__socials">
                                <?php
                                $socials = get_field('socials', 'option');
                                foreach ($socials as $social) :
                                ?>
                                    <a target="_blank" href="<?= $social['social_link'] ?>">
                                        <img src="<?= $social['social_icon'] ?>" alt="socials">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?php

get_footer();
