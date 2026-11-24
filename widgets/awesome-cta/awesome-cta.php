<?php
/**
 * Awesome CTA Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_CTA extends Widget_Base {

	public function get_name() {
		return 'awesome-cta';
	}

	public function get_title() {
		return esc_html__( 'CTA', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'cta', 'hero', 'banner', 'action', 'button', 'convert', 'promo' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. HEADINGS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_content',
			[
				'label' => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_badge_show',
			[
				'label'        => esc_html__( 'Show Tag Pill', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_cta_badge_icon',
			[
				'label'     => esc_html__( 'Tag Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_badge_text',
			[
				'label'       => esc_html__( 'Tag Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ready to Launch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_badge_dot',
			[
				'label'        => esc_html__( 'Live Pulse Dot', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'GET STARTED TODAY', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_cta_title',
			[
				'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Elevate Your Digital Presence Today.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_cta_hl_text',
			[
				'label'       => esc_html__( 'Highlight Words', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Type any word or phrase from your heading to highlight it.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Digital Presence', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_cta_hl_style',
			[
				'label'        => esc_html__( 'Highlight Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'color',
				'options'      => [
					'color'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
					'gradient'  => esc_html__( 'Color Gradient', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Clean Underline', 'awesome-widgets-elementor' ),
					'marker'    => esc_html__( 'Soft Marker', 'awesome-widgets-elementor' ),
					'box'       => esc_html__( 'Tinted Pill Box', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_cta_hl_text!' => '' ],
				'prefix_class' => 'awea-cta-hl-',
			]
		);

		$this->add_control(
			'awea_cta_title_tag',
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
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'awea_cta_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'The all-in-one suite to construct, launch, and scale high-performance brand experiences with zero bloat.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_cta_note_icon',
			[
				'label'     => esc_html__( 'Bottom Note Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-shield-alt',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cta_note',
			[
				'label'       => esc_html__( 'Bottom Note', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'No credit card required • Instant setup • Cancel anytime', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. FIRST BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_btn1',
			[
				'label' => esc_html__( 'First Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_btn1_show',
			[
				'label'        => esc_html__( 'Show First Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_cta_btn1_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_link',
			[
				'label'     => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SECOND BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_btn2',
			[
				'label' => esc_html__( 'Second Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_btn2_show',
			[
				'label'        => esc_html__( 'Show Second Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_cta_btn2_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Book Live Demo', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_link',
			[
				'label'     => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-calendar-check',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. LAYOUT & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_layout',
			[
				'label' => esc_html__( 'Layout & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_layout_mode',
			[
				'label'        => esc_html__( 'Layout Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'stacked' => esc_html__( 'Stacked (Centered / Aligned)', 'awesome-widgets-elementor' ),
					'split'   => esc_html__( 'Side by Side (Text Left, Buttons Right)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cta-mode-',
			]
		);

		$this->add_responsive_control(
			'awea_cta_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'center',
				'condition'            => [ 'awea_cta_layout_mode' => 'stacked' ],
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea-cta-justify: flex-start; --awea-cta-ml: 0; --awea-cta-mr: auto;',
					'center' => 'text-align: center; --awea-cta-justify: center; --awea-cta-ml: auto; --awea-cta-mr: auto;',
					'right'  => 'text-align: right; --awea-cta-justify: flex-end; --awea-cta-ml: auto; --awea-cta-mr: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-cta-box' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_cta_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'         => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-always'   => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'top-hover'    => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'bottom-always'=> esc_html__( 'Bottom Line (Always Show)', 'awesome-widgets-elementor' ),
					'left-always'  => esc_html__( 'Left Line (Always Show)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cta-bar-',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. BOX CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_box',
			[
				'label' => esc_html__( 'Box Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cta_max_width',
			[
				'label'      => esc_html__( 'Content Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1160 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '64',
					'right'    => '48',
					'bottom'   => '64',
					'left'     => '48',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_backdrop_blur',
			[
				'label'      => esc_html__( 'Background Blur', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-box' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'awea_cta_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line Start', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_cta_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-accent-bar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_accent_bar_color_2',
			[
				'label'     => esc_html__( 'Color Line End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_cta_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-accent-bar' => 'background: linear-gradient(90deg, {{awea_cta_accent_bar_color.VALUE}}, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_cta_accent_bar_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'condition'  => [ 'awea_cta_accent_bar!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-cta-bar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cta_border',
				'selector'       => '{{WRAPPER}} .awea-cta-box',
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
				'name'     => 'awea_cta_box_shadow',
				'selector' => '{{WRAPPER}} .awea-cta-box',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. TAG PILL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_badge',
			[
				'label'     => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cta-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cta_badge_border',
				'selector' => '{{WRAPPER}} .awea-cta-badge',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_badge_typo',
				'selector' => '{{WRAPPER}} .awea-cta-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '7',
					'right'    => '16',
					'bottom'   => '7',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. HEADINGS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_text',
			[
				'label' => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cta_subtitle_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_cta_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-cta-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_subtitle_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cta_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_cta_hl_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-hl' => 'color: {{VALUE}}; --awea-cta-hl: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_hl_color_2',
			[
				'label'     => esc_html__( 'Highlight Gradient End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [
					'awea_cta_hl_text!' => '',
					'awea_cta_hl_style' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-hl' => '--awea-cta-hl-2: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_title_typo',
				'selector' => '{{WRAPPER}} .awea-cta-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_cta_title_shadow',
				'selector' => '{{WRAPPER}} .awea-cta-title',
			]
		);

		$this->add_responsive_control(
			'awea_cta_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_desc_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cta_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_desc_typo',
				'selector' => '{{WRAPPER}} .awea-cta-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_desc_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 300, 'max' => 1000 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 640 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_desc_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 34 ],
				'condition'  => [ 'awea_cta_layout_mode' => 'stacked' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_note_heading',
			[
				'label'     => esc_html__( 'Bottom Note', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_cta_note!' => '' ],
			]
		);

		$this->add_control(
			'awea_cta_note_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'condition' => [ 'awea_cta_note!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_cta_note_typo',
				'selector'  => '{{WRAPPER}} .awea-cta-note',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_cta_note!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_buttons',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_btn_typo',
				'selector' => '{{WRAPPER}} .awea-cta-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_gap',
			[
				'label'      => esc_html__( 'Space Between Buttons', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-cta-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '15',
					'right'    => '30',
					'bottom'   => '15',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// First Button Colors
		$this->add_control(
			'awea_cta_btn1_heading',
			[
				'label'     => esc_html__( 'First Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_cta_btn1_tabs',
			[ 'condition' => [ 'awea_cta_btn1_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_cta_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn1_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_btn1_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cta_btn1_border',
				'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn1_shadow',
				'selector' => '{{WRAPPER}} .awea-cta-btn-primary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cta_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn1_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_btn1_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible',
			]
		);

		$this->add_control(
			'awea_cta_btn1_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn1_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Second Button Colors
		$this->add_control(
			'awea_cta_btn2_heading',
			[
				'label'     => esc_html__( 'Second Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_cta_btn2_tabs',
			[ 'condition' => [ 'awea_cta_btn2_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_cta_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn2_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_btn2_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cta_btn2_border',
				'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn2_shadow',
				'selector' => '{{WRAPPER}} .awea-cta-btn-secondary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cta_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn2_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_btn2_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible',
			]
		);

		$this->add_control(
			'awea_cta_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn2_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Safely highlight a phrase inside title text without breaking HTML tags.
	 */
	private function format_highlighted_title( $title, $hl_text ) {
		$safe_title = wp_kses_post( $title );
		if ( empty( $hl_text ) ) {
			return $safe_title;
		}

		$escaped_hl = esc_html( $hl_text );
		$pattern    = '/(' . preg_quote( $escaped_hl, '/' ) . ')(?![^<]*>)/';

		return preg_replace(
			$pattern,
			'<span class="awea-cta-hl">$1</span>',
			$safe_title,
			1
		);
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$badge_show = 'yes' === ( $settings['awea_cta_badge_show'] ?? 'no' );
		$badge_text = $settings['awea_cta_badge_text'] ?? '';
		$badge_dot  = 'yes' === ( $settings['awea_cta_badge_dot'] ?? 'no' );

		$subtitle  = $settings['awea_cta_subtitle'] ?? '';
		$title     = $settings['awea_cta_title'] ?? '';
		$hl_text   = trim( $settings['awea_cta_hl_text'] ?? '' );
		$title_tag = Utils::validate_html_tag( $settings['awea_cta_title_tag'] ?? 'h2' );
		$desc      = $settings['awea_cta_desc'] ?? '';
		$note      = $settings['awea_cta_note'] ?? '';
		$has_nico  = ! empty( $settings['awea_cta_note_icon']['value'] );

		$btn1_show  = 'yes' === ( $settings['awea_cta_btn1_show'] ?? 'no' );
		$btn1_text  = $settings['awea_cta_btn1_text'] ?? '';
		$btn1_pos   = $settings['awea_cta_btn1_icon_pos'] ?? 'right';
		$has_b1_ico = ! empty( $settings['awea_cta_btn1_icon']['value'] );

		$btn2_show  = 'yes' === ( $settings['awea_cta_btn2_show'] ?? 'no' );
		$btn2_text  = $settings['awea_cta_btn2_text'] ?? '';
		$btn2_pos   = $settings['awea_cta_btn2_icon_pos'] ?? 'left';
		$has_b2_ico = ! empty( $settings['awea_cta_btn2_icon']['value'] );

		// Live Canvas Inline Editing
		$this->add_inline_editing_attributes( 'awea_cta_subtitle', 'none' );
		$this->add_inline_editing_attributes( 'awea_cta_desc', 'basic' );
		$this->add_inline_editing_attributes( 'awea_cta_note', 'none' );

		$this->add_render_attribute( 'awea_cta_subtitle', 'class', 'awea-cta-subtitle' );
		$this->add_render_attribute( 'awea_cta_desc', 'class', 'awea-cta-desc' );

		if ( $btn1_show ) {
			$btn1_link = ! empty( $settings['awea_cta_btn1_link']['url'] ) ? $settings['awea_cta_btn1_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn1', $btn1_link );
			$this->add_render_attribute( 'btn1', 'class', [ 'awea-cta-btn', 'awea-cta-btn-primary' ] );
		}

		if ( $btn2_show ) {
			$btn2_link = ! empty( $settings['awea_cta_btn2_link']['url'] ) ? $settings['awea_cta_btn2_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn2', $btn2_link );
			$this->add_render_attribute( 'btn2', 'class', [ 'awea-cta-btn', 'awea-cta-btn-secondary' ] );
		}

		$formatted_title = $this->format_highlighted_title( $title, $hl_text );
		?>
		<section class="awea-cta-box">
			<span class="awea-cta-accent-bar" aria-hidden="true"></span>

			<div class="awea-cta-inner">

				<div class="awea-cta-copy">
					<?php if ( $badge_show && ! empty( $badge_text ) ) : ?>
						<div class="awea-cta-badge-wrap">
							<span class="awea-cta-badge">
								<?php if ( $badge_dot ) : ?>
									<span class="awea-cta-pulse" aria-hidden="true"></span>
								<?php endif; ?>

								<?php if ( ! empty( $settings['awea_cta_badge_icon']['value'] ) ) : ?>
									<span class="awea-cta-badge-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_cta_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>

								<span><?php echo esc_html( $badge_text ); ?></span>
							</span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $subtitle ) ) : ?>
						<span <?php $this->print_render_attribute_string( 'awea_cta_subtitle' ); ?>>
							<?php echo esc_html( $subtitle ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-cta-title">
							<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $desc ) ) : ?>
						<p <?php $this->print_render_attribute_string( 'awea_cta_desc' ); ?>>
							<?php echo wp_kses_post( $desc ); ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) || ! empty( $note ) ) : ?>
					<div class="awea-cta-action-col">
						<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) ) : ?>
							<div class="awea-cta-actions">
								<?php if ( $btn1_show && ! empty( $btn1_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'btn1' ); ?>>
										<?php if ( 'left' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn1_text ); ?></span>

										<?php if ( 'right' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>

								<?php if ( $btn2_show && ! empty( $btn2_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'btn2' ); ?>>
										<?php if ( 'left' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn2_text ); ?></span>

										<?php if ( 'right' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $note ) ) : ?>
							<p class="awea-cta-note">
								<?php if ( $has_nico ) : ?>
									<span class="awea-cta-note-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_cta_note_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span <?php $this->print_render_attribute_string( 'awea_cta_note' ); ?>><?php echo esc_html( $note ); ?></span>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var tag       = elementor.helpers.validateHTMLTag( settings.awea_cta_title_tag || 'h2' );
		var safeTitle = _.escape( settings.awea_cta_title || '' );
		var hlText    = _.escape( ( settings.awea_cta_hl_text || '' ).trim() );
		var badgeIco  = elementor.helpers.renderIcon( view, settings.awea_cta_badge_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var noteIco   = elementor.helpers.renderIcon( view, settings.awea_cta_note_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn1Ico   = elementor.helpers.renderIcon( view, settings.awea_cta_btn1_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn2Ico   = elementor.helpers.renderIcon( view, settings.awea_cta_btn2_icon, { 'aria-hidden': true }, 'i' , 'object' );

		view.addInlineEditingAttributes( 'awea_cta_subtitle', 'none' );
		view.addInlineEditingAttributes( 'awea_cta_desc', 'basic' );
		view.addInlineEditingAttributes( 'awea_cta_note', 'none' );

		view.addRenderAttribute( 'awea_cta_subtitle', 'class', 'awea-cta-subtitle' );
		view.addRenderAttribute( 'awea_cta_desc', 'class', 'awea-cta-desc' );

		if ( hlText && safeTitle.indexOf( hlText ) !== -1 ) {
			safeTitle = safeTitle.replace( hlText, '<span class="awea-cta-hl">' + hlText + '</span>' );
		}
		#>
		<section class="awea-cta-box">
			<span class="awea-cta-accent-bar" aria-hidden="true"></span>

			<div class="awea-cta-inner">
				<div class="awea-cta-copy">
					<# if ( 'yes' === settings.awea_cta_badge_show && settings.awea_cta_badge_text ) { #>
						<div class="awea-cta-badge-wrap">
							<span class="awea-cta-badge">
								<# if ( 'yes' === settings.awea_cta_badge_dot ) { #>
									<span class="awea-cta-pulse" aria-hidden="true"></span>
								<# } #>
								<# if ( badgeIco && badgeIco.rendered ) { #>
									<span class="awea-cta-badge-ico" aria-hidden="true">{{{ badgeIco.value }}}</span>
								<# } #>
								<span>{{{ settings.awea_cta_badge_text }}}</span>
							</span>
						</div>
					<# } #>

					<# if ( settings.awea_cta_subtitle ) { #>
						<span {{{ view.getRenderAttributeString( 'awea_cta_subtitle' ) }}}>{{{ settings.awea_cta_subtitle }}}</span>
					<# } #>

					<# if ( safeTitle ) { #>
						<{{{ tag }}} class="awea-cta-title">{{{ safeTitle }}}</{{{ tag }}}>
					<# } #>

					<# if ( settings.awea_cta_desc ) { #>
						<p {{{ view.getRenderAttributeString( 'awea_cta_desc' ) }}}>{{{ settings.awea_cta_desc }}}</p>
					<# } #>
				</div>

				<# if ( ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) || ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) || settings.awea_cta_note ) { #>
					<div class="awea-cta-action-col">
						<# if ( ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) || ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) ) { #>
							<div class="awea-cta-actions">
								<# if ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) { #>
									<a href="{{ settings.awea_cta_btn1_link.url || '#' }}" class="awea-cta-btn awea-cta-btn-primary">
										<# if ( 'left' === settings.awea_cta_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_cta_btn1_text }}}</span>
										<# if ( 'right' === settings.awea_cta_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>

								<# if ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) { #>
									<a href="{{ settings.awea_cta_btn2_link.url || '#' }}" class="awea-cta-btn awea-cta-btn-secondary">
										<# if ( 'left' === settings.awea_cta_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_cta_btn2_text }}}</span>
										<# if ( 'right' === settings.awea_cta_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>
							</div>
						<# } #>

						<# if ( settings.awea_cta_note ) { #>
							<p class="awea-cta-note">
								<# if ( noteIco && noteIco.rendered ) { #>
									<span class="awea-cta-note-ico" aria-hidden="true">{{{ noteIco.value }}}</span>
								<# } #>
								<span {{{ view.getRenderAttributeString( 'awea_cta_note' ) }}}>{{{ settings.awea_cta_note }}}</span>
							</p>
						<# } #>
					</div>
				<# } #>
			</div>
		</section>
		<?php
	}
}