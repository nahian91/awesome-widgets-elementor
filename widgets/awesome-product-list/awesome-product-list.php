<?php
/**
 * Awesome Product List Widget.
 *
 * Elementor widget that inserts a product list into the page
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_List extends Widget_Base {

	public function get_name() {
		return 'awesome-product-list';
	}

	public function get_title() {
		return esc_html__( 'Product List', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-list';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'product', 'list', 'awesome'];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'awea_product_list_title',
			[
				'label' => esc_html__('Title', 'awesome-widgets-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_list_title_heading',
			[
				'label' => __('Title', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Product Title', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_list_title_heading_align',
			[
				'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid > h4' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_product_list_items',
			[
				'label' => esc_html__('Items', 'awesome-widgets-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_list_count',
			[
				'label' => __('Number of Products', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'min' => 1,
				'max' => 50,
			]
		);

		$this->add_control(
			'awea_product_list_orderby',
			[
				'label' => __('Order By', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'     => __('Latest', 'awesome-widgets-elementor'),
					'top_rated'  => __('Top Rated', 'awesome-widgets-elementor'),
					'random'     => __('Random', 'awesome-widgets-elementor'),
					'featured'   => __('Featured', 'awesome-widgets-elementor'),
					'price_low'  => __('Price: Low to High', 'awesome-widgets-elementor'),
					'price_high' => __('Price: High to Low', 'awesome-widgets-elementor'),
					'most_reviewed' => __('Most Reviewed', 'awesome-widgets-elementor'),
					'on_sale' => __('On Sale', 'awesome-widgets-elementor'),
				],
			]
		);

		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_product_list_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_product_list_pro_message_notice', 
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => sprintf(
					'<div style="text-align:center;line-height:1.6;">
						<p style="margin-bottom:10px">%s</p>
					</div>',
					esc_html__('Awesome Widgets for Elementor Premium is coming soon with more widgets, features, and customization options.', 'awesome-widgets-elementor')
				)
			]  
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_list_layout_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Title Color
		$this->add_control(
			'awea_product_list_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid > h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Title Background
		$this->add_control(
			'awea_product_list_title_bg_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid > h4' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_list_title_typography',
				'selector' => '{{WRAPPER}} .awea-product-grid > h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		// Title Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_list_title_border',
				'selector' => '{{WRAPPER}} .awea-product-grid > h4',
			]
		);	

		// Title Padding
		$this->add_control(
			'awea_product_list_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-grid > h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_list_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image Box Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_list_image_border',
				'selector' => '{{WRAPPER}} .single-awea-product-list-img',
			]
		);	
		
		// Image Box Border Radius
		$this->add_control(
			'awea_product_list_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_list_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_list_content_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_list_content_border',
				'selector' => '{{WRAPPER}} .single-awea-product-list-box',
			]
		);	

		$this->add_control(
			'awea_product_list_contents_title_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_product_list_contents_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-content h4 a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Team Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_list_contents_title_typography',
				'selector' => '{{WRAPPER}} .single-awea-product-list-content h4 a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_product_list_contents_title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-content h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_product_list_contents_price_options',
			[
				'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_product_list_contents_price_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-meta span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Team Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_list_contents_price_typography',
				'selector' => '{{WRAPPER}} .single-awea-product-list-meta span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_list_btn_style',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_product_list_btn_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_product_list_btn_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_list_btn_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-meta .awea-product-grid-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_list_contents_btn_typography',
				'selector' => '{{WRAPPER}} .single-awea-product-list-meta .awea-product-grid-btn',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_product_list_btn_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_list_btn_color_hover',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awea-product-list-meta .awea-product-grid-btn:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}
protected function render() {
		$settings = $this->get_settings_for_display();
		$awea_product_list_title_heading = ! empty( $settings['awea_product_list_title_heading'] ) ? $settings['awea_product_list_title_heading'] : '';

		$product_count   = ! empty( $settings['awea_product_list_count'] ) ? intval( $settings['awea_product_list_count'] ) : 6;
		$product_orderby = ! empty( $settings['awea_product_list_orderby'] ) ? $settings['awea_product_list_orderby'] : 'latest';

		$args = [
			'post_type'      => 'product',
			'posts_per_page' => $product_count,
			'post_status'    => 'publish',
		];

		switch ( $product_orderby ) {
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
				$sale_products = wc_get_product_ids_on_sale();
				$args['post__in'] = ! empty( $sale_products ) ? $sale_products : [ 0 ];
				break;

			case 'latest':
			default:
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
		}

		$products = new \WP_Query( $args );

		if ( $products->have_posts() ) {
			echo '<div class="awea-product-grid">';
			if ( ! empty( $awea_product_list_title_heading ) ) {
				echo '<h4>' . esc_html( $awea_product_list_title_heading ) . '</h4>';
			}

			while ( $products->have_posts() ) {
				$products->the_post();
				global $product;

				$product_id    = get_the_ID();
				$product_link  = get_permalink( $product_id );
				$product_title = get_the_title();
				$product_price = $product->get_price_html();
				$product_image = get_the_post_thumbnail_url( $product_id, 'medium' );

				if ( ! $product_image ) {
					$product_image = wc_placeholder_img_src();
				}
				?>
				<div class="single-awea-product-list">
					<div class="single-awea-product-list-box">
						<div class="single-awea-product-list-img" style="background-image: url('<?php echo esc_url( $product_image ); ?>');"></div>
						<div class="single-awea-product-list-content">
							<h4><a href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product_title ); ?></a></h4>
							<div class="single-awea-product-list-meta">
								<span><?php echo wp_kses_post( $product_price ); ?></span>
								<?php if ( WC()->cart && WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $product->get_id() ) ) ) : ?>
									<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="awea-product-grid-btn">
										<?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?>
									</a>
								<?php else : ?>
									<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
									   class="awea-product-grid-btn"
									   data-quantity="1"
									   data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
									   rel="nofollow">
										<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			echo '</div>';
			wp_reset_postdata();
		} else {
			echo '<p>' . esc_html__( 'No products found.', 'awesome-widgets-elementor' ) . '</p>';
		}
	}
}