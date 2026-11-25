<?php
/**
 * Awesome About Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
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
		return [ 'awea', 'about', 'company', 'agency', 'story', 'profile', 'overview' ];
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
		   1. Photos & Badge Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_section_media',
			[
				'label' => esc_html__( 'Photos & Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ab_main_image',
			[
				'label'   => esc_html__( 'Main Photo', 'awesome-widgets-elementor' ),
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
				'name'      => 'awea_ab_main_image_size',
				'default'   => 'large',
				'condition' => [
					'awea_ab_main_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'awea_ab_float_image',
			[
				'label'     => esc_html__( 'Small Overlay Photo', 'awesome-widgets-elementor' ),
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
				'name'      => 'awea_ab_float_image_size',
				'default'   => 'medium',
				'condition' => [
					'awea_ab_float_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'awea_ab_badge_text',
			[
				'label'       => esc_html__( 'Experience Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Since 1998', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   2. Headings & Text Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_section_content',
			[
				'label' => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ab_subheading',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_ab_heading',
			[
				'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'The World Trusts Our Modern Digital Logistics.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_ab_hl_text',
			[
				'label'       => esc_html__( 'Highlight Words', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Type any word or phrase from your heading to highlight it.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Digital Logistics.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_ab_hl_style',
			[
				'label'        => esc_html__( 'Highlight Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'color',
				'options'      => [
					'color'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
					'gradient'  => esc_html__( 'Color Gradient', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Clean Underline', 'awesome-widgets-elementor' ),
					'marker'    => esc_html__( 'Soft Marker', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_ab_hl_text!' => '' ],
				'prefix_class' => 'awea-about-hl-',
			]
		);

		$this->add_control(
			'awea_ab_heading_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
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
			'awea_ab_description',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We engineer comprehensive design systems and high-throughput web applications that empower ambitious modern brands globally.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Feature Checklist Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_section_features',
			[
				'label' => esc_html__( 'Feature Checklist', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_ab_feature_icon',
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
			'awea_ab_feature_text',
			[
				'label'       => esc_html__( 'Item Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_ab_features_list',
			[
				'label'       => esc_html__( 'Checklist Items', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_ab_feature_text }}}',
				'default'     => [
					[
						'awea_ab_feature_text' => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
						'awea_ab_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_ab_feature_text' => esc_html__( 'Automated Compliance & Security', 'awesome-widgets-elementor' ),
						'awea_ab_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_ab_feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ),
						'awea_ab_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_ab_feature_text' => esc_html__( 'Global Freight Infrastructure', 'awesome-widgets-elementor' ),
						'awea_ab_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   4. Button & Contact Section
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_section_actions',
			[
				'label' => esc_html__( 'Button & Contact', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ab_show_btn',
			[
				'label'        => esc_html__( 'Show Action Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_ab_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Services', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_btn_link',
			[
				'label'     => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [
					'url' => '#',
				],
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_btn_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_show_phone',
			[
				'label'        => esc_html__( 'Show Phone Block', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_ab_phone_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_label',
			[
				'label'     => esc_html__( 'Small Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Inquiries:', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_num',
			[
				'label'     => esc_html__( 'Phone Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 234-5678',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_url',
			[
				'label'       => esc_html__( 'Click Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18002345678',
				'default'     => [
					'url' => 'tel:+18002345678',
				],
				'condition'   => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* -------------------------------------------------------------------------
		   1. Layout & Position Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_style_layout',
			[
				'label' => esc_html__( 'Layout & Position', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ab_image_pos',
			[
				'label'        => esc_html__( 'Photo Side', 'awesome-widgets-elementor' ),
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
			'awea_ab_vertical_align',
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
			'awea_ab_grid_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
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
		   2. Photos & Badge Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_style_media',
			[
				'label' => esc_html__( 'Photos & Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ab_main_img_heading',
			[
				'label' => esc_html__( 'Main Photo', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'awea_ab_main_aspect_ratio',
			[
				'label'     => esc_html__( 'Photo Shape Ratio', 'awesome-widgets-elementor' ),
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
			'awea_ab_main_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '48',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '48',
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
				'name'     => 'awea_ab_main_img_shadow',
				'selector' => '{{WRAPPER}} .awea-about-main-img',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_ab_main_img_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-about-main-img img',
			]
		);

		$this->add_control(
			'awea_ab_float_img_heading',
			[
				'label'     => esc_html__( 'Small Overlay Photo', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_float_img_size',
			[
				'label'      => esc_html__( 'Photo Size (%)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [ 'min' => 20, 'max' => 55 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-float-img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_float_border_width',
			[
				'label'      => esc_html__( 'Outer Ring Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-float-img' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_control(
			'awea_ab_float_border_color',
			[
				'label'     => esc_html__( 'Outer Ring Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-float-img' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_float_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
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
				'condition'  => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_ab_float_img_shadow',
				'selector'  => '{{WRAPPER}} .awea-about-float-img',
				'condition' => [ 'awea_ab_float_image[url]!' => '' ],
			]
		);

		$this->add_control(
			'awea_ab_badge_heading',
			[
				'label'     => esc_html__( 'Experience Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->add_control(
			'awea_ab_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-badge' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->add_control(
			'awea_ab_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_ab_badge_typo',
				'selector'  => '{{WRAPPER}} .awea-about-badge',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_badge_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_badge_text!' => '' ],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Text Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_style_text',
			[
				'label' => esc_html__( 'Text Style', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ab_sub_heading_style',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_ab_sub_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ab_sub_line_width',
			[
				'label'      => esc_html__( 'Side Line Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ab_sub_typo',
				'selector' => '{{WRAPPER}} .awea-about-sub',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_sub_spacing',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_title_heading_style',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ab_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ab_hl_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-hl' => 'color: {{VALUE}}; --awea-ab-hl: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_hl_color_2',
			[
				'label'     => esc_html__( 'Highlight Gradient End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [
					'awea_ab_hl_text!' => '',
					'awea_ab_hl_style' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-hl' => '--awea-ab-hl-2: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ab_title_typo',
				'selector' => '{{WRAPPER}} .awea-about-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_ab_title_shadow',
				'selector' => '{{WRAPPER}} .awea-about-title',
			]
		);

		$this->add_responsive_control(
			'awea_ab_title_spacing',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_desc_heading_style',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ab_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ab_desc_typo',
				'selector' => '{{WRAPPER}} .awea-about-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_desc_spacing',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
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
		   4. Checklist Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_style_features',
			[
				'label' => esc_html__( 'Checklist Style', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ab_feat_cols',
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
			'awea_ab_feat_gap',
			[
				'label'      => esc_html__( 'Space Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 40 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-feats' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_feat_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-feat' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ab_feat_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-feat-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-about-feat-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ab_feat_icon_size',
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
				'name'     => 'awea_ab_feat_typo',
				'selector' => '{{WRAPPER}} .awea-about-feat',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_feat_bottom_spacing',
			[
				'label'      => esc_html__( 'Space Below Checklist', 'awesome-widgets-elementor' ),
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
		   5. Button & Contact Style
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_ab_style_cta',
			[
				'label' => esc_html__( 'Button & Contact Style', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ab_btn_style_heading',
			[
				'label'     => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_ab_btn_typo',
				'selector'  => '{{WRAPPER}} .awea-about-btn',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_ab_tabs_btn_style',
			[
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->start_controls_tab(
			'awea_ab_tab_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ab_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ab_btn_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-about-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ab_tab_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ab_btn_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover, {{WRAPPER}} .awea-about-btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ab_btn_hover_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-about-btn:hover, {{WRAPPER}} .awea-about-btn:focus-visible',
			]
		);

		$this->add_control(
			'awea_ab_btn_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
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
				'name'      => 'awea_ab_btn_border',
				'selector'  => '{{WRAPPER}} .awea-about-btn',
				'separator' => 'before',
				'condition' => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_ab_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'awea_ab_show_btn' => 'yes' ],
			]
		);

		/* Phone Block Sub-section */
		$this->add_control(
			'awea_ab_phone_style_heading',
			[
				'label'     => esc_html__( 'Phone Block', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-ico' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_icon_bg',
			[
				'label'     => esc_html__( 'Icon Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_lbl_color',
			[
				'label'     => esc_html__( 'Small Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-lbl' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ab_phone_num_color',
			[
				'label'     => esc_html__( 'Phone Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-num' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_ab_phone_num_typo',
				'selector'  => '{{WRAPPER}} .awea-about-phone-num',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'condition' => [ 'awea_ab_show_phone' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Safely highlight a phrase inside heading text without breaking HTML tags.
	 */
	private function format_highlighted_heading( $heading, $hl_text ) {
		$safe_heading = wp_kses(
			$heading,
			[
				'br'     => [],
				'span'   => [ 'class' => [] ],
				'strong' => [],
				'em'     => [],
			]
		);
		if ( empty( $hl_text ) ) {
			return $safe_heading;
		}

		$escaped_hl = esc_html( $hl_text );
		$pattern    = '/(' . preg_quote( $escaped_hl, '/' ) . ')(?![^<]*>)/';

		return preg_replace(
			$pattern,
			'<span class="awea-about-hl">$1</span>',
			$safe_heading,
			1
		);
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$badge       = $settings['awea_ab_badge_text'] ?? '';
		$subheading  = $settings['awea_ab_subheading'] ?? '';
		$heading     = $settings['awea_ab_heading'] ?? '';
		$hl_text     = trim( $settings['awea_ab_hl_text'] ?? '' );
		$heading_tag = Utils::validate_html_tag( $settings['awea_ab_heading_tag'] ?? 'h2' );
		$desc        = $settings['awea_ab_description'] ?? '';
		$features    = $settings['awea_ab_features_list'] ?? [];

		$show_btn   = 'yes' === ( $settings['awea_ab_show_btn'] ?? 'no' );
		$btn_text   = $settings['awea_ab_btn_text'] ?? '';
		$show_phone = 'yes' === ( $settings['awea_ab_show_phone'] ?? 'no' );
		$phone_lbl  = $settings['awea_ab_phone_label'] ?? '';
		$phone_num  = $settings['awea_ab_phone_num'] ?? '';

		$has_main_img  = ! empty( $settings['awea_ab_main_image']['url'] );
		$has_float_img = ! empty( $settings['awea_ab_float_image']['url'] );

		$this->add_inline_editing_attributes( 'awea_ab_description', 'advanced' );
		$this->add_render_attribute( 'awea_ab_description', 'class', 'awea-about-desc' );

		if ( $show_btn ) {
			$btn_link = ! empty( $settings['awea_ab_btn_link']['url'] ) ? $settings['awea_ab_btn_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_ab_btn', $btn_link );
			$this->add_render_attribute( 'awea_ab_btn', 'class', 'awea-about-btn' );
		}

		if ( $show_phone && ! empty( $phone_num ) ) {
			$phone_url = $settings['awea_ab_phone_url'] ?? [];
			if ( empty( $phone_url['url'] ) ) {
				$clean_tel        = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_url['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'awea_ab_phone', $phone_url );
			$this->add_render_attribute( 'awea_ab_phone', 'class', 'awea-about-phone-link' );
		}

		$formatted_heading = $this->format_highlighted_heading( $heading, $hl_text );
		?>
		<section class="awea-about-grid">

			<?php if ( $has_main_img || $has_float_img || ! empty( $badge ) ) : ?>
				<div class="awea-about-visual">
					<?php if ( $has_main_img ) : ?>
						<div class="awea-about-main-img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_ab_main_image_size', 'awea_ab_main_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_float_img ) : ?>
						<div class="awea-about-float-img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_ab_float_image_size', 'awea_ab_float_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
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
						<?php echo $formatted_heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</<?php Utils::print_validated_html_tag( $heading_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $desc ) ) : ?>
					<div <?php $this->print_render_attribute_string( 'awea_ab_description' ); ?>>
						<?php echo wp_kses_post( $desc ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<ul class="awea-about-feats">
						<?php foreach ( $features as $feat ) : ?>
							<?php if ( ! empty( $feat['awea_ab_feature_text'] ) ) : ?>
								<li class="awea-about-feat">
									<?php if ( ! empty( $feat['awea_ab_feature_icon']['value'] ) ) : ?>
										<span class="awea-about-feat-icon" aria-hidden="true">
											<?php Icons_Manager::render_icon( $feat['awea_ab_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
									<span><?php echo esc_html( $feat['awea_ab_feature_text'] ); ?></span>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ( $show_btn && ! empty( $btn_text ) ) || ( $show_phone && ! empty( $phone_num ) ) ) : ?>
					<div class="awea-about-actions">
						<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'awea_ab_btn' ); ?>>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<?php if ( ! empty( $settings['awea_ab_btn_icon']['value'] ) ) : ?>
									<span class="awea-about-btn-icon" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_ab_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'awea_ab_phone' ); ?>>
								<?php if ( ! empty( $settings['awea_ab_phone_icon']['value'] ) ) : ?>
									<span class="awea-about-phone-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_ab_phone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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