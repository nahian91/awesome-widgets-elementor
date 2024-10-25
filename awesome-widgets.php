<?php
/*
 * Plugin Name: Awesome Widgets
 * Plugin URI: https://devnahian.com/about-us
 * Description: Awesome Widget is a Collection of Elementor Page Design
 * Version: 1.0.1
 * Author: Abdullah Nahian
 * Author URI: https://devnahian.com
 * Elementor tested up to: 3.19.2
 * Elementor Pro tested up to: 3.19.2
 * Text Domain: awesome-widgets
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

define('AWEA_VERSION', '1.0.1');
define('AWEA_FILE', __FILE__);
define('AWEA_PATH', plugin_dir_path(AWEA_FILE));
define('AWEA_URL', plugins_url('/', AWEA_FILE));

class AWEA {
    private static $_instance = null;

    // List of widgets
    private $widgets = [
        'awesome-cta',
        'awesome-heading',
        'awesome-image-box',
        'awesome-list-group',
        'awesome-number-box',
        'awesome-price',
        'awesome-process',
        'awesome-post-grid',
        'awesome-post-list',
        'awesome-post-tab',
        'awesome-timeline',
        'awesome-woo-category-list',
        'awesome-woo-product-carousel',
        'awesome-woo-product-list',
        'awesome-woo-product-tab',
    ];

    public static function instance() {
        return self::$_instance ?: (self::$_instance = new self());
    }

    public function __construct() {
        // Register the admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);
        // Register settings
        add_action('admin_init', [$this, 'settings_init']);
        // Set default options on activation
        register_activation_hook(AWEA_FILE, [$this, 'set_default_options']);

        if (did_action('elementor/loaded') && $this->are_widgets_enabled()) {
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'awea_scripts']);
            add_action('elementor/elements/categories_registered', [$this, 'elementor_category']);
            add_action('elementor/widgets/register', [$this, 'register_widgets']);
        }
    }

    public function set_default_options() {
        // Set all widgets to enabled (checked) by default
        $default_options = array_fill_keys($this->widgets, 1);
        update_option('awea_widgets_enabled', $default_options);
    }

    public function add_admin_menu() {
        add_menu_page('Awesome Widgets', 'Awesome Widgets', 'manage_options', 'awesome-widgets', [$this, 'admin_page']);
    }

    public function settings_init() {
        register_setting('awesomeWidgets', 'awea_widgets_enabled');

        add_settings_section('awea_section', 'Settings', null, 'awesome-widgets');

        foreach ($this->widgets as $widget) {
            add_settings_field(
                "awea_{$widget}_enabled",
                ucfirst(str_replace('-', ' ', $widget)),
                [$this, 'checkbox_render'],
                'awesome-widgets',
                'awea_section',
                ['widget' => $widget]
            );
        }
    }

    public function checkbox_render($args) {
        $options = get_option('awea_widgets_enabled', []);
        $widget = $args['widget'];
        ?>
        <input type='checkbox' name='awea_widgets_enabled[<?php echo esc_attr($widget); ?>]' value='1' <?php checked(isset($options[$widget]) ? $options[$widget] : 0, 1); ?>>
        <?php
    }

    public function admin_page() {
        ?>
        <form action='options.php' method='post'>
            <h2>Awesome Widgets Settings</h2>
            <?php
            settings_fields('awesomeWidgets');
            do_settings_sections('awesome-widgets');
            submit_button();
            ?>
        </form>
        <?php
    }

    public function are_widgets_enabled() {
        $options = get_option('awea_widgets_enabled');
        return !empty($options);
    }

    public function register_widgets($widgets_manager) {
        $options = get_option('awea_widgets_enabled', []);

        foreach ($this->widgets as $widget) {
            if (isset($options[$widget]) && $options[$widget] == 1) {
                require_once AWEA_PATH . "widgets/{$widget}.php";
                $class_name = "Elementor\\Widget_" . str_replace('-', '_', ucwords($widget, '-'));
                $widgets_manager->register(new $class_name());
            }
        }
    }

    public function awea_scripts() {
        $styles = ['bootstrap.min.css', 'fontawesome.min.css', 'main.css', 'responsive.css'];
        foreach ($styles as $style) {
            wp_enqueue_style("awesome-widgets-$style", AWEA_URL . "assets/css/$style", [], AWEA_VERSION);
        }
    }

    public function elementor_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category('awesome-widgets-elementor', [
            'title' => esc_html__('Awesome Widgets', 'awesome-widgets'),
        ], 1);
    }
}

add_action('after_setup_theme', [AWEA::class, 'instance']);
