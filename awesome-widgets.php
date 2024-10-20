<?php
/*
 * Plugin Name: Awesome Widgets
 * Plugin URI: https://devnahian.com/about-us
 * Description: Awesome Widget is Collection of Elementor Page Design
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


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('AWEA_VERSION', '1.0.13');
define('AWEA_FILE', __FILE__);
define('AWEA_PLUGIN_BASENAME', plugin_basename(AWEA_FILE));
define('AWEA_PATH', plugin_dir_path(AWEA_FILE));
define('AWEA_URL', plugins_url('/', AWEA_FILE));

/**
 * Main Class File of plugin
 * @since Awesome Widgets
 */
if (!class_exists('AWEA')) {
    class AWEA
    {
        public $this_uri;
        public $this_dir;

        /**
         * Get Instance
         *
         * @since Awesome Widgets
         */
        private static $_instance = null;
        public static function instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /*
         * Constructor
         */
        public function __construct()
        {

            // This uri & dir
            $this->this_uri = AWEA_URL;
            $this->this_dir = AWEA_PATH;

            if (!did_action('elementor/loaded')) {
                //
            } else {
                //elementor hooks
                add_action('elementor/frontend/after_enqueue_scripts', array($this, 'awea_scripts'));
                add_action('elementor/elements/categories_registered', array($this, 'elementor_category'));
                add_action('elementor/widgets/register', array($this, 'register_widgets'));
            }
        }

        /**
         * To Check Plugin is installed or not
         * @since Awesome Widgets
         */
        function _is_plugin_installed($plugin_path)
        {
            $installed_plugins = get_plugins();
            return isset($installed_plugins[$plugin_path]);
        }

        /**
         * Load and register the required Elementor widgets file
         *
         * @param $widgets_manager
         *
         * @since Awesome Widgets
         */
        function register_widgets($widgets_manager)
        {

            // Load Elementor Featured Service
            require_once $this->this_dir . 'widgets/awesome-cta.php';
            require_once $this->this_dir . 'widgets/awesome-heading.php';
            require_once $this->this_dir . 'widgets/awesome-image-box.php';
            require_once $this->this_dir . 'widgets/awesome-list-group.php';
            require_once $this->this_dir . 'widgets/awesome-number-box.php';
            require_once $this->this_dir . 'widgets/awesome-price.php';
            require_once $this->this_dir . 'widgets/awesome-process.php';

            // // Register Featured Service Widge
            $widgets_manager->register(new \ELementor\Widget_Awesome_Heading());
            $widgets_manager->register(new \ELementor\Widget_Awesome_Image_Box());
            $widgets_manager->register(new \ELementor\Widget_Awesome_List_Group());
            $widgets_manager->register(new \ELementor\Widget_Awesome_Number_Box());
            $widgets_manager->register(new \ELementor\Widget_Awesome_Price());
            $widgets_manager->register(new \ELementor\Widget_Awesome_Process());
            $widgets_manager->register(new \ELementor\Widget_Awesome_CTA());
        }

        /**
         * Loads scripts on elementor editor
         * @since Awesome Widgets
         */
        function awea_scripts()
        {
            // preview script
            wp_enqueue_style('awesome-widgets-bootstrap', $this->this_uri . 'assets/css/bootstrap.minmin.css', array(), AWEA_VERSION);
            wp_enqueue_style('awesome-widgets-fontawesome', $this->this_uri . 'assets/css/fontawesome.min.css', array(), AWEA_VERSION);
            wp_enqueue_style('awesome-widgets-main', $this->this_uri . 'assets/css/main.css', array(), AWEA_VERSION);
            wp_enqueue_style('awesome-widgets-responsive', $this->this_uri . 'assets/css/responsive.css', array(), AWEA_VERSION);
            wp_enqueue_style('awesome-widgets-elementor-responsive', $this->this_uri . 'assets/css/responsive.css', array(), AWEA_VERSION);
        }

        /**
         * Elementor Category
         * @since Awesome Widgets
         */
        function elementor_category()
        {

            // Register widget block category for Elementor section
            \Elementor\Plugin::instance()->elements_manager->add_category('awesome-widgets-elementor', array(
                'title' => esc_html__('Awesome Widgets', 'awesome-widgets'),
            ), 1);
        }
    }
}

add_action('after_setup_theme', function () {
    AWEA::instance();
});
