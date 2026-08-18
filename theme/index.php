<?php
/**
 * Le modèle principal (fallback) du thème Breizh Nature.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post();?>
    <article id="post-<?php the_ID(); ?>" >
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div>
    </article>

    <?php endwhile; ?>
    <?php else : ?>

        <p><?php esc_html_e( 'Aucun contenu trouvé.', 'breizh-nature' ); ?></p>

    <?php endif; ?>
</main>
<?php get_footer(); ?>