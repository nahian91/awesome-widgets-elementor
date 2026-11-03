<?php
/**
 * Awesome Product List Studio Widget.
 * Architectural WooCommerce Vertical Product List with Advanced Sorting & Global Kits.
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

class Widget_Awesome_Product_List extends Widget_Base {

	public function get_name() {
		return 'awesome-product-list';
	}

	public function get_title() {
		return esc_html__( 'Product List Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-list';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product list', 'vertical list', 'catalog', 'store' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: SECTION HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_list_header',
			[
				'label' => esc_html__( 'Section Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_section_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Featured Products', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_align',
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
					'{{WRAPPER}} .awea-product-list-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: QUERY & SORTING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_list_query',
			[
				'label' => esc_html__( 'Product Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_count',
			[
				'label'   => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_product_orderby',
			[
				'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'        => esc_html__( 'Latest Products', 'awesome-widgets-elementor' ),
					'top_rated'     => esc_html__( 'Top Selling (Total Sales)', 'awesome-widgets-elementor' ),
					'random'        => esc_html__( 'Random', 'awesome-widgets-elementor' ),
					'featured'      => esc_html__( 'Featured Products', 'awesome-widgets-elementor' ),
					'price_low'     => esc_html__( 'Price: Low to High', 'awesome-widgets-elementor' ),
					'price_high'    => esc_html__( 'Price: High to Low', 'awesome-widgets-elementor' ),
					'most_reviewed' => esc_html__( 'Most Reviewed', 'awesome-widgets-elementor' ),
					'on_sale'       => esc_html__( 'On Sale', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CONTAINER SHELL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_container',
			[
				'label' => esc_html__( 'Container Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_container_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_container_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-list-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_container_border',
				'selector' => '{{WRAPPER}} .awea-product-list-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_container_shadow',
				'selector' => '{{WRAPPER}} .awea-product-list-wrap',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: THUMBNAIL IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_image',
			[
				'label' => esc_html__( 'Thumbnail Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_thumb_size',
			[
				'label'      => esc_html__( 'Thumbnail Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 60, 'max' => 160 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 96 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_thumb_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_thumb_border',
				'selector' => '{{WRAPPER}} .awea-product-list-thumb',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY (TITLE & PRICE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography & Pricing', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Section Header Title
		$this->add_control(
			'awea_heading_sec_title',
			[
				'label' => esc_html__( 'Section Header Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_sec_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-list-header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sec_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-list-header',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_sec_title_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Product Item Title
		$this->add_control(
			'awea_heading_item_title',
			[
				'label'     => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .awea-product-list-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-list-title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Product Price
		$this->add_control(
			'awea_heading_item_price',
			[
				'label'     => esc_html__( 'Product Price', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_price_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typo',
				'selector' => '{{WRAPPER}} .awea-product-list-price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_row_gap',
			[
				'label'      => esc_html__( 'Gap Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-list-row:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product List Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$sec_title  = $settings['awea_section_title'] ?? '';
		$sec_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
		$count      = ! empty( $settings['awea_product_count'] ) ? absint( $settings['awea_product_count'] ) : 5;
		$orderby    = $settings['awea_product_orderby'] ?? 'latest';

		$args = [
			'post_type'      => 'product',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		];

		switch ( $orderby ) {
			case 'top_rated':
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'random':
				$args['orderby'] = 'rand';
				break;
			case 'featured':
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_visibility',
						'field'    => 'slug',
						'terms'    => [ 'featured' ],
						'operator' => 'IN',
					],
				];
				break;
			case 'price_low':
				$args['meta_key'] = '_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;
			case 'price_high':
				$args['meta_key'] = '_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'most_reviewed':
				$args['orderby'] = 'comment_count';
				$args['order']   = 'DESC';
				break;
			case 'on_sale':
				$sale_ids = wc_get_product_ids_on_sale();
				$args['post__in'] = ! empty( $sale_ids ) ? $sale_ids : [ 0 ];
				break;
			case 'latest':
			default:
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}
		?>
		<div class="awea-product-list-wrap">
			
			<?php if ( ! empty( $sec_title ) ) : ?>
				<<?php echo esc_attr( $sec_tag ); ?> class="awea-product-list-header">
					<?php echo esc_html( $sec_title ); ?>
				</<?php echo esc_attr( $sec_tag ); ?>>
			<?php endif; ?>

			<div class="awea-product-list-items" role="list">
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
					<div class="awea-product-list-row <?php echo $in_cart ? 'product-in-cart' : ''; ?>">
						
						<!-- Thumbnail Image -->
						<div class="awea-product-list-thumb">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" aria-label="<?php the_title_attribute(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'thumbnail', [ 'loading' => 'lazy' ] ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								<?php endif; ?>
							</a>
						</div>

						<!-- Content & Price Details -->
						<div class="awea-product-list-content">
							<h4 class="awea-product-list-title">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
							</h4>

							<div class="awea-product-list-meta">
								<span class="awea-product-list-price"><?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

								<div class="awea-product-list-action">
									<?php if ( $in_cart ) : ?>
										<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" class="awea-product-grid-btn awea-view-cart">
											<?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?>
										</a>
									<?php else : ?>
										<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID(), home_url() ) ); ?>"
										   data-product_id="<?php echo esc_attr( (string) get_the_ID() ); ?>"
										   data-quantity="1"
										   class="awea-product-grid-btn awea-add-to-cart ajax_add_to_cart add_to_cart_button"
										   rel="nofollow">
											<?php echo esc_html( $product->add_to_cart_text() ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>

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
						$button.closest('.awea-product-list-row').addClass('product-in-cart');
					}
				});
			});
		}
		</script>
		<?php
	}
}