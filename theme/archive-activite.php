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

        <form method="get" class="activite-filtres">
            <select name="type_activite">
                <option value=""><?php esc_html_e( 'Tous les types', 'breizh-nature' ); ?></option>
                <?php
                $types = get_terms( array( 'taxonomy' => 'type_activite', 'hide_empty' => false ) );
                foreach ( $types as $type ) :
                    $selected = isset( $_GET['type_activite'] ) && $_GET['type_activite'] === $type->slug;
                    ?>
                    <option value="<?php echo esc_attr( $type->slug ); ?>" <?php selected( $selected ); ?>>
                        <?php echo esc_html( $type->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="niveau">
                <option value=""><?php esc_html_e( 'Tous les niveaux', 'breizh-nature' ); ?></option>
                <?php
                $niveaux = get_terms( array( 'taxonomy' => 'niveau', 'hide_empty' => false ) );
                foreach ( $niveaux as $niveau ) :
                    $selected = isset( $_GET['niveau'] ) && $_GET['niveau'] === $niveau->slug;
                    ?>
                    <option value="<?php echo esc_attr( $niveau->slug ); ?>" <?php selected( $selected ); ?>>
                        <?php echo esc_html( $niveau->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="text" name="lieu" placeholder="<?php esc_attr_e( 'Lieu', 'breizh-nature' ); ?>"
                   value="<?php echo isset( $_GET['lieu'] ) ? esc_attr( $_GET['lieu'] ) : ''; ?>">

            <button type="submit"><?php esc_html_e( 'Filtrer', 'breizh-nature' ); ?></button>
        </form>

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