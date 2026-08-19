<?php
/**
 * Template pour la page 404 (contenu introuvable).
 *
 * @package Breizh_Nature
 */

get_header(); ?>

<main id="primary" class="site-main error-404">

    <h1><?php esc_html_e( 'Page introuvable', 'breizh-nature' ); ?></h1>
    <p><?php esc_html_e( 'Désolé, le contenu que vous cherchez n\'existe pas ou a été déplacé.', 'breizh-nature' ); ?></p>
    <p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php esc_html_e( 'Retour à l\'accueil', 'breizh-nature' ); ?>
        </a>
    </p>

</main>

<?php get_footer(); ?>
