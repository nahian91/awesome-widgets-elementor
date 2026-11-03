<?php
/**
 * Awesome Product Category Carousel Studio Widget.
 * Architectural WooCommerce Category Slider with Frosted Overlays & Global Kits.
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

class Widget_Awesome_Product_Category_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Category Carousel Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-nested-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'category', 'categories', 'carousel', 'slider', 'shop' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: QUERY & SOURCE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_cat_query',
			[
				'label' => esc_html__( 'Category Query', 'awesome-widgets-elementor' ),
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
				foreach ( $categories as $cat ) {$cat_options[ $cat->term_id ] =$cat->name;
				}
			}
		}

		$this->add_control(
			'awea_include_categories',
			[
				'label'       => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
			]
		);

		$this->add_control(
			'awea_hide_empty',
			[
				'label'        => esc_html__( 'Hide Empty Categories', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
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
					'id'    => 'ID',
					'count' => 'Product Count',
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
					'ASC'  => 'ASC',
					'DESC' => 'DESC',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: ELEMENTS & CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_cat_settings',
			[
				'label' => esc_html__( 'Elements & Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_count',
			[
				'label'        => esc_html__( 'Show Product Count', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
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
				'separator'          => 'before',
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
				'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-product-category',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-product-category',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CONTENT OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_content',
			[
				'label' => esc_html__( 'Content Overlay & Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_content_bg',
			[
				'label'     => esc_html__( 'Overlay Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.76)',
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_category_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-link, {{WRAPPER}} .awea-category-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_category_typography',
				'selector' => '{{WRAPPER}} .awea-product-category-link',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_content_padding',
			[
				'label'      => esc_html__( 'Overlay Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '18', 'right' => '20', 'bottom' => '18', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Carousel Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();$categories = $settings['awea_include_categories'] ?? [];$hide_empty = 'yes' === ( $settings['awea_hide_empty'] ?? 'no' );$show_count = 'yes' === ( $settings['awea_show_count'] ?? 'no' );$slides_view= $settings['awea_slides_per_view'] ?? '3';$arrows     = 'yes' === ( $settings['awea_carousel_arrows'] ?? 'no' );$dots       = 'yes' === ( $settings['awea_carousel_dots'] ?? 'no' );$loop       = 'yes' === ( $settings['awea_carousel_loop'] ?? 'no' );$autoplay   = 'yes' === ( $settings['awea_carousel_autoplay'] ?? 'no' );$auto_speed = ! empty( $settings['awea_carousel_autoplay_speed'] ) ? absint( $settings['awea_carousel_autoplay_speed'] ) : 5000;
		$widget_id  =$this->get_id();

		$args = [
			'taxonomy'   => 'product_cat',
			'hide_empty' => $hide_empty,
			'orderby'    => $settings['awea_orderby'] ?? 'name',
			'order'      => $settings['awea_order'] ?? 'ASC',
		];

		if ( ! empty( $categories ) && is_array($categories ) ) {
			$args['include'] = array_map( 'absint',$categories );
		}

		$product_categories = get_terms($args );

		if ( empty( $product_categories ) \vert{}\vert{} is_wp_error($product_categories ) ) {
			return;
		}
		?>
		<div class="awea-product-category-carousel-wrap">
			<div class="awea-product-category-carousel owl-carousel"
			     id="awea-cat-carousel-<?php echo esc_attr( $widget_id ); ?>"
			     data-items="<?php echo esc_attr( $slides_view ); ?>"
			     data-arrows="<?php echo esc_attr( $arrows ? 'true' : 'false' ); ?>"
			     data-dots="<?php echo esc_attr( $dots ? 'true' : 'false' ); ?>"
			     data-loop="<?php echo esc_attr( $loop ? 'true' : 'false' ); ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>"
			     data-speed="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php foreach ( $product_categories as $category ) :$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
				?>
					<div class="awea-product-category-slide">
						<article class="awea-product-category">
							
							<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-img-link" aria-label="<?php echo esc_attr( $category->name ); ?>">
								<?php if ( ! empty( $image_url ) ) : ?>
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy" />
								<?php endif; ?>
							</a>

							<div class="awea-product-category-content">
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-link">
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
		<?php
	}
}