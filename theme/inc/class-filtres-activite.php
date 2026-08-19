<?php
/**
 * Filtrage des activités par type, niveau et lieu.
 *
 * @package Breizh_Nature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Filtres_Activite {

    public function __construct() {
        add_action( 'pre_get_posts', array( $this, 'apply_filters' ) );
    }

    public function apply_filters( $query ) {

        // Uniquement sur la requête principale de l'archive activité, jamais dans l'admin.
        if ( is_admin() || ! $query->is_main_query() || ! is_post_type_archive( 'activite' ) ) {
            return;
        }

        $tax_query = array();

        if ( ! empty( $_GET['type_activite'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'type_activite',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $_GET['type_activite'] ),
            );
        }

        if ( ! empty( $_GET['niveau'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'niveau',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $_GET['niveau'] ),
            );
        }

        if ( ! empty( $tax_query ) ) {
            $query->set( 'tax_query', $tax_query );
        }

        if ( ! empty( $_GET['lieu'] ) ) {
            $query->set( 'meta_query', array(
                array(
                    'key'     => '_activite_lieu',
                    'value'   => sanitize_text_field( $_GET['lieu'] ),
                    'compare' => 'LIKE',
                ),
            ) );
        }
    }
}

new Breizh_Nature_Filtres_Activite();