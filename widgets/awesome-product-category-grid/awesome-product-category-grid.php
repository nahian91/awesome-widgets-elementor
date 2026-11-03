<?php
/**
 * Awesome Product Category Grid Studio Widget.
 * Luxury Dark-Mode Glassmorphism Category Grid with Kinetic Hover Effects.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_Category_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Category Grid Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product category', 'grid', 'shop', 'glassmorphism', 'showcase' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: QUERY & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_query',
			[
				'label' => esc_html__( 'Category Query & Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Category Options Dropdown
		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$categories = get_terms( [
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			] );
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				foreach ( $categories as $cat ) {
					$cat_options[ $cat->term_id ] = $cat->name;
				}
			}
		}

		$this->add_control(
			'awea_taxonomy_filter',
			[
				'label'       => esc_html__( 'Select Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Specific categories to show. Leave empty for all.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_posts_per_page',
			[
				'label'   => esc_html__( 'Total Items to Show', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_responsive_control(
			'awea_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1 Column',
					'2' => '2 Columns',
					'3' => '3 Columns',
					'4' => '4 Columns',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-grid-wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'awea_orderby',
			[
				'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => 'Name',
					'count' => 'Product Count',
					'id'    => 'ID',
					'slug'  => 'Slug',
					'rand'  => 'Random',
				],
			]
		);

		$this->add_control(
			'awea_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => 'Ascending',
					'DESC' => 'Descending',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: GRID & CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_grid',
			[
				'label' => esc_html__( 'Grid & Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_height',
			[
				'label'      => esc_html__( 'Card Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [ 'px' => [ 'min' => 200, 'max' => 1200 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 540 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cat-card' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_column_gap',
			[
				'label'     => esc_html__( 'Spacing (Gap)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 24 ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors' => [
					'{{WRAPPER}} .awea-grid-wrapper' => 'gap: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cat-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-cat-card',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: OVERLAY & GLASS BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_overlay',
			[
				'label' => esc_html__( 'Overlay & Glass Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'awea_tabs_overlay_styles' );

		// Normal State Tab
		$this->start_controls_tab(
			'awea_tab_overlay_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_image_overlay_bg',
				'label'    => esc_html__( 'Image Overlay Gradient', 'awesome-widgets-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cat-card::before',
			]
		);

		$this->add_control(
			'awea_glass_box_bg',
			[
				'label'     => esc_html__( 'Glass Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.06)',
				'selectors' => [
					'{{WRAPPER}} .awea-cat-info' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab(
			'awea_tab_overlay_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_glass_box_bg_hover',
			[
				'label'     => esc_html__( 'Glass Background Hover', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.14)',
				'selectors' => [
					'{{WRAPPER}} .awea-cat-card:hover .awea-cat-info' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_glow_intensity',
			[
				'label'   => esc_html__( 'Hover Glow Intensity', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
				'default' => [ 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .awea-cat-card:hover::after' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'awea_glass_blur',
			[
				'label'     => esc_html__( 'Glass Blur Intensity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 16 ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'selectors' => [
					'{{WRAPPER}} .awea-cat-info' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typo',
			[
				'label' => esc_html__( 'Typography & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subtitle Styling
		$this->add_control(
			'awea_heading_subtitle',
			[
				'label' => esc_html__( 'Subtitle Kicker', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_sub_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.65)',
				'selectors' => [
					'{{WRAPPER}} .awea-cat-info span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sub_typo',
				'selector' => '{{WRAPPER}} .awea-cat-info span',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Title Styling
		$this->add_control(
			'awea_heading_title',
			[
				'label'     => esc_html__( 'Category Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-cat-info h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-cat-info h3',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Action Link Styling
		$this->add_control(
			'awea_heading_action',
			[
				'label'     => esc_html__( 'Explore Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-view-collection' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-view-collection',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Grid Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings = $this->get_settings_for_display();
		$limit    = ! empty( $settings['awea_posts_per_page'] ) ? absint( $settings['awea_posts_per_page'] ) : 3;
		$orderby  = $settings['awea_orderby'] ?? 'name';
		$order    = $settings['awea_order'] ?? 'ASC';
		$filter   = $settings['awea_taxonomy_filter'] ?? [];

		$args = [
			'taxonomy'   => 'product_cat',
			'number'     => $limit,
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => false,
		];

		if ( ! empty( $filter ) && is_array( $filter ) ) {
			$args['include'] = array_map( 'absint', $filter );
			if ( 'name' !== $orderby ) {
				$args['orderby'] = 'include';
			}
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			if ( Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'No product categories found.', 'awesome-widgets-elementor' ) . '</div>';
			}
			return;
		}
		?>
		<div class="awea-product-category-grid-wrap">
			<div class="awea-grid-wrapper">
				<?php foreach ( $terms as $term ) : 
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
					$link         = get_term_link( $term );
				?>
					<a href="<?php echo esc_url( $link ); ?>" class="awea-cat-card">
						<?php if ( ! empty( $image_url ) ) : ?>
							<img src="<?php echo esc_url( $image_url ); ?>" class="awea-cat-image" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy" />
						<?php endif; ?>

						<div class="awea-cat-info">
							<span aria-hidden="true"><?php echo esc_html__( 'Collection', 'awesome-widgets-elementor' ); ?></span>
							<h3><?php echo esc_html( $term->name ); ?></h3>
							<div class="awea-view-collection">
								<?php echo esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ); ?>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}