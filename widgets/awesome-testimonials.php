<?php
/**
 * Awesome Testimonials Widget.
 *
 * Elementor widget that inserts a testimonials into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_Testimonials extends Widget_Base {

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
		return 'awesome-testimonials';
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
		return esc_html__( 'Testimonials', 'awesome-widgets-elementor' );
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
		return 'eicon-testimonial';
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
	       'awea_testimonials_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		   
		    ]
	    );
		
		// Testimonials Icon
		$this->add_control(
			'awea_testimonials_icon',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-quote-left',
					'library' => 'fa-solid',
				],
			]
		);

		// Testimonials Speech
		$this->add_control(
			'awea_testimonials_speech',
			[
				'label' => esc_html__( 'Speech', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima excepturi, animi eaque sed quidem libero doloribus repellat nostrum architecto atque officia molestias perferendis quaerat asperiores, quam reprehenderit temporibus corrupti eum quis! Pariatur modi quis ad voluptatem dolores odit voluptas ullam blanditiis non.', 'awesome-widgets-elementor' ),
			]
		);

		// Testimonials Author Image
		$this->add_control(
			'awea_testimonials_author_image',
			[
				'label' => __('Author Image', 'awesome-widgets-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// Testimonials Author Name
		$this->add_control(
			'awea_testimonials_author_name',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		// Testimonials Author Designation
		$this->add_control(
			'awea_testimonials_author_desg',
			[
				'label' => esc_html__( 'Designatiion', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Web Developer', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);
		
		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __('Alignment', 'awesome-widgets-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'awesome-widgets-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'awesome-widgets-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'awesome-widgets-elementor'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justify', 'awesome-widgets-elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial' => 'text-align: {{VALUE}}',
				],
			]
		);	

		// Testimonials Background Color
		$this->add_control(
			'awea_testimonials_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Testimonials Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_testimonials_border',
				'selector' => '{{WRAPPER}} .single-testimonial',
			]
		);	

		// Testimonials Border Radius
		$this->add_control(
			'awea_testimonials_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Testimonials Padding
		$this->add_control(
			'awea_testimonials_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_contents_icon_options',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// Testimonials Sub Heading Color
		$this->add_control(
			'awea_testimonials_contents_icon_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-icon i' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_testimonials_contents_speech_options',
			[
				'label' => esc_html__( 'Speech', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Testimonials Title Color
		$this->add_control(
			'awea_testimonials_speech_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-content p' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_speech_typography',
				'selector' => '{{WRAPPER}} .single-testimonial-content p',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_author_style',
			[
				'label' => esc_html__( 'Author', 'awesome-widgets-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_author_image_options',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_testimonials_author_image_width',
			[
				'label' => __('Width', 'awesome-widgets-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'vw'],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-author img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);		

		// Testimonials Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_testimonials_author_image_border',
				'selector' => '{{WRAPPER}} .single-testimonial-author img',
			]
		);	

		// Testimonials Border Radius
		$this->add_control(
			'awea_testimonials_border_author_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_author_name_options',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// Testimonials Sub Heading Color
		$this->add_control(
			'awea_testimonials_author_name_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-author h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_author_name_typography',
				'selector' => '{{WRAPPER}} .single-testimonial-author h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_testimonials_author_designation_options',
			[
				'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Testimonials Title Color
		$this->add_control(
			'awea_testimonials_author_designation_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-testimonial-author span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_author_designation_typography',
				'selector' => '{{WRAPPER}} .single-testimonial-author span',
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
		$settings = $this->get_settings_for_display();
		$awea_testimonials_icon = $settings['awea_testimonials_icon']['value'];
		$awea_testimonials_speech = $settings['awea_testimonials_speech'];
		$awea_testimonials_author_image = $settings['awea_testimonials_author_image']['url'];
		$awea_testimonials_author_name = $settings['awea_testimonials_author_name'];
		$awea_testimonials_author_desg = $settings['awea_testimonials_author_desg'];
       ?>
	   		<div class="single-testimonial">
				<div class="single-testimonial-icon">
					<i class="<?php echo esc_attr($awea_testimonials_icon);?>"></i>
				</div>
			   	<div class="single-testimonial-content">
				   <?php echo esc_html($awea_testimonials_speech);?>
				</div>
				<div class="single-testimonial-author">
					<img src="<?php echo esc_url($awea_testimonials_author_image);?>" alt="">
					<h4><?php echo esc_html($awea_testimonials_author_name);?> <span><?php echo esc_html($awea_testimonials_author_desg);?></span></h4>
				</div>
			</div>
       <?php
	}
}
