<?php
/**
 * Awesome Product Grid Widget.
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

class Widget_Awesome_Product_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Grid', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product grid', 'shop', 'store', 'catalog', 'ecommerce' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. PRODUCT QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_section_query',
			[
				'label' => esc_html__( 'Product Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pgd_query_type',
			[
				'label'   => esc_html__( 'Product Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'   => esc_html__( 'All Products', 'awesome-widgets-elementor' ),
					'category' => esc_html__( 'Filter by Categories', 'awesome-widgets-elementor' ),
					'featured' => esc_html__( 'Featured Products Only', 'awesome-widgets-elementor' ),
					'on_sale'  => esc_html__( 'On Sale Products Only', 'awesome-widgets-elementor' ),
					'manual'   => esc_html__( 'Pick Specific Products', 'awesome-widgets-elementor' ),
				],
			]
		);

		$product_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$all_prods = get_posts(
				[
					'post_type'      => 'product',
					'posts_per_page' => 200,
					'post_status'    => 'publish',
					'no_found_rows'  => true,
				]
			);
			foreach ( $all_prods as $p ) {
				$product_options[ $p->ID ] = $p->post_title;
			}
		}

		$this->add_control(
			'awea_pgd_manual_product_ids',
			[
				'label'       => esc_html__( 'Choose Products', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $product_options,
				'condition'   => [ 'awea_pgd_query_type' => 'manual' ],
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) && taxonomy_exists( 'product_cat' ) ) {
			$terms = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$cat_options[ $term->slug ] = $term->name;
				}
			}
		}

		$this->add_control(
			'awea_pgd_product_categories',
			[
				'label'       => esc_html__( 'Filter by Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'condition'   => [ 'awea_pgd_query_type' => 'category' ],
			]
		);

		$this->add_control(
			'awea_pgd_product_number',
			[
				'label'     => esc_html__( 'Number of Products', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'max'       => 50,
				'condition' => [ 'awea_pgd_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_pgd_product_orderby',
			[
				'label'     => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => [
					'date'       => esc_html__( 'Publish Date', 'awesome-widgets-elementor' ),
					'title'      => esc_html__( 'Product Name', 'awesome-widgets-elementor' ),
					'price'      => esc_html__( 'Price', 'awesome-widgets-elementor' ),
					'popularity' => esc_html__( 'Best Selling', 'awesome-widgets-elementor' ),
					'rand'       => esc_html__( 'Random Order', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_pgd_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_pgd_product_order',
			[
				'label'     => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'DESC',
				'options'   => [
					'DESC' => esc_html__( 'Descending (High / Newest)', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Ascending (Low / Oldest)', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_pgd_query_type!' => 'manual' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_section_elements',
			[
				'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pgd_show_sale_badge',
			[
				'label'        => esc_html__( 'Show Sale Tag', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pgd_sale_text',
			[
				'label'     => esc_html__( 'Sale Tag Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'SALE', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_pgd_show_sale_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pgd_show_category',
			[
				'label'        => esc_html__( 'Show Category Name', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pgd_show_rating',
			[
				'label'        => esc_html__( 'Show Star Rating', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_pgd_show_button',
			[
				'label'        => esc_html__( 'Show Add to Cart Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pgd_title_tag',
			[
				'label'     => esc_html__( 'Product Heading Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
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
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. GRID & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_section_layout',
			[
				'label' => esc_html__( 'Grid & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_pgd_columns',
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
					'{{WRAPPER}} .awea-product-grid-wrap .awea-grid-row' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pgd_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-grid-row' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pgd_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-grid-row' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pgd_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pgd-motion-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pgd_card_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-card, {{WRAPPER}} .awea-product-grid-wrap .awea-card::after' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_pgd_card_tabs' );

		$this->start_controls_tab(
			'awea_pgd_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pgd_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pgd_card_border',
				'selector'       => '{{WRAPPER}} .awea-product-grid-wrap .awea-card',
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
				'name'     => 'awea_pgd_card_shadow',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pgd_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pgd_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-card:hover',
			]
		);

		$this->add_control(
			'awea_pgd_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pgd_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Animated Border Glow
		$this->add_control(
			'awea_pgd_heading_beam',
			[
				'label'     => esc_html__( 'Animated Border Glow', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_pgd_enable_beam',
			[
				'label'        => esc_html__( 'Enable Glow Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pgd_beam_color',
			[
				'label'     => esc_html__( 'Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-card' => '--awea-pgd-beam-color: {{VALUE}};',
				],
				'condition' => [ 'awea_pgd_enable_beam' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_pgd_beam_speed',
			[
				'label'      => esc_html__( 'Glow Speed (Seconds)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-card' => '--awea-pgd-beam-speed: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_pgd_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. PRODUCT PHOTO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_style_image',
			[
				'label' => esc_html__( 'Product Photo', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_pgd_image_size',
				'default' => 'woocommerce_thumbnail',
			]
		);

		$this->add_responsive_control(
			'awea_pgd_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Photo Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1/1',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/5'  => '4:5 (Portrait)',
					'3/4'  => '3:4 (Classic)',
					'16/9' => '16:9 (Widescreen)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-image-container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pgd_image_bg',
			[
				'label'     => esc_html__( 'Image Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-image-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_pgd_img_filter',
				'label'    => esc_html__( 'Photo Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-image-container img',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. SALE TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_style_badge',
			[
				'label'     => esc_html__( 'Sale Tag', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_pgd_show_sale_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pgd_sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-badge-sale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pgd_sale_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-badge-sale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pgd_sale_typo',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-badge-sale',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TEXT & CATEGORY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_style_text',
			[
				'label' => esc_html__( 'Text & Category', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pgd_heading_cat',
			[
				'label'     => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_pgd_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pgd_brand_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-brand' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_pgd_show_category' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_pgd_brand_typo',
				'selector'  => '{{WRAPPER}} .awea-product-grid-wrap .awea-brand',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_pgd_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pgd_heading_title',
			[
				'label'     => esc_html__( 'Product Name', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_pgd_title_tabs' );

		$this->start_controls_tab(
			'awea_pgd_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pgd_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-product-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pgd_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pgd_title_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-card:hover .awea-product-name a, {{WRAPPER}} .awea-product-grid-wrap .awea-product-name a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pgd_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-product-name a',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pgd_title_shadow',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-product-name',
			]
		);

		$this->add_control(
			'awea_pgd_star_color',
			[
				'label'     => esc_html__( 'Star Rating Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'separator' => 'before',
				'condition' => [ 'awea_pgd_show_rating' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-pgd-rating .star-rating span::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. PRICE & BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pgd_style_button',
			[
				'label' => esc_html__( 'Price & Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pgd_current_price_color',
			[
				'label'     => esc_html__( 'Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-current-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pgd_price_typo',
				'selector' => '{{WRAPPER}} .awea-product-grid-wrap .awea-current-price',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_pgd_btn_typo',
				'label'     => esc_html__( 'Button Font', 'awesome-widgets-elementor' ),
				'selector'  => '{{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
				'condition' => [ 'awea_pgd_show_button' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_pgd_btn_tabs',
			[ 'condition' => [ 'awea_pgd_show_button' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_pgd_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pgd_btn_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pgd_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pgd_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pgd_btn_color_hover',
			[
				'label'     => esc_html__( 'Button Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn:hover, {{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pgd_btn_bg_hover',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn:hover, {{WRAPPER}} .awea-product-grid-wrap .awea-buy-btn:focus-visible' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Grid widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings    = $this->get_settings_for_display();
		$query_type  = $settings['awea_pgd_query_type'] ?? 'latest';
		$title_tag   = Utils::validate_html_tag( $settings['awea_pgd_title_tag'] ?? 'h3' );
		$has_beam    = ( 'yes' === ( $settings['awea_pgd_enable_beam'] ?? 'no' ) );
		$show_sale   = ( 'yes' === ( $settings['awea_pgd_show_sale_badge'] ?? 'no' ) );
		$sale_text   = ! empty( $settings['awea_pgd_sale_text'] ) ? $settings['awea_pgd_sale_text'] : esc_html__( 'SALE', 'awesome-widgets-elementor' );
		$show_cat    = ( 'yes' === ( $settings['awea_pgd_show_category'] ?? 'no' ) );
		$show_rating = ( 'yes' === ( $settings['awea_pgd_show_rating'] ?? 'no' ) );
		$show_btn    = ( 'yes' === ( $settings['awea_pgd_show_button'] ?? 'yes' ) );
		$thumb_size  = $settings['awea_pgd_image_size_size'] ?? 'woocommerce_thumbnail';

		$args = [
			'post_type'     => 'product',
			'post_status'   => 'publish',
			'no_found_rows' => true,
		];

		if ( 'manual' === $query_type && ! empty( $settings['awea_pgd_manual_product_ids'] ) ) {
			$args['post__in']       = array_map( 'absint', $settings['awea_pgd_manual_product_ids'] );
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = -1;
		} else {
			$args['posts_per_page'] = ! empty( $settings['awea_pgd_product_number'] ) ? absint( $settings['awea_pgd_product_number'] ) : 6;
			$orderby                = $settings['awea_pgd_product_orderby'] ?? 'date';
			$args['order']          = $settings['awea_pgd_product_order'] ?? 'DESC';

			if ( 'price' === $orderby ) {
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				$args['meta_key'] = '_price';
				$args['orderby']  = 'meta_value_num';
			} elseif ( 'popularity' === $orderby ) {
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
			} else {
				$args['orderby'] = $orderby;
			}

			if ( 'category' === $query_type && ! empty( $settings['awea_pgd_product_categories'] ) ) {
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $settings['awea_pgd_product_categories'],
					],
				];
			} elseif ( 'featured' === $query_type ) {
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_visibility',
						'field'    => 'slug',
						'terms'    => [ 'featured' ],
						'operator' => 'IN',
					],
				];
			} elseif ( 'on_sale' === $query_type ) {
				$sale_ids         = wc_get_product_ids_on_sale();
				$args['post__in'] = ! empty( $sale_ids ) ? $sale_ids : [ 0 ];
			}
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}

		$cart_product_ids = [];
		if ( WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $cart_item ) {
				$cart_product_ids[ (int) $cart_item['product_id'] ] = true;
			}
		}

		$card_classes_base = [ 'awea-card' ];
		if ( $has_beam ) {
			$card_classes_base[] = 'awea-has-beam';
		}
		?>
		<div class="awea-product-grid-wrap">
			<div class="awea-grid-row" role="list">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$product_id = get_the_ID();
					$product    = wc_get_product( $product_id );
					if ( ! $product ) {
						continue;
					}

					$in_cart      = isset( $cart_product_ids[ $product_id ] );
					$supports_ajx = $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock();
					$btn_classes  = [ 'awea-buy-btn', 'awea-add-to-cart-btn', 'product_type_' . $product->get_type() ];
					if ( $supports_ajx ) {
						$btn_classes[] = 'ajax_add_to_cart';
						$btn_classes[] = 'add_to_cart_button';
					}

					$card_classes = $card_classes_base;
					if ( $in_cart ) {
						$card_classes[] = 'product-in-cart';
					}
					?>
					<div class="awea-grid-item" role="listitem">
						<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

							<?php if ( $show_sale && $product->is_on_sale() ) : ?>
								<span class="awea-badge-sale"><?php echo esc_html( $sale_text ); ?></span>
							<?php endif; ?>

							<div class="awea-image-container">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" aria-label="<?php the_title_attribute(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( $thumb_size, [ 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
									<?php endif; ?>
								</a>
							</div>

							<div class="awea-post-content">
								<?php if ( $show_cat ) :
									$cat_text = wp_strip_all_tags( wc_get_product_category_list( $product_id, ', ', '', '' ) );
									if ( ! empty( $cat_text ) ) :
										?>
										<p class="awea-brand"><?php echo esc_html( $cat_text ); ?></p>
										<?php
									endif;
								endif; ?>

								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-product-name">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( $show_rating && wc_review_ratings_enabled() && $product->get_average_rating() > 0 ) : ?>
									<div class="awea-pgd-rating">
										<?php echo wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="awea-footer">
								<div class="awea-pricing">
									<?php if ( $product->is_on_sale() && '' !== $product->get_regular_price() ) : ?>
										<span class="awea-old-price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
									<?php endif; ?>
									<span class="awea-current-price"><?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?></span>
								</div>

								<?php if ( $show_btn ) : ?>
									<div class="awea-action-container">
										<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
										   data-product_id="<?php echo esc_attr( (string) $product_id ); ?>"
										   data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
										   data-quantity="1"
										   class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>"
										   aria-label="<?php esc_attr_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?>"
										   rel="nofollow">
											<i class="fas fa-shopping-bag" aria-hidden="true"></i>
											<span class="awea-btn-label"><?php echo esc_html( $product->add_to_cart_text() ); ?></span>
										</a>

										<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>"
										   class="awea-buy-btn awea-view-cart-btn"
										   aria-label="<?php esc_attr_e( 'View Cart', 'awesome-widgets-elementor' ); ?>">
											<i class="fas fa-check" aria-hidden="true"></i>
											<span class="awea-btn-label"><?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
										</a>
									</div>
								<?php endif; ?>
							</div>

						</article>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>

		<script>
		if (typeof jQuery !== 'undefined' && !window.__aweaProdGridBound) {
			window.__aweaProdGridBound = true;
			jQuery(function($) {
				$(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
					if ($button && $button.length) {
						$button.closest('.awea-card').addClass('product-in-cart');
					}
				});
			});
		}
		</script>
		<?php
	}
}