<?php
/**
 * Awesome List Group Studio Widget.
 * Modern Architectural Directory with Dynamic Icon Squircles & Kinetic Hover Physics.
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

class Widget_Awesome_List_Group extends Widget_Base {

    public function get_name() {
        return 'awesome-list-group';
    }

    public function get_title() {
        return esc_html__( 'List Group', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'list', 'group', 'features', 'checklist', 'directory', 'icon list' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: LIST ITEMS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_list_content',
            [
                'label' => esc_html__( 'List Items', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_layout_mode',
            [
                'label'   => esc_html__( 'Layout Presentation', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'connected',
                'options' => [
                    'connected' => esc_html__( 'Connected Feed Card', 'awesome-widgets-elementor' ),
                    'separated' => esc_html__( 'Independent Floating Tiles', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_item_icon',
            [
                'label'   => esc_html__( 'Item Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_item_title',
            [
                'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'High-Throughput Architecture', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_content',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => esc_html__( 'Engineered for sub-millisecond responses and high concurrency with zero runtime overhead.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'awea_item_link',
            [
                'label'       => esc_html__( 'Link URL (Optional)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'https://example.com',
            ]
        );

        $this->add_control(
            'awea_list_items',
            [
                'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'awea_item_title'   => esc_html__( 'Sourced from Certified Partners', 'awesome-widgets-elementor' ),
                        'awea_item_content' => esc_html__( 'Direct procurement from verified sustainable farms and ethical suppliers globally.', 'awesome-widgets-elementor' ),
                        'awea_item_icon'    => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
                    ],
                    [
                        'awea_item_title'   => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ),
                        'awea_item_content' => esc_html__( 'Continuous metric reporting and end-to-end milestone notifications at every step.', 'awesome-widgets-elementor' ),
                        'awea_item_icon'    => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
                    ],
                    [
                        'awea_item_title'   => esc_html__( 'Automated Compliance Engine', 'awesome-widgets-elementor' ),
                        'awea_item_content' => esc_html__( 'Zero-friction validation against industry standards with encrypted record persistence.', 'awesome-widgets-elementor' ),
                        'awea_item_icon'    => [ 'value' => 'fas fa-microchip', 'library' => 'fa-solid' ],
                    ],
                ],
                'title_field' => '{{{ awea_item_title }}}',
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
           TAB: STYLE -> SECTION: CONTAINER / SHELL
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
                'label'      => esc_html__( 'Container Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->add_responsive_control(
            'awea_container_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->add_control(
            'awea_container_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-card' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'awea_container_border',
                'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awea-icon-list-card',
                'condition' => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'awea_container_shadow',
                'label'     => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awea-icon-list-card',
                'condition' => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: LIST ITEM TILES
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_items',
            [
                'label' => esc_html__( 'Item Rows & Tiles', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_item_spacing',
            [
                'label'      => esc_html__( 'Gap Between Items', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 16 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_item_padding',
            [
                'label'      => esc_html__( 'Item Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '24', 'bottom' => '20', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_item_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_item_state_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_item_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_item_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_item_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_item_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-item',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_item_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_item_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f8fafc',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_item_border_hover_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_item_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-item:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Divider for Connected Mode
        $this->add_control(
            'awea_heading_divider_style',
            [
                'label'     => esc_html__( 'Inner Row Dividers', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->add_control(
            'awea_divider_color',
            [
                'label'     => esc_html__( 'Divider Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.06)',
                'selectors' => [
                    '{{WRAPPER}}.awea-mode-connected .awea-icon-list-item:not(:last-child)' => 'border-bottom: 1px solid {{VALUE}};',
                ],
                'condition' => [ 'awea_layout_mode' => 'connected' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ICON SQUIRCLE BADGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_icon',
            [
                'label' => esc_html__( 'Icon Squircle Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_icon_badge_size',
            [
                'label'      => esc_html__( 'Badge Dimension', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 36, 'max' => 90 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 56 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_glyph_size',
            [
                'label'      => esc_html__( 'Icon Glyph Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-icon-wrap i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-icon-list-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_badge_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_icon_badge_tabs' );

        // Normal Icon
        $this->start_controls_tab(
            'awea_icon_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-icon-wrap'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-icon-list-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_icon_badge_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-icon-wrap',
            ]
        );

        $this->end_controls_tab();

        // Hover Icon (Zero Hover Rotation / Scale)
        $this->start_controls_tab(
            'awea_icon_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_color_hover',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-icon-wrap'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_hover',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-icon-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY & TEXT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typography',
            [
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Title
        $this->add_control(
            'awea_heading_title_style',
            [
                'label' => esc_html__( 'Item Title', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs( 'awea_title_color_tabs' );

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
                    '{{WRAPPER}} .awea-icon-list-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-title',
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
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 6 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-list-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Description
        $this->add_control(
            'awea_heading_desc_style',
            [
                'label'     => esc_html__( 'Item Description', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_desc_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-list-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Link Arrow Indicator
        $this->add_control(
            'awea_heading_arrow_style',
            [
                'label'     => esc_html__( 'Link Arrow Indicator', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_arrow_color',
            [
                'label'     => esc_html__( 'Normal Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_arrow_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $layout_mode  = $settings['awea_layout_mode'] ?? 'connected';
        $items        = $settings['awea_list_items'] ?? [];
        $title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );

        if ( empty( $items ) ) {
            return;
        }

        $container_classes = [ 'awea-icon-list-card', 'awea-mode-' . $layout_mode ];
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
            <?php foreach ( $items as $index => $item ) : 
                $title    = $item['awea_item_title'] ?? '';
                $desc     = $item['awea_item_content'] ?? '';
                $has_url  = ! empty( $item['awea_item_link']['url'] );
                $link_key = 'awea_item_link_' . $index;

                $tag = $has_url ? 'a' : 'article';

                if ( $has_url ) {
                    $this->add_link_attributes( $link_key, $item['awea_item_link'] );
                }
                $this->add_render_attribute( $link_key, 'class', 'awea-icon-list-item elementor-repeater-item-' . esc_attr( $item['_id'] ) );
            ?>
                <<?php echo tag_escape( $tag ); ?> <?php echo $this->get_render_attribute_string( $link_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                    
                    <!-- Precision Squircle Icon Badge -->
                    <?php if ( ! empty( $item['awea_item_icon']['value'] ) ) : ?>
                        <div class="awea-icon-list-icon-wrap" aria-hidden="true">
                            <?php Icons_Manager::render_icon( $item['awea_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Typography Body -->
                    <div class="awea-icon-list-text">
                        <?php if ( ! empty( $title ) ) : ?>
                            <<?php echo esc_attr( $title_tag ); ?> class="awea-icon-list-title">
                                <?php echo esc_html( $title ); ?>
                            </<?php echo esc_attr( $title_tag ); ?>>
                        <?php endif; ?>

                        <?php if ( ! empty( $desc ) ) : ?>
                            <p class="awea-icon-list-desc">
                                <?php echo esc_html( $desc ); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if ( $has_url ) : ?>
                        <div class="awea-icon-list-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    <?php endif; ?>

                </<?php echo tag_escape( $tag ); ?>>
            <?php endforeach; ?>
        </div>
        <?php
    }
}