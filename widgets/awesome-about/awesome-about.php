<?php
/**
 * About Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Widget_Awesome_About extends Widget_Base {

	public function get_name() {
		return 'awesome-about';
	}

	public function get_title() {
		return esc_html__( 'About', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'about', 'company', 'agency', 'story', 'profile', 'overview' ];
	}

	public function get_style_depends() {
		return [ 'awea-about' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* -------------------------------------------------------------------------
		   1. Media Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'section_media',
			[
				'label' => esc_html__( 'Media & Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_image',
			[
				'label'   => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'main_image_size',
				'default'   => 'large',
				'condition' => [
					'main_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'float_image',
			[
				'label'     => esc_html__( 'Floating Accent Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'float_image_size',
				'default'   => 'medium',
				'condition' => [
					'float_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Experience Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'e.g. Since 1998', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   2. Editorial Content Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subheading',
			[
				'label'       => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'The World Trusts Our Modern Digital Logistics.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Heading HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We engineer comprehensive design systems and high-throughput web applications that empower ambitious modern brands globally.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Features List Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Key Highlights', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'feature_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'feature_text',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'features_list',
			[
				'label'       => esc_html__( 'Highlights', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ feature_text }}}',
				'default'     => [
					[
						'feature_text' => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
						'feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'feature_text' => esc_html__( 'Automated Compliance & Security', 'awesome-widgets-elementor' ),
						'feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ),
						'feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'feature_text' => esc_html__( 'Global Freight Infrastructure', 'awesome-widgets-elementor' ),
						'feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   4. Actions (CTA & Phone)
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'section_actions',
			[
				'label' => esc_html__( 'Call to Action', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_btn',
			[
				'label'        => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Services', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label'     => esc_html__( 'Button Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [
					'url' => '#',
				],
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'show_phone',
			[
				'label'        => esc_html__( 'Direct Contact Block', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'phone_icon',
			[
				'label'     => esc_html__( 'Contact Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_label',
			[
				'label'     => esc_html__( 'Caption', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Inquiries:', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_num',
			[
				'label'     => esc_html__( 'Phone / Display Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 234-5678',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_url',
			[
				'label'       => esc_html__( 'Contact Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18002345678',
				'default'     => [
					'url' => 'tel:+18002345678',
				],
				'condition'   => [ 'show_phone' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* -------------------------------------------------------------------------
		   1. Layout & Grid
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'style_layout',
			[
				'label' => esc_html__( 'Layout & Alignment', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_pos',
			[
				'label'        => esc_html__( 'Media Position', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'left',
				'prefix_class' => 'awea-about-pos-',
			]
		);

		$this->add_responsive_control(
			'vertical_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start'  => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'end'    => [
						'title' => esc_html__( 'Bottom', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-about-grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', 'vw' ],
				'range'      => [
					'px'  => [ 'min' => 16, 'max' => 140 ],
					'rem' => [ 'min' => 1, 'max' => 9 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   2. Media & Badge Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'style_media',
			[
				'label' => esc_html__( 'Media & Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'main_img_heading',
			[
				'label' => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'main_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4 / 5',
				'options'   => [
					'1 / 1'   => '1:1 (Square)',
					'4 / 5'   => '4:5 (Portrait)',
					'3 / 4'   => '3:4 (Classic)',
					'4 / 3'   => '4:3 (Landscape)',
					'16 / 10' => '16:10 (Wide)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-main-img' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'main_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '64',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '64',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-main-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_img_shadow',
				'selector' => '{{WRAPPER}} .awea-about-main-img',
			]
		);

		$this->add_control(
			'float_img_heading',
			[
				'label'     => esc_html__( 'Floating Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'float_img_size',
			[
				'label'      => esc_html__( 'Size (%)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [ 'min' => 20, 'max' => 55 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-float-img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'float_border_width',
			[
				'label'      => esc_html__( 'Frame Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-float-img' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_control(
			'float_border_color',
			[
				'label'     => esc_html__( 'Frame Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-float-img' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'float_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-float-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'float_img_shadow',
				'selector'  => '{{WRAPPER}} .awea-about-float-img',
				'condition' => [ 'float_image[url]!' => '' ],
			]
		);

		$this->add_control(
			'badge_heading',
			[
				'label'     => esc_html__( 'Experience Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'badge_text!' => '' ],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-badge' => 'color: {{VALUE}};',
				],
				'condition' => [ 'badge_text!' => '' ],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'badge_text!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'badge_typo',
				'selector'  => '{{WRAPPER}} .awea-about-badge',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'badge_text!' => '' ],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'badge_text!' => '' ],
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'badge_text!' => '' ],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Typography & Content Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'style_text',
			[
				'label' => esc_html__( 'Typography & Spacing', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_heading_style',
			[
				'label' => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'sub_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_line_width',
			[
				'label'      => esc_html__( 'Accent Line Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-line' => 'width: {{SIZE}}{{UNIT}}; display: {{SIZE}} === 0 ? "none" : "block";',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_typo',
				'selector' => '{{WRAPPER}} .awea-about-sub',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'sub_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading_style',
			[
				'label'     => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'selector' => '{{WRAPPER}} .awea-about-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_heading_style',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typo',
				'selector' => '{{WRAPPER}} .awea-about-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   4. Features Matrix Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'style_features',
			[
				'label' => esc_html__( 'Key Highlights', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'feat_cols',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-about-feats' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'feat_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 40 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-feats' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feat_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-feat' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feat_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-feat-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-about-feat-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'feat_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-feat-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-about-feat-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feat_typo',
				'selector' => '{{WRAPPER}} .awea-about-feat',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'feat_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-feats' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   5. Actions Style (Button & Phone)
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'style_cta',
			[
				'label' => esc_html__( 'Call to Action', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_style_heading',
			[
				'label'     => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'btn_typo',
				'selector'  => '{{WRAPPER}} .awea-about-btn',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'tabs_btn_style',
			[
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->start_controls_tab(
			'tab_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'btn_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover, {{WRAPPER}} .awea-about-btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover, {{WRAPPER}} .awea-about-btn:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover, {{WRAPPER}} .awea-about-btn:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'btn_border',
				'selector'  => '{{WRAPPER}} .awea-about-btn',
				'separator' => 'before',
				'condition' => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'show_btn' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'show_btn' => 'yes' ],
			]
		);

		/* Direct Contact Sub-section */
		$this->add_control(
			'phone_style_heading',
			[
				'label'     => esc_html__( 'Direct Contact Block', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-ico' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_icon_bg',
			[
				'label'     => esc_html__( 'Icon Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_lbl_color',
			[
				'label'     => esc_html__( 'Caption Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-lbl' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'phone_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-num' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'phone_num_typo',
				'selector'  => '{{WRAPPER}} .awea-about-phone-num',
				'condition' => [ 'show_phone' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$badge       = $settings['badge_text'] ?? '';
		$subheading  = $settings['subheading'] ?? '';
		$heading     = $settings['heading'] ?? '';
		$heading_tag = Utils::validate_html_tag( $settings['heading_tag'] ?? 'h2' );
		$desc        = $settings['description'] ?? '';
		$features    = $settings['features_list'] ?? [];

		$show_btn    = 'yes' === ( $settings['show_btn'] ?? 'no' );
		$btn_text    = $settings['btn_text'] ?? '';
		$show_phone  = 'yes' === ( $settings['show_phone'] ?? 'no' );
		$phone_lbl   = $settings['phone_label'] ?? '';
		$phone_num   = $settings['phone_num'] ?? '';

		$has_main_img  = ! empty( $settings['main_image']['url'] );
		$has_float_img = ! empty( $settings['float_image']['url'] );

		if ( $show_btn ) {
			$btn_link = ! empty( $settings['btn_link']['url'] ) ? $settings['btn_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn', $btn_link );
			$this->add_render_attribute( 'btn', 'class', 'awea-about-btn' );
		}

		if ( $show_phone && ! empty( $phone_num ) ) {
			$phone_url = $settings['phone_url'] ?? [];
			if ( empty( $phone_url['url'] ) ) {
				$clean_tel        = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_url['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'phone', $phone_url );
			$this->add_render_attribute( 'phone', 'class', 'awea-about-phone-link' );
		}
		?>
		<section class="awea-about-grid">

			<?php if ( $has_main_img || $has_float_img || ! empty( $badge ) ) : ?>
				<div class="awea-about-visual">
					<?php if ( $has_main_img ) : ?>
						<div class="awea-about-main-img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'main_image_size', 'main_image' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_float_img ) : ?>
						<div class="awea-about-float-img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'float_image_size', 'float_image' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $badge ) ) : ?>
						<span class="awea-about-badge"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="awea-about-content">
				<?php if ( ! empty( $subheading ) ) : ?>
					<div class="awea-about-sub">
						<span class="awea-about-line" aria-hidden="true"></span>
						<span><?php echo esc_html( $subheading ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $heading ) ) : ?>
					<<?php Utils::print_validated_html_tag( $heading_tag ); ?> class="awea-about-title">
						<?php echo wp_kses( $heading, [ 'br' => [], 'span' => [ 'class' => [] ], 'strong' => [], 'em' => [] ] ); ?>
					</<?php Utils::print_validated_html_tag( $heading_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $desc ) ) : ?>
					<div class="awea-about-desc">
						<?php echo wp_kses_post( $desc ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<ul class="awea-about-feats">
						<?php foreach ( $features as $feat ) : ?>
							<?php if ( ! empty( $feat['feature_text'] ) ) : ?>
								<li class="awea-about-feat">
									<?php if ( ! empty( $feat['feature_icon']['value'] ) ) : ?>
										<span class="awea-about-feat-icon" aria-hidden="true">
											<?php Icons_Manager::render_icon( $feat['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
									<span><?php echo esc_html( $feat['feature_text'] ); ?></span>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ( $show_btn && ! empty( $btn_text ) ) || ( $show_phone && ! empty( $phone_num ) ) ) : ?>
					<div class="awea-about-actions">
						<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'btn' ); ?>>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<?php if ( ! empty( $settings['btn_icon']['value'] ) ) : ?>
									<span class="awea-about-btn-icon" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'phone' ); ?>>
								<?php if ( ! empty( $settings['phone_icon']['value'] ) ) : ?>
									<span class="awea-about-phone-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['phone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span class="awea-about-phone-meta">
									<?php if ( ! empty( $phone_lbl ) ) : ?>
										<span class="awea-about-phone-lbl"><?php echo esc_html( $phone_lbl ); ?></span>
									<?php endif; ?>
									<span class="awea-about-phone-num"><?php echo esc_html( $phone_num ); ?></span>
								</span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</section>
		<?php
	}
}