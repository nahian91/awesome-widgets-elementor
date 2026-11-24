<?php
/**
 * Awesome List Group Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_List_Group extends Widget_Base {

	public function get_name() {
		return 'awesome-list-group';
	}

	public function get_title() {
		return esc_html__( 'List Group', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'list', 'group', 'features', 'checklist', 'directory', 'icon list', 'menu' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. LIST ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_section_items',
			[
				'label' => esc_html__( 'List Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_lg_repeater_tabs' );

		// --- TAB 1: DETAILS ---
		$repeater->start_controls_tab(
			'awea_lg_tab_content',
			[ 'label' => esc_html__( 'Details', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_lg_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_lg_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'SECURITY', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_lg_title',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'High-Throughput Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_lg_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Engineered for sub-millisecond responses and high concurrency with zero runtime overhead.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_lg_badge',
			[
				'label'       => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'New', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_lg_link',
			[
				'label'       => esc_html__( 'Click Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: COLORS ---
		$repeater->start_controls_tab(
			'awea_lg_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_lg_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Row', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_lg_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-lg-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_lg_item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-lg-icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-lg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_lg_item_icon_bg',
			[
				'label'     => esc_html__( 'Icon Box Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-lg-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_lg_item_badge_color',
			[
				'label'     => esc_html__( 'Tag Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-lg-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_lg_item_badge_bg',
			[
				'label'     => esc_html__( 'Tag Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-lg-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_lg_items',
			[
				'label'       => esc_html__( 'Row List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_lg_title }}}',
				'default'     => [
					[
						'awea_lg_title' => esc_html__( 'Sourced from Certified Partners', 'awesome-widgets-elementor' ),
						'awea_lg_desc'  => esc_html__( 'Direct procurement from verified sustainable farms and ethical suppliers globally.', 'awesome-widgets-elementor' ),
						'awea_lg_badge' => esc_html__( 'Verified', 'awesome-widgets-elementor' ),
						'awea_lg_icon'  => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
					],
					[
						'awea_lg_title'         => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ),
						'awea_lg_desc'          => esc_html__( 'Continuous metric reporting and end-to-end milestone notifications at every step.', 'awesome-widgets-elementor' ),
						'awea_lg_icon'          => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
						'awea_lg_item_featured' => 'yes',
					],
					[
						'awea_lg_title' => esc_html__( 'Automated Compliance Engine', 'awesome-widgets-elementor' ),
						'awea_lg_desc'  => esc_html__( 'Zero-friction validation against industry standards with encrypted record persistence.', 'awesome-widgets-elementor' ),
						'awea_lg_badge' => esc_html__( 'Core', 'awesome-widgets-elementor' ),
						'awea_lg_icon'  => [ 'value' => 'fas fa-microchip', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT & OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_section_layout',
			[
				'label' => esc_html__( 'Layout & Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_lg_mode',
			[
				'label'        => esc_html__( 'List Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'connected',
				'options'      => [
					'connected' => esc_html__( 'Single Box (Grouped Rows)', 'awesome-widgets-elementor' ),
					'separated' => esc_html__( 'Separate Cards', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-lg-mode-',
			]
		);

		$this->add_responsive_control(
			'awea_lg_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition'      => [ 'awea_lg_mode' => 'separated' ],
				'selectors'      => [
					'{{WRAPPER}}.awea-lg-mode-separated .awea-lg-wrap' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'awea_lg_icon_view',
			[
				'label'        => esc_html__( 'Icon Box Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'stacked' => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'solid'   => esc_html__( 'Solid Filled Box', 'awesome-widgets-elementor' ),
					'framed'  => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
					'minimal' => esc_html__( 'Plain Icon', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-lg-icon-',
			]
		);

		$this->add_control(
			'awea_lg_icon_align',
			[
				'label'     => esc_html__( 'Icon Vertical Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Middle', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-lg-item' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_lg_hover_motion',
			[
				'label'        => esc_html__( 'Row Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'slide',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'slide' => esc_html__( 'Nudge Right', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-lg-motion-',
			]
		);

		$this->add_control(
			'awea_lg_title_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
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

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. OUTER BOX (CONNECTED MODE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_style_container',
			[
				'label'     => esc_html__( 'Outer Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_lg_mode' => 'connected' ],
			]
		);

		$this->add_responsive_control(
			'awea_lg_box_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-lg-mode-connected .awea-lg-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_box_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-lg-mode-connected .awea-lg-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_lg_box_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-lg-mode-connected .awea-lg-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_lg_box_border',
				'selector'       => '{{WRAPPER}}.awea-lg-mode-connected .awea-lg-wrap',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_control(
			'awea_lg_divider_color',
			[
				'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-lg-mode-connected .awea-lg-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_lg_box_shadow',
				'selector' => '{{WRAPPER}}.awea-lg-mode-connected .awea-lg-wrap',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. LIST ROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_style_items',
			[
				'label' => esc_html__( 'List Rows', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_lg_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'condition'  => [ 'awea_lg_mode' => 'separated' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-lg-mode-separated .awea-lg-wrap' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'condition'  => [ 'awea_lg_mode' => 'separated' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-lg-mode-separated .awea-lg-wrap' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_item_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '22',
					'bottom'   => '20',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_item_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_lg_item_tabs' );

		$this->start_controls_tab(
			'awea_lg_item_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'awea_lg_item_bg_group',
				'types'     => [ 'classic', 'gradient' ],
				'condition' => [ 'awea_lg_mode' => 'separated' ],
				'selector'  => '{{WRAPPER}}.awea-lg-mode-separated .awea-lg-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_lg_item_border',
				'selector'       => '{{WRAPPER}}.awea-lg-mode-separated .awea-lg-item',
				'condition'      => [ 'awea_lg_mode' => 'separated' ],
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_lg_item_shadow',
				'selector'  => '{{WRAPPER}}.awea-lg-mode-separated .awea-lg-item',
				'condition' => [ 'awea_lg_mode' => 'separated' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_lg_item_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_lg_item_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-lg-item:hover',
			]
		);

		$this->add_control(
			'awea_lg_item_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_lg_mode' => 'separated' ],
				'selectors' => [
					'{{WRAPPER}}.awea-lg-mode-separated .awea-lg-item:hover' => 'border-color: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_lg_item_shadow_hover',
				'selector'  => '{{WRAPPER}}.awea-lg-mode-separated .awea-lg-item:hover',
				'condition' => [ 'awea_lg_mode' => 'separated' ],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_style_icon',
			[
				'label' => esc_html__( 'Icon Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_lg_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'condition'  => [ 'awea_lg_icon_view!' => 'minimal' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 42 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-lg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_icon_gap',
			[
				'label'      => esc_html__( 'Space Next to Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_icon_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [ 'awea_lg_icon_view!' => 'minimal' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_lg_icon_tabs' );

		$this->start_controls_tab(
			'awea_lg_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_lg_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-icon'     => 'color: var(--awea-lg-item-accent, {{VALUE}}); border-color: var(--awea-lg-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-lg-icon svg' => 'fill: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_lg_icon_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_lg_icon_view!' => 'minimal' ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_lg_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_lg_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-lg-item:hover .awea-lg-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-lg-item:hover .awea-lg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_lg_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_lg_icon_view!' => 'minimal' ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-item:hover .awea-lg-icon' => 'background-color: var(--awea-lg-item-accent, {{VALUE}}); border-color: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TEXT & TAG PILL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_lg_style_text',
			[
				'label' => esc_html__( 'Text & Tag Pill', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_lg_subtitle_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_lg_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-lg-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_lg_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-subtitle' => 'color: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_lg_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_lg_title_typo',
				'selector' => '{{WRAPPER}} .awea-lg-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_lg_title_shadow',
				'selector' => '{{WRAPPER}} .awea-lg-title',
			]
		);

		$this->add_control(
			'awea_lg_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_lg_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-item:hover .awea-lg-title' => 'color: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_title_space',
			[
				'label'      => esc_html__( 'Space Below Heading', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_lg_desc_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_lg_desc_typo',
				'selector' => '{{WRAPPER}} .awea-lg-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_lg_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_lg_badge_heading',
			[
				'label'     => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_lg_badge_typo',
				'selector' => '{{WRAPPER}} .awea-lg-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_lg_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-lg-badge' => 'color: var(--awea-lg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_lg_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-lg-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_badge_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_lg_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-lg-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_lg_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_lg_title_tag'] ?? 'h3' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-lg-wrap">
			<?php foreach ( $items as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$subtitle = $item['awea_lg_subtitle'] ?? '';
				$title    = $item['awea_lg_title'] ?? '';
				$desc     = $item['awea_lg_desc'] ?? '';
				$badge    = $item['awea_lg_badge'] ?? '';
				$featured = 'yes' === ( $item['awea_lg_item_featured'] ?? '' );
				$has_url  = ! empty( $item['awea_lg_link']['url'] );
				$link_key = 'awea_lg_link_' . $id;
				$tag      = $has_url ? 'a' : 'article';

				$subtitle_setting_key = $this->get_repeater_setting_key( 'awea_lg_subtitle', 'awea_lg_items', $index );
				$title_setting_key    = $this->get_repeater_setting_key( 'awea_lg_title', 'awea_lg_items', $index );
				$desc_setting_key     = $this->get_repeater_setting_key( 'awea_lg_desc', 'awea_lg_items', $index );
				$badge_setting_key    = $this->get_repeater_setting_key( 'awea_lg_badge', 'awea_lg_items', $index );

				$this->add_inline_editing_attributes( $subtitle_setting_key, 'none' );
				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );
				$this->add_inline_editing_attributes( $badge_setting_key, 'none' );

				$this->add_render_attribute( $subtitle_setting_key, 'class', 'awea-lg-subtitle' );
				$this->add_render_attribute( $title_setting_key, 'class', 'awea-lg-title' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-lg-desc' );
				$this->add_render_attribute( $badge_setting_key, 'class', 'awea-lg-badge' );

				$item_classes = [
					'awea-lg-item',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$item_classes[] = 'awea-lg-featured';
				}

				if ( $has_url ) {
					$this->add_link_attributes( $link_key, $item['awea_lg_link'] );
				}
				$this->add_render_attribute( $link_key, 'class', $item_classes );
				?>
				<<?php Utils::print_validated_html_tag( $tag ); ?> <?php $this->print_render_attribute_string( $link_key ); ?>>

					<?php if ( ! empty( $item['awea_lg_icon']['value'] ) ) : ?>
						<div class="awea-lg-icon" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_lg_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="awea-lg-body">
						<?php if ( ! empty( $subtitle ) ) : ?>
							<span <?php $this->print_render_attribute_string( $subtitle_setting_key ); ?>>
								<?php echo esc_html( $subtitle ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( $title_setting_key ); ?>>
								<?php echo esc_html( $title ); ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_setting_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $badge ) || $has_url ) : ?>
						<div class="awea-lg-meta">
							<?php if ( ! empty( $badge ) ) : ?>
								<span <?php $this->print_render_attribute_string( $badge_setting_key ); ?>>
									<?php echo esc_html( $badge ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $has_url ) : ?>
								<span class="awea-lg-arrow" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="9 18 15 12 9 6"></polyline>
									</svg>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				</<?php Utils::print_validated_html_tag( $tag ); ?>>
			<?php endforeach; ?>
		</div>
		<?php
	}
}