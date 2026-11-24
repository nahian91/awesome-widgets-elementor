<?php
/**
 * Awesome Team Carousel Studio Widget (Zero-Shadow Architectural Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since 2.0.0
 */

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
		   CONTENT: 1. ITEMS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_member_tabs' );

		// --- TAB 1: PROFILE ---
		$repeater->start_controls_tab(
			'awea_tab_profile',
			[ 'label' => esc_html__( 'Profile', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image',
			[
				'label'   => esc_html__( 'Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_name',
			[
				'label'       => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_role',
			[
				'label'       => esc_html__( 'Role', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_bio',
			[
				'label'       => esc_html__( 'Bio', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Pioneering clean architectural design systems and kinetic user interfaces.', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: SOCIALS ---
		$repeater->start_controls_tab(
			'awea_tab_socials',
			[ 'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ln_url',
			[
				'label'       => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://linkedin.com/in/username',
			]
		);

		$repeater->add_control(
			'awea_tw_url',
			[
				'label'       => esc_html__( 'X (Twitter)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://x.com/username',
			]
		);

		$repeater->add_control(
			'awea_fb_url',
			[
				'label'       => esc_html__( 'Facebook', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://facebook.com/username',
			]
		);

		$repeater->add_control(
			'awea_insta_url',
			[
				'label'       => esc_html__( 'Instagram', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://instagram.com/username',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_members',
			[
				'label'       => esc_html__( 'List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_name }}} — {{{ awea_role }}}',
				'default'     => [
					[
						'awea_name' => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
						'awea_role' => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
						'awea_bio'  => esc_html__( 'Pioneering clean architectural design systems and kinetic interfaces.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_name' => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_role' => esc_html__( 'Senior Product Designer', 'awesome-widgets-elementor' ),
						'awea_bio'  => esc_html__( 'Specializing in design tokens, accessible color theory, and user journeys.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_name' => esc_html__( 'Julian Szekeres', 'awesome-widgets-elementor' ),
						'awea_role' => esc_html__( 'Core Systems Engineer', 'awesome-widgets-elementor' ),
						'awea_bio'  => esc_html__( 'Optimizing micro-service pipelines and real-time state hydration routines.', 'awesome-widgets-elementor' ),
					],
				],
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
			'awea_name_tag',
			[
				'label'   => esc_html__( 'Title Tag', 'awesome-widgets-elementor' ),
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
			'awea_social_always_visible',
			[
				'label'        => esc_html__( 'Show Socials', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Always', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SLIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_slider',
			[
				'label' => esc_html__( 'Slider', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_slides_to_show',
			[
				'label'          => esc_html__( 'Slides', 'awesome-widgets-elementor' ),
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
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_show_arrows',
			[
				'label'        => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_show_dots',
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
			'awea_loop',
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
			'awea_autoplay_speed',
			[
				'label'     => esc_html__( 'Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'condition' => [ 'awea_autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_aspect_ratio',
			[
				'label'     => esc_html__( 'Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1',
					'4/5'  => '4:5',
					'3/4'  => '3:4',
					'16/9' => '16:9',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-team-img-container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
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
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-master-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_tabs' );

		$this->start_controls_tab(
			'awea_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
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
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-team-master-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.08)' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#090d16',
				'selectors' => [
					'{{WRAPPER}} .awea-team-master-card:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-team-master-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. DOCK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_dock',
			[
				'label' => esc_html__( 'Dock', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_dock_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
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
				'name'           => 'awea_dock_border',
				'selector'       => '{{WRAPPER}} .awea-team-info-panel',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.14)' ],
				],
			]
		);

		$this->add_responsive_control(
			'awea_dock_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-info-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_dock_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-info-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'awesome-widgets-elementor' ),
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
				'selector' => '{{WRAPPER}} .awea-team-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_role_color',
			[
				'label'     => esc_html__( 'Role Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-team-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_role_typo',
				'selector' => '{{WRAPPER}} .awea-team-role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_bio_color',
			[
				'label'     => esc_html__( 'Bio Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-team-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bio_typo',
				'selector' => '{{WRAPPER}} .awea-team-bio',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. ARROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_arrow_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
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
				'name'           => 'awea_arrow_border',
				'selector'       => '{{WRAPPER}} .awea-carousel-arrow-border',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_dots_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
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
		$settings       = $this->get_settings_for_display();
		$members        = $settings['awea_members'] ?? [];
		$items_desktop  = ! empty( $settings['awea_slides_to_show'] ) ? (int) $settings['awea_slides_to_show'] : 3;
		$items_tablet   = ! empty( $settings['awea_slides_to_show_tablet'] ) ? (int) $settings['awea_slides_to_show_tablet'] : 2;
		$items_mobile   = ! empty( $settings['awea_slides_to_show_mobile'] ) ? (int) $settings['awea_slides_to_show_mobile'] : 1;

		$gap_desktop    = isset( $settings['awea_slide_gap']['size'] ) ? (int) $settings['awea_slide_gap']['size'] : 24;
		$gap_tablet     = isset( $settings['awea_slide_gap_tablet']['size'] ) ? (int) $settings['awea_slide_gap_tablet']['size'] : 20;
		$gap_mobile     = isset( $settings['awea_slide_gap_mobile']['size'] ) ? (int) $settings['awea_slide_gap_mobile']['size'] : 16;

		$show_arrows    = ( 'yes' === ( $settings['awea_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$show_dots      = ( 'yes' === ( $settings['awea_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop           = ( 'yes' === ( $settings['awea_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay       = ( 'yes' === ( $settings['awea_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause          = ( 'yes' === ( $settings['awea_pause_on_hover'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed     = ! empty( $settings['awea_autoplay_speed'] ) ? (int) $settings['awea_autoplay_speed'] : 5000;
		$anim_speed     = ! empty( $settings['awea_animation_speed'] ) ? (int) $settings['awea_animation_speed'] : 450;

		$always_visible = ( 'yes' === ( $settings['awea_social_always_visible'] ?? 'no' ) );
		$name_tag       = Utils::validate_html_tag( $settings['awea_name_tag'] ?? 'h3' );

		if ( empty( $members ) ) {
			return;
		}

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

				<?php foreach ( $members as $index => $member ) :
					$id        = $member['_id'] ?? $index;
					$image_url = ! empty( $member['awea_image']['url'] ) ? esc_url( $member['awea_image']['url'] ) : Utils::get_placeholder_image_src();
					$name      = ! empty( $member['awea_name'] ) ? esc_html( $member['awea_name'] ) : '';
					$role      = ! empty( $member['awea_role'] ) ? esc_html( $member['awea_role'] ) : '';
					$bio       = ! empty( $member['awea_bio'] ) ? esc_html( $member['awea_bio'] ) : '';

					$socials = [];
					foreach ( [ 'ln', 'tw', 'fb', 'insta' ] as $soc_key ) {
						$url_data = $member[ 'awea_' . $soc_key . '_url' ] ?? [];
						if ( ! empty( $url_data['url'] ) ) {
							$brands = [
								'ln'    => [ 'icon' => 'fab fa-linkedin-in', 'title' => 'LinkedIn', 'brand' => '#0a66c2' ],
								'tw'    => [ 'icon' => 'fab fa-x-twitter', 'title' => 'X (Twitter)', 'brand' => '#000000' ],
								'fb'    => [ 'icon' => 'fab fa-facebook-f', 'title' => 'Facebook', 'brand' => '#1877f2' ],
								'insta' => [ 'icon' => 'fab fa-instagram', 'title' => 'Instagram', 'brand' => '#e4405f' ],
							];
							$socials[] = [
								'url'   => $url_data['url'],
								'icon'  => $brands[ $soc_key ]['icon'],
								'title' => $brands[ $soc_key ]['title'],
								'brand' => $brands[ $soc_key ]['brand'],
								'key'   => 'soc_' . $id . '_' . $soc_key,
							];
						}
					}
					?>
					<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
						<div class="awea-team-img-container">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
							<div class="awea-team-scrim" aria-hidden="true"></div>
						</div>

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

							<?php if ( ! empty( $socials ) ) : ?>
								<div class="awea-team-social-dock">
									<?php foreach ( $socials as $soc ) :
										$this->add_link_attributes( $soc['key'], [ 'url' => $soc['url'] ] );
										$this->add_render_attribute( $soc['key'], 'class', 'awea-team-social-btn' );
										$this->add_render_attribute( $soc['key'], 'aria-label', esc_attr( $soc['title'] ) );
										$this->add_render_attribute( $soc['key'], 'style', '--awea-social-brand: ' . esc_attr( $soc['brand'] ) . ';' );
										?>
										<a <?php $this->print_render_attribute_string( $soc['key'] ); ?>>
											<i class="<?php echo esc_attr( $soc['icon'] ); ?>" aria-hidden="true"></i>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-team-carousel.default', function ($scope,$) {
				var $carousel = $scope.find('.awea-team-carousel');
				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

				var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10) || 24;
				var gapTablet    = parseInt($carousel.data('gap-tablet'), 10) || 20;
				var gapMobile    = parseInt($carousel.data('gap-mobile'), 10) || 16;

				$carousel.owlCarousel({
					nav: $carousel.data('arrows') === 'yes',
					dots: $carousel.data('dots') === 'yes',
					loop: $carousel.data('loop') === 'yes',
					autoplay: $carousel.data('autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.data('timeout'), 10) || 5000,
					smartSpeed: parseInt($carousel.data('speed'), 10) || 450,
					autoplayHoverPause: $carousel.data('pause') === 'yes',
					navText: [
						'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
						'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
					],
					responsive: {
						0: { items: itemsMobile, margin: gapMobile },
						768: { items: itemsTablet, margin: gapTablet },
						1025: { items: itemsDesktop, margin: gapDesktop }
					}
				});
			});
		});
		</script>
		<?php
	}
}