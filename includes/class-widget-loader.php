<?php
/**
 * Elementor Widget Loader Class.
 *
 * @package AwesomeWidgetsElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AWEA_Widget_Loader
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

		// Register custom Elementor category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );

		// Register Elementor widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Enqueue widget-specific styles and scripts.
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_widget_scripts' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'enqueue_widget_scripts' ) );
	}

	/**
	 * Register the custom Awesome Widgets category in Elementor's panel.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager instance.
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'awesome-widgets-elementor',
			array(
				'title' => esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register active widgets with Elementor.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager instance.
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

			// Expected class name convention: AWEA_Awesome_Cta or Elementor\Widget_Awesome_Cta (supports both for backwards compatibility).
			$pascal_slug = str_replace( ' ', '_', ucwords( str_replace( array( '-', '_' ), ' ', $clean_slug ) ) );
			$class_names = array(
				'AWEA_' . $pascal_slug,
				'AWEA_Widget_' . $pascal_slug,
				'Elementor\\Widget_' . $pascal_slug,
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
					AWEA_VERSION
				);
			}
		}
	}

	/**
	 * Enqueue individual JS scripts for active widgets.
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
					AWEA_VERSION,
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