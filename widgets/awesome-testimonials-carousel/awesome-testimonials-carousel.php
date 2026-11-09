<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Testimonials_Carousel extends Widget_Base {

    public function get_name() {
        return 'awesome-testimonials-carousel';
    }

    public function get_title() {
        return esc_html__( 'Testimonials Carousel', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'awea-icon eicon-testimonial-carousel';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'reviews', 'testimonials', 'carousel', 'slider', 'rating' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: SLIDES / TESTIMONIALS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_carousel_content',
            [
                'label' => esc_html__( 'Testimonials Slides', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_item_rating',
            [
                'label'   => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '0' => esc_html__( 'None (Hide Stars)', 'awesome-widgets-elementor' ),
                    '1' => esc_html__( '1 Star', 'awesome-widgets-elementor' ),
                    '2' => esc_html__( '2 Stars', 'awesome-widgets-elementor' ),
                    '3' => esc_html__( '3 Stars', 'awesome-widgets-elementor' ),
                    '4' => esc_html__( '4 Stars', 'awesome-widgets-elementor' ),
                    '5' => esc_html__( '5 Stars', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $repeater->add_control(
            'awea_item_speech',
            [
                'label'       => esc_html__( 'Testimonial Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'awea_item_image',
            [
                'label'   => esc_html__( 'Author Photo', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'awea_item_name',
            [
                'label'       => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_desg',
            [
                'label'       => esc_html__( 'Role / Company', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_verified',
            [
                'label'        => esc_html__( 'Verified Customer Badge', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_testimonials_list',
            [
                'label'       => esc_html__( 'Testimonial Items', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ awea_item_name }}} - {{{ awea_item_desg }}}',
                'default'     => [
                    [
                        'awea_item_name'   => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
                        'awea_item_desg'   => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
                        'awea_item_speech' => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
                        'awea_item_rating' => '5',
                        'awea_item_verified' => 'yes',
                    ],
                    [
                        'awea_item_name'   => esc_html__( 'Maria Sauks', 'awesome-widgets-elementor' ),
                        'awea_item_desg'   => esc_html__( 'Senior Engineer', 'awesome-widgets-elementor' ),
                        'awea_item_speech' => esc_html__( 'Its impressed me on multiple levels. Painless, pleasant, and most of all hassle free! Id be lost without it.', 'awesome-widgets-elementor' ),
                        'awea_item_rating' => '5',
                        'awea_item_verified' => 'yes',
                    ],
                    [
                        'awea_item_name'   => esc_html__( 'Sarah Heinsed', 'awesome-widgets-elementor' ),
                        'awea_item_desg'   => esc_html__( 'Product Strategist', 'awesome-widgets-elementor' ),
                        'awea_item_speech' => esc_html__( 'Incredible craftsmanship and attention to detail. Our conversion rates jumped 32% since rollout.', 'awesome-widgets-elementor' ),
                        'awea_item_rating' => '5',
                        'awea_item_verified' => 'yes',
                    ],
                ],
            ]
        );

        $this->add_control(
            'awea_name_tag',
            [
                'label'     => esc_html__( 'Author Name Tag', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h4',
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
            'awea_show_quote_icon',
            [
                'label'        => esc_html__( 'Watermark Quote Icon', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CAROUSEL SETTINGS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_carousel_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'awea_slides_to_show',
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
            'awea_show_arrows',
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
            'awea_show_dots',
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
            'awea_loop',
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
            'awea_autoplay',
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
            'awea_pause_on_hover',
            [
                'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [ 'awea_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_autoplay_speed',
            [
                'label'       => esc_html__( 'Autoplay Interval', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 5000,
                'min'         => 1000,
                'max'         => 15000,
                'step'        => 500,
                'condition'   => [ 'awea_autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_animation_speed',
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
           TAB: STYLE -> SECTION: CARD & KINETIC BEAM
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_card',
            [
                'label' => esc_html__( 'Card & Kinetic Beam', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-card',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No scale / zoom)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_bg_hover_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-testimonial-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-card:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Kinetic Beam Group
        $this->add_control(
            'awea_beam_heading',
            [
                'label'     => esc_html__( 'Kinetic Beam Border', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_enable_beam',
            [
                'label'        => esc_html__( 'Enable Beam Effect', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_beam_color',
            [
                'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => '--awea-beam-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_enable_beam' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_beam_speed',
            [
                'label'      => esc_html__( 'Beam Rotation Speed', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range'      => [ 's' => [ 'min' => 1, 'max' => 10, 'step' => 0.5 ] ],
                'default'    => [ 'unit' => 's', 'size' => 3.5 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-card' => '--awea-beam-speed: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_enable_beam' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: WATERMARK QUOTE ICON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_quote',
            [
                'label'     => esc_html__( 'Watermark Quote', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_quote_icon' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_quote_icon_size',
            [
                'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 20, 'max' => 80 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 44 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-quote-brand' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_quote_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-quote-brand' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_quote_opacity',
            [
                'label'     => esc_html__( 'Normal Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 0.02, 'max' => 1, 'step' => 0.02 ] ],
                'default'   => [ 'size' => 0.08 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-quote-brand' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_quote_hover_opacity',
            [
                'label'     => esc_html__( 'Hover Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 0.02, 'max' => 1, 'step' => 0.02 ] ],
                'default'   => [ 'size' => 0.22 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card:hover .awea-testimonial-quote-brand' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: RATING STARS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_stars',
            [
                'label' => esc_html__( 'Rating Stars', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_star_size',
            [
                'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 36 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-stars i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_star_gap',
            [
                'label'      => esc_html__( 'Space Between Stars', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 1, 'max' => 16 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 5 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-stars' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_star_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Stars', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 18 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-stars' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_star_filled_color',
            [
                'label'     => esc_html__( 'Filled Star Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f59e0b',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-stars .awea-star-filled' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_star_empty_color',
            [
                'label'     => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e2e8f0',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-stars .awea-star-empty' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TESTIMONIAL TEXT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_speech',
            [
                'label' => esc_html__( 'Testimonial Text', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_speech_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_speech_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-text',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_speech_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Text', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: AUTHOR FOOTER & AVATAR
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_author',
            [
                'label' => esc_html__( 'Author & Meta', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_footer_border_color',
            [
                'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.06)',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-footer' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_footer_padding_top',
            [
                'label'      => esc_html__( 'Divider Top Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 18 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-footer' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Photo Subgroup
        $this->add_control(
            'awea_heading_avatar',
            [
                'label'     => esc_html__( 'Author Photo', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_avatar_size',
            [
                'label'      => esc_html__( 'Photo Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 30, 'max' => 100 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 50 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_avatar_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => '%', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_avatar_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-avatar',
            ]
        );

        // Name Subgroup
        $this->add_control(
            'awea_heading_author_text',
            [
                'label'     => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_name_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_name_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-name',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        // Role Subgroup
        $this->add_control(
            'awea_heading_desg_text',
            [
                'label'     => esc_html__( 'Role / Company', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_desg_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-desg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desg_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-desg',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Verified Badge Subgroup
        $this->add_control(
            'awea_heading_verified_style',
            [
                'label'     => esc_html__( 'Verified Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_verified_size',
            [
                'label'      => esc_html__( 'Badge Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 18, 'max' => 44 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 26 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-testimonial-verify' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_verified_bg_color',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dcfce7',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-verify' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_verified_icon_color',
            [
                'label'     => esc_html__( 'Checkmark Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#15803d',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-verify svg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ARROWS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_arrows',
            [
                'label'     => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_arrows' => 'yes' ],
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
                'condition' => [ 'awea_show_dots' => 'yes' ],
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
                    '{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-testimonials .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = $settings['awea_testimonials_list'] ?? [];

        if ( empty( $items ) ) {
            return;
        }

        $items_desktop = ! empty( $settings['awea_slides_to_show'] ) ? (int) $settings['awea_slides_to_show'] : 3;
        $items_tablet  = ! empty( $settings['awea_slides_to_show_tablet'] ) ? (int) $settings['awea_slides_to_show_tablet'] : 2;
        $items_mobile  = ! empty( $settings['awea_slides_to_show_mobile'] ) ? (int) $settings['awea_slides_to_show_mobile'] : 1;

        $gap_desktop   = isset( $settings['awea_slide_gap']['size'] ) ? (int) $settings['awea_slide_gap']['size'] : 24;
        $gap_tablet    = isset( $settings['awea_slide_gap_tablet']['size'] ) ? (int) $settings['awea_slide_gap_tablet']['size'] : 20;
        $gap_mobile    = isset( $settings['awea_slide_gap_mobile']['size'] ) ? (int) $settings['awea_slide_gap_mobile']['size'] : 16;

        $show_arrows   = ( 'yes' === ( $settings['awea_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
        $show_dots     = ( 'yes' === ( $settings['awea_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
        $loop          = ( 'yes' === ( $settings['awea_loop'] ?? 'no' ) ) ? 'yes' : 'no';
        $autoplay      = ( 'yes' === ( $settings['awea_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
        $pause         = ( 'yes' === ( $settings['awea_pause_on_hover'] ?? 'no' ) ) ? 'yes' : 'no';
        $auto_speed    = ! empty( $settings['awea_autoplay_speed'] ) ? (int) $settings['awea_autoplay_speed'] : 5000;
        $anim_speed    = ! empty( $settings['awea_animation_speed'] ) ? (int) $settings['awea_animation_speed'] : 450;

        $has_beam      = 'yes' === ( $settings['awea_enable_beam'] ?? 'no' );
        $has_quote     = 'yes' === ( $settings['awea_show_quote_icon'] ?? 'no' );
        $name_tag      = Utils::validate_html_tag( $settings['awea_name_tag'] ?? 'h4' );
        ?>
        <div class="awea-testimonials-carousel-wrapper">
            <div class="awea-testimonials owl-carousel" 
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

                <?php foreach ( $items as $item ) :
                    $avatar_url  = ! empty( $item['awea_item_image']['url'] ) ? esc_url( $item['awea_item_image']['url'] ) : Utils::get_placeholder_image_src();
                    $name        = ! empty( $item['awea_item_name'] ) ? esc_html( $item['awea_item_name'] ) : esc_html__( 'Anonymous', 'awesome-widgets-elementor' );
                    $desg        = ! empty( $item['awea_item_desg'] ) ? esc_html( $item['awea_item_desg'] ) : '';
                    $speech      = ! empty( $item['awea_item_speech'] ) ? wp_kses_post( $item['awea_item_speech'] ) : '';
                    $rating      = isset( $item['awea_item_rating'] ) ? absint( $item['awea_item_rating'] ) : 5;
                    $is_verified = 'yes' === ( $item['awea_item_verified'] ?? 'no' );

                    $card_classes = [ 'awea-testimonial-card' ];
                    if ( $has_beam ) {
                        $card_classes[] = 'awea-has-beam';
                    }
                ?>
                    <div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

                        <?php if ( $has_quote ) : ?>
                            <svg class="awea-testimonial-quote-brand" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
                            </svg>
                        <?php endif; ?>

                        <!-- Star Rating -->
                        <?php if ( $rating > 0 ) : ?>
                            <div class="awea-testimonial-stars" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating ) ); ?>">
                                <?php 
                                for ( $i = 1; $i <= 5; $i++ ) {
                                    $star_class = ( $i <= $rating ) ? 'fas fa-star awea-star-filled' : 'far fa-star awea-star-empty';
                                    echo '<i class="' . esc_attr( $star_class ) . '" aria-hidden="true"></i>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Testimonial Quote Speech -->
                        <?php if ( ! empty( $speech ) ) : ?>
                            <blockquote class="awea-testimonial-text">
                                &ldquo;<?php echo wp_kses_post( $speech ); ?>&rdquo;
                            </blockquote>
                        <?php endif; ?>

                        <!-- Author Footer Lockup -->
                        <div class="awea-testimonial-footer">
                            <?php if ( ! empty( $avatar_url ) ) : ?>
                                <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="awea-testimonial-avatar" loading="lazy" />
                            <?php endif; ?>
                            
                            <div class="awea-testimonial-meta">
                                <<?php echo esc_attr( $name_tag ); ?> class="awea-testimonial-name"><?php echo esc_html( $name ); ?></<?php echo esc_attr( $name_tag ); ?>>
                                <?php if ( ! empty( $desg ) ) : ?>
                                    <cite class="awea-testimonial-desg"><?php echo esc_html( $desg ); ?></cite>
                                <?php endif; ?>
                            </div>

                            <?php if ( $is_verified ) : ?>
                                <div class="awea-testimonial-verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}