<?php
/**
 * Awesome Timeline Widget.
 * Modern Kinetic Architecture with Progressive Scroll Animations.
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

class Widget_Awesome_Timeline extends Widget_Base {

    public function get_name() {
        return 'awesome-timeline';
    }

    public function get_title() {
        return esc_html__( 'Timeline', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'timeline', 'roadmap', 'history', 'steps', 'process', 'kinetic' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: MILESTONES
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_timeline_content',
            [
                'label' => esc_html__( 'Timeline Milestones', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_item_badge',
            [
                'label'       => esc_html__( 'Step / Date Tag', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Phase 01',
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_title',
            [
                'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Discovery & Deep Audit',
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_desc',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => 'We perform an exhaustive deep dive across existing database architectures and frontend rendering pipelines.',
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'awea_item_icon',
            [
                'label'   => esc_html__( 'Custom Node Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => '',
                    'library' => '',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_items',
            [
                'label'       => esc_html__( 'Milestone Items', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'awea_item_badge' => 'Phase 01',
                        'awea_item_title' => 'Discovery & Deep Audit',
                        'awea_item_desc'  => 'We perform an exhaustive deep dive across existing database architectures and frontend rendering pipelines.',
                    ],
                    [
                        'awea_item_badge' => 'Phase 02',
                        'awea_item_title' => 'Structural Logic Mapping',
                        'awea_item_desc'  => 'Defining application foundations, relational schemas, user journey nodes, and micro-service connectivity.',
                    ],
                    [
                        'awea_item_badge' => 'Phase 03',
                        'awea_item_title' => 'System Deployment & QA',
                        'awea_item_desc'  => 'Zero-downtime transition to production infrastructure backed by automated stress and security audits.',
                    ],
                ],
                'title_field' => '{{{ awea_item_badge }}} - {{{ awea_item_title }}}',
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'     => esc_html__( 'HTML Heading Tag', 'awesome-widgets-elementor' ),
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
           TAB: STYLE -> SECTION: GENERAL LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_layout',
            [
                'label' => esc_html__( 'Layout & Spacing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_timeline_max_width',
            [
                'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 300, 'max' => 1600 ],
                    '%'  => [ 'min' => 30, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 1100 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_item_gap',
            [
                'label'      => esc_html__( 'Item Vertical Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 120 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 40 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_spine_card_gap',
            [
                'label'      => esc_html__( 'Distance from Center Spine', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 12, 'max' => 100 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 48 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-item:nth-child(odd) .awea-timeline-content' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-timeline-item:nth-child(even) .awea-timeline-content' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SPINE & NODE INDICATORS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_spine',
            [
                'label' => esc_html__( 'Spine & Nodes', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_heading_spine',
            [
                'label' => esc_html__( 'Center Spine Line', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_spine_color',
            [
                'label'     => esc_html__( 'Spine Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-container::before' => 'background: linear-gradient(to bottom, transparent, {{VALUE}} 12%, {{VALUE}} 88%, transparent);',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_spine_width',
            [
                'label'      => esc_html__( 'Spine Thickness', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 2 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-container::before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_heading_dot',
            [
                'label'     => esc_html__( 'Node Circles', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_node_size',
            [
                'label'      => esc_html__( 'Node Diameter', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_node_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-dot-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-dot-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_node_top_offset',
            [
                'label'      => esc_html__( 'Vertical Alignment Offset', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 34 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_node_state_tabs' );

        // Normal Node State
        $this->start_controls_tab(
            'awea_node_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_dot_bg_color',
            [
                'label'     => esc_html__( 'Fill Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-dot-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_halo_color',
            [
                'label'     => esc_html__( 'Outer Halo Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.15)',
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'box-shadow: 0 0 0 8px {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Node State
        $this->start_controls_tab(
            'awea_node_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_dot_bg_color_hover',
            [
                'label'     => esc_html__( 'Fill Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-dot' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_icon_color_hover',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-dot-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_dot_halo_color_hover',
            [
                'label'     => esc_html__( 'Outer Halo Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.25)',
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-dot' => 'box-shadow: 0 0 0 12px {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: MILESTONE CARDS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_cards',
            [
                'label' => esc_html__( 'Milestone Cards', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-timeline-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'selector' => '{{WRAPPER}} .awea-timeline-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'selector' => '{{WRAPPER}} .awea-timeline-content',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No scale/zoom, purely color, border, and shadow)
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
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'selector' => '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: BADGE (STEP / DATE TAG)
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_badge',
            [
                'label' => esc_html__( 'Step Tag Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_badge_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-tag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_badge_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-step-tag' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_badge_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-tag',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_padding',
            [
                'label'      => esc_html__( 'Inner Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '4', 'right' => '12', 'bottom' => '4', 'left' => '12', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Tag', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TITLE & DESCRIPTION
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typography',
            [
                'label' => esc_html__( 'Title & Description', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Milestone Title
        $this->add_control(
            'awea_heading_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
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
                    '{{WRAPPER}} .awea-timeline-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-timeline-title',
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
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-timeline-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Milestone Description
        $this->add_control(
            'awea_heading_desc',
            [
                'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-timeline-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-timeline-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = $settings['awea_timeline_items'] ?? [];

        if ( empty( $items ) ) {
            return;
        }

        $tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
        ?>
        <div class="awea-timeline-container">
            <?php foreach ( $items as $item ) : 
                $badge    = $item['awea_item_badge'] ?? '';
                $title    = $item['awea_item_title'] ?? '';
                $desc     = $item['awea_item_desc'] ?? '';
                $has_icon = ! empty( $item['awea_item_icon']['value'] );
            ?>
                <div class="awea-timeline-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                    <!-- Center Node Indicator -->
                    <div class="awea-timeline-dot" aria-hidden="true">
                        <?php if ( $has_icon ) : ?>
                            <span class="awea-dot-icon">
                                <?php Icons_Manager::render_icon( $item['awea_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Content Card -->
                    <div class="awea-timeline-content">
                        <?php if ( ! empty( $badge ) ) : ?>
                            <span class="awea-step-tag"><?php echo esc_html( $badge ); ?></span>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $title ) ) : ?>
                            <<?php echo esc_attr( $tag ); ?> class="awea-timeline-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $tag ); ?>>
                        <?php endif; ?>

                        <?php if ( ! empty( $desc ) ) : ?>
                            <p class="awea-timeline-desc"><?php echo esc_html( $desc ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}