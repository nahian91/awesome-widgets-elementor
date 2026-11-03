<?php
/**
 * Awesome Price Menu Widget.
 *
 * Elementor widget that inserts a cta into the page
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

class Widget_Awesome_Price_Menu extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-price-menu';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve affiliate products widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Price Menu', 'awesome-widgets-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve affiliate products widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-menu-card';
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

	public function get_keywords() {
		return [ 'price', 'menu', 'awesome'];
	}

	/**
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		// Price Menu Section
		$this->start_controls_section(
			'awea_price_menu_section',
			[
				'label' => esc_html__( 'Price Menu', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_price_menu_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_price_menu_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'default' => esc_html__( 'Product Name', 'awesome-widgets-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_price_menu_price',
			[
				'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'default' => '$0.00',
			]
		);

		$repeater->add_control(
			'awea_price_menu_description',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Product short description...', 'awesome-widgets-elementor' ),
				'rows' => 3,
			]
		);

		$this->add_control(
			'awea_price_menu_items',
			[
				'label' => esc_html__( 'Price Menu Items', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_price_menu_title' => esc_html__( 'Body Soap', 'awesome-widgets-elementor' ),
						'awea_price_menu_price' => '$25',
						'awea_price_menu_description' => esc_html__( 'The glowing formula works great for skin.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_menu_title' => esc_html__( 'Shampoo', 'awesome-widgets-elementor' ),
						'awea_price_menu_price' => '$15',
						'awea_price_menu_description' => esc_html__( 'Cleans and nourishes hair naturally.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_menu_title' => esc_html__( 'Face Cream', 'awesome-widgets-elementor' ),
						'awea_price_menu_price' => '$30',
						'awea_price_menu_description' => esc_html__( 'Hydrates and revitalizes the skin.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_menu_title' => esc_html__( 'Hair Oil', 'awesome-widgets-elementor' ),
						'awea_price_menu_price' => '$18',
						'awea_price_menu_description' => esc_html__( 'Strengthens hair and promotes growth.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_menu_title' => esc_html__( 'Body Lotion', 'awesome-widgets-elementor' ),
						'awea_price_menu_price' => '$22',
						'awea_price_menu_description' => esc_html__( 'Keeps skin soft and moisturized all day.', 'awesome-widgets-elementor' ),
					],
				],
				'title_field' => '{{{ awea_price_menu_title }}}',
			]
		);

		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_price_menu_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_price_menu_pro_message_notice', 
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

		// Style: Product Title
		$this->start_controls_section(
			'awea_style_price_menu_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_price_menu_layout_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_price_menu_layout_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_price_menu_layout_border',
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->add_control(
			'awea_price_menu_layout_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Product Title
		$this->start_controls_section(
			'awea_style_price_menu_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_style_price_menu_image_border',
				'selector' => '{{WRAPPER}} .awea-price-menu img',
			]
		);

		$this->add_control(
			'awea_style_price_menu_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Product Title
		$this->start_controls_section(
			'awea_style_product_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu h4' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-price-menu h4',
			]
		);

		$this->end_controls_section();

		// Style: Price
		$this->start_controls_section(
			'awea_style_price',
			[
				'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_price_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_price_typography',
				'selector' => '{{WRAPPER}} .awea-price',
			]
		);

		$this->end_controls_section();

		// Style: Description
		$this->start_controls_section(
			'awea_style_description',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_description_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_description_typography',
				'selector' => '{{WRAPPER}} .awea-description',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['awea_price_menu_items'] ) ) {
			echo '<ul class="awea-price-menu-list">';
			foreach ( $settings['awea_price_menu_items'] as $item ) {
				$img_url = ! empty( $item['awea_price_menu_image']['url'] ) ? esc_url( $item['awea_price_menu_image']['url'] ) : 'https://placehold.co/600x400/png';
				?>
				<li class="awea-price-menu">
					<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr( $item['awea_price_menu_title'] ); ?>">
					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<h4><?php echo esc_html( $item['awea_price_menu_title'] ); ?></h4>
							<span class="awea-price"><?php echo esc_html( $item['awea_price_menu_price'] ); ?></span>
						</div>
						<p class="awea-description">
							<?php echo esc_html( $item['awea_price_menu_description'] ); ?>
						</p>
					</div>
				</li>
				<?php
			}
			echo '</ul>';
		}
	}
}