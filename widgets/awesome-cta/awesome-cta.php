<?php
/**
 * Awesome CTA Studio Widget.
 * Modern Kinetic Call-to-Action with Ambient Glow & Dual Action Architecture.
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
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Widget_Awesome_CTA extends Widget_Base {

    public function get_name() {
        return 'awesome-cta';
    }

    public function get_title() {
        return esc_html__( 'CTA', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'cta', 'hero', 'banner', 'action', 'button', 'convert', 'spotlight' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CONTENT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_cta_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_badge',
            [
                'label'        => esc_html__( 'Show Subtitle Badge', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_badge_icon',
            [
                'label'     => esc_html__( 'Badge Icon', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-sparkles',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'awea_show_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_badge_text',
            [
                'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Next Generation Framework', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'condition'   => [ 'awea_show_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_title',
            [
                'label'       => esc_html__( 'Main Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => esc_html__( 'Elevate Your Digital Presence Today.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
            ]
        );

        $this->add_control(
            'awea_description',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => esc_html__( 'The ultimate all-in-one suite to construct, launch, and scale high-performance brand experiences with zero bloat.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->add_responsive_control(
            'awea_align',
            [
                'label'        => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'      => 'center',
                'prefix_class' => 'awea-cta-align-',
                'selectors'    => [
                    '{{WRAPPER}} .awea-cta-hero-section' => 'text-align: {{VALUE}};',
                ],
                'separator'    => 'before',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PRIMARY BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_primary_btn',
            [
                'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_primary_btn',
            [
                'label'        => esc_html__( 'Show Primary Button', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_primary_btn_text',
            [
                'label'       => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_link',
            [
                'label'       => esc_html__( 'Destination Link', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'default'     => [ 'url' => '#' ],
                'condition'   => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_icon',
            [
                'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_icon_align',
            [
                'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => [
                    'left'  => esc_html__( 'Before Text', 'awesome-widgets-elementor' ),
                    'right' => esc_html__( 'After Text', 'awesome-widgets-elementor' ),
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: SECONDARY BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_secondary_btn',
            [
                'label' => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_secondary_btn',
            [
                'label'        => esc_html__( 'Show Secondary Button', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_secondary_btn_text',
            [
                'label'       => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Book Live Demo', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_show_secondary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_link',
            [
                'label'       => esc_html__( 'Destination Link', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'default'     => [ 'url' => '#' ],
                'condition'   => [ 'awea_show_secondary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_icon',
            [
                'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-calendar-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'awea_show_secondary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_icon_align',
            [
                'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => esc_html__( 'Before Text', 'awesome-widgets-elementor' ),
                    'right' => esc_html__( 'After Text', 'awesome-widgets-elementor' ),
                ],
                'condition' => [ 'awea_show_secondary_btn' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SECTION CONTAINER & AMBIENT GLOW
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_container',
            [
                'label' => esc_html__( 'Section & Ambient Glow', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_section_padding',
            [
                'label'      => esc_html__( 'Section Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '80', 'right' => '24', 'bottom' => '80', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_show_glow',
            [
                'label'        => esc_html__( 'Enable Ambient Glow', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_glow_color',
            [
                'label'     => esc_html__( 'Glow Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-hero-bg-glow' => 'background: radial-gradient(circle at center, {{VALUE}} 0%, transparent 70%);',
                ],
                'condition' => [ 'awea_show_glow' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_glow_opacity',
            [
                'label'     => esc_html__( 'Glow Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [ 'min' => 0.05, 'max' => 0.6, 'step' => 0.02 ],
                ],
                'default'   => [ 'size' => 0.18 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-hero-bg-glow' => 'opacity: {{SIZE}};',
                ],
                'condition' => [ 'awea_show_glow' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: BADGE KICKER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_badge',
            [
                'label'     => esc_html__( 'Badge Kicker', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_badge_color',
            [
                'label'     => esc_html__( 'Text & Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-hero-badge' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-cta-hero-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_badge_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-hero-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_badge_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-hero-badge',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '8', 'right' => '18', 'bottom' => '8', 'left' => '18', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_badge_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 28 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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

        // Main Title
        $this->add_control(
            'awea_heading_title_style',
            [
                'label' => esc_html__( 'Main Title', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-cta-hero-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-hero-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_title_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Description
        $this->add_control(
            'awea_heading_desc_style',
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
                    '{{WRAPPER}} .awea-cta-hero-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-hero-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_desc_max_width',
            [
                'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [ 'px' => [ 'min' => 300, 'max' => 1000 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 680 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-desc' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_desc_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 44 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-hero-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: PRIMARY BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_primary_btn',
            [
                'label'     => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_primary_btn_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_primary_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '36', 'bottom' => '16', 'left' => '36', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_primary_btn_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-btn-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_primary_btn_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_primary_btn_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_primary_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-primary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-primary' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_primary_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_primary_btn_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_primary_btn_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_primary_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-primary:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-primary:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-primary:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_primary_btn_hover_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-primary:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SECONDARY BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_secondary_btn',
            [
                'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_secondary_btn' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_secondary_btn_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_secondary_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_secondary_btn_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cta-btn-secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_secondary_btn_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_secondary_btn_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_secondary_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-secondary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-secondary' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_secondary_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_secondary_btn_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_secondary_btn_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_secondary_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-secondary:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-secondary:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_secondary_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-btn-secondary:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_secondary_btn_hover_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cta-btn-secondary:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $show_badge     = 'yes' === ( $settings['awea_show_badge'] ?? 'no' );
        $badge_text     = $settings['awea_badge_text'] ?? '';
        $title          = $settings['awea_title'] ?? '';
        $title_tag      = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );
        $desc           = $settings['awea_description'] ?? '';
        $show_glow      = 'yes' === ( $settings['awea_show_glow'] ?? 'no' );

        $show_prime_btn = 'yes' === ( $settings['awea_show_primary_btn'] ?? 'no' );
        $prime_text     = $settings['awea_primary_btn_text'] ?? '';
        $prime_align    = $settings['awea_primary_btn_icon_align'] ?? 'right';

        $show_sec_btn   = 'yes' === ( $settings['awea_show_secondary_btn'] ?? 'no' );
        $sec_text       = $settings['awea_secondary_btn_text'] ?? '';
        $sec_align      = $settings['awea_secondary_btn_icon_align'] ?? 'left';

        if ( $show_prime_btn && ! empty( $settings['awea_primary_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'awea_prime_link', $settings['awea_primary_btn_link'] );
        }
        if ( $show_sec_btn && ! empty( $settings['awea_secondary_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'awea_sec_link', $settings['awea_secondary_btn_link'] );
        }

        $this->add_render_attribute( 'awea_prime_link', 'class', 'awea-cta-btn awea-cta-btn-primary' );
        $this->add_render_attribute( 'awea_sec_link', 'class', 'awea-cta-btn awea-cta-btn-secondary' );
        ?>
        <section class="awea-cta-hero-section">
            
            <?php if ( $show_glow ) : ?>
                <div class="awea-cta-hero-bg-glow" aria-hidden="true"></div>
            <?php endif; ?>

            <div class="awea-cta-hero-content">

                <?php if ( $show_badge && ! empty( $badge_text ) ) : ?>
                    <div class="awea-cta-hero-badge">
                        <?php if ( ! empty( $settings['awea_badge_icon']['value'] ) ) : ?>
                            <span class="awea-badge-icon" aria-hidden="true">
                                <?php Icons_Manager::render_icon( $settings['awea_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                        <span class="awea-badge-text"><?php echo esc_html( $badge_text ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $title ) ) : ?>
                    <<?php echo esc_attr( $title_tag ); ?> class="awea-cta-hero-title">
                        <?php echo wp_kses_post( $title ); ?>
                    </<?php echo esc_attr( $title_tag ); ?>>
                <?php endif; ?>

                <?php if ( ! empty( $desc ) ) : ?>
                    <p class="awea-cta-hero-desc">
                        <?php echo esc_html( $desc ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( ( $show_prime_btn && ! empty( $prime_text ) ) || ( $show_sec_btn && ! empty( $sec_text ) ) ) : ?>
                    <div class="awea-cta-hero-actions">
                        
                        <?php if ( $show_prime_btn && ! empty( $prime_text ) ) : ?>
                            <a <?php echo $this->get_render_attribute_string( 'awea_prime_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                <?php if ( 'left' === $prime_align && ! empty( $settings['awea_primary_btn_icon']['value'] ) ) : ?>
                                    <span class="awea-btn-icon awea-icon-left" aria-hidden="true">
                                        <?php Icons_Manager::render_icon( $settings['awea_primary_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                <?php endif; ?>

                                <span class="awea-btn-text"><?php echo esc_html( $prime_text ); ?></span>

                                <?php if ( 'right' === $prime_align && ! empty( $settings['awea_primary_btn_icon']['value'] ) ) : ?>
                                    <span class="awea-btn-icon awea-icon-right" aria-hidden="true">
                                        <?php Icons_Manager::render_icon( $settings['awea_primary_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( $show_sec_btn && ! empty( $sec_text ) ) : ?>
                            <a <?php echo $this->get_render_attribute_string( 'awea_sec_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                <?php if ( 'left' === $sec_align && ! empty( $settings['awea_secondary_btn_icon']['value'] ) ) : ?>
                                    <span class="awea-btn-icon awea-icon-left" aria-hidden="true">
                                        <?php Icons_Manager::render_icon( $settings['awea_secondary_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                <?php endif; ?>

                                <span class="awea-btn-text"><?php echo esc_html( $sec_text ); ?></span>

                                <?php if ( 'right' === $sec_align && ! empty( $settings['awea_secondary_btn_icon']['value'] ) ) : ?>
                                    <span class="awea-btn-icon awea-icon-right" aria-hidden="true">
                                        <?php Icons_Manager::render_icon( $settings['awea_secondary_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>
        </section>
        <?php
    }
}