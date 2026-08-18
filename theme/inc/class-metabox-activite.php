<?php
/**
 * Meta Box des champs personnalisés de l'activité.
 *
 * @package Breizh_Nature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Metabox_Activite {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    /**
     * Étape 1 : déclarer la boîte.
     */
    public function add_box() {
        add_meta_box(
            'breizh_nature_activite_details',        // ID unique
            __( 'Détails de l\'activité', 'breizh-nature' ), // Titre affiché
            array( $this, 'render' ),                 // Fonction qui affiche le contenu
            'activite',                                // Uniquement sur le CPT "activite"
            'normal',                                  // Position : sous l'éditeur
            'high'                                     // Priorité d'affichage
        );
    }

    /**
     * Étape 2 : afficher le formulaire.
     */
    public function render( $post ) {

        // Le nonce : un jeton unique généré à chaque affichage du formulaire.
        wp_nonce_field( 'breizh_nature_save_activite', 'breizh_nature_activite_nonce' );

        // On récupère les valeurs déjà enregistrées (vide à la création).
        $date         = get_post_meta( $post->ID, '_activite_date', true );
        $heure        = get_post_meta( $post->ID, '_activite_heure', true );
        $duree        = get_post_meta( $post->ID, '_activite_duree', true );
        $lieu         = get_post_meta( $post->ID, '_activite_lieu', true );
        $participants = get_post_meta( $post->ID, '_activite_participants_max', true );
        $tarif        = get_post_meta( $post->ID, '_activite_tarif', true );
        $statut       = get_post_meta( $post->ID, '_activite_statut', true );
        ?>
        <p>
            <label for="activite_date"><?php esc_html_e( 'Date', 'breizh-nature' ); ?></label><br>
            <input type="date" id="activite_date" name="activite_date" value="<?php echo esc_attr( $date ); ?>">
        </p>
        <p>
            <label for="activite_heure"><?php esc_html_e( 'Heure', 'breizh-nature' ); ?></label><br>
            <input type="time" id="activite_heure" name="activite_heure" value="<?php echo esc_attr( $heure ); ?>">
        </p>
        <p>
            <label for="activite_duree"><?php esc_html_e( 'Durée (en minutes)', 'breizh-nature' ); ?></label><br>
            <input type="number" id="activite_duree" name="activite_duree" value="<?php echo esc_attr( $duree ); ?>" min="0">
        </p>
        <p>
            <label for="activite_lieu"><?php esc_html_e( 'Lieu', 'breizh-nature' ); ?></label><br>
            <input type="text" id="activite_lieu" name="activite_lieu" value="<?php echo esc_attr( $lieu ); ?>" class="widefat">
        </p>

        <p>
            <label for="activite_participants_max"><?php esc_html_e( 'Nombre maximal de participants', 'breizh-nature' ); ?></label><br>
            <input type="number" id="activite_participants_max" name="activite_participants_max" value="<?php echo esc_attr( $participants ); ?>" min="1">
        </p>
        <p>
            <label for="activite_tarif"><?php esc_html_e( 'Tarif (€)', 'breizh-nature' ); ?></label><br>
            <input type="number" id="activite_tarif" name="activite_tarif" value="<?php echo esc_attr( $tarif ); ?>" min="0" step="0.01">
        </p>
        <p>
            <label for="activite_statut"><?php esc_html_e( 'Statut', 'breizh-nature' ); ?></label><br>
            <select id="activite_statut" name="activite_statut">
                <option value="a_venir" <?php selected( $statut, 'a_venir' ); ?>><?php esc_html_e( 'À venir', 'breizh-nature' ); ?></option>
                <option value="complet" <?php selected( $statut, 'complet' ); ?>><?php esc_html_e( 'Complet', 'breizh-nature' ); ?></option>
                <option value="annule" <?php selected( $statut, 'annule' ); ?>><?php esc_html_e( 'Annulé', 'breizh-nature' ); ?></option>
                <option value="termine" <?php selected( $statut, 'termine' ); ?>><?php esc_html_e( 'Terminé', 'breizh-nature' ); ?></option>
            </select>
        </p>
        <?php
    }

    /**
     * Étape 3 : sauvegarder les données, de façon sécurisée.
     */
    public function save( $post_id ) {

        // 1. Vérification du nonce (protection CSRF).
        if ( ! isset( $_POST['breizh_nature_activite_nonce'] ) ||
            ! wp_verify_nonce( $_POST['breizh_nature_activite_nonce'], 'breizh_nature_save_activite' ) ) {
            return;
        }

        // 2. Ignorer les sauvegardes automatiques de WordPress (auto-draft).
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // 3. Vérification des permissions de l'utilisateur.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // 4. Nettoyage et sauvegarde de chaque champ.
        if ( isset( $_POST['activite_date'] ) ) {
            update_post_meta( $post_id, '_activite_date', sanitize_text_field( $_POST['activite_date'] ) );
        }
        if ( isset( $_POST['activite_heure'] ) ) {
            update_post_meta( $post_id, '_activite_heure', sanitize_text_field( $_POST['activite_heure'] ) );
        }
        if ( isset( $_POST['activite_duree'] ) ) {
            update_post_meta( $post_id, '_activite_duree', absint( $_POST['activite_duree'] ) );
        }
        if ( isset( $_POST['activite_lieu'] ) ) {
            update_post_meta( $post_id, '_activite_lieu', sanitize_text_field( $_POST['activite_lieu'] ) );
        }

        if ( isset( $_POST['activite_participants_max'] ) ) {
            update_post_meta( $post_id, '_activite_participants_max', absint( $_POST['activite_participants_max'] ) );
        }
        if ( isset( $_POST['activite_tarif'] ) ) {
            update_post_meta( $post_id, '_activite_tarif', sanitize_text_field( $_POST['activite_tarif'] ) );
        }
        if ( isset( $_POST['activite_statut'] ) ) {
            update_post_meta( $post_id, '_activite_statut', sanitize_text_field( $_POST['activite_statut'] ) );
        }
    }
}

new Breizh_Nature_Metabox_Activite();