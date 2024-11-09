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

 if ( ! function_exists( 'awe_fs' ) ) {
    // Create a helper function for easy SDK access.
    function awe_fs() {
        global $awe_fs;

        if ( ! isset( $awe_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $awe_fs = fs_dynamic_init( array(
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

        return $awe_fs;
    }

    // Init Freemius.
    awe_fs();
    // Signal that SDK was initiated.
    do_action( 'awe_fs_loaded' );
}


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
        // Enqueue Admin CSS
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);

        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'awea_scripts']);

    
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
        add_menu_page(
            'Awesome Widgets', 
            'Awesome Widgets', 
            'manage_options', 
            'awesome-widgets', 
            [$this, 'admin_general_page'],
            'dashicons-admin-generic', 
            90
        );
    
        add_submenu_page(
            'awesome-widgets', 
            'General Settings', 
            'General', 
            'manage_options', 
            'awesome-widgets', 
            [$this, 'admin_general_page']
        );
    
        add_submenu_page(
            'awesome-widgets', 
            'Widgets Settings', 
            'Widgets', 
            'manage_options', 
            'awesome-widgets-widgets', 
            [$this, 'admin_widgets_page']
        );
    
        add_submenu_page(
            'awesome-widgets', 
            'System Info', 
            'System Info', 
            'manage_options', 
            'awesome-widgets-system-info', 
            [$this, 'admin_system_info_page']
        );
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
        $checked = isset($options[$widget]) ? $options[$widget] : 0;
        ?>
        <label for="awea_<?php echo esc_attr($widget); ?>" class="awea-switch-container">
            <span class="awea-switch">
                <input 
                    type="checkbox" 
                    id="awea_<?php echo esc_attr($widget); ?>" 
                    name="awea_widgets_enabled[<?php echo esc_attr($widget); ?>]" 
                    value="1" 
                    <?php checked($checked, 1); ?>
                />
                <span class="awea-slider"></span>
            </span>
            <span class="awea-switch-label">
                <?php echo ucfirst(str_replace('-', ' ', $widget)); ?>
            </span>
        </label>
        <?php
    }
    

    public function admin_page() {
        ?>
        <div class="awea-dashboard-container">
            <div class="awea-dashboard-header">
                <h1>Awesome Widgets Settings</h1>
                <p>Enable or disable the widgets for your Elementor design needs.</p>
            </div>
    
            <!-- Master Toggle On/Off -->
            <div class="awea-toggle-all-container">
                <label for="awea_toggle_all" class="awea-switch-container">
                    <span class="awea-switch">
                        <input 
                            type="checkbox" 
                            id="awea_toggle_all" 
                        />
                        <span class="awea-slider"></span>
                    </span>
                    <span class="awea-switch-label">Toggle All On/Off</span>
                </label>
            </div>
    
            <form action='options.php' method='post' class="awea-settings-form">
                <?php
                settings_fields('awesomeWidgets');
                do_settings_sections('awesome-widgets');
                ?>
                <div class="awea-button-container">
                    <?php submit_button('Save Changes', 'primary', 'submit', true, ['class' => 'awea-button']); ?>
                </div>
            </form>
        </div>
        <?php
    }
    


    public function are_widgets_enabled() {
        $options = get_option('awea_widgets_enabled');
        return !empty($options);
    }

    public function register_widgets($widgets_manager) {
        $options = get_option('awea_widgets_enabled', []);
    
        foreach ($this->widgets as $widget) {
            // Check if the widget is enabled
            if (isset($options[$widget]) && $options[$widget] == 1) {
                // Load PHP file for the widget only if it is enabled
                require_once AWEA_PATH . "widgets/{$widget}.php";
                $class_name = "Elementor\\Widget_" . str_replace('-', '_', ucwords($widget, '-'));
                $widgets_manager->register(new $class_name());
            }
        }
    }

    public function admin_general_page() {
        ?>
        <div class="wrap">
        <div class="general-section">
    <h2 class="section-title">Special Offers</h2>
    <div class="general-boxes">
        <div class="general-box">
            <img src="path_to_image1.jpg" alt="Offer 1">
            <h3>Limited Time Offer</h3>
            <p>Get 50% off on selected items. Don't miss out!</p>
            <a href="#" class="btn">Shop Now</a>
        </div>
        <div class="general-box">
            <img src="path_to_image2.jpg" alt="Offer 2">
            <h3>Free Shipping</h3>
            <p>Enjoy free shipping on all orders above $100.</p>
            <a href="#" class="btn">Shop Now</a>
        </div>
        <div class="general-box">
            <img src="path_to_image3.jpg" alt="Offer 3">
            <h3>Exclusive Deals</h3>
            <p>Sign up for our newsletter and get exclusive deals.</p>
            <a href="#" class="btn">Subscribe Now</a>
        </div>
    </div>
</div>

        </div>
        <?php
    }

    public function admin_widgets_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Widgets Settings', 'awesome-widgets'); ?></h1>
            <form action='options.php' method='post' class="awea-settings-form">
                <?php
                settings_fields('awesomeWidgets');
                do_settings_sections('awesome-widgets');
                submit_button('Save Changes', 'primary', 'submit', true, ['class' => 'awea-button']);
                ?>
            </form>
        </div>
        <?php
    }

    public function system_info_page() {
        global $wpdb;
        ?>
        <h3>System Info</h3>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('PHP Version', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(PHP_VERSION); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('WordPress Version', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(get_bloginfo('version')); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Plugin Version', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(AWEA_VERSION); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Server Info', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('MySQL Version', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html($wpdb->db_version()); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Active Theme', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(wp_get_theme()->get('Name') . ' ' . wp_get_theme()->get('Version')); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Active Plugins', 'awesome-widgets'); ?></th>
                    <td>
                        <?php
                        $active_plugins = get_option('active_plugins');
                        foreach ($active_plugins as $plugin) {
                            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                            echo esc_html($plugin_data['Name']) . ' ' . esc_html($plugin_data['Version']) . '<br>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('WP Memory Limit', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(ini_get('memory_limit')); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('WP Debug Mode', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(defined('WP_DEBUG') && WP_DEBUG ? 'Enabled' : 'Disabled'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Max Upload File Size', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(ini_get('upload_max_filesize')); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Max Post Size', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(ini_get('post_max_size')); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Max Execution Time', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(ini_get('max_execution_time') . ' seconds'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('WordPress Site URL', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(get_site_url()); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('WordPress Home URL', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(home_url()); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Is WordPress Multisite?', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(is_multisite() ? 'Yes' : 'No'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Server Timezone', 'awesome-widgets'); ?></th>
                    <td><?php echo esc_html(date_default_timezone_get()); ?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
    
    public function admin_system_info_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('System Info', 'awesome-widgets'); ?></h1>
            <?php $this->system_info_page(); ?>
        </div>
        <?php
    }
    
    
    
    public function awea_scripts() {
        $options = get_option('awea_widgets_enabled', []);
    
        // Array of widget-specific CSS and JS files
        $styles = [
            'awesome-cta' => 'cta.css',
            'awesome-heading' => 'heading.css',
            'awesome-image-box' => 'image-box.css',
            'awesome-list-group' => 'list-group.css',
            'awesome-number-box' => 'number-box.css',
            'awesome-price' => 'price.css',
            'awesome-process' => 'process.css',
            'awesome-post-grid' => 'post-grid.css',
            'awesome-post-list' => 'post-list.css',
            'awesome-post-tab' => 'post-tab.css',
            'awesome-timeline' => 'timeline.css',
            'awesome-woo-category-list' => 'woo-category-list.css',
            'awesome-woo-product-carousel' => 'woo-product-carousel.css',
            'awesome-woo-product-list' => 'woo-product-list.css',
            'awesome-woo-product-tab' => 'woo-product-tab.css',
        ];
    
        $scripts = [
            'awesome-cta' => 'cta.js',
            'awesome-heading' => 'heading.js',
            'awesome-image-box' => 'image-box.js',
            'awesome-list-group' => 'list-group.js',
            'awesome-number-box' => 'number-box.js',
            'awesome-price' => 'price.js',
            'awesome-process' => 'process.js',
            'awesome-post-grid' => 'post-grid.js',
            'awesome-post-list' => 'post-list.js',
            'awesome-post-tab' => 'post-tab.js',
            'awesome-timeline' => 'timeline.js',
            'awesome-woo-category-list' => 'woo-category-list.js',
            'awesome-woo-product-carousel' => 'woo-product-carousel.js',
            'awesome-woo-product-list' => 'woo-product-list.js',
            'awesome-woo-product-tab' => 'woo-product-tab.js',
        ];
    
        // Enqueue CSS files only for enabled widgets
        foreach ($styles as $widget => $css_file) {
            if (isset($options[$widget]) && $options[$widget] == 1) {
                wp_enqueue_style("awesome-widgets-{$widget}-style", AWEA_URL . "assets/css/{$css_file}", [], AWEA_VERSION);
            }
        }
    
        // Enqueue JS files only for enabled widgets
        foreach ($scripts as $widget => $js_file) {
            if (isset($options[$widget]) && $options[$widget] == 1) {
                wp_enqueue_script("awesome-widgets-{$widget}-script", AWEA_URL . "assets/js/{$js_file}", ['jquery'], AWEA_VERSION, true);
            }
        }
    }
    

    public function elementor_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category('awesome-widgets-elementor', [
            'title' => esc_html__('Awesome Widgets', 'awesome-widgets'),
        ], 1);
    }

    public function enqueue_admin_styles($hook) {
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

add_action('after_setup_theme', [AWEA::class, 'instance']);
