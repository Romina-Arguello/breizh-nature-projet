<?php
/**
 * Template pour les articles de blog standards.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

    <main id="primary" class="site-main single-post">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1><?php the_title(); ?></h1>
                    <p class="entry-meta">
                        <?php echo esc_html( get_the_date() ); ?>
                    </p>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; ?>

    </main>

<?php get_footer(); ?>