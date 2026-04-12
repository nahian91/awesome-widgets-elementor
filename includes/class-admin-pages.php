<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class AWEA_Admin_Pages {

    private $widgets;

    public function __construct($widgets) {
        $this->widgets = $widgets;
        add_action('admin_menu', [$this, 'add_admin_menu']);
        // This is the only addition: it hides the Elementor header/loader on your pages
        add_action('admin_head', [$this, 'fix_elementor_conflict']);
    }

    /**
     * Hides Elementor Top Bar and Loader without changing your HTML structure
     */
    public function fix_elementor_conflict() {
        $screen = get_current_screen();
        if ( $screen && strpos($screen->id, 'awesome-widgets') !== false ) {
            echo '<style>
                #e-admin-top-bar-root, .e-admin-top-bar--active #e-admin-top-bar-root, #elementor-editor-loading { display: none !important; }
                body.e-admin-top-bar--active { margin-top: 0 !important; }
            </style>';
        }
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

        add_submenu_page(
            'awesome-widgets-elementor',
            'General Settings',
            'General',
            'manage_options',
            'awesome-widgets-elementor',
            [$this, 'general_page']
        );

        add_submenu_page(
            'awesome-widgets-elementor',
            'Widgets Settings',
            'Widgets',
            'manage_options',
            'awesome-widgets-widgets',
            [$this, 'widgets_page']
        );
    }

    public function general_page() {
    ?>
    <div class="awea-wrap awea-general-page" style="width:100%; max-width:none; padding:20px; box-sizing:border-box; font-family: Arial, sans-serif; line-height:1.6;">

        <h1><?php esc_html_e('Awesome Widgets - General Settings', 'awesome-widgets-elementor'); ?></h1>

        <div style="display:flex; gap:40px; flex-wrap: wrap;">
            <div style="flex:1 1 60%; min-width:280px;">
                <p><strong><?php esc_html_e('Awesome Widgets for Elementor', 'awesome-widgets-elementor'); ?></strong>
                <?php esc_html_e('is your ultimate toolkit for designing professional, engaging, and visually stunning websites. Built specifically for Elementor, this plugin offers a wide variety of feature-rich widgets that seamlessly integrate with your design workflow.', 'awesome-widgets-elementor'); ?></p>

                <h2><?php esc_html_e('Key Features', 'awesome-widgets-elementor'); ?></h2>
                <ul>
                    <li><strong><?php esc_html_e('Diverse Widget Collection:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('Over 50 customizable widgets including sliders, pricing tables, galleries, testimonials, and more.', 'awesome-widgets-elementor'); ?></li>
                    <li><strong><?php esc_html_e('Responsive Design:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('All widgets adapt perfectly to any screen size ensuring seamless mobile experience.', 'awesome-widgets-elementor'); ?></li>
                    <li><strong><?php esc_html_e('Easy Customization:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('User-friendly controls allow you to style and configure widgets without any coding knowledge.', 'awesome-widgets-elementor'); ?></li>
                    <li><strong><?php esc_html_e('Performance Optimized:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('Lightweight code ensures your website loads fast without sacrificing functionality.', 'awesome-widgets-elementor'); ?></li>
                    <li><strong><?php esc_html_e('Seamless Integration:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('Works flawlessly with Elementor and compatible with most WordPress themes and plugins.', 'awesome-widgets-elementor'); ?></li>
                    <li><strong><?php esc_html_e('Regular Updates & Support:', 'awesome-widgets-elementor'); ?></strong> <?php esc_html_e('Continuous improvements and responsive support to help you succeed.', 'awesome-widgets-elementor'); ?></li>
                </ul>

                <h2><?php esc_html_e('Getting Started', 'awesome-widgets-elementor'); ?></h2>
                <p><?php esc_html_e('After installing and activating the plugin, you can access all widgets from within the Elementor editor. Simply search for "Awesome" in the widget panel, drag your desired widget onto the page, and customize using the intuitive settings.', 'awesome-widgets-elementor'); ?></p>
            </div>

            <div style="flex:1 1 35%; min-width:260px; background:#f9f9f9; padding:20px; border-radius:8px; box-sizing:border-box;">
                <h2><?php esc_html_e('Resources & Support', 'awesome-widgets-elementor'); ?></h2>
                <ul>
                    <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Documentation', 'awesome-widgets-elementor'); ?></a></li>
                    <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Live Demo', 'awesome-widgets-elementor'); ?></a></li>
                    <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Support Forum', 'awesome-widgets-elementor'); ?></a></li>
                </ul>

                <h2><?php esc_html_e('Contact Us', 'awesome-widgets-elementor'); ?></h2>
                <p><?php esc_html_e('We\'d love to hear from you! Whether you have questions, suggestions, or need help, feel free to reach out:', 'awesome-widgets-elementor'); ?></p>
                <ul>
                    <li><?php esc_html_e('Email:', 'awesome-widgets-elementor'); ?> <a href="mailto:nahiansylhet@gmail.com">nahiansylhet@gmail.com</a></li>
                    <li><?php esc_html_e('Website:', 'awesome-widgets-elementor'); ?> <a href="https://devnahian.com" target="_blank" rel="noopener">https://devnahian.com</a></li>
                </ul>

                <p><em><?php esc_html_e('Thank you for choosing Awesome Widgets! We are committed to helping you build the website of your dreams.', 'awesome-widgets-elementor'); ?></em></p>
            </div>
        </div>
    </div>
    <?php
}


    public function widgets_page() {
        // Safely get and sanitize 'settings-updated' from URL
        $settings_updated = false;
        if (isset($_GET['settings-updated'])) {
            $settings_updated = filter_var(wp_unslash($_GET['settings-updated']), FILTER_VALIDATE_BOOLEAN);
        }

        if ($settings_updated) {
            add_settings_error(
                'awea_widgets_messages',
                'awea_widgets_message',
                esc_html__('Settings saved successfully.', 'awesome-widgets-elementor'),
                'updated'
            );
        }

        $options = get_option('awea_widgets_enabled', []);
        $total_widgets = count($this->widgets);
        $active_widgets = count(array_filter($options));
        $deactive_widgets = $total_widgets - $active_widgets;

        ?>
        <div class="awea-wrap">
            <h1><?php esc_html_e('Awesome Widgets Settings', 'awesome-widgets-elementor'); ?></h1>
            <p><?php esc_html_e('Enable or disable the widgets for your Elementor design needs.', 'awesome-widgets-elementor'); ?></p>

            <div class="awea-widget-counts" style="margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; display: flex; gap: 30px; font-size: 16px;">
                <div><strong><?php esc_html_e('Total Widgets:', 'awesome-widgets-elementor'); ?></strong> <?php echo esc_html($total_widgets); ?></div>
                <div><strong><?php esc_html_e('Active:', 'awesome-widgets-elementor'); ?></strong> <?php echo esc_html($active_widgets); ?></div>
                <div><strong><?php esc_html_e('Inactive:', 'awesome-widgets-elementor'); ?></strong> <?php echo esc_html($deactive_widgets); ?></div>
            </div>

            <?php settings_errors('awea_widgets_messages'); ?>

            <div class="awea-toggle-all-container">
                <label for="awea_toggle_all" class="awea-switch-container">
                    <span class="awea-switch">
                        <input type="checkbox" id="awea_toggle_all" />
                        <span class="awea-slider"></span>
                    </span>
                    <span class="awea-switch-label"><?php esc_html_e('Toggle All On/Off', 'awesome-widgets-elementor'); ?></span>
                </label>
            </div>

            <form action="options.php" method="post" class="awea-settings-form">
                <?php 
                // Outputs nonce, action, and option_page fields for the settings group
                settings_fields('awesomeWidgets'); 
                ?>
                <ul class="awea-widgets-list">
                    <?php foreach ($this->widgets as $widget): ?>
                        <?php $checked = isset($options[$widget]) ? $options[$widget] : 0; ?>
                        <li class="awea-widgets-list-item">
                            <label for="awea_<?php echo esc_attr($widget); ?>" class="awea-switch-container">
                                <span class="awea-switch-label"><?php echo esc_html(ucfirst(str_replace('-', ' ', $widget))); ?></span>
                                <span class="awea-switch">
                                    <input type="checkbox"
                                           id="awea_<?php echo esc_attr($widget); ?>"
                                           name="awea_widgets_enabled[<?php echo esc_attr($widget); ?>]"
                                           value="1" <?php checked($checked, 1); ?> />
                                    <span class="awea-slider"></span>
                                </span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="awea-button-container">
                    <?php submit_button(__('Save Changes', 'awesome-widgets-elementor'), 'primary', 'submit', true, ['class' => 'awea-button']); ?>
                </div>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleAll = document.getElementById('awea_toggle_all');
            const checkboxes = document.querySelectorAll('.awea-widgets-list input[type="checkbox"]');
            
            if (toggleAll) {
                toggleAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = toggleAll.checked);
                });
            }
        });
        </script>
        <?php
    }
}