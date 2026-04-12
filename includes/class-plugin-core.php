<?php

class AWEA {
    private static $_instance = null;

    private $widgets = [
        'awesome-cta',
        'awesome-heading',
        'awesome-image-box',
        'awesome-list-group',
        'awesome-number-box',
        'awesome-price',
        'awesome-testimonials',
        'awesome-contact-info',
        'awesome-team',
        'awesome-business-hours',
        'awesome-icon-box',
        'awesome-post-grid',
        'awesome-price-menu',
        'awesome-product-category-grid',
        'awesome-product-grid',
        'awesome-product-list',
        'awesome-timeline',
        'awesome-countdown',
        'awesome-counter',
        'awesome-accordion',
        'awesome-filter-gallery',
        'awesome-post-carousel',
        'awesome-product-carousel',
        'awesome-product-category-carousel',
        'awesome-team-carousel',
        'awesome-testimonials-carousel',
        'awesome-breadcumb',
        'awesome-slider',
        'awesome-about',
        'awesome-step-flow',
        'awesome-progress-bar',
    ];

    public static function instance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        require_once AWEA_PATH . 'includes/class-admin-pages.php';
        require_once AWEA_PATH . 'includes/class-widget-loader.php';
        require_once AWEA_PATH . 'includes/class-scripts.php';
        require_once AWEA_PATH . 'includes/class-settings.php';

        new AWEA_Admin_Pages($this->widgets);
        new AWEA_Widget_Loader($this->widgets);
        new AWEA_Scripts();
        new AWEA_Settings($this->widgets);
    }
}
