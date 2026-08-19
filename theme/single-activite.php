<?php
/**
 * Template d'affichage d'une activité individuelle.
 *
 * @package Breizh_Nature
 */

get_header(); ?>

    <main id="primary" class="site-main single-activite">

        <?php while ( have_posts() ) : the_post();

            $post_id      = get_the_ID();
            $date         = get_post_meta( $post_id, '_activite_date', true );
            $heure        = get_post_meta( $post_id, '_activite_heure', true );
            $duree        = get_post_meta( $post_id, '_activite_duree', true );
            $lieu         = get_post_meta( $post_id, '_activite_lieu', true );
            $participants = get_post_meta( $post_id, '_activite_participants_max', true );
            $tarif        = get_post_meta( $post_id, '_activite_tarif', true );
            $statut       = get_post_meta( $post_id, '_activite_statut', true );

            $types   = get_the_terms( $post_id, 'type_activite' );
            $niveaux = get_the_terms( $post_id, 'niveau' );
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'activite-detail' ); ?>>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="activite-image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <header class="activite-header">
                    <h1><?php the_title(); ?></h1>

                    <?php if ( $types && ! is_wp_error( $types ) ) : ?>
                        <p class="activite-types">
                            <?php foreach ( $types as $type ) : ?>
                                <span class="badge badge-type"><?php echo esc_html( $type->name ); ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $niveaux && ! is_wp_error( $niveaux ) ) : ?>
                        <p class="activite-niveau">
                            <?php foreach ( $niveaux as $niveau ) : ?>
                                <span class="badge badge-niveau"><?php echo esc_html( $niveau->name ); ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                </header>

                <div class="activite-infos">
                    <ul>
                        <?php if ( $date ) : ?>
                            <li><strong><?php esc_html_e( 'Date :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( date_i18n( 'j F Y', strtotime( $date ) ) ); ?></li>
                        <?php endif; ?>

                        <?php if ( $heure ) : ?>
                            <li><strong><?php esc_html_e( 'Heure :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( $heure ); ?></li>
                        <?php endif; ?>

                        <?php if ( $duree ) : ?>
                            <li><strong><?php esc_html_e( 'Durée :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( $duree ); ?> <?php esc_html_e( 'minutes', 'breizh-nature' ); ?></li>
                        <?php endif; ?>

                        <?php if ( $lieu ) : ?>
                            <li><strong><?php esc_html_e( 'Lieu :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( $lieu ); ?></li>
                        <?php endif; ?>

                        <?php if ( $participants ) : ?>
                            <li><strong><?php esc_html_e( 'Participants max :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( $participants ); ?></li>
                        <?php endif; ?>

                        <?php if ( $tarif ) : ?>
                            <li><strong><?php esc_html_e( 'Tarif :', 'breizh-nature' ); ?></strong>
                                <?php echo esc_html( $tarif ); ?> €</li>
                        <?php endif; ?>

                        <?php if ( $statut ) : ?>
                            <li><strong><?php esc_html_e( 'Statut :', 'breizh-nature' ); ?></strong>
                                <span class="statut statut-<?php echo esc_attr( $statut ); ?>">
								<?php echo esc_html( ucfirst( str_replace( '_', ' ', $statut ) ) ); ?>
							</span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="activite-content">
                    <?php the_content(); ?>
                </div>

                <div class="activite-reservation">
                    <?php
                    // Emplacement réservé au formulaire du plugin de réservations (prochaine étape).
                    if ( function_exists( 'breizh_nature_reservation_form' ) ) {
                        breizh_nature_reservation_form( $post_id );
                    }
                    ?>
                </div>

            </article>

        <?php endwhile; ?>

    </main>

<?php get_footer(); ?>