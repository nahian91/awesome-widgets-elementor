<?php
/**
 * Awesome Slider Studio Widget (Zero-Shadow Architectural Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since 2.0.0
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
use \Elementor\Repeater;

class Widget_Awesome_Slider extends Widget_Base {

	public function get_name() {
		return 'awesome-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'slider', 'carousel', 'hero', 'banner', 'slideshow' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. SLIDES (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_slides',
			[
				'label' => esc_html__( 'Slides', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_slide_tabs' );

		// --- TAB 1: CONTENT ---
		$repeater->start_controls_tab(
			'awea_tab_content',
			[ 'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image',
			[
				'label'   => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Creative Branding & Strategy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'We Build Memorable Brands', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Helping businesses stand out with strategic branding, design, and messaging.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: BUTTONS ---
		$repeater->start_controls_tab(
			'awea_tab_buttons',
			[ 'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_btn1_text',
			[
				'label'       => esc_html__( 'Primary Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Work', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_btn1_url',
			[
				'label'       => esc_html__( 'Primary URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_btn2_text',
			[
				'label'       => esc_html__( 'Secondary Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Contact Us', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$repeater->add_control(
			'awea_btn2_url',
			[
				'label'       => esc_html__( 'Secondary URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'label_block' => true,
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_slides',
			[
				'label'       => esc_html__( 'List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_title }}}',
				'default'     => [
					[
						'awea_subtitle' => esc_html__( 'Creative Branding', 'awesome-widgets-elementor' ),
						'awea_title'    => esc_html__( 'We Build Memorable Brands', 'awesome-widgets-elementor' ),
						'awea_desc'     => esc_html__( 'Helping businesses stand out with strategic branding, design, and messaging.', 'awesome-widgets-elementor' ),
						'awea_btn1_text' => esc_html__( 'Our Work', 'awesome-widgets-elementor' ),
						'awea_btn2_text' => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
					],
					[
						'awea_subtitle' => esc_html__( 'Digital Marketing', 'awesome-widgets-elementor' ),
						'awea_title'    => esc_html__( 'Grow Your Business Online', 'awesome-widgets-elementor' ),
						'awea_desc'     => esc_html__( 'From SEO to targeted marketing campaigns, we drive qualified traffic.', 'awesome-widgets-elementor' ),
						'awea_btn1_text' => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
						'awea_btn2_text' => esc_html__( 'Consultation', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_settings',
			[
				'label' => esc_html__( 'Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_slider_arrows',
			[
				'label'        => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_dots',
			[
				'label'        => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_loop',
			[
				'label'        => esc_html__( 'Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_slider_autoplay',
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
			'awea_slider_pause',
			[
				'label'        => esc_html__( 'Pause', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_slider_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_slider_autoplay_speed',
			[
				'label'     => esc_html__( 'Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8000,
				'min'       => 1000,
				'max'       => 20000,
				'step'      => 500,
				'condition' => [ 'awea_slider_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_slider_anim_speed',
			[
				'label'   => esc_html__( 'Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000,
				'min'     => 200,
				'max'     => 3000,
				'step'    => 100,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_slider_height',
			[
				'label'          => esc_html__( 'Height', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vh', 'em' ],
				'range'          => [
					'px' => [ 'min' => 300, 'max' => 1200 ],
					'vh' => [ 'min' => 40, 'max' => 100 ],
				],
				'default'        => [ 'unit' => 'vh', 'size' => 85 ],
				'tablet_default' => [ 'unit' => 'vh', 'size' => 70 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 520 ],
				'selectors'      => [
					'{{WRAPPER}} .awea-slide-box' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_overlay_background',
				'label'    => esc_html__( 'Overlay', 'awesome-widgets-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-slide-box::before',
			]
		);

		$this->add_control(
			'awea_overlay_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
				'default'   => [ 'size' => 0.55 ],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-box::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_slider_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [ 'top' => '140', 'right' => '60', 'bottom' => '140', 'left' => '60', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_slider_align',
			[
				'label'     => esc_html__( 'Align', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subtitle
		$this->add_control(
			'awea_heading_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-slide-subtitle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Title
		$this->add_control(
			'awea_heading_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-slide-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Description
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
				'default'   => 'rgba(255, 255, 255, 0.88)',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-slide-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_buttons',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_btn_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-slide-btn-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Primary Button
		$this->add_control(
			'awea_heading_btn1_style',
			[
				'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn1_typo',
				'selector' => '{{WRAPPER}} .awea-slide-btn-bg',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn1_tabs' );

		$this->start_controls_tab(
			'awea_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Secondary Button
		$this->add_control(
			'awea_heading_btn2_style',
			[
				'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn2_typo',
				'selector' => '{{WRAPPER}} .awea-slide-btn-border',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn2_tabs' );

		$this->start_controls_tab(
			'awea_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_btn2_border',
				'selector'       => '{{WRAPPER}} .awea-slide-btn-border',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.3)' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$slides    = $settings['awea_slides'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );

		if ( empty( $slides ) ) {
			return;
		}

		$arrows     = ( 'yes' === ( $settings['awea_slider_arrows'] ?? 'no' ) ) ? 'true' : 'false';
		$dots       = ( 'yes' === ( $settings['awea_slider_dots'] ?? 'no' ) ) ? 'true' : 'false';
		$loop       = ( 'yes' === ( $settings['awea_slider_loop'] ?? 'no' ) ) ? 'true' : 'false';
		$pause      = ( 'yes' === ( $settings['awea_slider_pause'] ?? 'no' ) ) ? 'true' : 'false';
		$autoplay   = ( 'yes' === ( $settings['awea_slider_autoplay'] ?? 'no' ) ) ? 'true' : 'false';
		$delay      = ! empty( $settings['awea_slider_autoplay_speed'] ) ? absint( $settings['awea_slider_autoplay_speed'] ) : 8000;
		$anim_speed = ! empty( $settings['awea_slider_anim_speed'] ) ? absint( $settings['awea_slider_anim_speed'] ) : 1000;
		$widget_id  = $this->get_id();
		?>
		<div class="awea-slider-wrap">
			<div class="awea-slider owl-carousel"
				 id="awea-hero-slider-<?php echo esc_attr( $widget_id ); ?>"
				 data-arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-dots="<?php echo esc_attr( $dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-delay="<?php echo esc_attr( (string) $delay ); ?>"
				 data-speed="<?php echo esc_attr( (string) $anim_speed ); ?>">

				<?php foreach ( $slides as $index => $slide ) :
					$img_url   = ! empty( $slide['awea_image']['url'] ) ? esc_url( $slide['awea_image']['url'] ) : '';
					$subtitle  = $slide['awea_subtitle'] ?? '';
					$title     = $slide['awea_title'] ?? '';
					$desc      = $slide['awea_desc'] ?? '';

					$btn1_text = $slide['awea_btn1_text'] ?? '';
					$btn2_text = $slide['awea_btn2_text'] ?? '';

					$btn1_key = 'awea_btn1_' . $index;
					$btn2_key = 'awea_btn2_' . $index;

					if ( ! empty( $slide['awea_btn1_url']['url'] ) ) {
						$this->add_link_attributes( $btn1_key, $slide['awea_btn1_url'] );
					}
					if ( ! empty( $slide['awea_btn2_url']['url'] ) ) {
						$this->add_link_attributes( $btn2_key, $slide['awea_btn2_url'] );
					}

					$this->add_render_attribute( $btn1_key, 'class', 'awea-slide-btn-bg' );
					$this->add_render_attribute( $btn2_key, 'class', 'awea-slide-btn-border' );
					?>
					<div class="awea-slide-box" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
						<div class="awea-slide-content">
							
							<?php if ( ! empty( $subtitle ) ) : ?>
								<span class="awea-slide-subtitle"><?php echo esc_html( $subtitle ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $title ) ) : ?>
								<<?php echo esc_attr( $title_tag ); ?> class="awea-slide-title">
									<?php echo wp_kses_post( $title ); ?>
								</<?php echo esc_attr( $title_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $desc ) ) : ?>
								<div class="awea-slide-desc">
									<?php echo wp_kses_post( $desc ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ( ! empty( $btn1_text ) && ! empty( $slide['awea_btn1_url']['url'] ) ) || ( ! empty( $btn2_text ) && ! empty( $slide['awea_btn2_url']['url'] ) ) ) : ?>
								<div class="awea-slide-btn-row">
									<?php if ( ! empty( $btn1_text ) && ! empty( $slide['awea_btn1_url']['url'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $btn1_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
											<span><?php echo esc_html( $btn1_text ); ?></span>
										</a>
									<?php endif; ?>

									<?php if ( ! empty( $btn2_text ) && ! empty( $slide['awea_btn2_url']['url'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $btn2_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
											<span><?php echo esc_html( $btn2_text ); ?></span>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-slider.default', function ($scope, $) {
				var $slider = $scope.find('.awea-slider');
				if (!$slider.length || typeof $slider.owlCarousel !== 'function') return;

				var showArrows = $slider.data('arrows') === true || $slider.data('arrows') === 'true';
				var showDots   = $slider.data('dots') === true || $slider.data('dots') === 'true';
				var loop       = $slider.data('loop') === true || $slider.data('loop') === 'true';
				var pauseHover = $slider.data('pause') === true || $slider.data('pause') === 'true';
				var autoplay   = $slider.data('autoplay') === true || $slider.data('autoplay') === 'true';
				var autoDelay  = parseInt($slider.data('delay'), 10) || 8000;
				var animSpeed  = parseInt($slider.data('speed'), 10) || 1000;

				$slider.owlCarousel({
					items: 1,
					nav: showArrows,
					dots: showDots,
					loop: loop,
					autoplay: autoplay,
					autoplayTimeout: autoDelay,
					smartSpeed: animSpeed,
					autoplayHoverPause: pauseHover,
					margin: 0,
					navText: [
						'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
						'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
					],
					responsive: {
						0: { items: 1, nav: false },
						769: { items: 1, nav: showArrows }
					}
				});
			});
		});
		</script>
		<?php
	}
}