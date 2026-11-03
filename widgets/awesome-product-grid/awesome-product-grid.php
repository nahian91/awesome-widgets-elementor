<?php
/**
 * Awesome Product Grid Studio Widget.
 * Architectural WooCommerce Product Grid with Kinetic Border Beams & AJAX Cart Sync.
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
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Grid Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product grid', 'shop', 'store', 'catalog', 'ajax cart' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: QUERY & SOURCE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_query',
			[
				'label' => esc_html__( 'Product Query & Source', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_query_type',
			[
				'label'   => esc_html__( 'Query Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'   => esc_html__( 'Latest Products', 'awesome-widgets-elementor' ),
					'manual'   => esc_html__( 'Manual Selection', 'awesome-widgets-elementor' ),
					'category' => esc_html__( 'By Category', 'awesome-widgets-elementor' ),
				],
			]
		);

		// Fetch Products for Manual Selection Dropdown
		$product_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$all_prods = get_posts( [
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			] );
			foreach ( $all_prods as $p ) {
				$product_options[ $p->ID ] = $p->post_title;
			}
		}

		$this->add_control(
			'awea_manual_product_ids',
			[
				'label'       => esc_html__( 'Select Products', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $product_options,
				'condition'   => [ 'awea_query_type' => 'manual' ],
			]
		);

		// Fetch Categories Dropdown
		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$terms = get_terms( [
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			] );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$cat_options[ $term->slug ] = $term->name;
				}
			}
		}

		$this->add_control(
			'awea_product_categories',
			[
				'label'       => esc_html__( 'Select Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'condition'   => [ 'awea_query_type' => 'category' ],
			]
		);

		$this->add_control(
			'awea_product_number',
			[
				'label'     => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'max'       => 50,
				'condition' => [ 'awea_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_product_orderby',
			[
				'label'     => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => [
					'date'  => 'Date',
					'title' => 'Title',
					'price' => 'Price',
					'rand'  => 'Random',
				],
				'condition' => [ 'awea_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_product_order',
			[
				'label'     => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'DESC',
				'options'   => [
					'ASC'  => 'ASC',
					'DESC' => 'DESC',
				],
				'condition' => [ 'awea_query_type!' => 'manual' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: GRID LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
					'{{WRAPPER}} .awea-grid-row' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-grid-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD SHELL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 32, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-card, {{WRAPPER}} .awea-card::after' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-card',
			]
		);

		$this->add_responsive_control(
			'awea_card_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .awea-card' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_kinetic_glow_color',
			[
				'label'     => esc_html__( 'Border Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-card::after' => 'background: conic-gradient(from var(--bento-angle), transparent 70%, {{VALUE}}, transparent);',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: META & BADGES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_meta',
			[
				'label' => esc_html__( 'Sale Badge & Category', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Sale Badge
		$this->add_control(
			'awea_heading_sale',
			[
				'label' => esc_html__( 'Sale Badge', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-badge-sale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sale_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ef4444',
				'selectors' => [
					'{{WRAPPER}} .awea-badge-sale' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sale_typo',
				'selector' => '{{WRAPPER}} .awea-badge-sale',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Category Brand
		$this->add_control(
			'awea_heading_category',
			[
				'label'     => esc_html__( 'Category / Brand', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_brand_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-brand' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_brand_typo',
				'selector' => '{{WRAPPER}} .awea-brand',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TITLE PANEL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_title',
			[
				'label' => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-name a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: BUTTON & PRICING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_button',
			[
				'label' => esc_html__( 'Pricing & Add to Cart', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_current_price_color',
			[
				'label'     => esc_html__( 'Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-current-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typo',
				'selector' => '{{WRAPPER}} .awea-current-price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_heading_atc',
			[
				'label'     => esc_html__( 'Add to Cart Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_btn_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_btn_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-buy-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-buy-btn' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_btn_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color_hover',
			[
				'label'     => esc_html__( 'Text/Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-card:hover .awea-buy-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-card:hover .awea-buy-btn' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-buy-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Grid Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$query_type = $settings['awea_query_type'] ?? 'latest';
		$title_tag  = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );

		$args = [
			'post_type'   => 'product',
			'post_status' => 'publish',
		];

		if ( 'manual' === $query_type && ! empty( $settings['awea_manual_product_ids'] ) ) {
			$args['post__in']       = array_map( 'absint', $settings['awea_manual_product_ids'] );
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = -1;
		} else {
			$args['posts_per_page'] = ! empty( $settings['awea_product_number'] ) ? absint( $settings['awea_product_number'] ) : 6;
			$args['order']          = $settings['awea_product_order'] ?? 'DESC';
			$args['orderby']        = $settings['awea_product_orderby'] ?? 'date';

			if ( 'category' === $query_type && ! empty( $settings['awea_product_categories'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $settings['awea_product_categories'],
					],
				];
			}
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}
		?>
		<div class="awea-product-grid-wrap">
			<div class="awea-grid-row">
				<?php 
				while ( $query->have_posts() ) : $query->the_post();
					$product = wc_get_product( get_the_ID() );
					if ( ! $product ) {
						continue;
					}

					$in_cart = false;
					if ( WC()->cart ) {
						foreach ( WC()->cart->get_cart() as $item ) {
							if ( (int) $item['product_id'] === (int) get_the_ID() ) {
								$in_cart = true;
								break;
							}
						}
					}
				?>
					<div class="awea-grid-item">
						<article class="awea-card <?php echo $in_cart ? 'product-in-cart' : ''; ?>">
							
							<?php if ( $product->is_on_sale() ) : ?>
								<span class="awea-badge-sale"><?php esc_html_e( 'SALE', 'awesome-widgets-elementor' ); ?></span>
							<?php endif; ?>

							<div class="awea-image-container">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', [ 'loading' => 'lazy' ] ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								<?php endif; ?>
							</div>

							<div class="awea-post-content">
								<p class="awea-brand">
									<?php echo esc_html( wp_strip_all_tags( wc_get_product_category_list( get_the_ID(), ', ', '', '' ) ) ); ?>
								</p>

								<<?php echo esc_attr( $title_tag ); ?> class="awea-product-name">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
								</<?php echo esc_attr( $title_tag ); ?>>
							</div>

							<div class="awea-footer">
								<div class="awea-pricing">
									<?php if ( $product->is_on_sale() ) : ?>
										<span class="awea-old-price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
									<?php endif; ?>
									<span class="awea-current-price"><?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?></span>
								</div>

								<div class="awea-action-container">
									<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID(), home_url() ) ); ?>" 
									   data-product_id="<?php echo esc_attr( (string) get_the_ID() ); ?>"
									   class="awea-buy-btn awea-add-to-cart-btn ajax_add_to_cart add_to_cart_button"
									   aria-label="<?php esc_attr_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?>">
										<i class="fas fa-shopping-bag" aria-hidden="true"></i>
										<span class="awea-btn-label"><?php esc_html_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?></span>
									</a>

									<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" 
									   class="awea-buy-btn awea-view-cart-btn"
									   aria-label="<?php esc_attr_e( 'View Cart', 'awesome-widgets-elementor' ); ?>">
										<i class="fas fa-check" aria-hidden="true"></i>
										<span class="awea-btn-label"><?php esc_html__( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
									</a>
								</div>
							</div>

						</article>
					</div>
				<?php 
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>

		<!-- Scoped AJAX Cart Sync Script -->
		<script>
		if (typeof jQuery !== 'undefined') {
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