<?php
/**
 * Awesome Product Carousel Studio Widget.
 * Architectural WooCommerce Product Slider with Live Cart Status & Global Kits.
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

class Widget_Awesome_Product_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Carousel Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-carousel-loop';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product', 'carousel', 'slider', 'shop', 'store' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: QUERY & SOURCE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_query',
			[
				'label' => esc_html__( 'Product Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_count',
			[
				'label'   => esc_html__( 'Number of Products', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
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
			'awea_product_categories',
			[
				'label'       => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
			]
		);

		$this->add_control(
			'awea_orderby',
			[
				'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => 'Date',
					'title'         => 'Title',
					'price'         => 'Price',
					'popularity'    => 'Popularity (Sales)',
					'rating'        => 'Average Rating',
					'rand'          => 'Random',
				],
			]
		);

		$this->add_control(
			'awea_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => 'ASC',
					'DESC' => 'DESC',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_slides_per_view',
			[
				'label'              => esc_html__( 'Items Per Slide', 'awesome-widgets-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '3',
				'options'            => [
					'1' => '1 Item',
					'2' => '2 Items',
					'3' => '3 Items',
					'4' => '4 Items',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'awea_carousel_arrows',
			[
				'label'        => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_dots',
			[
				'label'        => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [ 'awea_carousel_autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD SHELL & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Product Card Shell', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-product-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-product-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-product-card',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-product-card:hover',
			]
		);

		$this->add_responsive_control(
			'awea_card_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift (Y-Axis)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -30, 'max' => 0 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: SALE BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_sale',
			[
				'label' => esc_html__( 'Sale Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-sale-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_sale_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-sale-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sale_typo',
				'selector' => '{{WRAPPER}} .awea-product-sale-badge',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY & PRICES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typo',
			[
				'label' => esc_html__( 'Typography & Pricing', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Product Title
		$this->add_control(
			'awea_heading_title',
			[
				'label' => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .awea-product-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-product-title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Price
		$this->add_control(
			'awea_heading_price',
			[
				'label'     => esc_html__( 'Price Display', 'awesome-widgets-elementor' ),
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
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typo',
				'selector' => '{{WRAPPER}} .awea-product-price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: ADD TO CART BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_button',
			[
				'label' => esc_html__( 'Add to Cart Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-product-cart-btn',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
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
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-cart-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-cart-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn_border',
				'selector' => '{{WRAPPER}} .awea-product-cart-btn',
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
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-cart-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-cart-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-cart-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-cart-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Carousel Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings     = $this->get_settings_for_display();
		$num_products = ! empty( $settings['awea_post_count'] ) ? absint( $settings['awea_post_count'] ) : 8;
		$order        = $settings['awea_order'] ?? 'DESC';
		$orderby      = $settings['awea_orderby'] ?? 'date';
		$categories   = $settings['awea_product_categories'] ?? [];
		$slides_view  = $settings['awea_slides_per_view'] ?? '3';
		$arrows       = 'yes' === ( $settings['awea_carousel_arrows'] ?? 'no' );
		$dots         = 'yes' === ( $settings['awea_carousel_dots'] ?? 'no' );
		$loop         = 'yes' === ( $settings['awea_carousel_loop'] ?? 'no' );
		$autoplay     = 'yes' === ( $settings['awea_carousel_autoplay'] ?? 'no' );
		$auto_speed   = ! empty( $settings['awea_carousel_autoplay_speed'] ) ? absint( $settings['awea_carousel_autoplay_speed'] ) : 5000;
		$widget_id    = $this->get_id();

		$args = [
			'posts_per_page'      => $num_products,
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
		];

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => array_map( 'absint', $categories ),
				],
			];
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}
		?>
		<div class="awea-product-carousel-wrap">
			<div class="awea-product-carousel owl-carousel"
			     id="awea-prod-carousel-<?php echo esc_attr( $widget_id ); ?>"
			     data-items="<?php echo esc_attr( $slides_view ); ?>"
			     data-arrows="<?php echo esc_attr( $arrows ? 'true' : 'false' ); ?>"
			     data-dots="<?php echo esc_attr( $dots ? 'true' : 'false' ); ?>"
			     data-loop="<?php echo esc_attr( $loop ? 'true' : 'false' ); ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>"
			     data-speed="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php 
				while ( $query->have_posts() ) : $query->the_post();
					$product = wc_get_product( get_the_ID() );
					if ( ! $product ) {
						continue;
					}
					$is_on_sale = $product->is_on_sale();
				?>
					<div class="awea-product-slide">
						<article class="awea-product-card">
							
							<!-- Image Canvas & Sale Badge -->
							<div class="awea-product-img-wrap">
								<?php if ( $is_on_sale ) : ?>
									<span class="awea-product-sale-badge"><?php esc_html_e( 'Sale', 'awesome-widgets-elementor' ); ?></span>
								<?php endif; ?>

								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', [ 'class' => 'awea-product-img', 'loading' => 'lazy' ] ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea-product-img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								<?php endif; ?>
							</div>

							<!-- Body Content -->
							<div class="awea-product-body">
								<h3 class="awea-product-title">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
								</h3>

								<div class="awea-product-price">
									<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>

							<!-- Footer Action Button -->
							<div class="awea-product-footer">
								<?php 
								$cart_url = wc_get_cart_url();
								$in_cart  = false;
								if ( WC()->cart ) {
									$cart_id = WC()->cart->generate_cart_id( $product->get_id() );
									$in_cart = WC()->cart->find_product_in_cart( $cart_id );
								}

								if ( $in_cart ) :
								?>
									<a href="<?php echo esc_url( $cart_url ); ?>" class="awea-product-cart-btn awea-in-cart">
										<?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?>
									</a>
								<?php else : ?>
									<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
									   class="awea-product-cart-btn ajax_add_to_cart add_to_cart_button" 
									   data-product_id="<?php echo esc_attr( (string) $product->get_id() ); ?>" 
									   data-quantity="1" 
									   rel="nofollow">
										<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</a>
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
		<?php
	}
}