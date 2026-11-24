<?php
/**
 * Awesome Heading Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Heading extends Widget_Base {

	public function get_name() {
		return 'awesome-heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'heading', 'title', 'hero', 'section', 'divider', 'typography', 'highlight' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. TAG PILL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_section_badge',
			[
				'label' => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_hd_badge_show',
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
			'awea_hd_badge_text',
			[
				'label'       => esc_html__( 'Tag Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Architecture • 2026', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_hd_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_badge_icon',
			[
				'label'     => esc_html__( 'Tag Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 'awea_hd_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_badge_dot',
			[
				'label'        => esc_html__( 'Live Pulse Dot', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_hd_badge_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. HEADINGS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_section_heading',
			[
				'label' => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_hd_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'DESIGN SYSTEM', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_hd_title',
			[
				'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Built Beyond the Standard Grid.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_hd_highlight_text',
			[
				'label'       => esc_html__( 'Highlight Words', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Type any word or phrase from your heading to highlight it.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Standard Grid.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_hd_highlight_style',
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
				'condition'    => [ 'awea_hd_highlight_text!' => '' ],
				'prefix_class' => 'awea-hd-hl-',
			]
		);

		$this->add_control(
			'awea_hd_title_tag',
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
			'awea_hd_title_link',
			[
				'label'   => esc_html__( 'Heading Link (Optional)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_hd_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Reimagining digital interfaces through clean architectural structure, balanced typography, and effortless clarity.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. DIVIDER LINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_section_divider',
			[
				'label' => esc_html__( 'Divider Line', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_hd_divider_style',
			[
				'label'        => esc_html__( 'Line Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'beam',
				'options'      => [
					'none'     => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'beam'     => esc_html__( 'Animated Beam', 'awesome-widgets-elementor' ),
					'solid'    => esc_html__( 'Solid Line', 'awesome-widgets-elementor' ),
					'gradient' => esc_html__( 'Gradient Line', 'awesome-widgets-elementor' ),
					'dots'     => esc_html__( 'Three Dots', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-hd-div-',
			]
		);

		$this->add_control(
			'awea_hd_divider_pos',
			[
				'label'     => esc_html__( 'Line Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Main Heading', 'awesome-widgets-elementor' ),
					'below' => esc_html__( 'Below Main Heading', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_hd_divider_style!' => 'none' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_section_buttons',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Primary Button
		$this->add_control(
			'awea_hd_btn1_show',
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
			'awea_hd_btn1_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_hd_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn1_link',
			[
				'label'     => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_hd_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn1_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_hd_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn1_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_hd_btn1_show' => 'yes' ],
			]
		);

		// Secondary Button
		$this->add_control(
			'awea_hd_btn2_show',
			[
				'label'        => esc_html__( 'Show Second Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_hd_btn2_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_hd_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn2_link',
			[
				'label'     => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_hd_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn2_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 'awea_hd_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_btn2_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_hd_btn2_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_hd_align',
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
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea-hd-justify: flex-start; --awea-hd-ml: 0; --awea-hd-mr: auto;',
					'center' => 'text-align: center; --awea-hd-justify: center; --awea-hd-ml: auto; --awea-hd-mr: auto;',
					'right'  => 'text-align: right; --awea-hd-justify: flex-end; --awea-hd-ml: auto; --awea-hd-mr: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-hd-wrap' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 320, 'max' => 1400 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 820 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. TAG PILL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_style_badge',
			[
				'label'     => esc_html__( 'Tag Pill', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_hd_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_hd_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-hd-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hd_badge_typo',
				'selector' => '{{WRAPPER}} .awea-hd-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_hd_badge_border',
				'selector'       => '{{WRAPPER}} .awea-hd-badge',
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
				'name'     => 'awea_hd_badge_shadow',
				'selector' => '{{WRAPPER}} .awea-hd-badge',
			]
		);

		$this->add_responsive_control(
			'awea_hd_badge_radius',
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
					'{{WRAPPER}} .awea-hd-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_badge_padding',
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
					'{{WRAPPER}} .awea-hd-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_badge_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-badge-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. HEADINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_style_heading',
			[
				'label' => esc_html__( 'Headings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_hd_subtitle_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_hd_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hd_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-hd-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_hd_subtitle_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_hd_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-title, {{WRAPPER}} .awea-hd-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_hd_highlight_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-hl' => 'color: {{VALUE}}; --awea-hl-accent: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_hl_color_2',
			[
				'label'     => esc_html__( 'Highlight Gradient End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [
					'awea_hd_highlight_text!' => '',
					'awea_hd_highlight_style' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-hl' => '--awea-hl-accent-2: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hd_title_typo',
				'selector' => '{{WRAPPER}} .awea-hd-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_hd_title_shadow',
				'selector' => '{{WRAPPER}} .awea-hd-title',
			]
		);

		$this->add_responsive_control(
			'awea_hd_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. DIVIDER LINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_style_divider',
			[
				'label'     => esc_html__( 'Divider Line', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_hd_divider_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_hd_div_width',
			[
				'label'      => esc_html__( 'Line Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 30, 'max' => 320 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 96 ],
				'condition'  => [ 'awea_hd_divider_style!' => 'dots' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-div' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_div_height',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'condition'  => [ 'awea_hd_divider_style!' => 'dots' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-div' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_div_track',
			[
				'label'     => esc_html__( 'Base Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_hd_divider_style' => 'beam' ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-div' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_div_color',
			[
				'label'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}}.awea-hd-div-beam .awea-hd-div::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea-hd-div-solid .awea-hd-div'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea-hd-div-gradient .awea-hd-div'    => '--awea-hd-div-start: {{VALUE}};',
					'{{WRAPPER}}.awea-hd-div-dots .awea-hd-dot'        => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_div_color_2',
			[
				'label'     => esc_html__( 'Gradient End Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_hd_divider_style' => 'gradient' ],
				'selectors' => [
					'{{WRAPPER}}.awea-hd-div-gradient .awea-hd-div' => '--awea-hd-div-end: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_div_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-div-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_style_desc',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_hd_desc!' => '' ],
			]
		);

		$this->add_control(
			'awea_hd_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hd_desc_typo',
				'selector' => '{{WRAPPER}} .awea-hd-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_hd_desc_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 1100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 660 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_desc_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_hd_style_buttons',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hd_btn_typo',
				'selector' => '{{WRAPPER}} .awea-hd-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_hd_btn_gap',
			[
				'label'      => esc_html__( 'Space Between Buttons', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-btn-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-hd-btn-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '14',
					'right'    => '28',
					'bottom'   => '14',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-hd-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hd_btn_radius',
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
					'{{WRAPPER}} .awea-hd-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_hd_btn1_heading',
			[
				'label'     => esc_html__( 'First Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_hd_btn1_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_hd_btn1_tabs',
			[ 'condition' => [ 'awea_hd_btn1_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_hd_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_hd_btn1_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_hd_btn1_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-hd-btn-primary',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_hd_btn1_border',
				'selector' => '{{WRAPPER}} .awea-hd-btn-primary',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_hd_btn1_shadow',
				'selector' => '{{WRAPPER}} .awea-hd-btn-primary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_hd_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_hd_btn1_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-primary:hover, {{WRAPPER}} .awea-hd-btn-primary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_hd_btn1_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-hd-btn-primary:hover, {{WRAPPER}} .awea-hd-btn-primary:focus-visible',
			]
		);

		$this->add_control(
			'awea_hd_btn1_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-primary:hover, {{WRAPPER}} .awea-hd-btn-primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_hd_btn1_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-hd-btn-primary:hover, {{WRAPPER}} .awea-hd-btn-primary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'awea_hd_btn2_heading',
			[
				'label'     => esc_html__( 'Second Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_hd_btn2_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_hd_btn2_tabs',
			[ 'condition' => [ 'awea_hd_btn2_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_hd_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_hd_btn2_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_hd_btn2_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-hd-btn-secondary',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_hd_btn2_border',
				'selector' => '{{WRAPPER}} .awea-hd-btn-secondary',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_hd_btn2_shadow',
				'selector' => '{{WRAPPER}} .awea-hd-btn-secondary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_hd_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_hd_btn2_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-secondary:hover, {{WRAPPER}} .awea-hd-btn-secondary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_hd_btn2_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-hd-btn-secondary:hover, {{WRAPPER}} .awea-hd-btn-secondary:focus-visible',
			]
		);

		$this->add_control(
			'awea_hd_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-hd-btn-secondary:hover, {{WRAPPER}} .awea-hd-btn-secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_hd_btn2_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-hd-btn-secondary:hover, {{WRAPPER}} .awea-hd-btn-secondary:focus-visible',
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
			'<span class="awea-hd-hl">$1</span>',
			$safe_title,
			1
		);
	}

	/**
	 * Render divider helper so it can appear cleanly above or below title.
	 */
	protected function render_divider( $style ) {
		if ( 'none' === $style ) {
			return;
		}
		?>
		<div class="awea-hd-div-wrap" aria-hidden="true">
			<?php if ( 'dots' === $style ) : ?>
				<div class="awea-hd-dots">
					<span class="awea-hd-dot"></span>
					<span class="awea-hd-dot"></span>
					<span class="awea-hd-dot"></span>
				</div>
			<?php else : ?>
				<div class="awea-hd-div"></div>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$badge_show = 'yes' === ( $settings['awea_hd_badge_show'] ?? 'no' );
		$badge_text = $settings['awea_hd_badge_text'] ?? '';
		$badge_dot  = 'yes' === ( $settings['awea_hd_badge_dot'] ?? 'no' );

		$subtitle  = $settings['awea_hd_subtitle'] ?? '';
		$title     = $settings['awea_hd_title'] ?? '';
		$hl_text   = trim( $settings['awea_hd_highlight_text'] ?? '' );
		$title_tag = Utils::validate_html_tag( $settings['awea_hd_title_tag'] ?? 'h2' );
		$has_tlink = ! empty( $settings['awea_hd_title_link']['url'] );

		$div_style = $settings['awea_hd_divider_style'] ?? 'beam';
		$div_pos   = $settings['awea_hd_divider_pos'] ?? 'below';

		$desc = $settings['awea_hd_desc'] ?? '';

		$btn1_show  = 'yes' === ( $settings['awea_hd_btn1_show'] ?? 'no' );
		$btn1_text  = $settings['awea_hd_btn1_text'] ?? '';
		$btn1_pos   = $settings['awea_hd_btn1_icon_pos'] ?? 'right';
		$has_b1_ico = ! empty( $settings['awea_hd_btn1_icon']['value'] );

		$btn2_show  = 'yes' === ( $settings['awea_hd_btn2_show'] ?? 'no' );
		$btn2_text  = $settings['awea_hd_btn2_text'] ?? '';
		$btn2_pos   = $settings['awea_hd_btn2_icon_pos'] ?? 'right';
		$has_b2_ico = ! empty( $settings['awea_hd_btn2_icon']['value'] );

		// Live Canvas Inline Editing
		$this->add_inline_editing_attributes( 'awea_hd_subtitle', 'none' );
		$this->add_inline_editing_attributes( 'awea_hd_desc', 'basic' );

		$this->add_render_attribute( 'awea_hd_subtitle', 'class', 'awea-hd-subtitle' );
		$this->add_render_attribute( 'awea_hd_desc', 'class', 'awea-hd-desc' );

		if ( $has_tlink ) {
			$this->add_link_attributes( 'title_link', $settings['awea_hd_title_link'] );
		}

		if ( $btn1_show ) {
			$btn1_link = ! empty( $settings['awea_hd_btn1_link']['url'] ) ? $settings['awea_hd_btn1_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn1', $btn1_link );
			$this->add_render_attribute( 'btn1', 'class', [ 'awea-hd-btn', 'awea-hd-btn-primary' ] );
		}

		if ( $btn2_show ) {
			$btn2_link = ! empty( $settings['awea_hd_btn2_link']['url'] ) ? $settings['awea_hd_btn2_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn2', $btn2_link );
			$this->add_render_attribute( 'btn2', 'class', [ 'awea-hd-btn', 'awea-hd-btn-secondary' ] );
		}

		$formatted_title = $this->format_highlighted_title( $title, $hl_text );
		?>
		<header class="awea-hd-wrap">

			<?php if ( $badge_show && ! empty( $badge_text ) ) : ?>
				<div class="awea-hd-badge-wrap">
					<span class="awea-hd-badge">
						<?php if ( $badge_dot ) : ?>
							<span class="awea-hd-pulse" aria-hidden="true"></span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['awea_hd_badge_icon']['value'] ) ) : ?>
							<span class="awea-hd-badge-ico" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['awea_hd_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>

						<span><?php echo esc_html( $badge_text ); ?></span>
					</span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $subtitle ) ) : ?>
				<span <?php $this->print_render_attribute_string( 'awea_hd_subtitle' ); ?>>
					<?php echo esc_html( $subtitle ); ?>
				</span>
			<?php endif; ?>

			<?php
			if ( 'above' === $div_pos ) {
				$this->render_divider( $div_style );
			}
			?>

			<?php if ( ! empty( $title ) ) : ?>
				<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-hd-title">
					<?php if ( $has_tlink ) : ?>
						<a <?php $this->print_render_attribute_string( 'title_link' ); ?>>
							<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php else : ?>
						<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
			<?php endif; ?>

			<?php
			if ( 'below' === $div_pos ) {
				$this->render_divider( $div_style );
			}
			?>

			<?php if ( ! empty( $desc ) ) : ?>
				<p <?php $this->print_render_attribute_string( 'awea_hd_desc' ); ?>>
					<?php echo wp_kses_post( $desc ); ?>
				</p>
			<?php endif; ?>

			<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) ) : ?>
				<div class="awea-hd-actions">
					<?php if ( $btn1_show && ! empty( $btn1_text ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'btn1' ); ?>>
							<?php if ( 'left' === $btn1_pos && $has_b1_ico ) : ?>
								<span class="awea-hd-btn-ico awea-hd-ico-left" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_hd_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span><?php echo esc_html( $btn1_text ); ?></span>

							<?php if ( 'right' === $btn1_pos && $has_b1_ico ) : ?>
								<span class="awea-hd-btn-ico awea-hd-ico-right" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_hd_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<?php if ( $btn2_show && ! empty( $btn2_text ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'btn2' ); ?>>
							<?php if ( 'left' === $btn2_pos && $has_b2_ico ) : ?>
								<span class="awea-hd-btn-ico awea-hd-ico-left" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_hd_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span><?php echo esc_html( $btn2_text ); ?></span>

							<?php if ( 'right' === $btn2_pos && $has_b2_ico ) : ?>
								<span class="awea-hd-btn-ico awea-hd-ico-right" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_hd_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</header>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var tag       = elementor.helpers.validateHTMLTag( settings.awea_hd_title_tag || 'h2' );
		var title     = settings.awea_hd_title || '';
		var hlText    = ( settings.awea_hd_highlight_text || '' ).trim();
		var divStyle  = settings.awea_hd_divider_style || 'beam';
		var divPos    = settings.awea_hd_divider_pos || 'below';
		var hasTLink  = settings.awea_hd_title_link && settings.awea_hd_title_link.url;
		var badgeIco  = elementor.helpers.renderIcon( view, settings.awea_hd_badge_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn1Ico   = elementor.helpers.renderIcon( view, settings.awea_hd_btn1_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn2Ico   = elementor.helpers.renderIcon( view, settings.awea_hd_btn2_icon, { 'aria-hidden': true }, 'i' , 'object' );

		view.addInlineEditingAttributes( 'awea_hd_subtitle', 'none' );
		view.addInlineEditingAttributes( 'awea_hd_desc', 'basic' );
		view.addRenderAttribute( 'awea_hd_subtitle', 'class', 'awea-hd-subtitle' );
		view.addRenderAttribute( 'awea_hd_desc', 'class', 'awea-hd-desc' );

		if ( hlText && title.indexOf( hlText ) !== -1 ) {
			title = title.replace( hlText, '<span class="awea-hd-hl">' + _.escape( hlText ) + '</span>' );
		}
		#>
		<header class="awea-hd-wrap">
			<# if ( 'yes' === settings.awea_hd_badge_show && settings.awea_hd_badge_text ) { #>
				<div class="awea-hd-badge-wrap">
					<span class="awea-hd-badge">
						<# if ( 'yes' === settings.awea_hd_badge_dot ) { #>
							<span class="awea-hd-pulse" aria-hidden="true"></span>
						<# } #>
						<# if ( badgeIco && badgeIco.rendered ) { #>
							<span class="awea-hd-badge-ico" aria-hidden="true">{{{ badgeIco.value }}}</span>
						<# } #>
						<span>{{{ settings.awea_hd_badge_text }}}</span>
					</span>
				</div>
			<# } #>

			<# if ( settings.awea_hd_subtitle ) { #>
				<span {{{ view.getRenderAttributeString( 'awea_hd_subtitle' ) }}}>{{{ settings.awea_hd_subtitle }}}</span>
			<# } #>

			<# if ( 'none' !== divStyle && 'above' === divPos ) { #>
				<div class="awea-hd-div-wrap" aria-hidden="true">
					<# if ( 'dots' === divStyle ) { #>
						<div class="awea-hd-dots"><span class="awea-hd-dot"></span><span class="awea-hd-dot"></span><span class="awea-hd-dot"></span></div>
					<# } else { #>
						<div class="awea-hd-div"></div>
					<# } #>
				</div>
			<# } #>

			<# if ( title ) { #>
				<{{{ tag }}} class="awea-hd-title">
					<# if ( hasTLink ) { #>
						<a href="{{ settings.awea_hd_title_link.url }}">{{{ title }}}</a>
					<# } else { #>
						{{{ title }}}
					<# } #>
				</{{{ tag }}}>
			<# } #>

			<# if ( 'none' !== divStyle && 'below' === divPos ) { #>
				<div class="awea-hd-div-wrap" aria-hidden="true">
					<# if ( 'dots' === divStyle ) { #>
						<div class="awea-hd-dots"><span class="awea-hd-dot"></span><span class="awea-hd-dot"></span><span class="awea-hd-dot"></span></div>
					<# } else { #>
						<div class="awea-hd-div"></div>
					<# } #>
				</div>
			<# } #>

			<# if ( settings.awea_hd_desc ) { #>
				<p {{{ view.getRenderAttributeString( 'awea_hd_desc' ) }}}>{{{ settings.awea_hd_desc }}}</p>
			<# } #>

			<# if ( ( 'yes' === settings.awea_hd_btn1_show && settings.awea_hd_btn1_text ) || ( 'yes' === settings.awea_hd_btn2_show && settings.awea_hd_btn2_text ) ) { #>
				<div class="awea-hd-actions">
					<# if ( 'yes' === settings.awea_hd_btn1_show && settings.awea_hd_btn1_text ) { #>
						<a href="{{ settings.awea_hd_btn1_link.url || '#' }}" class="awea-hd-btn awea-hd-btn-primary">
							<# if ( 'left' === settings.awea_hd_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
								<span class="awea-hd-btn-ico awea-hd-ico-left" aria-hidden="true">{{{ btn1Ico.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_hd_btn1_text }}}</span>
							<# if ( 'right' === settings.awea_hd_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
								<span class="awea-hd-btn-ico awea-hd-ico-right" aria-hidden="true">{{{ btn1Ico.value }}}</span>
							<# } #>
						</a>
					<# } #>

					<# if ( 'yes' === settings.awea_hd_btn2_show && settings.awea_hd_btn2_text ) { #>
						<a href="{{ settings.awea_hd_btn2_link.url || '#' }}" class="awea-hd-btn awea-hd-btn-secondary">
							<# if ( 'left' === settings.awea_hd_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
								<span class="awea-hd-btn-ico awea-hd-ico-left" aria-hidden="true">{{{ btn2Ico.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_hd_btn2_text }}}</span>
							<# if ( 'right' === settings.awea_hd_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
								<span class="awea-hd-btn-ico awea-hd-ico-right" aria-hidden="true">{{{ btn2Ico.value }}}</span>
							<# } #>
						</a>
					<# } #>
				</div>
			<# } #>
		</header>
		<?php
	}
}