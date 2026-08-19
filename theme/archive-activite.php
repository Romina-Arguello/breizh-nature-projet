<?php
/**
 * Archive listant toutes les activités.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

    <main id="primary" class="site-main archive-activite">

        <header class="archive-header">
            <h1><?php esc_html_e( 'Toutes nos activités', 'breizh-nature' ); ?></h1>
        </header>

        <?php if ( have_posts() ) : ?>

            <div class="activites-liste">

                <?php while ( have_posts() ) : the_post();

                    $post_id = get_the_ID();
                    $date    = get_post_meta( $post_id, '_activite_date', true );
                    $lieu    = get_post_meta( $post_id, '_activite_lieu', true );
                    $tarif   = get_post_meta( $post_id, '_activite_tarif', true );
                    $niveaux = get_the_terms( $post_id, 'niveau' );
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'activite-card' ); ?>>

                        <a href="<?php the_permalink(); ?>" class="activite-card-link">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="activite-card-image">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </div>
                            <?php endif; ?>

                            <div class="activite-card-body">
                                <h2><?php the_title(); ?></h2>

                                <?php if ( $niveaux && ! is_wp_error( $niveaux ) ) : ?>
                                    <span class="badge badge-niveau"><?php echo esc_html( $niveaux[0]->name ); ?></span>
                                <?php endif; ?>

                                <p class="activite-card-excerpt"><?php the_excerpt(); ?></p>

                                <ul class="activite-card-infos">
                                    <?php if ( $date ) : ?>
                                        <li><?php echo esc_html( date_i18n( 'j F Y', strtotime( $date ) ) ); ?></li>
                                    <?php endif; ?>
                                    <?php if ( $lieu ) : ?>
                                        <li><?php echo esc_html( $lieu ); ?></li>
                                    <?php endif; ?>
                                    <?php if ( $tarif ) : ?>
                                        <li><?php echo esc_html( $tarif ); ?> €</li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                        </a>
                    </article>

                <?php endwhile; ?>

            </div>

            <div class="activites-pagination">
                <?php the_posts_pagination(); ?>
            </div>

        <?php else : ?>

            <p><?php esc_html_e( 'Aucune activité disponible pour le moment.', 'breizh-nature' ); ?></p>

        <?php endif; ?>

    </main>

<?php get_footer(); ?>