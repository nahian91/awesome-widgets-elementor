<?php
/**
 * Awesome Business Hours Widget.
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

class Widget_Awesome_Business_Hours extends Widget_Base {

	public function get_name() {
		return 'awesome-business-hours';
	}

	public function get_title() {
		return esc_html__( 'Business Hours', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-clock-o';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'business hours', 'schedule', 'opening hours', 'timetable', 'open now', 'clock' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. HEADINGS & STATUS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_section_content',
			[
				'label' => esc_html__( 'Headings & Status', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bh_show_status',
			[
				'label'        => esc_html__( 'Show Live Open/Closed Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_bh_open_text',
			[
				'label'     => esc_html__( 'Open Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Open Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_closed_text',
			[
				'label'     => esc_html__( 'Closed Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Closed Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'OPENING HOURS', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_bh_title',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( "We're ready to create.", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_bh_title_tag',
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
			'awea_bh_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Visit our studio or connect directly with our team during operational business hours.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_bh_timezone_note',
			[
				'label'       => esc_html__( 'Bottom Timezone Note', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Local Time • EST (UTC-5)', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. PHONE & CONTACT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_section_phone',
			[
				'label' => esc_html__( 'Phone & Contact', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bh_phone_show',
			[
				'label'        => esc_html__( 'Show Phone Block', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_bh_phone_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_bh_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_phone_label',
			[
				'label'     => esc_html__( 'Small Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Support Line', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_bh_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_phone_num',
			[
				'label'     => esc_html__( 'Phone Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 456-7890',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_bh_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_phone_url',
			[
				'label'     => esc_html__( 'Click Link URL', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => 'tel:+18004567890' ],
				'condition' => [ 'awea_bh_phone_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. WEEKLY SCHEDULE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_section_schedule',
			[
				'label' => esc_html__( 'Weekly Schedule', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_bh_day',
			[
				'label'   => esc_html__( 'Day of Week', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'Monday',
				'options' => [
					'Monday'    => esc_html__( 'Monday', 'awesome-widgets-elementor' ),
					'Tuesday'   => esc_html__( 'Tuesday', 'awesome-widgets-elementor' ),
					'Wednesday' => esc_html__( 'Wednesday', 'awesome-widgets-elementor' ),
					'Thursday'  => esc_html__( 'Thursday', 'awesome-widgets-elementor' ),
					'Friday'    => esc_html__( 'Friday', 'awesome-widgets-elementor' ),
					'Saturday'  => esc_html__( 'Saturday', 'awesome-widgets-elementor' ),
					'Sunday'    => esc_html__( 'Sunday', 'awesome-widgets-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'awea_bh_closed',
			[
				'label'        => esc_html__( 'Closed All Day', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_bh_hours',
			[
				'label'       => esc_html__( 'Display Hours', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00 AM — 06:00 PM',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_bh_closed!' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_bh_closed_label',
			[
				'label'       => esc_html__( 'Closed Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CLOSED', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_bh_closed' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_bh_open_24',
			[
				'label'       => esc_html__( 'Opens At (24h HH:MM)', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Used to detect live Open/Closed status.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00',
				'placeholder' => '09:00',
				'condition'   => [ 'awea_bh_closed!' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_bh_close_24',
			[
				'label'       => esc_html__( 'Closes At (24h HH:MM)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '18:00',
				'placeholder' => '18:00',
				'condition'   => [ 'awea_bh_closed!' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_schedule',
			[
				'label'       => esc_html__( 'Days List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_bh_day }}} — {{{ awea_bh_closed === "yes" ? (awea_bh_closed_label || "CLOSED") : awea_bh_hours }}}',
				'default'     => [
					[ 'awea_bh_day' => 'Monday', 'awea_bh_hours' => '09:00 AM — 06:00 PM', 'awea_bh_open_24' => '09:00', 'awea_bh_close_24' => '18:00' ],
					[ 'awea_bh_day' => 'Tuesday', 'awea_bh_hours' => '09:00 AM — 06:00 PM', 'awea_bh_open_24' => '09:00', 'awea_bh_close_24' => '18:00' ],
					[ 'awea_bh_day' => 'Wednesday', 'awea_bh_hours' => '09:00 AM — 06:00 PM', 'awea_bh_open_24' => '09:00', 'awea_bh_close_24' => '18:00' ],
					[ 'awea_bh_day' => 'Thursday', 'awea_bh_hours' => '09:00 AM — 06:00 PM', 'awea_bh_open_24' => '09:00', 'awea_bh_close_24' => '18:00' ],
					[ 'awea_bh_day' => 'Friday', 'awea_bh_hours' => '09:00 AM — 06:00 PM', 'awea_bh_open_24' => '09:00', 'awea_bh_close_24' => '18:00' ],
					[ 'awea_bh_day' => 'Saturday', 'awea_bh_hours' => '10:00 AM — 04:00 PM', 'awea_bh_open_24' => '10:00', 'awea_bh_close_24' => '16:00' ],
					[ 'awea_bh_day' => 'Sunday', 'awea_bh_closed' => 'yes', 'awea_bh_closed_label' => 'CLOSED' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. LAYOUT & THEME
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_section_layout',
			[
				'label' => esc_html__( 'Layout & Theme', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_bh_layout_mode',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'split',
				'options'      => [
					'split'   => esc_html__( 'Side by Side (Info Left, Hours Right)', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Stacked (Top & Bottom)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bh-mode-',
			]
		);

		$this->add_control(
			'awea_bh_surface_theme',
			[
				'label'        => esc_html__( 'Color Theme', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'auto',
				'options'      => [
					'auto'  => esc_html__( 'Theme Colors (Auto)', 'awesome-widgets-elementor' ),
					'dark'  => esc_html__( 'Dark Slate', 'awesome-widgets-elementor' ),
					'light' => esc_html__( 'Clean Light', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bh-theme-',
			]
		);

		$this->add_control(
			'awea_bh_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'          => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-always'    => esc_html__( 'Top Line', 'awesome-widgets-elementor' ),
					'bottom-always' => esc_html__( 'Bottom Line', 'awesome-widgets-elementor' ),
					'left-always'   => esc_html__( 'Left Line', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bh-bar-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_bh_card_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-bh-card',
			]
		);

		$this->add_control(
			'awea_bh_right_bg',
			[
				'label'     => esc_html__( 'Hours Panel Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-right' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_panel_divider_color',
			[
				'label'     => esc_html__( 'Panel Divider Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-right' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_bh_card_border',
				'selector' => '{{WRAPPER}} .awea-bh-card',
			]
		);

		$this->add_responsive_control(
			'awea_bh_card_radius',
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
					'{{WRAPPER}} .awea-bh-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_bh_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '44',
					'right'    => '44',
					'bottom'   => '44',
					'left'     => '44',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-bh-left, {{WRAPPER}} .awea-bh-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_bh_card_shadow',
				'selector' => '{{WRAPPER}} .awea-bh-card',
			]
		);

		$this->add_control(
			'awea_bh_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_bh_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-accent-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STATUS & HEADINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_style_text',
			[
				'label' => esc_html__( 'Status & Headings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_bh_badge_heading',
			[
				'label'     => esc_html__( 'Status Pill', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_bh_badge_typo',
				'selector'  => '{{WRAPPER}} .awea-bh-badge',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_badge_open_color',
			[
				'label'     => esc_html__( 'Open Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-open' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_badge_open_bg',
			[
				'label'     => esc_html__( 'Open Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-open' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_badge_closed_color',
			[
				'label'     => esc_html__( 'Closed Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-closed' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_badge_closed_bg',
			[
				'label'     => esc_html__( 'Closed Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-closed' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_bh_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_subtitle_heading',
			[
				'label'     => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_bh_subtitle!' => '' ],
			]
		);

		$this->add_control(
			'awea_bh_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_bh_subtitle!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_bh_subtitle_typo',
				'selector'  => '{{WRAPPER}} .awea-bh-subtitle',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_bh_subtitle!' => '' ],
			]
		);

		$this->add_control(
			'awea_bh_title_heading',
			[
				'label'     => esc_html__( 'Main Heading & Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_bh_title_color',
			[
				'label'     => esc_html__( 'Heading Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_title_typo',
				'selector' => '{{WRAPPER}} .awea-bh-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_bh_title_shadow',
				'selector' => '{{WRAPPER}} .awea-bh-title',
			]
		);

		$this->add_control(
			'awea_bh_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_desc_typo',
				'selector' => '{{WRAPPER}} .awea-bh-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. PHONE BLOCK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_style_phone',
			[
				'label'     => esc_html__( 'Phone Block', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_bh_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_bh_phone_label_color',
			[
				'label'     => esc_html__( 'Small Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_phone_label_typo',
				'label'    => esc_html__( 'Small Label Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-phone-label',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_bh_phone_color',
			[
				'label'     => esc_html__( 'Phone Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_phone_typo',
				'label'    => esc_html__( 'Phone Number Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-phone-num',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_bh_phone_ico_bg',
			[
				'label'     => esc_html__( 'Icon Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_phone_ico_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-ico'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-bh-phone-ico svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. SCHEDULE ROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_bh_style_schedule',
			[
				'label' => esc_html__( 'Schedule Rows', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_bh_row_pad',
			[
				'label'      => esc_html__( 'Row Vertical Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 15 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bh-row' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_line_color',
			[
				'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_day_typo',
				'label'    => esc_html__( 'Day Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-day',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_bh_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bh_hours_typo',
				'label'    => esc_html__( 'Hours Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-time',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_bh_hours_color',
			[
				'label'     => esc_html__( 'Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_today_color',
			[
				'label'     => esc_html__( 'Today Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-today'             => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_today_time_color',
			[
				'label'     => esc_html__( 'Today Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_closed_color',
			[
				'label'     => esc_html__( 'Closed Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-closed .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bh_tz_color',
			[
				'label'     => esc_html__( 'Timezone Note Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-bh-tz' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Evaluate whether the business is currently open (supports overnight ranges like 18:00 - 02:00).
	 */
	private function is_time_in_range( $now, $open, $close ) {
		if ( empty( $open ) || empty( $close ) ) {
			return true;
		}
		if ( $close < $open ) {
			return ( $now >= $open || $now <= $close );
		}
		return ( $now >= $open && $now <= $close );
	}

	private function calculate_is_open_now( $schedule_list ) {
		if ( empty( $schedule_list ) ) {
			return false;
		}

		$current_day  = wp_date( 'l' );
		$current_time = wp_date( 'H:i' );

		foreach ( $schedule_list as $item ) {
			$day_name = trim( $item['awea_bh_day'] ?? '' );
			if ( 0 === strcasecmp( $day_name, $current_day ) ) {
				if ( 'yes' === ( $item['awea_bh_closed'] ?? '' ) ) {
					return false;
				}
				$open_time  = trim( $item['awea_bh_open_24'] ?? '' );
				$close_time = trim( $item['awea_bh_close_24'] ?? '' );
				return $this->is_time_in_range( $current_time, $open_time, $close_time );
			}
		}

		return false;
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$schedule     = $settings['awea_bh_schedule'] ?? [];
		$current_day  = wp_date( 'l' );
		$is_open_now  = $this->calculate_is_open_now( $schedule );
		$show_status  = 'yes' === ( $settings['awea_bh_show_status'] ?? 'yes' );
		$open_label   = ! empty( $settings['awea_bh_open_text'] ) ? $settings['awea_bh_open_text'] : esc_html__( 'Open Now', 'awesome-widgets-elementor' );
		$closed_label = ! empty( $settings['awea_bh_closed_text'] ) ? $settings['awea_bh_closed_text'] : esc_html__( 'Closed Now', 'awesome-widgets-elementor' );
		$subtitle     = $settings['awea_bh_subtitle'] ?? '';
		$tz_note      = $settings['awea_bh_timezone_note'] ?? '';
		$show_phone   = 'yes' === ( $settings['awea_bh_phone_show'] ?? 'no' );
		$phone_num    = $settings['awea_bh_phone_num'] ?? '';
		$phone_link   = $settings['awea_bh_phone_url'] ?? [];
		$has_p_icon   = ! empty( $settings['awea_bh_phone_icon']['value'] );
		$title_tag    = Utils::validate_html_tag( $settings['awea_bh_title_tag'] ?? 'h2' );
		$widget_id    = $this->get_id();
		$wp_timezone  = wp_timezone_string();

		$this->add_inline_editing_attributes( 'awea_bh_subtitle', 'none' );
		$this->add_inline_editing_attributes( 'awea_bh_title', 'none' );
		$this->add_inline_editing_attributes( 'awea_bh_desc', 'basic' );

		$this->add_render_attribute( 'awea_bh_subtitle', 'class', 'awea-bh-subtitle' );
		$this->add_render_attribute( 'awea_bh_title', 'class', 'awea-bh-title' );
		$this->add_render_attribute( 'awea_bh_desc', 'class', 'awea-bh-desc' );

		if ( $show_phone && ! empty( $phone_num ) ) {
			if ( empty( $phone_link['url'] ) ) {
				$clean_tel         = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_link['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'awea_bh_phone_call', $phone_link );
		}
		?>
		<div class="awea-bh-root" id="awea-bh-<?php echo esc_attr( $widget_id ); ?>"
			 data-open-label="<?php echo esc_attr( $open_label ); ?>"
			 data-closed-label="<?php echo esc_attr( $closed_label ); ?>"
			 data-timezone="<?php echo esc_attr( $wp_timezone ); ?>">
			<div class="awea-bh-card">
				<span class="awea-bh-accent-bar" aria-hidden="true"></span>

				<!-- Left Status Panel -->
				<div class="awea-bh-left">
					<?php if ( $show_status ) : ?>
						<div class="awea-bh-badge <?php echo $is_open_now ? 'is-open' : 'is-closed'; ?>">
							<span class="awea-bh-pulse" aria-hidden="true"></span>
							<span class="awea-bh-badge-text"><?php echo esc_html( $is_open_now ? $open_label : $closed_label ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $subtitle ) ) : ?>
						<span <?php $this->print_render_attribute_string( 'awea_bh_subtitle' ); ?>>
							<?php echo esc_html( $subtitle ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_bh_title'] ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( 'awea_bh_title' ); ?>>
							<?php echo esc_html( $settings['awea_bh_title'] ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_bh_desc'] ) ) : ?>
						<p <?php $this->print_render_attribute_string( 'awea_bh_desc' ); ?>>
							<?php echo wp_kses_post( $settings['awea_bh_desc'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
						<div class="awea-bh-phone">
							<?php if ( ! empty( $settings['awea_bh_phone_label'] ) ) : ?>
								<span class="awea-bh-phone-label"><?php echo esc_html( $settings['awea_bh_phone_label'] ); ?></span>
							<?php endif; ?>

							<a class="awea-bh-phone-link" <?php $this->print_render_attribute_string( 'awea_bh_phone_call' ); ?>>
								<?php if ( $has_p_icon ) : ?>
									<span class="awea-bh-phone-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_bh_phone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span class="awea-bh-phone-num"><?php echo esc_html( $phone_num ); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right Weekly Schedule -->
				<div class="awea-bh-right">
					<?php if ( ! empty( $schedule ) ) : ?>
						<div class="awea-bh-list">
							<?php foreach ( $schedule as $item ) :
								$day_name  = trim( $item['awea_bh_day'] ?? '' );
								$is_closed = 'yes' === ( $item['awea_bh_closed'] ?? '' );
								$is_today  = ( 0 === strcasecmp( $day_name, $current_day ) );
								$time_str  = $is_closed
									? ( ! empty( $item['awea_bh_closed_label'] ) ? $item['awea_bh_closed_label'] : esc_html__( 'CLOSED', 'awesome-widgets-elementor' ) )
									: ( $item['awea_bh_hours'] ?? '' );

								$row_classes = [ 'awea-bh-row' ];
								if ( $is_today ) {
									$row_classes[] = 'is-today';
								}
								if ( $is_closed ) {
									$row_classes[] = 'is-closed';
								}
								?>
								<div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>"
									 data-day="<?php echo esc_attr( $day_name ); ?>"
									 data-closed="<?php echo $is_closed ? '1' : '0'; ?>"
									 data-open="<?php echo esc_attr( trim( $item['awea_bh_open_24'] ?? '' ) ); ?>"
									 data-close="<?php echo esc_attr( trim( $item['awea_bh_close_24'] ?? '' ) ); ?>">
									<div class="awea-bh-day-wrap">
										<span class="awea-bh-dot" aria-hidden="true"></span>
										<span class="awea-bh-day"><?php echo esc_html( $day_name ); ?></span>
									</div>
									<span class="awea-bh-time"><?php echo esc_html( $time_str ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $tz_note ) ) : ?>
						<div class="awea-bh-tz"><?php echo esc_html( $tz_note ); ?></div>
					<?php endif; ?>
				</div>

			</div>
		</div>

		<script>
		(function() {
			function getSiteDateParts(tz) {
				var now = new Date();
				try {
					if (tz && tz.indexOf('/') !== -1) {
						var dayFmt = new Intl.DateTimeFormat('en-US', { timeZone: tz, weekday: 'long' });
						var timeFmt = new Intl.DateTimeFormat('en-GB', { timeZone: tz, hour: '2-digit', minute: '2-digit', hour12: false });
						return {
							dayName: dayFmt.format(now),
							timeStr: timeFmt.format(now)
						};
					}
				} catch (e) {}
				var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				var hh = String(now.getHours()).padStart(2, '0');
				var mm = String(now.getMinutes()).padStart(2, '0');
				return { dayName: days[now.getDay()], timeStr: hh + ':' + mm };
			}

			function syncBusinessHours() {
				var root = document.getElementById('awea-bh-<?php echo esc_js( $widget_id ); ?>');
				if (!root) return;

				var tz = root.getAttribute('data-timezone') || '';
				var parts = getSiteDateParts(tz);
				var todayName = parts.dayName;
				var nowStr = parts.timeStr;

				var isOpen = false;
				var rows = root.querySelectorAll('.awea-bh-row');
				rows.forEach(function(row) {
					var day = row.getAttribute('data-day');
					if (day && day.toLowerCase() === todayName.toLowerCase()) {
						row.classList.add('is-today');
						var closed = row.getAttribute('data-closed') === '1';
						var open24 = row.getAttribute('data-open');
						var close24 = row.getAttribute('data-close');
						if (!closed) {
							if (!open24 || !close24) {
								isOpen = true;
							} else if (close24 < open24) {
								isOpen = (nowStr >= open24 || nowStr <= close24);
							} else {
								isOpen = (nowStr >= open24 && nowStr <= close24);
							}
						}
					} else {
						row.classList.remove('is-today');
					}
				});

				var badge = root.querySelector('.awea-bh-badge');
				var badgeText = root.querySelector('.awea-bh-badge-text');
				if (badge && badgeText) {
					badge.classList.toggle('is-open', isOpen);
					badge.classList.toggle('is-closed', !isOpen);
					badgeText.textContent = isOpen
						? root.getAttribute('data-open-label')
						: root.getAttribute('data-closed-label');
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', syncBusinessHours);
			} else {
				syncBusinessHours();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-business-hours.default', syncBusinessHours);
			}
		})();
		</script>
		<?php
	}
}