<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Testimonials_Carousel extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve cta widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-testimonials-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve cta widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'awesome-widgets-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve cta widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'awea-icon eicon-testimonial-carousel';
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
		return [ 'awea', 'reviews', 'testimonials', 'carousel' ];
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
	       'testimonial_content',
		    [
		        'label' => esc_html__('Content', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		   
		    ]
	    );
		
		// Testimonial
		$repeater = new Repeater();

		$repeater->add_control(
			'awea_testimonials_carousel_image',
			[
				'label' => esc_html__( 'Client Image', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		// Testimonial Client Name
		$repeater->add_control(
			'awea_testimonials_carousel_name',
			[
				'label' => esc_html__( 'Client Name', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Esther Howard', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		// Testimonial Client Designation
		$repeater->add_control(
			'awea_testimonials_carousel_desg',
			[
				'label' => esc_html__( 'Client Designation', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Businessman', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		// Testimonial Client Speech
		$repeater->add_control(
			'awea_testimonials_carousel_speech',
			[
				'label' => esc_html__( 'Client Speech', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Its impressed me on multiple levels. Thank you for making it painless, pleasant and most of all hassle free! Id be lost without It.', 'awesome-widgets-elementor' ),
			]
		);


		// Testimonial List
		$this->add_control(
			'awea_testimonials_carousel',
			[
				'label' => esc_html__( 'Testimonials', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ awea_testimonials_carousel_name }}}',
				'separator' => 'before',
				'default' => [
					[
						'awea_testimonials_carousel_image' => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							]
						],
						'awea_testimonials_carousel_name' => esc_html__( 'Esther Howard', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg' => esc_html__( 'Businessman', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Its impressed me on multiple levels. Thank you for making it painless, pleasant and most of all hassle free! Id be lost without It.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => esc_html__('5', 'awesome-widgets-elementor')
					],
					[
						'awea_testimonials_carousel_image' => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							]
						],
						'awea_testimonials_carousel_name' => esc_html__( 'Maria Sauks', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg' => esc_html__( 'Web Developer', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Its impressed me on multiple levels. Thank you for making it painless, pleasant and most of all hassle free! Id be lost without It.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => esc_html__('5', 'awesome-widgets-elementor')
					],
					[
						'awea_testimonials_carousel_image' => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							]
						],
						'awea_testimonials_carousel_name' => esc_html__( 'Sarah Heinsed', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg' => esc_html__( 'Blogger', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Its impressed me on multiple levels. Thank you for making it painless, pleasant and most of all hassle free! Id be lost without It.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => esc_html__('5', 'awesome-widgets-elementor')
					],
					[
						'awea_testimonials_carousel_image' => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							]
						],
						'awea_testimonials_carousel_name' => esc_html__( 'Mithc Hodge', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg' => esc_html__( 'Photographer', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Its impressed me on multiple levels. Thank you for making it painless, pleasant and most of all hassle free! Id be lost without It.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => esc_html__('5', 'awesome-widgets-elementor')
					]
				]
			]
		);
		
		$this->end_controls_section();

		 // start of the Content tab section
		 $this->start_controls_section(
			'awea_testimonials_carousel_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		 );

		$this->add_control(
			'awea_testimonials_carousel_items',
			[
				'label' => esc_html__( 'Slides Per View', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 6,
				'step' => 1,
			]
		);

		// Arrows
		$this->add_control(
			'awea_testimonials_carousel_arrows',
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
			'awea_testimonials_carousel_dots',
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
			'awea_testimonials_carousel_loops',
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
			'awea_testimonials_carousel_autoplay',
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
			'awea_testimonials_carousel_pause',
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
			'awea_testimonials_carousel_autoplay_speed',
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
			'awea_testimonials_carousel_autoplay_animation',
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
			'awea_testimonials_carousel_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_testimonials_carousel_pro_message_notice', 
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
			'awea_testimonials_carousel_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __('Alignment', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} .awea-testimonial-carousel' => 'text-align: {{VALUE}}',
				],
			]
		);	

		// Testimonials Background Color
		$this->add_control(
			'awea_testimonials_carousel_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Testimonials Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_testimonials_carousel_border',
				'selector' => '{{WRAPPER}} .awea-testimonial-carousel',
			]
		);	

		// Testimonials Border Radius
		$this->add_control(
			'awea_testimonials_carousel_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Testimonials Padding
		$this->add_control(
			'awea_testimonials_carousel_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_carousel_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_contents_icon_options',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// Testimonials Sub Heading Color
		$this->add_control(
			'awea_testimonials_carousel_contents_icon_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel-icon i' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_contents_speech_options',
			[
				'label' => esc_html__( 'Speech', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Testimonials Title Color
		$this->add_control(
			'awea_testimonials_carousel_speech_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel-content' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_carousel_speech_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-carousel-content',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_carousel_author_style',
			[
				'label' => esc_html__( 'Author', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_author_image_options',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);	

		// Testimonials Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_testimonials_carousel_author_image_border',
				'selector' => '{{WRAPPER}} .awea-testimonial-carousel-author img',
			]
		);	

		// Testimonials Border Radius
		$this->add_control(
			'awea_testimonials_carousel_border_author_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel-author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_author_name_options',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// Testimonials Sub Heading Color
		$this->add_control(
			'awea_testimonials_carousel_author_name_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel-author h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_carousel_author_name_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-carousel-author h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_author_designation_options',
			[
				'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Testimonials Title Color
		$this->add_control(
			'awea_testimonials_carousel_author_designation_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-carousel-author span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Testimonials Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_testimonials_carousel_author_designation_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-carousel-author span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_carousel_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_testimonials_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_testimonials_carousel_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_testimonials_carousel_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .awea-carousel-arrow-border i' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_testimonials_carousel_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_testimonials_carousel_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_testimonials_carousel_dots' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_testimonials_carousel_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_testimonials_carousel_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_testimonials_carousel_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrows_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
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

	$awea_testimonials_carousel = $settings['awea_testimonials_carousel'] ?? [];

	$awea_testimonials_carousel_items= !empty($settings['awea_testimonials_carousel_items']) ? (int) $settings['awea_testimonials_carousel_items'] : 3;
	$awea_testimonials_carousel_dots = !empty($settings['awea_testimonials_carousel_dots']) ? 'yes' : 'no';
	$awea_testimonials_carousel_arrows = !empty($settings['awea_testimonials_carousel_arrows']) ? 'yes' : 'no';
	$awea_testimonials_carousel_loops = !empty($settings['awea_testimonials_carousel_loops']) ? 'yes' : 'no';
	$awea_testimonials_carousel_autoplay = !empty($settings['awea_testimonials_carousel_autoplay']) ? 'yes' : 'no';
	$awea_testimonials_carousel_pause = !empty($settings['awea_testimonials_carousel_pause']) ? 'yes' : 'no';
	$awea_testimonials_carousel_autoplay_speed = !empty($settings['awea_testimonials_carousel_autoplay_speed']) ? (int) $settings['awea_testimonials_carousel_autoplay_speed'] : 5000;
	$awea_testimonials_carousel_autoplay_animation= !empty($settings['awea_testimonials_carousel_autoplay_animation']) ? (int) $settings['awea_testimonials_carousel_autoplay_animation'] : 300;

    ?>
    <!-- Testimonials Start Here -->
    <div class="awea-testimonials owl-carousel" 
		awea-testimonial-items="<?php echo esc_attr( $awea_testimonials_carousel_items ); ?>"
        awea-testimonial-arrows="<?php echo esc_attr( $awea_testimonials_carousel_arrows ); ?>" 
        awea-testimonial-dots="<?php echo esc_attr( $awea_testimonials_carousel_dots ); ?>" 
        awea-testimonial-loops="<?php echo esc_attr( $awea_testimonials_carousel_loops ); ?>" 
        awea-testimonial-autoplay="<?php echo esc_attr( $awea_testimonials_carousel_autoplay ); ?>" 
        awea-testimonial-pause="<?php echo esc_attr( $awea_testimonials_carousel_pause ); ?>" 
        awea-testimonial-animation="<?php echo esc_attr( $awea_testimonials_carousel_autoplay_animation ); ?>" 
        awea-testimonial-speed="<?php echo esc_attr( $awea_testimonials_carousel_autoplay_speed ); ?>">

        <?php if ( ! empty( $awea_testimonials_carousel ) ) : ?>
            <?php foreach ( $awea_testimonials_carousel as $testimonial ) :
                $testimonial_image_url = ! empty( $testimonial['awea_testimonials_carousel_image']['url'] ) ? esc_url( $testimonial['awea_testimonials_carousel_image']['url'] ) : \Elementor\Utils::get_placeholder_image_src();
                $testimonial_name = ! empty( $testimonial['awea_testimonials_carousel_name'] ) ? esc_html( $testimonial['awea_testimonials_carousel_name'] ) : esc_html__( 'John Doe', 'awesome-widgets-elementor' );
                $testimonial_desg = ! empty( $testimonial['awea_testimonials_carousel_desg'] ) ? esc_html( $testimonial['awea_testimonials_carousel_desg'] ) : esc_html__( 'Customer', 'awesome-widgets-elementor' );
                $testimonial_speech = ! empty( $testimonial['awea_testimonials_carousel_speech'] ) ? wp_kses_post( $testimonial['awea_testimonials_carousel_speech'] ) : esc_html__( 'No testimonial provided.', 'awesome-widgets-elementor' );
            ?>
                <div class="awea-testimonial-carousel">
                    <div class="awea-testimonial-carousel-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="awea-testimonial-carousel-content">
                        <?php echo wp_kses_post($testimonial_speech);; ?>
                    </div>
                    <div class="awea-testimonial-carousel-author">
                        <img src="<?php echo esc_url($testimonial_image_url); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>">
                        <h4>
                            <?php echo esc_html($testimonial_name); ?> 
                            <span><?php echo esc_html($testimonial_desg); ?></span>
						</h4>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- Testimonials End Here -->
    <?php
	}
}