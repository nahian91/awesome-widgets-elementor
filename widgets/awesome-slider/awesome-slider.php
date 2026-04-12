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
use \Elementor\Utils;

class Widget_Awesome_Slider extends Widget_Base {

	public function get_name() {
		return 'awesome-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'slider', 'carousel' ];
	}

	protected function register_controls() {

		// Slider content section
		$this->start_controls_section(
			'awea_slider_content',
			[
				'label' => esc_html__('Sliders', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_slider_image',
			[
				'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_slider_subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
			'awea_slider_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Web Developer', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
			'awea_slider_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Your description here', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
			'awea_slider_btn1_text',
			[
				'label' => esc_html__( 'Button 1 Text', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
            'awea_slider_btn1_url',
            [
                'label' => __( 'Button 1 URL', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'show_external' => true,
                'label_block' => true,
            ]
        );

		$repeater->add_control(
			'awea_slider_btn2_text',
			[
				'label' => esc_html__( 'Button 2 Text', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact Us', 'awesome-widgets-elementor' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
            'awea_slider_btn2_url',
            [
                'label' => __( 'Button 2 URL', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'show_external' => true,
                'label_block' => true,
            ]
        );

		$this->add_control(
			'awea_slider',
			[
				'label' => esc_html__( 'Sliders List', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_slider_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
						'awea_slider_subtitle' => esc_html__( 'Creative Branding', 'awesome-widgets-elementor' ),
						'awea_slider_title' => esc_html__( 'We Build Memorable Brands', 'awesome-widgets-elementor' ),
						'awea_slider_desc' => esc_html__( 'Helping businesses stand out with strategic branding, design, and messaging that connects with their audience.', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_text' => esc_html__( 'Our Work', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_url' => [ 'url' => 'https://devnahian.com' ],
						'awea_slider_btn2_text' => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
						'awea_slider_btn2_url' => [ 'url' => 'https://devnahian.com' ]
					],
					[
						'awea_slider_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
						'awea_slider_subtitle' => esc_html__( 'Digital Marketing', 'awesome-widgets-elementor' ),
						'awea_slider_title' => esc_html__( 'Grow Your Business Online', 'awesome-widgets-elementor' ),
						'awea_slider_desc' => esc_html__( 'From SEO to social media campaigns, we drive targeted traffic that converts into loyal customers.', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_text' => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_url' => [ 'url' => 'https://example.com/services' ],
						'awea_slider_btn2_text' => esc_html__( 'Free Consultation', 'awesome-widgets-elementor' ),
						'awea_slider_btn2_url' => [ 'url' => 'https://devnahian.com' ]
					],
					[
						'awea_slider_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
						'awea_slider_subtitle' => esc_html__( 'Web Development', 'awesome-widgets-elementor' ),
						'awea_slider_title' => esc_html__( 'Custom Websites That Convert', 'awesome-widgets-elementor' ),
						'awea_slider_desc' => esc_html__( 'We create fast, responsive, and user-friendly websites tailored to your business needs.', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_text' => esc_html__( 'View Projects', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_url' => [ 'url' => 'https://devnahian.com' ],
						'awea_slider_btn2_text' => esc_html__( 'Hire Us', 'awesome-widgets-elementor' ),
						'awea_slider_btn2_url' => [ 'url' => 'https://devnahian.com' ]
					],
				],
				'title_field' => '{{{ awea_slider_title }}}'
			]
		);

		$this->end_controls_section();

		// Settings
		$this->start_controls_section(
			'awea_slider_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT			
			]
		);

		$this->add_control(
			'awea_slider_arrows',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_dots',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_loop',
			[
				'label' => esc_html__( 'Loops', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_autoplay_speed',
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

		// Teams Carousel Animation Speed
		$this->add_control(
			'awea_slider_autoplay_animation',
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

		// start of the Style tab section
		$this->start_controls_section(
			'awea_slider_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'overlay_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-slide-box:before',
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label' => esc_html__('Overlay Opacity', 'awesome-widgets-elementor'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-box:before' => 'opacity: {{SIZE}};',
				],
			]
		);

		// Team Padding
		$this->add_control(
			'awea_slider_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_slider_align',
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
					'{{WRAPPER}} .awea-slide-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_slider_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_slider_contents_subtitle_options',
			[
				'label' => esc_html__( 'Sub Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_slider_contents_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content span' => 'color: {{VALUE}}',
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
				'name' => 'awea_slider_contents_subtitle_typography',
				'selector' => '{{WRAPPER}} .awea-slide-content span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_slider_contents_title_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_slider_contents_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content h4' => 'color: {{VALUE}}',
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
				'name' => 'awea_slider_contents_title_typography',
				'selector' => '{{WRAPPER}} .awea-slide-content h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_slider_contents_desc_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_slider_contents_desc_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content-desc' => 'color: {{VALUE}}',
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
				'name' => 'awea_slider_contents_desc_typography',
				'selector' => '{{WRAPPER}} .awea-slide-content-desc',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_slider_buttons_style',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_slider_button1_options',
			[
				'label' => esc_html__( 'Button 1', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_slider_button1_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_slider_button1_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_slider_button1_typography',
				'selector' => '{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_slider_button1_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_slider_button1_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_slider_button1_border',
				'selector' => '{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg',
			]
		);

		$this->add_control(
			'awea_slider_button1_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_slider_button1_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_slider_button1_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_button1_color_hover',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'awea_slider_button1_bg_hover',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg:hover' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_slider_button1_hovere_border',
				'selector' => '{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg:hover',
			]
		);

		$this->add_control(
			'awea_slider_button1_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-bg:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'awea_slider_button2_options',
			[
				'label' => esc_html__( 'Button 2', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_slider_button2_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_slider_button2_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_slider_button2_typography',
				'selector' => '{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_slider_button2_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_slider_button2_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_slider_button2_border',
				'selector' => '{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border',
			]
		);

		$this->add_control(
			'awea_slider_button2_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_slider_button2_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_slider_button2_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_button2_color_hover',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_slider_button2_bg_hover',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border:hover' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'awea_slider_button2_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn .awea-slide-btn-border:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_slider_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_slider_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_slider_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_slider_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_slider_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_slider_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_slider_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_slider_dots' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_slider_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_slider_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_slider_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_slider_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_slider_dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-slider .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
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
    $slides = $settings['awea_slider'] ?? [];

    if ( empty( $slides ) ) {
        return;
    }

    // Defaults updated for slower slider
    $awea_sliders_items = $settings['awea_slider_number'] ?? 3;
    $awea_sliders_arrows = $settings['awea_slider_arrows'] ?? 'yes';
    $awea_sliders_dots = $settings['awea_slider_dots'] ?? 'yes';
    $awea_sliders_loops = $settings['awea_slider_loop'] ?? 'no';
    $awea_sliders_pause = $settings['awea_slider_pause'] ?? 'no';
    $awea_sliders_autoplay = $settings['awea_slider_autoplay'] ?? 'no';

    // Slower defaults
    $awea_slider_autoplay_speed = $settings['awea_slider_autoplay_speed'] ?? 8000; // 8s delay
    $awea_slider_autoplay_animation = $settings['awea_slider_autoplay_animation'] ?? 1200; // 1.2s transition

    ?>
    <div class="awea-slider owl-carousel" 
        awea-slider-items="<?php echo esc_attr( $awea_sliders_items ); ?>" 
        awea-slider-arrows="<?php echo esc_attr( $awea_sliders_arrows === 'yes' ? 'true' : 'false' ); ?>" 
        awea-slider-dots="<?php echo esc_attr( $awea_sliders_dots === 'yes' ? 'true' : 'false' ); ?>" 
        awea-slider-loops="<?php echo esc_attr( $awea_sliders_loops === 'yes' ? 'true' : 'false' ); ?>" 
        awea-slider-pause="<?php echo esc_attr( $awea_sliders_pause === 'yes' ? 'true' : 'false' ); ?>" 
        awea-slider-autoplay="<?php echo esc_attr( $awea_sliders_autoplay === 'yes' ? 'true' : 'false' ); ?>" 
        awea-slider-autoplay-speed="<?php echo esc_attr( $awea_slider_autoplay_speed ); ?>" 
        awea-slider-autoplay-animation="<?php echo esc_attr( $awea_slider_autoplay_animation ); ?>">
        
        <?php foreach ( $slides as $slide ) :
            $awea_slide_image_url = !empty( $slide['awea_slider_image']['url'] ) ? esc_url( $slide['awea_slider_image']['url'] ) : '';
            $awea_slide_subtitle  = esc_html( $slide['awea_slider_subtitle'] ?? '' );
            $awea_slide_title     = esc_html( $slide['awea_slider_title'] ?? '' );
            $awea_slide_desc      = isset( $slide['awea_slider_desc'] ) ? wp_kses_post( $slide['awea_slider_desc'] ) : '';
            $awea_btn1_text = esc_html( $slide['awea_slider_btn1_text'] ?? '' );
            $awea_btn1_url  = !empty( $slide['awea_slider_btn1_url']['url'] ) ? esc_url( $slide['awea_slider_btn1_url']['url'] ) : '';
            $awea_btn2_text = esc_html( $slide['awea_slider_btn2_text'] ?? '' );
            $awea_btn2_url  = !empty( $slide['awea_slider_btn2_url']['url'] ) ? esc_url( $slide['awea_slider_btn2_url']['url'] ) : '';
        ?>
            <div class="awea-slide-box" style="background-image: url('<?php echo esc_url( $awea_slide_image_url ); ?>');">
                <div class="awea-slide-content">
                    <?php if ( $awea_slide_subtitle ) : ?>
                        <span><?php echo esc_html($awea_slide_subtitle); ?></span>
                    <?php endif; ?>

                    <?php if ( $awea_slide_title ) : ?>
                        <h4><?php echo esc_html($awea_slide_title); ?></h4>
                    <?php endif; ?>
					
                    <?php if ( $awea_slide_desc ) : ?>
                        <div class="awea-slide-content-desc">
                            <?php echo wp_kses_post($awea_slide_desc); ?>
                        </div>
                    <?php endif; ?>

                    <div class="awea-slide-btn">
                        <?php if ( $awea_btn1_text && $awea_btn1_url ) : ?>
                            <a href="<?php echo esc_url($awea_btn1_url); ?>" 
                               class="awea-slide-btn-bg"
                               aria-label="<?php echo esc_attr($awea_btn1_text); ?>">
                               <?php echo esc_html($awea_btn1_text); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( $awea_btn2_text && $awea_btn2_url ) : ?>
                            <a href="<?php echo esc_url($awea_btn2_url); ?>" 
                               class="awea-slide-btn-border"
                               aria-label="<?php echo esc_attr($awea_btn2_text); ?>">
                               <?php echo esc_html($awea_btn2_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
}