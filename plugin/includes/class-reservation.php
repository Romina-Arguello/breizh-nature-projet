<?php
/**
 * CPT "reservation" + logique de création.
 *
 * @package Breizh_Nature_Reservations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Reservation {

    public function __construct() {
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    /**
     * CPT interne, non public : uniquement visible/géré depuis l'admin.
     */
    public function register_cpt() {

        $labels = array(
            'name'          => __( 'Réservations', 'breizh-nature-reservations' ),
            'singular_name' => __( 'Réservation', 'breizh-nature-reservations' ),
            'menu_name'     => __( 'Réservations', 'breizh-nature-reservations' ),
            'edit_item'     => __( 'Voir la réservation', 'breizh-nature-reservations' ),
        );

        register_post_type( 'reservation', array(
            'labels'       => $labels,
            'public'       => false,       // Invisible côté visiteur : pas de page dédiée.
            'show_ui'      => true,        // Mais visible et gérable dans l'admin.
            'show_in_menu' => true,
            'menu_icon'    => 'dashicons-calendar-alt',
            'supports'     => array( 'title' ),
            'capability_type' => 'post',
        ) );
    }

    /**
     * Crée une réservation de façon centralisée et sécurisée.
     * Retourne l'ID du post créé, ou false en cas d'échec.
     */
    public static function create( array $data ) {

        $post_id = wp_insert_post( array(
            'post_type'   => 'reservation',
            'post_title'  => sprintf(
                '%s %s — %s',
                sanitize_text_field( $data['prenom'] ),
                sanitize_text_field( $data['nom'] ),
                get_the_title( $data['activite_id'] )
            ),
            'post_status' => 'publish',
        ) );

        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return false;
        }

        update_post_meta( $post_id, '_reservation_nom', sanitize_text_field( $data['nom'] ) );
        update_post_meta( $post_id, '_reservation_prenom', sanitize_text_field( $data['prenom'] ) );
        update_post_meta( $post_id, '_reservation_email', sanitize_email( $data['email'] ) );
        update_post_meta( $post_id, '_reservation_telephone', sanitize_text_field( $data['telephone'] ) );
        update_post_meta( $post_id, '_reservation_activite_id', absint( $data['activite_id'] ) );
        update_post_meta( $post_id, '_reservation_participants', absint( $data['participants'] ) );
        update_post_meta( $post_id, '_reservation_commentaire', sanitize_textarea_field( $data['commentaire'] ) );
        update_post_meta( $post_id, '_reservation_statut', 'en_attente' );

        return $post_id;
    }
}