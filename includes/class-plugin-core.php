<?php
/**
 * Main Plugin Core Class.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.7.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class AWEA
 *
 * Main singleton core controller for Awesome Widgets for Elementor.
 */
final class AWEA {

    /**
     * Singleton instance.
     *
     * @var AWEA|null
     */
    private static $instance = null;

    /**
     * List of registered widget slugs.
     *
     * @var array
     */
    private $widgets = array();

    /**
     * Admin pages instance.
     *
     * @var AWEA_Admin_Pages
     */
    public $admin_pages;

    /**
     * Header & Footer builder instance.
     *
     * @var AWEA_Header_Footer
     */
    public $header_footer;

    /**
     * Widget loader instance.
     *
     * @var AWEA_Widget_Loader
     */
    public $widget_loader;

    /**
     * Scripts manager instance.
     *
     * @var AWEA_Scripts
     */
    public $scripts;

    /**
     * Settings manager instance.
     *
     * @var AWEA_Settings
     */
    public $settings;

    /**
     * Main AWEA Instance.
     *
     * @return AWEA
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Throw error on object clone.
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Disable unserializing of the class.
     *
     * @return void
     */
    public function __wakeup() {
        wp_die( esc_html__( 'Cheatin&#8217; huh?', 'awesome-widgets-elementor' ) );
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->set_widgets();
        $this->includes();
        $this->init_components();
    }

    /**
     * Set up the list of available widgets (Core, eCommerce, and Header/Footer modules).
     *
     * @return void
     */
    private function set_widgets() {
        $default_widgets = array(
            // Core Creative & Content Widgets
            'awesome-cta',
            'awesome-heading',
            'awesome-image-box',
            'awesome-list-group',
            'awesome-number-box',
            'awesome-price',
            'awesome-testimonials',
            'awesome-contact-info',
            'awesome-team',
            'awesome-business-hours',
            'awesome-icon-box',
            'awesome-post-grid',
            'awesome-price-menu',
            'awesome-product-category-grid',
            'awesome-product-grid',
            'awesome-product-list',
            'awesome-timeline',
            'awesome-countdown',
            'awesome-counter',
            'awesome-accordion',
            'awesome-filter-gallery',
            'awesome-post-carousel',
            'awesome-product-carousel',
            'awesome-product-category-carousel',
            'awesome-team-carousel',
            'awesome-testimonials-carousel',
            'awesome-breadcumb',
            'awesome-slider',
            'awesome-about',
            'awesome-step-flow',
            'awesome-progress-bar',
            // WooCommerce eCommerce Studio Widgets
            'awesome-cart',
            'awesome-checkout',
            'awesome-account',
            'awesome-shop',
            // Header & Footer Layout Modules
            'awesome-site-logo',
            'awesome-nav-menu',
            'awesome-social-icons',
            'awesome-contact-bar',
            'awesome-copyright',
        );

        /**
         * Filter the widgets registered by Awesome Widgets for Elementor.
         *
         * @param array $default_widgets List of widget folder slugs.
         */
        $this->widgets = apply_filters( 'awea_registered_widgets', $default_widgets );
    }

    /**
     * Get the list of registered widget slugs.
     *
     * @return array
     */
    public function get_widgets() {
        return $this->widgets;
    }

    /**
     * Include required files.
     *
     * @return void
     */
    private function includes() {
        require_once AWEA_PATH . 'includes/class-admin-pages.php';
        require_once AWEA_PATH . 'includes/class-header-footer.php';
        require_once AWEA_PATH . 'includes/class-widget-loader.php';
        require_once AWEA_PATH . 'includes/class-scripts.php';
        require_once AWEA_PATH . 'includes/class-settings.php';
    }

    /**
     * Initialize plugin sub-components.
     *
     * @return void
     */
    private function init_components() {
        $this->settings      = new AWEA_Settings( $this->widgets );
        $this->header_footer = new AWEA_Header_Footer();
        $this->widget_loader = new AWEA_Widget_Loader( $this->widgets );
        $this->admin_pages   = new AWEA_Admin_Pages( $this->widgets );
        $this->scripts       = new AWEA_Scripts();
    }
}