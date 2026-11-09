<?php
/**
 * Awesome Image Box Studio Widget.
 * Modern Architectural Media Feature Card with Dynamic Aspect Ratios & Kinetic Physics.
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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Widget_Awesome_Image_Box extends Widget_Base {

    public function get_name() {
        return 'awesome-image-box';
    }

    public function get_title() {
        return esc_html__( 'Image Box', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'image box', 'feature', 'card', 'media', 'portfolio', 'showcase' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: MEDIA & IMAGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_image',
            [
                'label' => esc_html__( 'Image Media', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_image',
            [
                'label'   => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'awea_image_size',
                'default'   => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'awea_image_aspect_ratio',
            [
                'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '16/10',
                'options'   => [
                    '16/9'  => '16:9 Widescreen',
                    '16/10' => '16:10 Modern',
                    '4/3'   => '4:3 Standard',
                    '1/1'   => '1:1 Square',
                    '3/4'   => '3:4 Portrait',
                    'auto'  => 'Original (Auto)',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-img-container' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_image_badge_text',
            [
                'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'dynamic'     => [ 'active' => true ],
                'placeholder' => esc_html__( 'e.g. Featured, New', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CONTENT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_content',
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
                'default'     => esc_html__( 'Lumina Design Architecture', 'awesome-widgets-elementor' ),
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
                'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 5,
                'default' => esc_html__( 'Master the craft of clean aesthetics with a component library built for speed, kinetic depth, and harmonic precision.', 'awesome-widgets-elementor' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: BUTTON ACTION
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_button',
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
                'default'     => esc_html__( 'Start Exploring', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_button_link',
            [
                'label'       => esc_html__( 'Destination URL', 'awesome-widgets-elementor' ),
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
           TAB: STYLE -> SECTION: CARD SHELL & ALIGNMENT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Card Shell & Alignment', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_align',
            [
                'label'     => esc_html__( 'Content Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-card'     => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .awea-image-box-btn-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-image-box-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-image-box-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-card',
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
                    '{{WRAPPER}} .awea-image-box-card:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-image-box-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-card:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Ambient Corner Glow Controls
        $this->add_control(
            'awea_heading_glow_style',
            [
                'label'     => esc_html__( 'Ambient Corner Glow', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_show_ambient_glow',
            [
                'label'        => esc_html__( 'Show Glow Effect', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-image-box-sparkle' => 'background: radial-gradient(circle, {{VALUE}} 0%, transparent 70%);',
                ],
                'condition' => [ 'awea_show_ambient_glow' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: IMAGE FRAME & BADGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_image',
            [
                'label' => esc_html__( 'Image Frame & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_image_radius',
            [
                'label'      => esc_html__( 'Photo Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-img-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_image_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Photo', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 22 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-img-container' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Badge Styling
        $this->add_control(
            'awea_heading_badge_style',
            [
                'label'     => esc_html__( 'Badge Tag', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_badge_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_badge_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_badge_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-badge',
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
                'default'    => [ 'top' => '5', 'right' => '14', 'bottom' => '5', 'left' => '14', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-image-box-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}} .awea-image-box-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-image-box-card:hover .awea-image-box-title' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .awea-image-box-title',
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
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-image-box-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_desc_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Description', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'label'     => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_button' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_button_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_button_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_button_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_button_state_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_button_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_button_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_button_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_button_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_button_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover State (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_button_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_button_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_button_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_button_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_button_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn:hover',
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
        $badge_text  = $settings['awea_image_badge_text'] ?? '';
        $show_glow   = 'yes' === ( $settings['awea_show_ambient_glow'] ?? 'no' );

        $show_btn    = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
        $btn_text    = $settings['awea_button_text'] ?? '';
        $btn_align   = $settings['awea_button_icon_align'] ?? 'right';
        $has_btn_ico = ! empty( $settings['awea_button_icon']['value'] );

        if ( $show_btn && ! empty( $settings['awea_button_link']['url'] ) ) {
            $this->add_link_attributes( 'awea_button_link', $settings['awea_button_link'] );
        }
        $this->add_render_attribute( 'awea_button_link', 'class', 'awea-image-box-action-btn' );
        ?>
        <article class="awea-image-box-card">
            
            <!-- Image Frame with Dynamic Ratio -->
            <div class="awea-image-box-img-container">
                <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_image_size', 'awea_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                
                <?php if ( ! empty( $badge_text ) ) : ?>
                    <span class="awea-image-box-badge"><?php echo esc_html( $badge_text ); ?></span>
                <?php endif; ?>
            </div>

            <!-- Editorial Content -->
            <div class="awea-image-box-content">
                <?php if ( ! empty( $title ) ) : ?>
                    <<?php echo esc_attr( $title_tag ); ?> class="awea-image-box-title">
                        <?php echo esc_html( $title ); ?>
                    </<?php echo esc_attr( $title_tag ); ?>>
                <?php endif; ?>

                <?php if ( ! empty( $description ) ) : ?>
                    <p class="awea-image-box-desc">
                        <?php echo wp_kses_post( $description ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
                    <div class="awea-image-box-btn-wrap">
                        <a <?php echo $this->get_render_attribute_string( 'awea_button_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <?php if ( 'left' === $btn_align && $has_btn_ico ) : ?>
                                <span class="awea-btn-icon awea-icon-left" aria-hidden="true">
                                    <?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>
                            <?php endif; ?>

                            <span class="awea-btn-text"><?php echo esc_html( $btn_text ); ?></span>

                            <?php if ( 'right' === $btn_align && $has_btn_ico ) : ?>
                                <span class="awea-btn-icon awea-icon-right" aria-hidden="true">
                                    <?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $show_glow ) : ?>
                <div class="awea-image-box-sparkle" aria-hidden="true"></div>
            <?php endif; ?>

        </article>
        <?php
    }
}