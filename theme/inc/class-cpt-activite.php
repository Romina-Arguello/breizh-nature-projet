<?php
/**
 * Déclaration du Custom Post Type "activite".
 *
 * @package Breizh_Nature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_CPT_Activite {

    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
    }

    public function register() {

        $labels = array(
            'name'               => __( 'Activités', 'breizh-nature' ),
            'singular_name'      => __( 'Activité', 'breizh-nature' ),
            'add_new_item'       => __( 'Ajouter une activité', 'breizh-nature' ),
            'edit_item'          => __( 'Modifier l\'activité', 'breizh-nature' ),
            'new_item'           => __( 'Nouvelle activité', 'breizh-nature' ),
            'view_item'          => __( 'Voir l\'activité', 'breizh-nature' ),
            'search_items'       => __( 'Rechercher une activité', 'breizh-nature' ),
            'not_found'          => __( 'Aucune activité trouvée', 'breizh-nature' ),
            'menu_name'          => __( 'Activités', 'breizh-nature' ),
        );

        $args = array(
            'labels'        => $labels,
            'public'        => true,
            'show_in_menu'  => true,
            'menu_icon'     => 'dashicons-palmtree',
            'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'has_archive'   => true,
            'rewrite'       => array( 'slug' => 'activites' ),
            'show_in_rest'  => true,
        );

        register_post_type( 'activite', $args );
    }
}

new Breizh_Nature_CPT_Activite();