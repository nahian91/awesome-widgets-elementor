<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_Carousel extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve team widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-product-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve about widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Products Carousel', 'awesome-widgets-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'awea-icon eicon-carousel-loop';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'products', 'carousel', 'awea'];
	}

	/**
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// start of the Content tab section
		$this->start_controls_section(
			'awea_products_carousel_content',
			[
				'label' => esc_html__('Products Carousel', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);
		 
		 // Products Number
		$this->add_responsive_control(
			'awea_products_carousel_number',
			[
				'label' 		=> __('Number of Products', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '4',
			]
		);

		// Products Category
		// $this->add_control(
		// 	'awea_products_carousel_category',
		// 	[
		// 		'label' => __('Product Category', 'awesome-widgets-elementor'),
		// 		'type' => Controls_Manager::SELECT2,
		// 		'options' => $this->get_product_categories(),
		// 		'multiple' => true,
		// 	]
		// );

		// Products Order
		$this->add_control(
			'awea_products_carousel_order',
			[
				'label' 		=> __('Order', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 			=> __('Default', 'awesome-widgets-elementor'),
					'DESC' 		=> __('DESCENDING', 'awesome-widgets-elementor'),
					'ASC' 		=> __('ASCENDING', 'awesome-widgets-elementor'),
				],
			]
		);

		// Products Orderby
		$this->add_control(
			'awea_products_carousel_orderby',
			[
				'label' 		=> __('Order By', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					''               => __('Default', 'awesome-widgets-elementor'),
					'date'           => __('Date', 'awesome-widgets-elementor'),
					'title'          => __('Title', 'awesome-widgets-elementor'),
					'name'           => __('Name', 'awesome-widgets-elementor'),
					'rand'           => __('Random', 'awesome-widgets-elementor'),
					'comment_count'  => __('Comment Count', 'awesome-widgets-elementor'),
					'menu_order'     => __('Menu Order', 'awesome-widgets-elementor'),
					'best_selling'   => __('Best Selling', 'awesome-widgets-elementor'),
					'on_sale'        => __('On Sale', 'awesome-widgets-elementor'),
					'latest_products' => __('Latest Products', 'awesome-widgets-elementor'),
				],
			]
		);
		 
		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_products_carousel_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		// Number
		$this->add_control(
			'awea_products_carousel_slide_number',
			[
                'label'     => esc_html__( 'No. of items per slide', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
				'default' => '3',
                'frontend_available' => true,
            ]
		);

		// Arrows
		$this->add_control(
			'awea_products_carousel_arrows',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Dots
		$this->add_control(
			'awea_products_carousel_dots',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Loops
		$this->add_control(
			'awea_products_carousel_loop',
			[
				'label' => esc_html__( 'Loops', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Autoplay
		$this->add_control(
			'awea_products_carousel_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Pause
		$this->add_control(
			'awea_products_carousel_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Autoplay Speed
		$this->add_control(
			'awea_products_carousel_autoplay_speed',
			[
				'label' => esc_html__( 'Speed', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '5000',
				'options' => [
					'1000' => esc_html__( '1 Seconds', 'awesome-widgets-elementor' ),
					'2000' => esc_html__( '2 Seconds', 'awesome-widgets-elementor' ),
					'3000' => esc_html__( '3 Seconds', 'awesome-widgets-elementor' ),
					'4000' => esc_html__( '4 Seconds', 'awesome-widgets-elementor' ),
					'5000' => esc_html__( '5 Seconds', 'awesome-widgets-elementor' ),
					'6000' => esc_html__( '6 Seconds', 'awesome-widgets-elementor' ),
					'7000' => esc_html__( '7 Seconds', 'awesome-widgets-elementor' ),
					'8000' => esc_html__( '8 Seconds', 'awesome-widgets-elementor' ),
					'9000' => esc_html__( '9 Seconds', 'awesome-widgets-elementor' ),
					'10000' => esc_html__( '10 Seconds', 'awesome-widgets-elementor' ),
				],
			]
		);

		// Animation Speed
		$this->add_control(
			'awea_products_carousel_autoplay_animation',
			[
				'label' => esc_html__( 'Timeout', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '5000',
				'options' => [
					'1000' => esc_html__( '1 Seconds', 'awesome-widgets-elementor' ),
					'2000' => esc_html__( '2 Seconds', 'awesome-widgets-elementor' ),
					'3000' => esc_html__( '3 Seconds', 'awesome-widgets-elementor' ),
					'4000' => esc_html__( '4 Seconds', 'awesome-widgets-elementor' ),
					'5000' => esc_html__( '5 Seconds', 'awesome-widgets-elementor' ),
					'6000' => esc_html__( '6 Seconds', 'awesome-widgets-elementor' ),
					'7000' => esc_html__( '7 Seconds', 'awesome-widgets-elementor' ),
					'8000' => esc_html__( '8 Seconds', 'awesome-widgets-elementor' ),
					'9000' => esc_html__( '9 Seconds', 'awesome-widgets-elementor' ),
					'10000' => esc_html__( '10 Seconds', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();
		// end of the Content tab section

		// start of the Content tab section
		$this->start_controls_section(
			'awea_products_carousel_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		 );

		 $this->add_control( 
			'awea_products_carousel_pro_message_notice', 
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

		// Products Layout
		$this->start_controls_section(
			'awea_products_layout_style',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Product Background
		$this->add_control(
			'awea_product_carousel_layout_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Product Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_carousel_layout_border',
				'selector' => '{{WRAPPER}} .awea-product-carousel',
			]
		);	

		// Products Padding
		$this->add_control(
			'awea_product_carousel_layout_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Products Border Radius
		$this->add_control(
			'awea_product_carousel_layout_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_layout_align',
			[
				'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} .awea-product-carousel' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Start of the Products Content Tab Section
		$this->start_controls_section(
			'awea_products_image',
			[
				'label' => esc_html__('Images', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE		   
			]
		);

		// Products Image Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_carousel_border',
				'selector' => '{{WRAPPER}} .awea-product-carousel-img',
			]
		);	

		// Products Image Border
		$this->add_control(
			'awea_product_carousel_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Products Image Width
		$this->add_control(
			'awea_products_image_width',
			[
				'label' => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Products Image Width
		$this->add_control(
			'awea_products_image_height',
			[
				'label' => esc_html__( 'Height', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-img' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		// Products Title
		$this->start_controls_section(
			'awea_products_title_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Products Title Color
		$this->add_control(
			'awea_product_carousel_title_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-title a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Products Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_carousel_title_typography',
				'selector' => '{{WRAPPER}} .awea-product-carousel-title a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_products_title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Products Meta
		$this->start_controls_section(
			'awea_products_meta_style',
			[
				'label' => esc_html__( 'Meta', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Products Meta Price
		$this->add_control(
			'awea_products_meta_price_style',
			[
				'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Products Meta Price Color
		$this->add_control(
			'awea_product_carousel_meta_price_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-price' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Products Meta Price Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_carousel_meta_typography',
				'selector' => '{{WRAPPER}} .awea-product-price',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_products_price_spacing',
			[
				'label' => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-product-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Products Meta Price
		$this->add_control(
			'awea_products_meta_sale_text_style',
			[
				'label' => esc_html__( 'Sale', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Products Sale Price Color
		$this->add_control(
			'awea_product_carousel_meta_sale_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sale-price span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		// Products Sale Price Typography
		$this->add_group_control(
				Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_carousel_meta_sale_typography',
				'selector' => '{{WRAPPER}} .awea-sale-price span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		// Products Meta Price
		$this->add_control(
			'awea_products_meta_sale_style',
			[
				'label' => esc_html__( 'Sale Badge', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Products Sale Price Color
		$this->add_control(
			'awea_product_carousel_meta_sale_badge_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-sale' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		// Products Sale Price Color
		$this->add_control(
			'awea_product_carousel_meta_sale_badge_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-sale' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Products Sale Price Typography
		$this->add_group_control(
				Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_carousel_meta_sale_badge_typography',
				'selector' => '{{WRAPPER}} .awea-product-carousel-sale',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_product_carousel_price_sale_badge_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-sale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Products Button
		$this->start_controls_section(
			'awea_products_button_style',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'awea_product_carousel_btn_style_tab'
		);

		// Products Button Normal Tab
		$this->start_controls_tab(
			'awea_product_carousel_btn_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
			]
		);

		// Products Button Color
		$this->add_control(
			'awea_product_carousel_btn_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-btn' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Products Button Background
		$this->add_control(
			'awea_product_carousel_btn_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-btn' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Products Sale Price Typography
		$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'awea_product_carousel_btn_typography',
					'selector' => '{{WRAPPER}} .awea-product-carousel-btn',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					]
				]
			);

		$this->add_control(
			'awea_product_carousel_price_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Products Button Hover Tab
		$this->start_controls_tab(
			'awea_product_carousel_btn_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
			]
		);

		// Products Button Color
		$this->add_control(
			'awea_product_carousel_btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-btn:hover' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Products Button Hover Background
		$this->add_control(
			'awea_product_carousel_btn_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-carousel-btn:hover' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_carousel_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_products_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_product_carousel_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_product_carousel_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_carousel_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_product_carousel_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_carousel_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_carousel_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_products_carousel_dots' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_product_carousel_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_product_carousel_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_carousel_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_product_carousel_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_carousel_dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-products-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	 
	// Helper function to get product categories
	private function get_product_categories() {
		// Retrieve product categories
		$categories = get_terms(array('taxonomy' => 'product_cat'));
		
		// Initialize options array
		$options = array();
		
		// Check if categories were retrieved successfully
		if (!empty($categories) && !is_wp_error($categories)) {
			// Loop through categories
			foreach ($categories as $category) {
				// Check if category is an object and has required properties
				if (is_object($category) && isset($category->term_id) && isset($category->name)) {
					// Assign category ID as key and category name as value in options array
					$options[$category->term_id] = $category->name;
				}
			}
		}
		
		// Return options array
		return $options;
	}
	
	protected function render() {
		// Get input from the widget settings
		$settings = $this->get_settings_for_display();
		$awea_products_carousel_number = $settings['awea_products_carousel_number'];
		$awea_products_carousel_order = $settings['awea_products_carousel_order'];
		$awea_products_carousel_orderby = $settings['awea_products_carousel_orderby'];
		$awea_products_carousel_slide_number = $settings['awea_products_carousel_slide_number'];
		$awea_products_carousel_loop = $settings['awea_products_carousel_loop'];
		$awea_products_carousel_autoplay = $settings['awea_products_carousel_autoplay'];
		$awea_products_carousel_arrows = $settings['awea_products_carousel_arrows'];
		$awea_products_carousel_dots = $settings['awea_products_carousel_dots'];
		$awea_products_carousel_pause = $settings['awea_products_carousel_pause'];
		$awea_products_carousel_autoplay_speed = $settings['awea_products_carousel_autoplay_speed'];
		$awea_products_carousel_autoplay_animation = $settings['awea_products_carousel_autoplay_animation'];
	
		?>
	
		<div class="awea-products-carousel owl-carousel"  awea-products-scroll="<?php echo esc_attr( $awea_products_carousel_slide_number ); ?>"
		awea-products-arrows="<?php echo esc_attr( $awea_products_carousel_arrows ); ?>"
		awea-products-dots="<?php echo esc_attr( $awea_products_carousel_dots ); ?>" awea-products-loop= "<?php echo esc_attr( $awea_products_carousel_loop ); ?>" awea-products-autoplay="<?php echo esc_attr( $awea_products_carousel_autoplay ); ?>" awea-products-pause="<?php echo esc_attr( $awea_products_carousel_pause ); ?>" awea-products-arrows="<?php echo esc_attr( $awea_products_carousel_arrows ); ?>" awea-products-animation="<?php echo esc_attr( $awea_products_carousel_autoplay_animation ); ?>" awea-products-speed="<?php echo esc_attr( $awea_products_carousel_autoplay_speed ); ?>">
		<?php
			// WP_Query arguments to retrieve products
			$args = array(
				'posts_per_page' => $awea_products_carousel_number,
				'post_type' => 'product',
				'order' => $awea_products_carousel_order,
				'orderby' => $awea_products_carousel_orderby,
			);
	
			// WP_Query
			$query = new \WP_Query($args);
	
			if(class_exists( 'woocommerce' )) {
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) : $query->the_post();
					$product = wc_get_product(get_the_ID());
					$sale = $product->is_on_sale();
					$thumbnail_url = get_the_post_thumbnail_url() ?: 'path-to-default-image.jpg';
		?>
					<div class="awea-product-carousel">
							<?php if ($sale) : ?>
								<span class="awea-product-carousel-sale"><?php echo esc_html__('Sale', 'awesome-widgets-elementor'); ?></span>
							<?php endif; ?>
							<div class="awea-product-carousel-img" style="background-image:url('<?php echo esc_url($thumbnail_url); ?>')"></div>
							<div class="awea-product-carousel-content">
								<h4 class="awea-product-carousel-title">
								<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
							</h4>
							<div class="awea-product-carousel-price-bottom">
								<p class="awea-product-price">
								<?php if ( $product->is_on_sale() ) : ?>
									<span class="awea-sale-price"><?php echo wp_kses_post( wc_price( $product->get_sale_price() ) ); ?></span>
									<span class="awea-regular-price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
								<?php else : ?>
									<span class="awea-normal-price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
								<?php endif; ?>
							</p>

							<?php if ( WC()->cart && WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $product->get_id() ) ) ) : ?>
									<!-- Product already in cart -->
									<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="awea-product-carousel-btn">
										<?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?>
									</a>
								<?php else : ?>
									<!-- Product not yet in cart -->
									<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
									class="awea-product-carousel-btn" 
									data-quantity="1" 
									data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" 
									rel="nofollow">
										<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</a>
								<?php endif; ?>
								</div>
							</div>
						</div>
			<?php 
					endwhile;
				}
			}
			wp_reset_postdata();
		?>
		</div>
		<?php
	}	
}