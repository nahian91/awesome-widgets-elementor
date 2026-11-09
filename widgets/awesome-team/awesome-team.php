<?php
/**
 * Awesome Team Widget.
 * Modern Glassmorphic Team Member Card with Smooth Dock Hover Mechanics.
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
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_Team extends Widget_Base {

    public function get_name() {
        return 'awesome-team';
    }

    public function get_title() {
        return esc_html__( 'Team', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'team', 'member', 'profile', 'avatar', 'staff', 'card' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: MEMBER PROFILE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_member_profile',
            [
                'label' => esc_html__( 'Member Profile', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_member_image',
            [
                'label'   => esc_html__( 'Profile Photo', 'awesome-widgets-elementor' ),
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
                'name'      => 'awea_member_image_size',
                'default'   => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'awea_member_name',
            [
                'label'       => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'awea_name_tag',
            [
                'label'   => esc_html__( 'Name HTML Tag', 'awesome-widgets-elementor' ),
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
            'awea_member_role',
            [
                'label'       => esc_html__( 'Role / Position', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_member_bio',
            [
                'label'       => esc_html__( 'Short Bio', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => esc_html__( 'Enter a brief 1-2 sentence introduction...', 'awesome-widgets-elementor' ),
                'default'     => esc_html__( 'Pioneering clean architectural design systems and kinetic user interfaces for high-growth tech teams.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: SOCIAL CHANNELS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_member_socials',
            [
                'label' => esc_html__( 'Social Links', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater_socials = new Repeater();

        $repeater_socials->add_control(
            'awea_social_title',
            [
                'label'       => esc_html__( 'Platform Name', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater_socials->add_control(
            'awea_social_icon',
            [
                'label'   => esc_html__( 'Platform Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fab fa-linkedin-in',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater_socials->add_control(
            'awea_social_url',
            [
                'label'       => esc_html__( 'Profile URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'https://linkedin.com/in/username',
                'default'     => [
                    'url'         => '#',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
            ]
        );

        $repeater_socials->add_control(
            'awea_social_brand_color',
            [
                'label'     => esc_html__( 'Brand Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0a66c2',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-social-brand: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_social_list',
            [
                'label'       => esc_html__( 'Social Profiles', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_socials->get_controls(),
                'default'     => [
                    [
                        'awea_social_title'       => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
                        'awea_social_icon'        => [ 'value' => 'fab fa-linkedin-in', 'library' => 'fa-brands' ],
                        'awea_social_brand_color' => '#0a66c2',
                    ],
                    [
                        'awea_social_title'       => esc_html__( 'X (Twitter)', 'awesome-widgets-elementor' ),
                        'awea_social_icon'        => [ 'value' => 'fab fa-x-twitter', 'library' => 'fa-brands' ],
                        'awea_social_brand_color' => '#000000',
                    ],
                    [
                        'awea_social_title'       => esc_html__( 'GitHub', 'awesome-widgets-elementor' ),
                        'awea_social_icon'        => [ 'value' => 'fab fa-github', 'library' => 'fa-brands' ],
                        'awea_social_brand_color' => '#24292f',
                    ],
                ],
                'title_field' => '{{{ awea_social_title }}}',
            ]
        );

        $this->add_control(
            'awea_social_always_visible',
            [
                'label'        => esc_html__( 'Always Show Social Dock', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'On Hover', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => esc_html__( 'Enable to make social icons always visible instead of showing on hover.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD SHELL & PHOTO
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Card Shell & Photo', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_aspect_ratio',
            [
                'label'     => esc_html__( 'Photo Aspect Ratio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '4/5',
                'options'   => [
                    '1/1'  => '1:1 Square',
                    '4/5'  => '4:5 Classic Portrait',
                    '3/4'  => '3:4 Editorial',
                    '16/9' => '16:9 Landscape',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-img-container' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-master-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Outer Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-master-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_inner_img_radius',
            [
                'label'      => esc_html__( 'Photo Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-img-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'awea_card_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#090d16',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-master-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-master-card',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No transform / lift / zoom)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_bg_color_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#090d16',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_card_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-master-card:hover',
            ]
        );

        $this->end_controls_tab();$this->end_controls_tabs();

        // Overlay Scrim
        $this->add_control(
            'awea_scrim_heading',
            [
                'label'     => esc_html__( 'Bottom Gradient Scrim', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_scrim_color',
            [
                'label'     => esc_html__( 'Gradient Dark Shade', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(9, 13, 22, 0.88)',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-scrim' => 'background: linear-gradient(180deg, rgba(9, 13, 22, 0) 40%, {{VALUE}} 100%);',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: FROSTED GLASS INFO DOCK
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_panel',
            [
                'label' => esc_html__( 'Frosted Info Dock', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_panel_padding',
            [
                'label'      => esc_html__( 'Internal Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-info-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_panel_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-info-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_panel_offset_bottom',
            [
                'label'      => esc_html__( 'Bottom Inset Offset', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-info-panel' => 'bottom: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_panel_state_tabs' );

        // Normal Dock
        $this->start_controls_tab(
            'awea_panel_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_panel_bg',
            [
                'label'     => esc_html__( 'Glass Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.76)',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-info-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_panel_border',
                'label'    => esc_html__( 'Glass Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-info-panel',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_panel_shadow',
                'label'    => esc_html__( 'Glass Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-info-panel',
            ]
        );

        $this->end_controls_tab();

        // Hover Dock (No translateY lift)
        $this->start_controls_tab(
            'awea_panel_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_panel_bg_hover',
            [
                'label'     => esc_html__( 'Glass Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.88)',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card:hover .awea-team-info-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_panel_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card:hover .awea-team-info-panel' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_panel_shadow_hover',
                'label'    => esc_html__( 'Glass Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-master-card:hover .awea-team-info-panel',
            ]
        );

        $this->end_controls_tab();$this->end_controls_tabs();

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

        // Name Styling
        $this->add_control(
            'awea_heading_name_style',
            [
                'label' => esc_html__( 'Member Name', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_name_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_name_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-name',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_name_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Name', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 4 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Role Styling
        $this->add_control(
            'awea_heading_role_style',
            [
                'label'     => esc_html__( 'Role / Position', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_role_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-role' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_role_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-role',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_role_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Role', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-role' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Bio Styling
        $this->add_control(
            'awea_heading_bio_style',
            [
                'label'     => esc_html__( 'Short Bio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_bio_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-bio' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_bio_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-bio',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SOCIAL BUTTONS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_socials',
            [
                'label' => esc_html__( 'Social Buttons', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_social_btn_size',
            [
                'label'      => esc_html__( 'Button Box Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 28, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 38 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-social-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_social_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-social-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-team-social-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_social_gap',
            [
                'label'      => esc_html__( 'Space Between Buttons', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 4, 'max' => 24 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-social-dock' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_social_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-social-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_social_state_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_social_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_social_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-social-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_social_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.1)',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-social-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_social_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-team-social-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover State (No transform / scale)
        $this->start_controls_tab(
            'awea_social_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_social_hover_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-team-social-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_social_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-social-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_social_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-team-social-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();$this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings       =$this->get_settings_for_display();
        $name           =$settings['awea_member_name'] ?? '';
        $role           =$settings['awea_member_role'] ?? '';
        $bio            =$settings['awea_member_bio'] ?? '';
        $social_list    =$settings['awea_social_list'] ?? [];
        $name_tag       = Utils::validate_html_tag($settings['awea_name_tag'] ?? 'h3' );
        $always_visible = ( 'yes' === ($settings['awea_social_always_visible'] ?? 'no' ) );

        $card_classes = [ 'awea-team-master-card' ];
        if ( $always_visible ) {$card_classes[] = 'awea-social-always-visible';
        }
        ?>
        <article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
            <!-- Photo Canvas with Scrim -->
            <div class="awea-team-img-container">
                <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_member_image_size', 'awea_member_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <div class="awea-team-scrim"></div>
            </div>

            <!-- Frosted Glass Info Dock -->
            <div class="awea-team-info-panel">
                <?php if ( ! empty( $name ) ) : ?>
                    <<?php echo esc_attr( $name_tag ); ?> class="awea-team-name"><?php echo esc_html( $name ); ?></<?php echo esc_attr($name_tag ); ?>>
                <?php endif; ?>

                <?php if ( ! empty( $role ) ) : ?>
                    <span class="awea-team-role"><?php echo esc_html( $role ); ?></span>
                <?php endif; ?>

                <?php if ( ! empty( $bio ) ) : ?>
                    <p class="awea-team-bio"><?php echo esc_html( $bio ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $social_list ) ) : ?>
                    <div class="awea-team-social-dock">
                        <?php
                        foreach ( $social_list as $index =>$social ) :
                            $link_key = 'awea_social_link_' .$index;
                            $title    =$social['awea_social_title'] ?? '';

                            if ( ! empty( $social['awea_social_url']['url'] ) ) {$this->add_link_attributes( $link_key,$social['awea_social_url'] );
                            } else {
                                $this->add_render_attribute($link_key, 'href', '#' );
                            }

                            $this->add_render_attribute($link_key, 'class', 'awea-team-social-btn elementor-repeater-item-' . esc_attr( $social['_id'] ) );
                            $this->add_render_attribute($link_key, 'aria-label', esc_attr( $title ) );$this->add_render_attribute( $link_key, 'title', esc_attr($title ) );
                            ?>
                            <a <?php echo $this->get_render_attribute_string($link_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                <?php Icons_Manager::render_icon( $social['awea_social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        <?php
    }
}