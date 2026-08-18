<?php
/**
 * Déclaration des taxonomies personnalisées pour "activite".
 *
 * @package Breizh_Nature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Breizh_Nature_Taxonomies_Activite {

    public function __construct() {
        add_action( 'init', array( $this, 'register_type_activite' ) );
        add_action( 'init', array( $this, 'register_niveau' ) );
    }

    /**
     * Taxonomie "Type d'activité" : Randonnée, Atelier, Visite, Sortie découverte.
     */
    public function register_type_activite() {

        $labels = array(
            'name'          => __( 'Types d\'activité', 'breizh-nature' ),
            'singular_name' => __( 'Type d\'activité', 'breizh-nature' ),
            'search_items'  => __( 'Rechercher un type', 'breizh-nature' ),
            'all_items'     => __( 'Tous les types', 'breizh-nature' ),
            'edit_item'     => __( 'Modifier le type', 'breizh-nature' ),
            'add_new_item'  => __( 'Ajouter un type', 'breizh-nature' ),
            'menu_name'     => __( 'Types d\'activité', 'breizh-nature' ),
        );

        register_taxonomy(
            'type_activite',
            'activite',
            array(
                'labels'            => $labels,
                'hierarchical'      => true,   // Comme les catégories (pas comme les étiquettes/tags)
                'public'            => true,
                'show_in_rest'      => true,
                'rewrite'           => array( 'slug' => 'type-activite' ),
            )
        );
    }

    /**
     * Taxonomie "Niveau" : Facile, Intermédiaire, Difficile.
     */
    public function register_niveau() {

        $labels = array(
            'name'          => __( 'Niveaux', 'breizh-nature' ),
            'singular_name' => __( 'Niveau', 'breizh-nature' ),
            'search_items'  => __( 'Rechercher un niveau', 'breizh-nature' ),
            'all_items'     => __( 'Tous les niveaux', 'breizh-nature' ),
            'edit_item'     => __( 'Modifier le niveau', 'breizh-nature' ),
            'add_new_item'  => __( 'Ajouter un niveau', 'breizh-nature' ),
            'menu_name'     => __( 'Niveaux', 'breizh-nature' ),
        );

        register_taxonomy(
            'niveau',
            'activite',
            array(
                'labels'       => $labels,
                'hierarchical' => true,
                'public'       => true,
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'niveau' ),
            )
        );
    }
}

new Breizh_Nature_Taxonomies_Activite();