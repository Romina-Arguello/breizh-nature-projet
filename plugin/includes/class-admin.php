<?php
/**
 * Interface d'administration des réservations.
 *
 * @package Breizh_Nature_Reservations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Reservation_Admin {

    public function __construct() {
        add_filter( 'manage_reservation_posts_columns', array( $this, 'add_columns' ) );
        add_action( 'manage_reservation_posts_custom_column', array( $this, 'render_column' ), 10, 2 );
        add_action( 'add_meta_boxes', array( $this, 'add_status_box' ) );
        add_action( 'save_post_reservation', array( $this, 'save_status' ) );
    }

    /**
     * Colonnes personnalisées dans la liste des réservations.
     */
    public function add_columns( $columns ) {
        $columns['activite']     = __( 'Activité', 'breizh-nature-reservations' );
        $columns['participants'] = __( 'Participants', 'breizh-nature-reservations' );
        $columns['statut']       = __( 'Statut', 'breizh-nature-reservations' );
        return $columns;
    }

    public function render_column( $column, $post_id ) {
        switch ( $column ) {
            case 'activite':
                $activite_id = get_post_meta( $post_id, '_reservation_activite_id', true );
                echo esc_html( get_the_title( $activite_id ) );
                break;
            case 'participants':
                echo esc_html( get_post_meta( $post_id, '_reservation_participants', true ) );
                break;
            case 'statut':
                $statut = get_post_meta( $post_id, '_reservation_statut', true );
                echo '<span class="bnr-statut bnr-statut-' . esc_attr( $statut ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $statut ) ) ) . '</span>';
                break;
        }
    }

    /**
     * Meta box pour changer le statut (En attente / Acceptée / Refusée).
     */
    public function add_status_box() {
        add_meta_box(
            'bnr_statut_box',
            __( 'Statut de la réservation', 'breizh-nature-reservations' ),
            array( $this, 'render_status_box' ),
            'reservation',
            'side'
        );
    }

    public function render_status_box( $post ) {
        wp_nonce_field( 'bnr_save_statut', 'bnr_statut_nonce' );
        $statut = get_post_meta( $post->ID, '_reservation_statut', true );
        ?>
        <select name="bnr_statut">
            <option value="en_attente" <?php selected( $statut, 'en_attente' ); ?>><?php esc_html_e( 'En attente', 'breizh-nature-reservations' ); ?></option>
            <option value="acceptee" <?php selected( $statut, 'acceptee' ); ?>><?php esc_html_e( 'Acceptée', 'breizh-nature-reservations' ); ?></option>
            <option value="refusee" <?php selected( $statut, 'refusee' ); ?>><?php esc_html_e( 'Refusée', 'breizh-nature-reservations' ); ?></option>
        </select>
        <?php
    }

    public function save_status( $post_id ) {
        if ( ! isset( $_POST['bnr_statut_nonce'] ) || ! wp_verify_nonce( $_POST['bnr_statut_nonce'], 'bnr_save_statut' ) ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        if ( isset( $_POST['bnr_statut'] ) ) {
            update_post_meta( $post_id, '_reservation_statut', sanitize_text_field( $_POST['bnr_statut'] ) );
        }
    }
}