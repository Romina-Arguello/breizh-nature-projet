<?php
/**
 * Template pour les pages statiques.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

    <main id="primary" class="site-main page-content">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header">
                    <h1><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="page-image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; ?>

    </main>

<?php get_footer(); ?>