<?php
/**
 * Awesome Heading Studio Widget.
 * Architectural Section Heading with Kinetic Flow Divider & Micro-Interactions.
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
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Heading extends Widget_Base {

	public function get_name() {
		return 'awesome-heading';
	}

	public function get_title() {
		return esc_html__( 'Heading Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'heading', 'title', 'subheading', 'divider', 'banner', 'typography' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: EDITORIAL CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_heading_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_sub_heading',
			[
				'label'        => esc_html__( 'Show Sub Heading Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_sub_heading',
			[
				'label'       => esc_html__( 'Sub Heading Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Insights • 2026', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_show_sub_heading' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Beyond the Standard Grid.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_heading_tag',
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
			'awea_show_divider',
			[
				'label'        => esc_html__( 'Show Kinetic Divider', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_description',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => esc_html__( 'Reimagining the digital experience through the lens of architectural design and fluid motion engineering.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_show_button',
			[
				'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_button_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_button_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-up-right-from-square',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_button_icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Before Text', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'After Text', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'prefix_class' => 'awea-heading-align-',
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: SUB HEADING BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_subheading',
			[
				'label'     => esc_html__( 'Sub Heading Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_sub_heading' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_sub_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sub_heading_typography',
				'selector' => '{{WRAPPER}} .awea-section-signature-tag',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_sub_heading_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_sub_heading_border',
				'selector' => '{{WRAPPER}} .awea-section-signature-tag',
			]
		);

		$this->add_responsive_control(
			'awea_sub_heading_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sub_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '8', 'right' => '22', 'bottom' => '8', 'left' => '22', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sub_heading_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: MAIN HEADING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_heading',
			[
				'label' => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_heading_typography',
				'selector' => '{{WRAPPER}} .awea-section-signature-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: KINETIC DIVIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_divider',
			[
				'label'     => esc_html__( 'Kinetic Flow Divider', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_divider' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_divider_width',
			[
				'label'      => esc_html__( 'Divider Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 400 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 140 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-divider' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_divider_height',
			[
				'label'      => esc_html__( 'Divider Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-divider' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_divider_track_color',
			[
				'label'     => esc_html__( 'Track Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-divider' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_divider_flow_color',
			[
				'label'     => esc_html__( 'Flow Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-divider::after' => 'background: {{VALUE}}; box-shadow: 0 0 10px {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_divider_speed',
			[
				'label'      => esc_html__( 'Flow Cycle Duration (s)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-divider::after' => 'animation-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_divider_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-divider' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typography',
				'selector' => '{{WRAPPER}} .awea-section-signature-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 1200 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 740 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_button',
			[
				'label'     => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_button_typography',
				'selector' => '{{WRAPPER}} .awea-section-signature-btn',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '16', 'right' => '36', 'bottom' => '16', 'left' => '36', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-section-signature-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .awea-section-signature-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_tabs_button_style' );

		// Normal State
		$this->start_controls_tab(
			'awea_tab_button_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn_border',
				'selector' => '{{WRAPPER}} .awea-section-signature-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_btn_shadow',
				'selector' => '{{WRAPPER}} .awea-section-signature-btn',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'awea_tab_button_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-section-signature-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_btn_hover_shadow',
				'selector' => '{{WRAPPER}} .awea-section-signature-btn:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$show_sub     = 'yes' === ( $settings['awea_show_sub_heading'] ?? 'no' );
		$sub_heading  = $settings['awea_sub_heading'] ?? '';
		$heading      = $settings['awea_heading'] ?? '';
		$heading_tag  = Utils::validate_html_tag( $settings['awea_heading_tag'] ?? 'h2' );
		$show_divider = 'yes' === ( $settings['awea_show_divider'] ?? 'no' );
		$description  = $settings['awea_description'] ?? '';
		$show_btn     = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_button_text'] ?? '';
		$icon_align   = $settings['awea_button_icon_align'] ?? 'right';
		$has_icon     = ! empty( $settings['awea_button_icon']['value'] );

		if ( $show_btn && ! empty( $settings['awea_button_link']['url'] ) ) {
			$this->add_link_attributes( 'awea_button_link', $settings['awea_button_link'] );
		}
		$this->add_render_attribute( 'awea_button_link', 'class', 'awea-section-signature-btn' );
		?>
		<header class="awea-section-signature">
			
			<?php if ( $show_sub && ! empty( $sub_heading ) ) : ?>
				<div class="awea-section-signature-tag-wrap">
					<span class="awea-section-signature-tag"><?php echo esc_html( $sub_heading ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $heading ) ) : ?>
				<<?php echo esc_attr( $heading_tag ); ?> class="awea-section-signature-title">
					<?php echo wp_kses_post( $heading ); ?>
				</<?php echo esc_attr( $heading_tag ); ?>>
			<?php endif; ?>

			<?php if ( $show_divider ) : ?>
				<div class="awea-section-signature-divider-wrap">
					<div class="awea-section-signature-divider" aria-hidden="true"></div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $description ) ) : ?>
				<div class="awea-section-signature-desc-wrap">
					<p class="awea-section-signature-desc"><?php echo wp_kses_post( $description ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
				<div class="awea-section-signature-btn-wrap">
					<a <?php echo $this->get_render_attribute_string( 'awea_button_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php if ( 'left' === $icon_align && $has_icon ) : ?>
							<span class="awea-btn-icon awea-icon-left" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>

						<span class="awea-btn-text"><?php echo esc_html( $btn_text ); ?></span>

						<?php if ( 'right' === $icon_align && $has_icon ) : ?>
							<span class="awea-btn-icon awea-icon-right" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['awea_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>

		</header>
		<?php
	}
}