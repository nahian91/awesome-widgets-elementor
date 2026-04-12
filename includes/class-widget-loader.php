<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 
class AWEA_Widget_Loader {

    public function __construct() {
        if (did_action('elementor/loaded') && $this->are_widgets_enabled()) {
            add_action('elementor/widgets/register', [$this, 'register_widgets']);
            add_action('elementor/elements/categories_registered', [$this, 'add_elementor_category']);
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_widget_assets']);
        }
    }

    public function are_widgets_enabled() {
        $options = get_option('awea_widgets_enabled');
        return !empty($options);
    }

    public function register_widgets($widgets_manager) {
        $enabled_widgets = get_option('awea_widgets_enabled', []);

        // Scan all folders inside /widgets/
        $widget_dirs = glob(AWEA_PATH . 'widgets/*', GLOB_ONLYDIR);

        foreach ($widget_dirs as $dir_path) {
            $folder_name = basename($dir_path); // e.g. awesome-cta
            $file_path = $dir_path . '/' . $folder_name . '.php'; // widgets/awesome-cta/awesome-cta.php

            if (file_exists($file_path) && isset($enabled_widgets[$folder_name]) && $enabled_widgets[$folder_name] == 1) {
                require_once $file_path;

                // Create class name: Widget_Awesome_Cta
                $class_name = 'Elementor\\Widget_' . str_replace('-', '_', ucwords($folder_name, '-'));

                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            }
        }
    }

    public function enqueue_widget_assets() {
        $enabled_widgets = get_option('awea_widgets_enabled', []);
        $widget_dirs = glob(AWEA_PATH . 'widgets/*', GLOB_ONLYDIR);

        foreach ($widget_dirs as $dir_path) {
            $folder_name = basename($dir_path);

            if (empty($enabled_widgets[$folder_name]) || $enabled_widgets[$folder_name] != 1) {
                continue; // skip if widget not enabled
            }

            $style_path = $dir_path . '/' . $folder_name . '.css';
            $script_path = $dir_path . '/' . $folder_name . '.js';

            if (file_exists($style_path)) {
                wp_enqueue_style(
                    "awea-widget-{$folder_name}",
                    AWEA_URL . "widgets/{$folder_name}/{$folder_name}.css",
                    [],
                    AWEA_VERSION
                );
            }

            if (file_exists($script_path)) {
                wp_enqueue_script(
                    "awea-widget-{$folder_name}",
                    AWEA_URL . "widgets/{$folder_name}/{$folder_name}.js",
                    ['jquery'],
                    AWEA_VERSION,
                    true
                );
            }
        }
    }

    public function add_elementor_category($elements_manager) {
        $elements_manager->add_category(
            'awesome-widgets-elementor',
            [
                'title' => esc_html__('Awesome Widgets', 'awesome-widgets-elementor'),
            ],
            1
        );
    }
}
