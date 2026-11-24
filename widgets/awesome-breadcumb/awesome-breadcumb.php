<?php
/**
 * Awesome Breadcrumb Widget.
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
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Breadcumb extends Widget_Base {

	public function get_name() {
		return 'awesome-breadcumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'breadcrumb', 'navigation', 'trail', 'header', 'page title', 'seo', 'banner' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. NAVIGATION TRAIL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_section_breadcrumb',
			[
				'label' => esc_html__( 'Navigation Trail', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bc_source',
			[
				'label'   => esc_html__( 'Trail Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__( 'Automatic (WordPress Pages)', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Links', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_bc_home_label',
			[
				'label'     => esc_html__( 'Home Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Home', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_bc_source' => 'dynamic' ],
			]
		);

		$this->add_control(
			'awea_bc_home_icon',
			[
				'label'   => esc_html__( 'Home Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-home',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'awea_bc_show_current_crumb',
			[
				'label'        => esc_html__( 'Show Current Page Name', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_bc_source' => 'dynamic' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_bc_crumb_label',
			[
				'label'       => esc_html__( 'Link Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Page', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_bc_crumb_url',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_bc_custom_crumbs',
			[
				'label'       => esc_html__( 'Custom Trail Links', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_bc_crumb_label }}}',
				'condition'   => [ 'awea_bc_source' => 'custom' ],
				'default'     => [
					[
						'awea_bc_crumb_label' => esc_html__( 'Home', 'awesome-widgets-elementor' ),
						'awea_bc_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_bc_crumb_label' => esc_html__( 'Services', 'awesome-widgets-elementor' ),
						'awea_bc_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_bc_crumb_label' => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
						'awea_bc_crumb_url'   => [ 'url' => '' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. PAGE HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_section_header',
			[
				'label' => esc_html__( 'Page Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bc_show_title',
			[
				'label'        => esc_html__( 'Show Page Heading', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_bc_eyebrow',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'OVERVIEW', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bc_custom_title',
			[
				'label'       => esc_html__( 'Custom Page Heading', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Leave empty in Automatic mode to use the current page title.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bc_subtitle',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => '',
				'placeholder' => esc_html__( 'Optional short context line below the heading...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bc_title_tag',
			[
				'label'     => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h1',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'span' => 'span',
					'div'  => 'div',
				],
				'condition' => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bc_trail_pos',
			[
				'label'     => esc_html__( 'Trail Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Heading', 'awesome-widgets-elementor' ),
					'below' => esc_html__( 'Below Heading', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SEPARATOR & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_section_separator',
			[
				'label' => esc_html__( 'Separator & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bc_sep_type',
			[
				'label'   => esc_html__( 'Separator Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'chevron',
				'options' => [
					'chevron' => esc_html__( 'Chevron ( › )', 'awesome-widgets-elementor' ),
					'slash'   => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'dot'     => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'dash'    => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_bc_sep_icon',
			[
				'label'     => esc_html__( 'Choose Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_bc_sep_type' => 'custom' ],
			]
		);

		$this->add_control(
			'awea_bc_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'          => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'bottom-always' => esc_html__( 'Bottom Line', 'awesome-widgets-elementor' ),
					'top-always'    => esc_html__( 'Top Line', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bc-bar-',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. BANNER BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_style_layout',
			[
				'label' => esc_html__( 'Banner Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_bc_align',
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
					'left'   => 'text-align: left; --awea-bc-justify: flex-start; --awea-bc-ml: 0; --awea-bc-mr: auto;',
					'center' => 'text-align: center; --awea-bc-justify: center; --awea-bc-ml: auto; --awea-bc-mr: auto;',
					'right'  => 'text-align: right; --awea-bc-justify: flex-end; --awea-bc-ml: auto; --awea-bc-mr: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-bc-hero' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_max_width',
			[
				'label'      => esc_html__( 'Content Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '72',
					'right'    => '24',
					'bottom'   => '72',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_bc_border',
				'selector' => '{{WRAPPER}} .awea-bc-hero',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_bc_shadow',
				'selector' => '{{WRAPPER}} .awea-bc-hero',
			]
		);

		$this->add_control(
			'awea_bc_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line Start', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_bc_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-accent-bar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bc_accent_bar_color_2',
			[
				'label'     => esc_html__( 'Color Line End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_bc_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-accent-bar' => 'background: linear-gradient(90deg, {{awea_bc_accent_bar_color.VALUE}}, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_bc_accent_bar_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'condition'  => [ 'awea_bc_accent_bar!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-bc-bar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BACKGROUND & OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_style_background',
			[
				'label' => esc_html__( 'Background & Overlay', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_bc_banner_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-bc-hero',
			]
		);

		$this->add_control(
			'awea_bc_overlay_heading',
			[
				'label'     => esc_html__( 'Overlay Tint', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_bc_banner_overlay',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-bc-hero::before',
			]
		);

		$this->add_responsive_control(
			'awea_bc_overlay_opacity',
			[
				'label'     => esc_html__( 'Overlay Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'   => [ 'size' => 0 ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-hero::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. HEADINGS & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_style_title',
			[
				'label'     => esc_html__( 'Headings & Text', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_bc_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bc_eyebrow_heading',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_bc_eyebrow_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bc_eyebrow_typo',
				'selector' => '{{WRAPPER}} .awea-bc-eyebrow',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_bc_eyebrow_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_bc_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_bc_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bc_title_typo',
				'selector' => '{{WRAPPER}} .awea-bc-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_bc_title_shadow',
				'selector' => '{{WRAPPER}} .awea-bc-title',
			]
		);

		$this->add_responsive_control(
			'awea_bc_title_space',
			[
				'label'      => esc_html__( 'Space Between Heading & Trail', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-header'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-nav-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_bc_subtitle_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_bc_subtitle!' => '' ],
			]
		);

		$this->add_control(
			'awea_bc_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'condition' => [ 'awea_bc_subtitle!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_bc_subtitle_typo',
				'selector'  => '{{WRAPPER}} .awea-bc-subtitle',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
				'condition' => [ 'awea_bc_subtitle!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_bc_subtitle_space',
			[
				'label'      => esc_html__( 'Space Above Description', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'condition'  => [ 'awea_bc_subtitle!' => '' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TRAIL BAR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_style_trail',
			[
				'label' => esc_html__( 'Trail Bar', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_bc_trail_pill',
			[
				'label'        => esc_html__( 'Show Pill Box', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-bc-pill-',
			]
		);

		$this->add_control(
			'awea_bc_pill_bg',
			[
				'label'     => esc_html__( 'Pill Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_bc_trail_pill' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bc_pill_border',
			[
				'label'     => esc_html__( 'Pill Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_bc_trail_pill' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_pill_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '8',
					'right'    => '18',
					'bottom'   => '8',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition'  => [ 'awea_bc_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_pill_radius',
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
				'condition'  => [ 'awea_bc_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_bc_trail_typo',
				'selector'  => '{{WRAPPER}} .awea-bc-list',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_bc_trail_tabs' );

		$this->start_controls_tab(
			'awea_bc_trail_link',
			[ 'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_bc_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_bc_trail_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_bc_link_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item a:hover, {{WRAPPER}} .awea-bc-item a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_bc_trail_current',
			[ 'label' => esc_html__( 'Current Page', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_bc_current_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item.is-current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_bc_home_icon_size',
			[
				'label'      => esc_html__( 'Home Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-home-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-home-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bc_style_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_bc_sep_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-sep'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-sep svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-sep i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bc_sep_gap',
			[
				'label'      => esc_html__( 'Space Around Separator', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-sep' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_bc_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-sep'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-bc-sep svg' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .awea-bc-sep i'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build full WordPress dynamic breadcrumb trail (Pages, Posts, CPTs, Taxonomies, WooCommerce, Archives).
	 */
	private function get_dynamic_breadcrumbs( $home_label, $include_current = true ) {
		$crumbs   = [];
		$crumbs[] = [
			'label'   => $home_label,
			'url'     => home_url( '/' ),
			'is_home' => true,
		];

		if ( is_front_page() ) {
			return $crumbs;
		}

		if ( is_home() ) {
			$blog_id    = (int) get_option( 'page_for_posts' );
			$blog_title = $blog_id ? get_the_title( $blog_id ) : esc_html__( 'Blog', 'awesome-widgets-elementor' );
			if ( $include_current ) {
				$crumbs[] = [ 'label' => $blog_title, 'url' => null ];
			}
			return $crumbs;
		}

		// WooCommerce Shop & Product support
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( $shop_id > 0 && ! is_shop() ) {
				$crumbs[] = [
					'label' => get_the_title( $shop_id ),
					'url'   => get_permalink( $shop_id ),
				];
			}
		}

		if ( is_singular() ) {
			$post      = get_queried_object();
			$post_type = get_post_type( $post );

			if ( 'post' === $post_type ) {
				$blog_id = (int) get_option( 'page_for_posts' );
				if ( $blog_id > 0 ) {
					$crumbs[] = [
						'label' => get_the_title( $blog_id ),
						'url'   => get_permalink( $blog_id ),
					];
				}
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					$primary_cat = $cats[0];
					if ( $primary_cat->parent ) {
						$cat_ancestors = array_reverse( get_ancestors( $primary_cat->term_id, 'category' ) );
						foreach ( $cat_ancestors as $cat_id ) {
							$ancestor_term = get_term( $cat_id, 'category' );
							if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
								$crumbs[] = [
									'label' => $ancestor_term->name,
									'url'   => get_category_link( $ancestor_term->term_id ),
								];
							}
						}
					}
					$crumbs[] = [
						'label' => $primary_cat->name,
						'url'   => get_category_link( $primary_cat->term_id ),
					];
				}
			} elseif ( 'page' === $post_type ) {
				if ( $post->post_parent ) {
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
					foreach ( $ancestors as $ancestor_id ) {
						$crumbs[] = [
							'label' => get_the_title( $ancestor_id ),
							'url'   => get_permalink( $ancestor_id ),
						];
					}
				}
			} elseif ( 'product' !== $post_type ) {
				$pto = get_post_type_object( $post_type );
				if ( $pto && ! empty( $pto->has_archive ) ) {
					$crumbs[] = [
						'label' => $pto->labels->name,
						'url'   => get_post_type_archive_link( $post_type ),
					];
				}
			}

			if ( $include_current ) {
				$crumbs[] = [ 'label' => get_the_title( $post->ID ), 'url' => null ];
			}
		} elseif ( is_post_type_archive() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => post_type_archive_title( '', false ), 'url' => null ];
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term && ! is_wp_error( $term ) ) {
				if ( ! empty( $term->parent ) ) {
					$term_ancestors = array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) );
					foreach ( $term_ancestors as $ancestor_id ) {
						$ancestor = get_term( $ancestor_id, $term->taxonomy );
						if ( $ancestor && ! is_wp_error( $ancestor ) ) {
							$crumbs[] = [
								'label' => $ancestor->name,
								'url'   => get_term_link( $ancestor ),
							];
						}
					}
				}
				if ( $include_current ) {
					$crumbs[] = [ 'label' => $term->name, 'url' => null ];
				}
			}
		} elseif ( is_search() ) {
			if ( $include_current ) {
				$crumbs[] = [
					/* translators: %s: search query string */
					'label' => sprintf( esc_html__( 'Search: "%s"', 'awesome-widgets-elementor' ), get_search_query() ),
					'url'   => null,
				];
			}
		} elseif ( is_author() ) {
			if ( $include_current ) {
				$crumbs[] = [
					'label' => get_the_author_meta( 'display_name', get_query_var( 'author' ) ),
					'url'   => null,
				];
			}
		} elseif ( is_date() ) {
			if ( is_year() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => null ];
			} elseif ( is_month() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => get_year_link( get_the_time( 'Y' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'F' ), 'url' => null ];
			} elseif ( is_day() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => get_year_link( get_the_time( 'Y' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'F' ), 'url' => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'd' ), 'url' => null ];
			}
		} elseif ( is_404() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => esc_html__( 'Page Not Found', 'awesome-widgets-elementor' ), 'url' => null ];
			}
		} elseif ( is_archive() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => wp_strip_all_tags( get_the_archive_title() ), 'url' => null ];
			}
		}

		return $crumbs;
	}

	/**
	 * Render breadcrumb navigation trail.
	 */
	protected function render_trail( $crumbs, $settings, $extra_class = '' ) {
		if ( empty( $crumbs ) ) {
			return;
		}
		$sep_type      = $settings['awea_bc_sep_type'] ?? 'chevron';
		$has_home_icon = ! empty( $settings['awea_bc_home_icon']['value'] );
		$total_items   = count( $crumbs );
		?>
		<nav class="awea-bc-nav <?php echo esc_attr( $extra_class ); ?>" aria-label="<?php esc_attr_e( 'Breadcrumb', 'awesome-widgets-elementor' ); ?>">
			<ol class="awea-bc-list" itemscope itemtype="https://schema.org/BreadcrumbList">
				<?php foreach ( $crumbs as $index => $crumb ) :
					$is_last  = ( $index === $total_items - 1 );
					$position = $index + 1;
					$is_home  = ! empty( $crumb['is_home'] ) || 0 === $index;
					$link_key = 'awea_bc_link_' . $index;

					$has_url = ! empty( $crumb['url'] ) && ! $is_last;
					if ( $has_url ) {
						if ( ! empty( $crumb['link_data'] ) && is_array( $crumb['link_data'] ) ) {
							$this->add_link_attributes( $link_key, $crumb['link_data'] );
						} else {
							$this->add_render_attribute( $link_key, 'href', esc_url( $crumb['url'] ) );
						}
						$this->add_render_attribute( $link_key, 'itemprop', 'item' );
					}
					?>
					<li class="awea-bc-item <?php echo $is_last ? 'is-current' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<?php if ( $has_url ) : ?>
							<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<?php if ( $is_home && $has_home_icon ) : ?>
									<span class="awea-bc-home-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_bc_home_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
							</a>
						<?php else : ?>
							<span class="awea-bc-text" <?php echo $is_last ? 'aria-current="page"' : ''; ?> itemprop="name">
								<?php if ( $is_home && $has_home_icon ) : ?>
									<span class="awea-bc-home-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_bc_home_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<?php echo esc_html( $crumb['label'] ); ?>
							</span>
						<?php endif; ?>

						<meta itemprop="position" content="<?php echo esc_attr( (string) $position ); ?>" />

						<?php if ( ! $is_last ) : ?>
							<span class="awea-bc-sep" aria-hidden="true">
								<?php if ( 'chevron' === $sep_type ) : ?>
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
								<?php elseif ( 'slash' === $sep_type ) : ?>
									/
								<?php elseif ( 'dot' === $sep_type ) : ?>
									&bull;
								<?php elseif ( 'dash' === $sep_type ) : ?>
									&mdash;
								<?php elseif ( 'custom' === $sep_type && ! empty( $settings['awea_bc_sep_icon']['value'] ) ) : ?>
									<?php Icons_Manager::render_icon( $settings['awea_bc_sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</nav>
		<?php
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$source          = $settings['awea_bc_source'] ?? 'dynamic';
		$home_label      = ! empty( $settings['awea_bc_home_label'] ) ? $settings['awea_bc_home_label'] : esc_html__( 'Home', 'awesome-widgets-elementor' );
		$include_current = 'yes' === ( $settings['awea_bc_show_current_crumb'] ?? 'yes' );
		$show_title      = 'yes' === ( $settings['awea_bc_show_title'] ?? 'no' );
		$eyebrow         = $settings['awea_bc_eyebrow'] ?? '';
		$custom_title    = trim( $settings['awea_bc_custom_title'] ?? '' );
		$subtitle        = $settings['awea_bc_subtitle'] ?? '';
		$title_tag       = Utils::validate_html_tag( $settings['awea_bc_title_tag'] ?? 'h1' );
		$trail_pos       = $settings['awea_bc_trail_pos'] ?? 'below';

		$this->add_inline_editing_attributes( 'awea_bc_eyebrow', 'none' );
		$this->add_inline_editing_attributes( 'awea_bc_subtitle', 'basic' );
		$this->add_render_attribute( 'awea_bc_eyebrow', 'class', 'awea-bc-eyebrow' );
		$this->add_render_attribute( 'awea_bc_subtitle', 'class', 'awea-bc-subtitle' );

		if ( 'custom' === $source ) {
			$page_title   = '' !== $custom_title ? $custom_title : esc_html__( 'Our Solutions', 'awesome-widgets-elementor' );
			$custom_items = $settings['awea_bc_custom_crumbs'] ?? [];
			$crumbs       = [];

			foreach ( $custom_items as $idx => $item ) {
				if ( empty( $item['awea_bc_crumb_label'] ) ) {
					continue;
				}
				$crumbs[] = [
					'label'     => $item['awea_bc_crumb_label'],
					'url'       => $item['awea_bc_crumb_url']['url'] ?? '',
					'link_data' => $item['awea_bc_crumb_url'] ?? [],
					'is_home'   => ( 0 === $idx ),
				];
			}
		} else {
			if ( '' !== $custom_title ) {
				$page_title = $custom_title;
			} elseif ( is_404() ) {
				$page_title = esc_html__( 'Page Not Found', 'awesome-widgets-elementor' );
			} elseif ( is_search() ) {
				/* translators: %s: search query */
				$page_title = sprintf( esc_html__( 'Results for "%s"', 'awesome-widgets-elementor' ), get_search_query() );
			} elseif ( is_home() ) {
				$blog_id    = (int) get_option( 'page_for_posts' );
				$page_title = $blog_id ? get_the_title( $blog_id ) : esc_html__( 'Blog', 'awesome-widgets-elementor' );
			} elseif ( is_archive() ) {
				$page_title = wp_strip_all_tags( get_the_archive_title() );
			} else {
				$page_title = get_the_title();
			}
			$crumbs = $this->get_dynamic_breadcrumbs( $home_label, $include_current );
		}
		?>
		<header class="awea-bc-hero">
			<span class="awea-bc-accent-bar" aria-hidden="true"></span>

			<div class="awea-bc-inner">

				<?php
				if ( $show_title && 'above' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings, 'awea-bc-nav-top' );
				}
				?>

				<?php if ( $show_title && ( ! empty( $page_title ) || ! empty( $eyebrow ) ) ) : ?>
					<div class="awea-bc-header">
						<?php if ( ! empty( $eyebrow ) ) : ?>
							<span <?php $this->print_render_attribute_string( 'awea_bc_eyebrow' ); ?>>
								<?php echo esc_html( $eyebrow ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $page_title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-bc-title">
								<?php echo esc_html( $page_title ); ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $subtitle ) ) : ?>
							<p <?php $this->print_render_attribute_string( 'awea_bc_subtitle' ); ?>>
								<?php echo wp_kses_post( $subtitle ); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				if ( ! $show_title || 'below' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings );
				}
				?>

			</div>
		</header>
		<?php
	}
}