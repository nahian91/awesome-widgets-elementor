<?php
/**
 * Settings Manager Class.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class AWEA_Settings
 *
 * Manages plugin settings registration, sanitization routines, and default option hydration.
 */
class AWEA_Settings {

    /**
     * Available widget slugs.
     *
     * @var array
     */
    private $widgets = array();

    /**
     * Constructor.
     *
     * @param array $widgets List of widget slugs.
     */
    public function __construct( $widgets = array() ) {
        $this->widgets = is_array( $widgets ) ? $widgets : array();

        add_action( 'admin_init', array( $this, 'settings_init' ) );
    }

    /**
     * Set default options on plugin activation.
     *
     * Note: Can be called statically from the root plugin activation hook.
     * Uses add_option() to avoid overwriting existing user configurations.
     *
     * @param array $widgets Optional list of widget slugs.
     * @return void
     */
    public static function set_default_options( $widgets = array() ) {
        if ( empty( $widgets ) && class_exists( '\Elementor\AWEA' ) && method_exists( '\Elementor\AWEA', 'instance' ) ) {
            $widgets = AWEA::instance()->get_widgets();
        }

        if ( ! empty( $widgets ) && is_array( $widgets ) ) {
            $default_options = array_fill_keys( $widgets, 1 );
            add_option( 'awea_widgets_enabled', $default_options );
        }

        add_option( 'awea_general_options', array( 'general_field' => '' ) );
    }

    /**
     * Initialize Settings, Sections, and Fields.
     *
     * @return void
     */
    public function settings_init() {
        // ---------------------------------------------------------------------
        // 1. Widget Toggle Settings
        // ---------------------------------------------------------------------
        register_setting(
            'awesomeWidgets',
            'awea_widgets_enabled',
            array(
                'type'              => 'array',
                'description'       => esc_html__( 'Enabled status for Awesome Widgets', 'awesome-widgets-elementor' ),
                'sanitize_callback' => array( $this, 'sanitize_widget_settings' ),
                'show_in_rest'      => false,
                'default'           => array(),
            )
        );

        add_settings_section(
            'awea_section',
            esc_html__( 'Widgets Settings', 'awesome-widgets-elementor' ),
            '__return_false',
            'awesome-widgets-elementor'
        );

        foreach ( $this->widgets as $widget ) {
            $clean_slug  = sanitize_key( $widget );
            $field_title = ucwords( str_replace( array( '-', '_' ), ' ', $clean_slug ) );

            add_settings_field(
                'awea_' . $clean_slug . '_enabled',
                esc_html( $field_title ),
                array( $this, 'render_checkbox_field' ),
                'awesome-widgets-elementor',
                'awea_section',
                array(
                    'widget' => $clean_slug,
                    'label'  => $field_title,
                )
            );
        }

        // ---------------------------------------------------------------------
        // 2. General Settings
        // ---------------------------------------------------------------------
        register_setting(
            'awesomeWidgetsGeneral',
            'awea_general_options',
            array(
                'type'              => 'array',
                'description'       => esc_html__( 'General options for Awesome Widgets', 'awesome-widgets-elementor' ),
                'sanitize_callback' => array( $this, 'sanitize_general_settings' ),
                'show_in_rest'      => false,
                'default'           => array( 'general_field' => '' ),
            )
        );

        add_settings_section(
            'awea_general_section',
            esc_html__( 'General Settings', 'awesome-widgets-elementor' ),
            '__return_false',
            'awesome-widgets-general'
        );

        add_settings_field(
            'awea_general_field',
            esc_html__( 'General Option', 'awesome-widgets-elementor' ),
            array( $this, 'render_general_field' ),
            'awesome-widgets-general',
            'awea_general_section'
        );
    }

    /**
     * Render a widget toggle checkbox.
     *
     * @param array $args Field arguments containing 'widget' slug and 'label'.
     * @return void
     */
    public function render_checkbox_field( $args ) {
        $widget  = isset( $args['widget'] ) ? sanitize_key( $args['widget'] ) : '';
        $label   = isset( $args['label'] ) ? $args['label'] : '';
        $options = get_option( 'awea_widgets_enabled', array() );
        $options = is_array( $options ) ? $options : array();
        $checked = ! empty( $options[ $widget ] );
        ?>
        <label for="awea_<?php echo esc_attr( $widget ); ?>" class="awea-switch-container">
            <span class="awea-switch">
                <input type="checkbox"
                    id="awea_<?php echo esc_attr( $widget ); ?>"
                    name="awea_widgets_enabled[<?php echo esc_attr( $widget ); ?>]"
                    value="1" 
                    <?php checked( $checked, true ); ?> 
                />
                <span class="awea-slider"></span>
            </span>
            <span class="awea-switch-label"><?php echo esc_html( $label ); ?></span>
        </label>
        <?php
    }

    /**
     * Render the general text input field.
     *
     * @return void
     */
    public function render_general_field() {
        $options = get_option( 'awea_general_options', array() );
        $value   = isset( $options['general_field'] ) ? $options['general_field'] : '';
        ?>
        <input type="text"
            id="awea_general_field"
            class="regular-text"
            name="awea_general_options[general_field]"
            value="<?php echo esc_attr( $value ); ?>" 
        />
        <?php
    }

    /**
     * Sanitize widget toggle option input.
     *
     * @param mixed $input Submitted raw values.
     * @return array
     */
    public function sanitize_widget_settings( $input ) {
        $sanitized = array();
        $input     = is_array( $input ) ? $input : array();

        foreach ( $this->widgets as $widget ) {
            $clean_slug                   = sanitize_key( $widget );
            $sanitized[ $clean_slug ] = ! empty( $input[ $clean_slug ] ) ? 1 : 0;
        }

        return $sanitized;
    }

    /**
     * Sanitize general options input.
     *
     * @param mixed $input Submitted raw values.
     * @return array
     */
    public function sanitize_general_settings( $input ) {
        $sanitized = array();
        $input     = is_array( $input ) ? $input : array();

        $sanitized['general_field'] = isset( $input['general_field'] ) 
            ? sanitize_text_field( wp_unslash( $input['general_field'] ) ) 
            : '';

        return $sanitized;
    }
}