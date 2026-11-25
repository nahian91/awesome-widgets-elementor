<?php
/**
 * Awesome Testimonials Carousel Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Testimonials_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-testimonials-carousel';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'reviews', 'testimonials', 'carousel', 'slider', 'rating', 'social proof' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. REVIEWS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_section_items',
			[
				'label' => esc_html__( 'Reviews', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_tsc_item_tabs' );

		// --- TAB 1: REVIEW TEXT ---
		$repeater->start_controls_tab(
			'awea_tsc_tab_review',
			[ 'label' => esc_html__( 'Review Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tsc_rating',
			[
				'label'   => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'0' => esc_html__( 'Hide Stars', 'awesome-widgets-elementor' ),
					'1' => '1 ★',
					'2' => '2 ★★',
					'3' => '3 ★★★',
					'4' => '4 ★★★★',
					'5' => '5 ★★★★★',
				],
			]
		);

		$repeater->add_control(
			'awea_tsc_headline',
			[
				'label'       => esc_html__( 'Short Headline (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Transformed our workflow in 48 hours', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tsc_speech',
			[
				'label'       => esc_html__( 'Review Quote', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Write customer review...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: CUSTOMER INFO ---
		$repeater->start_controls_tab(
			'awea_tsc_tab_author',
			[ 'label' => esc_html__( 'Customer Info', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tsc_image',
			[
				'label'   => esc_html__( 'Customer Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_tsc_name',
			[
				'label'       => esc_html__( 'Customer Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tsc_desg',
			[
				'label'       => esc_html__( 'Job Title / Company', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tsc_verified',
			[
				'label'        => esc_html__( 'Show Verified Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: COLORS ---
		$repeater->start_controls_tab(
			'awea_tsc_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tsc_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Review', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_tsc_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-tsc-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tsc_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tsc_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_tsc_testimonials_list',
			[
				'label'       => esc_html__( 'Reviews List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_tsc_name }}} — {{{ awea_tsc_desg }}}',
				'default'     => [
					[
						'awea_tsc_name'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
						'awea_tsc_desg'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
						'awea_tsc_speech'   => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
						'awea_tsc_rating'   => '5',
						'awea_tsc_verified' => 'yes',
					],
					[
						'awea_tsc_name'          => esc_html__( 'Maria Sauks', 'awesome-widgets-elementor' ),
						'awea_tsc_desg'          => esc_html__( 'Senior Engineer at Vercel', 'awesome-widgets-elementor' ),
						'awea_tsc_speech'        => esc_html__( 'It impressed me on multiple levels. Painless, pleasant, and completely hassle-free from day one.', 'awesome-widgets-elementor' ),
						'awea_tsc_rating'        => '5',
						'awea_tsc_verified'      => 'yes',
						'awea_tsc_item_featured' => 'yes',
					],
					[
						'awea_tsc_name'     => esc_html__( 'Sarah Heinsed', 'awesome-widgets-elementor' ),
						'awea_tsc_desg'     => esc_html__( 'Product Strategist', 'awesome-widgets-elementor' ),
						'awea_tsc_speech'   => esc_html__( 'Incredible craftsmanship and attention to detail. Our conversion rates jumped 32% since rollout.', 'awesome-widgets-elementor' ),
						'awea_tsc_rating'   => '5',
						'awea_tsc_verified' => 'yes',
					],
					[
						'awea_tsc_name'     => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_tsc_desg'     => esc_html__( 'Founder at Studio Mono', 'awesome-widgets-elementor' ),
						'awea_tsc_speech'   => esc_html__( 'Every detail feels intentional—from typography scale to responsive spacing. Hands down the best suite we have adopted.', 'awesome-widgets-elementor' ),
						'awea_tsc_rating'   => '5',
						'awea_tsc_verified' => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_section_settings',
			[
				'label' => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_tsc_name_tag',
			[
				'label'   => esc_html__( 'Name Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'awea_tsc_show_quote_icon',
			[
				'label'        => esc_html__( 'Show Quote Icon', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_tsc_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tsc-motion-',
			]
		);

		$this->add_control(
			'awea_tsc_enable_beam',
			[
				'label'        => esc_html__( 'Animated Border Glow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_section_slider',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_tsc_slides_to_show',
			[
				'label'          => esc_html__( 'Slides to Show', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tsc_slide_gap',
			[
				'label'      => esc_html__( 'Space Between Slides', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_tsc_show_arrows',
			[
				'label'        => esc_html__( 'Show Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_tsc_show_dots',
			[
				'label'        => esc_html__( 'Show Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_tsc_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_tsc_autoplay',
			[
				'label'        => esc_html__( 'Autoplay Slides', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_tsc_pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_tsc_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tsc_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_tsc_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tsc_animation_speed',
			[
				'label'   => esc_html__( 'Slide Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 50,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tsc_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '32',
					'right'    => '30',
					'bottom'   => '32',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tsc_card_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_beam_color',
			[
				'label'     => esc_html__( 'Border Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_tsc_enable_beam' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-card' => '--awea-tsc-beam-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_tsc_card_state_tabs' );

		$this->start_controls_tab(
			'awea_tsc_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tsc_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-testimonial-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_tsc_card_border',
				'selector'       => '{{WRAPPER}} .awea-testimonial-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_tsc_card_shadow',
				'selector' => '{{WRAPPER}} .awea-testimonial-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_tsc_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tsc_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-testimonial-card:hover',
			]
		);

		$this->add_control(
			'awea_tsc_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-card:hover' => 'border-color: var(--awea-tsc-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_tsc_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-testimonial-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STARS & QUOTE ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_style_stars',
			[
				'label' => esc_html__( 'Stars & Quote Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tsc_star_size',
			[
				'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-stars i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_star_filled_color',
			[
				'label'     => esc_html__( 'Filled Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-stars .awea-star-filled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_star_empty_color',
			[
				'label'     => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-stars .awea-star-empty' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_quote_color',
			[
				'label'     => esc_html__( 'Quote Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_tsc_show_quote_icon' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-quote-brand' => 'color: var(--awea-tsc-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. REVIEW QUOTE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_style_speech',
			[
				'label' => esc_html__( 'Review Quote', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_tsc_headline_color',
			[
				'label'     => esc_html__( 'Headline Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-headline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tsc_headline_typo',
				'label'    => esc_html__( 'Headline Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-testimonial-headline',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_tsc_speech_color',
			[
				'label'     => esc_html__( 'Quote Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tsc_speech_typo',
				'label'    => esc_html__( 'Quote Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-testimonial-text',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. CUSTOMER DETAILS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_style_author',
			[
				'label' => esc_html__( 'Customer Details', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_tsc_line_color',
			[
				'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tsc_avatar_size',
			[
				'label'      => esc_html__( 'Photo Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tsc_avatar_radius',
			[
				'label'      => esc_html__( 'Photo Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_name_color',
			[
				'label'     => esc_html__( 'Customer Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tsc_name_typo',
				'selector' => '{{WRAPPER}} .awea-testimonial-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_tsc_name_shadow',
				'selector' => '{{WRAPPER}} .awea-testimonial-name',
			]
		);

		$this->add_control(
			'awea_tsc_desg_color',
			[
				'label'     => esc_html__( 'Job Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-desg' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tsc_desg_typo',
				'selector' => '{{WRAPPER}} .awea-testimonial-desg',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. ARROWS & DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tsc_style_arrows',
			[
				'label' => esc_html__( 'Arrows & Dots', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tsc_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'condition'  => [ 'awea_tsc_show_arrows' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_tsc_show_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_arrow_bg',
			[
				'label'     => esc_html__( 'Arrow Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_tsc_show_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_tsc_arrow_border',
				'selector'  => '{{WRAPPER}} .awea-carousel-arrow-border',
				'condition' => [ 'awea_tsc_show_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tsc_dots_color',
			[
				'label'     => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'condition' => [ 'awea_tsc_show_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tsc_dots_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_tsc_show_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonials .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['awea_tsc_testimonials_list'] ?? [];

		if ( empty( $items ) ) {
			return;
		}

		$items_desktop = ! empty( $settings['awea_tsc_slides_to_show'] ) ? (int) $settings['awea_tsc_slides_to_show'] : 3;
		$items_tablet  = ! empty( $settings['awea_tsc_slides_to_show_tablet'] ) ? (int) $settings['awea_tsc_slides_to_show_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_tsc_slides_to_show_mobile'] ) ? (int) $settings['awea_tsc_slides_to_show_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_tsc_slide_gap']['size'] ) ? (int) $settings['awea_tsc_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_tsc_slide_gap_tablet']['size'] ) ? (int) $settings['awea_tsc_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_tsc_slide_gap_mobile']['size'] ) ? (int) $settings['awea_tsc_slide_gap_mobile']['size'] : 16;

		$show_arrows = ( 'yes' === ( $settings['awea_tsc_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$show_dots   = ( 'yes' === ( $settings['awea_tsc_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop        = ( 'yes' === ( $settings['awea_tsc_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay    = ( 'yes' === ( $settings['awea_tsc_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause       = ( 'yes' === ( $settings['awea_tsc_pause_on_hover'] ?? 'yes' ) ) ? 'yes' : 'no';
		$auto_speed  = ! empty( $settings['awea_tsc_autoplay_speed'] ) ? (int) $settings['awea_tsc_autoplay_speed'] : 5000;
		$anim_speed  = ! empty( $settings['awea_tsc_animation_speed'] ) ? (int) $settings['awea_tsc_animation_speed'] : 450;

		$has_beam  = 'yes' === ( $settings['awea_tsc_enable_beam'] ?? 'no' );
		$has_quote = 'yes' === ( $settings['awea_tsc_show_quote_icon'] ?? 'no' );
		$name_tag  = Utils::validate_html_tag( $settings['awea_tsc_name_tag'] ?? 'h4' );
		?>
		<div class="awea-testimonials-carousel-wrapper">
			<div class="awea-testimonials owl-carousel"
				 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-arrows="<?php echo esc_attr( $show_arrows ); ?>"
				 data-dots="<?php echo esc_attr( $show_dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-speed="<?php echo esc_attr( $anim_speed ); ?>"
				 data-timeout="<?php echo esc_attr( $auto_speed ); ?>">

				<?php
				foreach ( $items as $index => $item ) :
					$id          = $item['_id'] ?? $index;
					$avatar_url  = ! empty( $item['awea_tsc_image']['url'] ) ? esc_url( $item['awea_tsc_image']['url'] ) : Utils::get_placeholder_image_src();
					$name        = ! empty( $item['awea_tsc_name'] ) ? esc_html( $item['awea_tsc_name'] ) : esc_html__( 'Anonymous', 'awesome-widgets-elementor' );
					$desg        = ! empty( $item['awea_tsc_desg'] ) ? esc_html( $item['awea_tsc_desg'] ) : '';
					$headline    = $item['awea_tsc_headline'] ?? '';
					$speech      = ! empty( $item['awea_tsc_speech'] ) ? wp_kses_post( $item['awea_tsc_speech'] ) : '';
					$rating      = isset( $item['awea_tsc_rating'] ) ? absint( $item['awea_tsc_rating'] ) : 5;
					$is_verified = 'yes' === ( $item['awea_tsc_verified'] ?? 'no' );
					$is_featured = 'yes' === ( $item['awea_tsc_item_featured'] ?? '' );

					$card_classes = [ 'awea-testimonial-card', 'elementor-repeater-item-' . esc_attr( $id ) ];
					if ( $has_beam ) {
						$card_classes[] = 'awea-has-beam';
					}
					if ( $is_featured ) {
						$card_classes[] = 'awea-tsc-featured';
					}
					?>
					<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

						<?php if ( $has_quote ) : ?>
							<svg class="awea-testimonial-quote-brand" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
								<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
							</svg>
						<?php endif; ?>

						<?php if ( $rating > 0 ) : ?>
							<div class="awea-testimonial-stars" aria-label="<?php
								/* translators: %s: star rating value (e.g. 5) */
								echo esc_attr( sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating ) );
							?>">
								<?php
								for ( $i = 1; $i <= 5; $i++ ) {
									$star_class = ( $i <= $rating ) ? 'fas fa-star awea-star-filled' : 'far fa-star awea-star-empty';
									echo '<i class="' . esc_attr( $star_class ) . '" aria-hidden="true"></i>';
								}
								?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $headline ) ) : ?>
							<p class="awea-testimonial-headline"><?php echo esc_html( $headline ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $speech ) ) : ?>
							<blockquote class="awea-testimonial-text">
								&ldquo;<?php echo wp_kses_post( $speech ); ?>&rdquo;
							</blockquote>
						<?php endif; ?>

						<footer class="awea-testimonial-footer">
							<?php if ( ! empty( $avatar_url ) ) : ?>
								<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="awea-testimonial-avatar" loading="lazy" />
							<?php endif; ?>

							<div class="awea-testimonial-meta">
								<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea-testimonial-name"><?php echo esc_html( $name ); ?></<?php Utils::print_validated_html_tag( $name_tag ); ?>>
								<?php if ( ! empty( $desg ) ) : ?>
									<cite class="awea-testimonial-desg"><?php echo esc_html( $desg ); ?></cite>
								<?php endif; ?>
							</div>

							<?php if ( $is_verified ) : ?>
								<span class="awea-testimonial-verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
										<polyline points="20 6 9 17 4 12"></polyline>
									</svg>
								</span>
							<?php endif; ?>
						</footer>

					</article>
				<?php endforeach; ?>
			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-testimonials-carousel.default', function ($scope) {
				var $carousel = $scope.find('.awea-testimonials');
				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

				var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10) || 24;
				var gapTablet    = parseInt($carousel.data('gap-tablet'), 10) || 20;
				var gapMobile    = parseInt($carousel.data('gap-mobile'), 10) || 16;
				var isRtl        = document.dir === 'rtl' || document.documentElement.dir === 'rtl';

				$carousel.owlCarousel({
					rtl: isRtl,
					nav: $carousel.data('arrows') === 'yes',
					dots: $carousel.data('dots') === 'yes',
					loop: $carousel.data('loop') === 'yes',
					autoplay: $carousel.data('autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.data('timeout'), 10) || 5000,
					smartSpeed: parseInt($carousel.data('speed'), 10) || 450,
					autoplayHoverPause: $carousel.data('pause') === 'yes',
					navText: [
						'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
						'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
					],
					responsive: {
						0: { items: itemsMobile, margin: gapMobile },
						768: { items: itemsTablet, margin: gapTablet },
						1025: { items: itemsDesktop, margin: gapDesktop }
					},
					onInitialized: equalizeHeights,
					onResized: equalizeHeights,
					onRefreshed: equalizeHeights
				});

				function equalizeHeights() {
					setTimeout(function() {
						var maxHeight = 0;
						var items = $carousel.find('.awea-testimonial-card');
						items.css('height', 'auto');
						items.each(function () {
							var h = $(this).outerHeight();
							if (h > maxHeight) maxHeight = h;
						});
						if (maxHeight > 0) items.css('height', maxHeight + 'px');
					}, 100);
				}
			});
		});
		</script>
		<?php
	}
}