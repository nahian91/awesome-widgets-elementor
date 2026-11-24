<?php
/**
 * Awesome Image Box Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Image_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-image-box';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'image box', 'grid', 'card', 'feature', 'media', 'horizontal', 'portfolio', 'service' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_section_items',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_ib_item_tabs' );

		// --- TAB 1: IMAGE ---
		$repeater->start_controls_tab(
			'awea_ib_tab_image',
			[ 'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ib_image',
			[
				'label'   => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_ib_badge',
			[
				'label'       => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Featured', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_ib_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ib_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'ARCHITECTURE', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ib_title',
			[
				'label'       => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ib_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_ib_features',
			[
				'label'       => esc_html__( 'Bullet Points (One per line)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( "High-resolution visuals\nResponsive framing\nFast lazy loading", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: BUTTON ---
		$repeater->start_controls_tab(
			'awea_ib_tab_button',
			[ 'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ib_btn_link',
			[
				'label'   => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_ib_btn_show',
			[
				'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_ib_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_ib_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_ib_btn_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_ib_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_ib_btn_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_ib_btn_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: COLORS ---
		$repeater->start_controls_tab(
			'awea_ib_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ib_item_featured',
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
			'awea_ib_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-ib-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ib_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}; --awea-ib-card-bg: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ib_item_border_color',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ib_item_badge_bg',
			[
				'label'     => esc_html__( 'Tag Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-ib-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ib_item_badge_color',
			[
				'label'     => esc_html__( 'Tag Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-ib-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ib_item_btn_bg',
			[
				'label'     => esc_html__( 'Button Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-ib-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_ib_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_ib_title }}}',
				'default'     => [
					[
						'awea_ib_badge'    => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_ib_subtitle' => esc_html__( 'STUDIO', 'awesome-widgets-elementor' ),
						'awea_ib_title'    => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
						'awea_ib_desc'     => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
						'awea_ib_btn_text' => esc_html__( 'Explore Studio', 'awesome-widgets-elementor' ),
					],
					[
						'awea_ib_badge'         => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
						'awea_ib_subtitle'      => esc_html__( 'EXPERIENCE', 'awesome-widgets-elementor' ),
						'awea_ib_title'         => esc_html__( 'Fluid Interaction', 'awesome-widgets-elementor' ),
						'awea_ib_desc'          => esc_html__( 'Tactile micro-interactions engineered with smooth spring curves that feel crisp and effortless.', 'awesome-widgets-elementor' ),
						'awea_ib_btn_text'      => esc_html__( 'View Showcase', 'awesome-widgets-elementor' ),
						'awea_ib_item_featured' => 'yes',
					],
					[
						'awea_ib_badge'    => esc_html__( 'System', 'awesome-widgets-elementor' ),
						'awea_ib_subtitle' => esc_html__( 'FRAMEWORK', 'awesome-widgets-elementor' ),
						'awea_ib_title'    => esc_html__( 'Modular Precision', 'awesome-widgets-elementor' ),
						'awea_ib_desc'     => esc_html__( 'Responsive grid primitives built to stay aligned across desktop, tablet, and mobile screens.', 'awesome-widgets-elementor' ),
						'awea_ib_btn_text' => esc_html__( 'Read Specs', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_section_layout',
			[
				'label' => esc_html__( 'Grid & Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_ib_columns',
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
					'{{WRAPPER}} .awea-ib-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_col_gap',
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
					'{{WRAPPER}} .awea-ib-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_row_gap',
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
					'{{WRAPPER}} .awea-ib-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_equal_height',
			[
				'label'        => esc_html__( 'Same Height Cards', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'stretch',
				'default'      => 'stretch',
				'selectors'    => [
					'{{WRAPPER}} .awea-ib-grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_img_pos',
			[
				'label'                => esc_html__( 'Image Position', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'top',
				'toggle'               => false,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'top'   => 'flex-direction: column;',
					'left'  => 'flex-direction: row;',
					'right' => 'flex-direction: row-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-ib-card' => '{{VALUE}}',
				],
				'prefix_class'         => 'awea-ib-pos%s-',
			]
		);

		$this->add_responsive_control(
			'awea_ib_img_width',
			[
				'label'      => esc_html__( 'Side Image Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 20, 'max' => 65 ],
					'px' => [ 'min' => 80, 'max' => 450 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 42 ],
				'condition'  => [ 'awea_ib_img_pos!' => 'top' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-media' => 'width: {{SIZE}}{{UNIT}}; min-height: 100%;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_ib_img_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_ib_img_ratio',
			[
				'label'     => esc_html__( 'Image Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/9'  => '16:9 (Widescreen)',
					'16/10' => '16:10 (Standard)',
					'4/3'   => '4:3 (Classic)',
					'1/1'   => '1:1 (Square)',
					'3/4'   => '3:4 (Portrait)',
					'auto'  => esc_html__( 'Original Ratio', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-media' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_feature_icon',
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
			'awea_ib_link_mode',
			[
				'label'   => esc_html__( 'Clickable Area', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'Button Only', 'awesome-widgets-elementor' ),
					'title'  => esc_html__( 'Heading & Button', 'awesome-widgets-elementor' ),
					'card'   => esc_html__( 'Whole Card', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_ib_title_tag',
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
			'awea_ib_section_effects',
			[
				'label' => esc_html__( 'Hover Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ib_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ib-motion-',
			]
		);

		$this->add_control(
			'awea_ib_img_hover_anim',
			[
				'label'        => esc_html__( 'Image Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'zoom-in',
				'options'      => [
					'none'     => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'zoom-in'  => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
					'zoom-out' => esc_html__( 'Zoom Out', 'awesome-widgets-elementor' ),
					'tilt'     => esc_html__( 'Zoom & Tilt', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ib-imganim-',
			]
		);

		$this->add_control(
			'awea_ib_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'         => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-hover'    => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'top-always'   => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'bottom-hover' => esc_html__( 'Bottom Line (On Hover)', 'awesome-widgets-elementor' ),
					'left-hover'   => esc_html__( 'Left Line (On Hover)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ib-bar-',
			]
		);

		$this->add_control(
			'awea_ib_stagger_offset',
			[
				'label'        => esc_html__( 'Offset Even Cards (Desktop)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'awea-ib-stagger-',
			]
		);

		$this->add_responsive_control(
			'awea_ib_stagger_amount',
			[
				'label'      => esc_html__( 'Offset Distance', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'condition'  => [ 'awea_ib_stagger_offset' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-ib-stagger: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ib_align',
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
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start; --awea-ib-btn-align: flex-start;',
					'center' => 'text-align: center; align-items: center; --awea-ib-btn-align: center;',
					'right'  => 'text-align: right; align-items: flex-end; --awea-ib-btn-align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-ib-card' => '{{VALUE}}',
					'{{WRAPPER}} .awea-ib-body' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '22',
					'right'    => '22',
					'bottom'   => '22',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_card_radius',
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
					'{{WRAPPER}} .awea-ib-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_card_backdrop_blur',
			[
				'label'      => esc_html__( 'Background Blur', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'awea_ib_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line Start', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ib_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-accent-bar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_accent_bar_color_2',
			[
				'label'     => esc_html__( 'Color Line End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_ib_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-accent-bar' => 'background: linear-gradient(90deg, var(--awea-ib-item-accent, {{awea_ib_accent_bar_color.VALUE}}), {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ib_accent_bar_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'condition'  => [ 'awea_ib_accent_bar!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-ib-bar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ib_card_tabs' );

		$this->start_controls_tab(
			'awea_ib_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ib_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ib-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_ib_card_border',
				'selector'       => '{{WRAPPER}} .awea-ib-card',
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
				'name'     => 'awea_ib_card_shadow',
				'selector' => '{{WRAPPER}} .awea-ib-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ib_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ib_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ib-card:hover',
			]
		);

		$this->add_control(
			'awea_ib_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card:hover' => 'border-color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ib_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-ib-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ib_card_featured',
			[ 'label' => esc_html__( 'Highlighted', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ib_card_bg_featured',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ib-card.awea-ib-featured',
			]
		);

		$this->add_control(
			'awea_ib_card_border_featured',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card.awea-ib-featured' => 'border-color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ib_card_shadow_featured',
				'selector' => '{{WRAPPER}} .awea-ib-card.awea-ib-featured',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ib_img_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_img_space',
			[
				'label'      => esc_html__( 'Space Below Image', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_ib_img_border',
				'selector' => '{{WRAPPER}} .awea-ib-media',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ib_img_shadow',
				'selector' => '{{WRAPPER}} .awea-ib-media',
			]
		);

		$this->start_controls_tabs( 'awea_ib_img_tabs' );

		$this->start_controls_tab(
			'awea_ib_img_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_img_overlay',
			[
				'label'     => esc_html__( 'Image Tint Overlay', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-media::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_ib_img_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-ib-media img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ib_img_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_img_overlay_hover',
			[
				'label'     => esc_html__( 'Image Tint Overlay', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card:hover .awea-ib-media::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_ib_img_filter_hover',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-ib-card:hover .awea-ib-media img',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. CORNER TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_badge',
			[
				'label' => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ib_badge_pos',
			[
				'label'                => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'top-left',
				'options'              => [
					'top-left'     => esc_html__( 'Top Left', 'awesome-widgets-elementor' ),
					'top-right'    => esc_html__( 'Top Right', 'awesome-widgets-elementor' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'awesome-widgets-elementor' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'awesome-widgets-elementor' ),
				],
				'selectors_dictionary' => [
					'top-left'     => 'top: 12px; left: 12px; right: auto; bottom: auto;',
					'top-right'    => 'top: 12px; right: 12px; left: auto; bottom: auto;',
					'bottom-left'  => 'bottom: 12px; left: 12px; top: auto; right: auto;',
					'bottom-right' => 'bottom: 12px; right: 12px; top: auto; left: auto;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-ib-badge' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_ib_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-badge' => 'background-color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_badge_typo',
				'selector' => '{{WRAPPER}} .awea-ib-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_ib_badge_border',
				'selector' => '{{WRAPPER}} .awea-ib-badge',
			]
		);

		$this->add_responsive_control(
			'awea_ib_badge_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '5',
					'right'    => '12',
					'bottom'   => '5',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_badge_radius',
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
					'{{WRAPPER}} .awea-ib-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. HEADINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_title',
			[
				'label' => esc_html__( 'Headings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ib_heading_subtitle_style',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_ib_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-subtitle' => 'color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-ib-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_ib_subtitle_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_heading_title_style',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_title_typo',
				'selector' => '{{WRAPPER}} .awea-ib-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_ib_title_shadow',
				'selector' => '{{WRAPPER}} .awea-ib-title',
			]
		);

		$this->add_responsive_control(
			'awea_ib_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ib_title_tabs' );

		$this->start_controls_tab(
			'awea_ib_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-title, {{WRAPPER}} .awea-ib-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ib_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card:hover .awea-ib-title, {{WRAPPER}} .awea-ib-card:hover .awea-ib-title a' => 'color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. TEXT & BULLETS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_desc',
			[
				'label' => esc_html__( 'Text & Bullets', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ib_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_desc_typo',
				'selector' => '{{WRAPPER}} .awea-ib-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_ib_desc_space',
			[
				'label'      => esc_html__( 'Space Below Text', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_heading_features_style',
			[
				'label'     => esc_html__( 'Bullet Points', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ib_feat_icon_color',
			[
				'label'     => esc_html__( 'Bullet Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-feat-ico'     => 'color: var(--awea-ib-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-ib-feat-ico svg' => 'fill: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ib_feat_text_color',
			[
				'label'     => esc_html__( 'Bullet Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-features li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_feat_typo',
				'selector' => '{{WRAPPER}} .awea-ib-features li',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_ib_feat_gap',
			[
				'label'      => esc_html__( 'Space Between Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-features' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_feat_bottom_space',
			[
				'label'      => esc_html__( 'Space Below Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ib_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ib_btn_full_width',
			[
				'label'        => esc_html__( 'Full Width Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => '100%',
				'default'      => '',
				'selectors'    => [
					'{{WRAPPER}} .awea-ib-btn' => 'width: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ib_btn_typo',
				'selector' => '{{WRAPPER}} .awea-ib-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_ib_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-ib-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_btn_icon_gap',
			[
				'label'      => esc_html__( 'Space Between Text & Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-btn' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '11',
					'right'    => '20',
					'bottom'   => '11',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ib_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ib_btn_tabs' );

		$this->start_controls_tab(
			'awea_ib_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_ib_btn_border',
				'selector' => '{{WRAPPER}} .awea-ib-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ib_btn_shadow',
				'selector' => '{{WRAPPER}} .awea-ib-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ib_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ib_btn_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ib_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'background-color: var(--awea-ib-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ib_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ib_btn_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_ib_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_ib_title_tag'] ?? 'h3' );
		$link_mode = $settings['awea_ib_link_mode'] ?? 'button';
		$feat_icon = $settings['awea_ib_feature_icon'] ?? [];

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-ib-grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$card_key = 'awea_ib_card_' . $id;
				$link_key = 'awea_ib_link_' . $id;

				$subtitle = $item['awea_ib_subtitle'] ?? '';
				$title    = $item['awea_ib_title'] ?? '';
				$desc     = $item['awea_ib_desc'] ?? '';
				$badge    = $item['awea_ib_badge'] ?? '';
				$featured = 'yes' === ( $item['awea_ib_item_featured'] ?? '' );

				$raw_features = trim( $item['awea_ib_features'] ?? '' );
				$features     = '' !== $raw_features ? array_filter( array_map( 'trim', explode( "\n", $raw_features ) ) ) : [];

				$url_data = ! empty( $item['awea_ib_btn_link']['url'] ) ? $item['awea_ib_btn_link'] : [ 'url' => '#' ];
				$has_url  = ! empty( $item['awea_ib_btn_link']['url'] );

				$btn_show = 'yes' === ( $item['awea_ib_btn_show'] ?? 'no' );
				$btn_text = $item['awea_ib_btn_text'] ?? '';
				$btn_pos  = $item['awea_ib_btn_icon_pos'] ?? 'right';
				$has_icon = ! empty( $item['awea_ib_btn_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$aria_label = ! empty( $title ) ? $title : ( ! empty( $btn_text ) ? $btn_text : esc_html__( 'Card link', 'awesome-widgets-elementor' ) );

				$subtitle_setting_key = $this->get_repeater_setting_key( 'awea_ib_subtitle', 'awea_ib_items', $index );
				$title_setting_key    = $this->get_repeater_setting_key( 'awea_ib_title', 'awea_ib_items', $index );
				$desc_setting_key     = $this->get_repeater_setting_key( 'awea_ib_desc', 'awea_ib_items', $index );

				$this->add_inline_editing_attributes( $subtitle_setting_key, 'none' );
				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );

				$this->add_render_attribute( $subtitle_setting_key, 'class', 'awea-ib-subtitle' );
				$this->add_render_attribute( $title_setting_key, 'class', 'awea-ib-title' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-ib-desc' );

				$img_item = $item['awea_ib_image'] ?? [];
				$img_url  = ! empty( $img_item['url'] ) ? $img_item['url'] : Utils::get_placeholder_image_src();

				$img_data = [
					'awea_ib_image'                     => $img_item,
					'awea_ib_img_size_size'             => $settings['awea_ib_img_size_size'] ?? 'large',
					'awea_ib_img_size_custom_dimension' => $settings['awea_ib_img_size_custom_dimension'] ?? [],
				];

				$img_html = ! empty( $img_item['id'] )
					? Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_ib_img_size', 'awea_ib_image' )
					: sprintf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img_url ), esc_attr( $title ) );

				$card_classes = [
					'awea-ib-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea-ib-card-clickable';
				}
				if ( $featured ) {
					$card_classes[] = 'awea-ib-featured';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_link_attributes( $link_key, $url_data );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<span class="awea-ib-accent-bar" aria-hidden="true"></span>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-ib-cover-link" aria-label="<?php echo esc_attr( $aria_label ); ?>"></a>
					<?php endif; ?>

					<div class="awea-ib-media">
						<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-ib-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea-ib-body">
						<?php if ( ! empty( $subtitle ) ) : ?>
							<span <?php $this->print_render_attribute_string( $subtitle_setting_key ); ?>>
								<?php echo esc_html( $subtitle ); ?>
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
							<ul class="awea-ib-features">
								<?php foreach ( $features as $feat ) : ?>
									<li>
										<?php if ( ! empty( $feat_icon['value'] ) ) : ?>
											<span class="awea-ib-feat-ico" aria-hidden="true">
												<?php Icons_Manager::render_icon( $feat_icon, [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
										<span><?php echo wp_kses_post( $feat ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( $btn_show && ! empty( $btn_text ) ) : ?>
							<div class="awea-ib-btn-wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea-ib-btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-ib-btn">
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_icon ) : ?>
										<span class="awea-ib-ico awea-ib-ico-left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_ib_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_icon ) : ?>
										<span class="awea-ib-ico awea-ib-ico-right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_ib_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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