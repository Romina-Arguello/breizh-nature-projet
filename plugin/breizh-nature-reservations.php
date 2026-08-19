<?php
/**
 * Plugin Name: Breizh'Nature Réservations
 * Plugin URI: https://github.com/Romina-Arguello/breizh-nature-projet
 * Description: Gère les demandes de réservation pour les activités Breizh'Nature (formulaire visiteur + interface admin).
 * Version: 1.0.0
 * Author: Romina Arguello
 * License: GPL v2 or later
 * Text Domain: breizh-nature-reservations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Constantes utiles, réutilisées dans tout le plugin.
define( 'BNR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BNR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BNR_VERSION', '1.0.0' );

// Chargement des classes du plugin.
require_once BNR_PLUGIN_PATH . 'includes/class-reservation.php';
require_once BNR_PLUGIN_PATH . 'includes/class-admin.php';
require_once BNR_PLUGIN_PATH . 'includes/class-form.php';

/**
 * Initialise le plugin : instancie chaque classe.
 * On centralise ici pour garder une seule fonction d'entrée claire.
 */
function bnr_init_plugin() {
    new Breizh_Nature_Reservation();
    new Breizh_Nature_Reservation_Admin();
    new Breizh_Nature_Reservation_Form();
}
add_action( 'plugins_loaded', 'bnr_init_plugin' );
