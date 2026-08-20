<?php
/**
 * Page d'accueil.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

    <main id="primary" class="site-main front-page">

        <section class="hero">
            <div class="hero-content">
                <h1><?php esc_html_e( "Découvrez la nature bretonne", 'breizh-nature' ); ?></h1>
                <p><?php esc_html_e( "Randonnées, sorties découverte, ateliers et patrimoine naturel en Bretagne.", 'breizh-nature' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/activites/' ) ); ?>" class="btn-primary">
                    <?php esc_html_e( 'Voir toutes les activités', 'breizh-nature' ); ?>
                </a>
            </div>
        </section>

        <section class="home-activites">
            <h2><?php esc_html_e( 'Nos prochaines activités', 'breizh-nature' ); ?></h2>

            <?php
            $activites = new WP_Query( array(
                'post_type'      => 'activite',
                'posts_per_page' => 3,
                'orderby'        => 'meta_value',
                'meta_key'       => '_activite_date',
                'order'          => 'ASC',
            ) );

            if ( $activites->have_posts() ) : ?>

                <div class="activites-liste">
                    <?php while ( $activites->have_posts() ) : $activites->the_post();
                        $post_id = get_the_ID();
                        $date    = get_post_meta( $post_id, '_activite_date', true );
                        $lieu    = get_post_meta( $post_id, '_activite_lieu', true );
                        $tarif   = get_post_meta( $post_id, '_activite_tarif', true );
                        $niveaux = get_the_terms( $post_id, 'niveau' );
                        ?>
                        <article <?php post_class( 'activite-card' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="activite-card-link">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="activite-card-image"><?php the_post_thumbnail( 'medium' ); ?></div>
                                <?php endif; ?>
                                <div class="activite-card-body">
                                    <h3><?php the_title(); ?></h3>
                                    <?php if ( $niveaux && ! is_wp_error( $niveaux ) ) : ?>
                                        <span class="badge badge-niveau"><?php echo esc_html( $niveaux[0]->name ); ?></span>
                                    <?php endif; ?>
                                    <ul class="activite-card-infos">
                                        <?php if ( $date ) : ?><li><?php echo esc_html( date_i18n( 'j F Y', strtotime( $date ) ) ); ?></li><?php endif; ?>
                                        <?php if ( $lieu ) : ?><li><?php echo esc_html( $lieu ); ?></li><?php endif; ?>
                                        <?php if ( $tarif ) : ?><li><?php echo esc_html( $tarif ); ?> €</li><?php endif; ?>
                                    </ul>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

            <?php else : ?>
                <p><?php esc_html_e( 'Aucune activité programmée pour le moment.', 'breizh-nature' ); ?></p>
            <?php endif; ?>
        </section>

    </main>

<?php get_footer(); ?>