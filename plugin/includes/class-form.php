<?php
/**
 * Formulaire de réservation côté visiteur (affichage + traitement sécurisé).
 *
 * @package Breizh_Nature_Reservations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Reservation_Form {

    public function __construct() {
        add_action( 'init', array( $this, 'handle_submission' ) );
    }

    /**
     * Traite la soumission du formulaire (avant tout affichage de page).
     */
    public function handle_submission() {

        if ( ! isset( $_POST['bnr_submit'] ) ) {
            return;
        }

        // 1. Nonce (protection CSRF).
        if ( ! isset( $_POST['bnr_nonce'] ) || ! wp_verify_nonce( $_POST['bnr_nonce'], 'bnr_reservation' ) ) {
            wp_die( esc_html__( 'Requête invalide, merci de réessayer.', 'breizh-nature-reservations' ) );
        }

        // 2. Validation minimale des champs obligatoires.
        $required = array( 'nom', 'prenom', 'email', 'activite_id', 'participants' );
        foreach ( $required as $field ) {
            if ( empty( $_POST[ $field ] ) ) {
                return; // On pourrait afficher un message d'erreur plus élaboré ici.
            }
        }

        // 3. Validation du format de l'e-mail.
        if ( ! is_email( $_POST['email'] ) ) {
            return;
        }

        // 4. Création sécurisée via la classe Reservation (qui nettoie chaque champ).
        Breizh_Nature_Reservation::create( array(
            'nom'          => $_POST['nom'],
            'prenom'       => $_POST['prenom'],
            'email'        => $_POST['email'],
            'telephone'    => $_POST['telephone'] ?? '',
            'activite_id'  => $_POST['activite_id'],
            'participants' => $_POST['participants'],
            'commentaire'  => $_POST['commentaire'] ?? '',
        ) );

        wp_safe_redirect( add_query_arg( 'reservation', 'success', wp_get_referer() ) );
        exit;
    }
}

/**
 * Fonction globale appelée depuis le thème (single-activite.php).
 * Affiche le formulaire HTML pour une activité donnée.
 */
function breizh_nature_reservation_form( $activite_id ) {

    if ( isset( $_GET['reservation'] ) && 'success' === $_GET['reservation'] ) {
        echo '<p class="reservation-success">' . esc_html__( 'Votre demande de réservation a bien été envoyée !', 'breizh-nature-reservations' ) . '</p>';
        return;
    }
    ?>
    <form method="post" class="bnr-reservation-form">
        <?php wp_nonce_field( 'bnr_reservation', 'bnr_nonce' ); ?>
        <input type="hidden" name="activite_id" value="<?php echo esc_attr( $activite_id ); ?>">

        <p>
            <label for="bnr_nom"><?php esc_html_e( 'Nom', 'breizh-nature-reservations' ); ?></label>
            <input type="text" id="bnr_nom" name="nom" required>
        </p>
        <p>
            <label for="bnr_prenom"><?php esc_html_e( 'Prénom', 'breizh-nature-reservations' ); ?></label>
            <input type="text" id="bnr_prenom" name="prenom" required>
        </p>
        <p>
            <label for="bnr_email"><?php esc_html_e( 'E-mail', 'breizh-nature-reservations' ); ?></label>
            <input type="email" id="bnr_email" name="email" required>
        </p>
        <p>
            <label for="bnr_telephone"><?php esc_html_e( 'Téléphone', 'breizh-nature-reservations' ); ?></label>
            <input type="tel" id="bnr_telephone" name="telephone">
        </p>
        <p>
            <label for="bnr_participants"><?php esc_html_e( 'Nombre de participants', 'breizh-nature-reservations' ); ?></label>
            <input type="number" id="bnr_participants" name="participants" min="1" required>
        </p>
        <p>
            <label for="bnr_commentaire"><?php esc_html_e( 'Commentaire', 'breizh-nature-reservations' ); ?></label>
            <textarea id="bnr_commentaire" name="commentaire" rows="3"></textarea>
        </p>

        <button type="submit" name="bnr_submit" value="1">
            <?php esc_html_e( 'Envoyer la demande', 'breizh-nature-reservations' ); ?>
        </button>
    </form>
    <?php
}