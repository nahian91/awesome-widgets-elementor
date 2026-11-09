<?php
/**
 * Awesome Product Carousel Studio Widget.
 * Architectural WooCommerce Product Slider with Live Cart Status & Global Kits.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_Carousel extends Widget_Base {

    public function get_name() {
        return 'awesome-product-carousel';
    }

    public function get_title() {
        return esc_html__( 'Product Carousel', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-carousel-loop';
    }

    public function get_categories() {
        return [ 'awesome-woo' ];
    }

    public function get_keywords() {
        return [ 'awea', 'woocommerce', 'product', 'carousel', 'slider', 'shop', 'store' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PRODUCT QUERY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_query',
            [
                'label' => esc_html__( 'Product Query', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_post_count',
            [
                'label'   => esc_html__( 'Number of Products', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 8,
                'min'     => 1,
                'max'     => 50,
            ]
        );

        // Category Options Dropdown
        $cat_options = [];
        if ( class_exists( 'WooCommerce' ) ) {
            $categories = get_terms( [
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            ] );
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                foreach ( $categories as $cat ) {
                    $cat_options[ $cat->term_id ] = $cat->name;
                }
            }
        }

        $this->add_control(
            'awea_product_categories',
            [
                'label'       => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $cat_options,
                'description' => esc_html__( 'Leave empty to display all categories.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_orderby',
            [
                'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__( 'Date', 'awesome-widgets-elementor' ),
                    'title'      => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                    'price'      => esc_html__( 'Price', 'awesome-widgets-elementor' ),
                    'popularity' => esc_html__( 'Popularity (Sales)', 'awesome-widgets-elementor' ),
                    'rating'     => esc_html__( 'Average Rating', 'awesome-widgets-elementor' ),
                    'rand'       => esc_html__( 'Random', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_order',
            [
                'label'   => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC'  => esc_html__( 'Ascending (A-Z / Low to High)', 'awesome-widgets-elementor' ),
                    'DESC' => esc_html__( 'Descending (Z-A / High to Low)', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CAROUSEL SETTINGS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'awea_slides_per_view',
            [
                'label'          => esc_html__( 'Slides Per View', 'awesome-widgets-elementor' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => [
                    '1' => '1 Item',
                    '2' => '2 Items',
                    '3' => '3 Items',
                    '4' => '4 Items',
                    '5' => '5 Items',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_slide_gap',
            [
                'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
            ]
        );

        $this->add_control(
            'awea_carousel_arrows',
            [
                'label'        => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_carousel_dots',
            [
                'label'        => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_carousel_loop',
            [
                'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_carousel_autoplay',
            [
                'label'        => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_carousel_pause',
            [
                'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [ 'awea_carousel_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_carousel_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'min'       => 1000,
                'max'       => 15000,
                'step'      => 500,
                'condition' => [ 'awea_carousel_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_carousel_transition_speed',
            [
                'label'   => esc_html__( 'Transition Speed (ms)', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 450,
                'min'     => 100,
                'max'     => 2000,
                'step'    => 50,
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h3',
                'options'   => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD SHELL & LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Product Card Shell', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_card_state_tabs' );

        // Normal Card
        $this->start_controls_tab(
            'awea_card_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-card',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No scale / No transform lift)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_card_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-card:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: PRODUCT PHOTO & SALE BADGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_photo',
            [
                'label' => esc_html__( 'Photo & Sale Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_image_aspect_ratio',
            [
                'label'     => esc_html__( 'Photo Aspect Ratio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1/1',
                'options'   => [
                    '1/1'  => '1:1 Square',
                    '4/5'  => '4:5 Portrait',
                    '3/4'  => '3:4 Editorial',
                    '16/9' => '16:9 Landscape',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-img-wrap' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_image_radius',
            [
                'label'      => esc_html__( 'Photo Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Sale Badge Subgroup
        $this->add_control(
            'awea_heading_sale',
            [
                'label'     => esc_html__( 'Sale Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_sale_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-sale-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_sale_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-sale-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_sale_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-sale-badge',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY & PRICING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typo',
            [
                'label' => esc_html__( 'Typography & Pricing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Product Title
        $this->add_control(
            'awea_heading_title',
            [
                'label' => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs( 'awea_title_tabs' );

        // Normal Title
        $this->start_controls_tab(
            'awea_title_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Title
        $this->start_controls_tab(
            'awea_title_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_title_hover_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-title a',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_title_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Title', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Price
        $this->add_control(
            'awea_heading_price',
            [
                'label'     => esc_html__( 'Price Display', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_price_color',
            [
                'label'     => esc_html__( 'Price Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-price, {{WRAPPER}} .awea-product-price ins' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_old_price_color',
            [
                'label'     => esc_html__( 'Original Price (Crossed Out)', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-price del' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_price_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-price',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ADD TO CART BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_button',
            [
                'label' => esc_html__( 'Add to Cart Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_btn_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-cart-btn',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_btn_state_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_btn_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-cart-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-cart-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-cart-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_btn_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_btn_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-cart-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-cart-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-product-cart-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'awea_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_btn_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-cart-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: NAVIGATION ARROWS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_arrows',
            [
                'label'     => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_carousel_arrows' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_arrow_size',
            [
                'label'      => esc_html__( 'Button Box Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 44 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_arrow_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-carousel-arrow-border i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_arrow_tabs' );

        // Normal Arrow
        $this->start_controls_tab(
            'awea_arrow_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_arrow_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_arrow_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_arrow_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-carousel-arrow-border',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_arrow_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-carousel-arrow-border',
            ]
        );

        $this->end_controls_tab();

        // Hover Arrow (Zero Zoom/Scale)
        $this->start_controls_tab(
            'awea_arrow_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_arrow_color_hover',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-carousel-arrow-border:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_arrow_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_arrow_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-carousel-arrow-border:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: PAGINATION DOTS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_dots',
            [
                'label'     => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_carousel_dots' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_dots_size',
            [
                'label'      => esc_html__( 'Dot Diameter', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 6, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-carousel .owl-dots button.owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_dots_gap',
            [
                'label'      => esc_html__( 'Space Between Dots', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 2, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 6 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-carousel .owl-dots button.owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_dots_margin_top',
            [
                'label'      => esc_html__( 'Top Margin', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 28 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dots_color',
            [
                'label'     => esc_html__( 'Inactive Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#cbd5e1',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dots_active_color',
            [
                'label'     => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Carousel Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
            return;
        }

        $settings     = $this->get_settings_for_display();
        $num_products = ! empty( $settings['awea_post_count'] ) ? absint( $settings['awea_post_count'] ) : 8;
        $order        = $settings['awea_order'] ?? 'DESC';
        $orderby      = $settings['awea_orderby'] ?? 'date';
        $categories   = $settings['awea_product_categories'] ?? [];
        $title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );

        $items_desktop = ! empty( $settings['awea_slides_per_view'] ) ? (int) $settings['awea_slides_per_view'] : 3;
        $items_tablet  = ! empty( $settings['awea_slides_per_view_tablet'] ) ? (int) $settings['awea_slides_per_view_tablet'] : 2;
        $items_mobile  = ! empty( $settings['awea_slides_per_view_mobile'] ) ? (int) $settings['awea_slides_per_view_mobile'] : 1;

        $gap_desktop   = isset( $settings['awea_slide_gap']['size'] ) ? (int) $settings['awea_slide_gap']['size'] : 24;
        $gap_tablet    = isset( $settings['awea_slide_gap_tablet']['size'] ) ? (int) $settings['awea_slide_gap_tablet']['size'] : 20;
        $gap_mobile    = isset( $settings['awea_slide_gap_mobile']['size'] ) ? (int) $settings['awea_slide_gap_mobile']['size'] : 16;

        $arrows     = ( 'yes' === ( $settings['awea_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
        $dots       = ( 'yes' === ( $settings['awea_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
        $loop       = ( 'yes' === ( $settings['awea_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
        $autoplay   = ( 'yes' === ( $settings['awea_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
        $pause      = ( 'yes' === ( $settings['awea_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
        $auto_speed = ! empty( $settings['awea_carousel_autoplay_speed'] ) ? absint( $settings['awea_carousel_autoplay_speed'] ) : 5000;
        $anim_speed = ! empty( $settings['awea_carousel_transition_speed'] ) ? absint( $settings['awea_carousel_transition_speed'] ) : 450;
        $widget_id  = $this->get_id();

        $args = [
            'posts_per_page'      => $num_products,
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'order'               => $order,
            'orderby'             => $orderby,
            'ignore_sticky_posts' => 1,
        ];

        if ( ! empty( $categories ) && is_array( $categories ) ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => array_map( 'absint', $categories ),
                ],
            ];
        }

        $query = new \WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return;
        }
        ?>
        <div class="awea-product-carousel-wrap">
            <div class="awea-product-carousel owl-carousel"
                 id="awea-prod-carousel-<?php echo esc_attr( $widget_id ); ?>"
                 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
                 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
                 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
                 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
                 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
                 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
                 data-arrows="<?php echo esc_attr( $arrows ); ?>"
                 data-dots="<?php echo esc_attr( $dots ); ?>"
                 data-loop="<?php echo esc_attr( $loop ); ?>"
                 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
                 data-pause="<?php echo esc_attr( $pause ); ?>"
                 data-speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
                 data-timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

                <?php 
                while ( $query->have_posts() ) : $query->the_post();
                    $product = wc_get_product( get_the_ID() );
                    if ( ! $product ) {
                        continue;
                    }
                    $is_on_sale = $product->is_on_sale();

                    $in_cart = false;
                    if ( WC()->cart ) {
                        foreach ( WC()->cart->get_cart() as $cart_item ) {
                            if ( (int) $cart_item['product_id'] === (int) get_the_ID() ) {
                                $in_cart = true;
                                break;
                            }
                        }
                    }
                ?>
                    <div class="awea-product-slide">
                        <article class="awea-product-card <?php echo $in_cart ? 'product-in-cart' : ''; ?>">
                            
                            <!-- Image Frame & Sale Badge -->
                            <div class="awea-product-img-wrap">
                                <?php if ( $is_on_sale ) : ?>
                                    <span class="awea-product-sale-badge"><?php esc_html_e( 'Sale', 'awesome-widgets-elementor' ); ?></span>
                                <?php endif; ?>

                                <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-product-img-link" aria-label="<?php the_title_attribute(); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'woocommerce_thumbnail', [ 'class' => 'awea-product-img', 'loading' => 'lazy' ] ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea-product-img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    <?php endif; ?>
                                </a>
                            </div>

                            <!-- Body Content -->
                            <div class="awea-product-body">
                                <<?php echo esc_attr( $title_tag ); ?> class="awea-product-title">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
                                </<?php echo esc_attr( $title_tag ); ?>>

                                <div class="awea-product-price">
                                    <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            </div>

                            <!-- Footer Cart Button -->
                            <div class="awea-product-footer">
                                <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" 
                                   class="awea-product-cart-btn awea-view-cart-btn"
                                   aria-label="<?php esc_attr_e( 'View Cart', 'awesome-widgets-elementor' ); ?>">
                                    <i class="fas fa-check" aria-hidden="true"></i>
                                    <span><?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
                                </a>

                                <a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID(), home_url() ) ); ?>" 
                                   class="awea-product-cart-btn awea-add-to-cart-btn ajax_add_to_cart add_to_cart_button" 
                                   data-product_id="<?php echo esc_attr( (string) $product->get_id() ); ?>" 
                                   data-quantity="1" 
                                   aria-label="<?php esc_attr_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?>"
                                   rel="nofollow">
                                    <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                                    <span><?php echo esc_html( $product->add_to_cart_text() ); ?></span>
                                </a>
                            </div>

                        </article>
                    </div>
                <?php 
                endwhile;
                wp_reset_postdata();
                ?>

            </div>
        </div>

        <!-- Scoped AJAX Cart Sync Script -->
        <script>
        if (typeof jQuery !== 'undefined') {
            jQuery(function($) {
                $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
                    if ($button && $button.length) {
                        $button.closest('.awea-product-card').addClass('product-in-cart');
                    }
                });
            });
        }
        </script>
        <?php
    }
}