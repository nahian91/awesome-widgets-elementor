<?php
/**
 * Awesome Widgets Icon Trait.
 * Provides unique SVG icon mappings for all 40 widgets in the suite.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.7.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

trait AWEA_Icon_Trait {

    /**
     * Return a unique SVG icon per widget slug.
     *
     * @return string HTML/SVG markup for the Elementor panel.
     */
    public function get_icon() {
        $slug = $this->get_name();
        
        // Define unique vector icon paths for all 40 widgets
        $icons = array(
            // 1. Creative & Content Studio
            'awesome-cta'                       => '<polygon points="5 3 19 12 5 21 5 3"></polygon>',
            'awesome-heading'                   => '<path d="M4 12h16M4 6h16M4 18h10"></path>',
            'awesome-image-box'                 => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>',
            'awesome-list-group'                => '<line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>',
            'awesome-number-box'                => '<path d="M4 19h16M4 15h16M6 9l6-6 6 6M12 3v12"></path>',
            'awesome-price'                     => '<line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>',
            'awesome-testimonials'              => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>',
            'awesome-contact-info'              => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
            'awesome-team'                      => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
            'awesome-business-hours'            => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
            'awesome-icon-box'                  => '<path d="M12 2l10 6.5v7L12 22 2 15.5v-7L12 2z"></path>',
            'awesome-price-menu'                => '<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line>',
            'awesome-timeline'                  => '<circle cx="12" cy="12" r="3"></circle><line x1="12" y1="2" x2="12" y2="9"></line><line x1="12" y1="15" x2="12" y2="22"></line>',
            'awesome-countdown'                 => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 15 15"></polyline>',
            'awesome-counter'                   => '<path d="M10 2h4M12 2v20M8 22h8"></path>',
            'awesome-accordion'                 => '<polyline points="6 9 12 15 18 9"></polyline>',
            'awesome-about'                     => '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>',
            'awesome-step-flow'                 => '<line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline>',
            'awesome-progress-bar'              => '<line x1="3" y1="12" x2="21" y2="12"></line><polyline points="15 6 21 12 15 18"></polyline>',

            // 2. eCommerce Studio
            'awesome-product-category-grid'     => '<rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>',
            'awesome-product-grid'              => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line>',
            'awesome-product-list'              => '<line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>',
            'awesome-product-carousel'          => '<path d="M2 16l4-4 4 4"></path><path d="M14 16l4-4 4 4"></path><line x1="6" y1="12" x2="6" y2="20"></line><line x1="18" y1="12" x2="18" y2="20"></line>',
            'awesome-product-category-carousel' => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 3l-4 4-4-4"></path>',
            'awesome-cart'                      => '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path>',
            'awesome-checkout'                  => '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line>',
            'awesome-account'                   => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',
            'awesome-shop'                      => '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path>',

            // 3. Media & Sliders Studio
            'awesome-filter-gallery'            => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>',
            'awesome-slider'                    => '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line>',
            'awesome-post-carousel'             => '<path d="M2 12h20M2 6h20M2 18h20"></path>',
            'awesome-team-carousel'             => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>',
            'awesome-testimonials-carousel'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>',

            // 4. Dynamic & Feed Studio
            'awesome-post-grid'                 => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line>',
            'awesome-breadcumb'                 => '<polyline points="9 18 15 12 9 6"></polyline>',

            // 5. Header & Footer Modules
            'awesome-site-logo'                 => '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
            'awesome-nav-menu'                  => '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>',
            'awesome-social-icons'              => '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>',
            'awesome-contact-bar'               => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>',
            'awesome-copyright'                 => '<circle cx="12" cy="12" r="10"></circle><path d="M14.8 14.8A4 4 0 1 1 16 10"></path>',
        );

        // Fallback icon if slug isn't explicitly defined
        $path = $icons[ $slug ] ?? '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>';

        return sprintf(
            '<svg class="awe-panel-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">%s</svg>',
            $path
        );
    }
}