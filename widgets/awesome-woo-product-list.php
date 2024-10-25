<?php
/**
 * Awesome CTA Widget.
 *
 * Elementor widget that inserts a cta into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_Product_list extends Widget_Base {

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
		return 'awesome-product-list';
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
		return esc_html__( 'Product List', 'awesome-widgets' );
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
		return 'eicon-call-to-action';
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
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		
		// start of the Content tab section
	   $this->start_controls_section(
	       'awea_cta_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		   
		    ]
	    );
		
		// CTA Sub Title
		$this->add_control(
			'awea_cta_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'awesome-widgets' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'are you ready?', 'awesome-widgets' ),
			]
		);

		// CTA Title
		$this->add_control(
			'awea_cta_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'We Are Awesome CTA!', 'awesome-widgets' ),
			]
		);

		// CTA Description
		$this->add_control(
			'awea_cta_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', 'awesome-widgets' ),
			]
		);

		// CTA Button 1
		$this->add_control(
			'awea_cta_button1',
			[
				'label' => esc_html__( 'Button 1', 'awesome-widgets' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '+880 123 4567 890', 'awesome-widgets' ),
			]
		);

		// CTA Button 2
		$this->add_control(
			'awea_cta_button2',
			[
				'label' => esc_html__( 'Button 2', 'awesome-widgets' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'info@anahian.com', 'awesome-widgets' ),
			]
		);
		
		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_cta_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// CTA Background Color
		$this->add_control(
			'awea_cta_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-price' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// CTA Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_cta_border',
				'selector' => '{{WRAPPER}} .single-price',
			]
		);	

		// CTA Border Radius
		$this->add_control(
			'awea_cta_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// CTA Padding
		$this->add_control(
			'awea_cta_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_cta_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cta_contents_subtitle_options',
			[
				'label' => esc_html__( 'Sub Title', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// CTA Sub Heading Color
		$this->add_control(
			'awea_cta_subtitle_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-box span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// CTA Sub Heading Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_cta_subtitle_typography',
				'selector' => '{{WRAPPER}} .cta-box span',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_cta_contents_title_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// CTA Title Color
		$this->add_control(
			'awea_cta_title_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-box h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// CTA Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_cta_title_typography',
				'selector' => '{{WRAPPER}} .cta-box h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

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
	protected function render() {
		// get our input from the widget settings.
		// $settings = $this->get_settings_for_display();
		// $awea_cta_sub_title = $settings['awea_cta_sub_title'];
		// $awea_cta_title = $settings['awea_cta_title'];
		// $awea_cta_desc = $settings['awea_cta_desc'];
		// $awea_cta_button1 = $settings['awea_cta_button1'];
		// $awea_cta_button2 = $settings['awea_cta_button2'];
       ?>
			<div class="feature-product-list-wrapper">
                        <div class="title-area">
                            <h2 class="title">
                                Top Selling
                            </h2>
                        </div>
                        <div class="single-product-list">
                            <a href="shop-details.html" class="thumbnail">
                                <img src="assets/images/grocery/06.jpg" alt="product">
                            </a>
                            <div class="body-content">
                                <div class="top">
                                    <div class="stars-area">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <a href="shop-details.html">
                                        <h4 class="title">Pastine Mellin Filid Angelo 100% Di Grano Tenero</h4>
                                    </a>
                                    <div class="price-area">
                                        <span class="current">$36.00</span>
                                        <div class="previous">$36.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-product-list">
                            <a href="shop-details.html" class="thumbnail">
                                <img src="assets/images/grocery/04.jpg" alt="product">
                            </a>
                            <div class="body-content">
                                <div class="top">
                                    <div class="stars-area">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <a href="shop-details.html">
                                        <h4 class="title">Lay's Potato Chips, Sweet Southern Heat ...</h4>
                                    </a>
                                    <div class="price-area">
                                        <span class="current">$36.00</span>
                                        <div class="previous">$36.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-product-list">
                            <a href="shop-details.html" class="thumbnail">
                                <img src="assets/images/grocery/01.jpg" alt="product">
                            </a>
                            <div class="body-content">
                                <div class="top">
                                    <div class="stars-area">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <a href="shop-details.html">
                                        <h4 class="title">Hillshire Farm Sliced Honey
                                            Deli Lunch Meat</h4>
                                    </a>
                                    <div class="price-area">
                                        <span class="current">$36.00</span>
                                        <div class="previous">$36.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-product-list">
                            <a href="shop-details.html" class="thumbnail">
                                <img src="assets/images/grocery/02.jpg" alt="product">
                            </a>
                            <div class="body-content">
                                <div class="top">
                                    <div class="stars-area">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <a href="shop-details.html">
                                        <h4 class="title">Pastine Mellin Filid Angelo 100% Di Grano Tenero</h4>
                                    </a>
                                    <div class="price-area">
                                        <span class="current">$36.00</span>
                                        <div class="previous">$36.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
       <?php
	}
}
