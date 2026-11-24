<?php
/**
 * Awesome Countdown Widget.
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

class Widget_Awesome_Countdown extends Widget_Base {

	public function get_name() {
		return 'awea_countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'countdown', 'timer', 'clock', 'launch', 'sale', 'urgent', 'event' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. TARGET DATE & TIME
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_section_timer',
			[
				'label' => esc_html__( 'Target Date & Time', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cd_due_date',
			[
				'label'       => esc_html__( 'End Date & Time', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => wp_date( 'Y-m-d H:i', strtotime( '+1 month' ) ),
				'description' => sprintf(
					/* translators: %s: Site current timezone string */
					esc_html__( 'Site Timezone: %s', 'awesome-widgets-elementor' ),
					'<strong>' . esc_html( wp_timezone_string() ) . '</strong>'
				),
			]
		);

		$this->add_control(
			'awea_cd_expire_type',
			[
				'label'   => esc_html__( 'When Timer Ends', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'message',
				'options' => [
					'message'  => esc_html__( 'Show Message', 'awesome-widgets-elementor' ),
					'redirect' => esc_html__( 'Go to Link URL', 'awesome-widgets-elementor' ),
					'none'     => esc_html__( 'Stay at Zero', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_cd_expire_message',
			[
				'label'     => esc_html__( 'Ended Message', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 2,
				'default'   => esc_html__( 'This event or offer has concluded.', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cd_expire_type' => 'message' ],
			]
		);

		$this->add_control(
			'awea_cd_expire_link',
			[
				'label'       => esc_html__( 'Redirect URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_cd_expire_type' => 'redirect' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. TIME UNITS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_section_units',
			[
				'label' => esc_html__( 'Time Units', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cd_show_days',
			[
				'label'        => esc_html__( 'Show Days', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_cd_label_days',
			[
				'label'     => esc_html__( 'Days Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cd_show_days' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cd_show_hours',
			[
				'label'        => esc_html__( 'Show Hours', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cd_label_hours',
			[
				'label'     => esc_html__( 'Hours Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cd_show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cd_show_minutes',
			[
				'label'        => esc_html__( 'Show Minutes', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cd_label_minutes',
			[
				'label'     => esc_html__( 'Minutes Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Mins', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cd_show_minutes' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cd_show_seconds',
			[
				'label'        => esc_html__( 'Show Seconds', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cd_label_seconds',
			[
				'label'     => esc_html__( 'Seconds Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Secs', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cd_show_seconds' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cd_leading_zero',
			[
				'label'        => esc_html__( 'Two-Digit Numbers (09 vs 9)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cd_show_separators',
			[
				'label'        => esc_html__( 'Show Separators', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_cd_sep_char',
			[
				'label'     => esc_html__( 'Separator Symbol', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => ':',
				'options'   => [
					':' => esc_html__( 'Colon ( : )', 'awesome-widgets-elementor' ),
					'/' => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'•' => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'—' => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_cd_show_separators' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cd_sep_blink',
			[
				'label'        => esc_html__( 'Pulse Separators', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'awea-cd-blink-',
				'condition'    => [ 'awea_cd_show_separators' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. LAYOUT & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_section_layout',
			[
				'label' => esc_html__( 'Layout & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cd_box_style',
			[
				'label'        => esc_html__( 'Box Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'card',
				'options'      => [
					'card'    => esc_html__( 'Bordered Card', 'awesome-widgets-elementor' ),
					'tinted'  => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'minimal' => esc_html__( 'Clean (No Box)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cd-style-',
			]
		);

		$this->add_control(
			'awea_cd_hover_motion',
			[
				'label'        => esc_html__( 'Box Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cd-motion-',
			]
		);

		$this->add_control(
			'awea_cd_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'          => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-always'    => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'top-hover'     => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'bottom-always' => esc_html__( 'Bottom Line (Always Show)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cd-bar-',
				'condition'    => [ 'awea_cd_box_style!' => 'minimal' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. NUMBER BOXES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_style_cells',
			[
				'label' => esc_html__( 'Number Boxes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cd_cells_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-timer-row' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cd_cell_direction',
			[
				'label'     => esc_html__( 'Content Order', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'column',
				'options'   => [
					'column'         => esc_html__( 'Numbers Above Label', 'awesome-widgets-elementor' ),
					'column-reverse' => esc_html__( 'Label Above Numbers', 'awesome-widgets-elementor' ),
					'row'            => esc_html__( 'Side by Side', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cd_cells_gap',
			[
				'label'      => esc_html__( 'Space Between Boxes', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 50 ],
					'rem' => [ 'min' => 0, 'max' => 4 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timer-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cd_cell_min_width',
			[
				'label'      => esc_html__( 'Minimum Box Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 60, 'max' => 280 ],
					'%'  => [ 'min' => 15, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cd_cell_max_width',
			[
				'label'      => esc_html__( 'Maximum Box Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 400 ],
					'%'  => [ 'min' => 20, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 220 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cd_cell_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '28',
					'right'    => '20',
					'bottom'   => '24',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cd_cell_radius',
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
					'{{WRAPPER}} .awea-time-cell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cd_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [
					'awea_cd_box_style!' => 'minimal',
					'awea_cd_accent_bar!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-cd-accent-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cd_cell_tabs' );

		$this->start_controls_tab(
			'awea_cd_cell_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cd_cell_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cd_cell_border',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cd_cell_shadow',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cd_cell_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cd_cell_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-time-cell:hover',
			]
		);

		$this->add_control(
			'awea_cd_cell_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cd_cell_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-time-cell:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. NUMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_style_digits',
			[
				'label' => esc_html__( 'Numbers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cd_digit_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-digit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cd_digit_typo',
				'selector' => '{{WRAPPER}} .awea-digit',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_cd_digit_shadow',
				'selector' => '{{WRAPPER}} .awea-digit',
			]
		);

		$this->add_responsive_control(
			'awea_cd_digit_space',
			[
				'label'      => esc_html__( 'Space Between Number & Label', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. UNIT LABELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_style_labels',
			[
				'label' => esc_html__( 'Unit Labels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cd_unit_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cd_unit_typo',
				'selector' => '{{WRAPPER}} .awea-unit',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. SEPARATORS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_style_separators',
			[
				'label'     => esc_html__( 'Separators', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cd_show_separators' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_cd_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-colon-sep' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cd_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-colon-sep' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. EXPIRED BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cd_style_expired',
			[
				'label'     => esc_html__( 'Ended Message Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cd_expire_type' => 'message' ],
			]
		);

		$this->add_responsive_control(
			'awea_cd_expired_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-countdown-expired' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_cd_expired_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-countdown-expired' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cd_expired_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-countdown-expired',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cd_expired_typo',
				'selector' => '{{WRAPPER}} .awea-countdown-expired',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cd_expired_border',
				'selector' => '{{WRAPPER}} .awea-countdown-expired',
			]
		);

		$this->add_responsive_control(
			'awea_cd_expired_radius',
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
					'{{WRAPPER}} .awea-countdown-expired' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$due_date_raw = ! empty( $settings['awea_cd_due_date'] ) ? $settings['awea_cd_due_date'] : '';
		$widget_id    = $this->get_id();

		$site_timezone = wp_timezone();
		$datetime      = date_create( $due_date_raw, $site_timezone );
		$target_time   = $datetime ? $datetime->getTimestamp() : strtotime( '+1 month' );
		$current_time  = (int) wp_date( 'U' );
		$diff          = max( 0, $target_time - $current_time );

		$days    = (int) floor( $diff / 86400 );
		$hours   = (int) floor( ( $diff % 86400 ) / 3600 );
		$minutes = (int) floor( ( $diff % 3600 ) / 60 );
		$seconds = (int) floor( $diff % 60 );

		$leading_zero = 'yes' === ( $settings['awea_cd_leading_zero'] ?? 'yes' );
		$format       = $leading_zero ? '%02d' : '%d';

		$show_days    = 'yes' === ( $settings['awea_cd_show_days'] ?? 'no' );
		$show_hours   = 'yes' === ( $settings['awea_cd_show_hours'] ?? 'no' );
		$show_mins    = 'yes' === ( $settings['awea_cd_show_minutes'] ?? 'no' );
		$show_secs    = 'yes' === ( $settings['awea_cd_show_seconds'] ?? 'no' );
		$show_seps    = 'yes' === ( $settings['awea_cd_show_separators'] ?? 'no' );
		$sep_char     = ! empty( $settings['awea_cd_sep_char'] ) ? $settings['awea_cd_sep_char'] : ':';
		$expire_type  = $settings['awea_cd_expire_type'] ?? 'message';
		$raw_redirect = $settings['awea_cd_expire_link']['url'] ?? '';
		$redirect_url = $raw_redirect ? esc_url_raw( $raw_redirect, [ 'http', 'https' ] ) : '';

		$active_units = [];
		if ( $show_days ) {
			$active_units[] = 'days';
		}
		if ( $show_hours ) {
			$active_units[] = 'hours';
		}
		if ( $show_mins ) {
			$active_units[] = 'minutes';
		}
		if ( $show_secs ) {
			$active_units[] = 'seconds';
		}
		$last_unit = end( $active_units );
		?>
		<div class="awea-countdown-wrap"
			 id="awea-countdown-<?php echo esc_attr( $widget_id ); ?>"
			 data-target="<?php echo esc_attr( (string) $target_time ); ?>"
			 data-server="<?php echo esc_attr( (string) $current_time ); ?>"
			 data-pad="<?php echo $leading_zero ? '1' : '0'; ?>"
			 data-expire="<?php echo esc_attr( $expire_type ); ?>"
			 data-redirect="<?php echo esc_url( $redirect_url ); ?>">

			<div class="awea-timer-row <?php echo ( $diff <= 0 && 'message' === $expire_type ) ? 'awea-is-hidden' : ''; ?>">

				<?php if ( $show_days ) : ?>
					<div class="awea-time-cell awea-unit-days">
						<span class="awea-cd-accent-bar" aria-hidden="true"></span>
						<span class="awea-digit awea-val-days"><?php echo esc_html( sprintf( $format, $days ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_cd_label_days'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'days' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_hours ) : ?>
					<div class="awea-time-cell awea-unit-hours">
						<span class="awea-cd-accent-bar" aria-hidden="true"></span>
						<span class="awea-digit awea-val-hours"><?php echo esc_html( sprintf( $format, $hours ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_cd_label_hours'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'hours' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_mins ) : ?>
					<div class="awea-time-cell awea-unit-minutes">
						<span class="awea-cd-accent-bar" aria-hidden="true"></span>
						<span class="awea-digit awea-val-minutes"><?php echo esc_html( sprintf( $format, $minutes ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_cd_label_minutes'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'minutes' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_secs ) : ?>
					<div class="awea-time-cell awea-unit-seconds">
						<span class="awea-cd-accent-bar" aria-hidden="true"></span>
						<span class="awea-digit awea-val-seconds"><?php echo esc_html( sprintf( $format, $seconds ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_cd_label_seconds'] ?? '' ); ?></span>
					</div>
				<?php endif; ?>

			</div>

			<?php if ( 'message' === $expire_type ) : ?>
				<div class="awea-countdown-expired <?php echo ( $diff <= 0 ) ? 'awea-is-visible' : ''; ?>" aria-live="polite">
					<?php echo esc_html( $settings['awea_cd_expire_message'] ?? '' ); ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function initCountdown() {
				var el = document.getElementById('awea-countdown-<?php echo esc_js( $widget_id ); ?>');
				if (!el || el.dataset.aweaBound === '1') return;
				el.dataset.aweaBound = '1';

				var targetTs    = parseInt(el.getAttribute('data-target'), 10) || 0;
				var serverTs    = parseInt(el.getAttribute('data-server'), 10) || Math.floor(Date.now() / 1000);
				var usePad      = el.getAttribute('data-pad') === '1';
				var expireType  = el.getAttribute('data-expire') || 'none';
				var redirectUrl = el.getAttribute('data-redirect') || '';
				var clockOffset = serverTs - Math.floor(Date.now() / 1000);

				var timerRow   = el.querySelector('.awea-timer-row');
				var expiredBox = el.querySelector('.awea-countdown-expired');
				var daysEl     = el.querySelector('.awea-val-days');
				var hoursEl    = el.querySelector('.awea-val-hours');
				var minsEl     = el.querySelector('.awea-val-minutes');
				var secsEl     = el.querySelector('.awea-val-seconds');

				function formatNum(n) {
					return (usePad && n < 10) ? '0' + n : String(n);
				}

				function handleExpiry() {
					if (expireType === 'message') {
						if (timerRow) timerRow.classList.add('awea-is-hidden');
						if (expiredBox) expiredBox.classList.add('awea-is-visible');
					} else if (expireType === 'redirect' && redirectUrl) {
						var isEditor = document.body.classList.contains('elementor-editor-active');
						if (!isEditor && /^https?:\/\//i.test(redirectUrl)) {
							window.location.assign(redirectUrl);
						}
					}
				}

				var interval = setInterval(function() {
					if (!document.body.contains(el)) {
						clearInterval(interval);
						return;
					}
					update();
				}, 1000);

				function update() {
					var nowTs = Math.floor(Date.now() / 1000) + clockOffset;
					var diff  = Math.max(0, targetTs - nowTs);

					var d = Math.floor(diff / 86400);
					var h = Math.floor((diff % 86400) / 3600);
					var m = Math.floor((diff % 3600) / 60);
					var s = Math.floor(diff % 60);

					if (daysEl)  daysEl.textContent  = formatNum(d);
					if (hoursEl) hoursEl.textContent = formatNum(h);
					if (minsEl)  minsEl.textContent  = formatNum(m);
					if (secsEl)  secsEl.textContent  = formatNum(s);

					if (diff <= 0) {
						clearInterval(interval);
						handleExpiry();
					}
				}

				update();
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initCountdown);
			} else {
				initCountdown();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea_countdown.default', initCountdown);
			}
		})();
		</script>
		<?php
	}
}