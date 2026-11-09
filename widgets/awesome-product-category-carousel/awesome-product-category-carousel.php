<?php
/**
 * Awesome Product Category Carousel Studio Widget.
 * Architectural WooCommerce Category Slider with Frosted Overlays & Global Kits.
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

class Widget_Awesome_Product_Category_Carousel extends Widget_Base {

    public function get_name() {
        return 'awesome-product-category-carousel';
    }

    public function get_title() {
        return esc_html__( 'Product Category Carousel', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-nested-carousel';
    }

    public function get_categories() {
        return [ 'awesome-woo' ];
    }

    public function get_keywords() {
        return [ 'awea', 'woocommerce', 'category', 'categories', 'carousel', 'slider', 'shop' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CATEGORY QUERY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_cat_query',
            [
                'label' => esc_html__( 'Category Query', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

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
            'awea_include_categories',
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
            'awea_hide_empty',
            [
                'label'        => esc_html__( 'Hide Empty Categories', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'awea_orderby',
            [
                'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name'  => esc_html__( 'Name', 'awesome-widgets-elementor' ),
                    'id'    => esc_html__( 'ID', 'awesome-widgets-elementor' ),
                    'count' => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
                    'rand'  => esc_html__( 'Random', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_order',
            [
                'label'   => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'  => esc_html__( 'Ascending (A-Z)', 'awesome-widgets-elementor' ),
                    'DESC' => esc_html__( 'Descending (Z-A)', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CAROUSEL SETTINGS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_cat_settings',
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
            'awea_show_count',
            [
                'label'        => esc_html__( 'Show Product Count', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
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

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD SHELL & RATIO
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_aspect_ratio',
            [
                'label'     => esc_html__( 'Card Aspect Ratio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '4/5',
                'options'   => [
                    '1/1'  => '1:1 Square',
                    '4/5'  => '4:5 Classic Portrait',
                    '3/4'  => '3:4 Editorial',
                    '16/9' => '16:9 Landscape',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_card_tabs' );

        // Normal Card
        $this->start_controls_tab(
            'awea_card_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-category',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-category',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No scale / No lift)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_border_hover_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-category:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: FROSTED GLASS OVERLAY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_content',
            [
                'label' => esc_html__( 'Frosted Info Dock', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_content_padding',
            [
                'label'      => esc_html__( 'Dock Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '14', 'right' => '18', 'bottom' => '14', 'left' => '18', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_content_radius',
            [
                'label'      => esc_html__( 'Dock Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-category-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_content_offset',
            [
                'label'      => esc_html__( 'Dock Inset Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 6, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-category-content' => 'left: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}}; bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_dock_tabs' );

        // Normal Dock
        $this->start_controls_tab(
            'awea_dock_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_content_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.78)',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_dock_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-category-content',
            ]
        );

        $this->end_controls_tab();

        // Hover Dock (No lift)
        $this->start_controls_tab(
            'awea_dock_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_content_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.90)',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category:hover .awea-product-category-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dock_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category:hover .awea-product-category-content' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typography',
            [
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Category Name
        $this->add_control(
            'awea_heading_cat_name',
            [
                'label' => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_category_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_category_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-category:hover .awea-product-category-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_category_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-category-link',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        // Product Count
        $this->add_control(
            'awea_heading_cat_count',
            [
                'label'     => esc_html__( 'Product Count Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_show_count' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_count_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-category-count' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_count' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'awea_count_typography',
                'label'     => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awea-category-count',
                'global'    => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'condition' => [ 'awea_show_count' => 'yes' ],
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
                    '{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-product-category-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Carousel Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
            return;
        }

        $settings   = $this->get_settings_for_display();
        $categories = $settings['awea_include_categories'] ?? [];
        $hide_empty = 'yes' === ( $settings['awea_hide_empty'] ?? 'no' );
        $show_count = 'yes' === ( $settings['awea_show_count'] ?? 'no' );

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
            'taxonomy'   => 'product_cat',
            'hide_empty' => $hide_empty,
            'orderby'    => $settings['awea_orderby'] ?? 'name',
            'order'      => $settings['awea_order'] ?? 'ASC',
        ];

        if ( ! empty( $categories ) && is_array( $categories ) ) {
            $args['include'] = array_map( 'absint', $categories );
        }

        $product_categories = get_terms( $args );

        if ( empty( $product_categories ) || is_wp_error( $product_categories ) ) {
            return;
        }
        ?>
        <div class="awea-product-category-carousel-wrap">
            <div class="awea-product-category-carousel owl-carousel"
                 id="awea-cat-carousel-<?php echo esc_attr( $widget_id ); ?>"
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

                <?php foreach ( $product_categories as $category ) :
                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    $image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
                ?>
                    <div class="awea-product-category-slide">
                        <article class="awea-product-category">
                            
                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-img-link" aria-label="<?php echo esc_attr( $category->name ); ?>">
                                <?php if ( ! empty( $image_url ) ) : ?>
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy" />
                                <?php endif; ?>
                            </a>

                            <div class="awea-product-category-content">
                                <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-link">
                                    <?php echo esc_html( $category->name ); ?>
                                </a>
                                <?php if ( $show_count ) : ?>
                                    <span class="awea-category-count">(<?php echo esc_html( (string) $category->count ); ?>)</span>
                                <?php endif; ?>
                            </div>

                        </article>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <?php
    }
}