<?php
/**
 * Awesome Product List Studio Widget.
 * Architectural WooCommerce Vertical Product List with Advanced Sorting & Global Kits.
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

class Widget_Awesome_Product_List extends Widget_Base {

    public function get_name() {
        return 'awesome-product-list';
    }

    public function get_title() {
        return esc_html__( 'Product List', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-price-list';
    }

    public function get_categories() {
        return [ 'awesome-woo' ];
    }

    public function get_keywords() {
        return [ 'awea', 'woocommerce', 'product list', 'vertical list', 'catalog', 'store' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: SECTION HEADER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_list_header',
            [
                'label' => esc_html__( 'Section Header', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_section_title',
            [
                'label'       => esc_html__( 'Header Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Featured Products', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
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
            ]
        );

        $this->add_responsive_control(
            'awea_title_align',
            [
                'label'     => esc_html__( 'Header Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-header' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PRODUCT QUERY & SORTING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_list_query',
            [
                'label' => esc_html__( 'Product Query', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_product_count',
            [
                'label'   => esc_html__( 'Number of Products', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 5,
                'min'     => 1,
                'max'     => 50,
            ]
        );

        $this->add_control(
            'awea_product_orderby',
            [
                'label'   => esc_html__( 'Sort Products By', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'latest',
                'options' => [
                    'latest'        => esc_html__( 'Latest Products', 'awesome-widgets-elementor' ),
                    'top_rated'     => esc_html__( 'Top Selling (Total Sales)', 'awesome-widgets-elementor' ),
                    'random'        => esc_html__( 'Random Order', 'awesome-widgets-elementor' ),
                    'featured'      => esc_html__( 'Featured Products Only', 'awesome-widgets-elementor' ),
                    'price_low'     => esc_html__( 'Price: Low to High', 'awesome-widgets-elementor' ),
                    'price_high'    => esc_html__( 'Price: High to Low', 'awesome-widgets-elementor' ),
                    'most_reviewed' => esc_html__( 'Most Reviewed', 'awesome-widgets-elementor' ),
                    'on_sale'       => esc_html__( 'On Sale Products', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_show_action_button',
            [
                'label'        => esc_html__( 'Show Cart Button', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CONTAINER SHELL
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_container',
            [
                'label' => esc_html__( 'Container Shell', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_container_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_container_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_container_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_container_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-list-wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_container_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-list-wrap',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: THUMBNAIL IMAGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_image',
            [
                'label' => esc_html__( 'Thumbnail Image', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_thumb_size',
            [
                'label'      => esc_html__( 'Thumbnail Dimensions', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 50, 'max' => 160 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 84 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_thumb_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_thumb_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-list-thumb',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY & PRICING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typography',
            [
                'label' => esc_html__( 'Typography & Pricing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Section Header Title
        $this->add_control(
            'awea_heading_sec_title',
            [
                'label' => esc_html__( 'Section Header Title', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_sec_title_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_sec_title_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-list-header',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_sec_title_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Header', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Product Item Title
        $this->add_control(
            'awea_heading_item_title',
            [
                'label'     => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'awea_item_title_tabs' );

        // Normal Title
        $this->start_controls_tab(
            'awea_item_title_tab_normal',
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
                    '{{WRAPPER}} .awea-product-list-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Title
        $this->start_controls_tab(
            'awea_item_title_tab_hover',
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
                    '{{WRAPPER}} .awea-product-list-title a:hover' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .awea-product-list-title a',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_title_space_below',
            [
                'label'      => esc_html__( 'Space Below Product Title', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 6 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Product Price
        $this->add_control(
            'awea_heading_item_price',
            [
                'label'     => esc_html__( 'Product Price', 'awesome-widgets-elementor' ),
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
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-price, {{WRAPPER}} .awea-product-list-price ins' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_sale_price_color',
            [
                'label'     => esc_html__( 'Original Price (Crossed Out)', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-price del' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_price_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-list-price',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Row Separators & Spacing
        $this->add_control(
            'awea_heading_row_spacing',
            [
                'label'     => esc_html__( 'Rows & Dividers', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_row_gap',
            [
                'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 16 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-list-row:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_divider_color',
            [
                'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.06)',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-list-row:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ACTION BUTTONS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_button',
            [
                'label'     => esc_html__( 'Action Buttons', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_action_button' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_btn_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-grid-btn',
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
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-grid-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f8fafc',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-grid-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-product-grid-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_btn_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-product-grid-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-grid-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-product-grid-btn:hover' => 'border-color: {{VALUE}};',
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
                'default'    => [ 'top' => '8', 'right' => '16', 'bottom' => '8', 'left' => '16', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-product-grid-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-product-grid-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product List Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
            return;
        }

        $settings    = $this->get_settings_for_display();
        $sec_title   = $settings['awea_section_title'] ?? '';
        $sec_tag     = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
        $count       = ! empty( $settings['awea_product_count'] ) ? absint( $settings['awea_product_count'] ) : 5;
        $orderby     = $settings['awea_product_orderby'] ?? 'latest';
        $show_action = ( 'yes' === ( $settings['awea_show_action_button'] ?? 'no' ) );

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => $count,
            'post_status'    => 'publish',
        ];

        switch ( $orderby ) {
            case 'top_rated':
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;
            case 'random':
                $args['orderby'] = 'rand';
                break;
            case 'featured':
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_visibility',
                        'field'    => 'slug',
                        'terms'    => [ 'featured' ],
                        'operator' => 'IN',
                    ],
                ];
                break;
            case 'price_low':
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'ASC';
                break;
            case 'price_high':
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;
            case 'most_reviewed':
                $args['orderby'] = 'comment_count';
                $args['order']   = 'DESC';
                break;
            case 'on_sale':
                $sale_ids = wc_get_product_ids_on_sale();
                $args['post__in'] = ! empty( $sale_ids ) ? $sale_ids : [ 0 ];
                break;
            case 'latest':
            default:
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
                break;
        }

        $query = new \WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return;
        }
        ?>
        <div class="awea-product-list-wrap">
            
            <?php if ( ! empty( $sec_title ) ) : ?>
                <<?php echo esc_attr( $sec_tag ); ?> class="awea-product-list-header">
                    <?php echo esc_html( $sec_title ); ?>
                </<?php echo esc_attr( $sec_tag ); ?>>
            <?php endif; ?>

            <div class="awea-product-list-items" role="list">
                <?php 
                while ( $query->have_posts() ) : $query->the_post();
                    $product = wc_get_product( get_the_ID() );
                    if ( ! $product ) {
                        continue;
                    }

                    $in_cart = false;
                    if ( WC()->cart ) {
                        foreach ( WC()->cart->get_cart() as $item ) {
                            if ( (int) $item['product_id'] === (int) get_the_ID() ) {
                                $in_cart = true;
                                break;
                            }
                        }
                    }
                ?>
                    <div class="awea-product-list-row <?php echo $in_cart ? 'product-in-cart' : ''; ?>" role="listitem">
                        
                        <!-- Thumbnail Image -->
                        <div class="awea-product-list-thumb">
                            <a href="<?php echo esc_url( get_the_permalink() ); ?>" aria-label="<?php the_title_attribute(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'woocommerce_thumbnail', [ 'loading' => 'lazy' ] ); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                <?php endif; ?>
                            </a>
                        </div>

                        <!-- Content & Price Details -->
                        <div class="awea-product-list-content">
                            <h4 class="awea-product-list-title">
                                <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
                            </h4>

                            <div class="awea-product-list-meta">
                                <span class="awea-product-list-price"><?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

                                <?php if ( $show_action ) : ?>
                                    <div class="awea-product-list-action">
                                        <?php if ( $in_cart ) : ?>
                                            <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" class="awea-product-grid-btn awea-view-cart">
                                                <?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID(), home_url() ) ); ?>"
                                               data-product_id="<?php echo esc_attr( (string) get_the_ID() ); ?>"
                                               data-quantity="1"
                                               class="awea-product-grid-btn awea-add-to-cart ajax_add_to_cart add_to_cart_button"
                                               rel="nofollow">
                                                <?php echo esc_html( $product->add_to_cart_text() ); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

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
                        $button.closest('.awea-product-list-row').addClass('product-in-cart');
                    }
                });
            });
        }
        </script>
        <?php
    }
}