<?php
/**
 * Awesome Contact Info Widget.
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
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Contact_Info extends Widget_Base {

	public function get_name() {
		return 'awea-contact-info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-unread';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'contact', 'info', 'directory', 'phone', 'email', 'address', 'support' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. SECTION HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_section_header',
			[
				'label' => esc_html__( 'Section Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ci_header_show',
			[
				'label'        => esc_html__( 'Show Section Header', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_ci_eyebrow',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'CONTACT US', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_ci_header_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ci_title',
			[
				'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get In Touch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_ci_header_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ci_subtitle',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'Reach our team directly via email, phone, or studio visit.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_ci_header_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ci_title_tag',
			[
				'label'     => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
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
				'condition' => [
					'awea_ci_header_show' => 'yes',
					'awea_ci_title!'      => '',
				],
			]
		);

		$this->add_control(
			'awea_ci_accent_bar',
			[
				'label'        => esc_html__( 'Side Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_ci_header_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CONTACT CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_section_items',
			[
				'label' => esc_html__( 'Contact Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_ci_item_tabs' );

		// --- TAB 1: DETAILS ---
		$repeater->start_controls_tab(
			'awea_ci_tab_details',
			[ 'label' => esc_html__( 'Details', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ci_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_ci_label',
			[
				'label'       => esc_html__( 'Small Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Direct Email', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ci_value',
			[
				'label'       => esc_html__( 'Contact Info', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'hello@example.com', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ci_subtext',
			[
				'label'       => esc_html__( 'Extra Note', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Replies within 2 hours', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: ACTION ---
		$repeater->start_controls_tab(
			'awea_ci_tab_action',
			[ 'label' => esc_html__( 'Action', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ci_link',
			[
				'label'       => esc_html__( 'Click Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'mailto:hello@example.com',
			]
		);

		$repeater->add_control(
			'awea_ci_copy',
			[
				'label'        => esc_html__( 'Allow One-Click Copy', 'awesome-widgets-elementor' ),
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
			'awea_ci_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ci_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Card', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_ci_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-ci-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ci_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ci_item_border',
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
			'awea_ci_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_ci_label }}}: {{{ awea_ci_value }}}',
				'default'     => [
					[
						'awea_ci_label'   => esc_html__( 'Direct Inquiries', 'awesome-widgets-elementor' ),
						'awea_ci_value'   => 'support@devnahian.com',
						'awea_ci_subtext' => esc_html__( 'Average response under 2 hrs', 'awesome-widgets-elementor' ),
						'awea_ci_icon'    => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
						'awea_ci_link'    => [ 'url' => 'mailto:support@devnahian.com' ],
						'awea_ci_copy'    => 'yes',
					],
					[
						'awea_ci_label'   => esc_html__( 'Telephone Support', 'awesome-widgets-elementor' ),
						'awea_ci_value'   => '+1 (800) 456-7890',
						'awea_ci_subtext' => esc_html__( 'Mon–Fri • 9:00 AM – 6:00 PM', 'awesome-widgets-elementor' ),
						'awea_ci_icon'    => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
						'awea_ci_link'    => [ 'url' => 'tel:+18004567890' ],
						'awea_ci_copy'    => 'yes',
					],
					[
						'awea_ci_label'   => esc_html__( 'Main Headquarters', 'awesome-widgets-elementor' ),
						'awea_ci_value'   => '100 Montgomery St, San Francisco, CA',
						'awea_ci_subtext' => esc_html__( 'Suite 400 • Financial District', 'awesome-widgets-elementor' ),
						'awea_ci_icon'    => [ 'value' => 'fas fa-map-marker-alt', 'library' => 'fa-solid' ],
						'awea_ci_copy'    => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. GRID & OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_section_layout',
			[
				'label' => esc_html__( 'Grid & Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ci_card_layout',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => [
					'horizontal' => esc_html__( 'Side by Side (Icon Left)', 'awesome-widgets-elementor' ),
					'vertical'   => esc_html__( 'Stacked (Icon Top)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ci-dir-',
			]
		);

		$this->add_control(
			'awea_ci_icon_style',
			[
				'label'        => esc_html__( 'Icon Box Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'soft',
				'options'      => [
					'soft'     => esc_html__( 'Soft Tinted Box', 'awesome-widgets-elementor' ),
					'solid'    => esc_html__( 'Solid Filled Box', 'awesome-widgets-elementor' ),
					'outlined' => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ci-icon-',
			]
		);

		$this->add_responsive_control(
			'awea_ci_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-ci-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 60 ],
					'rem' => [ 'min' => 0, 'max' => 4 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 60 ],
					'rem' => [ 'min' => 0, 'max' => 4 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ci-motion-',
			]
		);

		$this->add_control(
			'awea_ci_show_arrow',
			[
				'label'        => esc_html__( 'Show Link Arrow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_ci_copied_text',
			[
				'label'   => esc_html__( 'Copied Message Text', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Copied', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. SECTION HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_style_header',
			[
				'label'     => esc_html__( 'Section Header', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_ci_header_show' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_ci_header_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_eyebrow_heading',
			[
				'label'     => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_ci_eyebrow!' => '' ],
			]
		);

		$this->add_control(
			'awea_ci_eyebrow_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ci_eyebrow!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_ci_eyebrow_typo',
				'selector'  => '{{WRAPPER}} .awea-ci-eyebrow',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_ci_eyebrow!' => '' ],
			]
		);

		$this->add_control(
			'awea_ci_title_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ci_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ci_title_typo',
				'selector' => '{{WRAPPER}} .awea-ci-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_ci_title_shadow',
				'selector' => '{{WRAPPER}} .awea-ci-title',
			]
		);

		$this->add_control(
			'awea_ci_subtitle_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ci_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ci_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-ci-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_ci_bar_color',
			[
				'label'     => esc_html__( 'Side Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ci_accent_bar' => 'yes' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-header' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_header_space',
			[
				'label'      => esc_html__( 'Space Below Header', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. CONTACT CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_style_cards',
			[
				'label' => esc_html__( 'Contact Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ci_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '22',
					'bottom'   => '20',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_card_radius',
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
					'{{WRAPPER}} .awea-ci-row' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ci_card_tabs' );

		$this->start_controls_tab(
			'awea_ci_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ci_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ci-row',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_ci_card_border',
				'selector'       => '{{WRAPPER}} .awea-ci-row',
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
				'name'     => 'awea_ci_card_shadow',
				'selector' => '{{WRAPPER}} .awea-ci-row',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ci_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ci_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ci-row:hover',
			]
		);

		$this->add_control(
			'awea_ci_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover' => 'border-color: var(--awea-ci-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ci_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-ci-row:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_style_icon',
			[
				'label' => esc_html__( 'Icon Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ci_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-ci-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_icon_gap',
			[
				'label'      => esc_html__( 'Space Next to Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ci_icon_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ci_icon_tabs' );

		$this->start_controls_tab(
			'awea_ci_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ci_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-icon'     => 'color: var(--awea-ci-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-ci-icon svg' => 'fill: var(--awea-ci-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ci_icon_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ci-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ci-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ci_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ci_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon' => 'background-color: var(--awea-ci-item-accent, {{VALUE}}); border-color: var(--awea-ci-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. CARD TEXT & COPY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ci_style_text',
			[
				'label' => esc_html__( 'Card Text & Actions', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ci_label_heading',
			[
				'label' => esc_html__( 'Small Label', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ci_label_typo',
				'selector' => '{{WRAPPER}} .awea-ci-label',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_ci_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_value_heading',
			[
				'label'     => esc_html__( 'Contact Info', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ci_value_typo',
				'selector' => '{{WRAPPER}} .awea-ci-value',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_ci_value_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_value_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-value' => 'color: var(--awea-ci-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ci_subtext_heading',
			[
				'label'     => esc_html__( 'Extra Note', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ci_subtext_typo',
				'selector' => '{{WRAPPER}} .awea-ci-subtext',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_ci_subtext_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_copy_btn_heading',
			[
				'label'     => esc_html__( 'Copy & Arrow Buttons', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ci_copy_btn_color',
			[
				'label'     => esc_html__( 'Button Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-copy-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ci_copy_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ci-copy-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$header_show = 'yes' === ( $settings['awea_ci_header_show'] ?? 'yes' );
		$eyebrow     = $settings['awea_ci_eyebrow'] ?? '';
		$title       = $settings['awea_ci_title'] ?? '';
		$subtitle    = $settings['awea_ci_subtitle'] ?? '';
		$title_tag   = Utils::validate_html_tag( $settings['awea_ci_title_tag'] ?? 'h2' );
		$accent_bar  = 'yes' === ( $settings['awea_ci_accent_bar'] ?? 'no' );
		$items       = $settings['awea_ci_items'] ?? [];
		$show_arrow  = 'yes' === ( $settings['awea_ci_show_arrow'] ?? 'no' );
		$copied_text = ! empty( $settings['awea_ci_copied_text'] ) ? $settings['awea_ci_copied_text'] : esc_html__( 'Copied', 'awesome-widgets-elementor' );
		$widget_id   = $this->get_id();

		$this->add_inline_editing_attributes( 'awea_ci_eyebrow', 'none' );
		$this->add_inline_editing_attributes( 'awea_ci_title', 'none' );
		$this->add_inline_editing_attributes( 'awea_ci_subtitle', 'basic' );

		$this->add_render_attribute( 'awea_ci_eyebrow', 'class', 'awea-ci-eyebrow' );
		$this->add_render_attribute( 'awea_ci_title', 'class', 'awea-ci-title' );
		$this->add_render_attribute( 'awea_ci_subtitle', 'class', 'awea-ci-subtitle' );

		$header_classes = [ 'awea-ci-header' ];
		if ( ! $accent_bar ) {
			$header_classes[] = 'awea-ci-no-bar';
		}
		?>
		<div class="awea-ci-wrap" id="awea-ci-<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( $header_show && ( ! empty( $eyebrow ) || ! empty( $title ) || ! empty( $subtitle ) ) ) : ?>
				<header class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<span <?php $this->print_render_attribute_string( 'awea_ci_eyebrow' ); ?>>
							<?php echo esc_html( $eyebrow ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( 'awea_ci_title' ); ?>>
							<?php echo esc_html( $title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $subtitle ) ) : ?>
						<p <?php $this->print_render_attribute_string( 'awea_ci_subtitle' ); ?>>
							<?php echo wp_kses_post( $subtitle ); ?>
						</p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<div class="awea-ci-grid">
					<?php foreach ( $items as $index => $item ) :
						$id       = $item['_id'] ?? $index;
						$row_key  = 'awea_ci_row_' . $id;
						$link_key = 'awea_ci_link_' . $id;

						$label    = $item['awea_ci_label'] ?? '';
						$val      = $item['awea_ci_value'] ?? '';
						$subtext  = $item['awea_ci_subtext'] ?? '';
						$can_copy = 'yes' === ( $item['awea_ci_copy'] ?? '' );
						$featured = 'yes' === ( $item['awea_ci_item_featured'] ?? '' );
						$has_url  = ! empty( $item['awea_ci_link']['url'] );

						$label_setting_key   = $this->get_repeater_setting_key( 'awea_ci_label', 'awea_ci_items', $index );
						$value_setting_key   = $this->get_repeater_setting_key( 'awea_ci_value', 'awea_ci_items', $index );
						$subtext_setting_key = $this->get_repeater_setting_key( 'awea_ci_subtext', 'awea_ci_items', $index );

						$this->add_inline_editing_attributes( $label_setting_key, 'none' );
						$this->add_inline_editing_attributes( $value_setting_key, 'none' );
						$this->add_inline_editing_attributes( $subtext_setting_key, 'none' );

						$this->add_render_attribute( $label_setting_key, 'class', 'awea-ci-label' );
						$this->add_render_attribute( $value_setting_key, 'class', 'awea-ci-value' );
						$this->add_render_attribute( $subtext_setting_key, 'class', 'awea-ci-subtext' );

						$row_classes = [
							'awea-ci-row',
							'elementor-repeater-item-' . esc_attr( $id ),
						];
						if ( $has_url ) {
							$row_classes[] = 'awea-ci-has-link';
						}
						if ( $can_copy && ! $has_url ) {
							$row_classes[] = 'awea-ci-row-copy';
						}
						if ( $featured ) {
							$row_classes[] = 'awea-ci-featured';
						}

						$this->add_render_attribute( $row_key, 'class', $row_classes );

						if ( $can_copy && ! empty( $val ) ) {
							$this->add_render_attribute( $row_key, 'data-copy-text', esc_attr( $val ) );
							if ( ! $has_url ) {
								$this->add_render_attribute( $row_key, 'role', 'button' );
								$this->add_render_attribute( $row_key, 'tabindex', '0' );
							}
						}

						if ( $has_url ) {
							$this->add_link_attributes( $link_key, $item['awea_ci_link'] );
							$this->add_render_attribute( $link_key, 'class', 'awea-ci-cover-link' );
							$this->add_render_attribute( $link_key, 'aria-label', esc_attr( trim( $label . ': ' . $val, ': ' ) ) );
						}
						?>
						<div <?php $this->print_render_attribute_string( $row_key ); ?>>

							<?php if ( $has_url ) : ?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>></a>
							<?php endif; ?>

							<?php if ( ! empty( $item['awea_ci_icon']['value'] ) ) : ?>
								<div class="awea-ci-icon" aria-hidden="true">
									<?php Icons_Manager::render_icon( $item['awea_ci_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</div>
							<?php endif; ?>

							<div class="awea-ci-body">
								<?php if ( ! empty( $label ) ) : ?>
									<span <?php $this->print_render_attribute_string( $label_setting_key ); ?>>
										<?php echo esc_html( $label ); ?>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $val ) ) : ?>
									<span <?php $this->print_render_attribute_string( $value_setting_key ); ?>>
										<?php echo esc_html( $val ); ?>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $subtext ) ) : ?>
									<span <?php $this->print_render_attribute_string( $subtext_setting_key ); ?>>
										<?php echo esc_html( $subtext ); ?>
									</span>
								<?php endif; ?>
							</div>

							<?php if ( ( $can_copy && ! empty( $val ) ) || ( $show_arrow && $has_url ) ) : ?>
								<div class="awea-ci-actions">
									<?php if ( $can_copy && ! empty( $val ) ) : ?>
										<button type="button" class="awea-ci-copy-btn" aria-label="<?php esc_attr_e( 'Copy to clipboard', 'awesome-widgets-elementor' ); ?>">
											<svg class="awea-ci-ico-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
											<svg class="awea-ci-ico-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
											<span class="awea-ci-copy-label" aria-live="polite"><?php echo esc_html( $copied_text ); ?></span>
										</button>
									<?php endif; ?>

									<?php if ( $show_arrow && $has_url ) : ?>
										<span class="awea-ci-arrow" aria-hidden="true">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
												<line x1="7" y1="17" x2="17" y2="7"></line>
												<polyline points="7 7 17 7 17 17"></polyline>
											</svg>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function copyToClipboard(text, callback) {
				if (navigator.clipboard && window.isSecureContext) {
					navigator.clipboard.writeText(text).then(callback).catch(function() {
						fallbackCopy(text, callback);
					});
				} else {
					fallbackCopy(text, callback);
				}
			}

			function fallbackCopy(text, callback) {
				var textarea = document.createElement('textarea');
				textarea.value = text;
				textarea.style.position = 'fixed';
				textarea.style.opacity = '0';
				document.body.appendChild(textarea);
				textarea.focus();
				textarea.select();
				try {
					document.execCommand('copy');
					if (callback) callback();
				} catch (err) {}
				document.body.removeChild(textarea);
			}

			function initContactInfo() {
				var scope = document.getElementById('awea-ci-<?php echo esc_js( $widget_id ); ?>');
				if (!scope || scope.dataset.aweaBound === '1') return;
				scope.dataset.aweaBound = '1';

				function triggerCopy(row) {
					var text = row.getAttribute('data-copy-text');
					if (!text) return;
					copyToClipboard(text, function() {
						row.classList.add('is-copied');
						clearTimeout(row.__copyTimer);
						row.__copyTimer = setTimeout(function() {
							row.classList.remove('is-copied');
						}, 1800);
					});
				}

				scope.querySelectorAll('.awea-ci-copy-btn').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						var row = this.closest('.awea-ci-row');
						if (row) triggerCopy(row);
					});
				});

				scope.querySelectorAll('.awea-ci-row-copy').forEach(function(row) {
					row.addEventListener('click', function() {
						triggerCopy(this);
					});
					row.addEventListener('keydown', function(e) {
						if (e.key === 'Enter' || e.key === ' ') {
							e.preventDefault();
							triggerCopy(this);
						}
					});
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initContactInfo);
			} else {
				initContactInfo();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea-contact-info.default', initContactInfo);
			}
		})();
		</script>
		<?php
	}
}