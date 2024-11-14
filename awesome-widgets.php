<?php
/**
 * Plugin Name: Awesome Widgets for Elementor
 * Description: Easily integrate Contact Form 7 forms into Elementor using a dedicated widget.
 * Version: 1.0.0
 * Author: Abdullah Nahian
 * Text Domain: awesome-widgets-elementor
 * Domain Path: /languages
 * License: GPL-2.0-or-later
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
                'slug'                => 'awesome-widgets-elementor',
                'type'                => 'plugin',
                'public_key'          => 'pk_23e89894238073bcb61ffa59279c6',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'awesome-widgets-elementor',
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
        'awesome-testimonials',
        'awesome-contact-info',
        'awesome-team',
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
            'awesome-widgets-elementor', 
            [$this, 'general_page'], 
            '', 
            59
        );
    
        // Submenu for General
        add_submenu_page(
            'awesome-widgets-elementor',
            'General Settings',
            'General',
            'manage_options',
            'awesome-widgets-elementor',
            [$this, 'general_page']
        );
    
        // Submenu for Widgets
        add_submenu_page(
            'awesome-widgets-elementor',
            'Widgets Settings',
            'Widgets',
            'manage_options',
            'awesome-widgets-widgets',
            [$this, 'widgets_page']
        );
    
        // Submenu for System Info
        add_submenu_page(
            'awesome-widgets-elementor',
            'System Info',
            'System Info',
            'manage_options',
            'awesome-widgets-system-info',
            [$this, 'system_info_page']
        );
    }

    // General Page Callback
    public function general_page() {
        ?>
        <div class="awea-wrap">
            <h1>Awesome Widgets - General Settings</h1>       
<p><strong>Awesome Widgets for Elementor</strong> is a powerful and versatile plugin designed to supercharge your Elementor page builder experience. With a collection of unique, customizable widgets, this plugin helps you create stunning, responsive, and professional websites effortlessly.</p>

<h3>🌟 Key Features:</h3>
<ul>
  <li><strong>Exclusive Widgets:</strong> Access a wide variety of widgets to enhance your website's design and functionality.</li>
  <li><strong>Customizable Elements:</strong> Tailor each widget to match your brand’s style with extensive customization options.</li>
  <li><strong>Responsive Design:</strong> All widgets are fully responsive, ensuring a seamless experience across all devices.</li>
  <li><strong>Lightweight and Fast:</strong> Optimized for performance, the plugin ensures minimal impact on your site's speed.</li>
  <li><strong>Regular Updates:</strong> Stay ahead with frequent updates and new widget additions.</li>
</ul>

<h3>🚀 Widgets Included:</h3>
<ul>
  <li><strong>Advanced Slider:</strong> Create eye-catching sliders with dynamic content and animations.</li>
  <li><strong>Testimonials:</strong> Display customer reviews in a stylish, engaging manner.</li>
  <li><strong>Info Box:</strong> Showcase information with beautiful icons and text combinations.</li>
  <li><strong>Team Member:</strong> Introduce your team with customizable team member cards.</li>
  <li><strong>Pricing Table:</strong> Present your services or products with detailed, appealing pricing tables.</li>
</ul>

<h3>💡 Why Choose Awesome Widgets for Elementor?</h3>
<p>Whether you're building a blog, e-commerce site, or business website, <strong>Awesome Widgets for Elementor</strong> provides a comprehensive toolkit to help you bring your vision to life. Its user-friendly interface and powerful features make it the perfect addition to any Elementor-powered website.</p>
     
        </div>
        <?php
    }

    public function widgets_page() {
        // Check if the form has been submitted and changes have been saved.
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            // Add a success notice using add_settings_error.
            add_settings_error('awea_widgets_messages', 'awea_widgets_message', 'Settings saved successfully.', 'updated');
        }
    ?>
        <div class="awea-wrap">
            <h1>Awesome Widgets Settings</h1>
            <p>Enable or disable the widgets for your Elementor design needs.</p>
    
            <!-- Display settings errors (if any) -->
            <?php settings_errors('awea_widgets_messages'); ?>
    
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
                ?>
                <ul class="awea-widgets-list">
                    <?php
                    $options = get_option('awea_widgets_enabled', []);
                    foreach ($this->widgets as $widget) {
                        $checked = isset($options[$widget]) ? $options[$widget] : 0;
                        ?>
                        <li class="awea-widgets-list-item">
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
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="awea-button-container">
                    <?php submit_button('Save Changes', 'primary', 'submit', true, ['class' => 'awea-button']); ?>
                </div>
            </form>
        </div>
        <?php
    }
    


    // System Info Page Callback
    public function system_info_page() {
        ?>
        <div class="awea-wrap">
            <h1>Awesome Widgets - System Info</h1>
            <?php
                $system_info = [
                    'PHP Version'        => phpversion(),
                    'WordPress Version'  => get_bloginfo('version'),
                    'Active Theme'       => wp_get_theme()->get('Name'),
                    'Elementor Version'  => ELEMENTOR_VERSION,
                    'WP Memory Limit'    => ini_get('memory_limit'),
                    'WP Debug Mode'      => (defined('WP_DEBUG') && WP_DEBUG ? 'Enabled' : 'Disabled'),
                    'Server Software'    => $_SERVER['SERVER_SOFTWARE'],
                    'PHP SAPI'           => php_sapi_name(),
                ];

            echo '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
            echo '<thead><tr><th>Information</th><th>Details</th></tr></thead><tbody>';

            foreach ($system_info as $label => $value) {
                echo "<tr><td>{$label}</td><td>{$value}</td></tr>";
            }

            echo '</tbody></table>';
            ?>

                </div>
                <?php
            }    

            public function settings_init() {
                // Register settings for Widgets
                register_setting('awesomeWidgets', 'awea_widgets_enabled');

                add_settings_section('awea_section', 'Widgets Settings', null, 'awesome-widgets-elementor');
                foreach ($this->widgets as $widget) {
                    add_settings_field(
                        "awea_{$widget}_enabled",
                        ucfirst(str_replace('-', ' ', $widget)),
                        [$this, 'checkbox_render'],
                        'awesome-widgets-elementor',
                        'awea_section',
                        ['widget' => $widget]
                    );
                }

                // Register settings for General
                register_setting('awesomeWidgetsGeneral', 'awea_general_options');

                add_settings_section('awea_general_section', 'General Settings', null, 'awesome-widgets-general');
                add_settings_field(
                    'awea_general_field',
                    'General Option',
                    function () {
                        $options = get_option('awea_general_options');
                        ?>
                        <input type="text" name="awea_general_options[general_field]" 
                            value="<?php echo isset($options['general_field']) ? esc_attr($options['general_field']) : ''; ?>" />
                        <?php
                    },
                    'awesome-widgets-general',
                    'awea_general_section'
                );
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
                        do_settings_sections('awesome-widgets-elementor');
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
                    'title' => esc_html__('Awesome Widgets', 'awesome-widgets-elementor'),
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