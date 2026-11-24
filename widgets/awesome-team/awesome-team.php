<?php
/**
 * Awesome Team Studio Widget (Zero-Shadow Repeater Grid Edition).
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
		return [ 'awea', 'team', 'members', 'grid', 'profile', 'staff', 'card' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. MEMBERS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_members',
			[
				'label' => esc_html__( 'Members', 'awesome-widgets-elementor' ),
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
			'awea_photo',
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
			'awea_badge',
			[
				'label'       => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Leadership', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
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
				'label'   => esc_html__( 'Bio', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Pioneering clean architectural design systems and responsive user interfaces.', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: SOCIALS ---
		$repeater->start_controls_tab(
			'awea_tab_socials',
			[ 'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_soc1_icon',
			[
				'label'   => esc_html__( 'Icon 1', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [ 'value' => 'fab fa-linkedin-in', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_soc1_url',
			[
				'label'       => esc_html__( 'Link 1', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://linkedin.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_soc2_icon',
			[
				'label'     => esc_html__( 'Icon 2', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => [ 'value' => 'fab fa-x-twitter', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_soc2_url',
			[
				'label'       => esc_html__( 'Link 2', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://x.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_soc3_icon',
			[
				'label'     => esc_html__( 'Icon 3', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => [ 'value' => 'fab fa-github', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_soc3_url',
			[
				'label'       => esc_html__( 'Link 3', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://github.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_soc4_icon',
			[
				'label'     => esc_html__( 'Icon 4', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'awea_soc4_url',
			[
				'label'       => esc_html__( 'Link 4', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_members',
			[
				'label'       => esc_html__( 'Team List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_name }}} — {{{ awea_role }}}',
				'default'     => [
					[
						'awea_badge' => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_name'  => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
						'awea_role'  => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
						'awea_bio'   => esc_html__( 'Pioneering clean architectural design systems and responsive user interfaces.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_badge' => esc_html__( 'Engineering', 'awesome-widgets-elementor' ),
						'awea_name'  => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_role'  => esc_html__( 'Principal Systems Engineer', 'awesome-widgets-elementor' ),
						'awea_bio'   => esc_html__( 'Building sub-millisecond frontend architectures and scalable cloud workflows.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_badge' => esc_html__( 'Product', 'awesome-widgets-elementor' ),
						'awea_name'  => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_role'  => esc_html__( 'Head of Product Strategy', 'awesome-widgets-elementor' ),
						'awea_bio'   => esc_html__( 'Turning complex customer problems into intuitive, high-impact digital products.', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_card_style',
			[
				'label'        => esc_html__( 'Card Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'overlay',
				'options'      => [
					'overlay'   => esc_html__( 'Glass Overlay', 'awesome-widgets-elementor' ),
					'editorial' => esc_html__( 'Editorial Card', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tm-style-',
			]
		);

		$this->add_responsive_control(
			'awea_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-tm-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_img_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_img_ratio',
			[
				'label'     => esc_html__( 'Photo Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1',
					'4/5'  => '4:5',
					'3/4'  => '3:4',
					'16/9' => '16:9',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-media' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dock_visible',
			[
				'label'        => esc_html__( 'Always Show Socials', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'awea_card_style' => 'overlay' ],
				'prefix_class' => 'awea-tm-dock-open-',
			]
		);

		$this->add_control(
			'awea_name_tag',
			[
				'label'   => esc_html__( 'Name Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
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
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '26', 'right' => '26', 'bottom' => '26', 'left' => '26', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_photo_radius',
			[
				'label'      => esc_html__( 'Photo Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-tm-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-tm-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
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
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea-tm-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. INFO PANEL (GLASS OVERLAY MODE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_panel',
			[
				'label'     => esc_html__( 'Info Dock', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_card_style' => 'overlay' ],
			]
		);

		$this->add_control(
			'awea_dock_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dock_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.16)',
				'selectors' => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_dock_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_name_heading',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_name_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-name' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_name_typo',
				'selector' => '{{WRAPPER}} .awea-tm-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_role_heading',
			[
				'label'     => esc_html__( 'Role', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_role_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-role' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_role_typo',
				'selector' => '{{WRAPPER}} .awea-tm-role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_bio_heading',
			[
				'label'     => esc_html__( 'Bio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_bio_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-bio' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bio_typo',
				'selector' => '{{WRAPPER}} .awea-tm-bio',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. SOCIALS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_socials',
			[
				'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_soc_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 28, 'max' => 54 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 36 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_soc_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 26 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-soc-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-tm-soc-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_soc_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-socials' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_soc_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_soc_tabs' );

		$this->start_controls_tab(
			'awea_soc_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_soc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'awea_soc_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_soc_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_soc_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'awea_soc_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn:hover' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$members  = $settings['awea_members'] ?? [];
		$name_tag = Utils::validate_html_tag( $settings['awea_name_tag'] ?? 'h3' );

		if ( empty( $members ) ) {
			return;
		}
		?>
		<div class="awea-tm-grid">
			<?php foreach ( $members as $index => $member ) :
				$id    = $member['_id'] ?? $index;
				$badge = $member['awea_badge'] ?? '';
				$name  = $member['awea_name'] ?? '';
				$role  = $member['awea_role'] ?? '';
				$bio   = $member['awea_bio'] ?? '';

				$img_data = [
					'awea_photo'                     => $member['awea_photo'] ?? [],
					'awea_img_size_size'             => $settings['awea_img_size_size'] ?? 'large',
					'awea_img_size_custom_dimension' => $settings['awea_img_size_custom_dimension'] ?? [],
				];

				// Collect active social links (1..4)
				$socials = [];
				for ( $s = 1; $s <= 4; $s++ ) {
					$ico = $member[ "awea_soc{$s}_icon" ] ?? [];
					$url = $member[ "awea_soc{$s}_url" ] ?? [];
					if ( ! empty( $ico['value'] ) && ! empty( $url['url'] ) ) {
						$socials[] = [
							'icon' => $ico,
							'url'  => $url,
							'key'  => "soc_{$id}_{$s}",
						];
					}
				}
				?>
				<article class="awea-tm-card elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

					<div class="awea-tm-media">
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_img_size', 'awea_photo' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div class="awea-tm-scrim" aria-hidden="true"></div>

						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-tm-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea-tm-panel">
						<?php if ( ! empty( $name ) ) : ?>
							<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea-tm-name">
								<?php echo esc_html( $name ); ?>
							</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $role ) ) : ?>
							<span class="awea-tm-role"><?php echo esc_html( $role ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $bio ) ) : ?>
							<p class="awea-tm-bio"><?php echo esc_html( $bio ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $socials ) ) : ?>
							<div class="awea-tm-socials">
								<?php foreach ( $socials as $soc ) :
									$this->add_link_attributes( $soc['key'], $soc['url'] );
									$this->add_render_attribute( $soc['key'], 'class', 'awea-tm-soc-btn' );
									$this->add_render_attribute( $soc['key'], 'aria-label', esc_attr( $name ) );
									?>
									<a <?php $this->print_render_attribute_string( $soc['key'] ); ?>>
										<?php Icons_Manager::render_icon( $soc['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}