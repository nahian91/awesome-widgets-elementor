<?php
/**
 * Plugin Name: Awesome Widgets for Elementor
 * Description: Easily create stunning websites with advanced design options and increased functionality.
 * Version: 1.5.1
 * Author: Abdullah Nahian
 * Text Domain: awesome-widgets-elementor
 * Domain Path: /languages
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined('ABSPATH') ) {
    exit;
}

if ( ! function_exists( 'awea_fs' ) ) {
    // Create a helper function for easy SDK access.
    function awea_fs() {
        global $awea_fs;

        if ( ! isset( $awea_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $awea_fs = fs_dynamic_init( array(
                'id'                  => '17015',
                'slug'                => 'awesome-widgets',
                'type'                => 'plugin',
                'public_key'          => 'pk_23e89894238073bcb61ffa59279c6',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'awesome-widgets',
                    'account'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $awea_fs;
    }

    // Init Freemius.
    awea_fs();
    // Signal that SDK was initiated.
    do_action( 'awea_fs_loaded' );
}

// Define plugin constants
define('AWEA_VERSION', '1.3');
define('AWEA_FILE', __FILE__);
define('AWEA_PATH', plugin_dir_path(__FILE__));
define('AWEA_URL', plugin_dir_url(__FILE__));

// Load core plugin class
require_once AWEA_PATH . 'includes/class-plugin-core.php';

// Load widget loader and settings classes
require_once AWEA_PATH . 'includes/class-widget-loader.php';
require_once AWEA_PATH . 'includes/class-settings.php';

// ✅ Auto-detect widget folders
$widget_folders = glob(AWEA_PATH . 'widgets/*', GLOB_ONLYDIR);
$widget_slugs   = array_map('basename', $widget_folders);

// ✅ Initialize settings with widget slugs
new AWEA_Settings($widget_slugs);

// ✅ Initialize loader
new AWEA_Widget_Loader();

// ✅ Initialize plugin (core class boot)
add_action('after_setup_theme', ['AWEA', 'instance']);
