<?php
/**
 * Awesome Team Widget.
 *
 * Elementor widget that inserts a team into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_Team extends Widget_Base {

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
		return 'awesome-team';
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
		return esc_html__( 'Team', 'awesome-widgets' );
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
	       'awea_team_image',
		    [
		        'label' => esc_html__('Image', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		   
		    ]
	    );

		$this->add_control(
			'awea_team_image_upload',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_team_contents',
			 [
				 'label' => esc_html__('Contents', 'awesome-widgets'),
				 'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			
			 ]
		);

		$this->add_control(
			'awea_team_name',
			[
				'label' => esc_html__( 'Name', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'awea_team_designation',
			[
				'label' => esc_html__( 'Designation', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Web Developer', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
				'label_block' => true
			]
		);
		
		$this->end_controls_section();

		// Start of the Content tab section
		$this->start_controls_section(
			'awea_team_socials',
			[
				'label' => esc_html__('Socials', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Repeater Initialization
		$repeater = new \Elementor\Repeater();

		// Social Media Title
		$repeater->add_control(
			'awea_team_socials_title',
			[
				'label' => esc_html__('Title', 'textdomain'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Facebook', 'textdomain'),
				'label_block' => true,
			]
		);

		// Social Media Icon
		$repeater->add_control(
			'awea_team_socials_icon',
			[
				'label' => esc_html__('Icon', 'textdomain'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-facebook',
					'library' => 'fa-brands',
				],
				'fa-brands' => [
					'facebook', 'twitter', 'instagram', 'linkedin', 'youtube',
					'pinterest', 'whatsapp', 'telegram', 'tiktok', 'snapchat',
					'reddit', 'tumblr', 'github', 'gitlab', 'slack', 'skype',
					'dribbble', 'behance', 'flickr', 'medium', 'twitch',
					'discord', 'vimeo', 'spotify', 'soundcloud', 'weibo',
					'vk', 'messenger', 'quora', 'foursquare', 'xing', 
					'goodreads', 'rss', 'yelp'
				],
				'show_label' => false,
			]
		);

		// Social Media Link
		$repeater->add_control(
			'awea_team_socials_link',
			[
				'label' => esc_html__('Link', 'textdomain'),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => ['url', 'is_external', 'nofollow'],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);

		// Add Repeater to Section
		$this->add_control(
			'awea_team_socials_list',
			[
				'label' => esc_html__('Social Media Links', 'textdomain'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_team_socials_title' => esc_html__('Facebook', 'textdomain'),
						'awea_team_socials_icon' => ['value' => 'fab fa-facebook', 'library' => 'fa-brands'],
						'awea_team_socials_link' => ['url' => 'https://facebook.com'],
					],
					[
						'awea_team_socials_title' => esc_html__('Twitter', 'textdomain'),
						'awea_team_socials_icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
						'awea_team_socials_link' => ['url' => 'https://twitter.com'],
					],
					[
						'awea_team_socials_title' => esc_html__('Instagram', 'textdomain'),
						'awea_team_socials_icon' => ['value' => 'fab fa-instagram', 'library' => 'fa-brands'],
						'awea_team_socials_link' => ['url' => 'https://instagram.com'],
					],
					[
						'awea_team_socials_title' => esc_html__('LinkedIn', 'textdomain'),
						'awea_team_socials_icon' => ['value' => 'fab fa-linkedin', 'library' => 'fa-brands'],
						'awea_team_socials_link' => ['url' => 'https://linkedin.com'],
					],
				],
				'title_field' => '{{{ awea_team_socials_title }}}',
			]
		);

		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_team_layout_style',
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
			'awea_team_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_width',
			[
				'label' => esc_html__('Image Width', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .awea-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Image Box Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_image_box_border',
				'selector' => '{{WRAPPER}} .single-image-box',
			]
		);	
		
		// Image Box Border Radius
		$this->add_control(
			'awea_image_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-image-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_team_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_team_contents_designation_options',
			[
				'label' => esc_html__( 'Designation', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// CTA Title Color
		$this->add_control(
			'awea_team_contents_designation_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
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
				'name' => 'awea_team_contents_designation_typography',
				'selector' => '{{WRAPPER}} .cta-box h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_team_contents_title_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// CTA Title Color
		$this->add_control(
			'awea_team_contents_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
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
				'name' => 'awea_team_contents_title_typography',
				'selector' => '{{WRAPPER}} .cta-box h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_team_social_style',
			[
				'label' => esc_html__( 'Socials', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_team_social_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_team_social_tabs_normal',
			[
				'label' => esc_html__('Normal', 'textdomain'),
			]
		);

		$this->add_control(
			'awea_team_social_color',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_team_social_tabs_hover',
			[
				'label' => esc_html__('Hover', 'textdomain'),
			]
		);

		$this->add_control(
			'awea_team_social_color_hover',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'color: {{VALUE}}',
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
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		// $awea_cta_sub_title = $settings['awea_cta_sub_title'];
		// $awea_cta_title = $settings['awea_cta_title'];
		// $awea_cta_desc = $settings['awea_cta_desc'];
		// $awea_cta_button1 = $settings['awea_cta_button1'];
		// $awea_cta_button2 = $settings['awea_cta_button2'];
       ?>
			<div class="single-team">
				<img src="https://demo.themefisher.com/enov-bootstrap/images/team/team-1.jpg" alt="">
				<div class="team-content">
					<h4>Project Manager <span>Justin Hammer</span></h4>					
					<div class="team-social">
						<a href="#"><i class="fa fa-facebook-f"></i></a>
						<a href="#"><i class="fa fa-facebook-f"></i></a>
						<a href="#"><i class="fa fa-facebook-f"></i></a>
						<a href="#"><i class="fa fa-facebook-f"></i></a>
					</div>
				</div>
			</div>
       <?php
	}
}
