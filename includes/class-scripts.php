<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class AWEA_Scripts {

    public function __construct() {
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function enqueue_frontend_assets() {
        $styles = ['owl.carousel.min.css', 'custom-grid.css', 'main.css', 'responsive.css'];
        foreach ($styles as $style) {
            wp_enqueue_style(
                "awesome-widgets-$style",
                AWEA_URL . "assets/css/$style",
                [],
                AWEA_VERSION
            );
        }

        $scripts = ['owl.carousel.min.js', 'main.js'];
        foreach ($scripts as $script) {
            wp_enqueue_script(
                "awesome-widgets-" . str_replace('.js', '', $script),
                AWEA_URL . "assets/js/$script",
                ['jquery'],
                AWEA_VERSION,
                true
            );
        }
    }

    public function enqueue_admin_assets($hook) {
        wp_enqueue_style(
            'awesome-widgets-admin-style',
            AWEA_URL . 'assets/css/admin.css',
            [],
            AWEA_VERSION
        );

        wp_enqueue_script(
            'awesome-widgets-admin-toggle',
            AWEA_URL . 'assets/js/admin.js',
            ['jquery'],
            AWEA_VERSION,
            true
        );
    }
}
