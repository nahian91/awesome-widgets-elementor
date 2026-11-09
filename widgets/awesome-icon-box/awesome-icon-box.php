<?php
/**
 * Awesome Icon Box Studio Widget.
 * Modern Kinetic Feature Card with Dynamic Icon Integration.
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
use \Elementor\Icons_Manager;

class Widget_Awesome_Icon_Box extends Widget_Base {

    public function get_name() {
        return 'awesome-icon-box';
    }

    public function get_title() {
        return esc_html__( 'Icon Box', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'icon', 'box', 'feature', 'card', 'service', 'info' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: ICON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_icon_content',
            [
                'label' => esc_html__( 'Icon Media', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_icon',
            [
                'label'   => esc_html__( 'Choose Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-bolt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: TEXT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_text_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_title',
            [
                'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Lightning Fast Architecture', 'awesome-widgets-elementor' ),
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

        $this->add_control(
            'awea_description',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => esc_html__( 'Engineered for optimal rendering speeds with zero unnecessary overhead and asset minification straight out of the box.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_button_content',
            [
                'label' => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_button',
            [
                'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_button_text',
            [
                'label'       => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Explore Module', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_button_link',
            [
                'label'       => esc_html__( 'Destination Link', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'default'     => [ 'url' => '#' ],
                'condition'   => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_button_icon',
            [
                'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_button_icon_align',
            [
                'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => [
                    'left'  => esc_html__( 'Before Text', 'awesome-widgets-elementor' ),
                    'right' => esc_html__( 'After Text', 'awesome-widgets-elementor' ),
                ],
                'condition' => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_layout',
            [
                'label' => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_align',
            [
                'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-box' => 'text-align: {{VALUE}}; align-items: {{VALUE == "left" ? "flex-start" : (VALUE == "right" ? "flex-end" : "center")}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_card_state_tabs' );

        // Normal
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
                    '{{WRAPPER}} .awea-icon-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-box',
            ]
        );

        $this->end_controls_tab();

        // Hover (No transform lift / scale)
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
                    '{{WRAPPER}} .awea-icon-box:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-icon-box:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-box:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Background Glow Element
        $this->add_control(
            'awea_heading_ambient_glow',
            [
                'label'     => esc_html__( 'Ambient Corner Glow', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_show_corner_glow',
            [
                'label'        => esc_html__( 'Show Glow', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-icon-box::after' => 'background: radial-gradient(circle at center, {{VALUE}} 0%, transparent 70%);',
                ],
                'condition' => [ 'awea_show_corner_glow' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ICON & BADGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_icon',
            [
                'label' => esc_html__( 'Icon & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_dim',
            [
                'label'      => esc_html__( 'Badge Dimensions', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 36, 'max' => 120 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 64 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 12, 'max' => 64 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-wrapper i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_radius',
            [
                'label'      => esc_html__( 'Badge Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_icon_state_tabs' );

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
                    '{{WRAPPER}} .awea-icon-wrapper'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-icon-wrapper svg' => 'fill: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-icon-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_icon_badge_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-wrapper',
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
                    '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper svg' => 'fill: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_badge_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'awea_icon_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

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

        // Title
        $this->add_control(
            'awea_heading_title_style',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-icon-box-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-icon-box:hover .awea-icon-box-title' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .awea-icon-box-title',
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
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-icon-box-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-icon-box-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_desc_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-icon-box-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_button',
            [
                'label'     => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_btn_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-btn-link',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_btn_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-btn-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-btn-link' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-btn-link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-btn-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_btn_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-btn-link',
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
                    '{{WRAPPER}} .awea-btn-link:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-btn-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-btn-link:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_btn_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-btn-link:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings    = $this->get_settings_for_display();
        $title       = $settings['awea_title'] ?? '';
        $title_tag   = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
        $description = $settings['awea_description'] ?? '';
        $show_btn    = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
        $btn_text    = $settings['awea_button_text'] ?? '';
        $btn_align   = $settings['awea_button_icon_align'] ?? 'right';
        $has_btn_ico = ! empty( $settings['awea_button_icon']['value'] );

        if ( $show_btn && ! empty( $settings['awea_button_link']['url'] ) ) {
            $this->add_link_attributes( 'awea_btn_link', $settings['awea_button_link'] );
        }
        $this->add_render_attribute( 'awea_btn_link', 'class', 'awea-btn-link' );
        ?>
        <div class="awea-icon-box">
            <?php if ( ! empty( $settings['awea_icon']['value'] ) ) : ?>
                <div class="awea-icon-wrapper" aria-hidden="true">
                    <?php Icons_Manager::render_icon( $settings['awea_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $title ) ) : ?>
                <<?php echo esc_attr( $title_tag ); ?> class="awea-icon-box-title">
                    <?php echo esc_html( $title ); ?>
                </<?php echo esc_attr( $title_tag ); ?>>
            <?php endif; ?>

            <?php if ( ! empty( $description ) ) : ?>
                <p class="awea-icon-box-desc">
                    <?php echo wp_kses_post( $description ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'awea_btn_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                    <?php if ( 'left' === $btn_align && $has_btn_ico ) : ?>
                        <span class="awea-btn-icon awea-btn-icon-left" aria-hidden="true">
                            <?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                    <?php endif; ?>

                    <span class="awea-btn-text"><?php echo esc_html( $btn_text ); ?></span>

                    <?php if ( 'right' === $btn_align && $has_btn_ico ) : ?>
                        <span class="awea-btn-icon awea-btn-icon-right" aria-hidden="true">
                            <?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }
}