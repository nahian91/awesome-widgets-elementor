<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Team_Carousel extends Widget_Base {

    public function get_name() {
        return 'awesome-team-carousel';
    }

    public function get_title() {
        return esc_html__( 'Team Carousel', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'awea-icon eicon-carousel';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'team', 'carousel', 'slider', 'member', 'profile' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: TEAM MEMBERS
           ========================================================================== */
        $this->start_controls_section(
            'team_carousel_content',
            [
                'label' => esc_html__( 'Team Members', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_team_carousel_image',
            [
                'label'   => esc_html__( 'Profile Photo', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_name',
            [
                'label'       => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_designation',
            [
                'label'       => esc_html__( 'Role / Position', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_bio',
            [
                'label'       => esc_html__( 'Short Bio (Optional)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => esc_html__( 'Enter a brief introduction...', 'awesome-widgets-elementor' ),
                'default'     => esc_html__( 'Pioneering clean architectural design systems and kinetic user interfaces.', 'awesome-widgets-elementor' ),
            ]
        );

        $repeater->add_control(
            'awea_social_heading',
            [
                'label'     => esc_html__( 'Social Links', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_fb_url',
            [
                'label'       => esc_html__( 'Facebook URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://facebook.com/username',
                'default'     => [ 'url' => '' ],
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_tw_url',
            [
                'label'       => esc_html__( 'X (Twitter) URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://twitter.com/username',
                'default'     => [ 'url' => '' ],
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_ln_url',
            [
                'label'       => esc_html__( 'LinkedIn URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://linkedin.com/in/username',
                'default'     => [ 'url' => '#' ],
            ]
        );

        $repeater->add_control(
            'awea_team_carousel_insta_url',
            [
                'label'       => esc_html__( 'Instagram URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://instagram.com/username',
                'default'     => [ 'url' => '#' ],
            ]
        );

        $this->add_control(
            'awea_team_carousels',
            [
                'label'       => esc_html__( 'Members List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ awea_team_carousel_name }}} - {{{ awea_team_carousel_designation }}}',
                'default'     => [
                    [
                        'awea_team_carousel_name'        => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_designation' => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_bio'         => esc_html__( 'Pioneering clean architectural design systems and kinetic interfaces.', 'awesome-widgets-elementor' ),
                    ],
                    [
                        'awea_team_carousel_name'        => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_designation' => esc_html__( 'Senior Product Designer', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_bio'         => esc_html__( 'Specializing in design tokens, accessible color theory, and user journeys.', 'awesome-widgets-elementor' ),
                    ],
                    [
                        'awea_team_carousel_name'        => esc_html__( 'Julian Szekeres', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_designation' => esc_html__( 'Core Systems Engineer', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_bio'         => esc_html__( 'Optimizing micro-service pipelines and real-time state hydration routines.', 'awesome-widgets-elementor' ),
                    ],
                    [
                        'awea_team_carousel_name'        => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_designation' => esc_html__( 'Creative Director', 'awesome-widgets-elementor' ),
                        'awea_team_carousel_bio'         => esc_html__( 'Crafting high-impact digital experiences across web and mobile surfaces.', 'awesome-widgets-elementor' ),
                    ],
                ],
            ]
        );

        $this->add_control(
            'awea_name_tag',
            [
                'label'     => esc_html__( 'Name HTML Tag', 'awesome-widgets-elementor' ),
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

        $this->add_control(
            'awea_social_always_visible',
            [
                'label'        => esc_html__( 'Always Show Social Dock', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'On Hover', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: SLIDER SETTINGS
           ========================================================================== */
        $this->start_controls_section(
            'awea_team_carousel_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'awea_team_carousel_items',
            [
                'label'          => esc_html__( 'Slides Per View', 'awesome-widgets-elementor' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_team_carousel_gap',
            [
                'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
            ]
        );

        $this->add_control(
            'awea_team_carousel_arrows',
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
            'awea_team_carousel_dots',
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
            'awea_team_carousel_loop',
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
            'awea_team_carousel_autoplay',
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
            'awea_team_carousel_pause',
            [
                'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [ 'awea_team_carousel_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_team_carousel_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Interval', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'min'       => 1000,
                'max'       => 15000,
                'step'      => 500,
                'condition' => [ 'awea_team_carousel_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_team_carousel_autoplay_animation',
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
                'label'      => esc_html__( 'Outer Padding', 'awesome-widgets-elementor' ),
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

        $this->end_controls_tab();
        $this->end_controls_tabs();

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

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ARROWS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_arrows',
            [
                'label'     => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_team_carousel_arrows' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_arrow_size',
            [
                'label'      => esc_html__( 'Arrow Box Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 30, 'max' => 70 ] ],
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
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-carousel-arrow-border i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_arrows_tabs' );

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
                'label'    => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-carousel-arrow-border',
            ]
        );

        $this->end_controls_tab();

        // Hover Arrow (No zoom)
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
           TAB: STYLE -> SECTION: DOTS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_dots',
            [
                'label'     => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_team_carousel_dots' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_dots_size',
            [
                'label'      => esc_html__( 'Dot Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 6, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-team-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $members  = $settings['awea_team_carousels'] ?? [];

        if ( empty( $members ) ) {
            return;
        }

        $items_desktop  = ! empty( $settings['awea_team_carousel_items'] ) ? (int) $settings['awea_team_carousel_items'] : 3;
        $items_tablet   = ! empty( $settings['awea_team_carousel_items_tablet'] ) ? (int) $settings['awea_team_carousel_items_tablet'] : 2;
        $items_mobile   = ! empty( $settings['awea_team_carousel_items_mobile'] ) ? (int) $settings['awea_team_carousel_items_mobile'] : 1;

        $gap_desktop    = isset( $settings['awea_team_carousel_gap']['size'] ) ? (int) $settings['awea_team_carousel_gap']['size'] : 24;
        $gap_tablet     = isset( $settings['awea_team_carousel_gap_tablet']['size'] ) ? (int) $settings['awea_team_carousel_gap_tablet']['size'] : 20;
        $gap_mobile     = isset( $settings['awea_team_carousel_gap_mobile']['size'] ) ? (int) $settings['awea_team_carousel_gap_mobile']['size'] : 16;

        $show_arrows    = ( 'yes' === ( $settings['awea_team_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
        $show_dots      = ( 'yes' === ( $settings['awea_team_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
        $loop           = ( 'yes' === ( $settings['awea_team_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
        $autoplay       = ( 'yes' === ( $settings['awea_team_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
        $pause          = ( 'yes' === ( $settings['awea_team_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
        $auto_speed     = ! empty( $settings['awea_team_carousel_autoplay_speed'] ) ? (int) $settings['awea_team_carousel_autoplay_speed'] : 5000;
        $anim_speed     = ! empty( $settings['awea_team_carousel_autoplay_animation'] ) ? (int) $settings['awea_team_carousel_autoplay_animation'] : 450;

        $always_visible = ( 'yes' === ( $settings['awea_social_always_visible'] ?? 'no' ) );
        $name_tag       = Utils::validate_html_tag( $settings['awea_name_tag'] ?? 'h3' );

        $card_classes = [ 'awea-team-master-card' ];
        if ( $always_visible ) {
            $card_classes[] = 'awea-social-always-visible';
        }
        ?>
        <div class="awea-team-carousel-wrapper">
            <div class="awea-team-carousel owl-carousel"
                data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
                data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
                data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
                data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
                data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
                data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
                data-arrows="<?php echo esc_attr( $show_arrows ); ?>"
                data-dots="<?php echo esc_attr( $show_dots ); ?>"
                data-loop="<?php echo esc_attr( $loop ); ?>"
                data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
                data-pause="<?php echo esc_attr( $pause ); ?>"
                data-speed="<?php echo esc_attr( $anim_speed ); ?>"
                data-timeout="<?php echo esc_attr( $auto_speed ); ?>">

                <?php foreach ( $members as $team ) :
                    $image_url = ! empty( $team['awea_team_carousel_image']['url'] ) ? esc_url( $team['awea_team_carousel_image']['url'] ) : Utils::get_placeholder_image_src();
                    $name      = ! empty( $team['awea_team_carousel_name'] ) ? esc_html( $team['awea_team_carousel_name'] ) : '';
                    $role      = ! empty( $team['awea_team_carousel_designation'] ) ? esc_html( $team['awea_team_carousel_designation'] ) : '';
                    $bio       = ! empty( $team['awea_team_carousel_bio'] ) ? esc_html( $team['awea_team_carousel_bio'] ) : '';

                    $social_links = [
                        [
                            'url'   => $team['awea_team_carousel_ln_url']['url'] ?? '',
                            'icon'  => 'fab fa-linkedin-in',
                            'title' => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
                            'brand' => '#0a66c2',
                        ],
                        [
                            'url'   => $team['awea_team_carousel_tw_url']['url'] ?? '',
                            'icon'  => 'fab fa-x-twitter',
                            'title' => esc_html__( 'X (Twitter)', 'awesome-widgets-elementor' ),
                            'brand' => '#000000',
                        ],
                        [
                            'url'   => $team['awea_team_carousel_fb_url']['url'] ?? '',
                            'icon'  => 'fab fa-facebook-f',
                            'title' => esc_html__( 'Facebook', 'awesome-widgets-elementor' ),
                            'brand' => '#1877f2',
                        ],
                        [
                            'url'   => $team['awea_team_carousel_insta_url']['url'] ?? '',
                            'icon'  => 'fab fa-instagram',
                            'title' => esc_html__( 'Instagram', 'awesome-widgets-elementor' ),
                            'brand' => '#e4405f',
                        ],
                    ];

                    $has_socials = false;
                    foreach ( $social_links as $s_item ) {
                        if ( ! empty( $s_item['url'] ) ) {
                            $has_socials = true;
                            break;
                        }
                    }
                ?>
                    <article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
                        <!-- Image Canvas & Cinematic Scrim -->
                        <div class="awea-team-img-container">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
                            <div class="awea-team-scrim"></div>
                        </div>

                        <!-- Floating Frosted Glass Info Dock -->
                        <div class="awea-team-info-panel">
                            <?php if ( ! empty( $name ) ) : ?>
                                <<?php echo esc_attr( $name_tag ); ?> class="awea-team-name"><?php echo esc_html( $name ); ?></<?php echo esc_attr( $name_tag ); ?>>
                            <?php endif; ?>

                            <?php if ( ! empty( $role ) ) : ?>
                                <span class="awea-team-role"><?php echo esc_html( $role ); ?></span>
                            <?php endif; ?>

                            <?php if ( ! empty( $bio ) ) : ?>
                                <p class="awea-team-bio"><?php echo esc_html( $bio ); ?></p>
                            <?php endif; ?>

                            <?php if ( $has_socials ) : ?>
                                <div class="awea-team-social-dock">
                                    <?php foreach ( $social_links as $social ) :
                                        if ( empty( $social['url'] ) ) {
                                            continue;
                                        }
                                    ?>
                                        <a href="<?php echo esc_url( $social['url'] ); ?>" 
                                           class="awea-team-social-btn" 
                                           target="_blank" 
                                           rel="noopener noreferrer" 
                                           aria-label="<?php echo esc_attr( $social['title'] ); ?>" 
                                           title="<?php echo esc_attr( $social['title'] ); ?>"
                                           style="--awea-social-brand: <?php echo esc_attr( $social['brand'] ); ?>;">
                                            <i class="<?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}