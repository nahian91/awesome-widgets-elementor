<?php
/**
 * Awesome Step Flow Widget.
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

class Widget_Awesome_Step_Flow extends Widget_Base {

	public function get_name() {
		return 'awesome-step-flow';
	}

	public function get_title() {
		return esc_html__( 'Step Flow', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'step', 'flow', 'process', 'timeline', 'roadmap', 'workflow', 'how it works' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. PROCESS STEPS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_section_steps',
			[
				'label' => esc_html__( 'Process Steps', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_sf_step_tabs' );

		// --- TAB 1: DETAILS ---
		$repeater->start_controls_tab(
			'awea_sf_tab_details',
			[ 'label' => esc_html__( 'Details', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_sf_icon',
			[
				'label'   => esc_html__( 'Step Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-cube',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_sf_badge',
			[
				'label'       => esc_html__( 'Step Number', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_sf_title',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_sf_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Analyze core objectives and map user pathways across your product.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_sf_link',
			[
				'label'       => esc_html__( 'Step Link URL (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: COLORS ---
		$repeater->start_controls_tab(
			'awea_sf_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_sf_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Step', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_sf_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-sf-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_sf_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-sf-card-yes {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_sf_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-sf-card-yes {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_sf_steps',
			[
				'label'       => esc_html__( 'Steps List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_sf_badge }}} — {{{ awea_sf_title }}}',
				'default'     => [
					[
						'awea_sf_badge' => '01',
						'awea_sf_title' => esc_html__( 'Discovery', 'awesome-widgets-elementor' ),
						'awea_sf_desc'  => esc_html__( 'Analyze core objectives and map user pathways across your product.', 'awesome-widgets-elementor' ),
						'awea_sf_icon'  => [ 'value' => 'fas fa-cube', 'library' => 'fa-solid' ],
					],
					[
						'awea_sf_badge'         => '02',
						'awea_sf_title'         => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_sf_desc'          => esc_html__( 'Design modular workflows, state pipelines, and clean component systems.', 'awesome-widgets-elementor' ),
						'awea_sf_icon'          => [ 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ],
						'awea_sf_item_featured' => 'yes',
					],
					[
						'awea_sf_badge' => '03',
						'awea_sf_title' => esc_html__( 'Deployment', 'awesome-widgets-elementor' ),
						'awea_sf_desc'  => esc_html__( 'Ship to production with automated checks and real-time observability.', 'awesome-widgets-elementor' ),
						'awea_sf_icon'  => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_section_layout',
			[
				'label' => esc_html__( 'Layout & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_sf_direction',
			[
				'label'        => esc_html__( 'Flow Direction', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'horizontal',
				'toggle'       => false,
				'options'      => [
					'horizontal' => [
						'title' => esc_html__( 'Side by Side (Horizontal)', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-stretch',
					],
					'vertical'   => [
						'title' => esc_html__( 'Stacked (Vertical)', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-stretch',
					],
				],
				'prefix_class' => 'awea-sf-dir-',
			]
		);

		$this->add_control(
			'awea_sf_line_style',
			[
				'label'        => esc_html__( 'Connecting Line Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'beam',
				'options'      => [
					'beam'   => esc_html__( 'Animated Beam', 'awesome-widgets-elementor' ),
					'solid'  => esc_html__( 'Solid Line', 'awesome-widgets-elementor' ),
					'dashed' => esc_html__( 'Dashed Line', 'awesome-widgets-elementor' ),
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-sf-line-',
			]
		);

		$this->add_control(
			'awea_sf_icon_style',
			[
				'label'        => esc_html__( 'Icon Box Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'soft',
				'options'      => [
					'soft'     => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'solid'    => esc_html__( 'Solid Filled Box', 'awesome-widgets-elementor' ),
					'outlined' => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-sf-icon-',
			]
		);

		$this->add_control(
			'awea_sf_card_mode',
			[
				'label'        => esc_html__( 'Wrap Each Step in a Card', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'awea-sf-card-',
			]
		);

		$this->add_control(
			'awea_sf_hover_motion',
			[
				'label'        => esc_html__( 'Step Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-sf-motion-',
			]
		);

		$this->add_control(
			'awea_sf_title_tag',
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
		   STYLE: 1. LAYOUT & CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_style_layout',
			[
				'label' => esc_html__( 'Layout & Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_sf_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1400 ],
					'%'  => [ 'min' => 40, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1140 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sf_card_padding',
			[
				'label'      => esc_html__( 'Card Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '28',
					'right'    => '24',
					'bottom'   => '28',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition'  => [ 'awea_sf_card_mode' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-sf-card-yes .awea-sf-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sf_card_radius',
			[
				'label'      => esc_html__( 'Card Corner Roundness', 'awesome-widgets-elementor' ),
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
				'condition'  => [ 'awea_sf_card_mode' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-sf-card-yes .awea-sf-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'awea_sf_card_tabs',
			[ 'condition' => [ 'awea_sf_card_mode' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_sf_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_sf_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-sf-card-yes .awea-sf-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_sf_card_border',
				'selector'       => '{{WRAPPER}}.awea-sf-card-yes .awea-sf-item',
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
				'name'     => 'awea_sf_card_shadow',
				'selector' => '{{WRAPPER}}.awea-sf-card-yes .awea-sf-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_sf_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_sf_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-sf-card-yes .awea-sf-item:hover',
			]
		);

		$this->add_control(
			'awea_sf_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}}.awea-sf-card-yes .awea-sf-item:hover' => 'border-color: var(--awea-sf-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_sf_card_shadow_hover',
				'selector' => '{{WRAPPER}}.awea-sf-card-yes .awea-sf-item:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. CONNECTING LINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_style_line',
			[
				'label'     => esc_html__( 'Connecting Line', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_sf_line_style!' => 'none' ],
			]
		);

		$this->add_control(
			'awea_sf_track_color',
			[
				'label'     => esc_html__( 'Base Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sf-line' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_beam_color',
			[
				'label'     => esc_html__( 'Animated Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_sf_line_style' => 'beam' ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-beam' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sf_line_size',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-wrap' => '--awea-sf-line-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_beam_speed',
			[
				'label'      => esc_html__( 'Flow Speed (Seconds)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3 ],
				'condition'  => [ 'awea_sf_line_style' => 'beam' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-beam' => 'animation-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON BOX & BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_style_icon',
			[
				'label' => esc_html__( 'Icon Box & Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_sf_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 48, 'max' => 130 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 76 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-box'                        => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.awea-sf-dir-horizontal .awea-sf-line' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2);',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sf_box_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '18',
					'right'    => '18',
					'bottom'   => '18',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sf_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-sf-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_sf_icon_tabs' );

		$this->start_controls_tab(
			'awea_sf_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_sf_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-box'     => 'color: var(--awea-sf-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-sf-box svg' => 'fill: var(--awea-sf-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_sf_icon_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sf-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_sf_box_border',
				'selector' => '{{WRAPPER}} .awea-sf-box',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_sf_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_sf_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sf-item:hover .awea-sf-box'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-sf-item:hover .awea-sf-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-item:hover .awea-sf-box' => 'background-color: var(--awea-sf-item-accent, {{VALUE}}); border-color: var(--awea-sf-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'awea_sf_badge_heading',
			[
				'label'     => esc_html__( 'Step Number Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_sf_badge_size',
			[
				'label'      => esc_html__( 'Badge Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 46 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-num' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sf-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-num' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_badge_bg_hover',
			[
				'label'     => esc_html__( 'Hover Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-item:hover .awea-sf-num' => 'background-color: var(--awea-sf-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sf_badge_typo',
				'selector' => '{{WRAPPER}} .awea-sf-num',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_sf_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-num' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TEXT STYLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sf_style_text',
			[
				'label' => esc_html__( 'Text Style', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_sf_text_space',
			[
				'label'      => esc_html__( 'Space Below Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'condition'  => [ 'awea_sf_direction' => 'horizontal' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-sf-dir-horizontal .awea-sf-body' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_title_heading',
			[
				'label' => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_sf_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-title, {{WRAPPER}} .awea-sf-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-item:hover .awea-sf-title, {{WRAPPER}} .awea-sf-item:hover .awea-sf-title a' => 'color: var(--awea-sf-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sf_title_typo',
				'selector' => '{{WRAPPER}} .awea-sf-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_sf_title_shadow',
				'selector' => '{{WRAPPER}} .awea-sf-title',
			]
		);

		$this->add_responsive_control(
			'awea_sf_title_space',
			[
				'label'      => esc_html__( 'Space Below Heading', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sf-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sf_desc_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_sf_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-sf-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sf_desc_typo',
				'selector' => '{{WRAPPER}} .awea-sf-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$steps      = $settings['awea_sf_steps'] ?? [];
		$title_tag  = Utils::validate_html_tag( $settings['awea_sf_title_tag'] ?? 'h3' );
		$line_style = $settings['awea_sf_line_style'] ?? 'beam';

		if ( empty( $steps ) ) {
			return;
		}

		$total_steps = count( $steps );
		?>
		<div class="awea-sf-wrap">
			<?php foreach ( $steps as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$title    = $item['awea_sf_title'] ?? '';
				$badge    = $item['awea_sf_badge'] ?? '';
				$desc     = $item['awea_sf_desc'] ?? '';
				$featured = 'yes' === ( $item['awea_sf_item_featured'] ?? '' );
				$has_url  = ! empty( $item['awea_sf_link']['url'] );
				$link_key = 'awea_sf_link_' . $id;

				$title_key = $this->get_repeater_setting_key( 'awea_sf_title', 'awea_sf_steps', $index );
				$desc_key  = $this->get_repeater_setting_key( 'awea_sf_desc', 'awea_sf_steps', $index );

				$this->add_inline_editing_attributes( $title_key, 'none' );
				$this->add_inline_editing_attributes( $desc_key, 'basic' );

				$this->add_render_attribute( $title_key, 'class', 'awea-sf-title' );
				$this->add_render_attribute( $desc_key, 'class', 'awea-sf-desc' );

				if ( $has_url ) {
					$this->add_link_attributes( $link_key, $item['awea_sf_link'] );
				}

				$item_classes = [
					'awea-sf-item',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$item_classes[] = 'awea-sf-featured';
				}
				?>
				<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
					<div class="awea-sf-box">
						<?php
						if ( ! empty( $item['awea_sf_icon']['value'] ) ) {
							Icons_Manager::render_icon( $item['awea_sf_icon'], [ 'aria-hidden' => 'true' ] );
						}
						?>
						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-sf-num"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea-sf-body">
						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( $title_key ); ?>>
								<?php if ( $has_url ) : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<?php echo esc_html( $title ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $title ); ?>
								<?php endif; ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( 'none' !== $line_style && $index !== $total_steps - 1 ) : ?>
					<div class="awea-sf-line" aria-hidden="true">
						<?php if ( 'beam' === $line_style ) : ?>
							<div class="awea-sf-beam"></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var steps = settings.awea_sf_steps || [];
		if ( ! steps.length ) {
			return;
		}
		var tag       = elementor.helpers.validateHTMLTag( settings.awea_sf_title_tag || 'h3' );
		var lineStyle = settings.awea_sf_line_style || 'beam';
		#>
		<div class="awea-sf-wrap">
			<# _.each( steps, function( item, index ) {
				var iconHTML = elementor.helpers.renderIcon( view, item.awea_sf_icon, { 'aria-hidden': true }, 'i' , 'object' );
				var hasUrl   = item.awea_sf_link && item.awea_sf_link.url;
				var featCls  = 'yes' === item.awea_sf_item_featured ? ' awea-sf-featured' : '';
			#>
				<div class="awea-sf-item elementor-repeater-item-{{ item._id }}{{ featCls }}">
					<div class="awea-sf-box">
						<# if ( iconHTML && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# } #>
						<# if ( item.awea_sf_badge ) { #>
							<span class="awea-sf-num">{{ _.escape( item.awea_sf_badge ) }}</span>
						<# } #>
					</div>

					<div class="awea-sf-body">
						<# if ( item.awea_sf_title ) { #>
							<{{{ tag }}} class="awea-sf-title">
								<# if ( hasUrl ) { #>
									<a href="{{ item.awea_sf_link.url }}">{{ _.escape( item.awea_sf_title ) }}</a>
								<# } else { #>
									{{ _.escape( item.awea_sf_title ) }}
								<# } #>
							</{{{ tag }}}>
						<# } #>

						<# if ( item.awea_sf_desc ) { #>
							<p class="awea-sf-desc">{{{ item.awea_sf_desc }}}</p>
						<# } #>
					</div>
				</div>

				<# if ( 'none' !== lineStyle && index !== steps.length - 1 ) { #>
					<div class="awea-sf-line" aria-hidden="true">
						<# if ( 'beam' === lineStyle ) { #>
							<div class="awea-sf-beam"></div>
						<# } #>
					</div>
				<# } #>
			<# } ); #>
		</div>
		<?php
	}
}