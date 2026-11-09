<?php
/**
 * Awesome Price Studio Widget.
 * Modern Architectural Pricing Table with Featured Ribbon & Dynamic Tags.
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
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_Price extends Widget_Base {

    public function get_name() {
        return 'awesome-price';
    }

    public function get_title() {
        return esc_html__( 'Price Table', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'price', 'pricing', 'table', 'plan', 'tier', 'subscription', 'badge' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PLAN HEADER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_price_header',
            [
                'label' => esc_html__( 'Plan Header', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_price_title',
            [
                'label'       => esc_html__( 'Plan Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_is_featured',
            [
                'label'        => esc_html__( 'Featured / Highlighted Plan', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'awea_featured_badge_text',
            [
                'label'       => esc_html__( 'Ribbon Badge Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PRICING VALUES
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_price_amounts',
            [
                'label' => esc_html__( 'Pricing Values', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_currency',
            [
                'label'   => esc_html__( 'Currency Symbol', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '$',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_price',
            [
                'label'   => esc_html__( 'Price Amount', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '79',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_period',
            [
                'label'   => esc_html__( 'Billing Period', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'mo',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: FEATURES LIST
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_price_features',
            [
                'label' => esc_html__( 'Features Checklist', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_feature_text',
            [
                'label'       => esc_html__( 'Feature Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Unlimited Neural Projects', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_feature_icon',
            [
                'label'   => esc_html__( 'Feature Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_feature_active',
            [
                'label'        => esc_html__( 'Included / Active', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_features_list',
            [
                'label'       => esc_html__( 'Features', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'awea_feature_text' => esc_html__( 'Unlimited Neural Projects', 'awesome-widgets-elementor' ), 'awea_feature_active' => 'yes' ],
                    [ 'awea_feature_text' => esc_html__( 'Ultra-Low Latency API Access', 'awesome-widgets-elementor' ), 'awea_feature_active' => 'yes' ],
                    [ 'awea_feature_text' => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ), 'awea_feature_active' => 'yes' ],
                    [ 'awea_feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ), 'awea_feature_active' => 'yes' ],
                ],
                'title_field' => '{{{ awea_feature_text }}}',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: ACTION BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_price_button',
            [
                'label' => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_btn_text',
            [
                'label'       => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_btn_link',
            [
                'label'       => esc_html__( 'Destination URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'default'     => [ 'url' => '#' ],
                'placeholder' => 'https://example.com/checkout',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD SHELL
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-pricing-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-card',
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
                    '{{WRAPPER}} .awea-pricing-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
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
                    '{{WRAPPER}} .awea-pricing-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-card:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Featured Plan Shell Overrides
        $this->add_control(
            'awea_heading_featured_style',
            [
                'label'     => esc_html__( 'Featured Plan Shell Overrides', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_featured_card_border_color',
            [
                'label'     => esc_html__( 'Active Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-card.awea-is-featured' => 'border-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'awea_featured_card_shadow',
                'label'     => esc_html__( 'Active Box Shadow', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awea-pricing-card.awea-is-featured',
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: HEADER & PLAN TITLE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_header',
            [
                'label' => esc_html__( 'Header & Plan Title', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_header_color',
            [
                'label'     => esc_html__( 'Title Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-plan-tag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_header_bg',
            [
                'label'     => esc_html__( 'Title Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-plan-tag' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_header_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-plan-tag',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_header_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Header Block', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-card-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Ribbon Badge Style Subgroup
        $this->add_control(
            'awea_heading_ribbon_style',
            [
                'label'     => esc_html__( 'Featured Ribbon Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_ribbon_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-ribbon' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_ribbon_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-ribbon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'awea_ribbon_typo',
                'label'     => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awea-pricing-ribbon',
                'global'    => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'condition' => [ 'awea_is_featured' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: PRICING NUMBERS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_pricing',
            [
                'label' => esc_html__( 'Pricing Numbers', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Currency Symbol Subgroup
        $this->add_control(
            'awea_heading_currency',
            [
                'label' => esc_html__( 'Currency Symbol', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_currency_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_currency_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-currency',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Price Amount Subgroup
        $this->add_control(
            'awea_heading_amount',
            [
                'label'     => esc_html__( 'Price Amount', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_price_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_price_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-amount',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        // Billing Period Subgroup
        $this->add_control(
            'awea_heading_period',
            [
                'label'     => esc_html__( 'Billing Period', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_period_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-cycle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_period_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-cycle',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: FEATURES LIST
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_features',
            [
                'label' => esc_html__( 'Features Checklist', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_feature_icon_color',
            [
                'label'     => esc_html__( 'Check Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-feature-item i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-pricing-feature-item svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_feature_text_color',
            [
                'label'     => esc_html__( 'Feature Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-feature-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_feature_disabled_color',
            [
                'label'     => esc_html__( 'Excluded Feature Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-feature-item.is-disabled' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_feature_text_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-feature-item',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_feature_spacing',
            [
                'label'      => esc_html__( 'Space Between Features', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 6, 'max' => 28 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-feature-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_features_bottom_spacing',
            [
                'label'      => esc_html__( 'Space Above Button', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 16, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 32 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-feature-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ACTION BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_button',
            [
                'label' => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_btn_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_btn_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
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
                    '{{WRAPPER}} .awea-pricing-btn-cta:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-pricing-btn-cta:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-btn-cta:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_btn_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-pricing-btn-cta:hover',
            ]
        );

        $this->end_controls_tab();$this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings    = $this->get_settings_for_display();$title       = $settings['awea_price_title'] ?? '';$is_featured = 'yes' === ( $settings['awea_is_featured'] ?? 'no' );$badge_text  = $settings['awea_featured_badge_text'] ?? '';$currency    = $settings['awea_currency'] ?? '$';
        $price       =$settings['awea_price'] ?? '79';
        $period      =$settings['awea_period'] ?? 'mo';
        $features    =$settings['awea_features_list'] ?? [];
        $btn_text    =$settings['awea_btn_text'] ?? '';

        if ( ! empty( $settings['awea_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'awea_pricing_link',$settings['awea_btn_link'] );
        }
        $this->add_render_attribute( 'awea_pricing_link', 'class', 'awea-pricing-btn-cta' );

        $card_classes = [ 'awea-pricing-card' ];
        if ( $is_featured ) {$card_classes[] = 'awea-is-featured';
        }
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
            
            <?php if ( $is_featured && ! empty( $badge_text ) ) : ?>
                <div class="awea-pricing-ribbon" aria-hidden="true">
                    <span><?php echo esc_html( $badge_text ); ?></span>
                </div>
            <?php endif; ?>

            <!-- Header & Pricing Block -->
            <div class="awea-pricing-card-header">
                <?php if ( ! empty( $title ) ) : ?>
                    <span class="awea-pricing-plan-tag"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>

                <div class="awea-pricing-price-box">
                    <?php if ( ! empty( $currency ) ) : ?>
                        <span class="awea-pricing-currency"><?php echo esc_html( $currency ); ?></span>
                    <?php endif; ?>

                    <?php if ( ! empty( $price ) ) : ?>
                        <span class="awea-pricing-amount"><?php echo esc_html( $price ); ?></span>
                    <?php endif; ?>

                    <?php if ( ! empty( $period ) ) : ?>
                        <span class="awea-pricing-cycle">/<?php echo esc_html( ltrim( $period, '/' ) ); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Body Features & CTA -->
            <div class="awea-pricing-card-body">
                <?php if ( ! empty( $features ) ) : ?>
                    <ul class="awea-pricing-feature-list" role="list">
                        <?php foreach ( $features as$feature ) : 
                            $f_text   =$feature['awea_feature_text'] ?? '';
                            $f_active = 'yes' === ($feature['awea_feature_active'] ?? 'yes' );
                            if ( empty( $f_text ) ) continue;
                        ?>
                            <li class="awea-pricing-feature-item <?php echo $f_active ? '' : 'is-disabled'; ?>">
                                <span class="awea-feature-icon" aria-hidden="true">
                                    <?php 
                                    if ( ! empty( $feature['awea_feature_icon']['value'] ) ) {
                                        Icons_Manager::render_icon( $feature['awea_feature_icon'], [ 'aria-hidden' => 'true' ] );
                                    } else {
                                        echo '<i class="fas fa-check" aria-hidden="true"></i>';
                                    }
                                    ?>
                                </span>
                                <span class="awea-feature-text"><?php echo esc_html( $f_text ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( ! empty( $btn_text ) ) : ?>
                    <div class="awea-pricing-btn-wrap">
                        <a <?php echo $this->get_render_attribute_string( 'awea_pricing_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <?php
    }
}