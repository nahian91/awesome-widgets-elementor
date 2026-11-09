<?php
/**
 * Scripts and Styles Manager.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class AWEA_Scripts
 *
 * Handles frontend and backend asset registrations, conditional enqueuing, and localization.
 */
class AWEA_Scripts {

    /**
     * Constructor.
     */
    public function __construct() {
        // Frontend scripts and styles.
        add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_frontend_styles' ) );
        add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );

        // Admin assets.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    /**
     * Enqueue frontend stylesheets.
     *
     * @return void
     */
    public function enqueue_frontend_styles() {
        $styles = array(
            'awea-owl-carousel' => 'owl.carousel.min.css',
            'awea-custom-grid'  => 'custom-grid.css',
            'awea-main'         => 'main.css',
            'awea-responsive'   => 'responsive.css',
        );

        foreach ( $styles as $handle => $filename ) {
            wp_enqueue_style(
                $handle,
                AWEA_URL . 'assets/css/' . $filename,
                array(),
                defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0'
            );
        }
    }

    /**
     * Enqueue frontend JavaScript files.
     *
     * @return void
     */
    public function enqueue_frontend_scripts() {
        // Register or reuse Owl Carousel safely.
        if ( ! wp_script_is( 'owl-carousel', 'registered' ) ) {
            wp_register_script(
                'owl-carousel',
                AWEA_URL . 'assets/js/owl.carousel.min.js',
                array( 'jquery' ),
                '2.3.4',
                true
            );
        }

        wp_enqueue_script( 'owl-carousel' );

        wp_enqueue_script(
            'awea-main',
            AWEA_URL . 'assets/js/main.js',
            array( 'jquery', 'owl-carousel' ),
            defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0',
            true
        );
    }

    /**
     * Enqueue admin assets only on this plugin's settings screens.
     *
     * @param string $hook The current admin page hook.
     * @return void
     */
    public function enqueue_admin_assets( $hook ) {
        // Restrict loading strictly to Awesome Widgets admin pages.
        $allowed_hooks = array(
            'toplevel_page_awesome-widgets-elementor',
            'awesome-widgets_page_awesome-widgets-widgets',
            'awesome-widgets_page_awesome-widgets-header-footer',
        );

        if ( ! in_array( $hook, $allowed_hooks, true ) ) {
            return;
        }

        wp_enqueue_style(
            'awea-admin-style',
            AWEA_URL . 'assets/css/admin.css',
            array(),
            defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0'
        );

        wp_enqueue_script(
            'awea-admin-toggle',
            AWEA_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0',
            true
        );

        // Localize useful data or translation strings for admin JS.
        wp_localize_script(
            'awea-admin-toggle',
            'aweaAdminData',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            )
        );
    }
}