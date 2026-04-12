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

class Widget_Awesome_Team_Carousel extends Widget_Base {

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
		return 'awesome-team-carousel';
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
		return esc_html__( 'Team Carousel', 'awesome-widgets-elementor' );
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
		return 'awea-icon eicon-carousel';
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
		return [ 'awea', 'team', 'carousel' ];
	}

	/**
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'team_carousel_content',
			[
				'label' => esc_html__('Teams', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);
		 
		// Team Carousel List
		$repeater = new Repeater();
 
		$repeater->add_control(
			'awea_team_carousel_image',
			[
				'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'separator' => 'before',
			]
		);
 
		$repeater->add_control(
			'awea_team_carousel_name',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'awesome-widgets-elementor' ),
				'separator' => 'before',
				'label_block' => true
			]
		 );
 
		$repeater->add_control(
			'awea_team_carousel_designation',
			[
				'label' => esc_html__( 'Designtion', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Web Developer', 'awesome-widgets-elementor' ),
				'separator' => 'before',
				'label_block' => true
			]
		);

		$repeater->add_control(
            'awea_team_carousel_fb_url',
            [
                'label' => __( 'Facebook', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://devnahian.com',
                ],
                'show_external' => true,
                'autocomplete' => false,
                'label_block' => true,
            ]
        );

		$repeater->add_control(
            'awea_team_carousel_tw_url',
            [
                'label' => __( 'Twitter', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://devnahian.com',
                ],
                'show_external' => true,
                'autocomplete' => false,
                'label_block' => true,
            ]
        );

		$repeater->add_control(
            'awea_team_carousel_ln_url',
            [
                'label' => __( 'Linkedin', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://devnahian.com',
                ],
                'show_external' => true,
                'autocomplete' => false,
                'label_block' => true,
            ]
        );

		$repeater->add_control(
            'awea_team_carousel_insta_url',
            [
                'label' => __( 'Instagram', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://devnahian.com',
                ],
                'show_external' => true,
                'autocomplete' => false,
                'label_block' => true,
            ]
        );
 
		$this->add_control(
			'awea_team_carousels',
			[
				'label' => esc_html__( 'Teams List', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
				[
					'awea_team_carousel_image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'awea_team_carousel_name' => esc_html__( 'Novák Réka', 'awesome-widgets-elementor' ),
					'awea_team_carousel_designation' => esc_html__( 'Senior Developer', 'awesome-widgets-elementor'),
					'awea_team_carousel_fb_url' => 'https://www.facebook.com',
					'awea_team_carousel_tw_url' => 'https://twitter.com',
					'awea_team_carousel_ln_url' => 'https://www.linkedin.com',
					'awea_team_carousel_insta_url' => 'https://www.instagram.com',
				],
				[
					'awea_team_carousel_image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'awea_team_carousel_name' => esc_html__( 'Pintér Beatrix', 'awesome-widgets-elementor' ),
					'awea_team_carousel_designation' => esc_html__( 'Senior UX Designer', 'awesome-widgets-elementor'),
					'awea_team_carousel_fb_url' => 'https://www.facebook.com',
					'awea_team_carousel_tw_url' => 'https://twitter.com',
					'awea_team_carousel_ln_url' => 'https://www.linkedin.com',
					'awea_team_carousel_insta_url' => 'https://www.instagram.com/',
				],
				[
					'awea_team_carousel_image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'awea_team_carousel_name' => esc_html__( 'Szekeres Dalma', 'awesome-widgets-elementor' ),
					'awea_team_carousel_designation' => esc_html__( 'Admin Manager', 'awesome-widgets-elementor'),
					'awea_team_carousel_fb_url' => 'https://www.facebook.com',
					'awea_team_carousel_tw_url' => 'https://twitter.com',
					'awea_team_carousel_ln_url' => 'https://www.linkedin.com',
					'awea_team_carousel_insta_url' => 'https://www.instagram.com/',
				],
				[
					'awea_team_carousel_image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'awea_team_carousel_name' => esc_html__( 'John Doe', 'awesome-widgets-elementor' ),
					'awea_team_carousel_designation' => esc_html__( 'SEO Expert', 'awesome-widgets-elementor'),
					'awea_team_carousel_fb_url' => 'https://www.facebook.com',
					'awea_team_carousel_tw_url' => 'https://twitter.com',
					'awea_team_carousel_ln_url' => 'https://www.linkedin.com',
					'awea_team_carousel_insta_url' => 'https://www.instagram.com/',
				],
				],
				'title_field' => '{{{ awea_team_carousel_name }}}',
				'separator' => 'before',
			]
		);
		
		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_team_carousel_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT			
			]
		 );

		// Teams Carousel Number
		$this->add_control(
			'awea_team_carousel_number',
			[
				'label' 		=> __('Number of Teams', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '3',
			]
		);

		// Teams Carousel Arrows
		$this->add_control(
			'awea_team_carousel_arrows',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Teams Carousel Dots
		$this->add_control(
			'awea_team_carousel_dots',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Teams Carousel Loops
		$this->add_control(
			'awea_team_carousel_loop',
			[
				'label' => esc_html__( 'Loops', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Teams Carousel Pause
		$this->add_control(
			'awea_team_carousel_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Teams Carousel Autoplay
		$this->add_control(
			'awea_team_carousel_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Teams Carousel Autoplay Speed
		$this->add_control(
			'awea_team_carousel_autoplay_speed',
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
			'awea_team_carousel_autoplay_animation',
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
			'awea_team_carousel_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		 );

		 $this->add_control( 
			'awea_team_carousel_pro_message_notice', 
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
			'awea_single_team_carousel_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Team Background Color
		$this->add_control(
			'awea_single_team_carousel_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Team Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_single_team_carousel_border',
				'selector' => '{{WRAPPER}} .awea-single-team-carousel',
			]
		);	

		// Team Padding
		$this->add_control(
			'awea_single_team_carousel_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_single_team_carousel_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_width',
			[
				'label' => esc_html__('Image Width', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%', 'px', 'vw'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Image Box Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_image_box_border',
				'selector' => '{{WRAPPER}} .awea-single-team-carousel img',
			]
		);	
		
		// Image Box Border Radius
		$this->add_control(
			'awea_image_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_single_team_carousel_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_single_team_carousel_contents_name_options',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_single_team_carousel_contents_name_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-content h4' => 'color: {{VALUE}}',
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
				'name' => 'awea_single_team_carousel_contents_name_typography',
				'selector' => '{{WRAPPER}} .awea-single-team-carousel-content h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_single_team_carousel_contents_name_spacing',
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
					'{{WRAPPER}} .awea-single-team-carousel-content h4 span' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_single_team_carousel_contents_desg_options',
			[
				'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_single_team_carousel_contents_desg_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-content h4 span' => 'color: {{VALUE}}',
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
				'name' => 'awea_single_team_carousel_contents_desg_typography',
				'selector' => '{{WRAPPER}} .awea-single-team-carousel-content h4 span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_single_team_carousel_contents_desg_spacing',
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
					'{{WRAPPER}} .awea-single-team-carousel-content h4 span' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_single_team_carousel_social_style',
			[
				'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_single_team_carousel_social_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_social_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_social_size',
			[
				'label' => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-social a i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_single_team_carousel_social_margin',
			[
				'label' => esc_html__( 'Margin', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-social a i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'awea_single_team_carousel_social_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-social a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_social_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_social_color_hover',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-team-carousel-social a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_single_team_carousel_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_team_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_single_team_carousel_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_single_team_carousel_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_single_team_carousel_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_team_carousel_dots' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_single_team_carousel_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_single_team_carousel_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_single_team_carousel_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_single_team_carousel_dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
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
	protected function render() {
		// Get input from the widget settings.
		$settings = $this->get_settings_for_display();        
	
		// Sanitize and escape settings values before using them.
		$awea_team_carousels = isset($settings['awea_team_carousels']) ? $settings['awea_team_carousels'] : [];
		$awea_team_carousels_items = isset($settings['awea_team_carousel_number']) ? $settings['awea_team_carousel_number'] : 3; // Default to 3 items
		$awea_team_carousels_arrows = isset($settings['awea_team_carousel_arrows']) ? $settings['awea_team_carousel_arrows'] : 'yes';
		$awea_team_carousels_dots = isset($settings['awea_team_carousel_dots']) ? $settings['awea_team_carousel_dots'] : 'yes';
		$awea_team_carousels_loops = isset($settings['awea_team_carousel_loop']) ? $settings['awea_team_carousel_loop'] : 'no';
		$awea_team_carousels_pause = isset($settings['awea_team_carousel_pause']) ? $settings['awea_team_carousel_pause'] : 'no';
		$awea_team_carousels_autoplay = isset($settings['awea_team_carousel_autoplay']) ? $settings['awea_team_carousel_autoplay'] : 'no';
		$awea_team_carousels_autoplay_speed = isset($settings['awea_team_carousel_autoplay_speed']) ? $settings['awea_team_carousel_autoplay_speed'] : 5000;
		$awea_team_carousels_autoplay_animation = isset($settings['awea_team_carousel_autoplay_animation']) ? $settings['awea_team_carousel_autoplay_animation'] : '';
	
		// Render the team carousel if there are items.
		if (!empty($awea_team_carousels)) {
			?>
			<div class="awea-team-carousel owl-carousel" 
				awea-team-items="<?php echo esc_attr($awea_team_carousels_items); ?>" 
				awea-team-arrows="<?php echo esc_attr($awea_team_carousels_arrows); ?>" 
				awea-team-dots="<?php echo esc_attr($awea_team_carousels_dots); ?>" 
				awea-team-loops="<?php echo esc_attr($awea_team_carousels_loops); ?>" 
				awea-team-pause="<?php echo esc_attr($awea_team_carousels_pause); ?>" 
				awea-team-autoplay="<?php echo esc_attr($awea_team_carousels_autoplay); ?>" 
				awea-team-autoplay-speed="<?php echo esc_attr($awea_team_carousels_autoplay_speed); ?>" 
				awea-team-autoplay-animation="<?php echo esc_attr($awea_team_carousels_autoplay_animation); ?>">
				
				<?php
				foreach ($awea_team_carousels as $team) {
					$team_image = isset($team['awea_team_carousel_image']['url']) ? esc_url($team['awea_team_carousel_image']['url']) : '';
					$team_name = isset($team['awea_team_carousel_name']) ? esc_html($team['awea_team_carousel_name']) : '';
					$team_designation = isset($team['awea_team_carousel_designation']) ? esc_html($team['awea_team_carousel_designation']) : '';

					$team_fb_url = isset($team['awea_team_carousel_fb_url']['url']) ? esc_url($team['awea_team_carousel_fb_url']['url']) : '';

					$team_tw_url = isset($team['awea_team_carousel_tw_url']['url']) ? esc_url($team['awea_team_carousel_tw_url']['url']) : '';

					$team_ln_url = isset($team['awea_team_carousel_ln_url']['url']) ? esc_url($team['awea_team_carousel_ln_url']['url']) : '';

					$team_insta_url = isset($team['awea_team_carousel_insta_url']['url']) ? esc_url($team['awea_team_carousel_insta_url']['url']) : '';

					?>
					<div class="awea-single-team-carousel">
							<img src="<?php echo esc_url($team_image);?>" alt="<?php echo esc_attr($team_name);?>">
							<div class="awea-single-team-carousel-content">
								<h4><?php echo esc_html($team_name);?> <span><?php echo esc_html($team_designation);?></span></h4>
								<div class="awea-single-team-carousel-social">
								<?php
								$social_links = [
									[ 'url' => $team_fb_url,    'icon' => 'fab fa-facebook-f' ],
									[ 'url' => $team_tw_url,    'icon' => 'fab fa-twitter' ],
									[ 'url' => $team_ln_url,    'icon' => 'fab fa-linkedin-in' ],
									[ 'url' => $team_insta_url, 'icon' => 'fab fa-instagram' ],
								];

									foreach ( $social_links as $social ) {
										if ( ! empty( $social['url'] ) ) {
											echo '<a href="' . esc_url( $social['url'] ) . '" target="_blank" rel="noopener noreferrer">
													<i class="' . esc_attr( $social['icon'] ) . '"></i>
												</a>';
										}
									}
									?>
								</div>

							</div>
						</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}	
}