<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Product_Category_Carousel extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve about widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	*/
	public function get_name() {
		return 'awesome-product-category-carousel';
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
		return esc_html__( 'Products Category Carousel', 'awesome-widgets-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve about widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'awea-icon eicon-nested-carousel';
	}	

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the about widget belongs to.
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
		return [ 'category', 'products', 'carousel', 'awea'];
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
			'awea_product_categories_carousel_contents',
			[
				'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);
		 
		// Product Categories
		$this->add_control(
			'awea_product_categories_carousel',
			[
				'label' => esc_html__('Select Category', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_all_product_categories(),
				'label_block' => true,
				'multiple' => true, // Set to true for multiple selections
			]
		);
 
		 // Show Product Category Count
		 $this->add_control(
			'awea_product_categories_carousel_count',
			[
				'label' => esc_html__( 'Show Products Count', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
 
		 // Show Product Category Button
		 $this->add_control(
			'awea_product_categories_carousel_btn_show',
			[
				'label' => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
 
		// Product Category Alignment
		$this->add_control(
			'awea_product_categories_carousel_alignment',
			[
				'type' => Controls_Manager::CHOOSE,
				'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
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
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .product-category-content' => 'text-align: {{VALUE}}',
				],
				'separator' => 'before'
			],
		);
		
		$this->end_controls_section();
		// end of the Products Category Carousel Content tab section

		// start of the Content tab section
		$this->start_controls_section(
			'awea_product_category_carousel_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,		
			]
		);

		// Product Category Carousel Number
		$this->add_control(
			'awea_product_category_carousel_number',
			[
				'label' 		=> __('Number of Product Category', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '3',
			]
		);

		// Product Category Carousel Arrows
		$this->add_control(
			'awea_product_category_carousel_arrows',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Product Category Carousel Dots
		$this->add_control(
			'awea_product_category_carousel_dots',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Product Category Carousel Loops
		$this->add_control(
			'awea_product_category_carousel_loop',
			[
				'label' => esc_html__( 'Loops', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Product Category Carousel Pause
		$this->add_control(
			'awea_product_category_carousel_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Product Category Carousel Autoplay
		$this->add_control(
			'awea_product_category_carousel_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Product Category Carousel Autoplay Speed
		$this->add_control(
			'awea_product_category_carousel_autoplay_speed',
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

		// Product Category Carousel Animation Speed
		$this->add_control(
			'awea_product_category_carousel_autoplay_animation',
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
			'awea_products_category_carousel_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_products_category_carousel_pro_message_notice', 
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
		
		// Style
		$this->start_controls_section(
			'awea_product_category_content_style',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_category_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-content a, .awea-product-category-content span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_product_category_bg_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-content' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_product_category_typography',
				'selector' => '{{WRAPPER}} .awea-product-category-content a, .awea-product-category-content span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_product_category_border',
				'selector' => '{{WRAPPER}} .awea-product-category',
			]
		);	

		$this->add_control(
			'awea_product_category_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_category_carousel_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_product_category_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_product_category_carousel_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_product_category_carousel_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_category_carousel_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_product_category_carousel_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_product_category_carousel_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_category_carousel_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_product_category_carousel_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_product_category_carousel_dots' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_product_category_carousel_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_product_category_carousel_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_category_carousel_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_product_category_carousel_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_product_category_carousel_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_product_category_carousel_dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-product-category-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}

	protected function get_all_product_categories() {
    $product_categories = get_terms('product_cat');
    $options = [];

    if ( $product_categories && ! is_wp_error($product_categories) ) {
        foreach ( $product_categories as $category ) {
            $options[$category->term_id] = $category->name;
        }
    }
    return $options;
}


	protected function render() {
    $settings = $this->get_settings_for_display();

    // Widget settings
    $awea_product_category_carousel_items = $settings['awea_product_category_carousel_number'];
    $awea_product_category_carousel_arrows = $settings['awea_product_category_carousel_arrows'];
    $awea_product_category_carousel_dots = $settings['awea_product_category_carousel_dots'];
    $awea_product_category_carousel_loops = $settings['awea_product_category_carousel_loop'];
    $awea_product_category_carousel_pause = $settings['awea_product_category_carousel_pause'];
    $awea_product_category_carousel_autoplay = $settings['awea_product_category_carousel_autoplay'];
    $awea_product_category_carousel_autoplay_speed = $settings['awea_product_category_carousel_autoplay_speed'];
    $awea_product_category_carousel_autoplay_animation = $settings['awea_product_category_carousel_autoplay_animation'];

    // Build query args
    $args = [
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ];

    // If user selected categories, filter by them
    if ( ! empty( $settings['awea_product_category_include'] ) ) {
        $args['include'] = $settings['awea_product_category_include'];
    }

    $product_categories = get_terms( $args );

    if ( empty( $product_categories ) || is_wp_error( $product_categories ) ) {
        echo '<p>' . esc_html__( 'No categories found.', 'awesome-widgets-elementor' ) . '</p>';
        return;
    }
    ?>
    <div class="awea-product-category-carousel owl-carousel" 
        awea-product-category-carousel-items="<?php echo esc_attr( $awea_product_category_carousel_items ); ?>" 
        awea-product-category-carousel-arrows="<?php echo esc_attr( $awea_product_category_carousel_arrows ); ?>" 
        awea-product-category-carousel-dots="<?php echo esc_attr( $awea_product_category_carousel_dots ); ?>" 
        awea-product-category-carousel-loops="<?php echo esc_attr( $awea_product_category_carousel_loops ); ?>" 
        awea-product-category-carousel-pause="<?php echo esc_attr( $awea_product_category_carousel_pause ); ?>" 
        awea-product-category-carousel-autoplay="<?php echo esc_attr( $awea_product_category_carousel_autoplay ); ?>" 
        awea-product-category-carousel-autoplay-speed="<?php echo esc_attr( $awea_product_category_carousel_autoplay_speed ); ?>" 
        awea-product-category-carousel-autoplay-animation="<?php echo esc_attr( $awea_product_category_carousel_autoplay_animation ); ?>">

        <?php foreach ( $product_categories as $category ) : 
            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
            $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : wc_placeholder_img_src();
        ?>
            <div class="awea-product-category">
                <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-img-link">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                </a>
                <div class="awea-product-category-content">
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="awea-product-category-link">
                        <?php echo esc_html( $category->name ); ?>
                    </a>
                    <span class="count">(<?php echo esc_html( $category->count ); ?>)</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
}