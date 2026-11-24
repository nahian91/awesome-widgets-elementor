<?php
/**
 * Awesome Counter Widget.
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

class Widget_Awesome_Counter extends Widget_Base {

	public function get_name() {
		return 'awesome-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'counter', 'stats', 'grid', 'metrics', 'odometer', 'number', 'kpi' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. COUNTER CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_section_items',
			[
				'label' => esc_html__( 'Counter Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_cnt_item_tabs' );

		// --- TAB 1: NUMBER ---
		$repeater->start_controls_tab(
			'awea_cnt_tab_number',
			[ 'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_cnt_start',
			[
				'label'   => esc_html__( 'Start From', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_cnt_target',
			[
				'label'   => esc_html__( 'Count To', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_cnt_decimals',
			[
				'label'   => esc_html__( 'Decimal Places', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 4,
				'step'    => 1,
				'default' => 0,
			]
		);

		$repeater->add_control(
			'awea_cnt_prefix',
			[
				'label'       => esc_html__( 'Before Number', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => '$',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_cnt_suffix',
			[
				'label'       => esc_html__( 'After Number', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '+',
				'placeholder' => '+',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_cnt_duration',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
				'default' => 2200,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_cnt_tab_content',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_cnt_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_cnt_title',
			[
				'label'       => esc_html__( 'Main Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_cnt_subtext',
			[
				'label'       => esc_html__( 'Extra Note', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Verified Q4 metrics', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: COLORS ---
		$repeater->start_controls_tab(
			'awea_cnt_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_cnt_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Card', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_cnt_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-cnt-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_cnt_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_cnt_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_cnt_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_cnt_prefix }}}{{{ awea_cnt_target }}}{{{ awea_cnt_suffix }}} — {{{ awea_cnt_title }}}',
				'default'     => [
					[
						'awea_cnt_target' => 150,
						'awea_cnt_suffix' => '+',
						'awea_cnt_title'  => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
						'awea_cnt_icon'   => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
					],
					[
						'awea_cnt_target'        => 99.9,
						'awea_cnt_decimals'      => 1,
						'awea_cnt_suffix'        => '%',
						'awea_cnt_title'         => esc_html__( 'Uptime SLA Guarantee', 'awesome-widgets-elementor' ),
						'awea_cnt_icon'          => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
						'awea_cnt_item_featured' => 'yes',
					],
					[
						'awea_cnt_prefix' => '$',
						'awea_cnt_target' => 45,
						'awea_cnt_suffix' => 'M',
						'awea_cnt_title'  => esc_html__( 'Client Revenue Generated', 'awesome-widgets-elementor' ),
						'awea_cnt_icon'   => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_section_layout',
			[
				'label' => esc_html__( 'Grid & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_cnt_columns',
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
					'{{WRAPPER}} .awea-cnt-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cnt_card_direction',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'vertical',
				'options'      => [
					'vertical'   => esc_html__( 'Stacked (Icon Top)', 'awesome-widgets-elementor' ),
					'horizontal' => esc_html__( 'Side by Side (Icon Left)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cnt-dir-',
			]
		);

		$this->add_control(
			'awea_cnt_icon_style',
			[
				'label'        => esc_html__( 'Icon Box Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'soft',
				'options'      => [
					'soft'     => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'solid'    => esc_html__( 'Solid Filled Box', 'awesome-widgets-elementor' ),
					'outlined' => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
					'minimal'  => esc_html__( 'Plain Icon', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cnt-icon-',
			]
		);

		$this->add_control(
			'awea_cnt_thousand_sep',
			[
				'label'        => esc_html__( 'Comma Separator (1,000)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cnt_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cnt-motion-',
			]
		);

		$this->add_control(
			'awea_cnt_beam_enable',
			[
				'label'        => esc_html__( 'Animated Border Glow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-cnt-beam-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cnt_card_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'center',
				'condition'            => [ 'awea_cnt_card_direction' => 'vertical' ],
				'selectors_dictionary' => [
					'left'   => 'align-items: flex-start; text-align: left;',
					'center' => 'align-items: center; text-align: center;',
					'right'  => 'align-items: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-cnt-card' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '36',
					'right'    => '28',
					'bottom'   => '36',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_card_radius',
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
					'{{WRAPPER}} .awea-cnt-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cnt_beam_color',
			[
				'label'     => esc_html__( 'Border Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_cnt_beam_enable' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-card' => '--awea-cnt-beam: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cnt_card_tabs' );

		$this->start_controls_tab(
			'awea_cnt_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cnt_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cnt-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cnt_card_border',
				'selector'       => '{{WRAPPER}} .awea-cnt-card',
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
				'name'     => 'awea_cnt_card_shadow',
				'selector' => '{{WRAPPER}} .awea-cnt-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cnt_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cnt_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cnt-card:hover',
			]
		);

		$this->add_control(
			'awea_cnt_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-card:hover' => 'border-color: var(--awea-cnt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cnt_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-cnt-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ICON BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_style_icon',
			[
				'label' => esc_html__( 'Icon Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cnt_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 58 ],
				'condition'  => [ 'awea_cnt_icon_style!' => 'minimal' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-cnt-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_icon_space',
			[
				'label'      => esc_html__( 'Space Around Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}}.awea-cnt-dir-vertical .awea-cnt-icon'   => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0;',
					'{{WRAPPER}}.awea-cnt-dir-horizontal .awea-cnt-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cnt_icon_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [ 'awea_cnt_icon_style!' => 'minimal' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cnt_icon_tabs' );

		$this->start_controls_tab(
			'awea_cnt_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cnt_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-icon'     => 'color: var(--awea-cnt-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-cnt-icon svg' => 'fill: var(--awea-cnt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_cnt_icon_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_cnt_icon_style!' => 'minimal' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cnt_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cnt_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cnt_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_cnt_icon_style!' => 'minimal' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon' => 'background-color: var(--awea-cnt-item-accent, {{VALUE}}); border-color: var(--awea-cnt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. NUMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_style_number',
			[
				'label' => esc_html__( 'Numbers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cnt_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cnt_num_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-val',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_cnt_num_shadow',
				'selector' => '{{WRAPPER}} .awea-cnt-val',
			]
		);

		$this->add_responsive_control(
			'awea_cnt_num_space',
			[
				'label'      => esc_html__( 'Space Below Number', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-stats' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cnt_affix_heading',
			[
				'label'     => esc_html__( 'Before & After Symbols', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cnt_affix_color',
			[
				'label'     => esc_html__( 'Symbol Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-pre, {{WRAPPER}} .awea-cnt-suf' => 'color: var(--awea-cnt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cnt_affix_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-pre, {{WRAPPER}} .awea-cnt-suf',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. LABELS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cnt_style_label',
			[
				'label' => esc_html__( 'Labels & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cnt_label_color',
			[
				'label'     => esc_html__( 'Main Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-lbl' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cnt_label_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-lbl',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_cnt_subtext_heading',
			[
				'label'     => esc_html__( 'Extra Note', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cnt_subtext_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cnt_subtext_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-subtext',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$items        = $settings['awea_cnt_items'] ?? [];
		$use_grouping = 'yes' === ( $settings['awea_cnt_thousand_sep'] ?? 'yes' );
		$widget_id    = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-cnt-grid" id="awea-cnt-<?php echo esc_attr( $widget_id ); ?>">
			<?php foreach ( $items as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$start    = '' !== ( $item['awea_cnt_start'] ?? '' ) ? floatval( $item['awea_cnt_start'] ) : 0;
				$target   = '' !== ( $item['awea_cnt_target'] ?? '' ) ? floatval( $item['awea_cnt_target'] ) : 0;
				$decimals = ! empty( $item['awea_cnt_decimals'] ) ? absint( $item['awea_cnt_decimals'] ) : 0;
				$duration = ! empty( $item['awea_cnt_duration'] ) ? absint( $item['awea_cnt_duration'] ) : 2200;
				$prefix   = $item['awea_cnt_prefix'] ?? '';
				$suffix   = $item['awea_cnt_suffix'] ?? '';
				$title    = $item['awea_cnt_title'] ?? '';
				$subtext  = $item['awea_cnt_subtext'] ?? '';
				$featured = 'yes' === ( $item['awea_cnt_item_featured'] ?? '' );
				$has_icon = ! empty( $item['awea_cnt_icon']['value'] );

				$title_setting_key   = $this->get_repeater_setting_key( 'awea_cnt_title', 'awea_cnt_items', $index );
				$subtext_setting_key = $this->get_repeater_setting_key( 'awea_cnt_subtext', 'awea_cnt_items', $index );

				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $subtext_setting_key, 'none' );

				$this->add_render_attribute( $title_setting_key, 'class', 'awea-cnt-lbl' );
				$this->add_render_attribute( $subtext_setting_key, 'class', 'awea-cnt-subtext' );

				$card_classes = [
					'awea-cnt-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$card_classes[] = 'awea-cnt-featured';
				}

				$card_key = 'awea_cnt_card_' . $id;
				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_render_attribute( $card_key, 'data-start', (string) $start );
				$this->add_render_attribute( $card_key, 'data-target', (string) $target );
				$this->add_render_attribute( $card_key, 'data-decimals', (string) $decimals );
				$this->add_render_attribute( $card_key, 'data-duration', (string) $duration );
				$this->add_render_attribute( $card_key, 'data-grouping', $use_grouping ? '1' : '0' );

				$formatted_start = $use_grouping
					? number_format( $start, $decimals, '.', ',' )
					: number_format( $start, $decimals, '.', '' );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<?php if ( $has_icon ) : ?>
						<div class="awea-cnt-icon" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_cnt_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="awea-cnt-content">
						<div class="awea-cnt-stats">
							<?php if ( ! empty( $prefix ) ) : ?>
								<span class="awea-cnt-pre"><?php echo esc_html( $prefix ); ?></span>
							<?php endif; ?>

							<span class="awea-cnt-val"><?php echo esc_html( $formatted_start ); ?></span>

							<?php if ( ! empty( $suffix ) ) : ?>
								<span class="awea-cnt-suf"><?php echo esc_html( $suffix ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $title ) ) : ?>
							<p <?php $this->print_render_attribute_string( $title_setting_key ); ?>>
								<?php echo esc_html( $title ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $subtext ) ) : ?>
							<span <?php $this->print_render_attribute_string( $subtext_setting_key ); ?>>
								<?php echo esc_html( $subtext ); ?>
							</span>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

		<script>
		(function() {
			function initCounters() {
				var grid = document.getElementById('awea-cnt-<?php echo esc_js( $widget_id ); ?>');
				if (!grid || grid.dataset.aweaBound === '1') return;
				grid.dataset.aweaBound = '1';

				var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
				var cards = grid.querySelectorAll('.awea-cnt-card');

				cards.forEach(function(card) {
					var valEl = card.querySelector('.awea-cnt-val');
					if (!valEl) return;

					var start    = parseFloat(card.getAttribute('data-start')) || 0;
					var target   = parseFloat(card.getAttribute('data-target')) || 0;
					var decimals = parseInt(card.getAttribute('data-decimals'), 10) || 0;
					var duration = parseInt(card.getAttribute('data-duration'), 10) || 2200;
					var grouping = card.getAttribute('data-grouping') === '1';
					var started  = false;

					function formatNumber(num) {
						return num.toLocaleString('en-US', {
							useGrouping: grouping,
							minimumFractionDigits: decimals,
							maximumFractionDigits: decimals
						});
					}

					function runCount() {
						if (started) return;
						started = true;

						if (reduceMotion) {
							valEl.textContent = formatNumber(target);
							return;
						}

						var startTime = null;

						function step(timestamp) {
							if (!document.body.contains(card)) return;
							if (!startTime) startTime = timestamp;
							var elapsed  = timestamp - startTime;
							var progress = Math.min(elapsed / duration, 1);
							var eased    = 1 - Math.pow(1 - progress, 3);
							var current  = start + (target - start) * eased;

							valEl.textContent = formatNumber(current);

							if (progress < 1) {
								requestAnimationFrame(step);
							} else {
								valEl.textContent = formatNumber(target);
							}
						}

						requestAnimationFrame(step);
					}

					if ('IntersectionObserver' in window) {
						var observer = new IntersectionObserver(function(entries) {
							entries.forEach(function(entry) {
								if (entry.isIntersecting) {
									runCount();
									observer.disconnect();
								}
							});
						}, { threshold: 0.15 });
						observer.observe(card);
					} else {
						runCount();
					}
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initCounters);
			} else {
				initCounters();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-counter.default', initCounters);
			}
		})();
		</script>
		<?php
	}
}