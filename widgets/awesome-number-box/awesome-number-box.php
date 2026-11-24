<?php
/**
 * Awesome Number Box Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Number_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-number-box';
	}

	public function get_title() {
		return esc_html__( 'Number Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'number', 'box', 'grid', 'step', 'process', 'milestone', 'counter', 'timeline' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_section_items',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_nb_item_tabs' );

		// --- TAB 1: NUMBER ---
		$repeater->start_controls_tab(
			'awea_nb_tab_number',
			[ 'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_nb_number',
			[
				'label'       => esc_html__( 'Number or Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_nb_badge',
			[
				'label'       => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Active', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_nb_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_nb_tag',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Step One', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_nb_title',
			[
				'label'       => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_nb_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Comprehensive discovery sessions to align goals, user flows, and core system requirements.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_nb_features',
			[
				'label'       => esc_html__( 'Bullet Points (One per line)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( "Stakeholder alignment\nTechnical roadmap\nClear milestones", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: LINK ---
		$repeater->start_controls_tab(
			'awea_nb_tab_link',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_nb_link_url',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_nb_link_show',
			[
				'label'        => esc_html__( 'Show Link', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_nb_link_text',
			[
				'label'     => esc_html__( 'Link Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_nb_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_nb_link_icon',
			[
				'label'     => esc_html__( 'Link Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_nb_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_nb_link_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_nb_link_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: COLORS ---
		$repeater->start_controls_tab(
			'awea_nb_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_nb_item_featured',
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
			'awea_nb_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-nb-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_nb_item_num_color',
			[
				'label'     => esc_html__( 'Number Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-nb-badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-nb-watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_nb_item_num_bg',
			[
				'label'     => esc_html__( 'Number Box Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-nb-mode-badge {{CURRENT_ITEM}} .awea-nb-badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-soft {{CURRENT_ITEM}} .awea-nb-badge'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-split {{CURRENT_ITEM}} .awea-nb-badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-outlined {{CURRENT_ITEM}} .awea-nb-badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_nb_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}; --awea-nb-card-bg: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_nb_item_border',
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
			'awea_nb_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_nb_number }}} — {{{ awea_nb_title }}}',
				'default'     => [
					[
						'awea_nb_number'    => '01',
						'awea_nb_tag'       => esc_html__( 'Step One', 'awesome-widgets-elementor' ),
						'awea_nb_title'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
						'awea_nb_desc'      => esc_html__( 'Comprehensive discovery sessions to align goals, user flows, and core system requirements.', 'awesome-widgets-elementor' ),
						'awea_nb_link_text' => esc_html__( 'Explore Phase', 'awesome-widgets-elementor' ),
					],
					[
						'awea_nb_number'        => '02',
						'awea_nb_badge'         => esc_html__( 'Core', 'awesome-widgets-elementor' ),
						'awea_nb_tag'           => esc_html__( 'Step Two', 'awesome-widgets-elementor' ),
						'awea_nb_title'         => esc_html__( 'Architecture & Build', 'awesome-widgets-elementor' ),
						'awea_nb_desc'          => esc_html__( 'Modular design systems engineered for speed, accessibility, and effortless scalability.', 'awesome-widgets-elementor' ),
						'awea_nb_link_text'     => esc_html__( 'View Process', 'awesome-widgets-elementor' ),
						'awea_nb_item_featured' => 'yes',
					],
					[
						'awea_nb_number'    => '03',
						'awea_nb_tag'       => esc_html__( 'Step Three', 'awesome-widgets-elementor' ),
						'awea_nb_title'     => esc_html__( 'Launch & Scale', 'awesome-widgets-elementor' ),
						'awea_nb_desc'      => esc_html__( 'Seamless deployment with automated quality checks and real-time performance telemetry.', 'awesome-widgets-elementor' ),
						'awea_nb_link_text' => esc_html__( 'See Results', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_section_layout',
			[
				'label' => esc_html__( 'Grid & Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_nb_columns',
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
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-nb-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_col_gap',
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
					'{{WRAPPER}} .awea-nb-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_row_gap',
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
					'{{WRAPPER}} .awea-nb-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_equal_height',
			[
				'label'        => esc_html__( 'Same Height Cards', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'stretch',
				'default'      => 'stretch',
				'selectors'    => [
					'{{WRAPPER}} .awea-nb-grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_num_style',
			[
				'label'        => esc_html__( 'Number Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'badge',
				'options'      => [
					'badge'     => esc_html__( 'Solid Box', 'awesome-widgets-elementor' ),
					'soft'      => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'outlined'  => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
					'watermark' => esc_html__( 'Background Watermark', 'awesome-widgets-elementor' ),
					'split'     => esc_html__( 'Left Side Box', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-mode-',
			]
		);

		$this->add_control(
			'awea_nb_badge_shape',
			[
				'label'        => esc_html__( 'Number Box Shape', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'rounded',
				'options'      => [
					'rounded'  => esc_html__( 'Rounded', 'awesome-widgets-elementor' ),
					'circle'   => esc_html__( 'Circle', 'awesome-widgets-elementor' ),
					'square'   => esc_html__( 'Square', 'awesome-widgets-elementor' ),
					'hexagon'  => esc_html__( 'Hexagon', 'awesome-widgets-elementor' ),
					'squircle' => esc_html__( 'Blob', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_nb_num_style!' => 'watermark' ],
				'prefix_class' => 'awea-nb-shape-',
			]
		);

		$this->add_control(
			'awea_nb_connector',
			[
				'label'        => esc_html__( 'Step Connector Line (Desktop)', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Draws a connecting line between step cards.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'dashed' => esc_html__( 'Dashed Line', 'awesome-widgets-elementor' ),
					'solid'  => esc_html__( 'Solid Line', 'awesome-widgets-elementor' ),
					'dotted' => esc_html__( 'Dotted Line', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-conn-',
			]
		);

		$this->add_control(
			'awea_nb_action_style',
			[
				'label'        => esc_html__( 'Link Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'link',
				'options'      => [
					'link'   => esc_html__( 'Text Link', 'awesome-widgets-elementor' ),
					'button' => esc_html__( 'Solid Button', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-act-',
			]
		);

		$this->add_control(
			'awea_nb_feature_icon',
			[
				'label'     => esc_html__( 'Bullet Point Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_nb_link_mode',
			[
				'label'   => esc_html__( 'Clickable Area', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'Link Only', 'awesome-widgets-elementor' ),
					'title'  => esc_html__( 'Heading & Link', 'awesome-widgets-elementor' ),
					'card'   => esc_html__( 'Whole Card', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_nb_title_tag',
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
		   CONTENT: 3. HOVER EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_section_effects',
			[
				'label' => esc_html__( 'Hover Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_nb_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-motion-',
			]
		);

		$this->add_control(
			'awea_nb_num_hover_anim',
			[
				'label'        => esc_html__( 'Number Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'scale',
				'options'      => [
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'scale'  => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
					'rotate' => esc_html__( 'Tilt', 'awesome-widgets-elementor' ),
					'float'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'pulse'  => esc_html__( 'Glow Ring', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-nanim-',
			]
		);

		$this->add_control(
			'awea_nb_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'top-hover',
				'options'      => [
					'none'         => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-hover'    => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'top-always'   => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'bottom-hover' => esc_html__( 'Bottom Line (On Hover)', 'awesome-widgets-elementor' ),
					'left-hover'   => esc_html__( 'Left Line (On Hover)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-bar-',
			]
		);

		$this->add_control(
			'awea_nb_stagger_offset',
			[
				'label'        => esc_html__( 'Offset Even Cards (Desktop)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'awea-nb-stagger-',
			]
		);

		$this->add_responsive_control(
			'awea_nb_stagger_amount',
			[
				'label'      => esc_html__( 'Offset Distance', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'condition'  => [ 'awea_nb_stagger_offset' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-nb-stagger: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_nb_align',
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
				'default'              => 'left',
				'condition'            => [ 'awea_nb_num_style!' => 'split' ],
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start; --awea-nb-wm-left: auto; --awea-nb-wm-right: 16px; --awea-nb-btn-align: flex-start;',
					'center' => 'text-align: center; align-items: center; --awea-nb-wm-left: auto; --awea-nb-wm-right: 16px; --awea-nb-btn-align: center;',
					'right'  => 'text-align: right; align-items: flex-end; --awea-nb-wm-left: 16px; --awea-nb-wm-right: auto; --awea-nb-btn-align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-nb-card' => '{{VALUE}}',
					'{{WRAPPER}} .awea-nb-body' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '32',
					'right'    => '28',
					'bottom'   => '32',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_card_radius',
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
					'{{WRAPPER}} .awea-nb-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_card_backdrop_blur',
			[
				'label'      => esc_html__( 'Background Blur', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-card' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'awea_nb_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line Start', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_nb_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-accent-bar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_accent_bar_color_2',
			[
				'label'     => esc_html__( 'Color Line End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_nb_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-accent-bar' => 'background: linear-gradient(90deg, var(--awea-nb-item-accent, {{awea_nb_accent_bar_color.VALUE}}), {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_nb_accent_bar_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'condition'  => [ 'awea_nb_accent_bar!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-nb-bar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_conn_color',
			[
				'label'     => esc_html__( 'Connector Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_nb_connector!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}}' => '--awea-nb-conn-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nb_card_tabs' );

		$this->start_controls_tab(
			'awea_nb_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_nb_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-nb-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_nb_card_border',
				'selector'       => '{{WRAPPER}} .awea-nb-card',
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
				'name'     => 'awea_nb_card_shadow',
				'selector' => '{{WRAPPER}} .awea-nb-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nb_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_nb_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-nb-card:hover',
			]
		);

		$this->add_control(
			'awea_nb_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover' => 'border-color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nb_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-nb-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nb_card_featured',
			[ 'label' => esc_html__( 'Highlighted', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_nb_card_bg_featured',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-nb-card.awea-nb-featured',
			]
		);

		$this->add_control(
			'awea_nb_card_border_featured',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card.awea-nb-featured' => 'border-color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nb_card_shadow_featured',
				'selector' => '{{WRAPPER}} .awea-nb-card.awea-nb-featured',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. NUMBER BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_badge',
			[
				'label'     => esc_html__( 'Number Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_nb_num_style!' => 'watermark' ],
			]
		);

		$this->add_responsive_control(
			'awea_nb_badge_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 110 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 54 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_badge_gap',
			[
				'label'      => esc_html__( 'Space Below Number', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [ 'awea_nb_badge_shape' => 'rounded' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-nb-shape-rounded .awea-nb-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_badge_typo',
				'selector' => '{{WRAPPER}} .awea-nb-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->start_controls_tabs( 'awea_nb_badge_tabs' );

		$this->start_controls_tab(
			'awea_nb_badge_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nb_badge_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nb-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'awea_nb_badge_bg_group',
				'types'     => [ 'classic', 'gradient' ],
				'condition' => [ 'awea_nb_num_style!' => 'outlined' ],
				'selector'  => '{{WRAPPER}}.awea-nb-mode-badge .awea-nb-badge, {{WRAPPER}}.awea-nb-mode-soft .awea-nb-badge, {{WRAPPER}}.awea-nb-mode-split .awea-nb-badge',
			]
		);

		$this->add_control(
			'awea_nb_badge_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_nb_num_style' => 'outlined' ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-mode-outlined .awea-nb-badge'                        => 'border-color: var(--awea-nb-item-accent, {{VALUE}});',
					'{{WRAPPER}}.awea-nb-mode-outlined.awea-nb-shape-hexagon .awea-nb-badge' => 'background-color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nb_badge_shadow',
				'selector' => '{{WRAPPER}} .awea-nb-badge',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nb_badge_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nb_badge_color_hover',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover .awea-nb-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_nb_badge_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-nb-card:hover .awea-nb-badge, {{WRAPPER}}.awea-nb-mode-outlined.awea-nb-shape-hexagon .awea-nb-card:hover .awea-nb-badge::before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nb_badge_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-nb-card:hover .awea-nb-badge',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. WATERMARK (CONDITIONAL: WATERMARK MODE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_watermark',
			[
				'label'     => esc_html__( 'Background Watermark', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_nb_num_style' => 'watermark' ],
			]
		);

		$this->add_control(
			'awea_nb_wm_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-watermark' => 'color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_wm_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.02, 'max' => 0.35, 'step' => 0.01 ],
				],
				'default'   => [ 'size' => 0.08 ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-watermark' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_wm_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 60, 'max' => 240 ],
					'rem' => [ 'min' => 3, 'max' => 15 ],
				],
				'default'    => [ 'unit' => 'rem', 'size' => 7.5 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-watermark' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. CORNER TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_corner_badge',
			[
				'label' => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_nb_corner_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-corner' => 'color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_nb_corner_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nb-corner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_corner_typo',
				'selector' => '{{WRAPPER}} .awea-nb-corner',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_nb_corner_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '4',
					'right'    => '10',
					'bottom'   => '4',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-corner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_corner_radius',
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
					'{{WRAPPER}} .awea-nb-corner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. HEADINGS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_text',
			[
				'label' => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_nb_tag_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_tag_typo',
				'selector' => '{{WRAPPER}} .awea-nb-tag',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_nb_tag_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-tag' => 'color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_tag_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_title_typo',
				'selector' => '{{WRAPPER}} .awea-nb-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_nb_title_shadow',
				'selector' => '{{WRAPPER}} .awea-nb-title',
			]
		);

		$this->add_control(
			'awea_nb_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-title, {{WRAPPER}} .awea-nb-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover .awea-nb-title, {{WRAPPER}} .awea-nb-card:hover .awea-nb-title a' => 'color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_desc_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_desc_typo',
				'selector' => '{{WRAPPER}} .awea-nb-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_nb_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_desc_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_heading_features_style',
			[
				'label'     => esc_html__( 'Bullet Points', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_nb_feat_icon_color',
			[
				'label'     => esc_html__( 'Bullet Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-feat-ico'     => 'color: var(--awea-nb-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-nb-feat-ico svg' => 'fill: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_nb_feat_text_color',
			[
				'label'     => esc_html__( 'Bullet Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-features li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_feat_typo',
				'selector' => '{{WRAPPER}} .awea-nb-features li',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_nb_feat_gap',
			[
				'label'      => esc_html__( 'Space Between Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-features' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_feat_bottom_space',
			[
				'label'      => esc_html__( 'Space Below Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. ACTION LINK / BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nb_style_link',
			[
				'label' => esc_html__( 'Link / Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_nb_btn_full_width',
			[
				'label'        => esc_html__( 'Full Width Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => '100%',
				'default'      => '',
				'condition'    => [ 'awea_nb_action_style' => 'button' ],
				'selectors'    => [
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn' => 'width: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nb_link_typo',
				'selector' => '{{WRAPPER}} .awea-nb-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_nb_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-btn-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-nb-btn-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition'  => [ 'awea_nb_action_style' => 'button' ],
				'default'    => [
					'top'      => '11',
					'right'    => '20',
					'bottom'   => '11',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nb_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [ 'awea_nb_action_style' => 'button' ],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nb_link_tabs' );

		$this->start_controls_tab(
			'awea_nb_link_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nb_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-act-link .awea-nb-btn'   => 'color: var(--awea-nb-item-accent, {{VALUE}});',
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_nb_action_style' => 'button' ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nb_link_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nb_link_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-act-link .awea-nb-btn:hover, {{WRAPPER}}.awea-nb-act-link .awea-nb-btn:focus-visible' => 'color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn:hover, {{WRAPPER}}.awea-nb-act-button .awea-nb-card:hover .awea-nb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nb_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_nb_action_style' => 'button' ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-act-button .awea-nb-btn:hover, {{WRAPPER}}.awea-nb-act-button .awea-nb-card:hover .awea-nb-btn' => 'background-color: var(--awea-nb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_nb_items'] ?? [];
		$num_style = $settings['awea_nb_num_style'] ?? 'badge';
		$title_tag = Utils::validate_html_tag( $settings['awea_nb_title_tag'] ?? 'h3' );
		$link_mode = $settings['awea_nb_link_mode'] ?? 'button';
		$feat_icon = $settings['awea_nb_feature_icon'] ?? [];

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-nb-grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$card_key = 'awea_nb_card_' . $id;
				$link_key = 'awea_nb_link_' . $id;

				$number   = $item['awea_nb_number'] ?? '01';
				$badge    = $item['awea_nb_badge'] ?? '';
				$tag      = $item['awea_nb_tag'] ?? '';
				$title    = $item['awea_nb_title'] ?? '';
				$desc     = $item['awea_nb_desc'] ?? '';
				$featured = 'yes' === ( $item['awea_nb_item_featured'] ?? '' );

				$raw_features = trim( $item['awea_nb_features'] ?? '' );
				$features     = '' !== $raw_features ? array_filter( array_map( 'trim', explode( "\n", $raw_features ) ) ) : [];

				$url_data = ! empty( $item['awea_nb_link_url']['url'] ) ? $item['awea_nb_link_url'] : [ 'url' => '#' ];
				$has_url  = ! empty( $item['awea_nb_link_url']['url'] );

				$show_btn = 'yes' === ( $item['awea_nb_link_show'] ?? 'no' );
				$btn_text = $item['awea_nb_link_text'] ?? '';
				$btn_pos  = $item['awea_nb_link_icon_pos'] ?? 'right';
				$has_btn  = $show_btn && ! empty( $btn_text );
				$has_ico  = ! empty( $item['awea_nb_link_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$aria_label = ! empty( $title ) ? $title : ( ! empty( $btn_text ) ? $btn_text : esc_html__( 'Step link', 'awesome-widgets-elementor' ) );

				$num_setting_key   = $this->get_repeater_setting_key( 'awea_nb_number', 'awea_nb_items', $index );
				$tag_setting_key   = $this->get_repeater_setting_key( 'awea_nb_tag', 'awea_nb_items', $index );
				$title_setting_key = $this->get_repeater_setting_key( 'awea_nb_title', 'awea_nb_items', $index );
				$desc_setting_key  = $this->get_repeater_setting_key( 'awea_nb_desc', 'awea_nb_items', $index );

				$this->add_inline_editing_attributes( $num_setting_key, 'none' );
				$this->add_inline_editing_attributes( $tag_setting_key, 'none' );
				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );

				$this->add_render_attribute( $num_setting_key, 'class', 'awea-nb-badge' );
				$this->add_render_attribute( $tag_setting_key, 'class', 'awea-nb-tag' );
				$this->add_render_attribute( $title_setting_key, 'class', 'awea-nb-title' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-nb-desc' );

				$card_classes = [
					'awea-nb-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea-nb-card-clickable';
				}
				if ( $featured ) {
					$card_classes[] = 'awea-nb-featured';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_link_attributes( $link_key, $url_data );
				$this->add_render_attribute( $link_key, 'class', 'awea-nb-btn' );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<span class="awea-nb-accent-bar" aria-hidden="true"></span>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-nb-cover-link" aria-label="<?php echo esc_attr( $aria_label ); ?>"></a>
					<?php endif; ?>

					<?php if ( ! empty( $badge ) ) : ?>
						<span class="awea-nb-corner"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>

					<?php if ( 'watermark' === $num_style && ! empty( $number ) ) : ?>
						<div class="awea-nb-watermark" aria-hidden="true"><?php echo esc_html( $number ); ?></div>
					<?php endif; ?>

					<?php if ( 'watermark' !== $num_style && ! empty( $number ) ) : ?>
						<div class="awea-nb-badge-wrap">
							<span <?php $this->print_render_attribute_string( $num_setting_key ); ?>>
								<?php echo esc_html( $number ); ?>
							</span>
						</div>
					<?php endif; ?>

					<div class="awea-nb-body">
						<?php if ( ! empty( $tag ) ) : ?>
							<span <?php $this->print_render_attribute_string( $tag_setting_key ); ?>>
								<?php echo esc_html( $tag ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( $title_setting_key ); ?>>
								<?php if ( $is_title_link ) : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<?php echo esc_html( $title ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $title ); ?>
								<?php endif; ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_setting_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $features ) ) : ?>
							<ul class="awea-nb-features">
								<?php foreach ( $features as $feat ) : ?>
									<li>
										<?php if ( ! empty( $feat_icon['value'] ) ) : ?>
											<span class="awea-nb-feat-ico" aria-hidden="true">
												<?php Icons_Manager::render_icon( $feat_icon, [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
										<span><?php echo wp_kses_post( $feat ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( $has_btn ) : ?>
							<div class="awea-nb-btn-wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea-nb-btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_ico ) : ?>
										<span class="awea-nb-btn-ico awea-nb-ico-left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_nb_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_ico ) : ?>
										<span class="awea-nb-btn-ico awea-nb-ico-right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_nb_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

								<?php echo $is_card_link ? '</span>' : '</a>'; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}