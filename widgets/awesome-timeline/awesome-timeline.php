<?php
/**
 * Awesome Timeline Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class Widget_Awesome_Timeline extends Widget_Base {

	public function get_name() {
		return 'awesome-timeline';
	}

	public function get_title() {
		return esc_html__( 'Timeline', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'timeline', 'roadmap', 'history', 'steps', 'process', 'milestones' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. MILESTONES (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Milestones', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_item_tabs' );

		// --- TAB 1: CONTENT ---
		$repeater->start_controls_tab(
			'awea_tab_content',
			[ 'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tag',
			[
				'label'       => esc_html__( 'Tag / Date', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Phase 01', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery & Deep Audit', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Exhaustive architectural review across existing database schemas, APIs, and frontend rendering pipelines.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_link_text',
			[
				'label'       => esc_html__( 'Link Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'View Details', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_link_url',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_link_text!' => '' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: MEDIA & ICON ---
		$repeater->start_controls_tab(
			'awea_tab_media',
			[ 'label' => esc_html__( 'Media', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon',
			[
				'label'   => esc_html__( 'Node Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_image',
			[
				'label'   => esc_html__( 'Card Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_item_accent',
			[
				'label'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-tl-tag' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-tl-dot' => 'border-color: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-tl-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_items',
			[
				'label'       => esc_html__( 'Milestones List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_tag }}} — {{{ awea_title }}}',
				'default'     => [
					[
						'awea_tag'   => esc_html__( 'Phase 01', 'awesome-widgets-elementor' ),
						'awea_title' => esc_html__( 'Discovery & Deep Audit', 'awesome-widgets-elementor' ),
						'awea_desc'  => esc_html__( 'Exhaustive architectural review across existing database schemas, APIs, and frontend rendering pipelines.', 'awesome-widgets-elementor' ),
						'awea_icon'  => [ 'value' => 'fas fa-search', 'library' => 'fa-solid' ],
					],
					[
						'awea_tag'   => esc_html__( 'Phase 02', 'awesome-widgets-elementor' ),
						'awea_title' => esc_html__( 'Structural Logic Mapping', 'awesome-widgets-elementor' ),
						'awea_desc'  => esc_html__( 'Defining modular application foundations, relational schemas, user journey nodes, and service connectivity.', 'awesome-widgets-elementor' ),
						'awea_icon'  => [ 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ],
					],
					[
						'awea_tag'   => esc_html__( 'Phase 03', 'awesome-widgets-elementor' ),
						'awea_title' => esc_html__( 'System Deployment & QA', 'awesome-widgets-elementor' ),
						'awea_desc'  => esc_html__( 'Zero-downtime transition to production infrastructure backed by automated stress and security audits.', 'awesome-widgets-elementor' ),
						'awea_icon'  => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
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
			'awea_layout_mode',
			[
				'label'        => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'alternating',
				'options'      => [
					'alternating' => esc_html__( 'Alternating', 'awesome-widgets-elementor' ),
					'left'        => esc_html__( 'Left Spine', 'awesome-widgets-elementor' ),
					'right'       => esc_html__( 'Right Spine', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tl-mode-',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_img_size',
				'default' => 'large',
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
			'awea_scroll_anim',
			[
				'label'        => esc_html__( 'Scroll Reveal', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-tl-anim-',
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
			'awea_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 360, 'max' => 1500 ],
					'%'  => [ 'min' => 40, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1060 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_row_gap',
			[
				'label'      => esc_html__( 'Row Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_spine_gap',
			[
				'label'      => esc_html__( 'Spine Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}}.awea-tl-mode-alternating .awea-tl-item:nth-child(odd) .awea-tl-card'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.awea-tl-mode-alternating .awea-tl-item:nth-child(even) .awea-tl-card' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.awea-tl-mode-left .awea-tl-item'                                       => 'padding-left: calc({{SIZE}}{{UNIT}} + 18px);',
					'{{WRAPPER}}.awea-tl-mode-right .awea-tl-item'                                      => 'padding-right: calc({{SIZE}}{{UNIT}} + 18px);',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. SPINE & NODES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_spine',
			[
				'label' => esc_html__( 'Spine & Nodes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_spine_color',
			[
				'label'     => esc_html__( 'Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-wrap::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_spine_width',
			[
				'label'      => esc_html__( 'Line Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-wrap::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_node_size',
			[
				'label'      => esc_html__( 'Node Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 18, 'max' => 56 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 34 ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-dot i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-tl-dot svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_node_offset',
			[
				'label'      => esc_html__( 'Top Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-dot' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_node_halo_color',
			[
				'label'     => esc_html__( 'Node Ring Cutout Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-wrap' => '--awea-tl-halo: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_node_tabs' );

		$this->start_controls_tab(
			'awea_node_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_dot_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dot_border',
			[
				'label'     => esc_html__( 'Border & Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tl-dot' => 'border-color: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_node_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_dot_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tl-item:hover .awea-tl-dot' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dot_icon_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-item:hover .awea-tl-dot' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_cards',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '28',
					'right'    => '28',
					'bottom'   => '28',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-tl-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-tl-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-tl-card',
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
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-tl-card',
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
					'{{WRAPPER}} .awea-tl-item:hover .awea-tl-card' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-tl-item:hover .awea-tl-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-tl-item:hover .awea-tl-card',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TAG & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Typography & Link', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_tag_heading',
			[
				'label' => esc_html__( 'Tag Badge', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_tag_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tl-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tag_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tag_typo',
				'selector' => '{{WRAPPER}} .awea-tl-tag',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_title_heading',
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
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-tl-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tl-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_desc_heading',
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
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-tl-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_link_heading',
			[
				'label'     => esc_html__( 'Action Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_link_typo',
				'selector' => '{{WRAPPER}} .awea-tl-link',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-tl-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_link_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-tl-link:hover, {{WRAPPER}} .awea-tl-link:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['awea_items'] ?? [];

		if ( empty( $items ) ) {
			return;
		}

		$tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
		?>
		<div class="awea-tl-wrap">
			<?php foreach ( $items as $index => $item ) :
				$id        = $item['_id'] ?? $index;
				$badge     = $item['awea_tag'] ?? '';
				$title     = $item['awea_title'] ?? '';
				$desc      = $item['awea_desc'] ?? '';
				$has_icon  = ! empty( $item['awea_icon']['value'] );
				$img_item  = $item['awea_image'] ?? [];
				$img_url   = $img_item['url'] ?? '';
				$link_text = $item['awea_link_text'] ?? '';
				$has_link  = ! empty( $link_text ) && ! empty( $item['awea_link_url']['url'] );
				$link_key  = 'link_' . $id;

				if ( $has_link ) {
					$this->add_link_attributes( $link_key, $item['awea_link_url'] );
					$this->add_render_attribute( $link_key, 'class', 'awea-tl-link' );
				}

				$img_html = '';
				if ( ! empty( $img_url ) ) {
					if ( ! empty( $img_item['id'] ) ) {
						$img_data = [
							'awea_image'                     => $img_item,
							'awea_img_size_size'             => $settings['awea_img_size_size'] ?? 'large',
							'awea_img_size_custom_dimension' => $settings['awea_img_size_custom_dimension'] ?? [],
						];
						$img_html = Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_img_size', 'awea_image' );
					}
					if ( empty( $img_html ) ) {
						$img_html = sprintf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img_url ), esc_attr( $title ) );
					}
				}
				?>
				<div class="awea-tl-item elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

					<div class="awea-tl-dot" aria-hidden="true">
						<?php if ( $has_icon ) : ?>
							<?php Icons_Manager::render_icon( $item['awea_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php else : ?>
							<span class="awea-tl-dot-core"></span>
						<?php endif; ?>
					</div>

					<article class="awea-tl-card">
						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-tl-tag"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $tag ); ?> class="awea-tl-title">
								<?php echo esc_html( $title ); ?>
							</<?php Utils::print_validated_html_tag( $tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea-tl-desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $img_html ) ) : ?>
							<div class="awea-tl-media">
								<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						<?php endif; ?>

						<?php if ( $has_link ) : ?>
							<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<span><?php echo esc_html( $link_text ); ?></span>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<line x1="5" y1="12" x2="19" y2="12"></line>
									<polyline points="12 5 19 12 12 19"></polyline>
								</svg>
							</a>
						<?php endif; ?>
					</article>

				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}