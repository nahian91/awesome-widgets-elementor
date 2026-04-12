<?php

if ( ! defined( 'ABSPATH' ) ) exit; 
class AWEA_Settings {

    private $widgets;

    public function __construct($widgets) {
        $this->widgets = $widgets;

        add_action('admin_init', [$this, 'settings_init']);
        register_activation_hook(AWEA_FILE, [$this, 'set_default_options']);
    }

    public function set_default_options() {
        $default_options = array_fill_keys($this->widgets, 1); // enable all by default
        update_option('awea_widgets_enabled', $default_options);
    }

    public function settings_init() {
        // Register widget toggle settings with sanitization
        register_setting('awesomeWidgets', 'awea_widgets_enabled', [
            'sanitize_callback' => [$this, 'sanitize_widget_settings']
        ]);

        add_settings_section(
            'awea_section',
            esc_html__('Widgets Settings', 'awesome-widgets-elementor'),
            null,
            'awesome-widgets-elementor'
        );

        foreach ($this->widgets as $widget) {
            add_settings_field(
                "awea_{$widget}_enabled",
                esc_html(ucfirst(str_replace('-', ' ', $widget))),
                [$this, 'checkbox_render'],
                'awesome-widgets-elementor',
                'awea_section',
                ['widget' => $widget]
            );
        }

        // Register general settings with sanitization
        register_setting('awesomeWidgetsGeneral', 'awea_general_options', [
            'sanitize_callback' => [$this, 'sanitize_general_settings']
        ]);

        add_settings_section(
            'awea_general_section',
            esc_html__('General Settings', 'awesome-widgets-elementor'),
            null,
            'awesome-widgets-general'
        );

        add_settings_field(
            'awea_general_field',
            esc_html__('General Option', 'awesome-widgets-elementor'),
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
        $widget = $args['widget'];
        $options = get_option('awea_widgets_enabled', []);
        $checked = isset($options[$widget]) ? $options[$widget] : 0;
        ?>
        <label for="awea_<?php echo esc_attr($widget); ?>" class="awea-switch-container">
            <span class="awea-switch">
                <input type="checkbox"
                       id="awea_<?php echo esc_attr($widget); ?>"
                       name="awea_widgets_enabled[<?php echo esc_attr($widget); ?>]"
                       value="1" <?php checked($checked, 1); ?> />
                <span class="awea-slider"></span>
            </span>
            <span class="awea-switch-label"><?php echo esc_html(ucfirst(str_replace('-', ' ', $widget))); ?></span>
        </label>
        <?php
    }

    /**
     * Sanitization for widget toggle options
     */
    public function sanitize_widget_settings($input) {
        $sanitized = [];
        foreach ($this->widgets as $widget) {
            $sanitized[$widget] = isset($input[$widget]) && $input[$widget] == '1' ? 1 : 0;
        }
        return $sanitized;
    }

    /**
     * Sanitization for general options
     */
    public function sanitize_general_settings($input) {
        $sanitized = [];
        $sanitized['general_field'] = isset($input['general_field']) ? sanitize_text_field($input['general_field']) : '';
        return $sanitized;
    }
}
