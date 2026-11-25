<?php
/**
 * Awesome Product Category Carousel Widget.
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
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Product_Category_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-carousel';
	}

	public function get_title() {
		return esc_html__( 'Category Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-nested-carousel';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'category', 'categories', 'carousel', 'slider', 'collections' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CATEGORY QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_section_query',
			[
				'label' => esc_html__( 'Category Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) && taxonomy_exists( 'product_cat' ) ) {
			$categories = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				foreach ( $categories as $cat ) {
					$cat_options[ $cat->term_id ] = $cat->name;
				}
			}
		}

		$this->add_control(
			'awea_pcc_include_categories',
			[
				'label'       => esc_html__( 'Filter by Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Leave empty to show all product categories.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_pcc_number',
			[
				'label'   => esc_html__( 'Number of Categories', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_pcc_hide_empty',
			[
				'label'        => esc_html__( 'Hide Empty Categories', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_pcc_orderby',
			[
				'label'   => esc_html__( 'Sort Categories By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
					'count' => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
					'id'    => esc_html__( 'Category ID', 'awesome-widgets-elementor' ),
					'slug'  => esc_html__( 'Slug', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pcc_order',
			[
				'label'   => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending (A–Z / Low)', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending (Z–A / High)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_section_settings',
			[
				'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pcc_card_style',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'overlay',
				'options'      => [
					'overlay'   => esc_html__( 'Overlay Info Box (On Photo)', 'awesome-widgets-elementor' ),
					'editorial' => esc_html__( 'Clean Card (Text Below Photo)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pcc-style-',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_pcc_image_size',
				'default' => 'large',
			]
		);

		$this->add_control(
			'awea_pcc_show_count',
			[
				'label'        => esc_html__( 'Show Product Count', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_section_slider',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_pcc_slides_per_view',
			[
				'label'          => esc_html__( 'Slides to Show', 'awesome-widgets-elementor' ),
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
			'awea_pcc_slide_gap',
			[
				'label'      => esc_html__( 'Space Between Slides', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_pcc_carousel_arrows',
			[
				'label'        => esc_html__( 'Show Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pcc_carousel_dots',
			[
				'label'        => esc_html__( 'Show Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pcc_carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pcc_carousel_autoplay',
			[
				'label'        => esc_html__( 'Autoplay Slides', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pcc_carousel_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_pcc_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pcc_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_pcc_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pcc_carousel_transition_speed',
			[
				'label'   => esc_html__( 'Slide Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 50,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pcc_card_aspect_ratio',
			[
				'label'     => esc_html__( 'Photo Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/5'  => '4:5 (Portrait)',
					'3/4'  => '3:4 (Classic)',
					'16/9' => '16:9 (Widescreen)',
				],
				'selectors' => [
					'{{WRAPPER}}.awea-pcc-style-overlay .awea-product-category, {{WRAPPER}}.awea-pcc-style-editorial .awea-product-category-img-link' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pcc_card_radius',
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
					'{{WRAPPER}} .awea-product-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_pcc_img_filter',
				'label'    => esc_html__( 'Photo Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-product-category-img-link img',
			]
		);

		$this->start_controls_tabs( 'awea_pcc_card_tabs' );

		$this->start_controls_tab(
			'awea_pcc_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pcc_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-product-category',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pcc_card_border',
				'selector'       => '{{WRAPPER}} .awea-product-category',
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
				'name'     => 'awea_pcc_card_shadow',
				'selector' => '{{WRAPPER}} .awea-product-category',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pcc_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pcc_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-category:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pcc_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-product-category:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. GLASS INFO BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_style_dock',
			[
				'label'     => esc_html__( 'Glass Info Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_pcc_card_style' => 'overlay' ],
			]
		);

		$this->add_control(
			'awea_pcc_dock_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-pcc-style-overlay .awea-product-category-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_pcc_dock_border',
				'selector' => '{{WRAPPER}}.awea-pcc-style-overlay .awea-product-category-content',
			]
		);

		$this->add_responsive_control(
			'awea_pcc_dock_radius',
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
					'{{WRAPPER}}.awea-pcc-style-overlay .awea-product-category-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & COUNT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_style_text',
			[
				'label' => esc_html__( 'Text & Count', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pcc_title_color',
			[
				'label'     => esc_html__( 'Category Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pcc_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-category:hover .awea-product-category-link, {{WRAPPER}} .awea-product-category-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pcc_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-category-link',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pcc_title_shadow',
				'selector' => '{{WRAPPER}} .awea-product-category-link',
			]
		);

		$this->add_control(
			'awea_pcc_count_color',
			[
				'label'     => esc_html__( 'Product Count Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-category-count' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_pcc_show_count' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_pcc_count_typo',
				'selector'  => '{{WRAPPER}} .awea-category-count',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_pcc_show_count' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. ARROWS & DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcc_style_arrows',
			[
				'label' => esc_html__( 'Arrows & Dots', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pcc_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'condition'  => [ 'awea_pcc_carousel_arrows' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pcc_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_pcc_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pcc_arrow_bg',
			[
				'label'     => esc_html__( 'Arrow Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_pcc_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_pcc_arrow_border',
				'selector'  => '{{WRAPPER}} .awea-carousel-arrow-border',
				'condition' => [ 'awea_pcc_carousel_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pcc_dots_color',
			[
				'label'     => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'condition' => [ 'awea_pcc_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pcc_dots_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_pcc_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Carousel widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$categories = $settings['awea_pcc_include_categories'] ?? [];
		$limit      = ! empty( $settings['awea_pcc_number'] ) ? absint( $settings['awea_pcc_number'] ) : 8;
		$hide_empty = 'yes' === ( $settings['awea_pcc_hide_empty'] ?? 'no' );
		$show_count = 'yes' === ( $settings['awea_pcc_show_count'] ?? 'no' );
		$thumb_size = $settings['awea_pcc_image_size_size'] ?? 'large';

		$items_desktop = ! empty( $settings['awea_pcc_slides_per_view'] ) ? (int) $settings['awea_pcc_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_pcc_slides_per_view_tablet'] ) ? (int) $settings['awea_pcc_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_pcc_slides_per_view_mobile'] ) ? (int) $settings['awea_pcc_slides_per_view_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_pcc_slide_gap']['size'] ) ? (int) $settings['awea_pcc_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_pcc_slide_gap_tablet']['size'] ) ? (int) $settings['awea_pcc_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_pcc_slide_gap_mobile']['size'] ) ? (int) $settings['awea_pcc_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_pcc_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_pcc_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_pcc_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_pcc_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause      = ( 'yes' === ( $settings['awea_pcc_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_pcc_carousel_autoplay_speed'] ) ? absint( $settings['awea_pcc_carousel_autoplay_speed'] ) : 5000;
		$anim_speed = ! empty( $settings['awea_pcc_carousel_transition_speed'] ) ? absint( $settings['awea_pcc_carousel_transition_speed'] ) : 450;
		$widget_id  = $this->get_id();

		$orderby = $settings['awea_pcc_orderby'] ?? 'name';
		$args    = [
			'taxonomy'   => 'product_cat',
			'number'     => $limit,
			'hide_empty' => $hide_empty,
			'orderby'    => $orderby,
			'order'      => $settings['awea_pcc_order'] ?? 'ASC',
		];

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['include'] = array_map( 'absint', $categories );
			if ( 'name' !== $orderby ) {
				$args['orderby'] = 'include';
			}
		}

		$product_categories = get_terms( $args );

		if ( empty( $product_categories ) || is_wp_error( $product_categories ) ) {
			return;
		}
		?>
		<div class="awea-product-category-carousel-wrap">
			<div class="awea-product-category-carousel owl-carousel"
				 id="awea-cat-carousel-<?php echo esc_attr( $widget_id ); ?>"
				 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-dots="<?php echo esc_attr( $dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php foreach ( $product_categories as $category ) :
					$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
					$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, $thumb_size ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
					$term_link    = get_term_link( $category );
					if ( is_wp_error( $term_link ) ) {
						continue;
					}
					?>
					<div class="awea-product-category-slide">
						<article class="awea-product-category">

							<a href="<?php echo esc_url( $term_link ); ?>" class="awea-product-category-img-link" aria-label="<?php echo esc_attr( $category->name ); ?>">
								<?php if ( ! empty( $image_url ) ) : ?>
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy" />
								<?php endif; ?>
							</a>

							<div class="awea-product-category-content">
								<a href="<?php echo esc_url( $term_link ); ?>" class="awea-product-category-link">
									<?php echo esc_html( $category->name ); ?>
								</a>
								<?php if ( $show_count ) : ?>
									<span class="awea-category-count">(<?php echo esc_html( (string) $category->count ); ?>)</span>
								<?php endif; ?>
							</div>

						</article>
					</div>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		if (typeof jQuery !== 'undefined') {
			jQuery(window).on('elementor/frontend/init', function () {
				elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-category-carousel.default', function ($scope) {
					var $carousel = $scope.find('.awea-product-category-carousel');
					if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

					if ($carousel.hasClass('owl-loaded')) {
						$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
						$carousel.find('.owl-stage-outer').children().unwrap();
					}

					var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
					var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
					var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;
					var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10) || 24;
					var gapTablet    = parseInt($carousel.data('gap-tablet'), 10) || 20;
					var gapMobile    = parseInt($carousel.data('gap-mobile'), 10) || 16;
					var isRtl        = document.dir === 'rtl' || document.documentElement.dir === 'rtl';

					$carousel.owlCarousel({
						rtl: isRtl,
						nav: $carousel.data('arrows') === 'yes',
						dots: $carousel.data('dots') === 'yes',
						loop: $carousel.data('loop') === 'yes',
						autoplay: $carousel.data('autoplay') === 'yes',
						autoplayTimeout: parseInt($carousel.data('timeout'), 10) || 5000,
						smartSpeed: parseInt($carousel.data('speed'), 10) || 450,
						autoplayHoverPause: $carousel.data('pause') === 'yes',
						navText: [
							'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>',
							'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right" aria-hidden="true"></i></div>'
						],
						responsive: {
							0: { items: itemsMobile, margin: gapMobile },
							768: { items: itemsTablet, margin: gapTablet },
							1025: { items: itemsDesktop, margin: gapDesktop }
						}
					});
				});
			});
		}
		</script>
		<?php
	}
}