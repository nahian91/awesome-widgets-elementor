<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Post_Carousel extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve post widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-post-carousel';
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
		return esc_html__( 'Post Carousel', 'awesome-widgets-elementor' );
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
		return 'awea-icon eicon-posts-carousel';
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
		return [ 'post', 'carousel', 'awea', 'post' ];
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
			'awea_post_carousel_contents',
			[
				'label' => esc_html__('Query', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,		
			]
		);

		// posts Number
		$this->add_control(
			'awea_post_carousel_number',
			[
				'label' 		=> __('Number of posts', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '4',
			]
		);
 
		// post Order
		$this->add_control(
			'awea_post_carousel_order',
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
 
		// post Orderby
		$this->add_control(
			'awea_post_carousel_orderby',
			[
				'label' 		=> __('Order By', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 				=> __('Default', 'awesome-widgets-elementor'),
					'date' 			=> __('Date', 'awesome-widgets-elementor'),
					'title' 		=> __('Title', 'awesome-widgets-elementor'),
					'name' 			=> __('Name', 'awesome-widgets-elementor'),
					'modified' 		=> __('Modified', 'awesome-widgets-elementor'),
					'author' 		=> __('Author', 'awesome-widgets-elementor'),
					'rand' 			=> __('Random', 'awesome-widgets-elementor'),
					'ID' 			=> __('ID', 'awesome-widgets-elementor'),
					'comment_count' => __('Comment Count', 'awesome-widgets-elementor'),
					'menu_order' 	=> __('Menu Order', 'awesome-widgets-elementor'),
				],
			]
		);
 
		$args = array(
			'hide_empty' => false,
		);
		
		$categories = get_categories($args);

		if($categories) {
			foreach ( $categories as $key => $category ) {
				$options[$category->term_id] = $category->name;
			}
		}
 
		// post Categories
		$this->add_control(
			'awea_post_carousel_include_categories',
			[
				'label' => __( 'Post Filter', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $options,
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_carousel_option_section',
			[
				'label' => esc_html__('Meta Info', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT			
			]
		);

		// post Category Show
		$this->add_control(
			'awea_post_carousel_cat_visibility',
			[
				'label' 		=> __('Show Category', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> 'yes',
				'label_on' 		=> __('Show', 'awesome-widgets-elementor'),
				'label_off' 	=> __('Hide', 'awesome-widgets-elementor'),
			]
		);

		// post Date Show
		$this->add_control(
			'awea_post_carousel_date_visibility',
			[
				'label' 		=> __('Show Date', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> 'yes',
				'label_on' 		=> __('Show', 'awesome-widgets-elementor'),
				'label_off' 	=> __('Hide', 'awesome-widgets-elementor'),
			]
		);

		// post Excerpt Show
		$this->add_control(
			'awea_post_carousel_excerpt_visibility',
			[
				'label' 		=> __('Show Excerpt', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> 'yes',
				'label_on' 		=> __('Show', 'awesome-widgets-elementor'),
				'label_off' 	=> __('Hide', 'awesome-widgets-elementor'),
			]
		);

		// Blog Button Show
		$this->add_control(
			'awea_post_carousel_btn_visibility',
			[
				'label' 		=> __('Show Button', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> 'yes',
				'label_on' 		=> __('Show', 'awesome-widgets-elementor'),
				'label_off' 	=> __('Hide', 'awesome-widgets-elementor'),
			]
		);

		$this->end_controls_section();
		// end of the Content tab section

		$this->start_controls_section(
			'awea_post_carousel_btn_option_section',
			 [
				'label' => esc_html__('Button', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'awea_post_carousel_btn_visibility' => 'yes'
				],		
			]
		);

		$this->add_control(
			'awea_post_carousel_btn_text',
			[
				'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Read More', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();
		// end of the Content tab section

		// start of the Content tab section
		$this->start_controls_section(
		'awea_post_carousel_settings',
			[
				'label' => esc_html__('Settings', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		// Number
		$this->add_control(
			'awea_post_carousel_slide_number',
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

		// posts Carousel Arrows
		$this->add_control(
			'awea_post_carousel_arrows',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// posts Carousel Arrows
		$this->add_control(
			'awea_post_carousel_dots',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// posts Carousel Loops
		$this->add_control(
			'awea_post_carousel_loop',
			[
				'label' => esc_html__( 'Loops', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// posts Carousel Pause
		$this->add_control(
			'awea_post_carousel_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// posts Carousel Autoplay
		$this->add_control(
			'awea_post_carousel_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// posts Carousel Autoplay Speed
		$this->add_control(
			'awea_post_carousel_autoplay_speed',
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

		// posts Carousel Animation Speed
		$this->add_control(
			'awea_post_carousel_autoplay_animation',
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
			'awea_post_carousel_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_post_carousel_pro_message_notice', 
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
			'awea_post_carousel_layout_style',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);	

		// post Background
		$this->add_control(
			'awea_post_carousel_bg_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-content' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// post Padding
		$this->add_control(
			'awea_post_carousel_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// post Border Radius
		$this->add_control(
			'awea_post_carousel_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_post_carousel_border',
				'selector' => '{{WRAPPER}} .awea-single-post-carousel',
			]
		);	

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_meta_style',
			[
				'label' => esc_html__( 'Meta', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);	

		// Meta Color
		$this->add_control(
			'awea_post_carousel_meta_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-meta a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Meta Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_carousel_meta_typography',
				'selector' => '{{WRAPPER}} .awea-post-carousel-meta a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_title_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);	

		// Title Color
		$this->add_control(
			'awea_post_carousel_title_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-title h3' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);
		
		// Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_carousel_title_typography',
				'selector' => '{{WRAPPER}} .awea-post-carousel-title h3',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		// Section Heading Separator Style
		$this->add_control(
			'awea_post_carousel_title_tag',
			[
				'label' => __( 'Html Tag', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'awesome-widgets-elementor' ),
					'h2' => __( 'H2', 'awesome-widgets-elementor' ),
					'h3' => __( 'H3', 'awesome-widgets-elementor' ),
					'h4' => __( 'H4', 'awesome-widgets-elementor' ),
					'h5' => __( 'H5', 'awesome-widgets-elementor' ),
					'h6' => __( 'H6', 'awesome-widgets-elementor' ),
					'p' => __( 'P', 'awesome-widgets-elementor' ),
					'span' => __( 'Span', 'awesome-widgets-elementor' ),
					'div' => __( 'Div', 'awesome-widgets-elementor' ),
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_excerpt_style',
			[
				'label' => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_post_carousel_excerpt_visibility' => 'yes', 
				],
			]
		);	

		// Excerpt Color
		$this->add_control(
			'awea_post_carousel_excerpt_color',
			[
				'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-excerpt' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Excerpt Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_carousel_excerpt_typography',
				'selector' => '{{WRAPPER}} .awea-post-carousel-excerpt',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);	

		// post Image Width
		$this->add_control(
			'awea_post_image_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// post Image Height
		$this->add_control(
			'awea_post_image_image_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'awesome-widgets-elementor' ),
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// post Image Display Size
		$this->add_control(
			'awea_post_image_display',
			[
				'label' 		=> __('Display Size', 'awesome-widgets-elementor'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'default' 		=> 'cover',
				'options' 		=> [
					'auto' 			=> __('Auto', 'awesome-widgets-elementor'),
					'contain' 		=> __('Contain', 'awesome-widgets-elementor'),
					'cover' 		=> __('Cover', 'awesome-widgets-elementor'),
				],
			]
		);

		// post Image Radius
		$this->add_control(
			'awea_post_carousel_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_button_style',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_post_carousel_btn_visibility' => 'yes'
				],	
			]
		);	

		$this->start_controls_tabs(
			'awea_post_carousel_button_style_tabs'
		);

		// Blog Button Normal Tab
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
			]
		);

		// Blog Button Color
		$this->add_control(
			'awea_post_carousel_btn_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-content .awea-btn-line' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		// Excerpt Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_carousel_btn_typography',
				'selector' => '{{WRAPPER}} .awea-post-carousel-content .awea-btn-line',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				]
			]
		);

		$this->end_controls_tab();

		// Blog Button Hover Tab
		$this->start_controls_tab(
			'awea_post_carousel_button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
			]
		);

		// Blog Button Hover Color
		$this->add_control(
			'awea_post_carousel_btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel-content .awea-btn-line:hover' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_post_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_post_carousel_arrows_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_post_carousel_arrows_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_post_carousel_arrows_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_arrows_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .awea-carousel-arrow-border' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_post_carousel_arrows_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_post_carousel_arrow_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_carousel_dots_style',
			[
				'label' => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'awea_post_carousel_arrows' => 'yes'
				]
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_post_carousel_dots_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_post_carousel_dots_tabs_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_post_carousel_dots_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_dots_active',
			[
				'label' => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_post_carousel_dots_tabs_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_post_carousel_dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .awea-carousel-arrow-border i' => 'color: {{VALUE}}',
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
    $settings = $this->get_settings_for_display();

    // Set variables with default fallback values
    $awea_post_carousel_number = !empty($settings['awea_post_carousel_number']) ? (int) $settings['awea_post_carousel_number'] : 5;
    $awea_post_carousel_order = !empty($settings['awea_post_carousel_order']) ? $settings['awea_post_carousel_order'] : 'DESC';
    $awea_post_carousel_orderby = !empty($settings['awea_post_carousel_orderby']) ? $settings['awea_post_carousel_orderby'] : 'date';
    $awea_post_carousel_include_categories = $settings['awea_post_carousel_include_categories'] ?? [];
    $awea_post_carousel_cat_visibility = isset($settings['awea_post_carousel_cat_visibility']) && $settings['awea_post_carousel_cat_visibility'] === 'yes';
    $awea_post_carousel_date_visibility = isset($settings['awea_post_carousel_date_visibility']) && $settings['awea_post_carousel_date_visibility'] === 'yes';
    $awea_post_carousel_excerpt_visibility = isset($settings['awea_post_carousel_excerpt_visibility']) && $settings['awea_post_carousel_excerpt_visibility'] === 'yes';
    $awea_post_carousel_slide_number = !empty($settings['awea_post_carousel_slide_number']) ? $settings['awea_post_carousel_slide_number'] : 3;
    $awea_post_carousel_arrows = $settings['awea_post_carousel_arrows'];
	$awea_post_carousel_dots = $settings['awea_post_carousel_dots'];
    $awea_post_carousel_loop = isset($settings['awea_post_carousel_loop']) && $settings['awea_post_carousel_loop'] === 'yes' ? 'yes' : 'no';
    $awea_post_carousel_pause = isset($settings['awea_post_carousel_pause']) && $settings['awea_post_carousel_pause'] === 'yes' ? 'yes' : 'no';
    $awea_post_carousel_autoplay = isset($settings['awea_post_carousel_autoplay']) && $settings['awea_post_carousel_autoplay'] === 'yes' ? 'yes' : 'no';
    $awea_post_carousel_autoplay_speed = !empty($settings['awea_post_carousel_autoplay_speed']) ? $settings['awea_post_carousel_autoplay_speed'] : 5000;
    $awea_post_carousel_autoplay_animation = !empty($settings['awea_post_carousel_autoplay_animation']) ? $settings['awea_post_carousel_autoplay_animation'] : 'linear';
    $awea_post_carousel_btn_text = !empty($settings['awea_post_carousel_btn_text']) ? $settings['awea_post_carousel_btn_text'] : esc_html__('Read More', 'awesome-widgets-elementor');
    $awea_post_carousel_btn_visibility = isset($settings['awea_post_carousel_btn_visibility']) && $settings['awea_post_carousel_btn_visibility'] === 'yes';
    $awea_post_carousel_title_tag = !empty($settings['awea_post_carousel_title_tag']) ? $settings['awea_post_carousel_title_tag'] : 'h3';

    // Prepare categories argument for WP_Query
    if (!empty($awea_post_carousel_include_categories) && is_array($awea_post_carousel_include_categories)) {
        // WP_Query 'cat' expects comma-separated list of IDs (string), so convert array to string
        $cat_arg = implode(',', array_map('intval', $awea_post_carousel_include_categories));
    } else {
        $cat_arg = '';
    }

    // WP_Query Arguments
    $args = [
        'posts_per_page' => $awea_post_carousel_number,
        'post_type' => 'post',
        'post_status' => 'publish',
        'order' => $awea_post_carousel_order,
        'orderby' => $awea_post_carousel_orderby,
        'ignore_sticky_posts' => 1,
    ];

    if ($cat_arg !== '') {
        $args['cat'] = $cat_arg;
    }

    $query = new \WP_Query($args);
    ?>
    <div class="awea-post-carousel owl-carousel"
        awea-post-items="<?php echo esc_attr($awea_post_carousel_slide_number); ?>"
        awea-post-arrows="<?php echo esc_attr($awea_post_carousel_arrows); ?>"
		awea-post-dots="<?php echo esc_attr($awea_post_carousel_dots); ?>"
        awea-post-loops="<?php echo esc_attr($awea_post_carousel_loop); ?>"
        awea-post-pause="<?php echo esc_attr($awea_post_carousel_pause); ?>"
        awea-post-autoplay="<?php echo esc_attr($awea_post_carousel_autoplay); ?>"
        awea-post-autoplay-speed="<?php echo esc_attr($awea_post_carousel_autoplay_speed); ?>"
        awea-post-autoplay-animation="<?php echo esc_attr($awea_post_carousel_autoplay_animation); ?>"
    >
        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="awea-single-post-carousel">
                    <?php
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
                    ?>
                    <div class="awea-post-carousel-img" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>
                    <div class="awea-post-carousel-content">
                        <div class="awea-post-carousel-meta">
                            <?php if ($awea_post_carousel_cat_visibility) : ?>
                                <?php the_category(', '); ?>
                            <?php endif; ?>
                            <?php if ($awea_post_carousel_date_visibility) : ?>
                                <a class="awea-post-carousel-date" href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html(get_the_date('j M, Y')); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="awea-post-carousel-title">
                            <<?php echo esc_attr($awea_post_carousel_title_tag); ?> class="awea-post-carousel-title">
                                <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
                            </<?php echo esc_attr($awea_post_carousel_title_tag); ?>>
                        </div>
                        <?php if ($awea_post_carousel_excerpt_visibility) : ?>
                            <div class="awea-post-carousel-excerpt">
                                <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($awea_post_carousel_btn_visibility) : ?>
                            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="awea-btn-line" aria-label="<?php the_title_attribute(); ?>">
                                <?php echo esc_html($awea_post_carousel_btn_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php esc_html_e('No posts found.', 'awesome-widgets-elementor'); ?></p>
        <?php endif; ?>
    </div>
    <?php
	}
}