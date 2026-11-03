<?php
/**
 * Plugin Name:       Awesome Widgets for Elementor
 * Description:       Easily create stunning websites with advanced design options and increased functionality.
 * Version:           1.6.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Abdullah Nahian
 * Text Domain:       awesome-widgets-elementor
 * Domain Path:       /languages
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package AwesomeWidgetsElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// -----------------------------------------------------------------------------
// Freemius SDK Initialization
// -----------------------------------------------------------------------------

if ( ! function_exists( 'awea_fs' ) ) {
	/**
	 * Freemius helper function.
	 *
	 * @return object Freemius instance.
	 */
	function awea_fs() {
		global $awea_fs;

		if ( ! isset( $awea_fs ) ) {
			// Include Freemius SDK.
			$sdk_path = dirname( __FILE__ ) . '/freemius/start.php';
			if ( file_exists( $sdk_path ) ) {
				require_once $sdk_path;

				$awea_fs = fs_dynamic_init(
					array(
						'id'             => '17015',
						'slug'           => 'awesome-widgets-elementor',
						'type'           => 'plugin',
						'public_key'     => 'pk_23e89894238073bcb61ffa59279c6',
						'is_premium'     => false,
						'has_addons'     => false,
						'has_paid_plans' => false,
						'menu'           => array(
							'slug'    => 'awesome-widgets-elementor',
							'account' => false,
							'support' => false,
						),
					)
				);
			}
		}

		return $awea_fs;
	}

	// Init Freemius.
	awea_fs();
	do_action( 'awea_fs_loaded' );
}

// -----------------------------------------------------------------------------
// Constants
// -----------------------------------------------------------------------------

if ( ! defined( 'AWEA_VERSION' ) ) {
	define( 'AWEA_VERSION', '1.6.0' );
}

if ( ! defined( 'AWEA_FILE' ) ) {
	define( 'AWEA_FILE', __FILE__ );
}

if ( ! defined( 'AWEA_PATH' ) ) {
	define( 'AWEA_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'AWEA_URL' ) ) {
	define( 'AWEA_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'AWEA_BASENAME' ) ) {
	define( 'AWEA_BASENAME', plugin_basename( __FILE__ ) );
}

// -----------------------------------------------------------------------------
// Core Bootstrap
// -----------------------------------------------------------------------------

/**
 * Bootstrap the plugin after all active plugins are loaded.
 */
function awea_init_plugin() {
	// Load plugin textdomain for i18n.
	load_plugin_textdomain(
		'awesome-widgets-elementor',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);

	// Elementor dependency check.
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'awea_fail_elementor_missing' );
		return;
	}

	// Load core classes.
	require_once AWEA_PATH . 'includes/class-plugin-core.php';
	require_once AWEA_PATH . 'includes/class-widget-loader.php';
	require_once AWEA_PATH . 'includes/class-settings.php';

	// Discover widget folders safely.
	$widget_dir     = AWEA_PATH . 'widgets/*';
	$widget_folders = glob( $widget_dir, GLOB_ONLYDIR );
	$widget_slugs   = ! empty( $widget_folders ) ? array_map( 'basename', $widget_folders ) : array();

	// Initialize Settings & Loader.
	new AWEA_Settings( $widget_slugs );
	new AWEA_Widget_Loader();

	// Initialize Main Singleton.
	if ( class_exists( 'AWEA' ) && method_exists( 'AWEA', 'instance' ) ) {
		AWEA::instance();
	}
}
add_action( 'plugins_loaded', 'awea_init_plugin' );

/**
 * Admin notice shown when Elementor is not installed or inactive.
 */
function awea_fail_elementor_missing() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$elementor_path = 'elementor/elementor.php';
	$installed_plugins = get_plugins();
	$is_installed      = isset( $installed_plugins[ $elementor_path ] );

	if ( $is_installed ) {
		$activation_url = wp_nonce_url(
			'plugins.php?action=activate&plugin=' . $elementor_path . '&plugin_status=all&paged=1&s',
			'activate-plugin_' . $elementor_path
		);
		$message = sprintf(
			/* translators: 1: Plugin name, 2: Action link */
			esc_html__( '"%1$s" requires "Elementor" to be active. %2$s', 'awesome-widgets-elementor' ),
			'<strong>' . esc_html__( 'Awesome Widgets for Elementor', 'awesome-widgets-elementor' ) . '</strong>',
			'<a href="' . esc_url( $activation_url ) . '">' . esc_html__( 'Activate Elementor', 'awesome-widgets-elementor' ) . '</a>'
		);
	} else {
		$install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
			'install-plugin_elementor'
		);
		$message = sprintf(
			/* translators: 1: Plugin name, 2: Action link */
			esc_html__( '"%1$s" requires "Elementor" to be installed. %2$s', 'awesome-widgets-elementor' ),
			'<strong>' . esc_html__( 'Awesome Widgets for Elementor', 'awesome-widgets-elementor' ) . '</strong>',
			'<a href="' . esc_url( $install_url ) . '">' . esc_html__( 'Install Elementor', 'awesome-widgets-elementor' ) . '</a>'
		);
	}

	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}