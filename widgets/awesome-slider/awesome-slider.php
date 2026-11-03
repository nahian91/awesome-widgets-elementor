<?php
/**
 * Awesome Slider Studio Widget.
 * Architectural Full-Screen Hero Slider with Repeater Slides & Global Kits.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Repeater;

class Widget_Awesome_Slider extends Widget_Base {

	public function get_name() {
		return 'awesome-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'slider', 'carousel', 'hero', 'banner', 'slideshow' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: SLIDES REPEATER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_slider_content',
			[
				'label' => esc_html__( 'Hero Slides', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_slider_image',
			[
				'label'   => esc_html__( 'Slide Background Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_slider_subtitle',
			[
				'label'       => esc_html__( 'Subtitle Kicker', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Creative Branding & Strategy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_slider_title',
			[
				'label'       => esc_html__( 'Main Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'We Build Memorable Brands', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_slider_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Helping businesses stand out with strategic branding, design, and messaging that connects with their audience.', 'awesome-widgets-elementor' ),
			]
		);

		// Button 1
		$repeater->add_control(
			'awea_heading_btn1',
			[
				'label'     => esc_html__( 'Primary Action Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'awea_slider_btn1_text',
			[
				'label'       => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Our Work', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_slider_btn1_url',
			[
				'label'       => esc_html__( 'Button URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'label_block' => true,
			]
		);

		// Button 2
		$repeater->add_control(
			'awea_heading_btn2',
			[
				'label'     => esc_html__( 'Secondary Action Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'awea_slider_btn2_text',
			[
				'label'       => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Contact Us', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_slider_btn2_url',
			[
				'label'       => esc_html__( 'Button URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_slider',
			[
				'label'       => esc_html__( 'Slides List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'awea_slider_subtitle'  => esc_html__( 'Creative Branding', 'awesome-widgets-elementor' ),
						'awea_slider_title'     => esc_html__( 'We Build Memorable Brands', 'awesome-widgets-elementor' ),
						'awea_slider_desc'      => esc_html__( 'Helping businesses stand out with strategic branding, design, and messaging.', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_text' => esc_html__( 'Our Work', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_url'  => [ 'url' => '#' ],
						'awea_slider_btn2_text' => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
						'awea_slider_btn2_url'  => [ 'url' => '#' ],
					],
					[
						'awea_slider_subtitle'  => esc_html__( 'Digital Marketing', 'awesome-widgets-elementor' ),
						'awea_slider_title'     => esc_html__( 'Grow Your Business Online', 'awesome-widgets-elementor' ),
						'awea_slider_desc'      => esc_html__( 'From SEO to social media campaigns, we drive targeted traffic that converts.', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_text' => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
						'awea_slider_btn1_url'  => [ 'url' => '#' ],
						'awea_slider_btn2_text' => esc_html__( 'Consultation', 'awesome-widgets-elementor' ),
						'awea_slider_btn2_url'  => [ 'url' => '#' ],
					],
				],
				'title_field' => '{{{ awea_slider_title }}}',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_slider_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_slider_arrows',
			[
				'label'        => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_dots',
			[
				'label'        => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_slider_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8000,
				'condition' => [ 'awea_slider_autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: LAYOUT & OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Layout & Overlay', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_overlay_background',
				'label'    => esc_html__( 'Overlay Gradient', 'awesome-widgets-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-slide-box::before',
			]
		);

		$this->add_control(
			'awea_overlay_opacity',
			[
				'label'   => esc_html__( 'Overlay Opacity', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
				'default' => [ 'size' => 0.55 ],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-box::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_slider_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [ 'top' => '150', 'right' => '80', 'bottom' => '150', 'left' => '80', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_slider_align',
			[
				'label'     => esc_html__( 'Content Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subtitle
		$this->add_control(
			'awea_heading_subtitle',
			[
				'label' => esc_html__( 'Subtitle Kicker', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-slide-subtitle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Title
		$this->add_control(
			'awea_heading_title',
			[
				'label'     => esc_html__( 'Main Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-slide-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Description
		$this->add_control(
			'awea_heading_desc',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.85)',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-slide-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_buttons',
			[
				'label' => esc_html__( 'Action Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Button 1 Style
		$this->add_control(
			'awea_heading_btn1_style',
			[
				'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn1_typo',
				'selector' => '{{WRAPPER}} .awea-slide-btn-bg',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn1_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_btn1_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn1_border',
				'selector' => '{{WRAPPER}} .awea-slide-btn-bg',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_btn1_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-bg:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Button 2 Style
		$this->add_control(
			'awea_heading_btn2_style',
			[
				'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn2_typo',
				'selector' => '{{WRAPPER}} .awea-slide-btn-border',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn2_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_btn2_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn2_border',
				'selector' => '{{WRAPPER}} .awea-slide-btn-border',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_btn2_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-slide-btn-border:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '14', 'right' => '32', 'bottom' => '14', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-slide-btn-bg, {{WRAPPER}} .awea-slide-btn-border' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-slide-btn-bg, {{WRAPPER}} .awea-slide-btn-border' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$slides    = $settings['awea_slider'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );

		if ( empty( $slides ) ) {
			return;
		}

		$arrows    = 'yes' === ( $settings['awea_slider_arrows'] ?? 'no' );
		$dots      = 'yes' === ( $settings['awea_slider_dots'] ?? 'no' );
		$loop      = 'yes' === ( $settings['awea_slider_loop'] ?? 'no' );
		$pause     = 'yes' === ( $settings['awea_slider_pause'] ?? 'no' );
		$autoplay  = 'yes' === ( $settings['awea_slider_autoplay'] ?? 'no' );
		$speed     = ! empty( $settings['awea_slider_autoplay_speed'] ) ? absint( $settings['awea_slider_autoplay_speed'] ) : 8000;
		$widget_id = $this->get_id();
		?>
		<div class="awea-slider-wrap">
			<div class="awea-slider owl-carousel"
			     id="awea-hero-slider-<?php echo esc_attr( $widget_id ); ?>"
			     data-arrows="<?php echo esc_attr( $arrows ? 'true' : 'false' ); ?>"
			     data-dots="<?php echo esc_attr( $dots ? 'true' : 'false' ); ?>"
			     data-loop="<?php echo esc_attr( $loop ? 'true' : 'false' ); ?>"
			     data-pause="<?php echo esc_attr( $pause ? 'true' : 'false' ); ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>"
			     data-speed="<?php echo esc_attr( (string) $speed ); ?>">

				<?php foreach ( $slides as $index => $slide ) : 
					$img_url = ! empty( $slide['awea_slider_image']['url'] ) ? esc_url( $slide['awea_slider_image']['url'] ) : '';
					$subtitle = $slide['awea_slider_subtitle'] ?? '';
					$title    = $slide['awea_slider_title'] ?? '';
					$desc     = $slide['awea_slider_desc'] ?? '';

					$btn1_text = $slide['awea_slider_btn1_text'] ?? '';
					$btn2_text = $slide['awea_slider_btn2_text'] ?? '';

					$btn1_key = 'awea_btn1_' . $index;
					$btn2_key = 'awea_btn2_' . $index;

					if ( ! empty( $slide['awea_slider_btn1_url']['url'] ) ) {
						$this->add_link_attributes( $btn1_key, $slide['awea_slider_btn1_url'] );
					}
					if ( ! empty( $slide['awea_slider_btn2_url']['url'] ) ) {
						$this->add_link_attributes( $btn2_key, $slide['awea_slider_btn2_url'] );
					}

					$this->add_render_attribute( $btn1_key, 'class', 'awea-slide-btn-bg' );
					$this->add_render_attribute( $btn2_key, 'class', 'awea-slide-btn-border' );
				?>
					<div class="awea-slide-box" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
						<div class="awea-slide-content">
							
							<?php if ( ! empty( $subtitle ) ) : ?>
								<span class="awea-slide-subtitle"><?php echo esc_html( $subtitle ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $title ) ) : ?>
								<<?php echo esc_attr( $title_tag ); ?> class="awea-slide-title">
									<?php echo wp_kses_post( $title ); ?>
								</<?php echo esc_attr( $title_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $desc ) ) : ?>
								<div class="awea-slide-desc">
									<?php echo wp_kses_post( $desc ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ( ! empty( $btn1_text ) && ! empty( $slide['awea_slider_btn1_url']['url'] ) ) || ( ! empty( $btn2_text ) && ! empty( $slide['awea_slider_btn2_url']['url'] ) ) ) : ?>
								<div class="awea-slide-btn-row">
									<?php if ( ! empty( $btn1_text ) && ! empty( $slide['awea_slider_btn1_url']['url'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $btn1_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
											<span><?php echo esc_html( $btn1_text ); ?></span>
										</a>
									<?php endif; ?>

									<?php if ( ! empty( $btn2_text ) && ! empty( $slide['awea_slider_btn2_url']['url'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $btn2_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
											<span><?php echo esc_html( $btn2_text ); ?></span>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
		<?php
	}
}