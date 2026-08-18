<?php
/**
 * Breizh Nature - Functions du thème
 *
 * @package Breizh_Nature
 */

//Sécurité: empêche l'accès direct au fichier en dehors de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
require get_theme_file_path( '/inc/class-cpt-activite.php' );
require get_theme_file_path( '/inc/class-metabox-activite.php' );
/**
 * Chargement du CSS et du JS du thème.
 * On utilise le hook 'wp_enqueue_scripts'
 */

function breizh_nature_enqueue_assets() {
    wp_enqueue_style (
        'breizh-nature-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'breizh_nature_enqueue_assets' );

/**
 * Configuration de base du thème.
 */

function breizh_nature_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    register_nav_menus (array(
        'primary' => __('Menu principal', 'breizh-nature'),
    ));
}

add_action ('after_setup_theme', 'breizh_nature_setup');
