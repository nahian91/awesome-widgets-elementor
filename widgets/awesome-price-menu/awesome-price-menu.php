<?php
/**
 * Awesome Price Menu Widget.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Price_Menu extends Widget_Base {

	public function get_name() {
		return 'awesome-price-menu';
	}

	public function get_title() {
		return esc_html__( 'Price Menu', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-menu-card';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'price menu', 'restaurant', 'catalog', 'pricing', 'food menu', 'services' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. MENU ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pm_section_items',
			[
				'label' => esc_html__( 'Menu Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_pm_item_tabs' );

		// --- TAB 1: DETAILS ---
		$repeater->start_controls_tab(
			'awea_pm_tab_details',
			[ 'label' => esc_html__( 'Details', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pm_item_image',
			[
				'label'   => esc_html__( 'Item Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_pm_item_title',
			[
				'label'       => esc_html__( 'Item Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_pm_item_badge',
			[
				'label'       => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Chef’s Pick', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pm_item_original_price',
			[
				'label'       => esc_html__( 'Original Price (Strike-through)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => '$34.00',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pm_item_price',
			[
				'label'   => esc_html__( 'Current Price', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$28.00',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pm_item_description',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pm_item_link',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: COLORS ---
		$repeater->start_controls_tab(
			'awea_pm_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pm_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Item', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_pm_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-pm-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_pm_item_badge_color',
			[
				'label'     => esc_html__( 'Tag Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-price-menu-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_pm_item_badge_bg',
			[
				'label'     => esc_html__( 'Tag Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-price-menu-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_pm_items',
			[
				'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'awea_pm_item_title'          => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
						'awea_pm_item_badge'          => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
						'awea_pm_item_original_price' => '$34.00',
						'awea_pm_item_price'          => '$28.00',
						'awea_pm_item_description'    => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
						'awea_pm_item_featured'       => 'yes',
					],
					[
						'awea_pm_item_title'       => esc_html__( 'Pan-Seared Chilean Sea Bass', 'awesome-widgets-elementor' ),
						'awea_pm_item_price'       => '$42.00',
						'awea_pm_item_description' => esc_html__( 'Served over saffron risotto with charred asparagus and lemon-herb beurre blanc.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_pm_item_title'       => esc_html__( 'Artisanal Burrata & Heirloom', 'awesome-widgets-elementor' ),
						'awea_pm_item_badge'       => esc_html__( 'GF', 'awesome-widgets-elementor' ),
						'awea_pm_item_price'       => '$22.00',
						'awea_pm_item_description' => esc_html__( 'Fresh creamy burrata, organic heirloom tomatoes, basil oil, and 25-year aged balsamic.', 'awesome-widgets-elementor' ),
					],
				],
				'title_field' => '{{{ awea_pm_item_title }}} — {{{ awea_pm_item_price }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pm_section_settings',
			[
				'label' => esc_html__( 'Grid & Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_pm_columns',
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
				'prefix_class'   => 'awea-pm-cols%s-',
				'selectors'      => [
					'{{WRAPPER}} .awea-price-menu-list' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'awea_pm_title_tag',
			[
				'label'   => esc_html__( 'Item Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
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
		   STYLE: 1. MENU BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pm_style_container',
			[
				'label' => esc_html__( 'Menu Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pm_container_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1400 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pm_container_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '36',
					'right'    => '36',
					'bottom'   => '36',
					'left'     => '36',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pm_container_radius',
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
					'{{WRAPPER}} .awea-price-menu-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_pm_container_state_tabs' );

		$this->start_controls_tab(
			'awea_pm_container_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pm_container_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pm_container_border',
				'selector'       => '{{WRAPPER}} .awea-price-menu-list',
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
				'name'     => 'awea_pm_container_shadow',
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pm_container_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pm_container_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-price-menu-list:hover',
			]
		);

		$this->add_control(
			'awea_pm_container_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pm_container_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-price-menu-list:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ITEM PHOTO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pm_section_style_image',
			[
				'label' => esc_html__( 'Item Photo', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_pm_thumbnail_size',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'awea_pm_thumb_size',
			[
				'label'      => esc_html__( 'Photo Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 44, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 76 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pm_thumb_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_pm_thumb_border',
				'selector' => '{{WRAPPER}} .awea-price-menu-thumb',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & PRICE LINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pm_section_style_typography',
			[
				'label' => esc_html__( 'Text & Price Line', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Item Name
		$this->add_control(
			'awea_pm_heading_title',
			[
				'label' => esc_html__( 'Item Name', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pm_title_typography',
				'selector' => '{{WRAPPER}} .awea-price-menu-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pm_title_shadow',
				'selector' => '{{WRAPPER}} .awea-price-menu-title',
			]
		);

		$this->start_controls_tabs( 'awea_pm_title_tabs' );

		$this->start_controls_tab(
			'awea_pm_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pm_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-title, {{WRAPPER}} .awea-price-menu-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pm_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pm_title_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu:hover .awea-price-menu-title, {{WRAPPER}} .awea-price-menu:hover .awea-price-menu-title a' => 'color: var(--awea-pm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Tag Pill
		$this->add_control(
			'awea_pm_heading_badge',
			[
				'label'     => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pm_badge_typo',
				'selector' => '{{WRAPPER}} .awea-price-menu-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_pm_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-badge' => 'color: var(--awea-pm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_pm_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Price
		$this->add_control(
			'awea_pm_heading_price',
			[
				'label'     => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_pm_price_color',
			[
				'label'     => esc_html__( 'Current Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-price' => 'color: var(--awea-pm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_pm_orig_price_color',
			[
				'label'     => esc_html__( 'Original Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-original' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pm_price_typography',
				'selector' => '{{WRAPPER}} .awea-price',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		// Connecting Line
		$this->add_control(
			'awea_pm_heading_leader',
			[
				'label'     => esc_html__( 'Connecting Price Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_pm_leader_style',
			[
				'label'     => esc_html__( 'Line Style', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'dotted',
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'awesome-widgets-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'awesome-widgets-elementor' ),
					'solid'  => esc_html__( 'Solid', 'awesome-widgets-elementor' ),
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pm_leader_color',
			[
				'label'     => esc_html__( 'Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [ 'awea_pm_leader_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_pm_leader_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_pm_leader_style!' => 'none' ],
			]
		);

		// Description
		$this->add_control(
			'awea_pm_heading_desc',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_pm_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pm_desc_typography',
				'selector' => '{{WRAPPER}} .awea-description',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_pm_desc_margin_top',
			[
				'label'      => esc_html__( 'Space Above Description', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Rows & Dividers
		$this->add_control(
			'awea_pm_heading_row_spacing',
			[
				'label'     => esc_html__( 'Row Spacing & Dividers', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_pm_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 36 ],
				'condition'  => [ 'awea_pm_columns!' => '1' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pm_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-price-menu-list' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pm_row_divider_color',
			[
				'label'     => esc_html__( 'Row Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_pm_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_pm_title_tag'] ?? 'h4' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<ul class="awea-price-menu-list" role="list">
			<?php foreach ( $items as $index => $item ) :
				$id         = $item['_id'] ?? $index;
				$title      = $item['awea_pm_item_title'] ?? '';
				$badge      = $item['awea_pm_item_badge'] ?? '';
				$orig_price = $item['awea_pm_item_original_price'] ?? '';
				$price      = $item['awea_pm_item_price'] ?? '';
				$desc       = $item['awea_pm_item_description'] ?? '';
				$featured   = 'yes' === ( $item['awea_pm_item_featured'] ?? '' );
				$has_link   = ! empty( $item['awea_pm_item_link']['url'] );
				$link_key   = 'awea_pm_link_' . $id;

				$price_setting_key = $this->get_repeater_setting_key( 'awea_pm_item_price', 'awea_pm_items', $index );
				$desc_setting_key  = $this->get_repeater_setting_key( 'awea_pm_item_description', 'awea_pm_items', $index );

				$this->add_inline_editing_attributes( $price_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );

				$this->add_render_attribute( $price_setting_key, 'class', 'awea-price' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-description' );

				if ( $has_link ) {
					$this->add_link_attributes( $link_key, $item['awea_pm_item_link'] );
				}

				$item_classes = [
					'awea-price-menu',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$item_classes[] = 'awea-pm-featured';
				}
				?>
				<li class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" role="listitem">

					<?php if ( ! empty( $item['awea_pm_item_image']['url'] ) ) : ?>
						<div class="awea-price-menu-thumb">
							<?php
							if ( ! empty( $item['awea_pm_item_image']['id'] ) ) {
								echo wp_get_attachment_image( $item['awea_pm_item_image']['id'], $settings['awea_pm_thumbnail_size_size'], false, [ 'loading' => 'lazy' ] );
							} else {
								echo '<img src="' . esc_url( $item['awea_pm_item_image']['url'] ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
							}
							?>
						</div>
					<?php endif; ?>

					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<?php if ( ! empty( $title ) ) : ?>
								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-price-menu-title">
									<?php if ( $has_link ) : ?>
										<a <?php $this->print_render_attribute_string( $link_key ); ?>><?php echo esc_html( $title ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $title ); ?>
									<?php endif; ?>
									<?php if ( ! empty( $badge ) ) : ?>
										<span class="awea-price-menu-badge"><?php echo esc_html( $badge ); ?></span>
									<?php endif; ?>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $orig_price ) || ! empty( $price ) ) : ?>
								<span class="awea-price-group">
									<?php if ( ! empty( $orig_price ) ) : ?>
										<del class="awea-price-original"><?php echo esc_html( $orig_price ); ?></del>
									<?php endif; ?>
									<?php if ( ! empty( $price ) ) : ?>
										<span <?php $this->print_render_attribute_string( $price_setting_key ); ?>>
											<?php echo esc_html( $price ); ?>
										</span>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_setting_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var items = settings.awea_pm_items || [];
		if ( ! items.length ) {
			return;
		}
		var tag = elementor.helpers.validateHTMLTag( settings.awea_pm_title_tag || 'h4' );
		#>
		<ul class="awea-price-menu-list" role="list">
			<# _.each( items, function( item ) {
				var imgUrl   = item.awea_pm_item_image && item.awea_pm_item_image.url ? item.awea_pm_item_image.url : '';
				var featCls  = 'yes' === item.awea_pm_item_featured ? ' awea-pm-featured' : '';
			#>
				<li class="awea-price-menu elementor-repeater-item-{{ item._id }}{{ featCls }}" role="listitem">
					<# if ( imgUrl ) { #>
						<div class="awea-price-menu-thumb">
							<img src="{{ imgUrl }}" alt="{{ item.awea_pm_item_title }}" loading="lazy" />
						</div>
					<# } #>

					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<# if ( item.awea_pm_item_title ) { #>
								<{{{ tag }}} class="awea-price-menu-title">
									<# if ( item.awea_pm_item_link && item.awea_pm_item_link.url ) { #>
										<a href="{{ item.awea_pm_item_link.url }}">{{ _.escape( item.awea_pm_item_title ) }}</a>
									<# } else { #>
										{{ _.escape( item.awea_pm_item_title ) }}
									<# } #>
									<# if ( item.awea_pm_item_badge ) { #>
										<span class="awea-price-menu-badge">{{ _.escape( item.awea_pm_item_badge ) }}</span>
									<# } #>
								</{{{ tag }}}>
							<# } #>

							<# if ( item.awea_pm_item_original_price || item.awea_pm_item_price ) { #>
								<span class="awea-price-group">
									<# if ( item.awea_pm_item_original_price ) { #>
										<del class="awea-price-original">{{ _.escape( item.awea_pm_item_original_price ) }}</del>
									<# } #>
									<# if ( item.awea_pm_item_price ) { #>
										<span class="awea-price">{{ _.escape( item.awea_pm_item_price ) }}</span>
									<# } #>
								</span>
							<# } #>
						</div>

						<# if ( item.awea_pm_item_description ) { #>
							<p class="awea-description">{{{ item.awea_pm_item_description }}}</p>
						<# } #>
					</div>
				</li>
			<# } ); #>
		</ul>
		<?php
	}
}