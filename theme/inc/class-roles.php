<?php
/**
 * Création du rôle "Gestionnaire" (accès limité).
 *
 * @package Breizh_Nature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Roles {

    public function __construct() {
        add_action( 'after_switch_theme', array( $this, 'create_role' ) );
    }

    /**
     * Crée le rôle une seule fois, à l'activation du thème.
     */
    public function create_role() {

        // Évite de recréer le rôle s'il existe déjà.
        if ( get_role( 'gestionnaire_activites' ) ) {
            return;
        }

        add_role(
            'gestionnaire_activites',
            __( 'Gestionnaire', 'breizh-nature' ),
            array(
                'read'                   => true,  // Peut se connecter et voir l'admin.
                'edit_posts'             => true,  // Peut créer/modifier du contenu.
                'edit_published_posts'   => true,
                'publish_posts'          => true,
                'delete_posts'           => false, // NE PEUT PAS supprimer.
                'manage_options'         => false, // NE PEUT PAS toucher aux réglages.
                'edit_theme_options'     => false, // NE PEUT PAS toucher au thème.
                'edit_users'             => false, // NE PEUT PAS gérer les utilisateurs.
            )
        );
    }
}

new Breizh_Nature_Roles();