<?php
/**
 * Awesome Filter Gallery Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Filter_Gallery extends Widget_Base {

	public function get_name() {
		return 'awesome-filter-gallery';
	}

	public function get_title() {
		return esc_html__( 'Filter Gallery', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'filter', 'gallery', 'portfolio', 'grid', 'lightbox', 'showcase' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. FILTER BAR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_section_filter',
			[
				'label' => esc_html__( 'Filter Bar', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_fg_show_filter',
			[
				'label'        => esc_html__( 'Show Filter Bar', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_fg_all_label',
			[
				'label'     => esc_html__( '"All" Tab Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'All Works', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_fg_show_filter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_fg_show_counter',
			[
				'label'        => esc_html__( 'Show Item Counts', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_fg_show_filter' => 'yes' ],
			]
		);

		$cat_repeater = new Repeater();

		$cat_repeater->add_control(
			'awea_fg_cat_name',
			[
				'label'       => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_fg_categories',
			[
				'label'       => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cat_repeater->get_controls(),
				'default'     => [
					[ 'awea_fg_cat_name' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ) ],
					[ 'awea_fg_cat_name' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ) ],
					[ 'awea_fg_cat_name' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ) ],
					[ 'awea_fg_cat_name' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ) ],
				],
				'title_field' => '{{{ awea_fg_cat_name }}}',
				'condition'   => [ 'awea_fg_show_filter' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_fg_filter_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-nav-wrapper' => 'justify-content: {{VALUE}};',
				],
				'condition' => [ 'awea_fg_show_filter' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GALLERY CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_section_items',
			[
				'label' => esc_html__( 'Gallery Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$item_repeater = new Repeater();

		$item_repeater->start_controls_tabs( 'awea_fg_item_tabs' );

		// --- TAB 1: DETAILS ---
		$item_repeater->start_controls_tab(
			'awea_fg_tab_details',
			[ 'label' => esc_html__( 'Details', 'awesome-widgets-elementor' ) ]
		);

		$item_repeater->add_control(
			'awea_fg_item_image',
			[
				'label'   => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Concept', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_title',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Project Showcase', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_category',
			[
				'label'       => esc_html__( 'Category Names', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Separate multiple categories with a comma (e.g. Architecture, Minimalism).', 'awesome-widgets-elementor' ),
				'default'     => 'Architecture',
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_link',
			[
				'label'       => esc_html__( 'Project Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$item_repeater->end_controls_tab();

		// --- TAB 2: COLORS ---
		$item_repeater->start_controls_tab(
			'awea_fg_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$item_repeater->add_control(
			'awea_fg_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Card', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-fg-item-accent: {{VALUE}};',
				],
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$item_repeater->add_control(
			'awea_fg_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$item_repeater->end_controls_tab();

		$item_repeater->end_controls_tabs();

		$this->add_control(
			'awea_fg_gallery_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $item_repeater->get_controls(),
				'title_field' => '{{{ awea_fg_item_title }}}',
				'default'     => [
					[
						'awea_fg_item_title'    => esc_html__( 'Tokyo Cyberpunk', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_fg_item_title'    => esc_html__( 'Alpine Serenity', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Landscape',
					],
					[
						'awea_fg_item_title'    => esc_html__( 'Vogue Monolith', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Portraits',
					],
					[
						'awea_fg_item_title'    => esc_html__( 'Bauhaus Geometry', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_fg_item_title'    => esc_html__( 'Nordic Fjords', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Landscape',
					],
					[
						'awea_fg_item_title'    => esc_html__( 'Minimal Silhouette', 'awesome-widgets-elementor' ),
						'awea_fg_item_subtitle' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ),
						'awea_fg_item_category' => 'Portraits, Minimalism',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. GRID & OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_section_settings',
			[
				'label' => esc_html__( 'Grid & Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_fg_columns',
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
					'{{WRAPPER}} .awea-fg-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_fg_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_fg_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_fg_card_style',
			[
				'label'        => esc_html__( 'Text Placement', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'below',
				'options'      => [
					'below'   => esc_html__( 'Below Image (Card)', 'awesome-widgets-elementor' ),
					'overlay' => esc_html__( 'Over Image (Bottom Overlay)', 'awesome-widgets-elementor' ),
					'none'    => esc_html__( 'Image Only (Hide Text)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-fg-style-',
			]
		);

		$this->add_responsive_control(
			'awea_fg_ratio',
			[
				'label'     => esc_html__( 'Image Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/3',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/3'  => '4:3 (Standard)',
					'16/9' => '16:9 (Widescreen)',
					'3/4'  => '3:4 (Portrait)',
					'auto' => esc_html__( 'Original Ratio', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-thumb' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_fg_image_size',
				'default'   => 'large',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_fg_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-fg-motion-',
			]
		);

		$this->add_control(
			'awea_fg_title_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
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
			'awea_fg_lightbox',
			[
				'label'        => esc_html__( 'Enable Lightbox Popup', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_fg_card_radius',
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
					'{{WRAPPER}} .awea-fg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_fg_body_padding',
			[
				'label'      => esc_html__( 'Text Inner Spacing', 'awesome-widgets-elementor' ),
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
				'condition'  => [ 'awea_fg_card_style!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_fg_img_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-fg-thumb img',
			]
		);

		$this->start_controls_tabs( 'awea_fg_card_tabs' );

		$this->start_controls_tab(
			'awea_fg_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_fg_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-fg-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_fg_card_border',
				'selector'       => '{{WRAPPER}} .awea-fg-card',
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
				'name'     => 'awea_fg_card_shadow',
				'selector' => '{{WRAPPER}} .awea-fg-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_fg_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_fg_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-fg-card:hover',
			]
		);

		$this->add_control(
			'awea_fg_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-card:hover' => 'border-color: var(--awea-fg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_fg_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-fg-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. FILTER TABS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_style_filter',
			[
				'label'     => esc_html__( 'Filter Tabs', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_fg_show_filter' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_fg_nav_typo',
				'selector' => '{{WRAPPER}} .awea-fg-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_fg_nav_padding',
			[
				'label'      => esc_html__( 'Tab Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '8',
					'right'    => '18',
					'bottom'   => '8',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_fg_nav_space',
			[
				'label'      => esc_html__( 'Space Below Filter Bar', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-nav-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_fg_nav_bg',
			[
				'label'     => esc_html__( 'Bar Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-fg-nav-track' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_fg_pill_bg',
			[
				'label'     => esc_html__( 'Active Tab Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-pill-indicator' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_fg_nav_tabs' );

		$this->start_controls_tab(
			'awea_fg_nav_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_fg_nav_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_fg_nav_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_fg_nav_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_fg_nav_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_fg_nav_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn.is-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. CARD TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_fg_style_title',
			[
				'label' => esc_html__( 'Card Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_fg_text_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-body' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_fg_subtitle_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_fg_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-fg-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_fg_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-subtitle' => 'color: var(--awea-fg-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_fg_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_fg_title_typo',
				'selector' => '{{WRAPPER}} .awea-fg-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_fg_title_shadow',
				'selector' => '{{WRAPPER}} .awea-fg-title',
			]
		);

		$this->add_control(
			'awea_fg_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$items      = $settings['awea_fg_gallery_items'] ?? [];
		$categories = $settings['awea_fg_categories'] ?? [];
		$show_menu  = 'yes' === ( $settings['awea_fg_show_filter'] ?? 'no' );
		$show_count = 'yes' === ( $settings['awea_fg_show_counter'] ?? 'no' );
		$lightbox   = 'yes' === ( $settings['awea_fg_lightbox'] ?? 'yes' );
		$all_label  = ! empty( $settings['awea_fg_all_label'] ) ? $settings['awea_fg_all_label'] : esc_html__( 'All Works', 'awesome-widgets-elementor' );
		$title_tag  = Utils::validate_html_tag( $settings['awea_fg_title_tag'] ?? 'h4' );
		$widget_id  = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}

		// Compute category counts
		$cat_counts = [ '*' => count( $items ) ];
		foreach ( $items as $item ) {
			$raw_cats = explode( ',', $item['awea_fg_item_category'] ?? '' );
			foreach ( $raw_cats as $rc ) {
				$slug = sanitize_title( trim( $rc ) );
				if ( ! empty( $slug ) ) {
					$cat_counts[ $slug ] = ( $cat_counts[ $slug ] ?? 0 ) + 1;
				}
			}
		}
		?>
		<div class="awea-fg-root" id="awea-fg-<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( $show_menu ) : ?>
				<div class="awea-fg-nav-wrapper">
					<div class="awea-fg-nav-track" role="tablist">
						<span class="awea-fg-pill-indicator" aria-hidden="true"></span>

						<button type="button" class="awea-fg-btn is-active" data-filter="*" role="tab" aria-selected="true">
							<span><?php echo esc_html( $all_label ); ?></span>
							<?php if ( $show_count ) : ?>
								<span class="awea-fg-counter"><?php echo esc_html( (string) $cat_counts['*'] ); ?></span>
							<?php endif; ?>
						</button>

						<?php foreach ( $categories as $cat ) :
							$cat_raw  = $cat['awea_fg_cat_name'] ?? '';
							$cat_slug = sanitize_title( $cat_raw );
							if ( empty( $cat_slug ) ) {
								continue;
							}
							$count = $cat_counts[ $cat_slug ] ?? 0;
							?>
							<button type="button" class="awea-fg-btn" data-filter=".awea-cat-<?php echo esc_attr( $cat_slug ); ?>" role="tab" aria-selected="false">
								<span><?php echo esc_html( $cat_raw ); ?></span>
								<?php if ( $show_count ) : ?>
									<span class="awea-fg-counter"><?php echo esc_html( (string) $count ); ?></span>
								<?php endif; ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="awea-fg-grid">
				<?php foreach ( $items as $index => $item ) :
					$id         = $item['_id'] ?? $index;
					$img_data   = $item['awea_fg_item_image'] ?? [];
					$img_url    = ! empty( $img_data['url'] ) ? $img_data['url'] : Utils::get_placeholder_image_src();
					$title      = $item['awea_fg_item_title'] ?? '';
					$subtitle   = $item['awea_fg_item_subtitle'] ?? '';
					$featured   = 'yes' === ( $item['awea_fg_item_featured'] ?? '' );
					$custom_url = $item['awea_fg_item_link']['url'] ?? '';

					$subtitle_setting_key = $this->get_repeater_setting_key( 'awea_fg_item_subtitle', 'awea_fg_gallery_items', $index );
					$title_setting_key    = $this->get_repeater_setting_key( 'awea_fg_item_title', 'awea_fg_gallery_items', $index );

					$this->add_inline_editing_attributes( $subtitle_setting_key, 'none' );
					$this->add_inline_editing_attributes( $title_setting_key, 'none' );

					$this->add_render_attribute( $subtitle_setting_key, 'class', 'awea-fg-subtitle' );
					$this->add_render_attribute( $title_setting_key, 'class', 'awea-fg-title' );

					$raw_cats    = explode( ',', $item['awea_fg_item_category'] ?? '' );
					$cat_classes = [];
					foreach ( $raw_cats as $rc ) {
						$slug = sanitize_title( trim( $rc ) );
						if ( ! empty( $slug ) ) {
							$cat_classes[] = 'awea-cat-' . $slug;
						}
					}
					$class_string = implode( ' ', $cat_classes );

					$card_classes = [
						'awea-fg-card',
						'elementor-repeater-item-' . esc_attr( $id ),
					];
					if ( $featured ) {
						$card_classes[] = 'awea-fg-featured';
					}

					if ( $lightbox ) {
						$lightbox_url = Group_Control_Image_Size::get_attachment_image_src( $img_data['id'] ?? '', 'full', $settings ) ?: $img_url;
					}
					?>
					<div class="awea-fg-item <?php echo esc_attr( $class_string ); ?>">
						<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

							<div class="awea-fg-thumb">
								<?php
								if ( ! empty( $img_data['id'] ) ) {
									echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_fg_image_size', 'awea_fg_item_image' );
								} else {
									printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img_url ), esc_attr( $title ) );
								}
								?>

								<div class="awea-fg-actions">
									<?php if ( $lightbox ) : ?>
										<a href="<?php echo esc_url( $lightbox_url ); ?>"
										   class="awea-fg-action-btn elementor-lightbox"
										   data-elementor-open-lightbox="yes"
										   data-elementor-lightbox-slideshow="awea-fg-<?php echo esc_attr( $widget_id ); ?>"
										   title="<?php echo esc_attr( $title ); ?>"
										   aria-label="<?php esc_attr_e( 'View Full Image', 'awesome-widgets-elementor' ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
										</a>
									<?php endif; ?>

									<?php if ( ! empty( $custom_url ) ) :
										$link_key = 'awea_fg_link_' . $id;
										$this->add_link_attributes( $link_key, $item['awea_fg_item_link'] );
										$this->add_render_attribute( $link_key, 'class', 'awea-fg-action-btn' );
										$this->add_render_attribute( $link_key, 'aria-label', esc_attr( ! empty( $title ) ? $title : esc_html__( 'Open project link', 'awesome-widgets-elementor' ) ) );
										?>
										<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
										</a>
									<?php endif; ?>
								</div>
							</div>

							<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
								<div class="awea-fg-body">
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
								</div>
							<?php endif; ?>

						</article>
					</div>
				<?php endforeach; ?>
			</div>

		</div>

		<script>
		(function() {
			function initFilterGallery() {
				var scope = document.getElementById('awea-fg-<?php echo esc_js( $widget_id ); ?>');
				if (!scope || scope.dataset.aweaBound === '1') return;
				scope.dataset.aweaBound = '1';

				var track     = scope.querySelector('.awea-fg-nav-track');
				var indicator = scope.querySelector('.awea-fg-pill-indicator');
				var buttons   = scope.querySelectorAll('.awea-fg-btn');
				var items     = Array.from(scope.querySelectorAll('.awea-fg-item'));

				function updateIndicator(activeBtn) {
					if (!indicator || !activeBtn) return;
					indicator.style.width   = activeBtn.offsetWidth + 'px';
					indicator.style.height  = activeBtn.offsetHeight + 'px';
					indicator.style.left    = activeBtn.offsetLeft + 'px';
					indicator.style.top     = activeBtn.offsetTop + 'px';
					indicator.style.opacity = '1';
				}

				var defaultActive = scope.querySelector('.awea-fg-btn.is-active');
				if (defaultActive) {
					requestAnimationFrame(function() { updateIndicator(defaultActive); });
				}

				buttons.forEach(function(btn) {
					btn.addEventListener('click', function() {
						if (this.classList.contains('is-active')) return;

						buttons.forEach(function(b) {
							b.classList.remove('is-active');
							b.setAttribute('aria-selected', 'false');
						});
						this.classList.add('is-active');
						this.setAttribute('aria-selected', 'true');
						updateIndicator(this);

						var filterVal = this.getAttribute('data-filter');

						items.forEach(function(item) {
							var matches = (filterVal === '*' || item.matches(filterVal));
							if (matches) {
								item.style.display = '';
								item.classList.remove('is-fading-out');
								item.classList.add('is-fading-in');
							} else {
								item.classList.remove('is-fading-in');
								item.classList.add('is-fading-out');
								setTimeout(function() {
									if (item.classList.contains('is-fading-out')) {
										item.style.display = 'none';
									}
								}, 300);
							}
						});
					});
				});

				if ('ResizeObserver' in window && track) {
					var ro = new ResizeObserver(function() {
						var currentActive = scope.querySelector('.awea-fg-btn.is-active');
						if (currentActive) updateIndicator(currentActive);
					});
					ro.observe(track);
				} else {
					window.addEventListener('resize', function() {
						var currentActive = scope.querySelector('.awea-fg-btn.is-active');
						if (currentActive) updateIndicator(currentActive);
					});
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initFilterGallery);
			} else {
				initFilterGallery();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-filter-gallery.default', initFilterGallery);
			}
		})();
		</script>
		<?php
	}
}