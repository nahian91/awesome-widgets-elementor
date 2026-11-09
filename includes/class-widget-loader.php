<?php
/**
 * Elementor Widget Loader Class.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.6.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class AWEA_Widget_Loader
 *
 * Handles custom Elementor panel category registrations, dynamic widget class discovery,
 * conditional enabling, and widget-specific asset enqueuing.
 */
class AWEA_Widget_Loader {

    /**
     * Available widget slugs.
     *
     * @var array
     */
    private $widgets = array();

    /**
     * Constructor.
     *
     * @param array $widgets List of widget slugs passed from the core class.
     */
    public function __construct( $widgets = array() ) {
        $this->widgets = is_array( $widgets ) ? $widgets : array();

        // Register custom Elementor categories.
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );

        // Register Elementor widgets.
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

        // Enqueue widget-specific styles and scripts.
        add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
        add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_widget_scripts' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'enqueue_widget_scripts' ) );
    }

    /**
     * Register custom Awesome categories in Elementor's panel.
     *
     * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager instance.
     * @return void
     */
    public function register_categories( $elements_manager ) {
        // Core Awesome Widgets Category
        $elements_manager->add_category(
            'awesome-widgets-elementor',
            array(
                'title' => esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
                'icon'  => 'fa fa-plug',
            )
        );

        // Awesome Header & Footer Category
        $elements_manager->add_category(
            'awesome-header-footer',
            array(
                'title' => esc_html__( 'Awesome Header & Footer', 'awesome-widgets-elementor' ),
                'icon'  => 'fa fa-window-maximize',
            )
        );

        // Awesome Woo (eCommerce) Category
        $elements_manager->add_category(
            'awesome-woo',
            array(
                'title' => esc_html__( 'Awesome Woo', 'awesome-widgets-elementor' ),
                'icon'  => 'fa fa-shopping-bag',
            )
        );
    }

    /**
     * Register active widgets with Elementor.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager instance.
     * @return void
     */
    public function register_widgets( $widgets_manager ) {
        $enabled_widgets = get_option( 'awea_widgets_enabled', array() );
        $enabled_widgets = is_array( $enabled_widgets ) ? $enabled_widgets : array();

        // Fallback to directory scan only if no widget list was supplied via constructor.
        $widget_slugs = ! empty( $this->widgets ) ? $this->widgets : $this->get_widget_folders();

        foreach ( $widget_slugs as $slug ) {
            $clean_slug = sanitize_key( $slug );

            // Check if widget is enabled in settings (defaults to enabled if not set).
            if ( isset( $enabled_widgets[ $clean_slug ] ) && ! $enabled_widgets[ $clean_slug ] ) {
                continue;
            }

            $file_path = AWEA_PATH . 'widgets/' . $clean_slug . '/' . $clean_slug . '.php';

            if ( ! file_exists( $file_path ) ) {
                continue;
            }

            require_once $file_path;

            // Expected class name convention: Widget_Awesome_Cta, Widget_Awesome_Woo_Cart, etc.
            $pascal_slug = str_replace( ' ', '_', ucwords( str_replace( array( '-', '_' ), ' ', $clean_slug ) ) );
            $class_names = array(
                'Elementor\\Widget_' . $pascal_slug,
                'AWEA_' . $pascal_slug,
                'AWEA_Widget_' . $pascal_slug,
            );

            foreach ( $class_names as $class_name ) {
                if ( class_exists( $class_name ) ) {
                    $widgets_manager->register( new $class_name() );
                    break;
                }
            }
        }
    }

    /**
     * Enqueue individual CSS styles for active widgets.
     *
     * @return void
     */
    public function enqueue_widget_styles() {
        $enabled_widgets = get_option( 'awea_widgets_enabled', array() );
        $enabled_widgets = is_array( $enabled_widgets ) ? $enabled_widgets : array();
        $widget_slugs    = ! empty( $this->widgets ) ? $this->widgets : $this->get_widget_folders();

        foreach ( $widget_slugs as $slug ) {
            $clean_slug = sanitize_key( $slug );

            if ( isset( $enabled_widgets[ $clean_slug ] ) && ! $enabled_widgets[ $clean_slug ] ) {
                continue;
            }

            $css_file = 'widgets/' . $clean_slug . '/' . $clean_slug . '.css';

            if ( file_exists( AWEA_PATH . $css_file ) ) {
                wp_enqueue_style(
                    'awea-' . $clean_slug,
                    AWEA_URL . $css_file,
                    array(),
                    defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0'
                );
            }
        }
    }

    /**
     * Enqueue individual JS scripts for active widgets.
     *
     * @return void
     */
    public function enqueue_widget_scripts() {
        $enabled_widgets = get_option( 'awea_widgets_enabled', array() );
        $enabled_widgets = is_array( $enabled_widgets ) ? $enabled_widgets : array();
        $widget_slugs    = ! empty( $this->widgets ) ? $this->widgets : $this->get_widget_folders();

        foreach ( $widget_slugs as $slug ) {
            $clean_slug = sanitize_key( $slug );

            if ( isset( $enabled_widgets[ $clean_slug ] ) && ! $enabled_widgets[ $clean_slug ] ) {
                continue;
            }

            $js_file = 'widgets/' . $clean_slug . '/' . $clean_slug . '.js';

            if ( file_exists( AWEA_PATH . $js_file ) ) {
                wp_enqueue_script(
                    'awea-' . $clean_slug,
                    AWEA_URL . $js_file,
                    array( 'jquery' ),
                    defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0',
                    true
                );
            }
        }
    }

    /**
     * Helper method to discover widget folders if no widgets array was passed.
     *
     * @return array
     */
    private function get_widget_folders() {
        $dirs = glob( AWEA_PATH . 'widgets/*', GLOB_ONLYDIR );
        return ! empty( $dirs ) ? array_map( 'basename', $dirs ) : array();
    }
}